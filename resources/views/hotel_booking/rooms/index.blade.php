@extends('layouts.bt4.app')

@section('title', 'Listado de Hospedajes')

@section('content')

@include('welfare.nav')

<h3 class="inline">Hospedajes
	<a href="{{ route('hotel_booking.rooms.create') }}" class="btn btn-primary">Crear</a>
</h3>

<br>
<br>

<table class="table table-striped table-sm table-bordered">
	<thead>
		<tr>
            <th>Id</th>
            <th scope="col">Recinto</th>
            <th scope="col">Tipo</th>
			<th scope="col">Identificador</th>
            <th scope="col">Max.Días</th>
			<th scope="col">Descripción</th>
            <th scope="col">Precio</th>
			<th scope="col">Estado</th>
            <th scope="col"></th>
		</tr>
	</thead>
	<tbody>
	@foreach($rooms as $room)
		<tr>
            <td>{{ $room->id}}</td>
            <td nowrap>{{ $room->hotel->name }}</td>
            <td nowrap>{{ $room->type->name }}</td>
			<td nowrap>{{ $room->identifier }}</td>
            <td nowrap>{{ $room->max_days_avaliable }}</td>
            <td>{{ $room->description }}</td>
            <td>${{money( $room->price )}}</td>
            <td nowrap>@if($room->status) Activo @else Desactivado @endif</td>
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
                            onclick="return confirm('¿Está seguro que desea eliminar el hospedaje?')">
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
