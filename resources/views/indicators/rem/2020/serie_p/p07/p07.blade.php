@extends('layouts.app')

@section('title', 'Resumen Estadistico Mensual')

@section('content')

<?php

use Illuminate\Support\Facades\DB;

?>

@include('indicators.rem.partials.navP')

<h3>REM-P7. FAMILIAS EN CONTROL DE SALUD FAMILIAR.</h3>

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
                    <td colspan="17" class="active"><strong>SECCIÓN A. CLASIFICACIÓN DE LAS FAMILIAS SECTOR URBANO.</strong></td>
                </tr>
                <tr>
                    <td align='center'><strong>CLASIFICACIÓN DE LAS FAMILIAS POR SECTOR</strong></td>
                    <td align='center'><strong>TOTAL</strong></td>
                    <td align='center'><strong>SECTOR 1</strong></td>
                    <td align='center'><strong>SECTOR 2</strong></td>
                    <td align='center'><strong>SECTOR 3</strong></td>
                    <td align='center'><strong>SECTOR 4</strong></td>
                    <td align='center'><strong>SECTOR 5</strong></td>
                    <td align='center'><strong>SECTOR 6</strong></td>
                    <td align='center'><strong>SECTOR 7</strong></td>
                    <td align='center'><strong>SECTOR 8</strong></td>
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

                          FROM (select c.* from 2020prestaciones c where c.codigo_prestacion in("P7010100","P7010200","P7010300","P7200100","P7200200") AND c.serie = "P") a
                          left join 2020rems b on (a.id_prestacion=b.prestacion_id_prestacion)
                          AND (b.Mes in ('.$mes.')) AND (b.establecimiento_id_establecimiento in ('.$estab.'))
                          group by  a.codigo_prestacion,a.descripcion,a.id_prestacion
                          order by a.id_prestacion';
                $registro = DB::connection('mysql_rem')->select($query);

                $i=0;

                foreach($registro as $row ){
                    $nombre_descripcion = $row->codigo_prestacion;
                    if ($nombre_descripcion == "P7010100"){
                        $nombre_descripcion = "N° DE FAMILIAS INSCRITAS";
                    }
                    if ($nombre_descripcion == "P7010200"){
                        $nombre_descripcion = "N° DE FAMILIAS EVALUADAS CON CARTOLA/ENCUESTA FAMILIAR";
                    }
                    if ($nombre_descripcion == "P7010300"){
                        $nombre_descripcion = "N° DE FAMILIAS EN RIESGO BAJO";
                    }
                    if ($nombre_descripcion == "P7200100"){
                        $nombre_descripcion = "N° DE FAMILIAS EN RIESGO MEDIO";
                    }
                    if ($nombre_descripcion == "P7200200"){
                        $nombre_descripcion = "N° DE FAMILIAS EN RIESGO ALTO";
                    }
                    /*
                    	CLASIFICACIÓN DE LAS FAMILIAS SECTOR URBANO -
                    	CLASIFICACIÓN DE LAS FAMILIAS SECTOR URBANO -
                    	CLASIFICACIÓN DE LAS FAMILIAS SECTOR URBANO -
                    	CLASIFICACIÓN DE LAS FAMILIAS SECTOR URBANO -
                    	CLASIFICACIÓN DE LAS FAMILIAS SECTOR URBANO -
                    */
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

    <br>

    <!-- SECCION A.1 -->
    <div class="col-sm tab table-responsive" id="A1">
        <table class="table table-hover table-bordered table-sm">
            <thead>
                <tr>
                    <td colspan="17" class="active"><strong>SECCIÓN A.1 CLASIFICACIÓN DE LAS FAMILIAS SECTOR RURAL.</strong></td>
                </tr>
                <tr>
                    <td align='center'><strong>CLASIFICACIÓN DE LAS FAMILIAS POR SECTOR</strong></td>
                    <td align='center'><strong>TOTAL</strong></td>
                    <td align='center'><strong>SECTOR 1</strong></td>
                    <td align='center'><strong>SECTOR 2</strong></td>
                    <td align='center'><strong>SECTOR 3</strong></td>
                    <td align='center'><strong>SECTOR 4</strong></td>
                    <td align='center'><strong>SECTOR 5</strong></td>
                    <td align='center'><strong>SECTOR 6</strong></td>
                    <td align='center'><strong>SECTOR 7</strong></td>
                    <td align='center'><strong>SECTOR 8</strong></td>
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

                          FROM (select c.* from 2020prestaciones c where c.codigo_prestacion in("P7010400","P7010500","P7010600","P7200300","P7200400") AND c.serie = "P") a
                          left join 2020rems b on (a.id_prestacion=b.prestacion_id_prestacion)
                          AND (b.Mes in ('.$mes.')) AND (b.establecimiento_id_establecimiento in ('.$estab.'))
                          group by  a.codigo_prestacion,a.descripcion,a.id_prestacion
                          order by a.id_prestacion';
                $registro = DB::connection('mysql_rem')->select($query);

                $i=0;

                foreach($registro as $row ){
                    $nombre_descripcion = $row->codigo_prestacion;
                    if ($nombre_descripcion == "P7010400"){
                        $nombre_descripcion = "N° DE FAMILIAS INSCRITAS";
                    }
                    if ($nombre_descripcion == "P7010500"){
                        $nombre_descripcion = "N° DE FAMILIAS EVALUADAS CON CARTOLA/ENCUESTA FAMILIAR";
                    }
                    if ($nombre_descripcion == "P7010600"){
                        $nombre_descripcion = "N° DE FAMILIAS EN RIESGO BAJO";
                    }
                    if ($nombre_descripcion == "P7200300"){
                        $nombre_descripcion = "N° DE FAMILIAS EN RIESGO MEDIO";
                    }
                    if ($nombre_descripcion == "P7200400"){
                        $nombre_descripcion = "N° DE FAMILIAS EN RIESGO ALTO";
                    }
                    /*
                    	CLASIFICACIÓN DE LAS FAMILIAS SECTOR RURAL - N° DE FAMILIAS INSCRITAS
                    	CLASIFICACIÓN DE LAS FAMILIAS SECTOR RURAL - N° DE FAMILIAS EVALUADAS CON CARTOLA/ESCUESTA FAMILIAR
                    	CLASIFICACIÓN DE LAS FAMILIAS SECTOR RURAL - N° DE FAMILIAS EN RIESGO BAJO
                    	CLASIFICACIÓN DE LAS FAMILIAS SECTOR RURAL - N° DE FAMILIAS EN RIESGO MEDIO
                    	CLASIFICACIÓN DE LAS FAMILIAS SECTOR RURAL - N° DE FAMILIAS EN RIESGO ALTO
                    */
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

    <br>

    <!-- SECCION B -->
    <div class="col-sm tab table-responsive" id="B">
        <table class="table table-hover table-bordered table-sm">
            <thead>
                <tr>
                    <td colspan="17" class="active"><strong>SECCIÓN B. INTERVENCIÓN EN FAMILIAS SECTOR URBANO Y RURAL.</strong></td>
                </tr>
                <tr>
                    <td colspan="2" align='center'><strong>INTERVENCIÓN EN FAMILIAS</strong></td>
                    <td align='center'><strong>TOTAL</strong></td>
                    <td align='center'><strong>SECTOR 1</strong></td>
                    <td align='center'><strong>SECTOR 2</strong></td>
                    <td align='center'><strong>SECTOR 3</strong></td>
                    <td align='center'><strong>SECTOR 4</strong></td>
                    <td align='center'><strong>SECTOR 5</strong></td>
                    <td align='center'><strong>SECTOR 6</strong></td>
                    <td align='center'><strong>SECTOR 7</strong></td>
                    <td align='center'><strong>SECTOR 8</strong></td>
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

                          FROM (select c.* from 2020prestaciones c where c.codigo_prestacion in("P7200500",
                                                                                                "P7201200","P7201300","P7201400","P7201500",
                                                                                                "P7200700","P7200800","P7200900","P7201000","P7201100") AND c.serie = "P") a
                          left join 2020rems b on (a.id_prestacion=b.prestacion_id_prestacion)
                          AND (b.Mes in ('.$mes.')) AND (b.establecimiento_id_establecimiento in ('.$estab.'))
                          group by  a.codigo_prestacion,a.descripcion,a.id_prestacion
                          order by a.id_prestacion';
                $registro = DB::connection('mysql_rem')->select($query);

                $i=0;

                foreach($registro as $row ){
                    $nombre_descripcion = $row->codigo_prestacion;
                    if ($nombre_descripcion == "P7200500"){
                        $nombre_descripcion = "N° FAMILIAS CON PLAN DE INTERVENCIÓN";
                    }

                    if ($nombre_descripcion == "P7201200"){
                        $nombre_descripcion = "SIN RIESGO";
                    }
                    if ($nombre_descripcion == "P7201300"){
                        $nombre_descripcion = "RIESGO BAJO";
                    }
                    if ($nombre_descripcion == "P7201400"){
                        $nombre_descripcion = "RIESGO MEDIO";
                    }
                    if ($nombre_descripcion == "P7201500"){
                        $nombre_descripcion = "ALTO";
                    }

                    if ($nombre_descripcion == "P7200700"){
                        $nombre_descripcion = "TOTAL DE EGRESOS";
                    }
                    if ($nombre_descripcion == "P7200800"){
                        $nombre_descripcion = "ALTA POR CUMPLIR PLAN DE INTERVENCION";
                    }
                    if ($nombre_descripcion == "P7200900"){
                        $nombre_descripcion = "TRASLADO DE ESTABLECIMIENTO";
                    }
                    if ($nombre_descripcion == "P7201000"){
                        $nombre_descripcion = "DERIVACIÓN POR COMPLEJIDAD DEL CASO";
                    }
                    if ($nombre_descripcion == "P7201100"){
                        $nombre_descripcion = "POR ABANDONO";
                    }
                    ?>
                <tr>
                    <?php
                    if($i==0){?>
                    <td colspan="2" align="center"><?php echo $nombre_descripcion; ?></td>
                    <?php
                    }
                    if($i==1){?>
                    <td rowspan="4" style="text-align:center; vertical-align:middle">N° FAMILIAS SIN PLAN DE INTERVENCIÓN</td>
                    <?php
                    }
                    if($i>=1 && $i<=4){?>
                    <td align="left"><?php echo $nombre_descripcion; ?></td>
                    <?php
                    }
                    if($i==5){?>
                    <td rowspan="5" style="text-align:center; vertical-align:middle">N° FAMILIAS EGRESADAS DE PLANES DE INTERVENCIÓN</td>
                    <?php
                    }
                    if($i>=5){?>
                    <td align="left"><?php echo $nombre_descripcion; ?></td>
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
