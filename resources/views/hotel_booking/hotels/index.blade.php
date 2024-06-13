@extends('layouts.bt4.app')

@section('title', 'Lista de Recintos')

@section('content')

@include('welfare.nav')

<h3 class="inline">Recintos
	<a href="{{ route('hotel_booking.hotels.create') }}" class="btn btn-primary">Crear</a>
</h3>

<br>
<br>

<table class="table table-striped table-sm table-bordered">
	<thead>
		<tr>
            <th>Id</th>
			<th nowrap>Nombre</th>
            <th>Comuna</th>
			<th>Descripción</th>
			<th></th>
            <th></th>
		</tr>
	</thead>
	<tbody>
	@foreach($hotels as $hotel)
		<tr>
            <td>{{ $hotel->id}}</td>
			<td nowrap>{{ $hotel->name }}</td>
            <td>@if($hotel->commune){{ $hotel->commune->name }}@endif</td>
			<td>{{ $hotel->description }}</td>
			<td>
				<a href="{{ route('hotel_booking.hotels.edit', $hotel) }}"
					class="btn btn-sm btn-outline-secondary">
					<span class="fas fa-edit" aria-hidden="true"></span>
				</a>
			</td>
            <td>
                <form method="POST" class="form-horizontal" action="{{ route('hotel_booking.hotels.destroy', $hotel) }}">
                    @csrf
                    @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger btn-sm"
                            onclick="return confirm('¿Está seguro que desea eliminar el recinto?')">
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
