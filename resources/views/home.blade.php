@extends('layouts.app')

@section('title', 'Home')

@section('content')
<div class="jumbotron mt-5">
  <div class="row">
  <div class="col-9">
      <h1 class="display-4">Intranet iOnline</h1>      
      <p class="lead">{{ env('APP_SS') }}</p>
      <hr class="my-5">
        <p>Contacto:
            <a href="mailto:{{ env('APP_SS_EMAIL') }}">{{ env('APP_SS_EMAIL') }}</a>
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
    Hola {{ auth()->user()->firstName }}, soy el sistema <i class="fas fa-cog fa-spin fa-2x" style="color:green"></i>
    , quiero contarte que fui desarrollado el año 2018 por <a href="mailto:alvaro.torres@redsalud.gob.cl">
    Alvaro Torres</a> y <a href="mailto:jorge.mirandal@redsalud.gob.cl">Jorge Miranda</a> 
    y hoy día soy mantenido por un excelente equipo de desarrollo del Departamento TIC,
    dónde se incorporó los Estebanes (Rojas + Miranda), Germán Zuñiga, Álvaro Lupa y Oscar Zavala.
    <br>
    El equipo de combate en terreno está formado por 
    Yeannett, Adriana, Cristian y Álvaro (si, hay tres Álvaros en el departamento).
    <br>
    Nuestro jefe de departamento es el glorioso Don José Don Oso. <br>
    Y una mención especial a nuestra ex .... secretaría que aún nos apoya, Pamela :).

    <hr>

    <pre>{{ $phrase ? $phrase->phrase : '' }}</pre>
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
