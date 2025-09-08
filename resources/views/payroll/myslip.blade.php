@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="card shadow-lg border-0">
        <div class="card-body">
            <h3 class="card-title mb-3">💰 Slip Gaji Saya</h3>
            <p class="text-muted">Daftar slip gaji Anda berdasarkan periode</p>

            @forelse($payrolls as $payroll)
                <div class="border rounded p-3 mb-3 shadow-sm">
                    <h5 class="mb-2">Periode: {{ $payroll->periode }}</h5>
                    <table class="table table-sm">
                        <tr>
                            <th>Gaji Pokok</th>
                            <td>Rp {{ number_format($payroll->gaji_pokok,0,',','.') }}</td>
                        </tr>
                        <tr>
                            <th>Tunjangan</th>
                            <td>Rp {{ number_format($payroll->tunjangan_tetap,0,',','.') }}</td>
                        </tr>
                        <tr>
                            <th>Insentif</th>
                            <td>Rp {{ number_format($payroll->insentif,0,',','.') }}</td>
                        </tr>
                        <tr>
                            <th>Lembur</th>
                            <td>Rp {{ number_format($payroll->lembur_upah,0,',','.') }}</td>
                        </tr>
                        <tr>
                            <th>Potongan NWNP</th>
                            <td>Rp {{ number_format($payroll->nwnp_potongan,0,',','.') }}</td>
                        </tr>
                        <tr>
                            <th>Potongan BPJS</th>
                            <td>Rp {{ number_format($payroll->bpjs_potongan,0,',','.') }}</td>
                        </tr>
                        <tr class="table-success">
                            <th>Total Gaji</th>
                            <td><strong>Rp {{ number_format($payroll->total_gaji,0,',','.') }}</strong></td>
                        </tr>
                    </table>

                    {{-- Tombol download PDF per slip --}}
                    <a href="{{ route('payroll.pdf', $payroll->id) }}" target="_blank"
                       class="btn btn-sm btn-outline-danger">
                        📄 Download PDF
                    </a>
                </div>
            @empty
                <div class="alert alert-warning">Belum ada slip gaji untuk Anda.</div>
            @endforelse
        </div>
    </div>
</div>
@endsection
