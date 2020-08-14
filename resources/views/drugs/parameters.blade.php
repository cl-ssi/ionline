@extends('layouts.app')

@section('title', 'Parametros Unidad de Drogas')

@section('content')

@include('drugs.nav')

<h3 class="mb-3">Parametros Unidad de Drogas</h3>
@foreach($parameters as $parameter)
    <form method="POST" class="form-inline" action="{{ route('parameters.update', $parameter->id) }}">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="for_{{ $parameter->parameter }}" class="sr-only"></label>
            <input type="text" readonly class="form-control-plaintext"
            id="for_{{ $parameter->parameter }}" name="parameter" value="{{ $parameter->parameter }}">
        </div>
        <div class="form-group mx-md-3 mb-2">
            <label for="for_{{ $parameter->value }}" class="sr-only">{{ $parameter->value }}</label>
            <input type="text" class="form-control mx-sm-3" id="for_{{ $parameter->value }}"
            name="value" value="{{ $parameter->value }}" aria-describedby="{{ $parameter->parameter }}Help">
            <small id="{{ $parameter->parameter }}Help" class="text-muted">
              {{ $parameter->description }}
            </small>
        </div>
        <button type="submit" class="btn btn-primary mb-2">Guardar</button>

    </form>

    <br>
@endforeach

@endsection

@section('custom_js')

@endsection
