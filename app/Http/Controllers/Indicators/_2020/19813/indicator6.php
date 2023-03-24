<?php
namespace App\Http\Controllers\Indicators\_2020;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\Indicators\SingleParameter;

$year = 2020;

$sql_ultimo_rem = "SELECT MAX(Mes) as ultimo_rem FROM 2020rems;";
$ultimo_rem = DB::connection('mysql_rem')->select($sql_ultimo_rem)[0]->ultimo_rem;

/* Numerador = A0200002	LACTANCIA MATERNA EN MENORES CONTROLADOS - TIPO DE ALIMENTACIÓN - LACTANCIA MATERNA EXCLUSIVA
   Denominador = A0200001	LACTANCIA MATERNA EN MENORES CONTROLADOS - TIPO DE ALIMENTACIÓN - MENORES CONTROLADOS
*/
$label['meta'] = 'Porcentaje de niños y niñas que al sexto mes de vida, cuentan con lactancia materna exclusiva.';
$label['numerador'] = ' Nº de niños/as que al control de salud del sexto mes recibieron LME en el periodo de enero-diciembre 2020.';
$label['denominador'] = 'Nº de niño/as con control de salud del sexto mes realizado en el periodo de enero a diciembre de 2020.';

$meses = array(1,2,3,4,5,6,7,8,9,10,11,12);
$flag1 = NULL;
$flag2 = NULL;
$data62020 = array();

$sql_establecimientos =
'SELECT comuna, alias_estab
 FROM 2020establecimientos
 WHERE meta_san = 1
 ORDER BY comuna;';

$establecimientos = DB::connection('mysql_rem')->select($sql_establecimientos);

/* ==== Inicializar en 0 el arreglo de datos $data62020 ==== */
foreach($establecimientos as $establecimiento) {
    $data62020[$establecimiento->comuna]['numeradores']['total'] = 0;
    $data62020[$establecimiento->comuna]['denominadores']['total'] = 0;
    $data62020[$establecimiento->comuna]['cumplimiento'] = 0;
    for($mes=1; $mes <= $ultimo_rem; $mes++) {
        $data62020[$establecimiento->comuna]['numeradores'][$mes] = 0;
        $data62020[$establecimiento->comuna]['denominadores'][$mes] = 0;
        $data62020[$establecimiento->comuna][$establecimiento->alias_estab]['numeradores']['total'] = 0;
        $data62020[$establecimiento->comuna][$establecimiento->alias_estab]['denominadores']['total'] = 0;
        $data62020[$establecimiento->comuna][$establecimiento->alias_estab]['numeradores'][$mes] = 0;
        $data62020[$establecimiento->comuna][$establecimiento->alias_estab]['denominadores'][$mes] = 0;
    }
    $data62020[$establecimiento->comuna][$establecimiento->alias_estab]['cumplimiento'] = 0;
}

$data62020['ALTO HOSPICIO']['meta'] = '60%';
$data62020['CAMIÑA']['meta'] = '70%';
$data62020['COLCHANE']['meta'] = '100%';
$data62020['HUARA']['meta'] = '75%';
$data62020['IQUIQUE']['meta'] = '63%';
$data62020['PICA']['meta'] = '60%';
$data62020['POZO ALMONTE']['meta'] = '58%';

/* ===== Query numerador ===== */
$sql_numerador = 'SELECT e.Comuna, e.alias_estab, r.Mes, (ifnull(Col08,0) + ifnull(Col09,0)) as numerador
    FROM '.$year.'rems r
    LEFT JOIN 2020establecimientos e
    ON r.IdEstablecimiento=e.Codigo
    WHERE CodigoPrestacion = "A0200002" AND e.meta_san = 1
    ORDER BY e.Comuna, e.alias_estab, r.Mes';
$numeradores = DB::connection('mysql_rem')->select($sql_numerador);

foreach($numeradores as $registro) {
    if( ($flag1 != $registro->Comuna) OR ($flag2 != $registro->alias_estab) ) {
        for($mes=1; $mes <= $ultimo_rem; $mes++) {
            $data62020[$registro->Comuna][$registro->alias_estab]['numeradores'][$mes] = 0;
        }
        $flag1 = $registro->Comuna;
        $flag2 = $registro->alias_estab;
    }
    $data62020[$registro->Comuna][$registro->alias_estab]['numeradores'][$registro->Mes] = $registro->numerador;
}

/* ===== Query denominador ===== */
$sql_denominador = 'SELECT e.Comuna, e.alias_estab, r.Mes, (ifnull(Col08,0) + ifnull(Col09,0)) as denominador
    FROM '.$year.'rems r
    LEFT JOIN 2020establecimientos e
    ON r.IdEstablecimiento=e.Codigo
    WHERE CodigoPrestacion = "A0200001" AND e.meta_san = 1
    ORDER BY e.Comuna, e.alias_estab, r.Mes';
$denominadores = DB::connection('mysql_rem')->select($sql_denominador);

foreach($denominadores as $registro) {
    if( ($flag1 != $registro->Comuna) OR ($flag2 != $registro->alias_estab) ) {
        for($mes=1; $mes <= $ultimo_rem; $mes++) {
            $data62020[$registro->Comuna][$registro->alias_estab]['denominadores'][$mes] = 0;
        }
        $flag1 = $registro->Comuna;
        $flag2 = $registro->alias_estab;
    }
    $data62020[$registro->Comuna][$registro->alias_estab]['denominadores'][$registro->Mes] = $registro->denominador;
}

/* ==== Calculos ==== */
foreach($data62020 as $nombre_comuna => $comuna) {
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
            $data62020[$nombre_comuna][$nombre_establecimiento]['denominadores']['total'] = array_sum($establecimiento['denominadores']);
            $data62020[$nombre_comuna][$nombre_establecimiento]['numeradores']['total'] = array_sum($establecimiento['numeradores']);

            /* Calcula los totales de cada comuna */
            $data62020[$nombre_comuna]['numeradores']['total'] += $data62020[$nombre_comuna][$nombre_establecimiento]['numeradores']['total'];
            $data62020[$nombre_comuna]['denominadores']['total'] += $data62020[$nombre_comuna][$nombre_establecimiento]['denominadores']['total'];

            /* Calcula la suma mensual por comuna */
            for($mes=1; $mes <= $ultimo_rem; $mes++) {
                $data62020[$nombre_comuna]['numeradores'][$mes] += $establecimiento['numeradores'][$mes];
                $data62020[$nombre_comuna]['denominadores'][$mes] += $establecimiento['denominadores'][$mes];
            }

            /* Calculo de las metas de cada establecimiento */
            if($data62020[$nombre_comuna][$nombre_establecimiento]['denominadores']['total'] == 0) {
                /* Si es 0 el denominadore entonces la cumplimiento es 0 */
                $data62020[$nombre_comuna][$nombre_establecimiento]['cumplimiento'] = 0;
            }
            else {
                /* De lo contrario calcular el porcentaje */
                $data62020[$nombre_comuna][$nombre_establecimiento]['cumplimiento'] = $data62020[$nombre_comuna][$nombre_establecimiento]['numeradores']['total'] / $data62020[$nombre_comuna][$nombre_establecimiento]['denominadores']['total'] * 100;
            }

            /* Calculo de las metas de la comuna */
            if($data62020[$nombre_comuna]['denominadores']['total'] == 0) {
                /* Si es 0 el denominadore entonces la cumplimiento es 0 */
                $data62020[$nombre_comuna]['cumplimiento'] = 0;
            }
            else {
                /* De lo contrario calcular el porcentaje */
                $data62020[$nombre_comuna]['cumplimiento'] = $data62020[$nombre_comuna]['numeradores']['total'] / $data62020[$nombre_comuna]['denominadores']['total'] * 100;
            }
        }
    }
}
