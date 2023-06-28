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
                <label for="for-name">Asunto*</label>
                <input type="text" class="form-control" name="subject" autocomplete="off" required>
            </div>

            <div class="col-12 col-md-3">
                <label for="for-type">Tipo de Resolución*</label>
                <select name="type" id="for_type" class="form-control" required>
                    <option value="">Seleccionar Tipo de Resolución</option>
                    <option value="Sumario Administrativo">Sumario Administrativo</option>
                    <option value="Investigación Sumaria">Investigación Sumaria</option>
                </select>
            </div>

            <div class="col-12 col-md-2">
                <label for="for-name">Número de Resolución*</label>
                <input type="text" class="form-control" name="resolution_number" autocomplete="off" required>
            </div>

            <div class="col-12 col-md-2">
                <label for="for-name">Fecha de Resolución*</label>
                <input type="date" class="form-control" name="resolution_date" autocomplete="off" max={{ now() }}
                    required>
            </div>
        </div>

        <hr>

        <div class="form-group pt-1" style="width: 940px;">
            <label for="for-observation">Observaciones</label>
            <textarea class="form-control" id="for-observation" rows="15" name="observation"></textarea>
        </div>        

        <div class="form-row">
            <div class="mt-3 col-12">
                <button type="submit" class="btn btn-success">Guardar</button>
                <a href="{{ route('summary.index') }}" class="btn btn-outline-secondary">Cancelar</a>
            </div>
        </div>
    </form>
@endsection
