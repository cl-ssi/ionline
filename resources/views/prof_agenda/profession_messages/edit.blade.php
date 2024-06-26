@extends('layouts.bt4.app')

@section('content')

@include('prof_agenda.partials.nav')

<h3 class="mb-3">Editar mensaje por especialidad</h3>

<form method="POST" class="form-horizontal" action="{{ route('prof_agenda.profession_messages.update',$professionMessage) }}">
@csrf
@method('PUT')

<div class="row">
    <fieldset class="form-group col col-md">
        <label for="for_start_date">Profesión</label>
        <select class="form-control" name="profession_id" id="" required>
            <option value=""></option>
            @foreach($professions as $profesion)
            <option value="{{$profesion->id}}" @selected($profesion->id == $professionMessage->profession_id)>{{$profesion->name}}</option>
            @endforeach
        </select>
    </fieldset>

    <fieldset class="form-group col col-md">
        <label for="for_start_date">Glosa/Descripción de la actividad</label>
        <textarea class="form-control" name="text" id="" cols="30" rows="5" required>{{$professionMessage->text}}</textarea>
    </fieldset>
</div>

<button type="submit" class="btn btn-primary">Guardar</button>

</form>

@include('prof_agenda.partials.audit', ['audits' => $professionMessage->audits] )

@endsection

@section('custom_css')

@endsection

@section('custom_js')

@endsection
