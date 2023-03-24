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
$label[$ind]['meta'] = '1-. Cumplimiento Actividad medica Proyectada en Oftalmologia.';
$label[$ind]['numerador'] = 'N° de consultas medicas realizadas en UAPO.';
$label[$ind]['denominador'] = 'N° de consultas medicas comprometidas en UAPO.';
$label[$ind]['fuente_numerador'] = 'REM';
$label[$ind]['fuente_denominador'] = '';
$label[$ind]['ponderacion'] = '';

$meses = array(1,2,3,4,5,6,7,8,9,10,11,12);
$flag1 = NULL;
$flag2 = NULL;

$sql_establecimientos ='SELECT comuna, alias_estab
                        FROM 2020establecimientos
                        WHERE Codigo in (102301, 102306, 102305)
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
$data2020['IQUIQUE'][$ind]['meta'] = '100%';

/* ===== Query numerador ===== */
$sql_numerador = "SELECT e.Comuna, e.alias_estab, r.Mes, sum(ifnull(Col01,0)) as numerador
                   FROM {$year}rems r
                   LEFT JOIN {$year}establecimientos e
                   ON r.IdEstablecimiento=e.Codigo
                   WHERE CodigoPrestacion in (29000000)
                   AND Codigo in (102301, 102306, 102305)
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
$data2020['ALTO HOSPICIO'][$ind]['denominador'] = 1500;
$data2020['IQUIQUE'][$ind]['denominador'] = 3000;

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
$label[$ind]['meta'] = '2-. Cumplimiento de actividad TM proyectada.';
$label[$ind]['numerador'] = 'N° de consultas de TM realizadas Vicio de Refracción.';
$label[$ind]['denominador'] = 'N° de consultas de TM comprometidas Vicio de Refracción.';
$label[$ind]['fuente_numerador'] = 'REM';
$label[$ind]['fuente_denominador'] = '';
$label[$ind]['ponderacion'] = '';

$meses = array(1,2,3,4,5,6,7,8,9,10,11,12);
$flag1 = NULL;
$flag2 = NULL;

$sql_establecimientos ='SELECT comuna, alias_estab
                        FROM 2020establecimientos
                        WHERE Codigo in (102301, 102306, 102305, 102303)
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

$data2020['ALTO HOSPICIO'][$ind]['meta'] = '0%';
$data2020['IQUIQUE'][$ind]['meta'] = '0%';
$data2020['POZO ALMONTE'][$ind]['meta'] = '0%';

/* ===== Query numerador ===== */
$sql_numerador = "SELECT e.Comuna, e.alias_estab, r.Mes, sum(ifnull(Col01,0)) as numerador
                   FROM {$year}rems r
                   LEFT JOIN {$year}establecimientos e
                   ON r.IdEstablecimiento=e.Codigo
                   WHERE CodigoPrestacion in (29000002)
                   AND Codigo in (102301, 102306, 102305, 102303)
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
$data2020['ALTO HOSPICIO'][$ind]['denominador'] = 1800;
$data2020['IQUIQUE'][$ind]['denominador'] = 3500;
$data2020['POZO ALMONTE'][$ind]['denominador'] = 300;

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
$label[$ind]['meta'] = '3-. Cumplimiento actividad medica oftalmologica: Glaucoma
    nuevos.';
$label[$ind]['numerador'] = 'N°  de ingreso de Glaucoma en UAPO realizados.';
$label[$ind]['denominador'] = 'N° de ingresos de galucoma en UAPO comprometidos.';
$label[$ind]['fuente_numerador'] = 'REM';
$label[$ind]['fuente_denominador'] = '';
$label[$ind]['ponderacion'] = '';

$meses = array(1,2,3,4,5,6,7,8,9,10,11,12);
$flag1 = NULL;
$flag2 = NULL;

$sql_establecimientos ='SELECT comuna, alias_estab
                        FROM 2020establecimientos
                        WHERE Codigo in (102301, 102306, 102305)
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

$data2020['ALTO HOSPICIO'][$ind]['meta'] = '0%';
$data2020['IQUIQUE'][$ind]['meta'] = '0%';

/* ===== Query numerador ===== */
$sql_numerador = "SELECT e.Comuna, e.alias_estab, r.Mes, sum(ifnull(Col01,0)) as numerador
                   FROM {$year}rems r
                   LEFT JOIN {$year}establecimientos e
                   ON r.IdEstablecimiento=e.Codigo
                   WHERE CodigoPrestacion in (29000004)
                   AND Codigo in (102301, 102306, 102305)
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
$data2020['ALTO HOSPICIO'][$ind]['denominador'] = 100;
$data2020['IQUIQUE'][$ind]['denominador'] = 100;

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
$label[$ind]['meta'] = '4-. Cumplimiento actividad oftalmologica: Glaucomas controles.';
$label[$ind]['numerador'] = 'N° de controles de Glaucoma en UAPO realizados.';
$label[$ind]['denominador'] = 'N° de controles de Glaucoma en UAPO comprometidos.';
$label[$ind]['fuente_numerador'] = 'REM';
$label[$ind]['fuente_denominador'] = '';
$label[$ind]['ponderacion'] = '';

$meses = array(1,2,3,4,5,6,7,8,9,10,11,12);
$flag1 = NULL;
$flag2 = NULL;

$sql_establecimientos ='SELECT comuna, alias_estab
                        FROM 2020establecimientos
                        WHERE Codigo in (102301, 102306, 102305)
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

$data2020['ALTO HOSPICIO'][$ind]['meta'] = '0%';
$data2020['IQUIQUE'][$ind]['meta'] = '0%';

/* ===== Query numerador ===== */
$sql_numerador = "SELECT e.Comuna, e.alias_estab, r.Mes, sum(ifnull(Col01,0)) as numerador
                   FROM {$year}rems r
                   LEFT JOIN {$year}establecimientos e
                   ON r.IdEstablecimiento=e.Codigo
                   WHERE CodigoPrestacion in (29101030)
                   AND Codigo in (102301, 102306, 102305)
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
$data2020['ALTO HOSPICIO'][$ind]['denominador'] = 100;
$data2020['IQUIQUE'][$ind]['denominador'] = 700;

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

// Indicador 5

$ind = 5;
$label[$ind]['meta'] = '5-. Cumplimiento de la actividad TM proyectada en UAPO.';
$label[$ind]['numerador'] = 'N° de atenciones y procedimientos de TM realizados.';
$label[$ind]['denominador'] = 'N° de atenciones y procedimientos de TM programados.';
$label[$ind]['fuente_numerador'] = 'REM';
$label[$ind]['fuente_denominador'] = '';
$label[$ind]['ponderacion'] = '';

$meses = array(1,2,3,4,5,6,7,8,9,10,11,12);
$flag1 = NULL;
$flag2 = NULL;

$sql_establecimientos ='SELECT comuna, alias_estab
                        FROM 2020establecimientos
                        WHERE Codigo in (102301, 102306, 102305)
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

$data2020['ALTO HOSPICIO'][$ind]['meta'] = '0%';
$data2020['IQUIQUE'][$ind]['meta'] = '0%';

/* ===== Query numerador ===== */
$sql_numerador = "SELECT e.Comuna, e.alias_estab, r.Mes, sum(ifnull(Col01,0)) as numerador
                   FROM {$year}rems r
                   LEFT JOIN {$year}establecimientos e
                   ON r.IdEstablecimiento=e.Codigo
                   WHERE CodigoPrestacion in (29000003, 29000034, 29000035, 29000036, 29000037,
                                              29000039, 29000040, 29000042, 29000043, 29000053, 29000054, 29000055, 29000056)
                   AND Codigo in (102301, 102306, 102305)
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
$data2020['ALTO HOSPICIO'][$ind]['denominador'] = 1700;
$data2020['IQUIQUE'][$ind]['denominador'] = 4500;

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

// Indicador 6

$ind = 6;
$label[$ind]['meta'] = '6-. Cumplimiento de la actividad TM proyectada en UAPO.';
$label[$ind]['numerador'] = 'N° de Procedimiento Fondo de Ojo por TM a población
    diabética bajo control realizados.';
$label[$ind]['denominador'] = 'N° de Procedimiento Fondo de Ojo por TM a población
    diabética bajo control comprometidos.';
$label[$ind]['fuente_numerador'] = 'REM';
$label[$ind]['fuente_denominador'] = '';
$label[$ind]['ponderacion'] = '';

$meses = array(1,2,3,4,5,6,7,8,9,10,11,12);
$flag1 = NULL;
$flag2 = NULL;

$sql_establecimientos ='SELECT comuna, alias_estab
                        FROM 2020establecimientos
                        WHERE Codigo in (102301, 102306, 102305)
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

$data2020['ALTO HOSPICIO'][$ind]['meta'] = '0%';
$data2020['IQUIQUE'][$ind]['meta'] = '0%';

/* ===== Query numerador ===== */
$sql_numerador = "SELECT e.Comuna, e.alias_estab, r.Mes, sum(ifnull(Col01,0)) as numerador
                   FROM {$year}rems r
                   LEFT JOIN {$year}establecimientos e
                   ON r.IdEstablecimiento=e.Codigo
                   WHERE CodigoPrestacion in (29000038)
                   AND Codigo in (102301, 102306, 102305)
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
$data2020['ALTO HOSPICIO'][$ind]['denominador'] = 1300;
$data2020['IQUIQUE'][$ind]['denominador'] = 3500;

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

// Indicador 7

$ind = 7;
$label[$ind]['meta'] = '7-. Cumplimientos de la actividad proyectada en Gastroenterologia.';
$label[$ind]['numerador'] = 'N° de consultas gastroenterolgia realizadas por el
    programa.';
$label[$ind]['denominador'] = 'N° de consultas gastroenterolgia comprometidas por
    el programa.';
$label[$ind]['fuente_numerador'] = 'REM';
$label[$ind]['fuente_denominador'] = '';
$label[$ind]['ponderacion'] = '';

$meses = array(1,2,3,4,5,6,7,8,9,10,11,12);
$flag1 = NULL;
$flag2 = NULL;

$sql_establecimientos ='SELECT comuna, alias_estab
                        FROM 2020establecimientos
                        WHERE Codigo in (102300, 102305, 102303)
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

$data2020['ALTO HOSPICIO'][$ind]['meta'] = '0%';
$data2020['IQUIQUE'][$ind]['meta'] = '0%';
$data2020['POZO ALMONTE'][$ind]['meta'] = '0%';

/* ===== Query numerador ===== */
$sql_numerador = "SELECT e.Comuna, e.alias_estab, r.Mes, sum(ifnull(Col01,0)) as numerador
                   FROM {$year}rems r
                   LEFT JOIN {$year}establecimientos e
                   ON r.IdEstablecimiento=e.Codigo
                   WHERE CodigoPrestacion in (29000021)
                   AND Codigo in (102300, 102305, 102303)
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
$data2020['ALTO HOSPICIO'][$ind]['denominador'] = 150;
$data2020['IQUIQUE'][$ind]['denominador'] = 320;
$data2020['POZO ALMONTE'][$ind]['denominador'] = 100;

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

// Indicador 8

$ind = 8;
$label[$ind]['meta'] = '8-. Cumplimiento de la actividad proyectada en Otorrinolaringologia.';
$label[$ind]['numerador'] = 'N° de consultas Otorrinolangologia realizadas por el
    Programa.';
$label[$ind]['denominador'] = 'N° de consultas Otorrinolangologia comprometidas
    por el Programa.';
$label[$ind]['fuente_numerador'] = 'REM';
$label[$ind]['fuente_denominador'] = '';
$label[$ind]['ponderacion'] = '';

$meses = array(1,2,3,4,5,6,7,8,9,10,11,12);
$flag1 = NULL;
$flag2 = NULL;

$sql_establecimientos ='SELECT comuna, alias_estab
                        FROM 2020establecimientos
                        WHERE Codigo in (102300, 102305, 102303)
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

$data2020['ALTO HOSPICIO'][$ind]['meta'] = '0%';
$data2020['IQUIQUE'][$ind]['meta'] = '0%';
$data2020['POZO ALMONTE'][$ind]['meta'] = '0%';

/* ===== Query numerador ===== */
$sql_numerador = "SELECT e.Comuna, e.alias_estab, r.Mes, sum(ifnull(Col01,0)) as numerador
                   FROM {$year}rems r
                   LEFT JOIN {$year}establecimientos e
                   ON r.IdEstablecimiento=e.Codigo
                   WHERE CodigoPrestacion in (29000001)
                   AND Codigo in (102300, 102305, 102303)
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
$data2020['ALTO HOSPICIO'][$ind]['denominador'] = 200;
$data2020['IQUIQUE'][$ind]['denominador'] = 150;
$data2020['POZO ALMONTE'][$ind]['denominador'] = 60;

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

// Indicador 9

$ind = 9;
$label[$ind]['meta'] = '9-. Cumplimiento de la actividad programada en cirugía menor ambulatoria.';
$label[$ind]['numerador'] = 'Nº de Procedimientos cutáneos quirúrgicos de baja complejidad realizadas.';
$label[$ind]['denominador'] = 'Nº de Procedimientos cutáneos quirúrgicos de baja complejidad comprometidos.';
$label[$ind]['fuente_numerador'] = 'REM';
$label[$ind]['fuente_denominador'] = '';
$label[$ind]['ponderacion'] = '';

$meses = array(1,2,3,4,5,6,7,8,9,10,11,12);
$flag1 = NULL;
$flag2 = NULL;

$sql_establecimientos ='SELECT comuna, alias_estab
                        FROM 2020establecimientos
                        WHERE Codigo in (102300, 102305, 102303, 102308, 102304)
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

$data2020['ALTO HOSPICIO'][$ind]['meta'] = '0%';
$data2020['IQUIQUE'][$ind]['meta'] = '0%';
$data2020['POZO ALMONTE'][$ind]['meta'] = '0%';
$data2020['HUARA'][$ind]['meta'] = '0%';
$data2020['PICA'][$ind]['meta'] = '0%';

/* ===== Query numerador ===== */
$sql_numerador = "SELECT e.Comuna, e.alias_estab, r.Mes, sum(ifnull(Col01,0)) as numerador
                   FROM {$year}rems r
                   LEFT JOIN {$year}establecimientos e
                   ON r.IdEstablecimiento=e.Codigo
                   WHERE CodigoPrestacion in (29000027)
                   AND Codigo in (102300, 102305, 102303, 102308, 102304)
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
$data2020['ALTO HOSPICIO'][$ind]['denominador'] = 500;
$data2020['IQUIQUE'][$ind]['denominador'] = 1000;
$data2020['POZO ALMONTE'][$ind]['denominador'] = 20;
$data2020['HUARA'][$ind]['denominador'] = 20;
$data2020['PICA'][$ind]['denominador'] = 20;

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
