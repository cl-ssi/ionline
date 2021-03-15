@extends('layouts.guest')

@section('title', 'Boleta de Honorario')

@section('content')

@if(empty($serviceRequests))
<div class="alert alert-danger">
        <h4 class="alert-heading">No Posee Solicitudes de Pago de Honorario con este RUT.</h4>
</div>
@else
<h5 class="mb-3">Información de sus solicitudes de pago de Honorario.</h5>
<hr>


<div class="table-responsive">
        <table class="table table-sm table-bordered small">
                <thead>
                        <tr>
                                <th>Número de Solicitud de Servicio</th>
                                <th>Id</th>
                                <th>Año</th>
                                <th>Mes</th>
                                <th>Cargar Boleta</th>
                        </tr>
                </thead>
                <tbody>

                
                        @foreach ($serviceRequests as $serviceRequest)                        
                        @foreach($serviceRequest->fulfillments as $fullfillment)        
                        
                        <tr>
                                <td class="small">{{ $serviceRequest->id ?? '' }}</td>
                                <td class="small">{{ $fullfillment->id ?? '' }}</td>
                                <td>{{ $fullfillment->year ?? '' }}</td>
                                <td>{{ $fullfillment->month ?? '' }}</td>                                
                                <td>

                                @livewire('service-request.upload-invoice', ['fulfillment' => $fullfillment])
                                </td>
                        </tr>                        
                        @endforeach
                        @endforeach
                </tbody>
        </table>
</div>
@endif


@endsection

@section('custom_js')

@endsection