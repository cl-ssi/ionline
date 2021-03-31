@extends('layouts.app')

@section('title', 'Reporte - Solicitudes con resolución cargada')

@section('content')

@include('service_requests.partials.nav')

<h3 class="mb-3">Reporte - Solicitudes con resolución cargada</h3>

<table class="table table-sm table-bordered">
    <tr>
        <th>Nro.</th>
        <th>Id. solicitud</th>
        <th>Nombre</th>
        <th>Teléfono</th>
        <th scope="col">F. Inicio</th>
        <th scope="col">F. Pago</th>
        <th>Boleta</th>
    </tr>
    @foreach($serviceRequests as $key => $serviceRequest)
        <tr>
            <td rowspan="{{$serviceRequest->fulfillments->count()}}">{{$key + 1}}</td>
            <td rowspan="{{$serviceRequest->fulfillments->count()}}">{{$serviceRequest->id}}</td>
            <td rowspan="{{$serviceRequest->fulfillments->count()}}">{{$serviceRequest->employee->getFullNameAttribute()}}</td>
            <td rowspan="{{$serviceRequest->fulfillments->count()}}">{{$serviceRequest->phone_number}}</td>
            @foreach($serviceRequest->fulfillments as $fulfillment)
                <td nowrap>{{ $fulfillment->start_date->format('d-m-Y') }}</td>
                <td nowrap>{{ ($fulfillment->payment_date) ? $fulfillment->payment_date->format('d-m-Y') : ''}}</td>
                <td> @if($fulfillment->has_invoice_file == 1) Sí @else No @endif</td>
            </tr>
        @endforeach
    @endforeach
</table>
{{ $serviceRequests->links() }}
@endsection

@section('custom_js')


@endsection
