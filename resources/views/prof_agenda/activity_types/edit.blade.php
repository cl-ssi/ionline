@extends('layouts.bt4.app')

@section('content')

@include('prof_agenda.partials.nav')

<h3 class="mb-3">Editar tipo de actividad</h3>

<form method="POST" class="form-horizontal" action="{{ route('prof_agenda.activity_types.update',$activityType) }}">
@csrf
@method('PUT')

<div class="row">
    <fieldset class="form-group col col-md">
        <label for="for_name">Nombre tipo de actividad</label>
        <input type="text" class="form-control" name="name" value="{{$activityType->name}}" required>
    </fieldset>

    <fieldset class="form-group col col-md">
        <label for="for_start_date">Tipo</label>
        <select class="form-control" name="reservable" id="">
            <option value=""></option>
            <option value="1" @selected($activityType->reservable == 1)>Reservable</option>
            <option value="0" @selected($activityType->reservable == 0)>No reservable</option>
        </select>
    </fieldset>
</div>

<div class="row">
    <fieldset class="form-group col col-md">
        <label for="for_name">Max.Reservas p/semana	</label>
        <input type="text" class="form-control" name="maximum_allowed_per_week" value="{{$activityType->maximum_allowed_per_week}}">
    </fieldset>

    <fieldset class="form-group col col-md">
        <label for="for_start_date">Permite Reservas D/consecutivos</label>
        <select class="form-control" name="allow_consecutive_days" id="" required>
            <option value=""></option>
            <option value="1" @selected($activityType->allow_consecutive_days == 1)>Sí</option>
            <option value="0" @selected($activityType->allow_consecutive_days == 0)>No</option>
        </select>
    </fieldset>
</div>

<div class="row">
    <fieldset class="form-group col col-md">
        <label for="for_start_date">Glosa/Descripción de la actividad</label>
        <textarea class="form-control" name="description" id="" cols="30" rows="10">{{$activityType->description}}</textarea>
    </fieldset>

    <fieldset class="form-group col col-md">
        <label for="auto_reservable">Autoreservable</label>
        <select class="form-control" name="auto_reservable" id="auto_reservable">
            <option value=""></option>
            <option value="1" @selected($activityType->auto_reservable == 1)>Autoreservable</option>
            <option value="0" @selected($activityType->auto_reservable == 0)>No autoreservable</option>
        </select>
    </fieldset>
</div>

<button type="submit" class="btn btn-primary">Guardar</button>

</form>

@include('prof_agenda.partials.audit', ['audits' => $activityType->audits] )

@endsection

@section('custom_css')

@endsection

@section('custom_js')

@endsection
