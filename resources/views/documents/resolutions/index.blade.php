@extends('layouts.app')

@section('title', 'Resoluciones')

@section('content')

<h3>Listado Solicitudes de Firma</h3>

<div class="mb-3">

	<a class="btn btn-primary"
		href="{{ route('rrhh.resolutions.create') }}">
		<i class="far fa-file"></i> Nueva Solicitud
	</a>

</div>

<h4>Pendientes</h4>

<table class="table table-striped table-sm table-bordered">
	<thead>
		<tr>
			<th scope="col">Id</th>
      <th scope="col">Fecha de Solicitud</th>
      <th scope="col">U.Organizacional</th>
      <th scope="col">Responsable</th>
			<th scope="col">Estado Solicitud</th>
			<th scope="col">Ultimo Usuario</th>
      <th scope="col">Materia de Resolución</th>
      <th scope="col"></th>
		</tr>
	</thead>
	<tbody>
	@foreach($resolutionsPending as $resolution)
		<tr>
			<td>{{ $resolution->id }}</td>
      <td>{{ Carbon\Carbon::parse($resolution->request_date)->format('Y-m-d') }}</td>
      <td>{{ $resolution->organizationalUnit->name }}</td>
      <td>{{ $resolution->responsable->getFullNameAttribute() }}</td>
			<td>@if($resolution->SignatureFlows->whereNotNull('user_id')->last()->status === 1) Aceptada
					@elseif($resolution->SignatureFlows->whereNotNull('user_id')->last()->status === 0) Rechazada
					@else Pendiente @endif</td>
			<td>{{$resolution->SignatureFlows->whereNotNull('user_id')->last()->employee}}</td>
      <td>{{ $resolution->resolution_matter }}</td>
      <td>
				<a href="{{ route('rrhh.resolutions.edit', $resolution) }}"
					class="btn btn-sm btn-outline-secondary">
					<span class="fas fa-edit" aria-hidden="true"></span>
				</a>
			</td>
		</tr>
	@endforeach
	</tbody>
</table>

<h4>Resoluciones respondidas</h4>

<table class="table table-striped table-sm table-bordered">
	<thead>
		<tr>
			<th scope="col">Id</th>
      <th scope="col">Fecha de Solicitud</th>
      <th scope="col">U.Organizacional</th>
      <th scope="col">Responsable</th>
			<th scope="col">Estado Solicitud</th>
			<th scope="col">Ultimo Usuario</th>
      <th scope="col">Materia de Resolución</th>
      <th scope="col"></th>
		</tr>
	</thead>
	<tbody>
	@foreach($myResolutions as $resolution)
		<tr>
			<td>{{ $resolution->id }}</td>
      <td>{{ Carbon\Carbon::parse($resolution->request_date)->format('Y-m-d') }}</td>
      <td>{{ $resolution->organizationalUnit->name }}</td>
      <td>{{ $resolution->responsable->getFullNameAttribute() }}</td>
			<td>@if($resolution->SignatureFlows->whereNotNull('user_id')->last()->status == 1) Aceptada @else Rechazada @endif</td>
			<td>{{$resolution->SignatureFlows->whereNotNull('user_id')->last()->employee}}</td>
      <td>{{ $resolution->resolution_matter }}</td>
      <td>
				<a href="{{ route('rrhh.resolutions.edit', $resolution) }}"
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
