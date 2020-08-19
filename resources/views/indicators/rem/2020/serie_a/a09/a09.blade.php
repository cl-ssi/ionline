@extends('layouts.app')

@section('title', 'Resumen Estadistico Mensual')

@section('content')

<?php

use Illuminate\Support\Facades\DB;

?>

@include('indicators.rem.partials.nav')

<h3>REM-A9. ATENCIÓN DE SALUD ODONTOLÓGICA EN APS Y ESPECIALIDADES.</h3>

<br>

@include('indicators.rem.2020.serie_a.search')

<?php
//(isset($establecimientos) AND isset($periodo)));

if (in_array(0, $establecimientos) AND in_array(0, $periodo)){
    ?>
    @include('indicators.rem.partials.legend')
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
                    <td colspan="35" class="active"><strong>SECCIÓN A: CONSULTAS Y CONTROLES ODONTOLÓGICOS.</strong></td>
                </tr>
                <tr>
                    <td rowspan="3" style="text-align:center; vertical-align:middle"><strong>ACTIVIDAD</strong></td>
                    <td colspan="3" rowspan="2" style="text-align:center; vertical-align:middle"><strong>TOTAL</strong></td>
                    <td colspan="24" align="center"><strong>SEGÚN GRUPOS DE EDAD O DE RIESGO</strong></td>
                    <td rowspan="3" align="center"><strong>EMBARAZADAS</strong></td>
                    <td rowspan="3" align="center"><strong>60 AÑOS (INCLUÍDO EN GRUPOS DE 20-64 AÑOS)</strong></td>
                    <td rowspan="3" align="center"><strong>USUARIOS EN SITUACIÓN DE DISCAPACIDAD</strong></td>
                    <td rowspan="3" align="center"><strong>NIÑOS, NIÑAS, ADOLESCENTES Y JÓVENES POBLACIÓN SENAME</strong></td>
                    <td rowspan="3" align="center"><strong>MIGRANTES</strong></td>
                </tr>
                <tr>
                    <td colspan="2" align="center"><strong>Menos de 1 año</strong></td>
                    <td colspan="2" align="center"><strong>1 año</strong></td>
                    <td colspan="2" align="center"><strong>2 años</strong></td>
                    <td colspan="2" align="center"><strong>3 años</strong></td>
                    <td colspan="2" align="center"><strong>4 años</strong></td>
                    <td colspan="2" align="center"><strong>5 años</strong></td>
                    <td colspan="2" align="center"><strong>6 años</strong></td>
                    <td colspan="2" align="center"><strong>12 años</strong></td>
                    <td colspan="2" align="center"><strong>Resto <15 años</strong></td>
                    <td colspan="2" align="center"><strong>15-19 años</strong></td>
                    <td colspan="2" align="center"><strong>20-64 años</strong></td>
                    <td colspan="2" align="center"><strong>65 y más años</strong></td>
                </tr>
                <tr>
                    <td align="center"><strong>Ambos&nbsp;Sexos</strong></td>
                    <td align="center"><strong>Hombres</strong></td>
                    <td align="center"><strong>Mujeres</strong></td>
                    <td align="center"><strong>Hombres</strong></td>
                    <td align="center"><strong>Mujeres</strong></td>
                    <td align="center"><strong>Hombres</strong></td>
                    <td align="center"><strong>Mujeres</strong></td>
                    <td align="center"><strong>Hombres</strong></td>
                    <td align="center"><strong>Mujeres</strong></td>
                    <td align="center"><strong>Hombres</strong></td>
                    <td align="center"><strong>Mujeres</strong></td>
                    <td align="center"><strong>Hombres</strong></td>
                    <td align="center"><strong>Mujeres</strong></td>
                    <td align="center"><strong>Hombres</strong></td>
                    <td align="center"><strong>Mujeres</strong></td>
                    <td align="center"><strong>Hombres</strong></td>
                    <td align="center"><strong>Mujeres</strong></td>
                    <td align="center"><strong>Hombres</strong></td>
                    <td align="center"><strong>Mujeres</strong></td>
                    <td align="center"><strong>Hombres</strong></td>
                    <td align="center"><strong>Mujeres</strong></td>
                    <td align="center"><strong>Hombres</strong></td>
                    <td align="center"><strong>Mujeres</strong></td>
                    <td align="center"><strong>Hombres</strong></td>
                    <td align="center"><strong>Mujeres</strong></td>
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
                              ,sum(ifnull(b.Col25,0)) Col25
                              ,sum(ifnull(b.Col26,0)) Col26
                              ,sum(ifnull(b.Col27,0)) Col27
                              ,sum(ifnull(b.Col28,0)) Col28
                              ,sum(ifnull(b.Col29,0)) Col29
                              ,sum(ifnull(b.Col30,0)) Col30
                              ,sum(ifnull(b.Col31,0)) Col31
                              ,sum(ifnull(b.Col32,0)) Col32
                          FROM (select c.* from 2020prestaciones c where c.codigo_prestacion in("09400082","09400081","09230300","09400084")) a
                          left join 2020rems b on (a.id_prestacion=b.prestacion_id_prestacion)
                          AND (b.Mes in ('.$mes.')) AND (b.establecimiento_id_establecimiento in ('.$estab.'))
                          group by a.codigo_prestacion, a.descripcion, a.id_prestacion
                          order by a.id_prestacion';
                $registro = DB::connection('mysql_rem')->select($query);

                $i=0;

                foreach($registro as $row ){
                    $nombre_descripcion = $row->codigo_prestacion;
                    if ($nombre_descripcion == "09400082"){
                        $nombre_descripcion = "CONSULTA DE MORBILIDAD";
      							}
      							if ($nombre_descripcion == "09400081"){
                        $nombre_descripcion = "CONTROL ODONTOLÓGICO";
      							}
      							if ($nombre_descripcion == "09230300"){
                        $nombre_descripcion = "CONSULTA DE URGENCIA (GES)";
      							}
      							if ($nombre_descripcion == "09400084"){
                        $nombre_descripcion = "INASISTENCIA A CONSULTA";
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
                    <td colspan="35" class="active"><strong>SECCIÓN B: OTRAS ACTIVIDADES DE ODONTOLOGÍA GENERAL.</strong></td>
                </tr>
                <tr>
                    <td rowspan="2" style="text-align:center; vertical-align:middle"><strong>TIPO DE ACTIVIDAD</strong></td>
                    <td colspan="3" style="text-align:center; vertical-align:middle"><strong>TOTAL</strong></td>
                    <td colspan="2" align="center"><strong>Menos de 1 año</strong></td>
                    <td colspan="2" align="center"><strong>1 año</strong></td>
                    <td colspan="2" align="center"><strong>2 años</strong></td>
                    <td colspan="2" align="center"><strong>3 años</strong></td>
                    <td colspan="2" align="center"><strong>4 años</strong></td>
                    <td colspan="2" align="center"><strong>5 años</strong></td>
                    <td colspan="2" align="center"><strong>6 años</strong></td>
                    <td colspan="2" align="center"><strong>12 años</strong></td>
                    <td colspan="2" align="center"><strong>Resto <15 años</strong></td>
                    <td colspan="2" align="center"><strong>15-19 años</strong></td>
                    <td colspan="2" align="center"><strong>20-64 años</strong></td>
                    <td colspan="2" align="center"><strong>65 y más años</strong></td>
                    <td rowspan="2" align="center"><strong>EMBARAZADAS</strong></td>
                    <td rowspan="2" align="center"><strong>BENEFICIARIOS</strong></td>
                    <td rowspan="2" align="center"><strong>60 AÑOS (INCLUÍDO EN GRUPOS DE 20-64 AÑOS)</strong></td>
                    <td rowspan="2" align="center"><strong>COMPRA DE SERVICIO</strong></td>
                    <td rowspan="2" align="center"><strong>USUARIOS EN SITUACIÓN DE DISCAPACIDAD</strong></td>
                    <td rowspan="2" align="center"><strong>NIÑOS, NIÑAS, ADOLESCENTES Y JÓVENES POBLACIÓN SENAME</strong></td>
                    <td rowspan="2" align="center"><strong>MIGRANTES</strong></td>
                </tr>
                <tr>
                    <td align="center"><strong>Ambos&nbsp;Sexos</strong></td>
                    <td align="center"><strong>Hombres</strong></td>
                    <td align="center"><strong>Mujeres</strong></td>
                    <td align="center"><strong>Hombres</strong></td>
                    <td align="center"><strong>Mujeres</strong></td>
                    <td align="center"><strong>Hombres</strong></td>
                    <td align="center"><strong>Mujeres</strong></td>
                    <td align="center"><strong>Hombres</strong></td>
                    <td align="center"><strong>Mujeres</strong></td>
                    <td align="center"><strong>Hombres</strong></td>
                    <td align="center"><strong>Mujeres</strong></td>
                    <td align="center"><strong>Hombres</strong></td>
                    <td align="center"><strong>Mujeres</strong></td>
                    <td align="center"><strong>Hombres</strong></td>
                    <td align="center"><strong>Mujeres</strong></td>
                    <td align="center"><strong>Hombres</strong></td>
                    <td align="center"><strong>Mujeres</strong></td>
                    <td align="center"><strong>Hombres</strong></td>
                    <td align="center"><strong>Mujeres</strong></td>
                    <td align="center"><strong>Hombres</strong></td>
                    <td align="center"><strong>Mujeres</strong></td>
                    <td align="center"><strong>Hombres</strong></td>
                    <td align="center"><strong>Mujeres</strong></td>
                    <td align="center"><strong>Hombres</strong></td>
                    <td align="center"><strong>Mujeres</strong></td>
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
                          FROM (select c.* from 2020prestaciones c where c.codigo_prestacion in("09204918","09230500","09200313","09200513","09204919","09200725",
                                                                                                "09400085","09200735","09201225","09200813","09400086","09400087",
                                                                                                "09400088","09204922","09204924","09400089","09201713")) a
                          left join 2020rems b on (a.id_prestacion=b.prestacion_id_prestacion)
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

                    $nombre_descripcion = $row->codigo_prestacion;
                    if ($nombre_descripcion == "09204918"){
                        $nombre_descripcion = "EDUCACIÓN INDIVIDUAL CON INSTRUCCIÓN DE TÉCNICA DE CEPILLADO";
      							}
      							if ($nombre_descripcion == "09230500"){
                        $nombre_descripcion = "CONSEJERÍA BREVE EN TABACO";
      							}

      							if ($nombre_descripcion == "09200313"){
                        $nombre_descripcion = "EXAMEN DE SALUD ORAL";
      							}
      							if ($nombre_descripcion == "09200513"){
                        $nombre_descripcion = "APLICACIÓN DE SELLANTES";
      							}
      							if ($nombre_descripcion == "09204919"){
                        $nombre_descripcion = "FLUORURACIÓN TÓPICA BARNIZ";
      							}
      							if ($nombre_descripcion == "09200725"){
                        $nombre_descripcion = "PULIDO CORONARIO";
      							}
      							if ($nombre_descripcion == "09400085"){
                        $nombre_descripcion = "ACTIVIDAD INTERCEPTIVA DE ANOMALÍAS DENTO MAXILARES (OPI)";
      							}
      							if ($nombre_descripcion == "09200735"){
                        $nombre_descripcion = "DESTARTRAJE SUPRAGINGIVAL";
      							}
      							if ($nombre_descripcion == "09201225"){
                        $nombre_descripcion = "EXODONCIA";
      							}
      							if ($nombre_descripcion == "09200813"){
                        $nombre_descripcion = "PULPOTOMÍA";
      							}
      							if ($nombre_descripcion == "09400086"){
                        $nombre_descripcion = "RESTAURACIÓN PROVISORIA";
      							}
      							if ($nombre_descripcion == "09400087"){
                        $nombre_descripcion = "RESTAURACIÓN ESTÉTICA";
      							}
      							if ($nombre_descripcion == "09400088"){
                        $nombre_descripcion = "RESTAURACIÓN DE AMALGAMAS";
      							}
      							if ($nombre_descripcion == "09204922"){
                        $nombre_descripcion = "OBTURACIONES DE VIDIRIO IONÓMERO EN DIENTE TEMPORAL";
      							}
      							if ($nombre_descripcion == "09204924"){
                        $nombre_descripcion = "DESTARTRAJE SUBGINGIVAL Y PULIDO RADICULAR POR SEXTANTE";
      							}

      							if ($nombre_descripcion == "09400089"){
                        $nombre_descripcion = "PROCEDIMIENTOS MÉDICO-QUIRÚRGICOS";
      							}
      							if ($nombre_descripcion == "09201713"){
                        $nombre_descripcion = "RADIOGRAFÍA INTRAORAL (RETROALVEOLARES, BITE WING Y OCLUSALES)";
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
                    <td colspan="34" class="active"><strong>SECCIÓN C: INGRESOS Y EGRESOS  EN ESTABLECIMIENTOS APS.</strong></td>
                </tr>
                <tr>
                    <td colspan="2" rowspan="3" style="text-align:center; vertical-align:middle"><strong>TIPO DE INGRESO O EGRESO</strong></td>
                    <td colspan="3" rowspan="2" align="center"><strong>TOTAL</strong></td>
                    <td colspan="24" align="center"><strong>Según grupos de edad o de riesgo</strong></td>
                    <td rowspan="3" align="center"><strong>EMBARAZADAS</strong></td>
                    <td rowspan="3" align="center"><strong>60 AÑOS (INCLUÍDO EN GRUPOS DE 20-64 AÑOS)</strong></td>
                    <td rowspan="3" align="center"><strong>USUARIOS EN SITUACIÓN DE DISCAPACIDAD</strong>*</td>
                    <td rowspan="3" align="center"><strong>NIÑOS, NIÑAS, ADOLESCENTES Y JÓVENES POBLACIÓN SENAME</strong></td>
                    <td rowspan="3" align="center"><strong>MIGRANTES</strong></td>
                </tr>
                <tr>
                    <td colspan="2" align="center"><strong>Menos de 1 año</strong></td>
                    <td colspan="2" align="center"><strong>1 año</strong></td>
                    <td colspan="2" align="center"><strong>2 años</strong></td>
                    <td colspan="2" align="center"><strong>3 años</strong></td>
                    <td colspan="2" align="center"><strong>4 años</strong></td>
                    <td colspan="2" align="center"><strong>5 años</strong></td>
                    <td colspan="2" align="center"><strong>6 años</strong></td>
                    <td colspan="2" align="center"><strong>12 años</strong></td>
                    <td colspan="2" align="center"><strong>Resto <15 años</strong></td>
                    <td colspan="2" align="center"><strong>15-19 años</strong></td>
                    <td colspan="2" align="center"><strong>20-64 años</strong></td>
                    <td colspan="2" align="center"><strong>65 y más años</strong></td>
                </tr>
                <tr>
                    <td align="center"><strong>Ambos&nbsp;Sexos</strong></td>
                    <td align="center"><strong>Hombres</strong></td>
                    <td align="center"><strong>Mujeres</strong></td>
                    <td align="center"><strong>Hombres</strong></td>
                    <td align="center"><strong>Mujeres</strong></td>
                    <td align="center"><strong>Hombres</strong></td>
                    <td align="center"><strong>Mujeres</strong></td>
                    <td align="center"><strong>Hombres</strong></td>
                    <td align="center"><strong>Mujeres</strong></td>
                    <td align="center"><strong>Hombres</strong></td>
                    <td align="center"><strong>Mujeres</strong></td>
                    <td align="center"><strong>Hombres</strong></td>
                    <td align="center"><strong>Mujeres</strong></td>
                    <td align="center"><strong>Hombres</strong></td>
                    <td align="center"><strong>Mujeres</strong></td>
                    <td align="center"><strong>Hombres</strong></td>
                    <td align="center"><strong>Mujeres</strong></td>
                    <td align="center"><strong>Hombres</strong></td>
                    <td align="center"><strong>Mujeres</strong></td>
                    <td align="center"><strong>Hombres</strong></td>
                    <td align="center"><strong>Mujeres</strong></td>
                    <td align="center"><strong>Hombres</strong></td>
                    <td align="center"><strong>Mujeres</strong></td>
                    <td align="center"><strong>Hombres</strong></td>
                    <td align="center"><strong>Mujeres</strong></td>
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
                              ,sum(ifnull(b.Col25,0)) Col25
                              ,sum(ifnull(b.Col26,0)) Col26
                              ,sum(ifnull(b.Col27,0)) Col27
                              ,sum(ifnull(b.Col28,0)) Col28
                              ,sum(ifnull(b.Col29,0)) Col29
                              ,sum(ifnull(b.Col30,0)) Col30
                              ,sum(ifnull(b.Col31,0)) Col31
                              ,sum(ifnull(b.Col32,0)) Col32
                          FROM (select c.* from 2020prestaciones c where c.codigo_prestacion in("09215013","09215014","09215015")) a
                          left join 2020rems b on (a.id_prestacion=b.prestacion_id_prestacion)
                          AND (b.Mes in ('.$mes.')) AND (b.establecimiento_id_establecimiento in ('.$estab.'))
                          group by a.codigo_prestacion, a.descripcion, a.id_prestacion
                          order by a.id_prestacion';
                $registro = DB::connection('mysql_rem')->select($query);

                $i=0;

                foreach($registro as $row ){
                    $nombre_descripcion = $row->codigo_prestacion;

                    if ($nombre_descripcion == "09215013"){
                        $nombre_descripcion = "INGRESO A TRATAMIENTO ODNTOLOGÍA GENERAL";
      							}
      							if ($nombre_descripcion == "09215014"){
                        $nombre_descripcion = "INGRESO CONTROL CON ENFOQUE RIESGO ODONTOLÓGICO (CERO)";
      							}
      							if ($nombre_descripcion == "09215015"){
                        $nombre_descripcion = "EGRESO CONTROL CON ENFOQUE RIESGO ODONTOLÓGICO (CERO)";
      							}
                    ?>
                <tr>
                    <td align='left' colspan="2" nowrap="nowrap"><?php echo $nombre_descripcion; ?></td>
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
                    <?php
                    $i++;
                }
                ?>
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
                          FROM (select c.* from 2020prestaciones c where c.codigo_prestacion in("09215313","09215413")) a
                          left join 2020rems b on (a.id_prestacion=b.prestacion_id_prestacion)
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

                    $nombre_descripcion = $row->codigo_prestacion;
                    if ($nombre_descripcion == "09215313"){
                        $nombre_descripcion = "ALTAS ODONTOLÓGICAS PREVENTIVAS";
      							}
      							if ($nombre_descripcion == "09215413"){
                        $nombre_descripcion = "ALTAS ODONTOLÓGICAS INTEGRALES (EXCLUYE SECCIÓN G)";
      							}
                    ?>
                <tr>
                    <td align='left' colspan="2" nowrap="nowrap"><?php echo $nombre_descripcion; ?></td>
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
                    <?php
                    $i++;
                }
                ?>
                </tr>
                <tr>
                    <td align='left' colspan="2"><strong>ALTAS ODONTOLÓGICAS TOTALES</strong></td>
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
                          FROM (select c.* from 2020prestaciones c where c.codigo_prestacion in("09300300")) a
                          left join 2020rems b on (a.id_prestacion=b.prestacion_id_prestacion)
                          AND (b.Mes in ('.$mes.')) AND (b.establecimiento_id_establecimiento in ('.$estab.'))
                          group by a.codigo_prestacion, a.descripcion, a.id_prestacion
                          order by a.id_prestacion';
                $registro = DB::connection('mysql_rem')->select($query);

                $i=0;

                foreach($registro as $row ){

                    $nombre_descripcion = $row->codigo_prestacion;
                    if ($nombre_descripcion == "09300300"){
                        $nombre_descripcion = "EGRESOS POR ABANDONO	";
      							}
                    ?>
                <tr>
                    <td align='left' colspan="2" nowrap="nowrap"><?php echo $nombre_descripcion; ?></td>
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
                    <?php
                    $i++;
                }
                ?>
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
                          FROM (select c.* from 2020prestaciones c where c.codigo_prestacion in("09220100","09220150","09220250","09220350","09220450","09220500")) a
                          left join 2020rems b on (a.id_prestacion=b.prestacion_id_prestacion)
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

                    $nombre_descripcion = $row->codigo_prestacion;
                    if ($nombre_descripcion == "09220100"){
                        $nombre_descripcion = "0";
      							}
      							if ($nombre_descripcion == "09220150"){
                        $nombre_descripcion = "1 a 2";
      							}
      							if ($nombre_descripcion == "09220250"){
                        $nombre_descripcion = "3 a 4";
      							}
      							if ($nombre_descripcion == "09220350"){
                        $nombre_descripcion = "5 a 6";
      							}
      							if ($nombre_descripcion == "09220450"){
                        $nombre_descripcion = "7 a 8";
      							}
      							if ($nombre_descripcion == "09220500"){
                        $nombre_descripcion = "9 o más";
      							}
                    ?>
                <tr>
                    <?php
                    if($i==0){?>
                    <td align='left' rowspan="7" style="text-align:center; vertical-align:middle">ÍNDICE ceod O COPD EN PACIENTES INGRESADOS (Índice ceod se usa en menores de 7 años, para resto se utiliza COPD).</td>
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
                          FROM (select c.* from 2020prestaciones c where c.codigo_prestacion in("09600100","09600101","09600102")) a
                          left join 2020rems b on (a.id_prestacion=b.prestacion_id_prestacion)
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

                    $nombre_descripcion = $row->codigo_prestacion;

                    if ($nombre_descripcion == "09600100"){
                        $nombre_descripcion = "0";
      							}
      							if ($nombre_descripcion == "09600101"){
                        $nombre_descripcion = "1,2,3";
      							}
      							if ($nombre_descripcion == "09600102"){
                        $nombre_descripcion = "4 y *";
      							}
                    ?>
                <tr>
                    <?php
                    if($i==0){?>
                    <td align='left' rowspan="7" style="text-align:center; vertical-align:middle">CÓDIGO EXAMEN PERIODONTAL BASICO (EPB) EN PACIENTES INGRESADOS.</td>
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
                </tr>
            </tbody>
        </table>
    </div>

    <br>

    <div class="container">
    <!-- SECCION D -->
    <div class="col-sm tab table-responsive" id="D">
        <table class="table table-hover table-bordered table-sm">
            <thead>
                <tr>
                    <td colspan="8" class="active"><strong>SECCIÓN D: INTERCONSULTAS GENERADAS EN ESTABLECIMIENTOS APS.</strong></td>
                </tr>
                <tr>
                    <td colspan='2' align='center'><strong>ESPECIALIDAD</strong></td>
                    <td align='center'><strong>TOTAL</strong></td>
                    <td align='center'><strong>GESTANTES</strong></td>
                    <td align='center'><strong>60 AÑOS</strong></td>
                    <td align='center'><strong>USUARIOS EN SITUACIÓN DE DISCAPACIDAD</strong></td>
                    <td align='center'><strong>NIÑOS, NIÑAS, ADOLESCENTES Y JÓVENES RED SENAME</strong></td>
                    <td align='center'><strong>MIGRANTES</strong></td>
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
                          FROM (select c.* from 2020prestaciones c where c.codigo_prestacion in("09204926","09260100","09400030","09204929","09204931","09204933",
                                                                                                "09204934","09310700","09305400","09305500","09310800")) a
                          left join 2020rems b on (a.id_prestacion=b.prestacion_id_prestacion)
                          AND (b.Mes in ('.$mes.')) AND (b.establecimiento_id_establecimiento in ('.$estab.'))
                          group by a.codigo_prestacion, a.descripcion, a.id_prestacion
                          order by a.id_prestacion';
                $registro = DB::connection('mysql_rem')->select($query);

                $i=0;

                foreach($registro as $row ){
                    $nombre_descripcion = $row->codigo_prestacion;

                    if ($nombre_descripcion == "09204926"){
                        $nombre_descripcion = "ENDODONCIA";
      							}
      							if ($nombre_descripcion == "09260100"){
                        $nombre_descripcion = "PRÓTESIS REMOVIBLES";
      							}
      							if ($nombre_descripcion == "09400030"){
                        $nombre_descripcion = "PRÓTESIS FIJA";
      							}
      							if ($nombre_descripcion == "09204929"){
                        $nombre_descripcion = "CIRUGÍA BUCAL Y TRAUMATOLOGÍA MAXILOFACIAL";
      							}
      							if ($nombre_descripcion == "09204931"){
                        $nombre_descripcion = "ODONTOPEDIATRÍA";
      							}
      							if ($nombre_descripcion == "09204933"){
                        $nombre_descripcion = "ORTODONCIA";
      							}
      							if ($nombre_descripcion == "09204934"){
                        $nombre_descripcion = "PERIODONCIA";
      							}
      							if ($nombre_descripcion == "09310700"){
                        $nombre_descripcion = "IMAGENOLOGÍA ORAL Y MAXILOFACIAL";
      							}
      							if ($nombre_descripcion == "09305400"){
                        $nombre_descripcion = "PATOLOGÍA ORAL";
      							}
      							if ($nombre_descripcion == "09305500"){
                        $nombre_descripcion = "IMPLANTOLOGÍA BUCO MAXILOFACIAL";
      							}
      							if ($nombre_descripcion == "09310800"){
                        $nombre_descripcion = "TRASTORNOS TEMPOROMANDIBULARES Y DOLOR OROFACIAL";
      							}
                    ?>
                <tr>
                    <?php
                    if($i==0){?>
                    <td colspan="2" align='left' nowrap="nowrap"><?php echo $nombre_descripcion; ?></td>
                    <?php
                    }
                    if($i==1){?>
                    <td rowspan="2" style="text-align:center; vertical-align:middle" nowrap="nowrap">REHABILITACIÓN ORAL</td>
                    <td align='left' nowrap="nowrap"><?php echo $nombre_descripcion; ?></td>
                    <?php
                    }
                    if($i==2){?>
                    <td align='left' nowrap="nowrap"><?php echo $nombre_descripcion; ?></td>
                    <?php
                    }
                    if($i>=3){?>
                    <td align='left' colspan="2" nowrap="nowrap"><?php echo $nombre_descripcion; ?></td>
                    <?php
                    }
                    ?>
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

    <div class="col-sm tab table-responsive" id="E">
        <table class="table table-hover table-bordered table-sm">
            <thead>
                <tr>
                    <td colspan="5" class="active"><strong>SECCIÓN E: CONSULTAS ODONTOLÓGICAS  EN HORARIO CONTINUADO (incluidas en  Secciones A y B. Excluye extensiones horarias de Sección G ).</strong></td>
                </tr>
                <tr>
                    <td rowspan='2' colspan='2' style="text-align:center; vertical-align:middle"><strong>JORNADA</strong></td>
                    <td colspan='3' align='center'><strong>CONSULTAS</strong></td>
                </tr>
                <tr>
                    <td align='center'><strong>TOTAL</strong></td>
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
                          FROM (select c.* from 2020prestaciones c where c.codigo_prestacion in("09230100","09230200")) a
                          left join 2020rems b on (a.id_prestacion=b.prestacion_id_prestacion)
                          AND (b.Mes in ('.$mes.')) AND (b.establecimiento_id_establecimiento in ('.$estab.'))
                          group by a.codigo_prestacion, a.descripcion, a.id_prestacion
                          order by a.id_prestacion';
                $registro = DB::connection('mysql_rem')->select($query);

                $i=0;

                foreach($registro as $row ){
                    $nombre_descripcion = $row->codigo_prestacion;

                    if ($nombre_descripcion == "09230100"){
                        $nombre_descripcion = "VESPERTINA (LUNES-VIERNES)";
      							}
      							if ($nombre_descripcion == "09230200"){
                        $nombre_descripcion = "SÁBADO, DOMINGO o FESTIVO";
      							}
                    ?>
                <tr>
                    <?php
      							if($i==0){?>
                    <td rowspan="2" style="text-align:center; vertical-align:middle" nowrap="nowrap">HORARIO CONTINUADO</td>
      							<?php
                    }
							      ?>
                    <td align='left' nowrap="nowrap"><?php echo $nombre_descripcion; ?></td>
                    <td align='right'><?php echo number_format($row->Col01,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col02,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col03,0,",",".")?></td>
                    <?php
                    $i++;
                }
                ?>
                </tr>
            </tbody>
        </table>
    </div>
    </div>

    <br>

    <div class="col-sm tab table-responsive" id="F">
        <table class="table table-hover table-bordered table-sm">
            <thead>
                <tr>
                    <td colspan="19" class="active"><strong>SECCIÓN F:  ACTIVIDADES DE ATENCIÓN EN ESPECIALIDADES ODONTOLÓGICAS.</strong></td>
                </tr>
                <tr>
              			<td rowspan="2" style="text-align:center; vertical-align:middle"><strong>ACTIVIDADES DE ESPECIALIDADES</strong></td>
              			<td colspan="3" align="center"><strong>TOTAL</strong></td>
              			<td colspan="8" align="center"><strong>Según grupos de edad o de riesgo</strong></td>
              			<td rowspan="2" style="text-align:center; vertical-align:middle"><strong>EMBARAZADAS</strong></td>
              			<td rowspan="2" style="text-align:center; vertical-align:middle"><strong>BENEFICIARIOS</strong></td>
              			<td rowspan="2" style="text-align:center; vertical-align:middle"><strong>60 AÑOS (INCLUÍDO EN GRUPOS DE 20-64 AÑOS)</strong></td>
              			<td rowspan="2" style="text-align:center; vertical-align:middle"><strong>COMPRA DE SERVICIO</strong></td>
              			<td rowspan="2" style="text-align:center; vertical-align:middle"><strong>USUARIOS EN SITUACIÓN DE DISCAPACIDAD</strong></td>
              			<td rowspan="2" style="text-align:center; vertical-align:middle"><strong>NIÑOS, NIÑAS, ADOLESCENTES Y JÓVENES RED SENAME</strong></td>
              			<td rowspan="2" style="text-align:center; vertical-align:middle"><strong>MIGRANTES</strong></td>
            		</tr>
            		<tr>
              			<td align="center"><strong>Ambos Sexos</strong></td>
              			<td align="center"><strong>Hombres</strong></td>
              			<td align="center"><strong>Mujeres</strong></td>
              			<td align="center"><strong>0-5 años</strong></td>
              			<td align="center"><strong>6 años</strong></td>
              			<td align="center"><strong>7 años</strong></td>
              			<td align="center"><strong>12 años</strong></td>
              			<td align="center"><strong>Resto <15 años</strong></td>
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
                          FROM (select c.* from 2020prestaciones c where c.codigo_prestacion in("09204935","09600110","09600111","09600112","09600113","09600114","09600115","09600116",
                                                                                                "09202813","09600117","09600118","09203213","09305700","09305800","09600119","09600120",
                                                                                                "09600121","09202725","09202735","09202745","09600122","09600123","09600124","09600125",
                                                                                                "09600126","09600127","09600128","09305600","09600129","09600130","09600131","09600132",
                                                                                                "09203425","09203435","09203313","09600133","09600134","09306000","09600135","09600136",
                                                                                                "09600137","09600138","09600139","09600140","09600141","09600142","09600143","09600144",
                                                                                                "09600145","09600146","09600147","09600148")) a
                          left join 2020rems b on (a.id_prestacion=b.prestacion_id_prestacion)
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

                    $nombre_descripcion = $row->codigo_prestacion;
                    if ($nombre_descripcion == "09204935"){
      							$nombre_descripcion = "EXAMEN Y DIAGNÓSTICO DE ESPECIALIDAD";
      							}
                    if ($nombre_descripcion == "09600110"){
      							$nombre_descripcion = "EDUCACIÓN EN SALUD BUCAL";
      							}
                    if ($nombre_descripcion == "09600111"){
      							$nombre_descripcion = "INTERCONSULTA HOSPITALIZADOS";
      							}
                    if ($nombre_descripcion == "09600112"){
      							$nombre_descripcion = "VISITA A SALA";
      							}
                    if ($nombre_descripcion == "09600113"){
      							$nombre_descripcion = "CONTRALORÍA CLÍNICA";
      							}
                    if ($nombre_descripcion == "09600114"){
      							$nombre_descripcion = "CIRUGÍA TERCER MOLAR";
      							}
                    if ($nombre_descripcion == "09600115"){
      							$nombre_descripcion = "CIRUGÍA MENOR AMBULATORIA";
      							}
                    if ($nombre_descripcion == "09600116"){
      							$nombre_descripcion = "CIRUGÍA MAYOR AMBULATORIA";
      							}
                    if ($nombre_descripcion == "09202813"){
      							$nombre_descripcion = "TRATAMIENTO TRAUMATISMO DENTOALVEOLAR";
      							}
                    if ($nombre_descripcion == "09600117"){
      							$nombre_descripcion = "OBTURACION DIRECTA";
      							}
                    if ($nombre_descripcion == "09600118"){
      							$nombre_descripcion = "OBTURACION INDIRECTA (INLAYS U ONLAYS)";
      							}
                    if ($nombre_descripcion == "09203213"){
      							$nombre_descripcion = "INSTALACIÓN APARATO REMOVIBLE ORTODONCICO";
      							}
                    if ($nombre_descripcion == "09305700"){
      							$nombre_descripcion = "INSTALACIÓN APARATO FIJO ORTODONCICO";
      							}
                    if ($nombre_descripcion == "09305800"){
      							$nombre_descripcion = "INSTALACIÓN APARATO DE CONTENCIÓN ORTODONCICO";
      							}
                    if ($nombre_descripcion == "09600119"){
      							$nombre_descripcion = "RETIRO APARATOLOGIA DE ORTODONCIA";
      							}
                    if ($nombre_descripcion == "09600120"){
      							$nombre_descripcion = "ORTOPEDIA PREQUIRURGICA";
      							}
                    if ($nombre_descripcion == "09600121"){
      							$nombre_descripcion = "ORTODONCIA PREVENTIVA E INTERCEPTIVA (OPI)";
      							}
                    if ($nombre_descripcion == "09202725"){
      							$nombre_descripcion = "TRATAMIENTO ENDODONCIA UNIRRADICULAR";
      							}
                    if ($nombre_descripcion == "09202735"){
      							$nombre_descripcion = "TRATAMIENTO ENDODONCIA BIRRADICULAR";
      							}
                    if ($nombre_descripcion == "09202745"){
      							$nombre_descripcion = "TRATAMIENTO ENDODONCIA MULTIRRADICULAR";
      							}
                    if ($nombre_descripcion == "09600122"){
      							$nombre_descripcion = "INDUCCION AL CIERRE APICAL";
      							}
                    if ($nombre_descripcion == "09600123"){
      							$nombre_descripcion = "RETRATAMIENTO";
      							}
                    if ($nombre_descripcion == "09600124"){
      							$nombre_descripcion = "CIRUGIA APICAL";
      							}
                    if ($nombre_descripcion == "09600125"){
      							$nombre_descripcion = "ADAPTACION A LA ATENCIÓN ODONTOLOGICA";
      							}
                    if ($nombre_descripcion == "09600126"){
      							$nombre_descripcion = "PROCEDIMIENTO RESTAURADOR (ODONTOPEDIATRIA)";
      							}
                    if ($nombre_descripcion == "09600127"){
      							$nombre_descripcion = "PROCEDIMIENTO ENDODONTICO (ODONTOPEDIATRIA)";
      							}
                    if ($nombre_descripcion == "09600128"){
      							$nombre_descripcion = "CIRUGIA AMBULATORIA (ODONTOPEDIATRIA)";
      							}
                    if ($nombre_descripcion == "09305600"){
      							$nombre_descripcion = "DESTARTRAJE SUBGINGIVAL O PULIDO RADICULAR";
      							}
                    if ($nombre_descripcion == "09600129"){
      							$nombre_descripcion = "DESTARTRAJE SUBGINGIVAL O PULIDO CORONARIO";
      							}
                    if ($nombre_descripcion == "09600130"){
      							$nombre_descripcion = "PROCEDIMIENTO QUIRURGICO (PERIODONCIA)";
      							}
                    if ($nombre_descripcion == "09600131"){
      							$nombre_descripcion = "PROCEDIMIENTO QUIRURGICO PERIIMPLANTAR (PERIODONCIA)";
      							}
                    if ($nombre_descripcion == "09600132"){
      							$nombre_descripcion = "FERULIZACION";
      							}

                    if ($nombre_descripcion == "09203425"){
      							$nombre_descripcion = "REHABILITACION MEDIANTE PROTESIS REMOVIBLE ACRILICA PARCIAL O TOTAL";
      							}
                    if ($nombre_descripcion == "09203435"){
      							$nombre_descripcion = "REHABILITACION MEDIANTE PROTESIS REMOVIBLE METALICA PARCIAL";
      							}
                    if ($nombre_descripcion == "09203313"){
      							$nombre_descripcion = "REHABILITACION MEDIANTE PROTESIS FIJA UNITARIA O PLURAL";
      							}
                    if ($nombre_descripcion == "09600133"){
      							$nombre_descripcion = "REHABILITACION MEDIANTE PROTESIS FIJA IMPLANTOSOPORTADA";
      							}
                    if ($nombre_descripcion == "09600134"){
      							$nombre_descripcion = "REHABILITACION MEDIANTE PROTESIS MUCO IMPLANTOSOPORTADA";
      							}
                    if ($nombre_descripcion == "09306000"){
      							$nombre_descripcion = "REPARACION PROTESIS";
      							}
                    if ($nombre_descripcion == "09600135"){
      							$nombre_descripcion = "IMPLANTOLOGIA QUIRURGICA";
      							}
                    if ($nombre_descripcion == "09600136"){
      							$nombre_descripcion = "IMPLANTOLOGIA PROTESICA";
      							}
                    if ($nombre_descripcion == "09600137"){
      							$nombre_descripcion = "TOMA DE BIOPSIA";
      							}
                    if ($nombre_descripcion == "09600138"){
      							$nombre_descripcion = "ESTUDIO HISTOPATOLÓGICO";
      							}
                    if ($nombre_descripcion == "09600139"){
      							$nombre_descripcion = "SIALOMETRIA";
      							}
                    if ($nombre_descripcion == "09600140"){
      							$nombre_descripcion = "TERAPIA FARMACOLÓGICA DE LESIONES DEL TERRITORIO BUCO MAXILOFACIAL";
      							}
                    if ($nombre_descripcion == "09600141"){
      							$nombre_descripcion = "TERAPIA FÍSICA EN TRASTORNOS TEMPOROMANDIBULARES (TTM) Y DOLOR OROFACIAL (DOF)";
      							}
                    if ($nombre_descripcion == "09600142"){
      							$nombre_descripcion = "INFILTRACIÓN EN ARTICULACIÓN TEMPORO MANDIBULAR (ATM)";
      							}
                    if ($nombre_descripcion == "09600143"){
      							$nombre_descripcion = "BLOQUEO ANESTÉSICO Y/O MEDICAMENTOSO EN TTM Y DOF";
      							}
                    if ($nombre_descripcion == "09600144"){
      							$nombre_descripcion = "ARTROCENTESIS EN ATM";
      							}
                    if ($nombre_descripcion == "09600145"){
      							$nombre_descripcion = "TERAPIA BIOCONDUCTUAL";
      							}
                    if ($nombre_descripcion == "09600146"){
      							$nombre_descripcion = "DESGASTE SELECTIVO";
      							}
                    if ($nombre_descripcion == "09600147"){
      							$nombre_descripcion = "INSTALACIÓN DE DISPOSITIVO ORTOPÉDICO";
      							}
                    if ($nombre_descripcion == "09600148"){
      							$nombre_descripcion = "ACTIVIDADES SOMATOPRÓTESIS";
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
                    <td align='right'><?php echo number_format($row->Col12,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col13,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col14,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col15,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col16,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col17,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col18,0,",",".")?></td>
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
                </tr>
            </tbody>
        </table>
    </div>

    <br>

    <div class="col-sm tab table-responsive" id="F1">
        <table class="table table-hover table-bordered table-sm">
            <thead>
                <tr>
                    <td colspan="19" class="active"><strong>SECCIÓN F.1: ACTIVIDADES DE APOYO EN ATENCIÓN DE ESPECIALIDADES.</strong></td>
                </tr>
                <tr>
                    <td rowspan="2" style="text-align:center; vertical-align:middle"><strong>ACTIVIDADES DE APOYO</strong></td>
                    <td colspan="3" style="text-align:center; vertical-align:middle"><strong>TOTAL</strong></td>
                    <td colspan="8" align="center"><strong>Según grupos de edad o de riesgo (En años)</strong></td>
                    <td rowspan="2" align="center"><strong>EMBARAZADAS</strong></td>
                    <td rowspan="2" align="center"><strong>BENEFICIARIOS</strong></td>
                    <td rowspan="2" align="center"><strong>60 AÑOS (INCLUÍDO EN GRUPOS DE 20-64 AÑOS)</strong></td>
                    <td rowspan="2" align="center"><strong>COMPRA DE SERVICIO</strong></td>
                    <td rowspan="2" align="center"><strong>USUARIOS EN SITUACIÓN DE DISCAPACIDAD</strong></td>
                    <td rowspan="2" align="center"><strong>NIÑOS, NIÑAS, ADOLESCENTES Y JÓVENES RED SENAME</strong></td>
                    <td rowspan="2" align="center"><strong>MIGRANTES</strong></td>
                </tr>
                <tr>
                    <td align="center"><strong>Ambos&nbsp;Sexos</strong></td>
                    <td align="center"><strong>Hombres</strong></td>
                    <td align="center"><strong>Mujeres</strong></td>
                    <td align="center"><strong>0&nbsp;-&nbsp;5&nbsp;años</strong></td>
                    <td align="center"><strong>6&nbsp;años</strong></td>
                    <td align="center"><strong>7&nbsp;años</strong></td>
                    <td align="center"><strong>12&nbsp;años</strong></td>
                    <td align="center"><strong>Resto&nbsp;&lt;15&nbsp;años</strong></td>
                    <td align="center"><strong>15&nbsp;-&nbsp;19&nbsp;años</strong></td>
                    <td align="center"><strong>20&nbsp;-&nbsp;64&nbsp;años</strong></td>
                    <td align="center"><strong>65&nbsp;y&nbsp;más&nbsp;años</strong></td>
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
                          FROM (select c.* from 2020prestaciones c where c.codigo_prestacion in("09600149","09203913","09306200","09306300","09306400","09306500","09204013","09600150")) a
                          left join 2020rems b on (a.id_prestacion=b.prestacion_id_prestacion)
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
    						$totalCol09=0;
    						$totalCol10=0;
    						$totalCol11=0;
    						$totalCol12=0;
    						$totalCol13=0;
    						$totalCol14=0;
    						$totalCol15=0;

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

                    $nombre_descripcion = $row->codigo_prestacion;

                    if ($nombre_descripcion == "09600149"){
                        $nombre_descripcion = "RADIOGRAFÍA INTRAORAL (POR PLACA)";
      							}
                    if ($nombre_descripcion == "09203913"){
                        $nombre_descripcion = "RADIOGRAFÍA EXTRAORAL (POR PLACA)";
      							}
      							if ($nombre_descripcion == "09306200"){
                        $nombre_descripcion = "RADIOGRAFÍA OCLUSAL (POR PLACA)";
      							}
      							if ($nombre_descripcion == "09306300"){
                        $nombre_descripcion = "TELERRADIOGRAFÍA";
      							}
      							if ($nombre_descripcion == "09306400"){
                        $nombre_descripcion = "RADIOGRAFÍA PANORÁMICA (POR PLACA)";
      							}
      							if ($nombre_descripcion == "09306500"){
                        $nombre_descripcion = "TOMOGRAFÍA COMPUTACIONAL MAXILO FACIAL CONE BEAM";
      							}
      							if ($nombre_descripcion == "09204013"){
                        $nombre_descripcion = "SIALOGRAFÍAS (procedimiento)";
      							}
                    if ($nombre_descripcion == "09600150"){
                        $nombre_descripcion = "PROCEDIMIENTO IMAGENOLÓGICO COMPLEJO (POR PROCEDIMIENTO)";
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
                    <td align='right'><?php echo number_format($row->Col12,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col13,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col14,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col15,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col16,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col17,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col18,0,",",".")?></td>
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
                </tr>
            </tbody>
        </table>
    </div>

    <br>

    <div class="col-sm tab table-responsive" id="G">
        <table class="table table-hover table-bordered table-sm">
            <thead>
                <tr>
                    <td colspan="20" class="active"><strong>SECCIÓN G: PROGRAMAS ESPECIALES Y GES (Actividades incluidas en Sección B).</strong></td>
                </tr>
                <tr>
                    <td colspan="3" rowspan="3" style="text-align:center; vertical-align:middle"><strong>PROGRAMA - ACTIVIDAD</strong></td>
                    <td colspan="3" rowspan="2" style="text-align:center; vertical-align:middle"><strong>TOTAL</strong></td>
                    <td colspan="8" align="center"><strong>Según grupos de edad o de riesgo</strong></td>
                    <td rowspan="3" align="center"><strong>COMPRA DE SERVICIO</strong></td>
                    <td rowspan="3" align="center"><strong>USUARIOS EN SITUACIÓN DE DISCAPACIDAD</strong></td>
                    <td rowspan="3" align="center"><strong>NIÑOS, NIÑAS, ADOLESCENTES Y JÓVENES RED SENAME</strong></td>
                    <td rowspan="3" align="center"><strong>MIGRANTES</strong></td>
                    <td rowspan="3" align="center"><strong>EGRESO POR ABANDONO</strong></td>
                    <td rowspan="3" align="center"><strong>PACIENTE DIABÉTICO EN CONTROL PSCV</strong></td>
                </tr>
                <tr>
                    <td colspan="2" align="center"><strong>Menor de 15 años</strong></td>
                    <td colspan="2" align="center"><strong>15-19 años</strong></td>
                    <td colspan="2" align="center"><strong>20-64 años</strong></td>
                    <td colspan="2" align="center"><strong>65 y más años</strong></td>
                </tr>
                <tr>
                    <td align="center"><strong>Ambos&nbsp;Sexos</strong></td>
                    <td align="center"><strong>Hombres</strong></td>
                    <td align="center"><strong>Mujeres</strong></td>
                    <td align="center"><strong>Hombres</strong></td>
                    <td align="center"><strong>Mujeres</strong></td>
                    <td align="center"><strong>Hombres</strong></td>
                    <td align="center"><strong>Mujeres</strong></td>
                    <td align="center"><strong>Hombres</strong></td>
                    <td align="center"><strong>Mujeres</strong></td>
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
                          FROM (select c.* from 2020prestaciones c where c.codigo_prestacion in("09306900","09202313","09202413")) a
                          left join 2020rems b on (a.id_prestacion=b.prestacion_id_prestacion)
                          AND (b.Mes in ('.$mes.')) AND (b.establecimiento_id_establecimiento in ('.$estab.'))
                          group by a.codigo_prestacion, a.descripcion, a.id_prestacion
                          order by a.id_prestacion';
                $registro = DB::connection('mysql_rem')->select($query);

                $i=0;

                foreach($registro as $row ){
                    $nombre_descripcion = $row->codigo_prestacion;

                    if ($nombre_descripcion == "09306900"){
      								$nombre_descripcion = "N°AUDITORÍAS CLÍNICAS REALIZADAS";
      							}
      							if ($nombre_descripcion == "09202313"){
      								$nombre_descripcion = "PRÓTESIS REMOVIBLES";
      							}
      							if ($nombre_descripcion == "09202413"){
      								$nombre_descripcion = "REPARACIÓN DE PRÓTESIS";
      							}
                    ?>
                <tr>
                    <?php
      							if($i==0){?>
      							<td rowspan="10" style="text-align:center; vertical-align:middle">PROGRAMA ODONTOLÓGICO INTEGRAL, ESTRATEGIA MÁS SONRISAS PARA CHILE</td>
      							<?php
                    }
      							?>
                    <td align='left' colspan="2" nowrap="nowrap"><?php echo $nombre_descripcion; ?></td>
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
                    <?php
                    $i++;
                }
                ?>
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
                          FROM (select c.* from 2020prestaciones c where c.codigo_prestacion in("09260500","09260600","09600103","09204944","09400092","09400093")) a
                          left join 2020rems b on (a.id_prestacion=b.prestacion_id_prestacion)
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
    						$totalCol09=0;
    						$totalCol10=0;
    						$totalCol11=0;
                $totalCol12=0;
                $totalCol13=0;
                $totalCol14=0;
                $totalCol15=0;
                $totalCol16=0;
                $totalCol17=0;

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
                }
                ?>
                <tr>
                    <?php
                    if($i==0){?>
                    <td rowspan="7" style="text-align:center; vertical-align:middle">ALTAS INTEGRALES</td>
                    <?php
                    }
                    ?>
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
                </tr>
                <?php
                foreach($registro as $row ){
                    $nombre_descripcion = $row->codigo_prestacion;

                    if ($nombre_descripcion == "09260500"){
        								$nombre_descripcion = "JUNJI-INTEGRA-MINEDUC";
      							}
      							if ($nombre_descripcion == "09260600"){
                        $nombre_descripcion = "SERNAM";
      							}
                    if ($nombre_descripcion == "09600103"){
                        $nombre_descripcion = "PRODEMU";
      							}
      							if ($nombre_descripcion == "09204944"){
                        $nombre_descripcion = "CHILE SOLIDARIO";
      							}
      							if ($nombre_descripcion == "09400092"){
                        $nombre_descripcion = "MINVU";
      							}
      							if ($nombre_descripcion == "09400093"){
                        $nombre_descripcion = "DEMANDA LOCAL";
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
                    <td align='right'><?php echo number_format($row->Col12,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col13,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col14,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col15,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col16,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col17,0,",",".")?></td>
                    <?php
                    $i++;
                }
                ?>
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
                          FROM (select c.* from 2020prestaciones c where c.codigo_prestacion in("09500500","09500503","09500501","09500502")) a
                          left join 2020rems b on (a.id_prestacion=b.prestacion_id_prestacion)
                          AND (b.Mes in ('.$mes.')) AND (b.establecimiento_id_establecimiento in ('.$estab.'))
                          group by a.codigo_prestacion, a.descripcion, a.id_prestacion
                          order by a.id_prestacion';
                $registro = DB::connection('mysql_rem')->select($query);

                $i=0;

                foreach($registro as $row ){
                    $nombre_descripcion = $row->codigo_prestacion;

                    if ($nombre_descripcion == "09500500"){
                        $nombre_descripcion = "PRÓTESIS REMOVIBLES";
      							}
                    if ($nombre_descripcion == "09500503"){
                        $nombre_descripcion = "TOTAL ALTAS INTEGRALES";
      							}
                    if ($nombre_descripcion == "09500501"){
                        $nombre_descripcion = "Nº DE AUDITORIAS CLÍNICAS REALIZADAS";
      							}
                    if ($nombre_descripcion == "09500502"){
                        $nombre_descripcion = "REPARACIÓN DE PROTESIS";
      							}
                    ?>
                <tr>
                    <?php
      							if($i==0){?>
      							<td rowspan="4" style="text-align:center; vertical-align:middle">PROGRAMA ODONTOLÓGICO INTEGRAL, HOMBRES DE ESCASOS RECURSOS</td>
                    <td rowspan="4" style="text-align:center; vertical-align:middle">ALTAS INTEGRALES/ACTIVIDADES</td>
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
                    <td align='right'><?php echo number_format($row->Col11,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col12,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col13,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col14,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col15,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col16,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col17,0,",",".")?></td>
                    <?php
                    $i++;
                }
                ?>
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
                          FROM (select c.* from 2020prestaciones c where c.codigo_prestacion in("09600151","09600152")) a
                          left join 2020rems b on (a.id_prestacion=b.prestacion_id_prestacion)
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
    						$totalCol09=0;
    						$totalCol10=0;
    						$totalCol11=0;
                $totalCol12=0;
                $totalCol13=0;
                $totalCol14=0;
                $totalCol15=0;
                $totalCol16=0;
                $totalCol17=0;


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
                }
                ?>

                <tr>
                    <?php
                    if($i==0){?>
                    <td rowspan="3" style="text-align:center; vertical-align:middle">PROGRAMA ODONTOLÓGICO INTEGRAL, ESTRATEGIA ATENCION ODONTOLOGICA EN DOMICILIO</td>
                    <td rowspan="3" style="text-align:center; vertical-align:middle">ALTAS ODONTOLOGICAS</td>
                    <?php
                    }
                    ?>
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
                </tr>

                <?php

                foreach($registro as $row ){
                    $nombre_descripcion = $row->codigo_prestacion;

                    if ($nombre_descripcion == "09600151"){
                        $nombre_descripcion = "ALTAS PERSONAS CON DEPENDENCIA SEVERA";
                    }
                    if ($nombre_descripcion == "09600152"){
                        $nombre_descripcion = "ALTAS CUIDADORES PERSONAS CON DEPENDENCIA";
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
                    <td align='right'><?php echo number_format($row->Col12,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col13,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col14,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col15,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col16,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col17,0,",",".")?></td>
                    <?php
                    $i++;
                }
                ?>
                <tr>
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
                          FROM (select c.* from 2020prestaciones c where c.codigo_prestacion in("09204947","09204948","09600153","09600154","09204949","09204950",
                                                                                                "09300500","09310900","09311000","09311100","09311200",
                                                                                                "09400094","09400095","09400096",
                                                                                                "09400097","09400098")) a
                          left join 2020rems b on (a.id_prestacion=b.prestacion_id_prestacion)
                          AND (b.Mes in ('.$mes.')) AND (b.establecimiento_id_establecimiento in ('.$estab.'))
                          group by a.codigo_prestacion, a.descripcion, a.id_prestacion
                          order by a.id_prestacion';
                $registro = DB::connection('mysql_rem')->select($query);

                $i=0;

                foreach($registro as $row ){
                    $nombre_descripcion = $row->codigo_prestacion;

                    if ($nombre_descripcion == "09204947"){
                        $nombre_descripcion = "N° PACIENTES";
      							}
      							if ($nombre_descripcion == "09204948"){
                        $nombre_descripcion = "N° DIENTES";
      							}
                    if ($nombre_descripcion == "09600153"){
                        $nombre_descripcion = "N° PACIENTES";
      							}
      							if ($nombre_descripcion == "09600154"){
                        $nombre_descripcion = "N° DE SEXTANTES";
      							}
      							if ($nombre_descripcion == "09204949"){
                        $nombre_descripcion = "N° PACIENTES";
      							}
      							if ($nombre_descripcion == "09204950"){
                        $nombre_descripcion = "N° PROTESIS";
      							}

      							if ($nombre_descripcion == "09300500"){
                        $nombre_descripcion = "ALTAS INTEGRALES";
      							}
      							if ($nombre_descripcion == "09310900"){
                        $nombre_descripcion = "N° PACIENTES";
      							}
      							if ($nombre_descripcion == "09311000"){
                        $nombre_descripcion = "N° DIENTES";
      							}
      							if ($nombre_descripcion == "09311100"){
                        $nombre_descripcion = "N° PACIENTES";
      							}
      							if ($nombre_descripcion == "09311200"){
                        $nombre_descripcion = "N° PROTESIS";
      							}

      							if ($nombre_descripcion == "09400094"){
                        $nombre_descripcion = "ALTA INTEGRAL EN CENTRO DE SALUD";
      							}
      							if ($nombre_descripcion == "09400095"){
                        $nombre_descripcion = "ALTA INTEGRAL EN UNIDAD DENTAL MÓVIL O PORTÁTIL";
      							}
      							if ($nombre_descripcion == "09400096"){
                        $nombre_descripcion = "ALTA INTEGRAL EN ESTABLECIMIENTO EDUCACIONAL";
      							}
      							if ($nombre_descripcion == "09400097"){
                        $nombre_descripcion = "N° TOTAL DE ACTIVIDAD RECUPERATIVA REALIZADA EN >20 AÑOS, EN EXTENSIÓN HORARIA";
      							}
      							if ($nombre_descripcion == "09400098"){
                        $nombre_descripcion = "N° DE CONSULTAS DE MORBILIDAD REALIZADAS EN >20 AÑOS, EN EXTENSIÓN HORARIA";
      							}
                    ?>
                <tr>
                    <?php
      							if($i==0){?>
      							<td rowspan="6" style="text-align:center; vertical-align:middle">PROGRAMA MEJORAMIENTO DEL ACCESO, ESTRATEGIA RESOLUCIÓN DE ESPECIALIDAD EN APS</td>
                    <td rowspan="2" style="text-align:center; vertical-align:middle">TRATAMIENTO ENDODONCIA</td>
      							<?php
                    }
                    if($i>=0 && $i<=1){?>
      							<td align='left' nowrap="nowrap"><?php echo $nombre_descripcion; ?></td>
      							<?php
                    }
                    if($i==2){?>
                    <td rowspan="2" style="text-align:center; vertical-align:middle">TRATAMIENTO DE PERIODONCIA</td>
      							<?php
                    }
                    if($i>=2 && $i<=3){?>
      							<td align='left' nowrap="nowrap"><?php echo $nombre_descripcion; ?></td>
      							<?php
                    }
                    if($i==4){?>
                    <td rowspan="2" style="text-align:center; vertical-align:middle">PRÓTESIS REMOVIBLES</td>
      							<?php
                    }
                    if($i>=4 && $i<=5){?>
      							<td align='left' nowrap="nowrap"><?php echo $nombre_descripcion; ?></td>
      							<?php
                    }
                    if($i==6){?>
                    <td rowspan="5" style="text-align:center; vertical-align:middle">PROGRAMA GES ODONTOLÓGICO ADULTO DE 60 AÑOS</td>
                    <td colspan="2" align='left' nowrap="nowrap"><?php echo $nombre_descripcion; ?></td>
      							<?php
                    }
                    if($i==7){?>
                    <td rowspan="2" style="text-align:center; vertical-align:middle">TRATAMIENTO ENDODONCIA</td>
      							<?php
                    }
                    if($i>=7 && $i<=8){?>
      							<td align='left' nowrap="nowrap"><?php echo $nombre_descripcion; ?></td>
      							<?php
                    }
                    if($i==9){?>
                    <td rowspan="2" style="text-align:center; vertical-align:middle">TRATAMIENTO ENDODONCIA</td>
      							<?php
                    }
                    if($i>=9 && $i<=10){?>
      							<td align='left' nowrap="nowrap"><?php echo $nombre_descripcion; ?></td>
      							<?php
                    }
                    if($i==11){?>
                    <td rowspan="3" style="text-align:center; vertical-align:middle">PROGRAMA ODONTOLOGICO INTEGRAL, ESTRATEGIA ESTUDIANTES DE CUARTO MEDIO</td>
                    <td rowspan="3" style="text-align:center; vertical-align:middle">ALTAS INTEGRALES ESTUDIANTES DE CUARTO MEDIO</td>
                    <?php
                    }
                    if($i>=11 && $i<=13){?>
      							<td align='left' nowrap="nowrap"><?php echo $nombre_descripcion; ?></td>
      							<?php
                    }
                    if($i==14){?>
                    <td rowspan="2" style="text-align:center; vertical-align:middle">PROGRAMA MEJORAMIENTO DEL ACCESO, ESTRATEGIA MORBILIDAD ADULTO</td>
                    <td rowspan="2" style="text-align:center; vertical-align:middle">MORBILIDAD ADULTO</td>
                    <?php
                    }
                    if($i>=14 && $i<=15){?>
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
                    <td align='right'><?php echo number_format($row->Col15,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col16,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col17,0,",",".")?></td>
                    <?php
                    $i++;
                }
                ?>
                </tr>
            </tbody>
        </table>
    </div>

    <br>

    <div class="col-sm tab table-responsive" id="G1">
        <table class="table table-hover table-bordered table-sm">
            <thead>
                <tr>
                    <td colspan="31" class="active"><strong>SECCIÓN G.1: PROGRAMA SEMBRANDO SONRISAS.</strong></td>
                </tr>
                <tr>
                    <td rowspan="3" style="text-align:center; vertical-align:middle"><strong>ACTIVIDAD</strong></td>
                    <td colspan="3" rowspan="2" style="text-align:center; vertical-align:middle"><strong>TOTAL</strong></td>
                    <td colspan="22" align="center"><strong>SEGÚN GRUPOS DE EDAD O DE RIESGO</strong></td>
                    <td rowspan="3" align="center"><strong>USUARIOS EN SITUACIÓN DE DISCAPACIDAD</strong></td>
                    <td rowspan="3" align="center"><strong>Total</strong></td>
                    <td rowspan="3" align="center"><strong>JUNJI</strong></td>
                    <td rowspan="3" align="center"><strong>INTEGRA</strong></td>
                    <td rowspan="3" align="center"><strong>MINEDUC</strong></td>
                </tr>
                <tr>
                    <td colspan="2" align="center"><strong>Menos de 1 año</strong></td>
                    <td colspan="2" align="center"><strong>1 año</strong></td>
                    <td colspan="2" align="center"><strong>2 años</strong></td>
                    <td colspan="2" align="center"><strong>3 años</strong></td>
                    <td colspan="2" align="center"><strong>4 años</strong></td>
                    <td colspan="2" align="center"><strong>5 años</strong></td>
                    <td colspan="2" align="center"><strong>6 años</strong></td>
                    <td colspan="2" align="center"><strong>0-14 años</strong></td>
                    <td colspan="2" align="center"><strong>15-19 años</strong></td>
                    <td colspan="2" align="center"><strong>20-64 años</strong></td>
                    <td colspan="2" align="center"><strong>65 y más años</strong></td>

                </tr>
                <tr>
                    <td align="center"><strong>Ambos&nbsp;Sexos</strong></td>
                    <td align="center"><strong>Hombres</strong></td>
                    <td align="center"><strong>Mujeres</strong></td>
                    <td align="center"><strong>Hombres</strong></td>
                    <td align="center"><strong>Mujeres</strong></td>
                    <td align="center"><strong>Hombres</strong></td>
                    <td align="center"><strong>Mujeres</strong></td>
                    <td align="center"><strong>Hombres</strong></td>
                    <td align="center"><strong>Mujeres</strong></td>
                    <td align="center"><strong>Hombres</strong></td>
                    <td align="center"><strong>Mujeres</strong></td>
                    <td align="center"><strong>Hombres</strong></td>
                    <td align="center"><strong>Mujeres</strong></td>
                    <td align="center"><strong>Hombres</strong></td>
                    <td align="center"><strong>Mujeres</strong></td>
                    <td align="center"><strong>Hombres</strong></td>
                    <td align="center"><strong>Mujeres</strong></td>
                    <td align="center"><strong>Hombres</strong></td>
                    <td align="center"><strong>Mujeres</strong></td>
                    <td align="center"><strong>Hombres</strong></td>
                    <td align="center"><strong>Mujeres</strong></td>
                    <td align="center"><strong>Hombres</strong></td>
                    <td align="center"><strong>Mujeres</strong></td>
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
                              ,sum(ifnull(b.Col25,0)) Col25
                              ,sum(ifnull(b.Col26,0)) Col26
                              ,sum(ifnull(b.Col27,0)) Col27
                              ,sum(ifnull(b.Col28,0)) Col28
                              ,sum(ifnull(b.Col29,0)) Col29
                              ,sum(ifnull(b.Col30,0)) Col30
                          FROM (select c.* from 2020prestaciones c where c.codigo_prestacion in("09400090","09400091","09306600","09306800","09600105")) a
                          left join 2020rems b on (a.id_prestacion=b.prestacion_id_prestacion)
                          AND (b.Mes in ('.$mes.')) AND (b.establecimiento_id_establecimiento in ('.$estab.'))
                          group by a.codigo_prestacion, a.descripcion, a.id_prestacion
                          order by a.id_prestacion';
                $registro = DB::connection('mysql_rem')->select($query);

                $i=0;

                foreach($registro as $row ){
                    $nombre_descripcion = $row->codigo_prestacion;

                    if ($nombre_descripcion == "09400090"){
                        $nombre_descripcion = "EXAMEN DE SALUD";
      							}
      							if ($nombre_descripcion == "09400091"){
                        $nombre_descripcion = "Nº DE NIÑOS CON ÍNDICE ceod=0 AL INGRESO";
      							}
      							if ($nombre_descripcion == "09306600"){
                        $nombre_descripcion = "SET DE HIGIENE ORAL ENTREGADOS";
      							}
      							if ($nombre_descripcion == "09306800"){
                        $nombre_descripcion = "Nº DE APLICACIONES FLÚOR BARNIZ";
      							}
                    if ($nombre_descripcion == "09600105"){
                        $nombre_descripcion = "EDUCACIÓN GRUPAL EN ESTABLECIMIENTO DE EDUCACIÓN";
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
    <div class="col-sm tab table-responsive" id="H">
        <table class="table table-hover table-bordered table-sm">
            <thead>
                <tr>
                    <td colspan="8" class="active"><strong>SECCIÓN H: SEDACIÓN Y ANESTESIA.</strong></td>
                </tr>
                <tr>
                    <td rowspan="3" style="text-align:center; vertical-align:middle"><strong>ACTIVIDAD</strong></td>
                    <td colspan="3" rowspan="2" style="text-align:center; vertical-align:middle"><strong>TOTAL</strong></td>
                    <td colspan="4" align="center"><strong>SEGÚN GRUPOS DE EDAD O DE RIESGO</strong></td>
                </tr>
                <tr>
                    <td rowspan="2" align="center"><strong>0-5 años</strong></td>
                    <td rowspan="2" align="center"><strong>6 -14años</strong></td>
                    <td rowspan="2" align="center"><strong>15-19 años</strong></td>
                    <td rowspan="2" align="center"><strong>20-64 años</strong></td>
                </tr>
                <tr>
                    <td align="center"><strong>Ambos&nbsp;Sexos</strong></td>
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
                          FROM (select c.* from 2020prestaciones c where c.codigo_prestacion in("09306801","09600106","09204213","09204214")) a
                          left join 2020rems b on (a.id_prestacion=b.prestacion_id_prestacion)
                          AND (b.Mes in ('.$mes.')) AND (b.establecimiento_id_establecimiento in ('.$estab.'))
                          group by a.codigo_prestacion, a.descripcion, a.id_prestacion
                          order by a.id_prestacion';
                $registro = DB::connection('mysql_rem')->select($query);

                $i=0;

                foreach($registro as $row ){
                    $nombre_descripcion = $row->codigo_prestacion;

                    if ($nombre_descripcion == "09306801"){
                        $nombre_descripcion = "ATENCIÓN BAJO SEDACIÓN INHALATORIA (CON ÓXIDO NITROSO)";
      							}
                    if ($nombre_descripcion == "09600106"){
                        $nombre_descripcion = "SEDACIÓN ENDOVENOSA";
      							}
      							if ($nombre_descripcion == "09204213"){
                        $nombre_descripcion = "ATENCION BAJO ANESTESIA GENERAL";
      							}
      							if ($nombre_descripcion == "09204214"){
                        $nombre_descripcion = "ATENCIÓN BAJO SEDACIÓN ORAL";
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
                    <?php
                    $i++;
                }
                ?>
                </tr>
            </tbody>
        </table>
    </div>
    </div>

    <br>

    <div class="col-sm tab table-responsive" id="I">
        <table class="table table-hover table-bordered table-sm">
            <thead>
                <tr>
                    <td colspan="30" class="active"><strong>SECCIÓN I: CONSULTAS, INGRESOS Y EGRESOS A TRATAMIENTOS EN ESTABLECIMIENTOS DE NIVEL.</strong></td>
                </tr>
                <tr>
                    <td colspan="2" rowspan="3" style="text-align:center; vertical-align:middle"><strong>ESPECIALIDAD Y TIPO DE INGRESO O EGRESO</strong></td>
                    <td colspan="3" rowspan="2" style="text-align:center; vertical-align:middle"><strong>TOTAL</strong></td>
                    <td colspan="16" align="center"><strong>SEGÚN GRUPOS DE EDAD O DE RIESGO</strong></td>
                    <td rowspan="3" align="center"><strong>EMBARAZADAS</strong></td>
                    <td rowspan="3" align="center"><strong>60 AÑOS (INCLUÍDO EN GRUPOS DE 20-64 AÑOS)</strong></td>
                    <td colspan="2" align="center"><strong>CONSULTAS PERTINENTES</strong></td>
                    <td rowspan="3" align="center"><strong>INASISTENTE</strong></td>
                    <td rowspan="3" align="center"><strong>COMPRA DE SERVICIO</strong></td>
                    <td rowspan="3" align="center"><strong>USUARIOS EN SITUACIÓN DE DISCAPACIDAD</strong></td>
                    <td rowspan="3" align="center"><strong>NIÑOS, NIÑAS, ADOLESCENTES Y JÓVENES POBLACIÓN SENAME</strong></td>
                    <td rowspan="3" align="center"><strong>MIGRANTES</strong></td>
                </tr>
                <tr>
                    <td colspan="2" align="center"><strong>0-5 años</strong></td>
                    <td colspan="2" align="center"><strong>6 años</strong></td>
                    <td colspan="2" align="center"><strong>7 años</strong></td>
                    <td colspan="2" align="center"><strong>12 años</strong></td>
                    <td colspan="2" align="center"><strong>Resto &lt;15 años</strong></td>
                    <td colspan="2" align="center"><strong>15-19 años</strong></td>
                    <td colspan="2" align="center"><strong>20-64 años</strong></td>
                    <td colspan="2" align="center"><strong>65 y más años</strong></td>
                    <td rowspan="2" align="center"><strong>Según protocolo de referencia</strong></td>
                    <td rowspan="2" align="center"><strong>Según condición clínica</strong></td>
                </tr>
                <tr>
                    <td align="center"><strong>Ambos&nbsp;Sexos</strong></td>
                    <td align="center"><strong>Hombres</strong></td>
                    <td align="center"><strong>Mujeres</strong></td>
                    <td align="center"><strong>Hombres</strong></td>
                    <td align="center"><strong>Mujeres</strong></td>
                    <td align="center"><strong>Hombres</strong></td>
                    <td align="center"><strong>Mujeres</strong></td>
                    <td align="center"><strong>Hombres</strong></td>
                    <td align="center"><strong>Mujeres</strong></td>
                    <td align="center"><strong>Hombres</strong></td>
                    <td align="center"><strong>Mujeres</strong></td>
                    <td align="center"><strong>Hombres</strong></td>
                    <td align="center"><strong>Mujeres</strong></td>
                    <td align="center"><strong>Hombres</strong></td>
                    <td align="center"><strong>Mujeres</strong></td>
                    <td align="center"><strong>Hombres</strong></td>
                    <td align="center"><strong>Mujeres</strong></td>
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
                              ,sum(ifnull(b.Col25,0)) Col25
                              ,sum(ifnull(b.Col26,0)) Col26
                              ,sum(ifnull(b.Col27,0)) Col27
                              ,sum(ifnull(b.Col28,0)) Col28
                          FROM (select c.* from 2020prestaciones c where c.codigo_prestacion in("09240700","09240750",
                                                                                                "09600155","09600156","09216113","09216213","09600157",
                                                                                                "09600158","09600159","09204953","09204954","09600160",
                                                                                                "09600161","09600162","09216513","09216613","09600163",
                                                                                                "09600164","09600165","09216913","09217013","09600166",
                                                                                                "09600167","09600168","09217413","09217513","09600169",
                                                                                                "09600170","09600171","09217913","09218013","09600172",
                                                                                                "09600173","09600174","09600175","09600176","09600177",
                                                                                                "09600178","09600179","09218313","09218413","09600180",
                                                                                                "09600181","09600182","09218813","09218913","09600183",
                                                                                                "09600184","09600185","09219213","09219313","09600186",
                                                                                                "09600187","09600188","09600189","09600190","09600191",
                                                                                                "09600192","09600193","09309000","09309050","09600194",
                                                                                                "09600195","09600196","09309200","09309250","09600197",
                                                                                                "09600198","09600199","09240500","09240600","09600200")) a
                          left join 2020rems b on (a.id_prestacion=b.prestacion_id_prestacion)
                          AND (b.Mes in ('.$mes.')) AND (b.establecimiento_id_establecimiento in ('.$estab.'))
                          group by a.codigo_prestacion, a.descripcion, a.id_prestacion
                          order by a.id_prestacion';
                $registro = DB::connection('mysql_rem')->select($query);

                $i=0;

                foreach($registro as $row ){
                    $nombre_descripcion = $row->codigo_prestacion;

                    if ($nombre_descripcion == "09240700"){
                        $nombre_descripcion = "CONSULTA DE URGENCIA";
      							}
      							if ($nombre_descripcion == "09240750"){
                        $nombre_descripcion = "CONSULTA DE MORBILIDAD ODONTOLOGICA";
      							}

                    if ($nombre_descripcion == "09600155"){
                        $nombre_descripcion = "CONSULTA NUEVA";
      							}
                    if ($nombre_descripcion == "09600156"){
                        $nombre_descripcion = "CONTROL";
      							}
                    if ($nombre_descripcion == "09216113"){
                        $nombre_descripcion = "INGRESOS A TRATAMIENTO";
      							}
                    if ($nombre_descripcion == "09216213"){
                        $nombre_descripcion = "ALTAS DE TRATAMIENTO";
      							}
                    if ($nombre_descripcion == "09600157"){
                        $nombre_descripcion = "ALTAS ADMINISTRATIVAS";
      							}

                    if ($nombre_descripcion == "09600158"){
                        $nombre_descripcion = "CONSULTA NUEVA";
      							}
                    if ($nombre_descripcion == "09600159"){
                        $nombre_descripcion = "CONTROL";
      							}
                    if ($nombre_descripcion == "09204953"){
                        $nombre_descripcion = "INGRESOS A TRATAMIENTO";
      							}
                    if ($nombre_descripcion == "09204954"){
                        $nombre_descripcion = "ALTAS DE TRATAMIENTO";
      							}
                    if ($nombre_descripcion == "09600160"){
                        $nombre_descripcion = "ALTAS ADMINISTRATIVAS";
      							}

                    if ($nombre_descripcion == "09600161"){
                        $nombre_descripcion = "CONSULTA NUEVA";
      							}
                    if ($nombre_descripcion == "09600162"){
                        $nombre_descripcion = "CONTROL";
      							}
                    if ($nombre_descripcion == "09216513"){
                        $nombre_descripcion = "INGRESOS A TRATAMIENTO";
      							}
                    if ($nombre_descripcion == "09216613"){
                        $nombre_descripcion = "ALTAS DE TRATAMIENTO";
      							}
                    if ($nombre_descripcion == "09600163"){
                        $nombre_descripcion = "ALTAS ADMINISTRATIVAS";
      							}

                    if ($nombre_descripcion == "09600164"){
                        $nombre_descripcion = "CONSULTA NUEVA";
      							}
                    if ($nombre_descripcion == "09600165"){
                        $nombre_descripcion = "CONTROL";
      							}
                    if ($nombre_descripcion == "09216913"){
                        $nombre_descripcion = "INGRESOS A TRATAMIENTO";
      							}
                    if ($nombre_descripcion == "09217013"){
                        $nombre_descripcion = "ALTAS DE TRATAMIENTO";
      							}
                    if ($nombre_descripcion == "09600166"){
                        $nombre_descripcion = "ALTAS ADMINISTRATIVAS";
      							}

                    if ($nombre_descripcion == "09600167"){
                        $nombre_descripcion = "CONSULTA NUEVA";
      							}
                    if ($nombre_descripcion == "09600168"){
                        $nombre_descripcion = "CONTROL";
      							}
                    if ($nombre_descripcion == "09217413"){
                        $nombre_descripcion = "INGRESOS A TRATAMIENTO";
      							}
                    if ($nombre_descripcion == "09217513"){
                        $nombre_descripcion = "ALTAS DE TRATAMIENTO";
      							}
                    if ($nombre_descripcion == "09600169"){
                        $nombre_descripcion = "ALTAS ADMINISTRATIVAS";
      							}

                    if ($nombre_descripcion == "09600170"){
                        $nombre_descripcion = "CONSULTA NUEVA";
      							}
                    if ($nombre_descripcion == "09600171"){
                        $nombre_descripcion = "CONTROL";
      							}
                    if ($nombre_descripcion == "09217913"){
                        $nombre_descripcion = "INGRESOS A TRATAMIENTO";
      							}
                    if ($nombre_descripcion == "09218013"){
                        $nombre_descripcion = "ALTAS DE TRATAMIENTO";
      							}
                    if ($nombre_descripcion == "09600172"){
                        $nombre_descripcion = "ALTAS ADMINISTRATIVAS";
      							}

                    if ($nombre_descripcion == "09600173"){
                        $nombre_descripcion = "CONSULTA NUEVA";
      							}
                    if ($nombre_descripcion == "09600174"){
                        $nombre_descripcion = "CONTROL";
      							}
                    if ($nombre_descripcion == "09600175"){
                        $nombre_descripcion = "INGRESOS A TRATAMIENTO";
      							}
                    if ($nombre_descripcion == "09600176"){
                        $nombre_descripcion = "ALTAS DE TRATAMIENTO";
      							}
                    if ($nombre_descripcion == "09600177"){
                        $nombre_descripcion = "ALTAS ADMINISTRATIVAS";
      							}

                    if ($nombre_descripcion == "09600178"){
                        $nombre_descripcion = "CONSULTA NUEVA";
      							}
                    if ($nombre_descripcion == "09600179"){
                        $nombre_descripcion = "CONTROL";
      							}
                    if ($nombre_descripcion == "09218313"){
                        $nombre_descripcion = "INGRESOS A TRATAMIENTO";
      							}
                    if ($nombre_descripcion == "09218413"){
                        $nombre_descripcion = "ALTAS DE TRATAMIENTO";
      							}
                    if ($nombre_descripcion == "09600180"){
                        $nombre_descripcion = "ALTAS ADMINISTRATIVAS";
      							}

                    if ($nombre_descripcion == "09600181"){
                        $nombre_descripcion = "CONSULTA NUEVA";
      							}
                    if ($nombre_descripcion == "09600182"){
                        $nombre_descripcion = "CONTROL";
      							}
                    if ($nombre_descripcion == "09218813"){
                        $nombre_descripcion = "INGRESOS A TRATAMIENTO";
      							}
                    if ($nombre_descripcion == "09218913"){
                        $nombre_descripcion = "ALTAS DE TRATAMIENTO";
      							}
                    if ($nombre_descripcion == "09600183"){
                        $nombre_descripcion = "ALTAS ADMINISTRATIVAS";
      							}

                    if ($nombre_descripcion == "09600184"){
                        $nombre_descripcion = "CONSULTA NUEVA";
      							}
                    if ($nombre_descripcion == "09600185"){
                        $nombre_descripcion = "CONTROL";
      							}
                    if ($nombre_descripcion == "09219213"){
                        $nombre_descripcion = "INGRESOS A TRATAMIENTO";
      							}
                    if ($nombre_descripcion == "09219313"){
                        $nombre_descripcion = "ALTAS DE TRATAMIENTO";
      							}
                    if ($nombre_descripcion == "09600186"){
                        $nombre_descripcion = "ALTAS ADMINISTRATIVAS";
      							}

                    if ($nombre_descripcion == "09600187"){
                        $nombre_descripcion = "CONSULTA NUEVA";
      							}
                    if ($nombre_descripcion == "09600188"){
                        $nombre_descripcion = "CONTROL";
      							}
                    if ($nombre_descripcion == "09600189"){
                        $nombre_descripcion = "INGRESOS A TRATAMIENTO";
      							}
                    if ($nombre_descripcion == "09600190"){
                        $nombre_descripcion = "ALTAS DE TRATAMIENTO";
      							}
                    if ($nombre_descripcion == "09600191"){
                        $nombre_descripcion = "ALTAS ADMINISTRATIVAS";
      							}

                    if ($nombre_descripcion == "09600192"){
                        $nombre_descripcion = "CONSULTA NUEVA";
      							}
                    if ($nombre_descripcion == "09600193"){
                        $nombre_descripcion = "CONTROL";
      							}
                    if ($nombre_descripcion == "09309000"){
                        $nombre_descripcion = "INGRESOS A TRATAMIENTO";
      							}
                    if ($nombre_descripcion == "09309050"){
                        $nombre_descripcion = "ALTAS DE TRATAMIENTO";
      							}
                    if ($nombre_descripcion == "09600194"){
                        $nombre_descripcion = "ALTAS ADMINISTRATIVAS";
      							}

                    if ($nombre_descripcion == "09600195"){
                        $nombre_descripcion = "CONSULTA NUEVA";
      							}
                    if ($nombre_descripcion == "09600196"){
                        $nombre_descripcion = "CONTROL";
      							}
                    if ($nombre_descripcion == "09309200"){
                        $nombre_descripcion = "INGRESOS A TRATAMIENTO";
      							}
                    if ($nombre_descripcion == "09309250"){
                        $nombre_descripcion = "ALTAS DE TRATAMIENTO";
      							}
                    if ($nombre_descripcion == "09600197"){
                        $nombre_descripcion = "ALTAS ADMINISTRATIVAS";
      							}

                    if ($nombre_descripcion == "09600198"){
                        $nombre_descripcion = "CONSULTA NUEVA";
      							}
                    if ($nombre_descripcion == "09600199"){
                        $nombre_descripcion = "CONTROL";
      							}
                    if ($nombre_descripcion == "09240500"){
                        $nombre_descripcion = "INGRESOS A TRATAMIENTO";
      							}
                    if ($nombre_descripcion == "09240600"){
                        $nombre_descripcion = "ALTAS DE TRATAMIENTO";
      							}
                    if ($nombre_descripcion == "09600200"){
                        $nombre_descripcion = "ALTAS ADMINISTRATIVAS";
      							}

                    ?>
                <tr>
                    <?php
                    if($i==0){?>
                        <td rowspan='2' style="text-align:center; vertical-align:middle">CONSULTAS</td>
      							<?php
      							}
                    if($i==2){?>
                        <td rowspan='5' style="text-align:center; vertical-align:middle">CIRUGÍA BUCAL</td>
      							<?php
      							}
      							if($i==7){?>
                        <td rowspan='5' style="text-align:center; vertical-align:middle">CIRUGÍA Y TRAUMATOLOGÍA MAXILOFACIAL</td>
      							<?php
      							}
      							if($i==12){?>
                        <td rowspan='5' style="text-align:center; vertical-align:middle">ENDODONCIA</td>
      							<?php
      							}
                    if($i==17){?>
                        <td rowspan='5' style="text-align:center; vertical-align:middle">ODONTOPEDIATRÍA</td>
      							<?php
      							}
                    if($i==22){?>
                        <td rowspan='5' style="text-align:center; vertical-align:middle">OPERATORIA</td>
      							<?php
      							}
                    if($i==27){?>
                        <td rowspan='5' style="text-align:center; vertical-align:middle">ORTODONCIA Y ORTOPEDIA DENTO MAXILOFACIAL: APARATOLOGÍA FIJA</td>
      							<?php
      							}
                    if($i==32){?>
                        <td rowspan='5' style="text-align:center; vertical-align:middle">ORTODONCIA Y ORTOPEDIA DENTO MAXILOFACIAL: APARATOLOGÍA REMOVIBLE</td>
      							<?php
      							}
                    if($i==37){?>
                        <td rowspan='5' style="text-align:center; vertical-align:middle">PERIODONCIA</td>
      							<?php
      							}
                    if($i==42){?>
                        <td rowspan='5' style="text-align:center; vertical-align:middle">REHABILITACIÓN: PRÓTESIS FIJA</td>
      							<?php
      							}
                    if($i==47){?>
                        <td rowspan='5' style="text-align:center; vertical-align:middle">REHABILITACIÓN: PRÓTESIS REMOVIBLE</td>
      							<?php
      							}
                    if($i==52){?>
                        <td rowspan='5' style="text-align:center; vertical-align:middle">REHABILITACIÓN: PRÓTESIS IMPLANTOASISTIDA</td>
      							<?php
      							}
                    if($i==57){?>
                        <td rowspan='5' style="text-align:center; vertical-align:middle">IMPLANTOLOGÍA BUCO MAXILOFACIAL</td>
      							<?php
      							}
                    if($i==62){?>
                        <td rowspan='5' style="text-align:center; vertical-align:middle">PATOLOGÍA ORAL</td>
      							<?php
      							}
                    if($i==67){?>
                        <td rowspan='5' style="text-align:center; vertical-align:middle">TRASTORNOS TEMPOROMANDIBULARES Y DOLOR OROFACIAL</td>
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
                    <?php
                    $i++;
                }
                ?>
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
                          FROM (select c.* from 2020prestaciones c where c.codigo_prestacion in("09600155","09600158","09600161","09600164","09600167","09600170","09600173","09600178",
                                                                                                "09600181","09600184","09600187","09600192","09600195","09600198")) a
                          left join 2020rems b on (a.id_prestacion=b.prestacion_id_prestacion)
                          AND (b.Mes in ('.$mes.')) AND (b.establecimiento_id_establecimiento in ('.$estab.'))
                          group by a.codigo_prestacion, a.descripcion, a.id_prestacion
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
                    $i++;
                }
                ?>
                <tr>
                    <td align='left' rowspan="5" style="text-align:center; vertical-align:middle"><strong>TOTAL</strong></td>
                    <td align='left'><strong>CONSULTA NUEVA</strong></td>
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
                          FROM (select c.* from 2020prestaciones c where c.codigo_prestacion in("09600156","09600159","09600162","09600165","09600168","09600171","09600174","09600179","09600182",
                                                                                                "09600185","09600188","09600193","09600196","09600199")) a
                          left join 2020rems b on (a.id_prestacion=b.prestacion_id_prestacion)
                          AND (b.Mes in ('.$mes.')) AND (b.establecimiento_id_establecimiento in ('.$estab.'))
                          group by a.codigo_prestacion, a.descripcion, a.id_prestacion
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
                    $i++;
                }
                ?>
                <tr>
                    <td align='left'><strong>CONTROL</strong></td>
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
                          FROM (select c.* from 2020prestaciones c where c.codigo_prestacion in("09216113","09204953","09216513","09216913","09217413","09217913","09600175","09218313",
                                                                                                "09218813","09219213","09600189","09309000","09309200","09240500")) a
                          left join 2020rems b on (a.id_prestacion=b.prestacion_id_prestacion)
                          AND (b.Mes in ('.$mes.')) AND (b.establecimiento_id_establecimiento in ('.$estab.'))
                          group by a.codigo_prestacion, a.descripcion, a.id_prestacion
                          order by a.id_prestacion';
                $registro = DB::connection('mysql_rem')->select($query);

                $i=0;

                $totalCol01c=0;
    						$totalCol02c=0;
    						$totalCol03c=0;
    						$totalCol04c=0;
    						$totalCol05c=0;
    						$totalCol06c=0;
    						$totalCol07c=0;
    						$totalCol08c=0;
    						$totalCol09c=0;
    						$totalCol10c=0;
    						$totalCol11c=0;
    						$totalCol12c=0;
    						$totalCol13c=0;
    						$totalCol14c=0;
    						$totalCol15c=0;
    						$totalCol16c=0;
    						$totalCol17c=0;
    						$totalCol18c=0;
    						$totalCol19c=0;
    						$totalCol20c=0;
    						$totalCol21c=0;
    						$totalCol22c=0;
    						$totalCol23c=0;
                $totalCol24c=0;
                $totalCol25c=0;
                $totalCol26c=0;
                $totalCol27c=0;
                $totalCol28c=0;

                foreach($registro as $row ){
                    $totalCol01c=$totalCol01c+$row->Col01;
                    $totalCol02c=$totalCol02c+$row->Col02;
                    $totalCol03c=$totalCol03c+$row->Col03;
                    $totalCol04c=$totalCol04c+$row->Col04;
                    $totalCol05c=$totalCol05c+$row->Col05;
                    $totalCol06c=$totalCol06c+$row->Col06;
                    $totalCol07c=$totalCol07c+$row->Col07;
                    $totalCol08c=$totalCol08c+$row->Col08;
                    $totalCol09c=$totalCol09c+$row->Col09;
                    $totalCol10c=$totalCol10c+$row->Col10;
                    $totalCol11c=$totalCol11c+$row->Col11;
                    $totalCol12c=$totalCol12c+$row->Col12;
                    $totalCol13c=$totalCol13c+$row->Col13;
                    $totalCol14c=$totalCol14c+$row->Col14;
                    $totalCol15c=$totalCol15c+$row->Col15;
                    $totalCol16c=$totalCol16c+$row->Col16;
                    $totalCol17c=$totalCol17c+$row->Col17;
                    $totalCol18c=$totalCol18c+$row->Col18;
                    $totalCol19c=$totalCol19c+$row->Col19;
                    $totalCol20c=$totalCol20c+$row->Col20;
                    $totalCol21c=$totalCol21c+$row->Col21;
                    $totalCol22c=$totalCol22c+$row->Col22;
                    $totalCol23c=$totalCol23c+$row->Col23;
                    $totalCol24c=$totalCol24c+$row->Col24;
                    $totalCol25c=$totalCol25c+$row->Col25;
                    $totalCol26c=$totalCol26c+$row->Col26;
                    $totalCol27c=$totalCol27c+$row->Col27;
                    $totalCol28c=$totalCol28c+$row->Col28;
                    $i++;
                }
                ?>
                <tr>
                    <td align='left'><strong>INGRESOS A TRATAMIENTO</strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol01c,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol02c,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol03c,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol04c,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol05c,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol06c,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol07c,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol08c,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol09c,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol10c,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol11c,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol12c,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol13c,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol14c,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol15c,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol16c,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol17c,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol18c,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol19c,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol20c,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol21c,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol22c,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol23c,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol24c,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol25c,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol26c,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol27c,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol28c,0,",",".") ?></strong></td>
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
                          FROM (select c.* from 2020prestaciones c where c.codigo_prestacion in("09216213","09204954","09216613","09217013","09217513","09218013","09600176","09218413",
                                                                                                "09218913","09219313","09600190","09309050","09309250","09240600")) a
                          left join 2020rems b on (a.id_prestacion=b.prestacion_id_prestacion)
                          AND (b.Mes in ('.$mes.')) AND (b.establecimiento_id_establecimiento in ('.$estab.'))
                          group by a.codigo_prestacion, a.descripcion, a.id_prestacion
                          order by a.id_prestacion';
                $registro = DB::connection('mysql_rem')->select($query);

                $i=0;

                $totalCol01d=0;
    						$totalCol02d=0;
    						$totalCol03d=0;
    						$totalCol04d=0;
    						$totalCol05d=0;
    						$totalCol06d=0;
    						$totalCol07d=0;
    						$totalCol08d=0;
    						$totalCol09d=0;
    						$totalCol10d=0;
    						$totalCol11d=0;
    						$totalCol12d=0;
    						$totalCol13d=0;
    						$totalCol14d=0;
    						$totalCol15d=0;
    						$totalCol16d=0;
    						$totalCol17d=0;
    						$totalCol18d=0;
    						$totalCol19d=0;
    						$totalCol20d=0;
    						$totalCol21d=0;
    						$totalCol22d=0;
    						$totalCol23d=0;
                $totalCol24d=0;
                $totalCol25d=0;
                $totalCol26d=0;
                $totalCol27d=0;
                $totalCol28d=0;

                foreach($registro as $row ){
                    $totalCol01d=$totalCol01d+$row->Col01;
                    $totalCol02d=$totalCol02d+$row->Col02;
                    $totalCol03d=$totalCol03d+$row->Col03;
                    $totalCol04d=$totalCol04d+$row->Col04;
                    $totalCol05d=$totalCol05d+$row->Col05;
                    $totalCol06d=$totalCol06d+$row->Col06;
                    $totalCol07d=$totalCol07d+$row->Col07;
                    $totalCol08d=$totalCol08d+$row->Col08;
                    $totalCol09d=$totalCol09d+$row->Col09;
                    $totalCol10d=$totalCol10d+$row->Col10;
                    $totalCol11d=$totalCol11d+$row->Col11;
                    $totalCol12d=$totalCol12d+$row->Col12;
                    $totalCol13d=$totalCol13d+$row->Col13;
                    $totalCol14d=$totalCol14d+$row->Col14;
                    $totalCol15d=$totalCol15d+$row->Col15;
                    $totalCol16d=$totalCol16d+$row->Col16;
                    $totalCol17d=$totalCol17d+$row->Col17;
                    $totalCol18d=$totalCol18d+$row->Col18;
                    $totalCol19d=$totalCol19d+$row->Col19;
                    $totalCol20d=$totalCol20d+$row->Col20;
                    $totalCol21d=$totalCol21d+$row->Col21;
                    $totalCol22d=$totalCol22d+$row->Col22;
                    $totalCol23d=$totalCol23d+$row->Col23;
                    $totalCol24d=$totalCol24d+$row->Col24;
                    $totalCol25d=$totalCol25d+$row->Col25;
                    $totalCol26d=$totalCol26d+$row->Col26;
                    $totalCol27d=$totalCol27d+$row->Col27;
                    $totalCol28d=$totalCol28d+$row->Col28;
                    $i++;
                }
                ?>
                <tr>
                    <td align='left'><strong>ALTAS DE TRATAMIENTO</strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol01d,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol02d,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol03d,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol04d,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol05d,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol06d,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol07d,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol08d,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol09d,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol10d,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol11d,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol12d,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol13d,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol14d,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol15d,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol16d,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol17d,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol18d,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol19d,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol20d,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol21d,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol22d,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol23d,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol24d,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol25d,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol26d,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol27d,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol28d,0,",",".") ?></strong></td>
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
                          FROM (select c.* from 2020prestaciones c where c.codigo_prestacion in("09600157",
                          "09600163",
                          "09600166",
                          "09600160",
                          "09600169",
                          "09600172",
                          "09600177",
                          "09600180",
                          "09600183",
                          "09600186",
                          "09600191",
                          "09600194",
                          "09600197",
                          "09600200")) a
                          left join 2020rems b on (a.id_prestacion=b.prestacion_id_prestacion)
                          AND (b.Mes in ('.$mes.')) AND (b.establecimiento_id_establecimiento in ('.$estab.'))
                          group by a.codigo_prestacion, a.descripcion, a.id_prestacion
                          order by a.id_prestacion';
                $registro = DB::connection('mysql_rem')->select($query);

                $i=0;

                $totalCol01e=0;
    						$totalCol02e=0;
    						$totalCol03e=0;
    						$totalCol04e=0;
    						$totalCol05e=0;
    						$totalCol06e=0;
    						$totalCol07e=0;
    						$totalCol08e=0;
    						$totalCol09e=0;
    						$totalCol10e=0;
    						$totalCol11e=0;
    						$totalCol12e=0;
    						$totalCol13e=0;
    						$totalCol14e=0;
    						$totalCol15e=0;
    						$totalCol16e=0;
    						$totalCol17e=0;
    						$totalCol18e=0;
    						$totalCol19e=0;
    						$totalCol20e=0;
    						$totalCol21e=0;
    						$totalCol22e=0;
    						$totalCol23e=0;
                $totalCol24e=0;
                $totalCol25e=0;
                $totalCol26e=0;
                $totalCol27e=0;
                $totalCol28e=0;

                foreach($registro as $row ){
                    $totalCol01e=$totalCol01e+$row->Col01;
                    $totalCol02e=$totalCol02e+$row->Col02;
                    $totalCol03e=$totalCol03e+$row->Col03;
                    $totalCol04e=$totalCol04e+$row->Col04;
                    $totalCol05e=$totalCol05e+$row->Col05;
                    $totalCol06e=$totalCol06e+$row->Col06;
                    $totalCol07e=$totalCol07e+$row->Col07;
                    $totalCol08e=$totalCol08e+$row->Col08;
                    $totalCol09e=$totalCol09e+$row->Col09;
                    $totalCol10e=$totalCol10e+$row->Col10;
                    $totalCol11e=$totalCol11e+$row->Col11;
                    $totalCol12e=$totalCol12e+$row->Col12;
                    $totalCol13e=$totalCol13e+$row->Col13;
                    $totalCol14e=$totalCol14e+$row->Col14;
                    $totalCol15e=$totalCol15e+$row->Col15;
                    $totalCol16e=$totalCol16e+$row->Col16;
                    $totalCol17e=$totalCol17e+$row->Col17;
                    $totalCol18e=$totalCol18e+$row->Col18;
                    $totalCol19e=$totalCol19e+$row->Col19;
                    $totalCol20e=$totalCol20e+$row->Col20;
                    $totalCol21e=$totalCol21e+$row->Col21;
                    $totalCol22e=$totalCol22e+$row->Col22;
                    $totalCol23e=$totalCol23e+$row->Col23;
                    $totalCol24e=$totalCol24e+$row->Col24;
                    $totalCol25e=$totalCol25e+$row->Col25;
                    $totalCol26e=$totalCol26e+$row->Col26;
                    $totalCol27e=$totalCol27e+$row->Col27;
                    $totalCol28e=$totalCol28e+$row->Col28;
                    $i++;
                }
                ?>
                <tr>
                    <td align='left'><strong>ALTAS ADMINISTRATIVAS</strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol01e,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol02e,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol03e,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol04e,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol05e,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol06e,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol07e,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol08e,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol09e,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol10e,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol11e,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol12e,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol13e,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol14e,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol15e,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol16e,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol17e,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol18e,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol19e,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol20e,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol21e,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol22e,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol23e,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol24e,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol25e,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol26e,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol27e,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol28e,0,",",".") ?></strong></td>
                </tr>
            </tbody>
        </table>
    </div>

    <br>

    <div class="col-sm tab table-responsive" id="J">
        <table class="table table-hover table-bordered table-sm">
            <thead>
                <tr>
                    <td colspan="14" class="active"><strong>SECCIÓN J: ACTIVIDADES EFECTUADAS POR TÉCNICO PARAMÉDICO DENTAL Y/O HIGIENISTAS DENTALES.</strong></td>
                </tr>
                <tr>
                    <td rowspan="3" style="text-align:center; vertical-align:middle"><strong>TIPO DE ACTIVIDAD</strong></td>
                    <td colspan="3" rowspan="2" style="text-align:center; vertical-align:middle"><strong>TOTAL</strong></td>
                    <td colspan="8" align="center"><strong>Según grupos de edad o de riesgo</strong></td>
                    <td rowspan="3" align="center"><strong>EMBARAZADAS</strong></td>
                    <td rowspan="3" align="center"><strong>60 AÑOS (INCLUÍDO EN GRUPOS DE 20-64 AÑOS)</strong></td>
                </tr>
                <tr>
                    <td rowspan="2" align="center"><strong>0-5 años</strong></td>
                    <td rowspan="2" align="center"><strong>6 años</strong></td>
                    <td rowspan="2" align="center"><strong>7 años</strong></td>
                    <td rowspan="2" align="center"><strong>12 años</strong></td>
                    <td rowspan="2" align="center"><strong>Resto &lt;15 años</strong></td>
                    <td rowspan="2" align="center"><strong>15-19 años</strong></td>
                    <td rowspan="2" align="center"><strong>20-64 años</strong></td>
                    <td rowspan="2" align="center"><strong>65 y más años</strong></td>
                </tr>
                <tr>
                    <td align="center"><strong>Ambos&nbsp;Sexos</strong></td>
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
                          FROM (select c.* from 2020prestaciones c where c.codigo_prestacion in("09204317","09204417","09204517","09204717","09400080")) a
                          left join 2020rems b on (a.id_prestacion=b.prestacion_id_prestacion)
                          AND (b.Mes in ('.$mes.')) AND (b.establecimiento_id_establecimiento in ('.$estab.'))
                          group by a.codigo_prestacion, a.descripcion, a.id_prestacion
                          order by a.id_prestacion';
                $registro = DB::connection('mysql_rem')->select($query);

                $i=0;

                foreach($registro as $row ){
                    $nombre_descripcion = $row->codigo_prestacion;

                    if ($nombre_descripcion == "09204317"){
                        $nombre_descripcion = "APLICACIÓN DE SELLANTES";
      							}
      							if ($nombre_descripcion == "09204417"){
                        $nombre_descripcion = "PULIDO CORONARIO Y DESTARTRAJE SUPRAGINGIVAL";
      							}
      							if ($nombre_descripcion == "09204517"){
                        $nombre_descripcion = "FLUORURACIÓN TÓPICA ";
      							}
      							if ($nombre_descripcion == "09204717"){
                        $nombre_descripcion = "EDUCACIÓN INDIVIDUAL CON INSTRUCCIÓN DE TÉCNICA DE CEPILLADO";
      							}
      							if ($nombre_descripcion == "09400080"){
                        $nombre_descripcion = "RADIOGRAFÍAS INTRAORALES (RETROALVEOLARES Y BITEWING)";
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
                    <td align='right'><?php echo number_format($row->Col12,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col13,0,",",".")?></td>
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
    <div class="col-sm tab table-responsive" id="K">
        <table class="table table-hover table-bordered table-sm">
            <thead>
                <tr>
                    <td colspan="5" class="active"><strong>SECCIÓN K: GESTIÓN DE AGENDA (UNIDADES DENTALES MOVILES).</strong></td>
                </tr>
                <tr>
                    <td align="center"><strong>CONSULTAS</strong></td>
                    <td align="center"><strong>HORAS ODONTOLÓGICAS MENSUALES CONTRATADAS</strong></td>
                    <td align="center"><strong>HORAS DISPONIBLES DE ATENCIÓN CLÍNICA</strong></td>
                    <td align="center"><strong>CITAS AGENDADAS</strong></td>
                    <td align="center"><strong>CITAS EFECTIVAS</strong></td>
                </tr>
            </thead>
            <tbody>
                <?php
                $query = 'SELECT a.codigo_prestacion,a.descripcion
                              ,sum(ifnull(b.Col01,0)) Col01
                              ,sum(ifnull(b.Col02,0)) Col02
                              ,sum(ifnull(b.Col03,0)) Col03
                              ,sum(ifnull(b.Col04,0)) Col04
                          FROM (select c.* from 2020prestaciones c where c.codigo_prestacion in("09400104","09400101","09400102","09400103")) a
                          left join 2020rems b on (a.id_prestacion=b.prestacion_id_prestacion)
                          AND (b.Mes in ('.$mes.')) AND (b.establecimiento_id_establecimiento in ('.$estab.'))
                          group by a.codigo_prestacion, a.descripcion, a.id_prestacion
                          order by a.id_prestacion';
                $registro = DB::connection('mysql_rem')->select($query);

                $i=0;

                foreach($registro as $row ){
                    $nombre_descripcion = $row->codigo_prestacion;

                    if ($nombre_descripcion == "09400104"){
                        $nombre_descripcion = "NIVEL PRIMARIO";
      							}

      							if ($nombre_descripcion == "09400101"){
                        $nombre_descripcion = "ATENCIÓN MORBILIDAD";
      							}

      							if ($nombre_descripcion == "09400102"){
                        $nombre_descripcion = "ATENCIÓN TRATAMIENTO";
      							}

      							if ($nombre_descripcion == "09400103"){
                        $nombre_descripcion = "ATENCIÓN URGENCIA";
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
            </tbody>
        </table>
    </div>

    <br>

    <div class="col-sm tab table-responsive" id="L">
        <table class="table table-hover table-bordered table-sm">
            <thead>
                <tr>
                    <td colspan="4" class="active"><strong>SECCIÓN L: CONSULTORÍAS DE ESPECIALISTAS OTORGADAS.</strong></td>
                </tr>
                <tr>
                    <td align="center"><strong>ESPECIALIDADES</strong></td>
                    <td align="center"><strong>Nº CONSULTORÍAS</strong></td>
                    <td align="center"><strong>Nº DE CASOS REVISADOS POR EL EQUIPO</strong></td>
                    <td align="center"><strong>Nº DE CASOS ATENDIDOS</strong></td>
                </tr>
            </thead>
            <tbody>
                <?php
                $query = 'SELECT a.codigo_prestacion,a.descripcion
                              ,sum(ifnull(b.Col01,0)) Col01
                              ,sum(ifnull(b.Col02,0)) Col02
                              ,sum(ifnull(b.Col03,0)) Col03
                          FROM (select c.* from 2020prestaciones c where c.codigo_prestacion in("09400200","09400201","09400202","09400203","09400204","09400205","09400206","09600201",
                                                                                                "09600202","09600203")) a
                          left join 2020rems b on (a.id_prestacion=b.prestacion_id_prestacion)
                          AND (b.Mes in ('.$mes.')) AND (b.establecimiento_id_establecimiento in ('.$estab.'))
                          group by a.codigo_prestacion, a.descripcion, a.id_prestacion
                          order by a.id_prestacion';
                $registro = DB::connection('mysql_rem')->select($query);

                $i=0;

                foreach($registro as $row ){
                    $nombre_descripcion = $row->codigo_prestacion;

                    if ($nombre_descripcion == "09400200"){
                        $nombre_descripcion = "ENDODONCIA";
      							}
      							if ($nombre_descripcion == "09400201"){
                        $nombre_descripcion = "IMAGENOLOGÍA ORAL Y MAXILOFACIAL";
      							}
      							if ($nombre_descripcion == "09400202"){
                        $nombre_descripcion = "ORTODONCIA";
      							}
      							if ($nombre_descripcion == "09400203"){
                        $nombre_descripcion = "ODONTOPEDIATRÍA";
      							}
      							if ($nombre_descripcion == "09400204"){
                        $nombre_descripcion = "PERIODONCIA";
      							}
      							if ($nombre_descripcion == "09400205"){
                        $nombre_descripcion = "REHABILITACIÓN ORAL";
      							}
      							if ($nombre_descripcion == "09400206"){
                        $nombre_descripcion = "CIRUGÍA Y TRAUMATOLOGÍA MAXILOFACIAL";
      							}
                    if ($nombre_descripcion == "09600201"){
                        $nombre_descripcion = "TRASTORNOS TEMPOROMANDIBULARES Y DOLOR OROFACIAL";
      							}
                    if ($nombre_descripcion == "09600202"){
                        $nombre_descripcion = "PATOLOGIA ORAL";
      							}
                    if ($nombre_descripcion == "09600203"){
                        $nombre_descripcion = "IMPLANTOLOGÍA BUCO MAXILOFACIAL
";
      							}
                    ?>
                <tr>
                    <td align='left' nowrap="nowrap"><?php echo $nombre_descripcion; ?></td>
                    <td align='right'><?php echo number_format($row->Col01,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col02,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col03,0,",",".")?></td>
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
