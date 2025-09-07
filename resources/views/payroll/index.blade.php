@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h3>Daftar Payroll</h3>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- Form Generate Payroll --}}
    <div class="mb-3">
        <form action="{{ route('payroll.generate') }}" method="POST" class="row g-2">
            @csrf
            <div class="col-auto">
                <input type="month" name="periode" class="form-control" value="{{ now()->format('Y-m') }}" required>
            </div>
            <div class="col-auto">
                <button type="submit" class="btn btn-primary">🔄 Generate Payroll</button>
            </div>
        </form>
        {{-- Tombol Cetak Semua --}}
    @if($payrolls->count() > 0)
        <form action="{{ route('payroll.pdfAll') }}" method="POST" target="_blank" class="d-inline">
            @csrf
            <button type="submit" class="btn btn-secondary">
                🖨 Cetak Semua PDF
            </button>
        </form>
    @endif
    </div>

    {{-- Tabel Payroll --}}
    <div class="card shadow-sm">
        <div class="card-body p-0">
            <table class="table table-striped table-hover mb-0">
                <thead class="table-dark">
                    <tr>
                        <th>No</th>
                        <th>Karyawan</th>
                        <th>Periode</th>
                        <th>Total Gaji</th>
                        <th>Status</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($payrolls as $key => $p)
                        <tr>
                            <td>{{ $payrolls->firstItem() + $key }}</td>
                            <td>{{ $p->employee->nama_lengkap }}</td>
                            <td>{{ $p->periode }}</td>
                            <td>Rp {{ number_format($p->total_gaji,0,',','.') }}</td>
                            <td>
                                @if($p->status === 'approved')
                                    <span class="badge bg-success">Approved</span>
                                @else
                                    <span class="badge bg-warning text-dark">Draft</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <a href="{{ route('payroll.show', $p->id) }}" class="btn btn-info btn-sm">Detail</a>

                                <form action="{{ route('payroll.destroy', $p->id) }}" method="POST" class="d-inline">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm"
                                        onclick="return confirm('Hapus payroll ini?')">Hapus</button>
                                </form>

                                @if(auth()->user()->role === 'supervisor' && $p->status === 'draft')
                                    <form action="{{ route('payroll.approve', $p->id) }}" method="POST" class="d-inline">
                                        @csrf @method('PUT')
                                        <button type="submit" class="btn btn-success btn-sm"
                                            onclick="return confirm('Setujui payroll ini?')">Approve</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">Belum ada data payroll</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-3">
        {{ $payrolls->links() }}
    </div>
</div>
@endsection
