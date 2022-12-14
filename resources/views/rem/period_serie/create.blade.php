@extends('layouts.app')

@section('content')
@include('rem.nav')
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

    </div>

    <button type="submit" class="btn btn-primary">Guardar</button>

</form>

@endsection

@section('custom_js')

@endsection