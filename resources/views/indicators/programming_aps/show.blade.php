@extends('layouts.app')
@php
    $months = array (1=>'Ene',2=>'Feb',3=>'Mar',4=>'Abr',5=>'May',6=>'Jun',7=>'Jul',8=>'Ago',9=>'Sep',10=>'Oct',11=>'Nov',12=>'Dic');
    $comuna = $commune_id != 0 ? $program_aps->communes[$commune_id] : 'RESUMEN';
@endphp
@section('title', $program_aps->name)

@section('content')

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('indicators.index') }}">Indicadores</a></li>
        <li class="breadcrumb-item"><a href="{{ route('indicators.programming_aps.index') }}">Porgramación APS {{$program_aps->year}}</a></li>
        <li class="breadcrumb-item">{{$comuna}}</li>
    </ol>
</nav>

<style>
    .glosa {
        width: 400px;
    }
</style>


<h3 class="mb-3">Programación APS</h3>

<!-- Nav tabs commune -->
<ul class="nav nav-tabs d-print-none">
    @foreach($program_aps->communes as $index => $commune)
    <li class="nav-item">
        <a class="nav-link @if($commune_id == $index) active @endif"
            href="{{ route('indicators.programming_aps.show', [$program_aps->year, $index]) }}">{{$commune}}
        </a>
    </li>
    @endforeach
    <li class="nav-item">
        <a class="nav-link @if($commune_id == 0) active @endif"
            href="{{ route('indicators.programming_aps.show', [$program_aps->year, 0]) }}"> RESUMEN
        </a>
    </li>
</ul>
</div> <!-- cierre div main content -->
<!-- Tab panes -->
@if($commune_id != 0)
<div class="tab-content m-3">
    <h4 class="mb-3">
        <button id="export" type="button" class="btn btn-outline-info btn-sm"
            onclick="tableToExcel('tabla_{{ str_replace(" ","_",$comuna) }}', 'Hoja 1')">
            <i class="fas fa-download"></i>
        </button>
        {{ $comuna }}
        @if(count($program_aps->establishments) > 0)
        <select name="establishment" id="establishment" class="form-control col-3 float-right">
                    <option value="{{ str_replace(" ","_",$comuna) }}">Todas</option>
                @foreach($program_aps->establishments as $establishment)
                    <option value="{{ preg_replace("/[\s.,-]+/","_",$establishment) }}">{{ $establishment }}</option>
                @endforeach
        </select>
        @endif
    </h4>
    <div class="table-responsive targetDiv" id="{{ str_replace(" ","_",$comuna) }}">
    <table class="table table-bordered table-hover table-sm small" id="tabla_{{ str_replace(" ","_",$comuna) }}" >
        <thead>
            <tr>
                <th>N°</th>
                <th>Nivel</th>
                <th>Prestaciones</th>
                <th>Población a atender</th>
                <th>Actividades Programadas</th>
                <th>Verificación</th>
                <th>Prof.</th>
                @foreach($months as $month)
                <th>{{$month}}</th>
                @endforeach
                <th nowrap>Acum</th>
                <th nowrap>% Avance</th>
            </tr>
        </thead>
        <tbody>
        @foreach($program_aps->tracers as $tracer)
            <tr>
                <td class="text-right">{{ $tracer->number }}</td>
                <td>{{ $tracer->level }}</td>
                <td>{{ $tracer->name }}</td>
                <td>{{ $tracer->population }}</td>
                <td class="text-right">{{ number_format($tracer->getValuesAcum2('denominador', $comuna, null), 0, ',', '.') }}</td>
                <td>{{ $tracer->numerator_source }}</td>
                <td>{{ $tracer->professional }}</td>
                @foreach($months as $number => $month)
                <td class="text-right">{{ $tracer->getValueByFactorAndMonth2('numerador', $number, $comuna, null) != null ? number_format($tracer->getValueByFactorAndMonth2('numerador', $number, $comuna, null), 0, ',', '.') : ''}}</td>
                @endforeach
                <td class="text-right">{{ number_format($tracer->getValuesAcum2('numerador', $comuna, null), 0, ',', '.') }}</td>
                <td class="text-right">{{ number_format($tracer->getCompliance2($comuna, null), 1, ',', '.')}}% </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    </div>
    <!-- Por establecimiento -->
    @foreach($program_aps->establishments as $establishment)
    <div class="table-responsive targetDiv" style="display:none" id="{{ preg_replace("/[\s.,-]+/","_",$establishment) }}">
    <table class="table table-bordered table-hover table-sm small" id="tabla_{{ preg_replace("/[\s.,-]+/","_",$establishment) }}" >
        <thead>
            <tr>
                <th>N°</th>
                <th>Nivel</th>
                <th>Prestaciones</th>
                <th>Población a atender</th>
                <th>Actividades Programadas</th>
                <th>Verificación</th>
                <th>Prof.</th>
                @foreach($months as $month)
                <th>{{$month}}</th>
                @endforeach
                <th nowrap>Acum</th>
                <th nowrap>% Avance</th>
            </tr>
        </thead>
        <tbody>
        @foreach($program_aps->tracers as $tracer)
            <tr>
                <td class="text-right">{{ $tracer->number }}</td>
                <td>{{ $tracer->level }}</td>
                <td>{{ $tracer->name }}</td>
                <td>{{ $tracer->population }}</td>
                <td class="text-right">{{ number_format($tracer->getValuesAcum2('denominador', null, $establishment), 0, ',', '.') }}</td>
                <td>{{ $tracer->numerator_source }}</td>
                <td>{{ $tracer->professional }}</td>
                @foreach($months as $number => $month)
                <td class="text-right">{{ $tracer->getValueByFactorAndMonth2('numerador', $number, null, $establishment) != null ? number_format($tracer->getValueByFactorAndMonth2('numerador', $number, null, $establishment), 0, ',', '.') : ''}}</td>
                @endforeach
                <td class="text-right">{{ number_format($tracer->getValuesAcum2('numerador', null, $establishment), 0, ',', '.') }}</td>
                <td class="text-right">{{ number_format($tracer->getCompliance2(null, $establishment), 1, ',', '.')}}% </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    </div>
    @endforeach
</div>
@else
<div class="tab-content m-3">
    <h4 class="mb-3">
        <button type="button" class="btn btn-outline-info btn-sm"
            onclick="tableToExcel('tabla_resumen', 'Hoja 1')">
            <i class="fas fa-download"></i>
        </button>
        RESUMEN
    </h4>

    <div class="table-responsive">
    <table class="table table-bordered table-hover table-sm small" id="tabla_resumen" >
        <thead>
            <tr>
                <th>N°</th>
                <th>Nivel</th>
                <th>Prestaciones</th>
                <th>Población a atender</th>
                <th>Actividades Programadas</th>
                <th>Verificación</th>
                <th>Prof.</th>
                @foreach($months as $month)
                <th>{{$month}}</th>
                @endforeach
                <th nowrap>Acum</th>
                <th nowrap>% Avance</th>
            </tr>
        </thead>
        <tbody>
        @foreach($program_aps->tracers as $tracer)
            <tr>
                <td class="text-right">{{ $tracer->number }}</td>
                <td>{{ $tracer->level }}</td>
                <td>{{ $tracer->name }}</td>
                <td>{{ $tracer->population }}</td>
                <td class="text-right">{{ number_format($tracer->getValuesAcum('denominador'), 0, ',', '.') }}</td>
                <td>{{ $tracer->numerator_source }}</td>
                <td>{{ $tracer->professional }}</td>
                @foreach($months as $number => $month)
                <td class="text-right">{{ $tracer->getValueByFactorAndMonth2('numerador', $number, null, null) != null ? number_format($tracer->getValueByFactorAndMonth2('numerador', $number, null, null), 0, ',', '.') : ''}}</td>
                @endforeach
                <td class="text-right">{{ number_format($tracer->getValuesAcum('numerador', null), 0, ',', '.') }}</td>
                <td class="text-right">{{ number_format($tracer->getCompliance(), 1, ',', '.')}}% </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    </div>
</div>
@endif
@endsection

<script type="text/javascript" src="https://unpkg.com/xlsx@0.15.1/dist/xlsx.full.min.js"></script>  
@section('custom_js')
<script type="text/javascript">
    $('#establishment').on('change', function() {
        // alert( this.value );
        $('.targetDiv').hide();
        $("#" + this.value).show();
        var clickfun = $("#export").attr("onClick");
        var funname = clickfun.substring(0,clickfun.indexOf("("));       
        $("#export").attr("onclick",funname+"('tabla_"+ this.value + "', 'Hoja 1')");
    });


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