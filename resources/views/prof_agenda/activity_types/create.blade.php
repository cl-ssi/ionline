@extends('layouts.app')

@section('content')

@include('prof_agenda.partials.nav')

<h3 class="mb-3">Crear tipo de actividad</h3>

<form method="POST" class="form-horizontal" action="{{ route('prof_agenda.activity_types.store') }}">
@csrf
@method('POST')

<div class="row">
    <fieldset class="form-group col col-md">
        <label for="for_start_date">Nombre tipo de actividad</label>
        <input type="text" class="form-control" name="name" required>
    </fieldset>

    <fieldset class="form-group col col-md">
        <label for="for_start_date">Tipo</label>
        <select class="form-control" name="reservable" id="">
            <option value=""></option>
            <option value="1">Reservable</option>
            <option value="0">No reservable</option>
        </select>
    </fieldset>
</div>

<button type="submit" class="btn btn-primary">Guardar</button>

</form>

@endsection

@section('custom_js')

@endsection
