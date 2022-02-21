@extends('layouts.app')

@section('title', 'Solicitudes de Contratación')

@section('content')

@include('service_requests.partials.nav')

<h3>Datos Adicionales - Listado de Solicitudes de Contratación de Servicio</h3><br>

<form method="GET" class="form-horizontal" action="{{ route('rrhh.service-request.aditional_data_list') }}">
  <div class="form-row mb-3">
    <div class="col-6 col-md-3">
      <label>Unidad</label>
      <select class="form-control selectpicker" data-live-search="true" name="responsability_center_ou_id" data-size="5">
        <option value="">Todos</option>
        @foreach($responsabilityCenters as $key => $responsabilityCenter)
          <option value="{{$responsabilityCenter->id}}" @if($responsabilityCenter->id == $request->responsability_center_ou_id) selected @endif>{{$responsabilityCenter->name}}</option>
        @endforeach
      </select>
    </div>
    <div class="col-6 col-md-3">
      <label>Tipo</label>
      <select class="form-control selectpicker" data-live-search="true" name="program_contract_type" data-size="5">
        <option value="">Todos</option>
        <option value="Mensual" @if($request->program_contract_type == "Mensual") selected @endif>Mensual</option>
        <option value="Horas" @if($request->program_contract_type == "Horas") selected @endif>Horas</option>
      </select>
    </div>
    <div class="col-6 col-md-3">
      <label>Origen Financiamiento</label>
      <select class="form-control selectpicker" data-live-search="true" name="type" data-size="5">
        <option value="">Todos</option>
        <option value="Covid" @if($request->type == "Covid") selected @endif>Covid</option>
        <option value="Suma Alzada" @if($request->type == "Suma Alzada") selected @endif>Suma Alzada</option>
      </select>
    </div>
    <div class="col-6 col-md-3">
      <!-- <label>Estamento</label>
      <select class="form-control selectpicker" data-live-search="true" name="estate" data-size="5">
        <option value="">Todos</option>
        <option value="Profesional Médico" @if($request->estate == "Profesional Médico") selected @endif>Profesional Médico</option>
        <option value="Profesional" @if($request->estate == "Profesional") selected @endif>Profesional</option>
        <option value="Técnico" @if($request->estate == "Técnico") selected @endif>Técnico</option>
        <option value="Administrativo" @if($request->estate == "Administrativo") selected @endif>Administrativo</option>
        <option value="Farmaceutico" @if($request->estate == "Farmaceutico") selected @endif>Farmaceutico</option>
        <option value="Odontólogo" @if($request->estate == "Odontólogo") selected @endif>Odontólogo</option>
        <option value="Bioquímico" @if($request->estate == "Bioquímico") selected @endif>Bioquímico</option>
        <option value="Auxiliar" @if($request->estate == "Auxiliar") selected @endif>Auxiliar</option>
      </select> -->
      <label>Profesión</label>
      <select class="form-control selectpicker" data-live-search="true" name="profession_id" data-size="5">
        <option value="">Todos</option>
        @foreach($professions as $key => $profession)
          <option value="{{$profession->id}}" @if($profession->id == $request->profession_id) selected @endif>{{$profession->name}}</option>
        @endforeach
      </select>
    </div>
    <div class="col-6 col-md-3">
      <label>Establecimiento</label>
      <select class="form-control selectpicker" data-live-search="true" name="establishment_id" data-size="5">
        <option value="">Todos</option>
        <option value="1" @if($request->establishment_id == "1") selected @endif>Hospital Ernesto Torres Galdames</option>
        <option value="12" @if($request->establishment_id == "12") selected @endif>Dr. Héctor Reyno G.</option>
        <option value="0" @if($request->establishment_id == "0") selected @endif>Dirección SSI</option>
      </select>
    </div>
    <div class="col-6 col-md-3">
      <label>Id</label>
      <input type="text" class="form-control " name="id" value="{{$request->id}}">
    </div>
    <div class="col-6 col-md-3">
      <label>Profesional</label>
      <input type="text" class="form-control" name="name" value="{{$request->name}}">
    </div>
    <div class="col-6 col-md-3">
      <label>&nbsp;</label>
      <button type="submit" class="form-control btn btn-primary">
        <i class="fas fa-search"></i> Buscar
      </button>
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
      <!-- <td>{{ $serviceRequest->type }}</td> -->
      <td>{{ $serviceRequest->program_contract_type }}</td>
      <td>{{ $serviceRequest->type }}</td>
      <td nowrap>{{ \Carbon\Carbon::parse($serviceRequest->request_date)->format('d-m-Y') }}</td>
      <td nowrap>@if($serviceRequest->employee){{ $serviceRequest->employee->runNotFormat() }}@endif</td>
      <td nowrap>@if($serviceRequest->employee){{ $serviceRequest->employee->getFullNameAttribute() }}@endif</td>
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
        @if($serviceRequest->type == "Covid")
          @if($serviceRequest->program_contract_type == "Horas") <!-- && $serviceRequest->working_day_type == "HORA MÉDICA")-->
            @if($serviceRequest->SignatureFlows->whereNull('status')->count() > 1)
              <a data-toggle="modal" class="btn btn-outline-secondary btn-sm" id="a_modal_flow_incomplete">
              <i class="fas fa-file" style="color:#B9B9B9"></i></a>
            @else
              @if($serviceRequest->SignatureFlows->where('status',0)->count() > 0)
                <a data-toggle="modal" 	class="btn btn-outline-secondary btn-sm" id="a_modal_flow_rejected">
                <i class="fas fa-file" style="color:#B9B9B9"></i></a>
              @else
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
                  <a href="{{ route('rrhh.service-request.report.resolution-pdf', $serviceRequest) }}"
                    class="btn btn-outline-secondary btn-sm" target="_blank">
                  <span class="fas fa-file" aria-hidden="true"></span></a>
                @endif
              @endif
          @endif
        @else
          <a href="{{ route('rrhh.service-request.report.resolution-pdf-hsa', $serviceRequest) }}"
            class="btn btn-outline-secondary btn-sm" target="_blank">
          <span class="fas fa-file" aria-hidden="true"></span></a>
        @endif
      </td>
    </tr>
  @endforeach
  </tbody>
</table>
</div>

{{ $serviceRequests->appends(request()->query())->links() }}

@endsection

@section('custom_js')

<script>

</script>

@endsection
