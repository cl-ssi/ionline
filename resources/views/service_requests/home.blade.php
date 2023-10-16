@extends('layouts.bt4.app')

@section('title', 'Contratación Honorarios')

@section('content')

@include('service_requests.partials.nav')

<div class="jumbotron mt-3">
    <h1 class="display-6">Contratación de Honorarios</h1>
    <p class="lead">Bienvenido al módulo de honorarios de iOnline</p>
    <p>Si tiene alguna duda respecto a algún contrato, puedes ponerte en contacto con el área de RRHH El horario de atención es de 8:30 a 14:00.</p>

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
<script>
$('a[data-toggle="tooltip"]').tooltip({
    animated: 'fade',
    placement: 'top',
    html: true
});
</script>
@endsection
