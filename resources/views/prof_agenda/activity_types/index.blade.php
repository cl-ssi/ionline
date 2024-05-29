@extends('layouts.bt4.app')

@section('title', 'Lista de tipos de actividad')

@section('content')

@include('prof_agenda.partials.nav')

<h3 class="inline">Tipos de actividad
	<a href="{{ route('prof_agenda.activity_types.create') }}" class="btn btn-primary">Crear</a>
</h3>

<table class="table table-striped table-sm table-bordered">
	<thead>
		<tr>
            <th>Id</th>
			<th nowrap>Nombre</th>
            <th nowrap>Reservable</th>
            <th nowrap>Glosa/Descripción</th>
            <th nowrap>Permite Reservas D/consecutivos</th>
            <th nowrap>Max.Reservas p/semana</th>
            <th nowrap>Autoreservable</th>
            <th style="width:10%"></th>
            <th style="width:10%"></th>
		</tr>
	</thead>
	<tbody>
	@foreach($activityTypes as $activityType)
		<tr>
            <td>{{ $activityType->id}}</td>
			<td nowrap>{{ $activityType->name }}</td>
            <td nowrap>@if($activityType->reservable) Reservable @else No reservable @endif</td>
            <td nowrap>{{ substr($activityType->description, 0, 30) }}</td>
            <td>
                @if($activityType->allow_consecutive_days) Sí @else No @endif
            </td>
            <td>{{$activityType->maximum_allowed_per_week}}</td>
            <td nowrap>@if($activityType->auto_reservable) Autoreservable @else No autoreservable @endif</td>
			<td style="width:10%">
				<a href="{{ route('prof_agenda.activity_types.edit', $activityType) }}"
					class="btn btn-sm btn-outline-secondary">
					<span class="fas fa-edit" aria-hidden="true"></span>
				</a>
			</td>
            <td style="width:10%">
                <form method="POST" class="form-horizontal" action="{{ route('prof_agenda.activity_types.destroy', $activityType) }}">
                    @csrf
                    @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger btn-sm"
                            onclick="return confirm('Si elimina esta actividad, se eliminar todos los bloques de horario aperturados asociados. ¿Está seguro que desea eliminar el tipo de actividad?')">
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
