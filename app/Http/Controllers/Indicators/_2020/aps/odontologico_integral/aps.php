<?php
namespace App\Http\Controllers\Indicators\_2020;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\Indicators\SingleParameter;

$year = 2020;

$label['programa'] = 'Programa Odontológico Integral.';

// Indicador 1

$ind = 1;
$label[$ind]['meta'] = '1-. Atención odontológica integral en mujeres "Más sonrisas
    para Chile".';
$label[$ind]['numerador'] = 'N° total de altas odontológicas integrales en mujeres
    "Más sonrisas para Chile".';
$label[$ind]['denominador'] = 'N° total de altas odontológicas integrales comprometidas
    en mujeres "Más sonrisas para Chile".';
$label[$ind]['fuente_numerador'] = 'REM';
$label[$ind]['fuente_denominador'] = '';
$label[$ind]['ponderacion'] = '';

$meses = array(1,2,3,4,5,6,7,8,9,10,11,12);
$flag1 = NULL;
$flag2 = NULL;

$sql_establecimientos ='SELECT comuna, alias_estab
                        FROM 2020establecimientos
                        WHERE p_odont_integral = 1
                        ORDER BY comuna, id_establecimiento';

$establecimientos = DB::connection('mysql_rem')->select($sql_establecimientos);

/* ==== Inicializar en 0 el arreglo de datos $data2020 ==== */
foreach($establecimientos as $establecimiento) {
     $data2020[$establecimiento->comuna][$ind]['numeradores']['total'] = 0;
     $data2020[$establecimiento->comuna][$ind]['denominador'] = 0;
     $data2020[$establecimiento->comuna][$ind]['cumplimiento'] = 0;
     for($mes=1; $mes <= $ultimo_rem; $mes++) {
         $data2020[$establecimiento->comuna][$ind]['numeradores'][$mes] = 0;
         $data2020[$establecimiento->comuna][$ind][$establecimiento->alias_estab]['numeradores']['total'] = 0;
         $data2020[$establecimiento->comuna][$ind][$establecimiento->alias_estab]['numeradores'][$mes] = 0;

         //$data2020[$establecimiento->comuna][$ind]['denominador'] = 0;
         $data2020[$establecimiento->comuna][$ind][$establecimiento->alias_estab]['denominador'] = 0;
     }
     $data2020[$establecimiento->comuna][$ind][$establecimiento->alias_estab]['cumplimiento'] = 0;
}

$data2020['ALTO HOSPICIO'][$ind]['meta'] = '100%';
$data2020['CAMIÑA'][$ind]['meta'] = '100%';
$data2020['COLCHANE'][$ind]['meta'] = '100%';
$data2020['HUARA'][$ind]['meta'] = '100%';
$data2020['IQUIQUE'][$ind]['meta'] = '100%';
$data2020['PICA'][$ind]['meta'] = '100%';
$data2020['POZO ALMONTE'][$ind]['meta'] = '100%';

/* ===== Query numerador ===== */
$sql_numerador = "SELECT e.Comuna, e.alias_estab, r.Mes, sum(ifnull(Col01,0)) as numerador
                   FROM {$year}rems r
                   LEFT JOIN {$year}establecimientos e
                   ON r.IdEstablecimiento=e.Codigo
                   WHERE CodigoPrestacion in (09260500, 09260600, 09600103, 09204944, 09400092, 09400093)
                   AND e.p_odont_integral = 1
                   GROUP BY e.Comuna, e.alias_estab, r.Mes
                   ORDER BY e.Comuna, e.alias_estab, r.Mes";
$numeradores = DB::connection('mysql_rem')->select($sql_numerador);

foreach($numeradores as $registro) {
     if( ($flag1 != $registro->Comuna) OR ($flag2 != $registro->alias_estab) ) {
         for($mes=1; $mes <= $ultimo_rem; $mes++) {
             $data2020[$registro->Comuna][$ind][$registro->alias_estab]['numeradores'][$mes] = 0;
         }
         $flag1 = $registro->Comuna;
         $flag2 = $registro->alias_estab;
     }
     $data2020[$registro->Comuna][$ind][$registro->alias_estab]['numeradores'][$registro->Mes] = $registro->numerador;
}

/* denominador */
$data2020['ALTO HOSPICIO'][$ind]['denominador'] = 300;
$data2020['CAMIÑA'][$ind]['denominador'] = 50;
$data2020['COLCHANE'][$ind]['denominador'] = 45;
$data2020['HUARA'][$ind]['denominador'] = 86;
$data2020['IQUIQUE'][$ind]['denominador'] = 150;
$data2020['POZO ALMONTE'][$ind]['denominador'] = 93;
$data2020['PICA'][$ind]['denominador'] = 90;

/* ==== Calculos ==== */
foreach($data2020 as $nombre_comuna => $comuna) {
  foreach($comuna as $nro_ind => $indicador) {
    foreach($indicador as $nombre_establecimiento => $establecimiento) {
         /* Existe en el array un indice ['numerador'], ['denominador'] y ['meta'],
          * estos almacenan la información de la comuna, por lo tanto tengo que saltarlos
          * en la iteración del foreach y continuar con los establecimientos */
         /* Realizar los calculos mensuales */
         if($nombre_establecimiento != 'numeradores' AND
             $nombre_establecimiento != 'denominador' AND
             $nombre_establecimiento != 'meta' AND
             $nombre_establecimiento != 'cumplimiento' AND
             $nro_ind == $ind){

             /* Calcula numeradores totales de cada establecimiento */
             $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['numeradores']['total'] = array_sum($establecimiento['numeradores']);

             /* Calcula la suma mensual de numeradores por comuna */
             for($mes=1; $mes <= $ultimo_rem; $mes++) {
                 $data2020[$nombre_comuna][$ind]['numeradores'][$mes] += $establecimiento['numeradores'][$mes];
             }

             /* Calcula el numerador total de cada comuna */
             $data2020[$nombre_comuna][$ind]['numeradores']['total'] += $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['numeradores']['total'];
             //$data2020[$nombre_comuna][$ind]['denominadores']['total'] += $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['denominadores']['total'];

             /* Calculo de las metas de cada establecimiento */
             if($data2020[$nombre_comuna][$ind][$nombre_establecimiento]['denominador'] == 0) {
                 /* Si es 0 el denominadore entonces la cumplimiento es 0 */
                 $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['cumplimiento'] = 0;
             }
             else {
                 $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['cumplimiento'] =
                     $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['numeradores']['total'] / $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['denominador'] * 100;
             }

             /* Calculo de las metas de la comuna */
             if($data2020[$nombre_comuna][$ind]['denominador'] == 0) {
                 /* Si es 0 el denominadore entonces la cumplimiento es 0 */
                 $data2020[$nombre_comuna][$ind]['cumplimiento'] = 0;
             }
             else {
                 /* De lo contrario calcular el porcentaje */
                 $data2020[$nombre_comuna][$ind]['cumplimiento'] = $data2020[$nombre_comuna][$ind]['numeradores']['total'] / $data2020[$nombre_comuna][$ind]['denominador'] * 100;
             }
         }
     }
   }
}

// Indicador 2

$ind = 2;
$label[$ind]['meta'] = '2-. Atención odontológica integral en Hombres de escasos
    recursos.';
$label[$ind]['numerador'] = 'N° total de altas odontológicas integrales en Hombres
    de escasos recursos.';
$label[$ind]['denominador'] = 'N° total de altas odontológicas integrales comprometidas
    en Hombres de escasos recursos.';
$label[$ind]['fuente_numerador'] = 'REM';
$label[$ind]['fuente_denominador'] = '';
$label[$ind]['ponderacion'] = '';

$meses = array(1,2,3,4,5,6,7,8,9,10,11,12);
$flag1 = NULL;
$flag2 = NULL;

$sql_establecimientos ='SELECT comuna, alias_estab
                        FROM 2020establecimientos
                        WHERE p_odont_integral = 1
                        ORDER BY comuna, id_establecimiento';

$establecimientos = DB::connection('mysql_rem')->select($sql_establecimientos);

/* ==== Inicializar en 0 el arreglo de datos $data2020 ==== */
foreach($establecimientos as $establecimiento) {
     $data2020[$establecimiento->comuna][$ind]['numeradores']['total'] = 0;
     $data2020[$establecimiento->comuna][$ind]['denominador'] = 0;
     $data2020[$establecimiento->comuna][$ind]['cumplimiento'] = 0;
     for($mes=1; $mes <= $ultimo_rem; $mes++) {
         $data2020[$establecimiento->comuna][$ind]['numeradores'][$mes] = 0;
         $data2020[$establecimiento->comuna][$ind][$establecimiento->alias_estab]['numeradores']['total'] = 0;
         $data2020[$establecimiento->comuna][$ind][$establecimiento->alias_estab]['numeradores'][$mes] = 0;

         //$data2020[$establecimiento->comuna][$ind]['denominador'] = 0;
         $data2020[$establecimiento->comuna][$ind][$establecimiento->alias_estab]['denominador'] = 0;
     }
     $data2020[$establecimiento->comuna][$ind][$establecimiento->alias_estab]['cumplimiento'] = 0;
}

$data2020['ALTO HOSPICIO'][$ind]['meta'] = '100%';
$data2020['CAMIÑA'][$ind]['meta'] = '100%';
$data2020['COLCHANE'][$ind]['meta'] = '100%';
$data2020['HUARA'][$ind]['meta'] = '100%';
$data2020['IQUIQUE'][$ind]['meta'] = '100%';
$data2020['PICA'][$ind]['meta'] = '100%';
$data2020['POZO ALMONTE'][$ind]['meta'] = '100%';

/* ===== Query numerador ===== */
$sql_numerador = "SELECT e.Comuna, e.alias_estab, r.Mes, sum(ifnull(Col01,0)) as numerador
                   FROM {$year}rems r
                   LEFT JOIN {$year}establecimientos e
                   ON r.IdEstablecimiento=e.Codigo
                   WHERE CodigoPrestacion in (09500503)
                   AND e.p_odont_integral = 1
                   GROUP BY e.Comuna, e.alias_estab, r.Mes
                   ORDER BY e.Comuna, e.alias_estab, r.Mes";
$numeradores = DB::connection('mysql_rem')->select($sql_numerador);

foreach($numeradores as $registro) {
     if( ($flag1 != $registro->Comuna) OR ($flag2 != $registro->alias_estab) ) {
         for($mes=1; $mes <= $ultimo_rem; $mes++) {
             $data2020[$registro->Comuna][$ind][$registro->alias_estab]['numeradores'][$mes] = 0;
         }
         $flag1 = $registro->Comuna;
         $flag2 = $registro->alias_estab;
     }
     $data2020[$registro->Comuna][$ind][$registro->alias_estab]['numeradores'][$registro->Mes] = $registro->numerador;
}

/* denominador */
$data2020['ALTO HOSPICIO'][$ind]['denominador'] = 250;
$data2020['CAMIÑA'][$ind]['denominador'] = 40;
$data2020['COLCHANE'][$ind]['denominador'] = 10;
$data2020['HUARA'][$ind]['denominador'] = 13;
$data2020['IQUIQUE'][$ind]['denominador'] = 70;
$data2020['POZO ALMONTE'][$ind]['denominador'] = 27;
$data2020['PICA'][$ind]['denominador'] = 28;

/* ==== Calculos ==== */
foreach($data2020 as $nombre_comuna => $comuna) {
  foreach($comuna as $nro_ind => $indicador) {
    foreach($indicador as $nombre_establecimiento => $establecimiento) {
         /* Existe en el array un indice ['numerador'], ['denominador'] y ['meta'],
          * estos almacenan la información de la comuna, por lo tanto tengo que saltarlos
          * en la iteración del foreach y continuar con los establecimientos */
         /* Realizar los calculos mensuales */
         if($nombre_establecimiento != 'numeradores' AND
             $nombre_establecimiento != 'denominador' AND
             $nombre_establecimiento != 'meta' AND
             $nombre_establecimiento != 'cumplimiento' AND
             $nro_ind == $ind){

             /* Calcula numeradores totales de cada establecimiento */
             $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['numeradores']['total'] = array_sum($establecimiento['numeradores']);

             /* Calcula la suma mensual de numeradores por comuna */
             for($mes=1; $mes <= $ultimo_rem; $mes++) {
                 $data2020[$nombre_comuna][$ind]['numeradores'][$mes] += $establecimiento['numeradores'][$mes];
             }

             /* Calcula el numerador total de cada comuna */
             $data2020[$nombre_comuna][$ind]['numeradores']['total'] += $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['numeradores']['total'];
             //$data2020[$nombre_comuna][$ind]['denominadores']['total'] += $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['denominadores']['total'];

             /* Calculo de las metas de cada establecimiento */
             if($data2020[$nombre_comuna][$ind][$nombre_establecimiento]['denominador'] == 0) {
                 /* Si es 0 el denominadore entonces la cumplimiento es 0 */
                 $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['cumplimiento'] = 0;
             }
             else {
                 $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['cumplimiento'] =
                     $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['numeradores']['total'] / $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['denominador'] * 100;
             }

             /* Calculo de las metas de la comuna */
             if($data2020[$nombre_comuna][$ind]['denominador'] == 0) {
                 /* Si es 0 el denominadore entonces la cumplimiento es 0 */
                 $data2020[$nombre_comuna][$ind]['cumplimiento'] = 0;
             }
             else {
                 /* De lo contrario calcular el porcentaje */
                 $data2020[$nombre_comuna][$ind]['cumplimiento'] = $data2020[$nombre_comuna][$ind]['numeradores']['total'] / $data2020[$nombre_comuna][$ind]['denominador'] * 100;
             }
         }
     }
   }
}

// Indicador 3

$ind = 3;
$label[$ind]['meta'] = '3-. Atención odontológica integral a estudiantes que cursen
    cuarto medio y/o su equivalente.';
$label[$ind]['numerador'] = 'N° total de altas odontológicas integrales en estudiantes
    que cursen cuarto medio y/o su equivalente.';
$label[$ind]['denominador'] = 'N° total de altas odontológicas integrales comprometidas
    en estudiantes que cursen cuarto medio y/o su equivalente.';
$label[$ind]['fuente_numerador'] = 'REM';
$label[$ind]['fuente_denominador'] = '';
$label[$ind]['ponderacion'] = '';

$meses = array(1,2,3,4,5,6,7,8,9,10,11,12);
$flag1 = NULL;
$flag2 = NULL;

$sql_establecimientos ='SELECT comuna, alias_estab
                        FROM 2020establecimientos
                        WHERE p_odont_integral = 1
                        ORDER BY comuna, id_establecimiento';

$establecimientos = DB::connection('mysql_rem')->select($sql_establecimientos);

/* ==== Inicializar en 0 el arreglo de datos $data2020 ==== */
foreach($establecimientos as $establecimiento) {
     $data2020[$establecimiento->comuna][$ind]['numeradores']['total'] = 0;
     $data2020[$establecimiento->comuna][$ind]['denominador'] = 0;
     $data2020[$establecimiento->comuna][$ind]['cumplimiento'] = 0;
     for($mes=1; $mes <= $ultimo_rem; $mes++) {
         $data2020[$establecimiento->comuna][$ind]['numeradores'][$mes] = 0;
         $data2020[$establecimiento->comuna][$ind][$establecimiento->alias_estab]['numeradores']['total'] = 0;
         $data2020[$establecimiento->comuna][$ind][$establecimiento->alias_estab]['numeradores'][$mes] = 0;

         //$data2020[$establecimiento->comuna][$ind]['denominador'] = 0;
         $data2020[$establecimiento->comuna][$ind][$establecimiento->alias_estab]['denominador'] = 0;
     }
     $data2020[$establecimiento->comuna][$ind][$establecimiento->alias_estab]['cumplimiento'] = 0;
}

$data2020['ALTO HOSPICIO'][$ind]['meta'] = '100%';
$data2020['CAMIÑA'][$ind]['meta'] = '100%';
$data2020['COLCHANE'][$ind]['meta'] = '100%';
$data2020['HUARA'][$ind]['meta'] = '100%';
$data2020['IQUIQUE'][$ind]['meta'] = '100%';
$data2020['PICA'][$ind]['meta'] = '100%';
$data2020['POZO ALMONTE'][$ind]['meta'] = '100%';

/* ===== Query numerador ===== */
$sql_numerador = "SELECT e.Comuna, e.alias_estab, r.Mes, sum(ifnull(Col01,0)) as numerador
                   FROM {$year}rems r
                   LEFT JOIN {$year}establecimientos e
                   ON r.IdEstablecimiento=e.Codigo
                   WHERE CodigoPrestacion in (09400094, 09400095, 09400096)
                   AND e.p_odont_integral = 1
                   GROUP BY e.Comuna, e.alias_estab, r.Mes
                   ORDER BY e.Comuna, e.alias_estab, r.Mes";
$numeradores = DB::connection('mysql_rem')->select($sql_numerador);

foreach($numeradores as $registro) {
     if( ($flag1 != $registro->Comuna) OR ($flag2 != $registro->alias_estab) ) {
         for($mes=1; $mes <= $ultimo_rem; $mes++) {
             $data2020[$registro->Comuna][$ind][$registro->alias_estab]['numeradores'][$mes] = 0;
         }
         $flag1 = $registro->Comuna;
         $flag2 = $registro->alias_estab;
     }
     $data2020[$registro->Comuna][$ind][$registro->alias_estab]['numeradores'][$registro->Mes] = $registro->numerador;
}

/* denominador */
$data2020['ALTO HOSPICIO'][$ind]['denominador'] = 290;
$data2020['CAMIÑA'][$ind]['denominador'] = 13;
$data2020['COLCHANE'][$ind]['denominador'] = 6;
$data2020['HUARA'][$ind]['denominador'] = 14;
$data2020['IQUIQUE'][$ind]['denominador'] = 984;
$data2020['POZO ALMONTE'][$ind]['denominador'] = 133;
$data2020['PICA'][$ind]['denominador'] = 38;

/* ==== Calculos ==== */
foreach($data2020 as $nombre_comuna => $comuna) {
  foreach($comuna as $nro_ind => $indicador) {
    foreach($indicador as $nombre_establecimiento => $establecimiento) {
         /* Existe en el array un indice ['numerador'], ['denominador'] y ['meta'],
          * estos almacenan la información de la comuna, por lo tanto tengo que saltarlos
          * en la iteración del foreach y continuar con los establecimientos */
         /* Realizar los calculos mensuales */
         if($nombre_establecimiento != 'numeradores' AND
             $nombre_establecimiento != 'denominador' AND
             $nombre_establecimiento != 'meta' AND
             $nombre_establecimiento != 'cumplimiento' AND
             $nro_ind == $ind){

             /* Calcula numeradores totales de cada establecimiento */
             $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['numeradores']['total'] = array_sum($establecimiento['numeradores']);

             /* Calcula la suma mensual de numeradores por comuna */
             for($mes=1; $mes <= $ultimo_rem; $mes++) {
                 $data2020[$nombre_comuna][$ind]['numeradores'][$mes] += $establecimiento['numeradores'][$mes];
             }

             /* Calcula el numerador total de cada comuna */
             $data2020[$nombre_comuna][$ind]['numeradores']['total'] += $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['numeradores']['total'];
             //$data2020[$nombre_comuna][$ind]['denominadores']['total'] += $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['denominadores']['total'];

             /* Calculo de las metas de cada establecimiento */
             if($data2020[$nombre_comuna][$ind][$nombre_establecimiento]['denominador'] == 0) {
                 /* Si es 0 el denominadore entonces la cumplimiento es 0 */
                 $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['cumplimiento'] = 0;
             }
             else {
                 $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['cumplimiento'] =
                     $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['numeradores']['total'] / $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['denominador'] * 100;
             }

             /* Calculo de las metas de la comuna */
             if($data2020[$nombre_comuna][$ind]['denominador'] == 0) {
                 /* Si es 0 el denominadore entonces la cumplimiento es 0 */
                 $data2020[$nombre_comuna][$ind]['cumplimiento'] = 0;
             }
             else {
                 /* De lo contrario calcular el porcentaje */
                 $data2020[$nombre_comuna][$ind]['cumplimiento'] = $data2020[$nombre_comuna][$ind]['numeradores']['total'] / $data2020[$nombre_comuna][$ind]['denominador'] * 100;
             }
         }
     }
   }
}

// Indicador 4

$ind = 4;
$label[$ind]['meta'] = '4-. Atención Odontológica en domicilio.';
$label[$ind]['numerador'] = 'N° total de altas odontológicas a beneficiarios del
    programa de atención domiciliaria a personas con dependencia severa.';
$label[$ind]['denominador'] = 'N° total de altas odontológicas comprometidas a
    beneficiarios del programa de atención domiciliaria a personas con dependencia
    severa.';
$label[$ind]['fuente_numerador'] = 'REM';
$label[$ind]['fuente_denominador'] = '';
$label[$ind]['ponderacion'] = '';

$meses = array(1,2,3,4,5,6,7,8,9,10,11,12);
$flag1 = NULL;
$flag2 = NULL;

$sql_establecimientos ='SELECT comuna, alias_estab
                        FROM 2020establecimientos
                        WHERE p_odont_integral = 1
                        ORDER BY comuna, id_establecimiento';

$establecimientos = DB::connection('mysql_rem')->select($sql_establecimientos);

/* ==== Inicializar en 0 el arreglo de datos $data2020 ==== */
foreach($establecimientos as $establecimiento) {
     $data2020[$establecimiento->comuna][$ind]['numeradores']['total'] = 0;
     $data2020[$establecimiento->comuna][$ind]['denominador'] = 0;
     $data2020[$establecimiento->comuna][$ind]['cumplimiento'] = 0;
     for($mes=1; $mes <= $ultimo_rem; $mes++) {
         $data2020[$establecimiento->comuna][$ind]['numeradores'][$mes] = 0;
         $data2020[$establecimiento->comuna][$ind][$establecimiento->alias_estab]['numeradores']['total'] = 0;
         $data2020[$establecimiento->comuna][$ind][$establecimiento->alias_estab]['numeradores'][$mes] = 0;

         //$data2020[$establecimiento->comuna][$ind]['denominador'] = 0;
         $data2020[$establecimiento->comuna][$ind][$establecimiento->alias_estab]['denominador'] = 0;
     }
     $data2020[$establecimiento->comuna][$ind][$establecimiento->alias_estab]['cumplimiento'] = 0;
}

$data2020['ALTO HOSPICIO'][$ind]['meta'] = '100%';
$data2020['CAMIÑA'][$ind]['meta'] = '100%';
$data2020['COLCHANE'][$ind]['meta'] = '100%';
$data2020['HUARA'][$ind]['meta'] = '100%';
$data2020['IQUIQUE'][$ind]['meta'] = '100%';
$data2020['PICA'][$ind]['meta'] = '100%';
$data2020['POZO ALMONTE'][$ind]['meta'] = '100%';

/* ===== Query numerador ===== */
$sql_numerador = "SELECT e.Comuna, e.alias_estab, r.Mes, sum(ifnull(Col01,0)) as numerador
                   FROM {$year}rems r
                   LEFT JOIN {$year}establecimientos e
                   ON r.IdEstablecimiento=e.Codigo
                   WHERE CodigoPrestacion in (09600151)
                   AND e.p_odont_integral = 1
                   GROUP BY e.Comuna, e.alias_estab, r.Mes
                   ORDER BY e.Comuna, e.alias_estab, r.Mes";
$numeradores = DB::connection('mysql_rem')->select($sql_numerador);

foreach($numeradores as $registro) {
     if( ($flag1 != $registro->Comuna) OR ($flag2 != $registro->alias_estab) ) {
         for($mes=1; $mes <= $ultimo_rem; $mes++) {
             $data2020[$registro->Comuna][$ind][$registro->alias_estab]['numeradores'][$mes] = 0;
         }
         $flag1 = $registro->Comuna;
         $flag2 = $registro->alias_estab;
     }
     $data2020[$registro->Comuna][$ind][$registro->alias_estab]['numeradores'][$registro->Mes] = $registro->numerador;
}

/* denominador */
$data2020['ALTO HOSPICIO'][$ind]['denominador'] = 107;
$data2020['CAMIÑA'][$ind]['denominador'] = 7;
$data2020['COLCHANE'][$ind]['denominador'] = 9;
$data2020['HUARA'][$ind]['denominador'] = 5;
$data2020['IQUIQUE'][$ind]['denominador'] = 100;
$data2020['POZO ALMONTE'][$ind]['denominador'] = 17;
$data2020['PICA'][$ind]['denominador'] = 16;

/* ==== Calculos ==== */
foreach($data2020 as $nombre_comuna => $comuna) {
  foreach($comuna as $nro_ind => $indicador) {
    foreach($indicador as $nombre_establecimiento => $establecimiento) {
         /* Existe en el array un indice ['numerador'], ['denominador'] y ['meta'],
          * estos almacenan la información de la comuna, por lo tanto tengo que saltarlos
          * en la iteración del foreach y continuar con los establecimientos */
         /* Realizar los calculos mensuales */
         if($nombre_establecimiento != 'numeradores' AND
             $nombre_establecimiento != 'denominador' AND
             $nombre_establecimiento != 'meta' AND
             $nombre_establecimiento != 'cumplimiento' AND
             $nro_ind == $ind){

             /* Calcula numeradores totales de cada establecimiento */
             $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['numeradores']['total'] = array_sum($establecimiento['numeradores']);

             /* Calcula la suma mensual de numeradores por comuna */
             for($mes=1; $mes <= $ultimo_rem; $mes++) {
                 $data2020[$nombre_comuna][$ind]['numeradores'][$mes] += $establecimiento['numeradores'][$mes];
             }

             /* Calcula el numerador total de cada comuna */
             $data2020[$nombre_comuna][$ind]['numeradores']['total'] += $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['numeradores']['total'];
             //$data2020[$nombre_comuna][$ind]['denominadores']['total'] += $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['denominadores']['total'];

             /* Calculo de las metas de cada establecimiento */
             if($data2020[$nombre_comuna][$ind][$nombre_establecimiento]['denominador'] == 0) {
                 /* Si es 0 el denominadore entonces la cumplimiento es 0 */
                 $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['cumplimiento'] = 0;
             }
             else {
                 $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['cumplimiento'] =
                     $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['numeradores']['total'] / $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['denominador'] * 100;
             }

             /* Calculo de las metas de la comuna */
             if($data2020[$nombre_comuna][$ind]['denominador'] == 0) {
                 /* Si es 0 el denominadore entonces la cumplimiento es 0 */
                 $data2020[$nombre_comuna][$ind]['cumplimiento'] = 0;
             }
             else {
                 /* De lo contrario calcular el porcentaje */
                 $data2020[$nombre_comuna][$ind]['cumplimiento'] = $data2020[$nombre_comuna][$ind]['numeradores']['total'] / $data2020[$nombre_comuna][$ind]['denominador'] * 100;
             }
         }
     }
   }
}
