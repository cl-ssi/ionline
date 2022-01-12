@extends('layouts.mail')

@section('content')

<div style="text-align: justify;">

  <h4>Estimado/a: </h4>

  <br>

  <p>A través del presente, se informa la finalización de la <strong>Solicitud de Contratación</strong>:</p>

  <ul>
      <li><strong>Nº Solicitud</strong>: {{ $technicalEvaluation->requestReplacementStaff->id }}</li>
      <li><strong>Fecha Solicitud</strong>: {{ $technicalEvaluation->requestReplacementStaff->created_at->format('d-m-Y H:i:s') }}</li>
      <li><strong>Nombre Solicitud</strong>: {{ $technicalEvaluation->requestReplacementStaff->name }}</li>
      <li><strong>Estamento</strong>: {{ $technicalEvaluation->requestReplacementStaff->profile_manage->name }} <strong>Grado</strong>: {{ $technicalEvaluation->requestReplacementStaff->degree }}</li>
      <li><strong>Calidad Jurídica</strong>: {{ $technicalEvaluation->requestReplacementStaff->legalQualityManage->NameValue }}</li>
      <li><strong>La Persona cumplirá labores en Jornada</strong>: {{ $technicalEvaluation->requestReplacementStaff->WorkDayValue }} - {{ $technicalEvaluation->requestReplacementStaff->other_work_day }}</li>
      <li><strong>Fundamento de la Contratación</strong>: {{ $technicalEvaluation->requestReplacementStaff->fundamentManage->NameValue }}</li>
      <li><strong>De funcionario</strong>: {{ $technicalEvaluation->requestReplacementStaff->name_to_replace }}</li>
      <li><strong>Otro Fundamento (especifique)</strong>: {{ $technicalEvaluation->requestReplacementStaff->other_fundament }}</li>
      <li><strong>Periodo</strong>: {{ $technicalEvaluation->requestReplacementStaff->start_date->format('d-m-Y') }} - {{ $technicalEvaluation->requestReplacementStaff->end_date->format('d-m-Y') }}</li>
      <li><strong>Lugar de Desempeño</strong>: {{ $technicalEvaluation->requestReplacementStaff->ouPerformance->name }}</li>
  </ul>

  <hr>

  @if($technicalEvaluation->reason == null)

      <ul>
        @foreach($technicalEvaluation->applicants->where('selected', 1) as $applicant)
          <li><strong>Seleccionado</strong>: {{ $applicant->replacementStaff->FullName }}</li>
          <li><strong>Fecha Efectiva de Ingreso</strong>: {{ $applicant->start_date->format('d-m-Y') }}</li>
          <li><strong>Fin</strong>: {{ $applicant->end_date->format('d-m-Y') }}</li>
        @endforeach
      </ul>

  @else
      <p>La presente <strong>Solicitud de Contratación</strong> no se efectúa por:</p>
      <ul>
          <li><strong>Motivo:</strong> {{ $technicalEvaluation->ReasonValue }}</li>
          <li><strong>Observación:</strong> {{ $technicalEvaluation->observation }}</li>
          <li><strong>Fecha:</strong> {{ $technicalEvaluation->date_end->format('d-m-Y H:i:s') }}</li>
      </ul>
  @endif

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
