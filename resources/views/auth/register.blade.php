<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register</title>
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
</head>
<body style="background:#f89f0a;">

<div class="container d-flex justify-content-center align-items-center" style="height:100vh;">
    <div class="col-md-5 bg-white p-5 rounded shadow">
        <h3 class="text-center mb-4">Register</h3>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ url('/register') }}">
            @csrf

            <div class="form-group">
                <label>name</label>
                <input type="text" name="name" class="form-control" required>
            </div>

            <div class="form-group mt-3">
                <label>Email</label>
                <input type="email" name="email" class="form-control" required>
            </div>

            <div class="form-group mt-3">
                <label>Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>

            <div class="form-group mt-3">
                <label>Confirm Password</label>
                <input type="password" name="password_confirmation" class="form-control" required>
            </div>

            <div class="mt-4">
                <button type="submit" class="btn btn-primary px-4">
                    Register
                </button>

                <a href="{{ route('login') }}"
                   class="btn px-4 text-white"
                   style="background-color:#f89f0a; margin-left:10px;">
                    Kembali
                </a>
            </div>
        </form>
    </div>
</div>

<script src="{{ asset('js/bootstrap.min.js') }}"></script>
</body>
</html>
