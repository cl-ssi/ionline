@extends('layouts.app')

@section('title', 'Ley 19664')

@section('content')

@include('indicators.partials.nav')

@foreach($data4 as $nombre_comuna => $comuna)
  <h3 class="mb-3">{{ $nombre_comuna }}</h3>
@endforeach


    @foreach($data4 as $nombre_comuna => $comuna)
        <h4></h4>
        <h5 class="mb-3">{{ $label4['meta'] }}</h5>

        <table class="table table-sm table-bordered small">

            <thead>
                <tr class="text-center">
                    <!--<th>Nombre de la Meta</th>-->
                    <th>Indicador</th>
                    <th nowrap>Meta</th>
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
                  <td class="text-left">{{ $label4['numerador'] }}</td>
                  <td rowspan="2" class="align-middle text-center">{{ $comuna['meta'] }}</td>
                  <td rowspan="2" class="align-middle text-center">{{ number_format($comuna['cumplimiento'], 2, ',', '.') }}%</td>
                  @foreach($comuna['numeradores'] as $numerador)
                      <td class="text-right">{{ number_format($numerador, 0, ',', '.') }}</td>
                  @endforeach
              </tr>
              <tr>
                  <td class="text-left">{{ $label4['denominador'] }}</td>
                  @foreach($comuna['denominadores'] as $denominador)
                      <td class="text-right">{{ number_format($denominador, 0, ',', '.') }}</td>
                  @endforeach
              </tr>
            </tbody>
        </table>
    @endforeach
@endsection

@section('custom_js')

@endsection
