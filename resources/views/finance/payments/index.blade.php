@extends('layouts.app')

@section('title', 'Estados de pago')

@section('content')

<h3 class="mb-3">Estados de pago</h3>

<h5 class="mb-3">Pendientes</h5>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>FR</th>
            <th>OC</th>
            <th>Bolatas/Facturas</th>
            <th>Recepción</th>
            <th>Otros</th>
            <th>Estado</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>
                <button class="btn btn-primary">
                    <i class="fas fa-file"></i> FR# 23234
                </button>
            </td>
            <td>13241324-23-234</td>
            <td class="text-center">
                <button class="btn btn-sm btn-outline-primary">
                    <i class="fas fa-file"></i> 421
                </button>
                <button class="btn btn-sm btn-outline-primary">
                    <i class="fas fa-file"></i> 423
                </button>
            </td>
            <td class="text-center">
                <button class="btn btn-sm btn-outline-danger">
                    <i class="fas fa-file-pdf"></i>
                </button>
            </td>
            <td>

            </td>
            <td>
                Livewire
                <br>
                Fecha:
                <input type="date" class="form-control">
                Estado:
                <select class="form-control">
                    <option value="">Pendiente</option>
                    <option value="">Pagado</option>
                </select>

                <button class="btn btn-success">
                    <i class="fas fa-save"></i> Guardar
                </button>
            </td>
        </tr>
    </tbody>
</table>




<h5 class="mb-3">Pagados</h5>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>FR</th>
            <th>OC</th>
            <th>Bolatas/Facturas</th>
            <th>Recepción</th>
            <th>Otros</th>
            <th>Estado</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>
                <button class="btn btn-primary">
                    <i class="fas fa-file"></i> FR# 23234
                </button>
            </td>
            <td>13241324-23-234</td>
            <td class="text-center">
                <button class="btn btn-sm btn-outline-primary">
                    <i class="fas fa-file"></i> 421
                </button>
                <button class="btn btn-sm btn-outline-primary">
                    <i class="fas fa-file"></i> 423
                </button>
            </td>
            <td class="text-center">
                <button class="btn btn-sm btn-outline-danger">
                    <i class="fas fa-file-pdf"></i>
                </button>
            </td>
            <td>

            </td>
            <td>
                Fecha: 2342-23-23<br>
                Estado: Pagado
            </td>
        </tr>
    </tbody>
</table>

@endsection