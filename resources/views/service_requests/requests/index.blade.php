@extends('layouts.app')

@section('title', 'Solicitudes de Contratación')

@section('content')

<h3>Listado de Solicitudes de Contratación de Servicio</h3>

<div class="mb-3">
	<a class="btn btn-primary"
		href="{{ route('rrhh.service_requests.create') }}">
		<i class="far fa-file"></i> Nueva Solicitud
	</a>

	@can('Service Request: consolidated data')
		<a type="button"
			 class="btn btn-success"
			 href="{{ route('rrhh.service_requests.consolidated_data') }}">
			 Consolidado
			 <i class="far fa-file-excel"></i>
		 </a>
	@endcan

</div>

<!-- <br> -->

<h4>Pendientes</h4>

<div class="table-responsive">
<table class="table table-striped table-sm table-bordered">
	<thead>
		<tr>
			<th scope="col">Id</th>
			<th scope="col">Tipo</th>
			<th scope="col">F. Solicitud</th>
			<th scope="col">Rut</th>
			<th scope="col">Funcionario</th>
			<th scope="col">F. Inicio</th>
			<th scope="col">F. Término</th>
			<th scope="col">Estado Solicitud</th>
			<!-- <th scope="col">Creador</th> -->
			<th scope="col"></th>
		</tr>
	</thead>
	<tbody>
	@foreach($serviceRequestsPendings as $serviceRequest)
		<tr>
			<td>{{ $serviceRequest->id }}</td>
			<td>{{ $serviceRequest->type }}</td>
			<td nowrap>{{ \Carbon\Carbon::parse($serviceRequest->request_date)->format('d-m-Y') }}</td>
			<td nowrap>{{ $serviceRequest->rut }}</td>
			<td nowrap>{{ $serviceRequest->name }}</td>
			<td nowrap>{{ \Carbon\Carbon::parse($serviceRequest->start_date)->format('d-m-Y') }}</td>
			<td nowrap>{{ \Carbon\Carbon::parse($serviceRequest->end_date)->format('d-m-Y') }}</td>
			<td>@if($serviceRequest->SignatureFlows->whereNull('status')->count() > 0) Pendiente
					@else Finalizada @endif</td>
			<!-- $serviceRequest->SignatureFlows->last()->user->getFullNameAttribute()}} -  -->
			<!-- <td>{{$serviceRequest->SignatureFlows->last()->employee}}</td> -->
			<!-- <td>{{$serviceRequest->user->getFullNameAttribute()}}</td> -->
			<td nowrap>
				<a href="{{ route('rrhh.service_requests.edit', $serviceRequest) }}"
					class="btn btn-sm btn-outline-secondary">
					<span class="fas fa-edit" aria-hidden="true"></span>
				</a>
			</td>
		</tr>
	@endforeach
	</tbody>
</table>
</div>

<h4>Solicitudes respondidas</h4>

<div class="table-responsive">
<table class="table table-striped table-sm table-bordered">
	<thead>
		<tr>
			<th scope="col">Id</th>
			<th scope="col">Tipo</th>
			<th scope="col">F. Solicitud</th>
			<th scope="col">Rut</th>
			<th scope="col">Funcionario</th>
			<th scope="col">F. Inicio</th>
			<th scope="col">F. Término</th>
			<th scope="col">Estado Solicitud</th>
			<!-- <th scope="col">Creador</th> -->
			<th scope="col"></th>
		</tr>
	</thead>
	<tbody>
	@foreach($myServiceRequests as $serviceRequest)
		<tr>
			<td>{{ $serviceRequest->id }}</td>
			<td>{{ $serviceRequest->type }}</td>
			<td nowrap>{{ \Carbon\Carbon::parse($serviceRequest->request_date)->format('d-m-Y') }}</td>
			<td nowrap>{{ $serviceRequest->rut }}</td>
			<td nowrap>{{ $serviceRequest->name }}</td>
			<td nowrap>{{ \Carbon\Carbon::parse($serviceRequest->start_date)->format('d-m-Y') }}</td>
			<td nowrap>{{ \Carbon\Carbon::parse($serviceRequest->end_date)->format('d-m-Y') }}</td>
			<td>@if($serviceRequest->SignatureFlows->whereNull('status')->count() > 0) Pendiente
					@else Finalizada @endif</td>
			<!-- $serviceRequest->SignatureFlows->last()->user->getFullNameAttribute()}} -  -->
			<!-- <td>{{$serviceRequest->user->getFullNameAttribute()}}</td> -->
			<td nowrap>
				<a href="{{ route('rrhh.service_requests.edit', $serviceRequest) }}"
					class="btn btn-sm btn-outline-secondary">
					<span class="fas fa-edit" aria-hidden="true"></span>
				</a>
				@if($serviceRequest->SignatureFlows->whereNull('status')->count() > 1)
					<a data-toggle="modal" data-target="#GSCCModal"
						class="btn btn-outline-secondary btn-sm" target="_blank">
					<i class="fas fa-file" style="color:#B9B9B9"></i></a>
				@else
					<a href="{{ route('rrhh.service_requests.resolution-pdf', $serviceRequest) }}"
						class="btn btn-outline-secondary btn-sm" target="_blank">
					<span class="fas fa-file" aria-hidden="true"></span></a>
				@endif
			</td>
		</tr>
	@endforeach
	</tbody>
</table>
</div>

<div class="modal" tabindex="-1" role="dialog" id="GSCCModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Información</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>No es posible generar la resolución por que el flujo de firmas no está completo.</p>
      </div>
      <div class="modal-footer">
        <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>


@endsection

@section('custom_js')

@endsection
