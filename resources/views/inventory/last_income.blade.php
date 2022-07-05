@extends('layouts.app')

@section('title', 'Últimos ingresos')

@section('content')

@include('inventory.nav')

<h3 class="mb-3">
    Últimos ingresos a bodega
</h3>

<div class="table-responsive">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Ingreso a bodega</th>
                <th>Proveedor</th>
                <th>OC</th>
                <th>Producto</th>
                <th class="text-center">Cantidad</th>
                <th>Formulario</th>
                <th class="text-center" nowrap>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>2022-05-12</td>
                <td>Ganem LTDA</td>
                <td>12321-122-21AB</td>
                <td>Silla</td>
                <td class="text-center">03</td>
                <td><a href="#" class="link-primary">1233123</a></td>
                <td class="text-center" nowrap>
                    <button class="btn btn-sm btn-primary">
                        Inventariar
                    </button>
                    <button class="btn btn-sm btn-secondary">
                        No Inventariar
                    </button>
                </td>
            </tr>
            <tr>
                <td>2022-05-12</td>
                <td>Ganem LTDA</td>
                <td>12321-122-21AB</td>
                <td>Escritorio</td>
                <td class="text-center">02</td>
                <td><a href="#" class="link-primary">1233123</a></td>
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
                <td>2022-05-10</td>
                <td>Andigraf LTDA</td>
                <td>533-1544-232AB</td>
                <td>Lapiz rojo</td>
                <td class="text-center">10</td>
                <td><a href="#" class="link-primary">234234</a></td>
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
                <td>2022-05-10</td>
                <td>Andigraf LTDA</td>
                <td>533-1544-232AB</td>
                <td>Impresora Laser</td>
                <td class="text-center">01</td>
                <td><a href="#" class="link-primary">234234</a></td>
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
