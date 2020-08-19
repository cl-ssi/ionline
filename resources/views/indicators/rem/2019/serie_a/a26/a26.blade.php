@extends('layouts.app')

@section('title', 'Resumen Estadistico Mensual')

@section('content')

<?php

use Illuminate\Support\Facades\DB;

?>

@include('indicators.rem.partials.nav')

<h3>REM-26. ACTIVIDADES EN DOMICILIO Y OTROS ESPACIOS.</h3>

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
                    <td colspan="12" class="active"><strong>SECCIÓN A: VISITAS DOMICILIARIAS INTEGRALES A FAMILIAS (ESTABLECIMIENTOS APS).</strong></td>
                </tr>
                <tr>
                    <td align="center"><strong>CONCEPTOS</strong></td>
                    <td align="center"><strong>TOTAL</strong></td>
                    <td align="center"><strong>UN PROFESIONAL</strong></td>
                    <td align="center"><strong>DOS O MÁS PROFESIONALES</strong></td>
                    <td align="center"><strong>UN PROFESIONAL Y UN TÉCNICO PARAMÉDICO</strong></td>
                    <td align="center"><strong>FACILITADOR/A INTERCULTURAL PUEBLOS ORIGINARIOS</strong></td>
                    <td align="center"><strong>GESTOR COMUNITARIO</strong></td>
                    <td align="center"><strong>PRIMER CONTACTO</strong></td>
                    <td align="center"><strong>VISITA DE SEGUIMIENTO</strong></td>
                    <td align="center"><strong>PROGRAMA DE ATENCIÓN DOMICILIARIA A PERSONAS CON DEPENDENCIA SEVERA</strong></td>
                    <td align="center"><strong>PROGRAMA DE ACOMPAÑAMIENTO PSICOSOCIAL EN APS</strong></td>
                    <td align="center"><strong>MIGRANTES</strong></td>
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
                          FROM (select c.* from 2019prestaciones c where c.codigo_prestacion in("26261000","26260100","26273101","26274000","26291000","26291050","26291100","26273102","26274600",
                                                                                                "26262300","26273103","26273105","26274200","26280010","26262400","26291150","26291200","26291250",
                                                                                                "26291300","26280020","26273106","26274400","26261400","26273107","26274601","26300100","26300110")) a
                          left join 2019rems b on (a.id_prestacion=b.prestacion_id_prestacion)
                          AND (b.Mes in ('.$mes.')) AND (b.establecimiento_id_establecimiento in ('.$estab.'))
                          group by a.codigo_prestacion, a.descripcion, a.id_prestacion
                          order by a.id_prestacion';
                $registro = DB::connection('mysql_rem')->select($query);

                $i=0;

                foreach($registro as $row ){
                    $nombre_descripcion = $row->codigo_prestacion;
                    if ($nombre_descripcion == "26261000"){
                        $nombre_descripcion = "FAMILIA CON NIÑO PREMATURO";
      							}
      							if ($nombre_descripcion == "26260100"){
                        $nombre_descripcion = "FAMILIA CON NIÑO RECIÉN NACIDO";
      							}
      							if ($nombre_descripcion == "26273101"){
                        $nombre_descripcion = "FAMILIA CON NIÑO CON DÉFICIT DEL DSM";
      							}
      							if ($nombre_descripcion == "26274000"){
                        $nombre_descripcion = "FAMILIA CON NIÑO EN RIESGO VINCULAR AFECTIVO";
      							}
      							if ($nombre_descripcion == "26291000"){
                        $nombre_descripcion = "FAMILIA CON NIÑO < 7 MESES CON SCORE DE RIESGO MODERADO DE MORIR POR NEUMONÍA";
      							}
      							if ($nombre_descripcion == "26291050"){
                        $nombre_descripcion = "FAMILIA CON NIÑO < 7 MESES CON SCORE DE RIESGO GRAVE DE MORIR POR NEUMONÍA";
      							}
      							if ($nombre_descripcion == "26291100"){
                        $nombre_descripcion = "FAMILIA CON NIÑO CON PROBLEMA RESPIRATORIO CRÓNICO O NO CONTROLADO";
      							}
      							if ($nombre_descripcion == "26273102"){
                        $nombre_descripcion = "FAMILIA CON NIÑO MALNUTRIDO";
      							}
      							if ($nombre_descripcion == "26274600"){
                        $nombre_descripcion = "FAMILIA CON NIÑO CON RIESGO PSICOSOCIAL (EXCLUYE VINCULAR AFECTIVO)";
      							}
      							if ($nombre_descripcion == "26262300"){
                        $nombre_descripcion = "FAMILIA CON ADOLESCENTE EN RIESGO O PROBLEMA PSICOSOCIAL";
      							}
      							if ($nombre_descripcion == "26273103"){
                        $nombre_descripcion = "FAMILIA CON INTEGRANTE CON PATOLOGÍA CRÓNICA DESCOMPENSADA";
      							}
      							if ($nombre_descripcion == "26273105"){
                        $nombre_descripcion = "FAMILIA CON ADULTO MAYOR DEPENDEDIENTE (EXCLUYE DEPENDIENTE SEVERO)";
      							}
      							if ($nombre_descripcion == "26274200"){
                        $nombre_descripcion = "FAMILIA CON ADULTO MAYOR CON DEMENCIA";
      							}
      							if ($nombre_descripcion == "26280010"){
                        $nombre_descripcion = "FAMILIA CON ADULTO MAYOR EN RIESGO PSICOSOCIAL";
      							}
      							if ($nombre_descripcion == "26262400"){
                        $nombre_descripcion = "FAMILIA CON GESTANTE >20 AÑOS EN RIESGO PSICOSOCIAL";
      							}
      							if ($nombre_descripcion == "26291150"){
                        $nombre_descripcion = "FAMILIA CON GESTANTE ADOLESCENTE 10 A 14 AÑOS";
      							}
      							if ($nombre_descripcion == "26291200"){
                        $nombre_descripcion = "FAMILIA CON GESTANTE ADOLESCENTE EN RIESGO PSICOSOCIAL 15 A 19 AÑOS";
      							}
      							if ($nombre_descripcion == "26291250"){
                        $nombre_descripcion = "FAMILIA CON ADOLESCENTE CON PROBLEMA RESPIRATORIO CRÓNICO O NO CONTROLADO";
      							}
      							if ($nombre_descripcion == "26291300"){
                        $nombre_descripcion = "FAMILIA CON ADULTO CON PROBLEMA RESPIRATORIO CRÓNICO O NO CONTROLADO";
      							}
      							if ($nombre_descripcion == "26280020"){
                        $nombre_descripcion = "FAMILIA CON GESTANTE EN RIESGO BIOMÉDICO";
      							}
      							if ($nombre_descripcion == "26273106"){
                        $nombre_descripcion = "FAMILIA CON INTEGRANTE CON ENFERMEDAD TERMINAL";
      							}
      							if ($nombre_descripcion == "26274400"){
                        $nombre_descripcion = "FAMILIA CON INTEGRANTE ALTA HOSPITALIZACIÓN PRECOZ";
      							}
      							if ($nombre_descripcion == "26261400"){
                        $nombre_descripcion = "FAMILIA CON INTEGRANTE CON DEPENDENCIA SEVERA (excluye adulto mayor)";
      							}
      							if ($nombre_descripcion == "26273107"){
                        $nombre_descripcion = "FAMILIA CON OTRO RIESGO PSICOSOCIAL";
      							}
      							if ($nombre_descripcion == "26274601"){
                        $nombre_descripcion = "FAMILIA CON INTEGRANTE CON PROBLEMA DE SALUD MENTAL";
      							}
                    if ($nombre_descripcion == "26300100"){
                        $nombre_descripcion = "FAMILIA CON ADULTO MAYOR DEPENDEDIENTE SEVERO	";
      							}
                    if ($nombre_descripcion == "26300110"){
                        $nombre_descripcion = "FAMILIA CON NIÑOS/AS DE 5 A 9 AÑOS CON PROBLEMAS Y/O TRASTORNOS DE SALUD MENTAL";
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
            </tbody>
        </table>
    </div>

    <br>

    <!-- SECCION B -->
    <div class="col-sm tab table-responsive" id="B">
        <table class="table table-hover table-bordered table-sm">
            <thead>
                <tr>
                    <td colspan="10" class="active"><strong>SECCIÓN B: OTRAS VISITAS INTEGRALES.</strong></td>
                </tr>
                <tr>
                    <td colspan="2" align="center"><strong>CONCEPTOS</strong></td>
                    <td align="center"><strong>TOTAL</strong></td>
                    <td align="center"><strong>UN PROFESIONAL</strong></td>
                    <td align="center"><strong>DOS O MÁS PROFESIONALES</strong></td>
                    <td align="center"><strong>UN PROFESIONAL Y UN TÉCNICO PARAMÉDICO</strong></td>
                    <td align="center"><strong>TÉCNICO PARAMÉDICO</strong></td>
                    <td align="center"><strong>FACILITADOR/A INTERCULTURAL PUEBLOS ORIGINARIOS</strong></td>
                    <td align="center"><strong>GESTOR COMUNITARIO</strong></td>
                    <td align="center"><strong>MIGRANTES</strong></td>
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
                          FROM (select c.* from 2019prestaciones c where c.codigo_prestacion in("26260600","26261800","26261900","26273109",
                                                                                                "26275400","26275500","26275600",
                                                                                                "26273110","26262100",
                                                                                                "26300120","26300130")) a
                          left join 2019rems b on (a.id_prestacion=b.prestacion_id_prestacion)
                          AND (b.Mes in ('.$mes.')) AND (b.establecimiento_id_establecimiento in ('.$estab.'))
                          group by a.codigo_prestacion, a.descripcion, a.id_prestacion
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
                    if ($nombre_descripcion == "26260600"){
                        $nombre_descripcion = "VISITA EPIDEMIOLÓGICA";
      							}
      							if ($nombre_descripcion == "26261800"){
                        $nombre_descripcion = "A LUGAR DE TRABAJO (*)";
      							}
      							if ($nombre_descripcion == "26261900"){
                        $nombre_descripcion = "A COLEGIO, SALAS CUNA, JARDÍN INFANTIL (*)";
      							}
      							if ($nombre_descripcion == "26273109"){
                        $nombre_descripcion = "A GRUPO COMUNITARIO";
      							}
      							if ($nombre_descripcion == "26275400"){
                        $nombre_descripcion = "A DOMINICILIO (NIVEL SECUNDARIO)";
      							}
      							if ($nombre_descripcion == "26275500"){
                        $nombre_descripcion = "A LUGAR DE TRABAJO";
      							}
      							if ($nombre_descripcion == "26275600"){
                        $nombre_descripcion = "A ESTABLECIMIENTOS EDUCACIONALES";
      							}

      							if ($nombre_descripcion == "26273110"){
                        $nombre_descripcion = "EN SECTOR RURAL";
      							}
      							if ($nombre_descripcion == "26262100"){
                        $nombre_descripcion = "OTRAS";
      							}

                    if ($nombre_descripcion == "26300120"){
                        $nombre_descripcion = "PRIMERA VISITA";
      							}
                    if ($nombre_descripcion == "26300130"){
                        $nombre_descripcion = "SEGUNDA VISITA";
      							}
                    ?>
                <tr>
                    <?php
                    if($i>=0 && $i<=3){?>
                    <td colspan="2" align="left" nowrap="nowrap"><?php echo $nombre_descripcion; ?></td>
                    <?php
                    }
                    if($i==4){?>
                    <td rowspan="3" nowrap="nowrap" style="text-align:center; vertical-align:middle">VISITA INTEGRAL DE SALUD MENTAL</td>
                    <?php
                    }
                    if($i>=4 && $i<=6){?>
                    <td align="left" nowrap="nowrap"><?php echo $nombre_descripcion; ?></td>
                    <?php
                    }
                    if($i>=7 && $i<=8){?>
                    <td colspan="2" align="left" nowrap="nowrap"><?php echo $nombre_descripcion; ?></td>
                    <?php
                    }
                    if($i==9){?>
                    <td rowspan="2" nowrap="nowrap" style="text-align:center; vertical-align:middle">A PERSONAS CON DEPENDENCIA SEVERA</td>
                    <?php
                    }
                    if($i>=9){?>
                    <td align="left" nowrap="nowrap"><?php echo $nombre_descripcion; ?></td>
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
                </tr>
                <tr>
                    <td colspan="10" align='left'>(*) Excluye visita integral de salud mental</td>
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
                    <td colspan="6" class="active"><strong>SECCIÓN C: VISITAS CON FINES DE TRATAMIENTOS Y/O PROCEDIMIENTOS EN  DOMICILIO.</strong></td>
                </tr>
                <tr>
                    <td colspan="2" align="center"><strong>CONCEPTOS</strong></td>
                    <td align="center" width="10%"><strong>TOTAL</strong></td>
                    <td align="center"><strong>PROFESIONAL</strong></td>
                    <td align="center"><strong>TÉCNICO PARAMÉDICO</strong></td>
                    <td align="center"><strong>PROGRAMA DE ATENCIÓN DOMICILIARIA A PERSONAS CON DEPENDENCIA SEVERA</strong></td>
                </tr>
            </thead>
            <tbody>
                <?php
                $query = 'SELECT a.codigo_prestacion,a.descripcion
                              ,sum(ifnull(b.Col01,0)) Col01
                              ,sum(ifnull(b.Col02,0)) Col02
                              ,sum(ifnull(b.Col03,0)) Col03
                              ,sum(ifnull(b.Col04,0)) Col04
                          FROM (select c.* from 2019prestaciones c where c.codigo_prestacion in("26280030","26280040",
                                                                                                "26275700","26275800",
                                                                                                "26300140","26274500","26291350","26274602","26274603","26300150")) a
                          left join 2019rems b on (a.id_prestacion=b.prestacion_id_prestacion)
                          AND (b.Mes in ('.$mes.')) AND (b.establecimiento_id_establecimiento in ('.$estab.'))
                          group by a.codigo_prestacion, a.descripcion, a.id_prestacion
                          order by a.id_prestacion';
                $registro = DB::connection('mysql_rem')->select($query);

                $i=0;

                foreach($registro as $row ){
                    $nombre_descripcion = $row->codigo_prestacion;
                    if ($nombre_descripcion == "26280030"){
                        $nombre_descripcion = "A PERSONAS CON DEPENDENCIA LEVE";
      							}
      							if ($nombre_descripcion == "26280040"){
                        $nombre_descripcion = "A PERSONAS CON DEPENDENCIA MODERADA";
      							}
      							/*A PERSONAS CON DEPENDENCIA SEVERA*/
      							if ($nombre_descripcion == "26275700"){
                        $nombre_descripcion = "ONCOLÓGICOS (Excluye cuidados paliativos)";
      							}
      							if ($nombre_descripcion == "26275800"){
                        $nombre_descripcion = "NO ONCOLÓGICOS";
      							}

                    if ($nombre_descripcion == "26300140"){
                        $nombre_descripcion = "A PERSONAS EN CUIDADOS PALIATIVOS";
      							}
      							if ($nombre_descripcion == "26274500"){
                        $nombre_descripcion = "OTROS";
      							}
      							if ($nombre_descripcion == "26291350"){
                        $nombre_descripcion = "VISITA DE SEGUIMIENTO A PERSONAS CON DEPENDENCIA";
      							}
      							if ($nombre_descripcion == "26274602"){
                        $nombre_descripcion = "ATENCION ODONTOLOGICA EN DOMICILIO";
      							}
      							if ($nombre_descripcion == "26274603"){
                        $nombre_descripcion = "ATENCION  FARMACEÚTICA EN DOMICILIO";
      							}
                    if ($nombre_descripcion == "26300150"){
                        $nombre_descripcion = "ATENCIÓN NUTRICIONAL A PERSONAS CON INDICACION NUTRICIONAL ENTERAL DOMICILIARIA (NED)";
      							}
                    ?>
                <tr>
                    <?php
                    if($i>=0 && $i<=1){?>
                    <td colspan="2" align="left" nowrap="nowrap"><?php echo $nombre_descripcion; ?></td>
                    <?php
                    }
                    if($i==2){?>
                    <td rowspan="2" nowrap="nowrap" style="text-align:center; vertical-align:middle">A PERSONAS CON DEPENDENCIA SEVERA</td>
                    <?php
                    }
                    if($i>=2 && $i<=3){?>
                    <td align="left" nowrap="nowrap"><?php echo $nombre_descripcion; ?></td>
                    <?php
                    }
                    if($i>=4){?>
                    <td colspan="2" align="left" nowrap="nowrap"><?php echo $nombre_descripcion; ?></td>
                    <?php
                    }
                    ?>
                    <td align='right'><?php echo number_format($row->Col01,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col02,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col03,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col04,0,",",".")?></td>
                    <?php
                    $i++;
                }
                ?>
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
                    <td colspan="8" class="active"><strong>SECCIÓN D: RESCATE DE PACIENTES INASISTENTES.</strong></td>
                </tr>
                <tr>
                    <td rowspan="3" style="text-align:center; vertical-align:middle"><strong>GRUPO ETARIO</strong></td>
                    <td colspan="5" align="center"><strong>RESCATE EN DOMICILIO</strong></td>
                    <td colspan="2" rowspan="2" align="center"><strong>RESCATE TELEFONICO</strong></td>
                </tr>
                <tr>
                    <td rowspan="2" style="text-align:center; vertical-align:middle"><strong>TOTAL</strong></td>
                    <td colspan="3" align="center"><strong>FUNCIONARIO</strong></td>
                    <td rowspan="2" style="text-align:center; vertical-align:middle"><strong>COMPRA DE SERVICIO (*)</strong></td>
                </tr>
                <tr>
                    <td align="center"><strong>Técnico paramédico</strong></td>
                    <td align="center"><strong>Administrativo</strong></td>
                    <td align="center"><strong>Otro</strong></td>
                    <td align="center"><strong>Desde el establecimiento</strong></td>
                    <td align="center"><strong>Compra de servicio (*)</strong></td>
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
                          FROM (select c.* from 2019prestaciones c where c.codigo_prestacion in("26280050","26280060","26280070","26280080","26280090","26280100")) a
                          left join 2019rems b on (a.id_prestacion=b.prestacion_id_prestacion)
                          AND (b.Mes in ('.$mes.')) AND (b.establecimiento_id_establecimiento in ('.$estab.'))
                          group by a.codigo_prestacion, a.descripcion, a.id_prestacion
                          order by a.id_prestacion';
                $registro = DB::connection('mysql_rem')->select($query);

                $i=0;

                foreach($registro as $row ){
                    $nombre_descripcion = $row->codigo_prestacion;
                    if ($nombre_descripcion == "26280050"){
                        $nombre_descripcion = "Menor de 1 año";
                    }
                    if ($nombre_descripcion == "26280060"){
                        $nombre_descripcion = "1 a 4 años";
                    }
                    if ($nombre_descripcion == "26280070"){
                        $nombre_descripcion = "5 a 9 años";
                    }
                    if ($nombre_descripcion == "26280080"){
                        $nombre_descripcion = "10 a 24 años";
                    }
                    if ($nombre_descripcion == "26280090"){
                        $nombre_descripcion = "25 a 64 años";
                    }
                    if ($nombre_descripcion == "26280100"){
                        $nombre_descripcion = "65 y más";
                    }
                    ?>
                <tr>
                    <td align="left" nowrap="nowrap"><?php echo $nombre_descripcion; ?></td>
                    <td align='right'><?php echo number_format($row->Col01,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col02,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col03,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col04,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col05,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col06,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col07,0,",",".")?></td>
                    <?php
                    $i++;
                }
                ?>
                </tr>
                <tr>
                    <td colspan="8" align="left">* No incluidas como producción del establecimiento.</td>
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
                    <td colspan="7" class="active"><strong>SECCIÓN E: OTRAS VISITAS PROGRAMA DE ACOMPAÑAMIENTO PSICOSOCIAL EN ATENCIÓN PRIMARIA.</strong></td>
                </tr>
                <tr>
                    <td rowspan="2" style="text-align:center; vertical-align:middle"><strong>GRUPOS</strong></td>
                    <td rowspan="2" style="text-align:center; vertical-align:middle"><strong>TOTAL VISITAS</strong></td>
                    <td colspan="5" align="center"><strong>NÚMERO DE OTRAS VISITAS SEGÚN RANGO ETARIO</strong></td>
                </tr>
                <tr>
                    <td align="center"><strong>0 - 4</strong></td>
                    <td align="center"><strong>5 - 9</strong></td>
                    <td align="center"><strong>10 - 14</strong></td>
                    <td align="center"><strong>15 - 19</strong></td>
                    <td align="center"><strong>20 - 24</strong></td>
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
                          FROM (select c.* from 2019prestaciones c where c.codigo_prestacion in("26280200","26280210")) a
                          left join 2019rems b on (a.id_prestacion=b.prestacion_id_prestacion)
                          AND (b.Mes in ('.$mes.')) AND (b.establecimiento_id_establecimiento in ('.$estab.'))
                          group by a.codigo_prestacion, a.descripcion, a.id_prestacion
                          order by a.id_prestacion';
                $registro = DB::connection('mysql_rem')->select($query);

                $i=0;

                foreach($registro as $row ){
                    $nombre_descripcion = $row->codigo_prestacion;
                    if ($nombre_descripcion == "26280200"){
                        $nombre_descripcion = "ESTABLECIMIENTO EDUCACIONAL";
                    }
                    if ($nombre_descripcion == "26280210"){
                        $nombre_descripcion = "A LUGAR DE TRABAJO";
                    }
                    ?>
                <tr>
                    <td align="left" nowrap="nowrap"><?php echo $nombre_descripcion; ?></td>
                    <td align='right'><?php echo number_format($row->Col01,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col02,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col03,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col04,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col05,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col06,0,",",".")?></td>
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
                    <td colspan="7" class="active"><strong>SECCIÓN F: APOYO TELEFÓNICO DEL PROGRAMA DE ACOMPAÑAMIENTO PSICOSOCIAL EN APS.</strong></td>
                </tr>
                <tr>
                    <td rowspan="2" style="text-align:center; vertical-align:middle"><strong>GRUPOS</strong></td>
                    <td rowspan="2" style="text-align:center; vertical-align:middle"><strong>TOTAL ACCIONES</strong></td>
                    <td colspan="5" align="center"><strong>NÚMERO DE ACCIONES DE ACOMPAÑAMIENTO TELEFÓNICO</strong></td>
                </tr>
                <tr>
                    <td align="center"><strong>0 - 4</strong></td>
                    <td align="center"><strong>5 - 9</strong></td>
                    <td align="center"><strong>10 - 14</strong></td>
                    <td align="center"><strong>15 - 19</strong></td>
                    <td align="center"><strong>20 - 24</strong></td>
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
                          FROM (select c.* from 2019prestaciones c where c.codigo_prestacion in("26280220")) a
                          left join 2019rems b on (a.id_prestacion=b.prestacion_id_prestacion)
                          AND (b.Mes in ('.$mes.')) AND (b.establecimiento_id_establecimiento in ('.$estab.'))
                          group by a.codigo_prestacion, a.descripcion, a.id_prestacion
                          order by a.id_prestacion';
                $registro = DB::connection('mysql_rem')->select($query);

                $i=0;

                foreach($registro as $row ){
                    $nombre_descripcion = $row->codigo_prestacion;
                    if ($nombre_descripcion == "26280220"){
                        $nombre_descripcion = "ACCIONES TELEFÓNICAS REALIZADAS (LLAMADAS O MENSAJERÍA)";
                    }
                    ?>
                <tr>
                    <td align="left" nowrap="nowrap"><?php echo $nombre_descripcion; ?></td>
                    <td align='right'><?php echo number_format($row->Col01,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col02,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col03,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col04,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col05,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col06,0,",",".")?></td>
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
                    <td colspan="8" class="active"><strong>SECCIÓN G: VISITA A ESTABLECIMIENTO EDUCACIONAL PROGRAMA DE APOYO A LA SALUD MENTAL INFANTIL (PASMI) EN ATENCIÓN PRIMARIA.</strong></td>
                </tr>
                <tr>
                    <td align="center"><strong>CONCEPTO</strong></td>
                    <td align="center"><strong>TOTAL VISITAS 5 A 9 AÑOS</strong></td>
                    <td align="center"><strong>NÚMERO DE NIÑOS/AS VISITADOS 5 A 9 AÑOS</strong></td>
                </tr>
            </thead>
            <tbody>
                <?php
                $query = 'SELECT a.codigo_prestacion,a.descripcion
                              ,sum(ifnull(b.Col01,0)) Col01
                              ,sum(ifnull(b.Col02,0)) Col02
                          FROM (select c.* from 2019prestaciones c where c.codigo_prestacion in("26300160")) a
                          left join 2019rems b on (a.id_prestacion=b.prestacion_id_prestacion)
                          AND (b.Mes in ('.$mes.')) AND (b.establecimiento_id_establecimiento in ('.$estab.'))
                          group by a.codigo_prestacion, a.descripcion, a.id_prestacion
                          order by a.id_prestacion';
                $registro = DB::connection('mysql_rem')->select($query);

                $i=0;

                foreach($registro as $row ){
                    $nombre_descripcion = $row->codigo_prestacion;
                    if ($nombre_descripcion == "26300160"){
                        $nombre_descripcion = "ESTABLECIMIENTO EDUCACIONAL";
                    }
                    ?>
                <tr>
                    <td align="left" nowrap="nowrap"><?php echo $nombre_descripcion; ?></td>
                    <td align='right'><?php echo number_format($row->Col01,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col02,0,",",".")?></td>
                    <?php
                    $i++;
                }
                ?>
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
