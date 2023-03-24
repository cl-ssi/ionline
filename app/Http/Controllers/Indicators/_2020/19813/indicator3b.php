<?php
namespace App\Http\Controllers\Indicators\_2020;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\Indicators\SingleParameter;

$year = 2020;

$sql_ultimo_rem = "SELECT MAX(Mes) as ultimo_rem FROM 2020rems;";
$ultimo_rem = DB::connection('mysql_rem')->select($sql_ultimo_rem)[0]->ultimo_rem;

/* Numerador = 09215313 09215413   Denominador = 01080008*/

$label['meta'] = 'Cobertura de alta odontológica total en embarazadas: Porcentaje de altas odontológicas totales en embarazadas.';
$label['numerador'] = 'Nº de embarazadas con alta odontológica total de enero a diciembre 2020.';
$label['denominador'] = 'Nº total de embarazadas ingresadas a control prenatal de enero a diciembre del 2019.';

$meses = array(1,2,3,4,5,6,7,8,9,10,11,12);
$flag1 = NULL;
$flag2 = NULL;
$data3b2020 = array();

$sql_establecimientos =
'SELECT comuna, alias_estab
 FROM 2020establecimientos
 WHERE meta_san = 1
 ORDER BY comuna;';

$establecimientos = DB::connection('mysql_rem')->select($sql_establecimientos);

/* ==== Inicializar en 0 el arreglo de datos $data3b2020 ==== */
foreach($establecimientos as $establecimiento) {
    $data3b2020[$establecimiento->comuna]['numeradores']['total'] = 0;
    $data3b2020[$establecimiento->comuna]['denominadores']['total'] = 0;
    $data3b2020[$establecimiento->comuna]['cumplimiento'] = 0;
    for($mes=1; $mes <= $ultimo_rem; $mes++) {
        $data3b2020[$establecimiento->comuna]['numeradores'][$mes] = 0;
        $data3b2020[$establecimiento->comuna]['denominadores'][$mes] = 0;
        $data3b2020[$establecimiento->comuna][$establecimiento->alias_estab]['numeradores']['total'] = 0;
        $data3b2020[$establecimiento->comuna][$establecimiento->alias_estab]['denominadores']['total'] = 0;
        $data3b2020[$establecimiento->comuna][$establecimiento->alias_estab]['numeradores'][$mes] = 0;
        $data3b2020[$establecimiento->comuna][$establecimiento->alias_estab]['denominadores'][$mes] = 0;
    }
    $data3b2020[$establecimiento->comuna][$establecimiento->alias_estab]['cumplimiento'] = 0;
}

$data3b2020['ALTO HOSPICIO']['meta'] = '73%';
$data3b2020['CAMIÑA']['meta'] = '77%';
$data3b2020['COLCHANE']['meta'] = '80%';
$data3b2020['HUARA']['meta'] = '74%';
$data3b2020['IQUIQUE']['meta'] = '68%';
$data3b2020['PICA']['meta'] = '85%';
$data3b2020['POZO ALMONTE']['meta'] = '69%';

/* ===== Query numerador =====
09215313	INGRESOS Y EGRESOS  EN ESTABLECIMIENTOS APS - TIPO DE INGRESO O EGRESO - ALTAS ODONTOLÓGICAS PREVENTIVAS
09215413	INGRESOS Y EGRESOS  EN ESTABLECIMIENTOS APS - TIPO DE INGRESO O EGRESO - ALTAS ODONTOLÓGICAS INTEGRALES (EXCLUYE SECCIÓN G)
*/
$sql_numerador = 'SELECT e.Comuna, e.alias_estab, r.Mes, sum((ifnull(Col28,0))) as numerador
    FROM '.$year.'rems r
    LEFT JOIN 2020establecimientos e
    ON r.IdEstablecimiento=e.Codigo
    WHERE CodigoPrestacion IN (09215313,09215413) AND e.meta_san = 1
    GROUP BY e.Comuna, e.alias_estab, r.Mes
    ORDER BY e.Comuna, e.alias_estab, r.Mes';
$numeradores = DB::connection('mysql_rem')->select($sql_numerador);

foreach($numeradores as $registro) {
    if( ($flag1 != $registro->Comuna) OR ($flag2 != $registro->alias_estab) ) {
        for($mes=1; $mes <= $ultimo_rem; $mes++) {
            $data3b2020[$registro->Comuna][$registro->alias_estab]['numeradores'][$mes] = 0;
        }
        $flag1 = $registro->Comuna;
        $flag2 = $registro->alias_estab;
    }
    $data3b2020[$registro->Comuna][$registro->alias_estab]['numeradores'][$registro->Mes] = $registro->numerador;
}

/* ===== Query denominador =====
01080008	INGRESOS DE GESTANTES A PROGRAMA PRENATAL - CONDICIÓN - GESTANTES INGRESADAS
*/
$sql_denominador = 'SELECT e.Comuna, e.alias_estab, r.Mes, (ifnull(Col01,0)) as denominador
    FROM '.$year.'rems r
    LEFT JOIN 2020establecimientos e
    ON r.IdEstablecimiento=e.Codigo
    WHERE CodigoPrestacion = 01080008 AND e.meta_san = 1
    ORDER BY e.Comuna, e.alias_estab, r.Mes';
$denominadores = DB::connection('mysql_rem')->select($sql_denominador);

foreach($denominadores as $registro) {
    if( ($flag1 != $registro->Comuna) OR ($flag2 != $registro->alias_estab) ) {
        for($mes=1; $mes <= $ultimo_rem; $mes++) {
            $data3b2020[$registro->Comuna][$registro->alias_estab]['denominadores'][$mes] = 0;
        }
        $flag1 = $registro->Comuna;
        $flag2 = $registro->alias_estab;
    }
    $data3b2020[$registro->Comuna][$registro->alias_estab]['denominadores'][$registro->Mes] = $registro->denominador;
}

/* ==== Calculos ==== */
foreach($data3b2020 as $nombre_comuna => $comuna) {
    foreach($comuna as $nombre_establecimiento => $establecimiento) {
        /* Existe en el array un indice ['numerador'], ['denominador'] y ['meta'],
         * estos almacenan la información de la comuna, por lo tanto tengo que saltarlos
         * en la iteración del foreach y continuar con los establecimientos */
        /* Realizar los calculos mensuales */
        if($nombre_establecimiento != 'numeradores' AND
            $nombre_establecimiento != 'denominadores' AND
            $nombre_establecimiento != 'meta' AND
            $nombre_establecimiento != 'cumplimiento'){

            /* Calcula los totales de cada establecimiento */
            $data3b2020[$nombre_comuna][$nombre_establecimiento]['denominadores']['total'] = array_sum($establecimiento['denominadores']);
            $data3b2020[$nombre_comuna][$nombre_establecimiento]['numeradores']['total'] = array_sum($establecimiento['numeradores']);

            /* Calcula los totales de cada comuna */
            $data3b2020[$nombre_comuna]['numeradores']['total'] += $data3b2020[$nombre_comuna][$nombre_establecimiento]['numeradores']['total'];
            $data3b2020[$nombre_comuna]['denominadores']['total'] += $data3b2020[$nombre_comuna][$nombre_establecimiento]['denominadores']['total'];

            /* Calcula la suma mensual por comuna */
            for($mes=1; $mes <= $ultimo_rem; $mes++) {
                $data3b2020[$nombre_comuna]['numeradores'][$mes] += $establecimiento['numeradores'][$mes];
                $data3b2020[$nombre_comuna]['denominadores'][$mes] += $establecimiento['denominadores'][$mes];
            }

            /* Calculo de las cumplimiento de cada establecimiento */
            if($data3b2020[$nombre_comuna][$nombre_establecimiento]['denominadores']['total'] == 0) {
                /* Si es 0 el denominadore entonces la cumplimiento es 0 */
                $data3b2020[$nombre_comuna][$nombre_establecimiento]['cumplimiento'] = 0;
            }
            else {
                /* De lo contrario calcular el porcentaje */
                $data3b2020[$nombre_comuna][$nombre_establecimiento]['cumplimiento'] = $data3b2020[$nombre_comuna][$nombre_establecimiento]['numeradores']['total'] / $data3b2020[$nombre_comuna][$nombre_establecimiento]['denominadores']['total'] * 100;
            }

            /* Calculo de las cumplimiento de la comuna */
            if($data3b2020[$nombre_comuna]['denominadores']['total'] == 0) {
                /* Si es 0 el denominadore entonces la cumplimiento es 0 */
                $data3b2020[$nombre_comuna]['cumplimiento'] = 0;
            }
            else {
                /* De lo contrario calcular el porcentaje */
                $data3b2020[$nombre_comuna]['cumplimiento'] = $data3b2020[$nombre_comuna]['numeradores']['total'] / $data3b2020[$nombre_comuna]['denominadores']['total'] * 100;
            }
        }
    }
}
