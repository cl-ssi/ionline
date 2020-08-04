@extends('layouts.app')

@section('title', 'Ley 19.664')

@section('content')

@include('indicators.partials.nav')

<h3 class="mb-3">SERVICIO DE SALUD IQUIQUE
    <small>
        - Cumplimiento : {{ number_format($data1['aporte'] +
                                  $data2['aporte'] +
                                  $data3['aporte'] +
                                  $data4['aporte'] +
                                  $data6['aporte'] +
                                  $data8['aporte'] +
                                  $data10['aporte'] +
                                  $data11['aporte'] +
                                  $data12['aporte'], 2, ',', '.') }}%
    </small>
</h3>
<h6 class="mb-3">Metas Sanitarias Ley N° 19.664</h6>

<style>
    .glosa {
        width: 400px;
    }
</style>

<hr>

<h5 class="mb-3">{{ $data1['label']['meta'] }}</h5>
<table class="table table-sm table-bordered small">
    <thead>
        <tr class="text-center">
          <th>Indicador</th>
          <th nowrap>Meta</th>
          <th nowrap>Pond.</th>
          <th nowrap>% Cump</th>
          <th>Dic. {{ $last_year }}</th>
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
                {{ $data1['label']['numerador'] }}
                <span class="badge badge-secondary">
                    {{ $data1['label']['fuente']['numerador'] }}
                </span>
            </td>
            <td rowspan="2" class="align-middle text-center">≥{{ $data1['meta'] }}%</td>
            <td rowspan="2" class="align-middle text-center">
                {{ $data1['ponderacion'] }}
            </td>
            <td rowspan="2" class="align-middle text-center">
                <span class="{{ ($data1['cumplimiento'] >= preg_replace("/[^0-9]/", '', $data1['meta'])) ? 'text-success':'text-danger' }}">
                  @if($data1['cumplimiento'] != NULL)
                    {{ number_format($data1['cumplimiento'], 2, ',', '.') }}%
                  @else
                    {{ number_format(0, 2, ',', '.') }}%
                  @endif
                </span>
                <small><br>Aporte: {{ number_format($data1['aporte'], 2, ',', '.') }}%</small>
            </td>
            <td class="text-right">{{ number_format($data1['numerador_12a'], 0, ',', '.') }}</td>
            <td class="text-right">
              @if($data1['numerador'] != NULL)
                {{ number_format($data1['numerador'], 0, ',', '.') }}
              @else
                {{ number_format(0, 0, ',', '.') }}
              @endif
            </td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td class="text-right">
              @if($data1['numerador_6'] != NULL)
                {{ number_format($data1['numerador_6'], 0, ',', '.') }}
              @else
                {{ number_format(0, 0, ',', '.') }}
              @endif
            </td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td class="text-right">
              @if($data1['numerador_12'] != NULL)
                {{ number_format($data1['numerador_12'], 0, ',', '.') }}
              @else
                {{ number_format(0, 0, ',', '.') }}
              @endif
            </td>
        </tr>
        <tr>
            <td class="text-left">
                {{ $data1['label']['denominador'] }}
                <span class="badge badge-secondary">
                    {{ $data1['label']['fuente']['denominador'] }}
                </span>
            </td>
            <td class="text-right">{{ number_format($data1['denominador_12a'], 0, ',', '.') }}</td>
            <td class="text-right">
              @if($data1['denominador'] != NULL)
                {{ number_format($data1['denominador'], 0, ',', '.') }}
              @else
                {{ number_format(0, 0, ',', '.') }}
              @endif
            </td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td class="text-right">
              @if($data1['denominador_6'] != NULL)
                {{ number_format($data1['denominador_6'], 0, ',', '.') }}
              @else
                {{ number_format(0, 0, ',', '.') }}
              @endif
            </td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td class="text-right">
              @if($data1['denominador_12'] != NULL)
                {{ number_format($data1['denominador_12'], 2, ',', '.') }}%
              @else
                {{ number_format(0, 0, ',', '.') }}
              @endif
            </td>
        </tr>
    </tbody>
</table>

<h5 class="mb-3">{{ $data2['label']['meta'] }}</h5>

<table class="table table-sm table-bordered small">
    <thead>
        <tr class="text-center">
            <th>Indicador</th>
            <th nowrap>Meta</th>
            <th nowrap>Pond.</th>
            <th nowrap>% Cump</th>
            <th>Dic. {{ $last_year }}</th>
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
                {{ $data2['label']['numerador'] }}
                <span class="badge badge-secondary">
                  {{ $data2['label']['fuente']['numerador'] }}
                </span>
            </td>
            <td rowspan="2" class="align-middle text-center">{{ $data2['meta'] }}</td>
            <td rowspan="2" class="align-middle text-center">
                {{ $data2['ponderacion'] }}
            </td>
            <td rowspan="2" class="align-middle text-center">
                <span class="{{ ($data2['cumplimiento'] >= preg_replace("/[^0-9]/", '', $data2['meta'])) ? 'text-success':'text-danger' }}">
                    @if($data2['cumplimiento'] != NULL)
                      {{ number_format($data2['cumplimiento'], 2, ',', '.') }}%
                    @else
                      {{ number_format(0, 2, ',', '.') }}%
                    @endif
                </span>
                <small><br>Aporte: {{ number_format($data2['aporte'], 2, ',', '.') }}%</small>
            </td>
            <td class="text-right">{{ number_format($data2['numerador_12a'], 0, ',', '.') }}</td>
            <td class="text-right">
              @if($data2['numerador'] != NULL)
                {{ number_format($data2['numerador'], 0, ',', '.') }}
              @else
                {{ number_format(0, 0, ',', '.') }}
              @endif
            </td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td class="text-right">
              @if($data2['numerador_6'] != NULL)
                {{ number_format($data2['numerador_6'], 0, ',', '.') }}
              @else
                {{ number_format(0, 0, ',', '.') }}
              @endif
            </td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td class="text-right">
              @if($data2['numerador_12'] != NULL)
                {{ number_format($data2['numerador_12'], 0, ',', '.') }}
              @else
                {{ number_format(0, 0, ',', '.') }}
              @endif
            </td>
        </tr>
        <tr>
            <td class="text-left">
                {{ $data2['label']['denominador'] }}
                <span class="badge badge-secondary">
                    {{ $data2['label']['fuente']['denominador'] }}
                </span>
            </td>
            <td class="text-right">{{ number_format($data2['denominador_12a'], 0, ',', '.') }}</td>
            <td class="text-right">
              @if($data2['denominador'] != NULL)
                {{ number_format($data2['denominador'], 0, ',', '.') }}
              @else
                {{ number_format(0, 0, ',', '.') }}
              @endif
            </td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td class="text-right">
              @if($data2['denominador_6'] != NULL)
                {{ number_format($data2['denominador_6'], 0, ',', '.') }}
              @else
                {{ number_format(0, 0, ',', '.') }}
              @endif
            </td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td class="text-right">
              @if($data2['denominador_12'] != NULL)
                {{ number_format($data2['denominador_12'], 0, ',', '.') }}
              @else
                {{ number_format(0, 0, ',', '.') }}
              @endif
            </td>
        </tr>
    </tbody>
</table>

<h5 class="mb-3">{{ $data3['label']['meta'] }}</h5>
<table class="table table-sm table-bordered small">
    <thead>
        <tr class="text-center">
            <!--<th>Nombre de la Meta</th>-->
            <th>Indicador</th>
            <th nowrap>Meta</th>
            <th nowrap>Pond.</th>
            <th nowrap>% Cump</th>
            <th>Dic. {{ $last_year }}</th>
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
                {{ $data3['label']['numerador'] }}
                <span class="badge badge-secondary">
                  {{ $data3['label']['fuente']['numerador'] }}
                </span>
            </td>
            <td rowspan="2" class="align-middle text-center">{{ $data3['meta'] }}</td>
            <td rowspan="2" class="align-middle text-center">
                {{ $data3['ponderacion'] }}%
            </td>
            <td rowspan="2" class="align-middle text-center">
                <span class="{{ ($data3['cumplimiento'] >= preg_replace("/[^0-9]/", '', $data3['meta'])) ? 'text-success':'text-danger' }}">
                    @if($data3['cumplimiento'] != NULL)
                      {{ number_format($data3['cumplimiento'], 2, ',', '.') }}%
                    @else
                      {{ number_format(0, 2, ',', '.') }}%
                    @endif

                </span>
                <small><br>Aporte: {{ number_format($data3['aporte'], 2, ',', '.') }}%</small>
            </td>
            <td class="text-right">{{ number_format($data3['numerador_12a'], 0, ',', '.') }}</td>
            <td class="text-right">
              @if($data3['numerador'] != NULL)
                {{ number_format($data3['numerador'], 0, ',', '.') }}
              @else
                {{ number_format(0, 0, ',', '.') }}
              @endif
            </td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td class="text-right">
              @if($data3['numerador_6'] != NULL)
                {{ number_format($data3['numerador_6'], 0, ',', '.') }}
              @else
                {{ number_format(0, 0, ',', '.') }}
              @endif
            </td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td class="text-right">
              @if($data3['numerador_12'] != NULL)
                {{ number_format($data3['numerador_12'], 0, ',', '.') }}
              @else
                {{ number_format(0, 0, ',', '.') }}
              @endif
            </td>
        </tr>
        <tr>
            <td class="text-left">
                {{ $data3['label']['denominador'] }}
                <span class="badge badge-secondary">
                    {{ $data3['label']['fuente']['denominador'] }}
                </span>
            </td>
            <td class="text-right">{{ number_format($data3['denominador_12a'], 0, ',', '.') }}</td>
            <td class="text-right">
              @if($data3['denominador'] != NULL)
                {{ number_format($data3['denominador'], 0, ',', '.') }}
              @else
                {{ number_format(0, 0, ',', '.') }}
              @endif
            </td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td class="text-right">
              @if($data3['denominador_6'] != NULL)
                {{ number_format($data3['denominador_6'], 0, ',', '.') }}
              @else
                {{ number_format(0, 0, ',', '.') }}
              @endif
            </td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td class="text-right">
              @if($data3['denominador_12'] != NULL)
                {{ number_format($data3['denominador_12'], 0, ',', '.') }}
              @else
                {{ number_format(0, 0, ',', '.') }}
              @endif
            </td>
        </tr>
    </tbody>
</table>

<h5 class="mb-3">{{ $data4['label']['meta'] }}</h5>

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
              {{ $data4['label']['numerador'] }}
              <span class="badge badge-secondary">
                  {{ $data4['label']['fuente']['numerador'] }}
              </span>
            </td>
            <td rowspan="2" class="align-middle">{{ $data4['meta'] }}</td>
            <td rowspan="2" class="align-middle">{{ $data4['ponderacion'] }}%</td>
            <td rowspan="2" class="align-middle">
              <span class="{{ ($data4['cumplimiento'] <= preg_replace("/[^0-9]/", '', $data4['meta'])) ? 'text-success':'text-danger' }}">
                  {{ number_format($data4['cumplimiento'], 2, ',', '.') }}%
              </span>
              <small><br>Aporte: {{ number_format($data4['aporte'], 2, ',', '.') }}%</small>
            </td>
            <td class="text-rigth">{{ number_format($data4['numerador_acumulado'], 0, ',', '.') }}</td>
            @foreach($data4['numeradores'] as $numerador)
                <td>{{ number_format($numerador, 0, ',', '.') }}</td>
            @endforeach
        </tr>
        <tr class="text-center">
            <td class="text-left">
              {{ $data4['label']['denominador'] }}
              <span class="badge badge-secondary">
                  {{ $data4['label']['fuente']['denominador'] }}
              </span>
            </td>
            <td class="text-rigth">{{ number_format($data4['denominador_acumulado'], 0, ',', '.') }}</td>
            @foreach($data4['denominadores'] as $denominadores)
                <td>{{ number_format($denominadores, 0, ',', '.') }}</td>
            @endforeach
        </tr>
    </tbody>
</table>

<h5 class="mb-3">{{ $data6['label']['meta'] }}</h5>

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
              {{ $data6['label']['numerador'] }}
              <span class="badge badge-secondary">
                  {{ $data6['label']['fuente']['numerador'] }}
              </span>
            </td>
            <td rowspan="2" class="align-middle">disminución {{ $data6['meta'] }}% respecto de línea base.
                <small><br>línea base: {{ $data6['meta_nacional'] }}%</small>
            </td>
            <td rowspan="2" class="align-middle">{{ $data6['ponderacion'] }}%</td>
            <td rowspan="2" class="align-middle">
              @if($data6['cumplimiento'] <= ($data6['meta_nacional']-5) AND $data6['cumplimiento'] != 0)
                100%
                <small><br>{{ $data6['cumplimiento'] }}%</small>
              @else
                0%
                <small><br>{{ $data6['cumplimiento'] }}%</small>
              @endif
            </td>
            <td class="text-rigth">{{ $data6['numerador_acumulado'] }}</td>
            <td class="text-right" colspan="{{ $data6['vigencia'] }}">{{ number_format($data6['numerador_acumulado'],0, ',', '.') }}</td>
        </tr>
        <tr class="text-center">
            <td class="text-left">
              {{ $data6['label']['denominador'] }}
              <span class="badge badge-secondary">
                  {{ $data6['label']['fuente']['denominador'] }}
              </span>
            </td>
            <td class="text-rigth">{{ $data6['denominador_acumulado'] }}</td>
            <td colspan="12" class="text-center">{{ $data6['denominador_acumulado'] }} </td>
        </tr>
    </tbody>
</table>

<h5 class="mb-3">{{ $data8['label']['meta'] }}</h5>

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
              {{ $data8['label']['numerador'] }}
              <span class="badge badge-secondary">
                  {{ $data8['label']['fuente']['numerador'] }}
              </span>
            </td>
            <td rowspan="2" class="align-middle">{{ $data8['meta'] }}</td>
            <td rowspan="2" class="align-middle">{{ $data8['ponderacion'] }}</td>
            <td rowspan="2" class="align-middle">
              <span class="{{ ($data8['cumplimiento'] >= preg_replace("/[^0-9]/", '', $data8['meta'])) ? 'text-success':'text-danger' }}">
                  @if($data8['cumplimiento'] != NULL)
                    {{ number_format($data8['cumplimiento'], 2, ',', '.') }}%
                  @else
                    {{ number_format(0, 2, ',', '.') }}%
                  @endif
              </span>
              <small><br>Aporte: {{ number_format($data8['aporte'], 2, ',', '.') }}%</small>
            </td>
            <td class="text-rigth">{{ number_format($data8['numerador_acumulado'], 0, ',', '.') }}</td>
            @foreach($data8['numeradores'] as $numerador)
                <td>{{ number_format($numerador, 0, ',', '.') }}</td>
            @endforeach
        </tr>
        <tr class="text-center">
            <td class="text-left">
              {{ $data8['label']['denominador'] }}
              <span class="badge badge-secondary">
                  {{ $data8['label']['fuente']['denominador'] }}
              </span>
            </td>
            <td class="text-rigth">{{ number_format($data8['denominador'], 0, ',', '.') }}</td>
            <td colspan="12">{{ number_format($data8['denominador'], 0, ',', '.') }}</td>
        </tr>
    </tbody>
</table>

<h5 class="mb-3">{{ $data10['label']['meta'] }}</h5>

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
            <td class="text-left glosa">{{ $data10['label']['numerador'] }}
              <span class="badge badge-secondary">
                {{ $data10['label']['fuente']['numerador'] }}
              </span>
            </td>
            <td rowspan="2" class="align-middle">{{ $data10['meta'] }}</td>
            <td rowspan="2" class="align-middle">{{ $data10['ponderacion'] }}%</td>
            <td rowspan="2" class="align-middle">
              <span class="{{ ($data10['cumplimiento'] >= preg_replace("/[^0-9]/", '', $data10['meta'])) ? 'text-success':'text-danger' }}">
                  @if($data10['cumplimiento'] != NULL)
                    {{ number_format($data10['cumplimiento'], 2, ',', '.') }}%
                  @else
                    {{ number_format(0, 2, ',', '.') }}%
                  @endif
              </span>
              <small><br>Aporte: {{ number_format($data10['aporte'], 2, ',', '.') }}%</small>
            </td>
            <td class="text-rigth">{{ number_format($data10['numerador_acumulado'], 0, ',', '.') }}</td>
            @foreach($data10['numeradores'] as $numerador)
                <td>{{ number_format($numerador, 0, ',', '.') }}</td>
            @endforeach
        </tr>
        <tr class="text-center">
            <td class="text-left">
              {{ $data10['label']['denominador'] }}
              <span class="badge badge-secondary">
                  {{ $data10['label']['fuente']['denominador'] }}
              </span>
            </td>
            <td class="text-rigth">{{ number_format($data10['denominador'], 0, ',', '.') }}</td>
            <td colspan="12">{{ number_format($data10['denominador'], 0, ',', '.') }}</td>
        </tr>
    </tbody>
</table>

<h5 class="mb-3">{{ $data11['label']['meta'] }}</h5>

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
              {{ $data11['label']['numerador'] }}
              <span class="badge badge-secondary">
                  {{ $data11['label']['fuente']['numerador'] }}
              </span>
            </td>
            <td rowspan="2" class="align-middle">{{ $data11['meta'] }}</td>
            <td rowspan="2" class="align-middle">{{ $data11['ponderacion'] }}%</td>

            <td rowspan="2" class="align-middle">
              <span class="{{ ($data11['cumplimiento'] >= $data11['meta']) ? 'text-success':'text-danger' }}">
                  @if($data11['cumplimiento'] != NULL)
                    {{ number_format($data11['cumplimiento'], 2, ',', '.') }}%
                  @else
                    {{ number_format(0, 2, ',', '.') }}%
                  @endif
              </span>
              <small><br>Aporte: {{ number_format($data11['aporte'], 2, ',', '.') }}%</small>
            </td>
            <td class="text-rigth">{{ $data11['numerador_acumulado'] }}</td>
            @foreach($data11['numeradores'] as $numerador)
                <td>{{ $numerador }} </td>
            @endforeach
        </tr>
        <tr class="text-center">
            <td class="text-left">
              {{ $data11['label']['denominador'] }}
              <span class="badge badge-secondary">
                  {{ $data11['label']['fuente']['denominador'] }}
              </span>
            </td>
            <td class="text-rigth">{{ $data11['denominador_acumulado'] }}</td>
            @foreach($data11['denominadores'] as $denominador)
                <td>{{ $denominador }} </td>
            @endforeach
        </tr>
    </tbody>
</table>

<h5 class="mb-3">{{ $data12['label']['meta'] }}</h5>

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
                {{ $data12['label']['numerador'] }}
                <span class="badge badge-secondary">
                    {{ $data12['label']['fuente']['numerador'] }}
                </span>
            </td>
            <td rowspan="2" class="align-middle text-center">≥{{ $data12['meta'] }}%</td>
            <td rowspan="2" class="align-middle text-center">
                {{ $data12['ponderacion'] }}
            </td>
            <td rowspan="2" class="align-middle text-center">
                <span class="{{ ($data12['cumplimiento'] >= $data12['meta']) ? 'text-success':'text-danger' }}">
                {{ number_format($data12['cumplimiento'], 2, ',', '.') }}%
                </span>
                <small><br>Aporte: @numero($data12['aporte'])%</small>
            </td>
            <td class="text-right">{{ number_format($data12['numerador_acumulado'],0, ',', '.') }}</td>
            @foreach($data12['numeradores'] as $numerador)
                <td class="text-right">{{ number_format($numerador, 0, ',', '.') }}</td>
            @endforeach
        </tr>
        <tr>
            <td class="text-left">
                {{ $data12['label']['denominador'] }}
                <span class="badge badge-secondary">
                    {{ $data12['label']['fuente']['denominador'] }}
                </span>
            </td>
            <td class="text-right">{{ number_format($data12['denominador_acumulado'],0, ',', '.') }}</td>
            @foreach($data12['denominadores'] as $denominador)
                <td class="text-right">{{ number_format($denominador, 0, ',', '.') }}</td>
            @endforeach
        </tr>
    </tbody>
</table>

@endsection

@section('custom_js')
<script type="text/javascript">
    $('#myTab a[href="#IQUIQUE"]').tab('show') // Select tab by name
</script>
@endsection
