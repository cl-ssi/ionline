@extends('layouts.app')

@section('title', 'Reporte para pagos')

@section('content')

@include('service_requests.partials.nav')

<h3 class="mb-3">Reporte para pagos</h3>

<form class="form-inline mb-3" action="">

    <div class="row">

        <div class="form-group mx-sm-3 mb-2">
            <label for="forWeek" class="sr-only">Password</label>
            <input type="week" value="{{ $current_week }}" class="form-control" id="forWeek" name="week">
        </div>

        <button type="submit" class="btn btn-primary mb-2">Seleccionar</button>

    </div>
</form>

<!-- <div class="alert alert-warning" role="alert">
    <pre>foreach de fulfillment en rango de fechas y que tenga boleta y resolucion cargada y no tenga información de pagos</pre>
</div> -->

<h3 class="mb-3 mt-3">Pendientes de pago</h3>
{{--@can('be god')--}}
    <a href="{{route('rrhh.service_requests.report.bankPaymentFile', $current_week)}}" class="btn btn-sm btn-outline-primary" > <i class="fas fa-file"></i> Archivo de pago banco (En pruebas)</a>
{{--@endcan--}}
<table class="table table-sm table-bordered">
    <tr>
        <th>Id</th>
        <th>Tipo</th>
        <th>Jornada</th>
        <th>Nombre</th>
        <th nowrap>Rut</th>
        <th>Periodo</th>
        <th>Certif.</th>
        <th>Boleta</th>
        <th>Resolución</th>
        <th></th>
    </tr>
    @foreach($fulfillments->whereNull('total_paid') as $key => $fulfillment)
      <tr>
          <td>{{$fulfillment->serviceRequest->id}}</td>
          <td>{{$fulfillment->serviceRequest->program_contract_type}}</td>
          <td>{{$fulfillment->serviceRequest->working_day_type}}</td>
          <td>{{$fulfillment->serviceRequest->name}}</td>
          <td>{{$fulfillment->serviceRequest->rut}}</td>
          <td>{{$fulfillment->year}} - {{$fulfillment->month}}</td>
          <td>
              <a href="{{ route('rrhh.fulfillments.certificate-pdf',$fulfillment) }}" target="_blank">
                 <i class="fas fa-paperclip"></i>
              </a>
          </td>
          <td>
            @if($fulfillment->has_invoice_file)
              <a href="{{route('rrhh.fulfillments.download.invoice', $fulfillment)}}"
                 target="_blank" class="mr-4">
                 <i class="fas fa-paperclip"></i>
              </a>
            @endif
          </td>
          <td>
            @if($fulfillment->has_resolution_file)
              <a href="{{route('rrhh.fulfillments.download.resolution', $fulfillment)}}"
                 target="_blank" class="mr-4">
                 <i class="fas fa-paperclip"></i>
              </a>
            @endif
          </td>
          <td>
              <a href="{{ route('rrhh.fulfillments.edit_fulfillment',$fulfillment->serviceRequest) }}">
      					<span class="fas fa-edit" aria-hidden="true"></span>
      				</a>
          </td>
      </tr>
    @endforeach
</table>

<hr>

<h3 class="mb-3 mt-3">Pagados</h3>
<table class="table table-sm table-bordered">
    <tr>
        <th>Id</th>
        <th>Tipo</th>
        <th>Jornada</th>
        <th>Nombre</th>
        <th>Rut</th>
        <th>Periodo</th>
        <th>Certif.</th>
        <th>Boleta</th>
        <th>Resolución</th>
        <th>Fecha de pago</th>
        <th></th>
    </tr>
    @foreach($fulfillments->whereNotNull('total_paid') as $key => $fulfillment)
      <tr>
          <td>{{$fulfillment->serviceRequest->id}}</td>
          <td>{{$fulfillment->serviceRequest->program_contract_type}}</td>
          <td>{{$fulfillment->serviceRequest->working_day_type}}</td>
          <td>{{$fulfillment->serviceRequest->name}}</td>
          <td nowrap>{{$fulfillment->serviceRequest->rut}}</td>
          <td>{{$fulfillment->year}} - {{$fulfillment->month}}</td>
          <td>
              <a href="{{ route('rrhh.fulfillments.certificate-pdf',$fulfillment) }}" target="_blank">
                 <i class="fas fa-paperclip"></i>
              </a>
          </td>
          <td>
            @if($fulfillment->has_invoice_file)
              <a href="{{route('rrhh.fulfillments.download.invoice', $fulfillment)}}"
                 target="_blank" class="mr-4">
                 <i class="fas fa-paperclip"></i>
              </a>
            @endif
          </td>
          <td>
            @if($fulfillment->has_resolution_file)
              <a href="{{route('rrhh.fulfillments.download.resolution', $fulfillment)}}"
                 target="_blank" class="mr-4">
                 <i class="fas fa-paperclip"></i>
              </a>
            @endif
          </td>
          <td>
            {{$fulfillment->payment_date->format('Y-m-d')}}
          </td>
          <td>
              <a href="{{ route('rrhh.fulfillments.edit_fulfillment',$fulfillment->serviceRequest) }}">
      					<span class="fas fa-edit" aria-hidden="true"></span>
      				</a>
          </td>
      </tr>
    @endforeach
</table>
@endsection

@section('custom_js')


@endsection
