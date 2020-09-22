@extends('layouts.app')

@section('title', 'Nuevo convenio')

@section('content')

@include('programmings/nav')

<h3 class="mb-3">Iniciar Programación Operativa </h3>

<form method="POST" class="form-horizontal small" action="{{ route('programmings.store') }}" enctype="multipart/form-data">
    @csrf

    <div class="form-row">
        <div class="form-group col-md-7">
            <label for="forprogram">Establecimiento</label>
            <select name="establishment" id="formprogram" class="form-control">
                @foreach($establishments as $establishment)
                    <option value="{{ $establishment->id }}">{{ $establishment->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group col-md-5">
            <label for="forprogram">Descripción</label>
            <input type="input" class="form-control" id="forreferente" name="description" required="">
        </div>
    </div>

    <div class="form-row">

        <fieldset class="form-group col-3">
            <label for="fordate">Fecha</label>
            <input type="date" class="form-control" id="fordate" name="date" required="">
        </fieldset>

        <fieldset class="form-group col-5">
            <label for="forreferente">Responsable</label>
            <input type="input" class="form-control" id="foruser" name="user" required="">
        </fieldset>
    </div>
    <button type="submit" class="btn btn-info mb-4">Guardar</button>

</form>

@endsection

@section('custom_js')

@endsection
