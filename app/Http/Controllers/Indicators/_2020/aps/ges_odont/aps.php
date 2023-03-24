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
$label[$ind]['meta'] = '1-. Egresos odontologicos totales en niños y niñas de 6 años.';
$label[$ind]['numerador'] = 'N° de egresos odontologicos totales en niños y niñas
    6 años .';
$label[$ind]['denominador'] = 'Población inscrita validada año actual de niños y
    niñas de 6 años.';
$label[$ind]['fuente_numerador'] = 'REM';
$label[$ind]['fuente_denominador'] = 'FONASA';
$label[$ind]['ponderacion'] = '';

$meses = array(1,2,3,4,5,6,7,8,9,10,11,12);
$flag1 = NULL;
$flag2 = NULL;

$sql_establecimientos ='SELECT comuna, alias_estab
                        FROM 2020establecimientos
                        WHERE p_ges_odont = 1
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

$data2020['ALTO HOSPICIO'][$ind]['meta'] = '79%';
$data2020['CAMIÑA'][$ind]['meta'] = '79%';
$data2020['COLCHANE'][$ind]['meta'] = '79%';
$data2020['HUARA'][$ind]['meta'] = '79%';
$data2020['IQUIQUE'][$ind]['meta'] = '79%';
$data2020['PICA'][$ind]['meta'] = '79%';
$data2020['POZO ALMONTE'][$ind]['meta'] = '79%';

/* ===== Query numerador ===== */
$sql_numerador = "SELECT e.Comuna, e.alias_estab, r.Mes, sum(ifnull(Col16,0) + ifnull(Col17,0)) as numerador
                   FROM {$year}rems r
                   LEFT JOIN {$year}establecimientos e
                   ON r.IdEstablecimiento=e.Codigo
                   WHERE CodigoPrestacion in (09215413) AND e.p_ges_odont = 1
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

/* ===== Query denominador COMUNA ===== */
$sql_denominador = "SELECT e.alias_estab as nombre, e.Comuna as comuna, COUNT(*) AS denominador
                    FROM 2020percapita p
                    LEFT JOIN 2020establecimientos e ON e.Codigo = p.COD_CENTRO
                    WHERE
                    FECHA_CORTE = '2019-08-31' AND
                    EDAD = 6 AND
                    ACEPTADO_RECHAZADO = 'ACEPTADO'
                    GROUP BY e.Comuna, e.alias_estab
                    ORDER BY e.Comuna, e.alias_estab";

$denominadores = DB::connection('mysql_rem')->select($sql_denominador);

foreach($denominadores as $registro) {
    //$data2020[$registro->comuna][$ind][$registro->nombre]['denominador'] = $registro->denominador;
    $data2020[$registro->comuna][$ind]['denominador'] += $registro->denominador;
}

/* ===== Query denominador ESTAB ===== */
$sql_denominador = "SELECT e.alias_estab as nombre, e.Comuna as comuna, COUNT(*) AS denominador
                    FROM 2020percapita p
                    LEFT JOIN 2020establecimientos e ON e.Codigo = p.COD_CENTRO
                    WHERE
                    FECHA_CORTE = '2019-08-31' AND
                    EDAD = 6 AND
                    ACEPTADO_RECHAZADO = 'ACEPTADO'
                    AND e.p_ges_odont = 1
                    GROUP BY e.Comuna, e.alias_estab
                    ORDER BY e.Comuna, e.alias_estab";

$denominadores = DB::connection('mysql_rem')->select($sql_denominador);

foreach($denominadores as $registro) {
    $data2020[$registro->comuna][$ind][$registro->nombre]['denominador'] = $registro->denominador;
}

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
$label[$ind]['meta'] = '2-. Altas odontologicas totales en embarazadas.';
$label[$ind]['numerador'] = 'N° de altas odontologicos totales en embarazadas.';
$label[$ind]['denominador'] = 'Gestantes ingresadas a programa prenatal.';
$label[$ind]['fuente_numerador'] = 'REM';
$label[$ind]['fuente_denominador'] = 'REM';
$label[$ind]['ponderacion'] = '';

$meses = array(1,2,3,4,5,6,7,8,9,10,11,12);
$flag1 = NULL;
$flag2 = NULL;

$sql_establecimientos ='SELECT comuna, alias_estab
                        FROM 2020establecimientos
                        WHERE p_ges_odont = 1
                        ORDER BY comuna, id_establecimiento';

$establecimientos = DB::connection('mysql_rem')->select($sql_establecimientos);

/* ==== Inicializar en 0 el arreglo de datos $data2020 ==== */
foreach($establecimientos as $establecimiento) {
     $data2020[$establecimiento->comuna][$ind]['numeradores']['total'] = 0;
     $data2020[$establecimiento->comuna][$ind]['denominadores']['total'] = 0;
     $data2020[$establecimiento->comuna][$ind]['cumplimiento'] = 0;
     for($mes=1; $mes <= $ultimo_rem; $mes++) {
         $data2020[$establecimiento->comuna][$ind]['numeradores'][$mes] = 0;
         $data2020[$establecimiento->comuna][$ind][$establecimiento->alias_estab]['numeradores']['total'] = 0;
         $data2020[$establecimiento->comuna][$ind][$establecimiento->alias_estab]['numeradores'][$mes] = 0;

         $data2020[$establecimiento->comuna][$ind]['denominadores'][$mes] = 0;
         $data2020[$establecimiento->comuna][$ind][$establecimiento->alias_estab]['denominadores']['total'] = 0;
         $data2020[$establecimiento->comuna][$ind][$establecimiento->alias_estab]['denominadores'][$mes] = 0;
     }
     $data2020[$establecimiento->comuna][$ind][$establecimiento->alias_estab]['cumplimiento'] = 0;
}

$data2020['ALTO HOSPICIO'][$ind]['meta'] = '68%';
$data2020['CAMIÑA'][$ind]['meta'] = '68%';
$data2020['COLCHANE'][$ind]['meta'] = '68%';
$data2020['HUARA'][$ind]['meta'] = '68%';
$data2020['IQUIQUE'][$ind]['meta'] = '68%';
$data2020['PICA'][$ind]['meta'] = '68%';
$data2020['POZO ALMONTE'][$ind]['meta'] = '68%';

/* ===== Query numerador ===== */
$sql_numerador = "SELECT e.Comuna, e.alias_estab, r.Mes, sum(ifnull(Col28,0)) as numerador
                   FROM {$year}rems r
                   LEFT JOIN {$year}establecimientos e
                   ON r.IdEstablecimiento=e.Codigo
                   WHERE CodigoPrestacion in (09215313, 09215413) AND e.p_ges_odont = 1
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

/* ===== Query denominador ===== */
$sql_denominador = "SELECT e.Comuna, e.alias_estab, r.Mes, sum(ifnull(Col01,0)) as numerador
                   FROM {$year}rems r
                   LEFT JOIN {$year}establecimientos e
                   ON r.IdEstablecimiento=e.Codigo
                   WHERE CodigoPrestacion in (01080008) AND e.p_ges_odont = 1
                   GROUP BY e.Comuna, e.alias_estab, r.Mes
                   ORDER BY e.Comuna, e.alias_estab, r.Mes";
$denominadores = DB::connection('mysql_rem')->select($sql_denominador);

foreach($denominadores as $registro) {
     if( ($flag1 != $registro->Comuna) OR ($flag2 != $registro->alias_estab) ) {
         for($mes=1; $mes <= $ultimo_rem; $mes++) {
             $data2020[$registro->Comuna][$ind][$registro->alias_estab]['denominadores'][$mes] = 0;
         }
         $flag1 = $registro->Comuna;
         $flag2 = $registro->alias_estab;
     }
     $data2020[$registro->Comuna][$ind][$registro->alias_estab]['denominadores'][$registro->Mes] = $registro->numerador;
}

/* ==== Calculos ==== */
foreach($data2020 as $nombre_comuna => $comuna) {
  foreach($comuna as $nro_ind => $indicador) {
    foreach($indicador as $nombre_establecimiento => $establecimiento) {
         /* Existe en el array un indice ['numerador'], ['denominador'] y ['meta'],
          * estos almacenan la información de la comuna, por lo tanto tengo que saltarlos
          * en la iteración del foreach y continuar con los establecimientos */
         /* Realizar los calculos mensuales */
         if($nombre_establecimiento != 'numeradores' AND
             $nombre_establecimiento != 'denominadores' AND
             $nombre_establecimiento != 'meta' AND
             $nombre_establecimiento != 'cumplimiento' AND
             $nro_ind == $ind){

             /* Calcula numeradores totales de cada establecimiento */
             $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['numeradores']['total'] = array_sum($establecimiento['numeradores']);
             $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['denominadores']['total'] = array_sum($establecimiento['denominadores']);

             /* Calcula la suma mensual de numeradores por comuna */
             for($mes=1; $mes <= $ultimo_rem; $mes++) {
                 $data2020[$nombre_comuna][$ind]['numeradores'][$mes] += $establecimiento['numeradores'][$mes];
                 $data2020[$nombre_comuna][$ind]['denominadores'][$mes] += $establecimiento['denominadores'][$mes];
             }

             /* Calcula el numerador total de cada comuna */
             $data2020[$nombre_comuna][$ind]['numeradores']['total'] += $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['numeradores']['total'];
             $data2020[$nombre_comuna][$ind]['denominadores']['total'] += $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['denominadores']['total'];

             /* Calculo de las metas de cada establecimiento */
             if($data2020[$nombre_comuna][$ind][$nombre_establecimiento]['denominadores']['total'] == 0) {
                 /* Si es 0 el denominadore entonces la cumplimiento es 0 */
                 $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['cumplimiento'] = 0;
             }
             else {
                 $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['cumplimiento'] =
                     $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['numeradores']['total'] / $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['denominadores']['total'] * 100;
             }

             /* Calculo de las metas de la comuna */
             if($data2020[$nombre_comuna][$ind]['denominadores']['total'] == 0) {
                 /* Si es 0 el denominadore entonces la cumplimiento es 0 */
                 $data2020[$nombre_comuna][$ind]['cumplimiento'] = 0;
             }
             else {
                 /* De lo contrario calcular el porcentaje */
                 $data2020[$nombre_comuna][$ind]['cumplimiento'] = $data2020[$nombre_comuna][$ind]['numeradores']['total'] / $data2020[$nombre_comuna][$ind]['denominadores']['total'] * 100;
             }
         }
     }
   }
}

// Indicador 3
$ind = 3;
$label[$ind]['meta'] = '3-. Proporción de Consulta odontologica de urgencia GES.';
$label[$ind]['numerador'] = 'N° total de consultas odontologicas de urgencia GES.';
$label[$ind]['denominador'] = 'Población inscrita validada.';
$label[$ind]['fuente_numerador'] = 'REM';
$label[$ind]['fuente_denominador'] = 'FONASA';
$label[$ind]['ponderacion'] = '';

$meses = array(1,2,3,4,5,6,7,8,9,10,11,12);
$flag1 = NULL;
$flag2 = NULL;

$sql_establecimientos ='SELECT comuna, alias_estab
                        FROM 2020establecimientos
                        WHERE p_ges_odont = 1
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

$data2020['ALTO HOSPICIO'][$ind]['meta'] = '2%';
$data2020['CAMIÑA'][$ind]['meta'] = '2%';
$data2020['COLCHANE'][$ind]['meta'] = '2%';
$data2020['HUARA'][$ind]['meta'] = '2%';
$data2020['IQUIQUE'][$ind]['meta'] = '2%';
$data2020['PICA'][$ind]['meta'] = '2%';
$data2020['POZO ALMONTE'][$ind]['meta'] = '2%';

/* ===== Query numerador ===== */
$sql_numerador = "SELECT e.Comuna, e.alias_estab, r.Mes, sum(ifnull(Col01,0)) as numerador
                   FROM {$year}rems r
                   LEFT JOIN {$year}establecimientos e
                   ON r.IdEstablecimiento=e.Codigo
                   WHERE CodigoPrestacion in (09230300) AND e.p_ges_odont = 1
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

/* ===== Query denominador COMUNA ===== */
$sql_denominador = "SELECT e.alias_estab as nombre, e.Comuna as comuna, COUNT(*) AS denominador
                    FROM 2020percapita p
                    LEFT JOIN 2020establecimientos e ON e.Codigo = p.COD_CENTRO
                    WHERE
                    FECHA_CORTE = '2019-08-31' AND
                    ACEPTADO_RECHAZADO = 'ACEPTADO'
                    GROUP BY e.Comuna, e.alias_estab
                    ORDER BY e.Comuna, e.alias_estab";

$denominadores = DB::connection('mysql_rem')->select($sql_denominador);

foreach($denominadores as $registro) {
    //$data2020[$registro->comuna][$ind][$registro->nombre]['denominador'] = $registro->denominador;
    $data2020[$registro->comuna][$ind]['denominador'] += $registro->denominador;
}

/* ===== Query denominador ESTAB ===== */
$sql_denominador = "SELECT e.alias_estab as nombre, e.Comuna as comuna, COUNT(*) AS denominador
                    FROM 2020percapita p
                    LEFT JOIN 2020establecimientos e ON e.Codigo = p.COD_CENTRO
                    WHERE
                    FECHA_CORTE = '2019-08-31' AND
                    ACEPTADO_RECHAZADO = 'ACEPTADO'
                    AND e.p_ges_odont = 1
                    GROUP BY e.Comuna, e.alias_estab
                    ORDER BY e.Comuna, e.alias_estab";

$denominadores = DB::connection('mysql_rem')->select($sql_denominador);

foreach($denominadores as $registro) {
    $data2020[$registro->comuna][$ind][$registro->nombre]['denominador'] = $registro->denominador;
}

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
$label[$ind]['meta'] = '4-. Altas odontologicas totales en adulto Ges de 60 años.';
$label[$ind]['numerador'] = 'N° de altas odontologicas integrales GES de adultos
    de 60 años.';
$label[$ind]['denominador'] = 'N° de altas odontologicas integrales GES de adultos
    de 60 años comprometidas.';
$label[$ind]['fuente_numerador'] = 'REM';
$label[$ind]['fuente_denominador'] = '';
$label[$ind]['ponderacion'] = '';

$meses = array(1,2,3,4,5,6,7,8,9,10,11,12);
$flag1 = NULL;
$flag2 = NULL;

$sql_establecimientos ='SELECT comuna, alias_estab
                        FROM 2020establecimientos
                        WHERE p_ges_odont = 1
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
                   WHERE CodigoPrestacion in (09300500) AND e.p_ges_odont = 1
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

$data2020['ALTO HOSPICIO'][$ind]['denominador'] = '60';
$data2020['CAMIÑA'][$ind]['denominador'] = '6';
$data2020['COLCHANE'][$ind]['denominador'] = '3';
$data2020['HUARA'][$ind]['denominador'] = '7';
$data2020['IQUIQUE'][$ind]['denominador'] = '150';
$data2020['PICA'][$ind]['denominador'] = '8';
$data2020['POZO ALMONTE'][$ind]['denominador'] = '25';

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
