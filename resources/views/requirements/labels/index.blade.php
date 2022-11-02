@extends('layouts.app')

@section('title', 'Etiquetas')

@section('content')

@include('requirements.partials.nav')

<div class="row">
    <div class="col">
        <h3 class="mb-3">Etiquetas</h3>
    </div>
    <div class="col text-right">
        <a class="btn btn-primary mb-3" href="{{ route('requirements.labels.create') }}">
            Crear
        </a>
    </div>
</div>

<table class="table">
    <thead>
        <tr>
            <th class="text-center">ID</th>
            <th>Nombre</th>
            <th>Unidad Organizacional</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        @foreach($labels as $label)
        <tr>
            <td class="text-center">{{ $label->id }}</td>
            <td>{{ $label->name }}</td>
            <td>{{ $label->organizationalUnit->name }}</td>
            <td>
                <a href="{{ route('requirements.labels.edit', $label) }}">
                    <i class="fas fa-edit"></i>
                </a>
                
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

@endsection

@section('custom_js')

@endsection
