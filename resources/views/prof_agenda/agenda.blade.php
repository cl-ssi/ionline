@extends('layouts.app')

@section('title', 'Agenda')

@section('content')

@include('prof_agenda.partials.nav')

<h3>Gestor de la agenda</h3>

<form method="GET" class="form-horizontal" action="{{ route('prof_agenda.agenda.index') }}">

    @livewire('prof-agenda.select-user-profesion',['profession_id' => $request->profession_id, 'user_id' => $request->user_id])

</form>

<hr>

<!-- Button trigger modal -->
<button type="button" class="btn btn-primary" data-toggle="modal" data-target=".bd-example-modal-lg">Agregar bloque de horario</button>

{{--<!-- @livewire('prof-agenda.add-agenda-block',['profession_id' => $request->profession_id, 'profesional_id' => $request->user_id]) -->--}}

@if($proposals->count()>0)
    @livewire('prof-agenda.agenda',['profession_id' => $request->profession_id, 'profesional_id' => $request->user_id])
    @stack('scripts')
@endif

<!-- Modal -->
<form method="POST" class="form-horizontal" action="{{ route('prof_agenda.open_hour.saveBlock') }}">
@csrf
@method('POST')

<input type="hidden" name="profesional_id" value="{{$request->user_id}}">
<input type="hidden" name="profession_id" value="{{$request->profession_id}}">

<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
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

            <!-- <fieldset class="form-group col col-md-2">
                <label for="for_id_deis"><br></label>
                <button type="submit" class="btn btn-primary form-control" wire:click="save()">Guardar</button>
            </fieldset> -->
        </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Guardar</button>
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

@endsection