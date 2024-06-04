@extends('layouts.bt4.app')

@section('title', 'Topes por unidad organizacional')

@section('content')

@include('service_requests.partials.nav')

<h3 class="inline">Topes por unidad organizacional
	<a href="{{ route('rrhh.service-request.organizational_unit_limits.create') }}" class="btn btn-primary">Crear</a>
</h3>

<table class="table table-striped table-sm table-bordered">
	<thead>
		<tr>
			<th scope="col">Unidad organizacional</th>
			<th scope="col">Tope</th>
            <th></th>
		</tr>
	</thead>
	<tbody>
	@foreach($organizationalUnitLimits as $organizationalUnitLimit)
		<tr>
			<td>{{ $organizationalUnitLimit->organizationalUnit->name }}</td>
            <td>{{ $organizationalUnitLimit->max_value }}</td>
            <td>
                <a href="{{ route('rrhh.service-request.organizational_unit_limits.edit', $organizationalUnitLimit) }}"
                class="btn btn-sm btn-outline-secondary">
                    <span class="fas fa-edit" aria-hidden="true"></span>
                </a>
                <form method="POST" action="{{ route('rrhh.service-request.organizational_unit_limits.destroy', $organizationalUnitLimit) }}" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-outline-danger btn-sm"
                            onclick="return confirm('¿Está seguro que desea eliminar el tope?')">
                        <i class="fas fa-trash"></i>
                    </button>
                </form>
            </td>

		</tr>
	@endforeach
	</tbody>
</table>

@endsection

@section('custom_js')

@endsection
