@extends('layouts.app')

@section('title', 'Sustancias')

@section('content')

@include('drugs.nav')

<h3 class="mb-3">Sustancias</h3>

<fieldset class="form-group">
    <div class="input-group">
        <div class="input-group-prepend">
          <span class="input-group-text" id="basic-addon1"><i class="fas fa-search"></i></span>
        </div>
        <input type="text" class="form-control" id="forsearch" onkeyup="filter(1)" placeholder="Buscar" name="search" required="">
        <div class="input-group-append">
            <a class="btn btn-primary" href="{{ route('drugs.substances.create') }}"><i class="fas fa-plus"></i> Agregar nuevo</a>
        </div>
    </div>
</fieldset>

<form method="POST">
  {{ method_field('DELETE') }} {{ csrf_field() }}
  <table class="table table-sm" id="TableFilter">
    <thead>
        <tr>
            <th>Id</th>
            <th>Nombre</th>
            <th>Rama</th>
            <th>Unidad</th>
            <th>Laboratorio</th>

            <th>Presunta</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        @foreach($substances as $substance)
        <tr>
            <td>{{ $substance->id }}</td>
            <td>{{ $substance->name }}</td>
            <td>{{ $substance->rama }}</td>
            <td>{{ $substance->unit }}</td>
            <td>{{ $substance->laboratory }}</td>

            <td>{{ $substance->presumed == 1 ? "Si" : "No" }}</td>
            <td>
              <a href="{{ route('drugs.substances.edit', $substance->id) }}" class="btn btn-outline-primary btn-sm"><i class="fas fa-edit"></i> Editar</a>
              <!--<button class="btn btn-danger btn-sm" formaction=""><i class="fas fa-trash"></i> Eliminar</button>-->
            </td>
        </tr>
        @endforeach
    </tbody>
  </table>
</form>

@endsection

@section('custom_js')

@endsection
