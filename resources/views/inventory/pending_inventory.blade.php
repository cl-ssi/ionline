@extends('layouts.app')

@section('title', 'Bandeja Pendiente de Inventario')

@section('content')

@include('inventory.nav')

<h4>
    Bandeja Pendiente de Inventario
</h4>

<div class="card">
    <div class="card-body">

        <div class="form-row">
            <fieldset class="col-sm-1">
                <label for="code" class="form-label">
                    Código
                </label>
                <input type="text" class="form-control form-control-sm" id="code" value="56101504" disabled readonly>
            </fieldset>

            <fieldset class="col-sm-4">
                <label for="product" class="form-label">
                    Producto
                </label>
                <input type="text" class="form-control form-control-sm" id="product" value="Silla" disabled readonly>
            </fieldset>

            <fieldset class="col-sm-3">
                <label for="number-inventory" class="form-label">
                    Número de Inventario
                </label>
                <input type="text" class="form-control form-control-sm" id="number-inventory" placeholder="Ej. 222333444">
            </fieldset>

            <fieldset class="col-sm-2">
                <label for="useful-life" class="form-label">
                    Vida Útil
                </label>
                <input type="text" class="form-control form-control-sm" id="useful-life" value="" placeholder="Ej. 1 año">
            </fieldset>

            <fieldset class="col-sm-2">
                <label>
                    &nbsp;
                </label>
                <br>
                <button class="btn btn-sm btn-block btn-primary">
                    <i class="fas fa-save"></i> Guardar
                </button>
            </fieldset>
        </div>

        <div class="form-row mt-3">
            <fieldset class="col-sm-1">
                <label for="code" class="form-label">
                    Código
                </label>
                <input type="text" class="form-control form-control-sm" id="code" value="56101504" disabled readonly>
            </fieldset>

            <fieldset class="col-sm-4">
                <label for="product" class="form-label">
                    Producto
                </label>
                <input type="text" class="form-control form-control-sm" id="product" value="Silla" disabled readonly>
            </fieldset>

            <fieldset class="col-sm-3">
                <label for="number-inventory" class="form-label">
                    Número de Inventario
                </label>
                <input type="text" class="form-control form-control-sm" id="number-inventory" placeholder="Ej. 222333444">
            </fieldset>

            <fieldset class="col-sm-2">
                <label for="useful-life" class="form-label">
                    Vida Útil
                </label>
                <input type="text" class="form-control form-control-sm" id="useful-life" placeholder="Ej. 1 año">
            </fieldset>

            <fieldset class="col-sm-2">
                <label>
                    &nbsp;
                </label>
                <br>
                <button class="btn btn-sm btn-block btn-primary">
                    <i class="fas fa-save"></i> Guardar
                </button>
            </fieldset>
        </div>

        <div class="form-row mt-3">
            <fieldset class="col-sm-1">
                <label for="code" class="form-label">
                    Código
                </label>
                <input type="text" class="form-control form-control-sm" id="code" value="56101504" disabled readonly>
            </fieldset>

            <fieldset class="col-sm-4">
                <label for="product" class="form-label">
                    Producto
                </label>
                <input type="text" class="form-control form-control-sm" id="product" value="Silla" disabled readonly>
            </fieldset>

            <fieldset class="col-sm-3">
                <label for="number-inventory" class="form-label">
                    Número de Inventario
                </label>
                <input type="text" class="form-control form-control-sm" id="number-inventory" placeholder="Ej. 222333444">
            </fieldset>

            <fieldset class="col-sm-2">
                <label for="useful-life" class="form-label">
                    Vida Útil
                </label>
                <input type="text" class="form-control form-control-sm" id="useful-life" placeholder="Ej. 1 año">
            </fieldset>

            <fieldset class="col-sm-2">
                <label>
                    &nbsp;
                </label>
                <br>
                <button class="btn btn-sm btn-block btn-primary">
                    <i class="fas fa-save"></i> Guardar
                </button>
            </fieldset>
        </div>

        <div class="form-row mt-3">
            <fieldset class="col-sm-1">
                <label for="code" class="form-label">
                    Código
                </label>
                <input type="text" class="form-control form-control-sm" id="code" value="56101703" disabled readonly>
            </fieldset>

            <fieldset class="col-sm-4">
                <label for="product" class="form-label">
                    Producto
                </label>
                <input type="text" class="form-control form-control-sm" id="product" value="Escritorios" disabled readonly>
            </fieldset>

            <fieldset class="col-sm-3">
                <label for="number-inventory" class="form-label">
                    Número de Inventario
                </label>
                <input type="text" class="form-control form-control-sm" id="number-inventory" placeholder="Ej. 222333444">
            </fieldset>

            <fieldset class="col-sm-2">
                <label for="useful-life" class="form-label">
                    Vida Útil
                </label>
                <input type="text" class="form-control form-control-sm" id="useful-life" placeholder="Ej. 1 año">
            </fieldset>

            <fieldset class="col-sm-2">
                <label>
                    &nbsp;
                </label>
                <br>
                <button class="btn btn-sm btn-block btn-primary">
                    <i class="fas fa-save"></i> Guardar
                </button>
            </fieldset>
        </div>

        <div class="form-row mt-3">
            <fieldset class="col-sm-1">
                <label for="code" class="form-label">
                    Código
                </label>
                <input type="text" class="form-control form-control-sm" id="code" value="56101703" disabled readonly>
            </fieldset>

            <fieldset class="col-sm-4">
                <label for="product" class="form-label">
                    Producto
                </label>
                <input type="text" class="form-control form-control-sm" id="product" value="Escritorios" disabled readonly>
            </fieldset>

            <fieldset class="col-sm-3">
                <label for="number-inventory" class="form-label">
                    Número de Inventario
                </label>
                <input type="text" class="form-control form-control-sm" id="number-inventory" placeholder="Ej. 222333444">
            </fieldset>

            <fieldset class="col-sm-2">
                <label for="useful-life" class="form-label">
                    Vida Útil
                </label>
                <input type="text" class="form-control form-control-sm" id="useful-life" placeholder="Ej. 1 año">
            </fieldset>

            <fieldset class="col-sm-2">
                <label>
                    &nbsp;
                </label>
                <br>
                <button class="btn btn-sm btn-block btn-primary">
                    <i class="fas fa-save"></i> Guardar
                </button>
            </fieldset>
        </div>

        <div class="form-row mt-3">
            <fieldset class="col-sm-1">
                <label for="code" class="form-label">
                    Código
                </label>
                <input type="text" class="form-control form-control-sm" id="code" value="44121709" disabled readonly>
            </fieldset>

            <fieldset class="col-sm-4">
                <label for="product" class="form-label">
                    Producto
                </label>
                <input type="text" class="form-control form-control-sm" id="product" value="Impresora Laser" disabled readonly>
            </fieldset>

            <fieldset class="col-sm-3">
                <label for="number-inventory" class="form-label">
                    Número de Inventario
                </label>
                <input type="text" class="form-control form-control-sm" id="number-inventory" placeholder="Ej. 222333444">
            </fieldset>

            <fieldset class="col-sm-2">
                <label for="useful-life" class="form-label">
                    Vida Útil
                </label>
                <input type="text" class="form-control form-control-sm" id="useful-life" placeholder="Ej. 1 año">
            </fieldset>

            <fieldset class="col-sm-2">
                <label>
                    &nbsp;
                </label>
                <br>
                <button class="btn btn-sm btn-block btn-primary">
                    <i class="fas fa-save"></i> Guardar
                </button>
            </fieldset>
        </div>

    </div>
</div>

@endsection
