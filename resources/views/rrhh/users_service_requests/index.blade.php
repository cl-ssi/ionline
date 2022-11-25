@extends('layouts.app')

@section('title', 'Lista de Usuarios')

@section('content')

<h3 class="inline mt-3">Usuarios
	<a href="{{ route('rrhh.users.service_requests.create') }}" class="btn btn-primary">Crear</a>
</h3>

<br>

<form class="form-inline float-right" method="GET" action="{{ route('rrhh.users.index') }}">
	<div class="input-group mb-3">
		<input type="text" name="name" class="form-control" placeholder="Nombre o Apellido" autofocus>
		<div class="input-group-append">
			<button class="btn btn-outline-secondary" type="submit">
				<i class="fas fa-search" aria-hidden="true"></i>
			</button>
		</div>
	</div>
</form>

<br>

<table class="table table-striped table-sm">
	<thead class="thead-dark">
		<tr>
			<th scope="col">RUN</th>
			<th scope="col">Nombre</th>
			<th scope="col">Tipo</th>
			<th scope="col">Unidad Organizacional</th>
			<th scope="col">Cargo/Función</th>
			<th scope="col">Accion</th>
		</tr>
	</thead>
	<tbody>
		@foreach($users as $user)
			@if($user->id != 17430005)
				<tr>
					<th scope="row" nowrap>{{ $user->runFormat() }}</td>
					<td nowrap>{{ $user->name }} {{ $user->fathers_family }} {{ $user->mothers_family }}</td>
					<td class="small">{{ @$user->organizationalunit->establishment->name ?: ''}}</td>
					<td class="small">{{ @$user->organizationalunit->name ?: ''}}</td>
					<td class="small">{{ $user->position }}</td>
					<td nowrap>
						<a href="{{ route('rrhh.users.service_requests.edit',$user->id) }}" class="btn btn-outline-primary">
						<span class="fas fa-edit" aria-hidden="true"></span></a>

						<!-- @role('god')
						<a href="{{ route('rrhh.users.switch', $user->id) }}" class="btn btn-outline-warning">
						<span class="fas fa-redo" aria-hidden="true"></span></a>
						@endrole -->
					</td>
				</tr>
			@endif
		@endforeach
	</tbody>

</table>

{{ $users->links() }}

@endsection
