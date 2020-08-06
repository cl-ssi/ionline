<?php
namespace App\Http\Controllers\Indicators\_2019;

use Illuminate\Support\Facades\DB;

$year = 2019;

/*
$sql_ultimo_rem = "SELECT MAX(Mes) as ultimo_rem FROM 2019rems;";
$ultimo_rem = DB::connection('mysql_rem')->select($sql_ultimo_rem)[0]->ultimo_rem;
*/

/* 02010420	RESULTADOS DE LA APLICACIÓN DE ESCALA DE EVALUACIÓN DEL DESARROLLO PSICOMOTOR - REEVALUACIÓN - NORMAL (de riesgo)
   03500366	RESULTADOS DE LA APLICACIÓN DE ESCALA DE EVALUACIÓN DEL DESARROLLO PSICOMOTOR - REEVALUACIÓN - NORMAL CON REZAGO (de riesgo) */

$label['meta'] = 'Porcentaje de niños y niñas de 12 a 23 meses con riesgo del desarrollo psicomotor recuperados.';
$label['numerador'] = 'N° de niños y niñas de 12 a 23 meses dignosticados con riesgo del DSM recuperados, período enero a diciembre 2019.';
$label['denominador'] = 'N° de niños y niñas de 12 a 23 meses diagnosticados con riesgo de Desarrollo Psicomotor en su primera evaluación, período enero a diciembre 2019.';

$meses = array(1,2,3,4,5,6,7,8,9,10,11,12);
$flag1 = NULL;
$flag2 = NULL;
$data12019 = array();

$sql_establecimientos ='SELECT comuna, alias_estab
                        FROM 2019establecimientos
                        WHERE meta_san = 1
                        ORDER BY comuna;';

$establecimientos = DB::connection('mysql_rem')->select($sql_establecimientos);

/* ==== Inicializar en 0 el arreglo de datos $data12019 ==== */
foreach($establecimientos as $establecimiento) {
    $data12019[$establecimiento->comuna]['numeradores']['total'] = 0;
    $data12019[$establecimiento->comuna]['denominadores']['total'] = 0;
    //$data12019[$establecimiento->comuna]['denominadores_2']['total'] = 0;
    $data12019[$establecimiento->comuna]['cumplimiento'] = 0;
    for($mes=1; $mes <= $ultimo_rem; $mes++) {
        $data12019[$establecimiento->comuna]['numeradores'][$mes] = 0;
        $data12019[$establecimiento->comuna]['denominadores'][$mes] = 0;
        //$data12019[$establecimiento->comuna]['denominadores_2'][$mes] = 0;
        $data12019[$establecimiento->comuna][$establecimiento->alias_estab]['numeradores']['total'] = 0;
        $data12019[$establecimiento->comuna][$establecimiento->alias_estab]['denominadores']['total'] = 0;
        $data12019[$establecimiento->comuna][$establecimiento->alias_estab]['denominadores_2']['total'] = 0;
        $data12019[$establecimiento->comuna][$establecimiento->alias_estab]['numeradores'][$mes] = 0;
        $data12019[$establecimiento->comuna][$establecimiento->alias_estab]['denominadores'][$mes] = 0;
        $data12019[$establecimiento->comuna][$establecimiento->alias_estab]['denominadores_2'][$mes] = 0;
    }
    $data12019[$establecimiento->comuna][$establecimiento->alias_estab]['cumplimiento'] = 0;
}

$data12019['ALTO HOSPICIO']['meta'] = '90%';
$data12019['CAMIÑA']['meta'] = '100%';
$data12019['COLCHANE']['meta'] = '100%';
$data12019['HUARA']['meta'] = '90%';
$data12019['IQUIQUE']['meta'] = '94%';
$data12019['PICA']['meta'] = '90%';
$data12019['POZO ALMONTE']['meta'] = '90%';

/* ===== Query numerador ===== */
$sql_numerador = "SELECT e.Comuna, e.alias_estab, r.Mes, sum((ifnull(Col08,0) + ifnull(Col09,0) + ifnull(Col10,0) + ifnull(Col11,0))) as numerador
    FROM {$year}rems r
    LEFT JOIN 2019establecimientos e
    ON r.IdEstablecimiento=e.Codigo
    WHERE CodigoPrestacion in (02010420,03500366) AND e.meta_san = 1 AND r.Mes BETWEEN 1 AND {$ultimo_rem}
    GROUP BY e.Comuna, e.alias_estab, r.Mes
    ORDER BY e.Comuna, e.alias_estab, r.Mes";
$numeradores = DB::connection('mysql_rem')->select($sql_numerador);

foreach($numeradores as $registro) {
    if( ($flag1 != $registro->Comuna) OR ($flag2 != $registro->alias_estab) ) {
        for($mes=1; $mes <= $ultimo_rem; $mes++) {
            $data12019[$registro->Comuna][$registro->alias_estab]['numeradores'][$mes] = 0;
        }
        $flag1 = $registro->Comuna;
        $flag2 = $registro->alias_estab;
    }
    $data12019[$registro->Comuna][$registro->alias_estab]['numeradores'][$registro->Mes] = $registro->numerador;
}

/* ===== Query denominador ===== */
/*02010321	RESULTADOS DE LA APLICACIÓN DE ESCALA DE EVALUACIÓN DEL DESARROLLO PSICOMOTOR - PRIMERA EVALUACIÓN - RIESGO
  03500334	RESULTADOS DE LA APLICACIÓN DE ESCALA DE EVALUACIÓN DEL DESARROLLO PSICOMOTOR - TRASLADO DE ESTABLECIMIENTO - RIESGO*/

$sql_denominador = "SELECT e.Comuna, e.alias_estab, r.Mes,
                    (
                      SUM( CASE WHEN CodigoPrestacion IN (02010321) THEN
                        COALESCE(Col08,0) + COALESCE(Col09,0) + COALESCE(Col10,0) + COALESCE(Col11,0)
                        ELSE 0 END)
                      -
                      SUM( CASE WHEN CodigoPrestacion IN (03500334) THEN
                        COALESCE(Col08,0) + COALESCE(Col09,0) + COALESCE(Col10,0) + COALESCE(Col11,0)
                        ELSE 0 END)
                    ) AS denominador
                    FROM {$year}rems r
                    LEFT JOIN 2019establecimientos e
                    ON r.IdEstablecimiento=e.Codigo
                    WHERE e.meta_san = 1 AND r.Mes BETWEEN 1 AND {$ultimo_rem}
                    GROUP BY e.Comuna, e.alias_estab, r.Mes
                    ORDER BY e.Comuna, e.alias_estab, r.Mes";

$denominadores = DB::connection('mysql_rem')->select($sql_denominador);

foreach($denominadores as $registro) {
    if( ($flag1 != $registro->Comuna) OR ($flag2 != $registro->alias_estab) ) {
        for($mes=1; $mes <= $ultimo_rem; $mes++) {
            $data12019[$registro->Comuna][$registro->alias_estab]['denominadores'][$mes] = 0;
        }
        $flag1 = $registro->Comuna;
        $flag2 = $registro->alias_estab;
    }
    $data12019[$registro->Comuna][$registro->alias_estab]['denominadores'][$registro->Mes] = $registro->denominador;
}

/* ==== Calculos ==== */
foreach($data12019 as $nombre_comuna => $comuna) {
    foreach($comuna as $nombre_establecimiento => $establecimiento) {
        /* Existe en el array un indice ['numerador'], ['denominador'] y ['meta'],
         * estos almacenan la información de la comuna, por lo tanto tengo que saltarlos
         * en la iteración del foreach y continuar con los establecimientos */
        /* Realizar los calculos mensuales */
        if($nombre_establecimiento != 'numeradores' AND
            $nombre_establecimiento != 'denominadores' AND
            //$nombre_establecimiento != 'denominadores_2' AND
            $nombre_establecimiento != 'meta' AND
            $nombre_establecimiento != 'cumplimiento'){

            /* Calcula los totales de cada establecimiento */
            $data12019[$nombre_comuna][$nombre_establecimiento]['denominadores']['total'] = array_sum($establecimiento['denominadores']);
            //$data12019[$nombre_comuna][$nombre_establecimiento]['denominadores_2']['total'] = array_sum($establecimiento['denominadores_2']);
            $data12019[$nombre_comuna][$nombre_establecimiento]['numeradores']['total'] = array_sum($establecimiento['numeradores']);

            //dd($data12019[$nombre_comuna][$nombre_establecimiento]['denominadores']['total']);

            /* Calcula los totales de cada comuna */
            $data12019[$nombre_comuna]['numeradores']['total'] += $data12019[$nombre_comuna][$nombre_establecimiento]['numeradores']['total'];
            $data12019[$nombre_comuna]['denominadores']['total'] += $data12019[$nombre_comuna][$nombre_establecimiento]['denominadores']['total'];
            //-$data12019[$nombre_comuna][$nombre_establecimiento]['denominadores_2']['total'];

            /* Calcula la suma mensual por comuna */
            for($mes=1; $mes <= $ultimo_rem; $mes++) {
                $data12019[$nombre_comuna]['numeradores'][$mes] += $establecimiento['numeradores'][$mes];
                $data12019[$nombre_comuna]['denominadores'][$mes] += $establecimiento['denominadores'][$mes];// - $establecimiento['denominadores_2'][$mes];
            }

            /* Calculo de las metas de cada establecimiento */
            if($data12019[$nombre_comuna][$nombre_establecimiento]['denominadores']['total'] == 0) {
                /* Si es 0 el denominadore entonces el cumplimiento es 0 */
                $data12019[$nombre_comuna][$nombre_establecimiento]['cumplimiento'] = 0;
            }
            else {
                /* De lo contrario calcular el porcentaje */
                $data12019[$nombre_comuna][$nombre_establecimiento]['cumplimiento'] =
                    $data12019[$nombre_comuna][$nombre_establecimiento]['numeradores']['total'] /
                    $data12019[$nombre_comuna][$nombre_establecimiento]['denominadores']['total'] * 100;
            }

            /* Calculo de las metas de la comuna */
            $data12019Graphics[$nombre_comuna]['cumplimiento'][$mes] = 0;
            if($data12019[$nombre_comuna]['denominadores']['total'] == 0) {
                /* Si es 0 el denominadore entonces el cumplimiento es 0 */
                $data12019[$nombre_comuna]['cumplimiento'] = 0;
            }
            else {
                /* De lo contrario calcular el porcentaje */
                $data12019[$nombre_comuna]['cumplimiento'] = $data12019[$nombre_comuna]['numeradores']['total'] / $data12019[$nombre_comuna]['denominadores']['total'] * 100;
                //$data12019Graphics[$nombre_comuna]['cumplimiento'][$mes] = $data12019Graphics[$nombre_comuna]['numeradores'][$mes] / $data12019[$nombre_comuna]['denominadores'][$mes] * 100;
            }
        }
    }
}
