@extends('layouts.app')

@section('title', 'Indicadores')

@section('content')

@include('indicators.partials.nav')

<h3 class="mb-3">Indicadores</h3>

<ol>
    <li> <a href="{{ route('indicators.19813.2018.indicador1') }}">Porcentaje de niños y niñas de 12 a 23 meses con riesgo del desarrollo psicomoor recuperados.</a> </li>
    <li> <a href="{{ route('indicators.19813.2018.indicador2') }}">Papanicolau (PAP) vigente en mujeres de 25 a 64 años.</a>  </li>
    <li>
        <ul>
            <li> <a href="{{ route('indicators.19813.2018.indicador3a') }}">Porcentaje de altas odontológicas totales en adolescentes de 12 años.</a> </li>
            <li> <a href="{{ route('indicators.19813.2018.indicador3b') }}">Cobertura de alta odontológica total en embarazadas.</a> </li>
            <li> <a href="{{ route('indicators.19813.2018.indicador3c') }}">Porcentaje de egresos odontológicos en niños y niñas de 6 años.</a> </li>
        </ul>
    </li>
    <li>
        <ul>
            <li> <a href="{{ route('indicators.19813.2018.indicador4a') }}">Porcentaje de cobertura efectiva de personas con Diabetes Mellitus Tipo 2.</a> </li>
            <li> <a href="{{ route('indicators.19813.2018.indicador4b') }}">Porcentaje de personas con diabetes de 15 años y más con evaluación anual de pie.</a> </li>
        </ul>
    <li><a href="{{ route('indicators.19813.2018.indicador5') }}">Porcentaje de personas mayores de 15 años y más con cobertura efectiva de hipertensión arterial.</a> </li>
    <li> <a href="{{ route('indicators.19813.2018.indicador6') }}">Porcentaje de niños y niñas que al sexto mes de vida, cuentan con lactancia materna exclusiva.</a> </li>
</ol>

@endsection

@section('custom_js')

@endsection
