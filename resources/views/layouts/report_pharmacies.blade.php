<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <title>@yield('title')</title>
        <meta name="description" content="">
        <meta name="author" content="{{ env('APP_SS') }}">
        <link href="{{ asset('css/report.css') }}" rel="stylesheet">
    </head>
    <body>
        <div class="content">
          @if( auth()->user()->pharmacies->firstWhere('id', session('pharmacy_id'))->id == 2)
            <img style="padding-bottom: 4px;" src="{{ asset('images/logo_cgu_pluma.jpg') }}"
              width="120" alt="Logo {{ env('APP_SS') }}"><br>
          @else
            <img style="padding-bottom: 4px;" src="{{ asset('images/logo_pluma.jpg') }}"
                width="120" alt="Logo {{ env('APP_SS') }}"><br>
          @endif

          @yield('content')

          <div class="pie_pagina seis center">
              <span class="uppercase">{{ env('APP_SS') }}</span><br>
              {{ env('APP_SS_ADDRESS') }} -
              Fono: 572406976 -
              {{ env('APP_SS_WEBSITE') }}
          </div>
        </div>

        @yield('custom_js')
    </body>
</html>
