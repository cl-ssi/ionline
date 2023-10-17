@extends('layouts.bt4.app')

@section('title', 'Crear Frase del día')

@section('content')


<h3 class="mb-3">Crear Frase del día</h3>

<form method="POST" class="form-horizontal" action="{{ route('parameters.phrases.store') }}">
    @csrf

    <div class="row">
        <fieldset class="form-group col">
            <label for="for_phrase">Frase</label>
            <textarea class="form-control" id="for_phrase" rows="7" name="phrase" required></textarea>
        </fieldset>
    </div>
    <button type="submit" class="btn btn-primary">Actualizar</button>

    <a class="btn btn-outline-secondary" href="{{ route('parameters.phrases.index') }}">Volver</a>

</form>

@endsection

@section('custom_js')

@endsection
