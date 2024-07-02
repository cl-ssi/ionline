@extends('layouts.bt4.app')

@section('title', 'Solicitudes de Contratación')

@section('content')

@include('service_requests.partials.nav')

<h3 class="mb-3">Listado de Solicitudes de Contratación de Servicio</h3>

<div class="mb-3">
	<a class="btn btn-primary" href="{{ route('rrhh.service-request.create') }}">
		<i class="far fa-file"></i> Nueva Solicitud
	</a>

	@can('Service Request: derive requests')
	<a class="btn btn-warning" href="#modal_derive" data-toggle="modal">
		<i class="fas fa-sign-in-alt"></i> Derivar mis solicitudes
	</a>
	@endcan

</div>

<ul class="nav nav-tabs mb-3 d-print-none">

    <li class="nav-item">
        <a class="nav-link {{ active('rrhh.service-request.index','pending') }}"
            href="{{ route('rrhh.service-request.index','pending') }}">
            Disponibles para visar <b>({{$pendingCount}})</b>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link {{ active('rrhh.service-request.index','notAvaliable') }}"
            href="{{ route('rrhh.service-request.index','notAvaliable') }}">
            No disponibles para visar <b>({{$notAvailableCount}})</b>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link {{ active('rrhh.service-request.index','signed') }}"
            href="{{ route('rrhh.service-request.index','signed') }}">
            Visados <b>({{$signedCount}})</b>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link {{ active('rrhh.service-request.index','rejected') }}"
            href="{{ route('rrhh.service-request.index','rejected') }}">
            Rechazados <b>({{$rejecedCount}})</b>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link {{ active('rrhh.service-request.index','created') }}"
            href="{{ route('rrhh.service-request.index','created') }}">
            Creadas <b>({{$createdCount}})</b>
        </a>
    </li>

    @can('Service Request: view-all ou requests')
        <li class="nav-item">
            <a class="nav-link {{ active('rrhh.service-request.index','unitTotal') }}"
                href="{{ route('rrhh.service-request.index','unitTotal') }}">
                Total de la unidad <b>({{$unitTotal}})</b>
            </a>
        </li>
    @endcan

</ul>

@if($type == "pending")
    <h3>Disponibles para visar</h3>
@elseif($type == "notAvaliable")
    <h3>No disponibles para visar</h3>
@elseif($type == "signed")
    <h3>Visados</h3>
@elseif($type == "rejected")
    <h3>Rechazados</h3>
@elseif($type == "created")
    <h3>Creadas</h3>
@elseif($type == "unitTotal")
    <h3>Total de la unidad</h3>
@endif

@can('Service Request: accept all requests')
    @if($type == "pending")
    <a class="btn btn-info" href="{{ route('rrhh.service-request.accept_all_requests') }}">
        <i class="fas fa-angle-right"></i> Aceptar todo
    </a>
    <br><br>
    @endif
@endcan

<div class="table-responsive">
    <table class="table table-striped table-sm table-bordered">
        <thead>
            <tr>
                <th scope="col">Id</th>
                <th scope="col">T.Contrato</th>
                <th scope="col">C.Responsabilidad</th>
                <th scope="col">Origen Financiamiento</th>
                <th scope="col">F.Solicitud</th>
                <th scope="col">Rut</th>
                <th scope="col">Funcionario</th>
                <th scope="col">F.Inicio</th>
                <th scope="col">F.Término</th>
                <th scope="col">Estado Solicitud</th>
                <th scope="col"></th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $serviceRequest)
            <tr>
                <td>{{ $serviceRequest->id }}</td>
                <td>{{ $serviceRequest->program_contract_type ?? '' }}</td>
                <td>{{ $serviceRequest->responsabilityCenter->name ?? '' }}</td>
                <td>{{ $serviceRequest->type ?? '' }}</td>
                <td nowrap>{{ \Carbon\Carbon::parse($serviceRequest->request_date)->format('d-m-Y') }}</td>
                <td nowrap>{{ $serviceRequest->employee->runNotFormat() }}</td>
                <td>{{ $serviceRequest->employee->shortName }}</td>
                <td nowrap>{{ \Carbon\Carbon::parse($serviceRequest->start_date)->format('d-m-Y') }}</td>
                <td nowrap>{{ \Carbon\Carbon::parse($serviceRequest->end_date)->format('d-m-Y') }}</td>
                <td>@if($serviceRequest->SignatureFlows->whereNull('status')->count() > 0) Pendiente
                    @else Finalizada @endif</td>
                <td nowrap>
                    <a href="{{ route('rrhh.service-request.edit', $serviceRequest) }}" class="btn btn-sm btn-outline-secondary">
                        <span class="fas fa-edit" aria-hidden="true"></span>
                    </a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

@if($type == "rejected" || $type == "signed" || $type == "created")
    {{ $data->appends(request()->query())->links() }}
@endif

@if($type == "unitTotal")
    @can('Service Request: view-all ou requests')
        {{ $data->appends(request()->query())->links() }}
    @endcan
@endif

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

<!-- modal reenviar -->
<div class="modal" tabindex="-1" role="dialog" id="modal_derive">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Derivar solicitudes</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">

				<div class="row">
					<form method="POST" enctype="multipart/form-data" id="derive" action="{{ route('rrhh.service-request.derive') }}">
						@csrf

						<fieldset class="form-group col">
							<label for="for_type">Destinatario</label>
                            @livewire('search-select-user', ['required' => 'required', 'selected_id' => 'derive_user_id']) 
						</fieldset>

					</form>

				</div>

				<table class="table">
					<tr>
						<td>Disponibles para visar:</td>
						<td><b>{{$pendingCount}}</b></td>
					</tr>
					<tr>
						<td>No disponibles para visar:</td>
						<td><b>{{$notAvailableCount}}</b></td>
					</tr>
				</table>         

				<br>

				<i>Está a punto de derivar las sgtes solicitudes a otro trabajador.</i>

			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-primary" id="button_derive" >Derivar</button>
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
			</div>
		</div>
	</div>
</div>

@endsection

@section('custom_js')

<script>
	$('#a_modal_flow_incomplete').click(function() {
		$('#modal_label').text("No es posible generar la resolución por que el flujo de firmas no está completo.");
		$('#modal').modal("show");
	});
	$('#a_modal_flow_rejected').click(function() {
		$('#modal_label').text("No es posible generar la resolución por que el flujo de firmas fue rechazado.");
		$('#modal').modal("show");
	});
	$('#button_derive').click(function() {
		var user_id = $('#derive_user_id').val();
		var result = confirm("¿Está seguro de continuar con la derivación?");
		if (result) {
			$('#derive').submit();
		}
	});
</script>

@endsection