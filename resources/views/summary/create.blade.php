@extends('layouts.bt5.app')

@section('title', 'Módulo de Sumario - Crear Sumario')

@section('content')

@include('summary.nav')

<h3 class="mb-3">Crear Sumario</h3>

<form method="POST" class="form-horizontal" action="{{ route('summary.store') }}">
    @csrf
    @method('POST')
    <div class="row mb-3 g-2">
        <div class="col-12 col-md-4">
            <label for="for-name">Asunto*</label>
            <input type="text" class="form-control" name="subject" autocomplete="off" required>
        </div>

        <div class="col-12 col-md-3">
            <label for="for-type">Tipo*</label>
            <select name="type_id" id="for_type" class="form-select" required>
                <option value=""></option>
                @foreach($types as $id => $name)
                    <option value="{{ $id }}">{{ $name }}</option>
                @endforeach
            </select>
        </div>

        <div class="col-12 col-md-2">
            <label for="for-name">Nº. Resolución*</label>
            <input type="text" class="form-control" name="resolution_number" autocomplete="off" required>
        </div>

        <div class="col-12 col-md-3">
            <label for="for-name">Fecha de Resolución*</label>
            <input type="date" class="form-control" name="resolution_date" autocomplete="off" max={{ now() }}
                required>
        </div>
    </div>

    <hr>

    <div class="form-group pt-1">
        <label for="for-observation">Observaciones</label>
        <textarea class="form-control" id="for-observation" rows="5" name="observation"></textarea>
    </div>

    <div class="row">
        <div class="mt-3 col-12">
            <button type="submit" class="btn btn-success">Guardar</button>
            <a href="{{ route('summary.index') }}" class="btn btn-outline-secondary">Cancelar</a>
        </div>
    </div>
</form>

@endsection