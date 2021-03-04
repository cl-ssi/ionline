@extends('layouts.app')

@section('title', 'Home')

@section('content')
<div class="jumbotron mt-5">
    <div class="row">
    <div class="col-9">
        <!-- <h1 class="display-4">Intranet Online</h1> -->
        <h1 class="display-4 alert alert-danger center" style="text-align:center"><bold>AVISO IMPORTANTE</bold></h1>
        <p class="lead">{{ env('APP_SS') }}</p>
        <hr class="my-5">
        <p>
        Estimado usuario.<br>
Lamentamos informar que los datos registrados en la plataforma entre el día de ayer <strong>(3 de marzo) a las 15:00 y hoy (4 de marzo) a las 10:00.</strong>
no se encuentran disponibles, solicitamos su colaboración para actualizar o ingresar los datos faltantes.

Para su tranquilidad este inconveniente fue aislado y tomamos las medidas necesarias para que no vuelva a ocurrir
            <br>
            Saluda Atte. <br>
            Equipo de Desarrollo SSI
            <!-- <a href="mailto:{{ env('APP_SS_EMAIL') }}">{{ env('APP_SS_EMAIL') }}</a> -->
        </p>        

    </div>
    <div class="col-md-3 col-12">
        <img src="{{ asset('images/logo_blanco.png') }}"
            alt="Logo {{ env('APP_SS') }}"
            style="background-color: rgb(0, 108, 183);"
            class="img-thumbnail">
    </div>
</div>

<div class="alert alert-light" style="display: none" role="alert" id="developers">
    Hola {{ auth()->user()->name }} soy el sistema <i class="fas fa-cog fa-spin fa-2x" style="color:green"></i>
    , quiero contarte que fui desarrollado por <a href="mailto:alvaro.torres@redsalud.gob.cl">Alvaro Torres</a> y
    <a href="mailto:jorge.mirandal@redsalud.gob.cl">Jorge Miranda</a> del Servicio de Salud Iquique.

    <hr>

    <pre></pre>
</div>
@endsection

@section('custom_js')

<script type="text/javascript">
$(document).ready(function(){
    $("body").keydown(function(event){
    	/* 65=a, 74=j*/
    	if(event.which == 65 || event.which ==74) $("#developers").toggle("slow");
    });
});
</script>

@endsection
