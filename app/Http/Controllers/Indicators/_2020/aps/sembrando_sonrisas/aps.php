<?php
namespace App\Http\Controllers\Indicators\_2020;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\Indicators\SingleParameter;

$year = 2020;

$label['programa'] = 'Sembrando Sonrisas.';

// Indicador 1
$ind = 1;
$label[$ind]['meta'] = '1-. Promoción y prevencion en salud bucal en la
    población parvularia.';
$label[$ind]['numerador'] = 'N° de sets de higiene oral entregados a niñas y
    niños de 2 a 5 años.';
$label[$ind]['denominador'] = 'N° de sets de higiene oral comprometidos a niñas
    y niños de 2 a 5 años.';
$label[$ind]['fuente_numerador'] = 'REM';
$label[$ind]['fuente_denominador'] = '';
$label[$ind]['ponderacion'] = '';

$meses = array(1,2,3,4,5,6,7,8,9,10,11,12);
$flag1 = NULL;
$flag2 = NULL;

$sql_establecimientos ='SELECT comuna, alias_estab
                        FROM 2020establecimientos
                        WHERE p_sembrando_sonrisas = 1
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
                   WHERE CodigoPrestacion in (09306600) AND e.p_sembrando_sonrisas = 1
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
$data2020['ALTO HOSPICIO'][$ind]['denominador'] = 2545;
$data2020['CAMIÑA'][$ind]['denominador'] = 95;
$data2020['COLCHANE'][$ind]['denominador'] = 30;
$data2020['HUARA'][$ind]['denominador'] = 160;
$data2020['IQUIQUE'][$ind]['denominador'] = 4504;
$data2020['POZO ALMONTE'][$ind]['denominador'] = 905;
$data2020['PICA'][$ind]['denominador'] = 330;

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
$label[$ind]['meta'] = '2-. Dianostico de la salud bucal en población parvularia
    en contexto comunitario.';
$label[$ind]['numerador'] = 'N° de niñas y niños de 2 a 5 años con examen de salud
    bucal realizados.';
$label[$ind]['denominador'] = 'N° de niñas y niños de 2 a 5 años con examen de
    salud bucal comprometidos.';
$label[$ind]['fuente_numerador'] = 'REM';
$label[$ind]['fuente_denominador'] = '';
$label[$ind]['ponderacion'] = '';

$meses = array(1,2,3,4,5,6,7,8,9,10,11,12);
$flag1 = NULL;
$flag2 = NULL;

$sql_establecimientos ='SELECT comuna, alias_estab
                        FROM 2020establecimientos
                        WHERE p_sembrando_sonrisas = 1
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
                   WHERE CodigoPrestacion in (09400090) AND e.p_sembrando_sonrisas = 1
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
$data2020['ALTO HOSPICIO'][$ind]['denominador'] = 2545;
$data2020['CAMIÑA'][$ind]['denominador'] = 95;
$data2020['COLCHANE'][$ind]['denominador'] = 30;
$data2020['HUARA'][$ind]['denominador'] = 160;
$data2020['IQUIQUE'][$ind]['denominador'] = 4504;
$data2020['POZO ALMONTE'][$ind]['denominador'] = 905;
$data2020['PICA'][$ind]['denominador'] = 330;

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
$label[$ind]['meta'] = '3-. Prevención individual especifica en población parvularia';
$label[$ind]['numerador'] = 'N° de aplicaciones de flúor barniz a niñas y niños
    de 2 a 5 años realizados.';
$label[$ind]['denominador'] = 'N° de aplicaciones de flúor barniz a niñas y niños
    de 2 a 5 años comprometidos.';
$label[$ind]['fuente_numerador'] = 'REM';
$label[$ind]['fuente_denominador'] = '';
$label[$ind]['ponderacion'] = '';

$meses = array(1,2,3,4,5,6,7,8,9,10,11,12);
$flag1 = NULL;
$flag2 = NULL;

$sql_establecimientos ='SELECT comuna, alias_estab
                        FROM 2020establecimientos
                        WHERE p_sembrando_sonrisas = 1
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
                   WHERE CodigoPrestacion in (09306800) AND e.p_sembrando_sonrisas = 1
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
$data2020['ALTO HOSPICIO'][$ind]['denominador'] = 5090;
$data2020['CAMIÑA'][$ind]['denominador'] = 190;
$data2020['COLCHANE'][$ind]['denominador'] = 60;
$data2020['HUARA'][$ind]['denominador'] = 320;
$data2020['IQUIQUE'][$ind]['denominador'] = 9008;
$data2020['POZO ALMONTE'][$ind]['denominador'] = 1810;
$data2020['PICA'][$ind]['denominador'] = 660;

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
