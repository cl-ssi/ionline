@extends('layouts.app')

@section('title', 'Resumen Estadistico Mensual')

@section('content')

<?php

use Illuminate\Support\Facades\DB;

?>

@include('indicators.rem.partials.navP')

<h3>REM-P1. POBLACIÓN EN CONTROL PROGRAMA DE SALUD DE LA MUJER.</h3>

<br>

@include('indicators.rem.2019.serie_p.search')

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
                    <td colspan="16" class="active"><strong>ATENCIÓN PRIMARIA DE SALUD</strong></td>
                </tr>
                <tr>
                    <td colspan="16" class="active"><strong>SECCION A: POBLACIÓN EN CONTROL SEGÚN MÉTODO DE REGULACIÓN DE FERTILIDAD Y SALUD SEXUAL</strong></td>
                </tr>
                <tr>
                    <td colspan='2' rowspan='2' style="text-align:center; vertical-align:middle"><strong>METODOS</strong></td>
                    <td rowspan='2' style="text-align:center; vertical-align:middle"><strong>TOTAL</strong></td>
                    <td colspan='10' align='center'><strong>GRUPO DE EDAD (en años)</strong></td>
                    <td rowspan='2' style="text-align:center; vertical-align:middle"><strong>Pueblos Originarios</strong></td>
                    <td rowspan='2' style="text-align:center; vertical-align:middle"><strong>Población Migrantes</strong></td>
                    <td rowspan='2' style="text-align:center; vertical-align:middle"><strong>PV-VIH (personas viviendo con VIH)</strong></td>
                </tr>
                <tr>
                    <td align='center'><strong>Menor de 15 años</strong></td>
                    <td align='center'><strong>15 a 19 años</strong></td>
                    <td align='center'><strong>20 a 24 años</strong></td>
                    <td align='center'><strong>25 a 29 años</strong></td>
                    <td align='center'><strong>30 a 34 años</strong></td>
                    <td align='center'><strong>35 a 39 años</strong></td>
                    <td align='center'><strong>40 a 44 años</strong></td>
                    <td align='center'><strong>45 a 49 años</strong></td>
                    <td align='center'><strong>50 a 54 años</strong></td>
                    <td align='center'><strong>55 y más años</strong></td>
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
                          FROM (select c.* from 2019prestaciones c where c.codigo_prestacion in("P1010100","P1060124",
                                                                                                "P1010201","P1010202","P1010203","P1040508","P1040500","P1200190",
                                                                                                "P1010301","P1010302",
                                                                                                "P1200240","P1200250") AND c.serie = "P") a
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

                    $nombre_descripcion = $row->codigo_prestacion;
                    if ($nombre_descripcion == "P1010100"){
                        $nombre_descripcion = "D.I.U. T con Cobre";
                    }
    						    if ($nombre_descripcion == "P1060124"){
                        $nombre_descripcion = "D.I.U con Levonorgestrel";
                    }
                    if ($nombre_descripcion == "P1010201"){
                        $nombre_descripcion = "ORAL COMBINADO";
                    }
                    if ($nombre_descripcion == "P1010202"){
                        $nombre_descripcion = "ORAL PROGESTÁGENO";
                    }
                    if ($nombre_descripcion == "P1010203"){
                        $nombre_descripcion = "INYECTABLE COMBINADO";
                    }
                    if ($nombre_descripcion == "P1040508"){
                        $nombre_descripcion = "INYECTABLE PROGESTÁGENO";
                    }
                    if ($nombre_descripcion == "P1040500"){
                        $nombre_descripcion = "IMPLANTE ETONOGESTREL (3 AÑOS)";
                    }
                    if ($nombre_descripcion == "P1200190"){
                        $nombre_descripcion = "IMPLANTE ETONOGESTREL (5 AÑOS)";
                    }

                    if ($nombre_descripcion == "P1010301"){
                        $nombre_descripcion = "MUJER";
                    }
                    if ($nombre_descripcion == "P1010302"){
                        $nombre_descripcion = "HOMBRES";
                    }

                    if ($nombre_descripcion == "P1200200"){
                        $nombre_descripcion = "MUJER";
                    }
                    if ($nombre_descripcion == "P1200210"){
                        $nombre_descripcion = "HOMBRES";
                    }

                    if ($nombre_descripcion == "P1200220"){
                        $nombre_descripcion = "MUJER";
                    }
                    if ($nombre_descripcion == "P1200230"){
                        $nombre_descripcion = "HOMBRES";
                    }

                    if ($nombre_descripcion == "P1200240"){
                        $nombre_descripcion = "MUJER";
                    }
                    if ($nombre_descripcion == "P1200250"){
                        $nombre_descripcion = "HOMBRES";
                    }

                    ?>
                <tr>
                    <?php
                    if($i>=0 && $i<=1){?>
                    <td align='left' colspan='2' nowrap="nowrap"><?php echo $nombre_descripcion; ?></td>
                    <?php
                    }
                    if($i==2){?>
                    <td rowspan="6" style="text-align:center; vertical-align:middle">HORMONAL</td>
                    <?php
                    }
                    if($i>=2 && $i<=7){?>
                    <td align='left' nowrap="nowrap"><?php echo $nombre_descripcion; ?></td>
                    <?php
                    }
                    if($i==8){?>
                    <td rowspan="2" style="text-align:center; vertical-align:middle">SÓLO PRESERVATIVO MAC</td>
                    <?php
                    }
                    if($i>=8 && $i<=9){?>
                    <td align='left' nowrap="nowrap"><?php echo $nombre_descripcion; ?></td>
                    <?php
                    }
                    if($i==10){?>
                    <td rowspan="2" style="text-align:center; vertical-align:middle">PRESERVATIVO/PRACTICA SEXUAL SEGURA</td>
                    <?php
                    }
                    if($i>=10 && $i<=11){?>
                    <td align='left' nowrap="nowrap"><?php echo $nombre_descripcion; ?></td>
                    <?php
                    }
                    ?>
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
                    <?php
                    $i++;
                }
                ?>
                </tr>
                <tr>
                    <td colspan="2" align='center'><strong>TOTAL</strong></td>
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
                          FROM (select c.* from 2019prestaciones c where c.codigo_prestacion in("P1060010","P1060020","P1200260","P1060090","P1200270",
                                                                                                "P1200200","P1200210",
                                                                                                "P1200220","P1200230",
                                                                                                "P1200350") AND c.serie = "P") a
                          left join 2019rems b on (a.id_prestacion=b.prestacion_id_prestacion)
                          AND (b.Mes in ('.$mes.')) AND (b.establecimiento_id_establecimiento in ('.$estab.'))
                          group by  a.codigo_prestacion,a.descripcion,a.id_prestacion
                          order by a.id_prestacion';
                $registro = DB::connection('mysql_rem')->select($query);

                $i=0;

                foreach($registro as $row ){

                    $nombre_descripcion = $row->codigo_prestacion;
                    if ($nombre_descripcion == "P1060010"){
                        $nombre_descripcion = "Mujeres en control que padecen enfermedad cardiovascular (DM-HTA)";
                    }
                    if ($nombre_descripcion == "P1060020"){
                        $nombre_descripcion = "Mujeres con Retiro de Implante Anticipado en el semestre (antes de los 3 años)";
                    }
                    if ($nombre_descripcion == "P1200260"){
                        $nombre_descripcion = "Mujeres con Retiro de Implante Anticipado en el semestre (antes de los 5 años)";
                    }
                    if ($nombre_descripcion == "P1060090"){
                        $nombre_descripcion = "Método de Regulación de Fertilidad más Preservativo";
                    }
                    if ($nombre_descripcion == "P1200270"){
                        $nombre_descripcion = "Gestantes que reciben preservativo";
                    }

                    if ($nombre_descripcion == "P1200200"){
                        $nombre_descripcion = "Mujer";
                    }
                    if ($nombre_descripcion == "P1200210"){
                        $nombre_descripcion = "Hombres";
                    }

                    if ($nombre_descripcion == "P1200220"){
                        $nombre_descripcion = "Mujer";
                    }
                    if ($nombre_descripcion == "P1200230"){
                        $nombre_descripcion = "Hombres";
                    }

                    if ($nombre_descripcion == "P1200350"){
                        $nombre_descripcion = "CONDON FEMENINO";
                    }
                    ?>
                <tr>
                    <?php
                    if($i>=0 && $i<=4){?>
                    <td align='left' colspan='2' nowrap="nowrap"><?php echo $nombre_descripcion; ?></td>
                    <?php
                    }
                    if($i==5){?>
                    <td rowspan='2' style="text-align:center; vertical-align:middle">PRESERVATIVO/PRACTICA SEXUAL SEGURA</td>
                    <?php
                    }
                    if($i>=5 && $i<=6){?>
                    <td align='left' nowrap="nowrap"><?php echo $nombre_descripcion; ?></td>
                    <?php
                    }
                    if($i==7){?>
                    <td rowspan='2' style="text-align:center; vertical-align:middle">LUBRICANTES</td>
                    <?php
                    }
                    if($i>=7 && $i<=8){?>
                    <td align='left' nowrap="nowrap"><?php echo $nombre_descripcion; ?></td>
                    <?php
                    }
                    if($i>=9){?>
                    <td colspan="2" align='left' nowrap="nowrap"><?php echo $nombre_descripcion; ?></td>
                    <?php
                    }
                    ?>
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
                    <?php
                    $i++;
                }
                ?>
                </tr>
            </tbody>
        </table>
    </div>

    <br>

    <div class="container">
    <!-- SECCION B -->
    <div class="col-sm tab table-responsive" id="B">
        <table class="table table-hover table-bordered table-sm">
            <thead>
                <tr>
                    <td colspan="6" class="active"><strong>SECCION B: POBLACIÓN EN CONTROL SEGÚN MÉTODO DE REGULACIÓN DE FERTILIDAD Y SALUD SEXUAL</strong></td>
                </tr>
                <tr>
                    <td align='center'><strong>GRUPOS DE EDAD</strong></td>
                    <td align='center'><strong>TOTAL DE GESTANTES EN CONTROL</strong></td>
                    <td align='center'><strong>EN RIESGO PSICOSOCIAL </strong></td>
                    <td align='center'><strong>QUE PRESENTAN VIOLENCIA DE GÉNERO</strong></td>
                    <td align='center'><strong>GESTANTES QUE PRESENTAN ARO</strong></td>
                    <td align='center'><strong>POBLACION INMIGRANTES</strong></td>
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
                          FROM (select c.* from 2019prestaciones c where c.codigo_prestacion in("P1020100","P1020200","P1040501","P1060100","P1060101","P1060102","P1060103","P1060104",
                                                                                                "P1060105") AND c.serie = "P") a
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

                foreach($registro as $row ){
                    $totalCol01=$totalCol01+$row->Col01;
                    $totalCol02=$totalCol02+$row->Col02;
                    $totalCol03=$totalCol03+$row->Col03;
                    $totalCol04=$totalCol04+$row->Col04;
                    $totalCol05=$totalCol05+$row->Col05;

                    $nombre_descripcion = $row->codigo_prestacion;
                    if ($nombre_descripcion == "P1020100"){
                        $nombre_descripcion = "Menos de 15 años";
                    }
                    if ($nombre_descripcion == "P1020200"){
                        $nombre_descripcion = "15 a 19 años";
                    }
                    if ($nombre_descripcion == "P1040501"){
                        $nombre_descripcion = "20 a 24 años";
                    }
                    if ($nombre_descripcion == "P1060100"){
                        $nombre_descripcion = "25 a 29 años";
                    }
                    if ($nombre_descripcion == "P1060101"){
                        $nombre_descripcion = "30 a 34 años";
                    }
                    if ($nombre_descripcion == "P1060102"){
                        $nombre_descripcion = "35 a 39 años";
                    }
                    if ($nombre_descripcion == "P1060103"){
                        $nombre_descripcion = "40 a 44 años";
                    }
                    if ($nombre_descripcion == "P1060104"){
                        $nombre_descripcion = "45 a 49 años";
                    }
                    if ($nombre_descripcion == "P1060105"){
                        $nombre_descripcion = "50 a 54 años";
                    }
                    ?>
                <tr>
                    <td align='left' nowrap="nowrap"><?php echo $nombre_descripcion; ?></td>
                    <td align='right'><?php echo number_format($row->Col01,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col02,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col03,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col04,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col05,0,",",".")?></td>
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
                </tr>
            </tbody>
        </table>
    </div>

    <br>

    <!-- SECCION C -->
    <div class="col-sm tab table-responsive" id="C">
        <table class="table table-hover table-bordered table-sm">
            <thead>
                <tr>
                    <td colspan="3" class="active"><strong>SECCION C: GESTANTES EN RIESGO PSICOSOCIAL CON VISITA DOMICILIARIA INTEGRAL REALIZADA EN EL SEMESTRE.</strong></td>
                </tr>
                <tr>
                    <td align='center'><strong>N° VDI</strong></td>
                    <td align='center'><strong>N° Gestantes con VDI</strong></td>
                    <td align='center'><strong>TOTAL de Visitas</strong></td>
                </tr>
            </thead>
            <tbody>
                <?php
                $query = 'SELECT a.codigo_prestacion,a.descripcion
                              ,sum(ifnull(b.Col01,0)) Col01
                              ,sum(ifnull(b.Col02,0)) Col02
                          FROM (select c.* from 2019prestaciones c where c.codigo_prestacion in("P1040502","P1040503","P1040504","P1040505") AND c.serie = "P") a
                          left join 2019rems b on (a.id_prestacion=b.prestacion_id_prestacion)
                          AND (b.Mes in ('.$mes.')) AND (b.establecimiento_id_establecimiento in ('.$estab.'))
                          group by  a.codigo_prestacion,a.descripcion,a.id_prestacion
                          order by a.id_prestacion';
                $registro = DB::connection('mysql_rem')->select($query);

                $i=0;

                $totalCol01=0;
    						$totalCol02=0;

                foreach($registro as $row ){
                    $totalCol01=$totalCol01+$row->Col01;
                    $totalCol02=$totalCol02+$row->Col02;

                    $nombre_descripcion = $row->codigo_prestacion;
                    if ($nombre_descripcion == "P1040502"){
                        $nombre_descripcion = "1 Visita";
                    }
                    if ($nombre_descripcion == "P1040503"){
                        $nombre_descripcion = "2 Visitas";
                    }
                    if ($nombre_descripcion == "P1040504"){
                        $nombre_descripcion = "3 Visitas";
                    }
                    if ($nombre_descripcion == "P1040505"){
                        $nombre_descripcion = "4 y más visitas";
                    }
                    ?>
                <tr>
                    <td align='left' nowrap="nowrap"><?php echo $nombre_descripcion; ?></td>
                    <td align='right'><?php echo number_format($row->Col01,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col02,0,",",".")?></td>
                    <?php
                    $i++;
                }
                ?>
                </tr>
                <tr>
                    <td align='center'><strong>TOTAL</strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol01,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol02,0,",",".") ?></strong></td>
                </tr>
            </tbody>
        </table>
    </div>

    <br>

    <!-- SECCION D -->
    <div class="col-sm tab table-responsive" id="D">
        <table class="table table-hover table-bordered table-sm">
            <thead>
                <tr>
                    <td colspan="12" class="active"><strong>SECCION D: GESTANTES Y MUJERES DE 8° MES POST-PARTO EN CONTROL, SEGÚN ESTADO NUTRICIONAL.</strong></td>
                </tr>
                <tr>
                    <td rowspan='2' style="text-align:center; vertical-align:middle"><strong>POBLACION</strong></td>
                    <td rowspan='2' style="text-align:center; vertical-align:middle"><strong>ESTADO NUTRICIONAL</strong></td>
                    <td rowspan='2' style="text-align:center; vertical-align:middle"><strong>TOTAL</strong></td>
                    <td colspan='9' align='center'><strong>GRUPOS DE EDAD (en años)</strong></td>
                </tr>
                <tr>
                    <td align='center'><strong>Menos 15 años</strong></td>
                    <td align='center'><strong>15 a 19 años</strong></td>
                    <td align='center'><strong>20 a 24 años</strong></td>
                    <td align='center'><strong>25 a 29 años</strong></td>
                    <td align='center'><strong>30 a 34 años</strong></td>
                    <td align='center'><strong>35 a 39 años</strong></td>
                    <td align='center'><strong>40 a 44 años</strong></td>
                    <td align='center'><strong>45 a 49 años</strong></td>
                    <td align='center'><strong>50 a 54 años</strong></td>
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
                          FROM (select c.* from 2019prestaciones c where c.codigo_prestacion in("P1030101","P1030102","P1030103","P1030104") AND c.serie = "P") a
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

                    $nombre_descripcion = $row->codigo_prestacion;
                    if ($nombre_descripcion == "P1030101"){
                        $nombre_descripcion = "OBESA";
                    }
                    if ($nombre_descripcion == "P1030102"){
                        $nombre_descripcion = "SOBREPESO";
                    }
                    if ($nombre_descripcion == "P1030103"){
                        $nombre_descripcion = "NORMAL";
                    }
                    if ($nombre_descripcion == "P1030104"){
                        $nombre_descripcion = "BAJO PESO";
                    }
                    ?>
                <tr>
                    <?php
                    if($i==0){?>
                      <td rowspan="5" style="text-align:center; vertical-align:middle">GESTANTES EN CONTROL (Información a la fecha de corte)</td>
                    <?php
                    }
                    ?>
                    <td align='left' nowrap="nowrap"><?php echo $nombre_descripcion; ?></td>
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
                          FROM (select c.* from 2019prestaciones c where c.codigo_prestacion in("P1030201","P1030202","P1030203","P1030204") AND c.serie = "P") a
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

                    $nombre_descripcion = $row->codigo_prestacion;
                    if ($nombre_descripcion == "P1030201"){
                        $nombre_descripcion = "OBESA";
                    }
                    if ($nombre_descripcion == "P1030202"){
                        $nombre_descripcion = "SOBREPESO";
                    }
                    if ($nombre_descripcion == "P1030203"){
                        $nombre_descripcion = "NORMAL";
                    }
                    if ($nombre_descripcion == "P1030204"){
                        $nombre_descripcion = "BAJO PESO";
                    }
                    ?>
                <tr>
                    <?php
                    if($i==0){?>
                      <td rowspan="5" style="text-align:center; vertical-align:middle">CONTROL AL 8º MES POST-PARTO</td>
                    <?php
                    }
                    ?>
                    <td align='left' nowrap="nowrap"><?php echo $nombre_descripcion; ?></td>
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
                </tr>
            </tbody>
        </table>
    </div>

    <br>

    <!-- SECCION E -->
    <div class="col-sm tab table-responsive" id="E">
        <table class="table table-hover table-bordered table-sm">
            <thead>
                <tr>
                    <td colspan="2" class="active"><strong>SECCION E: MUJERES Y GESTANTES EN CONTROL CON CONSULTA NUTRICIONAL.</strong></td>
                </tr>
                <tr>
                    <td align='center'><strong>MUJERES</strong></td>
                    <td align='center'><strong>TOTAL</strong></td>
                </tr>
            </thead>
            <tbody>
                <?php
                $query = 'SELECT a.codigo_prestacion,a.descripcion
                              ,sum(ifnull(b.Col01,0)) Col01
                          FROM (select c.* from 2019prestaciones c where c.codigo_prestacion in("P1050100","P1050101","P1050102","P1050103","P1050104") AND c.serie = "P") a
                          left join 2019rems b on (a.id_prestacion=b.prestacion_id_prestacion)
                          AND (b.Mes in ('.$mes.')) AND (b.establecimiento_id_establecimiento in ('.$estab.'))
                          group by  a.codigo_prestacion,a.descripcion,a.id_prestacion
                          order by a.id_prestacion';
                $registro = DB::connection('mysql_rem')->select($query);

                $i=0;

                foreach($registro as $row ){
                    $nombre_descripcion = $row->codigo_prestacion;
                    if ($nombre_descripcion == "P1050100"){
                        $nombre_descripcion = "Gestantes con malnutrición por déficit (bajo peso)";
                    }
                    if ($nombre_descripcion == "P1050101"){
                        $nombre_descripcion = "Gestantes con malnutrición por exceso - Obesa";
                    }
                    if ($nombre_descripcion == "P1050102"){
                        $nombre_descripcion = "Gestantes con malnutrición por exceso - Sobrepeso";
                    }
                    if ($nombre_descripcion == "P1050103"){
                        $nombre_descripcion = "En 3º mes post parto";
                    }
                    if ($nombre_descripcion == "P1050104"){
                        $nombre_descripcion = "En 6º mes post parto";
                    }
                    ?>
                <tr>
                    <td align='left' nowrap="nowrap"><?php echo $nombre_descripcion; ?></td>
                    <td align='right'><?php echo number_format($row->Col01,0,",",".")?></td>
                    <?php
                    $i++;
                }
                ?>
                </tr>
            </tbody>
        </table>
    </div>

    <br>

    <!-- SECCION F -->
    <div class="col-sm tab table-responsive" id="F">
        <table class="table table-hover table-bordered table-sm">
            <thead>
                <tr>
                    <td colspan="2" class="active"><strong>SECCION F: MUJERES EN CONTROL DE CLIMATERIO.</strong></td>
                </tr>
                <tr>
                    <td align='center'><strong>Población</strong></td>
                    <td align='center'><strong>45 a 64 años</strong></td>
                </tr>
            </thead>
            <tbody>
                <?php
                $query = 'SELECT a.codigo_prestacion,a.descripcion
                              ,sum(ifnull(b.Col01,0)) Col01
                          FROM (select c.* from 2019prestaciones c where c.codigo_prestacion in("P1030301","P1060040","P1060050","P1060060","P1200340") AND c.serie = "P") a
                          left join 2019rems b on (a.id_prestacion=b.prestacion_id_prestacion)
                          AND (b.Mes in ('.$mes.')) AND (b.establecimiento_id_establecimiento in ('.$estab.'))
                          group by  a.codigo_prestacion,a.descripcion,a.id_prestacion
                          order by a.id_prestacion';
                $registro = DB::connection('mysql_rem')->select($query);

                $i=0;

                foreach($registro as $row ){
                    $nombre_descripcion = $row->codigo_prestacion;
                    if ($nombre_descripcion == "P1030301"){
                        $nombre_descripcion = "Población en Control";
                    }
                    if ($nombre_descripcion == "P1060040"){
                        $nombre_descripcion = "Mujeres con pauta aplicada MRS*";
                    }
                    if ($nombre_descripcion == "P1060050"){
                        $nombre_descripcion = "Mujeres con puntaje elevado de MRS*";
                    }
                    if ($nombre_descripcion == "P1060060"){
                        $nombre_descripcion = "Mujeres con aplicación de terapia hormonal de reemplazo según MRS*";
                    }
                    if ($nombre_descripcion == "P1200340"){
                        $nombre_descripcion = "Talleres educativos";
                    }
                    ?>
                <tr>
                    <td align='left' nowrap="nowrap"><?php echo $nombre_descripcion; ?></td>
                    <td align='right'><?php echo number_format($row->Col01,0,",",".")?></td>
                    <?php
                    $i++;
                }
                ?>
                </tr>
                <tr>
                    <td colspan="2" align='left'>* MRS: Menopause Rating Scale</td>
                </tr>
            </tbody>
        </table>
    </div>

    <br>

    <!-- SECCION F.1 -->
    <div class="col-sm tab table-responsive" id="F.1">
        <table class="table table-hover table-bordered table-sm">
            <thead>
                <tr>
                    <td colspan="9" class="active"><strong>SECCION F.1: POBLACIÓN EN CONTROL CLIMATERIO SEGÚN TIPO TERAPIA REEMPLAZO HORMONAL.</strong></td>
                </tr>
                <tr>
                    <td rowspan='2' style="text-align:center; vertical-align:middle"><strong>MÉTODOS</strong></td>
                    <td rowspan='2' style="text-align:center; vertical-align:middle"><strong>TOTAL</strong></td>
                    <td colspan='5' align='center'><strong>GRUPOS DE EDAD (en años)</strong></td>
                    <td rowspan='2' style="text-align:center; vertical-align:middle"><strong>Pueblos Originarios</strong></td>
                    <td rowspan='2' style="text-align:center; vertical-align:middle"><strong>Población Migrantes</strong></td>
                </tr>
                <tr>
                    <td align='center'><strong>Menor de 45 años</strong></td>
                    <td align='center'><strong>45 a 49 años</strong></td>
                    <td align='center'><strong>50 a 54 años</strong></td>
                    <td align='center'><strong>55 a 60 años</strong></td>
                    <td align='center'><strong>60 a 64 años</strong></td>
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
                          FROM (select c.* from 2019prestaciones c where c.codigo_prestacion in("P1200280","P1200290","P1200300","P1200310","P1200320","P1200330") AND c.serie = "P") a
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

                foreach($registro as $row ){
                    $totalCol01=$totalCol01+$row->Col01;
                    $totalCol02=$totalCol02+$row->Col02;
                    $totalCol03=$totalCol03+$row->Col03;
                    $totalCol04=$totalCol04+$row->Col04;
                    $totalCol05=$totalCol05+$row->Col05;
                    $totalCol06=$totalCol06+$row->Col06;
                    $totalCol07=$totalCol07+$row->Col07;
                    $totalCol08=$totalCol08+$row->Col08;

                    $nombre_descripcion = $row->codigo_prestacion;
                    if ($nombre_descripcion == "P1200280"){
                        $nombre_descripcion = "Estradiol Micronizado 1mg";
                    }
                    if ($nombre_descripcion == "P1200290"){
                        $nombre_descripcion = "Estradiol Gel	";
                    }
                    if ($nombre_descripcion == "P1200300"){
                        $nombre_descripcion = "Progesterona Micronizada 100mg";
                    }
                    if ($nombre_descripcion == "P1200310"){
                        $nombre_descripcion = "Progesterona Micronizada 200mg";
                    }
                    if ($nombre_descripcion == "P1200320"){
                        $nombre_descripcion = "Nomegestrol 5mg comp.";
                    }
                    if ($nombre_descripcion == "P1200330"){
                        $nombre_descripcion = "Tibolona 2,5mg comp.";
                    }
                    ?>
                <tr>
                    <td align='left' nowrap="nowrap"><?php echo $nombre_descripcion; ?></td>
                    <td align='right'><?php echo number_format($row->Col01,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col02,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col03,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col04,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col05,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col06,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col07,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col08,0,",",".")?></td>
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
                    <td colspan="5" class="active"><strong>SECCION G: GESTANTES EN CONTROL CON ECOGRAFÍA POR TRIMESTRE DE GESTACION (EN EL SEMESTRE).</strong></td>
                </tr>
                <tr>
                    <td align='center'><strong>Población</strong></td>
                    <td align='center'><strong>Primer trimestre</strong></td>
                    <td align='center'><strong>Segundo trimestre</strong></td>
                    <td align='center'><strong>Tercer trimestre</strong></td>
                    <td align='center'><strong>Total de Gestantes con Ecografías del extrasistema</strong></td>
                </tr>


            </thead>
            <tbody>
                <?php
                $query = 'SELECT a.codigo_prestacion,a.descripcion
                              ,sum(ifnull(b.Col01,0)) Col01
                              ,sum(ifnull(b.Col02,0)) Col02
                              ,sum(ifnull(b.Col03,0)) Col03
                              ,sum(ifnull(b.Col04,0)) Col04
                          FROM (select c.* from 2019prestaciones c where c.codigo_prestacion in("P1060106","P1060107","P1060108","P1060109","P1060110","P1060111","P1060112","P1060113",
                                                                                                "P1060114") AND c.serie = "P") a
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

                foreach($registro as $row ){
                    $totalCol01=$totalCol01+$row->Col01;
                    $totalCol02=$totalCol02+$row->Col02;
                    $totalCol03=$totalCol03+$row->Col03;
                    $totalCol04=$totalCol04+$row->Col04;

                    $nombre_descripcion = $row->codigo_prestacion;
                    if ($nombre_descripcion == "P1060106"){
                        $nombre_descripcion = "Menor de 15";
                    }
                    if ($nombre_descripcion == "P1060107"){
                        $nombre_descripcion = "15 - 19";
                    }
                    if ($nombre_descripcion == "P1060108"){
                        $nombre_descripcion = "20 - 24";
                    }
                    if ($nombre_descripcion == "P1060109"){
                        $nombre_descripcion = "25 - 29";
                    }
                    if ($nombre_descripcion == "P1060110"){
                        $nombre_descripcion = "30 - 34";
                    }
                    if ($nombre_descripcion == "P1060111"){
                        $nombre_descripcion = "35 - 39";
                    }
                    if ($nombre_descripcion == "P1060112"){
                        $nombre_descripcion = "40 - 44";
                    }
                    if ($nombre_descripcion == "P1060113"){
                        $nombre_descripcion = "45 - 49";
                    }
                    if ($nombre_descripcion == "P1060114"){
                        $nombre_descripcion = "50 - 54";
                    }


                    ?>
                <tr>
                    <td align='left' nowrap="nowrap"><?php echo $nombre_descripcion; ?></td>
                    <td align='right'><?php echo number_format($row->Col01,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col02,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col03,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col04,0,",",".")?></td>
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
                    <td colspan="5" class="active"><strong>SECCION H: GESTANTES EN CONTROL DE ENFERMEDADES TRANSMISIBLES (HEPATITIS B, CHAGAS).</strong></td>
                </tr>
                <tr>
                    <td rowspan="2"style="text-align:center; vertical-align:middle"><strong>Población</strong></td>
                    <td colspan="2" align='center'><strong>HEPATITIS B</strong></td>
                    <td colspan="2" align='center'><strong>CHAGAS</strong></td>
                </tr>
                <tr>
                    <td align='center'><strong>Solicitados</strong></td>
                    <td align='center'><strong>Informados</strong></td>
                    <td align='center'><strong>Solicitados</strong></td>
                    <td align='center'><strong>Informados</strong></td>
                </tr>
            </thead>
            <tbody>
                <?php
                $query = 'SELECT a.codigo_prestacion,a.descripcion
                              ,sum(ifnull(b.Col01,0)) Col01
                              ,sum(ifnull(b.Col02,0)) Col02
                              ,sum(ifnull(b.Col03,0)) Col03
                              ,sum(ifnull(b.Col04,0)) Col04
                          FROM (select c.* from 2019prestaciones c where c.codigo_prestacion in("P1200100","P1200110","P1200120","P1200130","P1200140","P1200150","P1200160","P1200170",
                                                                                                "P1200180") AND c.serie = "P") a
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

                foreach($registro as $row ){
                    $totalCol01=$totalCol01+$row->Col01;
                    $totalCol02=$totalCol02+$row->Col02;
                    $totalCol03=$totalCol03+$row->Col03;
                    $totalCol04=$totalCol04+$row->Col04;

                    $nombre_descripcion = $row->codigo_prestacion;
                    if ($nombre_descripcion == "P1200100"){
                        $nombre_descripcion = "Menor de 15";
                    }
                    if ($nombre_descripcion == "P1200110"){
                        $nombre_descripcion = "15 - 19";
                    }
                    if ($nombre_descripcion == "P1200120"){
                        $nombre_descripcion = "20 - 24";
                    }
                    if ($nombre_descripcion == "P1200130"){
                        $nombre_descripcion = "25 - 29";
                    }
                    if ($nombre_descripcion == "P1200140"){
                        $nombre_descripcion = "30 - 34";
                    }
                    if ($nombre_descripcion == "P1200150"){
                        $nombre_descripcion = "35 - 39";
                    }
                    if ($nombre_descripcion == "P1200160"){
                        $nombre_descripcion = "40 - 44";
                    }
                    if ($nombre_descripcion == "P1200170"){
                        $nombre_descripcion = "45 - 49";
                    }
                    if ($nombre_descripcion == "P1200180"){
                        $nombre_descripcion = "50 - 54";
                    }
                    ?>
                <tr>
                    <td align='left' nowrap="nowrap"><?php echo $nombre_descripcion; ?></td>
                    <td align='right'><?php echo number_format($row->Col01,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col02,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col03,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col04,0,",",".")?></td>
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
                    <td colspan="2" class="active"><strong>NIVEL SECUNDARIO.</strong></td>
                </tr>
                <tr>
                    <td colspan="2" class="active"><strong>SECCIÓN I: POBLACIÓN EN CONTROL POR PATOLOGÍAS DE ALTO RIESGO OBSTÉTRICO.</strong></td>
                </tr>
                <tr>
                    <td align='center'><strong>PATOLOGÍA</strong></td>
                    <td align='center'><strong>TOTAL</strong></td>
                </tr>
            </thead>
            <tbody>
                <?php
                $query = 'SELECT a.codigo_prestacion,a.descripcion
                              ,sum(ifnull(b.Col01,0)) Col01
                          FROM (select c.* from 2019prestaciones c where c.codigo_prestacion in("P1030303","P1060070","P1030304","P1030401","P1040506","P1040507","P1060115","P1060116",
                                                                                                "P1030403","P1060080","P1060117","P1060118","P1060119","P1060120","P1060121","P1060122",
                                                                                                "P1060123","P1030404") AND c.serie = "P") a
                          left join 2019rems b on (a.id_prestacion=b.prestacion_id_prestacion)
                          AND (b.Mes in ('.$mes.')) AND (b.establecimiento_id_establecimiento in ('.$estab.'))
                          group by  a.codigo_prestacion,a.descripcion,a.id_prestacion
                          order by a.id_prestacion';
                $registro = DB::connection('mysql_rem')->select($query);

                $i=0;

                $totalCol01=0;

                foreach($registro as $row ){
                    $totalCol01=$totalCol01+$row->Col01;

                    $nombre_descripcion = $row->codigo_prestacion;
                    if ($nombre_descripcion == "P1030303"){
                        $nombre_descripcion = "Preeclampsia (PE)";
                    }
                    if ($nombre_descripcion == "P1060070"){
                        $nombre_descripcion = "Sindrome Hipertensivo del Embarazo (SHE)";
                    }
                    if ($nombre_descripcion == "P1030304"){
                        $nombre_descripcion = "Factores de riesgo y condicionantes de Parto Prematuro";
                    }
                    if ($nombre_descripcion == "P1030401"){
                        $nombre_descripcion = "Retardo Crecimiento Intrauterino (RCIU)";
                    }
                    if ($nombre_descripcion == "P1040506"){
                        $nombre_descripcion = "SÍFILIS";
                    }
                    if ($nombre_descripcion == "P1040507"){
                        $nombre_descripcion = "VIH";
                    }
                    if ($nombre_descripcion == "P1060115"){
                        $nombre_descripcion = "Diabetes Pre Gestacional";
                    }
                    if ($nombre_descripcion == "P1060116"){
                        $nombre_descripcion = "Diabetes Gestacional";
                    }
                    if ($nombre_descripcion == "P1030403"){
                        $nombre_descripcion = "Cesárea anterior";
                    }
                    if ($nombre_descripcion == "P1060080"){
                        $nombre_descripcion = "Malformación Congénita";
                    }
                    if ($nombre_descripcion == "P1060117"){
                        $nombre_descripcion = "Anemia";
                    }
                    if ($nombre_descripcion == "P1060118"){
                        $nombre_descripcion = "Cardiopatías";
                    }
                    if ($nombre_descripcion == "P1060119"){
                        $nombre_descripcion = "Pielonefritis";
                    }
                    if ($nombre_descripcion == "P1060120"){
                        $nombre_descripcion = "Rh(-) sensibilizada";
                    }
                    if ($nombre_descripcion == "P1060121"){
                        $nombre_descripcion = "Placenta previa";
                    }
                    if ($nombre_descripcion == "P1060122"){
                        $nombre_descripcion = "Chagas";
                    }
                    if ($nombre_descripcion == "P1060123"){
                        $nombre_descripcion = "Colestasia Intrahépatica de Embarazo";
                    }
                    if ($nombre_descripcion == "P1030404"){
                        $nombre_descripcion = "Otras patologías del embarazo";
                    }
                    ?>
                <tr>
                    <td align='left' nowrap="nowrap"><?php echo $nombre_descripcion; ?></td>
                    <td align='right'><?php echo number_format($row->Col01,0,",",".")?></td>
                    <?php
                    $i++;
                }
                ?>
                </tr>
                <tr>
                    <td align='center'><strong>TOTAL</strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol01,0,",",".") ?></strong></td>
                </tr>
            </tbody>
        </table>
    </div>
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
