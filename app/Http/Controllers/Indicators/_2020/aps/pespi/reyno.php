<?php
namespace App\Http\Controllers\Indicators\_2020;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\Indicators\SingleParameter;

$last_year = 2019;
$year = 2020;

$label['programa'] = 'Programa Especial de Salud y Pueblos Indígenas (PESPI).';

// Indicador 1

$ind = 1;
$label[$ind]['indicador'] = '1-. Atenciones de medicina indígena asociadas al PESPI.';
$label[$ind]['numerador'] = 'N° Atenciones por Agente Medicina Indígena 2020.';
$label[$ind]['denominador'] = 'N° Atenciones por Agente Medicina Indígena 2019.';
$label[$ind]['fuente_numerador'] = 'REM';
$label[$ind]['fuente_denominador'] = 'REM';

$label[$ind]['meta'] = '> o = 70%';

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
$sql_valores = "SELECT e.Comuna, e.alias_estab, r.Mes, sum(ifnull(Col01,0)) as numerador
                  FROM {$year}rems r
                  LEFT JOIN {$year}establecimientos e
                  ON r.IdEstablecimiento=e.Codigo
                  WHERE CodigoPrestacion in (04025070) AND e.Codigo = 102307
                  GROUP BY e.Comuna, e.alias_estab, r.Mes
                  ORDER BY e.Comuna, e.alias_estab, r.Mes";
$valores = DB::connection('mysql_rem')->select($sql_valores);

foreach($valores as $valor) {
    $data_reyno2020[$ind]['numeradores'][$valor->Mes] = intval($valor->numerador);
    $data_reyno2020[$ind]['numeradores']['total'] += intval($valor->numerador);
}

/* ===== Query denominador ===== */
$sql_valores = "SELECT e.Comuna, e.alias_estab, r.Mes, sum(ifnull(Col01,0)) as denominador
                  FROM {$last_year}rems r
                  LEFT JOIN {$last_year}establecimientos e
                  ON r.IdEstablecimiento=e.Codigo
                  WHERE CodigoPrestacion in (04025070) AND e.Codigo = 102307
                  AND Mes <= $ultimo_rem
                  GROUP BY e.Comuna, e.alias_estab, r.Mes
                  ORDER BY e.Comuna, e.alias_estab, r.Mes";
$valores = DB::connection('mysql_rem')->select($sql_valores);

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

// Indicador 2

$ind = 2;
$label[$ind]['indicador'] = '2-. Consejerías relizadas por la Facilitador/a Intercultural.';
$label[$ind]['numerador'] = 'N° Consejerías Facilitador/a Intercultural 2020.';
$label[$ind]['denominador'] = 'N° Consejerías Facilitador/a Intercultural 2019.';
$label[$ind]['fuente_numerador'] = 'REM';
$label[$ind]['fuente_denominador'] = 'REM';

$label[$ind]['meta'] = '> o = 50%';

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
$sql_valores = "SELECT e.Comuna, e.alias_estab, r.Mes, sum(ifnull(Col01,0)) as numerador
                  FROM {$year}rems r
                  LEFT JOIN {$year}establecimientos e
                  ON r.IdEstablecimiento=e.Codigo
                  WHERE CodigoPrestacion in (19120212, 19184801, 19120312, 19185801, 19120609, 19182021,
                     19120709, 19170401, 19170501) AND e.Codigo = 102307
                  GROUP BY e.Comuna, e.alias_estab, r.Mes
                  ORDER BY e.Comuna, e.alias_estab, r.Mes";
$valores = DB::connection('mysql_rem')->select($sql_valores);

foreach($valores as $valor) {
    $data_reyno2020[$ind]['numeradores'][$valor->Mes] = intval($valor->numerador);
    $data_reyno2020[$ind]['numeradores']['total'] += intval($valor->numerador);
}

/* ===== Query denominador ===== */
$sql_valores = "SELECT e.Comuna, e.alias_estab, r.Mes, sum(ifnull(Col01,0)) as denominador
                  FROM {$last_year}rems r
                  LEFT JOIN {$last_year}establecimientos e
                  ON r.IdEstablecimiento=e.Codigo
                  WHERE CodigoPrestacion in (19120212, 19184801, 19120312, 19185801, 19120609, 19182021,
                     19120709, 19170401, 19170501) AND e.Codigo = 102307
                  AND Mes <= $ultimo_rem
                  GROUP BY e.Comuna, e.alias_estab, r.Mes
                  ORDER BY e.Comuna, e.alias_estab, r.Mes";
$valores = DB::connection('mysql_rem')->select($sql_valores);

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
$label[$ind]['indicador'] = '3-. Actividades de participación social de pueblos Indígenas.';
$label[$ind]['numerador'] = 'N° Actividades de Pueblos Indígenas 2020.';
$label[$ind]['denominador'] = 'N° Actividades de Pueblos Indígenas 2019.';
$label[$ind]['fuente_numerador'] = 'REM';
$label[$ind]['fuente_denominador'] = 'REM';

$label[$ind]['meta'] = '> o = 50%';

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
$sql_valores = "SELECT e.Comuna, e.alias_estab, r.Mes, sum(ifnull(Col09,0)) as numerador
                  FROM {$year}rems r
                  LEFT JOIN {$year}establecimientos e
                  ON r.IdEstablecimiento=e.Codigo
                  WHERE CodigoPrestacion in (19181100) AND e.Codigo = 102307
                  GROUP BY e.Comuna, e.alias_estab, r.Mes
                  ORDER BY e.Comuna, e.alias_estab, r.Mes";
$valores = DB::connection('mysql_rem')->select($sql_valores);

foreach($valores as $valor) {
    $data_reyno2020[$ind]['numeradores'][$valor->Mes] = intval($valor->numerador);
    $data_reyno2020[$ind]['numeradores']['total'] += intval($valor->numerador);
}

/* ===== Query denominador ===== */
$sql_valores = "SELECT e.Comuna, e.alias_estab, r.Mes, sum(ifnull(Col09,0)) as denominador
                  FROM {$last_year}rems r
                  LEFT JOIN {$last_year}establecimientos e
                  ON r.IdEstablecimiento=e.Codigo
                  WHERE CodigoPrestacion in (19181100) AND e.Codigo = 102307
                  AND Mes <= $ultimo_rem
                  GROUP BY e.Comuna, e.alias_estab, r.Mes
                  ORDER BY e.Comuna, e.alias_estab, r.Mes";
$valores = DB::connection('mysql_rem')->select($sql_valores);

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
