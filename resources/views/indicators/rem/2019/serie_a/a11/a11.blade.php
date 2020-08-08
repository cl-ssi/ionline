@extends('layouts.app')

@section('title', 'Resumen Estadistico Mensual')

@section('content')

<?php

use Illuminate\Support\Facades\DB;

?>

@include('indicators.rem.partials.nav')

<h3>REM-A11. EXÁMENES DE PESQUISA DE ENFERMEDADES TRASMISIBLES.</h3>

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
                    <td colspan="49" class="active"><strong>SECCION A: EXÁMENES DE SÍFILIS.</strong></td>
                </tr>
                <tr>
                    <td colspan="49" class="active"><strong>SECCIÓN A.1: EXAMEN VDRL POR GRUPO DE USUARIOS (Uso exclusivo de establecimientos con Laboratorio que procesan).</strong></td>
                </tr>
                <tr>
                    <td rowspan="3" style="text-align:center; vertical-align:middle"><strong>GRUPO DE PESQUISA</strong></td>
                    <td colspan="2" rowspan="2" style="text-align:center; vertical-align:middle"><strong>TOTAL</strong></td>
                    <td colspan="40" align="center"><strong>POR EDAD (en meses - años)</strong></td>
                    <td colspan="2" align="center"><strong>POR SEXO(Procesados)</strong></td>
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
                    <td rowspan="2" align="center"><strong>Hombres</strong></td>
                    <td rowspan="2" align="center"><strong>Mujeres</strong></td>
                </tr>
                <tr>
                    <td align="center"><strong>Procesados</strong></td>
                    <td align="center"><strong>Reactivos</strong></td>
                    <td align="center"><strong>Procesados</strong></td>
                    <td align="center"><strong>Reactivos</strong></td>
                    <td align="center"><strong>Procesados</strong></td>
                    <td align="center"><strong>Reactivos</strong></td>
                    <td align="center"><strong>Procesados</strong></td>
                    <td align="center"><strong>Reactivos</strong></td>
                    <td align="center"><strong>Procesados</strong></td>
                    <td align="center"><strong>Reactivos</strong></td>
                    <td align="center"><strong>Procesados</strong></td>
                    <td align="center"><strong>Reactivos</strong></td>
                    <td align="center"><strong>Procesados</strong></td>
                    <td align="center"><strong>Reactivos</strong></td>
                    <td align="center"><strong>Procesados</strong></td>
                    <td align="center"><strong>Reactivos</strong></td>
                    <td align="center"><strong>Procesados</strong></td>
                    <td align="center"><strong>Reactivos</strong></td>
                    <td align="center"><strong>Procesados</strong></td>
                    <td align="center"><strong>Reactivos</strong></td>
                    <td align="center"><strong>Procesados</strong></td>
                    <td align="center"><strong>Reactivos</strong></td>
                    <td align="center"><strong>Procesados</strong></td>
                    <td align="center"><strong>Reactivos</strong></td>
                    <td align="center"><strong>Procesados</strong></td>
                    <td align="center"><strong>Reactivos</strong></td>
                    <td align="center"><strong>Procesados</strong></td>
                    <td align="center"><strong>Reactivos</strong></td>
                    <td align="center"><strong>Procesados</strong></td>
                    <td align="center"><strong>Reactivos</strong></td>
                    <td align="center"><strong>Procesados</strong></td>
                    <td align="center"><strong>Reactivos</strong></td>
                    <td align="center"><strong>Procesados</strong></td>
                    <td align="center"><strong>Reactivos</strong></td>
                    <td align="center"><strong>Procesados</strong></td>
                    <td align="center"><strong>Reactivos</strong></td>
                    <td align="center"><strong>Procesados</strong></td>
                    <td align="center"><strong>Reactivos</strong></td>
                    <td align="center"><strong>Procesados</strong></td>
                    <td align="center"><strong>Reactivos</strong></td>
                    <td align="center"><strong>Procesados</strong></td>
                    <td align="center"><strong>Reactivos</strong></td>
                    <td align="center"><strong>Procesados</strong></td>
                    <td align="center"><strong>Reactivos</strong></td>
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
            									,sum(ifnull(b.Col48,0)) Col48
                          FROM (select c.* from 2019prestaciones c where c.codigo_prestacion in("11053700","11053800","11053900","11054000","11051200","11051201","11041000","11041100",
                                                                                                "11051500","11051300","11040200","11051400","11040300","11040600","11040500","11054100",
                                                                                                "11054200","11054201")) a
                          left join 2019rems b on (a.id_prestacion=b.prestacion_id_prestacion)
                          AND (b.Mes in ('.$mes.')) AND (b.establecimiento_id_establecimiento in ('.$estab.'))
                          group by a.codigo_prestacion, a.descripcion, a.id_prestacion
                          order by a.id_prestacion';
                $registro = DB::connection('mysql_rem')->select($query);

                $i=0;

                foreach($registro as $row ){
                    $nombre_descripcion = $row->codigo_prestacion;
                    if ($nombre_descripcion == "11053700"){
      								$nombre_descripcion = "GESTANTES PRIMER TRIMESTRE EMBARAZO";
      							}
      							if ($nombre_descripcion == "11053800"){
      								$nombre_descripcion = "GESTANTES SEGUNDO TRIMESTRE EMBARAZO";
      							}
      							if ($nombre_descripcion == "11053900"){
      								$nombre_descripcion = "GESTANTES TERCER TRIMESTRE EMBARAZO";
      							}
      							if ($nombre_descripcion == "11054000"){
      								$nombre_descripcion = "GESTANTES TRIMESTRE EMBARAZO IGNORADO";
      							}
      							if ($nombre_descripcion == "11051200"){
      								$nombre_descripcion = "GESTANTES EN SEGUIMIENTO POR DIAGNÓSTICO SÍFILIS";
      							}
      							if ($nombre_descripcion == "11051201"){
      								$nombre_descripcion = "PAREJA DE GESTANTE CON SEROLOGÍA REACTIVA";
      							}
      							if ($nombre_descripcion == "11041000"){
      								$nombre_descripcion = "MUJERES QUE INGRESAN A MATERNIDAD POR PARTO";
      							}
      							if ($nombre_descripcion == "11041100"){
      								$nombre_descripcion = "MUJERES QUE INGRESAN POR ABORTO";
      							}
      							if ($nombre_descripcion == "11051500"){
      								$nombre_descripcion = "MUJERES EN CONTROL GINECOLÓGICO";
      							}
      							if ($nombre_descripcion == "11051300"){
      								$nombre_descripcion = "RECIÉN NACIDO Y LACTANTE PARA DETECCIÓN DE SÍFILIS CONGÉNITA";
      							}
      							if ($nombre_descripcion == "11040200"){
      								$nombre_descripcion = "PERSONAS EN CONTROL POR COMERCIO SEXUAL";
      							}
      							if ($nombre_descripcion == "11051400"){
      								$nombre_descripcion = "PERSONAS EN CONTROL FECUNDIDAD";
      							}
      							if ($nombre_descripcion == "11040300"){
      								$nombre_descripcion = "CONSULTANTES POR ITS";
      							}
      							if ($nombre_descripcion == "11040600"){
      								$nombre_descripcion = "PERSONAS CON EMP";
      							}
      							if ($nombre_descripcion == "11040500"){
      								$nombre_descripcion = "DONANTES DE SANGRE";
      							}
      							if ($nombre_descripcion == "11054100"){
      								$nombre_descripcion = "DONANTES DE ÓRGANOS Y/O TEJIDOS";
      							}
      							if ($nombre_descripcion == "11054200"){
      								$nombre_descripcion = "PACIENTES EN DIÁLISIS";
      							}
      							if ($nombre_descripcion == "11054201"){
      								$nombre_descripcion = "VÍCTIMA DE VIOLENCIA SEXUAL";
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
                    <td align='right'><?php echo number_format($row->Col42,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col43,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col44,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col45,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col46,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col47,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col48,0,",",".")?></td>
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
                    <td colspan="49" class="active"><strong>SECCIÓN A.2: EXAMEN VDRL POR GRUPO DE USUARIOS (Uso exclusivo de establecimientos que Compran Servicio).</strong></td>
                </tr>
                <tr>
                    <td rowspan="3" style="text-align:center; vertical-align:middle"><strong>GRUPO DE PESQUISA</strong></td>
                    <td colspan="2" rowspan="2" style="text-align:center; vertical-align:middle"><strong>TOTAL</strong></td>
                    <td colspan="40" align="center"><strong>POR EDAD (en meses - años)</strong></td>
                    <td colspan="2" align="center"><strong>POR SEXO(Procesados)</strong></td>
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
                    <td rowspan="2" align="center"><strong>Hombres</strong></td>
                    <td rowspan="2" align="center"><strong>Mujeres</strong></td>
                </tr>
                <tr>
                    <td align="center"><strong>Procesados</strong></td>
                    <td align="center"><strong>Reactivos</strong></td>
                    <td align="center"><strong>Procesados</strong></td>
                    <td align="center"><strong>Reactivos</strong></td>
                    <td align="center"><strong>Procesados</strong></td>
                    <td align="center"><strong>Reactivos</strong></td>
                    <td align="center"><strong>Procesados</strong></td>
                    <td align="center"><strong>Reactivos</strong></td>
                    <td align="center"><strong>Procesados</strong></td>
                    <td align="center"><strong>Reactivos</strong></td>
                    <td align="center"><strong>Procesados</strong></td>
                    <td align="center"><strong>Reactivos</strong></td>
                    <td align="center"><strong>Procesados</strong></td>
                    <td align="center"><strong>Reactivos</strong></td>
                    <td align="center"><strong>Procesados</strong></td>
                    <td align="center"><strong>Reactivos</strong></td>
                    <td align="center"><strong>Procesados</strong></td>
                    <td align="center"><strong>Reactivos</strong></td>
                    <td align="center"><strong>Procesados</strong></td>
                    <td align="center"><strong>Reactivos</strong></td>
                    <td align="center"><strong>Procesados</strong></td>
                    <td align="center"><strong>Reactivos</strong></td>
                    <td align="center"><strong>Procesados</strong></td>
                    <td align="center"><strong>Reactivos</strong></td>
                    <td align="center"><strong>Procesados</strong></td>
                    <td align="center"><strong>Reactivos</strong></td>
                    <td align="center"><strong>Procesados</strong></td>
                    <td align="center"><strong>Reactivos</strong></td>
                    <td align="center"><strong>Procesados</strong></td>
                    <td align="center"><strong>Reactivos</strong></td>
                    <td align="center"><strong>Procesados</strong></td>
                    <td align="center"><strong>Reactivos</strong></td>
                    <td align="center"><strong>Procesados</strong></td>
                    <td align="center"><strong>Reactivos</strong></td>
                    <td align="center"><strong>Procesados</strong></td>
                    <td align="center"><strong>Reactivos</strong></td>
                    <td align="center"><strong>Procesados</strong></td>
                    <td align="center"><strong>Reactivos</strong></td>
                    <td align="center"><strong>Procesados</strong></td>
                    <td align="center"><strong>Reactivos</strong></td>
                    <td align="center"><strong>Procesados</strong></td>
                    <td align="center"><strong>Reactivos</strong></td>
                    <td align="center"><strong>Procesados</strong></td>
                    <td align="center"><strong>Reactivos</strong></td>
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
            									,sum(ifnull(b.Col48,0)) Col48
                          FROM (select c.* from 2019prestaciones c where c.codigo_prestacion in("11054202","11054203","11054204","11054205","11054206","11054207","11054208","11054209",
                                                                                                "11054210","11054211","11054212","11054213","11054214","11054215","11054216","11054217",
                                                                                                "11054218","11054219")) a
                          left join 2019rems b on (a.id_prestacion=b.prestacion_id_prestacion)
                          AND (b.Mes in ('.$mes.')) AND (b.establecimiento_id_establecimiento in ('.$estab.'))
                          group by a.codigo_prestacion, a.descripcion, a.id_prestacion
                          order by a.id_prestacion';
                $registro = DB::connection('mysql_rem')->select($query);

                $i=0;

                foreach($registro as $row ){
                    $nombre_descripcion = $row->codigo_prestacion;
                    if ($nombre_descripcion == "11054202"){
                        $nombre_descripcion = "GESTANTES PRIMER TRIMESTRE EMBARAZO";
      							}
      							if ($nombre_descripcion == "11054203"){
                        $nombre_descripcion = "GESTANTES SEGUNDO TRIMESTRE EMBARAZO";
      							}
      							if ($nombre_descripcion == "11054204"){
                        $nombre_descripcion = "GESTANTES TERCER TRIMESTRE EMBARAZO";
      							}
      							if ($nombre_descripcion == "11054205"){
                        $nombre_descripcion = "GESTANTES TRIMESTRE EMBARAZO IGNORADO";
      							}
      							if ($nombre_descripcion == "11054206"){
                        $nombre_descripcion = "GESTANTES EN SEGUIMIENTO POR DIAGNÓSTICO SÍFILIS";
      							}
      							if ($nombre_descripcion == "11054207"){
                        $nombre_descripcion = "PAREJA DE GESTANTE CON SEROLOGÍA REACTIVA";
      							}
      							if ($nombre_descripcion == "11054208"){
                        $nombre_descripcion = "MUJERES QUE INGRESAN A MATERNIDAD POR PARTO";
      							}
      							if ($nombre_descripcion == "11054209"){
                        $nombre_descripcion = "MUJERES QUE INGRESAN POR ABORTO";
      							}
      							if ($nombre_descripcion == "11054210"){
                        $nombre_descripcion = "MUJERES EN CONTROL GINECOLÓGICO";
      							}
      							if ($nombre_descripcion == "11054211"){
                        $nombre_descripcion = "RECIÉN NACIDO Y LACTANTE PARA DETECCIÓN DE SÍFILIS CONGÉNITA";
      							}
      							if ($nombre_descripcion == "11054212"){
                        $nombre_descripcion = "PERSONAS EN CONTROL POR COMERCIO SEXUAL";
      							}
      							if ($nombre_descripcion == "11054213"){
                        $nombre_descripcion = "PERSONAS EN CONTROL FECUNDIDAD";
      							}
      							if ($nombre_descripcion == "11054214"){
                        $nombre_descripcion = "CONSULTANTES POR ITS";
      							}
      							if ($nombre_descripcion == "11054215"){
                        $nombre_descripcion = "PERSONAS CON EMP";
      							}
      							if ($nombre_descripcion == "11054216"){
                        $nombre_descripcion = "DONANTES DE SANGRE";
      							}
      							if ($nombre_descripcion == "11054217"){
                        $nombre_descripcion = "DONANTES DE ÓRGANOS Y/O TEJIDOS";
      							}
      							if ($nombre_descripcion == "11054218"){
                        $nombre_descripcion = "PACIENTES EN DIÁLISIS";
      							}
      							if ($nombre_descripcion == "11054219"){
                        $nombre_descripcion = "VÍCTIMA DE VIOLENCIA SEXUAL";
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
                    <td align='right'><?php echo number_format($row->Col42,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col43,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col44,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col45,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col46,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col47,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col48,0,",",".")?></td>
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
                    <td colspan="49" class="active"><strong>SECCIÓN A.3: EXAMEN RPR POR GRUPO DE USUARIOS (Uso exclusivo de establecimientos con Laboratorio que procesan).</strong></td>
                </tr>
                <tr>
                    <td rowspan="3" style="text-align:center; vertical-align:middle"><strong>GRUPO DE PESQUISA</strong></td>
                    <td colspan="2" rowspan="2" style="text-align:center; vertical-align:middle"><strong>TOTAL</strong></td>
                    <td colspan="40" align="center"><strong>POR EDAD (en meses - años)</strong></td>
                    <td colspan="2" align="center"><strong>POR SEXO(Procesados)</strong></td>
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
                    <td rowspan="2" align="center"><strong>Hombres</strong></td>
                    <td rowspan="2" align="center"><strong>Mujeres</strong></td>
                </tr>
                <tr>
                    <td align="center"><strong>Procesados</strong></td>
                    <td align="center"><strong>Reactivos</strong></td>
                    <td align="center"><strong>Procesados</strong></td>
                    <td align="center"><strong>Reactivos</strong></td>
                    <td align="center"><strong>Procesados</strong></td>
                    <td align="center"><strong>Reactivos</strong></td>
                    <td align="center"><strong>Procesados</strong></td>
                    <td align="center"><strong>Reactivos</strong></td>
                    <td align="center"><strong>Procesados</strong></td>
                    <td align="center"><strong>Reactivos</strong></td>
                    <td align="center"><strong>Procesados</strong></td>
                    <td align="center"><strong>Reactivos</strong></td>
                    <td align="center"><strong>Procesados</strong></td>
                    <td align="center"><strong>Reactivos</strong></td>
                    <td align="center"><strong>Procesados</strong></td>
                    <td align="center"><strong>Reactivos</strong></td>
                    <td align="center"><strong>Procesados</strong></td>
                    <td align="center"><strong>Reactivos</strong></td>
                    <td align="center"><strong>Procesados</strong></td>
                    <td align="center"><strong>Reactivos</strong></td>
                    <td align="center"><strong>Procesados</strong></td>
                    <td align="center"><strong>Reactivos</strong></td>
                    <td align="center"><strong>Procesados</strong></td>
                    <td align="center"><strong>Reactivos</strong></td>
                    <td align="center"><strong>Procesados</strong></td>
                    <td align="center"><strong>Reactivos</strong></td>
                    <td align="center"><strong>Procesados</strong></td>
                    <td align="center"><strong>Reactivos</strong></td>
                    <td align="center"><strong>Procesados</strong></td>
                    <td align="center"><strong>Reactivos</strong></td>
                    <td align="center"><strong>Procesados</strong></td>
                    <td align="center"><strong>Reactivos</strong></td>
                    <td align="center"><strong>Procesados</strong></td>
                    <td align="center"><strong>Reactivos</strong></td>
                    <td align="center"><strong>Procesados</strong></td>
                    <td align="center"><strong>Reactivos</strong></td>
                    <td align="center"><strong>Procesados</strong></td>
                    <td align="center"><strong>Reactivos</strong></td>
                    <td align="center"><strong>Procesados</strong></td>
                    <td align="center"><strong>Reactivos</strong></td>
                    <td align="center"><strong>Procesados</strong></td>
                    <td align="center"><strong>Reactivos</strong></td>
                    <td align="center"><strong>Procesados</strong></td>
                    <td align="center"><strong>Reactivos</strong></td>
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
            									,sum(ifnull(b.Col48,0)) Col48
                          FROM (select c.* from 2019prestaciones c where c.codigo_prestacion in("11056400","11056401","11056402","11056403","11056404","11056405","11056406","11056407",
                                                                                                "11056408","11056409","11056410","11056411","11056412","11056413","11056414","11056415",
                                                                                                "11056416","11056417")) a
                          left join 2019rems b on (a.id_prestacion=b.prestacion_id_prestacion)
                          AND (b.Mes in ('.$mes.')) AND (b.establecimiento_id_establecimiento in ('.$estab.'))
                          group by a.codigo_prestacion, a.descripcion, a.id_prestacion
                          order by a.id_prestacion';
                $registro = DB::connection('mysql_rem')->select($query);

                $i=0;

                foreach($registro as $row ){
                    $nombre_descripcion = $row->codigo_prestacion;
                    if ($nombre_descripcion == "11056400"){
                        $nombre_descripcion = "GESTANTES PRIMER TRIMESTRE EMBARAZO";
      							}
      							if ($nombre_descripcion == "11056401"){
                        $nombre_descripcion = "GESTANTES SEGUNDO TRIMESTRE EMBARAZO";
      							}
      							if ($nombre_descripcion == "11056402"){
                        $nombre_descripcion = "GESTANTES TERCER TRIMESTRE EMBARAZO";
      							}
      							if ($nombre_descripcion == "11056403"){
                        $nombre_descripcion = "GESTANTES TRIMESTRE EMBARAZO IGNORADO";
      							}
      							if ($nombre_descripcion == "11056404"){
                        $nombre_descripcion = "GESTANTES EN SEGUIMIENTO POR DIAGNÓSTICO SÍFILIS";
      							}
      							if ($nombre_descripcion == "11056405"){
                        $nombre_descripcion = "PAREJA DE GESTANTE CON SEROLOGÍA REACTIVA";
      							}
      							if ($nombre_descripcion == "11056406"){
                        $nombre_descripcion = "MUJERES QUE INGRESAN A MATERNIDAD POR PARTO";
      							}
      							if ($nombre_descripcion == "11056407"){
                        $nombre_descripcion = "MUJERES QUE INGRESAN POR ABORTO";
      							}
      							if ($nombre_descripcion == "11056408"){
                        $nombre_descripcion = "MUJERES EN CONTROL GINECOLÓGICO";
      							}
      							if ($nombre_descripcion == "11056409"){
                        $nombre_descripcion = "RECIÉN NACIDO Y LACTANTE PARA DETECCIÓN DE SÍFILIS CONGÉNITA";
      							}
      							if ($nombre_descripcion == "11056410"){
                        $nombre_descripcion = "PERSONAS EN CONTROL POR COMERCIO SEXUAL";
      							}
      							if ($nombre_descripcion == "11056411"){
                        $nombre_descripcion = "PERSONAS EN CONTROL FECUNDIDAD";
      							}
      							if ($nombre_descripcion == "11056412"){
                        $nombre_descripcion = "CONSULTANTES POR ITS";
      							}
      							if ($nombre_descripcion == "11056413"){
                        $nombre_descripcion = "PERSONAS CON EMP";
      							}
      							if ($nombre_descripcion == "11056414"){
                        $nombre_descripcion = "DONANTES DE SANGRE";
      							}
      							if ($nombre_descripcion == "11056415"){
                        $nombre_descripcion = "DONANTES DE ÓRGANOS Y/O TEJIDOS";
      							}
      							if ($nombre_descripcion == "11056416"){
                        $nombre_descripcion = "PACIENTES EN DIÁLISIS";
      							}
      							if ($nombre_descripcion == "11056417"){
                        $nombre_descripcion = "VÍCTIMA DE VIOLENCIA SEXUAL";
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
                    <td align='right'><?php echo number_format($row->Col42,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col43,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col44,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col45,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col46,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col47,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col48,0,",",".")?></td>
                    <?php
                    $i++;
                }
                ?>
                </tr>
            </tbody>
        </table>
    </div>

    <br>

    <!-- SECCION A.4 -->
    <div class="col-sm tab table-responsive" id="A4">
        <table class="table table-hover table-bordered table-sm">
            <thead>
                <tr>
                    <td colspan="49" class="active"><strong>SECCIÓN A.4: EXAMEN RPR POR GRUPO DE USUARIOS (Uso exclusivo de establecimientos que Compran Servicio).</strong></td>
                </tr>
                <tr>
                    <td rowspan="3" style="text-align:center; vertical-align:middle"><strong>GRUPO DE PESQUISA</strong></td>
                    <td colspan="2" rowspan="2" style="text-align:center; vertical-align:middle"><strong>TOTAL</strong></td>
                    <td colspan="40" align="center"><strong>POR EDAD (en meses - años)</strong></td>
                    <td colspan="2" align="center"><strong>POR SEXO(Procesados)</strong></td>
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
                    <td rowspan="2" align="center"><strong>Hombres</strong></td>
                    <td rowspan="2" align="center"><strong>Mujeres</strong></td>
                </tr>
                <tr>
                    <td align="center"><strong>Procesados</strong></td>
                    <td align="center"><strong>Reactivos</strong></td>
                    <td align="center"><strong>Procesados</strong></td>
                    <td align="center"><strong>Reactivos</strong></td>
                    <td align="center"><strong>Procesados</strong></td>
                    <td align="center"><strong>Reactivos</strong></td>
                    <td align="center"><strong>Procesados</strong></td>
                    <td align="center"><strong>Reactivos</strong></td>
                    <td align="center"><strong>Procesados</strong></td>
                    <td align="center"><strong>Reactivos</strong></td>
                    <td align="center"><strong>Procesados</strong></td>
                    <td align="center"><strong>Reactivos</strong></td>
                    <td align="center"><strong>Procesados</strong></td>
                    <td align="center"><strong>Reactivos</strong></td>
                    <td align="center"><strong>Procesados</strong></td>
                    <td align="center"><strong>Reactivos</strong></td>
                    <td align="center"><strong>Procesados</strong></td>
                    <td align="center"><strong>Reactivos</strong></td>
                    <td align="center"><strong>Procesados</strong></td>
                    <td align="center"><strong>Reactivos</strong></td>
                    <td align="center"><strong>Procesados</strong></td>
                    <td align="center"><strong>Reactivos</strong></td>
                    <td align="center"><strong>Procesados</strong></td>
                    <td align="center"><strong>Reactivos</strong></td>
                    <td align="center"><strong>Procesados</strong></td>
                    <td align="center"><strong>Reactivos</strong></td>
                    <td align="center"><strong>Procesados</strong></td>
                    <td align="center"><strong>Reactivos</strong></td>
                    <td align="center"><strong>Procesados</strong></td>
                    <td align="center"><strong>Reactivos</strong></td>
                    <td align="center"><strong>Procesados</strong></td>
                    <td align="center"><strong>Reactivos</strong></td>
                    <td align="center"><strong>Procesados</strong></td>
                    <td align="center"><strong>Reactivos</strong></td>
                    <td align="center"><strong>Procesados</strong></td>
                    <td align="center"><strong>Reactivos</strong></td>
                    <td align="center"><strong>Procesados</strong></td>
                    <td align="center"><strong>Reactivos</strong></td>
                    <td align="center"><strong>Procesados</strong></td>
                    <td align="center"><strong>Reactivos</strong></td>
                    <td align="center"><strong>Procesados</strong></td>
                    <td align="center"><strong>Reactivos</strong></td>
                    <td align="center"><strong>Procesados</strong></td>
                    <td align="center"><strong>Reactivos</strong></td>
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
            									,sum(ifnull(b.Col48,0)) Col48
                          FROM (select c.* from 2019prestaciones c where c.codigo_prestacion in("11056418","11056419","11056420","11056421","11056422","11056423","11056424","11056425",
                                                                                                "11056426","11056427","11056428","11056429","11056430","11056431","11056432","11056433",
                                                                                                "11056434","11056435")) a
                          left join 2019rems b on (a.id_prestacion=b.prestacion_id_prestacion)
                          AND (b.Mes in ('.$mes.')) AND (b.establecimiento_id_establecimiento in ('.$estab.'))
                          group by a.codigo_prestacion, a.descripcion, a.id_prestacion
                          order by a.id_prestacion';
                $registro = DB::connection('mysql_rem')->select($query);

                $i=0;

                foreach($registro as $row ){
                    $nombre_descripcion = $row->codigo_prestacion;
                    if ($nombre_descripcion == "11056418"){
                        $nombre_descripcion = "GESTANTES PRIMER TRIMESTRE EMBARAZO";
      							}
      							if ($nombre_descripcion == "11056419"){
                        $nombre_descripcion = "GESTANTES SEGUNDO TRIMESTRE EMBARAZO";
      							}
      							if ($nombre_descripcion == "11056420"){
                        $nombre_descripcion = "GESTANTES TERCER TRIMESTRE EMBARAZO";
      							}
      							if ($nombre_descripcion == "11056421"){
                        $nombre_descripcion = "GESTANTES TRIMESTRE EMBARAZO IGNORADO";
      							}
      							if ($nombre_descripcion == "11056422"){
                        $nombre_descripcion = "GESTANTES EN SEGUIMIENTO POR DIAGNÓSTICO SÍFILIS";
      							}
      							if ($nombre_descripcion == "11056423"){
                        $nombre_descripcion = "PAREJA DE GESTANTE CON SEROLOGÍA REACTIVA";
      							}
      							if ($nombre_descripcion == "11056424"){
                        $nombre_descripcion = "MUJERES QUE INGRESAN A MATERNIDAD POR PARTO";
      							}
      							if ($nombre_descripcion == "11056425"){
                        $nombre_descripcion = "MUJERES QUE INGRESAN POR ABORTO";
      							}
      							if ($nombre_descripcion == "11056426"){
                        $nombre_descripcion = "MUJERES EN CONTROL GINECOLÓGICO";
      							}
      							if ($nombre_descripcion == "11056427"){
                        $nombre_descripcion = "RECIÉN NACIDO Y LACTANTE PARA DETECCIÓN DE SÍFILIS CONGÉNITA";
      							}
      							if ($nombre_descripcion == "11056428"){
                        $nombre_descripcion = "PERSONAS EN CONTROL POR COMERCIO SEXUAL";
      							}
      							if ($nombre_descripcion == "11056429"){
                        $nombre_descripcion = "PERSONAS EN CONTROL FECUNDIDAD";
      							}
      							if ($nombre_descripcion == "11056430"){
                        $nombre_descripcion = "CONSULTANTES POR ITS";
      							}
      							if ($nombre_descripcion == "11056431"){
                        $nombre_descripcion = "PERSONAS CON EMP";
      							}
      							if ($nombre_descripcion == "11056432"){
                        $nombre_descripcion = "DONANTES DE SANGRE";
      							}
      							if ($nombre_descripcion == "11056433"){
                        $nombre_descripcion = "DONANTES DE ÓRGANOS Y/O TEJIDOS";
      							}
      							if ($nombre_descripcion == "11056434"){
                        $nombre_descripcion = "PACIENTES EN DIÁLISIS";
      							}
      							if ($nombre_descripcion == "11056435"){
                        $nombre_descripcion = "VÍCTIMA DE VIOLENCIA SEXUAL";
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
                    <td align='right'><?php echo number_format($row->Col42,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col43,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col44,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col45,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col46,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col47,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col48,0,",",".")?></td>
                    <?php
                    $i++;
                }
                ?>
                </tr>
            </tbody>
        </table>
    </div>

    <br>

    <!-- SECCION A.5 -->
    <div class="col-sm tab table-responsive" id="A5">
        <table class="table table-hover table-bordered table-sm">
            <thead>
                <tr>
                    <td colspan="49" class="active"><strong>SECCIÓN A.5: EXAMEN MHA-TP POR GRUPO DE USUARIOS (Uso exclusivo de establecimientos con Laboratorio que procesan).</strong></td>
                </tr>
                <tr>
                    <td rowspan="3" style="text-align:center; vertical-align:middle"><strong>GRUPO DE PESQUISA</strong></td>
                    <td colspan="2" rowspan="2" style="text-align:center; vertical-align:middle"><strong>TOTAL</strong></td>
                    <td colspan="40" align="center"><strong>POR EDAD (en meses - años)</strong></td>
                    <td colspan="2" align="center"><strong>POR SEXO(Procesados)</strong></td>
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
                    <td rowspan="2" align="center"><strong>Hombres</strong></td>
                    <td rowspan="2" align="center"><strong>Mujeres</strong></td>
                </tr>
                <tr>
                    <td align="center"><strong>Procesados</strong></td>
                    <td align="center"><strong>Reactivos</strong></td>
                    <td align="center"><strong>Procesados</strong></td>
                    <td align="center"><strong>Reactivos</strong></td>
                    <td align="center"><strong>Procesados</strong></td>
                    <td align="center"><strong>Reactivos</strong></td>
                    <td align="center"><strong>Procesados</strong></td>
                    <td align="center"><strong>Reactivos</strong></td>
                    <td align="center"><strong>Procesados</strong></td>
                    <td align="center"><strong>Reactivos</strong></td>
                    <td align="center"><strong>Procesados</strong></td>
                    <td align="center"><strong>Reactivos</strong></td>
                    <td align="center"><strong>Procesados</strong></td>
                    <td align="center"><strong>Reactivos</strong></td>
                    <td align="center"><strong>Procesados</strong></td>
                    <td align="center"><strong>Reactivos</strong></td>
                    <td align="center"><strong>Procesados</strong></td>
                    <td align="center"><strong>Reactivos</strong></td>
                    <td align="center"><strong>Procesados</strong></td>
                    <td align="center"><strong>Reactivos</strong></td>
                    <td align="center"><strong>Procesados</strong></td>
                    <td align="center"><strong>Reactivos</strong></td>
                    <td align="center"><strong>Procesados</strong></td>
                    <td align="center"><strong>Reactivos</strong></td>
                    <td align="center"><strong>Procesados</strong></td>
                    <td align="center"><strong>Reactivos</strong></td>
                    <td align="center"><strong>Procesados</strong></td>
                    <td align="center"><strong>Reactivos</strong></td>
                    <td align="center"><strong>Procesados</strong></td>
                    <td align="center"><strong>Reactivos</strong></td>
                    <td align="center"><strong>Procesados</strong></td>
                    <td align="center"><strong>Reactivos</strong></td>
                    <td align="center"><strong>Procesados</strong></td>
                    <td align="center"><strong>Reactivos</strong></td>
                    <td align="center"><strong>Procesados</strong></td>
                    <td align="center"><strong>Reactivos</strong></td>
                    <td align="center"><strong>Procesados</strong></td>
                    <td align="center"><strong>Reactivos</strong></td>
                    <td align="center"><strong>Procesados</strong></td>
                    <td align="center"><strong>Reactivos</strong></td>
                    <td align="center"><strong>Procesados</strong></td>
                    <td align="center"><strong>Reactivos</strong></td>
                    <td align="center"><strong>Procesados</strong></td>
                    <td align="center"><strong>Reactivos</strong></td>
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
            									,sum(ifnull(b.Col48,0)) Col48
                          FROM (select c.* from 2019prestaciones c where c.codigo_prestacion in("11056436","11056437","11056438","11056439","11056440","11056441","11056442","11056443",
                                                                                                "11056444","11056445","11056446","11056447","11056448","11056449","11056450","11056451",
                                                                                                "11056452","11056453")) a
                          left join 2019rems b on (a.id_prestacion=b.prestacion_id_prestacion)
                          AND (b.Mes in ('.$mes.')) AND (b.establecimiento_id_establecimiento in ('.$estab.'))
                          group by a.codigo_prestacion, a.descripcion, a.id_prestacion
                          order by a.id_prestacion';
                $registro = DB::connection('mysql_rem')->select($query);

                $i=0;

                foreach($registro as $row ){
                    $nombre_descripcion = $row->codigo_prestacion;
                    if ($nombre_descripcion == "11056436"){
                        $nombre_descripcion = "GESTANTES PRIMER TRIMESTRE EMBARAZO";
      							}
      							if ($nombre_descripcion == "11056437"){
                        $nombre_descripcion = "GESTANTES SEGUNDO TRIMESTRE EMBARAZO";
      							}
      							if ($nombre_descripcion == "11056438"){
                        $nombre_descripcion = "GESTANTES TERCER TRIMESTRE EMBARAZO";
      							}
      							if ($nombre_descripcion == "11056439"){
                        $nombre_descripcion = "GESTANTES TRIMESTRE EMBARAZO IGNORADO";
      							}
      							if ($nombre_descripcion == "11056440"){
                        $nombre_descripcion = "GESTANTES EN SEGUIMIENTO POR DIAGNÓSTICO SÍFILIS";
      							}
      							if ($nombre_descripcion == "11056441"){
                        $nombre_descripcion = "PAREJA DE GESTANTE CON SEROLOGÍA REACTIVA";
      							}
      							if ($nombre_descripcion == "11056442"){
                        $nombre_descripcion = "MUJERES QUE INGRESAN A MATERNIDAD POR PARTO";
      							}
      							if ($nombre_descripcion == "11056443"){
                        $nombre_descripcion = "MUJERES QUE INGRESAN POR ABORTO";
      							}
      							if ($nombre_descripcion == "11056444"){
                        $nombre_descripcion = "MUJERES EN CONTROL GINECOLÓGICO";
      							}
      							if ($nombre_descripcion == "11056445"){
                        $nombre_descripcion = "RECIÉN NACIDO Y LACTANTE PARA DETECCIÓN DE SÍFILIS CONGÉNITA";
      							}
      							if ($nombre_descripcion == "11056446"){
                        $nombre_descripcion = "PERSONAS EN CONTROL POR COMERCIO SEXUAL";
      							}
      							if ($nombre_descripcion == "11056447"){
                        $nombre_descripcion = "PERSONAS EN CONTROL FECUNDIDAD";
      							}
      							if ($nombre_descripcion == "11056448"){
                        $nombre_descripcion = "CONSULTANTES POR ITS";
      							}
      							if ($nombre_descripcion == "11056449"){
                        $nombre_descripcion = "PERSONAS CON EMP";
      							}
      							if ($nombre_descripcion == "11056450"){
                        $nombre_descripcion = "DONANTES DE SANGRE";
      							}
      							if ($nombre_descripcion == "11056451"){
                        $nombre_descripcion = "DONANTES DE ÓRGANOS Y/O TEJIDOS";
      							}
      							if ($nombre_descripcion == "11056452"){
                        $nombre_descripcion = "PACIENTES EN DIÁLISIS";
      							}
      							if ($nombre_descripcion == "11056453"){
                        $nombre_descripcion = "VÍCTIMA DE VIOLENCIA SEXUAL";
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
                    <td align='right'><?php echo number_format($row->Col42,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col43,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col44,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col45,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col46,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col47,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col48,0,",",".")?></td>
                    <?php
                    $i++;
                }
                ?>
                </tr>
            </tbody>
        </table>
    </div>

    <br>

    <!-- SECCION A.6 -->
    <div class="col-sm tab table-responsive" id="A6">
        <table class="table table-hover table-bordered table-sm">
            <thead>
                <tr>
                    <td colspan="49" class="active"><strong>SECCIÓN A.6: EXAMEN MHA-TP POR GRUPO DE USUARIOS (Uso exclusivo de establecimientos que Compran Servicio).</strong></td>
                </tr>
                <tr>
                    <td rowspan="3" style="text-align:center; vertical-align:middle"><strong>GRUPO DE PESQUISA</strong></td>
                    <td colspan="2" rowspan="2" style="text-align:center; vertical-align:middle"><strong>TOTAL</strong></td>
                    <td colspan="40" align="center"><strong>POR EDAD (en meses - años)</strong></td>
                    <td colspan="2" align="center"><strong>POR SEXO(Procesados)</strong></td>
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
                    <td rowspan="2" align="center"><strong>Hombres</strong></td>
                    <td rowspan="2" align="center"><strong>Mujeres</strong></td>
                </tr>
                <tr>
                    <td align="center"><strong>Procesados</strong></td>
                    <td align="center"><strong>Reactivos</strong></td>
                    <td align="center"><strong>Procesados</strong></td>
                    <td align="center"><strong>Reactivos</strong></td>
                    <td align="center"><strong>Procesados</strong></td>
                    <td align="center"><strong>Reactivos</strong></td>
                    <td align="center"><strong>Procesados</strong></td>
                    <td align="center"><strong>Reactivos</strong></td>
                    <td align="center"><strong>Procesados</strong></td>
                    <td align="center"><strong>Reactivos</strong></td>
                    <td align="center"><strong>Procesados</strong></td>
                    <td align="center"><strong>Reactivos</strong></td>
                    <td align="center"><strong>Procesados</strong></td>
                    <td align="center"><strong>Reactivos</strong></td>
                    <td align="center"><strong>Procesados</strong></td>
                    <td align="center"><strong>Reactivos</strong></td>
                    <td align="center"><strong>Procesados</strong></td>
                    <td align="center"><strong>Reactivos</strong></td>
                    <td align="center"><strong>Procesados</strong></td>
                    <td align="center"><strong>Reactivos</strong></td>
                    <td align="center"><strong>Procesados</strong></td>
                    <td align="center"><strong>Reactivos</strong></td>
                    <td align="center"><strong>Procesados</strong></td>
                    <td align="center"><strong>Reactivos</strong></td>
                    <td align="center"><strong>Procesados</strong></td>
                    <td align="center"><strong>Reactivos</strong></td>
                    <td align="center"><strong>Procesados</strong></td>
                    <td align="center"><strong>Reactivos</strong></td>
                    <td align="center"><strong>Procesados</strong></td>
                    <td align="center"><strong>Reactivos</strong></td>
                    <td align="center"><strong>Procesados</strong></td>
                    <td align="center"><strong>Reactivos</strong></td>
                    <td align="center"><strong>Procesados</strong></td>
                    <td align="center"><strong>Reactivos</strong></td>
                    <td align="center"><strong>Procesados</strong></td>
                    <td align="center"><strong>Reactivos</strong></td>
                    <td align="center"><strong>Procesados</strong></td>
                    <td align="center"><strong>Reactivos</strong></td>
                    <td align="center"><strong>Procesados</strong></td>
                    <td align="center"><strong>Reactivos</strong></td>
                    <td align="center"><strong>Procesados</strong></td>
                    <td align="center"><strong>Reactivos</strong></td>
                    <td align="center"><strong>Procesados</strong></td>
                    <td align="center"><strong>Reactivos</strong></td>
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
            									,sum(ifnull(b.Col48,0)) Col48
                          FROM (select c.* from 2019prestaciones c where c.codigo_prestacion in("11056454","11056455","11056456","11056457","11056458","11056459","11056460","11056461",
                                                                                                "11056462","11056463","11056464","11056465","11056466","11056467","11056468","11056469",
                                                                                                "11056470","11056471")) a
                          left join 2019rems b on (a.id_prestacion=b.prestacion_id_prestacion)
                          AND (b.Mes in ('.$mes.')) AND (b.establecimiento_id_establecimiento in ('.$estab.'))
                          group by a.codigo_prestacion, a.descripcion, a.id_prestacion
                          order by a.id_prestacion';
                $registro = DB::connection('mysql_rem')->select($query);

                $i=0;

                foreach($registro as $row ){
                    $nombre_descripcion = $row->codigo_prestacion;
                    if ($nombre_descripcion == "11056454"){
                        $nombre_descripcion = "GESTANTES PRIMER TRIMESTRE EMBARAZO";
      							}
      							if ($nombre_descripcion == "11056455"){
                        $nombre_descripcion = "GESTANTES SEGUNDO TRIMESTRE EMBARAZO";
      							}
      							if ($nombre_descripcion == "11056456"){
                        $nombre_descripcion = "GESTANTES TERCER TRIMESTRE EMBARAZO";
      							}
      							if ($nombre_descripcion == "11056457"){
                        $nombre_descripcion = "GESTANTES TRIMESTRE EMBARAZO IGNORADO";
      							}
      							if ($nombre_descripcion == "11056458"){
                        $nombre_descripcion = "GESTANTES EN SEGUIMIENTO POR DIAGNÓSTICO SÍFILIS";
      							}
      							if ($nombre_descripcion == "11056459"){
                        $nombre_descripcion = "PAREJA DE GESTANTE CON SEROLOGÍA REACTIVA";
      							}
      							if ($nombre_descripcion == "11056460"){
                        $nombre_descripcion = "MUJERES QUE INGRESAN A MATERNIDAD POR PARTO";
      							}
      							if ($nombre_descripcion == "11056461"){
                        $nombre_descripcion = "MUJERES QUE INGRESAN POR ABORTO";
      							}
      							if ($nombre_descripcion == "11056462"){
                        $nombre_descripcion = "MUJERES EN CONTROL GINECOLÓGICO";
      							}
      							if ($nombre_descripcion == "11056463"){
                        $nombre_descripcion = "RECIÉN NACIDO Y LACTANTE PARA DETECCIÓN DE SÍFILIS CONGÉNITA";
      							}
      							if ($nombre_descripcion == "11056464"){
                        $nombre_descripcion = "PERSONAS EN CONTROL POR COMERCIO SEXUAL";
      							}
      							if ($nombre_descripcion == "11056465"){
                        $nombre_descripcion = "PERSONAS EN CONTROL FECUNDIDAD";
      							}
      							if ($nombre_descripcion == "11056466"){
                        $nombre_descripcion = "CONSULTANTES POR ITS";
      							}
      							if ($nombre_descripcion == "11056467"){
                        $nombre_descripcion = "PERSONAS CON EMP";
      							}
      							if ($nombre_descripcion == "11056468"){
                        $nombre_descripcion = "DONANTES DE SANGRE";
      							}
      							if ($nombre_descripcion == "11056469"){
                        $nombre_descripcion = "DONANTES DE ÓRGANOS Y/O TEJIDOS";
      							}
      							if ($nombre_descripcion == "11056470"){
                        $nombre_descripcion = "PACIENTES EN DIÁLISIS";
      							}
      							if ($nombre_descripcion == "11056471"){
                        $nombre_descripcion = "VÍCTIMA DE VIOLENCIA SEXUAL";
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
                    <td align='right'><?php echo number_format($row->Col42,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col43,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col44,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col45,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col46,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col47,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col48,0,",",".")?></td>
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
                    <td colspan="16" class="active"><strong>SECCIÓN B.1: EXÁMENES SEGÚN GRUPOS DE USUARIOS POR CONDICIÓN DE HEPATITIS B, HEPATITIS C, CHAGAS, HTLV 1 Y SIFILIS (Uso exclusivo de establecimientos con Laboratorio que procesan).</strong></td>
                </tr>
                <tr>
                    <td colspan="2" rowspan="2" style="text-align:center; vertical-align:middle"><strong>GRUPO DE USUARIOS</strong></td>
                    <td colspan="3" align="center"><strong>HEPATITIS B</strong></td>
                    <td colspan="3" align="center"><strong>HEPATITIS C</strong></td>
                    <td colspan="3" align="center"><strong>CHAGAS</strong></td>
                    <td colspan="3" align="center"><strong>HTLV1</strong></td>
                    <td colspan="2" align="center"><strong>SÍFILIS</strong></td>
                </tr>
                <tr>
                    <td align="center"><strong>Procesados</strong></td>
                    <td align="center"><strong>Reactivos</strong></td>
                    <td align="center"><strong>Confirmados</strong></td>
                    <td align="center"><strong>Procesados</strong></td>
                    <td align="center"><strong>Reactivos</strong></td>
                    <td align="center"><strong>Confirmados</strong></td>
                    <td align="center"><strong>Procesados</strong></td>
                    <td align="center"><strong>Reactivos</strong></td>
                    <td align="center"><strong>Confirmados</strong></td>
                    <td align="center"><strong>Procesados</strong></td>
                    <td align="center"><strong>Reactivos</strong></td>
                    <td align="center"><strong>Confirmados</strong></td>
                    <td align="center"><strong>Procesados</strong></td>
                    <td align="center"><strong>Reactivos</strong></td>
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
                          FROM (select c.* from 2019prestaciones c where c.codigo_prestacion in("11054300","11054400","11055100","11055110","11055120")) a
                          left join 2019rems b on (a.id_prestacion=b.prestacion_id_prestacion)
                          AND (b.Mes in ('.$mes.')) AND (b.establecimiento_id_establecimiento in ('.$estab.'))
                          group by a.codigo_prestacion, a.descripcion, a.id_prestacion
                          order by a.id_prestacion';
                $registro = DB::connection('mysql_rem')->select($query);

                $i=0;

                foreach($registro as $row ){
                    $nombre_descripcion = $row->codigo_prestacion;
                    if ($nombre_descripcion == "11054300"){
                        $nombre_descripcion = "USUARIOS";
      							}
      							if ($nombre_descripcion == "11054400"){
                        $nombre_descripcion = "ALTRUISTA NUEVO";
      							}
      							if ($nombre_descripcion == "11055100"){
                        $nombre_descripcion = "ALTRUISTA REPETIDO";
      							}
      							if ($nombre_descripcion == "11055110"){
                        $nombre_descripcion = "FAMILIAR O REPOSICIÓN";
      							}
      							if ($nombre_descripcion == "11055120"){
                        $nombre_descripcion = "DONANTES DE ÓRGANOS Y/O TEJIDOS";
                    }
                    ?>
                <tr>
                    <?php
                    if($i==0){?>
                    <td colspan="2" align='left' nowrap="nowrap"><?php echo $nombre_descripcion; ?></td>
                    <?php
                    }
                    if($i==1){?>
                    <td rowspan="3" style="text-align:center; vertical-align:middle" nowrap="nowrap">DONANTES</td>
                    <?php
                    }
                    if($i>=1 && $i<=3){?>
                    <td align='left' nowrap="nowrap"><?php echo $nombre_descripcion; ?></td>
                    <?php
                    }
                    if($i==4){?>
                    <td colspan="2" align='left' nowrap="nowrap"><?php echo $nombre_descripcion; ?></td>
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
                    <?php
                    $i++;
                }
                ?>
                </tr>
            </tbody>
        </table>
    </div>

    <br>

    <!-- SECCION B.2 -->
    <div class="col-sm tab table-responsive" id="B2">
        <table class="table table-hover table-bordered table-sm">
            <thead>
                <tr>
                    <td colspan="16" class="active"><strong>SECCIÓN B.2: EXÁMENES SEGÚN GRUPOS DE USUARIOS POR CONDICIÓN DE HEPATITIS B, HEPATITIS C, CHAGAS, HTLV 1 Y SIFILIS (Uso exclusivo de establecimientos que Compran Servicio).</strong></td>
                </tr>
                <tr>
                    <td colspan="2" rowspan="2" style="text-align:center; vertical-align:middle"><strong>GRUPO DE USUARIOS</strong></td>
                    <td colspan="3" align="center"><strong>HEPATITIS B</strong></td>
                    <td colspan="3" align="center"><strong>HEPATITIS C</strong></td>
                    <td colspan="3" align="center"><strong>CHAGAS</strong></td>
                    <td colspan="3" align="center"><strong>HTLV1</strong></td>
                    <td colspan="2" align="center"><strong>SÍFILIS</strong></td>
                </tr>
                <tr>
                    <td align="center"><strong>Procesados</strong></td>
                    <td align="center"><strong>Reactivos</strong></td>
                    <td align="center"><strong>Confirmados</strong></td>
                    <td align="center"><strong>Procesados</strong></td>
                    <td align="center"><strong>Reactivos</strong></td>
                    <td align="center"><strong>Confirmados</strong></td>
                    <td align="center"><strong>Procesados</strong></td>
                    <td align="center"><strong>Reactivos</strong></td>
                    <td align="center"><strong>Confirmados</strong></td>
                    <td align="center"><strong>Procesados</strong></td>
                    <td align="center"><strong>Reactivos</strong></td>
                    <td align="center"><strong>Confirmados</strong></td>
                    <td align="center"><strong>Procesados</strong></td>
                    <td align="center"><strong>Reactivos</strong></td>
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
                          FROM (select c.* from 2019prestaciones c where c.codigo_prestacion in("11055130","11055140","11055150","11055160","11055170")) a
                          left join 2019rems b on (a.id_prestacion=b.prestacion_id_prestacion)
                          AND (b.Mes in ('.$mes.')) AND (b.establecimiento_id_establecimiento in ('.$estab.'))
                          group by a.codigo_prestacion, a.descripcion, a.id_prestacion
                          order by a.id_prestacion';
                $registro = DB::connection('mysql_rem')->select($query);

                $i=0;

                foreach($registro as $row ){
                    $nombre_descripcion = $row->codigo_prestacion;
                    if ($nombre_descripcion == "11055130"){
                        $nombre_descripcion = "USUARIOS";
      							}
      							if ($nombre_descripcion == "11055140"){
                        $nombre_descripcion = "ALTRUISTA NUEVO";
      							}
      							if ($nombre_descripcion == "11055150"){
                        $nombre_descripcion = "ALTRUISTA REPETIDO";
      							}
      							if ($nombre_descripcion == "11055160"){
                        $nombre_descripcion = "FAMILIAR O REPOSICIÓN";
      							}
      							if ($nombre_descripcion == "11055170"){
                        $nombre_descripcion = "DONANTES DE ÓRGANOS Y/O TEJIDOS";
      							}
                    ?>
                <tr>
                    <?php
                    if($i==0){?>
                    <td colspan="2" align='left' nowrap="nowrap"><?php echo $nombre_descripcion; ?></td>
                    <?php
                    }
                    if($i==1){?>
                    <td rowspan="3" style="text-align:center; vertical-align:middle" nowrap="nowrap">DONANTES</td>
                    <?php
                    }
                    if($i>=1 && $i<=3){?>
                    <td align='left' nowrap="nowrap"><?php echo $nombre_descripcion; ?></td>
                    <?php
                    }
                    if($i==4){?>
                    <td colspan="2" align='left' nowrap="nowrap"><?php echo $nombre_descripcion; ?></td>
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
                    <?php
                    $i++;
                }
                ?>
                </tr>
            </tbody>
        </table>
    </div>

    <br>

    <!-- SECCION C.1-->
    <div class="col-sm tab table-responsive" id="C1">
        <table class="table table-hover table-bordered table-sm">
            <thead>
                <tr>
                    <td colspan="50" class="active"><strong>SECCIÓN C.1: EXÁMENES DE VIH POR GRUPOS DE USUARIOS (Uso exclusivo de establecimientos con Laboratorio que procesan).</strong></td>
                </tr>
                <tr>
                    <td colspan="2" rowspan="3" style="text-align:center; vertical-align:middle"><strong>GRUPO DE USUARIOS</strong></td>
                    <td colspan="2" rowspan="2" style="text-align:center; vertical-align:middle"><strong>TOTAL</strong></td>
                    <td colspan="32" align="center"><strong>GRUPO DE EDAD (En años)</strong></td>
                    <td colspan="4" align="center"><strong>POR SEXO (Procesados)</strong></td>
                    <td colspan="4" align="center"><strong>TRANS</strong></td>
                    <td colspan="2"rowspan="2" align="center"><strong>Pueblos originarios</strong></td>
                    <td colspan="2" rowspan="2" align="center"><strong>Migrantes</strong></td>
                    <td colspan="2" rowspan="2" align="center"><strong>14-18 años</strong></td>
                </tr>
                <tr>
                    <td colspan="2" align="center"><strong>Menor de 12 meses</strong></td>
                    <td colspan="2" align="center"><strong>12-24 meses</strong></td>
                    <td colspan="2" align="center"><strong>3 a 4 años</strong></td>
                    <td colspan="2" align="center"><strong>5 a 9 años</strong></td>
                    <td colspan="2" align="center"><strong>10 a 14 años</strong></td>
                    <td colspan="2" align="center"><strong>15 a 19 años</strong></td>
                    <td colspan="2" align="center"><strong>20 a 24 años</strong></td>
                    <td colspan="2" align="center"><strong>25 a 29 años</strong></td>
                    <td colspan="2" align="center"><strong>30 a 34 años</strong></td>
                    <td colspan="2" align="center"><strong>35 a 39 años</strong></td>
                    <td colspan="2" align="center"><strong>40 a 44 años</strong></td>
                    <td colspan="2" align="center"><strong>45 a 49 años</strong></td>
                    <td colspan="2" align="center"><strong>50 a 54 años</strong></td>
                    <td colspan="2" align="center"><strong>55 a 59 años</strong></td>
                    <td colspan="2" align="center"><strong>60 a 64 años</strong></td>
                    <td colspan="2" align="center"><strong>65 y más años</strong></td>
                    <td colspan="2" align="center"><strong>Hombres</strong></td>
                    <td colspan="2" align="center"><strong>Mujeres</strong></td>
                    <td colspan="2" align="center"><strong>Masculino</strong></td>
                    <td colspan="2" align="center"><strong>Femenino</strong></td>
                </tr>
                <tr>
                    <td align="center"><strong>Procesados</strong></td>
                    <td align="center"><strong>Confirmados positivos por ISP</strong></td>
                    <td align="center"><strong>Procesados</strong></td>
                    <td align="center"><strong>Confirmados positivos por ISP</strong></td>
                    <td align="center"><strong>Procesados</strong></td>
                    <td align="center"><strong>Confirmados positivos por ISP</strong></td>
                    <td align="center"><strong>Procesados</strong></td>
                    <td align="center"><strong>Confirmados positivos por ISP</strong></td>
                    <td align="center"><strong>Procesados</strong></td>
                    <td align="center"><strong>Confirmados positivos por ISP</strong></td>
                    <td align="center"><strong>Procesados</strong></td>
                    <td align="center"><strong>Confirmados positivos por ISP</strong></td>
                    <td align="center"><strong>Procesados</strong></td>
                    <td align="center"><strong>Confirmados positivos por ISP</strong></td>
                    <td align="center"><strong>Procesados</strong></td>
                    <td align="center"><strong>Confirmados positivos por ISP</strong></td>
                    <td align="center"><strong>Procesados</strong></td>
                    <td align="center"><strong>Confirmados positivos por ISP</strong></td>
                    <td align="center"><strong>Procesados</strong></td>
                    <td align="center"><strong>Confirmados positivos por ISP</strong></td>
                    <td align="center"><strong>Procesados</strong></td>
                    <td align="center"><strong>Confirmados positivos por ISP</strong></td>
                    <td align="center"><strong>Procesados</strong></td>
                    <td align="center"><strong>Confirmados positivos por ISP</strong></td>
                    <td align="center"><strong>Procesados</strong></td>
                    <td align="center"><strong>Confirmados positivos por ISP</strong></td>
                    <td align="center"><strong>Procesados</strong></td>
                    <td align="center"><strong>Confirmados positivos por ISP</strong></td>
                    <td align="center"><strong>Procesados</strong></td>
                    <td align="center"><strong>Confirmados positivos por ISP</strong></td>
                    <td align="center"><strong>Procesados</strong></td>
                    <td align="center"><strong>Confirmados positivos por ISP</strong></td>
                    <td align="center"><strong>Procesados</strong></td>
                    <td align="center"><strong>Confirmados positivos por ISP</strong></td>
                    <td align="center"><strong>Procesados</strong></td>
                    <td align="center"><strong>Confirmados positivos por ISP</strong></td>
                    <td align="center"><strong>Procesados</strong></td>
                    <td align="center"><strong>Confirmados positivos por ISP</strong></td>
                    <td align="center"><strong>Procesados</strong></td>
                    <td align="center"><strong>Confirmados positivos por ISP</strong></td>
                    <td align="center"><strong>Procesados</strong></td>
                    <td align="center"><strong>Confirmados positivos por ISP</strong></td>
                    <td align="center"><strong>Procesados</strong></td>
                    <td align="center"><strong>Confirmados positivos por ISP</strong></td>
                    <td align="center"><strong>Procesados</strong></td>
                    <td align="center"><strong>Confirmados positivos por ISP</strong></td>
                    <td align="center"><strong>Procesados</strong></td>
                    <td align="center"><strong>Confirmados positivos por ISP</strong></td>
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
            									,sum(ifnull(b.Col48,0)) Col48
                          FROM (select c.* from 2019prestaciones c where c.codigo_prestacion in("11052500","11052600","11052700","11052800","11052900","11053000","11054500","11054600",
                                                                                                "11053100",
                                                                                                "11055180","11055190","11053200",
                                                                                                "11050700","11053300","11053400","11053401","11053402","11053500","11053501","11053502",
                                                                                                "11053503","11053600","11055380")) a
                          left join 2019rems b on (a.id_prestacion=b.prestacion_id_prestacion)
                          AND (b.Mes in ('.$mes.')) AND (b.establecimiento_id_establecimiento in ('.$estab.'))
                          group by a.codigo_prestacion, a.descripcion, a.id_prestacion
                          order by a.id_prestacion';
                $registro = DB::connection('mysql_rem')->select($query);

                $i=0;

                foreach($registro as $row ){
                    $nombre_descripcion = $row->codigo_prestacion;
                    if ($nombre_descripcion == "11052500"){
                        $nombre_descripcion = "GESTANTES PRIMER EXAMEN";
      							}
      							if ($nombre_descripcion == "11052600"){
                        $nombre_descripcion = "GESTANTES SEGUNDO EXAMEN";
      							}
      							if ($nombre_descripcion == "11052700"){
                        $nombre_descripcion = "MUJER EN TRABAJO DE PRE PARTO O PARTO";
      							}
      							if ($nombre_descripcion == "11052800"){
                        $nombre_descripcion = "PERSONAS EN CONTROL POR COMERCIO SEXUAL";
      							}
      							if ($nombre_descripcion == "11052900"){
                        $nombre_descripcion = "PACIENTES EN DIÁLISIS";
      							}
      							if ($nombre_descripcion == "11053000"){
                        $nombre_descripcion = "POR CONSULTA ITS";
      							}
      							if ($nombre_descripcion == "11054500"){
                        $nombre_descripcion = "PERSONAS EN CONTROL DE REGULACIÓN FECUNDIDAD, GINECOLOGICO, CLIMATERIO";
      							}
      							if ($nombre_descripcion == "11054600"){
                        $nombre_descripcion = "PERSONAS CON EMP";
      							}
      							if ($nombre_descripcion == "11053100"){
                        $nombre_descripcion = "PERSONAS EN CONTROL DE SALUD SEGÚN CICLO VITAL";
      							}

      							if ($nombre_descripcion == "11055180"){
                        $nombre_descripcion = "ALTRUISTA NUEVO";
      							}
      							if ($nombre_descripcion == "11055190"){
                        $nombre_descripcion = "ALTRUISTA REPETIDO";
      							}
      							if ($nombre_descripcion == "11053200"){
                        $nombre_descripcion = "FAMILIAR O REPOSICIÓN";
      							}

      							if ($nombre_descripcion == "11050700"){
                        $nombre_descripcion = "DONANTES DE ÓRGANOS Y/O TEJIDOS";
      							}
      							if ($nombre_descripcion == "11053300"){
                        $nombre_descripcion = "PERSONA EN CONTROL POR TBC";
      							}
      							if ($nombre_descripcion == "11053400"){
                        $nombre_descripcion = "VÍCTIMA DE VIOLENCIA SEXUAL";
      							}
      							if ($nombre_descripcion == "11053401"){
                        $nombre_descripcion = "PAREJA SERODISCORDANTE";
      							}
      							if ($nombre_descripcion == "11053402"){
                        $nombre_descripcion = "PAREJA DE GESTANTE VIH POSITIVO";
      							}
      							if ($nombre_descripcion == "11053500"){
                        $nombre_descripcion = "PERSONAL DE SALUD EXPUESTO A ACCIDENTE CORTOPUNZANTE";
      							}
      							if ($nombre_descripcion == "11053501"){
                        $nombre_descripcion = "PACIENTES FUENTE DE ACCIDENTE CORTOPUNZANTE";
      							}
      							if ($nombre_descripcion == "11053502"){
                        $nombre_descripcion = "PERSONA EN CONTROL POR HEPATITIS B";
      							}
      							if ($nombre_descripcion == "11053503"){
                        $nombre_descripcion = "PERSONA EN CONTROL POR HEPATITIS C";
      							}
      							if ($nombre_descripcion == "11053600"){
                        $nombre_descripcion = "CONSULTANTES POR MORBILIDAD";
      							}
      							if ($nombre_descripcion == "11055380"){
                        $nombre_descripcion = "POR CONSULTA ESPONTÁNEA";
      							}
                    ?>
                <tr>
                    <?php
                    if($i>=0 && $i<=8){?>
                    <td colspan="2" align='left' nowrap="nowrap"><?php echo $nombre_descripcion; ?></td>
                    <?php
      							}
      							if($i==9){?>
                    <td rowspan="3" style="text-align:center; vertical-align:middle">DONANTES DE SANGRE</td>
                    <?php
      							}
      							if($i>=9 && $i<=11){?>
                    <td align='left' nowrap="nowrap"><?php echo $nombre_descripcion; ?></td>
                    <?php
      							}
      							if($i>=12){?>
                    <td colspan="2" align='left' nowrap="nowrap"><?php echo $nombre_descripcion; ?></td>
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
                    <td align='right'><?php echo number_format($row->Col48,0,",",".")?></td>
                    <?php
                    $i++;
                }
                ?>
                </tr>
            </tbody>
        </table>
    </div>

    <br>

    <!-- SECCION C.2-->
    <div class="col-sm tab table-responsive" id="C2">
        <table class="table table-hover table-bordered table-sm">
            <thead>
                <tr>
                    <td colspan="50" class="active"><strong>SECCIÓN C.2: EXÁMENES DE VIH POR GRUPOS DE USUARIOS (Uso exclusivo de establecimientos que Compran Servicio).</strong></td>
                </tr>
                <tr>
                    <td colspan="2" rowspan="3" style="text-align:center; vertical-align:middle"><strong>GRUPO DE USUARIOS</strong></td>
                    <td colspan="2" rowspan="2" style="text-align:center; vertical-align:middle"><strong>TOTAL</strong></td>
                    <td colspan="32" align="center"><strong>GRUPO DE EDAD (En años)</strong></td>
                    <td colspan="4" align="center"><strong>POR SEXO (Procesados)</strong></td>
                    <td colspan="4" align="center"><strong>TRANS</strong></td>
                    <td colspan="2"rowspan="2" align="center"><strong>Pueblos originarios</strong></td>
                    <td colspan="2" rowspan="2" align="center"><strong>Migrantes</strong></td>
                    <td colspan="2" rowspan="2" align="center"><strong>14-18 años</strong></td>
                </tr>
                <tr>
                    <td colspan="2" align="center"><strong>Menor de 12 meses</strong></td>
                    <td colspan="2" align="center"><strong>12-24 meses</strong></td>
                    <td colspan="2" align="center"><strong>3 a 4 años</strong></td>
                    <td colspan="2" align="center"><strong>5 a 9 años</strong></td>
                    <td colspan="2" align="center"><strong>10 a 14 años</strong></td>
                    <td colspan="2" align="center"><strong>15 a 19 años</strong></td>
                    <td colspan="2" align="center"><strong>20 a 24 años</strong></td>
                    <td colspan="2" align="center"><strong>25 a 29 años</strong></td>
                    <td colspan="2" align="center"><strong>30 a 34 años</strong></td>
                    <td colspan="2" align="center"><strong>35 a 39 años</strong></td>
                    <td colspan="2" align="center"><strong>40 a 44 años</strong></td>
                    <td colspan="2" align="center"><strong>45 a 49 años</strong></td>
                    <td colspan="2" align="center"><strong>50 a 54 años</strong></td>
                    <td colspan="2" align="center"><strong>55 a 59 años</strong></td>
                    <td colspan="2" align="center"><strong>60 a 64 años</strong></td>
                    <td colspan="2" align="center"><strong>65 y más años</strong></td>
                    <td colspan="2" align="center"><strong>Hombres</strong></td>
                    <td colspan="2" align="center"><strong>Mujeres</strong></td>
                    <td colspan="2" align="center"><strong>Masculino</strong></td>
                    <td colspan="2" align="center"><strong>Femenino</strong></td>
                </tr>
                <tr>
                    <td align="center"><strong>Procesados</strong></td>
                    <td align="center"><strong>Confirmados positivos por ISP</strong></td>
                    <td align="center"><strong>Procesados</strong></td>
                    <td align="center"><strong>Confirmados positivos por ISP</strong></td>
                    <td align="center"><strong>Procesados</strong></td>
                    <td align="center"><strong>Confirmados positivos por ISP</strong></td>
                    <td align="center"><strong>Procesados</strong></td>
                    <td align="center"><strong>Confirmados positivos por ISP</strong></td>
                    <td align="center"><strong>Procesados</strong></td>
                    <td align="center"><strong>Confirmados positivos por ISP</strong></td>
                    <td align="center"><strong>Procesados</strong></td>
                    <td align="center"><strong>Confirmados positivos por ISP</strong></td>
                    <td align="center"><strong>Procesados</strong></td>
                    <td align="center"><strong>Confirmados positivos por ISP</strong></td>
                    <td align="center"><strong>Procesados</strong></td>
                    <td align="center"><strong>Confirmados positivos por ISP</strong></td>
                    <td align="center"><strong>Procesados</strong></td>
                    <td align="center"><strong>Confirmados positivos por ISP</strong></td>
                    <td align="center"><strong>Procesados</strong></td>
                    <td align="center"><strong>Confirmados positivos por ISP</strong></td>
                    <td align="center"><strong>Procesados</strong></td>
                    <td align="center"><strong>Confirmados positivos por ISP</strong></td>
                    <td align="center"><strong>Procesados</strong></td>
                    <td align="center"><strong>Confirmados positivos por ISP</strong></td>
                    <td align="center"><strong>Procesados</strong></td>
                    <td align="center"><strong>Confirmados positivos por ISP</strong></td>
                    <td align="center"><strong>Procesados</strong></td>
                    <td align="center"><strong>Confirmados positivos por ISP</strong></td>
                    <td align="center"><strong>Procesados</strong></td>
                    <td align="center"><strong>Confirmados positivos por ISP</strong></td>
                    <td align="center"><strong>Procesados</strong></td>
                    <td align="center"><strong>Confirmados positivos por ISP</strong></td>
                    <td align="center"><strong>Procesados</strong></td>
                    <td align="center"><strong>Confirmados positivos por ISP</strong></td>
                    <td align="center"><strong>Procesados</strong></td>
                    <td align="center"><strong>Confirmados positivos por ISP</strong></td>
                    <td align="center"><strong>Procesados</strong></td>
                    <td align="center"><strong>Confirmados positivos por ISP</strong></td>
                    <td align="center"><strong>Procesados</strong></td>
                    <td align="center"><strong>Confirmados positivos por ISP</strong></td>
                    <td align="center"><strong>Procesados</strong></td>
                    <td align="center"><strong>Confirmados positivos por ISP</strong></td>
                    <td align="center"><strong>Procesados</strong></td>
                    <td align="center"><strong>Confirmados positivos por ISP</strong></td>
                    <td align="center"><strong>Procesados</strong></td>
                    <td align="center"><strong>Confirmados positivos por ISP</strong></td>
                    <td align="center"><strong>Procesados</strong></td>
                    <td align="center"><strong>Confirmados positivos por ISP</strong></td>
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
            									,sum(ifnull(b.Col48,0)) Col48
                          FROM (select c.* from 2019prestaciones c where c.codigo_prestacion in("11055200","11055210","11055220","11055230","11055240","11055250","11055260","11055270",
                                                                                                "11055280",
                                                                                                "11055290","11055300","11055310",
                                                                                                "11055320","11055330","11055340","11055341","11055342","11055350","11055351","11055352",
                                                                                                "11055353","11055360","11055370")) a
                          left join 2019rems b on (a.id_prestacion=b.prestacion_id_prestacion)
                          AND (b.Mes in ('.$mes.')) AND (b.establecimiento_id_establecimiento in ('.$estab.'))
                          group by a.codigo_prestacion, a.descripcion, a.id_prestacion
                          order by a.id_prestacion';
                $registro = DB::connection('mysql_rem')->select($query);

                $i=0;

                foreach($registro as $row ){
                    $nombre_descripcion = $row->codigo_prestacion;
                    if ($nombre_descripcion == "11055200"){
                        $nombre_descripcion = "GESTANTES PRIMER EXAMEN";
      							}
      							if ($nombre_descripcion == "11055210"){
                        $nombre_descripcion = "GESTANTES SEGUNDO EXAMEN";
      							}
      							if ($nombre_descripcion == "11055220"){
                        $nombre_descripcion = "MUJER EN TRABAJO DE PRE PARTO O PARTO";
      							}
      							if ($nombre_descripcion == "11055230"){
                        $nombre_descripcion = "PERSONAS EN CONTROL POR COMERCIO SEXUAL";
      							}
      							if ($nombre_descripcion == "11055240"){
                        $nombre_descripcion = "PACIENTES EN DIÁLISIS";
      							}
      							if ($nombre_descripcion == "11055250"){
                        $nombre_descripcion = "POR CONSULTA ITS";
      							}
      							if ($nombre_descripcion == "11055260"){
                        $nombre_descripcion = "PERSONAS EN CONTROL DE REGULACIÓN FECUNDIDAD, GINECOLOGICO, CLIMATERIO";
      							}
      							if ($nombre_descripcion == "11055270"){
                        $nombre_descripcion = "PERSONAS CON EMP";
      							}
      							if ($nombre_descripcion == "11055280"){
                        $nombre_descripcion = "PERSONAS EN CONTROL DE SALUD SEGÚN CICLO VITAL";
      							}

      							if ($nombre_descripcion == "11055290"){
                        $nombre_descripcion = "ALTRUISTA NUEVO";
      							}
      							if ($nombre_descripcion == "11055300"){
                        $nombre_descripcion = "ALTRUISTA REPETIDO";
      							}
      							if ($nombre_descripcion == "11055310"){
                        $nombre_descripcion = "FAMILIAR O REPOSICIÓN";
      							}

      							if ($nombre_descripcion == "11055320"){
                        $nombre_descripcion = "DONANTES DE ÓRGANOS Y/O TEJIDOS";
      							}
      							if ($nombre_descripcion == "11055330"){
                        $nombre_descripcion = "PERSONA EN CONTROL POR TBC";
      							}
      							if ($nombre_descripcion == "11055340"){
                        $nombre_descripcion = "VÍCTIMA DE VIOLENCIA SEXUAL";
      							}
      							if ($nombre_descripcion == "11055341"){
                        $nombre_descripcion = "PAREJA SERODISCORDANTE";
      							}
      							if ($nombre_descripcion == "11055342"){
                        $nombre_descripcion = "PAREJA DE GESTANTE VIH POSITIVO";
      							}
      							if ($nombre_descripcion == "11055350"){
                        $nombre_descripcion = "PERSONAL DE SALUD EXPUESTO A ACCIDENTE CORTOPUNZANTE";
      							}
      							if ($nombre_descripcion == "11055351"){
                        $nombre_descripcion = "PACIENTES FUENTE DE ACCIDENTE CORTOPUNZANTE";
      							}
      							if ($nombre_descripcion == "11055352"){
                        $nombre_descripcion = "PERSONA EN CONTROL POR HEPATITIS B";
      							}
      							if ($nombre_descripcion == "11055353"){
                        $nombre_descripcion = "PERSONA EN CONTROL POR HEPATITIS C";
      							}
      							if ($nombre_descripcion == "11055360"){
                        $nombre_descripcion = "CONSULTANTES POR MORBILIDAD";
      							}
      							if ($nombre_descripcion == "11055370"){
                        $nombre_descripcion = "POR CONSULTA ESPONTÁNEA";
      							}
                    ?>
                <tr>
                    <?php
                    if($i>=0 && $i<=8){?>
                    <td colspan="2" align='left' nowrap="nowrap"><?php echo $nombre_descripcion; ?></td>
                    <?php
      							}
      							if($i==9){?>
                    <td rowspan="3" style="text-align:center; vertical-align:middle">DONANTES DE SANGRE</td>
                    <?php
      							}
      							if($i>=9 && $i<=11){?>
                    <td align='left' nowrap="nowrap"><?php echo $nombre_descripcion; ?></td>
                    <?php
      							}
      							if($i>=12){?>
                    <td colspan="2" align='left' nowrap="nowrap"><?php echo $nombre_descripcion; ?></td>
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
                    <td align='right'><?php echo number_format($row->Col48,0,",",".")?></td>
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
    <!-- SECCION D-->
    <div class="col-sm tab table-responsive" id="D">
        <table class="table table-hover table-bordered table-sm">
            <thead>
                <tr>
                    <td colspan="4" class="active"><strong>SECCIÓN D: DETECCIÓN ENFERMEDAD DE CHAGAS EN GESTANTES Y RECIÉN NACIDOS SEGÚN RESULTADO DE EXÁMENES DE LABORATORIO.</strong></td>
                </tr>
                <tr>
                    <td align="center"><strong>TIPO DE EXÁMENES</strong></td>
                    <td align="center"><strong>EXÁMENES DE TAMIZAJE INFECCIÓN POR T. cruzi REALIZADOS</strong></td>
                    <td align="center"><strong>EXÁMENES TAMIZAJE DE INFECCIÓN POR T. cruzi CON RESULTADO REACTIVO</strong></td>
                    <td align="center"><strong>EXÁMENES DE CONFIRMACIÓN DE INFECCIÓN POR T. cruzi CON RESULTADO POSITIVO</strong></td>
                </tr>
            </thead>
            <tbody>
                <?php
                $query = 'SELECT a.codigo_prestacion,a.descripcion
                              ,sum(ifnull(b.Col01,0)) Col01
                              ,sum(ifnull(b.Col02,0)) Col02
                              ,sum(ifnull(b.Col03,0)) Col03
                          FROM (select c.* from 2019prestaciones c where c.codigo_prestacion in("11056000","11056100","11056200","11056300")) a
                          left join 2019rems b on (a.id_prestacion=b.prestacion_id_prestacion)
                          AND (b.Mes in ('.$mes.')) AND (b.establecimiento_id_establecimiento in ('.$estab.'))
                          group by a.codigo_prestacion, a.descripcion, a.id_prestacion
                          order by a.id_prestacion';
                $registro = DB::connection('mysql_rem')->select($query);

                $i=0;

                foreach($registro as $row ){
                    $nombre_descripcion = $row->codigo_prestacion;
                    if ($nombre_descripcion == "11056000"){
                        $nombre_descripcion = "GESTANTES QUE INGRESAN A CONTROL PRENATAL";
      							}
      							if ($nombre_descripcion == "11056100"){
                        $nombre_descripcion = "MUJERES EN TRABAJO DE PARTO O ABORTO SIN TAMIZAJE PREVIO CUALQUIERA SEA LA CAUSA";
      							}
      							if ($nombre_descripcion == "11056200"){
                        $nombre_descripcion = "RECIÉN NACIDOS, HIJOS DE MADRE CON ENFERMEDAD DE CHAGAS";
      							}
      							if ($nombre_descripcion == "11056300"){
                        $nombre_descripcion = "LACTANTES, HIJOS DE MADRE CON ENFERMEDAD DE CHAGAS";
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

    <!-- SECCION E-->
    <div class="col-sm tab table-responsive" id="E">
        <table class="table table-hover table-bordered table-sm">
            <thead>
                <tr>
                    <td colspan="43" class="active"><strong>SECCIÓN E: EXÁMENES DE GONORREA POR GRUPOS DE USUARIOS.</strong></td>
                </tr>
                <tr>
                    <td rowspan="3" style="text-align:center; vertical-align:middle"><strong>GRUPO DE USUARIOS</strong></td>
                    <td colspan="2" rowspan="2" style="text-align:center; vertical-align:middle"><strong>TOTAL</strong></td>
                    <td colspan="34" align="center"><strong>GRUPO DE EDAD (En años)</strong></td>
                    <td colspan="2" align="center"><strong>POR SEXO (Procesados)</strong></td>
                    <td colspan="2" align="center"><strong>TRANS</strong></td>
                    <td rowspan="3" align="center"><strong>Pueblos Originarios</strong></td>
                    <td rowspan="3" align="center"><strong>Migrantes</strong></td>
                </tr>
                <tr>
                    <td colspan="2" align="center"><strong>0 a 4 años</strong></td>
                    <td colspan="2" align="center"><strong>5 a 9 años</strong></td>
                    <td colspan="2" align="center"><strong>10 a 14 años</strong></td>
                    <td colspan="2" align="center"><strong>15 a 19 años</strong></td>
                    <td colspan="2" align="center"><strong>20 a 24 años</strong></td>
                    <td colspan="2" align="center"><strong>25 a 29 años</strong></td>
                    <td colspan="2" align="center"><strong>30 a 34 años</strong></td>
                    <td colspan="2" align="center"><strong>35 a 39 años</strong></td>
                    <td colspan="2" align="center"><strong>40 a 44 años</strong></td>
                    <td colspan="2" align="center"><strong>45 a 49 años</strong></td>
                    <td colspan="2" align="center"><strong>50 a 54 años</strong></td>
                    <td colspan="2" align="center"><strong>55 a 59 años</strong></td>
                    <td colspan="2" align="center"><strong>60 a 64 años</strong></td>
                    <td colspan="2" align="center"><strong>65 a 69 años</strong></td>
                    <td colspan="2" align="center"><strong>70 a 74 años</strong></td>
                    <td colspan="2" align="center"><strong>75 a 79 años</strong></td>
                    <td colspan="2" align="center"><strong>80 y más años</strong></td>
                    <td rowspan="2" align="center"><strong>Hombres</strong></td>
                    <td rowspan="2" align="center"><strong>Mujeres</strong></td>
                    <td rowspan="2" align="center"><strong>Masculino</strong></td>
                    <td rowspan="2" align="center"><strong>Femenino</strong></td>
                </tr>
                <tr>
                    <td align="center"><strong>Procesados</strong></td>
                    <td align="center"><strong>Reactivos</strong></td>
                    <td align="center"><strong>Procesados</strong></td>
                    <td align="center"><strong>Reactivos</strong></td>
                    <td align="center"><strong>Procesados</strong></td>
                    <td align="center"><strong>Reactivos</strong></td>
                    <td align="center"><strong>Procesados</strong></td>
                    <td align="center"><strong>Reactivos</strong></td>
                    <td align="center"><strong>Procesados</strong></td>
                    <td align="center"><strong>Reactivos</strong></td>
                    <td align="center"><strong>Procesados</strong></td>
                    <td align="center"><strong>Reactivos</strong></td>
                    <td align="center"><strong>Procesados</strong></td>
                    <td align="center"><strong>Reactivos</strong></td>
                    <td align="center"><strong>Procesados</strong></td>
                    <td align="center"><strong>Reactivos</strong></td>
                    <td align="center"><strong>Procesados</strong></td>
                    <td align="center"><strong>Reactivos</strong></td>
                    <td align="center"><strong>Procesados</strong></td>
                    <td align="center"><strong>Reactivos</strong></td>
                    <td align="center"><strong>Procesados</strong></td>
                    <td align="center"><strong>Reactivos</strong></td>
                    <td align="center"><strong>Procesados</strong></td>
                    <td align="center"><strong>Reactivos</strong></td>
                    <td align="center"><strong>Procesados</strong></td>
                    <td align="center"><strong>Reactivos</strong></td>
                    <td align="center"><strong>Procesados</strong></td>
                    <td align="center"><strong>Reactivos</strong></td>
                    <td align="center"><strong>Procesados</strong></td>
                    <td align="center"><strong>Reactivos</strong></td>
                    <td align="center"><strong>Procesados</strong></td>
                    <td align="center"><strong>Reactivos</strong></td>
                    <td align="center"><strong>Procesados</strong></td>
                    <td align="center"><strong>Reactivos</strong></td>
                    <td align="center"><strong>Procesados</strong></td>
                    <td align="center"><strong>Reactivos</strong></td>
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
                          FROM (select c.* from 2019prestaciones c where c.codigo_prestacion in("11056472","11056473","11056474","11056475","11056476","11056477","11056478")) a
                          left join 2019rems b on (a.id_prestacion=b.prestacion_id_prestacion)
                          AND (b.Mes in ('.$mes.')) AND (b.establecimiento_id_establecimiento in ('.$estab.'))
                          group by a.codigo_prestacion, a.descripcion, a.id_prestacion
                          order by a.id_prestacion';
                $registro = DB::connection('mysql_rem')->select($query);

                $i=0;

                foreach($registro as $row ){
                    $nombre_descripcion = $row->codigo_prestacion;
                    if ($nombre_descripcion == "11056472"){
                        $nombre_descripcion = "GESTANTES";
      							}
      							if ($nombre_descripcion == "11056473"){
                        $nombre_descripcion = "COMERCIO SEXUAL";
      							}
      							if ($nombre_descripcion == "11056474"){
                        $nombre_descripcion = "PERSONAS VIH (+)";
      							}
      							if ($nombre_descripcion == "11056475"){
                        $nombre_descripcion = "CONSULTANTE ITS AMBULATORIO (nivel1º y 2º)";
      							}
      							if ($nombre_descripcion == "11056476"){
                        $nombre_descripcion = "CONSULTANTE ITS HOSPITALARIO (nivel 3º y urgencia)";
      							}
      							if ($nombre_descripcion == "11056477"){
                        $nombre_descripcion = "VICTIMA DE VIOLENCIA SEXUAL";
      							}
      							if ($nombre_descripcion == "11056478"){
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

    <!-- SECCION F-->
    <div class="col-sm tab table-responsive" id="F">
        <table class="table table-hover table-bordered table-sm">
            <thead>
                <tr>
                    <td colspan="43" class="active"><strong>SECCIÓN F: EXÁMENES DE CHLAMYIDIA TRACHOMATIS POR GRUPOS DE USUARIOS .</strong></td>
                </tr>
                <tr>
                    <td rowspan="3" style="text-align:center; vertical-align:middle"><strong>GRUPO DE USUARIOS</strong></td>
                    <td colspan="2" rowspan="2" style="text-align:center; vertical-align:middle"><strong>TOTAL</strong></td>
                    <td colspan="34" align="center"><strong>GRUPO DE EDAD (En años)</strong></td>
                    <td colspan="2" align="center"><strong>POR SEXO (Procesados)</strong></td>
                    <td colspan="2" align="center"><strong>TRANS</strong></td>
                    <td rowspan="3" align="center"><strong>Pueblos Originarios</strong></td>
                    <td rowspan="3" align="center"><strong>Migrantes</strong></td>
                </tr>
                <tr>
                    <td colspan="2" align="center"><strong>0 a 4 años</strong></td>
                    <td colspan="2" align="center"><strong>5 a 9 años</strong></td>
                    <td colspan="2" align="center"><strong>10 a 14 años</strong></td>
                    <td colspan="2" align="center"><strong>15 a 19 años</strong></td>
                    <td colspan="2" align="center"><strong>20 a 24 años</strong></td>
                    <td colspan="2" align="center"><strong>25 a 29 años</strong></td>
                    <td colspan="2" align="center"><strong>30 a 34 años</strong></td>
                    <td colspan="2" align="center"><strong>35 a 39 años</strong></td>
                    <td colspan="2" align="center"><strong>40 a 44 años</strong></td>
                    <td colspan="2" align="center"><strong>45 a 49 años</strong></td>
                    <td colspan="2" align="center"><strong>50 a 54 años</strong></td>
                    <td colspan="2" align="center"><strong>55 a 59 años</strong></td>
                    <td colspan="2" align="center"><strong>60 a 64 años</strong></td>
                    <td colspan="2" align="center"><strong>65 a 69 años</strong></td>
                    <td colspan="2" align="center"><strong>70 a 74 años</strong></td>
                    <td colspan="2" align="center"><strong>75 a 79 años</strong></td>
                    <td colspan="2" align="center"><strong>80 y más años</strong></td>
                    <td rowspan="2" align="center"><strong>Hombres</strong></td>
                    <td rowspan="2" align="center"><strong>Mujeres</strong></td>
                    <td rowspan="2" align="center"><strong>Masculino</strong></td>
                    <td rowspan="2" align="center"><strong>Femenino</strong></td>
                </tr>
                <tr>
                    <td align="center"><strong>Procesados</strong></td>
                    <td align="center"><strong>Reactivos</strong></td>
                    <td align="center"><strong>Procesados</strong></td>
                    <td align="center"><strong>Reactivos</strong></td>
                    <td align="center"><strong>Procesados</strong></td>
                    <td align="center"><strong>Reactivos</strong></td>
                    <td align="center"><strong>Procesados</strong></td>
                    <td align="center"><strong>Reactivos</strong></td>
                    <td align="center"><strong>Procesados</strong></td>
                    <td align="center"><strong>Reactivos</strong></td>
                    <td align="center"><strong>Procesados</strong></td>
                    <td align="center"><strong>Reactivos</strong></td>
                    <td align="center"><strong>Procesados</strong></td>
                    <td align="center"><strong>Reactivos</strong></td>
                    <td align="center"><strong>Procesados</strong></td>
                    <td align="center"><strong>Reactivos</strong></td>
                    <td align="center"><strong>Procesados</strong></td>
                    <td align="center"><strong>Reactivos</strong></td>
                    <td align="center"><strong>Procesados</strong></td>
                    <td align="center"><strong>Reactivos</strong></td>
                    <td align="center"><strong>Procesados</strong></td>
                    <td align="center"><strong>Reactivos</strong></td>
                    <td align="center"><strong>Procesados</strong></td>
                    <td align="center"><strong>Reactivos</strong></td>
                    <td align="center"><strong>Procesados</strong></td>
                    <td align="center"><strong>Reactivos</strong></td>
                    <td align="center"><strong>Procesados</strong></td>
                    <td align="center"><strong>Reactivos</strong></td>
                    <td align="center"><strong>Procesados</strong></td>
                    <td align="center"><strong>Reactivos</strong></td>
                    <td align="center"><strong>Procesados</strong></td>
                    <td align="center"><strong>Reactivos</strong></td>
                    <td align="center"><strong>Procesados</strong></td>
                    <td align="center"><strong>Reactivos</strong></td>
                    <td align="center"><strong>Procesados</strong></td>
                    <td align="center"><strong>Reactivos</strong></td>
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
                          FROM (select c.* from 2019prestaciones c where c.codigo_prestacion in("11056479","11056480","11056481","11056482","11056483","11056484","11056485")) a
                          left join 2019rems b on (a.id_prestacion=b.prestacion_id_prestacion)
                          AND (b.Mes in ('.$mes.')) AND (b.establecimiento_id_establecimiento in ('.$estab.'))
                          group by a.codigo_prestacion, a.descripcion, a.id_prestacion
                          order by a.id_prestacion';
                $registro = DB::connection('mysql_rem')->select($query);

                $i=0;

                foreach($registro as $row ){
                    $nombre_descripcion = $row->codigo_prestacion;
                    if ($nombre_descripcion == "11056479"){
                        $nombre_descripcion = "GESTANTES";
      							}
      							if ($nombre_descripcion == "11056480"){
                        $nombre_descripcion = "COMERCIO SEXUAL";
      							}
      							if ($nombre_descripcion == "11056481"){
                        $nombre_descripcion = "PERSONAS VIH (+)";
      							}
      							if ($nombre_descripcion == "11056482"){
                        $nombre_descripcion = "CONSULTANTE ITS AMBULATORIO (nivel1º y 2º)";
      							}
      							if ($nombre_descripcion == "11056483"){
                        $nombre_descripcion = "CONSULTANTE ITS HOSPITALARIO (nivel 3º y urgencia)";
      							}
      							if ($nombre_descripcion == "11056484"){
                        $nombre_descripcion = "VICTIMA DE VIOLENCIA SEXUAL";
      							}
      							if ($nombre_descripcion == "11056485"){
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

    <!-- SECCION G-->
    <div class="col-sm tab table-responsive" id="G">
        <table class="table table-hover table-bordered table-sm">
            <thead>
                <tr>
                    <td colspan="50" class="active"><strong>SECCIÓN G: EXÁMENES DE VIH POR TECNICA VISUAL/RAPIDA Y GRUPOS DE USUARIOS (Uso exclusivo de establecimientos NO LABORATORIOS).</strong></td>
                </tr>
                <tr>
                    <td colspan="2" rowspan="3" style="text-align:center; vertical-align:middle"><strong>GRUPOS DE USUARIOS POR INSTANCIA</strong></td>
                    <td colspan="2" rowspan="2" style="text-align:center; vertical-align:middle"><strong>TOTAL</strong></td>
                    <td colspan="32" align="center"><strong>GRUPO DE EDAD (En años)</strong></td>
                    <td colspan="4" align="center"><strong>POR SEXO (Procesados)</strong></td>
                    <td colspan="4" align="center"><strong>TRANS</strong></td>
                    <td colspan="2"rowspan="2" align="center"><strong>Pueblos originarios</strong></td>
                    <td colspan="2" rowspan="2" align="center"><strong>Migrantes</strong></td>
                    <td colspan="2" rowspan="2" align="center"><strong>14-18 años</strong></td>
                </tr>
                <tr>
                    <td colspan="2" align="center"><strong>Menor de 12 meses</strong></td>
                    <td colspan="2" align="center"><strong>12-24 meses</strong></td>
                    <td colspan="2" align="center"><strong>3 a 4 años</strong></td>
                    <td colspan="2" align="center"><strong>5 a 9 años</strong></td>
                    <td colspan="2" align="center"><strong>10 a 14 años</strong></td>
                    <td colspan="2" align="center"><strong>15 a 19 años</strong></td>
                    <td colspan="2" align="center"><strong>20 a 24 años</strong></td>
                    <td colspan="2" align="center"><strong>25 a 29 años</strong></td>
                    <td colspan="2" align="center"><strong>30 a 34 años</strong></td>
                    <td colspan="2" align="center"><strong>35 a 39 años</strong></td>
                    <td colspan="2" align="center"><strong>40 a 44 años</strong></td>
                    <td colspan="2" align="center"><strong>45 a 49 años</strong></td>
                    <td colspan="2" align="center"><strong>50 a 54 años</strong></td>
                    <td colspan="2" align="center"><strong>55 a 59 años</strong></td>
                    <td colspan="2" align="center"><strong>60 a 64 años</strong></td>
                    <td colspan="2" align="center"><strong>65 y más años</strong></td>
                    <td colspan="2" align="center"><strong>Hombres</strong></td>
                    <td colspan="2" align="center"><strong>Mujeres</strong></td>
                    <td colspan="2" align="center"><strong>Masculino</strong></td>
                    <td colspan="2" align="center"><strong>Femenino</strong></td>
                </tr>
                <tr>
                    <td align="center"><strong>Procesados</strong></td>
                    <td align="center"><strong>Confirmados positivos por ISP</strong></td>
                    <td align="center"><strong>Procesados</strong></td>
                    <td align="center"><strong>Confirmados positivos por ISP</strong></td>
                    <td align="center"><strong>Procesados</strong></td>
                    <td align="center"><strong>Confirmados positivos por ISP</strong></td>
                    <td align="center"><strong>Procesados</strong></td>
                    <td align="center"><strong>Confirmados positivos por ISP</strong></td>
                    <td align="center"><strong>Procesados</strong></td>
                    <td align="center"><strong>Confirmados positivos por ISP</strong></td>
                    <td align="center"><strong>Procesados</strong></td>
                    <td align="center"><strong>Confirmados positivos por ISP</strong></td>
                    <td align="center"><strong>Procesados</strong></td>
                    <td align="center"><strong>Confirmados positivos por ISP</strong></td>
                    <td align="center"><strong>Procesados</strong></td>
                    <td align="center"><strong>Confirmados positivos por ISP</strong></td>
                    <td align="center"><strong>Procesados</strong></td>
                    <td align="center"><strong>Confirmados positivos por ISP</strong></td>
                    <td align="center"><strong>Procesados</strong></td>
                    <td align="center"><strong>Confirmados positivos por ISP</strong></td>
                    <td align="center"><strong>Procesados</strong></td>
                    <td align="center"><strong>Confirmados positivos por ISP</strong></td>
                    <td align="center"><strong>Procesados</strong></td>
                    <td align="center"><strong>Confirmados positivos por ISP</strong></td>
                    <td align="center"><strong>Procesados</strong></td>
                    <td align="center"><strong>Confirmados positivos por ISP</strong></td>
                    <td align="center"><strong>Procesados</strong></td>
                    <td align="center"><strong>Confirmados positivos por ISP</strong></td>
                    <td align="center"><strong>Procesados</strong></td>
                    <td align="center"><strong>Confirmados positivos por ISP</strong></td>
                    <td align="center"><strong>Procesados</strong></td>
                    <td align="center"><strong>Confirmados positivos por ISP</strong></td>
                    <td align="center"><strong>Procesados</strong></td>
                    <td align="center"><strong>Confirmados positivos por ISP</strong></td>
                    <td align="center"><strong>Procesados</strong></td>
                    <td align="center"><strong>Confirmados positivos por ISP</strong></td>
                    <td align="center"><strong>Procesados</strong></td>
                    <td align="center"><strong>Confirmados positivos por ISP</strong></td>
                    <td align="center"><strong>Procesados</strong></td>
                    <td align="center"><strong>Confirmados positivos por ISP</strong></td>
                    <td align="center"><strong>Procesados</strong></td>
                    <td align="center"><strong>Confirmados positivos por ISP</strong></td>
                    <td align="center"><strong>Procesados</strong></td>
                    <td align="center"><strong>Confirmados positivos por ISP</strong></td>
                    <td align="center"><strong>Procesados</strong></td>
                    <td align="center"><strong>Confirmados positivos por ISP</strong></td>
                    <td align="center"><strong>Procesados</strong></td>
                    <td align="center"><strong>Confirmados positivos por ISP</strong></td>
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
            									,sum(ifnull(b.Col48,0)) Col48
                          FROM (select c.* from 2019prestaciones c where c.codigo_prestacion in("11057100","11057101","11057102","11057103","11057104","11057105","11057106","11057107",
                                                                                                "11057108","11057109","11057110","11057111","11057112","11057113","11057114","11057115",
                                                                                                "11057116","11057117","11057118",
                                                                                                "11057119","11057120","11057121","11057122")) a
                          left join 2019rems b on (a.id_prestacion=b.prestacion_id_prestacion)
                          AND (b.Mes in ('.$mes.')) AND (b.establecimiento_id_establecimiento in ('.$estab.'))
                          group by a.codigo_prestacion, a.descripcion, a.id_prestacion
                          order by a.id_prestacion';
                $registro = DB::connection('mysql_rem')->select($query);

                $i=0;

                foreach($registro as $row ){
                    $nombre_descripcion = $row->codigo_prestacion;
                    if ($nombre_descripcion == "11057100"){
                        $nombre_descripcion = "GESTANTES PRIMER EXAMEN";
      							}
                    if ($nombre_descripcion == "11057101"){
                        $nombre_descripcion = "GESTANTES SEGUNDO EXAMEN";
      							}
                    if ($nombre_descripcion == "11057102"){
                        $nombre_descripcion = "MUJER EN TRABAJO DE PRE PARTO O PARTO";
      							}
                    if ($nombre_descripcion == "11057103"){
                        $nombre_descripcion = "PERSONAS EN CONTROL POR COMERCIO SEXUAL";
      							}
                    if ($nombre_descripcion == "11057104"){
                        $nombre_descripcion = "POR CONSULTA ITS";
      							}
                    if ($nombre_descripcion == "11057105"){
                        $nombre_descripcion = "PERSONAS EN CONTROL DE REGULACIÓN FECUNDIDAD, GINECOLOGICO, CLIMATERIO";
      							}
                    if ($nombre_descripcion == "11057106"){
                        $nombre_descripcion = "PERSONAS CON EMP";
      							}
                    if ($nombre_descripcion == "11057107"){
                        $nombre_descripcion = "PERSONAS EN CONTROL DE SALUD SEGÚN CICLO VITAL";
      							}
                    if ($nombre_descripcion == "11057108"){
                        $nombre_descripcion = "DONANTES DE ÓRGANOS Y/O TEJIDOS";
      							}
                    if ($nombre_descripcion == "11057109"){
                        $nombre_descripcion = "PERSONA EN CONTROL POR TBC";
      							}
                    if ($nombre_descripcion == "11057110"){
                        $nombre_descripcion = "VÍCTIMA DE VIOLENCIA SEXUAL";
      							}
                    if ($nombre_descripcion == "11057111"){
                        $nombre_descripcion = "PAREJA SERODISCORDANTE";
      							}
                    if ($nombre_descripcion == "11057112"){
                        $nombre_descripcion = "PAREJA DE GESTANTE VIH POSITIVO";
      							}
                    if ($nombre_descripcion == "11057113"){
                        $nombre_descripcion = "PERSONAL DE SALUD EXPUESTO A ACCIDENTE CORTOPUNZANTE";
      							}
                    if ($nombre_descripcion == "11057114"){
                        $nombre_descripcion = "PACIENTES FUENTE DE ACCIDENTE CORTOPUNZANTE";
      							}
                    if ($nombre_descripcion == "11057115"){
                        $nombre_descripcion = "PERSONA EN CONTROL POR HEPATITIS B";
      							}
                    if ($nombre_descripcion == "11057116"){
                        $nombre_descripcion = "PERSONA EN CONTROL POR HEPATITIS C";
      							}
                    if ($nombre_descripcion == "11057117"){
                        $nombre_descripcion = "CONSULTANTES POR MORBILIDAD";
      							}
                    if ($nombre_descripcion == "11057118"){
                        $nombre_descripcion = "POR CONSULTA ESPONTÁNEA";
      							}

                    if ($nombre_descripcion == "11057119"){
                        $nombre_descripcion = "CENTROS PENITENCIARIOS";
      							}
                    if ($nombre_descripcion == "11057120"){
                        $nombre_descripcion = "CENTROS SENAME";
      							}
                    if ($nombre_descripcion == "11057121"){
                        $nombre_descripcion = "CENTROS EDUCACIONALES";
      							}
                    if ($nombre_descripcion == "11057122"){
                        $nombre_descripcion = "OTROS";
      							}
                    ?>
                <tr>
                    <?php
                    if($i==0){?>
                    <td rowspan="19" style="text-align:center; vertical-align:middle">INTERIOR ESTABLECIMIENTO SALUD (INTRAMURO)</td>
                    <?php
                    }
                    if($i==19){?>
                    <td rowspan="4" style="text-align:center; vertical-align:middle">EXTERIOR ESTABLECIMIENTO DE SALUD (EXTRAMURO)</td>
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
                    <td align='right'><?php echo number_format($row->Col47,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col48,0,",",".")?></td>
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
