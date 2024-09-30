@extends('layouts.bt5.app')

@section('title', 'Inicio')

@section('content')

    <div class="row">
        <div class="col-2 bg_azul_gob">&nbsp;</div>
        <div class="col-2 bg_rojo_gob"></div>
        <div class="col-2 bg-light"></div>
        <div class="col-2 bg-light"></div>
        <div class="col-2 bg_azul_gob"></div>
        <div class="col-2 bg_rojo_gob"></div>

        <div class="col-12 text-center bg-light">
            <h1 class="color_azul_gob">
                <b>Online</b>
            </h1>
            <h3 class="color_rojo_gob">{{ env('APP_SS', 'Servicio de Salud') }}</h3>
        </div>
    </div>

    <div class="alert alert-light mt-2"
        style="display: none"
        role="alert"
        id="developers">
        Hola {{ auth()->user()->firstName }}, soy el sistema
        <i class="fas fa-cog fa-spin fa-2x"
            style="color:green"></i>
        , quiero contarte que fui desarrollado el año 2018 por Álvaro Torres y Jorge Miranda
        y hoy día soy mantenido por un excelente equipo de desarrollo del Departamento TIC,
        Esteban Rojas e Ignacio Miranda.
        <br>
        El equipo de combate en terreno está formado por
        Gabriela, Álvaro Figueroa y Miguel.
        <br>
        Nuestro jefe de departamento es el glorioso Don Álvaro Lupa Huanca. <br>
        <hr>
        <pre>{{ $phrase ? $phrase->phrase : '' }}</pre>

        <style>
            .logo_ionline {
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
                font-size: 1.5em;
                font-weight: bold;
                color: #006cb7;
            }
            .logo_ionline svg {
                width: 50px;
            }
            .logo_ionline .ionline {
                font-size: 1.2em;
                margin-top: 0px;
            }
            .logo_ionline .plus {
                font-size: 0.7em;
                font-family: 'Brush Script MT', cursive;
                color: #ef4144;
                margin-top: -48px;
                margin-left: 62px;
            }
        </style>
    
        <div class="logo_ionline">
            {!! logoIonline() !!}
            <span class="ionline">iOnline</span>
            <span class="plus">Plus</span>
        </div>
    </div>

    <div class="row pt-2">
        <div class="col-sm-8 col-12">
            @env('production')
            <div id="carouselNews"
                class="carousel slide">
                <div class="carousel-indicators">
                    @foreach ($allNews as $news)
                        <button type="button"
                            data-bs-target="#carouselNews"
                            data-bs-slide-to="{{ $loop->index }}"
                            @if ($loop->index == 0) class="active" @endif
                            aria-current="true"
                            aria-label="Slide {{ $loop->index }}"></button>
                    @endforeach
                </div>
                    <div class="carousel-inner">
                        @foreach ($allNews as $news)
                        <div class="carousel-item @if ($loop->index == 0) active @endif">
                            @if($news->image)
                                <img src="{{ Storage::url($news->image) }}"
                                    class="d-block w-100"
                                    alt="{{ $news->title }}">
                            @endif
                            <strong>{{ $news->created_at }} - {{ $news->title }}</strong>
                            <p>{{ $news->body }}</p>
                            <br>
                        </div>
                        @endforeach
                    </div>
                <button class="carousel-control-prev"
                    type="button"
                    data-bs-target="#carouselNews"
                    data-bs-slide="prev">
                    <span class="carousel-control-prev-icon"
                        aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next"
                    type="button"
                    data-bs-target="#carouselNews"
                    data-bs-slide="next">
                    <span class="carousel-control-next-icon"
                        aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
            @endenv

            <h5 class="text-white p-2 bg_azul_gob mt-3 text-center">
                <i class="fas fa-file-signature"></i>
                Informacion Firma Electrónica
            </h5>

            <div class="mt-4 p-5 text-black rounded bg-light">
                <div class="row">

                    <div class="col-md-3 col-12">
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


                    <div class="col">
                        <h6>Pasos para solicitud de Firma Electrónica del Gobierno (OTP) para Funcionarios Visadores y
                            Firmantes</h6>
                        <ol>
                            <li>
                                Solicitar mediante SGR o correo electrónico, la creación del usuario en firma.digital.gob.cl. Indicando los siguientes datos:
                            </li>
                            <ul>
                                <li>Run</li>
                                <li>Nombre completo</li>
                                <li>Correo electrónico</li>
                                <li>Cargo</li>
                                <li>Teléfono</li>
                            </ul>

                            <br>

                            <p>
                                <b>Funcionarios SST:</b>
                                <br>
                                Dirigir su requerimiento a Gabriela Aliaga.<br>
                                Correo: <a href="mailto:dtic.sst@redsalud.gob.cl">dtic.sst@redsalud.gob.cl</a>
                            </p>

                            <p>
                                <b>Funcionarios HETG:</b><br>
                                Dirigir su requerimiento a: Eric Ossandón.
                                <a href="mailto:eric.ossandon@redsalud.gob.cl">eric.ossandon@redsalud.gob.cl</a>
                            </p>

                            <p>
                                <b>Funcionarios HAH:</b><br>
                                Dirigir su requerimiento a: Bjorn Bergk y Erick Guzmán<br>
                                Correos: <a href="mailto:bjorn.bergk@hah.gob.cl">bjorn.bergk@hah.gob.cl</a> y <a href="mailto:erick.guzman@hah.gob.cl">erick.guzman@hah.gob.cl</a>
                            </p>

                            <li>
                                Ingresar al link <a href="https://firma.digital.gob.cl/ra/"
                                    target="_blank">firma.digital.gob.cl/ra</a>
                                usando su clave única y obtener un certificado digital de "propósito general".
                            </li>
                            <br>
                            <li>
                                Esperar la Autorización de su certificado por parte de un ministro de fe de SST. Luego usted recibirá un correo electrónico a la dirección informada inicialmente, informando sobre su aprobación.
                            </li>
                            <br>
                            <li>
                                Volver a ingresar a <a href="https://firma.digital.gob.cl/ra/"
                                    target="_blank">firma.digital.gob.cl</a>
                                y escanear el código QR de certificado generado, para escanear utilizar alguna aplicación de
                                segundo factor, como Google Authenticator:
                                <a
                                    href="https://play.google.com/store/apps/details?id=com.google.android.apps.authenticator2">Android</a>
                                -
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
            </div>

            <h5 class="text-white p-2 bg_azul_gob mt-3 text-center">
                <i class="fas fa-file-signature"></i>
                Agendar hora - Unidad Salud del Trabajador
            </h5>

            <div class="mt-4 p-5 text-black rounded bg-light">

                <h6>En el siguiente video podrá visualizar como realizar un agendamiento en la unidad de salud del trabajador. Para acceder al módulo presionar <a href="{{ route('prof_agenda.home') }}">aquí</a>.</h6>
                <br>
                <div class="row">
                    <fieldset class="form-group col-12 col-md-12">
                        <iframe src="https://drive.google.com/file/d/1O7YFz0EzEI37uFQuUOoYW0OjBVCgiCBH/preview" width="100%" height="315" allow="autoplay; fullscreen" allowfullscreen></iframe>
                    </fieldset>
                </div>
            </div>

            <!-- Se restringe la visualización a usuarios de bienestar y administradores -->
            @if(auth()->user()->welfare || auth()->user()->can('be god') || auth()->user()->can('welfare: amipass') || auth()->user()->can('welfare: balance'))
                <h5 class="text-white p-2 bg_azul_gob mt-3 text-center">
                    <i class="fas fa-file-signature"></i>
                    Reserva de cabañas - Bienestar
                </h5>

                <div class="mt-4 p-5 text-black rounded bg-light">

                    <h6>En el siguiente video podrá visualizar como realizar una reserva de cabañas del área de Bienestar. Para acceder al módulo presionar <a href="{{ route('welfare.index') }}">aquí</a>.</h6>
                    <br>
                    <div class="row">
                        <fieldset class="form-group col-12 col-md-12">
                            <iframe src="https://drive.google.com/file/d/1YsmCsLqlfcdSqODBUwtUb3xoDdSMzljo/preview" width="100%" height="315" allow="autoplay; fullscreen" allowfullscreen></iframe>
                        </fieldset>
                    </div>
                </div>

                <h5 class="text-white p-2 bg_azul_gob mt-3 text-center">
                    <i class="fas fa-file-signature"></i>
                    Solicitud de beneficios - Bienestar
                </h5>

                <div class="mt-4 p-5 text-black rounded bg-light">

                    <h6>En el siguiente video podrá visualizar como realizar una solicitud de beneficios al área de Bienestar. Para acceder al módulo presionar <a href="{{ route('welfare.index') }}">aquí</a>.</h6>
                    <br>
                    <div class="row">
                        <fieldset class="form-group col-12 col-md-12">
                            <iframe src="https://drive.google.com/file/d/1lh2YXr6WW_XwYNWodIyFwhq6iu8euoAB/preview" width="100%" height="315" allow="autoplay; fullscreen" allowfullscreen></iframe>
                        </fieldset>
                    </div>
                </div>
            @endif
            
        </div>

        <div class="col-sm-4 col-12">

            @if ($ct_notifications = count(auth()->user()->unreadNotifications))
                <h5 class="text-center text-white bg_azul_gob p-2">
                    <i class="bi bi-bell"
                        title="Notificaciones"></i> Mis notificaciones sin leer
                    <span class="badge text-bg-danger">
                        {{ count(auth()->user()->unreadNotifications) }}
                    </span>
                </h5>
                <ul class="list-group">
                    @foreach (auth()->user()->unreadNotifications->where('type', '!=', 'Filament\Notifications\DatabaseNotification')->take(7) as $notification)
                        <a href="{{ route('openNotification', $notification) }}"
                            class="list-group-item list-group-item-action small">
                            {{ $notification->created_at }} -
                            {!! $notification->data['icon'] ?? null !!}
                            <b>{{ $notification->data['module'] ?? '' }}</b>
                            @if( array_key_exists('subject',$notification->data) )
                            {!! $notification->data['subject'] !!}
                            @endif
                        </a>
                    @endforeach
                </ul>

                @if (count(auth()->user()->unreadNotifications) > 7)
                    <div class="alert alert-danger mt-2"
                        role="alert">
                        <small>
                            <b><i class="bi bi-exclamation-triangle"></i> Favor atender sus
                                <a href="{{ route('allNotifications') }}">notificaciones pendientes.</a>
                            </b>
                        </small>
                    </div>
                @endif
            @else
                <h5 class="text-center text-white p-2 bg_azul_gob">
                    <i class="fas fa-fw fa-bell"
                        title="Notificaciones"></i> Mis Notificaciones
                </h5>

                <ul class="list-group">
                    @foreach (auth()->user()->notifications->take(7) as $notification)
                        <a href="{{ route('openNotification', $notification) }}"
                            class="list-group-item list-group-item-action small">
                            {{ $notification->created_at }} -
                            {!! $notification->data['icon'] ?? null !!}
                            <b>{{ $notification->data['module'] ?? '' }}</b>
                            {!! $notification->data['subject'] !!}
                        </a>
                    @endforeach
                </ul>

                <div class="alert alert-info mt-2"
                    role="alert">
                    <small>
                        <b>Puede revisar
                            <a href="{{ route('allNotifications') }}">
                                todas sus notificaciones.
                            </a>
                        </b>
                    </small>
                </div>
            @endif

            <h5 class="text-center text-white p-2 bg_azul_gob">
                <i class="bi bi-newspaper"></i> Todas las Noticias
            </h5>

            <ul class="list-group">
                @foreach ($allNews as $news)
                    <p class="list-group-item list-group-item-action small">
                        <small><i class="fas fa-calendar-alt"></i>
                            {{ $news->created_at->format('d-m-Y H:i:s') }}</small> <br>
                        <b>{{ $news->title }}</b>
                    </p>
                @endforeach
            </ul>

            <h5 class="text-center text-white p-2 bg_azul_gob mt-3">
                <i class="bi bi-file-text"></i> Manuales
            </h5>

            <ul class="list-group">
                @foreach ($manuals as $manual)
                    <a href="{{ Storage::url($manual->file) }}"
                        class="list-group-item list-group-item-action small"
                        target="_blank">
                        {{ $manual->title }}<i> V: {{ number_format($manual->version,1,'.','') }} </i>
                    </a>
                @endforeach

                <a href="https://docs.google.com/document/d/1FMhKIgpKiEjTcez887z_8fKOmYXGaQ21/edit?usp=sharing&ouid=100875180090664492720&rtpof=true&sd=true"
                    class="list-group-item list-group-item-action small" target="_blank">
                    Bienestar - Solicitud de beneficios.
                </a>
                <a href="https://docs.google.com/document/d/1UzWY4S5DXlgnYAhbtNhgGiYmP3R9UyxJ/edit?usp=sharing&ouid=100875180090664492720&rtpof=true&sd=true"
                    class="list-group-item list-group-item-action small" target="_blank">
                    Bienestar - Reserva de cabañas.
                </a>
                <a href="https://docs.google.com/document/d/1Mqx_1KxClnLT-7JGbrxD6lfdPWXuNBcH/edit?usp=sharing&ouid=100875180090664492720&rtpof=true&sd=true"
                    class="list-group-item list-group-item-action small" target="_blank">
                    Creación de formularios de requerimiento.
                </a>
                <a href="https://drive.google.com/file/d/1dB7AYItL__aqTT--lPN0VKJmGJ_NY9l0/view?usp=sharing"
                    class="list-group-item list-group-item-action small" target="_blank">
                    Solicitud Firma Electrónica
                </a>
                <a href="https://drive.google.com/file/d/1aDgBnJRX4qT9vPejYcZ-4Zn4QUZHrcz0/view?usp=sharing"
                    class="list-group-item list-group-item-action small" target="_blank">
                    Módulo de Farmacias
                </a>
                <a href="https://docs.google.com/document/d/1r6zJhOMQYL8JiFlDJL2PtXeyu_bvggKCmLBomKjc24g/edit"
                    class="list-group-item list-group-item-action small" target="_blank">
                    Solicitud de Firmas iOnline
                </a>
            </ul>

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
