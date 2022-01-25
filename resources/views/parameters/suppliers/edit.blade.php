@extends('layouts.app')

@section('title', 'Proveedores')

@section('content')

@include('parameters.nav')

<h3 class="mb-3">Editar Proveedor</h3>

<form method="POST" class="form-horizontal" action="{{ route('parameters.suppliers.update', $supplier) }}">
    @csrf
    @method('PUT')
    <div class="row">
        <fieldset class="form-group col-sm-3">
            <label for="for_run">Run</label>
            <input type="run" class="form-control" id="for_run"
              value="{{ $supplier->run }}" name="run" required readonly>
        </fieldset>

        <fieldset class="form-group col-sm-1">
            <label for="for_dv">DV</label>
            <input type="dv" class="form-control" id="for_dv"
              value="{{ $supplier->dv }}" name="dv" required readonly>
        </fieldset>

        <fieldset class="form-group col-sm-8">
            <label for="for_name">Nombre Proveedor</label>
            <input type="name" class="form-control" id="for_name"
              value="{{ $supplier->name }}" name="name" required>
        </fieldset>
    </div>

    <div class="row">
        <fieldset class="form-group col-sm-4">
            <label for="for_address">Dirección</label>
            <input type="address" class="form-control" id="for_address"
              value="{{ $supplier->address }}" name="address" required>
        </fieldset>

        <fieldset class="form-group col-sm-4">
            <label for="for_city">Ciudad</label>
            <input type="city" class="form-control" id="for_city"
              value="{{ $supplier->city }}" name="city" required >
        </fieldset>

        <fieldset class="form-group col-sm-4">
            <label for="for_telephone">Teléfono</label>
            <input type="telephone" placeholder="+569xxxxxxxx" class="form-control" id="for_telephone"
              value="{{ $supplier->telephone }}" name="telephone" required>
        </fieldset>
    </div>

    <button type="submit" class="btn btn-primary float-right"><i class="fas fa-save"></i> Guardar</button>
    <!-- <a class="btn btn-outline-secondary" href="{{ route('parameters.purchaseunits.index') }}">Volver</a> -->
</form>

@endsection

@section('custom_js')

@endsection
