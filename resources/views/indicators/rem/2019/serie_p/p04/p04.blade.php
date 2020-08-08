@extends('layouts.app')

@section('title', 'Resumen Estadistico Mensual')

@section('content')

<?php

use Illuminate\Support\Facades\DB;

?>

@include('indicators.rem.partials.navP')

<h3>REM-P4. POBLACIÓN EN CONTROL PROGRAMA DE SALUD CARDIOVASCULAR (PSCV).</h3>

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
                    <td colspan="38" class="active"><strong>SECCIÓN A: PROGRAMA SALUD CARDIOVASCULAR (PSCV).</strong></td>
                </tr>
                <tr>
                    <td colspan='2' rowspan='3' style="text-align:center; vertical-align:middle"><strong>CONCEPTO</strong></td>
                    <td colspan='3' rowspan='2' style="text-align:center; vertical-align:middle"><strong>TOTAL</strong></td>
                    <td colspan='28' align='center'><strong>GRUPOS DE EDAD (en años) Y SEXO</strong></td>
                    <td colspan='2' rowspan='2' align='center'><strong>Pueblos Originarios</strong></td>
                    <td colspan='2' rowspan='2' align='center'><strong>Población Inmigrantes</strong></td>
                    <td rowspan='3' style="text-align:center; vertical-align:middle"><strong>Pacientes Diabéticos</strong></td>
                </tr>
                <tr>
                    <td colspan='2' align='center' ><strong>15 a 19 años</strong></td>
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
                          FROM (select c.* from 2019prestaciones c where c.codigo_prestacion in("P4150100",
                                                                                                "P4190100","P4150703","P4150801",
                                                                                                "P4150601","P4150602","P4150603","P4150701","P4190900","P4190910") AND c.serie = "P") a
                          left join 2019rems b on (a.id_prestacion=b.prestacion_id_prestacion)
                          AND (b.Mes in ('.$mes.')) AND (b.establecimiento_id_establecimiento in ('.$estab.'))
                          group by  a.codigo_prestacion,a.descripcion,a.id_prestacion
                          order by a.id_prestacion';
                $registro = DB::connection('mysql_rem')->select($query);

                $i=0;

                foreach($registro as $row ){
                    $nombre_descripcion = $row->codigo_prestacion;
                    if ($nombre_descripcion == "P4150100"){
                        $nombre_descripcion = "NÚMERO DE PERSONAS EN PSCV";
                    }

                    if ($nombre_descripcion == "P4190100"){
                        $nombre_descripcion = "BAJO";
                    }
                    if ($nombre_descripcion == "P4150703"){
                        $nombre_descripcion = "MODERADO";
                    }
                    if ($nombre_descripcion == "P4150801"){
                        $nombre_descripcion = "ALTO";
                    }

                    if ($nombre_descripcion == "P4150601"){
                        $nombre_descripcion = "HIPERTENSOS";
                    }
                    if ($nombre_descripcion == "P4150602"){
                        $nombre_descripcion = "DIABÉTICOS";
                    }
                    if ($nombre_descripcion == "P4150603"){
                        $nombre_descripcion = "DISLIPIDÉMICOS";
                    }
                    if ($nombre_descripcion == "P4150701"){
                        $nombre_descripcion = "TABAQUISMO > 55 AÑOS";
                    }
                    if ($nombre_descripcion == "P4190900"){
                        $nombre_descripcion = "ANTECEDENTES DE INFARTO AL MIOCARDIO (IAM)";
                    }
                    if ($nombre_descripcion == "P4190910"){
                        $nombre_descripcion = "ANTECEDENTES DE ENF. CEREBRO VASCULAR";
                    }

                    ?>
                <tr>
                    <?php
                    if($i==0){?>
                    <td colspan="2" align='left' nowrap="nowrap"><?php echo $nombre_descripcion; ?></td>
                    <?php
                    }
                    if($i==1){?>
                    <td rowspan='3' style="text-align:center; vertical-align:middle">CLASIFICACIÓN DEL RIESGO CARDIOVASCULAR</td>
                    <?php
                    }
                    if($i>=1 && $i<=3){?>
                    <td align='left' nowrap="nowrap"><?php echo $nombre_descripcion; ?></td>
                    <?php
                    }
                    if($i==4){?>
                    <td rowspan='6' style="text-align:center; vertical-align:middle">PERSONAS BAJO CONTROL SEGÚN PATOLOGIA Y FACTORES DE RIESGO (EXISTENCIA)</td>
                    <?php
                    }
                    if($i>=4 && $i<=9){?>
                    <td align='left' nowrap="nowrap"><?php echo $nombre_descripcion; ?></td>
                    <?php
                    }?>
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
                          FROM (select c.* from 2019prestaciones c where c.codigo_prestacion in("P4190800","P4190801","P4190810","P4190811","P4190803","P4190804") AND c.serie = "P") a
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

                    $nombre_descripcion = $row->codigo_prestacion;
                    if ($nombre_descripcion == "P4190800"){
                        $nombre_descripcion = "SIN ENFERMEDAD RENAL S/ERC";
                    }
                    if ($nombre_descripcion == "P4190801"){
                        $nombre_descripcion = "ETAPA G1 Y ETAPA G2 (VFG ≥ 60 ML/MIN)";
                    }
                    if ($nombre_descripcion == "P4190810"){
                        $nombre_descripcion = "ETAPA G3a (VFG ≥45 a 59 ML/MIN)";
                    }
                    if ($nombre_descripcion == "P4190811"){
                        $nombre_descripcion = "ETAPA G3a (VFG ≥30 a 44 ML/MIN)";
                    }
                    if ($nombre_descripcion == "P4190803"){
                        $nombre_descripcion = "ETAPA G4 (VFG ≥ 15 a 29 ML/MIN)";
                    }
                    if ($nombre_descripcion == "P4190804"){
                        $nombre_descripcion = "ETAPA G5 (VFG < 15 ML/MIN)";
                    }
                    ?>

                <tr>
                    <?php
                    if($i==0){?>
                    <td rowspan='7' style="text-align:center; vertical-align:middle">DETECCION Y PREVENCION DE LA PROGRECION DE LA ENFERMEDAD RENAL CRONICA (ERC)</td>
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
                    <td align='right'><?php echo number_format($row->Col36,0,",",".")?></td>
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
                    <td align='right'><strong><?php echo number_format($totalCol36,0,",",".") ?></strong></td>
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
                    <td colspan="38" class="active"><strong>SECCIÓN B: METAS DE COMPENSACIÓN.</strong></td>
                </tr>
                <tr>
                    <td colspan='2' rowspan='3' style="text-align:center; vertical-align:middle"><strong>CONCEPTO</strong></td>
                    <td colspan='3' rowspan='2' style="text-align:center; vertical-align:middle"><strong>TOTAL</strong></td>
                    <td colspan='28' align='center'><strong>GRUPOS DE EDAD (en años) Y SEXO</strong></td>
                    <td colspan='2' rowspan='2' align='center'><strong>Pueblos Originarios</strong></td>
                    <td colspan='2' rowspan='2' align='center'><strong>Población Inmigrantes</strong></td>
                </tr>
                <tr>
                    <td colspan='2' align='center' ><strong>15 a 19 años</strong></td>
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
                          FROM (select c.* from 2019prestaciones c where c.codigo_prestacion in("P4180200","P4200100",
                                                                                                "P4180300","P4200200","P4190920","P4180500",
                                                                                                "P4190930","P4190940") AND c.serie = "P") a
                          left join 2019rems b on (a.id_prestacion=b.prestacion_id_prestacion)
                          AND (b.Mes in ('.$mes.')) AND (b.establecimiento_id_establecimiento in ('.$estab.'))
                          group by  a.codigo_prestacion,a.descripcion,a.id_prestacion
                          order by a.id_prestacion';
                $registro = DB::connection('mysql_rem')->select($query);

                $i=0;

                foreach($registro as $row ){
                    $nombre_descripcion = $row->codigo_prestacion;
                    if ($nombre_descripcion == "P4180200"){
                        $nombre_descripcion = "PA<140/90 mmHg";
                    }
                    if ($nombre_descripcion == "P4200100"){
                        $nombre_descripcion = "PA<150/90 mmHg";
                    }

                    if ($nombre_descripcion == "P4180300"){
                        $nombre_descripcion = "hbA1C<7%";
                    }
                    if ($nombre_descripcion == "P4200200"){
                        $nombre_descripcion = "hbA1C<8%";
                    }
                    if ($nombre_descripcion == "P4190920"){
                        $nombre_descripcion = "hbA1C<7% - PA < 140/90 mmHg  y COLESTEROL  LDL<100MG/DL";
                    }
                    if ($nombre_descripcion == "P4180500"){
                        $nombre_descripcion = "COLESTEROL LDL < 100 mg/dL";
                    }

                    if ($nombre_descripcion == "P4190930"){
                        $nombre_descripcion = "EN TRATAMIENTO CON ACIDO ACETILSALICILICO";
                    }
                    if ($nombre_descripcion == "P4190940"){
                        $nombre_descripcion = "EN TRATAMIENTO CON ESTATINA";
                    }
                    ?>
                <tr>
                    <?php
                    if($i==0){?>
                    <td rowspan='2' style="text-align:center; vertical-align:middle">PERSONAS BAJO CONTROL POR HIPERTENSION</td>
                    <?php
                    }
                    if($i==2){?>
                    <td rowspan='4' style="text-align:center; vertical-align:middle">PERSONAS BAJO CONTROL POR DIABETES MELLITUS</td>
                    <?php
                    }
                    if($i==6){?>
                    <td rowspan='2' style="text-align:center; vertical-align:middle">PERSONAS BAJO CONTROL con antecedentes Enfermedad Cardiovascular (ECV)</td>
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
            </tbody>
        </table>
    </div>

    <br>

    <div class="container">
    <!-- SECCION C -->
    <div class="col-sm tab table-responsive" id="C">
        <table class="table table-hover table-bordered table-sm">
            <thead>
                <tr>
                    <td colspan="38" class="active"><strong>SECCIÓN C: VARIABLES DE SEGUIMIENTO DEL PSCV AL CORTE.</strong></td>
                </tr>
                <tr>
                    <td colspan='2' rowspan='2' style="text-align:center; vertical-align:middle"><strong>VARIABLES</strong></td>
                    <td rowspan='2' style="text-align:center; vertical-align:middle"><strong>TOTAL</strong></td>
                    <td colspan='2' align='center'><strong>EDAD (en años)</strong></td>
                    <td colspan='2' align='center'><strong>SEXO</strong></td>
                </tr>
                <tr>
                    <td align='center'><strong>15 a 64</strong></td>
                    <td align='center'><strong>65 y más</strong></td>
                    <td align='center'><strong>Hombres</strong></td>
                    <td align='center'><strong>Mujeres</strong></td>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td colspan="7" align='left'><strong>PERSONAS DIABETICAS EN PSCV</strong></td>
                </tr>
                <?php
                $query = 'SELECT a.codigo_prestacion,a.descripcion
                              ,sum(ifnull(b.Col01,0)) Col01
                              ,sum(ifnull(b.Col02,0)) Col02
                              ,sum(ifnull(b.Col03,0)) Col03
                              ,sum(ifnull(b.Col04,0)) Col04
									            ,sum(ifnull(b.Col05,0)) Col05
                          FROM (select c.* from 2019prestaciones c where c.codigo_prestacion in("P4190805","P4190806","P4190950","P4200600","P4200300","P4180800","P4200700","P4190960",
                                                                                                "P4190807","P4190808",
                                                                                                "P4190809","P4170300","P4190500","P4190600",
                                                                                                "P4190970","P4170500",
                                                                                                "P4200800","P4200900","P4201100","P4201200") AND c.serie = "P") a
                          left join 2019rems b on (a.id_prestacion=b.prestacion_id_prestacion)
                          AND (b.Mes in ('.$mes.')) AND (b.establecimiento_id_establecimiento in ('.$estab.'))
                          group by  a.codigo_prestacion,a.descripcion,a.id_prestacion
                          order by a.id_prestacion';
                $registro = DB::connection('mysql_rem')->select($query);

                $i=0;

                foreach($registro as $row ){
                    $nombre_descripcion = $row->codigo_prestacion;
                    if ($nombre_descripcion == "P4190805"){
                        $nombre_descripcion = "CON RAZON ALBÚMINA CREATININA (RAC),VIGENTE";
                    }
                    if ($nombre_descripcion == "P4190806"){
                        $nombre_descripcion = "CON VELOCIDAD DE FILTRACIÓN GLOMERULAR (VFG), VIGENTE";
                    }
                    if ($nombre_descripcion == "P4190950"){
                        $nombre_descripcion = "CON FONDO DE OJO, VIGENTE";
                    }
                    if ($nombre_descripcion == "P4200600"){
                        $nombre_descripcion = "CON ATENCIÓN PODOLÓGICA VIGENTE";
                    }
                    if ($nombre_descripcion == "P4200300"){
                        $nombre_descripcion = "CON ECG, VIGENTE";
                    }
                    if ($nombre_descripcion == "P4180800"){
                        $nombre_descripcion = "EN TRATAMIENTO CON INSULINA";
                    }
                    if ($nombre_descripcion == "P4200700"){
                        $nombre_descripcion = "EN TRATAMIENTO CON INSULINA QUE LOGRA META CON  HbA1C SEGÚN EDAD";
                    }
                    if ($nombre_descripcion == "P4190960"){
                        $nombre_descripcion = "CON HbA1C>= 9 %";
                    }
                    if ($nombre_descripcion == "P4190807"){
                        $nombre_descripcion = "EN TRATAMIENTO CON IECA O ARA II.";
                    }
                    if ($nombre_descripcion == "P4190808"){
                        $nombre_descripcion = "CON UN EXÁMEN DE COLESTEROL LDL VIGENTE.";
                    }

                    if ($nombre_descripcion == "P4190809"){
                        $nombre_descripcion = "RIESGO BAJO";
                    }
                    if ($nombre_descripcion == "P4170300"){
                        $nombre_descripcion = "RIESGO MODERADO";
                    }
                    if ($nombre_descripcion == "P4190500"){
                        $nombre_descripcion = "RIESGO ALTO";
                    }
                    if ($nombre_descripcion == "P4190600"){
                        $nombre_descripcion = "RIESGO MAXIMO";
                    }

                    if ($nombre_descripcion == "P4190970"){
                        $nombre_descripcion = "CURACION CONVENCIONAL";
                    }
                    if ($nombre_descripcion == "P4170500"){
                        $nombre_descripcion = "CURACION AVANZADA";
                    }

                    if ($nombre_descripcion == "P4200800"){
                        $nombre_descripcion = "CON AMPUTACIÓN POR PIE DIABÉTICO";
                    }
                    if ($nombre_descripcion == "P4200900"){
                        $nombre_descripcion = "CON DIAGNOSTIOC ASOCIADO DE HIPERTENSION ARTERIAL";
                    }
                    if ($nombre_descripcion == "P4201100"){
                        $nombre_descripcion = "CON ANTECEDENTE DE ATAQUE CEREBRO VASCULAR";
                    }
                    if ($nombre_descripcion == "P4201200"){
                        $nombre_descripcion = "CON ANTECEDENTES DE INFARTO AGUDO AL MIOCARDIO";
                    }
                    ?>
                <tr>
                    <?php
                    if($i>=0 && $i<=9){?>
                    <td align='left' colspan="2" nowrap="nowrap"><?php echo $nombre_descripcion; ?></td>
                    <?php
                    }
                    if($i==10){?>
                    <td rowspan='4' style="text-align:center; vertical-align:middle">CON EVALUACIÓN VIGENTE DEL PIE SEGÚN PAUTA DE ESTIMACION DEL RIESGO DE ULCERACION EN PERSONAS CON DIABETES</td>
                    <?php
                    }
                    if($i>=10 && $i<=13){?>
                    <td align='left' nowrap="nowrap"><?php echo $nombre_descripcion; ?></td>
                    <?php
                    }
                    if($i==14){?>
                    <td rowspan='2' style="text-align:center; vertical-align:middle">CON ÚLCERAS ACTIVAS DE PIE TRATADAS CON CURACIÓN</td>
                    <?php
                    }
                    if($i>=14 && $i<=15){?>
                    <td align='left' nowrap="nowrap"><?php echo $nombre_descripcion; ?></td>
                    <?php
                    }
                    if($i>=16 && $i<=19){?>
                    <td colspan="2" align='left' nowrap="nowrap"><?php echo $nombre_descripcion; ?></td>
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
                    <td colspan="7" align='left'><strong>PERSONAS DIABETICAS EN PSCV</strong></td>
                </tr>
                <?php
                $query = 'SELECT a.codigo_prestacion,a.descripcion
                              ,sum(ifnull(b.Col01,0)) Col01
                              ,sum(ifnull(b.Col02,0)) Col02
                              ,sum(ifnull(b.Col03,0)) Col03
                              ,sum(ifnull(b.Col04,0)) Col04
                              ,sum(ifnull(b.Col05,0)) Col05
                          FROM (select c.* from 2019prestaciones c where c.codigo_prestacion in("P4190812","P4200400") AND c.serie = "P") a
                          left join 2019rems b on (a.id_prestacion=b.prestacion_id_prestacion)
                          AND (b.Mes in ('.$mes.')) AND (b.establecimiento_id_establecimiento in ('.$estab.'))
                          group by  a.codigo_prestacion,a.descripcion,a.id_prestacion
                          order by a.id_prestacion';
                $registro = DB::connection('mysql_rem')->select($query);

                $i=0;

                foreach($registro as $row ){
                    $nombre_descripcion = $row->codigo_prestacion;
                    if ($nombre_descripcion == "P4190812"){
                        $nombre_descripcion = "CON RAZON ALBÚMINA CREATININA (RAC),VIGENTE";
                    }
                    if ($nombre_descripcion == "P4200400"){
                        $nombre_descripcion = "CON PRESIÓN ARTERIAL igual o Mayor 160/100 mmHg";
                    }
                    ?>
                <tr>
                    <?php
                    if($i>=0 && $i<=1){?>
                    <td align='left' colspan="2" nowrap="nowrap"><?php echo $nombre_descripcion; ?></td>
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
                    <td colspan="7" align='left'><strong>TODAS LAS PERSONAS EN PSCV</strong></td>
                </tr>
                <?php
                $query = 'SELECT a.codigo_prestacion,a.descripcion
                              ,sum(ifnull(b.Col01,0)) Col01
                              ,sum(ifnull(b.Col02,0)) Col02
                              ,sum(ifnull(b.Col03,0)) Col03
                              ,sum(ifnull(b.Col04,0)) Col04
                              ,sum(ifnull(b.Col05,0)) Col05
                          FROM (select c.* from 2019prestaciones c where c.codigo_prestacion in("P4201300","P4201400","P4201500","P4201600","P4200500","P4201700") AND c.serie = "P") a
                          left join 2019rems b on (a.id_prestacion=b.prestacion_id_prestacion)
                          AND (b.Mes in ('.$mes.')) AND (b.establecimiento_id_establecimiento in ('.$estab.'))
                          group by  a.codigo_prestacion,a.descripcion,a.id_prestacion
                          order by a.id_prestacion';
                $registro = DB::connection('mysql_rem')->select($query);

                $i=0;

                foreach($registro as $row ){
                    $nombre_descripcion = $row->codigo_prestacion;
                    if ($nombre_descripcion == "P4201300"){
                        $nombre_descripcion = "CON DIAGNÓSTCO DE GLICEMIA DE AYUNAS ALTERADA";
                    }
                    if ($nombre_descripcion == "P4201400"){
                        $nombre_descripcion = "CON DIAGNÓSTCO DE INTOLERANCIA A LA GLUCOSA";
                    }
                    if ($nombre_descripcion == "P4201500"){
                        $nombre_descripcion = "SOBREPESO: IMC entre 25 y 29.9";
                    }
                    if ($nombre_descripcion == "P4201600"){
                        $nombre_descripcion = "SOBREPESO: IMC entre 27 y 31.9";
                    }
                    if ($nombre_descripcion == "P4200500"){
                        $nombre_descripcion = "IMC igual o Mayor a 30KG/M2";
                    }
                    if ($nombre_descripcion == "P4201700"){
                        $nombre_descripcion = "**OBESIDAD: IMC igual o Mayor a 32KG/M2";
                    }
                    ?>
                <tr>
                    <?php
                    if($i>=0 && $i<=5){?>
                    <td align='left' colspan="2" nowrap="nowrap"><?php echo $nombre_descripcion; ?></td>
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
                    <td colspan="7" align='left'>NOTA (*): La vigencia de la evaluación es de 12 meses.</td>
                </tr>
                <tr>
                    <td colspan="7" align='left'>**Considerar en adultos mayores (65 años y más) un IMC igual o mayor a 32G/M2</td>
                </tr>
            </tbody>
        </table>
    </div>
    </div>

    <br>

    <!-- SECCION D -->
    <div class="col-sm tab table-responsive" id="D">
        <table class="table table-hover table-bordered table-sm">
            <thead>
                <tr>
                    <td colspan="38" class="active"><strong>SECCIÓN D: POBLACION EN CONTROL (EMPA VIGENTE) SEGÚN COMPENSACION Y ESTADO NUTRICIONAL .</strong></td>
                </tr>
                <tr>
                    <td colspan='2' rowspan='3' style="text-align:center; vertical-align:middle"><strong>CONCEPTO</strong></td>
                    <td colspan='3' rowspan='2' style="text-align:center; vertical-align:middle"><strong>TOTAL</strong></td>
                    <td colspan='16' align='center'><strong>GRUPOS DE EDAD (en años) Y SEXO</strong></td>
                    <td colspan='2' rowspan='2' align='center'><strong>Pueblos Originarios</strong></td>
                    <td colspan='2' rowspan='2' align='center'><strong>Población Inmigrantes</strong></td>
                </tr>
                <tr>
                    <td colspan='2' align='center'><strong>25 a 29 años</strong></td>
                    <td colspan='2' align='center'><strong>30 a 34 años</strong></td>
                    <td colspan='2' align='center'><strong>35 a 39 años</strong></td>
                    <td colspan='2' align='center'><strong>40 a 44 años</strong></td>
                    <td colspan='2' align='center'><strong>45 a 49 años</strong></td>
                    <td colspan='2' align='center'><strong>50 a 54 años</strong></td>
                    <td colspan='2' align='center'><strong>55 a 59 años</strong></td>
                    <td colspan='2' align='center'><strong>60 a 64 años</strong></td>
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
                          FROM (select c.* from 2019prestaciones c where c.codigo_prestacion in("P4201800","P4201900","P4202000","P4202010","P4202020","P4202030","P4202040") AND c.serie = "P") a
                          left join 2019rems b on (a.id_prestacion=b.prestacion_id_prestacion)
                          AND (b.Mes in ('.$mes.')) AND (b.establecimiento_id_establecimiento in ('.$estab.'))
                          group by  a.codigo_prestacion,a.descripcion,a.id_prestacion
                          order by a.id_prestacion';
                $registro = DB::connection('mysql_rem')->select($query);

                $i=0;

                foreach($registro as $row ){
                    $nombre_descripcion = $row->codigo_prestacion;
                    if ($nombre_descripcion == "P4201800"){
                        $nombre_descripcion = "POBLACIÓN BAJO CONTROL (EMPA VIGENTE)";
                    }
                    if ($nombre_descripcion == "P4201900"){
                        $nombre_descripcion = "PRESIÓN ARTERIAL ELEVADA (= >140/90 mmHg)";
                    }
                    if ($nombre_descripcion == "P4202000"){
                        $nombre_descripcion = "COLESTEROL ELEVADO (= > 200 mg/dl)";
                    }

                    if ($nombre_descripcion == "P4202010"){
                        $nombre_descripcion = "NORMAL";
                    }
                    if ($nombre_descripcion == "P4202020"){
                        $nombre_descripcion = "BAJO PESO";
                    }
                    if ($nombre_descripcion == "P4202030"){
                        $nombre_descripcion = "SOBRE PESO";
                    }
                    if ($nombre_descripcion == "P4202040"){
                        $nombre_descripcion = "OBESO";
                    }
                    ?>
                <tr>
                    <?php
                    if($i>=0 && $i<=2){?>
                    <td colspan="2" align='left' nowrap="nowrap"><?php echo $nombre_descripcion; ?></td>
                    <?php
                    }
                    if($i==3){?>
                    <td rowspan='4' style="text-align:center; vertical-align:middle">ESTADO NUTRICIONAL</td>
                    <?php
                    }
                    if($i>=3 && $i<=6){?>
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

    </div>
<?php
}
?>

@endsection

@section('custom_js')
    <script src="{{ asset('js/show_hide_tab.js') }}" defer></script>
    <script src="{{ asset('js/bootstrap-multiselect.js') }}" defer></script>
@endsection
