<?php
namespace App\Http\Controllers\Indicators\_2020;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\Indicators\SingleParameter;

$year = 2020;

$label['programa'] = 'Programa Odontológico Integral.';

// Indicador 2
$ind = 2;
$label[$ind]['indicador'] = '2-. Atención odontológica integral en Hombres de escasos
    recursos.';
$label[$ind]['numerador'] = 'N° total de altas odontológicas integrales en Hombres
    de escasos recursos.';
$label[$ind]['denominador'] = 'N° total de altas odontológicas integrales comprometidas
    en Hombres de escasos recursos.';
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
$data_reyno2020[$ind]['denominador'] = 70;

/* ===== Query numerador ===== */
$sql_valores = "SELECT e.Comuna, e.alias_estab, r.Mes, sum(ifnull(Col01,0)) as numerador
                  FROM {$year}rems r
                  LEFT JOIN {$year}establecimientos e
                  ON r.IdEstablecimiento=e.Codigo
                  WHERE CodigoPrestacion in (09500503) AND e.Codigo = 102307
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
