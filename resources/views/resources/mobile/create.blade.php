@extends('layouts.bt4.app')

@section('title', 'Crear Teléfono Móvil')

@section('content')

<h3 class="mb-3">Crear nuevo Teléfono Móvil</h3>

<form method="POST" class="form-horizontal" action="{{ route('resources.mobile.store') }}">
    {{ csrf_field() }}

    <div class="form-row">
        <fieldset class="form-group col-3">
            <label for="forNumero">Número*</label>
            <input type="integer" class="form-control" id="forNumero" placeholder="Número" name="number" required="required">
        </fieldset>
        
        <fieldset class="form-group col-3">
            <label for="forBrand">Marca</label>
            <input type="text" class="form-control" id="forBrand" name="brand">
        </fieldset>
        
        <fieldset class="form-group col-3">
            <label for="forModel">Modelo</label>
            <input type="text" class="form-control" id="forModel" name="model">
        </fieldset>
    </div>

    <div class="form-row">
        <fieldset class="form-group col-9">
            <label for="forUsers">Asignar a:</label>
            @livewire('search-select-user')
        </fieldset>
    </div>
        
        <fieldset class="form-group form-check">
            <input type="checkbox" class="form-check-input" id="owner" name="owner">
            <label class="form-check-label" for="for-owner">Es personal</label>
        </fieldset>

        <fieldset class="form-group form-check">
            <input type="checkbox" class="form-check-input" name="directory">
            <label class="form-check-label" for="for-directory">Mostrar en el directorio telefónico</label>
        </fieldset>
        
    <button type="submit" class="btn btn-primary">Crear</button>
    <a href="{{ route('resources.mobile.index') }}" class="btn btn-outline-dark">Cancelar</a>

</form>

@endsection
