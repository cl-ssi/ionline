@extends('layouts.app')

@section('title', 'Contratación Honorarios')

@section('content')

@include('service_requests.partials.nav')

<div class="jumbotron mt-3">
    <h1 class="display-3">Phuqhaña</h1>
    <p class="lead">Bienvenido el sistema de honorarios Phuqhaña, palabra Aymara que significa "Cumplir".</p>
    <hr class="my-2">
    <p>Desarrollado por el Departamento TIC,
    en conjunto con los que trabajan en el proceso cada día,
    liderado por el Director del Servicio de Salud Iquique Jorge Galleguillos Möller.</p>

    <hr><br>

    <h4>Videos de ayuda</h4>
    <div class="row">
      <fieldset class="form-group col-12 col-md-6">
        <iframe width="90%" height="315" src="https://www.youtube.com/embed/5XtANjSF9K4" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
  		</fieldset>

      <fieldset class="form-group col-12 col-md-6">
        <iframe width="90%" height="315" src="https://www.youtube.com/embed/jbYAGQQhxYY" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
  		</fieldset>
    </div>
</div>


@endsection

@section('custom_js')

@endsection
