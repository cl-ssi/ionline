@extends('layouts.app')

@section('title', 'Lista de de Establecimientos con Farmacia')

@section('content')

@include('pharmacies.nav')

<h3 class="inline">Establecimientos
	@can('Pharmacy: create establishments')
	<a href="{{ route('pharmacies.establishments.create') }}" class="btn btn-primary">Crear</a>
	@endcan
</h3>

<br>

<!--form class="form-inline float-right" method="GET" action="{{ route('rrhh.users.index') }}">
	<div class="input-group mb-3">
		<input type="text" name="name" class="form-control" placeholder="Nombre del Establecimiento" autocomplete="off">
		<div class="input-group-append">
			<button class="btn btn-outline-secondary" type="submit">
				<i class="fas fa-search" aria-hidden="true"></i></button>
		</div>
	</div>
</form-->


<br>

<table class="table table-striped table-sm table-bordered">
	<thead>
		<tr>
			<th scope="col">Nombre</th>
			<th scope="col"></th>
		</tr>
	</thead>
	<tbody>
	@foreach($establishments as $establishment)
		<tr>
			<td>{{ $establishment->name }}</td>
			<td>
				<a href="{{ route('pharmacies.establishments.edit', $establishment) }}"
					class="btn btn-sm btn-outline-secondary">
					<span class="fas fa-edit" aria-hidden="true"></span>
				</a>
			</td>
		</tr>
	@endforeach
	</tbody>
</table>

{{ $establishments->links() }}

@endsection

@section('custom_js')

@endsection
