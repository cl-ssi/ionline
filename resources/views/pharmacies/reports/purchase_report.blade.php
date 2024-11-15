@extends('layouts.bt4.app')

@section('title', 'Informe de compras')

@section('content')

@include('pharmacies.nav')

<h3>Informe de compras</h3>

<form method="GET" class="form-horizontal" action="{{ route('pharmacies.reports.purchase_report') }}">
    <div class="input-group mb-3">
        <div class="input-group-prepend">
            <span class="input-group-text">Rango de fechas</span>
        </div>
        <input type="date" class="form-control" name="dateFrom" value="{{ request('dateFrom', now()->startOfMonth()->format('Y-m-d')) }}" required>
        <input type="date" class="form-control" name="dateTo" value="{{ request('dateTo', now()->endOfMonth()->format('Y-m-d')) }}" required>
    </div>

    <div class="input-group mb-3">
        <div class="input-group-prepend">
            <span class="input-group-text">Factura</span>
        </div>
        <input type="text" class="form-control" name="invoice" value="{{ request('invoice', '') }}">
        <div class="input-group-prepend">
            <span class="input-group-text">Acta</span>
        </div>
        <input type="text" class="form-control" name="acceptance_certificate" value="{{ request('acceptance_certificate', '') }}">
        <div class="input-group-prepend">
            <span class="input-group-text">Programa</span>
        </div>
        <input type="text" class="form-control" name="program" value="{{ request('program', '') }}">
    </div>

    <div class="input-group mb-3">
        <div class="input-group-prepend">
            <span class="input-group-text">Proveedores</span>
        </div>
        <select name="supplier_id" class="form-control">
            <option value="0" {{ request('supplier_id', 0) == 0 ? 'selected' : '' }}>Todos</option>
            @foreach ($suppliers as $supplier)
                <option value="{{ $supplier->id }}" {{ request('supplier_id') == $supplier->id ? 'selected' : '' }}>
                    {{ $supplier->name }}
                </option>
            @endforeach
        </select>
        <div class="input-group-append">
            <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i> Buscar</button>
        </div>
    </div>
</form>

<div class="table-responsive">
    <table class="table table-striped table-sm" id="tabla_compras">
        <thead>
            <tr>
                <th>Fecha</th>
                <th>Proveedor</th>
                <th>Factura</th>
                <th>Guía</th>
                <th>Fecha Factura</th>
                <th>Destino</th>
                <th>Fondos</th>
                <th>Acta</th>
                <th>
                    <button type="button" class="btn btn-sm btn-outline-primary"
                        onclick="window.location.href='{{ route('pharmacies.reports.download_purchase_report', request()->query()) }}'">
                        <i class="fas fa-download"></i>
                    </button>
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach($purchases as $purchase)
                <tr>
                    <td>{{ $purchase->date->format('d/m/Y') }}</td>
                    <td>{{ $purchase->supplier->name }}</td>
                    <td>{{ $purchase->invoice }}</td>
                    <td>{{ $purchase->despatch_guide }}</td>
                    <td>{{ $purchase->invoice_date }}</td>
                    <td>{{ $purchase->destination }}</td>
                    <td>{{ $purchase->from }}</td>
                    <td>{{ $purchase->id }}</td>
                    <td>
                        <a href="{{ route('pharmacies.products.purchase.edit', $purchase) }}"
                            class="btn btn-outline-secondary btn-sm">
                            <span class="fas fa-edit" aria-hidden="true"></span>
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

{{ $purchases->appends(request()->query())->links() }}

@endsection
