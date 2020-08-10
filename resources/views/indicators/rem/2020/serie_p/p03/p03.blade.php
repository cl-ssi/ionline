@extends('layouts.app')

@section('title', 'Resumen Estadistico Mensual')

@section('content')

<?php

use Illuminate\Support\Facades\DB;

?>

@include('indicators.rem.partials.navP')

<h3>REM-P3. POBLACIÓN EN CONTROL OTROS PROGRAMAS.</h3>

<br>

@include('indicators.rem.2020.serie_p.search')

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
                    <td colspan="42" class="active"><strong>SECCIÓN A: EXISTENCIA DE POBLACIÓN EN CONTROL.</strong></td>
                </tr>
                <tr>
                    <td colspan='2' rowspan='3' style="text-align:center; vertical-align:middle"><strong>PROGRAMAS</strong></td>
      							<td colspan='3' rowspan='2' style="text-align:center; vertical-align:middle"><strong>TOTAL</strong></td>
      							<td colspan='34' align='center'><strong>GRUPOS DE EDAD (en a&ntilde;os) Y SEXO</strong></td>
      							<td rowspan='3' style="text-align:center; vertical-align:middle"><strong>Con espirometr&iacute;a vigente</strong></td>
      							<td colspan='2' rowspan='2' align='center'><strong>Población Migrantes</strong></td>
    						</tr>
    						<tr>
      							<td colspan='2' align='center'><strong>0 a 4 años</strong></td>
      							<td colspan='2' align='center'><strong>5 a 9 años</strong></td>
      							<td colspan='2' align='center'><strong>10 a 14 años</strong></td>
      							<td colspan='2' align='center'><strong>15 a 19 años</strong></td>
      							<td colspan='2' align='center'><strong>20 a 24 años</strong></td>
      							<td colspan='2' align='center'><strong>25 a 29 años</strong></td>
      							<td colspan='2' align='center'><strong>30 a 34 años</strong></td>
      							<td colspan='2' align='center'><strong>35 a 39 años</strong></td>
      							<td colspan='2' align='center'><strong>40 a 44 años</strong></td>
      							<td colspan='2' align='center'><strong>45 a 49 años</strong></td>
      							<td colspan='2' align='center'><strong>50 a 54 años</strong></td>
      							<td colspan='2' align='center'><strong>55 a 59 años</strong></td>
      							<td colspan='2' align='center'><strong>60 a 64 años</strong></td>
      							<td colspan='2' align='center'><strong>65 a 69 años</strong></td>
      							<td colspan='2' align='center'><strong>70 a 74 años</strong></td>
      							<td colspan='2' align='center'><strong>75 a 79 años</strong></td>
      							<td colspan='2' align='center'><strong>80 y más</strong></td>
    						</tr>
    						<tr>
      							<td align='center'><strong>Ambos sexos</strong></td>
      							<td align='center'><strong>Hombres</strong></td>
      							<td align='center'><strong>Mujeres</strong></td>
      							<td align='center'><strong>Hombres</strong></td>
      							<td align='center'><strong>Mujeres</strong></td>
      							<td align='center'><strong>Hombres</strong></td>
      							<td align='center'><strong>Mujeres</strong></td>
      							<td align='center'><strong>Hombres</strong></td>
      							<td align='center'><strong>Mujeres</strong></td>
      							<td align='center'><strong>Hombres</strong></td>
      							<td align='center'><strong>Mujeres</strong></td>
      							<td align='center'><strong>Hombres</strong></td>
      							<td align='center'><strong>Mujeres</strong></td>
      							<td align='center'><strong>Hombres</strong></td>
      							<td align='center'><strong>Mujeres</strong></td>
      							<td align='center'><strong>Hombres</strong></td>
      							<td align='center'><strong>Mujeres</strong></td>
      							<td align='center'><strong>Hombres</strong></td>
      							<td align='center'><strong>Mujeres</strong></td>
      							<td align='center'><strong>Hombres</strong></td>
      							<td align='center'><strong>Mujeres</strong></td>
      							<td align='center'><strong>Hombres</strong></td>
      							<td align='center'><strong>Mujeres</strong></td>
      							<td align='center'><strong>Hombres</strong></td>
      							<td align='center'><strong>Mujeres</strong></td>
      							<td align='center'><strong>Hombres</strong></td>
      							<td align='center'><strong>Mujeres</strong></td>
      							<td align='center'><strong>Hombres</strong></td>
      							<td align='center'><strong>Mujeres</strong></td>
      							<td align='center'><strong>Hombres</strong></td>
      							<td align='center'><strong>Mujeres</strong></td>
      							<td align='center'><strong>Hombres</strong></td>
      							<td align='center'><strong>Mujeres</strong></td>
      							<td align='center'><strong>Hombres</strong></td>
      							<td align='center'><strong>Mujeres</strong></td>
      							<td align='center'><strong>Hombres</strong></td>
      							<td align='center'><strong>Mujeres</strong></td>
      							<td align='center'><strong>Hombres</strong></td>
      							<td align='center'><strong>Mujeres</strong></td>
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
                          FROM (select c.* from 2020prestaciones c where c.codigo_prestacion in("P3160950","P3160960","P3160970",
                                                                                                "P3160980","P3160990","P3161000",
                                                                                                "P3161010","P3161020",
                                                                                                "P3161030","P3120500","P3161050","P3120600","P3120700","P3170100","P3140200","P3140300",
                                                                                                "P3120800","P3161040","P3160910","P3160920",
                                                                                                "P3130200","P3140400","P3130201",
                                                                                                "P3160800","P3160900","P3160940","P3170200") AND c.serie = "P") a
                          left join 2020rems b on (a.id_prestacion=b.prestacion_id_prestacion)
                          AND (b.Mes in ('.$mes.')) AND (b.establecimiento_id_establecimiento in ('.$estab.'))
                          group by  a.codigo_prestacion,a.descripcion,a.id_prestacion
                          order by a.id_prestacion';
                $registro = DB::connection('mysql_rem')->select($query);

                $i=0;

                foreach($registro as $row ){
                    $nombre_descripcion = $row->codigo_prestacion;
                    if ($nombre_descripcion == "P3160950"){
                        $nombre_descripcion = "LEVE";
                    }
                    if ($nombre_descripcion == "P3160960"){
                        $nombre_descripcion = "MODERADO";
                    }
                    if ($nombre_descripcion == "P3160970"){
                        $nombre_descripcion = "SEVERO";
                    }

                    if ($nombre_descripcion == "P3160980"){
                        $nombre_descripcion = "LEVE";
                    }
                    if ($nombre_descripcion == "P3160990"){
                        $nombre_descripcion = "MODERADO";
                    }
                    if ($nombre_descripcion == "P3161000"){
                        $nombre_descripcion = "SEVERO";
                    }

                    if ($nombre_descripcion == "P3161010"){
                        $nombre_descripcion = "TIPO A";
                    }
                    if ($nombre_descripcion == "P3161020"){
                        $nombre_descripcion = "TIPO B";
                    }

                    if ($nombre_descripcion == "P3161030"){
                        $nombre_descripcion = "OTRAS RESPIRATORIAS CRONICAS";
                    }
                    if ($nombre_descripcion == "P3120500"){
                        $nombre_descripcion = "OXIGENO DEPENDIENTE";
                    }
                    if ($nombre_descripcion == "P3161050"){
                        $nombre_descripcion = "ASISTENCIA VENTILATORIA NO INVASIVA O INVASIVA";
                    }
                    if ($nombre_descripcion == "P3120600"){
                        $nombre_descripcion = "FIBROSIS QUÍSTICA";
                    }
                    if ($nombre_descripcion == "P3120700"){
                        $nombre_descripcion = "EPILEPSIA";
                    }
                    if ($nombre_descripcion == "P3170100"){
                        $nombre_descripcion = "GLAUCOMA";
                    }
                    if ($nombre_descripcion == "P3140200"){
                        $nombre_descripcion = "ENFERMEDAD DE PARKINSON";
                    }
                    if ($nombre_descripcion == "P3140300"){
                        $nombre_descripcion = "ARTROSIS DE CADERA Y RODILLA";
                    }
                    if ($nombre_descripcion == "P3120800"){
                        $nombre_descripcion = "ALIVIO DEL DOLOR";
                    }
                    if ($nombre_descripcion == "P3161040"){
                        $nombre_descripcion = "HIPOTIROIDISMO";
                    }
                    if ($nombre_descripcion == "P3160910"){
                        $nombre_descripcion = "DEPENDENCIA LEVE";
                    }
                    if ($nombre_descripcion == "P3160920"){
                        $nombre_descripcion = "DEPENDENCIA MODERADA";
                    }

                    if ($nombre_descripcion == "P3130200"){
                        $nombre_descripcion = "ONCOLÓGICA";
                    }
                    if ($nombre_descripcion == "P3140400"){
                        $nombre_descripcion = "NO ONCOLÓGICA";
                    }
                    if ($nombre_descripcion == "P3130201"){
                        $nombre_descripcion = "CON ESCARAS";
                    }

                    if ($nombre_descripcion == "P3160800"){
                        $nombre_descripcion = "TOTAL PERSONAS";
                    }
                    if ($nombre_descripcion == "P3160900"){
                        $nombre_descripcion = "TOTAL DE PERSONAS CON ESCARAS";
                    }
                    if ($nombre_descripcion == "P3160940"){
                        $nombre_descripcion = "TOTAL DE PERSONAS CON CUIDADOR QUE RECIBE APOYO MONETARIO";
                    }
                    if ($nombre_descripcion == "P3170200"){
                        $nombre_descripcion = "CON INDICACIÓN DE NUTRICIÓN ENTERAL DOMICILIARIA (NED)";
                    }
                    ?>
                <tr>
                    <?php
                    if($i==0){?>
                    <td rowspan="3" style="text-align:center; vertical-align:middle">SÍNDROME BRONQUIAL OBSTRUCTIVA RECURRENTE (SBOR)</td>
                    <?php
                    }
                    if($i>=0 && $i<=2){?>
                    <td align='left' nowrap="nowrap"><?php echo $nombre_descripcion; ?></td>
                    <?php
                    }
                    if($i==3){?>
                    <td rowspan="3" style="text-align:center; vertical-align:middle">ASMA BRONQUIAL</td>
                    <?php
                    }
                    if($i>=3 && $i<=5){?>
                    <td align='left' nowrap="nowrap"><?php echo $nombre_descripcion; ?></td>
                    <?php
                    }
                    if($i==6){?>
                    <td rowspan="2" style="text-align:center; vertical-align:middle">ENFERMEDAD PULMONAR OBSTRUCTIVA CRÓNICA (EPOC)</td>
                    <?php
                    }
                    if($i>=6 && $i<=7){?>
                    <td align='left' nowrap="nowrap"><?php echo $nombre_descripcion; ?></td>
                    <?php
                    }
                    if($i>=8 && $i<=19){?>
                    <td colspan="2" align='left' nowrap="nowrap"><?php echo $nombre_descripcion; ?></td>
                    <?php
                    }
                    if($i==20){?>
                    <td rowspan="3" style="text-align:center; vertical-align:middle">DEPENDENCIA SEVERA</td>
                    <?php
                    }
                    if($i>=20 && $i<=22){?>
                    <td align='left' nowrap="nowrap"><?php echo $nombre_descripcion; ?></td>
                    <?php
                    }
                    if($i==23){?>
                    <td rowspan="4" style="text-align:center; vertical-align:middle">DEPENDENCIA SEVERA</td>
                    <?php
                    }
                    if($i>=23 && $i<=26){?>
                    <td align='left'><?php echo $nombre_descripcion; ?></td>
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
                    <td align='right'><?php echo number_format($row->Col37,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col38,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col39,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col40,0,",",".")?></td>
                    <?php
                    $i++;
                }
                ?>
                </tr>

                <tr>
                    <td colspan="42" align="left">(*) Incluidos en Dependencia Severa Oncológica y NO Oncológica</td>
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
                    <td colspan="6" class="active"><strong>SECCION B: CUIDADORES DE PACIENTES CON DEPENDENCIA SEVERA.</strong></td>
                </tr>
                <tr>
                    <td rowspan='2' style="text-align:center; vertical-align:middle"><strong>CONCEPTO</strong></td>
                    <td rowspan='2' style="text-align:center; vertical-align:middle"><strong>Total Cuidadores/es</strong></td>
                    <td colspan='4' align='center'><strong>ATENCIÓN DOMICILIARIA POR DEPENDENCIA SEVERA</strong></td>
                </tr>
                <tr>
                    <td align='center'><strong>Total Cuidadoras/es capacitadas/dos</strong></td>
                    <td align='center'><strong>Total cuidadoras/es con examen preventivo vigente</strong></td>
                    <td align='center'><strong>Cuidadoras/es con apoyo monetario</strong></td>
                    <td align='center'><strong>Cuidadoras/es Capacitadas/os con apoyo monetario</strong></td>
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
                          FROM (select c.* from 2020prestaciones c where c.codigo_prestacion in("P5300600") AND c.serie = "P") a
                          left join 2020rems b on (a.id_prestacion=b.prestacion_id_prestacion)
                          AND (b.Mes in ('.$mes.')) AND (b.establecimiento_id_establecimiento in ('.$estab.'))
                          group by  a.codigo_prestacion,a.descripcion,a.id_prestacion
                          order by a.id_prestacion';
                $registro = DB::connection('mysql_rem')->select($query);

                $i=0;

                foreach($registro as $row ){
                    $nombre_descripcion = $row->codigo_prestacion;
                    if ($nombre_descripcion == "P5300600"){
                        $nombre_descripcion = "NÚMERO DE CUIDADORES";
                    }

                    ?>
                <tr>
                    <td align='left'><?php echo $nombre_descripcion; ?></td>
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
            </tbody>
        </table>
    </div>
    </div>

    <!-- SECCION C -->
    <div class="col-sm tab table-responsive" id="C">
        <table class="table table-hover table-bordered table-sm">
            <thead>
                <tr>
                    <td colspan="38" class="active"><strong>SECCION C: POBLACIÓN EN CONTROL EN PROGRAMA DE REHABILITACIÓN PULMONAR EN SALA IRA-ERA.</strong></td>
                </tr>
                <tr>
                    <td rowspan='3' style="text-align:center; vertical-align:middle"><strong>PROGRAMA</strong></td>
                    <td colspan='3' rowspan='2' style="text-align:center; vertical-align:middle"><strong>TOTAL</strong></td>
                    <td colspan='34' align='center'><strong>GRUPOS DE EDAD (en años) Y SEXO</strong></td>
                </tr>
                <tr>
                    <td colspan='2' align='center'><strong>0 a 4 años</strong></td>
                    <td colspan='2' align='center'><strong>5 a 9 años</strong></td>
                    <td colspan='2' align='center'><strong>10 a 14 años</strong></td>
                    <td colspan='2' align='center'><strong>15 a 19 años</strong></td>
                    <td colspan='2' align='center'><strong>20 a 24 años</strong></td>
                    <td colspan='2' align='center'><strong>25 a 29 años</strong></td>
                    <td colspan='2' align='center'><strong>30 a 34 años</strong></td>
                    <td colspan='2' align='center'><strong>35 a 39 años</strong></td>
                    <td colspan='2' align='center'><strong>40 a 44 años</strong></td>
                    <td colspan='2' align='center'><strong>45 a 49 años</strong></td>
                    <td colspan='2' align='center'><strong>50 a 54 años</strong></td>
                    <td colspan='2' align='center'><strong>55 a 59 años</strong></td>
                    <td colspan='2' align='center'><strong>60 a 64 años</strong></td>
                    <td colspan='2' align='center'><strong>65 a 69 años</strong></td>
                    <td colspan='2' align='center'><strong>70 a 74 años</strong></td>
                    <td colspan='2' align='center'><strong>75 a 79 años</strong></td>
                    <td colspan='2' align='center'><strong>80 y más</strong></td>
                </tr>
                <tr>
                    <td align='center'><strong>Ambos sexos</strong></td>
                    <td align='center'><strong>Hombres</strong></td>
                    <td align='center'><strong>Mujeres</strong></td>
                    <td align='center'><strong>Hombres</strong></td>
                    <td align='center'><strong>Mujeres</strong></td>
                    <td align='center'><strong>Hombres</strong></td>
                    <td align='center'><strong>Mujeres</strong></td>
                    <td align='center'><strong>Hombres</strong></td>
                    <td align='center'><strong>Mujeres</strong></td>
                    <td align='center'><strong>Hombres</strong></td>
                    <td align='center'><strong>Mujeres</strong></td>
                    <td align='center'><strong>Hombres</strong></td>
                    <td align='center'><strong>Mujeres</strong></td>
                    <td align='center'><strong>Hombres</strong></td>
                    <td align='center'><strong>Mujeres</strong></td>
                    <td align='center'><strong>Hombres</strong></td>
                    <td align='center'><strong>Mujeres</strong></td>
                    <td align='center'><strong>Hombres</strong></td>
                    <td align='center'><strong>Mujeres</strong></td>
                    <td align='center'><strong>Hombres</strong></td>
                    <td align='center'><strong>Mujeres</strong></td>
                    <td align='center'><strong>Hombres</strong></td>
                    <td align='center'><strong>Mujeres</strong></td>
                    <td align='center'><strong>Hombres</strong></td>
                    <td align='center'><strong>Mujeres</strong></td>
                    <td align='center'><strong>Hombres</strong></td>
                    <td align='center'><strong>Mujeres</strong></td>
                    <td align='center'><strong>Hombres</strong></td>
                    <td align='center'><strong>Mujeres</strong></td>
                    <td align='center'><strong>Hombres</strong></td>
                    <td align='center'><strong>Mujeres</strong></td>
                    <td align='center'><strong>Hombres</strong></td>
                    <td align='center'><strong>Mujeres</strong></td>
                    <td align='center'><strong>Hombres</strong></td>
                    <td align='center'><strong>Mujeres</strong></td>
                    <td align='center'><strong>Hombres</strong></td>
                    <td align='center'><strong>Mujeres</strong></td>
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
                          FROM (select c.* from 2020prestaciones c where c.codigo_prestacion in("P3160930") AND c.serie = "P") a
                          left join 2020rems b on (a.id_prestacion=b.prestacion_id_prestacion)
                          AND (b.Mes in ('.$mes.')) AND (b.establecimiento_id_establecimiento in ('.$estab.'))
                          group by  a.codigo_prestacion,a.descripcion,a.id_prestacion
                          order by a.id_prestacion';
                $registro = DB::connection('mysql_rem')->select($query);

                $i=0;

                foreach($registro as $row ){
                    $nombre_descripcion = $row->codigo_prestacion;
                    if ($nombre_descripcion == "P3160930"){
                        $nombre_descripcion = "REHABILITACION PULMONAR";
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
                    <td align='right'><?php echo number_format($row->Col37,0,",",".")?></td>
                    <?php
                    $i++;
                }
                ?>
                </tr>
            </tbody>
        </table>
    </div>

    <br>

    <!-- SECCION C -->
    <div class="col-sm tab table-responsive" id="D">
        <table class="table table-hover table-bordered table-sm">
            <thead>
                <tr>
                    <td colspan="39" class="active"><strong>SECCION D: NIVEL DE CONTROL DE POBLACION RESPIRATORIA CRONICA.</strong></td>
                </tr>
                <tr>
                    <td colspan='2' rowspan='3' style="text-align:center; vertical-align:middle"><strong>PROGRAMAS</strong></td>
                    <td colspan='3' rowspan='2' style="text-align:center; vertical-align:middle"><strong>TOTAL</strong></td>
                    <td colspan='34' align='center'><strong>GRUPOS DE EDAD (en años) Y SEXO</strong></td>
                </tr>
                <tr>
                    <td colspan='2' align='center'><strong>0 a 4 años</strong></td>
                    <td colspan='2' align='center'><strong>5 a 9 años</strong></td>
                    <td colspan='2' align='center'><strong>10 a 14 años</strong></td>
                    <td colspan='2' align='center'><strong>15 a 19 años</strong></td>
                    <td colspan='2' align='center'><strong>20 a 24 años</strong></td>
                    <td colspan='2' align='center'><strong>25 a 29 años</strong></td>
                    <td colspan='2' align='center'><strong>30 a 34 años</strong></td>
                    <td colspan='2' align='center'><strong>35 a 39 años</strong></td>
                    <td colspan='2' align='center'><strong>40 a 44 años</strong></td>
                    <td colspan='2' align='center'><strong>45 a 49 años</strong></td>
                    <td colspan='2' align='center'><strong>50 a 54 años</strong></td>
                    <td colspan='2' align='center'><strong>55 a 59 años</strong></td>
                    <td colspan='2' align='center'><strong>60 a 64 años</strong></td>
                    <td colspan='2' align='center'><strong>65 a 69 años</strong></td>
                    <td colspan='2' align='center'><strong>70 a 74 años</strong></td>
                    <td colspan='2' align='center'><strong>75 a 79 años</strong></td>
                    <td colspan='2' align='center'><strong>80 y más</strong></td>
                </tr>
                <tr>
                    <td align='center'><strong>Ambos sexos</strong></td>
                    <td align='center'><strong>Hombres</strong></td>
                    <td align='center'><strong>Mujeres</strong></td>
                    <td align='center'><strong>Hombres</strong></td>
                    <td align='center'><strong>Mujeres</strong></td>
                    <td align='center'><strong>Hombres</strong></td>
                    <td align='center'><strong>Mujeres</strong></td>
                    <td align='center'><strong>Hombres</strong></td>
                    <td align='center'><strong>Mujeres</strong></td>
                    <td align='center'><strong>Hombres</strong></td>
                    <td align='center'><strong>Mujeres</strong></td>
                    <td align='center'><strong>Hombres</strong></td>
                    <td align='center'><strong>Mujeres</strong></td>
                    <td align='center'><strong>Hombres</strong></td>
                    <td align='center'><strong>Mujeres</strong></td>
                    <td align='center'><strong>Hombres</strong></td>
                    <td align='center'><strong>Mujeres</strong></td>
                    <td align='center'><strong>Hombres</strong></td>
                    <td align='center'><strong>Mujeres</strong></td>
                    <td align='center'><strong>Hombres</strong></td>
                    <td align='center'><strong>Mujeres</strong></td>
                    <td align='center'><strong>Hombres</strong></td>
                    <td align='center'><strong>Mujeres</strong></td>
                    <td align='center'><strong>Hombres</strong></td>
                    <td align='center'><strong>Mujeres</strong></td>
                    <td align='center'><strong>Hombres</strong></td>
                    <td align='center'><strong>Mujeres</strong></td>
                    <td align='center'><strong>Hombres</strong></td>
                    <td align='center'><strong>Mujeres</strong></td>
                    <td align='center'><strong>Hombres</strong></td>
                    <td align='center'><strong>Mujeres</strong></td>
                    <td align='center'><strong>Hombres</strong></td>
                    <td align='center'><strong>Mujeres</strong></td>
                    <td align='center'><strong>Hombres</strong></td>
                    <td align='center'><strong>Mujeres</strong></td>
                    <td align='center'><strong>Hombres</strong></td>
                    <td align='center'><strong>Mujeres</strong></td>
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
                          FROM (select c.* from 2020prestaciones c where c.codigo_prestacion in("P3161041","P3161042","P3161043","P3161044",
                                                                                                "P3161045","P3161046","P3161047") AND c.serie = "P") a
                          left join 2020rems b on (a.id_prestacion=b.prestacion_id_prestacion)
                          AND (b.Mes in ('.$mes.')) AND (b.establecimiento_id_establecimiento in ('.$estab.'))
                          group by  a.codigo_prestacion,a.descripcion,a.id_prestacion
                          order by a.id_prestacion';
                $registro = DB::connection('mysql_rem')->select($query);

                $i=0;

                foreach($registro as $row ){
                    $nombre_descripcion = $row->codigo_prestacion;
                    if ($nombre_descripcion == "P3161041"){
                        $nombre_descripcion = "Controlado";
                    }
                    if ($nombre_descripcion == "P3161042"){
                        $nombre_descripcion = "Parcialmente Controlado";
                    }
                    if ($nombre_descripcion == "P3161043"){
                        $nombre_descripcion = "No Controlado";
                    }
                    if ($nombre_descripcion == "P3161044"){
                        $nombre_descripcion = "No evaluada";
                    }

                    if ($nombre_descripcion == "P3161045"){
                        $nombre_descripcion = "Logra Control Adecuado";
                    }
                    if ($nombre_descripcion == "P3161046"){
                        $nombre_descripcion = "No Logra Control Adecuado";
                    }
                    if ($nombre_descripcion == "P3161047"){
                        $nombre_descripcion = "No evaluada";
                    }
                    ?>
                <tr>
                    <?php
                    if($i==0){?>
                    <td rowspan="4" style="text-align:center; vertical-align:middle">ASMA BRONQUIAL</td>
                    <?php
                    }
                    if($i==4){?>
                    <td rowspan="3" style="text-align:center; vertical-align:middle">ENFERMEDAD PULMONAR OBSTRUCTIVA CRÓNICA (EPOC)</td>
                    <?php
                    }
                    ?>
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
                    <td align='right'><?php echo number_format($row->Col37,0,",",".")?></td>
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
