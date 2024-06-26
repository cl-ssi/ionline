@extends('layouts.bt4.app')

@section('content')

@include('prof_agenda.partials.nav')

<h3 class="mb-3">Crear mensaje por especialidad</h3>

<form method="POST" class="form-horizontal" action="{{ route('prof_agenda.profession_messages.store') }}">
@csrf
@method('POST')

<div class="row">
    <fieldset class="form-group col col-md">
        <label for="for_start_date">Profesión</label>
        <select class="form-control" name="profession_id" id="" required>
            <option value=""></option>
            @foreach($professions as $profesion)
            <option value="{{$profesion->id}}">{{$profesion->name}}</option>
            @endforeach
        </select>
    </fieldset>

    <fieldset class="form-group col col-md">
        <label for="for_start_date">Glosa/Descripción de la actividad</label>
        <textarea class="form-control" name="text" id="" cols="30" rows="5" required></textarea>
    </fieldset>
</div>

<button type="submit" class="btn btn-primary">Guardar</button>

</form>

@endsection

@section('custom_js')

@endsection
