@extends('layouts.app')

@section('title', 'Unidades Policiales')

@section('content')

@include('drugs.nav')

<h3 class="mb-3">Agregar Unidades Policiales</h3>

<form method="POST" class="form-horizontal" action="{{ route('drugs.police_units.store') }}">
  {{ csrf_field() }} <!-- input hidden contra ataques CSRF -->
  <fieldset class="form-group">
    <label for="forcode">Código</label>
    <input type="text" class="form-control" id="forcode" placeholder="Ingrese el código" name="code" required="">
  </fieldset>

  <fieldset class="form-group">
    <label for="forname">Nombre</label>
    <input type="text" class="form-control" id="forname" placeholder="Ingrese el nombre de la unidad policial" name="name" required="">
  </fieldset>

  <div class="float-right">
    <a href="{{ route('drugs.police_units.index') }}" class="btn btn-outline-secondary">Cancelar</a>
    <button class="btn btn-outline-secondary" type="submit"><i class="fas fa-save"></i> Enviar</button>
  </div>
</form>


@endsection

@section('custom_js')

@endsection
