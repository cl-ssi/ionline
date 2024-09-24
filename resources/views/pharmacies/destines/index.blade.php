@extends('layouts.bt4.app')

@section('title', 'Lista destinos con farmacia')

@section('content')

@include('pharmacies.nav')

<h3 class="inline">Destinos
	@can('Pharmacy: create establishments')
	<a href="{{ route('pharmacies.destines.create') }}" class="btn btn-primary">Crear</a>
	@endcan
</h3>

<br>
<br>

<table class="table table-striped table-sm table-bordered">
	<thead>
		<tr>
			<th scope="col">Nombre</th>
			<th scope="col">Correo electrónico</th>
			<th scope="col"></th>
		</tr>
	</thead>
	<tbody>
	@foreach($destines as $destiny)
		<tr>
			<td>{{ $destiny->name }}</td>
			<td>{{ $destiny->email }}</td>
			<td>
				<a href="{{ route('pharmacies.destines.edit', $destiny) }}"
					class="btn btn-sm btn-outline-secondary">
					<span class="fas fa-edit" aria-hidden="true"></span>
				</a>
			</td>
		</tr>
	@endforeach
	</tbody>
</table>

{{ $destines->links() }}

@endsection

@section('custom_js')

@endsection
