@extends('layouts.bt4.app')
@section('title', 'Editar Reunión Lobby')
@section('content')

    <h3>Editar Acta de reunión</h3>
    <form method="POST" class="form-horizontal" action="{{ route('lobby.meeting.update', $meeting->id) }}">
        @csrf
        @method('PUT')

        <div class="form-row mb-3">
            <fieldset class="col-12 col-md-5">
                <label for="">Responsable*</label>
                <input type="text" class="form-control" required value="{{ $meeting->responsible->fullName ?? '' }}"
                    readonly>
            </fieldset>

            <fieldset class="col-12 col-md-5">
                <label for="for-petitioner">Solicitante*</label>
                <input type="text" class="form-control" name="petitioner" required value="{{ $meeting->petitioner }}"
                    readonly>
            </fieldset>

            <fieldset class="col-12 col-md-2">
                <label for="for-mecanism">Mecanismo*</label>
                <select class="form-control" name="mecanism" readonly required>
                    <option value="">Seleccionar Mecanismo</option>
                    <option @if ($meeting->mecanism == 'Videoconferencia') selected @endif>Videoconferencia</option>
                    <option @if ($meeting->mecanism == 'Presencial') selected @endif>Presencial</option>
                </select>
            </fieldset>
        </div>

        <div class="form-row mb-3">
            <fieldset class="col-12 col-md-6">
                <label for="for-subject">Asunto*</label>
                <input type="text" class="form-control" name="subject" required value="{{ $meeting->subject }}" readonly>
            </fieldset>

            <fieldset class="col-12 col-md-2">
                <label for="for-date">Fecha*</label>
                <input type="date" class="form-control" max="{{ date('Y-m-d') }}" name="date" required readonly
                    value="{{ $meeting->date }}">
            </fieldset>

            <fieldset class="col-12 col-md-2">
                <label for="for-start_at">Hora inicio</label>
                <input type="time" name="start_at" class="form-control"
                    value="{{ $meeting->start_at->format('H:i') ?? '' }}">
            </fieldset>

            <fieldset class="col-12 col-md-2">
                <label for="for-end_at">Hora término</label>
                <input type="time" name="end_at" class="form-control"
                    value="{{ $meeting->end_at->format('H:i') ?? '' }}">
            </fieldset>
        </div>

        <div class="form-row mb-3">
            <fieldset class="col-md-12 col-12">
                <label for="exponents" class="form-label">
                    {{ __('Exponentes') }} (Relacionado con el solicissstante)
                </label>

                <textarea name="exponents" id="exponents" class="form-control" autocomplete="off">{{ $meeting->exponents ?? '' }}</textarea>
            </fieldset>
        </div>


        <div class="form-row mb-3">
            <fieldset class="col-md-12 col-12">
                <label for="participants" class="form-label">
                    {{ __('Participantes') }} (relacionado con el servicio)
                </label>
                @livewire('search-select-user', ['selected_id' => 'users[]', 'required' => 'required', 'addUsers' => 'true'])

                {{-- TODO 
                Ver como mostrar cuando es addUser --}}

                

            </fieldset>
        </div>



        <div class="form-row">
            <div class="mt-3 col-12">
                <button type="submit" class="btn btn-success">Actualizar</button>
                <a href="{{ route('lobby.meeting.index') }}" class="btn btn-outline-secondary">Cancelar</a>
            </div>
        </div>
    </form>



@endsection
