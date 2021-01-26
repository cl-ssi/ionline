@extends('layouts.app')

@section('content')

@include('suitability.nav')

<h3 class="mb-3">Nueva Opción</h3>

<form method="POST" class="form-horizontal" action="{{ route('suitability.options.store') }}">
    @csrf
    @method('POST')
    <div class="form-row align-items-end">
        <fieldset class="form-group col-6 col-sm-6 col-md-6 col-lg-6">
            <label for="for_run">Preguntas*</label>
            <select class="form-control" name="question_id" id="question_id" required>
            <option value="">Seleccionar Pregunta</option>
            @foreach($questions as $question)
            <option value="{{ $question->id }}">{{ $question->question_text }} ({{$question->category->name}})</option>
            @endforeach
            </select>
        </fieldset>
    </div>

    <div class="form-group">
        <fieldset>
            <label class="required" for="option_text">Texto Opción*</label>
            <textarea class="form-control" name="option_text" id="option_text" required></textarea>
        </fieldset>
    </div>

    <div class="form-group">
    <fieldset>
            <label class="required" for="points">Puntos Opción*</label>
            <input type="number" class="form-control" name="points" id="points" required></input>
        </fieldset>

    </div>

    <button type="submit" class="btn btn-primary">Guardar</button>
</form>


@endsection

@section('custom_js')


@endsection