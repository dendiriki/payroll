@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h3>Detail Karyawan</h3>

    <div class="card">
        <div class="card-body">
            <p><strong>Nama:</strong> {{ $karyawan->nama_lengkap }}</p>
            <p><strong>Email (user):</strong> {{ optional($karyawan->user)->email ?? '-' }}</p>
            <p><strong>Tempat, Tgl Lahir:</strong> {{ $karyawan->tempat_lahir ?? '-' }}, {{ $karyawan->tanggal_lahir ?? '-' }}</p>
            <p><strong>Jenis Kelamin:</strong> {{ $karyawan->jenis_kelamin ?? '-' }}</p>
            <p><strong>Jabatan:</strong> {{ $karyawan->jabatan ?? '-' }}</p>
            <p><strong>Status:</strong> {{ $karyawan->status }}</p>
            <p><strong>Gaji Pokok:</strong> Rp {{ number_format($karyawan->gaji_pokok,0,',','.') }}</p>
            <p><strong>Tunjangan:</strong> Rp {{ number_format($karyawan->tunjangan ?? 0,0,',','.') }}</p>
            <p><strong>BPJS:</strong> {{ $karyawan->bpjs ? 'Ya' : 'Tidak' }}</p>
        </div>
    </div>

    <a href="{{ route('karyawan.index') }}" class="btn btn-secondary mt-3">Kembali</a>
</div>
@endsection
