@extends('layouts.app')

@section('title', 'Resumen Estadistico Mensual')

@section('content')

<?php

use Illuminate\Support\Facades\DB;

?>

@include('indicators.rem.partials.navBM')

<h3>REM-18A - LIBRO DE PRESTACIONES DE APOYO DIAGNOSTICO y TERAPÉUTICO</h3>
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
                  <td colspan="6" class="active"><strong>SECCIÓN A: EXÁMENES DE DIAGNOSTICO.</strong></td>
              </tr>
              <tr>
                  <td align="center"><strong>CÓDIGOS</strong></td>
                  <td align="center"><strong>EXÁMENES</strong></td>
                  <td align="center"><strong>TOTAL</strong></td>
                  <td align="center"><strong>SAPU/SAR/SUR</strong></td>
                  <td align="center"><strong>NO SAPU/ NO SUR</strong></td>
                  <td align="center"><strong>COMPRAS DE SERVICIOS</strong></td>
              </tr>
            </thead>
            <tbody>
                <tr>
                    <td></td>
                    <td align="center"><strong>1.- SANGRE HEMATOLOGÍA</strong></td>
                    <td colspan="4"></td>
                </tr>
                <?php
                $query = 'SELECT a.codigo_prestacion,a.descripcion
                              ,sum(ifnull(b.Col01,0)) Col01
                              ,sum(ifnull(b.Col02,0)) Col02
                              ,sum(ifnull(b.Col03,0)) Col03
                              ,sum(ifnull(b.Col04,0)) Col04
                          FROM (select c.* from 2020prestaciones c where c.codigo_prestacion in("80301001","80301002","80301003","80301004","80301005","80301006","80301007","80301008",
                                                                                                "80301009","80301010","80301011","80301012","80301013","80301014","80301015","80301016",
                                                                                                "80301017","80301020","80301021","80301022","80301023","80301024","80301025","80301026",
                                                                                                "80301027","80301028","80301029","80301030","80301032","80301033","80301034","80301035",
                                                                                                "80301036","80301038","80301039","80301040","80301041","80301042","80301043","80301044",
                                                                                                "80301045","80301046","80301047","80301048","80301049","80301050","80301051","80301052",
                                                                                                "80301053","80301054","80301055","80301056","80301057","80301058","80301059","80301062",
                                                                                                "80301063","80301064","80301065","80301066","80301067","80301068","80301069","80301070",
                                                                                                "80301071","80301072","80301074","80301075","80301076","80301077","80301078","80301079",
                                                                                                "80301080","80301081","80301082","80301083","80301085","80301086","80301087","80301088",
                                                                                                "80301089","80301090","80301091","80301092","80301093")) a
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

                foreach($registro as $row ){
                    $totalCol01a=$totalCol01a+$row->Col01;
                    $totalCol02a=$totalCol02a+$row->Col02;
                    $totalCol03a=$totalCol03a+$row->Col03;
                    $totalCol04a=$totalCol04a+$row->Col04;

                    $nombre_descripcion = $row->codigo_prestacion;
                    if ($nombre_descripcion == "80301001"){
                        $nombre_descripcion = "Acidificación del suero, test de Ham";
                    }
                    if ($nombre_descripcion == "80301002"){
                        $nombre_descripcion = "Acido fólico o folatos";
                    }
                    if ($nombre_descripcion == "80301003"){
                        $nombre_descripcion = "Adenograma, esplenograma, mielograma c/u ";
                    }
                    if ($nombre_descripcion == "80301004"){
                        $nombre_descripcion = "Adhesividad plaquetaria";
                    }
                    if ($nombre_descripcion == "80301005"){
                        $nombre_descripcion = "Aglutininas anti Rho";
                    }
                    if ($nombre_descripcion == "80301006"){
                        $nombre_descripcion = "Agregación plaquetaria";
                    }
                    if ($nombre_descripcion == "80301007"){
                        $nombre_descripcion = "Anticoagulantes circulantes o anticoagulante lúpico ";
                    }
                    if ($nombre_descripcion == "80301008"){
                        $nombre_descripcion = "Antitrombina III";
                    }
                    if ($nombre_descripcion == "80301009"){
                        $nombre_descripcion = "Auto-hemólisis test,  con y sin glucosa";
                    }
                    if ($nombre_descripcion == "80301010"){
                        $nombre_descripcion = "Células del lupus, cada muestra";
                    }
                    if ($nombre_descripcion == "80301011"){
                        $nombre_descripcion = "Coagulación, tiempo de ";
                    }
                    if ($nombre_descripcion == "80301012"){
                        $nombre_descripcion = "Coágulo,  tiempo de retracción del ";
                    }
                    if ($nombre_descripcion == "80301013"){
                        $nombre_descripcion = "Coágulo, tiempo de lisis del";
                    }
                    if ($nombre_descripcion == "80301014"){
                        $nombre_descripcion = "Coombs directo, test de";
                    }
                    if ($nombre_descripcion == "80301015"){
                        $nombre_descripcion = "Coombs indirecto, prueba de ";
                    }
                    if ($nombre_descripcion == "80301016"){
                        $nombre_descripcion = "Cuerpos de Heinz ";
                    }
                    if ($nombre_descripcion == "80301017"){
                        $nombre_descripcion = "Deshidrogenasa glucosa-6-fosfato en eritrocitos";
                    }
                    if ($nombre_descripcion == "80301020"){
                        $nombre_descripcion = "Euglobulinas, tiempo de lisis de";
                    }
                    if ($nombre_descripcion == "80301021"){
                        $nombre_descripcion = "Fibrinógeno";
                    }
                    if ($nombre_descripcion == "80301022"){
                        $nombre_descripcion = "Test de neutralización plaquetaria ";
                    }
                    if ($nombre_descripcion == "80301023"){
                        $nombre_descripcion = "Factor III plaquetario ";
                    }
                    if ($nombre_descripcion == "80301024"){
                        $nombre_descripcion = "Factor V";
                    }
                    if ($nombre_descripcion == "80301025"){
                        $nombre_descripcion = "Factores VII, VIII, IX, X, XI, XII, XIII, c/u";
                    }
                    if ($nombre_descripcion == "80301026"){
                        $nombre_descripcion = "Ferritina";
                    }
                    if ($nombre_descripcion == "80301027"){
                        $nombre_descripcion = "Fibrinógeno, productos de degradación del ";
                    }
                    if ($nombre_descripcion == "80301028"){
                        $nombre_descripcion = "Fierro sérico";
                    }
                    if ($nombre_descripcion == "80301029"){
                        $nombre_descripcion = "Fierro, capacidad de fijación del (incluye fierro sérico) ";
                    }
                    if ($nombre_descripcion == "80301030"){
                        $nombre_descripcion = "Fierro, cinética del (cada determinación)";
                    }

                    if ($nombre_descripcion == "80301032"){
                        $nombre_descripcion = "Gelación por etanol";
                    }
                    if ($nombre_descripcion == "80301033"){
                        $nombre_descripcion = "Grupos menores. Tipificación o determinación de otros sistemas sanguíneos (Kell, Duffy, Kidd y otros) c/u. ";
                    }

                    if ($nombre_descripcion == "80301034"){
                        $nombre_descripcion = "Grupos sanguíneos AB0 y Rho (incluye estudio de factor Du en Rh negativos) ";
                    }
                    if ($nombre_descripcion == "80301035"){
                        $nombre_descripcion = "Haptoglobina cuantitativa";
                    }
                    if ($nombre_descripcion == "80301036"){
                        $nombre_descripcion = "Hematocrito (proc. aut.)";
                    }
                    if ($nombre_descripcion == "80301038"){
                        $nombre_descripcion = "Hemoglobina en sangre total (proc. aut.)";
                    }
                    if ($nombre_descripcion == "80301039"){
                        $nombre_descripcion = "Hemoglobina fetal cualitativa";
                    }
                    if ($nombre_descripcion == "80301040"){
                        $nombre_descripcion = "Hemoglobina fetal cuantitativa en eritrocitos";
                    }
                    if ($nombre_descripcion == "80301041"){
                        $nombre_descripcion = "Hemoglobina glicosilada ";
                    }
                    if ($nombre_descripcion == "80301042"){
                        $nombre_descripcion = "Hemoglobina plasmática";
                    }
                    if ($nombre_descripcion == "80301043"){
                        $nombre_descripcion = "Hemoglobina termolabil ";
                    }
                    if ($nombre_descripcion == "80301044"){
                        $nombre_descripcion = "Hemoglobina, electroforesis de (incluye Hb. total)";
                    }
                    if ($nombre_descripcion == "80301045"){
                        $nombre_descripcion = "Hemograma (incluye recuentos de leucocitos y eritrocitos, hemoglobina, hematocrito, fórmula leucocitaria, características de los elementos figurados y velocidad de eritrosedimentación)";
                    }
                    if ($nombre_descripcion == "80301046"){
                        $nombre_descripcion = "Hemolisinas";
                    }
                    if ($nombre_descripcion == "80301047"){
                        $nombre_descripcion = "Hemólisis con sucrosa, test de";
                    }
                    if ($nombre_descripcion == "80301048"){
                        $nombre_descripcion = "Hemosiderina medular";
                    }
                    if ($nombre_descripcion == "80301049"){
                        $nombre_descripcion = "Heparina, cuantificación de";
                    }
                    if ($nombre_descripcion == "80301050"){
                        $nombre_descripcion = "Isoinmunización, detección de anticuerpos irregulares (proc. aut.).";
                    }
                    if ($nombre_descripcion == "80301051"){
                        $nombre_descripcion = "Isoinmunización, detección e identificación de anticuerpos";
                    }
                    if ($nombre_descripcion == "80301052"){
                        $nombre_descripcion = "Isopropanol, test de";
                    }
                    if ($nombre_descripcion == "80301053"){
                        $nombre_descripcion = "Metahemalbúmina";
                    }
                    if ($nombre_descripcion == "80301054"){
                        $nombre_descripcion = "Metahemoglobina";
                    }
                    if ($nombre_descripcion == "80301055"){
                        $nombre_descripcion = "Muraminidasa en eritrocitos";
                    }
                    if ($nombre_descripcion == "80301056"){
                        $nombre_descripcion = "Piruvatoquinasa en eritrocitos";
                    }
                    if ($nombre_descripcion == "80301057"){
                        $nombre_descripcion = "Protamina sulfato, determinación de";
                    }
                    if ($nombre_descripcion == "80301058"){
                        $nombre_descripcion = "Protoporfirinas en eritrocitos";
                    }
                    if ($nombre_descripcion == "80301059"){
                        $nombre_descripcion = "Protrombina, tiempo de o consumo de (incluye INR, Relación Internacional Normalizada) ";
                    }
                    if ($nombre_descripcion == "80301062"){
                        $nombre_descripcion = "Recuento de basófilos (absoluto) ";
                    }
                    if ($nombre_descripcion == "80301063"){
                        $nombre_descripcion = "Recuento de eosinófilos (absoluto)";
                    }
                    if ($nombre_descripcion == "80301064"){
                        $nombre_descripcion = "Recuento de eritrocitos, absoluto (proc. aut.)";
                    }
                    if ($nombre_descripcion == "80301065"){
                        $nombre_descripcion = "Recuento de leucocitos, absoluto (proc. aut.)";
                    }
                    if ($nombre_descripcion == "80301066"){
                        $nombre_descripcion = "Recuento de linfocitos (absoluto)";
                    }
                    if ($nombre_descripcion == "80301067"){
                        $nombre_descripcion = "Recuento de plaquetas (absoluto)";
                    }
                    if ($nombre_descripcion == "80301068"){
                        $nombre_descripcion = "Recuento de reticulocitos (absoluto o porcentual)";
                    }
                    if ($nombre_descripcion == "80301069"){
                        $nombre_descripcion = "Recuento diferencial o fórmula leucocitaria (proc. aut.) ";
                    }
                    if ($nombre_descripcion == "80301070"){
                        $nombre_descripcion = "Resistencia globular osmótica ";
                    }
                    if ($nombre_descripcion == "80301071"){
                        $nombre_descripcion = "Sacarosa, prueba de la";
                    }
                    if ($nombre_descripcion == "80301072"){
                        $nombre_descripcion = "Sangría, tiempo de (Ivy) (no incluye dispositivo asociado)";
                    }
                    if ($nombre_descripcion == "80301074"){
                        $nombre_descripcion = "Sobrevida del eritrocito (Cr 51 o similar)";
                    }
                    if ($nombre_descripcion == "80301075"){
                        $nombre_descripcion = "Subgrupo ABO y Rh fenotipo - genotipo Rh, c/u";
                    }
                    if ($nombre_descripcion == "80301076"){
                        $nombre_descripcion = "Thorn, prueba de (no incluye ACTH)";
                    }
                    if ($nombre_descripcion == "80301077"){
                        $nombre_descripcion = "Tinción de estearasa";
                    }
                    if ($nombre_descripcion == "80301078"){
                        $nombre_descripcion = "Tinción de fosfatasas alcalinas o ácidas";
                    }
                    if ($nombre_descripcion == "80301079"){
                        $nombre_descripcion = "Tinción de glicógeno o PAS";
                    }
                    if ($nombre_descripcion == "80301080"){
                        $nombre_descripcion = "Tinción de lípidos";
                    }

                    if ($nombre_descripcion == "80301081"){
                        $nombre_descripcion = "Tinción de peroxidasas";
                    }
                    if ($nombre_descripcion == "80301082"){
                        $nombre_descripcion = "Transferrina";
                    }
                    if ($nombre_descripcion == "80301083"){
                        $nombre_descripcion = "Trombina, tiempo de";
                    }
                    if ($nombre_descripcion == "80301085"){
                        $nombre_descripcion = "Tromboplastina, tiempo parcial de (TTPA, TTPK o similares)";
                    }
                    if ($nombre_descripcion == "80301086"){
                        $nombre_descripcion = "Velocidad de eritrosedimentación (proc. aut.)";
                    }
                    if ($nombre_descripcion == "80301087"){
                        $nombre_descripcion = "Vitamina B12, absorción de (Co 57 o similar)";
                    }
                    if ($nombre_descripcion == "80301088"){
                        $nombre_descripcion = "Volemia (incluye volumen globular total, volumen plasmático total y volumen sanguíneo total)";
                    }
                    if ($nombre_descripcion == "80301089"){
                        $nombre_descripcion = "Von Willebrand, Ag de (factor VIII Ag.) ";
                    }
                    if ($nombre_descripcion == "80301090"){
                        $nombre_descripcion = "Cofactor de Ristocetina";
                    }
                    if ($nombre_descripcion == "80301091"){
                        $nombre_descripcion = "Proteína C";
                    }
                    if ($nombre_descripcion == "80301092"){
                        $nombre_descripcion = "Proteína S";
                    }
                    if ($nombre_descripcion == "80301093"){
                        $nombre_descripcion = "Resistencia Proteína C";
                    }
                    ?>
                <tr>
                    <td align='left'><?php echo substr($row->codigo_prestacion, 1); ?></td>
                    <td align='left'><?php echo $nombre_descripcion; ?></td>
                    <td align='right'><?php echo number_format($row->Col01,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col02,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col03,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col04,0,",",".")?></td>
                    <?php
                    $i++;
                }
                ?>
                <tr>
                    <td></td>
                    <td align='center'><strong>TOTAL</strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol01a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol02a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol03a,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol04a,0,",",".") ?></strong></td>
                </tr>
                <tr>
                    <td></td>
                    <td align="center"><strong>2.- SANGRE BIOQUÍMICO</strong></td>
                    <td colspan="4"></td>
                </tr>
                <?php
                $query = 'SELECT a.codigo_prestacion,a.descripcion
                              ,sum(ifnull(b.Col01,0)) Col01
                              ,sum(ifnull(b.Col02,0)) Col02
                              ,sum(ifnull(b.Col03,0)) Col03
                              ,sum(ifnull(b.Col04,0)) Col04
                          FROM (select c.* from 2020prestaciones c where c.codigo_prestacion in("80302001","80302002","80302004","80302005","80302006","80302007","80302008","80302009",
                                                                                                "80302010","80302070","80302011","80302012","80302013","80302014","80302015","80302016",
                                                                                                "80302017","80302018","80302019","80302020","80302067","80302068","80302021","80302022",
                                                                                                "80302023","80302024","80302025","80302026","80302028","80302029","80302030","80302031",
                                                                                                "80302032","80302033","80302034","80302035","80302036","80302037","80302038","80302039",
                                                                                                "80302040","80302041","80302042","80302043","80302044","80302045","80302046","80302047",
                                                                                                "80302048","80302050","80302051","80302052","80302053","80302069","80302054","80302055",
                                                                                                "80302056","80302057","80302058","80302075","80302059","80302060","80302061","80302062",
                                                                                                "80302076","80302063","80302064","80302065","80302066")) a
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

                foreach($registro as $row ){
                    $totalCol01b=$totalCol01b+$row->Col01;
                    $totalCol02b=$totalCol02b+$row->Col02;
                    $totalCol03b=$totalCol03b+$row->Col03;
                    $totalCol04b=$totalCol04b+$row->Col04;

                    $nombre_descripcion = $row->codigo_prestacion;

                    if ($nombre_descripcion == "80302001"){
                        $nombre_descripcion = "Acetona cualitativa";
                    }
                    if ($nombre_descripcion == "80302002"){
                        $nombre_descripcion = "Acido cítrico";
                    }
                    if ($nombre_descripcion == "80302004"){
                        $nombre_descripcion = "Acido láctico";
                    }
                    if ($nombre_descripcion == "80302005"){
                        $nombre_descripcion = "Acido úrico, en sangre";
                    }
                    if ($nombre_descripcion == "80302006"){
                        $nombre_descripcion = "Alcohol etílico";
                    }
                    if ($nombre_descripcion == "80302007"){
                        $nombre_descripcion = "Aldolasa";
                    }
                    if ($nombre_descripcion == "80302008"){
                        $nombre_descripcion = "Amilasa, en sangre";
                    }
                    if ($nombre_descripcion == "80302009"){
                        $nombre_descripcion = "Aminoácidos, cualitativo en sangre";
                    }
                    if ($nombre_descripcion == "80302010"){
                        $nombre_descripcion = "Amonio";
                    }
                    if ($nombre_descripcion == "80302070"){
                        $nombre_descripcion = "Apolipoproteínas (A1, B u otras)";
                    }
                    if ($nombre_descripcion == "80302011"){
                        $nombre_descripcion = "Bicarbonato (proc. aut.)";
                    }
                    if ($nombre_descripcion == "80302012"){
                        $nombre_descripcion = "Bilirrubina total (proc. aut.)";
                    }
                    if ($nombre_descripcion == "80302013"){
                        $nombre_descripcion = "Bilirrubina total y conjugada";
                    }
                    if ($nombre_descripcion == "80302014"){
                        $nombre_descripcion = "Bromosulftaleína, prueba de (incluye medicamento y tomas de muestra)";
                    }
                    if ($nombre_descripcion == "80302015"){
                        $nombre_descripcion = "Calcio en sangre";
                    }
                    if ($nombre_descripcion == "80302016"){
                        $nombre_descripcion = "Calcio iónico, incluye proteínas totales";
                    }
                    if ($nombre_descripcion == "80302017"){
                        $nombre_descripcion = "Caroteno";
                    }
                    if ($nombre_descripcion == "80302018"){
                        $nombre_descripcion = "Caroteno, prueba de sobrecarga de (incluye tomas de muestra)";
                    }
                    if ($nombre_descripcion == "80302019"){
                        $nombre_descripcion = "Ceruloplasmina";
                    }
                    if ($nombre_descripcion == "80302020"){
                        $nombre_descripcion = "Cobre";
                    }
                    if ($nombre_descripcion == "80302067"){
                        $nombre_descripcion = "Colesterol total (proc. aut.)";
                    }
                    if ($nombre_descripcion == "80302068"){
                        $nombre_descripcion = "Colesterol HDL (proc. aut.)";
                    }
                    if ($nombre_descripcion == "80302021"){
                        $nombre_descripcion = "Colinesterasa en plasma o sangre total";
                    }
                    if ($nombre_descripcion == "80302022"){
                        $nombre_descripcion = "Creatina";
                    }
                    if ($nombre_descripcion == "80302023"){
                        $nombre_descripcion = "Creatinina en sangre";
                    }
                    if ($nombre_descripcion == "80302024"){
                        $nombre_descripcion = "Creatinina, depuración de (Clearence) (proc. aut.)";
                    }
                    if ($nombre_descripcion == "80302025"){
                        $nombre_descripcion = "Creatinquinasa CK - MB  miocárdica";
                    }
                    if ($nombre_descripcion == "80302026"){
                        $nombre_descripcion = "Creatinquinasa CK - total";
                    }
                    if ($nombre_descripcion == "80302028"){
                        $nombre_descripcion = "Depuraciones (Clearance) exógenas de Hipurán, Rojo Congo, manitol e inulina, c/u (no incluye medicamento)";
                    }
                    if ($nombre_descripcion == "80302029"){
                        $nombre_descripcion = "Deshidrogenasa hidroxibutírica (HBDH)";
                    }
                    if ($nombre_descripcion == "80302030"){
                        $nombre_descripcion = "Deshidrogenasa láctica total (LDH)";
                    }
                    if ($nombre_descripcion == "80302031"){
                        $nombre_descripcion = "Deshidrogenasa láctica total (LDH), con separación de isoenzimas";
                    }
                    if ($nombre_descripcion == "80302032"){
                        $nombre_descripcion = "Electrolitos plasmáticos (sodio, potasio, cloro) c/u";
                    }
                    if ($nombre_descripcion == "80302033"){
                        $nombre_descripcion = "Enzima convertidora de angiotensina I";
                    }
                    if ($nombre_descripcion == "80302034"){
                        $nombre_descripcion = "Perfil Lipídico (incluye: colesterol total, HDL, LDL, VLDL y triglicéridos)";
                    }
                    if ($nombre_descripcion == "80302035"){
                        $nombre_descripcion = "Fármacos y/o drogas; niveles plasmáticos de (alcohol, anorexígenos, antiarrítmicos, antibióticos, antidepresivos, antiepilépticos, antihistamínicos, antiinflamatorios y analgésicos, estimulantes respiratorios, tranquilizantes mayores y menores, etc.) c/u";
                    }
                    if ($nombre_descripcion == "80302036"){
                        $nombre_descripcion = "Fenilalanina";
                    }
                    if ($nombre_descripcion == "80302037"){
                        $nombre_descripcion = "Fosfatasas ácidas totales";
                    }
                    if ($nombre_descripcion == "80302038"){
                        $nombre_descripcion = "Fosfatasas ácidas totales y fracción prostática";
                    }
                    if ($nombre_descripcion == "80302039"){
                        $nombre_descripcion = "Fosfatasas alcalinas con separación de isoenzimas hepáticas, intestinales, óseas c/u";
                    }
                    if ($nombre_descripcion == "80302040"){
                        $nombre_descripcion = "Fosfatasas alcalinas totales";
                    }
                    if ($nombre_descripcion == "80302041"){
                        $nombre_descripcion = "Fosfolípidos";
                    }
                    if ($nombre_descripcion == "80302042"){
                        $nombre_descripcion = "Fósforo (fosfatos) en sangre";
                    }
                    if ($nombre_descripcion == "80302043"){
                        $nombre_descripcion = "Galactosa";
                    }
                    if ($nombre_descripcion == "80302044"){
                        $nombre_descripcion = "Galactosa, curva de tolerancia, (mínimo cuatro determinaciones) (no incluye la galactosa que se administra) (incluye los valores de todas las tomas de muestras necesarias)";
                    }
                    if ($nombre_descripcion == "80302045"){
                        $nombre_descripcion = "Gamma glutamiltranspeptidasa (GGT)";
                    }
                    if ($nombre_descripcion == "80302046"){
                        $nombre_descripcion = "Gases y equilibrio ácido base en sangre (incluye: pH, O2, CO2, exceso de base y bicarbonato), todos o cada uno de los parámetros";
                    }
                    if ($nombre_descripcion == "80302047"){
                        $nombre_descripcion = "Glucosa en sangre";
                    }
                    if ($nombre_descripcion == "80302048"){
                        $nombre_descripcion = "Glucosa, Prueba de Tolerancia a la Glucosa Oral (PTGO), (dos determinaciones) (no incluye la glucosa que se administra) (incluye el valor de las dos tomas de muestras)";
                    }
                    if ($nombre_descripcion == "80302050"){
                        $nombre_descripcion = "Adenosindeaminasa en sangre u otro fluído biológico.";
                    }
                    if ($nombre_descripcion == "80302051"){
                        $nombre_descripcion = "Lactosa, curva de tolerancia, (mínimo cuatro determinaciones) (no incluye la lactosa que se administra) (incluye los valores de todas las tomas de muestras necesarias)";
                    }
                    if ($nombre_descripcion == "80302052"){
                        $nombre_descripcion = "Leucinaminopeptidasa (LAP) ";
                    }
                    if ($nombre_descripcion == "80302053"){
                        $nombre_descripcion = "Lipasa";
                    }
                    if ($nombre_descripcion == "80302069"){
                        $nombre_descripcion = "Lípidos totales (proc. aut.)";
                    }
                    if ($nombre_descripcion == "80302054"){
                        $nombre_descripcion = "Lipoproteínas, electroforesis de (incluye lípidos totales)";
                    }
                    if ($nombre_descripcion == "80302055"){
                        $nombre_descripcion = "Litio";
                    }
                    if ($nombre_descripcion == "80302056"){
                        $nombre_descripcion = "Magnesio";
                    }
                    if ($nombre_descripcion == "80302057"){
                        $nombre_descripcion = "Nitrógeno ureico y/o úrea en sangre";
                    }
                    if ($nombre_descripcion == "80302058"){
                        $nombre_descripcion = "Osmolalidad en sangre ";
                    }
                    if ($nombre_descripcion == "80302075"){
                        $nombre_descripcion = "Perfil bioquímico (determinación automatizada de 12 parámetros)";
                    }
                    if ($nombre_descripcion == "80302059"){
                        $nombre_descripcion = "Proteínas fraccionadas albúmina/globulina (incluye código 03-02-060)";
                    }
                    if ($nombre_descripcion == "80302060"){
                        $nombre_descripcion = "Proteínas totales o albúminas, c/u en sangre";
                    }
                    if ($nombre_descripcion == "80302061"){
                        $nombre_descripcion = "Proteínas, electroforesis (incluye cód. 03-02-060)";
                    }
                    if ($nombre_descripcion == "80302062"){
                        $nombre_descripcion = "Salicilemia cuantitativa";
                    }
                    if ($nombre_descripcion == "80302076"){
                        $nombre_descripcion = "Perfil Hepático (incluye tiempo de protrombina, bilirrubina total y conjugada, fosfatasas alcalinas totales, GGT, transaminasas GOT/AST y GPT/ALT)";
                    }
                    if ($nombre_descripcion == "80302063"){
                        $nombre_descripcion = "Transaminasas, oxalacética (GOT/AST), Pirúvica (GPT/ALT), c/u";
                    }
                    if ($nombre_descripcion == "80302064"){
                        $nombre_descripcion = "Triglicéridos (proc. aut.)";
                    }
                    if ($nombre_descripcion == "80302065"){
                        $nombre_descripcion = "Vitaminas A, B, C, D, E, etc., c/u";
                    }
                    if ($nombre_descripcion == "80302066"){
                        $nombre_descripcion = "Xilosa, prueba de absorción (no incluye la xilosa que se administra)";
                    }
                    if ($nombre_descripcion == ""){
                        $nombre_descripcion = "";
                    }
                    if ($nombre_descripcion == ""){
                        $nombre_descripcion = "";
                    }
                    if ($nombre_descripcion == ""){
                        $nombre_descripcion = "";
                    }
                    if ($nombre_descripcion == ""){
                        $nombre_descripcion = "";
                    }
                    ?>
                <tr>
                    <td align='left'><?php echo substr($row->codigo_prestacion, 1); ?></td>
                    <td align='left'><?php echo $nombre_descripcion; ?></td>
                    <td align='right'><?php echo number_format($row->Col01,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col02,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col03,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col04,0,",",".")?></td>
                    <?php
                    $i++;
                }
                ?>
                <tr>
                    <td></td>
                    <td align='center'><strong>TOTAL</strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol01b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol02b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol03b,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol04b,0,",",".") ?></strong></td>
                </tr>
                <tr>
                    <td></td>
                    <td align="center"><strong>3.- EXÁMENES HORMONALES</strong></td>
                    <td colspan="4"></td>
                </tr>
                <?php
                $query = 'SELECT a.codigo_prestacion,a.descripcion
                              ,sum(ifnull(b.Col01,0)) Col01
                              ,sum(ifnull(b.Col02,0)) Col02
                              ,sum(ifnull(b.Col03,0)) Col03
                              ,sum(ifnull(b.Col04,0)) Col04
                          FROM (select c.* from 2020prestaciones c where c.codigo_prestacion in("80303024","80303025","80303026","80303027","80303028")) a
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

                foreach($registro as $row ){
                    $totalCol01c=$totalCol01c+$row->Col01;
                    $totalCol02c=$totalCol02c+$row->Col02;
                    $totalCol03c=$totalCol03c+$row->Col03;
                    $totalCol04c=$totalCol04c+$row->Col04;

                    $nombre_descripcion = $row->codigo_prestacion;

                    if ($nombre_descripcion == "80303024"){
                        $nombre_descripcion = "Tiroestimulante (TSH), hormona (adulto, niño o R.N.)";
                    }
                    if ($nombre_descripcion == "80303025"){
                        $nombre_descripcion = "Tiroglobulina";
                    }
                    if ($nombre_descripcion == "80303026"){
                        $nombre_descripcion = "Tiroxina libre (T4L)";
                    }
                    if ($nombre_descripcion == "80303027"){
                        $nombre_descripcion = "Tiroxina o tetrayodotironina (T4)";
                    }
                    if ($nombre_descripcion == "80303028"){
                        $nombre_descripcion = "Triyodotironina (T3)";
                    }
                    ?>
                <tr>
                    <td align='left'><?php echo substr($row->codigo_prestacion, 1); ?></td>
                    <td align='left'><?php echo $nombre_descripcion; ?></td>
                    <td align='right'><?php echo number_format($row->Col01,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col02,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col03,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col04,0,",",".")?></td>
                    <?php
                    $i++;
                }
                ?>
                <tr>
                    <td></td>
                    <td align='center'><strong>TOTAL</strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol01c,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol02c,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol03c,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol04c,0,",",".") ?></strong></td>
                </tr>
                <tr>
                    <td></td>
                    <td align="center"><strong>4.- INMUNOLÓGICOS</strong></td>
                    <td colspan="4"></td>
                </tr>
                <?php
                $query = 'SELECT a.codigo_prestacion,a.descripcion
                              ,sum(ifnull(b.Col01,0)) Col01
                              ,sum(ifnull(b.Col02,0)) Col02
                              ,sum(ifnull(b.Col03,0)) Col03
                              ,sum(ifnull(b.Col04,0)) Col04
                          FROM (select c.* from 2020prestaciones c where c.codigo_prestacion in("80305001","80305002","80305003","80305004","80305005","80305006","80305007","80305008",
                                                                                                "80305009","80305070","80305170","80305010","80305011","80305012","80305013","80305014",
                                                                                                "80305015","80305016","80305017","80305018","80305019","80305020","80305021","80305025",
                                                                                                "80305026","80305027","80305028","80305029","80305030","80305031","80305034","80305035",
                                                                                                "80305036","80305037","80305038","80305039","80305040","80305041","80305042","80305043",
                                                                                                "80305044","80305045","80305047","80305048","80305049","80305051","80305052","80305053",
                                                                                                "80305054","80305056","80305057","80305058","80305059","80305060","80305061","80305062",
                                                                                                "80305063")) a
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

                foreach($registro as $row ){
                    $totalCol01d=$totalCol01d+$row->Col01;
                    $totalCol02d=$totalCol02d+$row->Col02;
                    $totalCol03d=$totalCol03d+$row->Col03;
                    $totalCol04d=$totalCol04d+$row->Col04;

                    $nombre_descripcion = $row->codigo_prestacion;

                    if ($nombre_descripcion == "80305001"){
                        $nombre_descripcion = "Alfa -1- antitripsina cuantitativa";
                    }
                    if ($nombre_descripcion == "80305002"){
                        $nombre_descripcion = "Alfa -2- macroglobulina";
                    }
                    if ($nombre_descripcion == "80305003"){
                        $nombre_descripcion = "Alfa fetoproteínas";
                    }
                    if ($nombre_descripcion == "80305004"){
                        $nombre_descripcion = "Tamizaje de Anticuerpos anti antígenos nucleares extractables (a- ENA: Sm, RNP, Ro, La, Scl- 70 y Jo- 1)";
                    }
                    if ($nombre_descripcion == "80305005"){
                        $nombre_descripcion = "Anticuerpos antinucleares (ANA), antimitocondriales, anti DNA (ADNA), anti músculo liso, anticentrómero, u otros, c/u.";
                    }
                    if ($nombre_descripcion == "80305006"){
                        $nombre_descripcion = "Anticuerpos atípicos, pannel de identificación";
                    }
                    if ($nombre_descripcion == "80305007"){
                        $nombre_descripcion = "Anticuerpos específicos y otros autoanticuerpos (anticuerpos antitiroídeos: anticuerpos antimicrosomales y antitiroglobulinas y otros anticuerpos: prostático, espermios, etc.) c/u";
                    }
                    if ($nombre_descripcion == "80305008"){
                        $nombre_descripcion = "Antiestreptolisina O, por técnica de látex";
                    }
                    if ($nombre_descripcion == "80305009"){
                        $nombre_descripcion = "Antígeno carcinoembrionario (CEA)";
                    }
                    if ($nombre_descripcion == "80305070"){
                        $nombre_descripcion = "Antígeno prostático específico";
                    }
                    if ($nombre_descripcion == "80305170"){
                        $nombre_descripcion = "Antígeno Ca 125, Ca 15-3 y Ca 19-9, c/u";
                    }
                    if ($nombre_descripcion == "80305010"){
                        $nombre_descripcion = "Beta-2-microglobulina";
                    }
                    if ($nombre_descripcion == "80305011"){
                        $nombre_descripcion = "Complejos inmunes circulantes";
                    }
                    if ($nombre_descripcion == "80305012"){
                        $nombre_descripcion = "Complemento C1Q, C2, C3, C4, etc., c/u";
                    }
                    if ($nombre_descripcion == "80305013"){
                        $nombre_descripcion = "Complemento hemolítico (CH 50)";
                    }
                    if ($nombre_descripcion == "80305014"){
                        $nombre_descripcion = "Crioglobulinas, precipitación en frío (cualitativa) o cuantitativa c/u";
                    }
                    if ($nombre_descripcion == "80305015"){
                        $nombre_descripcion = "Depósito de complejos inmunes por inmunofluorescencia";
                    }
                    if ($nombre_descripcion == "80305016"){
                        $nombre_descripcion = "Depósito de complemento por inmunofluorescencia (C3, C4), c/u";
                    }
                    if ($nombre_descripcion == "80305017"){
                        $nombre_descripcion = "Depósito de fibrinógeno por inmunofluorescencia";
                    }
                    if ($nombre_descripcion == "80305018"){
                        $nombre_descripcion = "Depósito de inmunoglobulina por inmunofluorescencia (IgG, IgA, IgM) c/u";
                    }
                    if ($nombre_descripcion == "80305019"){
                        $nombre_descripcion = "Factor reumatoídeo por técnica de látex u otras similares";
                    }
                    if ($nombre_descripcion == "80305020"){
                        $nombre_descripcion = "Factor reumatoídeo por técnica Scat, Waaler Rose, nefelométricas y/o turbidimétricas";
                    }
                    if ($nombre_descripcion == "80305021"){
                        $nombre_descripcion = "Inhibidor de C1Q, C2 y C3, c/u";
                    }
                    if ($nombre_descripcion == "80305025"){
                        $nombre_descripcion = "Inmunofijación de inmunoglobulina, c/u";
                    }
                    if ($nombre_descripcion == "80305026"){
                        $nombre_descripcion = "Inmunoglobulina IgA secretora";
                    }
                    if ($nombre_descripcion == "80305027"){
                        $nombre_descripcion = "Inmunoglobulinas IgA, IgG, IgM, c/u";
                    }
                    if ($nombre_descripcion == "80305028"){
                        $nombre_descripcion = "Inmunoglobulinas IgE, IgD total, c/u";
                    }
                    if ($nombre_descripcion == "80305029"){
                        $nombre_descripcion = "Inmunoglobulinas IgE, IgG específicas, c/u";
                    }
                    if ($nombre_descripcion == "80305030"){
                        $nombre_descripcion = "Proteína C reactiva por técnica de látex u otras similares";
                    }
                    if ($nombre_descripcion == "80305031"){
                        $nombre_descripcion = "Proteína C reactiva por técnicas nefelométricas y/o turbidimétricas";
                    }
                    if ($nombre_descripcion == "80305034"){
                        $nombre_descripcion = "Quimiotaxis-leucotaxis";
                    }
                    if ($nombre_descripcion == "80305035"){
                        $nombre_descripcion = "Crioaglutininas";
                    }
                    if ($nombre_descripcion == "80305036"){
                        $nombre_descripcion = "Criohemolisinas";
                    }
                    if ($nombre_descripcion == "80305037"){
                        $nombre_descripcion = "Digestión fagocítica nitroblue-tetrazolium cualitativo y cuantitativo";
                    }
                    if ($nombre_descripcion == "80305038"){
                        $nombre_descripcion = "Fagocitosis: ingestión y digestión (killing) de levaduras por polimorfonucleares";
                    }
                    if ($nombre_descripcion == "80305039"){
                        $nombre_descripcion = "Fagocitosis: ingestión y digestión (killing) de bacterias por polimorfonucleares";
                    }
                    if ($nombre_descripcion == "80305040"){
                        $nombre_descripcion = "Inmunoadherencia de leucocitos macrófagos";
                    }
                    if ($nombre_descripcion == "80305041"){
                        $nombre_descripcion = "Intradermoreacción (PPD, histoplasmina, aspergilina, u otros, incluye el valor del antígeno y reacción de control), c/u.";
                    }
                    if ($nombre_descripcion == "80305042"){
                        $nombre_descripcion = "LIF o MIF";
                    }
                    if ($nombre_descripcion == "80305043"){
                        $nombre_descripcion = "Linfocitos B (inmunofluorescencia)";
                    }
                    if ($nombre_descripcion == "80305044"){
                        $nombre_descripcion = "Linfocitos B (rosetas EAC) y linfocitos T (rosetas E) c/u";
                    }
                    if ($nombre_descripcion == "80305045"){
                        $nombre_descripcion = "Linfocitos T ''helper'' (OKT4) o supresores (OKT8) con antisuero monoclonal, c/u";
                    }
                    if ($nombre_descripcion == "80305047"){
                        $nombre_descripcion = "Linfotoxinas humanas, detección de";
                    }
                    if ($nombre_descripcion == "80305048"){
                        $nombre_descripcion = "Reacción cutánea 16 alergenos por escarificación (incluye el valor de los antígenos)";
                    }
                    if ($nombre_descripcion == "80305049"){
                        $nombre_descripcion = "Transformación linfoblástica a drogas, análisis de transformación espontanea con estimulo inespecífico y con diferentes concentraciones de la droga en 1000 células";
                    }
                    if ($nombre_descripcion == "80305051"){
                        $nombre_descripcion = "Absorción de autoanticuerpos del receptor";
                    }
                    if ($nombre_descripcion == "80305052"){
                        $nombre_descripcion = "Anticuerpos linfocitotóxicos (PRA) por microlinfocitotoxicidad";
                    }
                    if ($nombre_descripcion == "80305053"){
                        $nombre_descripcion = "Autocrossmatch con linfocitos T y B";
                    }
                    if ($nombre_descripcion == "80305054"){
                        $nombre_descripcion = "Autocross match con linfocitos totales";
                    }
                    if ($nombre_descripcion == "80305056"){
                        $nombre_descripcion = "Alocrossmatch con linfocitos totales";
                    }
                    if ($nombre_descripcion == "80305057"){
                        $nombre_descripcion = "Alocrossmatch con linfocitos T y B";
                    }
                    if ($nombre_descripcion == "80305058"){
                        $nombre_descripcion = "Cultivo mixto de linfocitos";
                    }
                    if ($nombre_descripcion == "80305059"){
                        $nombre_descripcion = "Identificación de clase de inmunoglobulinas de auto o alo cross match positivo";
                    }
                    if ($nombre_descripcion == "80305060"){
                        $nombre_descripcion = "Tipificación HLA B-27";
                    }
                    if ($nombre_descripcion == "80305061"){
                        $nombre_descripcion = "Tipificación HLA B-8";
                    }
                    if ($nombre_descripcion == "80305062"){
                        $nombre_descripcion = "Tipificación HLA  - DR serológica";
                    }
                    if ($nombre_descripcion == "80305063"){
                        $nombre_descripcion = "Tipificación HLA - A, B serológica";
                    }
                    ?>
                <tr>
                    <td align='left'><?php echo substr($row->codigo_prestacion, 1); ?></td>
                    <td align='left'><?php echo $nombre_descripcion; ?></td>
                    <td align='right'><?php echo number_format($row->Col01,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col02,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col03,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col04,0,",",".")?></td>
                    <?php
                    $i++;
                }
                ?>
                <tr>
                    <td></td>
                    <td align='center'><strong>TOTAL</strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol01d,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol02d,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol03d,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol04d,0,",",".") ?></strong></td>
                </tr>
                <tr>
                    <td></td>
                    <td align="center"><strong>5.- MICROBIOLÓGICOS</strong></td>
                    <td colspan="4"></td>
                </tr>
                <?php
                $query = 'SELECT a.codigo_prestacion,a.descripcion
                              ,sum(ifnull(b.Col01,0)) Col01
                              ,sum(ifnull(b.Col02,0)) Col02
                              ,sum(ifnull(b.Col03,0)) Col03
                              ,sum(ifnull(b.Col04,0)) Col04
                          FROM (select c.* from 2020prestaciones c where c.codigo_prestacion in("80306001","80306002","80306004","80306005","80306006","80306007","80306008","80306009",
                                                                                                "80306010","80306011","80306012","80306013","80306014","80306015","80306016","80306017",
                                                                                                "80306117","80306018","80306019","80306020","80306021","80306022","80306023","80306024",
                                                                                                "80306025","80306026","80306027","80306028","80306029","80306030","80306031","80306032",
                                                                                                "80306033","80306034","80306036","80306037","80306038","80306039","80306041","80306042",
                                                                                                "80306043","80306045","80306046","80306047","80306048","80306049","80306050","80306051",
                                                                                                "80306052","80306053","80306054","80306056","80306057","80306058","80306059","80306061",
                                                                                                "80306062","80306063","80306064","80306065","80306066","80306067","80306068","80306069",
                                                                                                "80306169","80306070","80306170","80306270","80306072","80306073","80306074","80306075",
                                                                                                "80306076","80306077","80306078","80306079","80306080","80306081")) a
                          left join 2020rems b on (a.id_prestacion=b.prestacion_id_prestacion)
                          AND (b.Mes in ('.$mes.')) AND (b.establecimiento_id_establecimiento in ('.$estab.'))
                          group by  a.codigo_prestacion,a.descripcion,a.id_prestacion
                          order by a.id_prestacion';
                $registro = DB::connection('mysql_rem')->select($query);

                $i=0;

                $totalCol01e=0;
    						$totalCol02e=0;
    						$totalCol03e=0;
                $totalCol04e=0;

                foreach($registro as $row ){
                    $totalCol01e=$totalCol01e+$row->Col01;
                    $totalCol02e=$totalCol02e+$row->Col02;
                    $totalCol03e=$totalCol03e+$row->Col03;
                    $totalCol04e=$totalCol04e+$row->Col04;

                    $nombre_descripcion = $row->codigo_prestacion;

                    if ($nombre_descripcion == "80306001"){
                        $nombre_descripcion = "Baciloscopía Ziehl-Neelsen por concentración de líquidos (orina u otros), c/u";
                    }
                    if ($nombre_descripcion == "80306002"){
                        $nombre_descripcion = "Baciloscopía Ziehl-Neelsen, c/u";
                    }
                    if ($nombre_descripcion == "80306004"){
                        $nombre_descripcion = "Examen directo al fresco, c/s tinción (incluye trichomonas)";
                    }
                    if ($nombre_descripcion == "80306005"){
                        $nombre_descripcion = "Tinción de Gram";
                    }
                    if ($nombre_descripcion == "80306006"){
                        $nombre_descripcion = "Ultramicroscopía (incluye toma de muestras)";
                    }
                    if ($nombre_descripcion == "80306007"){
                        $nombre_descripcion = "Coprocultivo, c/u";
                    }
                    if ($nombre_descripcion == "80306008"){
                        $nombre_descripcion = "Corriente (excepto coprocultivo, hemocultivo y urocultivo) c/u";
                    }
                    if ($nombre_descripcion == "80306009"){
                        $nombre_descripcion = "Hemocultivo aerobio, c/u";
                    }
                    if ($nombre_descripcion == "80306010"){
                        $nombre_descripcion = "Hemocultivo anaerobio, c/u";
                    }
                    if ($nombre_descripcion == "80306011"){
                        $nombre_descripcion = "Urocultivo, recuento de colonias y antibiograma (cualquier técnica) (incluye toma de orina aséptica) (no incluye recolector pediátrico)";
                    }
                    if ($nombre_descripcion == "80306012"){
                        $nombre_descripcion = "Anaerobios (incluye cód. 03-06-008)";
                    }
                    if ($nombre_descripcion == "80306013"){
                        $nombre_descripcion = "Cultivo específico para Bordetella";
                    }
                    if ($nombre_descripcion == "80306014"){
                        $nombre_descripcion = "Cultivo para Campylobacter, Yersinia, Vibrio, c/u";
                    }
                    if ($nombre_descripcion == "80306015"){
                        $nombre_descripcion = "Difteria";
                    }
                    if ($nombre_descripcion == "80306016"){
                        $nombre_descripcion = "Neisseria gonorrhoeae (gonococo)";
                    }
                    if ($nombre_descripcion == "80306017"){
                        $nombre_descripcion = "Cultivo para Levaduras";
                    }
                    if ($nombre_descripcion == "80306117"){
                        $nombre_descripcion = "Hongos Filamentosos";
                    }
                    if ($nombre_descripcion == "80306018"){
                        $nombre_descripcion = "Cultivo para bacilo de Koch, (incluye otras micobacterias)";
                    }
                    if ($nombre_descripcion == "80306019"){
                        $nombre_descripcion = "Cultivo para Legionella";
                    }
                    if ($nombre_descripcion == "80306020"){
                        $nombre_descripcion = "Listeria";
                    }
                    if ($nombre_descripcion == "80306021"){
                        $nombre_descripcion = "Neisseria meningitidis (meningococo)";
                    }
                    if ($nombre_descripcion == "80306022"){
                        $nombre_descripcion = "Cultivo y Tipificación de micobacterias";
                    }
                    if ($nombre_descripcion == "80306023"){
                        $nombre_descripcion = "Mycoplasma y Ureaplasma, c/u";
                    }
                    if ($nombre_descripcion == "80306024"){
                        $nombre_descripcion = "Anaerobios  (mínimo 4 fármacos)";
                    }
                    if ($nombre_descripcion == "80306025"){
                        $nombre_descripcion = "Bacilo de Koch (cada fármaco)";
                    }
                    if ($nombre_descripcion == "80306026"){
                        $nombre_descripcion = "Corriente (mínimo 10 fármacos) (en caso de urocultivo no corresponde su cobro; incluido en el valor 03-06-011)";
                    }
                    if ($nombre_descripcion == "80306027"){
                        $nombre_descripcion = "Estudio de sensibilidad por dilución (CIM) (mínimo 6 fármacos) (en caso de urocultivo, no corresponde su cobro; incluido en el valor código 03-06-011)";
                    }
                    if ($nombre_descripcion == "80306028"){
                        $nombre_descripcion = "Antifungigrama (mínimo 4 fármacos antihongos)";
                    }
                    if ($nombre_descripcion == "80306029"){
                        $nombre_descripcion = "Autovacunas, incluye cultivo y preparación  de mínimo 10 ampollas";
                    }
                    if ($nombre_descripcion == "80306030"){
                        $nombre_descripcion = "Poder bactericida del suero";
                    }
                    if ($nombre_descripcion == "80306031"){
                        $nombre_descripcion = "Preparación de vacunas uni o polivalentes mantenidas en stock (mínimo 5 ampollas)";
                    }
                    if ($nombre_descripcion == "80306032"){
                        $nombre_descripcion = "Aspergilosis, candidiasis, histoplasmosis u otros hongos por inmunodiagnóstico c/u";
                    }
                    if ($nombre_descripcion == "80306033"){
                        $nombre_descripcion = "Brucella, reacción de aglutinación para (Wright-Hudleson) o similares";
                    }
                    if ($nombre_descripcion == "80306034"){
                        $nombre_descripcion = "Clamidias por inmunofluorescencia, peroxidasa, Elisa o similares";
                    }
                    if ($nombre_descripcion == "80306036"){
                        $nombre_descripcion = "Mononucleosis, reacción de Paul Bunnell, Anticuerpos Heterófilos o similares";
                    }
                    if ($nombre_descripcion == "80306037"){
                        $nombre_descripcion = "Mycoplasma IgG, IgM, c/u.";
                    }
                    if ($nombre_descripcion == "80306038"){
                        $nombre_descripcion = "R.P.R.";
                    }
                    if ($nombre_descripcion == "80306039"){
                        $nombre_descripcion = "Tíficas, reacciones de aglutinación  (Eberth H y O, paratyphi A y B) (Widal)";
                    }
                    if ($nombre_descripcion == "80306041"){
                        $nombre_descripcion = "Treponema pallidum FTA - ABS, MHA-TP c/u";
                    }
                    if ($nombre_descripcion == "80306042"){
                        $nombre_descripcion = " V.D.R.L.";
                    }
                    if ($nombre_descripcion == "80306043"){
                        $nombre_descripcion = "Artrópodos macroscópicos y microscópicos (imagos y/o pupas y/o larvas), diagnóstico de";
                    }
                    if ($nombre_descripcion == "80306045"){
                        $nombre_descripcion = "Coproparasitario seriado con técnica  para Cryptosporidium sp o para Diantamoeba fragilis (incluye los códigos 03-06-048 y/o 03-06-059 más aplicación de técnica de frotis con tinción tricrómica o tinción Ziehl-Neelsen en por lo menos 3 muestras, según corresponda)";
                    }
                    if ($nombre_descripcion == "80306046"){
                        $nombre_descripcion = "Coproparasitario seriado para Fasciola hepática (incluye diagnostico de gusanos macroscópicos y ex. microscópico de 10 muestras separadas por método de Telemann y de otras 10 muestras separadas y simultáneas con las ant. por téc. de sedimentación)";
                    }
                    if ($nombre_descripcion == "80306047"){
                        $nombre_descripcion = "Coproparasitario seriado para Isospora y Sarcocystis (incluye diagnóstico de gusanos macroscópicos y examen  microscópico de 3 muestras separadas)";
                    }
                    if ($nombre_descripcion == "80306048"){
                        $nombre_descripcion = "Coproparasitológico seriado simple (incluye diagnostico de gusanos macroscópicos y examen microscópico por concentración de 3 muestras separadas método Telemann) (proc. aut.)";
                    }
                    if ($nombre_descripcion == "80306049"){
                        $nombre_descripcion = "Diagnostico de parásitos en jugo duodenal y/o bilis, examen macroscópico y microscópico (directo y/o concentración, c/s tinción)";
                    }
                    if ($nombre_descripcion == "80306050"){
                        $nombre_descripcion = "Diagnostico parasitario en exudados, secreciones y otros líquidos orgánicos (no especificados mas adelante), examen macro y microscópico de (incluye concentración y/o tinción cuando proceda), c/u";
                    }
                    if ($nombre_descripcion == "80306051"){
                        $nombre_descripcion = "Graham, examen de (incluye diagnostico de gusanos macroscópicos y examen microscópico de 5 muestras separadas)";
                    }
                    if ($nombre_descripcion == "80306052"){
                        $nombre_descripcion = "Gusanos macroscópicos, diagnóstico de (proc. aut.)";
                    }
                    if ($nombre_descripcion == "80306053"){
                        $nombre_descripcion = "Hemoparásitos, diagnóstico microscópico de (mínimo 10 frotis y/o gotas gruesas, c/s examen directo al fresco), cada sesión";
                    }
                    if ($nombre_descripcion == "80306054"){
                        $nombre_descripcion = "Hemoparásitos, diagnóstico por técnica de Strout o similar en hasta 10 tubos capilares, cada sesión";
                    }
                    if ($nombre_descripcion == "80306056"){
                        $nombre_descripcion = "Raspado de piel, examen microscópico de (''Acarotest''): de 6 a 10 preparaciones";
                    }
                    if ($nombre_descripcion == "80306057"){
                        $nombre_descripcion = "Tenias post. trat., Diagnostico y búsqueda de escólex de";
                    }
                    if ($nombre_descripcion == "80306058"){
                        $nombre_descripcion = "Xenodiagnóstico (cada aplicación de 2 cajas, con 6 ninfas por lo menos c/u, examinadas a los 20 y/o 30 días y hasta por 60 días más si procede)";
                    }
                    if ($nombre_descripcion == "80306059"){
                        $nombre_descripcion = "Coproparasitológico seriado simple (incluye diagnóstico de gusanos macroscopicos  y exámen microscopico por concentración de tres muestras separadas método PAFS (proc. aut.)";
                    }
                    if ($nombre_descripcion == "80306061"){
                        $nombre_descripcion = "Elisa indirecta (Chagas, hidatidosis, toxocariasis y otras), c/u";
                    }
                    if ($nombre_descripcion == "80306062"){
                        $nombre_descripcion = "Fijación del complemento (distomatosis, toxoplasmosis, cisticercosis y otras) c/u";
                    }
                    if ($nombre_descripcion == "80306063"){
                        $nombre_descripcion = "Floculación en bentonita, látex, precipitinas o similar (triquinosis, hidatidosis y otros), c/u";
                    }
                    if ($nombre_descripcion == "80306064"){
                        $nombre_descripcion = "Hemaglutinación indirecta (toxoplasmosis, Chagas, hidatidosis y otras), c/u";
                    }
                    if ($nombre_descripcion == "80306065"){
                        $nombre_descripcion = "Inmunoelectroforesis o contrainmunoelectroforesis (hidatidosis, distomatosis, amebiasis y otras), c/u";
                    }
                    if ($nombre_descripcion == "80306066"){
                        $nombre_descripcion = "Inmunofluorescencia indirecta (toxoplasmosis, Chagas, amebiasis y otras), c/u";
                    }
                    if ($nombre_descripcion == "80306067"){
                        $nombre_descripcion = "Reacción intradérmica (incluye el valor y la aplicación del antígeno y del control y examen de las reacciones inmediatas y retardadas, cada antígeno) (bachmann, distomatosis u otras)";
                    }
                    if ($nombre_descripcion == "80306068"){
                        $nombre_descripcion = "Aislamiento de virus (adenovirus, citomegalovirus, Coxsakie, herpes, influenza, polio, sarampión y otros), c/u";
                    }
                    if ($nombre_descripcion == "80306069"){
                        $nombre_descripcion = "Anticuerpos virales, determ. de (adenovirus, citomegalovirus, herpes simple, rubéola, Influenza  A y B; virus varicela-zoster; virus sincicial respiratorio; parainfluenza 1, 2 y 3, Epstein Barr y otros), c/u";
                    }
                    if ($nombre_descripcion == "80306169"){
                        $nombre_descripcion = "Anticuerpos virales, determ. de H.I.V.";
                    }
                    if ($nombre_descripcion == "80306070"){
                        $nombre_descripcion = "Antígenos virales determ. de (adenovirus, citomegalovirus, herpes simple, rubéola, influenza y otros), (por cualquier técnica ej: inmunofluorescencia), c/u";
                    }
                    if ($nombre_descripcion == "80306170"){
                        $nombre_descripcion = "Antígenos virales determ. de rotavirus, por cualquier técnica";
                    }
                    if ($nombre_descripcion == "80306270"){
                        $nombre_descripcion = "Antígenos virales determ. de virus sincicial, por cualquier técnica";
                    }
                    if ($nombre_descripcion == "80306072"){
                        $nombre_descripcion = "Reacción de seroneutralización para: virus polio, ECHO, Coxsakie, c/u";
                    }
                    if ($nombre_descripcion == "80306073"){
                        $nombre_descripcion = "Virus hepatitis A, Anticore";
                    }
                    if ($nombre_descripcion == "80306074"){
                        $nombre_descripcion = "Virus hepatitis A, anticuerpos IgM del";
                    }
                    if ($nombre_descripcion == "80306075"){
                        $nombre_descripcion = "Virus hepatitis B, anticuerpo del antígeno E del";
                    }
                    if ($nombre_descripcion == "80306076"){
                        $nombre_descripcion = "Virus hepatitis B, anticore total del (anti HBc total)";
                    }
                    if ($nombre_descripcion == "80306077"){
                        $nombre_descripcion = "Virus hepatitis B, anticuerpos de antígeno de superficie (australiano)";
                    }
                    if ($nombre_descripcion == "80306078"){
                        $nombre_descripcion = "Virus hepatitis B, antígeno E del (HBEAg)";
                    }
                    if ($nombre_descripcion == "80306079"){
                        $nombre_descripcion = "Virus hepatitis B, antígeno superficie";
                    }
                    if ($nombre_descripcion == "80306080"){
                        $nombre_descripcion = "Virus hepatitis B, anticore IgM del (anti HBc IgM)";
                    }
                    if ($nombre_descripcion == "80306081"){
                        $nombre_descripcion = "Virus hepatitis C, anticuerpos de (anti HCV)";
                    }
                    ?>
                <tr>
                    <td align='left'><?php echo substr($row->codigo_prestacion, 1); ?></td>
                    <td align='left'><?php echo $nombre_descripcion; ?></td>
                    <td align='right'><?php echo number_format($row->Col01,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col02,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col03,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col04,0,",",".")?></td>
                    <?php
                    $i++;
                }
                ?>
                <tr>
                    <td></td>
                    <td align='center'><strong>TOTAL</strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol01e,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol02e,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol03e,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol04e,0,",",".") ?></strong></td>
                </tr>
                <tr>
                    <td></td>
                    <td align="center"><strong>6.- EXÁMENES DE DEPOSICIONES, EXUDADOS, SECRESIONES Y OTROS LÍQUIDOS</strong></td>
                    <td colspan="4"></td>
                </tr>
                <?php
                $query = 'SELECT a.codigo_prestacion,a.descripcion
                              ,sum(ifnull(b.Col01,0)) Col01
                              ,sum(ifnull(b.Col02,0)) Col02
                              ,sum(ifnull(b.Col03,0)) Col03
                              ,sum(ifnull(b.Col04,0)) Col04
                          FROM (select c.* from 2020prestaciones c where c.codigo_prestacion in("80308001","80308002","80308003","80308004","80308005","80308006","80308007","80308008",
                                                                                                "80308009","80308010","80308011","80308012","80308013","80308014","80308015","80308016",
                                                                                                "80308017","80308018","80308019","80308020","80308021","80308022","80308023","80308024",
                                                                                                "80308025","80308026","80308027","80308028","80308029","80308030","80308031","80308032",
                                                                                                "80308033","80308034","80308035","80308036","80308037","80308038","80308039","80308040",
                                                                                                "80308041","80308042","80308043","80308044")) a
                          left join 2020rems b on (a.id_prestacion=b.prestacion_id_prestacion)
                          AND (b.Mes in ('.$mes.')) AND (b.establecimiento_id_establecimiento in ('.$estab.'))
                          group by  a.codigo_prestacion,a.descripcion,a.id_prestacion
                          order by a.id_prestacion';
                $registro = DB::connection('mysql_rem')->select($query);

                $i=0;

    						$totalCol02f=0;
                $totalCol01f=0;
    						$totalCol03f=0;
                $totalCol04f=0;

                foreach($registro as $row ){
                    $totalCol01f=$totalCol01f+$row->Col01;
                    $totalCol02f=$totalCol02f+$row->Col02;
                    $totalCol03f=$totalCol03f+$row->Col03;
                    $totalCol04f=$totalCol04f+$row->Col04;

                    $nombre_descripcion = $row->codigo_prestacion;

                    if ($nombre_descripcion == "80308001"){
                        $nombre_descripcion = "Azúcares reductores (Benedict-Fehling o similar)";
                    }
                    if ($nombre_descripcion == "80308002"){
                        $nombre_descripcion = "Balance graso (Van de Kamer) muestra de tres o más días";
                    }
                    if ($nombre_descripcion == "80308003"){
                        $nombre_descripcion = "Grasas neutras (Sudán III) ";
                    }
                    if ($nombre_descripcion == "80308004"){
                        $nombre_descripcion = "Hemorragias ocultas, (bencidina, guayaco o test de Weber y similares), cualquier método, c/muestra";
                    }
                    if ($nombre_descripcion == "80308005"){
                        $nombre_descripcion = "Leucocitos fecales";
                    }
                    if ($nombre_descripcion == "80308006"){
                        $nombre_descripcion = "PH";
                    }
                    if ($nombre_descripcion == "80308007"){
                        $nombre_descripcion = "Porfirinas, c/u";
                    }
                    if ($nombre_descripcion == "80308008"){
                        $nombre_descripcion = "Urobilinógeno cuantitativo";
                    }
                    if ($nombre_descripcion == "80308009"){
                        $nombre_descripcion = "Células neoplásicas en fluídos biológicos";
                    }
                    if ($nombre_descripcion == "80308010"){
                        $nombre_descripcion = "Citológico c/s tinción (incluye examen al fresco, recuento celular y citológico porcentual)";
                    }
                    if ($nombre_descripcion == "80308011"){
                        $nombre_descripcion = "Directo al fresco c/s tinción, (incluye trichomonas)";
                    }
                    if ($nombre_descripcion == "80308012"){
                        $nombre_descripcion = "Electrolitos (sodio, potasio, cloro), c/u";
                    }
                    if ($nombre_descripcion == "80308013"){
                        $nombre_descripcion = "Eosinófilos, recuento de";
                    }
                    if ($nombre_descripcion == "80308014"){
                        $nombre_descripcion = "Físico-químico (incluye aspecto, color, pH, glucosa, proteína, Pandy y filancia)";
                    }
                    if ($nombre_descripcion == "80308015"){
                        $nombre_descripcion = "Glucosa en exudados secreciones y otros liquidos";
                    }
                    if ($nombre_descripcion == "80308016"){
                        $nombre_descripcion = "Mucina, determinación de";
                    }
                    if ($nombre_descripcion == "80308017"){
                        $nombre_descripcion = "pH, (proc. aut.)";
                    }
                    if ($nombre_descripcion == "80308018"){
                        $nombre_descripcion = "Proteínas totales o albúmina (proc. aut.) c/u";
                    }
                    if ($nombre_descripcion == "80308019"){
                        $nombre_descripcion = "Proteínas, electroforesis de (incluye proteínas totales)";
                    }
                    if ($nombre_descripcion == "80308020"){
                        $nombre_descripcion = "Bandas oligoclonales (incluye electroforesis de L.C.R., suero e inmunofijación)";
                    }
                    if ($nombre_descripcion == "80308021"){
                        $nombre_descripcion = "Glutamina";
                    }
                    if ($nombre_descripcion == "80308022"){
                        $nombre_descripcion = "Indice IgG/albúmina (incluye determ. de IgG y albúmina en L.C.R. y suero)";
                    }
                    if ($nombre_descripcion == "80308023"){
                        $nombre_descripcion = "Estudio de cristales (con luz polarizada)";
                    }
                    if ($nombre_descripcion == "80308024"){
                        $nombre_descripcion = "Acidez titulable, pH, volumen (una muestra)";
                    }
                    if ($nombre_descripcion == "80308025"){
                        $nombre_descripcion = "Prueba de estimulación máxima con histamina, mínimo 5 muestras (no incluye la histamina ni el antihistamínico).";
                    }
                    if ($nombre_descripcion == "80308026"){
                        $nombre_descripcion = "Volumen, anhídrido carbónico, amilasa y lipasa";
                    }
                    if ($nombre_descripcion == "80308027"){
                        $nombre_descripcion = "Cristales de colesterol";
                    }
                    if ($nombre_descripcion == "80308028"){
                        $nombre_descripcion = "Lípidos biliares";
                    }
                    if ($nombre_descripcion == "80308029"){
                        $nombre_descripcion = "Espermiograma (físico y microscópico, con o sin observación hasta 24 horas)";
                    }
                    if ($nombre_descripcion == "80308030"){
                        $nombre_descripcion = "Fosfatasa ácida prostática";
                    }
                    if ($nombre_descripcion == "80308031"){
                        $nombre_descripcion = "Fructosa, consumo de";
                    }
                    if ($nombre_descripcion == "80308032"){
                        $nombre_descripcion = "Bilirrubina";
                    }
                    if ($nombre_descripcion == "80308033"){
                        $nombre_descripcion = "Células anaranjadas (proc. aut.)";
                    }
                    if ($nombre_descripcion == "80308034"){
                        $nombre_descripcion = "Contaminantes (meconio y sangre) (proc. aut.)";
                    }
                    if ($nombre_descripcion == "80308035"){
                        $nombre_descripcion = "Creatinina (proc. aut.)";
                    }
                    if ($nombre_descripcion == "80308036"){
                        $nombre_descripcion = "Fosfatidil glicerol y/o fosfatidil inositol";
                    }
                    if ($nombre_descripcion == "80308037"){
                        $nombre_descripcion = "Indice de bilirrubina (prueba de Liley)";
                    }
                    if ($nombre_descripcion == "80308038"){
                        $nombre_descripcion = "Indice lecitina/esfingomielina";
                    }
                    if ($nombre_descripcion == "80308039"){
                        $nombre_descripcion = "Madurez fetal completa (físico; células anaranjadas, bilirrubina, test de Clements, creatinina, contaminantes)";
                    }
                    if ($nombre_descripcion == "80308040"){
                        $nombre_descripcion = "Test de Clements (proc. aut.)";
                    }
                    if ($nombre_descripcion == "80308041"){
                        $nombre_descripcion = "Colpocitograma";
                    }
                    if ($nombre_descripcion == "80308042"){
                        $nombre_descripcion = "Cristalización y filancia de moco cervical";
                    }
                    if ($nombre_descripcion == "80308043"){
                        $nombre_descripcion = "Moco-semen, prueba de compatibilidad";
                    }
                    if ($nombre_descripcion == "80308044"){
                        $nombre_descripcion = "Flujo vaginal o secreción uretral, estudio de (incluye toma de muestra y códigos 03-06-004, 03-06-005, 03-06-008, 03-06-017, y 03-06-026 )";
                    }

                    ?>
                <tr>
                    <td align='left'><?php echo substr($row->codigo_prestacion, 1); ?></td>
                    <td align='left'><?php echo $nombre_descripcion; ?></td>
                    <td align='right'><?php echo number_format($row->Col01,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col02,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col03,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col04,0,",",".")?></td>
                    <?php
                    $i++;
                }
                ?>
                <tr>
                    <td></td>
                    <td align='center'><strong>TOTAL</strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol01f,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol02f,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol03f,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol04f,0,",",".") ?></strong></td>
                </tr>
                <tr>
                    <td></td>
                    <td align="center"><strong>7.- EXÁMENES DE ORINA</strong></td>
                    <td colspan="4"></td>
                </tr>
                <?php
                $query = 'SELECT a.codigo_prestacion,a.descripcion
                              ,sum(ifnull(b.Col01,0)) Col01
                              ,sum(ifnull(b.Col02,0)) Col02
                              ,sum(ifnull(b.Col03,0)) Col03
                              ,sum(ifnull(b.Col04,0)) Col04
                          FROM (select c.* from 2020prestaciones c where c.codigo_prestacion in("80309001","80309002","80309003","80309004","80309005","80309006","80309007","80309008",
                                                                                                "80309009","80309010","80309011","80309012","80309013","80309014","80309040","80309015",
                                                                                                "80309016","80309035","80309017","80309018","80309019","80309020","80309021","80309022",
                                                                                                "80309023","80309024","80309025","80309027","80309028","80309029")) a
                          left join 2020rems b on (a.id_prestacion=b.prestacion_id_prestacion)
                          AND (b.Mes in ('.$mes.')) AND (b.establecimiento_id_establecimiento in ('.$estab.'))
                          group by  a.codigo_prestacion,a.descripcion,a.id_prestacion
                          order by a.id_prestacion';
                $registro = DB::connection('mysql_rem')->select($query);

                $i=0;

    						$totalCol02g=0;
                $totalCol01g=0;
    						$totalCol03g=0;
                $totalCol04g=0;

                foreach($registro as $row ){
                    $totalCol01g=$totalCol01g+$row->Col01;
                    $totalCol02g=$totalCol02g+$row->Col02;
                    $totalCol03g=$totalCol03g+$row->Col03;
                    $totalCol04g=$totalCol04g+$row->Col04;

                    $nombre_descripcion = $row->codigo_prestacion;

                    if ($nombre_descripcion == "80309001"){
                        $nombre_descripcion = "Acido ascórbico";
                    }
                    if ($nombre_descripcion == "80309002"){
                        $nombre_descripcion = "Acido delta aminolevulínico";
                    }
                    if ($nombre_descripcion == "80309003"){
                        $nombre_descripcion = "Acido fenilpirúvico (PKU, cualitativo)";
                    }
                    if ($nombre_descripcion == "80309004"){
                        $nombre_descripcion = "Acido úrico cuantitativo";
                    }
                    if ($nombre_descripcion == "80309005"){
                        $nombre_descripcion = "Acido 5 hidroxiindolacético cuantitativo";
                    }
                    if ($nombre_descripcion == "80309006"){
                        $nombre_descripcion = "Amilasa cuantitativa en orina";
                    }
                    if ($nombre_descripcion == "80309007"){
                        $nombre_descripcion = "Aminoácidos (cualitativo) (excepto fenilalanina, PKU)";
                    }
                    if ($nombre_descripcion == "80309008"){
                        $nombre_descripcion = "Calcio cuantitativo en orina ";
                    }
                    if ($nombre_descripcion == "80309009"){
                        $nombre_descripcion = "Cálculo urinario (examen físico y químico)";
                    }
                    if ($nombre_descripcion == "80309010"){
                        $nombre_descripcion = "Creatinina cuantitativa en orina";
                    }
                    if ($nombre_descripcion == "80309011"){
                        $nombre_descripcion = "Cuerpos cetónicos";
                    }
                    if ($nombre_descripcion == "80309012"){
                        $nombre_descripcion = "Electrolitos (sodio, potasio, cloro) c/u en orina";
                    }
                    if ($nombre_descripcion == "80309013"){
                        $nombre_descripcion = "Microalbuminuria cuantitativa";
                    }
                    if ($nombre_descripcion == "80309014"){
                        $nombre_descripcion = "Embarazo, detección de (cualquier técnica)";
                    }
                    if ($nombre_descripcion == "80309040"){
                        $nombre_descripcion = "Fenilquetonuria (PKU), cuantitativo";
                    }
                    if ($nombre_descripcion == "80309015"){
                        $nombre_descripcion = "Fósforo cuantitativo en orina";
                    }
                    if ($nombre_descripcion == "80309016"){
                        $nombre_descripcion = "Glucosa (cuantitativo) en orina";
                    }
                    if ($nombre_descripcion == "80309035"){
                        $nombre_descripcion = "Hemosiderina";
                    }
                    if ($nombre_descripcion == "80309017"){
                        $nombre_descripcion = "Hidroxiprolina en orina";
                    }
                    if ($nombre_descripcion == "80309018"){
                        $nombre_descripcion = "Melanogenuria (test de cloruro férrico)";
                    }
                    if ($nombre_descripcion == "80309019"){
                        $nombre_descripcion = "Mucopolisacáridos";
                    }
                    if ($nombre_descripcion == "80309020"){
                        $nombre_descripcion = "Nitrógeno ureico o urea en orina (cuantitativo)";
                    }
                    if ($nombre_descripcion == "80309021"){
                        $nombre_descripcion = "Nucleótidos cíclicos (CAMP, CGM, u otros) c/u";
                    }
                    if ($nombre_descripcion == "80309022"){
                        $nombre_descripcion = "Orina completa, (incluye cód. 03-09-023 y 03-09-024)";
                    }
                    if ($nombre_descripcion == "80309023"){
                        $nombre_descripcion = "Orina, físico-químico (aspecto, color, densidad, pH, proteínas, glucosa, cuerpos cetónicos, urobilinógeno, bilirrubina, hemoglobina y nitritos) todos o cada uno de los parámetros (proc. aut.)";
                    }
                    if ($nombre_descripcion == "80309024"){
                        $nombre_descripcion = "Orina, sedimento (proc. aut.)";
                    }
                    if ($nombre_descripcion == "80309025"){
                        $nombre_descripcion = "Osmolalidad";
                    }
                    if ($nombre_descripcion == "80309027"){
                        $nombre_descripcion = "Porfirinas, c/u";
                    }
                    if ($nombre_descripcion == "80309028"){
                        $nombre_descripcion = "Proteína (cuantitativa) en orina";
                    }
                    if ($nombre_descripcion == "80309029"){
                        $nombre_descripcion = "Proteínas de Bence-Jones prueba térmica";
                    }
                    ?>
                <tr>
                    <td align='left'><?php echo substr($row->codigo_prestacion, 1); ?></td>
                    <td align='left'><?php echo $nombre_descripcion; ?></td>
                    <td align='right'><?php echo number_format($row->Col01,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col02,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col03,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col04,0,",",".")?></td>
                    <?php
                    $i++;
                }
                ?>
                <tr>
                    <td></td>
                    <td align='center'><strong>TOTAL</strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol01g,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol02g,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol03g,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol04g,0,",",".") ?></strong></td>
                </tr>

                <tr>
                    <td></td>
                    <td align='center'><strong>TOTAL EXÁMENES</strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol01a+$totalCol01b+$totalCol01c+$totalCol01d+$totalCol01e+$totalCol01f+$totalCol01g,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol02a+$totalCol02b+$totalCol02c+$totalCol02d+$totalCol02e+$totalCol02f+$totalCol02g,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol03a+$totalCol03b+$totalCol03c+$totalCol03d+$totalCol03e+$totalCol03f+$totalCol03g,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol04a+$totalCol04b+$totalCol04c+$totalCol04d+$totalCol04e+$totalCol04f+$totalCol04g,0,",",".") ?></strong></td>
                </tr>

                <tr>
                    <td></td>
                    <td align="center"><strong>EXÁMENES RADIOLÓGICOS</strong></td>
                    <td colspan="4"></td>
                </tr>
                <?php
                $query = 'SELECT a.codigo_prestacion,a.descripcion
                              ,sum(ifnull(b.Col01,0)) Col01
                              ,sum(ifnull(b.Col02,0)) Col02
                              ,sum(ifnull(b.Col03,0)) Col03
                              ,sum(ifnull(b.Col04,0)) Col04
                          FROM (select c.* from 2020prestaciones c where c.codigo_prestacion in("80401001","80401002","80401003","80401004","80401005","80401006","80401007","80401008",
                                                                                                "80401009","80401070","80401010","80401110","80401130","80401011","80401012","80401013",
                                                                                                "80401014","80401015","80401016","80401017","80401018","80401019","80401020","80401021",
                                                                                                "80401022","80401023","80401024","80401026","80401027","80401028","80401029","80401030",
                                                                                                "80401031","80401032","80401033","80401034","80401035","80401036","80401037","80401038",
                                                                                                "80401039","80401040","80401041","80401042","80401043","80401044","80401045","80401046",
                                                                                                "80401047","80401048","80401049","80401051","80401151","80401052","80401053","80401054",
                                                                                                "80401055","80401056","80401057","80401058","80401059","80401060","80401061","80401062",
                                                                                                "80401063","80401064","80404002","80404003","80404004","80404005","80404006","80404007",
                                                                                                "80404008","80404009","80404010","80404011","80404012","80404013","80404014","80404015",
                                                                                                "80404016","80404018","80404019")) a
                          left join 2020rems b on (a.id_prestacion=b.prestacion_id_prestacion)
                          AND (b.Mes in ('.$mes.')) AND (b.establecimiento_id_establecimiento in ('.$estab.'))
                          group by  a.codigo_prestacion,a.descripcion,a.id_prestacion
                          order by a.id_prestacion';
                $registro = DB::connection('mysql_rem')->select($query);

                $i=0;

                foreach($registro as $row ){
                    $nombre_descripcion = $row->codigo_prestacion;

                    if ($nombre_descripcion == "80401001"){
                        $nombre_descripcion = "Radiografía de las glándulas salivales ''sialografía''";
                    }
                    if ($nombre_descripcion == "80401002"){
                        $nombre_descripcion = "Radiografía de partes blandas, laringe lateral, cavum rinofaríngeo (rinofarinx).";
                    }
                    if ($nombre_descripcion == "80401003"){
                        $nombre_descripcion = "Planigrafías laringe  (4 EXP.)";
                    }
                    if ($nombre_descripcion == "80401004"){
                        $nombre_descripcion = "Radiografía de tórax, proyección complementaria (oblicuas, selectivas u otras)";
                    }
                    if ($nombre_descripcion == "80401005"){
                        $nombre_descripcion = "Tórax, proyección complementaria de corazón (oblicuas u otras) (1 exp.) c/u";
                    }
                    if ($nombre_descripcion == "80401006"){
                        $nombre_descripcion = "Estudio radiológico de corazón (incluye fluoroscopía, telerradiografías frontal y lateral con esofagograma)";
                    }
                    if ($nombre_descripcion == "80401007"){
                        $nombre_descripcion = "Planigrafia localizada (incluye mínimo 6 cortes) (6 exp.)";
                    }
                    if ($nombre_descripcion == "80401008"){
                        $nombre_descripcion = "Radiografía de tórax  frontal o lateral con equipo móvil fuera del departamento de rayos.";
                    }
                    if ($nombre_descripcion == "80401009"){
                        $nombre_descripcion = "Radiografía de tórax simple frontal o lateral";
                    }
                    if ($nombre_descripcion == "80401070"){
                        $nombre_descripcion = "Radiografía de tórax frontal y lateral";
                    }
                    if ($nombre_descripcion == "80401010"){
                        $nombre_descripcion = "Mamografía bilateral";
                    }
                    if ($nombre_descripcion == "80401110"){
                        $nombre_descripcion = "Mamografía unilateral";
                    }
                    if ($nombre_descripcion == "80401130"){
                        $nombre_descripcion = "Mamografía proyección complementaria  (axilar u otras)";
                    }
                    if ($nombre_descripcion == "80401011"){
                        $nombre_descripcion = "Marcación preoperatoria de lesiones de la mama";
                    }
                    if ($nombre_descripcion == "80401012"){
                        $nombre_descripcion = "Radiografía de mama, pieza operatoria";
                    }
                    if ($nombre_descripcion == "80401013"){
                        $nombre_descripcion = "Radiografía de Abdomen Simple";
                    }
                    if ($nombre_descripcion == "80401014"){
                        $nombre_descripcion = "Radiografía de abdomen simple, proyección complementaria (lateral y/o oblicua)";
                    }
                    if ($nombre_descripcion == "80401015"){
                        $nombre_descripcion = "Colangiografía intra o postoperatoria (por sonda T, o similar)";
                    }
                    if ($nombre_descripcion == "80401016"){
                        $nombre_descripcion = "Colangiografía medica con planigrafía (6 exp.)";
                    }
                    if ($nombre_descripcion == "80401017"){
                        $nombre_descripcion = "Colecistografía c/s seriografía (34 exp.)";
                    }
                    if ($nombre_descripcion == "80401018"){
                        $nombre_descripcion = "Enema baritado del colon (incluye llene y control post-vaciamiento)";
                    }
                    if ($nombre_descripcion == "80401019"){
                        $nombre_descripcion = "Enema baritado del colon o intestino delgado, doble contraste";
                    }
                    if ($nombre_descripcion == "80401020"){
                        $nombre_descripcion = "Esofagograma  (incluye pesquisa de cuerpo extraño) (proc.aut.)";
                    }
                    if ($nombre_descripcion == "80401021"){
                        $nombre_descripcion = "Radiografía de esófago, estómago y duodeno, relleno y/o doble contraste";
                    }
                    if ($nombre_descripcion == "80401022"){
                        $nombre_descripcion = "Estudio radiológico de deglución faríngea";
                    }
                    if ($nombre_descripcion == "80401023"){
                        $nombre_descripcion = "Estudio radiológico del intestino delgado";
                    }
                    if ($nombre_descripcion == "80401024"){
                        $nombre_descripcion = "Radiografía de esófago, estómago y duodeno, simple en niños";
                    }
                    if ($nombre_descripcion == "80401026"){
                        $nombre_descripcion = "Pielografía de eliminación con control minutado (10 exp.)";
                    }
                    if ($nombre_descripcion == "80401027"){
                        $nombre_descripcion = "Pielografía de eliminación o descendente: incluye renal y vesical simples previas, 3 placas post inyección de medio de contraste, controles de pie y cistografía pre y post miccional.";
                    }
                    if ($nombre_descripcion == "80401028"){
                        $nombre_descripcion = "Radiografía renal simple (proc. aut.)";
                    }
                    if ($nombre_descripcion == "80401029"){
                        $nombre_descripcion = "Radiografía vesical simple o perivesical (proc. aut.)";
                    }
                    if ($nombre_descripcion == "80401030"){
                        $nombre_descripcion = "Radiografía agujeros ópticos, ambos lados";
                    }
                    if ($nombre_descripcion == "80401031"){
                        $nombre_descripcion = "Radiografía de cavidades perinasales, órbitas, articulaciones temporomandibulares, huesos propios de la nariz, malar, maxilar, arco cigomático y cara";
                    }
                    if ($nombre_descripcion == "80401032"){
                        $nombre_descripcion = "Radiografía de cráneo frontal y lateral";
                    }
                    if ($nombre_descripcion == "80401033"){
                        $nombre_descripcion = "Radiografía de Cráneo  proyección especial de  base de cráneo (Towne)";
                    }
                    if ($nombre_descripcion == "80401034"){
                        $nombre_descripcion = "Radiografía de globo ocular, estudio de cuerpo extraño";
                    }
                    if ($nombre_descripcion == "80401035"){
                        $nombre_descripcion = "Radiografía de oído, uno o ambos";
                    }
                    if ($nombre_descripcion == "80401036"){
                        $nombre_descripcion = "Radiografía de oído, uno o ambos (2 proy.) (2 exp.)";
                    }
                    if ($nombre_descripcion == "80401037"){
                        $nombre_descripcion = "Radiografía de oído, uno o ambos (3 proy.) (3 exp.)";
                    }
                    if ($nombre_descripcion == "80401038"){
                        $nombre_descripcion = "Planigrafía de oidos (68 exp.)";
                    }
                    if ($nombre_descripcion == "80401039"){
                        $nombre_descripcion = "Planigrafía silla turca, canal optico, cavidades perinasales, c/u (68 exp.)";
                    }
                    if ($nombre_descripcion == "80401040"){
                        $nombre_descripcion = "Radiografía de silla turca frontal y lateral";
                    }
                    if ($nombre_descripcion == "80401041"){
                        $nombre_descripcion = " Planigrafía localizada (cervical, dorsal o lumbosacra) (68 exp.)";
                    }
                    if ($nombre_descripcion == "80401042"){
                        $nombre_descripcion = "Radiografía de columna cervical o atlas-axis (frontal y lateral)";
                    }
                    if ($nombre_descripcion == "80401043"){
                        $nombre_descripcion = "Radiografía de columna cervical (frontal, lateral y oblicuas)";
                    }
                    if ($nombre_descripcion == "80401044"){
                        $nombre_descripcion = "Radiografía de columna cervical  flexión y  extensión (Dinámicas)";
                    }
                    if ($nombre_descripcion == "80401045"){
                        $nombre_descripcion = "Radiografía de columna dorsal o dorsolumbar localizada, parrilla costal adultos (frontal y lateral).";
                    }
                    if ($nombre_descripcion == "80401046"){
                        $nombre_descripcion = "Radiografía columna lumbar o lumbosacra";
                    }
                    if ($nombre_descripcion == "80401047"){
                        $nombre_descripcion = "Radiografía columna lumbar o lumbosacra  flexión y  extensión (Dinámicas)";
                    }
                    if ($nombre_descripcion == "80401048"){
                        $nombre_descripcion = "Radiografía columna lumbar o lumbosacra, oblicuas adicionales";
                    }
                    if ($nombre_descripcion == "80401049"){
                        $nombre_descripcion = "Radiografía de columna total, panorámica con folio graduado  frontal o lateral";
                    }
                    if ($nombre_descripcion == "80401051"){
                        $nombre_descripcion = "Radiografía de pelvis, cadera o coxofemoral";
                    }
                    if ($nombre_descripcion == "80401151"){
                        $nombre_descripcion = "Radiografía de pelvis, cadera o coxofemoral de RN, lactante o niño menor de 6 años.";
                    }
                    if ($nombre_descripcion == "80401052"){
                        $nombre_descripcion = "Radiografía de pelvis, cadera o coxofemoral, proyecciones especiales; (rotación interna, abducción, lateral, Lawenstein u otras)";
                    }
                    if ($nombre_descripcion == "80401053"){
                        $nombre_descripcion = "Radiografía de Sacrocoxis o articulaciones sacroilíacas.";
                    }
                    if ($nombre_descripcion == "80401054"){
                        $nombre_descripcion = "Radiografía de brazo, antebrazo, codo, muñeca, mano, dedos, pie  (frontal y lateral)";
                    }
                    if ($nombre_descripcion == "80401055"){
                        $nombre_descripcion = "Radiografía de clavícula.";
                    }
                    if ($nombre_descripcion == "80401056"){
                        $nombre_descripcion = "Radiografía Edad Ósea: carpo y mano";
                    }
                    if ($nombre_descripcion == "80401057"){
                        $nombre_descripcion = "Radiografía Edad ósea : rodilla frontal";
                    }
                    if ($nombre_descripcion == "80401058"){
                        $nombre_descripcion = "Estudio radiológico de escafoides";
                    }
                    if ($nombre_descripcion == "80401059"){
                        $nombre_descripcion = "Estudio radiológico de muñeca o tobillo frontal lateral y oblicuas";
                    }
                    if ($nombre_descripcion == "80401060"){
                        $nombre_descripcion = "Radiografía de hombro, fémur, rodilla, pierna, costilla o esternón Frontal y Lateral";
                    }
                    if ($nombre_descripcion == "80401061"){
                        $nombre_descripcion = "Planigrafía ósea frontal y/o lateral (6 exp.)";
                    }
                    if ($nombre_descripcion == "80401062"){
                        $nombre_descripcion = "Radiografía de Proyecciones especiales oblicuas u otras en hombro, brazo, codo, rodilla, rótulas, sesamoideos, axial de ambas rótulas o similares";
                    }
                    if ($nombre_descripcion == "80401063"){
                        $nombre_descripcion = "Radiografía de túnel intercondíleo o radio-carpiano";
                    }
                    if ($nombre_descripcion == "80401064"){
                        $nombre_descripcion = "Apoyo fluoroscópico a procedimientos intraoperatorios y/o biopsia (no incluye el proc.)";
                    }
                    if ($nombre_descripcion == "80404002"){
                        $nombre_descripcion = "Ecografía obstétrica";
                    }
                    if ($nombre_descripcion == "80404003"){
                        $nombre_descripcion = "Ecografía abdominal (incluye hígado, vía biliar, vesícula, páncreas, riñones, bazo, retroperitoneo y grandes vasos)";
                    }
                    if ($nombre_descripcion == "80404004"){
                        $nombre_descripcion = "Ecografía como apoyo a cirugía, o a procedimiento (de tórax, muscular, partes blandas, etc.)";
                    }
                    if ($nombre_descripcion == "80404005"){
                        $nombre_descripcion = "Ecografía transvaginal o transrectal";
                    }
                    if ($nombre_descripcion == "80404006"){
                        $nombre_descripcion = "Ecografía ginecológica, pelviana femenina u obstétrica con estudio fetal";
                    }
                    if ($nombre_descripcion == "80404007"){
                        $nombre_descripcion = "Ecografía transvaginal para seguimiento de ovulación, procedimiento completo (6-8 sesiones)";
                    }
                    if ($nombre_descripcion == "80404008"){
                        $nombre_descripcion = "Ecografía para seguimiento de ovulación, procedimiento completo (6 a 8 sesiones)";
                    }
                    if ($nombre_descripcion == "80404009"){
                        $nombre_descripcion = "Ecografía pélvica masculina (incluye vejiga y próstata)";
                    }
                    if ($nombre_descripcion == "80404010"){
                        $nombre_descripcion = "Ecografía renal (bilateral), o de bazo";
                    }
                    if ($nombre_descripcion == "80404011"){
                        $nombre_descripcion = "Ecografía encefálica (RN o lactante)";
                    }
                    if ($nombre_descripcion == "80404012"){
                        $nombre_descripcion = "Ecografía mamaria bilateral (incluye Doppler)";
                    }
                    if ($nombre_descripcion == "80404013"){
                        $nombre_descripcion = "Ecografía ocular, uno o ambos ojos.";
                    }
                    if ($nombre_descripcion == "80404014"){
                        $nombre_descripcion = "Ecografía testicular (uno o ambos) (Incluye Doppler)";
                    }
                    if ($nombre_descripcion == "80404015"){
                        $nombre_descripcion = "Ecografía tiroidea (Incluye Doppler)";
                    }
                    if ($nombre_descripcion == "80404016"){
                        $nombre_descripcion = "Ecografía vascular periférica, articular o de partes blandas";
                    }
                    if ($nombre_descripcion == "80404018"){
                        $nombre_descripcion = "Ecotomografía vascular periférica (bilateral), cervical (bilateral), abdominal o de otros órganos con doppler duplex";
                    }
                    if ($nombre_descripcion == "80404019"){
                        $nombre_descripcion = "Ecotomografía vascular periférica (bilateral), cervical (bilateral), abdominal o de otros órganos con doppler color";
                    }
                    ?>
                <tr>
                    <td align='left'><?php echo substr($row->codigo_prestacion, 1); ?></td>
                    <td align='left'><?php echo $nombre_descripcion; ?></td>
                    <td align='right'><?php echo number_format($row->Col01,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col02,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col03,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col04,0,",",".")?></td>
                    <?php
                    $i++;
                }
                ?>
            </tbody>
        </table>
    </div>

    <!-- SECCION B -->
    <div class="col-sm tab table-responsive" id="B">
        <table class="table table-hover table-bordered table-sm">
            <thead>
              <tr>
                  <td colspan="8" class="active"><strong>SECCIÓN B: PROCEDIMIENTOS APOYO CLÍNICO Y TERAPÉUTICO.</strong></td>
              </tr>
              <tr>
                  <td rowspan="2" style="text-align:center; vertical-align:middle"><strong>CÓDIGOS</strong></td>
                  <td rowspan="2" style="text-align:center; vertical-align:middle"><strong>PROCEDIMIENTOS</strong></td>
                  <td rowspan="2" style="text-align:center; vertical-align:middle"><strong>TOTAL</strong></td>
                  <td rowspan="2" style="text-align:center; vertical-align:middle"><strong>SAPU/SAR/SUR</strong></td>
                  <td rowspan="2" style="text-align:center; vertical-align:middle"><strong>NO SAPU/ NO SUR</strong></td>
                  <td colspan="2" align="center"><strong>FUNCIONARIO</strong></td>
                  <td rowspan="2" style="text-align:center; vertical-align:middle"><strong>COMPRAS DE SERVICIOS</strong></td>
              </tr>
              <tr>
                  <td align="center"><strong>MÉDICO</strong></td>
                  <td align="center"><strong>OTRO</strong></td>
              </tr>
            </thead>
            <tbody>
                <tr>
                    <td></td>
                    <td align="center"><strong>NEUROLOGÍA</strong></td>
                    <td colspan="6"></td>
                </tr>
                <?php
                $query = 'SELECT a.codigo_prestacion,a.descripcion
                              ,sum(ifnull(b.Col01,0)) Col01
                              ,sum(ifnull(b.Col02,0)) Col02
                              ,sum(ifnull(b.Col03,0)) Col03
                              ,sum(ifnull(b.Col04,0)) Col04
                              ,sum(ifnull(b.Col05,0)) Col05
                              ,sum(ifnull(b.Col06,0)) Col06
                          FROM (select c.* from 2020prestaciones c where c.codigo_prestacion in("81101003")) a
                          left join 2020rems b on (a.id_prestacion=b.prestacion_id_prestacion)
                          AND (b.Mes in ('.$mes.')) AND (b.establecimiento_id_establecimiento in ('.$estab.'))
                          group by  a.codigo_prestacion,a.descripcion,a.id_prestacion
                          order by a.id_prestacion';
                $registro = DB::connection('mysql_rem')->select($query);

                $i=0;

                foreach($registro as $row ){
                    $nombre_descripcion = $row->codigo_prestacion;

                    if ($nombre_descripcion == "81101003"){
                        $nombre_descripcion = "Lumbar c/s manometria c/s queckensted";
                    }
                    ?>
                <tr>
                    <td align='left'><?php echo substr($row->codigo_prestacion, 1); ?></td>
                    <td align='left'><?php echo $nombre_descripcion; ?></td>
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
                <tr>
                    <td></td>
                    <td align="center"><strong>OFTALMOLOGÍA</strong></td>
                    <td colspan="6"></td>
                </tr>
                <?php
                $query = 'SELECT a.codigo_prestacion,a.descripcion
                              ,sum(ifnull(b.Col01,0)) Col01
                              ,sum(ifnull(b.Col02,0)) Col02
                              ,sum(ifnull(b.Col03,0)) Col03
                              ,sum(ifnull(b.Col04,0)) Col04
                              ,sum(ifnull(b.Col05,0)) Col05
                              ,sum(ifnull(b.Col06,0)) Col06
                          FROM (select c.* from 2020prestaciones c where c.codigo_prestacion in("81201003","81201004","81201005","81201009","81201012","81201014","81201015","81201019",
                                                                                                "81201029","81201042","81201042A")) a
                          left join 2020rems b on (a.id_prestacion=b.prestacion_id_prestacion)
                          AND (b.Mes in ('.$mes.')) AND (b.establecimiento_id_establecimiento in ('.$estab.'))
                          group by  a.codigo_prestacion,a.descripcion,a.id_prestacion
                          order by a.id_prestacion';
                $registro = DB::connection('mysql_rem')->select($query);

                $totalCol02=0;
                $totalCol01=0;
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

                    if ($nombre_descripcion == "81201003"){
                        $nombre_descripcion = "cuantificacion de lagrimacion (test de   schirmer),  uno o";
                    }
                    if ($nombre_descripcion == "81201004"){
                        $nombre_descripcion = "curva de tension aplanatica (por cada dia), c/ojo";
                    }
                    if ($nombre_descripcion == "81201005"){
                        $nombre_descripcion = "diploscopia cuantitativa, ambos ojos";
                    }
                    if ($nombre_descripcion == "81201009"){
                        $nombre_descripcion = "exploracion sensoriomotora: estrabismo, estudio completo ,";
                    }
                    if ($nombre_descripcion == "81201012"){
                        $nombre_descripcion = "retinografia, ambos ojos";
                    }
                    if ($nombre_descripcion == "81201014"){
                        $nombre_descripcion = "tonometria ocular, cualquier tecnica, c/ojo";
                    }
                    if ($nombre_descripcion == "81201015"){
                        $nombre_descripcion = "tratamiento ortoptico y/ o pleoptico (por sesion) ,";
                    }
                    if ($nombre_descripcion == "81201019"){
                        $nombre_descripcion = "Exploracion vitreorretinal, ambos ojos";
                    }
                    if ($nombre_descripcion == "81201029"){
                        $nombre_descripcion = "Cuerpo extrano conjuntival y/o corneal en adultos";
                    }
                    if ($nombre_descripcion == "81201042"){
                        $nombre_descripcion = "Campimetría computarizada, c/ojo (excluye UAPO)";
                    }

                    if ($nombre_descripcion == "81201042A"){
                        $nombre_descripcion = "Campimetría computarizada, c/ojo (en UAPO)";
                    }
                    ?>
                <tr>
                    <td align='left'><?php echo substr($row->codigo_prestacion, 1); ?></td>
                    <td align='left'><?php echo $nombre_descripcion; ?></td>
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
                <tr>
                    <td></td>
                    <td align='center'><strong>TOTAL</strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol01,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol02,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol03,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol04,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol05,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol06,0,",",".") ?></strong></td>
                </tr>
                <tr>
                    <td></td>
                    <td align="center"><strong>OTORRINOLARINGOLOGÍA</strong></td>
                    <td colspan="6"></td>
                </tr>
                <?php
                $query = 'SELECT a.codigo_prestacion,a.descripcion
                              ,sum(ifnull(b.Col01,0)) Col01
                              ,sum(ifnull(b.Col02,0)) Col02
                              ,sum(ifnull(b.Col03,0)) Col03
                              ,sum(ifnull(b.Col04,0)) Col04
                              ,sum(ifnull(b.Col05,0)) Col05
                              ,sum(ifnull(b.Col06,0)) Col06
                          FROM (select c.* from 2020prestaciones c where c.codigo_prestacion in("81301025","81301026","81301029","81301030","81301042","81301043")) a
                          left join 2020rems b on (a.id_prestacion=b.prestacion_id_prestacion)
                          AND (b.Mes in ('.$mes.')) AND (b.establecimiento_id_establecimiento in ('.$estab.'))
                          group by  a.codigo_prestacion,a.descripcion,a.id_prestacion
                          order by a.id_prestacion';
                $registro = DB::connection('mysql_rem')->select($query);

                $totalCol02=0;
                $totalCol01=0;
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

                    if ($nombre_descripcion == "81301025"){
                        $nombre_descripcion = "Taponamiento nasal anterior (proc. aut.)";
                    }
                    if ($nombre_descripcion == "81301026"){
                        $nombre_descripcion = "Taponamiento nasal posterior";
                    }
                    if ($nombre_descripcion == "81301029"){
                        $nombre_descripcion = "Cuerpo extraño en fosas nasales, extraccion en adultos";
                    }
                    if ($nombre_descripcion == "81301030"){
                        $nombre_descripcion = "Cuerpo extraño en fosas nasales, extraccion en niños";
                    }
                    if ($nombre_descripcion == "81301042"){
                        $nombre_descripcion = "Trompa de eustaquio, insuflacion instrumental (proc. Aut.) en adultos";
                    }
                    if ($nombre_descripcion == "81301043"){
                        $nombre_descripcion = "Trompa de eustaquio, insuflacion instrumental (proc. Aut.) en ninos";
                    }
                    ?>
                <tr>
                    <td align='left'><?php echo substr($row->codigo_prestacion, 1); ?></td>
                    <td align='left'><?php echo $nombre_descripcion; ?></td>
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
                <tr>
                    <td></td>
                    <td align='center'><strong>TOTAL</strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol01,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol02,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol03,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol04,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol05,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol06,0,",",".") ?></strong></td>
                </tr>
                <tr>
                    <td></td>
                    <td align="center"><strong>DERMATOLOGÍA Y TEGUMENTOS</strong></td>
                    <td colspan="6"></td>
                </tr>
                <?php
                $query = 'SELECT a.codigo_prestacion,a.descripcion
                              ,sum(ifnull(b.Col01,0)) Col01
                              ,sum(ifnull(b.Col02,0)) Col02
                              ,sum(ifnull(b.Col03,0)) Col03
                              ,sum(ifnull(b.Col04,0)) Col04
                              ,sum(ifnull(b.Col05,0)) Col05
                              ,sum(ifnull(b.Col06,0)) Col06
                          FROM (select c.* from 2020prestaciones c where c.codigo_prestacion in("81601110","81601115")) a
                          left join 2020rems b on (a.id_prestacion=b.prestacion_id_prestacion)
                          AND (b.Mes in ('.$mes.')) AND (b.establecimiento_id_establecimiento in ('.$estab.'))
                          group by  a.codigo_prestacion,a.descripcion,a.id_prestacion
                          order by a.id_prestacion';
                $registro = DB::connection('mysql_rem')->select($query);

                $totalCol02=0;
                $totalCol01=0;
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

                    if ($nombre_descripcion == "81601110"){
                        $nombre_descripcion = "Curetaje de lesiones virales o similares hasta 10 lesiones";
                    }
                    if ($nombre_descripcion == "81601115"){
                        $nombre_descripcion = "Implantes Subcutáneos, instalación o retiro";
                    }
                    ?>
                <tr>
                    <td align='left'><?php echo substr($row->codigo_prestacion, 1); ?></td>
                    <td align='left'><?php echo $nombre_descripcion; ?></td>
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
                <tr>
                    <td></td>
                    <td align='center'><strong>TOTAL</strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol01,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol02,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol03,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol04,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol05,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol06,0,",",".") ?></strong></td>
                </tr>
                <tr>
                    <td></td>
                    <td align="center"><strong>CARDIOLOGÍA</strong></td>
                    <td colspan="6"></td>
                </tr>
                <?php
                $query = 'SELECT a.codigo_prestacion,a.descripcion
                              ,sum(ifnull(b.Col01,0)) Col01
                              ,sum(ifnull(b.Col02,0)) Col02
                              ,sum(ifnull(b.Col03,0)) Col03
                              ,sum(ifnull(b.Col04,0)) Col04
                              ,sum(ifnull(b.Col05,0)) Col05
                              ,sum(ifnull(b.Col06,0)) Col06
                          FROM (select c.* from 2020prestaciones c where c.codigo_prestacion in("81701001","81701006","81701009")) a
                          left join 2020rems b on (a.id_prestacion=b.prestacion_id_prestacion)
                          AND (b.Mes in ('.$mes.')) AND (b.establecimiento_id_establecimiento in ('.$estab.'))
                          group by  a.codigo_prestacion,a.descripcion,a.id_prestacion
                          order by a.id_prestacion';
                $registro = DB::connection('mysql_rem')->select($query);

                $totalCol02=0;
                $totalCol01=0;
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

                    if ($nombre_descripcion == "81701001"){
                        $nombre_descripcion = "Electrocardiograma";
                    }
                    if ($nombre_descripcion == "81701006"){
                        $nombre_descripcion = "E.C.G. Continuo (test holter o similares, por ej. variabilidad de la frecuencia cardiaca y/o alta resolución  del st y/o despolarización tardía);20 a 24 horas de registro   ";
                    }
                    if ($nombre_descripcion == "81701009"){
                        $nombre_descripcion = "Monitoreo continuo de presión arterial";
                    }
                    ?>
                <tr>
                    <td align='left'><?php echo substr($row->codigo_prestacion, 1); ?></td>
                    <td align='left'><?php echo $nombre_descripcion; ?></td>
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
                <tr>
                    <td></td>
                    <td align='center'><strong>TOTAL</strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol01,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol02,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol03,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol04,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol05,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol06,0,",",".") ?></strong></td>
                </tr>
                <tr>
                    <td></td>
                    <td align="center"><strong>NEUMOLOGÍA</strong></td>
                    <td colspan="6"></td>
                </tr>
                <?php
                $query = 'SELECT a.codigo_prestacion,a.descripcion
                              ,sum(ifnull(b.Col01,0)) Col01
                              ,sum(ifnull(b.Col02,0)) Col02
                              ,sum(ifnull(b.Col03,0)) Col03
                              ,sum(ifnull(b.Col04,0)) Col04
                              ,sum(ifnull(b.Col05,0)) Col05
                              ,sum(ifnull(b.Col06,0)) Col06
                          FROM (select c.* from 2020prestaciones c where c.codigo_prestacion in("81707001","81707002","81707004","81707030")) a
                          left join 2020rems b on (a.id_prestacion=b.prestacion_id_prestacion)
                          AND (b.Mes in ('.$mes.')) AND (b.establecimiento_id_establecimiento in ('.$estab.'))
                          group by  a.codigo_prestacion,a.descripcion,a.id_prestacion
                          order by a.id_prestacion';
                $registro = DB::connection('mysql_rem')->select($query);

                $totalCol02=0;
                $totalCol01=0;
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

                    if ($nombre_descripcion == "81707001"){
                        $nombre_descripcion = "Espirometría Basal";
                    }
                    if ($nombre_descripcion == "81707002"){
                        $nombre_descripcion = "Espirometria basal y con broncodilatador";
                    }
                    if ($nombre_descripcion == "81707004"){
                        $nombre_descripcion = "Test de provocacion con ejercicio";
                    }
                    if ($nombre_descripcion == "81707030"){
                        $nombre_descripcion = "Aerosolterapia (Nebulización)";
                    }

                    ?>
                <tr>
                    <td align='left'><?php echo substr($row->codigo_prestacion, 1); ?></td>
                    <td align='left'><?php echo $nombre_descripcion; ?></td>
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
                <tr>
                    <td></td>
                    <td align='center'><strong>TOTAL</strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol01,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol02,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol03,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol04,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol05,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol06,0,",",".") ?></strong></td>
                </tr>
                <tr>
                    <td></td>
                    <td align="center"><strong>GASTROENTEROLOGÍA</strong></td>
                    <td colspan="6"></td>
                </tr>
                <?php
                $query = 'SELECT a.codigo_prestacion,a.descripcion
                              ,sum(ifnull(b.Col01,0)) Col01
                              ,sum(ifnull(b.Col02,0)) Col02
                              ,sum(ifnull(b.Col03,0)) Col03
                              ,sum(ifnull(b.Col04,0)) Col04
                              ,sum(ifnull(b.Col05,0)) Col05
                              ,sum(ifnull(b.Col06,0)) Col06
                          FROM (select c.* from 2020prestaciones c where c.codigo_prestacion in("81801023","81801042","81801001")) a
                          left join 2020rems b on (a.id_prestacion=b.prestacion_id_prestacion)
                          AND (b.Mes in ('.$mes.')) AND (b.establecimiento_id_establecimiento in ('.$estab.'))
                          group by  a.codigo_prestacion,a.descripcion,a.id_prestacion
                          order by a.id_prestacion';
                $registro = DB::connection('mysql_rem')->select($query);

                $totalCol02=0;
                $totalCol01=0;
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

                    if ($nombre_descripcion == "81801023"){
                        $nombre_descripcion = "Intubacion con sonda gastrica";
                    }
                    if ($nombre_descripcion == "81801042"){
                        $nombre_descripcion = "Vaciamiento manual de fecaloma";
                    }
                    if ($nombre_descripcion == "81801001"){
                        $nombre_descripcion = "Gastroduodenoscopía (incluye esofagoscopía)";
                    }
                    ?>
                <tr>
                    <td align='left'><?php echo substr($row->codigo_prestacion, 1); ?></td>
                    <td align='left'><?php echo $nombre_descripcion; ?></td>
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
                <tr>
                    <td></td>
                    <td align='center'><strong>TOTAL</strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol01,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol02,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol03,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol04,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol05,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol06,0,",",".") ?></strong></td>
                </tr>
                <tr>
                    <td></td>
                    <td align="center"><strong>UROLOGÍA</strong></td>
                    <td colspan="6"></td>
                </tr>
                <?php
                $query = 'SELECT a.codigo_prestacion,a.descripcion
                              ,sum(ifnull(b.Col01,0)) Col01
                              ,sum(ifnull(b.Col02,0)) Col02
                              ,sum(ifnull(b.Col03,0)) Col03
                              ,sum(ifnull(b.Col04,0)) Col04
                              ,sum(ifnull(b.Col05,0)) Col05
                              ,sum(ifnull(b.Col06,0)) Col06
                          FROM (select c.* from 2020prestaciones c where c.codigo_prestacion in("81901019","81901022")) a
                          left join 2020rems b on (a.id_prestacion=b.prestacion_id_prestacion)
                          AND (b.Mes in ('.$mes.')) AND (b.establecimiento_id_establecimiento in ('.$estab.'))
                          group by  a.codigo_prestacion,a.descripcion,a.id_prestacion
                          order by a.id_prestacion';
                $registro = DB::connection('mysql_rem')->select($query);

                $totalCol02=0;
                $totalCol01=0;
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

                    if ($nombre_descripcion == "81901019"){
                        $nombre_descripcion = "Instilacion vesical (incluye colocacion de sonda) proc. Aut.";
                    }
                    if ($nombre_descripcion == "81901022"){
                        $nombre_descripcion = "Vac. Vesical por sonda uretral, (proc. Aut.)   ";
                    }
                    ?>
                <tr>
                    <td align='left'><?php echo substr($row->codigo_prestacion, 1); ?></td>
                    <td align='left'><?php echo $nombre_descripcion; ?></td>
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
                <tr>
                    <td></td>
                    <td align='center'><strong>TOTAL</strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol01,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol02,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol03,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol04,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol05,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol06,0,",",".") ?></strong></td>
                </tr>
                <tr>
                    <td></td>
                    <td align="center"><strong>GINECOLOGÍA</strong></td>
                    <td colspan="6"></td>
                </tr>
                <?php
                $query = 'SELECT a.codigo_prestacion,a.descripcion
                              ,sum(ifnull(b.Col01,0)) Col01
                              ,sum(ifnull(b.Col02,0)) Col02
                              ,sum(ifnull(b.Col03,0)) Col03
                              ,sum(ifnull(b.Col04,0)) Col04
                              ,sum(ifnull(b.Col05,0)) Col05
                              ,sum(ifnull(b.Col06,0)) Col06
                          FROM (select c.* from 2020prestaciones c where c.codigo_prestacion in("82001015")) a
                          left join 2020rems b on (a.id_prestacion=b.prestacion_id_prestacion)
                          AND (b.Mes in ('.$mes.')) AND (b.establecimiento_id_establecimiento in ('.$estab.'))
                          group by  a.codigo_prestacion,a.descripcion,a.id_prestacion
                          order by a.id_prestacion';
                $registro = DB::connection('mysql_rem')->select($query);

                foreach($registro as $row ){

                    $nombre_descripcion = $row->codigo_prestacion;

                    if ($nombre_descripcion == "82001015"){
                        $nombre_descripcion = "Colocación o extracción de dispositivo intrauterino (no incluye el valor del dispositivo)";
                    }
                    ?>
                <tr>
                    <td align='left'><?php echo substr($row->codigo_prestacion, 1); ?></td>
                    <td align='left'><?php echo $nombre_descripcion; ?></td>
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
                <tr>
                    <td></td>
                    <td align="center"><strong>ORTOPEDIA Y TRAUMATOLOGÍA</strong></td>
                    <td colspan="6"></td>
                </tr>
                <?php
                $query = 'SELECT a.codigo_prestacion,a.descripcion
                              ,sum(ifnull(b.Col01,0)) Col01
                              ,sum(ifnull(b.Col02,0)) Col02
                              ,sum(ifnull(b.Col03,0)) Col03
                              ,sum(ifnull(b.Col04,0)) Col04
                              ,sum(ifnull(b.Col05,0)) Col05
                              ,sum(ifnull(b.Col06,0)) Col06
                          FROM (select c.* from 2020prestaciones c where c.codigo_prestacion in("82101001","82101002","82106005","82106007","82106006","82106004","82107003")) a
                          left join 2020rems b on (a.id_prestacion=b.prestacion_id_prestacion)
                          AND (b.Mes in ('.$mes.')) AND (b.establecimiento_id_establecimiento in ('.$estab.'))
                          group by  a.codigo_prestacion,a.descripcion,a.id_prestacion
                          order by a.id_prestacion';
                $registro = DB::connection('mysql_rem')->select($query);

                $totalCol02=0;
                $totalCol01=0;
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

                    if ($nombre_descripcion == "82101001"){
                        $nombre_descripcion = "Infiltracion local medicamentos (bursas, tendones, yuxtaarticulares y/o intraarticulares";
                    }
                    if ($nombre_descripcion == "82101002"){
                        $nombre_descripcion = "Procedimiento para exploraciones radiologicas (incluye maniobra e inyeccion del medio de contraste)  BM18A  Revisar en BM Colocación valva";
                    }
                    if ($nombre_descripcion == "82106005"){
                        $nombre_descripcion = "Rodillera, bota larga o corta de yeso";
                    }
                    if ($nombre_descripcion == "82106007"){
                        $nombre_descripcion = "Velpeau";
                    }
                    if ($nombre_descripcion == "82106006"){
                        $nombre_descripcion = "Yeso antebraquial c/s ferula digital";
                    }
                    if ($nombre_descripcion == "82106004"){
                        $nombre_descripcion = "Yeso braquicarpiano";
                    }
                    if ($nombre_descripcion == "82107003"){
                        $nombre_descripcion = "Luxaciones de articulaciones menores (el resto)";
                    }
                    ?>
                <tr>
                    <td align='left'><?php echo substr($row->codigo_prestacion, 1); ?></td>
                    <td align='left'><?php echo $nombre_descripcion; ?></td>
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
                <tr>
                    <td></td>
                    <td align='center'><strong>TOTAL</strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol01,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol02,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol03,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol04,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol05,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol06,0,",",".") ?></strong></td>
                </tr>
                <tr>
                    <td></td>
                    <td align="center"><strong> SECCIÓN C: INTERVENCIONES QUIRÚRGICAS MENORES</strong></td>
                    <td colspan="6"></td>
                </tr>
                <?php
                $query = 'SELECT a.codigo_prestacion,a.descripcion
                              ,sum(ifnull(b.Col01,0)) Col01
                              ,sum(ifnull(b.Col02,0)) Col02
                              ,sum(ifnull(b.Col03,0)) Col03
                              ,sum(ifnull(b.Col04,0)) Col04
                              ,sum(ifnull(b.Col05,0)) Col05
                              ,sum(ifnull(b.Col06,0)) Col06
                          FROM (select c.* from 2020prestaciones c where c.codigo_prestacion in("81602201","81602202","81602203","81602204","81602205","81602206","81602207","81602211",
                                                                                                "81602212","81602213","81602214","81602215","81602216","81602221","81602222","81602217",
                                                                                                "81602224","81602225","81602231","81602232","81602223","81602240","81602241","81602242")) a
                          left join 2020rems b on (a.id_prestacion=b.prestacion_id_prestacion)
                          AND (b.Mes in ('.$mes.')) AND (b.establecimiento_id_establecimiento in ('.$estab.'))
                          group by  a.codigo_prestacion,a.descripcion,a.id_prestacion
                          order by a.id_prestacion';
                $registro = DB::connection('mysql_rem')->select($query);

                $totalCol02=0;
                $totalCol01=0;
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

                    if ($nombre_descripcion == "81602201"){
                        $nombre_descripcion = "Biopsia de piel y/o mucosa por curetaje o sección tangencial c/s electro x 1 sesion";
                    }
                    if ($nombre_descripcion == "81602202"){
                        $nombre_descripcion = "Extirpacion de, reparacion o biopsia total o parcial, de lesiones benignas cutáneas por excision cabeza, cuello, genitales, hasta 3 lesiones";
                    }
                    if ($nombre_descripcion == "81602203"){
                        $nombre_descripcion = "Extirpacion de, reparacion o biopsia total o parcial, de lesiones benignas cutáneas por excision resto de cuerpo hasta 3 lesiones";
                    }
                    if ($nombre_descripcion == "81602204"){
                        $nombre_descripcion = "Extirpacion de, reparacion o biopsia total o parcial, de lesiones benignas cutáneas por excision cabeza, cuello, genitales, desde 4 hasta 6 lesiones";
                    }
                    if ($nombre_descripcion == "81602205"){
                        $nombre_descripcion = "Extirpacion de, reparacion o biopsia total o parcial, de lesiones benignas cutáneas por excision resto de cuerpo desde 4 hasta 6 lesiones";
                    }
                    if ($nombre_descripcion == "81602206"){
                        $nombre_descripcion = "Extirpacion de lesiones benignas por sec tangencial ,curetaje,y/o fulguracion hasta 15 lesiones";
                    }
                    if ($nombre_descripcion == "81602207"){
                        $nombre_descripcion = "Tratamiento por electro de hemangiomas o telangectasias hasta 15 lesiones";
                    }
                    if ($nombre_descripcion == "81602211"){
                        $nombre_descripcion = "Cabeza, cuello, genitales: tratamiento quirúrgico de tumor maligno por escisión total o parcial, con o sin sutura, por cada lesión o melanoma cualquier localización";
                    }
                    if ($nombre_descripcion == "81602212"){
                        $nombre_descripcion = "Resto del cuerpo: tratamiento quirúrgico de tumor maligno por escisión total o parcial, con o sin sutura, por cada lesión";
                    }
                    if ($nombre_descripcion == "81602213"){
                        $nombre_descripcion = "Cabeza, cuello, genitales o melanoma cualquier ubicación: ampliación de márgenes quirúrgicos de tumor maligno extirpado previamente";
                    }
                  	if ($nombre_descripcion == "81602214"){
                        $nombre_descripcion = "Resto del cuerpo: ampliación de márgenes quirúrgicos de tumor maligno extirpado prevíamente";
                    }
                    if ($nombre_descripcion == "81602215"){
                        $nombre_descripcion = "Tumores vasculares profundos cara, cuero cabelludo, cuello, genitales";
                    }
                    if ($nombre_descripcion == "81602216"){
                        $nombre_descripcion = "Tumores vasculares profundos resto del cuerpo";
                    }
                    if ($nombre_descripcion == "81602221"){
                        $nombre_descripcion = "Herida cortante o contusa complicada, reparación y sutura (más de 5 cm)";
                    }
                    if ($nombre_descripcion == "81602222"){
                        $nombre_descripcion = "Herida cortante o contusa NO complicada, reparacion y sutura (una o multiples de mas de 5 cms de largo total y/o que comprometa solo piel)";
                    }
                    if ($nombre_descripcion == "81602217"){
                        $nombre_descripcion = "Cabeza, cuello, genitales: extirpación de lesión benigna subepidérmica, incluye tumor sólido, quiste epidérmico y lipoma por lesión";
                    }
                    if ($nombre_descripcion == "81602224"){
                        $nombre_descripcion = "Resto del cuerpo: extirpación de lesión benigna subepidérmica, incluye tumor sólido, quiste epidérmico y lipoma por lesión";
                    }
                    if ($nombre_descripcion == "81602225"){
                        $nombre_descripcion = "Vaciamiento y curetaje quirurgico de lesiones quistica o abscesos";
                    }
                    if ($nombre_descripcion == "81602231"){
                        $nombre_descripcion = "Onisectomia total o parcial simple";
                    }
                    if ($nombre_descripcion == "81602232"){
                        $nombre_descripcion = "Cirugia reparadora ungueal por proceso inflamatorio";
                    }
                    if ($nombre_descripcion == "81602223"){
                        $nombre_descripcion = "Correccion quirurgica de defecto congenito o por tumor ungueal";
                    }
                    if ($nombre_descripcion == "81602240"){
                        $nombre_descripcion = "Curacion por medico, quemadura o similar menor al 5% superficie corporal en pabellon";
                    }
                    if ($nombre_descripcion == "81602241"){
                        $nombre_descripcion = "Curacion por medico, quemadura o similar  5 a 10% superficie corporal en pabellon";
                    }
                    if ($nombre_descripcion == "81602242"){
                        $nombre_descripcion = "Curacion por medico, quemadura o similar  mayor  al 10% superficie corporal en pabellon";
                    }
                    ?>
                <tr>
                    <td align='left'><?php echo substr($row->codigo_prestacion, 1); ?></td>
                    <td align='left'><?php echo $nombre_descripcion; ?></td>
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
                <tr>
                    <td></td>
                    <td align='center'><strong>TOTAL</strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol01,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol02,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol03,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol04,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol05,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol06,0,",",".") ?></strong></td>
                </tr>
                <tr>
                    <td></td>
                    <td align="center"><strong>SECCIÓN D: MISCELÁNEOS</strong></td>
                    <td colspan="6"></td>
                </tr>
                <?php
                $query = 'SELECT a.codigo_prestacion,a.descripcion
                              ,sum(ifnull(b.Col01,0)) Col01
                              ,sum(ifnull(b.Col02,0)) Col02
                              ,sum(ifnull(b.Col03,0)) Col03
                              ,sum(ifnull(b.Col04,0)) Col04
                              ,sum(ifnull(b.Col05,0)) Col05
                              ,sum(ifnull(b.Col06,0)) Col06
                          FROM (select c.* from 2020prestaciones c where c.codigo_prestacion in("80106002","80106005","80106006","80106017","80106007","80106008","80106009","80106010",
                                                                                                "80106011","80106012","80106013","80106014","80106015","80106020","80106021","80106022",
                                                                                                "80106023")) a
                          left join 2020rems b on (a.id_prestacion=b.prestacion_id_prestacion)
                          AND (b.Mes in ('.$mes.')) AND (b.establecimiento_id_establecimiento in ('.$estab.'))
                          group by  a.codigo_prestacion,a.descripcion,a.id_prestacion
                          order by a.id_prestacion';
                $registro = DB::connection('mysql_rem')->select($query);

                $totalCol02=0;
                $totalCol01=0;
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

                    if ($nombre_descripcion == "80106002"){
                        $nombre_descripcion = "Curación simple ambulatoria";
                    }
                    if ($nombre_descripcion == "80106005"){
                        $nombre_descripcion = "Autocontrol pacientes Diabetico insulino dependiente (D.I.D. mensual)";
                    }
                    if ($nombre_descripcion == "80106006"){
                        $nombre_descripcion = "Oxigenoterapia domiciliaria (pacientes oxígeno dependientes)";
                    }
                    if ($nombre_descripcion == "80106017"){
                        $nombre_descripcion = "Curación compleja";
                    }
                    if ($nombre_descripcion == "80106007"){
                        $nombre_descripcion = "Extracción cuerpo extraño ojo";
                    }
                    if ($nombre_descripcion == "80106008"){
                        $nombre_descripcion = "Extracción cuerpo extraño otro lugar";
                    }
                    if ($nombre_descripcion == "80106009"){
                        $nombre_descripcion = "Lavado gástrico";
                    }
                    if ($nombre_descripcion == "80106010"){
                        $nombre_descripcion = "Lavado oído";
                    }
                    if ($nombre_descripcion == "80106011"){
                        $nombre_descripcion = "Técnicas reanimación cardiopulmonar básico";
                    }
                    if ($nombre_descripcion == "80106012"){
                        $nombre_descripcion = "Técnicas reanimación cardiopulmonar avanzado";
                    }
                    if ($nombre_descripcion == "80106013"){
                        $nombre_descripcion = "Aseo ocular";
                    }
                    if ($nombre_descripcion == "80106014"){
                        $nombre_descripcion = "Administración inyecciones";
                    }
                    if ($nombre_descripcion == "80106015"){
                        $nombre_descripcion = "Administración fleboclisis";
                    }
                    if ($nombre_descripcion == "80106020"){
                        $nombre_descripcion = "Administración oxigeno";
                    }
                    if ($nombre_descripcion == "80106021"){
                        $nombre_descripcion = "Aspiración secreciones";
                    }
                    if ($nombre_descripcion == "80106022"){
                        $nombre_descripcion = "Instalación sonda";
                    }
                    if ($nombre_descripcion == "80106023"){
                        $nombre_descripcion = "Procedimientos de podología";
                    }
                    ?>
                <tr>
                    <td align='left'><?php echo substr($row->codigo_prestacion, 1); ?></td>
                    <td align='left'><?php echo $nombre_descripcion; ?></td>
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
                <tr>
                    <td></td>
                    <td align='center'><strong>TOTAL</strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol01,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol02,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol03,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol04,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol05,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol06,0,",",".") ?></strong></td>
                </tr>
                <tr>
                    <td align='center'><strong>CÓDIGOS</strong></td>
                    <td align='center'><strong>OTROS PROCEDIMIENTOS</strong></td>
                    <td align='center'><strong>TOTAL</strong></td>
                    <td align='center'><strong>SAPU/SAR/SUR</strong></td>
                    <td align='center'><strong>NO SAPU/ NO SUR</strong></td>
                    <td align='center'><strong>COMPRAS DE SERVICIOS</strong></td>
                </tr>
                <?php
                $query = 'SELECT a.codigo_prestacion,a.descripcion
                              ,sum(ifnull(b.Col01,0)) Col01
                              ,sum(ifnull(b.Col02,0)) Col02
                              ,sum(ifnull(b.Col03,0)) Col03
                              ,sum(ifnull(b.Col04,0)) Col04
                          FROM (select c.* from 2020prestaciones c where c.codigo_prestacion in("80307011","80307012")) a
                          left join 2020rems b on (a.id_prestacion=b.prestacion_id_prestacion)
                          AND (b.Mes in ('.$mes.')) AND (b.establecimiento_id_establecimiento in ('.$estab.'))
                          group by  a.codigo_prestacion,a.descripcion,a.id_prestacion
                          order by a.id_prestacion';
                $registro = DB::connection('mysql_rem')->select($query);

                $totalCol02=0;
                $totalCol01=0;
                $totalCol03=0;
                $totalCol04=0;

                foreach($registro as $row ){
                    $totalCol01=$totalCol01+$row->Col01;
                    $totalCol02=$totalCol02+$row->Col02;
                    $totalCol03=$totalCol03+$row->Col03;
                    $totalCol04=$totalCol04+$row->Col04;

                    $nombre_descripcion = $row->codigo_prestacion;

                    if ($nombre_descripcion == "80307011"){
                        $nombre_descripcion = "Toma de muestra de sangre venosa en adultos";
                    }
                    if ($nombre_descripcion == "80307012"){
                        $nombre_descripcion = "Toma de muestra de sangre venosa en niños y lactantes";
                    }
                    ?>
                <tr>
                    <td align='left'><?php echo substr($row->codigo_prestacion, 1); ?></td>
                    <td align='left'><?php echo $nombre_descripcion; ?></td>
                    <td align='right'><?php echo number_format($row->Col01,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col02,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col03,0,",",".")?></td>
                    <td align='right'><?php echo number_format($row->Col04,0,",",".")?></td>
                    <?php
                    $i++;
                }
                ?>
                <tr>
                    <td></td>
                    <td align='center'><strong>TOTAL</strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol01,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol02,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol03,0,",",".") ?></strong></td>
                    <td align='right'><strong><?php echo number_format($totalCol04,0,",",".") ?></strong></td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- SECCION E -->
    <div class="col-sm tab table-responsive" id="E">
        <table class="table table-hover table-bordered table-sm">
            <thead>
              <tr>
                  <td colspan="8" class="active"><strong>SECCIÓN E: OTROS EXÁMENES Y PROCEDIMIENTOS  DE APOYO CLÍNICO Y TERAPEUTICO (SIN CÓDIGO EN ARANCEL).</strong></td>
              </tr>
              <tr>
                  <td rowspan="2" style="text-align:center; vertical-align:middle"><strong>CÓDIGOS</strong></td>
                  <td rowspan="2" style="text-align:center; vertical-align:middle"><strong>PROCEDIMIENTOS</strong></td>
                  <td rowspan="2" style="text-align:center; vertical-align:middle"><strong>TOTAL</strong></td>
                  <td rowspan="2" style="text-align:center; vertical-align:middle"><strong>SAPU/SAR/SUR</strong></td>
                  <td rowspan="2" style="text-align:center; vertical-align:middle"><strong>NO SAPU/ NO SUR</strong></td>
                  <td colspan="2" align="center"><strong>FUNCIONARIO</strong></td>
                  <td rowspan="2" style="text-align:center; vertical-align:middle"><strong>COMPRAS DE SERVICIOS</strong></td>
              </tr>
              <tr>
                  <td align="center"><strong>MÉDICO</strong></td>
                  <td align="center"><strong>OTRO</strong></td>
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
                          FROM (select c.* from 2020prestaciones c where c.codigo_prestacion in("80500001","80500002","80500003","80500004","80500005","80500006","80500007","80500008",
                                                                                                "80500009","80500010","80500011","80500014","80500016","80500017")) a
                          left join 2020rems b on (a.id_prestacion=b.prestacion_id_prestacion)
                          AND (b.Mes in ('.$mes.')) AND (b.establecimiento_id_establecimiento in ('.$estab.'))
                          group by  a.codigo_prestacion,a.descripcion,a.id_prestacion
                          order by a.id_prestacion';
                $registro = DB::connection('mysql_rem')->select($query);

                $totalCol02=0;
                $totalCol01=0;
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

                    if ($nombre_descripcion == "80500001"){
                        $nombre_descripcion = "Toma agudeza visual (ambos ojos)";
                    }
                    if ($nombre_descripcion == "80500002"){
                        $nombre_descripcion = "Autorrefractomia";
                    }
                    if ($nombre_descripcion == "80500003"){
                        $nombre_descripcion = "Lensometria";
                    }
                    if ($nombre_descripcion == "80500004"){
                        $nombre_descripcion = "Paquimetria Ultrasónica";
                    }
                    if ($nombre_descripcion == "80500005"){
                        $nombre_descripcion = "Paquimetria óptica";
                    }
                    if ($nombre_descripcion == "80500006"){
                        $nombre_descripcion = "Tomografía coherencia óptica";
                    }
                    if ($nombre_descripcion == "80500007"){
                        $nombre_descripcion = "Inyeccion intravitrea avastin";
                    }
                    if ($nombre_descripcion == "80500008"){
                        $nombre_descripcion = "Insercion Implante Anticonceptivo";
                    }
                    if ($nombre_descripcion == "80500009"){
                        $nombre_descripcion = "Remocion Implante Anticonceptivo";
                    }
                    if ($nombre_descripcion == "80500010"){
                        $nombre_descripcion = "Insercion Pellets subcutáneo";
                    }
                    if ($nombre_descripcion == "80500011"){
                        $nombre_descripcion = "Hemoglocotest instantaneo";
                    }
                    if ($nombre_descripcion == "80500014"){
                        $nombre_descripcion = "Radiografía de pelvis, cadera o coxofemoral de 1er screening  (entre 3 -6 meses)";
                    }
                    if ($nombre_descripcion == "80500016"){
                        $nombre_descripcion = "Cartridge para Troponina";
                    }
                    if ($nombre_descripcion == "80500017"){
                        $nombre_descripcion = "Cartridge Multiple";
                    }
                    ?>
                <tr>
                    <td align='left'><?php echo substr($row->codigo_prestacion, 1); ?></td>
                    <td align='left'><?php echo $nombre_descripcion; ?></td>
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
                <tr>
                    <td></td>
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
