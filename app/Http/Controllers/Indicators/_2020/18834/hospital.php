<?php
namespace App\Http\Controllers\Indicators\_2020;

use Illuminate\Support\Facades\DB;
use App\Models\Indicators\SingleParameter;

$year= 2020;
$meses = array(1,2,3,4,5,6,7,8,9,10,11,12);

/***********  META 1.5. ************/
/* ==== Inicializar variables ==== */
$data15_hosp = array();

$data15_hosp['label']['meta'] = '1.5. Porcentaje de cumplimiento de programación de
    consultas de profesionales no médicos de establecimientos
    hospitalarios de alta y mediana complejidad.';
$data15_hosp['label']['numerador'] = 'Número de consultas de profesionales
    no médicos realizadas.';
$data15_hosp['label']['denominador'] = 'Total de consultas de profesionales
    no médicos programadas y validadas * 100.';

$data15_hosp['label']['fuente']['numerador'] = 'REM';
$data15_hosp['label']['fuente']['denominador'] = 'Programacion Anual';

$data15_hosp['meta'] = '≥95%';
$data15_hosp['ponderacion'] = '15%';
$data15_hosp['cumplimiento'] = 0;
$data15_hosp['numerador_acumulado'] = 0;
$data15_hosp['denominador'] = 0;
foreach($meses as $mes) {
    $data15_hosp['numeradores'][$mes] = 0;
}

/* ===== Query numerador ===== */
$sql_numerador = "SELECT e.alias_estab, r.Mes, sum(ifnull(Col01,0)) AS numerador
    FROM {$year}rems r
    LEFT JOIN {$year}establecimientos e
    ON r.IdEstablecimiento=e.Codigo
    WHERE e.meta_san_18834_hosp = 1
    AND CodigoPrestacion IN (07024900, 07024915, 07024925, 07024935, 07024920, 07024816, 07024607, 07024705, 07024506)
    GROUP by e.Comuna, e.alias_estab, r.Mes
    ORDER BY e.Comuna, e.alias_estab, r.Mes";
$numeradores = DB::connection('mysql_rem')->select($sql_numerador);

/* Asigna los valores al mes y calcula el acumulado */
foreach($numeradores as $registro) {
    $data15_hosp['numeradores'][$registro->Mes] = $registro->numerador;
    $data15_hosp['numerador_acumulado'] += $registro->numerador;
}


$base_where = array(['law','18834'],['year',$year],['indicator',15],['establishment_id',1],['position','denominador']);
$value = SingleParameter::where($base_where)->first();
if($value) $data15_hosp['denominador'] = $value->value;
else       $data15_hosp['denominador'] = null;

/* Calculo del cumplimiento */
if($data15_hosp['denominador'] == 0) {
    /* Si es 0 el denominador entonces el cumplimiento es 0 */
    $data15_hosp['cumplimiento'] = 0;
}
else {
    /* De lo contrario calcular el porcentaje */
    $data15_hosp['cumplimiento'] =
        $data15_hosp['numerador_acumulado'] /
        $data15_hosp['denominador'] * 100;
}


if( $data15_hosp['cumplimiento'] >= preg_replace("/[^0-9]/", '', $data15_hosp['meta'])) {
    $data15_hosp['aporte'] = preg_replace("/[^0-9]/", '', $data15_hosp['ponderacion']);
}
else {
    $data15_hosp['aporte'] = $data15_hosp['cumplimiento'] *  preg_replace("/[^0-9]/", '', $data15_hosp['ponderacion']) / 100;
}

/********** META 1.6. **********/
$data16_hosp = array();

$data16_hosp['label']['meta'] = '1.6. Porcentaje de categorización de Urgencia a
    través de ESI en las UEH.';
$data16_hosp['label']['numerador'] = 'Número de pacientes categorizados según
    herramienta ESI en Unidad de Emergencia Hospitalaria,
    en establecimientos de alta y mediana complejidad en año t.';
$data16_hosp['label']['denominador'] = 'Total de pacientes con consultas de Urgencia
    realizadas en Unidades de Emergencia Hospitalaria (UEH) de
    establecimientos de alta y mediana complejidad en año t * 100.';

$data16_hosp['label']['fuente']['numerador'] = 'REM';
$data16_hosp['label']['fuente']['denominador'] = 'REM';

$data16_hosp['meta'] = '≥90%';
$data16_hosp['ponderacion'] = '10%';
$data16_hosp['numerador_acumulado'] = 0;
$data16_hosp['denominador_acumulado'] = 0;

foreach($meses as $mes) {
    $data16_hosp['numeradores'][$mes] = 0;
    $data16_hosp['denominadores'][$mes] = 0;
}

/* ===== Query numerador ===== */
$sql_numerador = "SELECT e.alias_estab, r.Mes, sum(ifnull(Col39,0)) as numerador
    FROM {$year}rems r
    LEFT JOIN {$year}establecimientos e
    ON r.IdEstablecimiento=e.Codigo
    WHERE e.meta_san_18834_hosp = 1
    AND CodigoPrestacion IN (08180201, 08180202, 08180203, 08180204, 08222610)
    GROUP by e.Comuna, e.alias_estab, r.Mes
    ORDER BY e.Comuna, e.alias_estab, r.Mes";
$numeradores = DB::connection('mysql_rem')->select($sql_numerador);

foreach($numeradores as $registro) {
    $data16_hosp['numeradores'][$registro->Mes] = $registro->numerador;
    $data16_hosp['numerador_acumulado'] += $registro->numerador;
}

/* ===== Query denominador ===== */
$sql_denominador =
   "SELECT e.alias_estab, r.Mes, sum(ifnull(Col01,0)) as denominador
    FROM {$year}rems r
    LEFT JOIN {$year}establecimientos e
    ON r.IdEstablecimiento=e.Codigo
    WHERE CodigoPrestacion IN (08180201, 08180202, 08180203, 08180204, 08222610, 08180205)
    AND e.meta_san_18834_hosp = 1
    GROUP BY e.Comuna, e.alias_estab, r.Mes
    ORDER BY e.Comuna, e.alias_estab, r.Mes";
$denominadores = DB::connection('mysql_rem')->select($sql_denominador);

foreach($denominadores as $registro) {
    $data16_hosp['denominadores'][$registro->Mes] = $registro->denominador;
    $data16_hosp['denominador_acumulado'] += $registro->denominador;
}

/* ==== Calculos ==== */
/* Calculo de las metas de la comuna */
if($data16_hosp['denominador_acumulado'] == 0) {
    /* Si es 0 el denominadore entonces el cumplimiento es 0 */
    $data16_hosp['cumplimiento'] = 0;
}
else {
    /* De lo contrario calcular el porcentaje */
    $data16_hosp['cumplimiento'] =
        $data16_hosp['numerador_acumulado'] /
        $data16_hosp['denominador_acumulado'] * 100;
}
//dd($data16_hosp);

if( $data16_hosp['cumplimiento'] >= preg_replace("/[^0-9]/", '', $data16_hosp['meta'])) {
    $data16_hosp['aporte'] = preg_replace("/[^0-9]/", '', $data16_hosp['ponderacion']);
}
else {
    $data16_hosp['aporte'] = $data16_hosp['cumplimiento'] *  preg_replace("/[^0-9]/", '', $data16_hosp['ponderacion']) / 100;
}

/********** META 1.7. **********/
$data17_hosp['label']['meta'] = '1.7. Porcentaje de categorización de pacientes en
    niveles de riesgo dependencia.';
$data17_hosp['label']['numerador']   = '(N° DC Categorizados de camas que se categorización
    de Lunes a Domingo) + (N° DC Categorizados en Camas que se Categorizan de Lunes
    a Viernes.';
$data17_hosp['label']['denominador'] = '(N° DC Ocupados en Camas que se Categorizan
    de Lunes a Domingo) + (N° DC Ocupados en Camas que se Categorizan de Lunes
    a viernes * 0.7) * 100.';

$data17_hosp['label']['fuente']['numerador'] = 'Certificado Hospital';
$data17_hosp['label']['fuente']['denominador'] = 'Certificado Hospital';

$data17_hosp['meta'] = '≥95%';
$data17_hosp['ponderacion'] = '10%';

$base_where = array(['law','18834'],['year',$year],['indicator',17],['establishment_id',1],['position','numerador']);

for($i = 1; $i <= 12; $i++) {
    $value = SingleParameter::where(array_merge($base_where,array(['month',$i])))->first();
    if($value) $data17_hosp['numeradores'][$i] = $value->value;
    else       $data17_hosp['numeradores'][$i] = null;
}

$data17_hosp['numerador_acumulado'] = array_sum($data17_hosp['numeradores']);

$base_where = array(['law','18834'],['year',$year],['indicator',17],['establishment_id',1],['position','denominador']);

for($i = 1; $i <= 12; $i++) {
    $value = SingleParameter::where(array_merge($base_where,array(['month',$i])))->first();
    if($value) $data17_hosp['denominadores'][$i] = $value->value;
    else       $data17_hosp['denominadores'][$i] = null;
}

$data17_hosp['denominador_acumulado'] = array_sum($data17_hosp['denominadores']);

if($data17_hosp['denominador_acumulado'] != 0) {
    $data17_hosp['cumplimiento'] =
        $data17_hosp['numerador_acumulado'] / $data17_hosp['denominador_acumulado'] * 100;
}
else {
    $data17_hosp['cumplimiento'] = 0;
}

if( $data17_hosp['cumplimiento'] >= preg_replace("/[^0-9]/", '', $data17_hosp['meta'])) {
    $data17_hosp['aporte'] = preg_replace("/[^0-9]/", '', $data17_hosp['ponderacion']);
}
else {
    $data17_hosp['aporte'] = $data17_hosp['cumplimiento'] *  preg_replace("/[^0-9]/", '', $data17_hosp['ponderacion']) / 100;
}

/***********  META 1.8. ************/
/* ==== Inicializar variables ==== */

$data18_hosp['label']['meta'] = '1.8. Porcentaje de Gestión Efectiva para el
    Cumplimiento GES en la Red.';
$data18_hosp['label']['numerador'] = 'Garantías cumplidas + Garantías Exceptuadas +
    Garantías Incumplidas Atendidas.';
$data18_hosp['label']['denominador'] = '(Garantías Cumplidas + Garantías Exceptuadas +
    Garantías Incumplidas Atendidas + Garantías Incumplidas No Atendidas +
    Garantías Retrasadas) * 100.';

$data18_hosp['label']['fuente']['numerador'] = 'Datamart';
$data18_hosp['label']['fuente']['denominador'] = 'Datamart';

$data18_hosp['meta'] = '99.5';
$data18_hosp['ponderacion'] = '10%';

$base_where = array(['law','18834'],['year',$year],['indicator',18],['establishment_id',1]);

for($i = 1; $i <= 12; $i++) {
    $where = array_merge($base_where,array(['month',$i],['position','numerador']));
    $value = SingleParameter::where($where)->first();
    if($value) $data18_hosp['numeradores'][$i] = $value->value;
    else       $data18_hosp['numeradores'][$i] = null;

    $where = array_merge($base_where,array(['month',$i],['position','denominador']));
    $value = SingleParameter::where($where)->first();
    if($value) $data18_hosp['denominadores'][$i] = $value->value;
    else       $data18_hosp['denominadores'][$i] = null;
}

$data18_hosp['numerador_acumulado']   = array_sum($data18_hosp['numeradores']);
$data18_hosp['denominador_acumulado'] = array_sum($data18_hosp['denominadores']);

if($data18_hosp['denominador_acumulado'] != 0) {
    $data18_hosp['cumplimiento'] = $data18_hosp['numerador_acumulado'] / $data18_hosp['denominador_acumulado'] * 100;
}
else $data18_hosp['cumplimiento'] = 0;

if( $data18_hosp['cumplimiento'] >= $data18_hosp['meta']) {
    $data18_hosp['aporte'] = preg_replace("/[^0-9]/", '', $data18_hosp['ponderacion']);
}
else {
    // $data18_hosp['aporte'] = 0;
    $data18_hosp['aporte'] = $data18_hosp['cumplimiento'] *  preg_replace("/[^0-9]/", '', $data18_hosp['ponderacion']) / $data18_hosp['meta'];
}

/********** META 1.9. **********/
$data19_hosp = array();
$data19_hosp['label']['meta'] = '1.9. Porcentaje de pacientes con indicación de
    hospitalización desde UEH, que acceden a cama de dotación en menos de 12 hrs.';
$data19_hosp['label']['numerador'] = 'N° total de pacientes con indicación de
    hospitalización que espera en UEH T<12 para acceder a cama de dotación en t.';
$data19_hosp['label']['denominador'] = 'N° total de pacientes con indicación de
    hospitalización en UEH en t * 100.';

$data19_hosp['label']['fuente']['numerador'] = 'REM';
$data19_hosp['label']['fuente']['denominador'] = 'REM';


$data19_hosp['meta'] = '80%';
$data19_hosp['ponderacion'] = '10%';
$data20_hosp['cumplimiento'] = 0;
$data19_hosp['numerador_acumulado'] = 0;
$data19_hosp['denominador_acumulado'] = 0;

foreach($meses as $mes) {
    $data19_hosp['numeradores'][$mes] = 0;
    $data19_hosp['denominadores'][$mes] = 0;
}

/* ===== Query numerador ===== */
$sql_numerador = "SELECT e.alias_estab, r.Mes, sum(ifnull(Col01,0)) as numerador
    FROM {$year}rems r
    LEFT JOIN {$year}establecimientos e
    ON r.IdEstablecimiento=e.Codigo
    WHERE e.meta_san_18834_hosp = 1
    AND CodigoPrestacion IN (08222640)
    GROUP by e.Comuna, e.alias_estab, r.Mes
    ORDER BY e.Comuna, e.alias_estab, r.Mes";
$numeradores = DB::connection('mysql_rem')->select($sql_numerador);

foreach($numeradores as $registro) {
    $data19_hosp['numeradores'][$registro->Mes] = $registro->numerador;
    $data19_hosp['numerador_acumulado'] += $registro->numerador;
}

/* ===== Query denominador ===== */

$sql_denominador =
   "SELECT e.alias_estab, r.Mes, sum(ifnull(Col01,0)) as denominador
    FROM {$year}rems r
    LEFT JOIN {$year}establecimientos e
    ON r.IdEstablecimiento=e.Codigo
    WHERE CodigoPrestacion IN (08222640, 08222650, 08222660, 08221600, 08222670,08222680, '08230500A')
    AND e.meta_san_18834_hosp = 1
    GROUP BY e.Comuna, e.alias_estab, r.Mes
    ORDER BY e.Comuna, e.alias_estab, r.Mes";
$denominadores = DB::connection('mysql_rem')->select($sql_denominador);

foreach($denominadores as $registro) {
    $data19_hosp['denominadores'][$registro->Mes] = $registro->denominador;
    $data19_hosp['denominador_acumulado'] += $registro->denominador;
}

/* ==== Calculos ==== */
/* Calculo de las metas de la comuna */
if($data19_hosp['denominador_acumulado'] == 0) {
    /* Si es 0 el denominadore entonces el cumplimiento es 0 */
    $data19_hosp['cumplimiento'] = 0;
}
else {
    /* De lo contrario calcular el porcentaje */
    $data19_hosp['cumplimiento'] =
        $data19_hosp['numerador_acumulado'] /
        $data19_hosp['denominador_acumulado'] * 100;
}

if( $data19_hosp['cumplimiento'] >= preg_replace("/[^0-9]/", '', $data19_hosp['meta'])) {
    $data19_hosp['aporte'] = preg_replace("/[^0-9]/", '', $data19_hosp['ponderacion']);
}
else {
    $data19_hosp['aporte'] = $data19_hosp['cumplimiento'] *  preg_replace("/[^0-9]/", '', $data19_hosp['ponderacion']) / 100;
}

/********** META 1.4 **********/
$data14_hosp = array();
$data14_hosp['label']['meta'] = '1.4. Porcentaje de egreso de maternidades con
    Lactancia Materna Exclusiva (LME).';
$data14_hosp['label']['numerador'] = 'Número de egresos de maternidad con Lactancia
    materna exclusiva.';
$data14_hosp['label']['denominador'] = 'Número total de egresos de maternidad * 100.';


$data14_hosp['label']['fuente']['numerador'] = 'REM';
$data14_hosp['label']['fuente']['denominador'] = 'REM';

$data14_hosp['meta'] = '≥93%';
$data14_hosp['ponderacion'] = '25%';
$data14_hosp['cumplimiento'] = 0;
$data14_hosp['numerador_acumulado'] = 0;
$data14_hosp['denominador_acumulado'] = 0;

foreach($meses as $mes) {
    $data14_hosp['numeradores'][$mes] = 0;
    $data14_hosp['denominadores'][$mes] = 0;
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
    $data14_hosp['numeradores'][$registro->Mes] = $registro->numerador;
    $data14_hosp['numerador_acumulado'] += $registro->numerador;
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
    $data14_hosp['denominadores'][$registro->Mes] = $registro->denominador;
    $data14_hosp['denominador_acumulado'] += $registro->denominador;
}

/* Calculo de las metas de la comuna */
if($data14_hosp['denominador_acumulado'] == 0) {
    /* Si es 0 el denominadore entonces el cumplimiento es 0 */
    $data14_hosp['cumplimiento'] = 0;
}
else {
    /* De lo contrario calcular el porcentaje */
    $data14_hosp['cumplimiento'] =
        $data14_hosp['numerador_acumulado'] /
        $data14_hosp['denominador_acumulado'] * 100;
}


if( $data14_hosp['cumplimiento'] >= preg_replace("/[^0-9]/", '', $data14_hosp['meta'])) {
    $data14_hosp['aporte'] = preg_replace("/[^0-9]/", '', $data14_hosp['ponderacion']);
}
else {
    $data14_hosp['aporte'] = $data14_hosp['cumplimiento'] *  preg_replace("/[^0-9]/", '', $data14_hosp['ponderacion']) / 100;
}

/********** META 3.1 **********/
$data31_hosp['label']['meta'] = '3.1. Porcentajes de funcionarios regidos
    por el Estatuto Administrativo, capacitados durante el año, en al
    menos una actividad pertinente de los nueve ejes estratégicos de
    la Estrategia Nacional de Salud.';
$data31_hosp['label']['numerador']   = 'N° de funcionarios capacitados durante
    año t.';
$data31_hosp['label']['denominador'] = 'N° total de funcionarios de la dotación
    año t';


$data31_hosp['label']['fuente']['numerador'] = 'Reporte RRHH';
$data31_hosp['label']['fuente']['denominador'] = 'Reporte RRHH';

$data31_hosp['meta'] = '≥50%';
$data31_hosp['ponderacion'] = '20%';

$base_where = array(['law','18834'],['year',$year],['indicator',31],['establishment_id',1],['position','numerador']);
$value = SingleParameter::where($base_where)->first();
if($value) {
  $data31_hosp['numerador_acumulado'] = $value->value;
  $data31_hosp['vigencia'] = $value->month;
}
else{
  $data31_hosp['numerador_acumulado'] = null;
  $data31_hosp['vigencia'] = 1;
}

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

?>
