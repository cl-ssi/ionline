@extends('layouts.app')

@section('title', 'Crear nuevo Permisos')

@section('content')

@include('parameters/nav')

<h3 class="mb-3">Crear nuevo Permisos</h3>

<form method="POST" class="form-horizontal" action="{{ route('parameters.permissions.store') }}">
    @csrf
    @method('POST')

    <div class="row">

    <fieldset class="form-group col-6 col-md-3">
            <label for="for_name">Nombre*</label>
            <input type="text" class="form-control" id="for_name" name="name" required>
        </fieldset>

        <fieldset class="form-group col-6 col-md-2">
            <label for="for_guard_name">Guard</label>
            <input type="text" class="form-control" id="for_guard_name" name="guard_name" readonly
                value="{{$guard}}">
        </fieldset>

        <fieldset class="form-group col-12 col-md-7">
            <label for="for_descripcion">Descripción</label>
            <input type="text" class="form-control" id="for_descripcion" name="descripcion"
                 >
        </fieldset>
    </div>
    

    <button type="submit" class="btn btn-primary">Guardar</button>

</form>

@endsection

@section('custom_js')

@endsection
