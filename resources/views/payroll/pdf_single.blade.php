<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Slip Gaji</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        .header { text-align: center; margin-bottom: 20px; }
        .table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        .table th, .table td { border: 1px solid #000; padding: 6px; text-align: left; }
        .table th { background: #f2f2f2; }
    </style>
</head>
<body>
    <div class="header">
        <h2>Slip Gaji</h2>
        <p>Periode: {{ $payroll->periode }}</p>
    </div>

    <table>
        <tr>
            <td><strong>Nama</strong></td>
            <td>{{ $payroll->employee->nama_lengkap }}</td>
        </tr>
        <tr>
            <td><strong>Status</strong></td>
            <td>{{ $payroll->employee->status }}</td>
        </tr>
    </table>

    <h4>Rincian Gaji</h4>
    <table class="table">
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
</body>
</html>
