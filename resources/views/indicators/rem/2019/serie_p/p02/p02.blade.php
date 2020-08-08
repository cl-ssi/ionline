@extends('layouts.app')

@section('title', 'Resumen Estadistico Mensual')

@section('content')

<?php

use Illuminate\Support\Facades\DB;

?>

@include('indicators.rem.partials.navP')

<h3>REM-P2. POBLACIÓN EN CONTROL PROGRAMA DE SALUD DEL NIÑO.</h3>

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
                    <td colspan="37" class="active"><strong>SECCION A: POBLACIÓN EN CONTROL, SEGÚN ESTADO NUTRICIONAL PARA NIÑOS MENOR DE UN MES-59 MESES.</strong></td>
                </tr>
                <tr>
                    <td colspan='2' rowspan='3' style="text-align:center; vertical-align:middle"><strong>INDICADOR NUTRICIONAL Y PARÁMETROS DE MEDICIÓN</strong></td>
                    <td colspan='3' rowspan='2' style="text-align:center; vertical-align:middle"><strong>TOTAL</strong></td>
                    <td colspan='28' align='center'><strong>GRUPOS DE EDAD (en meses - años) Y SEXO</strong></td>
                    <td colspan='2' rowspan='2' style="text-align:center; vertical-align:middle"><strong>Pueblos Originarios</strong></td>
                    <td colspan='2' rowspan='2' style="text-align:center; vertical-align:middle"><strong>Población Inmigrantes</strong></td>
                </tr>
                <tr>
                    <td colspan='2' align='center'><strong>Menor de 1 mes</strong></td>
                    <td colspan='2' align='center'><strong>1 mes</strong></td>
                    <td colspan='2' align='center'><strong>2 meses</strong></td>
                    <td colspan='2' align='center'><strong>3 meses</strong></td>
                    <td colspan='2' align='center'><strong>4 meses</strong></td>
                    <td colspan='2' align='center'><strong>5 meses</strong></td>
                    <td colspan='2' align='center'><strong>6 meses</strong></td>
                    <td colspan='2' align='center'><strong>7 a 11 meses</strong></td>
                    <td colspan='2' align='center'><strong>12 a 17 meses</strong></td>
                    <td colspan='2' align='center'><strong>18 a 23 meses</strong></td>
                    <td colspan='2' align='center'><strong>24 a 35 meses</strong></td>
                    <td colspan='2' align='center'><strong>36 a 41 meses</strong></td>
                    <td colspan='2' align='center'><strong>42 a 47 meses</strong></td>
                    <td colspan='2' align='center'><strong>48 a 59 meses</strong></td>
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
                          FROM (select c.* from 2019prestaciones c where c.codigo_prestacion in("P2060000") AND c.serie = "P") a
                          left join 2019rems b on (a.id_prestacion=b.prestacion_id_prestacion)
                          AND (b.Mes in ('.$mes.')) AND (b.establecimiento_id_establecimiento in ('.$estab.'))
                          group by  a.codigo_prestacion,a.descripcion,a.id_prestacion
                          order by a.id_prestacion';
                $registro = DB::connection('mysql_rem')->select($query);

                $i=0;

                foreach($registro as $row ){
                    $nombre_descripcion = $row->codigo_prestacion;
                    if ($nombre_descripcion == "P2060000"){
                        $nombre_descripcion = "TOTAL DE NIÑOS EN CONTROL";
                    }
                    ?>
                <tr>
                    <td colspan="2" align='center' nowrap="nowrap"><strong><?php echo $nombre_descripcion; ?></strong></td>
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
                          FROM (select c.* from 2019prestaciones c where c.codigo_prestacion in("P2400100","P2400110") AND c.serie = "P") a
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

                    $nombre_descripcion = $row->codigo_prestacion;
                    if ($nombre_descripcion == "P2400100"){
                        $nombre_descripcion = "+ 2 D.S. (>= +2.0)";
                    }
                    if ($nombre_descripcion == "P2400110"){
                        $nombre_descripcion = "+ 1 D.S. (+1.0 a +1.9)";
                    }
                    ?>

                <tr>
                    <?php
                    if($i==0){?>
                    <td rowspan='6' style="text-align:center; vertical-align:middle">INDICADOR PESO/EDAD</td>
                    <?php
                    }?>
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
                    <td align='right'><strong><?php echo number_format($totalCol32,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol33,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol34,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol35,0,",",".") ?></strong></td>
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
                          FROM (select c.* from 2019prestaciones c where c.codigo_prestacion in("P2070101","P2070102") AND c.serie = "P") a
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

                    $nombre_descripcion = $row->codigo_prestacion;
                    if ($nombre_descripcion == "P2070101"){
                        $nombre_descripcion = "- 1 D.S. (-1.0 a -1.9)";
                    }
                    if ($nombre_descripcion == "P2070102"){
                        $nombre_descripcion = "- 2 D.S. (<= -2.0)";
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
                    <td align='right'><strong><?php echo number_format($totalCol32,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol33,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol34,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol35,0,",",".") ?></strong></td>
                </tr>
                <!--  -->
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
                          FROM (select c.* from 2019prestaciones c where c.codigo_prestacion in("P2070201","P2070202") AND c.serie = "P") a
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

                    $nombre_descripcion = $row->codigo_prestacion;
                    if ($nombre_descripcion == "P2070201"){
                        $nombre_descripcion = "+ 2 D.S. (>= +2.0)";
                    }
                    if ($nombre_descripcion == "P2070202"){
                        $nombre_descripcion = "+ 1 D.S. (+1.0 a +1.9)";
                    }
                    ?>

                <tr>
                    <?php
                    if($i==0){?>
                    <td rowspan='6' style="text-align:center; vertical-align:middle">INDICADOR PESO/TALLA</td>
                    <?php
                    }?>
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
                    <td align='right'><strong><?php echo number_format($totalCol32,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol33,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol34,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol35,0,",",".") ?></strong></td>
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
                          FROM (select c.* from 2019prestaciones c where c.codigo_prestacion in("P2070301","P2070302") AND c.serie = "P") a
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

                    $nombre_descripcion = $row->codigo_prestacion;
                    if ($nombre_descripcion == "P2070301"){
                        $nombre_descripcion = "- 1 D.S. (-1.0 a -1.9)";
                    }
                    if ($nombre_descripcion == "P2070302"){
                        $nombre_descripcion = "- 2 D.S. (<= -2.0)";
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
                    <td align='right'><strong><?php echo number_format($totalCol32,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol33,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol34,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol35,0,",",".") ?></strong></td>
                </tr>
                <!--  -->
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
                          FROM (select c.* from 2019prestaciones c where c.codigo_prestacion in("P2400120","P2400130") AND c.serie = "P") a
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

                    $nombre_descripcion = $row->codigo_prestacion;
                    if ($nombre_descripcion == "P2400120"){
                        $nombre_descripcion = "+ 2 D.S. (>= +2.0)";
                    }
                    if ($nombre_descripcion == "P2400130"){
                        $nombre_descripcion = "+ 1 D.S. (+1.0 a +1.9)";
                    }
                    ?>

                <tr>
                    <?php
                    if($i==0){?>
                    <td rowspan='7' style="text-align:center; vertical-align:middle">INDICADOR TALLA/EDAD</td>
                    <?php
                    }?>
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
                    <td align='right'><strong><?php echo number_format($totalCol32,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol33,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol34,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol35,0,",",".") ?></strong></td>
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
                          FROM (select c.* from 2019prestaciones c where c.codigo_prestacion in("P2070401","P2070402") AND c.serie = "P") a
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

                    $nombre_descripcion = $row->codigo_prestacion;
                    if ($nombre_descripcion == "P2070401"){
                        $nombre_descripcion = "- 1 D.S. (-1.0 a -1.9)";
                    }
                    if ($nombre_descripcion == "P2070402"){
                        $nombre_descripcion = "- 2 D.S. (<= -2.0)";
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
                    <td align='right'><strong><?php echo number_format($totalCol32,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol33,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol34,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol35,0,",",".") ?></strong></td>
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
                          FROM (select c.* from 2019prestaciones c where c.codigo_prestacion in("P2400140") AND c.serie = "P") a
                          left join 2019rems b on (a.id_prestacion=b.prestacion_id_prestacion)
                          AND (b.Mes in ('.$mes.')) AND (b.establecimiento_id_establecimiento in ('.$estab.'))
                          group by  a.codigo_prestacion,a.descripcion,a.id_prestacion
                          order by a.id_prestacion';
                $registro = DB::connection('mysql_rem')->select($query);

                $i=0;

                foreach($registro as $row ){
                    $nombre_descripcion = $row->codigo_prestacion;
                    if ($nombre_descripcion == "P2400140"){
                        $nombre_descripcion = "PROMEDIO (-0,9 A + 0,9)";
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
                <!-- -->
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
                          FROM (select c.* from 2019prestaciones c where c.codigo_prestacion in("P2070501","P2070502","P2070503","P2070504","","P2070505") AND c.serie = "P") a
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

                    $nombre_descripcion = $row->codigo_prestacion;
                    if ($nombre_descripcion == "P2070501"){
                        $nombre_descripcion = "RIESGO DE DESNUTRIR/ DEFICIT PONDERAL";
                    }
                    if ($nombre_descripcion == "P2070502"){
                        $nombre_descripcion = "DESNUTRIDO";
                    }
                    if ($nombre_descripcion == "P2070503"){
                        $nombre_descripcion = "SOBREPESO / RIESGO OBESIDAD";
                    }
                    if ($nombre_descripcion == "P2070504"){
                        $nombre_descripcion = "OBESO";
                    }
                    if ($nombre_descripcion == "P2070505"){
                        $nombre_descripcion = "NORMAL";
                    }
                    ?>

                <tr>
                    <?php
                    if($i==0){?>
                    <td rowspan='8' style="text-align:center; vertical-align:middle">DIAGNOSTICO NUTRICIONAL INTEGRADO</td>
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
                    <?php
                    $i++;
                }
                ?>
                </tr>
                <tr>
                    <td align='left'><strong>SUBTOTAL</strong></td>
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
                          FROM (select c.* from 2019prestaciones c where c.codigo_prestacion in("P2070506") AND c.serie = "P") a
                          left join 2019rems b on (a.id_prestacion=b.prestacion_id_prestacion)
                          AND (b.Mes in ('.$mes.')) AND (b.establecimiento_id_establecimiento in ('.$estab.'))
                          group by  a.codigo_prestacion,a.descripcion,a.id_prestacion
                          order by a.id_prestacion';
                $registro = DB::connection('mysql_rem')->select($query);

                $i=0;

                foreach($registro as $row ){
                    $nombre_descripcion = $row->codigo_prestacion;
                    if ($nombre_descripcion == "P2070506"){
                        $nombre_descripcion = "DESNUTRICIÓN SECUNDARIA ";
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
                <tr>
                    <td align='left'><strong>TOTAL</strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol01+$row->Col01,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol02+$row->Col02,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol03+$row->Col03,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol04+$row->Col04,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol05+$row->Col05,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol06+$row->Col06,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol07+$row->Col07,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol08+$row->Col08,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol09+$row->Col09,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol10+$row->Col10,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol11+$row->Col11,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol12+$row->Col12,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol13+$row->Col13,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol14+$row->Col14,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol15+$row->Col15,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol16+$row->Col16,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol17+$row->Col17,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol18+$row->Col18,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol19+$row->Col19,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol20+$row->Col20,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol21+$row->Col21,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol22+$row->Col22,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol23+$row->Col23,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol24+$row->Col24,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol25+$row->Col25,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol26+$row->Col26,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol27+$row->Col27,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol28+$row->Col28,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol29+$row->Col29,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol30+$row->Col30,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol31+$row->Col31,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol32+$row->Col32,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol33+$row->Col33,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol34+$row->Col34,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol35+$row->Col35,0,",",".") ?></strong></td>
                </tr>
            </tbody>
        </table>
    </div>

    <br>

    <!-- SECCION A.1 -->
    <div class="col-sm tab table-responsive" id="A.1">
        <table class="table table-hover table-bordered table-sm">
            <thead>
                <tr>
                    <td colspan="13" class="active"><strong>SECCION A.1: POBLACIÓN EN CONTROL, SEGÚN ESTADO NUTRICIONAL PARA NIÑOS DE 60 MESES-9 AÑOS 11 MESES.</strong></td>
                </tr>
                <tr>
                    <td colspan='2' rowspan='3' style="text-align:center; vertical-align:middle"><strong>INDICADOR NUTRICIONAL Y PARÁMETROS DE MEDICIÓN</strong></td>
                    <td colspan='3' rowspan='2' style="text-align:center; vertical-align:middle"><strong>TOTAL</strong></td>
                    <td colspan='8' align='center'><strong>GRUPOS DE EDAD (en meses - años) Y SEXO</strong></td>
                </tr>
                <tr>
                    <td colspan="2" align="center"><strong>60 a 71 meses</strong></td>
                    <td colspan="2" align="center"><strong>6 a 9 años 11 meses</strong></td>
                    <td colspan="2" style="text-align:center; vertical-align:middle"><strong>Pueblos Originarios</strong></td>
                    <td colspan="2" style="text-align:center; vertical-align:middle"><strong>Población Inmigrantes</strong></td>
                </tr>
                <tr>
                    <td align="center"><strong>Ambos sexos</strong></td>
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
                          FROM (select c.* from 2019prestaciones c where c.codigo_prestacion in("P2400150") AND c.serie = "P") a
                          left join 2019rems b on (a.id_prestacion=b.prestacion_id_prestacion)
                          AND (b.Mes in ('.$mes.')) AND (b.establecimiento_id_establecimiento in ('.$estab.'))
                          group by  a.codigo_prestacion,a.descripcion,a.id_prestacion
                          order by a.id_prestacion';
                $registro = DB::connection('mysql_rem')->select($query);

                $i=0;

                foreach($registro as $row ){
                    $nombre_descripcion = $row->codigo_prestacion;
                    if ($nombre_descripcion == "P2400150"){
                        $nombre_descripcion = "TOTAL DE NIÑOS EN CONTROL";
                    }
                    ?>
                <tr>
                    <td colspan="2" align='center' nowrap="nowrap"><strong><?php echo $nombre_descripcion; ?></strong></td>
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
                          FROM (select c.* from 2019prestaciones c where c.codigo_prestacion in("P2400160","P2400170","P2400180") AND c.serie = "P") a
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
                    $totalCol03=$totalCol03+$row->Col03;
                    $totalCol04=$totalCol04+$row->Col04;
                    $totalCol05=$totalCol05+$row->Col05;
                    $totalCol06=$totalCol06+$row->Col06;
                    $totalCol07=$totalCol07+$row->Col07;
                    $totalCol08=$totalCol08+$row->Col08;
                    $totalCol09=$totalCol09+$row->Col09;
                    $totalCol10=$totalCol10+$row->Col10;
                    $totalCol11=$totalCol11+$row->Col11;

                    $nombre_descripcion = $row->codigo_prestacion;
                    if ($nombre_descripcion == "P2400160"){
                        $nombre_descripcion = "+ 3 D.S. (>= 3 )";
                    }
                    if ($nombre_descripcion == "P2400170"){
                        $nombre_descripcion = "+ 2 D.S. (>= +2.0 a +2.9)";
                    }
                    if ($nombre_descripcion == "P2400180"){
                        $nombre_descripcion = "+ 1 D.S. (>= +1.0 a +1.9)";
                    }
                    ?>
                <tr>
                    <?php
                    if($i==0){?>
                    <td rowspan='8' style="text-align:center; vertical-align:middle">INDICADOR IMC / EDAD</td>
                    <?php
                    }?>
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
                          FROM (select c.* from 2019prestaciones c where c.codigo_prestacion in("P2400190","P2400200") AND c.serie = "P") a
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
                    $totalCol03=$totalCol03+$row->Col03;
                    $totalCol04=$totalCol04+$row->Col04;
                    $totalCol05=$totalCol05+$row->Col05;
                    $totalCol06=$totalCol06+$row->Col06;
                    $totalCol07=$totalCol07+$row->Col07;
                    $totalCol08=$totalCol08+$row->Col08;
                    $totalCol09=$totalCol09+$row->Col09;
                    $totalCol10=$totalCol10+$row->Col10;
                    $totalCol11=$totalCol11+$row->Col11;
                    $nombre_descripcion = $row->codigo_prestacion;
                    if ($nombre_descripcion == "P2400190"){
                        $nombre_descripcion = "- 1 D.S. (-1.0 a -1.9)";
                    }
                    if ($nombre_descripcion == "P2400200"){
                        $nombre_descripcion = "- 2 D.S. (<= -2.0)";
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
                          FROM (select c.* from 2019prestaciones c where c.codigo_prestacion in("P2400210") AND c.serie = "P") a
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
                    $totalCol03=$totalCol03+$row->Col03;
                    $totalCol04=$totalCol04+$row->Col04;
                    $totalCol05=$totalCol05+$row->Col05;
                    $totalCol06=$totalCol06+$row->Col06;
                    $totalCol07=$totalCol07+$row->Col07;
                    $totalCol08=$totalCol08+$row->Col08;
                    $totalCol09=$totalCol09+$row->Col09;
                    $totalCol10=$totalCol10+$row->Col10;
                    $totalCol11=$totalCol11+$row->Col11;

                    $nombre_descripcion = $row->codigo_prestacion;
                    if ($nombre_descripcion == "P2400210"){
                        $nombre_descripcion = "PROMEDIO (-0,9 A + 0,9)";
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
                <!--  -->
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
                          FROM (select c.* from 2019prestaciones c where c.codigo_prestacion in("P2400220","P2400230") AND c.serie = "P") a
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
                    $totalCol03=$totalCol03+$row->Col03;
                    $totalCol04=$totalCol04+$row->Col04;
                    $totalCol05=$totalCol05+$row->Col05;
                    $totalCol06=$totalCol06+$row->Col06;
                    $totalCol07=$totalCol07+$row->Col07;
                    $totalCol08=$totalCol08+$row->Col08;
                    $totalCol09=$totalCol09+$row->Col09;
                    $totalCol10=$totalCol10+$row->Col10;
                    $totalCol11=$totalCol11+$row->Col11;

                    $nombre_descripcion = $row->codigo_prestacion;
                    if ($nombre_descripcion == "P2400220"){
                        $nombre_descripcion = "+ 2 D.S. (>= +2.0)";
                    }
                    if ($nombre_descripcion == "P2400230"){
                        $nombre_descripcion = "+ 1 D.S. (+1.0 a +1.9)";
                    }
                    ?>

                <tr>
                    <?php
                    if($i==0){?>
                    <td rowspan='7' style="text-align:center; vertical-align:middle">INDICADOR TALLA/EDAD</td>
                    <?php
                    }?>
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
                          FROM (select c.* from 2019prestaciones c where c.codigo_prestacion in("P2400240","P2400250") AND c.serie = "P") a
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
                    $totalCol03=$totalCol03+$row->Col03;
                    $totalCol04=$totalCol04+$row->Col04;
                    $totalCol05=$totalCol05+$row->Col05;
                    $totalCol06=$totalCol06+$row->Col06;
                    $totalCol07=$totalCol07+$row->Col07;
                    $totalCol08=$totalCol08+$row->Col08;
                    $totalCol09=$totalCol09+$row->Col09;
                    $totalCol10=$totalCol10+$row->Col10;
                    $totalCol11=$totalCol11+$row->Col11;

                    $nombre_descripcion = $row->codigo_prestacion;
                    if ($nombre_descripcion == "P2400240"){
                        $nombre_descripcion = "- 1 D.S. (-1.0 a -1.9)";
                    }
                    if ($nombre_descripcion == "P2400250"){
                        $nombre_descripcion = "- 2 D.S. (<= -2.0)";
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
                          FROM (select c.* from 2019prestaciones c where c.codigo_prestacion in("P2400260") AND c.serie = "P") a
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
                    $totalCol03=$totalCol03+$row->Col03;
                    $totalCol04=$totalCol04+$row->Col04;
                    $totalCol05=$totalCol05+$row->Col05;
                    $totalCol06=$totalCol06+$row->Col06;
                    $totalCol07=$totalCol07+$row->Col07;
                    $totalCol08=$totalCol08+$row->Col08;
                    $totalCol09=$totalCol09+$row->Col09;
                    $totalCol10=$totalCol10+$row->Col10;
                    $totalCol11=$totalCol11+$row->Col11;

                    $nombre_descripcion = $row->codigo_prestacion;
                    if ($nombre_descripcion == "P2400260"){
                        $nombre_descripcion = "PROMEDIO (-0,9 A + 0,9)";
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
                <!--  -->
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
                          FROM (select c.* from 2019prestaciones c where c.codigo_prestacion in("P2400270","P2400280","P2400290") AND c.serie = "P") a
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
                    $totalCol03=$totalCol03+$row->Col03;
                    $totalCol04=$totalCol04+$row->Col04;
                    $totalCol05=$totalCol05+$row->Col05;
                    $totalCol06=$totalCol06+$row->Col06;
                    $totalCol07=$totalCol07+$row->Col07;
                    $totalCol08=$totalCol08+$row->Col08;
                    $totalCol09=$totalCol09+$row->Col09;
                    $totalCol10=$totalCol10+$row->Col10;
                    $totalCol11=$totalCol11+$row->Col11;

                    $nombre_descripcion = $row->codigo_prestacion;
                    if ($nombre_descripcion == "P2400270"){
                        $nombre_descripcion = "NORMAL (< p75)";
                    }
                    if ($nombre_descripcion == "P2400280"){
                        $nombre_descripcion = "RIESGO DE OBESIDAD ABDOMINAL (75 < p < 90)";
                    }
                    if ($nombre_descripcion == "P2400290"){
                        $nombre_descripcion = "OBESIDAD ABDOMINAL (>p90)";
                    }
                    ?>

                <tr>
                    <?php
                    if($i==0){?>
                    <td rowspan='4' style="text-align:center; vertical-align:middle">INDICADOR PERIMETRO DE CINTURA / EDAD</td>
                    <?php
                    }?>
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
                </tr>
                <!-- -->
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
                          FROM (select c.* from 2019prestaciones c where c.codigo_prestacion in("P2400300","P2400310","P2400320","P2400330","P2400340","P2400350") AND c.serie = "P") a
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
                    $totalCol03=$totalCol03+$row->Col03;
                    $totalCol04=$totalCol04+$row->Col04;
                    $totalCol05=$totalCol05+$row->Col05;
                    $totalCol06=$totalCol06+$row->Col06;
                    $totalCol07=$totalCol07+$row->Col07;
                    $totalCol08=$totalCol08+$row->Col08;
                    $totalCol09=$totalCol09+$row->Col09;
                    $totalCol10=$totalCol10+$row->Col10;
                    $totalCol11=$totalCol11+$row->Col11;

                    $nombre_descripcion = $row->codigo_prestacion;
                    if ($nombre_descripcion == "P2400300"){
                        $nombre_descripcion = "RIESGO DE DESNUTRIR/ DEFICIT PONDERAL";
                    }
                    if ($nombre_descripcion == "P2400310"){
                        $nombre_descripcion = "DESNUTRIDO";
                    }
                    if ($nombre_descripcion == "P2400320"){
                        $nombre_descripcion = "SOBREPESO / RIESGO OBESIDAD";
                    }
                    if ($nombre_descripcion == "P2400340"){
                        $nombre_descripcion = "OBESO";
                    }
                    if ($nombre_descripcion == "P2400330"){
                        $nombre_descripcion = "OBESO SEVERO";
                    }
                    if ($nombre_descripcion == "P2400350"){
                        $nombre_descripcion = "NORMAL";
                    }
                    ?>

                <tr>
                    <?php
                    if($i==0){?>
                    <td rowspan='9' style="text-align:center; vertical-align:middle">DIAGNOSTICO NUTRICIONAL INTEGRADO</td>
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
                    <?php
                    $i++;
                }
                ?>
                </tr>
                <tr>
                    <td align='left'><strong>SUBTOTAL</strong></td>
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
                          FROM (select c.* from 2019prestaciones c where c.codigo_prestacion in("P2400360") AND c.serie = "P") a
                          left join 2019rems b on (a.id_prestacion=b.prestacion_id_prestacion)
                          AND (b.Mes in ('.$mes.')) AND (b.establecimiento_id_establecimiento in ('.$estab.'))
                          group by  a.codigo_prestacion,a.descripcion,a.id_prestacion
                          order by a.id_prestacion';
                $registro = DB::connection('mysql_rem')->select($query);

                $i=0;

                foreach($registro as $row ){
                    $nombre_descripcion = $row->codigo_prestacion;
                    if ($nombre_descripcion == "P2400360"){
                        $nombre_descripcion = "DESNUTRICIÓN SECUNDARIA ";
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
                    <td align='right'><strong><?php echo number_format($totalCol01+$row->Col01,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol02+$row->Col02,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol03+$row->Col03,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol04+$row->Col04,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol05+$row->Col05,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol06+$row->Col06,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol07+$row->Col07,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol08+$row->Col08,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol09+$row->Col09,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol10+$row->Col10,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol11+$row->Col11,0,",",".") ?></strong></td>
                </tr>
                <tr>
                    <td align='left' colspan="13">NOTA(*): El Diagnóstico Nutricional Integrado de Déficit para los niños (as) 5 años y más denomina Déficit Ponderal al Riesgo de Desnutrir.</td>
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
                    <td colspan="5" class="active"><strong>SECCION B: POBLACION EN CONTROL SEGÚN RESULTADO DE EVALUACIÓN DEL DESARROLLO PSICOMOTOR.</strong></td>
                </tr>
                <tr>
                    <td colspan='2' align='center'><strong>RESULTADO Y GRUPOS DE EDAD</strong></td>
                    <td align='center'><strong>TOTAL</strong></td>
                    <td align='center'><strong>Hombres</strong></td>
                    <td align='center'><strong>Mujer</strong></td>
                </tr>
            </thead>
            <tbody>
                <?php
                $query = 'SELECT a.codigo_prestacion,a.descripcion
                              ,sum(ifnull(b.Col01,0)) Col01
                              ,sum(ifnull(b.Col02,0)) Col02
                              ,sum(ifnull(b.Col03,0)) Col03
                          FROM (select c.* from 2019prestaciones c where c.codigo_prestacion in("P2100200","P2300100","P2300200","P2100400","P2100500",
                                                                                                "P2100600","P2300300","P2300400","P2200900","P2300000") AND c.serie = "P") a
                          left join 2019rems b on (a.id_prestacion=b.prestacion_id_prestacion)
                          AND (b.Mes in ('.$mes.')) AND (b.establecimiento_id_establecimiento in ('.$estab.'))
                          group by  a.codigo_prestacion,a.descripcion,a.id_prestacion
                          order by a.id_prestacion';
                $registro = DB::connection('mysql_rem')->select($query);

                $i=0;

                foreach($registro as $row ){
                    $nombre_descripcion = $row->codigo_prestacion;
                    if ($nombre_descripcion == "P2100200"){
                      $nombre_descripcion = "Menor 12 meses";
                    }
                    if ($nombre_descripcion == "P2300100"){
                      $nombre_descripcion = "12 a 17 meses";
                    }
                    if ($nombre_descripcion == "P2300200"){
                      $nombre_descripcion = "18 a 23 meses";
                    }
                    if ($nombre_descripcion == "P2100400"){
                      $nombre_descripcion = "24 a 47 meses";
                    }
                    if ($nombre_descripcion == "P2100500"){
                      $nombre_descripcion = " 48 a 59 meses";
                    }
                    if ($nombre_descripcion == "P2100600"){
                       $nombre_descripcion = "Menor 12 meses";
                    }
                    if ($nombre_descripcion == "P2300300"){
                      $nombre_descripcion = "12 a 17 meses";
                    }
                    if ($nombre_descripcion == "P2300400"){
                      $nombre_descripcion = "18 a 23 meses";
                    }
                    if ($nombre_descripcion == "P2200900"){
                      $nombre_descripcion = "24 a 47 meses";
                    }
                    if ($nombre_descripcion == "P2300000"){
                      $nombre_descripcion = " 48 a 59 meses";
                    }
                    ?>
                <tr>
                    <?php
                    if($i==0){?>
                    <td align='left' rowspan='5' style="text-align:center; vertical-align:middle">RIESGO</td>
                    <?php
                    }
                    if($i==5){?>
                    <td align='left' rowspan='5' style="text-align:center; vertical-align:middle">RETRASO</td>
                    <?php
                    }?>
                    <td align='center' nowrap="nowrap"><?php echo $nombre_descripcion; ?></td>
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

    <!-- SECCION C -->
    <div class="col-sm tab table-responsive" id="C">
        <table class="table table-hover table-bordered table-sm">
            <thead>
                <tr>
                    <td colspan="13" class="active"><strong>SECCION C: POBLACIÓN MENOR DE 1 AÑO EN CONTROL, SEGÚN SCORE RIESGO EN IRA Y VISITA DOMICILIARIA INTEGRAL EN EL SEMESTRE.</strong></td>
                </tr>
                <tr>
                    <td colspan='2' align='center'><strong>RESULTADO</strong></td>
                    <td align='center'><strong>TOTAL</strong></td>
                    <td align='center'><strong>Diada, menor de 10 días</strong></td>
                    <td align='center'><strong>1 mes</strong></td>
                    <td align='center'><strong>2 meses</strong></td>
                    <td align='center'><strong>3 meses</strong></td>
                    <td align='center'><strong>4 meses</strong></td>
                    <td align='center'><strong>5 meses</strong></td>
                    <td align='center'><strong>6 meses</strong></td>
                    <td align='center'><strong>Total de Niños y Niñas que han recibido VDI</strong></td>
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
                          FROM (select c.* from 2019prestaciones c where c.codigo_prestacion in("P2090300","P2090400","P2100100") AND c.serie = "P") a
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

                    $nombre_descripcion = $row->codigo_prestacion;
                    if ($nombre_descripcion == "P2090300"){
                      $nombre_descripcion = "LEVE";
                    }
                    if ($nombre_descripcion == "P2090400"){
                      $nombre_descripcion = "MODERADO";
                    }
                    if ($nombre_descripcion == "P2100100"){
                      $nombre_descripcion = "GRAVE";
                    }
                    ?>
                <tr>
                    <?php
                    if($i==0){?>
                    <td align='left' rowspan='4' style="text-align:center; vertical-align:middle">SCORE DE RIESGO</td>
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
                    <td colspan="2" class="active"><strong>SECCION D: POBLACIÓN EN CONTROL EN EL SEMESTRE CON CONSULTA NUTRICIONAL, SEGÚN ESTRATEGIA.</strong></td>
                </tr>
                <tr>
                    <td align='center'><strong>NIÑO/A CON CONSULTA NUTRICIONAL EN</strong></td>
                    <td align='center'><strong>TOTAL</strong></td>
                </tr>
            </thead>
            <tbody>
                <?php
                $query = 'SELECT a.codigo_prestacion,a.descripcion
                              ,sum(ifnull(b.Col01,0)) Col01
                          FROM (select c.* from 2019prestaciones c where c.codigo_prestacion in("P2200700","P2200800") AND c.serie = "P") a
                          left join 2019rems b on (a.id_prestacion=b.prestacion_id_prestacion)
                          AND (b.Mes in ('.$mes.')) AND (b.establecimiento_id_establecimiento in ('.$estab.'))
                          group by  a.codigo_prestacion,a.descripcion,a.id_prestacion
                          order by a.id_prestacion';
                $registro = DB::connection('mysql_rem')->select($query);

                $i=0;

                foreach($registro as $row ){
                    $nombre_descripcion = $row->codigo_prestacion;
                    if ($nombre_descripcion == "P2200700"){
                      $nombre_descripcion = "AL CONTROL DEL 5TO MES";
                    }
                    if ($nombre_descripcion == "P2200800"){
                      $nombre_descripcion = "AL CONTROL DE LOS 3 AÑOS Y 6 MESES";
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

    <!-- SECCION E -->
    <div class="col-sm tab table-responsive" id="E">
        <table class="table table-hover table-bordered table-sm">
            <thead>
                <tr>
                    <td colspan="2" class="active"><strong>SECCION E: POBLACIÓN INASISTENTE A CONTROL DEL NIÑO SANO (AL CORTE).</strong></td>
                </tr>
                <tr>
                    <td align='center'><strong>EDAD</strong></td>
                    <td align='center'><strong>TOTAL</strong></td>
                </tr>
            </thead>
            <tbody>
                <?php
                $query = 'SELECT a.codigo_prestacion,a.descripcion
                              ,sum(ifnull(b.Col01,0)) Col01
                          FROM (select c.* from 2019prestaciones c where c.codigo_prestacion in("P2300410","P2300420","P2300460","P2300470","P2300480","P2300490","P2300500","P2300510",
                                                                                                "P2300520") AND c.serie = "P") a
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
                    if ($nombre_descripcion == "P2300410"){
                      $nombre_descripcion = "MENOR DE 6 MESES";
                    }
                    if ($nombre_descripcion == "P2300420"){
                      $nombre_descripcion = "12 A 17 MESES";
                    }
                    if ($nombre_descripcion == "P2300460"){
                      $nombre_descripcion = "12 A 17 MESES";
                    }
                    if ($nombre_descripcion == "P2300470"){
                      $nombre_descripcion = "18 A 23 MESES";
                    }
                    if ($nombre_descripcion == "P2300480"){
                      $nombre_descripcion = "24 A 35 MESES";
                    }
                    if ($nombre_descripcion == "P2300490"){
                      $nombre_descripcion = "26 A 27 MESES";
                    }
                    if ($nombre_descripcion == "P2300500"){
                      $nombre_descripcion = "48 A 59 MESES";
                    }
                    if ($nombre_descripcion == "P2300510"){
                      $nombre_descripcion = "60 A 71 MESES";
                    }
                    if ($nombre_descripcion == "P2300520"){
                      $nombre_descripcion = "6 A 9 AÑOS";
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

    <!-- SECCION F -->
    <div class="col-sm tab table-responsive" id="F">
        <table class="table table-hover table-bordered table-sm">
            <thead>
                <tr>
                    <td colspan="5" class="active"><strong>SECCION F: POBLACIÓN INFANTIL SEGÚN DIAGNÓSTICO DE PRESIÓN ARTERIAL (Incluida en sección A y A1).</strong></td>
                </tr>
                <tr>
                    <td rowspan="2" align='center'><strong>CLASIFICACIÓN</strong></td>
                    <td rowspan="2" align='center'><strong>TOTAL</strong></td>
                    <td colspan="3" align='center'><strong>GRUPOS DE EDAD (en meses)</strong></td>
                </tr>
                <tr>
                    <td align='center'><strong>36 a 47 meses</strong></td>
                    <td align='center'><strong>48 a 71 meses</strong></td>
                    <td align='center'><strong>6-9 años</strong></td>
                </tr>
            </thead>
            <tbody>
                <?php
                $query = 'SELECT a.codigo_prestacion,a.descripcion
                              ,sum(ifnull(b.Col01,0)) Col01
                              ,sum(ifnull(b.Col02,0)) Col02
                              ,sum(ifnull(b.Col03,0)) Col03
                              ,sum(ifnull(b.Col04,0)) Col04
                          FROM (select c.* from 2019prestaciones c where c.codigo_prestacion in("P2300530","P2300540","P2300550","P2300560") AND c.serie = "P") a
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
                    if ($nombre_descripcion == "P2300530"){
                      $nombre_descripcion = "NORMAL (PA menor al percentil 90)";
                    }
                    if ($nombre_descripcion == "P2300540"){
                      $nombre_descripcion = "PRE-HIPERTENSIÓN (PA entre percentil 90 al 95)";
                    }
                    if ($nombre_descripcion == "P2300550"){
                      $nombre_descripcion = "ETAPA 1 (PA entre percentil 95 al 99)";
                    }
                    if ($nombre_descripcion == "P2300560"){
                      $nombre_descripcion = "ETAPA 2 (PA mayor al percentil 99)";
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
                    <td align='left'><strong>TOTAL</strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol01,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol02,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol03,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol04,0,",",".") ?></strong></td>
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
                    <td colspan="8" class="active"><strong>SECCION G: POBLACIÓN INFANTIL EUTRÓFICA, SEGÚN RIESGO DE MALNUTRICIÓN POR EXCESO (Incluida en sección A y A1).</strong></td>
                </tr>
                <tr>
                    <td rowspan="2" align='center'><strong>RESULTADO</strong></td>
                    <td rowspan="2" align='center'><strong>TOTAL</strong></td>
                    <td colspan="6" align='center'><strong>GRUPOS DE EDAD (en meses)</strong></td>
                </tr>
                <tr>
                    <td align='center'><strong>4 a 11 meses</strong></td>
                    <td align='center'><strong>12 a 23 meses</strong></td>
                    <td align='center'><strong>24 a 35 meses</strong></td>
                    <td align='center'><strong>36 a 47 meses</strong></td>
                    <td align='center'><strong>48 a 59 meses</strong></td>
                    <td align='center'><strong>60 a 71 meses</strong></td>
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
                          FROM (select c.* from 2019prestaciones c where c.codigo_prestacion in("P2300570","P2300580") AND c.serie = "P") a
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

                foreach($registro as $row ){
                    $totalCol01=$totalCol01+$row->Col01;
                    $totalCol02=$totalCol02+$row->Col02;
                    $totalCol03=$totalCol03+$row->Col03;
                    $totalCol04=$totalCol04+$row->Col04;
                    $totalCol05=$totalCol05+$row->Col05;
                    $totalCol06=$totalCol06+$row->Col06;
                    $totalCol07=$totalCol07+$row->Col07;

                    $nombre_descripcion = $row->codigo_prestacion;
                    if ($nombre_descripcion == "P2300570"){
                      $nombre_descripcion = "SIN RIESGO";
                    }
                    if ($nombre_descripcion == "P2300580"){
                      $nombre_descripcion = "CON RIESGO";
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
                <tr>
                    <td align='left'><strong>TOTAL</strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol01,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol02,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol03,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol04,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol05,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol06,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol07,0,",",".") ?></strong></td>
                </tr>
            </tbody>
        </table>
    </div>
    </div>

    <br>

    <!-- SECCION H -->
    <div class="col-sm tab table-responsive" id="G">
        <table class="table table-hover table-bordered table-sm">
            <thead>
                <tr>
                    <td colspan="42" class="active"><strong>SECCION H: POBLACIÓN INFANTIL SEGÚN DIAGNÓSTICO DE NANEAS (incluidas en sección A y A.1).</strong></td>
                </tr>
                <tr>
                    <td rowspan="3" align='center'><strong>DIAGNOSTICOS</strong></td>
                    <td colspan="3" rowspan="2" align='center'><strong>TOTAL</strong></td>
                    <td colspan="34" align='center'><strong>GRUPOS DE EDAD (en meses - años) Y SEXO</strong></td>
                    <td colspan="2" rowspan="2" align='center'><strong>Pueblos Originarios</strong></td>
                    <td colspan="2" rowspan="2" align='center'><strong>Población Migrantes</strong></td>
                </tr>
                <tr>
                    <td colspan="2" align='center'><strong>Menor de 1 mes</strong></td>
                    <td colspan="2" align='center'><strong>1 mes</strong></td>
                    <td colspan="2" align='center'><strong>2 meses</strong></td>
                    <td colspan="2" align='center'><strong>3 meses</strong></td>
                    <td colspan="2" align='center'><strong>4 meses</strong></td>
                    <td colspan="2" align='center'><strong>5 meses</strong></td>
                    <td colspan="2" align='center'><strong>6 meses</strong></td>
                    <td colspan="2" align='center'><strong>7 a 11 meses</strong></td>
                    <td colspan="2" align='center'><strong>12 a 17 meses</strong></td>
                    <td colspan="2" align='center'><strong>18 a 23 meses</strong></td>
                    <td colspan="2" align='center'><strong>24 a 35 meses</strong></td>
                    <td colspan="2" align='center'><strong>36 a 41 meses</strong></td>
                    <td colspan="2" align='center'><strong>42 a 47 meses</strong></td>
                    <td colspan="2" align='center'><strong>48 a 59 meses</strong></td>
                    <td colspan="2" align='center'><strong>60 a 71 meses</strong></td>
                    <td colspan="2" align='center'><strong>6 a 7 años</strong></td>
                    <td colspan="2" align='center'><strong>8 a 9 años</strong></td>
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
                          FROM (select c.* from 2019prestaciones c where c.codigo_prestacion in("P2500100","P2500200","P2500300","P2500400","P2500500","P2500600","P2500700","P2500800",
                                                                                                "P2500900","P2501000","P2501100","P2501200","P2501300","P2501400","P2501500","P2501600",
                                                                                                "P2501700") AND c.serie = "P") a
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

                    $nombre_descripcion = $row->codigo_prestacion;
                    if ($nombre_descripcion == "P2500100"){
                      $nombre_descripcion = "PRESION ARTERIAL ELEVADA";
                    }
                    if ($nombre_descripcion == "P2500200"){
                      $nombre_descripcion = "DIABETES TIPO I";
                    }
                    if ($nombre_descripcion == "P2500300"){
                      $nombre_descripcion = "DIABETES TIPO II";
                    }
                    if ($nombre_descripcion == "P2500400"){
                      $nombre_descripcion = "SINDROME DE DOWN";
                    }
                    if ($nombre_descripcion == "P2500500"){
                      $nombre_descripcion = "TRASTORNO ESPECTRO AUTISTA";
                    }
                    if ($nombre_descripcion == "P2500600"){
                      $nombre_descripcion = "FIBROSIS QUISTICA";
                    }
                    if ($nombre_descripcion == "P2500700"){
                      $nombre_descripcion = "PARALISIS CEREBRAL";
                    }
                    if ($nombre_descripcion == "P2500800"){
                      $nombre_descripcion = "ENFERMEDADES RENALES CRONICAS";
                    }
                    if ($nombre_descripcion == "P2500900"){
                      $nombre_descripcion = "ENFERMEDADES CARDIACAS CRONICAS";
                    }
                    if ($nombre_descripcion == "P2501000"){
                      $nombre_descripcion = "ENFERMEDADES GASTRICAS CRONICAS";
                    }
                    if ($nombre_descripcion == "P2501100"){
                      $nombre_descripcion = "ENFERMEDADES DE OJO";
                    }
                    if ($nombre_descripcion == "P2501200"){
                      $nombre_descripcion = "ENFERMEDADES DEL OIDO";
                    }
                    if ($nombre_descripcion == "P2501300"){
                      $nombre_descripcion = "ENFERMEDADES DE LA PIEL";
                    }
                    if ($nombre_descripcion == "P2501400"){
                      $nombre_descripcion = "NEOPLASIAS";
                    }
                    if ($nombre_descripcion == "P2501500"){
                      $nombre_descripcion = "MALFORMACIONES CONGENITAS, DEFORMIDADES Y ANOMALIAS CROMOSOMICAS";
                    }
                    if ($nombre_descripcion == "P2501600"){
                      $nombre_descripcion = "PREMATUROS";
                    }
                    if ($nombre_descripcion == "P2501700"){
                      $nombre_descripcion = "HOSPITALIZACION DOMICILIARIA";
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
                    <td align='right'><strong><?php echo number_format($totalCol35,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol36,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol37,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol38,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol39,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol40,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol41,0,",",".") ?></strong></td>
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
