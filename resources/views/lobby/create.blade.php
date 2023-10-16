@extends('layouts.bt4.app')
@section('title', 'Crear Reuniones Lobby')
@section('content')

    <h3>Crear Acta de reunión</h3>
    <form method="POST" class="form-horizontal" action="{{ route('lobby.meeting.store') }}">
        @csrf
        @method('POST')

        <div class="form-row mb-3">
            <fieldset class="col-12 col-md-5">
                <label for="">Responsable*</label>
                @livewire('search-select-user', ['selected_id' => 'responsible_id'])
            </fieldset>

            <fieldset class="col-12 col-md-5">
                <label for="for-petitioner">Solicitante*</label>
                <input type="text" class="form-control" name="petitioner" required>
            </fieldset>

            <fieldset class="col-12 col-md-2">
                <label for="for-mecanism">Mecanismo*</label>
                <select class="form-control" name="mecanism" required>
                    <option value="">Seleccionar Mecanismo</option>
                    <option>Videoconferencia</option>
                    <option>Presencial</option>
                </select>
            </fieldset>
        </div>

        <div class="form-row mb-3">
            <fieldset class="col-12 col-md-6">
                <label for="for-subject">Asunto*</label>
                <input type="text" class="form-control" name="subject" required>
            </fieldset>

            <fieldset class="col-12 col-md-2">
                <label for="for-date">Fecha*</label>
                <input type="date" class="form-control" max="{{ date('Y-m-d') }}" name="date" required>
            </fieldset>
        </div>

        <div class="form-row">
            <div class="mt-3 col-12">
                <button type="submit" class="btn btn-success">Guardar</button>
                <a href="{{ route('lobby.meeting.index') }}" class="btn btn-outline-secondary">Cancelar</a>
            </div>
        </div>
    </form>

@endsection
