@extends('layouts.bt4.app')

@section('content')

@include('prof_agenda.partials.nav')

<h3 class="mb-3">Editar ficha de programación #{{$proposal->id}}</h3>

<form method="POST" class="form-horizontal" action="{{ route('prof_agenda.proposals.update',$proposal) }}">
@csrf
@method('PUT')

<div class="row">
    <fieldset class="form-group col col-md-4">
        <label for="for_type">Tipo</label>
        <select class="form-control" name="type" @if($proposal->status == "Aperturado") readonly @endif>
            <option value=""></option>
            <option value="Nuevo horario" @selected($proposal->type == "Nuevo horario")>Nuevo horario</option>
            <option value="Reprogramación" @selected($proposal->type == "Reprogramación")>Reprogramación</option>
        </select>
    </fieldset>
    <fieldset class="form-group col col-md">
        <label for="for_start_date">Fecha Inicio</label>
        <input type="date" class="form-control" name="start_date" value="{{$proposal->start_date->format('Y-m-d')}}" required  @if($proposal->status == "Aperturado") readonly @endif>
    </fieldset>

    <fieldset class="form-group col col-md">
        <label for="for_end_date">Fecha Término</label>
        <input type="date" class="form-control" name="end_date" value="{{$proposal->end_date->format('Y-m-d')}}" required  @if($proposal->status == "Aperturado") readonly @endif>
    </fieldset>
</div>

<div class="row">

    <fieldset class="form-group col-12 col-md-4">
        <label for="for_users">Funcionario</label>
        <div id="div_responsable_id" wire:ignore>
            @livewire('search-select-user', ['selected_id' => 'user_id', 'required' => 'required', 'user' => $proposal->employee])
        </div>
    </fieldset>

    <fieldset class="form-group col-12 col-md-4">
        <label for="for_profesion_id">Profesión</label>
        <select class="form-control" name="profession_id" id="" required  @if($proposal->status == "Aperturado") readonly @endif>
            <option value=""></option>
            @foreach($professions as $profession)
                <option value="{{$profession->id}}" @selected($profession->id == $proposal->profession_id)>{{$profession->name}}</option>
            @endforeach
        </select>
    </fieldset>

    <fieldset class="form-group col-12 col-md-4">
        <label for="for_status">Estado</label>
        <select class="form-control" name="status" id="for_status" required>
            <option value="Creado" @selected($proposal->status == "Creado")>Creado</option>
            <option value="Aperturado" @selected($proposal->status == "Aperturado")>Aperturado</option>
            <option value="Bloqueado" @selected($proposal->status == "Bloqueado")>Bloqueado</option>
        </select>
    </fieldset>
</div>

<div class="row">
    <fieldset class="form-group col col-md">
        <label for="for_observation">Observación</label>
        <textarea name="observation" class="form-control" rows="3" cols="80" @if($proposal->status == "Aperturado") readonly @endif>
            {!!$proposal->observation!!}
        </textarea>
    </fieldset>
</div>

<button type="submit" class="btn btn-primary">Guardar</button>

</form>

<hr>

<div class="alert alert-primary" role="alert">
    Una propuesta aperturada no se puede modificar.
</div>

<h3 class="mb-3">Detalles</h3>

@livewire('prof-agenda.add-proposal-detail',['proposal' => $proposal])

@canany(['Agenda UST: Administrador'])
    @livewire('prof-agenda.clone-proposal',['proposal' => $proposal])
@endcanany

@livewire('prof-agenda.proposal-calendar',['proposal' => $proposal])
@stack('scripts')

@endsection

@section('custom_css')
<!-- CSS Custom para el calendario -->
<!-- <style media="screen">
    .dia_calendario {
        display: inline-block;
        border: solid 1px rgb(0, 0, 0, 0.125);
        border-radius: 0.25rem;
        width: 12%;
        /* width: 154px; */
        text-align: center;
        margin-bottom: 5px;
    }

    /* ok */
    .not_available_style {
        background: linear-gradient(
            to right,
            #FADBD8  0%,
            #FADBD8  50%,
            #FADBD8  50%,
            #FADBD8  100%
        );
    }

    /* ok */
    .active_style {
        background: linear-gradient(
            to right,
            #A3E4D7 0%,
            #A3E4D7 50%,
            #A3E4D7 50%,
            #A3E4D7 100%
        );
    }

    /* mosaico */

    .item1 {
    grid-area: area1;
    }

    .item4 {
    height: 100px;
    }


    .item5 {
    grid-area: area5;
    }


    .grid-container {
    display: grid;
    grid-template-areas:
        'area1 . .'
        'area1 area4 area5'
        'area1 . area5'
        '. . area5';
    grid-gap: 2px;
    }

    .grid-container > div {
    background-color: #f7f7f7;
    text-align: center;
    padding: 10px;
    }

</style> -->
@endsection

@section('custom_js')

@endsection
