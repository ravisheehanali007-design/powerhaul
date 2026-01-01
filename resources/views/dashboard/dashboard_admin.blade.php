<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - PowerHaul</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        body { background-color: #f8f9fc; font-family: Arial, sans-serif; }
        .sidebar { width: 250px; height: 100vh; background: #343a40; color: #fff; position: fixed; padding-top: 20px; }
        .sidebar-brand { font-size: 20px; font-weight: 600; padding-left: 20px; margin-bottom: 25px; }
        .sidebar-section-title { font-size: 11px; padding-left: 20px; color: #a4a4a4; letter-spacing: 1px; margin-bottom: 10px; }
        .sidebar a { display: block; padding: 10px 20px; color: #cfcfcf; text-decoration: none; }
        .sidebar a:hover { background: #495057; color: #fff; }
        .topnav { margin-left: 250px; height: 60px; background: #1f1f1f; display: flex; align-items: center; padding: 0 20px; }
        .content { margin-left: 250px; padding: 30px; }
        .card-footer { background: transparent; }
    </style>
</head>
<body>

<div class="sidebar">
    <div class="sidebar-brand">PowerHaulTrucks</div>
    <div class="sidebar-section-title">TABLES</div>
    <a href="{{ route('detailpenyewaan.index') }}">Detail Pemesanan</a>
    <a href="{{ route('stokalatberat.index') }}">Stok Alat Berat</a>
    <a href="{{ route('pelanggan.index') }}">Pelanggan</a>
    <a href="{{ route('pembayaran.index') }}">Pembayaran</a>
    <a href="{{ route('invoice.index') }}">Invoice</a>

    <div class="mt-auto p-3 small" style="position:absolute; bottom:0;">
        Logged in as:<br>
        <strong>{{ Auth::user()->name }}</strong>
    </div>
</div>

<div class="topnav d-flex justify-content-between align-items-center">
    <input class="form-control" type="search" placeholder="Search for..." style="max-width: 280px;">
    
    <form action="{{ route('logout') }}" method="POST" class="ms-3">
        @csrf
        <button type="submit" class="btn btn-outline-light">Logout</button>
    </form>
</div>

<div class="content">
    <h2>Dashboard Admin</h2>
    <p class="text-muted">Selamat datang kembali, {{ Auth::user()->name }}</p>

    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card text-white bg-primary mb-3">
                <div class="card-body">Primary Card</div>
                <div class="card-footer"><a href="#" class="text-white">View Details</a></div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-dark bg-warning mb-3">
                <div class="card-body">Warning Card</div>
                <div class="card-footer"><a href="#" class="text-dark">View Details</a></div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-success mb-3">
                <div class="card-body">Success Card</div>
                <div class="card-footer"><a href="#" class="text-white">View Details</a></div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-danger mb-3">
                <div class="card-body">Danger Card</div>
                <div class="card-footer"><a href="#" class="text-white">View Details</a></div>
            </div>
        </div>
    </div>

    <footer class="mt-5 text-center small text-muted">
        Copyright © PowerHaul {{ date('Y') }}
    </footer>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>