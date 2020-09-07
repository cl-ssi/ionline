@extends('layouts.app')

@section('title', 'Lista de Telefonos')

@section('content')

<h3 class="mb-3">Telefonos Fijos</h3>

<form class="form d-print-none" method="GET" action="{{ route('resources.telephone.index') }}">
<fieldset class="form-group">
    <div class="input-group">

        <div class="input-group-prepend">
            <a class="btn btn-primary" href="{{ route('resources.telephone.create') }}">
                <i class="fas fa-plus"></i> Agregar nuevo
            </a>
        </div>

        <input type="text" class="form-control" id="forsearch" onkeyup="filter(2)"
            placeholder="Busqueda por: Número o Anexo - Filtro por: Anexo" name="search">

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
				<th scope="col">Minsal</th>
                <th scope="col">Mac</th>
				<th scope="col">Asociado a</th>
                <th scope="col">Ubicación</th>
                <th scope="col">Lugar</th>
				<th scope="col">Accion</th>
			</tr>
		</thead>
		<tbody>
			@foreach($telephones as $key => $telephone)
			<tr>
				<td>{{ $telephones->firstItem() + $key }} </td>
				<td>{{ $telephone->number }} </td>
				<td>{{ $telephone->minsal }}</td>
        <td><small> {{ $telephone->mac }}</small></td>
				<td>
            @if($telephone->users->count() > 0)
                @foreach($telephone->users as $user)
                    {{ $user->FullName }} <br>
                @endforeach
            @endif
        </td>
        <td>
            {{ ($telephone->place)? $telephone->place->location->name:'' }}
        </td>
        <td>
            <small>{{ ($telephone->place)? $telephone->place->name:'' }}</small>
        </td>
				<td>
					  <a href="{{ route('resources.telephone.edit', $telephone->id) }}" class="btn btn-outline-secondary btn-sm">
					     <span class="fas fa-edit" aria-hidden="true"></span>
            </a>
				</td>
			</tr>
			@endforeach
		</tbody>
	</table>
</div>

{{ $telephones->links() }}

@endsection
