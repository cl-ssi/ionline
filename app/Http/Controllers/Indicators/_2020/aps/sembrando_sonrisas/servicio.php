<?php
namespace App\Http\Controllers\Indicators\_2020;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\Indicators\SingleParameter;

$year = 2020;

$label['programa'] = 'Sembrando sonrisas.';

// Indicador 1
$ind = 1;
$label[$ind]['indicador'] = '1-. Promoción y prevencion en salud bucal en la
    población parvularia.';
$label[$ind]['numerador'] = 'N° de sets de higiene oral entregados a niñas y
    niños de 2 a 5 años.';
$label[$ind]['denominador'] = 'N° de sets de higiene oral comprometidos a niñas
    y niños de 2 a 5 años.';
$label[$ind]['fuente_numerador'] = 'REM';
$label[$ind]['fuente_denominador'] = '';

$label[$ind]['meta'] = '79%';

$label[$ind]['ponderacion'] = '';

/* ==== Inicializar en 0 el arreglo de datos $data_servicio2020 ==== */
for($mes=1; $mes <= $ultimo_rem; $mes++) {
    $data_servicio2020[$ind]['numeradores']['total'] = 0;
    //$data_servicio2020[$ind]['denominadores']['total'] = 0;
    $data_servicio2020[$ind]['numeradores'][$mes] = 0;
    //$data_servicio2020[$ind]['denominadores'][$mes] = 0;
}

$data_servicio2020[$ind]['cumplimiento'] = 0;

/* ===== Query numerador ===== */
$sql_valores = "SELECT e.Comuna, e.alias_estab, r.Mes, sum(ifnull(Col01,0)) as numerador
                  FROM {$year}rems r
                  LEFT JOIN {$year}establecimientos e
                  ON r.IdEstablecimiento=e.Codigo
                  WHERE CodigoPrestacion in (09306600) AND e.Codigo = 102010
                  GROUP BY e.Comuna, e.alias_estab, r.Mes
                  ORDER BY e.Comuna, e.alias_estab, r.Mes";
$valores = DB::connection('mysql_rem')->select($sql_valores);

foreach($valores as $valor) {
    $data_servicio2020[$ind]['numeradores'][$valor->Mes] = intval($valor->numerador);
    $data_servicio2020[$ind]['numeradores']['total'] += intval($valor->numerador);
}

$data_servicio2020[$ind]['denominador'] = 1081;

/* Calcular el cumplimento */
if($data_servicio2020[$ind]['denominador'] == 0) {
    $data_servicio2020[$ind]['cumplimiento'] = 0;
}
else {
    $data_servicio2020[$ind]['cumplimiento'] = $data_servicio2020[$ind]['numeradores']['total'] /
                                $data_servicio2020[$ind]['denominador'] * 100;
}

// Indicador 2
$ind = 2;
$label[$ind]['indicador'] = '2-. Dianostico de la salud bucal en población parvularia
    en contexto comunitario.';
$label[$ind]['numerador'] = 'N° de niñas y niños de 2 a 5 años con examen de salud
    bucal realizados.';
$label[$ind]['denominador'] = 'N° de niñas y niños de 2 a 5 años con examen de
    salud bucal comprometidos.';
$label[$ind]['fuente_numerador'] = 'REM';
$label[$ind]['fuente_denominador'] = '';

$label[$ind]['meta'] = '79%';

$label[$ind]['ponderacion'] = '';

/* ==== Inicializar en 0 el arreglo de datos $data_servicio2020 ==== */
for($mes=1; $mes <= $ultimo_rem; $mes++) {
    $data_servicio2020[$ind]['numeradores']['total'] = 0;
    //$data_servicio2020[$ind]['denominadores']['total'] = 0;
    $data_servicio2020[$ind]['numeradores'][$mes] = 0;
    //$data_servicio2020[$ind]['denominadores'][$mes] = 0;
}

$data_servicio2020[$ind]['cumplimiento'] = 0;

/* ===== Query numerador ===== */
$sql_valores = "SELECT e.Comuna, e.alias_estab, r.Mes, sum(ifnull(Col01,0)) as numerador
                  FROM {$year}rems r
                  LEFT JOIN {$year}establecimientos e
                  ON r.IdEstablecimiento=e.Codigo
                  WHERE CodigoPrestacion in (09400090) AND e.Codigo = 102010
                  GROUP BY e.Comuna, e.alias_estab, r.Mes
                  ORDER BY e.Comuna, e.alias_estab, r.Mes";
$valores = DB::connection('mysql_rem')->select($sql_valores);

foreach($valores as $valor) {
    $data_servicio2020[$ind]['numeradores'][$valor->Mes] = intval($valor->numerador);
    $data_servicio2020[$ind]['numeradores']['total'] += intval($valor->numerador);
}

$data_servicio2020[$ind]['denominador'] = 1081;

/* Calcular el cumplimento */
if($data_servicio2020[$ind]['denominador'] == 0) {
    $data_servicio2020[$ind]['cumplimiento'] = 0;
}
else {
    $data_servicio2020[$ind]['cumplimiento'] = $data_servicio2020[$ind]['numeradores']['total'] /
                                $data_servicio2020[$ind]['denominador'] * 100;
}

// Indicador 3
$ind = 3;
$label[$ind]['indicador'] = '3-. Prevención individual especifica en población
    parvularia.';
$label[$ind]['numerador'] = 'N° de aplicaciones de flúor barniz a niñas y niños
    de 2 a 5 años realizados.';
$label[$ind]['denominador'] = 'N° de aplicaciones de flúor barniz a niñas y niños
    de 2 a 5 años comprometidos.';
$label[$ind]['fuente_numerador'] = 'REM';
$label[$ind]['fuente_denominador'] = '';

$label[$ind]['meta'] = '79%';

$label[$ind]['ponderacion'] = '';

/* ==== Inicializar en 0 el arreglo de datos $data_servicio2020 ==== */
for($mes=1; $mes <= $ultimo_rem; $mes++) {
    $data_servicio2020[$ind]['numeradores']['total'] = 0;
    //$data_servicio2020[$ind]['denominadores']['total'] = 0;
    $data_servicio2020[$ind]['numeradores'][$mes] = 0;
    //$data_servicio2020[$ind]['denominadores'][$mes] = 0;
}

$data_servicio2020[$ind]['cumplimiento'] = 0;

/* ===== Query numerador ===== */
$sql_valores = "SELECT e.Comuna, e.alias_estab, r.Mes, sum(ifnull(Col01,0)) as numerador
                  FROM {$year}rems r
                  LEFT JOIN {$year}establecimientos e
                  ON r.IdEstablecimiento=e.Codigo
                  WHERE CodigoPrestacion in (09306800) AND e.Codigo = 102010
                  GROUP BY e.Comuna, e.alias_estab, r.Mes
                  ORDER BY e.Comuna, e.alias_estab, r.Mes";
$valores = DB::connection('mysql_rem')->select($sql_valores);

foreach($valores as $valor) {
    $data_servicio2020[$ind]['numeradores'][$valor->Mes] = intval($valor->numerador);
    $data_servicio2020[$ind]['numeradores']['total'] += intval($valor->numerador);
}

$data_servicio2020[$ind]['denominador'] = 2162;

/* Calcular el cumplimento */
if($data_servicio2020[$ind]['denominador'] == 0) {
    $data_servicio2020[$ind]['cumplimiento'] = 0;
}
else {
    $data_servicio2020[$ind]['cumplimiento'] = $data_servicio2020[$ind]['numeradores']['total'] /
                                $data_servicio2020[$ind]['denominador'] * 100;
}
