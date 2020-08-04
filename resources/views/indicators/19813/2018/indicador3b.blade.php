@extends('layouts.app')

@section('title', 'Ley 19813')

@section('content')

@include('indicators.partials.nav')

<h3 class="mb-3">{{ $label['meta'] }}</h3>

<!-- Nav tabs -->
<ul class="nav nav-tabs" id="myTab" role="tablist">
    @foreach($data as $nombre_comuna => $comuna)
    <li class="nav-item">
        <a class="nav-link" data-toggle="tab" role="tab" aria-selected="true"
            href="#{{ str_replace(" ","_",$nombre_comuna) }}">{{$nombre_comuna}}
        </a>
    </li>
    @endforeach
</ul>

<!-- Tab panes -->
<div class="tab-content mt-3">

    @foreach($data as $nombre_comuna => $comuna)

        <div class="tab-pane" id="{{ str_replace(" ","_",$nombre_comuna) }}" role="tabpanel" >

            <h4>{{ $nombre_comuna }}</h4>

            <table class="table table-sm table-bordered small">

                <thead>
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
                    <tr class="text-center">
                        <td class="text-left">{{ $label['numerador'] }}</td>
                        <td rowspan="2" class="align-middle">{{ $comuna['meta'] }}</td>
                        <td rowspan="2" class="align-middle">{{ number_format($comuna['cumplimiento'], 2, ',', '.') }}%</td>
                        @foreach($comuna['numeradores'] as $numerador)
                            <td class="text-right">{{ number_format($numerador, 0, ',', '.') }}</td>
                        @endforeach
                    </tr>
                    <tr class="text-center">
                        <td class="text-left">{{ $label['denominador'] }}</td>
                        @foreach($comuna['denominadores'] as $denominador)
                            <td class="text-right">{{ number_format($denominador, 0, ',', '.') }}</td>
                        @endforeach
                    </tr>
                </tbody>
            </table>

            <hr class="mt-5 mb-4" >
            @foreach($comuna as $nombre_establecimiento => $establecimiento)
                @if($nombre_establecimiento != 'numeradores' AND
                    $nombre_establecimiento != 'denominadores' AND
                    $nombre_establecimiento != 'meta' AND
                    $nombre_establecimiento != 'cumplimiento')

                    <strong> {{ $nombre_establecimiento }} </strong>

                    <table class="table table-sm table-bordered small">
                        <thead>
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
                            <tr class="text-center">
                                <td class="text-left">{{ $label['numerador'] }}</td>
                                <td rowspan="2" class="align-middle"></td>
                                <td rowspan="2" class="align-middle">{{ number_format($establecimiento['cumplimiento'], 2, ',', '.') }}%</td>

                                @foreach($establecimiento['numeradores'] as $numerador)
                                    <td class="text-right">{{ number_format($numerador, 0, ',', '.') }}</td>
                                @endforeach
                            </tr>
                            <tr class="text-center">
                                <td class="text-left">{{ $label['denominador'] }}</td>
                                @foreach($establecimiento['denominadores'] as $denominador)
                                    <td class="text-right">{{ number_format($denominador, 0, ',', '.') }}</td>
                                @endforeach
                            </tr>
                        </tbody>

                    </table>
                @endif
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
