@extends('layouts.app')

@section('title', 'Reporte de vacunados')

@section('content')
<h3 class="mb-3">Reporte de vacunados</h3>

<table class="table table-sm">
    <tr>
        <th>Total de funcionarios registrados</th>
        <td>{{ $report['total'] }}</td>
        <td>100%</td>
    </tr>
    <tr>
        <th>Informado a través de clave única</th>
        <td>{{ $report['informed'] }}</td>
        <td>{{ $report['informed_per'] }}</td>
    </tr>
    <tr>
        <th>No informado a través de clave única</th>
        <td>{{ $report['not_informed'] }}</td>
        <td>{{ $report['not_informed_per'] }}</td>
    </tr>
    <tr>
        <th>Vacunados Primera Dósis</th>
        <td>{{ $report['fd_vaccined'] }}</td>
        <td>{{ $report['fd_vaccined_per'] }}</td>
    </tr>
    <tr>
        <th>No Vacunados Primera Dósis</th>
        <td>{{ $report['fd_not_vaccined'] }}</td>
        <td>{{ $report['fd_not_vaccined_per'] }}</td>
    </tr>
</table>

@endsection

@section('custom_js')

@endsection
