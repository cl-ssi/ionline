@extends('layouts.bt4.app')

@section('title', 'Editar Paciente')

@section('content')

@include('pharmacies.nav')

<form method="POST" action="{{ route('pharmacies.patients.update', $patient) }}">
    @csrf
    @method('PUT')

    <div class="form-row">
        <fieldset class="form-group col-md-4">
            <label for="for_id">ID</label>
            <input type="text" class="form-control @error('id') is-invalid @enderror" id="for_id" name="id" 
                value="{{ old('id', $patient->id) }}" required>
            @error('id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </fieldset>

        <fieldset class="form-group col-md-2">
            <label for="for_dv">DV</label>
            <input type="text" class="form-control @error('dv') is-invalid @enderror" id="for_dv" name="dv" 
                value="{{ old('dv', $patient->dv) }}" required>
            @error('dv')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </fieldset>

        <fieldset class="form-group col-md-6">
            <label for="for_full_name">Nombre Completo</label>
            <input type="text" class="form-control @error('full_name') is-invalid @enderror" id="for_full_name" name="full_name" 
                value="{{ old('full_name', $patient->full_name) }}" required>
            @error('full_name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </fieldset>
    </div>

    <div class="form-row">
        <fieldset class="form-group col-md-6">
            <label for="for_phone">Teléfono</label>
            <input type="text" class="form-control @error('phone') is-invalid @enderror" id="for_phone" name="phone" 
                value="{{ old('phone', $patient->phone) }}">
            @error('phone')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </fieldset>

        <fieldset class="form-group col-md-6">
            <label for="for_observation">Observación</label>
            <input type="text" class="form-control @error('observation') is-invalid @enderror" id="for_observation" name="observation" 
                value="{{ old('observation', $patient->observation) }}">
            @error('observation')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </fieldset>

        <fieldset class="form-group col-md-6">
            <label for="for_address">Dirección</label>
            <input type="text" class="form-control @error('address') is-invalid @enderror" id="for_address" name="address" 
                value="{{ old('address', $patient->address) }}" required>
            @error('address')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </fieldset>

        <fieldset class="form-group col-md-6">
            <label for="for_establishment_id">Centro Médico</label>
            <select class="form-control @error('establishment_id') is-invalid @enderror" id="for_establishment_id" name="establishment_id">
                <option value="">Seleccione un centro médico</option>
                @foreach($establishments as $establishment)
                    <option value="{{ $establishment->id }}" {{ old('establishment_id', $patient->establishment_id) == $establishment->id ? 'selected' : '' }}>
                        {{ $establishment->name }}
                    </option>
                @endforeach
            </select>
            @error('establishment_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </fieldset>
    </div>

    <button type="submit" class="btn btn-primary">Guardar</button>
</form>

@endsection
