@extends('layouts.app')

@section('title', "Resumen Estadistico Mensual {$year} - Serie {$prestacion->serie}-{$prestacion->Nserie}")

@section('content')

<?php

use Illuminate\Support\Facades\DB;

?>

@include('indicators.rem.partials.navbar')

<h3>REM-{{$prestacion->Nserie}}. {{$prestacion->descripcion}}.</h3>

<br>

@include('indicators.rem.search')


@if(!$establecimiento AND !$periodo)
    @include('indicators.rem.partials.legend')
@else
    <link href="{{ asset('css/rem.css') }}" rel="stylesheet">
@endif

@endsection

@section('custom_js')
    <script src="{{ asset('js/show_hide_tab.js') }}" defer></script>
    <script src="{{ asset('js/bootstrap-multiselect.js') }}" defer></script>
@endsection
