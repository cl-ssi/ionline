@extends('layouts.app')

@section('title', 'Reporte de documentos')

@section('content')

@include('documents.partials.nav')

<h3 class="mb-3">Reporte de documentos</h3>

<h4>Documentos creados: <strong>{{ $ct }}</strong></h4>

<table class="table table-sm">
    <thead>
        <tr>
            <th>Usuario</th>
            <th class="text-center">Creados</th>
            <th class="text-center">Cerrados</th>
            <th class="text-center">Pendientes</th>
        </tr>
    </thead>
    @foreach($users as $user)
    <tbody>
        <tr>
            <td>{{ $user->fullName }}</td>
            <td class="text-center">{{ $user->documents->count() }}</td>
            <td class="text-center">{{ $user->documents->where('file', '<>', '')->count() }}</td>
            <td class="text-center">{{ $user->documents->where('file', 'IS NULL', null)->count() }}</td>
        </tr>
    </tbody>
    @endforeach
</table>

<table class="table table-sm">
    <thead>
        <tr>
            <th>Unidad Organizacional</th>
            <th class="text-center">Creados</th>
            <th class="text-center">Cerrados</th>
            <th class="text-center">Pendientes</th>
        </tr>
    </thead>
    @foreach($ous as $ou)
    <tbody>
        <tr>
            <td>{{ $ou->name }}</td>
            <td class="text-center">{{ $ou->documents->count() }}</td>
            <td class="text-center">{{ $ou->documents->where('file', '<>', '')->count() }}</td>
            <td class="text-center">{{ $ou->documents->where('file', 'IS NULL', null)->count() }}</td>
        </tr>
    </tbody>
    @endforeach
</table>

@endsection

@section('custom_js')

@endsection
