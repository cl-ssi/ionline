@extends('layouts.bt4.app')

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

<div class="row">
    <fieldset class="form-group col col-md">
        <label for="for_name">Max.Reservas p/semana	</label>
        <input type="text" class="form-control" name="maximum_allowed_per_week">
    </fieldset>

    <fieldset class="form-group col col-md">
        <label for="for_start_date">Permite Reservas D/consecutivos</label>
        <select class="form-control" name="allow_consecutive_days" id="" required>
            <option value=""></option>
            <option value="1">Sí</option>
            <option value="0">No</option>
        </select>
    </fieldset>
</div>

<div class="row">
    <fieldset class="form-group col col-md">
        <label for="for_start_date">Glosa/Descripción de la actividad</label>
        <textarea class="form-control" name="description" id="" cols="30" rows="10"></textarea>
    </fieldset>

    <fieldset class="form-group col col-md">
        <label for="auto_reservable">Autoreservable</label>
        <select class="form-control" name="auto_reservable" id="auto_reservable">
            <option value=""></option>
            <option value="1">Autoreservable</option>
            <option value="0">No autoreservable</option>
        </select>
    </fieldset>
    
</div>

<button type="submit" class="btn btn-primary">Guardar</button>

</form>

@endsection

@section('custom_js')

@endsection
