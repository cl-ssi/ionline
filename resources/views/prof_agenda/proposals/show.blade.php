@extends('layouts.bt4.app')

@section('content')

@include('prof_agenda.partials.nav')

<h3 class="mb-3">Ficha de programación #{{$proposal->id}}</h3>

<form method="POST" class="form-horizontal" action="{{ route('prof_agenda.proposals.update',$proposal) }}">
@csrf
@method('PUT')

<div class="row">
    <fieldset class="form-group col col-md-4">
        <label for="for_type">Tipo</label>
        <select class="form-control" name="type">
            <option value=""></option>
            <option value="Nuevo horario" @selected($proposal->type == "Nuevo horario")>Nuevo horario</option>
            <option value="Reprogramación" @selected($proposal->type == "Reprogramación")>Reprogramación</option>
        </select>
    </fieldset>
    <fieldset class="form-group col col-md">
        <label for="for_start_date">Fecha Inicio</label>
        <input type="date" class="form-control" name="start_date" value="{{$proposal->start_date->format('Y-m-d')}}" required>
    </fieldset>

    <fieldset class="form-group col col-md">
        <label for="for_end_date">Fecha Término</label>
        <input type="date" class="form-control" name="end_date" value="{{$proposal->end_date->format('Y-m-d')}}" required>
    </fieldset>
</div>

<div class="row">

    <fieldset class="form-group col-12 col-md-4">
        <label for="for_users">Responsable</label>
        <div id="div_responsable_id" wire:ignore>
            @livewire('search-select-user', ['selected_id' => 'user_id', 'required' => 'required', 'user' => $proposal->employee])
        </div>
    </fieldset>

    <fieldset class="form-group col-12 col-md-4">
        <label for="for_profesion_id">Profesión</label>
        <select class="form-control" name="profession_id" id="" required>
            <option value=""></option>
            @foreach($professions as $profession)
                <option value="{{$profession->id}}" @selected($profession->id == $proposal->profession_id)>{{$profession->name}}</option>
            @endforeach
        </select>
    </fieldset>
</div>

<div class="row">
    <fieldset class="form-group col col-md">
        <label for="for_observation">Observación</label>
        <textarea name="observation" class="form-control" rows="3" cols="80">
            {!!$proposal->observation!!}
        </textarea>
    </fieldset>
</div>

<button type="submit" class="btn btn-primary">Crear</button>

</form>

<hr>

<h3 class="mb-3">Detalles</h3>




@endsection

@section('custom_js')

@endsection
