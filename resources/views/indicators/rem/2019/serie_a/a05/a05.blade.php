@extends('layouts.app')

@section('title', 'Resumen Estadistico Mensual')

@section('content')

<?php

use Illuminate\Support\Facades\DB;

?>

@include('indicators.rem.partials.nav')

<h3>REM-A05. INGRESOS Y EGRESOS POR CONDICIÓN Y PROBLEMAS DE SALUD.</h3>

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
                    <td colspan="15" class="active"><strong>SECCIÓN A: CONSULTAS MÉDICAS.</strong></td>
                </tr>
                <tr>
                    <td rowspan='2' style="text-align:center; vertical-align:middle"><strong>CONDICIÓN</strong></td>
                    <td rowspan='2' style="text-align:center; vertical-align:middle" width="7%"><strong>TOTAL</strong></td>
                    <td colspan='10' align='center'><strong>POR EDAD (en años)</strong></td>
                    <td rowspan='2' style="text-align:center; vertical-align:middle" width="10%"><strong>VÍCTIMA DE VIOLENCIA DE GENERO</strong></td>
                    <td rowspan='2' style="text-align:center; vertical-align:middle" width="10%"><strong>PUEBLOS ORIGINARIOS</strong></td>
                    <td rowspan='2' style="text-align:center; vertical-align:middle" width="5%"><strong>MIGRANTES</strong></td>
                </tr>
                <tr>
                    <td align='center'><strong>Menor de 15</strong></td>
                    <td align='center'><strong>15 - 19</strong></td>
                    <td align='center'><strong>20 - 24</strong></td>
                    <td align='center'><strong>25 - 29</strong></td>
                    <td align='center'><strong>30 - 34</strong></td>
                    <td align='center'><strong>35 - 39</strong></td>
                    <td align='center'><strong>40 - 44</strong></td>
                    <td align='center'><strong>45 - 49</strong></td>
                    <td align='center'><strong>50 - 54</strong></td>
                    <td align='center'><strong>55 y Más</strong></td>
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
                          FROM (select c.* from 2019prestaciones c where c.codigo_prestacion in("01080008","01080010","01080009","01090050","05050100")) a
                          left join 2019rems b on (a.id_prestacion=b.prestacion_id_prestacion)
                          AND (b.Mes in ('.$mes.')) AND (b.establecimiento_id_establecimiento in ('.$estab.'))
                          group by a.codigo_prestacion, a.descripcion, a.id_prestacion
                          order by a.id_prestacion';
                $registro = DB::connection('mysql_rem')->select($query);

                $i=0;

                foreach($registro as $row ){

                    $nombre_descripcion = $row->codigo_prestacion;
                    if ($nombre_descripcion == "01080008"){
                        $nombre_descripcion = "GESTANTES INGRESADAS";
      							}
                    if ($nombre_descripcion == "01080010"){
                        $nombre_descripcion = "PRIMIGESTAS INGRESADAS";
      							}
                    if ($nombre_descripcion == "01080009"){
                        $nombre_descripcion = "GESTANTES INGRESADAS ANTES DE LAS 14 SEMANAS";
      							}
                    if ($nombre_descripcion == "01090050"){
                        $nombre_descripcion = "GESTANTES CON EMBARAZO NO PLANIFICADO";
      							}
                    if ($nombre_descripcion == "05050100"){
                        $nombre_descripcion = "GESTANTES CON EXAMEN DE CHAGAS INFORMADO	";
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
    <!-- SECCION B -->
    <div class="col-sm tab table-responsive" id="B">
        <table class="table table-hover table-bordered table-sm">
            <thead>
                <tr>
                    <td colspan="5" class="active"><strong>SECCIÓN B: INGRESO DE GESTANTES CON PATOLOGÍA DE ALTO RIESGO OBSTÉTRICO A LA UNIDAD DE ARO (Nivel Secundario).</strong></td>
                </tr>
                <tr>
                    <td align='center'><strong>PATOLOGÍA</strong></td>
                    <td align='center'><strong>Nº DE INGRESOS A ARO</strong></td>
                    <td align='center'><strong>VÍCTIMA DE VIOLENCIA DE GENERO</strong></td>
                    <td align='center'><strong>PUEBLOS ORIGINARIOS</strong></td>
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
                          FROM (select c.* from 2019prestaciones c where c.codigo_prestacion in("05810010","01090040","05810020","24100700","01080017","24090050","24090060","01080018",
                                                                                                "01080019","05810030","24100800")) a
                          left join 2019rems b on (a.id_prestacion=b.prestacion_id_prestacion)
                          AND (b.Mes in ('.$mes.')) AND (b.establecimiento_id_establecimiento in ('.$estab.'))
                          group by a.codigo_prestacion, a.descripcion, a.id_prestacion
                          order by a.id_prestacion';
                $registro = DB::connection('mysql_rem')->select($query);

                $i=0;

                foreach($registro as $row ){

                    $nombre_descripcion = $row->codigo_prestacion;
                    if ($nombre_descripcion == "05810010"){
                        $nombre_descripcion = "Nº DE GESTANTES INGRESADAS";
      							}
                    if ($nombre_descripcion == "01090040"){
                        $nombre_descripcion = "PREECLAMPSIA (PE)";
      							}
                    if ($nombre_descripcion == "05810020"){
                        $nombre_descripcion = "SÍNDROME HIPERTENSIVO DEL EMBARAZO (SHE)";
      							}
                    if ($nombre_descripcion == "24100700"){
                        $nombre_descripcion = "FACTORES DE RIESGO Y CONDICIONANTES DE PARTO PREMATURO";
      							}
                    if ($nombre_descripcion == "01080017"){
                        $nombre_descripcion = "RETARDO CRECIMIENTO INTRAUTERINO (RCIU)";
      							}
                    if ($nombre_descripcion == "24090050"){
                        $nombre_descripcion = "SÍFILIS";
      							}
                    if ($nombre_descripcion == "24090060"){
                        $nombre_descripcion = "VIH";
      							}
                    if ($nombre_descripcion == "01080018"){
                        $nombre_descripcion = "DIABETES";
      							}
                    if ($nombre_descripcion == "01080019"){
                        $nombre_descripcion = "CESÁREA ANTERIOR";
      							}
                    if ($nombre_descripcion == "05810030"){
                        $nombre_descripcion = "MALFORMACIÓN CONGÉNITA";
      							}
                    if ($nombre_descripcion == "24100800"){
                        $nombre_descripcion = "OTRAS PATOLOGÍAS DEL EMBARAZO";
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
    </div>

    <br>

    <!-- SECCION C -->
    <div class="col-sm tab table-responsive" id="C">
        <table class="table table-hover table-bordered table-sm">
            <thead>
                <tr>
                    <td colspan="14" class="active"><strong>SECCIÓN C: INGRESOS A PROGRAMA DE REGULACIÓN DE FERTILIDAD, SEGÚN EDAD.</strong></td>
                </tr>
                <tr>
                    <td colspan='2' rowspan='2' style="text-align:center; vertical-align:middle"><strong>MÉTODOS</strong></td>
                    <td rowspan='2' align='center' style="text-align:center; vertical-align:middle"><strong>TOTAL</strong></td>
                    <td colspan='11' align='center'><strong>POR EDAD (en años)</strong></td>
                </tr>
                <tr>
                    <td align='center'><strong>Menor de 15</strong></td>
                    <td align='center'><strong>15 - 19</strong></td>
                    <td align='center'><strong>20 - 24</strong></td>
                    <td align='center'><strong>25 - 29</strong></td>
                    <td align='center'><strong>30 - 34</strong></td>
                    <td align='center'><strong>35 - 39</strong></td>
                    <td align='center'><strong>40 - 44</strong></td>
                    <td align='center'><strong>45 - 49</strong></td>
                    <td align='center'><strong>50 - 54</strong></td>
                    <td align='center'><strong>55 y Más</strong></td>
                    <td align='center'><strong>Espacios Amigables</strong></td>
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
                          FROM (select c.* from 2019prestaciones c where c.codigo_prestacion in("01080011","05810443","01080021","01080022","01080023","01090060","05970038","05970039",
                                                                                                "01080013","01080014","05970040","05970041")) a
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
                }
                ?>
                <tr>
                    <td align='center' colspan="2"><strong>TOTAL REGULACIÓN DE FERTILIDAD</strong></td>
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
                </tr>
                <?php
                foreach($registro as $row ){
                    $nombre_descripcion = $row->codigo_prestacion;
                    if ($nombre_descripcion == "01080011"){
                        $nombre_descripcion ="D.I.U. T DE COBRE";
      							}
      							if ($nombre_descripcion == "05810443"){
                        $nombre_descripcion ="D.I.U. CON LEVONORGESTREL";
      							}

      							if ($nombre_descripcion == "01080021"){
                        $nombre_descripcion = "ORAL COMBINADO";
      							}
      							if ($nombre_descripcion == "01080022"){
                        $nombre_descripcion = "ORAL PROGESTÁGENO";
      							}
      							if ($nombre_descripcion == "01080023"){
                        $nombre_descripcion = "INYECTABLE COMBINADO";
      							}
      							if ($nombre_descripcion == "01090060"){
                        $nombre_descripcion = "INYECTABLE PROGESTÁGENO";
      							}
                    if ($nombre_descripcion == "05970038"){
                        $nombre_descripcion = "IMPLANTE ETONOGESTREL (3 AÑOS)";
      							}
                    if ($nombre_descripcion == "05970039"){
                        $nombre_descripcion = "IMPLANTE LENONORGESTREL (5 AÑOS)";
      							}
      							if ($nombre_descripcion == "01080013"){
                        $nombre_descripcion = "MUJER";
      							}
      							if ($nombre_descripcion == "01080014"){
                        $nombre_descripcion = "HOMBRE";
      							}
                    if ($nombre_descripcion == "05970040"){
                        $nombre_descripcion = "MUJER";
      							}
                    if ($nombre_descripcion == "05970041"){
                        $nombre_descripcion = "HOMBRES";
      							}
                    ?>
                <tr>
                    <?php
      							if($i>=0 && $i<2){?>
                    <td align='left' colspan='2'><?php echo $nombre_descripcion; ?></td>
      							<?php
                    }
      							if($i==2){?>
      							<td rowspan="6" style="text-align:center; vertical-align:middle">HORMONAL</td>
      							<?php
                    }
      							if($i>=2 && $i<=7){?>
      							<td align='left'><?php echo $nombre_descripcion; ?></td>
      							<?php
                    }
      							if($i==8){?>
      							<td rowspan="2" style="text-align:center; vertical-align:middle">SÓLO PRESERVATIVO MAC</td>
      							<?php
                    }
      							if($i>=8 && $i<=9){?>
      							<td align='left'><?php echo $nombre_descripcion; ?></td>
      							<?php
                    }
                    if($i==10){?>
      							<td rowspan="2" style="text-align:center; vertical-align:middle">ESTERILIZACIÓN QUIRURGICA</td>
      							<?php
                    }
      							if($i>=10 && $i<=11){?>
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
                          FROM (select c.* from 2019prestaciones c where c.codigo_prestacion in("05050100A","05970042","05970043","05970044","05970045","05970046","05970047")) a
                          left join 2019rems b on (a.id_prestacion=b.prestacion_id_prestacion)
                          AND (b.Mes in ('.$mes.')) AND (b.establecimiento_id_establecimiento in ('.$estab.'))
                          group by a.codigo_prestacion, a.descripcion, a.id_prestacion
                          order by a.id_prestacion';
                $registro = DB::connection('mysql_rem')->select($query);

                $i=0;

                foreach($registro as $row ){
                    $nombre_descripcion = $row->codigo_prestacion;
                    if ($nombre_descripcion == "05050100A"){
                        $nombre_descripcion ="MÉTODO DE REGULACIÓN DE FERTILIDAD MÁS PRESERVATIVOS";
      							}
                    if ($nombre_descripcion == "05970042"){
                        $nombre_descripcion ="GESTANTES QUE RECIBEN PRESERVATIVO";
      							}
                    if ($nombre_descripcion == "05970043"){
                        $nombre_descripcion ="MUJER";
      							}
                    if ($nombre_descripcion == "05970044"){
                        $nombre_descripcion ="HOMBRES";
      							}
                    if ($nombre_descripcion == "05970045"){
                        $nombre_descripcion ="MUJER";
      							}
                    if ($nombre_descripcion == "05970046"){
                        $nombre_descripcion ="HOMBRES";
      							}
                    if ($nombre_descripcion == "05970047"){
                        $nombre_descripcion ="CONDON FEMENINO";
      							}
                    ?>
                <tr>
                    <?php
                    if($i>=0 && $i<=1){?>
                    <td colspan="2" align='left'><?php echo $nombre_descripcion; ?></td>
                    <?php
                    }
                    if($i==2){?>
      							<td rowspan="2" style="text-align:center; vertical-align:middle">PRESERVATIVO/PRACTICA SEXUAL SEGURA</td>
      							<?php
                    }
      							if($i>=2 && $i<=3){?>
      							<td align='left'><?php echo $nombre_descripcion; ?></td>
      							<?php
                    }
                    if($i==4){?>
      							<td rowspan="2" style="text-align:center; vertical-align:middle">LUBRICANTES</td>
      							<?php
                    }
      							if($i>=4 && $i<=5){?>
      							<td align='left'><?php echo $nombre_descripcion; ?></td>
      							<?php
                    }
                    if($i>=6){?>
                    <td colspan="2" align='left'><?php echo $nombre_descripcion; ?></td>
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
    <!-- SECCION B -->
    <div class="col-sm tab table-responsive" id="D">
        <table class="table table-hover table-bordered table-sm">
            <thead>
                <tr>
                    <td colspan="2" class="active"><strong>SECCION D: INGRESOS A PROGRAMA CONTROL DE CLIMATERIO.</strong></td>
                </tr>
                <tr>
                    <td align='center'><strong>CONCEPTO</strong></td>
                    <td align='center'><strong>TOTAL</strong></td>
                </tr>
            </thead>
            <tbody>
                <?php
                $query = 'SELECT a.codigo_prestacion,a.descripcion
                              ,sum(ifnull(b.Col01,0)) Col01
                          FROM (select c.* from 2019prestaciones c where c.codigo_prestacion in("01080090")) a
                          left join 2019rems b on (a.id_prestacion=b.prestacion_id_prestacion)
                          AND (b.Mes in ('.$mes.')) AND (b.establecimiento_id_establecimiento in ('.$estab.'))
                          group by a.codigo_prestacion, a.descripcion, a.id_prestacion
                          order by a.id_prestacion';
                $registro = DB::connection('mysql_rem')->select($query);

                $i=0;

                foreach($registro as $row ){

                    $nombre_descripcion = $row->codigo_prestacion;
                    if ($nombre_descripcion == "01080090"){
                        $nombre_descripcion = "INGRESOS";
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

    <div class="col-sm tab table-responsive" id="E">
        <table class="table table-hover table-bordered table-sm">
            <thead>
                <tr>
                    <td colspan="4" class="active"><strong>SECCIÓN E: INGRESOS A CONTROL DE SALUD DE RECIÉN NACIDOS.</strong></td>
                </tr>
                <tr>
                    <td align='center'><strong>EDAD</strong></td>
                    <td align='center'><strong>TOTAL</strong></td>
                    <td align='center'><strong>NIÑOS</strong></td>
                    <td align='center'><strong>NIÑAS</strong></td>
                </tr>
            </thead>
            <tbody>
                <?php
                $query = 'SELECT a.codigo_prestacion,a.descripcion
                              ,sum(ifnull(b.Col01,0)) Col01
                              ,sum(ifnull(b.Col02,0)) Col02
                              ,sum(ifnull(b.Col03,0)) Col03
                          FROM (select c.* from 2019prestaciones c where c.codigo_prestacion in("05225100")) a
                          left join 2019rems b on (a.id_prestacion=b.prestacion_id_prestacion)
                          AND (b.Mes in ('.$mes.')) AND (b.establecimiento_id_establecimiento in ('.$estab.'))
                          group by a.codigo_prestacion, a.descripcion, a.id_prestacion
                          order by a.id_prestacion';
                $registro = DB::connection('mysql_rem')->select($query);

                $i=0;

                foreach($registro as $row ){

                    $nombre_descripcion = $row->codigo_prestacion;
                    if ($nombre_descripcion == "05225100"){
                        $nombre_descripcion = "MENORES DE 28 DÍAS";
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

    <br>

    <div class="col-sm tab table-responsive" id="F">
        <table class="table table-hover table-bordered table-sm">
            <thead>
                <tr>
                    <td colspan="25" class="active"><strong>SECCIÓN F: INGRESOS Y EGRESOS A SALA DE ESTIMULACIÓN SERVICIO ITINERANTE Y ATENCIÓN DOMICILIARIA EN EL CENTRO DE SALUD.</strong></td>
                </tr>
                <tr>
                    <td rowspan="3" align="center" style="text-align:center; vertical-align:middle"><strong>NIÑO / A (CON)</strong></td>
                    <td colspan="3" rowspan="2" align="center" style="text-align:center; vertical-align:middle"><strong>TOTAL</strong></td>
                    <td colspan="12" align="center"><strong>INGRESOS SALA DE ESTIMULACION</strong></td>
                    <td colspan="2" align="center"><strong>SERVICIO ITINERANTE EN CENTRO DE SALUD</strong></td>
                    <td colspan="2" align="center"><strong>ATENCIÓN DOMICILIARIA EN CENTRO DE SALUD</strong></td>
                    <td colspan="5" align="center"><strong>EGRESOS Y RESULTADOS DE LA REEVALUACIÓN POST EGRESO</strong></td>
                </tr>
                <tr>
                    <td colspan="2" align="center"><strong>Menor 7 mese</strong>s</td>
                    <td colspan="2" align="center"><strong>7 - 11 meses</strong></td>
                    <td colspan="2" align="center"><strong>12 - 17 meses</strong></td>
                    <td colspan="2" align="center"><strong>18 - 23 meses</strong></td>
                    <td colspan="2" align="center"><strong>24 - 47 meses</strong></td>
                    <td colspan="2" align="center"><strong>48 - 59 meses</strong></td>
                    <td colspan="2" align="center"><strong>7 a 59 meses</strong></td>
                    <td colspan="2" align="center"><strong>7 a 59 meses</strong></td>
                    <td colspan="2" align="center"><strong>MOTIVO EGRESO</strong></td>
                    <td rowspan="2" align="center" style="text-align:center; vertical-align:middle"><strong>INASISTENTE</strong></td>
                    <td colspan="2" align="center"><strong>RESULTADO DE REEVALUACIÓN</strong></td>
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
                    <td align="center"><strong>Cumplimiento de tratamiento</strong></td>
                    <td align="center"><strong>Otros</strong></td>
                    <td align="center"><strong>Recuperado</strong></td>
                    <td align="center"><strong>No Recuperado</strong></td>
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
                          FROM (select c.* from 2019prestaciones c where c.codigo_prestacion in("06902601","06902602","06902603","06902604")) a
                          left join 2019rems b on (a.id_prestacion=b.prestacion_id_prestacion)
                          AND (b.Mes in ('.$mes.')) AND (b.establecimiento_id_establecimiento in ('.$estab.'))
                          group by a.codigo_prestacion, a.descripcion, a.id_prestacion
                          order by a.id_prestacion';
                $registro = DB::connection('mysql_rem')->select($query);

                $i=0;

                foreach($registro as $row ){

                    $nombre_descripcion = $row->codigo_prestacion;
                    if ($nombre_descripcion == "06902601"){
                        $nombre_descripcion = "NORMAL CON REZAGO";
      							}
      							if ($nombre_descripcion == "06902602"){
                        $nombre_descripcion = "RIESGO";
      							}
      							if ($nombre_descripcion == "06902603"){
                        $nombre_descripcion = "RETRASO";
      							}

      							if ($nombre_descripcion == "06902604"){
                        $nombre_descripcion = "OTRA VULNERABILIDAD";
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
                    <?php
                    $i++;
                }
                ?>
                </tr>
            </tbody>
        </table>
    </div>

    <br>

    <div class="col-sm tab table-responsive" id="F1">
        <table class="table table-hover table-bordered table-sm">
            <thead>
                <tr>
                    <td colspan="21" class="active"><strong>SECCIÓN F.1: REINGRESOS Y EGRESOS POR SEGUNDA VEZ A MODALIDAD DE ESTIMULACIÓN EN EL CENTRO DE SALUD.</strong></td>
                </tr>
                <tr>
                    <td rowspan="3" align="center" style="text-align:center; vertical-align:middle"><strong>NIÑO / A (CON)</strong></td>
                    <td colspan="3" rowspan="2" align="center" style="text-align:center; vertical-align:middle"><strong>TOTAL</strong></td>
                    <td colspan="12" align="center"><strong>REINGRESOS A MODALIDAD DE ESTIMULACION  EN CENTRO DE SALUD</strong></td>
                    <td colspan="5" align="center"><strong>EGRESOS POR SEGUNDA VEZ Y RESULTADOS DE LA REEVALUACIÓN POST EGRESO</strong></td>
                </tr>
                <tr>
                    <td colspan="2" align="center"><strong>Menor 7 mese</strong>s</td>
                    <td colspan="2" align="center"><strong>7 - 11 meses</strong></td>
                    <td colspan="2" align="center"><strong>12 - 17 meses</strong></td>
                    <td colspan="2" align="center"><strong>18 - 23 meses</strong></td>
                    <td colspan="2" align="center"><strong>24 - 47 meses</strong></td>
                    <td colspan="2" align="center"><strong>48 - 59 meses</strong></td>
                    <td colspan="2" align="center"><strong>MOTIVO EGRESO</strong></td>
                    <td rowspan="2" align="center" style="text-align:center; vertical-align:middle"><strong>INASISTENTE</strong></td>
                    <td colspan="2" align="center"><strong>RESULTADO DE REEVALUACIÓN</strong></td>
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
                    <td align="center"><strong>Cumplimiento de tratamiento</strong></td>
                    <td align="center"><strong>Otros</strong></td>
                    <td align="center"><strong>Recuperado</strong></td>
                    <td align="center"><strong>No Recuperado</strong></td>
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
                          FROM (select c.* from 2019prestaciones c where c.codigo_prestacion in("05970010","05970011","05970012","05970013")) a
                          left join 2019rems b on (a.id_prestacion=b.prestacion_id_prestacion)
                          AND (b.Mes in ('.$mes.')) AND (b.establecimiento_id_establecimiento in ('.$estab.'))
                          group by a.codigo_prestacion, a.descripcion, a.id_prestacion
                          order by a.id_prestacion';
                $registro = DB::connection('mysql_rem')->select($query);

                $i=0;

                foreach($registro as $row ){

                    $nombre_descripcion = $row->codigo_prestacion;
                    if ($nombre_descripcion == "05970010"){
                        $nombre_descripcion = "NORMAL CON REZAGO";
      							}
      							if ($nombre_descripcion == "05970011"){
                        $nombre_descripcion = "RIESGO";
      							}
      							if ($nombre_descripcion == "05970012"){
                        $nombre_descripcion = "RETRASO";
      							}
      							if ($nombre_descripcion == "05970013"){
                        $nombre_descripcion = "OTRA VULNERABILIDAD";
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

    <div class="col-sm tab table-responsive" id="G">
        <table class="table table-hover table-bordered table-sm">
            <thead>
                <tr>
                    <td colspan="14" class="active"><strong>SECCION G: INGRESOS DE NIÑOS Y NIÑAS CON NECESIDADES ESPECIALES DE BAJA COMPLEJIDAD A CONTROL DE SALUD INFANTIL EN APS</strong></td>
                </tr>
                <tr>
                    <td rowspan="3" align="center" style="text-align:center; vertical-align:middle"><strong>NANEAS</strong></td>
                    <td colspan="3" rowspan="2" align="center" style="text-align:center; vertical-align:middle"><strong>TOTAL</strong></td>
                    <td colspan="10" align="center"><strong>POR EDAD</strong></td>
                </tr>
                <tr>
                    <td colspan="2" align="center"><strong>0 - 4</strong></td>
                    <td colspan="2" align="center"><strong>5 - 9</strong></td>
                    <td colspan="2" align="center"><strong>10 - 14</strong></td>
                    <td colspan="2" align="center"><strong>15 a 19</strong></td>
                    <td colspan="2" align="center"><strong>20 - 24</strong></td>
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
                          FROM (select c.* from 2019prestaciones c where c.codigo_prestacion in("05225102")) a
                          left join 2019rems b on (a.id_prestacion=b.prestacion_id_prestacion)
                          AND (b.Mes in ('.$mes.')) AND (b.establecimiento_id_establecimiento in ('.$estab.'))
                          group by a.codigo_prestacion, a.descripcion, a.id_prestacion
                          order by a.id_prestacion';
                $registro = DB::connection('mysql_rem')->select($query);

                $i=0;

                foreach($registro as $row ){

                    $nombre_descripcion = $row->codigo_prestacion;
                    if ($nombre_descripcion == "05225102"){
                        $nombre_descripcion = "INGRESOS";
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

    <div class="col-sm tab table-responsive" id="H">
        <table class="table table-hover table-bordered table-sm">
            <thead>
                <tr>
                    <td colspan="33" class="active"><strong>SECCIÓN H: INGRESOS AL PSCV.</strong></td>
                </tr>
                <tr>
                    <td colspan="2" rowspan="3" align="center" style="text-align:center; vertical-align:middle"><strong>CONCEPTO</strong></td>
                    <td colspan="3" rowspan="2" align="center" style="text-align:center; vertical-align:middle"><strong>TOTAL</strong></td>
                    <td colspan="28" align="center"><strong>INGRESOS</strong></td>
                </tr>
                <tr>
                    <td colspan="2" align="center"><strong>15 a 19</strong></td>
                    <td colspan="2" align="center"><strong>20 - 24</strong></td>
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
                          FROM (select c.* from 2019prestaciones c where c.codigo_prestacion in("03030360","03021106","03021107","03021108","05810431","05810432")) a
                          left join 2019rems b on (a.id_prestacion=b.prestacion_id_prestacion)
                          AND (b.Mes in ('.$mes.')) AND (b.establecimiento_id_establecimiento in ('.$estab.'))
                          group by a.codigo_prestacion, a.descripcion, a.id_prestacion
                          order by a.id_prestacion';
                $registro = DB::connection('mysql_rem')->select($query);

                $i=0;

                foreach($registro as $row ){

                    $nombre_descripcion = $row->codigo_prestacion;
                    if ($nombre_descripcion == "03030360"){
                        $nombre_descripcion = "INGRESOS AL PSCV";
                    }

      							if ($nombre_descripcion == "03021106"){
                        $nombre_descripcion = "HIPERTENSIÓN ARTERIAL";
      							}
      							if ($nombre_descripcion == "03021107"){
                        $nombre_descripcion = "DIABETES MELLITUS";
      							}
      							if ($nombre_descripcion == "03021108"){
                        $nombre_descripcion = "DISLIPIDEMIAS";
      							}
      							if ($nombre_descripcion == "05810431"){
                        $nombre_descripcion = "ANTECEDENTES ENF. CARDIOVASCULAR ATEROSCLEROTICA";
      							}
      							if ($nombre_descripcion == "05810432"){
                        $nombre_descripcion = "TABAQUISMO";
      							}

                    ?>
                <tr>
                    <?php
      							if($i==0){?>
                    <td align='left' colspan='2'><?php echo $nombre_descripcion; ?></td>
      							<?php }
      							if($i==1){?>
                    <td rowspan="5" style="text-align:center; vertical-align:middle">PROG. SALUD CARDIOVASCULAR</td>
                    <td align='left' nowrap="nowrap"><?php echo $nombre_descripcion; ?></td>
      							<?php }
      							if($i>=2){?>
                    <td align='left'><?php echo $nombre_descripcion; ?></td>
      							<?php }?>
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

    <div class="col-sm tab table-responsive" id="I">
        <table class="table table-hover table-bordered table-sm">
            <thead>
                <tr>
                    <td colspan="37" class="active"><strong>SECCIÓN I: EGRESOS DEL PSCV.</strong></td>
                </tr>
                <tr>
                    <td colspan="2" rowspan="3" align="center" style="text-align:center; vertical-align:middle"><strong>CONCEPTO</strong></td>
                    <td colspan="3" rowspan="2" align="center" style="text-align:center; vertical-align:middle"><strong>TOTAL</strong></td>
                    <td colspan="28" align="center"><strong>EGRESOS</strong></td>
                    <td colspan='4' align='center'><strong>CAUSAL DE EGRESO</strong></td>
                </tr>
                <tr>
                    <td colspan="2" align="center"><strong>15 a 19</strong></td>
                    <td colspan="2" align="center"><strong>20 - 24</strong></td>
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
                    <td rowspan='2' align='center' style="text-align:center; vertical-align:middle"><strong>ABANDONO</strong></td>
                    <td rowspan='2' align='center' style="text-align:center; vertical-align:middle"><strong>TRASLADO</strong></td>
                    <td rowspan='2' align='center' style="text-align:center; vertical-align:middle"><strong>FALLECI-MIENTO</strong></td>
                    <td rowspan='2' align='center' style="text-align:center; vertical-align:middle"><strong>NO CUMPLE CRITERIO</strong></td>

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
                          FROM (select c.* from 2019prestaciones c where c.codigo_prestacion in("05810040","05225400","05225401","05225402","05810433","05810434")) a
                          left join 2019rems b on (a.id_prestacion=b.prestacion_id_prestacion)
                          AND (b.Mes in ('.$mes.')) AND (b.establecimiento_id_establecimiento in ('.$estab.'))
                          group by a.codigo_prestacion, a.descripcion, a.id_prestacion
                          order by a.id_prestacion';
                $registro = DB::connection('mysql_rem')->select($query);

                $i=0;

                foreach($registro as $row ){
                    $nombre_descripcion = $row->codigo_prestacion;
                    if ($nombre_descripcion == "05810040"){
                        $nombre_descripcion = "EGRESOS AL PSCV";
                    }

      							if ($nombre_descripcion == "05225400"){
                        $nombre_descripcion = "HIPERTENSIÓN ARTERIAL";
      							}
      							if ($nombre_descripcion == "05225401"){
                        $nombre_descripcion = "DIABETES MELLITUS";
      							}
      							if ($nombre_descripcion == "05225402"){
                        $nombre_descripcion = "DISLIPIDEMIAS";
      							}
      							if ($nombre_descripcion == "05810433"){
                        $nombre_descripcion = "ANTECEDENTES ENF. CARDIOVASCULAR ATEROSCLEROTICA";
      							}
      							if ($nombre_descripcion == "05810434"){
                        $nombre_descripcion = "TABAQUISMO";
      							}
                    ?>
                <tr>
                    <?php
      							if($i==0){?>
                    <td align='left' colspan='2'><?php echo $nombre_descripcion; ?></td>
      							<?php }
      							if($i==1){?>
                    <td rowspan="5" style="text-align:center; vertical-align:middle">PROG. SALUD CARDIOVASCULAR</td>
      							<td align='left' nowrap="nowrap"><?php echo $nombre_descripcion; ?></td>
      							<?php }
      							if($i>=2){?>
      							<td align='left'><?php echo $nombre_descripcion; ?></td>
      							<?php }?>
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

    <br>

    <div class="col-sm tab table-responsive" id="J">
        <table class="table table-hover table-bordered table-sm">
            <thead>
                <tr>
                    <td colspan="36" class="active"><strong>SECCIÓN J: INGRESOS Y EGRESOS AL PROGRAMA DE PACIENTES CON DEPENDENCIA LEVE, MODERADA Y SEVERA.</strong></td>
                </tr>
                <tr>
                    <td colspan='2' rowspan='3' align='center' style="text-align:center; vertical-align:middle"><strong>CONCEPTO</strong></td>
                    <td colspan='3' rowspan='2' align='center' style="text-align:center; vertical-align:middle"><strong>TOTAL</strong></td>
                    <td colspan='28' align='center'><strong>INGRESOS</strong></td>
                    <td colspan='3' align='center'><strong>CAUSAL DE EGRESO</strong></td>
                </tr>
                <tr>
                    <td colspan='2' align='center'><strong>< 20 años</strong></td>
                    <td colspan='2' align='center'><strong>20 - 24</strong></td>
                    <td colspan='2' align='center'><strong>25 a 29</strong></td>
                    <td colspan='2' align='center'><strong>30 a 34</strong></td>
                    <td colspan='2' align='center'><strong>35 a 39</strong></td>
                    <td colspan='2' align='center'><strong>40 a 44</strong></td>
                    <td colspan='2' align='center'><strong>45 a 49</strong></td>
                    <td colspan='2' align='center'><strong>50 a 54</strong></td>
                    <td colspan='2' align='center'><strong>55 a 59</strong></td>
                    <td colspan='2' align='center'><strong>60 a 64</strong></td>
                    <td colspan='2' align='center'><strong>65 a 69</strong></td>
                    <td colspan='2' align='center'><strong>70 a 74</strong></td>
                    <td colspan='2' align='center'><strong>75 a 79</strong></td>
                    <td colspan='2' align='center'><strong>80 y más</strong></td>
                    <td rowspan='2' align='center' style="text-align:center; vertical-align:middle"><strong>ABANDONO</strong></td>
                    <td rowspan='2' align='center' style="text-align:center; vertical-align:middle"><strong>TRASLADO</strong></td>
                    <td rowspan='2' align='center' style="text-align:center; vertical-align:middle"><strong>FALLECI-MIENTO</strong></td>
                </tr>
                <tr>
                    <td align='center'><strong>AMBOS SEXOS</strong></td>
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
                          FROM (select c.* from 2019prestaciones c where c.codigo_prestacion in("05810050","05810060","05810070","05810080","05810090")) a
                          left join 2019rems b on (a.id_prestacion=b.prestacion_id_prestacion)
                          AND (b.Mes in ('.$mes.')) AND (b.establecimiento_id_establecimiento in ('.$estab.'))
                          group by a.codigo_prestacion, a.descripcion, a.id_prestacion
                          order by a.id_prestacion';
                $registro = DB::connection('mysql_rem')->select($query);

                $i=0;

                foreach($registro as $row ){
                    $nombre_descripcion = $row->codigo_prestacion;
                    if ($nombre_descripcion == "05810050"){
                        $nombre_descripcion = "DEPENDENCIA LEVE";
      							}

      							if ($nombre_descripcion == "05810060"){
                        $nombre_descripcion = "DEPENDENCIA MODERADA";
      							}
      							if ($nombre_descripcion == "05810070"){
                        $nombre_descripcion = "ONCOLÓGICO";
      							}

      							if ($nombre_descripcion == "05810080"){
                        $nombre_descripcion = "NO ONCOLÓGICO";
      							}
      							if ($nombre_descripcion == "05810090"){
                        $nombre_descripcion = "DEPENDENCIA SEVERA CON  ESCARAS";
      							}
                    ?>
                <tr>
                    <?php
      							if($i>=0 && $i<=1){?>
                    <td align='left' colspan='2'><?php echo $nombre_descripcion; ?></td>
      							<?php }
      							if($i==2){?>
                    <td rowspan="2" style="text-align:center; vertical-align:middle">DEPENDENCIA GRAVE Y TOTAL</td>
                    <td align='left'><?php echo $nombre_descripcion; ?></td>
      							<?php }
      							if($i==3){?>
      							<td align='left'><?php echo $nombre_descripcion; ?></td>
      							<?php }
      							if($i==4){?>
      							<td align='left' colspan='2' nowrap="nowrap"><?php echo $nombre_descripcion; ?></td>
      							<?php }?>
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
            </tbody>
        </table>
    </div>

    <br>

    <div class="col-sm tab table-responsive" id="K">
        <table class="table table-hover table-bordered table-sm">
            <thead>
                <tr>
                    <td colspan="13" class="active"><strong>SECCIÓN K: INGRESOS AL PROGRAMA DEL ADULTO MAYOR SEGÚN CONDICIÓN DE FUNCIONALIDAD Y DEPENDENCIA.</strong></td>
                </tr>
                <tr>
                    <td rowspan='2' colspan="2" style="text-align:center; vertical-align:middle"><strong>CONDICION</strong></td>
                    <td colspan='3' align='center'><strong>TOTAL</strong></td>
                    <td colspan='2' align='center'><strong>65 - 69 años</strong></td>
                    <td colspan='2' align='center'><strong>70 - 74 años</strong></td>
                    <td colspan='2' align='center'><strong>75 - 79 años</strong></td>
                    <td colspan='2' align='center'><strong>80 y más</strong></td>
                </tr>
                <tr>
                    <td align='center'><strong>AMBOS SEXOS</strong></td>
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
                          FROM (select c.* from 2019prestaciones c where c.codigo_prestacion in("05021207","05021208","05120900")) a
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

                    $nombre_descripcion = $row->codigo_prestacion;
                    if ($nombre_descripcion == "05021207"){
                        $nombre_descripcion = "AUTOVALENTE SIN RIESGO";
      							}
      							if ($nombre_descripcion == "05021208"){
                        $nombre_descripcion = "AUTOVALENTE CON RIESGO";
      							}
      							if ($nombre_descripcion == "05120900"){
                        $nombre_descripcion = "RIESGO DE DEPENDENCIA";
      							}
                    ?>
                <tr>
                    <?php
                    if($i==0){?>
                    <td rowspan="3" style="text-align:center; vertical-align:middle">EFAM</td>
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
                    <td colspan="2" align='left'><strong>SUBTOTAL</strong></td>
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
                          FROM (select c.* from 2019prestaciones c where c.codigo_prestacion in("05130100","05130200","05130300","05810100")) a
                          left join 2019rems b on (a.id_prestacion=b.prestacion_id_prestacion)
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

                    $nombre_descripcion = $row->codigo_prestacion;
                    if ($nombre_descripcion == "05130100"){
                        $nombre_descripcion = "DEPENDIENTE LEVE";
      							}
      							if ($nombre_descripcion == "05130200"){
                        $nombre_descripcion = "DEPENDIENTE MODERADO";
      							}
      							if ($nombre_descripcion == "05130300"){
                        $nombre_descripcion = "DEPENDIENTE GRAVE";
      							}
      							if ($nombre_descripcion == "05810100"){
                        $nombre_descripcion = "DEPENDIENTE TOTAL";
      							}
                    ?>
                <tr>
                    <?php
                    if($i==0){?>
                    <td rowspan="4" style="text-align:center; vertical-align:middle">BARTHEL</td>
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
                    <td colspan="2" align='left'><strong>SUBTOTAL</strong></td>
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
                </tr>
                <?php
                $totalCol01=$totalCol01a+$totalCol01b;
                $totalCol02=$totalCol02a+$totalCol02b;
                $totalCol03=$totalCol03a+$totalCol03b;
                $totalCol04=$totalCol04a+$totalCol04b;
                $totalCol05=$totalCol05a+$totalCol05b;
                $totalCol06=$totalCol06a+$totalCol06b;
                $totalCol07=$totalCol07a+$totalCol07b;
                $totalCol08=$totalCol08a+$totalCol08b;
                $totalCol09=$totalCol09a+$totalCol09b;
                $totalCol10=$totalCol10a+$totalCol10b;
                $totalCol11=$totalCol11a+$totalCol11b;
                ?>
                <tr>
                    <td colspan="2" align='left'><strong>TOTAL</strong></td>
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
            </tbody>
        </table>
    </div>

    <br>

    <div class="col-sm tab table-responsive" id="L">
        <table class="table table-hover table-bordered table-sm">
            <thead>
                <tr>
                    <td colspan="16" class="active"><strong>SECCIÓN L: EGRESOS DEL PROGRAMA DEL ADULTO MAYOR SEGÚN CONDICIÓN DE FUNCIONALIDAD Y DEPENDENCIA.</strong></td>
                </tr>
                <tr>
                    <td rowspan='2' colspan="2" style="text-align:center; vertical-align:middle"><strong>CONDICION</strong></td>
                    <td colspan='3' align='center'><strong>TOTAL</strong></td>
                    <td colspan='2' align='center'><strong>65 - 69 años</strong></td>
                    <td colspan='2' align='center'><strong>70 - 74 años</strong></td>
                    <td colspan='2' align='center'><strong>75 - 79 años</strong></td>
                    <td colspan='2' align='center'><strong>80 y más</strong></td>
                    <td colspan='3' align='center'><strong>CAUSAL DE EGRESO</strong></td>
                </tr>
                <tr>
                    <td align='center'><strong>AMBOS SEXOS</strong></td>
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
                    <td align='center'><strong>ABANDONO</strong></td>
                    <td align='center'><strong>TRASLADO</strong></td>
                    <td align='center'><strong>FALLECIMIENTO</strong></td>
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
                          FROM (select c.* from 2019prestaciones c where c.codigo_prestacion in("05050700","05050800","05050900")) a
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

                    $nombre_descripcion = $row->codigo_prestacion;
                    if ($nombre_descripcion == "05050700"){
                        $nombre_descripcion = "AUTOVALENTE SIN RIESGO";
      							}
      							if ($nombre_descripcion == "05050800"){
                        $nombre_descripcion = "AUTOVALENTE CON RIESGO";
      							}
      							if ($nombre_descripcion == "05050900"){
                        $nombre_descripcion = "RIESGO DE DEPENDENCIA";
      							}
                    ?>
                <tr>
                    <?php
                    if($i==0){?>
                    <td rowspan="3" style="text-align:center; vertical-align:middle">EFAM</td>
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
                    <?php
                    $i++;
                }
                ?>
                </tr>
                <tr>
                    <td colspan="2" align='left'><strong>SUBTOTAL</strong></td>
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
                          FROM (select c.* from 2019prestaciones c where c.codigo_prestacion in("05051000","05051100","05051200","05051300")) a
                          left join 2019rems b on (a.id_prestacion=b.prestacion_id_prestacion)
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

                    $nombre_descripcion = $row->codigo_prestacion;
                    if ($nombre_descripcion == "05051000"){
                        $nombre_descripcion = "DEPENDIENTE LEVE";
      							}
      							if ($nombre_descripcion == "05051100"){
                        $nombre_descripcion = "DEPENDIENTE MODERADO";
      							}
      							if ($nombre_descripcion == "05051200"){
                        $nombre_descripcion = "DEPENDIENTE GRAVE";
      							}
      							if ($nombre_descripcion == "05051300"){
                        $nombre_descripcion = "DEPENDIENTE TOTAL";
      							}
                    ?>
                <tr>
                    <?php
                    if($i==0){?>
                    <td rowspan="4" style="text-align:center; vertical-align:middle">BARTHEL</td>
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
                    <?php
                    $i++;
                }
                ?>
                </tr>
                <tr>
                    <td colspan="2" align='left'><strong>SUBTOTAL</strong></td>
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
                </tr>
                <?php
                $totalCol01=$totalCol01a+$totalCol01b;
                $totalCol02=$totalCol02a+$totalCol02b;
                $totalCol03=$totalCol03a+$totalCol03b;
                $totalCol04=$totalCol04a+$totalCol04b;
                $totalCol05=$totalCol05a+$totalCol05b;
                $totalCol06=$totalCol06a+$totalCol06b;
                $totalCol07=$totalCol07a+$totalCol07b;
                $totalCol08=$totalCol08a+$totalCol08b;
                $totalCol09=$totalCol09a+$totalCol09b;
                $totalCol10=$totalCol10a+$totalCol10b;
                $totalCol11=$totalCol11a+$totalCol11b;
                $totalCol12=$totalCol12a+$totalCol12b;
                $totalCol13=$totalCol13a+$totalCol13b;
                $totalCol14=$totalCol14a+$totalCol14b;
                ?>
                <tr>
                    <td colspan="2" align='left'><strong>TOTAL</strong></td>
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
                </tr>
            </tbody>
        </table>
    </div>

    <br>

    <div class="col-sm tab table-responsive" id="M">
        <table class="table table-hover table-bordered table-sm">
            <thead>
                <tr>
                    <td colspan="15" class="active"><strong>SECCIÓN M: INGRESOS Y EGRESOS DEL PROGRAMA MÁS ADULTOS MAYORES AUTOVALENTES.</strong></td>
                </tr>
                    <td rowspan='2' colspan="2" style="text-align:center; vertical-align:middle"><strong>CONDICIÓN</strong></td>
                    <td colspan='3' align='center'><strong>TOTAL</strong></td>
                    <td colspan='2' align='center'><strong>60 a 64</strong></td>
                    <td colspan='2' align='center'><strong>65 a 69</strong></td>
                    <td colspan='2' align='center'><strong>70 a 74</strong></td>
                    <td colspan='2' align='center'><strong>75 a 79</strong></td>
                    <td colspan='2' align='center'><strong>80 y m&aacute;s</strong></td>
                </tr>
                <tr>
                    <td align='center'><strong>AMBOS SEXOS</strong></td>
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
                          FROM (select c.* from 2019prestaciones c where c.codigo_prestacion in("05051301","05051302","05051303")) a
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

                    $nombre_descripcion = $row->codigo_prestacion;
                    if ($nombre_descripcion == "05051301"){
                        $nombre_descripcion = "AUTOVALENTE SIN RIESGO";
                    }
                    if ($nombre_descripcion == "05051302"){
                        $nombre_descripcion = "AUTOVALENTE CON RIESGO";
                    }
							      if ($nombre_descripcion == "05051303"){
                        $nombre_descripcion = "RIESGO DE DEPENDENCIA";
                    }

                    ?>
                <tr>
                    <?php
                    if($i==0){?>
                    <td rowspan="4" style="text-align:center; vertical-align:middle">INGRESO</td>
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
                    <?php
                    $i++;
                }
                ?>
                </tr>
                <tr>
                    <td align='left'><strong>TOTAL INGRESOS</strong></td>
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
                          FROM (select c.* from 2019prestaciones c where c.codigo_prestacion in("05051304","05051305","05051306","05051307")) a
                          left join 2019rems b on (a.id_prestacion=b.prestacion_id_prestacion)
                          AND (b.Mes in ('.$mes.')) AND (b.establecimiento_id_establecimiento in ('.$estab.'))
                          group by a.codigo_prestacion, a.descripcion, a.id_prestacion
                          order by a.id_prestacion';
                $registro = DB::connection('mysql_rem')->select($query);

                $i=0;

                foreach($registro as $row ){

                    $nombre_descripcion = $row->codigo_prestacion;
                    if ($nombre_descripcion == "05051304"){
                        $nombre_descripcion = "COMPLETA CICLO";
                    }
                    if ($nombre_descripcion == "05051305"){
                        $nombre_descripcion = "ABANDONO";
                    }
                    if ($nombre_descripcion == "05051306"){
                        $nombre_descripcion = "TRASLADO";
                    }
                    if ($nombre_descripcion == "05051307"){
                        $nombre_descripcion = "FALLECIMIENTO";
                    }
                    ?>
                <tr>
                    <?php
                    if($i==0){?>
                    <td rowspan="4" style="text-align:center; vertical-align:middle">EGRESO</td>
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
                    <?php
                    $i++;
                }
                ?>
                </tr>
                <tr>
                    <td align='left' colspan="15">* Los pacientes de 60 a 64 años, no debe desagregarse por condición de funcionalidad, por ello sólo se registran en la primera fila (Autovalente sin riesgo).</td>
                </tr>
                <tr>
                    <td align='left' colspan="15">** Para la desagración por funcionalidad se contabiliza desde 65 y mas años.Sólo para el cálculo del total de los ingresos se contabiliza el rango de 60 - 64 años.</td>
                </tr>
            </tbody>
        </table>
    </div>

    <br>

    <div class="col-sm tab table-responsive" id="M">
        <table class="table table-hover table-bordered table-sm">
            <thead>
                <tr>
                    <td colspan="45" class="active"><strong>SECCIÓN N: INGRESOS AL PROGRAMA DE SALUD MENTAL EN APS /ESPECIALIDAD.</strong></td>
                </tr>
                    <td rowspan='2' colspan='2' align='center' style="text-align:center; vertical-align:middle"><strong>MOTIVO DE INGRESO</strong></td>
                    <td colspan='3' align='center'><strong>TOTAL</strong></td>
                    <td colspan='2' align='center'><strong>0 - 4 años</strong></td>
                    <td colspan='2' align='center'><strong>5 - 9 años</strong></td>
                    <td colspan='2' align='center'><strong>10 - 14 años</strong></td>
                    <td colspan='2' align='center'><strong>15 - 19 años</strong></td>
                    <td colspan='2' align='center'><strong>20 - 24 años</strong></td>
                    <td colspan='2' align='center'><strong>25 - 29 años</strong></td>
                    <td colspan='2' align='center'><strong>30 - 34 años</strong></td>
                    <td colspan='2' align='center'><strong>35 - 39 años</strong></td>
                    <td colspan='2' align='center'><strong>40 - 44 años</strong></td>
                    <td colspan='2' align='center'><strong>45 - 49 años</strong></td>
                    <td colspan='2' align='center'><strong>50 - 54 años</strong></td>
                    <td colspan='2' align='center'><strong>55 - 59 años</strong></td>
                    <td colspan='2' align='center'><strong>60 - 64 años</strong></td>
                    <td colspan='2' align='center'><strong>65 - 69 años</strong></td>
                    <td colspan='2' align='center'><strong>70 - 74 años</strong></td>
                    <td colspan='2' align='center'><strong>75 - 79 años</strong></td>
                    <td colspan='2' align='center'><strong>80 años y más</strong></td>
                    <td rowspan='2' align='center'><strong>GESTANTE</strong></td>
                    <td rowspan='2' align='center'><strong>Madre de Hijo menor de 5 años</strong></td>
                    <td colspan='2' align='center'><strong>PUEBLOS ORIGINARIOS</strong></td>
                    <td rowspan='2' align='center'><strong>Niños, Niñas, Adolescentes y Jóvenes Población SENAME</strong></td>
                    <td rowspan='2' align='center'><strong>MIGRANTES</strong></td>
                </tr>
                <tr>
                    <td align='center'><strong>AMBOS SEXOS</strong></td>
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
                    <td align='center'><strong>Mujeres</strong></td>
                    <td align='center'><strong>Hombres</strong></td>
                    <td align='center'><strong>Mujeres</strong></td>
                    <td align='center'><strong>Hombres</strong></td>
                    <td align='center'><strong>Mujeres</strong></td>
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
            									,sum(ifnull(b.Col42,0)) Col42
            									,sum(ifnull(b.Col43,0)) Col43
                          FROM (select c.* from 2019prestaciones c where c.codigo_prestacion in("05227400")) a
                          left join 2019rems b on (a.id_prestacion=b.prestacion_id_prestacion)
                          AND (b.Mes in ('.$mes.')) AND (b.establecimiento_id_establecimiento in ('.$estab.'))
                          group by a.codigo_prestacion, a.descripcion, a.id_prestacion
                          order by a.id_prestacion';
                $registro = DB::connection('mysql_rem')->select($query);

                $i=0;

                foreach($registro as $row ){

                    $nombre_descripcion = $row->codigo_prestacion;
                    if ($nombre_descripcion == "05227400"){
                        $nombre_descripcion = "	INGRESOS AL PROGRAMA";
                    }
                    ?>
                <tr>
                    <td colspan="2" align='left'><?php echo $nombre_descripcion; ?></td>
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
                    <?php
                    $i++;
                }
                ?>
                </tr>
                <tr>
                    <td colspan="2" align='left' nowrap><strong>FACTORES DE RIESGO Y CONDICIONANTES DE LA SALUD MENTAL</strong></td>
                    <td colspan="43" align='left'></td>
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
                          FROM (select c.* from 2019prestaciones c where c.codigo_prestacion in("06900700","06900800",
                                                                                                "06901100",
                                                                                                "05970014","05970015",
                                                                                                "05810441",
                                                                                                "06901200","06902605","06902606","06901300","06901400","05051400","05051500","05051600",
                                                                                                "06901500","06901600","06901700",
                                                                                                "06902200","05051700","05051800","06902300",
                                                                                                "05970016","05970017","05970018","05970019","05970020","05970021",
                                                                                                "05901801","05901802","05901803",
                                                                                                "06902000","06902100","06902400","06902500","06902600","05970022","05810445")) a
                          left join 2019rems b on (a.id_prestacion=b.prestacion_id_prestacion)
                          AND (b.Mes in ('.$mes.')) AND (b.establecimiento_id_establecimiento in ('.$estab.'))
                          group by a.codigo_prestacion, a.descripcion, a.id_prestacion
                          order by a.id_prestacion';
                $registro = DB::connection('mysql_rem')->select($query);

                $i=0;

                foreach($registro as $row ){

                    $nombre_descripcion = $row->codigo_prestacion;
                    if ($nombre_descripcion == "06900700"){
                        $nombre_descripcion = "VICTIMA";
                    }
                    if ($nombre_descripcion == "06900800"){
                        $nombre_descripcion = "AGRESOR / A";
                    }
                    if ($nombre_descripcion == "06901100"){
                        $nombre_descripcion = "ABUSO SEXUAL";
                    }
                    if ($nombre_descripcion == "05970014"){
                        $nombre_descripcion = "IDEACIÓN";
                    }
                    if ($nombre_descripcion == "05970015"){
                        $nombre_descripcion = "INTENTO";
                    }
                    if ($nombre_descripcion == "05810441"){
                        $nombre_descripcion = "PERSONAS CON DIAGNÓSTICOS DE TRASTORNOS MENTALES";
                    }
                    if ($nombre_descripcion == "06901200"){
                        $nombre_descripcion = "DEPRESIÓN LEVE";
      							}
      							if ($nombre_descripcion == "06902605"){
                        $nombre_descripcion = "DEPRESIÓN MODERADA";
      							}
      							if ($nombre_descripcion == "06902606"){
                        $nombre_descripcion = "DEPRESIÓN GRAVE";
      							}
      							if ($nombre_descripcion == "06901300"){
                        $nombre_descripcion = "DEPRESIÓN POST PARTO";
      							}
      							if ($nombre_descripcion == "06901400"){
                        $nombre_descripcion = "TRANSTORNO BIPOLAR";
      							}
      							if ($nombre_descripcion == "05051400"){
                        $nombre_descripcion = "DEPRESIÓN REFRACTARIA";
      							}
      							if ($nombre_descripcion == "05051500"){
                        $nombre_descripcion = "DEPRESIÓN GRAVE CON PSICOSIS";
      							}
      							if ($nombre_descripcion == "05051600"){
                        $nombre_descripcion = "DEPRESIÓN CON ALTO RIESGO SUICIDA";
      							}
                    if ($nombre_descripcion == "06901500"){
                        $nombre_descripcion = "CONSUMO PERJUDICIAL O DEPENDENCIA DE ALCOHOL";
                    }
                    if ($nombre_descripcion == "06901600"){
                        $nombre_descripcion = "CONSUMO PERJUDICIAL O DEPENDENCIA COMO DROGA PRINCIPAL";
                    }
                    if ($nombre_descripcion == "06901700"){
                        $nombre_descripcion = "POLICONSUMO";
                    }
                    if ($nombre_descripcion == "06902200"){
                        $nombre_descripcion = "TRANSTORNO HIPERCINÉTICOS";
      							}
      							if ($nombre_descripcion == "05051700"){
                        $nombre_descripcion = "TRANSTORNO DISOCIAL DESAFIANTE Y OPOSICIONISTA";
      							}
      							if ($nombre_descripcion == "05051800"){
                        $nombre_descripcion = "TRANSTORNO DE ANSIEDAD DE SEPARACIÓN EN LA INFANCIA";
      							}
      							if ($nombre_descripcion == "06902300"){
                        $nombre_descripcion = "OTROS TRASTORNOS DEL COMPORTAMIENTO Y DE LAS EMOCIONES DE COMIENZO HABITUAL EN LA INFANCIA Y ADOLESCENCIA";
      							}
                    if ($nombre_descripcion == "05970016"){
                        $nombre_descripcion = "TRASTORNO DE ESTRÉS POST TRAUMATICO";
      							}
                    if ($nombre_descripcion == "05970017"){
                        $nombre_descripcion = "TRASTORNO DE PANICO CON AGOROFOBIA";
      							}
                    if ($nombre_descripcion == "05970018"){
                        $nombre_descripcion = "TRASTORNO DE PANICO SIN AGOROFOBIA";
      							}
                    if ($nombre_descripcion == "05970019"){
                        $nombre_descripcion = "FOBIAS SOCIALES";
      							}
                    if ($nombre_descripcion == "05970020"){
                        $nombre_descripcion = "TRASTORNOS DE ANSIEDAD GENERALIZADA";
      							}
                    if ($nombre_descripcion == "05970021"){
                        $nombre_descripcion = "OTROS TRASTORNOS DE ANSIEDAD";
      							}
                    if ($nombre_descripcion == "05901801"){
                        $nombre_descripcion = "LEVE";
      							}
      							if ($nombre_descripcion == "05901802"){
                        $nombre_descripcion = "MODERADO";
      							}
      							if ($nombre_descripcion == "05901803"){
                        $nombre_descripcion = "AVANZADO";
      							}
                    if ($nombre_descripcion == "06902000"){
                        $nombre_descripcion = "ESQUIZOFRENIA";
                    }
      							if ($nombre_descripcion == "06902100"){
      								$nombre_descripcion = "TRANSTORNO DE LA CONDUCTA ALIMENTARIA";
      							}
      							if ($nombre_descripcion == "06902400"){
      								$nombre_descripcion = "RETRASO MENTAL";
      							}
      							if ($nombre_descripcion == "06902500"){
      								$nombre_descripcion = "TRANSTORNO DE PERSONALIDAD";
      							}
      							if ($nombre_descripcion == "06902600"){
      								$nombre_descripcion = "TRANSTORNO GENERALIZADO DEL DESARROLLO";
      							}
                    if ($nombre_descripcion == "05970022"){
      								$nombre_descripcion = "EPILEPSIA";
      							}
      							if ($nombre_descripcion == "05810445"){
      								$nombre_descripcion = "OTRAS";
      							}
                    ?>
                <tr>
                    <?php
                    if($i==0){?>
                    <td rowspan="2" style="text-align:center; vertical-align:middle">VIOLENCIA</td>
                    <?php
                    }
                    if($i>=0 && $i<=1){?>
                    <td align='left' nowrap><?php echo $nombre_descripcion; ?></td>
                    <?php
                    }
                    if($i==2){?>
                    <td colspan="2" align='left'><?php echo $nombre_descripcion; ?></td>
                    <?php
                    }
                    if($i==3){?>
                    <td rowspan="2" style="text-align:center; vertical-align:middle">SUICIDIO</td>
                    <?php
                    }
                    if($i>=3 && $i<=4){?>
                    <td align='left' nowrap><?php echo $nombre_descripcion; ?></td>
                    <?php
                    }
                    if($i==5){?>
                    <td colspan="2" align='left'><?php echo $nombre_descripcion; ?></td>
                    <?php
                    }
                    if($i==6){?>
                    <td rowspan="8" style="text-align:center; vertical-align:middle">TRASTORNOS DEL HUMOR(AFECTIVOS)</td>
                    <?php
                    }
                    if($i>=6 && $i<=13){?>
                    <td align='left' nowrap><?php echo $nombre_descripcion; ?></td>
                    <?php
                    }
                    if($i==14){?>
                    <td rowspan="3" style="text-align:center; vertical-align:middle">TRASTORNOS MENTALES Y DEL COMPORTAMIENTO DEBIDO A CONSUMO SUSTANCIAS PSICOTRÓPICAS</td>
                    <?php
                    }
                    if($i>=14 && $i<=16){?>
                    <td align='left'><?php echo $nombre_descripcion; ?></td>
                    <?php
                    }
                    if($i==17){?>
                    <td rowspan="4" style="text-align:center; vertical-align:middle">TRASTORNOS DEL COMPORTAMIENTO Y DE LAS EMOCIONES DE COMIENZO HABITUAL EN LA INFANCIA Y ADOLESCENCIA</td>
                    <?php
                    }
                    if($i>=17 && $i<=20){?>
                    <td align='left'><?php echo $nombre_descripcion; ?></td>
                    <?php
                    }
                    if($i==21){?>
                    <td rowspan="6" style="text-align:center; vertical-align:middle">TRASTORNOS DE ANSIEDAD</td>
                    <?php
                    }
                    if($i>=21 && $i<=26){?>
                    <td align='left' nowrap><?php echo $nombre_descripcion; ?></td>
                    <?php
                    }
                    if($i==27){?>
                    <td rowspan="3" style="text-align:center; vertical-align:middle">DEMENCIAS (INCLUYE ALZHEIMER)</td>
                    <?php
                    }
                    if($i>=27 && $i<=29){?>
                    <td align='left' nowrap><?php echo $nombre_descripcion; ?></td>
                    <?php
                    }
                    if($i>=30){?>
                    <td colspan="2" align='left'><?php echo $nombre_descripcion; ?></td>
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
                    <?php
                    $i++;
                }
                ?>
                </tr>
            </tbody>
        </table>
    </div>

    <br>

    <div class="col-sm tab table-responsive" id="O">
        <table class="table table-hover table-bordered table-sm">
            <thead>
                <tr>
                    <td colspan="48" class="active"><strong>SECCIÓN O: EGRESOS DEL PROGRAMA DE SALUD  MENTAL POR ALTAS CLÍNICAS EN APS /ESPECIALIDAD.</strong></td>
                </tr>
                    <td rowspan='2' colspan='2' align='center' style="text-align:center; vertical-align:middle"><strong>MOTIVO DE EGRESO</strong></td>
                    <td colspan='3' align='center'><strong>TOTAL</strong></td>
                    <td colspan='2' align='center'><strong>0 - 4 años</strong></td>
                    <td colspan='2' align='center'><strong>5 - 9 años</strong></td>
                    <td colspan='2' align='center'><strong>10 - 14 años</strong></td>
                    <td colspan='2' align='center'><strong>15 - 19 años</strong></td>
                    <td colspan='2' align='center'><strong>20 - 24 años</strong></td>
                    <td colspan='2' align='center'><strong>25 - 29 años</strong></td>
                    <td colspan='2' align='center'><strong>30 - 34 años</strong></td>
                    <td colspan='2' align='center'><strong>35 - 39 años</strong></td>
                    <td colspan='2' align='center'><strong>40 - 44 años</strong></td>
                    <td colspan='2' align='center'><strong>45 - 49 años</strong></td>
                    <td colspan='2' align='center'><strong>50 - 54 años</strong></td>
                    <td colspan='2' align='center'><strong>55 - 59 años</strong></td>
                    <td colspan='2' align='center'><strong>60 - 64 años</strong></td>
                    <td colspan='2' align='center'><strong>65 - 69 años</strong></td>
                    <td colspan='2' align='center'><strong>70 - 74 años</strong></td>
                    <td colspan='2' align='center'><strong>75 - 79 años</strong></td>
                    <td colspan='2' align='center'><strong>80 años y más</strong></td>
                    <td colspan='3' align='center'><strong>EGRESOS</strong></td>
                    <td rowspan='2' align='center'><strong>GESTANTE</strong></td>
                    <td rowspan='2' align='center'><strong>MADRE DE NIÑO MENOR DE 5 AÑOS</strong></td>
                    <td colspan='2' align='center'><strong>PUEBLOS ORIGINARIOS</strong></td>
                    <td rowspan='2' align='center'><strong>Niños, Niñas, Adolescentes y Jóvenes Población SENAME</strong></td>
                    <td rowspan='2' align='center'><strong>MIGRANTES</strong></td>
                </tr>
                <tr>
                    <td align='center'><strong>AMBOS SEXOS</strong></td>
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
                    <td align='center'><strong>Mujeres</strong></td>
                    <td align='center'><strong>Hombres</strong></td>
                    <td align='center'><strong>Mujeres</strong></td>
                    <td align='center'><strong>Hombres</strong></td>
                    <td align='center'><strong>Mujeres</strong></td>
                    <td align='center'><strong>Mujeres</strong></td>
                    <td align='center'><strong>Hombres</strong></td>
                    <td align='center'><strong>Mujeres</strong></td>
                    <td align='center'><strong>Hombres</strong></td>
                    <td align='center'><strong>Mujeres</strong></td>
                    <td align='center'><strong>Hombres</strong></td>
                    <td align='center'><strong>Mujeres</strong></td>
                    <td align='center'><strong></strong></td>
                    <td align='center'><strong></strong></td>
                    <td align='center'><strong></strong></td>
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
            									,sum(ifnull(b.Col42,0)) Col42
            									,sum(ifnull(b.Col43,0)) Col43
                              ,sum(ifnull(b.Col44,0)) Col44
                              ,sum(ifnull(b.Col45,0)) Col45
                              ,sum(ifnull(b.Col46,0)) Col46
                          FROM (select c.* from 2019prestaciones c where c.codigo_prestacion in("05810140")) a
                          left join 2019rems b on (a.id_prestacion=b.prestacion_id_prestacion)
                          AND (b.Mes in ('.$mes.')) AND (b.establecimiento_id_establecimiento in ('.$estab.'))
                          group by a.codigo_prestacion, a.descripcion, a.id_prestacion
                          order by a.id_prestacion';
                $registro = DB::connection('mysql_rem')->select($query);

                $i=0;

                foreach($registro as $row ){
                    $nombre_descripcion = $row->codigo_prestacion;
                    if ($nombre_descripcion == "05810140"){
                        $nombre_descripcion = "	EGRESOS AL PROGRAMA";
                    }
                    ?>
                <tr>
                    <td colspan="2" align='left'><?php echo $nombre_descripcion; ?></td>
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
                    <?php
                    $i++;
                }
                ?>
                </tr>
                <tr>
                    <td colspan="2" align='left' nowrap><strong>FACTORES DE RIESGO Y CONDICIONANTES DE LA SALUD MENTAL</strong></td>
                    <td colspan="46" align='left'></td>
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
                          FROM (select c.* from 2019prestaciones c where c.codigo_prestacion in("05223100","05223200",
                                                                                                "05223500",
                                                                                                "05970023","05970024",
                                                                                                "05810442",
                                                                                                "05223600","06902607","06902608","05223700","05223800","05051900","05052000","05052100",
                                                                                                "05223900","05224000","05224100",
                                                                                                "05224600","05052200","05052300","05224700",
                                                                                                "05970025","05970026","05970027","05970028","05970029","05970030",
                                                                                                "05224201","05224202","05224203",
                                                                                                "05224400","05224500","05224800","05224900","05225000","05970031","05810446")) a
                          left join 2019rems b on (a.id_prestacion=b.prestacion_id_prestacion)
                          AND (b.Mes in ('.$mes.')) AND (b.establecimiento_id_establecimiento in ('.$estab.'))
                          group by a.codigo_prestacion, a.descripcion, a.id_prestacion
                          order by a.id_prestacion';
                $registro = DB::connection('mysql_rem')->select($query);

                $i=0;

                foreach($registro as $row ){
                    $nombre_descripcion = $row->codigo_prestacion;
                    if ($nombre_descripcion == "05223100"){
                        $nombre_descripcion = "VICTIMA";
                    }
                    if ($nombre_descripcion == "05223200"){
                        $nombre_descripcion = "AGRESOR / A";
                    }
                    if ($nombre_descripcion == "05223500"){
                        $nombre_descripcion = "ABUSO SEXUAL";
                    }
                    if ($nombre_descripcion == "05970023"){
                        $nombre_descripcion = "IDEACIÓN";
                    }
                    if ($nombre_descripcion == "05970024"){
                        $nombre_descripcion = "INTENTO";
                    }
                    if ($nombre_descripcion == "05810442"){
                        $nombre_descripcion = "PERSONAS CON DIAGNÓSTICOS DE TRASTORNOS MENTALES";
                    }
                    if ($nombre_descripcion == "05223600"){
                        $nombre_descripcion = "DEPRESIÓN LEVE";
      							}
      							if ($nombre_descripcion == "06902607"){
                        $nombre_descripcion = "DEPRESIÓN MODERADA";
      							}
      							if ($nombre_descripcion == "06902608"){
                        $nombre_descripcion = "DEPRESIÓN GRAVE";
      							}
      							if ($nombre_descripcion == "05223700"){
                        $nombre_descripcion = "DEPRESIÓN POST PARTO";
      							}
      							if ($nombre_descripcion == "05223800"){
                        $nombre_descripcion = "TRANSTORNO BIPOLAR";
      							}
      							if ($nombre_descripcion == "05051900"){
                        $nombre_descripcion = "DEPRESIÓN REFRACTARIA";
      							}
      							if ($nombre_descripcion == "05052000"){
                        $nombre_descripcion = "DEPRESIÓN GRAVE CON PSICOSIS";
      							}
      							if ($nombre_descripcion == "05052100"){
                        $nombre_descripcion = "DEPRESIÓN CON ALTO RIESGO SUICIDA";
      							}
                    if ($nombre_descripcion == "05223900"){
                        $nombre_descripcion = "CONSUMO PERJUDICIAL O DEPENDENCIA DE ALCOHOL";
                    }
                    if ($nombre_descripcion == "05224000"){
                        $nombre_descripcion = "CONSUMO PERJUDICIAL O DEPENDENCIA COMO DROGA PRINCIPAL";
                    }
                    if ($nombre_descripcion == "05224100"){
                        $nombre_descripcion = "POLICONSUMO";
                    }
                    if ($nombre_descripcion == "05224600"){
                        $nombre_descripcion = "TRANSTORNO HIPERCINÉTICOS";
      							}
      							if ($nombre_descripcion == "05052200"){
                        $nombre_descripcion = "TRANSTORNO DISOCIAL DESAFIANTE Y OPOSICIONISTA";
      							}
      							if ($nombre_descripcion == "05052300"){
                        $nombre_descripcion = "TRANSTORNO DE ANSIEDAD DE SEPARACIÓN EN LA INFANCIA";
      							}
      							if ($nombre_descripcion == "05224700"){
                        $nombre_descripcion = "OTROS TRASTORNOS DEL COMPORTAMIENTO Y DE LAS EMOCIONES DE COMIENZO HABITUAL EN LA INFANCIA Y ADOLESCENCIA";
      							}
                    if ($nombre_descripcion == "05970025"){
                        $nombre_descripcion = "TRASTORNO DE ESTRÉS POST TRAUMATICO";
      							}
                    if ($nombre_descripcion == "05970026"){
                        $nombre_descripcion = "TRASTORNO DE PANICO CON AGOROFOBIA";
      							}
                    if ($nombre_descripcion == "05970027"){
                        $nombre_descripcion = "TRASTORNO DE PANICO SIN AGOROFOBIA";
      							}
                    if ($nombre_descripcion == "05970028"){
                        $nombre_descripcion = "FOBIAS SOCIALES";
      							}
                    if ($nombre_descripcion == "05970029"){
                        $nombre_descripcion = "TRASTORNOS DE ANSIEDAD GENERALIZADA";
      							}
                    if ($nombre_descripcion == "05970030"){
                        $nombre_descripcion = "OTROS TRASTORNOS DE ANSIEDAD";
      							}
                    if ($nombre_descripcion == "05224201"){
                        $nombre_descripcion = "LEVE";
      							}
      							if ($nombre_descripcion == "05224202"){
                        $nombre_descripcion = "MODERADO";
      							}
      							if ($nombre_descripcion == "05224203"){
                        $nombre_descripcion = "AVANZADO";
      							}
                    if ($nombre_descripcion == "05224400"){
                        $nombre_descripcion = "ESQUIZOFRENIA";
                    }
      							if ($nombre_descripcion == "05224500"){
      								$nombre_descripcion = "TRANSTORNO DE LA CONDUCTA ALIMENTARIA";
      							}
      							if ($nombre_descripcion == "05224800"){
      								$nombre_descripcion = "RETRASO MENTAL";
      							}
      							if ($nombre_descripcion == "05224900"){
      								$nombre_descripcion = "TRANSTORNO DE PERSONALIDAD";
      							}
      							if ($nombre_descripcion == "05225000"){
      								$nombre_descripcion = "TRANSTORNO GENERALIZADO DEL DESARROLLO";
      							}
                    if ($nombre_descripcion == "05970031"){
      								$nombre_descripcion = "EPILEPSIA";
      							}
      							if ($nombre_descripcion == "05810446"){
      								$nombre_descripcion = "OTRAS";
      							}
                    ?>
                <tr>
                    <?php
                    if($i==0){?>
                    <td rowspan="2" style="text-align:center; vertical-align:middle">VIOLENCIA</td>
                    <?php
                    }
                    if($i>=0 && $i<=1){?>
                    <td align='left' nowrap><?php echo $nombre_descripcion; ?></td>
                    <?php
                    }
                    if($i==2){?>
                    <td colspan="2" align='left'><?php echo $nombre_descripcion; ?></td>
                    <?php
                    }
                    if($i==3){?>
                    <td rowspan="2" style="text-align:center; vertical-align:middle">SUICIDIO</td>
                    <?php
                    }
                    if($i>=3 && $i<=4){?>
                    <td align='left' nowrap><?php echo $nombre_descripcion; ?></td>
                    <?php
                    }
                    if($i==5){?>
                    <td colspan="2" align='left'><?php echo $nombre_descripcion; ?></td>
                    <?php
                    }
                    if($i==6){?>
                    <td rowspan="8" style="text-align:center; vertical-align:middle">TRASTORNOS DEL HUMOR(AFECTIVOS)</td>
                    <?php
                    }
                    if($i>=6 && $i<=13){?>
                    <td align='left' nowrap><?php echo $nombre_descripcion; ?></td>
                    <?php
                    }
                    if($i==14){?>
                    <td rowspan="3" style="text-align:center; vertical-align:middle">TRASTORNOS MENTALES Y DEL COMPORTAMIENTO DEBIDO A CONSUMO SUSTANCIAS PSICOTRÓPICAS</td>
                    <?php
                    }
                    if($i>=14 && $i<=16){?>
                    <td align='left'><?php echo $nombre_descripcion; ?></td>
                    <?php
                    }
                    if($i==17){?>
                    <td rowspan="4" style="text-align:center; vertical-align:middle">TRASTORNOS DEL COMPORTAMIENTO Y DE LAS EMOCIONES DE COMIENZO HABITUAL EN LA INFANCIA Y ADOLESCENCIA</td>
                    <?php
                    }
                    if($i>=17 && $i<=20){?>
                    <td align='left'><?php echo $nombre_descripcion; ?></td>
                    <?php
                    }
                    if($i==21){?>
                    <td rowspan="6" style="text-align:center; vertical-align:middle">TRASTORNOS DE ANSIEDAD</td>
                    <?php
                    }
                    if($i>=21 && $i<=26){?>
                    <td align='left' nowrap><?php echo $nombre_descripcion; ?></td>
                    <?php
                    }
                    if($i==27){?>
                    <td rowspan="3" style="text-align:center; vertical-align:middle">DEMENCIAS (INCLUYE ALZHEIMER)</td>
                    <?php
                    }
                    if($i>=27 && $i<=29){?>
                    <td align='left' nowrap><?php echo $nombre_descripcion; ?></td>
                    <?php
                    }
                    if($i>=30){?>
                    <td colspan="2" align='left'><?php echo $nombre_descripcion; ?></td>
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
                    <?php
                    $i++;
                }
                ?>
                </tr>
            </tbody>
        </table>
    </div>

    <br>

    <div class="col-sm tab table-responsive" id="P">
        <table class="table table-hover table-bordered table-sm">
            <thead>
                <tr>
                    <td colspan="37" class="active"><strong>SECCIÓN P: INGRESOS Y EGRESOS AL COMPONENTE ALCOHOL Y DROGA EN APS/ESPECIALIDAD.</strong></td>
                </tr>
                <tr>
                    <td colspan="2" rowspan='2' style="text-align:center; vertical-align:middle"><strong>CONCEPTO</strong></td>
                    <td colspan='3' align='center'><strong>TOTAL</strong></td>
                    <td colspan='2' align='center'><strong>5 - 9 años</strong></td>
                    <td colspan='2' align='center'><strong>10 - 14 años</strong></td>
                    <td colspan='2' align='center'><strong>15 - 19 años</strong></td>
                    <td colspan='2' align='center'><strong>20 - 24 años</strong></td>
                    <td colspan='2' align='center'><strong>25 - 29 años</strong></td>
                    <td colspan='2' align='center'><strong>30 - 34 años</strong></td>
                    <td colspan='2' align='center'><strong>35 - 39 años</strong></td>
                    <td colspan='2' align='center'><strong>40 - 44 años</strong></td>
                    <td colspan='2' align='center'><strong>45 - 49 años</strong></td>
                    <td colspan='2' align='center'><strong>50 - 54 años</strong></td>
                    <td colspan='2' align='center'><strong>55 - 59 años</strong></td>
                    <td colspan='2' align='center'><strong>60 - 64 años</strong></td>
                    <td colspan='2' align='center'><strong>65 - 69 años</strong></td>
                    <td colspan='2' align='center'><strong>70 - 74 años</strong></td>
                    <td colspan='2' align='center'><strong>75 - 79 años</strong></td>
                    <td colspan='2' align='center'><strong>80 años y más</strong></td>
                </tr>
                <tr>
                    <td align='center'><strong>AMBOS SEXOS</strong></td>
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
                          FROM (select c.* from 2019prestaciones c where c.codigo_prestacion in("05970032","05970033","05970034","05970035")) a
                          left join 2019rems b on (a.id_prestacion=b.prestacion_id_prestacion)
                          AND (b.Mes in ('.$mes.')) AND (b.establecimiento_id_establecimiento in ('.$estab.'))
                          group by a.codigo_prestacion, a.descripcion, a.id_prestacion
                          order by a.id_prestacion';
                $registro = DB::connection('mysql_rem')->select($query);

                $i=0;

                foreach($registro as $row ){
                    $nombre_descripcion = $row->codigo_prestacion;
                    if ($nombre_descripcion == "05970032"){
                        $nombre_descripcion = "INGRESO";
                    }
                    if ($nombre_descripcion == "05970033"){
                        $nombre_descripcion = "EGRESOS";
                    }
                    if ($nombre_descripcion == "05970034"){
                        $nombre_descripcion = "INGRESO";
                    }
                    if ($nombre_descripcion == "05970035"){
                        $nombre_descripcion = "EGRESOS";
                    }
                    ?>
                <tr>
                    <?php
                    if($i==0){?>
                    <td rowspan="2" style="text-align:center; vertical-align:middle">PLAN AMBULATORIO BÁSICO</td>
                    <?php
                    }
                    if($i==2){?>
                    <td rowspan="2" style="text-align:center; vertical-align:middle">PLAN AMBULATORIO INTENSIVO</td>
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

    <br>

    <div class="col-sm tab table-responsive" id="Q">
        <table class="table table-hover table-bordered table-sm">
            <thead>
                <tr>
                    <td colspan="38" class="active"><strong>SECCIÓN Q:  PROGRAMA DE REHABILITACIÓN (PERSONAS CON TRASTORNOS PSIQUIÁTRICOS).</strong></td>
                </tr>
                <tr>
                    <td rowspan='3' align='center' style="text-align:center; vertical-align:middle"><strong>TIPO DE PROGRAMA</strong></td>
                    <td rowspan='3' align='center' style="text-align:center; vertical-align:middle"><strong>RUBRO</strong></td>
                    <td rowspan='2' colspan="3" align='center' style="text-align:center; vertical-align:middle"><strong>TOTAL</strong></td>
                    <td colspan='32' align='center'><strong>GRUPOS DE EDAD(en años)</strong></td>
                    <td rowspan='3' align='center' style="text-align:center; vertical-align:middle"><strong>A BENEFI-CIARIOS</strong></td>
                </tr>
                <tr>
                    <td align='center' colspan='2'><strong>5 a 9</strong></td>
                    <td align='center' colspan='2'><strong>10 a 14</strong></td>
                    <td align='center' colspan='2'><strong>15 a 19</strong></td>
                    <td align='center' colspan='2'><strong>20 a 24</strong></td>
                    <td align='center' colspan='2'><strong>25 a 29</strong></td>
                    <td align='center' colspan='2'><strong>30 a 34</strong></td>
                    <td align='center' colspan='2'><strong>35 a 39</strong></td>
                    <td align='center' colspan='2'><strong>40 a 44</strong></td>
                    <td align='center' colspan='2'><strong>45 a 49</strong></td>
                    <td align='center' colspan='2'><strong>50 a 54</strong></td>
                    <td align='center' colspan='2'><strong>55 a 59</strong></td>
                    <td align='center' colspan='2'><strong>60 a 64</strong></td>
                    <td align='center' colspan='2'><strong>65 a 69</strong></td>
                    <td align='center' colspan='2'><strong>70 a 74</strong></td>
                    <td align='center' colspan='2'><strong>75 a 79</strong></td>
                    <td align='center' colspan='2'><strong>80 y más</strong></td>
                </tr>
                <tr>
                    <td align='center'><strong>Ambos Sexos</strong></td>
                    <td align='center'><strong>HOMBRES</strong></td>
                    <td align='center'><strong>MUJERES</strong></td>
                    <td align='center'><strong>HOMBRES</strong></td>
                    <td align='center'><strong>MUJERES</strong></td>
                    <td align='center'><strong>HOMBRES</strong></td>
                    <td align='center'><strong>MUJERES</strong></td>
                    <td align='center'><strong>HOMBRES</strong></td>
                    <td align='center'><strong>MUJERES</strong></td>
                    <td align='center'><strong>HOMBRES</strong></td>
                    <td align='center'><strong>MUJERES</strong></td>
                    <td align='center'><strong>HOMBRES</strong></td>
                    <td align='center'><strong>MUJERES</strong></td>
                    <td align='center'><strong>HOMBRES</strong></td>
                    <td align='center'><strong>MUJERES</strong></td>
                    <td align='center'><strong>HOMBRES</strong></td>
                    <td align='center'><strong>MUJERES</strong></td>
                    <td align='center'><strong>HOMBRES</strong></td>
                    <td align='center'><strong>MUJERES</strong></td>
                    <td align='center'><strong>HOMBRES</strong></td>
                    <td align='center'><strong>MUJERES</strong></td>
                    <td align='center'><strong>HOMBRES</strong></td>
                    <td align='center'><strong>MUJERES</strong></td>
                    <td align='center'><strong>HOMBRES</strong></td>
                    <td align='center'><strong>MUJERES</strong></td>
                    <td align='center'><strong>HOMBRES</strong></td>
                    <td align='center'><strong>MUJERES</strong></td>
                    <td align='center'><strong>HOMBRES</strong></td>
                    <td align='center'><strong>MUJERES</strong></td>
                    <td align='center'><strong>HOMBRES</strong></td>
                    <td align='center'><strong>MUJERES</strong></td>
                    <td align='center'><strong>HOMBRES</strong></td>
                    <td align='center'><strong>MUJERES</strong></td>
                    <td align='center'><strong>HOMBRES</strong></td>
                    <td align='center'><strong>MUJERES</strong></td>
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
                          FROM (select c.* from 2019prestaciones c where c.codigo_prestacion in("05810210","05810220","05810230","05810240")) a
                          left join 2019rems b on (a.id_prestacion=b.prestacion_id_prestacion)
                          AND (b.Mes in ('.$mes.')) AND (b.establecimiento_id_establecimiento in ('.$estab.'))
                          group by a.codigo_prestacion, a.descripcion, a.id_prestacion
                          order by a.id_prestacion';
                $registro = DB::connection('mysql_rem')->select($query);

                $i=0;

                foreach($registro as $row ){
                    $nombre_descripcion = $row->codigo_prestacion;
                    if ($nombre_descripcion == "05810210"){
                        $nombre_descripcion = "INGRESOS";
                    }
                    if ($nombre_descripcion == "05810220"){
                        $nombre_descripcion = "EGRESOS";
                    }
                    if ($nombre_descripcion == "05810230"){
                        $nombre_descripcion = "INGRESOS";
                    }
                    if ($nombre_descripcion == "05810240"){
                        $nombre_descripcion = "EGRESOS";
                    }
                    ?>
                <tr>
                    <?php
                    if($i==0){?>
                    <td rowspan="2" style="text-align:center; vertical-align:middle">PROGRAMA DE REHABILITACIÓN TIPO I</td>
                    <?php
                    }
                    if($i==2){?>
                    <td rowspan="2" style="text-align:center; vertical-align:middle">PROGRAMA DE REHABILITACIÓN TIPO II</td>
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
                    <?php
                    $i++;
                }
                ?>
                </tr>
            </tbody>
        </table>
    </div>

    <br>

    <div class="col-sm tab table-responsive" id="R">
        <table class="table table-hover table-bordered table-sm">
            <thead>
                <tr>
                    <td colspan="47" class="active"><strong>SECCIÓN R: INGRESOS Y EGRESOS A PROGRAMA INFECCIÓN POR TRANSMISIÓN SEXUAL (Uso de establecimientos que realizan atención de ITS).</strong></td>
                </tr>
                <tr>
   	                <td rowspan='3' colspan='2' style="text-align:center; vertical-align:middle"><strong>PATOLOGÍAS</strong></td>
                    <td colspan='3' style="text-align:center; vertical-align:middle"><strong>TOTAL</strong></td>
                    <td colspan='34' align='center'><strong>INGRESOS POR EDAD</strong></td>
                    <td colspan='3' align='center'><strong>EGRESOS</strong></td>
                    <td colspan="2" style="text-align:center; vertical-align:middle"><strong>TRANS</strong></td>
                    <td rowspan='3' style="text-align:center; vertical-align:middle"><strong>PUEBLOS ORIGINARIOS</strong></td>
                    <td rowspan='3' style="text-align:center; vertical-align:middle"><strong>MIGRANTES</strong></td>
                    <td rowspan='3' style="text-align:center; vertical-align:middle"><strong>Niños, Niñas, Adolescentes y Jóvenes Población  SENAME</strong></td>
                </tr>
                <tr>
                    <td rowspan='2' align='center'><strong>Ambos sexos</strong></td>
                    <td rowspan='2' align='center'><strong>Hombres</strong></td>
                    <td rowspan='2' align='center'><strong>Mujeres</strong></td>
                    <td colspan='2' align='center'><strong>0 a 4</strong></td>
                    <td colspan='2' align='center'><strong>5 a 9</strong></td>
                    <td colspan='2' align='center'><strong>10 a 14</strong></td>
                    <td colspan='2' align='center'><strong>15 a 19</strong></td>
                    <td colspan='2' align='center'><strong>20 a 24</strong></td>
                    <td colspan='2' align='center'><strong>25 a 29</strong></td>
                    <td colspan='2' align='center'><strong>30 a 34</strong></td>
                    <td colspan='2' align='center'><strong>35 a 39</strong></td>
                    <td colspan='2' align='center'><strong>40 a 44</strong></td>
                    <td colspan='2' align='center'><strong>45 a 49</strong></td>
                    <td colspan='2' align='center'><strong>50 a 54</strong></td>
                    <td colspan='2' align='center'><strong>55 a 59</strong></td>
                    <td colspan='2' align='center'><strong>60 a 64</strong></td>
                    <td colspan='2' align='center'><strong>65 a 69</strong></td>
                    <td colspan='2' align='center'><strong>70 a 74</strong></td>
                    <td colspan='2' align='center'><strong>75 a 79</strong></td>
                    <td colspan='2' align='center'><strong>80 y más</strong></td>
                    <td rowspan='2' align='center'><strong>TOTAL</strong></td>
                    <td rowspan='2' align='center'><strong>POR ALTA</strong></td>
                    <td rowspan='2' align='center'><strong>POR ABANDONO</strong></td>
                    <td rowspan='2' align='center'><strong>MASCULINO</strong></td>
                    <td rowspan='2' align='center'><strong>FEMENINO</strong></td>
                </tr>
                <tr>
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
            									,sum(ifnull(b.Col42,0)) Col42
            									,sum(ifnull(b.Col43,0)) Col43
            									,sum(ifnull(b.Col44,0)) Col44
            									,sum(ifnull(b.Col45,0)) Col45
                          FROM (select c.* from 2019prestaciones c where c.codigo_prestacion in("05810241","05810242","05810243","05810244","05810245","05810246","05810247","05810248","05810249",
                                                                                                "05810250","05810251","05810252","05810253","05810254","05810255","05810256","05810257","05810258")) a
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
                }
                ?>
                <tr>
                    <td colspan="2" align='left'><strong>TOTAL DE INGRESOS</strong></td>
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
                </tr>
                <?php
                foreach($registro as $row ){
                    $nombre_descripcion = $row->codigo_prestacion;
                    if ($nombre_descripcion == "05810241"){
                        $nombre_descripcion = "SIFILIS";
                    }
                    if ($nombre_descripcion == "05810242"){
                        $nombre_descripcion = "GONORREA";
                    }
      							if ($nombre_descripcion == "05810243"){
                        $nombre_descripcion = "CONDILOMA";
      							}
      							if ($nombre_descripcion == "05810244"){
                        $nombre_descripcion = "HERPES";
      							}

      							if ($nombre_descripcion == "05810245"){
                        $nombre_descripcion = "CHLAMYDIAS";
      							}
      							if ($nombre_descripcion == "05810246"){
                        $nombre_descripcion = "URETRITIS NO GONOCÓCICA";
      							}
      							if ($nombre_descripcion == "05810247"){
                        $nombre_descripcion = "LINFOGRANULOMA";
      							}
      							if ($nombre_descripcion == "05810248"){
                        $nombre_descripcion = "CHANCROIDE";
      							}
      							if ($nombre_descripcion == "05810249"){
                        $nombre_descripcion = "OTRAS ITS";
      							}
      							if ($nombre_descripcion == "05810250"){
                        $nombre_descripcion = "SIFILIS";
      							}
      							if ($nombre_descripcion == "05810251"){
                        $nombre_descripcion = "GONORREA";
      							}
      							if ($nombre_descripcion == "05810252"){
                        $nombre_descripcion = "CONDILOMA";
      							}
      							if ($nombre_descripcion == "05810253"){
                        $nombre_descripcion = "HERPES";
      							}
      							if ($nombre_descripcion == "05810254"){
                        $nombre_descripcion = "CHLAMYDIAS";
      							}
      							if ($nombre_descripcion == "05810255"){
                        $nombre_descripcion = "URETRITIS NO GONOCÓCICA";
      							}
      							if ($nombre_descripcion == "05810256"){
                        $nombre_descripcion = "LINFOGRANULOMA";
      							}
      							if ($nombre_descripcion == "05810257"){
                        $nombre_descripcion = "CHANCROIDE";
      							}
      							if ($nombre_descripcion == "05810258"){
                        $nombre_descripcion = "OTRAS ITS";
      							}
                    ?>
                <tr>
                    <?php
                    if($i==0){?>
                    <td rowspan="9" style="text-align:center; vertical-align:middle">GESTANTES</td>
                    <?php
                    }
                    if($i==9){?>
                    <td rowspan="9" style="text-align:center; vertical-align:middle">NO GESTANTES</td>
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
                    <?php
                    $i++;
                }
                ?>
                </tr>
            </tbody>
        </table>
    </div>

    <br>

    <div class="col-sm tab table-responsive" id="S">
        <table class="table table-hover table-bordered table-sm">
            <thead>
                <tr>
                    <td colspan="49" class="active"><strong>SECCIÓN S: INGRESOS Y EGRESOS DEL PROGRAMA DE VIH/SIDA (Uso exclusivo Centros de Atención VIH-SIDA).</strong></td>
                </tr>
                <tr>
                    <td colspan="2" rowspan="3" style="text-align:center; vertical-align:middle"><strong>CONCEPTO</strong></td>
                    <td colspan="3" rowspan="2" style="text-align:center; vertical-align:middle"><strong>TOTAL</strong></td>
                    <td colspan="40" align="center"><strong>POR EDAD (en meses - años)</strong></td>
                    <td colspan="2" rowspan="2" align="center"><strong>TRANS</strong></td>
                    <td rowspan="3" align="center"><strong>Pueblos Originarios</strong></td>
                    <td rowspan="3" align="center"><strong>Migrantes</strong></td>
                </tr>
                <tr>
                    <td colspan="2" align="center"><strong>Menor de 6 meses</strong></td>
                    <td colspan="2" align="center"><strong>6 a 11 meses</strong></td>
                    <td colspan="2" align="center"><strong>12-24 meses</strong></td>
                    <td colspan="2" align="center"><strong>3 a 4</strong></td>
                    <td colspan="2" align="center"><strong>5 a 9</strong></td>
                    <td colspan="2" align="center"><strong>10 - 14</strong></td>
                    <td colspan="2" align="center"><strong>15 - 19</strong></td>
                    <td colspan="2" align="center"><strong>20 - 24</strong></td>
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
                    <td align="center"><strong>Hombres</strong></td>
                    <td align="center"><strong>Mujeres</strong></td>
                    <td align="center"><strong>Masculino</strong></td>
                    <td align="center"><strong>Femenino</strong></td>
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
                              ,sum(ifnull(b.Col47,0)) Col47
                          FROM (select c.* from 2019prestaciones c where c.codigo_prestacion in("05970036","05970037",
                                                                                                "05810370","05810410","05052300A",
                                                                                                "05052400","05052500","05052600")) a
                          left join 2019rems b on (a.id_prestacion=b.prestacion_id_prestacion)
                          AND (b.Mes in ('.$mes.')) AND (b.establecimiento_id_establecimiento in ('.$estab.'))
                          group by a.codigo_prestacion, a.descripcion, a.id_prestacion
                          order by a.id_prestacion';
                $registro = DB::connection('mysql_rem')->select($query);

                $i=0;

                foreach($registro as $row ){
                    $nombre_descripcion = $row->codigo_prestacion;
                    if ($nombre_descripcion == "05970036"){
                        $nombre_descripcion = "GESTANTES";
      							}
                    if ($nombre_descripcion == "05970037"){
                        $nombre_descripcion = "NO GESTANTES";
      							}
      							if ($nombre_descripcion == "05810370"){
                        $nombre_descripcion = "TOTAL EGRESOS";
      							}
      							if ($nombre_descripcion == "05810410"){
                        $nombre_descripcion = "EGRESOS POR FALLECIMIENTO (INCLUÍDO EN TOTAL EGRESOS)";
      							}
      							if ($nombre_descripcion == "05052300A"){
                        $nombre_descripcion = "EGRESOS POR ALTA HIJO VIH (-) DE MADRE VIH +INCLUÍDO EN TOTAL EGRESOS";
      							}
      							if ($nombre_descripcion == "05052400"){
                        $nombre_descripcion = "ABANDONO CONTROLES";
      							}
      							if ($nombre_descripcion == "05052500"){
                        $nombre_descripcion = "ABANDONO TRATAMIENTO";
      							}
      							if ($nombre_descripcion == "05052600"){
                        $nombre_descripcion = "ABANDONO DEL PROGRAMA";
      							}
                    ?>
                <tr>
                    <?php
                    if($i==0){ ?>
                    <td rowspan="2" style="text-align:center; vertical-align:middle">INGRESOS AL PROGRAMA</td>
                    <?php
                    }
                    if($i>=0 && $i<=1){ ?>
                    <td align='left'><?php echo $nombre_descripcion; ?></td>
                    <?php
                    }
                    if($i>=2 && $i<=4){ ?>
                    <td colspan="2" align='left'><?php echo $nombre_descripcion; ?></td>
                    <?php
                    }
                    if($i==5){ ?>
                    <td rowspan="3" style="text-align:center; vertical-align:middle">EVALUACIÓN MOVILIDAD PROGRAMA</td>
                    <?php
                    }
                    if($i>=5){ ?>
                    <td align='left' nowrap><?php echo $nombre_descripcion; ?></td>
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
                    <td align='right'><?php echo number_format($row->Col45,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col46,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col47,0,",",".")?></td>
                    <?php
                    $i++;
                }
                ?>
                </tr>
            </tbody>
        </table>
    </div>

    <br>

    <div class="col-sm tab table-responsive" id="T">
        <table class="table table-hover table-bordered table-sm">
            <thead>
                <tr>
                    <td colspan="36" class="active"><strong>SECCIÓN T: INGRESOS Y EGRESOS POR COMERCIO SEXUAL (Uso exclusivo de Unidades Control Comercio.</strong></td>
                </tr>
                <tr>
                    <td rowspan="3" style="text-align:center; vertical-align:middle"><strong>CONCEPTO</strong></td>
                    <td colspan="3" rowspan="2" style="text-align:center; vertical-align:middle"><strong>TOTAL</strong> </td>
                    <td colspan="28" align="center"><strong>GRUPOS DE EDAD (en años)</strong></td>
                    <td colspan="2" rowspan="2" align="center"><strong>TRANS</strong></td>
                    <td rowspan="3" align="center"><strong>Pueblos Originarios</strong></td>
                    <td rowspan="3" width="80"align="center"><strong>Migrantes</strong></td>
                </tr>
                <tr>
                    <td colspan="2" align="center"><strong>15 - 19</strong></td>
                    <td colspan="2" align="center"><strong>20 - 24</strong></td>
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
                          FROM (select c.* from 2019prestaciones c where c.codigo_prestacion in("05810420","05810430","05052700")) a
                          left join 2019rems b on (a.id_prestacion=b.prestacion_id_prestacion)
                          AND (b.Mes in ('.$mes.')) AND (b.establecimiento_id_establecimiento in ('.$estab.'))
                          group by a.codigo_prestacion, a.descripcion, a.id_prestacion
                          order by a.id_prestacion';
                $registro = DB::connection('mysql_rem')->select($query);

                $i=0;

                foreach($registro as $row ){
                    $nombre_descripcion = $row->codigo_prestacion;
                    if ($nombre_descripcion == "05810420"){
                        $nombre_descripcion = "INGRESOS AL PROGRAMA";
      							}
      							if ($nombre_descripcion == "05810430"){
                        $nombre_descripcion = "TOTAL EGRESOS";
      							}
      							if ($nombre_descripcion == "05052700"){
                        $nombre_descripcion = "INASISTENTES";
      							}
                    ?>
                <tr>
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
                    <?php
                    $i++;
                }
                ?>
                </tr>
            </tbody>
        </table>
    </div>

    <br>

    <div class="col-sm tab table-responsive" id="U">
        <table class="table table-hover table-bordered table-sm">
            <thead>
                <tr>
                    <td colspan="14" class="active"><strong>SECCIÓN U. INGRESOS Y EGRESOS PROGRAMA DE ACOMPAÑAMIENTO PSICOSOCIAL EN ATENCIÓN PRIMARIA.</strong></td>
                </tr>
                <tr>
                    <td rowspan="3" style="text-align:center; vertical-align:middle"><strong>ACTIVIDAD</strong></td>
                    <td colspan="3" rowspan="2" style="text-align:center; vertical-align:middle"><strong>TOTAL</strong></td>
                    <td colspan="10" align="center"><strong>GRUPOS DE EDAD (en años)</strong></td>
                </tr>
                <tr>
                    <td colspan="2" align="center"><strong>0 - 4</strong></td>
                    <td colspan="2" align="center"><strong>5 - 9</strong></td>
                    <td colspan="2" align="center"><strong>10 - 14</strong></td>
                    <td colspan="2" align="center"><strong>15 - 19</strong></td>
                    <td colspan="2" align="center"><strong>20 - 24</strong></td>
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
                          FROM (select c.* from 2019prestaciones c where c.codigo_prestacion in("05052701","05052702")) a
                          left join 2019rems b on (a.id_prestacion=b.prestacion_id_prestacion)
                          AND (b.Mes in ('.$mes.')) AND (b.establecimiento_id_establecimiento in ('.$estab.'))
                          group by a.codigo_prestacion, a.descripcion, a.id_prestacion
                          order by a.id_prestacion';
                $registro = DB::connection('mysql_rem')->select($query);

                $i=0;

                foreach($registro as $row ){
                    $nombre_descripcion = $row->codigo_prestacion;
                    if ($nombre_descripcion == "05052701"){
                        $nombre_descripcion = "INGRESOS";
      							}
      							if ($nombre_descripcion == "05052702"){
                        $nombre_descripcion = "EGRESOS";
      							}
                    ?>
                <tr>
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
