@extends('layouts.app')

@section('title', 'Indicadores')

@section('content')

@include('indicators.partials.nav')

<h3 class="mb-3">Indicadores</h3>

<ol>
    <li> <a href="{{ route('indicators.aps.2020.pmasama') }}">Más Adultos Mayores Autovalentes.</a> <span class="badge badge-warning"><i class="fas fa-check"></i></span></li>
    <li> <a href="{{ route('indicators.aps.2020.depsev.index') }}">Dependencia Severa.</a> <span class="badge badge-success"><i class="fas fa-check"></i></span></li>
    <li> <a href="{{ route('indicators.aps.2020.respiratorio.index') }}">Programa Respiratorio.</a> <span class="badge badge-warning"><i class="fas fa-exclamation"></i></span></li>
    <li> <a href="{{ route('indicators.aps.2020.resolutividad.index') }}">Programa Resolutividad en APS.</a> <span class="badge badge-warning"><i class="fas fa-exclamation"></i></span></li>
    <li> <a href="{{ route('indicators.aps.2020.pespi.index') }}">Programa Especial de Salud y Pueblos Indígenas (PESPI).</a> <span class="badge badge-success"><i class="fas fa-check"></i></span></li></li>
    <li> <a href="{{ route('indicators.aps.2020.equidad_rural.aps') }}">Programa Equidad en Salud Rural.</a> <span class="badge badge-warning"><i class="fas fa-exclamation"></i></span></li>
    <li> <a href="{{ route('indicators.aps.2020.saserep.index') }}">Programa de Salud Sexual Y Reproductiva.</a> <span class="badge badge-warning"><i class="fas fa-exclamation"></i></span></li>
    <li> Indicadores Odontológicos.</li>
    <ul>
        <li> <a href="{{ route('indicators.aps.2020.ges_odont.index') }}">GES Odontológico.</a> <span class="badge badge-success"><i class="fas fa-check"></i></li>
        <li> <a href="{{ route('indicators.aps.2020.sembrando_sonrisas.index') }}">Sembrando Sonrisas.</a> <span class="badge badge-warning"><i class="fas fa-exclamation"></i></span></li>
        <li> <a href="{{ route('indicators.aps.2020.mejoramiento_atencion_odontologica.aps') }}">Programa Mejoramiento Atención Odontológica.</a> <span class="badge badge-warning"><i class="fas fa-exclamation"></i></span></li>
        <li> <a href="{{ route('indicators.aps.2020.odontologico_integral.index') }}">Programa Odontológico Integral.</a> <span class="badge badge-warning"><i class="fas fa-exclamation"></i></span></li>
    </ul>
    <li> <a href="{{ route('indicators.aps.2020.chcc.index') }}">Chile Crece Contigo (ChCC).</a> <span class="badge badge-success"><i class="fas fa-check"></i></span></li>
</ol>

@endsection

@section('custom_js')

@endsection

@section('custom_js_head')

<script src="https://www.amcharts.com/lib/4/core.js"></script>
<script src="https://www.amcharts.com/lib/4/charts.js"></script>
<script src="https://www.amcharts.com/lib/4/themes/material.js"></script>
<script src="https://www.amcharts.com/lib/4/themes/animated.js"></script>



@endsection
