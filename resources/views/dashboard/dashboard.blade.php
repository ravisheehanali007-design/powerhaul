<!DOCTYPE html>
<html lang="en">
<head>
    <title>Dashboard - POWERHAUL</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
    <link href="https://fonts.googleapis.com/css?family=Poppins:200,300,400,500,600,700,800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/open-iconic-bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/ionicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/flaticon.css') }}">
    <link rel="stylesheet" href="{{ asset('css/icomoon.css') }}">

    <link rel="stylesheet" href="{{ asset('css/animate.css') }}">
    <link rel="stylesheet" href="{{ asset('css/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/owl.theme.default.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/magnific-popup.css') }}">
    <link rel="stylesheet" href="{{ asset('css/aos.css') }}">
    <link rel="stylesheet" href="{{ asset('css/bootstrap-datepicker.css') }}">
    <link rel="stylesheet" href="{{ asset('css/jquery.timepicker.css') }}">

    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    
    <style>
        /* Styling Lingkaran Foto Profil */
.user-icon-circle {
    width: 35px;
    height: 35px;
    border-radius: 50%;
    border: 2px solid rgba(255,255,255,0.2); /* Memberi bingkai tipis agar terlihat rapi */
    background: #eee;
    transition: 0.3s;
    overflow: hidden; /* Memastikan gambar tidak keluar dari lingkaran */
}


        
        
        /* 1. Navbar Transparan di atas Hero */
        .ftco_navbar {
            top: 0;
            background: transparent !important;
            position: absolute;
            left: 0;
            right: 0;
        }
        
        /* 2. Navbar saat di-scroll (Putih) */
        .ftco_navbar.scrolled {
            background: #fff !important;
            box-shadow: 0 0 10px rgba(0,0,0,0.1) !important;
        }

        /* 3. Hero Section & Teks */
        .hero-wrap {
            width: 100%;
            height: 100vh; /* Full screen seperti di gambar */
            min-height: 700px;
            position: relative;
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center center;
        }

        .hero-wrap .overlay {
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            content: '';
            opacity: .4;
            background: #000;
        }

        /* 4. Styling Card Koleksi */
        .category-card {
            border: 1px solid #f0f0f0;
            border-radius: 10px;
            padding: 25px 15px;
            transition: 0.3s;
            background: #fff;
            box-shadow: 0px 10px 18px -9px rgba(0, 0, 0, 0.1);
            cursor: pointer;
        }
        .category-card:hover {
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            transform: translateY(-5px);
        }
        .category-disabled { opacity: 0.4; pointer-events: none; }
    </style>
</head>
<body data-spy="scroll" data-target=".site-navbar-target" data-offset="300">

    <nav class="navbar navbar-expand-lg navbar-dark ftco_navbar ftco-navbar-light site-navbar-target" id="ftco-navbar">
        <div class="container">
            <a class="navbar-brand" href="#">POWER<strong>HAUL</strong></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ftco-nav">
                <span class="oi oi-menu"></span> Menu
            </button>
            <div class="collapse navbar-collapse" id="ftco-nav">
                <ul class="navbar-nav ml-auto align-items-center">
                    <li class="nav-item active"><a href="#" class="nav-link">Home</a></li>
                    <li class="nav-item"><a href="#" class="nav-link">About</a></li>
                    <li class="nav-item"><a href="#" class="nav-link">Pricing</a></li>
                    <li class="nav-item"><a href="#" class="nav-link">Our Car</a></li>
                    <li class="nav-item"><a href="#" class="nav-link">Blog</a></li>
                    <li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="profileDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="padding-left:20px;">
        <img src="{{ asset('images/profile.png') }}" style="width:32px; height:32px; border-radius:50%; margin-right:10px; object-fit: cover;">
        <span class="text-white small font-weight-bold">{{ Auth::user()->name }}</span>
    </a>
    
    <div class="dropdown-menu dropdown-menu-right shadow" aria-labelledby="profileDropdown" style="border-radius: 8px; overflow: hidden;">
        <form action="{{ route('logout') }}" method="POST" class="m-0">
    @csrf
    <button type="submit" class="dropdown-item d-flex align-items-center py-2" style="border: none; background: none; width: 100%; cursor: pointer;">
        <img src="{{ asset('images/logout.png') }}" style="width:18px; height:18px; margin-right:10px;">
        <span class="text-danger font-weight-bold">Logout</span>
    </button>
</form>
    </div>
</li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="hero-wrap" style="background-image: url('{{ asset('images/construction-truck.jpg') }}');" data-stellar-background-ratio="0.5">
        <div class="overlay"></div>
        <div class="container">
            <div class="row no-gutters slider-text justify-content-start align-items-center" style="height: 100vh; min-height: 700px;">
                <div class="col-lg-6 col-md-6 ftco-animate">
                    <div class="text">
                        <h1 class="mb-4" style="font-weight: 700; font-size: 55px; color: #fff; line-height: 1.2;">
                            Now <span>It's easy for you</span> <span>rent a car</span>
                        </h1>
                        <p style="font-size: 18px; color: rgba(255,255,255,0.9);">
                            A small river named Duden flows by their place and supplies it with the necessary regelialia.
                        </p>
                        <div class="d-flex align-items-center mt-4">
                            <a href="#" class="icon-wrap d-flex align-items-center justify-content-center" style="background: #f89d35; width: 60px; height: 60px; border-radius: 50%;">
                                <span class="ion-ios-play" style="color: #fff; font-size: 20px;"></span>
                            </a>
                            <span class="ml-3 font-weight-bold text-white">Easy steps for renting a car</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <section class="ftco-section bg-light">
        <div class="container">
            <div class="row justify-content-center mb-4 ftco-animate">
                <div class="col-md-7 heading-section text-center">
                    <span class="subheading" style="background: #dff1ff; padding: 5px 20px; border-radius: 5px; color:#007bff; font-weight: bold; text-transform: uppercase; letter-spacing: 2px;">
                        Collections
                    </span>
                </div>
            </div>

            <div class="row justify-content-center mb-5">
    @foreach($categories as $cat)
    <div class="col-md-2 col-6 mb-4 ftco-animate">
        {{-- Gunakan route dashboard atau katalog untuk kategori --}}
        <a href="{{ route('dashboard', ['category' => $cat['title']]) }}" style="text-decoration: none;">
            <div class="category-card text-center {{ $cat['disabled'] ? 'category-disabled' : '' }}">
                <img src="{{ asset($cat['image']) }}" style="width: 100px; height: 80px; object-fit: contain;" class="mb-2">
                <h6 class="font-weight-bold" style="color: #444;">{{ $cat['title'] }}</h6>
            </div>
        </a>
    </div>
@endforeach
</div>

            <div class="row">
                @foreach($cars as $car)
                    <div class="col-md-4 mb-5 ftco-animate">
                        <div class="car-wrap rounded border p-4 bg-white text-center h-100 shadow-sm">
                            <div class="img-container mb-4 d-flex align-items-center justify-content-center" style="height: 180px;">
                                <img src="{{ asset($car['photo']) }}" class="img-fluid" style="max-height: 100%; object-fit: contain;">
                            </div>
                            <div class="text">
                                <h2 class="mb-0" style="font-size: 22px; font-weight: 600; color: #333;">{{ $car['title'] }}</h2>
                                <h2 class="mb-3" style="font-size: 20px; font-weight: 500; color: #666;">{{ $car['year'] }}</h2>
                                <p class="mb-4" style="color: #007bff; font-weight: bold; font-size: 12px; letter-spacing: 2px;">
                                    TIPE: {{ strtoupper($car['type']) }}
                                </p>
                                <div class="mb-4">
    {{-- Gunakan kurung siku ['id_truk'] karena data dari getCars() adalah array --}}
<a href="{{ route('user.detail', $car['id_truk']) }}" class="btn btn-primary">Book Now</a>
</div>
                                <p class="text-muted mb-4" style="font-size: 14px; line-height: 1.6;">
                                    {{ $car['desc'] }}
                                </p>
                                <div class="rating"><span style="color: #ffc107; font-size: 18px;">★★★★★</span></div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('js/jquery-migrate-3.0.1.min.js') }}"></script>
    <script src="{{ asset('js/popper.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/jquery.easing.1.3.js') }}"></script>
    <script src="{{ asset('js/jquery.waypoints.min.js') }}"></script>
    <script src="{{ asset('js/jquery.stellar.min.js') }}"></script>
    <script src="{{ asset('js/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('js/jquery.magnific-popup.min.js') }}"></script>
    <script src="{{ asset('js/aos.js') }}"></script>
    <script src="{{ asset('js/jquery.animateNumber.min.js') }}"></script>
    <script src="{{ asset('js/scrollax.min.js') }}"></script>
    <script src="{{ asset('js/main.js') }}"></script>

    <script>
        $(document).ready(function() {
            // Animasi AOS
            AOS.init({
                duration: 800,
                easing: 'slide'
            });

            // Re-trigger animasi Waypoints jika perlu
            if(typeof contentWayPoint !== 'undefined') {
                contentWayPoint();
            }
        });
    </script>
</body>
</html>