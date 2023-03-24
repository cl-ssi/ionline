<?php
namespace App\Http\Controllers\Indicators\_2020;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\Indicators\SingleParameter;

$year = 2020;

$label['programa'] = 'GES Odontológico.';

// Indicador 1
$ind = 1;
$label[$ind]['indicador'] = '1-. Egresos odontologicos totales en niños y niñas
    de 6 años.';
$label[$ind]['numerador'] = 'N° de egresos odontologicos totales en niños y niñas
    6 años.';
$label[$ind]['denominador'] = 'Población inscrita validada año actual de niños y
    niñas de 6 años.';
$label[$ind]['fuente_numerador'] = 'REM';
$label[$ind]['fuente_denominador'] = 'FONASA';

$label[$ind]['meta'] = '79%';

$label[$ind]['ponderacion'] = '';

/* ==== Inicializar en 0 el arreglo de datos $data_reyno2020 ==== */
for($mes=1; $mes <= $ultimo_rem; $mes++) {
    $data_reyno2020[$ind]['numeradores']['total'] = 0;
    //$data_reyno2020[$ind]['denominadores']['total'] = 0;
    $data_reyno2020[$ind]['numeradores'][$mes] = 0;
    //$data_reyno2020[$ind]['denominadores'][$mes] = 0;
}

$data_reyno2020[$ind]['cumplimiento'] = 0;
$data_reyno2020[$ind]['denominador'] = 0;

/* ===== Query numerador ===== */
$sql_valores = "SELECT e.Comuna, e.alias_estab, r.Mes, sum(ifnull(Col16,0) + ifnull(Col17,0)) as numerador
                  FROM {$year}rems r
                  LEFT JOIN {$year}establecimientos e
                  ON r.IdEstablecimiento=e.Codigo
                  WHERE CodigoPrestacion in (09215413) AND e.Codigo = 102307
                  GROUP BY e.Comuna, e.alias_estab, r.Mes
                  ORDER BY e.Comuna, e.alias_estab, r.Mes";
$valores = DB::connection('mysql_rem')->select($sql_valores);

foreach($valores as $valor) {
    $data_reyno2020[$ind]['numeradores'][$valor->Mes] = intval($valor->numerador);
    $data_reyno2020[$ind]['numeradores']['total'] += intval($valor->numerador);
}


/* Calcular el cumplimento */
if($data_reyno2020[$ind]['denominador'] == 0) {
    $data_reyno2020[$ind]['cumplimiento'] = 0;
}
else {
    $data_reyno2020[$ind]['cumplimiento'] = $data_reyno2020[$ind]['numeradores']['total'] /
                                $data_reyno2020[$ind]['denominador'] * 100;
}

// Indicador 2
$ind = 2;
$label[$ind]['indicador'] = '2-. Altas odontologicas totales en embarazadas.';
$label[$ind]['numerador'] = 'N° de altas odontologicos totales en embarazadas.';
$label[$ind]['denominador'] = 'Gestantes ingresadas a programa prenatal.';
$label[$ind]['fuente_numerador'] = 'REM';
$label[$ind]['fuente_denominador'] = 'REM';

$label[$ind]['meta'] = '68%';

$label[$ind]['ponderacion'] = '';

/* ==== Inicializar en 0 el arreglo de datos $data_reyno2020 ==== */
for($mes=1; $mes <= $ultimo_rem; $mes++) {
    $data_reyno2020[$ind]['numeradores']['total'] = 0;
    $data_reyno2020[$ind]['denominadores']['total'] = 0;
    $data_reyno2020[$ind]['numeradores'][$mes] = 0;
    $data_reyno2020[$ind]['denominadores'][$mes] = 0;
}
$data_reyno2020[$ind]['cumplimiento'] = 0;

/* ===== Query numerador ===== */
$sql_numeradores = "SELECT e.Comuna, e.alias_estab, r.Mes, sum(ifnull(Col28,0)) as numerador
                  FROM {$year}rems r
                  LEFT JOIN {$year}establecimientos e
                  ON r.IdEstablecimiento=e.Codigo
                  WHERE CodigoPrestacion in (09215313, 09215413) AND e.Codigo = 102307
                  GROUP BY e.Comuna, e.alias_estab, r.Mes
                  ORDER BY e.Comuna, e.alias_estab, r.Mes";
$valores = DB::connection('mysql_rem')->select($sql_numeradores);

foreach($valores as $valor) {
    $data_reyno2020[$ind]['numeradores'][$valor->Mes] = intval($valor->numerador);
    $data_reyno2020[$ind]['numeradores']['total'] += intval($valor->numerador);
}

/* ===== Query denominador ===== */
$sql_denominadores = "SELECT e.Comuna, e.alias_estab, r.Mes, sum(ifnull(Col01,0)) as denominador
                  FROM {$year}rems r
                  LEFT JOIN {$year}establecimientos e
                  ON r.IdEstablecimiento=e.Codigo
                  WHERE CodigoPrestacion in (01080008) AND e.Codigo = 102307
                  GROUP BY e.Comuna, e.alias_estab, r.Mes
                  ORDER BY e.Comuna, e.alias_estab, r.Mes";
$valores = DB::connection('mysql_rem')->select($sql_denominadores);

foreach($valores as $valor) {
    $data_reyno2020[$ind]['denominadores'][$valor->Mes] = intval($valor->denominador);
    $data_reyno2020[$ind]['denominadores']['total'] += intval($valor->denominador);
}

/* Calcular el cumplimento */
if($data_reyno2020[$ind]['denominadores']['total'] == 0) {
    $data_reyno2020[$ind]['cumplimiento'] = 0;
}
else {
    $data_reyno2020[$ind]['cumplimiento'] = $data_reyno2020[$ind]['numeradores']['total'] /
                                $data_reyno2020[$ind]['denominadores']['total'] * 100;
}

// Indicador 3
$ind = 3;
$label[$ind]['indicador'] = '3-. Proporción de Consulta odontologica de urgencia GES.';
$label[$ind]['numerador'] = 'N° total de consultas odontologicas de urgencia GES.';
$label[$ind]['denominador'] = 'Población inscrita validada.';
$label[$ind]['fuente_numerador'] = 'REM';
$label[$ind]['fuente_denominador'] = 'FONASA';

$label[$ind]['meta'] = '2%';

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
                  WHERE CodigoPrestacion in (09230300) AND e.Codigo = 102307
                  GROUP BY e.Comuna, e.alias_estab, r.Mes
                  ORDER BY e.Comuna, e.alias_estab, r.Mes";
$valores = DB::connection('mysql_rem')->select($sql_valores);

foreach($valores as $valor) {
    $data_reyno2020[$ind]['numeradores'][$valor->Mes] = intval($valor->numerador);
    $data_reyno2020[$ind]['numeradores']['total'] += intval($valor->numerador);
}

$data_reyno2020[$ind]['denominador'] = 0;


/* Calcular el cumplimento */
if($data_reyno2020[$ind]['denominador'] == 0) {
    $data_reyno2020[$ind]['cumplimiento'] = 0;
}
else {
    $data_reyno2020[$ind]['cumplimiento'] = $data_reyno2020[$ind]['numeradores']['total'] /
                                $data_reyno2020[$ind]['denominador'] * 100;
}

// Indicador 4
$ind = 4;
$label[$ind]['indicador'] = '4-. Altas odontologicas totales en adulto Ges de 60 años..';
$label[$ind]['numerador'] = 'N° de altas odontologicas integrales GES de adultos
    de 60 años.';
$label[$ind]['denominador'] = 'N° de altas odontologicas integrales GES de adultos
    de 60 años comprometidas.';
$label[$ind]['fuente_numerador'] = 'REM';
$label[$ind]['fuente_denominador'] = 'FONASA';

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
                  WHERE CodigoPrestacion in (09300500) AND e.Codigo = 102307
                  GROUP BY e.Comuna, e.alias_estab, r.Mes
                  ORDER BY e.Comuna, e.alias_estab, r.Mes";
$valores = DB::connection('mysql_rem')->select($sql_valores);

foreach($valores as $valor) {
    $data_reyno2020[$ind]['numeradores'][$valor->Mes] = intval($valor->numerador);
    $data_reyno2020[$ind]['numeradores']['total'] += intval($valor->numerador);
}

$data_reyno2020[$ind]['denominador'] = 45;


/* Calcular el cumplimento */
if($data_reyno2020[$ind]['denominador'] == 0) {
    $data_reyno2020[$ind]['cumplimiento'] = 0;
}
else {
    $data_reyno2020[$ind]['cumplimiento'] = $data_reyno2020[$ind]['numeradores']['total'] /
                                $data_reyno2020[$ind]['denominador'] * 100;
}
