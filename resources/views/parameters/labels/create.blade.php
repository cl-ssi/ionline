@extends('layouts.app')

@section('title', 'Etiquetas')

@section('content')

<script src="{{ asset('js/colorpicker/jscolor.js') }}"></script>

<h3 class="mb-3">Crear Etiqueta de {{$module}}</h3>


<form method="POST" class="form-horizontal" action="{{ route('parameters.labels.store') }}">
    @csrf
    @method('POST')
    <input type="hidden" class="form-control" id="for_module" name="module" value="{{$module}}">
    <div class="row">
        <fieldset class="form-group col-3">
            <label for="for_name">Nombre:</label>
            <input type="text" class="form-control" id="for_name" name="name" required="" autocomplete="off">
        </fieldset>

        <fieldset class="form-group col">
            <label for="for_name">Color</label>
            <input class="form-control jscolor" name="color" value="ab2567" required="">
        </fieldset>

    </div>
    <button type="submit" class="btn btn-primary">Crear</button>

    @endsection

    @section('custom_js')

    @endsection