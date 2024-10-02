@extends('layouts.bt4.app')

@section('title', 'Reporte pagados')

@section('content')

@include('service_requests.partials.nav')

<h4 class="mb-3">Reporte pagados</h4>

<form method="GET" class="form-horizontal" action="{{ route('rrhh.service-request.report.payed') }}">

<div class="form-row">
	<fieldset class="form-group col-md">
        <label for="for_working_day_type">Jornada de Trabajo</label>
        <select name="working_day_type" class="form-control">
                <option value="">Todas</option>
                <option value="DIURNO" @if($request->input('working_day_type')=='DIURNO') selected @endif>DIURNO</option>
                <option value="TERCER TURNO" @if($request->input('working_day_type')=='TERCER TURNO') selected @endif>TERCER TURNO</option>
                <option value="TERCER TURNO - MODIFICADO" @if($request->input('working_day_type')=='TERCER TURNO - MODIFICADO') selected @endif>TERCER TURNO - MODIFICADO</option>
                <option value="CUARTO TURNO" @if($request->input('working_day_type')=='CUARTO TURNO') selected @endif>CUARTO TURNO</option>
                <option value="CUARTO TURNO - MODIFICADO" @if($request->input('working_day_type')=='CUARTO TURNO - MODIFICADO') selected @endif>CUARTO TURNO - MODIFICADO</option>
                <option value="DIURNO PASADO A TURNO" @if($request->input('working_day_type')=='DIURNO PASADO A TURNO') selected @endif>DIURNO PASADO A TURNO</option>
                <option value="HORA MÉDICA" @if($request->input('working_day_type')=='HORA MÉDICA') selected @endif>HORA MÉDICA</option>
                <option value="HORA EXTRA" @if($request->input('working_day_type')=='HORA EXTRA') selected @endif>HORA EXTRA</option>
                <option value="TURNO EXTRA" @if($request->input('working_day_type')=='TURNO EXTRA') selected @endif>TURNO EXTRA</option>
                <option value="TURNO DE REEMPLAZO" @if($request->input('working_day_type')=='TURNO DE REEMPLAZO') selected @endif >TURNO DE REEMPLAZO</option>
                <option value="DIARIO" @if($request->input('working_day_type')=='DIARIO') selected @endif >DIARIO</option>
        </select>
	</fieldset>

	<fieldset class="form-group col-md">
        <label for="for_working_day_type">Desde</label>
        <input type="date" class="form-control" name="from" @if($request->from) value={{$request->from}} @endif>
	</fieldset>

	<fieldset class="form-group col-md">
        <label for="for_working_day_type">Hasta</label>
        <input type="date" class="form-control" name="to" @if($request->to) value={{$request->to}} @endif>
	</fieldset>

    <fieldset class="form-group col-md">
        <label for="for_working_day_type">ID</label>
        <input type="text" class="form-control" name="service_request_id" autocomplete="off" @if($request->service_request_id) value={{$request->service_request_id}} @endif>
	</fieldset>

    <fieldset class="form-group col-md">
        <label for="for_working_day_type"></label>
        <button type="submit" class="btn btn-primary form-control"><i class="fas fa-search"></i> Buscar</button>
	</fieldset>

</div>

<div class="form-row">
    <div class="col-3">
        <a class="btn btn-outline-success" href="{{route('rrhh.service-request.report.bank-payment-file',auth()->user()->organizationalUnit->establishment_id)}}">
            <i class="fas fa-file"></i>Archivo de pago banco
        </a>
    </div>
    <div class="col-3">
        <button type="submit" class="btn btn-outline-success " title="Descargar Excel" name="excel">Descargar <i class="fas fa-file-excel"></i></button>
    </div>
</div>

</form>

<hr>

  <table class="table table-sm table-bordered table-stripped">
    <tr>
        <th></th>
        <th>Id</th>
        <th>Establecimiento</th>
        <th>Unidad</th>
        <th>Tipo de Contrato</th>
        <th>Tipo/Jornada</th>
        <th>Nombre</th>
        <th nowrap>Rut</th>
        <th>Periodo</th>
        <th>Banco - N° Cuenta</th>
        <th>F.Pago</th>
        <th>Monto</th>
        <th>Cer.</th>
        <th>Bol.</th>
        <th>Res.</th>
        <th></th>
    </tr>
    @foreach($payed_fulfillments as $key => $fulfillment)
      <tr>
					<td class="small">{{$key+1}}</td>
          <td class="small">{{$fulfillment->serviceRequest->id}}</td>
          <td class="small">{{$fulfillment->serviceRequest->establishment->name}}</td>
					<td class="small">{{$fulfillment->serviceRequest->responsabilityCenter->name}}</td>
          <td class="small">{{$fulfillment->serviceRequest->type ?? ''}}</td>
          <td class="small">
            {{$fulfillment->serviceRequest->program_contract_type}}
            <br>
            {{$fulfillment->serviceRequest->working_day_type}}
          </td>
          <td class="small">{{$fulfillment->serviceRequest->employee->fullName}}</td>
          <td class="small" nowrap>{{$fulfillment->serviceRequest->employee->runFormat()}}</td>
          <td class="small">
            @if($fulfillment->year)
              {{ $fulfillment->year }}-{{ $fulfillment->month }}
            @else
              {{ $fulfillment->start_date->format('Y-m') }}
            @endif
          </td>
          <td class="small">{{$fulfillment->serviceRequest->employee->bankAccount->bank->name ?? ''}} - {{$fulfillment->serviceRequest->employee->bankAccount->number?? ''}}</td>
          <td class="small" nowrap>{{$fulfillment->payment_date->format('Y-m-d') ?? ''}}</td>
					<td class="small">{{$fulfillment->total_paid ?? ''}}</td>
          <td class="small">
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
          <td class="small">
            @if($fulfillment->has_invoice_file)
              <a href="{{route('rrhh.service-request.fulfillment.download_invoice', [$fulfillment, time()])}}"
                 target="_blank" title="Boleta" >
                 <i class="fas fa-paperclip"></i>
              </a>
            @endif
          </td>
          <td class="small">
            @if($fulfillment->serviceRequest->has_resolution_file)
              <a href="{{route('rrhh.service-request.fulfillment.download_resolution', $fulfillment->serviceRequest)}}"
                 target="_blank" title="Resolución">
                 <i class="fas fa-paperclip"></i>
              </a>
            @endif
          </td>
          <td class="small">
              <a href="{{ route('rrhh.service-request.fulfillment.edit',$fulfillment->serviceRequest) }}" title="Editar">
      					<span class="fas fa-edit" aria-hidden="true"></span>
      				</a>
          </td>
          <!-- @canany(['Service Request: fulfillments finance'])
            <td>
              @livewire('service-request.payment-ready-toggle', ['fulfillment' => $fulfillment])
            </td>
          @endcanany -->
      </tr>
    @endforeach
</table>

{{ $payed_fulfillments->appends(request()->query())->links() }}

@endsection

@section('custom_js')


@endsection
