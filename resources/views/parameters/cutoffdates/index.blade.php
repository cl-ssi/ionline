@extends('layouts.bt4.app')

@section('title', 'Fechas de corte (COMGES)')

@section('content')

<h3 class="mb-3">Mantenedor de fechas de corte (COMGES)
<form class="form-inline float-right" method="GET" action="{{ route('parameters.cutoffdates.index') }}">
    <select name="year" class="form-control" onchange="this.form.submit()">
                    @foreach(range(2020, date('Y')) as $anio)
                        <option value="{{ $anio }}" {{ request()->year == $anio || $year == $anio ? 'selected' : '' }}>{{ $anio }}</option>
                    @endforeach
    </select>
</form>
</h3>

<a class="btn btn-primary mb-3" href="{{ route('parameters.cutoffdates.create', ['year' => request()->year ?? $year]) }}">
    Crear
</a>

<div class="table-responsive">
    <table class="table table-bordered table-sm small">
        <thead>
            <tr>
                <th>Año</th>
                <th>N° corte</th>
                <th>Fecha</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @forelse($cut_off_dates as $key => $cut_off_date)
            <tr>
                <td>{{ $cut_off_date->year }}</td>
                <td>{{ $cut_off_date->number }}</td>
                <td>{{ $cut_off_date->date->format('d-m-Y') }}</td>
                <td>
                    <a href="{{ route('parameters.cutoffdates.edit', $cut_off_date) }}">
                      <i class="fas fa-edit"></i>
                    </a>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="4" class="text-center">No existen registros</td>
            </tr>
            @endforelse
        </tbody>
    </table>
<div>


@endsection

@section('custom_js')

@endsection
