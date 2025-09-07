@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h3>Buat Payroll Baru</h3>

    <div class="card shadow">
        <div class="card-body">
            <form action="{{ route('payroll.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="karyawan_id" class="form-label">Karyawan</label>
                    <select name="karyawan_id" class="form-select" required>
                        <option value="">-- Pilih Karyawan --</option>
                        @foreach($karyawan as $k)
                            <option value="{{ $k->id }}">{{ $k->nama_lengkap }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="periode" class="form-label">Periode</label>
                    <input type="month" name="periode" class="form-control" required>
                </div>

                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('payroll.index') }}" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </div>
</div>
@endsection
