@extends('layouts.app')

@section('title', 'Firmas y distribución')

@section('content')

<h3 class="mb-3">Solicitudes de firmas y distribución</h3>

<form class="form d-print-none" method="GET" action="">
<fieldset class="form-group">
    <div class="input-group">

        <div class="input-group-prepend">
        	<a class="btn btn-primary" href="{{ route('documents.signatures.create') }}">
                <i class="fas fa-plus"></i> Nueva solicitud</a>
        </div>

        <input type="text" class="form-control" id="forsearch" onkeyup="filter(3)"
            placeholder="Buscar por materia o descripción"
            name="search" readonly>

        <div class="input-group-append">
            <button class="btn btn-outline-secondary" type="submit">
                <i class="fas fa-search" aria-hidden="true"></i></button>
        </div>
    </div>
</fieldset>
</form>

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
			<th scope="col">Edit</th>
            <th scope="col">Firmar</th>
            <th scope="col">Doc</th>
		</tr>
	</thead>
	<tbody>
	@foreach($signatures as $signature)
		<tr>
			<td>{{ $signature->id }}</td>
			<td>{{ $signature->request_date->format('Y-m-d') }}</td>
			<td>{{ $signature->organizationalUnit->name }}</td>
			<td>{{ $signature->responsable->getFullNameAttribute() }}</td>
			<td>
				@if($signature->signaturesFiles->first()->signaturesFlows->whereNotNull('user_id')->first()->status === 1) Aceptada
				@elseif($signature->signaturesFiles->first()->signaturesFlows->whereNotNull('user_id')->first()->status === 0) Rechazada
				@else Pendiente @endif
			</td>
			<td>{{ $signature->signaturesFiles->first()->signaturesFlows->whereNotNull('user_id')->last()->employee }}</td>
			<td>{{ $signature->signature_matter }}</td>
			<td>
				<a href="{{ route('documents.signatures.edit', $signature) }}"
					class="btn btn-sm btn-outline-secondary">
					<span class="fas fa-edit" aria-hidden="true"></span>
				</a>
			</td>
            <td>
                <a href="{{ route('signPdf', $signature->signaturesFiles->where('file_type', 'documento')->first()->id) }}"
                   class="btn btn-sm btn-outline-primary">
                    <span class="fas fa-edit" aria-hidden="true"></span>
                </a>
            </td>

            <td>
                <a href="{{ route('documents.showPdf', $signature) }}"
                   class="btn btn-sm btn-outline-secondary">
                    <span class="fas fa-file" aria-hidden="true"></span>
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
	@foreach($signatures as $signature)
		<tr>
			<td>{{ $signature->id }}</td>
			<td>{{ Carbon\Carbon::parse($signature->request_date)->format('Y-m-d') }}</td>
			<td>{{ $signature->organizationalUnit->name }}</td>
			<td>{{ $signature->responsable->getFullNameAttribute() }}</td>
			<td>@if($signature->signaturesFiles->first()->signaturesFlows->whereNotNull('user_id')->first()->status == 1) Aceptada @else Rechazada @endif</td>
			<td>{{$signature->signaturesFiles->first()->signaturesFlows->whereNotNull('user_id')->first()->employee}}</td>
			<td>{{ $signature->signature_matter }}</td>
			<td>
				<a href="{{ route('documents.signatures.edit', $signature) }}"
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
