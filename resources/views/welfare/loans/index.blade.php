@extends('layouts.app')

@section('title', 'Prestamos')

@section('content')

@include('welfare.nav')

<h3>Carga de Prestamos SIRH</h3>
<form method="POST" action="{{ route('welfare.loans.import') }}" enctype="multipart/form-data">
    @csrf
    <div class="form-group">
        <label for="file">Archivo Excel de SIRH:</label>
        <input type="file" name="file" id="file">
    </div>
    <button type="submit" class="btn btn-primary">Importar datos de Excel</button>
</form>
<br><br><br>

<h5>Datos Actuales</h5>
<table class="table table-spacing">
    <thead>
        <tr class="bg-primary text-white">
            <th colspan="5">Datos Prestamos</th>
            <th colspan="4" class="bg-secondary text-white">Cuotas Morosas</th>
        </tr>
        <tr>
            <th class="bg-light">Folio</th>
            <th class="bg-light">Rut</th>
            <th class="bg-light">Nombre Completo</th>
            <th class="bg-light">Fecha</th>
            <th>Nº</th>
            <th>Nro-Moroso</th>
            <th>Interés-Moroso</th>
            <th>Amortización-Moroso</th>
            <th>Valor-Moroso</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($loans as $loan)
        <tr>
            <td>{{ $loan->folio }}</td>
            <td>{{ $loan->rut }}</td>
            <td>{{ $loan->names }}</td>
            <td>{{ $loan->date }}</td>
            <td>{{ $loan->number }}</td>
            <td>{{ $loan->late_number }}</td>
            <td>{{ $loan->late_interest }}</td>
            <td>{{ $loan->late_amortization }}</td>
            <td>{{ $loan->late_value }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
{{ $loans->links() }}
@endsection