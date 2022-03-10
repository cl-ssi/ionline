@extends('layouts.app')

@section('title', 'Asociar usuarios a farmacia')

@section('content')

@include('pharmacies.admin_nav')

<h3>Asociar usuario a farmacia</h3>

<form method="POST" action="{{ route('pharmacies.user_asign_store') }}">
@csrf
	<div class="form-row">
			<fieldset class="form-group col-5">
					<label for="for_user_id">Funcionario*</label>
					@livewire('search-select-user', ['required' => 'required'])
			</fieldset>

			<fieldset class="form-group col-12 col-md-5">
					<label for="for_user_id">Farmacia*</label>
					<select name="pharmacy_id" id="for_pharmacy_id" class="form-control" required>
						@foreach($pharmacies as $pharmacy)
							<option value="{{$pharmacy->id}}">{{$pharmacy->name}}</option>
						@endforeach
					</select>
			</fieldset>

			<fieldset class="form-group col-12 col-md-2">
					<label for="for_user_id"><br></label>
					<button type="submit" class="form-control btn btn-primary">Asignar</button>
			</fieldset>
	</div>
</form>

<h4>Usuarios asociados</h4>

<div class="table-responsive">
	<table class="table table-striped table-sm" id="tabla_purchase">
		<thead>
			<tr>
				<th scope="col">Farmacia</th>
				<th scope="col">Usuario asociado</th>
				<th scope="col">Acción</th>
			</tr>
		</thead>
		<tbody>
			@foreach($pharmacies as $key => $pharmacy)
				@foreach($pharmacy->users as $key => $user)
					<tr>
						<td>{{ $pharmacy->name }}</td>
						<td>{{ $user->getFullNameUpperAttribute() }}</td>
						<td>
							<form method="POST" action="{{ route('pharmacies.user_asign_destroy', [$pharmacy,$user]) }}" class="d-inline">
								@csrf
								@method('DELETE')
								<button type="submit" class="btn btn-outline-secondary btn-sm" onclick="return confirm('¿Está seguro de eliminar la información?');">
									<span class="fas fa-trash-alt" aria-hidden="true"></span>
								</button>
							</form>
						</td>
					</tr>
				@endforeach
			@endforeach
		</tbody>
	</table>
</div>

@endsection

@section('custom_js')

@endsection
