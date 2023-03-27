<?php
namespace App\Http\Controllers\Indicators\_2020;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\Indicators\SingleParameter;

$year = 2020;

$sql_ultimo_rem = "SELECT MAX(Mes) as ultimo_rem FROM 2020rems;";
$ultimo_rem = DB::connection('mysql_rem')->select($sql_ultimo_rem)[0]->ultimo_rem;

/* Numerador = 09215015   Denominador =    */
$label['meta'] = 'Porcentaje de egresos odontológicos en niños y niñas de 6 años.';
$label['numerador'] = 'N° niños de 6 años inscritos con egreso odontológico de enero a diciembre 2020.';
$label['denominador'] = 'Total niños de 6 años inscritos validados por FONASA para el año 2020.';


$flag1 = NULL;
$flag2 = NULL;
$data3c2020 = array();

$sql_establecimientos = "SELECT comuna, alias_estab
                         FROM 2020establecimientos
                         WHERE meta_san = 1
                         ORDER BY comuna";

$establecimientos = DB::connection('mysql_rem')->select($sql_establecimientos);

/* ==== Inicializar en 0 el arreglo de datos $data3c2020 ==== */
foreach($establecimientos as $establecimiento) {
    $data3c2020[$establecimiento->comuna]['numeradores']['total'] = 0;
    $data3c2020[$establecimiento->comuna]['denominador'] = 0;
    $data3c2020[$establecimiento->comuna]['cumplimiento'] = 0;
    for($mes=1; $mes <= $ultimo_rem; $mes++) {
        $data3c2020[$establecimiento->comuna]['numeradores'][$mes] = 0;
        $data3c2020[$establecimiento->comuna][$establecimiento->alias_estab]['numeradores']['total'] = 0;
        $data3c2020[$establecimiento->comuna][$establecimiento->alias_estab]['numeradores'][$mes] = 0;
    }
    $data3c2020[$establecimiento->comuna][$establecimiento->alias_estab]['denominador'] = 0;
    $data3c2020[$establecimiento->comuna][$establecimiento->alias_estab]['cumplimiento'] = 0;
}


$data3c2020['ALTO HOSPICIO']['meta'] = '74%';
$data3c2020['CAMIÑA']['meta'] = '79%';
$data3c2020['COLCHANE']['meta'] = '83%';
$data3c2020['HUARA']['meta'] = '79%';
$data3c2020['IQUIQUE']['meta'] = '79%';
$data3c2020['PICA']['meta'] = '79%';
$data3c2020['POZO ALMONTE']['meta'] = '75%';


/* ===== Query numerador ===== */
$sql_numerador = 'SELECT e.Comuna, e.alias_estab, r.Mes, sum((ifnull(Col16,0) + ifnull(Col17,0))) as numerador
    FROM '.$year.'rems r
    LEFT JOIN 2020establecimientos e
    ON r.IdEstablecimiento=e.Codigo
    WHERE CodigoPrestacion IN (09215015) AND e.meta_san = 1
    GROUP by e.Comuna, e.alias_estab, r.Mes
    ORDER BY e.Comuna, e.alias_estab, r.Mes';
$numeradores = DB::connection('mysql_rem')->select($sql_numerador);

foreach($numeradores as $registro) {
    if( ($flag1 != $registro->Comuna) OR ($flag2 != $registro->alias_estab) ) {
        for($mes=1; $mes <= $ultimo_rem; $mes++) {
            $data3c2020[$registro->Comuna][$registro->alias_estab]['numeradores'][$mes] = 0;
        }
        $flag1 = $registro->Comuna;
        $flag2 = $registro->alias_estab;
    }
    $data3c2020[$registro->Comuna][$registro->alias_estab]['numeradores'][$registro->Mes] = $registro->numerador;
}

/* ===== Query denominador ===== */
$sql_denominador = "SELECT e.alias_estab, e.Comuna, COUNT(*) AS denominador
                    FROM 2020percapita p
                    LEFT JOIN 2020establecimientos e ON e.Codigo = p.COD_CENTRO
                    WHERE
                    FECHA_CORTE = '2019-08-31' AND
                    EDAD = 6 AND
                    ACEPTADO_RECHAZADO = 'ACEPTADO' AND e.meta_san = 1
                    GROUP BY e.Comuna, e.alias_estab
                    ORDER BY e.Comuna, e.alias_estab";
$denominadores = DB::connection('mysql_rem')->select($sql_denominador);



foreach($denominadores as $registro) {
    $data3c2020[$registro->Comuna][$registro->alias_estab]['denominador'] = $registro->denominador;
    $data3c2020[$registro->Comuna]['denominador'] += $registro->denominador;
}

// $data3c2020['ALTO HOSPICIO']['denominador'] = 1641;
// $data3c2020['ALTO HOSPICIO']['CESFAM Pedro Pulgar']['denominador'] = 1641;
// $data3c2020['ALTO HOSPICIO']['CECOSF El Boro']['denominador'] = 0;
// $data3c2020['ALTO HOSPICIO']['CECOSF La Tortuga']['denominador'] = 0;

$data3c2020['CAMIÑA']['denominador'] = 28;
$data3c2020['CAMIÑA']['CGR Camiña']['denominador'] = 0;
$data3c2020['CAMIÑA']['Posta Rural Moquella']['denominador'] = 0;

$data3c2020['COLCHANE']['denominador'] = 6;
$data3c2020['COLCHANE']['CGR Colchane']['denominador'] = 0;
$data3c2020['COLCHANE']['Posta Rural Enquelga']['denominador'] = 0;
$data3c2020['COLCHANE']['Posta Rural Cariquima']['denominador'] = 0;

$data3c2020['HUARA']['denominador'] = 77;
$data3c2020['HUARA']['CGR Dr. Amador Neghme Rodríguez']['denominador'] = 0;
$data3c2020['HUARA']['Posta Rural Pisagua']['denominador'] = 0;
$data3c2020['HUARA']['Posta Rural Tarapacá']['denominador'] = 0;
$data3c2020['HUARA']['Posta Rural Chiapa']['denominador'] = 0;
$data3c2020['HUARA']['Posta Rural Sibaya']['denominador'] = 0;

// $data3c2020['IQUIQUE']['denominador'] = 2622;
// $data3c2020['IQUIQUE']['CESFAM Cirujano Aguirre']['denominador'] = 780;
// $data3c2020['IQUIQUE']['CESFAM Cirujano Videla']['denominador'] = 702;
// $data3c2020['IQUIQUE']['CESFAM Cirujano Guzmán']['denominador'] = 519;
// $data3c2020['IQUIQUE']['CESFAM Sur Iquique']['denominador'] = 610;
// $data3c2020['IQUIQUE']['Posta Rural Chanavayita']['denominador'] = 1;
// $data3c2020['IQUIQUE']['Posta Rural San Marcos']['denominador'] = 1;
// $data3c2020['IQUIQUE']['CECOSF Cerro Esmeralda']['denominador'] = 9;

// $data3c2020['PICA']['denominador'] = 99;
// $data3c2020['PICA']['CESFAM Pica']['denominador'] = 99;
// $data3c2020['PICA']['Posta Rural Cancosa']['denominador'] = 0;
// $data3c2020['PICA']['Posta Rural Matilla']['denominador'] = 0;

// $data3c2020['POZO ALMONTE']['denominador'] = 258;
// $data3c2020['POZO ALMONTE']['CESFAM Pozo Almonte']['denominador'] = 258;
// $data3c2020['POZO ALMONTE']['Posta Rural Mamiña']['denominador'] = 0;
// $data3c2020['POZO ALMONTE']['Posta Rural La Tirana']['denominador'] = 0;
// $data3c2020['POZO ALMONTE']['Posta Rural La Huayca']['denominador'] = 0;

/* ==== Calculos ==== */
foreach($data3c2020 as $nombre_comuna => $comuna) {
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
                $data3c2020[$nombre_comuna][$nombre_establecimiento]['numeradores']['total'] = array_sum($establecimiento['numeradores']);
                //$data3c2020[$nombre_comuna][$nombre_establecimiento]['denominadores']['total'] = array_sum($establecimiento['denominadores']);
            }

            /* Calcula los totales de cada comuna */
            $data3c2020[$nombre_comuna]['numeradores']['total'] += $data3c2020[$nombre_comuna][$nombre_establecimiento]['numeradores']['total'];
            //$data3c2020[$nombre_comuna]['denominadores']['total'] += $data3c2020[$nombre_comuna][$nombre_establecimiento]['denominadores']['total'];

            /* Calcula la suma mensual por comuna */
            for($mes=1; $mes <= $ultimo_rem; $mes++) {
                $data3c2020[$nombre_comuna]['numeradores'][$mes] += $establecimiento['numeradores'][$mes];
                //$data3c2020[$nombre_comuna]['denominadores'][$mes] += $establecimiento['denominadores'][$mes];
            }

            /* Calculo de las metas de cada establecimiento */
            if($data3c2020[$nombre_comuna][$nombre_establecimiento]['denominador'] == 0) {
                /* Si es 0 el denominadore entonces la cumplimiento es 0 */
                $data3c2020[$nombre_comuna][$nombre_establecimiento]['cumplimiento'] = 0;
            }
            else {
                /* De lo contrario calcular el porcentaje */
                $data3c2020[$nombre_comuna][$nombre_establecimiento]['cumplimiento'] =
                    $data3c2020[$nombre_comuna][$nombre_establecimiento]['numeradores']['total'] / $data3c2020[$nombre_comuna][$nombre_establecimiento]['denominador'] * 100;
            }

            /* Calculo de las metas de la comuna */
            if($data3c2020[$nombre_comuna]['denominador'] == 0) {
                /* Si es 0 el denominadore entonces la cumplimiento es 0 */
                $data3c2020[$nombre_comuna]['cumplimiento'] = 0;
            }
            else {
                /* De lo contrario calcular el porcentaje */
                $data3c2020[$nombre_comuna]['cumplimiento'] = $data3c2020[$nombre_comuna]['numeradores']['total'] / $data3c2020[$nombre_comuna]['denominador'] * 100;
            }
        }
    }
}
