@extends('layouts.app')

@section('title', 'Resumen Estadistico Mensual')

@section('content')

<?php

use Illuminate\Support\Facades\DB;

?>

@include('indicators.rem.partials.nav')

<h3>REM-25. SERVICIOS DE SANGRE.</h3>

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
    <div class="col-sm tab table-responsive" id="A.1">
        <table class="table table-hover table-bordered table-sm">
            <thead>
                <tr>
                    <td colspan="26" class="active"><strong>SECCIÓN A.1: POBLACIÓN DONANTE (CS-UMT-BS).</strong></td>
                </tr>
                <tr>
                    <td rowspan="3" style="text-align:center; vertical-align:middle"><strong>DONANTES</strong></td>
                    <td colspan="2" rowspan="3" style="text-align:center; vertical-align:middle"><strong>DESCRIPCIÓN</strong></td>
                    <td colspan="3" rowspan="2" style="text-align:center; vertical-align:middle"><strong>TOTAL</strong></td>
                    <td colspan="20" align="center"><strong>POR EDAD</strong></td>
                </tr>
                <tr>
                    <td colspan="2" align="center"><strong>18-19</strong></td>
                    <td colspan="2" align="center"-><strong>20-24</strong></td>
                    <td colspan="2" align="center"><strong>25-29</strong></td>
                    <td colspan="2" align="center"><strong>30-34</strong></td>
                    <td colspan="2" align="center"><strong>35-39</strong></td>
                    <td colspan="2" align="center"><strong>40-44</strong></td>
                    <td colspan="2" align="center"><strong>45-49</strong></td>
                    <td colspan="2" align="center"><strong>50-54</strong></td>
                    <td colspan="2" align="center"><strong>55-59</strong></td>
                    <td colspan="2" align="center"><strong>60-64</strong></td>
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
                          FROM (select c.* from 2019prestaciones c where c.codigo_prestacion in("25100100","25100300","25100500")) a
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

                    $nombre_descripcion = $row->codigo_prestacion;
                    if ($nombre_descripcion == "25100100"){
                        $nombre_descripcion = "ACEPTADOS";
      							}
      							if ($nombre_descripcion == "25100300"){
                        $nombre_descripcion = "ACEPTADOS";
      							}
      							if ($nombre_descripcion == "25100500"){
                        $nombre_descripcion = "ACEPTADOS";
      							}
                    ?>
                <tr>
                    <?php
      							if($i==0){?>
                    <td rowspan="2" style="text-align:center; vertical-align:middle">ALTRUISTAS</td>
                    <td style="text-align:center; vertical-align:middle">NUEVOS</td>
      							<?php
      							}
      							if($i==1){?>
                    <td style="text-align:center; vertical-align:middle">REPETIDOS</td>
      							<?php
      							}
      							if($i==2){?>
                    <td colspan="2" style="text-align:center; vertical-align:middle">FAMILIARES O REPOSICIÓN</td>
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
                    <?php
                    $i++;
                }
                ?>
                </tr>
                <tr>
                    <td colspan="3" align='center'><strong>TOTAL</strong></td>
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
                          FROM (select c.* from 2019prestaciones c where c.codigo_prestacion in("25502201","25502202")) a
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

                    $nombre_descripcion = $row->codigo_prestacion;
                    if ($nombre_descripcion == "25502201"){
                        $nombre_descripcion = "TOTAL DÍAS ATENCIÓN OTORGADOS";
      							}
      							if ($nombre_descripcion == "25502202"){
                        $nombre_descripcion = "TOTAL COLECTAS MÓVILES REALIZADAS";
      							}
                    ?>
                <tr>
                    <td align="left" colspan="3" nowrap="nowrap"><?php echo $nombre_descripcion; ?></td>
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
                    <?php
                    $i++;
                }
                ?>
                </tr>
            </tbody>
        </table>
    </div>

    <br>

    <!-- SECCION A.2 -->
    <div class="col-sm tab table-responsive" id="A.2">
        <table class="table table-hover table-bordered table-sm">
            <thead>
                <tr>
                    <td colspan="26" class="active"><strong>SECCIÓN A.2: TIPO DE DONANTES RECHAZADOS.</strong></td>
                </tr>
                <tr>
                    <td rowspan="3" style="text-align:center; vertical-align:middle"><strong>DONANTES</strong></td>
                    <td colspan="2" rowspan="3" style="text-align:center; vertical-align:middle"><strong>DESCRIPCIÓN</strong></td>
                    <td colspan="3" rowspan="2" style="text-align:center; vertical-align:middle"><strong>TOTAL</strong></td>
                    <td colspan="20" align="center"><strong>POR EDAD</strong></td>
                </tr>
                <tr>
                    <td colspan="2" align="center"><strong>18-19</strong></td>
                    <td colspan="2" align="center"-><strong>20-24</strong></td>
                    <td colspan="2" align="center"><strong>25-29</strong></td>
                    <td colspan="2" align="center"><strong>30-34</strong></td>
                    <td colspan="2" align="center"><strong>35-39</strong></td>
                    <td colspan="2" align="center"><strong>40-44</strong></td>
                    <td colspan="2" align="center"><strong>45-49</strong></td>
                    <td colspan="2" align="center"><strong>50-54</strong></td>
                    <td colspan="2" align="center"><strong>55-59</strong></td>
                    <td colspan="2" align="center"><strong>60-64</strong></td>
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
                          FROM (select c.* from 2019prestaciones c where c.codigo_prestacion in("25100200","25400010","25100400","25400020","25100600","25400030")) a
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

                    $nombre_descripcion = $row->codigo_prestacion;
                    if ($nombre_descripcion == "25100200"){
                        $nombre_descripcion = "RECHAZADOS TRANSITORIOS";
      							}
      							if ($nombre_descripcion == "25400010"){
                        $nombre_descripcion = "RECHAZADOS PERMANENTES";
      							}

      							if ($nombre_descripcion == "25100400"){
                        $nombre_descripcion = "RECHAZADOS TRANSITORIOS";
      							}
      							if ($nombre_descripcion == "25400020"){
                        $nombre_descripcion = "RECHAZADOS PERMANENTES";
      							}

      							if ($nombre_descripcion == "25100600"){
                        $nombre_descripcion = "RECHAZADOS TRANSITORIOS";
      							}
      							if ($nombre_descripcion == "25400030"){
                        $nombre_descripcion = "RECHAZADOS PERMANENTES";
      							}
                    ?>
                <tr>
                    <?php
                    if($i==0){?>
                    <td rowspan="4" style="text-align:center; vertical-align:middle">ALTRUISTAS</td>
                    <td rowspan="2" style="text-align:center; vertical-align:middle">NUEVOS</td>
      							<?php
      							}
      							if($i==2){?>
                    <td rowspan="2" style="text-align:center; vertical-align:middle">REPETIDOS</td>
      							<?php
      							}
      							if($i==4){?>
                    <td rowspan="2" colspan="2" style="text-align:center; vertical-align:middle">FAMILIARES O REPOSICIÓN</td>
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
                    <?php
                    $i++;
                }
                ?>
                </tr>
                <tr>
                    <td colspan="3" align='center'><strong>TOTAL</strong></td>
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
                </tr>
            </tbody>
        </table>
    </div>

    <br>

    <div class="container">
    <!-- SECCION A.3 -->
    <div class="col-sm tab table-responsive" id="A.3">
        <table class="table table-hover table-bordered table-sm">
            <thead>
                <tr>
                    <td colspan="6" class="active"><strong>SECCIÓN A.3: REACCIONES ADVERSAS A LA DONACIÓN (CS - UMT - BS).</strong></td>
                </tr>
                <tr>
                    <td colspan="3" align="center"><strong>TIPO</strong></td>
                    <td align="center"><strong>TOTAL</strong></td>
                    <td align="center"><strong> ALTRUISTAS</strong></td>
                    <td align="center"><strong>REPOSICIÓN</strong></td>
                </tr>
            </thead>
            <tbody>
                <?php
                $query = 'SELECT a.codigo_prestacion,a.descripcion
                              ,sum(ifnull(b.Col01,0)) Col01
                              ,sum(ifnull(b.Col02,0)) Col02
                              ,sum(ifnull(b.Col03,0)) Col03
                          FROM (select c.* from 2019prestaciones c where c.codigo_prestacion in("25501000","25501100","25501200","25501300","25501400","25501500","25501600","25501700",
                                                                                                "25501800",
                                                                                                "25501900","25502000","25502100","25502200")) a
                          left join 2019rems b on (a.id_prestacion=b.prestacion_id_prestacion)
                          AND (b.Mes in ('.$mes.')) AND (b.establecimiento_id_establecimiento in ('.$estab.'))
                          group by a.codigo_prestacion, a.descripcion, a.id_prestacion
                          order by a.id_prestacion';
                $registro = DB::connection('mysql_rem')->select($query);

                $i=0;

                foreach($registro as $row ){
                    $nombre_descripcion = $row->codigo_prestacion;
                    if ($nombre_descripcion == "25501000"){
                        $nombre_descripcion = "HEMATOMA";
      							}
      							if ($nombre_descripcion == "25501100"){
                        $nombre_descripcion = "PUNCIÓN ARTERIAL";
      							}
      							if ($nombre_descripcion == "25501200"){
                        $nombre_descripcion = "SANGRAMIENTO POSTERIOR";
      							}
      							if ($nombre_descripcion == "25501300"){
                        $nombre_descripcion = "IRRITACIÓN DE UN NERVIO";
      							}
      							if ($nombre_descripcion == "25501400"){
                        $nombre_descripcion = "LESIÓN NERVIOSA";
      							}
      							if ($nombre_descripcion == "25501500"){
                        $nombre_descripcion = "LESIÓN DE TENDON";
      							}
      							if ($nombre_descripcion == "25501600"){
                        $nombre_descripcion = "BRAZO DOLOROSO";
      							}
      							if ($nombre_descripcion == "25501700"){
                        $nombre_descripcion = "TROMBOFLEBITIS";
      							}
      							if ($nombre_descripcion == "25501800"){
                        $nombre_descripcion = "ALERGIA LOCAL";
      							}
      							if ($nombre_descripcion == "25501900"){
                        $nombre_descripcion = "SIN LESION";
      							}
      							if ($nombre_descripcion == "25502000"){
                        $nombre_descripcion = "CON LESION";
      							}
      							if ($nombre_descripcion == "25502100"){
                        $nombre_descripcion = "SIN LESION";
      							}
      							if ($nombre_descripcion == "25502200"){
                        $nombre_descripcion = "CON LESION";
      							}
                    ?>
                <tr>
                    <?php
                    if($i==0){?>
								<td rowspan="9" style="text-align:center; vertical-align:middle">CON SÍNTOMAS LOCALES</td>
							<?php
							}
							if($i>=0 && $i<=8){?>
							  <td colspan="2" align="left" nowrap="nowrap"><?php echo $nombre_descripcion; ?></td>
							<?php
							}
							if($i==9){?>
								<td rowspan="4" style="text-align:center; vertical-align:middle">CON SÍNTOMAS GENERALES</td>
                              <td rowspan="2" style="text-align:center; vertical-align:middle">RVV INMEDIATA</td>
							<?php
							}
							if($i>=9 && $i<=10){?>
								<td align="left" nowrap="nowrap"><?php echo $nombre_descripcion; ?></td>
							<?php
							}
							if($i==11){?>
                                <td rowspan="2" style="text-align:center; vertical-align:middle">RVV TARDÍA</td>
							<?php
							}
							if($i>=11){?>
								<td align="left" nowrap="nowrap"><?php echo $nombre_descripcion; ?></td>
							<?php
							}?>

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
        <table class="table table-hover table-bordered table-sm">
            <thead>
                <tr>
                    <td colspan="2" class="active"><strong>SECCIÓN B: INGRESO UNIDADES DE SANGRE A PRODUCIÓN (CS-BS).</strong></td>
                </tr>
                <tr>
                    <td align="center"><strong>UNIDADES DE SANGRE</strong></td>
                    <td align="center"><strong>TOTAL</strong></td>
                </tr>
            </thead>
            <tbody>
                <?php
                $query = 'SELECT a.codigo_prestacion,a.descripcion
                              ,sum(ifnull(b.Col01,0)) Col01
                          FROM (select c.* from 2019prestaciones c where c.codigo_prestacion in("25100700","25100800")) a
                          left join 2019rems b on (a.id_prestacion=b.prestacion_id_prestacion)
                          AND (b.Mes in ('.$mes.')) AND (b.establecimiento_id_establecimiento in ('.$estab.'))
                          group by a.codigo_prestacion, a.descripcion, a.id_prestacion
                          order by a.id_prestacion';
                $registro = DB::connection('mysql_rem')->select($query);

                $i=0;

                $totalCol01=0;

                foreach($registro as $row ){
                    $totalCol01=$totalCol01+$row->Col01;
                    $nombre_descripcion = $row->codigo_prestacion;
                    if ($nombre_descripcion == "25100700"){
                        $nombre_descripcion = "APTAS";
      							}
      							if ($nombre_descripcion == "25100800"){
                        $nombre_descripcion = "NO APTAS";
      							}
                    ?>
                <tr>
                    <td align="left" nowrap="nowrap"><?php echo $nombre_descripcion; ?></td>
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

    <!-- SECCION C -->
    <div class="col-sm tab table-responsive" id="C">
        <table class="table table-hover table-bordered table-sm">
            <thead>
                <tr>
                    <td colspan="3" class="active"><strong>SECCIÓN C: PRODUCCIÓN DE COMPONENTES SANGUÍNEOS (CS-BS).</strong></td>
                </tr>
                <tr>
                    <td align="center"><strong>PRODUCCIÓN</strong></td>
                    <td align="center"><strong>DESCRIPCIÓN</strong></td>
                    <td align="center"><strong>TOTAL</strong></td>
                </tr>
            </thead>
            <tbody>
                <?php
                $query = 'SELECT a.codigo_prestacion,a.descripcion
                              ,sum(ifnull(b.Col01,0)) Col01
                          FROM (select c.* from 2019prestaciones c where c.codigo_prestacion in("25400080","25400090","25400100",
                                                                                                "25400110","25400122","25400124","25400130",
                                                                                                "25400140","25400150",
                                                                                                "25400160")) a
                          left join 2019rems b on (a.id_prestacion=b.prestacion_id_prestacion)
                          AND (b.Mes in ('.$mes.')) AND (b.establecimiento_id_establecimiento in ('.$estab.'))
                          group by a.codigo_prestacion, a.descripcion, a.id_prestacion
                          order by a.id_prestacion';
                $registro = DB::connection('mysql_rem')->select($query);

                $i=0;

                $totalCol01=0;

                foreach($registro as $row ){
                    $nombre_descripcion = $row->codigo_prestacion;
                    if ($nombre_descripcion == "25400080"){
                        $nombre_descripcion = "DESPLAMATIZADOS";
      							}
      							if ($nombre_descripcion == "25400090"){
                        $nombre_descripcion = "LEUCOREDUCIDOS";
      							}
      							if ($nombre_descripcion == "25400100"){
                        $nombre_descripcion = "FILTRADOS";
      							}

                    if ($nombre_descripcion == "25400110"){
                        $nombre_descripcion = "ESTÁNDAR";
      							}
      							if ($nombre_descripcion == "25400122"){
                        $nombre_descripcion = "LEUCORREDUCIDA POOL";
      							}
      							if ($nombre_descripcion == "25400124"){
                        $nombre_descripcion = "LEUCODEPLATEADA POOL";
      							}
      							if ($nombre_descripcion == "25400130"){
                        $nombre_descripcion = "AFERESIS";
      							}

                    if ($nombre_descripcion == "25400140"){
                        $nombre_descripcion = "PLASMA FRESCO CONGELADO TERAPÉUTICO";
      							}
      							if ($nombre_descripcion == "25400150"){
                        $nombre_descripcion = "PLASMA USO NO TERAPÉUTICO";
      							}

      							if ($nombre_descripcion == "25400160"){
                        $nombre_descripcion = "CRIOPRECIPITADOS";
      							}


                    ?>
                <tr>
                  <?php
                    if($i==0){?>
                    <td rowspan="3" style="text-align:center; vertical-align:middle">GLÓBULOS ROJOS</td>
                    <?php
                    }
                    if($i>=0 && $i<=2){?>
                    <td align="left" nowrap="nowrap"><?php echo $nombre_descripcion; ?></td>
                    <?php
                    }
                    if($i==3){?>
                    <td rowspan="4" style="text-align:center; vertical-align:middle">PLAQUETAS</td>
                    <?php
                    }
                    if($i>=3 && $i<=6){?>
                    <td align="left" nowrap="nowrap"><?php echo $nombre_descripcion; ?></td>
                    <?php
                    }
                    if($i==7){?>
                    <td rowspan="2" style="text-align:center; vertical-align:middle">PLASMAS</td>
                    <?php
                    }
                    if($i>=7 && $i<=8){?>
                    <td align="left" nowrap="nowrap"><?php echo $nombre_descripcion; ?></td>
                    <?php
                    }
                    if($i==9){?>
                    <td colspan="2" align="left" nowrap="nowrap"><?php echo $nombre_descripcion; ?></td>
                    <?php
                    }
                    ?>
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

    <!-- SECCION C.1 -->
    <div class="col-sm tab table-responsive" id="A.2">
        <table class="table table-hover table-bordered table-sm">
            <thead>
                <tr>
                    <td colspan="7" class="active"><strong>SECCIÓN C.1: COMPONENTES SANGUÍNEOS ELIMINADOS (CS-BS).</strong></td>
                </tr>
                <tr>
                    <td rowspan="2" style="text-align:center; vertical-align:middle"><strong>CAUSA</strong></td>
                    <td rowspan="2" style="text-align:center; vertical-align:middle"><strong>GLOBULOS ROJOS*</strong></td>
                    <td rowspan="2" style="text-align:center; vertical-align:middle"><strong>PLASMAS*</strong></td>
                    <td colspan="3" align="center"><strong>PLAQUETAS</strong></td>
                    <td rowspan="2" align="center"><strong>CRIOPRECIPITADOS</strong></td>
                </tr>
                <tr>
                    <td align="center"><strong>Estándar</strong></td>
                    <td align="center"><strong>Pool*</strong></td>
                    <td align="center"><strong>Aféresis</strong></td>
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
                          FROM (select c.* from 2019prestaciones c where c.codigo_prestacion in("25400170","25400190","25505000")) a
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

                foreach($registro as $row ){
                    $totalCol01=$totalCol01+$row->Col01;
                    $totalCol02=$totalCol02+$row->Col02;
                    $totalCol03=$totalCol03+$row->Col03;
                    $totalCol04=$totalCol04+$row->Col04;
                    $totalCol05=$totalCol05+$row->Col05;
                    $totalCol06=$totalCol06+$row->Col06;

                    $nombre_descripcion = $row->codigo_prestacion;
                    if ($nombre_descripcion == "25400170"){
                        $nombre_descripcion = "CALIFICACION MICROBIOLOGICA REACTIVA";
      							}
      							if ($nombre_descripcion == "25400190"){
                        $nombre_descripcion = "OBSOLESCENCIA";
      							}
      							if ($nombre_descripcion == "25505000"){
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
                </tr>
                <tr>
                    <td colspan="7" align='left'>* Cualquier tipo</td>
                </tr>
            </tbody>
        </table>
    </div>

    <br>

    <!-- SECCION C.2 -->
    <div class="col-sm tab table-responsive" id="C.2">
        <table class="table table-hover table-bordered table-sm">
            <thead>
                <tr>
                    <td colspan="7" class="active"><strong>SECCIÓN C.2: COMPONENTES SANGUÍNEOS ELIMINADOS O DEVUELTOS AL CENTRO DE SANGRE (UMT).</strong></td>
                </tr>
                <tr>
                    <td rowspan="2" style="text-align:center; vertical-align:middle"><strong>CAUSA</strong></td>
                    <td rowspan="2" style="text-align:center; vertical-align:middle"><strong>GLOBULOS ROJOS*</strong></td>
                    <td rowspan="2" style="text-align:center; vertical-align:middle"><strong>PLASMAS*</strong></td>
                    <td colspan="3" align="center"><strong>PLAQUETAS</strong></td>
                    <td rowspan="2" align="center"><strong>CRIOPRECIPITADOS</strong></td>
                </tr>
                <tr>
                    <td align="center"><strong>Estándar</strong></td>
                    <td align="center"><strong>Pool*</strong></td>
                    <td align="center"><strong>Aféresis</strong></td>
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
                          FROM (select c.* from 2019prestaciones c where c.codigo_prestacion in("25502200A","25502300","25502400","25502500","25502600")) a
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

                foreach($registro as $row ){
                    $totalCol01=$totalCol01+$row->Col01;
                    $totalCol02=$totalCol02+$row->Col02;
                    $totalCol03=$totalCol03+$row->Col03;
                    $totalCol04=$totalCol04+$row->Col04;
                    $totalCol05=$totalCol05+$row->Col05;
                    $totalCol06=$totalCol06+$row->Col06;

                    $nombre_descripcion = $row->codigo_prestacion;
                    if ($nombre_descripcion == "25502200A"){
                        $nombre_descripcion = "OBSOLESCENCIA";
      							}
      							if ($nombre_descripcion == "25502300"){
                        $nombre_descripcion = "FALTA POR CADENA DE FRIO";
      							}
      							if ($nombre_descripcion == "25502400"){
                        $nombre_descripcion = "DEVOLUCIONES POR PRODUCTO POR NO CUMPLIR ESTANDAR";
      							}
      							if ($nombre_descripcion == "25502500"){
                        $nombre_descripcion = "DESCONGELAMIENTO SIN USO";
      							}
      							if ($nombre_descripcion == "25502600"){
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
                </tr>
                <tr>
                    <td colspan="7" align='left'>* Cualquier tipo</td>
                </tr>
            </tbody>
        </table>
    </div>

    <br>

    <!-- SECCION C.3 -->
    <div class="col-sm tab table-responsive" id="C.3">
        <table class="table table-hover table-bordered table-sm">
            <thead>
                <tr>
                    <td colspan="8" class="active"><strong>SECCIÓN C.3: COMPONENTES SANGUÍNEOS TRANSFORMACIONES (CS-BS-UMT).</strong></td>
                </tr>
                <tr>
                    <td colspan="2" align="center" width="25%"><strong>COMPONENTES</strong></td>
                    <td align="center" width="12%"><strong>TOTAL</strong></td>
                    <td align="center"><strong>UNIDADES PEDIÁTRICAS</strong></td>
                    <td align="center"><strong>IRRADIACIÓN</strong></td>
                    <td align="center" width="12%"><strong>RECONSTITUCIÓN PARA USO PEDIÁTRICO (RECAMBIO)</strong></td>
                    <td align="center" width="12%"><strong>REDUCCIÓN VOLUMEN</strong></td>
                    <td align="center"><strong>DESPLASMATIZACIÓN</strong></td>
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
                          FROM (select c.* from 2019prestaciones c where c.codigo_prestacion in("25502700",
                                                                                                "25502800","25502900","25503000",
                                                                                                "25503100","25503200")) a
                          left join 2019rems b on (a.id_prestacion=b.prestacion_id_prestacion)
                          AND (b.Mes in ('.$mes.')) AND (b.establecimiento_id_establecimiento in ('.$estab.'))
                          group by a.codigo_prestacion, a.descripcion, a.id_prestacion
                          order by a.id_prestacion';
                $registro = DB::connection('mysql_rem')->select($query);

                $i=0;

                foreach($registro as $row ){
                    $nombre_descripcion = $row->codigo_prestacion;
                    if ($nombre_descripcion == "25502700"){
      								$nombre_descripcion = "GLOBULOS ROJOS *";
      							}
      							if ($nombre_descripcion == "25502800"){
      								$nombre_descripcion = "ESTANDAR";
      							}
      							if ($nombre_descripcion == "25502900"){
      								$nombre_descripcion = "POOL *";
      							}
      							if ($nombre_descripcion == "25503000"){
      								$nombre_descripcion = "AFERESIS";
      							}
      							if ($nombre_descripcion == "25503100"){
      								$nombre_descripcion = "PLASMAS *";
      							}
      							if ($nombre_descripcion == "25503200"){
      								$nombre_descripcion = "CRIOPRECIPITADOS";
      							}
                    ?>
                <tr>
                    <?php
                    if($i==0){?>
                    <td colspan="2" align="left" nowrap="nowrap"><?php echo $nombre_descripcion; ?></td>
                    <?php
                    }
                    if($i==1){?>
                    <td rowspan="3" style="text-align:center; vertical-align:middle">PLAQUETAS</td>
                    <?php
                    }
                    if($i>=1 && $i<=3){?>
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
                    <td align='right'><?php echo number_format($row->Col05,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col06,0,",",".")?></td>
                    <?php
                    $i++;
                }
                ?>
                </tr>
                <tr>
                    <td colspan="8" align='left'>* Cualquier tipo</td>
                </tr>
            </tbody>
        </table>
    </div>

    <br>

    <!-- SECCION C.4 -->
    <div class="col-sm tab table-responsive" id="C.4">
        <table class="table table-hover table-bordered table-sm">
            <thead>
                <tr>
                    <td colspan="3" class="active"><strong>SECCIÓN C.4: COMPONENTES SANGUÍNEOS DISTRIBUÍBLES (CS).</strong></td>
                </tr>
                <tr>
                    <td colspan="2" align="center"><strong>CAUSA</strong></td>
                    <td align="center"><strong>TOTAL</strong></td>
                </tr>
            </thead>
            <tbody>
                <?php
                $query = 'SELECT a.codigo_prestacion,a.descripcion
                              ,sum(ifnull(b.Col01,0)) Col01
                          FROM (select c.* from 2019prestaciones c where c.codigo_prestacion in("25503300",
                                                                                                "25503400","25503500","25503600",
                                                                                                "25503700","25503800")) a
                          left join 2019rems b on (a.id_prestacion=b.prestacion_id_prestacion)
                          AND (b.Mes in ('.$mes.')) AND (b.establecimiento_id_establecimiento in ('.$estab.'))
                          group by a.codigo_prestacion, a.descripcion, a.id_prestacion
                          order by a.id_prestacion';
                $registro = DB::connection('mysql_rem')->select($query);

                $i=0;

                foreach($registro as $row ){
                    $nombre_descripcion = $row->codigo_prestacion;
                    if ($nombre_descripcion == "25503300"){
                        $nombre_descripcion = "GLOBULOS ROJOS *";
      							}
      							if ($nombre_descripcion == "25503400"){
                        $nombre_descripcion = "ESTANDAR";
      							}
      							if ($nombre_descripcion == "25503500"){
                        $nombre_descripcion = "POOL *";
      							}
      							if ($nombre_descripcion == "25503600"){
                        $nombre_descripcion = "EFERESIS";
      							}
      							if ($nombre_descripcion == "25503700"){
                        $nombre_descripcion = "PLASMAS *";
      							}
      							if ($nombre_descripcion == "25503800"){
                        $nombre_descripcion = "CRIOPRECIPITADOS";
      							}
                    ?>
                <tr>
                    <?php
                    if($i==0){?>
                    <td colspan="2" align="left" nowrap="nowrap"><?php echo $nombre_descripcion; ?></td>
                    <?php
                    }
                    if($i==1){?>
                    <td rowspan="3" style="text-align:center; vertical-align:middle">PLAQUETAS</td>
                    <?php
                    }
                    if($i>=1 && $i<=3){?>
                    <td align="left" nowrap="nowrap"><?php echo $nombre_descripcion; ?></td>
                    <?php
                    }
                    if($i>=4){?>
                    <td colspan="2" align="left" nowrap="nowrap"><?php echo $nombre_descripcion; ?></td>
                    <?php
                    }
                    ?>
                    <td align='right'><?php echo number_format($row->Col01,0,",",".")?></td>
                    <?php
                    $i++;
                }
                ?>
                </tr>
                <tr>
                    <td colspan="3" align='left'>* Cualquier tipo</td>
                </tr>
            </tbody>
        </table>
    </div>

    <br>

    <!-- SECCION C.5 -->
    <div class="col-sm tab table-responsive" id="C.5">
        <table class="table table-hover table-bordered table-sm">
            <thead>
                <tr>
                    <td colspan="2" class="active"><strong>SECCIÓN C.5: SATISFACCION STOCK (7 DÍAS) CS.</strong></td>
                </tr>
                <tr>
                    <td align="center"><strong>GR</strong></td>
                    <td align="center"><strong>NÚMERO DÍAS BAJO STOCK ÓPTIMO</strong></td>
                </tr>
            </thead>
            <tbody>
                <?php
                $query = 'SELECT a.codigo_prestacion,a.descripcion
                              ,sum(ifnull(b.Col01,0)) Col01
                          FROM (select c.* from 2019prestaciones c where c.codigo_prestacion in("25503900","25504000","25504100","25504200","25504300")) a
                          left join 2019rems b on (a.id_prestacion=b.prestacion_id_prestacion)
                          AND (b.Mes in ('.$mes.')) AND (b.establecimiento_id_establecimiento in ('.$estab.'))
                          group by a.codigo_prestacion, a.descripcion, a.id_prestacion
                          order by a.id_prestacion';
                $registro = DB::connection('mysql_rem')->select($query);

                $i=0;

                foreach($registro as $row ){
                    $nombre_descripcion = $row->codigo_prestacion;
                    if ($nombre_descripcion == "25503900"){
                        $nombre_descripcion = "O+";
      							}
      							if ($nombre_descripcion == "25504000"){
                        $nombre_descripcion = "A+";
      							}
      							if ($nombre_descripcion == "25504100"){
                        $nombre_descripcion = "B+";
      							}
      							if ($nombre_descripcion == "25504200"){
                        $nombre_descripcion = "O(-)";
      							}
      							if ($nombre_descripcion == "25504300"){
                        $nombre_descripcion = "A(-)";
      							}
                    ?>
                <tr>
                    <td align="left" nowrap="nowrap"><?php echo $nombre_descripcion; ?></td>
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

    <!-- SECCION C.6 -->
    <div class="col-sm tab table-responsive" id="C.6">
        <table class="table table-hover table-bordered table-sm">
            <thead>
                <tr>
                    <td colspan="2" class="active"><strong>SECCIÓN C.6: SATISFACCION STOCK CRITICO (3 DÍAS) UMT.</strong></td>
                </tr>
                <tr>
                    <td align="center"><strong>GR</strong></td>
                    <td align="center"><strong>NÚMERO DÍAS BAJO STOCK ÓPTIMO</strong></td>
                </tr>
            </thead>
            <tbody>
                <?php
                $query = 'SELECT a.codigo_prestacion,a.descripcion
                              ,sum(ifnull(b.Col01,0)) Col01
                          FROM (select c.* from 2019prestaciones c where c.codigo_prestacion in("25504400","25504500","25504600","25504700","25504800")) a
                          left join 2019rems b on (a.id_prestacion=b.prestacion_id_prestacion)
                          AND (b.Mes in ('.$mes.')) AND (b.establecimiento_id_establecimiento in ('.$estab.'))
                          group by a.codigo_prestacion, a.descripcion, a.id_prestacion
                          order by a.id_prestacion';
                $registro = DB::connection('mysql_rem')->select($query);

                $i=0;

                foreach($registro as $row ){
                    $nombre_descripcion = $row->codigo_prestacion;
                    if ($nombre_descripcion == "25504400"){
                        $nombre_descripcion = "O+";
      							}
      							if ($nombre_descripcion == "25504500"){
                        $nombre_descripcion = "A+";
      							}
      							if ($nombre_descripcion == "25504600"){
                        $nombre_descripcion = "B+";
      							}
      							if ($nombre_descripcion == "25504700"){
                        $nombre_descripcion = "O(-)";
      							}
      							if ($nombre_descripcion == "25504800"){
                        $nombre_descripcion = "A(-)";
      							}
                    ?>
                <tr>
                    <td align="left" nowrap="nowrap"><?php echo $nombre_descripcion; ?></td>
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

    <!-- SECCION D -->
    <div class="col-sm tab table-responsive" id="D">
        <table class="table table-hover table-bordered table-sm">
            <thead>
                <tr>
                    <td colspan="6" class="active"><strong>SECCIÓN D: COMPONENTES SANGUINEOS DISTRIBUIDOS (CS) O TRANSFERIDOS (BS Y UMT).</strong></td>
                </tr>
                <tr>
                    <td colspan="2" align="center"><strong>DESCRIPCIÓN</strong></td>
                    <td align="center"><strong>TOTAL</strong></td>
                    <td align="center"><strong>PÚBLICO</strong></td>
                    <td align="center"><strong>PRIVADO**</strong></td>
                    <td align="center"><strong>F.F.A.A.</strong></td>
                </tr>
            </thead>
            <tbody>
                <?php
                $query = 'SELECT a.codigo_prestacion,a.descripcion
                              ,sum(ifnull(b.Col01,0)) Col01
                              ,sum(ifnull(b.Col02,0)) Col02
                              ,sum(ifnull(b.Col03,0)) Col03
                              ,sum(ifnull(b.Col04,0)) Col04
                          FROM (select c.* from 2019prestaciones c where c.codigo_prestacion in("25400270",
                                                                                                "25400280","25400290","25400300",
                                                                                                "25400322","25400330")) a
                          left join 2019rems b on (a.id_prestacion=b.prestacion_id_prestacion)
                          AND (b.Mes in ('.$mes.')) AND (b.establecimiento_id_establecimiento in ('.$estab.'))
                          group by a.codigo_prestacion, a.descripcion, a.id_prestacion
                          order by a.id_prestacion';
                $registro = DB::connection('mysql_rem')->select($query);

                $i=0;

                foreach($registro as $row ){
                    $nombre_descripcion = $row->codigo_prestacion;
                    if ($nombre_descripcion == "25400270"){
                        $nombre_descripcion = "GLOBULOS ROJOS";
      							}

      							if ($nombre_descripcion == "25400280"){
                        $nombre_descripcion = "ESTÁNDAR";
      							}
      							if ($nombre_descripcion == "25400290"){
                        $nombre_descripcion = "POOL*";
      							}
      							if ($nombre_descripcion == "25400300"){
                        $nombre_descripcion = "AFERESIS";
      							}

      							if ($nombre_descripcion == "25400322"){
                        $nombre_descripcion = "PLASMAS";
      							}
      							if ($nombre_descripcion == "25400330"){
                        $nombre_descripcion = "CRIOPRECIPITADOS";
      							}
                    ?>
                <tr>
                    <?php
                    if($i==0){?>
                    <td colspan="2" align="left" nowrap="nowrap"><?php echo $nombre_descripcion; ?></td>
                    <?php
                    }
                    if($i==1){?>
                    <td rowspan="3" style="text-align:center; vertical-align:middle">PLAQUETAS</td>
                    <?php
                    }
                    if($i>=1 && $i<=3){?>
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
                <tr>
                    <td colspan="6" align='left'>* Cualquier tipo <br>
                                                  **Universitarios, Clínicas Privadas, Otros
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <br>

    <!-- SECCION D.1 -->
    <div class="col-sm tab table-responsive" id="D.1">
        <table class="table table-hover table-bordered table-sm">
            <thead>
                <tr>
                    <td colspan="7" class="active"><strong>SECCIÓN D.1: TRANSFUSIONES (UMT - BS).</strong></td>
                </tr>
                <tr>
                    <td colspan="2" rowspan="2" style="text-align:center; vertical-align:middle"><strong>TRANSFUSIONES (Nº DE UNIDADES)</strong></td>
                    <td rowspan="2" style="text-align:center; vertical-align:middle"><strong>TOTAL</strong></td>
                    <td colspan="2" align="center"><strong>MENORES DE 15 AÑOS</strong></td>
                    <td colspan="2" align="center"><strong>DE 15 Y MAS AÑOS</strong></td>
                </tr>
                <tr>
                    <td align="center"><strong>Normales</strong></td>
                    <td align="center"><strong>Irradiados</strong></td>
                    <td align="center"><strong>Normales</strong></td>
                    <td align="center"><strong>Irradiados</strong></td>
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
                          FROM (select c.* from 2019prestaciones c where c.codigo_prestacion in("25200500",
                                                                                                "25200600","25400340","25400350",
                                                                                                "25400362","25200700")) a
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

                foreach($registro as $row ){
                    $totalCol01=$totalCol01+$row->Col01;
                    $totalCol02=$totalCol02+$row->Col02;
                    $totalCol03=$totalCol03+$row->Col03;
                    $totalCol04=$totalCol04+$row->Col04;
                    $totalCol05=$totalCol05+$row->Col05;

                    $nombre_descripcion = $row->codigo_prestacion;
                    if ($nombre_descripcion == "25200500"){
      								$nombre_descripcion = "GLOBULOS ROJOS";
      							}

      							if ($nombre_descripcion == "25200600"){
      								$nombre_descripcion = "ESTÁNDAR";
      							}
      							if ($nombre_descripcion == "25400340"){
      								$nombre_descripcion = "POOL*";
      							}
      							if ($nombre_descripcion == "25400350"){
      								$nombre_descripcion = "AFERESIS";
      							}

      							if ($nombre_descripcion == "25400362"){
      								$nombre_descripcion = "PLASMAS";
      							}
      							if ($nombre_descripcion == "25200700"){
      								$nombre_descripcion = "CRIOPRECIPITADOS";
      							}
                    ?>
                <tr>
                    <?php
                    if($i==0){?>
                    <td colspan="2" align="left" nowrap="nowrap"><?php echo $nombre_descripcion; ?></td>
                    <?php
                    }
                    if($i==1){?>
                    <td rowspan="3" style="text-align:center; vertical-align:middle">PLAQUETAS</td>
                    <?php
                    }
                    if($i>=1 && $i<=3){?>
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
                    <td align='right'><?php echo number_format($row->Col05,0,",",".")?></td>
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
                    <td colspan="3" class="active"><strong>SECCIÓN E: DEMANDA GLÓBULOS ROJOS PARA TRANSFUSIÓN (UMT-BS).</strong></td>
                </tr>
                <tr>
                    <td colspan="2" align="center"><strong>TIPO</strong></td>
                    <td align="center"><strong>TOTAL</strong></td>
                </tr>
            </thead>
            <tbody>
                <?php
                $query = 'SELECT a.codigo_prestacion,a.descripcion
                              ,sum(ifnull(b.Col01,0)) Col01
                          FROM (select c.* from 2019prestaciones c where c.codigo_prestacion in("25200900","25300100")) a
                          left join 2019rems b on (a.id_prestacion=b.prestacion_id_prestacion)
                          AND (b.Mes in ('.$mes.')) AND (b.establecimiento_id_establecimiento in ('.$estab.'))
                          group by a.codigo_prestacion, a.descripcion, a.id_prestacion
                          order by a.id_prestacion';
                $registro = DB::connection('mysql_rem')->select($query);

                $i=0;

                foreach($registro as $row ){
                    $nombre_descripcion = $row->codigo_prestacion;
                    if ($nombre_descripcion == "25200900"){
                        $nombre_descripcion = "SOLICITADAS";
      							}
      							if ($nombre_descripcion == "25300100"){
                        $nombre_descripcion = "DESPACHADAS";
      							}
                    ?>
                <tr>
                    <?php
                    if($i==0){?>
                    <td rowspan="2" style="text-align:center; vertical-align:middle">PLAQUETAS</td>
                    <?php
                    }?>
                    <td align="left" nowrap="nowrap"><?php echo $nombre_descripcion; ?></td>
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
                    <td colspan="5" class="active"><strong>SECCIÓN F: REACCIONES ADVERSAS POR ACTO* TRANSFUSIONAL (UMT-BS).</strong></td>
                </tr>
                <tr>
                    <td align="center"><strong>TIPO</strong></td>
                    <td align="center"><strong>TOTAL</strong></td>
                    <td align="center"><strong>GLÓBULOS ROJOS</strong></td>
                    <td align="center"><strong>PLASMAS</strong></td>
                    <td align="center"><strong>PLAQUETAS</strong></td>
                </tr>
            </thead>
            <tbody>
                <?php
                $query = 'SELECT a.codigo_prestacion,a.descripcion
                              ,sum(ifnull(b.Col01,0)) Col01
                              ,sum(ifnull(b.Col02,0)) Col02
                              ,sum(ifnull(b.Col03,0)) Col03
                              ,sum(ifnull(b.Col04,0)) Col04
                          FROM (select c.* from 2019prestaciones c where c.codigo_prestacion in("25400370","25400380","25400390","25400400","25400410","25400420","25400430","25400440",
                                                                                                "25400450","25400460")) a
                          left join 2019rems b on (a.id_prestacion=b.prestacion_id_prestacion)
                          AND (b.Mes in ('.$mes.')) AND (b.establecimiento_id_establecimiento in ('.$estab.'))
                          group by a.codigo_prestacion, a.descripcion, a.id_prestacion
                          order by a.id_prestacion';
                $registro = DB::connection('mysql_rem')->select($query);

                $i=0;

                foreach($registro as $row ){
                    $nombre_descripcion = $row->codigo_prestacion;
                    if ($nombre_descripcion == "25400370"){
                        $nombre_descripcion = "RASH ALLERGICO";
      							}

      							if ($nombre_descripcion == "25400380"){
                        $nombre_descripcion = "ANAFILAXIA";
      							}
      							if ($nombre_descripcion == "25400390"){
                        $nombre_descripcion = "REACCIONS FEBRIL NO HEMOLITICA";
      							}
      							if ($nombre_descripcion == "25400400"){
                        $nombre_descripcion = "REACCION  HEMOLITICA AGUDA POR INCOMPATIBILIDAD ABO";
      							}
      							if ($nombre_descripcion == "25400410"){
                        $nombre_descripcion = "REACCION  HEMOLITICA AGUDA POR OTRA CAUSA";
      							}

      							if ($nombre_descripcion == "25400420"){
                        $nombre_descripcion = "SOBRECARGA CIRCULATORIA";
      							}
      							if ($nombre_descripcion == "25400430"){
                        $nombre_descripcion = "REACCION HEMOLOTICA TARDIA";
      							}

      							if ($nombre_descripcion == "25400440"){
                        $nombre_descripcion = "SEPTICEMIA";
      							}
      							if ($nombre_descripcion == "25400450"){
                        $nombre_descripcion = "TRALI";
      							}

      							if ($nombre_descripcion == "25400460"){
                        $nombre_descripcion = "OTRAS";
      							}
                    ?>
                <tr>
                    <td align="left" nowrap="nowrap"><?php echo $nombre_descripcion; ?></td>
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
                    <td colspan="5" align="left">* Cada vez que el paciente se transfunde.</td>
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
