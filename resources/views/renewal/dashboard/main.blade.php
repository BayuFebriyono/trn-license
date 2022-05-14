<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="{{ asset('mazer/assets/css/opencss.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('mazer/assets/css/bootstrap.css') }}">

    <link rel="stylesheet" href="{{ asset('mazer/assets/vendors/iconly/bold.css') }}">

    <link rel="stylesheet" href="{{ asset('mazer/assets/vendors/simple-datatables/style.css') }}">
    <link rel="stylesheet" href="{{ asset('sweet-alert/sweetalert2.min.css') }}">

    <link rel="stylesheet" href="{{ asset('mazer/assets/vendors/perfect-scrollbar/perfect-scrollbar.css') }}">
    <link rel="stylesheet" href="{{ asset('mazer/assets/vendors/bootstrap-icons/bootstrap-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('mazer/assets/css/app.css') }}">
    <link rel="shortcut icon" href="{{ asset('mazer/assets/css/app.css') }}" type="image/x-icon">
    <script src="{{ asset('js/jquery.js') }}"></script>
    <script src="{{ asset('sweet-alert/sweetalert2.min.js') }}"></script>
</head>

<body>
    <div id="app">
       @include('renewal.dashboard.navbar');
        <div id="main">
            <header class="mb-3">
                <a href="#" class="burger-btn d-block d-xl-none">
                    <i class="bi bi-justify fs-3"></i>
                </a>
            </header>

            @yield('content')

            {{-- <footer>
                <div class="footer clearfix mb-0 text-muted">
                    <p class="text-center">2022 &copy; Training Center</p>
                </div>
            </footer> --}}
        </div>
    </div>
    <script src="{{ asset('mazer/assets/vendors/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('mazer/assets/js/bootstrap.bundle.min.js') }}"></script>

    {{-- <script src="{{ asset('mazer/assets/vendors/apexcharts/apexcharts.js') }}"></script>
    <script src="{{ asset('mazer/assets/js/pages/dashboard.js') }}"></script> --}}

    <script src="{{ asset('mazer/assets/vendors/simple-datatables/simple-datatables.js') }}"></script>
    <script>
        // Simple Datatable
        let table1 = document.querySelector('#table1');
        let dataTable = new simpleDatatables.DataTable(table1);
    </script>
    <script src="{{ asset('mazer/assets/js/mazer.js') }}"></script>
</body>

</html>
