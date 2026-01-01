<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Cetak Transaksi</title>
    <style>
        body {
            font-family: "Times New Roman", Times, serif;
            font-size: 12px;
            color: #000;
        }
        .container {
            width: 700px;
            margin: auto;
        }
        .text-center {
            text-align: center;
        }
        .header h3 {
            margin: 0;
        }
        .header p {
            margin: 2px 0;
        }
        hr {
            border: 1px solid #000;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        table th, table td {
            border: 1px solid #000;
            padding: 6px;
        }
        table th {
            text-align: center;
        }
        .no-border td {
            border: none;
            padding: 4px 0;
        }
        .text-right {
            text-align: right;
        }
        .footer {
            margin-top: 40px;
        }

        @media print {
            body {
                margin: 0;
            }
        }
    </style>
</head>
<body onload="window.print()"> {{-- Ini yang membuat otomatis menawarkan print --}}

<div class="container">
    <div class="header text-center">
        <h3>PT. MITRA MANDIRI TRANSINDO</h3>
        <p>Ruko Baruna No. 4 Tanah Mas Semarang</p>
        <br>
        <strong>LAPORAN PERHITUNGAN SEWA</strong>
    </div>

    <hr>

    {{-- INFO TRANSAKSI --}}
    <table class="no-border">
        <tr>
            <td width="120">No Transaksi</td>
            <td width="10">:</td>
            <td>{{ $invoice->id_detail }}</td> {{-- Variabel sudah sinkron --}}
        </tr>
        <tr>
            <td>Customer</td>
            <td>:</td>
            <td>{{ $invoice->nama_pelanggan }}</td>
        </tr>
    </table>

    {{-- TABEL DETAIL --}}
    <table>
        <thead>
            <tr>
                <th width="40">No</th>
                <th>Nama Alat Berat</th>
                <th width="80">Jumlah</th>
                <th width="120">Sub Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($rincian as $i => $item)
                <tr>
                    <td class="text-center">{{ $i + 1 }}</td>
                    <td>{{ $item->nama_truk }}</td>
                    <td class="text-center">{{ $item->banyaknya }}</td>
                    <td class="text-right">Rp {{ number_format($item->jumlah, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{-- TOTAL --}}
    <table class="no-border" style="margin-top:10px;">
    <tr>
        <td width="150"><strong>Total Tagihan</strong></td>
        <td width="20">:</td>
        <td>
            <strong>
                {{-- MENGHITUNG TOTAL LANGSUNG DARI DAFTAR ITEM DI ATAS --}}
                Rp {{ number_format($rincian->sum('jumlah'), 0, ',', '.') }}
            </strong>
        </td>
    </tr>
</table>

    <div class="footer">
        <p>Semarang, {{ \Carbon\Carbon::parse($invoice->pick_up)->format('d-m-Y') }}</p>
        <br><br>
        <p>( _______________________ )<br>
        <strong>Admin / Finance</strong></p>
    </div>
</div>

</body>
</html>
