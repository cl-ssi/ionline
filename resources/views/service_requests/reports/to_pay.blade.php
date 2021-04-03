@extends('layouts.app')

@section('title', 'Reporte para pagos')

@section('content')

@include('service_requests.partials.nav')

<h3 class="mb-3">Reporte para pagos</h3>

<form method="GET" class="form-horizontal" action="{{ route('rrhh.service-request.report.to-pay') }}">

  <div class="input-group mb-3">
    <div class="input-group-prepend">
      <span class="input-group-text">Establecimiento</span>
    </div>
    <select class="form-control selectpicker" data-live-search="true" name="establishment_id" data-size="5">
      <option value="">Todos</option>
      <option value="1" @if($request->establishment_id == 1) selected @endif>Hospital Ernesto Torres Galdames</option>
      <option value="12" @if($request->establishment_id == 12) selected @endif>Dr. Héctor Reyno G.</option>
      <option value="0" @if($request->establishment_id == 0) selected @endif>Dirección SSI</option>
    </select>
    <div class="input-group-append">
        <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i> Buscar</button>
    </div>
  </div>
</form>

<hr>


<h4 class="mb-3 mt-3">Pendientes de pago</h4>
    <a href="{{route('rrhh.service-request.report.bank-payment-file',$request->establishment_id)}}" class="btn btn-sm btn-outline-primary" > <i class="fas fa-file"></i> Archivo de pago banco (En pruebas)</a>
<table class="table table-sm table-bordered">
    <tr>
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
        <th></th>
        @canany(['Service Request: fulfillments finance'])
          <th nowrap style="width: 21%"  >Aprobación de pago </th>
        @endcanany
    </tr>
    @foreach($topay_fulfillments as $key => $fulfillment)
      <tr>
          <td>{{$fulfillment->serviceRequest->id}}</td>
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
              <a href="{{route('rrhh.service-request.fulfillment.download_invoice', $fulfillment)}}"
                 target="_blank" title="Boleta" >
                 <i class="fas fa-paperclip"></i>
              </a>
            @endif
          </td>
          <td>
            @if($fulfillment->serviceRequest->has_resolution_file)
              <a href="{{route('rrhh.service-request.fulfillment.download_resolution', $fulfillment->serviceRequest)}}"
                 target="_blank" title="Resolución">
                 <i class="fas fa-paperclip"></i>
              </a>
            @endif
          </td>
          <td>
              <a href="{{ route('rrhh.service-request.fulfillment.edit',$fulfillment->serviceRequest) }}" title="Editar">
      					<span class="fas fa-edit" aria-hidden="true"></span>
      				</a>
          </td>
          @canany(['Service Request: fulfillments finance'])
            <td>
              @livewire('service-request.payment-ready-toggle', ['fulfillment' => $fulfillment])
            </td>
          @endcanany
      </tr>
    @endforeach
</table>

@endsection

@section('custom_js')


@endsection
