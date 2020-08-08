@extends('layouts.app')

@section('title', 'Resumen Estadistico Mensual')

@section('content')

<?php

use Illuminate\Support\Facades\DB;

?>

@include('indicators.rem.partials.nav')

<h3>REM-A02. EXAMEN DE MEDICINA PREVENTIVA EN MAYORES DE 15 AÑOS.</h3>

<br>

@include('indicators.rem.2019.serie_a.search')

<?php
//(isset($establecimientos) AND isset($periodo)));

if (in_array(0, $establecimientos) AND in_array(0, $periodo)){
    ?>
    @include('indicators.rem.partials.legend')
    <?php
}
else{
    $estab = implode (", ", $establecimientos);
    $mes = implode (", ", $periodo);


    /* Sección A */
    $query =
    'SELECT
        SUBSTRING_INDEX(descripcion, "- ", -1) AS nombre_descripcion,
        SUM(IFNULL(rems.col01, 0)) Col01,
        SUM(IFNULL(rems.col02, 0)) Col02,
        SUM(IFNULL(rems.col03, 0)) Col03
    FROM (
        SELECT c.*
            FROM 2019prestaciones c
            WHERE c.codigo_prestacion IN( "03030101", "03030102", "03030103",
                                           "03030104", "03030350", "03030110" )
        ) prestaciones
    LEFT JOIN 2019rems rems
        ON ( prestaciones.id_prestacion = rems.prestacion_id_prestacion )
            AND rems.mes IN ( '.$mes.' )
            AND rems.establecimiento_id_establecimiento IN ( '.$estab.' )
    GROUP BY prestaciones.descripcion,
             prestaciones.id_prestacion
    ORDER BY prestaciones.id_prestacion';

    $registros_a = DB::connection('mysql_rem')->select($query);



    /* Sección B */
    $query =
    'SELECT
        SUBSTRING_INDEX(descripcion, "- ", -1) AS nombre_descripcion,
        SUM(IFNULL(rems.Col01,0)) Col01,
        SUM(IFNULL(rems.Col02,0)) Col02,
        SUM(IFNULL(rems.Col03,0)) Col03,
        SUM(IFNULL(rems.Col04,0)) Col04,
        SUM(IFNULL(rems.Col05,0)) Col05,
        SUM(IFNULL(rems.Col06,0)) Col06,
        SUM(IFNULL(rems.Col07,0)) Col07,
        SUM(IFNULL(rems.Col08,0)) Col08,
        SUM(IFNULL(rems.Col09,0)) Col09,
        SUM(IFNULL(rems.Col10,0)) Col10,
        SUM(IFNULL(rems.Col11,0)) Col11,
        SUM(IFNULL(rems.Col12,0)) Col12,
        SUM(IFNULL(rems.Col13,0)) Col13,
        SUM(IFNULL(rems.Col14,0)) Col14,
        SUM(IFNULL(rems.Col15,0)) Col15,
        SUM(IFNULL(rems.Col16,0)) Col16,
        SUM(IFNULL(rems.Col17,0)) Col17,
        SUM(IFNULL(rems.Col18,0)) Col18,
        SUM(IFNULL(rems.Col19,0)) Col19,
        SUM(IFNULL(rems.Col20,0)) Col20,
        SUM(IFNULL(rems.Col21,0)) Col21,
        SUM(IFNULL(rems.Col22,0)) Col22,
        SUM(IFNULL(rems.Col23,0)) Col23,
        SUM(IFNULL(rems.Col24,0)) Col24,
        SUM(IFNULL(rems.Col25,0)) Col25,
        SUM(IFNULL(rems.Col26,0)) Col26,
        SUM(IFNULL(rems.Col27,0)) Col27,
        SUM(IFNULL(rems.Col28,0)) Col28,
        SUM(IFNULL(rems.Col29,0)) Col29,
        SUM(IFNULL(rems.Col30,0)) Col30,
        SUM(IFNULL(rems.Col31,0)) Col31
    FROM (
        SELECT c.*
            FROM 2019prestaciones c
            WHERE c.codigo_prestacion IN("03030330","03030340","03030120","03030130")
        ) prestaciones
    LEFT JOIN 2019rems rems
        ON (prestaciones.id_prestacion = rems.prestacion_id_prestacion)
            AND rems.Mes IN ('.$mes.')
            AND rems.establecimiento_id_establecimiento IN ('.$estab.')
    GROUP BY prestaciones.descripcion,
             prestaciones.id_prestacion
    ORDER BY prestaciones.id_prestacion';

    $registros_b = DB::connection('mysql_rem')->select($query);



    /* Sección C */
    $query =
    'SELECT
        SUBSTRING_INDEX(descripcion, "- ", -1) AS nombre_descripcion,
        SUM(IFNULL(rems.Col01,0)) Col01,
        SUM(IFNULL(rems.Col02,0)) Col02,
        SUM(IFNULL(rems.Col03,0)) Col03,
        SUM(IFNULL(rems.Col04,0)) Col04,
        SUM(IFNULL(rems.Col05,0)) Col05,
        SUM(IFNULL(rems.Col06,0)) Col06,
        SUM(IFNULL(rems.Col07,0)) Col07,
        SUM(IFNULL(rems.Col08,0)) Col08,
        SUM(IFNULL(rems.Col09,0)) Col09,
        SUM(IFNULL(rems.Col10,0)) Col10,
        SUM(IFNULL(rems.Col11,0)) Col11,
        SUM(IFNULL(rems.Col12,0)) Col12,
        SUM(IFNULL(rems.Col13,0)) Col13,
        SUM(IFNULL(rems.Col14,0)) Col14,
        SUM(IFNULL(rems.Col15,0)) Col15,
        SUM(IFNULL(rems.Col16,0)) Col16,
        SUM(IFNULL(rems.Col17,0)) Col17,
        SUM(IFNULL(rems.Col18,0)) Col18,
        SUM(IFNULL(rems.Col19,0)) Col19,
        SUM(IFNULL(rems.Col20,0)) Col20,
        SUM(IFNULL(rems.Col21,0)) Col21,
        SUM(IFNULL(rems.Col22,0)) Col22,
        SUM(IFNULL(rems.Col23,0)) Col23,
        SUM(IFNULL(rems.Col24,0)) Col24,
        SUM(IFNULL(rems.Col25,0)) Col25,
        SUM(IFNULL(rems.Col26,0)) Col26,
        SUM(IFNULL(rems.Col27,0)) Col27,
        SUM(IFNULL(rems.Col28,0)) Col28,
        SUM(IFNULL(rems.Col29,0)) Col29,
        SUM(IFNULL(rems.Col30,0)) Col30,
        SUM(IFNULL(rems.Col31,0)) Col31
    FROM (
        SELECT c.*
        FROM 2019prestaciones c
        WHERE c.codigo_prestacion IN("02200010","02200020")
        ) prestaciones
    LEFT JOIN 2019rems rems
        ON prestaciones.id_prestacion=rems.prestacion_id_prestacion
            AND rems.Mes IN ('.$mes.')
            AND rems.establecimiento_id_establecimiento IN ('.$estab.')
    GROUP BY prestaciones.descripcion,
             prestaciones.id_prestacion
    ORDER BY prestaciones.id_prestacion';

    $registros_c = DB::connection('mysql_rem')->select($query);



    /* Sección D */
    $query =
    'SELECT SUBSTRING_INDEX(descripcion, "- ", -1) AS nombre_descripcion,
           SUM(IFNULL(rems.col01, 0)) Col01,
           SUM(IFNULL(rems.col02, 0)) Col02,
           SUM(IFNULL(rems.col03, 0)) Col03,
           SUM(IFNULL(rems.col04, 0)) Col04,
           SUM(IFNULL(rems.col05, 0)) Col05,
           SUM(IFNULL(rems.col06, 0)) Col06,
           SUM(IFNULL(rems.col07, 0)) Col07,
           SUM(IFNULL(rems.col08, 0)) Col08,
           SUM(IFNULL(rems.col09, 0)) Col09,
           SUM(IFNULL(rems.col10, 0)) Col10,
           SUM(IFNULL(rems.col11, 0)) Col11,
           SUM(IFNULL(rems.col12, 0)) Col12,
           SUM(IFNULL(rems.col13, 0)) Col13,
           SUM(IFNULL(rems.col14, 0)) Col14,
           SUM(IFNULL(rems.col15, 0)) Col15,
           SUM(IFNULL(rems.col16, 0)) Col16,
           SUM(IFNULL(rems.col17, 0)) Col17,
           SUM(IFNULL(rems.col18, 0)) Col18,
           SUM(IFNULL(rems.col19, 0)) Col19,
           SUM(IFNULL(rems.col20, 0)) Col20,
           SUM(IFNULL(rems.col21, 0)) Col21,
           SUM(IFNULL(rems.col22, 0)) Col22,
           SUM(IFNULL(rems.col23, 0)) Col23,
           SUM(IFNULL(rems.col24, 0)) Col24,
           SUM(IFNULL(rems.col25, 0)) Col25,
           SUM(IFNULL(rems.col26, 0)) Col26,
           SUM(IFNULL(rems.col27, 0)) Col27,
           SUM(IFNULL(rems.col28, 0)) Col28,
           SUM(IFNULL(rems.col29, 0)) Col29,
           SUM(IFNULL(rems.col30, 0)) Col30,
           SUM(IFNULL(rems.col31, 0)) Col31
    FROM (
        SELECT c.*
            FROM   2019prestaciones c
            WHERE  c.codigo_prestacion IN( "02200030", "02200040" )
        ) prestaciones
    LEFT JOIN 2019rems rems
        ON ( prestaciones.id_prestacion = rems.prestacion_id_prestacion )
            AND rems.mes IN ( '.$mes.' )
            AND rems.establecimiento_id_establecimiento IN ( '.$estab.' )
    GROUP  BY prestaciones.descripcion,
              prestaciones.id_prestacion';

    $registros_d = DB::connection('mysql_rem')->select($query);
    ?>


    <link href="{{ asset('css/rem.css') }}" rel="stylesheet">

    <!--div class="form-group">
        <select class="form-control selectpicker" id="tabselector">
            <option value="A">A: EMP REALIZADO POR PROFESIONAL.</option>
            <option value="B">B: EMP SEGÚN RESULTADO DEL ESTADO NUTRICIONAL.</option>
            <option value="C">C: RESULTADOS DE EMP SEGÚN ESTADO DE SALUD.</option>
            <option value="D">D: RESULTADOS DE EMP SEGÚN ESTADO DE SALUD (EXÁMENES DE LABORATORIO).</option>
        </select>
    </div-->

    </main>

    <div id="contenedor">


    <!-- SECCION A -->
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
                <tr>
                    <td align='center'><strong>TOTAL</strong></td>
                    <td align='right'><strong>@numero(array_sum(array_column($registros_a,'Col01')))</strong></td>
                    <td align='right'><strong>@numero(array_sum(array_column($registros_a,'Col02')))</strong></td>
                    <td align='right'><strong>@numero(array_sum(array_column($registros_a,'Col03')))</strong></td>
                </tr>
                @foreach($registros_a as $row)
                <tr>
                    <td align='left' nowrap="nowrap">{{ $row->nombre_descripcion }}</td>
                    <td align='right'>@numero($row->Col01)</td>
                    <td align='right'>@numero($row->Col02)</td>
                    <td align='right'>@numero($row->Col03)</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <br>

    <!-- SECCION B -->
    <div class="col-sm tab table-responsive" id="B">
        <table class="table table-hover table-bordered table-sm">
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
                <tr>
                    <td align='center' nowrap="nowrap"><strong>TOTAL</strong></td>
                    <td align='right'><strong>@numero(array_sum(array_column($registros_b,'Col01')))</strong></td>
                    <td align='right'><strong>@numero(array_sum(array_column($registros_b,'Col02')))</strong></td>
                    <td align='right'><strong>@numero(array_sum(array_column($registros_b,'Col03')))</strong></td>
                    <td align='right'><strong>@numero(array_sum(array_column($registros_b,'Col04')))</strong></td>
                    <td align='right'><strong>@numero(array_sum(array_column($registros_b,'Col05')))</strong></td>
                    <td align='right'><strong>@numero(array_sum(array_column($registros_b,'Col06')))</strong></td>
                    <td align='right'><strong>@numero(array_sum(array_column($registros_b,'Col07')))</strong></td>
                    <td align='right'><strong>@numero(array_sum(array_column($registros_b,'Col08')))</strong></td>
                    <td align='right'><strong>@numero(array_sum(array_column($registros_b,'Col09')))</strong></td>
                    <td align='right'><strong>@numero(array_sum(array_column($registros_b,'Col10')))</strong></td>
                    <td align='right'><strong>@numero(array_sum(array_column($registros_b,'Col11')))</strong></td>
                    <td align='right'><strong>@numero(array_sum(array_column($registros_b,'Col12')))</strong></td>
                    <td align='right'><strong>@numero(array_sum(array_column($registros_b,'Col13')))</strong></td>
                    <td align='right'><strong>@numero(array_sum(array_column($registros_b,'Col14')))</strong></td>
                    <td align='right'><strong>@numero(array_sum(array_column($registros_b,'Col15')))</strong></td>
                    <td align='right'><strong>@numero(array_sum(array_column($registros_b,'Col16')))</strong></td>
                    <td align='right'><strong>@numero(array_sum(array_column($registros_b,'Col17')))</strong></td>
                    <td align='right'><strong>@numero(array_sum(array_column($registros_b,'Col18')))</strong></td>
                    <td align='right'><strong>@numero(array_sum(array_column($registros_b,'Col19')))</strong></td>
                    <td align='right'><strong>@numero(array_sum(array_column($registros_b,'Col20')))</strong></td>
                    <td align='right'><strong>@numero(array_sum(array_column($registros_b,'Col21')))</strong></td>
                    <td align='right'><strong>@numero(array_sum(array_column($registros_b,'Col22')))</strong></td>
                    <td align='right'><strong>@numero(array_sum(array_column($registros_b,'Col23')))</strong></td>
                    <td align='right'><strong>@numero(array_sum(array_column($registros_b,'Col24')))</strong></td>
                    <td align='right'><strong>@numero(array_sum(array_column($registros_b,'Col25')))</strong></td>
                    <td align='right'><strong>@numero(array_sum(array_column($registros_b,'Col26')))</strong></td>
                    <td align='right'><strong>@numero(array_sum(array_column($registros_b,'Col27')))</strong></td>
                    <td align='right'><strong>@numero(array_sum(array_column($registros_b,'Col28')))</strong></td>
                    <td align='right'><strong>@numero(array_sum(array_column($registros_b,'Col29')))</strong></td>
                    <td align='right'><strong>@numero(array_sum(array_column($registros_b,'Col30')))</strong></td>
                    <td align='right'><strong>@numero(array_sum(array_column($registros_b,'Col31')))</strong></td>
                </tr>
                @foreach($registros_b as $row)
                <tr>
                    <td align='left' nowrap="nowrap">{{ $row->nombre_descripcion }}</td>
                    <td align='right'>@numero($row->Col01)</td>
                    <td align='right'>@numero($row->Col02)</td>
                    <td align='right'>@numero($row->Col03)</td>
                    <td align='right'>@numero($row->Col04)</td>
                    <td align='right'>@numero($row->Col05)</td>
                    <td align='right'>@numero($row->Col06)</td>
                    <td align='right'>@numero($row->Col07)</td>
                    <td align='right'>@numero($row->Col08)</td>
                    <td align='right'>@numero($row->Col09)</td>
                    <td align='right'>@numero($row->Col10)</td>
                    <td align='right'>@numero($row->Col11)</td>
                    <td align='right'>@numero($row->Col12)</td>
                    <td align='right'>@numero($row->Col13)</td>
                    <td align='right'>@numero($row->Col14)</td>
                    <td align='right'>@numero($row->Col15)</td>
                    <td align='right'>@numero($row->Col16)</td>
                    <td align='right'>@numero($row->Col17)</td>
                    <td align='right'>@numero($row->Col18)</td>
                    <td align='right'>@numero($row->Col19)</td>
                    <td align='right'>@numero($row->Col20)</td>
                    <td align='right'>@numero($row->Col21)</td>
                    <td align='right'>@numero($row->Col22)</td>
                    <td align='right'>@numero($row->Col23)</td>
                    <td align='right'>@numero($row->Col24)</td>
                    <td align='right'>@numero($row->Col25)</td>
                    <td align='right'>@numero($row->Col26)</td>
                    <td align='right'>@numero($row->Col27)</td>
                    <td align='right'>@numero($row->Col28)</td>
                    <td align='right'>@numero($row->Col29)</td>
                    <td align='right'>@numero($row->Col30)</td>
                    <td align='right'>@numero($row->Col31)</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <br>

    <!-- SECCION C -->
    <div class="col-sm tab table-responsive" id="C">
        <table class="table table-hover table-bordered table-sm">
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
                @foreach($registros_c as $row)
                <tr>
                    <td align='left'>{{ $row->nombre_descripcion }}</td>
                    <td align='right'>@numero($row->Col01)</td>
                    <td align='right'>@numero($row->Col02)</td>
                    <td align='right'>@numero($row->Col03)</td>
                    <td align='right'>@numero($row->Col04)</td>
                    <td align='right'>@numero($row->Col05)</td>
                    <td align='right'>@numero($row->Col06)</td>
                    <td align='right'>@numero($row->Col07)</td>
                    <td align='right'>@numero($row->Col08)</td>
                    <td align='right'>@numero($row->Col09)</td>
                    <td align='right'>@numero($row->Col10)</td>
                    <td align='right'>@numero($row->Col11)</td>
                    <td align='right'>@numero($row->Col12)</td>
                    <td align='right'>@numero($row->Col13)</td>
                    <td align='right'>@numero($row->Col14)</td>
                    <td align='right'>@numero($row->Col15)</td>
                    <td align='right'>@numero($row->Col16)</td>
                    <td align='right'>@numero($row->Col17)</td>
                    <td align='right'>@numero($row->Col18)</td>
                    <td align='right'>@numero($row->Col19)</td>
                    <td align='right'>@numero($row->Col20)</td>
                    <td align='right'>@numero($row->Col21)</td>
                    <td align='right'>@numero($row->Col22)</td>
                    <td align='right'>@numero($row->Col23)</td>
                    <td align='right'>@numero($row->Col24)</td>
                    <td align='right'>@numero($row->Col25)</td>
                    <td align='right'>@numero($row->Col26)</td>
                    <td align='right'>@numero($row->Col27)</td>
                    <td align='right'>@numero($row->Col28)</td>
                    <td align='right'>@numero($row->Col29)</td>
                    <td align='right'>@numero($row->Col30)</td>
                    <td align='right'>@numero($row->Col31)</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <br>

    <!-- SECCION D -->
    <div class="col-sm tab table-responsive" id="D">
        <table class="table table-hover table-bordered table-sm">
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
                @foreach($registros_d as $row)
                <tr>
                    <td align='left'>{{ $row->nombre_descripcion }}</td>
                    <td align='right'>@numero($row->Col01)</td>
                    <td align='right'>@numero($row->Col02)</td>
                    <td align='right'>@numero($row->Col03)</td>
                    <td align='right'>@numero($row->Col04)</td>
                    <td align='right'>@numero($row->Col05)</td>
                    <td align='right'>@numero($row->Col06)</td>
                    <td align='right'>@numero($row->Col07)</td>
                    <td align='right'>@numero($row->Col08)</td>
                    <td align='right'>@numero($row->Col09)</td>
                    <td align='right'>@numero($row->Col10)</td>
                    <td align='right'>@numero($row->Col11)</td>
                    <td align='right'>@numero($row->Col12)</td>
                    <td align='right'>@numero($row->Col13)</td>
                    <td align='right'>@numero($row->Col14)</td>
                    <td align='right'>@numero($row->Col15)</td>
                    <td align='right'>@numero($row->Col16)</td>
                    <td align='right'>@numero($row->Col17)</td>
                    <td align='right'>@numero($row->Col18)</td>
                    <td align='right'>@numero($row->Col19)</td>
                    <td align='right'>@numero($row->Col20)</td>
                    <td align='right'>@numero($row->Col21)</td>
                    <td align='right'>@numero($row->Col22)</td>
                    <td align='right'>@numero($row->Col23)</td>
                    <td align='right'>@numero($row->Col24)</td>
                    <td align='right'>@numero($row->Col25)</td>
                    <td align='right'>@numero($row->Col26)</td>
                    <td align='right'>@numero($row->Col27)</td>
                    <td align='right'>@numero($row->Col28)</td>
                    <td align='right'>@numero($row->Col29)</td>
                    <td align='right'>@numero($row->Col30)</td>
                    <td align='right'>@numero($row->Col31)</td>
                </tr>
                @endforeach
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
