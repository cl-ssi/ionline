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

<h4>Disponibles para visar <b>({{count($serviceRequestsMyPendings)}})</b></h4>

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
	@foreach($serviceRequestsMyPendings as $serviceRequest)
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

<hr>

<h4>No disponibles para visar <b>({{count($serviceRequestsOthersPendings)}})</b></h4>

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
	@foreach($serviceRequestsOthersPendings as $serviceRequest)
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

<hr>

<h4>Visados <b>({{count($serviceRequestsAnswered)}})</b></h4>

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
	@foreach($serviceRequestsAnswered as $serviceRequest)
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
					<a data-toggle="modal" class="btn btn-outline-secondary btn-sm" id="a_modal_flow_incomplete">
					<i class="fas fa-file" style="color:#B9B9B9"></i></a>
				@else
					@if($serviceRequest->SignatureFlows->where('status',0)->count() > 0)
						<a data-toggle="modal" 	class="btn btn-outline-secondary btn-sm" id="a_modal_flow_rejected">
						<i class="fas fa-file" style="color:#B9B9B9"></i></a>
					@else
						<a href="{{ route('rrhh.service_requests.resolution-pdf', $serviceRequest) }}"
							class="btn btn-outline-secondary btn-sm" target="_blank">
						<span class="fas fa-file" aria-hidden="true"></span></a>
					@endif
				@endif
			</td>
		</tr>
	@endforeach
	</tbody>
</table>
</div>

<hr>

<h4><red>Rechazados <b>({{count($serviceRequestsRejected)}})</b></red></h4>

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
	@foreach($serviceRequestsRejected as $serviceRequest)
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
					<a data-toggle="modal" class="btn btn-outline-secondary btn-sm" id="a_modal_flow_incomplete">
					<i class="fas fa-file" style="color:#B9B9B9"></i></a>
				@else
					@if($serviceRequest->SignatureFlows->where('status',0)->count() > 0)
						<a data-toggle="modal" 	class="btn btn-outline-secondary btn-sm" id="a_modal_flow_rejected">
						<i class="fas fa-file" style="color:#B9B9B9"></i></a>
					@else
						<a href="{{ route('rrhh.service_requests.resolution-pdf', $serviceRequest) }}"
							class="btn btn-outline-secondary btn-sm" target="_blank">
						<span class="fas fa-file" aria-hidden="true"></span></a>
					@endif
				@endif
			</td>
		</tr>
	@endforeach
	</tbody>
</table>
</div>

<!-- @if(count($serviceRequestsCreated) > 0)
<hr>

<h4>Solicitudes creadas</h4>

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
			<th scope="col"></th>
		</tr>
	</thead>
	<tbody>
	@foreach($serviceRequestsCreated as $serviceRequest)
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
			<td nowrap>
				<a href="{{ route('rrhh.service_requests.edit', $serviceRequest) }}"
					class="btn btn-sm btn-outline-secondary">
					<span class="fas fa-edit" aria-hidden="true"></span>
				</a>
				@if($serviceRequest->SignatureFlows->whereNull('status')->count() > 1)
					<a data-toggle="modal" class="btn btn-outline-secondary btn-sm" id="a_modal_flow_incomplete">
					<i class="fas fa-file" style="color:#B9B9B9"></i></a>
				@else
					@if($serviceRequest->SignatureFlows->where('status',0)->count() > 0)
						<a data-toggle="modal" 	class="btn btn-outline-secondary btn-sm" id="a_modal_flow_rejected">
						<i class="fas fa-file" style="color:#B9B9B9"></i></a>
					@else
						<a href="{{ route('rrhh.service_requests.resolution-pdf', $serviceRequest) }}"
							class="btn btn-outline-secondary btn-sm" target="_blank">
						<span class="fas fa-file" aria-hidden="true"></span></a>
					@endif
				@endif
			</td>
		</tr>
	@endforeach
	</tbody>
</table>
</div>

@endif -->

<!-- modal -->
<div class="modal" tabindex="-1" role="dialog" id="modal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Información</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p><label id="modal_label"></label></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

@endsection

@section('custom_js')

<script>

$('#a_modal_flow_incomplete').click(function(){
		$('#modal_label').text("No es posible generar la resolución por que el flujo de firmas no está completo.");
    $('#modal').modal("show");
});

$('#a_modal_flow_rejected').click(function(){
		$('#modal_label').text("No es posible generar la resolución por que el flujo de firmas fue rechazado.");
    $('#modal').modal("show");
});

</script>

@endsection
