<?php
namespace App\Http\Controllers\Indicators\_2020;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\Indicators\SingleParameter;

$year = 2020;

$label['programa'] = 'Programa Resolutividad en APS.';

// Indicador 1

$ind = 1;
$label[$ind]['indicador'] = '1-. Cumplimiento de la actividad medica proyectada en Oftalmología.';
$label[$ind]['numerador'] = 'N° de consultas medicas realizadas Vicio de refracción.';
$label[$ind]['denominador'] = 'N° de consultas medicas comprometidas Vicio de refracción.';
$label[$ind]['fuente_numerador'] = 'REM';
$label[$ind]['fuente_denominador'] = '';

$label[$ind]['meta'] = '100%';

$label[$ind]['ponderacion'] = '';

/* ==== Inicializar en 0 el arreglo de datos $data_reyno2020 ==== */
for($mes=1; $mes <= $ultimo_rem; $mes++) {
    $data_reyno2020[$ind]['numeradores']['total'] = 0;
    //$data_reyno2020[$ind]['denominadores']['total'] = 0;
    $data_reyno2020[$ind]['numeradores'][$mes] = 0;
    //$data_reyno2020[$ind]['denominadores'][$mes] = 0;
}

$data_reyno2020[$ind]['cumplimiento'] = 0;

/* ===== Query numerador ===== */
$sql_valores = "SELECT e.Comuna, e.alias_estab, r.Mes, sum(ifnull(Col01,0)) as numerador
                  FROM {$year}rems r
                  LEFT JOIN {$year}establecimientos e
                  ON r.IdEstablecimiento=e.Codigo
                  WHERE CodigoPrestacion in (29000000) AND e.Codigo = 102307
                  GROUP BY e.Comuna, e.alias_estab, r.Mes
                  ORDER BY e.Comuna, e.alias_estab, r.Mes";
$valores = DB::connection('mysql_rem')->select($sql_valores);

foreach($valores as $valor) {
    $data_reyno2020[$ind]['numeradores'][$valor->Mes] = intval($valor->numerador);
    $data_reyno2020[$ind]['numeradores']['total'] += intval($valor->numerador);
}

/* ===== denominador ===== */
$data_reyno2020[$ind]['denominador'] = 500;

/* Calcular el cumplimento */
if($data_reyno2020[$ind]['denominador'] == 0) {
    $data_reyno2020[$ind]['cumplimiento'] = 0;
}
else {
    $data_reyno2020[$ind]['cumplimiento'] = $data_reyno2020[$ind]['numeradores']['total'] /
                                $data_reyno2020[$ind]['denominador'] * 100;
}

// Indicador 7

$ind = 7;
$label[$ind]['indicador'] = '7-. Cumplimientos de la actividad proyectada en Gastroenterologia.';
$label[$ind]['numerador'] = 'Nº de consultas gastroenterología realizadas en el programa.';
$label[$ind]['denominador'] = 'Nº de consultas gastroenterología comprometidas en el programa.';
$label[$ind]['fuente_numerador'] = 'REM';
$label[$ind]['fuente_denominador'] = '';

$label[$ind]['meta'] = '100%';

$label[$ind]['ponderacion'] = '';

/* ==== Inicializar en 0 el arreglo de datos $data_reyno2020 ==== */
for($mes=1; $mes <= $ultimo_rem; $mes++) {
    $data_reyno2020[$ind]['numeradores']['total'] = 0;
    //$data_reyno2020[$ind]['denominadores']['total'] = 0;
    $data_reyno2020[$ind]['numeradores'][$mes] = 0;
    //$data_reyno2020[$ind]['denominadores'][$mes] = 0;
}

$data_reyno2020[$ind]['cumplimiento'] = 0;

/* ===== Query numerador ===== */
$sql_valores = "SELECT e.Comuna, e.alias_estab, r.Mes, sum(ifnull(Col01,0)) as numerador
                  FROM {$year}rems r
                  LEFT JOIN {$year}establecimientos e
                  ON r.IdEstablecimiento=e.Codigo
                  WHERE CodigoPrestacion in (29000021) AND e.Codigo = 102307
                  GROUP BY e.Comuna, e.alias_estab, r.Mes
                  ORDER BY e.Comuna, e.alias_estab, r.Mes";
$valores = DB::connection('mysql_rem')->select($sql_valores);

foreach($valores as $valor) {
    $data_reyno2020[$ind]['numeradores'][$valor->Mes] = intval($valor->numerador);
    $data_reyno2020[$ind]['numeradores']['total'] += intval($valor->numerador);
}

/* ===== denominador ===== */
$data_reyno2020[$ind]['denominador'] = 80;

/* Calcular el cumplimento */
if($data_reyno2020[$ind]['denominador'] == 0) {
    $data_reyno2020[$ind]['cumplimiento'] = 0;
}
else {
    $data_reyno2020[$ind]['cumplimiento'] = $data_reyno2020[$ind]['numeradores']['total'] /
                                $data_reyno2020[$ind]['denominador'] * 100;
}

// Indicador 8

$ind = 8;
$label[$ind]['indicador'] = '8-. Cumplimiento de la actividad proyectada en Otorrinolaringologia.';
$label[$ind]['numerador'] = 'N° de consultas Otorrinolangologia realizadas en el programa.';
$label[$ind]['denominador'] = 'N° de consultas Otorrinolangologia comprometida en el programa.';
$label[$ind]['fuente_numerador'] = 'REM';
$label[$ind]['fuente_denominador'] = '';

$label[$ind]['meta'] = '100%';

$label[$ind]['ponderacion'] = '';

/* ==== Inicializar en 0 el arreglo de datos $data_reyno2020 ==== */
for($mes=1; $mes <= $ultimo_rem; $mes++) {
    $data_reyno2020[$ind]['numeradores']['total'] = 0;
    //$data_reyno2020[$ind]['denominadores']['total'] = 0;
    $data_reyno2020[$ind]['numeradores'][$mes] = 0;
    //$data_reyno2020[$ind]['denominadores'][$mes] = 0;
}

$data_reyno2020[$ind]['cumplimiento'] = 0;

/* ===== Query numerador ===== */
$sql_valores = "SELECT e.Comuna, e.alias_estab, r.Mes, sum(ifnull(Col01,0)) as numerador
                  FROM {$year}rems r
                  LEFT JOIN {$year}establecimientos e
                  ON r.IdEstablecimiento=e.Codigo
                  WHERE CodigoPrestacion in (29000001) AND e.Codigo = 102307
                  GROUP BY e.Comuna, e.alias_estab, r.Mes
                  ORDER BY e.Comuna, e.alias_estab, r.Mes";
$valores = DB::connection('mysql_rem')->select($sql_valores);

foreach($valores as $valor) {
    $data_reyno2020[$ind]['numeradores'][$valor->Mes] = intval($valor->numerador);
    $data_reyno2020[$ind]['numeradores']['total'] += intval($valor->numerador);
}

/* ===== denominador ===== */
$data_reyno2020[$ind]['denominador'] = 75;

/* Calcular el cumplimento */
if($data_reyno2020[$ind]['denominador'] == 0) {
    $data_reyno2020[$ind]['cumplimiento'] = 0;
}
else {
    $data_reyno2020[$ind]['cumplimiento'] = $data_reyno2020[$ind]['numeradores']['total'] /
                                $data_reyno2020[$ind]['denominador'] * 100;
}

// Indicador 9

$ind = 9;
$label[$ind]['indicador'] = '9- Nº de procedimientos cutáneos quirúrgicos de baja complejidad comprometidas.';
$label[$ind]['numerador'] = 'Nº de procedimientos cutáneos quirúrgicos de baja complejidad realizadas.';
$label[$ind]['denominador'] = 'Nº de procedimientos cutáneos quirúrgicos de baja complejidad comprometidas.';
$label[$ind]['fuente_numerador'] = 'REM';
$label[$ind]['fuente_denominador'] = '';

$label[$ind]['meta'] = '100%';

$label[$ind]['ponderacion'] = '';

/* ==== Inicializar en 0 el arreglo de datos $data_reyno2020 ==== */
for($mes=1; $mes <= $ultimo_rem; $mes++) {
    $data_reyno2020[$ind]['numeradores']['total'] = 0;
    //$data_reyno2020[$ind]['denominadores']['total'] = 0;
    $data_reyno2020[$ind]['numeradores'][$mes] = 0;
    //$data_reyno2020[$ind]['denominadores'][$mes] = 0;
}

$data_reyno2020[$ind]['cumplimiento'] = 0;

/* ===== Query numerador ===== */
$sql_valores = "SELECT e.Comuna, e.alias_estab, r.Mes, sum(ifnull(Col01,0)) as numerador
                  FROM {$year}rems r
                  LEFT JOIN {$year}establecimientos e
                  ON r.IdEstablecimiento=e.Codigo
                  WHERE CodigoPrestacion in (29000027) AND e.Codigo = 102307
                  GROUP BY e.Comuna, e.alias_estab, r.Mes
                  ORDER BY e.Comuna, e.alias_estab, r.Mes";
$valores = DB::connection('mysql_rem')->select($sql_valores);

foreach($valores as $valor) {
    $data_reyno2020[$ind]['numeradores'][$valor->Mes] = intval($valor->numerador);
    $data_reyno2020[$ind]['numeradores']['total'] += intval($valor->numerador);
}

/* ===== denominador ===== */
$data_reyno2020[$ind]['denominador'] = 200;

/* Calcular el cumplimento */
if($data_reyno2020[$ind]['denominador'] == 0) {
    $data_reyno2020[$ind]['cumplimiento'] = 0;
}
else {
    $data_reyno2020[$ind]['cumplimiento'] = $data_reyno2020[$ind]['numeradores']['total'] /
                                $data_reyno2020[$ind]['denominador'] * 100;
}
