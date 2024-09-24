@extends('layouts.bt4.app')

@section('title', 'Agendamiento Unidad de Salud del Trabajador')

@section('content')

@include('prof_agenda.partials.nav')

<h4>Mis reservas</h4>

<table class="table table-striped table-sm table-bordered">
	<thead>
		<tr>
            <th>Id</th>
			<th nowrap>Especialidad</th>
            <th nowrap>Profesional</th>
            <th nowrap>T.Actividad</th>
            <th nowrap>Fecha</th>
            <th nowrap>Asistencia</th>
            <th nowrap>Motivo.Inasistencia</th>
            <th style="width:10%"></th>
		</tr>
	</thead>
	<tbody>
	@foreach($openHours as $openHour)
		<tr>
            <td>{{ $openHour->id}}</td>
            <td nowrap>{{ $openHour->profession->name }}</td>
			<td nowrap>@if($openHour->profesional) {{ $openHour->profesional->shortName }} @endif</td>
            <td nowrap>@if($openHour->activityType){{ $openHour->activityType->name }}@endif</td>
            <td nowrap>{{ $openHour->start_date }}</td>
            <td nowrap>
                @if($openHour->assistance)
                    @if($openHour->assistance == 1)
                        Asiste
                    @else
                        No asistep
                    @endif
                @else
                    Pendiente
                @endif
            </td>
            <td nowrap>{{ $openHour->absence_reason }}</td>
            <td nowrap>
                @if(!$openHour->assistance)
                    <form method="POST" class="form-horizontal" onsubmit="return confirm('¿Está seguro de eliminar la reserva?');" action="{{ route('prof_agenda.open_hour.auto_delete_reservation') }}">
                    @csrf
                    @method('POST')
                        <input class="openHours_id" type="hidden" id="" name="openHours_id" value="{{$openHour->id}}">
                        <button type="submit" class="form-control btn btn-danger">Eliminar</button>
                    </form>
                @endif
            </td>
		</tr>
	@endforeach
	</tbody>
</table>

{{ $openHours->appends(request()->query())->links() }}

@endsection