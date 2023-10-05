@extends('layouts.app')

@section('title', 'Agenda')

@section('content')

@include('prof_agenda.partials.nav')

<h3>Reservas</h3>

<form method="GET" class="form-horizontal" action="{{ route('prof_agenda.open_hour.index') }}">

    @livewire('prof-agenda.select-user-profesion',['profession_id' => $request->profession_id, 'user_id' => $request->user_id])

</form>

<hr>

<table class="table table-striped table-sm table-bordered">
	<thead>
		<tr>
            <th>F.Inicio</th>
			<th>F.Término</th>
            <th>Funcionario</th>
            <th>T.Actividad</th>
			<th>Paciente</th>
            <th>Asistencia</th>
		</tr>
	</thead>
	<tbody>
	@foreach($openHours as $openHour)
        @if($openHour->assistance === 1) <tr class="table-success">
        @elseif($openHour->assistance === 0) <tr class="table-danger"> 
        @else <tr> @endif
            <td>{{$openHour->start_date->format('Y-m-d h:i')}}</td>
            <td>{{$openHour->end_date->format('Y-m-d h:i')}}</td>
            <td>@if($openHour->profesional){{$openHour->profesional->shortName}}@endif</td>
            <td>{{$openHour->activityType->name}}</td>
            <td>@if($openHour->patient){{$openHour->patient->shortName}}@endif</td>
            <td>
                @if($openHour->assistance === 1) <i class="fa fa-check" aria-hidden="true"></i>
                @elseif($openHour->assistance === 0) <i class="fa fa-times" aria-hidden="true"></i>
                @endif
            </td>
		</tr>
	@endforeach
	</tbody>
</table>

@endsection