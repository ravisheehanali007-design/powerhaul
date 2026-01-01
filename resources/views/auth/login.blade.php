<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
</head>
<body style="background:#f89f0a;">

<div class="container d-flex justify-content-center align-items-center" style="height:100vh;">
    <div class="col-md-5 bg-white p-5 rounded shadow">
        <h3 class="text-center mb-4">Login</h3>
@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif
        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show">
                {{ session('error') }}
            </div>
        @endif

        <form method="POST" action="{{ url('/login') }}">
            @csrf

            <div class="form-group">
                <label>Username/Email</label>
                <input type="text" name="email" class="form-control" required>
            </div>

            <div class="form-group mt-3">
                <label>Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-primary px-4">Login</button>
            <a href="{{ url('/') }}" class="btn btn-danger px-4" style="margin-left: 10px;">Batal</a>
            <a href="{{ route('register') }}"
   class="btn px-4 text-white"
   style="background-color:#f89f0a; min-width:100px; margin-left:10px;">
    Register
</a>
        </form>
    </div>
</div>

<script src="{{ asset('js/bootstrap.min.js') }}"></script>
</body>
</html>
