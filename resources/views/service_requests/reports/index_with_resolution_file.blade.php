@extends('layouts.app')

@section('title', 'Reporte - Solicitudes con resolución cargada')

@section('content')

@include('service_requests.partials.nav')

<h3 class="mb-3">Reporte - {{ $title }}</h3>

<table class="table table-sm table-bordered">
    <tr>
        <th>Nro.</th>
        <th>Id. solicitud</th>
        <th>Nombre</th>
        <th>Teléfono</th>
        <th>F. Inicio</th>
        <th>F. Término</th>
    </tr>
    @foreach($serviceRequests as $key => $serviceRequest)
        <tr>
            <td>{{$key + 1}}</td>
            <td>{{$serviceRequest->id}}</td>
            <td>{{$serviceRequest->employee->getFullNameAttribute()}}</td>
            <td>{{$serviceRequest->phone_number}}</td>
            <td>{{ optional($serviceRequest->start_date)->format('Y-m-d') }}</td>
            <td>{{ optional($serviceRequest->end_date)->format('Y-m-d') }}</td>
        </tr>
    @endforeach
</table>
{{ $serviceRequests->links() }}
@endsection

@section('custom_js')


@endsection
