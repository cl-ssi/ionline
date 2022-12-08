@extends('layouts.app')

@section('content')
@canany(['be god','Rem: admin','Rem: user'])
@include('rem.nav')
@endcan


<div style="margin-bottom: 10px;" class="row">
    <div class="col-lg-12">
        <a class="btn btn-success" href="{{ route('rem.periods.create') }}">
            Agregar Periodo Rem
        </a>
    </div>
</div>

<hr>
<h3 class="mb-3">Listado de Periodos para cargas REM</h3>

<table class="table table-sm table-bordered">
    <thead>
        <tr>
            <th>Periodo</th>
            <th>Año</th>
            <th>Mes</th>
        </tr>
    </thead>

    <tbody>
        @foreach($periods as $period)
        <tr>
            <td>{{ $period->period }}</td>
            <td>{{ $period->year }}</td>
            <td>{{ $period->month }}</td>
        </tr>
        @endforeach
    </tbody>
    
</table>

@endsection

@section('custom_js')

@endsection