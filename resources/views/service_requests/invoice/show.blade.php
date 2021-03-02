@extends('layouts.guest')

@section('title', 'Boleta de Honorario')

@section('content')

@if($sr === null)
<div class="alert alert-danger">
        <h4 class="alert-heading">No Posee Solicitudes de Pago de Honorario con este RUT.</h4>
</div>
@else
<h5 class="mb-3">información de sus solicitudes de pago de Honorario.</h5>
<hr>
<div class="table-responsive">
        <table class="table table-sm table-bordered small">
                <thead>
                        <tr>
                                <th>Id</th>
                                <th>Tipo de Contrato</th>
                                <th>Descripción de Servicio</th>
                                <th>Fecha de Solicitud</th>
                                <th>Inicio de Contrato</th>
                                <th>Fin de Contrato</th>
                                <th>Subir Boleta</th>
                        </tr>
                </thead>
                <tbody>
                        @foreach ($sr as $servicerequest)
                        <tr>
                                <td class="small">{{ $servicerequest->id ?? '' }}</td>
                                <td>{{ $servicerequest->type ?? '' }}</td>
                                <td class="small">{{ $servicerequest->service_description ?? '' }}</td>
                                <td>{{ $servicerequest->request_date->format('d-m-Y') ?? '' }}</td>
                                <td>{{ $servicerequest->start_date->format('d-m-Y') ?? '' }}</td>
                                <td>{{ $servicerequest->end_date->format('d-m-Y') ?? '' }}</td>
                                <td> <i class="fas fa-paperclip"></i></td>
                        </tr>
                        @endforeach
                </tbody>
        </table>
</div>
@endif


@endsection

@section('custom_js')

@endsection