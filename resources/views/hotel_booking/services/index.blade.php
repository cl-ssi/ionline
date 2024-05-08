@extends('layouts.bt4.app')

@section('title', 'Listado de Servicios')

@section('content')

@include('welfare.nav')

<h3 class="inline">Servicios
	<a href="{{ route('hotel_booking.services.create') }}" class="btn btn-primary">Crear</a>
</h3>

<br>
<br>

<table class="table table-striped table-sm table-bordered">
	<thead>
		<tr>
            <th width="5%">Id</th>
			<th nowrap>Nombre</th>
			<th width="5%"></th>
            <th width="5%"></th>
		</tr>
	</thead>
	<tbody>
	@foreach($services as $service)
		<tr>
            <td>{{ $service->id}}</td>
			<td nowrap>{{ $service->name }}</td>
			<td>
				<a href="{{ route('hotel_booking.services.edit', $service) }}"
					class="btn btn-sm btn-outline-secondary">
					<span class="fas fa-edit" aria-hidden="true"></span>
				</a>
			</td>
            <td>
                <form method="POST" class="form-horizontal" action="{{ route('hotel_booking.services.destroy', $service) }}">
                    @csrf
                    @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger btn-sm"
                            onclick="return confirm('¿Está seguro que desea eliminar el servicio?')">
                            <i class="fas fa-trash"></i>
                        </button>
                </form>
                </td>
            </td>
		</tr>
	@endforeach
	</tbody>
</table>

@endsection

@section('custom_js')

@endsection
