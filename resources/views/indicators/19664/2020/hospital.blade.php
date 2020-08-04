@extends('layouts.app')

@section('title', 'Ley 19664')

@section('content')

@include('indicators.partials.nav')

<h3 class="mb-3">Hospital Dr. Ernesto Torres G.
    <small>
        - Cumplimiento : {{ number_format($data4_hosp['aporte'] +
                                          $data5_hosp['aporte'] +
                                          $data6_hosp['aporte'] +
                                          $data7_hosp['aporte'] +
                                          $data8_hosp['aporte'] +
                                          $data9_hosp['aporte'] +
                                          $data10_hosp['aporte'] +
                                          $data11_hosp['aporte'] +
                                          $data12_hosp['aporte'], 2, ',', '.') }}%
    </small>
</h3>
<h6 class="mb-3">Metas Sanitarias Ley N° 19.664</h6>

<style media="screen">
    .label {
        width: 40%;
    }
</style>

<hr>

<h5 class="mb-3">{{ $data4_hosp['label']['meta'] }}</h5>

<table class="table table-sm table-bordered small mb-4">

    <thead>
        <tr class="text-center">
            <th>Indicador</th>
            <th nowrap>Meta</th>
            <th nowrap>Pond</th>
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
        <tr class="text-center">
            <td class="text-left glosa">
              {{ $data4_hosp['label']['numerador'] }}
              <span class="badge badge-secondary">
                  {{ $data4_hosp['label']['fuente']['numerador'] }}
              </span>
            </td>
            <td rowspan="2" class="align-middle">{{ $data4_hosp['meta'] }}</td>
            <td rowspan="2" class="align-middle">{{ $data4_hosp['ponderacion'] }}%</td>
            <td rowspan="2" class="align-middle">
              <span class="{{ ($data4_hosp['cumplimiento'] <= preg_replace("/[^0-9]/", '', $data4_hosp['meta'])) ? 'text-success':'text-danger' }}">
                  {{ number_format($data4_hosp['cumplimiento'], 2, ',', '.') }}%
              </span>
              <small><br>Aporte: {{ number_format($data4_hosp['aporte'], 2, ',', '.') }}%</small>
            </td>
            <td class="text-rigth">{{ number_format($data4_hosp['numerador_acumulado'], 0, ',', '.') }}</td>
            @foreach($data4_hosp['numeradores'] as $numerador)
                <td>{{ number_format($numerador, 0, ',', '.') }}</td>
            @endforeach
        </tr>
        <tr class="text-center">
            <td class="text-left">
              {{ $data4_hosp['label']['denominador'] }}
              <span class="badge badge-secondary">
                  {{ $data4_hosp['label']['fuente']['denominador'] }}
              </span>
            </td>
            <td class="text-rigth">{{ number_format($data4_hosp['denominador_acumulado'], 0, ',', '.') }}</td>
            @foreach($data4_hosp['denominadores'] as $denominadores)
                <td>{{ number_format($denominadores, 0, ',', '.') }}</td>
            @endforeach
        </tr>
    </tbody>
</table>

<h5 class="mb-3">{{ $data5_hosp['label']['meta'] }}</h5>

<table class="table table-sm table-bordered small mb-4">

    <thead>
        <tr class="text-center">
            <th>Indicador</th>
            <th nowrap>Meta</th>
            <th nowrap>Pond</th>
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
        <tr class="text-center">
            <td class="text-left glosa">
              {{ $data5_hosp['label']['numerador'] }}
              <span class="badge badge-secondary">
                  {{ $data5_hosp['label']['fuente']['numerador'] }}
              </span>
            </td>
            <td rowspan="2" class="align-middle">{{ $data5_hosp['meta'] }}</td>
            <td rowspan="2" class="align-middle">{{ $data5_hosp['ponderacion'] }}%</td>
            <td rowspan="2" class="align-middle">
              <span class="{{ ($data5_hosp['cumplimiento'] >= preg_replace("/[^0-9]/", '', $data5_hosp['meta'])) ? 'text-success':'text-danger' }}">
                  {{ number_format($data5_hosp['cumplimiento'], 2, ',', '.') }}%
              </span>
              <small><br>Aporte: {{ number_format($data5_hosp['aporte'], 2, ',', '.') }}%</small>
            </td>
            <td class="text-rigth">{{ number_format($data5_hosp['numerador_acumulado'], 0, ',', '.') }}</td>
            @foreach($data5_hosp['numeradores'] as $numerador)
              @if($numerador != NULL)
                <td>{{ number_format($numerador, 0, ',', '.') }}</td>
              @else
                <td></td>
              @endif
            @endforeach
        </tr>
        <tr class="text-center">
            <td class="text-left">
              {{ $data5_hosp['label']['denominador'] }}
              <span class="badge badge-secondary">
                  {{ $data5_hosp['label']['fuente']['denominador'] }}
              </span>
            </td>
            <td class="text-rigth">{{ number_format($data5_hosp['denominador_acumulado'], 0, ',', '.') }}</td>
            @foreach($data5_hosp['denominadores'] as $denominadores)
              @if($denominadores != NULL)
                <td>{{ number_format($denominadores, 0, ',', '.') }}</td>
              @else
                <td></td>
              @endif
            @endforeach
        </tr>
    </tbody>
</table>

<h5 class="mb-3">{{ $data6_hosp['label']['meta'] }}</h5>

<table class="table table-sm table-bordered small mb-4">

    <thead>
        <tr class="text-center">
            <th>Indicador</th>
            <th nowrap>Meta</th>
            <th nowrap>Pond</th>
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
        <tr class="text-center">
            <td class="text-left glosa">
              {{ $data6_hosp['label']['numerador'] }}
              <span class="badge badge-secondary">
                  {{ $data6_hosp['label']['fuente']['numerador'] }}
              </span>
            </td>
            <td rowspan="2" class="align-middle">disminución {{ $data6_hosp['meta'] }}% respecto de línea base.
                <small><br>línea base: {{ $data6_hosp['meta_nacional'] }}%</small>
            </td>
            <td rowspan="2" class="align-middle">{{ $data6_hosp['ponderacion'] }}%</td>
            <td rowspan="2" class="align-middle">
              @if($data6_hosp['cumplimiento'] <= ($data6_hosp['meta_nacional']-5) AND $data6_hosp['cumplimiento'] != 0)
                100%
                <small><br>{{ $data6_hosp['cumplimiento'] }}%</small>
              @else
                0%
                <small><br>{{ $data6_hosp['cumplimiento'] }}%</small>
              @endif
            </td>
            <td class="text-rigth">{{ $data6_hosp['numerador_acumulado'] }}</td>
            <td class="text-right" colspan="{{ $data6_hosp['vigencia'] }}">{{ number_format($data6_hosp['numerador_acumulado'],0, ',', '.') }}</td>
        </tr>
        <tr class="text-center">
            <td class="text-left">
              {{ $data6_hosp['label']['denominador'] }}
              <span class="badge badge-secondary">
                  {{ $data6_hosp['label']['fuente']['denominador'] }}
              </span>
            </td>
            <td class="text-rigth">{{ $data6_hosp['denominador_acumulado'] }}</td>
            <td colspan="12" class="text-center">{{ $data6_hosp['denominador_acumulado'] }} </td>
        </tr>
    </tbody>
</table>

<h5 class="mb-3">{{ $data7_hosp['label']['meta'] }}</h5>

<table class="table table-sm table-bordered small mb-4">

    <thead>
        <tr class="text-center">
            <th>Indicador</th>
            <th nowrap>Meta</th>
            <th nowrap>Pond</th>
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
        <tr class="text-center">
            <td class="text-left glosa">
              {{ $data7_hosp['label']['numerador'] }}
              <span class="badge badge-secondary">
                  {{ $data7_hosp['label']['fuente']['numerador'] }}
              </span>
            </td>
            <td rowspan="2" class="align-middle">{{ $data7_hosp['meta'] }}%</td>
            <td rowspan="2" class="align-middle">{{ $data7_hosp['ponderacion'] }}%</td>
            <td rowspan="2" class="align-middle">
              <span class="{{ ($data7_hosp['cumplimiento'] >= preg_replace("/[^0-9]/", '', $data7_hosp['meta'])) ? 'text-success':'text-danger' }}">
                  {{ number_format($data7_hosp['cumplimiento'], 2, ',', '.') }}%
              </span>
              <small><br>Aporte: {{ number_format($data7_hosp['aporte'], 2, ',', '.') }}%</small>
            </td>
            <td class="text-rigth">{{ number_format($data7_hosp['numerador_acumulado'], 0, ',', '.') }}</td>
            @foreach($data7_hosp['numeradores'] as $numerador)
              @if($numerador != NULL)
                <td>{{ number_format($numerador, 0, ',', '.') }}</td>
              @else
                <td></td>
              @endif
            @endforeach
        </tr>
        <tr class="text-center">
            <td class="text-left">
              {{ $data7_hosp['label']['denominador'] }}
              <span class="badge badge-secondary">
                  {{ $data7_hosp['label']['fuente']['denominador'] }}
              </span>
            </td>
            <td class="text-rigth">{{ number_format($data7_hosp['denominador_acumulado'], 0, ',', '.') }}</td>
            @foreach($data7_hosp['denominadores'] as $denominadores)
              @if($denominadores != NULL)
                <td>{{ number_format($denominadores, 0, ',', '.') }}</td>
              @else
                <td></td>
              @endif
            @endforeach
        </tr>
    </tbody>
</table>

<h5 class="mb-3">{{ $data8_hosp['label']['meta'] }}</h5>

<table class="table table-sm table-bordered small mb-4">

    <thead>
        <tr class="text-center">
            <th>Indicador</th>
            <th nowrap>Meta</th>
            <th nowrap>Pond</th>
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
        <tr class="text-center">
            <td class="text-left glosa">
              {{ $data8_hosp['label']['numerador'] }}
              <span class="badge badge-secondary">
                  {{ $data8_hosp['label']['fuente']['numerador'] }}
              </span>
            </td>
            <td rowspan="2" class="align-middle">{{ $data8_hosp['meta'] }}</td>
            <td rowspan="2" class="align-middle">{{ $data8_hosp['ponderacion'] }}</td>
            <td rowspan="2" class="align-middle">
              <span class="{{ ($data8_hosp['cumplimiento'] >= preg_replace("/[^0-9]/", '', $data8_hosp['meta'])) ? 'text-success':'text-danger' }}">
                  @if($data8_hosp['cumplimiento'] != NULL)
                    {{ number_format($data8_hosp['cumplimiento'], 2, ',', '.') }}%
                  @else
                    {{ number_format(0, 2, ',', '.') }}%
                  @endif
              </span>
              <small><br>Aporte: {{ number_format($data8_hosp['aporte'], 2, ',', '.') }}%</small>
            </td>
            <td class="text-rigth">{{ number_format($data8_hosp['numerador_acumulado'], 0, ',', '.') }}</td>
            @foreach($data8_hosp['numeradores'] as $numerador)
                <td>{{ number_format($numerador, 0, ',', '.') }}</td>
            @endforeach
        </tr>
        <tr class="text-center">
            <td class="text-left">
              {{ $data8_hosp['label']['denominador'] }}
              <span class="badge badge-secondary">
                  {{ $data8_hosp['label']['fuente']['denominador'] }}
              </span>
            </td>
            <td class="text-rigth">{{ number_format($data8_hosp['denominador'], 0, ',', '.') }}</td>
            <td colspan="12">{{ number_format($data8_hosp['denominador'], 0, ',', '.') }}</td>
        </tr>
    </tbody>
</table>

<h5 class="mb-3">{{ $data9_hosp['label']['meta'] }}</h5>

<table class="table table-sm table-bordered small mb-4">

    <thead>
        <tr class="text-center">
            <th>Indicador</th>
            <th nowrap>Meta</th>
            <th nowrap>Pond</th>
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
        <tr class="text-center">
            <td class="text-left glosa">
              {{ $data9_hosp['label']['numerador'] }}
              <span class="badge badge-secondary">
                  {{ $data9_hosp['label']['fuente']['numerador'] }}
              </span>
            </td>
            <td rowspan="2" class="align-middle">{{ $data9_hosp['meta'] }}</td>
            <td rowspan="2" class="align-middle">{{ $data9_hosp['ponderacion'] }}</td>
            <td rowspan="2" class="align-middle">
              <span class="{{ ($data9_hosp['cumplimiento'] >= preg_replace("/[^0-9]/", '', $data9_hosp['meta'])) ? 'text-success':'text-danger' }}">
                  {{ number_format($data9_hosp['cumplimiento'], 2, ',', '.') }}%
              </span>
              <small><br>Aporte: {{ number_format($data9_hosp['aporte'], 2, ',', '.') }}%</small>
            </td>
            <td class="text-rigth">{{ number_format($data9_hosp['numerador_acumulado'], 0, ',', '.') }}</td>
            @foreach($data9_hosp['numeradores'] as $numerador)
              @if($numerador != NULL)
                <td>{{ number_format($numerador, 0, ',', '.') }}</td>
              @else
                <td></td>
              @endif
            @endforeach
        </tr>
        <tr class="text-center">
            <td class="text-left">
              {{ $data9_hosp['label']['denominador'] }}
              <span class="badge badge-secondary">
                  {{ $data9_hosp['label']['fuente']['denominador'] }}
              </span>
            </td>
            <td class="text-rigth">{{ number_format($data9_hosp['denominador_acumulado'], 0, ',', '.') }}</td>
            @foreach($data9_hosp['denominadores'] as $denominadores)
              @if($denominadores != NULL)
                <td>{{ number_format($denominadores, 0, ',', '.') }}</td>
              @else
                <td></td>
              @endif
            @endforeach
        </tr>
    </tbody>
</table>

<h5 class="mb-3">{{ $data10_hosp['label']['meta'] }}</h5>

<table class="table table-sm table-bordered small mb-4">

    <thead>
        <tr class="text-center">
            <th>Indicador</th>
            <th nowrap>Meta</th>
            <th nowrap>Pond</th>
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
        <tr class="text-center">
            <td class="text-left glosa">{{ $data10_hosp['label']['numerador'] }}
              <span class="badge badge-secondary">
                {{ $data10_hosp['label']['fuente']['numerador'] }}
              </span>
            </td>
            <td rowspan="2" class="align-middle">{{ $data10_hosp['meta'] }}</td>
            <td rowspan="2" class="align-middle">{{ $data10_hosp['ponderacion'] }}%</td>
            <td rowspan="2" class="align-middle">
              <span class="{{ ($data10_hosp['cumplimiento'] >= preg_replace("/[^0-9]/", '', $data10_hosp['meta'])) ? 'text-success':'text-danger' }}">
                  @if($data10_hosp['cumplimiento'] != NULL)
                    {{ number_format($data10_hosp['cumplimiento'], 2, ',', '.') }}%
                  @else
                    {{ number_format(0, 2, ',', '.') }}%
                  @endif
              </span>
              <small><br>Aporte: {{ number_format($data10_hosp['aporte'], 2, ',', '.') }}%</small>
            </td>
            <td class="text-rigth">{{ number_format($data10_hosp['numerador_acumulado'], 0, ',', '.') }}</td>
            @foreach($data10_hosp['numeradores'] as $numerador)
                <td>{{ number_format($numerador, 0, ',', '.') }}</td>
            @endforeach
        </tr>
        <tr class="text-center">
            <td class="text-left">
              {{ $data10_hosp['label']['denominador'] }}
              <span class="badge badge-secondary">
                  {{ $data10_hosp['label']['fuente']['denominador'] }}
              </span>
            </td>
            <td class="text-rigth">{{ number_format($data10_hosp['denominador'], 0, ',', '.') }}</td>
            <td colspan="12">{{ number_format($data10_hosp['denominador'], 0, ',', '.') }}</td>
        </tr>
    </tbody>
</table>

<h5 class="mb-3">{{ $data11_hosp['label']['meta'] }}</h5>

<table class="table table-sm table-bordered small mb-4">

    <thead>
        <tr class="text-center">
            <th class="label">Indicador</th>
            <th nowrap>Meta</th>
            <th nowrap>Ponde</th>

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
        <tr class="text-center">
            <td class="text-left glosa">
              {{ $data11_hosp['label']['numerador'] }}
              <span class="badge badge-secondary">
                  {{ $data11_hosp['label']['fuente']['numerador'] }}
              </span>
            </td>
            <td rowspan="2" class="align-middle">{{ $data11_hosp['meta'] }}</td>
            <td rowspan="2" class="align-middle">{{ $data11_hosp['ponderacion'] }}%</td>

            <td rowspan="2" class="align-middle">
              <span class="{{ ($data11_hosp['cumplimiento'] >= $data11_hosp['meta']) ? 'text-success':'text-danger' }}">
                  @if($data11_hosp['cumplimiento'] != NULL)
                    {{ number_format($data11_hosp['cumplimiento'], 2, ',', '.') }}%
                  @else
                    {{ number_format(0, 2, ',', '.') }}%
                  @endif
              </span>
              <small><br>Aporte: {{ number_format($data11_hosp['aporte'], 2, ',', '.') }}%</small>
            </td>
            <td class="text-rigth">{{ $data11_hosp['numerador_acumulado'] }}</td>
            @foreach($data11_hosp['numeradores'] as $numerador)
                <td>{{ $numerador }} </td>
            @endforeach
        </tr>
        <tr class="text-center">
            <td class="text-left">
              {{ $data11_hosp['label']['denominador'] }}
              <span class="badge badge-secondary">
                  {{ $data11_hosp['label']['fuente']['denominador'] }}
              </span>
            </td>
            <td class="text-rigth">{{ $data11_hosp['denominador_acumulado'] }}</td>
            @foreach($data11_hosp['denominadores'] as $denominador)
                <td>{{ $denominador }} </td>
            @endforeach
        </tr>
    </tbody>
</table>

<h5 class="mb-3">{{ $data12_hosp['label']['meta'] }}</h5>

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
                {{ $data12_hosp['label']['numerador'] }}
                <span class="badge badge-secondary">
                    {{ $data12_hosp['label']['fuente']['numerador'] }}
                </span>
            </td>
            <td rowspan="2" class="align-middle text-center">{{ $data12_hosp['meta'] }}</td>
            <td rowspan="2" class="align-middle text-center">
                {{ $data12_hosp['ponderacion'] }}
            </td>
            <td rowspan="2" class="align-middle text-center">
                <span class="{{ ($data12_hosp['cumplimiento'] >= preg_replace("/[^0-9]/", '', $data12_hosp['meta'])) ? 'text-success':'text-danger' }}">
                {{ number_format($data12_hosp['cumplimiento'], 2, ',', '.') }}%
                </span>
                <small><br>Aporte: @numero($data12_hosp['aporte'])%</small>
            </td>
            <td class="text-right">{{ number_format($data12_hosp['numerador_acumulado'],0, ',', '.') }}</td>
            @foreach($data12_hosp['numeradores'] as $numerador)
                <td class="text-right">{{ number_format($numerador, 0, ',', '.') }}</td>
            @endforeach
        </tr>
        <tr>
            <td class="text-left">
                {{ $data12_hosp['label']['denominador'] }}
                <span class="badge badge-secondary">
                    {{ $data12_hosp['label']['fuente']['denominador'] }}
                </span>
            </td>
            <td class="text-right">{{ number_format($data12_hosp['denominador_acumulado'],0, ',', '.') }}</td>
            @foreach($data12_hosp['denominadores'] as $denominador)
                <td class="text-right">{{ number_format($denominador, 0, ',', '.') }}</td>
            @endforeach
        </tr>
    </tbody>
</table>
@endsection

@section('custom_js')

@endsection
