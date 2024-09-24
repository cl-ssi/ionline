@extends('layouts.bt4.app')

@section('title', 'Proveedores')

@section('content')

@include('pharmacies.nav')

<h3 class="inline">Proveedores
	@can('Pharmacy: create suppliers')
	<a href="{{ route('pharmacies.suppliers.create') }}" class="btn btn-primary">Crear</a>
	@endcan
</h3>

<br>
<br>

<table class="table table-striped table-sm table-bordered">
	<thead>
		<tr>
			<th scope="col">Nombre</th>
			<th scope="col">Rut</th>
			<th scope="col">Address</th>
			<th scope="col">Comuna</th>
			<th scope="col">Teléfono</th>
			<th scope="col">Fax</th>
			<th scope="col">Contacto</th>
			<th scope="col"></th>
		</tr>
	</thead>
	<tbody>
	@foreach($suppliers as $supplier)
		<tr class="small">
			<td>{{ $supplier->name }}</td>
			<td nowrap>{{ $supplier->rut }}</td>
			<td>{{ $supplier->address }}</td>
			<td>{{ $supplier->commune }}</td>
			<td>{{ $supplier->telephone }}</td>
			<td>{{ $supplier->fax }}</td>
			<td>{{ $supplier->contact }}</td>
			<td>
				<a href="{{ route('pharmacies.suppliers.edit', $supplier )}}"
				class="btn btn-sm btn-outline-secondary">
				<span class="fas fa-edit" aria-hidden="true"></span></a>
			</td>
		</tr>
		@endforeach
	</tbody>

</table>
{{ $suppliers->links() }}

@endsection

@section('custom_js')

@endsection
