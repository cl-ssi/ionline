@extends('layouts.app')

@section('title', $municipality->name_municipality)

@section('content')

@include('agreements/nav')

<h3 class="mb-3">{{$municipality->name_municipality}}</h3>

<form method="POST" class="form-horizontal" action="{{ route('agreements.municipalities.update', $municipality) }}">
    @csrf
    @method('PUT')

    <div class="form-row">
        <fieldset class="form-group col-2">
            <label for="for_rut">RUT</label>
            <input type="text" class="form-control" id="rut_municipality" name="rut_municipality" value="{{$municipality->rut_municipality}}" required readonly>
        </fieldset>

        <fieldset class="form-group col-4">
            <label for="for_name">E-mail municipio</label>
            <input type="text" class="form-control" id="email_municipality" name="email_municipality" value="{{$municipality->email_municipality}}">
        </fieldset>

        <fieldset class="form-group col-6">
            <label for="for_address">Dirección</label>
            <input type="text" class="form-control" id="adress_municipality" name="adress_municipality" value="{{$municipality->adress_municipality}}" required>
        </fieldset>
    </div>

    <div class="form-row">
        <fieldset class="form-group col-2">
            <label for="for_rut">RUT alcalde</label>
            <input type="text" class="form-control" id="rut_representative" name="rut_representative" value="{{$municipality->rut_representative}}" required>
        </fieldset>

        <fieldset class="form-group col-4">
            <label for="for_name">Nombre alcalde</label>
            <input type="text" class="form-control" id="name_representative" name="name_representative" value="{{$municipality->name_representative}}" required>
        </fieldset>

        <fieldset class="form-group col-6">
            <label for="for_address">Decreto</label>
            <input type="text" class="form-control" id="decree_representative" name="decree_representative" value="{{$municipality->decree_representative}}" required>
        </fieldset>
    </div>
    <div class="form-row">
        <fieldset class="form-group col-2">
            <label for="for_rut">RUT alcalde subrogante</label>
            <input type="text" class="form-control" id="rut_representative_surrogate" name="rut_representative_surrogate" value="{{$municipality->rut_representative_surrogate}}">
        </fieldset>

        <fieldset class="form-group col-4">
            <label for="for_name">Nombre alcalde subrogante</label>
            <input type="text" class="form-control" id="name_representative_surrogate" name="name_representative_surrogate" value="{{$municipality->name_representative_surrogate}}">
        </fieldset>

        <fieldset class="form-group col-6">
            <label for="for_address">Decreto</label>
            <input type="text" class="form-control" id="decree_representative_surrogate" name="decree_representative_surrogate" value="{{$municipality->decree_representative_surrogate}}">
        </fieldset>

    </div>

    <button type="submit" class="btn btn-primary mb-4">Guardar</button>

</form>

@endsection