<?php
namespace App\Http\Controllers\Indicators\_2020;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\Indicators\SingleParameter;

$year = 2020;

$label['programa'] = 'Más Adultos Mayores Autovalentes.';

// Indicador 1
$ind = 1;
$label[$ind]['meta'] = '1-. % de población mayor de 60 años que mantienen o mejoran su condición de funcionalidad, según cuestionario de Funcionalidad.';
$label[$ind]['numerador'] = 'N° de personas egresadas del Programa, que mantienen o mejoran su condición funcional según cuestionario de funcionalidad.';
$label[$ind]['denominador'] = 'N° total de personas que egresan  del Programa * 100.';
$label[$ind]['fuente_numerador'] = 'REM';
$label[$ind]['fuente_denominador'] = 'REM';

$meses = array(1,2,3,4,5,6,7,8,9,10,11,12);
$flag1 = NULL;
$flag2 = NULL;
$data2020 = array();

$sql_establecimientos =
"SELECT comuna, alias_estab
 FROM {$year}establecimientos
 WHERE p_masama = 1
 ORDER BY comuna";

$establecimientos = DB::connection('mysql_rem')->select($sql_establecimientos);

/* ==== Inicializar en 0 el arreglo de datos $data2020 ==== */
foreach($establecimientos as $establecimiento) {
    $data2020[$establecimiento->comuna][$ind]['numeradores']['total'] = 0;
    $data2020[$establecimiento->comuna][$ind]['denominadores']['total'] = 0;
    $data2020[$establecimiento->comuna][$ind]['cumplimiento'] = 0;
    for($mes=1; $mes <= $ultimo_rem; $mes++) {
        $data2020[$establecimiento->comuna][$ind]['numeradores'][$mes] = 0;
        $data2020[$establecimiento->comuna][$ind]['denominadores'][$mes] = 0;
        $data2020[$establecimiento->comuna][$ind][$establecimiento->alias_estab]['numeradores']['total'] = 0;
        $data2020[$establecimiento->comuna][$ind][$establecimiento->alias_estab]['denominadores']['total'] = 0;
        $data2020[$establecimiento->comuna][$ind][$establecimiento->alias_estab]['numeradores'][$mes] = 0;
        $data2020[$establecimiento->comuna][$ind][$establecimiento->alias_estab]['denominadores'][$mes] = 0;
    }
    $data2020[$establecimiento->comuna][$ind][$establecimiento->alias_estab]['cumplimiento'] = 0;
}

$data2020['ALTO HOSPICIO'][$ind]['meta'] = 'Meta (Agosto y diciembre) 60%';
$data2020['IQUIQUE'][$ind]['meta'] = 'Meta (Agosto y diciembre) 60%';
$data2020['POZO ALMONTE'][$ind]['meta'] = 'Meta (Agosto y diciembre) 60%';

/* ===== Query numerador ===== */
$sql_numerador = "SELECT e.Comuna, e.alias_estab, r.Mes, sum(ifnull(Col01,0)) as numerador
                  FROM {$year}rems r
                  LEFT JOIN {$year}establecimientos e
                  ON r.IdEstablecimiento=e.Codigo
                  WHERE CodigoPrestacion in (03500353, 03500354) AND e.p_masama= 1
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
$sql_denominador = "SELECT e.Comuna, e.alias_estab, r.Mes, sum(ifnull(Col01,0)) as denominador
    FROM {$year}rems r
    LEFT JOIN {$year}establecimientos e
    ON r.IdEstablecimiento=e.Codigo
    WHERE CodigoPrestacion in (05051304) AND e.p_masama = 1
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
    $data2020[$registro->Comuna][$ind][$registro->alias_estab]['denominadores'][$registro->Mes] = $registro->denominador;
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

            /* Calcula los totales de cada establecimiento */
            $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['denominadores']['total'] = array_sum($establecimiento['denominadores']);
            $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['numeradores']['total'] = array_sum($establecimiento['numeradores']);

            /* Calcula los totales de cada comuna */
            $data2020[$nombre_comuna][$ind]['numeradores']['total'] += $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['numeradores']['total'];
            $data2020[$nombre_comuna][$ind]['denominadores']['total'] += $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['denominadores']['total'];

            /* Calcula la suma mensual por comuna */
            for($mes=1; $mes <= $ultimo_rem; $mes++) {
                $data2020[$nombre_comuna][$ind]['numeradores'][$mes] += $establecimiento['numeradores'][$mes];
                $data2020[$nombre_comuna][$ind]['denominadores'][$mes] += $establecimiento['denominadores'][$mes];
            }

            /* Calculo de las metas de cada establecimiento */
            if($data2020[$nombre_comuna][$ind][$nombre_establecimiento]['denominadores']['total'] == 0) {
                /* Si es 0 el denominadore entonces la cumplimiento es 0 */
                $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['cumplimiento'] = 0;
            }
            else {
                /* De lo contrario calcular el porcentaje */
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

// Indicador 2
$ind = 2;
$label[$ind]['meta'] = '2-. % de población mayor de 60 años que mantienen o mejoran su condición de funcionalidad, según Timed Up and Go.';
$label[$ind]['numerador'] = 'N° de personas egresadas del Programa, que mantienen o mejoran su condición funcional según Timed Up and Go.';
$label[$ind]['denominador'] = 'N° total de personas que egresan  del Programa * 100.';
$label[$ind]['fuente_numerador'] = 'REM';
$label[$ind]['fuente_denominador'] = 'REM';

$meses = array(1,2,3,4,5,6,7,8,9,10,11,12);
$flag1 = NULL;
$flag2 = NULL;

$sql_establecimientos =
'SELECT comuna, alias_estab
 FROM 2020establecimientos
 WHERE p_masama = 1
 ORDER BY comuna;';

$establecimientos = DB::connection('mysql_rem')->select($sql_establecimientos);

/* ==== Inicializar en 0 el arreglo de datos $data2020 ==== */
foreach($establecimientos as $establecimiento) {
    $data2020[$establecimiento->comuna][$ind]['numeradores']['total'] = 0;
    $data2020[$establecimiento->comuna][$ind]['denominadores']['total'] = 0;
    $data2020[$establecimiento->comuna][$ind]['cumplimiento'] = 0;
    for($mes=1; $mes <= $ultimo_rem; $mes++) {
        $data2020[$establecimiento->comuna][$ind]['numeradores'][$mes] = 0;
        $data2020[$establecimiento->comuna][$ind]['denominadores'][$mes] = 0;
        $data2020[$establecimiento->comuna][$ind][$establecimiento->alias_estab]['numeradores']['total'] = 0;
        $data2020[$establecimiento->comuna][$ind][$establecimiento->alias_estab]['denominadores']['total'] = 0;
        $data2020[$establecimiento->comuna][$ind][$establecimiento->alias_estab]['numeradores'][$mes] = 0;
        $data2020[$establecimiento->comuna][$ind][$establecimiento->alias_estab]['denominadores'][$mes] = 0;
    }
    $data2020[$establecimiento->comuna][$ind][$establecimiento->alias_estab]['cumplimiento'] = 0;
}

$data2020['ALTO HOSPICIO'][$ind]['meta'] = 'Meta (Agosto y diciembre) 60%';
$data2020['IQUIQUE'][$ind]['meta'] = 'Meta (Agosto y diciembre) 60%';
$data2020['POZO ALMONTE'][$ind]['meta'] = 'Meta (Agosto y diciembre) 60%';

/* ===== Query numerador ===== */
$sql_numerador = "SELECT e.Comuna, e.alias_estab, r.Mes, sum(ifnull(Col01,0)) as numerador
                  FROM {$year}rems r
                  LEFT JOIN {$year}establecimientos e
                  ON r.IdEstablecimiento=e.Codigo
                  WHERE CodigoPrestacion in (03500350, 03500351) AND e.p_masama = 1
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
$sql_denominador = "SELECT e.Comuna, e.alias_estab, r.Mes, sum(ifnull(Col01,0)) as denominador
                    FROM {$year}rems r
                    LEFT JOIN {$year}establecimientos e
                    ON r.IdEstablecimiento=e.Codigo
                    WHERE CodigoPrestacion in (05051304) AND e.p_masama = 1
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
    $data2020[$registro->Comuna][$ind][$registro->alias_estab]['denominadores'][$registro->Mes] = $registro->denominador;
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

            /* Calcula los totales de cada establecimiento */
            $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['denominadores']['total'] = array_sum($establecimiento['denominadores']);
            $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['numeradores']['total'] = array_sum($establecimiento['numeradores']);

            /* Calcula los totales de cada comuna */
            $data2020[$nombre_comuna][$ind]['numeradores']['total'] += $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['numeradores']['total'];
            $data2020[$nombre_comuna][$ind]['denominadores']['total'] += $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['denominadores']['total'];

            /* Calcula la suma mensual por comuna */
            for($mes=1; $mes <= $ultimo_rem; $mes++) {
                $data2020[$nombre_comuna][$ind]['numeradores'][$mes] += $establecimiento['numeradores'][$mes];
                $data2020[$nombre_comuna][$ind]['denominadores'][$mes] += $establecimiento['denominadores'][$mes];
            }

            /* Calculo de las metas de cada establecimiento */
            if($data2020[$nombre_comuna][$ind][$nombre_establecimiento]['denominadores']['total'] == 0) {
                /* Si es 0 el denominadore entonces la cumplimiento es 0 */
                $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['cumplimiento'] = 0;
            }
            else {
                /* De lo contrario calcular el porcentaje */
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
$label[$ind]['meta'] = '3-. % población mayor de 60 años en control en Centro de
    Salud, ingresados al Programa Más Adultos Mayores Autovalentes.';
$label[$ind]['numerador'] = '(N° de personas de 65 años y más ingresadas al programa,
    con condición de autovalentes + autovalentes con riesgo + en riesgo de dependencia)
     + (N° de personas entre 60 y 64 años ingresadas al Programa con EMPA vigente).';
$label[$ind]['denominador'] = 'Población comprometida a ingresar * 100.';
$label[$ind]['fuente_numerador'] = 'REM';
$label[$ind]['fuente_denominador'] = 'Población';

$meses = array(1,2,3,4,5,6,7,8,9,10,11,12);
$flag1 = NULL;
$flag2 = NULL;

$sql_establecimientos =
'SELECT comuna, alias_estab
 FROM 2020establecimientos
 WHERE p_masama = 1
 ORDER BY comuna;';

$establecimientos = DB::connection('mysql_rem')->select($sql_establecimientos);

/* ==== Inicializar en 0 el arreglo de datos $data2020 ==== */
foreach($establecimientos as $establecimiento) {
    $data2020[$establecimiento->comuna][$ind]['numeradores']['total'] = 0;
    //$data2020[$establecimiento->comuna][$ind]['denominadores']['total'] = 0;
    $data2020[$establecimiento->comuna][$ind]['cumplimiento'] = 0;
    for($mes=1; $mes <= $ultimo_rem; $mes++) {
        $data2020[$establecimiento->comuna][$ind]['numeradores'][$mes] = 0;
        //$data2020[$establecimiento->comuna][$ind]['denominadores'][$mes] = 0;
        $data2020[$establecimiento->comuna][$ind][$establecimiento->alias_estab]['numeradores']['total'] = 0;
        //$data2020[$establecimiento->comuna][$ind][$establecimiento->alias_estab]['denominadores']['total'] = 0;
        $data2020[$establecimiento->comuna][$ind][$establecimiento->alias_estab]['numeradores'][$mes] = 0;
        //$data2020[$establecimiento->comuna][$ind][$establecimiento->alias_estab]['denominadores'][$mes] = 0;
    }
    $data2020[$establecimiento->comuna][$ind][$establecimiento->alias_estab]['cumplimiento'] = 0;
}

$data2020['ALTO HOSPICIO'][$ind]['denominadores']['total']  = 538;
$data2020['IQUIQUE'][$ind]['denominadores']['total']  = 2152;
$data2020['POZO ALMONTE'][$ind]['denominadores']['total']  = 450;

$data2020['ALTO HOSPICIO'][$ind]['meta'] = '60% agosto - 100% diciembre';
$data2020['IQUIQUE'][$ind]['meta'] = '60% agosto - 100% diciembre';
$data2020['POZO ALMONTE'][$ind]['meta'] = '60% agosto - 100% diciembre';

/* ===== Query numerador ===== */
$sql_numerador = "SELECT e.Comuna, e.alias_estab, r.Mes, sum(ifnull(Col01,0)) as numerador
                  FROM {$year}rems r
                  LEFT JOIN {$year}establecimientos e
                  ON r.IdEstablecimiento=e.Codigo
                  WHERE CodigoPrestacion in (05051301, 05051302, 05051303) AND e.p_masama = 1
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

// /* ===== Query denominador ===== */
// $sql_denominador = "SELECT e.Comuna, e.alias_estab, r.Mes, sum(ifnull(Col01,0)) as denominador
//                     FROM {$year}rems r
//                     LEFT JOIN {$year}establecimientos e
//                     ON r.IdEstablecimiento=e.Codigo
//                     WHERE CodigoPrestacion in (05051304, 05051305, 05051306, 05051307) AND e.p_masama = 1
//                     GROUP BY e.Comuna, e.alias_estab, r.Mes
//                     ORDER BY e.Comuna, e.alias_estab, r.Mes";
// $denominadores = DB::connection('mysql_rem')->select($sql_denominador);
//
// foreach($denominadores as $registro) {
//     if( ($flag1 != $registro->Comuna) OR ($flag2 != $registro->alias_estab) ) {
//         for($mes=1; $mes <= $ultimo_rem; $mes++) {
//             $data2020[$registro->Comuna][$ind][$registro->alias_estab]['denominadores'][$mes] = 0;
//         }
//         $flag1 = $registro->Comuna;
//         $flag2 = $registro->alias_estab;
//     }
//     $data2020[$registro->Comuna][$ind][$registro->alias_estab]['denominadores'][$registro->Mes] = $registro->denominador;
// }

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

            /* Calcula los totales de cada establecimiento */
            // $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['denominadores']['total'] = array_sum($establecimiento['denominadores']);
            $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['numeradores']['total'] = array_sum($establecimiento['numeradores']);

            /* Calcula los totales de cada comuna */
            $data2020[$nombre_comuna][$ind]['numeradores']['total'] += $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['numeradores']['total'];
            // $data2020[$nombre_comuna][$ind]['denominadores']['total'] += $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['denominadores']['total'];

            /* Calcula la suma mensual por comuna */
            for($mes=1; $mes <= $ultimo_rem; $mes++) {
                $data2020[$nombre_comuna][$ind]['numeradores'][$mes] += $establecimiento['numeradores'][$mes];
                // $data2020[$nombre_comuna][$ind]['denominadores'][$mes] += $establecimiento['denominadores'][$mes];
            }

            // /* Calculo de las metas de cada establecimiento */
            // if($data2020[$nombre_comuna][$ind][$nombre_establecimiento]['denominadores']['total'] == 0) {
            //     /* Si es 0 el denominadore entonces la cumplimiento es 0 */
            //     $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['cumplimiento'] = 0;
            // }
            // else {
            //     /* De lo contrario calcular el porcentaje */
            //     $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['cumplimiento'] =
            //         $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['numeradores']['total'] / $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['denominadores']['total'] * 100;
            // }

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

// Indicador 4
$ind = 4;
$label[$ind]['meta'] = '4-. Promedio de asistentes a sesiones del programa.';
$label[$ind]['numerador'] = 'Suma de asistentes a sesiones en el mes.';
$label[$ind]['denominador'] = 'N° de sesiones realizadas en el mes.';
$label[$ind]['fuente_numerador'] = 'REM';
$label[$ind]['fuente_denominador'] = 'REM';

$meses = array(1,2,3,4,5,6,7,8,9,10,11,12);
$flag1 = NULL;
$flag2 = NULL;

$sql_establecimientos =
'SELECT comuna, alias_estab
 FROM 2020establecimientos
 WHERE p_masama = 1
 ORDER BY comuna;';

$establecimientos = DB::connection('mysql_rem')->select($sql_establecimientos);

/* ==== Inicializar en 0 el arreglo de datos $data2020 ==== */
foreach($establecimientos as $establecimiento) {
    $data2020[$establecimiento->comuna][$ind]['numeradores']['total'] = 0;
    $data2020[$establecimiento->comuna][$ind]['denominadores']['total'] = 0;
    $data2020[$establecimiento->comuna][$ind]['cumplimiento'] = 0;
    for($mes=1; $mes <= $ultimo_rem; $mes++) {
        $data2020[$establecimiento->comuna][$ind]['numeradores'][$mes] = 0;
        $data2020[$establecimiento->comuna][$ind]['denominadores'][$mes] = 0;
        $data2020[$establecimiento->comuna][$ind][$establecimiento->alias_estab]['numeradores']['total'] = 0;
        $data2020[$establecimiento->comuna][$ind][$establecimiento->alias_estab]['denominadores']['total'] = 0;
        $data2020[$establecimiento->comuna][$ind][$establecimiento->alias_estab]['numeradores'][$mes] = 0;
        $data2020[$establecimiento->comuna][$ind][$establecimiento->alias_estab]['denominadores'][$mes] = 0;
    }
    $data2020[$establecimiento->comuna][$ind][$establecimiento->alias_estab]['cumplimiento'] = 0;
}

$data2020['ALTO HOSPICIO'][$ind]['meta'] = '15 asistentes por sesión';
$data2020['IQUIQUE'][$ind]['meta'] = '15 asistentes por sesión';
$data2020['POZO ALMONTE'][$ind]['meta'] = '15 asistentes por sesión';

/* ===== Query numerador ===== */
$sql_numerador = "SELECT e.Comuna, e.alias_estab, r.Mes, sum(ifnull(Col01,0)) as numerador
                  FROM {$year}rems r
                  LEFT JOIN {$year}establecimientos e
                  ON r.IdEstablecimiento=e.Codigo
                  WHERE CodigoPrestacion in (27300913, 27300914, 27300915) AND e.p_masama = 1
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
$sql_denominador = "SELECT e.Comuna, e.alias_estab, r.Mes, sum(ifnull(Col02,0)) as denominador
                    FROM {$year}rems r
                    LEFT JOIN {$year}establecimientos e
                    ON r.IdEstablecimiento=e.Codigo
                    WHERE CodigoPrestacion in (27300913, 27300914, 27300915) AND e.p_masama = 1
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
    $data2020[$registro->Comuna][$ind][$registro->alias_estab]['denominadores'][$registro->Mes] = $registro->denominador;
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

            /* Calcula los totales de cada establecimiento */
            $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['denominadores']['total'] = array_sum($establecimiento['denominadores']);
            $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['numeradores']['total'] = array_sum($establecimiento['numeradores']);

            /* Calcula los totales de cada comuna */
            $data2020[$nombre_comuna][$ind]['numeradores']['total'] += $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['numeradores']['total'];
            $data2020[$nombre_comuna][$ind]['denominadores']['total'] += $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['denominadores']['total'];

            /* Calcula la suma mensual por comuna */
            for($mes=1; $mes <= $ultimo_rem; $mes++) {
                $data2020[$nombre_comuna][$ind]['numeradores'][$mes] += $establecimiento['numeradores'][$mes];
                $data2020[$nombre_comuna][$ind]['denominadores'][$mes] += $establecimiento['denominadores'][$mes];
            }

            /* Calculo de las metas de cada establecimiento */
            if($data2020[$nombre_comuna][$ind][$nombre_establecimiento]['denominadores']['total'] == 0) {
                /* Si es 0 el denominadore entonces la cumplimiento es 0 */
                $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['cumplimiento'] = 0;
            }
            else {
                /* De lo contrario calcular el porcentaje */
                $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['cumplimiento'] =
                    $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['numeradores']['total'] / $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['denominadores']['total'];
            }

            /* Calculo de las metas de la comuna */
            if($data2020[$nombre_comuna][$ind]['denominadores']['total'] == 0) {
                /* Si es 0 el denominadore entonces la cumplimiento es 0 */
                $data2020[$nombre_comuna][$ind]['cumplimiento'] = 0;
            }
            else {
                /* De lo contrario calcular el porcentaje */
                $data2020[$nombre_comuna][$ind]['cumplimiento'] = $data2020[$nombre_comuna][$ind]['numeradores']['total'] / $data2020[$nombre_comuna][$ind]['denominadores']['total'];
            }
        }
    }
  }
}

// Indicador 5
$ind = 5;
$label[$ind]['meta'] = '5-. Trabajo en Red local.';
$label[$ind]['numerador'] = 'N° de organizaciones con líderes comunitarios capacitados
    por el MASAMA en el período.';
$label[$ind]['denominador'] = 'N° de organizaciones ingresadas al programa de estimulación
    funcional del MASAMA en el período * 100.';
$label[$ind]['fuente_numerador'] = 'REM';
$label[$ind]['fuente_denominador'] = 'REM';

$meses = array(1,2,3,4,5,6,7,8,9,10,11,12);
$flag1 = NULL;
$flag2 = NULL;

$sql_establecimientos =
'SELECT comuna, alias_estab
 FROM 2020establecimientos
 WHERE p_masama = 1
 ORDER BY comuna;';

$establecimientos = DB::connection('mysql_rem')->select($sql_establecimientos);

/* ==== Inicializar en 0 el arreglo de datos $data2020 ==== */
foreach($establecimientos as $establecimiento) {
    $data2020[$establecimiento->comuna][$ind]['numeradores']['total'] = 0;
    $data2020[$establecimiento->comuna][$ind]['denominadores']['total'] = 0;
    $data2020[$establecimiento->comuna][$ind]['cumplimiento'] = 0;
    for($mes=1; $mes <= $ultimo_rem; $mes++) {
        $data2020[$establecimiento->comuna][$ind]['numeradores'][$mes] = 0;
        $data2020[$establecimiento->comuna][$ind]['denominadores'][$mes] = 0;
        $data2020[$establecimiento->comuna][$ind][$establecimiento->alias_estab]['numeradores']['total'] = 0;
        $data2020[$establecimiento->comuna][$ind][$establecimiento->alias_estab]['denominadores']['total'] = 0;
        $data2020[$establecimiento->comuna][$ind][$establecimiento->alias_estab]['numeradores'][$mes] = 0;
        $data2020[$establecimiento->comuna][$ind][$establecimiento->alias_estab]['denominadores'][$mes] = 0;
    }
    $data2020[$establecimiento->comuna][$ind][$establecimiento->alias_estab]['cumplimiento'] = 0;
}

$data2020['ALTO HOSPICIO'][$ind]['meta'] = '20% agosto - 30% diciembre';
$data2020['IQUIQUE'][$ind]['meta'] = '20% agosto - 30% diciembre';
$data2020['POZO ALMONTE'][$ind]['meta'] = '20% agosto - 30% diciembre';

/* ===== Query numerador ===== */
$sql_numerador = "SELECT e.Comuna, e.alias_estab, r.Mes, sum(ifnull(Col01,0)) as numerador
                  FROM {$year}rems r
                  LEFT JOIN {$year}establecimientos e
                  ON r.IdEstablecimiento=e.Codigo
                  WHERE CodigoPrestacion in (27500220) AND e.p_masama = 1
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
$sql_denominador = "SELECT e.Comuna, e.alias_estab, r.Mes, sum(ifnull(Col01,0)) as denominador
                    FROM {$year}rems r
                    LEFT JOIN {$year}establecimientos e
                    ON r.IdEstablecimiento=e.Codigo
                    WHERE CodigoPrestacion in (27500210) AND e.p_masama = 1
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
    $data2020[$registro->Comuna][$ind][$registro->alias_estab]['denominadores'][$registro->Mes] = $registro->denominador;
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

            /* Calcula los totales de cada establecimiento */
            $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['denominadores']['total'] = array_sum($establecimiento['denominadores']);
            $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['numeradores']['total'] = array_sum($establecimiento['numeradores']);

            /* Calcula los totales de cada comuna */
            $data2020[$nombre_comuna][$ind]['numeradores']['total'] += $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['numeradores']['total'];
            $data2020[$nombre_comuna][$ind]['denominadores']['total'] += $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['denominadores']['total'];

            /* Calcula la suma mensual por comuna */
            for($mes=1; $mes <= $ultimo_rem; $mes++) {
                $data2020[$nombre_comuna][$ind]['numeradores'][$mes] += $establecimiento['numeradores'][$mes];
                $data2020[$nombre_comuna][$ind]['denominadores'][$mes] += $establecimiento['denominadores'][$mes];
            }

            /* Calculo de las metas de cada establecimiento */
            if($data2020[$nombre_comuna][$ind][$nombre_establecimiento]['denominadores']['total'] == 0) {
                /* Si es 0 el denominadore entonces la cumplimiento es 0 */
                $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['cumplimiento'] = 0;
            }
            else {
                /* De lo contrario calcular el porcentaje */
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

// Indicador 6
$ind = 6;
$label[$ind]['meta'] = '6-. Ejecución del Programa de capacitación de Líderes Comunitarios.';
$label[$ind]['numerador'] = 'N° de organizaciones con líderes comunitarios capacitados
    por el MASAMA en el período.';
$label[$ind]['denominador'] = 'N° de organizaciones ingresadas al programa de estimulación
    funcional del MASAMA en el período * 100.';
$label[$ind]['fuente_numerador'] = 'REM';
$label[$ind]['fuente_denominador'] = 'REM';

$meses = array(1,2,3,4,5,6,7,8,9,10,11,12);
$flag1 = NULL;
$flag2 = NULL;

$sql_establecimientos =
'SELECT comuna, alias_estab
 FROM 2020establecimientos
 WHERE p_masama = 1
 ORDER BY comuna;';

$establecimientos = DB::connection('mysql_rem')->select($sql_establecimientos);

/* ==== Inicializar en 0 el arreglo de datos $data2020 ==== */
foreach($establecimientos as $establecimiento) {
    $data2020[$establecimiento->comuna][$ind]['numeradores']['total'] = 0;
    $data2020[$establecimiento->comuna][$ind]['denominadores']['total'] = 0;
    $data2020[$establecimiento->comuna][$ind]['cumplimiento'] = 0;
    for($mes=1; $mes <= $ultimo_rem; $mes++) {
        $data2020[$establecimiento->comuna][$ind]['numeradores'][$mes] = 0;
        $data2020[$establecimiento->comuna][$ind]['denominadores'][$mes] = 0;
        $data2020[$establecimiento->comuna][$ind][$establecimiento->alias_estab]['numeradores']['total'] = 0;
        $data2020[$establecimiento->comuna][$ind][$establecimiento->alias_estab]['denominadores']['total'] = 0;
        $data2020[$establecimiento->comuna][$ind][$establecimiento->alias_estab]['numeradores'][$mes] = 0;
        $data2020[$establecimiento->comuna][$ind][$establecimiento->alias_estab]['denominadores'][$mes] = 0;
    }
    $data2020[$establecimiento->comuna][$ind][$establecimiento->alias_estab]['cumplimiento'] = 0;
}

$data2020['ALTO HOSPICIO'][$ind]['meta'] = '20 % agosto - 30% diciembre';
$data2020['IQUIQUE'][$ind]['meta'] = '20% agosto - 30% diciembre';
$data2020['POZO ALMONTE'][$ind]['meta'] = '20% agosto - 30% diciembre';

/* ===== Query numerador ===== */
$sql_numerador = "SELECT e.Comuna, e.alias_estab, r.Mes, sum(ifnull(Col01,0)) as numerador
                  FROM {$year}rems r
                  LEFT JOIN {$year}establecimientos e
                  ON r.IdEstablecimiento=e.Codigo
                  WHERE CodigoPrestacion in (27500200) AND e.p_masama = 1
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
$sql_denominador = "SELECT e.Comuna, e.alias_estab, r.Mes, sum(ifnull(Col01,0)) as denominador
                    FROM {$year}rems r
                    LEFT JOIN {$year}establecimientos e
                    ON r.IdEstablecimiento=e.Codigo
                    WHERE CodigoPrestacion in (27500190) AND e.p_masama = 1
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
    $data2020[$registro->Comuna][$ind][$registro->alias_estab]['denominadores'][$registro->Mes] = $registro->denominador;
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

            /* Calcula los totales de cada establecimiento */
            $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['denominadores']['total'] = array_sum($establecimiento['denominadores']);
            $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['numeradores']['total'] = array_sum($establecimiento['numeradores']);

            /* Calcula los totales de cada comuna */
            $data2020[$nombre_comuna][$ind]['numeradores']['total'] += $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['numeradores']['total'];
            $data2020[$nombre_comuna][$ind]['denominadores']['total'] += $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['denominadores']['total'];

            /* Calcula la suma mensual por comuna */
            for($mes=1; $mes <= $ultimo_rem; $mes++) {
                $data2020[$nombre_comuna][$ind]['numeradores'][$mes] += $establecimiento['numeradores'][$mes];
                $data2020[$nombre_comuna][$ind]['denominadores'][$mes] += $establecimiento['denominadores'][$mes];
            }

            /* Calculo de las metas de cada establecimiento */
            if($data2020[$nombre_comuna][$ind][$nombre_establecimiento]['denominadores']['total'] == 0) {
                /* Si es 0 el denominadore entonces la cumplimiento es 0 */
                $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['cumplimiento'] = 0;
            }
            else {
                /* De lo contrario calcular el porcentaje */
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

// Indicador 7
$ind = 7;
$label[$ind]['meta'] = '7-. Porcentaje de personas que egresan del Programa.';
$label[$ind]['numerador'] = 'N° de personas mayores que egresan del Programa.';
$label[$ind]['denominador'] = 'N° de personas mayores que ingresan al Programa. * 100.';
$label[$ind]['fuente_numerador'] = 'REM';
$label[$ind]['fuente_denominador'] = 'REM';

$meses = array(1,2,3,4,5,6,7,8,9,10,11,12);
$flag1 = NULL;
$flag2 = NULL;

$sql_establecimientos =
'SELECT comuna, alias_estab
 FROM 2020establecimientos
 WHERE p_masama = 1
 ORDER BY comuna;';

$establecimientos = DB::connection('mysql_rem')->select($sql_establecimientos);

/* ==== Inicializar en 0 el arreglo de datos $data2020 ==== */
foreach($establecimientos as $establecimiento) {
    $data2020[$establecimiento->comuna][$ind]['numeradores']['total'] = 0;
    $data2020[$establecimiento->comuna][$ind]['denominadores']['total'] = 0;
    $data2020[$establecimiento->comuna][$ind]['cumplimiento'] = 0;
    for($mes=1; $mes <= $ultimo_rem; $mes++) {
        $data2020[$establecimiento->comuna][$ind]['numeradores'][$mes] = 0;
        $data2020[$establecimiento->comuna][$ind]['denominadores'][$mes] = 0;
        $data2020[$establecimiento->comuna][$ind][$establecimiento->alias_estab]['numeradores']['total'] = 0;
        $data2020[$establecimiento->comuna][$ind][$establecimiento->alias_estab]['denominadores']['total'] = 0;
        $data2020[$establecimiento->comuna][$ind][$establecimiento->alias_estab]['numeradores'][$mes] = 0;
        $data2020[$establecimiento->comuna][$ind][$establecimiento->alias_estab]['denominadores'][$mes] = 0;
    }
    $data2020[$establecimiento->comuna][$ind][$establecimiento->alias_estab]['cumplimiento'] = 0;
}

$data2020['ALTO HOSPICIO'][$ind]['meta'] = '80%';
$data2020['IQUIQUE'][$ind]['meta'] = '80%';
$data2020['POZO ALMONTE'][$ind]['meta'] = '80%';

/* ===== Query numerador ===== */
$sql_numerador = "SELECT e.Comuna, e.alias_estab, r.Mes, sum(ifnull(Col01,0)) as numerador
                  FROM {$year}rems r
                  LEFT JOIN {$year}establecimientos e
                  ON r.IdEstablecimiento=e.Codigo
                  WHERE CodigoPrestacion in (05051304) AND e.p_masama = 1
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
$sql_denominador = "SELECT e.Comuna, e.alias_estab, r.Mes, sum(ifnull(Col01,0)) as denominador
                    FROM {$year}rems r
                    LEFT JOIN {$year}establecimientos e
                    ON r.IdEstablecimiento=e.Codigo
                    WHERE CodigoPrestacion in (05051301, 05051302, 05051303) AND e.p_masama = 1
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
    $data2020[$registro->Comuna][$ind][$registro->alias_estab]['denominadores'][$registro->Mes] = $registro->denominador;
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

            /* Calcula los totales de cada establecimiento */
            $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['denominadores']['total'] = array_sum($establecimiento['denominadores']);
            $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['numeradores']['total'] = array_sum($establecimiento['numeradores']);

            /* Calcula los totales de cada comuna */
            $data2020[$nombre_comuna][$ind]['numeradores']['total'] += $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['numeradores']['total'];
            $data2020[$nombre_comuna][$ind]['denominadores']['total'] += $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['denominadores']['total'];

            /* Calcula la suma mensual por comuna */
            for($mes=1; $mes <= $ultimo_rem; $mes++) {
                $data2020[$nombre_comuna][$ind]['numeradores'][$mes] += $establecimiento['numeradores'][$mes];
                $data2020[$nombre_comuna][$ind]['denominadores'][$mes] += $establecimiento['denominadores'][$mes];
            }

            /* Calculo de las metas de cada establecimiento */
            if($data2020[$nombre_comuna][$ind][$nombre_establecimiento]['denominadores']['total'] == 0) {
                /* Si es 0 el denominadore entonces la cumplimiento es 0 */
                $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['cumplimiento'] = 0;
            }
            else {
                /* De lo contrario calcular el porcentaje */
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

// Indicador 8
$ind = 8;
$label[$ind]['meta'] = '8-. Porcentaje de personas que mejoran condición funcional
    al egreso del Programa.';
$label[$ind]['numerador'] = 'N° de personas egresadas del Programa, que mejoran
    su condición funcional según Timed Up and Go.';
$label[$ind]['denominador'] = 'N° de personas egresadas del Programa * 100.';
$label[$ind]['fuente_numerador'] = 'REM';
$label[$ind]['fuente_denominador'] = 'REM';

$meses = array(1,2,3,4,5,6,7,8,9,10,11,12);
$flag1 = NULL;
$flag2 = NULL;

$sql_establecimientos =
'SELECT comuna, alias_estab
 FROM 2020establecimientos
 WHERE p_masama = 1
 ORDER BY comuna;';

$establecimientos = DB::connection('mysql_rem')->select($sql_establecimientos);

/* ==== Inicializar en 0 el arreglo de datos $data2020 ==== */
foreach($establecimientos as $establecimiento) {
    $data2020[$establecimiento->comuna][$ind]['numeradores']['total'] = 0;
    $data2020[$establecimiento->comuna][$ind]['denominadores']['total'] = 0;
    $data2020[$establecimiento->comuna][$ind]['cumplimiento'] = 0;
    for($mes=1; $mes <= $ultimo_rem; $mes++) {
        $data2020[$establecimiento->comuna][$ind]['numeradores'][$mes] = 0;
        $data2020[$establecimiento->comuna][$ind]['denominadores'][$mes] = 0;
        $data2020[$establecimiento->comuna][$ind][$establecimiento->alias_estab]['numeradores']['total'] = 0;
        $data2020[$establecimiento->comuna][$ind][$establecimiento->alias_estab]['denominadores']['total'] = 0;
        $data2020[$establecimiento->comuna][$ind][$establecimiento->alias_estab]['numeradores'][$mes] = 0;
        $data2020[$establecimiento->comuna][$ind][$establecimiento->alias_estab]['denominadores'][$mes] = 0;
    }
    $data2020[$establecimiento->comuna][$ind][$establecimiento->alias_estab]['cumplimiento'] = 0;
}

$data2020['ALTO HOSPICIO'][$ind]['meta'] = 'Incremento 5%';
$data2020['IQUIQUE'][$ind]['meta'] = 'Incremento 5%';
$data2020['POZO ALMONTE'][$ind]['meta'] = 'Incremento 5%';

/* ===== Query numerador ===== */
$sql_numerador = "SELECT e.Comuna, e.alias_estab, r.Mes, sum(ifnull(Col01,0)) as numerador
                  FROM {$year}rems r
                  LEFT JOIN {$year}establecimientos e
                  ON r.IdEstablecimiento=e.Codigo
                  WHERE CodigoPrestacion in (03500350) AND e.p_masama = 1
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
$sql_denominador = "SELECT e.Comuna, e.alias_estab, r.Mes, sum(ifnull(Col01,0)) as denominador
                    FROM {$year}rems r
                    LEFT JOIN {$year}establecimientos e
                    ON r.IdEstablecimiento=e.Codigo
                    WHERE CodigoPrestacion in (05051304) AND e.p_masama = 1
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
    $data2020[$registro->Comuna][$ind][$registro->alias_estab]['denominadores'][$registro->Mes] = $registro->denominador;
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

            /* Calcula los totales de cada establecimiento */
            $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['denominadores']['total'] = array_sum($establecimiento['denominadores']);
            $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['numeradores']['total'] = array_sum($establecimiento['numeradores']);

            /* Calcula los totales de cada comuna */
            $data2020[$nombre_comuna][$ind]['numeradores']['total'] += $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['numeradores']['total'];
            $data2020[$nombre_comuna][$ind]['denominadores']['total'] += $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['denominadores']['total'];

            /* Calcula la suma mensual por comuna */
            for($mes=1; $mes <= $ultimo_rem; $mes++) {
                $data2020[$nombre_comuna][$ind]['numeradores'][$mes] += $establecimiento['numeradores'][$mes];
                $data2020[$nombre_comuna][$ind]['denominadores'][$mes] += $establecimiento['denominadores'][$mes];
            }

            /* Calculo de las metas de cada establecimiento */
            if($data2020[$nombre_comuna][$ind][$nombre_establecimiento]['denominadores']['total'] == 0) {
                /* Si es 0 el denominadore entonces la cumplimiento es 0 */
                $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['cumplimiento'] = 0;
            }
            else {
                /* De lo contrario calcular el porcentaje */
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

// Indicador 9
$ind = 9;
$label[$ind]['meta'] = '9-. Porcentaje de Personas que Mejoran Condición Funcional
    al egreso del Programa.';
$label[$ind]['numerador'] = 'N° de personas egresadas del Programa, que mejoran
    su condición funcional según Cuestionario de funcionalidad.';
$label[$ind]['denominador'] = 'N° de personas egresadas del Programa * 100.';
$label[$ind]['fuente_numerador'] = 'REM';
$label[$ind]['fuente_denominador'] = 'REM';

$meses = array(1,2,3,4,5,6,7,8,9,10,11,12);
$flag1 = NULL;
$flag2 = NULL;

$sql_establecimientos =
'SELECT comuna, alias_estab
 FROM 2020establecimientos
 WHERE p_masama = 1
 ORDER BY comuna;';

$establecimientos = DB::connection('mysql_rem')->select($sql_establecimientos);

/* ==== Inicializar en 0 el arreglo de datos $data2020 ==== */
foreach($establecimientos as $establecimiento) {
    $data2020[$establecimiento->comuna][$ind]['numeradores']['total'] = 0;
    $data2020[$establecimiento->comuna][$ind]['denominadores']['total'] = 0;
    $data2020[$establecimiento->comuna][$ind]['cumplimiento'] = 0;
    for($mes=1; $mes <= $ultimo_rem; $mes++) {
        $data2020[$establecimiento->comuna][$ind]['numeradores'][$mes] = 0;
        $data2020[$establecimiento->comuna][$ind]['denominadores'][$mes] = 0;
        $data2020[$establecimiento->comuna][$ind][$establecimiento->alias_estab]['numeradores']['total'] = 0;
        $data2020[$establecimiento->comuna][$ind][$establecimiento->alias_estab]['denominadores']['total'] = 0;
        $data2020[$establecimiento->comuna][$ind][$establecimiento->alias_estab]['numeradores'][$mes] = 0;
        $data2020[$establecimiento->comuna][$ind][$establecimiento->alias_estab]['denominadores'][$mes] = 0;
    }
    $data2020[$establecimiento->comuna][$ind][$establecimiento->alias_estab]['cumplimiento'] = 0;
}

$data2020['ALTO HOSPICIO'][$ind]['meta'] = 'Incremento 5%';
$data2020['IQUIQUE'][$ind]['meta'] = 'Incremento 5%';
$data2020['POZO ALMONTE'][$ind]['meta'] = 'Incremento 5%';

/* ===== Query numerador ===== */
$sql_numerador = "SELECT e.Comuna, e.alias_estab, r.Mes, sum(ifnull(Col01,0)) as numerador
                  FROM {$year}rems r
                  LEFT JOIN {$year}establecimientos e
                  ON r.IdEstablecimiento=e.Codigo
                  WHERE CodigoPrestacion in (03500353) AND e.p_masama = 1
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
$sql_denominador = "SELECT e.Comuna, e.alias_estab, r.Mes, sum(ifnull(Col01,0)) as denominador
                    FROM {$year}rems r
                    LEFT JOIN {$year}establecimientos e
                    ON r.IdEstablecimiento=e.Codigo
                    WHERE CodigoPrestacion in (05051304) AND e.p_masama = 1
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
    $data2020[$registro->Comuna][$ind][$registro->alias_estab]['denominadores'][$registro->Mes] = $registro->denominador;
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

            /* Calcula los totales de cada establecimiento */
            $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['denominadores']['total'] = array_sum($establecimiento['denominadores']);
            $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['numeradores']['total'] = array_sum($establecimiento['numeradores']);

            /* Calcula los totales de cada comuna */
            $data2020[$nombre_comuna][$ind]['numeradores']['total'] += $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['numeradores']['total'];
            $data2020[$nombre_comuna][$ind]['denominadores']['total'] += $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['denominadores']['total'];

            /* Calcula la suma mensual por comuna */
            for($mes=1; $mes <= $ultimo_rem; $mes++) {
                $data2020[$nombre_comuna][$ind]['numeradores'][$mes] += $establecimiento['numeradores'][$mes];
                $data2020[$nombre_comuna][$ind]['denominadores'][$mes] += $establecimiento['denominadores'][$mes];
            }

            /* Calculo de las metas de cada establecimiento */
            if($data2020[$nombre_comuna][$ind][$nombre_establecimiento]['denominadores']['total'] == 0) {
                /* Si es 0 el denominadore entonces la cumplimiento es 0 */
                $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['cumplimiento'] = 0;
            }
            else {
                /* De lo contrario calcular el porcentaje */
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

// dd($data2020);

//
// echo '<pre>';
// print_r($data12020);
// echo '</pre>';
