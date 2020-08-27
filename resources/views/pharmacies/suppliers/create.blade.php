@extends('layouts.app')

@section('title', 'Crear Proveedor')

@section('content')

@include('pharmacies.nav')

<h3 class="mb-3">Crear Proveedor</h3>

<form method="POST" class="form-horizontal" action="{{ route('pharmacies.suppliers.store') }}">
    @csrf
    @method('POST')

    <div class="row">

        <fieldset class="form-group col">
            <label for="for_name">Nombre</label>
            <input type="text" class="form-control" id="for_name" placeholder="Nombre del proveedor" name="name" required="" autocomplete="off">
        </fieldset>

        <fieldset class="form-group col-2">
            <label for="for_rut">RUT</label>
            <input type="text" class="form-control" id="for_rut" placeholder="xx.xxx.xxx-x" name="rut" required="" autocomplete="off">
        </fieldset>

    </div>

    <div class="row">

        <fieldset class="form-group col">
            <label for="for_address">Dirección</label>
            <input type="text" class="form-control" id="for_address" placeholder="Calle, número, etc" name="address" required="" autocomplete="off">
        </fieldset>

        <fieldset class="form-group col-4">
            <label for="for_commune">Comuna</label>
            <input type="text" class="form-control" id="for_commune" placeholder="Nombre de la comuna" name="commune" required="" autocomplete="off">
        </fieldset>

    </div>

    <div class="row">

        <fieldset class="form-group col">
            <label for="for_telephone">Teléfono</label>
            <input type="text" class="form-control" id="for_telephone" placeholder="" name="telephone" required="" autocomplete="off">
        </fieldset>

        <fieldset class="form-group col">
            <label for="for_fax">FAX</label>
            <input type="text" class="form-control" id="for_fax" placeholder="(opcional)" name="fax" required=""  autocomplete="off">
        </fieldset>

        <fieldset class="form-group col">
            <label for="for_contact">Contacto</label>
            <input type="text" class="form-control" id="for_contact" placeholder="e-mail/fono (opcional)" name="contact" required="" autocomplete="off">
        </fieldset>

    </div>
    <button type="submit" class="btn btn-primary">Crear</button>

</form>

@endsection

@section('custom_js')

@endsection
