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
$label['meta'] = 'Porcentaje de altas odontológicas totales en adolescentes de 12 años.';
$label['numerador'] = 'Nº de Adolescentes de 12 años con alta odontológica total de enero a diciembre 2020.';
$label['denominador'] = 'Total de Adolescentes de 12 años inscritos validados por FONASA para el año 2020.';

$meses = array(1,2,3,4,5,6,7,8,9,10,11,12);
$flag1 = NULL;
$flag2 = NULL;
$data3a2020 = array();

$sql_establecimientos = "SELECT comuna, alias_estab
                         FROM 2020establecimientos
                         WHERE meta_san = 1
                         ORDER BY comuna";

$establecimientos = DB::connection('mysql_rem')->select($sql_establecimientos);

/* ==== Inicializar en 0 el arreglo de datos $data3a2020 ==== */
foreach($establecimientos as $establecimiento) {
    $data3a2020[$establecimiento->comuna]['numeradores']['total'] = 0;
    $data3a2020[$establecimiento->comuna]['denominador'] = 0;
    $data3a2020[$establecimiento->comuna]['cumplimiento'] = 0;
    for($mes=1; $mes <= $ultimo_rem; $mes++) {
        $data3a2020[$establecimiento->comuna]['numeradores'][$mes] = 0;
        $data3a2020[$establecimiento->comuna][$establecimiento->alias_estab]['numeradores']['total'] = 0;
        $data3a2020[$establecimiento->comuna][$establecimiento->alias_estab]['numeradores'][$mes] = 0;
    }
    $data3a2020[$establecimiento->comuna][$establecimiento->alias_estab]['denominador'] = 0;
    $data3a2020[$establecimiento->comuna][$establecimiento->alias_estab]['cumplimiento'] = 0;
}

$data3a2020['ALTO HOSPICIO']['meta'] = '81%';
$data3a2020['CAMIÑA']['meta'] = '95%';
$data3a2020['COLCHANE']['meta'] = '75%';
$data3a2020['HUARA']['meta'] = '75%';
$data3a2020['IQUIQUE']['meta'] = '81%';
$data3a2020['PICA']['meta'] = '82%';
$data3a2020['POZO ALMONTE']['meta'] = '75%';


/* ===== Query numerador ===== */
$sql_numerador = 'SELECT e.Comuna, e.alias_estab, r.Mes, sum((COALESCE(Col18,0) + COALESCE(Col19,0))) as numerador
    FROM '.$year.'rems r
    LEFT JOIN 2020establecimientos e
    ON r.IdEstablecimiento=e.Codigo
    WHERE CodigoPrestacion IN (09215313,09215413) AND e.meta_san = 1
    GROUP by e.Comuna, e.alias_estab, r.Mes
    ORDER BY e.Comuna, e.alias_estab, r.Mes';
$numeradores = DB::connection('mysql_rem')->select($sql_numerador);

foreach($numeradores as $registro) {
    if( ($flag1 != $registro->Comuna) OR ($flag2 != $registro->alias_estab) ) {
        for($mes=1; $mes <= $ultimo_rem; $mes++) {
            $data3a2020[$registro->Comuna][$registro->alias_estab]['numeradores'][$mes] = 0;
        }
        $flag1 = $registro->Comuna;
        $flag2 = $registro->alias_estab;
    }
    $data3a2020[$registro->Comuna][$registro->alias_estab]['numeradores'][$registro->Mes] = $registro->numerador;
}

/* ===== Query denominador ===== */
$sql_denominador = "SELECT e.alias_estab, e.Comuna, COUNT(*) AS denominador
                    FROM 2020percapita p
                    LEFT JOIN 2020establecimientos e ON e.Codigo = p.COD_CENTRO
                    WHERE
                    FECHA_CORTE = '2019-08-31' AND
                    EDAD = 12 AND
                    ACEPTADO_RECHAZADO = 'ACEPTADO' AND e.meta_san = 1
                    GROUP BY e.Comuna, e.alias_estab
                    ORDER BY e.Comuna, e.alias_estab";
$denominadores = DB::connection('mysql_rem')->select($sql_denominador);



foreach($denominadores as $registro) {
    $data3a2020[$registro->Comuna][$registro->alias_estab]['denominador'] = $registro->denominador;
    $data3a2020[$registro->Comuna]['denominador'] += $registro->denominador;
}

/* NO se porqué está este valor a mano, no se necesita */
// $data3a2020['ALTO HOSPICIO']['denominador'] = 1491;
// $data3a2020['ALTO HOSPICIO']['CESFAM Pedro Pulgar']['denominador'] = 1491;
// $data3a2020['ALTO HOSPICIO']['CECOSF El Boro']['denominador'] = 0;
// $data3a2020['ALTO HOSPICIO']['CECOSF La Tortuga']['denominador'] = 0;

$data3a2020['CAMIÑA']['denominador'] = 21;
$data3a2020['CAMIÑA']['CGR Camiña']['denominador'] = 0;
$data3a2020['CAMIÑA']['Posta Rural Moquella']['denominador'] = 0;

$data3a2020['COLCHANE']['denominador'] = 19;
$data3a2020['COLCHANE']['CGR Colchane']['denominador'] = 0;
$data3a2020['COLCHANE']['Posta Rural Enquelga']['denominador'] = 0;
$data3a2020['COLCHANE']['Posta Rural Cariquima']['denominador'] = 0;

$data3a2020['HUARA']['denominador'] = 31;
$data3a2020['HUARA']['CGR Dr. Amador Neghme Rodríguez']['denominador'] = 0;
$data3a2020['HUARA']['Posta Rural Pisagua']['denominador'] = 0;
$data3a2020['HUARA']['Posta Rural Tarapacá']['denominador'] = 0;
$data3a2020['HUARA']['Posta Rural Chiapa']['denominador'] = 0;
$data3a2020['HUARA']['Posta Rural Sibaya']['denominador'] = 0;

// $data3a2020['IQUIQUE']['denominador'] = 2243;
// $data3a2020['IQUIQUE']['CESFAM Cirujano Aguirre']['denominador'] = 709;
// $data3a2020['IQUIQUE']['CESFAM Cirujano Videla']['denominador'] = 596;
// $data3a2020['IQUIQUE']['CESFAM Cirujano Guzmán']['denominador'] = 432;
// $data3a2020['IQUIQUE']['CESFAM Sur Iquique']['denominador'] = 497;
// $data3a2020['IQUIQUE']['Posta Rural Chanavayita']['denominador'] = 5;
// $data3a2020['IQUIQUE']['Posta Rural San Marcos']['denominador'] = 1;
// $data3a2020['IQUIQUE']['CECOSF Cerro Esmeralda']['denominador'] = 3;

// $data3a2020['PICA']['denominador'] = 78;
// $data3a2020['PICA']['CESFAM Pica']['denominador'] = 78;
// $data3a2020['PICA']['Posta Rural Cancosa']['denominador'] = 0;
// $data3a2020['PICA']['Posta Rural Matilla']['denominador'] = 0;

// $data3a2020['POZO ALMONTE']['denominador'] = 211;
// $data3a2020['POZO ALMONTE']['CESFAM Pozo Almonte']['denominador'] = 211;
// $data3a2020['POZO ALMONTE']['Posta Rural Mamiña']['denominador'] = 0;
// $data3a2020['POZO ALMONTE']['Posta Rural La Tirana']['denominador'] = 0;
// $data3a2020['POZO ALMONTE']['Posta Rural La Huayca']['denominador'] = 0;

//echo '<pre>-'; print_r($data3a2020); die();

/* ==== Calculos ==== */
foreach($data3a2020 as $nombre_comuna => $comuna) {
    foreach($comuna as $nombre_establecimiento => $establecimiento) {
        /* Existe en el array un indice ['numerador'], ['denominador'] y ['meta'],
         * estos almacenan la información de la comuna, por lo tanto tengo que saltarlos
         * en la iteración del foreach y continuar con los establecimientos */
        /* Realizar los calculos mensuales */
        if($nombre_establecimiento != 'numeradores' AND
            $nombre_establecimiento != 'denominador' AND
            $nombre_establecimiento != 'meta' AND
            $nombre_establecimiento != 'cumplimiento'){

            /* Calcula los totales de cada establecimiento */
            if(is_array($establecimiento['numeradores'])) {
                $data3a2020[$nombre_comuna][$nombre_establecimiento]['numeradores']['total'] = array_sum($establecimiento['numeradores']);
                //$data3a2020[$nombre_comuna][$nombre_establecimiento]['denominadores']['total'] = array_sum($establecimiento['denominadores']);
            }

            /* Calcula los totales de cada comuna */
            $data3a2020[$nombre_comuna]['numeradores']['total'] += $data3a2020[$nombre_comuna][$nombre_establecimiento]['numeradores']['total'];
            //$data3a2020[$nombre_comuna]['denominadores']['total'] += $data3a2020[$nombre_comuna][$nombre_establecimiento]['denominadores']['total'];

            /* Calcula la suma mensual por comuna */
            for($mes=1; $mes <= $ultimo_rem; $mes++) {
                $data3a2020[$nombre_comuna]['numeradores'][$mes] += $establecimiento['numeradores'][$mes];
                //$data3a2020[$nombre_comuna]['denominadores'][$mes] += $establecimiento['denominadores'][$mes];
            }

            /* Calculo de las cumplimiento de cada establecimiento */
            if($data3a2020[$nombre_comuna][$nombre_establecimiento]['denominador'] == 0) {
                /* Si es 0 el denominadore entonces la cumplimiento es 0 */
                $data3a2020[$nombre_comuna][$nombre_establecimiento]['cumplimiento'] = 0;
            }
            else {
                /* De lo contrario calcular el porcentaje */
                $data3a2020[$nombre_comuna][$nombre_establecimiento]['cumplimiento'] =
                    $data3a2020[$nombre_comuna][$nombre_establecimiento]['numeradores']['total'] / $data3a2020[$nombre_comuna][$nombre_establecimiento]['denominador'] * 100;
            }

            /* Calculo de las cumplimiento de la comuna */
            if($data3a2020[$nombre_comuna]['denominador'] == 0) {
                /* Si es 0 el denominadore entonces la cumplimiento es 0 */
                $data3a2020[$nombre_comuna]['cumplimiento'] = 0;
            }
            else {
                /* De lo contrario calcular el porcentaje */
                $data3a2020[$nombre_comuna]['cumplimiento'] = $data3a2020[$nombre_comuna]['numeradores']['total'] / $data3a2020[$nombre_comuna]['denominador'] * 100;
            }
        }
    }
}
