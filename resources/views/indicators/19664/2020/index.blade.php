@extends('layouts.app')

@section('title', 'Indicadores')

@section('content')

@include('indicators.partials.nav')

<h3 class="mb-3">Indicadores Ley N°19.664</h3>

<ol>
    <li> <a href="{{ route('indicators.19664.2020.servicio') }}">Servicio de Salud.</a> <span class="badge badge-warning" data-toggle="tooltip" data-placement="top" title="En Revisión"><i class="fas fa-exclamation"></i></span>
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
                              <font size="2">1.1.1 Pacientes diabéticos compensados en el grupo de 15 años y más.</font>
                            </li>
                            <li type="disc">
                              <font size="2">1.1.2 Evaluacion Anual de los Pies en personas con DM2 de 15 y más con diabetes bajo control.</font>
                            </li>
                            <li type="disc">
                              <font size="2">1.1.3 Pacientes hipertensos compensados bajo control en el grupo de 15 años y más.</font>
                            </li>
                            <li type="disc">
                              <font size="2">1.2 Porcentaje de Intervenciones Quirúrgicas Suspendidas.</font>
                            </li>
                            <li type="disc">
                              <font size="2">1.4 Variación procentual del número de días promedio de espera para intervenciones quirúrgicas, según línea base.</font>
                            </li>
                            <li type="disc">
                              <font size="2">b. Porcentaje de cumplimento de la programación anual de consulta médicas realizadas por especialista.</font>
                            </li>
                            <li type="disc">
                              <font size="2">c. Porcentaje de Cumplimiento de la Programación anual de Consultas Médicas realizadas en modalidad Telemedicina.</font>
                            </li>
                            <li type="disc">
                              <font size="2">d. Variación procentual de pacientes que esperan más de 12 horas en la Unidad de Emeergencia Hospitalaria UEH para ceder a una cama de dotación.</font>
                            </li>
                            <li type="disc">
                              <font size="2">3.a Porcentaje de Gestión Efectiva para el Cumplimiento GES en la Red.</font>
                            </li>
                            <li type="disc">
                              <font size="2">3.b Porcentaje de intervenciones sanitarias GES otrogadas según lo programado en contrato PPV para el año t.</font>
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </li>
    <br>
    <li> <a href="{{ route('indicators.19664.2020.hospital') }}">Hospital Dr. Ernesto Torres G.</a> <span class="badge badge-warning" data-toggle="tooltip" data-placement="top" title="En Revisión"><i class="fas fa-exclamation"></i></span>
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
                              <font size="2">1.2 Porcentaje de Intervenciones Quirúrgicas Suspendidas.</font>
                            </li>
                            <li type="disc">
                              <font size="2">1.3 Porcentaje de ambulatorización de cirugías mayores en el año t.</font>
                            </li>
                            <li type="disc">
                              <font size="2">1.4 Variación procentual del número de días promedio de espera para intervenciones quirúrgicas, según línea base.</font>
                            </li>
                            <li type="disc">
                              <font size="2">a. Porcentaje de altas Odonotlógicas de especialidades del nivel secundario por ingreso de tratamiento.</font>
                            </li>
                            <li type="disc">
                              <font size="2">b. Porcentaje de cumplimento de la programación anual de consulta médicas realizadas por especialista.</font>
                            </li>
                            <li type="disc">
                              <font size="2">c. Porcentaje de Cumplimiento de la Programación anual de Consultas Médicas realizadas en modalidad Telemedicina.</font>
                            </li>
                            <li type="disc">
                              <font size="2">d. Variación procentual de pacientes que esperan más de 12 horas en la Unidad de Emeergencia Hospitalaria UEH para ceder a una cama de dotación.</font>
                            </li>
                            <li type="disc">
                              <font size="2">e. Promedio de días de estadía de pacientes derivados vía UUCC a prestadores privados fuera de convenio.</font>
                            </li>
                            <li type="disc">
                              <font size="2">3.a Porcentaje de Gestión Efectiva para el Cumplimiento GES en la Red.</font>
                            </li>
                            <li type="disc">
                              <font size="2">3.b Porcentaje de intervenciones sanitarias GES otrogadas según lo programado en contrato PPV para el año t.</font>
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </li>
    <br>
    <li> <a href="{{ route('indicators.19664.2020.reyno') }}"> CGU Dr. Héctor Reyno.</a> <span class="badge badge-warning" data-toggle="tooltip" data-placement="top" title="En Revisión"><i class="fas fa-exclamation"></i></span>
        <button class="btn btn-primary btn-sm" type="button" data-toggle="collapse" data-target="#collapseExample-3" aria-expanded="false" aria-controls="collapseExample" disabled>
            <i class="fas fa-chart-bar"></i> Gráfica
        </button>
        <div>
            <div class="row">
                <div class="col-sm">
                    <div class="collapse" id="collapseExample-3">
                        <div id="chartdiv-reyno"></div>
                        <ol>
                            <li type="disc">
                              <font size="2">1.1.1 Pacientes diabéticos compensados en el grupo de 15 años y más.</font>
                            </li>
                            <li type="disc">
                              <font size="2">1.1.2 Evaluacion Anual de los Pies en personas con DM2 de 15 y más con diabetes bajo control.</font>
                            </li>
                            <li type="disc">
                              <font size="2">1.1.3 Pacientes hipertensos compensados bajo control en el grupo de 15 años y más.</font>
                            </li>
                            <li type="disc">
                              <font size="2">3.a Porcentaje de Gestión Efectiva para el Cumplimiento GES en la Red.</font>
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </li>
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
