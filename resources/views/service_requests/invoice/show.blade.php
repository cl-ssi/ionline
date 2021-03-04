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
@livewire('invoice.list' )

<div class="table-responsive">
        <table class="table table-sm table-bordered small">
                <thead>
                        <tr>
                                <th>Id</th>
                                <th>Nombre</th>                                
                        </tr>
                </thead>
                <tbody>

                
                        @foreach ($serviceRequests as $serviceRequest)                        
                        @foreach($serviceRequest->fulfillments as $fullfillment)
                        <tr>
                                <td class="small">{{ $fullfillment->id ?? '' }}</td>                                
                                <td> <i class="fas fa-paperclip"></i></td>
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