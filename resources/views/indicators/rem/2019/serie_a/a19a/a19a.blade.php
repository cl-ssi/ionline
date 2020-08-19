@extends('layouts.app')

@section('title', 'Resumen Estadistico Mensual')

@section('content')

<?php

use Illuminate\Support\Facades\DB;

?>

@include('indicators.rem.partials.nav')

<h3>REM-19a. ACTIVIDADES DE PROMOCIÓN Y PREVENCIÓN DE LA SALUD.</h3>

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
    <!-- SECCION A.1 -->
    <div class="col-sm tab table-responsive" id="A1">
        <table class="table table-hover table-bordered table-sm">
            <thead>
                <tr>
                    <td colspan="46" class="active"><strong>SECCIÓN A: CONSEJERÍAS.</strong></td>
                </tr>
                <tr>
                    <td colspan="46" class="active"><strong>SECCIÓN A.1: CONSEJERÍAS INDIVIDUALES.</strong></td>
                </tr>
                <tr>
                    <td rowspan="3" style="text-align:center; vertical-align:middle"><strong>ACTIVIDADES Y AREAS TEMATICAS</strong></td>
                    <td rowspan="3" style="text-align:center; vertical-align:middle"><strong>PROFESIONAL</strong></td>
                    <td colspan="3" rowspan="2" style="text-align:center; vertical-align:middle"><strong>TOTAL</strong></td>
                    <td colspan="34" align="center"><strong>GRUPOS DE EDAD (en años)</strong></td>
                    <td rowspan="3" align="center"><strong>Espacios Amigables / adolescentes</strong></td>
                    <td colspan="2" rowspan="2" align="center"><strong>TRANS</strong></td>
                    <td rowspan="3" align="center"><strong>Pueblos Originarios</strong></td>
                    <td rowspan="3" align="center"><strong>Migrantes</strong></td>
                    <td rowspan="3" align="center"><strong>14 - 18 años</strong></td>
                    <td rowspan="3" align="center"><strong>Niños, Niñas, Adolescentes y Jóvenes Población SENAME</strong></td>
                </tr>
                <tr>
                    <td colspan="2" align="center"><strong>0 - 4</strong></td>
                    <td colspan="2" align="center"><strong>5 - 9</strong></td>
                    <td colspan="2" align="center"><strong>10 - 14</strong></td>
                    <td colspan="2" align="center"><strong>15 - 19</strong></td>
                    <td colspan="2" align="center"><strong>20 - 24</strong></td>
                    <td colspan="2" align="center"><strong>25 - 29</strong></td>
                    <td colspan="2" align="center"><strong>30 - 34</strong></td>
                    <td colspan="2" align="center"><strong>35 - 39</strong></td>
                    <td colspan="2" align="center"><strong>40 - 44</strong></td>
                    <td colspan="2" align="center"><strong>45 - 49</strong></td>
                    <td colspan="2" align="center"><strong>50 - 54</strong></td>
                    <td colspan="2" align="center"><strong>55 - 59</strong></td>
                    <td colspan="2" align="center"><strong>60 - 64</strong></td>
                    <td colspan="2" align="center"><strong>65 - 69</strong></td>
                    <td colspan="2" align="center"><strong>70 - 74</strong></td>
                    <td colspan="2" align="center"><strong>75- 79</strong></td>
                    <td colspan="2" align="center"><strong>80 y mas</strong></td>
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
                    <td align="center"><strong>HOMBRES</strong></td>
                    <td align="center"><strong>MUJERES</strong></td>
                    <td align="center"><strong>HOMBRES</strong></td>
                    <td align="center"><strong>MUJERES</strong></td>
                    <td align="center"><strong>HOMBRES</strong></td>
                    <td align="center"><strong>MUJERES</strong></td>
                    <td align="center"><strong>HOMBRES</strong></td>
                    <td align="center"><strong>MUJERES</strong></td>
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
                          FROM (select c.* from 2019prestaciones c where c.codigo_prestacion in("19120201","19120202","19120203","19120204","19120206","19120208","19120210","19170100","19120211","19120212","19120205",
                                                                                                "19184000","19184100","19184200","19184300","19184400","19184500","19184600","19184700","19184800","19184801","19184900",
                                                                                                "19120301","19120302","19120303","19120304","19120306","19120308","19120310","19170200","19120311","19120312","19120305",
                                                                                                "19185000","19185100","19185200","19185300","19185400","19185500","19185600","19185700","19185800","19185801","19185900",
                                                                                                "19120601","19120602","19120603","19120606","19120608","19120609","19120611",
                                                                                                "19182010","19182020","19182021","19182030",
                                                                                                "19120701","19120702","19120703","19120706","19120708","19120709","19120711",
                                                                                                "19150900","19150920","19170300","19170400","19170401",
                                                                                                "19140604","19140605","19140606","19140607","19140608","19170500","19170501","19140609")) a
                          left join 2019rems b on (a.id_prestacion=b.prestacion_id_prestacion)
                          AND (b.Mes in ('.$mes.')) AND (b.establecimiento_id_establecimiento in ('.$estab.'))
                          group by a.codigo_prestacion, a.descripcion, a.id_prestacion
                          order by a.id_prestacion';
                $registro = DB::connection('mysql_rem')->select($query);

                $i=0;

                foreach($registro as $row ){
                    $nombre_descripcion = $row->codigo_prestacion;
                    if ($nombre_descripcion == "19120201"){
                        $nombre_descripcion = "MÉDICO";
      							}
      							if ($nombre_descripcion == "19120202"){
                        $nombre_descripcion = "ENFERMERA /O";
      							}
      							if ($nombre_descripcion == "19120203"){
                        $nombre_descripcion = "MATRONA /ÓN";
      							}
      							if ($nombre_descripcion == "19120204"){
                        $nombre_descripcion = "NUTRICIONISTA";
      							}
      							if ($nombre_descripcion == "19120206"){
                        $nombre_descripcion = "ASISTENTE SOCIAL";
      							}
      							if ($nombre_descripcion == "19120208"){
                        $nombre_descripcion = "PSICÓLOGO /A";
      							}
      							if ($nombre_descripcion == "19120210"){
                        $nombre_descripcion = "KINESIÓLOGO";
      							}
      							if ($nombre_descripcion == "19170100"){
                        $nombre_descripcion = "TERAPEUTA OCUPACIONAL";
      							}
      							if ($nombre_descripcion == "19120211"){
                        $nombre_descripcion = "OTRO PROFESIONAL";
      							}
      							if ($nombre_descripcion == "19120212"){
                        $nombre_descripcion = "FACILITADOR/A INTERCULTURAL";
      							}
      							if ($nombre_descripcion == "19120205"){
                        $nombre_descripcion = "TÉCNICO PARAMÉDICO";
      							}

                    if ($nombre_descripcion == "19184000"){
                        $nombre_descripcion = "MÉDICO";
      							}
      							if ($nombre_descripcion == "19184100"){
                        $nombre_descripcion = "ENFERMERA /O";
      							}
      							if ($nombre_descripcion == "19184200"){
                        $nombre_descripcion = "MATRONA /ÓN";
      							}
      							if ($nombre_descripcion == "19184300"){
                        $nombre_descripcion = "NUTRICIONISTA";
      							}
      							if ($nombre_descripcion == "19184400"){
                        $nombre_descripcion = "ASISTENTE SOCIAL";
      							}
      							if ($nombre_descripcion == "19184500"){
                        $nombre_descripcion = "PSICÓLOGO /A";
      							}
      							if ($nombre_descripcion == "19184600"){
                        $nombre_descripcion = "KINESIÓLOGO";
      							}
      							if ($nombre_descripcion == "19184700"){
                        $nombre_descripcion = "TERAPEUTA OCUPACIONAL";
      							}
      							if ($nombre_descripcion == "19184800"){
                        $nombre_descripcion = "OTRO PROFESIONAL";
      							}
      							if ($nombre_descripcion == "19184801"){
                        $nombre_descripcion = "FACILITADOR/A INTERCULTURAL";
      							}
      							if ($nombre_descripcion == "19184900"){
                        $nombre_descripcion = "TÉCNICO PARAMÉDICO";
      							}

                    if ($nombre_descripcion == "19120301"){
                        $nombre_descripcion = "MÉDICO";
      							}
      							if ($nombre_descripcion == "19120302"){
                        $nombre_descripcion = "ENFERMERA /O";
      							}
      							if ($nombre_descripcion == "19120303"){
                        $nombre_descripcion = "MATRONA /ÓN";
      							}
      							if ($nombre_descripcion == "19120304"){
                        $nombre_descripcion = "NUTRICIONISTA";
      							}
      							if ($nombre_descripcion == "19120306"){
                        $nombre_descripcion = "ASISTENTE SOCIAL";
      							}
      							if ($nombre_descripcion == "19120308"){
                        $nombre_descripcion = "PSICÓLOGO /A";
      							}
      							if ($nombre_descripcion == "19120310"){
                        $nombre_descripcion = "KINESIÓLOGO";
      							}
      							if ($nombre_descripcion == "19170200"){
                        $nombre_descripcion = "TERAPEUTA OCUPACIONAL";
      							}
      							if ($nombre_descripcion == "19120311"){
                        $nombre_descripcion = "OTRO PROFESIONAL";
      							}
      							if ($nombre_descripcion == "19120312"){
                        $nombre_descripcion = "FACILITADOR/A INTERCULTURAL";
      							}
      							if ($nombre_descripcion == "19120305"){
                        $nombre_descripcion = "TÉCNICO PARAMÉDICO";
      							}

                    if ($nombre_descripcion == "19185000"){
                        $nombre_descripcion = "MÉDICO";
      							}
      							if ($nombre_descripcion == "19185100"){
                        $nombre_descripcion = "ENFERMERA /O";
      							}
      							if ($nombre_descripcion == "19185200"){
                        $nombre_descripcion = "MATRONA /ÓN";
      							}
      							if ($nombre_descripcion == "19185300"){
                        $nombre_descripcion = "NUTRICIONISTA";
      							}
      							if ($nombre_descripcion == "19185400"){
                        $nombre_descripcion = "ASISTENTE SOCIAL";
      							}
      							if ($nombre_descripcion == "19185500"){
                        $nombre_descripcion = "PSICÓLOGO /A";
      							}
      							if ($nombre_descripcion == "19185600"){
                        $nombre_descripcion = "KINESIÓLOGO";
      							}
      							if ($nombre_descripcion == "19185700"){
                        $nombre_descripcion = "TERAPEUTA OCUPACIONAL";
      							}
      							if ($nombre_descripcion == "19185800"){
                        $nombre_descripcion = "OTRO PROFESIONAL";
      							}
      							if ($nombre_descripcion == "19185801"){
                        $nombre_descripcion = "FACILITADOR/A INTERCULTURAL";
      							}
      							if ($nombre_descripcion == "19185900"){
                        $nombre_descripcion = "TÉCNICO PARAMÉDICO";
      							}

                    if ($nombre_descripcion == "19120601"){
                        $nombre_descripcion = "MÉDICO";
      							}
      							if ($nombre_descripcion == "19120602"){
                        $nombre_descripcion = "ENFERMERA /O";
      							}
      							if ($nombre_descripcion == "19120603"){
                        $nombre_descripcion = "MATRONA /ÓN";
      							}
      							if ($nombre_descripcion == "19120606"){
                        $nombre_descripcion = "ASISTENTE SOCIAL";
      							}
      							if ($nombre_descripcion == "19120608"){
                        $nombre_descripcion = "PSICÓLOGO /A";
      							}
      							if ($nombre_descripcion == "19120609"){
                        $nombre_descripcion = "FACILITADOR/A INTERCULTURAL";
      							}
      							if ($nombre_descripcion == "19120611"){
                        $nombre_descripcion = "OTRO PROFESIONAL";
      							}

                    if ($nombre_descripcion == "19182010"){
                        $nombre_descripcion = "MÉDICO";
      							}
      							if ($nombre_descripcion == "19182020"){
                        $nombre_descripcion = "MATRONA /ÓN";
      							}
      							if ($nombre_descripcion == "19182021"){
                        $nombre_descripcion = "FACILITADOR/A INTERCULTURAL";
      							}
      							if ($nombre_descripcion == "19182030"){
                        $nombre_descripcion = "OTRO PROFESIONAL";
      							}

                    if ($nombre_descripcion == "19120701"){
                        $nombre_descripcion = "MÉDICO";
      							}
      							if ($nombre_descripcion == "19120702"){
                        $nombre_descripcion = "ENFERMERA /O";
      							}
      							if ($nombre_descripcion == "19120703"){
                        $nombre_descripcion = "MATRONA /ÓN";
      							}
      							if ($nombre_descripcion == "19120706"){
                        $nombre_descripcion = "ASISTENTE SOCIAL";
      							}
      							if ($nombre_descripcion == "19120708"){
                        $nombre_descripcion = "PSICÓLOGO /A";
      							}
      							if ($nombre_descripcion == "19120709"){
                        $nombre_descripcion = "FACILITADOR/A INTERCULTURAL";
      							}
      							if ($nombre_descripcion == "19120711"){
                        $nombre_descripcion = "OTRO PROFESIONAL";
      							}

                    if ($nombre_descripcion == "19150900"){
                        $nombre_descripcion = "MÉDICO PRE TEST";
      							}
      							if ($nombre_descripcion == "19150920"){
                        $nombre_descripcion = "MATRONA /ÓN PRE TEST";
      							}
      							if ($nombre_descripcion == "19170300"){
                        $nombre_descripcion = "MÉDICO POST TEST";
      							}
      							if ($nombre_descripcion == "19170400"){
                        $nombre_descripcion = "MATRONA /ÓN POST TEST";
      							}
      							if ($nombre_descripcion == "19170401"){
                        $nombre_descripcion = "FACILITADOR/A INTERCULTURAL";
      							}

                    if ($nombre_descripcion == "19140604"){
                        $nombre_descripcion = "MÉDICO";
      							}
      							if ($nombre_descripcion == "19140605"){
                        $nombre_descripcion = "ENFERMERA /O";
      							}
      							if ($nombre_descripcion == "19140606"){
                        $nombre_descripcion = "MATRONA /ÓN";
      							}
      							if ($nombre_descripcion == "19140607"){
                        $nombre_descripcion = "ASISTENTE SOCIAL";
      							}
      							if ($nombre_descripcion == "19140608"){
                        $nombre_descripcion = "PSICÓLOGO /A";
      							}
      							if ($nombre_descripcion == "19170500"){
                        $nombre_descripcion = "TERAPEUTA OCUPACIONAL";
      							}
      							if ($nombre_descripcion == "19170501"){
                        $nombre_descripcion = "FACILITADOR/A INTERCULTURAL";
      							}
      							if ($nombre_descripcion == "19140609"){
                        $nombre_descripcion = "OTRO PROFESIONAL";
      							}
                    ?>
                <tr>
                    <?php
                    if($i==0){?>
                    <td rowspan="11" style="text-align:center; vertical-align:middle" nowrap="nowrap">ACTIVIDAD FÍSICA</td>
                    <?php
                    }
                    if($i==11){?>
                    <td rowspan="11" style="text-align:center; vertical-align:middle" nowrap="nowrap">ALIMENTACIÓN SALUDABLE</td>
                    <?php
                    }
                    if($i==22){?>
                    <td rowspan="11" style="text-align:center; vertical-align:middle" nowrap="nowrap">TABAQUISMO</td>
                    <?php
                    }
                    if($i==33){?>
                    <td rowspan="11" style="text-align:center; vertical-align:middle" nowrap="nowrap">CONSUMO DE DROGAS</td>
                    <?php
                    }
                    if($i==44){?>
                    <td rowspan="7" style="text-align:center; vertical-align:middle" nowrap="nowrap">SALUD SEXUAL Y REPRODUCTIVA</td>
                    <?php
                    }
                    if($i==51){?>
                    <td rowspan="4" style="text-align:center; vertical-align:middle" nowrap="nowrap">REGULACIÓN DE FERTILIDAD</td>
                    <?php
                    }
                    if($i==55){?>
                    <td rowspan="7" style="text-align:center; vertical-align:middle">PREVENCIÓN VIH E INFECCIÓN DE TRANSMISIÓN SEXUAL (ITS)</td>
                    <?php
                    }
                    if($i==62){?>
                    <td rowspan="5" style="text-align:center; vertical-align:middle">PREVENCIÓN DE LA TRANSMISIÓN VERTICAL DEL VIH (EMBARAZADAS)</td>
                    <?php
                    }
                    if($i==67){?>
                    <td rowspan="8" style="text-align:center; vertical-align:middle">OTRAS ÁREAS</td>
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
                    <td colspan="44" class="active"><strong>SECCIÓN A.2: CONSEJERÍAS INDIVIDUALES POR VIH (NO INCLUIDAS EN LA SECCION A.1).</strong></td>
                </tr>
                <tr>
                    <td rowspan="3" style="text-align:center; vertical-align:middle"><strong><strong>CONSEJERIAS</strong></strong></td>
                    <td rowspan="3" style="text-align:center; vertical-align:middle"><strong><strong>ÁREA O NIVEL</strong></strong></td>
                    <td colspan="3" rowspan="2" style="text-align:center; vertical-align:middle"><strong>TOTAL</strong></td>
                    <td colspan="34" align="center"><strong>GRUPOS DE EDAD (en años)</strong></td>
                    <td colspan="2" rowspan="2" align="center"><strong>TRANS</strong></td>
                    <td rowspan="3" align="center"><strong>Pueblos Originarios</strong></td>
                    <td rowspan="3" align="center"><strong>Migrantes</strong></td>
                    <td rowspan="3" align="center"><strong>Niños, Niñas, Adolescentes y Jóvenes Población SENAME</strong></td>
                </tr>
                <tr>
                    <td colspan="2" align="center"><strong>0 - 4</strong></td>
                    <td colspan="2" align="center"><strong>5 - 9</strong></td>
                    <td colspan="2" align="center"><strong>10 a 14</strong></td>
                    <td colspan="2" align="center"><strong>15 a 19</strong></td>
                    <td colspan="2" align="center"><strong>20 a 24</strong></td>
                    <td colspan="2" align="center"><strong>25 - 29</strong></td>
                    <td colspan="2" align="center"><strong>30 - 34</strong></td>
                    <td colspan="2" align="center"><strong>35 - 39</strong></td>
                    <td colspan="2" align="center"><strong>40 - 44</strong></td>
                    <td colspan="2" align="center"><strong>45 - 49</strong></td>
                    <td colspan="2" align="center"><strong>50 - 54</strong></td>
                    <td colspan="2" align="center"><strong>55 - 59</strong></td>
                    <td colspan="2" align="center"><strong>60 - 64</strong></td>
                    <td colspan="2" align="center"><strong>65 - 69</strong></td>
                    <td colspan="2" align="center"><strong>70 - 74</strong></td>
                    <td colspan="2" align="center"><strong>75 - 79</strong></td>
                    <td colspan="2" align="center"><strong>80 y mas</strong></td>
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
                    <td align="center"><strong>HOMBRES</strong></td>
                    <td align="center"><strong>MUJERES</strong></td>
                    <td align="center"><strong>HOMBRES</strong></td>
                    <td align="center"><strong>MUJERES</strong></td>
                    <td align="center"><strong>HOMBRES</strong></td>
                    <td align="center"><strong>MUJERES</strong></td>
                    <td align="center"><strong>HOMBRES</strong></td>
                    <td align="center"><strong>MUJERES</strong></td>
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

                          FROM (select c.* from 2019prestaciones c where c.codigo_prestacion in("19150960","19150970","19150980","19150990","19182040","19160100",
                                                                                                "19160200","19160300","19160400","19160500","19182050","19160600")) a
                          left join 2019rems b on (a.id_prestacion=b.prestacion_id_prestacion)
                          AND (b.Mes in ('.$mes.')) AND (b.establecimiento_id_establecimiento in ('.$estab.'))
                          group by a.codigo_prestacion, a.descripcion, a.id_prestacion
                          order by a.id_prestacion';
                $registro = DB::connection('mysql_rem')->select($query);

                $i=0;

                foreach($registro as $row ){
                    $nombre_descripcion = $row->codigo_prestacion;
                    if ($nombre_descripcion == "19150960"){
                        $nombre_descripcion = "EN BANCO DE SANGRE  (DONANTES)";
      							}
      							if ($nombre_descripcion == "19150970"){
                        $nombre_descripcion = "HOSPITALIZACIÓN";
      							}
      							if ($nombre_descripcion == "19150980"){
                        $nombre_descripcion = "EN CDT - CRS";
      							}
      							if ($nombre_descripcion == "19150990"){
                        $nombre_descripcion = "EN APS";
      							}
      							if ($nombre_descripcion == "19182040"){
                        $nombre_descripcion = "EN APS - ESPACIOS AMIGABLES";
      							}
      							if ($nombre_descripcion == "19160100"){
                        $nombre_descripcion = "EN OTRAS INSTANCIAS";
      							}

      							if ($nombre_descripcion == "19160200"){
                        $nombre_descripcion = "EN BANCO DE SANGRE  (DONANTES)";
      							}
      							if ($nombre_descripcion == "19160300"){
                        $nombre_descripcion = "HOSPITALIZACIÓN";
      							}
      							if ($nombre_descripcion == "19160400"){
                        $nombre_descripcion = "EN CDT - CRS";
      							}
      							if ($nombre_descripcion == "19160500"){
                        $nombre_descripcion = "EN APS";
      							}
      							if ($nombre_descripcion == "19182050"){
                        $nombre_descripcion = "EN APS - ESPACIOS AMIGABLES";
      							}
      							if ($nombre_descripcion == "19160600"){
                        $nombre_descripcion = "EN OTRAS INSTANCIAS";
      							}
                    ?>
                <tr>
                    <?php
                    if($i==0){?>
                    <td rowspan="6" style="text-align:center; vertical-align:middle">ORIENTACIÓN E INFORMACIÓN PREVIA AL EXAMEN VIH</td>
                    <?php
                    }
                    if($i==6){?>
                    <td rowspan="6" style="text-align:center; vertical-align:middle" nowrap="nowrap">CONSEJERÍAS POST TEST VIH</td>
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
    <!-- SECCION A.3 -->
    <div class="col-sm tab table-responsive" id="A3">
        <table class="table table-hover table-bordered table-sm">
            <thead>
                <tr>
                    <td colspan="4" class="active"><strong>SECCIÓN A.3: CONSEJERÍAS FAMILIARES.</strong></td>
                </tr>
                <tr>
                    <td align="center">TEMAS PRIORIDAD</td>
                    <td align="center"><strong>FAMILIA</strong></td>
                    <td align="center"><strong>TOTAL ACTIVIDADES</strong></td>
                    <td align="center"><strong>ESPACIOS AMIGABLES</strong></td>
                </tr>
            </thead>
            <tbody>
                <?php
                $query = 'SELECT a.codigo_prestacion,a.descripcion
                              ,sum(ifnull(b.Col01,0)) Col01
                              ,sum(ifnull(b.Col02,0)) Col02
                          FROM (select c.* from 2019prestaciones c where c.codigo_prestacion in("19140700","19140800","19140900","19150100","19150200","19150300","19150400","19150500","19190100")) a
                          left join 2019rems b on (a.id_prestacion=b.prestacion_id_prestacion)
                          AND (b.Mes in ('.$mes.')) AND (b.establecimiento_id_establecimiento in ('.$estab.'))
                          group by a.codigo_prestacion, a.descripcion, a.id_prestacion
                          order by a.id_prestacion';
                $registro = DB::connection('mysql_rem')->select($query);

                $i=0;

                foreach($registro as $row ){
                    $nombre_descripcion = $row->codigo_prestacion;
                    if ($nombre_descripcion == "19140700"){
                        $nombre_descripcion = "CON RIESGO PSICOSOCIAL";
      							}
      							if ($nombre_descripcion == "19140800"){
                        $nombre_descripcion = "CON INTEGRANTE DE PATOLOGÍA CRÓNICA";
      							}
      							if ($nombre_descripcion == "19140900"){
                        $nombre_descripcion = "CON INTEGRANTE CON PROBLEMA DE SALUD MENTAL";
      							}
      							if ($nombre_descripcion == "19150100"){
                        $nombre_descripcion = "CON ADULTO MAYOR DEPENDIENTE";
      							}
      							if ($nombre_descripcion == "19150200"){
                        $nombre_descripcion = "CON ADULTO MAYOR CON DEMENCIA";
      							}
      							if ($nombre_descripcion == "19150300"){
                        $nombre_descripcion = "CON INTEGRANTE CON ENFERMEDAD TERMINAL";
      							}
      							if ($nombre_descripcion == "19150400"){
                        $nombre_descripcion = "CON INTEGRANTE DEPENDIENTE SEVERO";
      							}
      							if ($nombre_descripcion == "19150500"){
                        $nombre_descripcion = "OTRAS ÁREAS DE INTERVENCIÓN";
      							}
                    if ($nombre_descripcion == "19190100"){
                        $nombre_descripcion = "CON ADOLESCENTE VIH (+)";
      							}
                    ?>
                <tr>
                    <?php
                    if($i==0){?>
                    <td rowspan="9" ></td>
                    <?php
                    }
                    ?>
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

    <!-- SECCION A.4 -->
    <div class="col-sm tab table-responsive" id="A4">
        <table class="table table-hover table-bordered table-sm">
            <thead>
                <tr>
                    <td colspan="13" class="active"><strong>SECCIÓN A.4: CONSEJERÍAS INDIVIDUALES EN ADOLESCENTES CON ENTREGA DE PRESERVATIVOS.</strong></td>
                </tr>
                <tr>
                    <td rowspan="3" colspan="2" style="text-align:center; vertical-align:middle">ACTIVIDAD</td>
                    <td rowspan="2" colspan="3" style="text-align:center; vertical-align:middle"><strong>TOTAL</strong></td>
                    <td colspan="8" align="center"><strong>GRUPOS DE EDAD (en años)</strong></td>
                </tr>
                <tr>
                    <td colspan="2" align="center">0 - 4</td>
                    <td colspan="2" align="center">5 - 9</td>
                    <td colspan="2" align="center">10 - 14</td>
                    <td colspan="2" align="center">15-19</td>
                </tr>
                <tr>
                    <td align="center">AMBOS SEXOS</td>
                    <td align="center">* Las consejerías realizadas en Espacios Amigables NO DEBEN ser mayor al Total de Actividades.</td>
                    <td align="center">MUJERES</td>
                    <td align="center">HOMBRES</td>
                    <td align="center">MUJERES</td>
                    <td align="center">HOMBRES</td>
                    <td align="center">MUJERES</td>
                    <td align="center">HOMBRES</td>
                    <td align="center">MUJERES</td>
                    <td align="center">HOMBRES</td>
                    <td align="center">MUJERES</td>
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
                          FROM (select c.* from 2019prestaciones c where c.codigo_prestacion in("19190101","19190102","19190103")) a
                          left join 2019rems b on (a.id_prestacion=b.prestacion_id_prestacion)
                          AND (b.Mes in ('.$mes.')) AND (b.establecimiento_id_establecimiento in ('.$estab.'))
                          group by a.codigo_prestacion, a.descripcion, a.id_prestacion
                          order by a.id_prestacion';
                $registro = DB::connection('mysql_rem')->select($query);

                $i=0;

                foreach($registro as $row ){
                    $nombre_descripcion = $row->codigo_prestacion;
                    if ($nombre_descripcion == "19190101"){
                        $nombre_descripcion = "CONDONES MASCULINOS";
      							}
                    if ($nombre_descripcion == "19190102"){
                        $nombre_descripcion = "CONDONES FEMENINOS";
      							}
                    if ($nombre_descripcion == "19190103"){
                        $nombre_descripcion = "AMBOS TIPOS DE CONDONES";
      							}
                    ?>
                <tr>
                    <?php
                    if($i==0){?>
                    <td rowspan="3" style="text-align:center; vertical-align:middle">CONSEJERIA CON ENTREGA DE PRESERVATIVOS </td>
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
            </tbody>
        </table>
    </div>

    <br>

    <!-- SECCION B.1 -->
    <div class="col-sm tab table-responsive" id="B1">
        <table class="table table-hover table-bordered table-sm">
            <thead>
                <tr>
                    <td colspan="12" class="active"><strong>SECCIÓN B: ACTIVIDADES DE PROMOCIÓN.</strong></td>
                </tr>
                <tr>
                    <td colspan="12" class="active"><strong>SECCIÓN B.1: ACTIVIDADES DE PROMOCIÓN SEGÚN ESTRATEGIAS Y CONDICIONANTES ABORDADAS Y NÚMERO DE PARTICIPANTES.</strong></td>
                </tr>
                <tr>
                    <td rowspan="2" align="center"><strong>ACTIVIDADES</strong></td>
                    <td rowspan="2" align="center"><strong>ESTRATEGIA, ESPACIOS  O LÍNEAS DE ACCIÓN</strong></td>
                    <td rowspan="2" align="center"><strong>TOTAL ACTIVIDADES</strong></td>
                    <td colspan="7" align="center"><strong>CONDICIONANTES ABORDADAS</strong></td>
                    <td rowspan="2" align="center"><strong>DETERMINANTES SOCIALES DE LA SALUD ABORDADAS - CHILE CRECE CONTIGO</strong></td>
                    <td rowspan="2" align="center"><strong>TOTAL PARTICIPANTES</strong></td>
                </tr>
                <tr>
                    <td align="center"><strong>Actividad física</strong></td>
                    <td align="center"><strong>Alimentación</strong></td>
                    <td align="center"><strong>Ambiente libre de humo de tabaco</strong></td>
                    <td align="center"><strong>Factores protectores psicosociales</strong></td>
                    <td align="center"><strong>Factores protectores ambientales</strong></td>
                    <td align="center"><strong>Derechos humanos</strong></td>
                    <td align="center"><strong>Salud sexual y prevención de VIH/SIDA e ITS</strong></td>
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
                          FROM (select c.* from 2019prestaciones c where c.codigo_prestacion in("19140101","19170700","19140102","19140103",
                                                                                                "19140201","19170800","19140202","19140203",
                                                                                                "19140301","19170900","19140302","19140303",
                                                                                                "19140401","19180000","19140402","19140403")) a
                          left join 2019rems b on (a.id_prestacion=b.prestacion_id_prestacion)
                          AND (b.Mes in ('.$mes.')) AND (b.establecimiento_id_establecimiento in ('.$estab.'))
                          group by a.codigo_prestacion, a.descripcion, a.id_prestacion
                          order by a.id_prestacion';
                $registro = DB::connection('mysql_rem')->select($query);

                $i=0;

                foreach($registro as $row ){
                    $nombre_descripcion = $row->codigo_prestacion;
                    if ($nombre_descripcion == "19140101"){
                        $nombre_descripcion = "COMUNAS, COMUNIDADES.";
      							}
      							if ($nombre_descripcion == "19170700"){
                        $nombre_descripcion = "ESPACIOS AMIGABLES EN APS";
      							}
      							if ($nombre_descripcion == "19140102"){
                        $nombre_descripcion = "LUGARES DE TRABAJO";
      							}
      							if ($nombre_descripcion == "19140103"){
                        $nombre_descripcion = "ESTABLECIMIENTOS EDUCACIÓN";
      							}

      							if ($nombre_descripcion == "19140201"){
                        $nombre_descripcion = "COMUNAS, COMUNIDADES.";
      							}
      							if ($nombre_descripcion == "19170800"){
                        $nombre_descripcion = "ESPACIOS AMIGABLES EN APS";
      							}
      							if ($nombre_descripcion == "19140202"){
                        $nombre_descripcion = "LUGARES DE TRABAJO";
      							}
      							if ($nombre_descripcion == "19140203"){
                        $nombre_descripcion = "ESTABLECIMIENTOS EDUCACIÓN";
      							}

      							if ($nombre_descripcion == "19140301"){
                        $nombre_descripcion = "COMUNAS, COMUNIDADES.";
      							}
      							if ($nombre_descripcion == "19170900"){
                        $nombre_descripcion = "ESPACIOS AMIGABLES EN APS";
      							}
      							if ($nombre_descripcion == "19140302"){
                        $nombre_descripcion = "LUGARES DE TRABAJO";
      							}
      							if ($nombre_descripcion == "19140303"){
                        $nombre_descripcion = "ESTABLECIMIENTOS EDUCACIÓN";
      							}

      							if ($nombre_descripcion == "19140401"){
                        $nombre_descripcion = "COMUNAS, COMUNIDADES.";
      							}
      							if ($nombre_descripcion == "19180000"){
                        $nombre_descripcion = "ESPACIOS AMIGABLES EN APS";
      							}
      							if ($nombre_descripcion == "19140402"){
                        $nombre_descripcion = "LUGARES DE TRABAJO";
      							}
      							if ($nombre_descripcion == "19140403"){
                        $nombre_descripcion = "ESTABLECIMIENTOS EDUCACIÓN";
      							}
                    ?>
                <tr>
                    <?php
                    if($i==0){?>
                    <td rowspan="4" style="text-align:center; vertical-align:middle">EVENTOS MASIVOS</td>
                    <?php
                    }
                    if($i==4){?>
                    <td rowspan="4" style="text-align:center; vertical-align:middle">REUNIONES DE PLANIFICACIÓN PARTICIPATIVA</td>
                    <?php
                    }
                    if($i==8){?>
                    <td rowspan="4" style="text-align:center; vertical-align:middle">JORNADAS Y SEMINARIOS</td>
                    <?php
                    }
                    if($i==12){?>
                    <td rowspan="4" style="text-align:center; vertical-align:middle">EDUCACIÓN GRUPAL</td>
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
    <!-- SECCION B.2 -->
    <div class="col-sm tab table-responsive" id="B2">
        <table class="table table-hover table-bordered table-sm">
            <thead>
                <tr>
                    <td colspan="8" class="active"><strong>SECCIÓN B.2: TALLERES GRUPALES DE VIDA SANA SEGÚN TIPO, POR ESPACIOS DE ACCIÓN.</strong></td>
                </tr>
                <tr>
                    <td align="center"><strong>ESPACIOS DE ACCIÓN</strong></td>
                    <td align="center"><strong>TOTAL TALLERES</strong></td>
                    <td align="center"><strong>AUTOESTIMA Y AUTOCUIDADO</strong></td>
                    <td align="center"><strong>MENTE SANA Y CUERPO SANO</strong></td>
                    <td align="center"><strong>COMUNICACIÓN</strong></td>
                    <td align="center"><strong>YO ME CUIDO</strong></td>
                    <td align="center"><strong>CONTROL DEL TABACO</strong></td>
                    <td align="center"><strong>OTROS TIPO DE TALLERES</strong></td>
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
                          FROM (select c.* from 2019prestaciones c where c.codigo_prestacion in("19140501","19180100","19140502","19140503")) a
                          left join 2019rems b on (a.id_prestacion=b.prestacion_id_prestacion)
                          AND (b.Mes in ('.$mes.')) AND (b.establecimiento_id_establecimiento in ('.$estab.'))
                          group by a.codigo_prestacion, a.descripcion, a.id_prestacion
                          order by a.id_prestacion';
                $registro = DB::connection('mysql_rem')->select($query);

                $i=0;

                foreach($registro as $row ){
                    $nombre_descripcion = $row->codigo_prestacion;
                    if ($nombre_descripcion == "19140501"){
                        $nombre_descripcion = "COMUNAS, COMUNIDADES.";
      							}
      							if ($nombre_descripcion == "19180100"){
                        $nombre_descripcion = "ESPACIOS AMIGABLES EN APS";
      							}
      							if ($nombre_descripcion == "19140502"){
                        $nombre_descripcion = "LUGARES DE TRABAJO";
      							}
      							if ($nombre_descripcion == "19140503"){
                        $nombre_descripcion = "ESTABLECIMIENTOS EDUCACIÓN";
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

    <br>

    <!-- SECCION B.3 -->
    <div class="col-sm tab table-responsive" id="B3">
        <table class="table table-hover table-bordered table-sm">
            <thead>
                <tr>
                    <td colspan="8" class="active"><strong>SECCIÓN B.3: ACTIVIDADES DE GESTIÓN SEGÚN TIPO, POR ESPACIOS DE ACCIÓN.</strong></td>
                </tr>
                <tr>
                    <td align="center"><strong>ESPACIOS DE ACCIÓN</strong></td>
                    <td align="center"><strong>TOTAL ACTIVIDADES</strong></td>
                    <td align="center"><strong>REUNIONES DE GESTIÓN</strong></td>
                    <td align="center"><strong>REUNIONES MASIVAS DE GESTIÓN</strong></td>
                    <td align="center"><strong>ACCIONES DE COMUNICACIÓN Y DIFUSIÓN</strong></td>
                    <td align="center"><strong>PREPARACIÓN ACTIVIDADES EDUCATIVAS</strong></td>
                    <td align="center"><strong>ENTREVISTAS</strong></td>
                    <td align="center"><strong>INVESTIGACIÓN Y CAPACITACIÓN DE RRHH</strong></td>
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
                          FROM (select c.* from 2019prestaciones c where c.codigo_prestacion in("19140601","19180200","19140602","19140603","19182060","19140610")) a
                          left join 2019rems b on (a.id_prestacion=b.prestacion_id_prestacion)
                          AND (b.Mes in ('.$mes.')) AND (b.establecimiento_id_establecimiento in ('.$estab.'))
                          group by a.codigo_prestacion, a.descripcion, a.id_prestacion
                          order by a.id_prestacion';
                $registro = DB::connection('mysql_rem')->select($query);

                $i=0;

                foreach($registro as $row ){
                    $nombre_descripcion = $row->codigo_prestacion;
                    if ($nombre_descripcion == "19140601"){
                        $nombre_descripcion = "COMUNAS, COMUNIDADES";
      							}
      							if ($nombre_descripcion == "19180200"){
                        $nombre_descripcion = "ESPACIOS AMIGABLES EN APS";
      							}
      							if ($nombre_descripcion == "19140602"){
                        $nombre_descripcion = "LUGARES DE TRABAJO";
      							}
      							if ($nombre_descripcion == "19140603"){
                        $nombre_descripcion = "ESTABLECIMIENTOS EDUCACIONALES";
      							}
      							if ($nombre_descripcion == "19182060"){
                        $nombre_descripcion = "OFICINA INTERCULTURAL";
      							}
      							if ($nombre_descripcion == "19140610"){
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

    <br>

    <!-- SECCION B.4 -->
    <div class="col-sm tab table-responsive" id="B4">
        <table class="table table-hover table-bordered table-sm">
            <thead>
                <tr>
                    <td colspan="10" class="active"><strong>SECCIÓN B.4: TALLERES GRUPALES SEGÚN TEMATICA Y NUMERO DE PARTICIPANTES EN PROGRAMA ESPACIOS AMIGABLES.</strong></td>
                </tr>
                <tr>
                    <td align="center"><strong>ESPACIOS DE ACCIÓN</strong></td>
                    <td align="center"><strong>TOTAL TALLERES</strong></td>
                    <td align="center"><strong>TOTAL PARTICIPANTES</strong></td>
                    <td align="center"><strong>ACTIVIDAD FISICA</strong></td>
                    <td align="center"><strong>ALIMENTACIÓN</strong></td>
                    <td align="center"><strong>AMBIENTE LIBRE DE HUMO DEL TABACO</strong></td>
                    <td align="center"><strong>FACTORES PROTECTORES PSICOSOCIALES</strong></td>
                    <td align="center"><strong>PREVENCIÓN CONSUMO DE ALCOHOL Y OTRAS DROGAS</strong></td>
                    <td align="center"><strong>SALUD SEXUAL Y PREVENCIÓN DE VIH/SIDA e ITS</strong></td>
                    <td align="center"><strong>OTROS TIPOS DE TALLERES</strong></td>
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
                          FROM (select c.* from 2019prestaciones c where c.codigo_prestacion in("19190104","19190105","19190106")) a
                          left join 2019rems b on (a.id_prestacion=b.prestacion_id_prestacion)
                          AND (b.Mes in ('.$mes.')) AND (b.establecimiento_id_establecimiento in ('.$estab.'))
                          group by a.codigo_prestacion, a.descripcion, a.id_prestacion
                          order by a.id_prestacion';
                $registro = DB::connection('mysql_rem')->select($query);

                $i=0;

                foreach($registro as $row ){
                    $nombre_descripcion = $row->codigo_prestacion;
                    if ($nombre_descripcion == "19190104"){
                        $nombre_descripcion = "ESPACIOS COMUNITARIOS";
      							}
                    if ($nombre_descripcion == "19190105"){
                        $nombre_descripcion = "ESTBLECIMIENTOS EDUCACIONALES";
      							}
                    if ($nombre_descripcion == "19190106"){
                        $nombre_descripcion = "CENTROS DE SALUD";
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
