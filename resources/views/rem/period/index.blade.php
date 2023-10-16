@extends('layouts.bt4.app')

@section('content')
@include('rem.nav')


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
            <th>Eliminar</th>
        </tr>
    </thead>

    <tbody>
        @foreach($periods as $period)
        <tr>
            <td>{{ $period->period->format('Y-m') }}</td>
            <td>{{ $period->year }}</td>
            <td>{{ $period->month }}</td>
            <td>
                <form method="POST" class="form-horizontal" action="{{ route('rem.periods.destroy', $period) }}">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger float-left" onclick="return confirm('¿Está seguro que desea eliminar el periodo ?' )"><i class="fas fa-trash-alt"></i></button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>

</table>

@endsection

@section('custom_js')

@endsection