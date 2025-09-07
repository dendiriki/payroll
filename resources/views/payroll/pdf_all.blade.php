<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Payroll PDF</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 12px;
            margin: 20px;
            position: relative;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .slip {
            page-break-after: always;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        .table th, .table td {
            border: 1px solid #000;
            padding: 6px;
            text-align: left;
        }

        .table th {
            background: #f2f2f2;
        }

        .rekap {
            margin-top: 30px;
        }

        /* Watermark */
        .watermark {
            position: fixed;
            top: 40%;
            left: 20%;
            width: 60%;
            text-align: center;
            opacity: 0.08;
            font-size: 70px;
            transform: rotate(-30deg);
            z-index: -1;
        }

        /* Footer copyright */
        .footer {
            position: fixed;
            bottom: 10px;
            left: 0;
            right: 0;
            text-align: center;
            font-size: 10px;
            color: #666;
        }
    </style>
</head>
<body>
    {{-- Watermark --}}
    <div class="watermark">Dendi Riki Rahmawan</div>

    <div class="header">
        <h2>Daftar Slip Gaji</h2>
    </div>

    @foreach($payrolls as $payroll)
        <div class="slip">
            <h3>Slip Gaji - {{ $payroll->employee->nama_lengkap }}</h3>
            <p>Periode: {{ $payroll->periode }}</p>

            <table>
                <tr>
                    <td><strong>Nama</strong></td>
                    <td>{{ $payroll->employee->nama_lengkap }}</td>
                </tr>
                <tr>
                    <td><strong>Status</strong></td>
                    <td>{{ $payroll->employee->status }}</td>
                </tr>
                <tr>
                    <td><strong>Periode</strong></td>
                    <td>{{ $payroll->periode }}</td>
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
                <tr>
                    <th><strong>Total Gaji</strong></th>
                    <td><strong>Rp {{ number_format($payroll->total_gaji,0,',','.') }}</strong></td>
                </tr>
            </table>
        </div>
    @endforeach

    {{-- Rekap Total --}}
    <div class="rekap">
        <h3>Rekapitulasi Total Gaji</h3>
        <table class="table">
            <tr>
                <th>Total yang harus dibayarkan</th>
                <td><strong>Rp {{ number_format($grandTotal,0,',','.') }}</strong></td>
            </tr>
        </table>
    </div>

    {{-- Footer --}}
    <div class="footer">
        &copy; {{ date('Y') }} Dendi Riki Rahmawan - Semua hak dilindungi
    </div>
</body>
</html>
