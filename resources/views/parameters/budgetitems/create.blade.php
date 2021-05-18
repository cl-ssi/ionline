@extends('layouts.app')

@section('title', 'Crear Item Presupuestario')

@section('content')

@include('parameters.nav')

<h3 class="mb-3">Crear Item Presupuestrio</h3>

<form method="POST" class="form-horizontal" action="{{ route('parameters.budgetitems.store') }}">
    @csrf

    <div class="row">
        <fieldset class="form-group col">
            <label for="for_code">Código</label>
            <input type="text" class="form-control" id="for_code" name="code" required>
        </fieldset>

        <fieldset class="form-group col">
            <label for="for_name">Nombre</label>
            <input type="text" class="form-control" id="for_name" name="name">
        </fieldset>

    </div>
    <button type="submit" class="btn btn-primary">Guardar</button>
    <a class="btn btn-outline-secondary" href="{{ route('parameters.budgetitems.index') }}">Volver</a>

</form>

@endsection

@section('custom_js')

@endsection
