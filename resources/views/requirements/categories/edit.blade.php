@extends('layouts.app')

@section('title', 'Editar Categoría')

@section('content')

@include('requirements.partials.nav')

<script src="{{ asset('js/colorpicker/jscolor.js') }}"></script>

<h3 class="mb-3">Editar Categoría</h3>

<form method="POST" class="form-horizontal" action="{{ route('requirements.categories.update', $category) }}">
    @csrf
    @method('PUT')

    <div class="row">
        <fieldset class="form-group col-3">
            <label for="for_name">Nombre:</label>
            <input type="text" class="form-control" id="for_name" name="name" required="" value="{{$category->name}}">
        </fieldset>

        <fieldset class="form-group col">
            <label for="for_name">Color</label>
            <input class="form-control jscolor" id="color" name="color" required="" value="{{$category->color}}" onchange="update(this.jscolor)">
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
