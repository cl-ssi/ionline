@extends('layouts.app')

@section('title', 'Resumen Estadistico Mensual')

@section('content')

<?php

use Illuminate\Support\Facades\DB;

?>

@include('indicators.rem.partials.nav')

<h3>REM-A01. CONTROLES DE SALUD.</h3>

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

    <!--div class="form-group">
        <select class="form-control selectpicker" id="tabselector">
            <option value="A">A: CONTROLES DE SALUD SEXUAL Y REPRODUCTIVA</option>
            <option value="B">B: CONTROLES DE SALUD SEGÚN CICLO VITAL</option>
            <option value="C">C: CONTROLES SEGÚN PROBLEMA DE SALUD</option>
            <option value="D">D: CONTROL DE SALUD INTEGRAL DE ADOLESCENTES</option>
            <option value="E">E: CONTROLES DE SALUD EN ESTABLECIMIENTO EDUCACIONAL</option>
        </select>
    </div-->



</main>
<main>

    <!-- SECCION A -->
    <div id="contenedor">
        <div class="col-sm tab table-responsive" id="A" style="width: 400px;">
        <table class="table table-hover table-bordered table-sm">
            <thead>
                <tr>
                    <td colspan="4" class="active"><strong>SECCIÓN A: EMP REALIZADO POR PROFESIONAL.</strong></td>
                </tr>
                <tr>
                    <td rowspan="2" style="text-align:center; vertical-align:middle"><strong>PROFESIONAL</strong></td>
                    <td colspan="3" align="center"><strong>TOTAL</strong></td>
                </tr>
                <tr>
                    <td align="center"><strong>AMBOS SEXOS</strong></td>
                    <td align="center"><strong>HOMBRES</strong></td>
                    <td align="center"><strong>MUJERES</strong></td>
                </tr>
            </thead>
            <tbody>
                <?php
                $query = 'SELECT a.codigo_prestacion,a.descripcion
                              ,sum(ifnull(b.Col01,0)) Col01
                              ,sum(ifnull(b.Col02,0)) Col02
                              ,sum(ifnull(b.Col03,0)) Col03
                          FROM (select c.* from 2020prestaciones c where c.codigo_prestacion in("03030101","03030102","03030103","03030104","03030350","03030110")) a
                          left join 2020rems b on (a.id_prestacion=b.prestacion_id_prestacion)
                          AND (b.Mes in ('.$mes.')) AND (b.establecimiento_id_establecimiento in ('.$estab.'))
                          group by  a.codigo_prestacion,a.descripcion, a.id_prestacion
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
                }
                ?>

                <tr>
                    <td align='center'><strong>TOTAL</strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol01,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol02,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol03,0,",",".") ?></strong></td>
                </tr>

                <?php

                foreach($registro as $row ){
                    $nombre_descripcion = $row->codigo_prestacion;
                    if ($nombre_descripcion == "03030101"){
                        $nombre_descripcion = "MÉDICO";
                    }
                    if ($nombre_descripcion == "03030102"){
                        $nombre_descripcion = "ENFERMERA /O";
                    }
                    if ($nombre_descripcion == "03030103"){
                        $nombre_descripcion = "MATRONA /ÓN";
                    }
                    if ($nombre_descripcion == "03030104"){
                        $nombre_descripcion = "NUTRICIONISTA";
                    }
                    if ($nombre_descripcion == "03030350"){
                        $nombre_descripcion = "OTRO PROFESIONAL";
                    }
                    if ($nombre_descripcion == "03030110"){
                        $nombre_descripcion = "TÉCNICO PARAMÉDICO";
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

    <br>

    <!-- SECCION B -->
    <div class="col-sm tab table-responsive" id="B">
        <table class="table table-hover table-bordered table-sm" >
            <thead>
                <tr>
                    <td colspan="32" class="active"><strong>SECCIÓN B: EMP SEGÚN RESULTADO DEL ESTADO NUTRICIONAL.</strong></td>
                </tr>
                <tr>
                    <td rowspan="2" style="text-align:center; vertical-align:middle"><strong>ESTADO NUTRICIONAL</strong></td>
                    <td colspan="3" align="center"><strong>TOTAL</strong></td>
                    <td colspan="2" align="center"><strong>15 a 19</strong></td>
                    <td colspan="2" align="center"><strong>20 a 24</strong></td>
                    <td colspan="2" align="center"><strong>25 a 29</strong></td>
                    <td colspan="2" align="center"><strong>30 a 34</strong></td>
                    <td colspan="2" align="center"><strong>35 a 39</strong></td>
                    <td colspan="2" align="center"><strong>40 a 44</strong></td>
                    <td colspan="2" align="center"><strong>45 a 49</strong></td>
                    <td colspan="2" align="center"><strong>50 a 54</strong></td>
                    <td colspan="2" align="center"><strong>55 a 59</strong></td>
                    <td colspan="2" align="center"><strong>60 a 64</strong></td>
                    <td colspan="2" align="center"><strong>65 a 69</strong></td>
                    <td colspan="2" align="center"><strong>70 a 74</strong></td>
                    <td colspan="2" align="center"><strong>75 a 79</strong></td>
                    <td colspan="2" align="center"><strong>80 y más</strong></td>
                </tr>
                <tr>
                    <td align="center"><strong>AMBOS SEXOS</strong></td>
                    <td align="center"><strong>HOMBRES</strong></td>
                    <td align="center"><strong>MUJERES</strong></td>
                    <td align="center"><strong>HOMBRES</strong></td>
                    <td align="center"><strong>MUJERES</strong></td>
                    <td align="center"><strong>HOMBRES</strong></td>
                    <td align="center"><strong>MUJERES</strong></td>
                    <td align="center"><strong>HOMBRES</strong></td>
                    <td align="center"><strong>MUJERES</strong></td>
                    <td align="center"><strong>HOMBRES</strong></td>
                    <td align="center"><strong>MUJERES</strong></td>
                    <td align="center"><strong>MUJERES</strong></td>
                    <td align="center"><strong>HOMBRES</strong></td>
                    <td align="center"><strong>HOMBRES</strong></td>
                    <td align="center"><strong>MUJERES</strong></td>
                    <td align="center"><strong>HOMBRES</strong></td>
                    <td align="center"><strong>MUJERES</strong></td>
                    <td align="center"><strong>HOMBRES</strong></td>
                    <td align="center"><strong>MUJERES</strong></td>
                    <td align="center"><strong>HOMBRES</strong></td>
                    <td align="center"><strong>MUJERES</strong></td>
                    <td align="center"><strong>HOMBRES</strong></td>
                    <td align="center"><strong>MUJERES</strong></td>
                    <td align="center"><strong>HOMBRES</strong></td>
                    <td align="center"><strong>MUJERES</strong></td>
                    <td align="center"><strong>HOMBRES</strong></td>
                    <td align="center"><strong>MUJERES</strong></td>
                    <td align="center"><strong>HOMBRES</strong></td>
                    <td align="center"><strong>MUJERES</strong></td>
                    <td align="center"><strong>HOMBRES</strong></td>
                    <td align="center"><strong>MUJERES</strong></td>
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
                          FROM  (select c.* from 2020prestaciones c where c.codigo_prestacion in("03030330","03030340","03030120","03030130")) a
                          left join 2020rems b on (a.id_prestacion=b.prestacion_id_prestacion)
                          AND (b.Mes in ('.$mes.')) AND (b.establecimiento_id_establecimiento in ('.$estab.'))
                          group by  a.codigo_prestacion,a.descripcion, a.id_prestacion
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
                }
                ?>

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
                </tr>

                <?php

                foreach($registro as $row ){
                    $nombre_descripcion = $row->codigo_prestacion;
                    if ($nombre_descripcion == "03030330"){
                        $nombre_descripcion = "NORMAL";
                    }
                    if ($nombre_descripcion == "03030340"){
                        $nombre_descripcion = "BAJO PESO";
                    }
                    if ($nombre_descripcion == "03030120"){
                        $nombre_descripcion = "SOBREPESO";
                    }
                    if ($nombre_descripcion == "03030130"){
                        $nombre_descripcion = "OBESOS";
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
    <div class="col-sm tab table-responsive" id="C">
        <table class="table table-hover table-bordered table-sm" >
            <thead>
                <tr>
                  <td colspan="32" class="active"><strong>SECCIÓN C: RESULTADOS DE EMP SEGÚN ESTADO DE SALUD.</strong></td>
              </tr>
              <tr>
                  <td rowspan="2" style="text-align:center; vertical-align:middle"><strong>ESTADO DE SALUD</strong></td>
                  <td colspan="3" align="center"><strong>TOTAL</strong></td>
                  <td colspan="2" align="center"><strong>15 a 19</strong></td>
                  <td colspan="2" align="center"><strong>20 a 24</strong></td>
                  <td colspan="2" align="center"><strong>25 a 29</strong></td>
                  <td colspan="2" align="center"><strong>30 a 34</strong></td>
                  <td colspan="2" align="center"><strong>35 a 39</strong></td>
                  <td colspan="2" align="center"><strong>40 a 44</strong></td>
                  <td colspan="2" align="center"><strong>45 a 49</strong></td>
                  <td colspan="2" align="center"><strong>50 a 54</strong></td>
                  <td colspan="2" align="center"><strong>55 a 59</strong></td>
                  <td colspan="2" align="center"><strong>60 a 64</strong></td>
                  <td colspan="2" align="center"><strong>65 a 69</strong></td>
                  <td colspan="2" align="center"><strong>70 a 74</strong></td>
                  <td colspan="2" align="center"><strong>75 a 79</strong></td>
                  <td colspan="2" align="center"><strong>80 y más</strong></td>
              </tr>
              <tr>
                  <td align="center"><strong>AMBOS SEXOS</strong></td>
                  <td align="center"><strong>HOMBRES</strong></td>
                  <td align="center"><strong>MUJERES</strong></td>
                  <td align="center"><strong>HOMBRES</strong></td>
                  <td align="center"><strong>MUJERES</strong></td>
                  <td align="center"><strong>HOMBRES</strong></td>
                  <td align="center"><strong>MUJERES</strong></td>
                  <td align="center"><strong>HOMBRES</strong></td>
                  <td align="center"><strong>MUJERES</strong></td>
                  <td align="center"><strong>HOMBRES</strong></td>
                  <td align="center"><strong>MUJERES</strong></td>
                  <td align="center"><strong>MUJERES</strong></td>
                  <td align="center"><strong>HOMBRES</strong></td>
                  <td align="center"><strong>HOMBRES</strong></td>
                  <td align="center"><strong>MUJERES</strong></td>
                  <td align="center"><strong>HOMBRES</strong></td>
                  <td align="center"><strong>MUJERES</strong></td>
                  <td align="center"><strong>HOMBRES</strong></td>
                  <td align="center"><strong>MUJERES</strong></td>
                  <td align="center"><strong>HOMBRES</strong></td>
                  <td align="center"><strong>MUJERES</strong></td>
                  <td align="center"><strong>HOMBRES</strong></td>
                  <td align="center"><strong>MUJERES</strong></td>
                  <td align="center"><strong>HOMBRES</strong></td>
                  <td align="center"><strong>MUJERES</strong></td>
                  <td align="center"><strong>HOMBRES</strong></td>
                  <td align="center"><strong>MUJERES</strong></td>
                  <td align="center"><strong>HOMBRES</strong></td>
                  <td align="center"><strong>MUJERES</strong></td>
                  <td align="center"><strong>HOMBRES</strong></td>
                  <td align="center"><strong>MUJERES</strong></td>
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
                          FROM  (select c.* from 2020prestaciones c where c.codigo_prestacion in("02200010","02200020")) a
                          left join 2020rems b on (a.id_prestacion=b.prestacion_id_prestacion)
                          AND (b.Mes in ('.$mes.')) AND (b.establecimiento_id_establecimiento in ('.$estab.'))
                          group by  a.codigo_prestacion,a.descripcion, a.id_prestacion
                          order by a.id_prestacion';

                $registro = DB::connection('mysql_rem')->select($query);

                $i=0;

                foreach($registro as $row ){
                    $nombre_descripcion = $row->codigo_prestacion;
                    if ($nombre_descripcion == "02200010"){
                        $nombre_descripcion = "TABAQUISMO";
                    }
                    if ($nombre_descripcion == "02200020"){
                        $nombre_descripcion = "PRESIÓN ARTERIAL ELEVADA (= >140/90 mmHg)";
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
          <table class="table table-hover table-bordered table-sm" >
              <thead>
                  <tr>
                    <td colspan="32" class="active"><strong>SECCIÓN D: RESULTADOS DE EMP SEGÚN ESTADO DE SALUD (EXÁMENES DE LABORATORIO).</strong></td>
                </tr>
                <tr>
                    <td rowspan="2" style="text-align:center; vertical-align:middle"><strong>ESTADO DE SALUD</strong></td>
                    <td colspan="3" align="center"><strong>TOTAL</strong></td>
                    <td colspan="2" align="center"><strong>15 a 19</strong></td>
                    <td colspan="2" align="center"><strong>20 a 24</strong></td>
                    <td colspan="2" align="center"><strong>25 a 29</strong></td>
                    <td colspan="2" align="center"><strong>30 a 34</strong></td>
                    <td colspan="2" align="center"><strong>35 a 39</strong></td>
                    <td colspan="2" align="center"><strong>40 a 44</strong></td>
                    <td colspan="2" align="center"><strong>45 a 49</strong></td>
                    <td colspan="2" align="center"><strong>50 a 54</strong></td>
                    <td colspan="2" align="center"><strong>55 a 59</strong></td>
                    <td colspan="2" align="center"><strong>60 a 64</strong></td>
                    <td colspan="2" align="center"><strong>65 a 69</strong></td>
                    <td colspan="2" align="center"><strong>70 a 74</strong></td>
                    <td colspan="2" align="center"><strong>75 a 79</strong></td>
                    <td colspan="2" align="center"><strong>80 y más</strong></td>
                </tr>
                <tr>
                    <td align="center"><strong>AMBOS SEXOS</strong></td>
                    <td align="center"><strong>HOMBRES</strong></td>
                    <td align="center"><strong>MUJERES</strong></td>
                    <td align="center"><strong>HOMBRES</strong></td>
                    <td align="center"><strong>MUJERES</strong></td>
                    <td align="center"><strong>HOMBRES</strong></td>
                    <td align="center"><strong>MUJERES</strong></td>
                    <td align="center"><strong>HOMBRES</strong></td>
                    <td align="center"><strong>MUJERES</strong></td>
                    <td align="center"><strong>HOMBRES</strong></td>
                    <td align="center"><strong>MUJERES</strong></td>
                    <td align="center"><strong>MUJERES</strong></td>
                    <td align="center"><strong>HOMBRES</strong></td>
                    <td align="center"><strong>HOMBRES</strong></td>
                    <td align="center"><strong>MUJERES</strong></td>
                    <td align="center"><strong>HOMBRES</strong></td>
                    <td align="center"><strong>MUJERES</strong></td>
                    <td align="center"><strong>HOMBRES</strong></td>
                    <td align="center"><strong>MUJERES</strong></td>
                    <td align="center"><strong>HOMBRES</strong></td>
                    <td align="center"><strong>MUJERES</strong></td>
                    <td align="center"><strong>HOMBRES</strong></td>
                    <td align="center"><strong>MUJERES</strong></td>
                    <td align="center"><strong>HOMBRES</strong></td>
                    <td align="center"><strong>MUJERES</strong></td>
                    <td align="center"><strong>HOMBRES</strong></td>
                    <td align="center"><strong>MUJERES</strong></td>
                    <td align="center"><strong>HOMBRES</strong></td>
                    <td align="center"><strong>MUJERES</strong></td>
                    <td align="center"><strong>HOMBRES</strong></td>
                    <td align="center"><strong>MUJERES</strong></td>
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
                            FROM  (select c.* from 2020prestaciones c where c.codigo_prestacion in("02200030","02200040")) a
                            left join 2020rems b on (a.id_prestacion=b.prestacion_id_prestacion)
                            AND (b.Mes in ('.$mes.')) AND (b.establecimiento_id_establecimiento in ('.$estab.'))
                            group by  a.codigo_prestacion,a.descripcion, a.id_prestacion
                            order by a.id_prestacion';

                  $registro = DB::connection('mysql_rem')->select($query);

                  $i=0;

                  foreach($registro as $row ){
                      $nombre_descripcion = $row->codigo_prestacion;
                      if ($nombre_descripcion == "02200030"){
                          $nombre_descripcion = "GLICEMIA ALTERADA (= > a 100 mg/dl)";
                      }
                      if ($nombre_descripcion == "02200040"){
                          $nombre_descripcion = "COLESTEROL ELEVADO (= > 200 mg/dl)";
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
