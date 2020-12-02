@extends('layouts.app')

@section('title', 'Programacion APS')

@section('content')

@include('indicators.partials.nav')

<h3 class="mb-3">Programacion APS</h3>

<a href="{{ route('indicators.program_aps.2019.create')}}" class="btn btn-primary">Agregar valor</a>

<!-- Nav tabs -->
<ul class="nav nav-tabs d-print-none" id="myTab" role="tablist">
    @foreach($communes as $commune)
    <li class="nav-item">
        <a class="nav-link" data-toggle="tab" role="tab" aria-selected="true"
            href="#{{ str_replace(" ","_",mb_strtoupper($commune->name)) }}">{{ mb_strtoupper($commune->name) }}
        </a>
    </li>
    @endforeach
</ul>

<!-- Tab panes -->
<div class="tab-content mt-3">
    @foreach($communes as $commune)
        <div class="tab-pane" id="{{ str_replace(" ","_",mb_strtoupper($commune->name)) }}" role="tabpanel" >
            <h4>
                <button type="button" class="btn btn-outline-info btn-sm"
                    onclick="tableToExcel('tabla_{{ str_replace(" ","_",mb_strtoupper($commune->name)) }}', 'Hoja 1')">
                    <i class="fas fa-download"></i>
                </button>
                {{ mb_strtoupper($commune->name) }}
            </h4>


            <table class="table table-bordered table-hover table-sm small" id="tabla_{{ str_replace(" ","_",mb_strtoupper($commune->name)) }}" >
                <thead>
                    <tr>
                        <th>N°</th>
                        <th>Nivel</th>
                        <th>Prestaciones</th>
                        <th>Población a atender</th>
                        <th nowrap>N° Pobl.</th>
                        <th nowrap>% Cob.</th>
                        <th>Conc.</th>
                        <th data-toggle="tooltip" data-placement="top" title="N° Poblacion * Concentración * Cobertura">Actividades Programadas</th>
                        <th>Prof.</th>
                        <th>Rend.</th>
                        <th>Verificación</th>
                        <th>Obs.</th>
                        <th nowrap>Ene-Dic</th>
                        <th nowrap>% Avance</th>


                    </tr>
                </thead>
                <tbody>
                @foreach($glosas as $index => $glosa)
                    <tr>
                        <td class="text-right">
                            @auth
                            <a href="{{ route('indicators.program_aps.2019.edit', [$glosa->id,$commune->id]) }}">
                            @endauth
                            {{ $glosa->numero }}
                            @auth
                            </a>
                            @endauth
                        </td>
                        <td>{{ $glosa->nivel }}</td>
                        <td>{{ $glosa->prestacion }}</td>
                        <td>{{ $glosa->poblacion }}</td>
                        <td class="text-right">{{ $data[mb_strtoupper($commune->name)][$glosa->numero]['poblacion'] }}</td>
                        <td class="text-right">{{ $data[mb_strtoupper($commune->name)][$glosa->numero]['cobertura'] }}%</td>
                        <td class="text-right">{{ $data[mb_strtoupper($commune->name)][$glosa->numero]['concentracion'] }}</td>
                        <td class="text-right">{{ $data[mb_strtoupper($commune->name)][$glosa->numero]['actividadesProgramadas'] }}</td>
                        <td>{{ $glosa->profesional }}</td>
                        <!--td class="text-right">{{ $data[mb_strtoupper($commune->name)][$glosa->numero]['observadoAnterior'] }}</td-->
                        <td class="text-right">{{ $data[mb_strtoupper($commune->name)][$glosa->numero]['rendimientoProfesional'] }}</td>
                        <td>{{ $glosa->verificacion }}</td>
                        <td>{{ $data[mb_strtoupper($commune->name)][$glosa->numero]['observaciones'] }}</td>
                        <td class="text-right">{{ $data[mb_strtoupper($commune->name)][$glosa->numero]['ct_marzo'] }}</td>
                        <td class="text-right">{{ $data[mb_strtoupper($commune->name)][$glosa->numero]['porc_marzo'] }}%</td>
                    </tr>
                @endforeach
                </tbody>
            </table>

        </div>
    @endforeach
</div>

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

<script type="text/javascript">
    $('#myTab a[href="#IQUIQUE"]').tab('show') // Select tab by name
    $('[data-toggle="tooltip"]').tooltip()
</script>
@endsection
