@extends('layouts.app')

@section('content')

@include('prof_agenda.partials.nav')

<h3 class="mb-3">Editar ficha de programación #{{$activityType->id}}</h3>

<form method="POST" class="form-horizontal" action="{{ route('prof_agenda.activity_types.update',$activityType) }}">
@csrf
@method('PUT')

<div class="row">
    <fieldset class="form-group col col-md">
        <label for="for_name">Nombre tipo de actividad</label>
        <input type="text" class="form-control" name="name" value="{{$activityType->name}}" required>
    </fieldset>
</div>

<button type="submit" class="btn btn-primary">Guardar</button>

</form>

@endsection

@section('custom_css')

@endsection

@section('custom_js')

@endsection
