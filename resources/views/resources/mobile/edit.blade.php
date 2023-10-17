@extends('layouts.bt4.app')

@section('title', 'Editar Teléfono Móvil')

@section('content')

<h3 class="mb-3">Editar Teléfono Móvil</h3>

<form method="POST" class="form-horizontal" action="{{ route('resources.mobile.update', $mobile) }}">
    @method('PUT')
    @csrf

    <div class="form-row">

        <fieldset class="form-group col-3">
            <label for="forNumero">Número</label>
            <input type="integer" class="form-control" id="forNumero" name="number" value="{{ $mobile->number }}">
        </fieldset>
        
        <fieldset class="form-group col-3">
            <label for="forBrand">Marca</label>
            <input type="text" class="form-control" id="forBrand" name="brand" value="{{ $mobile->brand }}">
        </fieldset>

        <fieldset class="form-group col-3">
            <label for="forModel">Modelo</label>
            <input type="text" class="form-control" id="forModel" name="model" value="{{ $mobile->model }}">
        </fieldset>
    </div>
        
    <div class="form-row">

        <fieldset class="form-group col-9">
            <label for="forUsers">Asignar a:</label>
            @livewire('search-select-user', ['user' => $mobile->user ?? null])
        </fieldset>
    </div>

    <fieldset class="form-group form-check">
        <input type="checkbox" class="form-check-input" @checked($mobile->owner) name="owner">
        <label class="form-check-label" for="for-owner">Es móvil es personal</label>
    </fieldset>

    <fieldset class="form-group form-check">
        <input type="checkbox" class="form-check-input" @checked($mobile->directory) name="directory">
        <label class="form-check-label" for="for-directory">Mostrar en el directorio telefónico</label>
    </fieldset>

    <fieldset class="form-group">
        <button type="submit" class="btn btn-primary">
            <span class="fas fa-save" aria-hidden="true"></span> Actualizar
        </button>

        </form>

        <a href="{{ route('resources.mobile.index') }}" class="btn btn-outline-secondary">Cancelar</a>

        <form method="POST" action="{{ route('resources.mobile.destroy', $mobile) }}" class="d-inline">
            @csrf
            @method('DELETE')
            <button class="btn btn-danger float-right">
                <span class="fas fa-trash" aria-hidden="true"></span> Eliminar
            </button>
        </form>
    </fieldset>

@endsection
