@extends('layouts.app')

@section('title', 'Editar actividad de participación '.$programming->establishment->type.' '.$programming->establishment->name.' '.$programming->year)

@section('content')

@include('programmings/nav')

<h3 class="mb-3">Editar actividad de participación {{ $programming->establishment->type }} {{ $programming->establishment->name }} {{ $programming->year}} </h3>
<br>

<form method="POST" class="form-horizontal" action="{{ route('participation.update', $value) }}">
    @csrf
    @method('PUT')
    <input type="hidden" name="programming_id" value="{{$programming->id}}">
    <div class="form-row">
        <fieldset class="form-group col-sm-8">
            <label for="for_activity_name">Nombre de la actividad</label>
            <input type="text" class="form-control" id="for_activity_name" name="activity_name" value="{{$value->activity_name}}" required>
        </fieldset>

        <fieldset class="form-group col-sm">
            <label for="for_value">N° veces que se realizará la actividad en el año</label>
            <input type="number" min="1" class="form-control" id="for_value" name="value" value="{{$value->value}}" required>
        </fieldset>
    </div>

    <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Guardar</button>
    <a class="btn btn-outline-secondary" href="{{ url()->previous() }}">Volver</a>

</form>

@endsection