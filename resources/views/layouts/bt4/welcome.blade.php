<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Sitio web del {{ env('APP_SS') }}">
    <meta name="author" content="Servicio de Salud Tarapacá">
    <title>{{ config('app.name') }}</title>

    <!-- Styles -->
    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css"
        integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l"
        crossorigin="anonymous">
    <link href="{{ asset('css/cu.min.css') }}" rel="stylesheet">

    <!-- Favicons -->
    <meta name="theme-color" content="#563d7c">

    <style>
        h1 {
            font-family: Sans-serif;
            font-weight: 200;
            color: #006fb3;
            font-size: 2.4rem;
        }
        .gb_azul {
            color: #006fb3;
        }
        .gb_rojo {
            color: #fe6565;
        }
        @media (min-width: 768px) {
            .bd-placeholder-img-lg {
                font-size: 3.5rem;
            }
        }

        .bg-nav-gobierno {
            @switch(env('APP_ENV'))
                @case('local') background-color: rgb(73, 17, 82) !important; @break
                @case('testing') background-color: rgb(2, 82, 0) !important; @break
            @endswitch
        }
    </style>

    <!-- Place your kit's code here -->
    <script src="https://kit.fontawesome.com/7c4f606aba.js" SameSite="None"
        crossorigin="anonymous"></script>
</head>

<body>
    <div class="d-flex flex-column flex-md-row align-items-center p-3 px-md-4 mb-3 bg-white border-bottom shadow-sm container bg-nav-gobierno">
        <h5 class="my-0 mr-md-auto font-weight-normal"> <img src="{{ asset('images/gob-header.svg') }}" alt="Logo del gobierno de chile"> </h5>
        <nav class="my-2 my-md-0 mr-md-3">
            <a class="p-2 text-dark" href="http://www.saludtarapaca.gob.cl">Web Servicio de Salud</a>
        </nav>

    </div>

    <div class="pricing-header px-3 py-3 pt-md-5 pb-md-4 mx-auto text-center container">
        <h1 class="display-5 mb-3">{{ env('APP_NAME') }} - {{ env('APP_SS') }}</h1>
        <div class="d-flex justify-content-center">
            <table class="align-self-center">
                <tr>
                    <td style="background-color: #006fb3;" width="300" height="6"></td>
                    <td style="background-color: #fe6565;" width="300" height="6"></td>
                </tr>
            </table>
        </div>
        <p class="text-muted mt-4">Bienvenido a la intranet del {{ env('APP_SS') }}.</p>
        @include('layouts.bt4.partials.errors')
        @include('layouts.bt4.partials.flash_message')

    </div>

    <div class="container">
        <div class="card-deck mb-3">

            <div class="card shadow-sm">
                <div class="card-header">
                    <h4 class="my-0 font-weight-normal text-center">Ingreso al sistema</h4>
                </div>
                <div class="card-body">

                    <h6 class="mb-3 text-center">Utilizando tu Clave Única</h6>

                    <!-- Código para visualizar botón oficial iniciar sesión con ClaveÚnica-->
                    <a class="btn-cu  btn-m btn-color-estandar m-auto"
                        href="{{ route('claveunica.autenticar') }}"
                        title="Este es el botón Iniciar sesión de ClaveÚnica">
                        <span class="cl-claveunica"></span>
                        <span class="texto">Iniciar sesión</span>
                    </a>
                    <!--./ fin botón-->

                
                <hr>
                
                <h6 class="mb-3 text-center">Con tu cuenta del sistema</h6>

                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="form-group row">
                        <label for="id" class="col-4 col-md-4 col-form-label text-right">{{ __('RUN') }}</label>
                        <div class="col-8 col-md-6">
                            <input id="id" type="text" class="form-control @error('id') is-invalid @enderror"
                                name="id" value="{{ old('id') }}" required autofocus>
                            @error('id')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="password" class="col-4 col-md-4 col-form-label text-right">{{ __('Clave') }}</label>
                        <div class="col-8 col-md-6">
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" 
                                name="password" required autocomplete="current-password">
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>


                    <div class="form-group row">
                        <div class="col-8 offset-2">
                            <div class="form-check">
                                <a class="card-link" href="{{route('password.request')}}">{{ __('¿Olvido su contraseña?') }}</a>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-8 offset-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember" value=1 {{ old('remember') ? 'checked' : '' }}>
                                <label class="form-check-label" for="remember">{{ __('Recuerdame') }}</label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-8 col-md-6 offset-4">
                            <button type="submit" class="btn btn-secondary btn-block">
                                {{ __('Iniciar sesión') }}
                            </button>
                        </div>
                    </div>
                </form>


                </div>
            </div>

            @if(env('APP_SS_ID') == 2)
                <div class="card shadow-sm">
                    <div class="card-header">
                        <h4 class="my-0 font-weight-normal text-center">Resultado exámenes</h4>
                    </div>
                    <div class="card-body">

                        <ul class="list-unstyled mt-3 mb-4 text-center">
                            <p>Si perteneces a la región de Tarapacá, puedes revisar
                                el resultado de tu exámen de Covid-19 utilizando tu
                                clave única del estado, haciendo click en el botón
                                de abajo.</p>

                        </ul>
                        <div class="row justify-content-center">
                            <a class="btn btn-primary" href="https://esmeralda.saludtarapaca.gob.cl">
                                Resultado Exámenes
                            </a>
                        </div>


                        <hr>

                        <h6 class="mb-3">Otros links de interés</h6>
                        
                        <a class="card-link" href="{{ route('rrhh.users.directory') }}">
                            <i class="fas fa-fw fa-address-book"></i>
                            Directorio telefónico
                        </a>

                        <br>
                        
                        <a class="card-link" href="{{ route('indicators.index') }}">
                            <i class="fas fa-fw fa-chart-pie"></i>
                            Metas sanitarias
                        </a>

                        <br>

                        <a class="card-link" href="{{ route('invoice.welcome') }}">
                            <i class="fas fa-fw fa-file-invoice"></i>
                            Honorarios (subir boletas)
                        </a>

                    </div>
                </div>



                <div class="card shadow-sm">
                    <div class="card-header">
                        <h4 class="my-0 font-weight-normal">
                            <a href="https://portal.saludtarapaca.gob.cl" class="btn btn-secondary btn-block">Portal de sistemas</a>
                        </h4>
                    </div>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">
                            <a href="https://i.saludtarapaca.gob.cl" class="btn btn-info btn-block disabled">iOnline</a>
                        </li>
                        <li class="list-group-item">
                            <a href="{{ route('login') }}/external" class="btn btn-outline-info btn-block">Externos</a>
                        </li>
                        <li class="list-group-item">
                            <a href="https://neo.saludtarapaca.gob.cl" class="btn btn-outline-info btn-block">NeoSalud</a>
                        </li>
                        <li class="list-group-item">
                            <a href="https://uni.saludtarapaca.gob.cl" class="btn btn-outline-info btn-block">UniSalud</a>
                        </li>
                        <li class="list-group-item">
                            <a href="https://esmeralda.saludtarapaca.gob.cl" class="btn btn-outline-info btn-block">Esmeralda</a>
                        </li>
                        <li class="list-group-item">
                            <a href="https://siremx.saludtarapaca.gob.cl" class="btn btn-outline-info btn-block">Siremx</a>
                            <!--a href="{{ route('claveunica.autenticar') }}/L3NpcmVteC9sb2dpbmN1" class="btn btn-outline-info btn-block">Siremx</a-->
                        </li>
                    </ul>
                </div>
            @endif

        </div>

        <footer class="pt-4 my-md-5 pt-md-5 border-top">
            <div class="row">
                <div class="col-3 col-md-3">
                    <img class="mb-2" src="{{ asset('images/logo_sst_100px.png') }}" alt="Logo Servicio de Salud Tarapacá">
                </div>
                <div class="col-1 col-md-6">

                </div>
                <div class="col-7 col-md-3">
                    <h5>Desarrollado por</h5>
                    <ul class="list-unstyled text-small">
                        <li>Departamento TIC del SST</li>
                        <li><a class="text-muted" href="mailto:sistemas.sst@redsalud.gobc.">sistemas.sst@redsalud.gob.cl</a></li>
                        <small class="d-block mb-3 text-muted">2021</small>
                    </ul>
                </div>
            </div>
        </footer>
    </div>


</body>

</html>
