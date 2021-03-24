@extends('layouts.app')

@section('content')

<link href="{{ asset('css/cu.min.css') }}" rel="stylesheet">

<div class="container">
    <div class="text-center">
        @isset($url)
        <h4>Sistemas para personas external al {{ env('APP_SS') }}</h4>
        @else
        <h4>iOnline del {{ env('APP_SS') }}</h4>
        @endisset
    </div>
    <div class="row justify-content-center">
        <div class="mt-4">
            <!-- Código para visualizar botón oficial iniciar sesión con ClaveÚnica-->
            @isset($url)
            <a class="btn-cu btn-m btn-color-estandar" href="{{ route('claveunica.autenticar') }}?redirect=L2NsYXZldW5pY2EvbG9naW4tZXh0ZXJuYWw="
                title="Este es el botón Iniciar sesión de ClaveÚnica">
                <span class="cl-claveunica"></span>
                <span class="texto">Externo</span>
            </a>
            @else
            <a class="btn-cu btn-m btn-color-estandar" href="{{ route('claveunica.autenticar') }}?redirect=L2NsYXZldW5pY2EvbG9naW4="
                title="Este es el botón Iniciar sesión de ClaveÚnica">
                <span class="cl-claveunica"></span>
                <span class="texto">Iniciar sesión</span>
            </a>
            @endisset
            <!--./ fin botón-->
        </div>
    </div>
    <div class="row justify-content-center mt-4">
        <div class="col-md-8 d-none" id="local_login">
            <div class="card">
                <div class="card-header justify-content-center">
                    <h5> {{ isset($url) ? ucwords($url) : ""}} {{ __('Login') }} </h5>
                </div>
                <div class="card-header">{{ __('Iniciar sesión')  }} {{ isset($url) ? ucwords($url) : ""}}</div>

                <div class="card-body">
                    @isset($url)
                    <form method="POST" action='{{ url("login/$url") }}'>
                        @else
                        <form method="POST" action="{{ route('login') }}">
                            @endisset
                            @csrf

                            <div class="form-group row">
                                <label for="id" class="col-md-4 col-form-label text-md-right">{{ __('RUN') }}</label>

                                <div class="col-md-6">
                                    <input id="id" type="text" class="form-control @error('id') is-invalid @enderror" name="id" value="{{ old('id') }}" required autofocus>

                                    @error('id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Clave') }}</label>

                                <div class="col-md-6">
                                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-6 offset-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                        <label class="form-check-label" for="remember">
                                            {{ __('Recordarme') }}
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Iniciar Sesión') }}
                                    </button>

                                    @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Recordar Clave') }}
                                    </a>
                                    @endif
                                </div>
                            </div>
                        </form>
                </div>
            </div>
        </div>
    </div>
    <div class="row justify-content-center mt-4">
        <button type="button" class="btn btn-sm btn btn-outline-light float-right small" style="margin-top: 200px;" id="show_local_login">Inicio local</button>
    </div>
</div>
@endsection

@section('custom_js')
<script type="text/javascript">
    $("#show_local_login").click(function() {
        $("#local_login").toggleClass('d-none');
    });
</script>
@endsection