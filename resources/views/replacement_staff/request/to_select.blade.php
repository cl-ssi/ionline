@extends('layouts.app')

@section('title', 'Listado de STAFF')

@section('content')

@include('replacement_staff.nav')

<h4 class="mb-3">Selección de Postulantes</h4>

<table class="table table-sm table-bordered">
    <thead>
        <tr class="table-active">
          <th colspan="3">Resumen de Postulación</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <th class="table-active">Por medio del presente, la Subdirección</th>
            <td colspan="2">{{ $requestReplacementStaff->RequestSing->organizationalUnitSub->name }}</td>
        </tr>
        <tr>
            <th class="table-active">En el grado</th>
            <td colspan="2">{{ $requestReplacementStaff->degree }}</td>
        </tr>
        <tr>
            <th class="table-active">Calidad Jurídica</th>
            <td colspan="2">{{ $requestReplacementStaff->LegalQualityValue }}</td>
        </tr>
        <tr>
            <th class="table-active">La Persona cumplirá labores en Jornada</th>
            <td style="width: 33%">{{ $requestReplacementStaff->WorkDayValue }}</td>
            <td style="width: 33%">{{ $requestReplacementStaff->other_work_day }}</td>
        </tr>
        <tr>
            <th class="table-active">Justificación o fundamento de la Contratación</th>
            <td style="width: 33%">{{ $requestReplacementStaff->FundamentValue }}</td>
            <td style="width: 33%">De funcionario: {{ $requestReplacementStaff->name_to_replace }}</td>
        </tr>
        <tr>
            <th class="table-active">Otros (especifique)</th>
            <td colspan="2">{{ $requestReplacementStaff->other_fundament }}</td>
        </tr>
    </tbody>
</table>

<div class="card">
    <div class="card-header">
        Formulario Solicitud Contratación de Personal
    </div>
    <div class="card-body">

    </div>
</div>

@endsection

@section('custom_js')

@endsection
