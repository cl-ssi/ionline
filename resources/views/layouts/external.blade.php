<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'Laravel') }}</title>
        <!-- Scripts -->
        <script src="{{ asset('js/app.js') }}" defer></script>
        <!-- Fonts -->
        <link rel="dns-prefetch" href="//fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
        <!-- Styles -->
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">

        <!-- Custom styles for this template -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"
            integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO"
            crossorigin="anonymous">
        <link href="{{ asset('css/ssi.css') }}" rel="stylesheet">

        <!-- Favicons -->
        <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
        <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
        <link rel="manifest" href="/site.webmanifest">
        @production
        <link rel="icon" type="image/vnd.microsoft.icon" href="/favicon.ico">
        @else
        <link rel="icon" type="image/vnd.microsoft.icon" href="/favicon-local.ico">
        @endproduction

        <!-- Place your kit's code here -->
        <script src="https://kit.fontawesome.com/7c4f606aba.js" SameSite="None"
            crossorigin="anonymous"></script>

        @livewireStyles
    </head>
    <body>
        <nav class="navbar navbar-dark sticky-top bg-ssi flex-md-nowrap p-0 shadow ssi-azul">
            <a class="navbar-ssi @production ssi-rojo @else ssi-morado @endproduction col-md-3 col-lg-2 mr-0 px-3" href="{{ route('home') }}">Servicio de Salud</a>
            <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-toggle="collapse" data-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>
            <ul class="navbar-nav px-3 d-none d-md-block">
                <li class="nav-item">
                    <span class="nav-link">@auth {{ Auth::guard('external')->user()->name }} @endauth</span>
                </li>
            </ul>
        </nav>
        <div class="container-fluid">
            <div class="row">
                <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
                    <div class="sidebar-sticky pt-3">
                        @include('layouts.partials.nav_external')
                    </div>
                </nav>
                <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
                    @include('layouts.partials.errors')
                    @include('layouts.partials.flash_message')
                    @yield('content')
                </main>
            </div>
        </div>
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.9.0/feather.min.js"></script>
        <script>
            feather.replace()
        </script>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"
            integrity="sha512-bLT0Qm9VnAYZDflyKcBaQ2gg0hSYNQrJ8RilYldYQ1FxQYoCLtUjuuRuZo+fjqhx/qtq/1itJ0C2ejDxltZVFg=="
            crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"
            integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49"
            crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"
            integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy"
            crossorigin="anonymous"></script>
        <script src="https://cdn.amcharts.com/lib/version/4.9.34/core.js"></script>
        <script src="https://cdn.amcharts.com/lib/version/4.9.34/charts.js"></script>
        <script src="https://cdn.amcharts.com/lib/version/4.9.34/themes/material.js"></script>
        <script src="https://cdn.amcharts.com/lib/version/4.9.34/themes/animated.js"></script>

        <link rel="stylesheet"
              href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.18/css/bootstrap-select.min.css"
              integrity="sha512-ARJR74swou2y0Q2V9k0GbzQ/5vJ2RBSoCWokg4zkfM29Fb3vZEQyv0iWBMW/yvKgyHSR/7D64pFMmU8nYmbRkg=="
              crossorigin="anonymous"/>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.18/js/bootstrap-select.min.js"
                integrity="sha512-yDlE7vpGDP7o2eftkCiPZ+yuUyEcaBwoJoIhdXv71KZWugFqEphIS3PU60lEkFaz8RxaVsMpSvQxMBaKVwA5xg=="
                crossorigin="anonymous"></script>

        @yield('custom_js')
        @livewireScripts
    </body>
</html>
