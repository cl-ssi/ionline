@extends('layouts.app')

@section('title', 'Ley N° 18.834')

@section('content')

@include('indicators.partials.nav')

<h3 class="mb-3">Hospital Dr. Ernesto Torres G.
    <small> -
        Cumplimiento : @numero(
        $data14_hosp['aporte'] +
        $data15_hosp['aporte'] +
        $data16_hosp['aporte'] +
        $data17_hosp['aporte'] +
        $data18_hosp['aporte'] +
        $data19_hosp['aporte'] +
        $data20_hosp['aporte'] +
        $data31_hosp['aporte'])%
    </small>
</h3>

<h6 class="mb-3">Metas Sanitarias Ley N° 18.834</h6>


<style>
    .glosa {
        width: 400px;
    }

    .fa-check-circle {
        color: green;
    }
</style>



<hr>



<h5 class="mb-3">{{ $data14_hosp['label']['meta'] }}</h5>

<table class="table table-sm table-bordered small">

    <thead>
        <tr class="text-center">
            <th>Indicador</th>
            <th nowrap>Meta</th>
            <th nowrap>Pond.</th>
            <th nowrap>% Cump</th>
            <th>Acum</th>
            <th>Ene</th>
            <th>Feb</th>
            <th>Mar</th>
            <th>Abr</th>
            <th>May</th>
            <th>Jun</th>
            <th>Jul</th>
            <th>Ago</th>
            <th>Sep</th>
            <th>Oct</th>
            <th>Nov</th>
            <th>Dic</th>
        </tr>
    </thead>

    <tbody>
        <tr>
            <td class="text-left glosa">
                {{ $data14_hosp['label']['numerador'] }}
                <span class="badge badge-secondary">
                    {{ $data14_hosp['label']['fuente']['numerador'] }}
                </span>
            </td>
            <td rowspan="2" class="align-middle text-center">{{ $data14_hosp['meta'] }}</td>
            <td rowspan="2" class="align-middle text-center">
                {{ $data14_hosp['ponderacion'] }}
            </td>
            <td rowspan="2" class="align-middle text-center">
                <span class="{{ ($data14_hosp['cumplimiento'] >= preg_replace("/[^0-9]/", '', $data14_hosp['meta'])) ? 'text-success':'text-danger' }}">
                    {{ number_format($data14_hosp['cumplimiento'], 2, ',', '.') }}%
                </span>
                <small><br>Aporte: @numero($data14_hosp['aporte'])%</small>
            </td>
            <td class="text-right">{{ number_format($data14_hosp['numerador_acumulado'], 0, ',', '.') }}</td>
            @for ($i = 1; $i <= 3; $i++) The current value is {{ $i }} @endfor </tr> <tr>
                <td class="text-left">
                    {{ $data14_hosp['label']['denominador'] }}
                    <span class="badge badge-secondary">
                        {{ $data14_hosp['label']['fuente']['denominador'] }}
                    </span>
                </td>

                <td class="text-right">{{ number_format($data14_hosp['denominador'], 0, ',', '.') }}</td>

                <td class="text-center" colspan="12">{{ number_format($data14_hosp['denominador'], 0, ',', '.') }}</td>
        </tr>
    </tbody>
</table>







<h5 class="mb-3">{{ $data15_hosp['label']['meta'] }}</h5>

<table class="table table-sm table-bordered small">

    <thead>
        <tr class="text-center">
            <th>Indicador</th>
            <th nowrap>Meta</th>
            <th nowrap>Pond.</th>
            <th nowrap>% Cump</th>
            <th>Acum</th>
            <th>Ene</th>
            <th>Feb</th>
            <th>Mar</th>
            <th>Abr</th>
            <th>May</th>
            <th>Jun</th>
            <th>Jul</th>
            <th>Ago</th>
            <th>Sep</th>
            <th>Oct</th>
            <th>Nov</th>
            <th>Dic</th>
        </tr>
    </thead>

    <tbody>
        <tr>
            <td class="text-left glosa">
                {{ $data15_hosp['label']['numerador'] }}
                <span class="badge badge-secondary">
                    {{ $data15_hosp['label']['fuente']['numerador'] }}
                </span>
            </td>
            <td rowspan="2" class="align-middle text-center">{{ $data15_hosp['meta'] }}</td>
            <td rowspan="2" class="align-middle text-center">
                {{ $data15_hosp['ponderacion'] }}
            </td>
            <td rowspan="2" class="align-middle text-center">
                <span class="{{ ($data15_hosp['cumplimiento'] >= preg_replace("/[^0-9]/", '', $data15_hosp['meta'])) ? 'text-success':'text-danger' }}">
                    {{ number_format($data15_hosp['cumplimiento'], 2, ',', '.') }}%
                </span>
                <small><br>Aporte: @numero($data15_hosp['aporte'])%</small>
            </td>
            <td class="text-right">{{ number_format($data15_hosp['numerador_acumulado'], 0, ',', '.') }}</td>
            @foreach($data15_hosp['numeradores'] as $numerador)
            <td class="text-right">{{ number_format($numerador, 0, ',', '.') }}</td>
            @endforeach
        </tr>
        <tr>
            <td class="text-left">
                {{ $data15_hosp['label']['denominador'] }}
                <span class="badge badge-secondary">
                    {{ $data15_hosp['label']['fuente']['denominador'] }}
                </span>
            </td>
            <td class="text-right">{{ number_format($data15_hosp['denominador_acumulado'], 0, ',', '.') }}</td>
            @foreach($data15_hosp['denominadores'] as $denominador)
            <td class="text-right">{{ number_format($denominador, 0, ',', '.') }}</td>
            @endforeach
        </tr>
    </tbody>
</table>






<h5 class="mb-3">{{ $data16_hosp['label']['meta'] }}</h5>

<table class="table table-sm table-bordered small">

    <thead>
        <tr class="text-center">
            <th>Indicador</th>
            <th nowrap>Meta</th>
            <th nowrap>Pond.</th>
            <th nowrap>% Cump</th>
            <th>Acum</th>
            <th>Ene</th>
            <th>Feb</th>
            <th>Mar</th>
            <th>Abr</th>
            <th>May</th>
            <th>Jun</th>
            <th>Jul</th>
            <th>Ago</th>
            <th>Sep</th>
            <th>Oct</th>
            <th>Nov</th>
            <th>Dic</th>
        </tr>
    </thead>

    <tbody>
        <tr>
            <td class="text-left glosa">
                {{ $data16_hosp['label']['numerador'] }}
                <span class="badge badge-secondary">
                    {{ $data16_hosp['label']['fuente']['numerador'] }}
                </span>
            </td>
            <td rowspan="2" class="align-middle text-center">{{ $data16_hosp['meta'] }}</td>
            <td rowspan="2" class="align-middle text-center">
                {{ $data16_hosp['ponderacion'] }}
            </td>
            <td rowspan="2" class="align-middle text-center">
                <span class="{{ ($data16_hosp['cumplimiento'] >= preg_replace("/[^0-9]/", '', $data16_hosp['meta'])) ? 'text-success':'text-danger' }}">
                    {{ number_format($data16_hosp['cumplimiento'], 2, ',', '.') }}%
                </span>
                <small><br>Aporte: @numero($data16_hosp['aporte'])%</small>
            </td>
            <td class="text-right">{{ number_format($data16_hosp['numerador_acumulado'],0, ',', '.') }}</td>
            @foreach($data16_hosp['numeradores'] as $numerador)
            <td class="text-right">{{ number_format($numerador, 0, ',', '.') }}</td>
            @endforeach
        </tr>
        <tr>
            <td class="text-left">
                {{ $data16_hosp['label']['denominador'] }}
                <span class="badge badge-secondary">
                    {{ $data16_hosp['label']['fuente']['denominador'] }}
                </span>
            </td>
            <td class="text-right">{{ number_format($data16_hosp['denominador_acumulado'],0, ',', '.') }}</td>
            @foreach($data16_hosp['denominadores'] as $denominador)
            <td class="text-right">{{ number_format($denominador, 0, ',', '.') }}</td>
            @endforeach
        </tr>
    </tbody>
</table>






<h5 class="mb-3">{{ $data17_hosp['label']['meta'] }}</h5>

<table class="table table-sm table-bordered small">

    <thead>
        <tr class="text-center">
            <th>Indicador</th>
            <th nowrap>Meta</th>
            <th nowrap>Pond.</th>
            <th nowrap>% Cump</th>
            <th>Acum</th>
            <th>Ene</th>
            <th>Feb</th>
            <th>Mar</th>
            <th>Abr</th>
            <th>May</th>
            <th>Jun</th>
            <th>Jul</th>
            <th>Ago</th>
            <th>Sep</th>
            <th>Oct</th>
            <th>Nov</th>
            <th>Dic</th>
        </tr>
    </thead>

    <tbody>
        <tr>
            <td class="text-left glosa">
                {{ $data17_hosp['label']['numerador'] }}
                <span class="badge badge-secondary">
                    {{ $data17_hosp['label']['fuente']['numerador'] }}
                </span>
            </td>
            <td rowspan="2" class="align-middle text-center">{{ $data17_hosp['meta'] }}</td>
            <td rowspan="2" class="align-middle text-center">
                {{ $data17_hosp['ponderacion'] }}
            </td>
            <td rowspan="2" class="align-middle text-center">
                <span class="{{ ($data17_hosp['cumplimiento'] >= preg_replace("/[^0-9]/", '', $data17_hosp['meta'])) ? 'text-success':'text-danger' }}">
                    {{ number_format($data17_hosp['cumplimiento'], 2, ',', '.') }}%
                </span>
                <small><br>Aporte: @numero($data17_hosp['aporte'])%</small>
            </td>
            <td class="text-right">{{ number_format($data17_hosp['numerador_acumulado'],0, ',', '.') }}</td>
            @foreach($data17_hosp['numeradores'] as $numerador)
            <td class="text-right">{{ number_format($numerador, 0, ',', '.') }}</td>
            @endforeach
        </tr>
        <tr>
            <td class="text-left">
                {{ $data17_hosp['label']['denominador'] }}
                <span class="badge badge-secondary">
                    {{ $data17_hosp['label']['fuente']['denominador'] }}
                </span>
            </td>
            <td class="text-right">{{ number_format($data17_hosp['denominador_acumulado'],0, ',', '.') }}</td>
            @foreach($data17_hosp['denominadores'] as $denominador)
            <td class="text-right">{{ number_format($denominador, 0, ',', '.') }}</td>
            @endforeach
        </tr>
    </tbody>
</table>






<h5 class="mb-3">{{ $data18_hosp['label']['meta'] }}</h5>

<table class="table table-sm table-bordered small">

    <thead>
        <tr class="text-center">
            <th>Indicador</th>
            <th nowrap>Meta</th>
            <th nowrap>Pond.</th>
            <th nowrap>% Cump</th>
            <th>Acum</th>
            <th>Ene</th>
            <th>Feb</th>
            <th>Mar</th>
            <th>Abr</th>
            <th>May</th>
            <th>Jun</th>
            <th>Jul</th>
            <th>Ago</th>
            <th>Sep</th>
            <th>Oct</th>
            <th>Nov</th>
            <th>Dic</th>
        </tr>
    </thead>

    <tbody>
        <tr>
            <td class="text-left glosa">
                {{ $data18_hosp['label']['numerador'] }}
                <span class="badge badge-secondary">
                    {{ $data18_hosp['label']['fuente']['numerador'] }}
                </span>
            </td>
            <td rowspan="2" class="align-middle text-center">{{ $data18_hosp['meta'] }}</td>
            <td rowspan="2" class="align-middle text-center">
                {{ $data18_hosp['ponderacion'] }}
            </td>
            <td rowspan="2" class="align-middle text-center">
                <span class="{{ ($data18_hosp['cumplimiento'] >= preg_replace("/[^0-9]/", '', $data18_hosp['meta'])) ? 'text-success':'text-danger' }}">
                    {{ number_format($data18_hosp['cumplimiento'], 2, ',', '.') }}%
                </span>
                <small><br>Aporte: {{ number_format($data18_hosp['aporte'],1, ',', '.') }}%</small>
            </td>
            <td class="text-right">{{ number_format($data18_hosp['numerador_acumulado'],0, ',', '.') }}</td>
            <td colspan="{{ $data18_hosp['vigencia'] }}" class="text-right">
                {{ number_format($data18_hosp['numerador_acumulado'],0, ',', '.') }}
            </td>
        </tr>
        <tr>
            <td class="text-left">
                {{ $data18_hosp['label']['denominador'] }}
                <span class="badge badge-secondary">
                    {{ $data18_hosp['label']['fuente']['denominador'] }}
                </span>
            </td>
            <td class="text-right">{{ number_format($data18_hosp['denominador_acumulado'],0, ',', '.') }}</td>
            <td colspan="12" class="text-center">
                {{ number_format($data18_hosp['denominador_acumulado'],0, ',', '.') }}
            </td>
        </tr>
    </tbody>
</table>







<h5 class="mb-3">{{ $data19_hosp['label']['meta'] }}</h5>

<table class="table table-sm table-bordered small">

    <thead>
        <tr class="text-center">
            <th>Indicador</th>
            <th nowrap>Meta</th>
            <th nowrap>Pond.</th>
            <th nowrap>% Cump</th>
            <th>Acum</th>
            <th>Ene</th>
            <th>Feb</th>
            <th>Mar</th>
            <th>Abr</th>
            <th>May</th>
            <th>Jun</th>
            <th>Jul</th>
            <th>Ago</th>
            <th>Sep</th>
            <th>Oct</th>
            <th>Nov</th>
            <th>Dic</th>
        </tr>
    </thead>

    <tbody>
        <tr>
            <td class="text-left glosa">
                {{ $data19_hosp['label']['numerador'] }}
                <span class="badge badge-secondary">
                    {{ $data19_hosp['label']['fuente']['numerador'] }}
                </span>
            </td>
            <td rowspan="2" class="align-middle text-center">{{ $data19_hosp['meta'] }}</td>
            <td rowspan="2" class="align-middle text-center">
                {{ $data19_hosp['ponderacion'] }}
            </td>
            <td rowspan="2" class="align-middle text-center">
                <span class="{{ ($data19_hosp['cumplimiento'] >= preg_replace("/[^0-9]/", '', $data19_hosp['meta'])) ? 'text-success':'text-danger' }}">
                    @if($data19_hosp['numerador'] <= 5) 100% @endif <small><br>Aporte: @numero($data19_hosp['aporte'])%</small>
            </td>
            <td class="text-center">{{ number_format($data19_hosp['numerador'], 1, ',', '.') }}%</td>
            <td class="text-center" colspan="12">{{ number_format($data19_hosp['numerador'], 1, ',', '.') }}%</td>
        </tr>
        <tr>
            <td class="text-left">
                {{ $data19_hosp['label']['denominador'] }}
                <span class="badge badge-secondary">
                    {{ $data19_hosp['label']['fuente']['denominador'] }}
                </span>
            </td>
            <td class="text-center">{{ $data19_hosp['denominador_acumulado'] }}%</td>
            <td class="text-center" colspan="12">{{ $data19_hosp['denominador_acumulado'] }}%</td>
        </tr>
    </tbody>
</table>






<h5 class="mb-3">{{ $data20_hosp['label']['meta'] }}</h5>

<table class="table table-sm table-bordered small">

    <thead>
        <tr class="text-center">
            <th>Indicador <i class="fas fa-check-circle d-print-none"></i></th>
            <th nowrap>Meta</th>
            <th nowrap>Pond.</th>
            <th nowrap>% Cump</th>
            <th>Acum</th>
            <th>Ene</th>
            <th>Feb</th>
            <th>Mar</th>
            <th>Abr</th>
            <th>May</th>
            <th>Jun</th>
            <th>Jul</th>
            <th>Ago</th>
            <th>Sep</th>
            <th>Oct</th>
            <th>Nov</th>
            <th>Dic</th>
        </tr>
    </thead>

    <tbody>
        <tr>
            <td class="text-left glosa">
                {{ $data20_hosp['label']['numerador'] }}
                <span class="badge badge-secondary">
                    {{ $data20_hosp['label']['fuente']['numerador'] }}
                </span>
            </td>
            <td rowspan="2" class="align-middle text-center">{{ $data20_hosp['meta'] }}</td>
            <td rowspan="2" class="align-middle text-center">
                {{ $data20_hosp['ponderacion'] }}
            </td>
            <td rowspan="2" class="align-middle text-center">
                <span class="{{ ($data20_hosp['cumplimiento'] >= preg_replace("/[^0-9]/", '', $data20_hosp['meta'])) ? 'text-success':'text-danger' }}">
                    {{ number_format($data20_hosp['cumplimiento'], 2, ',', '.') }}%
                </span>
                <small><br>Aporte: @numero($data20_hosp['aporte'])%</small>
            </td>
            <td class="text-center">{{ $data20_hosp['numerador_acumulado'] }}</td>
            @foreach($data20_hosp['numeradores'] as $numerador)
            <td class="text-right">{{ number_format($numerador, 0, ',', '.') }}</td>
            @endforeach
        </tr>
        <tr>
            <td class="text-left">
                {{ $data20_hosp['label']['denominador'] }}
                <span class="badge badge-secondary">
                    {{ $data20_hosp['label']['fuente']['denominador'] }}
                </span>
            </td>
            <td class="text-center">{{ $data20_hosp['denominador_acumulado'] }}</td>
            @foreach($data20_hosp['denominadores'] as $denominador)
            <td class="text-right">{{ number_format($denominador, 0, ',', '.') }}</td>
            @endforeach
        </tr>
    </tbody>
</table>





<h5 class="mb-3">{{ $data31_hosp['label']['meta'] }}</h5>

<table class="table table-sm table-bordered small">

    <thead>
        <tr class="text-center">
            <th>Indicador</th>
            <th nowrap>Meta</th>
            <th nowrap>Pond.</th>
            <th nowrap>% Cump</th>
            <th>Acum</th>
            <th>Ene</th>
            <th>Feb</th>
            <th>Mar</th>
            <th>Abr</th>
            <th>May</th>
            <th>Jun</th>
            <th>Jul</th>
            <th>Ago</th>
            <th>Sep</th>
            <th>Oct</th>
            <th>Nov</th>
            <th>Dic</th>
        </tr>
    </thead>

    <tbody>
        <tr>
            <td class="text-left glosa">
                {{ $data31_hosp['label']['numerador'] }}
                <span class="badge badge-secondary">
                    {{ $data31_hosp['label']['fuente']['numerador'] }}
                </span>
            </td>
            <td rowspan="2" class="align-middle text-center">{{ $data31_hosp['meta'] }}</td>
            <td rowspan="2" class="align-middle text-center">
                {{ $data31_hosp['ponderacion'] }}
            </td>
            <td rowspan="2" class="align-middle text-center">
                <span class="{{ ($data31_hosp['cumplimiento'] >= preg_replace("/[^0-9]/", '', $data31_hosp['meta'])) ? 'text-success':'text-danger' }}">
                    {{ number_format($data31_hosp['cumplimiento'], 2, ',', '.') }}%
                </span>
                <small><br>Aporte: @numero($data31_hosp['aporte'])%</small>
            </td>
            <td class="text-right">{{ number_format($data31_hosp['numerador_acumulado'],0, ',', '.') }}</td>
            <td class="text-right" colspan="{{ $data31_hosp['vigencia'] }}">{{ number_format($data31_hosp['numerador_acumulado'],0, ',', '.') }}</td>
        </tr>
        <tr>
            <td class="text-left">
                {{ $data31_hosp['label']['denominador'] }}
                <span class="badge badge-secondary">
                    {{ $data31_hosp['label']['fuente']['denominador'] }}
                </span>
            </td>
            <td class="text-right">{{ number_format($data31_hosp['denominador_acumulado'],0, ',', '.') }}</td>
            <td class="text-right" colspan="12">{{ number_format($data31_hosp['denominador_acumulado'],0, ',', '.') }}</td>
        </tr>
    </tbody>
</table>

@endsection

@section('custom_js')

@endsection