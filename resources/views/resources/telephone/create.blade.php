@extends('layouts.bt4.app')

@section('title', 'Crear Telefono')

@section('content')

<h3 class="mb-3">Crear nuevo Teléfono Fijo</h3>

<form method="POST" class="form-horizontal" action="{{ route('resources.telephone.store') }}">
    @csrf

    <div class="form-row">

        <fieldset class="form-group col">
            <label for="forNumero">Número*</label>
            <input type="integer" class="form-control" 
                id="forNumero" 
                placeholder="Número" 
                name="number" 
                required="required"
                value="{{ old('number') }}">
        </fieldset>

        <fieldset class="form-group col">
            <label for="forMinsal">Minsal*</label>
            <input type="integer" class="form-control" 
                id="forMinsal" 
                placeholder="Anexo Minsal" 
                name="minsal" 
                required="required"
                value="{{ old('minsal') }}">
        </fieldset>

        <fieldset class="form-group col">
            <label for="forMac">MAC</label>
            <input type="integer" class="form-control" 
                id="forMac" 
                name="mac" 
                maxlength="17" 
                value="{{ old('mac') }}">
        </fieldset>
    </div>


    <div class="form-row">

        <fieldset class="form-group col-12">
            @livewire('parameters.places.place-selector')
        </fieldset>

    </div>

    <fieldset class="form-group">
        @livewire('multiple-user-search',[
            'myUsers' => [],
            'nameInput' => 'users'
        ])
    </fieldset>

    <button type="submit" class="btn btn-primary">Crear</button>

    <a href="{{ route('resources.telephone.index') }}" class="btn btn-outline-dark">Cancelar</a>

</form>

@endsection
