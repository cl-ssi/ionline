@extends('layouts.app')

@section('content')

@include('suitability.nav')

<h3 class="mb-3">Editar Pregunta Número {{$question->id}}</h3>

<form method="POST" class="form-horizontal" action="{{ route('suitability.questions.update',$question) }}">
    @csrf
    @method('PUT')
    <div class="form-row align-items-end">
        <fieldset class="form-group col-6 col-sm-6 col-md-6 col-lg-6">
            <label for="for_run">Examenes*</label>
            <select class="form-control" name="category_id" id="category_id" required>
            <option value="">Seleccionar Examen</option>
            @foreach($categories as $category)
            <option value="{{ $category->id }}">{{ $category->name }}</option>
            @endforeach
            </select>
        </fieldset>
    </div>
    

    <div class="form-group">

        <fieldset>
            <label class="required" for="question_text">Texto Pregunta*</label>
            <textarea class="form-control" name="question_text" id="question_text" required>{{$question->question_text}}</textarea>
        </fieldset>
    </div>

    <button type="submit" class="btn btn-primary">Actualizar</button>
</form>

@endsection