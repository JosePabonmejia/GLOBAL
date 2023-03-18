<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'E-commerce') }}</title>
    <!-- Favicon -->
    <!-- <link href="{{ asset('imagenes/hospital.png') }}" rel="icon" type="image/png"> -->
    <!-- Fonts -->
    <!-- Icons -->
    <link href="{{ asset('argon') }}/vendor/nucleo/css/nucleo.css" rel="stylesheet">
    <link href="{{ asset('argon') }}/vendor/@fortawesome/fontawesome-free/css/all.min.css" rel="stylesheet">
    <!-- Argon CSS -->
    <link type="text/css" href="{{ asset('argon') }}/css/argon.css" rel="stylesheet">
    <link type="text/css" href="{{ asset('assets') }}/vendor/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link type="text/css" href="{{ asset('assets') }}/vendor/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css" rel="stylesheet">
    <!-- <link type="text/css" href="{{ asset('assets') }}/vendor/datatables.net-buttons-bs4/css/select.bootstrap4.min.css" rel="stylesheet"> -->
    <!-- Argon CSS -->

    @yield('css')
</head>

<body>
    @auth()
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>
    @include('layouts.navbars.sidebar')
    @endauth

    <div class="main-content">
        @include('layouts.navbars.navbar')
        @yield('content')
        

    </div>

    @guest()
    @include('layouts.footers.guest')
    @endguest
    <script src="{{ asset('argon')  }}/vendor/jquery/dist/jquery.min.js"></script>
    <script src="{{ asset('argon')  }}/vendor/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('argon')  }}/vendor/chart.js/dist/Chart.min.js"></script>
    <!-- Datatables -->
    <script src="{{ asset('assets')}}/vendor/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="{{ asset('assets')}}/vendor/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>

    <script src="{{ asset('assets')}}/vendor/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
    <script src="{{ asset('assets')}}/vendor/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js"></script>
    <script src="{{ asset('assets')}}/vendor/datatables.net-buttons/js/buttons.html5.min.js"></script>
    <script src="{{ asset('assets')}}/vendor/datatables.net-buttons/js/buttons.flash.min.js"></script>
    <script src="{{ asset('assets')}}/vendor/datatables.net-buttons/js/buttons.print.min.js"></script>
    <script src="{{ asset('assets')}}/vendor/datatables.net-select/js/dataTables.select.min.js"></script>


    <script src="{{ asset('argon')  }}/js/plugins/sweetalert2.js"></script>
    <script src="{{ asset('argon')  }}/vendor/chart.js/dist/Chart.min.js"></script>
    @yield('js')
    <!-- <script>
        const boton = document.createElement("button");
        boton.innerHTML = "Click aquí";
        boton.style = "bottom:10px;right:10px;position:fixed;z-index:9999;"
        document.body.appendChild(boton);
    </script> -->
    <!-- Argon JS -->
    <script src="{{ asset('argon') }}/js/argon.js"></script>
    <script src="{{ asset('argon')  }}/js/plugins/sweetalert2.js"></script>
    <script src="{{ asset('argon')  }}/vendor/chart.js/dist/Chart.min.js"></script>

</body>

</html>