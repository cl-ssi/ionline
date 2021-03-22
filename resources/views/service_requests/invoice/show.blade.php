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


@livewire('service-request.update-account' , ['serviceRequest' => $serviceRequests->last()])

<br><br><hr>

<div class="table-responsive">
        <table class="table table-sm table-bordered small">
                <thead>
                        <tr>
                                <th>ID Solicitud</th>
                                <th>Tipo de Contrato</th>
                                <th>Jornada de Trabajo</th>
                                <th>ID Cumplimiento</th>
                                <th>Año</th>
                                <th>Mes</th>
                                <th>Monto de Boleta</th>
                                <th>Cargar Boleta</th>
                        </tr>
                </thead>
                <tbody>

                
                        @foreach ($serviceRequests as $serviceRequest) 
                        @foreach($serviceRequest->fulfillments->reverse() as $fullfillment)
                        <tr></tr>
                        <tr>
                                <td class="small">{{ $serviceRequest->id ?? '' }}</td>                                
                                <td>{{ $serviceRequest->program_contract_type ?? '' }}</td>
                                <td>{{ $serviceRequest->working_day_type ?? '' }}</td>
                                <td class="small">{{ $fullfillment->id ?? '' }}</td>
                                <td>{{ $fullfillment->year ?? '' }}</td>
                                <td>{{ $fullfillment->month ?? '' }}</td>
                                <td>{{ $serviceRequest->gross_amount ?? '' }}</td>
                                <td>
                                @if($fullfillment->total_to_pay)
                                @livewire('service-request.upload-invoice', ['fulfillment' => $fullfillment])
                                @else
                                No se ha cargado información de Pago
                                @endif
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