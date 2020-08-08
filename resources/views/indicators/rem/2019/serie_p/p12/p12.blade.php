@extends('layouts.app')

@section('title', 'Resumen Estadistico Mensual')

@section('content')

<?php

use Illuminate\Support\Facades\DB;

?>

@include('indicators.rem.partials.navP')

<h3>REM-P12. PERSONAS CON PAP – MAMOGRAFIA - EXAMEN FISICO DE MAMA VIGENTES Y PRODUCCION DE PAP (SEMESTRAL).</h3>

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

    <div class="container">
    <!-- SECCION A -->
    <div class="col-sm tab table-responsive" id="A">
        <table class="table table-hover table-bordered table-sm">
            <thead>
                <tr>
                    <td colspan="3" class="active"><strong>SECCION A: PROGRAMA DE CANCER DE CUELLO UTERINO: POBLACIÓN CON PAP VIGENTE.</strong></td>
                </tr>
                <tr>
                    <td align='center'><strong>GRUPOS DE EDAD (en años)</strong></td>
                    <td align='center'><strong>MUJERES con PAP Vigente en los ultimos 3 años</strong></td>
                    <td align='center'><strong>"TRANS MASCULINO con PAP Vigente en los ultimos 3 años</strong></td>
                </tr>
            </thead>
            <tbody>
                <?php
                $query = 'SELECT a.codigo_prestacion,a.descripcion
                              ,sum(ifnull(b.Col01,0)) Col01
                              ,sum(ifnull(b.Col02,0)) Col02
                          FROM (select c.* from 2019prestaciones c where c.codigo_prestacion in("P1207150","P1206010","P1206020","P1206030","P1206040","P1206050","P1206060","P1206070",
                                                                                                "P1206080","P1207160","P1230001","P1230002","P1230003") AND c.serie = "P") a
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
                    if ($nombre_descripcion == "P1207150"){
                        $nombre_descripcion = "Menor de 25 años";
                    }
                    if ($nombre_descripcion == "P1206010"){
                        $nombre_descripcion = "25 a 29 años";
                    }
                    if ($nombre_descripcion == "P1206020"){
                        $nombre_descripcion = "30 a 34 años";
                    }
                    if ($nombre_descripcion == "P1206030"){
                        $nombre_descripcion = "35 a 39 años";
                    }
                    if ($nombre_descripcion == "P1206040"){
                        $nombre_descripcion = "40 a 44 años";
                    }
                    if ($nombre_descripcion == "P1206050"){
                        $nombre_descripcion = "45 a 49 años";
                    }
                    if ($nombre_descripcion == "P1206060"){
                        $nombre_descripcion = "50 a 54 años";
                    }
                    if ($nombre_descripcion == "P1206070"){
                        $nombre_descripcion = "55 a 59 años";
                    }
                    if ($nombre_descripcion == "P1206080"){
                        $nombre_descripcion = "60 a 64 años";
                    }
                    if ($nombre_descripcion == "P1207160"){
                        $nombre_descripcion = "65 A 69 años";
                    }
                    if ($nombre_descripcion == "P1230001"){
                        $nombre_descripcion = "70 a 74 años";
                    }
                    if ($nombre_descripcion == "P1230002"){
                        $nombre_descripcion = "75 a 79 años";
                    }
                    if ($nombre_descripcion == "P1230003"){
                        $nombre_descripcion = "80 y más años";
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
                    <td align='left'><strong>TOTAL</strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol01,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol02,0,",",".") ?></strong></td>
                </tr>
                <tr>
                    <td colspan="3" align='left'>(*) FUENTE DE INFORMACIÓN: CITOEXPERT O REVICAN</td>
                </tr>
            </tbody>
        </table>
    </div>
    </div>

    <br>

    <!-- SECCION B.1 -->
    <div class="col-sm tab table-responsive" id="B1">
        <table class="table table-hover table-bordered table-sm">
            <thead>
                <tr>
                    <td colspan="12" class="active"><strong>SECCIÓN B.1- PROGRAMA DE CANCER DE CUELLO UTERINO: PAP REALIZADOS E INFORMADOS SEGÚN RESULTADOS Y GRUPOS DE EDAD <br>(Examen realizados en la red pública)</strong></td>
                </tr>
                <tr>
                    <td rowspan='3' align='center' style="text-align:center; vertical-align:middle"><strong>GRUPOS DE EDAD (en años)</strong></td>
                    <td colspan='11' align='center'><strong>PAP INFORMADOS SEGÚN RESULTADO</strong></td>
                </tr>
                <tr>
                    <td rowspan='2' style="text-align:center; vertical-align:middle"><strong>TOTAL</strong></td>
                    <td rowspan='2' style="text-align:center; vertical-align:middle"><strong>NORMALES</strong></td>
                    <td colspan='2' align='center'><strong>INADECUADOS Y ATIPICOS</strong></td>
                    <td colspan='6' align='center'><strong>POSITIVOS</strong></td>
                    <td rowspan='2' style="text-align:center; vertical-align:middle"><strong>TOTAL PAP INFORMADOS EN TRANS MASCULINO SEGÚN EDAD</strong></td>
                </tr>
                <tr>
                    <td align='center'><strong>INADECUADOS</strong></td>
                    <td align='center'><strong>ATIPICOS</strong></td>
                    <td align='center'><strong>HPV</strong></td>
                    <td align='center'><strong>NIE I</strong></td>
                    <td align='center'><strong>NIE II</strong></td>
                    <td align='center'><strong>NIE III</strong></td>
                    <td align='center'><strong>Ca. Inv. (Epidermoide)</strong></td>
                    <td align='center'><strong>Ca. Inv. (Adenocarcinoma)</strong></td>
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
                          FROM (select c.* from 2019prestaciones c where c.codigo_prestacion in("P1207170","P1207010","P1207020","P1208020","P1208030","P1208040","P1208050","P1208060",
                                                                                                "P1208070","P1208080","P1208090","P1208100","P1230004") AND c.serie = "P") a
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

                foreach($registro as $row ){
                    $totalCol01=$totalCol01+$row->Col01;
                    $totalCol02=$totalCol02+$row->Col02;

                    $nombre_descripcion = $row->codigo_prestacion;
                    if ($nombre_descripcion == "P1207170"){
                        $nombre_descripcion = "Menor de 25 años";
                    }
                    if ($nombre_descripcion == "P1207010"){
                        $nombre_descripcion = "25 a 29 años";
                    }
                    if ($nombre_descripcion == "P1207020"){
                        $nombre_descripcion = "30 a 34 años";
                    }
                    if ($nombre_descripcion == "P1208020"){
                        $nombre_descripcion = "35 a 39 años";
                    }
                    if ($nombre_descripcion == "P1208030"){
                        $nombre_descripcion = "40 a 44 años";
                    }
                    if ($nombre_descripcion == "P1208040"){
                        $nombre_descripcion = "45 a 49 años";
                    }
                    if ($nombre_descripcion == "P1208050"){
                        $nombre_descripcion = "50 a 54 años";
                    }
                    if ($nombre_descripcion == "P1208060"){
                        $nombre_descripcion = "55 a 59 años";
                    }
                    if ($nombre_descripcion == "P1208070"){
                        $nombre_descripcion = "60 a 64 años";
                    }
                    if ($nombre_descripcion == "P1208080"){
                        $nombre_descripcion = "65 A 69 años";
                    }
                    if ($nombre_descripcion == "P1208090"){
                        $nombre_descripcion = "70 a 74 años";
                    }
                    if ($nombre_descripcion == "P1208100"){
                        $nombre_descripcion = "75 a 79 años";
                    }
                    if ($nombre_descripcion == "P1230004"){
                        $nombre_descripcion = "80 y más años";
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
                    <td align='right'><?php echo number_format($row->Col09,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col10,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col11,0,",",".")?></td>
                    <?php
                    $i++;
                }
                ?>
                </tr>
                <tr>
                    <td align='left'><strong>TOTAL</strong></td>
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
                </tr>
                <tr>
                    <td colspan="12" align='left'>(*) FUENTE DE INFORMACIÓN: CITOEXPERT O REVICAN</td>
                </tr>
            </tbody>
        </table>
    </div>

    <br>

    <!-- SECCION B.2 -->
    <div class="col-sm tab table-responsive" id="B2">
        <table class="table table-hover table-bordered table-sm">
            <thead>
                <tr>
                    <td colspan="12" class="active"><strong>SECCIÓN B.2- PROGRAMA DE CANCER DE CUELLO UTERINO: PAP REALIZADOS E INFORMADOS SEGÚN RESULTADOS Y GRUPOS DE EDAD <br>(Examen realizados en extrasistema).</strong></td>
                </tr>
                <tr>
                    <td rowspan='3' align='center' style="text-align:center; vertical-align:middle"><strong>GRUPOS DE EDAD (en años)</strong></td>
                    <td colspan='11' align='center'><strong>PAP INFORMADOS SEGÚN RESULTADO</strong></td>
                </tr>
                <tr>
                    <td rowspan='2' style="text-align:center; vertical-align:middle"><strong>TOTAL</strong></td>
                    <td rowspan='2' style="text-align:center; vertical-align:middle"><strong>NORMALES</strong></td>
                    <td colspan='2' align='center'><strong>INADECUADOS Y ATIPICOS</strong></td>
                    <td colspan='6' align='center'><strong>POSITIVOS</strong></td>
                    <td rowspan='2' style="text-align:center; vertical-align:middle"><strong>TOTAL PAP INFORMADOS EN TRANS MASCULINO SEGÚN EDAD</strong></td>
                </tr>
                <tr>
                    <td align='center'><strong>INADECUADOS</strong></td>
                    <td align='center'><strong>ATIPICOS</strong></td>
                    <td align='center'><strong>HPV</strong></td>
                    <td align='center'><strong>NIE I</strong></td>
                    <td align='center'><strong>NIE II</strong></td>
                    <td align='center'><strong>NIE III</strong></td>
                    <td align='center'><strong>Ca. Inv. (Epidermoide)</strong></td>
                    <td align='center'><strong>Ca. Inv. (Adenocarcinoma)</strong></td>
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
                          FROM (select c.* from 2019prestaciones c where c.codigo_prestacion in("P1220091","P1220092","P1220093","P1220094","P1220095","P1220096","P1220097","P1220098",
                                                                                                "P1220099","P1220100","P1220101","P1220102","P1230005") AND c.serie = "P") a
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

                foreach($registro as $row ){
                    $totalCol01=$totalCol01+$row->Col01;
                    $totalCol02=$totalCol02+$row->Col02;

                    $nombre_descripcion = $row->codigo_prestacion;
                    if ($nombre_descripcion == "P1220091"){
                        $nombre_descripcion = "Menor de 25 años";
                    }
                    if ($nombre_descripcion == "P1220092"){
                        $nombre_descripcion = "25 a 29 años";
                    }
                    if ($nombre_descripcion == "P1220093"){
                        $nombre_descripcion = "30 a 34 años";
                    }
                    if ($nombre_descripcion == "P1220094"){
                        $nombre_descripcion = "35 a 39 años";
                    }
                    if ($nombre_descripcion == "P1220095"){
                        $nombre_descripcion = "40 a 44 años";
                    }
                    if ($nombre_descripcion == "P1220096"){
                        $nombre_descripcion = "45 a 49 años";
                    }
                    if ($nombre_descripcion == "P1220097"){
                        $nombre_descripcion = "50 a 54 años";
                    }
                    if ($nombre_descripcion == "P1220098"){
                        $nombre_descripcion = "55 a 59 años";
                    }
                    if ($nombre_descripcion == "P1220099"){
                        $nombre_descripcion = "60 a 64 años";
                    }
                    if ($nombre_descripcion == "P1220100"){
                        $nombre_descripcion = "65 A 69 años";
                    }
                    if ($nombre_descripcion == "P1220101"){
                        $nombre_descripcion = "70 a 74 años";
                    }
                    if ($nombre_descripcion == "P1220102"){
                        $nombre_descripcion = "75 a 79 años";
                    }
                    if ($nombre_descripcion == "P1230005"){
                        $nombre_descripcion = "80 y más años";
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
                    <td align='right'><?php echo number_format($row->Col09,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col10,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col11,0,",",".")?></td>
                    <?php
                    $i++;
                }
                ?>
                </tr>
                <tr>
                    <td align='left'><strong>TOTAL</strong></td>
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
                </tr>
                <tr>
                    <td colspan="12" align='left'>(*) FUENTE DE INFORMACIÓN: CITOEXPERT O REVICAN</td>
                </tr>
            </tbody>
        </table>
    </div>

    <br>

    <div class="container">

    <!-- SECCION C -->
    <div class="col-sm tab table-responsive" id="C">
        <table class="table table-hover table-bordered table-sm">
            <thead>
                <tr>
                    <td colspan="3" class="active"><strong>SECCION C: PROGRAMA DE CANCER DE MAMA: MUJERES CON MAMOGRAFÍA VIGENTE EN LOS ULTIMOS 3 AÑOS.</strong></td>
                </tr>
                <tr>
                    <td align='center'><strong>GRUPOS DE EDAD (en años)</strong></td>
                    <td align='center'><strong>Mujeres con mamografia vigente  (Menor o igual a 3 años)</strong></td>
                </tr>
            </thead>
            <tbody>
                <?php
                $query = 'SELECT a.codigo_prestacion,a.descripcion
                              ,sum(ifnull(b.Col01,0)) Col01
                          FROM (select c.* from 2019prestaciones c where c.codigo_prestacion in("P1207190","P1220020","P1220030","P1207030","P1207040","P1207050","P1207060","P1207070",
                                                                                                "P1207080") AND c.serie = "P") a
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
                    if ($nombre_descripcion == "P1207190"){
                        $nombre_descripcion = "Menor de 35 años";
                    }
                    if ($nombre_descripcion == "P1220020"){
                        $nombre_descripcion = "35 a 49 años";
                    }
                    if ($nombre_descripcion == "P1220030"){
                        $nombre_descripcion = "50 a 54 años";
                    }
                    if ($nombre_descripcion == "P1207030"){
                        $nombre_descripcion = "55 a 59 años";
                    }
                    if ($nombre_descripcion == "P1207040"){
                        $nombre_descripcion = "60 a 64 años";
                    }
                    if ($nombre_descripcion == "P1207050"){
                        $nombre_descripcion = "65 A 69 años";
                    }
                    if ($nombre_descripcion == "P1207060"){
                        $nombre_descripcion = "70 a 74 años";
                    }
                    if ($nombre_descripcion == "P1207070"){
                        $nombre_descripcion = "75 a 79 años";
                    }
                    if ($nombre_descripcion == "P1207080"){
                        $nombre_descripcion = "80 y más años";
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
                    <td align='left'><strong>TOTAL</strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol01,0,",",".") ?></strong></td>
                </tr>
                <tr>
                    <td colspan="3" align='left'>(*) FUENTE DE INFORMACIÓN: TARJETERO POBLACIONAL DE LA APS</td>
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
                    <td colspan="3" class="active"><strong>SECCION D: PROGRAMA DE CANCER DE MAMA: NÚMERO DE MUJERES CON EXAMEN FÍSICO DE MAMA (VIGENTE).</strong></td>
                </tr>
                <tr>
                    <td align='center'><strong>GRUPOS DE EDAD (en años)</strong></td>
                    <td align='center'><strong>"Mujeres con EFM vigente</strong></td>
                </tr>
            </thead>
            <tbody>
                <?php
                $query = 'SELECT a.codigo_prestacion,a.descripcion
                              ,sum(ifnull(b.Col01,0)) Col01
                          FROM (select c.* from 2019prestaciones c where c.codigo_prestacion in("P1207180","P1220070","P1220090","P1207090","P1207100","P1207110","P1207120","P1207130",
                                                                                                "P1207140") AND c.serie = "P") a
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
                    if ($nombre_descripcion == "P1207180"){
                        $nombre_descripcion = "Menor de 35 años";
                    }
                    if ($nombre_descripcion == "P1220070"){
                        $nombre_descripcion = "35 a 49 años";
                    }
                    if ($nombre_descripcion == "P1220090"){
                        $nombre_descripcion = "50 a 54 años";
                    }
                    if ($nombre_descripcion == "P1207090"){
                        $nombre_descripcion = "55 a 59 años";
                    }
                    if ($nombre_descripcion == "P1207100"){
                        $nombre_descripcion = "60 a 64 años";
                    }
                    if ($nombre_descripcion == "P1207110"){
                        $nombre_descripcion = "65 A 69 años";
                    }
                    if ($nombre_descripcion == "P1207120"){
                        $nombre_descripcion = "70 a 74 años";
                    }
                    if ($nombre_descripcion == "P1207130"){
                        $nombre_descripcion = "75 a 79 años";
                    }
                    if ($nombre_descripcion == "P1207140"){
                        $nombre_descripcion = "80 y más años";
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
                    <td align='left'><strong>TOTAL</strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol01,0,",",".") ?></strong></td>
                </tr>
                <tr>
                    <td colspan="3" align='left'>(*) FUENTE DE INFORMACIÓN: TARJETERO POBLACIONAL DE LA APS</td>
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
