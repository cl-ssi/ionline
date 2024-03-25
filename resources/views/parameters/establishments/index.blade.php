@extends('layouts.bt5.app')

@section('title', 'Establecimientos')

@section('content')

<h3 class="mb-3">Establecimientos</h3>

<a class="btn btn-primary mb-3" href="{{ route('parameters.establishments.create') }}">Crear</a>
<table class="table table-bordered table-sm">
    <thead>
        <tr>
            <th>Id</th>
            <th>Nombre Oficial</th>
            <th>Alias</th>
            <!-- <th>Tipo</th> -->
            <th>Deis</th>
            <th>Deis Nuevo</th>
            <th>Comuna</th>
            <th>Dependencia Jerarquica</th>
            <th>Dependencia Administrativa</th>
            <!-- <th>Nivel de Atención</th> -->
            <th>Dirección</th>
            <th>Fono</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        @foreach($establishments as $establishment)
        <tr>
            <td>{{ $establishment->id?? '' }}</td>
            <td>{{ $establishment->official_name?? '' }}</td>
            <td>{{ $establishment->alias?? '' }}</td>
            <!-- <td>{{ $establishment->establishmentType->name?? '' }}</td> -->
            <td>{{ $establishment->deis?? '' }}</td>
            <td>{{ $establishment->new_deis?? '' }}</td>
            <td>{{ $establishment->commune->name?? '' }}</td>
            <td>{{ $establishment->dependency?? '' }}</td>
            <td>{{ $establishment->administrative_dependency?? '' }}</td>
            <!-- <td>{{ $establishment->level_of_care?? '' }}</td> -->
            <td>{{ $establishment->full_address ?? ''}} </td>
            <td>{{ $establishment->telephone??''}} </td>
            <td>
                <a href="{{ route('parameters.establishments.edit', $establishment) }}">
                    <i class="fas fa-edit"></i>
                </a>
            </td>
        </tr>
        @endforeach
    </tbody>

</table>

@endsection