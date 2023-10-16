@extends('layouts.bt4.app')

@section('content')
@include('rem.nav')
<h3 class="mb-3">Agregar Nuevo Periodo con la serie que corresponde</h3>
<form method="POST" class="form-horizontal" action="{{ route('rem.periods_series.store') }}">
    @csrf
    @method('POST')

    <div class="form-row">

        <fieldset class="form-group col">
            <label for="for_period_id">Periodo</label>
            <select name="period_id" id="for_period_id" class="form-control selectpicker" data-live-search="true" title="Seleccione Periodo" required>
                <option value="">Seleccionar Periodo</option>
                @foreach($remPeriods as $remPeriod)
                <option value="{{ $remPeriod->id }}">{{ $remPeriod->year }}-{{ $remPeriod->month }}</option>
                @endforeach
            </select>
        </fieldset>



        <fieldset class="form-group col">
            <label for="for_serie_id">Serie</label>
            <select name="serie_id" id="for_serie_id" class="form-control selectpicker" data-live-search="true" title="Seleccione Serie" required>
                <option value="">Seleccionar Serie</option>
                @foreach($remSeries as $remSerie)
                <option value="{{ $remSerie->id }}">{{ $remSerie->name }}</option>
                @endforeach
            </select>
        </fieldset>

        <fieldset class="form-group col">
            <label for="for_serie_id">Tipo</label>
            <select name="type[]" id="for_type" class="form-control selectpicker" title="Seleccione tipo"  multiple required>
                <option value="">Seleccionar Tipo</option>
                <option value="CECOSF">CECOSF</option>
                <option value="CESFAM">CESFAM</option>
                <option value="CGR">CGR</option>
                <option value="COSAM">COSAM</option>
                <option value="HOSPITAL">HOSPITAL</option>
                <option value="PRAIS">PRAIS</option>
                <option value="PSR">PSR</option>
                <option value="SAPU">SAPU</option>
            </select>
        </fieldset>

    </div>

    <button type="submit" class="btn btn-primary">Guardar</button>

</form>

@endsection

@section('custom_js')

@endsection