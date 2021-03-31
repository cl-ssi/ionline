@extends('layouts.app')

@section('title', 'Crear nuevo Permisos')

@section('content')

@include('parameters/nav')

<h3 class="mb-3">Crear Nueva Professión</h3>

<form method="POST" class="form-horizontal" action="{{ route('parameters.professions.store') }}">
    @csrf
    @method('POST')

    <div class="row">

    <fieldset class="form-group col-6 col-md-3">
            <label for="for_name">Nombre*</label>
            <input type="text" class="form-control" id="for_name" name="name" autocomplete="off" required>
        </fieldset>        

        <fieldset class="form-group col-12 col-md-7">
            <label for="for_category">Categoría</label>
            <input type="text" class="form-control" id="for_category" autocomplete="off" name="category">
        </fieldset>
    </div>
    

    <button type="submit" class="btn btn-primary">Guardar</button>

</form>

@endsection

@section('custom_js')

@endsection
