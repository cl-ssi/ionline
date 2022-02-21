@extends('layouts.app')

@section('title', 'Reporte - Contratos Duplicados')

@section('content')

@include('service_requests.partials.nav')

<h3 class="mb-3">Reporte - Contratos Duplicados  <small>(Funcionarios con más de 1 contrato)</small></h3>


<table class="table table-sm table-bordered table-stripped" id="table_duplicated">
  <tr>
    <th>ID</th>
    <th>Rut</th>
    <th>Nombre</th>
    <th>Unidad</th>
    <th>Fecha Inicio</th>
    <th>Fecha de Término</th>
  </tr>
  @foreach($serviceRequests as $key => $serviceRequest)
  <tr>

    <td>
      <a href="{{ route('rrhh.service-request.edit', $serviceRequest) }}">
        {{$serviceRequest->id?? ''}}
      <a>
    </td>
    <td>{{$serviceRequest->employee->runNotFormat()}}</td>
    <td>{{$serviceRequest->employee->getFullNameAttribute()}}</td>
    <td>{{$serviceRequest->responsabilityCenter->name??''}}</td>
    <td nowrap>{{$serviceRequest->start_date->format('d-m-Y')}}</td>
    <td nowrap>{{$serviceRequest->end_date->format('d-m-Y')}}</td>
  </tr>
  @endforeach
</table>



@endsection

@section('custom_js')


@endsection