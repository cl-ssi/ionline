@extends('layouts.app')

@section('title', 'Reporte - Resoluciones pendientes')

@section('content')

@include('service_requests.partials.nav')

<h3 class="mb-3">Reporte - Resoluciones pendientes</h3>

<table class="table table-sm table-bordered">
    <tr>
        <th>Id</th>
        <th nowrap>Rut</th>
        <th>Nombre</th>
        <th scope="col">F. Inicio</th>
        <th scope="col">F. Término</th>
        <th>Tipo</th>
        <th>Jornada</th>
        <th></th>
    </tr>
    @foreach($serviceRequests as $key => $serviceRequest)
      <tr>
          <td>{{$serviceRequest->id}}</td>
          <td>{{$serviceRequest->rut}}</td>
          <td>{{$serviceRequest->name}}</td>
          <td nowrap>{{ $serviceRequest->start_date->format('d-m-Y') }}</td>
    			<td nowrap>{{ $serviceRequest->end_date->format('d-m-Y') }}</td>
          <td>{{$serviceRequest->program_contract_type}}</td>
          <td>{{$serviceRequest->working_day_type}}</td>
          <!-- <td>
            @if($serviceRequest->has_resolution_file)
              <a href="{{route('rrhh.service-request.fulfillment.download-resolution', $serviceRequest)}}"
                 target="_blank" class="mr-4">
                 <i class="fas fa-paperclip"></i>
              </a>
            @endif
          </td> -->
          <td>
              <a href="{{ route('rrhh.service-request.fulfillment.edit',$serviceRequest) }}">
      					<span class="fas fa-edit" aria-hidden="true"></span>
      				</a>
          </td>
      </tr>
    @endforeach
</table>

@endsection

@section('custom_js')


@endsection
