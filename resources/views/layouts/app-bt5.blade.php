<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Servicio de Salud') }} @yield('title')</title>

        <link href="{{ asset('favicon-'. env('APP_ENV') .'.ico') }}" rel="icon" type="image/x-icon">

        @yield('custom_js_head')

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

        <link href="{{ asset('css/intranet.css') }}" rel="stylesheet">

        <style media="screen">
            .bg-nav-gobierno {
                @switch(env('APP_ENV'))
                    @case('local') background-color: rgb(73, 17, 82); @break
                    @case('testing') background-color: rgb(2, 82, 0); @break
                    @case('production')
                        @if(env('APP_DEBUG') == true)
                            background-color: rgb(255, 0, 0);
                        @elseif(!env('OLD_SERVER'))
                            background-color: rgb(2, 82, 0);
                        @endif
                        @break;
                @endswitch
            }
        </style>
        @yield('custom_css')

        <!-- Place your kit's code here -->
        <script src="https://use.fontawesome.com/releases/v5.15.4/js/all.js" data-mutate-approach="sync"></script>

        @livewireStyles
    </head>
    <body>
        <div id="app">
            @guest
                @include('layouts.partials.nav')
            @else
                @if(Auth::user()->external )
                    @include('layouts.partials.nav_external')
                @else
                    @include('layouts.partials.nav')
                @endif
            @endGuest
            <main class="container pt-3">
                <div class="d-none d-print-block">
                    <strong>{{ env('APP_SS') }}</strong><br>
                    Ministerio de Salud
                </div>
                @include('layouts.partials.errors')
                @include('layouts.partials.flash_message')
                @yield('content', $slot ?? '')
            </main>

            <footer class="footer">
                <div class="col-8 col-md-6 d-inline-block text-white"
                    style="background-color: rgb(0,108,183);">{{ config('app.ss', 'Servicio de Salud') }}</div>
                <div class="col-4 col-md-6 float-right text-white"
                    style="background-color: rgb(239,65,68);"> © {{ date('Y') }}</div>
            </footer>
        </div>
        
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"
            integrity="sha512-bLT0Qm9VnAYZDflyKcBaQ2gg0hSYNQrJ8RilYldYQ1FxQYoCLtUjuuRuZo+fjqhx/qtq/1itJ0C2ejDxltZVFg=="
            crossorigin="anonymous"></script>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
        @yield('custom_js')
        @livewireScripts
    </body>
</html>