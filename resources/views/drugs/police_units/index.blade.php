@extends('layouts.app')

@section('title', 'Unidades Policiales')

@section('content')

@include('drugs.nav')

<h3 class="mb-3">Unidades Policiales</h3>

<fieldset class="form-group">
    <div class="input-group">
        <div class="input-group-prepend">
          <span class="input-group-text" id="basic-addon1"><i class="fas fa-search"></i></span>
        </div>
        <input type="text" class="form-control" id="forsearch" onkeyup="filter(1)" placeholder="Buscar" name="search" required="">
        <div class="input-group-append">
            <a class="btn btn-primary" href="{{ route('drugs.police_units.create') }}"><i class="fas fa-plus"></i> Agregar nuevo</a>
        </div>
    </div>
</fieldset>

<table class="table table-sm" id="TableFilter">
    <thead>
        <tr>
            <th>Id</th>
            <th>Código</th>
            <th>Nombre</th>
            <th>Estado</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        @foreach($policeUnits as $police_unit)
        <tr>
            <td>{{ $police_unit->id }}</td>
            <td>{{ $police_unit->code }}</td>
            <td>{{ $police_unit->name }}</td>
            <td>{{ $police_unit->status }}</td>
            <td>
              <a href="{{ route('drugs.police_units.edit', $police_unit->id) }}" class="btn btn-outline-primary btn-sm"><i class="fas fa-edit"></i> Editar</a>
              <!--<button class="btn btn-danger btn-sm" formaction=""><i class="fas fa-trash"></i> Eliminar</button>-->
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

@endsection

@section('custom_js')

@endsection
