<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Order Success - Powerhaul</title>
    <style>
        body { font-family: 'Segoe UI', Arial, sans-serif; background: #f5f5f5; margin: 0; padding: 0; }
        .navbar { width: 100%; background: #fff; padding: 15px 25px; color: #000; font-size: 22px; font-weight: bold; text-align: center; box-shadow: 0 2px 4px rgba(0,0,0,0.1); text-transform: uppercase; }
        .container { background: #fff; padding: 40px; max-width: 700px; margin: 40px auto; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.05); }
        h2 { color: #2d3436; margin-bottom: 25px; font-size: 24px; font-weight: bold; }
        .section-title { font-weight: bold; margin-top: 30px; text-transform: none; font-size: 18px; color: #000; }
        .line { border-bottom: 1px solid #eee; margin: 15px 0; }
        .info-table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        .info-table td { padding: 5px 0; font-size: 15px; }
        .label { color: #636e72; width: 180px; }
        .value { font-weight: 400; color: #000; }
        .order-table { width: 100%; margin-top: 10px; }
        .order-table th { text-align: left; padding-bottom: 10px; font-size: 16px; }
        .order-table td { padding: 10px 0; }
        .price-row { display: flex; justify-content: space-between; padding: 5px 0; }
        .price-label { color: #636e72; }
        .address-box { line-height: 1.6; color: #000; margin-top: 10px; }
        .back-link { display: inline-block; margin-top: 30px; text-decoration: none; color: #000; font-size: 14px; }
    </style>
</head>
<body>

<div class="navbar">POWER HAUL</div>

<div class="container">
    <h2>Thank you. Your order has been received.</h2>

    {{-- Header Info Summary --}}
    <table class="info-table">
        <tr>
            <td class="label">Order number:</td>
            <td class="value">{{ $order->id_invoice }}</td>
        </tr>
        <tr>
            <td class="label">Date:</td>
            <td class="value">{{ \Carbon\Carbon::parse($order->created_at)->format('F d, Y') }}</td>
        </tr>
        <tr>
            <td class="label">Email:</td>
            <td class="value">{{ $order->email }}</td>
        </tr>
        <tr>
            <td class="label">Total:</td>
            <td class="value">Rp{{ number_format($order->total, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td class="label">Payment method:</td>
            <td class="value">
    {{ $order->pay_cash == 1 ? 'Cash Payment' : 'Online Payment' }}
</td>
        </tr>
    </table>

    <div class="section-title">Booking Details</div>
    <div class="line"></div>
    <table class="info-table">
        <tr>
            <td class="label">Check In:</td>
            <td class="value">{{ \Carbon\Carbon::parse($order->pick_up)->format('F d, Y') }}</td>
        </tr>
        <tr>
            <td class="label">Check Out:</td>
            <td class="value">{{ \Carbon\Carbon::parse($order->return_date)->format('F d, Y') }}</td>
        </tr>
    </table>

    <div class="section-title">Order details</div>
    <div class="line"></div>
    <table class="order-table">
        <thead>
            <tr>
                <th>Product</th>
                <th style="text-align: right;"></th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ $order->nama_truk ?? 'Unit Alat Berat' }} <br> <span style="color: #636e72;">× {{ $order->qty }}</span></td>
                <td style="text-align: right;"></td>
            </tr>
        </tbody>
    </table>
    
    <div class="line"></div>
    
    <div class="price-row">
        <span class="price-label">Subtotal:</span>
        <span>Rp{{ number_format($order->total, 0, ',', '.') }}</span>
    </div>
    <div class="price-row">
        <span class="price-label">Payment method:</span>
        <span>
    {{ $order->pay_cash == 1 ? 'Cash Payment' : 'Online Payment' }}
</span>
    </div>
    <div class="price-row" style="font-weight: bold;">
        <span>Total:</span>
        <span>Rp{{ number_format($order->total, 0, ',', '.') }}</span>
    </div>

    <div class="section-title">Billing address</div>
    <div class="line"></div>
    <div class="address-box">
        <strong>Nama:</strong> {{ $order->fname }}<br>
        <strong>Alamat:</strong> {{ $order->streetaddress ?? 'Alamat tidak diisi' }}<br>
        <strong>Kota:</strong> {{ $order->city }}<br>
        <strong>Negara:</strong> {{ $order->country }}<br>
        <strong>Kode pos:</strong> {{ $order->kodepos }}
    </div>
    
    <a href="{{ route('dashboard') }}" class="back-link">← Back to Dashboard</a>
</div>
<script>
    // Fungsi ini akan berjalan otomatis setelah seluruh konten halaman (gambar, text, css) selesai dimuat
    window.onload = function() {
        window.print();
        
        // Opsional: Jika ingin otomatis kembali ke dashboard setelah cetak selesai/dibatalkan
        
    }
</script>
</body>
</html>