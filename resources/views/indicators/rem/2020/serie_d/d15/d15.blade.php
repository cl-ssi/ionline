@extends('layouts.app')

@section('title', 'Resumen Estadistico Mensual')

@section('content')

<?php

use Illuminate\Support\Facades\DB;

?>

@include('indicators.rem.partials.navD')

<h3>REM-D.15 - Programa Nacional de Alimentación Complementaria (PNAC).</h3>

<br>

@include('indicators.rem.2020.serie_d.search')

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
    <!-- SECCION A -->
    <div class="col-sm tab table-responsive" id="A">
        <table class="table table-hover table-bordered table-sm">
            <thead>
                <tr>
                    <td colspan="15" class="active"><strong>Sección A: PNAC - Cantidad distribuida (kg) a personas intrasistema.</strong></td>
                </tr>
                <tr>
                    <td rowspan="2" style="text-align:center; vertical-align:middle"><strong>Subprogramas</strong></td>
                    <td rowspan="2" style="text-align:center; vertical-align:middle"><strong>Productos</strong></td>
                    <td rowspan="2" style="text-align:center; vertical-align:middle"><strong>Total</strong></td>
                    <td colspan="7" align="center"><strong>Menores a 6 años</strong></td>
                    <td colspan="2" align="center"><strong>Gestantes</strong></td>
                    <td colspan="3" align="center"><strong>Madre con hijo/a menor a 6 meses</strong></td>
                </tr>
                <tr>
                    <td align="center"><strong>0 - 2 meses</strong></td>
                    <td align="center"><strong>3 - 5 meses</strong></td>
                    <td align="center"><strong>6 - 11 meses</strong></td>
                    <td align="center"><strong>12 - 17 meses</strong></td>
                    <td align="center"><strong>18 - 23 meses</strong></td>
                    <td align="center"><strong>24 - 47 meses</strong></td>
                    <td align="center"><strong>48 - 71 meses</strong></td>
                    <td align="center"><strong>Normal, sobrepeso y obesas</strong></td>
                    <td align="center"><strong>Bajo peso</strong></td>
                    <td align="center"><strong>Lactancia materna exclusiva</strong></td>
                    <td align="center"><strong>Lactancia materna predominante</strong></td>
                    <td align="center"><strong>Fórmula predominante o exclusiva</strong></td>
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
                          FROM (select c.* from 2020prestaciones c where c.codigo_prestacion in("15010100","15010200","15080008","15900010")) a
                          left join 2020rems b on (a.id_prestacion=b.prestacion_id_prestacion)
                          AND (b.Mes in ('.$mes.')) AND (b.establecimiento_id_establecimiento in ('.$estab.'))
                          group by  a.codigo_prestacion,a.descripcion,a.id_prestacion
                          order by a.id_prestacion';
                $registro = DB::connection('mysql_rem')->select($query);

                $i=0;

                $totalCol01a=0;
    						$totalCol02a=0;
    						$totalCol03a=0;
    						$totalCol04a=0;
    						$totalCol05a=0;
    						$totalCol06a=0;
    						$totalCol07a=0;
    						$totalCol08a=0;
    						$totalCol09a=0;
    						$totalCol10a=0;
    						$totalCol11a=0;
    						$totalCol12a=0;
                $totalCol13a=0;

                foreach($registro as $row ){
                    $totalCol01a=$totalCol01a+$row->Col01;
                    $totalCol02a=$totalCol02a+$row->Col02;
                    $totalCol03a=$totalCol03a+$row->Col03;
                    $totalCol04a=$totalCol04a+$row->Col04;
                    $totalCol05a=$totalCol05a+$row->Col05;
                    $totalCol06a=$totalCol06a+$row->Col06;
                    $totalCol07a=$totalCol07a+$row->Col07;
                    $totalCol08a=$totalCol08a+$row->Col08;
                    $totalCol09a=$totalCol09a+$row->Col09;
                    $totalCol10a=$totalCol10a+$row->Col10;
                    $totalCol11a=$totalCol11a+$row->Col11;
                    $totalCol12a=$totalCol12a+$row->Col12;
                    $totalCol13a=$totalCol13a+$row->Col13;

                    $nombre_descripcion = $row->codigo_prestacion;
                    if ($nombre_descripcion == "15010100"){
                        $nombre_descripcion = "Leche Purita Fortificada (LPF)";
                    }
                    if ($nombre_descripcion == "15010200"){
                        $nombre_descripcion = "Purita Cereal (PC)";
                    }
                    if ($nombre_descripcion == "15080008"){
                        $nombre_descripcion = "Purita Mamá (PM)";
                    }
                    if ($nombre_descripcion == "15900010"){
                        $nombre_descripcion = "Fórmula de Inicio (FI)";
                    }

                    ?>
                <tr>
                    <?php
                    if($i==0){?>
                    <td rowspan='5' style="text-align:center; vertical-align:middle">Básico</td>
                    <?php
                    }
                    ?>
                    <td align='left' nowrap="nowrap"><?php echo $nombre_descripcion; ?></td>
                    <td align='right'><?php echo number_format($row->Col01,2,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col02,2,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col03,2,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col04,2,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col05,2,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col06,2,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col07,2,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col08,2,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col09,2,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col10,2,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col11,2,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col12,2,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col13,2,",",".")?></td>
                    <?php
                    $i++;
                }
                ?>
                </tr>
                <tr>
                    <td align='center'><strong>SUBTOTAL</strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol01a,2,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol02a,2,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol03a,2,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol04a,2,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol05a,2,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol06a,2,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol07a,2,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol08a,2,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol09a,2,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol10a,2,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol11a,2,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol12a,2,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol13a,2,",",".") ?></strong></td>
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
                          FROM (select c.* from 2020prestaciones c where c.codigo_prestacion in("15010300","15010400","15010500","15080009","15900020")) a
                          left join 2020rems b on (a.id_prestacion=b.prestacion_id_prestacion)
                          AND (b.Mes in ('.$mes.')) AND (b.establecimiento_id_establecimiento in ('.$estab.'))
                          group by  a.codigo_prestacion,a.descripcion,a.id_prestacion
                          order by a.id_prestacion';
                $registro = DB::connection('mysql_rem')->select($query);

                $i=0;

                $totalCol01b=0;
    						$totalCol02b=0;
    						$totalCol03b=0;
    						$totalCol04b=0;
    						$totalCol05b=0;
    						$totalCol06b=0;
    						$totalCol07b=0;
    						$totalCol08b=0;
    						$totalCol09b=0;
    						$totalCol10b=0;
    						$totalCol11b=0;
    						$totalCol12b=0;
                $totalCol13b=0;

                foreach($registro as $row ){
                    $totalCol01b=$totalCol01b+$row->Col01;
                    $totalCol02b=$totalCol02b+$row->Col02;
                    $totalCol03b=$totalCol03b+$row->Col03;
                    $totalCol04b=$totalCol04b+$row->Col04;
                    $totalCol05b=$totalCol05b+$row->Col05;
                    $totalCol06b=$totalCol06b+$row->Col06;
                    $totalCol07b=$totalCol07b+$row->Col07;
                    $totalCol08b=$totalCol08b+$row->Col08;
                    $totalCol09b=$totalCol09b+$row->Col09;
                    $totalCol10b=$totalCol10b+$row->Col10;
                    $totalCol11b=$totalCol11b+$row->Col11;
                    $totalCol12b=$totalCol12b+$row->Col12;
                    $totalCol13b=$totalCol13b+$row->Col13;

                    $nombre_descripcion = $row->codigo_prestacion;
                    if ($nombre_descripcion == "15010300"){
                        $nombre_descripcion = "Leche Purita Fortificada (LPF)";
                    }
                    if ($nombre_descripcion == "15010400"){
                        $nombre_descripcion = "Purita Cereal (PC)";
                    }
                    if ($nombre_descripcion == "15010500"){
                        $nombre_descripcion = "Mi Sopita (MS)";
                    }
                    if ($nombre_descripcion == "15080009"){
                        $nombre_descripcion = "Purita Mamá (PM)";
                    }
                    if ($nombre_descripcion == "15900020"){
                        $nombre_descripcion = "Fórmula de Inicio (FI)";
                    }
                    ?>
                <tr>
                    <?php
                    if($i==0){?>
                    <td rowspan='6' style="text-align:center; vertical-align:middle">Refuerzo</td>
                    <?php
                    }
                    ?>
                    <td align='left' nowrap="nowrap"><?php echo $nombre_descripcion; ?></td>
                    <td align='right'><?php echo number_format($row->Col01,2,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col02,2,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col03,2,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col04,2,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col05,2,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col06,2,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col07,2,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col08,2,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col09,2,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col10,2,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col11,2,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col12,2,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col13,2,",",".")?></td>
                    <?php
                    $i++;
                }
                ?>
                </tr>
                <tr>
                    <td align='center'><strong>SUBTOTAL</strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol01b,2,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol02b,2,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol03b,2,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol04b,2,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol05b,2,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol06b,2,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol07b,2,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol08b,2,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol09b,2,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol10b,2,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol11b,2,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol12b,2,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol13b,2,",",".") ?></strong></td>
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
                          FROM (select c.* from 2020prestaciones c where c.codigo_prestacion in("15030100","15030200","15080006","15080012")) a
                          left join 2020rems b on (a.id_prestacion=b.prestacion_id_prestacion)
                          AND (b.Mes in ('.$mes.')) AND (b.establecimiento_id_establecimiento in ('.$estab.'))
                          group by  a.codigo_prestacion,a.descripcion,a.id_prestacion
                          order by a.id_prestacion';
                $registro = DB::connection('mysql_rem')->select($query);

                $i=0;

                $totalCol01c=0;
    						$totalCol02c=0;
    						$totalCol03c=0;
    						$totalCol04c=0;
    						$totalCol05c=0;
    						$totalCol06c=0;
    						$totalCol07c=0;
    						$totalCol08c=0;
    						$totalCol09c=0;
    						$totalCol10c=0;
    						$totalCol11c=0;
    						$totalCol12c=0;
                $totalCol13c=0;

                foreach($registro as $row ){
                    $totalCol01c=$totalCol01c+$row->Col01;
                    $totalCol02c=$totalCol02c+$row->Col02;
                    $totalCol03c=$totalCol03c+$row->Col03;
                    $totalCol04c=$totalCol04c+$row->Col04;
                    $totalCol05c=$totalCol05c+$row->Col05;
                    $totalCol06c=$totalCol06c+$row->Col06;
                    $totalCol07c=$totalCol07c+$row->Col07;
                    $totalCol08c=$totalCol08c+$row->Col08;
                    $totalCol09c=$totalCol09c+$row->Col09;
                    $totalCol10c=$totalCol10c+$row->Col10;
                    $totalCol11c=$totalCol11c+$row->Col11;
                    $totalCol12c=$totalCol12c+$row->Col12;
                    $totalCol13c=$totalCol13c+$row->Col13;

                    $nombre_descripcion = $row->codigo_prestacion;
                    if ($nombre_descripcion == "15030100"){
                        $nombre_descripcion = "Fórmula de Prematuros (FP)";
                    }
                    if ($nombre_descripcion == "15030200"){
                        $nombre_descripcion = "Fórmula de Continuación (FC)";
                    }
                    if ($nombre_descripcion == "15080006"){
                        $nombre_descripcion = "Leche Purita Fortificada (LPF)";
                    }
                    if ($nombre_descripcion == "15080012"){
                        $nombre_descripcion = "Mi Sopita (MS)";
                    }
                    ?>
                <tr>
                    <?php
                    if($i==0){?>
                    <td rowspan='5' style="text-align:center; vertical-align:middle">Prematuros Extremos</td>
                    <?php
                    }
                    ?>
                    <td align='left' nowrap="nowrap"><?php echo $nombre_descripcion; ?></td>
                    <td align='right'><?php echo number_format($row->Col01,2,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col02,2,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col03,2,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col04,2,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col05,2,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col06,2,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col07,2,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col08,2,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col09,2,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col10,2,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col11,2,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col12,2,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col13,2,",",".")?></td>
                    <?php
                    $i++;
                }
                ?>
                </tr>
                <tr>
                    <td align='center'><strong>SUBTOTAL</strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol01c,2,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol02c,2,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol03c,2,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol04c,2,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol05c,2,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol06c,2,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol07c,2,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol08c,2,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol09c,2,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol10c,2,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol11c,2,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol12c,2,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol13c,2,",",".") ?></strong></td>
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
                          FROM (select c.* from 2020prestaciones c where c.codigo_prestacion in("15900030","15900040")) a
                          left join 2020rems b on (a.id_prestacion=b.prestacion_id_prestacion)
                          AND (b.Mes in ('.$mes.')) AND (b.establecimiento_id_establecimiento in ('.$estab.'))
                          group by  a.codigo_prestacion,a.descripcion,a.id_prestacion
                          order by a.id_prestacion';
                $registro = DB::connection('mysql_rem')->select($query);

                $i=0;

                $totalCol01d=0;
    						$totalCol02d=0;
    						$totalCol03d=0;
    						$totalCol04d=0;
    						$totalCol05d=0;
    						$totalCol06d=0;
    						$totalCol07d=0;
    						$totalCol08d=0;
    						$totalCol09d=0;
    						$totalCol10d=0;
    						$totalCol11d=0;
    						$totalCol12d=0;
                $totalCol13d=0;

                foreach($registro as $row ){
                    $totalCol01d=$totalCol01d+$row->Col01;
                    $totalCol02d=$totalCol02d+$row->Col02;
                    $totalCol03d=$totalCol03d+$row->Col03;
                    $totalCol04d=$totalCol04d+$row->Col04;
                    $totalCol05d=$totalCol05d+$row->Col05;
                    $totalCol06d=$totalCol06d+$row->Col06;
                    $totalCol07d=$totalCol07d+$row->Col07;
                    $totalCol08d=$totalCol08d+$row->Col08;
                    $totalCol09d=$totalCol09d+$row->Col09;
                    $totalCol10d=$totalCol10d+$row->Col10;
                    $totalCol11d=$totalCol11d+$row->Col11;
                    $totalCol12d=$totalCol12d+$row->Col12;
                    $totalCol13d=$totalCol13d+$row->Col13;

                    $nombre_descripcion = $row->codigo_prestacion;
                    if ($nombre_descripcion == "15900030"){
                        $nombre_descripcion = "Fórmula Extensamente Hidrolizada (FEH)";
                    }
                    if ($nombre_descripcion == "15900040"){
                        $nombre_descripcion = "Fórmula Aminoacídica (FAA)";
                    }
                    ?>
                <tr>
                    <?php
                    if($i==0){?>
                    <td rowspan='3' style="text-align:center; vertical-align:middle">Alergia a la proteína de la leche de vaca</td>
                    <?php
                    }
                    ?>
                    <td align='left' nowrap="nowrap"><?php echo $nombre_descripcion; ?></td>
                    <td align='right'><?php echo number_format($row->Col01,2,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col02,2,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col03,2,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col04,2,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col05,2,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col06,2,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col07,2,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col08,2,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col09,2,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col10,2,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col11,2,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col12,2,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col13,2,",",".")?></td>
                    <?php
                    $i++;
                }
                ?>
                </tr>
                <tr>
                    <td align='center'><strong>SUBTOTAL</strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol01d,2,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol02d,2,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol03d,2,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol04d,2,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol05d,2,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol06d,2,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol07d,2,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol08d,2,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol09d,2,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol10d,2,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol11d,2,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol12d,2,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol13d,2,",",".") ?></strong></td>
                </tr>
                <tr>
                    <td colspan="2" align='center'><strong>TOTAL</strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol01a+$totalCol01b+$totalCol01c+$totalCol01d,2,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol02a+$totalCol02b+$totalCol02c+$totalCol02d,2,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol03a+$totalCol03b+$totalCol03c+$totalCol03d,2,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol04a+$totalCol04b+$totalCol04c+$totalCol04d,2,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol05a+$totalCol05b+$totalCol05c+$totalCol05d,2,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol06a+$totalCol06b+$totalCol06c+$totalCol06d,2,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol07a+$totalCol07b+$totalCol07c+$totalCol07d,2,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol08a+$totalCol08b+$totalCol08c+$totalCol08d,2,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol09a+$totalCol09b+$totalCol09c+$totalCol09d,2,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol10a+$totalCol10b+$totalCol10c+$totalCol10d,2,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol11a+$totalCol11b+$totalCol11c+$totalCol11d,2,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol12a+$totalCol12b+$totalCol12c+$totalCol12d,2,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol13a+$totalCol13b+$totalCol13c+$totalCol13d,2,",",".") ?></strong></td>
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
                    <td colspan="14" class="active"><strong>Sección B: PNAC - Número de personas intrasistema que retiran.</strong></td>
                </tr>
                <tr>
                    <td rowspan="2" style="text-align:center; vertical-align:middle"><strong>Subprogramas</strong></td>
                    <td rowspan="2" style="text-align:center; vertical-align:middle"><strong>Total</strong></td>
                    <td colspan="7" align="center"><strong>Menores a 6 años</strong></td>
                    <td colspan="2" align="center"><strong>Gestantes</strong></td>
                    <td colspan="3" align="center"><strong>Madre con hijo/a menor a 6 meses</strong></td>
                </tr>
                <tr>
                    <td align="center"><strong>0 - 2 meses</strong></td>
                    <td align="center"><strong>3 - 5 meses</strong></td>
                    <td align="center"><strong>6 - 11 meses</strong></td>
                    <td align="center"><strong>12 - 17 meses</strong></td>
                    <td align="center"><strong>18 - 23 meses</strong></td>
                    <td align="center"><strong>24 - 47 meses</strong></td>
                    <td align="center"><strong>48 - 71 meses</strong></td>
                    <td align="center"><strong>Normal, sobrepeso y obesas</strong></td>
                    <td align="center"><strong>Bajo peso</strong></td>
                    <td align="center"><strong>Lactancia materna exclusiva</strong></td>
                    <td align="center"><strong>Lactancia materna predominante</strong></td>
                    <td align="center"><strong>Fórmula predominante o exclusiva</strong></td>
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
                          FROM (select c.* from 2020prestaciones c where c.codigo_prestacion in("15050100","15050200","15050500","15900050")) a
                          left join 2020rems b on (a.id_prestacion=b.prestacion_id_prestacion)
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
    						$totalCol07=0;
    						$totalCol08=0;
    						$totalCol09=0;
    						$totalCol10=0;
    						$totalCol11=0;
    						$totalCol12=0;
                $totalCol13=0;

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

                    $nombre_descripcion = $row->codigo_prestacion;
                    if ($nombre_descripcion == "15050100"){
                        $nombre_descripcion = "Básico";
                    }
                    if ($nombre_descripcion == "15050200"){
                        $nombre_descripcion = "Refuerzo";
                    }
                    if ($nombre_descripcion == "15050500"){
                        $nombre_descripcion = "Prematuros Extremos";
                    }
                    if ($nombre_descripcion == "15900050"){
                        $nombre_descripcion = "Alergia a la Proteína de la leche de vaca";
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
                          FROM (select c.* from 2020prestaciones c where c.codigo_prestacion in("15900060")) a
                          left join 2020rems b on (a.id_prestacion=b.prestacion_id_prestacion)
                          AND (b.Mes in ('.$mes.')) AND (b.establecimiento_id_establecimiento in ('.$estab.'))
                          group by  a.codigo_prestacion,a.descripcion,a.id_prestacion
                          order by a.id_prestacion';
                $registro = DB::connection('mysql_rem')->select($query);

                $i=0;

                foreach($registro as $row ){

                    $nombre_descripcion = $row->codigo_prestacion;
                    if ($nombre_descripcion == "15900060"){
                        $nombre_descripcion = "Programas Sociales (*)";
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
                    <?php
                    $i++;
                }
                ?>
                </tr>
                <tr>
                    <td colspan="14">Nota: (*) Información referencial, ya incluida en los subprogramas.</td>
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
                    <td colspan="15" class="active"><strong>Sección C: PNAC: Cantidad distribuida (kg) a personas extrasistema (incluye modalidad libre elección).</strong></td>
                </tr>
                <tr>
                    <td rowspan="2" style="text-align:center; vertical-align:middle"><strong>Subprogramas</strong></td>
                    <td rowspan="2" style="text-align:center; vertical-align:middle"><strong>Productos</strong></td>
                    <td rowspan="2" style="text-align:center; vertical-align:middle"><strong>Total</strong></td>
                    <td colspan="7" align="center"><strong>Menores a 6 años</strong></td>
                    <td colspan="2" align="center"><strong>Gestantes</strong></td>
                    <td colspan="3" align="center"><strong>Madre con hijo/a menor a 6 meses</strong></td>
                </tr>
                <tr>
                    <td align="center"><strong>0 - 2 meses</strong></td>
                    <td align="center"><strong>3 - 5 meses</strong></td>
                    <td align="center"><strong>6 - 11 meses</strong></td>
                    <td align="center"><strong>12 - 17 meses</strong></td>
                    <td align="center"><strong>18 - 23 meses</strong></td>
                    <td align="center"><strong>24 - 47 meses</strong></td>
                    <td align="center"><strong>48 - 71 meses</strong></td>
                    <td align="center"><strong>Normal, sobrepeso y obesas</strong></td>
                    <td align="center"><strong>Bajo peso</strong></td>
                    <td align="center"><strong>Lactancia materna exclusiva</strong></td>
                    <td align="center"><strong>Lactancia materna predominante</strong></td>
                    <td align="center"><strong>Fórmula predominante o exclusiva</strong></td>
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
                          FROM (select c.* from 2020prestaciones c where c.codigo_prestacion in("15020100","15020200","15080010","15900070")) a
                          left join 2020rems b on (a.id_prestacion=b.prestacion_id_prestacion)
                          AND (b.Mes in ('.$mes.')) AND (b.establecimiento_id_establecimiento in ('.$estab.'))
                          group by  a.codigo_prestacion,a.descripcion,a.id_prestacion
                          order by a.id_prestacion';
                $registro = DB::connection('mysql_rem')->select($query);

                $i=0;

                $totalCol01a=0;
    						$totalCol02a=0;
    						$totalCol03a=0;
    						$totalCol04a=0;
    						$totalCol05a=0;
    						$totalCol06a=0;
    						$totalCol07a=0;
    						$totalCol08a=0;
    						$totalCol09a=0;
    						$totalCol10a=0;
    						$totalCol11a=0;
    						$totalCol12a=0;
                $totalCol13a=0;

                foreach($registro as $row ){
                    $totalCol01a=$totalCol01a+$row->Col01;
                    $totalCol02a=$totalCol02a+$row->Col02;
                    $totalCol03a=$totalCol03a+$row->Col03;
                    $totalCol04a=$totalCol04a+$row->Col04;
                    $totalCol05a=$totalCol05a+$row->Col05;
                    $totalCol06a=$totalCol06a+$row->Col06;
                    $totalCol07a=$totalCol07a+$row->Col07;
                    $totalCol08a=$totalCol08a+$row->Col08;
                    $totalCol09a=$totalCol09a+$row->Col09;
                    $totalCol10a=$totalCol10a+$row->Col10;
                    $totalCol11a=$totalCol11a+$row->Col11;
                    $totalCol12a=$totalCol12a+$row->Col12;
                    $totalCol13a=$totalCol13a+$row->Col13;

                    $nombre_descripcion = $row->codigo_prestacion;
                    if ($nombre_descripcion == "15020100"){
                        $nombre_descripcion = "Leche Purita Fortificada (LPF)";
                    }
                    if ($nombre_descripcion == "15020200"){
                        $nombre_descripcion = "Purita Cereal (PC)";
                    }
                    if ($nombre_descripcion == "15080010"){
                        $nombre_descripcion = "Purita Mamá (PM)";
                    }
                    if ($nombre_descripcion == "15900070"){
                        $nombre_descripcion = "Fórmula de Inicio (FI)";
                    }

                    ?>
                <tr>
                    <?php
                    if($i==0){?>
                    <td rowspan='5' style="text-align:center; vertical-align:middle">Básico</td>
                    <?php
                    }
                    ?>
                    <td align='left' nowrap="nowrap"><?php echo $nombre_descripcion; ?></td>
                    <td align='right'><?php echo number_format($row->Col01,2,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col02,2,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col03,2,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col04,2,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col05,2,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col06,2,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col07,2,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col08,2,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col09,2,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col10,2,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col11,2,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col12,2,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col13,2,",",".")?></td>
                    <?php
                    $i++;
                }
                ?>
                </tr>
                <tr>
                    <td align='center'><strong>SUBTOTAL</strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol01a,2,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol02a,2,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol03a,2,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol04a,2,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol05a,2,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol06a,2,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol07a,2,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol08a,2,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol09a,2,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol10a,2,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol11a,2,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol12a,2,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol13a,2,",",".") ?></strong></td>
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
                          FROM (select c.* from 2020prestaciones c where c.codigo_prestacion in("15020300","15020400","15020500","15080011","15900080")) a
                          left join 2020rems b on (a.id_prestacion=b.prestacion_id_prestacion)
                          AND (b.Mes in ('.$mes.')) AND (b.establecimiento_id_establecimiento in ('.$estab.'))
                          group by  a.codigo_prestacion,a.descripcion,a.id_prestacion
                          order by a.id_prestacion';
                $registro = DB::connection('mysql_rem')->select($query);

                $i=0;

                $totalCol01b=0;
    						$totalCol02b=0;
    						$totalCol03b=0;
    						$totalCol04b=0;
    						$totalCol05b=0;
    						$totalCol06b=0;
    						$totalCol07b=0;
    						$totalCol08b=0;
    						$totalCol09b=0;
    						$totalCol10b=0;
    						$totalCol11b=0;
    						$totalCol12b=0;
                $totalCol13b=0;

                foreach($registro as $row ){
                    $totalCol01b=$totalCol01b+$row->Col01;
                    $totalCol02b=$totalCol02b+$row->Col02;
                    $totalCol03b=$totalCol03b+$row->Col03;
                    $totalCol04b=$totalCol04b+$row->Col04;
                    $totalCol05b=$totalCol05b+$row->Col05;
                    $totalCol06b=$totalCol06b+$row->Col06;
                    $totalCol07b=$totalCol07b+$row->Col07;
                    $totalCol08b=$totalCol08b+$row->Col08;
                    $totalCol09b=$totalCol09b+$row->Col09;
                    $totalCol10b=$totalCol10b+$row->Col10;
                    $totalCol11b=$totalCol11b+$row->Col11;
                    $totalCol12b=$totalCol12b+$row->Col12;
                    $totalCol13b=$totalCol13b+$row->Col13;

                    $nombre_descripcion = $row->codigo_prestacion;
                    if ($nombre_descripcion == "15020300"){
                        $nombre_descripcion = "Leche Purita Fortificada (LPF)";
                    }
                    if ($nombre_descripcion == "15020400"){
                        $nombre_descripcion = "Purita Cereal (PC)";
                    }
                    if ($nombre_descripcion == "15020500"){
                        $nombre_descripcion = "Mi Sopita (MS)";
                    }
                    if ($nombre_descripcion == "15080011"){
                        $nombre_descripcion = "Purita Mamá (PM)";
                    }
                    if ($nombre_descripcion == "15900080"){
                        $nombre_descripcion = "Fórmula de Inicio (FI)";
                    }
                    ?>
                <tr>
                    <?php
                    if($i==0){?>
                    <td rowspan='6' style="text-align:center; vertical-align:middle">Refuerzo</td>
                    <?php
                    }
                    ?>
                    <td align='left' nowrap="nowrap"><?php echo $nombre_descripcion; ?></td>
                    <td align='right'><?php echo number_format($row->Col01,2,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col02,2,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col03,2,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col04,2,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col05,2,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col06,2,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col07,2,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col08,2,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col09,2,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col10,2,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col11,2,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col12,2,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col13,2,",",".")?></td>
                    <?php
                    $i++;
                }
                ?>
                </tr>
                <tr>
                    <td align='center'><strong>SUBTOTAL</strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol01b,2,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol02b,2,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol03b,2,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol04b,2,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol05b,2,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol06b,2,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol07b,2,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol08b,2,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol09b,2,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol10b,2,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol11b,2,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol12b,2,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol13b,2,",",".") ?></strong></td>
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
                          FROM (select c.* from 2020prestaciones c where c.codigo_prestacion in("15040100","15040200","15080007","15080013")) a
                          left join 2020rems b on (a.id_prestacion=b.prestacion_id_prestacion)
                          AND (b.Mes in ('.$mes.')) AND (b.establecimiento_id_establecimiento in ('.$estab.'))
                          group by  a.codigo_prestacion,a.descripcion,a.id_prestacion
                          order by a.id_prestacion';
                $registro = DB::connection('mysql_rem')->select($query);

                $i=0;

                $totalCol01c=0;
    						$totalCol02c=0;
    						$totalCol03c=0;
    						$totalCol04c=0;
    						$totalCol05c=0;
    						$totalCol06c=0;
    						$totalCol07c=0;
    						$totalCol08c=0;
    						$totalCol09c=0;
    						$totalCol10c=0;
    						$totalCol11c=0;
    						$totalCol12c=0;
                $totalCol13c=0;

                foreach($registro as $row ){
                    $totalCol01c=$totalCol01c+$row->Col01;
                    $totalCol02c=$totalCol02c+$row->Col02;
                    $totalCol03c=$totalCol03c+$row->Col03;
                    $totalCol04c=$totalCol04c+$row->Col04;
                    $totalCol05c=$totalCol05c+$row->Col05;
                    $totalCol06c=$totalCol06c+$row->Col06;
                    $totalCol07c=$totalCol07c+$row->Col07;
                    $totalCol08c=$totalCol08c+$row->Col08;
                    $totalCol09c=$totalCol09c+$row->Col09;
                    $totalCol10c=$totalCol10c+$row->Col10;
                    $totalCol11c=$totalCol11c+$row->Col11;
                    $totalCol12c=$totalCol12c+$row->Col12;
                    $totalCol13c=$totalCol13c+$row->Col13;

                    $nombre_descripcion = $row->codigo_prestacion;
                    if ($nombre_descripcion == "15040100"){
                        $nombre_descripcion = "Fórmula de Prematuros (FP)";
                    }
                    if ($nombre_descripcion == "15040200"){
                        $nombre_descripcion = "Fórmula de Continuación (FC)";
                    }
                    if ($nombre_descripcion == "15080007"){
                        $nombre_descripcion = "Leche Purita Fortificada (LPF)";
                    }
                    if ($nombre_descripcion == "15080013"){
                        $nombre_descripcion = "Mi Sopita (MS)";
                    }
                    ?>
                <tr>
                    <?php
                    if($i==0){?>
                    <td rowspan='5' style="text-align:center; vertical-align:middle">Prematuros Extremos</td>
                    <?php
                    }
                    ?>
                    <td align='left' nowrap="nowrap"><?php echo $nombre_descripcion; ?></td>
                    <td align='right'><?php echo number_format($row->Col01,2,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col02,2,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col03,2,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col04,2,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col05,2,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col06,2,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col07,2,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col08,2,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col09,2,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col10,2,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col11,2,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col12,2,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col13,2,",",".")?></td>
                    <?php
                    $i++;
                }
                ?>
                </tr>
                <tr>
                    <td align='left'><strong>TOTAL</strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol01c,2,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol02c,2,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol03c,2,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol04c,2,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol05c,2,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol06c,2,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol07c,2,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol08c,2,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol09c,2,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol10c,2,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol11c,2,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol12c,2,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol13c,2,",",".") ?></strong></td>
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
                          FROM (select c.* from 2020prestaciones c where c.codigo_prestacion in("15901200","15901300")) a
                          left join 2020rems b on (a.id_prestacion=b.prestacion_id_prestacion)
                          AND (b.Mes in ('.$mes.')) AND (b.establecimiento_id_establecimiento in ('.$estab.'))
                          group by  a.codigo_prestacion,a.descripcion,a.id_prestacion
                          order by a.id_prestacion';
                $registro = DB::connection('mysql_rem')->select($query);

                $i=0;

                $totalCol01d=0;
    						$totalCol02d=0;
    						$totalCol03d=0;
    						$totalCol04d=0;
    						$totalCol05d=0;
    						$totalCol06d=0;
    						$totalCol07d=0;
    						$totalCol08d=0;
    						$totalCol09d=0;
    						$totalCol10d=0;
    						$totalCol11d=0;
    						$totalCol12d=0;
                $totalCol13d=0;

                foreach($registro as $row ){
                    $totalCol01d=$totalCol01d+$row->Col01;
                    $totalCol02d=$totalCol02d+$row->Col02;
                    $totalCol03d=$totalCol03d+$row->Col03;
                    $totalCol04d=$totalCol04d+$row->Col04;
                    $totalCol05d=$totalCol05d+$row->Col05;
                    $totalCol06d=$totalCol06d+$row->Col06;
                    $totalCol07d=$totalCol07d+$row->Col07;
                    $totalCol08d=$totalCol08d+$row->Col08;
                    $totalCol09d=$totalCol09d+$row->Col09;
                    $totalCol10d=$totalCol10d+$row->Col10;
                    $totalCol11d=$totalCol11d+$row->Col11;
                    $totalCol12d=$totalCol12d+$row->Col12;
                    $totalCol13d=$totalCol13d+$row->Col13;

                    $nombre_descripcion = $row->codigo_prestacion;
                    if ($nombre_descripcion == "15901200"){
                        $nombre_descripcion = "Fórmula Extensamente Hidrolizada (FEH)";
                    }
                    if ($nombre_descripcion == "15901300"){
                        $nombre_descripcion = "Fórmula Aminoacídica (FAA)";
                    }
                    ?>
                <tr>
                    <?php
                    if($i==0){?>
                    <td rowspan='3' style="text-align:center; vertical-align:middle">Alergia a la proteína de la leche de vaca **</td>
                    <?php
                    }
                    ?>
                    <td align='left' nowrap="nowrap"><?php echo $nombre_descripcion; ?></td>
                    <td align='right'><?php echo number_format($row->Col01,2,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col02,2,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col03,2,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col04,2,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col05,2,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col06,2,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col07,2,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col08,2,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col09,2,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col10,2,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col11,2,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col12,2,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col13,2,",",".")?></td>
                    <?php
                    $i++;
                }
                ?>
                </tr>
                <tr>
                    <td align='left'><strong>SUBTOTAL</strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol01d,2,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol02d,2,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol03d,2,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol04d,2,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol05d,2,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol06d,2,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol07d,2,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol08d,2,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol09d,2,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol10d,2,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol11d,2,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol12d,2,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol13d,2,",",".") ?></strong></td>
                </tr>
                <tr>
                    <td colspan="2" align='center'><strong>TOTAL</strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol01a+$totalCol01b+$totalCol01c+$totalCol01d,2,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol02a+$totalCol02b+$totalCol02c+$totalCol02d,2,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol03a+$totalCol03b+$totalCol03c+$totalCol03d,2,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol04a+$totalCol04b+$totalCol04c+$totalCol04d,2,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol05a+$totalCol05b+$totalCol05c+$totalCol05d,2,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol06a+$totalCol06b+$totalCol06c+$totalCol06d,2,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol07a+$totalCol07b+$totalCol07c+$totalCol07d,2,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol08a+$totalCol08b+$totalCol08c+$totalCol08d,2,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol09a+$totalCol09b+$totalCol09c+$totalCol09d,2,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol10a+$totalCol10b+$totalCol10c+$totalCol10d,2,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol11a+$totalCol11b+$totalCol11c+$totalCol11d,2,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol12a+$totalCol12b+$totalCol12c+$totalCol12d,2,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol13a+$totalCol13b+$totalCol13c+$totalCol13d,2,",",".") ?></strong></td>
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
                    <td colspan="14" class="active"><strong>Sección D: PNAC - Número de personas extrasistema que retiran.</strong></td>
                </tr>
                <tr>
                    <td rowspan="2" style="text-align:center; vertical-align:middle"><strong>Subprogramas</strong></td>
                    <td rowspan="2" style="text-align:center; vertical-align:middle"><strong>Total</strong></td>
                    <td colspan="7" align="center"><strong>Menores a 6 años</strong></td>
                    <td colspan="2" align="center"><strong>Gestantes</strong></td>
                    <td colspan="3" align="center"><strong>Madre con hijo/a menor a 6 meses</strong></td>
                </tr>
                <tr>
                    <td align="center"><strong>0 - 2 meses</strong></td>
                    <td align="center"><strong>3 - 5 meses</strong></td>
                    <td align="center"><strong>6 - 11 meses</strong></td>
                    <td align="center"><strong>12 - 17 meses</strong></td>
                    <td align="center"><strong>18 - 23 meses</strong></td>
                    <td align="center"><strong>24 - 47 meses</strong></td>
                    <td align="center"><strong>48 - 71 meses</strong></td>
                    <td align="center"><strong>Normal, sobrepeso y obesas</strong></td>
                    <td align="center"><strong>Bajo peso</strong></td>
                    <td align="center"><strong>Lactancia materna exclusiva</strong></td>
                    <td align="center"><strong>Lactancia materna predominante</strong></td>
                    <td align="center"><strong>Fórmula predominante o exclusiva</strong></td>
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
                          FROM (select c.* from 2020prestaciones c where c.codigo_prestacion in("15060100","15060200","15060600","15901400")) a
                          left join 2020rems b on (a.id_prestacion=b.prestacion_id_prestacion)
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
    						$totalCol07=0;
    						$totalCol08=0;
    						$totalCol09=0;
    						$totalCol10=0;
    						$totalCol11=0;
    						$totalCol12=0;
                $totalCol13=0;

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

                    $nombre_descripcion = $row->codigo_prestacion;
                    if ($nombre_descripcion == "15060100"){
                        $nombre_descripcion = "Básico";
                    }
                    if ($nombre_descripcion == "15060200"){
                        $nombre_descripcion = "Refuerzo";
                    }
                    if ($nombre_descripcion == "15060600"){
                        $nombre_descripcion = "Prematuros Extremos";
                    }
                    if ($nombre_descripcion == "15901400"){
                        $nombre_descripcion = "Alergia a la Proteína de la leche de vaca **";
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
                          FROM (select c.* from 2020prestaciones c where c.codigo_prestacion in("15900090")) a
                          left join 2020rems b on (a.id_prestacion=b.prestacion_id_prestacion)
                          AND (b.Mes in ('.$mes.')) AND (b.establecimiento_id_establecimiento in ('.$estab.'))
                          group by  a.codigo_prestacion,a.descripcion,a.id_prestacion
                          order by a.id_prestacion';
                $registro = DB::connection('mysql_rem')->select($query);

                $i=0;

                foreach($registro as $row ){

                    $nombre_descripcion = $row->codigo_prestacion;
                    if ($nombre_descripcion == "15900090"){
                        $nombre_descripcion = "Programas Sociales (*)";
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
                    <?php
                    $i++;
                }
                ?>
                </tr>
                <tr>
                    <td colspan="14">Nota: (*) Información referencial, ya incluida en los subprogramas. <br>
                                    (**) Exclusivamente para Fuerzas Armadas y de Orden.</td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- SECCION E
    <div class="col-sm tab table-responsive" id="E">
        <table class="table table-hover table-bordered table-sm">
            <thead>
                <tr>
                    <td colspan="15" class="active"><strong>Sección E: Existencia y movimiento total de productos (Intrasistema y Extrasistema).</strong></td>
                </tr>
                <tr>
                    <td rowspan="3" style="text-align:center; vertical-align:middle"><strong>Productos</strong></td>
                    <td rowspan="3" style="text-align:center; vertical-align:middle"><strong>Saldo Mes Anterior</strong></td>
                    <td colspan="2" align="center"><strong>Ingresos</strong></td>
                    <td rowspan="3" style="text-align:center; vertical-align:middle"><strong>Total Disponible</strong></td>
                    <td colspan="7" align="center"><strong>Egresos</strong></td>
                    <td rowspan="3" style="text-align:center; vertical-align:middle"><strong>Saldo mes siguiente</strong></td>
                    <td colspan="2" align="center"><strong>Necesidades</strong></td>
                </tr>
                <tr>
                    <td rowspan="2" style="text-align:center; vertical-align:middle"><strong>Planta</strong></td>
                    <td rowspan="2" style="text-align:center; vertical-align:middle"><strong>Por traspaso</strong></td>
                    <td colspan="3" align="center"><strong>Distribuido</strong></td>
                    <td rowspan="2" style="text-align:center; vertical-align:middle"><strong>Mermas (Incluye faltantes)</strong></td>
                    <td rowspan="2" style="text-align:center; vertical-align:middle"><strong>Otros: demostraciones, donaciones, etc</strong></td>
                    <td rowspan="2" style="text-align:center; vertical-align:middle"><strong>Traspaso</strong></td>
                    <td rowspan="2" style="text-align:center; vertical-align:middle"><strong>Total Egresos</strong></td>
                    <td rowspan="2" style="text-align:center; vertical-align:middle"><strong>Bodega del establecimiento</strong></td>
                    <td rowspan="2" style="text-align:center; vertical-align:middle"><strong>Bodegas centrales</strong></td>
                </tr>
                <tr>
                    <td align="center"><strong>Intrasistema</strong></td>
                    <td align="center"><strong>Extrasistema</strong></td>
                    <td align="center"><strong>Total</strong></td>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>-->

    <br>

    <div class="container">
    <!-- SECCION E -->
    <div class="col-sm tab table-responsive" id="E">
        <table class="table table-hover table-bordered table-sm">
            <thead>
                <tr>
                    <td colspan="3" class="active"><strong>Sección F: Número de reevaluaciones antropométricas a población del extrasistema</strong></td>
                </tr>
                <tr>
                    <td rowspan="2" style="text-align:center; vertical-align:middle"><strong>Funcionarios</strong></td>
                    <td colspan="2" align="center"><strong>Reevaluaciones efectuadas según tipo de establecimiento</strong></td>
                </tr>
                <tr>
                    <td align="center"><strong>Establecimiento del SS</strong></td>
                    <td align="center"><strong>Establecimiento Municipal</strong></td>
                </tr>
            </thead>
            <tbody>
                <?php
                $query = 'SELECT a.codigo_prestacion,a.descripcion
                              ,sum(ifnull(b.Col01,0)) Col01
                              ,sum(ifnull(b.Col02,0)) Col02
                          FROM (select c.* from 2020prestaciones c where c.codigo_prestacion in("15080001","15080002","15080004","15080003","15080005")) a
                          left join 2020rems b on (a.id_prestacion=b.prestacion_id_prestacion)
                          AND (b.Mes in ('.$mes.')) AND (b.establecimiento_id_establecimiento in ('.$estab.'))
                          group by  a.codigo_prestacion,a.descripcion,a.id_prestacion
                          order by a.id_prestacion';
                $registro = DB::connection('mysql_rem')->select($query);

                $i=0;

                foreach($registro as $row ){

                    $nombre_descripcion = $row->codigo_prestacion;
                    if ($nombre_descripcion == "15080001"){
                        $nombre_descripcion = "Médico";
                    }
                    if ($nombre_descripcion == "15080002"){
                        $nombre_descripcion = "Enfermera";
                    }
                    if ($nombre_descripcion == "15080004"){
                        $nombre_descripcion = "Nutricionista";
                    }
                    if ($nombre_descripcion == "15080003"){
                        $nombre_descripcion = "Matrona";
                    }
                    if ($nombre_descripcion == "15080005"){
                        $nombre_descripcion = "Auxiliar";
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
