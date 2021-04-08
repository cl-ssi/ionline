@extends('layouts.app')

@section('title', 'Reporte para pagos')

@section('content')

@include('service_requests.partials.nav')

<h3 class="mb-3">Pagos rechazados</h3>


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
              {{$fulfillment->serviceRequest->id}}
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
            @livewire('service-request.payment-feedback-toggle', ['fulfillment' => $fulfillment])
            </td>
      </tr>
    @endforeach
</table>


@endsection

@section('custom_js')


@endsection
