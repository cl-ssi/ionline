@extends('layouts.app')

@section('content')
<hr>
<h3 class="mb-3">Listado de Periodos Con los REM que les corresponde</h3>

<table class="table table-sm table-bordered">
    <thead>
        <tr>
            <th>Periodo</th>
            <th>Serie</th>
        </tr>
    </thead>

    @forelse($remPeriodSeries as $remPeriodSerie)
    <tr>
        <td>{{ $remPeriodSerie->period->year ?? 'sin año'  }}-{{ $remPeriodSerie->period->month ?? 'sin mes'  }}</td>
        <td>{{ $remPeriodSerie->serie->name ?? 'sin nombre' }}</td>
    </tr>

    @empty
    <tr>
        <td colspan="2" align="center">No hay Series Asociadas a Periodos</td>
    </tr>

    @endforelse

</table>



@endsection

@section('custom_js')

@endsection