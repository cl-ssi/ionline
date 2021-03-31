@extends('layouts.app')

@section('title', 'Reporte para pagos')

@section('content')

@include('service_requests.partials.nav')

<h3 class="mb-3">Reporte sin Datos Bancarios</h3>

<h4 class="mb-3 mt-3">Sin Datos</h4>

<table class="table table-sm table-bordered">
    <tr>
        <th>Nombre</th>
        <th nowrap>Rut</th>
        <th>Servicio o Unidad</th>
        <th>Teléfono</th>
        <th>Email</th>
    </tr>
    @foreach($servicerequests as $servicerequest)
    <tr>
        <td>{{ $servicerequest->employee->getFullNameAttribute() ?? '' }}</td>
        <td>{{ $servicerequest->employee->runNotFormat() ?? '' }}</td>
        <td>{{ $servicerequest->responsabilityCenter->name ?? '' }}</td>
        <td>{{ $servicerequest->phone_number ?? '' }}</td>
        <td>{{ $servicerequest->email ?? '' }}</td>
    </tr>

    @endforeach
</table>

@endsection

@section('custom_js')


@endsection
