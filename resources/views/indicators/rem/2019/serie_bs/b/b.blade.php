@extends('layouts.app')

@section('title', 'Resumen Estadistico Mensual')

@section('content')

<?php

use Illuminate\Support\Facades\DB;

?>

@include('indicators.rem.partials.navBS')

<h3>REM-BS. Glosa Resumen.</h3>

<br>

@include('indicators.rem.2019.serie_a.search')

<?php
//(isset($establecimientos) AND isset($periodo)));

if (in_array(0, $establecimientos) AND in_array(0, $periodo)){
    ?>
    <div class="jumbotron">
        <h2>
            Bienvenido!
        </h2>
        <br><br>
        <p align="justify">
            El Departamento de Planificación y Control de Redes (SDGA) del Servicio de Salud de Iquique, pone a disposición el Consolidado del Registro
            Estadístico Mensual, este sitio web se sustenta mensualmente de los REM informados por todos los establecimientos de la red asistencial de la región de Tarapacá.
            <br><br>
            <!--<a class="btn btn-primary btn-large" href="#">Revise el manual</a>-->
        </p>
    </div>
<?php
}
else{
    $estab = implode (", ", $establecimientos);
    $mes = implode (", ", $periodo);?>

    <link href="{{ asset('css/rem.css') }}" rel="stylesheet">

    <!--<div class="form-group">
        <select class="form-control selectpicker" data-size="10" id="tabselector">
            <option value="A">A: CONSULTAS MÉDICAS.</option>
            <option value="B">B: ATENCIONES MEDICAS POR PROGRAMAS Y POLICLINICOS ESPECIALISTAS ACREDITADOS.</option>
            <option value="C">C: CONSULTAS Y CONTROLES POR OTROS PROFESIONALES EN ESPECIALIDAD (NIVEL SECUNDARIO).</option>
            <option value="D">D: CONSULTAS INFECCIÓN TRANSMISIÓN SEXUAL (ITS) Y CONTROLES DE SALUD SEXUAL EN EL NIVEL SECUNDARIO.</option>
        </select>
    </div>-->

    <!--
    AQUI LOS CODIGOS
    -->

    </main>

    <div id="contenedor">
    <!-- SECCION A -->
    <div class="col-sm tab table-responsive" id="A">
        <table class="table table-hover table-bordered table-sm">
            <thead>
                <tr>
                    <td rowspan="3" style="text-align:center; vertical-align:middle"><strong>GLOSA</strong></td>
                    <td rowspan="3" style="text-align:center; vertical-align:middle"><strong>TOTAL</strong></td>
                    <td colspan="4" style="text-align:center; vertical-align:middle"><strong>ACTIVIDADES</strong></td>
                    <td colspan="7" style="text-align:center; vertical-align:middle"><strong>INTERVENCIONES QUIRÚRGICAS</strong></td>
                    <td colspan="3"  rowspan="2" style="text-align:center; vertical-align:middle"><strong>INTERVENCIONES QUIRÚRGICAS MAYORES NO AMBULATORIAS ELECTIVAS</strong></td>
                    <td colspan="3"  rowspan="2" style="text-align:center; vertical-align:middle"><strong>INTERVENCIONES QUIRÚRGICAS MAYORES AMBULATORIAS ELECTIVA</strong></td>
                    <td colspan="3"  rowspan="2" style="text-align:center; vertical-align:middle"><strong>INTERVENCIONES QUIRÚRGICAS MAYORES AMBULATORIAS URGENCIA</strong></td>
                    <td colspan="3"  rowspan="2" style="text-align:center; vertical-align:middle"><strong>INTERVENCIONES QUIRÚRGICAS MAYORES NO AMBULATORIAS URGENCIA</strong></td>
                    <td colspan="3"  rowspan="2" style="text-align:center; vertical-align:middle"><strong>PROCEDENCIA</strong></td>
                    <td colspan="3"  rowspan="2" style="text-align:center; vertical-align:middle"><strong>PRODUCCION INTRA HOSPITAL</strong></td>
                    <td rowspan="3" style="text-align:center; vertical-align:middle"><strong>OPERATIVO</strong></td>
                    <td colspan="2" rowspan="2" style="text-align:center; vertical-align:middle"><strong>COMPRAS REALIZADAS</strong></td>
                    <td rowspan="3" style="text-align:center; vertical-align:middle"><strong>VENTAS DE SERVICIOS</strong></td>
                    <td rowspan="3" style="text-align:center; vertical-align:middle"><strong>TRANSFERENCIA 2019</strong></td>
                    <td rowspan="3" style="text-align:center; vertical-align:middle"><strong>TOTAL FACTURADO</strong></td>
                </tr>
                <tr>
                    <td rowspan="2" style="text-align:center; vertical-align:middle"><strong>TOTAL BENEFICIARIOS</strong></td>
                    <td colspan="2" style="text-align:center; vertical-align:middle"><strong>BENEFICIARIOS</strong></td>
                    <td rowspan="2" style="text-align:center; vertical-align:middle"><strong>NO BENEFICIARIOS</strong></td>
                    <td rowspan="2" style="text-align:center; vertical-align:middle"><strong>TOTAL BENEFICIARIOS</strong></td>
                    <td colspan="3" style="text-align:center; vertical-align:middle"><strong>PRINCIPAL</strong></td>
                    <td colspan="3" style="text-align:center; vertical-align:middle"><strong>SECUNDARIA</strong></td>
                </tr>
                <tr>
                    <td style="text-align:center; vertical-align:middle"><strong>MAI</strong></td>
                    <td style="text-align:center; vertical-align:middle"><strong>MLE</strong></td>
                    <td style="text-align:center; vertical-align:middle"><strong>MAI</strong></td>
                    <td style="text-align:center; vertical-align:middle"><strong>MLE</strong></td>
                    <td style="text-align:center; vertical-align:middle"><strong>NO BENEFICIARIO</strong></td>
                    <td style="text-align:center; vertical-align:middle"><strong>MAI</strong></td>
                    <td style="text-align:center; vertical-align:middle"><strong>MLE</strong></td>
                    <td style="text-align:center; vertical-align:middle"><strong>NO BENEFICIARIO</strong></td>
                    <td style="text-align:center; vertical-align:middle"><strong>TOTAL</strong></td>
                    <td style="text-align:center; vertical-align:middle" nowrap><strong>< 15 AÑOS</strong></td>
                    <td style="text-align:center; vertical-align:middle" nowrap><strong>15 AÑOS Y MÁS</strong></td>
                    <td style="text-align:center; vertical-align:middle" nowrap><strong>TOTAL</strong></td>
                    <td style="text-align:center; vertical-align:middle" nowrap><strong>< 15 AÑOS</strong></td>
                    <td style="text-align:center; vertical-align:middle" nowrap><strong>15 AÑOS Y MÁS</strong></td>
                    <td style="text-align:center; vertical-align:middle" nowrap><strong>TOTAL</strong></td>
                    <td style="text-align:center; vertical-align:middle" nowrap><strong>< 15 AÑOS</strong></td>
                    <td style="text-align:center; vertical-align:middle" nowrap><strong>15 AÑOS Y MÁS</strong></td>
                    <td style="text-align:center; vertical-align:middle" nowrap><strong>TOTAL</strong></td>
                    <td style="text-align:center; vertical-align:middle" nowrap><strong>< 15 AÑOS</strong></td>
                    <td style="text-align:center; vertical-align:middle" nowrap><strong>15 AÑOS Y MÁS</strong></td>
                    <td style="text-align:center; vertical-align:middle"><strong>ATENCION CERRADA</strong></td>
                    <td style="text-align:center; vertical-align:middle"><strong>ATENCION ABIERTA</strong></td>
                    <td style="text-align:center; vertical-align:middle"><strong>EMERGENCIA</strong></td>
                    <td style="text-align:center; vertical-align:middle"><strong>POR HONORARIOS</strong></td>
                    <td style="text-align:center; vertical-align:middle"><strong>POR CONVENIOS</strong></td>
                    <td style="text-align:center; vertical-align:middle"><strong>POR CONSULTORES DE LLAMADA</strong></td>
                    <td style="text-align:center; vertical-align:middle"><strong>AL SISTEMA</strong></td>
                    <td style="text-align:center; vertical-align:middle"><strong>EXTRASISTEMA</strong></td>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><strong>CONSULTAS Y ATENCION MEDICA</strong></td>
                    <td colspan="36"></td>
                </tr>
                <?php
                $query = 'SELECT a.codigo_prestacion,a.descripcion
                              ,sum(ifnull(b.Col01,0)) Col01
                              ,sum(ifnull(b.Col02,0)) Col02
                              ,sum(ifnull(b.Col03,0)) Col03
                              ,sum(ifnull(b.Col04,0)) Col04
									            ,sum(ifnull(b.Col05,0)) Col05
                              ,sum(ifnull(b.Col06,0)) Col06
                              ,sum(ifnull(b.Col07,0)) Col07
                              ,sum(ifnull(b.Col08,0)) Col08
                              ,sum(ifnull(b.Col09,0)) Col09
                              ,sum(ifnull(b.Col10,0)) Col10
                              ,sum(ifnull(b.Col11,0)) Col11
                              ,sum(ifnull(b.Col12,0)) Col12
                              ,sum(ifnull(b.Col13,0)) Col13
            									,sum(ifnull(b.Col14,0)) Col14
            									,sum(ifnull(b.Col15,0)) Col15
            									,sum(ifnull(b.Col16,0)) Col16
            									,sum(ifnull(b.Col17,0)) Col17
            									,sum(ifnull(b.Col18,0)) Col18
            									,sum(ifnull(b.Col19,0)) Col19
            									,sum(ifnull(b.Col20,0)) Col20
            									,sum(ifnull(b.Col21,0)) Col21
            									,sum(ifnull(b.Col22,0)) Col22
            									,sum(ifnull(b.Col23,0)) Col23
                              ,sum(ifnull(b.Col24,0)) Col24
                              ,sum(ifnull(b.Col25,0)) Col25
                              ,sum(ifnull(b.Col26,0)) Col26
                              ,sum(ifnull(b.Col27,0)) Col27
                              ,sum(ifnull(b.Col28,0)) Col28
                              ,sum(ifnull(b.Col29,0)) Col29
                              ,sum(ifnull(b.Col30,0)) Col30
                              ,sum(ifnull(b.Col31,0)) Col31
                              ,sum(ifnull(b.Col32,0)) Col32
                              ,sum(ifnull(b.Col33,0)) Col33
                              ,sum(ifnull(b.Col34,0)) Col34
                              ,sum(ifnull(b.Col35,0)) Col35
                              ,sum(ifnull(b.Col36,0)) Col36
                          FROM (select c.* from 2019prestaciones c where c.codigo_prestacion in("01010001","01010002","01010003","01010004","01010005","01010006","01010007","01010008",
                                                                                                "01010009","01010010","01010011","01010012","01010013","01013100")) a
                          left join 2019rems b on (a.id_prestacion=b.prestacion_id_prestacion)
                          AND (b.Mes in ('.$mes.')) AND (b.establecimiento_id_establecimiento in ('.$estab.'))
                          group by  a.codigo_prestacion,a.descripcion,a.id_prestacion
                          order by a.id_prestacion';
                $registro = DB::connection('mysql_rem')->select($query);

                $i=0;

                $totalCol01a=0;
    						$totalCol02a=0;
    						$totalCol03a=0;
    						$totalCol04a=0;
    						$totalCol05a=0;
    						$totalCol06a=0;
    						$totalCol07a=0;
    						$totalCol08a=0;
    						$totalCol09a=0;
    						$totalCol10a=0;
    						$totalCol11a=0;
    						$totalCol12a=0;
    						$totalCol13a=0;
    						$totalCol14a=0;
    						$totalCol15a=0;
    						$totalCol16a=0;
    						$totalCol17a=0;
    						$totalCol18a=0;
    						$totalCol19a=0;
    						$totalCol20a=0;
    						$totalCol21a=0;
    						$totalCol22a=0;
    						$totalCol23a=0;
    						$totalCol24a=0;
    						$totalCol25a=0;
    						$totalCol26a=0;
    						$totalCol27a=0;
    						$totalCol28a=0;
    						$totalCol29a=0;
    						$totalCol30a=0;
    						$totalCol31a=0;
    						$totalCol32a=0;
    						$totalCol33a=0;
    						$totalCol34a=0;
    						$totalCol35a=0;
    						$totalCol36a=0;

                foreach($registro as $row ){
                    $totalCol01a=$totalCol01a+$row->Col01;
                    $totalCol02a=$totalCol02a+$row->Col02;
                    $totalCol03a=$totalCol03a+$row->Col03;
                    $totalCol04a=$totalCol04a+$row->Col04;
                    $totalCol05a=$totalCol05a+$row->Col05;
                    $totalCol06a=$totalCol06a+$row->Col06;
                    $totalCol07a=$totalCol07a+$row->Col07;
                    $totalCol08a=$totalCol08a+$row->Col08;
                    $totalCol09a=$totalCol09a+$row->Col09;
                    $totalCol10a=$totalCol10a+$row->Col10;
                    $totalCol11a=$totalCol11a+$row->Col11;
                    $totalCol12a=$totalCol12a+$row->Col12;
                    $totalCol13a=$totalCol13a+$row->Col13;
                    $totalCol14a=$totalCol14a+$row->Col14;
                    $totalCol15a=$totalCol15a+$row->Col15;
                    $totalCol16a=$totalCol16a+$row->Col16;
                    $totalCol17a=$totalCol17a+$row->Col17;
                    $totalCol18a=$totalCol18a+$row->Col18;
                    $totalCol19a=$totalCol19a+$row->Col19;
                    $totalCol20a=$totalCol20a+$row->Col20;
                    $totalCol21a=$totalCol21a+$row->Col21;
                    $totalCol22a=$totalCol22a+$row->Col22;
                    $totalCol23a=$totalCol23a+$row->Col23;
                    $totalCol24a=$totalCol24a+$row->Col24;
                    $totalCol25a=$totalCol25a+$row->Col25;
                    $totalCol26a=$totalCol26a+$row->Col26;
                    $totalCol27a=$totalCol27a+$row->Col27;
                    $totalCol28a=$totalCol28a+$row->Col28;
                    $totalCol29a=$totalCol29a+$row->Col29;
                    $totalCol30a=$totalCol30a+$row->Col30;
                    $totalCol31a=$totalCol31a+$row->Col31;
                    $totalCol32a=$totalCol32a+$row->Col32;
                    $totalCol33a=$totalCol33a+$row->Col33;
                    $totalCol34a=$totalCol34a+$row->Col34;
                    $totalCol35a=$totalCol35a+$row->Col35;
                    $totalCol36a=$totalCol36a+$row->Col36;

                    $nombre_descripcion = $row->codigo_prestacion;
                    if ($nombre_descripcion == "01010001"){
                        $nombre_descripcion = "Consulta o control médico integral en atención primaria";
      							}
                    if ($nombre_descripcion == "01010002"){
                        $nombre_descripcion = "Consulta o control médico integral en especialidades (Hosp. Mediana Complejidad)";
      							}
                    if ($nombre_descripcion == "01010003"){
                        $nombre_descripcion = "Consulta médica integral en servicio de urgencia (Hosp. Alta Complejidad)";
      							}
                    if ($nombre_descripcion == "01010004"){
                        $nombre_descripcion = "Consulta médica integral en C.R.S.";
      							}
                    if ($nombre_descripcion == "01010005"){
                        $nombre_descripcion = "Consulta médica integral en servicio de urgencia (Hosp. Mediana Complejidad)";
      							}
                    if ($nombre_descripcion == "01010006"){
                        $nombre_descripcion = "Asistencia de cardiólogo a cirugías no cardíacas";
      							}
                    if ($nombre_descripcion == "01010007"){
                        $nombre_descripcion = "Atención médica del recién nacido";
      							}
                    if ($nombre_descripcion == "01010008"){
                        $nombre_descripcion = "Consulta integral de especialidades en Cirugía, Ginecología y Obstetricia, Ortopedia y Traumatología (en CDT)";
      							}
                    if ($nombre_descripcion == "01010009"){
                        $nombre_descripcion = "Consulta integral de especialidades en Urología, Otorrinolaringología, Medicina Fisica y Rehabilitación, Dermatología, Pediatría y Subespecialidades (en CDT)";
      							}
                    if ($nombre_descripcion == "01010010"){
                        $nombre_descripcion = "Consulta integral de especialidades en Medicina Interna y Subespecialidades, Oftalmología, Neurología, Oncología (en CDT)";
      							}
                    if ($nombre_descripcion == "01010011"){
                        $nombre_descripcion = "Consulta integral de especialidades en Cirugía, Ginecología y Obstetricia, Ortopedia y Traumatología (Hosp. Alta Complejidad)";
      							}
                    if ($nombre_descripcion == "01010012"){
                        $nombre_descripcion = "Consulta integral de especialidades en Urología, Otorrinolaringología, Medicina Física y Rehabilitación, Dermatología, Pediatría y Subespecialidades (Hosp. Alta Complejidad)";
      							}
                    if ($nombre_descripcion == "01010013"){
                        $nombre_descripcion = "Consulta integral de especialidades en Medicina Interna y Subespecialidades, Oftalmología, Neurología, Oncología (Hosp. Alta Complejidad)";
      							}
                    if ($nombre_descripcion == "01013100"){
                        $nombre_descripcion = "Consulta por Telemedicina";
      							}
                    ?>
                <tr>
                    <td align='left' nowrap><?php echo $nombre_descripcion; ?></td>
                    <td align='right'><?php echo number_format($row->Col01,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col02,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col03,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col04,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col05,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col06,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col07,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col08,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col09,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col10,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col11,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col12,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col13,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col14,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col15,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col16,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col17,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col18,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col19,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col20,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col21,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col22,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col23,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col24,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col25,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col26,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col27,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col28,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col29,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col30,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col31,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col32,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col33,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col34,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col35,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col36,0,",",".")?></td>
                    <?php
                    $i++;
                }
                ?>
                </tr>
                <tr>
                    <td align='center'><strong>TOTAL ARANCEL MAI</strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol01a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol02a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol03a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol04a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol05a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol06a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol07a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol08a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol09a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol10a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol11a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol12a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol13a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol14a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol15a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol16a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol17a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol18a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol19a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol20a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol21a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol22a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol23a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol24a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol25a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol26a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol27a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol28a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol29a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol30a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol31a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol32a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol33a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol34a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol35a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol36a,0,",",".") ?></strong></td>
                </tr>
                <?php
                $query = 'SELECT a.codigo_prestacion,a.descripcion
                              ,sum(ifnull(b.Col01,0)) Col01
                              ,sum(ifnull(b.Col02,0)) Col02
                              ,sum(ifnull(b.Col03,0)) Col03
                              ,sum(ifnull(b.Col04,0)) Col04
									            ,sum(ifnull(b.Col05,0)) Col05
                              ,sum(ifnull(b.Col06,0)) Col06
                              ,sum(ifnull(b.Col07,0)) Col07
                              ,sum(ifnull(b.Col08,0)) Col08
                              ,sum(ifnull(b.Col09,0)) Col09
                              ,sum(ifnull(b.Col10,0)) Col10
                              ,sum(ifnull(b.Col11,0)) Col11
                              ,sum(ifnull(b.Col12,0)) Col12
                              ,sum(ifnull(b.Col13,0)) Col13
            									,sum(ifnull(b.Col14,0)) Col14
            									,sum(ifnull(b.Col15,0)) Col15
            									,sum(ifnull(b.Col16,0)) Col16
            									,sum(ifnull(b.Col17,0)) Col17
            									,sum(ifnull(b.Col18,0)) Col18
            									,sum(ifnull(b.Col19,0)) Col19
            									,sum(ifnull(b.Col20,0)) Col20
            									,sum(ifnull(b.Col21,0)) Col21
            									,sum(ifnull(b.Col22,0)) Col22
            									,sum(ifnull(b.Col23,0)) Col23
                              ,sum(ifnull(b.Col24,0)) Col24
                              ,sum(ifnull(b.Col25,0)) Col25
                              ,sum(ifnull(b.Col26,0)) Col26
                              ,sum(ifnull(b.Col27,0)) Col27
                              ,sum(ifnull(b.Col28,0)) Col28
                              ,sum(ifnull(b.Col29,0)) Col29
                              ,sum(ifnull(b.Col30,0)) Col30
                              ,sum(ifnull(b.Col31,0)) Col31
                              ,sum(ifnull(b.Col32,0)) Col32
                              ,sum(ifnull(b.Col33,0)) Col33
                              ,sum(ifnull(b.Col34,0)) Col34
                              ,sum(ifnull(b.Col35,0)) Col35
                              ,sum(ifnull(b.Col36,0)) Col36
                          FROM (select c.* from 2019prestaciones c where c.codigo_prestacion in("01010014","01010015","01010016","01010017","01010018","01012816")) a
                          left join 2019rems b on (a.id_prestacion=b.prestacion_id_prestacion)
                          AND (b.Mes in ('.$mes.')) AND (b.establecimiento_id_establecimiento in ('.$estab.'))
                          group by  a.codigo_prestacion,a.descripcion,a.id_prestacion
                          order by a.id_prestacion';
                $registro = DB::connection('mysql_rem')->select($query);

                $i=0;

                $totalCol01b=0;
    						$totalCol02b=0;
    						$totalCol03b=0;
    						$totalCol04b=0;
    						$totalCol05b=0;
    						$totalCol06b=0;
    						$totalCol07b=0;
    						$totalCol08b=0;
    						$totalCol09b=0;
    						$totalCol10b=0;
    						$totalCol11b=0;
    						$totalCol12b=0;
    						$totalCol13b=0;
    						$totalCol14b=0;
    						$totalCol15b=0;
    						$totalCol16b=0;
    						$totalCol17b=0;
    						$totalCol18b=0;
    						$totalCol19b=0;
    						$totalCol20b=0;
    						$totalCol21b=0;
    						$totalCol22b=0;
    						$totalCol23b=0;
    						$totalCol24b=0;
    						$totalCol25b=0;
    						$totalCol26b=0;
    						$totalCol27b=0;
    						$totalCol28b=0;
    						$totalCol29b=0;
    						$totalCol30b=0;
    						$totalCol31b=0;
    						$totalCol32b=0;
    						$totalCol33b=0;
    						$totalCol34b=0;
    						$totalCol35b=0;
    						$totalCol36b=0;

                foreach($registro as $row ){
                    $totalCol01b=$totalCol01b+$row->Col01;
                    $totalCol02b=$totalCol02b+$row->Col02;
                    $totalCol03b=$totalCol03b+$row->Col03;
                    $totalCol04b=$totalCol04b+$row->Col04;
                    $totalCol05b=$totalCol05b+$row->Col05;
                    $totalCol06b=$totalCol06b+$row->Col06;
                    $totalCol07b=$totalCol07b+$row->Col07;
                    $totalCol08b=$totalCol08b+$row->Col08;
                    $totalCol09b=$totalCol09b+$row->Col09;
                    $totalCol10b=$totalCol10b+$row->Col10;
                    $totalCol11b=$totalCol11b+$row->Col11;
                    $totalCol12b=$totalCol12b+$row->Col12;
                    $totalCol13b=$totalCol13b+$row->Col13;
                    $totalCol14b=$totalCol14b+$row->Col14;
                    $totalCol15b=$totalCol15b+$row->Col15;
                    $totalCol16b=$totalCol16b+$row->Col16;
                    $totalCol17b=$totalCol17b+$row->Col17;
                    $totalCol18b=$totalCol18b+$row->Col18;
                    $totalCol19b=$totalCol19b+$row->Col19;
                    $totalCol20b=$totalCol20b+$row->Col20;
                    $totalCol21b=$totalCol21b+$row->Col21;
                    $totalCol22b=$totalCol22b+$row->Col22;
                    $totalCol23b=$totalCol23b+$row->Col23;
                    $totalCol24b=$totalCol24b+$row->Col24;
                    $totalCol25b=$totalCol25b+$row->Col25;
                    $totalCol26b=$totalCol26b+$row->Col26;
                    $totalCol27b=$totalCol27b+$row->Col27;
                    $totalCol28b=$totalCol28b+$row->Col28;
                    $totalCol29b=$totalCol29b+$row->Col29;
                    $totalCol30b=$totalCol30b+$row->Col30;
                    $totalCol31b=$totalCol31b+$row->Col31;
                    $totalCol32b=$totalCol32b+$row->Col32;
                    $totalCol33b=$totalCol33b+$row->Col33;
                    $totalCol34b=$totalCol34b+$row->Col34;
                    $totalCol35b=$totalCol35b+$row->Col35;
                    $totalCol36b=$totalCol36b+$row->Col36;

                    $nombre_descripcion = $row->codigo_prestacion;
                    if ($nombre_descripcion == "01010014"){
                        $nombre_descripcion = "Consulta médica general";
      							}
                    if ($nombre_descripcion == "01010015"){
                        $nombre_descripcion = "Consultas de urgencia en Hospitales de baja complejidad";
      							}
                    if ($nombre_descripcion == "01010016"){
                        $nombre_descripcion = "Consultas de especialidad en hospitales de baja complejidad y establecimientos de APS";
      							}
                    if ($nombre_descripcion == "01010017"){
                        $nombre_descripcion = "Otras consulta médica de especialidades";
      							}
                    if ($nombre_descripcion == "01010018"){
                        $nombre_descripcion = "Consulta médica de especialidad en servicio de urgencia";
      							}
                    if ($nombre_descripcion == "01012816"){
                        $nombre_descripcion = "Consulta Médica de Especialidad en Obstetricia y Ginecología";
      							}
                    ?>
                <tr>
                    <td align='left' nowrap><?php echo $nombre_descripcion; ?></td>
                    <td align='right'><?php echo number_format($row->Col01,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col02,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col03,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col04,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col05,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col06,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col07,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col08,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col09,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col10,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col11,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col12,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col13,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col14,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col15,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col16,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col17,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col18,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col19,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col20,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col21,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col22,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col23,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col24,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col25,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col26,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col27,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col28,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col29,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col30,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col31,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col32,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col33,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col34,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col35,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col36,0,",",".")?></td>
                    <?php
                    $i++;
                }
                ?>
                </tr>
                <tr>
                    <td align='center'><strong>TOTAL ARANCEL MLE Y NO ARANCELADO</strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol01b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol02b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol03b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol04b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol05b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol06b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol07b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol08b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol09b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol10b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol11b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol12b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol13b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol14b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol15b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol16b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol17b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol18b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol19b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol20b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol21b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol22b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol23b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol24b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol25b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol26b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol27b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol28b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol29b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol30b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol31b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol32b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol33b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol34b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol35b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol36b,0,",",".") ?></strong></td>
                </tr>
                <tr>
                    <td align='center'><strong>TOTAL PRODUCCION</strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol01a + $totalCol01b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol02a + $totalCol02b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol03a + $totalCol03b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol04a + $totalCol04b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol05a + $totalCol05b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol06a + $totalCol06b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol07a + $totalCol07b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol08a + $totalCol08b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol09a + $totalCol09b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol10a + $totalCol10b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol11a + $totalCol11b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol12a + $totalCol12b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol13a + $totalCol13b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol14a + $totalCol14b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol15a + $totalCol15b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol16a + $totalCol16b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol17a + $totalCol17b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol18a + $totalCol18b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol19a + $totalCol19b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol20a + $totalCol20b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol21a + $totalCol21b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol22a + $totalCol22b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol23a + $totalCol23b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol24a + $totalCol24b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol25a + $totalCol25b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol26a + $totalCol26b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol27a + $totalCol27b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol28a + $totalCol28b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol29a + $totalCol29b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol30a + $totalCol30b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol31a + $totalCol31b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol32a + $totalCol32b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol33a + $totalCol33b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol34a + $totalCol34b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol35a + $totalCol35b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol36a + $totalCol36b,0,",",".") ?></strong></td>
                </tr>
                <!-- CONSULTAS POR OTROS PROFESIONALES DE LA SALUD -->
                <tr>
                    <td><strong>CONSULTAS POR OTROS PROFESIONALES DE LA SALUD</strong></td>
                    <td colspan="36"></td>
                </tr>
                <?php
                $query = 'SELECT a.codigo_prestacion,a.descripcion
                              ,sum(ifnull(b.Col01,0)) Col01
                              ,sum(ifnull(b.Col02,0)) Col02
                              ,sum(ifnull(b.Col03,0)) Col03
                              ,sum(ifnull(b.Col04,0)) Col04
									            ,sum(ifnull(b.Col05,0)) Col05
                              ,sum(ifnull(b.Col06,0)) Col06
                              ,sum(ifnull(b.Col07,0)) Col07
                              ,sum(ifnull(b.Col08,0)) Col08
                              ,sum(ifnull(b.Col09,0)) Col09
                              ,sum(ifnull(b.Col10,0)) Col10
                              ,sum(ifnull(b.Col11,0)) Col11
                              ,sum(ifnull(b.Col12,0)) Col12
                              ,sum(ifnull(b.Col13,0)) Col13
            									,sum(ifnull(b.Col14,0)) Col14
            									,sum(ifnull(b.Col15,0)) Col15
            									,sum(ifnull(b.Col16,0)) Col16
            									,sum(ifnull(b.Col17,0)) Col17
            									,sum(ifnull(b.Col18,0)) Col18
            									,sum(ifnull(b.Col19,0)) Col19
            									,sum(ifnull(b.Col20,0)) Col20
            									,sum(ifnull(b.Col21,0)) Col21
            									,sum(ifnull(b.Col22,0)) Col22
            									,sum(ifnull(b.Col23,0)) Col23
                              ,sum(ifnull(b.Col24,0)) Col24
                              ,sum(ifnull(b.Col25,0)) Col25
                              ,sum(ifnull(b.Col26,0)) Col26
                              ,sum(ifnull(b.Col27,0)) Col27
                              ,sum(ifnull(b.Col28,0)) Col28
                              ,sum(ifnull(b.Col29,0)) Col29
                              ,sum(ifnull(b.Col30,0)) Col30
                              ,sum(ifnull(b.Col31,0)) Col31
                              ,sum(ifnull(b.Col32,0)) Col32
                              ,sum(ifnull(b.Col33,0)) Col33
                              ,sum(ifnull(b.Col34,0)) Col34
                              ,sum(ifnull(b.Col35,0)) Col35
                              ,sum(ifnull(b.Col36,0)) Col36
                          FROM (select c.* from 2019prestaciones c where c.codigo_prestacion in("01010019","01010020","01010021","01010022","01010023","01010024")) a
                          left join 2019rems b on (a.id_prestacion=b.prestacion_id_prestacion)
                          AND (b.Mes in ('.$mes.')) AND (b.establecimiento_id_establecimiento in ('.$estab.'))
                          group by  a.codigo_prestacion,a.descripcion,a.id_prestacion
                          order by a.id_prestacion';
                $registro = DB::connection('mysql_rem')->select($query);

                $i=0;

                $totalCol01a=0;
    						$totalCol02a=0;
    						$totalCol03a=0;
    						$totalCol04a=0;
    						$totalCol05a=0;
    						$totalCol06a=0;
    						$totalCol07a=0;
    						$totalCol08a=0;
    						$totalCol09a=0;
    						$totalCol10a=0;
    						$totalCol11a=0;
    						$totalCol12a=0;
    						$totalCol13a=0;
    						$totalCol14a=0;
    						$totalCol15a=0;
    						$totalCol16a=0;
    						$totalCol17a=0;
    						$totalCol18a=0;
    						$totalCol19a=0;
    						$totalCol20a=0;
    						$totalCol21a=0;
    						$totalCol22a=0;
    						$totalCol23a=0;
    						$totalCol24a=0;
    						$totalCol25a=0;
    						$totalCol26a=0;
    						$totalCol27a=0;
    						$totalCol28a=0;
    						$totalCol29a=0;
    						$totalCol30a=0;
    						$totalCol31a=0;
    						$totalCol32a=0;
    						$totalCol33a=0;
    						$totalCol34a=0;
    						$totalCol35a=0;
    						$totalCol36a=0;

                foreach($registro as $row ){
                    $totalCol01a=$totalCol01a+$row->Col01;
                    $totalCol02a=$totalCol02a+$row->Col02;
                    $totalCol03a=$totalCol03a+$row->Col03;
                    $totalCol04a=$totalCol04a+$row->Col04;
                    $totalCol05a=$totalCol05a+$row->Col05;
                    $totalCol06a=$totalCol06a+$row->Col06;
                    $totalCol07a=$totalCol07a+$row->Col07;
                    $totalCol08a=$totalCol08a+$row->Col08;
                    $totalCol09a=$totalCol09a+$row->Col09;
                    $totalCol10a=$totalCol10a+$row->Col10;
                    $totalCol11a=$totalCol11a+$row->Col11;
                    $totalCol12a=$totalCol12a+$row->Col12;
                    $totalCol13a=$totalCol13a+$row->Col13;
                    $totalCol14a=$totalCol14a+$row->Col14;
                    $totalCol15a=$totalCol15a+$row->Col15;
                    $totalCol16a=$totalCol16a+$row->Col16;
                    $totalCol17a=$totalCol17a+$row->Col17;
                    $totalCol18a=$totalCol18a+$row->Col18;
                    $totalCol19a=$totalCol19a+$row->Col19;
                    $totalCol20a=$totalCol20a+$row->Col20;
                    $totalCol21a=$totalCol21a+$row->Col21;
                    $totalCol22a=$totalCol22a+$row->Col22;
                    $totalCol23a=$totalCol23a+$row->Col23;
                    $totalCol24a=$totalCol24a+$row->Col24;
                    $totalCol25a=$totalCol25a+$row->Col25;
                    $totalCol26a=$totalCol26a+$row->Col26;
                    $totalCol27a=$totalCol27a+$row->Col27;
                    $totalCol28a=$totalCol28a+$row->Col28;
                    $totalCol29a=$totalCol29a+$row->Col29;
                    $totalCol30a=$totalCol30a+$row->Col30;
                    $totalCol31a=$totalCol31a+$row->Col31;
                    $totalCol32a=$totalCol32a+$row->Col32;
                    $totalCol33a=$totalCol33a+$row->Col33;
                    $totalCol34a=$totalCol34a+$row->Col34;
                    $totalCol35a=$totalCol35a+$row->Col35;
                    $totalCol36a=$totalCol36a+$row->Col36;

                    $nombre_descripcion = $row->codigo_prestacion;
                    if ($nombre_descripcion == "01010019"){
                        $nombre_descripcion = "Consulta o control por enfermera, matrona o nutricionista";
      							}
                    if ($nombre_descripcion == "01010020"){
                        $nombre_descripcion = "Control de salud niño con EDP por enfermera";
      							}
                    if ($nombre_descripcion == "01010021"){
                        $nombre_descripcion = "Consulta o control por auxiliar de enfermería";
      							}
                    if ($nombre_descripcion == "01010022"){
                        $nombre_descripcion = "Consulta por fonoaudiólogo";
      							}
                    if ($nombre_descripcion == "01010023"){
                        $nombre_descripcion = "Atención kinesiológica integral ambulatoria";
      							}
                    if ($nombre_descripcion == "01010024"){
                        $nombre_descripcion = "Atención integral por terapeuta ocupacional";
      							}
                    ?>
                <tr>
                    <td align='left' nowrap><?php echo $nombre_descripcion; ?></td>
                    <td align='right'><?php echo number_format($row->Col01,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col02,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col03,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col04,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col05,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col06,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col07,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col08,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col09,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col10,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col11,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col12,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col13,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col14,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col15,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col16,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col17,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col18,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col19,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col20,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col21,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col22,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col23,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col24,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col25,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col26,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col27,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col28,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col29,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col30,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col31,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col32,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col33,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col34,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col35,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col36,0,",",".")?></td>
                    <?php
                    $i++;
                }
                ?>
                </tr>
                <tr>
                    <td align='center'><strong>TOTAL ARANCEL MAI</strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol01a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol02a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol03a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol04a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol05a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol06a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol07a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol08a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol09a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol10a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol11a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol12a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol13a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol14a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol15a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol16a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol17a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol18a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol19a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol20a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol21a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol22a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol23a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol24a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol25a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol26a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol27a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol28a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol29a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol30a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol31a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol32a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol33a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol34a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol35a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol36a,0,",",".") ?></strong></td>
                </tr>
                <?php
                $query = 'SELECT a.codigo_prestacion,a.descripcion
                              ,sum(ifnull(b.Col01,0)) Col01
                              ,sum(ifnull(b.Col02,0)) Col02
                              ,sum(ifnull(b.Col03,0)) Col03
                              ,sum(ifnull(b.Col04,0)) Col04
									            ,sum(ifnull(b.Col05,0)) Col05
                              ,sum(ifnull(b.Col06,0)) Col06
                              ,sum(ifnull(b.Col07,0)) Col07
                              ,sum(ifnull(b.Col08,0)) Col08
                              ,sum(ifnull(b.Col09,0)) Col09
                              ,sum(ifnull(b.Col10,0)) Col10
                              ,sum(ifnull(b.Col11,0)) Col11
                              ,sum(ifnull(b.Col12,0)) Col12
                              ,sum(ifnull(b.Col13,0)) Col13
            									,sum(ifnull(b.Col14,0)) Col14
            									,sum(ifnull(b.Col15,0)) Col15
            									,sum(ifnull(b.Col16,0)) Col16
            									,sum(ifnull(b.Col17,0)) Col17
            									,sum(ifnull(b.Col18,0)) Col18
            									,sum(ifnull(b.Col19,0)) Col19
            									,sum(ifnull(b.Col20,0)) Col20
            									,sum(ifnull(b.Col21,0)) Col21
            									,sum(ifnull(b.Col22,0)) Col22
            									,sum(ifnull(b.Col23,0)) Col23
                              ,sum(ifnull(b.Col24,0)) Col24
                              ,sum(ifnull(b.Col25,0)) Col25
                              ,sum(ifnull(b.Col26,0)) Col26
                              ,sum(ifnull(b.Col27,0)) Col27
                              ,sum(ifnull(b.Col28,0)) Col28
                              ,sum(ifnull(b.Col29,0)) Col29
                              ,sum(ifnull(b.Col30,0)) Col30
                              ,sum(ifnull(b.Col31,0)) Col31
                              ,sum(ifnull(b.Col32,0)) Col32
                              ,sum(ifnull(b.Col33,0)) Col33
                              ,sum(ifnull(b.Col34,0)) Col34
                              ,sum(ifnull(b.Col35,0)) Col35
                              ,sum(ifnull(b.Col36,0)) Col36
                          FROM (select c.* from 2019prestaciones c where c.codigo_prestacion in("01010025","01012817","01010026","01010027","01010028")) a
                          left join 2019rems b on (a.id_prestacion=b.prestacion_id_prestacion)
                          AND (b.Mes in ('.$mes.')) AND (b.establecimiento_id_establecimiento in ('.$estab.'))
                          group by  a.codigo_prestacion,a.descripcion,a.id_prestacion
                          order by a.id_prestacion';
                $registro = DB::connection('mysql_rem')->select($query);

                $i=0;

                $totalCol01b=0;
    						$totalCol02b=0;
    						$totalCol03b=0;
    						$totalCol04b=0;
    						$totalCol05b=0;
    						$totalCol06b=0;
    						$totalCol07b=0;
    						$totalCol08b=0;
    						$totalCol09b=0;
    						$totalCol10b=0;
    						$totalCol11b=0;
    						$totalCol12b=0;
    						$totalCol13b=0;
    						$totalCol14b=0;
    						$totalCol15b=0;
    						$totalCol16b=0;
    						$totalCol17b=0;
    						$totalCol18b=0;
    						$totalCol19b=0;
    						$totalCol20b=0;
    						$totalCol21b=0;
    						$totalCol22b=0;
    						$totalCol23b=0;
    						$totalCol24b=0;
    						$totalCol25b=0;
    						$totalCol26b=0;
    						$totalCol27b=0;
    						$totalCol28b=0;
    						$totalCol29b=0;
    						$totalCol30b=0;
    						$totalCol31b=0;
    						$totalCol32b=0;
    						$totalCol33b=0;
    						$totalCol34b=0;
    						$totalCol35b=0;
    						$totalCol36b=0;

                foreach($registro as $row ){
                    $totalCol01b=$totalCol01b+$row->Col01;
                    $totalCol02b=$totalCol02b+$row->Col02;
                    $totalCol03b=$totalCol03b+$row->Col03;
                    $totalCol04b=$totalCol04b+$row->Col04;
                    $totalCol05b=$totalCol05b+$row->Col05;
                    $totalCol06b=$totalCol06b+$row->Col06;
                    $totalCol07b=$totalCol07b+$row->Col07;
                    $totalCol08b=$totalCol08b+$row->Col08;
                    $totalCol09b=$totalCol09b+$row->Col09;
                    $totalCol10b=$totalCol10b+$row->Col10;
                    $totalCol11b=$totalCol11b+$row->Col11;
                    $totalCol12b=$totalCol12b+$row->Col12;
                    $totalCol13b=$totalCol13b+$row->Col13;
                    $totalCol14b=$totalCol14b+$row->Col14;
                    $totalCol15b=$totalCol15b+$row->Col15;
                    $totalCol16b=$totalCol16b+$row->Col16;
                    $totalCol17b=$totalCol17b+$row->Col17;
                    $totalCol18b=$totalCol18b+$row->Col18;
                    $totalCol19b=$totalCol19b+$row->Col19;
                    $totalCol20b=$totalCol20b+$row->Col20;
                    $totalCol21b=$totalCol21b+$row->Col21;
                    $totalCol22b=$totalCol22b+$row->Col22;
                    $totalCol23b=$totalCol23b+$row->Col23;
                    $totalCol24b=$totalCol24b+$row->Col24;
                    $totalCol25b=$totalCol25b+$row->Col25;
                    $totalCol26b=$totalCol26b+$row->Col26;
                    $totalCol27b=$totalCol27b+$row->Col27;
                    $totalCol28b=$totalCol28b+$row->Col28;
                    $totalCol29b=$totalCol29b+$row->Col29;
                    $totalCol30b=$totalCol30b+$row->Col30;
                    $totalCol31b=$totalCol31b+$row->Col31;
                    $totalCol32b=$totalCol32b+$row->Col32;
                    $totalCol33b=$totalCol33b+$row->Col33;
                    $totalCol34b=$totalCol34b+$row->Col34;
                    $totalCol35b=$totalCol35b+$row->Col35;
                    $totalCol36b=$totalCol36b+$row->Col36;

                    $nombre_descripcion = $row->codigo_prestacion;
                    if ($nombre_descripcion == "01010025"){
                        $nombre_descripcion = "Consulta por otros profesionales";
      							}
                    if ($nombre_descripcion == "01012817"){
                        $nombre_descripcion = "Consulta por Asistente Social";
      							}
                    if ($nombre_descripcion == "01010026"){
                        $nombre_descripcion = "Consultas/ Controles de Especialidades Odontológica";
      							}
                    if ($nombre_descripcion == "01010027"){
                        $nombre_descripcion = "Consultas/Controles de morbilidad odontológica";
      							}
                    if ($nombre_descripcion == "01010028"){
                        $nombre_descripcion = "Consultas de urgencia odontológica";
      							}
                    ?>
                <tr>
                    <td align='left' nowrap><?php echo $nombre_descripcion; ?></td>
                    <td align='right'><?php echo number_format($row->Col01,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col02,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col03,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col04,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col05,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col06,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col07,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col08,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col09,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col10,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col11,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col12,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col13,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col14,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col15,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col16,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col17,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col18,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col19,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col20,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col21,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col22,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col23,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col24,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col25,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col26,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col27,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col28,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col29,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col30,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col31,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col32,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col33,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col34,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col35,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col36,0,",",".")?></td>
                    <?php
                    $i++;
                }
                ?>
                </tr>
                <tr>
                    <td align='center'><strong>TOTAL ARANCEL MLE Y NO ARANCELADO</strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol01b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol02b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol03b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol04b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol05b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol06b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol07b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol08b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol09b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol10b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol11b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol12b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol13b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol14b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol15b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol16b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol17b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol18b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol19b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol20b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol21b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol22b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol23b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol24b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol25b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol26b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol27b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol28b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol29b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol30b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol31b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol32b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol33b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol34b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol35b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol36b,0,",",".") ?></strong></td>
                </tr>
                <tr>
                    <td align='center'><strong>TOTAL PRODUCCION</strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol01a + $totalCol01b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol02a + $totalCol02b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol03a + $totalCol03b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol04a + $totalCol04b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol05a + $totalCol05b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol06a + $totalCol06b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol07a + $totalCol07b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol08a + $totalCol08b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol09a + $totalCol09b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol10a + $totalCol10b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol11a + $totalCol11b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol12a + $totalCol12b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol13a + $totalCol13b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol14a + $totalCol14b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol15a + $totalCol15b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol16a + $totalCol16b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol17a + $totalCol17b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol18a + $totalCol18b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol19a + $totalCol19b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol20a + $totalCol20b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol21a + $totalCol21b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol22a + $totalCol22b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol23a + $totalCol23b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol24a + $totalCol24b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol25a + $totalCol25b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol26a + $totalCol26b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol27a + $totalCol27b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol28a + $totalCol28b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol29a + $totalCol29b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol30a + $totalCol30b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol31a + $totalCol31b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol32a + $totalCol32b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol33a + $totalCol33b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol34a + $totalCol34b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol35a + $totalCol35b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol36a + $totalCol36b,0,",",".") ?></strong></td>
                </tr>
                <!-- CONSULTAS POR OTROS PROFESIONALES DE LA SALUD -->
                <tr>
                    <td><strong>EDUCACION DE GRUPO</strong></td>
                    <td colspan="36"></td>
                </tr>
                <?php
                $query = 'SELECT a.codigo_prestacion,a.descripcion
                              ,sum(ifnull(b.Col01,0)) Col01
                              ,sum(ifnull(b.Col02,0)) Col02
                              ,sum(ifnull(b.Col03,0)) Col03
                              ,sum(ifnull(b.Col04,0)) Col04
									            ,sum(ifnull(b.Col05,0)) Col05
                              ,sum(ifnull(b.Col06,0)) Col06
                              ,sum(ifnull(b.Col07,0)) Col07
                              ,sum(ifnull(b.Col08,0)) Col08
                              ,sum(ifnull(b.Col09,0)) Col09
                              ,sum(ifnull(b.Col10,0)) Col10
                              ,sum(ifnull(b.Col11,0)) Col11
                              ,sum(ifnull(b.Col12,0)) Col12
                              ,sum(ifnull(b.Col13,0)) Col13
            									,sum(ifnull(b.Col14,0)) Col14
            									,sum(ifnull(b.Col15,0)) Col15
            									,sum(ifnull(b.Col16,0)) Col16
            									,sum(ifnull(b.Col17,0)) Col17
            									,sum(ifnull(b.Col18,0)) Col18
            									,sum(ifnull(b.Col19,0)) Col19
            									,sum(ifnull(b.Col20,0)) Col20
            									,sum(ifnull(b.Col21,0)) Col21
            									,sum(ifnull(b.Col22,0)) Col22
            									,sum(ifnull(b.Col23,0)) Col23
                              ,sum(ifnull(b.Col24,0)) Col24
                              ,sum(ifnull(b.Col25,0)) Col25
                              ,sum(ifnull(b.Col26,0)) Col26
                              ,sum(ifnull(b.Col27,0)) Col27
                              ,sum(ifnull(b.Col28,0)) Col28
                              ,sum(ifnull(b.Col29,0)) Col29
                              ,sum(ifnull(b.Col30,0)) Col30
                              ,sum(ifnull(b.Col31,0)) Col31
                              ,sum(ifnull(b.Col32,0)) Col32
                              ,sum(ifnull(b.Col33,0)) Col33
                              ,sum(ifnull(b.Col34,0)) Col34
                              ,sum(ifnull(b.Col35,0)) Col35
                              ,sum(ifnull(b.Col36,0)) Col36
                          FROM (select c.* from 2019prestaciones c where c.codigo_prestacion in("01010029","01010030","01010031","01010032")) a
                          left join 2019rems b on (a.id_prestacion=b.prestacion_id_prestacion)
                          AND (b.Mes in ('.$mes.')) AND (b.establecimiento_id_establecimiento in ('.$estab.'))
                          group by  a.codigo_prestacion,a.descripcion,a.id_prestacion
                          order by a.id_prestacion';
                $registro = DB::connection('mysql_rem')->select($query);

                $i=0;

                $totalCol01a=0;
    						$totalCol02a=0;
    						$totalCol03a=0;
    						$totalCol04a=0;
    						$totalCol05a=0;
    						$totalCol06a=0;
    						$totalCol07a=0;
    						$totalCol08a=0;
    						$totalCol09a=0;
    						$totalCol10a=0;
    						$totalCol11a=0;
    						$totalCol12a=0;
    						$totalCol13a=0;
    						$totalCol14a=0;
    						$totalCol15a=0;
    						$totalCol16a=0;
    						$totalCol17a=0;
    						$totalCol18a=0;
    						$totalCol19a=0;
    						$totalCol20a=0;
    						$totalCol21a=0;
    						$totalCol22a=0;
    						$totalCol23a=0;
    						$totalCol24a=0;
    						$totalCol25a=0;
    						$totalCol26a=0;
    						$totalCol27a=0;
    						$totalCol28a=0;
    						$totalCol29a=0;
    						$totalCol30a=0;
    						$totalCol31a=0;
    						$totalCol32a=0;
    						$totalCol33a=0;
    						$totalCol34a=0;
    						$totalCol35a=0;
    						$totalCol36a=0;

                foreach($registro as $row ){
                    $totalCol01a=$totalCol01a+$row->Col01;
                    $totalCol02a=$totalCol02a+$row->Col02;
                    $totalCol03a=$totalCol03a+$row->Col03;
                    $totalCol04a=$totalCol04a+$row->Col04;
                    $totalCol05a=$totalCol05a+$row->Col05;
                    $totalCol06a=$totalCol06a+$row->Col06;
                    $totalCol07a=$totalCol07a+$row->Col07;
                    $totalCol08a=$totalCol08a+$row->Col08;
                    $totalCol09a=$totalCol09a+$row->Col09;
                    $totalCol10a=$totalCol10a+$row->Col10;
                    $totalCol11a=$totalCol11a+$row->Col11;
                    $totalCol12a=$totalCol12a+$row->Col12;
                    $totalCol13a=$totalCol13a+$row->Col13;
                    $totalCol14a=$totalCol14a+$row->Col14;
                    $totalCol15a=$totalCol15a+$row->Col15;
                    $totalCol16a=$totalCol16a+$row->Col16;
                    $totalCol17a=$totalCol17a+$row->Col17;
                    $totalCol18a=$totalCol18a+$row->Col18;
                    $totalCol19a=$totalCol19a+$row->Col19;
                    $totalCol20a=$totalCol20a+$row->Col20;
                    $totalCol21a=$totalCol21a+$row->Col21;
                    $totalCol22a=$totalCol22a+$row->Col22;
                    $totalCol23a=$totalCol23a+$row->Col23;
                    $totalCol24a=$totalCol24a+$row->Col24;
                    $totalCol25a=$totalCol25a+$row->Col25;
                    $totalCol26a=$totalCol26a+$row->Col26;
                    $totalCol27a=$totalCol27a+$row->Col27;
                    $totalCol28a=$totalCol28a+$row->Col28;
                    $totalCol29a=$totalCol29a+$row->Col29;
                    $totalCol30a=$totalCol30a+$row->Col30;
                    $totalCol31a=$totalCol31a+$row->Col31;
                    $totalCol32a=$totalCol32a+$row->Col32;
                    $totalCol33a=$totalCol33a+$row->Col33;
                    $totalCol34a=$totalCol34a+$row->Col34;
                    $totalCol35a=$totalCol35a+$row->Col35;
                    $totalCol36a=$totalCol36a+$row->Col36;

                    $nombre_descripcion = $row->codigo_prestacion;
                    if ($nombre_descripcion == "01010029"){
                        $nombre_descripcion = "Educación de grupo por médico";
      							}
                    if ($nombre_descripcion == "01010030"){
                        $nombre_descripcion = "Educación de grupo por enfermera, matrona o nutricionista";
      							}
                    if ($nombre_descripcion == "01010031"){
                        $nombre_descripcion = "Educación de grupo por asistente social";
      							}
                    if ($nombre_descripcion == "01010032"){
                        $nombre_descripcion = "Educación de grupo por auxiliar de enfermería";
      							}
                    ?>
                <tr>
                    <td align='left' nowrap><?php echo $nombre_descripcion; ?></td>
                    <td align='right'><?php echo number_format($row->Col01,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col02,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col03,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col04,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col05,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col06,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col07,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col08,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col09,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col10,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col11,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col12,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col13,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col14,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col15,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col16,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col17,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col18,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col19,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col20,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col21,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col22,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col23,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col24,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col25,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col26,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col27,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col28,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col29,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col30,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col31,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col32,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col33,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col34,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col35,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col36,0,",",".")?></td>
                    <?php
                    $i++;
                }
                ?>
                </tr>
                <tr>
                    <td align='center'><strong>TOTAL ARANCEL MAI</strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol01a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol02a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol03a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol04a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol05a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol06a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol07a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol08a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol09a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol10a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol11a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol12a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol13a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol14a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol15a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol16a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol17a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol18a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol19a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol20a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol21a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol22a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol23a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol24a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol25a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol26a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol27a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol28a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol29a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol30a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol31a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol32a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol33a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol34a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol35a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol36a,0,",",".") ?></strong></td>
                </tr>
                <?php
                $query = 'SELECT a.codigo_prestacion,a.descripcion
                              ,sum(ifnull(b.Col01,0)) Col01
                              ,sum(ifnull(b.Col02,0)) Col02
                              ,sum(ifnull(b.Col03,0)) Col03
                              ,sum(ifnull(b.Col04,0)) Col04
									            ,sum(ifnull(b.Col05,0)) Col05
                              ,sum(ifnull(b.Col06,0)) Col06
                              ,sum(ifnull(b.Col07,0)) Col07
                              ,sum(ifnull(b.Col08,0)) Col08
                              ,sum(ifnull(b.Col09,0)) Col09
                              ,sum(ifnull(b.Col10,0)) Col10
                              ,sum(ifnull(b.Col11,0)) Col11
                              ,sum(ifnull(b.Col12,0)) Col12
                              ,sum(ifnull(b.Col13,0)) Col13
            									,sum(ifnull(b.Col14,0)) Col14
            									,sum(ifnull(b.Col15,0)) Col15
            									,sum(ifnull(b.Col16,0)) Col16
            									,sum(ifnull(b.Col17,0)) Col17
            									,sum(ifnull(b.Col18,0)) Col18
            									,sum(ifnull(b.Col19,0)) Col19
            									,sum(ifnull(b.Col20,0)) Col20
            									,sum(ifnull(b.Col21,0)) Col21
            									,sum(ifnull(b.Col22,0)) Col22
            									,sum(ifnull(b.Col23,0)) Col23
                              ,sum(ifnull(b.Col24,0)) Col24
                              ,sum(ifnull(b.Col25,0)) Col25
                              ,sum(ifnull(b.Col26,0)) Col26
                              ,sum(ifnull(b.Col27,0)) Col27
                              ,sum(ifnull(b.Col28,0)) Col28
                              ,sum(ifnull(b.Col29,0)) Col29
                              ,sum(ifnull(b.Col30,0)) Col30
                              ,sum(ifnull(b.Col31,0)) Col31
                              ,sum(ifnull(b.Col32,0)) Col32
                              ,sum(ifnull(b.Col33,0)) Col33
                              ,sum(ifnull(b.Col34,0)) Col34
                              ,sum(ifnull(b.Col35,0)) Col35
                              ,sum(ifnull(b.Col36,0)) Col36
                          FROM (select c.* from 2019prestaciones c where c.codigo_prestacion in("01010033")) a
                          left join 2019rems b on (a.id_prestacion=b.prestacion_id_prestacion)
                          AND (b.Mes in ('.$mes.')) AND (b.establecimiento_id_establecimiento in ('.$estab.'))
                          group by  a.codigo_prestacion,a.descripcion,a.id_prestacion
                          order by a.id_prestacion';
                $registro = DB::connection('mysql_rem')->select($query);

                $i=0;

                $totalCol01b=0;
    						$totalCol02b=0;
    						$totalCol03b=0;
    						$totalCol04b=0;
    						$totalCol05b=0;
    						$totalCol06b=0;
    						$totalCol07b=0;
    						$totalCol08b=0;
    						$totalCol09b=0;
    						$totalCol10b=0;
    						$totalCol11b=0;
    						$totalCol12b=0;
    						$totalCol13b=0;
    						$totalCol14b=0;
    						$totalCol15b=0;
    						$totalCol16b=0;
    						$totalCol17b=0;
    						$totalCol18b=0;
    						$totalCol19b=0;
    						$totalCol20b=0;
    						$totalCol21b=0;
    						$totalCol22b=0;
    						$totalCol23b=0;
    						$totalCol24b=0;
    						$totalCol25b=0;
    						$totalCol26b=0;
    						$totalCol27b=0;
    						$totalCol28b=0;
    						$totalCol29b=0;
    						$totalCol30b=0;
    						$totalCol31b=0;
    						$totalCol32b=0;
    						$totalCol33b=0;
    						$totalCol34b=0;
    						$totalCol35b=0;
    						$totalCol36b=0;

                foreach($registro as $row ){
                    $totalCol01b=$totalCol01b+$row->Col01;
                    $totalCol02b=$totalCol02b+$row->Col02;
                    $totalCol03b=$totalCol03b+$row->Col03;
                    $totalCol04b=$totalCol04b+$row->Col04;
                    $totalCol05b=$totalCol05b+$row->Col05;
                    $totalCol06b=$totalCol06b+$row->Col06;
                    $totalCol07b=$totalCol07b+$row->Col07;
                    $totalCol08b=$totalCol08b+$row->Col08;
                    $totalCol09b=$totalCol09b+$row->Col09;
                    $totalCol10b=$totalCol10b+$row->Col10;
                    $totalCol11b=$totalCol11b+$row->Col11;
                    $totalCol12b=$totalCol12b+$row->Col12;
                    $totalCol13b=$totalCol13b+$row->Col13;
                    $totalCol14b=$totalCol14b+$row->Col14;
                    $totalCol15b=$totalCol15b+$row->Col15;
                    $totalCol16b=$totalCol16b+$row->Col16;
                    $totalCol17b=$totalCol17b+$row->Col17;
                    $totalCol18b=$totalCol18b+$row->Col18;
                    $totalCol19b=$totalCol19b+$row->Col19;
                    $totalCol20b=$totalCol20b+$row->Col20;
                    $totalCol21b=$totalCol21b+$row->Col21;
                    $totalCol22b=$totalCol22b+$row->Col22;
                    $totalCol23b=$totalCol23b+$row->Col23;
                    $totalCol24b=$totalCol24b+$row->Col24;
                    $totalCol25b=$totalCol25b+$row->Col25;
                    $totalCol26b=$totalCol26b+$row->Col26;
                    $totalCol27b=$totalCol27b+$row->Col27;
                    $totalCol28b=$totalCol28b+$row->Col28;
                    $totalCol29b=$totalCol29b+$row->Col29;
                    $totalCol30b=$totalCol30b+$row->Col30;
                    $totalCol31b=$totalCol31b+$row->Col31;
                    $totalCol32b=$totalCol32b+$row->Col32;
                    $totalCol33b=$totalCol33b+$row->Col33;
                    $totalCol34b=$totalCol34b+$row->Col34;
                    $totalCol35b=$totalCol35b+$row->Col35;
                    $totalCol36b=$totalCol36b+$row->Col36;

                    $nombre_descripcion = $row->codigo_prestacion;
                    if ($nombre_descripcion == "01010033"){
                        $nombre_descripcion = "Educación de grupo por otro integrante del equipo de salud";
      							}
                    ?>
                <tr>
                    <td align='left' nowrap><?php echo $nombre_descripcion; ?></td>
                    <td align='right'><?php echo number_format($row->Col01,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col02,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col03,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col04,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col05,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col06,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col07,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col08,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col09,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col10,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col11,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col12,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col13,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col14,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col15,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col16,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col17,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col18,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col19,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col20,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col21,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col22,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col23,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col24,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col25,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col26,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col27,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col28,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col29,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col30,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col31,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col32,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col33,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col34,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col35,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col36,0,",",".")?></td>
                    <?php
                    $i++;
                }
                ?>
                </tr>
                <tr>
                    <td align='center'><strong>TOTAL ARANCEL MLE Y NO ARANCELADO</strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol01b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol02b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol03b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol04b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol05b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol06b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol07b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol08b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol09b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol10b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol11b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol12b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol13b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol14b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol15b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol16b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol17b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol18b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol19b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol20b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol21b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol22b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol23b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol24b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol25b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol26b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol27b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol28b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol29b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol30b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol31b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol32b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol33b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol34b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol35b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol36b,0,",",".") ?></strong></td>
                </tr>
                <tr>
                    <td align='center'><strong>TOTAL PRODUCCION</strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol01a + $totalCol01b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol02a + $totalCol02b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol03a + $totalCol03b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol04a + $totalCol04b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol05a + $totalCol05b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol06a + $totalCol06b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol07a + $totalCol07b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol08a + $totalCol08b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol09a + $totalCol09b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol10a + $totalCol10b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol11a + $totalCol11b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol12a + $totalCol12b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol13a + $totalCol13b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol14a + $totalCol14b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol15a + $totalCol15b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol16a + $totalCol16b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol17a + $totalCol17b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol18a + $totalCol18b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol19a + $totalCol19b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol20a + $totalCol20b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol21a + $totalCol21b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol22a + $totalCol22b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol23a + $totalCol23b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol24a + $totalCol24b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol25a + $totalCol25b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol26a + $totalCol26b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol27a + $totalCol27b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol28a + $totalCol28b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol29a + $totalCol29b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol30a + $totalCol30b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol31a + $totalCol31b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol32a + $totalCol32b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol33a + $totalCol33b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol34a + $totalCol34b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol35a + $totalCol35b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol36a + $totalCol36b,0,",",".") ?></strong></td>
                </tr>
                <tr>
                    <td><strong>VISITAS DOMICILIARIAS</strong></td>
                    <td colspan="36"></td>
                </tr>
                <?php
                $query = 'SELECT a.codigo_prestacion,a.descripcion
                              ,sum(ifnull(b.Col01,0)) Col01
                              ,sum(ifnull(b.Col02,0)) Col02
                              ,sum(ifnull(b.Col03,0)) Col03
                              ,sum(ifnull(b.Col04,0)) Col04
									            ,sum(ifnull(b.Col05,0)) Col05
                              ,sum(ifnull(b.Col06,0)) Col06
                              ,sum(ifnull(b.Col07,0)) Col07
                              ,sum(ifnull(b.Col08,0)) Col08
                              ,sum(ifnull(b.Col09,0)) Col09
                              ,sum(ifnull(b.Col10,0)) Col10
                              ,sum(ifnull(b.Col11,0)) Col11
                              ,sum(ifnull(b.Col12,0)) Col12
                              ,sum(ifnull(b.Col13,0)) Col13
            									,sum(ifnull(b.Col14,0)) Col14
            									,sum(ifnull(b.Col15,0)) Col15
            									,sum(ifnull(b.Col16,0)) Col16
            									,sum(ifnull(b.Col17,0)) Col17
            									,sum(ifnull(b.Col18,0)) Col18
            									,sum(ifnull(b.Col19,0)) Col19
            									,sum(ifnull(b.Col20,0)) Col20
            									,sum(ifnull(b.Col21,0)) Col21
            									,sum(ifnull(b.Col22,0)) Col22
            									,sum(ifnull(b.Col23,0)) Col23
                              ,sum(ifnull(b.Col24,0)) Col24
                              ,sum(ifnull(b.Col25,0)) Col25
                              ,sum(ifnull(b.Col26,0)) Col26
                              ,sum(ifnull(b.Col27,0)) Col27
                              ,sum(ifnull(b.Col28,0)) Col28
                              ,sum(ifnull(b.Col29,0)) Col29
                              ,sum(ifnull(b.Col30,0)) Col30
                              ,sum(ifnull(b.Col31,0)) Col31
                              ,sum(ifnull(b.Col32,0)) Col32
                              ,sum(ifnull(b.Col33,0)) Col33
                              ,sum(ifnull(b.Col34,0)) Col34
                              ,sum(ifnull(b.Col35,0)) Col35
                              ,sum(ifnull(b.Col36,0)) Col36
                          FROM (select c.* from 2019prestaciones c where c.codigo_prestacion in("01010034","01010035","01010036")) a
                          left join 2019rems b on (a.id_prestacion=b.prestacion_id_prestacion)
                          AND (b.Mes in ('.$mes.')) AND (b.establecimiento_id_establecimiento in ('.$estab.'))
                          group by  a.codigo_prestacion,a.descripcion,a.id_prestacion
                          order by a.id_prestacion';
                $registro = DB::connection('mysql_rem')->select($query);

                $i=0;

                $totalCol01a=0;
    						$totalCol02a=0;
    						$totalCol03a=0;
    						$totalCol04a=0;
    						$totalCol05a=0;
    						$totalCol06a=0;
    						$totalCol07a=0;
    						$totalCol08a=0;
    						$totalCol09a=0;
    						$totalCol10a=0;
    						$totalCol11a=0;
    						$totalCol12a=0;
    						$totalCol13a=0;
    						$totalCol14a=0;
    						$totalCol15a=0;
    						$totalCol16a=0;
    						$totalCol17a=0;
    						$totalCol18a=0;
    						$totalCol19a=0;
    						$totalCol20a=0;
    						$totalCol21a=0;
    						$totalCol22a=0;
    						$totalCol23a=0;
    						$totalCol24a=0;
    						$totalCol25a=0;
    						$totalCol26a=0;
    						$totalCol27a=0;
    						$totalCol28a=0;
    						$totalCol29a=0;
    						$totalCol30a=0;
    						$totalCol31a=0;
    						$totalCol32a=0;
    						$totalCol33a=0;
    						$totalCol34a=0;
    						$totalCol35a=0;
    						$totalCol36a=0;

                foreach($registro as $row ){
                    $totalCol01a=$totalCol01a+$row->Col01;
                    $totalCol02a=$totalCol02a+$row->Col02;
                    $totalCol03a=$totalCol03a+$row->Col03;
                    $totalCol04a=$totalCol04a+$row->Col04;
                    $totalCol05a=$totalCol05a+$row->Col05;
                    $totalCol06a=$totalCol06a+$row->Col06;
                    $totalCol07a=$totalCol07a+$row->Col07;
                    $totalCol08a=$totalCol08a+$row->Col08;
                    $totalCol09a=$totalCol09a+$row->Col09;
                    $totalCol10a=$totalCol10a+$row->Col10;
                    $totalCol11a=$totalCol11a+$row->Col11;
                    $totalCol12a=$totalCol12a+$row->Col12;
                    $totalCol13a=$totalCol13a+$row->Col13;
                    $totalCol14a=$totalCol14a+$row->Col14;
                    $totalCol15a=$totalCol15a+$row->Col15;
                    $totalCol16a=$totalCol16a+$row->Col16;
                    $totalCol17a=$totalCol17a+$row->Col17;
                    $totalCol18a=$totalCol18a+$row->Col18;
                    $totalCol19a=$totalCol19a+$row->Col19;
                    $totalCol20a=$totalCol20a+$row->Col20;
                    $totalCol21a=$totalCol21a+$row->Col21;
                    $totalCol22a=$totalCol22a+$row->Col22;
                    $totalCol23a=$totalCol23a+$row->Col23;
                    $totalCol24a=$totalCol24a+$row->Col24;
                    $totalCol25a=$totalCol25a+$row->Col25;
                    $totalCol26a=$totalCol26a+$row->Col26;
                    $totalCol27a=$totalCol27a+$row->Col27;
                    $totalCol28a=$totalCol28a+$row->Col28;
                    $totalCol29a=$totalCol29a+$row->Col29;
                    $totalCol30a=$totalCol30a+$row->Col30;
                    $totalCol31a=$totalCol31a+$row->Col31;
                    $totalCol32a=$totalCol32a+$row->Col32;
                    $totalCol33a=$totalCol33a+$row->Col33;
                    $totalCol34a=$totalCol34a+$row->Col34;
                    $totalCol35a=$totalCol35a+$row->Col35;
                    $totalCol36a=$totalCol36a+$row->Col36;

                    $nombre_descripcion = $row->codigo_prestacion;
                    if ($nombre_descripcion == "01010034"){
                        $nombre_descripcion = "Visita a domicilio por enfermera, matrona o nutricionista";
      							}
                    if ($nombre_descripcion == "01010035"){
                        $nombre_descripcion = "Visita a domicilio por asistente social";
      							}
                    if ($nombre_descripcion == "01010036"){
                        $nombre_descripcion = "Visita a domicilio por auxiliar de enfermería";
      							}
                    ?>
                <tr>
                    <td align='left' nowrap><?php echo $nombre_descripcion; ?></td>
                    <td align='right'><?php echo number_format($row->Col01,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col02,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col03,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col04,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col05,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col06,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col07,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col08,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col09,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col10,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col11,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col12,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col13,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col14,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col15,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col16,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col17,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col18,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col19,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col20,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col21,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col22,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col23,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col24,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col25,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col26,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col27,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col28,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col29,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col30,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col31,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col32,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col33,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col34,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col35,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col36,0,",",".")?></td>
                    <?php
                    $i++;
                }
                ?>
                </tr>
                <tr>
                    <td align='center'><strong>TOTAL ARANCEL MAI</strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol01a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol02a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol03a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol04a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol05a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol06a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol07a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol08a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol09a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol10a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol11a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol12a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol13a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol14a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol15a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol16a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol17a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol18a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol19a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol20a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol21a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol22a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol23a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol24a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol25a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol26a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol27a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol28a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol29a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol30a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol31a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol32a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol33a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol34a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol35a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol36a,0,",",".") ?></strong></td>
                </tr>
                <?php
                $query = 'SELECT a.codigo_prestacion,a.descripcion
                              ,sum(ifnull(b.Col01,0)) Col01
                              ,sum(ifnull(b.Col02,0)) Col02
                              ,sum(ifnull(b.Col03,0)) Col03
                              ,sum(ifnull(b.Col04,0)) Col04
									            ,sum(ifnull(b.Col05,0)) Col05
                              ,sum(ifnull(b.Col06,0)) Col06
                              ,sum(ifnull(b.Col07,0)) Col07
                              ,sum(ifnull(b.Col08,0)) Col08
                              ,sum(ifnull(b.Col09,0)) Col09
                              ,sum(ifnull(b.Col10,0)) Col10
                              ,sum(ifnull(b.Col11,0)) Col11
                              ,sum(ifnull(b.Col12,0)) Col12
                              ,sum(ifnull(b.Col13,0)) Col13
            									,sum(ifnull(b.Col14,0)) Col14
            									,sum(ifnull(b.Col15,0)) Col15
            									,sum(ifnull(b.Col16,0)) Col16
            									,sum(ifnull(b.Col17,0)) Col17
            									,sum(ifnull(b.Col18,0)) Col18
            									,sum(ifnull(b.Col19,0)) Col19
            									,sum(ifnull(b.Col20,0)) Col20
            									,sum(ifnull(b.Col21,0)) Col21
            									,sum(ifnull(b.Col22,0)) Col22
            									,sum(ifnull(b.Col23,0)) Col23
                              ,sum(ifnull(b.Col24,0)) Col24
                              ,sum(ifnull(b.Col25,0)) Col25
                              ,sum(ifnull(b.Col26,0)) Col26
                              ,sum(ifnull(b.Col27,0)) Col27
                              ,sum(ifnull(b.Col28,0)) Col28
                              ,sum(ifnull(b.Col29,0)) Col29
                              ,sum(ifnull(b.Col30,0)) Col30
                              ,sum(ifnull(b.Col31,0)) Col31
                              ,sum(ifnull(b.Col32,0)) Col32
                              ,sum(ifnull(b.Col33,0)) Col33
                              ,sum(ifnull(b.Col34,0)) Col34
                              ,sum(ifnull(b.Col35,0)) Col35
                              ,sum(ifnull(b.Col36,0)) Col36
                          FROM (select c.* from 2019prestaciones c where c.codigo_prestacion in("01010037","01010038")) a
                          left join 2019rems b on (a.id_prestacion=b.prestacion_id_prestacion)
                          AND (b.Mes in ('.$mes.')) AND (b.establecimiento_id_establecimiento in ('.$estab.'))
                          group by  a.codigo_prestacion,a.descripcion,a.id_prestacion
                          order by a.id_prestacion';
                $registro = DB::connection('mysql_rem')->select($query);

                $i=0;

                $totalCol01b=0;
    						$totalCol02b=0;
    						$totalCol03b=0;
    						$totalCol04b=0;
    						$totalCol05b=0;
    						$totalCol06b=0;
    						$totalCol07b=0;
    						$totalCol08b=0;
    						$totalCol09b=0;
    						$totalCol10b=0;
    						$totalCol11b=0;
    						$totalCol12b=0;
    						$totalCol13b=0;
    						$totalCol14b=0;
    						$totalCol15b=0;
    						$totalCol16b=0;
    						$totalCol17b=0;
    						$totalCol18b=0;
    						$totalCol19b=0;
    						$totalCol20b=0;
    						$totalCol21b=0;
    						$totalCol22b=0;
    						$totalCol23b=0;
    						$totalCol24b=0;
    						$totalCol25b=0;
    						$totalCol26b=0;
    						$totalCol27b=0;
    						$totalCol28b=0;
    						$totalCol29b=0;
    						$totalCol30b=0;
    						$totalCol31b=0;
    						$totalCol32b=0;
    						$totalCol33b=0;
    						$totalCol34b=0;
    						$totalCol35b=0;
    						$totalCol36b=0;

                foreach($registro as $row ){
                    $totalCol01b=$totalCol01b+$row->Col01;
                    $totalCol02b=$totalCol02b+$row->Col02;
                    $totalCol03b=$totalCol03b+$row->Col03;
                    $totalCol04b=$totalCol04b+$row->Col04;
                    $totalCol05b=$totalCol05b+$row->Col05;
                    $totalCol06b=$totalCol06b+$row->Col06;
                    $totalCol07b=$totalCol07b+$row->Col07;
                    $totalCol08b=$totalCol08b+$row->Col08;
                    $totalCol09b=$totalCol09b+$row->Col09;
                    $totalCol10b=$totalCol10b+$row->Col10;
                    $totalCol11b=$totalCol11b+$row->Col11;
                    $totalCol12b=$totalCol12b+$row->Col12;
                    $totalCol13b=$totalCol13b+$row->Col13;
                    $totalCol14b=$totalCol14b+$row->Col14;
                    $totalCol15b=$totalCol15b+$row->Col15;
                    $totalCol16b=$totalCol16b+$row->Col16;
                    $totalCol17b=$totalCol17b+$row->Col17;
                    $totalCol18b=$totalCol18b+$row->Col18;
                    $totalCol19b=$totalCol19b+$row->Col19;
                    $totalCol20b=$totalCol20b+$row->Col20;
                    $totalCol21b=$totalCol21b+$row->Col21;
                    $totalCol22b=$totalCol22b+$row->Col22;
                    $totalCol23b=$totalCol23b+$row->Col23;
                    $totalCol24b=$totalCol24b+$row->Col24;
                    $totalCol25b=$totalCol25b+$row->Col25;
                    $totalCol26b=$totalCol26b+$row->Col26;
                    $totalCol27b=$totalCol27b+$row->Col27;
                    $totalCol28b=$totalCol28b+$row->Col28;
                    $totalCol29b=$totalCol29b+$row->Col29;
                    $totalCol30b=$totalCol30b+$row->Col30;
                    $totalCol31b=$totalCol31b+$row->Col31;
                    $totalCol32b=$totalCol32b+$row->Col32;
                    $totalCol33b=$totalCol33b+$row->Col33;
                    $totalCol34b=$totalCol34b+$row->Col34;
                    $totalCol35b=$totalCol35b+$row->Col35;
                    $totalCol36b=$totalCol36b+$row->Col36;

                    $nombre_descripcion = $row->codigo_prestacion;
                    if ($nombre_descripcion == "01010037"){
                        $nombre_descripcion = "Visita a domicilio por otro integrante del equipo de salud";
      							}
                    if ($nombre_descripcion == "01010038"){
                        $nombre_descripcion = "Visita domiciaria por otro profesional y técnicos paramédico";
      							}
                    ?>
                <tr>
                    <td align='left' nowrap><?php echo $nombre_descripcion; ?></td>
                    <td align='right'><?php echo number_format($row->Col01,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col02,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col03,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col04,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col05,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col06,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col07,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col08,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col09,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col10,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col11,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col12,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col13,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col14,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col15,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col16,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col17,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col18,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col19,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col20,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col21,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col22,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col23,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col24,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col25,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col26,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col27,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col28,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col29,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col30,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col31,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col32,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col33,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col34,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col35,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col36,0,",",".")?></td>
                    <?php
                    $i++;
                }
                ?>
                </tr>
                <tr>
                    <td align='center'><strong>TOTAL ARANCEL MLE Y NO ARANCELADO</strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol01b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol02b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol03b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol04b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol05b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol06b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol07b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol08b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol09b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol10b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol11b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol12b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol13b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol14b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol15b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol16b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol17b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol18b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol19b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol20b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol21b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol22b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol23b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol24b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol25b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol26b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol27b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol28b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol29b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol30b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol31b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol32b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol33b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol34b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol35b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol36b,0,",",".") ?></strong></td>
                </tr>
                <tr>
                    <td align='center'><strong>TOTAL PRODUCCION</strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol01a + $totalCol01b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol02a + $totalCol02b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol03a + $totalCol03b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol04a + $totalCol04b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol05a + $totalCol05b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol06a + $totalCol06b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol07a + $totalCol07b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol08a + $totalCol08b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol09a + $totalCol09b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol10a + $totalCol10b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol11a + $totalCol11b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol12a + $totalCol12b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol13a + $totalCol13b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol14a + $totalCol14b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol15a + $totalCol15b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol16a + $totalCol16b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol17a + $totalCol17b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol18a + $totalCol18b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol19a + $totalCol19b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol20a + $totalCol20b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol21a + $totalCol21b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol22a + $totalCol22b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol23a + $totalCol23b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol24a + $totalCol24b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol25a + $totalCol25b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol26a + $totalCol26b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol27a + $totalCol27b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol28a + $totalCol28b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol29a + $totalCol29b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol30a + $totalCol30b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol31a + $totalCol31b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol32a + $totalCol32b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol33a + $totalCol33b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol34a + $totalCol34b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol35a + $totalCol35b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol36a + $totalCol36b,0,",",".") ?></strong></td>
                </tr>
                <tr>
                    <td><strong>VACUNACION Y DESPARASITACION</strong></td>
                    <td colspan="36"></td>
                </tr>
                <?php
                $query = 'SELECT a.codigo_prestacion,a.descripcion
                              ,sum(ifnull(b.Col01,0)) Col01
                              ,sum(ifnull(b.Col02,0)) Col02
                              ,sum(ifnull(b.Col03,0)) Col03
                              ,sum(ifnull(b.Col04,0)) Col04
									            ,sum(ifnull(b.Col05,0)) Col05
                              ,sum(ifnull(b.Col06,0)) Col06
                              ,sum(ifnull(b.Col07,0)) Col07
                              ,sum(ifnull(b.Col08,0)) Col08
                              ,sum(ifnull(b.Col09,0)) Col09
                              ,sum(ifnull(b.Col10,0)) Col10
                              ,sum(ifnull(b.Col11,0)) Col11
                              ,sum(ifnull(b.Col12,0)) Col12
                              ,sum(ifnull(b.Col13,0)) Col13
            									,sum(ifnull(b.Col14,0)) Col14
            									,sum(ifnull(b.Col15,0)) Col15
            									,sum(ifnull(b.Col16,0)) Col16
            									,sum(ifnull(b.Col17,0)) Col17
            									,sum(ifnull(b.Col18,0)) Col18
            									,sum(ifnull(b.Col19,0)) Col19
            									,sum(ifnull(b.Col20,0)) Col20
            									,sum(ifnull(b.Col21,0)) Col21
            									,sum(ifnull(b.Col22,0)) Col22
            									,sum(ifnull(b.Col23,0)) Col23
                              ,sum(ifnull(b.Col24,0)) Col24
                              ,sum(ifnull(b.Col25,0)) Col25
                              ,sum(ifnull(b.Col26,0)) Col26
                              ,sum(ifnull(b.Col27,0)) Col27
                              ,sum(ifnull(b.Col28,0)) Col28
                              ,sum(ifnull(b.Col29,0)) Col29
                              ,sum(ifnull(b.Col30,0)) Col30
                              ,sum(ifnull(b.Col31,0)) Col31
                              ,sum(ifnull(b.Col32,0)) Col32
                              ,sum(ifnull(b.Col33,0)) Col33
                              ,sum(ifnull(b.Col34,0)) Col34
                              ,sum(ifnull(b.Col35,0)) Col35
                              ,sum(ifnull(b.Col36,0)) Col36
                          FROM (select c.* from 2019prestaciones c where c.codigo_prestacion in("01010039","01010040","01010041")) a
                          left join 2019rems b on (a.id_prestacion=b.prestacion_id_prestacion)
                          AND (b.Mes in ('.$mes.')) AND (b.establecimiento_id_establecimiento in ('.$estab.'))
                          group by  a.codigo_prestacion,a.descripcion,a.id_prestacion
                          order by a.id_prestacion';
                $registro = DB::connection('mysql_rem')->select($query);

                $i=0;

                $totalCol01a=0;
    						$totalCol02a=0;
    						$totalCol03a=0;
    						$totalCol04a=0;
    						$totalCol05a=0;
    						$totalCol06a=0;
    						$totalCol07a=0;
    						$totalCol08a=0;
    						$totalCol09a=0;
    						$totalCol10a=0;
    						$totalCol11a=0;
    						$totalCol12a=0;
    						$totalCol13a=0;
    						$totalCol14a=0;
    						$totalCol15a=0;
    						$totalCol16a=0;
    						$totalCol17a=0;
    						$totalCol18a=0;
    						$totalCol19a=0;
    						$totalCol20a=0;
    						$totalCol21a=0;
    						$totalCol22a=0;
    						$totalCol23a=0;
    						$totalCol24a=0;
    						$totalCol25a=0;
    						$totalCol26a=0;
    						$totalCol27a=0;
    						$totalCol28a=0;
    						$totalCol29a=0;
    						$totalCol30a=0;
    						$totalCol31a=0;
    						$totalCol32a=0;
    						$totalCol33a=0;
    						$totalCol34a=0;
    						$totalCol35a=0;
    						$totalCol36a=0;

                foreach($registro as $row ){
                    $totalCol01a=$totalCol01a+$row->Col01;
                    $totalCol02a=$totalCol02a+$row->Col02;
                    $totalCol03a=$totalCol03a+$row->Col03;
                    $totalCol04a=$totalCol04a+$row->Col04;
                    $totalCol05a=$totalCol05a+$row->Col05;
                    $totalCol06a=$totalCol06a+$row->Col06;
                    $totalCol07a=$totalCol07a+$row->Col07;
                    $totalCol08a=$totalCol08a+$row->Col08;
                    $totalCol09a=$totalCol09a+$row->Col09;
                    $totalCol10a=$totalCol10a+$row->Col10;
                    $totalCol11a=$totalCol11a+$row->Col11;
                    $totalCol12a=$totalCol12a+$row->Col12;
                    $totalCol13a=$totalCol13a+$row->Col13;
                    $totalCol14a=$totalCol14a+$row->Col14;
                    $totalCol15a=$totalCol15a+$row->Col15;
                    $totalCol16a=$totalCol16a+$row->Col16;
                    $totalCol17a=$totalCol17a+$row->Col17;
                    $totalCol18a=$totalCol18a+$row->Col18;
                    $totalCol19a=$totalCol19a+$row->Col19;
                    $totalCol20a=$totalCol20a+$row->Col20;
                    $totalCol21a=$totalCol21a+$row->Col21;
                    $totalCol22a=$totalCol22a+$row->Col22;
                    $totalCol23a=$totalCol23a+$row->Col23;
                    $totalCol24a=$totalCol24a+$row->Col24;
                    $totalCol25a=$totalCol25a+$row->Col25;
                    $totalCol26a=$totalCol26a+$row->Col26;
                    $totalCol27a=$totalCol27a+$row->Col27;
                    $totalCol28a=$totalCol28a+$row->Col28;
                    $totalCol29a=$totalCol29a+$row->Col29;
                    $totalCol30a=$totalCol30a+$row->Col30;
                    $totalCol31a=$totalCol31a+$row->Col31;
                    $totalCol32a=$totalCol32a+$row->Col32;
                    $totalCol33a=$totalCol33a+$row->Col33;
                    $totalCol34a=$totalCol34a+$row->Col34;
                    $totalCol35a=$totalCol35a+$row->Col35;
                    $totalCol36a=$totalCol36a+$row->Col36;

                    $nombre_descripcion = $row->codigo_prestacion;
                    if ($nombre_descripcion == "01010039"){
                        $nombre_descripcion = "Vacunaciones (sólo considera administración)";
      							}
                    if ($nombre_descripcion == "01010040"){
                        $nombre_descripcion = "Desparasitación sarna (cada persona)";
      							}
                    if ($nombre_descripcion == "01010041"){
                        $nombre_descripcion = "Desparasitación pediculosis (cada persona)";
      							}
                    ?>
                <tr>
                    <td align='left' nowrap><?php echo $nombre_descripcion; ?></td>
                    <td align='right'><?php echo number_format($row->Col01,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col02,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col03,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col04,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col05,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col06,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col07,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col08,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col09,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col10,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col11,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col12,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col13,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col14,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col15,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col16,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col17,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col18,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col19,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col20,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col21,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col22,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col23,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col24,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col25,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col26,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col27,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col28,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col29,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col30,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col31,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col32,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col33,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col34,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col35,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col36,0,",",".")?></td>
                    <?php
                    $i++;
                }
                ?>
                </tr>
                <tr>
                    <td align='center'><strong>TOTAL</strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol01a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol02a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol03a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol04a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol05a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol06a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol07a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol08a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol09a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol10a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol11a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol12a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol13a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol14a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol15a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol16a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol17a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol18a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol19a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol20a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol21a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol22a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol23a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol24a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol25a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol26a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol27a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol28a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol29a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol30a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol31a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol32a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol33a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol34a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol35a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol36a,0,",",".") ?></strong></td>
                </tr>
                <tr>
                    <td><strong>MISCELANEOS</strong></td>
                    <td colspan="36"></td>
                </tr>
                <?php
                $query = 'SELECT a.codigo_prestacion,a.descripcion
                              ,sum(ifnull(b.Col01,0)) Col01
                              ,sum(ifnull(b.Col02,0)) Col02
                              ,sum(ifnull(b.Col03,0)) Col03
                              ,sum(ifnull(b.Col04,0)) Col04
									            ,sum(ifnull(b.Col05,0)) Col05
                              ,sum(ifnull(b.Col06,0)) Col06
                              ,sum(ifnull(b.Col07,0)) Col07
                              ,sum(ifnull(b.Col08,0)) Col08
                              ,sum(ifnull(b.Col09,0)) Col09
                              ,sum(ifnull(b.Col10,0)) Col10
                              ,sum(ifnull(b.Col11,0)) Col11
                              ,sum(ifnull(b.Col12,0)) Col12
                              ,sum(ifnull(b.Col13,0)) Col13
            									,sum(ifnull(b.Col14,0)) Col14
            									,sum(ifnull(b.Col15,0)) Col15
            									,sum(ifnull(b.Col16,0)) Col16
            									,sum(ifnull(b.Col17,0)) Col17
            									,sum(ifnull(b.Col18,0)) Col18
            									,sum(ifnull(b.Col19,0)) Col19
            									,sum(ifnull(b.Col20,0)) Col20
            									,sum(ifnull(b.Col21,0)) Col21
            									,sum(ifnull(b.Col22,0)) Col22
            									,sum(ifnull(b.Col23,0)) Col23
                              ,sum(ifnull(b.Col24,0)) Col24
                              ,sum(ifnull(b.Col25,0)) Col25
                              ,sum(ifnull(b.Col26,0)) Col26
                              ,sum(ifnull(b.Col27,0)) Col27
                              ,sum(ifnull(b.Col28,0)) Col28
                              ,sum(ifnull(b.Col29,0)) Col29
                              ,sum(ifnull(b.Col30,0)) Col30
                              ,sum(ifnull(b.Col31,0)) Col31
                              ,sum(ifnull(b.Col32,0)) Col32
                              ,sum(ifnull(b.Col33,0)) Col33
                              ,sum(ifnull(b.Col34,0)) Col34
                              ,sum(ifnull(b.Col35,0)) Col35
                              ,sum(ifnull(b.Col36,0)) Col36
                          FROM (select c.* from 2019prestaciones c where c.codigo_prestacion in("01010042","01010043","01010044","01010045","01010046")) a
                          left join 2019rems b on (a.id_prestacion=b.prestacion_id_prestacion)
                          AND (b.Mes in ('.$mes.')) AND (b.establecimiento_id_establecimiento in ('.$estab.'))
                          group by  a.codigo_prestacion,a.descripcion,a.id_prestacion
                          order by a.id_prestacion';
                $registro = DB::connection('mysql_rem')->select($query);

                $i=0;

                $totalCol01a=0;
    						$totalCol02a=0;
    						$totalCol03a=0;
    						$totalCol04a=0;
    						$totalCol05a=0;
    						$totalCol06a=0;
    						$totalCol07a=0;
    						$totalCol08a=0;
    						$totalCol09a=0;
    						$totalCol10a=0;
    						$totalCol11a=0;
    						$totalCol12a=0;
    						$totalCol13a=0;
    						$totalCol14a=0;
    						$totalCol15a=0;
    						$totalCol16a=0;
    						$totalCol17a=0;
    						$totalCol18a=0;
    						$totalCol19a=0;
    						$totalCol20a=0;
    						$totalCol21a=0;
    						$totalCol22a=0;
    						$totalCol23a=0;
    						$totalCol24a=0;
    						$totalCol25a=0;
    						$totalCol26a=0;
    						$totalCol27a=0;
    						$totalCol28a=0;
    						$totalCol29a=0;
    						$totalCol30a=0;
    						$totalCol31a=0;
    						$totalCol32a=0;
    						$totalCol33a=0;
    						$totalCol34a=0;
    						$totalCol35a=0;
    						$totalCol36a=0;

                foreach($registro as $row ){
                    $totalCol01a=$totalCol01a+$row->Col01;
                    $totalCol02a=$totalCol02a+$row->Col02;
                    $totalCol03a=$totalCol03a+$row->Col03;
                    $totalCol04a=$totalCol04a+$row->Col04;
                    $totalCol05a=$totalCol05a+$row->Col05;
                    $totalCol06a=$totalCol06a+$row->Col06;
                    $totalCol07a=$totalCol07a+$row->Col07;
                    $totalCol08a=$totalCol08a+$row->Col08;
                    $totalCol09a=$totalCol09a+$row->Col09;
                    $totalCol10a=$totalCol10a+$row->Col10;
                    $totalCol11a=$totalCol11a+$row->Col11;
                    $totalCol12a=$totalCol12a+$row->Col12;
                    $totalCol13a=$totalCol13a+$row->Col13;
                    $totalCol14a=$totalCol14a+$row->Col14;
                    $totalCol15a=$totalCol15a+$row->Col15;
                    $totalCol16a=$totalCol16a+$row->Col16;
                    $totalCol17a=$totalCol17a+$row->Col17;
                    $totalCol18a=$totalCol18a+$row->Col18;
                    $totalCol19a=$totalCol19a+$row->Col19;
                    $totalCol20a=$totalCol20a+$row->Col20;
                    $totalCol21a=$totalCol21a+$row->Col21;
                    $totalCol22a=$totalCol22a+$row->Col22;
                    $totalCol23a=$totalCol23a+$row->Col23;
                    $totalCol24a=$totalCol24a+$row->Col24;
                    $totalCol25a=$totalCol25a+$row->Col25;
                    $totalCol26a=$totalCol26a+$row->Col26;
                    $totalCol27a=$totalCol27a+$row->Col27;
                    $totalCol28a=$totalCol28a+$row->Col28;
                    $totalCol29a=$totalCol29a+$row->Col29;
                    $totalCol30a=$totalCol30a+$row->Col30;
                    $totalCol31a=$totalCol31a+$row->Col31;
                    $totalCol32a=$totalCol32a+$row->Col32;
                    $totalCol33a=$totalCol33a+$row->Col33;
                    $totalCol34a=$totalCol34a+$row->Col34;
                    $totalCol35a=$totalCol35a+$row->Col35;
                    $totalCol36a=$totalCol36a+$row->Col36;

                    $nombre_descripcion = $row->codigo_prestacion;
                    if ($nombre_descripcion == "01010042"){
                        $nombre_descripcion = "Curación simple ambulatoria";
      							}
                    if ($nombre_descripcion == "01010043"){
                        $nombre_descripcion = "Autocontrol pacientes Diabetico insulino dependiente (D.I.D. mensual)";
      							}
                    if ($nombre_descripcion == "01010044"){
                        $nombre_descripcion = "Oxigenoterapia domiciliaria (pacientes oxígeno dependientes)";
      							}
                    if ($nombre_descripcion == "01010045"){
                        $nombre_descripcion = "Despacho de recetas a crónicos";
      							}
                    if ($nombre_descripcion == "01010046"){
                        $nombre_descripcion = "Abreu";
      							}
                    ?>
                <tr>
                    <td align='left' nowrap><?php echo $nombre_descripcion; ?></td>
                    <td align='right'><?php echo number_format($row->Col01,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col02,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col03,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col04,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col05,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col06,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col07,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col08,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col09,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col10,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col11,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col12,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col13,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col14,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col15,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col16,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col17,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col18,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col19,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col20,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col21,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col22,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col23,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col24,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col25,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col26,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col27,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col28,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col29,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col30,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col31,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col32,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col33,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col34,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col35,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col36,0,",",".")?></td>
                    <?php
                    $i++;
                }
                ?>
                </tr>
                <tr>
                    <td align='center'><strong>TOTAL ARANCEL MAI</strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol01a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol02a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol03a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol04a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol05a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol06a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol07a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol08a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol09a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol10a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol11a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol12a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol13a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol14a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol15a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol16a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol17a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol18a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol19a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol20a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol21a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol22a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol23a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol24a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol25a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol26a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol27a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol28a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol29a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol30a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol31a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol32a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol33a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol34a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol35a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol36a,0,",",".") ?></strong></td>
                </tr>
                <?php
                $query = 'SELECT a.codigo_prestacion,a.descripcion
                              ,sum(ifnull(b.Col01,0)) Col01
                              ,sum(ifnull(b.Col02,0)) Col02
                              ,sum(ifnull(b.Col03,0)) Col03
                              ,sum(ifnull(b.Col04,0)) Col04
									            ,sum(ifnull(b.Col05,0)) Col05
                              ,sum(ifnull(b.Col06,0)) Col06
                              ,sum(ifnull(b.Col07,0)) Col07
                              ,sum(ifnull(b.Col08,0)) Col08
                              ,sum(ifnull(b.Col09,0)) Col09
                              ,sum(ifnull(b.Col10,0)) Col10
                              ,sum(ifnull(b.Col11,0)) Col11
                              ,sum(ifnull(b.Col12,0)) Col12
                              ,sum(ifnull(b.Col13,0)) Col13
            									,sum(ifnull(b.Col14,0)) Col14
            									,sum(ifnull(b.Col15,0)) Col15
            									,sum(ifnull(b.Col16,0)) Col16
            									,sum(ifnull(b.Col17,0)) Col17
            									,sum(ifnull(b.Col18,0)) Col18
            									,sum(ifnull(b.Col19,0)) Col19
            									,sum(ifnull(b.Col20,0)) Col20
            									,sum(ifnull(b.Col21,0)) Col21
            									,sum(ifnull(b.Col22,0)) Col22
            									,sum(ifnull(b.Col23,0)) Col23
                              ,sum(ifnull(b.Col24,0)) Col24
                              ,sum(ifnull(b.Col25,0)) Col25
                              ,sum(ifnull(b.Col26,0)) Col26
                              ,sum(ifnull(b.Col27,0)) Col27
                              ,sum(ifnull(b.Col28,0)) Col28
                              ,sum(ifnull(b.Col29,0)) Col29
                              ,sum(ifnull(b.Col30,0)) Col30
                              ,sum(ifnull(b.Col31,0)) Col31
                              ,sum(ifnull(b.Col32,0)) Col32
                              ,sum(ifnull(b.Col33,0)) Col33
                              ,sum(ifnull(b.Col34,0)) Col34
                              ,sum(ifnull(b.Col35,0)) Col35
                              ,sum(ifnull(b.Col36,0)) Col36
                          FROM (select c.* from 2019prestaciones c where c.codigo_prestacion in("01010047")) a
                          left join 2019rems b on (a.id_prestacion=b.prestacion_id_prestacion)
                          AND (b.Mes in ('.$mes.')) AND (b.establecimiento_id_establecimiento in ('.$estab.'))
                          group by  a.codigo_prestacion,a.descripcion,a.id_prestacion
                          order by a.id_prestacion';
                $registro = DB::connection('mysql_rem')->select($query);

                $i=0;

                $totalCol01b=0;
    						$totalCol02b=0;
    						$totalCol03b=0;
    						$totalCol04b=0;
    						$totalCol05b=0;
    						$totalCol06b=0;
    						$totalCol07b=0;
    						$totalCol08b=0;
    						$totalCol09b=0;
    						$totalCol10b=0;
    						$totalCol11b=0;
    						$totalCol12b=0;
    						$totalCol13b=0;
    						$totalCol14b=0;
    						$totalCol15b=0;
    						$totalCol16b=0;
    						$totalCol17b=0;
    						$totalCol18b=0;
    						$totalCol19b=0;
    						$totalCol20b=0;
    						$totalCol21b=0;
    						$totalCol22b=0;
    						$totalCol23b=0;
    						$totalCol24b=0;
    						$totalCol25b=0;
    						$totalCol26b=0;
    						$totalCol27b=0;
    						$totalCol28b=0;
    						$totalCol29b=0;
    						$totalCol30b=0;
    						$totalCol31b=0;
    						$totalCol32b=0;
    						$totalCol33b=0;
    						$totalCol34b=0;
    						$totalCol35b=0;
    						$totalCol36b=0;

                foreach($registro as $row ){
                    $totalCol01b=$totalCol01b+$row->Col01;
                    $totalCol02b=$totalCol02b+$row->Col02;
                    $totalCol03b=$totalCol03b+$row->Col03;
                    $totalCol04b=$totalCol04b+$row->Col04;
                    $totalCol05b=$totalCol05b+$row->Col05;
                    $totalCol06b=$totalCol06b+$row->Col06;
                    $totalCol07b=$totalCol07b+$row->Col07;
                    $totalCol08b=$totalCol08b+$row->Col08;
                    $totalCol09b=$totalCol09b+$row->Col09;
                    $totalCol10b=$totalCol10b+$row->Col10;
                    $totalCol11b=$totalCol11b+$row->Col11;
                    $totalCol12b=$totalCol12b+$row->Col12;
                    $totalCol13b=$totalCol13b+$row->Col13;
                    $totalCol14b=$totalCol14b+$row->Col14;
                    $totalCol15b=$totalCol15b+$row->Col15;
                    $totalCol16b=$totalCol16b+$row->Col16;
                    $totalCol17b=$totalCol17b+$row->Col17;
                    $totalCol18b=$totalCol18b+$row->Col18;
                    $totalCol19b=$totalCol19b+$row->Col19;
                    $totalCol20b=$totalCol20b+$row->Col20;
                    $totalCol21b=$totalCol21b+$row->Col21;
                    $totalCol22b=$totalCol22b+$row->Col22;
                    $totalCol23b=$totalCol23b+$row->Col23;
                    $totalCol24b=$totalCol24b+$row->Col24;
                    $totalCol25b=$totalCol25b+$row->Col25;
                    $totalCol26b=$totalCol26b+$row->Col26;
                    $totalCol27b=$totalCol27b+$row->Col27;
                    $totalCol28b=$totalCol28b+$row->Col28;
                    $totalCol29b=$totalCol29b+$row->Col29;
                    $totalCol30b=$totalCol30b+$row->Col30;
                    $totalCol31b=$totalCol31b+$row->Col31;
                    $totalCol32b=$totalCol32b+$row->Col32;
                    $totalCol33b=$totalCol33b+$row->Col33;
                    $totalCol34b=$totalCol34b+$row->Col34;
                    $totalCol35b=$totalCol35b+$row->Col35;
                    $totalCol36b=$totalCol36b+$row->Col36;

                    $nombre_descripcion = $row->codigo_prestacion;
                    if ($nombre_descripcion == "01010047"){
                        $nombre_descripcion = "Procedimientos de podología";
      							}
                    ?>
                <tr>
                    <td align='left' nowrap><?php echo $nombre_descripcion; ?></td>
                    <td align='right'><?php echo number_format($row->Col01,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col02,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col03,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col04,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col05,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col06,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col07,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col08,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col09,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col10,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col11,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col12,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col13,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col14,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col15,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col16,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col17,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col18,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col19,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col20,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col21,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col22,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col23,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col24,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col25,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col26,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col27,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col28,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col29,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col30,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col31,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col32,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col33,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col34,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col35,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col36,0,",",".")?></td>
                    <?php
                    $i++;
                }
                ?>
                </tr>
                <tr>
                    <td align='center'><strong>TOTAL ARANCEL MLE Y NO ARANCELADO</strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol01b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol02b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol03b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol04b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol05b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol06b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol07b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol08b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol09b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol10b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol11b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol12b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol13b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol14b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol15b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol16b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol17b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol18b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol19b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol20b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol21b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol22b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol23b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol24b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol25b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol26b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol27b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol28b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol29b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol30b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol31b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol32b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol33b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol34b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol35b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol36b,0,",",".") ?></strong></td>
                </tr>
                <tr>
                    <td align='center'><strong>TOTAL PRODUCCION</strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol01a + $totalCol01b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol02a + $totalCol02b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol03a + $totalCol03b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol04a + $totalCol04b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol05a + $totalCol05b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol06a + $totalCol06b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol07a + $totalCol07b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol08a + $totalCol08b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol09a + $totalCol09b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol10a + $totalCol10b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol11a + $totalCol11b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol12a + $totalCol12b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol13a + $totalCol13b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol14a + $totalCol14b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol15a + $totalCol15b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol16a + $totalCol16b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol17a + $totalCol17b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol18a + $totalCol18b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol19a + $totalCol19b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol20a + $totalCol20b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol21a + $totalCol21b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol22a + $totalCol22b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol23a + $totalCol23b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol24a + $totalCol24b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol25a + $totalCol25b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol26a + $totalCol26b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol27a + $totalCol27b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol28a + $totalCol28b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol29a + $totalCol29b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol30a + $totalCol30b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol31a + $totalCol31b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol32a + $totalCol32b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol33a + $totalCol33b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol34a + $totalCol34b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol35a + $totalCol35b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol36a + $totalCol36b,0,",",".") ?></strong></td>
                </tr>
                <tr>
                    <td><strong>OTRAS MISCELANEOS</strong></td>
                    <td colspan="36"></td>
                </tr>
                <?php
                $query = 'SELECT a.codigo_prestacion,a.descripcion
                              ,sum(ifnull(b.Col01,0)) Col01
                              ,sum(ifnull(b.Col02,0)) Col02
                              ,sum(ifnull(b.Col03,0)) Col03
                              ,sum(ifnull(b.Col04,0)) Col04
									            ,sum(ifnull(b.Col05,0)) Col05
                              ,sum(ifnull(b.Col06,0)) Col06
                              ,sum(ifnull(b.Col07,0)) Col07
                              ,sum(ifnull(b.Col08,0)) Col08
                              ,sum(ifnull(b.Col09,0)) Col09
                              ,sum(ifnull(b.Col10,0)) Col10
                              ,sum(ifnull(b.Col11,0)) Col11
                              ,sum(ifnull(b.Col12,0)) Col12
                              ,sum(ifnull(b.Col13,0)) Col13
            									,sum(ifnull(b.Col14,0)) Col14
            									,sum(ifnull(b.Col15,0)) Col15
            									,sum(ifnull(b.Col16,0)) Col16
            									,sum(ifnull(b.Col17,0)) Col17
            									,sum(ifnull(b.Col18,0)) Col18
            									,sum(ifnull(b.Col19,0)) Col19
            									,sum(ifnull(b.Col20,0)) Col20
            									,sum(ifnull(b.Col21,0)) Col21
            									,sum(ifnull(b.Col22,0)) Col22
            									,sum(ifnull(b.Col23,0)) Col23
                              ,sum(ifnull(b.Col24,0)) Col24
                              ,sum(ifnull(b.Col25,0)) Col25
                              ,sum(ifnull(b.Col26,0)) Col26
                              ,sum(ifnull(b.Col27,0)) Col27
                              ,sum(ifnull(b.Col28,0)) Col28
                              ,sum(ifnull(b.Col29,0)) Col29
                              ,sum(ifnull(b.Col30,0)) Col30
                              ,sum(ifnull(b.Col31,0)) Col31
                              ,sum(ifnull(b.Col32,0)) Col32
                              ,sum(ifnull(b.Col33,0)) Col33
                              ,sum(ifnull(b.Col34,0)) Col34
                              ,sum(ifnull(b.Col35,0)) Col35
                              ,sum(ifnull(b.Col36,0)) Col36
                          FROM (select c.* from 2019prestaciones c where c.codigo_prestacion in("01010048","01010049","01010050","01010051","01010052","01010053","01010054","01010055",
                                                                                                "01010056","01010057","01010058","01010059","01010060","01010061","01010062","01010063",
                                                                                                "01010064","01010065","01010066","01010067","01010068","01010069","01010070","01010071")) a
                          left join 2019rems b on (a.id_prestacion=b.prestacion_id_prestacion)
                          AND (b.Mes in ('.$mes.')) AND (b.establecimiento_id_establecimiento in ('.$estab.'))
                          group by  a.codigo_prestacion,a.descripcion,a.id_prestacion
                          order by a.id_prestacion';
                $registro = DB::connection('mysql_rem')->select($query);

                $i=0;

                $totalCol01a=0;
    						$totalCol02a=0;
    						$totalCol03a=0;
    						$totalCol04a=0;
    						$totalCol05a=0;
    						$totalCol06a=0;
    						$totalCol07a=0;
    						$totalCol08a=0;
    						$totalCol09a=0;
    						$totalCol10a=0;
    						$totalCol11a=0;
    						$totalCol12a=0;
    						$totalCol13a=0;
    						$totalCol14a=0;
    						$totalCol15a=0;
    						$totalCol16a=0;
    						$totalCol17a=0;
    						$totalCol18a=0;
    						$totalCol19a=0;
    						$totalCol20a=0;
    						$totalCol21a=0;
    						$totalCol22a=0;
    						$totalCol23a=0;
    						$totalCol24a=0;
    						$totalCol25a=0;
    						$totalCol26a=0;
    						$totalCol27a=0;
    						$totalCol28a=0;
    						$totalCol29a=0;
    						$totalCol30a=0;
    						$totalCol31a=0;
    						$totalCol32a=0;
    						$totalCol33a=0;
    						$totalCol34a=0;
    						$totalCol35a=0;
    						$totalCol36a=0;

                foreach($registro as $row ){
                    $totalCol01a=$totalCol01a+$row->Col01;
                    $totalCol02a=$totalCol02a+$row->Col02;
                    $totalCol03a=$totalCol03a+$row->Col03;
                    $totalCol04a=$totalCol04a+$row->Col04;
                    $totalCol05a=$totalCol05a+$row->Col05;
                    $totalCol06a=$totalCol06a+$row->Col06;
                    $totalCol07a=$totalCol07a+$row->Col07;
                    $totalCol08a=$totalCol08a+$row->Col08;
                    $totalCol09a=$totalCol09a+$row->Col09;
                    $totalCol10a=$totalCol10a+$row->Col10;
                    $totalCol11a=$totalCol11a+$row->Col11;
                    $totalCol12a=$totalCol12a+$row->Col12;
                    $totalCol13a=$totalCol13a+$row->Col13;
                    $totalCol14a=$totalCol14a+$row->Col14;
                    $totalCol15a=$totalCol15a+$row->Col15;
                    $totalCol16a=$totalCol16a+$row->Col16;
                    $totalCol17a=$totalCol17a+$row->Col17;
                    $totalCol18a=$totalCol18a+$row->Col18;
                    $totalCol19a=$totalCol19a+$row->Col19;
                    $totalCol20a=$totalCol20a+$row->Col20;
                    $totalCol21a=$totalCol21a+$row->Col21;
                    $totalCol22a=$totalCol22a+$row->Col22;
                    $totalCol23a=$totalCol23a+$row->Col23;
                    $totalCol24a=$totalCol24a+$row->Col24;
                    $totalCol25a=$totalCol25a+$row->Col25;
                    $totalCol26a=$totalCol26a+$row->Col26;
                    $totalCol27a=$totalCol27a+$row->Col27;
                    $totalCol28a=$totalCol28a+$row->Col28;
                    $totalCol29a=$totalCol29a+$row->Col29;
                    $totalCol30a=$totalCol30a+$row->Col30;
                    $totalCol31a=$totalCol31a+$row->Col31;
                    $totalCol32a=$totalCol32a+$row->Col32;
                    $totalCol33a=$totalCol33a+$row->Col33;
                    $totalCol34a=$totalCol34a+$row->Col34;
                    $totalCol35a=$totalCol35a+$row->Col35;
                    $totalCol36a=$totalCol36a+$row->Col36;

                    $nombre_descripcion = $row->codigo_prestacion;
                    if ($nombre_descripcion == "01010048"){
                        $nombre_descripcion = "Hemoglucotest instantáneo";
      							}
                    if ($nombre_descripcion == "01010049"){
                        $nombre_descripcion = "Actividad Básica";
      							}
                    if ($nombre_descripcion == "01010050"){
                        $nombre_descripcion = "Actividad Terapeutica";
      							}
                    if ($nombre_descripcion == "01010051"){
                        $nombre_descripcion = "Evaluacion Actividad";
      							}
                    if ($nombre_descripcion == "01010052"){
                        $nombre_descripcion = "Evaluacion  prevocacional";
      							}
                    if ($nombre_descripcion == "01010053"){
                        $nombre_descripcion = "Evaluación cognitiva";
      							}
                    if ($nombre_descripcion == "01010054"){
                        $nombre_descripcion = "Estimulación cognitiva";
      							}
                    if ($nombre_descripcion == "01010055"){
                        $nombre_descripcion = "Curacion avanzada de herida";
      							}
                    if ($nombre_descripcion == "01010056"){
                        $nombre_descripcion = "Evaluación Motriz Funcional";
      							}
                    if ($nombre_descripcion == "01010057"){
                        $nombre_descripcion = "Evaluación cognitiva-perceptual";
      							}
                    if ($nombre_descripcion == "01010058"){
                        $nombre_descripcion = "Evaluación independencia en actividades de la vida diaria";
      							}
                    if ($nombre_descripcion == "01010059"){
                        $nombre_descripcion = "Evaluación barreras arquitectónicas";
      							}
                    if ($nombre_descripcion == "01010060"){
                        $nombre_descripcion = "Evaluación puesto de trabajo";
      							}
                    if ($nombre_descripcion == "01010061"){
                        $nombre_descripcion = "Evaluación del desarrollo Psicomotor";
      							}
                    if ($nombre_descripcion == "01010062"){
                        $nombre_descripcion = "Reentrenamiento de las funciones cognitiva-perceptual";
      							}
                    if ($nombre_descripcion == "01010063"){
                        $nombre_descripcion = "Reentrenamiento de las actividades de la vida diaria";
      							}
                    if ($nombre_descripcion == "01010064"){
                        $nombre_descripcion = "Reentrenamiento laboral";
      							}
                    if ($nombre_descripcion == "01010065"){
                        $nombre_descripcion = "Comité junta médica";
      							}
                    if ($nombre_descripcion == "01010066"){
                        $nombre_descripcion = "Consultorías médicas de especialidades";
      							}
                    if ($nombre_descripcion == "01010067"){
                        $nombre_descripcion = "Consultorías odontólogos";
      							}
                    if ($nombre_descripcion == "01010068"){
                        $nombre_descripcion = "Consejerias Individual por profesional de salud";
      							}
                    if ($nombre_descripcion == "01010069"){
                        $nombre_descripcion = "Consejerias Familiar por  profesionales de salud";
      							}
                    if ($nombre_descripcion == "01010070"){
                        $nombre_descripcion = "Instalación de clips en lesiones sangrantes";
      							}
                    if ($nombre_descripcion == "01010071"){
                        $nombre_descripcion = "Instalación vendaje compresivo (Coban)";
      							}
                    ?>
                <tr>
                    <td align='left' nowrap><?php echo $nombre_descripcion; ?></td>
                    <td align='right'><?php echo number_format($row->Col01,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col02,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col03,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col04,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col05,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col06,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col07,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col08,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col09,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col10,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col11,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col12,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col13,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col14,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col15,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col16,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col17,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col18,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col19,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col20,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col21,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col22,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col23,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col24,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col25,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col26,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col27,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col28,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col29,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col30,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col31,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col32,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col33,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col34,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col35,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col36,0,",",".")?></td>
                    <?php
                    $i++;
                }
                ?>
                </tr>
                <tr>
                    <td align='center'><strong>TOTAL</strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol01a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol02a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol03a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol04a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol05a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol06a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol07a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol08a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol09a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol10a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol11a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol12a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol13a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol14a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol15a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol16a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol17a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol18a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol19a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol20a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol21a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol22a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol23a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol24a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol25a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol26a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol27a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol28a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol29a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol30a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol31a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol32a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol33a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol34a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol35a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol36a,0,",",".") ?></strong></td>
                </tr>
                <tr>
                    <td><strong>Trasplantes</strong></td>
                    <td colspan="36"></td>
                </tr>
                <?php
                $query = 'SELECT a.codigo_prestacion,a.descripcion
                              ,sum(ifnull(b.Col01,0)) Col01
                              ,sum(ifnull(b.Col02,0)) Col02
                              ,sum(ifnull(b.Col03,0)) Col03
                              ,sum(ifnull(b.Col04,0)) Col04
									            ,sum(ifnull(b.Col05,0)) Col05
                              ,sum(ifnull(b.Col06,0)) Col06
                              ,sum(ifnull(b.Col07,0)) Col07
                              ,sum(ifnull(b.Col08,0)) Col08
                              ,sum(ifnull(b.Col09,0)) Col09
                              ,sum(ifnull(b.Col10,0)) Col10
                              ,sum(ifnull(b.Col11,0)) Col11
                              ,sum(ifnull(b.Col12,0)) Col12
                              ,sum(ifnull(b.Col13,0)) Col13
            									,sum(ifnull(b.Col14,0)) Col14
            									,sum(ifnull(b.Col15,0)) Col15
            									,sum(ifnull(b.Col16,0)) Col16
            									,sum(ifnull(b.Col17,0)) Col17
            									,sum(ifnull(b.Col18,0)) Col18
            									,sum(ifnull(b.Col19,0)) Col19
            									,sum(ifnull(b.Col20,0)) Col20
            									,sum(ifnull(b.Col21,0)) Col21
            									,sum(ifnull(b.Col22,0)) Col22
            									,sum(ifnull(b.Col23,0)) Col23
                              ,sum(ifnull(b.Col24,0)) Col24
                              ,sum(ifnull(b.Col25,0)) Col25
                              ,sum(ifnull(b.Col26,0)) Col26
                              ,sum(ifnull(b.Col27,0)) Col27
                              ,sum(ifnull(b.Col28,0)) Col28
                              ,sum(ifnull(b.Col29,0)) Col29
                              ,sum(ifnull(b.Col30,0)) Col30
                              ,sum(ifnull(b.Col31,0)) Col31
                              ,sum(ifnull(b.Col32,0)) Col32
                              ,sum(ifnull(b.Col33,0)) Col33
                              ,sum(ifnull(b.Col34,0)) Col34
                              ,sum(ifnull(b.Col35,0)) Col35
                              ,sum(ifnull(b.Col36,0)) Col36
                          FROM (select c.* from 2019prestaciones c where c.codigo_prestacion in("01010072","01010073","01010074","01010075","01010076","01010077","01010078","01010079",
                                                                                                "01010080","01010081","01010082")) a
                          left join 2019rems b on (a.id_prestacion=b.prestacion_id_prestacion)
                          AND (b.Mes in ('.$mes.')) AND (b.establecimiento_id_establecimiento in ('.$estab.'))
                          group by  a.codigo_prestacion,a.descripcion,a.id_prestacion
                          order by a.id_prestacion';
                $registro = DB::connection('mysql_rem')->select($query);

                $i=0;

                $totalCol01a=0;
    						$totalCol02a=0;
    						$totalCol03a=0;
    						$totalCol04a=0;
    						$totalCol05a=0;
    						$totalCol06a=0;
    						$totalCol07a=0;
    						$totalCol08a=0;
    						$totalCol09a=0;
    						$totalCol10a=0;
    						$totalCol11a=0;
    						$totalCol12a=0;
    						$totalCol13a=0;
    						$totalCol14a=0;
    						$totalCol15a=0;
    						$totalCol16a=0;
    						$totalCol17a=0;
    						$totalCol18a=0;
    						$totalCol19a=0;
    						$totalCol20a=0;
    						$totalCol21a=0;
    						$totalCol22a=0;
    						$totalCol23a=0;
    						$totalCol24a=0;
    						$totalCol25a=0;
    						$totalCol26a=0;
    						$totalCol27a=0;
    						$totalCol28a=0;
    						$totalCol29a=0;
    						$totalCol30a=0;
    						$totalCol31a=0;
    						$totalCol32a=0;
    						$totalCol33a=0;
    						$totalCol34a=0;
    						$totalCol35a=0;
    						$totalCol36a=0;

                foreach($registro as $row ){
                    $totalCol01a=$totalCol01a+$row->Col01;
                    $totalCol02a=$totalCol02a+$row->Col02;
                    $totalCol03a=$totalCol03a+$row->Col03;
                    $totalCol04a=$totalCol04a+$row->Col04;
                    $totalCol05a=$totalCol05a+$row->Col05;
                    $totalCol06a=$totalCol06a+$row->Col06;
                    $totalCol07a=$totalCol07a+$row->Col07;
                    $totalCol08a=$totalCol08a+$row->Col08;
                    $totalCol09a=$totalCol09a+$row->Col09;
                    $totalCol10a=$totalCol10a+$row->Col10;
                    $totalCol11a=$totalCol11a+$row->Col11;
                    $totalCol12a=$totalCol12a+$row->Col12;
                    $totalCol13a=$totalCol13a+$row->Col13;
                    $totalCol14a=$totalCol14a+$row->Col14;
                    $totalCol15a=$totalCol15a+$row->Col15;
                    $totalCol16a=$totalCol16a+$row->Col16;
                    $totalCol17a=$totalCol17a+$row->Col17;
                    $totalCol18a=$totalCol18a+$row->Col18;
                    $totalCol19a=$totalCol19a+$row->Col19;
                    $totalCol20a=$totalCol20a+$row->Col20;
                    $totalCol21a=$totalCol21a+$row->Col21;
                    $totalCol22a=$totalCol22a+$row->Col22;
                    $totalCol23a=$totalCol23a+$row->Col23;
                    $totalCol24a=$totalCol24a+$row->Col24;
                    $totalCol25a=$totalCol25a+$row->Col25;
                    $totalCol26a=$totalCol26a+$row->Col26;
                    $totalCol27a=$totalCol27a+$row->Col27;
                    $totalCol28a=$totalCol28a+$row->Col28;
                    $totalCol29a=$totalCol29a+$row->Col29;
                    $totalCol30a=$totalCol30a+$row->Col30;
                    $totalCol31a=$totalCol31a+$row->Col31;
                    $totalCol32a=$totalCol32a+$row->Col32;
                    $totalCol33a=$totalCol33a+$row->Col33;
                    $totalCol34a=$totalCol34a+$row->Col34;
                    $totalCol35a=$totalCol35a+$row->Col35;
                    $totalCol36a=$totalCol36a+$row->Col36;

                    $nombre_descripcion = $row->codigo_prestacion;
                    if ($nombre_descripcion == "01010072"){
                        $nombre_descripcion = "Estudio receptor donante cadáver";
      							}
                    if ($nombre_descripcion == "01010073"){
                        $nombre_descripcion = "Estudio receptor donante vivo";
      							}
                    if ($nombre_descripcion == "01010074"){
                        $nombre_descripcion = "Estudio receptores corazón-pulmón";
      							}
                    if ($nombre_descripcion == "01010075"){
                        $nombre_descripcion = "Estudio pacientes trasplante medula ósea";
      							}
                    if ($nombre_descripcion == "01010076"){
                        $nombre_descripcion = "Trasplante de medula autólogo";
      							}
                    if ($nombre_descripcion == "01010077"){
                        $nombre_descripcion = "Trasplante de medula alógeno";
      							}
                    if ($nombre_descripcion == "01010078"){
                        $nombre_descripcion = "Trasplante medula de cordón";
      							}
                    if ($nombre_descripcion == "01010079"){
                        $nombre_descripcion = "Trasplante medula aploidentico";
      							}
                    if ($nombre_descripcion == "01010080"){
                        $nombre_descripcion = "Trasplante de córnea (incluye procuramiento y seguimiento por un año)";
      							}
                    if ($nombre_descripcion == "01010081"){
                        $nombre_descripcion = "Soporte pretrasplante hepático extracorporeo por sesión";
      							}
                    if ($nombre_descripcion == "01010082"){
                        $nombre_descripcion = "Mantención donante cadáver (pulmón, corazón o hígado) (muerte cerebral)";
      							}
                    ?>
                <tr>
                    <td align='left' nowrap><?php echo $nombre_descripcion; ?></td>
                    <td align='right'><?php echo number_format($row->Col01,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col02,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col03,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col04,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col05,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col06,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col07,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col08,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col09,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col10,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col11,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col12,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col13,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col14,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col15,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col16,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col17,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col18,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col19,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col20,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col21,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col22,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col23,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col24,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col25,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col26,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col27,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col28,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col29,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col30,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col31,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col32,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col33,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col34,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col35,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col36,0,",",".")?></td>
                    <?php
                    $i++;
                }
                ?>
                </tr>
                <tr>
                    <td align='center'><strong>TOTAL</strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol01a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol02a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol03a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol04a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol05a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol06a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol07a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol08a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol09a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol10a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol11a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol12a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol13a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol14a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol15a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol16a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol17a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol18a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol19a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol20a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol21a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol22a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol23a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol24a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol25a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol26a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol27a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol28a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol29a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol30a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol31a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol32a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol33a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol34a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol35a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol36a,0,",",".") ?></strong></td>
                </tr>
                <tr>
                    <td><strong>ATENCION CERRADA</strong></td>
                    <td colspan="36"></td>
                </tr>
                <?php
                $query = 'SELECT a.codigo_prestacion,a.descripcion
                              ,sum(ifnull(b.Col01,0)) Col01
                              ,sum(ifnull(b.Col02,0)) Col02
                              ,sum(ifnull(b.Col03,0)) Col03
                              ,sum(ifnull(b.Col04,0)) Col04
									            ,sum(ifnull(b.Col05,0)) Col05
                              ,sum(ifnull(b.Col06,0)) Col06
                              ,sum(ifnull(b.Col07,0)) Col07
                              ,sum(ifnull(b.Col08,0)) Col08
                              ,sum(ifnull(b.Col09,0)) Col09
                              ,sum(ifnull(b.Col10,0)) Col10
                              ,sum(ifnull(b.Col11,0)) Col11
                              ,sum(ifnull(b.Col12,0)) Col12
                              ,sum(ifnull(b.Col13,0)) Col13
            									,sum(ifnull(b.Col14,0)) Col14
            									,sum(ifnull(b.Col15,0)) Col15
            									,sum(ifnull(b.Col16,0)) Col16
            									,sum(ifnull(b.Col17,0)) Col17
            									,sum(ifnull(b.Col18,0)) Col18
            									,sum(ifnull(b.Col19,0)) Col19
            									,sum(ifnull(b.Col20,0)) Col20
            									,sum(ifnull(b.Col21,0)) Col21
            									,sum(ifnull(b.Col22,0)) Col22
            									,sum(ifnull(b.Col23,0)) Col23
                              ,sum(ifnull(b.Col24,0)) Col24
                              ,sum(ifnull(b.Col25,0)) Col25
                              ,sum(ifnull(b.Col26,0)) Col26
                              ,sum(ifnull(b.Col27,0)) Col27
                              ,sum(ifnull(b.Col28,0)) Col28
                              ,sum(ifnull(b.Col29,0)) Col29
                              ,sum(ifnull(b.Col30,0)) Col30
                              ,sum(ifnull(b.Col31,0)) Col31
                              ,sum(ifnull(b.Col32,0)) Col32
                              ,sum(ifnull(b.Col33,0)) Col33
                              ,sum(ifnull(b.Col34,0)) Col34
                              ,sum(ifnull(b.Col35,0)) Col35
                              ,sum(ifnull(b.Col36,0)) Col36
                          FROM (select c.* from 2019prestaciones c where c.codigo_prestacion in("01010083","01010084","01010085","01010086","01010087","01010088","01010089","01010090",
                                                                                                "01010091","01010092","01010093","01010094","01010095")) a
                          left join 2019rems b on (a.id_prestacion=b.prestacion_id_prestacion)
                          AND (b.Mes in ('.$mes.')) AND (b.establecimiento_id_establecimiento in ('.$estab.'))
                          group by  a.codigo_prestacion,a.descripcion,a.id_prestacion
                          order by a.id_prestacion';
                $registro = DB::connection('mysql_rem')->select($query);

                $i=0;

                $totalCol01a=0;
    						$totalCol02a=0;
    						$totalCol03a=0;
    						$totalCol04a=0;
    						$totalCol05a=0;
    						$totalCol06a=0;
    						$totalCol07a=0;
    						$totalCol08a=0;
    						$totalCol09a=0;
    						$totalCol10a=0;
    						$totalCol11a=0;
    						$totalCol12a=0;
    						$totalCol13a=0;
    						$totalCol14a=0;
    						$totalCol15a=0;
    						$totalCol16a=0;
    						$totalCol17a=0;
    						$totalCol18a=0;
    						$totalCol19a=0;
    						$totalCol20a=0;
    						$totalCol21a=0;
    						$totalCol22a=0;
    						$totalCol23a=0;
    						$totalCol24a=0;
    						$totalCol25a=0;
    						$totalCol26a=0;
    						$totalCol27a=0;
    						$totalCol28a=0;
    						$totalCol29a=0;
    						$totalCol30a=0;
    						$totalCol31a=0;
    						$totalCol32a=0;
    						$totalCol33a=0;
    						$totalCol34a=0;
    						$totalCol35a=0;
    						$totalCol36a=0;

                foreach($registro as $row ){
                    $totalCol01a=$totalCol01a+$row->Col01;
                    $totalCol02a=$totalCol02a+$row->Col02;
                    $totalCol03a=$totalCol03a+$row->Col03;
                    $totalCol04a=$totalCol04a+$row->Col04;
                    $totalCol05a=$totalCol05a+$row->Col05;
                    $totalCol06a=$totalCol06a+$row->Col06;
                    $totalCol07a=$totalCol07a+$row->Col07;
                    $totalCol08a=$totalCol08a+$row->Col08;
                    $totalCol09a=$totalCol09a+$row->Col09;
                    $totalCol10a=$totalCol10a+$row->Col10;
                    $totalCol11a=$totalCol11a+$row->Col11;
                    $totalCol12a=$totalCol12a+$row->Col12;
                    $totalCol13a=$totalCol13a+$row->Col13;
                    $totalCol14a=$totalCol14a+$row->Col14;
                    $totalCol15a=$totalCol15a+$row->Col15;
                    $totalCol16a=$totalCol16a+$row->Col16;
                    $totalCol17a=$totalCol17a+$row->Col17;
                    $totalCol18a=$totalCol18a+$row->Col18;
                    $totalCol19a=$totalCol19a+$row->Col19;
                    $totalCol20a=$totalCol20a+$row->Col20;
                    $totalCol21a=$totalCol21a+$row->Col21;
                    $totalCol22a=$totalCol22a+$row->Col22;
                    $totalCol23a=$totalCol23a+$row->Col23;
                    $totalCol24a=$totalCol24a+$row->Col24;
                    $totalCol25a=$totalCol25a+$row->Col25;
                    $totalCol26a=$totalCol26a+$row->Col26;
                    $totalCol27a=$totalCol27a+$row->Col27;
                    $totalCol28a=$totalCol28a+$row->Col28;
                    $totalCol29a=$totalCol29a+$row->Col29;
                    $totalCol30a=$totalCol30a+$row->Col30;
                    $totalCol31a=$totalCol31a+$row->Col31;
                    $totalCol32a=$totalCol32a+$row->Col32;
                    $totalCol33a=$totalCol33a+$row->Col33;
                    $totalCol34a=$totalCol34a+$row->Col34;
                    $totalCol35a=$totalCol35a+$row->Col35;
                    $totalCol36a=$totalCol36a+$row->Col36;

                    $nombre_descripcion = $row->codigo_prestacion;
                    if ($nombre_descripcion == "01010083"){
                        $nombre_descripcion = "Día cama hospitalización integral medicina, cirugía, pediatría, obstetricia-ginecología y especialidades (sala 3 camas o más) (Hosp. Alta Complejidad)";
      							}
                    if ($nombre_descripcion == "01010084"){
                        $nombre_descripcion = "Día cama hospitalización integral medicina, cirugía, pediatría, obstetricia-ginecología y especialidades (sala 3 camas o más) (Hosp. Mediana Complejidad)";
      							}
                    if ($nombre_descripcion == "01010085"){
                        $nombre_descripcion = "Día cama hospitalización integral medicina, cirugía, pediatría, obstetricia-ginecología y especialidades (sala 3 camas o más) (Hosp. Baja Complejidad)";
      							}
                    if ($nombre_descripcion == "01010086"){
                        $nombre_descripcion = "Día cama hospitalización integral adulto en Unidad de Cuidado Intensivo (U.C.I.)";
      							}
                    if ($nombre_descripcion == "01010087"){
                        $nombre_descripcion = "Día cama hospitalización integral pediátrica en Unidad de Cuidado Intensivo (U.C.I).";
      							}
                    if ($nombre_descripcion == "01010088"){
                        $nombre_descripcion = "Día cama hospitalización integral neonatal en Unidad de Cuidado Intensivo (U.C.I.)";
      							}
                    if ($nombre_descripcion == "01010089"){
                        $nombre_descripcion = "Día cama hospitalización integral adulto en Unidad de Tratamiento Intermedio (U.T.I)";
      							}
                    if ($nombre_descripcion == "01010090"){
                        $nombre_descripcion = "Día cama hospitalización integral pediátrica en Unidad de Tratamiento Intermedio (U.T.I)";
      							}
                    if ($nombre_descripcion == "01010091"){
                        $nombre_descripcion = "Día cama hospitalización integral neonatal en Unidad de Tratamiento Intermedio (U.T.I)";
      							}
                    if ($nombre_descripcion == "01010092"){
                        $nombre_descripcion = "Día cama hospitalización integral incubadora";
      							}
                    if ($nombre_descripcion == "01010093"){
                        $nombre_descripcion = "Día cama hospitalización integral psiquiatría crónicos";
      							}
                    if ($nombre_descripcion == "01010094"){
                        $nombre_descripcion = "Día cama hosp. integral psiquiatría corta estadía";
      							}
                    if ($nombre_descripcion == "01010095"){
                        $nombre_descripcion = "Día cama hosp. integral desintoxicación alcohol y drogas";
      							}
                    ?>
                <tr>
                    <td align='left'><?php echo $nombre_descripcion; ?></td>
                    <td align='right'><?php echo number_format($row->Col01,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col02,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col03,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col04,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col05,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col06,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col07,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col08,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col09,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col10,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col11,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col12,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col13,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col14,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col15,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col16,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col17,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col18,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col19,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col20,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col21,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col22,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col23,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col24,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col25,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col26,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col27,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col28,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col29,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col30,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col31,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col32,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col33,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col34,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col35,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col36,0,",",".")?></td>
                    <?php
                    $i++;
                }
                ?>
                </tr>
                <tr>
                    <td align='center'><strong>TOTAL</strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol01a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol02a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol03a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol04a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol05a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol06a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol07a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol08a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol09a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol10a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol11a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol12a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol13a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol14a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol15a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol16a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol17a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol18a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol19a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol20a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol21a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol22a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol23a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol24a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol25a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol26a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol27a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol28a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol29a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol30a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol31a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol32a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol33a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol34a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol35a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol36a,0,",",".") ?></strong></td>
                </tr>
                <tr>
                    <td><strong>MISCELANEOS DIA CAMA</strong></td>
                    <td colspan="36"></td>
                </tr>
                <?php
                $query = 'SELECT a.codigo_prestacion,a.descripcion
                              ,sum(ifnull(b.Col01,0)) Col01
                              ,sum(ifnull(b.Col02,0)) Col02
                              ,sum(ifnull(b.Col03,0)) Col03
                              ,sum(ifnull(b.Col04,0)) Col04
									            ,sum(ifnull(b.Col05,0)) Col05
                              ,sum(ifnull(b.Col06,0)) Col06
                              ,sum(ifnull(b.Col07,0)) Col07
                              ,sum(ifnull(b.Col08,0)) Col08
                              ,sum(ifnull(b.Col09,0)) Col09
                              ,sum(ifnull(b.Col10,0)) Col10
                              ,sum(ifnull(b.Col11,0)) Col11
                              ,sum(ifnull(b.Col12,0)) Col12
                              ,sum(ifnull(b.Col13,0)) Col13
            									,sum(ifnull(b.Col14,0)) Col14
            									,sum(ifnull(b.Col15,0)) Col15
            									,sum(ifnull(b.Col16,0)) Col16
            									,sum(ifnull(b.Col17,0)) Col17
            									,sum(ifnull(b.Col18,0)) Col18
            									,sum(ifnull(b.Col19,0)) Col19
            									,sum(ifnull(b.Col20,0)) Col20
            									,sum(ifnull(b.Col21,0)) Col21
            									,sum(ifnull(b.Col22,0)) Col22
            									,sum(ifnull(b.Col23,0)) Col23
                              ,sum(ifnull(b.Col24,0)) Col24
                              ,sum(ifnull(b.Col25,0)) Col25
                              ,sum(ifnull(b.Col26,0)) Col26
                              ,sum(ifnull(b.Col27,0)) Col27
                              ,sum(ifnull(b.Col28,0)) Col28
                              ,sum(ifnull(b.Col29,0)) Col29
                              ,sum(ifnull(b.Col30,0)) Col30
                              ,sum(ifnull(b.Col31,0)) Col31
                              ,sum(ifnull(b.Col32,0)) Col32
                              ,sum(ifnull(b.Col33,0)) Col33
                              ,sum(ifnull(b.Col34,0)) Col34
                              ,sum(ifnull(b.Col35,0)) Col35
                              ,sum(ifnull(b.Col36,0)) Col36
                          FROM (select c.* from 2019prestaciones c where c.codigo_prestacion in("01010096","01010097","01010098","01010099","01010100","01010101","01010102","01010103",
                                                                                                "01010104","01010105")) a
                          left join 2019rems b on (a.id_prestacion=b.prestacion_id_prestacion)
                          AND (b.Mes in ('.$mes.')) AND (b.establecimiento_id_establecimiento in ('.$estab.'))
                          group by  a.codigo_prestacion,a.descripcion,a.id_prestacion
                          order by a.id_prestacion';
                $registro = DB::connection('mysql_rem')->select($query);

                $i=0;

                $totalCol01a=0;
    						$totalCol02a=0;
    						$totalCol03a=0;
    						$totalCol04a=0;
    						$totalCol05a=0;
    						$totalCol06a=0;
    						$totalCol07a=0;
    						$totalCol08a=0;
    						$totalCol09a=0;
    						$totalCol10a=0;
    						$totalCol11a=0;
    						$totalCol12a=0;
    						$totalCol13a=0;
    						$totalCol14a=0;
    						$totalCol15a=0;
    						$totalCol16a=0;
    						$totalCol17a=0;
    						$totalCol18a=0;
    						$totalCol19a=0;
    						$totalCol20a=0;
    						$totalCol21a=0;
    						$totalCol22a=0;
    						$totalCol23a=0;
    						$totalCol24a=0;
    						$totalCol25a=0;
    						$totalCol26a=0;
    						$totalCol27a=0;
    						$totalCol28a=0;
    						$totalCol29a=0;
    						$totalCol30a=0;
    						$totalCol31a=0;
    						$totalCol32a=0;
    						$totalCol33a=0;
    						$totalCol34a=0;
    						$totalCol35a=0;
    						$totalCol36a=0;

                foreach($registro as $row ){
                    $totalCol01a=$totalCol01a+$row->Col01;
                    $totalCol02a=$totalCol02a+$row->Col02;
                    $totalCol03a=$totalCol03a+$row->Col03;
                    $totalCol04a=$totalCol04a+$row->Col04;
                    $totalCol05a=$totalCol05a+$row->Col05;
                    $totalCol06a=$totalCol06a+$row->Col06;
                    $totalCol07a=$totalCol07a+$row->Col07;
                    $totalCol08a=$totalCol08a+$row->Col08;
                    $totalCol09a=$totalCol09a+$row->Col09;
                    $totalCol10a=$totalCol10a+$row->Col10;
                    $totalCol11a=$totalCol11a+$row->Col11;
                    $totalCol12a=$totalCol12a+$row->Col12;
                    $totalCol13a=$totalCol13a+$row->Col13;
                    $totalCol14a=$totalCol14a+$row->Col14;
                    $totalCol15a=$totalCol15a+$row->Col15;
                    $totalCol16a=$totalCol16a+$row->Col16;
                    $totalCol17a=$totalCol17a+$row->Col17;
                    $totalCol18a=$totalCol18a+$row->Col18;
                    $totalCol19a=$totalCol19a+$row->Col19;
                    $totalCol20a=$totalCol20a+$row->Col20;
                    $totalCol21a=$totalCol21a+$row->Col21;
                    $totalCol22a=$totalCol22a+$row->Col22;
                    $totalCol23a=$totalCol23a+$row->Col23;
                    $totalCol24a=$totalCol24a+$row->Col24;
                    $totalCol25a=$totalCol25a+$row->Col25;
                    $totalCol26a=$totalCol26a+$row->Col26;
                    $totalCol27a=$totalCol27a+$row->Col27;
                    $totalCol28a=$totalCol28a+$row->Col28;
                    $totalCol29a=$totalCol29a+$row->Col29;
                    $totalCol30a=$totalCol30a+$row->Col30;
                    $totalCol31a=$totalCol31a+$row->Col31;
                    $totalCol32a=$totalCol32a+$row->Col32;
                    $totalCol33a=$totalCol33a+$row->Col33;
                    $totalCol34a=$totalCol34a+$row->Col34;
                    $totalCol35a=$totalCol35a+$row->Col35;
                    $totalCol36a=$totalCol36a+$row->Col36;

                    $nombre_descripcion = $row->codigo_prestacion;
                    if ($nombre_descripcion == "01010096"){
                        $nombre_descripcion = "Día cama integral psiquiátrico diurno";
      							}
                    if ($nombre_descripcion == "01010097"){
                        $nombre_descripcion = "Día cama hospitalización integral psiquiatría mediana estadía";
      							}
                    if ($nombre_descripcion == "01010098"){
                        $nombre_descripcion = "Día cama integral de observación o día cama integral ambulatorio diurno";
      							}
                    if ($nombre_descripcion == "01010099"){
                        $nombre_descripcion = "Camilla de observación en servicio de urgencia";
      							}
                    if ($nombre_descripcion == "01010100"){
                        $nombre_descripcion = "Día cama integral geriatría o crónicos";
      							}
                    if ($nombre_descripcion == "01010101"){
                        $nombre_descripcion = "Día estada en cámara hiperbárica";
      							}
                    if ($nombre_descripcion == "01010102"){
                        $nombre_descripcion = "Día cama hogar embarazada rural (del Servicio de Salud)";
      							}
                    if ($nombre_descripcion == "01010103"){
                        $nombre_descripcion = "Día cuna de hospitalización integral";
      							}
                    if ($nombre_descripcion == "01010104"){
                        $nombre_descripcion = "Día cama hospitalización integral urgencia H.U.A.P. (Sólo Hospital Urgencia Asistencia Pública)";
      							}
                    if ($nombre_descripcion == "01010105"){
                        $nombre_descripcion = "Día cama hogar protegido paciente psiquiátrico compensado";
      							}
                    ?>
                <tr>
                    <td align='left' nowrap><?php echo $nombre_descripcion; ?></td>
                    <td align='right'><?php echo number_format($row->Col01,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col02,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col03,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col04,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col05,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col06,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col07,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col08,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col09,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col10,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col11,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col12,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col13,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col14,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col15,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col16,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col17,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col18,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col19,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col20,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col21,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col22,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col23,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col24,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col25,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col26,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col27,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col28,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col29,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col30,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col31,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col32,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col33,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col34,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col35,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col36,0,",",".")?></td>
                    <?php
                    $i++;
                }
                ?>
                </tr>
                <tr>
                    <td align='center'><strong>TOTAL ARANCEL MAI</strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol01a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol02a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol03a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol04a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol05a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol06a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol07a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol08a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol09a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol10a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol11a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol12a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol13a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol14a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol15a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol16a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol17a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol18a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol19a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol20a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol21a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol22a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol23a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol24a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol25a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol26a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol27a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol28a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol29a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol30a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol31a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol32a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol33a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol34a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol35a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol36a,0,",",".") ?></strong></td>
                </tr>
                <?php
                $query = 'SELECT a.codigo_prestacion,a.descripcion
                              ,sum(ifnull(b.Col01,0)) Col01
                              ,sum(ifnull(b.Col02,0)) Col02
                              ,sum(ifnull(b.Col03,0)) Col03
                              ,sum(ifnull(b.Col04,0)) Col04
									            ,sum(ifnull(b.Col05,0)) Col05
                              ,sum(ifnull(b.Col06,0)) Col06
                              ,sum(ifnull(b.Col07,0)) Col07
                              ,sum(ifnull(b.Col08,0)) Col08
                              ,sum(ifnull(b.Col09,0)) Col09
                              ,sum(ifnull(b.Col10,0)) Col10
                              ,sum(ifnull(b.Col11,0)) Col11
                              ,sum(ifnull(b.Col12,0)) Col12
                              ,sum(ifnull(b.Col13,0)) Col13
            									,sum(ifnull(b.Col14,0)) Col14
            									,sum(ifnull(b.Col15,0)) Col15
            									,sum(ifnull(b.Col16,0)) Col16
            									,sum(ifnull(b.Col17,0)) Col17
            									,sum(ifnull(b.Col18,0)) Col18
            									,sum(ifnull(b.Col19,0)) Col19
            									,sum(ifnull(b.Col20,0)) Col20
            									,sum(ifnull(b.Col21,0)) Col21
            									,sum(ifnull(b.Col22,0)) Col22
            									,sum(ifnull(b.Col23,0)) Col23
                              ,sum(ifnull(b.Col24,0)) Col24
                              ,sum(ifnull(b.Col25,0)) Col25
                              ,sum(ifnull(b.Col26,0)) Col26
                              ,sum(ifnull(b.Col27,0)) Col27
                              ,sum(ifnull(b.Col28,0)) Col28
                              ,sum(ifnull(b.Col29,0)) Col29
                              ,sum(ifnull(b.Col30,0)) Col30
                              ,sum(ifnull(b.Col31,0)) Col31
                              ,sum(ifnull(b.Col32,0)) Col32
                              ,sum(ifnull(b.Col33,0)) Col33
                              ,sum(ifnull(b.Col34,0)) Col34
                              ,sum(ifnull(b.Col35,0)) Col35
                              ,sum(ifnull(b.Col36,0)) Col36
                          FROM (select c.* from 2019prestaciones c where c.codigo_prestacion in("01010106","01012818","01012819","01012820","01012821")) a
                          left join 2019rems b on (a.id_prestacion=b.prestacion_id_prestacion)
                          AND (b.Mes in ('.$mes.')) AND (b.establecimiento_id_establecimiento in ('.$estab.'))
                          group by  a.codigo_prestacion,a.descripcion,a.id_prestacion
                          order by a.id_prestacion';
                $registro = DB::connection('mysql_rem')->select($query);

                $i=0;

                $totalCol01b=0;
    						$totalCol02b=0;
    						$totalCol03b=0;
    						$totalCol04b=0;
    						$totalCol05b=0;
    						$totalCol06b=0;
    						$totalCol07b=0;
    						$totalCol08b=0;
    						$totalCol09b=0;
    						$totalCol10b=0;
    						$totalCol11b=0;
    						$totalCol12b=0;
    						$totalCol13b=0;
    						$totalCol14b=0;
    						$totalCol15b=0;
    						$totalCol16b=0;
    						$totalCol17b=0;
    						$totalCol18b=0;
    						$totalCol19b=0;
    						$totalCol20b=0;
    						$totalCol21b=0;
    						$totalCol22b=0;
    						$totalCol23b=0;
    						$totalCol24b=0;
    						$totalCol25b=0;
    						$totalCol26b=0;
    						$totalCol27b=0;
    						$totalCol28b=0;
    						$totalCol29b=0;
    						$totalCol30b=0;
    						$totalCol31b=0;
    						$totalCol32b=0;
    						$totalCol33b=0;
    						$totalCol34b=0;
    						$totalCol35b=0;
    						$totalCol36b=0;

                foreach($registro as $row ){
                    $totalCol01b=$totalCol01b+$row->Col01;
                    $totalCol02b=$totalCol02b+$row->Col02;
                    $totalCol03b=$totalCol03b+$row->Col03;
                    $totalCol04b=$totalCol04b+$row->Col04;
                    $totalCol05b=$totalCol05b+$row->Col05;
                    $totalCol06b=$totalCol06b+$row->Col06;
                    $totalCol07b=$totalCol07b+$row->Col07;
                    $totalCol08b=$totalCol08b+$row->Col08;
                    $totalCol09b=$totalCol09b+$row->Col09;
                    $totalCol10b=$totalCol10b+$row->Col10;
                    $totalCol11b=$totalCol11b+$row->Col11;
                    $totalCol12b=$totalCol12b+$row->Col12;
                    $totalCol13b=$totalCol13b+$row->Col13;
                    $totalCol14b=$totalCol14b+$row->Col14;
                    $totalCol15b=$totalCol15b+$row->Col15;
                    $totalCol16b=$totalCol16b+$row->Col16;
                    $totalCol17b=$totalCol17b+$row->Col17;
                    $totalCol18b=$totalCol18b+$row->Col18;
                    $totalCol19b=$totalCol19b+$row->Col19;
                    $totalCol20b=$totalCol20b+$row->Col20;
                    $totalCol21b=$totalCol21b+$row->Col21;
                    $totalCol22b=$totalCol22b+$row->Col22;
                    $totalCol23b=$totalCol23b+$row->Col23;
                    $totalCol24b=$totalCol24b+$row->Col24;
                    $totalCol25b=$totalCol25b+$row->Col25;
                    $totalCol26b=$totalCol26b+$row->Col26;
                    $totalCol27b=$totalCol27b+$row->Col27;
                    $totalCol28b=$totalCol28b+$row->Col28;
                    $totalCol29b=$totalCol29b+$row->Col29;
                    $totalCol30b=$totalCol30b+$row->Col30;
                    $totalCol31b=$totalCol31b+$row->Col31;
                    $totalCol32b=$totalCol32b+$row->Col32;
                    $totalCol33b=$totalCol33b+$row->Col33;
                    $totalCol34b=$totalCol34b+$row->Col34;
                    $totalCol35b=$totalCol35b+$row->Col35;
                    $totalCol36b=$totalCol36b+$row->Col36;

                    $nombre_descripcion = $row->codigo_prestacion;
                    if ($nombre_descripcion == "01010106"){
                        $nombre_descripcion = "Día Cama Residencia Protegida";
      							}
                    if ($nombre_descripcion == "01012818"){
                        $nombre_descripcion = "Día Cama de Hospitalización Medicina y Especialidades (sala 3 camas o más de pensionado o medio pensionado).";
      							}
                    if ($nombre_descripcion == "01012819"){
                        $nombre_descripcion = "Día Cama de Hospitalización Cirugía (sala 3 camas o más de pensionado o medio pensionado)";
      							}
                    if ($nombre_descripcion == "01012820"){
                        $nombre_descripcion = "Día Cama de Hospitalización Pediatría (sala 3 camas o más de pensionado o medio pensionado)";
      							}
                    if ($nombre_descripcion == "01012821"){
                        $nombre_descripcion = "Día Cama de Hospitalización Obstetricia y Ginecología (sala 3 camas o más de pensionado o medio pensionado)";
      							}
                    ?>
                <tr>
                    <td align='left' nowrap><?php echo $nombre_descripcion; ?></td>
                    <td align='right'><?php echo number_format($row->Col01,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col02,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col03,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col04,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col05,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col06,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col07,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col08,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col09,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col10,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col11,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col12,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col13,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col14,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col15,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col16,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col17,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col18,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col19,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col20,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col21,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col22,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col23,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col24,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col25,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col26,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col27,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col28,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col29,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col30,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col31,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col32,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col33,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col34,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col35,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col36,0,",",".")?></td>
                    <?php
                    $i++;
                }
                ?>
                </tr>
                <tr>
                    <td align='center'><strong>TOTAL ARANCEL MLE Y NO ARANCELADO</strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol01b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol02b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol03b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol04b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol05b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol06b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol07b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol08b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol09b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol10b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol11b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol12b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol13b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol14b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol15b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol16b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol17b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol18b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol19b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol20b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol21b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol22b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol23b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol24b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol25b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol26b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol27b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol28b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol29b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol30b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol31b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol32b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol33b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol34b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol35b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol36b,0,",",".") ?></strong></td>
                </tr>
                <tr>
                    <td align='center'><strong>TOTAL PRODUCCION</strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol01a + $totalCol01b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol02a + $totalCol02b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol03a + $totalCol03b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol04a + $totalCol04b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol05a + $totalCol05b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol06a + $totalCol06b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol07a + $totalCol07b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol08a + $totalCol08b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol09a + $totalCol09b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol10a + $totalCol10b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol11a + $totalCol11b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol12a + $totalCol12b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol13a + $totalCol13b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol14a + $totalCol14b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol15a + $totalCol15b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol16a + $totalCol16b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol17a + $totalCol17b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol18a + $totalCol18b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol19a + $totalCol19b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol20a + $totalCol20b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol21a + $totalCol21b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol22a + $totalCol22b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol23a + $totalCol23b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol24a + $totalCol24b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol25a + $totalCol25b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol26a + $totalCol26b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol27a + $totalCol27b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol28a + $totalCol28b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol29a + $totalCol29b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol30a + $totalCol30b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol31a + $totalCol31b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol32a + $totalCol32b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol33a + $totalCol33b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol34a + $totalCol34b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol35a + $totalCol35b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol36a + $totalCol36b,0,",",".") ?></strong></td>
                </tr>
                
                <!-- /* 677 - 694 */ -->

                <tr>
                    <td><strong>GRUPO 04: IMAGENOLOGIA</strong></td>
                    <td colspan="36"></td>
                </tr>
                <tr>
                    <td><strong>III. ULTRASONOGRAFIA</strong></td>
                    <td colspan="36"></td>
                </tr>
                <?php
                $query = 'SELECT a.codigo_prestacion,a.descripcion
                              ,sum(ifnull(b.Col01,0)) Col01
                              ,sum(ifnull(b.Col02,0)) Col02
                              ,sum(ifnull(b.Col03,0)) Col03
                              ,sum(ifnull(b.Col04,0)) Col04
									            ,sum(ifnull(b.Col05,0)) Col05
                              ,sum(ifnull(b.Col06,0)) Col06
                              ,sum(ifnull(b.Col07,0)) Col07
                              ,sum(ifnull(b.Col08,0)) Col08
                              ,sum(ifnull(b.Col09,0)) Col09
                              ,sum(ifnull(b.Col10,0)) Col10
                              ,sum(ifnull(b.Col11,0)) Col11
                              ,sum(ifnull(b.Col12,0)) Col12
                              ,sum(ifnull(b.Col13,0)) Col13
            									,sum(ifnull(b.Col14,0)) Col14
            									,sum(ifnull(b.Col15,0)) Col15
            									,sum(ifnull(b.Col16,0)) Col16
            									,sum(ifnull(b.Col17,0)) Col17
            									,sum(ifnull(b.Col18,0)) Col18
            									,sum(ifnull(b.Col19,0)) Col19
            									,sum(ifnull(b.Col20,0)) Col20
            									,sum(ifnull(b.Col21,0)) Col21
            									,sum(ifnull(b.Col22,0)) Col22
            									,sum(ifnull(b.Col23,0)) Col23
                              ,sum(ifnull(b.Col24,0)) Col24
                              ,sum(ifnull(b.Col25,0)) Col25
                              ,sum(ifnull(b.Col26,0)) Col26
                              ,sum(ifnull(b.Col27,0)) Col27
                              ,sum(ifnull(b.Col28,0)) Col28
                              ,sum(ifnull(b.Col29,0)) Col29
                              ,sum(ifnull(b.Col30,0)) Col30
                              ,sum(ifnull(b.Col31,0)) Col31
                              ,sum(ifnull(b.Col32,0)) Col32
                              ,sum(ifnull(b.Col33,0)) Col33
                              ,sum(ifnull(b.Col34,0)) Col34
                              ,sum(ifnull(b.Col35,0)) Col35
                              ,sum(ifnull(b.Col36,0)) Col36
                          FROM (select c.* from 2019prestaciones c where c.codigo_prestacion in("01010694","01010695","01010696","01010697","01010698","01010699","01010700","01010701",
                                                                                                "01010702","01010703","01010704","01010705","01010706","01010707","01010708","01010709",
                                                                                                "01010710","01010711","01010712","01010713")) a
                          left join 2019rems b on (a.id_prestacion=b.prestacion_id_prestacion)
                          AND (b.Mes in ('.$mes.')) AND (b.establecimiento_id_establecimiento in ('.$estab.'))
                          group by  a.codigo_prestacion,a.descripcion,a.id_prestacion
                          order by a.id_prestacion';
                $registro = DB::connection('mysql_rem')->select($query);

                $i=0;

                $totalCol01=0;
    						$totalCol02=0;
    						$totalCol03=0;
    						$totalCol04=0;
    						$totalCol05=0;
    						$totalCol06=0;
    						$totalCol07=0;
    						$totalCol08=0;
    						$totalCol09=0;
    						$totalCol10=0;
    						$totalCol11=0;
    						$totalCol12=0;
    						$totalCol13=0;
    						$totalCol14=0;
    						$totalCol15=0;
    						$totalCol16=0;
    						$totalCol17=0;
    						$totalCol18=0;
    						$totalCol19=0;
    						$totalCol20=0;
    						$totalCol21=0;
    						$totalCol22=0;
    						$totalCol23=0;
    						$totalCol24=0;
    						$totalCol25=0;
    						$totalCol26=0;
    						$totalCol27=0;
    						$totalCol28=0;
    						$totalCol29=0;
    						$totalCol30=0;
    						$totalCol31=0;
    						$totalCol32=0;
    						$totalCol33=0;
    						$totalCol34=0;
    						$totalCol35=0;
    						$totalCol36=0;

                foreach($registro as $row ){
                    $totalCol01=$totalCol01+$row->Col01;
                    $totalCol02=$totalCol02+$row->Col02;
                    $totalCol03=$totalCol03+$row->Col03;
                    $totalCol04=$totalCol04+$row->Col04;
                    $totalCol05=$totalCol05+$row->Col05;
                    $totalCol06=$totalCol06+$row->Col06;
                    $totalCol07=$totalCol07+$row->Col07;
                    $totalCol08=$totalCol08+$row->Col08;
                    $totalCol09=$totalCol09+$row->Col09;
                    $totalCol10=$totalCol10+$row->Col10;
                    $totalCol11=$totalCol11+$row->Col11;
                    $totalCol12=$totalCol12+$row->Col12;
                    $totalCol13=$totalCol13+$row->Col13;
                    $totalCol14=$totalCol14+$row->Col14;
                    $totalCol15=$totalCol15+$row->Col15;
                    $totalCol16=$totalCol16+$row->Col16;
                    $totalCol17=$totalCol17+$row->Col17;
                    $totalCol18=$totalCol18+$row->Col18;
                    $totalCol19=$totalCol19+$row->Col19;
                    $totalCol20=$totalCol20+$row->Col20;
                    $totalCol21=$totalCol21+$row->Col21;
                    $totalCol22=$totalCol22+$row->Col22;
                    $totalCol23=$totalCol23+$row->Col23;
                    $totalCol24=$totalCol24+$row->Col24;
                    $totalCol25=$totalCol25+$row->Col25;
                    $totalCol26=$totalCol26+$row->Col26;
                    $totalCol27=$totalCol27+$row->Col27;
                    $totalCol28=$totalCol28+$row->Col28;
                    $totalCol29=$totalCol29+$row->Col29;
                    $totalCol30=$totalCol30+$row->Col30;
                    $totalCol31=$totalCol31+$row->Col31;
                    $totalCol32=$totalCol32+$row->Col32;
                    $totalCol33=$totalCol33+$row->Col33;
                    $totalCol34=$totalCol34+$row->Col34;
                    $totalCol35=$totalCol35+$row->Col35;
                    $totalCol36=$totalCol36+$row->Col36;

                    $nombre_descripcion = $row->codigo_prestacion;
                    if ($nombre_descripcion == "01010694"){
                        $nombre_descripcion = "Ecografía obstétrica";
      							}
                    if ($nombre_descripcion == "01010695"){
                        $nombre_descripcion = "Ecografía abdominal (incluye hígado, vía biliar, vesícula, páncreas, riñones, bazo, retroperitoneo y grandes vasos)";
      							}
                    if ($nombre_descripcion == "01010696"){
                        $nombre_descripcion = "Ecografía como apoyo a cirugía, o a procedimiento (de tórax, muscular, partes blandas, etc.)";
      							}
                    if ($nombre_descripcion == "01010697"){
                        $nombre_descripcion = "Ecografía transvaginal o transrectal";
      							}
                    if ($nombre_descripcion == "01010698"){
                        $nombre_descripcion = "Ecografía ginecológica, pelviana femenina u obstétrica con estudio fetal";
      							}
                    if ($nombre_descripcion == "01010699"){
                        $nombre_descripcion = "Ecografía transvaginal para seguimiento de ovulación, procedimiento completo (6-8 sesiones)";
      							}
                    if ($nombre_descripcion == "01010700"){
                        $nombre_descripcion = "Ecografía para seguimiento de ovulación, procedimiento completo (6 a 8 sesiones)";
      							}
                    if ($nombre_descripcion == "01010701"){
                        $nombre_descripcion = "Ecografía pélvica masculina (incluye vejiga y próstata)";
      							}
                    if ($nombre_descripcion == "01010702"){
                        $nombre_descripcion = "Ecografía renal (bilateral), o de bazo";
      							}
                    if ($nombre_descripcion == "01010703"){
                        $nombre_descripcion = "Ecografía encefálica (RN o lactante)";
      							}
                    if ($nombre_descripcion == "01010704"){
                        $nombre_descripcion = "Ecografía mamaria bilateral (incluye Doppler)";
      							}
                    if ($nombre_descripcion == "01010705"){
                        $nombre_descripcion = "Ecografía ocular, uno o ambos ojos.";
      							}
                    if ($nombre_descripcion == "01010706"){
                        $nombre_descripcion = "Ecografía testicular (uno o ambos) (Incluye Doppler)";
      							}
                    if ($nombre_descripcion == "01010707"){
                        $nombre_descripcion = "Ecografía tiroidea (Incluye Doppler)";
      							}
                    if ($nombre_descripcion == "01010708"){
                        $nombre_descripcion = "Ecografía Partes Blandas o Musculoesquelética (cada zona anatómica)";
      							}
                    if ($nombre_descripcion == "01010709"){
                        $nombre_descripcion = "Ecografía vascular (arterial y venosa) periférica (bilateral)";
      							}
                    if ($nombre_descripcion == "01010710"){
                        $nombre_descripcion = "Ecografía doppler de vasos del cuello";
      							}
                    if ($nombre_descripcion == "01010711"){
                        $nombre_descripcion = "Ecografía transcraneana";
      							}
                    if ($nombre_descripcion == "01010712"){
                        $nombre_descripcion = "Ecografía abdominal o de vasos testiculares";
      							}
                    if ($nombre_descripcion == "01010713"){
                        $nombre_descripcion = "Ecografía doppler de vasos placentarios";
      							}
                    ?>
                <tr>
                    <td align='left' nowrap><?php echo $nombre_descripcion; ?></td>
                    <td align='right'><?php echo number_format($row->Col01,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col02,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col03,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col04,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col05,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col06,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col07,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col08,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col09,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col10,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col11,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col12,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col13,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col14,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col15,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col16,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col17,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col18,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col19,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col20,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col21,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col22,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col23,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col24,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col25,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col26,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col27,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col28,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col29,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col30,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col31,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col32,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col33,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col34,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col35,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col36,0,",",".")?></td>
                    <?php
                    $i++;
                }
                ?>
                </tr>
                <tr>
                    <td align='center'><strong>TOTAL</strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol01,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol02,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol03,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol04,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol05,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol06,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol07,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol08,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol09,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol10,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol11,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol12,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol13,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol14,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol15,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol16,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol17,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol18,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol19,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol20,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol21,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol22,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol23,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol24,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol25,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol26,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol27,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol28,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol29,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol30,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol31,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol32,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol33,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol34,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol35,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol36,0,",",".") ?></strong></td>
                </tr>
            </tbody>
        </table>
    </div>
    </div>
<?php
}
?>

@endsection

@section('custom_js')
    <script src="{{ asset('js/show_hide_tab.js') }}" defer></script>
    <script src="{{ asset('js/bootstrap-multiselect.js') }}" defer></script>
@endsection
