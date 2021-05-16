@extends('layouts.app')

@section('title', 'Formulario')

@section('content')

<link href="{{ asset('css/bootstrap-select.min.css') }}" rel="stylesheet" type="text/css"/>
<link href="{{ asset('css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet" type="text/css"/>
<link href="{{ asset('css/steps.css') }}" rel="stylesheet" type="text/css"/>

<h3 class="mb-3">Formulario de Requerimiento</h3>

@include('request_form.nav')

<!-- <h5>Folio Depto. Abastecimiento: {{ $requestForm->FormRequestNumber }}</h5> -->

<table class="table table-sm table-bordered">
    <tr>
        <th colspan="6" class="table-active">Formulario Requerimiento N° {{ $requestForm->id }}</th>
    </tr>
    <tr>
        <th>Gasto Estimado</th>
        <td colspan="5">${{ $requestForm->estimated_expense }}</td>
    </tr>
    <tr>
        <th>Nombre Administrador de Contrato</th>
        <td>{{ $requestForm->creator->getFullNameAttribute()}}</td>
    </tr>
    <tr>
        <th>Programa Asociado</th>
        <td colspan="5">{{ $requestForm->program }}</td>
    </tr>
    <tr>
        <th>Justificación en Breve</th>
        <td colspan="5">{{ $requestForm->justification }}</td>
    </tr>
</table>



@endsection
