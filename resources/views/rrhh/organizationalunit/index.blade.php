@extends('layouts.app')

@section('title', 'Lista de Unidades Organizacionales')

@section('content')

<h3 class="mb-3">Unidades organizacionales</h3>

<fieldset class="form-group">
    <div class="input-group">
        <div class="input-group-prepend">
        	<span class="input-group-text" id="basic-addon"><i class="fas fa-search"></i></span>
        </div>
        <input type="text" class="form-control" id="forsearch" onkeyup="filter(1)" placeholder="Ingrese Nombre" name="search" required="">
        <div class="input-group-append">
            <a class="btn btn-primary" href="{{ route('rrhh.organizational-units.create') }}"><i class="fas fa-plus"></i> Agregar nuevo</a>
        </div>
    </div>
</fieldset>

<div class="table-responsive">
	<table class="table table-striped table-sm" id="TableFilter">
		<thead>
			<tr>
				<th scope="col"></th>
				<th scope="col">Nombre</th>
                <th scope="col">Nivel</th>
                <th scope="col">Id Establecimiento</th>
				<th scope="col">Accion</th>
			</tr>
		</thead>
		<tbody>
			@foreach($organizationalUnits as $key => $organizationalUnit)
			<tr>
				<td scope="row">{{ ++$key }} </td>
				<td>{{ $organizationalUnit->name }}</td>
                <td>{{ $organizationalUnit->level }}</td>
                <td>{{ $organizationalUnit->establishment_id }}</td>
				<td>
					<a href="{{ route('rrhh.organizational-units.edit', $organizationalUnit->id) }}" class="btn btn-outline-secondary btn-sm">
					<span class="fas fa-edit" aria-hidden="true"></span></a>
				</td>
			</tr>
			@endforeach
		</tbody>
	</table>
</div>

@endsection
