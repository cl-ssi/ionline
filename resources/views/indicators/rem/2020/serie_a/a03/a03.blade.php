@extends('layouts.app')

@section('title', 'Resumen Estadistico Mensual')

@section('content')

<?php

use Illuminate\Support\Facades\DB;

?>

@include('indicators.rem.partials.nav')

<h3>REM-A03. APLICACIÓN Y RESULTADOS DE ESCALAS DE EVALUACIÓN.</h3>

<br>

@include('indicators.rem.2020.serie_a.search')

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
            <optgroup label="SECCION A: APLICACIÓN DE INSTRUMENTO Y RESULTADO EN EL NIÑO (A)">
                <option value="A1">A.1: APLICACIÓN Y RESULTADOS DE PAUTA BREVE.</option>
                <option value="A2">A.2: RESULTADOS DE LA APLICACIÓN DE ESCALA DE EVALUACIÓN DEL DESARROLLO PSICOMOTOR.</option>
                <option value="A3">A.3: NIÑOS Y NIÑAS CON REZAGO, DÉFICIT U OTRA VULNERABILIDAD DERIVADOS A ALGUNA MODALIDAD DE ESTIMULACIÓN EN LA PRIMERA EVALUACIÓN.</option>
                <option value="A4">A.4: RESULTADOS DE LA APLICACIÓN DE PROTOCOLO NEUROSENSORIAL.</option>
                <option value="A5">A.5:  LACTANCIA MATERNA EN MENORES CONTROLADOS.</option>
            </optgroup>
            <optgroup label="SECCION B: EVALUACIÓN, APLICACIÓN Y RESULTADOS DE ESCALAS EN  LA MUJER">
                <option value="B1">B.1: EVALUACIÓN DEL ESTADO NUTRICIONAL A MUJERES CONTROLADAS AL OCTAVO MES POST.</option>
                <option value="B2">B.2: APLICACIÓN DE ESCALA SEGÚN EVALUACION DE RIESGO PSICOSOCIAL ABREVIADA A GESTANTES.</option>
                <option value="B3">B.3: APLICACIÓN DE ESCALA DE EDIMBURGO A GESTANTES Y MUJERES POST PARTO.</option>
            </optgroup>
                <option value="C">C: RESULTADOS DE LA EVALUACIÓN DEL ESTADO NUTRICIONAL DEL ADOLESCENTE CON CONTROL.</option>
            <optgroup label="SECCIÓN D: OTRAS EVALUACIONES, APLICACIONES Y RESULTADOS DE ESCALAS EN TODAS LAS EDADES">
                <option value="D1">D.1: APLICACIÓN DE TAMIZAJE PARA EVALUAR EL NIVEL DE RIESGO DE CONSUMO DE  ALCOHOL, TABACO Y OTRAS DROGAS.</option>
                <option value="D2">D.2: RESULTADOS DE LA APLICACIÓN DE INSTRUMENTO DE VALORACIÓN DE DESEMPEÑO EN COMUNIDAD (IVADEC-CIF).</option>
                <option value="D3">D.3: APLICACIÓN Y RESULTADO DE PAUTA DE EVALUACIÓN Y SALUD MENTAL.</option>
                <option value="D4">D.4: RESULTADO DE APLICACIÓN DE CONDICIÓN DE FUNCIONALIDAD AL EGRESO PROGRAMA "MÁS ADULTOS MAYORES AUTOVALENTES".</option>
                <option value="D5">D.5: VARIACION  DE RESULTADO DE APLICACIÓN DEL ÍNDICE DE BARTHEL ENTRE EL INGRESO Y EGRESO HOSPITALARIO.</option>
                <option value="D6">D.6: APLICACIÓN DE ESCALA ZARIT ABREVIADO EN CUIDADORES DE PERSONAS CON DEPENDENCIA SEVERA.</option>
                <option value="D7">D.7: APLICACIÓN Y RESULTADOS DE PAUTA DE EVALUACION CON ENFOQUE DE RIESGO ODONTOLOGICO (CERO).</option>
            </optgroup>
              <option value="E">E: APLICACIÓN DE PAUTA DETECCIÓN DE FACTORES DE RIESGO PSICOSOCIAL INFANTIL.</option>
              <option value="F">F: TAMIZAJE TRASTORNO ESPECTRO AUTISTA (MCHAT).</option>
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
                    <td colspan="25" class="active"><strong>SECCIÓN A: APLICACIÓN DE INSTRUMENTO Y RESULTADO EN EL NIÑO (A).</strong></td>
                </tr>
                <tr>
                    <td colspan="25" class="active"><strong>SECCIÓN A1: APLICACIÓN Y RESULTADOS DE PAUTA BREVE.</strong></td>
                </tr>
                <tr>
                    <td colspan="2" rowspan="3" style="text-align:center; vertical-align:middle"><strong>EVALUACIONES POR EDAD DEL NIÑO</strong></td>
                    <td colspan="3" rowspan="2" style="text-align:center; vertical-align:middle"><strong>TOTAL</strong></td>
                    <td colspan="20" align="center"><strong>GRUPO DE EDAD</strong></td>
                </tr>
                <tr>
                    <td colspan="2" align="center"><strong>Menor de 1 mes</strong></td>
                    <td colspan="2" align="center"><strong>1 mes</strong></td>
                    <td colspan="2" align="center"><strong>2 meses</strong></td>
                    <td colspan="2" align="center"><strong>3 meses</strong></td>
                    <td colspan="2" align="center"><strong>4 meses</strong></td>
                    <td colspan="2" align="center"><strong>5 meses</strong></td>
                    <td colspan="2" align="center"><strong>6 meses</strong></td>
                    <td colspan="2" align="center"><strong>7 - 11 meses</strong></td>
                    <td colspan="2" align="center"><strong>12 - 17 meses</strong></td>
                    <td colspan="2" align="center"><strong>18 - 24 meses</strong></td>
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
                          FROM  (select c.* from 2020prestaciones c where c.codigo_prestacion in("02021730","03500020","03500030")) a
                          left join 2020rems b on (a.id_prestacion=b.prestacion_id_prestacion)
                          AND (b.Mes in ('.$mes.')) AND (b.establecimiento_id_establecimiento in ('.$estab.'))
                          group by a.codigo_prestacion, a.descripcion, a.id_prestacion
                          order by a.id_prestacion';

                $registro = DB::connection('mysql_rem')->select($query);

                $i=0;

                foreach($registro as $row ){
                    $nombre_descripcion = $row->codigo_prestacion;
                    if ($nombre_descripcion == "02021730"){
                        $nombre_descripcion = "APLICACIÓN PAUTA BREVE";
                    }
                    if ($nombre_descripcion == "03500020"){
                        $nombre_descripcion = "NORMAL";
                    }
                    if ($nombre_descripcion == "03500030"){
                        $nombre_descripcion = "ALTERADO";
                    }
                    ?>
                <tr>
                    <?php
                    if($i==0){?>
                    <td align='left' nowrap="nowrap" colspan="2"><?php echo $nombre_descripcion; ?></td>
                    <?php
                    }
                    if($i==1){?>
                    <td rowspan="2" style="text-align:center; vertical-align:middle" nowrap>RESULTADOS</td>
                    <td align='left' nowrap="nowrap"><?php echo $nombre_descripcion; ?></td>
                    <?php
                    }
                    if($i==2){?>
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

    </main>

    <br>

    <!-- SECCIÓN A.2 -->
    <div class="col-sm tab table-responsive" id="A2">
        <table class="table table-hover table-bordered table-sm">
            <thead>
                <tr>
                    <td colspan="18" class="active"><strong>SECCIÓN A2: RESULTADOS DE LA APLICACIÓN DE ESCALA DE EVALUACIÓN DEL DESARROLLO PSICOMOTOR.</strong></td>
                </tr>
                <tr>
                    <td rowspan="3" style="text-align:center; vertical-align:middle"><strong>ACTIVIDAD</strong></td>
                    <td rowspan="3" style="text-align:center; vertical-align:middle"><strong>RESULTADO</strong></td>
                    <td rowspan="2" colspan="3" style="text-align:center; vertical-align:middle"><strong>TOTAL</strong></td>
                    <td colspan="12" align="center"><strong>POR EDAD</strong></td>
                    <td rowspan="3" style="text-align:center; vertical-align:middle"><strong>MIGRANTES</strong></td>
                </tr>
                <tr>
                    <td align="center" colspan="2"><strong>Menor 7 meses</strong></td>
                    <td align="center" colspan="2"><strong>7 - 11 meses</strong></td>
                    <td align="center" colspan="2"><strong>12 - 17 meses</strong></td>
                    <td align="center" colspan="2"><strong>18 - 23 meses</strong></td>
                    <td align="center" colspan="2"><strong>24 - 47 meses</strong></td>
                    <td colspan="2" align="center"><strong>48 - 59 meses</strong></td>
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
                            ,sum(ifnull(b.Col16,0)) Col16
                        FROM  (select c.* from 2020prestaciones c where c.codigo_prestacion in("02021740",
                                                                                               "02010320","05225303","02010321","02010322",
                                                                                               "05225304","02010420","05225305","03500366","03500400","03500401","05225306","02010421","02010422",
                                                                                               "03500331","03500332",
                                                                                               "03500333","03500334","03500335")) a
                        left join 2020rems b on (a.id_prestacion=b.prestacion_id_prestacion)
                        AND (b.Mes in ('.$mes.')) AND (b.establecimiento_id_establecimiento in ('.$estab.'))
                        group by a.codigo_prestacion, a.descripcion, a.id_prestacion
                        order by a.id_prestacion';

              $registro = DB::connection('mysql_rem')->select($query);

              $i=0;

              foreach($registro as $row ){
                  $nombre_descripcion = $row->codigo_prestacion;
                  if ($nombre_descripcion == "02021740"){
                      $nombre_descripcion = "APLICACIÓN TEST DE DESARROLLO PSICOMOTOR";
                  }

                  if ($nombre_descripcion == "02010320"){
                      $nombre_descripcion = "NORMAL";
                  }
                  if ($nombre_descripcion == "05225303"){
                      $nombre_descripcion = "NORMAL CON REZAGO";
                  }
                  if ($nombre_descripcion == "02010321"){
                      $nombre_descripcion = "RIESGO";
                  }
                  if ($nombre_descripcion == "02010322"){
                      $nombre_descripcion = "RETRASO";
                  }

                  if ($nombre_descripcion == "05225304"){
                      $nombre_descripcion = "NORMAL (desde normal con rezago)";
                  }
                  if ($nombre_descripcion == "02010420"){
                      $nombre_descripcion = "NORMAL (desde riesgo)";
                  }
                  if ($nombre_descripcion == "05225305"){
                      $nombre_descripcion = "NORMAL (desde retraso)";
                  }
                  if ($nombre_descripcion == "03500366"){
                      $nombre_descripcion = "NORMAL CON REZAGO (desde riesgo)";
                  }
                  if ($nombre_descripcion == "03500400"){
                      $nombre_descripcion = "NORMAL CON REZAGO (desde retraso)";
                  }
                  if ($nombre_descripcion == "03500401"){
                      $nombre_descripcion = "RIESGO (desde retraso)";
                  }
                  if ($nombre_descripcion == "05225306"){
                      $nombre_descripcion = "NORMAL CON REZAGO (desde normal con rezago)";
                  }
                  if ($nombre_descripcion == "02010421"){
                      $nombre_descripcion = "RIESGO (desde riesgo)";
                  }
                  if ($nombre_descripcion == "02010422"){
                      $nombre_descripcion = "RETRASO (desde retraso)";
                  }

                  if ($nombre_descripcion == "03500331"){
                      $nombre_descripcion = "RIESGO";
                  }
                  if ($nombre_descripcion == "03500332"){
                      $nombre_descripcion = "RETRASO";
                  }

                  if ($nombre_descripcion == "03500333"){
                      $nombre_descripcion = "NORMAL CON REZAGO";
                  }
                  if ($nombre_descripcion == "03500334"){
                      $nombre_descripcion = "RIESGO";
                  }
                  if ($nombre_descripcion == "03500335"){
                      $nombre_descripcion = "RETRASO";
                  }
                  ?>
              <tr>
                  <?php
                  if($i==0){?>
                  <td align='left' nowrap="nowrap" colspan="2"><?php echo $nombre_descripcion; ?></td>
                  <?php
                  }
                  if($i==1){?>
                  <td rowspan="4" style="text-align:center; vertical-align:middle" nowrap>PRIMERA EVALUACIÓN</td>
                  <td align='left' nowrap="nowrap"><?php echo $nombre_descripcion; ?></td>
                  <?php
                  }
                  if($i>=2 && $i<=4){?>
                  <td align='left' nowrap="nowrap"><?php echo $nombre_descripcion; ?></td>
                  <?php
                  }
                  if($i==5){?>
                  <td rowspan="9" style="text-align:center; vertical-align:middle" nowrap>REEVALUACIÓN</td>
                  <td align='left' nowrap="nowrap"><?php echo $nombre_descripcion; ?></td>
                  <?php
                  }
                  if($i>=6 && $i<=13){?>
                  <td align='left' nowrap="nowrap"><?php echo $nombre_descripcion; ?></td>
                  <?php
                  }
                  if($i==14){?>
                  <td rowspan="2" style="text-align:center; vertical-align:middle" nowrap>DERIVADOS A ESPECIALIDAD</td>
                  <td align='left' nowrap="nowrap"><?php echo $nombre_descripcion; ?></td>
                  <?php
                  }
                  if($i==15){?>
                  <td align='left' nowrap="nowrap"><?php echo $nombre_descripcion; ?></td>
                  <?php
                  }
                  if($i==16){?>
                  <td rowspan="3" style="text-align:center; vertical-align:middle" nowrap>TRASLADO DE ESTABLECIMIENTO</td>
                  <td align='left' nowrap="nowrap"><?php echo $nombre_descripcion; ?></td>
                  <?php
                  }
                  if($i>=17){?>
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
                  <?php
                  $i++;
              }
              ?>
            </tbody>
        </table>
    </div>

    <br>

    <!-- SECCIÓN A.3 -->
    <div class="col-sm tab table-responsive" id="A3">
        <table class="table table-hover table-bordered table-sm">
            <thead>
                <tr>
                    <td colspan="16" class="active"><strong>SECCIÓN A3: NIÑOS Y NIÑAS CON REZAGO, DÉFICIT U OTRA VULNERABILIDAD DERIVADOS A ALGUNA MODALIDAD DE ESTIMULACIÓN EN LA PRIMERA EVALUACIÓN.</strong></td>
                </tr>
                <tr>
                    <td rowspan="3" style="text-align:center; vertical-align:middle"><strong>NIÑO / A</strong></td>
                    <td rowspan="2" colspan="3" style="text-align:center; vertical-align:middle"><strong>TOTAL</strong></td>
                    <td colspan="12" align="center"><strong>POR EDAD</strong></td>
                </tr>
                <tr>
                    <td align="center" colspan="2"><strong>Menor 7 meses</strong></td>
                    <td align="center" colspan="2"><strong>7 - 11 meses</strong></td>
                    <td align="center" colspan="2"><strong>12 - 17 meses</strong></td>
                    <td align="center" colspan="2"><strong>18 - 23 meses</strong></td>
                    <td align="center" colspan="2"><strong>24 - 47 meses</strong></td>
                    <td align="center" colspan="2"><strong>48 - 59 meses</strong></td>
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
                          FROM  (select c.* from 2020prestaciones c where c.codigo_prestacion in("02021790","02021810","02021820","05225307")) a
                          left join 2020rems b on (a.id_prestacion=b.prestacion_id_prestacion)
                          AND (b.Mes in ('.$mes.')) AND (b.establecimiento_id_establecimiento in ('.$estab.'))
                          group by a.codigo_prestacion, a.descripcion, a.id_prestacion
                          order by a.id_prestacion';

                $registro = DB::connection('mysql_rem')->select($query);

                $i=0;

                foreach($registro as $row ){
                    $nombre_descripcion = $row->codigo_prestacion;
                    if ($nombre_descripcion == "02021790"){
                        $nombre_descripcion = "NORMAL CON REZAGO";
      							}
      							if ($nombre_descripcion == "02021810"){
                        $nombre_descripcion = "RIESGO";
      							}
      							if ($nombre_descripcion == "02021820"){
                        $nombre_descripcion = "RETRASO";
      							}
      							if ($nombre_descripcion == "05225307"){
                        $nombre_descripcion = "OTRA VULNERABILIDAD";
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

    <div class="container">
    <!-- SECCION A4 -->
    <div class="col-sm tab table-responsive" id="A4">
        <table class="table table-hover table-bordered table-sm">
            <thead>
                <tr>
                    <td colspan="8" class="active"><strong>SECCIÓN A.4: RESULTADOS DE LA APLICACIÓN DE PROTOCOLO NEUROSENSORIAL.</strong></td>
                </tr>
                <tr>
                    <td rowspan="3" style="text-align:center; vertical-align:middle"><strong>RESULTADOS</strong></td>
                    <td rowspan="2" colspan="3" style="text-align:center; vertical-align:middle"><strong>TOTAL</strong></td>
                    <td colspan="4" align="center"><strong>POR EDAD</strong></td>
                </tr>
                <tr>
                    <td align="center" colspan="2"><strong>1 mes</strong></td>
                    <td align="center" colspan="2"><strong>2 meses</strong></td>
                </tr>
                <tr>
                    <td align="center"><strong>Ambos Sexos</strong></td>
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
                          FROM  (select c.* from 2020prestaciones c where c.codigo_prestacion in("02021760","03500040","03500050","03500060")) a
                          left join 2020rems b on (a.id_prestacion=b.prestacion_id_prestacion)
                          AND (b.Mes in ('.$mes.')) AND (b.establecimiento_id_establecimiento in ('.$estab.'))
                          group by a.codigo_prestacion, a.descripcion, a.id_prestacion
                          order by a.id_prestacion';

                $registro = DB::connection('mysql_rem')->select($query);

                $i=0;

                foreach($registro as $row ){
                    $nombre_descripcion = $row->codigo_prestacion;
                    if ($nombre_descripcion == "02021760"){
                        $nombre_descripcion = "APLICACIÓN DE PROTOCOLO NEUROSENSORIAL (1-2 MESES)";
      							}
      							if ($nombre_descripcion == "03500040"){
                        $nombre_descripcion = "NORMAL";
      							}
      							if ($nombre_descripcion == "03500050"){
                        $nombre_descripcion = "ANORMAL";
      							}
        							if ($nombre_descripcion == "03500060"){
        								$nombre_descripcion = "MUY ANORMAL";
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

    <!-- SECCION A.5 -->
    <div class="col-sm tab table-responsive" id="A5">
        <table class="table table-hover table-bordered table-sm">
            <thead>
                <tr>
                    <td colspan="14" class="active"><strong>SECCIÓN A.5: LACTANCIA MATERNA EN MENORES CONTROLADOS.</strong></td>
                </tr>
                <tr>
                    <td rowspan="3" style="text-align:center; vertical-align:middle"><strong>TIPO DE ALIMENTACIÓN</strong></td>
                    <td colspan="3" rowspan="2" style="text-align:center; vertical-align:middle"><strong>TOTAL</strong></td>
                    <td colspan="10" align="center"><strong>SEGÚN CONTROL PROGRAMÁTICO</strong></td>
                </tr>
                <tr>
                    <td colspan="2" align="center"><strong>Del 1° mes</strong></td>
                    <td colspan="2" align="center"><strong>Del 3° mes</strong></td>
                    <td colspan="2" align="center"><strong>Del 6° mes</strong></td>
                    <td colspan="2" align="center"><strong>Del 12° mes</strong></td>
                    <td colspan="2" align="center"><strong>Del 24° mes</strong></td>
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
                          FROM  (select c.* from 2020prestaciones c where c.codigo_prestacion in("A0200001","A0200002","03500359","03500360","A0200003")) a
                          left join 2020rems b on (a.id_prestacion=b.prestacion_id_prestacion)
                          AND (b.Mes in ('.$mes.')) AND (b.establecimiento_id_establecimiento in ('.$estab.'))
                          group by a.codigo_prestacion, a.descripcion, a.id_prestacion
                          order by a.id_prestacion';

                $registro = DB::connection('mysql_rem')->select($query);

                $i=0;

                foreach($registro as $row ){
                    $nombre_descripcion = $row->codigo_prestacion;
                    if ($nombre_descripcion == "A0200001"){
                        $nombre_descripcion = "MENORES CONTROLADOS";
      							}
      							if ($nombre_descripcion == "A0200002"){
                        $nombre_descripcion = "LACTANCIA MATERNA EXCLUSIVA";
      							}
      							if ($nombre_descripcion == "03500359"){
                        $nombre_descripcion = "LACTANCIA MATERNA / FORMULA LACTEA";
      							}
      							if ($nombre_descripcion == "03500360"){
                        $nombre_descripcion = "FORMULA LACTEA	";
      							}
      							if ($nombre_descripcion == "A0200003"){
                        $nombre_descripcion = "LACTANCIA MATERNA MAS SÓLIDOS";
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

    <div class="container">

    <!-- SECCION B1 -->
    <div class="col-sm tab table-responsive" id="B1">
        <table class="table table-hover table-bordered table-sm">
            <thead>
                <tr>
                    <td colspan="2" class="active"><strong>SECCION B: EVALUACIÓN, APLICACIÓN Y RESULTADOS DE ESCALAS EN  LA MUJER.</strong></td>
                </tr>
                <tr>
                    <td colspan="2" class="active"><strong>SECCIÓN B.1: EVALUACIÓN DEL ESTADO NUTRICIONAL A MUJERES CONTROLADAS AL OCTAVO MES POST PARTO.</strong></td>
                </tr>
                <tr>
                    <td align="center"><strong>ESTADO NUTRICIONAL</strong></td>
                    <td align="center"><strong>TOTAL</strong></td>
                </tr>
            </thead>
            <tbody>
                <?php
                $query = 'SELECT a.codigo_prestacion,a.descripcion
                              ,sum(ifnull(b.Col01,0)) Col01
                          FROM  (select c.* from 2020prestaciones c where c.codigo_prestacion in("03500120","03500130","03500140","03500150")) a
                          left join 2020rems b on (a.id_prestacion=b.prestacion_id_prestacion)
                          AND (b.Mes in ('.$mes.')) AND (b.establecimiento_id_establecimiento in ('.$estab.'))
                          group by a.codigo_prestacion, a.descripcion, a.id_prestacion
                          order by a.id_prestacion';

                $registro = DB::connection('mysql_rem')->select($query);

                $i=0;

                $totalCol01=0;

                foreach($registro as $row ){
                    $totalCol01=$totalCol01+$row->Col01;
                }
                ?>

                <tr>
                    <td align='center'><strong>TOTAL</strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol01,0,",",".") ?></strong></td>
                </tr>

                <?php
                foreach($registro as $row ){
                    $nombre_descripcion = $row->codigo_prestacion;
                    if ($nombre_descripcion == "03500120"){
                        $nombre_descripcion = "OBESA";
      							}
      							if ($nombre_descripcion == "03500130"){
                        $nombre_descripcion = "SOBREPESO";
      							}
      							if ($nombre_descripcion == "03500140"){
                        $nombre_descripcion = "NORMAL";
      							}
      							if ($nombre_descripcion == "03500150"){
                        $nombre_descripcion = "BAJO PESO";
      							}
                    ?>
                <tr>
                    <td align='left'><?php echo $nombre_descripcion; ?></td>
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

    <!-- SECCION B2 -->
    <div class="col-sm tab table-responsive" id="B2">
        <table class="table table-hover table-bordered table-sm">
            <thead>
                <tr>
                    <td colspan="4" class="active"><strong>SECCIÓN B.2: APLICACIÓN DE ESCALA SEGÚN EVALUACION DE RIESGO PSICOSOCIAL ABREVIADA A GESTANTES.</strong></td>
                </tr>
                <tr>
                    <td align='center'><strong>TIPO</strong></td>
                    <td align='center'><strong>TOTAL DE APLICACIONES</strong></td>
                    <td align='center'><strong>RIESGO</strong></td>
                    <td align='center'><strong>DERIVADAS A EQUIPO DE CABECERA</strong></td>
                </tr>
            </thead>
            <tbody>
                <?php
                $query = 'SELECT a.codigo_prestacion,a.descripcion
                              ,sum(ifnull(b.Col01,0)) Col01
                              ,sum(ifnull(b.Col02,0)) Col02
                              ,sum(ifnull(b.Col03,0)) Col03
                          FROM  (select c.* from 2020prestaciones c where c.codigo_prestacion in("02021830")) a
                          left join 2020rems b on (a.id_prestacion=b.prestacion_id_prestacion)
                          AND (b.Mes in ('.$mes.')) AND (b.establecimiento_id_establecimiento in ('.$estab.'))
                          group by a.codigo_prestacion, a.descripcion, a.id_prestacion
                          order by a.id_prestacion';

                $registro = DB::connection('mysql_rem')->select($query);

                $i=0;

                foreach($registro as $row ){
                    $nombre_descripcion = $row->codigo_prestacion;
                    if ($nombre_descripcion == "02021830"){
                        $nombre_descripcion = "EVALUACIÓN AL INGRESO";
                    }
                    ?>
                <tr>
                    <td align='left'><?php echo $nombre_descripcion; ?></td>
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

    <!-- SECCION B3 -->
    <div class="col-sm tab table-responsive" id="B3">
        <table class="table table-hover table-bordered table-sm">
            <thead>
                <tr>
                    <td colspan="6" class="active"><strong>SECCIÓN B.3: APLICACIÓN DE ESCALA DE EDIMBURGO A GESTANTES Y MUJERES POST PARTO.</strong></td>
                </tr>
                <tr>
                    <td colspan="2" style="text-align:center; vertical-align:middle"><strong>CONCEPTO</strong></td>
                    <td align='center'><strong>TOTAL DE APLICACIONES</strong></td>
                    <td align='center'><strong>RESULTADOS 10 O MÁS PTOS. O RESULTADO DISTINTO DE 0 EN PREG 10. (PUERPERAS)</strong></td>
                    <td align='center'><strong>RESULTADOS 13 O MÁS PTOS O RESULTADO DISTINTO DE 0 EN PREG 10. (GESTANTES)</strong></td>
                    <td align='center'><strong>TOTAL DE CASOS ALTERADOS DERIVADOS A SALUD MENTAL</strong></td>
                </tr>
            </thead>
            <tbody>
                <?php
                $query = 'SELECT a.codigo_prestacion,a.descripcion
                              ,sum(ifnull(b.Col01,0)) Col01
                              ,sum(ifnull(b.Col02,0)) Col02
                              ,sum(ifnull(b.Col03,0)) Col03
                              ,sum(ifnull(b.Col04,0)) Col04
                          FROM  (select c.* from 2020prestaciones c where c.codigo_prestacion in("03500160","03500170","03500200","03500210")) a
                          left join 2020rems b on (a.id_prestacion=b.prestacion_id_prestacion)
                          AND (b.Mes in ('.$mes.')) AND (b.establecimiento_id_establecimiento in ('.$estab.'))
                          group by a.codigo_prestacion, a.descripcion, a.id_prestacion
                          order by a.id_prestacion';

                $registro = DB::connection('mysql_rem')->select($query);

                $i=0;

                foreach($registro as $row ){
                    $nombre_descripcion = $row->codigo_prestacion;
                    if ($nombre_descripcion == "03500160"){
                        $nombre_descripcion = "PRIMERA EVALUACIÓN (2º control prenatal)";
                    }
                    if ($nombre_descripcion == "03500170"){
                        $nombre_descripcion = "REEVALUACIÓN (con puntaje elevado en la primera evaluación)";
							      }
                    if ($nombre_descripcion == "03500200"){
                        $nombre_descripcion = "A los 2 meses";
                    }
                    if ($nombre_descripcion == "03500210"){
                        $nombre_descripcion = "A los 6 meses";
                    }
                    ?>
                <tr>
                    <?php
                    if($i==0){?>
                    <td rowspan="2" style="text-align:center; vertical-align:middle">EVALUACIÓN A GESTANTES</td>
                    <?php
                    }
                    if($i==2){?>
                    <td rowspan="2" style="text-align:center; vertical-align:middle">EVALUACIÓN A MUJERES POST PARTO O SÍNTOMAS DE DEPRESIÓN</td>
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
            </tbody>
        </table>
    </div>

    <br>

    <!-- SECCION C -->
    <div class="col-sm tab table-responsive" id="C">
        <table class="table table-hover table-bordered table-sm">
            <thead>
                <tr>
                    <td colspan="8" class="active"><strong>SECCIÓN C: RESULTADOS DE LA EVALUACIÓN DEL ESTADO NUTRICIONAL DEL ADOLESCENTE CON CONTROL SALUD INTEGRAL.</strong></td>
                </tr>
                <tr>
                    <td rowspan='2' style="text-align:center; vertical-align:middle"><strong>ESTADO NUTRICIONAL</strong></td>
                    <td colspan='3' align='center'><strong>TOTAL</strong></td>
                    <td colspan='2' align='center'><strong>10 A 14</strong></td>
                    <td colspan='2' align='center'><strong>15 A 19</strong></td>
                </tr>
                <tr>
                    <td align='center'><strong>AMBOS SEXOS</strong></td>
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
                          FROM  (select c.* from 2020prestaciones c where c.codigo_prestacion in("03050400","03050500","03050600","03050700","03050710")) a
                          left join 2020rems b on (a.id_prestacion=b.prestacion_id_prestacion)
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

                foreach($registro as $row ){
                    $totalCol01=$totalCol01+$row->Col01;
                    $totalCol02=$totalCol02+$row->Col02;
                    $totalCol03=$totalCol03+$row->Col03;
                    $totalCol04=$totalCol04+$row->Col04;
                    $totalCol05=$totalCol05+$row->Col05;
                    $totalCol06=$totalCol06+$row->Col06;
                    $totalCol07=$totalCol07+$row->Col07;
                }
                ?>

                <tr>
                    <td align='center'><strong>TOTAL</strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol01,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol02,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol03,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol04,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol05,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol06,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol07,0,",",".") ?></strong></td>
                </tr>

                <?php

                foreach($registro as $row ){
                    $nombre_descripcion = $row->codigo_prestacion;
                    if ($nombre_descripcion == "03050400"){
                        $nombre_descripcion = "NORMAL";
      							}
      							if ($nombre_descripcion == "03050500"){
                        $nombre_descripcion = "BAJO PESO";
      							}
      							if ($nombre_descripcion == "03050600"){
      								$nombre_descripcion = "SOBREPESO";
      							}
      							if ($nombre_descripcion == "03050700"){
      								$nombre_descripcion = "OBESOS";
      							}
      							if ($nombre_descripcion == "03050710"){
      								$nombre_descripcion = "OBESOS SEVEROS";
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

    <!-- SECCION D1 -->
    <div class="col-sm tab table-responsive" id="D1">
        <table class="table table-hover table-bordered table-sm">
            <thead>
                <tr>
                    <td colspan="17" class="active"><strong>SECCIÓN D: OTRAS EVALUACIONES, APLICACIONES Y RESULTADOS DE ESCALAS EN TODAS LAS EDADES.</strong></td>
                </tr>
                <tr>
                    <td colspan="17" class="active"><strong>SECCIÓN D.1: APLICACIÓN DE TAMIZAJE PARA EVALUAR EL NIVEL DE RIESGO DE CONSUMO DE ALCOHOL, TABACO Y OTRAS DROGAS.</strong></td>
                </tr>
                <tr>
                    <td colspan="2" rowspan="3" style="text-align:center; vertical-align:middle"><strong>COMPONENTE</strong></td>
                    <td rowspan="2" colspan="3" align="center"><strong>TOTAL</strong></td>
                    <td colspan="12" align="center"><strong>POR EDAD</strong></td>
                </tr>
                <tr>
                    <td align="center" colspan="2"><strong>10-14 años</strong></td>
                    <td align="center" colspan="2"><strong>15-19 años</strong></td>
                    <td align="center" colspan="2"><strong>20-24 años</strong></td>
                    <td align="center" colspan="2"><strong>25-44 años</strong></td>
                    <td align="center" colspan="2"><strong>45-64 años</strong></td>
                    <td align="center" colspan="2"><strong>65 o más</strong></td>
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
                          FROM  (select c.* from 2020prestaciones c where c.codigo_prestacion in("03500346","03500347","03500402","03500348","03600100","03500367",
                                                                                                 "03500349","03500290","03500300")) a
                          left join 2020rems b on (a.id_prestacion=b.prestacion_id_prestacion)
                          AND (b.Mes in ('.$mes.')) AND (b.establecimiento_id_establecimiento in ('.$estab.'))
                          group by a.codigo_prestacion, a.descripcion, a.id_prestacion
                          order by a.id_prestacion';

                $registro = DB::connection('mysql_rem')->select($query);

                $i=0;

                foreach($registro as $row ){
                    $nombre_descripcion = $row->codigo_prestacion;
                    if ($nombre_descripcion == "03500346"){
        								$nombre_descripcion = "Nº DE AUDIT (EMP/EMPAM)";
        						}
        						if ($nombre_descripcion == "03500347"){
        							  $nombre_descripcion = "Nº DE AUDIT APLICADO";
        						}
                    if ($nombre_descripcion == "03500402"){
        							  $nombre_descripcion = "Nº DE ASSIST (EMP/EMPAM)";
        						}
                    if ($nombre_descripcion == "03500348"){
        							  $nombre_descripcion = "N° DE ASSIST APLICADO";
        						}
                    if ($nombre_descripcion == "03600100"){
        							  $nombre_descripcion = "N° DE CRAFFT EN CONTROL DE SALUD INTEGRAL DEL ADOLESCENTE";
        						}
                    if ($nombre_descripcion == "03500367"){
        							  $nombre_descripcion = "N° DE CRAFFT APLICADO";
        						}


        						if ($nombre_descripcion == "03500349"){
        								$nombre_descripcion = "BAJO RIESGO";
        						}
        						if ($nombre_descripcion == "03500290"){
        								$nombre_descripcion = "CONSUMO RIESGOSO / INTERMEDIO";
        						}
        						if ($nombre_descripcion == "03500300"){
        								$nombre_descripcion = "POSIBLE CONSUMO PERJUDICIAL O DEPENDENCIA";
        						}
                    ?>
                <tr>
                    <?php
                    if($i>=0 && $i<=4){?>
                    <td align='left' nowrap="nowrap" colspan="2"><?php echo $nombre_descripcion; ?></td>
                    <?php
                    }
                    if($i==5){?>
                    <td align='left' rowspan="3" style="text-align:center; vertical-align:middle">RESULTADOS DE EVALUACIÓN</td>
                    <td align='left'><?php echo $nombre_descripcion; ?></td>
                    <?php
                    }
							      if($i>=6){?>
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

    <div class="col-sm tab table-responsive" id="D2">
        <table class="table table-hover table-bordered table-sm">
            <thead>
                <tr>
                    <td colspan="27" class="active"><strong>SECCIÓN D.2: RESULTADOS DE LA APLICACIÓN DE INSTRUMENTO DE VALORACIÓN DE DESEMPEÑO EN COMUNIDAD (IVADEC-CIF).</strong></td>
                </tr>
                <tr>
                    <td rowspan="3" style="text-align:center; vertical-align:middle"><strong>ACTIVIDAD</strong></td>
                    <td rowspan="3" style="text-align:center; vertical-align:middle"><strong>RESULTADO</strong></td>
                    <td rowspan="2" colspan="3" style="text-align:center; vertical-align:middle"><strong>TOTAL</strong></td>
                    <td colspan="22" align="center"><strong>POR EDAD</strong></td>
                </tr>
                <tr>
                    <td align="center" colspan="2"><strong>6 -11 meses</strong></td>
                    <td align="center" colspan="2"><strong>12 - 23 meses</strong></td>
                    <td align="center" colspan="2"><strong>2 - 4 años</strong></td>
                    <td align="center" colspan="2"><strong>5 - 9 años</strong></td>
                    <td align="center" colspan="2"><strong>10 a 14 años</strong></td>
                    <td align="center" colspan="2"><strong>15 a 19 años</strong></td>
                    <td align="center" colspan="2"><strong>20 a 24 años</strong></td>
                    <td align="center" colspan="2"><strong>25 a 64 años</strong></td>
                    <td align="center" colspan="2"><strong>65 a 69 años</strong></td>
                    <td align="center" colspan="2"><strong>70 a 79 años</strong></td>
                    <td align="center" colspan="2"><strong>80 y más años</strong></td>
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
                          FROM  (select c.* from 2020prestaciones c where c.codigo_prestacion in("03051000A","03051100","03051200","03051300","03051400",
                                                                                                 "03051500","03051600","03051700","03051800","03051900",
                                                                                                 "03052000","03052100","03052200","03052300","03052400",
                                                                                                 "03052500","03052600","03052700","03052800","03052900",
                                                                                                 "03053000","03053100","03053200","03053300","03053400",
                                                                                                 "03053500","03053600","03053700","03053800","03053900")) a
                          left join 2020rems b on (a.id_prestacion=b.prestacion_id_prestacion)
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

                    $nombre_descripcion = $row->codigo_prestacion;
                    if ($nombre_descripcion == "03051000A"){
                        $nombre_descripcion = "SIN DISCAPACIDAD";
      							}
      							if ($nombre_descripcion == "03051100"){
                        $nombre_descripcion = "DISCAPACIDAD LEVE";
      							}
      							if ($nombre_descripcion == "03051200"){
                        $nombre_descripcion = "DISCAPACIDAD MODERADA";
      							}
      							if ($nombre_descripcion == "03051300"){
                        $nombre_descripcion = "DISCAPACIDAD SEVERA";
      							}
      							if ($nombre_descripcion == "03051400"){
                        $nombre_descripcion = "DISCAPACIDAD PROFUNDA";
      							}

      							if ($nombre_descripcion == "03051500"){
                        $nombre_descripcion = "SIN DISCAPACIDAD";
      							}
      							if ($nombre_descripcion == "03051600"){
                        $nombre_descripcion = "DISCAPACIDAD LEVE";
      							}
      							if ($nombre_descripcion == "03051700"){
                        $nombre_descripcion = "DISCAPACIDAD MODERADA";
      							}
      							if ($nombre_descripcion == "03051800"){
                        $nombre_descripcion = "DISCAPACIDAD SEVERA";
      							}
      							if ($nombre_descripcion == "03051900"){
                        $nombre_descripcion = "DISCAPACIDAD PROFUNDA";
      							}

      							if ($nombre_descripcion == "03052000"){
                        $nombre_descripcion = "SIN DISCAPACIDAD";
      							}
      							if ($nombre_descripcion == "03052100"){
                        $nombre_descripcion = "DISCAPACIDAD LEVE";
      							}
      							if ($nombre_descripcion == "03052200"){
                        $nombre_descripcion = "DISCAPACIDAD MODERADA";
      							}
      							if ($nombre_descripcion == "03052300"){
                        $nombre_descripcion = "DISCAPACIDAD SEVERA";
      							}
      							if ($nombre_descripcion == "03052400"){
                        $nombre_descripcion = "DISCAPACIDAD PROFUNDA";
      							}

      							if ($nombre_descripcion == "03052500"){
                        $nombre_descripcion = "SIN DISCAPACIDAD";
      							}
      							if ($nombre_descripcion == "03052600"){
                        $nombre_descripcion = "DISCAPACIDAD LEVE";
      							}
      							if ($nombre_descripcion == "03052700"){
                        $nombre_descripcion = "DISCAPACIDAD MODERADA";
      							}
      							if ($nombre_descripcion == "03052800"){
                        $nombre_descripcion = "DISCAPACIDAD SEVERA";
      							}
      							if ($nombre_descripcion == "03052900"){
                        $nombre_descripcion = "DISCAPACIDAD PROFUNDA";
      							}

      							/* ORIGEN MENTAL INTELECTUAL */

      							if ($nombre_descripcion == "03053000"){
                        $nombre_descripcion = "SIN DISCAPACIDAD";
      							}
      							if ($nombre_descripcion == "03053100"){
                        $nombre_descripcion = "DISCAPACIDAD LEVE";
      							}
      							if ($nombre_descripcion == "03053200"){
                        $nombre_descripcion = "DISCAPACIDAD MODERADA";
      							}
      							if ($nombre_descripcion == "03053300"){
                        $nombre_descripcion = "DISCAPACIDAD SEVERA";
      							}
      							if ($nombre_descripcion == "03053400"){
                        $nombre_descripcion = "DISCAPACIDAD PROFUNDA";
      							}

      							/* ORIGEN MULTIPLE */

      							if ($nombre_descripcion == "03053500"){
                        $nombre_descripcion = "SIN DISCAPACIDAD";
      							}
      							if ($nombre_descripcion == "03053600"){
                        $nombre_descripcion = "DISCAPACIDAD LEVE";
      							}
      							if ($nombre_descripcion == "03053700"){
                        $nombre_descripcion = "DISCAPACIDAD MODERADA";
      							}
      							if ($nombre_descripcion == "03053800"){
                        $nombre_descripcion = "DISCAPACIDAD SEVERA";
      							}
      							if ($nombre_descripcion == "03053900"){
                        $nombre_descripcion = "DISCAPACIDAD PROFUNDA";
      							}
                    ?>
                    <tr>
                    <?php
							      if($i==0){?>
                        <td rowspan="5" style="text-align:center; vertical-align:middle">ORIGEN FISICO</td>
                    <?php
                    }
                    if($i==5){?>
                        <td rowspan="5" style="text-align:center; vertical-align:middle">ORIGEN SENSORIAL VISUAL</td>
                    <?php
                    }
                    if($i==10){?>
                        <td rowspan="5" style="text-align:center; vertical-align:middle">ORIGEN SENSORIAL AUDITIVO</td>
                    <?php
							      }
                    if($i==15){?>
                        <td rowspan="5" style="text-align:center; vertical-align:middle">ORIGEN MENTAL PSIQUICO</td>
                    <?php
							      }
                    if($i==20){?>
                        <td rowspan="5" style="text-align:center; vertical-align:middle">ORIGEN MENTAL INTELECTUAL</td>
                    <?php
							      }
                    if($i==25){?>
                        <td rowspan="5" style="text-align:center; vertical-align:middle">ORIGEN MULTIPLE</td>
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
                    <?php
                    $i++;
                }
                ?>
                </tr>
                <tr>
                    <td align='left' colspan="2"><strong>TOTAL DE EVALUACIONES</strong></td>
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
                          FROM  (select c.* from 2020prestaciones c where c.codigo_prestacion in("03500336","03500337","03500338","03500339","03500340",
                                                                                                 "03500341","03500342","03500343","03500344","03500345")) a
                          left join 2020rems b on (a.id_prestacion=b.prestacion_id_prestacion)
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

                    $nombre_descripcion = $row->codigo_prestacion;
                    if ($nombre_descripcion == "03500336"){
                        $nombre_descripcion = "SIN DISCAPACIDAD";
      							}
      							if ($nombre_descripcion == "03500337"){
                        $nombre_descripcion = "DISCAPACIDAD LEVE";
      							}
      							if ($nombre_descripcion == "03500338"){
                        $nombre_descripcion = "DISCAPACIDAD MODERADA";
      							}
      							if ($nombre_descripcion == "03500339"){
                        $nombre_descripcion = "DISCAPACIDAD SEVERA";
      							}
      							if ($nombre_descripcion == "03500340"){
                        $nombre_descripcion = "DISCAPACIDAD PROFUNDA";
      							}

      							if ($nombre_descripcion == "03500341"){
                        $nombre_descripcion = "SIN DISCAPACIDAD";
      							}
      							if ($nombre_descripcion == "03500342"){
                        $nombre_descripcion = "DISCAPACIDAD LEVE";
      							}
      							if ($nombre_descripcion == "03500343"){
                        $nombre_descripcion = "DISCAPACIDAD MODERADA";
      							}
      							if ($nombre_descripcion == "03500344"){
                        $nombre_descripcion = "DISCAPACIDAD SEVERA";
      							}
      							if ($nombre_descripcion == "03500345"){
                        $nombre_descripcion = "DISCAPACIDAD PROFUNDA";
      							}

                    ?>
                    <tr>
                    <?php
							      if($i==0){?>
                    <td rowspan="5" style="text-align:center; vertical-align:middle">EVALUACIÓN INGRESO</td>
							      <?php
							      }
                    if($i==5){?>
                    <td rowspan="5" style="text-align:center; vertical-align:middle">EVALUACIÓN EGRESO</td>
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
                    <?php
                    $i++;
                }
                ?>
                </tr>
                <tr>
                    <td align='left' colspan="2"><strong>TOTAL DE EVALUACIONES</strong></td>
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
                </tr>
            </tbody>
        </table>
    </div>

    <br>

    <div class="col-sm tab table-responsive" id="D3">
        <table class="table table-hover table-bordered table-sm">
            <thead>
                <tr>
                    <td colspan="39" class="active"><strong>SECCION D.3: APLICACIÓN Y RESULTADO DE PAUTA DE EVALUACIÓN Y SALUD MENTAL.</strong></td>
                </tr>
                <tr>
                    <td colspan="2" rowspan="3" style="text-align:center; vertical-align:middle"><strong>RESULTADOS</strong></td>
                    <td colspan="3" rowspan="2" style="text-align:center; vertical-align:middle"><strong>TOTAL</strong></td>
                    <td colspan="34" align="center"><strong>POR EDAD</strong></td>
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
                          FROM  (select c.* from 2020prestaciones c where c.codigo_prestacion in("03500368","03500369","03500370","03500371","03500372","03500373")) a
                          left join 2020rems b on (a.id_prestacion=b.prestacion_id_prestacion)
                          AND (b.Mes in ('.$mes.')) AND (b.establecimiento_id_establecimiento in ('.$estab.'))
                          group by a.codigo_prestacion, a.descripcion, a.id_prestacion
                          order by a.id_prestacion';

                $registro = DB::connection('mysql_rem')->select($query);

                $i=0;

                foreach($registro as $row ){

                    $nombre_descripcion = $row->codigo_prestacion;
                    if ($nombre_descripcion == "03500368"){
      								$nombre_descripcion = "BAJO";
      							}
      							if ($nombre_descripcion == "03500369"){
      								$nombre_descripcion = "MEDIO";
      							}
      							if ($nombre_descripcion == "03500370"){
      								$nombre_descripcion = "ALTO";
      							}
      							if ($nombre_descripcion == "03500371"){
      								$nombre_descripcion = "BAJO";
      							}
      							if ($nombre_descripcion == "03500372"){
      								$nombre_descripcion = "MEDIO";
      							}
      							if ($nombre_descripcion == "03500373"){
      								$nombre_descripcion = "ALTO";
      							}

                                  ?>
                                  <tr>
                                  <?php
      							if($i==0){?>
      							  <td align='left' rowspan="3" style="text-align:center; vertical-align:middle">EVALUACION AL INGRESO</td>
                                  <?php
      							}
      							if($i==3){?>
      								<td align='left' rowspan="3" style="text-align:center; vertical-align:middle">EVALUACION AL EGRESO</td>
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
                    <?php
                    $i++;
                }
                ?>
                </tr>
            </tbody>
        </table>
    </div>

    <br>

    <div class="col-sm tab table-responsive" id="D4">
        <table class="table table-hover table-bordered table-sm">
            <thead>
                <tr>
                    <td colspan="15" class="active"><strong>SECCION D.4: RESULTADO DE APLICACIÓN DE CONDICIÓN DE FUNCIONALIDAD AL EGRESO PROGRAMA "MÁS ADULTOS MAYORES AUTOVALENTES".</strong></td>
                </tr>
                <tr>
                    <td rowspan="3" style="text-align:center; vertical-align:middle"><strong>ACTIVIDAD</strong></td>
                    <td rowspan="3" style="text-align:center; vertical-align:middle"><strong>RESULTADO</strong></td>
                    <td colspan="3" rowspan="2" style="text-align:center; vertical-align:middle"><strong>TOTAL</strong></td>
                    <td colspan="10" align="center"><strong>POR EDAD</strong></td>
                </tr>
                <tr>
                    <td colspan="2" align="center"><strong>60 a 64 años</strong></td>
                    <td colspan="2" align="center"><strong>65 a 69 años</strong></td>
                    <td colspan="2" align="center"><strong>70 a 74 años</strong></td>
                    <td colspan="2" align="center"><strong>75 a 79 años</strong></td>
                    <td colspan="2" align="center"><strong>80 y más años</strong></td>
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
                          FROM  (select c.* from 2020prestaciones c where c.codigo_prestacion in("03500350","03500351","03500352","03500353","03500354","03500355")) a
                          left join 2020rems b on (a.id_prestacion=b.prestacion_id_prestacion)
                          AND (b.Mes in ('.$mes.')) AND (b.establecimiento_id_establecimiento in ('.$estab.'))
                          group by a.codigo_prestacion, a.descripcion, a.id_prestacion
                          order by a.id_prestacion';

                $registro = DB::connection('mysql_rem')->select($query);

                $i=0;

                foreach($registro as $row ){

                    $nombre_descripcion = $row->codigo_prestacion;
                    if ($nombre_descripcion == "03500350"){
                        $nombre_descripcion = "MEJORA";
      							}
      							if ($nombre_descripcion == "03500351"){
                        $nombre_descripcion = "MANTIENE";
      							}
      							if ($nombre_descripcion == "03500352"){
                        $nombre_descripcion = "DISMINUYE";
      							}
      							if ($nombre_descripcion == "03500353"){
                        $nombre_descripcion = "MEJORA";
      							}
      							if ($nombre_descripcion == "03500354"){
                        $nombre_descripcion = "MANTIENE";
      							}
      							if ($nombre_descripcion == "03500355"){
                        $nombre_descripcion = "DISMINUYE";
      							}

                    ?>
                <tr>
                    <?php
      							if($i==0){?>
      							<td align='left' rowspan="3" style="text-align:center; vertical-align:middle">TIMED UP AND GO</td>
                    <?php
      							}
      							if($i==3){?>
      							<td align='left' rowspan="3" style="text-align:center; vertical-align:middle">CUESTIONARIO</td>
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
                    <?php
                    $i++;
                }
                ?>
                </tr>
            </tbody>
        </table>
    </div>

    <br>

    <div class="col-sm tab table-responsive" id="D5">
        <table class="table table-hover table-bordered table-sm">
            <thead>
                <tr>
                    <td colspan="16" class="active"><strong>D.5: VARIACION DE RESULTADO DE APLICACIÓN DEL ÍNDICE DE BARTHEL ENTRE EL INGRESO Y EGRESO HOSPITALARIO.</strong></td>
                </tr>
                <tr>
                    <td rowspan="3" style="text-align:center; vertical-align:middle"><strong>INDICE DE BARTHEL</strong></td>
                    <td colspan="3" rowspan="2" style="text-align:center; vertical-align:middle"><strong>TOTAL</strong></td>
                    <td colspan="12" align="center"><strong>POR EDAD</strong></td>
                </tr>
                <tr>
                    <td colspan="2" align="center"><strong>65 a 69 años</strong></td>
                    <td colspan="2" align="center"><strong>70 a 74 años</strong></td>
                    <td colspan="2" align="center"><strong>75 a 79 años</strong></td>
                    <td colspan="2" align="center"><strong>80 y 84 años</strong></td>
                    <td colspan="2" align="center"><strong>85 y 89 años</strong></td>
                    <td colspan="2" align="center"><strong>90 y más años</strong></td>
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
                          FROM  (select c.* from 2020prestaciones c where c.codigo_prestacion in("03500356","03500357","03500358")) a
                          left join 2020rems b on (a.id_prestacion=b.prestacion_id_prestacion)
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

                    $nombre_descripcion = $row->codigo_prestacion;
                    if ($nombre_descripcion == "03500356"){
                        $nombre_descripcion = "MEJORA PUNTUACIÓN ÍNDICE DE BARTHEL";
      							}
      							if ($nombre_descripcion == "03500357"){
                        $nombre_descripcion = "MANTIENE PUNTUACIÓN ÍNDICE DE BARTHEL";
      							}
      							if ($nombre_descripcion == "03500358"){
                        $nombre_descripcion = "DISMINUYE PUNTUACIÓN ÍNDICE DE BARTHEL";
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
                </tr>
                <tr>
                    <td align='left' colspan="16">** * El resultado que se consigna es la comparacion del indice de Barthel aplicado al Ingreso y Egreso de la Hospitalizacion.</td>
                </tr>
            </tbody>
        </table>
    </div>

    <br>

    <div class="col-sm tab table-responsive" id="D6">
        <table class="table table-hover table-bordered table-sm">
            <thead>
                <tr>
                    <td colspan="16" class="active"><strong>D.6: APLICACIÓN DE ESCALA ZARIT ABREVIADO EN CUIDADORES DE PERSONAS CON DEPENDENCIA SEVERA.</strong></td>
                </tr>
                <tr>
                    <td rowspan="3" style="text-align:center; vertical-align:middle"><strong>ESCALA DE SOBRECARGA DEL CUIDADOR "ZARIT ABREVIADO"</strong></td>
                    <td colspan="3" rowspan="2" style="text-align:center; vertical-align:middle"><strong>TOTAL</strong></td>
                    <td colspan="12" align="center"><strong>POR EDAD</strong></td>
                </tr>
                <tr>
                    <td colspan="2" align="center"><strong>10-14 años</strong></td>
                    <td colspan="2" align="center"><strong>15-19 años</strong></td>
                    <td colspan="2" align="center"><strong>20-24 años</strong></td>
                    <td colspan="2" align="center"><strong>25-44 años</strong></td>
                    <td colspan="2" align="center"><strong>45-64 años</strong></td>
                    <td colspan="2" align="center"><strong>65 o más</strong></td>
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
                          FROM  (select c.* from 2020prestaciones c where c.codigo_prestacion in("03500361","03500362")) a
                          left join 2020rems b on (a.id_prestacion=b.prestacion_id_prestacion)
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

                    $nombre_descripcion = $row->codigo_prestacion;
                    if ($nombre_descripcion == "03500361"){
                        $nombre_descripcion = "CUIDADORA (O) CON SOBRECARGA INTENSA";
                    }
                    if ($nombre_descripcion == "03500362"){
                        $nombre_descripcion = "CUIDADORA (O) SIN SOBRECARGA INTENSA";
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
                <tr>
                    <td align='left'><strong>TOTAL CUIDADORES EVALUADOS</strong></td>
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
                </tr>
            </tbody>
        </table>
    </div>

    <br>

    <div class="col-sm tab table-responsive" id="D7">
        <table class="table table-hover table-bordered table-sm">
            <thead>
                <tr>
                    <td colspan="21" class="active"><strong>D.7: APLICACIÓN Y RESULTADOS DE PAUTA DE EVALUACION CON ENFOQUE DE RIESGO ODONTOLOGICO (CERO).</strong></td>
                </tr>
                <tr>
                    <td rowspan="3" colspan="2" style="text-align:center; vertical-align:middle"><strong>PAUTA CERO</strong></td>
                    <td colspan="3" rowspan="2" style="text-align:center; vertical-align:middle"><strong>TOTAL</strong></td>
                    <td colspan="14" align="center"><strong>POR EDAD</strong></td>
                    <td colspan="2" rowspan="2" style="text-align:center; vertical-align:middle"><strong>NIÑOS Y NIÑAS RED SENAME</strong></td>
                </tr>
                <tr>
                    <td colspan="2" align="center"><strong><1 año</strong></td>
                    <td colspan="2" align="center"><strong>1 año</strong></td>
                    <td colspan="2" align="center"><strong>2 años</strong></td>
                    <td colspan="2" align="center"><strong>3 años</strong></td>
                    <td colspan="2" align="center"><strong>4 años</strong></td>
                    <td colspan="2" align="center"><strong>5 años</strong></td>
                    <td colspan="2" align="center"><strong>6 años</strong></td>
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
                          FROM  (select c.* from 2020prestaciones c where c.codigo_prestacion in("03500364","03500365")) a
                          left join 2020rems b on (a.id_prestacion=b.prestacion_id_prestacion)
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

                    $nombre_descripcion = $row->codigo_prestacion;
                    if ($nombre_descripcion == "03500364"){
                        $nombre_descripcion = "BAJO RIESGO ";
      							}
      							if ($nombre_descripcion == "03500365"){
                        $nombre_descripcion = "ALTO RIESGO";
      							}
                    ?>
                <tr>
                    <?php
      							if($i==0){
      							?>
      							<td nowrap="nowrap" rowspan="2" style="text-align:center; vertical-align:middle">EVALUACIÓN DE RIESGO</td>
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
                    <?php
                    $i++;
                }
                ?>
                </tr>
                <tr>
                    <td align='center' colspan="2"><strong>TOTAL</strong></td>
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
                    <td colspan="22" class="active"><strong>E: APLICACIÓN DE PAUTA DETECCIÓN DE FACTORES DE RIESGO PSICOSOCIAL INFANTIL.</strong></td>
                </tr>
                <tr>
                    <td rowspan="3"style="text-align:center; vertical-align:middle"><strong>EVALUACIÓN</strong></td>
                    <td colspan="3" rowspan="2" style="text-align:center; vertical-align:middle"><strong>TOTAL</strong></td>
                    <td colspan="10" align="center"><strong>POR EDAD</strong></td>
                    <td colspan="2" rowspan="2" style="text-align:center; vertical-align:middle"><strong>PUEBLOS ORIGINARIOS</strong></td>
                    <td colspan="2" rowspan="2" style="text-align:center; vertical-align:middle"><strong>MIGRANTES</strong></td>
                    <td colspan="4" align="center"><strong>DERIVACIÓN</strong></td>
                </tr>
                <tr>
                    <td colspan="2" align="center"><strong>Menor 7 meses</strong></td>
                    <td colspan="2" align="center"><strong>7 - 11 meses</strong></td>
                    <td colspan="2" align="center"><strong>12 - 23 meses</strong></td>
                    <td colspan="2" align="center"><strong>24- 48 meses</strong></td>
                    <td colspan="2" align="center"><strong>5 A 9 AÑOS</strong></td>
                    <td rowspan="2" style="text-align:center; vertical-align:middle"><strong>RIESGO</strong></td>
                    <td rowspan="2" style="text-align:center; vertical-align:middle"><strong>DERIVADAS A EQUIPOS DE CABECERA</strong></td>
                    <td rowspan="2" style="text-align:center; vertical-align:middle"><strong>DERIVADAS A MADI 0 4 AÑOS</strong></td>
                    <td rowspan="2" style="text-align:center; vertical-align:middle"><strong>DERIVADO A SALUD MENTAL 5 A 9 AÑOS</strong></td>
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
                          FROM  (select c.* from 2020prestaciones c where c.codigo_prestacion in("03500403")) a
                          left join 2020rems b on (a.id_prestacion=b.prestacion_id_prestacion)
                          AND (b.Mes in ('.$mes.')) AND (b.establecimiento_id_establecimiento in ('.$estab.'))
                          group by a.codigo_prestacion, a.descripcion, a.id_prestacion
                          order by a.id_prestacion';

                $registro = DB::connection('mysql_rem')->select($query);

                $i=0;

                foreach($registro as $row ){

                    $nombre_descripcion = $row->codigo_prestacion;
                    if ($nombre_descripcion == "03500403"){
                        $nombre_descripcion = "ESCALA DE  RIESGO PSICOSOCIAL EN CONTROL DE SALUD INFANTIL";
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
    <div class="container">
    <div class="col-sm tab table-responsive" id="F">
        <table class="table table-hover table-bordered table-sm">
            <thead>
                <tr>
                    <td colspan="22" class="active"><strong>SECCIÓN F: TAMIZAJE TRASTORNO ESPECTRO AUTISTA (MCHAT).</strong></td>
                </tr>
                <tr>
                    <td rowspan="2" style="text-align:center; vertical-align:middle"><strong>EVALUACIÓN</strong></td>
                    <td colspan="2" align="center"><strong>12 - 23 meses</strong></td>
                </tr>
                <tr>
                    <td align="center"><strong>Hombres</strong></td>
                    <td align="center"><strong>Mujeres</strong></td>
                </tr>
            </thead>
            <tbody>
                <?php
                $query = 'SELECT a.codigo_prestacion,a.descripcion
                              ,sum(ifnull(b.Col01,0)) Col01
                              ,sum(ifnull(b.Col02,0)) Col02
                          FROM  (select c.* from 2020prestaciones c where c.codigo_prestacion in("03500404","03500405","03500406","03500407")) a
                          left join 2020rems b on (a.id_prestacion=b.prestacion_id_prestacion)
                          AND (b.Mes in ('.$mes.')) AND (b.establecimiento_id_establecimiento in ('.$estab.'))
                          group by a.codigo_prestacion, a.descripcion, a.id_prestacion
                          order by a.id_prestacion';

                $registro = DB::connection('mysql_rem')->select($query);

                $i=0;

                foreach($registro as $row ){

                    $nombre_descripcion = $row->codigo_prestacion;
                    if ($nombre_descripcion == "03500404"){
                        $nombre_descripcion = "Niños/as con Control a los 18 meses";
      							}
                    if ($nombre_descripcion == "03500405"){
                        $nombre_descripcion = "Niños/as con alteracion de area Lenguaje y/o Social en Control de los 18 meses";
      							}
                    if ($nombre_descripcion == "03500406"){
                        $nombre_descripcion = "Niños/as con Tamizaje Trastorno Espectro Autista (MCHAT) realizado   con alteracion del area de lenguaje y/o Social en el control de los 18 meses";
      							}
                    if ($nombre_descripcion == "03500407"){
                        $nombre_descripcion = "Niños/as con Tamizaje Trastorno Espectro Autista (MCHAT) alterado y  con alteracion del area de lenguaje y/o Social en el control";
      							}
                    ?>
                <tr>
                    <td align='left'><?php echo $nombre_descripcion; ?></td>
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
    </div>
<?php
}
?>

@endsection

@section('custom_js')
    <script src="{{ asset('js/show_hide_tab.js') }}" defer></script>
    <script src="{{ asset('js/bootstrap-multiselect.js') }}" defer></script>
@endsection
