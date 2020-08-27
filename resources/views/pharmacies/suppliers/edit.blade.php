@extends('layouts.app')

@section('title', 'Editar Proveedor')

@section('content')

@include('pharmacies.nav')

<h3 class="mb-3">Editar Proveedor</h3>

<form method="POST" class="form-horizontal" action="{{ route('pharmacies.suppliers.update', $supplier) }}">
    @csrf
    @method('PUT')

    <div class="row">

        <fieldset class="form-group col">
            <label for="for_name">Nombre</label>
            <input type="text" class="form-control" id="for_name"
            value="{{ $supplier->name }}" name="name" required autocomplete="off">
        </fieldset>

        <fieldset class="form-group col-2">
            <label for="for_rut">RUT</label>
            <input type="text" class="form-control" id="for_rut"
            value="{{ $supplier->rut }}" name="rut" required>
        </fieldset>

    </div>

    <div class="row">

        <fieldset class="form-group col">
            <label for="for_address">Dirección</label>
            <input type="text" class="form-control" id="for_address"
            value="{{ $supplier->address }}" name="address" required autocomplete="off">
        </fieldset>

        <fieldset class="form-group col-4">
            <label for="for_commune">Comuna</label>
            <input type="text" class="form-control" id="for_commune"
            value="{{ $supplier->commune }}" name="commune" required autocomplete="off">
        </fieldset>

    </div>

    <div class="row">

        <fieldset class="form-group col">
            <label for="for_telephone">Teléfono</label>
            <input type="text" class="form-control" id="for_telephone"
            value="{{ $supplier->telephone }}" placeholder name="telephone">
        </fieldset>

        <fieldset class="form-group col">
            <label for="for_fax">FAX</label>
            <input type="text" class="form-control" id="for_fax"
            value="{{ $supplier->fax }}" name="fax">
        </fieldset>

        <fieldset class="form-group col">
            <label for="for_contact">Contacto</label>
            <input type="text" class="form-control" id="for_contact"
            value="{{ $supplier->contact }}" name="contact">
        </fieldset>

    </div>
    <button type="submit" class="btn btn-primary">Guardar</button>

</form>

@endsection

@section('custom_js')

@endsection
