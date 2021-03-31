@extends('layouts.app')
@section('title', 'Gestion de Turnos')
@section('content')

	<h3 class="inline mt-3">Tipos de turno</h3>
	<a href="{{ route('rrhh.users.create') }}" class="btn btn-primary">Crear</a>
	<br>

	<table class="table table-striped table-sm">
		<thead class="thead-dark">
			<tr>
				<th>#</th>
				<th>Nombre</th>
				<th>Abrev.</th>
				<th>Creado en</th>
				<th>Accion</th>
			</tr>
		</thead>
		<tbody>
				@foreach($sTypes as $sType)
					<tr>
						<td>{{$loop->iteration}}</td>
						<td>{{$sType->name}}</td>
						<td>{{$sType->shortname}}</td>
						<td>{{$sType->created_at}}</td>
						<td><a href="{{route('rrhh.shiftsTypes.edit', $sType->id)}}" class="btn btn-outline-primary" ><i class="fa fa-edit">	</i></a></td>
					</tr>
				@endforeach
				
		</tbody>
	</table>
@endsection
