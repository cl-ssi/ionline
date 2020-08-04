@extends('layouts.app')

@section('title', 'Ley N° 18.834')

@section('content')

@include('indicators.partials.nav')

<h3 class="mb-3">SERVICIO DE SALUD IQUIQUE
    <small>
        - Cumplimiento : @numero(
           $data13['aporte'] +
           $data14['aporte'] +
           $data17['aporte'] +
           $data18['aporte'] +
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
            <td rowspan="2" class="align-middle text-center">{{ $data13['meta'] }}</td>
            <td rowspan="2" class="align-middle text-center">
                {{ $data13['ponderacion'] }}
            </td>
            <td rowspan="2" class="align-middle text-center">
                <span class="{{ ($data13['cumplimiento'] >= preg_replace("/[^0-9]/", '', $data13['meta'])) ? 'text-success':'text-danger' }}">
                {{ number_format($data13['cumplimiento'], 2, ',', '.') }}%
                </span>
                <small><br>Aporte: @numero($data13['aporte'])%</small>
            </td>
            <td>{{ number_format($data13['numerador'], 0, ',', '.') }}</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td>{{ number_format($data13['numerador_6'], 0, ',', '.') }}</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td>{{ $data13['numerador_12'] }}</td>
        </tr>
        <tr>
            <td class="text-left">
                {{ $data13['label']['denominador'] }}
                <span class="badge badge-secondary">
                    {{ $data13['label']['fuente']['denominador'] }}
                </span>
            </td>
            <td>{{ number_format($data13['denominador'], 0, ',', '.') }}</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td>{{ number_format($data13['denominador_6'], 0, ',', '.') }}</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td>{{ $data13['denominador_12'] }}</td>
        </tr>
    </tbody>
</table>





<h5 class="mb-3">{{ $data14['label']['meta'] }}</h5>

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
                {{ $data14['label']['numerador'] }}
                <span class="badge badge-secondary">
                    {{ $data14['label']['fuente']['numerador'] }}
                </span>
            </td>
            <td rowspan="2" class="align-middle text-center">{{ $data14['meta'] }}</td>
            <td rowspan="2" class="align-middle text-center">
                {{ $data14['ponderacion'] }}
            </td>
            <td rowspan="2" class="align-middle text-center">
                <span class="{{ ($data14['cumplimiento'] >= preg_replace("/[^0-9]/", '', $data14['meta'])) ? 'text-success':'text-danger' }}">
                {{ number_format($data14['cumplimiento'], 2, ',', '.') }}%
                </span>
                <small><br>Aporte: @numero($data14['aporte'])%</small>
            </td>
            <td class="text-right">{{ number_format($data14['numerador_acumulado'], 0, ',', '.') }}</td>
            @foreach($data14['numeradores'] as $numerador)
                <td class="text-right">{{ number_format($numerador, 0, ',', '.') }}</td>
            @endforeach
        </tr>
        <tr>
            <td class="text-left">
                {{ $data14['label']['denominador'] }}
                <span class="badge badge-secondary">
                    {{ $data14['label']['fuente']['denominador'] }}
                </span>
            </td>

            <td class="text-right">{{ number_format($data14['denominador'], 0, ',', '.') }}</td>

            <td class="text-center" colspan="12">{{ number_format($data14['denominador'], 0, ',', '.') }}</td>
        </tr>
    </tbody>
</table>






    <h5 class="mb-3">{{ $data17['label']['meta'] }}</h5>

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
                    {{ $data17['label']['numerador'] }}
                    <span class="badge badge-secondary">
                        {{ $data17['label']['fuente']['numerador'] }}
                    </span>
                </td>
                <td rowspan="2" class="align-middle text-center">{{ $data17['meta'] }}</td>
                <td rowspan="2" class="align-middle text-center">
                    {{ $data17['ponderacion'] }}
                </td>
                <td rowspan="2" class="align-middle text-center">
                    <span class="{{ ($data17['cumplimiento'] >= preg_replace("/[^0-9]/", '', $data17['meta'])) ? 'text-success':'text-danger' }}">
                    {{ number_format($data17['cumplimiento'], 2, ',', '.') }}%
                    </span>
                    <small><br>Aporte: @numero($data17['aporte'])%</small>
                </td>
                <td class="text-right">{{ number_format($data17['numerador_acumulado'],0, ',', '.') }}</td>
                @foreach($data17['numeradores'] as $numerador)
                    <td class="text-right">{{ number_format($numerador, 0, ',', '.') }}</td>
                @endforeach
            </tr>
            <tr>
                <td class="text-left">
                    {{ $data17['label']['denominador'] }}
                    <span class="badge badge-secondary">
                        {{ $data17['label']['fuente']['denominador'] }}
                    </span>
                </td>
                <td class="text-right">{{ number_format($data17['denominador_acumulado'],0, ',', '.') }}</td>
                @foreach($data17['denominadores'] as $denominador)
                    <td class="text-right">{{ number_format($denominador, 0, ',', '.') }}</td>
                @endforeach
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
                <td rowspan="2" class="align-middle text-center">{{ $data18['meta'] }}</td>
                <td rowspan="2" class="align-middle text-center">
                    {{ $data18['ponderacion'] }}
                </td>
                <td rowspan="2" class="align-middle text-center">
                    <span class="{{ ($data18['cumplimiento'] >= preg_replace("/[^0-9]/", '', $data18['meta'])) ? 'text-success':'text-danger' }}">
                    {{ number_format($data18['cumplimiento'], 2, ',', '.') }}%
                    </span>
                    <small><br>Aporte: {{ number_format($data18['aporte'],1, ',', '.') }}%</small>
                </td>
                <td class="text-right">{{ number_format($data18['numerador_acumulado'],0, ',', '.') }}</td>
                <td colspan="{{ $data18['vigencia'] }}" class="text-right">
                    {{ number_format($data18['numerador_acumulado'],0, ',', '.') }}
                </td>
            </tr>
            <tr>
                <td class="text-left glosa">
                    {{ $data18['label']['denominador'] }}
                    <span class="badge badge-secondary">
                        {{ $data18['label']['fuente']['denominador'] }}
                    </span>
                </td>
                <td class="text-right">{{ number_format($data18['denominador_acumulado'],0, ',', '.') }}</td>
                <td colspan="12" class="text-center">
                    {{ number_format($data18['denominador_acumulado'],0, ',', '.') }}
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
                <td rowspan="2" class="align-middle text-center">{{ $data31['meta'] }}</td>
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
                <td class="text-left glosa">
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
