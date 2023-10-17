@extends('layouts.bt4.app')

@section('content')
@include('rem.nav')

<h3 class="mb-3">Agregar Nuevo Periodo de REM</h3>
<form method="post" id="form-edit" action="{{ route('rem.periods.store') }}">
    @csrf
    @method('POST')
    <div class="form-row">
        <fieldset class="form-group col">
            <label for="for_month">Mes</label>
            <select name="month" class="form-control selectpicker" required>
                <option value=""></option>
                <option value="1">Enero</option>
                <option value="2">Febrero</option>
                <option value="3">Marzo</option>
                <option value="4">Abril</option>
                <option value="5">Mayo</option>
                <option value="6">Junio</option>
                <option value="7">Julio</option>
                <option value="8">Agosto</option>
                <option value="9">Septiembre</option>
                <option value="10">Octubre</option>
                <option value="11">Noviembre</option>
                <option value="12">Diciembre</option>
            </select>
        </fieldset>


        <fieldset class="form-group col">
            <label for="for_year">Año</label>
            <select name="year" class="form-control selectpicker" required>
                <option value=""></option>
                @foreach(range(2022, now()->year) as $year)
                <option value="{{ $year }}">{{ $year }}</option>
                @endforeach
            </select>
        </fieldset>
    </div>
    <button type="submit" class="btn btn-primary">Guardar</button>

</form>

@endsection

@section('custom_js')

@endsection