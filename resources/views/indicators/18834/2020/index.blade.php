@extends('layouts.app')

@section('title', 'Ley N° 18.834')

@section('content')

@include('indicators.partials.nav')

<h3 class="mb-3">Indicadores</h3>
<h6 class="mb-3">Metas Sanitarias Ley N° 18.834</h6>

<ol>
    <li> <a href="{{ route('indicators.18834.2020.servicio') }}">Servicio de Salud.</a> <span class="badge badge-warning" data-toggle="tooltip" data-placement="top" title="En Revisión"><i class="fas fa-exclamation"></i></span>
        <button class="btn btn-primary btn-sm" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample" disabled>
            <i class="fas fa-chart-bar"></i> Gráfica
        </button>
        <div>
            <div class="row">
                <div class="col-sm">
                    <div class="collapse" id="collapseExample">
                        <div id="chartdiv"></div>
                        <ol>
                            <li type="disc">
                              <font size="2">1.3. Porcentaje de pacientes hipertensos compensados bajo control en el grupo de 15 y más años en el nivel primario.</font>
                            </li>
                            <li type="disc">
                              <font size="2">1.4. Porcentaje de cumplimiento de programación de consultas de profesionales no médicos de establecimientos hospitalarios de alta complejidad.</font>
                            </li>
                            <li type="disc">
                              <font size="2">1.7. Porcentaje de Gestión Efectiva para el Cumplimiento GES en la Red.</font>
                            </li>
                            <li type="disc">
                              <font size="2">1.8. Porcentaje de pretaciones trazadoras de tratamiento GES otrogadas según lo programado de prestaciones trazadoras de tratamiento GES en contrato PPV para el año t.</font>
                            </li>
                            <li type="disc">
                              <font size="2">3.1. Porcentajes de funcionarios regidos por el Estatuto Administrativo, capacitados durante el año en al menos una actividad pertinente, de los nueve ejes estratégicos de la Estrategia Nacional de Salud.</font>
                            </li>
                  			</ol>
                    </div>
                </div>
            </div>
        </div>
    </li>
    <br>
    <li> <a href="{{ route('indicators.18834.2020.hospital') }}">Hospital Dr. Ernesto Torres G.</a> <span class="badge badge-warning" data-toggle="tooltip" data-placement="top" title="En Revisión"><i class="fas fa-exclamation"></i></span>
        <button class="btn btn-primary btn-sm" type="button" data-toggle="collapse" data-target="#collapseExample-2" aria-expanded="false" aria-controls="collapseExample" disabled>
            <i class="fas fa-chart-bar"></i> Gráfica
        </button>
        <div>
            <div class="row">
                <div class="col-sm">
                    <div class="collapse" id="collapseExample-2">
                        <div id="chartdiv-hetg"></div>
                        <ol>
                            <li type="disc">
                              <font size="2">1.4. Porcentaje de cumplimiento de programación de consultas de profesionales no médicos de establecimientos hospitalarios de alta complejidad.</font>
                    				</li>
                            <li type="disc">
                              <font size="2">1.5. Porcentaje de categorización de Urgencia a través de ESI en las UEH.</font>
                    				</li>
                    				<li type="disc">
                    					<font size="2">1.6. Porcentaje de categorización de pacientes en niveles de riesgo dependencia.</font>
                    				</li>
                            <li type="disc">
                    					<font size="2">1.7. Porcentaje de Gestión Efectiva para el Cumplimiento GES en la Red.</font>
                    				</li>
                    				<li type="disc">
                    					<font size="2">1.8. Porcentaje de pretaciones trazadoras de tratamiento GES otrogadas según lo programado de prestaciones trazadoras de tratamiento GES en contrato PPV para el año t.</font>
                    				</li>
                            <li type="disc">
                    					<font size="2">2.0. Porcentaje de egreso de maternidades con Lactancia Materna Exclusiva (LME).</font>
                    				</li>
                            <li type="disc">
                    					<font size="2">3.1. Porcentajes de funcionarios regidos por el Estatuto Administrativo, capacitados durante el año en al menos una actividad pertinente, de los nueve ejes estratégicos de la Estrategia Nacional de Salud.</font>
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </li>
    <br>
    <li> <a href="{{ route('indicators.18834.2020.reyno') }}">CGU Dr. Héctor Reyno.</a> <span class="badge badge-warning" data-toggle="tooltip" data-placement="top" title="En Revisión"><i class="fas fa-exclamation"></i></span>
        <button class="btn btn-primary btn-sm" type="button" data-toggle="collapse" data-target="#collapseExample-3" aria-expanded="false" aria-controls="collapseExample" disabled>
            <i class="fas fa-chart-bar"></i> Gráfica
        </button>
    </li>
    <div>
        <div class="row">
            <div class="col-sm">
                <div class="collapse" id="collapseExample-3">
                    <div id="chartdiv-reyno"></div>
                    <ol>
                        <li type="disc">
                          <font size="2">1.1. Pacientes diabéticos compensados en el grupo de 15 años y más.</font>
                        </li>
                        <li type="disc">
                          <font size="2">1.2. Evaluación anual de los pies en personas de 15 años y más con diabetes bajo control.</font>
                        </li>
                        <li type="disc">
                          <font size="2">1.3. Pacientes hipertenesos compensados bajo control en el grupo de 15 años y más.</font>
                        </li>
                        <li type="disc">
                          <font size="2">1.7. Porcentaje de Gestión Efectiva para el Cumplimiento GES en la Red.</font>
                        </li>
                        <li type="disc">
                          <font size="2">1.8. Porcentaje de pretaciones trazadoras de tratamiento GES otrogadas según lo programado de prestaciones trazadoras de tratamiento GES en contrato PPV para el año t.</font>
                        </li>
                        <li type="disc">
                          <font size="2">3.1. Porcentajes de funcionarios regidos por el Estatuto Administrativo, capacitados durante el año en al menos una actividad pertinente, de los nueve ejes estratégicos de la Estrategia Nacional de Salud.</font>
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
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
