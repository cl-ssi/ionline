<?php setlocale(LC_ALL, 'es_CL.UTF-8');?>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <title>@yield('title')</title>
    <meta name="description"
        content="Documento generado a través de iOnline del {{ env('APP_SS') }}">
    <meta name="author"
        content="{{ env('APP_SS') }}">

    <link href="{{ public_path('css/document.css') }}"
        rel="stylesheet">
    <meta http-equiv="Content-Type"
        content="text/html; charset=utf-8" />
    <style>
        body {
            margin: 0;
        }
        main {
            margin-left: 0px;
        }
    </style>
</head>

<body>
    <!-- Define header and footer blocks before your content -->
    <header class="left"
        style="float: left;">

        <img src="{{ public_path('images/Logo_Gobierno_de_Chile_2010-2014.svg') }}"
            height="87"
            style="padding-left: 8px;"
            alt="Logo de la institución">

        @hasSection('linea1')
            <div class="negrita"
                style="font-size: 1.1rem; padding-top: 2px; padding-left: 9px; width: 200px;">
                @yield('linea1')
            </div>
        @endif
    </header>

    <!-- Define main for content -->
    <main>
        @yield('content', $slot ?? '')
    </main>
    <!-- For approvals -->
    @yield('approvals')
</body>

</html>