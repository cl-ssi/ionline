@extends('layouts.bt4.app')

@section('title', 'Editar Calendario')

@section('content')


<form class="form-horizontal" id="edit_event_form" method="POST" action="/vehicleCalendar/edit/{{$event->id}}">
    @csrf
    @method('PATCH')
    <div class="form-group">
        <label for="edit_title_input">Titulo</label>
        <input class="form-control" id="edit_title_input" name="title" type="text"
            placeholder="Escriba el Titulo del Evento" value="{{$event->title}}">
        <span class="text-danger" id="edit_title_error"></span>
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-6 pl-0 pr-1">
                <div class="form-group">
                    <label for="edit_start_input">Fecha Inicio</label>
                    <input class="form-control" id="edit_start_input" name="start" type="datetime-local"
                        value="{{$event->start}}">
                    <span class="text-danger" id="edit_start_error"></span>

                </div>
            </div>
            <div class="col-6 pl-1 pr-0">
                <div class="form-group">
                    <label for="edit_end_input">Fecha Termino</label>
                    <input class="form-control" id="edit_end_input" name="end" type="datetime-local"
                        value="{{$event->end}}">
                    <span class="text-danger" id="edit_end_error"></span>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-6 pl-0 pr-1">
                <div class="form-group">
                    <label for="edit_car_input">Patente Vehiculo</label>
                    <input class="form-control" id="edit_car_input" name="car_licence_number" type="text"
                        placeholder="Escriba la patente" value="{{$event->car_licence_number}}">
                </div>
            </div>
            <div class="col-6 pl-1 pr-0">
                <div class="form-group">
                    <label for="edit_passengers_input">Numero de Pasajeros</label>
                    <input class="form-control" id="edit_passengers_input" name="passenger_number" type="number"
                        placeholder="(Valor de 1 a 16)" min="1" max="16" value="{{$event->passenger_number}}">
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-6 pl-0 pr-1">
                <div class="form-group">
                    <label for="edit_location_input">Destino</label>
                    <input class="form-control" id="edit_location_input" name="location" type="text"
                        placeholder="Escriba el Destino" value="{{$event->location}}">
                    @error('location')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="col-md-6 pl-1 pr-0">
                <div class="form-group">
                    <label for="edit_state_option">Estado</label>
                    <select class="custom-select" id="edit_state_option" name='state' va>
                        <option value="En Mantencion" style="background-color: #dc3545; color: white" {{
                            old('edit_state_option', $event->state) == 'En Mantencion' ? 'selected' : '' }}>En
                            Mantencion</option>
                        <option value="Por Confirmar" style="background-color: #fd7e14" {{ old('edit_state_option',
                            $event->state) == 'Por Confirmar' ? 'selected' : '' }}>Por Confirmar</option>
                        <option value="En Espera" style="background-color: #ffc107" {{ old('edit_state_option', $event->
                            state) == 'En Espera' ? 'selected' : '' }}>En Espera</option>
                        <option value="Agendado" style="background-color: #198754" {{ old('edit_state_option', $event->
                            state) == 'Agendado' ? 'selected' : '' }}>Agendado</option>
                        <option value="Disponible" style="background-color: #0d6efd" {{ old('edit_state_option',
                            $event->state) == 'Disponible' ? 'selected' : '' }}>Disponible</option>
                        <option value="Suspendido" style="background-color: #6c757d; color: white" {{
                            old('edit_state_option', $event->state) == 'Suspendido' ? 'selected' : '' }}>Suspendido
                        </option>
                        <option value="No Operativo" style="background-color: #553C7B; color: white" {{
                            old('edit_state_option', $event->state) == 'No Operativo' || old('edit_state_option', $event->state) == 'Licencia' ? 'selected' : '' }}>No Operativo</option>
                    </select>
                    @error('state')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="container-fluid">
                <div class="row">
                    <div class="form-group">
                        <label for="edit_comment_input">Comentario</label>
                        <textarea class="form-control" id="edit_comment_input" cols="180"
                            name="comment">{{$event->comment}}</textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-6 pl-0 pr-1">
                <div class="form-group">
                    <label for="create_driver_id">Conductor</label>
                    @livewire('search-select-user', ['selected_id' => 'driver_id','user' => $event->driver])
                    <span class="text-danger" id="create_driver_error"></span>
                </div>
            </div>

            <div class="col-6 pl-0 pr-1">
                <div class="form-group">
                    <label for="create-requester-id">Solicitante</label>
                    @livewire('search-select-user', ['selected_id' => 'requester_id', 'user' => $event->requester])
                    <span class="text-danger" id="create_requester_error"></span>
                </div>
            </div>
        </div>
    </div>

    <button class="form-control btn btn-primary" id="edit_submit_btn" type="submit">Guardar</button>
</form>

@stack('scripts')

@endsection