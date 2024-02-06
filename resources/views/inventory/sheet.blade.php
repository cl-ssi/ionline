@extends('layouts.bt5.app')
@section('title', 'Planilla Mural')
@section('content')
@include('inventory.nav', [
        'establishment' => auth()->user()->organizationalUnit->establishment
    ])
    <fieldset class="col-md-6">
            <label for="place-id" class="form-label">
                Ubicación a Generar la Planilla Mural
            </label>

            @livewire('places.find-place', [
                'smallInput' => true,
                'tagId' => 'place-id',
                'placeholder' => 'Ingrese una ubicación o cod. arq.',
                'establishment' => auth()->user()->organizationalUnit->establishment,
            ])
            <input
                class="form-control @error('place_id') is-invalid @enderror"
                type="hidden"
            >

            @error('place_id')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
    </fieldset>
    <br>

    <div class="col-md-1">
            <label class="form-label">
                &nbsp; 
            </label>
            <button class="btn btn-primary" wire:click="searchBySelectedPlace">Buscar</button>
    </div>


@endsection