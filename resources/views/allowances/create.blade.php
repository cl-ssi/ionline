@extends('layouts.app')

@section('title', 'Viáticos')

@section('content')

@include('allowances.partials.nav')

@if (session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif

<h5><i class="fas fa-file"></i> Nuevo formulario para solicitud de Viático</h5>

<br>

<form method="POST" class="form-horizontal" action="{{ route('allowances.store') }}" enctype="multipart/form-data"/>
    @csrf
    @method('POST')

    <div class="form-row">
        <fieldset class="form-group col-12 col-md-6">
            <label for="for_user_allowance_id">Funcionario:</label>
            @livewire('search-select-user', [
                'selected_id' => 'user_allowance_id',
                'required' => 'required'
            ])
        </fieldset>

        <fieldset class="form-group col-12 col-md-3">
            <label for="for_contractual_condition">Calidad</label>
            <select name="contractual_condition" class="form-control" required>
                <option value="">Seleccione...</option>
                <option value="to hire">Contrata</option>
                <option value="holder">Titular</option>
            </select>
        </fieldset>

        <fieldset class="form-group col-12 col-md-3">
            <label for="for_allowance_value_id">Grado</label>
            <select name="allowance_value_id" class="form-control" required>
                <option value="">Seleccione...</option>
                @foreach($allowanceValues as $allowanceValue)
                    <option value="{{ $allowanceValue->id }}">{{ $allowanceValue->name }}</option>
                @endforeach
            </select>
        </fieldset>
    </div>

    <div class="form-row">
        <fieldset class="form-group col-12 col-md-3">
            <label for="for_requester_id">Comuna Origen:</label>
                @livewire('search-select-commune', [
                    'selected_id' => 'origin_commune_id',
                    'required' => 'required'
                ])
        </fieldset>

        <fieldset class="form-group col-12 col-md-3">
            <label for="for_requester_id">Comuna Destino:</label>
                @livewire('search-select-commune', [
                    'selected_id' => 'destination_commune_id',
                    'required' => 'required'
                ])
        </fieldset>

        <fieldset class="form-group col-12 col-md-3">
            <label for="for_place">Lugar</label>
            <input class="form-control" type="text" autocomplete="off" name="place" required>
        </fieldset>

        <fieldset class="form-group col-12 col-md-3">
            <label for="for_reason">Motivo</label>
            <input class="form-control" type="text" autocomplete="off" name="reason" required>
        </fieldset>
    </div>

    <div class="form-row">
        <fieldset class="form-group col-12 col-md-3">
            <label for="for_round_trip">Medio de Transporte</label>
            <select name="means_of_transport" class="form-control" required>
                <option value="">Seleccione...</option>
                <option value="ambulance">Ambulancia</option>
                <option value="plane">Avión</option>
                <option value="bus">Bus</option>
                <option value="other">Otro</option>
            </select>
        </fieldset>

        <fieldset class="form-group col-12 col-md-3">
            <label for="for_round_trip">Itinerario</label>
            <select name="round_trip" class="form-control" required>
                <option value="">Seleccione...</option>
                <option value="round trip">Ida, vuelta</option>
                <option value="one-way only">Sólo ida</option>
            </select>
        </fieldset>
        
        <fieldset class="form-group col-12 col-md-3">
            <label for="for_overnight">Derecho de Pasaje</label>
            <div class="mt-1">
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="passage" id="for_passage_yes" value="1" required>
                    <label class="form-check-label" for="for_passage_yes">Si</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="passage" id="for_passage_no" value="0" required>
                    <label class="form-check-label" for="for_passage_no">No</label>
                </div>
            </div>
        </fieldset>

        <fieldset class="form-group col-12 col-md-3">
            <label for="for_passage">Pernocta fuera de residencia</label>
            <div class="mt-1">
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="overnight" id="for_overnight_yes" value="1" required>
                    <label class="form-check-label" for="for_overnight_no">Si</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="overnight" id="for_overnight_no" value="0" required>
                    <label class="form-check-label" for="for_overnight_no">No</label>
                </div>
            </div>
        </fieldset>
    </div>

    <div class="form-row">
        <fieldset class="form-group col-12 col-sm-3">
            <label for="for_start_date">Desde</label>
            <input type="date" class="form-control" name="from" id="for_from" required>
        </fieldset>

        <fieldset class="form-group col-12 col-sm-3">
            <label for="for_end_date">Hasta</label>
            <input type="date" class="form-control" name="to" id="for_to" required>
        </fieldset>
    </div>
    
    <hr>
    <br>

    @livewire('allowances.allowance-files', [
        'form' => 'create'
    ])

    <br>

    <button type="submit" class="btn btn-primary float-right"><i class="fas fa-save"></i> Guardar</button>
</form>

<br><br>

@endsection

@section('custom_js')

@endsection