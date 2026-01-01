<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - PowerHaul</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        body { background-color: #f8f9fc; font-family: 'Nunito', Arial, sans-serif; margin: 0; }

        /* --- SIDEBAR STYLING --- */
        .sidebar { 
            width: 250px; 
            height: 100vh; 
            background: #3a3b45; /* Warna gelap konsisten */
            position: fixed; 
            top: 0; 
            left: 0; 
            display: flex; 
            flex-direction: column; 
            z-index: 1001;
        }

        .brand-link { text-decoration: none !important; }
        
        .sidebar-brand {
            font-size: 19px; 
            font-weight: 800; 
            padding: 25px 20px 10px 20px; 
            color: #ffffff; 
            letter-spacing: 0.5px;
        }

        .sidebar-section-title {
            font-size: 11px; 
            padding: 20px 20px 10px 20px; 
            color: #858796; 
            font-weight: 700; 
            letter-spacing: 1.5px;
            text-uppercase: true;
        }

        .nav-link-custom { 
            display: block; 
            padding: 12px 20px; 
            color: #d1d3e2 !important; 
            text-decoration: none !important; 
            font-size: 14px;
            transition: 0.3s;
            border-left: 4px solid transparent;
        }

        .user-info-box {
            position: absolute; 
            bottom: 30px; 
            left: 20px; 
            color: #ffffff; 
            font-size: 13px; 
            line-height: 1.4;
        }

        /* --- TOPNAV STYLING --- */
        .topnav { 
            margin-left: 250px; 
            height: 70px; 
            background: #1f1f1f; /* Dark Topnav sesuai gambar sebelumnya */
            display: flex; 
            align-items: center; 
            padding: 0 20px; 
            position: sticky; 
            top: 0; 
            z-index: 1000;
            box-shadow: 0 .15rem 1.75rem 0 rgba(0,0,0,.15);
        }

        /* --- CONTENT STYLING --- */
        .content { 
            margin-left: 250px; 
            padding: 30px; 
            min-height: calc(100vh - 70px);
            background-color: #f8f9fc;
        }

        .footer { text-align: center; font-size: 13px; color: #6c757d; margin-top: 50px; padding-bottom: 20px; }
        
        /* Utility */
        .form-control-dark {
            background: #343a40; 
            border: none; 
            color: white;
        }
        .form-control-dark::placeholder { color: #858796; }
    </style>
</head>
<body>

<div class="sidebar">
    <a href="{{ route('dashboard.admin') }}" class="brand-link">
        <div class="sidebar-brand">PowerHaulTrucks</div>
    </a>

    <div class="sidebar-section-title">TABLES</div>

    <a href="{{ route('detailpenyewaan.index') }}" class="nav-link-custom {{ request()->routeIs('detailpenyewaan.*') ? 'active-link' : '' }}">
    Detail Penyewaan
    <a href="{{ route('stokalatberat.index') }}" class="nav-link-custom {{ request()->routeIs('stok-alat-berat.*') ? 'active-link' : '' }}">
    Stok Alat Berat
</a>
    <a href="{{ route('pelanggan.index') }}" class="nav-link-custom {{ request()->routeIs('pelanggan.*') ? 'active-link' : '' }}"> Pelanggan</a>
    <a href="{{ route('pembayaran.index') }}" class="nav-link-custom {{ request()->routeIs('pembayaran.*') ? 'active-link' : '' }}"> Pembayaran</a>
    <a href="{{ route('invoice.index') }}" class="nav-link-custom {{ request()->routeIs('invoice.*') ? 'active-link' : '' }}"> Invoice</a>

    <div class="user-info-box">
        <span style="color: #cfcfcf;">Logged in as:</span><br>
        <strong style="font-size: 14px;">{{ Auth::user()->name }}</strong>
    </div>
</div>

<div class="topnav d-flex justify-content-between align-items-center">
    <div class="flex-grow-1">
        <input class="form-control form-control-dark" type="search" placeholder="Search for..." style="max-width: 350px;">
    </div>
    
    <form action="{{ route('logout') }}" method="POST" class="ms-3">
        @csrf
        <button type="submit" class="btn btn-outline-light btn-sm">Logout</button>
    </form>
</div>

<div class="content">
    @yield('content')

    <div class="footer">
        Copyright © PowerHaul {{ date('Y') }}
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>