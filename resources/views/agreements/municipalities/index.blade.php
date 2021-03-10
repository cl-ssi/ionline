@extends('layouts.app')

@section('title', 'Lista de Municipios')

@section('content')

@include('agreements/nav')

<h3 class="mb-3">Municipios</h3>

<table class="table table-sm table-hover">
    <thead>
        <tr class="small">
            <th>Nombre</th>
            <th>RUT</th>
            <th>Dirección</th>
            <th>Comuna</th>
            <th>Alcalde</th>
            <th>Alcalde subrogante</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        @foreach($municipalities as $municipality)
        <tr class="small">
            <td>{{ $municipality->name_municipality }}</td>
            <td>{{ $municipality->rut_municipality }}</td>
            <td>{{ $municipality->adress_municipality }}</td>
            <td>{{ $municipality->commune->name }}</td>
            <td>{{$municipality->name_representative}}</td>
            <td>{{$municipality->name_representative_surrogate}}</td>
            <td><a href="{{route('agreements.municipalities.edit', $municipality)}}"><span class="fa fa-edit"></span></a></td>
        </tr>
        @endforeach
    </tbody>
</table>

@endsection
