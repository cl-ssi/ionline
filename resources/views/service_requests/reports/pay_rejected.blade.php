@extends('layouts.app')

@section('title', 'Reporte para pagos')

@section('content')

@include('service_requests.partials.nav')

<h3 class="mb-3">Pagos rechazados</h3>
<form method="GET" class="form-horizontal" action="{{ route('rrhh.service-request.report.pay-rejected') }}">
  <div class="input-group mb-3">
    <div class="input-group-prepend">
      <span class="input-group-text">Tipo de Contrato</span>
    </div>
    <select class="form-control selectpicker" data-live-search="true" name="program_contract_type" data-size="5">
      <option value="">Todos</option>
      <option value="Mensual" @if($request->program_contract_type == "Mensual") selected @endif>Mensual</option>
      <option value="Horas" @if($request->program_contract_type == "Horas") selected @endif>Horas</option>
    </select>

    <div class="input-group-prepend">
      <span class="input-group-text">Jornada</span>
    </div>
    <select class="form-control selectpicker" data-live-search="true" name="working_day_type" data-size="5">
      <option value="">Todos</option>
      <option value="DIURNO" @if($request->working_day_type == "DIURNO") selected @endif>DIURNO</option>
      <option value="TERCER TURNO" @if($request->working_day_type == "TERCER TURNO") selected @endif>TERCER TURNO</option>
      <option value="TERCER TURNO - MODIFICADO" @if($request->working_day_type == "TERCER TURNO - MODIFICADO") selected @endif>TERCER TURNO - MODIFICADO</option>
      <option value="CUARTO TURNO" @if($request->working_day_type == "CUARTO TURNO") selected @endif>CUARTO TURNO</option>
      <option value="CUARTO TURNO - MODIFICADO" @if($request->working_day_type == "CUARTO TURNO - MODIFICADO") selected @endif>CUARTO TURNO - MODIFICADO</option>
      <option value="DIURNO PASADO A TURNO" @if($request->working_day_type == "DIURNO PASADO A TURNO") selected @endif>DIURNO PASADO A TURNO</option>
      <option value="HORA MÉDICA" @if($request->working_day_type == "HORA MÉDICA") selected @endif>HORA MÉDICA</option>
      <option value="HORA EXTRA" @if($request->working_day_type == "HORA EXTRA") selected @endif>HORA EXTRA</option>
      <option value="TURNO EXTRA" @if($request->working_day_type == "TURNO EXTRA") selected @endif>TURNO EXTRA</option>
      <option value="TURNO DE REEMPLAZO" @if($request->working_day_type == "TURNO DE REEMPLAZO") selected @endif>TURNO DE REEMPLAZO</option>      
    </select>

    <div class="input-group-append">
        <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i> Buscar</button>
    </div>

  </div>

</form>


<table class="table table-sm table-bordered table-stripped">
  <tr>
    <th></th>
    <th>Id</th>
    <th>Establecimiento</th>
    <th>Tipo/Jornada</th>
    <th>Nombre</th>
    <th nowrap>Rut</th>
    <th>Periodo</th>
    <th>Banco - N° Cuenta</th>
    <th>Telefono</th>
    <th>Cer.</th>
    <th>Bol.</th>
    <th>Res.</th>
    <th>Motivo</th>
  </tr>
  @foreach($fulfillments->whereNull('total_paid') as $key => $fulfillment)
  <tr>
    <td>{{ ++$key }}</td>
    <td>
      @if($fulfillment->serviceRequest != null)
      <a href="{{ route('rrhh.service-request.fulfillment.edit',$fulfillment->serviceRequest) }}" title="Editar">
        {{$fulfillment->serviceRequest->id}}
      </a>
      @else

      @endif
    </td>
    <td class="small">{{$fulfillment->serviceRequest->establishment->name}}</td>
    <td>
      {{$fulfillment->serviceRequest->program_contract_type}}
      <br>
      {{$fulfillment->serviceRequest->working_day_type}}
    </td>
    <td>{{$fulfillment->serviceRequest->employee->fullName}}</td>
    <td nowrap>{{$fulfillment->serviceRequest->employee->runFormat()}}</td>
    <td>
      @if($fulfillment->year)
      {{ $fulfillment->year }}-{{ $fulfillment->month }}
      @else
      {{ $fulfillment->start_date->format('Y-m') }}
      @endif
    </td>
    <td class="small">{{$fulfillment->serviceRequest->employee->bankAccount->bank->name ?? ''}} - {{$fulfillment->serviceRequest->employee->bankAccount->number?? ''}}</td>
    <td>{{$fulfillment->serviceRequest->phone_number ?? ''}}</td>
    <td>
      @if($fulfillment->signatures_file_id)
      <a href="{{ route('rrhh.service-request.fulfillment.signed-certificate-pdf',$fulfillment) }}" target="_blank" title="Certificado">
        <i class="fas fa-signature"></i>
      </a>
      @else
      <a href="{{ route('rrhh.service-request.fulfillment.certificate-pdf',$fulfillment) }}" target="_blank" title="Certificado">
        <i class="fas fa-paperclip"></i>
      </a>
      @endif
    </td>
    <td>
      @if($fulfillment->has_invoice_file)
      <a href="{{route('rrhh.service-request.fulfillment.download_invoice', [$fulfillment, time()])}}" target="_blank" title="Boleta">
        <i class="fas fa-paperclip"></i>
      </a>
      @endif
    </td>
    <td>
      @if($fulfillment->serviceRequest->has_resolution_file)
      <a href="{{route('rrhh.service-request.fulfillment.download_resolution', $fulfillment->serviceRequest)}}" target="_blank" title="Resolución">
        <i class="fas fa-paperclip"></i>
      </a>
      @endif
    </td>
    <td>
      @livewire('service-request.payment-feedback-toggle', ['fulfillment' => $fulfillment])
    </td>
  </tr>
  @endforeach
</table>


@endsection

@section('custom_js')


@endsection