@extends('layouts.app')

@section('title', 'Frases del día')

@section('content')

@include('parameters/nav')

<h3 class="mb-3">Frases del día</h3>

<a class="btn btn-primary mb-3" href="{{ route('parameters.phrases.create')}}"> Nuevo </a>

    @foreach($phrases as $phrase)
    <div class="card mb-2">

        <div class="card-body">
            <h5 class="card-title">{{ $phrase->id }} <small> <a href="{{ route('parameters.phrases.edit', $phrase) }}">Editar</a></small> </h5>
            <pre>{{ $phrase->phrase }}</pre>
        </div>
    </div>
    @endforeach

@endsection

@section('custom_js')

@endsection
