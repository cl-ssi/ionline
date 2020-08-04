@extends('layouts.app')

@section('title', 'Ley 18834')

@section('content')

@include('indicators.partials.nav')

<h3 class="mb-3">SERVICIO DE SALUD IQUIQUE
    <small>
        - Cumplimiento : {{ number_format($data1_reyno['aporte'] +
                                  $data2_reyno['aporte'] +
                                  $data3_reyno['aporte'] +
                                  $data12_reyno['aporte'], 2, ',', '.') }}%
    </small>
</h3>
<h6 class="mb-3">Metas Sanitarias Ley N° 19.664</h6>

<style>
    .glosa {
        width: 400px;
    }
</style>

<hr>

<h5 class="mb-3">{{ $data1_reyno['label']['meta'] }}</h5>
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
                {{ $data1_reyno['label']['numerador'] }}
                <span class="badge badge-secondary">
                    {{ $data1_reyno['label']['fuente']['numerador'] }}
                </span>
            </td>
            <td rowspan="2" class="align-middle text-center">{{ $data1_reyno['meta'] }}</td>
            <td rowspan="2" class="align-middle text-center">
                {{ $data1_reyno['ponderacion'] }}
            </td>
            <td rowspan="2" class="align-middle text-center">
                <span class="{{ ($data1_reyno['cumplimiento'] >= preg_replace("/[^0-9]/", '', $data1_reyno['meta'])) ? 'text-success':'text-danger' }}">
                  @if($data1_reyno['cumplimiento'] != NULL)
                    {{ number_format($data1_reyno['cumplimiento'], 2, ',', '.') }}%
                  @else
                    {{ number_format(0, 2, ',', '.') }}%
                  @endif
                </span>
                <small><br>Aporte: {{ number_format($data1_reyno['aporte'], 2, ',', '.') }}%</small>
            </td>
            <td class="text-right">{{ number_format($data1_reyno['numerador_12a'], 0, ',', '.') }}</td>
            <td class="text-right">
              @if($data1_reyno['numerador'] != NULL)
                {{ number_format($data1_reyno['numerador'], 0, ',', '.') }}
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
              @if($data1_reyno['numerador_6'] != NULL)
                {{ number_format($data1_reyno['numerador_6'], 0, ',', '.') }}
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
              @if($data1_reyno['numerador_12'] != NULL)
                {{ number_format($data1_reyno['numerador_12'], 0, ',', '.') }}
              @else
                {{ number_format(0, 0, ',', '.') }}
              @endif
            </td>
        </tr>
        <tr>
            <td class="text-left">
                {{ $data1_reyno['label']['denominador'] }}
                <span class="badge badge-secondary">
                    {{ $data1_reyno['label']['fuente']['denominador'] }}
                </span>
            </td>
            <td class="text-right">{{ number_format($data1_reyno['denominador_12a'], 0, ',', '.') }}</td>
            <td class="text-right">
              @if($data1_reyno['denominador'] != NULL)
                {{ number_format($data1_reyno['denominador'], 0, ',', '.') }}
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
              @if($data1_reyno['denominador_6'] != NULL)
                {{ number_format($data1_reyno['denominador_6'], 0, ',', '.') }}
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
              @if($data1_reyno['denominador_12'] != NULL)
                {{ number_format($data1_reyno['denominador_12'], 2, ',', '.') }}%
              @else
                {{ number_format(0, 0, ',', '.') }}
              @endif
            </td>
        </tr>
    </tbody>
</table>

<h5 class="mb-3">{{ $data2_reyno['label']['meta'] }}</h5>

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
                {{ $data2_reyno['label']['numerador'] }}
                <span class="badge badge-secondary">
                  {{ $data2_reyno['label']['fuente']['numerador'] }}
                </span>
            </td>
            <td rowspan="2" class="align-middle text-center">{{ $data2_reyno['meta'] }}</td>
            <td rowspan="2" class="align-middle text-center">
                {{ $data2_reyno['ponderacion'] }}
            </td>
            <td rowspan="2" class="align-middle text-center">
                <span class="{{ ($data2_reyno['cumplimiento'] >= preg_replace("/[^0-9]/", '', $data2_reyno['meta'])) ? 'text-success':'text-danger' }}">
                    @if($data2_reyno['cumplimiento'] != NULL)
                      {{ number_format($data2_reyno['cumplimiento'], 2, ',', '.') }}%
                    @else
                      {{ number_format(0, 2, ',', '.') }}%
                    @endif
                </span>
                <small><br>Aporte: {{ number_format($data2_reyno['aporte'], 2, ',', '.') }}%</small>
            </td>
            <td class="text-right">{{ number_format($data2_reyno['numerador_12a'], 0, ',', '.') }}</td>
            <td class="text-right">
              @if($data2_reyno['numerador'] != NULL)
                {{ number_format($data2_reyno['numerador'], 0, ',', '.') }}
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
              @if($data2_reyno['numerador_6'] != NULL)
                {{ number_format($data2_reyno['numerador_6'], 0, ',', '.') }}
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
              @if($data2_reyno['numerador_12'] != NULL)
                {{ number_format($data2_reyno['numerador_12'], 0, ',', '.') }}
              @else
                {{ number_format(0, 0, ',', '.') }}
              @endif
            </td>
        </tr>
        <tr>
            <td class="text-left">
                {{ $data2_reyno['label']['denominador'] }}
                <span class="badge badge-secondary">
                    {{ $data2_reyno['label']['fuente']['denominador'] }}
                </span>
            </td>
            <td class="text-right">{{ number_format($data1_reyno['denominador_12a'], 0, ',', '.') }}</td>
            <td class="text-right">
              @if($data2_reyno['denominador'] != NULL)
                {{ number_format($data2_reyno['denominador'], 0, ',', '.') }}
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
              @if($data2_reyno['denominador_6'] != NULL)
                {{ number_format($data2_reyno['denominador_6'], 0, ',', '.') }}
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
              @if($data2_reyno['denominador_12'] != NULL)
                {{ number_format($data2_reyno['denominador_12'], 0, ',', '.') }}
              @else
                {{ number_format(0, 0, ',', '.') }}
              @endif
            </td>
        </tr>
    </tbody>
</table>

<h5 class="mb-3">{{ $data3_reyno['label']['meta'] }}</h5>
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
                {{ $data3_reyno['label']['numerador'] }}
                <span class="badge badge-secondary">
                  {{ $data3_reyno['label']['fuente']['numerador'] }}
                </span>
            </td>
            <td rowspan="2" class="align-middle text-center">{{ $data3_reyno['meta'] }}</td>
            <td rowspan="2" class="align-middle text-center">
                {{ $data3_reyno['ponderacion'] }}%
            </td>
            <td rowspan="2" class="align-middle text-center">
                <span class="{{ ($data3_reyno['cumplimiento'] >= preg_replace("/[^0-9]/", '', $data3_reyno['meta'])) ? 'text-success':'text-danger' }}">
                    @if($data3_reyno['cumplimiento'] != NULL)
                      {{ number_format($data3_reyno['cumplimiento'], 2, ',', '.') }}%
                    @else
                      {{ number_format(0, 2, ',', '.') }}%
                    @endif

                </span>
                <small><br>Aporte: {{ number_format($data3_reyno['aporte'], 2, ',', '.') }}%</small>
            </td>
            <td class="text-right">{{ number_format($data3_reyno['numerador_12a'], 0, ',', '.') }}</td>
            <td class="text-right">
              @if($data3_reyno['numerador'] != NULL)
                {{ number_format($data3_reyno['numerador'], 0, ',', '.') }}
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
              @if($data3_reyno['numerador_6'] != NULL)
                {{ number_format($data3_reyno['numerador_6'], 0, ',', '.') }}
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
              @if($data3_reyno['numerador_12'] != NULL)
                {{ number_format($data3_reyno['numerador_12'], 0, ',', '.') }}
              @else
                {{ number_format(0, 0, ',', '.') }}
              @endif
            </td>
        </tr>
        <tr>
            <td class="text-left">
                {{ $data3_reyno['label']['denominador'] }}
                <span class="badge badge-secondary">
                    {{ $data3_reyno['label']['fuente']['denominador'] }}
                </span>
            </td>
            <td class="text-right">{{ number_format($data3_reyno['denominador_12a'], 0, ',', '.') }}</td>
            <td class="text-right">
              @if($data3_reyno['denominador'] != NULL)
                {{ number_format($data3_reyno['denominador'], 0, ',', '.') }}
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
              @if($data3_reyno['denominador_6'] != NULL)
                {{ number_format($data3_reyno['denominador_6'], 0, ',', '.') }}
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
              @if($data3_reyno['denominador_12'] != NULL)
                {{ number_format($data3_reyno['denominador_12'], 0, ',', '.') }}
              @else
                {{ number_format(0, 0, ',', '.') }}
              @endif
            </td>
        </tr>
    </tbody>
</table>

<h5 class="mb-3">{{ $data12_reyno['label']['meta'] }}</h5>

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
                {{ $data12_reyno['label']['numerador'] }}
                <span class="badge badge-secondary">
                    {{ $data12_reyno['label']['fuente']['numerador'] }}
                </span>
            </td>
            <td rowspan="2" class="align-middle text-center">{{ $data12_reyno['meta'] }}</td>
            <td rowspan="2" class="align-middle text-center">
                {{ $data12_reyno['ponderacion'] }}
            </td>
            <td rowspan="2" class="align-middle text-center">
                <span class="{{ ($data12_reyno['cumplimiento'] >= preg_replace("/[^0-9]/", '', $data12_reyno['meta'])) ? 'text-success':'text-danger' }}">
                {{ number_format($data12_reyno['cumplimiento'], 2, ',', '.') }}%
                </span>
                <small><br>Aporte: @numero($data12_reyno['aporte'])%</small>
            </td>
            <td class="text-right">{{ number_format($data12_reyno['numerador_acumulado'],0, ',', '.') }}</td>
            @foreach($data12_reyno['numeradores'] as $numerador)
                <td class="text-right">{{ number_format($numerador, 0, ',', '.') }}</td>
            @endforeach
        </tr>
        <tr>
            <td class="text-left">
                {{ $data12_reyno['label']['denominador'] }}
                <span class="badge badge-secondary">
                    {{ $data12_reyno['label']['fuente']['denominador'] }}
                </span>
            </td>
            <td class="text-right">{{ number_format($data12_reyno['denominador_acumulado'],0, ',', '.') }}</td>
            @foreach($data12_reyno['denominadores'] as $denominador)
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
