@extends('layouts.bt4.app')

@section('title', 'Agenda')

@section('content')

@include('prof_agenda.partials.nav')

<h3>Reservas</h3>

<form method="GET" class="form-horizontal" action="{{ route('prof_agenda.open_hour.index') }}">

    @livewire('prof-agenda.select-user-profesion',['profession_id' => $request->profession_id, 'user_id' => $request->user_id, 'profesional_ust' => true])

    <div class="row">
        <fieldset class="form-group col col-md-4">
            <label for="for_id_deis">ID</label>
            <input type="text" class="form-control" name="id" @if($request) value="{{$request->id}}" @endif>
        </fieldset>

        <fieldset class="form-group col col-md-4">
            <label for="for_id_deis">Paciente</label>
            @livewire('search-select-user', [
                'selected_id' => 'patient_id'
            ])
        </fieldset>

        <fieldset class="form-group col col-md-4">
            <label for="for_id_deis">Asistencia</label>
            <select class="form-control" name="assistance" id="">
                <option value="-1" @selected(!$request->assistance == -1)>Todos</option>
                <option value="1" @selected($request->assistance == 1)>Asiste</option>
                <option value="0" @selected($request->assistance == 0)>No asiste</option>
                <option value="2" @selected($request->assistance == 2)>Bloqueados</option>
            </select>
        </fieldset>
    </div>

</form>

<hr>

<div class="form-row mb-4 justify-content-end">
    <div style="color:yellow">&#9632;</div>&nbsp;<p>Eliminado</p>&nbsp;&nbsp; <!--plomo-->
    <div style="color:green">&#9632;</div>&nbsp;<p>Asiste</p>&nbsp;&nbsp; <!--amarillo-->
    <div style="color:red">&#9632;</div>&nbsp;<p>No asiste</p>&nbsp;&nbsp; <!--verde-->
</div>

<table class="table table-sm table-bordered">
	<thead>
		<tr>
            <th>ID</th>
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
        @if($openHour->deleted_at) <tr class="table-warning">
        @elseif($openHour->assistance === 1) <tr class="table-success">
        @elseif($openHour->assistance === 0) <tr class="table-danger"> 
        @else <tr> @endif
            <td>{{$openHour->id}}</td>
            <td>{{$openHour->start_date->format('Y-m-d H:i')}}</td>
            <td>{{$openHour->end_date->format('Y-m-d H:i')}}</td>
            <td>@if($openHour->profesional){{$openHour->profesional->shortName}}@endif</td>
            <td>{{$openHour->activityType->name}}</td>
            <td>@if($openHour->patient)
                    {{$openHour->patient->shortName}}
                @elseif($openHour->externalUser)
                    {{$openHour->externalUser->shortName}}
                @endif</td>
            <td>
                @if($openHour->deleted_at) <i class="fa fa-ban" aria-hidden="true"></i>
                @elseif($openHour->assistance === 1) <i class="fa fa-check" aria-hidden="true"></i>
                @elseif($openHour->assistance === 0) <i class="fa fa-times" aria-hidden="true"></i>
                @endif
                @canany(['Agenda UST: Administrador'])
                    <a data-toggle="collapse" href="#hiddenrow{{$openHour->id}}" role="button" aria-expanded="false" aria-controls="collapseExample">
                        <i class="fa fa-eye" aria-hidden="true"></i>
                    </a>
                @endcanany
            </td>
		</tr>

        @canany(['Agenda UST: Administrador'])
            <tr id="hiddenrow{{$openHour->id}}" class="collapse">
                <td colspan="7">@include('prof_agenda.partials.audit', ['audits' => $openHour->audits] )</td>
            </tr>
        @endcanany

	@endforeach
	</tbody>
</table>


{{$openHours->appends(request()->query())->links()}}

@endsection