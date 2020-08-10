@extends('layouts.app')

@section('title', 'Metas')

@section('content')

@include('indicators.rem.partials.nav')

<h3 class="mb-3">Resumen Estadístico Mensual</h3>
<h6 class="mb-3">Serie P</h6>

<ol>
    <li> <a href="{{ route('indicators.rems.year.serie.nserie.index', [2020, 'serie_p', 'p01']) }}">REM-P1. POBLACIÓN EN CONTROL PROGRAMA DE SALUD DE LA MUJER.</a> </li>
    <li> <a href="{{ route('indicators.rems.year.serie.nserie.index', [2020, 'serie_p', 'p02']) }}">REM-P2. POBLACIÓN EN CONTROL PROGRAMA DE SALUD DEL NIÑO.</a> </li>
    <li> <a href="{{ route('indicators.rems.year.serie.nserie.index', [2020, 'serie_p', 'p03']) }}">REM-P3. POBLACIÓN EN CONTROL OTROS PROGRAMAS.</a> </li>
    <li> <a href="{{ route('indicators.rems.year.serie.nserie.index', [2020, 'serie_p', 'p04']) }}">REM-P4. POBLACIÓN EN CONTROL PROGRAMA DE SALUD CARDIOVASCULAR (PSCV).</a> </li>
    <li> <a href="{{ route('indicators.rems.year.serie.nserie.index', [2020, 'serie_p', 'p05']) }}">REM-P5. POBLACIÓN EN CONTROL PROGRAMA NACIONAL DE SALUD INTEGRAL DE PERSONAS MAYORES.</a> </li>
    <li> <a href="{{ route('indicators.rems.year.serie.nserie.index', [2020, 'serie_p', 'p06']) }}">REM-P6. POBLACIÓN EN CONTROL PROGRAMA DE SALUD MENTAL EN ATENCIÓN PRIMARIA Y ESPECIALIDAD.</a> </li>
    <li> <a href="{{ route('indicators.rems.year.serie.nserie.index', [2020, 'serie_p', 'p07']) }}">REM-P7. FAMILIAS EN CONTROL DE SALUD FAMILIAR.</a> </li>
    <li> <a href="{{ route('indicators.rems.year.serie.nserie.index', [2020, 'serie_p', 'p09']) }}">REM-P9. POBLACIÓN EN CONTROL DEL ADOLESCENTE.</a> </li>
    <li> <a href="{{ route('indicators.rems.year.serie.nserie.index', [2020, 'serie_p', 'p11']) }}">REM-P11. POBLACIÓN EN CONTROL PROGRAMA DE INFECCIONES DE TRASMISIÓN SEXUAL - VIH / SIDA.</a> </li>
    <li> <a href="{{ route('indicators.rems.year.serie.nserie.index', [2020, 'serie_p', 'p12']) }}">REM-P12. PERSONAS CON PAP – MAMOGRAFIA - EXAMEN FISICO DE MAMA VIGENTES Y PRODUCCION DE PAP (SEMESTRAL).</a> </li>
    <li> <a href="{{ route('indicators.rems.year.serie.nserie.index', [2020, 'serie_p', 'p13']) }}">REM-P13. NIÑOS, NIÑAS, ADOLESCENTES Y JÓVENES DE LA RED DE PROTECCIÓN SENAME EN ATENCIÓN.</a> </li>
</ol>

@endsection

@section('custom_js')

@endsection
