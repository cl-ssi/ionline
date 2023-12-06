@extends('layouts.bt4.app')
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
                <td>Sobre</td>
                <td>Desde</td>
            </tr>
        </thead>

        @foreach ($absenteeismTypes as $absenteeismType)
            <tr>
                <td>{{ $absenteeismType->name }}</td>
                <form action="{{ route('rrhh.absence-types.update', $absenteeismType->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="absenteeismType" value="{{ $absenteeismType->id }}">
                    <td>
                        <input type="checkbox" name="discount" value="1"
                            {{ $absenteeismType->discount == 1 ? 'checked' : '' }}>
                    </td>
                    <td>
                        <input type="checkbox" name="half_day" value="1"
                            {{ $absenteeismType->half_day == 1 ? 'checked' : '' }}>
                    </td>
                    <td>
                        <input type="checkbox" name="count_business_days" value="1"
                            {{ $absenteeismType->count_business_days == 1 ? 'checked' : '' }}>
                    </td>
                    <td>
                        <input type="text" name="over" value="{{ $absenteeismType->over}}">
                    </td>
                    <td>
                        <input type="text" name="from" value="{{ $absenteeismType->from}}">
                    </td>
                    <td>
                        <button type="submit" class="btn btn-primary">Actualizar</button>
                    </td>
                </form>
            </tr>
        @endforeach
    </table>



    </form>

@endsection
