@extends('layouts.app')

@section('title', 'Ley N° 18.834')

@section('content')

@include('indicators.partials.nav')

<h3 class="mb-3">CGU Dr. Hector Reyno
    <small>
        -  Cumplimiento : @numero($data11_reyno['aporte'] +
                                  $data12_reyno['aporte'] +
                                  $data13_reyno['aporte'] +
                                  $data18_reyno['aporte'] +
                                  $data31_reyno['aporte'])%
    </small>
</h3>
<h6 class="mb-3">Metas Sanitarias Ley N° 18.834</h6>

<style>
    .glosa {
        width: 400px;
    }
</style>

<hr>


<h5 class="mb-3">{{ $data11_reyno['label']['meta'] }}</h5>
<table class="table table-sm table-bordered small">
    <thead>
        <tr class="text-center">
          <th>Indicador</th>
          <th nowrap>Meta</th>
          <th nowrap>Pond.</th>
          <th nowrap>% Cump</th>
          <th>Dic {{ $last_year }}</th>
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
                {{ $data11_reyno['label']['numerador'] }}
                <span class="badge badge-secondary">
                    {{ $data11_reyno['label']['fuente']['numerador'] }}
                </span>
            </td>
            <td rowspan="2" class="align-middle text-center">{{ $data11_reyno['meta'] }}</td>
            <td rowspan="2" class="align-middle text-center">
                {{ $data11_reyno['ponderacion'] }}
            </td>
            <td rowspan="2" class="align-middle text-center">
                <span class="{{ ($data11_reyno['cumplimiento'] >= preg_replace("/[^0-9]/", '', $data11_reyno['meta'])) ? 'text-success':'text-danger' }}">
                  @if($data11_reyno['cumplimiento'] != NULL)
                    {{ number_format($data11_reyno['cumplimiento'], 2, ',', '.') }}%
                  @else
                    {{ number_format(0, 2, ',', '.') }}%
                  @endif
                </span>
                <small><br>Aporte: @numero($data11_reyno['aporte'])%</small>
            </td>
            <td class="text-right">{{ number_format($data11_reyno['numerador_12a'], 0, ',', '.') }}</td>
            <td class="text-right">
              @if($data11_reyno['numerador'] != NULL)
                {{ number_format($data11_reyno['numerador'], 0, ',', '.') }}
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
              @if($data11_reyno['numerador_6'] != NULL)
                {{ number_format($data11_reyno['numerador_6'], 0, ',', '.') }}
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
              @if($data11_reyno['numerador_12'] != NULL)
                {{ number_format($data11_reyno['numerador_12'], 0, ',', '.') }}
              @else
                {{ number_format(0, 0, ',', '.') }}
              @endif
            </td>
        </tr>
        <tr>
            <td class="text-left">
                {{ $data11_reyno['label']['denominador'] }}
                <span class="badge badge-secondary">
                    {{ $data11_reyno['label']['fuente']['denominador'] }}
                </span>
            </td>
            <td class="text-right">{{ number_format($data11_reyno['denominador_12a'], 0, ',', '.') }}</td>
            <td class="text-right">
              @if($data11_reyno['denominador'] != NULL)
                {{ number_format($data11_reyno['denominador'], 0, ',', '.') }}
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
              @if($data11_reyno['denominador_6'] != NULL)
                {{ number_format($data11_reyno['denominador_6'], 0, ',', '.') }}
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
              @if($data11_reyno['denominador_12'] != NULL)
                {{ number_format($data11_reyno['denominador_12'], 2, ',', '.') }}%
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
            <th>Dic {{ $last_year }}</th>
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
            <td class="text-right">{{ number_format($data12_reyno['numerador_12a'], 0, ',', '.') }}</td>
            <td class="text-right">
              @if($data12_reyno['numerador'] != NULL)
                {{ number_format($data12_reyno['numerador'], 0, ',', '.') }}
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
              @if($data12_reyno['numerador_6'] != NULL)
                {{ number_format($data12_reyno['numerador_6'], 0, ',', '.') }}
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
              @if($data12_reyno['numerador_12'] != NULL)
                {{ number_format($data12_reyno['numerador_12'], 0, ',', '.') }}
              @else
                {{ number_format(0, 0, ',', '.') }}
              @endif
            </td>
        </tr>
        <tr>
            <td class="text-left">
                {{ $data12_reyno['label']['denominador'] }}
                <span class="badge badge-secondary">
                    {{ $data12_reyno['label']['fuente']['denominador'] }}
                </span>
            </td>
            <td class="text-right">{{ number_format($data12_reyno['denominador_12a'], 0, ',', '.') }}</td>
            <td class="text-right">
              @if($data12_reyno['denominador'] != NULL)
                {{ number_format($data12_reyno['denominador'], 0, ',', '.') }}
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
              @if($data12_reyno['denominador_6'] != NULL)
                {{ number_format($data12_reyno['denominador_6'], 0, ',', '.') }}
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
              @if($data12_reyno['denominador_12'] != NULL)
                {{ number_format($data12_reyno['denominador_12'], 0, ',', '.') }}
              @else
                {{ number_format(0, 0, ',', '.') }}
              @endif
            </td>
        </tr>
    </tbody>
</table>

<h5 class="mb-3">{{ $data13_reyno['label']['meta'] }}</h5>
<table class="table table-sm table-bordered small">
    <thead>
        <tr class="text-center">
            <!--<th>Nombre de la Meta</th>-->
            <th>Indicador</th>
            <th nowrap>Meta</th>
            <th nowrap>Pond.</th>
            <th nowrap>% Cump</th>
            <th>Dic {{ $last_year }}</th>
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
                {{ $data13_reyno['label']['numerador'] }}
                <span class="badge badge-secondary">
                  {{ $data13_reyno['label']['fuente']['numerador'] }}
                </span>
            </td>
            <td rowspan="2" class="align-middle text-center">{{ $data13_reyno['meta'] }}</td>
            <td rowspan="2" class="align-middle text-center">
                {{ $data13_reyno['ponderacion'] }}
            </td>
            <td rowspan="2" class="align-middle text-center">
                <span class="{{ ($data13_reyno['cumplimiento'] >= preg_replace("/[^0-9]/", '', $data13_reyno['meta'])) ? 'text-success':'text-danger' }}">
                    {{ number_format($data13_reyno['cumplimiento'], 2, ',', '.') }}%
                </span>
                <small><br>Aporte: @numero($data13_reyno['aporte'])%</small>
            </td>
            <td class="text-right">{{ number_format($data13_reyno['numerador_12a'], 0, ',', '.') }}</td>
            <td class="text-right">
              @if($data13_reyno['numerador'] != NULL)
                {{ number_format($data13_reyno['numerador'], 0, ',', '.') }}
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
              @if($data13_reyno['numerador_6'] != NULL)
                {{ number_format($data13_reyno['numerador_6'], 0, ',', '.') }}
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
              @if($data13_reyno['numerador_12'] != NULL)
                {{ number_format($data13_reyno['numerador_12'], 0, ',', '.') }}
              @else
                {{ number_format(0, 0, ',', '.') }}
              @endif
            </td>
        </tr>
        <tr>
            <td class="text-left">
                {{ $data13_reyno['label']['denominador'] }}
                <span class="badge badge-secondary">
                    {{ $data13_reyno['label']['fuente']['denominador'] }}
                </span>
            </td>
            <td class="text-right">{{ number_format($data13_reyno['denominador_12a'], 0, ',', '.') }}</td>
            <td class="text-right">
              @if($data13_reyno['denominador'] != NULL)
                {{ number_format($data13_reyno['denominador'], 0, ',', '.') }}
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
              @if($data13_reyno['denominador_6'] != NULL)
                {{ number_format($data13_reyno['denominador_6'], 0, ',', '.') }}
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
              @if($data13_reyno['denominador_12'] != NULL)
                {{ number_format($data13_reyno['denominador_12'], 0, ',', '.') }}
              @else
                {{ number_format(0, 0, ',', '.') }}
              @endif
            </td>
        </tr>
    </tbody>
</table>

<h5 class="mb-3">{{ $data18_reyno['label']['meta'] }}</h5>

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
                {{ $data18_reyno['label']['numerador'] }}
                <span class="badge badge-secondary">
                    {{ $data18_reyno['label']['fuente']['numerador'] }}
                </span>
            </td>
            <td rowspan="2" class="align-middle text-center">{{ $data18_reyno['meta'] }}</td>
            <td rowspan="2" class="align-middle text-center">
                {{ $data18_reyno['ponderacion'] }}
            </td>
            <td rowspan="2" class="align-middle text-center">
                <span class="{{ ($data18_reyno['cumplimiento'] >= preg_replace("/[^0-9]/", '', $data18_reyno['meta'])) ? 'text-success':'text-danger' }}">
                {{ number_format($data18_reyno['cumplimiento'], 2, ',', '.') }}%
                </span>
                <small><br>Aporte: @numero($data18_reyno['aporte'])%</small>
            </td>
            <td class="text-right">{{ number_format($data18_reyno['numerador_acumulado'],0, ',', '.') }}</td>
            @foreach($data18_reyno['numeradores'] as $numerador)
                <td class="text-right">{{ number_format($numerador, 0, ',', '.') }}</td>
            @endforeach
        </tr>
        <tr>
            <td class="text-left">
                {{ $data18_reyno['label']['denominador'] }}
                <span class="badge badge-secondary">
                    {{ $data18_reyno['label']['fuente']['denominador'] }}
                </span>
            </td>
            <td class="text-right">{{ number_format($data18_reyno['denominador_acumulado'],0, ',', '.') }}</td>
            @foreach($data18_reyno['denominadores'] as $denominador)
                <td class="text-right">{{ number_format($denominador, 0, ',', '.') }}</td>
            @endforeach
        </tr>
    </tbody>
</table>

<h5 class="mb-3">{{ $data31_reyno['label']['meta'] }}</h5>

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
                {{ $data31_reyno['label']['numerador'] }}
                <span class="badge badge-secondary">
                    {{ $data31_reyno['label']['fuente']['numerador'] }}
                </span>
            </td>
            <td rowspan="2" class="align-middle text-center">{{ $data31_reyno['meta'] }}</td>
            <td rowspan="2" class="align-middle text-center">
                {{ $data31_reyno['ponderacion'] }}
            </td>
            <td rowspan="2" class="align-middle text-center">
                <span class="{{ ($data31_reyno['cumplimiento'] >= preg_replace("/[^0-9]/", '', $data31_reyno['meta'])) ? 'text-success':'text-danger' }}">
                    {{ number_format($data31_reyno['cumplimiento'], 2, ',', '.') }}%
                </span>
                <small><br>Aporte: @numero($data31_reyno['aporte'])%</small>
            </td>
            <td class="text-right">{{ number_format($data31_reyno['numerador_acumulado'],0, ',', '.') }}</td>
            <td class="text-right" colspan="{{ $data31_reyno['vigencia'] }}">{{ number_format($data31_reyno['numerador_acumulado'],0, ',', '.') }}</td>
        </tr>
        <tr>
            <td class="text-left">
                {{ $data31_reyno['label']['denominador'] }}
                <span class="badge badge-secondary">
                    {{ $data31_reyno['label']['fuente']['denominador'] }}
                </span>
            </td>
            <td class="text-right">{{ number_format($data31_reyno['denominador_acumulado'],0, ',', '.') }}</td>
            <td class="text-right" colspan="12">{{ number_format($data31_reyno['denominador_acumulado'],0, ',', '.') }}</td>
        </tr>
    </tbody>
</table>

@endsection

@section('custom_js')

@endsection
