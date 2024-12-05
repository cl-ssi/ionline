@extends('layouts.bt4.app')

@section('title', 'Reporte Refrendación')

@section('content')

@include('pharmacies.nav')

<h3>Reporte Refrendación</h3>

<form method="GET" action="{{ route('pharmacies.reports.endorsementReport') }}">
    <div class="row mb-3">
        <div class="col-md-3">
            <label for="year">Año</label>
            <select id="year" name="year" class="form-control">
                @for ($i = now()->year; $i >= now()->year - 10; $i--)
                    <option value="{{ $i }}" {{ $year == $i ? 'selected' : '' }}>{{ $i }}</option>
                @endfor
            </select>
        </div>
        <div class="col-md-3">
            <label for="month">Mes</label>
            <select id="month" name="month" class="form-control">
                @foreach (range(1, 12) as $m)
                    <option value="{{ $m }}" {{ $month == $m ? 'selected' : '' }}>
                        {{ DateTime::createFromFormat('!m', $m)->format('F') }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3 d-flex align-items-end">
            <button type="submit" class="btn btn-primary">Filtrar</button>
        </div>
    </div>
</form>

</main>




<main>

<table class="table table-striped table-bordered">
    <thead>
        <tr>
            <th>Validación</th>
            <th>Servicio de Salud</th>
            <th>Año</th>
            <th>Mes</th>
            <th>Programa - Medicamento</th>
            <th>Cantidad mensual programada</th>
            <th>Cantidad recepción</th>
            <th>Fecha recepción</th>
            <th>Proveedor</th>
            <th>N° Orden Compra</th>
            <th>N° Factura</th>
            <th>Fecha emisión de factura</th>
            <th>Fecha vencimiento de factura</th>
            <th>Valor del producto</th>
            <th>Comisión intermediación</th>
            <th>Cantidad despachada</th>
            <th>Modalidad de compra</th>
            <th>Observaciones</th>
        </tr>
    </thead>
    <tbody>
        @forelse($items as $item)
            <tr>
                @foreach($item as $value)
                    <td>{{ $value }}</td>
                @endforeach
            </tr>
        @empty
            <tr>
                <td colspan="18" class="text-center">No hay datos disponibles para los filtros seleccionados.</td>
            </tr>
        @endforelse
    </tbody>
</table>

</main>

@endsection
