<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>
        @if(App::environment('development'))
            Dev:
        @elseif(App::environment('test'))
            Test:
        @endif

        {{ config('app.name') }} - @yield('title')
    </title>

    @if(App::environment('development'))
        <link href="{{ asset('favicon-development.ico') }}" rel="icon" type="image/x-icon">
    @elseif(App::environment('test'))
        <link href="{{ asset('favicon-test.ico') }}" rel="icon" type="image/x-icon">
    @else
        <link href="{{ asset('favicon.ico') }}" rel="icon" type="image/x-icon">
    @endif

    <!-- Styles -->
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- Font Awesome - load everything-->
    <script defer src="{{ asset('js/font-awesome/all.min.js') }}"></script>

    <!-- Custom Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    @if(App::environment('development'))
        <style media="screen">
            .bg-nav-gobierno {
                background-color: rgb(73, 17, 82);
            }
        </style>
    @elseif(App::environment('test'))
        <style media="screen">
            .bg-nav-gobierno {
                background-color: rgb(2, 82, 0);
            }
        </style>
    @endif

    @yield('custom_css')
    @yield('custom_js_head')
</head>

<body>
    <header class="mb-3">
        @include('layouts.partials.nav_ehr')
    </header>

    <main role="main" class="container">
        <div class="d-none d-print-block">
            <strong>{{ env('APP_SS') }}</strong><br>
            Ministerio de Salud
        </div>
        @include('layouts/partials/errors')
        @include('layouts/partials/flash_message')
        @yield('content')
    </main>

    <footer class="footer">
        <div class="col-8 col-md-6 d-inline-block text-white"
            style="background-color: rgb(0,108,183);">{{ env('APP_SS') }}</div>
        <div class="col-4 col-md-6 float-right text-white"
            style="background-color: rgb(239,65,68);"> © 2018</div>
    </footer>

    <!-- jQuery first, then Popper.js, then Bootstrap JS Botton -->
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('js/popper.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/app.js') }}"></script>
    @yield('custom_js')
</body>
</html>
