@extends('layouts.app')

@section('title', 'Resumen Estadistico Mensual')

@section('content')

<?php

use Illuminate\Support\Facades\DB;

?>

@include('indicators.rem.partials.nav')

<h3>REM-28. PROGRAMA DE REHABILITACIÓN INTEGRAL.</h3>

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
                  <td colspan="47" class="active"><strong>A. NIVEL PRIMARIO</strong></td>
                </tr>
                <tr>
                  <td colspan="47" class="active"><strong>SECCIÓN A.1: INGRESOS Y EGRESOS AL PROGRAMA DE REHABILITACIÓN INTEGRAL.</strong></td>
                </tr>
                <tr>
                  <td rowspan="3" style="text-align:center; vertical-align:middle"><strong>TIPO DE INGRESO</strong></td>
                  <td colspan="3" rowspan="2" style="text-align:center; vertical-align:middle"><strong>TOTAL</strong></td>
                  <td colspan="38" align="center"><strong>POR EDAD (en años)</strong></td>
                  <td colspan="3" align="center"><strong>TIPO DE ESTRATEGIA</strong></td>
                  <td rowspan="3" style="text-align:center; vertical-align:middle"><strong>Otros</strong></td>
                  <td rowspan="3" style="text-align:center; vertical-align:middle"><strong>UAPORRINO</strong></td>
                </tr>
                <tr>
                  <td colspan="2" align="center"><strong>&lt; 12 meses</strong></td>
                  <td colspan="2" align="center"><strong>12 a 23 meses</strong></td>
                  <td colspan="2" align="center"><strong>2 - 4</strong></td>
                  <td colspan="2" align="center"><strong>5 - 9</strong></td>
                  <td colspan="2" align="center"><strong>10 - 14</strong></td>
                  <td colspan="2" align="center"><strong>15 - 19</strong></td>
                  <td colspan="2" align="center"><strong>20 - 24</strong></td>
                  <td colspan="2" align="center"><strong>25 - 29</strong></td>
                  <td colspan="2" align="center"><strong>30 - 34</strong></td>
                  <td colspan="2" align="center"><strong>35 - 39</strong></td>
                  <td colspan="2" align="center"><strong>40 - 44</strong></td>
                  <td colspan="2" align="center"><strong>45- 49</strong></td>
                  <td colspan="2" align="center"><strong>50 - 54</strong></td>
                  <td colspan="2" align="center"><strong>55 - 59</strong></td>
                  <td colspan="2" align="center"><strong>60 - 64</strong></td>
                  <td colspan="2" align="center"><strong>65 - 69</strong></td>
                  <td colspan="2" align="center"><strong>70 - 74</strong></td>
                  <td colspan="2" align="center"><strong>75 - 79</strong></td>
                  <td colspan="2" align="center"><strong>80 y mas</strong></td>
                  <td rowspan="2" align="center"><strong>Rehabilitación Base Comunitaria (RBC)</strong></td>
                  <td rowspan="2" align="center"><strong>Rehabilitación Integral(RI)</strong></td>
                <td rowspan="2" align="center"><strong>Rehabilitación Rural (RR)</strong></td>
                </tr>
                <tr>
                  <td align="center"><strong>Ambos Sexos</strong></td>
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
                              ,sum(ifnull(b.Col35,0)) Col35
                              ,sum(ifnull(b.Col36,0)) Col36
                              ,sum(ifnull(b.Col37,0)) Col37
                              ,sum(ifnull(b.Col38,0)) Col38
            									,sum(ifnull(b.Col39,0)) Col39
            									,sum(ifnull(b.Col40,0)) Col40
            									,sum(ifnull(b.Col41,0)) Col41
            									,sum(ifnull(b.Col42,0)) Col42
            									,sum(ifnull(b.Col43,0)) Col43
            									,sum(ifnull(b.Col44,0)) Col44
            									,sum(ifnull(b.Col45,0)) Col45
            									,sum(ifnull(b.Col46,0)) Col46
                          FROM (select c.* from 2020prestaciones c where c.codigo_prestacion in("28020500","28020550","28020560","28021621","28021622","28022100","28021631","28021632")) a
                          left join 2020rems b on (a.id_prestacion=b.prestacion_id_prestacion)
                          AND (b.Mes in ('.$mes.')) AND (b.establecimiento_id_establecimiento in ('.$estab.'))
                          group by a.codigo_prestacion, a.descripcion, a.id_prestacion
                          order by a.id_prestacion';
                $registro = DB::connection('mysql_rem')->select($query);

                $i=0;

                foreach($registro as $row ){
                    $nombre_descripcion = $row->codigo_prestacion;
                    if ($nombre_descripcion == "28020500"){
                        $nombre_descripcion = "INGRESOS";
                    }
  							    if ($nombre_descripcion == "28020550"){
                        $nombre_descripcion = "INGRESOS CON PLAN DE TRATAMIENTO INTEGRAL (PTI)";
                    }
                    if ($nombre_descripcion == "28020560"){
                        $nombre_descripcion = "INGRESOS CON PLAN DE TRATAMIENTO INTEGRAL (PTI) CON OBJETIVOS PARA EL TRABAJO";
                    }
                    if ($nombre_descripcion == "28021621"){
                        $nombre_descripcion = "INGRESOS DE USUARIOS CON CUIDADOR ";
                    }
                    if ($nombre_descripcion == "28021622"){
                        $nombre_descripcion = "INGRESOS ACV REFERIDOS DESDE HOSPITAL";
                    }
                    if ($nombre_descripcion == "28022100"){
                        $nombre_descripcion = "INGRESOS POR AMPUTACIÓN";
                    }
                    if ($nombre_descripcion == "28021630"){
                        $nombre_descripcion = "INGRESOS AMPUTADO PIE DIABÉTICO";
                    }
                    if ($nombre_descripcion == "28021631"){
                        $nombre_descripcion = "REINGRESO Al PROGRAMA";
                    }
                    if ($nombre_descripcion == "28021632"){
                        $nombre_descripcion = "INGRESOS CON PTI CUIDADOR";
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
                    <td align='right'><?php echo number_format($row->Col35,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col36,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col37,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col38,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col39,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col40,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col41,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col42,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col43,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col44,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col45,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col46,0,",",".")?></td>
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
            									,sum(ifnull(b.Col44,0)) Col44
            									,sum(ifnull(b.Col45,0)) Col45
            									,sum(ifnull(b.Col46,0)) Col46
                          FROM (select c.* from 2020prestaciones c where c.codigo_prestacion in("28020570","28020580","28020590","28020592","28020593")) a
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
                $totalCol35=0;
                $totalCol36=0;
                $totalCol37=0;
                $totalCol38=0;
                $totalCol39=0;
                $totalCol40=0;
                $totalCol41=0;
                $totalCol42=0;
                $totalCol43=0;
                $totalCol44=0;
                $totalCol45=0;
                $totalCol46=0;

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
                    $totalCol37=$totalCol37+$row->Col37;
                    $totalCol38=$totalCol38+$row->Col38;
                    $totalCol39=$totalCol39+$row->Col39;
                    $totalCol40=$totalCol40+$row->Col40;
                    $totalCol41=$totalCol41+$row->Col41;
                    $totalCol42=$totalCol42+$row->Col42;
                    $totalCol43=$totalCol43+$row->Col43;
                    $totalCol44=$totalCol44+$row->Col44;
                    $totalCol45=$totalCol45+$row->Col45;
                    $totalCol46=$totalCol46+$row->Col46;
                    $i++;
                }
                ?>
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
                    <td align='right'><strong><?php echo number_format($totalCol35,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol36,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol37,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol38,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol39,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol40,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol41,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol42,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol43,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol44,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol45,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol46,0,",",".") ?></strong></td>
                </tr>
                <?php
                foreach($registro as $row ){
                    $nombre_descripcion = $row->codigo_prestacion;
                    if ($nombre_descripcion == "28020570"){
                        $nombre_descripcion = "EGRESOS POR ALTA";
                    }
                    if ($nombre_descripcion == "28020580"){
                        $nombre_descripcion = "EGRESOS POR ABANDONO";
                    }
                    if ($nombre_descripcion == "28020590"){
                        $nombre_descripcion = "EGRESOS POR FALLECIMIENTO";
                    }
                    if ($nombre_descripcion == "28020592"){
                        $nombre_descripcion = "EGRESOS POR OTRAS CAUSAS";
                    }
                    if ($nombre_descripcion == "28020591"){
                        $nombre_descripcion = "EGRESOS CON PERFIL PRELABORAL";
                    }
                    if ($nombre_descripcion == "28020593"){
                        $nombre_descripcion = "EGRESOS CON PTI CUIDADOR";
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
                    <td align='right'><?php echo number_format($row->Col35,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col36,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col37,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col38,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col39,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col40,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col41,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col42,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col43,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col44,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col45,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col46,0,",",".")?></td>
                    <?php
                    $i++;
                }
                ?>
            </tbody>
        </table>
    </div>

    <br>

    <!-- SECCION A2 -->
    <div class="col-sm tab table-responsive" id="A2">
        <table class="table table-hover table-bordered table-sm">
            <thead>
                <tr>
                  <td colspan="46" class="active"><strong>SECCION A.2: INGRESOS POR CONDICIÓN DE SALUD.</strong></td>
                </tr>
                <tr>
                    <td rowspan="3" style="text-align:center; vertical-align:middle"><strong>CONDICIÓN DE SALUD</strong></td>
                    <td rowspan="3" style="text-align:center; vertical-align:middle"><strong>CONCEPTO</strong></td>
                    <td rowspan="3" style="text-align:center; vertical-align:middle"><strong>TOTAL</strong></td>
                    <td colspan="38" align="center"><strong>POR EDAD (en años)</strong></td>
                    <td colspan="3" align="center"><strong>TIPO DE ESTRATEGIA</strong></td>
                    <td rowspan="3" style="text-align:center; vertical-align:middle"><strong>OTROS</strong></td>
                    <td rowspan="3" style="text-align:center; vertical-align:middle"><strong>UAPORRINO</strong></td>
                </tr>
                <tr>
                    <td colspan="2" align="center"><strong>&lt; 12 meses</strong></td>
                    <td colspan="2" align="center"><strong>12 a 23 meses</strong></td>
                    <td colspan="2" align="center"><strong>2 - 4</strong></td>
                    <td colspan="2" align="center"><strong>5 - 9</strong></td>
                    <td colspan="2" align="center"><strong>10 - 14</strong></td>
                    <td colspan="2" align="center"><strong>15 - 19</strong></td>
                    <td colspan="2" align="center"><strong>20 - 24</strong></td>
                    <td colspan="2" align="center"><strong>25 - 29</strong></td>
                    <td colspan="2" align="center"><strong>30 - 34</strong></td>
                    <td colspan="2" align="center"><strong>35 - 39</strong></td>
                    <td colspan="2" align="center"><strong>40 - 44</strong></td>
                    <td colspan="2" align="center"><strong>45- 49</strong></td>
                    <td colspan="2" align="center"><strong>50 - 54</strong></td>
                    <td colspan="2" align="center"><strong>55 - 59</strong></td>
                    <td colspan="2" align="center"><strong>60 - 64</strong></td>
                    <td colspan="2" align="center"><strong>65 - 69</strong></td>
                    <td colspan="2" align="center"><strong>70 - 74</strong></td>
                    <td colspan="2" align="center"><strong>75 - 79</strong></td>
                    <td colspan="2" align="center"><strong>80 y mas</strong></td>
                    <td rowspan="2" align="center"><strong>Rehabilitación Base Comunitaria (RBC)</strong></td>
                    <td rowspan="2" align="center"><strong>Rehabilitación Integral(RI)</strong></td>
                    <td rowspan="2" align="center"><strong>Rehabilitación Rural (RR)</strong></td>
                </tr>
                <tr>
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
                              ,sum(ifnull(b.Col35,0)) Col35
                              ,sum(ifnull(b.Col36,0)) Col36
                              ,sum(ifnull(b.Col37,0)) Col37
                              ,sum(ifnull(b.Col38,0)) Col38
            									,sum(ifnull(b.Col39,0)) Col39
            									,sum(ifnull(b.Col40,0)) Col40
            									,sum(ifnull(b.Col41,0)) Col41
            									,sum(ifnull(b.Col42,0)) Col42
            									,sum(ifnull(b.Col43,0)) Col43
            									,sum(ifnull(b.Col44,0)) Col44
                          FROM (select c.* from 2020prestaciones c where c.codigo_prestacion in("28014800","05226300","05226500","05226600","05226700","28010600","28010700","28101010",
                                                                                                "05226800","28022110","05226900","28010800","28010900","28021633","28101020","28022120",
                                                                                                "28022130","28022140","28022150","28022160","28022170","28022180","28022190","28022200",
                                                                                                "28022210","28022220","28022230","28021623")) a
                          left join 2020rems b on (a.id_prestacion=b.prestacion_id_prestacion)
                          AND (b.Mes in ('.$mes.')) AND (b.establecimiento_id_establecimiento in ('.$estab.'))
                          group by a.codigo_prestacion, a.descripcion, a.id_prestacion
                          order by a.id_prestacion';
                $registro = DB::connection('mysql_rem')->select($query);

                $i=0;

                foreach($registro as $row ){
                    $nombre_descripcion = $row->codigo_prestacion;
                    if ($nombre_descripcion == "28014800"){
                      $nombre_descripcion = "TOTAL INGRESO (N° DE PERSONAS)";
                    }

                    if ($nombre_descripcion == "05226300"){
                      $nombre_descripcion = "SÍNDROME DOLOROSO DE ORIGEN TRAUMÁTICO";
                    }
                    if ($nombre_descripcion == "05226500"){
                      $nombre_descripcion = "ARTROSIS LEVE Y MODERADA DE RODILLA Y CADERA";
                    }
                    if ($nombre_descripcion == "05226600"){
                      $nombre_descripcion = "NEUROLOGICOS ACCIDENTE CEREBRO VASCULAR (ACV)";
                    }
                    if ($nombre_descripcion == "05226700"){
                      $nombre_descripcion = "NEUROLOGICOS  TRAUMATISMO ENCEFALO CRANEANO (TEC)";
                    }
                    if ($nombre_descripcion == "28010600"){
                      $nombre_descripcion = "NEUROLOGICOS LESIÓN MEDULAR";
                    }
                    if ($nombre_descripcion == "28010700"){
                      $nombre_descripcion = "QUEMADOS (NO GES)";
                    }
                    if ($nombre_descripcion == "28101010"){
                      $nombre_descripcion = "QUEMADOS (GES)";
                    }
                    if ($nombre_descripcion == "05226800"){
                      $nombre_descripcion = "ENFERMEDAD DE PARKINSON";
                    }
                    if ($nombre_descripcion == "28022110"){
                      $nombre_descripcion = "NEUROLÓGICOS DISRAFIA";
                    }
                    if ($nombre_descripcion == "05226900"){
                      $nombre_descripcion = "OTRO DÉFICIT SECUNDARIO CON COMPROMISO NEUROMUSCULAR EN MENOR DE 20 AÑOS CONGÉNITO";
                    }
                    if ($nombre_descripcion == "28010800"){
                      $nombre_descripcion = "OTRO DÉFICIT SECUNDARIO CON COMPROMISO NEUROMUSCULAR EN MENOR DE 20 AÑOS ADQUIRIDO";
                    }
                    if ($nombre_descripcion == "28010900"){
                      $nombre_descripcion = "OTRO DÉFICIT SECUNDARIO CON COMPROMISO NEUROMUSCULAR  EN MAYOR DE 20 AÑOS";
                    }
                    if ($nombre_descripcion == "28021633"){
                      $nombre_descripcion = "OTROS";
                    }
                    if ($nombre_descripcion == "28101020"){
                      $nombre_descripcion = "DIABETES MELLITUS	";
                    }
                    if ($nombre_descripcion == "28022120"){
                      $nombre_descripcion = "AMPUTACIÓN POR DIABETES";
                    }
                    if ($nombre_descripcion == "28022130"){
                      $nombre_descripcion = "AMPUTACIÓN POR OTRAS CAUSAS";
                    }
                    if ($nombre_descripcion == "28022140"){
                      $nombre_descripcion = "ARTROSIS SEVERA DE RODILLA Y CADERA";
                    }
                    if ($nombre_descripcion == "28022150"){
                      $nombre_descripcion = "OTRAS ARTROSIS";
                    }
                    if ($nombre_descripcion == "28022160"){
                      $nombre_descripcion = "REUMATOLOGICAS";
                    }
                    if ($nombre_descripcion == "28022170"){
                      $nombre_descripcion = "DOLOR LUMBAR";
                    }
                    if ($nombre_descripcion == "28022180"){
                      $nombre_descripcion = "HOMBRO DOLOROSO";
                    }
                    if ($nombre_descripcion == "28022190"){
                      $nombre_descripcion = "CUIDADOS PALIATIVOS";
                    }
                    if ($nombre_descripcion == "28022200"){
                      $nombre_descripcion = "OTROS SÍNDROMES DOLOROSOS NO TRAUMÁTICOS";
                    }

    						    if ($nombre_descripcion == "28022210"){
                      $nombre_descripcion = "CONDICIÓN SENSORIAL VISUAL";
                    }
                    if ($nombre_descripcion == "28022220"){
                      $nombre_descripcion = "CONDICIÓN SENSORIAL AUDITIVO";
                    }
                    if ($nombre_descripcion == "28022230"){
                      $nombre_descripcion = "OTROS";
                    }

                    if ($nombre_descripcion == "28021623"){
                      $nombre_descripcion = "CUIDADORES";
                    }
                    ?>
                <tr>
                    <?php
                    if($i==0){?>
                    <td align='left' colspan='2'><?php echo $nombre_descripcion; ?></td>
                    <?php
                    }
                    if($i==1){?>
                    <td rowspan='23' style="text-align:center; vertical-align:middle">CONDICIÓN FÍSICA</td>
                    <?php
                    }
                    if($i>=1 && $i<=23){?>
                      <td align='left' nowrap="nowrap"><?php echo $nombre_descripcion; ?></td>
                    <?php
                    }
                    if($i>=24){?>
                    <td align='left' colspan='2'><?php echo $nombre_descripcion; ?></td>
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
                    <td align='right'><?php echo number_format($row->Col41,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col42,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col43,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col44,0,",",".")?></td>
                    <?php
                    $i++;
                }
                ?>
            </tbody>
        </table>
    </div>

    <br>

    <div class="container">
    <!-- SECCION A3 -->
    <div class="col-sm tab table-responsive" id="A3">
        <table class="table table-hover table-bordered table-sm">
            <thead>
                <tr>
                  <td colspan="7" class="active"><strong>SECCIÓN A.3: EVALUACIÓN INICIAL.</strong></td>
                </tr>
                <tr>
                    <td rowspan="2" style="text-align:center; vertical-align:middle"><strong>PROFESIONAL</strong></td>
                    <td rowspan="2" style="text-align:center; vertical-align:middle"><strong>TOTAL</strong></td>
                    <td colspan="5" align="center"><strong>TIPO DE ESTRATEGIA </strong></td>
                </tr>
                <tr>
                    <td rowspan="2" align="center"><strong>Rehabilitación Base Comunitaria (RBC)</strong></td>
                    <td rowspan="2" align="center"><strong>Rehabilitación Integral(RI)</strong></td>
                    <td rowspan="2" align="center"><strong>Rehabilitación Rural (RR)</strong></td>
                    <td align="center"><strong>UAPORRINO</strong></td>
                    <td align="center"><strong>OTROS</strong></td>
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
            									,sum(ifnull(b.Col46,0)) Col46
                          FROM (select c.* from 2020prestaciones c where c.codigo_prestacion in("28010100","28010200","28010300","28010400","28010500")) a
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

                foreach($registro as $row ){
                    $totalCol01=$totalCol01+$row->Col01;
                    $totalCol02=$totalCol02+$row->Col02;
                    $totalCol03=$totalCol03+$row->Col03;
                    $totalCol04=$totalCol04+$row->Col04;
                    $totalCol05=$totalCol05+$row->Col05;
                    $totalCol06=$totalCol06+$row->Col06;

                    $nombre_descripcion = $row->codigo_prestacion;
                    if ($nombre_descripcion == "28010100"){
                        $nombre_descripcion = "MÉDICO";
                    }
                    if ($nombre_descripcion == "28010200"){
                        $nombre_descripcion = "KINESIÓLOGO";
                    }
                    if ($nombre_descripcion == "28010300"){
                        $nombre_descripcion = "TERAPEUTA OCUPACIONAL";
                    }
                    if ($nombre_descripcion == "28010400"){
                        $nombre_descripcion = "FONOAUDIÓLOGO";
                    }
                    if ($nombre_descripcion == "28010500"){
                        $nombre_descripcion = "PSICÓLOGO/A";
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
                </tr>
            </tbody>
        </table>
    </div>

    <br>

    <!-- SECCION A4 -->
    <div class="col-sm tab table-responsive" id="A4">
        <table class="table table-hover table-bordered table-sm">
            <thead>
                <tr>
                  <td colspan="7" class="active"><strong>SECCIÓN A.4: EVALUACIÓN INTERMEDIA.</strong></td>
                </tr>
                <tr>
                    <td align="center"><strong>PROFESIONAL</strong></td>
                    <td align="center"><strong>TOTAL</strong></td>
                    <td align="center"><strong>Rehabilitación Base Comunitaria (RBC)</strong></td>
                    <td align="center"><strong>Rehabilitación Integral(RI)</strong></td>
                    <td align="center"><strong>Rehabilitación Rural (RR)</strong></td>
                    <td align="center"><strong>UAPORRINO</strong></td>
                    <td align="center"><strong>Otros</strong></td>
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
                          FROM (select c.* from 2020prestaciones c where c.codigo_prestacion in("28011000","28011100","28011200","28011300")) a
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

                foreach($registro as $row ){
                    $totalCol01=$totalCol01+$row->Col01;
                    $totalCol02=$totalCol02+$row->Col02;
                    $totalCol03=$totalCol03+$row->Col03;
                    $totalCol04=$totalCol04+$row->Col04;
                    $totalCol05=$totalCol05+$row->Col05;
                    $totalCol06=$totalCol06+$row->Col06;

                    $nombre_descripcion = $row->codigo_prestacion;
                    if ($nombre_descripcion == "28011000"){
                        $nombre_descripcion = "KINESIÓLOGO";
                    }
                    if ($nombre_descripcion == "28011100"){
                        $nombre_descripcion = "TERAPEUTA OCUPACIONAL";
                    }
                    if ($nombre_descripcion == "28011200"){
                        $nombre_descripcion = "FONOAUDIÓLOGO";
                    }
                    if ($nombre_descripcion == "28011300"){
                        $nombre_descripcion = "PSICÓLOGO/A";
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
                </tr>
            </tbody>
        </table>
    </div>

    <br>

    <!-- SECCION A5 -->
    <div class="col-sm tab table-responsive" id="A5">
        <table class="table table-hover table-bordered table-sm">
            <thead>
                <tr>
                  <td colspan="7" class="active"><strong>SECCIÓN A.5: SESIONES DE REHABILITACIÓN.</strong></td>
                </tr>
                <tr>
                    <td align="center"><strong>PROFESIONAL</strong></td>
                    <td align="center"><strong>TOTAL</strong></td>
                    <td align="center"><strong>Rehabilitación Base Comunitaria (RBC)</strong></td>
                    <td align="center"><strong>Rehabilitación Integral(RI)</strong></td>
                    <td align="center"><strong>Rehabilitación Rural (RR)</strong></td>
                    <td align="center"><strong>UAPORRINO</strong></td>
                    <td align="center"><strong>Otros</strong></td>
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
                          FROM (select c.* from 2020prestaciones c where c.codigo_prestacion in("28020660","28020670","28020680","28020690")) a
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

                foreach($registro as $row ){
                    $totalCol01=$totalCol01+$row->Col01;
                    $totalCol02=$totalCol02+$row->Col02;
                    $totalCol03=$totalCol03+$row->Col03;
                    $totalCol04=$totalCol04+$row->Col04;
                    $totalCol05=$totalCol05+$row->Col05;
                    $totalCol06=$totalCol06+$row->Col06;

                    $nombre_descripcion = $row->codigo_prestacion;
                    if ($nombre_descripcion == "28020660"){
                        $nombre_descripcion = "KINESIÓLOGO";
                    }
                    if ($nombre_descripcion == "28020670"){
                        $nombre_descripcion = "TERAPEUTA OCUPACIONAL";
                    }
                    if ($nombre_descripcion == "28020680"){
                        $nombre_descripcion = "FONOAUDIÓLOGO";
                    }
                    if ($nombre_descripcion == "28020690"){
                        $nombre_descripcion = "PSICÓLOGO/A";
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
                </tr>
            </tbody>
        </table>
    </div>

    <br>

    <!-- SECCION A6 -->
    <div class="col-sm tab table-responsive" id="A6">
        <table class="table table-hover table-bordered table-sm">
            <thead>
                <tr>
                  <td colspan="6" class="active"><strong>SECCIÓN A.6: PROCEDIMIENTOS Y ACTIVIDADES.</strong></td>
                </tr>
                <tr>
                    <td align="center"><strong>TIPO</strong></td>
                    <td align="center"><strong>Total Rehabilitacion Base Comunitaria</strong></td>
                    <td align="center"><strong>Total Rehabilitación Integral</strong></td>
                    <td align="center"><strong>Total Rehabilitacion Rural</strong></td>
                    <td align="center"><strong>Otros</strong></td>
                    <td align="center"><strong>UAPORRINO</strong></td>
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
                          FROM (select c.* from 2020prestaciones c where c.codigo_prestacion in("28011400","28020721","28011500","28022240","28022250","28022260","28011700","28022270",
                                                                                                "28022280","28022290","28022300","28022310","28101030","28022320","28022330","28012000",
                                                                                                "28012200","28020710","28012400","28012500","28022340","28022350","28011600","28012300",
                                                                                                "28020720","28020722","28020723","28020724","28022360","28022370")) a
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

                foreach($registro as $row ){
                    $totalCol01=$totalCol01+$row->Col01;
                    $totalCol02=$totalCol02+$row->Col02;
                    $totalCol03=$totalCol03+$row->Col03;
                    $totalCol04=$totalCol04+$row->Col04;
                    $totalCol05=$totalCol05+$row->Col05;

                    $nombre_descripcion = $row->codigo_prestacion;
                    if ($nombre_descripcion == "28011400"){
                        $nombre_descripcion = "EVALUACIÓN AYUDAS TÉCNICAS";
                    }
                    if ($nombre_descripcion == "28020721"){
                        $nombre_descripcion = "ENTRENAMIENTO DE AYUDAS TECNICAS";
                    }
                    if ($nombre_descripcion == "28011500"){
                        $nombre_descripcion = "FISIOTERAPIA";
                    }
                    if ($nombre_descripcion == "28022240"){
                        $nombre_descripcion = "TRATAMIENTO COMPRESIVO";
                    }
                    if ($nombre_descripcion == "28022250"){
                        $nombre_descripcion = "ENTRENAMIENTO PROTÉSICO";
                    }
                    if ($nombre_descripcion == "28022260"){
                        $nombre_descripcion = "ASPIRACIÓN";
                    }
                    if ($nombre_descripcion == "28011700"){
                        $nombre_descripcion = "EJERCICIOS TERAPÉUTICOS";
                    }
                    if ($nombre_descripcion == "28022270"){
                        $nombre_descripcion = "EVALUACIÓN DEL HABLA Y LENGUAJE";
                    }
                    if ($nombre_descripcion == "28022280"){
                        $nombre_descripcion = "TRATAMIENTO (VOZ, HABLA Y/O LENGUAJE)";
                    }
                    if ($nombre_descripcion == "28022290"){
                        $nombre_descripcion = "TRATAMIENTO FUNCIONES MOTORAS ORALES";
                    }
                    if ($nombre_descripcion == "28022300"){
                        $nombre_descripcion = "ESTIMULACIÓN COGNITIVA";
                    }
                    if ($nombre_descripcion == "28022310"){
                        $nombre_descripcion = "PREVENCIÓN DE DETERIORO DE ÓRGANOS FONO ARTICULATORIOS (OFA)";
                    }
                    if ($nombre_descripcion == "28101030"){
                        $nombre_descripcion = "REHABILITACIÓN DEGLUCIÓN";
                    }
                    if ($nombre_descripcion == "28022320"){
                        $nombre_descripcion = "EVALUACIÓN DE DISFAGIA";
                    }
                    if ($nombre_descripcion == "28022330"){
                        $nombre_descripcion = "REHABILITACIÓN DISFAGIA";
                    }
                    if ($nombre_descripcion == "28012000"){
                        $nombre_descripcion = "CONFECCIÓN ÓRTESIS Y/O ADAPTACIONES";
                    }
                    if ($nombre_descripcion == "28012200"){
                        $nombre_descripcion = "HABILITACIÓN Y REHABILITACIÓN EN ACTIVIDADES DE LA VIDA DIARIA (AVD)";
                    }
                    if ($nombre_descripcion == "28020710"){
                        $nombre_descripcion = "HABILITACIÓN Y REHABILITACIÓN EDUCACIONAL";
                    }
                    if ($nombre_descripcion == "28012400"){
                        $nombre_descripcion = "ACTIVIDADES RECREATIVAS";
                    }
                    if ($nombre_descripcion == "28012500"){
                        $nombre_descripcion = "ACTIVIDADES TERAPÉUTICAS";
                    }
                    if ($nombre_descripcion == "28022340"){
                        $nombre_descripcion = "INTEGRACIÓN SENSORIAL";
                    }
                    if ($nombre_descripcion == "28022350"){
                        $nombre_descripcion = "PSICOTERAPIA";
                    }
                    if ($nombre_descripcion == "28011600"){
                        $nombre_descripcion = "MASOTERAPIA";
                    }
                    if ($nombre_descripcion == "28012300"){
                        $nombre_descripcion = "ADAPTACIÓN DEL HOGAR";
                    }
                    if ($nombre_descripcion == "28020720"){
                        $nombre_descripcion = "ORIENTACIÓN Y MOVILIDAD";
                    }
                    if ($nombre_descripcion == "28020722"){
                        $nombre_descripcion = "ORIENTACIÓN SOCIOLABORAL";
                    }
                    if ($nombre_descripcion == "28020723"){
                        $nombre_descripcion = "ORIENTACIÓN FAMILIAR Y A LA RED DE APOYO PARA EL TRABAJO";
                    }
                    if ($nombre_descripcion == "28020724"){
                        $nombre_descripcion = "GESTIÓN DE LA RED LOCAL PARA EL TRABAJO";
                    }
                    if ($nombre_descripcion == "28022360"){
                        $nombre_descripcion = "REHABILITACIÓN AUDITIVA INDIVIDUAL";
                    }
                    if ($nombre_descripcion == "28022370"){
                        $nombre_descripcion = "REHABILITACIÓN AUDITIVA GRUPAL";
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
                <tr>
                    <td align='left'><strong>TOTAL</strong></td>
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

    <!-- SECCION A7 -->
    <div class="col-sm tab table-responsive" id="A7">
        <table class="table table-hover table-bordered table-sm">
            <thead>
                <tr>
                  <td colspan="6" class="active"><strong>SECCIÓN A.7: CONSEJERÍA INDIVIDUAL AGENDADA.</strong></td>
                </tr>
                <tr>
                    <td align="center"><strong>TIPO</strong></td>
                    <td align="center"><strong>Total Rehabilitacion Base Comunitaria</strong></td>
                    <td align="center"><strong>Total Rehabilitación Integral</strong></td>
                    <td align="center"><strong>Total Rehabilitacion Rural</strong></td>
                    <td align="center"><strong>Otros</strong></td>
                    <td align="center"><strong>UAPORRINO</strong></td>
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
                          FROM (select c.* from 2020prestaciones c where c.codigo_prestacion in("28012600","28012700","28012800","28012900","28013000")) a
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

                foreach($registro as $row ){
                    $totalCol01=$totalCol01+$row->Col01;
                    $totalCol02=$totalCol02+$row->Col02;
                    $totalCol03=$totalCol03+$row->Col03;
                    $totalCol04=$totalCol04+$row->Col04;
                    $totalCol05=$totalCol05+$row->Col05;

                    $nombre_descripcion = $row->codigo_prestacion;
                    if ($nombre_descripcion == "28012600"){
                        $nombre_descripcion = "KINESIÓLOGO";
                    }
                    if ($nombre_descripcion == "28012700"){
                        $nombre_descripcion = "TERAPEUTA OCUPACIONAL";
                    }
                    if ($nombre_descripcion == "28012800"){
                        $nombre_descripcion = "FONOAUDIÓLOGO";
                    }
                    if ($nombre_descripcion == "28012900"){
                        $nombre_descripcion = "PSICÓLOGO/A";
                    }
                    if ($nombre_descripcion == "28013000"){
                        $nombre_descripcion = "ASISTENTE SOCIAL";
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
                <tr>
                    <td align='left'><strong>TOTAL</strong></td>
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

    <!-- SECCION A8 -->
    <div class="col-sm tab table-responsive" id="A8">
        <table class="table table-hover table-bordered table-sm">
            <thead>
                <tr>
                  <td colspan="6" class="active"><strong>SECCIÓN A.8: CONSEJERÍA FAMILIAR AGENDADA.</strong></td>
                </tr>
                <tr>
                    <td align="center"><strong>PROFESIONAL</strong></td>
                    <td align="center"><strong>Total Rehabilitacion Base Comunitaria</strong></td>
                    <td align="center"><strong>Total Rehabilitación Integral</strong></td>
                    <td align="center"><strong>Total Rehabilitacion Rural</strong></td>
                    <td align="center"><strong>Otros</strong></td>
                    <td align="center"><strong>UAPORRINO</strong></td>
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
                          FROM (select c.* from 2020prestaciones c where c.codigo_prestacion in("28013100","28013200","28013300","28013400","28013500")) a
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

                foreach($registro as $row ){
                    $totalCol01=$totalCol01+$row->Col01;
                    $totalCol02=$totalCol02+$row->Col02;
                    $totalCol03=$totalCol03+$row->Col03;
                    $totalCol04=$totalCol04+$row->Col04;
                    $totalCol05=$totalCol05+$row->Col05;

                    $nombre_descripcion = $row->codigo_prestacion;
                    if ($nombre_descripcion == "28013100"){
                        $nombre_descripcion = "KINESIÓLOGO";
                    }
                    if ($nombre_descripcion == "28013200"){
                        $nombre_descripcion = "TERAPEUTA OCUPACIONAL";
                    }
                    if ($nombre_descripcion == "28013300"){
                        $nombre_descripcion = "FONOAUDIÓLOGO";
                    }
                    if ($nombre_descripcion == "28013400"){
                        $nombre_descripcion = "PSICÓLOGO/A";
                    }
                    if ($nombre_descripcion == "28013500"){
                        $nombre_descripcion = "ASISTENTE SOCIAL";
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
                <tr>
                    <td align='left'><strong>TOTAL</strong></td>
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

    <!-- SECCION A9 -->
    <div class="col-sm tab table-responsive" id="A9">
        <table class="table table-hover table-bordered table-sm">
            <thead>
                <tr>
                  <td colspan="7" class="active"><strong>SECCIÓN A.9: VISITAS DOMICILIARIAS INTEGRALES.</strong></td>
                </tr>
                <tr>
                    <td rowspan="2" style="text-align:center; vertical-align:middle"><strong>FAMILIA</strong></td>
                    <td rowspan="2" style="text-align:center; vertical-align:middle"><strong>TOTAL</strong></td>
                    <td colspan="5" align="center"><strong>TIPO DE ESTRATEGIA</strong></td>
                </tr>
                    <td align="center"><strong>Rehabilitación Base Comunitaria (RBC)</strong></td>
                    <td align="center"><strong>Rehabilitación Integral(RI)</strong></td>
                    <td align="center"><strong>Rehabilitación Rural (RR)</strong></td>
                    <td align="center"><strong>Otros</strong></td>
                    <td align="center"><strong>UAPORRINO</strong></td>
                <tr>
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
                          FROM (select c.* from 2020prestaciones c where c.codigo_prestacion in("26274800","28021624")) a
                          left join 2020rems b on (a.id_prestacion=b.prestacion_id_prestacion)
                          AND (b.Mes in ('.$mes.')) AND (b.establecimiento_id_establecimiento in ('.$estab.'))
                          group by a.codigo_prestacion, a.descripcion, a.id_prestacion
                          order by a.id_prestacion';
                $registro = DB::connection('mysql_rem')->select($query);

                $i=0;

                foreach($registro as $row ){
                    $nombre_descripcion = $row->codigo_prestacion;
                    if ($nombre_descripcion == "26274800"){
                        $nombre_descripcion = "VISITA DOMICILIARIA INTEGRAL";
                    }
                    if ($nombre_descripcion == "28021624"){
                        $nombre_descripcion = "VISITA DE TRATAMIENTO Y/O PROCEDIMIENTO";
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
                    <?php
                    $i++;
                }
                ?>
                </tr>
            </tbody>
        </table>
    </div>

    <br>

    <!-- SECCION A10 -->
    <div class="col-sm tab table-responsive" id="A10">
        <table class="table table-hover table-bordered table-sm">
            <thead>
                <tr>
                  <td colspan="7" class="active"><strong>SECCIÓN A.10: NÚMERO DE PERSONAS QUE INGRESAN Y NÚMERO DE SESIONES DE EDUCACIÓN GRUPAL.</strong></td>
                </tr>
                <tr>
                    <td rowspan="2" style="text-align:center; vertical-align:middle"><strong>FAMILIA</strong></td>
                    <td rowspan="2" style="text-align:center; vertical-align:middle"><strong>TOTAL</strong></td>
                    <td colspan="5" align="center"><strong>TIPO DE ESTRATEGIA</strong></td>
                </tr>
                    <td align="center"><strong>Rehabilitación Base Comunitaria (RBC)</strong></td>
                    <td align="center"><strong>Rehabilitación Integral(RI)</strong></td>
                    <td align="center"><strong>Rehabilitación Rural (RR)</strong></td>
                    <td align="center"><strong>Otros</strong></td>
                    <td align="center"><strong>UAPORRINO</strong></td>
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
                          FROM (select c.* from 2020prestaciones c where c.codigo_prestacion in("27300800","28013600")) a
                          left join 2020rems b on (a.id_prestacion=b.prestacion_id_prestacion)
                          AND (b.Mes in ('.$mes.')) AND (b.establecimiento_id_establecimiento in ('.$estab.'))
                          group by a.codigo_prestacion, a.descripcion, a.id_prestacion
                          order by a.id_prestacion';
                $registro = DB::connection('mysql_rem')->select($query);

                $i=0;

                foreach($registro as $row ){
                    $nombre_descripcion = $row->codigo_prestacion;
                    if ($nombre_descripcion == "27300800"){
                        $nombre_descripcion = "NÚMERO DE PERSONAS";
                    }
                    if ($nombre_descripcion == "28013600"){
                        $nombre_descripcion = "NÚMERO DE SESIONES";
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

    <!-- SECCION A11 -->
    <div class="col-sm tab table-responsive" id="A11">
        <table class="table table-hover table-bordered table-sm">
            <thead>
                <tr>
                  <td colspan="12" class="active"><strong>SECCIÓN A.11: PERSONAS QUE LOGRAN PARTICIPACION EN COMUNIDAD.</strong></td>
                </tr>
                <tr>
                    <td rowspan="2" style="text-align:center; vertical-align:middle"><strong>COMPONENTE (Nº PERSONAS)</strong></td>
                    <td rowspan="2" style="text-align:center; vertical-align:middle"><strong>TOTAL</strong></td>
                    <td colspan="3" align="center"><strong>LABORAL</strong></td>
                    <td rowspan="2" style="text-align:center; vertical-align:middle"><strong>Educativa</strong></td>
                    <td rowspan="2" style="text-align:center; vertical-align:middle"><strong>Comunitario</strong></td>
                    <td colspan="5" align="center"><strong>TIPO DE ESTRATEGIA</strong></td>
                </tr>
                    <td align="center"><strong>Trabajo con objetivos de habilitación y rehabilitación</strong></td>
                    <td align="center"><strong>Trabajo sin objetivos de habilitación y rehabilitación</strong></td>
                    <td align="center"><strong>Dueña/o de casa</strong></td>
                    <td align="center"><strong>Rehabilitación Base Comunitaria (RBC)</strong></td>
                    <td align="center"><strong>Rehabilitación Integral(RI)</strong></td>
                    <td align="center"><strong>Rehabilitación Rural (RR)</strong></td>
                    <td align="center"><strong>Otros</strong></td>
                    <td align="center"><strong>UAPORRINO</strong></td>
                <tr>
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
                          FROM (select c.* from 2020prestaciones c where c.codigo_prestacion in("28020730","28020740","28020750")) a
                          left join 2020rems b on (a.id_prestacion=b.prestacion_id_prestacion)
                          AND (b.Mes in ('.$mes.')) AND (b.establecimiento_id_establecimiento in ('.$estab.'))
                          group by a.codigo_prestacion, a.descripcion, a.id_prestacion
                          order by a.id_prestacion';
                $registro = DB::connection('mysql_rem')->select($query);

                $i=0;

                foreach($registro as $row ){
                    $nombre_descripcion = $row->codigo_prestacion;
                    if ($nombre_descripcion == "28020730"){
                        $nombre_descripcion = "CONDICIÓN FÍSICA";
                    }
                    if ($nombre_descripcion == "28020740"){
                        $nombre_descripcion = "CONDICIÓN SENSORIAL VISUAL";
                    }
                    if ($nombre_descripcion == "28020750"){
                        $nombre_descripcion = "CONDICIÓN SENSORIAL AUDITIVO";
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
    <!-- SECCION A12 -->
    <div class="col-sm tab table-responsive" id="A12">
        <table class="table table-hover table-bordered table-sm">
            <thead>
                <tr>
                    <td colspan="10" class="active"><strong>SECCIÓN A.12: ACTIVIDADES Y PARTICIPACION.</strong></td>
                </tr>
                <tr>
                    <td rowspan="2" style="text-align:center; vertical-align:middle"><strong>MODALIDADES DE INTERVENCIÓN</strong></td>
                    <td rowspan="2" style="text-align:center; vertical-align:middle"><strong>GRUPO OBJETIVO</strong></td>
                    <td align='center' colspan="2"><strong>TOTALES RBC</strong></td>
                    <td align='center' colspan="2"><strong>TOTALES RI</strong></td>
                    <td align='center' colspan="2"><strong>TOTALES RR</strong></td>
                    <td align='center' colspan="2"><strong>OTROS TOTALES</strong></td>
                </tr>
                <tr>
                    <td align='center'><strong>Actividades</strong></td>
                    <td align='center'><strong>Participantes</strong></td>
                    <td align='center'><strong>Actividades</strong></td>
                    <td align='center'><strong>Participantes</strong></td>
                    <td align='center'><strong>Actividades</strong></td>
                    <td align='center'><strong>Participantes</strong></td>
                    <td align='center'><strong>Actividades</strong></td>
                    <td align='center'><strong>Participantes</strong></td>
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
                          FROM (select c.* from 2020prestaciones c where c.codigo_prestacion in("28020760","28020770","28020780","28020790",
                                                                                                "28020800","28020810","28020820","28020830","28020840",
                                                                                                "28020850","28020860","28020870","28020880","28020890","28020900","28101040")) a
                          left join 2020rems b on (a.id_prestacion=b.prestacion_id_prestacion)
                          AND (b.Mes in ('.$mes.')) AND (b.establecimiento_id_establecimiento in ('.$estab.'))
                          group by a.codigo_prestacion, a.descripcion, a.id_prestacion
                          order by a.id_prestacion';
                $registro = DB::connection('mysql_rem')->select($query);

                $i=0;

                foreach($registro as $row ){
                    $nombre_descripcion = $row->codigo_prestacion;
                    if ($nombre_descripcion == "28020760"){
                        $nombre_descripcion = "COMUNAS, COMUNIDADES";
                    }
                    if ($nombre_descripcion == "28020770"){
                        $nombre_descripcion = "ORGANIZACIONES ASOCIADAS A DISCAPACIDAD";
                    }
                    if ($nombre_descripcion == "28020780"){
                        $nombre_descripcion = "ORGANIZACIONES COMUNITARIAS";
                    }
                    if ($nombre_descripcion == "28020790"){
                        $nombre_descripcion = "COMUNIDAD EDUCATIVA";
                    }

                    if ($nombre_descripcion == "28020800"){
                        $nombre_descripcion = "COMUNAS COMUNIDADES";
                    }
                    if ($nombre_descripcion == "28020810"){
                        $nombre_descripcion = "EMPLEADORES Y COMPAÑEROS DE TRABAJO";
                    }
                    if ($nombre_descripcion == "28020820"){
                        $nombre_descripcion = "COMUNIDAD EDUCATIVA";
                    }
                    if ($nombre_descripcion == "28020830"){
                        $nombre_descripcion = "RED DE APOYO";
                    }
                    if ($nombre_descripcion == "28020840"){
                        $nombre_descripcion = "CUIDADORES";
                    }

                    if ($nombre_descripcion == "28020850"){
                        $nombre_descripcion = "PROFESIONALES DE SALUD";
                    }
                    if ($nombre_descripcion == "28020860"){
                        $nombre_descripcion = "EMPLEADORES Y COMPAÑEROS DE TRABAJO";
                    }
                    if ($nombre_descripcion == "28020870"){
                        $nombre_descripcion = "COMUNIDAD EDUCATIVA";
                    }
                    if ($nombre_descripcion == "28020880"){
                        $nombre_descripcion = "MONITORES";
                    }
                    if ($nombre_descripcion == "28020890"){
                        $nombre_descripcion = "RED DE APOYO";
                    }
                    if ($nombre_descripcion == "28020900"){
                        $nombre_descripcion = "CUIDADORES";
                    }

                    if ($nombre_descripcion == "28101040"){
                        $nombre_descripcion = "ORGANIZACIONES COMUNITARIAS";
                    }
                    ?>
                <tr>
                    <?php
                    if($i==0){?>
                    <td rowspan="4" style="text-align:center; vertical-align:middle">DIAGNÓSTICO O PLANIFICACIÓN PARTICIPATIVA</td>
                    <?php
                    }
                    if($i==4){?>
                    <td rowspan="5" style="text-align:center; vertical-align:middle">ACTIVIDADES DE PROMOCIÓN DE LA SALUD</td>
                    <?php
                    }
                    if($i==9){?>
                    <td rowspan="6" style="text-align:center; vertical-align:middle">ACTIVIDADES PARA FORTALECER LOS CONOCIMIENTOS Y DESTREZAS PERSONALES</td>
                    <?php
                    }
                    if($i==15){?>
                    <td style="text-align:center; vertical-align:middle">ASESORÍA A GRUPOS COMUNITARIOS</td>
                    <?php
                    }

                    ?>
                    <td align='left'><?php echo $nombre_descripcion; ?></td>
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
            </tbody>
        </table>
    </div>
    </div>

    <br>

    <!-- SECCION B1 -->
    <div class="col-sm tab table-responsive" id="B1">
        <table class="table table-hover table-bordered table-sm">
            <thead>
                <tr>
                  <td colspan="45" class="active"><strong>SECCIÓN B: NIVEL HOSPITALARIO</strong></td>
                </tr>
                <tr>
                  <td colspan="45" class="active"><strong>SECCIÓN B.1: INGRESOS Y EGRESOS AL PROGRAMA DE REHABILITACIÓN INTEGRAL.</strong></td>
                </tr>
                <tr>
                  <td rowspan="3" style="text-align:center; vertical-align:middle"><strong>INGRESOS</strong></td>
                  <td colspan="3" rowspan="2" style="text-align:center; vertical-align:middle"><strong>TOTAL</strong></td>
                  <td colspan="38" align="center"><strong>POR EDAD (en años)</strong></td>
                  <td colspan="3" align="center"><strong>TIPO ATENCION</strong></td>
                </tr>
                <tr>
                  <td colspan="2" align="center"><strong>&lt; 12 meses</strong></td>
                  <td colspan="2" align="center"><strong>12 a 23 meses</strong></td>
                  <td colspan="2" align="center"><strong>2 - 4</strong></td>
                  <td colspan="2" align="center"><strong>5 - 9</strong></td>
                  <td colspan="2" align="center"><strong>10 - 14</strong></td>
                  <td colspan="2" align="center"><strong>15 - 19</strong></td>
                  <td colspan="2" align="center"><strong>20 - 24</strong></td>
                  <td colspan="2" align="center"><strong>25 - 29</strong></td>
                  <td colspan="2" align="center"><strong>30 - 34</strong></td>
                  <td colspan="2" align="center"><strong>35 - 39</strong></td>
                  <td colspan="2" align="center"><strong>40 - 44</strong></td>
                  <td colspan="2" align="center"><strong>45- 49</strong></td>
                  <td colspan="2" align="center"><strong>50 - 54</strong></td>
                  <td colspan="2" align="center"><strong>55 - 59</strong></td>
                  <td colspan="2" align="center"><strong>60 - 64</strong></td>
                  <td colspan="2" align="center"><strong>65 - 69</strong></td>
                  <td colspan="2" align="center"><strong>70 - 74</strong></td>
                  <td colspan="2" align="center"><strong>75 - 79</strong></td>
                  <td colspan="2" align="center"><strong>80 y mas</strong></td>
                  <td rowspan="3" align="center"><strong>Abierta</strong></td>
                  <td colspan="2" align="center"><strong>CERRADA</strong></td>
                </tr>
                <tr>
                  <td align="center"><strong>Ambos Sexos</strong></td>
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
                  <td align="center"><strong>UPC</strong></td>
                  <td align="center"><strong>Cuidados Medios y Básicos</strong></td>
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
            									,sum(ifnull(b.Col44,0)) Col44
                          FROM (select c.* from 2020prestaciones c where c.codigo_prestacion in("28021620","28021625","28020940","28020950","28020960","28022380","28020970","28020980",
                                                                                                "28020990","28101050","28021000","28021110","28021120","28021130")
                                                                                              ) a
                          left join 2020rems b on (a.id_prestacion=b.prestacion_id_prestacion)
                          AND (b.Mes in ('.$mes.')) AND (b.establecimiento_id_establecimiento in ('.$estab.'))
                          group by a.codigo_prestacion, a.descripcion, a.id_prestacion
                          order by a.id_prestacion';
                $registro = DB::connection('mysql_rem')->select($query);

                $i=0;

                foreach($registro as $row ){
                    $nombre_descripcion = $row->codigo_prestacion;
                    if ($nombre_descripcion == "28021620"){
                        $nombre_descripcion = "TOTAL INGRESO (N° DE PERSONAS)";
                    }
                    if ($nombre_descripcion == "28021625"){
                        $nombre_descripcion = "INGRESOS CON PLAN DE TRATAMIENTO INTEGRAL (PTI)";
                    }
                    if ($nombre_descripcion == "28020940"){
                        $nombre_descripcion = "NEUROLÓGICOS TRAUMATISMO ENCÉFALO CRANEANO (TEC)";
                    }
                    if ($nombre_descripcion == "28020950"){
                        $nombre_descripcion = "NEUROLÓGICOS LESIÓN MEDULAR ";
                    }
                    if ($nombre_descripcion == "28020960"){
                        $nombre_descripcion = "NEUROLÓGICOS ACCIDENTE CEREBRO VASCULAR (ACV)";
                    }
                    if ($nombre_descripcion == "28022380"){
                        $nombre_descripcion = "NEUROLOGICOS DISRAFIA";
                    }
                    if ($nombre_descripcion == "28020970"){
                        $nombre_descripcion = "NEUROLÓGICAS TUMORES";
                    }
                    if ($nombre_descripcion == "28020980"){
                        $nombre_descripcion = "PARÁLISIS CEREBRAL";
                    }
                    if ($nombre_descripcion == "28020990"){
                        $nombre_descripcion = "QUEMADOS (NO GES)";
                    }
                    if ($nombre_descripcion == "28101050"){
                        $nombre_descripcion = "GRAN QUEMADO (GES)";
                    }
                    if ($nombre_descripcion == "28021000"){
                        $nombre_descripcion = "SENSORIALES AUDITIVOS";
                    }
                    if ($nombre_descripcion == "28021110"){
                        $nombre_descripcion = "SENSORIALES VISUALES";
                    }
                    if ($nombre_descripcion == "28021120"){
                        $nombre_descripcion = "TRAUMATOLÓGICOS";
                    }
                    if ($nombre_descripcion == "28021130"){
                        $nombre_descripcion = "AMPUTADOS POR OTRAS CAUSAS";
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
                    <td align='right'><?php echo number_format($row->Col35,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col36,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col37,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col38,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col39,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col40,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col41,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col42,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col43,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col44,0,",",".")?></td>
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
            									,sum(ifnull(b.Col44,0)) Col44
                          FROM (select c.* from 2020prestaciones c where c.codigo_prestacion in("28022390","28101060","28021150","28021160","28021170","28021180","28022400","28022410",
                                                                                                "28022420","28022430","28022440","28101070","28021190")
                                                                                              ) a
                          left join 2020rems b on (a.id_prestacion=b.prestacion_id_prestacion)
                          AND (b.Mes in ('.$mes.')) AND (b.establecimiento_id_establecimiento in ('.$estab.'))
                          group by a.codigo_prestacion, a.descripcion, a.id_prestacion
                          order by a.id_prestacion';
                $registro = DB::connection('mysql_rem')->select($query);

                $i=0;

                // 28022390	AMPUTADOS POR DIABETES
                // 28101060	ENFERMEDADES DEL CORAZÓN
                // 28021150	RESPIRATORIO
                // 28021160	NEUROMUSCULARES AGUDAS
                // 28021170	NEUROMUSCULARES CRÓNICAS
                // 28021180	REUMATOLÓGICAS
                // 28022400	NEUROLÓGICAS ESCLEROSIS LATERAL AMIOTRÓFICA (ELA)
                // 28022410	RETRASO EN EL DESARROLLO PSICOMOTOR
                // 28022420	ONCOLÓGICOS
                // 28022430	SINDROME DE INMOVILIZACIÓN
                // 28022440	CUIDADOS PALIATIVOS
                // 28101070	CIRUGÍA MAYOR ABDOMINAL
                // 28021190	OTROS

                foreach($registro as $row ){
                    $nombre_descripcion = $row->codigo_prestacion;

                    if ($nombre_descripcion == "28022390"){
                        $nombre_descripcion = "AMPUTADOS POR DIABETES";
                    }
                    if ($nombre_descripcion == "28101060"){
                        $nombre_descripcion = "ENFERMEDADES DEL CORAZÓN";
                    }
                    if ($nombre_descripcion == "28021140"){
                        $nombre_descripcion = "CARDIOVASCULAR";
                    }
                    if ($nombre_descripcion == "28021150"){
                        $nombre_descripcion = "RESPIRATORIO";
                    }
                    if ($nombre_descripcion == "28021160"){
                        $nombre_descripcion = "NEUROMUSCULARES AGUDAS";
                    }
                    if ($nombre_descripcion == "28021170"){
                        $nombre_descripcion = "NEUROMUSCULARES CRÓNICAS";
                    }
                    if ($nombre_descripcion == "28021180"){
                        $nombre_descripcion = "REUMATOLÓGICAS";
                    }
                    if ($nombre_descripcion == "28022400"){
                        $nombre_descripcion = "NEUROLÓGICAS ESCLEROSIS LATERAL AMIOTRÓFICA (ELA)";
                    }
                    if ($nombre_descripcion == "28022410"){
                        $nombre_descripcion = "RETRASO EN EL DESARROLLO PSICOMOTOR";
                    }
                    if ($nombre_descripcion == "28022420"){
                        $nombre_descripcion = "ONCOLÓGICOS";
                    }
                    if ($nombre_descripcion == "28022430"){
                        $nombre_descripcion = "SINDROME DE INMOVILIZACIÓN";
                    }
                    if ($nombre_descripcion == "28022440"){
                        $nombre_descripcion = "CUIDADOS PALIATIVOS";
                    }
                    if ($nombre_descripcion == "28101070"){
                        $nombre_descripcion = "CIRUGÍA MAYOR ABDOMINAL";
                    }
                    if ($nombre_descripcion == "28021190"){
                        $nombre_descripcion = "OTROS";
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
                    <td align='right'><?php echo number_format($row->Col35,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col36,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col37,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col38,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col39,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col40,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col41,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col42,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col43,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col44,0,",",".")?></td>
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
            									,sum(ifnull(b.Col44,0)) Col44
                          FROM (select c.* from 2020prestaciones c where c.codigo_prestacion in("28021200","28021210","28021220","28021626","28021627")) a
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
                $totalCol35=0;
                $totalCol36=0;
                $totalCol37=0;
                $totalCol38=0;
                $totalCol39=0;
                $totalCol40=0;
                $totalCol41=0;
                $totalCol42=0;
                $totalCol43=0;
                $totalCol44=0;

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
                    $totalCol37=$totalCol37+$row->Col37;
                    $totalCol38=$totalCol38+$row->Col38;
                    $totalCol39=$totalCol39+$row->Col39;
                    $totalCol40=$totalCol40+$row->Col40;
                    $totalCol41=$totalCol41+$row->Col41;
                    $totalCol42=$totalCol42+$row->Col42;
                    $totalCol43=$totalCol43+$row->Col43;
                    $totalCol44=$totalCol44+$row->Col44;
                    $i++;
                }
                ?>
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
                    <td align='right'><strong><?php echo number_format($totalCol35,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol36,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol37,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol38,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol39,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol40,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol41,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol42,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol43,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol44,0,",",".") ?></strong></td>
                </tr>
                <?php
                foreach($registro as $row ){
                    $nombre_descripcion = $row->codigo_prestacion;
                    if ($nombre_descripcion == "28021200"){
                        $nombre_descripcion = "EGRESOS POR ALTA";
                    }
                    if ($nombre_descripcion == "28021210"){
                        $nombre_descripcion = "EGRESOS POR ABANDONO";
                    }
                    if ($nombre_descripcion == "28021220"){
                        $nombre_descripcion = "EGRESOS POR FALLECIMIENTO";
                    }
                    if ($nombre_descripcion == "28021626"){
                        $nombre_descripcion = "EGRESOS ACV REFERIDO A APS";
                    }
                    if ($nombre_descripcion == "28021627"){
                        $nombre_descripcion = "OTROS";
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
                    <td align='right'><?php echo number_format($row->Col35,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col36,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col37,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col38,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col39,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col40,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col41,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col42,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col43,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col44,0,",",".")?></td>
                    <?php
                    $i++;
                }
                ?>
            </tbody>
        </table>
    </div>

    <br>

    <!-- SECCION B2 -->
    <div class="col-sm tab table-responsive" id="B2">
        <table class="table table-hover table-bordered table-sm">
            <thead>
                <tr>
                  <td colspan="44" class="active"><strong>SECCIÓN B.2: EVALUACIÓN INICIAL.</strong></td>
                </tr>
                <tr>
                  <td rowspan="2" style="text-align:center; vertical-align:middle"><strong>PROFESIONAL</strong></td>
                  <td colspan="3" style="text-align:center; vertical-align:middle"><strong>TOTAL</strong></td>
                </tr>
                <tr>
                  <td align="center"><strong>Ambos Sexos</strong></td>
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
                          FROM (select c.* from 2020prestaciones c where c.codigo_prestacion in("28021230","28021240","28021250","28021260","28021270","28022450")) a
                          left join 2020rems b on (a.id_prestacion=b.prestacion_id_prestacion)
                          AND (b.Mes in ('.$mes.')) AND (b.establecimiento_id_establecimiento in ('.$estab.'))
                          group by a.codigo_prestacion, a.descripcion, a.id_prestacion
                          order by a.id_prestacion';
                $registro = DB::connection('mysql_rem')->select($query);

                $i=0;

                $totalCol01=0;
    						$totalCol02=0;
    						$totalCol03=0;

                foreach($registro as $row ){
                    $totalCol01=$totalCol01+$row->Col01;
                    $totalCol02=$totalCol02+$row->Col02;
                    $totalCol03=$totalCol03+$row->Col03;

                    $nombre_descripcion = $row->codigo_prestacion;
                    if ($nombre_descripcion == "28021230"){
                        $nombre_descripcion = "KINESIOLOGO";
                    }
                    if ($nombre_descripcion == "28021240"){
                        $nombre_descripcion = "TERAPEUTA OCUPACIONAL";
                    }
                    if ($nombre_descripcion == "28021250"){
                        $nombre_descripcion = "FONOAUDIOLOGO";
                    }
                    if ($nombre_descripcion == "28021260"){
                        $nombre_descripcion = "PSICOLOGO (A)";
                    }
                    if ($nombre_descripcion == "28021270"){
                        $nombre_descripcion = "ASISTENTE SOCIAL";
                    }
                    if ($nombre_descripcion == "28022450"){
                        $nombre_descripcion = "ORTOPROTESISTA";
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
                <tr>
                    <td align='left'><strong>TOTAL</strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol01,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol02,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol03,0,",",".") ?></strong></td>
                </tr>
            </tbody>
        </table>
    </div>

    <br>

    <div class="container">
    <!-- SECCION B3 -->
    <div class="col-sm tab table-responsive" id="B3">
        <table class="table table-hover table-bordered table-sm">
            <thead>
                <tr>
                    <td colspan="2" class="active"><strong>SECCIÓN B.3: EVALUACION INTERMEDIA.</strong></td>
                </tr>
                <tr>
                    <td align="center"><strong>PROFESIONAL</strong></td>
                    <td align="center"><strong>TOTAL</strong></td>
                </tr>
            </thead>
            <tbody>
                <?php
                $query = 'SELECT a.codigo_prestacion,a.descripcion
                              ,sum(ifnull(b.Col01,0)) Col01
                          FROM (select c.* from 2020prestaciones c where c.codigo_prestacion in("28021280","28021290","28021300","28021310","28022460")) a
                          left join 2020rems b on (a.id_prestacion=b.prestacion_id_prestacion)
                          AND (b.Mes in ('.$mes.')) AND (b.establecimiento_id_establecimiento in ('.$estab.'))
                          group by a.codigo_prestacion, a.descripcion, a.id_prestacion
                          order by a.id_prestacion';
                $registro = DB::connection('mysql_rem')->select($query);

                $i=0;

                $totalCol01=0;

                foreach($registro as $row ){
                    $totalCol01=$totalCol01+$row->Col01;

                    $nombre_descripcion = $row->codigo_prestacion;
                    if ($nombre_descripcion == "28021280"){
                        $nombre_descripcion = "KINESIOLOGO";
                    }
                    if ($nombre_descripcion == "28021290"){
                        $nombre_descripcion = "TERAPEUTA OCUPACIONAL";
                    }
                    if ($nombre_descripcion == "28021300"){
                        $nombre_descripcion = "FONOAUDIOLOGO";
                    }
                    if ($nombre_descripcion == "28021310"){
                        $nombre_descripcion = "PSICOLOGO (A)";
                    }
                    if ($nombre_descripcion == "28022460"){
                        $nombre_descripcion = "ORTOPROTESISTA";
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
            </tbody>
        </table>
    </div>

    <br>

    <!-- SECCION B4 -->
    <div class="col-sm tab table-responsive" id="B4">
        <table class="table table-hover table-bordered table-sm">
            <thead>
                <tr>
                    <td colspan="2" class="active"><strong>SECCIÓN B.4: SESIONES DE REHABILITACIÓN.</strong></td>
                </tr>
                <tr>
                    <td align="center"><strong>PROFESIONAL</strong></td>
                    <td align="center"><strong>TOTAL</strong></td>
                </tr>
            </thead>
            <tbody>
                <?php
                $query = 'SELECT a.codigo_prestacion,a.descripcion
                              ,sum(ifnull(b.Col01,0)) Col01
                          FROM (select c.* from 2020prestaciones c where c.codigo_prestacion in("28021320","28021330","28021340","28021350")) a
                          left join 2020rems b on (a.id_prestacion=b.prestacion_id_prestacion)
                          AND (b.Mes in ('.$mes.')) AND (b.establecimiento_id_establecimiento in ('.$estab.'))
                          group by a.codigo_prestacion, a.descripcion, a.id_prestacion
                          order by a.id_prestacion';
                $registro = DB::connection('mysql_rem')->select($query);

                $i=0;

                $totalCol01=0;

                foreach($registro as $row ){
                    $totalCol01=$totalCol01+$row->Col01;

                    $nombre_descripcion = $row->codigo_prestacion;
                    if ($nombre_descripcion == "28021320"){
                        $nombre_descripcion = "KINESIOLOGO";
                    }
                    if ($nombre_descripcion == "28021330"){
                        $nombre_descripcion = "TERAPEUTA OCUPACIONAL";
                    }
                    if ($nombre_descripcion == "28021340"){
                        $nombre_descripcion = "FONOAUDIOLOGO";
                    }
                    if ($nombre_descripcion == "28021350"){
                        $nombre_descripcion = "PSICOLOGO (A)";
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
            </tbody>
        </table>
    </div>

    <br>

    <!-- SECCION B5 -->
    <div class="col-sm tab table-responsive" id="B5">
        <table class="table table-hover table-bordered table-sm">
            <thead>
                <tr>
                    <td colspan="2" class="active"><strong>SECCION B.5: DERIVACIONES Y CONTINUIDAD EN LOS CUIDADOS.</strong></td>
                </tr>
                <tr>
                    <td align="center"><strong>DERIVACIÓN</strong></td>
                    <td align="center"><strong>TOTAL</strong></td>
                </tr>
            </thead>
            <tbody>
                <?php
                $query = 'SELECT a.codigo_prestacion,a.descripcion
                              ,sum(ifnull(b.Col01,0)) Col01
                          FROM (select c.* from 2020prestaciones c where c.codigo_prestacion in("28021360","28021370","28021380")) a
                          left join 2020rems b on (a.id_prestacion=b.prestacion_id_prestacion)
                          AND (b.Mes in ('.$mes.')) AND (b.establecimiento_id_establecimiento in ('.$estab.'))
                          group by a.codigo_prestacion, a.descripcion, a.id_prestacion
                          order by a.id_prestacion';
                $registro = DB::connection('mysql_rem')->select($query);

                $i=0;

                foreach($registro as $row ){
                    $nombre_descripcion = $row->codigo_prestacion;
                    if ($nombre_descripcion == "28021360"){
                        $nombre_descripcion = "A OTRO HOSPITAL (hospitalizado)";
                    }
                    if ($nombre_descripcion == "28021370"){
                        $nombre_descripcion = "A NIVEL SECUNDARIO (ambulatorio)";
                    }
                    if ($nombre_descripcion == "28021380"){
                        $nombre_descripcion = "A NIVEL PRIMARIO";
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

    <!-- SECCION B6 -->
    <div class="col-sm tab table-responsive" id="B6">
        <table class="table table-hover table-bordered table-sm">
            <thead>
                <tr>
                    <td colspan="2" class="active"><strong>SECCION B.6: PROCEDIMIENTOS Y OTRAS ACTIVIDADES.</strong></td>
                </tr>
                <tr>
                    <td align="center"><strong>TIPO</strong></td>
                    <td align="center"><strong>TOTAL</strong></td>
                </tr>
            </thead>
            <tbody>
                <?php
                $query = 'SELECT a.codigo_prestacion,a.descripcion
                              ,sum(ifnull(b.Col01,0)) Col01
                          FROM (select c.* from 2020prestaciones c where c.codigo_prestacion in("28012100","28012110","28021390","28021400","28021420","28021430","28021440","28021450",
                                                                                                "28021460","28022470","28021480","28021490","28021500","28021510","28101080","28022480",
                                                                                                "28022490","28021540","28021550","28021570","28021580","28021590","28021600","28022500",
                                                                                                "28022510","28022520","28022530","28022540","28022550","28022560","28022570","28022580",
                                                                                                "28022590","28022600","28022610","28022620","28101090","28101100")) a
                          left join 2020rems b on (a.id_prestacion=b.prestacion_id_prestacion)
                          AND (b.Mes in ('.$mes.')) AND (b.establecimiento_id_establecimiento in ('.$estab.'))
                          group by a.codigo_prestacion, a.descripcion, a.id_prestacion
                          order by a.id_prestacion';
                $registro = DB::connection('mysql_rem')->select($query);

                $i=0;

                $totalCol01=0;

                foreach($registro as $row ){
                    $totalCol01=$totalCol01+$row->Col01;

                    $nombre_descripcion = $row->codigo_prestacion;
                    if ($nombre_descripcion == "28012100"){
                        $nombre_descripcion = "EVALUACIÓN AYUDAS TÉCNICAS";
                    }
                    if ($nombre_descripcion == "28012110"){
                        $nombre_descripcion = "ENTRENAMIENTO DE AYUDAS TECNICAS";
                    }
                    if ($nombre_descripcion == "28021390"){
                        $nombre_descripcion = "FISIOTERAPIA";
                    }
                    if ($nombre_descripcion == "28021400"){
                        $nombre_descripcion = "TRATAMIENTO COMPRESIVO";
                    }
                    if ($nombre_descripcion == "28021420"){
                        $nombre_descripcion = "ENTRENAMIENTO PROTÉSICO";
                    }
                    if ($nombre_descripcion == "28021430"){
                        $nombre_descripcion = "EDUCACIÓN GRUPAL";
                    }
                    if ($nombre_descripcion == "28021440"){
                        $nombre_descripcion = "EDUCACIÓN FAMILIAR";
                    }
                    if ($nombre_descripcion == "28021450"){
                        $nombre_descripcion = "ASPIRACIÓN";
                    }
                    if ($nombre_descripcion == "28021460"){
                        $nombre_descripcion = "EJERCICIOS TERAPÉUTICOS";
                    }
                    if ($nombre_descripcion == "28022470"){
                        $nombre_descripcion = "EVALUACIÓN DEL HABLA Y LENGUAJE";
                    }
                    if ($nombre_descripcion == "28021480"){
                        $nombre_descripcion = "TRATAMIENTO (VOZ, HABLA Y/O LENGUAJE)";
                    }
                    if ($nombre_descripcion == "28021490"){
                        $nombre_descripcion = "TRATAMIENTO FUNCIONES MOTORAS ORALES";
                    }
                    if ($nombre_descripcion == "28021500"){
                        $nombre_descripcion = "ESTIMULACIÓN COGNITIVA";
                    }
                    if ($nombre_descripcion == "28021510"){
                        $nombre_descripcion = "PREVENCIÓN DE DETERIORO DE ÓRGANOS FONO ARTICULATORIOS (OFA)";
                    }
                    if ($nombre_descripcion == "28101080"){
                        $nombre_descripcion = "REHABILITACIÓN  DEGLUCIÓN";
                    }
                    if ($nombre_descripcion == "28022480"){
                        $nombre_descripcion = "EVALUACIÓN DE DISFAGIA";
                    }
                    if ($nombre_descripcion == "28022490"){
                        $nombre_descripcion = "REHABILITACIÓN DISFAGIA";
                    }
                    if ($nombre_descripcion == "28021540"){
                        $nombre_descripcion = "CONFECCIÓN ÓRTESIS Y/O ADAPTACIONES";
                    }
                    if ($nombre_descripcion == "28021550"){
                        $nombre_descripcion = "HABILITACIÓN Y REHABILITACIÓN EN ACTIVIDADES DE LA VIDA DIARIA (AVD)";
                    }
                    if ($nombre_descripcion == "28021570"){
                        $nombre_descripcion = "HABILITACIÓN Y REHABILITACIÓN EDUCACIONAL";
                    }
                    if ($nombre_descripcion == "28021580"){
                        $nombre_descripcion = "ACTIVIDADES RECREATIVAS";
                    }
                    if ($nombre_descripcion == "28021590"){
                        $nombre_descripcion = "ACTIVIDADES TERAPÉUTICAS";
                    }
                    if ($nombre_descripcion == "28021600"){
                        $nombre_descripcion = "INTEGRACIÓN SENSORIAL";
                    }
                    if ($nombre_descripcion == "28022500"){
                        $nombre_descripcion = "PSICOTERAPIA";
                    }
                    if ($nombre_descripcion == "28022510"){
                        $nombre_descripcion = "MASOTERAPIA";
                    }
                    if ($nombre_descripcion == "28022520"){
                        $nombre_descripcion = "ADAPTACIÓN DEL HOGAR";
                    }
                    if ($nombre_descripcion == "28022530"){
                        $nombre_descripcion = "ORIENTACIÓN Y MOVILIDAD";
                    }
                    if ($nombre_descripcion == "28022540"){
                        $nombre_descripcion = "ORIENTACIÓN SOCIOLABORAL";
                    }
                    if ($nombre_descripcion == "28022550"){
                        $nombre_descripcion = "ORIENTACIÓN FAMILIAR Y A LA RED DE APOYO PARA EL TRABAJO";
                    }
                    if ($nombre_descripcion == "28022560"){
                        $nombre_descripcion = "GESTIÓN DE LA RED LOCAL PARA EL TRABAJO";
                    }
                    if ($nombre_descripcion == "28022570"){
                        $nombre_descripcion = "TOMA DE MOLDE DE ÓRTESIS Y PRÓTESIS";
                    }
                    if ($nombre_descripcion == "28022580"){
                        $nombre_descripcion = "PRUEBA DE ÓRTESIS Y PRÓTESIS";
                    }
                    if ($nombre_descripcion == "28022590"){
                        $nombre_descripcion = "CONFECCIÓN DE ÓRTESIS Y PRÓTESIS";
                    }
                    if ($nombre_descripcion == "28022600"){
                        $nombre_descripcion = "REPARACIÓN DE ÓRTESIS Y PRÓTESIS";
                    }
                    if ($nombre_descripcion == "28022610"){
                        $nombre_descripcion = "REHABILITACIÓN AUDITIVA INDIVIDUAL";
                    }
                    if ($nombre_descripcion == "28022620"){
                        $nombre_descripcion = "REHABILITACIÓN AUDITIVA GRUPAL";
                    }
                    if ($nombre_descripcion == "28101090"){
                        $nombre_descripcion = "TERAPIA RESPIRATORIA Y FUNCIONAL PULMONAR";
                    }
                    if ($nombre_descripcion == "28101100"){
                        $nombre_descripcion = "EDUCACIÓN INDIVIDUAL";
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
            </tbody>
        </table>
    </div>
    </div>

    <br>

    <!-- SECCION C -->
    <div class="col-sm tab table-responsive" id="C">
        <table class="table table-hover table-bordered table-sm">
            <thead>
                <tr>
                  <td colspan="21" class="active"><strong>SECCIÓN C: AYUDAS TÉCNICAS DE SALUD, NIVEL APS Y HOSPITALARIO.</strong></td>
                </tr>
                <tr>
                  <td colspan="21" class="active"><strong>SECCIÓN C.1: NÚMERO DE PERSONAS QUE RECIBEN AYUDAS TÉCNICAS.</strong></td>
                </tr>
                <tr>
                    <td rowspan="2" style="text-align:center; vertical-align:middle"><strong>AYUDAS TÉCNICAS</strong></td>
                    <td rowspan="2" align="center"><strong>TOTAL</strong></td>
                    <td colspan="19" align="center"><strong>POR EDAD (en años)</strong></td>
                </tr>
                <tr>
                    <td align="center"><strong>&lt; 12 meses</strong></td>
                    <td align="center"><strong>12 a 23 meses</strong></td>
                    <td align="center"><strong>2 - 4</strong></td>
                    <td align="center"><strong>5 - 9</strong></td>
                    <td align="center"><strong>10 - 14</strong></td>
                    <td align="center"><strong>15 - 19</strong></td>
                    <td align="center"><strong>20 - 24</strong></td>
                    <td align="center"><strong>25 - 29</strong></td>
                    <td align="center"><strong>30 - 34</strong></td>
                    <td align="center"><strong>35 - 39</strong></td>
                    <td align="center"><strong>40 - 44</strong></td>
                    <td align="center"><strong>45- 49</strong></td>
                    <td align="center"><strong>50 - 54</strong></td>
                    <td align="center"><strong>55 - 59</strong></td>
                    <td align="center"><strong>60 - 64</strong></td>
                    <td align="center"><strong>65 - 69</strong></td>
                    <td align="center"><strong>70 - 74</strong></td>
                    <td align="center"><strong>75 - 79</strong></td>
                    <td align="center"><strong>80 y mas</strong></td>
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
                          FROM (select c.* from 2020prestaciones c where c.codigo_prestacion in("28022630")) a
                          left join 2020rems b on (a.id_prestacion=b.prestacion_id_prestacion)
                          AND (b.Mes in ('.$mes.')) AND (b.establecimiento_id_establecimiento in ('.$estab.'))
                          group by a.codigo_prestacion, a.descripcion, a.id_prestacion
                          order by a.id_prestacion';
                $registro = DB::connection('mysql_rem')->select($query);

                $i=0;

                foreach($registro as $row ){
                    $nombre_descripcion = $row->codigo_prestacion;
                    if ($nombre_descripcion == "28022630"){
                        $nombre_descripcion = "NÚMERO DE PERSONAS CON AYUDA TÉCNICA ENTREGADA";
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
                    <?php
                    $i++;
                }
                ?>
                </tr>
            </tbody>
        </table>
    </div>

    <br>

    <div class="col-sm tab table-responsive" id="C">
        <table class="table table-hover table-bordered table-sm">
            <thead>
                <tr>
                  <td colspan="21" class="active"><strong>SECCIÓN C.2: NÚMERO DE  AYUDAS TÉCNICAS ENTREGADAS POR TIPO.</strong></td>
                </tr>
                <tr>
                    <td rowspan="2" style="text-align:center; vertical-align:middle"><strong>TOTAL DE AYUDAS TÉCNICAS ENTREGADAS</strong></td>
                    <td rowspan="2" align="center"><strong>TOTAL</strong></td>
                    <td colspan="19" align="center"><strong>POR EDAD (en años)</strong></td>
                </tr>
                <tr>
                    <td align="center"><strong>&lt; 12 meses</strong></td>
                    <td align="center"><strong>12 a 23 meses</strong></td>
                    <td align="center"><strong>2 - 4</strong></td>
                    <td align="center"><strong>5 - 9</strong></td>
                    <td align="center"><strong>10 - 14</strong></td>
                    <td align="center"><strong>15 - 19</strong></td>
                    <td align="center"><strong>20 - 24</strong></td>
                    <td align="center"><strong>25 - 29</strong></td>
                    <td align="center"><strong>30 - 34</strong></td>
                    <td align="center"><strong>35 - 39</strong></td>
                    <td align="center"><strong>40 - 44</strong></td>
                    <td align="center"><strong>45- 49</strong></td>
                    <td align="center"><strong>50 - 54</strong></td>
                    <td align="center"><strong>55 - 59</strong></td>
                    <td align="center"><strong>60 - 64</strong></td>
                    <td align="center"><strong>65 - 69</strong></td>
                    <td align="center"><strong>70 - 74</strong></td>
                    <td align="center"><strong>75 - 79</strong></td>
                    <td align="center"><strong>80 y mas</strong></td>
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
                          FROM (select c.* from 2020prestaciones c where c.codigo_prestacion in("28022640","28022650","28022660","28022670","28022680","28022690","28022700","28022710",
                                                                                                "28022720","28022730","28022740","28022750","28022760","28022770","28023020","28023030",
                                                                                                "28101200","28101300","28101400","28101500","28101600","28101700")) a
                          left join 2020rems b on (a.id_prestacion=b.prestacion_id_prestacion)
                          AND (b.Mes in ('.$mes.')) AND (b.establecimiento_id_establecimiento in ('.$estab.'))
                          group by a.codigo_prestacion, a.descripcion, a.id_prestacion
                          order by a.id_prestacion';
                $registro = DB::connection('mysql_rem')->select($query);

                $i=0;

                foreach($registro as $row ){
                    $nombre_descripcion = $row->codigo_prestacion;
                    if ($nombre_descripcion == "28022640"){
                        $nombre_descripcion = "SILLAS DE RUEDAS ESTANDAR";
                    }
                    if ($nombre_descripcion == "28022650"){
                        $nombre_descripcion = "SILLA DE RUEDAS NEUROLOGICA";
                    }
                    if ($nombre_descripcion == "28022660"){
                        $nombre_descripcion = "COJIN ANTI ESCARAS";
                    }
                    if ($nombre_descripcion == "28022670"){
                        $nombre_descripcion = "COLCHÓN ANTI ESCARAS";
                    }
                    if ($nombre_descripcion == "28022680"){
                        $nombre_descripcion = "BASTONES";
                    }
                    if ($nombre_descripcion == "28022690"){
                        $nombre_descripcion = "ANDADORES";
                    }
                    if ($nombre_descripcion == "28022700"){
                        $nombre_descripcion = "CORSÉ";
                    }
                    if ($nombre_descripcion == "28022710"){
                        $nombre_descripcion = "ORTESIS BAJA TEMPERATURA (palmeta, cock up, digitales entre otras)";
                    }
                    if ($nombre_descripcion == "28022720"){
                        $nombre_descripcion = "ORTESIS ALTA TEMPERATURA (OTP, canaletas, canaleta con yugo, entre otras)";
                    }
                    if ($nombre_descripcion == "28022730"){
                        $nombre_descripcion = "SISTEMA COMPRESIVO";
                    }
                    if ($nombre_descripcion == "28022740"){
                        $nombre_descripcion = "PROTESIS EXTREMIDAD INFERIOR";
                    }
                    if ($nombre_descripcion == "28022750"){
                        $nombre_descripcion = "PROTESIS EXTREMIDAD SUPERIOR";
                    }
                    if ($nombre_descripcion == "28022760"){
                        $nombre_descripcion = "AYUDA TÉCNICA AUDITIVAS AUDIFONOS";
                    }
                    if ($nombre_descripcion == "28022770"){
                        $nombre_descripcion = "AYUDA TÉCNICA VISUALES LENTES";
                    }
                    if ($nombre_descripcion == "28023020"){
                        $nombre_descripcion = "PLANTILLA ORTOPÉDICA";
                    }
                    if ($nombre_descripcion == "28023030"){
                        $nombre_descripcion = "BOTA O BOTÍN DE DESCARGA";
                    }
                    if ($nombre_descripcion == "28101200"){
                        $nombre_descripcion = "ZAPATO ORTOPÉDICO";
                    }
                    if ($nombre_descripcion == "28101300"){
                        $nombre_descripcion = "BAÑO PORTÁTIL";
                    }
                    if ($nombre_descripcion == "28101400"){
                        $nombre_descripcion = "TECNOLOGÍAS DE LA COMUNICACIÓN AUMENTATIVA Y ALTERNATIVAS";
                    }
                    if ($nombre_descripcion == "28101500"){
                        $nombre_descripcion = "EQUIPO VENTILADOR MECÁNICO NO INVASIVO";
                    }
                    if ($nombre_descripcion == "28101600"){
                        $nombre_descripcion = "ASPIRADOR DE SECRECIONES";
                    }
                    if ($nombre_descripcion == "28101700"){
                        $nombre_descripcion = "OTRAS";
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
                    <?php
                    $i++;
                }
                ?>
            </tbody>
        </table>
    </div>

    <br>

    <!-- SECCION C -->
    <div class="col-sm tab table-responsive" id="C1">
        <table class="table table-hover table-bordered table-sm">
            <thead>
                <tr>
                  <td colspan="21" class="active"><strong>SECCIÓN C.3: AYUDAS TÉCNICAS POR CONDICIÓN DE SALUD.</strong></td>
                </tr>
                <tr>
                    <td rowspan="2" style="text-align:center; vertical-align:middle"><strong>TOTAL AYUDA TÉCNICA POR CONDICIÓN DE SALUD CONDICIÓN DE SALUD</strong></td>
                    <td rowspan="2" align="center"><strong>TOTAL</strong></td>
                    <td colspan="19" align="center"><strong>POR EDAD (en años)</strong></td>
                </tr>
                <tr>
                    <td align="center"><strong>&lt; 12 meses</strong></td>
                    <td align="center"><strong>12 a 23 meses</strong></td>
                    <td align="center"><strong>2 - 4</strong></td>
                    <td align="center"><strong>5 - 9</strong></td>
                    <td align="center"><strong>10 - 14</strong></td>
                    <td align="center"><strong>15 - 19</strong></td>
                    <td align="center"><strong>20 - 24</strong></td>
                    <td align="center"><strong>25 - 29</strong></td>
                    <td align="center"><strong>30 - 34</strong></td>
                    <td align="center"><strong>35 - 39</strong></td>
                    <td align="center"><strong>40 - 44</strong></td>
                    <td align="center"><strong>45- 49</strong></td>
                    <td align="center"><strong>50 - 54</strong></td>
                    <td align="center"><strong>55 - 59</strong></td>
                    <td align="center"><strong>60 - 64</strong></td>
                    <td align="center"><strong>65 - 69</strong></td>
                    <td align="center"><strong>70 - 74</strong></td>
                    <td align="center"><strong>75 - 79</strong></td>
                    <td align="center"><strong>80 y mas</strong></td>
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
                          FROM (select c.* from 2020prestaciones c where c.codigo_prestacion in("28022790","28022800","28022810","28022820","28022830","28022840","28022850","28022860",
                                                                                                "28022870","28022880","28022890","28022900","28022910","28101800","28022920","28022930",
                                                                                                "28022940","28022950","28022960","28101900","28022970","28022980","28022990")) a
                          left join 2020rems b on (a.id_prestacion=b.prestacion_id_prestacion)
                          AND (b.Mes in ('.$mes.')) AND (b.establecimiento_id_establecimiento in ('.$estab.'))
                          group by a.codigo_prestacion, a.descripcion, a.id_prestacion
                          order by a.id_prestacion';
                $registro = DB::connection('mysql_rem')->select($query);

                $i=0;

                foreach($registro as $row ){
                    $nombre_descripcion = $row->codigo_prestacion;
                    if ($nombre_descripcion == "28022790"){
                        $nombre_descripcion = "NEUROLÓGICO  TRAUMATISMO ENCÉFALO CRANEANO";
                    }
                    if ($nombre_descripcion == "28022800"){
                        $nombre_descripcion = "NEUROLÓGICOS DISRAFIA";
                    }
                    if ($nombre_descripcion == "28022810"){
                        $nombre_descripcion = "NEUROLÓGICO LESIÓN MEDULAR";
                    }
                    if ($nombre_descripcion == "28022820"){
                        $nombre_descripcion = "NEUROLÓGICO ACCIDENTE CEREBRO VASCULAR HEMORRAGICO";
                    }
                    if ($nombre_descripcion == "28022830"){
                        $nombre_descripcion = "NEUROLÓGICO ACCIDENTE CEREBRO VASCULAR  ISQUÉMICO";
                    }
                    if ($nombre_descripcion == "28022840"){
                        $nombre_descripcion = "NEUROLÓGICO TUMORES";
                    }
                    if ($nombre_descripcion == "28022850"){
                        $nombre_descripcion = "NEUROLÓGICO PARALISIS CEREBRAL";
                    }
                    if ($nombre_descripcion == "28022860"){
                        $nombre_descripcion = "NEUROLÓGICO PARKINSON";
                    }
                    if ($nombre_descripcion == "28022870"){
                        $nombre_descripcion = "NEUROLÓGICO ESCLEROSIS LATERAL AMIOTRÓFICA";
                    }
                    if ($nombre_descripcion == "28022880"){
                        $nombre_descripcion = "OTROS NEUROLÓGICOS";
                    }
                    if ($nombre_descripcion == "28022890"){
                        $nombre_descripcion = "ARTROSIS CADERA/RODILLA GES";
                    }
                    if ($nombre_descripcion == "28022900"){
                        $nombre_descripcion = "ARTROSIS CADERA/RODILLA NO GES";
                    }
                    if ($nombre_descripcion == "28022910"){
                        $nombre_descripcion = "OTRAS ARTROSIS  (hombro, columna)";
                    }
                    if ($nombre_descripcion == "28101800"){
                        $nombre_descripcion = "DIABETES MELLITUS";
                    }
                    if ($nombre_descripcion == "28022920"){
                        $nombre_descripcion = "AMPUTACIÓN POR DIABETES";
                    }
                    if ($nombre_descripcion == "28022930"){
                        $nombre_descripcion = "AMPUTACIÓN POR OTRAS CAUSAS";
                    }
                    if ($nombre_descripcion == "28022940"){
                        $nombre_descripcion = "ONCOLÓGICOS";
                    }
                    if ($nombre_descripcion == "28022950"){
                        $nombre_descripcion = "CUIDADOS PALIATIVOS";
                    }
                    if ($nombre_descripcion == "28022960"){
                        $nombre_descripcion = "QUEMADOS (NO GES)";
                    }
                    if ($nombre_descripcion == "28101900"){
                        $nombre_descripcion = "GRAN QUEMADO (GES)";
                    }
                    if ($nombre_descripcion == "28022970"){
                        $nombre_descripcion = "SENSORIAL AUDITIVO";
                    }
                    if ($nombre_descripcion == "28022980"){
                        $nombre_descripcion = "SENSORIAL VISUAL";
                    }
                    if ($nombre_descripcion == "28022990"){
                        $nombre_descripcion = "OTRAS CONDICIONES DE SALUD";
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
                    <?php
                    $i++;
                }
                ?>
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
