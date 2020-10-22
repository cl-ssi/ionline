@extends('layouts.app')

@section('title', 'Nuevo convenio')

@section('content')

@include('programmings/nav')

<h3 class="mb-3"> Nuevo Listado de Actividades Anual </h3>

<form method="POST" class="form-horizontal small" action="{{ route('activityprograms.store') }}" enctype="multipart/form-data">
    @csrf

    <div class="form-row">
        <div class="form-group col-md-9">
            <label for="forprogram">Descripción</label>
            <input type="input" class="form-control" id="forreferente" name="description" required="">
        </div>

        <fieldset class="form-group col-3">
            <label for="fordate">Fecha</label>
            <input type="date" class="form-control" id="fordate" name="date" required="">
        </fieldset>
    </div>
    <button type="submit" class="btn btn-info mb-4">Guardar</button>

</form>

@endsection

@section('custom_js')

@endsection
