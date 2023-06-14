@extends('layouts.app')
@section('title', 'Módulo de Sumario - Crear Sumario')
@section('content')
    @include('summary.nav')
    <h3>Crear Sumario</h3>
    <form method="POST" class="form-horizontal" action="{{ route('summary.store') }}">
        @csrf
        @method('POST')
        <div class="form-row mb-3">
            <div class="col-12 col-md-4">
                <label for="for-name">Nombre*</label>
                <input type="text" class="form-control" name="name" autocomplete="off" required>
            </div>
        </div>

        <div class="form-row">
            <div class="mt-3 col-12">
                <button type="submit" class="btn btn-success">Guardar</button>
                <a href="{{ route('summary.index') }}" class="btn btn-outline-secondary">Cancelar</a>
            </div>
        </div>
    </form>
@endsection
