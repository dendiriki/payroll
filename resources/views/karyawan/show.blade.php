@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h3 class="mb-4">Detail Karyawan</h3>

    <div class="card shadow-sm">
        <div class="card-body">
            <table class="table table-bordered mb-0">
                <tr>
                    <th width="200">Nama Lengkap</th>
                    <td>{{ $karyawan->nama_lengkap }}</td>
                </tr>
                <tr>
                    <th>Email (User)</th>
                    <td>{{ optional($karyawan->user)->email ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Tempat, Tanggal Lahir</th>
                    <td>
                        {{ $karyawan->tempat_lahir ?? '-' }},
                        {{ $karyawan->tanggal_lahir ? $karyawan->tanggal_lahir->format('d-m-Y') : '-' }}
                    </td>
                </tr>
                <tr>
                    <th>Jenis Kelamin</th>
                    <td>
                        @if($karyawan->jenis_kelamin == 'L')
                            Laki-laki
                        @elseif($karyawan->jenis_kelamin == 'P')
                            Perempuan
                        @else
                            -
                        @endif
                    </td>
                </tr>
                <tr>
                    <th>Jabatan</th>
                    <td>{{ $karyawan->jabatan ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Status</th>
                    <td>{{ $karyawan->status }}</td>
                </tr>
                <tr>
                    <th>Tanggal Bergabung</th>
                    <td>{{ $karyawan->join_date ? $karyawan->join_date->format('d-m-Y') : '-' }}</td>
                </tr>
                <tr>
                    <th>Gaji Pokok</th>
                    <td>Rp {{ number_format($karyawan->gaji_pokok,0,',','.') }}</td>
                </tr>
                <tr>
                    <th>Tunjangan</th>
                    <td>Rp {{ number_format($karyawan->tunjangan ?? 0,0,',','.') }}</td>
                </tr>
                <tr>
                    <th>BPJS</th>
                    <td>
                        <span class="badge {{ $karyawan->bpjs ? 'bg-success' : 'bg-danger' }}">
                            {{ $karyawan->bpjs ? 'Ya' : 'Tidak' }}
                        </span>
                    </td>
                </tr>
            </table>
        </div>
    </div>

    <div class="mt-3">
        <a href="{{ route('karyawan.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
        <a href="{{ route('karyawan.edit', $karyawan->id) }}" class="btn btn-primary">
            <i class="bi bi-pencil"></i> Edit
        </a>
    </div>
</div>
@endsection
