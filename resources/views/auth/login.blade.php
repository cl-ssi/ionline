@extends('layouts.bt4.app')

@section('content')

<link href="{{ asset('css/cu.min.css') }}" rel="stylesheet">

<style>
    .locallogin {
        background-color: #e7e7e7; 
        color: black;
        border: none;
        padding: 9px 26px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        font-size: 16px;
    }
</style>

<div class="container">
    <div class="text-center">
        @isset($url)
        <h4>Módulo para personas externas al {{ env('APP_SS') }}</h4>
        @else
        <h4>iOnline del {{ env('APP_SS') }}</h4>
        @endisset
    </div>
    <div class="row justify-content-center">
        <div class="mt-4">
            <!-- Código para visualizar botón oficial iniciar sesión con ClaveÚnica-->
            @isset($url)
                <a class="btn-cu btn-m btn-color-estandar" href="{{ route('claveunica.autenticar', "L2NsYXZldW5pY2EvbG9naW4tZXh0ZXJuYWw=") }}"
                    title="Este es el botón Iniciar sesión de ClaveÚnica">
                    <span class="cl-claveunica"></span>
                    <span class="texto">Iniciar sesión</span>
                </a>
            @else
                <a class="btn-cu btn-m btn-color-estandar m-auto" 
                    href="{{ route('claveunica.autenticar') }}"
                    title="Este es el botón Iniciar sesión de ClaveÚnica">
                    <span class="cl-claveunica"></span>
                    <span class="texto">Iniciar sesión</span>
                </a>
                <!--./ fin botón-->
            @endisset
            <!--./ fin botón-->
            <div class="row justify-content-center mt-5">
                <button type="button" class="locallogin" id="show_local_login">
                    <i class="fas fa-lg fa-sign-in-alt"></i> 
                    <u class="ml-1">Iniciar local</u>
                </button>
            </div>

        </div>
    </div>
    <div class="row justify-content-center mt-4">
        <div class="col-md-8 d-none" id="local_login">
            <div class="card">

                <div class="card-header">
                    <h4>{{ __('Iniciar sesión')  }} {{ isset($url) ? ucwords($url) : "sin clave única" }}</h4>
                </div>

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
                                        {{ __('Recuperar Clave') }}
                                    </a>
                                    @endif
                                </div>
                            </div>
                        </form>
                </div>
            </div>
        </div>
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