@extends('layouts.app')

@section('title', 'Crear Unidades Policiales')

@section('content')

@include('drugs.nav')

<h3>Editar Unidades Policiales</h3>

<form method="POST" class="form-horizontal" action="{{ route('drugs.police_units.update', $policeUnit->id) }}">
    @method('PUT')
    @csrf

    <fieldset class="form-group">
      <label for="forcode">Código</label>
      <input type="text" class="form-control" id="forcode" placeholder="Ingrese el código" name="code" value="{{ $policeUnit->code }}"  required="">
    </fieldset>

    <fieldset class="form-group">
      <label for="forname">Nombre</label>
      <input type="text" class="form-control" id="forname" placeholder="Ingrese el nombre de la unidad policial" name="name" value="{{ $policeUnit->name }}" required="">
    </fieldset>

    <div class="float-right">
        <a href="{{ route('drugs.police_units.index') }}" class="btn btn-outline-secondary">Cancelar</a>
        <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Guardar</button>
    </div>

</form>

@endsection
