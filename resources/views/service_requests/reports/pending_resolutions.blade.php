@extends('layouts.app')

@section('title', 'Reporte - Resoluciones pendientes')

@section('content')

@include('service_requests.partials.nav')

<h3 class="mb-3">Reporte - Resoluciones pendientes</h3>

<table class="table table-sm table-bordered">
    <tr>
        <th>Id</th>
        <th>Tipo</th>
        <th>Jornada</th>
        <th nowrap>Rut</th>
        <th>Nombre</th>
        <th>Resolución</th>
        <th></th>
    </tr>
    @foreach($serviceRequests as $key => $serviceRequest)
      <tr>
          <td>{{$serviceRequest->id}}</td>
          <td>{{$serviceRequest->program_contract_type}}</td>
          <td>{{$serviceRequest->working_day_type}}</td>
          <td>{{$serviceRequest->rut}}</td>
          <td>{{$serviceRequest->name}}</td>
          <td>

          </td>
          <td>
              <a href="{{ route('rrhh.fulfillments.edit_fulfillment',$serviceRequest) }}">
      					<span class="fas fa-edit" aria-hidden="true"></span>
      				</a>
          </td>
      </tr>
    @endforeach
</table>

@endsection

@section('custom_js')


@endsection
