@extends('layouts.app')

@section('title', 'Crear Unidad de Compra')

@section('content')

@include('parameters.nav')

<h3 class="mb-3">Crear Unidad de Compra</h3>

<form method="POST" class="form-horizontal" action="{{ route('parameters.purchaseunits.store') }}">
    @csrf

    <div class="row">

        <fieldset class="form-group col">
            <label for="for_name">Nombre</label>
            <input type="text" class="form-control" id="for_name" name="name">
        </fieldset>

    </div>
    <button type="submit" class="btn btn-primary">Guardar</button>
    <a class="btn btn-outline-secondary" href="{{ route('parameters.purchaseunits.index') }}">Volver</a>

</form>

@endsection

@section('custom_js')

@endsection
