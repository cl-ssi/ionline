@extends('layouts.app')

@section('title', 'Programacion APS')

@section('content')

@include('indicators.partials.nav')

@php( $months = array (1=>'Ene',2=>'Feb',3=>'Mar',4=>'Abr',5=>'May',6=>'Jun',7=>'Jul',8=>'Ago',9=>'Sep',10=>'Oct',11=>'Nov') )

<h3 class="mb-3">Programacion APS</h3>

{{--<a href="{{ route('indicators.program_aps.2020.create', $id) }}" class="btn btn-primary">Agregar valor</a>--}}

<!-- Nav tabs -->
<ul class="nav nav-tabs d-print-none">
    @foreach($communes as $commune)
    <li class="nav-item">
        <a class="nav-link @if($commune->id == $id) active @endif"
            href="{{ route('indicators.program_aps.2020.index', $commune->id) }}">{{$commune->name}}
        </a>
    </li>
    @endforeach
    <li class="nav-item">
        <a class="nav-link @if($id == 0) active @endif"
            href="{{ route('indicators.program_aps.2020.index', 0) }}"> RESUMEN
        </a>
    </li>
</ul>

<!-- Tab panes -->
<div class="tab-content mt-3">
@if($id != 0)
    @foreach($communes as $commune)
        @if($commune->id == $id)
        
            <h4>
                <button type="button" class="btn btn-outline-info btn-sm"
                    onclick="tableToExcel('tabla_{{ str_replace(" ","_",$commune->name) }}', 'Hoja 1')">
                    <i class="fas fa-download"></i>
                </button>
                {{ $commune->name }}
            </h4>


            <table class="table table-bordered table-hover table-sm small" id="tabla_{{ str_replace(" ","_",$commune->name) }}" >
                <thead>
                    <tr>
                        <th>N°</th>
                        <th>Nivel</th>
                        <th>Prestaciones</th>
                        <th>Población a atender</th>
                        <!-- <th nowrap>N° Pobl.</th>
                        <th nowrap>% Cob.</th>
                        <th>Conc.</th> -->
                        <th>Actividades Programadas</th>
                        <!-- <th>Prof.</th>
                        <th>Rend.</th> -->
                        <th>Verificación</th>
                        <th>Obs.</th>
                        @foreach($months as $month)
                            <th>{{$month}}</th>
                        @endforeach
                        <th nowrap>Acum</th>
                        <th nowrap>% Avance</th>


                    </tr>
                </thead>
                <tbody>
                @foreach($glosas as $index => $glosa)
                    <tr>
                        <td class="text-right">
                            {{--@auth
                            <a href="{{ route('indicators.program_aps.2020.edit', [$glosa->id,$commune->id]) }}">
                            @endauth --}}
                            {{ $glosa->numero }}
                            {{--@auth
                            </a>
                            @endauth--}}
                        </td>
                        <td>{{ $glosa->nivel }}</td>
                        <td>{{ $glosa->prestacion }}</td>
                        <td>{{ $glosa->poblacion }}</td>
                        {{--<td class="text-right">{{ $data[$commune->name][$glosa->numero]['poblacion'] }}</td>
                        <td class="text-right">{{ $data[$commune->name][$glosa->numero]['cobertura'] }}%</td>
                        <td class="text-right">{{ $data[$commune->name][$glosa->numero]['concentracion'] }}</td> --}}
                        <td class="text-right">{{ $data[$commune->name][$glosa->numero]['actividadesProgramadas'] }}</td>
                        {{-- <td>{{ $glosa->profesional }}</td>
                        <td class="text-right">{{ $data[$commune->name][$glosa->numero]['observadoAnterior'] }}</td>
                        <td class="text-right">{{ $data[$commune->name][$glosa->numero]['rendimientoProfesional'] }}</td> --}}
                        <td>{{ $glosa->verificacion }}</td>
                        <td>{{ $data[$commune->name][$glosa->numero]['observaciones'] }}</td>
                        @foreach($months as $index => $month)
                            <td class="text-right">{{$data[$commune->name][$glosa->numero]['numeradores'][$index]}}</td>
                        @endforeach
                        <td class="text-right">{{ $data[$commune->name][$glosa->numero]['ct_marzo'] }}</td>
                        <td class="text-right">{{ $data[$commune->name][$glosa->numero]['porc_marzo'] }}{{ $data[$commune->name][$glosa->numero]['porc_marzo'] ? '%' : '' }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>

        </div>
        @endif
    @endforeach
@else
    <h4>
        <button type="button" class="btn btn-outline-info btn-sm"
            onclick="tableToExcel('tabla_resumen', 'Hoja 1')">
            <i class="fas fa-download"></i>
        </button>
        RESUMEN
    </h4>

    <table class="table table-bordered table-hover table-sm small" id="tabla_resumen" >
        <thead>
            <tr>
                <th>N°</th>
                <th>Nivel</th>
                <th>Prestaciones</th>
                <th>Numerador</th>
                <th>Denominador</th>
                <th>Cobertura</th>
            </tr>
        </thead>
        <tbody>
            @foreach($glosas as $glosa)
            <tr>
                <td>{{ $glosa->numero }}</td>
                <td>{{ $glosa->nivel }}</td>
                <td>{{ $glosa->prestacion }}</td>
                <td class="text-right">{{ $data[$glosa->numero]['total_numerador'] }}</td>
                <td class="text-right">{{ $data[$glosa->numero]['total_denominador'] }}</td>
                <td class="text-right">{{ $data[$glosa->numero]['total_cobertura'] }}%</td>
            </tr>
            @endforeach
        </tbody>
    </table>
@endif 

@endsection

@section('custom_js')
<script type="text/javascript">
var tableToExcel = (function() {
    var uri = 'data:application/vnd.ms-excel;base64,'
    , template = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><head><meta http-equiv="Content-Type" content="text/html;charset=utf-8"></head><body><table>{table}</table></body></html>'
    , base64 = function(s) { return window.btoa(unescape(encodeURIComponent(s))) }
    , format = function(s, c) { return s.replace(/{(\w+)}/g, function(m, p) { return c[p]; }) }
    return function(table, name) {
    if (!table.nodeType) table = document.getElementById(table)
    var ctx = {worksheet: name || 'Worksheet', table: table.innerHTML}
    window.location.href = uri + base64(format(template, ctx))
    }
})()
</script>

@endsection
