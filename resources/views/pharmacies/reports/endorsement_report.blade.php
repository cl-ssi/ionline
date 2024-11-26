@extends('layouts.bt5.app')

@section('title', 'Informe de compras')

@section('content')

@include('pharmacies.nav')

<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>

<h3>Refrendación</h3>

<form method="GET" class="form-horizontal" action="{{ route('pharmacies.reports.endorsementReport') }}">
    <div class="input-group mb-3">
        <div class="input-group-prepend">
            <span class="input-group-text">Año</span>
        </div>
        <select class="form-control" name="year" required>
            @php
                $currentYear = now()->year;
                $startYear = $currentYear - 10;
            @endphp
            @for ($year = $startYear; $year <= $currentYear; $year++)
                <option value="{{ $year }}" {{ request('year', $currentYear) == $year ? 'selected' : '' }}>
                    {{ $year }}
                </option>
            @endfor
        </select>

        <div class="input-group-prepend">
            <span class="input-group-text">Mes</span>
        </div>
        <select class="form-control" name="month" required>
            @for ($month = 1; $month <= 12; $month++)
                <option value="{{ $month }}" {{ request('month', now()->month) == $month ? 'selected' : '' }}>
                    {{ \Carbon\Carbon::create()->month($month)->translatedFormat('F') }}
                </option>
            @endfor
        </select>

        <div class="input-group-append">
            <button type="submit" class="btn btn-primary">Buscar</button>
        </div>
    </div>
</form>

</main>

<main>

<!-- Botón de descarga -->
<div class="text-end mb-3">
    <button id="downloadExcel" class="btn btn-success">Descargar en Excel</button>
</div>

<table id="purchaseTable" class="table table-striped">
    <thead>
        <tr>
            <th>N</th>
            <th>ID</th>
            <th>Año</th>
            <th>Mes</th>
            <th>Programa, patologia, medicamento, zgen</th>
            <th>Cantidad mensual programada</th>
            <th>Cantidad recepción</th>
            <th>Fecha recepción</th>
            <th>Proveedor</th>
            <th>N orden compra</th>
            <th>N factura</th>
            <th>Fecha de emisión de factura</th>
            <th>Fecha de vencimiento de factura</th>
            <th>Valor del producto</th>
            <th>Comisión intermediación</th>
            <th>Cantidad despachada</th>
            <th>Modalidad de compra</th>
            <th>Observaciones</th>
        </tr>
    </thead>
    <tbody>
        @foreach($purchases as $key => $purchase)
            @foreach($purchase->purchaseItems as $item)
                <tr>
                    <td>{{ $key }}</td>
                    <td>{{ $purchase->id }}</td>
                    <td>{{ $year }}</td>
                    <td>{{ \Carbon\Carbon::create()->month($month)->translatedFormat('F') }}</td>
                    <td>{{ ($item->product->program->name ?? 'N/A') . ' - ' . ($item->product->name ?? 'N/A') }}</td>
                    <td>{{ $item->amount }}</td>
                    <td>{{ $item->amount }}</td> <!-- Using `amount` from PurchaseItem as per your correction -->
                    <td>{{ optional($purchase->date)->format('d-m-Y') ?? 'N/A' }}</td>
                    <td>{{ $purchase->supplier->name ?? 'N/A' }}</td>
                    <td>{{ $purchase->purchase_order }}</td>
                    <td>{{ $purchase->invoice }}</td>
                    <td>{{ optional($purchase->purchase_order_date)->format('d-m-Y') ?? 'N/A' }}</td>
                    <td>{{ optional($purchase->invoice_date)->format('d-m-Y') ?? 'N/A' }}</td>
                    <td>{{ number_format($item->amount, 0, ',', '.') }}</td>
                    <td>{{ $purchase->commission ?? 0 }}</td>
                    <td>{{ $item->amount }}</td>
                    <td>{{ $purchase->purchase_type ?? 'CENABAST' }}</td>
                    <td>{{ $purchase->notes }}</td>
                </tr>
            @endforeach
        @endforeach
    </tbody>

</table>

</main>

<script>
    document.getElementById('downloadExcel').addEventListener('click', function () {
        // Captura la tabla
        let table = document.getElementById('purchaseTable');

        // Convierte la tabla a una hoja de cálculo
        let wb = XLSX.utils.table_to_book(table, { sheet: "Refrandación" });

        // Descarga como archivo Excel
        XLSX.writeFile(wb, 'Data_Refrandacion.xlsx');
    });
</script>

@endsection
