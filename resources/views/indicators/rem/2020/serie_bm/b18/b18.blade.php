@extends('layouts.app')

@section('title', 'Resumen Estadistico Mensual')

@section('content')

<?php

use Illuminate\Support\Facades\DB;

?>

@include('indicators.rem.partials.navBM')

<h3>REM-B18. ACTIVIDADES DE APOYO DIAGNOSTICO y TERAPEUTICO.</h3>
<h6 class="mb-3">(USO EXCLUSIVO DE ESTABLECIMIENTOS MUNICIPALES)</h6>

<br>

@include('indicators.rem.2020.serie_bm.search')

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

    <div class="container">

    <div id="contenedor">
    <!-- SECCION A -->
    <div class="col-sm tab table-responsive" id="A">
        <table class="table table-hover table-bordered table-sm">
            <thead>
              <tr>
                  <td colspan="5" class="active"><strong>SECCIÓN A: EXÁMENES DE DIAGNOSTICO.</strong></td>
              </tr>
              <tr>
                  <td align="center" colspan="2"><strong>EXÁMENES</strong></td>
                  <td align="center"><strong>TOTAL</strong></td>
                  <td align="center"><strong>SAPU/SAR/SUR</strong></td>
                  <td align="center"><strong>NO SAPU/ NO SUR</strong></td>
              </tr>
            </thead>
            <tbody>
                <?php
                $query = 'SELECT a.codigo_prestacion,a.descripcion
                              ,sum(ifnull(b.Col01,0)) Col01
                              ,sum(ifnull(b.Col02,0)) Col02
                              ,sum(ifnull(b.Col03,0)) Col03
                          FROM (select c.* from 2020prestaciones c where c.codigo_prestacion in("18010100","18010200","18090100","18010500","18010601","18010800","18010900")) a
                          left join 2020rems b on (a.id_prestacion=b.prestacion_id_prestacion)
                          AND (b.Mes in ('.$mes.')) AND (b.establecimiento_id_establecimiento in ('.$estab.'))
                          group by  a.codigo_prestacion,a.descripcion,a.id_prestacion
                          order by a.id_prestacion';
                $registro = DB::connection('mysql_rem')->select($query);

                $i=0;

                $totalCol01=0;
    						$totalCol02=0;
    						$totalCol03=0;

                foreach($registro as $row ){
                    $totalCol01=$totalCol01+$row->Col01;
                    $totalCol02=$totalCol02+$row->Col02;
                    $totalCol03=$totalCol03+$row->Col03;

                    $i++;
                }
                ?>
                <tr>
                    <td colspan="2" align='left'><strong>TOTAL EXÁMENES LABORATORIO</strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol01,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol02,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol03,0,",",".") ?></strong></td>
                </tr>
                <?php
                $query = 'SELECT a.codigo_prestacion,a.descripcion
                              ,sum(ifnull(b.Col01,0)) Col01
                              ,sum(ifnull(b.Col02,0)) Col02
                              ,sum(ifnull(b.Col03,0)) Col03
                          FROM (select c.* from 2020prestaciones c where c.codigo_prestacion in("18010100","18010200","18090100")) a
                          left join 2020rems b on (a.id_prestacion=b.prestacion_id_prestacion)
                          AND (b.Mes in ('.$mes.')) AND (b.establecimiento_id_establecimiento in ('.$estab.'))
                          group by  a.codigo_prestacion,a.descripcion,a.id_prestacion
                          order by a.id_prestacion';
                $registro = DB::connection('mysql_rem')->select($query);

                $i=0;

                foreach($registro as $row ){
                    $nombre_descripcion = $row->codigo_prestacion;
                    if ($nombre_descripcion == "18010100"){
                        $nombre_descripcion = "HEMATOLÓGICOS";
                    }
                    if ($nombre_descripcion == "18010200"){
                        $nombre_descripcion = "BIOQUÍMICOS";
                    }
                    if ($nombre_descripcion == "18090100"){
                        $nombre_descripcion = "HORMONALES";
                    }
                    ?>
                <tr>
                    <?php
                    if($i==0){?>
                    <td align='center'>I</td>
                    <?php
                    }
                    if($i==1){?>
                    <td align='center'>II</td>
                    <?php
                    }
                    if($i==2){?>
                    <td align='center'>III</td>
                    <?php
                    }
                    ?>
                    <td align='left'><?php echo $nombre_descripcion; ?></td>
                    <td align='right'><?php echo number_format($row->Col01,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col02,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col03,0,",",".")?></td>
                    <?php
                    $i++;
                }
                ?>
                </tr>
                <tr>
                    <td align='center'>IV</td>
                    <td align='left'>GENÉTICA</td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <?php
                $query = 'SELECT a.codigo_prestacion,a.descripcion
                              ,sum(ifnull(b.Col01,0)) Col01
                              ,sum(ifnull(b.Col02,0)) Col02
                              ,sum(ifnull(b.Col03,0)) Col03
                          FROM (select c.* from 2020prestaciones c where c.codigo_prestacion in("18010500","18010601")) a
                          left join 2020rems b on (a.id_prestacion=b.prestacion_id_prestacion)
                          AND (b.Mes in ('.$mes.')) AND (b.establecimiento_id_establecimiento in ('.$estab.'))
                          group by  a.codigo_prestacion,a.descripcion,a.id_prestacion
                          order by a.id_prestacion';
                $registro = DB::connection('mysql_rem')->select($query);

                $i=0;

                foreach($registro as $row ){
                    $nombre_descripcion = $row->codigo_prestacion;
                    if ($nombre_descripcion == "18010500"){
                        $nombre_descripcion = "INMUNOLÓGICOS";
                    }
                    if ($nombre_descripcion == "18010601"){
                        $nombre_descripcion = "MICROBIOLÓGICOS";
                    }
                    ?>
                <tr>
                    <?php
                    if($i==0){?>
                    <td align='center'>V</td>
                    <?php
                    }
                    if($i==1){?>
                    <td align='center'>VI</td>
                    <?php
                    }
                    ?>
                    <td align='left'><?php echo $nombre_descripcion; ?></td>
                    <td align='right'><?php echo number_format($row->Col01,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col02,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col03,0,",",".")?></td>
                    <?php
                    $i++;
                }
                ?>
                <tr>
                    <td align='center'></td>
                    <td align='left'>a) BACTERIAS Y HONGOS</td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td align='center'></td>
                    <td align='left'>b) PARÁSITOS</td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td align='center'></td>
                    <td align='left'>c) VIRUS</td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td align='center'>VII</td>
                    <td align='left'>PROCEDIMIENTO O DETERMINACIÓN DIRECTA C/PACIENTE</td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <?php
                $query = 'SELECT a.codigo_prestacion,a.descripcion
                              ,sum(ifnull(b.Col01,0)) Col01
                              ,sum(ifnull(b.Col02,0)) Col02
                              ,sum(ifnull(b.Col03,0)) Col03
                          FROM (select c.* from 2020prestaciones c where c.codigo_prestacion in("18010800","18010900")) a
                          left join 2020rems b on (a.id_prestacion=b.prestacion_id_prestacion)
                          AND (b.Mes in ('.$mes.')) AND (b.establecimiento_id_establecimiento in ('.$estab.'))
                          group by  a.codigo_prestacion,a.descripcion,a.id_prestacion
                          order by a.id_prestacion';
                $registro = DB::connection('mysql_rem')->select($query);

                $i=0;

                foreach($registro as $row ){
                    $nombre_descripcion = $row->codigo_prestacion;
                    if ($nombre_descripcion == "18010800"){
                        $nombre_descripcion = "EX.  DE DEPOSICIONES EXUDADOS. SECREC. Y OTROS LIQ.";
                    }
                    if ($nombre_descripcion == "18010900"){
                        $nombre_descripcion = "ORINA";
                    }
                    ?>
                <tr>
                    <?php
                    if($i==0){?>
                    <td align='center'>VIII</td>
                    <?php
                    }
                    if($i==1){?>
                    <td align='center'>IX</td>
                    <?php
                    }
                    ?>
                    <td align='left'><?php echo $nombre_descripcion; ?></td>
                    <td align='right'><?php echo number_format($row->Col01,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col02,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col03,0,",",".")?></td>
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
                          FROM (select c.* from 2020prestaciones c where c.codigo_prestacion in("18011001","18011002","18400500","18400600")) a
                          left join 2020rems b on (a.id_prestacion=b.prestacion_id_prestacion)
                          AND (b.Mes in ('.$mes.')) AND (b.establecimiento_id_establecimiento in ('.$estab.'))
                          group by  a.codigo_prestacion,a.descripcion,a.id_prestacion
                          order by a.id_prestacion';
                $registro = DB::connection('mysql_rem')->select($query);

                $i=0;

                $totalCol01=0;
    						$totalCol02=0;
    						$totalCol03=0;

                foreach($registro as $row ){
                    $totalCol01=$totalCol01+$row->Col01;
                    $totalCol02=$totalCol02+$row->Col02;
                    $totalCol03=$totalCol03+$row->Col03;

                    $i++;
                }
                ?>
                <tr>
                    <td colspan="2" align='left'><strong>TOTAL EXÁMENES IMAGENOLOGIA</strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol01,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol02,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol03,0,",",".") ?></strong></td>
                </tr>
                <?php
                $query = 'SELECT a.codigo_prestacion,a.descripcion
                              ,sum(ifnull(b.Col01,0)) Col01
                              ,sum(ifnull(b.Col02,0)) Col02
                              ,sum(ifnull(b.Col03,0)) Col03
                          FROM (select c.* from 2020prestaciones c where c.codigo_prestacion in("18011001","18011002","18400500","18400600")) a
                          left join 2020rems b on (a.id_prestacion=b.prestacion_id_prestacion)
                          AND (b.Mes in ('.$mes.')) AND (b.establecimiento_id_establecimiento in ('.$estab.'))
                          group by  a.codigo_prestacion,a.descripcion,a.id_prestacion
                          order by a.id_prestacion';
                $registro = DB::connection('mysql_rem')->select($query);

                $i=0;

                foreach($registro as $row ){
                    $nombre_descripcion = $row->codigo_prestacion;
                    if ($nombre_descripcion == "18011001"){
                        $nombre_descripcion = "EX. RADIOLÓGICOS SIMPLES";
                    }
                    if ($nombre_descripcion == "18011002"){
                        $nombre_descripcion = "Ecotomografias";
                    }
                    if ($nombre_descripcion == "18400500"){
                        $nombre_descripcion = "Ecotomografias abdominal";
                    }
                    if ($nombre_descripcion == "18400600"){
                        $nombre_descripcion = "Ecografias Obstétricas";
                    }
                    ?>
                <tr>
                    <?php
                    if($i==0){?>
                    <td align='center'>a)</td>
                    <?php
                    }
                    if($i==1){?>
                    <td align='center'></td>
                    <?php
                    }
                    if($i==2){?>
                    <td align='center'></td>
                    <?php
                    }
                    if($i==3){?>
                    <td align='center'></td>
                    <?php
                    }
                    ?>
                    <td align='left'><?php echo $nombre_descripcion; ?></td>
                    <td align='right'><?php echo number_format($row->Col01,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col02,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col03,0,",",".")?></td>
                    <?php
                    $i++;
                }
                ?>
            </tbody>
        </table>
    </div>

    <br>

    <!-- SECCION B -->
    <div class="col-sm tab table-responsive" id="B">
        <table class="table table-hover table-bordered table-sm">
            <thead>
              <tr>
                  <td colspan="4" class="active"><strong>SECCIÓN B: PROCEDIMIENTO DE APOYO CLÍNICO Y TERAPÉUTICO.</strong></td>
              </tr>
              <tr>
                  <td align="center"><strong>PROCEDIMIENTOS</strong></td>
                  <td align="center"><strong>TOTAL</strong></td>
                  <td align="center"><strong>SAPU/SAR/SUR</strong></td>
                  <td align="center"><strong>NO SAPU/ NO SUR</strong></td>
              </tr>
            </thead>
            <tbody>
                <?php
                $query = 'SELECT a.codigo_prestacion,a.descripcion
                              ,sum(ifnull(b.Col01,0)) Col01
                              ,sum(ifnull(b.Col02,0)) Col02
                              ,sum(ifnull(b.Col03,0)) Col03
                          FROM (select c.* from 2020prestaciones c where c.codigo_prestacion in("18020100","18400400","18020200","18020300","18020400","18020500","18020600","18020700",
                                                                                                "18020800","18020900")) a
                          left join 2020rems b on (a.id_prestacion=b.prestacion_id_prestacion)
                          AND (b.Mes in ('.$mes.')) AND (b.establecimiento_id_establecimiento in ('.$estab.'))
                          group by  a.codigo_prestacion,a.descripcion,a.id_prestacion
                          order by a.id_prestacion';
                $registro = DB::connection('mysql_rem')->select($query);

                $i=0;

                $totalCol01=0;
    						$totalCol02=0;
    						$totalCol03=0;

                foreach($registro as $row ){
                    $totalCol01=$totalCol01+$row->Col01;
                    $totalCol02=$totalCol02+$row->Col02;
                    $totalCol03=$totalCol03+$row->Col03;

                    $nombre_descripcion = $row->codigo_prestacion;
                    if ($nombre_descripcion == "18020100"){
                        $nombre_descripcion = "PROC. DE NEUROLOGÍA Y NEUROCIRUGÍA";
                    }
                    if ($nombre_descripcion == "18400400"){
                        $nombre_descripcion = "PROC. DE OFTALMOLOGÍA";
                    }
                    if ($nombre_descripcion == "18020200"){
                        $nombre_descripcion = "PROC. DE OTORRINOLARINGOLOGÍA";
                    }
                    if ($nombre_descripcion == "18020300"){
                        $nombre_descripcion = "PROC. DE NEUMOLOGÍA";
                    }
                    if ($nombre_descripcion == "18020400"){
                        $nombre_descripcion = "PROC. DE DERMATOLOGÍA";
                    }
                    if ($nombre_descripcion == "18020500"){
                        $nombre_descripcion = "PROC. DE CARDIOLOGÍA";
                    }
                    if ($nombre_descripcion == "18020600"){
                        $nombre_descripcion = "PROC. DE GASTROENTEROLOGÍA";
                    }
                    if ($nombre_descripcion == "18020700"){
                        $nombre_descripcion = "PROC. DE UROLOGÍA";
                    }
                    if ($nombre_descripcion == "18020800"){
                        $nombre_descripcion = "PROC. ORTOPEDIA Y TRAUMATOLOGÍA";
                    }
                    if ($nombre_descripcion == "18020900"){
                        $nombre_descripcion = "PROC. GINECO-OBSTÉTRICOS";
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
                <tr>
                    <td align='center'><strong>TOTAL</strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol01,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol02,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol03,0,",",".") ?></strong></td>
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
                  <td colspan="4" class="active"><strong>SECCIÓN C: INTERVENCIONES QUIRÚRGICAS MENORES.</strong></td>
              </tr>
              <tr>
                  <td align="center"><strong></strong></td>
                  <td align="center"><strong>TOTAL</strong></td>
                  <td align="center"><strong>SAPU/SAR/SUR</strong></td>
                  <td align="center"><strong>NO SAPU/ NO SUR</strong></td>
              </tr>
            </thead>
            <tbody>
                <?php
                $query = 'SELECT a.codigo_prestacion,a.descripcion
                              ,sum(ifnull(b.Col01,0)) Col01
                              ,sum(ifnull(b.Col02,0)) Col02
                              ,sum(ifnull(b.Col03,0)) Col03
                          FROM (select c.* from 2020prestaciones c where c.codigo_prestacion in("18010100","18010200","18090100","18010500","18010601","18010800","18010900")) a
                          left join 2020rems b on (a.id_prestacion=b.prestacion_id_prestacion)
                          AND (b.Mes in ('.$mes.')) AND (b.establecimiento_id_establecimiento in ('.$estab.'))
                          group by  a.codigo_prestacion,a.descripcion,a.id_prestacion
                          order by a.id_prestacion';
                $registro = DB::connection('mysql_rem')->select($query);

                $i=0;

                $query = 'SELECT a.codigo_prestacion,a.descripcion
                              ,sum(ifnull(b.Col01,0)) Col01
                              ,sum(ifnull(b.Col02,0)) Col02
                              ,sum(ifnull(b.Col03,0)) Col03
                          FROM (select c.* from 2020prestaciones c where c.codigo_prestacion in("18030000")) a
                          left join 2020rems b on (a.id_prestacion=b.prestacion_id_prestacion)
                          AND (b.Mes in ('.$mes.')) AND (b.establecimiento_id_establecimiento in ('.$estab.'))
                          group by  a.codigo_prestacion,a.descripcion,a.id_prestacion
                          order by a.id_prestacion';
                $registro = DB::connection('mysql_rem')->select($query);

                $i=0;

                foreach($registro as $row ){
                    $totalCol01=$totalCol01+$row->Col01;
                    $totalCol02=$totalCol02+$row->Col02;
                    $totalCol03=$totalCol03+$row->Col03;

                    $nombre_descripcion = $row->codigo_prestacion;
                    if ($nombre_descripcion == "18030000"){
                        $nombre_descripcion = "TOTAL INTERVENCIONES QUIRÚRGICAS MENORES (SUB-GRUPO TEGUMENTOS)	";
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

    <!-- SECCION D -->
    <div class="col-sm tab table-responsive" id="D">
        <table class="table table-hover table-bordered table-sm">
            <thead>
              <tr>
                  <td colspan="4" class="active"><strong>SECCIÓN D: INTERVENCIONES QUIRÚRGICAS MENORES POR EDAD.</strong></td>
              </tr>
              <tr>
                  <td align="center"><strong>INTERVENCIONES QUIRÚRGICAS</strong></td>
                  <td align="center"><strong>TOTAL</strong></td>
                  <td align="center"><strong>< 15 AÑOS</strong></td>
                  <td align="center"><strong>15 Y + AÑOS</strong></td>
              </tr>
            </thead>
            <tbody>
                <?php
                $query = 'SELECT a.codigo_prestacion,a.descripcion
                              ,sum(ifnull(b.Col01,0)) Col01
                              ,sum(ifnull(b.Col02,0)) Col02
                              ,sum(ifnull(b.Col03,0)) Col03
                          FROM (select c.* from 2020prestaciones c where c.codigo_prestacion in("18040100","18040200")) a
                          left join 2020rems b on (a.id_prestacion=b.prestacion_id_prestacion)
                          AND (b.Mes in ('.$mes.')) AND (b.establecimiento_id_establecimiento in ('.$estab.'))
                          group by  a.codigo_prestacion,a.descripcion,a.id_prestacion
                          order by a.id_prestacion';
                $registro = DB::connection('mysql_rem')->select($query);

                $totalCol01=0;
                $totalCol02=0;
                $totalCol03=0;

                foreach($registro as $row ){
                    $totalCol01=$totalCol01+$row->Col01;
                    $totalCol02=$totalCol02+$row->Col02;
                    $totalCol03=$totalCol03+$row->Col03;
                }
                ?>
                <tr>
                    <td align='center'><strong>TOTAL</strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol01,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol02,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol03,0,",",".") ?></strong></td>
                </tr>
                <?php

                $i=0;

                foreach($registro as $row ){
                    $nombre_descripcion = $row->codigo_prestacion;

                    if ($nombre_descripcion == "18040100"){
                        $nombre_descripcion = "SAPU/SAR";
                    }
                    if ($nombre_descripcion == "18040200"){
                        $nombre_descripcion = "NO SAPU";
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

    <!-- SECCION E -->
    <div class="col-sm tab table-responsive" id="E">
        <table class="table table-hover table-bordered table-sm">
            <thead>
              <tr>
                  <td colspan="4" class="active"><strong>SECCIÓN E: MISCELÁNEOS.</strong></td>
              </tr>
              <tr>
                  <td align="center"><strong>MISCELÁNEOS</strong></td>
                  <td align="center"><strong>TOTAL</strong></td>
                  <td align="center"><strong>SAPU/SAR/SUR</strong></td>
                  <td align="center"><strong>NO SAPU/ NO SUR</strong></td>
              </tr>
            </thead>
            <tbody>
                <?php
                $query = 'SELECT a.codigo_prestacion,a.descripcion
                              ,sum(ifnull(b.Col01,0)) Col01
                              ,sum(ifnull(b.Col02,0)) Col02
                              ,sum(ifnull(b.Col03,0)) Col03
                          FROM (select c.* from 2020prestaciones c where c.codigo_prestacion in("18090000","18050100","18050200","18050300")) a
                          left join 2020rems b on (a.id_prestacion=b.prestacion_id_prestacion)
                          AND (b.Mes in ('.$mes.')) AND (b.establecimiento_id_establecimiento in ('.$estab.'))
                          group by  a.codigo_prestacion,a.descripcion,a.id_prestacion
                          order by a.id_prestacion';
                $registro = DB::connection('mysql_rem')->select($query);

                $i=0;

                foreach($registro as $row ){
                    $nombre_descripcion = $row->codigo_prestacion;

                    if ($nombre_descripcion == "18090000"){
                        $nombre_descripcion = "PROCEDIMIENTOS DE PODOLOGIA";
                    }
                    if ($nombre_descripcion == "18050100"){
                        $nombre_descripcion = "CURACIÓN SIMPLE AMBULATORIA";
                    }
                    if ($nombre_descripcion == "18050200"){
                        $nombre_descripcion = "AUTO CUIDADO PACIENTE DID";
                    }
                    if ($nombre_descripcion == "18050300"){
                        $nombre_descripcion = "OXIGENOTERAPIA A DOMICILIO";
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

    <!-- SECCION F -->
    <div class="col-sm tab table-responsive" id="F">
        <table class="table table-hover table-bordered table-sm">
            <thead>
              <tr>
                  <td colspan="2" class="active"><strong>SECCIÓN F: PRESCRIPCIONES ADMINISTRADAS EN URGENCIA APS.</strong></td>
              </tr>
              <tr>
                  <td align="center"><strong>ATENCIÓN</strong></td>
                  <td align="center"><strong>TOTAL</strong></td>
              </tr>
            </thead>
            <tbody>
                <?php
                $query = 'SELECT a.codigo_prestacion,a.descripcion
                              ,sum(ifnull(b.Col01,0)) Col01
                          FROM (select c.* from 2020prestaciones c where c.codigo_prestacion in("18400700")) a
                          left join 2020rems b on (a.id_prestacion=b.prestacion_id_prestacion)
                          AND (b.Mes in ('.$mes.')) AND (b.establecimiento_id_establecimiento in ('.$estab.'))
                          group by  a.codigo_prestacion,a.descripcion,a.id_prestacion
                          order by a.id_prestacion';
                $registro = DB::connection('mysql_rem')->select($query);

                $i=0;

                foreach($registro as $row ){
                    $nombre_descripcion = $row->codigo_prestacion;

                    if ($nombre_descripcion == "18400700"){
                        $nombre_descripcion = "URGENCIA SAPU/SAR";
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

    <!-- SECCION H -->
    <div class="col-sm tab table-responsive" id="H">
        <table class="table table-hover table-bordered table-sm">
            <thead>
              <tr>
                  <td colspan="8" class="active"><strong>SECCIÓN G : OTRAS ATENCIONES A PACIENTES AMBULATORIOS.</strong></td>
              </tr>
              <tr>
            			<td rowspan="2" style="text-align:center; vertical-align:middle"><strong>TIPO DE ATENCIÓN</strong></td>
            			<td rowspan="2" style="text-align:center; vertical-align:middle"><strong>TOTAL</strong></td>
            			<td colspan="6" align="center"><strong>ATENCIONES POR EDAD</strong></td>
          		</tr>
          		<tr>
            			<td align="center"><strong>< 1 año</strong></td>
            			<td align="center"><strong>1 - 4 años</strong></td>
            			<td align="center"><strong>5 a 9 años</strong></td>
            			<td align="center"><strong>10 a 19 años</strong></td>
            			<td align="center"><strong>20 a 64 años</strong></td>
            			<td align="center"><strong>65 años y más</strong></td>
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
                          FROM (select c.* from 2020prestaciones c where c.codigo_prestacion in("18070100","18070300","18400900")) a
                          left join 2020rems b on (a.id_prestacion=b.prestacion_id_prestacion)
                          AND (b.Mes in ('.$mes.')) AND (b.establecimiento_id_establecimiento in ('.$estab.'))
                          group by  a.codigo_prestacion,a.descripcion,a.id_prestacion
                          order by a.id_prestacion';
                $registro = DB::connection('mysql_rem')->select($query);

                $i=0;

                foreach($registro as $row ){
                    $nombre_descripcion = $row->codigo_prestacion;

                    if ($nombre_descripcion == "18070100"){
                        $nombre_descripcion = "POR TERAPÉUTICA OCUPACIONAL";
                    }
                    if ($nombre_descripcion == "18070300"){
                        $nombre_descripcion = "POR KINESIOLOGO (NO SAPU)";
                    }
                    if ($nombre_descripcion == "18400900"){
                        $nombre_descripcion = "POR EDUCADORA DE PÁRVULO/DIFERENCIAL";
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

    <br>

    <!-- SECCION G -->
    <div class="col-sm tab table-responsive" id="G">
        <table class="table table-hover table-bordered table-sm">
            <thead>
              <tr>
                  <td colspan="8" class="active"><strong>SECCIÓN H: OTROS TRASLADOS DE PACIENTES.</strong></td>
              </tr>
              <tr>
            			<td colspan="2" align="center"><strong>TIPO DE ACCION</strong></td>
            			<td align="center"><strong>TOTAL</strong></td>
            			<td align="center"><strong>POR COMPRA DE SERVICIO</strong></td>
          		</tr>
            </thead>
            <tbody>
                <?php
                $query = 'SELECT a.codigo_prestacion,a.descripcion
                              ,sum(ifnull(b.Col01,0)) Col01
                              ,sum(ifnull(b.Col02,0)) Col02
                          FROM (select c.* from 2020prestaciones c where c.codigo_prestacion in("18090200","18090300","18090400")) a
                          left join 2020rems b on (a.id_prestacion=b.prestacion_id_prestacion)
                          AND (b.Mes in ('.$mes.')) AND (b.establecimiento_id_establecimiento in ('.$estab.'))
                          group by  a.codigo_prestacion,a.descripcion,a.id_prestacion
                          order by a.id_prestacion';
                $registro = DB::connection('mysql_rem')->select($query);

                $i=0;

                foreach($registro as $row ){
                    $nombre_descripcion = $row->codigo_prestacion;

                    if ($nombre_descripcion == "18090200"){
                        $nombre_descripcion = "AMBULANCIA";
                    }
                    if ($nombre_descripcion == "18090300"){
                        $nombre_descripcion = "MARÍTIMO";
                    }
                    if ($nombre_descripcion == "18090400"){
                        $nombre_descripcion = "AÉREO";
                    }
                    ?>
                <tr>
                    <?php
                    if($i==0){?>
                    <td rowspan="3" style="text-align:center; vertical-align:middle">TRASLADOS NO DE URGENCIA</td>
                    <?php
                    }
                    ?>
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
