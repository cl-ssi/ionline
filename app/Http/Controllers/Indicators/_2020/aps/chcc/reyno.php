<?php
namespace App\Http\Controllers\Indicators\_2020;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\Indicators\SingleParameter;

$year = 2020;

$label['programa'] = 'Chile Crece Contigo (ChCC).';

// Indicador 1
// $ind = 1;
// $label[$ind]['meta'] = 'A1-. Promedio de Visitas domiciliaria integrales (VDI)
//     realizadas a familias con gestantes en situación de riesgo psicosocial según
//     EPSA que presentan al menos 3 riesgos sicosociales.';
// $label[$ind]['numerador'] = 'Número de Visitas domiciliaria integrales (VDI) realizadas
//     a familias con gestantes en situación de riesgo psicosocial según EPSA aplicada
//      en el primer control prenatal con al menos 3 riesgos.';
// $label[$ind]['denominador'] = 'Número de gestantes con situación de riesgo psicosocial
//     según EPSA al ingreso a control prenatal con al menos 3 riesgos.';
// $label[$ind]['fuente_numerador'] = 'SRDM';
// $label[$ind]['fuente_denominador'] = 'SRDM';
// $label[$ind]['ponderacion'] = '15%';
//
// $meses = array(1,2,3,4,5,6,7,8,9,10,11,12);
// $flag1 = NULL;
// $flag2 = NULL;
// $data_reyno2020 = array();
//
// $sql_establecimientos =
// "SELECT comuna, alias_estab
//  FROM {$year}establecimientos
//  WHERE p_chcc = 1
//  ORDER BY comuna";
//
// $establecimientos = DB::connection('mysql_rem')->select($sql_establecimientos);
//
// /* ==== Inicializar en 0 el arreglo de datos $data_reyno2020 ==== */
// foreach($establecimientos as $establecimiento) {
//     $data_reyno2020[$establecimiento->comuna][$ind]['numeradores']['total'] = 0;
//     $data_reyno2020[$establecimiento->comuna][$ind]['denominadores']['total'] = 0;
//     $data_reyno2020[$establecimiento->comuna][$ind]['cumplimiento'] = 0;
//     for($mes=1; $mes <= $ultimo_rem; $mes++) {
//         $data_reyno2020[$establecimiento->comuna][$ind]['numeradores'][$mes] = 0;
//         $data_reyno2020[$establecimiento->comuna][$ind]['denominadores'][$mes] = 0;
//         $data_reyno2020[$establecimiento->comuna][$ind][$establecimiento->alias_estab]['numeradores']['total'] = 0;
//         $data_reyno2020[$establecimiento->comuna][$ind][$establecimiento->alias_estab]['denominadores']['total'] = 0;
//         $data_reyno2020[$establecimiento->comuna][$ind][$establecimiento->alias_estab]['numeradores'][$mes] = 0;
//         $data_reyno2020[$establecimiento->comuna][$ind][$establecimiento->alias_estab]['denominadores'][$mes] = 0;
//     }
//     $data_reyno2020[$establecimiento->comuna][$ind][$establecimiento->alias_estab]['cumplimiento'] = 0;
// }
//
// if($ultimo_rem >= 1 && $ultimo_rem <= 7){
//     $data_reyno2020['ALTO HOSPICIO'][$ind]['meta'] = 'Abr: 1';
//     $data_reyno2020['CAMIÑA'][$ind]['meta'] = 'Abr: 1';
//     $data_reyno2020['COLCHANE'][$ind]['meta'] = 'Abr: 1';
//     $data_reyno2020['HUARA'][$ind]['meta'] = 'Abr: 1';
//     $data_reyno2020['IQUIQUE'][$ind]['meta'] = 'Abr: 1';
//     $data_reyno2020['PICA'][$ind]['meta'] = 'Abr: 1';
//     $data_reyno2020['POZO ALMONTE'][$ind]['meta'] = 'Abr: 1';
// }
// if($ultimo_rem >= 8 && $ultimo_rem <= 11){
//     $data_reyno2020['ALTO HOSPICIO'][$ind]['meta'] = 'Ago: 3';
//     $data_reyno2020['CAMIÑA'][$ind]['meta'] = 'Ago: 3';
//     $data_reyno2020['COLCHANE'][$ind]['meta'] = 'Ago: 3';
//     $data_reyno2020['HUARA'][$ind]['meta'] = 'Ago: 3';
//     $data_reyno2020['IQUIQUE'][$ind]['meta'] = 'Ago: 3';
//     $data_reyno2020['PICA'][$ind]['meta'] = 'Ago: 3';
//     $data_reyno2020['POZO ALMONTE'][$ind]['meta'] = 'Ago: 3';
// }
// if($ultimo_rem >= 12){
//     $data_reyno2020['ALTO HOSPICIO'][$ind]['meta'] = 'Dic: 4';
//     $data_reyno2020['CAMIÑA'][$ind]['meta'] = 'Dic: 4';
//     $data_reyno2020['COLCHANE'][$ind]['meta'] = 'Dic: 4';
//     $data_reyno2020['HUARA'][$ind]['meta'] = 'Dic: 4';
//     $data_reyno2020['IQUIQUE'][$ind]['meta'] = 'Dic: 4';
//     $data_reyno2020['PICA'][$ind]['meta'] = 'Dic: 4';
//     $data_reyno2020['POZO ALMONTE'][$ind]['meta'] = 'Dic: 4';
// }
//
// /* ===== Query numerador ===== */
// $sql_numerador = "SELECT e.Comuna, e.alias_estab, r.Mes, sum(ifnull(Col01,0)) as numerador
//                   FROM {$year}rems r
//                   LEFT JOIN {$year}establecimientos e
//                   ON r.IdEstablecimiento=e.Codigo
//                   WHERE CodigoPrestacion in ('') AND e.p_chcc= 1
//                   GROUP BY e.Comuna, e.alias_estab, r.Mes
//                   ORDER BY e.Comuna, e.alias_estab, r.Mes";
// $numeradores = DB::connection('mysql_rem')->select($sql_numerador);
//
// foreach($numeradores as $registro) {
//     if( ($flag1 != $registro->Comuna) OR ($flag2 != $registro->alias_estab) ) {
//         for($mes=1; $mes <= $ultimo_rem; $mes++) {
//             $data_reyno2020[$registro->Comuna][$ind][$registro->alias_estab]['numeradores'][$mes] = 0;
//         }
//         $flag1 = $registro->Comuna;
//         $flag2 = $registro->alias_estab;
//     }
//     $data_reyno2020[$registro->Comuna][$ind][$registro->alias_estab]['numeradores'][$registro->Mes] = $registro->numerador;
// }
//
// /* ===== Query denominador ===== */
// $sql_denominador = "SELECT e.Comuna, e.alias_estab, r.Mes, sum(ifnull(Col01,0)) as denominador
//     FROM {$year}rems r
//     LEFT JOIN {$year}establecimientos e
//     ON r.IdEstablecimiento=e.Codigo
//     WHERE CodigoPrestacion in ('') AND e.p_chcc = 1
//     GROUP BY e.Comuna, e.alias_estab, r.Mes
//     ORDER BY e.Comuna, e.alias_estab, r.Mes";
// $denominadores = DB::connection('mysql_rem')->select($sql_denominador);
//
// foreach($denominadores as $registro) {
//     if( ($flag1 != $registro->Comuna) OR ($flag2 != $registro->alias_estab) ) {
//         for($mes=1; $mes <= $ultimo_rem; $mes++) {
//             $data_reyno2020[$registro->Comuna][$ind][$registro->alias_estab]['denominadores'][$mes] = 0;
//         }
//         $flag1 = $registro->Comuna;
//         $flag2 = $registro->alias_estab;
//     }
//     $data_reyno2020[$registro->Comuna][$ind][$registro->alias_estab]['denominadores'][$registro->Mes] = $registro->denominador;
// }
//
// /* ==== Calculos ==== */
// foreach($data_reyno2020 as $nombre_comuna => $comuna) {
//   foreach($comuna as $nro_ind => $indicador) {
//     foreach($indicador as $nombre_establecimiento => $establecimiento) {
//         /* Existe en el array un indice ['numerador'], ['denominador'] y ['meta'],
//          * estos almacenan la información de la comuna, por lo tanto tengo que saltarlos
//          * en la iteración del foreach y continuar con los establecimientos */
//         /* Realizar los calculos mensuales */
//         if($nombre_establecimiento != 'numeradores' AND
//             $nombre_establecimiento != 'denominadores' AND
//             $nombre_establecimiento != 'meta' AND
//             $nombre_establecimiento != 'cumplimiento' AND
//             $nro_ind == $ind){
//
//             /* Calcula los totales de cada establecimiento */
//             $data_reyno2020[$nombre_comuna][$ind][$nombre_establecimiento]['denominadores']['total'] = array_sum($establecimiento['denominadores']);
//             $data_reyno2020[$nombre_comuna][$ind][$nombre_establecimiento]['numeradores']['total'] = array_sum($establecimiento['numeradores']);
//
//             /* Calcula los totales de cada comuna */
//             $data_reyno2020[$nombre_comuna][$ind]['numeradores']['total'] += $data_reyno2020[$nombre_comuna][$ind][$nombre_establecimiento]['numeradores']['total'];
//             $data_reyno2020[$nombre_comuna][$ind]['denominadores']['total'] += $data_reyno2020[$nombre_comuna][$ind][$nombre_establecimiento]['denominadores']['total'];
//
//             /* Calcula la suma mensual por comuna */
//             for($mes=1; $mes <= $ultimo_rem; $mes++) {
//                 $data_reyno2020[$nombre_comuna][$ind]['numeradores'][$mes] += $establecimiento['numeradores'][$mes];
//                 $data_reyno2020[$nombre_comuna][$ind]['denominadores'][$mes] += $establecimiento['denominadores'][$mes];
//             }
//
//             /* Calculo de las metas de cada establecimiento */
//             if($data_reyno2020[$nombre_comuna][$ind][$nombre_establecimiento]['denominadores']['total'] == 0) {
//                 /* Si es 0 el denominadore entonces la cumplimiento es 0 */
//                 $data_reyno2020[$nombre_comuna][$ind][$nombre_establecimiento]['cumplimiento'] = 0;
//             }
//             else {
//                 /* De lo contrario calcular el porcentaje */
//                 $data_reyno2020[$nombre_comuna][$ind][$nombre_establecimiento]['cumplimiento'] =
//                     $data_reyno2020[$nombre_comuna][$ind][$nombre_establecimiento]['numeradores']['total'] / $data_reyno2020[$nombre_comuna][$ind][$nombre_establecimiento]['denominadores']['total'] * 100;
//             }
//
//             /* Calculo de las metas de la comuna */
//             if($data_reyno2020[$nombre_comuna][$ind]['denominadores']['total'] == 0) {
//                 /* Si es 0 el denominadore entonces la cumplimiento es 0 */
//                 $data_reyno2020[$nombre_comuna][$ind]['cumplimiento'] = 0;
//             }
//             else {
//                 /* De lo contrario calcular el porcentaje */
//                 $data_reyno2020[$nombre_comuna][$ind]['cumplimiento'] = $data_reyno2020[$nombre_comuna][$ind]['numeradores']['total'] / $data_reyno2020[$nombre_comuna][$ind]['denominadores']['total'] * 100;
//             }
//         }
//     }
//   }
// }

// Indicador 2
$ind = 2;
$label[$ind]['indicador'] = 'A2-. Porcentaje de gestantes que ingresan a educación
    grupal: temáticas de  autocuidado, preparación para el parto  y apoyo a la
    crianza en la atención primaria.';
$label[$ind]['numerador'] = 'Número de gestantes que ingresan a educación grupal:
    temáticas de  autocuidado, preparación para el parto  y apoyo a la crianza
    en la atención primaria.';
$label[$ind]['denominador'] = 'Total  de gestantes ingresadas a control prenatal.';
$label[$ind]['fuente_numerador'] = 'REM';
$label[$ind]['fuente_denominador'] = 'REM';
$label[$ind]['meta'] = '80%';
$label[$ind]['ponderacion'] = '15%';

/* ==== Inicializar en 0 el arreglo de datos $data_reyno2020 ==== */
for($mes=1; $mes <= $ultimo_rem; $mes++) {
    $data_reyno2020[$ind]['numeradores']['total'] = 0;
    $data_reyno2020[$ind]['denominadores']['total'] = 0;
    $data_reyno2020[$ind]['numeradores'][$mes] = 0;
    $data_reyno2020[$ind]['denominadores'][$mes] = 0;
}
$data_reyno2020[$ind]['cumplimiento'] = 0;

/* ===== Query numerador ===== */
$sql_valores = "SELECT e.Comuna, e.alias_estab, r.Mes, sum(ifnull(Col22,0)) as numerador
                  FROM {$year}rems r
                  LEFT JOIN {$year}establecimientos e
                  ON r.IdEstablecimiento=e.Codigo
                  WHERE CodigoPrestacion in (27500110) AND e.Codigo = 102307
                  GROUP BY e.Comuna, e.alias_estab, r.Mes
                  ORDER BY e.Comuna, e.alias_estab, r.Mes";
$valores = DB::connection('mysql_rem')->select($sql_valores);

foreach($valores as $valor) {
    $data_reyno2020[$ind]['numeradores'][$valor->Mes] = intval($valor->numerador);
    $data_reyno2020[$ind]['numeradores']['total'] += intval($valor->numerador);
}

/* ===== Query denominador ===== */
$sql_denominador = "SELECT e.Comuna, e.alias_estab, r.Mes, sum(ifnull(Col01,0)) as denominador
                    FROM {$year}rems r
                    LEFT JOIN {$year}establecimientos e
                    ON r.IdEstablecimiento=e.Codigo
                    WHERE CodigoPrestacion in (01080008) AND e.Codigo = 102307
                    GROUP BY e.Comuna, e.alias_estab, r.Mes
                    ORDER BY e.Comuna, e.alias_estab, r.Mes";
$valores = DB::connection('mysql_rem')->select($sql_denominador);

foreach($valores as $valor) {
    $data_reyno2020[$ind]['denominadores'][$valor->Mes] = intval($valor->denominador);
    $data_reyno2020[$ind]['denominadores']['total'] += intval($valor->denominador);
}

/* Calcular el cumplimento */
if($data_reyno2020[$ind]['denominadores']['total'] != 0) {
    $data_reyno2020[$ind]['cumplimiento'] = $data_reyno2020[$ind]['numeradores']['total'] /
                              $data_reyno2020[$ind]['denominadores']['total'] * 100;
}


// Indicador 3

$ind = 3;
$label[$ind]['indicador'] = 'A3-. Porcentaje de controles de salud realizados en presencia
    de pareja, familiar u otra figura significativa de la gestante.';
$label[$ind]['numerador'] = 'Número de controles de salud realizados en presencia
    de pareja, familiar u otra figura significativa de la gestante.';
$label[$ind]['denominador'] = 'Número de controles prenatales realizados.';
$label[$ind]['fuente_numerador'] = 'REM';
$label[$ind]['fuente_denominador'] = 'REM';
$label[$ind]['meta'] = '30%';
$label[$ind]['ponderacion'] = '15%';

/* ==== Inicializar en 0 el arreglo de datos $data_reyno2020 ==== */
for($mes=1; $mes <= $ultimo_rem; $mes++) {
    $data_reyno2020[$ind]['numeradores']['total'] = 0;
    $data_reyno2020[$ind]['denominadores']['total'] = 0;
    $data_reyno2020[$ind]['numeradores'][$mes] = 0;
    $data_reyno2020[$ind]['denominadores'][$mes] = 0;
}
$data_reyno2020[$ind]['cumplimiento'] = 0;

/* ===== Query numerador ===== */
$sql_valores = "SELECT e.Comuna, e.alias_estab, r.Mes, sum(ifnull(Col21,0)) as numerador
                  FROM {$year}rems r
                  LEFT JOIN {$year}establecimientos e
                  ON r.IdEstablecimiento=e.Codigo
                  WHERE CodigoPrestacion in (01010201, 01010203) AND e.Codigo = 102307
                  GROUP BY e.Comuna, e.alias_estab, r.Mes
                  ORDER BY e.Comuna, e.alias_estab, r.Mes";
$valores = DB::connection('mysql_rem')->select($sql_valores);

foreach($valores as $valor) {
    $data_reyno2020[$ind]['numeradores'][$valor->Mes] = intval($valor->numerador);
    $data_reyno2020[$ind]['numeradores']['total'] += intval($valor->numerador);
}

/* ===== Query denominador ===== */
$sql_denominador = "SELECT e.Comuna, e.alias_estab, r.Mes, sum(ifnull(Col01,0)) as denominador
                    FROM {$year}rems r
                    LEFT JOIN {$year}establecimientos e
                    ON r.IdEstablecimiento=e.Codigo
                    WHERE CodigoPrestacion in (01010201, 01010203) AND e.Codigo = 102307
                    GROUP BY e.Comuna, e.alias_estab, r.Mes
                    ORDER BY e.Comuna, e.alias_estab, r.Mes";
$valores = DB::connection('mysql_rem')->select($sql_denominador);

foreach($valores as $valor) {
    $data_reyno2020[$ind]['denominadores'][$valor->Mes] = intval($valor->denominador);
    $data_reyno2020[$ind]['denominadores']['total'] += intval($valor->denominador);
}

/* Calcular el cumplimento */
if($data_reyno2020[$ind]['denominadores']['total'] != 0) {
    $data_reyno2020[$ind]['cumplimiento'] = $data_reyno2020[$ind]['numeradores']['total'] /
                              $data_reyno2020[$ind]['denominadores']['total'] * 100;
}

// Indicador 4

$ind = 4;
$label[$ind]['indicador'] = 'A4-. Porcentaje de controles de salud entregados a díadas
    dentro de los 10 días de vida del recién nacido o nacida.';
$label[$ind]['numerador'] = 'Número de díadas controladas dentro de los 10 días
    de vida del recién nacido(a).';
$label[$ind]['denominador'] = 'Número de recién nacidos ingresados a control salud.';
$label[$ind]['fuente_numerador'] = 'REM';
$label[$ind]['fuente_denominador'] = 'REM';
$label[$ind]['meta'] = '70%';
$label[$ind]['ponderacion'] = '15%';

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
                  WHERE CodigoPrestacion in (01110106, 01110107) AND e.Codigo = 102307
                  GROUP BY e.Comuna, e.alias_estab, r.Mes
                  ORDER BY e.Comuna, e.alias_estab, r.Mes";
$valores = DB::connection('mysql_rem')->select($sql_valores);

foreach($valores as $valor) {
    $data_reyno2020[$ind]['numeradores'][$valor->Mes] = intval($valor->numerador);
    $data_reyno2020[$ind]['numeradores']['total'] += intval($valor->numerador);
}

/* ===== Query denominador ===== */
$sql_denominador = "SELECT e.Comuna, e.alias_estab, r.Mes, sum(ifnull(Col01,0)) as denominador
                    FROM {$year}rems r
                    LEFT JOIN {$year}establecimientos e
                    ON r.IdEstablecimiento=e.Codigo
                    WHERE CodigoPrestacion in (05225100) AND e.Codigo = 102307
                    GROUP BY e.Comuna, e.alias_estab, r.Mes
                    ORDER BY e.Comuna, e.alias_estab, r.Mes";
$valores = DB::connection('mysql_rem')->select($sql_denominador);

foreach($valores as $valor) {
    $data_reyno2020[$ind]['denominadores'][$valor->Mes] = intval($valor->denominador);
    $data_reyno2020[$ind]['denominadores']['total'] += intval($valor->denominador);
}

/* Calcular el cumplimento */
if($data_reyno2020[$ind]['denominadores']['total'] != 0) {
    $data_reyno2020[$ind]['cumplimiento'] = $data_reyno2020[$ind]['numeradores']['total'] /
                              $data_reyno2020[$ind]['denominadores']['total'] * 100;
}

// Indicador 5

$ind = 5;
$label[$ind]['indicador'] = 'A5-. Porcentaje de controles de salud entregados a niños
    y niñas menores de 4 años en el que participa el padre.';
$label[$ind]['numerador'] = 'Número de controles de salud entregados a niñas y niños
    menores de 4 años en los que participa el padre.';
$label[$ind]['denominador'] = 'Número de controles de salud entregados a niños(as)
    menores de 4 años.';
$label[$ind]['fuente_numerador'] = 'REM';
$label[$ind]['fuente_denominador'] = 'REM';
$label[$ind]['meta'] = '25%';
$label[$ind]['ponderacion'] = '15%';

/* ==== Inicializar en 0 el arreglo de datos $data_reyno2020 ==== */
for($mes=1; $mes <= $ultimo_rem; $mes++) {
    $data_reyno2020[$ind]['numeradores']['total'] = 0;
    $data_reyno2020[$ind]['denominadores']['total'] = 0;
    $data_reyno2020[$ind]['numeradores'][$mes] = 0;
    $data_reyno2020[$ind]['denominadores'][$mes] = 0;
}
$data_reyno2020[$ind]['cumplimiento'] = 0;

/* ===== Query numerador ===== */
$sql_valores = "SELECT e.Comuna, e.alias_estab, r.Mes, sum(ifnull(Col34,0) + ifnull(Col35,0)) as numerador
                  FROM {$year}rems r
                  LEFT JOIN {$year}establecimientos e
                  ON r.IdEstablecimiento=e.Codigo
                  WHERE CodigoPrestacion in (02010101, 02010201, 02010103) AND e.Codigo = 102307
                  GROUP BY e.Comuna, e.alias_estab, r.Mes
                  ORDER BY e.Comuna, e.alias_estab, r.Mes";
$valores = DB::connection('mysql_rem')->select($sql_valores);

foreach($valores as $valor) {
    $data_reyno2020[$ind]['numeradores'][$valor->Mes] = intval($valor->numerador);
    $data_reyno2020[$ind]['numeradores']['total'] += intval($valor->numerador);
}

/* ===== Query denominador ===== */
$sql_denominador = "SELECT e.Comuna, e.alias_estab, r.Mes, sum(ifnull(Col04,0) +
                     ifnull(Col05,0) + ifnull(Col06,0) +
                     ifnull(Col07,0) + ifnull(Col08,0) +
                     ifnull(Col09,0) + ifnull(Col10,0) +
                     ifnull(Col11,0) + ifnull(Col12,0) +
                     ifnull(Col13,0) + ifnull(Col14,0)) as denominador
                    FROM {$year}rems r
                    LEFT JOIN {$year}establecimientos e
                    ON r.IdEstablecimiento=e.Codigo
                    WHERE CodigoPrestacion in (02010101, 02010201, 02010103) AND e.Codigo = 102307
                    GROUP BY e.Comuna, e.alias_estab, r.Mes
                    ORDER BY e.Comuna, e.alias_estab, r.Mes";
$valores = DB::connection('mysql_rem')->select($sql_denominador);

foreach($valores as $valor) {
    $data_reyno2020[$ind]['denominadores'][$valor->Mes] = intval($valor->denominador);
    $data_reyno2020[$ind]['denominadores']['total'] += intval($valor->denominador);
}

/* Calcular el cumplimento */
if($data_reyno2020[$ind]['denominadores']['total'] != 0) {
    $data_reyno2020[$ind]['cumplimiento'] = $data_reyno2020[$ind]['numeradores']['total'] /
                              $data_reyno2020[$ind]['denominadores']['total'] * 100;
}

// Indicador 6

$ind = 6;
$label[$ind]['indicador'] = 'A6-. Porcentaje de niños(as) menores de 5 años cuyas madres,
    padres o cuidadores(as) ingresan a talleres Nadie es Perfecto.';
$label[$ind]['numerador'] = 'Número de madres, padres o cuidadores(as) de niños(as)
    menores de 5 años que ingresan a talleres Nadie es Perfecto.';
$label[$ind]['denominador'] = 'Población bajo control de niños(as) menores de 5
    años.';
$label[$ind]['fuente_numerador'] = 'REM';
$label[$ind]['fuente_denominador'] = 'REM';

if($ultimo_rem >= 1 && $ultimo_rem <= 7){
    $label[$ind]['meta'] = 'Abr: 2%';
}
if($ultimo_rem >= 8 && $ultimo_rem <= 11){
    $label[$ind]['meta'] = 'Ago: 3,9%';
}
if($ultimo_rem >= 12){
    $label[$ind]['meta'] = 'Dic: 7%';
}
$label[$ind]['ponderacion'] = '20%';

/* ==== Inicializar en 0 el arreglo de datos $data_reyno2020 ==== */
for($mes=1; $mes <= $ultimo_rem; $mes++) {
    $data_reyno2020[$ind]['numeradores']['total'] = 0;
    //$data_reyno2020[$ind]['denominadores']['total'] = 0;
    $data_reyno2020[$ind]['numeradores'][$mes] = 0;
    //$data_reyno2020[$ind]['denominadores'][$mes] = 0;
}
$data_reyno2020[$ind]['denominador'] = 0;
$data_reyno2020[$ind]['denominador_a'] = 0;
$data_reyno2020[$ind]['denominador_6'] = 0;
$data_reyno2020[$ind]['denominador_12'] = 0;
$data_reyno2020[$ind]['cumplimiento'] = 0;

/* ===== Query numerador ===== */
$sql_valores = "SELECT e.Comuna, e.alias_estab, r.Mes, sum(ifnull(Col01,0)) as numerador
                  FROM {$year}rems r
                  LEFT JOIN {$year}establecimientos e
                  ON r.IdEstablecimiento=e.Codigo
                  WHERE CodigoPrestacion in (27300700) AND e.Codigo = 102307
                  GROUP BY e.Comuna, e.alias_estab, r.Mes
                  ORDER BY e.Comuna, e.alias_estab, r.Mes";
$valores = DB::connection('mysql_rem')->select($sql_valores);

foreach($valores as $valor) {
    $data_reyno2020[$ind]['numeradores'][$valor->Mes] = intval($valor->numerador);
    $data_reyno2020[$ind]['numeradores']['total'] += intval($valor->numerador);
}

if($ultimo_rem <= 5) {
  /* ===== Query denominador ===== */
  $sql_denominador = "SELECT e.Comuna, e.alias_estab, r.Mes, sum(ifnull(Col04,0) + ifnull(Col05,0) +
                      ifnull(Col06,0) + ifnull(Col07,0) +
                      ifnull(Col08,0) + ifnull(Col09,0) +
                      ifnull(Col10,0) + ifnull(Col11,0) +
                      ifnull(Col12,0) + ifnull(Col13,0) +
                      ifnull(Col14,0) + ifnull(Col15,0) +
                      ifnull(Col16,0) + ifnull(Col17,0) +
                      ifnull(Col18,0) + ifnull(Col19,0) +
                      ifnull(Col20,0) + ifnull(Col21,0) +
                      ifnull(Col22,0) + ifnull(Col23,0) +
                      ifnull(Col24,0) + ifnull(Col25,0) +
                      ifnull(Col26,0) + ifnull(Col27,0) +
                      ifnull(Col28,0) + ifnull(Col29,0) +
                      ifnull(Col30,0) + ifnull(Col31,0)) as denominador
                      FROM 2019rems r
                      LEFT JOIN 2019establecimientos e
                      ON r.IdEstablecimiento=e.Codigo
                      WHERE CodigoPrestacion in ('P2060000') AND e.Codigo = 102307
                      AND r.Mes = '12'
                      GROUP BY e.Comuna, e.alias_estab, r.Mes
                      ORDER BY e.Comuna, e.alias_estab, r.Mes";
  $valores = DB::connection('mysql_rem')->select($sql_denominador);

  foreach($valores as $valor) {
      $data_reyno2020[$ind]['denominador_a'] = intval($valor->denominador);
  }

  $data_reyno2020[$ind]['denominador'] = $data_reyno2020[$ind]['denominador_a'];

  /* Calcular el cumplimento */
  if($data_reyno2020[$ind]['denominador_a'] != 0) {
      $data_reyno2020[$ind]['cumplimiento'] = $data_reyno2020[$ind]['numeradores']['total'] /
                                $data_reyno2020[$ind]['denominador_a'] * 100;
  }
}
else{
  /* ===== Query denominador ===== */
  $sql_denominador = "SELECT e.Comuna, e.alias_estab, r.Mes, sum(ifnull(Col04,0) + ifnull(Col05,0) +
                      ifnull(Col06,0) + ifnull(Col07,0) +
                      ifnull(Col08,0) + ifnull(Col09,0) +
                      ifnull(Col10,0) + ifnull(Col11,0) +
                      ifnull(Col12,0) + ifnull(Col13,0) +
                      ifnull(Col14,0) + ifnull(Col15,0) +
                      ifnull(Col16,0) + ifnull(Col17,0) +
                      ifnull(Col18,0) + ifnull(Col19,0) +
                      ifnull(Col20,0) + ifnull(Col21,0) +
                      ifnull(Col22,0) + ifnull(Col23,0) +
                      ifnull(Col24,0) + ifnull(Col25,0) +
                      ifnull(Col26,0) + ifnull(Col27,0) +
                      ifnull(Col28,0) + ifnull(Col29,0) +
                      ifnull(Col30,0) + ifnull(Col31,0)) as denominador
                      FROM {$year}rems r
                      LEFT JOIN {$year}establecimientos e
                      ON r.IdEstablecimiento=e.Codigo
                      WHERE CodigoPrestacion in ('P2060000') AND e.Codigo = 102307
                      AND (Mes = 6 OR Mes = 12)
                      GROUP BY e.Comuna, e.alias_estab, r.Mes
                      ORDER BY e.Comuna, e.alias_estab, r.Mes";
  $valores = DB::connection('mysql_rem')->select($sql_denominador);

  foreach($valores as $valor) {
      switch($valor->Mes) {
          case 6:  $data_reyno2020[$ind]['denominador_6'] = intval($valor->denominador); break;
          case 12: $data_reyno2020[$ind]['denominador_12'] = intval($valor->denominador); break;
      }
  }

  if($ultimo_rem <= 11){
    $data_reyno2020[$ind]['denominador'] = $data_reyno2020[$ind]['denominador_6'];

    /* Calcular el cumplimento */
    if($data_reyno2020[$ind]['denominador_6'] != 0) {
        $data_reyno2020[$ind]['cumplimiento'] = $data_reyno2020[$ind]['numeradores']['total'] /
              $data_reyno2020[$ind]['denominador_6'] * 100;
    }
  }
  else{
    $data_reyno2020[$ind]['denominador'] = $data_reyno2020[$ind]['denominador_12'];

    /* Calcular el cumplimento */
    if($data_reyno2020[$ind]['denominador_12'] != 0) {
        $data_reyno2020[$ind]['cumplimiento'] = $data_reyno2020[$ind]['numeradores']['total'] /
              $data_reyno2020[$ind]['denominador_12'] * 100;
    }
  }
}

// // Indicador 7
// $ind = 7;
// $label[$ind]['meta'] = 'A7-. Promedio de talleres Nadie es Perfecto iniciados por
//     facilitadores vigentes a la fecha de corte.';
// $label[$ind]['numerador'] = 'Número de talleres Nadie es Perfecto iniciado por
//     facilitadores vigentes a la fecha de corte.';
// $label[$ind]['denominador'] = 'Número de facilitadores Nadie es Perfecto vigentes
//     a la fecha de corte.';
// $label[$ind]['fuente_numerador'] = 'SRDM';
// $label[$ind]['fuente_denominador'] = 'SRDM';
// $label[$ind]['ponderacion'] = '15%';
//
// $meses = array(1,2,3,4,5,6,7,8,9,10,11,12);
// $flag1 = NULL;
// $flag2 = NULL;
//
// $sql_establecimientos =
// 'SELECT comuna, alias_estab
//  FROM 2020establecimientos
//  WHERE p_chcc = 1
//  ORDER BY comuna;';
//
// $establecimientos = DB::connection('mysql_rem')->select($sql_establecimientos);
//
// /* ==== Inicializar en 0 el arreglo de datos $data_reyno2020 ==== */
// foreach($establecimientos as $establecimiento) {
//     $data_reyno2020[$establecimiento->comuna][$ind]['numeradores']['total'] = 0;
//     $data_reyno2020[$establecimiento->comuna][$ind]['denominadores']['total'] = 0;
//     $data_reyno2020[$establecimiento->comuna][$ind]['cumplimiento'] = 0;
//     for($mes=1; $mes <= $ultimo_rem; $mes++) {
//         $data_reyno2020[$establecimiento->comuna][$ind]['numeradores'][$mes] = 0;
//         $data_reyno2020[$establecimiento->comuna][$ind]['denominadores'][$mes] = 0;
//         $data_reyno2020[$establecimiento->comuna][$ind][$establecimiento->alias_estab]['numeradores']['total'] = 0;
//         $data_reyno2020[$establecimiento->comuna][$ind][$establecimiento->alias_estab]['denominadores']['total'] = 0;
//         $data_reyno2020[$establecimiento->comuna][$ind][$establecimiento->alias_estab]['numeradores'][$mes] = 0;
//         $data_reyno2020[$establecimiento->comuna][$ind][$establecimiento->alias_estab]['denominadores'][$mes] = 0;
//     }
//     $data_reyno2020[$establecimiento->comuna][$ind][$establecimiento->alias_estab]['cumplimiento'] = 0;
// }
//
// if($ultimo_rem >= 1 && $ultimo_rem <= 7){
//     $data_reyno2020['ALTO HOSPICIO'][$ind]['meta'] = 'Abr: 0,7';
//     $data_reyno2020['CAMIÑA'][$ind]['meta'] = 'Abr: 0,7';
//     $data_reyno2020['COLCHANE'][$ind]['meta'] = 'Abr: 0,7';
//     $data_reyno2020['HUARA'][$ind]['meta'] = 'Abr: 0,7';
//     $data_reyno2020['IQUIQUE'][$ind]['meta'] = 'Abr: 0,7';
//     $data_reyno2020['PICA'][$ind]['meta'] = 'Abr: 0,7';
//     $data_reyno2020['POZO ALMONTE'][$ind]['meta'] = 'Abr: 0,7';
// }
// if($ultimo_rem >= 8 && $ultimo_rem <= 11){
//     $data_reyno2020['ALTO HOSPICIO'][$ind]['meta'] = 'Ago: 1,7';
//     $data_reyno2020['CAMIÑA'][$ind]['meta'] = 'Ago: 1,7';
//     $data_reyno2020['COLCHANE'][$ind]['meta'] = 'Ago: 1,7';
//     $data_reyno2020['HUARA'][$ind]['meta'] = 'Ago: 1,7';
//     $data_reyno2020['IQUIQUE'][$ind]['meta'] = 'Ago: 1,7';
//     $data_reyno2020['PICA'][$ind]['meta'] = 'Ago: 1,7';
//     $data_reyno2020['POZO ALMONTE'][$ind]['meta'] = 'Ago: 1,7';
// }
// if($ultimo_rem >= 12){
//     $data_reyno2020['ALTO HOSPICIO'][$ind]['meta'] = 'Dic: 3,4';
//     $data_reyno2020['CAMIÑA'][$ind]['meta'] = 'Dic: 3,4';
//     $data_reyno2020['COLCHANE'][$ind]['meta'] = 'Dic: 3,4';
//     $data_reyno2020['HUARA'][$ind]['meta'] = 'Dic: 3,4';
//     $data_reyno2020['IQUIQUE'][$ind]['meta'] = 'Dic: 3,4';
//     $data_reyno2020['PICA'][$ind]['meta'] = 'Dic: 3,4';
//     $data_reyno2020['POZO ALMONTE'][$ind]['meta'] = 'Dic: 3,4';
// }
//
// /* ===== Query numerador ===== */
// $sql_numerador = "SELECT e.Comuna, e.alias_estab, r.Mes, sum(ifnull(Col01,0)) as numerador
//                   FROM {$year}rems r
//                   LEFT JOIN {$year}establecimientos e
//                   ON r.IdEstablecimiento=e.Codigo
//                   WHERE CodigoPrestacion in ('') AND e.p_chcc = 1
//                   GROUP BY e.Comuna, e.alias_estab, r.Mes
//                   ORDER BY e.Comuna, e.alias_estab, r.Mes";
// $numeradores = DB::connection('mysql_rem')->select($sql_numerador);
//
// foreach($numeradores as $registro) {
//     if( ($flag1 != $registro->Comuna) OR ($flag2 != $registro->alias_estab) ) {
//         for($mes=1; $mes <= $ultimo_rem; $mes++) {
//             $data_reyno2020[$registro->Comuna][$ind][$registro->alias_estab]['numeradores'][$mes] = 0;
//         }
//         $flag1 = $registro->Comuna;
//         $flag2 = $registro->alias_estab;
//     }
//     $data_reyno2020[$registro->Comuna][$ind][$registro->alias_estab]['numeradores'][$registro->Mes] = $registro->numerador;
// }
//
// /* ===== Query denominador ===== */
// $sql_denominador = "SELECT e.Comuna, e.alias_estab, r.Mes, sum(ifnull(Col04,0)) as denominador
//                     FROM {$year}rems r
//                     LEFT JOIN {$year}establecimientos e
//                     ON r.IdEstablecimiento=e.Codigo
//                     WHERE CodigoPrestacion in ('') AND e.p_chcc = 1
//                     GROUP BY e.Comuna, e.alias_estab, r.Mes
//                     ORDER BY e.Comuna, e.alias_estab, r.Mes";
// $denominadores = DB::connection('mysql_rem')->select($sql_denominador);
//
// foreach($denominadores as $registro) {
//     if( ($flag1 != $registro->Comuna) OR ($flag2 != $registro->alias_estab) ) {
//         for($mes=1; $mes <= $ultimo_rem; $mes++) {
//             $data_reyno2020[$registro->Comuna][$ind][$registro->alias_estab]['denominadores'][$mes] = 0;
//         }
//         $flag1 = $registro->Comuna;
//         $flag2 = $registro->alias_estab;
//     }
//     $data_reyno2020[$registro->Comuna][$ind][$registro->alias_estab]['denominadores'][$registro->Mes] = $registro->denominador;
// }
//
// /* ==== Calculos ==== */
// foreach($data_reyno2020 as $nombre_comuna => $comuna) {
//   foreach($comuna as $nro_ind => $indicador) {
//     foreach($indicador as $nombre_establecimiento => $establecimiento) {
//         /* Existe en el array un indice ['numerador'], ['denominador'] y ['meta'],
//          * estos almacenan la información de la comuna, por lo tanto tengo que saltarlos
//          * en la iteración del foreach y continuar con los establecimientos */
//         /* Realizar los calculos mensuales */
//         if($nombre_establecimiento != 'numeradores' AND
//             $nombre_establecimiento != 'denominadores' AND
//             $nombre_establecimiento != 'meta' AND
//             $nombre_establecimiento != 'cumplimiento' AND
//             $nro_ind == $ind){
//
//             /* Calcula los totales de cada establecimiento */
//             $data_reyno2020[$nombre_comuna][$ind][$nombre_establecimiento]['denominadores']['total'] = array_sum($establecimiento['denominadores']);
//             $data_reyno2020[$nombre_comuna][$ind][$nombre_establecimiento]['numeradores']['total'] = array_sum($establecimiento['numeradores']);
//
//             /* Calcula los totales de cada comuna */
//             $data_reyno2020[$nombre_comuna][$ind]['numeradores']['total'] += $data_reyno2020[$nombre_comuna][$ind][$nombre_establecimiento]['numeradores']['total'];
//             $data_reyno2020[$nombre_comuna][$ind]['denominadores']['total'] += $data_reyno2020[$nombre_comuna][$ind][$nombre_establecimiento]['denominadores']['total'];
//
//             /* Calcula la suma mensual por comuna */
//             for($mes=1; $mes <= $ultimo_rem; $mes++) {
//                 $data_reyno2020[$nombre_comuna][$ind]['numeradores'][$mes] += $establecimiento['numeradores'][$mes];
//                 $data_reyno2020[$nombre_comuna][$ind]['denominadores'][$mes] += $establecimiento['denominadores'][$mes];
//             }
//
//             /* Calculo de las metas de cada establecimiento */
//             if($data_reyno2020[$nombre_comuna][$ind][$nombre_establecimiento]['denominadores']['total'] == 0) {
//                 /* Si es 0 el denominadore entonces la cumplimiento es 0 */
//                 $data_reyno2020[$nombre_comuna][$ind][$nombre_establecimiento]['cumplimiento'] = 0;
//             }
//             else {
//                 /* De lo contrario calcular el porcentaje */
//                 $data_reyno2020[$nombre_comuna][$ind][$nombre_establecimiento]['cumplimiento'] =
//                     $data_reyno2020[$nombre_comuna][$ind][$nombre_establecimiento]['numeradores']['total'] / $data_reyno2020[$nombre_comuna][$ind][$nombre_establecimiento]['denominadores']['total'] * 100;
//             }
//
//             /* Calculo de las metas de la comuna */
//             if($data_reyno2020[$nombre_comuna][$ind]['denominadores']['total'] == 0) {
//                 /* Si es 0 el denominadore entonces la cumplimiento es 0 */
//                 $data_reyno2020[$nombre_comuna][$ind]['cumplimiento'] = 0;
//             }
//             else {
//                 /* De lo contrario calcular el porcentaje */
//                 $data_reyno2020[$nombre_comuna][$ind]['cumplimiento'] = $data_reyno2020[$nombre_comuna][$ind]['numeradores']['total'] / $data_reyno2020[$nombre_comuna][$ind]['denominadores']['total'] * 100;
//             }
//         }
//     }
//   }
// }

// Indicador 8

$ind = 8;
$label[$ind]['indicador'] = 'A8-. Porcentaje de niños(as) menores de 1 año cuyas madres,
    padres o cuidadores(as) ingresan a talleres de Promoción del desarrollo: motor
     y lenguaje.';
$label[$ind]['numerador'] = 'Número niños(as) menores de 1 año cuyas madres, padres
    o cuidadores(as)  ingresan a talleres de Promoción del desarrollo: motor y lenguaje.';
$label[$ind]['denominador'] = 'Número de niños(as) bajo control menores de 1 año.';
$label[$ind]['fuente_numerador'] = 'REM';
$label[$ind]['fuente_denominador'] = 'REM P';
if($ultimo_rem >= 1 && $ultimo_rem <= 7){
    $label[$ind]['meta'] = 'Abr: 18%';
}
if($ultimo_rem >= 8 && $ultimo_rem <= 11){
    $label[$ind]['meta'] = 'Ago: 22%';
}
if($ultimo_rem >= 12){
    $label[$ind]['meta'] = 'Dic: 25%';
}
$label[$ind]['ponderacion'] = '15%';

/* ==== Inicializar en 0 el arreglo de datos $data_reyno2020 ==== */
for($mes=1; $mes <= $ultimo_rem; $mes++) {
    $data_reyno2020[$ind]['numeradores']['total'] = 0;
    // $data_reyno2020[$ind]['denominadores']['total'] = 0;
    $data_reyno2020[$ind]['numeradores'][$mes] = 0;
    // $data_reyno2020[$ind]['denominadores'][$mes] = 0;
}
$data_reyno2020[$ind]['denominador'] = 0;
$data_reyno2020[$ind]['denominador_a'] = 0;
$data_reyno2020[$ind]['denominador_6'] = 0;
$data_reyno2020[$ind]['denominador_12'] = 0;
$data_reyno2020[$ind]['cumplimiento'] = 0;

/* ===== Query numerador ===== */
$sql_valores = "SELECT e.Comuna, e.alias_estab, r.Mes, sum(ifnull(Col01,0)) as numerador
                  FROM {$year}rems r
                  LEFT JOIN {$year}establecimientos e
                  ON r.IdEstablecimiento=e.Codigo
                  WHERE CodigoPrestacion in (27300902, 27300903) AND e.Codigo = 102307
                  GROUP BY e.Comuna, e.alias_estab, r.Mes
                  ORDER BY e.Comuna, e.alias_estab, r.Mes";
$valores = DB::connection('mysql_rem')->select($sql_valores);

foreach($valores as $valor) {
    $data_reyno2020[$ind]['numeradores'][$valor->Mes] = intval($valor->numerador);
    $data_reyno2020[$ind]['numeradores']['total'] += intval($valor->numerador);
}

/* ===== Query denominador ===== */
$sql_denominador = "SELECT e.Comuna, e.alias_estab, r.Mes, sum(ifnull(Col01,0)) as denominador
                    FROM {$year}rems r
                    LEFT JOIN {$year}establecimientos e
                    ON r.IdEstablecimiento=e.Codigo
                    WHERE CodigoPrestacion in ('') AND e.Codigo = 102307
                    GROUP BY e.Comuna, e.alias_estab, r.Mes
                    ORDER BY e.Comuna, e.alias_estab, r.Mes";
$valores = DB::connection('mysql_rem')->select($sql_denominador);

if($ultimo_rem <= 5) {
    /* ===== Query denominador ===== */
    $sql_denominador = "SELECT e.Comuna, e.alias_estab, r.Mes, sum(ifnull(Col04,0) + ifnull(Col05,0) +
                        ifnull(Col06,0) + ifnull(Col07,0) +
                        ifnull(Col08,0) + ifnull(Col09,0) +
                        ifnull(Col10,0) + ifnull(Col11,0) +
                        ifnull(Col12,0) + ifnull(Col13,0) +
                        ifnull(Col14,0) + ifnull(Col15,0) +
                        ifnull(Col16,0) + ifnull(Col17,0) +
                        ifnull(Col18,0) + ifnull(Col19,0)) as denominador
                        FROM 2019rems r
                        LEFT JOIN 2019establecimientos e
                        ON r.IdEstablecimiento=e.Codigo
                        WHERE CodigoPrestacion in ('P2060000') AND e.Codigo = 102307
                        AND r.Mes = '12'
                        GROUP BY e.Comuna, e.alias_estab, r.Mes
                        ORDER BY e.Comuna, e.alias_estab, r.Mes";
    $valores = DB::connection('mysql_rem')->select($sql_denominador);

    foreach($valores as $valor) {
        $data_reyno2020[$ind]['denominador_a'] = intval($valor->denominador);
    }

    $data_reyno2020[$ind]['denominador'] = $data_reyno2020[$ind]['denominador_a'];

    /* Calcular el cumplimento */
    if($data_reyno2020[$ind]['denominador'] != 0) {
        $data_reyno2020[$ind]['cumplimiento'] = $data_reyno2020[$ind]['numeradores']['total'] /
                                  $data_reyno2020[$ind]['denominador_a'] * 100;
    }
}
else{
    /* ===== Query denominador ===== */
    $sql_denominador = "SELECT e.Comuna, e.alias_estab, r.Mes, sum(ifnull(Col04,0) + ifnull(Col05,0) +
                        ifnull(Col06,0) + ifnull(Col07,0) +
                        ifnull(Col08,0) + ifnull(Col09,0) +
                        ifnull(Col10,0) + ifnull(Col11,0) +
                        ifnull(Col12,0) + ifnull(Col13,0) +
                        ifnull(Col14,0) + ifnull(Col15,0) +
                        ifnull(Col16,0) + ifnull(Col17,0) +
                        ifnull(Col18,0) + ifnull(Col19,0)) as denominador
                        FROM {$year}rems r
                        LEFT JOIN {$year}establecimientos e
                        ON r.IdEstablecimiento=e.Codigo
                        WHERE CodigoPrestacion in ('P2060000') AND e.Codigo = 102307
                        AND (Mes = 6 OR Mes = 12)
                        GROUP BY e.Comuna, e.alias_estab, r.Mes
                        ORDER BY e.Comuna, e.alias_estab, r.Mes";
    $valores = DB::connection('mysql_rem')->select($sql_denominador);

    foreach($valores as $valor) {
        switch($valor->Mes) {
            case 6:  $data_reyno2020[$ind]['denominador_6'] = intval($valor->denominador); break;
            case 12: $data_reyno2020[$ind]['denominador_12'] = intval($valor->denominador); break;
        }
    }

    if($ultimo_rem <= 11){
      $data_reyno2020[$ind]['denominador'] = $data_reyno2020[$ind]['denominador_6'];

      /* Calcular el cumplimento */
      if($data_reyno2020[$ind]['denominador_6'] != 0) {
          $data_reyno2020[$ind]['cumplimiento'] = $data_reyno2020[$ind]['numeradores']['total'] /
                $data_reyno2020[$ind]['denominador_6'] * 100;
      }
    }
    else{
      $data_reyno2020[$ind]['denominador'] = $data_reyno2020[$ind]['denominador_12'];

      /* Calcular el cumplimento */
      if($data_reyno2020[$ind]['denominador_12'] != 0) {
          $data_reyno2020[$ind]['cumplimiento'] = $data_reyno2020[$ind]['numeradores']['total'] /
                $data_reyno2020[$ind]['denominador_12'] * 100;
      }
    }
}

// Indicador 9

$ind = 9;
$label[$ind]['indicador'] = 'A9-. Porcentaje de niños(as) con resultado de déficit en
    el desarrollo psicomotor en la primera evaluación, ingresados a sala de estimulación .';
$label[$ind]['numerador'] = 'Número de niños(as) con resultado de déficit en el
    desarrollo psicomotor en la primera evaluación, ingresados a sala de estimulación.';
$label[$ind]['denominador'] = 'Número de niños(as) con resultado de déficit en EEDP
    y TEPSI en la primera evaluación.';
$label[$ind]['fuente_numerador'] = 'REM';
$label[$ind]['fuente_denominador'] = 'REM';
$label[$ind]['meta'] = '90%';
$label[$ind]['ponderacion'] = '28%';

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
                  WHERE CodigoPrestacion in (06902602, 06902603) AND e.Codigo = 102307
                  GROUP BY e.Comuna, e.alias_estab, r.Mes
                  ORDER BY e.Comuna, e.alias_estab, r.Mes";
$valores = DB::connection('mysql_rem')->select($sql_valores);

foreach($valores as $valor) {
    $data_reyno2020[$ind]['numeradores'][$valor->Mes] = intval($valor->numerador);
    $data_reyno2020[$ind]['numeradores']['total'] += intval($valor->numerador);
}

/* ===== Query denominador ===== */
$sql_denominador = "SELECT e.Comuna, e.alias_estab, r.Mes, sum(ifnull(Col01,0)) as denominador
                    FROM {$year}rems r
                    LEFT JOIN {$year}establecimientos e
                    ON r.IdEstablecimiento=e.Codigo
                    WHERE CodigoPrestacion in (02010321, 02010322) AND e.Codigo = 102307
                    GROUP BY e.Comuna, e.alias_estab, r.Mes
                    ORDER BY e.Comuna, e.alias_estab, r.Mes";
$valores = DB::connection('mysql_rem')->select($sql_denominador);

foreach($valores as $valor) {
    $data_reyno2020[$ind]['denominadores'][$valor->Mes] = intval($valor->denominador);
    $data_reyno2020[$ind]['denominadores']['total'] += intval($valor->denominador);
}

/* Calcular el cumplimento */
if($data_reyno2020[$ind]['denominadores']['total'] != 0) {
    $data_reyno2020[$ind]['cumplimiento'] = $data_reyno2020[$ind]['numeradores']['total'] /
                              $data_reyno2020[$ind]['denominadores']['total'] * 100;
}

// Indicador 10

$ind = 10;
$label[$ind]['indicador'] = 'A10-. Porcentaje de niños(as) con resultado de rezago en
    EEDP y TEPSI en la primera evaluación derivados a modalidad de estimulación
    (no considera  ludoteca).';
$label[$ind]['numerador'] = 'Número de niños(as) con resultado de rezago en EEDP
    y TEPSI en la primera evaluación  derivados a modalidad de estimulación.';
$label[$ind]['denominador'] = 'Número de niños(as) con resultado de déficit en EEDP
    y TEPSI en la primera evaluación.';
$label[$ind]['fuente_numerador'] = 'REM';
$label[$ind]['fuente_denominador'] = 'REM';
$label[$ind]['meta'] = '80%';
$label[$ind]['ponderacion'] = '15%';

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
                  WHERE CodigoPrestacion in (02021790) AND e.Codigo = 102307
                  GROUP BY e.Comuna, e.alias_estab, r.Mes
                  ORDER BY e.Comuna, e.alias_estab, r.Mes";
$valores = DB::connection('mysql_rem')->select($sql_valores);

foreach($valores as $valor) {
    $data_reyno2020[$ind]['numeradores'][$valor->Mes] = intval($valor->numerador);
    $data_reyno2020[$ind]['numeradores']['total'] += intval($valor->numerador);
}

/* ===== Query denominador ===== */
$sql_denominador = "SELECT e.Comuna, e.alias_estab, r.Mes, sum(ifnull(Col01,0)) as denominador
                    FROM {$year}rems r
                    LEFT JOIN {$year}establecimientos e
                    ON r.IdEstablecimiento=e.Codigo
                    WHERE CodigoPrestacion in (05225303) AND e.Codigo = 102307
                    GROUP BY e.Comuna, e.alias_estab, r.Mes
                    ORDER BY e.Comuna, e.alias_estab, r.Mes";
$valores = DB::connection('mysql_rem')->select($sql_denominador);

foreach($valores as $valor) {
    $data_reyno2020[$ind]['denominadores'][$valor->Mes] = intval($valor->denominador);
    $data_reyno2020[$ind]['denominadores']['total'] += intval($valor->denominador);
}

/* Calcular el cumplimento */
if($data_reyno2020[$ind]['denominadores']['total'] != 0) {
    $data_reyno2020[$ind]['cumplimiento'] = $data_reyno2020[$ind]['numeradores']['total'] /
                              $data_reyno2020[$ind]['denominadores']['total'] * 100;
}

$ind = 11;
$label[$ind]['indicador'] = 'A11-. Porcentaje de niños(as) de 7 a 11 meses con alteraciones
    en el DSM  recuperados.';
$label[$ind]['numerador'] = 'Número de niños(as) de 7 a 11 con resultado "Normal"
    (sin rezago y  excluyendo “de retraso”) en la reevaluación y que en la primera
     aplicación tuvieron resultado de “normal con rezago” o “riesgo”.';
$label[$ind]['denominador'] = 'Número de niños(as) de 7 a 11 meses diagnosticados
    con alteraciones (excluyendo categoría "retraso") del DSM.';
$label[$ind]['fuente_numerador'] = 'REM';
$label[$ind]['fuente_denominador'] = 'REM';
$label[$ind]['meta'] = '80%';
$label[$ind]['ponderacion'] = '15%';

/* ==== Inicializar en 0 el arreglo de datos $data_reyno2020 ==== */
for($mes=1; $mes <= $ultimo_rem; $mes++) {
    $data_reyno2020[$ind]['numeradores']['total'] = 0;
    $data_reyno2020[$ind]['denominadores']['total'] = 0;
    $data_reyno2020[$ind]['numeradores'][$mes] = 0;
    $data_reyno2020[$ind]['denominadores'][$mes] = 0;
}
$data_reyno2020[$ind]['cumplimiento'] = 0;

/* ===== Query numerador ===== */
$sql_valores = "SELECT e.Comuna, e.alias_estab, r.Mes, sum(ifnull(Col06,0) + ifnull(Col07,0)) as numerador
                  FROM {$year}rems r
                  LEFT JOIN {$year}establecimientos e
                  ON r.IdEstablecimiento=e.Codigo
                  WHERE CodigoPrestacion in (05225304, 02010420) AND e.Codigo = 102307
                  GROUP BY e.Comuna, e.alias_estab, r.Mes
                  ORDER BY e.Comuna, e.alias_estab, r.Mes";
$valores = DB::connection('mysql_rem')->select($sql_valores);

foreach($valores as $valor) {
    $data_reyno2020[$ind]['numeradores'][$valor->Mes] = intval($valor->numerador);
    $data_reyno2020[$ind]['numeradores']['total'] += intval($valor->numerador);
}

/* ===== Query denominador ===== */
$sql_denominador = "SELECT e.Comuna, e.alias_estab, r.Mes, sum(ifnull(Col06,0) + ifnull(Col07,0)) as denominador
                    FROM {$year}rems r
                    LEFT JOIN {$year}establecimientos e
                    ON r.IdEstablecimiento=e.Codigo
                    WHERE CodigoPrestacion in (05225303, 02010321) AND e.Codigo = 102307
                    GROUP BY e.Comuna, e.alias_estab, r.Mes
                    ORDER BY e.Comuna, e.alias_estab, r.Mes";
$valores = DB::connection('mysql_rem')->select($sql_denominador);

foreach($valores as $valor) {
    $data_reyno2020[$ind]['denominadores'][$valor->Mes] = intval($valor->denominador);
    $data_reyno2020[$ind]['denominadores']['total'] += intval($valor->denominador);
}

/* Calcular el cumplimento */
if($data_reyno2020[$ind]['denominadores']['total'] != 0) {
    $data_reyno2020[$ind]['cumplimiento'] = $data_reyno2020[$ind]['numeradores']['total'] /
                              $data_reyno2020[$ind]['denominadores']['total'] * 100;
}

// Indicador 12

$ind = 12;
$label[$ind]['indicador'] = 'A12-. Promedio de Visitas Domiciliarias Integrales realizadas
    a familias de niños(as) con resultado de déficit en el desarrollo psicomotor
    según EEDP y TEPSI  en la primera evaluación.';
$label[$ind]['numerador'] = 'Número de Visitas Domiciliarias Integrales realizadas
    a familias de niños(as) con resultado de déficit en el desarrollo psicomotor
     según EEDP y TEPSI en la primera evaluación.';
$label[$ind]['denominador'] = 'Número de niños(as) con resultado de déficit en EEDP
    y TEPSI en la primera evaluación.';
$label[$ind]['fuente_numerador'] = 'REM';
$label[$ind]['fuente_denominador'] = 'REM';
$label[$ind]['meta'] = '1.5';
$label[$ind]['ponderacion'] = '15%';

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
                  WHERE CodigoPrestacion in (26273101) AND e.Codigo = 102307
                  GROUP BY e.Comuna, e.alias_estab, r.Mes
                  ORDER BY e.Comuna, e.alias_estab, r.Mes";
$valores = DB::connection('mysql_rem')->select($sql_valores);

foreach($valores as $valor) {
    $data_reyno2020[$ind]['numeradores'][$valor->Mes] = intval($valor->numerador);
    $data_reyno2020[$ind]['numeradores']['total'] += intval($valor->numerador);
}

/* ===== Query denominador ===== */
$sql_denominador = "SELECT e.Comuna, e.alias_estab, r.Mes, sum(ifnull(Col01,0)) as denominador
                    FROM {$year}rems r
                    LEFT JOIN {$year}establecimientos e
                    ON r.IdEstablecimiento=e.Codigo
                    WHERE CodigoPrestacion in (02010321, 02010322) AND e.Codigo = 102307
                    GROUP BY e.Comuna, e.alias_estab, r.Mes
                    ORDER BY e.Comuna, e.alias_estab, r.Mes";
$valores = DB::connection('mysql_rem')->select($sql_denominador);

foreach($valores as $valor) {
    $data_reyno2020[$ind]['denominadores'][$valor->Mes] = intval($valor->denominador);
    $data_reyno2020[$ind]['denominadores']['total'] += intval($valor->denominador);
}

/* Calcular el cumplimento */
if($data_reyno2020[$ind]['denominadores']['total'] != 0) {
    $data_reyno2020[$ind]['cumplimiento'] = $data_reyno2020[$ind]['numeradores']['total'] /
                              $data_reyno2020[$ind]['denominadores']['total'] * 100;
}

// // Indicador 12
// $ind = 12;

//
// $meses = array(1,2,3,4,5,6,7,8,9,10,11,12);
// $flag1 = NULL;
// $flag2 = NULL;
//
// $sql_establecimientos =
// 'SELECT comuna, alias_estab
//  FROM 2020establecimientos
//  WHERE p_chcc = 1
//  ORDER BY comuna;';
//
// $establecimientos = DB::connection('mysql_rem')->select($sql_establecimientos);
//
// /* ==== Inicializar en 0 el arreglo de datos $data_reyno2020 ==== */
// foreach($establecimientos as $establecimiento) {
//     $data_reyno2020[$establecimiento->comuna][$ind]['numeradores']['total'] = 0;
//     $data_reyno2020[$establecimiento->comuna][$ind]['denominadores']['total'] = 0;
//     $data_reyno2020[$establecimiento->comuna][$ind]['cumplimiento'] = 0;
//     for($mes=1; $mes <= $ultimo_rem; $mes++) {
//         $data_reyno2020[$establecimiento->comuna][$ind]['numeradores'][$mes] = 0;
//         $data_reyno2020[$establecimiento->comuna][$ind]['denominadores'][$mes] = 0;
//         $data_reyno2020[$establecimiento->comuna][$ind][$establecimiento->alias_estab]['numeradores']['total'] = 0;
//         $data_reyno2020[$establecimiento->comuna][$ind][$establecimiento->alias_estab]['denominadores']['total'] = 0;
//         $data_reyno2020[$establecimiento->comuna][$ind][$establecimiento->alias_estab]['numeradores'][$mes] = 0;
//         $data_reyno2020[$establecimiento->comuna][$ind][$establecimiento->alias_estab]['denominadores'][$mes] = 0;
//     }
//     $data_reyno2020[$establecimiento->comuna][$ind][$establecimiento->alias_estab]['cumplimiento'] = 0;
// }
//
// $data_reyno2020['ALTO HOSPICIO'][$ind]['meta'] = '1,5';
// $data_reyno2020['CAMIÑA'][$ind]['meta'] = '1,5';
// $data_reyno2020['COLCHANE'][$ind]['meta'] = '1,5';
// $data_reyno2020['IQUIQUE'][$ind]['meta'] = '1,5';
// $data_reyno2020['HUARA'][$ind]['meta'] = '1,5';
// $data_reyno2020['PICA'][$ind]['meta'] = '1,5';
// $data_reyno2020['POZO ALMONTE'][$ind]['meta'] = '1,5';
//
// /* ===== Query numerador ===== */
// $sql_numerador = "SELECT e.Comuna, e.alias_estab, r.Mes, sum(ifnull(Col01,0)) as numerador
//                   FROM {$year}rems r
//                   LEFT JOIN {$year}establecimientos e
//                   ON r.IdEstablecimiento=e.Codigo
//                   WHERE CodigoPrestacion in (26273101) AND e.p_chcc = 1
//                   GROUP BY e.Comuna, e.alias_estab, r.Mes
//                   ORDER BY e.Comuna, e.alias_estab, r.Mes";
// $numeradores = DB::connection('mysql_rem')->select($sql_numerador);
//
// foreach($numeradores as $registro) {
//     if( ($flag1 != $registro->Comuna) OR ($flag2 != $registro->alias_estab) ) {
//         for($mes=1; $mes <= $ultimo_rem; $mes++) {
//             $data_reyno2020[$registro->Comuna][$ind][$registro->alias_estab]['numeradores'][$mes] = 0;
//         }
//         $flag1 = $registro->Comuna;
//         $flag2 = $registro->alias_estab;
//     }
//     $data_reyno2020[$registro->Comuna][$ind][$registro->alias_estab]['numeradores'][$registro->Mes] = $registro->numerador;
// }
//
// /* ===== Query denominador ===== */
// $sql_denominador = "SELECT e.Comuna, e.alias_estab, r.Mes, sum(ifnull(Col01,0)) as denominador
//                     FROM {$year}rems r
//                     LEFT JOIN {$year}establecimientos e
//                     ON r.IdEstablecimiento=e.Codigo
//                     WHERE CodigoPrestacion in (02010321, 02010322) AND e.p_chcc = 1
//                     GROUP BY e.Comuna, e.alias_estab, r.Mes
//                     ORDER BY e.Comuna, e.alias_estab, r.Mes";
// $denominadores = DB::connection('mysql_rem')->select($sql_denominador);
//
// foreach($denominadores as $registro) {
//     if( ($flag1 != $registro->Comuna) OR ($flag2 != $registro->alias_estab) ) {
//         for($mes=1; $mes <= $ultimo_rem; $mes++) {
//             $data_reyno2020[$registro->Comuna][$ind][$registro->alias_estab]['denominadores'][$mes] = 0;
//         }
//         $flag1 = $registro->Comuna;
//         $flag2 = $registro->alias_estab;
//     }
//     $data_reyno2020[$registro->Comuna][$ind][$registro->alias_estab]['denominadores'][$registro->Mes] = $registro->denominador;
// }
//
// /* ==== Calculos ==== */
// foreach($data_reyno2020 as $nombre_comuna => $comuna) {
//   foreach($comuna as $nro_ind => $indicador) {
//     foreach($indicador as $nombre_establecimiento => $establecimiento) {
//         /* Existe en el array un indice ['numerador'], ['denominador'] y ['meta'],
//          * estos almacenan la información de la comuna, por lo tanto tengo que saltarlos
//          * en la iteración del foreach y continuar con los establecimientos */
//         /* Realizar los calculos mensuales */
//         if($nombre_establecimiento != 'numeradores' AND
//             $nombre_establecimiento != 'denominadores' AND
//             $nombre_establecimiento != 'meta' AND
//             $nombre_establecimiento != 'cumplimiento' AND
//             $nro_ind == $ind){
//
//             /* Calcula los totales de cada establecimiento */
//             $data_reyno2020[$nombre_comuna][$ind][$nombre_establecimiento]['denominadores']['total'] = array_sum($establecimiento['denominadores']);
//             $data_reyno2020[$nombre_comuna][$ind][$nombre_establecimiento]['numeradores']['total'] = array_sum($establecimiento['numeradores']);
//
//             /* Calcula los totales de cada comuna */
//             $data_reyno2020[$nombre_comuna][$ind]['numeradores']['total'] += $data_reyno2020[$nombre_comuna][$ind][$nombre_establecimiento]['numeradores']['total'];
//             $data_reyno2020[$nombre_comuna][$ind]['denominadores']['total'] += $data_reyno2020[$nombre_comuna][$ind][$nombre_establecimiento]['denominadores']['total'];
//
//             /* Calcula la suma mensual por comuna */
//             for($mes=1; $mes <= $ultimo_rem; $mes++) {
//                 $data_reyno2020[$nombre_comuna][$ind]['numeradores'][$mes] += $establecimiento['numeradores'][$mes];
//                 $data_reyno2020[$nombre_comuna][$ind]['denominadores'][$mes] += $establecimiento['denominadores'][$mes];
//             }
//
//             /* Calculo de las metas de cada establecimiento */
//             if($data_reyno2020[$nombre_comuna][$ind][$nombre_establecimiento]['denominadores']['total'] == 0) {
//                 /* Si es 0 el denominadore entonces la cumplimiento es 0 */
//                 $data_reyno2020[$nombre_comuna][$ind][$nombre_establecimiento]['cumplimiento'] = 0;
//             }
//             else {
//                 /* De lo contrario calcular el porcentaje */
//                 $data_reyno2020[$nombre_comuna][$ind][$nombre_establecimiento]['cumplimiento'] =
//                     $data_reyno2020[$nombre_comuna][$ind][$nombre_establecimiento]['numeradores']['total'] / $data_reyno2020[$nombre_comuna][$ind][$nombre_establecimiento]['denominadores']['total'] * 100;
//             }
//
//             /* Calculo de las metas de la comuna */
//             if($data_reyno2020[$nombre_comuna][$ind]['denominadores']['total'] == 0) {
//                 /* Si es 0 el denominadore entonces la cumplimiento es 0 */
//                 $data_reyno2020[$nombre_comuna][$ind]['cumplimiento'] = 0;
//             }
//             else {
//                 /* De lo contrario calcular el porcentaje */
//                 $data_reyno2020[$nombre_comuna][$ind]['cumplimiento'] = $data_reyno2020[$nombre_comuna][$ind]['numeradores']['total'] / $data_reyno2020[$nombre_comuna][$ind]['denominadores']['total'] * 100;
//             }
//         }
//     }
//   }
// }

// dd($data2020);
