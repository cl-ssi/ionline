@extends('layouts.app')

@section('title', 'Reporte - Solicitudes con resolución cargada')

@section('content')

@include('service_requests.partials.nav')

<h3 class="mb-3">Reporte - Solicitudes con resolución cargada</h3>

<table class="table table-sm table-bordered">
    <tr>
        <th>Id</th>
        <th>Nombre</th>
        <th scope="col">F. Inicio</th>
        <th>Boleta</th>
    </tr>
    @foreach($serviceRequests as $key => $serviceRequest)
        <tr>
            <td rowspan="{{$serviceRequest->fulfillments->count()}}">{{$serviceRequest->id}}</td>
            <td rowspan="{{$serviceRequest->fulfillments->count()}}">{{$serviceRequest->name}}</td>
            @foreach($serviceRequest->fulfillments as $fulfillment)
                <td nowrap>{{ $fulfillment->start_date->format('d-m-Y') }}</td>
                <td> @if($fulfillment->has_invoice_file == 1) Sí @else No @endif</td>
            </tr>
        @endforeach
    @endforeach
</table>

@endsection

@section('custom_js')


@endsection
