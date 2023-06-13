@extends('layouts.app')
@section('title', 'Módulo de Sumario - Crear Eventos')
@section('content')
    @include('summary.nav')
    <h3>Crear Eventos Sumario</h3>
    <form method="POST" class="form-horizontal" action="{{ route('summary.events.store') }}">
        @csrf
        @method('POST')
        <div class="form-row mb-3">
            <div class="col-12 col-md-4">
                <label for="for-name">Nombre*</label>
                <input type="text" class="form-control" name="name" autocomplete="off" required>
            </div>

            <div class="col-12 col-md-2">
                <label for="for-duration">Duración</label>
                <input type="number" class="form-control" min="0" name="duration">
            </div>

            <div class="col-12 col-md-3">
                <label for="for-user">Usuario</label>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="user" value="1">
                </div>
            </div>

            <div class="col-12 col-md-3">
                <label for="for-file">Archivo</label>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="file" value="1">
                </div>
            </div>
        </div>

        <div class="form-row">
            <div class="mt-3 col-12">
                <button type="submit" class="btn btn-success">Guardar</button>
                <a href="{{ route('summary.events.index') }}" class="btn btn-outline-secondary">Cancelar</a>
            </div>
        </div>
    </form>
@endsection
