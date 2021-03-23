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
                                <th>ID</th>
                                <th>Tipo Contrato</th>
                                <th>Jornada de Trabajo</th>
                                <th>Estado</th>
                                <th class="text-center">Visaciones</th>
                                <!-- <th>ID Cumplimiento</th> -->
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
                                <td>@if($serviceRequest->SignatureFlows->where('status','===',0)->count() > 0) Rechazada
                  									@elseif($serviceRequest->SignatureFlows->whereNull('status')->count() > 0) Pendiente
                  									@else Finalizada @endif</td>
                                <td class="p-0">
                                  <table class="table table-sm table-bordered small">
                                      <tbody>
                                        @foreach($serviceRequest->SignatureFlows->sortBy('sign_position') as $key => $SignatureFlow)
                                          @if($SignatureFlow->status === null)
                                            <tr class="bg-light">
                                          @elseif($SignatureFlow->status === 0)
                                            <tr class="bg-danger">
                                          @elseif($SignatureFlow->status === 1)
                                            <tr>
                                          @elseif($SignatureFlow->status === 2)
                                            <tr class="bg-warning">
                                          @endif
                                            <td>{{ $SignatureFlow->signature_date->format('Y-m-d H:i')}}</td>
                                            <td>{{ $SignatureFlow->user->getShortNameAttribute() }}</td>
                                            <!-- <td>@if($SignatureFlow->status === null)
                                                @elseif($SignatureFlow->status === 1) Aceptada
                                                @elseif($SignatureFlow->status === 0) Rechazada
                                                @elseif($SignatureFlow->status === 2) Devuelta
                                                @endif</td> -->
                                          </tr>
                                        @endforeach
                                      </tbody>
                                  </table>

                                </td>
                                <!-- <td class="small">{{ $fullfillment->id ?? '' }}</td> -->
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
