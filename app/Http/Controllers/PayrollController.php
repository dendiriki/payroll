<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payroll;
use App\Models\Employee;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;


class PayrollController extends Controller
{
    /**
     * Ambil data presensi dari JSON (simulasi API).
     */
  private function getPresensiData($karyawan_id, $periode, $upahPerJam)
    {
        $data = json_decode(Storage::disk('public')->get('presensi.json'), true);

        $karyawan = collect($data)->first(function ($item) use ($karyawan_id, $periode) {
            return $item['karyawan_id'] == $karyawan_id && $item['periode'] == $periode;
        });

        if (!$karyawan) {
            return ['total_lembur_jam' => 0, 'total_lembur_upah' => 0, 'nwnp_hari' => 0];
        }

        $presensi = collect($karyawan['presensi'])->keyBy('tanggal');

        $periodeDate = Carbon::createFromFormat('Y-m', $periode);
        $start = $periodeDate->copy()->startOfMonth();
        $end   = $periodeDate->copy()->endOfMonth();

        $nwnp = 0;
        $totalJam = 0;
        $totalUpah = 0;

        for ($date = $start; $date->lte($end); $date->addDay()) {
            $hariKe = $date->dayOfWeekIso; // 1=Senin, 7=Minggu
            if (in_array($hariKe, [6,7])) continue;

            $record = $presensi->get($date->format('Y-m-d'));

            if (!$record || empty($record['jam_masuk'])) {
                $nwnp++;
            } else {
                if (!empty($record['jam_keluar'])) {
                    $jamKeluar = Carbon::parse($date->format('Y-m-d') . ' ' . $record['jam_keluar']);
                    $jamNormal = Carbon::parse($date->format('Y-m-d') . ' 17:00');

                    if ($jamKeluar->gt($jamNormal)) {
                        $jamLemburHari = $jamNormal->diffInHours($jamKeluar);
                        $totalJam += $jamLemburHari;

                        // hitung lembur per hari
                        $jamNormalRate = min($jamLemburHari, 4);
                        $jamDoubleRate = max($jamLemburHari - 4, 0);

                        $totalUpah += ($jamNormalRate * $upahPerJam) + ($jamDoubleRate * $upahPerJam * 2);
                    }
                }
            }
        }

        return [
            'total_lembur_jam'  => $totalJam,
            'total_lembur_upah' => $totalUpah,
            'nwnp_hari'         => $nwnp,
        ];
    }

    public function index()
    {
        $payrolls = Payroll::with('employee')->orderBy('periode', 'desc')->paginate(15);
        return view('payroll.index', compact('payrolls'));
    }

    /**
     * Generate payroll otomatis dari API JSON
     */
    public function generate(Request $request)
    {
        $request->validate([
            'periode' => 'required|date_format:Y-m',
        ]);

        $periode = $request->periode;

        // Ambil data JSON
        $data = json_decode(Storage::disk('public')->get('presensi.json'), true);

        // Ambil hanya ID karyawan yang ada di JSON sesuai periode
        $employeeIds = collect($data)
            ->where('periode', $periode)
            ->pluck('karyawan_id')
            ->unique();

        // Ambil data karyawan dari database sesuai JSON
        $employees = Employee::whereIn('id', $employeeIds)->get();

        foreach ($employees as $employee) {
            // tentukan upah per jam dulu
            if (in_array($employee->status, ['Tetap','Kontrak'])) {
                $upahPerJam = ($employee->gaji_pokok + ($employee->tunjangan ?? 0)) / 173;
            } else {
                $upahPerJam = $employee->gaji_pokok / 200;
            }

            // ambil data presensi + lembur (sudah per tanggal)
            $presensi = $this->getPresensiData($employee->id, $periode, $upahPerJam);

            $lemburJam  = $presensi['total_lembur_jam'];
            $lemburUpah = $presensi['total_lembur_upah'];
            $nwnpHari   = $presensi['nwnp_hari'];

            $gaji_pokok = (float) $employee->gaji_pokok;
            $tunjangan_tetap = (float) ($employee->tunjangan ?? 0);

            // ======================
            // Hitung insentif
            // ======================
            $insentif = 0;
            $years = null;
            if ($employee->status === 'Tetap' && $employee->join_date) {
                $periodeDate = Carbon::createFromFormat('Y-m', $periode)->endOfMonth();

                // hitung selisih real year lalu bulatkan ke bawah
                $realYears = Carbon::parse($employee->join_date)->diffInRealYears($periodeDate);
                $years = floor($realYears); // hanya tahun penuh yang dihitung

                // logika insentif
                if ($years < 1) {
                    $insentif = 1_000_000;
                } else {
                    $insentif = 1_100_000 + (($years - 1) * 100_000);
                }
            }

            // Potongan
            $nwnpPotongan = $nwnpHari * ($gaji_pokok / 30);
            $bpjsPotongan = $employee->bpjs ? (($gaji_pokok + $tunjangan_tetap) * 0.03) : 0;

            // Total
            $total = $gaji_pokok + $tunjangan_tetap + $insentif + $lemburUpah - $nwnpPotongan - $bpjsPotongan;

            // Debug dulu biar yakin
            // dd([
            //     'id'       => $employee->id,
            //     'realYears'=> $realYears, // 4.66 dst
            //     'years'    => $years,     // hasil floor, jadi 4
            //     'insentif' => $insentif,  // 1.400.000 untuk 4 tahun
            //     'join'     => $employee->join_date,
            //     'periode'  => $periode
            // ]);

            // Simpan payroll
            Payroll::updateOrCreate(
                [
                    'employee_id' => $employee->id,
                    'periode'     => $periode,
                ],
                [
                    'gaji_pokok'      => $gaji_pokok,
                    'tunjangan_tetap' => $tunjangan_tetap,
                    'insentif'        => $insentif,
                    'lembur_jam'      => $lemburJam,
                    'lembur_upah'     => round($lemburUpah, 2),
                    'nwnp_potongan'   => round($nwnpPotongan, 2),
                    'bpjs_potongan'   => round($bpjsPotongan, 2),
                    'total_gaji'      => round($total, 2),
                    'status'          => 'draft',
                ]
            );
        }

        return redirect()->route('payroll.index')->with('success', "Payroll periode $periode berhasil digenerate.");
    }



    /**
     * Detail payroll
     */
    public function show($id)
    {
        $payroll = Payroll::with('employee')->findOrFail($id);
        return view('payroll.show', compact('payroll'));
    }

    /**
     * Hapus payroll
     */
    public function destroy($id)
    {
        $payroll = Payroll::findOrFail($id);
        $payroll->delete();
        return redirect()->route('payroll.index')->with('success', 'Payroll berhasil dihapus.');
    }

    /**
     * Approve payroll (khusus supervisor)
     */
    public function approve($id)
    {
        $user = Auth::user();
        if (! $user || $user->role !== 'supervisor') {
            abort(403, 'Unauthorized - hanya supervisor yang dapat melakukan approve');
        }

        $payroll = Payroll::findOrFail($id);
        $payroll->update(['status' => 'approved']);
        return redirect()->route('payroll.index')->with('success', 'Payroll disetujui.');
    }

    public function pdfAll()
    {
        // ambil semua payroll terbaru
        $payrolls = Payroll::with('employee')
            ->orderBy('periode', 'desc')
            ->get();

        if ($payrolls->isEmpty()) {
            return redirect()->route('payroll.index')
                ->with('error', 'Tidak ada data payroll untuk dicetak.');
        }

        // hitung total semua gaji
        $grandTotal = $payrolls->sum('total_gaji');

        $pdf = Pdf::loadView('payroll.pdf_all', compact('payrolls', 'grandTotal'))
            ->setPaper('A4', 'portrait');

        return $pdf->stream("Payroll-All.pdf");
    }

}
