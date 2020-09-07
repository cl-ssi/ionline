@extends('layouts.app')

@section('title', 'Editar Frase del día')

@section('content')

@include('parameters/nav')

<h3 class="mb-3">Editar Frase del día</h3>

<form method="POST" class="form-horizontal" action="{{ route('parameters.phrases.update', $phrase) }}">
    @csrf
    @method('PUT')

    <div class="row">
        <fieldset class="form-group col">
            <label for="for_phrase">Frase</label>
            <textarea class="form-control" id="for_phrase" rows="7" name="phrase" required>{{ $phrase->phrase }}</textarea>
        </fieldset>
    </div>
    <button type="submit" class="btn btn-primary">Actualizar</button>

</form>

@endsection

@section('custom_js')

@endsection
