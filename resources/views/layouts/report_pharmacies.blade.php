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
          @if( Auth::user()->can('Pharmacy: REYNO (id:2)'))
            <img style="padding-bottom: 4px;" src="{{ asset('images/logo_cgu_pluma.jpg') }}"
              width="120" alt="Logo {{ config('app.ss') }}"><br>
          @else
            <img style="padding-bottom: 4px;" src="{{ asset('images/logo_pluma.jpg') }}"
                width="120" alt="Logo {{ config('app.ss') }}"><br>
          @endif
          
          @yield('content')

          <div class="pie_pagina seis center">
              <span class="uppercase">{{ config('app.ss') }}</span><br>
              {{ env('APP_SS_ADDRESS') }} -
              Fono: 572406976 -
              {{ env('APP_SS_WEBSITE') }}
          </div>
        </div>

        @yield('custom_js')
    </body>
</html>
