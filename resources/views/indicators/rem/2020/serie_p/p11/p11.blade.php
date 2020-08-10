@extends('layouts.app')

@section('title', 'Resumen Estadistico Mensual')

@section('content')

<?php

use Illuminate\Support\Facades\DB;

?>

@include('indicators.rem.partials.navP')

<h3>REM-P11. POBLACIÓN EN CONTROL PROGRAMA DE INFECCIONES DE TRASMISIÓN SEXUAL - VIH / SIDA.</h3>

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
                    <td colspan="49" class="active"><strong>SECCION A: POBLACIÓN EN CONTROL DEL PROGRAMA DE VIH/SIDA (Uso exclusivo Centros de Atención VIH-SIDA).</strong></td>
                </tr>
                <tr>
                    <td colspan='3' rowspan='3' style="text-align:center; vertical-align:middle"><strong>CONCEPTO</strong></td>
                    <td colspan='3' rowspan='2' style="text-align:center; vertical-align:middle"><strong>TOTAL</strong></td>
                    <td colspan='38' align='center'><strong>GRUPOS DE EDAD (en años)</strong></td>
                    <td colspan='2' rowspan="2" style="text-align:center; vertical-align:middle"><strong>TRANS</strong></td>
                    <td rowspan='3' style="text-align:center; vertical-align:middle"><strong>Pueblos Originarios</strong></td>
                    <td rowspan='3' style="text-align:center; vertical-align:middle"><strong>Población Migrantes</strong></td>
                    <td rowspan='3' style="text-align:center; vertical-align:middle"><strong>Niños, Niñas, Adolescentes y Jóvenes Población SENAME</strong></td>
                </tr>
                <tr>
                    <td colspan='2' align='center'><strong>Menor 1 Año</strong></td>
                    <td colspan='2' align='center'><strong>1 año</strong></td>
                    <td colspan='2' align='center'><strong>2 a 4 años</strong></td>
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
                    <td colspan='2' align='center'><strong>80 y más años</strong></td>
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
                    <td align='center'><strong>Hombres</strong></td>
                    <td align='center'><strong>Mujeres</strong></td>
                    <td align='center'><strong>Masculino</strong></td>
                    <td align='center'><strong>Femenino</strong></td>
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
                          FROM (select c.* from 2020prestaciones c where c.codigo_prestacion in("P11000150","P11000160","P11000170","P11000180") AND c.serie = "P") a
                          left join 2020rems b on (a.id_prestacion=b.prestacion_id_prestacion)
                          AND (b.Mes in ('.$mes.')) AND (b.establecimiento_id_establecimiento in ('.$estab.'))
                          group by  a.codigo_prestacion,a.descripcion,a.id_prestacion
                          order by a.id_prestacion';
                $registro = DB::connection('mysql_rem')->select($query);

                $i=0;

                foreach($registro as $row ){
                    $nombre_descripcion = $row->codigo_prestacion;
                    if ($nombre_descripcion == "P11000150"){
                        $nombre_descripcion = "Inicia TARV en este embarazo";
                    }
                    if ($nombre_descripcion == "P11000160"){
                        $nombre_descripcion = "en TARV previa";
                    }
                    if ($nombre_descripcion == "P11000170"){
                        $nombre_descripcion = "Con TARV";
                    }
                    if ($nombre_descripcion == "P11000180"){
                        $nombre_descripcion = "Sin TARV";
                    }
                    ?>
                <tr>
                    <?php
                    if($i==0){?>
                    <td rowspan="4" style="text-align:center; vertical-align:middle">Nº TOTAL DE PERSONAS CON VIH/SIDA</td>
                    <td rowspan="2" style="text-align:center; vertical-align:middle">GESTANTES</td>
                    <?php
                    }
                    if($i==2){?>
                    <td rowspan="2" style="text-align:center; vertical-align:middle">NO GESTANTES</td>
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
            </tbody>
        </table>
    </div>

    <br>

    <!-- SECCION B -->
    <div class="col-sm tab table-responsive" id="B">
        <table class="table table-hover table-bordered table-sm">
            <thead>
                <tr>
                    <td colspan="36" class="active"><strong>SECCION B: Población EN CONTROL POR COMERCIO SEXUAL (Uso exclusivo de Unidades Control Comercio Sexual).</strong></td>
                </tr>
                <tr>
                    <td rowspan='3' style="text-align:center; vertical-align:middle"><strong>CONCEPTO</strong></td>
                    <td colspan='3' rowspan='2' style="text-align:center; vertical-align:middle"><strong>TOTAL</strong></td>
                    <td colspan='28' align='center'><strong>GRUPOS DE EDAD (en años)</strong></td>
                    <td colspan='2' rowspan="2" style="text-align:center; vertical-align:middle"><strong>TRANS</strong></td>
                    <td rowspan='3' style="text-align:center; vertical-align:middle"><strong>Pueblos Originarios</strong></td>
                    <td rowspan='3' style="text-align:center; vertical-align:middle"><strong>Población Migrantes</strong></td>
                </tr>
                <tr>
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
                    <td colspan='2' align='center'><strong>80 y más años</strong></td>
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
                    <td align='center'><strong>Masculino</strong></td>
                    <td align='center'><strong>Femenino</strong></td>
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
                          FROM (select c.* from 2020prestaciones c where c.codigo_prestacion in("P11000140") AND c.serie = "P") a
                          left join 2020rems b on (a.id_prestacion=b.prestacion_id_prestacion)
                          AND (b.Mes in ('.$mes.')) AND (b.establecimiento_id_establecimiento in ('.$estab.'))
                          group by  a.codigo_prestacion,a.descripcion,a.id_prestacion
                          order by a.id_prestacion';
                $registro = DB::connection('mysql_rem')->select($query);

                $i=0;

                foreach($registro as $row ){
                    $nombre_descripcion = $row->codigo_prestacion;
                    if ($nombre_descripcion == "P11000140"){
                        $nombre_descripcion = "Nº DE PERSONAS / COMERCIO SEXUAL";
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
