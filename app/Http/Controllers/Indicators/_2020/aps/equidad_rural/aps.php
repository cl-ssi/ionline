<?php
namespace App\Http\Controllers\Indicators\_2020;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\Indicators\SingleParameter;

$last_year = 2019;

$year = 2020;

$label['programa'] = 'Programa Equidad en Salud Rural.';

// Indicador 1

$ind = 1;
$label[$ind]['meta'] = '1-. Incremento de atenciones de Ronda (contoles + consultas
    + EMP) realizadas.';
$label[$ind]['numerador'] = 'N° atenciones efectuadas en establecimiento 2020.';
$label[$ind]['denominador'] = 'N° atenciones efectuadas en establecimiento 2019.';
$label[$ind]['fuente_numerador'] = 'REM';
$label[$ind]['fuente_denominador'] = 'REM';
$label[$ind]['ponderacion'] = '';

$meses = array(1,2,3,4,5,6,7,8,9,10,11,12);
$flag1 = NULL;
$flag2 = NULL;

$sql_establecimientos ="SELECT comuna, alias_estab
                        FROM {$year}establecimientos
                        WHERE p_equidad_rural = 1
                        ORDER BY comuna, id_establecimiento";

$establecimientos = DB::connection('mysql_rem')->select($sql_establecimientos);

/* ==== Inicializar en 0 el arreglo de datos $data2020 ==== */
foreach($establecimientos as $establecimiento) {
     $data2020[$establecimiento->comuna][$ind]['numerador'] = 0;
     $data2020[$establecimiento->comuna][$ind]['numeradores_m']['total'] = 0;
     $data2020[$establecimiento->comuna][$ind]['numeradores_nm']['total'] = 0;
     $data2020[$establecimiento->comuna][$ind]['denominador'] = 0;
     $data2020[$establecimiento->comuna][$ind]['denominadores_m']['total'] = 0;
     $data2020[$establecimiento->comuna][$ind]['denominadores_nm']['total'] = 0;

     $data2020[$establecimiento->comuna][$ind]['cumplimiento'] = 0;
     for($mes=1; $mes <= $ultimo_rem; $mes++) {
         $data2020[$establecimiento->comuna][$ind]['numeradores_m'][$mes] = 0;
         $data2020[$establecimiento->comuna][$ind]['numeradores_nm'][$mes] = 0;
         $data2020[$establecimiento->comuna][$ind]['denominadores_m'][$mes] = 0;
         $data2020[$establecimiento->comuna][$ind]['denominadores_nm'][$mes] = 0;

         $data2020[$establecimiento->comuna][$ind][$establecimiento->alias_estab]['numerador'] = 0;
         $data2020[$establecimiento->comuna][$ind][$establecimiento->alias_estab]['numeradores_m']['total'] = 0;
         $data2020[$establecimiento->comuna][$ind][$establecimiento->alias_estab]['numeradores_m'][$mes] = 0;
         $data2020[$establecimiento->comuna][$ind][$establecimiento->alias_estab]['numeradores_nm']['total'] = 0;
         $data2020[$establecimiento->comuna][$ind][$establecimiento->alias_estab]['numeradores_nm'][$mes] = 0;

         $data2020[$establecimiento->comuna][$ind][$establecimiento->alias_estab]['denominador'] = 0;
         $data2020[$establecimiento->comuna][$ind][$establecimiento->alias_estab]['denominadores_m']['total'] = 0;
         $data2020[$establecimiento->comuna][$ind][$establecimiento->alias_estab]['denominadores_m'][$mes] = 0;
         $data2020[$establecimiento->comuna][$ind][$establecimiento->alias_estab]['denominadores_nm']['total'] = 0;
         $data2020[$establecimiento->comuna][$ind][$establecimiento->alias_estab]['denominadores_nm'][$mes] = 0;
     }
     $data2020[$establecimiento->comuna][$ind][$establecimiento->alias_estab]['cumplimiento'] = 0;
}

$data2020['COLCHANE'][$ind]['meta'] = '˃ o = 100%';
$data2020['CAMIÑA'][$ind]['meta'] = '˃ o = 100%';
$data2020['HUARA'][$ind]['meta'] = '˃ o = 100%';
$data2020['POZO ALMONTE'][$ind]['meta'] = '˃ o = 100%';
$data2020['PICA'][$ind]['meta'] = '˃ o = 100%';

/* ===== Query NUMERADOR medico ===== */
$sql_numerador = "SELECT e.Comuna, e.alias_estab, r.Mes, sum(ifnull(Col01,0)) as numerador
                   FROM {$year}rems r
                   LEFT JOIN {$year}establecimientos e
                   ON r.IdEstablecimiento=e.Codigo
                   WHERE CodigoPrestacion in (01010101, 01010201, 01080001, 01110106, 01080030, 01010601, 01010901, 01010401,
                                              02010101,
                                              03010501, 03030190, '01030100A', '01030300C', 01200010, 03030140, 01200031,
                                              03030101,
                                              03020101, 03020201, 03020301, 03020402, 03020403, 03020401, 03040210, 03040220, 04040100, 04025010, 04025020, 04025025, 04040427, 03020501,
                                              03030290,
                                              04040423)
                   AND p_equidad_rural = 1
                   GROUP BY e.Comuna, e.alias_estab, r.Mes
                   ORDER BY e.Comuna, e.alias_estab, r.Mes";
$numeradores = DB::connection('mysql_rem')->select($sql_numerador);

foreach($numeradores as $registro) {
     if( ($flag1 != $registro->Comuna) OR ($flag2 != $registro->alias_estab) ) {
         for($mes=1; $mes <= $ultimo_rem; $mes++) {
             $data2020[$registro->Comuna][$ind][$registro->alias_estab]['numeradores_m'][$mes] = 0;
         }
         $flag1 = $registro->Comuna;
         $flag2 = $registro->alias_estab;
     }
     $data2020[$registro->Comuna][$ind][$registro->alias_estab]['numeradores_m'][$registro->Mes] = $registro->numerador;
}

/* ===== Query NUMERADOR no medico ===== */

$sql_numerador = "SELECT e.Comuna, e.alias_estab, r.Mes, sum(ifnull(Col01,0)) as numerador
                   FROM {$year}rems r
                   LEFT JOIN {$year}establecimientos e
                   ON r.IdEstablecimiento=e.Codigo
                   WHERE CodigoPrestacion in (01010103, 01010203, 01080002, 01110107, 01080040, 01010603, 01010903, 01010403,
                                              02010201, 02010103, 02010105,
                                              03010502, 03010504, 03010505, 03030200, '01030200B', '01030400D', 01200020, 01200030, 03030150, 03030170, 03030160, 03030180, 01200032, 01200033, 01200034, 01200035,
                                              03030102, 03030103, 03030104, 03030350, 03030110,
                                              03020702, 04025030, 04025040, 04040200, 04025050, 04050100, 03020604, 04050110, 04050120, 03020908, 03030250, 03030270, 03030280, 03020806,
                                              04040400,
                                              04050130, 04040402, 04025073, 04040407,
                                              04040417, 04040418, 04040419,
                                              04040424, 04040425, 04040426)
                   AND p_equidad_rural = 1
                   GROUP BY e.Comuna, e.alias_estab, r.Mes
                   ORDER BY e.Comuna, e.alias_estab, r.Mes";
$numeradores = DB::connection('mysql_rem')->select($sql_numerador);

foreach($numeradores as $registro) {
     if( ($flag1 != $registro->Comuna) OR ($flag2 != $registro->alias_estab) ) {
         for($mes=1; $mes <= $ultimo_rem; $mes++) {
             $data2020[$registro->Comuna][$ind][$registro->alias_estab]['numeradores_nm'][$mes] = 0;
         }
         $flag1 = $registro->Comuna;
         $flag2 = $registro->alias_estab;
     }
     $data2020[$registro->Comuna][$ind][$registro->alias_estab]['numeradores_nm'][$registro->Mes] = $registro->numerador;
}

/* ==== Query DENOMINADOR medico ==== */
$sql_denominador = "SELECT e.Comuna, e.alias_estab, r.Mes, sum(ifnull(Col01,0)) as denominador
                   FROM {$last_year}rems r
                   LEFT JOIN {$last_year}establecimientos e
                   ON r.IdEstablecimiento=e.Codigo
                   WHERE CodigoPrestacion in (01010101, 01010201, 01080001, 01110106, 01080030, 01010601, 01010901, 01010401,
                                              02010101,
                                              03010501, 03030190, '01030100A', '01030300C', 01200010, 03030140, 01200031,
                                              03030101,
                                              03020101, 03020201, 03020301, 03020402, 03020403, 03020401, 03040210, 03040220, 04040100, 04025010, 04025020, 04025025, 04040427, 03020501,
                                              03030290,
                                              04040423)
                   AND Mes <= $ultimo_rem
                   AND e.p_equidad_rural = 1
                   GROUP BY e.Comuna, e.alias_estab, r.Mes
                   ORDER BY e.Comuna, e.alias_estab, r.Mes";
$denominadores = DB::connection('mysql_rem')->select($sql_denominador);

foreach($denominadores as $registro) {
     if( ($flag1 != $registro->Comuna) OR ($flag2 != $registro->alias_estab) ) {
         for($mes=1; $mes <= $ultimo_rem; $mes++) {
             $data2020[$registro->Comuna][$ind][$registro->alias_estab]['denominadores_m'][$mes] = 0;
         }
         $flag1 = $registro->Comuna;
         $flag2 = $registro->alias_estab;
     }
     $data2020[$registro->Comuna][$ind][$registro->alias_estab]['denominadores_m'][$registro->Mes] = $registro->denominador;
}

/* ==== Query DENOMINADOR no medico ==== */
$sql_denominador = "SELECT e.Comuna, e.alias_estab, r.Mes, sum(ifnull(Col01,0)) as denominador
                   FROM {$last_year}rems r
                   LEFT JOIN {$last_year}establecimientos e
                   ON r.IdEstablecimiento=e.Codigo
                   WHERE CodigoPrestacion in (01010103, 01010203, 01080002, 01110107, 01080040, 01010603, 01010903, 01010403,
                                              02010201, 02010103, 02010105,
                                              03010502, 03010504, 03010505, 03030200, '01030200B', '01030400D', 01200020, 01200030, 03030150, 03030170, 03030160, 03030180, 01200032, 01200033, 01200034, 01200035,
                                              03030102, 03030103, 03030104, 03030350, 03030110,
                                              03020702, 04025030, 04025040, 04040200, 04025050, 04050100, 03020604, 04050110, 04050120, 03020908, 03030250, 03030270, 03030280, 03020806,
                                              04040400,
                                              04050130, 04040402, 04025073, 04040407,
                                              04040417, 04040418, 04040419,
                                              04040424, 04040425, 04040426)
                   AND Mes <= $ultimo_rem
                   AND e.p_equidad_rural = 1
                   GROUP BY e.Comuna, e.alias_estab, r.Mes
                   ORDER BY e.Comuna, e.alias_estab, r.Mes";
$denominadores = DB::connection('mysql_rem')->select($sql_denominador);

foreach($denominadores as $registro) {
     if( ($flag1 != $registro->Comuna) OR ($flag2 != $registro->alias_estab) ) {
         for($mes=1; $mes <= $ultimo_rem; $mes++) {
             $data2020[$registro->Comuna][$ind][$registro->alias_estab]['denominadores_nm'][$mes] = 0;
         }
         $flag1 = $registro->Comuna;
         $flag2 = $registro->alias_estab;
     }
     $data2020[$registro->Comuna][$ind][$registro->alias_estab]['denominadores_nm'][$registro->Mes] = $registro->denominador;
}

/* ==== Calculos ==== */
foreach($data2020 as $nombre_comuna => $comuna) {
  foreach($comuna as $nro_ind => $indicador) {
    foreach($indicador as $nombre_establecimiento => $establecimiento) {
         /* Existe en el array un indice ['numerador'], ['denominador'] y ['meta'],
          * estos almacenan la información de la comuna, por lo tanto tengo que saltarlos
          * en la iteración del foreach y continuar con los establecimientos */
         /* Realizar los calculos mensuales */
         if($nombre_establecimiento != 'numerador' AND
            $nombre_establecimiento != 'numeradores_m' AND
            $nombre_establecimiento != 'numeradores_nm' AND
            $nombre_establecimiento != 'denominador' AND
            $nombre_establecimiento != 'denominadores_m' AND
            $nombre_establecimiento != 'denominadores_nm' AND
            $nombre_establecimiento != 'meta' AND
            $nombre_establecimiento != 'cumplimiento' AND
            $nro_ind == $ind){

             /* Calcula numeradores totales de cada establecimiento */
             $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['numeradores_m']['total'] = array_sum($establecimiento['numeradores_m']);
             $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['numeradores_nm']['total'] = array_sum($establecimiento['numeradores_nm']);

             $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['denominadores_m']['total'] = array_sum($establecimiento['denominadores_m']);
             $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['denominadores_nm']['total'] = array_sum($establecimiento['denominadores_nm']);

             $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['numerador'] = $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['numeradores_m']['total'] +
                $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['numeradores_nm']['total'];

            $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['denominador'] = $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['denominadores_m']['total'] +
               $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['denominadores_nm']['total'];

             /* Calcula la suma mensual de numeradores por comuna */
             for($mes=1; $mes <= $ultimo_rem; $mes++) {
                 $data2020[$nombre_comuna][$ind]['numeradores_m'][$mes] += $establecimiento['numeradores_m'][$mes];
                 $data2020[$nombre_comuna][$ind]['numeradores_nm'][$mes] += $establecimiento['numeradores_nm'][$mes];

                 $data2020[$nombre_comuna][$ind]['denominadores_m'][$mes] += $establecimiento['denominadores_m'][$mes];
                 $data2020[$nombre_comuna][$ind]['denominadores_nm'][$mes] += $establecimiento['denominadores_nm'][$mes];
             }

             /* Calcula el numerador total de cada comuna */
             $data2020[$nombre_comuna][$ind]['numeradores_m']['total'] += $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['numeradores_m']['total'];
             $data2020[$nombre_comuna][$ind]['numeradores_nm']['total'] += $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['numeradores_nm']['total'];
             $data2020[$nombre_comuna][$ind]['denominadores_m']['total'] += $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['denominadores_m']['total'];
             $data2020[$nombre_comuna][$ind]['denominadores_nm']['total'] += $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['denominadores_nm']['total'];

             /* Calcula la suma de numeradores medicos y no medicos por comuna */
             $data2020[$nombre_comuna][$ind]['numerador'] = $data2020[$nombre_comuna][$ind]['numeradores_m']['total'] + $data2020[$nombre_comuna][$ind]['numeradores_nm']['total'];
             $data2020[$nombre_comuna][$ind]['denominador'] = $data2020[$nombre_comuna][$ind]['denominadores_m']['total'] + $data2020[$nombre_comuna][$ind]['denominadores_nm']['total'];

             /* Calculo de las metas de cada establecimiento */
             if($data2020[$nombre_comuna][$ind][$nombre_establecimiento]['denominador'] == 0) {
                 /* Si es 0 el denominadore entonces la cumplimiento es 0 */
                 $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['cumplimiento'] = 0;
             }
             else {
                 $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['cumplimiento'] =
                     $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['numerador'] / $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['denominador'] * 100;
             }

             /* Calculo de las metas de la comuna */
             if($data2020[$nombre_comuna][$ind]['denominador'] == 0) {
                 /* Si es 0 el denominadore entonces la cumplimiento es 0 */
                 $data2020[$nombre_comuna][$ind]['cumplimiento'] = 0;
             }
             else {
                 /* De lo contrario calcular el porcentaje */
                 $data2020[$nombre_comuna][$ind]['cumplimiento'] = $data2020[$nombre_comuna][$ind]['numerador'] / $data2020[$nombre_comuna][$ind]['denominador'] * 100;
             }
         }
     }
   }
}

// Indicador 2

$ind = 2;
$label[$ind]['meta'] = '2-. Cobertura familias evalauda en establecimento.';
$label[$ind]['numerador'] = 'N° Familias evalaudas con cartola/encuesta familiar.';
$label[$ind]['denominador'] = 'N° Familias inscritas.';
$label[$ind]['fuente_numerador'] = 'REM P';
$label[$ind]['fuente_denominador'] = 'REM P';
$label[$ind]['ponderacion'] = '';

$meses = array(1,2,3,4,5,6,7,8,9,10,11,12);
$flag1 = NULL;
$flag2 = NULL;

$sql_establecimientos ='SELECT comuna, alias_estab
                        FROM 2020establecimientos
                        WHERE p_equidad_rural = 1
                        ORDER BY comuna, id_establecimiento';

$establecimientos = DB::connection('mysql_rem')->select($sql_establecimientos);

  /* ==== Inicializar en 0 el arreglo de datos $data2020 ==== */
foreach($establecimientos as $establecimiento) {
    // $data2020[$establecimiento->comuna][$ind]['numeradores']['total'] = 0;
    $data2020[$establecimiento->comuna][$ind]['numerador'] = 0;
    $data2020[$establecimiento->comuna][$ind]['numerador_a'] = 0;
    $data2020[$establecimiento->comuna][$ind]['numerador_6'] = 0;
    $data2020[$establecimiento->comuna][$ind]['numerador_12'] = 0;
    // $data2020[$establecimiento->comuna][$ind]['denominadores']['total'] = 0;
    $data2020[$establecimiento->comuna][$ind]['denominador'] = 0;
    $data2020[$establecimiento->comuna][$ind]['denominador_a'] = 0;
    $data2020[$establecimiento->comuna][$ind]['denominador_6'] = 0;
    $data2020[$establecimiento->comuna][$ind]['denominador_12'] = 0;
    $data2020[$establecimiento->comuna][$ind]['cumplimiento'] = 0;
    for($mes=1; $mes <= $ultimo_rem; $mes++) {
        $data2020[$establecimiento->comuna][$ind][$establecimiento->alias_estab]['numerador'] = 0;
        $data2020[$establecimiento->comuna][$ind][$establecimiento->alias_estab]['numerador_a'] = 0;
        $data2020[$establecimiento->comuna][$ind][$establecimiento->alias_estab]['numerador_6'] = 0;
        $data2020[$establecimiento->comuna][$ind][$establecimiento->alias_estab]['numerador_12'] = 0;

        $data2020[$establecimiento->comuna][$ind][$establecimiento->alias_estab]['denominador'] = 0;
        $data2020[$establecimiento->comuna][$ind][$establecimiento->alias_estab]['denominador_a'] = 0;
        $data2020[$establecimiento->comuna][$ind][$establecimiento->alias_estab]['denominador_6'] = 0;
        $data2020[$establecimiento->comuna][$ind][$establecimiento->alias_estab]['denominador_12'] = 0;
    }
    $data2020[$establecimiento->comuna][$ind][$establecimiento->alias_estab]['cumplimiento'] = 0;
}

if($ultimo_rem <= 11){
  $data2020['CAMIÑA'][$ind]['meta'] = '30%';
  $data2020['COLCHANE'][$ind]['meta'] = '30%';
  $data2020['HUARA'][$ind]['meta'] = '30%';
  $data2020['PICA'][$ind]['meta'] = '30%';
  $data2020['POZO ALMONTE'][$ind]['meta'] = '30%';
}
else {
  $data2020['CAMIÑA'][$ind]['meta'] = '60%';
  $data2020['COLCHANE'][$ind]['meta'] = '60%';
  $data2020['HUARA'][$ind]['meta'] = '60%';
  $data2020['PICA'][$ind]['meta'] = '60%';
  $data2020['POZO ALMONTE'][$ind]['meta'] = '60%';
}

/* ===== Query numerador ===== */
$sql_numerador = "SELECT e.Comuna, e.alias_estab, r.Mes, sum(ifnull(Col01,0)) as numerador
                    FROM {$year}rems r
                    LEFT JOIN {$year}establecimientos e
                    ON r.IdEstablecimiento=e.Codigo
                    WHERE CodigoPrestacion in ('P7010200','P7010500') AND e.p_equidad_rural = 1
                    AND (r.Mes = '6' OR r.Mes = '12')
                    GROUP BY e.Comuna, e.alias_estab, r.Mes
                    ORDER BY e.Comuna, e.alias_estab, r.Mes";
$valores = DB::connection('mysql_rem')->select($sql_numerador);

foreach($valores as $valor) {
    switch ($valor->Mes) {
        case 6:
              $data2020[$valor->Comuna][$ind][$valor->alias_estab]['numerador_6'] = $valor->numerador;
          break;
        case 12;
              $data2020[$valor->Comuna][$ind][$valor->alias_estab]['numerador_12'] = $valor->numerador;
          break;
    }
}

/* ===== Query denominador ===== */
$sql_denominador = "SELECT e.Comuna, e.alias_estab, r.Mes, sum(ifnull(Col01,0)) as denominador
                    FROM {$year}rems r
                    LEFT JOIN {$year}establecimientos e
                    ON r.IdEstablecimiento=e.Codigo
                    WHERE CodigoPrestacion in ('P7010100','P7010400') AND e.p_equidad_rural = 1
                    AND (r.Mes = '6' OR r.Mes = '12')
                    GROUP BY e.Comuna, e.alias_estab, r.Mes
                    ORDER BY e.Comuna, e.alias_estab, r.Mes";
$valores = DB::connection('mysql_rem')->select($sql_denominador);

foreach($valores as $valor) {
    switch ($valor->Mes) {
        case 6:
              $data2020[$valor->Comuna][$ind][$valor->alias_estab]['denominador_6'] = $valor->denominador;
          break;
        case 12:
              $data2020[$valor->Comuna][$ind][$valor->alias_estab]['denominador_12'] = $valor->denominador;
          break;
    }
}

/* ==== Calculos ==== */
foreach($data2020 as $nombre_comuna => $comuna) {
  foreach($comuna as $nro_ind => $indicador) {
    foreach($indicador as $nombre_establecimiento => $establecimiento) {
        /* Existe en el array un indice ['numerador'], ['denominador'] y ['meta'],
           * estos almacenan la información de la comuna, por lo tanto tengo que saltarlos
           * en la iteración del foreach y continuar con los establecimientos */
        /* Realizar los calculos mensuales */
        if($nombre_establecimiento != 'numerador' AND
              $nombre_establecimiento != 'numerador_a' AND
              $nombre_establecimiento != 'numerador_6' AND
              $nombre_establecimiento != 'numerador_12' AND
              $nombre_establecimiento != 'denominador' AND
              $nombre_establecimiento != 'denominador_a' AND
              $nombre_establecimiento != 'denominador_6' AND
              $nombre_establecimiento != 'denominador_12' AND
              $nombre_establecimiento != 'meta' AND
              $nombre_establecimiento != 'cumplimiento' AND
              $nro_ind == $ind){

            /* Calcula el denominador total de cada comuna según REM */
            // $data2020[$nombre_comuna][$ind]['numerador_a'] += $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['numerador_a'];
            $data2020[$nombre_comuna][$ind]['numerador_6'] += $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['numerador_6'];
            $data2020[$nombre_comuna][$ind]['numerador_12'] += $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['numerador_12'];

            // $data2020[$nombre_comuna][$ind]['denominador_a'] += $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['denominador_a'];
            $data2020[$nombre_comuna][$ind]['denominador_6'] += $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['denominador_6'];
            $data2020[$nombre_comuna][$ind]['denominador_12'] += $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['denominador_12'];

            //Asigna el denominador por establecimiento y comunal para los calculos.
            if($ultimo_rem >= 6 && $ultimo_rem <= 11){

                $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['denominador'] = $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['denominador_6'];
                $data2020[$nombre_comuna][$ind]['denominador'] = $data2020[$nombre_comuna][$ind]['denominador_6'];

                $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['numerador'] = $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['numerador_6'];
                $data2020[$nombre_comuna][$ind]['numerador'] = $data2020[$nombre_comuna][$ind]['numerador_6'];
            }
            elseif($ultimo_rem == 12) {
                $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['numerador'] = $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['numerador_12'];
                $data2020[$nombre_comuna][$ind]['numerador'] = $data2020[$nombre_comuna][$ind]['numerador_12'];

                $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['denominador'] = $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['denominador_12'];
                $data2020[$nombre_comuna][$ind]['denominador'] = $data2020[$nombre_comuna][$ind]['denominador_12'];
            }
            else{
                $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['numerador'] = 0;
                $data2020[$nombre_comuna][$ind]['numerador'] = 0;

                $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['denominador'] = 0;
                $data2020[$nombre_comuna][$ind]['denominador'] = 0;
            }

            /* Calculo de las metas de cada establecimiento */
            if($data2020[$nombre_comuna][$ind][$nombre_establecimiento]['denominador'] == 0) {
                /* Si es 0 el denominadore entonces la cumplimiento es 0 */
                $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['cumplimiento'] = 0;
            }
            else {
                $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['cumplimiento'] =
                    $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['numerador'] / $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['denominador'] * 100;
            }

            /* Calculo de las metas de la comuna */
            if($data2020[$nombre_comuna][$ind]['denominador'] == 0) {
                /* Si es 0 el denominadore entonces la cumplimiento es 0 */
                $data2020[$nombre_comuna][$ind]['cumplimiento'] = 0;
            }
            else {
                /* De lo contrario calcular el porcentaje */
                $data2020[$nombre_comuna][$ind]['cumplimiento'] = $data2020[$nombre_comuna][$ind]['numerador'] / $data2020[$nombre_comuna][$ind]['denominador'] * 100;
            }
        }
    }
  }
}

// Indicador 3

$ind = 3;
$label[$ind]['meta'] = '3-. Cobertura familias evalauda en riesgo con plan de
    intervención en establecieminto.';
$label[$ind]['numerador'] = 'N° Familias evalaudas en riesgo con plan de intervención.';
$label[$ind]['denominador'] = 'N° Total de familias evalaudas en riesgo (alto,
    Medio y bajo).';
$label[$ind]['fuente_numerador'] = 'REM P';
$label[$ind]['fuente_denominador'] = 'REM P';
$label[$ind]['ponderacion'] = '';

$meses = array(1,2,3,4,5,6,7,8,9,10,11,12);
$flag1 = NULL;
$flag2 = NULL;

$sql_establecimientos ='SELECT comuna, alias_estab
                        FROM 2020establecimientos
                        WHERE p_equidad_rural = 1
                        ORDER BY comuna, id_establecimiento';

$establecimientos = DB::connection('mysql_rem')->select($sql_establecimientos);

  /* ==== Inicializar en 0 el arreglo de datos $data2020 ==== */
foreach($establecimientos as $establecimiento) {
    // $data2020[$establecimiento->comuna][$ind]['numeradores']['total'] = 0;
    $data2020[$establecimiento->comuna][$ind]['numerador'] = 0;
    $data2020[$establecimiento->comuna][$ind]['numerador_a'] = 0;
    $data2020[$establecimiento->comuna][$ind]['numerador_6'] = 0;
    $data2020[$establecimiento->comuna][$ind]['numerador_12'] = 0;
    // $data2020[$establecimiento->comuna][$ind]['denominadores']['total'] = 0;
    $data2020[$establecimiento->comuna][$ind]['denominador'] = 0;
    $data2020[$establecimiento->comuna][$ind]['denominador_a'] = 0;
    $data2020[$establecimiento->comuna][$ind]['denominador_6'] = 0;
    $data2020[$establecimiento->comuna][$ind]['denominador_12'] = 0;
    $data2020[$establecimiento->comuna][$ind]['cumplimiento'] = 0;
    for($mes=1; $mes <= $ultimo_rem; $mes++) {
        $data2020[$establecimiento->comuna][$ind][$establecimiento->alias_estab]['numerador'] = 0;
        $data2020[$establecimiento->comuna][$ind][$establecimiento->alias_estab]['numerador_a'] = 0;
        $data2020[$establecimiento->comuna][$ind][$establecimiento->alias_estab]['numerador_6'] = 0;
        $data2020[$establecimiento->comuna][$ind][$establecimiento->alias_estab]['numerador_12'] = 0;

        $data2020[$establecimiento->comuna][$ind][$establecimiento->alias_estab]['denominador'] = 0;
        $data2020[$establecimiento->comuna][$ind][$establecimiento->alias_estab]['denominador_a'] = 0;
        $data2020[$establecimiento->comuna][$ind][$establecimiento->alias_estab]['denominador_6'] = 0;
        $data2020[$establecimiento->comuna][$ind][$establecimiento->alias_estab]['denominador_12'] = 0;
    }
    $data2020[$establecimiento->comuna][$ind][$establecimiento->alias_estab]['cumplimiento'] = 0;
}

if($ultimo_rem <= 11){
  $data2020['CAMIÑA'][$ind]['meta'] = '10%';
  $data2020['COLCHANE'][$ind]['meta'] = '10%';
  $data2020['HUARA'][$ind]['meta'] = '10%';
  $data2020['PICA'][$ind]['meta'] = '10%';
  $data2020['POZO ALMONTE'][$ind]['meta'] = '10%';
}
else {
  $data2020['CAMIÑA'][$ind]['meta'] = '20%';
  $data2020['COLCHANE'][$ind]['meta'] = '20%';
  $data2020['HUARA'][$ind]['meta'] = '20%';
  $data2020['PICA'][$ind]['meta'] = '20%';
  $data2020['POZO ALMONTE'][$ind]['meta'] = '20%';
}

/* ===== Query numerador ===== */
$sql_numerador = "SELECT e.Comuna, e.alias_estab, r.Mes, sum(ifnull(Col01,0)) as numerador
                    FROM {$year}rems r
                    LEFT JOIN {$year}establecimientos e
                    ON r.IdEstablecimiento=e.Codigo
                    WHERE CodigoPrestacion in ('P7200500') AND e.p_equidad_rural = 1
                    AND (r.Mes = '6' OR r.Mes = '12')
                    GROUP BY e.Comuna, e.alias_estab, r.Mes
                    ORDER BY e.Comuna, e.alias_estab, r.Mes";
$valores = DB::connection('mysql_rem')->select($sql_numerador);

foreach($valores as $valor) {
    switch ($valor->Mes) {
        case 6:
              $data2020[$valor->Comuna][$ind][$valor->alias_estab]['numerador_6'] = $valor->numerador;
          break;
        case 12;
              $data2020[$valor->Comuna][$ind][$valor->alias_estab]['numerador_12'] = $valor->numerador;
          break;
    }
}

/* ===== Query denominador ===== */
$sql_denominador = "SELECT e.Comuna, e.alias_estab, r.Mes, sum(ifnull(Col01,0)) as denominador
                    FROM {$year}rems r
                    LEFT JOIN {$year}establecimientos e
                    ON r.IdEstablecimiento=e.Codigo
                    WHERE CodigoPrestacion in ('P7010300','P7200100','P7200200','P7010600','P7200300','P7200400') AND e.p_equidad_rural = 1
                    AND (r.Mes = '6' OR r.Mes = '12')
                    GROUP BY e.Comuna, e.alias_estab, r.Mes
                    ORDER BY e.Comuna, e.alias_estab, r.Mes";
$valores = DB::connection('mysql_rem')->select($sql_denominador);

foreach($valores as $valor) {
    switch ($valor->Mes) {
        case 6:
              $data2020[$valor->Comuna][$ind][$valor->alias_estab]['denominador_6'] = $valor->denominador;
          break;
        case 12:
              $data2020[$valor->Comuna][$ind][$valor->alias_estab]['denominador_12'] = $valor->denominador;
          break;
    }
}

/* ==== Calculos ==== */
foreach($data2020 as $nombre_comuna => $comuna) {
  foreach($comuna as $nro_ind => $indicador) {
    foreach($indicador as $nombre_establecimiento => $establecimiento) {
        /* Existe en el array un indice ['numerador'], ['denominador'] y ['meta'],
           * estos almacenan la información de la comuna, por lo tanto tengo que saltarlos
           * en la iteración del foreach y continuar con los establecimientos */
        /* Realizar los calculos mensuales */
        if($nombre_establecimiento != 'numerador' AND
              $nombre_establecimiento != 'numerador_a' AND
              $nombre_establecimiento != 'numerador_6' AND
              $nombre_establecimiento != 'numerador_12' AND
              $nombre_establecimiento != 'denominador' AND
              $nombre_establecimiento != 'denominador_a' AND
              $nombre_establecimiento != 'denominador_6' AND
              $nombre_establecimiento != 'denominador_12' AND
              $nombre_establecimiento != 'meta' AND
              $nombre_establecimiento != 'cumplimiento' AND
              $nro_ind == $ind){

            /* Calcula el denominador total de cada comuna según REM */
            // $data2020[$nombre_comuna][$ind]['numerador_a'] += $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['numerador_a'];
            $data2020[$nombre_comuna][$ind]['numerador_6'] += $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['numerador_6'];
            $data2020[$nombre_comuna][$ind]['numerador_12'] += $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['numerador_12'];

            // $data2020[$nombre_comuna][$ind]['denominador_a'] += $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['denominador_a'];
            $data2020[$nombre_comuna][$ind]['denominador_6'] += $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['denominador_6'];
            $data2020[$nombre_comuna][$ind]['denominador_12'] += $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['denominador_12'];

            //Asigna el denominador por establecimiento y comunal para los calculos.
            if($ultimo_rem >= 6 && $ultimo_rem <= 11){

                $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['denominador'] = $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['denominador_6'];
                $data2020[$nombre_comuna][$ind]['denominador'] = $data2020[$nombre_comuna][$ind]['denominador_6'];

                $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['numerador'] = $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['numerador_6'];
                $data2020[$nombre_comuna][$ind]['numerador'] = $data2020[$nombre_comuna][$ind]['numerador_6'];
            }
            elseif($ultimo_rem == 12) {
                $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['numerador'] = $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['numerador_12'];
                $data2020[$nombre_comuna][$ind]['numerador'] = $data2020[$nombre_comuna][$ind]['numerador_12'];

                $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['denominador'] = $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['denominador_12'];
                $data2020[$nombre_comuna][$ind]['denominador'] = $data2020[$nombre_comuna][$ind]['denominador_12'];
            }
            else{
                $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['numerador'] = 0;
                $data2020[$nombre_comuna][$ind]['numerador'] = 0;

                $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['denominador'] = 0;
                $data2020[$nombre_comuna][$ind]['denominador'] = 0;
            }

            /* Calculo de las metas de cada establecimiento */
            if($data2020[$nombre_comuna][$ind][$nombre_establecimiento]['denominador'] == 0) {
                /* Si es 0 el denominadore entonces la cumplimiento es 0 */
                $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['cumplimiento'] = 0;
            }
            else {
                $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['cumplimiento'] =
                    $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['numerador'] / $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['denominador'] * 100;
            }

            /* Calculo de las metas de la comuna */
            if($data2020[$nombre_comuna][$ind]['denominador'] == 0) {
                /* Si es 0 el denominadore entonces la cumplimiento es 0 */
                $data2020[$nombre_comuna][$ind]['cumplimiento'] = 0;
            }
            else {
                /* De lo contrario calcular el porcentaje */
                $data2020[$nombre_comuna][$ind]['cumplimiento'] = $data2020[$nombre_comuna][$ind]['numerador'] / $data2020[$nombre_comuna][$ind]['denominador'] * 100;
            }
        }
    }
  }
}
