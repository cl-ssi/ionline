@extends('layouts.app')

@section('title', 'Juzgados')

@section('content')

@include('drugs.nav')

<h3 class="mb-3">Agregar Juzgados</h3>

<form method="POST" class="form-horizontal" action="{{ route('drugs.courts.store') }}">
  {{ csrf_field() }} <!-- input hidden contra ataques CSRF -->
  <fieldset class="form-group">
    <label for="forname">Nombre</label>
    <input type="text" class="form-control" id="forname" placeholder="Ingrese el nombre del juzgado" name="name" required="">
  </fieldset>

  <fieldset class="form-group">
    <label for="foraddress">Dirección</label>
    <input type="text" class="form-control" id="foraddress" placeholder="Ingrese la dirección" name="address" required="">
  </fieldset>

  <fieldset class="form-group">
    <label for="forcommune">Comuna</label>
    <input type="text" class="form-control" id="forcommune" placeholder="Ingrese la comuna" name="commune" required="">
  </fieldset>

  <!--<fieldset class="form-group">
    <label for="forcommune">Comuna</label>
    <select class="form-control" id="forcommune" name="commune">
      <option value="">Seleccione...</option>
    </select>
  </fieldset>-->

  <div class="float-right">
    <a href="{{ route('drugs.courts.index') }}" class="btn btn-outline-secondary">Cancelar</a>
    <button class="btn btn-primary" type="submit"><i class="fas fa-save"></i> Guardar</button>
  </div>
</form>


@endsection

@section('custom_js')

@endsection
