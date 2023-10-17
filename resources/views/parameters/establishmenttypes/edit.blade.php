@extends('layouts.bt4.app')

@section('title', 'Editar Tipo de Establecimiento')

@section('content')

<h3 class="mb-3">Editar Tipo de Establecimiento</h3>
<form method="POST" class="form-horizontal" action="{{ route('parameters.establishment_types.update', $establishmentType) }}">
    @csrf
    @method('PUT')
    <div class="form-row">
    <fieldset class="form-group col-12 col-md-4">
        <label for="for_name">Nombre*</label>
        <input type="text" class="form-control" id="for_name" name="name" value="{{ old('name', $establishmentType->name) }}" autocomplete="off" required>
    </fieldset>
    </div>

    <button type="submit" class="btn btn-primary">Actualizar</button>
    <a class="btn btn-outline-secondary" href="{{ route('parameters.establishment_types.index') }}">Volver</a>
</form>
@endsection