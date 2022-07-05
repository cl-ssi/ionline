@extends('layouts.app')

@section('title', 'Bandeja Pendiente de Inventario')

@section('content')

@include('inventory.nav')

<h3 class="mb-3">
    Bandeja Pendiente de Inventario
</h3>


        <div class="form-row">
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
                <input type="text" class="form-control form-control-sm" id="product" value="Silla" disabled readonly>
            </fieldset>

            <fieldset class="col-sm-4">
                <label for="number-inventory" class="form-label">
                    Descripción
                </label>
                <input type="text" class="form-control form-control-sm" id="number-inventory" placeholder="Silla café con patas de metal" disabled>
            </fieldset>

            <fieldset class="col-sm-1">
                <label>
                    &nbsp;
                </label>
                <br>
                <a class="btn btn-sm btn-block btn-primary" href="{{ route('inventories.details') }}">
                    <i class="fas fa-edit"></i>
                </a>
            </fieldset>
        </div>

        <div class="form-row mt-3">
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
                <input type="text" class="form-control form-control-sm" id="product" value="Silla" disabled readonly>
            </fieldset>

            <fieldset class="col-sm-4">
                <label for="number-inventory" class="form-label">
                    Descripción
                </label>
                <input type="text" class="form-control form-control-sm" id="number-inventory" placeholder="Silla café con patas de metal" disabled>
            </fieldset>

            <fieldset class="col-sm-1">
                <label>
                    &nbsp;
                </label>
                <br>
                <a class="btn btn-sm btn-block btn-primary" href="{{ route('inventories.details') }}">
                    <i class="fas fa-edit"></i>
                </a>
            </fieldset>
        </div>

        <div class="form-row mt-3">
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
                <input type="text" class="form-control form-control-sm" id="product" value="Silla" disabled readonly>
            </fieldset>

            <fieldset class="col-sm-4">
                <label for="number-inventory" class="form-label">
                    Descripción
                </label>
                <input type="text" class="form-control form-control-sm" id="number-inventory" placeholder="Silla café con patas de metal" disabled>
            </fieldset>

            <fieldset class="col-sm-1">
                <label>
                    &nbsp;
                </label>
                <br>
                <a class="btn btn-sm btn-block btn-primary" href="{{ route('inventories.details') }}">
                    <i class="fas fa-edit"></i>
                </a>
            </fieldset>
        </div>

        <div class="form-row mt-3">
            <fieldset class="col-sm-2">
                <label for="code" class="form-label">
                    Código
                </label>
                <input type="text" class="form-control form-control-sm" id="code" value="56101703" disabled readonly>
            </fieldset>

            <fieldset class="col-sm-3">
                <label for="product" class="form-label">
                    Producto
                </label>
                <input type="text" class="form-control form-control-sm" id="product" value="Escritorios" disabled readonly>
            </fieldset>

            <fieldset class="col-sm-4">
                <label for="number-inventory" class="form-label">
                    Descripción
                </label>
                <input type="text" class="form-control form-control-sm" id="number-inventory" placeholder="Escritorio de melamina en L" disabled>
            </fieldset>

            <fieldset class="col-sm-1">
                <label>
                    &nbsp;
                </label>
                <br>
                <a class="btn btn-sm btn-block btn-primary" href="{{ route('inventories.details') }}">
                    <i class="fas fa-edit"></i>
                </a>
            </fieldset>
        </div>

        <div class="form-row mt-3">
            <fieldset class="col-sm-2">
                <label for="code" class="form-label">
                    Código
                </label>
                <input type="text" class="form-control form-control-sm" id="code" value="56101703" disabled readonly>
            </fieldset>

            <fieldset class="col-sm-3">
                <label for="product" class="form-label">
                    Producto
                </label>
                <input type="text" class="form-control form-control-sm" id="product" value="Escritorios" disabled readonly>
            </fieldset>

            <fieldset class="col-sm-4">
                <label for="number-inventory" class="form-label">
                    Descripción
                </label>
                <input type="text" class="form-control form-control-sm" id="number-inventory" placeholder="Escritorio de melamina en L" disabled>
            </fieldset>

            <fieldset class="col-sm-1">
                <label>
                    &nbsp;
                </label>
                <br>
                <a class="btn btn-sm btn-block btn-primary" href="{{ route('inventories.details') }}">
                    <i class="fas fa-edit"></i>
                </a>
            </fieldset>
        </div>

        <div class="form-row mt-3">
            <fieldset class="col-sm-2">
                <label for="code" class="form-label">
                    Código
                </label>
                <input type="text" class="form-control form-control-sm" id="code" value="44121709" disabled readonly>
            </fieldset>

            <fieldset class="col-sm-3">
                <label for="product" class="form-label">
                    Producto
                </label>
                <input type="text" class="form-control form-control-sm" id="product" value="Impresora Laser" disabled readonly>
            </fieldset>

            <fieldset class="col-sm-4">
                <label for="number-inventory" class="form-label">
                    Descripción
                </label>
                <input type="text" class="form-control form-control-sm" id="number-inventory" placeholder="Impresora multifuncional con scanner" disabled>
            </fieldset>

            <fieldset class="col-sm-1">
                <label>
                    &nbsp;
                </label>
                <br>
                <a class="btn btn-sm btn-block btn-primary" href="{{ route('inventories.details') }}">
                    <i class="fas fa-edit"></i>
                </a>
            </fieldset>
        </div>


@endsection
