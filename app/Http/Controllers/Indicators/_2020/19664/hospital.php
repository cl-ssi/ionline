<?php
namespace App\Http\Controllers\Indicators\_2020;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\Indicators\SingleParameter;

$year = 2020;
$meses = array(1,2,3,4,5,6,7,8,9,10,11,12);

$sql_ultimo_rem = "SELECT MAX(Mes) as ultimo_rem FROM 2020rems;";
$ultimo_rem = DB::connection('mysql_rem')->select($sql_ultimo_rem)[0]->ultimo_rem;


function lastParameter (int $ind){
  $last_parameter = SingleParameter::select('month')
      ->where('indicator', $ind)
      ->get()
      ->last();

  return $last_parameter;
}

/**** INDICADOR 4 ****/
$data4_hosp['label']['meta'] = '4. Porcentaje de Intervenciones Quirúrgicas
    Suspendidas.';
$data4_hosp['label']['numerador'] = 'N° de intervenciones en especialidad
    quirúrgicas suspendidas en el establecimiento en el periodo.';
$data4_hosp['label']['denominador'] = 'N° total de intervencines en
    especialidad quirúrgicas programadas en tabla en el periodo * 100.';

$data4_hosp['label']['fuente']['numerador'] = 'REM';
$data4_hosp['label']['fuente']['denominador'] = 'REM';

$data4_hosp['meta'] = '<=7%';
$data4_hosp['ponderacion'] = '8';

/* Inicializar los meses, si son menores al ultimo rem cargado */
for($mes = 1; $mes <= $ultimo_rem; $mes ++) {
    $data4_hosp['numeradores'][$mes] = 0;
    $data4_hosp['denominadores'][$mes] = 0;
}

$data4_hosp['numerador_acumulado'] = 0;
$data4_hosp['denominador_acumulado'] = 0;

$sql_valores =
    "SELECT Mes AS mes,
        (SUM(ifnull(Col07,0)) + SUM(ifnull(Col08,0))) AS numerador,
        (SUM(ifnull(Col05,0)) + SUM(ifnull(Col06,0))) AS denominador
    FROM {$year}prestaciones p
    LEFT JOIN {$year}rems r
    ON p.codigo_prestacion = r.CodigoPrestacion
    WHERE Nserie = 'A21' AND IdEstablecimiento = 102100 AND r.Ano = 2020 AND
    codigo_prestacion IN
        (21500600, 21600800, 21600900, 21700100, 21500700, 21500800,
        21700300, 21700400, 21700500, 21700600, 21500900, 21700700)
    GROUP BY Mes";
$valores = DB::connection('mysql_rem')->select($sql_valores);

foreach($valores as $valor) {
    $data4_hosp['numeradores'][$valor->mes] = intval($valor->numerador);
    $data4_hosp['numerador_acumulado'] += intval($valor->numerador);
    $data4_hosp['denominadores'][$valor->mes] = intval($valor->denominador);
    $data4_hosp['denominador_acumulado'] += intval($valor->denominador);
}

/* Calcular el cumplimento */
if($data4_hosp['denominador_acumulado'] != 0) {
    $data4_hosp['cumplimiento'] = round($data4_hosp['numerador_acumulado'] /
                              $data4_hosp['denominador_acumulado'] * 100,1);
}

if( $data4_hosp['cumplimiento'] <= preg_replace("/[^0-9]/", '', $data4_hosp['meta'])) {
    $data4_hosp['aporte'] = $data4_hosp['ponderacion'];
}
else{
    $data4_hosp['aporte'] = 0;
}

/**** INDICADOR 5 ****/
$data5_hosp['label']['meta'] = '5. Porcentaje de ambulatorización de
    cirugías mayores en el año t.';
$data5_hosp['label']['numerador'] = 'N° de egreos de CMA en el periodo.';
$data5_hosp['label']['denominador'] = '(N° total de Egresos de CMA + Egresos
    posible de ambulatorizar en el periodo) * 100.';

$data5_hosp['label']['fuente']['numerador'] = 'GRD Minsal';
$data5_hosp['label']['fuente']['denominador'] = 'GRD Minsal';

$data5_hosp['meta'] = '≥55%';
$data5_hosp['ponderacion'] = '8';

$base_where = array(['law','19664'],['year',$year],['indicator',5],['establishment_id',1]);

$last_parameter = lastParameter(5);

for($i = 1; $i <= $last_parameter->month; $i++) {
    $where = array_merge($base_where,array(['month',$i],['position','numerador']));
    $value = SingleParameter::where($where)->first();
    if($value) $data5_hosp['numeradores'][$i] = $value->value;
    else       $data5_hosp['numeradores'][$i] = null;

    $where = array_merge($base_where,array(['month',$i],['position','denominador']));
    $value = SingleParameter::where($where)->first();
    if($value) $data5_hosp['denominadores'][$i] = $value->value;
    else       $data5_hosp['denominadores'][$i] = null;
}

$data5_hosp['numerador_acumulado']   = array_sum($data5_hosp['numeradores']);
$data5_hosp['denominador_acumulado'] = array_sum($data5_hosp['denominadores']);

if($data5_hosp['denominador_acumulado'] != 0) {
    $data5_hosp['cumplimiento'] = $data5_hosp['numerador_acumulado'] / $data5_hosp['denominador_acumulado'] * 100;
}
else $data5_hosp['cumplimiento'] = 0;

if( $data5_hosp['cumplimiento'] >= preg_replace("/[^0-9]/", '', $data5_hosp['meta'])) {
    $data5_hosp['aporte'] = $data5_hosp['ponderacion'];
}
else{
    $data5_hosp['aporte'] = 0;
}

//dd($data5_hosp);

/**** INDICADOR 6. ****/
$data6_hosp['label']['meta'] = '6. Variación porcentual del número de días
    promedio de espera para intervenciones quirúrgicas, según línea base.';
$data6_hosp['label']['numerador'] = 'Promedio de días de espera del total de las
    intervenciones quirúrgicas electivas del año t - 1 - promedio de días de
    espera del total de las intervenciones quirúrgicas electivas del año t.';
$data6_hosp['label']['denominador'] = 'promedio de días de espera del total de las
    intervenciones quirúrgicas electivas del año t-1 *100';

$data6_hosp['label']['fuente']['numerador'] = 'SIGTE';
$data6_hosp['label']['fuente']['denominador'] = 'SIGTE';

// $data6_hosp['meta'] = 'disminución 5 % respecto de línea base.';
$data6_hosp['meta'] = '5';
$data6_hosp['meta_nacional'] = '19';
$data6_hosp['ponderacion'] = '8';

$base_where = array(['law','19664'],['year',$year],['indicator',6],['establishment_id',1]);

$last_parameter = lastParameter(6);

for($i = 1; $i <= $last_parameter->month; $i++) {
    $where = array_merge($base_where,array(['month',$i],['position','numerador']));
    $value = SingleParameter::where($where)->first();
    if($value) $data6_hosp['numeradores'][$i] = $value->value;
    else       $data6_hosp['numeradores'][$i] = null;
}

/* 'mensual','semestral','anual','acumulada' */
$where = array_merge($base_where,array(['type','acumulada'],['position','numerador']));
$value = SingleParameter::where($where)->get()->last();

if($value){
    $data6_hosp['numerador_acumulado']   = $value->value;
    $data6_hosp['vigencia'] = $value->month;
}
else{
    $data6_hosp['numerador_acumulado']   = array_sum($data6_hosp['numeradores']);
    $data6_hosp['vigencia'] = 1;
}

/* 'mensual','semestral','anual','acumulada' */
$where = array_merge($base_where,array(['type','anual'],['position','denominador']));
$value = SingleParameter::where($where)->first();

if($value) $data6_hosp['denominador_acumulado'] = $value->value;
else       $data6_hosp['denominador_acumulado'] = 0;

if($data6_hosp['denominador_acumulado'] != 0) {
    $data6_hosp['cumplimiento'] = number_format(
        $data6_hosp['numerador_acumulado'] / $data6_hosp['denominador_acumulado'] * 100,2, ',', '.');
}
else $data6_hosp['cumplimiento'] = 0;

if( $data6_hosp['cumplimiento'] >= ($data6_hosp['meta_nacional'] - 5) && $data6_hosp['cumplimiento'] != 0) {
    $data6_hosp['aporte'] = $data6_hosp['ponderacion'];
}
else {
    $data6_hosp['aporte'] = 0;
}

/**** INDICADOR 7 ****/
$data7_hosp['label']['meta'] = '7. Porcentaje de altas Odontológicas de
    especialidades del nivel secundario por ingreso de tratamiento.';
$data7_hosp['label']['numerador'] = 'N° de altas de tratamiento odontológico
    de especialidades del periodo.';
$data7_hosp['label']['denominador'] = 'N° de ingresos a tratamiento
    odontológico de especialidades del periodo * 100.';

$data7_hosp['label']['fuente']['numerador'] = 'REM';
$data7_hosp['label']['fuente']['denominador'] = 'REM';

$data7_hosp['meta'] = '82.71';
$data7_hosp['ponderacion'] = '7';

/* Inicializar los meses, si son menores al ultimo rem cargado */
for($mes = 1; $mes <= $ultimo_rem; $mes ++) {
    $data7_hosp['numeradores'][$mes] = 0;
    $data7_hosp['denominadores'][$mes] = 0;
}

$data7_hosp['numerador_acumulado'] = 0;
$data7_hosp['denominador_acumulado'] = 0;

$sql_numeradores =
    "SELECT Mes AS mes, floor(SUM(ifnull(Col01,0))) AS numerador
    FROM {$year}prestaciones p
    LEFT JOIN {$year}rems r
    ON p.codigo_prestacion = r.CodigoPrestacion
    WHERE Nserie = 'A09' AND IdEstablecimiento = 102100 AND r.Ano = 2020 AND
    codigo_prestacion IN
        (09216213, 09204954, 09216613, 09217013, 09217513, 09218013,
        09218413, 09218913, 09219313, 09309050, 09309250, 09240600)
    GROUP BY Mes";
$valores = DB::connection('mysql_rem')->select($sql_numeradores);

foreach($valores as $valor) {
    $data7_hosp['numeradores'][$valor->mes] = intval($valor->numerador);
    $data7_hosp['numerador_acumulado'] += intval($valor->numerador);
}

$sql_denominadores =
    "SELECT Mes AS mes, floor(SUM(ifnull(Col01,0))) AS denominador
    FROM {$year}prestaciones p
    LEFT JOIN {$year}rems r
    ON p.codigo_prestacion = r.CodigoPrestacion
    WHERE Nserie = 'A09' AND IdEstablecimiento = 102100 AND r.Ano = 2020 AND
    codigo_prestacion IN
        (09216113, 09204953, 09216513, 09216913, 09217413, 09217913,
         09218313, 09218813, 09219213, 09309000, 09309200, 09240500)
    GROUP BY Mes";
$valores = DB::connection('mysql_rem')->select($sql_denominadores);


foreach($valores as $valor) {
    $data7_hosp['denominadores'][$valor->mes] = intval($valor->denominador);
    $data7_hosp['denominador_acumulado'] += intval($valor->denominador);
}

/* Calcular el cumplimento */
if($data7_hosp['denominador_acumulado'] != 0) {
    $data7_hosp['cumplimiento'] = round($data7_hosp['numerador_acumulado'] /
                              $data7_hosp['denominador_acumulado'] * 100,1);
}
else {
    $data7_hosp['cumplimiento'] = 0;
}

if( $data7_hosp['cumplimiento'] >= $data7_hosp['meta']) {
    $data7_hosp['aporte'] = $data7_hosp['ponderacion'];
}
else {
    $data7_hosp['aporte'] = $data7_hosp['cumplimiento'] *  preg_replace("/[^0-9]/", '', $data7_hosp['ponderacion']) / $data7_hosp['meta'];
}

/**** INDICADOR 8 ****/
$data8_hosp['label']['meta'] = '8. Porcentaje de Cumplimento de la
    Programación anual de Consulta Médicas realizadas por Especialista.';
$data8_hosp['label']['numerador'] = 'N° de consultas epecialista realizadas
    durante el periodo.';
$data8_hosp['label']['denominador'] = 'N° total de consultas de especialistas
    programadas y validadas para igual periodo * 100.';

$data8_hosp['label']['fuente']['numerador'] = 'REM';
$data8_hosp['label']['fuente']['denominador'] = 'Programacion Anual';

$data8_hosp['meta'] = '95';
$data8_hosp['ponderacion'] = '8%';

$data8_hosp['numerador_acumulado'] = 0;
$data8_hosp['denominador'] = '';

/* Inicializar los meses, si son menores al ultimo rem cargado */
for($mes = 1; $mes <= $ultimo_rem; $mes ++) {
    $data8_hosp['numeradores'][$mes] = 0;
}

$sql_numeradores =
"SELECT Mes AS mes, floor(SUM(ifnull(Col01,0))) AS numerador
FROM {$year}prestaciones p
LEFT JOIN {$year}rems r
ON p.codigo_prestacion = r.CodigoPrestacion
WHERE Nserie = 'A07' AND IdEstablecimiento = 102100 AND r.Ano = 2020 AND
codigo_prestacion IN
    (7020130, 7020230, 7020330, 7020331, 7020332, 7024219, 7020500,
    7020501, 7020600, 7020601, 7020700, 7020800, 7020801, 7020900,
    7020901, 7021000, 7021001, 7021100, 7021101, 7021230, 7021300,
    7021301, 7022000, 7022001, 7021531, 7022132, 7022133, 7022134,
    7021700, 7021800, 7021801, 7021900, 7022130, 7022142, 7022143,
    7022144, 7022135, 7022136, 7022137, 7022700, 7022800, 7022900,
    7021701, 7023100, 7023200, 7023201, 7023202, 7023203, 7023700,
    7023701, 7023702, 7023703, 7024000, 7024001, 7024200, 7030500,
    7024201, 7024202, 7030501, 7030502)
GROUP BY Mes;";

$valores = DB::connection('mysql_rem')->select($sql_numeradores);

foreach($valores as $valor) {
    $data8_hosp['numeradores'][$valor->mes] = intval($valor->numerador);
    $data8_hosp['numerador_acumulado'] += intval($valor->numerador);
}

$base_where = array(['law','19664'],['year',$year],['indicator',8],['establishment_id',1],['position','denominador']);
$value = SingleParameter::where($base_where)->first();
if($value) $data8_hosp['denominador'] = $value->value;
else       $data8_hosp['denominador'] = 0;

/* Calcular el cumplimento */
if($data8_hosp['numerador_acumulado'] AND $data8_hosp['denominador'] != 0) {
    $data8_hosp['cumplimiento'] = $data8_hosp['numerador_acumulado'] / $data8_hosp['denominador'] * 100;
}
else {
    $data8_hosp['cumplimiento'] = 0;
}

if( $data8_hosp['cumplimiento'] >= preg_replace("/[^0-9]/", '', $data8_hosp['meta'])) {
    $data8_hosp['aporte'] = preg_replace("/[^0-9]/", '', $data8_hosp['ponderacion']);
}
else {
    $data8_hosp['aporte'] = $data8_hosp['cumplimiento'] *  preg_replace("/[^0-9]/", '', $data8_hosp['ponderacion']) / $data8_hosp['meta'];
}


/********** META 1.9. **********/
$data9_hosp = array();
$data9_hosp['label']['meta'] = '9. Porcentaje de pacientes con indicación de
    hospitalización desde UEH, que acceden a cama de dotación en menos de 12 hrs.';
$data9_hosp['label']['numerador'] = 'N° total de pacientes con indicación de
    hospitalización que espera en UEH T<12 para acceder a cama de dotación en t.';
$data9_hosp['label']['denominador'] = 'N° total de pacientes con indicación de
    hospitalización en UEH en t. * 100';

$data9_hosp['label']['fuente']['numerador'] = 'REM';
$data9_hosp['label']['fuente']['denominador'] = 'REM';


$data9_hosp['meta'] = '80%';
$data9_hosp['ponderacion'] = '36%';
$data9_hosp['cumplimiento'] = 0;
$data9_hosp['numerador_acumulado'] = 0;
$data9_hosp['denominador_acumulado'] = 0;

foreach($meses as $mes) {
    $data9_hosp['numeradores'][$mes] = 0;
    $data9_hosp['denominadores'][$mes] = 0;
}

/* ===== Query numerador ===== */
$sql_numerador = "SELECT e.alias_estab, r.Mes, sum(ifnull(Col01,0)) as numerador
    FROM {$year}rems r
    LEFT JOIN {$year}establecimientos e
    ON r.IdEstablecimiento=e.Codigo
    WHERE CodigoPrestacion IN (08222640)
    AND IdEstablecimiento = 102100
    GROUP by e.Comuna, e.alias_estab, r.Mes
    ORDER BY e.Comuna, e.alias_estab, r.Mes";
$numeradores = DB::connection('mysql_rem')->select($sql_numerador);

foreach($numeradores as $registro) {
    $data9_hosp['numeradores'][$registro->Mes] = $registro->numerador;
    $data9_hosp['numerador_acumulado'] += $registro->numerador;
}

/* ===== Query denominador ===== */
$sql_denominador =
   "SELECT e.alias_estab, r.Mes, sum(ifnull(Col01,0)) as denominador
    FROM {$year}rems r
    LEFT JOIN {$year}establecimientos e
    ON r.IdEstablecimiento=e.Codigo
    WHERE CodigoPrestacion IN (08222640, 08222650, 08222660, 08222680, '08230500A')
    AND IdEstablecimiento = 102100
    GROUP BY e.Comuna, e.alias_estab, r.Mes
    ORDER BY e.Comuna, e.alias_estab, r.Mes";
$denominadores = DB::connection('mysql_rem')->select($sql_denominador);

foreach($denominadores as $registro) {
    $data9_hosp['denominadores'][$registro->Mes] = $registro->denominador;
    $data9_hosp['denominador_acumulado'] += $registro->denominador;
}

/* ==== Calculos ==== */
/* Calculo de las metas de la comuna */
if($data9_hosp['denominador_acumulado'] == 0) {
    /* Si es 0 el denominadore entonces el cumplimiento es 0 */
    $data9_hosp['cumplimiento'] = 0;
}
else {
    /* De lo contrario calcular el porcentaje */
    $data9_hosp['cumplimiento'] =
        $data9_hosp['numerador_acumulado'] /
        $data9_hosp['denominador_acumulado'] * 100;
}

if( $data9_hosp['cumplimiento'] >= preg_replace("/[^0-9]/", '', $data9_hosp['meta'])) {
    $data9_hosp['aporte'] = preg_replace("/[^0-9]/", '', $data9_hosp['ponderacion']);
}
else {
    $data9_hosp['aporte'] = 0;
}
// else {
//     $data9_hosp['aporte'] = $data9_hosp['cumplimiento'] *  preg_replace("/[^0-9]/", '', $data9_hosp['ponderacion']) / 100;
// }

/**** INDICADOR 10 ****/
$data10_hosp['label']['meta'] = '10. Porcentaje de Cumplimiento de la
    Programación anual de Consultas Médicas realizadas en modalidad
    Telemedicina.';
$data10_hosp['label']['numerador'] = 'N° total de consultas médicas (nuevas y controles)
    de especialidad realizadas a través de telemedicina, durante el periodo.';
$data10_hosp['label']['denominador'] = 'N° total de consultas de especialista
    programadas y validadas para igual periodo * 100.';

$data10_hosp['label']['fuente']['numerador'] = 'REM';
$data10_hosp['label']['fuente']['denominador'] = 'Programacion Anual';

$data10_hosp['meta'] = '≥95%';
$data10_hosp['ponderacion'] = '7';

$data10_hosp['numerador_acumulado'] = 0;
$data10_hosp['denominador'] = '';

/* Inicializar los meses, si son menores al ultimo rem cargado */
for($mes = 1; $mes <= $ultimo_rem; $mes ++) {
    $data10_hosp['numeradores'][$mes] = 0;
}

$sql_numeradores =
"SELECT Mes AS mes, FLOOR(
    SUM(ifnull(Col09,0)) +
    SUM(ifnull(Col10,0)) +
    SUM(ifnull(Col11,0)) +
    SUM(ifnull(Col12,0))
) AS numerador
FROM {$year}prestaciones p
LEFT JOIN {$year}rems r
ON p.codigo_prestacion = r.CodigoPrestacion
WHERE Nserie = 'A30' AND IdEstablecimiento = 102100 AND r.Ano = 2020 AND
codigo_prestacion IN (
    30000000, 30000001, 30000002, 30000003, 30000004, 30000005, 30000006,
    30000007, 30000008, 30000009, 30000010, 30000011, 30000012, 30000013,
    30000014, 30000015, 30000016, 30000017, 30000018, 30000019, 30000020,
    30000021, 30000022, 30000023, 30000024, 30000025, 30000026, 30000027,
    30000028, 30000029, 30000030, 30000031, 30000032, 30000033, 30000034,
    30000035, 30000036, 30000037, 30000038, 30000039, 30000040, 30000041,
    30000042, 30000043, 30000044, 30000045, 30000046, 30000047, 30000048,
    30000049, 30000050, 30000051, 30000052, 30000053, 30000054, 30000086,
    30000055, 30000056, 30000087, 30000088
)
GROUP BY Mes;";

$valores = DB::connection('mysql_rem')->select($sql_numeradores);

foreach($valores as $valor) {
    $data10_hosp['numeradores'][$valor->mes] = intval($valor->numerador);
    $data10_hosp['numerador_acumulado'] += intval($valor->numerador);
}

$base_where = array(['law','19664'],['year',$year],['indicator',10],['establishment_id',1],['position','denominador']);
$value = SingleParameter::where($base_where)->first();
if($value) $data10_hosp['denominador'] = $value->value;
else       $data10_hosp['denominador'] = 0;

/* Calcular el cumplimento */
if($data10_hosp['numerador_acumulado'] AND $data10_hosp['denominador'] != 0) {
    $data10_hosp['cumplimiento'] = $data10_hosp['numerador_acumulado'] / $data10_hosp['denominador'] * 100;
}
else $data10_hosp['cumplimiento'] = 0;

// dd($data10_hosp['denominador']);

if( $data10_hosp['cumplimiento'] >= preg_replace("/[^0-9]/", '', $data10_hosp['meta'])) {
    $data10_hosp['aporte'] = preg_replace("/[^0-9]/", '', $data10_hosp['ponderacion']);
}
else{
    $data10_hosp['aporte'] = 0;
}

/**** INDICADOR 11 ****/
$data11_hosp['label']['meta'] = '11. Promedio de días de estada de pacientes
    derivados vía UGCC a prestadores privados fuera de convenio.';
$data11_hosp['label']['numerador'] = 'N° de días de hospitalización de
    pacientes derivados vía UGCC en el extrasistema.';
$data11_hosp['label']['denominador'] = 'N° total de pacientes derivados vía
    UGCC al extrasistema.';

$data11_hosp['label']['fuente']['numerador'] = 'UGCC Minsal';
$data11_hosp['label']['fuente']['denominador'] = 'UGCC Minsal';

$data11_hosp['meta'] = '<=10%';
$data11_hosp['ponderacion'] = '8';

$base_where = array(['law','19664'],['year',$year],['indicator',11],['establishment_id',1]);

$last_parameter = lastParameter(11);

for($i = 1; $i <= $last_parameter->month; $i++) {
    $where = array_merge($base_where,array(['month',$i],['position','numerador']));
    $value = SingleParameter::where($where)->first();
    if($value) $data11_hosp['numeradores'][$i] = $value->value;
    else       $data11_hosp['numeradores'][$i] = null;

    $where = array_merge($base_where,array(['month',$i],['position','denominador']));
    $value = SingleParameter::where($where)->first();
    if($value) $data11_hosp['denominadores'][$i] = $value->value;
    else       $data11_hosp['denominadores'][$i] = null;
}

$data11_hosp['numerador_acumulado']   = array_sum($data11_hosp['numeradores']);
$data11_hosp['denominador_acumulado'] = array_sum($data11_hosp['denominadores']);

if($data11_hosp['numerador_acumulado'] AND $data11_hosp['denominador_acumulado'] != 0) {
    $data11_hosp['cumplimiento'] = $data11_hosp['numerador_acumulado'] / $data11_hosp['denominador_acumulado'] * 100;
}
// elseif($data11_hosp['denominador_acumulado'] == 0 && $data11_hosp['numerador_acumulado'] == 0) {
//     $data11_hosp['cumplimiento'] = 100;
// }
else $data11_hosp['cumplimiento'] = 0;

if( $data11_hosp['cumplimiento'] >= $data11_hosp['meta']) {
    $data11_hosp['aporte'] = $data11_hosp['ponderacion'];
}
elseif($data11_hosp['cumplimiento'] == NULL){
    $data11_hosp['aporte'] = 0;
}
// else {
//     $data11_hosp['aporte'] = ($data11_hosp['cumplimiento'] * $data11_hosp['ponderacion']) / 100;
// }

/* INDICADOR 12 */
$data12_hosp['label']['meta'] = '12. Porcentaje de Gestión Efectiva para el
    Cumplimiento GES en la Red.';
$data12_hosp['label']['numerador'] = 'Garantías cumplidas + Garantías Exceptuadas +
    Garantías Incumplidas Atendidas.';
$data12_hosp['label']['denominador'] = '(Garantías Cumplidas + Garantías Exceptuadas +
    Garantías Incumplidas Atendidas + Garantías Incumplidas No Atendidas +
    Garantías Retrasadas) * 100.';

$data12_hosp['label']['fuente']['numerador'] = 'Datamart';
$data12_hosp['label']['fuente']['denominador'] = 'Datamart';

$data12_hosp['meta'] = '100';
$data12_hosp['ponderacion'] = '10%';

$base_where = array(['law','19664'],['year',$year],['indicator',12],['establishment_id',1]);

$last_parameter = lastParameter(12);

for($i = 1; $i <= $last_parameter->month; $i++) {
    $where = array_merge($base_where,array(['month',$i],['position','numerador']));
    $value = SingleParameter::where($where)->first();
    if($value) $data12_hosp['numeradores'][$i] = $value->value;
    else       $data12_hosp['numeradores'][$i] = null;

    $where = array_merge($base_where,array(['month',$i],['position','denominador']));
    $value = SingleParameter::where($where)->first();
    if($value) $data12_hosp['denominadores'][$i] = $value->value;
    else       $data12_hosp['denominadores'][$i] = null;
}

$data12_hosp['numerador_acumulado']   = array_sum($data12_hosp['numeradores']);
$data12_hosp['denominador_acumulado'] = array_sum($data12_hosp['denominadores']);

if($data12_hosp['denominador_acumulado'] != 0) {
    $data12_hosp['cumplimiento'] = $data12_hosp['numerador_acumulado'] / $data12_hosp['denominador_acumulado'] * 100;
}
else $data12_hosp['cumplimiento'] = 0;

if( $data12_hosp['cumplimiento'] >= preg_replace("/[^0-9]/", '', $data12_hosp['meta'])) {
    $data12_hosp['aporte'] = preg_replace("/[^0-9]/", '', $data12_hosp['ponderacion']);
}
else {
    $data12_hosp['aporte'] = $data12_hosp['cumplimiento'] *  preg_replace("/[^0-9]/", '', $data12_hosp['ponderacion']) / $data12_hosp['meta'];
}

?>
