@extends('layouts.app')

@section('title', 'Más Adultos Mayores Autovalentes')

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
          <h4>{{ $nombre_comuna }}</h4>
          @foreach($comuna as $ind => $indicador)

            <table class="table table-sm table-bordered small">

                <thead>
                    <tr class="text-left">
                        <th colspan="16">{{ $label[$ind]['meta'] }}</th>
                    </tr>
                    <tr class="text-center">
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
                        <td class="text-left glosa">
                          {{ $label[$ind]['numerador'] }}
                          <span class="badge badge-secondary">
                              {{ $label[$ind]['fuente_numerador'] }}
                          </span>
                        </td>
                        <td rowspan="2" class="align-middle">{{ $indicador['meta'] }}</td>
                        <td rowspan="2" class="align-middle">
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
                        @if($ind == 3)
                          @foreach($indicador['denominadores'] as $denominador)
                              <td class="text-right">{{ number_format($denominador, 0, ',', '.') }}</td>
                              <td class="text-center" colspan="12">{{ number_format($denominador, 0, ',', '.') }}</td>
                          @endforeach
                        @else
                          @foreach($indicador['denominadores'] as $denominador)
                              <td class="text-right">{{ number_format($denominador, 0, ',', '.') }}</td>
                          @endforeach
                        @endif
                    </tr>
                </tbody>
            </table>
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
