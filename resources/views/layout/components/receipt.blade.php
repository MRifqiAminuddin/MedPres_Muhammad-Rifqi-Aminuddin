<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Faktur Pembelian Obat</title>

    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 12px;
            color: #000;
        }

        .container {
            width: 100%;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .mb-10 {
            margin-bottom: 10px;
        }

        .mb-20 {
            margin-bottom: 20px;
        }

        .header {
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
        }

        .header h2 {
            margin: 0;
            font-size: 18px;
            font-weight: bold;
        }

        .header p {
            margin: 2px 0;
            font-size: 11px;
        }

        .title {
            margin: 20px 0;
            font-size: 16px;
            font-weight: bold;
            text-transform: uppercase;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table th,
        table td {
            border: 1px solid #000;
            padding: 6px;
            font-size: 11px;
        }

        table th {
            background: #f2f2f2;
            font-weight: bold;
        }

        .no-border td {
            border: none;
            padding: 3px 0;
        }

        .total-table td {
            border: none;
            padding: 4px;
            font-size: 12px;
        }

        .signature {
            margin-top: 40px;
        }

        .signature div {
            width: 40%;
            text-align: center;
            float: right;
        }

        .clear {
            clear: both;
        }
    </style>
</head>

<body>
<div class="container">

    <!-- HEADER -->
    <div class="header text-center mb-20">
        <h2>RS DELTA SURYA</h2>
        <p>Jl. Raya Sidoarjo No. XX, Jawa Timur</p>
        <p>Telp: (031) 123456 • Email: info@rsdeltasurya.id</p>
    </div>

    <!-- TITLE -->
    <div class="title text-center">
        Faktur Pembelian Obat
    </div>

    <!-- INFO TRANSAKSI -->
    <table class="no-border mb-20">
        <tr>
            <td width="20%">No. Faktur</td>
            <td width="30%">: {{ $invoice_number }}</td>
            <td width="20%">Tanggal</td>
            <td width="30%">: {{ $invoice_date }}</td>
        </tr>
        <tr>
            <td>Nama Pasien</td>
            <td>: {{ $patient_name }}</td>
            <td>Umur</td>
            <td>: {{ $patient_age }} Tahun</td>
        </tr>
    </table>

    <!-- TABEL OBAT -->
    <table class="mb-20">
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="30%">Nama Obat</th>
                <th width="10%">Qty</th>
                <th width="20%">Aturan Pakai</th>
                <th width="15%">Harga</th>
                <th width="20%">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($medicines as $index => $medicine)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td>{{ $medicine->name }}</td>
                <td class="text-center">{{ $medicine->qty }}</td>
                <td>{{ $medicine->rule }} / {{ $medicine->dosage }}</td>
                <td class="text-right">Rp {{ number_format($medicine->price, 0, ',', '.') }}</td>
                <td class="text-right">Rp {{ number_format($medicine->subtotal, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- TOTAL -->
    <table class="total-table">
        <tr>
            <td width="70%" class="text-right"><strong>Total</strong></td>
            <td width="30%" class="text-right">
                <strong>Rp {{ number_format($total_price, 0, ',', '.') }}</strong>
            </td>
        </tr>
    </table>

    <!-- SIGNATURE -->
    <div class="signature">
        <div>
            <p>Sidoarjo, {{ $invoice_date }}</p>
            <p>Petugas Apotek</p>
            <br><br><br>
            <p><strong>{{ $pharmacist_name }}</strong></p>
        </div>
        <div class="clear"></div>
    </div>

</div>
</body>
</html>
