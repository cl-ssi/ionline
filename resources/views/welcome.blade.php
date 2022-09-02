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
        <p class="text-muted mt-4">Bienvenido a la intranet del Servicio de Salud de Iquique.</p>

    </div>

    <div class="container">
        <div class="card-deck mb-3 text-center">


		<div class="card shadow-sm">
				<div class="card-header">
					<h4 class="my-0 font-weight-normal text-center">Ingreso al iOnline</h4>
				</div>
				<div class="card-body">
					<!-- Código para visualizar botón oficial iniciar sesión con ClaveÚnica-->
					<a class="btn-cu btn-m btn-color-estandar m-auto" 
						href="{{ route('claveunica.autenticar') }}?redirect=L2NsYXZldW5pY2EvbG9naW4="
						title="Este es el botón Iniciar sesión de ClaveÚnica">
						<span class="cl-claveunica"></span>
						<span class="texto">Iniciar sesión</span>
					</a>
					<!--./ fin botón-->

				
				<hr>
				
				<form method="POST" action="{{ route('login') }}">
					@csrf
					<div class="form-group row">
						<label for="id" class="col-md-4 form-label">{{ __('RUN') }}</label>
						<div class="col-md-8">
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
						<label for="password" class="col-md-4 form-label">{{ __('Clave') }}</label>
						<div class="col-md-8">
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
						<div class="col-md-4 offset-md-4">
							<div class="form-check">
								<input class="form-check-input" type="checkbox" name="remember" id="remember" value=1 {{ old('remember') ? 'checked' : '' }}>
								<label class="form-check-label" for="remember">{{ __('Recuerdame') }}</label>
							</div>
						</div>
					</div>

					<div class="form-group row">
						<div class="col-md-12 m-auto">
							<button type="submit" class="btn btn-secondary pr-4 pl-4">
								{{ __('Iniciar sesión') }}
							</button>
						</div>
					</div>
				</form>


				</div>
			</div>


            <div class="card shadow-sm">
                <div class="card-header">
                    <h4 class="my-0 font-weight-normal">Resultado exámenes PCR</h4>
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
						<a href="https://i.saludiquique.cl" class="btn btn-info btn-block disabled">iOnline</a>
					</li>
					<li class="list-group-item">
						<a href="{{ route('login') }}/external" class="btn btn-outline-info btn-block">Externos</a>
					</li>
					<li class="list-group-item">
						<a href="https://neo.saludtarapaca.gob.cl" class="btn btn-outline-info btn-block">NeoSalud</a>
					</li>
					<li class="list-group-item">
						<a href="https://uni.saludtarapaca.gob.cl" class="btn btn-outline-info btn-block">Unisalud</a>
					</li>
					<li class="list-group-item">
						<a href="https://esmeralda.saludtarapaca.org" class="btn btn-outline-info btn-block">Esmeralda</a>
					</li>
					<li class="list-group-item">
						<a href="{{ route('claveunica.autenticar') }}?redirect=L3NpcmVteC9sb2dpbmN1" class="btn btn-outline-info btn-block">Sirmx</a>
					</li>
                </ul>
            </div>

        </div>

        <footer class="pt-4 my-md-5 pt-md-5 border-top">
            <div class="row">
                <div class="col-12 col-md">
                    <img class="mb-2" src="{{ asset('images/logo_ssi_100px.png') }}" alt="Logo Servicio de Salud Iquique">
                </div>
                <div class="col-6 col-md">

                </div>
                <div class="col-6 col-md">

                </div>
                <div class="col-6 col-md">
                    <h5>Desarrollado por</h5>
                    <ul class="list-unstyled text-small">
                        <li>Departamento TIC del SSI</li>
                        <li><a class="text-muted" href="mailto:sistemas.ssi@redsalud.gobc.">sistemas.ssi@redsalud.gob.cl</a></li>
                        <small class="d-block mb-3 text-muted"> 2021</small>
                    </ul>
                </div>
            </div>
        </footer>
    </div>


</body>

</html>
