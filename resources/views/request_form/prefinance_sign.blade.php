@extends('layouts.app')

@section('title', 'Formulario de Requerimientos')

@section('content')

<link href="{{ asset('css/bootstrap-select.min.css') }}" rel="stylesheet" type="text/css"/>
<link href="{{ asset('css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet" type="text/css"/>
<link href="{{ asset('css/steps.css') }}" rel="stylesheet" type="text/css"/>

<h4 class="mb-3">Formulario de Requerimiento - Autorización Refrendación Presupuestaria</h4>

@include('request_form.nav')

<div class="table-responsive">
    <h6><i class="fas fa-info-circle"></i> Detalle Formulario</h6>
    <table class="table table-sm table-striped table-bordered">
        <!-- <thead>
            <tr class="table-active">
                <th colspan="2">Formulario Contratación de Personal </th>
            </tr>
        </thead> -->
        <tbody class="small">
            <tr>
                <th class="table-active" style="width: 33%">Gasto Estimado</th>
                <td>${{ $requestForm->estimated_expense }}</td>
            </tr>
            <tr>
                <th class="table-active" scope="row">Nombre del Solicitante</th>
                <td>{{ $requestForm->creator->getFullNameAttribute()}}</td>
            </tr>
            <tr>
                <th class="table-active" scope="row">Unidad Organizacional</th>
                <td>{{ $requestForm->organizationalUnit->name}}</td>
            </tr>
            <tr>
                <th class="table-active" scope="row">Mecanismo de Compra</th>
                <td>{{ $requestForm->getPurchaseMechanism()}}</td>
            </tr>
            <tr>
                <th class="table-active" scope="row">Programa Asociado</th>
                <td>{{ $requestForm->program }}</td>
            </tr>
            <tr>
                <th class="table-active" scope="row">Justificación de Adquisición</th>
                <td>{{ $requestForm->justification }}</td>
            </tr>
            <tr>
                <th class="table-active" scope="row">Fecha de Creación</th>
                <td>{{ $requestForm->created_at }}</td>
            </tr>
        </tbody>
    </table>
</div>

<livewire:request-form.prefinance-authorization :requestForm="$requestForm" :eventType="$eventType" >

@endsection
