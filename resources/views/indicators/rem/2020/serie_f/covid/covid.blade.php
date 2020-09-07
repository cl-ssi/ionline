@extends('layouts.app')

@section('title', 'Resumen Estadistico Mensual')

@section('content')

<?php

use Illuminate\Support\Facades\DB;

?>

@include('indicators.rem.partials.navF')

<h3>RESUMEN ESTADÍSTICO MENSUAL DE DATOS DE ACTIVIDADES DE SALUD PRIORIZADAS, EN CONTEXTO DE PANDEMIA NO CONTENIDAS EN LOS REGISTROS HABITUALES REM 2020</h3>

<br>

@include('indicators.rem.2020.serie_f.search')

<?php
//(isset($establecimientos) AND isset($periodo)));

if (in_array(0, $establecimientos) and in_array(0, $periodo)) {
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
} else {
    $estab = implode(", ", $establecimientos);
    $mes = implode(", ", $periodo); ?>

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
                        <td colspan="40" class="active"><strong>SECCIÓN A: SEGUIMIENTO EN ATENCIÓN PRIMARIA DE SALUD POR LLAMADA TELEFÓNICA.</strong></td>
                    </tr>
                    <tr>
                        <td colspan="2" rowspan="2" style="text-align:center; vertical-align:middle"><strong>PROFESIONAL</strong></td>
                        <td rowspan="2" style="text-align:center; vertical-align:middle"><strong>TOTAL</strong></td>
                        <td colspan="34" align="center"><strong>POR EDAD (en años)</strong></td>
                        <td colspan="2" align="center"><strong>SEXO</strong></td>
                        <td rowspan="2" align="center" width="100"><strong>NIÑOS, NIÑAS, ADOLESCENTES Y JÓVENES RED SENAME</strong></td>
                    </tr>
                    <tr>
                        <td colspan="2" align="center"><strong>0 - 4</strong></td>
                        <td colspan="2" align="center"><strong>5 - 9</strong></td>
                        <td colspan="2" align="center"><strong>10 - 14</strong></td>
                        <td colspan="2" align="center"><strong>15 - 19</strong></td>
                        <td colspan="2" align="center"><strong>20 - 24</strong></td>
                        <td colspan="2" align="center"><strong>25 - 29</strong></td>
                        <td colspan="2" align="center"><strong>30 - 34</strong></td>
                        <td colspan="2" align="center"><strong>35 - 39</strong></td>
                        <td colspan="2" align="center"><strong>40 - 44</strong></td>
                        <td colspan="2" align="center"><strong>45 - 49</strong></td>
                        <td colspan="2" align="center"><strong>50 - 54</strong></td>
                        <td colspan="2" align="center"><strong>55 - 59</strong></td>
                        <td colspan="2" align="center"><strong>60 - 64</strong></td>
                        <td colspan="2" align="center"><strong>65 - 69</strong></td>
                        <td colspan="2" align="center"><strong>70 - 74</strong></td>
                        <td colspan="2" align="center"><strong>75 - 79</strong></td>
                        <td colspan="2" align="center"><strong>80 y mas</strong></td>
                        <td align="center"><strong>Hombres</strong></td>
                        <td align="center"><strong>Mujeres</strong></td>
                    </tr>
                </thead>
                <tbody>
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
                          FROM (select c.* from 2020prestaciones c where c.codigo_prestacion in("01950100V","01950110V","01950120V","01950711V","01950130V","01950140V")) a
                          left join 2020rems b on (a.id_prestacion=b.prestacion_id_prestacion)
                          AND (b.Mes in (' . $mes . ')) AND (b.establecimiento_id_establecimiento in (' . $estab . '))
                          group by a.codigo_prestacion, a.descripcion, a.id_prestacion
                          order by a.id_prestacion';
                    $registro = DB::connection('mysql_rem')->select($query);

                    $i = 0;

                    $totalCol01 = 0;
                    $totalCol02 = 0;
                    $totalCol03 = 0;
                    $totalCol04 = 0;
                    $totalCol05 = 0;
                    $totalCol06 = 0;
                    $totalCol07 = 0;
                    $totalCol08 = 0;
                    $totalCol09 = 0;
                    $totalCol10 = 0;
                    $totalCol11 = 0;
                    $totalCol12 = 0;
                    $totalCol13 = 0;
                    $totalCol14 = 0;
                    $totalCol15 = 0;
                    $totalCol16 = 0;
                    $totalCol17 = 0;
                    $totalCol18 = 0;
                    $totalCol19 = 0;
                    $totalCol20 = 0;
                    $totalCol21 = 0;

                    foreach ($registro as $row) {
                        $totalCol01 = $totalCol01 + $row->Col01;
                        $totalCol02 = $totalCol02 + $row->Col02;
                        $totalCol03 = $totalCol03 + $row->Col03;
                        $totalCol04 = $totalCol04 + $row->Col04;
                        $totalCol05 = $totalCol05 + $row->Col05;
                        $totalCol06 = $totalCol06 + $row->Col06;
                        $totalCol07 = $totalCol07 + $row->Col07;
                        $totalCol08 = $totalCol08 + $row->Col08;
                        $totalCol09 = $totalCol09 + $row->Col09;
                        $totalCol10 = $totalCol10 + $row->Col10;
                        $totalCol11 = $totalCol11 + $row->Col11;
                        $totalCol12 = $totalCol12 + $row->Col12;
                        $totalCol13 = $totalCol13 + $row->Col13;
                        $totalCol14 = $totalCol14 + $row->Col14;
                        $totalCol15 = $totalCol15 + $row->Col15;
                        $totalCol16 = $totalCol16 + $row->Col16;
                        $totalCol17 = $totalCol17 + $row->Col17;
                        $totalCol18 = $totalCol18 + $row->Col18;
                        $totalCol19 = $totalCol19 + $row->Col19;
                        $totalCol20 = $totalCol20 + $row->Col20;
                        $totalCol21 = $totalCol21 + $row->Col21;

                        $nombre_descripcion = $row->codigo_prestacion;
                        if ($nombre_descripcion == "01950100V") {
                            $nombre_descripcion = "MÉDICO";
                        }
                        if ($nombre_descripcion == "01950110V") {
                            $nombre_descripcion = "ENFERMERA";
                        }
                        if ($nombre_descripcion == "01950120V") {
                            $nombre_descripcion = "GESTANTES";
                        }
                        if ($nombre_descripcion == "01950711V") {
                            $nombre_descripcion = "REGULACIÓN DE FERTILIDAD";
                        }
                        if ($nombre_descripcion == "01950130V") {
                            $nombre_descripcion = "OTROS";
                        }
                        if ($nombre_descripcion == "01950140V") {
                            $nombre_descripcion = "OTROS PROFESIONALES";
                        }
                    ?>
                        <tr>
                            <?php
                            if ($i >= 0 && $i <= 1) { ?>
                                <td align='left' colspan='2'><?php echo $nombre_descripcion; ?></td>
                            <?php
                            }
                            if ($i == 2) { ?>
                                <td align='left' rowspan="3" style="text-align:center; vertical-align:middle">MATRONA</td>
                            <?php
                            }
                            if ($i >= 2 && $i <= 4) { ?>
                                <td align='left'><?php echo $nombre_descripcion; ?></td>
                            <?php
                            }
                            if ($i >= 5) { ?>
                                <td align='left' colspan="2"><?php echo $nombre_descripcion; ?></td>
                            <?php
                            }
                            ?>
                            <td align='right'><?php echo number_format($row->Col01, 0, ",", ".") ?></td>
                            <td colspan="2" align='right'><?php echo number_format($row->Col02, 0, ",", ".") ?></td>
                            <td colspan="2" align='right'><?php echo number_format($row->Col03, 0, ",", ".") ?></td>
                            <td colspan="2" align='right'><?php echo number_format($row->Col04, 0, ",", ".") ?></td>
                            <td colspan="2" align='right'><?php echo number_format($row->Col05, 0, ",", ".") ?></td>
                            <td colspan="2" align='right'><?php echo number_format($row->Col06, 0, ",", ".") ?></td>
                            <td colspan="2" align='right'><?php echo number_format($row->Col07, 0, ",", ".") ?></td>
                            <td colspan="2" align='right'><?php echo number_format($row->Col08, 0, ",", ".") ?></td>
                            <td colspan="2" align='right'><?php echo number_format($row->Col09, 0, ",", ".") ?></td>
                            <td colspan="2" align='right'><?php echo number_format($row->Col10, 0, ",", ".") ?></td>
                            <td colspan="2" align='right'><?php echo number_format($row->Col11, 0, ",", ".") ?></td>
                            <td colspan="2" align='right'><?php echo number_format($row->Col12, 0, ",", ".") ?></td>
                            <td colspan="2" align='right'><?php echo number_format($row->Col13, 0, ",", ".") ?></td>
                            <td colspan="2" align='right'><?php echo number_format($row->Col14, 0, ",", ".") ?></td>
                            <td colspan="2" align='right'><?php echo number_format($row->Col15, 0, ",", ".") ?></td>
                            <td colspan="2" align='right'><?php echo number_format($row->Col16, 0, ",", ".") ?></td>
                            <td colspan="2" align='right'><?php echo number_format($row->Col17, 0, ",", ".") ?></td>
                            <td colspan="2" align='right'><?php echo number_format($row->Col18, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col19, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col20, 0, ",", ".") ?></td>
                            <td colspan="2" align='right'><?php echo number_format($row->Col21, 0, ",", ".") ?></td>
                        <?php
                        $i++;
                    }
                        ?>
                        </tr>
                        <tr>
                            <td align='left' colspan="2"><strong>TOTAL</strong></td>
                            <td align='right'><strong><?php echo number_format($totalCol01, 0, ",", ".") ?></strong></td>
                            <td align='right' colspan="2"><strong><?php echo number_format($totalCol02, 0, ",", ".") ?></strong></td>
                            <td align='right' colspan="2"><strong><?php echo number_format($totalCol03, 0, ",", ".") ?></strong></td>
                            <td align='right' colspan="2"><strong><?php echo number_format($totalCol04, 0, ",", ".") ?></strong></td>
                            <td align='right' colspan="2"><strong><?php echo number_format($totalCol05, 0, ",", ".") ?></strong></td>
                            <td align='right' colspan="2"><strong><?php echo number_format($totalCol06, 0, ",", ".") ?></strong></td>
                            <td align='right' colspan="2"><strong><?php echo number_format($totalCol07, 0, ",", ".") ?></strong></td>
                            <td align='right' colspan="2"><strong><?php echo number_format($totalCol08, 0, ",", ".") ?></strong></td>
                            <td align='right' colspan="2"><strong><?php echo number_format($totalCol09, 0, ",", ".") ?></strong></td>
                            <td align='right' colspan="2"><strong><?php echo number_format($totalCol10, 0, ",", ".") ?></strong></td>
                            <td align='right' colspan="2"><strong><?php echo number_format($totalCol11, 0, ",", ".") ?></strong></td>
                            <td align='right' colspan="2"><strong><?php echo number_format($totalCol12, 0, ",", ".") ?></strong></td>
                            <td align='right' colspan="2"><strong><?php echo number_format($totalCol13, 0, ",", ".") ?></strong></td>
                            <td align='right' colspan="2"><strong><?php echo number_format($totalCol14, 0, ",", ".") ?></strong></td>
                            <td align='right' colspan="2"><strong><?php echo number_format($totalCol15, 0, ",", ".") ?></strong></td>
                            <td align='right' colspan="2"><strong><?php echo number_format($totalCol16, 0, ",", ".") ?></strong></td>
                            <td align='right' colspan="2"><strong><?php echo number_format($totalCol17, 0, ",", ".") ?></strong></td>
                            <td align='right' colspan="2"><strong><?php echo number_format($totalCol18, 0, ",", ".") ?></strong></td>
                            <td align='right'><strong><?php echo number_format($totalCol19, 0, ",", ".") ?></strong></td>
                            <td align='right'><strong><?php echo number_format($totalCol20, 0, ",", ".") ?></strong></td>
                            <td align='right' colspan="2"><strong><?php echo number_format($totalCol21, 0, ",", ".") ?></strong></td>
                        </tr>
                </tbody>
            </table>
        </div>

        <br>

        <!-- SECCION B -->
        <div class="col-sm tab table-responsive" id="B">
            <table class="table table-hover table-bordered table-sm">
                <thead>
                    <tr>
                        <td colspan="38" class="active"><strong>SECCIÓN B: CONSULTA MÉDICA EN ATENCIÓN PRIMARIA DE SALUD POR LLAMADA TELEFÓNICA.</strong></td>
                    </tr>
                    <tr>
                        <td rowspan="2" style="text-align:center; vertical-align:middle"><strong></strong></td>
                        <td rowspan="2" style="text-align:center; vertical-align:middle"><strong>TOTAL</strong></td>
                        <td colspan="34" align="center"><strong>POR EDAD (en años)</strong></td>
                        <td colspan="2" align="center"><strong>SEXO</strong></td>
                    </tr>
                    <tr>
                        <td colspan="2" align="center"><strong>0 - 4</strong></td>
                        <td colspan="2" align="center"><strong>5 - 9</strong></td>
                        <td colspan="2" align="center"><strong>10 - 14</strong></td>
                        <td colspan="2" align="center"><strong>15 - 19</strong></td>
                        <td colspan="2" align="center"><strong>20 - 24</strong></td>
                        <td colspan="2" align="center"><strong>25 - 29</strong></td>
                        <td colspan="2" align="center"><strong>30 - 34</strong></td>
                        <td colspan="2" align="center"><strong>35 - 39</strong></td>
                        <td colspan="2" align="center"><strong>40 - 44</strong></td>
                        <td colspan="2" align="center"><strong>45 - 49</strong></td>
                        <td colspan="2" align="center"><strong>50 - 54</strong></td>
                        <td colspan="2" align="center"><strong>55 - 59</strong></td>
                        <td colspan="2" align="center"><strong>60 - 64</strong></td>
                        <td colspan="2" align="center"><strong>65 - 69</strong></td>
                        <td colspan="2" align="center"><strong>70 - 74</strong></td>
                        <td colspan="2" align="center"><strong>75 - 79</strong></td>
                        <td colspan="2" align="center"><strong>80 y mas</strong></td>
                        <td align="center"><strong>Hombres</strong></td>
                        <td align="center"><strong>Mujeres</strong></td>
                    </tr>
                </thead>
                <tbody>
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
                          FROM (select c.* from 2020prestaciones c where c.codigo_prestacion in("01950150V")) a
                          left join 2020rems b on (a.id_prestacion=b.prestacion_id_prestacion)
                          AND (b.Mes in (' . $mes . ')) AND (b.establecimiento_id_establecimiento in (' . $estab . '))
                          group by a.codigo_prestacion, a.descripcion, a.id_prestacion
                          order by a.id_prestacion';
                    $registro = DB::connection('mysql_rem')->select($query);

                    $i = 0;

                    foreach ($registro as $row) {

                        $nombre_descripcion = $row->codigo_prestacion;
                        if ($nombre_descripcion == "01950150V") {
                            $nombre_descripcion = "MEDICINA GENERAL";
                        }
                    ?>
                        <tr>
                            <?php
                            if ($i == 0) { ?>
                                <td align='left'><?php echo $nombre_descripcion; ?></td>
                            <?php
                            }
                            ?>
                            <td align='right'><?php echo number_format($row->Col01, 0, ",", ".") ?></td>
                            <td colspan="2" align='right'><?php echo number_format($row->Col02, 0, ",", ".") ?></td>
                            <td colspan="2" align='right'><?php echo number_format($row->Col03, 0, ",", ".") ?></td>
                            <td colspan="2" align='right'><?php echo number_format($row->Col04, 0, ",", ".") ?></td>
                            <td colspan="2" align='right'><?php echo number_format($row->Col05, 0, ",", ".") ?></td>
                            <td colspan="2" align='right'><?php echo number_format($row->Col06, 0, ",", ".") ?></td>
                            <td colspan="2" align='right'><?php echo number_format($row->Col07, 0, ",", ".") ?></td>
                            <td colspan="2" align='right'><?php echo number_format($row->Col08, 0, ",", ".") ?></td>
                            <td colspan="2" align='right'><?php echo number_format($row->Col09, 0, ",", ".") ?></td>
                            <td colspan="2" align='right'><?php echo number_format($row->Col10, 0, ",", ".") ?></td>
                            <td colspan="2" align='right'><?php echo number_format($row->Col11, 0, ",", ".") ?></td>
                            <td colspan="2" align='right'><?php echo number_format($row->Col12, 0, ",", ".") ?></td>
                            <td colspan="2" align='right'><?php echo number_format($row->Col13, 0, ",", ".") ?></td>
                            <td colspan="2" align='right'><?php echo number_format($row->Col14, 0, ",", ".") ?></td>
                            <td colspan="2" align='right'><?php echo number_format($row->Col15, 0, ",", ".") ?></td>
                            <td colspan="2" align='right'><?php echo number_format($row->Col16, 0, ",", ".") ?></td>
                            <td colspan="2" align='right'><?php echo number_format($row->Col17, 0, ",", ".") ?></td>
                            <td colspan="2" align='right'><?php echo number_format($row->Col18, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col19, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col20, 0, ",", ".") ?></td>
                        <?php
                        $i++;
                    }
                        ?>
                        </tr>
                </tbody>
            </table>
        </div>

        <br>

        <!-- SECCION C.1 -->
        <div class="col-sm tab table-responsive" id="C1">
            <table class="table table-hover table-bordered table-sm">
                <thead>
                    <tr>
                        <td colspan="30" class="active"><strong>SECCIÓN C: ATENCIONES TELEFONICAS EN CONSULTAS Y CONTROLES.</strong></td>
                    </tr>
                    <tr>
                        <td colspan="30" class="active"><strong>SECCIÓN C1: ATENCIONES TELEFONICAS MEDICAS EN ESPECIALIDAD.</strong></td>
                    </tr>
                    <tr>
                        <td rowspan="3" style="text-align:center; vertical-align:middle"><strong>ACTIVIDADES</strong></td>
                        <td rowspan="3" style="text-align:center; vertical-align:middle"><strong>TOTAL</strong></td>
                        <td colspan="19" style="text-align:center; vertical-align:middle"><strong>ATENCIONES TELEFÓNICAS DE CONSULTAS TOTALES DE ESPECIALIDAD</strong></td>
                        <td colspan="8" style="text-align:center; vertical-align:middle"><strong>ATENCIONES TELEFÓNICAS DE CONSULTAS NUEVAS DE ESPECIALIDAD SEGÚN ORIGEN</strong></td>
                        <td rowspan="3" style="text-align:center; vertical-align:middle"><strong>Atención Telefónica: entrega de los resultados de exámenes o procedimiento (Confección de recetas o lectura de exámenes)</strong></td>
                    </tr>
                    <tr>
                        <td colspan="17" align="center"><strong>GRUPO DE EDAD (en años)</strong></td>
                        <td colspan="2" align="center"><strong>SEXO</strong></td>
                        <td colspan="4" align="center"><strong>MENOS 15 AÑOS</strong></td>
                        <td colspan="4" align="center"><strong>DE 15 Y MÁS AÑOS</strong></td>
                    </tr>
                    <tr>
                        <td align="center"><strong>0 - 4</strong></td>
                        <td align="center"><strong>5 - 9</strong></td>
                        <td align="center"><strong>10 - 14</strong></td>
                        <td align="center"><strong>15 - 19</strong></td>
                        <td align="center"><strong>20 - 24</strong></td>
                        <td align="center"><strong>25 - 29</strong></td>
                        <td align="center"><strong>30 - 34</strong></td>
                        <td align="center"><strong>35 - 39</strong></td>
                        <td align="center"><strong>40 - 44</strong></td>
                        <td align="center"><strong>45 - 49</strong></td>
                        <td align="center"><strong>50 - 54</strong></td>
                        <td align="center"><strong>55 - 59</strong></td>
                        <td align="center"><strong>60 - 64</strong></td>
                        <td align="center"><strong>65 - 69</strong></td>
                        <td align="center"><strong>70 - 74</strong></td>
                        <td align="center"><strong>75 - 79</strong></td>
                        <td align="center"><strong>80 y mas</strong></td>
                        <td align="center"><strong>Hombres</strong></td>
                        <td align="center"><strong>Mujeres</strong></td>
                        <td align="center"><strong>TOTAL</strong></td>
                        <td align="center"><strong>APS</strong></td>
                        <td align="center"><strong>CAE / CDT / CRS / Hospitalización</strong></td>
                        <td align="center"><strong>URGENCIA</strong></td>
                        <td align="center"><strong>TOTAL</strong></td>
                        <td align="center"><strong>APS</strong></td>
                        <td align="center"><strong>CAE / CDT / CRS / Hospitalización</strong></td>
                        <td align="center"><strong>URGENCIA</strong></td>
                    </tr>
                </thead>
                <tbody>
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
                          FROM (select c.* from 2020prestaciones c where c.codigo_prestacion in("01950160V","01950170V","01950180V","01950190V","01950200V","01950210V","01950220V","01950230V",
                                                                                                "01950240V","01950250V","01950260V","01950270V","01950280V","01950290V","01950300V")) a
                          left join 2020rems b on (a.id_prestacion=b.prestacion_id_prestacion)
                          AND (b.Mes in (' . $mes . ')) AND (b.establecimiento_id_establecimiento in (' . $estab . '))
                          group by a.codigo_prestacion, a.descripcion, a.id_prestacion
                          order by a.id_prestacion';
                    $registro = DB::connection('mysql_rem')->select($query);

                    $i = 0;

                    $totalCol01 = 0;
                    $totalCol02 = 0;
                    $totalCol03 = 0;
                    $totalCol04 = 0;
                    $totalCol05 = 0;
                    $totalCol06 = 0;
                    $totalCol07 = 0;
                    $totalCol08 = 0;
                    $totalCol09 = 0;
                    $totalCol10 = 0;
                    $totalCol11 = 0;
                    $totalCol12 = 0;
                    $totalCol13 = 0;
                    $totalCol14 = 0;
                    $totalCol15 = 0;
                    $totalCol16 = 0;
                    $totalCol17 = 0;
                    $totalCol18 = 0;
                    $totalCol19 = 0;
                    $totalCol20 = 0;
                    $totalCol21 = 0;
                    $totalCol22 = 0;
                    $totalCol23 = 0;
                    $totalCol24 = 0;
                    $totalCol25 = 0;
                    $totalCol26 = 0;
                    $totalCol27 = 0;
                    $totalCol28 = 0;
                    $totalCol29 = 0;

                    foreach ($registro as $row) {
                        $totalCol01 = $totalCol01 + $row->Col01;
                        $totalCol02 = $totalCol02 + $row->Col02;
                        $totalCol03 = $totalCol03 + $row->Col03;
                        $totalCol04 = $totalCol04 + $row->Col04;
                        $totalCol05 = $totalCol05 + $row->Col05;
                        $totalCol06 = $totalCol06 + $row->Col06;
                        $totalCol07 = $totalCol07 + $row->Col07;
                        $totalCol08 = $totalCol08 + $row->Col08;
                        $totalCol09 = $totalCol09 + $row->Col09;
                        $totalCol10 = $totalCol10 + $row->Col10;
                        $totalCol11 = $totalCol11 + $row->Col11;
                        $totalCol12 = $totalCol12 + $row->Col12;
                        $totalCol13 = $totalCol13 + $row->Col13;
                        $totalCol14 = $totalCol14 + $row->Col14;
                        $totalCol15 = $totalCol15 + $row->Col15;
                        $totalCol16 = $totalCol16 + $row->Col16;
                        $totalCol17 = $totalCol17 + $row->Col17;
                        $totalCol18 = $totalCol18 + $row->Col18;
                        $totalCol19 = $totalCol19 + $row->Col19;
                        $totalCol20 = $totalCol20 + $row->Col20;
                        $totalCol21 = $totalCol21 + $row->Col21;
                        $totalCol22 = $totalCol22 + $row->Col22;
                        $totalCol23 = $totalCol23 + $row->Col23;
                        $totalCol24 = $totalCol24 + $row->Col24;
                        $totalCol25 = $totalCol25 + $row->Col25;
                        $totalCol26 = $totalCol26 + $row->Col26;
                        $totalCol27 = $totalCol27 + $row->Col27;
                        $totalCol28 = $totalCol28 + $row->Col28;
                        $totalCol29 = $totalCol29 + $row->Col29;

                        // $nombre_descripcion = $row->codigo_prestacion;
                        // if ($nombre_descripcion == "01950160V") {
                        //     $nombre_descripcion = "Pediatría (incluye totalidad de producción pediatrica de subespecialidades)";
                        // }
                        // if ($nombre_descripcion == "01950170V") {
                        //     $nombre_descripcion = "Medicina Interna";
                        // }
                        // if ($nombre_descripcion == "01950180V") {
                        //     $nombre_descripcion = "Cirugía";
                        // }
                        // if ($nombre_descripcion == "01950190V") {
                        //     $nombre_descripcion = "Enfermedad respiratoria de adulto (broncopulmonar)";
                        // }
                        // if ($nombre_descripcion == "01950200V") {
                        //     $nombre_descripcion = "Cardiología adulto";
                        // }
                        // if ($nombre_descripcion == "01950210V") {
                        //     $nombre_descripcion = "Endocrinología adulto";
                        // }
                        // if ($nombre_descripcion == "01950220V") {
                        //     $nombre_descripcion = "Reumatología adulto";
                        // }
                        // if ($nombre_descripcion == "01950230V") {
                        //     $nombre_descripcion = "Infectología adulto";
                        // }
                        // if ($nombre_descripcion == "01950240V") {
                        //     $nombre_descripcion = "Diabetología";
                        // }
                        // if ($nombre_descripcion == "01950250V") {
                        //     $nombre_descripcion = "Psiquiatría";
                        // }
                        // if ($nombre_descripcion == "01950260V") {
                        //     $nombre_descripcion = "Oftalmología";
                        // }
                        // if ($nombre_descripcion == "01950270V") {
                        //     $nombre_descripcion = "Otorrinolaringología";
                        // }
                        // if ($nombre_descripcion == "01950280V") {
                        //     $nombre_descripcion = "Obstetricia y Ginecología";
                        // }
                        // if ($nombre_descripcion == "01950290V") {
                        //     $nombre_descripcion = "Traumatología";
                        // }
                        // if ($nombre_descripcion == "01950300V") {
                        //     $nombre_descripcion = "Otras Especialidades Adulto";
                        // }
                    ?>
                        <tr>
                            <?php $search = array('ATENCIONES', 'TELEFONICAS', 'MEDICAS', 'EN ESPECIALIDAD '); ?>
                            <?php $fixed_string = str_replace($search, '', $row->descripcion); ?>
                            <td align='left'><?php echo strtoupper($fixed_string) ?></td>
                            <td align='right'><?php echo number_format($row->Col01, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col02, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col03, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col04, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col05, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col06, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col07, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col08, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col09, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col10, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col11, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col12, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col13, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col14, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col15, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col16, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col17, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col18, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col19, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col20, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col21, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col22, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col23, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col24, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col25, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col26, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col27, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col28, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col29, 0, ",", ".") ?></td>
                        <?php
                        $i++;
                    }
                        ?>
                        </tr>
                        <tr>
                            <td align='left'><strong>TOTAL</strong></td>
                            <td align='right'><strong><?php echo number_format($totalCol01, 0, ",", ".") ?></strong></td>
                            <td align='right'><strong><?php echo number_format($totalCol02, 0, ",", ".") ?></strong></td>
                            <td align='right'><strong><?php echo number_format($totalCol03, 0, ",", ".") ?></strong></td>
                            <td align='right'><strong><?php echo number_format($totalCol04, 0, ",", ".") ?></strong></td>
                            <td align='right'><strong><?php echo number_format($totalCol05, 0, ",", ".") ?></strong></td>
                            <td align='right'><strong><?php echo number_format($totalCol06, 0, ",", ".") ?></strong></td>
                            <td align='right'><strong><?php echo number_format($totalCol07, 0, ",", ".") ?></strong></td>
                            <td align='right'><strong><?php echo number_format($totalCol08, 0, ",", ".") ?></strong></td>
                            <td align='right'><strong><?php echo number_format($totalCol09, 0, ",", ".") ?></strong></td>
                            <td align='right'><strong><?php echo number_format($totalCol10, 0, ",", ".") ?></strong></td>
                            <td align='right'><strong><?php echo number_format($totalCol11, 0, ",", ".") ?></strong></td>
                            <td align='right'><strong><?php echo number_format($totalCol12, 0, ",", ".") ?></strong></td>
                            <td align='right'><strong><?php echo number_format($totalCol13, 0, ",", ".") ?></strong></td>
                            <td align='right'><strong><?php echo number_format($totalCol14, 0, ",", ".") ?></strong></td>
                            <td align='right'><strong><?php echo number_format($totalCol15, 0, ",", ".") ?></strong></td>
                            <td align='right'><strong><?php echo number_format($totalCol16, 0, ",", ".") ?></strong></td>
                            <td align='right'><strong><?php echo number_format($totalCol17, 0, ",", ".") ?></strong></td>
                            <td align='right'><strong><?php echo number_format($totalCol18, 0, ",", ".") ?></strong></td>
                            <td align='right'><strong><?php echo number_format($totalCol19, 0, ",", ".") ?></strong></td>
                            <td align='right'><strong><?php echo number_format($totalCol20, 0, ",", ".") ?></strong></td>
                            <td align='right'><strong><?php echo number_format($totalCol21, 0, ",", ".") ?></strong></td>
                            <td align='right'><strong><?php echo number_format($totalCol22, 0, ",", ".") ?></strong></td>
                            <td align='right'><strong><?php echo number_format($totalCol23, 0, ",", ".") ?></strong></td>
                            <td align='right'><strong><?php echo number_format($totalCol24, 0, ",", ".") ?></strong></td>
                            <td align='right'><strong><?php echo number_format($totalCol25, 0, ",", ".") ?></strong></td>
                            <td align='right'><strong><?php echo number_format($totalCol26, 0, ",", ".") ?></strong></td>
                            <td align='right'><strong><?php echo number_format($totalCol27, 0, ",", ".") ?></strong></td>
                            <td align='right'><strong><?php echo number_format($totalCol28, 0, ",", ".") ?></strong></td>
                            <td align='right'><strong><?php echo number_format($totalCol29, 0, ",", ".") ?></strong></td>
                        </tr>
                </tbody>
            </table>
        </div>

        <br>

        <!-- SECCION C.2 -->
        <div class="col-sm tab table-responsive" id="C2">
            <table class="table table-hover table-bordered table-sm">
                <thead>
                    <tr>
                        <td colspan="21" class="active"><strong>SECCIÓN C2: CONTROLES  DE ESPECIALIDAD RESUELTAS POR VISITAS DOMICILIARIAS.</strong></td>
                    </tr>
                    <tr>
                        <td rowspan="3" style="text-align:center; vertical-align:middle"><strong>ACTIVIDADES</strong></td>
                        <td rowspan="3" style="text-align:center; vertical-align:middle"><strong>TOTAL</strong></td>
                        <td colspan="17" align="center"><strong>GRUPO DE EDAD (en años)</strong></td>
                        <td colspan="2" align="center"><strong>SEXO</strong></td>
                    </tr>
                    <tr>
                        <td align="center"><strong>0 - 4</strong></td>
                        <td align="center"><strong>5 - 9</strong></td>
                        <td align="center"><strong>10 - 14</strong></td>
                        <td align="center"><strong>15 - 19</strong></td>
                        <td align="center"><strong>20 - 24</strong></td>
                        <td align="center"><strong>25 - 29</strong></td>
                        <td align="center"><strong>30 - 34</strong></td>
                        <td align="center"><strong>35 - 39</strong></td>
                        <td align="center"><strong>40 - 44</strong></td>
                        <td align="center"><strong>45 - 49</strong></td>
                        <td align="center"><strong>50 - 54</strong></td>
                        <td align="center"><strong>55 - 59</strong></td>
                        <td align="center"><strong>60 - 64</strong></td>
                        <td align="center"><strong>65 - 69</strong></td>
                        <td align="center"><strong>70 - 74</strong></td>
                        <td align="center"><strong>75 - 79</strong></td>
                        <td align="center"><strong>80 y mas</strong></td>
                        <td align="center"><strong>Hombres</strong></td>
                        <td align="center"><strong>Mujeres</strong></td>
                    </tr>
                </thead>
                <tbody>
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
                          FROM (select c.* from 2020prestaciones c where c.codigo_prestacion in("01950310V","01950320V","01950330V","01950340V","01950350V","01950360V","01950370V","01950380V",
                                                                                                "01950390V","01950400V","01950410V","01950420V","01950430V","01950440V","01950450V")) a
                          left join 2020rems b on (a.id_prestacion=b.prestacion_id_prestacion)
                          AND (b.Mes in (' . $mes . ')) AND (b.establecimiento_id_establecimiento in (' . $estab . '))
                          group by a.codigo_prestacion, a.descripcion, a.id_prestacion
                          order by a.id_prestacion';
                    $registro = DB::connection('mysql_rem')->select($query);

                    $i = 0;

                    $totalCol01 = 0;
                    $totalCol02 = 0;
                    $totalCol03 = 0;
                    $totalCol04 = 0;
                    $totalCol05 = 0;
                    $totalCol06 = 0;
                    $totalCol07 = 0;
                    $totalCol08 = 0;
                    $totalCol09 = 0;
                    $totalCol10 = 0;
                    $totalCol11 = 0;
                    $totalCol12 = 0;
                    $totalCol13 = 0;
                    $totalCol14 = 0;
                    $totalCol15 = 0;
                    $totalCol16 = 0;
                    $totalCol17 = 0;
                    $totalCol18 = 0;
                    $totalCol19 = 0;
                    $totalCol20 = 0;

                    foreach ($registro as $row) {
                        $totalCol01 = $totalCol01 + $row->Col01;
                        $totalCol02 = $totalCol02 + $row->Col02;
                        $totalCol03 = $totalCol03 + $row->Col03;
                        $totalCol04 = $totalCol04 + $row->Col04;
                        $totalCol05 = $totalCol05 + $row->Col05;
                        $totalCol06 = $totalCol06 + $row->Col06;
                        $totalCol07 = $totalCol07 + $row->Col07;
                        $totalCol08 = $totalCol08 + $row->Col08;
                        $totalCol09 = $totalCol09 + $row->Col09;
                        $totalCol10 = $totalCol10 + $row->Col10;
                        $totalCol11 = $totalCol11 + $row->Col11;
                        $totalCol12 = $totalCol12 + $row->Col12;
                        $totalCol13 = $totalCol13 + $row->Col13;
                        $totalCol14 = $totalCol14 + $row->Col14;
                        $totalCol15 = $totalCol15 + $row->Col15;
                        $totalCol16 = $totalCol16 + $row->Col16;
                        $totalCol17 = $totalCol17 + $row->Col17;
                        $totalCol18 = $totalCol18 + $row->Col18;
                        $totalCol19 = $totalCol19 + $row->Col19;
                        $totalCol20 = $totalCol20 + $row->Col20;

                        // $nombre_descripcion = $row->codigo_prestacion;
                        // if ($nombre_descripcion == "01950310V") {
                        //     $nombre_descripcion = "Pediatría (incluye totalidad de producción pediatrica de subespecialidades)";
                        // }
                        // if ($nombre_descripcion == "01950170V") {
                        //     $nombre_descripcion = "Medicina Interna";
                        // }
                        // if ($nombre_descripcion == "01950180V") {
                        //     $nombre_descripcion = "Cirugía";
                        // }
                        // if ($nombre_descripcion == "01950190V") {
                        //     $nombre_descripcion = "Enfermedad respiratoria de adulto (broncopulmonar)";
                        // }
                        // if ($nombre_descripcion == "01950200V") {
                        //     $nombre_descripcion = "Cardiología adulto";
                        // }
                        // if ($nombre_descripcion == "01950210V") {
                        //     $nombre_descripcion = "Endocrinología adulto";
                        // }
                        // if ($nombre_descripcion == "01950220V") {
                        //     $nombre_descripcion = "Reumatología adulto";
                        // }
                        // if ($nombre_descripcion == "01950230V") {
                        //     $nombre_descripcion = "Infectología adulto";
                        // }
                        // if ($nombre_descripcion == "01950240V") {
                        //     $nombre_descripcion = "Diabetología";
                        // }
                        // if ($nombre_descripcion == "01950250V") {
                        //     $nombre_descripcion = "Psiquiatría";
                        // }
                        // if ($nombre_descripcion == "01950260V") {
                        //     $nombre_descripcion = "Oftalmología";
                        // }
                        // if ($nombre_descripcion == "01950270V") {
                        //     $nombre_descripcion = "Otorrinolaringología";
                        // }
                        // if ($nombre_descripcion == "01950280V") {
                        //     $nombre_descripcion = "Obstetricia y Ginecología";
                        // }
                        // if ($nombre_descripcion == "01950290V") {
                        //     $nombre_descripcion = "Traumatología";
                        // }
                        // if ($nombre_descripcion == "01950300V") {
                        //     $nombre_descripcion = "Otras Especialidades Adulto";
                        // }
                    ?>
                        <tr>
                            <?php $search = array('CONTROLES', 'DE ESPECIALIDAD', 'RESUELTAS POR', 'VISITAS DOMICILIARIAS '); ?>
                            <?php $fixed_string = str_replace($search, '', $row->descripcion); ?>
                            <td align='left'><?php echo strtoupper($fixed_string) ?></td>
                            <td align='right'><?php echo number_format($row->Col01, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col02, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col03, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col04, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col05, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col06, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col07, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col08, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col09, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col10, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col11, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col12, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col13, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col14, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col15, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col16, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col17, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col18, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col19, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col20, 0, ",", ".") ?></td>
                        <?php
                        $i++;
                    }
                        ?>
                        </tr>
                        <tr>
                            <td align='left'><strong>TOTAL</strong></td>
                            <td align='right'><strong><?php echo number_format($totalCol01, 0, ",", ".") ?></strong></td>
                            <td align='right'><strong><?php echo number_format($totalCol02, 0, ",", ".") ?></strong></td>
                            <td align='right'><strong><?php echo number_format($totalCol03, 0, ",", ".") ?></strong></td>
                            <td align='right'><strong><?php echo number_format($totalCol04, 0, ",", ".") ?></strong></td>
                            <td align='right'><strong><?php echo number_format($totalCol05, 0, ",", ".") ?></strong></td>
                            <td align='right'><strong><?php echo number_format($totalCol06, 0, ",", ".") ?></strong></td>
                            <td align='right'><strong><?php echo number_format($totalCol07, 0, ",", ".") ?></strong></td>
                            <td align='right'><strong><?php echo number_format($totalCol08, 0, ",", ".") ?></strong></td>
                            <td align='right'><strong><?php echo number_format($totalCol09, 0, ",", ".") ?></strong></td>
                            <td align='right'><strong><?php echo number_format($totalCol10, 0, ",", ".") ?></strong></td>
                            <td align='right'><strong><?php echo number_format($totalCol11, 0, ",", ".") ?></strong></td>
                            <td align='right'><strong><?php echo number_format($totalCol12, 0, ",", ".") ?></strong></td>
                            <td align='right'><strong><?php echo number_format($totalCol13, 0, ",", ".") ?></strong></td>
                            <td align='right'><strong><?php echo number_format($totalCol14, 0, ",", ".") ?></strong></td>
                            <td align='right'><strong><?php echo number_format($totalCol15, 0, ",", ".") ?></strong></td>
                            <td align='right'><strong><?php echo number_format($totalCol16, 0, ",", ".") ?></strong></td>
                            <td align='right'><strong><?php echo number_format($totalCol17, 0, ",", ".") ?></strong></td>
                            <td align='right'><strong><?php echo number_format($totalCol18, 0, ",", ".") ?></strong></td>
                            <td align='right'><strong><?php echo number_format($totalCol19, 0, ",", ".") ?></strong></td>
                            <td align='right'><strong><?php echo number_format($totalCol20, 0, ",", ".") ?></strong></td>
                        </tr>
                </tbody>
            </table>
        </div>

        <br>

        <!-- SECCION D.1 -->
        <div class="col-sm tab table-responsive" id="D1">
            <table class="table table-hover table-bordered table-sm">
                <thead>
                    <tr>
                        <td colspan="21" class="active"><strong>SECCIÓN D: ATENCIÓN ODONTOLÓGICA.</strong></td>
                    </tr>
                    <tr>
                        <td colspan="21" class="active"><strong>SECCIÓN D1: ATENCIÓN ODONTOLÓGICA NIVEL PRIMARIO.</strong></td>
                    </tr>
                    <tr>
                        <td rowspan="2" style="text-align:center; vertical-align:middle"><strong>ACTIVIDADES</strong></td>
                        <td colspan="3" style="text-align:center; vertical-align:middle"><strong>TOTAL</strong></td>
                        <td colspan="12" style="text-align:center; vertical-align:middle"><strong>SEGÚN GRUPOS DE EDAD O DE RIESGO</strong></td>
                        <td rowspan="2" style="text-align:center; vertical-align:middle"><strong>EMBARAZADAS</strong></td>
                        <td rowspan="2" style="text-align:center; vertical-align:middle"><strong>60 AÑOS (INCLUÍDO EN GRUPOS DE 20-64 AÑOS)</strong></td>
                        <td rowspan="2" style="text-align:center; vertical-align:middle"><strong>USUARIOS EN SITUACIÓN DE DISCAPACIDAD</strong></td>
                        <td rowspan="2" style="text-align:center; vertical-align:middle"><strong>NIÑOS, NIÑAS, ADOLESCENTES Y JÓVENES RED SENAME</strong></td>
                        <td rowspan="2" style="text-align:center; vertical-align:middle"><strong>MIGRANTES</strong></td>
                    </tr>
                    <tr>
                        <td align="center"><strong>Ambos sexos</strong></td>
                        <td align="center"><strong>Hombres</strong></td>
                        <td align="center"><strong>Mujeres</strong></td>
                        <td align="center"><strong>menos de 1 año</strong></td>
                        <td align="center"><strong>1 año</strong></td>
                        <td align="center"><strong>2 años</strong></td>
                        <td align="center"><strong>3 años</strong></td>
                        <td align="center"><strong>4 años</strong></td>
                        <td align="center"><strong>5 años</strong></td>
                        <td align="center"><strong>6 años</strong></td>
                        <td align="center"><strong>12 años</strong></td>
                        <td align="center"><strong>Resto < 15 años</strong></td>
                        <td align="center"><strong>15-19 años</strong></td>
                        <td align="center"><strong>20-64 años</strong></td>
                        <td align="center"><strong>65 y más años</strong></td>            
                    </tr>
                </thead>
                <tbody>
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
                          FROM (select c.* from 2020prestaciones c where c.codigo_prestacion in("01950460V","01950470V","01950480V","01950490V","01950500V","01950510V","01950520V")) a
                          left join 2020rems b on (a.id_prestacion=b.prestacion_id_prestacion)
                          AND (b.Mes in (' . $mes . ')) AND (b.establecimiento_id_establecimiento in (' . $estab . '))
                          group by a.codigo_prestacion, a.descripcion, a.id_prestacion
                          order by a.id_prestacion';
                    $registro = DB::connection('mysql_rem')->select($query);

                    $i = 0;

                    $totalCol01 = 0;
                    $totalCol02 = 0;
                    $totalCol03 = 0;
                    $totalCol04 = 0;
                    $totalCol05 = 0;
                    $totalCol06 = 0;
                    $totalCol07 = 0;
                    $totalCol08 = 0;
                    $totalCol09 = 0;
                    $totalCol10 = 0;
                    $totalCol11 = 0;
                    $totalCol12 = 0;
                    $totalCol13 = 0;
                    $totalCol14 = 0;
                    $totalCol15 = 0;
                    $totalCol16 = 0;
                    $totalCol17 = 0;
                    $totalCol18 = 0;
                    $totalCol19 = 0;
                    $totalCol20 = 0;

                    foreach ($registro as $row) {
                        $totalCol01 = $totalCol01 + $row->Col01;
                        $totalCol02 = $totalCol02 + $row->Col02;
                        $totalCol03 = $totalCol03 + $row->Col03;
                        $totalCol04 = $totalCol04 + $row->Col04;
                        $totalCol05 = $totalCol05 + $row->Col05;
                        $totalCol06 = $totalCol06 + $row->Col06;
                        $totalCol07 = $totalCol07 + $row->Col07;
                        $totalCol08 = $totalCol08 + $row->Col08;
                        $totalCol09 = $totalCol09 + $row->Col09;
                        $totalCol10 = $totalCol10 + $row->Col10;
                        $totalCol11 = $totalCol11 + $row->Col11;
                        $totalCol12 = $totalCol12 + $row->Col12;
                        $totalCol13 = $totalCol13 + $row->Col13;
                        $totalCol14 = $totalCol14 + $row->Col14;
                        $totalCol15 = $totalCol15 + $row->Col15;
                        $totalCol16 = $totalCol16 + $row->Col16;
                        $totalCol17 = $totalCol17 + $row->Col17;
                        $totalCol18 = $totalCol18 + $row->Col18;
                        $totalCol19 = $totalCol19 + $row->Col19;
                        $totalCol20 = $totalCol20 + $row->Col20;
                    ?>
                        <tr>
                            <?php $search = array('ATENCIÓN', 'ODONTOLÓGICA', 'NIVEL PRIMARIO'); ?>
                            <?php $fixed_string = str_replace($search, '', $row->descripcion); ?>
                            <td align='left'><?php echo strtoupper($fixed_string) ?></td>
                            <td align='right'><?php echo number_format($row->Col01, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col02, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col03, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col04, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col05, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col06, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col07, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col08, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col09, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col10, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col11, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col12, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col13, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col14, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col15, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col16, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col17, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col18, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col19, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col20, 0, ",", ".") ?></td>
                        <?php
                        $i++;
                    }
                        ?>
                        </tr>
                        <tr>
                            <td align='left'><strong>TOTAL</strong></td>
                            <td align='right'><strong><?php echo number_format($totalCol01, 0, ",", ".") ?></strong></td>
                            <td align='right'><strong><?php echo number_format($totalCol02, 0, ",", ".") ?></strong></td>
                            <td align='right'><strong><?php echo number_format($totalCol03, 0, ",", ".") ?></strong></td>
                            <td align='right'><strong><?php echo number_format($totalCol04, 0, ",", ".") ?></strong></td>
                            <td align='right'><strong><?php echo number_format($totalCol05, 0, ",", ".") ?></strong></td>
                            <td align='right'><strong><?php echo number_format($totalCol06, 0, ",", ".") ?></strong></td>
                            <td align='right'><strong><?php echo number_format($totalCol07, 0, ",", ".") ?></strong></td>
                            <td align='right'><strong><?php echo number_format($totalCol08, 0, ",", ".") ?></strong></td>
                            <td align='right'><strong><?php echo number_format($totalCol09, 0, ",", ".") ?></strong></td>
                            <td align='right'><strong><?php echo number_format($totalCol10, 0, ",", ".") ?></strong></td>
                            <td align='right'><strong><?php echo number_format($totalCol11, 0, ",", ".") ?></strong></td>
                            <td align='right'><strong><?php echo number_format($totalCol12, 0, ",", ".") ?></strong></td>
                            <td align='right'><strong><?php echo number_format($totalCol13, 0, ",", ".") ?></strong></td>
                            <td align='right'><strong><?php echo number_format($totalCol14, 0, ",", ".") ?></strong></td>
                            <td align='right'><strong><?php echo number_format($totalCol15, 0, ",", ".") ?></strong></td>
                            <td align='right'><strong><?php echo number_format($totalCol16, 0, ",", ".") ?></strong></td>
                            <td align='right'><strong><?php echo number_format($totalCol17, 0, ",", ".") ?></strong></td>
                            <td align='right'><strong><?php echo number_format($totalCol18, 0, ",", ".") ?></strong></td>
                            <td align='right'><strong><?php echo number_format($totalCol19, 0, ",", ".") ?></strong></td>
                            <td align='right'><strong><?php echo number_format($totalCol20, 0, ",", ".") ?></strong></td>
                        </tr>
                </tbody>
            </table>
        </div>

        <br>

        <!-- SECCION D.2 -->
        <div class="col-sm tab table-responsive" id="D2">
            <table class="table table-hover table-bordered table-sm">
                <thead>
                    <tr>
                        <td colspan="22" class="active"><strong>SECCIÓN D2: ATENCIÓN ODONTOLÓGICA ESTABLECIMIENTOS HOSPITALARIOS DE BAJA, MEDIANA Y ALTA COMPLEJIDAD.</strong></td>
                    </tr>
                    <tr>
                        <td rowspan="2" style="text-align:center; vertical-align:middle"><strong>ACTIVIDADES</strong></td>
                        <td colspan="3" style="text-align:center; vertical-align:middle"><strong>TOTAL</strong></td>
                        <td colspan="8" style="text-align:center; vertical-align:middle"><strong>SEGÚN GRUPOS DE EDAD O DE RIESGO</strong></td>
                        <td rowspan="2" style="text-align:center; vertical-align:middle"><strong>EMBARAZADAS</strong></td>
                        <td rowspan="2" style="text-align:center; vertical-align:middle"><strong>BENEFICIARIOS</strong></td>
                        <td rowspan="2" style="text-align:center; vertical-align:middle"><strong>60 AÑOS (INCLUÍDO EN GRUPOS DE 20-64 AÑOS)</strong></td>
                        <td rowspan="2" style="text-align:center; vertical-align:middle"><strong>USUARIOS EN SITUACIÓN DE DISCAPACIDAD</strong></td>
                        <td rowspan="2" style="text-align:center; vertical-align:middle"><strong>NIÑOS, NIÑAS, ADOLESCENTES Y JÓVENES RED SENAME</strong></td>
                        <td rowspan="2" style="text-align:center; vertical-align:middle"><strong>MIGRANTES</strong></td>
                    </tr>
                    <tr>
                        <td align="center"><strong>Ambos sexos</strong></td>
                        <td align="center"><strong>Hombres</strong></td>
                        <td align="center"><strong>Mujeres</strong></td>
                        <td align="center"><strong>0 - 5 años</strong></td>
                        <td align="center"><strong>6 años</strong></td>
                        <td align="center"><strong>7 años</strong></td>
                        <td align="center"><strong>12 años</strong></td>
                        <td align="center"><strong>Resto < 15 años</strong></td>
                        <td align="center"><strong>15-19 años</strong></td>
                        <td align="center"><strong>20-64 años</strong></td>
                        <td align="center"><strong>65 y más años</strong></td>            
                    </tr>
                </thead>
                <tbody>
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
                          FROM (select c.* from 2020prestaciones c where c.codigo_prestacion in("01950530V","01950540V","01950550V","01950560V","01950570V","01950580V")) a
                          left join 2020rems b on (a.id_prestacion=b.prestacion_id_prestacion)
                          AND (b.Mes in (' . $mes . ')) AND (b.establecimiento_id_establecimiento in (' . $estab . '))
                          group by a.codigo_prestacion, a.descripcion, a.id_prestacion
                          order by a.id_prestacion';
                    $registro = DB::connection('mysql_rem')->select($query);

                    $i = 0;

                    $totalCol01 = 0;
                    $totalCol02 = 0;
                    $totalCol03 = 0;
                    $totalCol04 = 0;
                    $totalCol05 = 0;
                    $totalCol06 = 0;
                    $totalCol07 = 0;
                    $totalCol08 = 0;
                    $totalCol09 = 0;
                    $totalCol10 = 0;
                    $totalCol11 = 0;
                    $totalCol12 = 0;
                    $totalCol13 = 0;
                    $totalCol14 = 0;
                    $totalCol15 = 0;
                    $totalCol16 = 0;
                    $totalCol17 = 0;

                    foreach ($registro as $row) {
                        $totalCol01 = $totalCol01 + $row->Col01;
                        $totalCol02 = $totalCol02 + $row->Col02;
                        $totalCol03 = $totalCol03 + $row->Col03;
                        $totalCol04 = $totalCol04 + $row->Col04;
                        $totalCol05 = $totalCol05 + $row->Col05;
                        $totalCol06 = $totalCol06 + $row->Col06;
                        $totalCol07 = $totalCol07 + $row->Col07;
                        $totalCol08 = $totalCol08 + $row->Col08;
                        $totalCol09 = $totalCol09 + $row->Col09;
                        $totalCol10 = $totalCol10 + $row->Col10;
                        $totalCol11 = $totalCol11 + $row->Col11;
                        $totalCol12 = $totalCol12 + $row->Col12;
                        $totalCol13 = $totalCol13 + $row->Col13;
                        $totalCol14 = $totalCol14 + $row->Col14;
                        $totalCol15 = $totalCol15 + $row->Col15;
                        $totalCol16 = $totalCol16 + $row->Col16;
                        $totalCol17 = $totalCol17 + $row->Col17;
                    ?>
                        <tr>
                            <?php $search = array('ATENCIÓN ODONTOLÓGICA', 'ESTABLECIMIENTOS', 'HOSPITALARIOS', 'DE BAJA, MEDIANA Y ALTA', 'COMPLEJIDAD'); ?>
                            <?php $fixed_string = str_replace($search, '', $row->descripcion); ?>
                            <td align='left'><?php echo strtoupper($fixed_string) ?></td>
                            <td align='right'><?php echo number_format($row->Col01, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col02, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col03, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col04, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col05, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col06, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col07, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col08, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col09, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col10, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col11, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col12, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col13, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col14, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col15, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col16, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col17, 0, ",", ".") ?></td>
                        <?php
                        $i++;
                    }
                        ?>
                        </tr>
                        <tr>
                            <td align='left'><strong>TOTAL</strong></td>
                            <td align='right'><strong><?php echo number_format($totalCol01, 0, ",", ".") ?></strong></td>
                            <td align='right'><strong><?php echo number_format($totalCol02, 0, ",", ".") ?></strong></td>
                            <td align='right'><strong><?php echo number_format($totalCol03, 0, ",", ".") ?></strong></td>
                            <td align='right'><strong><?php echo number_format($totalCol04, 0, ",", ".") ?></strong></td>
                            <td align='right'><strong><?php echo number_format($totalCol05, 0, ",", ".") ?></strong></td>
                            <td align='right'><strong><?php echo number_format($totalCol06, 0, ",", ".") ?></strong></td>
                            <td align='right'><strong><?php echo number_format($totalCol07, 0, ",", ".") ?></strong></td>
                            <td align='right'><strong><?php echo number_format($totalCol08, 0, ",", ".") ?></strong></td>
                            <td align='right'><strong><?php echo number_format($totalCol09, 0, ",", ".") ?></strong></td>
                            <td align='right'><strong><?php echo number_format($totalCol10, 0, ",", ".") ?></strong></td>
                            <td align='right'><strong><?php echo number_format($totalCol11, 0, ",", ".") ?></strong></td>
                            <td align='right'><strong><?php echo number_format($totalCol12, 0, ",", ".") ?></strong></td>
                            <td align='right'><strong><?php echo number_format($totalCol13, 0, ",", ".") ?></strong></td>
                            <td align='right'><strong><?php echo number_format($totalCol14, 0, ",", ".") ?></strong></td>
                            <td align='right'><strong><?php echo number_format($totalCol15, 0, ",", ".") ?></strong></td>
                            <td align='right'><strong><?php echo number_format($totalCol16, 0, ",", ".") ?></strong></td>
                            <td align='right'><strong><?php echo number_format($totalCol17, 0, ",", ".") ?></strong></td>
                        </tr>
                </tbody>
            </table>
        </div>

        <br>

        <!-- SECCION E.1 -->
        <div class="col-sm tab table-responsive" id="E1">
            <table class="table table-hover table-bordered table-sm">
                <thead>
                    <tr>
                        <td colspan="42" class="active"><strong>SECCION E: ACCIONES DE SALUD MENTAL REMOTAS EN EL CONTEXTO DE PANDEMIA.</strong></td>
                    </tr>
                    <tr>
                        <td colspan="42" class="active"><strong>SECCIÓN E1: ACCIONES TELEFÓNICAS DE SALUD MENTAL EN EL CONTEXTO DE PANDEMIA (APS Y ESPECIALIDAD).</strong></td>
                    </tr>
                    <tr>
                        <td rowspan="2" style="text-align:center; vertical-align:middle"><strong>GRUPOS</strong></td>
                        <td rowspan="2" style="text-align:center; vertical-align:middle"><strong>TOTAL ACCIONES</strong></td>
                        <td colspan="34" align="center"><strong>NÚMERO DE ACCIONES TELEFÓNICAS Y DE SEGUIMIENTO POR RANGOS DE EDAD</strong></td>
                        <td colspan="2" align="center"><strong>SEXO</strong></td>
                        <td rowspan="2" style="text-align:center; vertical-align:middle"><strong>NIÑOS, NIÑAS, ADOLESCENTES Y JOVENES POBLACIÓN SENAME</strong></td>
                        <td rowspan="2" style="text-align:center; vertical-align:middle"><strong>PUEBLOS ORIGINARIOS</strong></td>
                        <td rowspan="2" style="text-align:center; vertical-align:middle"><strong>MIGRANTES</strong></td>
                        <td rowspan="2" style="text-align:center; vertical-align:middle"><strong>DEMENCIA</strong></td>
                    </tr>
                    <tr>
                        <td colspan="2" align="center"><strong>0 - 4</strong></td>
                        <td colspan="2" align="center"><strong>5 - 9</strong></td>
                        <td colspan="2" align="center"><strong>10 - 14</strong></td>
                        <td colspan="2" align="center"><strong>15 - 19</strong></td>
                        <td colspan="2" align="center"><strong>20 - 24</strong></td>
                        <td colspan="2" align="center"><strong>25 - 29</strong></td>
                        <td colspan="2" align="center"><strong>30 - 34</strong></td>
                        <td colspan="2" align="center"><strong>35 - 39</strong></td>
                        <td colspan="2" align="center"><strong>40 - 44</strong></td>
                        <td colspan="2" align="center"><strong>45 - 49</strong></td>
                        <td colspan="2" align="center"><strong>50 - 54</strong></td>
                        <td colspan="2" align="center"><strong>55 - 59</strong></td>
                        <td colspan="2" align="center"><strong>60 - 64</strong></td>
                        <td colspan="2" align="center"><strong>65 - 69</strong></td>
                        <td colspan="2" align="center"><strong>70 - 74</strong></td>
                        <td colspan="2" align="center"><strong>75 - 79</strong></td>
                        <td colspan="2" align="center"><strong>80 y mas</strong></td>
                        <td align="center"><strong>Hombres</strong></td>
                        <td align="center"><strong>Mujeres</strong></td>
                    </tr>
                </thead>
                <tbody>
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
                          FROM (select c.* from 2020prestaciones c where c.codigo_prestacion in("01950590V", "01950600V", "01950610V")) a
                          left join 2020rems b on (a.id_prestacion=b.prestacion_id_prestacion)
                          AND (b.Mes in (' . $mes . ')) AND (b.establecimiento_id_establecimiento in (' . $estab . '))
                          group by a.codigo_prestacion, a.descripcion, a.id_prestacion
                          order by a.id_prestacion';
                    $registro = DB::connection('mysql_rem')->select($query);

                    $i = 0;

                    foreach ($registro as $row) {
                    ?>
                        <tr>
                            <?php $search = array('ACCIONES TELEFÓNICAS', 'DE SALUD MENTAL', 'EN EL CONTEXTO DE', 'PANDEMIA', 'DEPANDEMIA', '(APS Y ESPECIALIDAD)'); ?>
                            <?php $fixed_string = str_replace($search, '', $row->descripcion); ?>
                            <td align='left'><?php echo strtoupper($fixed_string) ?></td>
                            <td align='right'><?php echo number_format($row->Col01, 0, ",", ".") ?></td>
                            <td colspan="2" align='right'><?php echo number_format($row->Col02, 0, ",", ".") ?></td>
                            <td colspan="2" align='right'><?php echo number_format($row->Col03, 0, ",", ".") ?></td>
                            <td colspan="2" align='right'><?php echo number_format($row->Col04, 0, ",", ".") ?></td>
                            <td colspan="2" align='right'><?php echo number_format($row->Col05, 0, ",", ".") ?></td>
                            <td colspan="2" align='right'><?php echo number_format($row->Col06, 0, ",", ".") ?></td>
                            <td colspan="2" align='right'><?php echo number_format($row->Col07, 0, ",", ".") ?></td>
                            <td colspan="2" align='right'><?php echo number_format($row->Col08, 0, ",", ".") ?></td>
                            <td colspan="2" align='right'><?php echo number_format($row->Col09, 0, ",", ".") ?></td>
                            <td colspan="2" align='right'><?php echo number_format($row->Col10, 0, ",", ".") ?></td>
                            <td colspan="2" align='right'><?php echo number_format($row->Col11, 0, ",", ".") ?></td>
                            <td colspan="2" align='right'><?php echo number_format($row->Col12, 0, ",", ".") ?></td>
                            <td colspan="2" align='right'><?php echo number_format($row->Col13, 0, ",", ".") ?></td>
                            <td colspan="2" align='right'><?php echo number_format($row->Col14, 0, ",", ".") ?></td>
                            <td colspan="2" align='right'><?php echo number_format($row->Col15, 0, ",", ".") ?></td>
                            <td colspan="2" align='right'><?php echo number_format($row->Col16, 0, ",", ".") ?></td>
                            <td colspan="2" align='right'><?php echo number_format($row->Col17, 0, ",", ".") ?></td>
                            <td colspan="2" align='right'><?php echo number_format($row->Col18, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col19, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col20, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col21, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col22, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col23, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col24, 0, ",", ".") ?></td>
                        <?php
                        $i++;
                    }
                        ?>
                        </tr>
                </tbody>
            </table>
        </div>

        <br>

        <!-- SECCION E.2 -->
        <div class="col-sm tab table-responsive" id="E2">
            <table class="table table-hover table-bordered table-sm">
                <thead>
                        <td colspan="43" class="active"><strong>SECCIÓN E2: CONTROLES DE SALUD MENTAL REMOTOS EN EL CONTEXTO DE PANDEMIA (APS Y ESPECIALIDAD)</strong></td>
                    </tr>
                    <tr>
                        <td rowspan="3" style="text-align:center; vertical-align:middle"><strong>ACTIVIDADES</strong></td>
                        <td rowspan="3" style="text-align:center; vertical-align:middle"><strong>PROFESIONAL</strong></td>
                        <td colspan="3" rowspan="2" style="text-align:center; vertical-align:middle"><strong>TOTAL</strong></td>
                        <td colspan="34" align="center"><strong>NÚMERO DE CONTROLES DE SALUD MENTAL REMOTOS POR RANGOS DE EDAD</strong></td>
                        <td rowspan="3" style="text-align:center; vertical-align:middle"><strong>NIÑOS, NIÑAS, ADOLESCENTES Y JOVENES POBLACIÓN SENAME</strong></td>
                        <td rowspan="3" style="text-align:center; vertical-align:middle"><strong>PUEBLOS ORIGINARIOS</strong></td>
                        <td rowspan="3" style="text-align:center; vertical-align:middle"><strong>MIGRANTES</strong></td>
                        <td rowspan="3" style="text-align:center; vertical-align:middle"><strong>DEMENCIA</strong></td>
                    </tr>
                    <tr>
                        <td colspan="2" align="center"><strong>0 - 4</strong></td>
                        <td colspan="2" align="center"><strong>5 - 9</strong></td>
                        <td colspan="2" align="center"><strong>10 - 14</strong></td>
                        <td colspan="2" align="center"><strong>15 - 19</strong></td>
                        <td colspan="2" align="center"><strong>20 - 24</strong></td>
                        <td colspan="2" align="center"><strong>25 - 29</strong></td>
                        <td colspan="2" align="center"><strong>30 - 34</strong></td>
                        <td colspan="2" align="center"><strong>35 - 39</strong></td>
                        <td colspan="2" align="center"><strong>40 - 44</strong></td>
                        <td colspan="2" align="center"><strong>45 - 49</strong></td>
                        <td colspan="2" align="center"><strong>50 - 54</strong></td>
                        <td colspan="2" align="center"><strong>55 - 59</strong></td>
                        <td colspan="2" align="center"><strong>60 - 64</strong></td>
                        <td colspan="2" align="center"><strong>65 - 69</strong></td>
                        <td colspan="2" align="center"><strong>70 - 74</strong></td>
                        <td colspan="2" align="center"><strong>75 - 79</strong></td>
                        <td colspan="2" align="center"><strong>80 y mas</strong></td>
                    </tr>
                    <tr>
                        <td align="center"><strong>Ambos sexos</strong></td>
                        <td align="center"><strong>Hombres (H)</strong></td>
                        <td align="center"><strong>Mujeres (M)</strong></td>
                        <td align="center"><strong>H</strong></td>
                        <td align="center"><strong>M</strong></td>
                        <td align="center"><strong>H</strong></td>
                        <td align="center"><strong>M</strong></td>
                        <td align="center"><strong>H</strong></td>
                        <td align="center"><strong>M</strong></td>
                        <td align="center"><strong>H</strong></td>
                        <td align="center"><strong>M</strong></td>
                        <td align="center"><strong>H</strong></td>
                        <td align="center"><strong>M</strong></td>
                        <td align="center"><strong>H</strong></td>
                        <td align="center"><strong>M</strong></td>
                        <td align="center"><strong>H</strong></td>
                        <td align="center"><strong>M</strong></td>
                        <td align="center"><strong>H</strong></td>
                        <td align="center"><strong>M</strong></td>
                        <td align="center"><strong>H</strong></td>
                        <td align="center"><strong>M</strong></td>
                        <td align="center"><strong>H</strong></td>
                        <td align="center"><strong>M</strong></td>
                        <td align="center"><strong>H</strong></td>
                        <td align="center"><strong>M</strong></td>
                        <td align="center"><strong>H</strong></td>
                        <td align="center"><strong>M</strong></td>
                        <td align="center"><strong>H</strong></td>
                        <td align="center"><strong>M</strong></td>
                        <td align="center"><strong>H</strong></td>
                        <td align="center"><strong>M</strong></td>
                        <td align="center"><strong>H</strong></td>
                        <td align="center"><strong>M</strong></td>
                        <td align="center"><strong>H</strong></td>
                        <td align="center"><strong>M</strong></td>
                        <td align="center"><strong>H</strong></td>
                        <td align="center"><strong>M</strong></td>
                    </tr>
                </thead>
                <tbody>
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
            				  ,sum(ifnull(b.Col37,0)) Col37
            				  ,sum(ifnull(b.Col38,0)) Col38
            				  ,sum(ifnull(b.Col39,0)) Col39
            				  ,sum(ifnull(b.Col40,0)) Col40
            				  ,sum(ifnull(b.Col41,0)) Col41
                          FROM (select c.* from 2020prestaciones c where c.codigo_prestacion in("01950712V", "01950713V", "01950714V", "01950715V", "01950716V", "01950717V",
                                                                                                "01950718V", "01950719V", "01950720V", "01950721V", "01950722V" )) a
                          left join 2020rems b on (a.id_prestacion=b.prestacion_id_prestacion)
                          AND (b.Mes in (' . $mes . ')) AND (b.establecimiento_id_establecimiento in (' . $estab . '))
                          group by a.codigo_prestacion, a.descripcion, a.id_prestacion
                          order by a.id_prestacion';
                    $registro = DB::connection('mysql_rem')->select($query);

                    $i = 0;

                    $totalCol01 = 0;
                    $totalCol02 = 0;
                    $totalCol03 = 0;
                    $totalCol04 = 0;
                    $totalCol05 = 0;
                    $totalCol06 = 0;
                    $totalCol07 = 0;
                    $totalCol08 = 0;
                    $totalCol09 = 0;
                    $totalCol10 = 0;
                    $totalCol11 = 0;
                    $totalCol12 = 0;
                    $totalCol13 = 0;
                    $totalCol14 = 0;
                    $totalCol15 = 0;
                    $totalCol16 = 0;
                    $totalCol17 = 0;
                    $totalCol18 = 0;
                    $totalCol19 = 0;
                    $totalCol20 = 0;
                    $totalCol21 = 0;
                    $totalCol22 = 0;
                    $totalCol23 = 0;
                    $totalCol24 = 0;
                    $totalCol25 = 0;
                    $totalCol26 = 0;
                    $totalCol27 = 0;
                    $totalCol28 = 0;
                    $totalCol29 = 0;
                    $totalCol30 = 0;
                    $totalCol31 = 0;
                    $totalCol32 = 0;
                    $totalCol33 = 0;
                    $totalCol34 = 0;
                    $totalCol35 = 0;
                    $totalCol36 = 0;
                    $totalCol37 = 0;
                    $totalCol38 = 0;
                    $totalCol39 = 0;
                    $totalCol40 = 0;
                    $totalCol41 = 0;

                    foreach ($registro as $row) {
                        $totalCol01 += $row->Col01;
                        $totalCol02 += $row->Col02;
                        $totalCol03 += $row->Col03;
                        $totalCol04 += $row->Col04;
                        $totalCol05 += $row->Col05;
                        $totalCol06 += $row->Col06;
                        $totalCol07 += $row->Col07;
                        $totalCol08 += $row->Col08;
                        $totalCol09 += $row->Col09;
                        $totalCol10 += $row->Col10;
                        $totalCol11 += $row->Col11;
                        $totalCol12 += $row->Col12;
                        $totalCol13 += $row->Col13;
                        $totalCol14 += $row->Col14;
                        $totalCol15 += $row->Col15;
                        $totalCol16 += $row->Col16;
                        $totalCol17 += $row->Col17;
                        $totalCol18 += $row->Col18;
                        $totalCol19 += $row->Col19;
                        $totalCol20 += $row->Col20;
                        $totalCol21 += $row->Col21;
                        $totalCol22 += $row->Col22;
                        $totalCol23 += $row->Col23;
                        $totalCol24 += $row->Col24;
                        $totalCol25 += $row->Col25;
                        $totalCol26 += $row->Col26;
                        $totalCol27 += $row->Col27;
                        $totalCol28 += $row->Col28;
                        $totalCol29 += $row->Col29;
                        $totalCol30 += $row->Col30;
                        $totalCol31 += $row->Col31;
                        $totalCol32 += $row->Col32;
                        $totalCol33 += $row->Col33;
                        $totalCol34 += $row->Col34;
                        $totalCol35 += $row->Col35;
                        $totalCol36 += $row->Col36;
                        $totalCol37 += $row->Col37;
                        $totalCol38 += $row->Col38;
                        $totalCol39 += $row->Col39;
                        $totalCol40 += $row->Col40;
                        $totalCol41 += $row->Col41;
                    ?>
                        <tr>
                            <?php $search = array('CONTROLES DE SALUD MENTAL', 'REMOTOS', 'EN EL CONTEXTO DE PANDEMIA', '(APS Y ESPECIALIDAD)', 'POR LLAMADAS TELEFONICAS'); ?>
                            <?php $fixed_string = str_replace($search, '', $row->descripcion); ?>
                            @if($i==0)<td rowspan="12" style="text-align:center; vertical-align:middle">CONTROLES DE SALUD MENTAL POR LLAMADAS TELEFONICAS  EN EL CONTEXTO DE PANDEMIA</td>@endif
                            <td align='left'><?php echo strtoupper($fixed_string) ?></td>
                            <td align='right'><?php echo number_format($row->Col01, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col02, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col03, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col04, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col05, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col06, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col07, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col08, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col09, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col10, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col11, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col12, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col13, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col14, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col15, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col16, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col17, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col18, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col19, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col20, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col21, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col22, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col23, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col24, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col25, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col26, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col27, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col28, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col29, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col30, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col31, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col32, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col33, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col34, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col35, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col36, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col37, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col38, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col39, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col40, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col41, 0, ",", ".") ?></td>
                        <?php
                        $i++;
                    }
                        ?>
                        </tr>
                        <tr>
                            <td align='left'><strong>TOTAL</strong></td>
                            <td align='right'><strong><?php echo number_format($totalCol01, 0, ",", ".") ?></strong></td>
                            <td align='right'><strong><?php echo number_format($totalCol02, 0, ",", ".") ?></strong></td>
                            <td align='right'><strong><?php echo number_format($totalCol03, 0, ",", ".") ?></strong></td>
                            <td align='right'><strong><?php echo number_format($totalCol04, 0, ",", ".") ?></strong></td>
                            <td align='right'><strong><?php echo number_format($totalCol05, 0, ",", ".") ?></strong></td>
                            <td align='right'><strong><?php echo number_format($totalCol06, 0, ",", ".") ?></strong></td>
                            <td align='right'><strong><?php echo number_format($totalCol07, 0, ",", ".") ?></strong></td>
                            <td align='right'><strong><?php echo number_format($totalCol08, 0, ",", ".") ?></strong></td>
                            <td align='right'><strong><?php echo number_format($totalCol09, 0, ",", ".") ?></strong></td>
                            <td align='right'><strong><?php echo number_format($totalCol10, 0, ",", ".") ?></strong></td>
                            <td align='right'><strong><?php echo number_format($totalCol11, 0, ",", ".") ?></strong></td>
                            <td align='right'><strong><?php echo number_format($totalCol12, 0, ",", ".") ?></strong></td>
                            <td align='right'><strong><?php echo number_format($totalCol13, 0, ",", ".") ?></strong></td>
                            <td align='right'><strong><?php echo number_format($totalCol14, 0, ",", ".") ?></strong></td>
                            <td align='right'><strong><?php echo number_format($totalCol15, 0, ",", ".") ?></strong></td>
                            <td align='right'><strong><?php echo number_format($totalCol16, 0, ",", ".") ?></strong></td>
                            <td align='right'><strong><?php echo number_format($totalCol17, 0, ",", ".") ?></strong></td>
                            <td align='right'><strong><?php echo number_format($totalCol18, 0, ",", ".") ?></strong></td>
                            <td align='right'><strong><?php echo number_format($totalCol19, 0, ",", ".") ?></strong></td>
                            <td align='right'><strong><?php echo number_format($totalCol20, 0, ",", ".") ?></strong></td>
                            <td align='right'><strong><?php echo number_format($totalCol21, 0, ",", ".") ?></strong></td>
                            <td align='right'><strong><?php echo number_format($totalCol22, 0, ",", ".") ?></strong></td>
                            <td align='right'><strong><?php echo number_format($totalCol23, 0, ",", ".") ?></strong></td>
                            <td align='right'><strong><?php echo number_format($totalCol24, 0, ",", ".") ?></strong></td>
                            <td align='right'><strong><?php echo number_format($totalCol25, 0, ",", ".") ?></strong></td>
                            <td align='right'><strong><?php echo number_format($totalCol26, 0, ",", ".") ?></strong></td>
                            <td align='right'><strong><?php echo number_format($totalCol27, 0, ",", ".") ?></strong></td>
                            <td align='right'><strong><?php echo number_format($totalCol28, 0, ",", ".") ?></strong></td>
                            <td align='right'><strong><?php echo number_format($totalCol29, 0, ",", ".") ?></strong></td>
                            <td align='right'><strong><?php echo number_format($totalCol30, 0, ",", ".") ?></strong></td>
                            <td align='right'><strong><?php echo number_format($totalCol31, 0, ",", ".") ?></strong></td>
                            <td align='right'><strong><?php echo number_format($totalCol32, 0, ",", ".") ?></strong></td>
                            <td align='right'><strong><?php echo number_format($totalCol33, 0, ",", ".") ?></strong></td>
                            <td align='right'><strong><?php echo number_format($totalCol34, 0, ",", ".") ?></strong></td>
                            <td align='right'><strong><?php echo number_format($totalCol35, 0, ",", ".") ?></strong></td>
                            <td align='right'><strong><?php echo number_format($totalCol36, 0, ",", ".") ?></strong></td>
                            <td align='right'><strong><?php echo number_format($totalCol37, 0, ",", ".") ?></strong></td>
                            <td align='right'><strong><?php echo number_format($totalCol38, 0, ",", ".") ?></strong></td>
                            <td align='right'><strong><?php echo number_format($totalCol39, 0, ",", ".") ?></strong></td>
                            <td align='right'><strong><?php echo number_format($totalCol40, 0, ",", ".") ?></strong></td>
                            <td align='right'><strong><?php echo number_format($totalCol41, 0, ",", ".") ?></strong></td>
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
            				  ,sum(ifnull(b.Col37,0)) Col37
            				  ,sum(ifnull(b.Col38,0)) Col38
            				  ,sum(ifnull(b.Col39,0)) Col39
            				  ,sum(ifnull(b.Col40,0)) Col40
            				  ,sum(ifnull(b.Col41,0)) Col41
                          FROM (select c.* from 2020prestaciones c where c.codigo_prestacion in("01950723V", "01950724V", "01950725V", "01950726V", "01950727V", "01950728V",
                                                                                                "01950729V", "01950730V", "01950731V", "01950732V", "01950733V" )) a
                          left join 2020rems b on (a.id_prestacion=b.prestacion_id_prestacion)
                          AND (b.Mes in (' . $mes . ')) AND (b.establecimiento_id_establecimiento in (' . $estab . '))
                          group by a.codigo_prestacion, a.descripcion, a.id_prestacion
                          order by a.id_prestacion';
                    $registro = DB::connection('mysql_rem')->select($query);

                    $i = 0;

                    $totalCol01 = 0;
                    $totalCol02 = 0;
                    $totalCol03 = 0;
                    $totalCol04 = 0;
                    $totalCol05 = 0;
                    $totalCol06 = 0;
                    $totalCol07 = 0;
                    $totalCol08 = 0;
                    $totalCol09 = 0;
                    $totalCol10 = 0;
                    $totalCol11 = 0;
                    $totalCol12 = 0;
                    $totalCol13 = 0;
                    $totalCol14 = 0;
                    $totalCol15 = 0;
                    $totalCol16 = 0;
                    $totalCol17 = 0;
                    $totalCol18 = 0;
                    $totalCol19 = 0;
                    $totalCol20 = 0;
                    $totalCol21 = 0;
                    $totalCol22 = 0;
                    $totalCol23 = 0;
                    $totalCol24 = 0;
                    $totalCol25 = 0;
                    $totalCol26 = 0;
                    $totalCol27 = 0;
                    $totalCol28 = 0;
                    $totalCol29 = 0;
                    $totalCol30 = 0;
                    $totalCol31 = 0;
                    $totalCol32 = 0;
                    $totalCol33 = 0;
                    $totalCol34 = 0;
                    $totalCol35 = 0;
                    $totalCol36 = 0;
                    $totalCol37 = 0;
                    $totalCol38 = 0;
                    $totalCol39 = 0;
                    $totalCol40 = 0;
                    $totalCol41 = 0;

                    foreach ($registro as $row) {

                        $totalCol01 += $row->Col01;
                        $totalCol02 += $row->Col02;
                        $totalCol03 += $row->Col03;
                        $totalCol04 += $row->Col04;
                        $totalCol05 += $row->Col05;
                        $totalCol06 += $row->Col06;
                        $totalCol07 += $row->Col07;
                        $totalCol08 += $row->Col08;
                        $totalCol09 += $row->Col09;
                        $totalCol10 += $row->Col10;
                        $totalCol11 += $row->Col11;
                        $totalCol12 += $row->Col12;
                        $totalCol13 += $row->Col13;
                        $totalCol14 += $row->Col14;
                        $totalCol15 += $row->Col15;
                        $totalCol16 += $row->Col16;
                        $totalCol17 += $row->Col17;
                        $totalCol18 += $row->Col18;
                        $totalCol19 += $row->Col19;
                        $totalCol20 += $row->Col20;
                        $totalCol21 += $row->Col21;
                        $totalCol22 += $row->Col22;
                        $totalCol23 += $row->Col23;
                        $totalCol24 += $row->Col24;
                        $totalCol25 += $row->Col25;
                        $totalCol26 += $row->Col26;
                        $totalCol27 += $row->Col27;
                        $totalCol28 += $row->Col28;
                        $totalCol29 += $row->Col29;
                        $totalCol30 += $row->Col30;
                        $totalCol31 += $row->Col31;
                        $totalCol32 += $row->Col32;
                        $totalCol33 += $row->Col33;
                        $totalCol34 += $row->Col34;
                        $totalCol35 += $row->Col35;
                        $totalCol36 += $row->Col36;
                        $totalCol37 += $row->Col37;
                        $totalCol38 += $row->Col38;
                        $totalCol39 += $row->Col39;
                        $totalCol40 += $row->Col40;
                        $totalCol41 += $row->Col41;
                    ?>
                        <tr>
                            <?php $search = array('CONTROLES DE SALUD MENTAL', 'REMOTOS', 'EN EL CONTEXTO DE PANDEMIA', '(APS Y ESPECIALIDAD)', 'POR VIDEO LLAMADAS'); ?>
                            <?php $fixed_string = str_replace($search, '', $row->descripcion); ?>
                            @if($i==0)<td rowspan="12" style="text-align:center; vertical-align:middle">CONTROLES DE SALUD MENTAL POR VIDEO LLAMADAS  EN EL CONTEXTO DE PANDEMIA</td>@endif
                            <td align='left'><?php echo strtoupper($fixed_string) ?></td>
                            <td align='right'><?php echo number_format($row->Col01, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col02, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col03, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col04, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col05, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col06, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col07, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col08, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col09, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col10, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col11, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col12, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col13, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col14, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col15, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col16, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col17, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col18, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col19, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col20, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col21, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col22, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col23, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col24, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col25, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col26, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col27, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col28, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col29, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col30, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col31, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col32, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col33, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col34, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col35, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col36, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col37, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col38, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col39, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col40, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col41, 0, ",", ".") ?></td>
                        <?php
                        $i++;
                    }
                        ?>
                        </tr>
                        <tr>
                            <td align='left'><strong>TOTAL</strong></td>
                            <td align='right'><strong><?php echo number_format($totalCol01, 0, ",", ".") ?></strong></td>
                            <td align='right'><strong><?php echo number_format($totalCol02, 0, ",", ".") ?></strong></td>
                            <td align='right'><strong><?php echo number_format($totalCol03, 0, ",", ".") ?></strong></td>
                            <td align='right'><strong><?php echo number_format($totalCol04, 0, ",", ".") ?></strong></td>
                            <td align='right'><strong><?php echo number_format($totalCol05, 0, ",", ".") ?></strong></td>
                            <td align='right'><strong><?php echo number_format($totalCol06, 0, ",", ".") ?></strong></td>
                            <td align='right'><strong><?php echo number_format($totalCol07, 0, ",", ".") ?></strong></td>
                            <td align='right'><strong><?php echo number_format($totalCol08, 0, ",", ".") ?></strong></td>
                            <td align='right'><strong><?php echo number_format($totalCol09, 0, ",", ".") ?></strong></td>
                            <td align='right'><strong><?php echo number_format($totalCol10, 0, ",", ".") ?></strong></td>
                            <td align='right'><strong><?php echo number_format($totalCol11, 0, ",", ".") ?></strong></td>
                            <td align='right'><strong><?php echo number_format($totalCol12, 0, ",", ".") ?></strong></td>
                            <td align='right'><strong><?php echo number_format($totalCol13, 0, ",", ".") ?></strong></td>
                            <td align='right'><strong><?php echo number_format($totalCol14, 0, ",", ".") ?></strong></td>
                            <td align='right'><strong><?php echo number_format($totalCol15, 0, ",", ".") ?></strong></td>
                            <td align='right'><strong><?php echo number_format($totalCol16, 0, ",", ".") ?></strong></td>
                            <td align='right'><strong><?php echo number_format($totalCol17, 0, ",", ".") ?></strong></td>
                            <td align='right'><strong><?php echo number_format($totalCol18, 0, ",", ".") ?></strong></td>
                            <td align='right'><strong><?php echo number_format($totalCol19, 0, ",", ".") ?></strong></td>
                            <td align='right'><strong><?php echo number_format($totalCol20, 0, ",", ".") ?></strong></td>
                            <td align='right'><strong><?php echo number_format($totalCol21, 0, ",", ".") ?></strong></td>
                            <td align='right'><strong><?php echo number_format($totalCol22, 0, ",", ".") ?></strong></td>
                            <td align='right'><strong><?php echo number_format($totalCol23, 0, ",", ".") ?></strong></td>
                            <td align='right'><strong><?php echo number_format($totalCol24, 0, ",", ".") ?></strong></td>
                            <td align='right'><strong><?php echo number_format($totalCol25, 0, ",", ".") ?></strong></td>
                            <td align='right'><strong><?php echo number_format($totalCol26, 0, ",", ".") ?></strong></td>
                            <td align='right'><strong><?php echo number_format($totalCol27, 0, ",", ".") ?></strong></td>
                            <td align='right'><strong><?php echo number_format($totalCol28, 0, ",", ".") ?></strong></td>
                            <td align='right'><strong><?php echo number_format($totalCol29, 0, ",", ".") ?></strong></td>
                            <td align='right'><strong><?php echo number_format($totalCol30, 0, ",", ".") ?></strong></td>
                            <td align='right'><strong><?php echo number_format($totalCol31, 0, ",", ".") ?></strong></td>
                            <td align='right'><strong><?php echo number_format($totalCol32, 0, ",", ".") ?></strong></td>
                            <td align='right'><strong><?php echo number_format($totalCol33, 0, ",", ".") ?></strong></td>
                            <td align='right'><strong><?php echo number_format($totalCol34, 0, ",", ".") ?></strong></td>
                            <td align='right'><strong><?php echo number_format($totalCol35, 0, ",", ".") ?></strong></td>
                            <td align='right'><strong><?php echo number_format($totalCol36, 0, ",", ".") ?></strong></td>
                            <td align='right'><strong><?php echo number_format($totalCol37, 0, ",", ".") ?></strong></td>
                            <td align='right'><strong><?php echo number_format($totalCol38, 0, ",", ".") ?></strong></td>
                            <td align='right'><strong><?php echo number_format($totalCol39, 0, ",", ".") ?></strong></td>
                            <td align='right'><strong><?php echo number_format($totalCol40, 0, ",", ".") ?></strong></td>
                            <td align='right'><strong><?php echo number_format($totalCol41, 0, ",", ".") ?></strong></td>
                        </tr>
                </tbody>
            </table>
        </div>

        <br>

        <!-- SECCION F -->
        <div class="col-sm tab table-responsive" id="F">
            <table class="table table-hover table-bordered table-sm">
                <thead>
                        <td colspan="42" class="active"><strong>SECCION F: ACCIONES DE SEGUIMIENTO TELEFÓNICO EN EL PROGRAMA DE SALUD CARDIOVASCULAR EN APS EN EL CONTEXTO DE PANDEMIA.</strong></td>
                    </tr>
                    <tr>
                        <td rowspan="3" style="text-align:center; vertical-align:middle"><strong>ACTIVIDADES</strong></td>
                        <td rowspan="3" style="text-align:center; vertical-align:middle"><strong>PROFESIONAL</strong></td>
                        <td colspan="3" rowspan="2" style="text-align:center; vertical-align:middle"><strong>TOTAL</strong></td>
                        <td colspan="28" align="center"><strong>NÚMERO DE ACCIONES POR RANGOS DE EDAD</strong></td>
                        <td rowspan="3" style="text-align:center; vertical-align:middle"><strong>BENEFICIARIOS</strong></td>
                    </tr>
                    <tr>
                        <td colspan="2" align="center"><strong>15 - 19</strong></td>
                        <td colspan="2" align="center"><strong>20 - 24</strong></td>
                        <td colspan="2" align="center"><strong>25 - 29</strong></td>
                        <td colspan="2" align="center"><strong>30 - 34</strong></td>
                        <td colspan="2" align="center"><strong>35 - 39</strong></td>
                        <td colspan="2" align="center"><strong>40 - 44</strong></td>
                        <td colspan="2" align="center"><strong>45 - 49</strong></td>
                        <td colspan="2" align="center"><strong>50 - 54</strong></td>
                        <td colspan="2" align="center"><strong>55 - 59</strong></td>
                        <td colspan="2" align="center"><strong>60 - 64</strong></td>
                        <td colspan="2" align="center"><strong>65 - 69</strong></td>
                        <td colspan="2" align="center"><strong>70 - 74</strong></td>
                        <td colspan="2" align="center"><strong>75 - 79</strong></td>
                        <td colspan="2" align="center"><strong>80 y mas</strong></td>
                    </tr>
                    <tr>
                        <td align="center"><strong>Ambos sexos</strong></td>
                        <td align="center"><strong>Hombres (H)</strong></td>
                        <td align="center"><strong>Mujeres (M)</strong></td>
                        <td align="center"><strong>H</strong></td>
                        <td align="center"><strong>M</strong></td>
                        <td align="center"><strong>H</strong></td>
                        <td align="center"><strong>M</strong></td>
                        <td align="center"><strong>H</strong></td>
                        <td align="center"><strong>M</strong></td>
                        <td align="center"><strong>H</strong></td>
                        <td align="center"><strong>M</strong></td>
                        <td align="center"><strong>H</strong></td>
                        <td align="center"><strong>M</strong></td>
                        <td align="center"><strong>H</strong></td>
                        <td align="center"><strong>M</strong></td>
                        <td align="center"><strong>H</strong></td>
                        <td align="center"><strong>M</strong></td>
                        <td align="center"><strong>H</strong></td>
                        <td align="center"><strong>M</strong></td>
                        <td align="center"><strong>H</strong></td>
                        <td align="center"><strong>M</strong></td>
                        <td align="center"><strong>H</strong></td>
                        <td align="center"><strong>M</strong></td>
                        <td align="center"><strong>H</strong></td>
                        <td align="center"><strong>M</strong></td>
                        <td align="center"><strong>H</strong></td>
                        <td align="center"><strong>M</strong></td>
                        <td align="center"><strong>H</strong></td>
                        <td align="center"><strong>M</strong></td>
                        <td align="center"><strong>H</strong></td>
                        <td align="center"><strong>M</strong></td>
                    </tr>
                </thead>
                <tbody>
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
                          FROM (select c.* from 2020prestaciones c where c.codigo_prestacion in("01950640V", "01950650V", "01950660V", "01950670V", 
                                                                                                "01950680V", "01950690V", "01950700V", "01950710V" )) a
                          left join 2020rems b on (a.id_prestacion=b.prestacion_id_prestacion)
                          AND (b.Mes in (' . $mes . ')) AND (b.establecimiento_id_establecimiento in (' . $estab . '))
                          group by a.codigo_prestacion, a.descripcion, a.id_prestacion
                          order by a.id_prestacion';
                    $registro = DB::connection('mysql_rem')->select($query);

                    $i = 0;

                    foreach ($registro as $row) {
                    ?>
                        <tr>
                            <?php $search = array('ACCIONES TELEFÓNICAS DEL', 'PROGRAMA DE SALUD CARDIOVASCULAR EN APS', 'EN EL CONTEXTO DE PANDEMIA', 'Llamadas telefónicas o Video', 'llamadas', 'mensajes de texto'); ?>
                            <?php $fixed_string = str_replace($search, '', $row->descripcion); ?>
                            @if($i==0)<td rowspan="4" style="text-align:center; vertical-align:middle"><?php echo strtoupper('Llamadas telefónicas o Video llamadas') ?></td>@endif
                            @if($i==4)<td rowspan="4" style="text-align:center; vertical-align:middle"><?php echo strtoupper('Mensajes de texto') ?></td>@endif
                            <td align='left'><?php echo strtoupper($fixed_string) ?></td>
                            <td align='right'><?php echo number_format($row->Col01, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col02, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col03, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col04, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col05, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col06, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col07, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col08, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col09, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col10, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col11, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col12, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col13, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col14, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col15, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col16, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col17, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col18, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col19, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col20, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col21, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col22, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col23, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col24, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col25, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col26, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col27, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col28, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col29, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col30, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col31, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col32, 0, ",", ".") ?></td>
                        <?php
                        $i++;
                    }
                        ?>
                        </tr>
                </tbody>
            </table>
        </div>

        <br>

        <!-- SECCION G -->
        <div class="col-sm tab table-responsive" id="G">
            <table class="table table-hover table-bordered table-sm">
                <thead>
                    <tr>
                        <td colspan="7" class="active"><strong>SECCIÓN G: HOSPITALIZACIÓN DOMICILIARIA EN APS (financiada por PRAPS reforzamiento RRHH COVID19).</strong></td>
                    </tr>
                    <tr>
                        <td rowspan="2" style="text-align:center; vertical-align:middle"><strong>COMPONENTES</strong></td>
                        <td rowspan="2" style="text-align:center; vertical-align:middle"><strong>TOTAL</strong></td>
                        <td colspan="3" align="center"><strong>EDAD</strong></td>
                        <td colspan="2" align="center"><strong>SEXO</strong></td>
                    </tr>
                    <tr>
                        <td align="center"><strong>0 - 19</strong></td>
                        <td align="center"><strong>20 - 64</strong></td>
                        <td align="center"><strong>65 y mas</strong></td>
                        <td align="center"><strong>Hombres</strong></td>
                        <td align="center"><strong>Mujeres</strong></td>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $query = 'SELECT a.codigo_prestacion,a.descripcion
                              ,sum(ifnull(b.Col01,0)) Col01
                              ,sum(ifnull(b.Col02,0)) Col02
                              ,sum(ifnull(b.Col03,0)) Col03
                              ,sum(ifnull(b.Col04,0)) Col04
							  ,sum(ifnull(b.Col05,0)) Col05
                              ,sum(ifnull(b.Col06,0)) Col06
                          FROM (select c.* from 2020prestaciones c where c.codigo_prestacion in("01950734V", "01950735V", "01950736V", "01950737V",
                                                                                                "01950738V", "01950739V", "01950740V")) a
                          left join 2020rems b on (a.id_prestacion=b.prestacion_id_prestacion)
                          AND (b.Mes in (' . $mes . ')) AND (b.establecimiento_id_establecimiento in (' . $estab . '))
                          group by a.codigo_prestacion, a.descripcion, a.id_prestacion
                          order by a.id_prestacion';
                    $registro = DB::connection('mysql_rem')->select($query);

                    $i = 0;

                    foreach ($registro as $row) {
                    ?>
                        <tr>
                            <?php $search = array('HOSPITALIZACIÓN DOMICILIARIA EN APS', '(financiada por PRAPS reforzamiento RRHH COVID19)'); ?>
                            <?php $fixed_string = str_replace($search, '', $row->descripcion); ?>
                            <td align='left'><?php echo strtoupper($fixed_string) ?></td>
                            <td align='right'><?php echo number_format($row->Col01, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col02, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col03, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col04, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col05, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col06, 0, ",", ".") ?></td>
                        <?php
                        $i++;
                    }
                        ?>
                        </tr>
                </tbody>
            </table>
        </div>

        <br>

        <!-- SECCION H -->
        <div class="col-sm tab table-responsive" id="H">
            <table class="table table-hover table-bordered table-sm">
                <thead>
                    <tr>
                        <td colspan="2" class="active"><strong>SECCIÓN H: ATENCIÓN DOMICILIARIA (financiada por PRAPS reforzamiento RRHH COVID19).</strong></td>
                    </tr>
                    <tr>
                        <td style="text-align:center; vertical-align:middle"><strong>ACTIVIDAD</strong></td>
                        <td style="text-align:center; vertical-align:middle"><strong>TOTAL</strong></td>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $query = 'SELECT a.codigo_prestacion,a.descripcion
                              ,sum(ifnull(b.Col01,0)) Col01
                          FROM (select c.* from 2020prestaciones c where c.codigo_prestacion in("01950741V", "01950742V", "01950743V")) a
                          left join 2020rems b on (a.id_prestacion=b.prestacion_id_prestacion)
                          AND (b.Mes in (' . $mes . ')) AND (b.establecimiento_id_establecimiento in (' . $estab . '))
                          group by a.codigo_prestacion, a.descripcion, a.id_prestacion
                          order by a.id_prestacion';
                    $registro = DB::connection('mysql_rem')->select($query);

                    $i = 0;

                    foreach ($registro as $row) {
                    ?>
                        <tr>
                            <?php $search = array('ATENCIÓN DOMICILIARIA', '(financiada por PRAPS reforzamiento RRHH COVID19)'); ?>
                            <?php $fixed_string = str_replace($search, '', $row->descripcion); ?>
                            <td align='left'><?php echo strtoupper($fixed_string) ?></td>
                            <td align='right'><?php echo number_format($row->Col01, 0, ",", ".") ?></td>
                        <?php
                        $i++;
                    }
                        ?>
                        </tr>
                </tbody>
            </table>
        </div>

        <br>

        <!-- SECCION I -->
        <div class="col-sm tab table-responsive" id="I">
            <table class="table table-hover table-bordered table-sm">
                <thead>
                    <tr>
                        <td colspan="4" class="active"><strong>SECCIÓN I: DESPACHO DE RECETAS DE PACIENTES AMBULATORIOS  EN DOMICILIO.</strong></td>
                    </tr>
                    <tr>
                        <td rowspan="2" style="text-align:center; vertical-align:middle"><strong>TIPO RECETA</strong></td>
                        <td colspan="2" style="text-align:center; vertical-align:middle"><strong>RECETAS DESPACHADAS</strong></td>
                    </tr>
                    <tr>
                        <td style="text-align:center; vertical-align:middle"><strong>DESPACHO TOTAL</strong></td>
                        <td style="text-align:center; vertical-align:middle"><strong>DESPACHO PARCIAL</strong></td>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $query = 'SELECT a.codigo_prestacion,a.descripcion
                              ,sum(ifnull(b.Col01,0)) Col01
                              ,sum(ifnull(b.Col02,0)) Col02
                          FROM (select c.* from 2020prestaciones c where c.codigo_prestacion in("01950744V", "01950745V", "01950746V")) a
                          left join 2020rems b on (a.id_prestacion=b.prestacion_id_prestacion)
                          AND (b.Mes in (' . $mes . ')) AND (b.establecimiento_id_establecimiento in (' . $estab . '))
                          group by a.codigo_prestacion, a.descripcion, a.id_prestacion
                          order by a.id_prestacion';
                    $registro = DB::connection('mysql_rem')->select($query);

                    $i = 0;
                    $totalCol01 = 0;
                    $totalCol02 = 0;

                    foreach ($registro as $row) {
                        $totalCol01 += $row->Col01;
                        $totalCol02 += $row->Col02;
                    ?>
                        <tr>
                            <?php $search = array('DESPACHO DE RECETAS', 'DE PACIENTES AMBULATORIOS', 'EN DOMICILIO'); ?>
                            <?php $fixed_string = str_replace($search, '', $row->descripcion); ?>
                            <td align='left'><?php echo strtoupper($fixed_string) ?></td>
                            <td align='right'><?php echo number_format($row->Col01, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col02, 0, ",", ".") ?></td>
                        <?php
                        $i++;
                    }
                        ?>
                        </tr>
                        <tr>
                            <td align='left'><strong>TOTAL</strong></td>
                            <td align='right'><strong><?php echo number_format($totalCol01, 0, ",", ".") ?></strong></td>
                            <td align='right'><strong><?php echo number_format($totalCol02, 0, ",", ".") ?></strong></td>
                        </tr>
                </tbody>
            </table>
        </div>

        <br>

        <!-- SECCION J -->
        <div class="col-sm tab table-responsive" id="J">
            <table class="table table-hover table-bordered table-sm">
                <thead>
                        <td colspan="42" class="active"><strong>SECCIÓN J: ACTIVIDADES DE ACOMPAÑAMIENTO REMOTO A PERSONAS MAYORES Y SUS FAMILIAS POR PARTE DEL PROGRAMA MÁS ADULTOS MAYORES AUTOVALENTES.</strong></td>
                    </tr>
                    <tr>
                        <td rowspan="3" style="text-align:center; vertical-align:middle"><strong>TIPO DE ACTIVIDAD</strong></td>
                        <td colspan="3" rowspan="2" style="text-align:center; vertical-align:middle"><strong>TOTAL</strong></td>
                        <td colspan="28" align="center"><strong>NÚMERO DE ACCIONES POR RANGOS DE EDAD</strong></td>
                        <td rowspan="3" style="text-align:center; vertical-align:middle"><strong>GRUPAL</strong></td>
                        <td rowspan="3" style="text-align:center; vertical-align:middle"><strong>BENEFICIARIOS</strong></td>
                    </tr>
                    <tr>
                        <td colspan="2" align="center"><strong>15 - 19</strong></td>
                        <td colspan="2" align="center"><strong>20 - 24</strong></td>
                        <td colspan="2" align="center"><strong>25 - 29</strong></td>
                        <td colspan="2" align="center"><strong>30 - 34</strong></td>
                        <td colspan="2" align="center"><strong>35 - 39</strong></td>
                        <td colspan="2" align="center"><strong>40 - 44</strong></td>
                        <td colspan="2" align="center"><strong>45 - 49</strong></td>
                        <td colspan="2" align="center"><strong>50 - 54</strong></td>
                        <td colspan="2" align="center"><strong>55 - 59</strong></td>
                        <td colspan="2" align="center"><strong>60 - 64</strong></td>
                        <td colspan="2" align="center"><strong>65 - 69</strong></td>
                        <td colspan="2" align="center"><strong>70 - 74</strong></td>
                        <td colspan="2" align="center"><strong>75 - 79</strong></td>
                        <td colspan="2" align="center"><strong>80 y mas</strong></td>
                    </tr>
                    <tr>
                        <td align="center"><strong>Ambos sexos</strong></td>
                        <td align="center"><strong>Hombres (H)</strong></td>
                        <td align="center"><strong>Mujeres (M)</strong></td>
                        <td align="center"><strong>H</strong></td>
                        <td align="center"><strong>M</strong></td>
                        <td align="center"><strong>H</strong></td>
                        <td align="center"><strong>M</strong></td>
                        <td align="center"><strong>H</strong></td>
                        <td align="center"><strong>M</strong></td>
                        <td align="center"><strong>H</strong></td>
                        <td align="center"><strong>M</strong></td>
                        <td align="center"><strong>H</strong></td>
                        <td align="center"><strong>M</strong></td>
                        <td align="center"><strong>H</strong></td>
                        <td align="center"><strong>M</strong></td>
                        <td align="center"><strong>H</strong></td>
                        <td align="center"><strong>M</strong></td>
                        <td align="center"><strong>H</strong></td>
                        <td align="center"><strong>M</strong></td>
                        <td align="center"><strong>H</strong></td>
                        <td align="center"><strong>M</strong></td>
                        <td align="center"><strong>H</strong></td>
                        <td align="center"><strong>M</strong></td>
                        <td align="center"><strong>H</strong></td>
                        <td align="center"><strong>M</strong></td>
                        <td align="center"><strong>H</strong></td>
                        <td align="center"><strong>M</strong></td>
                        <td align="center"><strong>H</strong></td>
                        <td align="center"><strong>M</strong></td>
                        <td align="center"><strong>H</strong></td>
                        <td align="center"><strong>M</strong></td>
                    </tr>
                </thead>
                <tbody>
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
            				  ,sum(ifnull(b.Col32,0)) Col33
                          FROM (select c.* from 2020prestaciones c where c.codigo_prestacion in("01950747V", "01950748V", "01950749V", "01950750V")) a
                          left join 2020rems b on (a.id_prestacion=b.prestacion_id_prestacion)
                          AND (b.Mes in (' . $mes . ')) AND (b.establecimiento_id_establecimiento in (' . $estab . '))
                          group by a.codigo_prestacion, a.descripcion, a.id_prestacion
                          order by a.id_prestacion';
                    $registro = DB::connection('mysql_rem')->select($query);

                    foreach ($registro as $row) {
                    ?>
                        <tr>
                            <?php $search = array('ACTIVIDADES DE ACOMPAÑAMIENTO REMOTO', 'A PERSONAS MAYORES Y SUS FAMILIAS', 'POR PARTE DEL PROGRAMA MÁS ADULTOS MAYORES AUTOVALENTES'); ?>
                            <?php $fixed_string = str_replace($search, '', $row->descripcion); ?>
                            <td align='left'><?php echo strtoupper($fixed_string) ?></td>
                            <td align='right'><?php echo number_format($row->Col01, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col02, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col03, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col04, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col05, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col06, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col07, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col08, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col09, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col10, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col11, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col12, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col13, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col14, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col15, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col16, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col17, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col18, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col19, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col20, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col21, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col22, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col23, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col24, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col25, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col26, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col27, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col28, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col29, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col30, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col31, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col32, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col33, 0, ",", ".") ?></td>
                        <?php
                    }
                        ?>
                        </tr>
                </tbody>
            </table>
        </div>

        <br>

        <!-- SECCION K -->
        <div class="col-sm tab table-responsive" id="K">
            <table class="table table-hover table-bordered table-sm">
                <thead>
                        <td colspan="7" class="active"><strong>SECCIÓN K: CONTROLES DE SALUD ADOLESCENTES VIA REMOTA.</strong></td>
                    </tr>
                    <tr>
                        <td rowspan="2" style="text-align:center; vertical-align:middle"><strong>CONTROL DE SALUD INTEGRAL</strong></td>
                        <td colspan="3" style="text-align:center; vertical-align:middle"><strong>10 A 14 AÑOS</strong></td>
                        <td colspan="3" style="text-align:center; vertical-align:middle"><strong>15 A 19 AÑOS</strong></td>
                    </tr>
                    <tr>
                        <td align="center"><strong>Ambos sexos</strong></td>
                        <td align="center"><strong>Hombres (H)</strong></td>
                        <td align="center"><strong>Mujeres (M)</strong></td>
                        <td align="center"><strong>Ambos sexos</strong></td>
                        <td align="center"><strong>Hombres (H)</strong></td>
                        <td align="center"><strong>Mujeres (M)</strong></td>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $query = 'SELECT a.codigo_prestacion,a.descripcion
                              ,sum(ifnull(b.Col01,0)) Col01
                              ,sum(ifnull(b.Col02,0)) Col02
                              ,sum(ifnull(b.Col03,0)) Col03
                              ,sum(ifnull(b.Col04,0)) Col04
							  ,sum(ifnull(b.Col05,0)) Col05
                              ,sum(ifnull(b.Col06,0)) Col06
                          FROM (select c.* from 2020prestaciones c where c.codigo_prestacion in("01950751V", "01950752V")) a
                          left join 2020rems b on (a.id_prestacion=b.prestacion_id_prestacion)
                          AND (b.Mes in (' . $mes . ')) AND (b.establecimiento_id_establecimiento in (' . $estab . '))
                          group by a.codigo_prestacion, a.descripcion, a.id_prestacion
                          order by a.id_prestacion';
                    $registro = DB::connection('mysql_rem')->select($query);

                    foreach ($registro as $row) {
                    ?>
                        <tr>
                            <?php $search = array('CONTROLES DE SALUD', 'ADOLESCENTES VIA REMOTA'); ?>
                            <?php $fixed_string = str_replace($search, '', $row->descripcion); ?>
                            <td align='left'><?php echo strtoupper($fixed_string) ?></td>
                            <td align='right'><?php echo number_format($row->Col01, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col02, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col03, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col04, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col05, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col06, 0, ",", ".") ?></td>
                        <?php
                    }
                        ?>
                        </tr>
                </tbody>
            </table>
        </div>

        <br>

        <!-- SECCION L -->
        <div class="col-sm tab table-responsive" id="L">
            <table class="table table-hover table-bordered table-sm">
                <thead>
                    <tr>
                        <td colspan="36" class="active"><strong>SECCION L: ACCIONES REMOTAS DE MEDICINAS COMPLEMENTARIAS Y PRACTICAS DE BIENESTAR EN SALUD.</strong></td>
                    </tr>
                    <tr>
                        <td rowspan="2" style="text-align:center; vertical-align:middle"><strong>GRUPO OBJETIVO</strong></td>
                        <td rowspan="2" style="text-align:center; vertical-align:middle"><strong>TOTAL</strong></td>
                        <td colspan="34" align="center"><strong>NÚMERO DE ACCIONES TELEFÓNICAS Y DE SEGUIMIENTO POR RANGOS DE EDAD</strong></td>
                    </tr>
                    <tr>
                        <td colspan="2" align="center"><strong>0 - 4</strong></td>
                        <td colspan="2" align="center"><strong>5 - 9</strong></td>
                        <td colspan="2" align="center"><strong>10 - 14</strong></td>
                        <td colspan="2" align="center"><strong>15 - 19</strong></td>
                        <td colspan="2" align="center"><strong>20 - 24</strong></td>
                        <td colspan="2" align="center"><strong>25 - 29</strong></td>
                        <td colspan="2" align="center"><strong>30 - 34</strong></td>
                        <td colspan="2" align="center"><strong>35 - 39</strong></td>
                        <td colspan="2" align="center"><strong>40 - 44</strong></td>
                        <td colspan="2" align="center"><strong>45 - 49</strong></td>
                        <td colspan="2" align="center"><strong>50 - 54</strong></td>
                        <td colspan="2" align="center"><strong>55 - 59</strong></td>
                        <td colspan="2" align="center"><strong>60 - 64</strong></td>
                        <td colspan="2" align="center"><strong>65 - 69</strong></td>
                        <td colspan="2" align="center"><strong>70 - 74</strong></td>
                        <td colspan="2" align="center"><strong>75 - 79</strong></td>
                        <td colspan="2" align="center"><strong>80 y mas</strong></td>
                    </tr>
                </thead>
                <tbody>
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
                          FROM (select c.* from 2020prestaciones c where c.codigo_prestacion in("01950753V", "01950754V", "01950755V")) a
                          left join 2020rems b on (a.id_prestacion=b.prestacion_id_prestacion)
                          AND (b.Mes in (' . $mes . ')) AND (b.establecimiento_id_establecimiento in (' . $estab . '))
                          group by a.codigo_prestacion, a.descripcion, a.id_prestacion
                          order by a.id_prestacion';
                    $registro = DB::connection('mysql_rem')->select($query);

                    $i = 0;

                    foreach ($registro as $row) {
                    ?>
                        <tr>
                            <?php $search = array('ACCIONES REMOTAS', 'DE MEDICINAS COMPLEMENTARIAS', 'Y PRACTICAS DE BIENESTAR EN SALUD'); ?>
                            <?php $fixed_string = str_replace($search, '', $row->descripcion); ?>
                            <td align='left'><?php echo strtoupper($fixed_string) ?></td>
                            <td align='right'><?php echo number_format($row->Col01, 0, ",", ".") ?></td>
                            <td colspan="2" align='right'><?php echo number_format($row->Col02, 0, ",", ".") ?></td>
                            <td colspan="2" align='right'><?php echo number_format($row->Col03, 0, ",", ".") ?></td>
                            <td colspan="2" align='right'><?php echo number_format($row->Col04, 0, ",", ".") ?></td>
                            <td colspan="2" align='right'><?php echo number_format($row->Col05, 0, ",", ".") ?></td>
                            <td colspan="2" align='right'><?php echo number_format($row->Col06, 0, ",", ".") ?></td>
                            <td colspan="2" align='right'><?php echo number_format($row->Col07, 0, ",", ".") ?></td>
                            <td colspan="2" align='right'><?php echo number_format($row->Col08, 0, ",", ".") ?></td>
                            <td colspan="2" align='right'><?php echo number_format($row->Col09, 0, ",", ".") ?></td>
                            <td colspan="2" align='right'><?php echo number_format($row->Col10, 0, ",", ".") ?></td>
                            <td colspan="2" align='right'><?php echo number_format($row->Col11, 0, ",", ".") ?></td>
                            <td colspan="2" align='right'><?php echo number_format($row->Col12, 0, ",", ".") ?></td>
                            <td colspan="2" align='right'><?php echo number_format($row->Col13, 0, ",", ".") ?></td>
                            <td colspan="2" align='right'><?php echo number_format($row->Col14, 0, ",", ".") ?></td>
                            <td colspan="2" align='right'><?php echo number_format($row->Col15, 0, ",", ".") ?></td>
                            <td colspan="2" align='right'><?php echo number_format($row->Col16, 0, ",", ".") ?></td>
                            <td colspan="2" align='right'><?php echo number_format($row->Col17, 0, ",", ".") ?></td>
                            <td colspan="2" align='right'><?php echo number_format($row->Col18, 0, ",", ".") ?></td>
                        <?php
                        $i++;
                    }
                        ?>
                        </tr>
                </tbody>
            </table>
        </div>

        <br>

        <!-- SECCION M -->
        <div class="col-sm tab table-responsive" id="M">
            <table class="table table-hover table-bordered table-sm">
                <thead>
                        <td colspan="44" class="active"><strong>SECCIÓN M: ATENCIONES DE SEGUIMIENTO NUTRICIONALES VÍA REMOTA.</strong></td>
                    </tr>
                    <tr>
                        <td rowspan="3" style="text-align:center; vertical-align:middle"><strong>TIPO DE ATENCIÓN</strong></td>
                        <td colspan="3" rowspan="2" style="text-align:center; vertical-align:middle"><strong>TOTAL</strong></td>
                        <td colspan="36" align="center"><strong>POR EDAD (en años)</strong></td>
                        <td rowspan="3" style="text-align:center; vertical-align:middle"><strong>BENEFICIARIOS</strong></td>
                        <td rowspan="3" style="text-align:center; vertical-align:middle"><strong>PUEBLOS ORIGINARIOS</strong></td>
                        <td rowspan="3" style="text-align:center; vertical-align:middle"><strong>MIGRANTES</strong></td>
                        <td rowspan="3" style="text-align:center; vertical-align:middle"><strong>NIÑOS, NIÑAS, ADOLESCENTES Y JÓVENES RED SENAME</strong></td>
                    </tr>
                    <tr>
                        <td colspan="2" align="center"><strong>Menor de 1 mes</strong></td>
                        <td colspan="2" align="center"><strong>1 mes a 4 años</strong></td>
                        <td colspan="2" align="center"><strong>5 a 9 años</strong></td>
                        <td colspan="2" align="center"><strong>10 a 14 años</strong></td>
                        <td colspan="2" align="center"><strong>15 a 19 años</strong></td>
                        <td colspan="2" align="center"><strong>20 a 24 años</strong></td>
                        <td colspan="2" align="center"><strong>25 a 29 años</strong></td>
                        <td colspan="2" align="center"><strong>30 a 34 años</strong></td>
                        <td colspan="2" align="center"><strong>35 a 39 años</strong></td>
                        <td colspan="2" align="center"><strong>40 a 44 años</strong></td>
                        <td colspan="2" align="center"><strong>45 a 49 años</strong></td>
                        <td colspan="2" align="center"><strong>50 a 54 años</strong></td>
                        <td colspan="2" align="center"><strong>55 a 59 años</strong></td>
                        <td colspan="2" align="center"><strong>60 a 64 años</strong></td>
                        <td colspan="2" align="center"><strong>65 a 69 años</strong></td>
                        <td colspan="2" align="center"><strong>70 a 74 años</strong></td>
                        <td colspan="2" align="center"><strong>75 a 79 años</strong></td>
                        <td colspan="2" align="center"><strong>80 y mas</strong></td>
                    </tr>
                    <tr>
                        <td align="center"><strong>Ambos sexos</strong></td>
                        <td align="center"><strong>Hombres (H)</strong></td>
                        <td align="center"><strong>Mujeres (M)</strong></td>
                        <td align="center"><strong>H</strong></td>
                        <td align="center"><strong>M</strong></td>
                        <td align="center"><strong>H</strong></td>
                        <td align="center"><strong>M</strong></td>
                        <td align="center"><strong>H</strong></td>
                        <td align="center"><strong>M</strong></td>
                        <td align="center"><strong>H</strong></td>
                        <td align="center"><strong>M</strong></td>
                        <td align="center"><strong>H</strong></td>
                        <td align="center"><strong>M</strong></td>
                        <td align="center"><strong>H</strong></td>
                        <td align="center"><strong>M</strong></td>
                        <td align="center"><strong>H</strong></td>
                        <td align="center"><strong>M</strong></td>
                        <td align="center"><strong>H</strong></td>
                        <td align="center"><strong>M</strong></td>
                        <td align="center"><strong>H</strong></td>
                        <td align="center"><strong>M</strong></td>
                        <td align="center"><strong>H</strong></td>
                        <td align="center"><strong>M</strong></td>
                        <td align="center"><strong>H</strong></td>
                        <td align="center"><strong>M</strong></td>
                        <td align="center"><strong>H</strong></td>
                        <td align="center"><strong>M</strong></td>
                        <td align="center"><strong>H</strong></td>
                        <td align="center"><strong>M</strong></td>
                        <td align="center"><strong>H</strong></td>
                        <td align="center"><strong>M</strong></td>
                        <td align="center"><strong>H</strong></td>
                        <td align="center"><strong>M</strong></td>
                        <td align="center"><strong>H</strong></td>
                        <td align="center"><strong>M</strong></td>
                        <td align="center"><strong>H</strong></td>
                        <td align="center"><strong>M</strong></td>
                        <td align="center"><strong>H</strong></td>
                        <td align="center"><strong>M</strong></td>
                    </tr>
                </thead>
                <tbody>
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
            				  ,sum(ifnull(b.Col37,0)) Col37
            				  ,sum(ifnull(b.Col38,0)) Col38
            				  ,sum(ifnull(b.Col39,0)) Col39
            				  ,sum(ifnull(b.Col40,0)) Col40
            				  ,sum(ifnull(b.Col41,0)) Col41
            				  ,sum(ifnull(b.Col42,0)) Col42
            				  ,sum(ifnull(b.Col43,0)) Col43
                          FROM (select c.* from 2020prestaciones c where c.codigo_prestacion in("01950756V", "01950757V", "01950758V")) a
                          left join 2020rems b on (a.id_prestacion=b.prestacion_id_prestacion)
                          AND (b.Mes in (' . $mes . ')) AND (b.establecimiento_id_establecimiento in (' . $estab . '))
                          group by a.codigo_prestacion, a.descripcion, a.id_prestacion
                          order by a.id_prestacion';
                    $registro = DB::connection('mysql_rem')->select($query);

                    foreach ($registro as $row) {
                    ?>
                        <tr>
                            <?php $search = array('ATENCIONES DE SEGUIMIENTO', 'NUTRICIONALES VÍA REMOTA'); ?>
                            <?php $fixed_string = str_replace($search, '', $row->descripcion); ?>
                            <td align='left'><?php echo strtoupper($fixed_string) ?></td>
                            <td align='right'><?php echo number_format($row->Col01, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col02, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col03, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col04, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col05, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col06, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col07, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col08, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col09, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col10, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col11, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col12, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col13, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col14, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col15, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col16, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col17, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col18, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col19, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col20, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col21, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col22, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col23, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col24, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col25, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col26, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col27, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col28, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col29, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col30, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col31, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col32, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col33, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col34, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col35, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col36, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col37, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col38, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col39, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col40, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col41, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col42, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col43, 0, ",", ".") ?></td>
                        <?php
                    }
                        ?>
                        </tr>
                </tbody>
            </table>
        </div>

        <br>

        <!-- SECCION N -->
        <div class="col-sm tab table-responsive" id="N">
            <table class="table table-hover table-bordered table-sm">
                <thead>
                    <tr>
                        <td colspan="36" class="active"><strong>SECCIÓN N: SEGUIMIENTO DE SALUD INFANTIL EN CONTEXTO DE PANDEMIA.</strong></td>
                    </tr>
                    <tr>
                        <td rowspan="2" style="text-align:center; vertical-align:middle"><strong>PROFESIONALES</strong></td>
                        <td rowspan="2" style="text-align:center; vertical-align:middle"><strong>TOTAL ACCIONES</strong></td>
                        <td colspan="2" style="text-align:center; vertical-align:middle"><strong>ACCIONES</strong></td>
                        <td rowspan="2" style="text-align:center; vertical-align:middle"><strong>TOTAL USUARIOS</strong></td>
                        <td colspan="30" align="center"><strong>GRUPOS DE EDAD (en meses - años) </strong></td>
                        <td rowspan="2" style="text-align:center; vertical-align:middle"><strong>NANEAS</strong></td>
                    </tr>
                    <tr>
                        <td align="center"><strong>LLAMADAS TELEFÓNICAS</strong></td>
                        <td align="center"><strong>VIDEO LLAMADAS</strong></td>
                        <td colspan="2" align="center"><strong>1 mes</strong></td>
                        <td colspan="2" align="center"><strong>2 meses</strong></td>
                        <td colspan="2" align="center"><strong>3 meses</strong></td>
                        <td colspan="2" align="center"><strong>4 meses</strong></td>
                        <td colspan="2" align="center"><strong>5 meses</strong></td>
                        <td colspan="2" align="center"><strong>6 meses</strong></td>
                        <td colspan="2" align="center"><strong>7 a 11 meses</strong></td>
                        <td colspan="2" align="center"><strong>12 a 17 meses</strong></td>
                        <td colspan="2" align="center"><strong>18 a 23 meses</strong></td>
                        <td colspan="2" align="center"><strong>24 a 35 meses</strong></td>
                        <td colspan="2" align="center"><strong>36 a 41 meses</strong></td>
                        <td colspan="2" align="center"><strong>42 a 47 meses</strong></td>
                        <td colspan="2" align="center"><strong>48 a 59 meses</strong></td>
                        <td colspan="2" align="center"><strong>60 a 71 meses</strong></td>
                        <td colspan="2" align="center"><strong>6 a 9 años 11 meses</strong></td>
                    </tr>
                </thead>
                <tbody>
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
                          FROM (select c.* from 2020prestaciones c where c.codigo_prestacion in("01950759V", "01950760V", "01950761V", "01950762V")) a
                          left join 2020rems b on (a.id_prestacion=b.prestacion_id_prestacion)
                          AND (b.Mes in (' . $mes . ')) AND (b.establecimiento_id_establecimiento in (' . $estab . '))
                          group by a.codigo_prestacion, a.descripcion, a.id_prestacion
                          order by a.id_prestacion';
                    $registro = DB::connection('mysql_rem')->select($query);

                    foreach ($registro as $row) {
                    ?>
                        <tr>
                            <?php $search = array('SEGUIMIENTO DE SALUD INFANTIL', 'EN CONTEXTO DE PANDEMIA'); ?>
                            <?php $fixed_string = str_replace($search, '', $row->descripcion); ?>
                            <td align='left'><?php echo strtoupper($fixed_string) ?></td>
                            <td align='right'><?php echo number_format($row->Col01, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col02, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col03, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col04, 0, ",", ".") ?></td>
                            <td colspan="2" align='right'><?php echo number_format($row->Col05, 0, ",", ".") ?></td>
                            <td colspan="2" align='right'><?php echo number_format($row->Col06, 0, ",", ".") ?></td>
                            <td colspan="2" align='right'><?php echo number_format($row->Col07, 0, ",", ".") ?></td>
                            <td colspan="2" align='right'><?php echo number_format($row->Col08, 0, ",", ".") ?></td>
                            <td colspan="2" align='right'><?php echo number_format($row->Col09, 0, ",", ".") ?></td>
                            <td colspan="2" align='right'><?php echo number_format($row->Col10, 0, ",", ".") ?></td>
                            <td colspan="2" align='right'><?php echo number_format($row->Col11, 0, ",", ".") ?></td>
                            <td colspan="2" align='right'><?php echo number_format($row->Col12, 0, ",", ".") ?></td>
                            <td colspan="2" align='right'><?php echo number_format($row->Col13, 0, ",", ".") ?></td>
                            <td colspan="2" align='right'><?php echo number_format($row->Col14, 0, ",", ".") ?></td>
                            <td colspan="2" align='right'><?php echo number_format($row->Col15, 0, ",", ".") ?></td>
                            <td colspan="2" align='right'><?php echo number_format($row->Col16, 0, ",", ".") ?></td>
                            <td colspan="2" align='right'><?php echo number_format($row->Col17, 0, ",", ".") ?></td>
                            <td colspan="2" align='right'><?php echo number_format($row->Col18, 0, ",", ".") ?></td>
                            <td colspan="2" align='right'><?php echo number_format($row->Col19, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col20, 0, ",", ".") ?></td>
                        <?php
                    }
                        ?>
                        </tr>
                </tbody>
            </table>
        </div>

        <br>

        <!-- SECCION O -->
        <div class="col-sm tab table-responsive" id="O">
            <table class="table table-hover table-bordered table-sm">
                <thead>
                    <tr>
                        <td colspan="37" class="active"><strong>SECCIÓN O: ACCIONES REMOTAS DE SEGUIMIENTO EN RIESGO PSICOSOCIAL PARA GESTANTES, NIÑOS Y NIÑAS  DE 0 A 9 AÑOS EN CONTEXTO DE PANDEMIA.</strong></td>
                    </tr>
                    <tr>
                        <td rowspan="2" style="text-align:center; vertical-align:middle"><strong>PROFESIONALES</strong></td>
                        <td rowspan="2" style="text-align:center; vertical-align:middle"><strong>TOTAL ACCIONES</strong></td>
                        <td colspan="3" style="text-align:center; vertical-align:middle"><strong>ACCIONES</strong></td>
                        <td rowspan="2" style="text-align:center; vertical-align:middle"><strong>TOTAL USUARIOS</strong></td>
                        <td colspan="22" align="center"><strong>GRUPOS DE EDAD (en meses - años) </strong></td>
                        <td rowspan="2" style="text-align:center; vertical-align:middle"><strong>NANEAS</strong></td>
                    </tr>
                    <tr>
                        <td align="center"><strong>LLAMADAS TELEFÓNICAS</strong></td>
                        <td align="center"><strong>VIDEO LLAMADAS</strong></td>
                        <td align="center"><strong>MENSAJERÍA DE TEXTO</strong></td>
                        <td colspan="2" align="center"><strong>Gestantes</strong></td>
                        <td colspan="2" align="center"><strong>Menor de 7 meses</strong></td>
                        <td colspan="2" align="center"><strong>7 a 11 meses</strong></td>
                        <td colspan="2" align="center"><strong>12 a 17 meses</strong></td>
                        <td colspan="2" align="center"><strong>18 a 23 meses</strong></td>
                        <td colspan="2" align="center"><strong>24 a 35 meses</strong></td>
                        <td colspan="2" align="center"><strong>36 a 41 meses</strong></td>
                        <td colspan="2" align="center"><strong>42 a 47 meses</strong></td>
                        <td colspan="2" align="center"><strong>48 a 59 meses</strong></td>
                        <td colspan="2" align="center"><strong>60 a 71 meses</strong></td>
                        <td colspan="2" align="center"><strong>6 a 9 años 11 meses</strong></td>
                    </tr>
                </thead>
                <tbody>
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
                          FROM (select c.* from 2020prestaciones c where c.codigo_prestacion in("01950763V", "01950764V", "01950765V", "01950766V",
                                                                                                "01950767V", "01950768V", "01950769V")) a
                          left join 2020rems b on (a.id_prestacion=b.prestacion_id_prestacion)
                          AND (b.Mes in (' . $mes . ')) AND (b.establecimiento_id_establecimiento in (' . $estab . '))
                          group by a.codigo_prestacion, a.descripcion, a.id_prestacion
                          order by a.id_prestacion';
                    $registro = DB::connection('mysql_rem')->select($query);

                    foreach ($registro as $row) {
                    ?>
                        <tr>
                            <?php $search = array('ACCIONES REMOTAS DE SEGUIMIENTO', 'EN RIESGO PSICOSOCIAL PARA', 'GESTANTES, NIÑOS Y NIÑAS  DE 0 A 9 AÑOS', 'EN CONTEXTO DE PANDEMIA'); ?>
                            <?php $fixed_string = str_replace($search, '', $row->descripcion); ?>
                            <td align='left'><?php echo strtoupper($fixed_string) ?></td>
                            <td align='right'><?php echo number_format($row->Col01, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col02, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col03, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col04, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col05, 0, ",", ".") ?></td>
                            <td colspan="2" align='right'><?php echo number_format($row->Col06, 0, ",", ".") ?></td>
                            <td colspan="2" align='right'><?php echo number_format($row->Col07, 0, ",", ".") ?></td>
                            <td colspan="2" align='right'><?php echo number_format($row->Col08, 0, ",", ".") ?></td>
                            <td colspan="2" align='right'><?php echo number_format($row->Col09, 0, ",", ".") ?></td>
                            <td colspan="2" align='right'><?php echo number_format($row->Col10, 0, ",", ".") ?></td>
                            <td colspan="2" align='right'><?php echo number_format($row->Col11, 0, ",", ".") ?></td>
                            <td colspan="2" align='right'><?php echo number_format($row->Col12, 0, ",", ".") ?></td>
                            <td colspan="2" align='right'><?php echo number_format($row->Col13, 0, ",", ".") ?></td>
                            <td colspan="2" align='right'><?php echo number_format($row->Col14, 0, ",", ".") ?></td>
                            <td colspan="2" align='right'><?php echo number_format($row->Col15, 0, ",", ".") ?></td>
                            <td colspan="2" align='right'><?php echo number_format($row->Col16, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col17, 0, ",", ".") ?></td>
                        <?php
                    }
                        ?>
                        </tr>
                </tbody>
            </table>
        </div>

        <br>

        <!-- SECCION O -->
        <div class="col-sm tab table-responsive" id="P">
            <table class="table table-hover table-bordered table-sm">
                <thead>
                    <tr>
                        <td colspan="18" class="active"><strong>SECCION P: ATENCIONES REMOTAS EN MODALIDADES DE APOYO AL DESARROLLO INFANTIL (MADIS) EN APS.</strong></td>
                    </tr>
                    <tr>
                        <td rowspan="2" style="text-align:center; vertical-align:middle"><strong>ACTIVIDAD</strong></td>
                        <td rowspan="2" style="text-align:center; vertical-align:middle"><strong>TOTAL ACCIONES</strong></td>
                        <td colspan="3" style="text-align:center; vertical-align:middle"><strong>TIPO DE ACCION PARA GENERAR ATENCIONES</strong></td>
                        <td rowspan="2" style="text-align:center; vertical-align:middle"><strong>TOTAL USUARIOS</strong></td>
                        <td colspan="12" align="center"><strong>NÚMERO DE ACCIONES DE ATENCIONES POR GRUPOS DE EDAD (en meses - años)</strong></td>
                    </tr>
                    <tr>
                        <td align="center"><strong>TELEFÓNICO</strong></td>
                        <td align="center"><strong>VIDEO LLAMADA</strong></td>
                        <td align="center"><strong>MENSAJERÍA</strong></td>
                        <td colspan="2" align="center"><strong>Menor de 7 meses</strong></td>
                        <td colspan="2" align="center"><strong>7 a 11 meses</strong></td>
                        <td colspan="2" align="center"><strong>12 a 17 meses</strong></td>
                        <td colspan="2" align="center"><strong>18 a 23 meses</strong></td>
                        <td colspan="2" align="center"><strong>24 a 47 meses</strong></td>
                        <td colspan="2" align="center"><strong>48 a 59 meses</strong></td>
                    </tr>
                </thead>
                <tbody>
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
                          FROM (select c.* from 2020prestaciones c where c.codigo_prestacion in("01950770V", "01950771V", "01950772V", "01950773V")) a
                          left join 2020rems b on (a.id_prestacion=b.prestacion_id_prestacion)
                          AND (b.Mes in (' . $mes . ')) AND (b.establecimiento_id_establecimiento in (' . $estab . '))
                          group by a.codigo_prestacion, a.descripcion, a.id_prestacion
                          order by a.id_prestacion';
                    $registro = DB::connection('mysql_rem')->select($query);

                    foreach ($registro as $row) {
                    ?>
                        <tr>
                            <?php $search = array('ATENCIONES REMOTAS EN MODALIDADES DE APOYO', 'AL DESARROLLO INFANTIL (MADIS) EN APS'); ?>
                            <?php $fixed_string = str_replace($search, '', $row->descripcion); ?>
                            <td align='left'><?php echo strtoupper($fixed_string) ?></td>
                            <td align='right'><?php echo number_format($row->Col01, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col02, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col03, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col04, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col05, 0, ",", ".") ?></td>
                            <td colspan="2" align='right'><?php echo number_format($row->Col06, 0, ",", ".") ?></td>
                            <td colspan="2" align='right'><?php echo number_format($row->Col07, 0, ",", ".") ?></td>
                            <td colspan="2" align='right'><?php echo number_format($row->Col08, 0, ",", ".") ?></td>
                            <td colspan="2" align='right'><?php echo number_format($row->Col09, 0, ",", ".") ?></td>
                            <td colspan="2" align='right'><?php echo number_format($row->Col10, 0, ",", ".") ?></td>
                            <td colspan="2" align='right'><?php echo number_format($row->Col11, 0, ",", ".") ?></td>
                        <?php
                    }
                        ?>
                        </tr>
                </tbody>
            </table>
        </div>

        <br>

        <!-- SECCION Q -->
        <div class="col-sm tab table-responsive" id="Q">
            <table class="table table-hover table-bordered table-sm">
                <thead>
                    <tr>
                        <td colspan="14" class="active"><strong>SECCIÓN Q: EDUCACIÓN GRUPAL REMOTA SEGÚN ÁREAS TEMÁTICAS Y EDAD.</strong></td>
                    </tr>
                    <tr>
                        <td colspan="2" rowspan="2" style="text-align:center; vertical-align:middle"><strong>ÁREAS TEMÁTICAS DE PROMOCIÓN Y PREVENCIÓN</strong></td>
                        <td rowspan="2" style="text-align:center; vertical-align:middle"><strong>TOTAL ACCIONES</strong></td>
                        <td colspan="7" align="center"><strong>TIPO DE ACCION PARA GENERAR ATENCIONES</strong></td>
                        <td colspan="4" align="center"><strong>MADRE, PADRE O CUIDADOR DE:</strong></td>
                    </tr>
                    <tr>
                        <td align="center"><strong>TELEFÓNICO</strong></td>
                        <td align="center"><strong>VIDEO LLAMADA GRUPAL</strong></td>
                        <td align="center"><strong>SEMINARIO- RADIO</strong></td>
                        <td align="center"><strong>PLATAFORMA DIGITAL</strong></td>
                        <td align="center"><strong>TOTAL USUARIOS</strong></td>
                        <td align="center"><strong>GESTANTES</strong></td>
                        <td align="center"><strong>ACOMPAÑANTE DE GESTANTE</strong></td>
                        <td align="center"><strong>MENORES DE 12 MESES</strong></td>
                        <td align="center"><strong>NIÑOS DE 12 A 23 MESES</strong></td>
                        <td align="center"><strong>NIÑOS DE 2 A 5 AÑOS</strong></td>
                        <td align="center"><strong>NIÑOS DE 5 A 9 AÑOS</strong></td>
                    </tr>
                </thead>
                <tbody>
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
                          FROM (select c.* from 2020prestaciones c where c.codigo_prestacion in("01950774V", "01950775V", "01950776V", "01950777V")) a
                          left join 2020rems b on (a.id_prestacion=b.prestacion_id_prestacion)
                          AND (b.Mes in (' . $mes . ')) AND (b.establecimiento_id_establecimiento in (' . $estab . '))
                          group by a.codigo_prestacion, a.descripcion, a.id_prestacion
                          order by a.id_prestacion';
                    $registro = DB::connection('mysql_rem')->select($query);

                    $i = 0;

                    foreach ($registro as $row) {
                    ?>
                        <tr>
                            @if($i==0)<td rowspan="4" style="text-align:center; vertical-align:middle">HABILIDADES PARENTALES</td>@endif
                            <?php $search = array('EDUCACIÓN GRUPAL REMOTA', 'SEGÚN ÁREAS TEMÁTICAS Y EDAD', 'HABILIDADES PARENTALES'); ?>
                            <?php $fixed_string = str_replace($search, '', $row->descripcion); ?>
                            <td align='left'><?php echo strtoupper($fixed_string) ?></td>
                            <td align='right'><?php echo number_format($row->Col01, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col02, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col03, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col04, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col05, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col06, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col07, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col08, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col09, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col10, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col11, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col12, 0, ",", ".") ?></td>
                        <?php
                        $i++;
                    }
                        ?>
                        </tr>
                </tbody>
            </table>
        </div>

        <br>

        <!-- SECCION R -->
        <div class="col-sm tab table-responsive" id="R">
            <table class="table table-hover table-bordered table-sm">
                <thead>
                    <tr>
                        <td colspan="11" class="active"><strong>SECCIÓN R: DESPACHO DE RECETAS DE SALUD SEXUAL Y REPRODUCTIVA.</strong></td>
                    </tr>
                    <tr>
                        <td rowspan="3" style="text-align:center; vertical-align:middle"><strong>TIPO DE RECETA</strong></td>
                        <td colspan="4" style="text-align:center; vertical-align:middle"><strong>RECETAS DESPACHADAS</strong></td>
                        <td colspan="6" style="text-align:center; vertical-align:middle"><strong>GRUPOS DE EDAD</strong></td>
                    </tr>
                    <tr>
                        <td rowspan="2" align="center"><strong>Despacho total</strong></td>
                        <td rowspan="2" align="center"><strong>Despacho Extraordinario</strong></td>
                        <td rowspan="2" align="center"><strong>En Establecimientos de Salud</strong></td>
                        <td rowspan="2" align="center"><strong>En Domicilio</strong></td>
                        <td colspan="2" align="center"><strong>< 19 años</strong></td>
                        <td colspan="2" align="center"><strong>20 a 64 años</strong></td>
                        <td colspan="2" align="center"><strong>65 y más</strong></td>
                    </tr>
                    <tr>
                        <td align="center"><strong>Hombre</strong></td>
                        <td align="center"><strong>Mujer</strong></td>
                        <td align="center"><strong>Hombre</strong></td>
                        <td align="center"><strong>Mujer</strong></td>
                        <td align="center"><strong>Hombre</strong></td>
                        <td align="center"><strong>Mujer</strong></td>
                    </tr>
                </thead>
                <tbody>
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
                          FROM (select c.* from 2020prestaciones c where c.codigo_prestacion in("01950778V","01950779V","01950780V")) a
                          left join 2020rems b on (a.id_prestacion=b.prestacion_id_prestacion)
                          AND (b.Mes in (' . $mes . ')) AND (b.establecimiento_id_establecimiento in (' . $estab . '))
                          group by a.codigo_prestacion, a.descripcion, a.id_prestacion
                          order by a.id_prestacion';
                    $registro = DB::connection('mysql_rem')->select($query);

                    $i = 0;

                    $totalCol01 = 0;
                    $totalCol02 = 0;
                    $totalCol03 = 0;
                    $totalCol04 = 0;
                    $totalCol05 = 0;
                    $totalCol06 = 0;
                    $totalCol07 = 0;
                    $totalCol08 = 0;
                    $totalCol09 = 0;
                    $totalCol10 = 0;

                    foreach ($registro as $row) {
                        $totalCol01 = $totalCol01 + $row->Col01;
                        $totalCol02 = $totalCol02 + $row->Col02;
                        $totalCol03 = $totalCol03 + $row->Col03;
                        $totalCol04 = $totalCol04 + $row->Col04;
                        $totalCol05 = $totalCol05 + $row->Col05;
                        $totalCol06 = $totalCol06 + $row->Col06;
                        $totalCol07 = $totalCol07 + $row->Col07;
                        $totalCol08 = $totalCol08 + $row->Col08;
                        $totalCol09 = $totalCol09 + $row->Col09;
                        $totalCol10 = $totalCol10 + $row->Col10;
                    ?>
                        <tr>
                            <?php $search = array('DESPACHO DE RECETAS DE SALUD', 'SEXUAL Y REPRODUCTIVA'); ?>
                            <?php $fixed_string = str_replace($search, '', $row->descripcion); ?>
                            <td align='left'><?php echo strtoupper($fixed_string) ?></td>
                            <td align='right'><?php echo number_format($row->Col01, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col02, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col03, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col04, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col05, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col06, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col07, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col08, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col09, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col10, 0, ",", ".") ?></td>
                        <?php
                        $i++;
                    }
                        ?>
                        </tr>
                        <tr>
                            <td align='left'><strong>TOTAL</strong></td>
                            <td align='right'><strong><?php echo number_format($totalCol01, 0, ",", ".") ?></strong></td>
                            <td align='right'><strong><?php echo number_format($totalCol02, 0, ",", ".") ?></strong></td>
                            <td align='right'><strong><?php echo number_format($totalCol03, 0, ",", ".") ?></strong></td>
                            <td align='right'><strong><?php echo number_format($totalCol04, 0, ",", ".") ?></strong></td>
                            <td align='right'><strong><?php echo number_format($totalCol05, 0, ",", ".") ?></strong></td>
                            <td align='right'><strong><?php echo number_format($totalCol06, 0, ",", ".") ?></strong></td>
                            <td align='right'><strong><?php echo number_format($totalCol07, 0, ",", ".") ?></strong></td>
                            <td align='right'><strong><?php echo number_format($totalCol08, 0, ",", ".") ?></strong></td>
                            <td align='right'><strong><?php echo number_format($totalCol09, 0, ",", ".") ?></strong></td>
                            <td align='right'><strong><?php echo number_format($totalCol10, 0, ",", ".") ?></strong></td>
                        </tr>
                </tbody>
            </table>
        </div>

        <br>

        <!-- SECCION S -->
        <div class="col-sm tab table-responsive" id="S">
            <table class="table table-hover table-bordered table-sm">
                <thead>
                    <tr>
                        <td colspan="21" class="active"><strong>SECCIÓN S: ACTIVIDADES PROGRAMA ELIGE VIDA SANA POR LLAMADA TELEFÓNICA O REDES SOCIALES.</strong></td>
                    </tr>
                    <tr>
                        <td rowspan="2" style="text-align:center; vertical-align:middle"><strong>ACTIVIDAD</strong></td>
                        <td rowspan="2" style="text-align:center; vertical-align:middle"><strong>N° MENSAJES</strong></td>
                        <td rowspan="2" style="text-align:center; vertical-align:middle"><strong>N° PARTICIPANTES</strong></td>
                        <td colspan="2" style="text-align:center; vertical-align:middle"><strong>MADRE, PADRE O CUIDADOR DE</strong></td>
                        <td colspan="14" style="text-align:center; vertical-align:middle"><strong>N° PARTICIPANTES POR EDAD</strong></td>
                        <td rowspan="2" style="text-align:center; vertical-align:middle"><strong>GESTANTES</strong></td>
                        <td rowspan="2" style="text-align:center; vertical-align:middle"><strong>POST PARTO</strong></td>
                    </tr>
                    <tr>
                        <td align="center"><strong>Menores de 1 año</strong></td>
                        <td align="center"><strong>Niños 12 a 23 meses</strong></td>
                        <td align="center"><strong>menor de 2 años</strong></td>
                        <td align="center"><strong>2 a 4</strong></td>
                        <td align="center"><strong>5 a 9</strong></td>
                        <td align="center"><strong>10 a 14</strong></td>
                        <td align="center"><strong>15 a 19</strong></td>
                        <td align="center"><strong>20 a 24</strong></td>
                        <td align="center"><strong>25 a 29</strong></td>
                        <td align="center"><strong>30 a 34</strong></td>
                        <td align="center"><strong>35 a 39</strong></td>
                        <td align="center"><strong>40 a 44</strong></td>
                        <td align="center"><strong>45 a 49</strong></td>
                        <td align="center"><strong>50 a 54</strong></td>
                        <td align="center"><strong>55 a 59</strong></td>            
                        <td align="center"><strong>60 a 64</strong></td>            
                    </tr>
                </thead>
                <tbody>
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
                          FROM (select c.* from 2020prestaciones c where c.codigo_prestacion in("01950781V","01950782V","01950783V")) a
                          left join 2020rems b on (a.id_prestacion=b.prestacion_id_prestacion)
                          AND (b.Mes in (' . $mes . ')) AND (b.establecimiento_id_establecimiento in (' . $estab . '))
                          group by a.codigo_prestacion, a.descripcion, a.id_prestacion
                          order by a.id_prestacion';
                    $registro = DB::connection('mysql_rem')->select($query);

                    foreach ($registro as $row) {
                    ?>
                        <tr>
                            <?php $search = array('ACTIVIDADES PROGRAMA ELIGE VIDA SANA', 'POR LLAMADA TELEFÓNICA O REDES SOCIALES'); ?>
                            <?php $fixed_string = str_replace($search, '', $row->descripcion); ?>
                            <td align='left'><?php echo strtoupper($fixed_string) ?></td>
                            <td align='right'><?php echo number_format($row->Col01, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col02, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col03, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col04, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col05, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col06, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col07, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col08, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col09, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col10, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col11, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col12, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col13, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col14, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col15, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col16, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col17, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col18, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col19, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col20, 0, ",", ".") ?></td>
                        <?php
                    }
                        ?>
                        </tr>
                </tbody>
            </table>
        </div>

        <br>

        <!-- SECCION T -->
        <div class="col-sm tab table-responsive" id="T">
            <table class="table table-hover table-bordered table-sm">
                <thead>
                    <tr>
                        <td colspan="12" class="active"><strong>SECCIÓN T: ACTIVIDADES PROGRAMA ELIGE VIDA SANA POR LLAMADA TELEFÓNICA O REDES SOCIALES.</strong></td>
                    </tr>
                    <tr>
                        <td rowspan="2" style="text-align:center; vertical-align:middle"><strong>TALLER</strong></td>
                        <td rowspan="2" style="text-align:center; vertical-align:middle"><strong>N° ARCHIVOS MULTIMEDIA</strong></td>
                        <td colspan="2" style="text-align:center; vertical-align:middle"><strong>MADRE, PADRE O CUIDADOR DE</strong></td>
                        <td colspan="6" style="text-align:center; vertical-align:middle"><strong>N° ARCHIVOS MULTIMEDIA POR EDAD</strong></td>
                        <td rowspan="2" style="text-align:center; vertical-align:middle"><strong>GESTANTES</strong></td>
                        <td rowspan="2" style="text-align:center; vertical-align:middle"><strong>POST PARTO</strong></td>
                    </tr>
                    <tr>
                        <td align="center"><strong>Menores de 1 año</strong></td>
                        <td align="center"><strong>Niños 12 a 23 meses</strong></td>
                        <td align="center"><strong>menor de 2 años</strong></td>
                        <td align="center"><strong>2 a 4</strong></td>
                        <td align="center"><strong>5 a 9</strong></td>
                        <td align="center"><strong>10 a 14</strong></td>
                        <td align="center"><strong>15 a 19</strong></td>
                        <td align="center"><strong>20 a 64</strong></td>          
                    </tr>
                </thead>
                <tbody>
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
                          FROM (select c.* from 2020prestaciones c where c.codigo_prestacion in("01950784V","01950785V")) a
                          left join 2020rems b on (a.id_prestacion=b.prestacion_id_prestacion)
                          AND (b.Mes in (' . $mes . ')) AND (b.establecimiento_id_establecimiento in (' . $estab . '))
                          group by a.codigo_prestacion, a.descripcion, a.id_prestacion
                          order by a.id_prestacion';
                    $registro = DB::connection('mysql_rem')->select($query);

                    foreach ($registro as $row) {
                    ?>
                        <tr>
                            <?php $search = array('ACTIVIDADES PROGRAMA ELIGE VIDA SANA', 'POR LLAMADA TELEFÓNICA O REDES SOCIALES'); ?>
                            <?php $fixed_string = str_replace($search, '', $row->descripcion); ?>
                            <td align='left'><?php echo strtoupper($fixed_string) ?></td>
                            <td align='right'><?php echo number_format($row->Col01, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col02, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col03, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col04, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col05, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col06, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col07, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col08, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col09, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col10, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col11, 0, ",", ".") ?></td>
                        <?php
                    }
                        ?>
                        </tr>
                </tbody>
            </table>
        </div>

        <br>

        <!-- SECCION U.1 -->
        <div class="col-sm tab table-responsive" id="U1">
            <table class="table table-hover table-bordered table-sm">
                    <thead>
                        <td colspan="42" class="active"><strong>SECCIÓN U: REHABILITACIÓN Y TELESALUD EN NIVEL APS Y HOSPITALARIO.</strong></td>
                    </tr>
                    <thead>
                        <td colspan="42" class="active"><strong>SECCION U1: ACCIONES DE REHABILITACIÓN Y TELESALUD EN APS.</strong></td>
                    </tr>
                    <tr>
                        <td rowspan="3" style="text-align:center; vertical-align:middle"><strong>TIPO DE CONTROL</strong></td>
                        <td rowspan="3" style="text-align:center; vertical-align:middle"><strong>PROFESIONAL</strong></td>
                        <td colspan="3" rowspan="2" style="text-align:center; vertical-align:middle"><strong>TOTAL</strong></td>
                        <td colspan="28" align="center"><strong>NÚMERO DE ACCIONES POR RANGOS DE EDAD</strong></td>
                    </tr>
                    <tr>
                        <td colspan="2" align="center"><strong>15 - 19</strong></td>
                        <td colspan="2" align="center"><strong>20 - 24</strong></td>
                        <td colspan="2" align="center"><strong>25 - 29</strong></td>
                        <td colspan="2" align="center"><strong>30 - 34</strong></td>
                        <td colspan="2" align="center"><strong>35 - 39</strong></td>
                        <td colspan="2" align="center"><strong>40 - 44</strong></td>
                        <td colspan="2" align="center"><strong>45 - 49</strong></td>
                        <td colspan="2" align="center"><strong>50 - 54</strong></td>
                        <td colspan="2" align="center"><strong>55 - 59</strong></td>
                        <td colspan="2" align="center"><strong>60 - 64</strong></td>
                        <td colspan="2" align="center"><strong>65 - 69</strong></td>
                        <td colspan="2" align="center"><strong>70 - 74</strong></td>
                        <td colspan="2" align="center"><strong>75 - 79</strong></td>
                        <td colspan="2" align="center"><strong>80 y mas</strong></td>
                    </tr>
                    <tr>
                        <td align="center"><strong>Ambos sexos</strong></td>
                        <td align="center"><strong>Hombres (H)</strong></td>
                        <td align="center"><strong>Mujeres (M)</strong></td>
                        <td align="center"><strong>H</strong></td>
                        <td align="center"><strong>M</strong></td>
                        <td align="center"><strong>H</strong></td>
                        <td align="center"><strong>M</strong></td>
                        <td align="center"><strong>H</strong></td>
                        <td align="center"><strong>M</strong></td>
                        <td align="center"><strong>H</strong></td>
                        <td align="center"><strong>M</strong></td>
                        <td align="center"><strong>H</strong></td>
                        <td align="center"><strong>M</strong></td>
                        <td align="center"><strong>H</strong></td>
                        <td align="center"><strong>M</strong></td>
                        <td align="center"><strong>H</strong></td>
                        <td align="center"><strong>M</strong></td>
                        <td align="center"><strong>H</strong></td>
                        <td align="center"><strong>M</strong></td>
                        <td align="center"><strong>H</strong></td>
                        <td align="center"><strong>M</strong></td>
                        <td align="center"><strong>H</strong></td>
                        <td align="center"><strong>M</strong></td>
                        <td align="center"><strong>H</strong></td>
                        <td align="center"><strong>M</strong></td>
                        <td align="center"><strong>H</strong></td>
                        <td align="center"><strong>M</strong></td>
                        <td align="center"><strong>H</strong></td>
                        <td align="center"><strong>M</strong></td>
                        <td align="center"><strong>H</strong></td>
                        <td align="center"><strong>M</strong></td>
                    </tr>
                </thead>
                <tbody>
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
                          FROM (select c.* from 2020prestaciones c where c.codigo_prestacion in("01950786V", "01950787V", "01950788V", "01950789V", "01950790V",
                                                                                                "01950791V", "01950792V", "01950793V", "01950794V", "01950795V",
                                                                                                "01950796V", "01950797V" )) a
                          left join 2020rems b on (a.id_prestacion=b.prestacion_id_prestacion)
                          AND (b.Mes in (' . $mes . ')) AND (b.establecimiento_id_establecimiento in (' . $estab . '))
                          group by a.codigo_prestacion, a.descripcion, a.id_prestacion
                          order by a.id_prestacion';
                    $registro = DB::connection('mysql_rem')->select($query);

                    $i = 0;

                    foreach ($registro as $row) {
                    ?>
                        <tr>
                            @if($i==0)<td rowspan="4" style="text-align:center; vertical-align:middle"><?php echo strtoupper('Evaluación  intermedia remota') ?></td>@endif
                            @if($i==4)<td rowspan="4" style="text-align:center; vertical-align:middle"><?php echo strtoupper('Sesión de rehabilitación vía remota (telerehabilitación)') ?></td>@endif
                            @if($i==8)<td rowspan="4" style="text-align:center; vertical-align:middle"><?php echo strtoupper('Educación remota a usuario y/o cuidador') ?></td>@endif
                            <?php $search = array('ACCIONES DE REHABILITACIÓN Y TELESALUD EN APS', 'Evaluación  intermedia remota', 'Evaluación', 'sesion de', 'rehabilitaion', 'rerhabilitacion', 'sesión de rehabilitacion', 'rehabilitacion', 'via remota tele', 'via remota telerehabilitacion', 'educacion remota a usurario y/o cuidador'); ?>
                            <?php $fixed_string = str_replace($search, '', $row->descripcion); ?>
                            <td align='left'><?php echo strtoupper($fixed_string) ?></td>
                            <td align='right'><?php echo number_format($row->Col01, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col02, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col03, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col04, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col05, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col06, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col07, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col08, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col09, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col10, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col11, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col12, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col13, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col14, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col15, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col16, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col17, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col18, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col19, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col20, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col21, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col22, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col23, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col24, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col25, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col26, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col27, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col28, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col29, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col30, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col31, 0, ",", ".") ?></td>
                        <?php
                        $i++;
                    }
                        ?>
                        </tr>
                </tbody>
            </table>
        </div>

        <br>

        <!-- SECCION U.2 -->
        <div class="col-sm tab table-responsive" id="U2">
            <table class="table table-hover table-bordered table-sm">                  
                    <thead>
                        <td colspan="42" class="active"><strong>SECCION U2: ACCIONES DE REHABILITACIÓN Y TELESALUD EN HOSPITAL.</strong></td>
                    </tr>
                    <tr>
                        <td rowspan="3" style="text-align:center; vertical-align:middle"><strong>TIPO DE CONTROL</strong></td>
                        <td rowspan="3" style="text-align:center; vertical-align:middle"><strong>PROFESIONAL</strong></td>
                        <td colspan="3" rowspan="2" style="text-align:center; vertical-align:middle"><strong>TOTAL</strong></td>
                        <td colspan="28" align="center"><strong>NÚMERO DE ACCIONES POR RANGOS DE EDAD</strong></td>
                    </tr>
                    <tr>
                        <td colspan="2" align="center"><strong>15 - 19</strong></td>
                        <td colspan="2" align="center"><strong>20 - 24</strong></td>
                        <td colspan="2" align="center"><strong>25 - 29</strong></td>
                        <td colspan="2" align="center"><strong>30 - 34</strong></td>
                        <td colspan="2" align="center"><strong>35 - 39</strong></td>
                        <td colspan="2" align="center"><strong>40 - 44</strong></td>
                        <td colspan="2" align="center"><strong>45 - 49</strong></td>
                        <td colspan="2" align="center"><strong>50 - 54</strong></td>
                        <td colspan="2" align="center"><strong>55 - 59</strong></td>
                        <td colspan="2" align="center"><strong>60 - 64</strong></td>
                        <td colspan="2" align="center"><strong>65 - 69</strong></td>
                        <td colspan="2" align="center"><strong>70 - 74</strong></td>
                        <td colspan="2" align="center"><strong>75 - 79</strong></td>
                        <td colspan="2" align="center"><strong>80 y mas</strong></td>
                    </tr>
                    <tr>
                        <td align="center"><strong>Ambos sexos</strong></td>
                        <td align="center"><strong>Hombres (H)</strong></td>
                        <td align="center"><strong>Mujeres (M)</strong></td>
                        <td align="center"><strong>H</strong></td>
                        <td align="center"><strong>M</strong></td>
                        <td align="center"><strong>H</strong></td>
                        <td align="center"><strong>M</strong></td>
                        <td align="center"><strong>H</strong></td>
                        <td align="center"><strong>M</strong></td>
                        <td align="center"><strong>H</strong></td>
                        <td align="center"><strong>M</strong></td>
                        <td align="center"><strong>H</strong></td>
                        <td align="center"><strong>M</strong></td>
                        <td align="center"><strong>H</strong></td>
                        <td align="center"><strong>M</strong></td>
                        <td align="center"><strong>H</strong></td>
                        <td align="center"><strong>M</strong></td>
                        <td align="center"><strong>H</strong></td>
                        <td align="center"><strong>M</strong></td>
                        <td align="center"><strong>H</strong></td>
                        <td align="center"><strong>M</strong></td>
                        <td align="center"><strong>H</strong></td>
                        <td align="center"><strong>M</strong></td>
                        <td align="center"><strong>H</strong></td>
                        <td align="center"><strong>M</strong></td>
                        <td align="center"><strong>H</strong></td>
                        <td align="center"><strong>M</strong></td>
                        <td align="center"><strong>H</strong></td>
                        <td align="center"><strong>M</strong></td>
                        <td align="center"><strong>H</strong></td>
                        <td align="center"><strong>M</strong></td>
                    </tr>
                </thead>
                <tbody>
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
                          FROM (select c.* from 2020prestaciones c where c.codigo_prestacion in("01950798V", "01950799V", "01950800V", "01950801V", "01950802V",
                                                                                                "01950803V", "01950804V", "01950805V", "01950806V", "01950807V",
                                                                                                "01950808V", "01950809V" )) a
                          left join 2020rems b on (a.id_prestacion=b.prestacion_id_prestacion)
                          AND (b.Mes in (' . $mes . ')) AND (b.establecimiento_id_establecimiento in (' . $estab . '))
                          group by a.codigo_prestacion, a.descripcion, a.id_prestacion
                          order by a.id_prestacion';
                    $registro = DB::connection('mysql_rem')->select($query);

                    $i = 0;

                    foreach ($registro as $row) {
                    ?>
                        <tr>
                            @if($i==0)<td rowspan="4" style="text-align:center; vertical-align:middle"><?php echo strtoupper('Evaluación  intermedia remota') ?></td>@endif
                            @if($i==4)<td rowspan="4" style="text-align:center; vertical-align:middle"><?php echo strtoupper('Sesión de rehabilitación vía remota (telerehabilitación)') ?></td>@endif
                            @if($i==8)<td rowspan="4" style="text-align:center; vertical-align:middle"><?php echo strtoupper('Educación remota a usuario y/o cuidador') ?></td>@endif
                            <?php $search = array('ACCIONES DE REHABILITACIÓN Y TELESALUD EN APS', 'sesión de rehabilitacion', 'via remota tele', 'rehabilitacion ', 'ACCIONES DE REHABILITACIÓN Y TELESALUD EN HOSPITAL', 'Evaluación  intermedia remota', 'Evaluación', 'sesion de', 'rehabilitaion', 'rerhabilitacion', 'via remota telerehabilitacion', 'educacion remota a usurario y/o cuidador'); ?>
                            <?php $fixed_string = str_replace($search, '', $row->descripcion); ?>
                            <td align='left'><?php echo strtoupper($fixed_string . ($i==0 || $i==4 || $i==8 ? ' FISIATRA' : '')) ?></td>
                            <td align='right'><?php echo number_format($row->Col01, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col02, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col03, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col04, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col05, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col06, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col07, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col08, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col09, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col10, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col11, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col12, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col13, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col14, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col15, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col16, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col17, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col18, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col19, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col20, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col21, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col22, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col23, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col24, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col25, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col26, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col27, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col28, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col29, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col30, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col31, 0, ",", ".") ?></td>
                        <?php
                        $i++;
                    }
                        ?>
                        </tr>
                </tbody>
            </table>
        </div>

        <br>

        <!-- SECCION V -->
        <div class="col-sm tab table-responsive" id="V">
            <table class="table table-hover table-bordered table-sm">                  
                    <thead>
                        <td colspan="42" class="active"><strong>SECCIÓN V: REHABILITACIÓN DOMICILIARIA EN NIVEL HOSPITALARIO.</strong></td>
                    </tr>
                    <tr>
                        <td rowspan="3" style="text-align:center; vertical-align:middle"><strong>TIPO DE CONTROL</strong></td>
                        <td rowspan="3" style="text-align:center; vertical-align:middle"><strong>PROFESIONAL</strong></td>
                        <td colspan="3" rowspan="2" style="text-align:center; vertical-align:middle"><strong>TOTAL</strong></td>
                        <td colspan="28" align="center"><strong>NÚMERO DE ACCIONES POR RANGOS DE EDAD</strong></td>
                    </tr>
                    <tr>
                        <td colspan="2" align="center"><strong>15 - 19</strong></td>
                        <td colspan="2" align="center"><strong>20 - 24</strong></td>
                        <td colspan="2" align="center"><strong>25 - 29</strong></td>
                        <td colspan="2" align="center"><strong>30 - 34</strong></td>
                        <td colspan="2" align="center"><strong>35 - 39</strong></td>
                        <td colspan="2" align="center"><strong>40 - 44</strong></td>
                        <td colspan="2" align="center"><strong>45 - 49</strong></td>
                        <td colspan="2" align="center"><strong>50 - 54</strong></td>
                        <td colspan="2" align="center"><strong>55 - 59</strong></td>
                        <td colspan="2" align="center"><strong>60 - 64</strong></td>
                        <td colspan="2" align="center"><strong>65 - 69</strong></td>
                        <td colspan="2" align="center"><strong>70 - 74</strong></td>
                        <td colspan="2" align="center"><strong>75 - 79</strong></td>
                        <td colspan="2" align="center"><strong>80 y mas</strong></td>
                    </tr>
                    <tr>
                        <td align="center"><strong>Ambos sexos</strong></td>
                        <td align="center"><strong>Hombres (H)</strong></td>
                        <td align="center"><strong>Mujeres (M)</strong></td>
                        <td align="center"><strong>H</strong></td>
                        <td align="center"><strong>M</strong></td>
                        <td align="center"><strong>H</strong></td>
                        <td align="center"><strong>M</strong></td>
                        <td align="center"><strong>H</strong></td>
                        <td align="center"><strong>M</strong></td>
                        <td align="center"><strong>H</strong></td>
                        <td align="center"><strong>M</strong></td>
                        <td align="center"><strong>H</strong></td>
                        <td align="center"><strong>M</strong></td>
                        <td align="center"><strong>H</strong></td>
                        <td align="center"><strong>M</strong></td>
                        <td align="center"><strong>H</strong></td>
                        <td align="center"><strong>M</strong></td>
                        <td align="center"><strong>H</strong></td>
                        <td align="center"><strong>M</strong></td>
                        <td align="center"><strong>H</strong></td>
                        <td align="center"><strong>M</strong></td>
                        <td align="center"><strong>H</strong></td>
                        <td align="center"><strong>M</strong></td>
                        <td align="center"><strong>H</strong></td>
                        <td align="center"><strong>M</strong></td>
                        <td align="center"><strong>H</strong></td>
                        <td align="center"><strong>M</strong></td>
                        <td align="center"><strong>H</strong></td>
                        <td align="center"><strong>M</strong></td>
                        <td align="center"><strong>H</strong></td>
                        <td align="center"><strong>M</strong></td>
                    </tr>
                </thead>
                <tbody>
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
                          FROM (select c.* from 2020prestaciones c where c.codigo_prestacion in("01950810V", "01950811V", "01950812V", "01950813V")) a
                          left join 2020rems b on (a.id_prestacion=b.prestacion_id_prestacion)
                          AND (b.Mes in (' . $mes . ')) AND (b.establecimiento_id_establecimiento in (' . $estab . '))
                          group by a.codigo_prestacion, a.descripcion, a.id_prestacion
                          order by a.id_prestacion';
                    $registro = DB::connection('mysql_rem')->select($query);

                    $i = 0;

                    foreach ($registro as $row) {
                    ?>
                        <tr>
                            @if($i==0)<td rowspan="4" style="text-align:center; vertical-align:middle"><?php echo strtoupper('Rehabilitación domiciliaria') ?></td>@endif
                            <?php $search = array('REHABILITACIÓN DOMICILIARIA', 'EN NIVEL HOSPITALARIO', 'REHABILITACION DOMICILIARIA'); ?>
                            <?php $fixed_string = str_replace($search, '', $row->descripcion); ?>
                            <td align='left'><?php echo strtoupper($fixed_string) ?></td>
                            <td align='right'><?php echo number_format($row->Col01, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col02, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col03, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col04, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col05, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col06, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col07, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col08, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col09, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col10, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col11, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col12, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col13, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col14, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col15, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col16, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col17, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col18, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col19, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col20, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col21, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col22, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col23, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col24, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col25, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col26, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col27, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col28, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col29, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col30, 0, ",", ".") ?></td>
                            <td align='right'><?php echo number_format($row->Col31, 0, ",", ".") ?></td>
                        <?php
                        $i++;
                    }
                        ?>
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