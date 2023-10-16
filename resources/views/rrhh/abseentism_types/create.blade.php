@extends('layouts.bt4.app')
@section('title', 'Crear Tipos de Ausencia')
@section('content')

    <h3 class="mb-3">Agregar Tipos de Ausentismo</h3> <small></small>

    <table class="table table-sm table-bordered">
        <thead>
            <tr>
                <td>Nombre</td>
                <td>Agregar</td>
            </tr>
        </thead>
        @foreach ($typesnotstore as $type)
            <tr>
                <td>{{ $type }}</td>
                <td>
                    <form action="{{ route('rrhh.absence-types.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="tipo_de_ausentismo" value="{{ $type }}">
                        <button type="submit" class="btn btn-primary">Agregar</button>
                    </form>
                </td>
            </tr>
        @endforeach

    </table>

@endsection
