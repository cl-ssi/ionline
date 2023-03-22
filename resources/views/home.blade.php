@extends('layouts.app')

@section('title', 'Hogar')

@section('content')

<!-- <style>
    .jumbotron {
        background-image: linear-gradient(to bottom, rgba(255,255,255,0) 0%,rgba(255,255,255,1) 100%), url("../images/new-year-2023.jpg");
        background-size: cover;
    }
</style> --> 

<div class="jumbotron mt-4">
    <div class="row">
        <div class="col-9">
            <h1 class="display-4">Intranet Online</h1>
            <p class="lead">{{ env('APP_SS') }}</p>

            <!-- <p class="h3 font-italic font-weight-bold text-primary">
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                El Departamento TIC del Servicio de Salud <br>
                te desea una feliz navidad y un prospero año nuevo <br>
                junto a todos tus seres queridos, ❤ <br>
                lleno de salud, alegría y lo que tú estes buscando. <br>
                <br>
                <br>
            </p> -->

            <hr class="my-4">

            <p>Contacto:
                <a href="mailto:{{ env('APP_SS_EMAIL') }}">{{ env('APP_SS_EMAIL') }}</a>
            </p>

            <!-- <div class="alert alert-info" role="alert">
                <p class="font-italic font-weight-bold">
                    <i class="fas fa-gift text-danger"></i>
                    Feliz navidad te desea el glorioso Departamento Tic
                    <i class="fas fa-sleigh text-danger"></i> 
                </p>
            </div> -->

        </div>
        <div class="col-md-3 col-12">
            <!-- <img src="{{ asset('images/tree.jpg') }}" class="img-thumbnail rounded" alt="Arbol de navidad"> -->
            <img src="{{ asset('images/logo_blanco.png') }}" alt="Logo {{ env('APP_SS') }}" style="background-color: rgb(0, 108, 183);" class="img-thumbnail">
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
        Yeannett, Cristian, Álvaro y Erick (si, hay tres Álvaros en el departamento).
        <br>
        Nuestro jefe de departamento es el glorioso Don José Don Oso. <br>
        <hr>
        <pre>{{ $phrase ? $phrase->phrase : '' }}</pre>
    </div>


    <h6>Pasos para solicitud de Firma Electrónica del Gobierno (OTP) para Funcionarios Visadores y Firmantes</h6>
    <ol>
        <li>
            Solicitar a Yeannett del Departamento Tic (tic.ssi@redsalud.gob.cl) o 
            Pamela Villagrán la creación del usuario firma.digital.gob.cl indicando los siguientes datos:
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
</script>

@endsection
