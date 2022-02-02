<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <title>@yield('title')</title>
        <meta name="description" content="">
        <meta name="author" content="{{ env('APP_SS') }}">

        <meta name="viewport" content="width=500, initial-scale=1">
        <style media="screen">
            .pie_pagina {
                margin: 0 auto;
                /*border: 1px solid #F2F2F2;*/
                height: 40px;
                position: fixed;
                bottom: 0;
                text-align: center;
            }
        </style>
    </head>
    <body>
        <div class="content">

            <div style="height: 120px;">
                <img style="padding-bottom: 4px;" src="{{ asset('images/logo_rgb.png') }}"
                    width="120" alt="Logo {{ env('APP_SS') }}"><br>
            </div>
            @yield('content')


            <div class="pie_pagina seis center">
                <span class="uppercase">{{ env('APP_SS') }}</span><br>
                {{ env('APP_SS_ADDRESS') }} -
                Fono: {{ env('APP_SS_TELEPHONE') }} -
                {{ env('APP_SS_WEBSITE') }}
            </div>
        </div>

        @yield('custom_js')
    </body>
</html>
