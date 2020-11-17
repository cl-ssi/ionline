@extends('layouts.app')

@section('title', "Resumen Estadistico Mensual {$year} - Serie {$prestacion->serie}-{$prestacion->Nserie}")

@section('content')

<?php

use Illuminate\Support\Facades\DB;

?>

@include('indicators.rem.partials.navbar')

<h3>REM-{{$prestacion->Nserie}}. {{$prestacion->nombre_serie}}.</h3>

<br>

@include('indicators.rem.search')


@if(!$establecimiento AND !$periodo)
    @include('indicators.rem.partials.legend')
@else
    <link href="{{ asset('css/rem.css') }}" rel="stylesheet">
    </main>
    <div id="contenedor">
    @foreach($secciones as $seccion)
        <div class="col-sm tab table-responsive" id="{{$seccion->name}}">
        <table class="table table-hover table-bordered table-sm">
        {!!$seccion->thead!!}
        <tbody>
        @if($seccion->totals AND $seccion->totals_first)
        <tr>
            <td align='left' @if($seccion->hasGroup() AND !$seccion->discard_group) colspan="{{$seccion->supergroups ? 3 : 2 }}" @endif nowrap="nowrap"><b>TOTAL</b></td>
            @foreach($seccion->cols as $col)
            <td align='right'><b>{{number_format($seccion->total($col),0,",",".")}}</b></td>
            @endforeach
        </tr>
        @endif
        @php($group_temp = $pass = $supergroup_temp = null)
        @foreach($seccion->prestaciones as $prestacion)
        <tr>
            @if($seccion->supergroups != null AND !$seccion->discard_group AND $prestacion->nombre_supergrupo_prestacion != $supergroup_temp AND $seccion->supergroupExists($prestacion->nombre_supergrupo_prestacion))
                <td width='10%' rowspan='{{$seccion->getCountPrestacionBy($prestacion->nombre_supergrupo_prestacion) + ($seccion->isSupergroupWithSubtotals($prestacion->nombre_supergrupo_prestacion) ? 2 : 0)}}' class="centrado">{{$prestacion->nombre_supergrupo_prestacion}}</td>
                @php($supergroup_temp = $prestacion->nombre_supergrupo_prestacion)
            @endif
            @if($prestacion->hasGroup($seccion->maxLevel()) AND !$seccion->discard_group AND $prestacion->nombre_grupo_prestacion != $group_temp AND strlen($prestacion->nombre_grupo_prestacion) != 1)
                <td width='10%' rowspan='{{$seccion->getCountPrestacionBy($prestacion->nombre_grupo_prestacion)}}' colspan="{{strlen($prestacion->nombre_supergrupo_prestacion) != 1 ? 1 : 2}}" class="centrado">{{$prestacion->nombre_grupo_prestacion}}</td>
                @php($group_temp = $prestacion->nombre_grupo_prestacion)
            @endif
            @if($seccion->subtotals != null AND $seccion->subtotals_first AND $prestacion->nombre_grupo_prestacion != $pass AND $seccion->subtotalExists($prestacion->nombre_grupo_prestacion))
            <tr>
                <td align='left' colspan="1" nowrap="nowrap"><b>TOTAL</b></td>
                @foreach($seccion->cols as $col)
                <td align='right'><b>{{number_format($seccion->subtotal($col, $prestacion->nombre_grupo_prestacion),0,",",".")}}</b></td>
                @endforeach
                @php($pass = $prestacion->nombre_grupo_prestacion)
            </tr>
            @endif
            <td align='left' colspan='{{($prestacion->hasGroup($seccion->maxLevel()) AND strlen($prestacion->nombre_grupo_prestacion) != 1) ? 1: 2}}' nowrap="nowrap">{{$prestacion->nombre_prestacion}}</td>
            @foreach($seccion->cols as $col)
            <td align='right'>{{number_format($prestacion->rems->sum($col),0,",",".")}}</td>
            @endforeach
            @if($seccion->subtotals != null AND !$seccion->subtotals_first AND $prestacion->nombre_grupo_prestacion != $pass AND $seccion->subtotalExists($prestacion->nombre_grupo_prestacion) AND $seccion->isLastPrestacionByGroup($prestacion))
            <tr>
                <td align='left' colspan="1" nowrap="nowrap"><b>TOTAL</b></td>
                @foreach($seccion->cols as $col)
                <td align='right'><b>{{number_format($seccion->subtotal($col, $prestacion->nombre_grupo_prestacion),0,",",".")}}</b></td>
                @endforeach
                @php($pass = $prestacion->nombre_grupo_prestacion)
            </tr>
            @endif
        </tr>
        @endforeach
        @if($seccion->totals_by_prestacion != null)
        <tr>
            <td align='left' rowspan="{{count($seccion->getTotalsByPrestacion())}}" class="centrado"><b>TOTAL</b></td>
            @foreach($seccion->getTotalsByPrestacion() as $nombre_prestacion)
                <td align='left' colspan="1" nowrap="nowrap"><b>{{$nombre_prestacion}}</b></td>
                @foreach($seccion->cols as $col)
                <td align='right'><b>{{number_format($seccion->totalByPrestacion($col, $nombre_prestacion),0,",",".")}}</b></td>
                @endforeach
            </tr>
            @endforeach
        </tr>
        @endif
        @if($seccion->totals AND !$seccion->totals_first)
        <tr>
            <td align='left' @if($seccion->hasGroup() AND !$seccion->discard_group) colspan="{{$seccion->supergroups ? 3 : 2 }}" @endif nowrap="nowrap"><b>TOTAL</b></td>
            @foreach($seccion->cols as $col)
            <td align='right'><b>{{number_format($seccion->total($col),0,",",".")}}</b></td>
            @endforeach
        </tr>
        @endif
        {!!$seccion->tfoot!!}
        </tbody>
        </table>
        </div>
    <br>
    @endforeach
    </div>
@endif

@endsection

@section('custom_js')
    <script src="{{ asset('js/show_hide_tab.js') }}" defer></script>
    <script src="{{ asset('js/bootstrap-multiselect.js') }}" defer></script>
@endsection
