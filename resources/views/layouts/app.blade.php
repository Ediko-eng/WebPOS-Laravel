<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'SI POS Kasir' }}</title>

    <link rel="stylesheet" href="{{ asset('asset/AdminLTE-3.2.0/plugins/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('asset/AdminLTE-3.2.0/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('asset/AdminLTE-3.2.0/plugins/sweetalert2/sweetalert2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('asset/AdminLTE-3.2.0/dist/css/adminlte.min.css') }}">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="shortcut icon" href="{{ asset('asset/image/isa.jpg') }}" type="image/jpg">

    <script src="{{ asset('asset/AdminLTE-3.2.0/plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('asset/AdminLTE-3.2.0/plugins/sweetalert2/sweetalert2.min.js') }}"></script>

    @stack('styles')
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">

    <div id="preloader" style="position:fixed;top:0;left:0;width:100%;height:100%;background:#fff;z-index:99999;display:flex;align-items:center;justify-content:center;">
        <div class="spinner-border text-primary" style="width:3rem;height:3rem;" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>

    @include('layouts.navbar')
    @include('layouts.sidebar')

    @if (session('success'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                title: 'Susesu!',
                text: '{{ session('success') }}',
                icon: 'success',
                toast: true,
                position: 'bottom-right',
                showConfirmButton: false,
                timer: 5000
            });
        });
    </script>
    @endif

    @if ($errors->any())
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                title: 'Error!',
                text: '{{ $errors->first() }}',
                icon: 'error',
                toast: true,
                position: 'bottom-right',
                showConfirmButton: false,
                timer: 5000
            });
        });
    </script>
    @endif

    @yield('content')

    @include('layouts.footer')
</div>

<script src="{{ asset('asset/AdminLTE-3.2.0/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('asset/AdminLTE-3.2.0/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('asset/AdminLTE-3.2.0/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('asset/AdminLTE-3.2.0/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('asset/AdminLTE-3.2.0/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('asset/AdminLTE-3.2.0/dist/js/adminlte.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('preloader').style.display = 'none';

        if ($.fn.DataTable) {
            $('#tblData').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
            });
        }

        var tema = sessionStorage.getItem('tema');
        if (tema === 'dark') {
            document.body.classList.add('dark-mode');
            var cek = document.getElementById('cekDark');
            if (cek) cek.checked = true;
        }

        var cekDark = document.getElementById('cekDark');
        if (cekDark) {
            cekDark.addEventListener('change', function() {
                if (this.checked) {
                    document.body.classList.add('dark-mode');
                    sessionStorage.setItem('tema', 'dark');
                } else {
                    document.body.classList.remove('dark-mode');
                    sessionStorage.setItem('tema', 'light');
                }
            });
        }
    });
</script>

@stack('scripts')
</body>
</html>
