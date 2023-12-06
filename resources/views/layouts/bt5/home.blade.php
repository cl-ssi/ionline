@extends('layouts.bt5.app')

@section('title', 'Inicio')

@section('content')

<div class="row">
    <div class="col">
        <img src="{{ asset('images/header_ionline_title_150px.png') }}" class="img-fluid" alt="...">
    </div>
</div>

<div class="row pt-2">
    <div class="col-sm-8 col-12">
        <div id="carouselNews" class="carousel slide">
            <div class="carousel-indicators">
                @foreach($allNews as $news)
                    <button type="button" data-bs-target="#carouselNews" data-bs-slide-to="{{ $loop->index }}" @if($loop->index == 0) class="active" @endif aria-current="true" aria-label="Slide {{ $loop->index }}"></button>
                @endforeach
            </div>
            <div class="carousel-inner">
                @foreach($allNews as $news)
                <div class="carousel-item @if($loop->index == 0) active @endif">
                    <a href="{{ route('news.show', $news) }}"> 
                        <img src="{{ route('news.view_image', $news) }}" class="d-block w-100" alt="...">
                        <div class="carousel-caption d-none d-md-block">
                            <h5>{{ $news->title }}</h5>
                            <p>{{ $news->subtitle }}.</p>
                        </div>
                    </a>
                </div>
                @endforeach
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselNews" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselNews" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>

        <div class="mt-4" style="background-color: #006FB3; color: #FFFFFF">
            <h5 class="ms-4"><i class="fas fa-file-signature"></i> Información sobre Firma Electrónica</h5>
        </div>

        {{-- <div class="jumbotron mt-4 pt-2"> --}}
        <div class="mt-4 p-5 text-black rounded" style="background-color: #EEEEEE">
            <div class="row">
                {{--
                <div class="col-md-3 col-12">
                    <!-- <img src="{{ asset('images/tree.jpg') }}" class="img-thumbnail rounded" alt="Arbol de navidad"> -->
                    <img src="{{ asset('images/Logo Servicio de Salud Tarapacá - RGB.png') }}"
                        alt="Logo {{ env('APP_SS') }}"
                        class="img-thumbnail mb-3">
                    <strong>Logos:</strong>
                    <ul>
                        <li>
                            <a href="{{ asset('images/Logo Servicio de Salud Tarapacá - RGB.png') }}">SST Color</a>
                        </li>
                        <li>
                            <a href="{{ asset('images/Logo Servicio de Salud Tarapacá - Pluma.png') }}">SST Pluma</a>
                        </li>
                        <li>
                            <a href="{{ asset('images/Logo Hospital Ernesto Torres - RGB.png') }}">HETG Color</a>
                        </li>
                        <li>
                            <a href="{{ asset('images/Logo Hospital Ernesto Torres - Pluma.png') }}">HETG Pluma</a>
                        </li>
                        <li>
                            <a href="{{ asset('images/Logo Hospital de Alto Hospicio - RGB.png') }}">HAH Color</a>
                        </li>
                        <li>
                            <a href="{{ asset('images/Logo Hospital de Alto Hospicio - Pluma.png') }}">HAH Pluma</a>
                        </li>
                    </ul>
                </div>
                --}}

                <div class="col">
                    <h6>Pasos para solicitud de Firma Electrónica del Gobierno (OTP) para Funcionarios Visadores y Firmantes</h6>
                    <ol>
                        <li>
                            Solicitar mediante un requerimiento en iOnline/SGR, dirigido a Gabriela Aliaga del Departamento de Tecnologías de la Información y Comunicaciones, la creación del usuario firma.digital.gob.cl. Indicar los siguientes datos:
                        </li>
                        <ul>
                            <li>Run</li>
                            <li>Nombre completo</li>
                            <li>Correo electrónico</li>
                            <li>Cargo</li>
                            <li>Telefono</li>
                        </ul>
                        <li>
                            Ingresar al link <a href="https://firma.digital.gob.cl/ra/" target="_blank">firma.digital.gob.cl</a>
                            usando su clave única y obtener un certificado de "propósito general".
                        </li>
                        <li>
                            Contactar al ministro de fe Paula Tapia (paula.tapia@redsalud.gob.cl) o
                            Pamela Villagrán (sdga.ssi@redsalud.gob.cl) o
                            José Donoso (jose.donosoc@redsalud.gob.cl) para solicitar la aprobación por parte del ministro de fe.
                        </li>
                        <li>
                            Volver a ingresar a <a href="https://firma.digital.gob.cl/ra/" target="_blank">firma.digital.gob.cl</a>
                            y escanear el código QR de certificado generado, para escanear utilizar alguna aplicación de segundo factor, como Google Authenticator:
                            <a href="https://play.google.com/store/apps/details?id=com.google.android.apps.authenticator2">Android</a> -
                            <a href="https://apps.apple.com/cl/app/google-authenticator/id388497605">iPhone</a>
                        </li>
                    </ol>

                    <p>
                        En caso de consultas, no dude en llamarnos. Teléfono: +56 572409403 / Anexo: 579403
                    </p>

                    <hr class="my-4">
                    <p class="text-right">Contacto:
                        <a href="mailto:{{ env('APP_SS_EMAIL') }}">{{ env('APP_SS_EMAIL') }}</a>
                    </p>
                </div>
            </div>

            <div class="alert alert-light" style="display: none" role="alert" id="developers">
                Hola {{ auth()->user()->firstName }}, soy el sistema <i class="fas fa-cog fa-spin fa-2x" style="color:green"></i>
                , quiero contarte que fui desarrollado el año 2018 por Alvaro Torres y Jorge Miranda
                y hoy día soy mantenido por un excelente equipo de desarrollo del Departamento TIC,
                dónde se incorporó los Estebanes (Rojas + Miranda) y Álvaro Lupa.
                <br>
                El equipo de combate en terreno está formado por
                Gabriela, Cristian, Álvaro, Victor y Miguel.
                <br>
                Nuestro jefe de departamento es el glorioso Don José Don Oso. <br>
                <hr>
                <pre>{{ $phrase ? $phrase->phrase : '' }}</pre>
            </div>
        </div>
    </div>

    <div class="col-sm-4 col-12">
        <img src="{{ asset('images/feliz_navidad.png') }}"
            alt="Logo {{ env('APP_SS') }}"
            class="img-thumbnail mb-3">

        @if($ct_notifications = count(auth()->user()->unreadNotifications))
            <h5 class="text-center" style="background-color: #006FB3; color: #FFFFFF">
                <i class="fas fa-fw fa-bell" title="Notificaciones"></i> Mis Notificaciones sin leer
                <span class="badge badge-secondary">{{ count(auth()->user()->unreadNotifications) }}</span>
            </h5>
            <ul class="list-group">
                @foreach(auth()->user()->unreadNotifications->take(5) as $notification)
                <a href="{{ route('openNotification',$notification) }}" class="list-group-item list-group-item-action small">
                    {{ $notification->created_at }} -
                    {!! $notification->data['icon'] ?? null !!}
                    <b>{{ $notification->data['module'] ?? '' }}</b>
                    {{ $notification->data['subject'] }}
                </a>
                @endforeach
            </ul>

            @if(count(auth()->user()->unreadNotifications) > 5)
            <div class="alert alert-danger mt-2" role="alert">
                <small>
                    <b>Estimado Usuario</b>, Favor atender notificaciones pendientes.
                    <a type="button" class="btn btn-link btn-sm" href="{{ route('allNotifications') }}">
                        Aquí!
                    </a>
                </small>
            </div>
            @endif
        @else
            <h5 class="text-center" style="background-color: #006FB3; color: #FFFFFF">
                <i class="fas fa-fw fa-bell" title="Notificaciones"></i> Mis Notificaciones
            </h5>

            <ul class="list-group">
                @foreach(Auth()->user()->notifications->take(5) as $notification)
                <a href="{{ route('openNotification',$notification) }}" class="list-group-item list-group-item-action small">
                    {{ $notification->created_at }} -
                    {!! $notification->data['icon'] ?? null !!}
                    <b>{{ $notification->data['module'] ?? '' }}</b>
                    {{ $notification->data['subject'] }}
                </a>
                @endforeach
            </ul>

            <div class="alert alert-info mt-2" role="alert">
                <small>
                    <b>Estimado Usuario</b>, puede revisar todas sus notificaciones.
                    <a type="button" class="btn btn-link btn-sm" href="{{ route('allNotifications') }}">
                        Aquí!
                    </a>
                </small>
            </div>
        @endif

        <h5 class="text-center" style="background-color: #006FB3; color: #FFFFFF">
            <i class="far fa-newspaper"></i> Todas las Noticias
        </h5>
        
        <ul class="list-group">
            @foreach($allNews as $news)
                <a href="{{ route('news.show',$news) }}" 
                    class="list-group-item list-group-item-action small">
                    <small><i class="fas fa-calendar-alt"></i> {{ $news->publication_date_at->format('d-m-Y H:i:s') }}</small> <br>
                    <b>{{ $news->title }}</b>
                </a>
             @endforeach  
        </ul>
        
    </div>
</div>

{{--
<div class="bg-light rounded-3 p-3 mb-1 mt-2">
    <div class="container-fluid">

        <h1 class="display-4">Intranet Online</h1>


        <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
            <ol class="carousel-indicators">
                <!-- <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li> -->
                <li data-target="#carouselExampleIndicators" data-slide-to="1" class="active"></li>
                <!-- <li data-target="#carouselExampleIndicators" data-slide-to="2" class=""></li> -->
            </ol>
            <div class="carousel-inner">

                <!-- <div class="carousel-item active">
                    <img src="{{ asset('images/news/new1.png') }}" alt="">
                </div> -->

                <div class="carousel-item active">
                    <!-- <img src="{{ asset('images/news/new2.png') }}" alt="">
                    <div class="carousel-caption d-none d-md-block">
                        <h5 class="text-left">
                            <a href="https://cealsm.suseso.cl/users">Link Encuesta</a>
                        </h5>
                    </div> -->
                </div>

                <!-- <div class="carousel-item">
                    <svg class="bd-placeholder-img bd-placeholder-img-lg d-block w-100" width="800" height="500" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: Third slide" preserveAspectRatio="xMidYMid slice" focusable="false"><title>Placeholder</title><rect width="100%" height="100%" fill="#555"></rect><text x="50%" y="50%" fill="#333" dy=".3em">Third slide</text></svg>
                </div> -->
            </div>
            <button class="carousel-control-prev" type="button" data-target="#carouselExampleIndicators" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-target="#carouselExampleIndicators" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </button>
        </div>

        <hr class="my-4">

        <div class="row mt-4">
            <div class="col-md-3 col-12">
                <!-- <img src="{{ asset('images/tree.jpg') }}" class="img-thumbnail rounded" alt="Arbol de navidad"> -->
                <img src="{{ asset('images/Logo Servicio de Salud Tarapacá - RGB.png') }}"
                    alt="Logo {{ env('APP_SS') }}"
                    class="img-thumbnail mb-3">
                <strong>Logos:</strong>
                <ul>
                    <li>
                        <a href="{{ asset('images/Logo Servicio de Salud Tarapacá - RGB.png') }}" class="text-decoration-none">SST Color</a>
                    </li>
                    <li>
                        <a href="{{ asset('images/Logo Servicio de Salud Tarapacá - Pluma.png') }}" class="text-decoration-none">SST Pluma</a>
                    </li>
                    <li>
                        <a href="{{ asset('images/Logo Hospital Ernesto Torres - RGB.png') }}" class="text-decoration-none">HETG Color</a>
                    </li>
                    <li>
                        <a href="{{ asset('images/Logo Hospital Ernesto Torres - Pluma.png') }}" class="text-decoration-none">HETG Pluma</a>
                    </li>
                    <li>
                        <a href="{{ asset('images/Logo Hospital de Alto Hospicio - RGB.png') }}" class="text-decoration-none">HAH Color</a>
                    </li>
                    <li>
                        <a href="{{ asset('images/Logo Hospital de Alto Hospicio - Pluma.png') }}" class="text-decoration-none">HAH Pluma</a>
                    </li>
                </ul>
            </div>
            <div class="col-9">
                <h6>Pasos para solicitud de Firma Electrónica del Gobierno (OTP) para Funcionarios Visadores y Firmantes</h6>
                <ol>
                    <li>
                        Solicitar mediante un requerimiento en iOnline/SGR, dirigido a Gabriela Aliaga del Departamento de Tecnologías de la Información y Comunicaciones, la creación del usuario <a href="https://firma.digital.gob.cl" target="_blank" class="text-decoration-none">firma.digital.gob.cl</a>. Indicar los siguientes datos:
                    </li>
                    <ul>
                        <li>Run</li>
                        <li>Nombre completo</li>
                        <li>Correo electrónico</li>
                        <li>Cargo</li>
                        <li>Teléfono</li>
                    </ul>
                    <li>
                        Ingresar al link <a href="https://firma.digital.gob.cl/ra/" target="_blank" class="text-decoration-none">firma.digital.gob.cl</a>
                        usando su clave única y obtener un certificado de "propósito general".
                    </li>
                    <li>
                    Contactar al ministro de fe Paula Tapia (paula.tapia@redsalud.gob.cl) o
                    Pamela Villagrán (sdga.ssi@redsalud.gob.cl) o
                    José Donoso (jose.donosoc@redsalud.gob.cl) para solicitar la aprobación por parte del ministro de fe.
                    </li>
                    <li>
                    Volver a ingresar a <a href="https://firma.digital.gob.cl/ra/" target="_blank" class="text-decoration-none">firma.digital.gob.cl</a>
                    y escanear el código QR de certificado generado, para escanear utilizar alguna aplicación de segundo factor, como Google Authenticator:
                    <a href="https://play.google.com/store/apps/details?id=com.google.android.apps.authenticator2" class="text-decoration-none">Android</a> -
                    <a href="https://apps.apple.com/cl/app/google-authenticator/id388497605" class="text-decoration-none">iPhone</a>
                    </li>
                </ol>

                <p>
                    En caso de consultas, no dude en llamarnos. Teléfono: +56 572409403 / Anexo: 579403
                </p>

                <hr class="my-4">

                <div class="d-flex justify-content-end">
                    <p>
                        Contacto:
                        <a href="mailto:{{ env('APP_SS_EMAIL') }}" class="text-decoration-none">{{ env('APP_SS_EMAIL') }}</a>
                    </p>
                </div>
            </div>

        </div>

        @if($ct_notifications = count(auth()->user()->unreadNotifications))
            <h4>{{ $ct_notifications }} notificaciones sin leer</h4>
            <ul>
                @foreach(auth()->user()->unreadNotifications as $notification)
                <li>
                    <a href="{{ route('openNotification',$notification) }}">
                        {{ $notification->created_at }} -
                        {!! $notification->data['icon'] ?? null !!}
                        <b>{{ $notification->data['module'] ?? '' }}</b>
                        {{ $notification->data['subject'] }}
                    </a>
                </li>
                @endforeach
            </ul>
            <hr>
        @endif

        <div class="alert alert-light" style="display: none" role="alert" id="developers">
            Hola {{ auth()->user()->firstName }}, soy el sistema <i class="fas fa-cog fa-spin fa-2x" style="color:green"></i>
            , quiero contarte que fui desarrollado el año 2018 por Alvaro Torres y Jorge Miranda
            y hoy día soy mantenido por un excelente equipo de desarrollo del Departamento TIC,
            dónde se incorporó los Estebanes (Rojas + Miranda) y Álvaro Lupa.
            <br>
            El equipo de combate en terreno está formado por
            Gabriela, Cristian, Álvaro, Victor y Miguel.
            <br>
            Nuestro jefe de departamento es el glorioso Don José Don Oso. <br>
            <hr>
            <pre>{{ $phrase ? $phrase->phrase : '' }}</pre>
        </div>

    </div>
</div>

--}}

@endsection

@section('custom_js')

<script type="text/javascript">
    $(document).ready(function() {
        $("body").keydown(function(event) {
            /* 65=a, 74=j*/
            if (event.which == 65 || event.which == 74) $("#developers").toggle("slow");
        });
    });

    // Cargar Modal
    // $(window).on('load', function() {
    //     $('#modal-news').modal('show');
    // });
</script>

@endsection
