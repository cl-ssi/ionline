@extends('layouts.app')

@section('title', 'Resumen Estadistico Mensual')

@section('content')

<?php

use Illuminate\Support\Facades\DB;

?>

@include('indicators.rem.partials.nav')

<h3>REM-19b. ACTIVIDADES DE PARTICIPACIÓN SOCIAL.</h3>

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
                    <td colspan="9" class="active"><strong>SECCIÓN A: ATENCIÓN OFICINAS DE INFORMACIONES (SISTEMA INTEGRAL DE ATENCIÓN A USUARIOS).</strong></td>
                </tr>
                <tr>
                    <td rowspan="2" style="text-align:center; vertical-align:middle"><strong>TIPO DE ATENCION</strong></td>
                    <td colspan="3" align="center"><strong>Nº DE ATENCIONES EN EL MES</strong></td>
                    <td colspan="2" align="center"><strong>RESPUESTAS DEL MES DENTRO DE PLAZOS LEGALES (15 DIAS HÁBILES)</strong></td>
                    <td rowspan="2" align="center"><strong>RECLAMOS RESPONDIDOS FUERA DE PLAZOS LEGALES</strong></td>
                    <td colspan="2" align="center"><strong>RECLAMOS PENDIENTES</strong></td>
                </tr>
                <tr>
                    <td align="center"><strong>Total</strong></td>
                    <td align="center"><strong>Hombres</strong></td>
                    <td align="center"><strong>Mujeres</strong></td>
                    <td align="center"><strong>Reclamos generados en el mes</strong></td>
                    <td align="center"><strong>Reclamos generados en el mes anterior</strong></td>
                    <td align="center"><strong>Respuestas pendientes dentro del plazo legal</strong></td>
                    <td align="center"><strong>Respuestas pendientes fuera del plazo legal</strong></td>
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
                          FROM (select c.* from 2020prestaciones c where c.codigo_prestacion in("19180400","19180500","19180600","19180700","19182070","19191010","19191020","19180800",
                                                                                                "19180900","19181000","19181001","19181002","19181003")) a
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

                foreach($registro as $row ){
                    $totalCol01=$totalCol01+$row->Col01;
                    $totalCol02=$totalCol02+$row->Col02;
                    $totalCol03=$totalCol03+$row->Col03;
                    $totalCol04=$totalCol04+$row->Col04;
                    $totalCol05=$totalCol05+$row->Col05;
                    $totalCol06=$totalCol06+$row->Col06;
                    $totalCol07=$totalCol07+$row->Col07;
                    $totalCol08=$totalCol08+$row->Col08;
                }
                ?>
                <tr>
                    <td align='left'><strong>TOTAL DE RECLAMOS</strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol01,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol02,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol03,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol04,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol05,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol06,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol07,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol08,0,",",".") ?></strong></td>
                </tr>
                <?php
                foreach($registro as $row ){
                    $nombre_descripcion = $row->codigo_prestacion;
                    if ($nombre_descripcion == "19180400"){
                        $nombre_descripcion = "TRATO";
      							}
      							if ($nombre_descripcion == "19180500"){
                        $nombre_descripcion = "COMPETENCIA TÉCNICA";
      							}
      							if ($nombre_descripcion == "19180600"){
                        $nombre_descripcion = "INFRAESTRUCTURA";
      							}
      							if ($nombre_descripcion == "19180700"){
                        $nombre_descripcion = "TIEMPO DE ESPERA (EN SALA DE ESPERA)";
      							}
      							if ($nombre_descripcion == "19182070"){
                        $nombre_descripcion = "TIEMPO DE ESPERA, POR CONSULTA ESPECIALIDAD (POR LISTA DE ESPERA)";
      							}
      							if ($nombre_descripcion == "19191010"){
                        $nombre_descripcion = "TIEMPO DE ESPERA, POR PROCEDIMIENTO (LISTA DE ESPERA)";
      							}
      							if ($nombre_descripcion == "19191020"){
                        $nombre_descripcion = "TIEMPO DE ESPERA , POR CIRUGÍA (LISTA DE ESPERA)";
      							}
      							if ($nombre_descripcion == "19180800"){
                        $nombre_descripcion = "INFORMACIÓN";
      							}
      							if ($nombre_descripcion == "19180900"){
                        $nombre_descripcion = "PROCEDIMIENTOS ADMINISTRATIVOS";
      							}
      							if ($nombre_descripcion == "19181000"){
                        $nombre_descripcion = "PROBIDAD ADMINISTRATIVA";
      							}
      							if ($nombre_descripcion == "19181001"){
                        $nombre_descripcion = "INCUMPLIMIENTO GARANTÍAS EXPLÍCITAS EN SALUD (GES)";
      							}
      							if ($nombre_descripcion == "19181002"){
                        $nombre_descripcion = "INCUMPLIMIENTO DE GARANTÍAS LEY RICARTE SOTO";
      							}
      							if ($nombre_descripcion == "19181003"){
                        $nombre_descripcion = "INCUMPLIMIENTO DE GARANTÍAS FOFAR";
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
                          FROM (select c.* from 2020prestaciones c where c.codigo_prestacion in("19140612","19140613","19140615","19182100","19182110")) a
                          left join 2020rems b on (a.id_prestacion=b.prestacion_id_prestacion)
                          AND (b.Mes in ('.$mes.')) AND (b.establecimiento_id_establecimiento in ('.$estab.'))
                          group by a.codigo_prestacion, a.descripcion, a.id_prestacion
                          order by a.id_prestacion';
                $registro = DB::connection('mysql_rem')->select($query);

                $i=0;

                foreach($registro as $row ){
                    $nombre_descripcion = $row->codigo_prestacion;
                    if ($nombre_descripcion == "19140612"){
                        $nombre_descripcion = "CONSULTAS";
      							}
      							if ($nombre_descripcion == "19140613"){
                        $nombre_descripcion = "SUGERENCIAS";
      							}
      							if ($nombre_descripcion == "19140615"){
                        $nombre_descripcion = "FELICITACIONES";
      							}
      							if ($nombre_descripcion == "19182100"){
                        $nombre_descripcion = "SOLICITUDES";
      							}
      							if ($nombre_descripcion == "19182110"){
                        $nombre_descripcion = "SOLICITUDES LEY 20.285 (Ley de Transparencia)";
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

    <!-- SECCION B -->
    <div class="col-sm tab table-responsive" id="B">
        <table class="table table-hover table-bordered table-sm">
            <thead>
                <tr>
                    <td colspan="12" class="active"><strong>SECCIÓN B: ACTIVIDADES POR ESTRATEGIA/LÍNEA DE ACCIÓN O ESPACIO / INSTANCIA DE PARTICIPACIÓN.</strong></td>
                </tr>
                <tr>
                    <td rowspan="2" style="text-align:center; vertical-align:middle" width="15%"><strong>TIPO DE ACTIVIDADES</strong></td>
                    <td colspan="4" align="center"><strong>ESPACIOS/INSTANCIAS</strong></td>
                    <td colspan="4" align="center"><strong>ESTRATEGIAS/LÍNEAS DE ACCIÓN</strong></td>
                    <td colspan="3" align="center"><strong>PARTICIPANTES</strong></td>
                </tr>
                <tr>
                    <td align="center"><strong>Consultas Ciudadanas</strong></td>
                    <td align="center"><strong>Consejo de la Sociedad Civil, Consejos consultivos, de desarrollo y comités locales</strong></td>
                    <td align="center"><strong>Consejos consultivos de Adolescentes y Jóvenes</strong></td>
                    <td align="center"><strong>Mesas: Territoriales, diálogos ciudadanos, mesa salud intercultural</strong></td>
                    <td align="center"><strong>Cuentas públicas participativas</strong></td>
                    <td align="center"><strong>Presupuestos participativos</strong></td>
                    <td align="center"><strong>Estrategias de satisfacción usuaria</strong></td>
                    <td align="center"><strong>Planificación local participativa (Diagnósticos, programación y evaluación)</strong></td>
                    <td align="center"><strong>Total participantes</strong></td>
                    <td align="center"><strong>Total hombres</strong></td>
                    <td align="center"><strong>Total mujeres</strong></td>
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
                          FROM (select c.* from 2020prestaciones c where c.codigo_prestacion in("19150600","19140616","19140617","19140618","19150700","19140620","19150860","19140621",
                                                                                                "19140622","19140623","19181100")) a
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

                    $nombre_descripcion = $row->codigo_prestacion;
                    if ($nombre_descripcion == "19150600"){
                        $nombre_descripcion = "ADMINISTRACIÓN Y GESTIÓN";
      							}
      							if ($nombre_descripcion == "19140616"){
                        $nombre_descripcion = "ENTREVISTAS";
      							}
      							if ($nombre_descripcion == "19140617"){
                        $nombre_descripcion = "REUNIONES INTRASECTOR";
      							}
      							if ($nombre_descripcion == "19140618"){
                        $nombre_descripcion = "REUNIONES INTERSECTOR";
      							}
      							if ($nombre_descripcion == "19150700"){
                        $nombre_descripcion = "ACTIVIDADES DE MONITOREO";
      							}
      							if ($nombre_descripcion == "19140620"){
                        $nombre_descripcion = "ASESORÍA TÉCNICA";
      							}
      							if ($nombre_descripcion == "19150860"){
                        $nombre_descripcion = "JORNADAS DE INTERCAMBIO DE EXPERIENCIAS";
      							}
      							if ($nombre_descripcion == "19140621"){
                        $nombre_descripcion = "ACTIVIDADES DE DIFUSIÓN Y COMUNICACIÓN";
      							}
      							if ($nombre_descripcion == "19140622"){
                        $nombre_descripcion = "EDUCACIÓN Y CAPACITACIÓN COMUNITARIA";
      							}
      							if ($nombre_descripcion == "19140623"){
                        $nombre_descripcion = "EVENTOS MASIVOS (ASAMBLEAS, CABILDOS, OTROS)";
      							}
      							if ($nombre_descripcion == "19181100"){
                        $nombre_descripcion = "ACTIVIDADES A PUEBLOS INDÍGENAS";
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
                    <?php
                    $i++;
                }
                ?>
                </tr>
                <tr>
                    <td align='left'><strong>TOTAL DE ACTIVIDADES</strong></td>
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
                          FROM (select c.* from 2020prestaciones c where c.codigo_prestacion in("19180300")) a
                          left join 2020rems b on (a.id_prestacion=b.prestacion_id_prestacion)
                          AND (b.Mes in ('.$mes.')) AND (b.establecimiento_id_establecimiento in ('.$estab.'))
                          group by a.codigo_prestacion, a.descripcion, a.id_prestacion
                          order by a.id_prestacion';
                $registro = DB::connection('mysql_rem')->select($query);

                $i=0;

                foreach($registro as $row ){
                    $nombre_descripcion = $row->codigo_prestacion;
                    if ($nombre_descripcion == "19180300"){
                        $nombre_descripcion = "ACTIVIDADES DE PARTICIPACIÓN SOCIAL POR TEC. PARAMÉDICO";
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
                    <td colspan="3" class="active"><strong>SECCIÓN C: REUNIONES DE ADULTO MAYOR.</strong></td>
                </tr>
                <tr>
                    <td align="center"><strong>TIPO DE REUNIÓN</strong></td>
                    <td align="center"><strong>TOTAL</strong></td>
                    <td align="center"><strong>CASOS INSTITUCIONALES</strong></td>
                </tr>
            </thead>
            <tbody>
                <?php
                $query = 'SELECT a.codigo_prestacion,a.descripcion
                              ,sum(ifnull(b.Col01,0)) Col01
                              ,sum(ifnull(b.Col02,0)) Col02
                          FROM (select c.* from 2020prestaciones c where c.codigo_prestacion in("19160800","19160900")) a
                          left join 2020rems b on (a.id_prestacion=b.prestacion_id_prestacion)
                          AND (b.Mes in ('.$mes.')) AND (b.establecimiento_id_establecimiento in ('.$estab.'))
                          group by a.codigo_prestacion, a.descripcion, a.id_prestacion
                          order by a.id_prestacion';
                $registro = DB::connection('mysql_rem')->select($query);

                $i=0;

                foreach($registro as $row ){
                    $nombre_descripcion = $row->codigo_prestacion;
                    if ($nombre_descripcion == "19160800"){
                        $nombre_descripcion = "CLÍNICAS";
      							}
      							if ($nombre_descripcion == "19160900"){
                        $nombre_descripcion = "CON INSTITUCIONES DE LARGA ESTADÍA";
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

    </div>
<?php
}
?>

@endsection

@section('custom_js')
    <script src="{{ asset('js/show_hide_tab.js') }}" defer></script>
    <script src="{{ asset('js/bootstrap-multiselect.js') }}" defer></script>
@endsection
