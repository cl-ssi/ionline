@extends('layouts.bt4.app')

@section('title', 'Agenda')

@section('content')

@include('prof_agenda.partials.nav')

<h3>Gestor de la agenda</h3>

<form method="GET" class="form-horizontal" action="{{ route('prof_agenda.agenda.index') }}">

    @livewire('prof-agenda.select-user-profesion',['profession_id' => $request->profession_id, 'user_id' => $request->user_id, 'profesional_ust' => true])

</form>

<hr>

@if($proposals->count()>0)

    <!-- Button trigger modal -->
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addBlock">Agregar bloque de horario</button>
    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteBlocks">Eliminar bloques</button>
    <button type="button" class="btn btn-info" data-toggle="modal" data-target="#blockPeriod">Bloquear período</button>
    <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#jubilado">Reservar jubilado</button>

    @livewire('prof-agenda.agenda',['profession_id' => $request->profession_id, 'profesional_id' => $request->user_id])
    @stack('scripts')
@endif

<!-- Modal -->
<form method="POST" class="form-horizontal" action="{{ route('prof_agenda.open_hour.saveBlock') }}">
    @csrf
    @method('POST')
    <input type="hidden" name="profesional_id" value="{{$request->user_id}}">
    <input type="hidden" name="profession_id" value="{{$request->profession_id}}">
    <div class="modal fade bd-example-modal-lg" tabindex="-1" id="addBlock" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">Agregar bloque de horario</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            

            <div class="row">
                <fieldset class="form-group col col-md">
                    <label for="for_id_deis">Día</label>
                    <input type="date" class="form-control" name="date" required>
                </fieldset>

                <fieldset class="form-group col col-md">
                    <label for="for_id_deis">H.inicio</label>
                    <input type="time" class="form-control" name="start_hour" required>
                </fieldset>

                <fieldset class="form-group col col-md">
                    <label for="for_id_deis">H.término</label>
                    <input type="time" class="form-control" name="end_hour" required>
                </fieldset>

                <fieldset class="form-group col col-md">
                    <label for="for_duration">Duración</label>
                    <select name="duration" name="duration" class="form-control" id="" required>
                        <option value=""></option>
                        <option value="60">60</option>
                        <option value="40">40</option>
                        <option value="30">30</option>
                        <option value="20">20</option>
                    </select>
                </fieldset>

                <fieldset class="form-group col col-md">
                    <label for="for_activity_type_id">T.actividad</label>
                    <select name="activity_type_id" class="form-control" id="" required>
                        <option value=""></option>
                        @foreach($activity_types as $activity_type)
                            <option value="{{$activity_type->id}}">{{$activity_type->name}}</option>
                        @endforeach
                    </select>
                </fieldset>

            </div>

        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-primary" onclick="return confirm('¿Está seguro que desea agregar el bloque de horario?')">Guardar</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        </div>
        </div>
    </div>
    </div>
</form>

<form method="POST" class="form-horizontal" action="{{ route('prof_agenda.open_hour.deleteBlocks') }}">
    @csrf
    @method('POST')

    <input type="hidden" name="profesional_id" value="{{$request->user_id}}">
    <div class="modal fade bd-example-modal-lg" tabindex="-1" id="deleteBlocks" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">Eliminar bloques de horario</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="row">
                <fieldset class="form-group col col-md">
                    <label for="for_id_deis">Día</label>
                    <input type="date" class="form-control" name="date" required>
                </fieldset>

                <fieldset class="form-group col col-md">
                    <label for="for_id_deis">H.inicio</label>
                    <input type="time" class="form-control" name="start_hour" required>
                </fieldset>

                <fieldset class="form-group col col-md">
                    <label for="for_id_deis">H.término</label>
                    <input type="time" class="form-control" name="end_hour" required>
                </fieldset>
            </div>

        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-primary" onclick="return confirm('¿Está seguro que desea eliminar el bloque de horario?')">Eliminar</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        </div>
        </div>
    </div>
    </div>
</form>

<!-- bloquear periodo de tiempo -->
<form method="POST" class="form-horizontal" action="{{ route('prof_agenda.open_hour.blockPeriod') }}">
    @csrf
    @method('POST')

    <input type="hidden" name="profesional_id" value="{{$request->user_id}}">
    <div class="modal fade bd-example-modal-lg" tabindex="-1" id="blockPeriod" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">Bloquear período de tiempo</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="row">
                <fieldset class="form-group col col-md">
                    <label for="for_id_deis">Inicio</label>
                    <input type="date" class="form-control" name="start_date" required>
                </fieldset>

                <fieldset class="form-group col col-md">
                    <label for="for_id_deis">H.inicio</label>
                    <input type="time" class="form-control" name="start_hour" required>
                </fieldset>

            </div>

            <div class="row">
                <fieldset class="form-group col col-md">
                    <label for="for_id_deis">Término</label>
                    <input type="date" class="form-control" name="end_date" required>
                </fieldset>

                <fieldset class="form-group col col-md">
                    <label for="for_id_deis">H.término</label>
                    <input type="time" class="form-control" name="end_hour" required>
                </fieldset>
            </div>

        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-primary" onclick="return confirm('¿Está seguro que desea bloquear el período seleccionado?')">Bloquear</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        </div>
        </div>
    </div>
    </div>
</form>

<form method="POST" class="form-horizontal" action="{{ route('prof_agenda.open_hour.externalUserSave') }}">
    @csrf
    @method('POST')
    <div class="modal fade bd-example-modal-lg" tabindex="-1" id="jubilado" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">Reservar jubilado</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            
            @livewire('prof-agenda.select-activity-type-open-hours',['profession_id' => $request->profession_id, 'profesional_id' => $request->user_id])

            @livewire('prof-agenda.external-employee-data')

        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-primary" onclick="return confirm('¿Está seguro que desea reservar el bloque de horario?')">Guardar</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        </div>
        </div>
    </div>
    </div>
</form>

@endsection

<!-- CSS Custom para el calendario -->
@section('custom_css')

@endsection

@section('custom_js')

<script src='{{asset("js/jquery.rut.chileno.js")}}'></script>
<script type="text/javascript">
	$(document).ready(function() {
        //obtiene digito verificador
        $('input[name=user_id]').keyup(function(e) {
			var str = $("#for_user_id").val();
			$('#for_dv').val($.rut.dv(str));
		});
    });
</script>

@endsection