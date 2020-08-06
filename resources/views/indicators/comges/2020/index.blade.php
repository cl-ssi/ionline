@extends('layouts.app')

@section('title', 'Compromiso de Gestión 2020')

@section('content')

@include('indicators.partials.nav')


<h3 class="mb-3">Indicadores Compromiso de Gestión 2020 - Referente - Segundo Referente</h3>

<ol>
    <li><a href="#comges1" class="dropdown-toggle" data-toggle="collapse">Proceso de Referencia y Contrarreferencia en la Red Asistencial</a> <small>{{ $comgesglobal['1referente1'] }} - {{ $comgesglobal['1referente2'] }}</small> <span class="badge badge-success"><i class="fas fa-check"></i></span>
        <div class="collapse" id="comges1">
            <ul>
                <a href="{{ route('indicators.comges.2020.comges1corte1') }}">
                    <li>I Corte</li>
                </a>
                <a href="#">
                    <li>II Corte</li>
                </a>
                <a href="#">
                    <li>III Corte</li>
                </a>
                <a href="#">
                    <li>IV Corte</li>
                </a>
            </ul>
        </div>
    </li>
    <li><a href="#comges2" class="dropdown-toggle" data-toggle="collapse">Programación de Profesionales y Actividades en Red</a> <small>{{ $comgesglobal['2referente1'] }} - {{ $comgesglobal['2referente2'] }}</small> <span class="badge badge-warning"><i class="fas fa-exclamation"></i></span>
        <div class="collapse" id="comges2">
            <ul>
                <a href="{{ route('indicators.comges.2020.comges2corte1') }}">
                    <li>I Corte</li>
                </a>
                <a href="#">
                    <li>II Corte</li>
                </a>
                <a href="#">
                    <li>III Corte</li>
                </a>
                <a href="#">
                    <li>IV Corte</li>
                </a>
            </ul>
        </div>
    </li>
    <li><a href="#comges3" class="dropdown-toggle" data-toggle="collapse">Estandarización del Proceso de Agendamiento en la Red Asistencial</a> <small>{{ $comgesglobal['3referente1'] }} - {{ $comgesglobal['3referente2'] }} </small>
        <div class="collapse" id="comges3">
            <ul>
                <a href="{{ route('indicators.comges.2020.comges3corte1') }}">
                    <li>I Corte</li>
                </a>
                <a href="#">
                    <li>II Corte</li>
                </a>
                <a href="#">
                    <li>III Corte</li>
                </a>
                <a href="#">
                    <li>IV Corte</li>
                </a>
            </ul>
        </div>
    </li>
    <li><a href="#comges4" class="dropdown-toggle" data-toggle="collapse">Reducción de los Tiempos de Espera por Consultas Nuevas de Especialidades Médicas</a> <small> {{ $comgesglobal['4referente1'] }} - {{ $comgesglobal['4referente2'] }} </small> <span class="badge badge-warning"><i class="fas fa-exclamation"></i></span>
        <div class="collapse" id="comges4">
            <ul>
                <a href="{{ route('indicators.comges.2020.comges4corte1') }}">
                    <li>I Corte</li>
                </a>
                <a href="#">
                    <li>II Corte</li>
                </a>
                <a href="#">
                    <li>III Corte</li>
                </a>
                <a href="#">
                    <li>IV Corte</li>
                </a>
            </ul>
        </div>
    </li>
    <li><a href="#comges5" class="dropdown-toggle" data-toggle="collapse">Reducción de los Tiempos de Espera por Intervenciones Quirúrgicas</a> <small> {{ $comgesglobal['5referente1'] }} - {{ $comgesglobal['5referente2'] }} </small> <span class="badge badge-warning"><i class="fas fa-exclamation"></i></span>
        <div class="collapse" id="comges5">
            <ul>
                <a href="{{ route('indicators.comges.2020.comges5corte1') }}">
                    <li>I Corte</li>
                </a>
                <a href="#">
                    <li>II Corte</li>
                </a>
                <a href="#">
                    <li>III Corte</li>
                </a>
                <a href="#">
                    <li>IV Corte</li>
                </a>
            </ul>
        </div>
    </li>
    </li>
    <li><a href="#comges6" class="dropdown-toggle" data-toggle="collapse">Reducción de los Tiempos de Espera por Consultas Nuevas de Especialidades Odontológicas</a> <small> {{ $comgesglobal['6referente1'] }} - {{ $comgesglobal['6referente2'] }}</small>

        <div class="collapse" id="comges6">
            <ul>
                <a href="{{ route('indicators.comges.2020.comges6corte1') }}">
                    <li>I Corte</li>
                </a>
                <a href="#">
                    <li>II Corte</li>
                </a>
                <a href="#">
                    <li>III Corte</li>
                </a>
                <a href="#">
                    <li>IV Corte</li>
                </a>
            </ul>
        </div>
    </li>
    <li><a href="#comges7" class="dropdown-toggle" data-toggle="collapse">Fortalecimiento del Plan Nacional de Cáncer</a> <small>{{ $comgesglobal['7referente1'] }} - {{ $comgesglobal['7referente2'] }} </small> <span class="badge badge-warning"><i class="fas fa-exclamation"></i></span>
        <div class="collapse" id="comges7">
            <ul>
                <a href="{{ route('indicators.comges.2020.comges7corte1') }}">
                    <li>I Corte</li>
                </a>
                <a href="#">
                    <li>II Corte</li>
                </a>
                <a href="#">
                    <li>III Corte</li>
                </a>
                <a href="#">
                    <li>IV Corte</li>
                </a>
            </ul>
        </div>
    </li>
    <li><a href="#comges8" class="dropdown-toggle" data-toggle="collapse">Fortalecimiento de la Salud Bucal</a> <small>{{ $comgesglobal['8referente1'] }} - {{ $comgesglobal['8referente2'] }} </small> <span class="badge badge-warning"><i class="fas fa-exclamation"></i></span>
        <div class="collapse" id="comges8">
            <ul>
                <a href="{{ route('indicators.comges.2020.comges8corte1') }}">
                    <li>I Corte</li>
                </a>
                <a href="#">
                    <li>II Corte</li>
                </a>
                <a href="#">
                    <li>III Corte</li>
                </a>
                <a href="#">
                    <li>IV Corte</li>
                </a>
            </ul>
        </div>
    </li>
    <li><a href="#comges9" class="dropdown-toggle" data-toggle="collapse">Fortalecimiento de la Salud Mental Infanto-Adolescente</a> <small> {{ $comgesglobal['9referente1'] }} - {{ $comgesglobal['9referente2'] }} </small> <span class="badge badge-warning"><i class="fas fa-exclamation"></i></span>
        <div class="collapse" id="comges9">
            <ul>
                <a href="{{ route('indicators.comges.2020.comges9corte1') }}">
                    <li>I Corte</li>
                </a>
                <a href="#">
                    <li>II Corte</li>
                </a>
                <a href="#">
                    <li>III Corte</li>
                </a>
                <a href="#">
                    <li>IV Corte</li>
                </a>
            </ul>
        </div>
    </li>
    <li><a href="#comges10" class="dropdown-toggle" data-toggle="collapse">Fortalecimiento de la Salud en Personas Mayores</a> <small> {{ $comgesglobal['10referente1'] }} - {{ $comgesglobal['10referente2'] }} </small> <span class="badge badge-warning"><i class="fas fa-exclamation"></i></span>
        <div class="collapse" id="comges10">
            <ul>
                <a href="{{ route('indicators.comges.2020.comges10corte1') }}">
                    <li>I Corte</li>
                </a>
                <a href="#">
                    <li>II Corte</li>
                </a>
                <a href="#">
                    <li>III Corte</li>
                </a>
                <a href="#">
                    <li>IV Corte</li>
                </a>
            </ul>
        </div>
    </li>
    <li><a href="#comges11" class="dropdown-toggle" data-toggle="collapse">Fortalecimiento del Proceso de Atención de Urgencia</a> <small>{{ $comgesglobal['11referente1'] }} - {{ $comgesglobal['11referente2'] }} </small> <span class="badge badge-warning"><i class="fas fa-exclamation"></i></span>
        <div class="collapse" id="comges11">
            <ul>
                <a href="{{ route('indicators.comges.2020.comges11corte1') }}">
                    <li>I Corte</li>
                </a>
                <a href="#">
                    <li>II Corte</li>
                </a>
                <a href="#">
                    <li>III Corte</li>
                </a>
                <a href="#">
                    <li>IV Corte</li>
                </a>
            </ul>
        </div>
    </li>
    <li><a href="#comges12" class="dropdown-toggle" data-toggle="collapse">Fortalecimiento del Proceso de Hospitalización</a> <small>{{ $comgesglobal['12referente1'] }} - {{ $comgesglobal['12referente2'] }} </small> <span class="badge badge-warning"><i class="fas fa-exclamation"></i></span>
        <div class="collapse" id="comges12">
            <ul>
                <a href="{{ route('indicators.comges.2020.comges12corte1') }}">
                    <li>I Corte</li>
                </a>
                <a href="#">
                    <li>II Corte</li>
                </a>
                <a href="#">
                    <li>III Corte</li>
                </a>
                <a href="#">
                    <li>IV Corte</li>
                </a>
            </ul>
        </div>
    </li>
    <li><a href="#comges13" class="dropdown-toggle" data-toggle="collapse">Fortalecimiento del Proceso Quirúrgico</a> <small> {{ $comgesglobal['13referente1'] }} - {{ $comgesglobal['13referente2'] }} </small> <span class="badge badge-warning"><i class="fas fa-exclamation"></i></span>
        <div class="collapse" id="comges13">
            <ul>
                <a href="{{ route('indicators.comges.2020.comges13corte1') }}">
                    <li>I Corte</li>
                </a>
                <a href="#">
                    <li>II Corte</li>
                </a>
                <a href="#">
                    <li>III Corte</li>
                </a>
                <a href="#">
                    <li>IV Corte</li>
                </a>
            </ul>
        </div>
    </li>
    <li><a href="#comges14" class="dropdown-toggle" data-toggle="collapse">Aumento de Donantes Efectivos de Órganos para Trasplantes</a> <small>{{ $comgesglobal['14referente1'] }} - {{ $comgesglobal['14referente2'] }} </small> <span class="badge badge-success"><i class="fas fa-check"></i></span>
        <div class="collapse" id="comges14">
            <ul>
                <a href="{{ route('indicators.comges.2020.comges14corte1') }}">
                    <li>I Corte</li>
                </a>
                <a href="#">
                    <li>II Corte</li>
                </a>
                <a href="#">
                    <li>III Corte</li>
                </a>
                <a href="#">
                    <li>IV Corte</li>
                </a>
            </ul>
        </div>
    </li>
    <li><a href="#comges15" class="dropdown-toggle" data-toggle="collapse">Prevención y Control del VIH - SIDA</a> <small>{{ $comgesglobal['15referente1'] }} - {{ $comgesglobal['15referente2'] }} </small>
        <div class="collapse" id="comges15">
            <ul>
                <a href="{{ route('indicators.comges.2020.comges15corte1') }}">
                    <li>I Corte</li>
                </a>
                <a href="#">
                    <li>II Corte</li>
                </a>
                <a href="#">
                    <li>III Corte</li>
                </a>
                <a href="#">
                    <li>IV Corte</li>
                </a>
            </ul>
        </div>
    </li>
    <li><a href="#comges16" class="dropdown-toggle" data-toggle="collapse">Fortalecimiento de la Satisfacción Usuaria</a> <small>{{ $comgesglobal['16referente1'] }} - {{ $comgesglobal['16referente2'] }} </small> <span class="badge badge-success"><i class="fas fa-check"></i></span>
        <div class="collapse" id="comges16">
            <ul>
                <a href="{{ route('indicators.comges.2020.comges16corte1') }}">
                    <li>I Corte</li>
                </a>
                <a href="#">
                    <li>II Corte</li>
                </a>
                <a href="#">
                    <li>III Corte</li>
                </a>
                <a href="#">
                    <li>IV Corte</li>
                </a>
            </ul>
        </div>
    </li>
    <li><a href="#comges17" class="dropdown-toggle" data-toggle="collapse">Fortalecimiento de la Participación Ciudadana</a> <small>{{ $comgesglobal['17referente1'] }} - {{ $comgesglobal['17referente2'] }} </small> <span class="badge badge-warning"><i class="fas fa-exclamation"></i></span>
        <div class="collapse" id="comges17">
            <ul>
                <a href="{{ route('indicators.comges.2020.comges17corte1') }}">
                    <li>I Corte</li>
                </a>
                <a href="#">
                    <li>II Corte</li>
                </a>
                <a href="#">
                    <li>III Corte</li>
                </a>
                <a href="#">
                    <li>IV Corte</li>
                </a>
            </ul>
        </div>
    </li>
    <li><a href="#comges18" class="dropdown-toggle" data-toggle="collapse">Política Comunicacional de los Servicios de Salud</a> <small>{{ $comgesglobal['18referente1'] }} - {{ $comgesglobal['18referente2'] }} </small>
        <div class="collapse" id="comges18">
            <ul>
                <a href="{{ route('indicators.comges.2020.comges18corte1') }}">
                    <li>I Corte</li>
                </a>
                <a href="#">
                    <li>II Corte</li>
                </a>
                <a href="#">
                    <li>III Corte</li>
                </a>
                <a href="#">
                    <li>IV Corte</li>
                </a>
            </ul>
        </div>
    </li>
    <li><a href="#comges19" class="dropdown-toggle" data-toggle="collapse">Optimización de los Procesos de Gestión de Inventario de Medicamentos en Farmacias Hospitalarias</a> <small>{{ $comgesglobal['19referente1'] }} - {{ $comgesglobal['19referente2'] }}</small> <span class="badge badge-success"><i class="fas fa-check"></i></span>
        <div class="collapse" id="comges19">
            <ul>
                <a href="{{ route('indicators.comges.2020.comges19corte1') }}">
                    <li>I Corte</li>
                </a>
                <a href="#">
                    <li>II Corte</li>
                </a>
                <a href="#">
                    <li>III Corte</li>
                </a>
                <a href="#">
                    <li>IV Corte</li>
                </a>
            </ul>
        </div>
    </li>
    <li><a href="#comges20" class="dropdown-toggle" data-toggle="collapse">Política de Calidad y Seguridad en la Atención</a> <small>{{ $comgesglobal['20referente1'] }} - {{ $comgesglobal['20referente2'] }} </small> <span class="badge badge-success"><i class="fas fa-check"></i></span>
        <div class="collapse" id="comges20">
            <ul>
                <li>I Corte - No Aplica</li>
                <a href="#">
                    <li>II Corte</li>
                </a>
                <a href="#">
                    <li>III Corte</li>
                </a>
                <a href="#">
                    <li>IV Corte</li>
                </a>
            </ul>
        </div>
    </li>
    <li><a href="#comges21" class="dropdown-toggle" data-toggle="collapse">Disminución del Ausentismo Laboral en la Red Asistencial</a> <small>{{ $comgesglobal['21referente1'] }} - {{ $comgesglobal['21referente2'] }} </small>
        <div class="collapse" id="comges21">
            <ul>
                <a href="{{ route('indicators.comges.2020.comges21corte1') }}">
                    <li>I Corte</li>
                </a>
                <a href="#">
                    <li>II Corte</li>
                </a>
                <a href="#">
                    <li>III Corte</li>
                </a>
                <a href="#">
                    <li>IV Corte</li>
                </a>
            </ul>
        </div>
    </li>
    <li><a href="#comges22" class="dropdown-toggle" data-toggle="collapse">Fortalecimiento de la Estrategia SIDRA</a> <small>{{ $comgesglobal['22referente1'] }} - {{ $comgesglobal['22referente2'] }} </small> <span class="badge badge-success"><i class="fas fa-check"></i></span>
        <div class="collapse" id="comges22">
            <ul>
                <a href="{{ route('indicators.comges.2020.comges22corte1') }}">
                    <li>I Corte</li>
                </a>
                <a href="#">
                    <li>II Corte</li>
                </a>
                <a href="#">
                    <li>III Corte</li>
                </a>
                <a href="#">
                    <li>IV Corte</li>
                </a>
            </ul>
        </div>
    </li>
    <li><a href="#comges23" class="dropdown-toggle" data-toggle="collapse">Fortalecimiento de los Sistemas de Información en el Ámbito de Gestión y Desarrollo de las Personas</a> <small>{{ $comgesglobal['23referente1'] }} - {{ $comgesglobal['23referente2'] }} </small> <span class="badge badge-success"><i class="fas fa-check"></i></span>
        <div class="collapse" id="comges23">
            <ul>

                <li>I Corte - No Aplica</li>

                <a href="#">
                    <li>II Corte</li>
                </a>
                <a href="#">
                    <li>III Corte</li>
                </a>
                <a href="#">
                    <li>IV Corte</li>
                </a>
            </ul>
        </div>
    </li>
    <li><a href="#comges24" class="dropdown-toggle" data-toggle="collapse">Ejecución Presupuestaria para Proyectos de Inversión Sectorial</a> <small>{{ $comgesglobal['24referente1'] }} - {{ $comgesglobal['24referente2'] }} </small> <span class="badge badge-success"><i class="fas fa-check"></i></span>
        <div class="collapse" id="comges24">
            <ul>
                <a href="{{ route('indicators.comges.2020.comges24corte1') }}">
                    <li>I Corte</li>
                </a>
                <a href="#">
                    <li>II Corte</li>
                </a>
                <a href="#">
                    <li>III Corte</li>
                </a>
                <a href="#">
                    <li>IV Corte</li>
                </a>
            </ul>
        </div>
    </li>
    <li><a href="#comges25" class="dropdown-toggle" data-toggle="collapse">Fortalecimiento del Proceso de Compra de Medicamentos en Establecimientos Hospitalarios</a> <small>{{ $comgesglobal['25referente1'] }} - {{ $comgesglobal['25referente2'] }} </small> <span class="badge badge-success"><i class="fas fa-check"></i></span>
        <div class="collapse" id="comges25">
            <ul>
                <a href="{{ route('indicators.comges.2020.comges25corte1') }}">
                    <li>I Corte</li>
                </a>
                <a href="#">
                    <li>II Corte</li>
                </a>
                <a href="#">
                    <li>III Corte</li>
                </a>
                <a href="#">
                    <li>IV Corte</li>
                </a>
            </ul>
        </div>
    </li>
</ol>


@endsection

@section('custom_js')

@endsection
