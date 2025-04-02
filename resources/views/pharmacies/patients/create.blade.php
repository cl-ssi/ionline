@extends('layouts.bt4.app')

@section('title', 'Crear Paciente')

@section('content')

@include('pharmacies.nav')

<h3>Nuevo Paciente</h3>

<form method="POST" action="{{ route('pharmacies.patients.store') }}" enctype="multipart/form-data">
    @csrf

    <div class="form-row">
        <fieldset class="form-group col-md-6">
            <label for="for_full_name">Nombre Completo</label>
            <input type="text" class="form-control" id="for_full_name" name="full_name" required>
        </fieldset>

        <fieldset class="form-group col-md-6">
            <label for="for_rut">RUT</label>
            <input type="text" class="form-control" id="for_rut" name="rut" required>
        </fieldset>

        <fieldset class="form-group col-md-6">
            <label for="for_phone">Teléfono</label>
            <input type="text" class="form-control" id="for_phone" name="phone">
        </fieldset>

        <fieldset class="form-group col-md-6">
            <label for="for_phone_note">Nota Teléfono</label>
            <input type="text" class="form-control" id="for_phone_note" name="phone_note">
        </fieldset>

        <fieldset class="form-group col-md-6">
            <label for="for_address">Dirección</label>
            <input type="text" class="form-control" id="for_address" name="address">
        </fieldset>

        <fieldset class="form-group col-md-6">
            <label for="for_medical_center">Centro Médico</label>
            <select class="form-control" id="for_medical_center" name="medical_center">
                <option value="">Seleccione un centro médico</option>
                @foreach($establishments as $establishment)
                    <option value="{{ $establishment->name }}">{{ $establishment->name }}</option>
                @endforeach
            </select>
        </fieldset>
    </div>

    <button type="submit" class="btn btn-primary">Crear</button>
</form>

@endsection
