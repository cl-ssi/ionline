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
        <div class="col-sm tab table-responsive" id="A">
        <table class="table table-hover table-bordered table-sm">
            <thead>
                <tr>
                    <td colspan="27" class="active"><strong>A: CONTROLES DE SALUD SEXUAL Y REPRODUCTIVA.</strong></td>
                </tr>
                <tr>
                    <td rowspan="2" class="centrado"><strong>TIPO DE CONTROL</strong></td>
                    <td rowspan="2" class="centrado"><strong>PROFESIONAL</strong></td>
                    <td rowspan="2" class="centrado"><strong>TOTAL</strong></td>
                    <td colspan="16" align="center"><strong>POR EDAD (en años)</strong></td>
                    <td colspan="2" align="center"><strong>SEXO</strong></td>
                    <td rowspan="2" class="centrado"><strong>BENEFI-CIARIOS</strong></td>
                    <td rowspan="2" class="centrado"><strong>CONTROL CON PAREJA FAMILIAR U OTRO</strong></td>
                    <td rowspan="2" class="centrado"><strong>CONTROL DE DIADA CON PRESENCIA DEL PADRE</strong></td>
                    <td colspan="3" class="centrado"><strong>TIPOS DE LACTANCIA</strong></td>
                </tr>
                <tr>
                    <td align="center"><strong>&nbsp;5&nbsp;-&nbsp;9&nbsp;</strong></td>
                    <td align="center"><strong>&nbsp;10&nbsp;-&nbsp;14&nbsp;</strong></td>
                    <td align="center"><strong>&nbsp;15&nbsp;-&nbsp;19&nbsp;</strong></td>
                    <td align="center"><strong>&nbsp;20&nbsp;-&nbsp;24&nbsp;</strong></td>
                    <td align="center"><strong>&nbsp;25&nbsp;-&nbsp;29&nbsp;</strong></td>
                    <td align="center"><strong>&nbsp;30&nbsp;-&nbsp;34&nbsp;</strong></td>
                    <td align="center"><strong>&nbsp;35&nbsp;-&nbsp;39&nbsp;</strong></td>
                    <td align="center"><strong>&nbsp;40&nbsp;-&nbsp;44&nbsp;</strong></td>
                    <td align="center"><strong>&nbsp;45&nbsp;-&nbsp;49&nbsp;</strong></td>
                    <td align="center"><strong>&nbsp;50&nbsp;-&nbsp;54&nbsp;</strong></td>
                    <td align="center"><strong>&nbsp;55&nbsp;-&nbsp;59&nbsp;</strong></td>
                    <td align="center"><strong>&nbsp;60&nbsp;-&nbsp;64&nbsp;</strong></td>
                    <td align="center"><strong>&nbsp;65&nbsp;-&nbsp;69&nbsp;</strong></td>
                    <td align="center"><strong>&nbsp;70&nbsp;-&nbsp;74&nbsp;</strong></td>
                    <td align="center"><strong>&nbsp;75&nbsp;-&nbsp;79&nbsp;</strong></td>
                    <td align="center"><strong>&nbsp;80&nbsp;Y&nbsp;más&nbsp;</strong></td>
                    <td align="center"><strong>&nbsp;HOMBRES&nbsp;</strong></td>
                    <td align="center"><strong>&nbsp;MUJERES&nbsp;</strong></td>
                    <td class="centrado"><strong>&nbsp;LACTANCIA MATERNA EXCLUSIVA&nbsp;</strong></td>
                    <td class="centrado"><strong>&nbsp;LACTANCIA MATERNA / LACTANCIA ARTIFICIAL&nbsp;</strong></td>
                    <td class="centrado"><strong>&nbsp;LACTANCIA ARTIFICIAL&nbsp;</strong></td>
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
                          FROM (select c.* from 2020prestaciones c where c.codigo_prestacion in("01010101","01010103","01010201","01010203","01080001","01080002",
                                                                                            "01110106","01110107","01080030","01080040","01010601","01010603",
                                                                                            "01010901","01010903","01010401","01010403") AND c.serie = "A" ) a
                          left join 2020rems b on (a.id_prestacion=b.prestacion_id_prestacion)
                          AND (b.Mes in ('.$mes.')) AND (b.establecimiento_id_establecimiento in ('.$estab.'))
                          group by  a.codigo_prestacion,a.descripcion, a.id_prestacion
                          order by a.id_prestacion';
                $registro = DB::connection('mysql_rem')->select($query);

                $i=0;

                foreach($registro as $row ){
                    $nombre_descripcion = $row->codigo_prestacion;
                    if ($nombre_descripcion == "01010101"){
                        $nombre_descripcion = "MÉDICO";
                    }
                    if ($nombre_descripcion == "01010103"){
                        $nombre_descripcion = "MATRONA (ON)";
                    }
                    if ($nombre_descripcion == "01010201"){
                        $nombre_descripcion = "MÉDICO";
                    }
                    if ($nombre_descripcion == "01010203"){
                        $nombre_descripcion = "MATRONA (ON)";
                    }
                    if ($nombre_descripcion == "01080001"){
                        $nombre_descripcion = "MÉDICO";
                    }
                    if ($nombre_descripcion == "01080002"){
                        $nombre_descripcion = "MATRONA (ON)";
                    }
                    if ($nombre_descripcion == "01110106"){
                        $nombre_descripcion = "MÉDICO";
                    }
                    if ($nombre_descripcion == "01110107"){
                        $nombre_descripcion = "MATRONA (ON)";
                    }
                    if ($nombre_descripcion == "01080030"){
                        $nombre_descripcion = "MÉDICO";
                    }
                    if ($nombre_descripcion == "01080040"){
                        $nombre_descripcion = "MATRONA (ON)";
                    }
                    if ($nombre_descripcion == "01010601"){
                        $nombre_descripcion = "MÉDICO";
                    }
                    if ($nombre_descripcion == "01010603"){
                        $nombre_descripcion = "MATRONA (ON)";
                    }
                    if ($nombre_descripcion == "01010901"){
                        $nombre_descripcion = "MÉDICO";
                    }
                    if ($nombre_descripcion == "01010903"){
                        $nombre_descripcion = "MATRONA (ON)";
                    }
                    if ($nombre_descripcion == "01010401"){
                        $nombre_descripcion = "MÉDICO";
                    }
                    if ($nombre_descripcion == "01010403"){
                        $nombre_descripcion = "MATRONA (ON)";
                    }
                ?>
                <tr>
                    <?php
                    if($i==0){?>
                        <td width='10%' rowspan='2' class="centrado">PRE-CONCEPCIONAL</td>
                    <?php
                    }
                    if($i==2){?>
                        <td width='10%' rowspan='2' class="centrado">PRENATAL</td>
                    <?php
                    }
                    if($i==4){?>
                        <td width='10%' rowspan='2' class="centrado">POST PARTO Y POST ABORTO</td>
                    <?php
                    }
                    if($i==6){?>
                        <td width='10%' rowspan='2' class="centrado">PUÉRPERA CON RECIÉN NACIDO HASTA 10 DÍAS DE VIDA</td>
                    <?php
                    }
                    if($i==8){?>
                        <td width='10%' rowspan='2' class="centrado">PUÉRPERA CON RECIÉN NACIDO ENTRE 11 y 28 DÍAS</td>
                    <?php
                    }
                    if($i==10){?>
                        <td width='10%' rowspan='2' class="centrado">GINECOLÓGICO</td>
                    <?php
                    }
                    if($i==12){?>
                        <td width='10%' rowspan='2' class="centrado">CLIMATERIO</td>
                    <?php
                    }
                    if($i==14){?>
                        <td width='10%' rowspan='2' class="centrado">REGULACIÓN DE FECUNDIDAD</td>
                    <?php
                    }
                    ?>
                    <td align='left' nowrap="nowrap"><?php echo $nombre_descripcion; ?></td>
                    <td align='right'><?php echo number_format($row->Col01,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col02,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col03,0,",",".")?></td>
                    <td width='2%' align='right'><?php echo number_format($row->Col04,0,",",".")?></td>
                    <td width='2%' align='right'><?php echo number_format($row->Col05,0,",",".")?></td>
                    <td width='2%' align='right'><?php echo number_format($row->Col06,0,",",".")?></td>
                    <td width='2%' align='right'><?php echo number_format($row->Col07,0,",",".")?></td>
                    <td width='2%' align='right'><?php echo number_format($row->Col08,0,",",".")?></td>
                    <td width='2%' align='right'><?php echo number_format($row->Col09,0,",",".")?></td>
                    <td width='2%' align='right'><?php echo number_format($row->Col10,0,",",".")?></td>
                    <td width='2%' align='right'><?php echo number_format($row->Col11,0,",",".")?></td>
                    <td width='2%' align='right'><?php echo number_format($row->Col12,0,",",".")?></td>
                    <td width='2%' align='right'><?php echo number_format($row->Col13,0,",",".")?></td>
                    <td width='2%' align='right'><?php echo number_format($row->Col14,0,",",".")?></td>
                    <td width='2%' align='right'><?php echo number_format($row->Col15,0,",",".")?></td>
                    <td width='2%' align='right'><?php echo number_format($row->Col16,0,",",".")?></td>
                    <td width='2%' align='right'><?php echo number_format($row->Col17,0,",",".")?></td>
                    <td width='2%' align='right'><?php echo number_format($row->Col18,0,",",".")?></td>
                    <td width='2%' align='right'><?php echo number_format($row->Col19,0,",",".")?></td>
                    <td width='2%' align='right'><?php echo number_format($row->Col20,0,",",".")?></td>
                    <td width='2%' align='right'><?php echo number_format($row->Col21,0,",",".")?></td>
                    <td width='2%' align='right'><?php echo number_format($row->Col22,0,",",".")?></td>
                    <td width='2%' align='right'><?php echo number_format($row->Col23,0,",",".")?></td>
                    <td width='2%' align='right'><?php echo number_format($row->Col24,0,",",".")?></td>
                    <td width='2%' align='right'><?php echo number_format($row->Col25,0,",",".")?></td>
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
                    <td colspan="38" class="active"><strong>SECCIÓN B: CONTROLES DE SALUD SEGÚN CICLO VITAL.</strong></td>
                </tr>
                <tr>
                    <td rowspan="2" class="centrado"><strong>&nbsp;TIPO&nbsp;DE&nbsp;CONTROL&nbsp;</strong></td>
                    <td rowspan="2" class="centrado"><strong>&nbsp;PROFESIONAL&nbsp;</strong></td>
                    <td colspan="3" align='center'><strong>TOTAL</strong></td>
                    <td colspan="29" align='center'><strong>POR EDAD (En años)</strong></td>
                    <td rowspan="2" class="centrado"><strong>BENEFICIARIOS</strong></td>
                    <td colspan="2" align='center'><strong>CONTROL CON PRESENCIA DEL PADRE</strong></td>
                    <td rowspan="2" class="centrado"><strong>Niños, Niñas, Adolescentes y Jóvenes Población SENAME</strong></td>
                </tr>
                <tr>
                    <td align='center'><strong>Ambos Sexos</strong></td>
                    <td align='center'><strong>Hombres</strong></td>
                    <td align='center'><strong>Mujeres</strong></td>
                    <td align='center'><strong>Menor de 1 mes</strong></td>
                    <td align='center'><strong>1 mes</strong></td>
                    <td align='center'><strong>2 meses</strong></td>
                    <td align='center'><strong>3 meses</strong></td>
                    <td align='center'><strong>4 meses</strong></td>
                    <td align='center'><strong>5 meses</strong></td>
                    <td align='center'><strong>6 meses</strong></td>
                    <td align='center'><strong>7&nbsp;-&nbsp;11<br />meses</strong></td>
                    <td align='center'><strong>12&nbsp;-&nbsp;17<br />meses</strong></td>
                    <td align='center'><strong>18&nbsp;-&nbsp;23<br />meses</strong></td>
                    <td align='center'><strong>24&nbsp;-&nbsp;47<br />meses</strong></td>
                    <td align='center'><strong>48&nbsp;-&nbsp;59<br />meses</strong></td>
                    <td align='center'><strong>60&nbsp;-&nbsp;71<br />meses</strong></td>
                    <td align='center'><strong>6&nbsp;-&nbsp;9</strong></td>
                    <td align='center'><strong>10&nbsp;-&nbsp;14</strong></td>
                    <td align='center'><strong>15&nbsp;-&nbsp;19</strong></td>
                    <td align='center'><strong>20&nbsp;-&nbsp;24</strong></td>
                    <td align='center'><strong>25&nbsp;-&nbsp;29</strong></td>
                    <td align='center'><strong>30&nbsp;-&nbsp;34</strong></td>
                    <td align='center'><strong>35&nbsp;-&nbsp;39</strong></td>
                    <td align='center'><strong>40&nbsp;-&nbsp;44</strong></td>
                    <td align='center'><strong>45&nbsp;-&nbsp;49</strong></td>
                    <td align='center'><strong>50&nbsp;-&nbsp;54</strong></td>
                    <td align='center'><strong>55&nbsp;-&nbsp;59</strong></td>
                    <td align='center'><strong>60&nbsp;-&nbsp;64</strong></td>
                    <td align='center'><strong>65&nbsp;-&nbsp;69</strong></td>
                    <td align='center'><strong>70&nbsp;-&nbsp;74</strong></td>
                    <td align='center'><strong>75&nbsp;-&nbsp;79</strong></td>
                    <td align='center'><strong>80 y mas</strong></td>
                    <td align='center'><strong>menor 1 año</strong></td>
                    <td align='center'><strong>1 año a 3 años 11 meses 29 días</strong></td>
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
                          FROM  (select c.* from 2020prestaciones c where c.codigo_prestacion in("02010101","02010201","02010103","02010105")) a
                          left join 2020rems b on (a.id_prestacion=b.prestacion_id_prestacion)
                          AND (b.Mes in ('.$mes.')) AND (b.establecimiento_id_establecimiento in ('.$estab.'))
                          group by  a.codigo_prestacion,a.descripcion, a.id_prestacion
                          order by a.id_prestacion';

                $registro = DB::connection('mysql_rem')->select($query);

                $i=0;

                foreach($registro as $row ){
                    $nombre_descripcion = $row->codigo_prestacion;
                    if ($nombre_descripcion == "02010101"){
                        $nombre_descripcion = "MÉDICO";
                    }
                    if ($nombre_descripcion == "02010201"){
                        $nombre_descripcion = "ENFERMERA (O)";
                    }
                    if ($nombre_descripcion == "02010103"){
                        $nombre_descripcion = "MATRONA (ON)";
                    }
                    if ($nombre_descripcion == "02010105"){
                        $nombre_descripcion = "TÉCNICO PARAMÉDICO";
                    }
                    ?>
                <tr>
                    <?php
                    if($i==0){?>
                    <td rowspan='4' align='center' class="centrado">DE SALUD</td>
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
                    <td colspan="40" class="active"><strong>SECCIÓN C: CONTROLES SEGÚN PROBLEMA DE SALUD.</strong></td>
                </tr>
                <tr>
                    <td rowspan="3" class="centrado"><strong>TIPO DE CONTROL</strong></td>
                    <td rowspan="3" class="centrado"><strong>PROFESIONAL</strong></td>
                    <td rowspan="2" colspan="3" class="centrado"><strong>TOTAL</strong></td>
                    <td colspan="34" align="center"><strong>POR EDAD</strong></td>
                    <td rowspan="3" class="centrado"><strong>BENEFICIARIOS</strong></td>
                </tr>
                <tr>
                    <td align="center" colspan="2"><strong>0 - 4</strong></td>
                    <td align="center" colspan="2"><strong>5 - 9</strong></td>
                    <td align="center" colspan="2"><strong>10 - 14</strong></td>
                    <td align="center" colspan="2"><strong>15 a 19</strong></td>
                    <td align="center" colspan="2"><strong>20 - 24</strong></td>
                    <td align="center" colspan="2"><strong>25 - 29</strong></td>
                    <td align="center" colspan="2"><strong>30 - 34</strong></td>
                    <td align="center" colspan="2"><strong>35 - 39</strong></td>
                    <td align="center" colspan="2"><strong>40 - 44</strong></td>
                    <td align="center" colspan="2"><strong>45 - 49</strong></td>
                    <td align="center" colspan="2"><strong>50 - 54</strong></td>
                    <td align="center" colspan="2"><strong>55 - 59</strong></td>
                    <td align="center" colspan="2"><strong>60 - 64</strong></td>
                    <td align="center" colspan="2"><strong>65 - 69</strong></td>
                    <td align="center" colspan="2"><strong>70 - 74</strong></td>
                    <td align="center" colspan="2"><strong>75 - 79</strong></td>
                    <td align="center" colspan="2"><strong>80 y mas</strong></td>
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
                          FROM  (select c.* from 2020prestaciones c where c.codigo_prestacion in("03010501","03010502","03010504","03010505","03030190","03030200","01030100A",
                                                                                              "01030200B","01030300C","01030400D","01200010","01200020","01200030","03030140",
                                                                                              "03030150","03030170","03030160","03030180","01200031","01200032","01200033",
                                                                                              "01200034","01200035")) a
                          left join 2020rems b on (a.id_prestacion=b.prestacion_id_prestacion)
                          AND (b.Mes in ('.$mes.')) AND (b.establecimiento_id_establecimiento in ('.$estab.'))
                          group by  a.codigo_prestacion,a.descripcion, a.id_prestacion
                          order by a.id_prestacion';

                $registro = DB::connection('mysql_rem')->select($query);

                $i=0;

                foreach($registro as $row ){
                    $nombre_descripcion = $row->codigo_prestacion;
                    if ($nombre_descripcion == "03010501"){
                        $nombre_descripcion = "MÉDICO";
                    }
                    if ($nombre_descripcion == "03010502"){
                        $nombre_descripcion = "ENFERMERA (O)";
                    }
                    if ($nombre_descripcion == "03010504"){
                        $nombre_descripcion = "NUTRICIONISTA";
                    }
                    if ($nombre_descripcion == "03010505"){
                        $nombre_descripcion = "TÉCNICO PARAMÉDICO";
                    }

                    if ($nombre_descripcion == "03030190"){
                        $nombre_descripcion = "MÉDICO";
                    }
                    if ($nombre_descripcion == "03030200"){
                        $nombre_descripcion = "ENFERMERA (O)";
                    }
                    if ($nombre_descripcion == "01030100A"){
                        $nombre_descripcion = "MÉDICO";
                    }
                    if ($nombre_descripcion == "01030200B"){
                        $nombre_descripcion = "ENFERMERA (O)";
                    }
                    if ($nombre_descripcion == "01030300C"){
                        $nombre_descripcion = "MÉDICO";
                    }
                    if ($nombre_descripcion == "01030400D"){
                        $nombre_descripcion = "ENFERMERA (O)";
                    }

                    if ($nombre_descripcion == "01200010"){
                        $nombre_descripcion = "MÉDICO";
                    }
                    if ($nombre_descripcion == "01200020"){
                        $nombre_descripcion = "ENFERMERA (O)";
                    }
                    if ($nombre_descripcion == "01200030"){
                        $nombre_descripcion = "MATRONA (ON)";
                    }

                    if ($nombre_descripcion == "03030140"){
                        $nombre_descripcion = "MÉDICO";
                    }
                    if ($nombre_descripcion == "03030150"){
                        $nombre_descripcion = "ENFERMERA (O)";
                    }
                    if ($nombre_descripcion == "03030170"){
                        $nombre_descripcion = "MATRONA (ON)";
                    }
                    if ($nombre_descripcion == "03030160"){
                        $nombre_descripcion = "NUTRICIONISTA";
                    }
                    if ($nombre_descripcion == "03030180"){
                        $nombre_descripcion = "TÉCNICO PARAMÉDICO";
                    }

                    if ($nombre_descripcion == "03030140"){
                        $nombre_descripcion = "MÉDICO";
                    }
                    if ($nombre_descripcion == "03030150"){
                        $nombre_descripcion = "ENFERMERA (O)";
                    }
                    if ($nombre_descripcion == "03030170"){
                        $nombre_descripcion = "MATRONA (ON)";
                    }
                    if ($nombre_descripcion == "03030160"){
                        $nombre_descripcion = "NUTRICIONISTA";
                    }
                    if ($nombre_descripcion == "03030180"){
                        $nombre_descripcion = "TÉCNICO PARAMÉDICO";
                    }
                    if ($nombre_descripcion == "01200031"){
                        $nombre_descripcion = "MÉDICO";
                    }
                    if ($nombre_descripcion == "01200032"){
                        $nombre_descripcion = "ENFERMERA (O)";
                    }
                    if ($nombre_descripcion == "01200033"){
                        $nombre_descripcion = "MATRONA (ON)";
                    }
                    if ($nombre_descripcion == "01200034"){
                        $nombre_descripcion = "NUTRICIONISTA";
                    }
                    if ($nombre_descripcion == "01200035"){
                        $nombre_descripcion = "TÉCNICO PARAMÉDICO";
                    }
                    ?>
                <tr>
                    <?php
                    if($i==0){?>
                    <td width="10%" rowspan='4' class="centrado">DE SALUD CARDIOVASCULAR</td>
                    <?php
                    }
                    if($i==4){?>
                    <td rowspan='2' class="centrado">DE TUBERCULOSIS</td>
                    <?php }
                    if($i==6){?>
                    <td rowspan='2' class="centrado">SEGUIMIENTO AUTOVALENTE CON RIESGO</td>
                    <?php
                    }
                    if($i==8){?>
                    <td rowspan='2' class="centrado">SEGUIMIENTO RIESGO DEPENDENCIA</td>
                    <?php
                    }
                    if($i==10){?>
                    <td rowspan='3' class="centrado">DE INFECCIÓN TRANSMISIÓN SEXUAL</td>
                    <?php
                    }
                    if($i==13){ ?>
                    <td rowspan='5' class="centrado">OTROS PROBLEMAS DE SALUD</td>
                    <?php
                    }
                    if($i==18){?>
                    <td rowspan='5' class="centrado">NIÑOS CON NECESIDADES ESPECIALES</td>
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
                        <td colspan="7" class="active"><strong>SECCIÓN D: CONTROL DE SALUD INTEGRAL DE ADOLESCENTES (Incluidos en sección B).</strong></td>
                    </tr>
                    <tr>
                         <td rowspan="2" style="text-align:center; vertical-align:middle"><strong>LUGAR DEL CONTROL, SEGÚN EDAD</strong></td>
                         <td colspan="3" align="center"><strong>10 A 14 AÑOS</strong></td>
                         <td colspan="3" align="center"><strong>15 A 19 AÑOS</strong></td>
                    </tr>
                    <tr>
                        <td align="center"><strong>AMBOS SEXOS</strong></td>
                        <td align="center"><strong>HOMBRES</strong></td>
                        <td align="center"><strong>MUJERES</strong></td>
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
                                          ,sum(ifnull(b.Col04,0)) Col04
                                          ,sum(ifnull(b.Col05,0)) Col05
                                          ,sum(ifnull(b.Col06,0)) Col06
                                      FROM  (select c.* from 2020prestaciones c where c.codigo_prestacion in("01030500","01030600","01030700","01030800")) a
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

                    foreach($registro as $row ){
                        $totalCol01=$totalCol01+$row->Col01;
                        $totalCol02=$totalCol02+$row->Col02;
                        $totalCol03=$totalCol03+$row->Col03;
                        $totalCol04=$totalCol04+$row->Col04;
                        $totalCol05=$totalCol05+$row->Col05;
                        $totalCol06=$totalCol06+$row->Col06;
                        $nombre_descripcion = $row->codigo_prestacion;
                        if ($nombre_descripcion == "01030500"){
                            $nombre_descripcion = "EN ESPACIO AMIGABLE DIFERENCIADO";
                        }
                        if ($nombre_descripcion == "01030600"){
                            $nombre_descripcion = "EN OTROS ESPACIOS DEL ESTABLECIMIENTO DE SALUD";
                        }
                        if ($nombre_descripcion == "01030700"){
                            $nombre_descripcion = "EN ESTABLECIMIENTOS EDUCACIONALES";
                        }
                        if ($nombre_descripcion == "01030800"){
                            $nombre_descripcion = "EN OTROS LUGARES FUERA DEL ESTABLECIMIENTO DE SALUD";
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
                        <td align='center'><strong>TOTAL</strong></td>
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

        <!-- SECCION E -->
        <div class="col-sm tab table-responsive" id="E">
            <table class="table table-hover table-bordered table-sm">
                <thead>
                    <tr>
                        <td colspan="7" class="active"><strong>SECCIÓN E: CONTROLES DE SALUD EN ESTABLECIMIENTO EDUCACIONAL (Los controles individuales deben estar incluídos en la Sección B).</strong></td>
                    </tr>
                    <tr>
                        <td rowspan="2" style="text-align:center; vertical-align:middle"><strong>TIPO DE CONTROLES</strong></td>
                        <td rowspan="2" style="text-align:center; vertical-align:middle"><strong>CURSO</strong></td>
                        <td rowspan="2" style="text-align:center; vertical-align:middle"><strong>TOTAL*</strong></td>
                        <td rowspan="2" style="text-align:center; vertical-align:middle"><strong>TOTAL NIÑOS Y NIÑAS</strong></td>
                        <td colspan="2" align="center"><strong>SEXO</strong></td>
                    </tr>
                    <tr>
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
                                FROM  (select c.* from 2020prestaciones c where c.codigo_prestacion in("01031000","01031100","01031200","01031300","01031400",
                                                                                                       "01031500","01031600","01031700","01031800","01031900")) a
                                left join 2020rems b on (a.id_prestacion=b.prestacion_id_prestacion)
                                AND (b.Mes in ('.$mes.')) AND (b.establecimiento_id_establecimiento in ('.$estab.'))
                                group by  a.codigo_prestacion,a.descripcion, a.id_prestacion
                                order by a.id_prestacion';

                    $registro = DB::connection('mysql_rem')->select($query);

                    $i=0;

                    foreach($registro as $row ){
                        $nombre_descripcion = $row->codigo_prestacion;
                        if ($nombre_descripcion == "01031000"){
                            $nombre_descripcion = "KINDER";
                        }
                        if ($nombre_descripcion == "01031100"){
                            $nombre_descripcion = "PRIMERO BASICO";
                        }
                        if ($nombre_descripcion == "01031200"){
                            $nombre_descripcion = "SEGUNDO BASICO";
                        }
                        if ($nombre_descripcion == "01031300"){
                            $nombre_descripcion = "TERCERO BASICO";
                        }
                        if ($nombre_descripcion == "01031400"){
                            $nombre_descripcion = "CUARTO BASICO";
                        }
                        if ($nombre_descripcion == "01031500"){
                            $nombre_descripcion = "KINDER";
                        }
                        if ($nombre_descripcion == "01031600"){
                            $nombre_descripcion = "PRIMERO BASICO";
                        }
                        if ($nombre_descripcion == "01031700"){
                            $nombre_descripcion = "SEGUNDO BASICO";
                        }
                        if ($nombre_descripcion == "01031800"){
                            $nombre_descripcion = "TERCERO BASICO";
                        }
                        if ($nombre_descripcion == "01031900"){
                            $nombre_descripcion = "CUARTO BASICO";
                        }
                        ?>
                    <tr>
                        <?php
                        if($i==0){?>
                        <td rowspan='5' align='center' style="text-align:center; vertical-align:middle">CONTROLES INDIVIDUALES</td>
                        <?php
                        }
                        if($i==5){?>
                        <td rowspan='5' align='center' style="text-align:center; vertical-align:middle">CONTROLES GRUPALES</td>
                        <?php
                        }
                        ?>
                        <td align='left'><?php echo $nombre_descripcion; ?></td>
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
                        <td align='left' colspan="6">En Total* se registra el número de controles grupales</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <br>

        <!-- SECCIÓN F: CONTROLES INTEGRALES DE PERSONAS CON CONDICIONES CRÓNICAS -->
        <div class="col-sm tab table-responsive" id="E">
            <table class="table table-hover table-bordered table-sm">
                <thead>
                    <tr>
                        <td colspan="35" class="active"><strong>SECCIÓN F: CONTROLES INTEGRALES DE PERSONAS CON CONDICIONES CRÓNICAS.</strong></td>
                    </tr>
                    <tr>
                        <td rowspan="3" style="text-align:center; vertical-align:middle"><strong>&nbsp;TIPO&nbsp;DE&nbsp;CONTROL&nbsp;</strong></td>
                        <td rowspan="2" colspan="3" style="text-align:center; vertical-align:middle"><strong>TOTAL</strong></td>
                        <td colspan="28" align='center'><strong>POR EDAD (En años)</strong></td>
                        <td rowspan="3" style="text-align:center; vertical-align:middle"><strong>Beneficiarios</strong></td>
                        <td rowspan="3" style="text-align:center; vertical-align:middle"><strong>Migrantes</strong></td>
                        <td rowspan="3" style="text-align:center; vertical-align:middle"><strong>Pueblos Originarios</strong></td>
                    </tr>
                    <tr>
                      <td align='center' colspan="2"><strong>15&nbsp;-&nbsp;19</strong></td>
                      <td align='center' colspan="2"><strong>20&nbsp;-&nbsp;24</strong></td>
                      <td align='center' colspan="2"><strong>25&nbsp;-&nbsp;29</strong></td>
                      <td align='center' colspan="2"><strong>30&nbsp;-&nbsp;34</strong></td>
                      <td align='center' colspan="2"><strong>35&nbsp;-&nbsp;39</strong></td>
                      <td align='center' colspan="2"><strong>40&nbsp;-&nbsp;44</strong></td>
                      <td align='center' colspan="2"><strong>45&nbsp;-&nbsp;49</strong></td>
                      <td align='center' colspan="2"><strong>50&nbsp;-&nbsp;54</strong></td>
                      <td align='center' colspan="2"><strong>55&nbsp;-&nbsp;59</strong></td>
                      <td align='center' colspan="2"><strong>60&nbsp;-&nbsp;64</strong></td>
                      <td align='center' colspan="2"><strong>65&nbsp;-&nbsp;69</strong></td>
                      <td align='center' colspan="2"><strong>70&nbsp;-&nbsp;74</strong></td>
                      <td align='center' colspan="2"><strong>75&nbsp;-&nbsp;79</strong></td>
                      <td align='center' colspan="2"><strong>80 y mas</strong></td>
                    </tr>
                    <tr>
                        <td align='center'><strong>Ambos Sexos</strong></td>
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
                                FROM  (select c.* from 2020prestaciones c where c.codigo_prestacion in("01501010","01501020","01501030","01501040")) a
                                left join 2020rems b on (a.id_prestacion=b.prestacion_id_prestacion)
                                AND (b.Mes in ('.$mes.')) AND (b.establecimiento_id_establecimiento in ('.$estab.'))
                                group by  a.codigo_prestacion,a.descripcion, a.id_prestacion
                                order by a.id_prestacion';

                    $registro = DB::connection('mysql_rem')->select($query);

                    $i=0;

                    foreach($registro as $row ){
                        $nombre_descripcion = $row->codigo_prestacion;
                        if ($nombre_descripcion == "01501010"){
                            $nombre_descripcion = "CONTROL INTEGRAL CON RIESGO LEVE G1";
                        }
                        if ($nombre_descripcion == "01501020"){
                            $nombre_descripcion = "CONTROL INTEGRAL CON RIESGO MODERADO (G2)";
                        }
                        if ($nombre_descripcion == "01501030"){
                            $nombre_descripcion = "CONTROL INTEGRAL CON RIESGO ALTO (G3)";
                        }
                        if ($nombre_descripcion == "01501040"){
                            $nombre_descripcion = "SEGUIMIENTO A DISTANCIA CON RIESGO ALTO (G3)";
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
