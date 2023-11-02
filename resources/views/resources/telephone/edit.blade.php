@extends('layouts.bt5.app')

@section('title', 'Editar Telefono')

@section('content')

    <h3 class="mb-3">Editar Teléfono Fijo</h3>

    <form method="POST"
        class="form-horizontal"
        action="{{ route('resources.telephone.update', $telephone) }}">
        @method('PUT')
        @csrf

        <div class="row g-2 mb-3">
            <fieldset class="form-group col-4">
                <label for="forNumero">Número*</label>
                <input type="integer"
                    class="form-control"
                    id="forNumero"
                    name="number"
                    value="{{ $telephone->number }}"
                    value="{{ old('numero') }}">
            </fieldset>

            <fieldset class="form-group col-4">
                <label for="forMinsal">Minsal*</label>
                <input type="integer"
                    class="form-control"
                    id="forMinsal"
                    name="minsal"
                    value="{{ $telephone->minsal }}"
                    value="{{ old('minsal') }}">
            </fieldset>

            <fieldset class="form-group col-4">
                <label for="forMac">MAC</label>
                <input type="integer"
                    class="form-control"
                    id="forMac"
                    name="mac"
                    value="{{ $telephone->mac }}"
                    maxlength="17"
                    value="{{ old('mac') }}">
            </fieldset>
        </div>

        @livewire('parameters.places.place-selector', ['place_id' => $telephone->place_id ?? null])

        <div class="row">
            <div class="col-6">
                @livewire('multiple-user-search', [
                    'myUsers' => $telephone->users->pluck('id'),
                    'nameInput' => 'users',
                ])
            </div>
        </div>

        <fieldset class="form-group">
            <button type="submit"
                class="btn btn-primary">
                <span class="fas fa-save"
                    aria-hidden="true"></span> Actualizar</button>

    </form>

    <a href="{{ route('resources.telephone.index') }}"
        class="btn btn-outline-secondary">Cancelar</a>

    <form method="POST"
        action="{{ route('resources.telephone.destroy', $telephone->id) }}"
        class="d-inline">
        @csrf
        @method('DELETE')
        <button class="btn btn-danger float-right"><span class="fas fa-trash"
                aria-hidden="true"></span> Eliminar</button>
    </form>

    </fieldset>

@endsection
