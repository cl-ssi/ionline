@extends('layouts.app')

@section('title', 'Reporte de vacunados')

@section('content')

@include('vaccination.partials.nav')

<h3 class="mb-3">Reporte de vacunados</h3>

<table class="table table-sm table-bordered">
    <tr>
        <th>Total de funcionarios a vacunar</th>
        <td class="text-right">{{ $report['total'] }}</td>
        <td class="text-right"></td>
    </tr>
    <tr>
        <th>Informados a través de clave única</th>
        <td class="text-right">{{ $report['informed'] }}</td>
        <td class="text-right">{{ $report['informed_per'] }}</td>
    </tr>
    <tr>
        <th>No informados a través de clave única</th>
        <td class="text-right">{{ $report['not_informed'] }}</td>
        <td class="text-right">{{ $report['not_informed_per'] }}</td>
    </tr>
    <tr>
        <th>Vacunados Primera Dósis</th>
        <td class="text-right">{{ $report['fd_vaccined'] }}</td>
        <td class="text-right">{{ $report['fd_vaccined_per'] }}</td>
    </tr>
    <tr>
        <th>No Vacunados Primera Dósis</th>
        <td class="text-right">{{ $report['fd_not_vaccined'] }}</td>
        <td class="text-right">{{ $report['fd_not_vaccined_per'] }}</td>
    </tr>
    <tr>
        <th>Vacunados Segunda Dósis</th>
        <td class="text-right">{{ $report['sd_vaccined'] }}</td>
        <td class="text-right">{{ $report['sd_vaccined_per'] }}</td>
    </tr>
    <tr>
        <th>No Vacunados Segunda Dósis</th>
        <td class="text-right">{{ $report['sd_not_vaccined'] }}</td>
        <td class="text-right">{{ $report['sd_not_vaccined_per'] }}</td>
    </tr>
</table>

@endsection

@section('custom_js')

@endsection
