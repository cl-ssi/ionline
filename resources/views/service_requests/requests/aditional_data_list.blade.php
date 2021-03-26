@extends('layouts.app')

@section('title', 'Solicitudes de Contratación')

@section('content')

@include('service_requests.partials.nav')

<h3>Datos Adicionales - Listado de Solicitudes de Contratación de Servicio</h3><br>

<form method="GET" class="form-horizontal" action="{{ route('rrhh.service-request.aditional_data_list') }}">
  <div class="input-group mb-3">
    <div class="input-group-prepend">
      <span class="input-group-text">Unidad</span>
    </div>
    <select class="form-control selectpicker" data-live-search="true" name="responsability_center_ou_id" data-size="5">
      <option value="">Todos</option>
      @foreach($responsabilityCenters as $key => $responsabilityCenter)
        <option value="{{$responsabilityCenter->id}}" @if($responsabilityCenter->id == $request->responsability_center_ou_id) selected @endif>{{$responsabilityCenter->name}}</option>
      @endforeach
    </select>
    <div class="input-group-prepend">
      <span class="input-group-text">Tipo</span>
    </div>
    <select class="form-control selectpicker" data-live-search="true" name="program_contract_type" data-size="5">
      <option value="">Todos</option>
      <option value="Mensual" @if($request->program_contract_type == "Mensual") selected @endif>Mensual</option>
      <option value="Horas" @if($request->program_contract_type == "Horas") selected @endif>Horas</option>
    </select>
    <div class="input-group-prepend">
      <span class="input-group-text">Id</span>
    </div>
    <input type="text" name="id" value="{{$request->id}}">
    <div class="input-group-prepend">
      <span class="input-group-text">Profesional</span>
    </div>
    <input type="text" name="name" value="{{$request->name}}">
    <div class="input-group-append">
        <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i> Buscar</button>
    </div>
  </div>
</form>

<hr>

<div class="table-responsive">
<table class="table table-striped table-sm table-bordered">
  <thead>
    <tr>
      <th scope="col">Id</th>
      <!-- <th scope="col">Tipo</th> -->
      <th scope="col">T.Contrato</th>
      <th scope="col">F. Solicitud</th>
      <th scope="col">Rut</th>
      <th scope="col">Funcionario</th>
      <th scope="col">F. Inicio</th>
      <th scope="col">F. Término</th>
      <th scope="col">Estado Solicitud</th>
      <th scope="col"></th>
      <th scope="col"></th>
    </tr>
  </thead>
  <tbody>
  @foreach($serviceRequests as $serviceRequest)
    <tr>
      <td>{{ $serviceRequest->id }}</td>
      <!-- <td>{{ $serviceRequest->type }}</td> -->
      <td>{{ $serviceRequest->program_contract_type }}</td>
      <td nowrap>{{ \Carbon\Carbon::parse($serviceRequest->request_date)->format('d-m-Y') }}</td>
      <td nowrap>{{ $serviceRequest->rut }}</td>
      <td nowrap>{{ $serviceRequest->name }}</td>
      <td nowrap>{{ \Carbon\Carbon::parse($serviceRequest->start_date)->format('d-m-Y') }}</td>
      <td nowrap>{{ \Carbon\Carbon::parse($serviceRequest->end_date)->format('d-m-Y') }}</td>
      <td>@if($serviceRequest->SignatureFlows->whereNull('status')->count() > 0) Pendiente
          @else Finalizada @endif</td>
      <td nowrap>
        <a href="{{ route('rrhh.service-request.edit', $serviceRequest) }}"
          class="btn btn-sm btn-outline-secondary">
          <span class="fas fa-edit" aria-hidden="true"></span>
        </a>
      </td>
      <td>
        @if($serviceRequest->program_contract_type == "Horas" && $serviceRequest->working_day_type == "HORA MÉDICA")
          @if($serviceRequest->SignatureFlows->whereNull('status')->count() > 1)
            <a data-toggle="modal" class="btn btn-outline-secondary btn-sm" id="a_modal_flow_incomplete">
            <i class="fas fa-file" style="color:#B9B9B9"></i></a>
          @else
            @if($serviceRequest->SignatureFlows->where('status',0)->count() > 0)
              <a data-toggle="modal" 	class="btn btn-outline-secondary btn-sm" id="a_modal_flow_rejected">
              <i class="fas fa-file" style="color:#B9B9B9"></i></a>
            @else
              <!-- <a href="#"
                class="btn btn-outline-secondary btn-sm" target="_blank">
              <span class="fas fa-plus" aria-hidden="true"></span></a> -->

              <a href="{{ route('rrhh.service-request.report.resolution-pdf', $serviceRequest) }}"
                class="btn btn-outline-secondary btn-sm" target="_blank">
              <span class="fas fa-file" aria-hidden="true"></span></a>
            @endif
          @endif
          @elseif($serviceRequest->program_contract_type == "Mensual")
            @if($serviceRequest->SignatureFlows->whereNull('status')->count() > 1)
              <a data-toggle="modal" class="btn btn-outline-secondary btn-sm" id="a_modal_flow_incomplete">
              <i class="fas fa-file" style="color:#B9B9B9"></i></a>
            @else
              @if($serviceRequest->SignatureFlows->where('status',0)->count() > 0)
                <a data-toggle="modal" 	class="btn btn-outline-secondary btn-sm" id="a_modal_flow_rejected">
                <i class="fas fa-file" style="color:#B9B9B9"></i></a>
              @else
                <!-- <a href="#"
                  class="btn btn-outline-secondary btn-sm" target="_blank">
                <span class="fas fa-plus" aria-hidden="true"></span></a> -->

                <a href="{{ route('rrhh.service-request.report.resolution-pdf', $serviceRequest) }}"
                  class="btn btn-outline-secondary btn-sm" target="_blank">
                <span class="fas fa-file" aria-hidden="true"></span></a>
              @endif
            @endif
        @endif
      </td>
    </tr>
  @endforeach
  </tbody>
</table>
</div>

{{ $serviceRequests->links() }}

@endsection

@section('custom_js')

<script>

</script>

@endsection
