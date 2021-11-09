@extends('layouts.app')

@section('title', 'Editar Item Presupuestario')

@section('content')

@include('parameters.nav')

<h3 class="mb-3">Editar Item Presupuestario</h3>

<form method="POST" class="form-horizontal" action="{{ route('parameters.budgetitems.update', $budgetItem) }}">
    @csrf
    @method('PUT')
    <div class="row">
        <fieldset class="form-group col">
            <label for="for_name">Código*</label>
            <input type="text" class="form-control" id="for_name"
            value="{{ $budgetItem->code }}" name="code" required>
        </fieldset>

        <fieldset class="form-group col">
            <label for="for_prefix">Nombre</label>
            <input type="text" class="form-control" id="for_prefix"
            value="{{ $budgetItem->name }}" name="name" required>
        </fieldset>

    </div>
    <button type="submit" class="btn btn-primary">Guardar</button>
    <a class="btn btn-outline-secondary" href="{{ route('parameters.budgetitems.index') }}">Volver</a>

</form>

@endsection

@section('custom_js')

@endsection
