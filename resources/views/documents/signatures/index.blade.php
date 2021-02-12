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


                <button type="button" class="btn btn-sm btn-outline-primary" data-toggle="modal" data-target="#exampleModalCenter">
                    <i class="fas fa-edit"></i>
                </button>

            </td>

            <td>
                <a href="{{ route('documents.showPdf', $signature) }}"
                   class="btn btn-sm btn-outline-secondary">
                    <span class="fas fa-file" aria-hidden="true"></span>
                </a>
            </td>
		</tr>
	@endforeach


    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Nro. OTP</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST" class="form-horizontal" action="{{route('signPdf', $signature->signaturesFiles->where('file_type', 'documento')->first()->id)}}" enctype="multipart/form-data">
                    <div class="modal-body">
                    @csrf <!-- input hidden contra ataques CSRF -->
                        @method('POST')
                        <div class="form-row">
                            <div class="form-group col-12">
                                <label for="forotp">Ingrese número OTP.</label>
                                <input type="text" class="form-control form-control-sm" id="forotp" name="otp" maxlength="6" required/>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>

                        <button class="btn btn-primary" type="submit">
                            <i class="fas fa-edit"></i> Firmar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

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
