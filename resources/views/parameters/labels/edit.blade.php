@extends('layouts.bt4.app')

@section('title', 'Editar Etiqueta')

@section('content')

<script src="{{ asset('js/colorpicker/jscolor.js') }}"></script>

<h3 class="mb-3">Editar Etiqueta de {{ $inventoryLabel->module }}</h3>

<form method="POST" class="form-horizontal" action="{{ route('parameters.labels.update', $inventoryLabel) }}">
    @csrf
    @method('PUT')
    <input type="hidden" class="form-control" id="for_module" name="module" value="{{ $inventoryLabel->module }}">
    <div class="row">
        <fieldset class="form-group col-3">
            <label class="font-weight-bold" for="for_name">Nombre</label>
            <input type="text" class="form-control" id="for_name" name="name" required="" autocomplete="off" value="{{ $inventoryLabel->name }}">
        </fieldset>

        <fieldset class="form-group col">
            <label class="font-weight-bold" for="for-color">Color</label>
            <input class="form-control jscolor" name="color" value="{{ $inventoryLabel->color }}" required="" onchange="update(this.jscolor)" id="for-color">
        </fieldset>

    </div>
    <button type="submit" class="btn btn-primary">Crear</button>
</form>

@endsection

@section('custom_js')
    <script>
    $( document ).ready(function() {
      document.getElementById("for_name").focus();
    });

    function update(jscolor) {
        // 'jscolor' instance can be used as a string
        document.getElementById('rect').style.backgroundColor = '#' + jscolor
    }
    </script>
@endsection