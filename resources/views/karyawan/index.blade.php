@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Daftar Karyawan</h3>
        <a href="{{ route('karyawan.create') }}" class="btn btn-primary">+ Tambah Karyawan</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-hover table-bordered">
        <thead class="table-dark">
            <tr>
                <th>Nama</th>
                <th>Email (user)</th>
                <th>Jabatan</th>
                <th>Status</th>
                <th>Gaji Pokok</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($karyawans as $k)
            <tr>
                <td>{{ $k->nama_lengkap }}</td>
                <td>{{ optional($k->user)->email ?? '-' }}</td>
                <td>{{ $k->jabatan ?? '-' }}</td>
                <td>{{ $k->status }}</td>
                <td>Rp {{ number_format($k->gaji_pokok,0,',','.') }}</td>
                <td>
                    <a href="{{ route('karyawan.show', $k->id) }}" class="btn btn-info btn-sm">Detail</a>
                    <a href="{{ route('karyawan.edit', $k->id) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('karyawan.destroy', $k->id) }}" method="POST" style="display:inline-block;">
                        @csrf @method('DELETE')
                        <button class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus?')">Hapus</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="6" class="text-center">Belum ada data karyawan</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
