<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Struk Seafood 2000 - #{{ $order->id }}</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            color: #333;
            font-size: 12px;
            line-height: 1.4;
            margin: 0;
            padding: 10px;
        }
        .receipt-box {
            max-width: 400px;
            margin: auto;
            padding: 20px;
            border: 1px solid #eee;
            background: #fff;
        }
        .header {
            text-align: center;
            padding-bottom: 15px;
            border-bottom: 1px dashed #ddd;
            margin-bottom: 15px;
        }
        .header h2 {
            margin: 0;
            font-size: 20px;
            font-weight: bold;
            color: #111;
        }
        .header p {
            margin: 3px 0;
            font-size: 10px;
            color: #777;
        }
        .meta-table {
            width: 100%;
            margin-bottom: 15px;
            font-size: 11px;
        }
        .meta-table td {
            padding: 3px 0;
        }
        .meta-label {
            color: #777;
        }
        .meta-value {
            font-weight: bold;
            text-align: right;
        }
        .status-badge {
            background: #fcf8e3;
            border: 1px solid #fbeed5;
            color: #c09853;
            text-align: center;
            padding: 6px;
            font-weight: bold;
            font-size: 11px;
            text-transform: uppercase;
            margin-bottom: 15px;
            border-radius: 4px;
        }
        .status-selesai {
            background: #d9edf7;
            border: 1px solid #bce8f1;
            color: #3a87ad;
        }
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            margin-bottom: 15px;
        }
        .items-table th {
            border-bottom: 1px dashed #ddd;
            padding: 5px 0;
            text-align: left;
            font-size: 10px;
            color: #777;
            text-transform: uppercase;
        }
        .items-table td {
            padding: 7px 0;
            border-bottom: 1px solid #f9f9f9;
            vertical-align: top;
        }
        .item-name {
            font-weight: bold;
            color: #222;
        }
        .item-option {
            font-size: 9px;
            color: #0d9488;
            margin: 2px 0 0 0;
        }
        .item-qty {
            font-size: 10px;
            color: #888;
            margin-top: 2px;
        }
        .total-section {
            border-top: 1px dashed #ddd;
            padding-top: 10px;
            margin-bottom: 15px;
        }
        .total-row {
            width: 100%;
            font-size: 13px;
            font-weight: bold;
        }
        .total-val {
            text-align: right;
            font-size: 16px;
            color: #0d9488;
        }
        .payment-info {
            background: #f9f9f9;
            border-radius: 6px;
            padding: 10px;
            font-size: 10px;
            color: #555;
            border: 1px solid #f0f0f0;
        }
        .payment-info table {
            width: 100%;
        }
        .payment-info td {
            padding: 2px 0;
        }
        .footer-note {
            text-align: center;
            font-size: 10px;
            color: #999;
            margin-top: 25px;
            border-top: 1px solid #eee;
            padding-top: 10px;
        }
    </style>
</head>
<body>

<div class="receipt-box">
    
    <!-- Header -->
    <div class="header">
        <h2>SEAFOOD 2000</h2>
        <p>Jl. Ringroad - Medan</p>
        <p>HP: 0858 3370 9981</p>
    </div>

    <!-- Metadata -->
    <table class="meta-table">
        <tr>
            <td class="meta-label">ID Pesanan:</td>
            <td class="meta-value">#{{ $order->id }}</td>
        </tr>
        <tr>
            <td class="meta-label">Waktu Pesan:</td>
            <td class="meta-value">{{ $order->created_at->setTimezone('Asia/Jakarta')->format('d/m/Y H:i') }} WIB</td>
        </tr>
        <tr>
            <td class="meta-label">Nama Pemesan:</td>
            <td class="meta-value">{{ $order->customer_name }}</td>
        </tr>
        <tr>
            <td class="meta-label">Meja:</td>
            <td class="meta-value">{{ $order->table_number ?? 'Bungkus / Takeaway' }}</td>
        </tr>
    </table>

    <!-- Status -->
    <div class="status-badge {{ $order->status === 'selesai' ? 'status-selesai' : '' }}">
        Status: {{ $order->status }}
    </div>

    <!-- Items -->
    <table class="items-table">
        <thead>
            <tr>
                <th style="width: 70%;">Menu</th>
                <th style="width: 30%; text-align: right;">Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order->items as $item)
                <tr>
                    <td>
                        <div class="item-name">{{ $item->menu->name }}</div>
                        @if($item->cooking_option)
                            <div class="item-option">Masakan: {{ $item->cooking_option }}</div>
                        @endif
                        <div class="item-qty">{{ $item->quantity }} x Rp {{ number_format($item->price, 0, ',', '.') }}</div>
                    </td>
                    <td style="text-align: right; font-weight: bold; color: #222;">
                        Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Pricing Summary -->
    <div class="total-section">
        <table class="total-row">
            <tr>
                <td>Total Tagihan:</td>
                <td class="total-val">Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
            </tr>
        </table>
    </div>

    <!-- Payment info -->
    <div class="payment-info">
        <table>
            <tr>
                <td style="color: #777;">Metode Pembayaran:</td>
                <td style="text-align: right; font-weight: bold; text-transform: uppercase;">{{ $order->payment_method }}</td>
            </tr>
            <tr>
                <td style="color: #777;">Status Pembayaran:</td>
                <td style="text-align: right; font-weight: bold; color: {{ $order->payment && $order->payment->status === 'paid' ? '#0d9488' : '#c09853' }}">
                    {{ $order->payment && $order->payment->status === 'paid' ? 'Lunas' : 'Menunggu Verifikasi' }}
                </td>
            </tr>
        </table>
    </div>

    <!-- Footer note -->
    <div class="footer-note">
        Terima kasih atas kunjungan Anda!<br>
        Seafood 2000 - Cita Rasa Terbaik Hidangan Laut
    </div>

</div>

</body>
</html>
