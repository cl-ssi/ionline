@extends('layouts.bt4.app')

@section('title', 'Creat Tipo de Establecimiento')

@section('content')
<h3 class="mb-3">Crear nuevo Tipo de Establecimiento</h3>

<form method="POST" class="form-horizontal" action="{{ route('parameters.establishment_types.store') }}">
    @csrf
    @method('POST')

    <div class="form-row">
        <fieldset class="form-group col-12 col-md-4">
            <label for="for_name">Nombre*</label>
            <input type="text" class="form-control" id="for_name" name="name" autocomplete="off" required>
        </fieldset>
    </div>

    <button type="submit" class="btn btn-primary">Guardar</button>
    <a class="btn btn-outline-secondary" href="{{ route('parameters.establishment_types.index') }}">Volver</a>

</form>


@endsection