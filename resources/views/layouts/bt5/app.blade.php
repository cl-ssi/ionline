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

        <link 
            href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" 
            rel="stylesheet" 
            integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" 
            crossorigin="anonymous">

        <link href="{{ asset('css/intranet.css') }}" rel="stylesheet">

        <style media="screen">
            .bg-nav-gobierno {
                @switch(env('APP_ENV'))
                    @case('local') background-color: rgb(73, 17, 82); @break
                    @case('testing') background-color: rgb(2, 82, 0); @break
                    @case('production')
                        @if(env('APP_DEBUG') == true)
                            background-color: rgb(255, 0, 0);
                        @else
                            background-color: rgb(0,108,183);
                        @endif
                        @break;
                @endswitch
            }

            .container {
                max-width: 1200px;
            }
        </style>

        @yield('custom_css')

        <!-- Bootstrap icons -->
        <link 
            rel="stylesheet" 
            href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">

        <!-- Place your kit's code here -->
        <script 
            src="https://use.fontawesome.com/releases/v5.15.4/js/all.js" 
            data-mutate-approach="sync">
        </script>

        @livewireStyles
    </head>
    <body>
        <div id="app">
            @include('layouts.bt5.partials.nav')

            @if(Route::is('home') )
            <main class="container">
            @else  
            <main class="container pt-3">  
            @endif
                <div class="d-none d-print-block">
                    <strong>{{ env('APP_SS') }}</strong><br>
                    Ministerio de Salud
                </div>
                @include('layouts.bt5.partials.errors')
                @include('layouts.bt5.partials.flash_message')
                @yield('content', $slot ?? '')
            </main>

            <footer class="footer d-print-none">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-6 col-md-6 text-white"style="background-color: rgb(0,108,183);">
                            {{ env('APP_SS', 'Servicio de Salud') }}
                        </div>
                        <div class="col-6 col-md-6 float-right text-white" style="background-color: rgb(239,65,68);">
                            © {{ date('Y') }}
                        </div>
                    </div>
                </div>
            </footer>
        </div>

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

        <script 
            src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" 
            integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" 
            crossorigin="anonymous">
        </script>

        @yield('custom_js')
        @livewireScripts
        @stack('scripts')
    </body>
</html>