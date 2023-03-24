<?php
namespace App\Http\Controllers\Indicators\_2020;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\Indicators\SingleParameter;

$year = 2020;

$label['programa'] = 'Chile Crece Contigo (ChCC).';

// Indicador 1

$ind = 1;
$label[$ind]['indicador'] = 'H1-. Porcentaje de mujeres gestantes beneficiarias
    que asisten a taller en las Maternidades del Servicio de Salud.';
$label[$ind]['numerador'] = 'Número de mujeres gestantes primigestas beneficiarias
    que asisten a taller en la Maternidades del Servicio de Salud.';
$label[$ind]['denominador'] = 'Número de mujeres gestantes primigestas ingresadas a programa prenatal.';
$label[$ind]['fuente_numerador'] = 'REM';
$label[$ind]['fuente_denominador'] = 'REM';
$label[$ind]['meta'] = '40%';
$label[$ind]['ponderacion'] = '10%';

/* ==== Inicializar en 0 el arreglo de datos $data_hosp2020 ==== */
for($mes=1; $mes <= $ultimo_rem; $mes++) {
    $data_hosp2020[$ind]['numeradores']['total'] = 0;
    $data_hosp2020[$ind]['denominadores']['total'] = 0;
    $data_hosp2020[$ind]['numeradores'][$mes] = 0;
    $data_hosp2020[$ind]['denominadores'][$mes] = 0;
}
$data_hosp2020[$ind]['cumplimiento'] = 0;

/* ===== Query numerador ===== */
$sql_valores = "SELECT e.Comuna, e.alias_estab, r.Mes, sum(ifnull(Col23,0)) as numerador
                  FROM {$year}rems r
                  LEFT JOIN {$year}establecimientos e
                  ON r.IdEstablecimiento=e.Codigo
                  WHERE CodigoPrestacion in (27500110) AND e.Codigo = 102100
                  GROUP BY e.Comuna, e.alias_estab, r.Mes
                  ORDER BY e.Comuna, e.alias_estab, r.Mes";
$valores = DB::connection('mysql_rem')->select($sql_valores);

foreach($valores as $valor) {
    $data_hosp2020[$ind]['numeradores'][$valor->Mes] = intval($valor->numerador);
    $data_hosp2020[$ind]['numeradores']['total'] += intval($valor->numerador);
}

/* ===== Query denominador ===== */
$sql_denominador = "SELECT r.Mes, sum(ifnull(Col01,0)) as denominador
                    FROM {$year}rems r
                    LEFT JOIN {$year}establecimientos e
                    ON r.IdEstablecimiento=e.Codigo
                    WHERE CodigoPrestacion in (01080010)
                    GROUP BY r.Mes
                    ORDER BY r.Mes";
$valores = DB::connection('mysql_rem')->select($sql_denominador);

foreach($valores as $valor) {
    $data_hosp2020[$ind]['denominadores'][$valor->Mes] = intval($valor->denominador);
    $data_hosp2020[$ind]['denominadores']['total'] += intval($valor->denominador);
}

/* Calcular el cumplimento */
if($data_hosp2020[$ind]['denominadores']['total'] != 0) {
    $data_hosp2020[$ind]['cumplimiento'] = $data_hosp2020[$ind]['numeradores']['total'] /
                              $data_hosp2020[$ind]['denominadores']['total'] * 100;
}

// Indicador 2
$ind = 2;
$label[$ind]['indicador'] = 'H2-. Porcentaje de partos con acompañamiento durante
    preparto y parto de mujeres beneficiarias.';
$label[$ind]['numerador'] = 'Número de partos con acompañamiento durante preparto
    y parto de mujeres beneficiarias.';
$label[$ind]['denominador'] = 'Número de partos de mujeres beneficiarias.';
$label[$ind]['fuente_numerador'] = 'REM';
$label[$ind]['fuente_denominador'] = 'REM';
$label[$ind]['meta'] = '80%';
$label[$ind]['ponderacion'] = '15%';

/* ==== Inicializar en 0 el arreglo de datos $data_hosp2020 ==== */
for($mes=1; $mes <= $ultimo_rem; $mes++) {
    $data_hosp2020[$ind]['numeradores']['total'] = 0;
    $data_hosp2020[$ind]['denominadores']['total'] = 0;
    $data_hosp2020[$ind]['numeradores'][$mes] = 0;
    $data_hosp2020[$ind]['denominadores'][$mes] = 0;
}
$data_hosp2020[$ind]['cumplimiento'] = 0;

/* ===== Query numerador ===== */
$sql_valores = "SELECT e.Comuna, e.alias_estab, r.Mes, sum(ifnull(Col02,0)) as numerador
                  FROM {$year}rems r
                  LEFT JOIN {$year}establecimientos e
                  ON r.IdEstablecimiento=e.Codigo
                  WHERE CodigoPrestacion in (01090020) AND e.Codigo = 102100
                  GROUP BY e.Comuna, e.alias_estab, r.Mes
                  ORDER BY e.Comuna, e.alias_estab, r.Mes";
$valores = DB::connection('mysql_rem')->select($sql_valores);

foreach($valores as $valor) {
    $data_hosp2020[$ind]['numeradores'][$valor->Mes] = intval($valor->numerador);
    $data_hosp2020[$ind]['numeradores']['total'] += intval($valor->numerador);
}

/* ===== Query denominador ===== */
$sql_denominador = "SELECT e.Comuna, e.alias_estab, r.Mes, sum(ifnull(Col02,0)) as denominador
                    FROM {$year}rems r
                    LEFT JOIN {$year}establecimientos e
                    ON r.IdEstablecimiento=e.Codigo
                    WHERE CodigoPrestacion in (01030100, 01030200, 01030300, 24090700) AND e.Codigo = 102100
                    GROUP BY e.Comuna, e.alias_estab, r.Mes
                    ORDER BY e.Comuna, e.alias_estab, r.Mes";
$valores = DB::connection('mysql_rem')->select($sql_denominador);

foreach($valores as $valor) {
    $data_hosp2020[$ind]['denominadores'][$valor->Mes] = intval($valor->denominador);
    $data_hosp2020[$ind]['denominadores']['total'] += intval($valor->denominador);
}

/* Calcular el cumplimento */
if($data_hosp2020[$ind]['denominadores']['total'] != 0) {
    $data_hosp2020[$ind]['cumplimiento'] = $data_hosp2020[$ind]['numeradores']['total'] /
                              $data_hosp2020[$ind]['denominadores']['total'] * 100;
}

// Indicador 3
$ind = 3;
$label[$ind]['indicador'] = 'H3-. Porcentaje de recién nacidos y nacidas con peso
    mayor o igual a 2.500 gramos con contacto piel a piel mayor o igual a 30 minutos
     supervisado por equipo.';
$label[$ind]['numerador'] = 'Número de recién nacidos con peso mayor o igual a 2.500
    gramos con contacto piel a piel mayor o igual a 30 minutos.';
$label[$ind]['denominador'] = 'Número de nacidos y nacidas con peso mayor o igual
    a 2.500 gr.';
$label[$ind]['fuente_numerador'] = 'REM';
$label[$ind]['fuente_denominador'] = 'REM';
$label[$ind]['meta'] = '80%';
$label[$ind]['ponderacion'] = '20%';

/* ==== Inicializar en 0 el arreglo de datos $data_hosp2020 ==== */
for($mes=1; $mes <= $ultimo_rem; $mes++) {
    $data_hosp2020[$ind]['numeradores']['total'] = 0;
    $data_hosp2020[$ind]['denominadores']['total'] = 0;
    $data_hosp2020[$ind]['numeradores'][$mes] = 0;
    $data_hosp2020[$ind]['denominadores'][$mes] = 0;
}
$data_hosp2020[$ind]['cumplimiento'] = 0;

/* ===== Query numerador ===== */
$sql_valores = "SELECT e.Comuna, e.alias_estab, r.Mes, sum(ifnull(Col16,0)) as numerador
                  FROM {$year}rems r
                  LEFT JOIN {$year}establecimientos e
                  ON r.IdEstablecimiento=e.Codigo
                  WHERE CodigoPrestacion in (01030100, 01030200, 01030300, 24090700) AND e.Codigo = 102100
                  GROUP BY e.Comuna, e.alias_estab, r.Mes
                  ORDER BY e.Comuna, e.alias_estab, r.Mes";
$valores = DB::connection('mysql_rem')->select($sql_valores);

foreach($valores as $valor) {
    $data_hosp2020[$ind]['numeradores'][$valor->Mes] = intval($valor->numerador);
    $data_hosp2020[$ind]['numeradores']['total'] += intval($valor->numerador);
}

/* ===== Query denominador ===== */
$sql_denominador = "SELECT e.Comuna, e.alias_estab, r.Mes, sum(ifnull(Col07,0) + ifnull(Col08,0) + ifnull(Col09,0)) as denominador
                    FROM {$year}rems r
                    LEFT JOIN {$year}establecimientos e
                    ON r.IdEstablecimiento=e.Codigo
                    WHERE CodigoPrestacion in (01060100) AND e.Codigo = 102100
                    GROUP BY e.Comuna, e.alias_estab, r.Mes
                    ORDER BY e.Comuna, e.alias_estab, r.Mes";
$valores = DB::connection('mysql_rem')->select($sql_denominador);

foreach($valores as $valor) {
    $data_hosp2020[$ind]['denominadores'][$valor->Mes] = intval($valor->denominador);
    $data_hosp2020[$ind]['denominadores']['total'] += intval($valor->denominador);
}

/* Calcular el cumplimento */
if($data_hosp2020[$ind]['denominadores']['total'] != 0) {
    $data_hosp2020[$ind]['cumplimiento'] = $data_hosp2020[$ind]['numeradores']['total'] /
                              $data_hosp2020[$ind]['denominadores']['total'] * 100;
}

// Indicador 4
$ind = 4;
$label[$ind]['indicador'] = 'H4-. Porcentaje de egresos de maternidad con lactancia
    materna exclusiva.';
$label[$ind]['numerador'] = 'Número de egresos de maternidad con lactancia materna
    exclusiva.';
$label[$ind]['denominador'] = 'Número de egresos de maternidad.';
$label[$ind]['fuente_numerador'] = 'REM';
$label[$ind]['fuente_denominador'] = 'REM';
$label[$ind]['meta'] = '93%';
$label[$ind]['ponderacion'] = '10%';

/* ==== Inicializar en 0 el arreglo de datos $data_hosp2020 ==== */
for($mes=1; $mes <= $ultimo_rem; $mes++) {
    $data_hosp2020[$ind]['numeradores']['total'] = 0;
    $data_hosp2020[$ind]['denominadores']['total'] = 0;
    $data_hosp2020[$ind]['numeradores'][$mes] = 0;
    $data_hosp2020[$ind]['denominadores'][$mes] = 0;
}
$data_hosp2020[$ind]['cumplimiento'] = 0;

/* ===== Query numerador ===== */
$sql_valores = "SELECT e.Comuna, e.alias_estab, r.Mes, sum(ifnull(Col01,0)) as numerador
                  FROM {$year}rems r
                  LEFT JOIN {$year}establecimientos e
                  ON r.IdEstablecimiento=e.Codigo
                  WHERE CodigoPrestacion in (24200100) AND e.Codigo = 102100
                  GROUP BY e.Comuna, e.alias_estab, r.Mes
                  ORDER BY e.Comuna, e.alias_estab, r.Mes";
$valores = DB::connection('mysql_rem')->select($sql_valores);

foreach($valores as $valor) {
    $data_hosp2020[$ind]['numeradores'][$valor->Mes] = intval($valor->numerador);
    $data_hosp2020[$ind]['numeradores']['total'] += intval($valor->numerador);
}

/* ===== Query denominador ===== */
$sql_denominador = "SELECT e.Comuna, e.alias_estab, r.Mes, sum(ifnull(Col01,0)) as denominador
                    FROM {$year}rems r
                    LEFT JOIN {$year}establecimientos e
                    ON r.IdEstablecimiento=e.Codigo
                    WHERE CodigoPrestacion in (24200134) AND e.Codigo = 102100
                    GROUP BY e.Comuna, e.alias_estab, r.Mes
                    ORDER BY e.Comuna, e.alias_estab, r.Mes";
$valores = DB::connection('mysql_rem')->select($sql_denominador);

foreach($valores as $valor) {
    $data_hosp2020[$ind]['denominadores'][$valor->Mes] = intval($valor->denominador);
    $data_hosp2020[$ind]['denominadores']['total'] += intval($valor->denominador);
}

/* Calcular el cumplimento */
if($data_hosp2020[$ind]['denominadores']['total'] != 0) {
    $data_hosp2020[$ind]['cumplimiento'] = $data_hosp2020[$ind]['numeradores']['total'] /
                              $data_hosp2020[$ind]['denominadores']['total'] * 100;
}

// Indicador 5
$ind = 5;
$label[$ind]['indicador'] = 'H5-. Porcentaje de mujeres que recibe el set de implementos
    del Programa de Apoyo al Recién Nacido (PARN) y que participan en sesión educativa
     en puerperio.';
$label[$ind]['numerador'] = 'Número de mujeres que recibe el set de implementos
    Programa de Apoyo al Recién Nacido (PARN) y que participan en sesión educativa
     en puerperio.';
$label[$ind]['denominador'] = 'Número de mujeres que recibe el set de implementos
    Programa de Apoyo al Recién Nacido (PARN).';
$label[$ind]['fuente_numerador'] = 'SR PARN';
$label[$ind]['fuente_denominador'] = 'SR PARN';
$label[$ind]['meta'] = '90%';
$label[$ind]['ponderacion'] = '15%';

/* ==== Inicializar en 0 el arreglo de datos $data_hosp2020 ==== */
for($mes=1; $mes <= $ultimo_rem; $mes++) {
    $data_hosp2020[$ind]['numeradores']['total'] = 0;
    $data_hosp2020[$ind]['denominadores']['total'] = 0;
    $data_hosp2020[$ind]['numeradores'][$mes] = 0;
    $data_hosp2020[$ind]['denominadores'][$mes] = 0;
}
$data_hosp2020[$ind]['cumplimiento'] = 0;

/* ===== Query numerador ===== */
$sql_valores = "SELECT e.Comuna, e.alias_estab, r.Mes, sum(ifnull(Col01,0)) as numerador
                  FROM {$year}rems r
                  LEFT JOIN {$year}establecimientos e
                  ON r.IdEstablecimiento=e.Codigo
                  WHERE CodigoPrestacion in ('') AND e.Codigo = 102100
                  GROUP BY e.Comuna, e.alias_estab, r.Mes
                  ORDER BY e.Comuna, e.alias_estab, r.Mes";
$valores = DB::connection('mysql_rem')->select($sql_valores);

foreach($valores as $valor) {
    $data_hosp2020[$ind]['numeradores'][$valor->Mes] = intval($valor->numerador);
    $data_hosp2020[$ind]['numeradores']['total'] += intval($valor->numerador);
}

/* ===== Query denominador ===== */
$sql_denominador = "SELECT e.Comuna, e.alias_estab, r.Mes, sum(ifnull(Col01,0)) as denominador
                    FROM {$year}rems r
                    LEFT JOIN {$year}establecimientos e
                    ON r.IdEstablecimiento=e.Codigo
                    WHERE CodigoPrestacion in ('') AND e.Codigo = 102100
                    GROUP BY e.Comuna, e.alias_estab, r.Mes
                    ORDER BY e.Comuna, e.alias_estab, r.Mes";
$valores = DB::connection('mysql_rem')->select($sql_denominador);

foreach($valores as $valor) {
    $data_hosp2020[$ind]['denominadores'][$valor->Mes] = intval($valor->denominador);
    $data_hosp2020[$ind]['denominadores']['total'] += intval($valor->denominador);
}

/* Calcular el cumplimento */
if($data_hosp2020[$ind]['denominadores']['total'] != 0) {
    $data_hosp2020[$ind]['cumplimiento'] = $data_hosp2020[$ind]['numeradores']['total'] /
                              $data_hosp2020[$ind]['denominadores']['total'] * 100;
}

// Indicador 6
$ind = 6;
$label[$ind]['indicador'] = 'H6-. Porcentaje de recien nacidos vivos  que recibe
    el set de implementos del Programa de Apoyo al Recién Nacido (PARN) en el
    Servicio de Salud.';
$label[$ind]['numerador'] = 'Número de set de implementos de apoyo al recien nacido
    (PARN) entregados  en las maternidades de la red pública  del Servicio de Salud.';
$label[$ind]['denominador'] = 'Número de nacidos vivos en los hospitales de la red
    pública del Servicio de Salud.';
$label[$ind]['fuente_numerador'] = 'SR PARN';
$label[$ind]['fuente_denominador'] = 'REM';
$label[$ind]['meta'] = '95%';
$label[$ind]['ponderacion'] = '15%';

/* ==== Inicializar en 0 el arreglo de datos $data_hosp2020 ==== */
for($mes=1; $mes <= $ultimo_rem; $mes++) {
    $data_hosp2020[$ind]['numeradores']['total'] = 0;
    $data_hosp2020[$ind]['denominadores']['total'] = 0;
    $data_hosp2020[$ind]['numeradores'][$mes] = 0;
    $data_hosp2020[$ind]['denominadores'][$mes] = 0;
}
$data_hosp2020[$ind]['cumplimiento'] = 0;

/* ===== Query numerador ===== */
$sql_valores = "SELECT e.Comuna, e.alias_estab, r.Mes, sum(ifnull(Col01,0)) as numerador
                  FROM {$year}rems r
                  LEFT JOIN {$year}establecimientos e
                  ON r.IdEstablecimiento=e.Codigo
                  WHERE CodigoPrestacion in ('') AND e.Codigo = 102100
                  GROUP BY e.Comuna, e.alias_estab, r.Mes
                  ORDER BY e.Comuna, e.alias_estab, r.Mes";
$valores = DB::connection('mysql_rem')->select($sql_valores);

foreach($valores as $valor) {
    $data_hosp2020[$ind]['numeradores'][$valor->Mes] = intval($valor->numerador);
    $data_hosp2020[$ind]['numeradores']['total'] += intval($valor->numerador);
}

/* ===== Query denominador ===== */
$sql_denominador = "SELECT e.Comuna, e.alias_estab, r.Mes, sum(ifnull(Col01,0)) as denominador
                    FROM {$year}rems r
                    LEFT JOIN {$year}establecimientos e
                    ON r.IdEstablecimiento=e.Codigo
                    WHERE CodigoPrestacion in (01060100) AND e.Codigo = 102100
                    GROUP BY e.Comuna, e.alias_estab, r.Mes
                    ORDER BY e.Comuna, e.alias_estab, r.Mes";
$valores = DB::connection('mysql_rem')->select($sql_denominador);

foreach($valores as $valor) {
    $data_hosp2020[$ind]['denominadores'][$valor->Mes] = intval($valor->denominador);
    $data_hosp2020[$ind]['denominadores']['total'] += intval($valor->denominador);
}

/* Calcular el cumplimento */
if($data_hosp2020[$ind]['denominadores']['total'] != 0) {
    $data_hosp2020[$ind]['cumplimiento'] = $data_hosp2020[$ind]['numeradores']['total'] /
                              $data_hosp2020[$ind]['denominadores']['total'] * 100;
}

// Indicador 7
$ind = 7;
$label[$ind]['indicador'] = 'H7-. Porcentaje de recien nacidos/as y de niños/as
    menores de 5 años   egresados de los Servicios de Pediatría o Neonatología
    atendidos por profesional del equipo psicosocial.';
$label[$ind]['numerador'] = 'Número de recien nacidos/as y de niños/as menores de
    5 años egresados de los Servicios de Pediatría o Neonatología atendidos por
    profesional del equipo psicosocial.';
$label[$ind]['denominador'] = 'Total de recien nacidos/as y de niños/as menores
    de 5 años   egresados de los Servicios de Pediatría o Neonatología.';
$label[$ind]['fuente_numerador'] = 'REM';
$label[$ind]['fuente_denominador'] = 'REM';
$label[$ind]['meta'] = '50%';
$label[$ind]['ponderacion'] = '30%';

/* ==== Inicializar en 0 el arreglo de datos $data_hosp2020 ==== */
for($mes=1; $mes <= $ultimo_rem; $mes++) {
    $data_hosp2020[$ind]['numeradores']['total'] = 0;
    $data_hosp2020[$ind]['denominadores']['total'] = 0;
    $data_hosp2020[$ind]['numeradores'][$mes] = 0;
    $data_hosp2020[$ind]['denominadores'][$mes] = 0;
}
$data_hosp2020[$ind]['cumplimiento'] = 0;

/* ===== Query numerador ===== */
$sql_valores = "SELECT e.Comuna, e.alias_estab, r.Mes, sum(ifnull(Col02,0) + ifnull(Col03,0) +
                    ifnull(Col04,0)) as numerador
                  FROM {$year}rems r
                  LEFT JOIN {$year}establecimientos e
                  ON r.IdEstablecimiento=e.Codigo
                  WHERE CodigoPrestacion in (21800850, 21800860) AND e.Codigo = 102100
                  GROUP BY e.Comuna, e.alias_estab, r.Mes
                  ORDER BY e.Comuna, e.alias_estab, r.Mes";
$valores = DB::connection('mysql_rem')->select($sql_valores);

foreach($valores as $valor) {
    $data_hosp2020[$ind]['numeradores'][$valor->Mes] = intval($valor->numerador);
    $data_hosp2020[$ind]['numeradores']['total'] += intval($valor->numerador);
}

/* ===== Query denominador ===== */
$sql_denominador = "SELECT e.Comuna, e.alias_estab, r.Mes, sum(ifnull(Col02,0) + ifnull(Col03,0) +
                        ifnull(Col04,0)) as denominador
                    FROM {$year}rems r
                    LEFT JOIN {$year}establecimientos e
                    ON r.IdEstablecimiento=e.Codigo
                    WHERE CodigoPrestacion in (21500300) AND e.Codigo = 102100
                    GROUP BY e.Comuna, e.alias_estab, r.Mes
                    ORDER BY e.Comuna, e.alias_estab, r.Mes";
$valores = DB::connection('mysql_rem')->select($sql_denominador);

foreach($valores as $valor) {
    $data_hosp2020[$ind]['denominadores'][$valor->Mes] = intval($valor->denominador);
    $data_hosp2020[$ind]['denominadores']['total'] += intval($valor->denominador);
}

/* Calcular el cumplimento */
if($data_hosp2020[$ind]['denominadores']['total'] != 0) {
    $data_hosp2020[$ind]['cumplimiento'] = $data_hosp2020[$ind]['numeradores']['total'] /
                              $data_hosp2020[$ind]['denominadores']['total'] * 100;
}

// Indicador 8
$ind = 8;
$label[$ind]['indicador'] = 'H8-. Porcentaje de egresos de neonatología con lactancia
    materna exclusiva.';
$label[$ind]['numerador'] = 'Número de egresos de neonatología con lactancia materna
    exclusiva.';
$label[$ind]['denominador'] = 'Número de egresos de neonatología.';
$label[$ind]['fuente_numerador'] = 'REM';
$label[$ind]['fuente_denominador'] = 'REM';
$label[$ind]['meta'] = '70%';
$label[$ind]['ponderacion'] = '15%';

/* ==== Inicializar en 0 el arreglo de datos $data_hosp2020 ==== */
for($mes=1; $mes <= $ultimo_rem; $mes++) {
    $data_hosp2020[$ind]['numeradores']['total'] = 0;
    $data_hosp2020[$ind]['denominadores']['total'] = 0;
    $data_hosp2020[$ind]['numeradores'][$mes] = 0;
    $data_hosp2020[$ind]['denominadores'][$mes] = 0;
}
$data_hosp2020[$ind]['cumplimiento'] = 0;

/* ===== Query numerador ===== */
$sql_valores = "SELECT e.Comuna, e.alias_estab, r.Mes, sum(ifnull(Col02,0)) as numerador
                  FROM {$year}rems r
                  LEFT JOIN {$year}establecimientos e
                  ON r.IdEstablecimiento=e.Codigo
                  WHERE CodigoPrestacion in (24200100) AND e.Codigo = 102100
                  GROUP BY e.Comuna, e.alias_estab, r.Mes
                  ORDER BY e.Comuna, e.alias_estab, r.Mes";
$valores = DB::connection('mysql_rem')->select($sql_valores);

foreach($valores as $valor) {
    $data_hosp2020[$ind]['numeradores'][$valor->Mes] = intval($valor->numerador);
    $data_hosp2020[$ind]['numeradores']['total'] += intval($valor->numerador);
}

/* ===== Query denominador ===== */
$sql_denominador = "SELECT e.Comuna, e.alias_estab, r.Mes, sum(ifnull(Col02,0)) as denominador
                    FROM {$year}rems r
                    LEFT JOIN {$year}establecimientos e
                    ON r.IdEstablecimiento=e.Codigo
                    WHERE CodigoPrestacion in (24200134) AND e.Codigo = 102100
                    GROUP BY e.Comuna, e.alias_estab, r.Mes
                    ORDER BY e.Comuna, e.alias_estab, r.Mes";
$valores = DB::connection('mysql_rem')->select($sql_denominador);

foreach($valores as $valor) {
    $data_hosp2020[$ind]['denominadores'][$valor->Mes] = intval($valor->denominador);
    $data_hosp2020[$ind]['denominadores']['total'] += intval($valor->denominador);
}

/* Calcular el cumplimento */
if($data_hosp2020[$ind]['denominadores']['total'] != 0) {
    $data_hosp2020[$ind]['cumplimiento'] = $data_hosp2020[$ind]['numeradores']['total'] /
                              $data_hosp2020[$ind]['denominadores']['total'] * 100;
}
