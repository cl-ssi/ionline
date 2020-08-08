@extends('layouts.app')

@section('title', 'Metas')

@section('content')

@include('indicators.rem.partials.nav')

<h3 class="mb-3">Resumen Estadístico Mensual</h3>
<h6 class="mb-3">Serie A</h6>

<ol>
    <li> <a href="{{ route('indicators.rems.year.serie.nserie.index', [2019, 'serie_a', 'a01']) }}">REM-A01. CONTROLES DE SALUD.</a> </li>
    <li> <a href="{{ route('indicators.rems.year.serie.nserie.index', [2019, 'serie_a', 'a02']) }}">REM-A02. EXAMEN DE MEDICINA PREVENTIVA EN MAYORES DE 15 AÑOS.</a> </li>
    <li> <a href="{{ route('indicators.rems.year.serie.nserie.index', [2019, 'serie_a', 'a03']) }}">REM-A03. APLICACIÓN Y RESULTADOS DE ESCALAS DE EVALUACIÓN.</a> </li>
    <li> <a href="{{ route('indicators.rems.year.serie.nserie.index', [2019, 'serie_a', 'a04']) }}">REM-A04. CONSULTAS Y OTRAS ATENCIONES EN LA RED.</a> </li>
    <li> <a href="{{ route('indicators.rems.year.serie.nserie.index', [2019, 'serie_a', 'a05']) }}">REM-A05. INGRESOS Y EGRESOS POR CONDICIÓN Y PROBLEMAS DE SALUD.</a> </li>
    <li> <a href="{{ route('indicators.rems.year.serie.nserie.index', [2019, 'serie_a', 'a06']) }}">REM-A06. PROGRAMA DE SALUD MENTAL ATENCIÓN PRIMARIA Y ESPECIALIDADES.</a> </li>
    <li> <a href="{{ route('indicators.rems.year.serie.nserie.index', [2019, 'serie_a', 'a07']) }}">REM-A07. ATENCIÓN  DE ESPECIALIDADES.</a> </li>
    <li> <a href="{{ route('indicators.rems.year.serie.nserie.index', [2019, 'serie_a', 'a08']) }}">REM-A08. ATENCIÓN DE URGENCIA.</a> </li>
    <li> <a href="{{ route('indicators.rems.year.serie.nserie.index', [2019, 'serie_a', 'a09']) }}">REM-A09. ATENCIÓN DE SALUD ODONTOLÓGICA EN APS Y ESPECIALIDADES.</a> </li>
    <li> <a href="{{ route('indicators.rems.year.serie.nserie.index', [2019, 'serie_a', 'a11']) }}">REM-A11. EXÁMENES DE PESQUISA DE ENFERMEDADES TRASMISIBLES.</a> <span class="badge badge-success">Nuevo</span> </li>
    <li> <a href="{{ route('indicators.rems.year.serie.nserie.index', [2019, 'serie_a', 'a19a']) }}">REM-A19a. ACTIVIDADES DE PROMOCIÓN Y PREVENCIÓN DE LA SALUD.</a> </li>
    <li> <a href="{{ route('indicators.rems.year.serie.nserie.index', [2019, 'serie_a', 'a19b']) }}">REM-A19b. ACTIVIDADES DE PARTICIPACIÓN SOCIAL.</a> </li>
    <li> REM-A21. QUIROFANOS Y OTROS RECURSOS HOSPITALARIOS.</a> </li>
    <ul>
      <li> <a href="{{ route('indicators.rems.year.serie.nserie.index', [2019, 'serie_a', 'a21a']) }}">SECCION A </a> </li>
      <li> <a href="{{ route('indicators.rems.year.serie.nserie.index', [2019, 'serie_a', 'a21']) }}">SECCION B, C.1, C.2, D.1, D.2, E, F, G </a> </li>
    </ul>
    <li> <a href="{{ route('indicators.rems.year.serie.nserie.index', [2019, 'serie_a', 'a23']) }}">REM-A23. SALAS: IRA, ERA Y MIXTAS EN APS.</a> </li>
    <li> <a href="{{ route('indicators.rems.year.serie.nserie.index', [2019, 'serie_a', 'a24']) }}">REM-A24. ATENCIÓN EN MATERNIDAD.</a> </li>
    <li> <a href="{{ route('indicators.rems.year.serie.nserie.index', [2019, 'serie_a', 'a25']) }}">REM-A25. SERVICIOS DE SANGRE.</a> <span class="badge badge-success">Nuevo</span> </li>
    <li> <a href="{{ route('indicators.rems.year.serie.nserie.index', [2019, 'serie_a', 'a26']) }}">REM-A26. ACTIVIDADES EN DOMICILIO Y OTROS ESPACIOS.</a> </li>
    <li> <a href="{{ route('indicators.rems.year.serie.nserie.index', [2019, 'serie_a', 'a27']) }}">REM-A27. EDUCACIÓN PARA LA SALUD.</a> </li>
    <li> <a href="{{ route('indicators.rems.year.serie.nserie.index', [2019, 'serie_a', 'a28']) }}">REM-A28. PROGRAMA DE REHABILITACIÓN INTEGRAL.</a> </li>
    <li> <a href="{{ route('indicators.rems.year.serie.nserie.index', [2019, 'serie_a', 'a29']) }}">REM-A29. PROGRAMA DE IMÁGENES DIAGNÓSTICAS Y/O RESOLUTIVIDAD EN ATENCION PRIMARIA.</a> </li>
    <li> <a href="{{ route('indicators.rems.year.serie.nserie.index', [2019, 'serie_a', 'a30']) }}">REM-A30. ATENCIONES POR TELEMEDICINA EN LA RED ASISTENCIAL.</a> </li>
    <li> <a href="{{ route('indicators.rems.year.serie.nserie.index', [2019, 'serie_a', 'a31']) }}">REM-A31. MEDICINA COMPLEMENTARIA.</a> <span class="badge badge-success">Nuevo</span> </li>
</ol>

@endsection

@section('custom_js')

@endsection
