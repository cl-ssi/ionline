<?php
namespace App\Http\Controllers\Indicators\_2019;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\Indicators\SingleParameter;


$year= 2019;
$meses = array(1,2,3,4,5,6,7,8,9,10,11,12);



/********** META 1.4. **********/
/* ==== Inicializar variables ==== */
$data14_hosp = array();

$data14_hosp['label']['meta'] = '1.4. Porcentaje de cumplimiento de programación de
    consultas de profesionales no médicos de establecimientos
    hospitalarios de alta complejidad.';
$data14_hosp['label']['numerador'] = 'Total, de número de consultas de profesionales
    no médicos realizadas.';
$data14_hosp['label']['denominador'] = 'Total, de número de consultas de profesionales
    no médicos programadas.';


$data14_hosp['label']['fuente']['numerador'] = 'REM';
$data14_hosp['label']['fuente']['denominador'] = 'Programación Anual';



$data14_hosp['meta'] = '≥95%';
$data14_hosp['ponderacion'] = '10%';
$data14_hosp['cumplimiento'] = 0;
$data14_hosp['numerador_acumulado'] = 0;

$base_where = array(['law','18834'],['year',$year],['indicator',14],['establishment_id',1],['position','denominador']);
$value = SingleParameter::where(array_merge($base_where))->first();
if($value) $data14_hosp['denominador'] = $value->value;
else       $data14_hosp['denominador'] = null;


foreach($meses as $mes) {
    $data14_hosp['numeradores'][$mes] = 0;
}

/* ===== Query numerador ===== */
$sql_numerador = "SELECT e.alias_estab, r.Mes, sum(ifnull(Col01,0)) AS numerador
    FROM {$year}rems r
    LEFT JOIN establecimientos e
    ON r.IdEstablecimiento=e.Codigo
    WHERE e.meta_san_18834_hosp = 1
    AND CodigoPrestacion IN (07024900, 07024915, 07024925, 07024935, 07024920, 07024816, 07024607, 07024817, 07024809, 07024705, 07024506,
                              07024930, 07024940, 070251200, 070251300, 070251400, '07030100A', 07030200, 07030300, 07030400, 07024950, 07024960,
                              28021230, 28021240, 28021250, 28021260, 28021270,
                              28021280, 28021290, 28021300, 28021310,
                              28021320, 28021330, 28021340, 28021350)
    GROUP by e.Comuna, e.alias_estab, r.Mes
    ORDER BY e.Comuna, e.alias_estab, r.Mes";

$numeradores = DB::connection('mysql_rem')->select($sql_numerador);

/* Asigna los valores al mes y calcula el acumulado */
foreach($numeradores as $registro) {
    $data14_hosp['numeradores'][$registro->Mes] = $registro->numerador;
    $data14_hosp['numerador_acumulado'] += $registro->numerador;
}

/* Calculo del cumplimiento */
if($data14_hosp['denominador'] == 0) {
    /* Si es 0 el denominador entonces el cumplimiento es 0 */
    $data14_hosp['cumplimiento'] = 0;
}
else {
    /* De lo contrario calcular el porcentaje */
    $data14_hosp['cumplimiento'] =
        $data14_hosp['numerador_acumulado'] /
        $data14_hosp['denominador'] * 100;
}


if( $data14_hosp['cumplimiento'] >= preg_replace("/[^0-9]/", '', $data14_hosp['meta'])) {
    $data14_hosp['aporte'] = preg_replace("/[^0-9]/", '', $data14_hosp['ponderacion']);
}
else {
    $data14_hosp['aporte'] = $data14_hosp['cumplimiento'] *  preg_replace("/[^0-9]/", '', $data14_hosp['ponderacion']) / 100;
}


/********** META 1.5. **********/
$data15_hosp = array();

$data15_hosp['label']['meta'] = '1.5. Porcentaje de categorización de Urgencia a
    través de ESI en las UEH.';
$data15_hosp['label']['numerador'] = 'Número de pacientes categorizados según
    herramienta ESI en Unidad de Emergencia Hospitalaria,
    en establecimientos de alta y mediana complejidad.';
$data15_hosp['label']['denominador'] = 'Total de pacientes con consultas de Urgencia
    realizadas en Unidades de Emergencia Hospitalaria (UEH) de
    establecimientos de alta y mediana complejidad.';

$data15_hosp['label']['fuente']['numerador'] = 'REM';
$data15_hosp['label']['fuente']['denominador'] = 'REM';

$data15_hosp['meta'] = '≥90%';
$data15_hosp['ponderacion'] = '10%';
$data15_hosp['numerador_acumulado'] = 0;
$data15_hosp['denominador_acumulado'] = 0;

foreach($meses as $mes) {
    $data15_hosp['numeradores'][$mes] = 0;
    $data15_hosp['denominadores'][$mes] = 0;
}

// $sql_establecimientos ='SELECT dependencia, alias_estab
//                       FROM establecimientos
//                       WHERE meta_san_18834_hosp = 1
//                       ORDER BY comuna';
//
// $establecimientos = DB::connection('mysql_rem')->select($sql_establecimientos);




/* ===== Query numerador ===== */
$sql_numerador = "SELECT e.alias_estab, r.Mes, sum(ifnull(Col39,0)) as numerador
    FROM {$year}rems r
    LEFT JOIN establecimientos e
    ON r.IdEstablecimiento=e.Codigo
    WHERE e.meta_san_18834_hosp = 1
    AND CodigoPrestacion IN (08180201, 08180202, 08180203, 08180204, 08222610)
    GROUP by e.Comuna, e.alias_estab, r.Mes
    ORDER BY e.Comuna, e.alias_estab, r.Mes";
$numeradores = DB::connection('mysql_rem')->select($sql_numerador);

foreach($numeradores as $registro) {
    $data15_hosp['numeradores'][$registro->Mes] = $registro->numerador;
    $data15_hosp['numerador_acumulado'] += $registro->numerador;
}

/* ===== Query denominador ===== */
$sql_denominador =
   "SELECT e.alias_estab, r.Mes, sum(ifnull(Col01,0)) as denominador
    FROM {$year}rems r
    LEFT JOIN establecimientos e
    ON r.IdEstablecimiento=e.Codigo
    WHERE CodigoPrestacion IN (08180201, 08180202, 08180203, 08180204, 08222610, 08180205)
    AND e.meta_san_18834_hosp = 1
    GROUP BY e.Comuna, e.alias_estab, r.Mes
    ORDER BY e.Comuna, e.alias_estab, r.Mes";
$denominadores = DB::connection('mysql_rem')->select($sql_denominador);

foreach($denominadores as $registro) {
    $data15_hosp['denominadores'][$registro->Mes] = $registro->denominador;
    $data15_hosp['denominador_acumulado'] += $registro->denominador;
}

/* ==== Calculos ==== */
/* Calculo de las metas de la comuna */
if($data15_hosp['denominador_acumulado'] == 0) {
    /* Si es 0 el denominadore entonces el cumplimiento es 0 */
    $data15_hosp['cumplimiento'] = 0;
}
else {
    /* De lo contrario calcular el porcentaje */
    $data15_hosp['cumplimiento'] =
        $data15_hosp['numerador_acumulado'] /
        $data15_hosp['denominador_acumulado'] * 100;
}
//dd($data15_hosp);

if( $data15_hosp['cumplimiento'] >= preg_replace("/[^0-9]/", '', $data15_hosp['meta'])) {
    $data15_hosp['aporte'] = preg_replace("/[^0-9]/", '', $data15_hosp['ponderacion']);
}
else {
    $data15_hosp['aporte'] = $data15_hosp['cumplimiento'] *  preg_replace("/[^0-9]/", '', $data15_hosp['ponderacion']) / 100;
}





/********** META 1.6. **********/
$data16_hosp['label']['meta'] = '1.6. Porcentaje de categorización de pacientes en
    niveles de riesgo dependencia.';
$data16_hosp['label']['numerador']   = 'Número DC Categorizados.';
$data16_hosp['label']['denominador'] = 'Número DC Ocupados en Camas que se
    Categorizan de Lunes a Domingo.';

$data16_hosp['label']['fuente']['numerador'] = 'Certificado Hospital';
$data16_hosp['label']['fuente']['denominador'] = 'Certificado Hospital';

$data16_hosp['meta'] = '≥95%';
$data16_hosp['ponderacion'] = '10%';

$base_where = array(['law','18834'],['year',$year],['indicator',16],['establishment_id',1],['position','numerador']);

for($i = 1; $i <= 12; $i++) {
    $value = SingleParameter::where(array_merge($base_where,array(['month',$i])))->first();
    if($value) $data16_hosp['numeradores'][$i] = $value->value;
    else       $data16_hosp['numeradores'][$i] = null;
}

$data16_hosp['numerador_acumulado'] = array_sum($data16_hosp['numeradores']);

$base_where = array(['law','18834'],['year',$year],['indicator',16],['establishment_id',1],['position','denominador']);

for($i = 1; $i <= 12; $i++) {
    $value = SingleParameter::where(array_merge($base_where,array(['month',$i])))->first();
    if($value) $data16_hosp['denominadores'][$i] = $value->value;
    else       $data16_hosp['denominadores'][$i] = null;
}

$data16_hosp['denominador_acumulado'] = array_sum($data16_hosp['denominadores']);

if($data16_hosp['denominador_acumulado'] != 0) {
    $data16_hosp['cumplimiento'] =
        $data16_hosp['numerador_acumulado'] / $data16_hosp['denominador_acumulado'] * 100;
}
else {
    $data16_hosp['cumplimiento'] = 0;
}

//dd($data16_hosp);

if( $data16_hosp['cumplimiento'] >= preg_replace("/[^0-9]/", '', $data16_hosp['meta'])) {
    $data16_hosp['aporte'] = preg_replace("/[^0-9]/", '', $data16_hosp['ponderacion']);
}
else {
    $data16_hosp['aporte'] = $data16_hosp['cumplimiento'] *  preg_replace("/[^0-9]/", '', $data16_hosp['ponderacion']) / 100;
}




/********** META 1.7. **********/
$data17_hosp['label']['meta'] = '1.7. Porcentaje de Gestión Efectiva para el
    Cumplimiento GES en la Red.';
$data17_hosp['label']['numerador'] = 'Garantías cumplidas + Garantías Exceptuadas +
    Garantías Incumplidas Atendidas.';
$data17_hosp['label']['denominador'] = '(Garantías Cumplidas + Garantías Exceptuadas +
    Garantías Incumplidas Atendidas + Garantías No Atendidas +
    Garantías Retrasadas) * 100.';

$data17_hosp['label']['fuente']['numerador'] = 'Datamart';
$data17_hosp['label']['fuente']['denominador'] = 'Datamart';

$data17_hosp['meta'] = '100%';
$data17_hosp['ponderacion'] = '10%';

$base_where = array(['law','18834'],['year',$year],['indicator',17],['establishment_id',1]);

for($i = 1; $i <= 12; $i++) {
    $where = array_merge($base_where,array(['month',$i],['position','numerador']));
    $value = SingleParameter::where($where)->first();
    if($value) $data17_hosp['numeradores'][$i] = $value->value;
    else       $data17_hosp['numeradores'][$i] = null;

    $where = array_merge($base_where,array(['month',$i],['position','denominador']));
    $value = SingleParameter::where($where)->first();
    if($value) $data17_hosp['denominadores'][$i] = $value->value;
    else       $data17_hosp['denominadores'][$i] = null;
}

$data17_hosp['numerador_acumulado']   = array_sum($data17_hosp['numeradores']);
$data17_hosp['denominador_acumulado'] = array_sum($data17_hosp['denominadores']);

if($data17_hosp['denominador_acumulado'] != 0) {
    $data17_hosp['cumplimiento'] = $data17_hosp['numerador_acumulado'] / $data17_hosp['denominador_acumulado'] * 100;
}
else $data17_hosp['cumplimiento'] = 0;


if( $data17_hosp['cumplimiento'] >= preg_replace("/[^0-9]/", '', $data17_hosp['meta'])) {
    $data17_hosp['aporte'] = preg_replace("/[^0-9]/", '', $data17_hosp['ponderacion']);
}
else {
    $data17_hosp['aporte'] = $data17_hosp['cumplimiento'] *  preg_replace("/[^0-9]/", '', $data17_hosp['ponderacion']) / 100;
}





/********** META 1.8. **********/
/* reporte a mes*/

$data18_hosp['label']['meta'] = '1.8. Porcentaje de pretaciones trazadoras
    de tratamiento GES otrogadas según lo programado de prestaciones
    trazadoras de tratamiento GES en contrato PPV para el año t.';
$data18_hosp['label']['numerador'] = 'Número de prestaciones trazadoras de
    tratamiento GES otorgadas dentro del año t.';
$data18_hosp['label']['denominador'] = 'N° de prestaciones trazadoras de
    tratamiento GES programadas en el contrato PPV para el año t.';


$data18_hosp['label']['fuente']['numerador'] = 'Plataforma SIGGES';
$data18_hosp['label']['fuente']['denominador'] = 'Programación Anual';


$data18_hosp['meta'] = '100%';
$data18_hosp['meta_umbral'] = '60%';
$data18_hosp['ponderacion'] = '10%';

$base_where = array(['law','18834'],['year',$year],['indicator',18],
                    ['establishment_id',1],['position','numerador']);

$value = SingleParameter::where($base_where)->first();

$data18_hosp['vigencia'] = $value->month;

if($value) {
    $data18_hosp['numerador_acumulado'] = $value->value;
    $data18_hosp['vigencia'] = $value->month;
}
else {
    $data18_hosp['numerador_acumulado'] = null;
    $data18_hosp['vigencia'] = 1;
}

$base_where = array(['law','18834'],['year',$year],['indicator',18],
                    ['establishment_id',1],['position','denominador']);

$value = SingleParameter::where($base_where)->first();

if($value) $data18_hosp['denominador_acumulado'] = $value->value;
else       $data18_hosp['denominador_acumulado'] = null;

if($data18_hosp['denominador_acumulado'] != 0) {
    $data18_hosp['cumplimiento'] = $data18_hosp['numerador_acumulado'] / $data18_hosp['denominador_acumulado'] * 100;
}
else $data18_hosp['cumplimiento'] = 0;


if( $data18_hosp['cumplimiento'] >= preg_replace("/[^0-9]/", '', $data18_hosp['meta_umbral'])) {
    //dd($data18_hosp);
    $data18_hosp['aporte'] = $data18_hosp['cumplimiento'] / 100 * preg_replace("/[^0-9]/", '', $data18_hosp['ponderacion']);
}
else {
    //$data18_hosp['aporte'] = $data18_hosp['cumplimiento'] *  preg_replace("/[^0-9]/", '', $data18_hosp['ponderacion']) / 100;
    $data18_hosp['aporte'] = 0;
}




/********** META 1.9. **********/
$data19_hosp = array();
$data19_hosp['label']['meta'] = '1.9. Variación porcentual de pacientes que
    esperan más de 12 horas en la Unidad de Emergencia Hospitalaria (UEH)
    para acceder a una cama de dotación.';
/*$data19_hosp['label']['numerador'] = '% de pacientes provenientes desde la UEH,
    que se hospitalizan después de 12 horas desde la indicación,
    en periodo t-2-% de pacientes provenientes desde la UEH, que se
    hospitalizan después de las 12 horas desde la indicación en periodo t.';*/
$data19_hosp['label']['numerador'] = '% de pacientes provenientes desde la UEH,
        que se hospitalizan después de 12 horas desde la indicación,
        en el año t.';
$data19_hosp['label']['denominador'] = '% de pacientes provenientes de la UEH, que
    se hospitalizan después de las 12 horas desde la indicación en el
    año t-2 * 100.';

$data19_hosp['label']['fuente']['numerador'] = 'REM';
$data19_hosp['label']['fuente']['denominador'] = 'Línea Base';


$data19_hosp['meta'] = '≥5%';
$data19_hosp['ponderacion'] = '10%';
$data19_hosp['cumplimiento'] = 0;
$data19_hosp['numerador'] = 0;
$data19_hosp['numerador_acumulado'] = 0;
$data19_hosp['numerador_acumulado_2'] = 0;
$data19_hosp['denominador_acumulado'] = 5;

/* ==== Inicializar en 0 el arreglo de datos $data ==== */
foreach($meses as $mes) {
    $data19_hosp['numeradores'][$mes] = 0;
    $data19_hosp['numeradores_2'][$mes] = 0;
    $data19_hosp['denominadores'][$mes] = 0;
}

/* ===== denominador ===== */
/* Primero los denominadores porque los uso para calcular el numerador
$data19_hosp['denominadores'] =  [1=>2.5, 2=>4.2, 3=>2.0,  4=>2.1,  5=>1.6,  6=>1.0,
                 7=>2.4, 8=>2.7, 9=>1.4, 10=>1.3, 11=>1.4, 12=>2.7];*/

/* ===== Query numerador ===== */
$sql_numerador = "SELECT e.servicio_salud, e.alias_estab, r.Mes, sum(ifnull(Col01,0)) as numerador
    FROM {$year}rems r
    LEFT JOIN establecimientos e
    ON r.IdEstablecimiento=e.Codigo
    WHERE CodigoPrestacion IN (08222640,08222650,08222660,08221600,08222670,08222680,'08230500A')
    AND e.meta_san_18834_hosp = 1
    GROUP BY e.servicio_salud, e.alias_estab, r.Mes
    ORDER BY e.servicio_salud, e.alias_estab, r.Mes";
$numeradores_totales = DB::connection('mysql_rem')->select($sql_numerador);

foreach($numeradores_totales as $registro) {
    $tmp[$registro->Mes]['totales'] = $registro->numerador;
}

$sql_numerador = "SELECT e.servicio_salud, e.alias_estab, r.Mes, sum(ifnull(Col01,0)) as numerador
    FROM {$year}rems r
    LEFT JOIN establecimientos e
    ON r.IdEstablecimiento=e.Codigo
    WHERE CodigoPrestacion IN (08222650,08222660)
    AND e.meta_san_18834_hosp = 1
    GROUP BY e.servicio_salud, e.alias_estab, r.Mes
    ORDER BY e.servicio_salud, e.alias_estab, r.Mes";
$numeradores = DB::connection('mysql_rem')->select($sql_numerador);

foreach($numeradores as $registro) {
    $tmp[$registro->Mes]['numerador'] = $registro->numerador;
}

foreach($tmp as $key => $mes){
    //$tmp[$key]['porcentaje'] = $mes['numerador'] / $mes['totales'] *  100 ;
    $data19_hosp['numeradores_2'][$key] += $mes['numerador'];
    $data19_hosp['numeradores'][$key] += $mes['totales'];
    $data19_hosp['numerador_acumulado'] += $data19_hosp['numeradores'][$key];
    $data19_hosp['numerador_acumulado_2'] += $data19_hosp['numeradores_2'][$key];
    //$data19_hosp['denominador_acumulado'] += $data19_hosp['denominadores'][$key];
}

/* ==== Calculos ==== */
if($data19_hosp['denominador_acumulado'] == 0) {
    /* Si es 0 el denominador entonces el cumplimiento es 0 */
    $data19_hosp['cumplimiento'] = 0;
}
else {
    /* De lo contrario calcular el porcentaje */
    $data19_hosp['numerador'] = $data19_hosp['numerador_acumulado_2'] / $data19_hosp['numerador_acumulado'] * 100;

    $data19_hosp['cumplimiento'] = round($data19_hosp['numerador'],1) / $data19_hosp['denominador_acumulado'] * 100;
    //dd($data19_hosp);
}

if( $data19_hosp['cumplimiento'] >= preg_replace("/[^0-9]/", '', $data19_hosp['meta'])) {
    $data19_hosp['aporte'] = preg_replace("/[^0-9]/", '', $data19_hosp['ponderacion']);
}
else {
    $data19_hosp['aporte'] = $data19_hosp['cumplimiento'] *  preg_replace("/[^0-9]/", '', $data19_hosp['ponderacion']) / 100;
}





/********** META 2.0 **********/
$data20_hosp = array();
$data20_hosp['label']['meta'] = '2.0. Porcentaje de egreso de maternidades con
    Lactancia Materna Exclusiva (LME).';
$data20_hosp['label']['numerador'] = 'N° de egresos de maternidad con LME.';
$data20_hosp['label']['denominador'] = 'N° total de egresos de maternidad.';


$data20_hosp['label']['fuente']['numerador'] = 'REM';
$data20_hosp['label']['fuente']['denominador'] = 'REM';

$data20_hosp['meta'] = '≥60%';
$data20_hosp['ponderacion'] = '20%';
$data20_hosp['cumplimiento'] = 0;
$data20_hosp['numerador_acumulado'] = 0;
$data20_hosp['denominador_acumulado'] = 0;

foreach($meses as $mes) {
    $data20_hosp['numeradores'][$mes] = 0;
    $data20_hosp['denominadores'][$mes] = 0;
}

/* ===== Query numerador ===== */
$sql_numerador = "SELECT e.servicio_salud, e.alias_estab, r.Mes, ifnull(Col01,0) as numerador
    FROM {$year}rems r
    LEFT JOIN establecimientos e
    ON r.IdEstablecimiento=e.Codigo
    WHERE CodigoPrestacion = 24200100 AND e.meta_san_18834_hosp = 1
    ORDER BY e.servicio_salud, e.alias_estab, r.Mes";
$numeradores = DB::connection('mysql_rem')->select($sql_numerador);

foreach($numeradores as $registro) {
    $data20_hosp['numeradores'][$registro->Mes] = $registro->numerador;
    $data20_hosp['numerador_acumulado'] += $registro->numerador;
}

/* ===== Query denominador ===== */
$sql_denominador = "SELECT e.servicio_salud, e.alias_estab, r.Mes, ifnull(Col01,0) as denominador
    FROM {$year}rems r
    LEFT JOIN establecimientos e
    ON r.IdEstablecimiento=e.Codigo
    WHERE CodigoPrestacion = 24200134 AND e.meta_san_18834_hosp = 1
    ORDER BY e.servicio_salud, e.alias_estab, r.Mes";
$denominadores = DB::connection('mysql_rem')->select($sql_denominador);

foreach($denominadores as $registro) {
    $data20_hosp['denominadores'][$registro->Mes] = $registro->denominador;
    $data20_hosp['denominador_acumulado'] += $registro->denominador;
}

/* Calculo de las metas de la comuna */
if($data20_hosp['denominador_acumulado'] == 0) {
    /* Si es 0 el denominadore entonces el cumplimiento es 0 */
    $data20_hosp['cumplimiento'] = 0;
}
else {
    /* De lo contrario calcular el porcentaje */
    $data20_hosp['cumplimiento'] =
        $data20_hosp['numerador_acumulado'] /
        $data20_hosp['denominador_acumulado'] * 100;
}


if( $data20_hosp['cumplimiento'] >= preg_replace("/[^0-9]/", '', $data20_hosp['meta'])) {
    $data20_hosp['aporte'] = preg_replace("/[^0-9]/", '', $data20_hosp['ponderacion']);
}
else {
    $data20_hosp['aporte'] = $data20_hosp['cumplimiento'] *  preg_replace("/[^0-9]/", '', $data20_hosp['ponderacion']) / 100;
}





/********** META 3.1 **********/
$data31_hosp['label']['meta'] = '3.1. Porcentajes de funcionarios regidos
    por el Estatuto Administrativo, capacitados durante el año en al
    menos una actividad pertinente, de los nueve ejes estratégicos de
    la Estrategia Nacional de Salud.';
$data31_hosp['label']['numerador']   = 'N° de funcionarios regidos por el EA
    capacitados durante el año 2019 en al menos una actividad de capacitación
    pertinente de los nueve Ejes de la Estrategia Nacional de Salud.';
$data31_hosp['label']['denominador'] = 'N° total de funcionarios de dotación,
    regidos por el EA.';


$data31_hosp['label']['fuente']['numerador'] = 'Reporte RRHH';
$data31_hosp['label']['fuente']['denominador'] = 'Reporte RRHH';

$data31_hosp['meta'] = '≥50%';
$data31_hosp['ponderacion'] = '20%';

$base_where = array(['law','18834'],['year',$year],['indicator',31],['establishment_id',1],['position','numerador']);
$value = SingleParameter::where($base_where)->first();
if($value) $data31_hosp['numerador_acumulado'] = $value->value;
else       $data31_hosp['numerador_acumulado'] = null;

$data31_hosp['vigencia'] = $value->month;

$base_where = array(['law','18834'],['year',$year],['indicator',31],['establishment_id',1],['position','denominador']);
$value = SingleParameter::where($base_where)->first();
if($value) $data31_hosp['denominador_acumulado'] = $value->value;
else       $data31_hosp['denominador_acumulado'] = null;


if($data31_hosp['denominador_acumulado'] != 0) {
    $data31_hosp['cumplimiento'] = $data31_hosp['numerador_acumulado'] / $data31_hosp['denominador_acumulado'] * 100;
}
else $data31_hosp['cumplimiento'] = 0;


if( $data31_hosp['cumplimiento'] >= preg_replace("/[^0-9]/", '', $data31_hosp['meta'])) {
    $data31_hosp['aporte'] = preg_replace("/[^0-9]/", '', $data31_hosp['ponderacion']);
}
else {
    $data31_hosp['aporte'] = $data31_hosp['cumplimiento'] *  preg_replace("/[^0-9]/", '', $data31_hosp['ponderacion']) / 100;
}

//echo '<pre>'; print_r($data); die();

?>
