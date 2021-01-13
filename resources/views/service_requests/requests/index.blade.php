@extends('layouts.app')

@section('title', 'Solicitudes de Contratación')

@section('content')

<h3>Listado de Solicitudes de Contratación de Servicio</h3>

<div class="mb-3">
	<a class="btn btn-primary"
		href="{{ route('rrhh.service_requests.create') }}">
		<i class="far fa-file"></i> Nueva Solicitud
	</a>

	<a type="button"
	   class="btn btn-success"
		 href="{{ route('rrhh.service_requests.consolidated_data') }}">
		 Consolidado
		 <i class="far fa-file-excel"></i>
	 </a>
</div>

<!-- <br> -->

<h4>Pendientes</h4>

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
			<th scope="col">Creador</th>
			<th scope="col"></th>
		</tr>
	</thead>
	<tbody>
	@foreach($serviceRequestsPendings as $serviceRequest)
		<tr>
			<td>{{ $serviceRequest->id }}</td>
			<td>{{ $serviceRequest->type }}</td>
			<td>{{ \Carbon\Carbon::parse($serviceRequest->request_date)->format('d-m-Y') }}</td>
			<td>{{ $serviceRequest->rut }}</td>
			<td>{{ $serviceRequest->name }}</td>
			<td>{{ \Carbon\Carbon::parse($serviceRequest->start_date)->format('d-m-Y') }}</td>
			<td>{{ \Carbon\Carbon::parse($serviceRequest->end_date)->format('d-m-Y') }}</td>
			<td>@if($serviceRequest->SignatureFlows->whereNull('status')->count() > 0) Pendiente
					@else Finalizada @endif</td>
			<!-- $serviceRequest->SignatureFlows->last()->user->getFullNameAttribute()}} -  -->
			<!-- <td>{{$serviceRequest->SignatureFlows->last()->employee}}</td> -->
			<td>{{$serviceRequest->user->getFullNameAttribute()}}</td>
			<td>
				<a href="{{ route('rrhh.service_requests.edit', $serviceRequest) }}"
					class="btn btn-sm btn-outline-secondary">
					<span class="fas fa-edit" aria-hidden="true"></span>
				</a>
			</td>
		</tr>
	@endforeach
	</tbody>
</table>

<h4>Solicitudes respondidas</h4>

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
			<th scope="col">Creador</th>
			<th scope="col"></th>
		</tr>
	</thead>
	<tbody>
	@foreach($myServiceRequests as $serviceRequest)
		<tr>
			<td>{{ $serviceRequest->id }}</td>
			<td>{{ $serviceRequest->type }}</td>
			<td>{{ \Carbon\Carbon::parse($serviceRequest->request_date)->format('d-m-Y') }}</td>
			<td>{{ $serviceRequest->rut }}</td>
			<td>{{ $serviceRequest->name }}</td>
			<td>{{ \Carbon\Carbon::parse($serviceRequest->start_date)->format('d-m-Y') }}</td>
			<td>{{ \Carbon\Carbon::parse($serviceRequest->end_date)->format('d-m-Y') }}</td>
			<td>@if($serviceRequest->SignatureFlows->whereNull('status')->count() > 0) Pendiente
					@else Finalizada @endif</td>
			<!-- $serviceRequest->SignatureFlows->last()->user->getFullNameAttribute()}} -  -->
			<td>{{$serviceRequest->user->getFullNameAttribute()}}</td>
			<td>
				<a href="{{ route('rrhh.service_requests.edit', $serviceRequest) }}"
					class="btn btn-sm btn-outline-secondary">
					<span class="fas fa-edit" aria-hidden="true"></span>
				</a>
			</td>
		</tr>
	@endforeach
	</tbody>
</table>


@endsection

@section('custom_js')

@endsection
