@extends('layouts.app')

@section('title', 'Dependencia Severa')

@section('content')

@include('indicators.partials.nav')

<style>
    .glosa {
        width: 400px;
    }
</style>

<h3 class="mb-3">{{ $label['programa'] }}</h3>

<!-- Nav tabs -->
<ul class="nav nav-tabs d-print-none" id="myTab" role="tablist">
  @foreach($data2020 as $nombre_comuna => $comuna)
    <li class="nav-item">
        <a class="nav-link" data-toggle="tab" role="tab" aria-selected="true"
            href="#{{ str_replace(" ","_",$nombre_comuna) }}">{{$nombre_comuna}}
        </a>
    </li>
  @endforeach
</ul>

<!-- Tab panes -->
<div class="tab-content mt-3">
    @foreach($data2020 as $nombre_comuna => $comuna)

        <div class="tab-pane" id="{{ str_replace(" ","_",$nombre_comuna) }}" role="tabpanel" >
          <h4>{{ $nombre_comuna }}
            <small><button class="btn btn-primary btn-sm" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
              <i class="fas fa-search-plus"></i>
            </button></small>
          </h4>
          @foreach($comuna as $ind => $indicador)

            <table class="table table-sm table-bordered small">

                <thead>
                    <tr class="text-left">
                        <th colspan="17">
                            {{ $label[$ind]['meta'] }}
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
                        <td rowspan="2" class="align-middle text-center">{{ $indicador['meta'] }}</td>
                        <td rowspan="2" class="align-middle text-center">{{ $label[$ind]['ponderacion'] }}</td>
                        <td rowspan="2" class="align-middle text-center">
                          @if($ind == 3)
                            -
                          @else
                            {{ number_format($indicador['cumplimiento'], 2, ',', '.') }}%
                          @endif
                        </td>
                        @if($ind == 1 || $ind == 2 ||
                            $ind == 3 || $ind == 6 ||
                            $ind == 7)
                            @foreach($indicador['numeradores'] as $numerador)
                                <td class="text-right">{{ number_format($numerador, 0, ',', '.') }}</td>
                            @endforeach
                        @else
                            <td class="text-right">{{ number_format($indicador['numerador'], 0, ',', '.') }}</td>
                            <td class="text-right"></td>
                            <td class="text-right"></td>
                            <td class="text-right"></td>
                            <td class="text-right"></td>
                            <td class="text-right"></td>
                            <td class="text-right">{{ number_format($indicador['numerador_6'], 0, ',', '.') }}</td>
                            <td class="text-right"></td>
                            <td class="text-right"></td>
                            <td class="text-right"></td>
                            <td class="text-right"></td>
                            <td class="text-right"></td>
                            <td class="text-right">{{ number_format($indicador['numerador_12'], 0, ',', '.') }}</td>
                        @endif
                    </tr>
                    <tr>
                        <td class="text-left">
                          {{ $label[$ind]['denominador'] }}
                          <span class="badge badge-secondary">
                              {{ $label[$ind]['fuente_denominador'] }}
                          </span>
                        </td>
                          <!-- PENDIENTE -->
                        <td class="text-right">{{ number_format($indicador['denominador'], 0, ',', '.') }}</td>
                        <td class="text-right"></td>
                        <td class="text-right"></td>
                        <td class="text-right"></td>
                        <td class="text-right"></td>
                        <td class="text-right"></td>
                        <td class="text-right">{{ number_format($indicador['denominador_6'], 0, ',', '.') }}</td>
                        <td class="text-right"></td>
                        <td class="text-right"></td>
                        <td class="text-right"></td>
                        <td class="text-right"></td>
                        <td class="text-right"></td>
                        <td class="text-right">{{ number_format($indicador['denominador_12'], 0, ',', '.') }}</td>
                    </tr>
                </tbody>
            </table>

            <div class="collapse" id="collapseExample">
                <div class="card card-body">
                    <!-- <hr class="mt-5 mb-4" > -->
                    @foreach($indicador as $nombre_establecimiento => $establecimiento)
                        @if($nombre_establecimiento != 'numeradores' AND
                            $nombre_establecimiento != 'numerador' AND
                            $nombre_establecimiento != 'numerador_a' AND
                            $nombre_establecimiento != 'numerador_6' AND
                            $nombre_establecimiento != 'numerador_12' AND
                            $nombre_establecimiento != 'denominadores' AND
                            $nombre_establecimiento != 'denominador' AND
                            $nombre_establecimiento != 'denominador_a' AND
                            $nombre_establecimiento != 'denominador_6' AND
                            $nombre_establecimiento != 'denominador_12' AND
                            $nombre_establecimiento != 'meta' AND
                            $nombre_establecimiento != 'cumplimiento')

                            <strong> {{ $nombre_establecimiento }} </strong>

                            <table class="table table-sm table-bordered small">
                                <thead>
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
                                        <td class="text-left glosa">{{ $label[$ind]['numerador'] }}</td>
                                        <td rowspan="2" class="align-middle"></td>
                                        <td rowspan="2" class="align-middle text-center">{{ $label[$ind]['ponderacion'] }}</td>
                                        <td rowspan="2" class="align-middle">
                                          @if($ind == 3)
                                            -
                                          @else
                                              {{ number_format($establecimiento['cumplimiento'], 2, '.', '') }}%
                                          @endif
                                        </td>
                                          @if($ind == 1 || $ind == 2 ||
                                              $ind == 3 || $ind == 6 ||
                                              $ind == 7)
                                              @foreach($establecimiento['numeradores'] as $numerador)
                                                  <td class="text-right">{{ number_format($numerador, 0, ',', '.') }}</td>
                                              @endforeach
                                          @else
                                              <td class="text-right">{{ number_format($establecimiento['numerador'], 0, ',', '.') }}</td>
                                              <td class="text-right"></td>
                                              <td class="text-right"></td>
                                              <td class="text-right"></td>
                                              <td class="text-right"></td>
                                              <td class="text-right"></td>
                                              <td class="text-right">{{ number_format($establecimiento['numerador_6'], 0, ',', '.') }}</td>
                                              <td class="text-right"></td>
                                              <td class="text-right"></td>
                                              <td class="text-right"></td>
                                              <td class="text-right"></td>
                                              <td class="text-right"></td>
                                              <td class="text-right">{{ number_format($establecimiento['numerador_12'], 0, ',', '.') }}</td>
                                          @endif
                                    </tr>
                                    <tr>
                                        <td class="text-left">{{ $label[$ind]['denominador'] }}</td>
                                            <td class="text-right">{{ number_format($establecimiento['denominador'], 0, ',', '.') }}</td>
                                            <td class="text-right"></td>
                                            <td class="text-right"></td>
                                            <td class="text-right"></td>
                                            <td class="text-right"></td>
                                            <td class="text-right"></td>
                                            <td class="text-right">{{ number_format($establecimiento['denominador_6'], 0, ',', '.') }}</td>
                                            <td class="text-right"></td>
                                            <td class="text-right"></td>
                                            <td class="text-right"></td>
                                            <td class="text-right"></td>
                                            <td class="text-right"></td>
                                            <td class="text-right">{{ number_format($establecimiento['denominador_12'], 0, ',', '.') }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        @endif
                    @endforeach
                </div>
            </div>
            <br>
          @endforeach
        </div>
    @endforeach
</div>

@endsection

@section('custom_js')

<script type="text/javascript">
    $('#myTab a[href="#IQUIQUE"]').tab('show') // Select tab by name
</script>

@endsection

@section('custom_js_head')

@endsection
