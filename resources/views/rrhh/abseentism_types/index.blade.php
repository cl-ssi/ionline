@extends('layouts.app')
@section('title', 'Tipos de Ausencia')
@section('content')

    <h3 class="mb-3">Tipos de Ausentismo</h3>

    <a class="btn btn-primary mb-3" href="{{ route('rrhh.absence-types.create') }}">Agregar Tipo de Ausentismo</a>

    <table class="table table-sm table-bordered">
        <thead>
            <tr>
                <td>Nombre</td>
                <td>Descuento</td>
                <td>Medio Día</td>
            </tr>
        </thead>

        @foreach ($absenteeismTypes as $absenteeismtype)
            <tr>
                <td>{{ $absenteeismtype->name }}</td>
                <td></td>
                <td></td>
            </tr>
        @endforeach
    </table>


@endsection
