@extends('layouts.app')

@section('title', 'Ingresar Recepción')

@section('content')

@include('drugs.nav')

<h3 class="mb-3">Editar Recepción</h3>

<!-- FIXME: Ver como restringir acceso a esta página de otra forma -->
@can('Drugs: edit receptions')
<form method="POST" class="form-horizontal" action="{{ route('drugs.receptions.update', $reception->id ) }}">
    @method('PUT')
    @csrf

    <div class="form-row">
        <fieldset class="form-group col">
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="parte_label" id="inlineRadio1" value="Parte"
                @if($reception->parte_label == 'Parte') checked @endif >
                <label class="form-check-label" for="inlineRadio1">Parte</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="parte_label" id="inlineRadio2" value="Oficio Reservado"
                @if($reception->parte_label == 'Oficio Reservado') checked @endif >
                <label class="form-check-label" for="inlineRadio2">Oficio Reservado</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="parte_label" id="inlineRadio3" value="RUC"
                @if($reception->parte_label == 'RUC') checked @endif >
                <label class="form-check-label" for="inlineRadio3">RUC</label>
            </div>
        </fieldset>
    </div>

    <div class="form-row">
        <fieldset class="form-group col-2">
            <label for="for_parte">Número *</label>
            <input type="text" class="form-control" id="for_parte" name="parte" value="{{ $reception->parte }}">
        </fieldset>

        <fieldset class="form-group col-5">
            <label for="for_police_unit">Origen</label>
            <select name="parte_police_unit_id" id="for_police_unit" class="form-control">
                @foreach($policeUnits as $police_unit)
                <option value="{{ $police_unit->id }}"
                    @if($reception->parte_police_unit_id == $police_unit->id) selected @endif >
                    {{ $police_unit->name }}</option>
                @endforeach
            </select>
        </fieldset>

        <fieldset class="form-group col-5">
            <label for="for_court">Fiscalia</label>
            <select name="court_id" id="for_court" class="form-control">
                @foreach($courts as $court)
                <option value="{{ $court->id }}"
                    @if($reception->court_id == $court->id) selected @endif >
                    {{ $court->name }}</option>
                @endforeach
            </select>
        </fieldset>

    </div>

    <div class="form-row">
        <fieldset class="form-group col-2">
            <label for="fordocument">Número Oficio</label>
            <input type="text" class="form-control" id="fordocument"
            name="document_number" value="{{ $reception->document_number }}">
        </fieldset>

        <fieldset class="form-group col-5">
            <label for="for_police_unit">Origen Oficio</label>
            <select name="document_police_unit_id" id="for_police_unit" class="form-control">
                @foreach($policeUnits as $police_unit)
                <option disabled selected value></option>
                <option value="{{ $police_unit->id }}"
                    @if($reception->document_police_unit_id == $police_unit->id) selected @endif >
                    {{ $police_unit->name }}</option>
                @endforeach
            </select>
        </fieldset>

        <fieldset class="form-group col-3">
            <label for="fordocument_date">Fecha Oficio *</label>
            <input type="date" class="form-control" id="fordocument_date"
            name="document_date" value="{{ $reception->document_date->format('Y-m-d') }}">
        </fieldset>
    </div>

    <div class="form-row">
        <fieldset class="form-group col-4">
            <label for="for_delivery">Funcionario que entrega *</label>
            <input type="text" class="form-control" id="for_delivery"
            name="delivery" value="{{ $reception->delivery }}" required>
        </fieldset>

        <fieldset class="form-group col-4">
            <label for="for_delivery_run">RUN Funcionario *</label>
            <input type="text" class="form-control" id="for_delivery_run"
            name="delivery_run" value="{{ $reception->delivery_run }}" required>
        </fieldset>

        <fieldset class="form-group col-4">
            <label for="fordelivery_position">Cargo de quien entrega *</label>
            <input type="text" class="form-control" id="fordelivery_position"
                name="delivery_position" value="{{ $reception->delivery_position }}" required>
        </fieldset>
    </div>

    <div class="form-row">
        <fieldset class="form-group col-4">
            <label for="forimputed">Nombre Imputado</label>
            <input type="text" class="form-control" id="forimputed"
            name="imputed" value="{{ $reception->imputed }}">
        </fieldset>

        <fieldset class="form-group col-4">
            <label for="forimputed_run">RUN Imputado</label>
            <input type="text" class="form-control" id="forimputed_run"
            name="imputed_run" value="{{ $reception->imputed_run }}">
        </fieldset>

        <fieldset class="form-group col-1 pb-1">
            <label for="for_accion">Accion</label>
            <button type="submit" class="btn btn-primary">Actualizar</button>
        </fieldset>
    </div>
    <div class="form-row">
        <fieldset class="form-group col">
            <label for="forobservation">Observación</label>
            <input type="text" class="form-control" id="forobservation"
            name="observation" value="{{ $reception->observation }}">
        </fieldset>
    </div>

<a href="{{ route('drugs.receptions.show', $reception->id) }}" class="btn btn-outline-dark"> Cancelar</a>

</form>
@endcan

@endsection
