<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login | SI-POS Kasir</title>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="{{ asset('asset/AdminLTE-3.2.0/plugins/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('asset/AdminLTE-3.2.0/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('asset/AdminLTE-3.2.0/dist/css/adminlte.min.css') }}">
    <link rel="shortcut icon" href="{{ asset('asset/image/isa.jpg') }}" type="image/jpg">
</head>
<body class="hold-transition login-page" id="bg-login">
<div class="login-box slide-down" style="margin-top: -70px;">
    <div class="card card-outline card-primary">
        <div class="card-header text-center">
            <a href="#" class="h1"><b>SI</b> POS Kasir</a>
        </div>
        <div class="card-body">
            <p class="login-box-msg">Tama hodi hahu ita-boot nia sesaun</p>

            @if ($errors->any())
            <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                {{ $errors->first() }}
            </div>
            @endif

            <form action="{{ route('login.post') }}" method="post">
                @csrf
                <div class="input-group mb-4">
                    <input type="text" name="username" class="form-control" placeholder="username"
                           value="{{ old('username', $username ?? '') }}" required autofocus>
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-user"></span>
                        </div>
                    </div>
                </div>
                <div class="input-group mb-4">
                    <input type="password" name="password" class="form-control" placeholder="Password" required>
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                </div>
                <div class="mb-4">
                    <button type="submit" name="login" class="btn btn-primary btn-block">Tama</button>
                </div>
            </form>
            <p class="my-3 text-center">
                <strong>Copyright &copy; 2023 <span class="text-info">SI POS Kasir</span></strong>
            </p>
        </div>
    </div>
</div>

<script src="{{ asset('asset/AdminLTE-3.2.0/plugins/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('asset/AdminLTE-3.2.0/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('asset/AdminLTE-3.2.0/dist/js/adminlte.min.js') }}"></script>
</body>
</html>
