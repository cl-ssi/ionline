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
    <link href="{{ asset('css/intranet.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        @include('layouts.partials.nav')

        <main class="py-4">
            @yield('content')
        </main>

        <footer class="footer">
            <div class="col-8 col-md-6 d-inline-block text-white"
                style="background-color: rgb(0,108,183);">{{ config('app.ss', 'Servicio de Salud') }}</div>
            <div class="col-4 col-md-6 float-right text-white"
                style="background-color: rgb(239,65,68);"> © {{ date('Y') }}</div>
        </footer>
    </div>
</body>
</html>
