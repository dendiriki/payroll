@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h3>Edit Payroll</h3>

    <div class="card shadow">
        <div class="card-body">
            <form action="{{ route('payroll.update', $payroll->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label">Nama Karyawan</label>
                    <input type="text" class="form-control" value="{{ $payroll->karyawan->nama_lengkap }}" disabled>
                </div>

                <div class="mb-3">
                    <label for="periode" class="form-label">Periode</label>
                    <input type="month" name="periode" class="form-control" value="{{ $payroll->periode->format('Y-m') }}" required>
                </div>

                <p class="text-muted">Lembur & NWNP akan dihitung otomatis dari data presensi.</p>

                <button type="submit" class="btn btn-primary">Update</button>
                <a href="{{ route('payroll.index') }}" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </div>
</div>
@endsection
