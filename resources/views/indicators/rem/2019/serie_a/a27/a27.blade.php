@extends('layouts.app')

@section('title', 'Resumen Estadistico Mensual')

@section('content')

<?php

use Illuminate\Support\Facades\DB;

?>

@include('indicators.rem.partials.nav')

<h3>REM-27. EDUCACIÓN PARA LA SALUD.</h3>

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
                    <td colspan="29" class="active"><strong>SECCIÓN A: PERSONAS QUE INGRESAN A EDUCACIÓN GRUPAL SEGÚN ÁREAS TEMÁTICAS Y EDAD.</strong></td>
                </tr>
                <tr>
                    <td colspan="3" rowspan="2" style="text-align:center; vertical-align:middle"><strong>ÁREAS TEMÁTICAS DE PREVENCIÓN</strong></td>
                    <td rowspan="2" style="text-align:center; vertical-align:middle"><strong>TOTAL</strong></td>
                    <td colspan="5" align="center"><strong>MADRE, PADRE O CUIDADOR DE :</strong></td>
                    <td colspan="15" align="center"><strong>GRUPO DE EDAD (en años)</strong></td>
                    <td colspan="2" align="center"><strong>GESTANTES</strong></td>
                    <td rowspan="2" align="center"><strong>GESTANTES ALTO RIESGO OBSTÉTRICO</strong></td>
                    <td rowspan="2" align="center"><strong>MUJERES EN EDADES DE CLIMATERIO 45 A 64 AÑOS</strong></td>
                    <td rowspan="2" align="center"><strong>FAMILIAS DE RIESGO</strong></td>
                </tr>
                <tr>
                    <td align="center"><strong>Menores de 1 año</strong></td>
                    <td align="center"><strong>Niños 12 a 23 meses</strong></td>
                    <td align="center"><strong>Niños de 2 a 5 años</strong></td>
                    <td align="center"><strong>Niños de 6 a 9 años</strong></td>
                    <td align="center" nowrap="nowrap"><strong>10 a 14 años</strong></td>
                    <td align="center" nowrap="nowrap"><strong>10 a 14</strong></td>
                    <td align="center" nowrap="nowrap"><strong>15 a 19</strong></td>
                    <td align="center" nowrap="nowrap"><strong>20 a 24</strong></td>
                    <td align="center" nowrap="nowrap"><strong>25 - 29</strong></td>
                    <td align="center" nowrap="nowrap"><strong>30 - 34</strong></td>
                    <td align="center" nowrap="nowrap"><strong>35 - 39</strong></td>
                    <td align="center" nowrap="nowrap"><strong>40 - 44</strong></td>
                    <td align="center" nowrap="nowrap"><strong>45 - 49</strong></td>
                    <td align="center" nowrap="nowrap"><strong>50 - 54</strong></td>
                    <td align="center" nowrap="nowrap"><strong>55 - 59</strong></td>
                    <td align="center" nowrap="nowrap"><strong>60 - 64</strong></td>
                    <td align="center" nowrap="nowrap"><strong>65 - 69</strong></td>
                    <td align="center" nowrap="nowrap"><strong>70 - 74</strong></td>
                    <td align="center" nowrap="nowrap"><strong>75 - 79</strong></td>
                    <td align="center" nowrap="nowrap"><strong>80 y mas</strong></td>
                    <td align="center"><strong>APS</strong></td>
                    <td align="center"><strong>Maternidad</strong></td>
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
                          FROM (select c.* from 2019prestaciones c where c.codigo_prestacion in("27280100",
                                                                                                "27280315","27280325","27280335","27500100",
                                                                                                "27280400","27280500","27280600","27280700","27280800","27500110","27300918",
                                                                                                "27300902","27300903","27300904","27300700","27400100","27400150",
                                                                                                "27290700",
                                                                                                "27300919","27300920",
                                                                                                "27300921","27290301","27400010","27281000",
                                                                                                "27281100","27281200","27281300",
                                                                                                "27300906",
                                                                                                "27500120")) a
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

                    $nombre_descripcion = $row->codigo_prestacion;
                    if ($nombre_descripcion == "27280100"){
                        $nombre_descripcion = "ESTIMULACIÓN DESARROLLO PSICOMOTOR";
      							}

      							if ($nombre_descripcion == "27280315"){
                        $nombre_descripcion = "RIESGO DE MALNUTRICION POR EXCESO";
      							}
      							if ($nombre_descripcion == "27280325"){
                        $nombre_descripcion = "MALNUTRICION POR EXCESO";
      							}
      							if ($nombre_descripcion == "27280335"){
                        $nombre_descripcion = "MALNUTRICION POR DEFICIT";
      							}
                    if ($nombre_descripcion == "27500100"){
                        $nombre_descripcion = "SIN RIESGO DE MALNUTRICIÓN";
      							}

      							if ($nombre_descripcion == "27280400"){
                        $nombre_descripcion = "PREVENCIÓN DE IRA - ERA";
      							}
      							if ($nombre_descripcion == "27280500"){
                        $nombre_descripcion = "PREVENCIÓN DE ACCIDENTES";
      							}
      							if ($nombre_descripcion == "27280600"){
                        $nombre_descripcion = "SALUD BUCO-DENTAL";
      							}
      							if ($nombre_descripcion == "27280700"){
                        $nombre_descripcion = "PREVENCIÓN VIOLENCIA DE GÉNERO";
      							}
      							if ($nombre_descripcion == "27280800"){
                        $nombre_descripcion = "SALUD SEXUAL Y REPRODUCTIVA";
      							}
                    if ($nombre_descripcion == "27500110"){
                        $nombre_descripcion = "EDUCACION PRENATAL (NUTRICION- LACTANCIA- CRIANZA- AUTOCUIDADO- PREPARACIÓN PARTO Y OTROS)";
      							}
      							if ($nombre_descripcion == "27300918"){
                        $nombre_descripcion = "PROMOCION DE SALUD MENTAL";
      							}

      							if ($nombre_descripcion == "27300902"){
                        $nombre_descripcion = "DEL LENGUAJE";
      							}

      							if ($nombre_descripcion == "27300903"){
                        $nombre_descripcion = 'MOTOR';
      							}
      							if ($nombre_descripcion == "27300904"){
                        $nombre_descripcion = 'OTROS';
      							}

      							if ($nombre_descripcion == "27300700"){
                        $nombre_descripcion = 'NADIE ES PERFECTO';
      							}
      							if ($nombre_descripcion == "27400100"){
                        $nombre_descripcion = 'FAMILIAS FUERTES';
      							}
      							if ($nombre_descripcion == "27400150"){
                        $nombre_descripcion = 'OTROS';
      							}

      							if ($nombre_descripcion == "27290600"){
                        $nombre_descripcion = "AUTOCUIDADO";
      							}
      							if ($nombre_descripcion == "27290700"){
                        $nombre_descripcion = "APOYO MADRE A MADRE";
      							}

      							if ($nombre_descripcion == "27300919"){
                        $nombre_descripcion = "PREVENCION SUICIDIO";
      							}
      							if ($nombre_descripcion == "27300920"){
                        $nombre_descripcion = "PREVENCION TRASTORNO MENTAL";
      							}

      							if ($nombre_descripcion == "27300921"){
                        $nombre_descripcion = "PREVENCION ALCOHOL Y DROGAS";
      							}
      							if ($nombre_descripcion == "27290301"){
                        $nombre_descripcion = "ANTITABÁQUICA (excluye REM 23)";
      							}

      							if ($nombre_descripcion == "27400010"){
                        $nombre_descripcion = "PREVENCIÓN DE LA TRANSMISIÓN VERTICAL DE VIH-SIFILIS";
      							}
      							if ($nombre_descripcion == "27281000"){
                        $nombre_descripcion = "OTRAS ÁREAS TEMÁTICAS";
      							}

      							if ($nombre_descripcion == "27281100"){
                        $nombre_descripcion = "ESTIMULACIÓN DE MEMORIA";
      							}
      							if ($nombre_descripcion == "27281200"){
                        $nombre_descripcion = "PREVENCIÓN CAÍDAS";
      							}
      							if ($nombre_descripcion == "27281300"){
                        $nombre_descripcion = "ESTIMULACIÓN DE ACTIVIDAD FÍSICA";
      							}

      							if ($nombre_descripcion == "27300906"){
                        $nombre_descripcion = "USO RACIONAL DE MEDICAMENTOS";
      							}
                    if ($nombre_descripcion == "27500120"){
                        $nombre_descripcion = "RESISTENCIA ANTIMICROBIANOS";
      							}
                    ?>
                <tr>
                    <?php
                    /*style="vertical-align:middle; writing-mode: vertical-lr; transform: rotate(270deg);"*/
                    if($i==0){?>
                    <td rowspan="31" style="text-align:center; vertical-align:middle">EDUCACIÓN DE GRUPO</td>
                    <td align='left' colspan='2' nowrap="nowrap"><?php echo $nombre_descripcion; ?></td>
                    <?php
                    }
                    if($i==1){?>
                    <td rowspan="4" align="center" style="text-align:center; vertical-align:middle">NUTRICIÓN</td>
                    <?php
                    }
                    if($i>=1 && $i<=4){?>
                    <td align='left' nowrap="nowrap"><?php echo $nombre_descripcion; ?></td>
                    <?php
                    }
                    if($i>=5 && $i<=11){?>
                    <td align='left' colspan='2' nowrap="nowrap"><?php echo $nombre_descripcion; ?></td>
                    <?php
                    }
                    if($i==12){?>
                    <td rowspan="3" align="center" style="text-align:center; vertical-align:middle">PROMOCIÓN DEL DESARROLLO INFANTIL TEMPRANO</td>
                    <?php
                    }
                    if($i>=12 && $i<=14){?>
                    <td align='left' nowrap="nowrap"><?php echo $nombre_descripcion; ?></td>
                    <?php
                    }
                    if($i==15){?>
                    <td rowspan="3" align="center" style="text-align:center; vertical-align:middle">HABILIDADES PARENTALES</td>
                    <?php
                    }
                    if($i>=15 && $i<=17){?>
                    <td align='left' nowrap="nowrap"><?php echo $nombre_descripcion; ?></td>
                    <?php
                    }
                    if($i==18){?>
                    <td align='left' colspan="2" nowrap="nowrap"><?php echo $nombre_descripcion; ?></td>
                    <?php
                    }
                    if($i==19){?>
                    <td rowspan="2" align="center" style="text-align:center; vertical-align:middle">PREVENCIÓN DE SALUD MENTAL </td>
                    <?php
                    }
                    if($i>=19 && $i<=20){?>
                    <td align='left' nowrap="nowrap"><?php echo $nombre_descripcion; ?></td>
                    <?php
                    }
                    if($i>=21 && $i<=24){?>
                    <td align='left' colspan="2" nowrap="nowrap"><?php echo $nombre_descripcion; ?></td>
                    <?php
                    }
                    if($i==25){?>
                    <td rowspan="3" align="center" style="text-align:center; vertical-align:middle">EDUCACIÓN ESPECIAL EN ADULTO MAYOR</td>
                    <?php
                    }
                    if($i>=25 && $i<=27){?>
                    <td align='left' nowrap="nowrap"><?php echo $nombre_descripcion; ?></td>
                    <?php
                    }
                    if($i>=28){?>
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
                    <td colspan="9" class="active"><strong>SECCIÓN B: ACTIVIDADES DE EDUCACIÓN PARA LA SALUD SEGÚN PERSONAL QUE LAS REALIZA (SESIONES).</strong></td>
                </tr>
                <tr>
                    <td colspan="3" style="text-align:center; vertical-align:middle"><strong>ÁREAS TEMÁTICAS DE PREVENCIÓN</strong></td>
                    <td style="text-align:center; vertical-align:middle"><strong>TOTAL</strong></td>
                    <td style="text-align:center; vertical-align:middle"><strong>UN PROFESIONAL</strong></td>
                    <td style="text-align:center; vertical-align:middle"><strong>DOS O MÁS PROFESIONALES</strong></td>
                    <td style="text-align:center; vertical-align:middle"><strong>UN PROFESIONAL Y UN TÉCNICO PARAMÉDICO</strong></td>
                    <td style="text-align:center; vertical-align:middle"><strong>TÉCNICO PARAMÉDICO</strong></td>
                    <td style="text-align:center; vertical-align:middle"><strong>FACILITADOR/A INTERCULTURAL PUEBLOS ORIGINARIOS</strong></td>
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
                          FROM (select c.* from 2019prestaciones c where c.codigo_prestacion in("27281500",
                                                                                                "27281615A","27281615B","27281615C","27500130",
                                                                                                "27281700","27281900","27282000","27282100","27282200","27500140","27300922",
                                                                                                "27300908","27300909","27300910",
                                                                                                "27300900","27400200","27400250",
                                                                                                "27300200",
                                                                                                "27300923","27300924",
                                                                                                "27300925","27290302","27400020","27282400",
                                                                                                "27282500","27282600","27290303",
                                                                                                "27300912","27500150")) a
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
                    if ($nombre_descripcion == "27281500"){
                        $nombre_descripcion = "ESTIMULACIÓN DESARROLLO PSICOMOTOR";
      							}

      							if ($nombre_descripcion == "27281615A"){
                        $nombre_descripcion = "RIESGO DE MALNUTRICION POR EXCESO";
      							}
      							if ($nombre_descripcion == "27281615B"){
                        $nombre_descripcion = "MALNUTRICION POR EXCESO";
      							}
      							if ($nombre_descripcion == "27281615C"){
                        $nombre_descripcion = "MALNUTRICION POR DEFICIT";
      							}
                    if ($nombre_descripcion == "27500130"){
                        $nombre_descripcion = "SIN RIESGO DE MALNUTRICIÓN";
      							}

      							if ($nombre_descripcion == "27281700"){
                        $nombre_descripcion = "PREVENCIÓN DE IRA - ERA";
      							}
      							if ($nombre_descripcion == "27281900"){
                        $nombre_descripcion = "PREVENCIÓN DE ACCIDENTES";
      							}
      							if ($nombre_descripcion == "27282000"){
                        $nombre_descripcion = "SALUD BUCO-DENTAL";
      							}
      							if ($nombre_descripcion == "27282100"){
                        $nombre_descripcion = "PREVENCIÓN VIOLENCIA DE GÉNERO";
      							}
      							if ($nombre_descripcion == "27282200"){
                        $nombre_descripcion = "SALUD SEXUAL Y REPRODUCTIVA";
      							}
                    if ($nombre_descripcion == "27500140"){
                        $nombre_descripcion = "EDUCACION PRENATAL (NUTRICION- LACTANCIA- CRIANZA- AUTOCUIDADO- PREPARACIÓN PARTO Y OTROS)";
      							}
      							if ($nombre_descripcion == "27300922"){
                        $nombre_descripcion = "PROMOCION DE SALUD MENTAL";
      							}

      							if ($nombre_descripcion == "27300908"){
                        $nombre_descripcion = "DEL LENGUAJE";
      							}
      							if ($nombre_descripcion == "27300909"){
                        $nombre_descripcion = 'MOTOR';
      							}
      							if ($nombre_descripcion == "27300910"){
                        $nombre_descripcion = 'OTROS';
      							}

      							if ($nombre_descripcion == "27300900"){
                        $nombre_descripcion = 'NADIE ES PERFECTO';
      							}
      							if ($nombre_descripcion == "27400200"){
                        $nombre_descripcion = 'FAMILIAS FUERTES';
      							}
      							if ($nombre_descripcion == "27400250"){
                        $nombre_descripcion = 'OTROS';
      							}

      							if ($nombre_descripcion == "27300200"){
                        $nombre_descripcion = "APOYO MADRE A MADRE";
      							}

      							if ($nombre_descripcion == "27300923"){
                        $nombre_descripcion = "PREVENCION SUICIDIO";
      							}
      							if ($nombre_descripcion == "27300924"){
                        $nombre_descripcion = "PREVENCION TRASTORNO MENTAL";
      							}

      							if ($nombre_descripcion == "27300925"){
                        $nombre_descripcion = "PREVENCION ALCOHOL Y DROGAS";
      							}
      							if ($nombre_descripcion == "27290302"){
                        $nombre_descripcion = "ANTITABÁQUICA (excluye REM 23)";
      							}
      							if ($nombre_descripcion == "27400020"){
                        $nombre_descripcion = "PREVENCIÓN DE LA TRANSMISIÓN VERTICAL DE VIH-SIFILIS";
      							}
      							if ($nombre_descripcion == "27282400"){
                        $nombre_descripcion = "OTRAS ÁREAS TEMÁTICAS";
      							}

      							if ($nombre_descripcion == "27282500"){
                        $nombre_descripcion = "ESTIMULACIÓN DE MEMORIA";
      							}
      							if ($nombre_descripcion == "27282600"){
                        $nombre_descripcion = "PREVENCIÓN CAÍDAS";
      							}
      							if ($nombre_descripcion == "27290303"){
                        $nombre_descripcion = "ESTIMULACIÓN DE ACTIVIDAD FÍSICA";
      							}

      							if ($nombre_descripcion == "27300912"){
                        $nombre_descripcion = "USO RACIONAL DE MEDICAMENTOS";
      							}
                    if ($nombre_descripcion == "27500150"){
                        $nombre_descripcion = "RESISTENCIA ANTIMICROBIANOS";
      							}
                    ?>
                <tr>
                    <?php
                    /*style="vertical-align:middle; writing-mode: vertical-lr; transform: rotate(270deg);"*/
                    if($i==0){?>
                    <td rowspan="31" style="text-align:center; vertical-align:middle">EDUCACIÓN DE GRUPO</td>
                    <td align='left' colspan='2' nowrap="nowrap"><?php echo $nombre_descripcion; ?></td>
                    <?php
                    }
                    if($i==1){?>
                    <td rowspan="4" align="center" style="text-align:center; vertical-align:middle">NUTRICIÓN</td>
                    <?php
                    }
                    if($i>=1 && $i<=4){?>
                    <td align='left' nowrap="nowrap"><?php echo $nombre_descripcion; ?></td>
                    <?php
                    }
                    if($i>=5 && $i<=11){?>
                    <td align='left' colspan='2' nowrap="nowrap"><?php echo $nombre_descripcion; ?></td>
                    <?php
                    }
                    if($i==12){?>
                    <td rowspan="3" align="center" style="text-align:center; vertical-align:middle">PROMOCIÓN DEL DESARROLLO INFANTIL TEMPRANO</td>
                    <?php
                    }
                    if($i>=12 && $i<=14){?>
                    <td align='left' nowrap="nowrap"><?php echo $nombre_descripcion; ?></td>
                    <?php
                    }
                    if($i==15){?>
                    <td rowspan="3" align="center" style="text-align:center; vertical-align:middle">HABILIDADES PARENTALES</td>
                    <?php
                    }
                    if($i>=15 && $i<=17){?>
                    <td align='left' nowrap="nowrap"><?php echo $nombre_descripcion; ?></td>
                    <?php
                    }
                    if($i==18){?>
                    <td align='left' colspan="2" nowrap="nowrap"><?php echo $nombre_descripcion; ?></td>
                    <?php
                    }
                    if($i==19){?>
                    <td rowspan="2" align="center" style="text-align:center; vertical-align:middle">PREVENCIÓN DE SALUD MENTAL </td>
                    <?php
                    }
                    if($i>=19 && $i<=20){?>
                    <td align='left' nowrap="nowrap"><?php echo $nombre_descripcion; ?></td>
                    <?php
                    }
                    if($i>=21 && $i<=24){?>
                    <td align='left' colspan="2" nowrap="nowrap"><?php echo $nombre_descripcion; ?></td>
                    <?php
                    }
                    if($i==25){?>
                    <td rowspan="3" align="center" style="text-align:center; vertical-align:middle">EDUCACIÓN ESPECIAL EN ADULTO MAYOR</td>
                    <?php
                    }
                    if($i>=25 && $i<=27){?>
                    <td align='left' nowrap="nowrap"><?php echo $nombre_descripcion; ?></td>
                    <?php
                    }
                    if($i>=28){?>
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
                <tr>
                    <td colspan="2" align='center'><strong>TOTAL</strong></td>
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

    <!-- SECCION C -->
    <div class="col-sm tab table-responsive" id="C">
        <table class="table table-hover table-bordered table-sm">
            <thead>
                <tr>
                    <td colspan="6" class="active"><strong>SECCIÓN C: ACTIVIDAD FÍSICA GRUPAL PARA PROGRAMA SALUD CARDIOVASCULAR (SESIONES).</strong></td>
                </tr>
                <tr>
                  <td style="text-align:center; vertical-align:middle"><strong>GRUPO DE EDAD</strong></td>
                  <td style="text-align:center; vertical-align:middle"><strong>TOTAL SESIONES</strong></td>
                  <td style="text-align:center; vertical-align:middle"><strong>PROFESOR EDUCACIÓN FÍSICA</strong></td>
                  <td style="text-align:center; vertical-align:middle"><strong>KINESIÓLOGO</strong></td>
                  <td style="text-align:center; vertical-align:middle"><strong>OTROS PROFESIONALES</strong></td>
                  <td style="text-align:center; vertical-align:middle"><strong>TÉCNICO PARAMÉDICO</strong></td>
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
                          FROM (select c.* from 2019prestaciones c where c.codigo_prestacion in("27300500","27290100","27290200","27290300")) a
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
                    if ($nombre_descripcion == "27300500"){
                        $nombre_descripcion = "10 A 19 AÑOS";
      							}
      							if ($nombre_descripcion == "27290100"){
                        $nombre_descripcion = "20 A 24 AÑOS";
      							}
      							if ($nombre_descripcion == "27290200"){
                        $nombre_descripcion = "25 A 64 AÑOS";
      							}
      							if ($nombre_descripcion == "27290300"){
                        $nombre_descripcion = "65 Y MÁS";
      							}
                    ?>
                <tr>
                    <td align='left' nowrap="nowrap"><?php echo $nombre_descripcion; ?></td>
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
                    <td align='center'><strong>TOTAL</strong></td>
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

    <!-- SECCION D -->
    <div class="col-sm tab table-responsive" id="D">
        <table class="table table-hover table-bordered table-sm">
            <thead>
                <tr>
                    <td colspan="2" class="active"><strong>SECCIÓN D: EDUCACIÓN GRUPAL A GESTANTES DE ALTO RIESGO OBSTÉTRICO (Nivel Secundario).</strong></td>
                </tr>
                <tr>
                  <td style="text-align:center; vertical-align:middle"><strong>TEMAS</strong></td>
                  <td style="text-align:center; vertical-align:middle"><strong>TOTAL SESIONES</strong></td>
                </tr>
            </thead>
            <tbody>
                <?php
                $query = 'SELECT a.codigo_prestacion,a.descripcion
                              ,sum(ifnull(b.Col01,0)) Col01
                          FROM (select c.* from 2019prestaciones c where c.codigo_prestacion in("27300300","27300400","27300600")) a
                          left join 2019rems b on (a.id_prestacion=b.prestacion_id_prestacion)
                          AND (b.Mes in ('.$mes.')) AND (b.establecimiento_id_establecimiento in ('.$estab.'))
                          group by a.codigo_prestacion, a.descripcion, a.id_prestacion
                          order by a.id_prestacion';
                $registro = DB::connection('mysql_rem')->select($query);

                $i=0;

                foreach($registro as $row ){
                    $nombre_descripcion = $row->codigo_prestacion;
                    if ($nombre_descripcion == "27300300"){
                        $nombre_descripcion = "AUTOCUIDADO SEGÚN PATOLOGÍA";
      							}
      							if ($nombre_descripcion == "27300400"){
                        $nombre_descripcion = "PREPARACIÓN PARA EL PARTO";
      							}
      							if ($nombre_descripcion == "27300600"){
                        $nombre_descripcion = "TALLER DE EDUCACIÓN PRENATAL";
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
                    <td colspan="3" class="active"><strong>SECCIÓN E: TALLERES PROGRAMA "MÁS A.M AUTOVALENTES".</strong></td>
                </tr>
                <tr>
                  <td style="text-align:center; vertical-align:middle"><strong>TALLER</strong></td>
                  <td style="text-align:center; vertical-align:middle"><strong>Nº DE SESIONES</strong></td>
                  <td style="text-align:center; vertical-align:middle"><strong>Nº DE PARTICIPANTES</strong></td>
                </tr>
            </thead>
            <tbody>
                <?php
                $query = 'SELECT a.codigo_prestacion,a.descripcion
                              ,sum(ifnull(b.Col01,0)) Col01
                              ,sum(ifnull(b.Col02,0)) Col02
                          FROM (select c.* from 2019prestaciones c where c.codigo_prestacion in("27300913","27300914","27300915")) a
                          left join 2019rems b on (a.id_prestacion=b.prestacion_id_prestacion)
                          AND (b.Mes in ('.$mes.')) AND (b.establecimiento_id_establecimiento in ('.$estab.'))
                          group by a.codigo_prestacion, a.descripcion, a.id_prestacion
                          order by a.id_prestacion';
                $registro = DB::connection('mysql_rem')->select($query);

                $i=0;

                foreach($registro as $row ){
                    $nombre_descripcion = $row->codigo_prestacion;
                    if ($nombre_descripcion == "27300913"){
                        $nombre_descripcion = "ESTIMULACIÓN DE FUNCIONES MOTORAS Y PREVENCIÓN DE CAÍDAS";
      							}
      							if ($nombre_descripcion == "27300914"){
                        $nombre_descripcion = "ESTIMULACION DE FUNCIONES  COGNITIVA";
      							}
      							if ($nombre_descripcion == "27300915"){
                        $nombre_descripcion = "AUTOCUIDADO Y ESTILOS DE VIDA SALUDABLE";
      							}
                    ?>
                <tr>
                    <td align='left' nowrap="nowrap"><?php echo $nombre_descripcion; ?></td>
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

    <br>

    <!-- SECCION F -->
    <div class="col-sm tab table-responsive" id="F">
        <table class="table table-hover table-bordered table-sm">
            <thead>
                <tr>
                    <td colspan="24" class="active"><strong>SECCIÓN F: TALLERES PROGRAMA ELIGE VIDA SANA.</strong></td>
                </tr>
                <tr>
                    <td rowspan="2" style="text-align:center; vertical-align:middle"><strong>TALLER</strong></td>
                    <td rowspan="2" style="text-align:center; vertical-align:middle"><strong>Nº DE SESIONES</strong></td>
                    <td rowspan="2" style="text-align:center; vertical-align:middle"><strong>Nº DE PARTICIPANTES</strong></td>
                    <td colspan="5" align="center"><strong>MADRE, PADRE O CUIDADOR DE :</strong></td>
                    <td colspan="14" align="center"><strong>POR EDAD</strong></td>
                    <td rowspan="2" style="text-align:center; vertical-align:middle"><strong>Gestantes</strong></td>
                    <td rowspan="2" style="text-align:center; vertical-align:middle"><strong>Post Parto</strong></td>
                </tr>
                <tr>
                    <td align="center"><strong>Menores de 1 año</strong></td>
                    <td align="center"><strong>Niños 12 a 23 meses</strong></td>
                    <td align="center"><strong>Niños de 2 a 5 años</strong></td>
                    <td align="center"><strong>Niños de 6 a 9 años</strong></td>
                    <td align="center"><strong>10 a 14 años</strong></td>
                    <td align="center"><strong>menor de 2 años</strong></td>
                    <td align="center"><strong>2 a 4</strong></td>
                    <td align="center"><strong>5 a 9</strong></td>
                    <td align="center"><strong>10 a 14</strong></td>
                    <td align="center"><strong>15 a 19</strong></td>
                    <td align="center"><strong>20 a 24</strong></td>
                    <td align="center"><strong>25 - 29</strong></td>
                    <td align="center"><strong>30 - 34</strong></td>
                    <td align="center"><strong>35 - 39</strong></td>
                    <td align="center"><strong>40 - 44</strong></td>
                    <td align="center"><strong>45 - 49</strong></td>
                    <td align="center"><strong>50 - 54</strong></td>
                    <td align="center"><strong>55 - 59</strong></td>
                    <td align="center"><strong>60 - 64</strong></td>
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
                          FROM (select c.* from 2019prestaciones c where c.codigo_prestacion in("27300916","27500160","27500170")) a
                          left join 2019rems b on (a.id_prestacion=b.prestacion_id_prestacion)
                          AND (b.Mes in ('.$mes.')) AND (b.establecimiento_id_establecimiento in ('.$estab.'))
                          group by a.codigo_prestacion, a.descripcion, a.id_prestacion
                          order by a.id_prestacion';
                $registro = DB::connection('mysql_rem')->select($query);

                $i=0;

                foreach($registro as $row ){
                    $nombre_descripcion = $row->codigo_prestacion;
                    if ($nombre_descripcion == "27300916"){
                        $nombre_descripcion = "CIRCULO DE ACTIVIDAD FISICA";
      							}
      							if ($nombre_descripcion == "27500160"){
                        $nombre_descripcion = "CIRCULO DE VIDA SANA";
      							}
                    if ($nombre_descripcion == "27500170"){
                        $nombre_descripcion = "ACTIVIDADES MASIVAS";
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
                    <td colspan="11" class="active"><strong>SECCIÓN G: INTERVENCIONES POR PATRON DE CONSUMO DE ALCOHOL, TABACO Y OTRAS DROGAS.</strong></td>
                </tr>
                <tr>
                    <td colspan="2" rowspan="2" style="text-align:center; vertical-align:middle"><strong>TIPO DE INTERVENCIÓN</strong></td>
                    <td rowspan="2" style="text-align:center; vertical-align:middle"><strong>Nº DE INTERVENCIONES</strong></td>
                    <td colspan="6" align="center"><strong>POR EDAD</strong></td>
                    <td colspan="2" align="center"><strong>SEXO</strong></td>
                </tr>
                <tr>
                    <td align="center"><strong>10-14 años</strong></td>
                    <td align="center"><strong>15-19 años</strong></td>
                    <td align="center"><strong>20-24 años</strong></td>
                    <td align="center"><strong>25-44 años</strong></td>
                    <td align="center"><strong>45-64 años</strong></td>
                    <td align="center"><strong>65 o más</strong></td>
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
                          FROM (select c.* from 2019prestaciones c where c.codigo_prestacion in("27300926","27300927","27300928",
                                                                                                "27300929","27300930","27300931",
                                                                                                "27300932","27300933","27300934")) a
                          left join 2019rems b on (a.id_prestacion=b.prestacion_id_prestacion)
                          AND (b.Mes in ('.$mes.')) AND (b.establecimiento_id_establecimiento in ('.$estab.'))
                          group by a.codigo_prestacion, a.descripcion, a.id_prestacion
                          order by a.id_prestacion';
                $registro = DB::connection('mysql_rem')->select($query);

                $i=0;

                foreach($registro as $row ){
                    $nombre_descripcion = $row->codigo_prestacion;
                    if ($nombre_descripcion == "27300926"){
                        $nombre_descripcion = "ALCOHOL";
      							}
      							if ($nombre_descripcion == "27300927"){
                        $nombre_descripcion = "TABACO";
      							}
      							if ($nombre_descripcion == "27300928"){
                        $nombre_descripcion = "DROGAS";
      							}

      							if ($nombre_descripcion == "27300929"){
                        $nombre_descripcion = "ALCOHOL";
      							}
      							if ($nombre_descripcion == "27300930"){
                        $nombre_descripcion = "TABACO";
      							}
      							if ($nombre_descripcion == "27300931"){
                        $nombre_descripcion = "DROGAS";
      							}

      							if ($nombre_descripcion == "27300932"){
                        $nombre_descripcion = "ALCOHOL";
      							}
      							if ($nombre_descripcion == "27300933"){
                        $nombre_descripcion = "TABACO";
      							}
      							if ($nombre_descripcion == "27300934"){
                        $nombre_descripcion = "DROGAS";
      							}
                    ?>
                <tr>
                    <?php
                    if($i==0){?>
                    <td rowspan="3" style="text-align:center; vertical-align:middle" width="20%">INTERVENCIÓN MÍNIMA (BAJO RIESGO)</td>
                    <?php
                                  }
                    if($i==3){?>
                    <td rowspan="3" style="text-align:center; vertical-align:middle">INTERVENCIÓN BREVE (RIESGO)</td>
                    <?php
                                  }
                    if($i==6){?>
                    <td rowspan="3" style="text-align:center; vertical-align:middle">INTERVENCIÓN REFERENCIA ASISTIDA (PERJUDICIAL O DEPENDENCIA)</td>
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
            </tbody>
        </table>
    </div>

    <br>

    <div class="container">
    <!-- SECCION H -->
    <div class="col-sm tab table-responsive" id="H">
        <table class="table table-hover table-bordered table-sm">
            <thead>
                <tr>
                    <td colspan="4" class="active"><strong>SECCIÓN H: PERSONAS QUE INGRESAN A TALLERES PARA PADRES DEL PROGRAMA DE APOYO A LA SALUD MENTAL INFANTIL (PASMI).</strong></td>
                </tr>
                <tr>
                    <td align="center"><strong>Concepto</strong></td>
                    <td align="center"><strong>Total de padres, madres o cuidadores de 5 a 9 años</strong></td>
                    <td align="center"><strong>Total de talleres</strong></td>
                    <td align="center"><strong>Total de sesiones></strong></td>
                </tr>
            </thead>
            <tbody>
                <?php
                $query = 'SELECT a.codigo_prestacion,a.descripcion
                              ,sum(ifnull(b.Col01,0)) Col01
                              ,sum(ifnull(b.Col02,0)) Col02
                              ,sum(ifnull(b.Col03,0)) Col03
                          FROM (select c.* from 2019prestaciones c where c.codigo_prestacion in("27500180")) a
                          left join 2019rems b on (a.id_prestacion=b.prestacion_id_prestacion)
                          AND (b.Mes in ('.$mes.')) AND (b.establecimiento_id_establecimiento in ('.$estab.'))
                          group by a.codigo_prestacion, a.descripcion, a.id_prestacion
                          order by a.id_prestacion';
                $registro = DB::connection('mysql_rem')->select($query);

                $i=0;

                foreach($registro as $row ){
                    $nombre_descripcion = $row->codigo_prestacion;
                    if ($nombre_descripcion == "27500180"){
                        $nombre_descripcion = "Taller Nadie es Perfecto (PASMI)";
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

    <!-- SECCION I -->
    <div class="col-sm tab table-responsive" id="I">
        <table class="table table-hover table-bordered table-sm">
            <thead>
                <tr>
                    <td colspan="9" class="active"><strong>SECCIÓN I: ORGANIZACIONES SOCIALES DE LA RED DEL PROGRAMA MÁS ADULTOS MAYORES AUTOVALENTES.</strong></td>
                </tr>
                <tr>
                    <td rowspan="2" align="center"><strong>Concepto</strong></td>
                    <td colspan="8" align="center"><strong>POR TIPO DE ORGANIZACIÓN</strong></td>
                </tr>
                <tr>
                    <td align="center"><strong>N° Total  de Organizaciones</strong></td>
                    <td align="center"><strong>Clubes de Adultos Mayores</strong></td>
                    <td align="center"><strong>Centros de Madres</strong></td>
                    <td align="center"><strong>Clubes Deportivos</strong></td>
                    <td align="center"><strong>Uniones Comunales de Adultos Mayores</strong></td>
                    <td align="center"><strong>Junta de Vecinos</strong></td>
                    <td align="center"><strong>Organizaciones informales</strong></td>
                    <td align="center"><strong>Otras organizaciones formales</strong></td>
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
                          FROM (select c.* from 2019prestaciones c where c.codigo_prestacion in("27500190","27500200")) a
                          left join 2019rems b on (a.id_prestacion=b.prestacion_id_prestacion)
                          AND (b.Mes in ('.$mes.')) AND (b.establecimiento_id_establecimiento in ('.$estab.'))
                          group by a.codigo_prestacion, a.descripcion, a.id_prestacion
                          order by a.id_prestacion';
                $registro = DB::connection('mysql_rem')->select($query);

                $i=0;

                foreach($registro as $row ){
                    $nombre_descripcion = $row->codigo_prestacion;
                    if ($nombre_descripcion == "27500190"){
                        $nombre_descripcion = "Organizaciones ingresadas al Programa de Estimulación Funcional del programa Más Adultos Mayores Autovalentes";
      							}
                    if ($nombre_descripcion == "27500200"){
                        $nombre_descripcion = "Organizaciones con Líderes Comunitarios Capacitados por el Programa Más Adultos Mayores Autovalentes";
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
                    <?php
                    $i++;
                }
                ?>
                </tr>
            </tbody>
        </table>
    </div>

    <br>

    <!-- SECCION J -->
    <div class="col-sm tab table-responsive" id="J">
        <table class="table table-hover table-bordered table-sm">
            <thead>
                <tr>
                    <td colspan="13" class="active"><strong>SECCIÓN J: SERVICIOS DE LA RED DEL PROGRAMA MÁS ADULTOS MAYORES AUTOVALENTES.</strong></td>
                </tr>
                <tr>
                    <td rowspan="2" align="center"><strong>Concepto</strong></td>
                    <td colspan="12" align="center"><strong>POR TIPO DE SERVICIO</strong></td>
                </tr>
                <tr>
                    <td align="center"><strong>N° Total de Servicios</strong></td>
                    <td align="center"><strong>Unidad Municipal de Personas Mayores</strong></td>
                    <td align="center"><strong>Unidad Municipal de Atención Social</strong></td>
                    <td align="center"><strong>Unidad Municipal de Deportes</strong></td>
                    <td align="center"><strong>Unidad Municipal Turismo</strong></td>
                    <td align="center"><strong>Unidad Municipal Educación</strong></td>
                    <td align="center"><strong>Biblioteca Municipal</strong></td>
                    <td align="center"><strong>Unidad Cultura Minicipal</strong></td>
                    <td align="center"><strong>Otras Unidades Municipales</strong></td>
                    <td align="center"><strong>Escuelas o Colegios</strong></td>
                    <td align="center"><strong>Universidades</strong></td>
                    <td align="center"><strong>Otras Unidades Externas al Municipio</strong></td>
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
                          FROM (select c.* from 2019prestaciones c where c.codigo_prestacion in("27500210","27500220")) a
                          left join 2019rems b on (a.id_prestacion=b.prestacion_id_prestacion)
                          AND (b.Mes in ('.$mes.')) AND (b.establecimiento_id_establecimiento in ('.$estab.'))
                          group by a.codigo_prestacion, a.descripcion, a.id_prestacion
                          order by a.id_prestacion';
                $registro = DB::connection('mysql_rem')->select($query);

                $i=0;

                foreach($registro as $row ){
                    $nombre_descripcion = $row->codigo_prestacion;
                    if ($nombre_descripcion == "27500210"){
                        $nombre_descripcion = "Servicios Locales con oferta programática para personas mayores (total o parcial)";
      							}
                    if ($nombre_descripcion == "27500220"){
                        $nombre_descripcion = "Servicios Locales con Planes Intersectoriales para el Fomento del Autocuidado y Estimulación Funcional desarrollados junto al Programa Más Adultos Mayores Autovalentes";
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
                    <?php
                    $i++;
                }
                ?>
                </tr>
            </tbody>
        </table>
    </div>

    <br>

    <!-- SECCION K -->
    <div class="col-sm tab table-responsive" id="K">
        <table class="table table-hover table-bordered table-sm">
            <thead>
                <tr>
                    <td colspan="13" class="active"><strong>SECCIÓN K: TALLER GRUPALES DE LACTANCIA MATERNA.</strong></td>
                </tr>
                <tr>
                    <td rowspan="2" align="center"><strong>Concepto</strong></td>
                    <td rowspan="2" align="center"><strong>Nº DE TALLERES</strong></td>
                    <td colspan="11" align="center"><strong>GRUPO DE EDAD (En años)</strong></td>
                </tr>
                <tr>
                    <td align="center"><strong>10 a 14 años</strong></td>
                    <td align="center"><strong>15 a 19 años</strong></td>
                    <td align="center"><strong>20 a 24 años</strong></td>
                    <td align="center"><strong>25 a 29 años</strong></td>
                    <td align="center"><strong>30 a 34 años</strong></td>
                    <td align="center"><strong>35 a 39 años</strong></td>
                    <td align="center"><strong>40 a 44 años</strong></td>
                    <td align="center"><strong>45 a 49 años</strong></td>
                    <td align="center"><strong>50 a 54 años</strong></td>
                    <td align="center"><strong>PUEBLOS ORIGINARIOS</strong></td>
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
                              ,sum(ifnull(b.Col12,0)) Col12
                          FROM (select c.* from 2019prestaciones c where c.codigo_prestacion in("27500230")) a
                          left join 2019rems b on (a.id_prestacion=b.prestacion_id_prestacion)
                          AND (b.Mes in ('.$mes.')) AND (b.establecimiento_id_establecimiento in ('.$estab.'))
                          group by a.codigo_prestacion, a.descripcion, a.id_prestacion
                          order by a.id_prestacion';
                $registro = DB::connection('mysql_rem')->select($query);

                $i=0;

                foreach($registro as $row ){
                    $nombre_descripcion = $row->codigo_prestacion;
                    if ($nombre_descripcion == "27500230"){
                        $nombre_descripcion = "NUMERO DE TALLERES DE LACTANCIA MATERNA REALIZADA EN MATERNIDADES";
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
                    <?php
                    $i++;
                }
                ?>
                </tr>
            </tbody>
        </table>
    </div>

    <br>

    <!-- SECCION L -->
    <div class="col-sm tab table-responsive" id="L">
        <table class="table table-hover table-bordered table-sm">
            <thead>
                <tr>
                    <td colspan="8" class="active"><strong>SECCIÓN L: TALLERES GRUPALES DE LACTANCIA MATERNA EN ATENCIÓN PRIMARIA.</strong></td>
                </tr>
                <tr>
                    <td rowspan="2" align="center"><strong>Concepto</strong></td>
                    <td rowspan="2" align="center"><strong>Nº DE TALLERES</strong></td>
                    <td colspan="6" align="center"><strong>GRUPO DE EDAD (En años)</strong></td>
                </tr>
                <tr>
                    <td align="center"><strong>De 0 a 29 días</strong></td>
                    <td align="center"><strong>De 1 mes a 2 meses 29 días</strong></td>
                    <td align="center"><strong>De 3 meses a 5 meses 29 días</strong></td>
                    <td align="center"><strong>De 6 meses a 11 meses 29 días</strong></td>
                    <td align="center"><strong>PUEBLOS ORIGINARIOS</strong></td>
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
                          FROM (select c.* from 2019prestaciones c where c.codigo_prestacion in("27500240")) a
                          left join 2019rems b on (a.id_prestacion=b.prestacion_id_prestacion)
                          AND (b.Mes in ('.$mes.')) AND (b.establecimiento_id_establecimiento in ('.$estab.'))
                          group by a.codigo_prestacion, a.descripcion, a.id_prestacion
                          order by a.id_prestacion';
                $registro = DB::connection('mysql_rem')->select($query);

                $i=0;

                foreach($registro as $row ){
                    $nombre_descripcion = $row->codigo_prestacion;
                    if ($nombre_descripcion == "27500240"){
                        $nombre_descripcion = "NUMERO DE TALLERES DE LACTANCIA MATERNA REALIZADA EN ATENCION PRIMARIA A MENORES DE UN AÑO";
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
<?php
}
?>

@endsection

@section('custom_js')
    <script src="{{ asset('js/show_hide_tab.js') }}" defer></script>
    <script src="{{ asset('js/bootstrap-multiselect.js') }}" defer></script>
@endsection
