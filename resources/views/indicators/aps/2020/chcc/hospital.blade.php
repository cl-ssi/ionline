@extends('layouts.app')

@section('title', 'ChCC')

@section('content')

@include('indicators.partials.nav')

<style>
    .glosa {
        width: 400px;
    }
</style>

<h3 class="mb-3">{{ $label['programa'] }}</h3>

<h5 class="mb-3">Hospital Dr. Ernesto Torres G.</h5>

@foreach($data_hosp2020 as $ind => $indicador)
    <table class="table table-sm table-bordered small">

        <thead>
            <tr class="text-left">
                <th colspan="17">
                    {{ $label[$ind]['indicador'] }}
                </th>
            </tr>
            <tr class="text-center">
                <th>Indicador</th>
                <th nowrap>Meta</th>
                <th nowrap>Ponderación</th>
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
                  {{ $label[$ind]['numerador'] }}
                  <span class="badge badge-secondary">
                      {{ $label[$ind]['fuente_numerador'] }}
                  </span>
                </td>
                <td rowspan="2" class="align-middle text-center">{{ $label[$ind]['meta'] }}</td>
                <td rowspan="2" class="align-middle text-center">{{ $label[$ind]['ponderacion'] }}</td>
                <td rowspan="2" class="align-middle text-center">
                  @if($ind == 4)
                    {{ number_format($indicador['cumplimiento'], 2, ',', '.') }}
                  @else
                    {{ number_format($indicador['cumplimiento'], 2, ',', '.') }}%
                  @endif
                </td>
                @foreach($indicador['numeradores'] as $numerador)
                    <td class="text-right">{{ number_format($numerador, 0, ',', '.') }}</td>
                @endforeach
            </tr>
            <tr>
                <td class="text-left">
                  {{ $label[$ind]['denominador'] }}
                  <span class="badge badge-secondary">
                      {{ $label[$ind]['fuente_denominador'] }}
                  </span>
                </td>
                @foreach($indicador['denominadores'] as $denominador)
                    <td class="text-right">{{ number_format($denominador, 0, ',', '.') }}</td>
                @endforeach
            </tr>
        </tbody>

    </table>
@endforeach

@endsection

@section('custom_js')

@endsection

@section('custom_js_head')

@endsection
