@extends('layouts.app')

@section('title', 'Ingresar Recepción')

@section('content')

@include('drugs.nav')

<h3 class="mb-3">Ingresar Recepción</h3>

<form method="POST" class="form-horizontal" action="{{ route('drugs.receptions.store') }}">
    @csrf

    <div class="form-row">
        <fieldset class="form-group col">
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="parte_label"
                id="inlineRadio1" value="Parte" checked>
                <label class="form-check-label" for="inlineRadio1">Parte</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="parte_label"
                id="inlineRadio2" value="Oficio Reservado">
                <label class="form-check-label" for="inlineRadio2">Oficio Reservado</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="parte_label"
                id="inlineRadio3" value="RUC">
                <label class="form-check-label" for="inlineRadio3">RUC</label>
            </div>
        </fieldset>
    </div>


    <div class="form-row">

        <fieldset class="form-group col-2">
            <label for="for_parte">Parte/Of.Res/RUC</label>
            <input type="text" class="form-control" id="for_parte" name="parte">
        </fieldset>

        <fieldset class="form-group col-5">
            <label for="for_parte_police_unit">Origen *</label>
            <select class="form-control" id="for_parte_police_unit"
            name="parte_police_unit_id" required>
                @foreach($policeUnits as $police_unit)
                <option value="{{ $police_unit->id }}">{{ $police_unit->name }}</option>
                @endforeach
            </select>
        </fieldset>

        <fieldset class="form-group col-5">
            <label for="for_court">Fiscalia *</label>
            <select name="court_id" id="for_court" class="form-control" required>
                @foreach($courts as $court)
                <option value="{{ $court->id }}">{{ $court->name }}</option>
                @endforeach
            </select>
        </fieldset>

    </div>

    <div class="form-row">

        <fieldset class="form-group col-2">
            <label for="fordocument">Número Oficio *</label>
            <input type="text" class="form-control" id="fordocument"
            name="document_number" required>
        </fieldset>

        <fieldset class="form-group col-5">
            <label for="for_police_unit">Origen Oficio *</label>
            <select name="document_police_unit_id" id="for_police_unit"
                    class="form-control" required>
                @foreach($policeUnits as $police_unit)
                <option value="{{ $police_unit->id }}">{{ $police_unit->name }}</option>
                @endforeach
            </select>
        </fieldset>

        <fieldset class="form-group col-3">
            <label for="fordocument_date">Fecha Oficio *</label>
            <input type="date" class="form-control" id="fordocument_date"
            name="document_date" required>
        </fieldset>

    </div>

    <div class="form-row">
        <fieldset class="form-group col-4">
            <label for="for_delivery">Funcionario que entrega</label>
            <input type="text" class="form-control" id="for_delivery"
            name="delivery">
        </fieldset>

        <fieldset class="form-group col-4">
            <label for="for_delivery_run">RUN Funcionario</label>
            <input type="text" class="form-control" id="for_delivery_run"
            name="delivery_run">
        </fieldset>

        <fieldset class="form-group col-4">
            <label for="fordelivery_position">Cargo de quien entrega</label>
            <input type="text" class="form-control" id="fordelivery_position"
            name="delivery_position">
        </fieldset>
    </div>

    <div class="form-row">
        <fieldset class="form-group col-4">
            <label for="forimputed">Nombre Imputado</label>
            <input type="text" class="form-control" id="forimputed"
            name="imputed">
        </fieldset>

        <fieldset class="form-group col-4">
            <label for="forimputed_run">RUN Imputado</label>
            <input type="text" class="form-control" id="forimputed_run"
            name="imputed_run" placeholder="xx.xxx.xxx-x">
        </fieldset>

        <fieldset class="form-group col-1 pb-1">
            <label for="for_accion">Accion</label>
            <button type="submit" class="btn btn-primary">Guardar</button>
        </fieldset>
    </div>
    <div class="form-row">
        <fieldset class="form-group col">
            <label for="forobservation">Observación</label>
            <input type="text" class="form-control" id="forobservation"
            name="observation">
        </fieldset>
    </div>


</form>

@endsection

@section('custom_js')

@endsection
