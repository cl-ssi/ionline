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
</head>

<body>
    <!-- Define header and footer blocks before your content -->
    <header class="left"
        style="float: left;">

        <img src="{{ $establishment->logoPublicPath }}"
            height="109"
            alt="Logo de la institución">

        @hasSection('linea1')
            <div class="siete"
                style="padding-top: 2px; width: 200px;">
                @yield('linea1')
            </div>
        @endif

        @hasSection('linea2')
            <div class="siete"
                style="padding-top: 1px;">
                @yield('linea2')
            </div>
        @endif

        @hasSection('linea3')
            <div class="seis"
                style="padding-top: 2px; color: #999">
                @yield('linea3')
            </div>
        @endif
    </header>


    @include('documents.templates.partials.footer')

    <!-- Define main for content -->
    <main>
        @yield('before-content')
        @yield('content', $slot ?? '')
    </main>
    <!-- For approvals -->
    @yield('approvals')
</body>

</html>