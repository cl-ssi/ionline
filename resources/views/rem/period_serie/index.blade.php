@extends('layouts.bt4.app')

@section('content')
@include('rem.nav')
<div style="margin-bottom: 10px;" class="row">
    <div class="col-lg-12">
        <a class="btn btn-success" href="{{ route('rem.periods_series.create') }}">
            Agregar REM a Periodo
        </a>
    </div>
</div>

<hr>
<h3 class="mb-3">Listado de Periodos Con los REM que les corresponde</h3>

<table class="table table-sm table-bordered">
    <thead>
        <tr>
            <th>Periodo</th>
            <th>Serie</th>
            <th>Tipo de Establecimiento</th>
        </tr>
    </thead>

    @forelse($remPeriodSeries as $remPeriodSerie)
    <tr>
        <td>{{ $remPeriodSerie->period->year ?? 'sin año'  }}-{{ $remPeriodSerie->period->month ?? 'sin mes'  }}</td>
        <td>{{ $remPeriodSerie->serie->name ?? 'sin nombre' }}</td>
        <td>{{ $remPeriodSerie->type ?? 'sin tipo' }}</td>
    </tr>

    @empty
    <tr>
        <td colspan="3" align="center">No hay Series Asociadas a Periodos</td>
    </tr>

    @endforelse

</table>



@endsection

@section('custom_js')

@endsection