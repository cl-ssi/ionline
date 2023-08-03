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
                <td>Cuenta Día Trabajados</td>
            </tr>
        </thead>

        @foreach ($absenteeismTypes as $absenteeismtype)
            <tr>
                <td>{{ $absenteeismtype->name }}</td>
                <td>
                    <input type="checkbox" name="discount" value="1"
                        {{ $absenteeismtype->discount == 1 ? 'checked' : '' }}>
                </td>
                <td>
                    <input type="checkbox" name="half_day" value="1"
                        {{ $absenteeismtype->half_day == 1 ? 'checked' : '' }}>
                </td>
                <td>
                    <input type="checkbox" name="count_business_days" value="1"
                        {{ $absenteeismtype->count_business_days == 1 ? 'checked' : '' }}>
                </td>
            </tr>
        @endforeach
    </table>


@endsection
