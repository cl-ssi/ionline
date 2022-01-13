@extends('layouts.app')

@section('title', 'Reporte - Contratos Solapados')

@section('content')

@include('service_requests.partials.nav')

<h3 class="mb-3">Reporte - Contratos Solapados </h3>


<table class="table table-sm table-bordered table-stripped" id="table_overlapping">
  <tr>
    <th>Contrato</th>    
    <th>Fecha Inicio</th>
    <th>Fecha de Término</th>
    <th>Contrato</th>
    <th>Fecha Inicio</th>
    <th>Fecha de Término</th>
  </tr>
  @foreach($serviceRequests as $key => $serviceRequest)
  <tr>
    <td>
      <a href="{{ route('rrhh.service-request.edit', $serviceRequest) }}" target="blank">
        {{$serviceRequest->id?? ''}}
      <a>
    </td>
    <td nowrap>{{$serviceRequest->start_date->format('d-m-Y')}}</td>
    <td nowrap>{{$serviceRequest->end_date->format('d-m-Y')}}</td>

    

  </tr>
  @endforeach

</table>
{{ $serviceRequests->links() }}



@endsection

@section('custom_js')


@endsection