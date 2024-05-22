@extends('layouts.bt4.app')

@section('title', 'Lista de Propuestas')

@section('content')

@include('prof_agenda.partials.nav')

<h3 class="inline">Listado de propuestas
	<a href="{{ route('prof_agenda.proposals.create') }}" class="btn btn-primary">Crear</a>
</h3>

<div class="form-row justify-content-end">
    <div style="color:white; border: 1px solid black; width: 20px; height: 20px; display: inline-block;">&#9632;</div>&nbsp;<p>Activos</p>&nbsp;&nbsp; 
    <div style="color:#FAC2C2; width: 20px; height: 20px; display: inline-block;">&#9632;</div>&nbsp;<p>Bloqueado</p>&nbsp;&nbsp; 
    <div style="color:#FAFAC0; width: 20px; height: 20px; display: inline-block;">&#9632;</div>&nbsp;<p>Expirados</p>&nbsp;&nbsp; 
</div>

<table class="table table-sm table-bordered">
	<thead>
		<tr>
            <th>Id</th>
			<th nowrap>Tipo</th>
            <th>Funcionario</th>
			<th>Profesión</th>
            <th>F.Inicio</th>
            <th>F.Término</th>
            <th>Estado</th>
            <th></th>
		</tr>
	</thead>
	<tbody>
	@foreach($proposals as $proposal)
        <tr class=""> 
        @if($proposal->end_date < now()) <tr class="table-warning"> @endif
        @if($proposal->status == "Bloqueado") <tr class="table-danger"> @endif

            <td>{{ $proposal->id}}</td>
			<td nowrap>{{ $proposal->type }}</td>
            <td>{{$proposal->employee->shortName}}</td>
			<td>{{ $proposal->profession->name }}</td>
            <td>{{ $proposal->start_date->format('Y-m-d') }}</td>
            <td>{{ $proposal->end_date->format('Y-m-d') }}</td>
            <td>{{$proposal->status}}</td>
			<td>
				<a href="{{ route('prof_agenda.proposals.edit', $proposal) }}"
					class="btn btn-sm btn-outline-secondary">
					<span class="fas fa-edit" aria-hidden="true"></span>
				</a>
			</td>
            <td>
                @if($proposal->status != "Aperturado")
                    <form method="POST" class="form-horizontal" action="{{ route('prof_agenda.proposals.destroy', $proposal) }}">
                        @csrf
                        @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger btn-sm"
                                onclick="return confirm('¿Está seguro que desea eliminar la propuesta?')">
                                <i class="fas fa-trash"></i>
                            </button>
                    </form>
                @endif
            </td>
		</tr>
	@endforeach
	</tbody>
</table>

@endsection

@section('custom_js')

@endsection
