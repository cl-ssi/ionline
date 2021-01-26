@extends('layouts.app')

@section('title', 'Ley N° 18.834')

@section('content')

@include('indicators.partials.nav')

<h3 class="mb-3">SERVICIO DE SALUD IQUIQUE
    <small>
        - Cumplimiento : @numero(
           $data13['aporte'] +
           $data15['aporte'] +
           $data18['aporte'] +
           $data12['aporte'] +
           $data31['aporte'])%
    </small>
</h3>
<h6 class="mb-3">Metas Sanitarias Ley N° 18.834</h6>


<style>
    .glosa {
        width: 400px;
    }
</style>

<hr>
<!-- Tab panes -->


<h5 class="mb-3">{{ $data13['label']['meta'] }}</h5>

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
                {{ $data13['label']['numerador'] }}
                <span class="badge badge-secondary">
                    {{ $data13['label']['fuente']['numerador'] }}
                </span>
            </td>
            <td rowspan="2" class="align-middle text-center">≥{{ $data13['meta'] }}%</td>
            <td rowspan="2" class="align-middle text-center">
                {{ $data13['ponderacion'] }}
            </td>
            <td rowspan="2" class="align-middle text-center">
                <span class="{{ ($data13['cumplimiento'] >= preg_replace("/[^0-9]/", '', $data13['meta'])) ? 'text-success':'text-danger' }}">
                {{ number_format($data13['cumplimiento'], 2, ',', '.') }}%
                </span>
                <small><br>Aporte: {{ number_format($data13['aporte'], 2, ',', '.') }}%</small>
            </td>
            <td class="text-right">{{ number_format($data13['numerador_12a'], 0, ',', '.') }}</td></td>
            <td class="text-right">
            @if($data13['numerador'] == NULL)
              {{ number_format(0, 0, ',', '.') }}</td>
            @else
              {{ number_format($data13['numerador'], 0, ',', '.') }}</td>
            @endif
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td class="text-right">
              @if($data13['numerador_6'] == NULL)
                {{ number_format(0, 0, ',', '.') }}</td>
              @else
                {{ number_format($data13['numerador_6'], 0, ',', '.') }}</td>
              @endif
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td class="text-right">
              @if($data13['numerador_12'] == NULL)
                {{ number_format(0, 0, ',', '.') }}</td>
              @else
                {{ $data13['numerador_12'] }}</td>
              @endif
        </tr>
        <tr>
            <td class="text-left">
                {{ $data13['label']['denominador'] }}
                <span class="badge badge-secondary">
                    {{ $data13['label']['fuente']['denominador'] }}
                </span>
            </td>
            <td class="text-right">{{ number_format($data13['denominador_12a'], 0, ',', '.') }}</td></td>
            <td class="text-right">
              @if($data13['denominador'] == NULL)
                {{ number_format(0, 0, ',', '.') }}</td>
              @else
                {{ number_format($data13['denominador'], 0, ',', '.') }}</td>
              @endif
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td class="text-right">
              @if($data13['denominador_6'] == NULL)
                {{ number_format(0, 0, ',', '.') }}</td>
              @else
                {{ number_format($data13['denominador_6'], 0, ',', '.') }}
              @endif
            </td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td class="text-right">
              @if($data13['denominador_12'] == NULL)
                {{ number_format(0, 0, ',', '.') }}</td>
              @else
                {{ $data13['denominador_12'] }}
              @endif
            </td>
        </tr>
    </tbody>
</table>



<h5 class="mb-3">{{ $data15['label']['meta'] }}</h5>

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
                {{ $data15['label']['numerador'] }}
                <span class="badge badge-secondary">
                    {{ $data15['label']['fuente']['numerador'] }}
                </span>
            </td>
            <td rowspan="2" class="align-middle text-center">≥{{ $data15['meta'] }}%</td>
            <td rowspan="2" class="align-middle text-center">
                {{ $data15['ponderacion'] }}
            </td>
            <td rowspan="2" class="align-middle text-center">
                <span class="{{ ($data15['cumplimiento'] >= preg_replace("/[^0-9]/", '', $data15['meta'])) ? 'text-success':'text-danger' }}">
                {{ number_format($data15['cumplimiento'], 2, ',', '.') }}%
                </span>
                <small><br>Aporte: @numero($data15['aporte'])%</small>
            </td>
            <td class="text-right">{{ number_format($data15['numerador_acumulado'], 0, ',', '.') }}</td>
            @foreach($data15['numeradores'] as $numerador)
                <td class="text-right">{{ number_format($numerador, 0, ',', '.') }}</td>
            @endforeach
        </tr>
        <tr>
            <td class="text-left">
                {{ $data15['label']['denominador'] }}
                <span class="badge badge-secondary">
                    {{ $data15['label']['fuente']['denominador'] }}
                </span>
            </td>

            <td class="text-right">{{ number_format($data15['denominador'], 0, ',', '.') }}</td>

            <td class="text-center" colspan="12">{{ number_format($data15['denominador'], 0, ',', '.') }}</td>
        </tr>
    </tbody>
</table>

<h5 class="mb-3">{{ $data18['label']['meta'] }}</h5>

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
                {{ $data18['label']['numerador'] }}
                <span class="badge badge-secondary">
                    {{ $data18['label']['fuente']['numerador'] }}
                </span>
            </td>
            <td rowspan="2" class="align-middle text-center">≥{{ $data18['meta'] }}%</td>
            <td rowspan="2" class="align-middle text-center">
                {{ $data18['ponderacion'] }}
            </td>
            <td rowspan="2" class="align-middle text-center">
                <span class="{{ ($data18['cumplimiento'] >= $data18['meta']) ? 'text-success':'text-danger' }}">
                {{ number_format($data18['cumplimiento'], 2, ',', '.') }}%
                </span>
                <small><br>Aporte: {{ number_format($data18['aporte'], 2, ',', '.') }}%</small>
            </td>
            <td class="text-right">{{ number_format($data18['numerador_acumulado'],0, ',', '.') }}</td>
            @foreach($data18['numeradores'] as $numerador)
                <td class="text-right">{{ number_format($numerador, 0, ',', '.') }}</td>
            @endforeach
        </tr>
        <tr>
            <td class="text-left">
                {{ $data18['label']['denominador'] }}
                <span class="badge badge-secondary">
                    {{ $data18['label']['fuente']['denominador'] }}
                </span>
            </td>
            <td class="text-right">{{ number_format($data18['denominador_acumulado'],0, ',', '.') }}</td>
            @foreach($data18['denominadores'] as $denominador)
                <td class="text-right">{{ number_format($denominador, 0, ',', '.') }}</td>
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
                <span class="{{ ($data12['cumplimiento'] >= preg_replace("/[^0-9]/", '', $data12['meta'])) ? 'text-success':'text-danger' }}">
                    {{ number_format($data12['cumplimiento'], 2, ',', '.') }}%
                </span>
                <small><br>Aporte: {{ number_format($data12['aporte'], 2, ',', '.') }}%</small>
            </td>
            <td class="text-right">{{ number_format($data12['numerador_12a'], 0, ',', '.') }}</td>
            <td class="text-right">
              @if($data12['numerador'] == NULL)
                {{ number_format(0, 0, ',', '.') }}</td>
              @else
                {{ number_format($data12['numerador'], 0, ',', '.') }}</td>
              @endif
            </td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td class="text-right">
              @if($data12['numerador_6'] == NULL)
                {{ number_format(0, 0, ',', '.') }}</td>
              @else
                {{ number_format($data12['numerador_6'], 0, ',', '.') }}</td>
              @endif
            </td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td class="text-right">
              @if($data12['numerador_12'] == NULL)
                {{ number_format(0, 0, ',', '.') }}</td>
              @else
                {{ number_format($data12['numerador_12'], 0, ',', '.') }}</td>
              @endif
            </td>
        </tr>
        <tr>
            <td class="text-left">
                {{ $data12['label']['denominador'] }}
                <span class="badge badge-secondary">
                    {{ $data12['label']['fuente']['denominador'] }}
                </span>
            </td>
            <td class="text-right">{{ number_format($data12['denominador_12a'], 0, ',', '.') }}</td>
            <td class="text-right">
              @if($data12['denominador'] == NULL)
                {{ number_format(0, 0, ',', '.') }}</td>
              @else
                {{ number_format($data12['denominador'], 0, ',', '.') }}</td>
              @endif
            </td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td class="text-right">
              @if($data12['denominador_6'] == NULL)
                {{ number_format(0, 0, ',', '.') }}</td>
              @else
                {{ number_format($data12['denominador_6'], 0, ',', '.') }}</td>
              @endif
            </td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td class="text-right">
              @if($data12['denominador_12'] == NULL)
                {{ number_format(0, 0, ',', '.') }}</td>
              @else
                {{ number_format($data12['denominador_12'], 0, ',', '.') }}</td>
              @endif
            </td>
        </tr>
    </tbody>
</table>

<h5 class="mb-3">{{ $data31['label']['meta'] }}</h5>

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
                {{ $data31['label']['numerador'] }}
                <span class="badge badge-secondary">
                    {{ $data31['label']['fuente']['numerador'] }}
                </span>
            </td>
            <td rowspan="2" class="align-middle text-center">≥{{ $data31['meta'] }}%</td>
            <td rowspan="2" class="align-middle text-center">
                {{ $data31['ponderacion'] }}
            </td>
            <td rowspan="2" class="align-middle text-center">
                <span class="{{ ($data31['cumplimiento'] >= preg_replace("/[^0-9]/", '', $data31['meta'])) ? 'text-success':'text-danger' }}">
                    {{ number_format($data31['cumplimiento'], 2, ',', '.') }}%
                </span>
                <small><br>Aporte: @numero($data31['aporte'])%</small>
            </td>
            <td class="text-right">{{ number_format($data31['numerador_acumulado'],0, ',', '.') }}</td>
            <td class="text-right" colspan="{{ $data31['vigencia'] }}">{{ number_format($data31['numerador_acumulado'],0, ',', '.') }}</td>
        </tr>
        <tr>
            <td class="text-left">
                {{ $data31['label']['denominador'] }}
                <span class="badge badge-secondary">
                    {{ $data31['label']['fuente']['denominador'] }}
                </span>
            </td>
            <td class="text-right">{{ number_format($data31['denominador_acumulado'],0, ',', '.') }}</td>
            <td class="text-right" colspan="12">{{ number_format($data31['denominador_acumulado'],0, ',', '.') }}</td>
        </tr>
    </tbody>
</table>

@endsection

@section('custom_js')

@endsection
