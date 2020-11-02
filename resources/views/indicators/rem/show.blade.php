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
            <td align='left' @if($seccion->hasGroup()) colspan="2" @endif nowrap="nowrap"><b>TOTAL</b></td>
            @foreach($seccion->cols as $col)
            <td align='right'><b>{{number_format($seccion->total($col),0,",",".")}}</b></td>
            @endforeach
        </tr>
        @endif
        @php($temp = null)
        @foreach($seccion->prestaciones as $prestacion)
        <tr>
            @if($prestacion->hasGroup() AND $prestacion->nombre_grupo_prestacion != $temp)
            <td width='10%' rowspan='{{$seccion->getCountPrestacionBy($prestacion->nombre_grupo_prestacion)}}' class="centrado">{{$prestacion->nombre_grupo_prestacion}}</td>
            @php($temp = $prestacion->nombre_grupo_prestacion)
            @endif
            <td align='left' nowrap="nowrap">{{$prestacion->nombre_prestacion}}</td>
            @foreach($seccion->cols as $col)
            <td align='right'>{{number_format($prestacion->rems->sum($col),0,",",".")}}</td>
            @endforeach
        </tr>
        @endforeach
        @if($seccion->totals AND !$seccion->totals_first)
        <tr>
            <td align='left' @if($seccion->hasGroup()) colspan="2" @endif nowrap="nowrap"><b>TOTAL</b></td>
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
