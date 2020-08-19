<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <title>@yield('title')</title>
        <meta name="description" content="">
        <meta name="author" content="{{ config('app.ss') }}">
        <link href="{{ asset('css/report.css') }}" rel="stylesheet">
    </head>
    <body>
        <div class="content">
            <img style="padding-bottom: 4px;" src="{{ asset('images/logo_pluma.jpg') }}"
                width="120" alt="Logo {{ config('app.ss') }}"><br>
            @yield('content')

            <div class="pie_pagina seis center">
                <span class="uppercase">{{ config('app.ss') }}</span><br>
                {{ env('APP_SS_ADDRESS') }} -
                Fono: {{ env('APP_SS_TELEPHONE') }} -
                {{ env('APP_SS_WEBSITE') }}
            </div>
        </div>

        @yield('custom_js')
    </body>
</html>
