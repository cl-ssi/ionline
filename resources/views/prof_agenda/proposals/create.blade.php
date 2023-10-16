@extends('layouts.bt4.app')

@section('content')

@include('prof_agenda.partials.nav')

<h3 class="mb-3">Crear ficha de programación</h3>

<form method="POST" class="form-horizontal" action="{{ route('prof_agenda.proposals.store') }}">
@csrf
@method('POST')

<div class="row">
    <fieldset class="form-group col col-md-4">
        <label for="for_type">Tipo</label>
        <select class="form-control" name="type">
            <option value=""></option>
            <option value="Nuevo horario">Nuevo horario</option>
            <option value="Reprogramación">Reprogramación</option>
        </select>
    </fieldset>
    <fieldset class="form-group col col-md">
        <label for="for_start_date">Fecha Inicio</label>
        <input type="date" class="form-control" name="start_date" required>
    </fieldset>

    <fieldset class="form-group col col-md">
        <label for="for_end_date">Fecha Término</label>
        <input type="date" class="form-control" name="end_date" required>
    </fieldset>
</div>

<div class="row">

    <fieldset class="form-group col-12 col-md-4">
        <label for="for_users">Funcionario</label>
        <div id="div_responsable_id" wire:ignore>
            @livewire('search-select-user', ['selected_id' => 'user_id', 'required' => 'required'])
        </div>
    </fieldset>

    <fieldset class="form-group col-12 col-md-4">
        <label for="for_profesion_id">Profesión</label>
        <select class="form-control" name="profession_id" id="" required>
            <option value=""></option>
            @foreach($professions as $profession)
                <option value="{{$profession->id}}">{{$profession->name}}</option>
            @endforeach
        </select>
    </fieldset>
</div>

<div class="row">
    <fieldset class="form-group col col-md">
        <label for="for_observation">Observación</label>
        <textarea name="observation" class="form-control" rows="3" cols="80"></textarea>
    </fieldset>
</div>

<button type="submit" class="btn btn-primary">Guardar</button>

</form>

@endsection

@section('custom_js')

@endsection
