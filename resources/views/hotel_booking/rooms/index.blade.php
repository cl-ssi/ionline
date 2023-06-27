@extends('layouts.app')

@section('title', 'Lista de de Establecimientos con Farmacia')

@section('content')

@include('hotel_booking.partials.nav')

<h3 class="inline">Habitaciones
	<a href="{{ route('hotel_booking.rooms.create') }}" class="btn btn-primary">Crear</a>
</h3>

<br>
<br>

<table class="table table-striped table-sm table-bordered">
	<thead>
		<tr>
            <th>Id</th>
            <th scope="col">Hotel</th>
            <th scope="col">Tipo</th>
			<th scope="col">Identificador</th>
			<th scope="col">Descripción</th>
			<th scope="col"></th>
            <th scope="col"></th>
		</tr>
	</thead>
	<tbody>
	@foreach($rooms as $room)
		<tr>
            <td>{{ $room->id}}</td>
            <td>{{ $room->hotel->name }}</td>
            <td>{{ $room->type->name }}</td>
			<td>{{ $room->identifier }}</td>
            <td>{{ $room->description }}</td>
			<td>
				<a href="{{ route('hotel_booking.rooms.edit', $room) }}"
					class="btn btn-sm btn-outline-secondary">
					<span class="fas fa-edit" aria-hidden="true"></span>
				</a>
			</td>
            <td>
                <form method="POST" class="form-horizontal" action="{{ route('hotel_booking.rooms.destroy', $room) }}">
                    @csrf
                    @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger btn-sm"
                            onclick="return confirm('¿Está seguro que desea eliminar la habitación?')">
                            <i class="fas fa-trash"></i>
                        </button>
                </form>
                </td>
            </td>
		</tr>
	@endforeach
	</tbody>
</table>

{{-- $hotels->links() --}}

@endsection

@section('custom_js')

@endsection
