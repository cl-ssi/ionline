@extends('layouts.bt4.app')

@section('title', 'Editar fecha de corte')

@section('content')

<h3 class="mb-3">Editar fecha de corte</h3>

<form method="POST" class="form-horizontal" action="{{ route('parameters.cutoffdates.update', $cut_off_date) }}">
    @csrf
    @method('PUT')
    <div class="form-row">
        <fieldset class="form-group col-sm-2">
            <label for="for_year">Año</label>
            <input type="number" class="form-control" id="for_year" name="year" value="{{$cut_off_date->year}}" required readonly>
        </fieldset>

        <fieldset class="form-group col-sm-1">
            <label for="for_number">N° corte</label>
            <input type="number" min="1" class="form-control" id="for_number" name="number" value="{{$cut_off_date->number}}" required readonly>
        </fieldset>

        <fieldset class="form-group col-sm-3">
            <label for="for_date">Fecha</label>
            <input type="date" min='{{$cut_off_date->year}}-01-01' max='{{$cut_off_date->year + 1}}-12-31' class="form-control" id="for_date" name="date" value="{{$cut_off_date->date->format('Y-m-d')}}" required>
        </fieldset>
    </div>

    <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Guardar</button>
    <a class="btn btn-outline-secondary" href="{{ route('parameters.cutoffdates.index') }}">Volver</a>
</form>

@endsection

@section('custom_js')

@endsection
