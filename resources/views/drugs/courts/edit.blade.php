@extends('layouts.app')

@section('title', 'Crear Juzgados')

@section('content')

@include('drugs.nav')

<h3>Editar Juzgados</h3>

<form method="POST" class="form-horizontal" action="{{ route('drugs.courts.update', $court->id) }}">
    @method('PUT')
    @csrf

    <fieldset class="form-group">
      <label for="forname">Nombre</label>
      <input type="text" class="form-control" id="forname" placeholder="Ingrese el nombre del juzgado" name="name" value="{{ $court->name }}" required="">
    </fieldset>

    <fieldset class="form-group">
      <label for="foraddress">Dirección</label>
      <input type="text" class="form-control" id="foraddress" placeholder="Ingrese la dirección" name="address" value="{{ $court->address }}"  required="">
    </fieldset>

    <fieldset class="form-group">
      <label for="forcommune">Comuna</label>
      <input type="text" class="form-control" id="forcommune" placeholder="Ingrese la comuna" name="commune" value="{{ $court->commune }}"  required="">
    </fieldset>

    <div class="float-right">
        <a href="{{ route('drugs.courts.index') }}" class="btn btn-outline-secondary">Cancelar</a>
        <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Guardar</button>
    </div>

</form>

@endsection
