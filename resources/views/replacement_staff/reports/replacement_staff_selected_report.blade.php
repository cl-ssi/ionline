@extends('layouts.app')

@section('title', 'Listado de STAFF')

@section('content')

@include('replacement_staff.nav')

<div class="row">
    <div class="col-sm-8">
        <h4 class="mb-3"><i class="far fa-file-alt"></i> Reporte: RR.HH. con Proceso de Selección Terminado </h4>
    </div>
</div>

<div class="table-responsive">
    <table class="table table-sm table-striped table-bordered">
        <thead class="text-center small">
            <tr>
                <th>#</th>
                <th>Nombre</th>
                <th>Solicitud</th>
                <th>Fecha Inicio</th>
                <th>Fecha Termino</th>
                <th>Periodo desde Termino</th>
                <!-- <th style="width: 8%">Fecha</th>
                <th>Solicitud</th>
                <th>Grado</th>
                <th>Calidad Jurídica</th>
                <th>Periodo</th>
                <th>Fundamento</th>
                <th>Solicitante</th>
                <th>Estado</th>
                <th style="width: 2%"></th> -->
                <th></th>
            </tr>
        </thead>
        <tbody class="small">
          @foreach($applicants as $key => $applicant)
            <tr>
                <td>{{ $key+1 }}</td>
                <td><a href="{{ route('replacement_staff.show_replacement_staff', $applicant->replacementStaff) }}" target="_blank">{{ $applicant->replacementStaff->FullName }}</a></td>
                <td><a href="{{ route('replacement_staff.request.technical_evaluation.edit', $applicant->technicalEvaluation) }}" target="_blank">{{ $applicant->technicalEvaluation->requestReplacementStaff->name }}</a></td>
                <td>{{ $applicant->start_date->format('d-m-Y') }}</td>
                <td>{{ $applicant->end_date->format('d-m-Y') }}</td>
                <td>{{ $applicant->end_date->diffForHumans() }}</td>
                <td>
                  <button type="button" class="btn btn-primary btn-sm">
                    <i class="fas fa-calendar-check"></i>
                  </button>
                </td>
            </tr>
          @endforeach
        </tbody>
    </table>
</div>

@endsection

@section('custom_js')

@endsection
