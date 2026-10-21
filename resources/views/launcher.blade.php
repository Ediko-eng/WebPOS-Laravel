<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SI POS Kasir</title>

    <link rel="stylesheet" href="{{ asset('asset/AdminLTE-3.2.0/plugins/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('asset/AdminLTE-3.2.0/dist/css/adminlte.min.css') }}">
    <link rel="shortcut icon" href="{{ asset('asset/image/isa.jpg') }}" type="image/jpg">
</head>
<body class="hold-transition" style="background:#f4f6f9;">
<div class="wrapper">
    <div class="content-wrapper" style="margin:0;">
        <section class="content">
            <div class="container-fluid">
                <div class="text-center" style="padding:30px 15px 10px;">
                    <img src="{{ asset('asset/image/isa.jpg') }}" class="img-circle elevation-2"
                         width="70" alt="logo">
                    <h1 style="font-size:26px;margin-top:10px;">SI POS Kasir</h1>
                    <p class="text-muted mb-0">Sistema Informasaun Ponto de Venda &mdash; ita bele loke
                        toku sesaun iha ne'e, ida-ida iha slot ida-ida.</p>
                </div>

                <div class="row" style="max-width:1000px;margin:0 auto;">
                    @foreach ($slots as $slot)
                        <div class="col-md-4 col-sm-6">
                            <div class="card card-outline card-primary" style="height:100%;">
                                <div class="card-header">
                                    <h3 class="card-title">
                                        <i class="fas fa-window-maximize"></i> Sesaun {{ $slot['number'] }}
                                    </h3>
                                    <div class="card-tools">
                                        <span class="badge badge-{{ $slot['level'] == 1 ? 'primary' : ($slot['level'] == 2 ? 'info' : 'secondary') }}">
                                            {{ $slot['levelName'] }}
                                        </span>
                                    </div>
                                </div>
                                <div class="card-body text-center">
                                    <i class="fas fa-user-circle fa-4x text-muted"></i>
                                    <h4 style="margin:10px 0 2px;">{{ $slot['fullname'] ?? '—' }}</h4>
                                    <p class="text-muted" style="margin:0;">{{ $slot['username'] ?? '—' }}</p>
                                </div>
                                <div class="card-footer">
                                    <a href="{{ $basePath }}/s{{ $slot['number'] }}/login?u={{ $slot['username'] }}"
                                       class="btn btn-primary btn-block btn-sm" target="_blank">
                                        <i class="fas fa-sign-in-alt"></i> Tama iha Sesaun {{ $slot['number'] }}
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="text-center" style="padding:10px 15px 30px;">
                    @if ($currentUser)
                        <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-right"></i> Kontinua komo {{ $currentUser->username }}
                        </a>
                        <div style="height:8px;"></div>
                    @endif
                    <button type="button" class="btn btn-success" id="openAll">
                        <i class="fas fa-th"></i> Loke Toku Sesaun
                    </button>
                    <p class="text-muted" style="margin-top:12px;font-size:13px;">
                        Eita browser ne'ebé diferente ba kada sesaun, se ita hakarak iha browser ida deit,
                        ita bele uza sesaun ida-ida (slot) &mdash; kada slot iha nia sesaun (login) propriu.
                    </p>
                </div>
            </div>
        </section>
    </div>
</div>

<script src="{{ asset('asset/AdminLTE-3.2.0/plugins/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('asset/AdminLTE-3.2.0/dist/js/adminlte.min.js') }}"></script>
<script>
    (function () {
        var basePath = @json($basePath);
        var urls = @json($slots->map(fn($s) => $basePath . '/s' . $s['number'] . '/login?u=' . $s['username'])->all());

        document.getElementById('openAll').addEventListener('click', function () {
            urls.forEach(function (url) { window.open(url, '_blank'); });
        });
    })();
</script>
</body>
</html>
