@extends('layouts.mail')

@section('content')

<div style="text-align: justify;">

  <h4>Estimado/a: </h4>

  <br>

  <p>A través del presente, se informa ...:</p>

  <ul>
      <li><strong>Nº Solicitud</strong>: {{ $technicalEvaluation->requestReplacementStaff->id }}</li>
      <li><strong>Fecha Solicitud</strong>: {{ $technicalEvaluation->requestReplacementStaff->created_at->format('d-m-Y H:i:s') }}</li>
      <li><strong>Nombre Solicitud</strong>: {{ $technicalEvaluation->requestReplacementStaff->name }}</li>
      <li><strong>En el grado</strong>: {{ $technicalEvaluation->requestReplacementStaff->degree }}</li>
      <li><strong>Calidad Jurídica</strong>: {{ $technicalEvaluation->requestReplacementStaff->LegalQualityValue }}</li>
      <li><strong>La Persona cumplirá labores en Jornada</strong>: {{ $technicalEvaluation->requestReplacementStaff->WorkDayValue }} - {{ $technicalEvaluation->requestReplacementStaff->other_work_day }}</li>
      <li><strong>Justificación o fundamento de la Contratación</strong>: {{ $technicalEvaluation->requestReplacementStaff->FundamentValue }}</li>
      <li><strong>De funcionario</strong>: {{ $technicalEvaluation->requestReplacementStaff->name_to_replace }}</li>
      <li><strong>Otros (especifique)</strong>: {{ $technicalEvaluation->requestReplacementStaff->other_fundament }}</li>
      <li><strong>Periodo</strong>: {{ $technicalEvaluation->requestReplacementStaff->start_date->format('d-m-Y') }} - {{ $technicalEvaluation->requestReplacementStaff->end_date->format('d-m-Y') }}</li>
  </ul>

  <hr>

  <ul>
    @foreach($technicalEvaluation->applicants->where('selected', 1) as $applicant)
      <li><strong>Seleccionado</strong>: {{ $applicant->replacement_staff->FullName }}</li>
    @endforeach
  </ul>

  <hr>

  <ul>
      <li><strong>Solicitado por</strong>: {{ $technicalEvaluation->requestReplacementStaff->user->FullName }}</li>
      <li><strong>Unidad Organizacional</strong>: {{ $technicalEvaluation->requestReplacementStaff->organizationalUnit->name }}</li>
  </ul>

  <p>Para mayor infromación favor ingresar a su Bandeja de Solicitudes en iOnline.</p>

  <br>

  <p>Esto es un mensaje automatico de: {{ env('APP_NAME') }} -  {{ env('APP_SS') }}.</p>



</div>

@endsection
