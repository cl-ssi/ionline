@extends('layouts.app')

@section('title', 'Crear Categoría')

@section('content')

@include('requirements.partials.nav')

<script src="{{ asset('js/colorpicker/jscolor.js') }}"></script>

<h3 class="mb-3">Crear Categoría</h3>

<form method="POST" class="form-horizontal" action="{{ route('requirements.categories.store') }}">
    @csrf
    @method('POST')

    <div class="row">
        <fieldset class="form-group col-3">
            <label for="for_name">Nombre:</label>
            <input type="text" class="form-control" id="for_name" name="name" required="">
        </fieldset>

        <fieldset class="form-group col">
            <label for="for_name">Color</label>
            <input class="form-control jscolor" name="color" value="ab2567" required="">
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
  </script>
@endsection
