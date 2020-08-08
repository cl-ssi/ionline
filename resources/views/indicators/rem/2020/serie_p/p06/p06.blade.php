@extends('layouts.app')

@section('title', 'Resumen Estadistico Mensual')

@section('content')

<?php

use Illuminate\Support\Facades\DB;

?>

@include('indicators.rem.partials.navP')

<h3>REM-P6. POBLACIÓN EN CONTROL PROGRAMA DE SALUD MENTAL EN ATENCIÓN PRIMARIA Y ESPECIALIDAD.</h3>

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
                    <td colspan="46" class="active"><strong>A. ATENCIÓN PRIMARIA.</strong></td>
                </tr>
                <tr>
                    <td colspan="46" class="active"><strong>SECCION A.1: POBLACIÓN EN CONTROL EN APS AL CORTE.</strong></td>
                </tr>
                <tr>
                    <td colspan='2' rowspan='3' style="text-align:center; vertical-align:middle"><strong>CONCEPTO</strong></td>
                    <td colspan='3' rowspan='2' align='center'><strong>TOTAL</strong></td>
                    <td colspan='34' align='center'><strong>GRUPO DE EDAD (en años)</strong></td>
                    <td rowspan='3' align='center'><strong>Gestantes</strong></td>
                    <td rowspan='3' align='center'><strong>Madre de Hijo menor de 5 años</strong></td>
                    <td colspan='2' rowspan='2' align='center'><strong>Pueblos Originarios</strong></td>
                    <td colspan='2' rowspan='2' align='center'><strong>Población Migrantes</strong></td>
                    <td rowspan='3' align='center'><strong>Niños, Niñas, Adolescentes y Jóvenes de Población SENAME</strong></td>
                </tr>
                <tr>
                    <td colspan='2' align='center'><strong><font size=1>0 a 4 años</font></strong></td>
                    <td colspan='2' align='center'><strong><font size=1>5 a 9 años</font></strong></td>
                    <td colspan='2' align='center'><strong><font size=1>10 a 14 años</font></strong></td>
                    <td colspan='2' align='center'><strong><font size=1>15 a 19 años</font></strong></td>
                    <td colspan='2' align='center'><strong><font size=1>20 a 24 años</font></strong></td>
                    <td colspan='2' align='center'><strong><font size=1>25 a 29 años</font></strong></td>
                    <td colspan='2' align='center'><strong><font size=1>30 a 34 años</font></strong></td>
                    <td colspan='2' align='center'><strong><font size=1>35 a 39 años</font></strong></td>
                    <td colspan='2' align='center'><strong><font size=1>40 a 44 años</font></strong></td>
                    <td colspan='2' align='center'><strong><font size=1>45 a 49 años</font></strong></td>
                    <td colspan='2' align='center'><strong><font size=1>50 a 54 años</font></strong></td>
                    <td colspan='2' align='center'><strong><font size=1>55 a 59 años</font></strong></td>
                    <td colspan='2' align='center'><strong><font size=1>60 a 64 años</font></strong></td>
                    <td colspan='2' align='center'><strong><font size=1>65 a 69 años</font></strong></td>
                    <td colspan='2' align='center'><strong><font size=1>70 a 74 años</font></strong></td>
                    <td colspan='2' align='center'><strong><font size=1>75 a 79 años</font></strong></td>
                    <td colspan='2' align='center'><strong><font size=1>80 y más años</font></strong></td>
                </tr>
                <tr>
                    <td align='center'><strong><font size=1>Ambos sexos</font></strong></td>
                    <td align='center'><strong><font size=1>Hombres</font></strong></td>
                    <td align='center'><strong><font size=1>Mujeres</font></strong></td>
                    <td align='center'><strong><font size=1>Hombres</font></strong></td>
                    <td align='center'><strong><font size=1>Mujeres</font></strong></td>
                    <td align='center'><strong><font size=1>Hombres</font></strong></td>
                    <td align='center'><strong><font size=1>Mujeres</font></strong></td>
                    <td align='center'><strong><font size=1>Hombres</font></strong></td>
                    <td align='center'><strong><font size=1>Mujeres</font></strong></td>
                    <td align='center'><strong><font size=1>Hombres</font></strong></td>
                    <td align='center'><strong><font size=1>Mujeres</font></strong></td>
                    <td align='center'><strong><font size=1>Hombres</font></strong></td>
                    <td align='center'><strong><font size=1>Mujeres</font></strong></td>
                    <td align='center'><strong><font size=1>Hombres</font></strong></td>
                    <td align='center'><strong><font size=1>Mujeres</font></strong></td>
                    <td align='center'><strong><font size=1>Hombres</font></strong></td>
                    <td align='center'><strong><font size=1>Mujeres</font></strong></td>
                    <td align='center'><strong><font size=1>Hombres</font></strong></td>
                    <td align='center'><strong><font size=1>Mujeres</font></strong></td>
                    <td align='center'><strong><font size=1>Hombres</font></strong></td>
                    <td align='center'><strong><font size=1>Mujeres</font></strong></td>
                    <td align='center'><strong><font size=1>Hombres</font></strong></td>
                    <td align='center'><strong><font size=1>Mujeres</font></strong></td>
                    <td align='center'><strong><font size=1>Hombres</font></strong></td>
                    <td align='center'><strong><font size=1>Mujeres</font></strong></td>
                    <td align='center'><strong><font size=1>Hombres</font></strong></td>
                    <td align='center'><strong><font size=1>Mujeres</font></strong></td>
                    <td align='center'><strong><font size=1>Hombres</font></strong></td>
                    <td align='center'><strong><font size=1>Mujeres</font></strong></td>
                    <td align='center'><strong><font size=1>Hombres</font></strong></td>
                    <td align='center'><strong><font size=1>Mujeres</font></strong></td>
                    <td align='center'><strong><font size=1>Hombres</font></strong></td>
                    <td align='center'><strong><font size=1>Mujeres</font></strong></td>
                    <td align='center'><strong><font size=1>Hombres</font></strong></td>
                    <td align='center'><strong><font size=1>Mujeres</font></strong></td>
                    <td align='center'><strong><font size=1>Hombres</font></strong></td>
                    <td align='center'><strong><font size=1>Mujeres</font></strong></td>
                    <td align='center'><strong><font size=1>Hombres</font></strong></td>
                    <td align='center'><strong><font size=1>Mujeres</font></strong></td>
                    <td align='center'><strong><font size=1>Hombres</font></strong></td>
                    <td align='center'><strong><font size=1>Mujeres</font></strong></td>
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
                          FROM (select c.* from 2020prestaciones c where c.codigo_prestacion in("P6221000") AND c.serie = "P") a
                          left join 2020rems b on (a.id_prestacion=b.prestacion_id_prestacion)
                          AND (b.Mes in ('.$mes.')) AND (b.establecimiento_id_establecimiento in ('.$estab.'))
                          group by  a.codigo_prestacion,a.descripcion,a.id_prestacion
                          order by a.id_prestacion';
                $registro = DB::connection('mysql_rem')->select($query);

                $i=0;

                foreach($registro as $row ){
                    $nombre_descripcion = $row->codigo_prestacion;
                    if ($nombre_descripcion == "P6221000"){
                        $nombre_descripcion = "NÚMERO DE PERSONAS EN CONTROL EN EL PROGRAMA";
                    }
                    ?>

                <tr>
                    <td colspan="2" align='left' nowrap="nowrap"><strong><?php echo $nombre_descripcion; ?></strong></td>
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
                <tr>
                    <td colspan="46" align='left' nowrap="nowrap"><strong>FACTORES DE RIESGO Y CONDICIONANTES DE LA SALUD MENTAL</strong></td>
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
                          FROM (select c.* from 2020prestaciones c where c.codigo_prestacion in("P6221100","P6221200",
                                                                                                "P6221500",
                                                                                                -- "P6230600","P6230700",
                                                                                                "P6230800","P6230900",
                                                                                                "P6227601",
                                                                                                "P6221600","P6227500","P6227600","P6221700","P6221800",
                                                                                                "P6221900","P6222000","P6222100",
                                                                                                "P6222600","P6223060","P6223070","P6223080",
                                                                                                "P6231000","P6231100","P6231200","P6231300","P6231400","P6231500",
                                                                                                "P6222300","P6230100","P6230200",
                                                                                                "P6222400","P6227400","P6222500","P6222800","P6222900","P6223000","P6231600","P6227602") AND c.serie = "P") a
                          left join 2020rems b on (a.id_prestacion=b.prestacion_id_prestacion)
                          AND (b.Mes in ('.$mes.')) AND (b.establecimiento_id_establecimiento in ('.$estab.'))
                          group by  a.codigo_prestacion,a.descripcion,a.id_prestacion
                          order by a.id_prestacion';
                $registro = DB::connection('mysql_rem')->select($query);

                $i=0;

                foreach($registro as $row ){

                    $nombre_descripcion = $row->codigo_prestacion;
                    if ($nombre_descripcion == "P6221100"){
                        $nombre_descripcion = "VICTIMA";
                    }

                    if ($nombre_descripcion == "P6221200"){
                        $nombre_descripcion = "AGRESOR/A";
                    }
                    if ($nombre_descripcion == "P6221500"){
                        $nombre_descripcion = "ABUSO SEXUAL";
                    }

                    // if ($nombre_descripcion == "P6230600"){
                    //     $nombre_descripcion = "SOSPECHA";
                    // }
                    // if ($nombre_descripcion == "P6230700"){
                    //     $nombre_descripcion = "CONFIRMACION";
                    // }

                    if ($nombre_descripcion == "P6230800"){
                        $nombre_descripcion = "IDEACION";
                    }
                    if ($nombre_descripcion == "P6230900"){
                        $nombre_descripcion = "INTENTO";
                    }

                    if ($nombre_descripcion == "P6227601"){
                        $nombre_descripcion = "PERSONAS CON DIAGNOSTICOS DE TRASTORNOS MENTALES";
                    }

                    if ($nombre_descripcion == "P6221600"){
                        $nombre_descripcion = "DEPRESIÓN LEVE";
                    }
                    if ($nombre_descripcion == "P6227500"){
                        $nombre_descripcion = "DEPRESIÓN MODERADA";
                    }
                    if ($nombre_descripcion == "P6227600"){
                        $nombre_descripcion = "DEPRESIÓN GRAVE";
                    }
                    if ($nombre_descripcion == "P6221700"){
                        $nombre_descripcion = "DEPRESIÓN POST PARTO";
                    }
                    if ($nombre_descripcion == "P6221800"){
                        $nombre_descripcion = "TRASTORNO BIPOLAR";
                    }

                    if ($nombre_descripcion == "P6221900"){
                        $nombre_descripcion = "CONSUMO PERJUDICIAL O DEPENDENCIA DE ALCOHOL";
                    }
                    if ($nombre_descripcion == "P6222000"){
                        $nombre_descripcion = "CONSUMO PERJUDICIAL O DEPENDENCIA COMO DROGA PRINCIPAL";
                    }
                    if ($nombre_descripcion == "P6222100"){
                        $nombre_descripcion = "POLICONSUMO";
                    }

                    if ($nombre_descripcion == "P6222600"){
                        $nombre_descripcion = "TRASTORNO HIPERCINETICOS";
                    }
                    if ($nombre_descripcion == "P6223060"){
                        $nombre_descripcion = "TRASTORNO DISOCIAL DESAFIANTE Y OPOSICIONISTA";
                    }
                    if ($nombre_descripcion == "P6223070"){
                        $nombre_descripcion = "TRASTORNO DE ANSIEDAD DE SEPARACIÓN EN LA INFANCIA";
                    }
                    if ($nombre_descripcion == "P6223080"){
                        $nombre_descripcion = "OTROS TRASTORNOS DEL COMPORTAMIENTO Y DE LAS EMOCIONES DE COMIENZO HABITUAL EN LA INFANCIA Y ADOLESCENCIA";
                    }

                    if ($nombre_descripcion == "P6231000"){
                        $nombre_descripcion = "TRASTORNO DE ESTRÉS POST TRAUMATICO";
                    }
                    if ($nombre_descripcion == "P6231100"){
                        $nombre_descripcion = "TRASTORNO DE PANICO CON AGOROFOBIA";
                    }
                    if ($nombre_descripcion == "P6231200"){
                        $nombre_descripcion = "TRASTORNO DE PANICO SIN AGOROFOBIA";
                    }
                    if ($nombre_descripcion == "P6231300"){
                        $nombre_descripcion = "FOBIAS SOCIALES";
                    }
                    if ($nombre_descripcion == "P6231400"){
                        $nombre_descripcion = "TRASTORNOS DE ANSIEDAD GENERALIZADA";
                    }
                    if ($nombre_descripcion == "P6231500"){
                        $nombre_descripcion = "OTROS TRASTORNOS DE ANSIEDAD";
                    }

                    if ($nombre_descripcion == "P6222300"){
                        $nombre_descripcion = "LEVE";
                    }
                    if ($nombre_descripcion == "P6230100"){
                        $nombre_descripcion = "MODERADO";
                    }
                    if ($nombre_descripcion == "P6230200"){
                        $nombre_descripcion = "AVANZADO";
                    }

                    if ($nombre_descripcion == "P6222400"){
                        $nombre_descripcion = "ESQUIZOFRENIA";
                    }
                    if ($nombre_descripcion == "P6227400"){
                        $nombre_descripcion = "PRIMER EPISODIO ESQUIZOFRENIA CON OCUPACION REGULAR";
                    }
                    if ($nombre_descripcion == "P6222500"){
                        $nombre_descripcion = "TRANSTORNO DE LA CONDUCTA ALIMENTARIA";
                    }
                    if ($nombre_descripcion == "P6222800"){
                        $nombre_descripcion = "RETRASO MENTAL";
                    }
                    if ($nombre_descripcion == "P6222900"){
                        $nombre_descripcion = "TRANSTORNO DE PERSONALIDAD";
                    }
                    if ($nombre_descripcion == "P6223000"){
                        $nombre_descripcion = "TRANSTORNO GENERALIZADOS DEL DESARROLLO";
                    }
                    if ($nombre_descripcion == "P6231600"){
                        $nombre_descripcion = "EPILEPSIA";
                    }
                    if ($nombre_descripcion == "P6227602"){
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
                    <td align='left' nowrap="nowrap"><?php echo $nombre_descripcion; ?></td>
                    <?php
                    }
                    if($i==2){?>
                    <td colspan="2" align='left' nowrap="nowrap"><?php echo $nombre_descripcion; ?></td>
                    <?php
                    }
                    if($i==3){?>
                    <td rowspan="2" style="text-align:center; vertical-align:middle">SUICIDIO</td>
                    <?php
                    }
                    if($i>=3 && $i<=4){?>
                    <td style="text-align:center; vertical-align:middle"><?php echo $nombre_descripcion; ?></td>
                    <?php
                    }
                    if($i==5){?>
                    <td colspan="2" align='left' nowrap="nowrap"><?php echo $nombre_descripcion; ?></td>
                    <?php
                    }
                    if($i==6){?>
                    <td rowspan="5" style="text-align:center; vertical-align:middle">TRANSTORNOS DEL HUMOR (AFECTIVOS)</td>
                    <?php
                    }
                    if($i>=6 && $i<=10){?>
                    <td align='left' nowrap="nowrap"><?php echo $nombre_descripcion; ?></td>
                    <?php
                    }
                    if($i==11){?>
                    <td rowspan="3" style="text-align:center; vertical-align:middle">TRANSTORNOS MENTALES Y DEL COMPORTAMIENTO DEBIDO A CONSUMO SUSTANCIAS PSICOTROPICAS</td>
                    <?php
                    }
                    if($i>=11 && $i<=13){?>
                    <td align='left' nowrap="nowrap"><?php echo $nombre_descripcion; ?></td>
                    <?php
                    }
                    if($i==14){?>
                    <td rowspan="4" style="text-align:center; vertical-align:middle">TRASTORNOS DEL COMPORTAMIENTO Y DE LAS EMOCIONES DE COMIENZO HABITUAL EN LA INFANCIA Y ADOLESCENCIA</td>
                    <?php
                    }
                    if($i>=14 && $i<=17){?>
                    <td align='left'><?php echo $nombre_descripcion; ?></td>
                    <?php
                    }
                    if($i==18){?>
                    <td rowspan="6" style="text-align:center; vertical-align:middle">TRASTORNOS DE ANSIEDAD</td>
                    <?php
                    }
                    if($i>=18 && $i<=23){?>
                    <td align='left'><?php echo $nombre_descripcion; ?></td>
                    <?php
                    }
                    if($i==24){?>
                    <td rowspan="3" style="text-align:center; vertical-align:middle">DEMENCIAS (INCLUYE ALZHEIMER)</td>
                    <?php
                    }
                    if($i>=24 && $i<=26){?>
                    <td align='left'><?php echo $nombre_descripcion; ?></td>
                    <?php
                    }

                    if($i>=27 && $i<=36){?>
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
                    <td align='right'><?php echo number_format($row->Col44,0,",",".")?></td>
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
    <div class="col-sm tab table-responsive" id="A2">
        <table class="table table-hover table-bordered table-sm">
            <thead>
                <tr>
                    <td colspan="39" class="active"><strong>SECCION A.2: PROGRAMA DE REHABILITACIÓN EN ATENCION PRIMARIA (PERSONAS CON TRANSTORNOS PSIQUIÁTRICO).</strong></td>
                </tr>
                <tr>
                    <td rowspan='3' style="text-align:center; vertical-align:middle"><strong>TIPO</strong></td>
                    <td rowspan='3' style="text-align:center; vertical-align:middle"><strong>RUBRO</strong></td>
                    <td colspan='3' rowspan='2' style="text-align:center; vertical-align:middle"><strong>TOTAL</strong></td>
                    <td colspan='34' align='center'><strong>GRUPO DE EDAD (en años)</strong></td>
                </tr>
                <tr>
                    <td colspan='2' align='center'><strong>0 a 4 años</strong></td>
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
                          FROM (select c.* from 2020prestaciones c where c.codigo_prestacion in("P6223040","P6223050") AND c.serie = "P") a
                          left join 2020rems b on (a.id_prestacion=b.prestacion_id_prestacion)
                          AND (b.Mes in ('.$mes.')) AND (b.establecimiento_id_establecimiento in ('.$estab.'))
                          group by  a.codigo_prestacion,a.descripcion,a.id_prestacion
                          order by a.id_prestacion';
                $registro = DB::connection('mysql_rem')->select($query);

                $i=0;

                foreach($registro as $row ){
                    $nombre_descripcion = $row->codigo_prestacion;
                    if ($nombre_descripcion == "P6223040"){
                        $nombre_descripcion = "Nº DE PERSONAS EN CONTROL EN EL PROGRAMA";
                    }
                    if ($nombre_descripcion == "P6223050"){
                        $nombre_descripcion = "Nº DE PERSONAS EN CONTROL EN EL PROGRAMA";
                    }
                    ?>

                <tr>
                    <?php
                    if($i==0){?>
                    <td align='left' nowrap="nowrap">PROGRAMA DE REHABILITACION TIPO I</td>
                    <?php
                    }
                    if($i==1){?>
                    <td align='left' nowrap="nowrap">PROGRAMA DE REHABILITACION TIPO II</td>
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
                    <?php
                    $i++;
                }
                ?>
                </tr>
            </tbody>
        </table>
    </div>

    <br>

    <!-- SECCION A.3 -->
    <div class="col-sm tab table-responsive" id="A3">
        <table class="table table-hover table-bordered table-sm">
            <thead>
                <tr>
                    <td colspan="39" class="active"><strong>SECCION A.3: PROGRAMA DE ACOMPAÑAMIENTO PSICOSOCIAL EN LA ATENCION PRIMARIA.</strong></td>
                </tr>
                <tr>
                    <td rowspan="3" style="text-align:center; vertical-align:middle"><strong>CONCEPTO</strong></td>
                    <td colspan="3" rowspan="2" style="text-align:center; vertical-align:middle"><strong>TOTAL</strong></td>
                    <td colspan="10" align="center"><strong>GRUPOS DE EDAD (en años)</strong></td>
                    <td rowspan="2" colspan="2" align="center"><strong>Población Migrantes</strong></td>
                </tr>
                <tr>
                    <td colspan="2" align="center"><strong>0 a 4 años</strong></td>
                    <td colspan="2" align="center"><strong>5 a 9 años</strong></td>
                    <td colspan="2" align="center"><strong>10 a 14 años</strong></td>
                    <td colspan="2" align="center"><strong>15 a 19 años</strong></td>
                    <td colspan="2" align="center"><strong>20 a 24 años</strong></td>
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
                          FROM (select c.* from 2020prestaciones c where c.codigo_prestacion in("P6230300") AND c.serie = "P") a
                          left join 2020rems b on (a.id_prestacion=b.prestacion_id_prestacion)
                          AND (b.Mes in ('.$mes.')) AND (b.establecimiento_id_establecimiento in ('.$estab.'))
                          group by  a.codigo_prestacion,a.descripcion,a.id_prestacion
                          order by a.id_prestacion';
                $registro = DB::connection('mysql_rem')->select($query);

                $i=0;

                foreach($registro as $row ){
                    $nombre_descripcion = $row->codigo_prestacion;
                    if ($nombre_descripcion == "P6230300"){
                        $nombre_descripcion = "NUMERO PERSONA EN CONTROL EN PROGRAMA DE ACOMPAÑAMIENTO PSICOSOCIAL";
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
                    <?php
                    $i++;
                }
                ?>
                </tr>
            </tbody>
        </table>
    </div>

    <br>

    <!-- SECCION B.1 -->
    <div class="col-sm tab table-responsive" id="B1">
        <table class="table table-hover table-bordered table-sm">
            <thead>
                <tr>
                    <td colspan="47" class="active"><strong>B. ATENCIÓN DE ESPECIALIDADES.</strong></td>
                </tr>
                <tr>
                    <td colspan="47" class="active"><strong>SECCION B.1: POBLACIÓN EN CONTROL EN ESPECIALIDAD AL CORTE.</strong></td>
                </tr>
                <tr>
                    <td colspan='2' rowspan='3' style="text-align:center; vertical-align:middle"><strong>CONCEPTO</strong></td>
                    <td colspan='3' rowspan='2' align='center'><strong>TOTAL</strong></td>
                    <td colspan='34' align='center'><strong>GRUPO DE EDAD (en años)</strong></td>
                    <td rowspan='3' align='center'><strong>Gestantes</strong></td>
                    <td rowspan='3' align='center'><strong>Madre de Hijo menor de 5 años</strong></td>
                    <td colspan='2' rowspan='2' align='center'><strong>Pueblos Originarios</strong></td>
                    <td colspan='2' rowspan='2' align='center'><strong>Población Migrantes</strong></td>
                    <td rowspan='3' align='center'><strong>Niños, Niñas, Adolescentes y Jóvenes de Población SENAME</strong></td>
                    <td rowspan='3' align='center'><strong>Plan Cuidado Integral Elaborado</strong></td>
                </tr>
                <tr>
                    <td colspan='2' align='center'><strong><font size=1>0 a 4 años</font></strong></td>
                    <td colspan='2' align='center'><strong><font size=1>5 a 9 años</font></strong></td>
                    <td colspan='2' align='center'><strong><font size=1>10 a 14 años</font></strong></td>
                    <td colspan='2' align='center'><strong><font size=1>15 a 19 años</font></strong></td>
                    <td colspan='2' align='center'><strong><font size=1>20 a 24 años</font></strong></td>
                    <td colspan='2' align='center'><strong><font size=1>25 a 29 años</font></strong></td>
                    <td colspan='2' align='center'><strong><font size=1>30 a 34 años</font></strong></td>
                    <td colspan='2' align='center'><strong><font size=1>35 a 39 años</font></strong></td>
                    <td colspan='2' align='center'><strong><font size=1>40 a 44 años</font></strong></td>
                    <td colspan='2' align='center'><strong><font size=1>45 a 49 años</font></strong></td>
                    <td colspan='2' align='center'><strong><font size=1>50 a 54 años</font></strong></td>
                    <td colspan='2' align='center'><strong><font size=1>55 a 59 años</font></strong></td>
                    <td colspan='2' align='center'><strong><font size=1>60 a 64 años</font></strong></td>
                    <td colspan='2' align='center'><strong><font size=1>65 a 69 años</font></strong></td>
                    <td colspan='2' align='center'><strong><font size=1>70 a 74 años</font></strong></td>
                    <td colspan='2' align='center'><strong><font size=1>75 a 79 años</font></strong></td>
                    <td colspan='2' align='center'><strong><font size=1>80 y más años</font></strong></td>
                </tr>
                <tr>
                    <td align='center'><strong><font size=1>Ambos sexos</font></strong></td>
                    <td align='center'><strong><font size=1>Hombres</font></strong></td>
                    <td align='center'><strong><font size=1>Mujeres</font></strong></td>
                    <td align='center'><strong><font size=1>Hombres</font></strong></td>
                    <td align='center'><strong><font size=1>Mujeres</font></strong></td>
                    <td align='center'><strong><font size=1>Hombres</font></strong></td>
                    <td align='center'><strong><font size=1>Mujeres</font></strong></td>
                    <td align='center'><strong><font size=1>Hombres</font></strong></td>
                    <td align='center'><strong><font size=1>Mujeres</font></strong></td>
                    <td align='center'><strong><font size=1>Hombres</font></strong></td>
                    <td align='center'><strong><font size=1>Mujeres</font></strong></td>
                    <td align='center'><strong><font size=1>Hombres</font></strong></td>
                    <td align='center'><strong><font size=1>Mujeres</font></strong></td>
                    <td align='center'><strong><font size=1>Hombres</font></strong></td>
                    <td align='center'><strong><font size=1>Mujeres</font></strong></td>
                    <td align='center'><strong><font size=1>Hombres</font></strong></td>
                    <td align='center'><strong><font size=1>Mujeres</font></strong></td>
                    <td align='center'><strong><font size=1>Hombres</font></strong></td>
                    <td align='center'><strong><font size=1>Mujeres</font></strong></td>
                    <td align='center'><strong><font size=1>Hombres</font></strong></td>
                    <td align='center'><strong><font size=1>Mujeres</font></strong></td>
                    <td align='center'><strong><font size=1>Hombres</font></strong></td>
                    <td align='center'><strong><font size=1>Mujeres</font></strong></td>
                    <td align='center'><strong><font size=1>Hombres</font></strong></td>
                    <td align='center'><strong><font size=1>Mujeres</font></strong></td>
                    <td align='center'><strong><font size=1>Hombres</font></strong></td>
                    <td align='center'><strong><font size=1>Mujeres</font></strong></td>
                    <td align='center'><strong><font size=1>Hombres</font></strong></td>
                    <td align='center'><strong><font size=1>Mujeres</font></strong></td>
                    <td align='center'><strong><font size=1>Hombres</font></strong></td>
                    <td align='center'><strong><font size=1>Mujeres</font></strong></td>
                    <td align='center'><strong><font size=1>Hombres</font></strong></td>
                    <td align='center'><strong><font size=1>Mujeres</font></strong></td>
                    <td align='center'><strong><font size=1>Hombres</font></strong></td>
                    <td align='center'><strong><font size=1>Mujeres</font></strong></td>
                    <td align='center'><strong><font size=1>Hombres</font></strong></td>
                    <td align='center'><strong><font size=1>Mujeres</font></strong></td>
                    <td align='center'><strong><font size=1>Hombres</font></strong></td>
                    <td align='center'><strong><font size=1>Mujeres</font></strong></td>
                    <td align='center'><strong><font size=1>Hombres</font></strong></td>
                    <td align='center'><strong><font size=1>Mujeres</font></strong></td>
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
                          FROM (select c.* from 2020prestaciones c where c.codigo_prestacion in("P6223090") AND c.serie = "P") a
                          left join 2020rems b on (a.id_prestacion=b.prestacion_id_prestacion)
                          AND (b.Mes in ('.$mes.')) AND (b.establecimiento_id_establecimiento in ('.$estab.'))
                          group by  a.codigo_prestacion,a.descripcion,a.id_prestacion
                          order by a.id_prestacion';
                $registro = DB::connection('mysql_rem')->select($query);

                $i=0;

                foreach($registro as $row ){
                    $nombre_descripcion = $row->codigo_prestacion;
                    if ($nombre_descripcion == "P6223090"){
                        $nombre_descripcion = "NÚMERO DE PERSONAS EN CONTROL EN EL PROGRAMA";
                    }
                    ?>

                <tr>
                    <td colspan="2" align='left' nowrap="nowrap"><strong><?php echo $nombre_descripcion; ?></strong></td>
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
                <tr>
                    <td colspan="46" align='left' nowrap="nowrap"><strong>FACTORES DE RIESGO Y CONDICIONANTES DE LA SALUD MENTAL</strong></td>
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
                          FROM (select c.* from 2020prestaciones c where c.codigo_prestacion in("P6223100","P6223110",
                                                                                                "P6223140",
                                                                                                -- "P6231700","P6231800",
                                                                                                "P6231900","P6232000",
                                                                                                "P6223170",
                                                                                                "P6223180","P6223190","P6223200","P6223210","P6223220",
                                                                                                "P6223230","P6223240","P6223250",
                                                                                                "P6223260","P6223270","P6223280","P6223290",
                                                                                                "P6232100","P6232200","P6232300","P6232400","P6232500","P6232600",
                                                                                                "P6223310","P6230400","P6230500",
                                                                                                "P6223330","P6223340","P6223350","P6223360","P6223370","P6223380","P6232700","P6227603") AND c.serie = "P") a
                          left join 2020rems b on (a.id_prestacion=b.prestacion_id_prestacion)
                          AND (b.Mes in ('.$mes.')) AND (b.establecimiento_id_establecimiento in ('.$estab.'))
                          group by  a.codigo_prestacion,a.descripcion,a.id_prestacion
                          order by a.id_prestacion';
                $registro = DB::connection('mysql_rem')->select($query);

                $i=0;

                foreach($registro as $row ){

                    $nombre_descripcion = $row->codigo_prestacion;
                    if ($nombre_descripcion == "P6223100"){
                        $nombre_descripcion = "VICTIMA";
                    }

                    if ($nombre_descripcion == "P6223110"){
                        $nombre_descripcion = "AGRESOR/A";
                    }
                    if ($nombre_descripcion == "P6223140"){
                        $nombre_descripcion = "ABUSO SEXUAL";
                    }

                    // if ($nombre_descripcion == "P6231700"){
                    //     $nombre_descripcion = "SOSPECHA";
                    // }
                    // if ($nombre_descripcion == "P6231800"){
                    //     $nombre_descripcion = "CONFIRMACION";
                    // }

                    if ($nombre_descripcion == "P6231900"){
                        $nombre_descripcion = "IDEACION";
                    }
                    if ($nombre_descripcion == "P6232000"){
                        $nombre_descripcion = "INTENTO";
                    }

                    if ($nombre_descripcion == "P6223170"){
                        $nombre_descripcion = "PERSONAS CON DIAGNOSTICOS DE TRASTORNOS MENTALES";
                    }

                    if ($nombre_descripcion == "P6223180"){
                        $nombre_descripcion = "DEPRESIÓN REFRACTARIA";
                    }
                    if ($nombre_descripcion == "P6223190"){
                        $nombre_descripcion = "DEPRESIÓN GRAVE CON PSICOSIS";
                    }
                    if ($nombre_descripcion == "P6223200"){
                        $nombre_descripcion = "DEPRESIÓN CON ALTO RIESGO SUICIDA";
                    }
                    if ($nombre_descripcion == "P6223210"){
                        $nombre_descripcion = "DEPRESIÓN POST PARTO";
                    }
                    if ($nombre_descripcion == "P6223220"){
                        $nombre_descripcion = "TRASTORNO BIPOLAR";
                    }

                    if ($nombre_descripcion == "P6223230"){
                        $nombre_descripcion = "CONSUMO PERJUDICIAL O DEPENDENCIA DE ALCOHOL";
                    }
                    if ($nombre_descripcion == "P6223240"){
                        $nombre_descripcion = "CONSUMO PERJUDICIAL O DEPENDENCIA COMO DROGA PRINCIPAL";
                    }
                    if ($nombre_descripcion == "P6223250"){
                        $nombre_descripcion = "POLICONSUMO";
                    }

                    if ($nombre_descripcion == "P6223260"){
                        $nombre_descripcion = "TRASTORNO HIPERCINETICOS";
                    }
                    if ($nombre_descripcion == "P6223270"){
                        $nombre_descripcion = "TRASTORNO DISOCIAL DESAFIANTE Y OPOSICIONISTA";
                    }
                    if ($nombre_descripcion == "P6223280"){
                        $nombre_descripcion = "TRASTORNO DE ANSIEDAD DE SEPARACIÓN EN LA INFANCIA";
                    }
                    if ($nombre_descripcion == "P6223290"){
                        $nombre_descripcion = "OTROS TRASTORNOS DEL COMPORTAMIENTO Y DE LAS EMOCIONES DE COMIENZO HABITUAL EN LA INFANCIA Y ADOLESCENCIA";
                    }

                    if ($nombre_descripcion == "P6232100"){
                        $nombre_descripcion = "TRASTORNO DE ESTRÉS POST TRAUMATICO";
                    }
                    if ($nombre_descripcion == "P6232200"){
                        $nombre_descripcion = "TRASTORNO DE PANICO CON AGOROFOBIA";
                    }
                    if ($nombre_descripcion == "P6232300"){
                        $nombre_descripcion = "TRASTORNO DE PANICO SIN AGOROFOBIA";
                    }
                    if ($nombre_descripcion == "P6232400"){
                        $nombre_descripcion = "FOBIAS SOCIALES";
                    }
                    if ($nombre_descripcion == "P6232500"){
                        $nombre_descripcion = "TRASTORNOS DE ANSIEDAD GENERALIZADA";
                    }
                    if ($nombre_descripcion == "P6232600"){
                        $nombre_descripcion = "OTROS TRASTORNOS DE ANSIEDAD";
                    }

                    if ($nombre_descripcion == "P6223310"){
                        $nombre_descripcion = "LEVE";
                    }
                    if ($nombre_descripcion == "P6230400"){
                        $nombre_descripcion = "MODERADO";
                    }
                    if ($nombre_descripcion == "P6230500"){
                        $nombre_descripcion = "AVANZADO";
                    }

                    if ($nombre_descripcion == "P6223330"){
                        $nombre_descripcion = "ESQUIZOFRENIA";
                    }
                    if ($nombre_descripcion == "P6223340"){
                        $nombre_descripcion = "PRIMER EPISODIO ESQUIZOFRENIA CON OCUPACION REGULAR";
                    }
                    if ($nombre_descripcion == "P6223350"){
                        $nombre_descripcion = "TRANSTORNO DE LA CONDUCTA ALIMENTARIA";
                    }
                    if ($nombre_descripcion == "P6223360"){
                        $nombre_descripcion = "RETRASO MENTAL";
                    }
                    if ($nombre_descripcion == "P6223370"){
                        $nombre_descripcion = "TRANSTORNO DE PERSONALIDAD";
                    }
                    if ($nombre_descripcion == "P6223380"){
                        $nombre_descripcion = "TRANSTORNO GENERALIZADOS DEL DESARROLLO";
                    }
                    if ($nombre_descripcion == "P6232700"){
                        $nombre_descripcion = "EPILEPSIA";
                    }
                    if ($nombre_descripcion == "P6227603"){
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
                    <td align='left' nowrap="nowrap"><?php echo $nombre_descripcion; ?></td>
                    <?php
                    }
                    if($i==2){?>
                    <td colspan="2" align='left' nowrap="nowrap"><?php echo $nombre_descripcion; ?></td>
                    <?php
                    }
                    if($i==3){?>
                    <td rowspan="2" style="text-align:center; vertical-align:middle">SUICIDIO</td>
                    <?php
                    }
                    if($i>=3 && $i<=4){?>
                    <td align='left' nowrap="nowrap"><?php echo $nombre_descripcion; ?></td>
                    <?php
                    }
                    if($i==5){?>
                    <td colspan="2" align='left' nowrap="nowrap"><strong><?php echo $nombre_descripcion; ?></strong></td>
                    <?php
                    }
                    if($i==6){?>
                    <td rowspan="5" style="text-align:center; vertical-align:middle">TRANSTORNOS DEL HUMOR (AFECTIVOS)</td>
                    <?php
                    }
                    if($i>=6 && $i<=10){?>
                    <td align='left' nowrap="nowrap"><?php echo $nombre_descripcion; ?></td>
                    <?php
                    }
                    if($i==11){?>
                    <td rowspan="3" style="text-align:center; vertical-align:middle">TRANSTORNOS MENTALES Y DEL COMPORTAMIENTO DEBIDO A CONSUMO SUSTANCIAS PSICOTROPICAS</td>
                    <?php
                    }
                    if($i>=11 && $i<=13){?>
                    <td align='left' nowrap="nowrap"><?php echo $nombre_descripcion; ?></td>
                    <?php
                    }
                    if($i==14){?>
                    <td rowspan="4" style="text-align:center; vertical-align:middle">TRASTORNOS DEL COMPORTAMIENTO Y DE LAS EMOCIONES DE COMIENZO HABITUAL EN LA INFANCIA Y ADOLESCENCIA</td>
                    <?php
                    }
                    if($i>=14 && $i<=17){?>
                    <td align='left'><?php echo $nombre_descripcion; ?></td>
                    <?php
                    }
                    if($i==18){?>
                    <td rowspan="6" style="text-align:center; vertical-align:middle">TRASTORNOS DE ANSIEDAD</td>
                    <?php
                    }
                    if($i>=18 && $i<=23){?>
                    <td align='left'><?php echo $nombre_descripcion; ?></td>
                    <?php
                    }
                    if($i==24){?>
                    <td rowspan="3" style="text-align:center; vertical-align:middle">DEMENCIAS (INCLUYE ALZHEIMER)</td>
                    <?php
                    }
                    if($i>=24 && $i<=26){?>
                    <td align='left'><?php echo $nombre_descripcion; ?></td>
                    <?php
                    }

                    if($i>=27 && $i<=36){?>
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

    <!-- SECCION B.1 -->
    <div class="col-sm tab table-responsive" id="B">
        <table class="table table-hover table-bordered table-sm">
            <thead>
                <tr>
                    <td colspan="39" class="active"><strong>SECCION B.2: PROGRAMA DE REHABILITACIÓN EN ESPECIALIDAD (PERSONAS CON TRANSTORNOS PSIQUIÁTRICO).</strong></td>
                </tr>
                <tr>
                    <td rowspan='3' style="text-align:center; vertical-align:middle"><strong>TIPO</strong></td>
                    <td rowspan='3' style="text-align:center; vertical-align:middle"><strong>RUBRO</strong></td>
                    <td colspan='3' rowspan='2' style="text-align:center; vertical-align:middle"><strong>TOTAL</strong></td>
                    <td colspan='34' align='center'><strong>GRUPO DE EDAD (en años)</strong></td>
                </tr>
                <tr>
                    <td colspan='2' align='center'><strong>0 a 4 años</strong></td>
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
                          FROM (select c.* from 2020prestaciones c where c.codigo_prestacion in("P6223390","P6223400") AND c.serie = "P") a
                          left join 2020rems b on (a.id_prestacion=b.prestacion_id_prestacion)
                          AND (b.Mes in ('.$mes.')) AND (b.establecimiento_id_establecimiento in ('.$estab.'))
                          group by  a.codigo_prestacion,a.descripcion,a.id_prestacion
                          order by a.id_prestacion';
                $registro = DB::connection('mysql_rem')->select($query);

                $i=0;

                foreach($registro as $row ){
                    $nombre_descripcion = $row->codigo_prestacion;
                    if ($nombre_descripcion == "P6223390"){
                        $nombre_descripcion = "Nº DE PERSONAS EN CONTROL EN EL PROGRAMA";
                    }
                    if ($nombre_descripcion == "P6223400"){
                        $nombre_descripcion = "Nº DE PERSONAS EN CONTROL EN EL PROGRAMA";
                    }
                    ?>

                <tr>
                    <?php
                    if($i==0){?>
                    <td align='left' nowrap="nowrap">PROGRAMA DE REHABILITACION TIPO I</td>
                    <?php
                    }
                    if($i==1){?>
                    <td align='left' nowrap="nowrap">PROGRAMA DE REHABILITACION TIPO II</td>
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
