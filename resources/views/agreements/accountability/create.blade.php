@extends('layouts.app')

@section('title', 'Nueva Rendición')

@section('content')

@include('agreements/nav')

<h3 class="mb-3">Nueva Rendición</h3>

<form method="POST" class="form-horizontal" action="{{ route('agreements.accountability.store', $agreement->id) }}">
    @csrf
    @method('POST')

    <div class="row">
        <fieldset class="form-group col">
            <label for="for_month">Mes</label>
            <select name="month" id="for_month" class="form-control" required>
                <option>Enero</option>
                <option>Febrero</option>
                <option>Marzo</option>
                <option>Abril</option>
                <option>Mayo</option>
                <option>Junio</option>
                <option>Julio</option>
                <option>Agosto</option>
                <option>Septiembre</option>
                <option>Octubre</option>
                <option>Noviembre</option>
                <option>Diciembre</option>
            </select>
        </fieldset>

        <fieldset class="form-group col">
            <label for="for_document">N° Documento</label>
            <input type="text" class="form-control" id="for_document" name="document" required>
        </fieldset>

        <fieldset class="form-group col">
            <label for="for_date">Fecha Documento</label>
            <input type="date" class="form-control" id="for_date" name="date" required>
        </fieldset>

    </div>

    <button type="submit" class="btn btn-primary">Guardar</button>

</form>


@endsection

@section('custom_js')

@endsection
