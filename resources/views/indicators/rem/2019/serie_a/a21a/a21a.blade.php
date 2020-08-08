@extends('layouts.app')

@section('title', 'Resumen Estadistico Mensual')

@section('content')

<?php

use Illuminate\Support\Facades\DB;

?>

@include('indicators.rem.partials.nav')

<h3>REM-21. QUIROFANOS Y OTROS RECURSOS HOSPITALARIOS.</h3>

<br>

@include('indicators.rem.2019.serie_a.a21a.search')

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
                    <td colspan="25" class="active"><strong>SECCIÓN A: INGRESOS AGUDOS SEGÚN DIAGNOSTICO.</strong></td>
                </tr>
                <tr>
                    <td rowspan="2" style="text-align:center; vertical-align:middle"><strong>TIPO DE QUIRÓFANOS</strong></td>
                    <td rowspan="2" align="center" width="10%"><strong>NÙMERO DE QUIRÓFANOS EN DOTACIÓN</strong></td>
                    <td rowspan="2" align="center" width="10%"><strong>PROMEDIO MENSUAL DE QUIRÓFANOS HABILITADOS</strong></td>
                    <td rowspan="2" align="center" width="10%"><strong>PROMEDIO MENSUAL  DE QUIRÓFANOS EN TRABAJO</strong></td>
                    <td rowspan="2" align="center" width="10%"><strong>TOTAL DE HORAS MENSUALES DE QUIRÓFANOS HABILITADOS</strong></td>
                    <td rowspan="2" align="center" width="10%"><strong>TOTAL DE HORAS MENSUALES DE QUIRÓFANOS EN TRABAJO</strong></td>
                    <td colspan="4" align="center"><strong>HORAS MENSUALES PROGRAMADAS DE TABLA QUIRURGICA DE QUIRÓFANOS EN TRABAJO</strong></td>
                    <td colspan="5" align="center"><strong>HORAS MENSUALES OCUPADAS DE QUIRÓFANOS EN TRABAJO HORARIO HABIL</strong></td>
                    <td colspan="5" align="center"><strong>HORAS MENSUALES OCUPADAS DE QUIRÓFANOS EN TRABAJO HORARIO INHABIL DE LUNES A VIERNES</strong></td>
                    <td colspan="5" align="center"><strong>HORAS MENSUALES OCUPADAS DE QUIRÓFANOS EN TRABAJO HORARIO SABADO, DOMINGO Y FESTIVO</strong></td>
                </tr>
                <tr>
                    <td align="center"><strong>Totales</strong></td>
                    <td align="center"><strong>Beneficiarios MAI</strong></td>
                    <td align="center"><strong>Beneficiarios MLE</strong></td>
                    <td align="center"><strong>Otros</strong></td>
                    <td align="center"><strong>Totales</strong></td>
                    <td align="center"><strong>Beneficiarios MAI</strong></td>
                    <td align="center"><strong>Beneficiarios MLE</strong></td>
                    <td align="center"><strong>Otros</strong></td>
                    <td align="center"><strong>De preparación</strong></td>
                    <td align="center"><strong>Totales</strong></td>
                    <td align="center"><strong>Beneficiarios MAI</strong></td>
                    <td align="center"><strong>Beneficiarios MLE</strong></td>
                    <td align="center"><strong>Otros</strong></td>
                    <td align="center"><strong>De preparación</strong></td>
                    <td align="center"><strong>Totales</strong></td>
                    <td align="center"><strong>Beneficiarios MAI</strong></td>
                    <td align="center"><strong>Beneficiarios MLE</strong></td>
                    <td align="center"><strong>Otros</strong></td>
                    <td align="center"><strong>De preparación</strong></td>
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
                          FROM (select c.* from 2019prestaciones c where c.codigo_prestacion in("21220100","21220200","21220700","21220600")) a
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
                }
                ?>
                <tr>
                    <td align='left'><strong>TOTAL</strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol01,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol02,2,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol03,2,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol04,2,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol05,2,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol06,2,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol07,2,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol08,2,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol09,2,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol10,2,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol11,2,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol12,2,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol13,2,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol14,2,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol15,2,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol16,2,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol17,2,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol18,2,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol19,2,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol20,2,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol21,2,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol22,2,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol23,2,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol24,2,",",".") ?></strong></td>
                </tr>
                <?php

                foreach($registro as $row ){
                    $nombre_descripcion = $row->codigo_prestacion;
                    if ($nombre_descripcion == "21220100"){
                        $nombre_descripcion = "DE CIRUGÍA ELECTIVA";
      							}
      							if ($nombre_descripcion == "21220200"){
                        $nombre_descripcion = "DE URGENCIA";
      							}
      							if ($nombre_descripcion == "21220700"){
                        $nombre_descripcion = "OBSTÉTRICO";
      							}
      							if ($nombre_descripcion == "21220600"){
                        $nombre_descripcion = "INDIFERENCIADO";
      							}
                    ?>
                <tr>
                    <td align='left' nowrap="nowrap"><?php echo $nombre_descripcion; ?></td>
                    <td align='right'><?php echo number_format($row->Col01,0,",",".")?></td>
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
                    <td align='right'><?php echo number_format($row->Col14,2,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col15,2,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col16,2,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col17,2,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col18,2,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col19,2,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col20,2,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col21,2,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col22,2,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col23,2,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col24,2,",",".")?></td>
                    <?php
                    $i++;
                }
                ?>
                </tr>
            </tbody>
        </table>
    </div>

    <br>

    </div>
<?php
}
?>

@endsection

@section('custom_js')
    <script src="{{ asset('js/show_hide_tab.js') }}" defer></script>
    <script src="{{ asset('js/bootstrap-multiselect.js') }}" defer></script>
@endsection
