@extends('layouts.bt4.app')

@section('title', 'Crear nuevo fraccionamiento')

@section('content')

@include('pharmacies.nav')

<link href="{{ asset('css/bootstrap-select.min.css') }}" rel="stylesheet" type="text/css"/>

<h3>Nuevo Fraccionamiento</h3>

<div class="alert alert-info" role="alert">
    Al momento de crear el fraccionamiento, debe tener seleccionado el "destino" o el "receptor".
</div>

<form method="POST" action="{{ route('pharmacies.products.fractionation.store') }}">
    @csrf

    @livewire('pharmacies.search-select-user', ['selected_id' => 'patient_id'])

    <div class="form-row">
        <fieldset class="form-group col">
            <label for="for_acquirer">Adquiriente</label>
            <input type="text" name="acquirer" class="form-control" id="for_acquirer" placeholder="Nombre del adquiriente">
        </fieldset>
        <fieldset class="form-group col">
            <label for="for_origin">Médico</label>
            @livewire('search-select-user', ['selected_id' => 'medic_id'])
        </fieldset>
    </div>

    <div class="form-row">
        <fieldset class="form-group col">
            <label for="for_qf_supervisor">QF Supervisor</label>
            @livewire('search-select-user', ['selected_id' => 'qf_supervisor_id'])
        </fieldset>

        <fieldset class="form-group col">
            <label for="for_fractionator">Fraccionador</label>
            <input type="text" name="fractionator_id" class="form-control" id="for_fractionator" value="{{ auth()->user()->id }}" hidden>
            <input type="text" name="fractionator_name" class="form-control" id="for_fractionator_name" value="{{ auth()->user()->shortName }}" readonly>
        </fieldset>
    </div>

    <div class="form-row">
        <fieldset class="form-group col">
            <label for="for_note">Nota</label>
            <input type="text" class="form-control" id="for_note" placeholder="" name="notes">
        </fieldset>
    </div>

    <button type="submit" class="btn btn-primary">Crear</button>
</form>

@endsection

@section('custom_js')

<!--<link href="{{ asset('css/bootstrap-3.3.7.min.css') }}" rel="stylesheet" type="text/css"/>-->
<script src="{{ asset('js/bootstrap-select.min.js') }}"></script>
<script src="{{ asset('js/show_hide_tab.js') }}"></script>

@endsection
