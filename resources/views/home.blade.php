@extends('layouts.app')

@section('title', 'Home')

@section('content')

<style>
    .jumbotron {
    background-image: url("{{ asset('images/new-year.webp') }}");
    background-size: cover;
    /* opacity: 0.5; */
}
</style>
<div class="jumbotron mt-4 text-light">
    <div class="row">
        <div class="col-6">
            <!-- <h1 class="display-4">Intranet Online</h1> -->
            <!-- <p class="lead">{{ env('APP_SS') }}</p> -->
            <h2 class="display-4"></h2>
            <p class="lead">
            <br><br><br><br><br><br><br><br>

                <br><br><br><br><br><br>
            </p>
            
            <hr class="my-4">

            <p>Contacto:
                <a href="mailto:{{ env('APP_SS_EMAIL') }}">{{ env('APP_SS_EMAIL') }}</a>
            </p>
            <!-- <ol>
                <h6>Pasos para solicitud de Firma Electrónica del Gobierno (OTP)</h6>
                <li>
                Solicitar a Yeannett Valdivia o Pamela Villagrán crear usuario en sistema de firma digital.
                </li>
                <li>
                Ingresar al link <a href="https://firma.digital.gob.cl/ra/" target="_blank">firma.digital.gob.cl</a> usando clave única y obtener un certificado de "propósito general".
                </li>
                <li>
                Contactar al ministro de fe Paula Tapia o José Donoso para solicitar la aprobación por parte del ministro de fe.
                </li>
                <li>
                Volver a ingresar a <a href="https://firma.digital.gob.cl/ra/" target="_blank">firma.digital.gob.cl</a> y escanear el código QR de certificado generado, para escanear utilizar alguna aplicación autentificadora, ejemplo Google Authenticator.<br>
                <a href="https://play.google.com/store/apps/details?id=com.google.android.apps.authenticator2">Android</a><br>
                <a href="https://apps.apple.com/cl/app/google-authenticator/id388497605">I-Phone</a>
                </li>
            </ol> -->
        </div>
        <div class="col-md-3 col-12">
            <!-- <img src="{{ asset('images/christmas-tree.jpg') }}" class="img-thumbnail rounded" alt="Arbol de navidad">
            <img src="{{ asset('images/logo_blanco.png') }}" alt="Logo {{ env('APP_SS') }}" style="background-color: rgb(0, 108, 183);" class="img-thumbnail"> -->
        </div>
    </div>

    <div class="alert alert-light" style="display: none" role="alert" id="developers">
        Hola {{ auth()->user()->firstName }}, soy el sistema <i class="fas fa-cog fa-spin fa-2x" style="color:green"></i>
        , quiero contarte que fui desarrollado el año 2018 por <a href="mailto:alvaro.torres@redsalud.gob.cl">
            Alvaro Torres</a> y <a href="mailto:jorge.mirandal@redsalud.gob.cl">Jorge Miranda</a>
        y hoy día soy mantenido por un excelente equipo de desarrollo del Departamento TIC,
        dónde se incorporó los Estebanes (Rojas + Miranda), Germán Zuñiga y Álvaro Lupa.
        <br>
        El equipo de combate en terreno está formado por
        Yeannett, Adriana, Cristian y Álvaro (si, hay tres Álvaros en el departamento).
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
    </script>

    @endsection
