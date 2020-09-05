@extends('layouts.app')

@section('title', 'Lista de Computadores')

@section('content')

<h3 class="mb-3">Computadores</h3>

<form class="form d-print-none" method="GET" action="{{ route('resources.computer.index') }}">
<fieldset class="form-group">
    <div class="input-group">

        <div class="input-group-prepend">
        	<a class="btn btn-primary" href="{{ route('resources.computer.create') }}">
                <i class="fas fa-plus"></i> Agregar nuevo</a>
        </div>

        <input type="text" class="form-control" id="forsearch" onkeyup="filter(3)"
            placeholder="Busqueda por: Marca o Modelo o IP o Serial o Número de Inventario - Filtro por: Serial"
            name="search">

        <div class="input-group-append">
            <button class="btn btn-outline-secondary" type="submit">
                <i class="fas fa-search" aria-hidden="true"></i></button>
        </div>
    </div>
</fieldset>
</form>

<div class="table-responsive">
	<table class="table table-striped table-sm" id="TableFilter">
		<thead>
			<tr>
				<th scope="col"></th>
				<th scope="col">Marca</th>
				<th scope="col">Modelo</th>
				<th scope="col">Serial</th>
				<th scope="col">IP</th>
                <th scope="col">Inventario</th>
				<!-- <th scope="col">Comentario</th> -->
				<th scope="col">Asignado a:</th>
                <th scope="col">Lugar</th>
				<th scope="col">Accion</th>
			</tr>
		</thead>
		<tbody>
			@foreach($computers as $key => $computer)
			<tr>
				<td scope="row">{{ ++$key }} </td>
				<td>{{ $computer->brand }}</td>
				<td>{{ $computer->model }}</td>
				<td>{{ $computer->serial }}</td>
				<td>{{ $computer->ip }}</td>
        <td>{{ $computer->inventory_number }}</td>
				<!-- <td>{{ $computer->comment }}</td> -->
				<td>
          @foreach($computer->users as $user)
					     {{ $user->FullName }}<br>
					@endforeach
				</td>
        <td>{{ $computer->place ? $computer->place->name : '' }}</td>
				<td>
					<a href="{{ route('resources.computer.edit', $computer) }}" class="btn btn-outline-secondary btn-sm">
					<span class="fas fa-edit" aria-hidden="true"></span></a>
				</td>
			</tr>
			@endforeach
		</tbody>
	</table>
</div>

{{ $computers->links() }}

@endsection
