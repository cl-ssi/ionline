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
        <td colspan="2">&nbsp;</td>
    </tr>

    <tr>
        <th>Informados a través de clave única</th>
        <td class="text-right">{{ $report['informed_cu'] }}</td>
        <td class="text-right">{{ $report['informed_cu_per'] }}</td>
    </tr>
    <tr>
        <th>Informados a través de teléfono (OIRS)</th>
        <td class="text-right">{{ $report['informed_tp'] }}</td>
        <td class="text-right">{{ $report['informed_tp_per'] }}</td>
    </tr>
    <tr>
        <th>Informados a través de email (OIRS)</th>
        <td class="text-right">{{ $report['informed_em'] }}</td>
        <td class="text-right">{{ $report['informed_em_per'] }}</td>
    </tr>
    <tr>
        <th>No se han informado por niguno de los anteriores</th>
        <td class="text-right">{{ $report['not_informed'] }}</td>
        <td class="text-right">{{ $report['not_informed_per'] }}</td>
    </tr>

    <tr>
        <td colspan="2">&nbsp;</td>
    </tr>

    <tr>
        <th>Auto Agendados Primera Dósis (>22-02-2021)</th>
        <td class="text-right">{{ $report['fd_booking'] }}</td>
        <td class="text-right">{{ $report['fd_booking_per'] }}</td>
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
        <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
        <th>Auto Agendados Segunda Dósis</th>
        <td class="text-right">{{ $report['sd_booking'] }}</td>
        <td class="text-right">{{ $report['sd_booking_per'] }}</td>
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
