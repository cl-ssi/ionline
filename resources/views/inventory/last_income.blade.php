@extends('layouts.app')

@section('title', 'Últimos ingresos')

@section('content')

@include('inventory.nav')

<h5>
    Empresa A - OC-2022-12 - Guia 123
</h5>

<div class="table-responsive">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Producto</th>
                <th class="text-center">Cantidad</th>
                <th class="text-center">Acciones</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Silla</td>
                <td class="text-center">03</td>
                <td class="text-center">
                    <button class="btn btn-sm btn-primary">
                        Inventariar
                    </button>
                    <button class="btn btn-sm btn-secondary">
                        No Inventariar
                    </button>
                </td>
            </tr>
            <tr>
                <td>Escritorio</td>
                <td class="text-center">02</td>
                <td class="text-center">
                    <button class="btn btn-sm btn-primary">
                        Inventariar
                    </button>
                    <button class="btn btn-sm btn-secondary">
                        No Inventariar
                    </button>
                </td>
            </tr>
        </tbody>
    </table>
</div>

<h5>
    Empresa B - OC-2022-12 - Factura 123
</h5>

<div class="table-responsive">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Producto</th>
                <th class="text-center">Cantidad</th>
                <th class="text-center">Acciones</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Lapiz rojo</td>
                <td class="text-center">10</td>
                <td class="text-center">
                    <button class="btn btn-sm btn-primary">
                        Inventariar
                    </button>
                    <button class="btn btn-sm btn-secondary">
                        No Inventariar
                    </button>
                </td>
            </tr>
            <tr>
                <td>Impresora Laser</td>
                <td class="text-center">01</td>
                <td class="text-center">
                    <button class="btn btn-sm btn-primary">
                        Inventariar
                    </button>
                    <button class="btn btn-sm btn-secondary">
                        No Inventariar
                    </button>
                </td>
            </tr>
        </tbody>
    </table>
</div>

@endsection
