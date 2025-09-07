@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h3>Detail Payroll</h3>

    <div class="card shadow-sm">
        <div class="card-body">
            <p><strong>Nama:</strong> {{ $payroll->employee->nama_lengkap }}</p>
            <p><strong>Periode:</strong> {{ $payroll->periode }}</p>
            <p><strong>Gaji Pokok:</strong> Rp {{ number_format($payroll->gaji_pokok,0,',','.') }}</p>
            <p><strong>Tunjangan Tetap:</strong> Rp {{ number_format($payroll->tunjangan_tetap,0,',','.') }}</p>
            <p><strong>Insentif:</strong> Rp {{ number_format($payroll->insentif,0,',','.') }}</p>
            <p><strong>Lembur Jam:</strong> {{ $payroll->lembur_jam }} jam</p>
            <p><strong>Upah Lembur:</strong> Rp {{ number_format($payroll->lembur_upah,0,',','.') }}</p>
            <p><strong>Potongan NWNP:</strong> Rp {{ number_format($payroll->nwnp_potongan,0,',','.') }}</p>
            <p><strong>Potongan BPJS:</strong> Rp {{ number_format($payroll->bpjs_potongan,0,',','.') }}</p>
            <h5><strong>Total Gaji:</strong> Rp {{ number_format($payroll->total_gaji,0,',','.') }}</h5>
            <p><strong>Status:</strong> 
                @if($payroll->status === 'approved')
                    <span class="badge bg-success">Approved</span>
                @else
                    <span class="badge bg-warning text-dark">Draft</span>
                @endif
            </p>
        </div>
    </div>

    <div class="mt-3">
        <a href="{{ route('payroll.index') }}" class="btn btn-secondary">Kembali</a>
        @if(auth()->user()->role === 'supervisor' && $payroll->status === 'draft')
            <form action="{{ route('payroll.approve', $payroll->id) }}" method="POST" class="d-inline">
                @csrf @method('PUT')
                <button type="submit" class="btn btn-success">Approve</button>
            </form>
        @endif
    </div>
</div>
@endsection
