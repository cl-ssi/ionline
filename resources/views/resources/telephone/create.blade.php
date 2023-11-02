@extends('layouts.bt5.app')

@section('title', 'Crear Telefono')

@section('content')

    <h3 class="mb-3">Crear nuevo Teléfono Fijo</h3>

    <form method="POST"
        class="form-horizontal"
        action="{{ route('resources.telephone.store') }}">
        @csrf

        <div class="row g-2 mb-3">

            <fieldset class="form-group col">
                <label for="forNumero">Número*</label>
                <input type="integer"
                    class="form-control"
                    id="forNumero"
                    placeholder="Número"
                    name="number"
                    required="required"
                    value="{{ old('number') }}">
            </fieldset>

            <fieldset class="form-group col">
                <label for="forMinsal">Minsal*</label>
                <input type="integer"
                    class="form-control"
                    id="forMinsal"
                    placeholder="Anexo Minsal"
                    name="minsal"
                    required="required"
                    value="{{ old('minsal') }}">
            </fieldset>

            <fieldset class="form-group col">
                <label for="forMac">MAC</label>
                <input type="integer"
                    class="form-control"
                    id="forMac"
                    name="mac"
                    maxlength="17"
                    value="{{ old('mac') }}">
            </fieldset>
        </div>

        @livewire('parameters.places.place-selector')

        <div class="row">
            <div class="col-6">
                @livewire('multiple-user-search', [
                    'myUsers' => [],
                    'nameInput' => 'users',
                ])
            </div>
        </div>

        <button type="submit"
            class="btn btn-primary">Crear</button>

        <a href="{{ route('resources.telephone.index') }}"
            class="btn btn-outline-dark">Cancelar</a>

    </form>

@endsection
