@extends('layouts.app')

@section('title', 'Resumen Estadistico Mensual')

@section('content')

<?php

use Illuminate\Support\Facades\DB;

?>

@include('indicators.rem.partials.nav')

<h3>REM-29. PROGRAMA DE IMÁGENES DIAGNÓSTICAS Y/O RESOLUTIVIDAD EN ATENCION PRIMARIA.</h3>

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

    <!-- SECCION A -->
    <div class="col-sm tab table-responsive" id="A">
        <table class="table table-hover table-bordered table-sm">
            <thead>
                <tr>
                    <td colspan="16" class="active"><strong>SECCIÓN A: PROGRAMA DE RESOLUTIVIDAD ATENCIÓN PRIMARIA DE SALUD.</strong></td>
                </tr>
                <tr>
                    <td rowspan="2" style="text-align:center; vertical-align:middle"><strong>CONSULTAS	</strong></td>
                    <td colspan="3" align="center"><strong>TOTAL</strong></td>
                    <td colspan="2" align="center"><strong><15</strong></td>
                    <td colspan="2" align="center"><strong>15 - 19</strong></td>
                    <td colspan="2" align="center"><strong>20 - 64</strong></td>
                    <td colspan="2" align="center"><strong>65 Y MÁS</strong></td>
                    <td colspan="2" align="center"><strong>TOTAL INTERCONSULTAS GENERADAS EN APS PARA RESOLUCIÓN POR ESPECIALIDAD OFTALMOLOGÍA (UAPO Y CANASTA INTEGRAL)</strong></td>
                    <td colspan="2" align="center"><strong>TOTAL INTERCONSULTAS GENERADAS EN APS PARA RESOLUCIÓN POR ESPECIALIDAD OTORRINOLARINGOLOGÍA (UAPORRINO Y CANASTA INTEGRAL)	</strong></td>
                </tr>
                <tr>
                    <td align="center"><strong>Ambos&nbsp;Sexos</strong></td>
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
                    <td align="center"><strong>Menos 15 años</strong></td>
                    <td align="center"><strong>15 y más años</strong></td>
                    <td align="center"><strong>Menos 15 años</strong></td>
                    <td align="center"><strong>15 y más años</strong></td>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td align="center"><strong>CONSULTAS MÉDICAS DE ESPECIALIDADES</strong></td>
                    <td colspan="15" class="active"></td>
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
                          FROM (select c.* from 2020prestaciones c where c.codigo_prestacion in("29000000","29000001")) a
                          left join 2020rems b on (a.id_prestacion=b.prestacion_id_prestacion)
                          AND (b.Mes in ('.$mes.')) AND (b.establecimiento_id_establecimiento in ('.$estab.'))
                          group by a.codigo_prestacion, a.descripcion, a.id_prestacion
                          order by a.id_prestacion';
                $registro = DB::connection('mysql_rem')->select($query);

                $i=0;

                foreach($registro as $row ){
                    $nombre_descripcion = $row->codigo_prestacion;
                    if ($nombre_descripcion == "29000000"){
                        $nombre_descripcion = "OFTALMOLOGÍA /UAPO";
      							}
      							if ($nombre_descripcion == "29000001"){
                        $nombre_descripcion = "OTORRINOLARINGOLOGÍA/UAPORRINO";
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
                    <?php
                    $i++;
                }
                ?>
                </tr>
                <tr>
                    <td align="center"><strong>CONSULTAS OTROS PROFESIONALES</strong></td>
                    <td colspan="15" class="active"></td>
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
                          FROM (select c.* from 2020prestaciones c where c.codigo_prestacion in("29000002","29000003","29000070","29000071","29101010","29101020")) a
                          left join 2020rems b on (a.id_prestacion=b.prestacion_id_prestacion)
                          AND (b.Mes in ('.$mes.')) AND (b.establecimiento_id_establecimiento in ('.$estab.'))
                          group by a.codigo_prestacion, a.descripcion, a.id_prestacion
                          order by a.id_prestacion';
                $registro = DB::connection('mysql_rem')->select($query);

                $i=0;

                foreach($registro as $row ){
                    $nombre_descripcion = $row->codigo_prestacion;
                    if ($nombre_descripcion == "29000002"){
                        $nombre_descripcion = "TECNÓLOGO MÉDICO POR VICIO DE REFRACCIÓN";
      							}
      							if ($nombre_descripcion == "29000003"){
                        $nombre_descripcion = "TECNÓLOGO MÉDICO (OFTALMOLOGIA) OTRAS CONSULTAS";
      							}
                    if ($nombre_descripcion == "29000070"){
                        $nombre_descripcion = "TECNÓLOGO MÉDICO O FONOAUDIÓLOGO POR HIPOACUSIA (UAPORRINO)	";
      							}
                    if ($nombre_descripcion == "29000071"){
                        $nombre_descripcion = "TECNÓLOGO MÉDICO O FONOAUDIÓLOGO CONSULTAS (UAPORRINO)";
      							}
                    if ($nombre_descripcion == "29101010"){
                        $nombre_descripcion = "CONSULTA DE CALIFICACIÓN DE URGENCIA POR TECNÓLOGO MÉDICO (UAPO)";
      							}
                    if ($nombre_descripcion == "29101020"){
                        $nombre_descripcion = "TERAPEUTA OCUPACIONAL";
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
                    <?php
                    $i++;
                }
                ?>
                </tr>
                <tr>
                    <td align="center"><strong>INGRESOS Y EGRESOS GLAUCOMA UAPO</strong></td>
                    <td colspan="15" class="active"></td>
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
                          FROM (select c.* from 2020prestaciones c where c.codigo_prestacion in("29000004","29000005")) a
                          left join 2020rems b on (a.id_prestacion=b.prestacion_id_prestacion)
                          AND (b.Mes in ('.$mes.')) AND (b.establecimiento_id_establecimiento in ('.$estab.'))
                          group by a.codigo_prestacion, a.descripcion, a.id_prestacion
                          order by a.id_prestacion';
                $registro = DB::connection('mysql_rem')->select($query);

                $i=0;

                foreach($registro as $row ){
                    $nombre_descripcion = $row->codigo_prestacion;
                    if ($nombre_descripcion == "29000004"){
                        $nombre_descripcion = "INGRESOS GLAUCOMA UAPO";
      							}
      							if ($nombre_descripcion == "29000005"){
                        $nombre_descripcion = "EGRESOS GLAUCOMA UAPO";
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
                    <?php
                    $i++;
                }
                ?>
                </tr>
                <tr>
                    <td align="center"><strong>GLAUCOMA (por médico)</strong></td>
                    <td colspan="15" class="active"></td>
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
                          FROM (select c.* from 2020prestaciones c where c.codigo_prestacion in("29101030","29101040")) a
                          left join 2020rems b on (a.id_prestacion=b.prestacion_id_prestacion)
                          AND (b.Mes in ('.$mes.')) AND (b.establecimiento_id_establecimiento in ('.$estab.'))
                          group by a.codigo_prestacion, a.descripcion, a.id_prestacion
                          order by a.id_prestacion';
                $registro = DB::connection('mysql_rem')->select($query);

                $i=0;

                foreach($registro as $row ){
                    $nombre_descripcion = $row->codigo_prestacion;
                    if ($nombre_descripcion == "29101030"){
                        $nombre_descripcion = "CONTROLES DE GLAUCOMA UAPO";
      							}
                    if ($nombre_descripcion == "29101040"){
                        $nombre_descripcion = "CONSULTA DESCARTE GLAUCOMA	";
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
                    <td colspan="15" class="active"><strong>SECCIÓN B: PROCEDIMIENTOS DE IMÁGENES DIAGNOSTICAS Y PROGRAMA DE RESOLUTIVIDAD EN APS.</strong></td>
                </tr>
                <tr>
                    <td rowspan="2" colspan="2" style="text-align:center; vertical-align:middle"><strong>TIPO DE EXAMEN Y PROCEDIMIENTO DIAGNOSTICO</strong></td>
                    <td rowspan="2" style="text-align:center; vertical-align:middle"><strong>TOTAL</strong></td>
                    <td colspan="9" align="center"><strong>POR EDAD (EN AÑOS)</strong></td>
                    <td colspan="3" align="center"><strong>MODALIDAD</strong></td>
                </tr>
                <tr>
                    <td align="center"><strong>< 35</strong></td>
                    <td align="center"><strong>35 A 49</strong></td>
                    <td align="center"><strong>50 a 54</strong></td>
                    <td align="center"><strong>55 a 59</strong></td>
                    <td align="center"><strong>60 a 64</strong></td>
                    <td align="center"><strong>65 a 69</strong></td>
                    <td align="center"><strong>70 a 74</strong></td>
                    <td align="center"><strong>75 a 79</strong></td>
                    <td align="center"><strong>80 y más</strong></td>
                    <td align="center"><strong>INSTITUCIONAL</strong></td>
                    <td align="center"><strong>COMPRA AL SISTEMA</strong></td>
                    <td align="center"><strong>COMPRA EXTRASISTEMA</strong></td>
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
                          FROM (select c.* from 2020prestaciones c where c.codigo_prestacion in("29000007","29000008","29000009","29000010","29000011","29000012","29000013","29000048",
                                                                                                "29000014","29000015","29000016",
                                                                                                "29000017","29000018","29000019",
                                                                                                "29000020","29000021","29000022","29000023","29000024","29000025",
                                                                                                "29000026","29000027","29000028","29000029",
                                                                                                "29000049","29000050","29000051","29000052",
                                                                                                "29000030","29000031")) a
                          left join 2020rems b on (a.id_prestacion=b.prestacion_id_prestacion)
                          AND (b.Mes in ('.$mes.')) AND (b.establecimiento_id_establecimiento in ('.$estab.'))
                          group by a.codigo_prestacion, a.descripcion, a.id_prestacion
                          order by a.id_prestacion';
                $registro = DB::connection('mysql_rem')->select($query);

                $i=0;

                foreach($registro as $row ){
                    $nombre_descripcion = $row->codigo_prestacion;
                    if ($nombre_descripcion == "29000007"){
                        $nombre_descripcion = "SOLICITADAS";
      							}
                    if ($nombre_descripcion == "29000008"){
                        $nombre_descripcion = "INFORMADAS";
      							}
                    if ($nombre_descripcion == "29000009"){
                        $nombre_descripcion = "CON BIRADS 0";
      							}
                    if ($nombre_descripcion == "29000010"){
                        $nombre_descripcion = "CON BIRADS 1 o 2";
      							}
                    if ($nombre_descripcion == "29000011"){
                        $nombre_descripcion = "CON BIRADS  3";
      							}
                    if ($nombre_descripcion == "29000012"){
                        $nombre_descripcion = "CON BIRADS  4, 5 o 6";
      							}
                    if ($nombre_descripcion == "29000013"){
                        $nombre_descripcion = "SIN INFORME BIRADS";
      							}
                    if ($nombre_descripcion == "29000048"){
                        $nombre_descripcion = "MAGNIFICACIONES";
      							}
                    if ($nombre_descripcion == "29000014"){
                        $nombre_descripcion = "MAMARIA	SOLICITADAS";
      							}
                    if ($nombre_descripcion == "29000015"){
                        $nombre_descripcion = "INFORMADAS";
      							}
                    if ($nombre_descripcion == "29000016"){
                        $nombre_descripcion = "CON INFORME DE SOSPECHA DE MALIGNIDAD";
      							}
                    if ($nombre_descripcion == "29000017"){
                        $nombre_descripcion = "SOLICITADAS";
      							}
                    if ($nombre_descripcion == "29000018"){
                        $nombre_descripcion = "INFORMADAS";
      							}
                    if ($nombre_descripcion == "29000019"){
                        $nombre_descripcion = "CON RESULTADO LITIASIS BILIAR";
      							}
                    if ($nombre_descripcion == "29000020"){
                        $nombre_descripcion = "SOLICITADAS";
      							}
                    if ($nombre_descripcion == "29000021"){
                        $nombre_descripcion = "INFORMADAS";
      							}
                    if ($nombre_descripcion == "29000022"){
                        $nombre_descripcion = "TOMA DE BIOPSIA";
      							}
                    if ($nombre_descripcion == "29000023"){
                        $nombre_descripcion = "CON INFORME DE SOSPECHA DE MALIGNIDAD";
      							}
                    if ($nombre_descripcion == "29000024"){
                        $nombre_descripcion = "TEST DE UREASA SOLICITADAS";
      							}
                    if ($nombre_descripcion == "29000025"){
                        $nombre_descripcion = "TEST DE UREASA POSITIVAS (+) H PYLORI";
      							}
                    if ($nombre_descripcion == "29000026"){
                        $nombre_descripcion = "SOLICITADAS";
      							}
                    if ($nombre_descripcion == "29000027"){
                        $nombre_descripcion = "REALIZADAS";
      							}
                    if ($nombre_descripcion == "29000028"){
                        $nombre_descripcion = "BIOPSIAS DE CIRUGÍA MENOR ENVIADAS A ANATOMÍA PATOLÓGICA";
      							}
                    if ($nombre_descripcion == "29000029"){
                        $nombre_descripcion = "N° BIOPSIAS DE CIRUGÍA MENOR CON INFORME DE SOSPECHA DE MALIGNIDAD";
      							}
                    if ($nombre_descripcion == "29000049"){
                        $nombre_descripcion = "SOLICITADAS";
      							}
                    if ($nombre_descripcion == "29000050"){
                        $nombre_descripcion = "REALIZADAS";
      							}
                    if ($nombre_descripcion == "29000051"){
                        $nombre_descripcion = "ANTERO POSTERIOR (FRONTAL)";
      							}
                    if ($nombre_descripcion == "29000052"){
                        $nombre_descripcion = "ANTERO POSTERIOR  Y LATERAL";
      							}
                    if ($nombre_descripcion == "29000030"){
                        $nombre_descripcion = "SOLICITADAS";
      							}
                    if ($nombre_descripcion == "29000031"){
                        $nombre_descripcion = "INFORMADAS";
      							}
                    ?>
                <tr>
                    <?php
                    if($i==0){?>
                    <td rowspan="8" style="text-align:center; vertical-align:middle">MAMOGRAFÍA</td>
                    <?php
                    }
                    if($i==8){?>
                    <td rowspan="3" style="text-align:center; vertical-align:middle">ECOTOMOGRAFÍA MAMARIA</td>
                    <?php
                    }
                    if($i==11){?>
                    <td rowspan="3" style="text-align:center; vertical-align:middle">ECOTOMOGRAFÍA ABDOMINA</td>
                    <?php
                    }
                    if($i==14){?>
                    <td rowspan="6" style="text-align:center; vertical-align:middle">ENDOSCOPIA DIGESTIVA ALTA</td>
                    <?php
                    }
                    if($i==20){?>
                    <td rowspan="4" style="text-align:center; vertical-align:middle">CIRUGÍA MENOR</td>
                    <?php
                    }
                    if($i==24){?>
                    <td rowspan="4" style="text-align:center; vertical-align:middle">RADIOGRAFIA TORAX POR SOSPECHA NEUMONIA Y SOSPECHA DE OTRA PATOLOGÍA RESPIRATORIA CRONICA</td>
                    <?php
                    }
                    if($i==28){?>
                    <td rowspan="2" style="text-align:center; vertical-align:middle">RADIOGRAFÍA DE CADERAS 3-6 MESES (SCREENING)</td>
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
    <!-- SECCION B -->
    <div class="col-sm tab table-responsive" id="C">
        <table class="table table-hover table-bordered table-sm">
            <thead>
                <tr>
                    <td colspan="3" class="active"><strong>SECCIÓN C: PROCEDIMIENTOS APOYO CLÍNICO Y TERAPÉUTICO.</strong></td>
                </tr>
                <tr>
                    <td align="center"><strong>ESPECIALIDAD</strong></td>
                    <td align="center"><strong>PROCEDIMIENTOS</strong></td>
                    <td align="center"><strong>TOTAL</strong></td>
                </tr>
            </thead>
            <tbody>
                <?php
                $query = 'SELECT a.codigo_prestacion,a.descripcion
                              ,sum(ifnull(b.Col01,0)) Col01
                          FROM (select c.* from 2020prestaciones c where c.codigo_prestacion in("29000034","29000035","29000036","29000037","29000038","29000039","29000040","29000041",
                                                                                                "29000042","29000043","29101050","29101060","29000053","29000054","29000055","29000056",
                                                                                                "29101070","29101080","29101090","29101100","29101110",
                                                                                                "29000045","29000046","29000060","29000061","29000047")) a
                          left join 2020rems b on (a.id_prestacion=b.prestacion_id_prestacion)
                          AND (b.Mes in ('.$mes.')) AND (b.establecimiento_id_establecimiento in ('.$estab.'))
                          group by a.codigo_prestacion, a.descripcion, a.id_prestacion
                          order by a.id_prestacion';
                $registro = DB::connection('mysql_rem')->select($query);

                $i=0;

                foreach($registro as $row ){
                    $nombre_descripcion = $row->codigo_prestacion;
                    if ($nombre_descripcion == "29000034"){
                        $nombre_descripcion = "CUANTIFICACIÓN DE LAGRIMACIÓN (TEST DE SCHIMER), UNO O AMBOS OJOS";
      							}
                    if ($nombre_descripcion == "29000035"){
                        $nombre_descripcion = "CURVA DE TENSIÓN APLANÁTICA (POR CADA DÍA), C/OJO	";
      							}
                    if ($nombre_descripcion == "29000036"){
                        $nombre_descripcion = "DISPLOSCOPIA CUANTITATIVA, AMBOS OJOS	";
      							}
                    if ($nombre_descripcion == "29000037"){
                        $nombre_descripcion = "EXPLORACIÓN SENSORIOMOTORA: ESTRABISMO, ESTUDIO COMPLETO, AMBOS OJOS";
      							}
                    if ($nombre_descripcion == "29000038"){
                        $nombre_descripcion = "RETINOGRAFÍA, AMBOS OJOS";
      							}
                    if ($nombre_descripcion == "29000039"){
                        $nombre_descripcion = "TONOMETRÍA APLANÁTICA C/OJO";
      							}
                    if ($nombre_descripcion == "29000040"){
                        $nombre_descripcion = "TRATAMIENTO ORTÓPTICO Y/O PLEÓPTICO (POR SESIÓN), AMBOS OJOS";
      							}
                    if ($nombre_descripcion == "29000041"){
                        $nombre_descripcion = "EXPLORACIÓN VITREORRETINAL, AMBOS OJOS (FONDO DE OJO)";
      							}
                    if ($nombre_descripcion == "29000042"){
                        $nombre_descripcion = "CUERPO EXTRAÑO CONJUNTIVAL Y/O CORNEAL";
      							}
                    if ($nombre_descripcion == "29000043"){
                        $nombre_descripcion = "CAMPIMETRÍA COMPUTARIZADA, C/OJO (EN UAPO)";
      							}
                    if ($nombre_descripcion == "29101050"){
                        $nombre_descripcion = "TOMOGRAFIA COHERENTE ÓPTICA, C/OJO";
      							}
                    if ($nombre_descripcion == "29101060"){
                        $nombre_descripcion = "AGUDEZA VISUAL AISLADA CADA OJO";
      							}
                    if ($nombre_descripcion == "29000053"){
                        $nombre_descripcion = "TOMOGRAFIA COHERENTE OPTICA";
      							}
                    if ($nombre_descripcion == "29000054"){
                        $nombre_descripcion = "PAQUIMETRIA";
      							}
                    if ($nombre_descripcion == "29000055"){
                        $nombre_descripcion = "AUTOREFRACTOMIA";
      							}
                    if ($nombre_descripcion == "29000056"){
                        $nombre_descripcion = "LENSOMETRIA";
      							}
                    if ($nombre_descripcion == "29101070"){
                        $nombre_descripcion = "EXTRACCIÓN CUERPO EXTRAÑO OJO (EXCLUYE CONJUNTIVAL Y/O CORNEAL)";
      							}
                    if ($nombre_descripcion == "29101080"){
                        $nombre_descripcion = "HEMOGLUCOTEST PREVIO A CONSULTA VICIO DE REFRACCIÓN EN PACIENTE DIABÉTICO	";
      							}
                    if ($nombre_descripcion == "29101090"){
                        $nombre_descripcion = "AUTORREFRACCIÓN BAJO CICLOPLEJIA";
      							}
                    if ($nombre_descripcion == "29101100"){
                        $nombre_descripcion = "IRRIGACIÓN DE LA VÍA LAGRIMAL";
      							}
                    if ($nombre_descripcion == "29101110"){
                        $nombre_descripcion = "PRUEBA DE PROVOCACIÓN OSCURIDAD MÁS PRONACIÓN	";
      							}

                    if ($nombre_descripcion == "29000045"){
                        $nombre_descripcion = "AUDIMETRÍAS (REALIZADAS)";
      							}
                    if ($nombre_descripcion == "29000046"){
                        $nombre_descripcion = "IMPEDANCIOMETRÍA";
      							}
                    if ($nombre_descripcion == "29000060"){
                        $nombre_descripcion = "EMISIONES OTOACUSTICAS";
      							}
                    if ($nombre_descripcion == "29000061"){
                        $nombre_descripcion = "CALIBRACION AUDIFONOS";
      							}
                    if ($nombre_descripcion == "29000047"){
                        $nombre_descripcion = "EXAMEN FUNCIONAL VIII PAR";
      							}
                    ?>
                <tr>
                    <?php
                    if($i==0){?>
                    <td rowspan="21" style="text-align:center; vertical-align:middle">OFTALMOLOGÍA</td>
                    <?php
                    }
                    if($i==21){?>
                    <td rowspan="5" style="text-align:center; vertical-align:middle">OTORRINOLARINGOLOGÍA </td>
                    <?php
                    }
                    ?>
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

    <!-- SECCION B -->
    <div class="col-sm tab table-responsive" id="C">
        <table class="table table-hover table-bordered table-sm">
            <thead>
                <tr>
                    <td colspan="6" class="active"><strong>SECCIÓN D: ENTREGA DE AYUDAS TÉCNICAS.</strong></td>
                </tr>
                <tr>
            			<td rowspan="2" style="text-align:center; vertical-align:middle"><strong>CONCEPTO</strong></td>
            			<td rowspan="2" style="text-align:center; vertical-align:middle"><strong>Ambos Sexos</strong></td>
            			<td colspan="2" align="center"><strong>< 65 Años</strong></td>
            			<td colspan="2" align="center"><strong>De 65 años y más</strong></td>
            		</tr>
            		<tr>
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
                          FROM (select c.* from 2020prestaciones c where c.codigo_prestacion in("29101120","29101130")) a
                          left join 2020rems b on (a.id_prestacion=b.prestacion_id_prestacion)
                          AND (b.Mes in ('.$mes.')) AND (b.establecimiento_id_establecimiento in ('.$estab.'))
                          group by a.codigo_prestacion, a.descripcion, a.id_prestacion
                          order by a.id_prestacion';
                $registro = DB::connection('mysql_rem')->select($query);

                $i=0;

                foreach($registro as $row ){
                    $nombre_descripcion = $row->codigo_prestacion;
                    if ($nombre_descripcion == "29101120"){
                        $nombre_descripcion = "LENTES (Entregados)	";
      							}
                    if ($nombre_descripcion == "29101130"){
                        $nombre_descripcion = "AUDÍFONOS (Entregados)	";
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
