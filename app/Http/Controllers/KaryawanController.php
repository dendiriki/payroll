<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\User;


class KaryawanController extends Controller
{
// Menampilkan daftar karyawan
     // Tampilkan daftar employee
    public function index()
    {
        // ambil dengan relasi user supaya bisa tampilkan email/name dari users (jika ada)
        $karyawans = Employee::with('user')->orderBy('nama_lengkap')->get();
        return view('karyawan.index', compact('karyawans'));
    }

    // Form tambah employee
    public function create()
    {
        // Ambil user yang berrole karyawan dan belum punya employee record
        $usedUserIds = Employee::whereNotNull('user_id')->pluck('user_id')->toArray();
        $users = User::where('role', 'karyawan')
                     ->whereNotIn('id', $usedUserIds)
                     ->get();

        return view('karyawan.create', compact('users'));
    }

    // Simpan employee baru
    public function store(Request $request)
    {
        $request->validate([
            'user_id'       => 'required|exists:users,id|unique:employees,user_id',
            'nama_lengkap'  => 'required|string|max:255',
            'tempat_lahir'  => 'nullable|string|max:255',
            'tanggal_lahir' => 'nullable|date',
            'jenis_kelamin' => 'nullable|in:L,P',
            'jabatan'       => 'nullable|string|max:255',
            'status'        => 'required|in:Tetap,Kontrak,HL',
            'gaji_pokok'    => 'required|numeric',
            'tunjangan'     => 'nullable|numeric',
            'bpjs'          => 'nullable|boolean',
        ]);

        Employee::create([
            'user_id'       => $request->user_id,
            'nama_lengkap'  => $request->nama_lengkap,
            'tempat_lahir'  => $request->tempat_lahir,
            'tanggal_lahir' => $request->tanggal_lahir,
            'jenis_kelamin' => $request->jenis_kelamin,
            'jabatan'       => $request->jabatan,
            'status'        => $request->status,
            'gaji_pokok'    => $request->gaji_pokok,
            'tunjangan'     => $request->tunjangan ?? 0,
            'bpjs'          => $request->has('bpjs') ? 1 : 0,
        ]);

        return redirect()->route('karyawan.index')->with('success', 'Karyawan berhasil ditambahkan.');
    }

    // Tampilkan detail employee
    public function show($id)
    {
        $karyawan = Employee::with('user')->findOrFail($id);
        return view('karyawan.show', compact('karyawan'));
    }

    // Form edit
    public function edit($id)
    {
        $karyawan = Employee::findOrFail($id);

        // Untuk pilihan user: semua karyawan + current user (agar seleksi tidak hilang)
        $usedUserIds = Employee::whereNotNull('user_id')->where('id', '!=', $id)->pluck('user_id')->toArray();
        $users = User::where('role', 'karyawan')
                     ->whereNotIn('id', $usedUserIds)
                     ->get();

        return view('karyawan.edit', compact('karyawan', 'users'));
    }

    // Update
    public function update(Request $request, $id)
    {
        $karyawan = Employee::findOrFail($id);

        $request->validate([
            'user_id' => 'required|exists:users,id|unique:employees,user_id,'.$id,
            'nama_lengkap'  => 'required|string|max:255',
            'tempat_lahir'  => 'nullable|string|max:255',
            'tanggal_lahir' => 'nullable|date',
            'jenis_kelamin' => 'nullable|in:L,P',
            'jabatan'       => 'nullable|string|max:255',
            'status'        => 'required|in:Tetap,Kontrak,HL',
            'gaji_pokok'    => 'required|numeric',
            'tunjangan'     => 'nullable|numeric',
            'bpjs'          => 'nullable|boolean',
        ]);

        $karyawan->update([
            'user_id'       => $request->user_id,
            'nama_lengkap'  => $request->nama_lengkap,
            'tempat_lahir'  => $request->tempat_lahir,
            'tanggal_lahir' => $request->tanggal_lahir,
            'jenis_kelamin' => $request->jenis_kelamin,
            'jabatan'       => $request->jabatan,
            'status'        => $request->status,
            'gaji_pokok'    => $request->gaji_pokok,
            'tunjangan'     => $request->tunjangan ?? 0,
            'bpjs'          => $request->has('bpjs') ? 1 : 0,
        ]);

        return redirect()->route('karyawan.index')->with('success', 'Data karyawan berhasil diperbarui.');
    }

    // Hapus
    public function destroy($id)
    {
        $karyawan = Employee::findOrFail($id);
        $karyawan->delete();

        return redirect()->route('karyawan.index')->with('success', 'Karyawan berhasil dihapus.');
    }
}
