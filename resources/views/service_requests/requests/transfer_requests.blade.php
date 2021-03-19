@extends('layouts.app')

@section('title', 'Transferencia de solicitudes')

@section('content')

<h3>Transferencia de solicitudes</h3><br>

@livewire('service-request.derive')
<hr>

@php
/*

<form method="GET" class="form-horizontal" action="{{ route('rrhh.service_requests.aditional_data_list') }}">
  <div class="input-group mb-3">
    <div class="input-group-prepend">
      <span class="input-group-text">Unidad</span>
    </div>
    <select class="form-control selectpicker" data-live-search="true" name="responsability_center_ou_id" data-size="5">
      <option value="">Todos</option>
      @foreach($users as $key => $user)
        <option value="{{$user->id}}">{{$user->getFullNameAttribute()}}</option>
      @endforeach
    </select>
    <div class="input-group-append">
        <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i> Buscar</button>
    </div>
  </div>
</form>




<h4>Hojas de ruta</h4>
<form method="POST" enctype="multipart/form-data" id="derive" action="{{ route('rrhh.service_requests.derive') }}">
@csrf

<div class="row">
  <fieldset class="form-group col">
      <label for="for_type">Origen</label>
      <select name="user_id" id="user_id" class="form-control selectpicker" data-live-search="true" data-size="5" required>
        <option value=""></option>
        @foreach($users as $key => $user)
          <option value="{{$user->id}}">{{$user->getFullNameAttribute()}}</option>
        @endforeach
      </select>
  </fieldset>

  <input type="hidden" class="form-control" name="sender_id" id="sender_id" value="">

  <fieldset class="form-group col">
      <label for="for_type">Disponibles para visar</label>
      <input type="text" class="form-control" name="disponibles_para_visar" id="disponibles_para_visar" value="0">
  </fieldset>

  <fieldset class="form-group col">
      <label for="for_type">No disponibles para visar</label>
      <input type="text" class="form-control" name="no_disponibles_para_visar" id="no_disponibles_para_visar" value="0">
  </fieldset>

  <fieldset class="form-group col">
      <label for="for_type">Destino</label>
      <select name="derive_user_id" id="derive_user_id" class="form-control selectpicker" data-live-search="true" data-size="5" required>
        <option value=""></option>
        @foreach($users as $key => $user)
          <option value="{{$user->id}}">{{$user->getFullNameAttribute()}}</option>
        @endforeach
      </select>
  </fieldset>

  <fieldset class="form-group col">
      <label for="for_type"><br></label>
      <button type="button" class="btn btn-primary form-control" id="button_derive">Derivar</button>
  </fieldset>
</div>

</form>

<hr>

<h4>Cumplimientos</h4>
<form method="GET" class="form-horizontal" action="{{ route('rrhh.service_requests.aditional_data_list') }}">
  <div class="input-group mb-3">
    <div class="input-group-prepend">
      <span class="input-group-text">Unidad</span>
    </div>
    <select class="form-control selectpicker" data-live-search="true" name="responsability_center_ou_id" data-size="5">
      <option value="">Todos</option>
      @foreach($responsabilityCenters as $key => $responsabilityCenter)
        <option value="{{$responsabilityCenter->id}}">{{$responsabilityCenter->name}}</option>
      @endforeach
    </select>
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
      <th scope="col">Tipo</th>
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
      <td>{{ $serviceRequest->type }}</td>
      <td nowrap>{{ \Carbon\Carbon::parse($serviceRequest->request_date)->format('d-m-Y') }}</td>
      <td nowrap>{{ $serviceRequest->rut }}</td>
      <td nowrap>{{ $serviceRequest->name }}</td>
      <td nowrap>{{ \Carbon\Carbon::parse($serviceRequest->start_date)->format('d-m-Y') }}</td>
      <td nowrap>{{ \Carbon\Carbon::parse($serviceRequest->end_date)->format('d-m-Y') }}</td>
      <td>@if($serviceRequest->SignatureFlows->whereNull('status')->count() > 0) Pendiente
          @else Finalizada @endif</td>
      <td nowrap>
        <a href="{{ route('rrhh.service_requests.edit', $serviceRequest) }}"
          class="btn btn-sm btn-outline-secondary">
          <span class="fas fa-edit" aria-hidden="true"></span>
        </a>
      </td>
      <td>
        @if($serviceRequest->program_contract_type == "Mensual")
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

              <a href="{{ route('rrhh.service_requests.resolution-pdf', $serviceRequest) }}"
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
*/
@endphp
@endsection

@section('custom_js')

<script>

</script>

@endsection
