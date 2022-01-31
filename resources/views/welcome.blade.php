<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Sitio web del Servicio de Salud Iquique">
    <meta name="author" content="Alvaro Torres Fuchslocher">
    <title>{{ config('app.name') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
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
            <a class="p-2" href="http://www.saludiquique.cl">Servicio de Salud Iquique</a>
        </nav>

    </div>

    <div class="pricing-header px-3 py-3 pt-md-5 pb-md-4 mx-auto text-center container">
        <h1 class="display-5 mb-3">{{ env('APP_SS') }}</h1>
        <div class="d-flex justify-content-center">
            <table class="align-self-center">
                <tr>
                    <td style="background-color: #006fb3;" width="300" height="6"></td>
                    <td style="background-color: #fe6565;" width="300" height="6"></td>
                </tr>
            </table>
        </div>
        <p class="text-muted mt-4">Bienvenido al portal de sistemas del Servicio de Salud de Iquique.</p>

    </div>

    <div class="container">
        <div class="card-deck mb-3 text-center">

            <div class="card shadow-sm">
                <div class="card-header">
                    <h4 class="my-0 font-weight-normal">Resultado exámenes</h4>
                </div>
                <div class="card-body">

                    <ul class="list-unstyled mt-3 mb-4">
                        <p>Si perteneces a la región de Tarapacá, puedes revisar
                            el resultado de tu exámen de Covid-19 utilizando tu
                            clave única del estado, haciendo click en el botón
                            de abajo.</p>

                    </ul>
                    <div class="row justify-content-center">
                    <!-- Código para visualizar botón oficial iniciar sesión con ClaveÚnica-->
                    <a class="btn-cu btn-m  btn-color-estandar" href="{{ route('claveunica.autenticar') }}?redirect=L21vbml0b3IvbGFiL2xvZ2lu"
                        title="Este es el botón Iniciar sesión de ClaveÚnica">
                        <span class="cl-claveunica"></span>
                        <span class="texto">Iniciar sesión</span>
                    </a>
                    <!--./ fin botón-->
                    </div>

                    <br>
                    <hr class="">
                    <a href="{{ route('vaccination.welcome')}}">Vacunación funcionarios de salud</a>
                </div>
            </div>

            <div class="card shadow-sm">
                <div class="card-header">
                    <h4 class="my-0 font-weight-normal">Estado de urgencias (No disponible Temporalmente)</h4>
                </div>
                <div class="card-body">
                <br>
                <br>
                <br>
                <i class="fas fa-clock fa-5x"></i>
                </div>
<!-- 
                @php($array = json_decode(file_get_contents('status.json'),true))

                <p class="text-muted mt-2 mb-2">Ultima actualización: {{ $array['updated'] }}</p>

                <table class="table table-sm">
                    <tr>
                        <th>Establecimiento</th>
                        <th>En espera</th>
                        <th>En box</th>
                    </tr>
                    @foreach($array['data'] as $nombre => $element)
                        <tr>
                            <td>{{ $nombre }}</td>
                            <td>{{ $element['En espera'] }}</td>
                            <td>{{ $element['En box'] }}</td>
                        </tr>
                    @endforeach
                </table> -->

            </div>

            <div class="card shadow-sm">
                <div class="card-header">
                    <h4 class="my-0 font-weight-normal">Nuestros sistemas</h4>
                </div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item list-group-item-action">
                        <a class="btn btn-outline-primary btn-block" href="{{ route('login') }}/external">Portal Externos</a>
                    </li>
                    <li class="list-group-item list-group-item-action">
                        <a class="btn btn-outline-primary btn-block" href="{{ route('claveunica.autenticar') }}?redirect=L3NpcmVteC9sb2dpbmN1">Sirmx</a>
                    </li>
                    <li class="list-group-item list-group-item-action">
                        <a class="btn btn-outline-primary btn-block" href="http://intranet.saludiquique.cl">Intranet</a>
                    </li>
                    <li class="list-group-item list-group-item-action">
                        <a class="btn btn-outline-primary btn-block" href="{{ route('login') }}">iOnline</a>
                    </li>
                    <hr class="">
                </ul>
            </div>

        </div>

        <footer class="pt-4 my-md-5 pt-md-5 border-top">
            <div class="row">
                <div class="col-12 col-md">
                    <img class="mb-2" src="{{ asset('images/logo_ssi_100px.png') }}" alt="Logo Servicio de Salud Iquique">
                </div>
                <div class="col-6 col-md">
                    <h5>Portales del estado</h5>
                    <ul class="list-unstyled text-small">
                        <li><a class="text-muted" href="http://www.gob.cl">Gobierno de Chile</a></li>
                        <li><a class="text-muted" href="http://www.minsal.cl">Ministerio de Salud</a></li>
                        <li><a class="text-muted" href="http://www.saludiquique.cl">Servicio de Salud Iquique</a> </li>
                    </ul>
                </div>
                <div class="col-6 col-md">
                    <h5>Relacionados</h5>
                    <ul class="list-unstyled text-small">
                        <li><a class="text-muted" href="https://www.gob.cl/coronavirus/">Coronavirus</a></li>
                        <li><a class="text-muted" href="https://www.gob.cl/coronavirus/cifrasoficiales/">Cifras oficiales coronavirus</a> </li>
                        <li><a class="text-muted" href="https://www.gob.cl/plannacionaldecancer/">Plan nacional de cancer</a></li>

                    </ul>
                </div>
                <div class="col-6 col-md">
                    <h5>Desarrollado por</h5>
                    <ul class="list-unstyled text-small">
                        <li>Departamento TIC SSI</li>
                        <li><a class="text-muted" href="mailto:sistemas.ssi@redsalud.gobc.">sistemas.ssi@redsalud.gob.cl</a></li>
                        <small class="d-block mb-3 text-muted">&copy; 2021</small>
                    </ul>
                </div>
            </div>
        </footer>
    </div>
    <!-- <div class="text-center">
        Sistema de Mamografias
        <a href="{{ route('claveunica.autenticar') }}?redirect=L3NpcmVteC9sb2dpbmN1">
            <img src="{{ asset('images/btn_claveunica_119px.png') }}" alt="Logo Clave única">
        </a>
    </div> -->

</body>

</html>
