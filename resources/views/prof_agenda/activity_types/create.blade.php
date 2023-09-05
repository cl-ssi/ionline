@extends('layouts.app')

@section('content')

@include('prof_agenda.partials.nav')

<h3 class="mb-3">Crear ficha de programación</h3>

<form method="POST" class="form-horizontal" action="{{ route('prof_agenda.activity_types.store') }}">
@csrf
@method('POST')

<div class="row">
    <fieldset class="form-group col col-md">
        <label for="for_start_date">Nombre tipo de actividad</label>
        <input type="text" class="form-control" name="name" required>
    </fieldset>
</div>

<button type="submit" class="btn btn-primary">Guardar</button>

</form>

@endsection

@section('custom_js')

@endsection
