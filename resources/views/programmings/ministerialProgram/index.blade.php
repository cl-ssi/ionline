@extends('layouts.app')

@section('title', 'Lista de Profesionales')

@section('content')

@include('programmings/nav')

<h3 class="mb-3"> Profesionales</h3>

<table class="table table-sm table-hover">
    <thead>
        <tr class="small">
            <th>ID</th>
            <th>NOMBRE</th>
            <th>ALIAS</th>
        </tr>
    </thead>
    <tbody>
        @foreach($ministerialPrograms as $ministerialprogram)
        <tr class="small">
            <td>{{ $ministerialprogram->id }}</td>
            <td>{{ $ministerialprogram->name }}</td>
            <td>{{ $ministerialprogram->alias }}</td>
            <td></td>
        </tr>
        @endforeach
    </tbody>
</table>

@endsection
