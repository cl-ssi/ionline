@extends('layouts.app')

@section('title', 'Resumen Estadistico Mensual')

@section('content')

<?php

use Illuminate\Support\Facades\DB;

?>

@include('indicators.rem.partials.nav')

<h3>REM-30. ATENCIONES POR TELEMEDICINA EN LA RED ASISTENCIAL.</h3>

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
                    <td colspan="27" class="active"><strong>SECCION A: TELECONSULTA MEDICA DE ESPECIALIDAD.</strong></td>
                </tr>
                <tr>
                    <td rowspan="3" style="text-align:center; vertical-align:middle"><strong>ESPECIALIDADES</strong></td>
                    <td colspan="4" align="center"><strong>TELECONSULTA MEDICA DE ESPECIALIDAD AMBULATORIA NUEVA</strong></td>
                    <td colspan="4" align="center"><strong>TELECONSULTA MEDICA DE ESPECIALIDAD AMBULATORIA CONTROL</strong></td>
                    <td colspan="4" align="center"><strong>TOTAL TELECONSULTAS MEDICAS AMBULATORIAS DE ESPECIALIDAD REALIZADAS POR TELEMEDICINA</strong></td>
                    <td colspan="3" align="center"><strong>MODALIDAD</strong></td>
                    <td colspan="4" align="center"><strong>TELECONSULTA MEDICA DE ESPECIALIDAD REALIZADAS A PACIENTES HOSPITALIZADOS</strong></td>
                    <td colspan="3" align="center"><strong>MODALIDAD</strong></td>
                    <td colspan="4" align="center"><strong>CONSULTAS POR TELEMEDICINA SOLICITADAS DESDE APS O NIVEL SECUNDARIO RESUELTAS POR OTRO</strong></td>
                </tr>
                <tr>
                    <td colspan="2" align="center"><strong>MENORES DE 15 AÑOS</strong></td>
                    <td colspan="2" align="center"><strong>15 AÑOS Y MÁS</strong></td>
                    <td colspan="2" align="center"><strong>MENORES DE 15 AÑOS</strong></td>
                    <td colspan="2" align="center"><strong>15 AÑOS Y MÁS</strong></td>
                    <td colspan="2" align="center"><strong>MENORES DE 15 AÑOS</strong></td>
                    <td colspan="2" align="center"><strong>15 AÑOS Y MÁS</strong></td>
                    <td rowspan="2" style="text-align:center; vertical-align:middle"><strong>Institucional</strong></td>
                    <td colspan="2" style="text-align:center; vertical-align:middle"><strong>Compra de Servicio</strong></td>
                    <td colspan="2" align="center"><strong>MENORES DE 15 AÑOS</strong></td>
                    <td colspan="2" align="center"><strong>15 AÑOS Y MÁS</strong></td>
                    <td rowspan="2" style="text-align:center; vertical-align:middle"><strong>Institucional</strong></td>
                    <td colspan="2" style="text-align:center; vertical-align:middle"><strong>Compra de Servicio</strong></td>
                    <td colspan="2" align="center"><strong>MENORES DE 15 AÑOS</strong></td>
                    <td colspan="2" align="center"><strong>15 AÑOS Y MÁS</strong></td>
                </tr>
                <tr>
                    <td align="center"><strong>HOMBRES</strong></td>
                    <td align="center"><strong>MUJERES</strong></td>
                    <td align="center"><strong>HOMBRES</strong></td>
                    <td align="center"><strong>MUJERES</strong></td>
                    <td align="center"><strong>HOMBRES</strong></td>
                    <td align="center"><strong>MUJERES</strong></td>
                    <td align="center"><strong>HOMBRES</strong></td>
                    <td align="center"><strong>MUJERES</strong></td>
                    <td align="center"><strong>HOMBRES</strong></td>
                    <td align="center"><strong>MUJERES</strong></td>
                    <td align="center"><strong>HOMBRES</strong></td>
                    <td align="center"><strong>MUJERES</strong></td>
                    <td align="center"><strong>Sistema</strong></td>
                    <td align="center"><strong>Extrasistema</strong></td>
                    <td align="center"><strong>HOMBRES</strong></td>
                    <td align="center"><strong>MUJERES</strong></td>
                    <td align="center"><strong>HOMBRES</strong></td>
                    <td align="center"><strong>MUJERES</strong></td>
                    <td align="center"><strong>Sistema</strong></td>
                    <td align="center"><strong>Extrasistema</strong></td>
                    <td align="center"><strong>HOMBRES</strong></td>
                    <td align="center"><strong>MUJERES</strong></td>
                    <td align="center"><strong>HOMBRES</strong></td>
                    <td align="center"><strong>MUJERES</strong></td>
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
                          FROM (select c.* from 2020prestaciones c where c.codigo_prestacion in("30000000","30000001","30000002","30000003","30000004","30000005","30000006","30000007",
                                                                                                "30000008","30000009","30000010","30000011","30000012","30000013","30000014","30000015",
                                                                                                "30000016","30000017","30000018","30000019","30000020","30000021","30000022","30000023",
                                                                                                "30000024","30000025","30000026","30000027","30000028","30000029","30000030","30000031",
                                                                                                "30000032","30000033","30000034","30000035","30000036","30000037","30000038","30000039",
                                                                                                "30000040","30000041","30000042","30000043","30000044","30000045","30000046","30000047",
                                                                                                "30000048","30000049","30000050","30000051","30000052","30000053","30000054","30000086",
                                                                                                "30000055","30000056","30000087","30000088")) a
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
                $totalCol26=0;

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
                    <td align='right'><strong><?php echo number_format($totalCol26,0,",",".") ?></strong></td>
                </tr>
                <?php
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

                    $nombre_descripcion = $row->codigo_prestacion;
                    if ($nombre_descripcion == "30000000"){
                        $nombre_descripcion = "PEDIATRÍA";
      							}
                    if ($nombre_descripcion == "30000001"){
                        $nombre_descripcion = "MEDICINA INTERNA";
      							}
                    if ($nombre_descripcion == "30000002"){
                        $nombre_descripcion = "NEONATOLOGÍA";
      							}
                    if ($nombre_descripcion == "30000003"){
                        $nombre_descripcion = "ENFERMEDAD RESPIRATORIA PEDIÁTRICA (BRONCOPULMONAR INFANTIL)";
      							}
                    if ($nombre_descripcion == "30000004"){
                        $nombre_descripcion = "ENFERMEDAD RESPIRATORIA DE ADULTO (BRONCOPULMONAR)";
      							}
                    if ($nombre_descripcion == "30000005"){
                        $nombre_descripcion = "CARDIOLOGÍA PEDIÁTRICA";
      							}
                    if ($nombre_descripcion == "30000006"){
                        $nombre_descripcion = "CARDIOLOGÍA ADULTO";
      							}
                    if ($nombre_descripcion == "30000007"){
                        $nombre_descripcion = "ENDOCRINOLOGÍA PEDIÁTRICA";
      							}
                    if ($nombre_descripcion == "30000008"){
                        $nombre_descripcion = "ENDOCRINOLOGÍA ADULTO";
      							}
                    if ($nombre_descripcion == "30000009"){
                        $nombre_descripcion = "GASTROENTEROLOGÍA PEDIÁTRICA";
      							}
                    if ($nombre_descripcion == "30000010"){
                        $nombre_descripcion = "GASTROENTEROLOGÍA ADULTO";
      							}
                    if ($nombre_descripcion == "30000011"){
                        $nombre_descripcion = "GENÉTICA CLÍNICA";
      							}
                    if ($nombre_descripcion == "30000012"){
                        $nombre_descripcion = "HEMATO-ONCOLOGÍA INFANTIL";
      							}
                    if ($nombre_descripcion == "30000013"){
                        $nombre_descripcion = "HEMATOLOGÍA ADULTO";
      							}
                    if ($nombre_descripcion == "30000014"){
                        $nombre_descripcion = "NEFROLOGÍA PEDIÁTRICA";
      							}
                    if ($nombre_descripcion == "30000015"){
                        $nombre_descripcion = "NEFROLOGÍA ADULTO";
      							}
                    if ($nombre_descripcion == "30000016"){
                        $nombre_descripcion = "NUTRIÓLOGO PEDIÁTRICO";
      							}
                    if ($nombre_descripcion == "30000017"){
                        $nombre_descripcion = "NUTRIÓLOGO ADULTO";
      							}
                    if ($nombre_descripcion == "30000018"){
                        $nombre_descripcion = "REUMATOLOGÍA PEDIÁTRICA";
      							}
                    if ($nombre_descripcion == "30000019"){
                        $nombre_descripcion = "REUMATOLOGÍA ADULTO";
      							}
                    if ($nombre_descripcion == "30000020"){
                        $nombre_descripcion = "DERMATOLOGÍA";
      							}
                    if ($nombre_descripcion == "30000021"){
                        $nombre_descripcion = "INFECTOLOGÍA PEDIÁTRICA";
      							}
                    if ($nombre_descripcion == "30000022"){
                        $nombre_descripcion = "INFECTOLOGÍA ADULTO";
      							}
                    if ($nombre_descripcion == "30000023"){
                        $nombre_descripcion = "INMUNOLOGÍA";
      							}
                    if ($nombre_descripcion == "30000024"){
                        $nombre_descripcion = "GERIATRÍA";
      							}
                    if ($nombre_descripcion == "30000025"){
                        $nombre_descripcion = "MEDICINA FÍSICA Y REHABILITACIÓN PEDIÁTRICA (FISIATRÍA PEDIÁTRICA)";
      							}
                    if ($nombre_descripcion == "30000026"){
                        $nombre_descripcion = "MEDICINA FÍSICA Y REHABILITACIÓN ADULTO (FISIATRÍA ADULTO)";
      							}
                    if ($nombre_descripcion == "30000027"){
                        $nombre_descripcion = "NEUROLOGÍA PEDIÁTRICA";
      							}
                    if ($nombre_descripcion == "30000028"){
                        $nombre_descripcion = "NEUROLOGÍA ADULTO";
      							}
                    if ($nombre_descripcion == "30000029"){
                        $nombre_descripcion = "ONCOLOGÍA MÉDICA";
      							}
                    if ($nombre_descripcion == "30000030"){
                        $nombre_descripcion = "PSIQUIATRÍA PEDIÁTRICA Y DE LA ADOLESCENCIA";
      							}
                    if ($nombre_descripcion == "30000031"){
                        $nombre_descripcion = "PSIQUIATRÍA ADULTO";
      							}
                    if ($nombre_descripcion == "30000032"){
                        $nombre_descripcion = "CIRUGÍA PEDIÁTRICA";
      							}
                    if ($nombre_descripcion == "30000033"){
                        $nombre_descripcion = "CIRUGÍA GENERAL ADULTO";
      							}
                    if ($nombre_descripcion == "30000034"){
                        $nombre_descripcion = "CIRUGÍA DIGESTIVA (ALTA)";
      							}
                    if ($nombre_descripcion == "30000035"){
                        $nombre_descripcion = "CIRUGÍA DE CABEZA, CUELLO Y MAXILOFACIAL";
      							}
                    if ($nombre_descripcion == "30000036"){
                        $nombre_descripcion = "CIRUGÍA PLÁSTICA Y REPARADORA PEDIÁTRICA";
      							}
                    if ($nombre_descripcion == "30000037"){
                        $nombre_descripcion = "CIRUGÍA PLÁSTICA Y REPARADORA ADULTO";
      							}
                    if ($nombre_descripcion == "30000038"){
                        $nombre_descripcion = "COLOPROCTOLOGÍA (CIRUGIA DIGESTIVA BAJA)";
      							}
                    if ($nombre_descripcion == "30000039"){
                        $nombre_descripcion = "CIRUGÍA TÓRAX";
      							}
                    if ($nombre_descripcion == "30000040"){
                        $nombre_descripcion = "CIRUGÍA VASCULAR PERIFÉRICA";
      							}
                    if ($nombre_descripcion == "30000041"){
                        $nombre_descripcion = "NEUROCIRUGÍA";
      							}
                    if ($nombre_descripcion == "30000042"){
                        $nombre_descripcion = "CIRUGÍA CARDIOVASCULAR";
      							}
                    if ($nombre_descripcion == "30000043"){
                        $nombre_descripcion = "ANESTESIOLOGÍA";
      							}
                    if ($nombre_descripcion == "30000044"){
                        $nombre_descripcion = "OBSTETRICIA";
      							}
                    if ($nombre_descripcion == "30000045"){
                        $nombre_descripcion = "GINECOLOGÍA PEDIÁTRICA Y DE LA ADOLESCENCIA";
      							}
                    if ($nombre_descripcion == "30000046"){
                        $nombre_descripcion = "GINECOLOGÍA ADULTO";
      							}
                    if ($nombre_descripcion == "30000047"){
                        $nombre_descripcion = "OFTALMOLOGÍA";
      							}
                    if ($nombre_descripcion == "30000048"){
                        $nombre_descripcion = "OTORRINOLARINGOLOGÍA";
      							}
                    if ($nombre_descripcion == "30000049"){
                        $nombre_descripcion = "TRAUMATOLOGÍA Y ORTOPEDIA PEDIÁTRICA";
      							}
                    if ($nombre_descripcion == "30000050"){
                        $nombre_descripcion = "TRAUMATOLOGÍA Y ORTOPEDIA ADULTO";
      							}
                    if ($nombre_descripcion == "30000051"){
                        $nombre_descripcion = "UROLOGÍA PEDIÁTRICA";
      							}
                    if ($nombre_descripcion == "30000052"){
                        $nombre_descripcion = "UROLOGÍA ADULTO";
      							}
                    if ($nombre_descripcion == "30000053"){
                        $nombre_descripcion = "MEDICINA FAMILIAR DEL NIÑO";
      							}
                    if ($nombre_descripcion == "30000054"){
                        $nombre_descripcion = "MEDICINA FAMILIAR";
      							}
                    if ($nombre_descripcion == "30000086"){
                        $nombre_descripcion = "MEDICINA FAMILIAR ADULTO";
      							}
                    if ($nombre_descripcion == "30000055"){
                        $nombre_descripcion = "DIABETOLOGÍA";
      							}
                    if ($nombre_descripcion == "30000056"){
                        $nombre_descripcion = "MEDICINA INTENSIVA";
      							}
                    if ($nombre_descripcion == "30000087"){
                        $nombre_descripcion = "IMAGENOLOGÍA";
      							}
                    if ($nombre_descripcion == "30000088"){
                        $nombre_descripcion = "RADIOTERAPIA ONCOLÓGICA";
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
                    <td colspan="12" class="active"><strong>SECCIÓN B: TELECONSULTA MÉDICA EN ESTABLECIMIENTOS DE ATENCIÓN SECUNDARIA DE URGENCIA.</strong></td>
                </tr>
                <tr>
              			<td rowspan="3" style="text-align:center; vertical-align:middle"><strong>TIPO DE CONSULTA URGENCIA</strong></td>
              			<td colspan="4" style="text-align:center; vertical-align:middle"><strong>TELECONSULTA MEDICA DE URGENCIA DE UEH DE HOSPITALES DE ALTA Y MEDIANA COMPLEJIDAD</strong></td>
              			<td colspan="3" style="text-align:center; vertical-align:middle"><strong>MODALIDAD</strong></td>
              			<td colspan="4" style="text-align:center; vertical-align:middle"><strong>CONSULTAS POR TELEMEDICINA SOLICITADAS DESDE APS O NIVEL SECUNDARIO RESUELTAS POR OTRO ESTABLECIMIENTO</strong></td>
            		</tr>
            		<tr>
              			<td colspan="2" align="center"><strong>MENORES DE 15 AÑOS</strong></td>
              			<td colspan="2" align="center"><strong>15 AÑOS Y MÁS</strong></td>
              			<td align="center"><strong>Institucional</strong></td>
              			<td colspan="2" align="center"><strong>Compra de Servicio</strong></td>
              			<td colspan="2" align="center"><strong>MENORES DE 15 AÑOS</strong></td>
              			<td colspan="2" align="center"><strong>15 AÑOS Y MÁS</strong></td>
            		</tr>
            		<tr>
              			<td align="center"><strong>Hombres</strong></td>
              			<td align="center"><strong>Mujeres</strong></td>
              			<td align="center"><strong>Hombres</strong></td>
              			<td align="center"><strong>Mujeres</strong></td>
              			<td align="center"><strong>Establecimiento de la Red</strong></td>
              			<td align="center"><strong>Sistema</strong></td>
              			<td align="center"><strong>Extrasistema</strong></td>
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
                          FROM (select c.* from 2020prestaciones c where c.codigo_prestacion in("30000089","30000090","30000091")) a
                          left join 2020rems b on (a.id_prestacion=b.prestacion_id_prestacion)
                          AND (b.Mes in ('.$mes.')) AND (b.establecimiento_id_establecimiento in ('.$estab.'))
                          group by a.codigo_prestacion, a.descripcion, a.id_prestacion
                          order by a.id_prestacion';
                $registro = DB::connection('mysql_rem')->select($query);

                $i=0;

                foreach($registro as $row ){
                    $nombre_descripcion = $row->codigo_prestacion;
                    if ($nombre_descripcion == "30000089"){
                        $nombre_descripcion = "CONSULTA URGENCIA OTROS";
      							}
                    if ($nombre_descripcion == "30000090"){
                        $nombre_descripcion = "ACCIDENTE CEREBRO VASCULAR (ACV)";
      							}
                    if ($nombre_descripcion == "30000091"){
                        $nombre_descripcion = "QUEMADOS";
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

    <!-- SECCION C -->
    <div class="col-sm tab table-responsive" id="C">
        <table class="table table-hover table-bordered table-sm">
            <thead>
                <tr>
                    <td colspan="15" class="active"><strong>SECCIÓN C: TELEINFORMES EN ESTABLECIMIENTOS DE ATENCIÓN PRIMARIA, SECUNDARIA Y TERCIARIA.</strong></td>
                </tr>
                <tr>
                    <td rowspan="4" style="text-align:center; vertical-align:middle"><strong>INFORMES REALIZADOS POR TELEMEDICINA</strong></td>
                    <td colspan="7" style="text-align:center; vertical-align:middle"><strong>ESTABLECIMIENTOS DE NIVEL PRIMARIO DE SALUD</strong></td>
                    <td colspan="7" style="text-align:center; vertical-align:middle"><strong>ESTABLECIMIENTOS DE NIVEL SECUNDARIO Y TERCIARIO</strong></td>
                </tr>
                <tr>
                    <td colspan="2" align="center"><strong>MENORES DE 15 AÑOS</strong></td>
                    <td colspan="2" align="center"><strong>15 AÑOS Y MÁS</strong></td>
                    <td colspan="3" align="center"><strong>MODALIDAD</strong></td>
                    <td colspan="2" align="center"><strong>MENORES DE 15 AÑOS</strong></td>
                    <td colspan="2" align="center"><strong>15 AÑOS Y MÁS</strong></td>
                    <td colspan="3" align="center"><strong>MODALIDAD</strong></td>
                </tr>
                <tr>
                    <td rowspan="2" style="text-align:center; vertical-align:middle"><strong>HOMBRES</strong></td>
                    <td rowspan="2" style="text-align:center; vertical-align:middle"><strong>MUJERES</strong></td>
                    <td rowspan="2" style="text-align:center; vertical-align:middle"><strong>HOMBRES</strong></td>
                    <td rowspan="2" style="text-align:center; vertical-align:middle"><strong>MUJERES</strong></td>
                    <td rowspan="2" style="text-align:center; vertical-align:middle"><strong>Institucional</strong></td>
                    <td colspan="2" style="text-align:center; vertical-align:middle"><strong>Compra de Servicio</strong></td>
                    <td rowspan="2" style="text-align:center; vertical-align:middle"><strong>HOMBRES</strong></td>
                    <td rowspan="2" style="text-align:center; vertical-align:middle"><strong>MUJERES</strong></td>
                    <td rowspan="2" style="text-align:center; vertical-align:middle"><strong>HOMBRES</strong></td>
                    <td rowspan="2" style="text-align:center; vertical-align:middle"><strong>MUJERES</strong></td>
                    <td rowspan="2" style="text-align:center; vertical-align:middle"><strong>Institucional</strong></td>
                    <td colspan="2" style="text-align:center; vertical-align:middle"><strong>Compra de Servicio</strong></td>
                </tr>
                <tr>
                  <td align="center"><strong>Sistema</strong></td>
                  <td align="center"><strong>Extrasistema</strong></td>
                  <td align="center"><strong>Sistema</strong></td>
                  <td align="center"><strong>Extrasistema</strong></td>
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
                          FROM (select c.* from 2020prestaciones c where c.codigo_prestacion in("30000058","30000059","30000060","30000061","30000062","30000063","30000064","30000065","30000066",
                                                                                                "30000067","30000068","30000069","30000070")) a
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
                }
                ?>
                <tr>
                    <td align='left'><strong>TOTAL</strong></td>
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
                </td>
                <?php
                foreach($registro as $row ){
                    $nombre_descripcion = $row->codigo_prestacion;
                    if ($nombre_descripcion == "30000058"){
                        $nombre_descripcion = "N° DE INFORMES ECOGRAFÍAS OBSTETRICA";
      							}
                    if ($nombre_descripcion == "30000059"){
                        $nombre_descripcion = "N° DE INFORMES ELECTROCARDIOGRAMA";
      							}
                    if ($nombre_descripcion == "30000060"){
                        $nombre_descripcion = "N° DE INFORMES ELECTROENCEFALOGRAMA";
      							}
                    if ($nombre_descripcion == "30000061"){
                        $nombre_descripcion = "N° DE INFORMES ESPIROMETRÍAS";
      							}
                    if ($nombre_descripcion == "30000062"){
                        $nombre_descripcion = "N° DE INFORMES FONDO DE OJO";
      							}
                    if ($nombre_descripcion == "30000063"){
                        $nombre_descripcion = "N° DE INFORMES HOLTER DE PRESIÓN ARTERIAL";
      							}
                    if ($nombre_descripcion == "30000064"){
                        $nombre_descripcion = "N° DE INFORMES TEST DE ESFUERZO";
      							}
                    if ($nombre_descripcion == "30000065"){
                        $nombre_descripcion = "N° DE INFORMES RADIOGRAFÍAS SIMPLES";
      							}
                    if ($nombre_descripcion == "30000066"){
                        $nombre_descripcion = "N° DE INFORMES RADIOGRAFÍAS DENTALES";
      							}
                    if ($nombre_descripcion == "30000067"){
                        $nombre_descripcion = "N° DE INFORMES DE TOMOGRAFÍA AXIAL COMPUTALIZADA";
      							}
                    if ($nombre_descripcion == "30000068"){
                        $nombre_descripcion = "N° DE INFORMES DE RESONANCIA MAGNÉTICA NUCLEAR";
      							}
                    if ($nombre_descripcion == "30000069"){
                        $nombre_descripcion = "N° DE INFORMES ECOGRAFIAS ABDOMINAL";
      							}
                    if ($nombre_descripcion == "30000070"){
                        $nombre_descripcion = "N° DE MAMOGRAFIAS";
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
                    <td colspan="20" class="active"><strong>SECCION D: TELECONSULTA AMBULATORIA EN ESPECIALIDAD ODONTOLOGICA.</strong></td>
                </tr>
                <tr>
                    <td rowspan="3" style="text-align:center; vertical-align:middle"><strong>ESPECIALIDADES ODONTOLOGICAS</strong></td>
                    <td colspan="4" style="text-align:center; vertical-align:middle"><strong>TELECONSULTA MEDICA DE ESPECIALIDAD AMBULATORIA NUEVA</strong></td>
                    <td colspan="4" style="text-align:center; vertical-align:middle"><strong>TELECONSULTA MEDICA  DE ESPECIALIDAD AMBULATORIA  CONTROL</strong></td>
                    <td colspan="4" style="text-align:center; vertical-align:middle"><strong>TOTAL TELECONSULTAS  MEDICAS AMBULATORIAS DE ESPECIALIDAD REALIZADAS POR TELEMEDICINA</strong></td>
                    <td colspan="3" style="text-align:center; vertical-align:middle"><strong>MODALIDAD</strong></td>
                    <td colspan="4" style="text-align:center; vertical-align:middle"><strong>CONSULTAS POR TELEMEDICINA SOLICITADAS DESDE APS O NIVEL SECUNDARIO RESUELTAS POR OTRO</strong></td>
                </tr>
                <tr>
                    <td colspan="2" align="center"><strong>MENORES DE 15 AÑOS</strong></td>
                    <td colspan="2" align="center"><strong>15 AÑOS Y MÁS</strong></td>
                    <td colspan="2" align="center"><strong>MENORES DE 15 AÑOS</strong></td>
                    <td colspan="2" align="center"><strong>15 AÑOS Y MÁS</strong></td>
                    <td colspan="2" align="center"><strong>MENORES DE 15 AÑOS</strong></td>
                    <td colspan="2" align="center"><strong>15 AÑOS Y MÁS</strong></td>
                    <td align="center"><strong>Institucional</strong></td>
                    <td colspan="2" align="center"><strong>Compra de Servicio</strong></td>
                    <td colspan="2" align="center"><strong>MENORES DE 15 AÑOS</strong></td>
                    <td colspan="2" align="center"><strong>15 AÑOS Y MÁS</strong></td>
                </tr>
                <tr>
                    <td style="text-align:center; vertical-align:middle"><strong>HOMBRES</strong></td>
                    <td style="text-align:center; vertical-align:middle"><strong>MUJERES</strong></td>
                    <td style="text-align:center; vertical-align:middle"><strong>HOMBRES</strong></td>
                    <td style="text-align:center; vertical-align:middle"><strong>MUJERES</strong></td>
                    <td style="text-align:center; vertical-align:middle"><strong>HOMBRES</strong></td>
                    <td style="text-align:center; vertical-align:middle"><strong>MUJERES</strong></td>
                    <td style="text-align:center; vertical-align:middle"><strong>HOMBRES</strong></td>
                    <td style="text-align:center; vertical-align:middle"><strong>MUJERES</strong></td>
                    <td style="text-align:center; vertical-align:middle"><strong>HOMBRES</strong></td>
                    <td style="text-align:center; vertical-align:middle"><strong>MUJERES</strong></td>
                    <td style="text-align:center; vertical-align:middle"><strong>HOMBRES</strong></td>
                    <td style="text-align:center; vertical-align:middle"><strong>MUJERES</strong></td>
                    <td align="center"><strong>Establecimiento de la Red</strong></td>
                    <td align="center"><strong>Sistema</strong></td>
                    <td align="center"><strong>Extrasistema</strong></td>
                    <td style="text-align:center; vertical-align:middle"><strong>HOMBRES</strong></td>
                    <td style="text-align:center; vertical-align:middle"><strong>MUJERES</strong></td>
                    <td style="text-align:center; vertical-align:middle"><strong>HOMBRES</strong></td>
                    <td style="text-align:center; vertical-align:middle"><strong>MUJERES</strong></td>
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
                          FROM (select c.* from 2020prestaciones c where c.codigo_prestacion in("30000071","30000072","30000073","30000074","30000075","30000076","30000077","30000078",
                                                                                                "30000079","30000080","30000081")) a
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
                }
                ?>
                <tr>
                    <td align='left'><strong>TOTAL</strong></td>
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
                </td>
                <?php
                foreach($registro as $row ){
                    $nombre_descripcion = $row->codigo_prestacion;
                    if ($nombre_descripcion == "30000071"){
                        $nombre_descripcion = "CIRUGÍA BUCAL";
      							}
                    if ($nombre_descripcion == "30000072"){
                        $nombre_descripcion = "CIRUGÍA Y TRAUMATOLOGÍA MAXILOFACIAL";
      							}
                    if ($nombre_descripcion == "30000073"){
                        $nombre_descripcion = "ENDODONCIA";
      							}
                    if ($nombre_descripcion == "30000074"){
                        $nombre_descripcion = "ODONTOPEDIATRÍA";
      							}
                    if ($nombre_descripcion == "30000075"){
                        $nombre_descripcion = "ORTODONCIA Y ORTOPEDIA DENTO MAXILOFACIAL";
      							}
                    if ($nombre_descripcion == "30000076"){
                        $nombre_descripcion = "PERIODONCIA";
      							}
                    if ($nombre_descripcion == "30000077"){
                        $nombre_descripcion = "REHABILITACIÓN: PRÓTESIS FIJA";
      							}
                    if ($nombre_descripcion == "30000078"){
                        $nombre_descripcion = "REHABILITACIÓN: PRÓTESIS REMOVIBLE";
      							}
                    if ($nombre_descripcion == "30000079"){
                        $nombre_descripcion = "IMPLANTOLOGÍA BUCO MAXILOFACIAL";
      							}
                    if ($nombre_descripcion == "30000080"){
                        $nombre_descripcion = "PATOLOGÍA ORAL";
      							}
                    if ($nombre_descripcion == "30000081"){
                        $nombre_descripcion = "TRASTORNOS TEMPOROMANDIBULARES Y DOLOR OROFACIAL";
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
                    <td colspan="12" class="active"><strong>SECCION E: TELEPROCEDIMIENTOS EN ATENCION SECUNDARIA Y TERCIARIA.</strong></td>
                </tr>
                <tr>
                    <td rowspan="4" style="text-align:center; vertical-align:middle"><strong>TELEPROCEDIMIENTOS</strong></td>
                    <td colspan="7" style="text-align:center; vertical-align:middle"><strong>ESTABLECIMIENTOS DE NIVEL SECUNDARIO Y TERCIARIO</strong></td>
                    <td colspan="4" rowspan="2" style="text-align:center; vertical-align:middle"><strong>PROCEDIMIENTOS POR TELEMEDICINA SOLICITADOS DESDE  NIVEL SECUNDARIO Y TERCIARIO Y RESUELTOS POR OTRO ESTABLECIMIENTO</strong></td>
                </tr>
                <tr>
                    <td colspan="2" align="center"><strong>MENORES DE 15 AÑOS</strong></td>
                    <td colspan="2" align="center"><strong>15 AÑOS Y MÁS</strong></td>
                    <td colspan="3" align="center"><strong>MODALIDAD</strong></td>
                </tr>
                <tr>
                    <td rowspan="2" style="text-align:center; vertical-align:middle"><strong>HOMBRES</strong></td>
                    <td rowspan="2" style="text-align:center; vertical-align:middle"><strong>MUJERES</strong></td>
                    <td rowspan="2" style="text-align:center; vertical-align:middle"><strong>HOMBRES</strong></td>
                    <td rowspan="2" style="text-align:center; vertical-align:middle"><strong>MUJERES</strong></td>
                    <td align="center"><strong>Institucional</strong></td>
                    <td colspan="2" align="center"><strong>Compra de Servicio</strong></td>
                    <td colspan="2" align="center"><strong>MENORES DE 15 AÑOS</strong></td>
                    <td colspan="2" align="center"><strong>15 AÑOS Y MÁS</strong></td>
                </tr>
                <tr>
                    <td style="text-align:center; vertical-align:middle"><strong>Establecimiento de la Red</strong></td>
                    <td style="text-align:center; vertical-align:middle"><strong>Sistema</strong></td>
                    <td style="text-align:center; vertical-align:middle"><strong>Extrasistema</strong></td>
                    <td style="text-align:center; vertical-align:middle"><strong>HOMBRES</strong></td>
                    <td style="text-align:center; vertical-align:middle"><strong>MUJERES</strong></td>
                    <td style="text-align:center; vertical-align:middle"><strong>HOMBRES</strong></td>
                    <td style="text-align:center; vertical-align:middle"><strong>MUJERES</strong></td>
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
                          FROM (select c.* from 2020prestaciones c where c.codigo_prestacion in("30000082","30000083","30000084","30000085")) a
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
                }
                ?>
                <tr>
                    <td align='left'><strong>TOTAL</strong></td>
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
                </td>
                <?php
                foreach($registro as $row ){
                    $nombre_descripcion = $row->codigo_prestacion;
                    if ($nombre_descripcion == "30000082"){
                        $nombre_descripcion = "ECOCARDIOGRAMA";
      							}
                    if ($nombre_descripcion == "30000083"){
                        $nombre_descripcion = "TROMBOLISIS DE URGENCIA INFARTO CEREBRAL (ACV)";
      							}
                    if ($nombre_descripcion == "30000084"){
                        $nombre_descripcion = "TROMBOLISIS INTRACORONARIA (IAM)";
      							}
                    if ($nombre_descripcion == "30000085"){
                        $nombre_descripcion = "ECOGRAFÍA GINECO-OBSTÉTRICA";
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
    <!-- SECCION F -->
    <div class="col-sm tab table-responsive" id="E">
        <table class="table table-hover table-bordered table-sm">
            <thead>
                <tr>
                    <td colspan="12" class="active"><strong>SECCIÓN F: TELECONSULTA ABREVIADA.</strong></td>
                </tr>
                <tr>
              			<td rowspan="3" style="text-align:center; vertical-align:middle"><strong>TIPO DE CONSULTA URGENCIA</strong></td>
              			<td colspan="3" align="center"><strong>MODALIDAD</strong></td>
            		</tr>
            		<tr>
              			<td align="center"><strong>Institucional</strong></td>
              			<td colspan="2" align="center"><strong>Compra de Servicio</strong></td>
            		</tr>
            		<tr>
              			<td align="center"><strong>Establecimiento de la Red</strong></td>
              			<td align="center"><strong>Sistema</strong></td>
              			<td align="center"><strong>Extrasistema</strong></td>
            		</tr>
            </thead>
            <tbody>
                <?php
                $query = 'SELECT a.codigo_prestacion,a.descripcion
                              ,sum(ifnull(b.Col01,0)) Col01
                              ,sum(ifnull(b.Col02,0)) Col02
                              ,sum(ifnull(b.Col03,0)) Col03
                          FROM (select c.* from 2020prestaciones c where c.codigo_prestacion in("30000092","30000093")) a
                          left join 2020rems b on (a.id_prestacion=b.prestacion_id_prestacion)
                          AND (b.Mes in ('.$mes.')) AND (b.establecimiento_id_establecimiento in ('.$estab.'))
                          group by a.codigo_prestacion, a.descripcion, a.id_prestacion
                          order by a.id_prestacion';
                $registro = DB::connection('mysql_rem')->select($query);

                $i=0;

                foreach($registro as $row ){
                    $nombre_descripcion = $row->codigo_prestacion;
                    if ($nombre_descripcion == "30000092"){
                        $nombre_descripcion = "TRATAMIENTO ANTICOAGULANTE ORAL";
      							}
                    if ($nombre_descripcion == "30000093"){
                        $nombre_descripcion = "OTROS";
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

    </div>
<?php
}
?>

@endsection

@section('custom_js')
    <script src="{{ asset('js/show_hide_tab.js') }}" defer></script>
    <script src="{{ asset('js/bootstrap-multiselect.js') }}" defer></script>
@endsection
