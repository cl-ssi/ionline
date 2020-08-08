@extends('layouts.app')

@section('title', 'Resumen Estadistico Mensual')

@section('content')

<?php

use Illuminate\Support\Facades\DB;

?>

@include('indicators.rem.partials.nav')

<h3>REM-21. QUIROFANOS Y OTROS RECURSOS HOSPITALARIOS.</h3>

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
                    <td colspan="7" class="active"><strong>SECCIÓN B: PROCEDIMIENTOS COMPLEJOS AMBULATORIOS.</strong></td>
                </tr>
                <tr>
                    <td align="center"><strong>COMPONENTES</strong></td>
                    <td align="center" width="10%"><strong>TOTAL</strong></td>
                    <td align="center"><strong>QUIMIOTERAPIA</strong></td>
                    <td align="center"><strong>HEMODIÁLISIS</strong></td>
                    <td align="center"><strong>CIRUGÍA MAYOR AMBULATORIA</strong></td>
                    <td align="center"><strong>CORONARIOGRAFÍA</strong></td>
                    <td align="center"><strong>OTRAS</strong></td>
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
                          FROM (select c.* from 2019prestaciones c where c.codigo_prestacion in("21220800","21400300","21220900","21300100","21400400")) a
                          left join 2019rems b on (a.id_prestacion=b.prestacion_id_prestacion)
                          AND (b.Mes in ('.$mes.')) AND (b.establecimiento_id_establecimiento in ('.$estab.'))
                          group by a.codigo_prestacion, a.descripcion, a.id_prestacion
                          order by a.id_prestacion';
                $registro = DB::connection('mysql_rem')->select($query);

                $i=0;

                foreach($registro as $row ){
                    $nombre_descripcion = $row->codigo_prestacion;
                    if ($nombre_descripcion == "21220800"){
                        $nombre_descripcion = "RECURSO DISPONIBLE";
      							}
      							if ($nombre_descripcion == "21400300"){
                        $nombre_descripcion = "INGRESOS";
      							}
      							if ($nombre_descripcion == "21220900"){
                        $nombre_descripcion = "PERSONAS ATENDIDAS";
      							}
      							if ($nombre_descripcion == "21300100"){
                        $nombre_descripcion = "DÍAS PERSONAS ATENDIDAS";
      							}
      							if ($nombre_descripcion == "21400400"){
                        $nombre_descripcion = "ALTAS";
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
            </tbody>
        </table>
    </div>

    <br>

    <div class="container">
    <!-- SECCION C1 -->
    <div class="col-sm tab table-responsive" id="A">
        <table class="table table-hover table-bordered table-sm">
            <thead>
                <tr>
                    <td colspan="2" class="active"><strong>SECCIÓN C:  HOSPITALIZACIÓN DOMICILIARIA.</strong></td>
                </tr>
                <tr>
                    <td colspan="2" class="active"><strong>SECCIÓN C.1:  PERSONAS ATENDIDAS EN EL PROGRAMA.</strong></td>
                </tr>
                <tr>
                    <td align="center"><strong>COMPONENTES</strong></td>
                    <td align="center"><strong>TOTAL</strong></td>
                </tr>
            </thead>
            <tbody>
                <?php
                $query = 'SELECT a.codigo_prestacion,a.descripcion
                              ,sum(ifnull(b.Col01,0)) Col01
                          FROM (select c.* from 2019prestaciones c where c.codigo_prestacion in("21400500","21400600","21400700","21300600","21300700","21800810")) a
                          left join 2019rems b on (a.id_prestacion=b.prestacion_id_prestacion)
                          AND (b.Mes in ('.$mes.')) AND (b.establecimiento_id_establecimiento in ('.$estab.'))
                          group by a.codigo_prestacion, a.descripcion, a.id_prestacion
                          order by a.id_prestacion';
                $registro = DB::connection('mysql_rem')->select($query);

                $i=0;

                foreach($registro as $row ){
                    $nombre_descripcion = $row->codigo_prestacion;
                    if ($nombre_descripcion == "21400500"){
                        $nombre_descripcion = "INGRESOS";
      							}
      							if ($nombre_descripcion == "21400600"){
                        $nombre_descripcion = "PERSONAS ATENDIDAS";
      							}
      							if ($nombre_descripcion == "21400700"){
                        $nombre_descripcion = "DIAS PERSONAS ATENDIDAS";
      							}
      							if ($nombre_descripcion == "21300600"){
                        $nombre_descripcion = "ALTAS";
      							}
      							if ($nombre_descripcion == "21300700"){
                        $nombre_descripcion = "FALLECIDOS";
      							}
      							if ($nombre_descripcion == "21800810"){
                        $nombre_descripcion = "REINGRESOS A HOSPITALIZACIÓN TRADICIONAL";
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

    <!-- SECCION C2 -->
    <div class="col-sm tab table-responsive" id="A">
        <table class="table table-hover table-bordered table-sm">
            <thead>
                <tr>
                    <td colspan="6" class="active"><strong>SECCIÓN C.2: VISITAS REALIZADAS.</strong></td>
                </tr>
                <tr>
                    <td align="center"><strong>COMPONENTE</strong></td>
                    <td align="center" width="10%"><strong>TOTAL</strong></td>
                    <td align="center"><strong>UN PROFESIONAL</strong></td>
                    <td align="center"><strong>DOS O MÁS PROFESIONALES</strong></td>
                    <td align="center"><strong>UN PROFESIONAL Y UN TÉCNICO PARAMÉDICO</strong></td>
                    <td align="center"><strong>SÓLO TÉCNICO PARAMÉDICO</strong></td>
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
                          FROM (select c.* from 2019prestaciones c where c.codigo_prestacion in("21800820")) a
                          left join 2019rems b on (a.id_prestacion=b.prestacion_id_prestacion)
                          AND (b.Mes in ('.$mes.')) AND (b.establecimiento_id_establecimiento in ('.$estab.'))
                          group by a.codigo_prestacion, a.descripcion, a.id_prestacion
                          order by a.id_prestacion';
                $registro = DB::connection('mysql_rem')->select($query);

                $i=0;

                foreach($registro as $row ){
                    $nombre_descripcion = $row->codigo_prestacion;
                    if ($nombre_descripcion == "21800820"){
                        $nombre_descripcion = "VISITAS REALIZADAS A PERSONAS EN HOSPITALIZACIÓN DOMICILIARIA";
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
            </tbody>
        </table>
    </div>

    <br>

    <!-- SECCION D1 -->
    <div class="col-sm tab table-responsive" id="D1">
        <table class="table table-hover table-bordered table-sm">
            <thead>
                <tr>
                    <td colspan="3" class="active"><strong>SECCIÓN D: HOSPITAL AMIGO.</strong></td>
                </tr>
                <tr>
                    <td colspan="3" class="active"><strong>SECCIÓN D.1: ACOMPAÑAMIENTO A HOSPITALIZADOS.</strong></td>
                </tr>
                <tr>
                    <td align="center"><strong>COMPONENTES</strong></td>
                    <td align="center"><strong>Menores de  15 años</strong></td>
                    <td align="center"><strong>60 y más años</strong></td>
                </tr>
            </thead>
            <tbody>
                <?php
                $query = 'SELECT a.codigo_prestacion,a.descripcion
                              ,sum(ifnull(b.Col01,0)) Col01
                              ,sum(ifnull(b.Col02,0)) Col02
                          FROM (select c.* from 2019prestaciones c where c.codigo_prestacion in("21400800","21400900","21500100","21500200")) a
                          left join 2019rems b on (a.id_prestacion=b.prestacion_id_prestacion)
                          AND (b.Mes in ('.$mes.')) AND (b.establecimiento_id_establecimiento in ('.$estab.'))
                          group by a.codigo_prestacion, a.descripcion, a.id_prestacion
                          order by a.id_prestacion';
                $registro = DB::connection('mysql_rem')->select($query);

                $i=0;

                foreach($registro as $row ){
                    $nombre_descripcion = $row->codigo_prestacion;
                    if ($nombre_descripcion == "21400800"){
                        $nombre_descripcion = "TOTAL DÍAS CAMAS OCUPADAS";
      							}
      							if ($nombre_descripcion == "21400900"){
                        $nombre_descripcion = "DÍAS CAMAS OCUPADAS CON ACOMPAÑAMIENTO DIURNO (*)";
      							}
      							if ($nombre_descripcion == "21500100"){
                        $nombre_descripcion = "DÍAS CAMAS OCUPADAS CON ACOMPAÑAMIENTO DIURNO MÍNIMO DE 6 HORAS (*)";
      							}
      							if ($nombre_descripcion == "21500200"){
                        $nombre_descripcion = "DÍAS CAMAS OCUPADAS CON ACOMPAÑAMIENTO NOCTURNO";
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
                <tr>
                    <td colspan="3">(*) Excluye acompañamiento en horario de visita diaria</td>
                </tr>
            </tbody>
        </table>
    </div>

    <br>

    <!-- SECCION D2 -->
    <div class="col-sm tab table-responsive" id="D2">
        <table class="table table-hover table-bordered table-sm">
            <thead>
                <tr>
                    <td colspan="3" class="active"><strong>SECCIÓN D.2: INFORMACIÓN A FAMILIARES DE PACIENTES EGRESADOS.</strong></td>
                </tr>
                <tr>
                    <td align="center"><strong>CONCEPTO</strong></td>
                    <td align="center"><strong>Menores de  15 años</strong></td>
                    <td align="center"><strong>60 y más años</strong></td>
                </tr>
            </thead>
            <tbody>
                <?php
                $query = 'SELECT a.codigo_prestacion,a.descripcion
                              ,sum(ifnull(b.Col01,0)) Col01
                              ,sum(ifnull(b.Col02,0)) Col02
                          FROM (select c.* from 2019prestaciones c where c.codigo_prestacion in("21800830","21800840")) a
                          left join 2019rems b on (a.id_prestacion=b.prestacion_id_prestacion)
                          AND (b.Mes in ('.$mes.')) AND (b.establecimiento_id_establecimiento in ('.$estab.'))
                          group by a.codigo_prestacion, a.descripcion, a.id_prestacion
                          order by a.id_prestacion';
                $registro = DB::connection('mysql_rem')->select($query);

                $i=0;

                foreach($registro as $row ){
                    $nombre_descripcion = $row->codigo_prestacion;
                    if ($nombre_descripcion == "21800830"){
                        $nombre_descripcion = "TOTAL DE EGRESOS (en el periodo)";
      							}
      							if ($nombre_descripcion == "21800840"){
                        $nombre_descripcion = "EGRESADOS CON INFORMACIÓN U ORIENTACIÓN A FAMILIARES AL MOMENTO DEL ALTA";
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
            </tbody>
        </table>
    </div>
    </div>

    <br>

    <!-- SECCION E -->
    <div class="col-sm tab table-responsive" id="E">
        <table class="table table-hover table-bordered table-sm">
            <thead>
                <tr>
                    <td colspan="9" class="active"><strong>SECCIÓN E: APOYO PSICOSOCIAL EN NIÑOS (AS) HOSPITALIZADOS.</strong></td>
                </tr>
                <tr>
                    <td align="center" width="15%"><strong>CONCEPTO</strong></td>
                    <td align="center"><strong>INTERVENCIÓN</strong></td>
                    <td align="center" width="10%"><strong>TOTAL</strong></td>
                    <td align="center"><strong>Hasta 28 días</strong></td>
                    <td align="center"><strong>29 dias hasta menor de 1 año</strong></td>
                    <td align="center"><strong>1 a 4 años</strong></td>
                    <td align="center"><strong>5 a 9 años</strong></td>
                    <td align="center"><strong>10 a 14 años</strong></td>
                    <td align="center"><strong>15 a 19 años</strong></td>
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
                          FROM (select c.* from 2019prestaciones c where c.codigo_prestacion in("21500300","21800850","21800860","21800870","21800880")) a
                          left join 2019rems b on (a.id_prestacion=b.prestacion_id_prestacion)
                          AND (b.Mes in ('.$mes.')) AND (b.establecimiento_id_establecimiento in ('.$estab.'))
                          group by a.codigo_prestacion, a.descripcion, a.id_prestacion
                          order by a.id_prestacion';
                $registro = DB::connection('mysql_rem')->select($query);

                $i=0;

                foreach($registro as $row ){
                    $nombre_descripcion = $row->codigo_prestacion;
                    if ($nombre_descripcion == "21500300"){
                        $nombre_descripcion = "TOTAL DE EGRESOS (en el período)";
      							}
      							if ($nombre_descripcion == "21800850"){
                        $nombre_descripcion = "INTERVENCIÓN PSICOSOCIAL";
      							}
      							if ($nombre_descripcion == "21800860"){
                        $nombre_descripcion = "ESTIMULACIÓN DEL DESARROLLO";
      							}

      							if ($nombre_descripcion == "21800870"){
                        $nombre_descripcion = "INTERVENCIÓN PSICOSOCIAL";
      							}
      							if ($nombre_descripcion == "21800880"){
                        $nombre_descripcion = "ESTIMULACIÓN DEL DESARROLLO";
      							}
                ?>
                <tr>
                    <?php
							      if($i==0){?>
                    <td colspan="2" align='left' nowrap="nowrap"><?php echo $nombre_descripcion; ?></td>
                    <?php
                    }
                    if($i==1){?>
                    <td rowspan="2" style="text-align:center; vertical-align:middle">EGRESADOS CON APOYO PSICOSOCIAL (en el período)</td>
                    <?php
                    }
                    if($i>=1 && $i<=2){?>
                    <td align='left' nowrap="nowrap"><?php echo $nombre_descripcion; ?></td>
                    <?php
                    }
                    if($i==3){?>
                    <td rowspan="2" style="text-align:center; vertical-align:middle">Nº DE ATENCIONES (en el mes)</td>
                    <?php
                    }
                    if($i>=3 && $i<=4){?>
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
                    <?php
                    $i++;
                }
                ?>
            </tbody>
        </table>
    </div>

    <br>

    <!-- SECCION F -->
    <div class="col-sm tab table-responsive" id="F">
        <table class="table table-hover table-bordered table-sm">
            <thead>
                <tr>
                    <td colspan="9" class="active"><strong>SECCIÓN F: GESTIÓN DE PROCESOS DE PACIENTES QUIRÚRGICOS CON CIRUGÍA ELECTIVA.</strong></td>
                </tr>
                <tr>
                    <td rowspan="3" style="text-align:center; vertical-align:middle"><strong>ESPECIALIDAD</strong></td>
                    <td colspan="2" rowspan="2" style="text-align:center; vertical-align:middle"><strong>DIAS DE ESTADA PREQUIRÚRGICOS</strong></td>
                    <td colspan="2" rowspan="2" style="text-align:center; vertical-align:middle"><strong>PACIENTES INTERVENIDOS</strong></td>
                    <td colspan="4" align="center"><strong>PROGRAMACIÓN DE TABLA QUIRÚRGICA (N° DE PACIENTES)</strong></td>
                </tr>
                <tr>
                    <td colspan="2" align="center"><strong>PACIENTES PROGRAMADOS</strong></td>
                    <td colspan="2" align="center"><strong>PACIENTES SUSPENDIDOS</strong></td>
                </tr>
                <tr>
                    <td align="center"><strong>Menores de 15 años</strong></td>
                    <td align="center"><strong>15 años y más</strong></td>
                    <td align="center"><strong>Menores de 15 años</strong></td>
                    <td align="center"><strong>15 años y más</strong></td>
                    <td align="center"><strong>Menores de 15 años</strong></td>
                    <td align="center"><strong>15 años y más</strong></td>
                    <td align="center"><strong>Menores de 15 años</strong></td>
                    <td align="center"><strong>15 años y más</strong></td>
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
                          FROM (select c.* from 2019prestaciones c where c.codigo_prestacion in("21500600","21600800","21600900","21700100","21500700","21500800","21700300","21700400",
                                                                                                "21700500","21700600","21500900","21700700")) a
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

                foreach($registro as $row ){
                    $totalCol01=$totalCol01+$row->Col01;
                    $totalCol02=$totalCol02+$row->Col02;
                    $totalCol03=$totalCol03+$row->Col03;
                    $totalCol04=$totalCol04+$row->Col04;
                    $totalCol05=$totalCol05+$row->Col05;
                    $totalCol06=$totalCol06+$row->Col06;
                    $totalCol07=$totalCol07+$row->Col07;
                    $totalCol08=$totalCol08+$row->Col08;

                    $nombre_descripcion = $row->codigo_prestacion;
                    if ($nombre_descripcion == "21500600"){
                        $nombre_descripcion = "CIRUGÍA GENERAL";
      							}
      							if ($nombre_descripcion == "21600800"){
                        $nombre_descripcion = "CIRUGÍA CARDIOVASCULAR";
      							}
      							if ($nombre_descripcion == "21600900"){
                        $nombre_descripcion = "CIRUGÍA MÁXILOFACIAL";
      							}
      							if ($nombre_descripcion == "21700100"){
                        $nombre_descripcion = "CIRUGÍA TÓRAX";
      							}
      							if ($nombre_descripcion == "21500700"){
                        $nombre_descripcion = "TRAUMATOLOGÍA";
      							}
      							if ($nombre_descripcion == "21500800"){
                        $nombre_descripcion = "NEUROCIRUGÍA";
      							}
      							if ($nombre_descripcion == "21700300"){
                        $nombre_descripcion = "OTORRINOLARINGOLOGÍA";
      							}
      							if ($nombre_descripcion == "21700400"){
                        $nombre_descripcion = "OFTALMOLOGÍA";
      							}
      							if ($nombre_descripcion == "21700500"){
                        $nombre_descripcion = "OBSTETRICIA Y GINECOLOGÍA";
      							}
      							if ($nombre_descripcion == "21700600"){
                        $nombre_descripcion = "GINECOLOGÍA";
      							}
      							if ($nombre_descripcion == "21500900"){
                        $nombre_descripcion = "UROLOGÍA";
      							}
      							if ($nombre_descripcion == "21700700"){
                        $nombre_descripcion = "RESTO ESPECIALIDADES";
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
                </tr>
            </tbody>
        </table>
    </div>

    <br>

    <div class="container">
    <!-- SECCION F -->
    <div class="col-sm tab table-responsive" id="G">
        <table class="table table-hover table-bordered table-sm">
            <thead>
                <tr>
                    <td colspan="7" class="active"><strong>SECCIÓN G: CAUSAS DE SUSPENSIÓN DE CIRUGIAS ELECTIVAS.</strong></td>
                </tr>
                <tr>
                    <td rowspan="2" style="text-align:center; vertical-align:middle"><strong>CAUSAS DE SUSPENSIÓN ATRIBUÍBLES A:</strong></td>
                    <td colspan="6" align="center"><strong>Nº DE PERSONAS</strong></td>
                </tr>
                <tr>
                    <td align="center"><strong>TOTALES</strong></td>
                    <td align="center"><strong>Menores de 15 años</strong></td>
                    <td align="center"><strong>15 años y más</strong></td>
                    <td align="center"><strong>Beneficiarios MAI</strong></td>
                    <td align="center"><strong>Beneficiarios MLE</strong></td>
                    <td align="center"><strong>Otros</strong></td>
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
                          FROM (select c.* from 2019prestaciones c where c.codigo_prestacion in("21700701","21700702","21700703","21700704","21700705","21700706","21800890")) a
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
                    if ($nombre_descripcion == "21700701"){
                        $nombre_descripcion = "PACIENTES";
      							}
      							if ($nombre_descripcion == "21700702"){
                        $nombre_descripcion = "ADMINISTRATIVAS";
      							}
      							if ($nombre_descripcion == "21700703"){
                        $nombre_descripcion = "UNIDAD DE APOYO CLÍNICO";
      							}
      							if ($nombre_descripcion == "21700704"){
                        $nombre_descripcion = "EQUIPO QUIRÚRGICO";
      							}
      							if ($nombre_descripcion == "21700705"){
                        $nombre_descripcion = "INFRAESTRUCTURA";
      							}
      							if ($nombre_descripcion == "21700706"){
                        $nombre_descripcion = "EMERGENCIAS";
      							}
      							if ($nombre_descripcion == "21700707"){
                        $nombre_descripcion = "ATAQUE DE TERCEROS";
      							}
      							if ($nombre_descripcion == "21800890"){
                        $nombre_descripcion = "GREMIALES";
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
