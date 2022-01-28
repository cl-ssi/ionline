@extends('layouts.app')

@section('title', 'Juzgados')

@section('content')

@include('drugs.nav')

<h3 class="mb-3">Juzgados</h3>

<fieldset class="form-group">
    <div class="input-group">
        <div class="input-group-prepend">
          <span class="input-group-text" id="basic-addon1"><i class="fas fa-search"></i></span>
        </div>
        <input type="text" class="form-control" id="forsearch" onkeyup="filter(1)" placeholder="Buscar" name="search" required="">
        <div class="input-group-append">
            <a class="btn btn-primary" href="{{ route('drugs.courts.create') }}"><i class="fas fa-plus"></i> Agregar nuevo</a>
        </div>
    </div>
</fieldset>

<form method="POST">
  <table class="table table-sm" id="TableFilter">
  {{ method_field('DELETE') }} {{ csrf_field() }}
    <thead>
        <tr>
            <th>Id</th>
            <th>Nombre</th>
            <th>Dirección</th>
            <th>Comuna</th>
            <th>Estado</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        @foreach($courts as $court)
        <tr>
            <td>{{ $court->id }}</td>
            <td>{{ $court->name }}</td>
            <td>{{ $court->address }}</td>
            <td>{{ $court->commune }}</td>
            <td>{{ $court->status }}</td>
            <td>
              <a href="{{ route('drugs.courts.edit', $court->id) }}" class="btn btn-outline-primary btn-sm"><i class="fas fa-edit"></i> Editar</a>
              <!--<button class="btn btn-danger btn-sm" formaction=""><i class="fas fa-trash"></i> Eliminar</button>-->
            </td>
        </tr>
        @endforeach
    </tbody>
  </table>
<form method="POST">

@endsection

@section('custom_js')

@endsection
