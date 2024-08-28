@extends('layouts.bt4.app')

@section('title', 'Agendamiento Unidad de Salud del Trabajador')

@section('content')

@include('prof_agenda.partials.nav')

<div class="jumbotron mt-3">
    <h1 class="display-6">Agendamiento Unidad de Salud del Trabajador</h1>
    <p class="lead">Módulo para realizar reservas médicas. </p>

    <h6>En el siguiente video podrá visualizar como realizar un agendamiento.</h6>
    <br>
    <div class="row">
        <fieldset class="form-group col-12 col-md-12">
            <iframe src="https://drive.google.com/file/d/1O7YFz0EzEI37uFQuUOoYW0OjBVCgiCBH/preview" width="100%" height="540" allow="autoplay; fullscreen" allowfullscreen></iframe>
        </fieldset>
    </div>
</div>

@endsection

<!-- CSS Custom para el calendario -->
@section('custom_css')

@endsection

@section('custom_js')

<script>

</script>

@endsection
