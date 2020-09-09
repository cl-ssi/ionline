@extends('layouts.app')

@section('title', 'Lista de Teléfonos Móviles')

@section('content')

<h3 class="mb-3">Teléfonos Móviles</h3>

<form class="form d-print-none" method="GET" action="{{ route('resources.mobile.index') }}">
<fieldset class="form-group">
    <div class="input-group">

        <div class="input-group-prepend">
            <a class="btn btn-primary" href="{{ route('resources.mobile.create') }}">
                <i class="fas fa-plus"></i> Agregar nuevo</a>
        </div>

        <input type="text" class="form-control" id="forsearch" onkeyup="filter(1)"
            placeholder="Busqueda por: número o marca - Filtro por: número" name="search">

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
				<th scope="col">Número</th>
				<th scope="col">Marca</th>
                <th scope="col">Modelo</th>
				<th scope="col">Asociado a</th>
				<th scope="col">Accion</th>
			</tr>
		</thead>
		<tbody>
			@foreach($mobiles as $key => $mobile)
			<tr>
				<td>{{ $key }} </td>
				<td>{{ $mobile->number }}</td>
				<td>{{ $mobile->brand }}</td>
                <td>{{ $mobile->model }}</td>
				<td>{{ @$mobile->user->FullName ?: '' }}</td>
				<td>
					<a href="{{ route('resources.mobile.edit', $mobile->id) }}" class="btn btn-outline-secondary btn-sm">
					<span class="fas fa-edit" aria-hidden="true"></span></a>
				</td>
			</tr>
			@endforeach
		</tbody>
	</table>
</div>

{{ $mobiles->links() }}

@endsection
