<?php
namespace App\Http\Controllers\Indicators\_2020;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Indicators\Establecimiento;
use App\Models\Indicators\Rem;
use Illuminate\Support\Facades\DB;
use App\Models\Indicators\SingleParameter;

$year = 2020;

/*
$sql_ultimo_rem = "SELECT MAX(Mes) as ultimo_rem FROM 2020rems;";
$ultimo_rem = DB::connection('mysql_rem')->select($sql_ultimo_rem)[0]->ultimo_rem;
*/

/* 02010420	RESULTADOS DE LA APLICACIÓN DE ESCALA DE EVALUACIÓN DEL DESARROLLO PSICOMOTOR - REEVALUACIÓN - NORMAL (de riesgo)
   03500366	RESULTADOS DE LA APLICACIÓN DE ESCALA DE EVALUACIÓN DEL DESARROLLO PSICOMOTOR - REEVALUACIÓN - NORMAL CON REZAGO (de riesgo) */

$label['meta'] = 'Porcentaje de niños y niñas de 12 a 23 meses con riesgo del desarrollo psicomotor recuperados.';
$label['numerador'] = 'N° de niños y niñas de 12 a 23 meses diagnosticados con riesgo del DSM recuperados, período enero a diciembre 2020.';
$label['denominador'] = 'N° de niños y niñas de 12 a 23 meses diagnosticados con riesgo de Desarrollo Psicomotor en su primera evaluación, período enero a diciembre 2020.';

$meses = array(1,2,3,4,5,6,7,8,9,10,11,12);
$flag1 = NULL;
$flag2 = NULL;
$data12020 = array();

$sql_establecimientos ='SELECT comuna, alias_estab
                        FROM 2020establecimientos
                        WHERE meta_san = 1
                        ORDER BY comuna;';

$establecimientos = DB::connection('mysql_rem')->select($sql_establecimientos);

/* ==== Inicializar en 0 el arreglo de datos $data12020 ==== */
foreach($establecimientos as $establecimiento) {
    $data12020[$establecimiento->comuna]['numeradores']['total'] = 0;
    $data12020[$establecimiento->comuna]['denominadores']['total'] = 0;
    //$data12020[$establecimiento->comuna]['denominadores_2']['total'] = 0;
    $data12020[$establecimiento->comuna]['cumplimiento'] = 0;
    for($mes=1; $mes <= $ultimo_rem; $mes++) {
        $data12020[$establecimiento->comuna]['numeradores'][$mes] = 0;
        $data12020[$establecimiento->comuna]['denominadores'][$mes] = 0;
        //$data12020[$establecimiento->comuna]['denominadores_2'][$mes] = 0;
        $data12020[$establecimiento->comuna][$establecimiento->alias_estab]['numeradores']['total'] = 0;
        $data12020[$establecimiento->comuna][$establecimiento->alias_estab]['denominadores']['total'] = 0;
        $data12020[$establecimiento->comuna][$establecimiento->alias_estab]['denominadores_2']['total'] = 0;
        $data12020[$establecimiento->comuna][$establecimiento->alias_estab]['numeradores'][$mes] = 0;
        $data12020[$establecimiento->comuna][$establecimiento->alias_estab]['denominadores'][$mes] = 0;
        $data12020[$establecimiento->comuna][$establecimiento->alias_estab]['denominadores_2'][$mes] = 0;
    }
    $data12020[$establecimiento->comuna][$establecimiento->alias_estab]['cumplimiento'] = 0;
}

$data12020['ALTO HOSPICIO']['meta'] = '90%';
$data12020['CAMIÑA']['meta'] = '100%';
$data12020['COLCHANE']['meta'] = '100%';
$data12020['HUARA']['meta'] = '90%';
$data12020['IQUIQUE']['meta'] = '94%';
$data12020['PICA']['meta'] = '90%';
$data12020['POZO ALMONTE']['meta'] = '90%';

/* ===== Query numerador ===== */
$sql_numerador = "SELECT e.Comuna, e.alias_estab, r.Mes, sum((ifnull(Col08,0) + ifnull(Col09,0) + ifnull(Col10,0) + ifnull(Col11,0))) as numerador
    FROM {$year}rems r
    LEFT JOIN 2020establecimientos e
    ON r.IdEstablecimiento=e.Codigo
    WHERE CodigoPrestacion in (02010420,03500366) AND e.meta_san = 1
    GROUP BY e.Comuna, e.alias_estab, r.Mes
    ORDER BY e.Comuna, e.alias_estab, r.Mes";
$numeradores = DB::connection('mysql_rem')->select($sql_numerador);

// $numeradores = Rem::year(2020)->with(['establecimiento' => function($q){ return $q->where('meta_san', 1); }])
//                   ->selectRaw('SUM(COALESCE(Col08, 0)) + SUM(COALESCE(Col09, 0)) + SUM(COALESCE(Col10, 0)) + SUM(COALESCE(Col11, 0)) AS valor, IdEstablecimiento, Mes')
//                   ->whereHas('establecimiento', function($q){ return $q->where('meta_san', 1); })
//                   ->whereIn('CodigoPrestacion', ['02010420','03500366'])->groupBy('IdEstablecimiento','Mes')->orderBy('Mes')->get();
// dd($numeradores);

foreach($numeradores as $registro) {
    if( ($flag1 != $registro->Comuna) OR ($flag2 != $registro->alias_estab) ) {
        for($mes=1; $mes <= $ultimo_rem; $mes++) {
            $data12020[$registro->Comuna][$registro->alias_estab]['numeradores'][$mes] = 0;
        }
        $flag1 = $registro->Comuna;
        $flag2 = $registro->alias_estab;
    }
    $data12020[$registro->Comuna][$registro->alias_estab]['numeradores'][$registro->Mes] = $registro->numerador;
}
//dd($data12020['IQUIQUE']);

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
                    LEFT JOIN 2020establecimientos e
                    ON r.IdEstablecimiento=e.Codigo
                    WHERE e.meta_san = 1
                    GROUP BY e.Comuna, e.alias_estab, r.Mes
                    ORDER BY e.Comuna, e.alias_estab, r.Mes";

$denominadores = DB::connection('mysql_rem')->select($sql_denominador);

// $denominadores = Rem::year(2020)->with(['establecimiento' => function($q){ return $q->where('meta_san', 1); }])
//                   ->selectRaw('SUM(COALESCE(Col08, 0)) + SUM(COALESCE(Col09, 0)) + SUM(COALESCE(Col10, 0)) + SUM(COALESCE(Col11, 0)) AS valor, IdEstablecimiento, Mes')
//                   ->whereHas('establecimiento', function($q){ return $q->where('meta_san', 1); })
//                   ->whereIn('CodigoPrestacion', ['02010321'])->groupBy('IdEstablecimiento','Mes')->orderBy('Mes')->get();
// $denominadores2 = Rem::year(2020)->with(['establecimiento' => function($q){ return $q->where('meta_san', 1); }])
//                   ->selectRaw('SUM(COALESCE(Col08, 0)) + SUM(COALESCE(Col09, 0)) + SUM(COALESCE(Col10, 0)) + SUM(COALESCE(Col11, 0)) AS valor, IdEstablecimiento, Mes')
//                   ->whereHas('establecimiento', function($q){ return $q->where('meta_san', 1); })
//                   ->whereIn('CodigoPrestacion', ['03500334'])->groupBy('IdEstablecimiento','Mes')->orderBy('Mes')->get();

// $denominadores2 = $denominadores2->transform(function($item, $key){ $item->valor = -$item->valor; return $item; });
// $denominadores = $denominadores->concat($denominadores2);
// dd($denominadores->sum('valor'));

foreach($denominadores as $registro) {
    if( ($flag1 != $registro->Comuna) OR ($flag2 != $registro->alias_estab) ) {
        for($mes=1; $mes <= $ultimo_rem; $mes++) {
            $data12020[$registro->Comuna][$registro->alias_estab]['denominadores'][$mes] = 0;
        }
        $flag1 = $registro->Comuna;
        $flag2 = $registro->alias_estab;
    }
    $data12020[$registro->Comuna][$registro->alias_estab]['denominadores'][$registro->Mes] = $registro->denominador;
}

foreach($data12020 as $nombre_comuna => $comuna) {
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
            $data12020[$nombre_comuna][$nombre_establecimiento]['denominadores']['total'] = array_sum($establecimiento['denominadores']);
            //$data12020[$nombre_comuna][$nombre_establecimiento]['denominadores_2']['total'] = array_sum($establecimiento['denominadores_2']);
            $data12020[$nombre_comuna][$nombre_establecimiento]['numeradores']['total'] = array_sum($establecimiento['numeradores']);

            //dd($data12020[$nombre_comuna][$nombre_establecimiento]['denominadores']['total']);

            /* Calcula los totales de cada comuna */
            $data12020[$nombre_comuna]['numeradores']['total'] += $data12020[$nombre_comuna][$nombre_establecimiento]['numeradores']['total'];
            $data12020[$nombre_comuna]['denominadores']['total'] += $data12020[$nombre_comuna][$nombre_establecimiento]['denominadores']['total'];
            //-$data12020[$nombre_comuna][$nombre_establecimiento]['denominadores_2']['total'];

            /* Calcula la suma mensual por comuna */
            for($mes=1; $mes <= $ultimo_rem; $mes++) {
                $data12020[$nombre_comuna]['numeradores'][$mes] += $establecimiento['numeradores'][$mes];
                $data12020[$nombre_comuna]['denominadores'][$mes] += $establecimiento['denominadores'][$mes];// - $establecimiento['denominadores_2'][$mes];
            }

            /* Calculo de las metas de cada establecimiento */
            if($data12020[$nombre_comuna][$nombre_establecimiento]['denominadores']['total'] == 0) {
                /* Si es 0 el denominadore entonces el cumplimiento es 0 */
                $data12020[$nombre_comuna][$nombre_establecimiento]['cumplimiento'] = 0;
            }
            else {
                /* De lo contrario calcular el porcentaje */
                $data12020[$nombre_comuna][$nombre_establecimiento]['cumplimiento'] =
                    $data12020[$nombre_comuna][$nombre_establecimiento]['numeradores']['total'] /
                    $data12020[$nombre_comuna][$nombre_establecimiento]['denominadores']['total'] * 100;
            }

            /* Calculo de las metas de la comuna */
            $data12020Graphics[$nombre_comuna]['cumplimiento'][$mes] = 0;
            if($data12020[$nombre_comuna]['denominadores']['total'] == 0) {
                /* Si es 0 el denominadore entonces el cumplimiento es 0 */
                $data12020[$nombre_comuna]['cumplimiento'] = 0;
            }
            else {
                /* De lo contrario calcular el porcentaje */
                $data12020[$nombre_comuna]['cumplimiento'] = $data12020[$nombre_comuna]['numeradores']['total'] / $data12020[$nombre_comuna]['denominadores']['total'] * 100;
                //$data12020Graphics[$nombre_comuna]['cumplimiento'][$mes] = $data12020Graphics[$nombre_comuna]['numeradores'][$mes] / $data12020[$nombre_comuna]['denominadores'][$mes] * 100;
            }
        }
    }
}
