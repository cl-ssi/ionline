@extends('layouts.bt4.app')

@section('title', 'Agregar actividad de participación '.$programming->establishment->type.' '.$programming->establishment->name.' '.$programming->year)

@section('content')

@include('programmings/nav')

<h3 class="mb-3">Agregar actividad de participación {{ $programming->establishment->type }} {{ $programming->establishment->name }} {{ $programming->year}} </h3>
<br>

<form method="POST" class="form-horizontal" action="{{ route('participation.store', $programming) }}">
    @csrf
    @method('POST')
    <input type="hidden" name="programming_id" value="{{$programming->id}}">
    <input type="hidden" name="indicator_id" value="{{$indicatorId}}">
    <div class="form-row">
        <fieldset class="form-group col-sm-8">
            <label for="for_activity_name">Nombre de la actividad</label>
            <input type="text" class="form-control" id="for_activity_name" name="activity_name" value="{{old('activity_name')}}" required>
        </fieldset>

        <fieldset class="form-group col-sm">
            <label for="for_value">N° veces que se realizará la actividad en el año</label>
            <input type="number" min="1" class="form-control" id="for_value" name="value" value="{{old('value')}}" required>
        </fieldset>
    </div>

    <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Guardar</button>
    <a class="btn btn-outline-secondary" href="{{ url()->previous() }}">Volver</a>

</form>

@endsection