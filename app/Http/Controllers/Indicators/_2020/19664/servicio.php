<?php
namespace App\Http\Controllers\Indicators\_2020;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\Indicators\SingleParameter;

$last_year = 2019;
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

/* INDICADOR 1. */
$data1['label']['meta'] = '1. Pacientes diabéticos compensados en
    el grupo de 15 años y más.';
$data1['label']['numerador'] = 'N° de personas con DM2 de 15 A 79 años
    con Hemoglobina Glicosilada bajo 7%, según último control en los
    últimos 12 meses + N° de personas con DM2 de 80 años y más con
    Hemoglobina Glicosilada bajo 8% según último control vigente, en los
    últimos 12 meses.';
$data1['label']['denominador'] = 'Total de pacientes diabéticos de 15
    años y más bajo control en el nivel primario * 100.';

$data1['label']['fuente']['numerador'] = 'REM';
$data1['label']['fuente']['denominador'] = 'REM';

$data1['meta'] = '45';
$data1['ponderacion'] = '17%';

/* ==== Inicializar el arreglo de datos $data ==== */
$data1['numerador_12a'] = '';
$data1['denominador_12a'] = '';

$data1['numerador'] = '';
$data1['numerador_6'] = '';
$data1['numerador_12'] = '';
$data1['denominador'] = '';
$data1['denominador_6'] = '';
$data1['denominador_12'] = '';

$data1['cumplimiento'] = '';

$data1['aporte'] = '';

// AÑO ANTERIOR

$sql_numerador = "SELECT r.Mes AS mes, SUM(COALESCE(Col01,0)) AS valor
                FROM {$last_year}rems r
                WHERE Mes = 12 AND IdEstablecimiento NOT IN (102100)
                  AND CodigoPrestacion IN ('P4180300','P4200200')
                GROUP BY r.Mes
                ORDER BY r.Mes";
$numeradores = DB::connection('mysql_rem')->select($sql_numerador);

foreach($numeradores as $numerador) {
    switch($numerador->mes) {
        case 12: $data1['numerador_12a'] = $numerador->valor; break;
    }
}

$sql_denominador = "SELECT r.Mes AS mes, SUM(COALESCE(Col01,0)) AS valor
                    FROM {$last_year}rems r
                    WHERE Mes = 12 AND IdEstablecimiento NOT IN (102100)
                      AND CodigoPrestacion IN ('P4150602')
                    GROUP BY r.Mes
                    ORDER BY r.Mes";
$denominadores = DB::connection('mysql_rem')->select($sql_denominador);

foreach($denominadores as $denominador) {
    switch($denominador->mes) {
        case 12: $data1['denominador_12a'] = $denominador->valor; break;
    }
}

// -----------------------------------------------------------------------------

$sql_numerador = "SELECT r.Mes AS mes, SUM(COALESCE(Col01,0)) AS valor
                FROM {$year}rems r
                WHERE (Mes = 6 OR Mes = 12) AND IdEstablecimiento NOT IN (102100)
                  AND CodigoPrestacion IN ('P4180300','P4200200')
                GROUP BY r.Mes
                ORDER BY r.Mes";
$numeradores = DB::connection('mysql_rem')->select($sql_numerador);

foreach($numeradores as $numerador) {
    switch($numerador->mes) {
        case 6:  $data1['numerador_6'] = $numerador->valor; break;
        case 12: $data1['numerador_12'] = $numerador->valor; break;
    }
}

$sql_denominador = "SELECT r.Mes AS mes, SUM(COALESCE(Col01,0)) AS valor
                    FROM {$year}rems r
                    WHERE (Mes = 6 OR Mes = 12) AND IdEstablecimiento NOT IN (102100)
                      AND CodigoPrestacion IN ('P4150602')
                    GROUP BY r.Mes
                    ORDER BY r.Mes";
$denominadores = DB::connection('mysql_rem')->select($sql_denominador);

foreach($denominadores as $denominador) {
    switch($denominador->mes) {
        case 6:  $data1['denominador_6'] = $denominador->valor; break;
        case 12: $data1['denominador_12'] = $denominador->valor; break;
    }
}

switch($ultimo_rem){
    case 1:
    case 2:
    case 3:
    case 4:
    case 5:
        $data1['numerador'] = '';
        $data1['denominador'] = '';
        $data1['cumplimiento'] = '';
        break;
    case 6:
    case 7:
    case 8:
    case 9:
    case 10:
    case 11:
        if($data1['numerador_6'] AND $data1['denominador_6'] != 0) {
            $data1['cumplimiento'] = $data1['numerador_6'] / $data1['denominador_6'] * 100;
        }
        else {
            $data1['cumplimiento'] = 0;
        }
        $data1['numerador'] = $data1['numerador_6'] = $data1['numerador_6'];
        $data1['denominador'] = $data1['denominador_6'] = $data1['denominador_6'];
        break;
    case 12:
        if($data1['numerador_12'] AND $data1['denominador_12'] != 0) {
            $data1['cumplimiento'] = $data1['numerador_12'] / $data1['denominador_12'] * 100;
        }
        else {
            $data1['cumplimiento'] = 0;
        }
        $data1['numerador'] = $data1['numerador_12'] = $data1['numerador_12'];
        $data1['denominador'] = $data1['denominador_12'] = $data1['denominador_12'];
        break;
}

if( $data1['cumplimiento'] >= $data1['meta']) {
    $data1['aporte'] = preg_replace("/[^0-9]/", '', $data1['ponderacion']);
}
elseif( $data1['cumplimiento'] == '') {
    $data1['aporte'] = 0;
}

/**** INDICADOR 2. ****/
$data2['label']['meta'] = '2. Evaluacion Anual de los Pies en
    personas con DM2 de 15 y más con diabetes bajo control.';
$data2['label']['numerador'] = 'N° de personas con DM2 bajo control de
    15 y más años con una evaluación de pié viegente en el año t.';
$data2['label']['denominador'] = 'N° total de pacientes diabéticos de
    15 años y más bajo controlen nivel primario. * 100.';

$data2['meta'] = '90';
$data2['ponderacion'] = '17%';

$data2['label']['fuente']['numerador'] = 'REM';
$data2['label']['fuente']['denominador'] = 'REM';

/* ==== Inicializar el arreglo de datos $data ==== */
$data2['numerador_12a'] = '';
$data2['denominador_12a'] = '';

$data2['numerador'] = '';
$data2['numerador_6'] = '';
$data2['numerador_12'] = '';
$data2['denominador'] = '';
$data2['denominador_6'] = '';
$data2['denominador_12'] = '';

$data2['cumplimiento'] = '';

$data2['aporte'] = '';

// AÑO ANTERIOR

$sql_numerador = "SELECT r.Mes AS mes, SUM(COALESCE(Col01,0)) AS valor
                FROM {$last_year}rems r
                WHERE Mes = 12 AND IdEstablecimiento NOT IN (102100)
                    AND CodigoPrestacion IN ('P4190809','P4170300','P4190500','P4190600')
                GROUP BY r.Mes
                ORDER BY r.Mes";
$numeradores = DB::connection('mysql_rem')->select($sql_numerador);

foreach($numeradores as $numerador) {
    switch($numerador->mes) {
        case 12: $data2['numerador_12a'] = $numerador->valor; break;
    }
}

$sql_denominador = "SELECT r.Mes AS mes, SUM(COALESCE(Col01,0)) AS valor
                    FROM {$last_year}rems r
                    WHERE Mes = 12 AND IdEstablecimiento NOT IN (102100)
                        AND CodigoPrestacion IN ('P4150602')
                    GROUP BY r.Mes
                    ORDER BY r.Mes";
$denominadores = DB::connection('mysql_rem')->select($sql_denominador);

foreach($denominadores as $denominador) {
    switch($denominador->mes) {
        case 12: $data2['denominador_12a'] = $denominador->valor; break;
    }
}

// -----------------------------------------------------------------------------

$sql_numerador = "SELECT r.Mes AS mes, SUM(COALESCE(Col01,0)) AS valor
                FROM {$year}rems r
                WHERE (Mes = 6 OR Mes = 12) AND IdEstablecimiento NOT IN (102100)
                    AND CodigoPrestacion IN ('P4190809','P4170300','P4190500','P4190600')
                GROUP BY r.Mes
                ORDER BY r.Mes";
$numeradores = DB::connection('mysql_rem')->select($sql_numerador);

foreach($numeradores as $numerador) {
    switch($numerador->mes) {
        case 6:  $data2['numerador_6'] = $numerador->valor; break;
        case 12: $data2['numerador_12'] = $numerador->valor; break;
    }
}

$sql_denominador = "SELECT r.Mes AS mes, SUM(COALESCE(Col01,0)) AS valor
                    FROM {$year}rems r
                    WHERE (Mes = 6 OR Mes = 12) AND IdEstablecimiento NOT IN (102100)
                        AND CodigoPrestacion IN ('P4150602')
                    GROUP BY r.Mes
                    ORDER BY r.Mes";
$denominadores = DB::connection('mysql_rem')->select($sql_denominador);

foreach($denominadores as $denominador) {
    switch($denominador->mes) {
        case 6:  $data2['denominador_6'] = $denominador->valor; break;
        case 12: $data2['denominador_12'] = $denominador->valor; break;
    }
}

switch($ultimo_rem){
    case 1:
    case 2:
    case 3:
    case 4:
    case 5:
        $data2['numerador'] = '';
        $data2['denominador'] = '';
        $data2['cumplimiento'] = '';
        break;
    case 6:
    case 7:
    case 8:
    case 9:
    case 10:
    case 11:
        if($data2['numerador_6'] AND $data2['denominador_6'] != 0) {
            $data2['cumplimiento'] = $data2['numerador_6'] / $data2['denominador_6'] * 100;
        }
        else {
            $data2['cumplimiento'] = 0;
        }
        $data2['numerador'] = $data2['numerador_6'] = $data2['numerador_6'];
        $data2['denominador'] = $data2['denominador_6'] = $data2['denominador_6'];
        break;
    case 12:
        if($data2['numerador_12'] AND $data2['denominador_12'] != 0) {
            $data2['cumplimiento'] = $data2['numerador_12'] / $data2['denominador_12'] * 100;
        }
        else {
            $data2['cumplimiento'] = 0;
        }
        $data2['numerador'] = $data2['numerador_12'] = $data2['numerador_12'];
        $data2['denominador'] = $data2['denominador_12'] = $data2['denominador_12'];
        break;
}

if( $data2['cumplimiento'] >= preg_replace("/[^0-9]/", '', $data2['meta'])) {
    $data2['aporte'] = preg_replace("/[^0-9]/", '', $data2['ponderacion']);
}
else {
    $data2['aporte'] = $data2['cumplimiento'] *  preg_replace("/[^0-9]/", '', $data2['ponderacion']) / $data2['meta'];
}

/**** INDICADOR 3. ****/
$data3['label']['meta'] = '3. Pacientes hipertensos compensados
    bajo control en el grupo de 15 años y más.';
$data3['label']['numerador'] = 'N° personas con HTA de 15 a 79 años
    con presión arterial bajo 140/90 mmHg, según último control vigente
    en los últimos 12 meses + N° de personas con HTC de 80 y más años
    con presión arterial bajo 150/90 mmHg, según último control vigente,
    en los últimos 12 meses.';
$data3['label']['denominador'] = 'N° total de pacientes hipertensos de
    15 años y más bajo control en el nivel primario * 100.';

$data3['label']['fuente']['numerador'] = 'REM';
$data3['label']['fuente']['denominador'] = 'REM';

$data3['meta'] = '68';
$data3['ponderacion'] = '6.5';

/* ==== Inicializar el arreglo de datos $data ==== */
$data3['numerador_12a'] = '';
$data3['denominador_12a'] = '';

$data3['numerador'] = '';
$data3['numerador_6'] = '';
$data3['numerador_12'] = '';
$data3['denominador'] = '';
$data3['denominador_6'] = '';
$data3['denominador_12'] = '';

$data3['cumplimiento'] = '';

$data3['aporte'] = '';

// AÑO ANTEIROR
$sql_numerador = "SELECT r.Mes AS mes, SUM(COALESCE(Col01,0)) AS valor
                FROM {$last_year}rems r
                WHERE Mes = 12 AND IdEstablecimiento NOT IN (102100)
                    AND CodigoPrestacion IN ('P4180200','P4200100')
                GROUP BY r.Mes
                ORDER BY r.Mes";
$numeradores = DB::connection('mysql_rem')->select($sql_numerador);

foreach($numeradores as $numerador) {
    switch($numerador->mes) {
        case 12: $data3['numerador_12a'] = $numerador->valor; break;
    }
}

$sql_denominador = "SELECT r.Mes AS mes, SUM(COALESCE(Col01,0)) AS valor
                    FROM {$last_year}rems r
                    WHERE Mes = 12 AND IdEstablecimiento NOT IN (102100)
                        AND CodigoPrestacion IN ('P4150601')
                    GROUP BY r.Mes
                    ORDER BY r.Mes";
$denominadores = DB::connection('mysql_rem')->select($sql_denominador);

foreach($denominadores as $denominador) {
    switch($denominador->mes) {
        case 12: $data3['denominador_12a'] = $denominador->valor; break;
    }
}
//-----------------------------------------------------------------------------

$sql_numerador = "SELECT r.Mes AS mes, SUM(COALESCE(Col01,0)) AS valor
                FROM {$year}rems r
                WHERE (Mes = 6 OR Mes = 12) AND IdEstablecimiento NOT IN (102100)
                    AND CodigoPrestacion IN ('P4180200','P4200100')
                GROUP BY r.Mes
                ORDER BY r.Mes";
$numeradores = DB::connection('mysql_rem')->select($sql_numerador);

foreach($numeradores as $numerador) {
    switch($numerador->mes) {
        case 6:  $data3['numerador_6'] = $numerador->valor; break;
        case 12: $data3['numerador_12'] = $numerador->valor; break;
    }
}

$sql_denominador = "SELECT r.Mes AS mes, SUM(COALESCE(Col01,0)) AS valor
                    FROM {$year}rems r
                    WHERE (Mes = 6 OR Mes = 12) AND IdEstablecimiento NOT IN (102100)
                        AND CodigoPrestacion IN ('P4150601')
                    GROUP BY r.Mes
                    ORDER BY r.Mes";
$denominadores = DB::connection('mysql_rem')->select($sql_denominador);

foreach($denominadores as $denominador) {
    switch($denominador->mes) {
        case 6:  $data3['denominador_6'] = $denominador->valor; break;
        case 12: $data3['denominador_12'] = $denominador->valor; break;
    }
}

switch($ultimo_rem){
    case 1:
    case 2:
    case 3:
    case 4:
    case 5:
        $data3['numerador'] = '';
        $data3['denominador'] = '';
        $data3['cumplimiento'] = '';
        break;
    case 6:
    case 7:
    case 8:
    case 9:
    case 10:
    case 11:
        if($data3['numerador_6'] AND $data3['denominador_6'] != 0) {
            $data3['cumplimiento'] = $data3['numerador_6'] / $data3['denominador_6'] * 100;
        }
        else {
            $data3['cumplimiento'] = 0;
        }
        $data3['numerador'] = $data3['numerador_6'] = $data3['numerador_6'];
        $data3['denominador'] = $data3['denominador_6'] = $data3['denominador_6'];
        break;
    case 12:
        if($data3['numerador_12'] AND $data3['denominador_12'] != 0) {
            $data3['cumplimiento'] = $data3['numerador_12'] / $data3['denominador_12'] * 100;
        }
        else {
            $data3['cumplimiento'] = 0;
        }
        $data3['numerador'] = $data3['numerador_12'] = $data3['numerador_12'];
        $data3['denominador'] = $data3['denominador_12'] = $data3['denominador_12'];
        break;
}

if( $data3['cumplimiento'] >= $data3['meta']) {
    $data3['aporte'] = $data3['ponderacion'];
}
else {
    $data3['aporte'] = $data3['cumplimiento'] *  $data3['ponderacion'] / $data3['meta'];
}

/**** INDICADOR 4 ****/
$data4['label']['meta'] = '4. Porcentaje de Intervenciones Quirúrgicas
    Suspendidas.';
$data4['label']['numerador'] = 'N° de intervenciones en especialidad
    quirúrgicas suspendidas en el establecimiento en el periodo.';
$data4['label']['denominador'] = 'N° total de intervencines en
    especialidad quirúrgicas programadas en tabla en el periodo * 100.';

$data4['label']['fuente']['numerador'] = 'REM';
$data4['label']['fuente']['denominador'] = 'REM';

$data4['meta'] = '<=7%';
$data4['ponderacion'] = '7.5';

/* Inicializar los meses, si son menores al ultimo rem cargado */
for($mes = 1; $mes <= $ultimo_rem; $mes ++) {
    $data4['numeradores'][$mes] = 0;
    $data4['denominadores'][$mes] = 0;
}

$data4['numerador_acumulado'] = 0;
$data4['denominador_acumulado'] = 0;

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
    $data4['numeradores'][$valor->mes] = intval($valor->numerador);
    $data4['numerador_acumulado'] += intval($valor->numerador);
    $data4['denominadores'][$valor->mes] = intval($valor->denominador);
    $data4['denominador_acumulado'] += intval($valor->denominador);
}

/* Calcular el cumplimento */
if($data4['denominador_acumulado'] != 0) {
    $data4['cumplimiento'] = round($data4['numerador_acumulado'] /
                              $data4['denominador_acumulado'] * 100,1);
}

if( $data4['cumplimiento'] <= preg_replace("/[^0-9]/", '', $data4['meta'])) {
    $data4['aporte'] = $data4['ponderacion'];
}
else{
    $data4['aporte'] = 0;
}

/**** INDICADOR 6. ****/
$data6['label']['meta'] = '6. Variación porcentual del número de días
    promedio de espera para intervenciones quirúrgicas, según línea base.';
$data6['label']['numerador'] = 'Promedio de días de espera del total de las
    intervenciones quirúrgicas electivas del año t - 1 - promedio de días de
    espera del total de las intervenciones quirúrgicas electivas del año t.';
$data6['label']['denominador'] = 'promedio de días de espera del total de las
    intervenciones quirúrgicas electivas del año t-1 *100';

$data6['label']['fuente']['numerador'] = 'SIGTE';
$data6['label']['fuente']['denominador'] = 'SIGTE';

// $data6['meta'] = 'disminución 5 % respecto de línea base.';
$data6['meta'] = '5';
$data6['meta_nacional'] = '19';
$data6['ponderacion'] = '17';

$base_where = array(['law','19664'],['year',$year],['indicator',6],['establishment_id',9]);

$last_parameter = lastParameter(6);

for($i = 1; $i <= $last_parameter->month; $i++) {
    $where = array_merge($base_where,array(['month',$i],['position','numerador']));
    $value = SingleParameter::where($where)->first();
    if($value) $data6['numeradores'][$i] = $value->value;
    else       $data6['numeradores'][$i] = null;
}

/* 'mensual','semestral','anual','acumulada' */
$where = array_merge($base_where,array(['type','acumulada'],['position','numerador']));
$value = SingleParameter::where($where)->get()->last();

if($value){
    $data6['numerador_acumulado']   = $value->value;
    $data6['vigencia'] = $value->month;
}
else{
    $data6['numerador_acumulado']   = array_sum($data6['numeradores']);
    $data6['vigencia'] = 1;
}

/* 'mensual','semestral','anual','acumulada' */
$where = array_merge($base_where,array(['type','anual'],['position','denominador']));
$value = SingleParameter::where($where)->first();

if($value) $data6['denominador_acumulado'] = $value->value;
else       $data6['denominador_acumulado'] = 0;

if($data6['denominador_acumulado'] != 0) {
    $data6['cumplimiento'] = number_format(
        $data6['numerador_acumulado'] / $data6['denominador_acumulado'] * 100,2, ',', '.');
}
else $data6['cumplimiento'] = 0;

if( $data6['cumplimiento'] >= ($data6['meta_nacional'] - 5) && $data6['cumplimiento'] != 0) {
    $data6['aporte'] = $data6['ponderacion'];
}
else {
    $data6['aporte'] = 0;
}

/**** INDICADOR 8 ****/
$data8['label']['meta'] = '8. Porcentaje de Cumplimento de la
    Programación anual de Consulta Médicas realizadas por Especialista.';
$data8['label']['numerador'] = 'N° de consultas epecialista realizadas
    durante el periodo.';
$data8['label']['denominador'] = 'N° total de consultas de especialistas
    programadas y validadas para igual periodo * 100.';

$data8['label']['fuente']['numerador'] = 'REM';
$data8['label']['fuente']['denominador'] = 'Programacion Anual';

$data8['meta'] = '95';
$data8['ponderacion'] = '7%';

$data8['numerador_acumulado'] = 0;
$data8['denominador'] = '';

/* Inicializar los meses, si son menores al ultimo rem cargado */
for($mes = 1; $mes <= $ultimo_rem; $mes ++) {
    $data8['numeradores'][$mes] = 0;
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
    $data8['numeradores'][$valor->mes] = intval($valor->numerador);
    $data8['numerador_acumulado'] += intval($valor->numerador);
}

$base_where = array(['law','19664'],['year',$year],['indicator',8],['establishment_id',9],['position','denominador']);
$value = SingleParameter::where($base_where)->first();
if($value) $data8['denominador'] = $value->value;
else       $data8['denominador'] = 0;

/* Calcular el cumplimento */
if($data8['numerador_acumulado'] AND $data8['denominador'] != 0) {
    $data8['cumplimiento'] = $data8['numerador_acumulado'] / $data8['denominador'] * 100;
}
else {
    $data8['cumplimiento'] = 0;
}

if( $data8['cumplimiento'] >= preg_replace("/[^0-9]/", '', $data8['meta'])) {
    $data8['aporte'] = preg_replace("/[^0-9]/", '', $data8['ponderacion']);
}
else{
    $data8['aporte'] = $data8['cumplimiento'] *  preg_replace("/[^0-9]/", '', $data8['ponderacion']) / $data8['meta'];
}

/**** INDICADOR 10 ****/
$data10['label']['meta'] = '10. Porcentaje de Cumplimiento de la
    Programación anual de Consultas Médicas realizadas en modalidad
    Telemedicina.';
$data10['label']['numerador'] = 'N° total de consultas médicas (nuevas y controles)
    de especialidad realizadas a través de telemedicina, durante el periodo.';
$data10['label']['denominador'] = 'N° total de consultas de especialista
    programadas y validadas para igual periodo * 100.';

$data10['label']['fuente']['numerador'] = 'REM';
$data10['label']['fuente']['denominador'] = 'Programacion Anual';

$data10['meta'] = '≥95%';
$data10['ponderacion'] = '6.5';

$data10['numerador_acumulado'] = 0;
$data10['denominador'] = '';

/* Inicializar los meses, si son menores al ultimo rem cargado */
for($mes = 1; $mes <= $ultimo_rem; $mes ++) {
    $data10['numeradores'][$mes] = 0;
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
    $data10['numeradores'][$valor->mes] = intval($valor->numerador);
    $data10['numerador_acumulado'] += intval($valor->numerador);
}

$base_where = array(['law','19664'],['year',$year],['indicator',10],['establishment_id',9],['position','denominador']);
$value = SingleParameter::where($base_where)->first();
if($value) $data10['denominador'] = $value->value;
else       $data10['denominador'] = 0;

/* Calcular el cumplimento */
if($data10['numerador_acumulado'] AND $data10['denominador'] != 0) {
    $data10['cumplimiento'] = $data10['numerador_acumulado'] / $data10['denominador'] * 100;
}
else $data10['cumplimiento'] = 0;

if( $data10['cumplimiento'] >= preg_replace("/[^0-9]/", '', $data10['meta'])) {
    $data10['aporte'] = $data10['ponderacion'];
}
else{
    $data10['aporte'] = 0;
}
// dd($data10);
/**** INDICADOR 11 ****/
$data11['label']['meta'] = '11. Promedio de días de estada de pacientes
    derivados vía UGCC a prestadores privados fuera de convenio.';
$data11['label']['numerador'] = 'N° de días de hospitalización de
    pacientes derivados vía UGCC en el extrasistema.';
$data11['label']['denominador'] = 'N° total de pacientes derivados vía
    UGCC al extrasistema.';

$data11['label']['fuente']['numerador'] = 'UGCC Minsal';
$data11['label']['fuente']['denominador'] = 'UGCC Minsal';

$data11['meta'] = '<=10%';
$data11['ponderacion'] = '6.5';

$base_where = array(['law','19664'],['year',$year],['indicator',11],['establishment_id',9]);

$last_parameter = lastParameter(11);

for($i = 1; $i <= $last_parameter->month; $i++) {
    $where = array_merge($base_where,array(['month',$i],['position','numerador']));
    $value = SingleParameter::where($where)->first();
    if($value) $data11['numeradores'][$i] = $value->value;
    else       $data11['numeradores'][$i] = null;

    $where = array_merge($base_where,array(['month',$i],['position','denominador']));
    $value = SingleParameter::where($where)->first();
    if($value) $data11['denominadores'][$i] = $value->value;
    else       $data11['denominadores'][$i] = null;
}

$data11['numerador_acumulado']   = array_sum($data11['numeradores']);
$data11['denominador_acumulado'] = array_sum($data11['denominadores']);

if($data11['denominador_acumulado'] != 0) {
    $data11['cumplimiento'] = $data11['numerador_acumulado'] / $data11['denominador_acumulado'] * 100;
}
elseif($data11['denominador_acumulado'] == 0 && $data11['numerador_acumulado'] == 0) {
    $data11['cumplimiento'] = 100;
}
else $data11['cumplimiento'] = 0;

if( $data11['cumplimiento'] >= $data11['meta']) {
    $data11['aporte'] = $data11['ponderacion'];
}
elseif($data11['cumplimiento'] == NULL){
    $data11['aporte'] = 0;
}
else {
    $data11['aporte'] = ($data11['cumplimiento'] * $data11['ponderacion']) / 100;
}

/* INDICADOR 12 */
$data12['label']['meta'] = '12. Porcentaje de Gestión Efectiva para el
    Cumplimiento GES en la Red.';
$data12['label']['numerador'] = 'Garantías cumplidas + Garantías Exceptuadas +
    Garantías Incumplidas Atendidas.';
$data12['label']['denominador'] = '(Garantías Cumplidas + Garantías Exceptuadas +
    Garantías Incumplidas Atendidas + Garantías Incumplidas No Atendidas +
    Garantías Retrasadas) * 100.';

$data12['label']['fuente']['numerador'] = 'Datamart';
$data12['label']['fuente']['denominador'] = 'Datamart';

$data12['meta'] = '99.5';
$data12['ponderacion'] = '15%';

$base_where = array(['law','19664'],['year',$year],['indicator',12],['establishment_id',9]);

$last_parameter = lastParameter(12);

for($i = 1; $i <= $last_parameter->month; $i++) {
    $where = array_merge($base_where,array(['month',$i],['position','numerador']));
    $value = SingleParameter::where($where)->first();
    if($value) $data12['numeradores'][$i] = $value->value;
    else       $data12['numeradores'][$i] = null;

    $where = array_merge($base_where,array(['month',$i],['position','denominador']));
    $value = SingleParameter::where($where)->first();
    if($value) $data12['denominadores'][$i] = $value->value;
    else       $data12['denominadores'][$i] = null;
}

$data12['numerador_acumulado']   = array_sum($data12['numeradores']);
$data12['denominador_acumulado'] = array_sum($data12['denominadores']);

if($data12['denominador_acumulado'] != 0) {
    $data12['cumplimiento'] = $data12['numerador_acumulado'] / $data12['denominador_acumulado'] * 100;
}
else $data12['cumplimiento'] = 0;

if( $data12['cumplimiento'] >= $data12['meta']) {
    $data12['aporte'] = preg_replace("/[^0-9]/", '', $data12['ponderacion']);
}
else {
    $data12['aporte'] = $data12['cumplimiento'] *  preg_replace("/[^0-9]/", '', $data12['ponderacion']) / $data12['meta'];
}



?>
