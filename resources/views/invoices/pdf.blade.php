<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk Pembayaran - BENGKELPRO</title>
    <style>
        @page {
            margin: 0;
        }
        body {
            font-family: 'Courier New', Courier, monospace; /* Font khas struk */
            font-size: 12px;
            line-height: 1.4;
            color: #000;
            margin: 0;
            padding: 10px;
            width: 80mm; /* Standar printer thermal besar, sesuaikan ke 58mm jika perlu */
        }

        .header {
            text-align: center;
            margin-bottom: 15px;
            border-bottom: 1px dashed #000;
            padding-bottom: 10px;
        }

        .header h1 {
            font-size: 18px;
            margin: 0;
            text-transform: uppercase;
            letter-spacing: 2px;
        }

        .header p {
            margin: 2px 0;
            font-size: 10px;
        }

        .info-table {
            width: 100%;
            margin-bottom: 10px;
        }

        .info-table td {
            padding: 2px 0;
            vertical-align: top;
        }

        .label {
            width: 35%;
        }

        .separator {
            border-top: 1px dashed #000;
            margin: 10px 0;
        }

        .item-list {
            width: 100%;
            margin-bottom: 10px;
        }

        .item-list th {
            text-align: left;
            border-bottom: 1px solid #000;
            padding-bottom: 5px;
        }

        .total-section {
            width: 100%;
            margin-top: 5px;
        }

        .total-row td {
            padding: 2px 0;
        }

        .total-amount {
            font-weight: bold;
            font-size: 14px;
        }

        .footer {
            text-align: center;
            margin-top: 20px;
            font-size: 10px;
        }

        .status-badge {
            display: inline-block;
            border: 1px solid #000;
            padding: 2px 5px;
            font-weight: bold;
            margin-top: 5px;
        }

        /* Utility */
        .text-right { text-align: right; }
        .bold { font-weight: bold; }
    </style>
</head>
<body>

    <div class="header">
        <h1>BENGKELPRO</h1>
        <p>Jl. Workshop No. 123, Indonesia</p>
        <p>Telp: 0812-3456-7890</p>
        <p>--------------------------------</p>
        <p class="bold">STRUK PEMBAYARAN</p>
    </div>

    <table class="info-table">
        <tr>
            <td class="label">No. Antrian</td>
            <td>: <span class="bold">{{ $invoice->queue_number }}</span></td>
        </tr>
        <tr>
            <td class="label">Tgl/Waktu</td>
            <td>: {{ $invoice->created_at->format('d/m/Y H:i') }}</td>
        </tr>
        <tr>
            <td class="label">Customer</td>
            <td>: {{ $invoice->customer_name }}</td>
        </tr>
        <tr>
            <td class="label">Kendaraan</td>
            <td>: {{ $invoice->vehicle_name }}</td>
        </tr>
    </table>

    <div class="separator"></div>

    <table class="item-list">
        <thead>
            <tr>
                <th>Deskripsi Service</th>
                <th class="text-right">Harga</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ $invoice->service->name ?? 'Service Umum' }}</td>
                <td class="text-right">Rp {{ number_format($invoice->total_price) }}</td>
            </tr>
        </tbody>
    </table>

    <div class="separator"></div>

    <table class="total-section">
        <tr>
            <td class="label">Mekanik</td>
            <td class="text-right">{{ $invoice->mechanic->name ?? '-' }}</td>
        </tr>
        <tr class="total-row">
            <td class="bold">TOTAL</td>
            <td class="text-right total-amount bold">Rp {{ number_format($invoice->total_price) }}</td>
        </tr>
    </table>

    <div class="separator"></div>

    <div class="footer">
        <div class="status-badge">LUNAS</div>
        <p style="margin-top: 10px;">Terima kasih atas kepercayaan Anda.</p>
        <p>Periksa kembali kendaraan Anda sebelum meninggalkan bengkel.</p>
        <p>*** BENGKELPRO - Solusi Otomotif ***</p>
    </div>

</body>
</html>