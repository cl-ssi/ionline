@extends('layouts.app')

@section('title', 'Inicio')

@section('content')




<!-- <style>
    .jumbotron {
        background-image: linear-gradient(to bottom, rgba(255,255,255,0) 0%,rgba(255,255,255,1) 100%), url("../images/new-year-2023.jpg");
        background-size: cover;
    }
</style> -->



<div class="jumbotron mt-4 pt-2">
    <h1 class="display-4">Intranet Online</h1>


    <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators">
            <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
            <!-- <li data-target="#carouselExampleIndicators" data-slide-to="1" class=""></li> -->
            <!-- <li data-target="#carouselExampleIndicators" data-slide-to="2" class=""></li> -->
        </ol>
        <div class="carousel-inner">

            <div class="carousel-item active">
                <img src="{{ asset('images/news/new1.png') }}" alt="">
            </div>

            <!-- <div class="carousel-item">
                <img src="{{ asset('images/news/new2.png') }}" alt="">
            </div> -->

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
        <div class="col-9">
            <h6>Pasos para solicitud de Firma Electrónica del Gobierno (OTP) para Funcionarios Visadores y Firmantes</h6>
            <ol>
                <li>
                    Solicitar a Gabriela Aliaga del Departamento Tic (dtic.sst@redsalud.gob.cl), Yeannett Valdivia (sda.ssi@redsalud.gob.cl)
                    o Pamela Villagrán (sdga.ssi@redsalud.gob.cl) la creación del usuario firma.digital.gob.cl indicando los siguientes datos:
                </li>
                <ul>
                    <li>Run</li>
                    <li>Nombre completo</li>
                    <li>Correo electrónico</li>
                    <li>Cargo</li>
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

            <hr class="my-4">
            <p class="text-right">Contacto:
                <a href="mailto:{{ env('APP_SS_EMAIL') }}">{{ env('APP_SS_EMAIL') }}</a>
            </p>

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
