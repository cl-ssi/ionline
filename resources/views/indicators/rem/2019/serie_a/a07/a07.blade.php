@extends('layouts.app')

@section('title', 'Resumen Estadistico Mensual')

@section('content')

<?php

use Illuminate\Support\Facades\DB;

?>

@include('indicators.rem.partials.nav')

<h3>REM-07. ATENCIÓN DE ESPECIALIDADES.</h3>

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
                    <td colspan="49" class="active"><strong>SECCIÓN A: CONSULTAS MÉDICAS.</strong></td>
                </tr>
                <tr>
                    <td rowspan="3" style="text-align:center; vertical-align:middle"><strong>ESPECIALIDADES Y SUB-ESPECIALIDADES</strong></td>
                    <td colspan="22" align="center"><strong>CONSULTAS MÉDICAS</strong></td>
                    <td colspan="8" align="center"><strong>CONSULTAS NUEVAS SEGÚN ORIGEN(*)</strong></td>
                    <td colspan="2" rowspan="2" align="center"><strong>CONSULTAS PERTINENTES (Nuevas originadas en APS)</strong></td>
                    <td colspan="2" rowspan="2" align="center"><strong>INASISTENTE A CONSULTA MÉDICA (NSP)</strong></td>
                    <td rowspan="3" align="center"><strong>CONSULTA ABREVIADA (Confección de recetas o lectura de exámenes)</strong></td>
                    <td colspan="2" rowspan="2" align="center"><strong>INTERCONSULTAS A HOSPITALIZADOS (EN SALA)</strong></td>
                    <td colspan="2" rowspan="2" align="center"><strong>ALTA DE CONSULTA DE ESPECIALIDAD AMBULATORIA</strong></td>
                    <td colspan="2" rowspan="2" align="center"><strong>CONSULTAS REALIZADAS EN APS E INFORMADAS EN SECCIÓN A</strong></td>
                    <td rowspan="3" align="center"><strong>COMPRA DE SERVICIO</strong></td>
                    <td rowspan="3" align="center"><strong>CONSULTAS MÉDICAS POR OPERATIVOS (no incluidas en produccion)</strong></td>
                    <td colspan="2" rowspan="2" align="center"><strong>TOTAL INTERCONSULTAS GENERADAS EN APS PARA DERIVACION ESPECIALIDAD</strong></td>
                    <td colspan="3" rowspan="2" align="center"><strong>CONSULTORÍAS DE MEDICOS ESPECIALISTAS OTORGADAS</strong></td>
                </tr>
                <tr>
                    <td rowspan="2" style="text-align:center; vertical-align:middle"><strong>TOTAL</strong></td>
                    <td colspan="17" align="center"><strong>GRUPOS DE EDAD (en años)</strong></td>
                    <td colspan="2" align="center"><strong>A BENEFICIARIOS</strong></td>
                    <td colspan="2" align="center"><strong>POR SEXO</strong></td>
                    <td colspan="4" align="center"><strong>Menos 15 años</strong></td>
                    <td colspan="4" align="center"><strong>De 15 y más años</strong></td>
                </tr>
                <tr>
                    <td align="center"><strong>0&nbsp;-&nbsp;4</strong></td>
                    <td align="center"><strong>5&nbsp;-&nbsp;9</strong></td>
                    <td align="center"><strong>10&nbsp;-&nbsp;14</strong></td>
                    <td align="center"><strong>15&nbsp;-&nbsp;19</strong></td>
                    <td align="center"><strong>20&nbsp;-&nbsp;24</strong></td>
                    <td align="center"><strong>25&nbsp;-&nbsp;29</strong></td>
                    <td align="center"><strong>30&nbsp;-&nbsp;34</strong></td>
                    <td align="center"><strong>35&nbsp;-&nbsp;39</strong></td>
                    <td align="center"><strong>40&nbsp;-&nbsp;44</strong></td>
                    <td align="center"><strong>45&nbsp;-&nbsp;49</strong></td>
                    <td align="center"><strong>50&nbsp;-&nbsp;54</strong></td>
                    <td align="center"><strong>55&nbsp;-&nbsp;59</strong></td>
                    <td align="center"><strong>60&nbsp;-&nbsp;64</strong></td>
                    <td align="center"><strong>65&nbsp;-&nbsp;69</strong></td>
                    <td align="center"><strong>70&nbsp;-&nbsp;74</strong></td>
                    <td align="center"><strong>75&nbsp;-&nbsp;79</strong></td>
                    <td align="center"><strong>80&nbsp;y&nbsp;mas</strong></td>
                    <td align="center"><strong>Menos&nbsp;15 años</strong></td>
                    <td align="center"><strong>15&nbsp;y&nbsp;más años</strong></td>
                    <td align="center"><strong>Hombres</strong></td>
                    <td align="center"><strong>Mujeres</strong></td>
                    <td align="center"><strong>TOTAL</strong></td>
                    <td align="center"><strong>APS</strong></td>
                    <td align="center"><strong>CAE/CDT/CRS</strong></td>
                    <td align="center"><strong>URGENCIA</strong></td>
                    <td align="center"><strong>TOTAL</strong></td>
                    <td align="center"><strong>APS</strong></td>
                    <td align="center"><strong>CAE/CDT/CRS</strong></td>
                    <td align="center"><strong>URGENCIA</strong></td>
                    <td align="center"><strong>Según&nbsp;protocolo&nbsp;de referencia</strong></td>
                    <td align="center"><strong>Según&nbsp;tiempo establecido</strong></td>
                    <td align="center"><strong>Menos 15&nbsp;años</strong></td>
                    <td align="center"><strong>15&nbsp;y&nbsp;más años</strong></td>
                    <td align="center"><strong>Menos 15&nbsp;años</strong></td>
                    <td align="center"><strong>15&nbsp;y&nbsp;más años</strong></td>
                    <td align="center"><strong>Menos 15&nbsp;años</strong></td>
                    <td align="center"><strong>15&nbsp;y&nbsp;más años</strong></td>
                    <td align="center"><strong>CONTRATADOS&nbsp;POR&nbsp;EL&nbsp;ESTABLECIMIENTO O DIRECCIÓN DEL SERVICIO</strong></td>
                    <td align="center"><strong>ESPECIALISTAS&nbsp;DE HOSPITALES</strong></td>
                    <td align="center"><strong>Menos&nbsp;15 años</strong></td>
                    <td align="center"><strong>15&nbsp;y&nbsp;más años</strong></td>
                    <td align="center"><strong>Nº&nbsp;Consultorías</strong></td>
                    <td align="center"><strong>Nº&nbsp;de&nbsp;casos&nbsp;revisados por el equipo</strong></td>
                    <td align="center"><strong>Nº&nbsp;de&nbsp;casos atendidos</strong></td>
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
                              ,sum(ifnull(b.Col38,0)) Col38
            									,sum(ifnull(b.Col39,0)) Col39
            									,sum(ifnull(b.Col40,0)) Col40
            									,sum(ifnull(b.Col41,0)) Col41
            									,sum(ifnull(b.Col42,0)) Col42
            									,sum(ifnull(b.Col43,0)) Col43
            									,sum(ifnull(b.Col44,0)) Col44
            									,sum(ifnull(b.Col45,0)) Col45
            									,sum(ifnull(b.Col46,0)) Col46
            									,sum(ifnull(b.Col47,0)) Col47
            									,sum(ifnull(b.Col48,0)) Col48
                          FROM (select c.* from 2019prestaciones c where c.codigo_prestacion in("07020130","07020230","07020330","07020331","07020332","07024219",
                                                                                                "07020500","07020501","07020600","07020601","07020700","07020800",
                                                                                                "07020801","07020900","07020901","07021000","07021001","07021100",
                                                                                                "07021101","07021230","07021300","07021301","07022000","07022001",
                                                                                                "07021531","07022132","07022133","07022134","07021700","07021800",
                                                                                                "07021801","07021900","07022130","07022142","07022143","07022144",
                                                                                                "07022135","07022136","07022137","07022700","07022800","07022900",
                                                                                                "07021701","07023100","07023200","07023201","07023202","07023203",
                                                                                                "07023700","07023701","07023702","07023703","07024000","07024001",
                                                                                                "07024200","07030500","07024201","07024202","07030501","07030502")) a
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
    						$totalCol25=0;
    						$totalCol26=0;
    						$totalCol27=0;
    						$totalCol28=0;
    						$totalCol29=0;
    						$totalCol30=0;
    						$totalCol31=0;
    						$totalCol32=0;
    						$totalCol33=0;
    						$totalCol34=0;
    						$totalCol35=0;
    						$totalCol36=0;
    						$totalCol37=0;
    						$totalCol38=0;
    						$totalCol39=0;
    						$totalCol40=0;
    						$totalCol41=0;
    						$totalCol42=0;
    						$totalCol43=0;
    						$totalCol44=0;
    						$totalCol45=0;
    						$totalCol46=0;
    						$totalCol47=0;
    						$totalCol48=0;

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
                    $totalCol26=$totalCol26+$row->Col26;
                    $totalCol27=$totalCol27+$row->Col27;
                    $totalCol28=$totalCol28+$row->Col28;
                    $totalCol29=$totalCol29+$row->Col29;
                    $totalCol30=$totalCol30+$row->Col30;
                    $totalCol31=$totalCol31+$row->Col31;
                    $totalCol32=$totalCol32+$row->Col32;
                    $totalCol33=$totalCol33+$row->Col33;
                    $totalCol34=$totalCol34+$row->Col34;
                    $totalCol35=$totalCol35+$row->Col35;
                    $totalCol36=$totalCol36+$row->Col36;
                    $totalCol37=$totalCol37+$row->Col37;
                    $totalCol38=$totalCol38+$row->Col38;
                    $totalCol39=$totalCol39+$row->Col39;
                    $totalCol40=$totalCol40+$row->Col40;
                    $totalCol41=$totalCol41+$row->Col41;
                    $totalCol42=$totalCol42+$row->Col42;
                    $totalCol43=$totalCol43+$row->Col43;
                    $totalCol44=$totalCol44+$row->Col44;
                    $totalCol45=$totalCol45+$row->Col45;
                    $totalCol46=$totalCol46+$row->Col46;
                    $totalCol47=$totalCol47+$row->Col47;
                    $totalCol48=$totalCol48+$row->Col48;

                    $nombre_descripcion = $row->codigo_prestacion;
                    if ($nombre_descripcion == "07020130"){
                        $nombre_descripcion = "PEDIATRÍA";
      							}
      							if ($nombre_descripcion == "07020230"){
                        $nombre_descripcion = "MEDICINA INTERNA";
      							}
      							if ($nombre_descripcion == "07020330"){
                        $nombre_descripcion = "NEONATOLOGÍA";
      							}
      							if ($nombre_descripcion == "07020331"){
                        $nombre_descripcion = "ENFERMEDAD RESPIRATORIO PEDIÁTRICA (BRONCOPULMONAR INFANTIL)";
      							}
      							if ($nombre_descripcion == "07020332"){
                        $nombre_descripcion = "ENFERMEDAD RESPIRATORIO DE ADULTO (BRONCOPULMONAR)";
      							}
      							if ($nombre_descripcion == "07024219"){
                        $nombre_descripcion = "CARDIOLOGÍA PEDIÁTRICA";
      							}
      							if ($nombre_descripcion == "07020500"){
                        $nombre_descripcion = "CARDIOLOGÍA";
      							}
      							if ($nombre_descripcion == "07020501"){
                        $nombre_descripcion = "ENDOCRINOLOGÍA PEDIÁTRICA";
      							}
      							if ($nombre_descripcion == "07020600"){
                        $nombre_descripcion = "ENDOCRINOLOGÍA ADULTO";
      							}
      							if ($nombre_descripcion == "07020601"){
                        $nombre_descripcion = "GASTROENTEROLOGÍA PEDÍATRICA";
      							}
      							if ($nombre_descripcion == "07020700"){
                        $nombre_descripcion = "GASTROENTEROLOGÍA ADULTO";
      							}
      							if ($nombre_descripcion == "07020800"){
                        $nombre_descripcion = "GENETICA CLÍNICA";
      							}
      							if ($nombre_descripcion == "07020801"){
                        $nombre_descripcion = "HEMATO-ONCOLOGÍA INFANTIL";
      							}
      							if ($nombre_descripcion == "07020900"){
                        $nombre_descripcion = "HEMATOLOGÍA";
      							}
      							if ($nombre_descripcion == "07020901"){
                        $nombre_descripcion = "NEFROLOGÍA PEDÍATRICA";
      							}
      							if ($nombre_descripcion == "07021000"){
                        $nombre_descripcion = "NEFROLOGÍA ADULTO";
      							}
      							if ($nombre_descripcion == "07021001"){
                        $nombre_descripcion = "NUTRIÓLOGO PEDÍATRICO";
      							}
      							if ($nombre_descripcion == "07021100"){
                        $nombre_descripcion = "NUTRIÓLOGO";
      							}
      							if ($nombre_descripcion == "07021101"){
                        $nombre_descripcion = "REUMATOLOGÍA PEDÍATRICA";
      							}
      							if ($nombre_descripcion == "07021230"){
                        $nombre_descripcion = "REUMATOLOGÍA ADULTO";
      							}
      							if ($nombre_descripcion == "07021300"){
                        $nombre_descripcion = "DERMATOLOGÍA";
      							}
      							if ($nombre_descripcion == "07021301"){
                        $nombre_descripcion = "INFECTOLOGÍA PEDÍATRICA";
      							}
      							if ($nombre_descripcion == "07022000"){
                        $nombre_descripcion = "INFECTOLOGÍA ADULTO";
      							}
      							if ($nombre_descripcion == "07022001"){
                        $nombre_descripcion = "INMUNOLOGÍA";
      							}
      							if ($nombre_descripcion == "07021531"){
                        $nombre_descripcion = "GERIATRÍA";
      							}
      							if ($nombre_descripcion == "07022132"){
                        $nombre_descripcion = "MEDICINA FÍSICA Y REHABILITACIÓN PEDIÁTRICA (FISIATRÍA PEDIÁTRICA)";
      							}
      							if ($nombre_descripcion == "07022133"){
                        $nombre_descripcion = "MEDICINA FÍSICA Y REHABILITACIÓN ADULTO (FISIATRÍA ADULTO)";
      							}
      							if ($nombre_descripcion == "07022134"){
                        $nombre_descripcion = "NEUROLOGÍA PEDIÁTRICA";
      							}
                    if ($nombre_descripcion == "07021700"){
                        $nombre_descripcion = "NEUROLOGÍA ADULTO";
      							}
      							if ($nombre_descripcion == "07021800"){
                        $nombre_descripcion = "ONCOLOGÍA MÉDICA";
      							}
      							if ($nombre_descripcion == "07021801"){
                        $nombre_descripcion = "PSIQUIATRÍA PEDIÁTRICA Y DE LA ADOLESCENCIA";
      							}
      							if ($nombre_descripcion == "07021900"){
                        $nombre_descripcion = "PSIQUIATRÍA ADULTO";
      							}
      							if ($nombre_descripcion == "07022130"){
                        $nombre_descripcion = "CIRUGÍA PEDIÁTRICA";
      							}
      							if ($nombre_descripcion == "07022142"){
                        $nombre_descripcion = "CIRUGÍA GENERAL ADULTO";
      							}
      							if ($nombre_descripcion == "07022143"){
                        $nombre_descripcion = "CIRUGÍA DIGESTIVA";
      							}
      							if ($nombre_descripcion == "07022144"){
                        $nombre_descripcion = "CIRUGÍA DE CABEZA, CUELLO Y MAXILOFACIAL";
      							}
      							if ($nombre_descripcion == "07022135"){
                        $nombre_descripcion = "CIRUGÍA PLÁSTICA Y REPARADORA PEDIÁTRICA";
      							}
      							if ($nombre_descripcion == "07022136"){
                        $nombre_descripcion = "CIRUGÍA PLÁSTICA Y REPARADORA ADULTO";
      							}
      							if ($nombre_descripcion == "07022137"){
                        $nombre_descripcion = "COLOPROCTOLOGÍA (CIRUGIA DIGESTIVA BAJA)";
      							}
      							if ($nombre_descripcion == "07022700"){
                        $nombre_descripcion = "CIRUGÍA TÓRAX";
      							}
      							if ($nombre_descripcion == "07022800"){
                        $nombre_descripcion = "CIRUGÍA VASCULAR PERIFÉRICA";
      							}
                    if ($nombre_descripcion == "07022900"){
                        $nombre_descripcion = "NEUROCIRUGÍA";
      							}
      							if ($nombre_descripcion == "07021701"){
                        $nombre_descripcion = "CIRUGÍA CARDIOVASCULAR";
      							}
      							if ($nombre_descripcion == "07023100"){
                        $nombre_descripcion = "ANESTESIOLOGÍA";
      							}
      							if ($nombre_descripcion == "07023200"){
                        $nombre_descripcion = "OBSTETRICIA";
      							}
      							if ($nombre_descripcion == "07023201"){
                        $nombre_descripcion = "GINECOLOGÍA PEDIÁTRICA Y DE LA ADOLESCENCIA";
      							}
      							if ($nombre_descripcion == "07023202"){
                        $nombre_descripcion = "GINECOLOGÍA ADULTO";
      							}
      							if ($nombre_descripcion == "07023203"){
                        $nombre_descripcion = "OFTALMOLOGÍA";
      							}
      							if ($nombre_descripcion == "07023700"){
                        $nombre_descripcion = "OTORRINOLARINGOLOGÍA";
      							}
      							if ($nombre_descripcion == "07023701"){
                        $nombre_descripcion = "TRAUMATOLOGÍA Y ORTOPEDIA PEDIÁTRICA";
      							}
      							if ($nombre_descripcion == "07023702"){
                        $nombre_descripcion = "TRAUMATOLOGÍA Y ORTOPEDIA ADULTO";
      							}
      							if ($nombre_descripcion == "07023703"){
                        $nombre_descripcion = "UROLOGÍA PEDIÁTRICA";
      							}
      							if ($nombre_descripcion == "07024000"){
                        $nombre_descripcion = "UROLOGÍA ADULTO";
      							}
      							if ($nombre_descripcion == "07024001"){
                        $nombre_descripcion = "MEDICINA FAMILIAR DEL NIÑO";
      							}
      							if ($nombre_descripcion == "07024200"){
                        $nombre_descripcion = "MEDICINA FAMILIAR";
      							}
                    if ($nombre_descripcion == "07030500"){
                        $nombre_descripcion = "MEDICINA FAMILIAR ADULTO";
      							}
      							if ($nombre_descripcion == "07024201"){
      								$nombre_descripcion = "DIABETOLOGÍA";
      							}
      							if ($nombre_descripcion == "07024202"){
      								$nombre_descripcion = "MEDICINA NUCLEAR (EXCLUYE INFORMES)";
      							}
                    if ($nombre_descripcion == "07030501"){
      								$nombre_descripcion = "IMAGENOLOGÍA";
      							}
      							if ($nombre_descripcion == "07030502"){
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
                    <td align='right'><?php echo number_format($row->Col38,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col39,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col40,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col41,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col42,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col43,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col44,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col45,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col46,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col47,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col48,0,",",".")?></td>
                    <?php
                    $i++;
                }
                ?>
                </tr>
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
                    <td align='right'><strong><?php echo number_format($totalCol27,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol28,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol29,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol30,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol31,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol32,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol33,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol34,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol35,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol36,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol37,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol38,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol39,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol40,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol41,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol42,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol43,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol44,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol45,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol46,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol47,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol48,0,",",".") ?></strong></td>
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
                    <td colspan="19" class="active"><strong>SECCIÓN B: ATENCIONES MEDICAS POR PROGRAMAS Y POLICLINICOS ESPECIALISTAS ACREDITADOS.</strong></td>
                </tr>
                <tr>
                    <td align="center"><strong>ATENCIONES</strong></td>
                    <td align="center"><strong>TOTAL</strong></td>
                    <td align="center"><strong>0 - 4 años</strong></td>
                    <td align="center"><strong>5 - 9 años</strong></td>
                    <td align="center"><strong>10 - 14 años</strong></td>
                    <td align="center"><strong>15 - 19 años</strong></td>
                    <td align="center"><strong>20 - 24 años</strong></td>
                    <td align="center"><strong>25 - 29 años</strong></td>
                    <td align="center"><strong>30 - 34 años</strong></td>
                    <td align="center"><strong>35 - 39 años</strong></td>
                    <td align="center"><strong>40 - 44 años</strong></td>
                    <td align="center"><strong>45 - 49 años</strong></td>
                    <td align="center"><strong>50 - 54 años</strong></td>
                    <td align="center"><strong>55 - 59 años</strong></td>
                    <td align="center"><strong>60 - 64 años</strong></td>
                    <td align="center"><strong>65 - 69 años</strong></td>
                    <td align="center"><strong>70 - 74 años</strong></td>
                    <td align="center"><strong>75 - 79 años</strong></td>
                    <td align="center"><strong>80 años y mas</strong></td>
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
                          FROM (select c.* from 2019prestaciones c where c.codigo_prestacion in("07024203","07024204","07024205","07024206","07024207","07024208",
                                                                                                "07024209","07024211","07024212","07024213","07024214","07024215",
                                                                                                "07024216","07024217","07024218")) a
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

                    $nombre_descripcion = $row->codigo_prestacion;
                    if ($nombre_descripcion == "07024203"){
                        $nombre_descripcion = "ARRITMIAS";
      							}
      							if ($nombre_descripcion == "07024204"){
                        $nombre_descripcion = "DIABETES";
      							}
      							if ($nombre_descripcion == "07024205"){
                        $nombre_descripcion = "CIRUGÍA DE MAMAS";
      							}
      							if ($nombre_descripcion == "07024206"){
                        $nombre_descripcion = "ALTO RIESGO OBSTÉTRICO";
      							}
      							if ($nombre_descripcion == "07024207"){
                        $nombre_descripcion = "TRATAMIENTO ANTICOAGULANTE";
      							}
      							if ($nombre_descripcion == "07024208"){
                        $nombre_descripcion = "CUIDADOS PALIATIVOS";
      							}
      							if ($nombre_descripcion == "07024209"){
                        $nombre_descripcion = "INFERTILIDAD";
      							}
      							if ($nombre_descripcion == "07024210"){
                        $nombre_descripcion = "ATENCIONES UAPO";
      							}
      							if ($nombre_descripcion == "07024211"){
                        $nombre_descripcion = "PATOLOGÍA CERVICAL";
      							}
      							if ($nombre_descripcion == "07024212"){
                        $nombre_descripcion = "PATOLOGÍA DE MAMAS";
      							}
      							if ($nombre_descripcion == "07024213"){
                        $nombre_descripcion = "ATENCIONES ADOLESCENCIA";
      							}
      							if ($nombre_descripcion == "07024214"){
                        $nombre_descripcion = "NINEAS";
      							}
      							if ($nombre_descripcion == "07024215"){
                        $nombre_descripcion = "NANEAS";
      							}
      							if ($nombre_descripcion == "07024216"){
                        $nombre_descripcion = "ITS";
      							}
      							if ($nombre_descripcion == "07024217"){
                        $nombre_descripcion = "VIH/SIDA";
      							}
      							if ($nombre_descripcion == "07024218"){
                        $nombre_descripcion = "MEDICINAL OCUPACIONAL (SALUD DEL PERSONAL)";
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
                    <?php
                    $i++;
                }
                ?>
                </tr>
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
                    <td colspan="43" class="active"><strong>SECCIÓN C: CONSULTAS Y CONTROLES POR OTROS PROFESIONALES EN ESPECIALIDAD (NIVEL SECUNDARIO).</strong></td>
                </tr>
                <tr>
                    <td colspan="2" rowspan="3" style="text-align:center; vertical-align:middle"><strong>PROFESIONAL</strong></td>
                    <td colspan="3" rowspan="2" style="text-align:center; vertical-align:middle"><strong>TOTAL</strong></td>
                    <td colspan="34" align="center"><strong>POR EDAD (en años)</strong></td>
                    <td rowspan="3" align="center"><strong>Beneficiarios</strong></td>
                    <td rowspan="3" align="center"><strong>Total Controles (incluidos en grupo de edad)</strong></td>
                    <td rowspan="3" align="center"><strong>Pueblos Originarios</strong></td>
                    <td rowspan="3" align="center"><strong>Migrantes</strong></td>
                </tr>
                <tr>
                    <td colspan="2" align="center"><strong>0 - 4</strong></td>
                    <td colspan="2" align="center"><strong>5 - 9</strong></td>
                    <td colspan="2" align="center"><strong>10 - 14</strong></td>
                    <td colspan="2" align="center"><strong>15 - 19</strong></td>
                    <td colspan="2" align="center"><strong>20 - 24</strong></td>
                    <td colspan="2" align="center"><strong>25 - 29</strong></td>
                    <td colspan="2" align="center"><strong>30 - 34</strong></td>
                    <td colspan="2" align="center"><strong>35 - 39</strong></td>
                    <td colspan="2" align="center"><strong>40 - 44</strong></td>
                    <td colspan="2" align="center"><strong>45 - 49</strong></td>
                    <td colspan="2" align="center"><strong>50 - 54</strong></td>
                    <td colspan="2" align="center"><strong>55 - 59</strong></td>
                    <td colspan="2" align="center"><strong>60 - 64</strong></td>
                    <td colspan="2" align="center"><strong>65 - 69</strong></td>
                    <td colspan="2" align="center"><strong>70 - 74</strong></td>
                    <td colspan="2" align="center"><strong>75 - 79</strong></td>
                    <td colspan="2" align="center"><strong>80 y mas</strong></td>
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
                              ,sum(ifnull(b.Col38,0)) Col38
            									,sum(ifnull(b.Col39,0)) Col39
            									,sum(ifnull(b.Col40,0)) Col40
            									,sum(ifnull(b.Col41,0)) Col41
                          FROM (select c.* from 2019prestaciones c where c.codigo_prestacion in("07024900","07024915","07024925","07024935","07024920","07024816",
                                                                                                "07024607","07024817","07024809","07024705","07024506")) a
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
    						$totalCol25=0;
    						$totalCol26=0;
    						$totalCol27=0;
    						$totalCol28=0;
    						$totalCol29=0;
    						$totalCol30=0;
    						$totalCol31=0;
    						$totalCol32=0;
    						$totalCol33=0;
    						$totalCol34=0;
    						$totalCol35=0;
    						$totalCol36=0;
    						$totalCol37=0;
    						$totalCol38=0;
    						$totalCol39=0;
    						$totalCol40=0;
    						$totalCol41=0;

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
                    $totalCol26=$totalCol26+$row->Col26;
                    $totalCol27=$totalCol27+$row->Col27;
                    $totalCol28=$totalCol28+$row->Col28;
                    $totalCol29=$totalCol29+$row->Col29;
                    $totalCol30=$totalCol30+$row->Col30;
                    $totalCol31=$totalCol31+$row->Col31;
                    $totalCol32=$totalCol32+$row->Col32;
                    $totalCol33=$totalCol33+$row->Col33;
                    $totalCol34=$totalCol34+$row->Col34;
                    $totalCol35=$totalCol35+$row->Col35;
                    $totalCol36=$totalCol36+$row->Col36;
                    $totalCol37=$totalCol37+$row->Col37;
                    $totalCol38=$totalCol38+$row->Col38;
                    $totalCol39=$totalCol39+$row->Col39;
                    $totalCol40=$totalCol40+$row->Col40;
                    $totalCol41=$totalCol41+$row->Col41;

                    $nombre_descripcion = $row->codigo_prestacion;
                    if ($nombre_descripcion == "07024900"){
                        $nombre_descripcion = "ENFERMERA";
      							}
      							if ($nombre_descripcion == "07024915"){
                        $nombre_descripcion = "ARO";
      							}
      							if ($nombre_descripcion == "07024925"){
                        $nombre_descripcion = "GINECOLOGÍA";
      							}
      							if ($nombre_descripcion == "07024935"){
                        $nombre_descripcion = "INFERTILIDAD";
      							}
      							if ($nombre_descripcion == "07024920"){
                        $nombre_descripcion = "NUTRICIONISTA";
      							}
      							if ($nombre_descripcion == "07024816"){
                        $nombre_descripcion = "PSICÓLOGO (EXCLUYE SM)";
      							}
      							if ($nombre_descripcion == "07024607"){
                        $nombre_descripcion = "FONOAUDIÓLOGO";
      							}
      							if ($nombre_descripcion == "07024817"){
                        $nombre_descripcion = "KINESIÓLOGO";
      							}
      							if ($nombre_descripcion == "07024809"){
                        $nombre_descripcion = "TERAPEUTA OCUPACIONAL";
      							}
      							if ($nombre_descripcion == "07024705"){
                        $nombre_descripcion = "TECNÓLOGO MÉDICO";
      							}
      							if ($nombre_descripcion == "07024506"){
                        $nombre_descripcion = "ASISTENTE SOCIAL";
      							}
                    ?>
                <tr>
                    <?php
								    if($i==0){?>
                    <td align='left' colspan='2'><?php echo $nombre_descripcion; ?></td>
                    <?php
                    }
                    if($i==1){?>
                    <td align='left' rowspan="3">MATRONA</td>
                    <?php
                    }
                    if($i>=1 && $i<=3){?>
                    <td align='left'><?php echo $nombre_descripcion; ?></td>
                    <?php
                    }
                    if($i>=4){?>
                    <td align='left' colspan="2"><?php echo $nombre_descripcion; ?></td>
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
                    <td align='right'><?php echo number_format($row->Col38,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col39,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col40,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col41,0,",",".")?></td>
                    <?php
                    $i++;
                }
                ?>
                </tr>
                <tr>
                    <td align='left' colspan="2"><strong>TOTAL</strong></td>
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
                    <td align='right'><strong><?php echo number_format($totalCol27,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol28,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol29,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol30,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol31,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol32,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol33,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol34,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol35,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol36,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol37,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol38,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol39,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol40,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol41,0,",",".") ?></strong></td>
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
                    <td colspan="45" class="active"><strong>SECCIÓN D: CONSULTAS INFECCIÓN TRANSMISIÓN SEXUAL (ITS) Y CONTROLES DE SALUD SEXUAL EN EL NIVEL.</strong></td>
                </tr>
                <tr>
                    <td rowspan="3" style="text-align:center; vertical-align:middle"><strong>ACTIVIDAD</strong></td>
                    <td rowspan="3" style="text-align:center; vertical-align:middle"><strong>PROFESIONAL</strong></td>
                    <td colspan="3" rowspan="2" align="center"><strong>TOTAL</strong></td>
                    <td colspan="34" align="center"><strong>POR EDAD (en años)</strong></td>
                    <td rowspan="3" align="center"><strong>Beneficiarios</strong></td>
                    <td colspan="2" rowspan="2" align="center"><strong>Trans</strong></td>
                    <td rowspan="3" align="center"><strong>Pueblos Originarios</strong></td>
                    <td rowspan="3" align="center"><strong>Migrantes</strong></td>
                    <td rowspan="3" align="center"><strong>Niños, Niñas, Adolescentes y Jóvenes Población SENAME</strong></td>
                </tr>
                <tr>
                    <td colspan="2" align="center"><strong>0 - 4</strong></td>
                    <td colspan="2" align="center"><strong>5 - 9</strong></td>
                    <td colspan="2" align="center"><strong>10 - 14</strong></td>
                    <td colspan="2" align="center"><strong>15 - 19</strong></td>
                    <td colspan="2" align="center"><strong>20 - 24</strong></td>
                    <td colspan="2" align="center"><strong>25 - 29</strong></td>
                    <td colspan="2" align="center"><strong>30 - 34</strong></td>
                    <td colspan="2" align="center"><strong>35 - 39</strong></td>
                    <td colspan="2" align="center"><strong>40 - 44</strong></td>
                    <td colspan="2" align="center"><strong>45 - 49</strong></td>
                    <td colspan="2" align="center"><strong>50 - 54</strong></td>
                    <td colspan="2" align="center"><strong>55 - 59</strong></td>
                    <td colspan="2" align="center"><strong>60 - 64</strong></td>
                    <td colspan="2" align="center"><strong>65 - 69</strong></td>
                    <td colspan="2" align="center"><strong>70 - 74</strong></td>
                    <td colspan="2" align="center"><strong>75 - 79</strong></td>
                    <td colspan="2" align="center"><strong>80 y mas</strong></td>
                </tr>
                <tr>
                    <td align="center"><strong>Ambos Sexos</strong></td>
                    <td align="center"><strong>Hombre</strong></td>
                    <td align="center"><strong>Mujer</strong></td>
                    <td align="center"><strong>Hombre</strong></td>
                    <td align="center"><strong>Mujer</strong></td>
                    <td align="center"><strong>Hombre</strong></td>
                    <td align="center"><strong>Mujer</strong></td>
                    <td align="center"><strong>Hombre</strong></td>
                    <td align="center"><strong>Mujer</strong></td>
                    <td align="center"><strong>Hombre</strong></td>
                    <td align="center"><strong>Mujer</strong></td>
                    <td align="center"><strong>Hombre</strong></td>
                    <td align="center"><strong>Mujer</strong></td>
                    <td align="center"><strong>Hombre</strong></td>
                    <td align="center"><strong>Mujer</strong></td>
                    <td align="center"><strong>Hombre</strong></td>
                    <td align="center"><strong>Mujer</strong></td>
                    <td align="center"><strong>Hombre</strong></td>
                    <td align="center"><strong>Mujer</strong></td>
                    <td align="center"><strong>Hombre</strong></td>
                    <td align="center"><strong>Mujer</strong></td>
                    <td align="center"><strong>Hombre</strong></td>
                    <td align="center"><strong>Mujer</strong></td>
                    <td align="center"><strong>Hombre</strong></td>
                    <td align="center"><strong>Mujer</strong></td>
                    <td align="center"><strong>Hombre</strong></td>
                    <td align="center"><strong>Mujer</strong></td>
                    <td align="center"><strong>Hombre</strong></td>
                    <td align="center"><strong>Mujer</strong></td>
                    <td align="center"><strong>Hombre</strong></td>
                    <td align="center"><strong>Mujer</strong></td>
                    <td align="center"><strong>Hombre</strong></td>
                    <td align="center"><strong>Mujer</strong></td>
                    <td align="center"><strong>Hombre</strong></td>
                    <td align="center"><strong>Mujer</strong></td>
                    <td align="center"><strong>Hombre</strong></td>
                    <td align="center"><strong>Mujer</strong></td>
                    <td align="center"><strong>Hombre</strong></td>
                    <td align="center"><strong>Mujer</strong></td>
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
                              ,sum(ifnull(b.Col38,0)) Col38
            									,sum(ifnull(b.Col39,0)) Col39
            									,sum(ifnull(b.Col40,0)) Col40
            									,sum(ifnull(b.Col41,0)) Col41
                              ,sum(ifnull(b.Col42,0)) Col42
                              ,sum(ifnull(b.Col43,0)) Col43
                          FROM (select c.* from 2019prestaciones c where c.codigo_prestacion in("07024930","07024940","070251200","070251300","070251400","07030100A",
                                                                                                "07030200","07030300","07030400","07024950","07024960")) a
                          left join 2019rems b on (a.id_prestacion=b.prestacion_id_prestacion)
                          AND (b.Mes in ('.$mes.')) AND (b.establecimiento_id_establecimiento in ('.$estab.'))
                          group by a.codigo_prestacion, a.descripcion, a.id_prestacion
                          order by a.id_prestacion';
                $registro = DB::connection('mysql_rem')->select($query);

                $i=0;

                foreach($registro as $row ){

                    $nombre_descripcion = $row->codigo_prestacion;
                    if ($nombre_descripcion == "07024930"){
                        $nombre_descripcion = "ENFERMERA";
      							}
      							if ($nombre_descripcion == "07024940"){
                        $nombre_descripcion = "MATRONA";
      							}

      							if ($nombre_descripcion == "070251200"){
                        $nombre_descripcion = "ENFERMERA";
      							}
      							if ($nombre_descripcion == "070251300"){
                        $nombre_descripcion = "MATRONA";
      							}
      							if ($nombre_descripcion == "070251400"){
                        $nombre_descripcion = "PSICOLOGO (A)";
      							}

      							if ($nombre_descripcion == "07030100A"){
                        $nombre_descripcion = "ENFERMERA";
      							}
      							if ($nombre_descripcion == "07030200"){
                        $nombre_descripcion = "MATRONA";
      							}

      							if ($nombre_descripcion == "07030300"){
                        $nombre_descripcion = "ENFERMERA";
      							}
      							if ($nombre_descripcion == "07030400"){
                        $nombre_descripcion = "MATRONA";
      							}

      							if ($nombre_descripcion == "07024950"){
                        $nombre_descripcion = "ENFERMERA";
      							}
      							if ($nombre_descripcion == "07024960"){
                        $nombre_descripcion = "MATRONA";
      							}
                    ?>
                <tr>
                    <?php
                    if($i==0){?>
                    <td align='left' rowspan="2" style="text-align:center; vertical-align:middle">CONSULTAS INFECCIÓN TRANSMISIÓN SEXUAL(ITS) (excluir VIH/SIDA)</td>
								    <?php
                    }
                    if($i>=0 && $i<=1){?>
                    <td align='left'><?php echo $nombre_descripcion; ?></td>
                    <?php }
                    if($i==2){?>
                    <td align='left' rowspan="3" style="text-align:center; vertical-align:middle">CONSULTAS VIH/SIDA</td>
                    <?php }
                    if($i>=2 && $i<=4){?>
                    <td align='left'><?php echo $nombre_descripcion; ?></td>
                    <?php }
                    if($i==5){?>
                    <td align='left' rowspan="2" style="text-align:center; vertical-align:middle" nowrap="nowrap">CONTROL VIH CON TAR</td>
                    <?php }
                    if($i>=5 && $i<=6){?>
                    <td align='left'><?php echo $nombre_descripcion; ?></td>
                    <?php }
                    if($i==7){?>
                    <td align='left' rowspan="2" style="text-align:center; vertical-align:middle">CONTROL VIH SIN TAR</td>
                    <?php }
                    if($i>=7 && $i<=8){?>
                    <td align='left'><?php echo $nombre_descripcion; ?></td>
                    <?php }
                    if($i==9){?>
                    <td align='left' rowspan="2" style="text-align:center; vertical-align:middle">CONTROLES DE SALUD A PERSONAS QUE EJERCEN COMERCIO SEXUAL</td>
                    <?php }
                    if($i>=9 && $i<=10){?>
                    <td align='left'><?php echo $nombre_descripcion; ?></td>
                    <?php }
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
                    <td align='right'><?php echo number_format($row->Col38,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col39,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col40,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col41,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col42,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col43,0,",",".")?></td>
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
