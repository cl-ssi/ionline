@extends('layouts.app')

@section('title', 'Inventario Detalle')

@section('content')

@include('inventory.nav')

<h4>
    Inventario
</h4>

<div class="form-row mb-3">
    <fieldset class="col-sm-2">
        <label for="code" class="form-label">
            Código
        </label>
        <input type="text" class="form-control form-control-sm" id="code" value="56101504" disabled readonly>
    </fieldset>

    <fieldset class="col-sm-3">
        <label for="product" class="form-label">
            Producto
        </label>
        <input type="text" class="form-control form-control-sm" id="product" value="Sillas" disabled readonly>
    </fieldset>

    <fieldset class="col-sm-2">
        <label for="number-inventory" class="form-label">
            Nro. Inventario
        </label>
        <input type="text" class="form-control form-control-sm" id="number-inventory" value="INV-1111111" disabled readonly>
    </fieldset>

    <fieldset class="col-sm-2">
        <label for="useful-life" class="form-label">
            Vida util
        </label>
        <input type="text" class="form-control form-control-sm" id="useful-life" value="1 año" disabled readonly>
    </fieldset>

    <fieldset class="col-sm-3">
        <label for="number-inventory" class="form-label">
            Depreciacion
        </label>
        <input type="text" class="form-control form-control-sm" id="number-inventory" value="Lorem ipsum" disabled readonly>
    </fieldset>
</div>

<div class="form-row mb-3">
    <fieldset class="col-sm-6">
        <label for="subtitle" class="form-label">
            Sub-titulo FR
        </label>
        <input type="text" class="form-control form-control-sm" id="subtitle" value="Lorem ipsum" disabled readonly>
    </fieldset>

    <fieldset class="col-sm-2">
        <label for="oc" class="form-label">
            OC
        </label>
        <input type="text" class="form-control form-control-sm" id="oc" value="1057448-165-AG22" disabled readonly>
    </fieldset>

    <fieldset class="col-sm-2">
        <label for="value" class="form-label">
            Valor OC
        </label>
        <input type="text" class="form-control form-control-sm" id="value" value="$28000" disabled readonly>
    </fieldset>

    <fieldset class="col-sm-2">
        <label for="date-" class="form-label">
            Fecha Compra OC
        </label>
        <input type="text" class="form-control form-control-sm" id="date-" value="2022-06-02 13:55:28" disabled readonly>
    </fieldset>
</div>

<div class="form-row mb-3">
    <fieldset class="col-sm-2">
        <label for="date-reception" class="form-label">
            Fecha Ingreso
        </label>
        <input type="text" class="form-control form-control-sm" id="date-reception" value="2022-06-30" disabled readonly>
    </fieldset>

    <fieldset class="col-sm-4">
        <label for="responsability" class="form-label">
            Responsable
        </label>
        <input type="text" class="form-control form-control-sm" id="responsability" value="Pedro Perez" disabled readonly>
    </fieldset>

    <fieldset class="col-sm-2">
        <label for="reception-confirmation" class="form-label">
            Confirmacion Recepcion
        </label>
        <input type="text" class="form-control form-control-sm" id="reception-confirmation" value="Si" disabled readonly>
    </fieldset>

    <fieldset class="col-sm-4">
        <label for="destinations" class="form-label">
            Destino Ubicacion
        </label>
        <input type="text" class="form-control form-control-sm" id="destinations" value="Departamento TIC, oficina 211" disabled readonly>
    </fieldset>
</div>

<div class="form-row mb-3">
    <fieldset class="col-sm-3">
        <label for="brand" class="form-label">
            Marca
        </label>
        <input type="text" class="form-control form-control-sm" id="brand" value="Acme" disabled readonly>
    </fieldset>

    <fieldset class="col-sm-3">
        <label for="model" class="form-label">
            Modelo
        </label>
        <input type="text" class="form-control form-control-sm" id="model" value="47FA" disabled readonly>
    </fieldset>

    <fieldset class="col-sm-3">
        <label for="serial-number" class="form-label">
            Numero de Serie
        </label>
        <input type="text" class="form-control form-control-sm" id="serial-number" value="1112223344-0" disabled readonly>
    </fieldset>
</div>

<div class="form-row mb-3">
    <fieldset class="col-sm-12">
        <label for="description" class="form-label">
            Descripcion
        </label>
        <input type="text" class="form-control form-control-sm" id="description" value="Silla de escritorio ergonomica" disabled readonly>
    </fieldset>
</div>

@endsection