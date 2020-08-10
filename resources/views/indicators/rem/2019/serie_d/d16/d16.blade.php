@extends('layouts.app')

@section('title', 'Resumen Estadistico Mensual')

@section('content')

<?php

use Illuminate\Support\Facades\DB;

?>

@include('indicators.rem.partials.navD')

<h3>REM-D.16. Programa de Alimentación Complementaria del Adulto Mayor (PACAM).</h3>

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

    <div class="container">
    <!-- SECCION A -->
    <div class="col-sm tab table-responsive" id="A">
        <table class="table table-hover table-bordered table-sm">
            <thead>
                <tr>
                    <td colspan="3" class="active"><strong>Sección A: PACAM - Cantidad distribuida (kg).</strong></td>
                </tr>
                <tr>
                    <td align="center"><strong>Grupo Programático</strong></td>
                    <td align="center"><strong>Crema Años Dorados (CAD)</strong></td>
                    <td align="center"><strong>Bebida Láctea Años Dorados (BLAD)</strong></td>
                </tr>
            </thead>
            <tbody>
                <?php
                $query = 'SELECT a.codigo_prestacion,a.descripcion
                              ,sum(ifnull(b.Col01,0)) Col01
                              ,sum(ifnull(b.Col02,0)) Col02
                          FROM (select c.* from 2019prestaciones c where c.codigo_prestacion in("16090300","16200210","16090500","16090600","16090100")) a
                          left join 2019rems b on (a.id_prestacion=b.prestacion_id_prestacion)
                          AND (b.Mes in ('.$mes.')) AND (b.establecimiento_id_establecimiento in ('.$estab.'))
                          group by  a.codigo_prestacion,a.descripcion,a.id_prestacion
                          order by a.id_prestacion';
                $registro = DB::connection('mysql_rem')->select($query);

                $i=0;

                $totalCol01=0;
    						$totalCol02=0;

                foreach($registro as $row ){
                    $totalCol01=$totalCol01+$row->Col01;
                    $totalCol02=$totalCol02+$row->Col02;

                    $nombre_descripcion = $row->codigo_prestacion;
                    if ($nombre_descripcion == "16090300"){
                        $nombre_descripcion = "70 años y más (independiente del motivo de ingreso)";
                    }
                    if ($nombre_descripcion == "16200210"){
                        $nombre_descripcion = "65 - 69 años con alteración de la funcionalidad";
                    }
                    if ($nombre_descripcion == "16090500"){
                        $nombre_descripcion = "65 - 69 años en programa social (Vínculos, Familia, Calle u otro)";
                    }
                    if ($nombre_descripcion == "16090600"){
                        $nombre_descripcion = "60 - 69 años con tuberculosis";
                    }
                    if ($nombre_descripcion == "16090100"){
                        $nombre_descripcion = "60 - 69 años en ELEAM autorizado o similar";
                    }

                    ?>
                <tr>
                    <td align='left' nowrap="nowrap"><?php echo $nombre_descripcion; ?></td>
                    <td align='right'><?php echo number_format($row->Col01,2,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col02,0,",",".")?></td>
                    <?php
                    $i++;
                }
                ?>
                </tr>
                <tr>
                    <td align='center'><strong>TOTAL</strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol01,2,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol02,0,",",".") ?></strong></td>
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
                    <td colspan="7" class="active"><strong>Sección B: PACAM - Número de personas que retiran).</strong></td>
                </tr>
                <tr>
                    <td rowspan="2" style="text-align:center; vertical-align:middle" width="35%"><strong>Grupo Programático</strong></td>
                    <td colspan="3" align="center"><strong>Crema Años Dorados (CAD)</strong></td>
                    <td colspan="3" align="center"><strong>Bebida Láctea Años Dorados (BLAD)</strong></td>
                </tr>
                <tr>
                    <td align="center"><strong>Personas (que retiran en el mes)</strong></td>
                    <td align="center"><strong>Ingresos del mes</strong></td>
                    <td align="center"><strong>Inasistentes del mes</strong></td>
                    <td align="center"><strong>Personas (que retiran en el mes)</strong></td>
                    <td align="center"><strong>Ingresos del mes</strong></td>
                    <td align="center"><strong>Inasistentes del mes</strong></td>
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
                          FROM (select c.* from 2019prestaciones c where c.codigo_prestacion in("16100300","16200220","16100600","16100700","16100100")) a
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

                foreach($registro as $row ){
                    $totalCol01=$totalCol01+$row->Col01;
                    $totalCol02=$totalCol02+$row->Col02;
                    $totalCol03=$totalCol03+$row->Col03;
                    $totalCol04=$totalCol04+$row->Col04;
                    $totalCol05=$totalCol05+$row->Col05;
                    $totalCol06=$totalCol06+$row->Col06;

                    $nombre_descripcion = $row->codigo_prestacion;
                    if ($nombre_descripcion == "16100300"){
                        $nombre_descripcion = "70 años y más (independiente del motivo de ingreso)";
                    }
                    if ($nombre_descripcion == "16200220"){
                        $nombre_descripcion = "65 - 69 años con alteración de la funcionalidad";
                    }
                    if ($nombre_descripcion == "16100600"){
                        $nombre_descripcion = "65 - 69 años en programa social (Vínculos, Familia, Calle u otro)";
                    }
                    if ($nombre_descripcion == "16100700"){
                        $nombre_descripcion = "60 - 69 años con tuberculosis";
                    }
                    if ($nombre_descripcion == "16100100"){
                        $nombre_descripcion = "60 - 69 años en ELEAM autorizado o similar";
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

    <br>

    <!-- SECCION D -->
    <div class="col-sm tab table-responsive" id="D">
        <table class="table table-hover table-bordered table-sm">
            <thead>
                <tr>
                    <td colspan="7" class="active"><strong>Sección D: PACAM - Número de personas que retiran, pertenecientes al PRAIS (incluidos en Sección B).</strong></td>
                </tr>
                <tr>
                    <td rowspan="2" style="text-align:center; vertical-align:middle" width="35%"><strong>Grupo Programático</strong></td>
                    <td colspan="3" align="center"><strong>Crema Años Dorados (CAD)</strong></td>
                    <td colspan="3" align="center"><strong>Bebida Láctea Años Dorados (BLAD)</strong></td>
                </tr>
                <tr>
                    <td align="center"><strong>Personas (que retiran en el mes)</strong></td>
                    <td align="center"><strong>Ingresos del mes</strong></td>
                    <td align="center"><strong>Inasistentes del mes</strong></td>
                    <td align="center"><strong>Personas (que retiran en el mes)</strong></td>
                    <td align="center"><strong>Ingresos del mes</strong></td>
                    <td align="center"><strong>Inasistentes del mes</strong></td>
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
                          FROM (select c.* from 2019prestaciones c where c.codigo_prestacion in("16200100","16200230","16200240","16200200","16200250")) a
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

                foreach($registro as $row ){
                    $totalCol01=$totalCol01+$row->Col01;
                    $totalCol02=$totalCol02+$row->Col02;
                    $totalCol03=$totalCol03+$row->Col03;
                    $totalCol04=$totalCol04+$row->Col04;
                    $totalCol05=$totalCol05+$row->Col05;
                    $totalCol06=$totalCol06+$row->Col06;

                    $nombre_descripcion = $row->codigo_prestacion;
                    if ($nombre_descripcion == "16200100"){
                        $nombre_descripcion = "70 años y más (independiente del motivo de ingreso)";
                    }
                    if ($nombre_descripcion == "16200230"){
                        $nombre_descripcion = "65 - 69 años con alteración de la funcionalidad";
                    }
                    if ($nombre_descripcion == "16200240"){
                        $nombre_descripcion = "65 - 69 años en programa social (Vínculos, Familia, Calle u otro)";
                    }
                    if ($nombre_descripcion == "16200200"){
                        $nombre_descripcion = "60 - 69 años con tuberculosis";
                    }
                    if ($nombre_descripcion == "16200250"){
                        $nombre_descripcion = "60 - 69 años en ELEAM autorizado o similar";
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
