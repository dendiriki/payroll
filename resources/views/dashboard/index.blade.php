{{-- resources/views/dashboard/index.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="card shadow-lg border-0">
        <div class="card-body">
            <h3 class="card-title mb-3">Selamat datang, {{ $user->name }} 👋</h3>
            <p class="card-text">
                Anda login sebagai <span class="badge bg-info text-dark">{{ ucfirst($user->role) }}</span>
            </p>

            @if($user->role === 'admin' || $user->role === 'supervisor'|| $user->role === 'staff')
                <div class="alert alert-primary mt-3">
                    <h5 class="mb-3">📌 Menu Supervisor/Admin Payroll</h5>
                    <div class="row g-3">
                     <div class="col-md-4">
                            <a href="{{ route('karyawan.index') }}" class="btn btn-outline-primary w-100 py-3 shadow-sm">
                                👥 Kelola Karyawan
                            </a>
                        </div>
                        <div class="col-md-4">
                            <a href="{{ route('payroll.index') }}" class="btn btn-outline-success w-100 py-3 shadow-sm">
                                📊 Laporan Payroll
                            </a>
                        </div>
                        <div class="col-md-4">
                            <a href="#" class="btn btn-outline-secondary w-100 py-3 shadow-sm">
                                ⚙️ Pengaturan Sistem
                            </a>
                        </div>
                    </div>
                </div>
            @elseif($user->role === 'karyawan')
                <div class="alert alert-success mt-3">
                    <h5 class="mb-3">📌 Menu Karyawan</h5>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <a href="#" class="btn btn-outline-success w-100 py-3 shadow-sm">
                                💰 Lihat Slip Gaji
                            </a>
                        </div>
                        <div class="col-md-6">
                            <a href="#" class="btn btn-outline-warning w-100 py-3 shadow-sm">
                                ✏️ Update Data Pribadi
                            </a>
                        </div>
                    </div>
                </div>
            @else
                <div class="alert alert-warning mt-3">
                    <h5>Menu Tidak Dikenal</h5>
                    <p>Silakan hubungi admin sistem untuk pengecekan role Anda.</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
