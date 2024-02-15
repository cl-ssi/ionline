@extends('layouts.bt5.app')

@section('title', 'Módulo de Vinculos - Crear')

@section('content')
    @include('summary.nav')
    <h3>Crear Vínculos</h3>
    <form method="POST" class="form-horizontal" action="{{ route('summary.links.store') }}">
        @csrf
        @method('POST')

        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="for_before_event_id">Evento Anterior</label>
                <select id="for_before_event_id" name="before_event_id" class="form-control" required>
                    <option value="">Seleccionar Evento Anterior</option>
                    @foreach ($events as $event)
                        <option value="{{ $event->id }}">{{ $event->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group col-md-6">
                <label for="for_after_event_id">Evento Sucesor</label>
                <select id="for_after_event_id" name="after_event_id" class="form-control" required>
                    <option value="">Seleccionar Evento Posterior</option>
                    @foreach ($events as $event)
                        <option value="{{ $event->id }}">{{ $event->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>


        <div class="form-row">
            <div class="mt-3 col-12">
                <button type="submit" class="btn btn-success">Guardar</button>
                <a href="{{ route('summary.links.index') }}" class="btn btn-outline-secondary">Cancelar</a>
            </div>
        </div>

    </form>

@endsection

@section('custom_js')

@endsection