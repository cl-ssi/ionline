<?php
namespace App\Http\Controllers\Indicators\_2019;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\Indicators\SingleParameter;

/* INDICADOR 1 */
/* 2019 */
$year = 2019;

$sql_ultimo_rem = "SELECT MAX(Mes) as ultimo_rem FROM 2019rems;";
$ultimo_rem = DB::connection('mysql_rem')->select($sql_ultimo_rem)[0]->ultimo_rem;
$mescarga = $ultimo_rem;

/* 02010420	RESULTADOS DE LA APLICACIÓN DE ESCALA DE EVALUACIÓN DEL DESARROLLO PSICOMOTOR - REEVALUACIÓN - NORMAL (de riesgo)
   03500366	RESULTADOS DE LA APLICACIÓN DE ESCALA DE EVALUACIÓN DEL DESARROLLO PSICOMOTOR - REEVALUACIÓN - NORMAL CON REZAGO (de riesgo) */

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
        $data120191[$establecimiento->comuna][$establecimiento->alias_estab]['denominadores_2']['total'] = 0;
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
    WHERE CodigoPrestacion in (02010420,03500366) AND e.meta_san = 1
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
                    WHERE e.meta_san = 1
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

/* INDICADOR 2 */
/* 2019 */

$data22019 = array();

$sql_establecimientos = "SELECT Codigo AS codigo, alias_estab AS nombre, comuna
                         FROM 2019establecimientos
                         WHERE meta_san = 1
                         ORDER BY comuna;";

$establecimientos = DB::connection('mysql_rem')->select($sql_establecimientos);


$data22019['ALTO HOSPICIO']['meta'] = '46%';
$data22019['CAMIÑA']['meta'] = '59%';
$data22019['COLCHANE']['meta'] = '100%';
$data22019['HUARA']['meta'] = '57%';
$data22019['IQUIQUE']['meta'] = '55%';
$data22019['PICA']['meta'] = '55%';
$data22019['POZO ALMONTE']['meta'] = '59%';

/* ==== Inicializar en 0 el arreglo de datos $data22019 ==== */
foreach($establecimientos as $establecimiento) {
    $data22019[$establecimiento->comuna]['numerador'] = 0;
    $data22019[$establecimiento->comuna]['establecimientos'][$establecimiento->nombre]['numerador'] = 0;

    $data22019[$establecimiento->comuna]['numerador_6'] = 0;
    $data22019[$establecimiento->comuna]['establecimientos'][$establecimiento->nombre]['numerador_6'] = 0;

    $data22019[$establecimiento->comuna]['numerador_12'] = 0;
    $data22019[$establecimiento->comuna]['establecimientos'][$establecimiento->nombre]['numerador_12'] = 0;

    $data22019[$establecimiento->comuna]['denominador'] = 0;
    $data22019[$establecimiento->comuna]['establecimientos'][$establecimiento->nombre]['denominador'] = 0;

    $data22019[$establecimiento->comuna]['cumplimiento'] = 0;
    $data22019[$establecimiento->comuna]['establecimientos'][$establecimiento->nombre]['cumplimiento'] = 0;

    $data22019[$establecimiento->comuna]['establecimientos'][$establecimiento->nombre]['meta'] = $data22019[$establecimiento->comuna]['meta'];
}

/* Sólo si está cargado sobre el rem de Junio */
if($ultimo_rem >= 6) {

    /* ===== Query numerador ===== */
    $sql_numerador =
        "SELECT e.Comuna AS comuna, e.alias_estab AS nombre, r.Mes AS mes, sum(ifnull(Col01,0)) as numerador
        FROM {$year}rems r
        LEFT JOIN 2019establecimientos e ON r.IdEstablecimiento=e.Codigo
        WHERE
        e.meta_san = 1 AND Ano = 2019 AND (Mes = 6 OR Mes = 12) AND
        CodigoPrestacion IN ('P1206010','P1206020','P1206030','P1206040','P1206050','P1206060','P1206070','P1206080')
        GROUP by e.Comuna, e.alias_estab, r.Mes
        ORDER BY e.Comuna, e.alias_estab, r.Mes";

    $numeradores = DB::connection('mysql_rem')->select($sql_numerador);

    //dd($data22019);

    foreach($numeradores as $registro) {
        if($registro->mes == 6) {
            $data22019[$registro->comuna]['numerador_6'] += $registro->numerador;
            $data22019[$registro->comuna]['establecimientos'][$registro->nombre]['numerador_6'] = $registro->numerador;
        }
        if($registro->mes == 12){
            $data22019[$registro->comuna]['numerador_12'] += $registro->numerador;
            $data22019[$registro->comuna]['establecimientos'][$registro->nombre]['numerador_12'] = $registro->numerador;
        }

        if($ultimo_rem < 12) {
            $data22019[$registro->comuna]['numerador'] = $data22019[$registro->comuna]['numerador_6'];
            $data22019[$registro->comuna]['establecimientos'][$registro->nombre]['numerador'] =
                $data22019[$registro->comuna]['establecimientos'][$registro->nombre]['numerador_6'];
        }
        else {
            $data22019[$registro->comuna]['numerador'] = $data22019[$registro->comuna]['numerador_12'];
            $data22019[$registro->comuna]['establecimientos'][$registro->nombre]['numerador'] =
                $data22019[$registro->comuna]['establecimientos'][$registro->nombre]['numerador_12'];
        }
    }

    /* ===== Query denominador ===== */
    $sql_denominador = "SELECT e.alias_estab as nombre, e.Comuna as comuna, COUNT(*) AS denominador
                        FROM percapita_pro p
                        LEFT JOIN 2019establecimientos e ON e.Codigo = p.COD_CENTRO
                        WHERE
                        FECHA_CORTE = '2018-08-31' AND
                        GENERO = 'F' AND
                        EDAD BETWEEN 25 AND 64 AND
                        ACEPTADO_RECHAZADO = 'ACEPTADO'
                        AND e.meta_san = 1
                        GROUP BY e.Comuna, e.alias_estab
                        ORDER BY e.Comuna, e.alias_estab";

    $denominadores = DB::connection('mysql_rem')->select($sql_denominador);

    foreach($denominadores as $registro) {
        $data22019[$registro->comuna]['denominador'] += $registro->denominador;
        $data22019[$registro->comuna]['establecimientos'][$registro->nombre]['denominador'] = $registro->denominador;
    }

    /* Poblaciones manuales (denominadores) */
    $data22019['CAMIÑA']['denominador'] = 327;
    $data22019['CAMIÑA']['establecimientos']['CGR Camiña']['denominador'] = 0;
    $data22019['CAMIÑA']['establecimientos']['Posta Rural Moquella']['denominador'] = 0;

    $data22019['COLCHANE']['denominador'] = 218;
    $data22019['COLCHANE']['establecimientos']['CGR Colchane']['denominador'] = 0;
    $data22019['COLCHANE']['establecimientos']['Posta Rural Enquelga']['denominador'] = 0;
    $data22019['COLCHANE']['establecimientos']['Posta Rural Cariquima']['denominador'] = 0;

    $data22019['HUARA']['denominador'] = 594;
    $data22019['HUARA']['establecimientos']['CGR Dr. Amador Neghme Rodríguez']['denominador'] = 0;
    $data22019['HUARA']['establecimientos']['Posta Rural Pisagua']['denominador'] = 0;
    $data22019['HUARA']['establecimientos']['Posta Rural Tarapacá']['denominador'] = 0;
    $data22019['HUARA']['establecimientos']['Posta Rural Chiapa']['denominador'] = 0;
    $data22019['HUARA']['establecimientos']['Posta Rural Sibaya']['denominador'] = 0;


    /* ==== Calculos ==== */
    foreach($data22019 as $nombre_comuna => $comuna) {
        /* Calculo de las metas de la comuna */
        if($data22019[$nombre_comuna]['denominador'] == 0) {
            /* Si es 0 el denominadore entonces la meta es 0 */
            $data22019[$nombre_comuna]['cumplimiento'] = 0;
        }
        else {
            $data22019[$nombre_comuna]['cumplimiento'] = $data22019[$nombre_comuna]['numerador'] /
                $data22019[$nombre_comuna]['denominador'] * 100;
        }
        /* Formateo de tipo de número después de hacer calculos*/
        $data22019[$nombre_comuna]['numerador'] = $data22019[$nombre_comuna]['numerador'];
        $data22019[$nombre_comuna]['numerador_6'] = $data22019[$nombre_comuna]['numerador_6'];
        $data22019[$nombre_comuna]['numerador_12'] = $data22019[$nombre_comuna]['numerador_12'];
        $data22019[$nombre_comuna]['denominador'] = $data22019[$nombre_comuna]['denominador'];

        foreach($comuna['establecimientos'] as $nombre_establecimiento => $establecimiento) {
            /* Calculo de cumplimiento de cada establecimiento */
            if($establecimiento['denominador'] == 0) {
                /* Si es 0 el denominador entonces la meta es 0 */
                $data22019[$nombre_comuna]['establecimientos'][$nombre_establecimiento]['cumplimiento'] = 0;
            }
            else {
                $data22019[$nombre_comuna]['establecimientos'][$nombre_establecimiento]['cumplimiento'] =
                    $data22019[$nombre_comuna]['establecimientos'][$nombre_establecimiento]['numerador'] /
                    $data22019[$nombre_comuna]['establecimientos'][$nombre_establecimiento]['denominador'] * 100;
            }

            /* Formateo de tipo de número después de hacer calculos*/
            $data22019[$nombre_comuna]['establecimientos'][$nombre_establecimiento]['numerador'] =
               $data22019[$nombre_comuna]['establecimientos'][$nombre_establecimiento]['numerador'];
            $data22019[$nombre_comuna]['establecimientos'][$nombre_establecimiento]['numerador_6'] =
                $data22019[$nombre_comuna]['establecimientos'][$nombre_establecimiento]['numerador_6'];
            $data22019[$nombre_comuna]['establecimientos'][$nombre_establecimiento]['numerador_12'] =
                $data22019[$nombre_comuna]['establecimientos'][$nombre_establecimiento]['numerador_12'];
            $data22019[$nombre_comuna]['establecimientos'][$nombre_establecimiento]['denominador'] =
                $data22019[$nombre_comuna]['establecimientos'][$nombre_establecimiento]['denominador'];
        }
    }
}

//dd($data22019);

/* INDICADOR 3A */
/* 2019 */

$sql_ultimo_rem = "SELECT MAX(Mes) as ultimo_rem FROM 2019rems;";
$ultimo_rem = DB::connection('mysql_rem')->select($sql_ultimo_rem)[0]->ultimo_rem;

/* Numerador = 09215313 09215413   Denominador = 01080008*/

$meses = array(1,2,3,4,5,6,7,8,9,10,11,12);
$flag1 = NULL;
$flag2 = NULL;
$data3a2019 = array();

$sql_establecimientos = "SELECT comuna, alias_estab
                         FROM 2019establecimientos
                         WHERE meta_san = 1
                         ORDER BY comuna";

$establecimientos = DB::connection('mysql_rem')->select($sql_establecimientos);

/* ==== Inicializar en 0 el arreglo de datos $data3a2019 ==== */
foreach($establecimientos as $establecimiento) {
    $data3a2019[$establecimiento->comuna]['numeradores']['total'] = 0;
    $data3a2019[$establecimiento->comuna]['denominador'] = 0;
    $data3a2019[$establecimiento->comuna]['cumplimiento'] = 0;
    for($mes=1; $mes <= $ultimo_rem; $mes++) {
        $data3a2019[$establecimiento->comuna]['numeradores'][$mes] = 0;
        $data3a2019[$establecimiento->comuna][$establecimiento->alias_estab]['numeradores']['total'] = 0;
        $data3a2019[$establecimiento->comuna][$establecimiento->alias_estab]['numeradores'][$mes] = 0;
    }
    $data3a2019[$establecimiento->comuna][$establecimiento->alias_estab]['denominador'] = 0;
    $data3a2019[$establecimiento->comuna][$establecimiento->alias_estab]['cumplimiento'] = 0;
}

$data3a2019['ALTO HOSPICIO']['meta'] = '89%';
$data3a2019['CAMIÑA']['meta'] = '95%';
$data3a2019['COLCHANE']['meta'] = '93%';
$data3a2019['HUARA']['meta'] = '80%';
$data3a2019['IQUIQUE']['meta'] = '81%';
$data3a2019['PICA']['meta'] = '82%';
$data3a2019['POZO ALMONTE']['meta'] = '75%';


/* ===== Query numerador ===== */
$sql_numerador = 'SELECT e.Comuna, e.alias_estab, r.Mes, sum((COALESCE(Col18,0) + COALESCE(Col19,0))) as numerador
    FROM '.$year.'rems r
    LEFT JOIN 2019establecimientos e
    ON r.IdEstablecimiento=e.Codigo
    WHERE CodigoPrestacion IN (09215313,09215413) AND e.meta_san = 1
    GROUP by e.Comuna, e.alias_estab, r.Mes
    ORDER BY e.Comuna, e.alias_estab, r.Mes';
$numeradores = DB::connection('mysql_rem')->select($sql_numerador);

foreach($numeradores as $registro) {
    if( ($flag1 != $registro->Comuna) OR ($flag2 != $registro->alias_estab) ) {
        for($mes=1; $mes <= $ultimo_rem; $mes++) {
            $data3a2019[$registro->Comuna][$registro->alias_estab]['numeradores'][$mes] = 0;
        }
        $flag1 = $registro->Comuna;
        $flag2 = $registro->alias_estab;
    }
    $data3a2019[$registro->Comuna][$registro->alias_estab]['numeradores'][$registro->Mes] = $registro->numerador;
}

/* ===== Query denominador ===== */
$sql_denominador = "SELECT e.alias_estab, e.Comuna, COUNT(*) AS denominador
                    FROM percapita_pro p
                    LEFT JOIN 2019establecimientos e ON e.Codigo = p.COD_CENTRO
                    WHERE
                    FECHA_CORTE = '2018-08-31' AND
                    EDAD = 12 AND
                    ACEPTADO_RECHAZADO = 'ACEPTADO' AND e.meta_san = 1
                    GROUP BY e.Comuna, e.alias_estab
                    ORDER BY e.Comuna, e.alias_estab";
$denominadores = DB::connection('mysql_rem')->select($sql_denominador);



foreach($denominadores as $registro) {
    $data3a2019[$registro->Comuna][$registro->alias_estab]['denominador'] = $registro->denominador;
    $data3a2019[$registro->Comuna]['denominador'] += $registro->denominador;
}

/* NO se porqué está este valor a mano, no se necesita */
// $data3a2019['ALTO HOSPICIO']['denominador'] = 1491;
// $data3a2019['ALTO HOSPICIO']['CESFAM Pedro Pulgar']['denominador'] = 1491;
// $data3a2019['ALTO HOSPICIO']['CECOSF El Boro']['denominador'] = 0;
// $data3a2019['ALTO HOSPICIO']['CECOSF La Tortuga']['denominador'] = 0;

$data3a2019['CAMIÑA']['denominador'] = 21;
$data3a2019['CAMIÑA']['CGR Camiña']['denominador'] = 0;
$data3a2019['CAMIÑA']['Posta Rural Moquella']['denominador'] = 0;

$data3a2019['COLCHANE']['denominador'] = 19;
$data3a2019['COLCHANE']['CGR Colchane']['denominador'] = 0;
$data3a2019['COLCHANE']['Posta Rural Enquelga']['denominador'] = 0;
$data3a2019['COLCHANE']['Posta Rural Cariquima']['denominador'] = 0;

$data3a2019['HUARA']['denominador'] = 31;
$data3a2019['HUARA']['CGR Dr. Amador Neghme Rodríguez']['denominador'] = 0;
$data3a2019['HUARA']['Posta Rural Pisagua']['denominador'] = 0;
$data3a2019['HUARA']['Posta Rural Tarapacá']['denominador'] = 0;
$data3a2019['HUARA']['Posta Rural Chiapa']['denominador'] = 0;
$data3a2019['HUARA']['Posta Rural Sibaya']['denominador'] = 0;

// $data3a2019['IQUIQUE']['denominador'] = 2243;
// $data3a2019['IQUIQUE']['CESFAM Cirujano Aguirre']['denominador'] = 709;
// $data3a2019['IQUIQUE']['CESFAM Cirujano Videla']['denominador'] = 596;
// $data3a2019['IQUIQUE']['CESFAM Cirujano Guzmán']['denominador'] = 432;
// $data3a2019['IQUIQUE']['CESFAM Sur Iquique']['denominador'] = 497;
// $data3a2019['IQUIQUE']['Posta Rural Chanavayita']['denominador'] = 5;
// $data3a2019['IQUIQUE']['Posta Rural San Marcos']['denominador'] = 1;
// $data3a2019['IQUIQUE']['CECOSF Cerro Esmeralda']['denominador'] = 3;

// $data3a2019['PICA']['denominador'] = 78;
// $data3a2019['PICA']['CESFAM Pica']['denominador'] = 78;
// $data3a2019['PICA']['Posta Rural Cancosa']['denominador'] = 0;
// $data3a2019['PICA']['Posta Rural Matilla']['denominador'] = 0;

// $data3a2019['POZO ALMONTE']['denominador'] = 211;
// $data3a2019['POZO ALMONTE']['CESFAM Pozo Almonte']['denominador'] = 211;
// $data3a2019['POZO ALMONTE']['Posta Rural Mamiña']['denominador'] = 0;
// $data3a2019['POZO ALMONTE']['Posta Rural La Tirana']['denominador'] = 0;
// $data3a2019['POZO ALMONTE']['Posta Rural La Huayca']['denominador'] = 0;

//echo '<pre>-'; print_r($data3a2019); die();

/* ==== Calculos ==== */
foreach($data3a2019 as $nombre_comuna => $comuna) {
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
                $data3a2019[$nombre_comuna][$nombre_establecimiento]['numeradores']['total'] = array_sum($establecimiento['numeradores']);
                //$data3a2019[$nombre_comuna][$nombre_establecimiento]['denominadores']['total'] = array_sum($establecimiento['denominadores']);
            }

            /* Calcula los totales de cada comuna */
            $data3a2019[$nombre_comuna]['numeradores']['total'] += $data3a2019[$nombre_comuna][$nombre_establecimiento]['numeradores']['total'];
            //$data3a2019[$nombre_comuna]['denominadores']['total'] += $data3a2019[$nombre_comuna][$nombre_establecimiento]['denominadores']['total'];

            /* Calcula la suma mensual por comuna */
            for($mes=1; $mes <= $ultimo_rem; $mes++) {
                $data3a2019[$nombre_comuna]['numeradores'][$mes] += $establecimiento['numeradores'][$mes];
                //$data3a2019[$nombre_comuna]['denominadores'][$mes] += $establecimiento['denominadores'][$mes];
            }

            /* Calculo de las cumplimiento de cada establecimiento */
            if($data3a2019[$nombre_comuna][$nombre_establecimiento]['denominador'] == 0) {
                /* Si es 0 el denominadore entonces la cumplimiento es 0 */
                $data3a2019[$nombre_comuna][$nombre_establecimiento]['cumplimiento'] = 0;
            }
            else {
                /* De lo contrario calcular el porcentaje */
                $data3a2019[$nombre_comuna][$nombre_establecimiento]['cumplimiento'] =
                    $data3a2019[$nombre_comuna][$nombre_establecimiento]['numeradores']['total'] / $data3a2019[$nombre_comuna][$nombre_establecimiento]['denominador'] * 100;
            }

            /* Calculo de las cumplimiento de la comuna */
            if($data3a2019[$nombre_comuna]['denominador'] == 0) {
                /* Si es 0 el denominadore entonces la cumplimiento es 0 */
                $data3a2019[$nombre_comuna]['cumplimiento'] = 0;
            }
            else {
                /* De lo contrario calcular el porcentaje */
                $data3a2019[$nombre_comuna]['cumplimiento'] = $data3a2019[$nombre_comuna]['numeradores']['total'] / $data3a2019[$nombre_comuna]['denominador'] * 100;
            }
        }
    }
}

// INDICADOR 3B
// 2019

/* Numerador = 09215313 09215413   Denominador = 01080008*/

$meses = array(1,2,3,4,5,6,7,8,9,10,11,12);
$flag1 = NULL;
$flag2 = NULL;
$data3b2019 = array();

$sql_establecimientos =
'SELECT comuna, alias_estab
 FROM 2019establecimientos
 WHERE meta_san = 1
 ORDER BY comuna;';

$establecimientos = DB::connection('mysql_rem')->select($sql_establecimientos);

/* ==== Inicializar en 0 el arreglo de datos $data3b2019 ==== */
foreach($establecimientos as $establecimiento) {
    $data3b2019[$establecimiento->comuna]['numeradores']['total'] = 0;
    $data3b2019[$establecimiento->comuna]['denominadores']['total'] = 0;
    $data3b2019[$establecimiento->comuna]['cumplimiento'] = 0;
    for($mes=1; $mes <= $ultimo_rem; $mes++) {
        $data3b2019[$establecimiento->comuna]['numeradores'][$mes] = 0;
        $data3b2019[$establecimiento->comuna]['denominadores'][$mes] = 0;
        $data3b2019[$establecimiento->comuna][$establecimiento->alias_estab]['numeradores']['total'] = 0;
        $data3b2019[$establecimiento->comuna][$establecimiento->alias_estab]['denominadores']['total'] = 0;
        $data3b2019[$establecimiento->comuna][$establecimiento->alias_estab]['numeradores'][$mes] = 0;
        $data3b2019[$establecimiento->comuna][$establecimiento->alias_estab]['denominadores'][$mes] = 0;
    }
    $data3b2019[$establecimiento->comuna][$establecimiento->alias_estab]['cumplimiento'] = 0;
}

$data3b2019['ALTO HOSPICIO']['meta'] = '72%';
$data3b2019['CAMIÑA']['meta'] = '75%';
$data3b2019['COLCHANE']['meta'] = '80%';
$data3b2019['HUARA']['meta'] = '74%';
$data3b2019['IQUIQUE']['meta'] = '59%';
$data3b2019['PICA']['meta'] = '85%';
$data3b2019['POZO ALMONTE']['meta'] = '69%';

/* ===== Query numerador =====
09215313	INGRESOS Y EGRESOS  EN ESTABLECIMIENTOS APS - TIPO DE INGRESO O EGRESO - ALTAS ODONTOLÓGICAS PREVENTIVAS
09215413	INGRESOS Y EGRESOS  EN ESTABLECIMIENTOS APS - TIPO DE INGRESO O EGRESO - ALTAS ODONTOLÓGICAS INTEGRALES (EXCLUYE SECCIÓN G)
*/
$sql_numerador = 'SELECT e.Comuna, e.alias_estab, r.Mes, sum((ifnull(Col28,0))) as numerador
    FROM '.$year.'rems r
    LEFT JOIN 2019establecimientos e
    ON r.IdEstablecimiento=e.Codigo
    WHERE CodigoPrestacion IN (09215313,09215413) AND e.meta_san = 1
    GROUP BY e.Comuna, e.alias_estab, r.Mes
    ORDER BY e.Comuna, e.alias_estab, r.Mes';
$numeradores = DB::connection('mysql_rem')->select($sql_numerador);

foreach($numeradores as $registro) {
    if( ($flag1 != $registro->Comuna) OR ($flag2 != $registro->alias_estab) ) {
        for($mes=1; $mes <= $ultimo_rem; $mes++) {
            $data3b2019[$registro->Comuna][$registro->alias_estab]['numeradores'][$mes] = 0;
        }
        $flag1 = $registro->Comuna;
        $flag2 = $registro->alias_estab;
    }
    $data3b2019[$registro->Comuna][$registro->alias_estab]['numeradores'][$registro->Mes] = $registro->numerador;
}

/* ===== Query denominador =====
01080008	INGRESOS DE GESTANTES A PROGRAMA PRENATAL - CONDICIÓN - GESTANTES INGRESADAS
*/
$sql_denominador = 'SELECT e.Comuna, e.alias_estab, r.Mes, (ifnull(Col01,0)) as denominador
    FROM '.$year.'rems r
    LEFT JOIN 2019establecimientos e
    ON r.IdEstablecimiento=e.Codigo
    WHERE CodigoPrestacion = 01080008 AND e.meta_san = 1
    ORDER BY e.Comuna, e.alias_estab, r.Mes';
$denominadores = DB::connection('mysql_rem')->select($sql_denominador);

foreach($denominadores as $registro) {
    if( ($flag1 != $registro->Comuna) OR ($flag2 != $registro->alias_estab) ) {
        for($mes=1; $mes <= $ultimo_rem; $mes++) {
            $data3b2019[$registro->Comuna][$registro->alias_estab]['denominadores'][$mes] = 0;
        }
        $flag1 = $registro->Comuna;
        $flag2 = $registro->alias_estab;
    }
    $data3b2019[$registro->Comuna][$registro->alias_estab]['denominadores'][$registro->Mes] = $registro->denominador;
}

/* ==== Calculos ==== */
foreach($data3b2019 as $nombre_comuna => $comuna) {
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
            $data3b2019[$nombre_comuna][$nombre_establecimiento]['denominadores']['total'] = array_sum($establecimiento['denominadores']);
            $data3b2019[$nombre_comuna][$nombre_establecimiento]['numeradores']['total'] = array_sum($establecimiento['numeradores']);

            /* Calcula los totales de cada comuna */
            $data3b2019[$nombre_comuna]['numeradores']['total'] += $data3b2019[$nombre_comuna][$nombre_establecimiento]['numeradores']['total'];
            $data3b2019[$nombre_comuna]['denominadores']['total'] += $data3b2019[$nombre_comuna][$nombre_establecimiento]['denominadores']['total'];

            /* Calcula la suma mensual por comuna */
            for($mes=1; $mes <= $ultimo_rem; $mes++) {
                $data3b2019[$nombre_comuna]['numeradores'][$mes] += $establecimiento['numeradores'][$mes];
                $data3b2019[$nombre_comuna]['denominadores'][$mes] += $establecimiento['denominadores'][$mes];
            }

            /* Calculo de las cumplimiento de cada establecimiento */
            if($data3b2019[$nombre_comuna][$nombre_establecimiento]['denominadores']['total'] == 0) {
                /* Si es 0 el denominadore entonces la cumplimiento es 0 */
                $data3b2019[$nombre_comuna][$nombre_establecimiento]['cumplimiento'] = 0;
            }
            else {
                /* De lo contrario calcular el porcentaje */
                $data3b2019[$nombre_comuna][$nombre_establecimiento]['cumplimiento'] = $data3b2019[$nombre_comuna][$nombre_establecimiento]['numeradores']['total'] / $data3b2019[$nombre_comuna][$nombre_establecimiento]['denominadores']['total'] * 100;
            }

            /* Calculo de las cumplimiento de la comuna */
            if($data3b2019[$nombre_comuna]['denominadores']['total'] == 0) {
                /* Si es 0 el denominadore entonces la cumplimiento es 0 */
                $data3b2019[$nombre_comuna]['cumplimiento'] = 0;
            }
            else {
                /* De lo contrario calcular el porcentaje */
                $data3b2019[$nombre_comuna]['cumplimiento'] = $data3b2019[$nombre_comuna]['numeradores']['total'] / $data3b2019[$nombre_comuna]['denominadores']['total'] * 100;
            }
        }
    }
}

//INDICADOR 3C
//2019

/* Numerador = 09215015   Denominador =    */

$flag1 = NULL;
$flag2 = NULL;
$data3c2019 = array();

$sql_establecimientos = "SELECT comuna, alias_estab
                         FROM 2019establecimientos
                         WHERE meta_san = 1
                         ORDER BY comuna";

$establecimientos = DB::connection('mysql_rem')->select($sql_establecimientos);

/* ==== Inicializar en 0 el arreglo de datos $data3c2019 ==== */
foreach($establecimientos as $establecimiento) {
    $data3c2019[$establecimiento->comuna]['numeradores']['total'] = 0;
    $data3c2019[$establecimiento->comuna]['denominador'] = 0;
    $data3c2019[$establecimiento->comuna]['cumplimiento'] = 0;
    for($mes=1; $mes <= $ultimo_rem; $mes++) {
        $data3c2019[$establecimiento->comuna]['numeradores'][$mes] = 0;
        $data3c2019[$establecimiento->comuna][$establecimiento->alias_estab]['numeradores']['total'] = 0;
        $data3c2019[$establecimiento->comuna][$establecimiento->alias_estab]['numeradores'][$mes] = 0;
    }
    $data3c2019[$establecimiento->comuna][$establecimiento->alias_estab]['denominador'] = 0;
    $data3c2019[$establecimiento->comuna][$establecimiento->alias_estab]['cumplimiento'] = 0;
}


$data3c2019['ALTO HOSPICIO']['meta'] = '74%';
$data3c2019['CAMIÑA']['meta'] = '100%';
$data3c2019['COLCHANE']['meta'] = '100%';
$data3c2019['HUARA']['meta'] = '100%';
$data3c2019['IQUIQUE']['meta'] = '83%';
$data3c2019['PICA']['meta'] = '85%';
$data3c2019['POZO ALMONTE']['meta'] = '80%';


/* ===== Query numerador ===== */
$sql_numerador = 'SELECT e.Comuna, e.alias_estab, r.Mes, sum((ifnull(Col16,0) + ifnull(Col17,0))) as numerador
    FROM '.$year.'rems r
    LEFT JOIN 2019establecimientos e
    ON r.IdEstablecimiento=e.Codigo
    WHERE CodigoPrestacion IN (09215015) AND e.meta_san = 1
    GROUP by e.Comuna, e.alias_estab, r.Mes
    ORDER BY e.Comuna, e.alias_estab, r.Mes';
$numeradores = DB::connection('mysql_rem')->select($sql_numerador);

foreach($numeradores as $registro) {
    if( ($flag1 != $registro->Comuna) OR ($flag2 != $registro->alias_estab) ) {
        for($mes=1; $mes <= $ultimo_rem; $mes++) {
            $data3c2019[$registro->Comuna][$registro->alias_estab]['numeradores'][$mes] = 0;
        }
        $flag1 = $registro->Comuna;
        $flag2 = $registro->alias_estab;
    }
    $data3c2019[$registro->Comuna][$registro->alias_estab]['numeradores'][$registro->Mes] = $registro->numerador;
}

/* ===== Query denominador ===== */
$sql_denominador = "SELECT e.alias_estab, e.Comuna, COUNT(*) AS denominador
                    FROM percapita_pro p
                    LEFT JOIN 2019establecimientos e ON e.Codigo = p.COD_CENTRO
                    WHERE
                    FECHA_CORTE = '2018-08-31' AND
                    EDAD = 6 AND
                    ACEPTADO_RECHAZADO = 'ACEPTADO' AND e.meta_san = 1
                    GROUP BY e.Comuna, e.alias_estab
                    ORDER BY e.Comuna, e.alias_estab";
$denominadores = DB::connection('mysql_rem')->select($sql_denominador);



foreach($denominadores as $registro) {
    $data3c2019[$registro->Comuna][$registro->alias_estab]['denominador'] = $registro->denominador;
    $data3c2019[$registro->Comuna]['denominador'] += $registro->denominador;
}

// $data3c2019['ALTO HOSPICIO']['denominador'] = 1641;
// $data3c2019['ALTO HOSPICIO']['CESFAM Pedro Pulgar']['denominador'] = 1641;
// $data3c2019['ALTO HOSPICIO']['CECOSF El Boro']['denominador'] = 0;
// $data3c2019['ALTO HOSPICIO']['CECOSF La Tortuga']['denominador'] = 0;

$data3c2019['CAMIÑA']['denominador'] = 28;
$data3c2019['CAMIÑA']['CGR Camiña']['denominador'] = 0;
$data3c2019['CAMIÑA']['Posta Rural Moquella']['denominador'] = 0;

$data3c2019['COLCHANE']['denominador'] = 6;
$data3c2019['COLCHANE']['CGR Colchane']['denominador'] = 0;
$data3c2019['COLCHANE']['Posta Rural Enquelga']['denominador'] = 0;
$data3c2019['COLCHANE']['Posta Rural Cariquima']['denominador'] = 0;

$data3c2019['HUARA']['denominador'] = 77;
$data3c2019['HUARA']['CGR Dr. Amador Neghme Rodríguez']['denominador'] = 0;
$data3c2019['HUARA']['Posta Rural Pisagua']['denominador'] = 0;
$data3c2019['HUARA']['Posta Rural Tarapacá']['denominador'] = 0;
$data3c2019['HUARA']['Posta Rural Chiapa']['denominador'] = 0;
$data3c2019['HUARA']['Posta Rural Sibaya']['denominador'] = 0;

// $data3c2019['IQUIQUE']['denominador'] = 2622;
// $data3c2019['IQUIQUE']['CESFAM Cirujano Aguirre']['denominador'] = 780;
// $data3c2019['IQUIQUE']['CESFAM Cirujano Videla']['denominador'] = 702;
// $data3c2019['IQUIQUE']['CESFAM Cirujano Guzmán']['denominador'] = 519;
// $data3c2019['IQUIQUE']['CESFAM Sur Iquique']['denominador'] = 610;
// $data3c2019['IQUIQUE']['Posta Rural Chanavayita']['denominador'] = 1;
// $data3c2019['IQUIQUE']['Posta Rural San Marcos']['denominador'] = 1;
// $data3c2019['IQUIQUE']['CECOSF Cerro Esmeralda']['denominador'] = 9;

// $data3c2019['PICA']['denominador'] = 99;
// $data3c2019['PICA']['CESFAM Pica']['denominador'] = 99;
// $data3c2019['PICA']['Posta Rural Cancosa']['denominador'] = 0;
// $data3c2019['PICA']['Posta Rural Matilla']['denominador'] = 0;

// $data3c2019['POZO ALMONTE']['denominador'] = 258;
// $data3c2019['POZO ALMONTE']['CESFAM Pozo Almonte']['denominador'] = 258;
// $data3c2019['POZO ALMONTE']['Posta Rural Mamiña']['denominador'] = 0;
// $data3c2019['POZO ALMONTE']['Posta Rural La Tirana']['denominador'] = 0;
// $data3c2019['POZO ALMONTE']['Posta Rural La Huayca']['denominador'] = 0;

/* ==== Calculos ==== */
foreach($data3c2019 as $nombre_comuna => $comuna) {
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
                $data3c2019[$nombre_comuna][$nombre_establecimiento]['numeradores']['total'] = array_sum($establecimiento['numeradores']);
                //$data3c2019[$nombre_comuna][$nombre_establecimiento]['denominadores']['total'] = array_sum($establecimiento['denominadores']);
            }

            /* Calcula los totales de cada comuna */
            $data3c2019[$nombre_comuna]['numeradores']['total'] += $data3c2019[$nombre_comuna][$nombre_establecimiento]['numeradores']['total'];
            //$data3c2019[$nombre_comuna]['denominadores']['total'] += $data3c2019[$nombre_comuna][$nombre_establecimiento]['denominadores']['total'];

            /* Calcula la suma mensual por comuna */
            for($mes=1; $mes <= $ultimo_rem; $mes++) {
                $data3c2019[$nombre_comuna]['numeradores'][$mes] += $establecimiento['numeradores'][$mes];
                //$data3c2019[$nombre_comuna]['denominadores'][$mes] += $establecimiento['denominadores'][$mes];
            }

            /* Calculo de las metas de cada establecimiento */
            if($data3c2019[$nombre_comuna][$nombre_establecimiento]['denominador'] == 0) {
                /* Si es 0 el denominadore entonces la cumplimiento es 0 */
                $data3c2019[$nombre_comuna][$nombre_establecimiento]['cumplimiento'] = 0;
            }
            else {
                /* De lo contrario calcular el porcentaje */
                $data3c2019[$nombre_comuna][$nombre_establecimiento]['cumplimiento'] =
                    $data3c2019[$nombre_comuna][$nombre_establecimiento]['numeradores']['total'] / $data3c2019[$nombre_comuna][$nombre_establecimiento]['denominador'] * 100;
            }

            /* Calculo de las metas de la comuna */
            if($data3c2019[$nombre_comuna]['denominador'] == 0) {
                /* Si es 0 el denominadore entonces la cumplimiento es 0 */
                $data3c2019[$nombre_comuna]['cumplimiento'] = 0;
            }
            else {
                /* De lo contrario calcular el porcentaje */
                $data3c2019[$nombre_comuna]['cumplimiento'] = $data3c2019[$nombre_comuna]['numeradores']['total'] / $data3c2019[$nombre_comuna]['denominador'] * 100;
            }
        }
    }
}

//INDICADOR 4A
//2019

$data4a2019 = array();

$sql_establecimientos = "SELECT Codigo AS codigo, alias_estab AS nombre, comuna
                         FROM 2019establecimientos
                         WHERE meta_san = 1
                         ORDER BY comuna;";

$establecimientos = DB::connection('mysql_rem')->select($sql_establecimientos);

$data4a2019['ALTO HOSPICIO']['meta'] = '16%';
$data4a2019['CAMIÑA']['meta'] = '20%';
$data4a2019['COLCHANE']['meta'] = '15%';
$data4a2019['HUARA']['meta'] = '20%';
$data4a2019['IQUIQUE']['meta'] = '30%';
$data4a2019['PICA']['meta'] = '30%';
$data4a2019['POZO ALMONTE']['meta'] = '24%';

/* ==== Inicializar en 0 el arreglo de datos $data4a2019 ==== */
foreach($establecimientos as $establecimiento) {
    $data4a2019[$establecimiento->comuna]['numerador'] = 0;
    $data4a2019[$establecimiento->comuna]['establecimientos'][$establecimiento->nombre]['numerador'] = 0;

    $data4a2019[$establecimiento->comuna]['numerador_6'] = 0;
    $data4a2019[$establecimiento->comuna]['establecimientos'][$establecimiento->nombre]['numerador_6'] = 0;

    $data4a2019[$establecimiento->comuna]['numerador_12'] = 0;
    $data4a2019[$establecimiento->comuna]['establecimientos'][$establecimiento->nombre]['numerador_12'] = 0;

    $data4a2019[$establecimiento->comuna]['denominador'] = 0;
    $data4a2019[$establecimiento->comuna]['establecimientos'][$establecimiento->nombre]['denominador'] = 0;

    $data4a2019[$establecimiento->comuna]['cumplimiento'] = 0;
    $data4a2019[$establecimiento->comuna]['establecimientos'][$establecimiento->nombre]['cumplimiento'] = 0;

    $data4a2019[$establecimiento->comuna]['establecimientos'][$establecimiento->nombre]['meta'] = $data4a2019[$establecimiento->comuna]['meta'];
}

/* Sólo si está cargado sobre el rem de Junio */
if($ultimo_rem >= 6) {
    /* ===== Query numerador ===== */
    $sql_numerador =
    "SELECT e.Comuna as comuna, e.alias_estab as nombre, r.Mes as mes, sum(ifnull(Col01,0)) as numerador
        FROM {$year}rems r
        LEFT JOIN 2019establecimientos e ON r.IdEstablecimiento=e.Codigo
        WHERE
        e.meta_san = 1 AND Ano = 2019 AND (Mes = 6 OR Mes = 12) AND
        CodigoPrestacion IN ('P4180300','P4200200')
        GROUP by e.Comuna, e.alias_estab, r.Mes
        ORDER BY e.Comuna, e.alias_estab, r.Mes";

    $numeradores = DB::connection('mysql_rem')->select($sql_numerador);

    foreach($numeradores as $registro) {
        if($registro->mes == 6) {
            $data4a2019[$registro->comuna]['numerador_6'] += $registro->numerador;
            $data4a2019[$registro->comuna]['establecimientos'][$registro->nombre]['numerador_6'] = $registro->numerador;
        }
        if($registro->mes == 12){
            $data4a2019[$registro->comuna]['numerador_12'] += $registro->numerador;
            $data4a2019[$registro->comuna]['establecimientos'][$registro->nombre]['numerador_12'] = $registro->numerador;
        }

        if($ultimo_rem < 12) {
            $data4a2019[$registro->comuna]['numerador'] = $data4a2019[$registro->comuna]['numerador_6'];
            $data4a2019[$registro->comuna]['establecimientos'][$registro->nombre]['numerador'] =
                $data4a2019[$registro->comuna]['establecimientos'][$registro->nombre]['numerador_6'];
        }
        else {
            $data4a2019[$registro->comuna]['numerador'] = $data4a2019[$registro->comuna]['numerador_12'];
            $data4a2019[$registro->comuna]['establecimientos'][$registro->nombre]['numerador'] =
                $data4a2019[$registro->comuna]['establecimientos'][$registro->nombre]['numerador_12'];
        }
    }

    /* ===== Query denominador ===== */
    $sql_denominador = "SELECT alias_estab as nombre, Comuna as comuna, SUM(denominador) as denominador
                    FROM
                    (
                      (SELECT e.alias_estab, e.Comuna, COUNT(*)*0.1 AS denominador
                        FROM percapita_pro p
                        LEFT JOIN 2019establecimientos e ON e.Codigo = p.COD_CENTRO
                        WHERE
                            e.meta_san = 1 AND
                        FECHA_CORTE = '2018-08-31' AND
                        EDAD BETWEEN 15 AND 64 AND
                        ACEPTADO_RECHAZADO = 'ACEPTADO'
                        GROUP BY e.Comuna, e.alias_estab
                        ORDER BY e.Comuna, e.alias_estab)

                      UNION

                      (SELECT e.alias_estab, e.Comuna, COUNT(*)*0.25 AS denominador
                        FROM percapita_pro p
                        LEFT JOIN 2019establecimientos e ON e.Codigo = p.COD_CENTRO
                        WHERE
                            e.meta_san = 1 AND
                        FECHA_CORTE = '2018-08-31' AND
                        EDAD >= 65 AND
                        ACEPTADO_RECHAZADO = 'ACEPTADO'
                        GROUP BY e.Comuna, e.alias_estab
                        ORDER BY e.Comuna, e.alias_estab)
                    ) tmp
                    group by tmp.Comuna, tmp.alias_estab
                    order by tmp.Comuna, tmp.alias_estab";

    $denominadores = DB::connection('mysql_rem')->select($sql_denominador);

    foreach($denominadores as $registro) {
        $data4a2019[$registro->comuna]['denominador'] += $registro->denominador;
        $data4a2019[$registro->comuna]['establecimientos'][$registro->nombre]['denominador'] = $registro->denominador;
    }

    /* Poblaciones manuales (denominadores) */
    $data4a2019['CAMIÑA']['denominador'] = 140;
    $data4a2019['CAMIÑA']['establecimientos']['CGR Camiña']['denominador'] = 0;
    $data4a2019['CAMIÑA']['establecimientos']['Posta Rural Moquella']['denominador'] = 0;

    $data4a2019['COLCHANE']['denominador'] = 101;
    $data4a2019['COLCHANE']['establecimientos']['CGR Colchane']['denominador'] = 0;
    $data4a2019['COLCHANE']['establecimientos']['Posta Rural Enquelga']['denominador'] = 0;
    $data4a2019['COLCHANE']['establecimientos']['Posta Rural Cariquima']['denominador'] = 0;

    $data4a2019['HUARA']['denominador'] = 231;
    $data4a2019['HUARA']['establecimientos']['CGR Dr. Amador Neghme Rodríguez']['denominador'] = 0;
    $data4a2019['HUARA']['establecimientos']['Posta Rural Pisagua']['denominador'] = 0;
    $data4a2019['HUARA']['establecimientos']['Posta Rural Tarapacá']['denominador'] = 0;
    $data4a2019['HUARA']['establecimientos']['Posta Rural Chiapa']['denominador'] = 0;
    $data4a2019['HUARA']['establecimientos']['Posta Rural Sibaya']['denominador'] = 0;

    /* ==== Calculos ==== */
    foreach($data4a2019 as $nombre_comuna => $comuna) {
        /* Calculo de las metas de la comuna */
        if($data4a2019[$nombre_comuna]['denominador'] == 0) {
            /* Si es 0 el denominadore entonces la meta es 0 */
            $data4a2019[$nombre_comuna]['cumplimiento'] = 0;
        }
        else {
            $data4a2019[$nombre_comuna]['cumplimiento'] = $data4a2019[$nombre_comuna]['numerador'] /
                $data4a2019[$nombre_comuna]['denominador'] * 100;
        }
        /* Formateo de tipo de número después de hacer calculos*/
        $data4a2019[$nombre_comuna]['numerador'] = $data4a2019[$nombre_comuna]['numerador'];
        $data4a2019[$nombre_comuna]['numerador_6'] = $data4a2019[$nombre_comuna]['numerador_6'];
        $data4a2019[$nombre_comuna]['numerador_12'] = $data4a2019[$nombre_comuna]['numerador_12'];
        $data4a2019[$nombre_comuna]['denominador'] = $data4a2019[$nombre_comuna]['denominador'];

        foreach($comuna['establecimientos'] as $nombre_establecimiento => $establecimiento) {
            /* Calculo de cumplimiento de cada establecimiento */
            if($establecimiento['denominador'] == 0) {
                /* Si es 0 el denominador entonces la meta es 0 */
                $data4a2019[$nombre_comuna]['establecimientos'][$nombre_establecimiento]['cumplimiento'] = 0;
            }
            else {
                $data4a2019[$nombre_comuna]['establecimientos'][$nombre_establecimiento]['cumplimiento'] =
                    $data4a2019[$nombre_comuna]['establecimientos'][$nombre_establecimiento]['numerador'] /
                    $data4a2019[$nombre_comuna]['establecimientos'][$nombre_establecimiento]['denominador'] * 100;
            }

            /* Formateo de tipo de número después de hacer calculos*/
            $data4a2019[$nombre_comuna]['establecimientos'][$nombre_establecimiento]['numerador'] =
                $data4a2019[$nombre_comuna]['establecimientos'][$nombre_establecimiento]['numerador'];
            $data4a2019[$nombre_comuna]['establecimientos'][$nombre_establecimiento]['numerador_6'] =
                $data4a2019[$nombre_comuna]['establecimientos'][$nombre_establecimiento]['numerador_6'];
            $data4a2019[$nombre_comuna]['establecimientos'][$nombre_establecimiento]['numerador_12'] =
                $data4a2019[$nombre_comuna]['establecimientos'][$nombre_establecimiento]['numerador_12'];
            $data4a2019[$nombre_comuna]['establecimientos'][$nombre_establecimiento]['denominador'] =
                $data4a2019[$nombre_comuna]['establecimientos'][$nombre_establecimiento]['denominador'];

        }
    }
}

//INDICADOR 4B
//2019

$data4b2019 = array();

$sql_establecimientos = "SELECT comuna, alias_estab
                         FROM 2019establecimientos
                         WHERE meta_san = 1
                         ORDER BY comuna;";

$establecimientos = DB::connection('mysql_rem')->select($sql_establecimientos);

/* ==== Inicializar en 0 el arreglo de datos $data4b2019 ==== */
foreach($establecimientos as $establecimiento) {
    /*$data4b2019[$establecimiento->comuna]['numerador'] = 0;
    $data4b2019[$establecimiento->comuna]['denominador'] = 0;
    $data4b2019[$establecimiento->comuna]['meta'] = 0;
    $data4b2019[$establecimiento->comuna]['cumplimiento'] = 0;
    $data4b2019[$establecimiento->comuna][$establecimiento->alias_estab]['numerador'] = 0;
    $data4b2019[$establecimiento->comuna][$establecimiento->alias_estab]['denominador'] = 0;
    $data4b2019[$establecimiento->comuna][$establecimiento->alias_estab]['meta'] = 0;
    $data4b2019[$establecimiento->comuna][$establecimiento->alias_estab]['cumplimiento'] = 0;*/

    $data4b2019[$establecimiento->comuna]['numerador'] = 0;
    $data4b2019[$establecimiento->comuna]['numerador_6'] = 0;
    $data4b2019[$establecimiento->comuna]['numerador_12'] = 0;
    $data4b2019[$establecimiento->comuna]['denominador'] = 0;
    $data4b2019[$establecimiento->comuna]['denominador_6'] = 0;
    $data4b2019[$establecimiento->comuna]['denominador_12'] = 0;
    $data4b2019[$establecimiento->comuna]['meta'] = 0;
    $data4b2019[$establecimiento->comuna]['cumplimiento'] = 0;
    $data4b2019[$establecimiento->comuna][$establecimiento->alias_estab]['numerador'] = 0;
    $data4b2019[$establecimiento->comuna][$establecimiento->alias_estab]['numerador_6'] = 0;
    $data4b2019[$establecimiento->comuna][$establecimiento->alias_estab]['numerador_12'] = 0;
    $data4b2019[$establecimiento->comuna][$establecimiento->alias_estab]['denominador'] = 0;
    $data4b2019[$establecimiento->comuna][$establecimiento->alias_estab]['denominador_6'] = 0;
    $data4b2019[$establecimiento->comuna][$establecimiento->alias_estab]['denominador_12'] = 0;
    $data4b2019[$establecimiento->comuna][$establecimiento->alias_estab]['meta'] = 0;
    $data4b2019[$establecimiento->comuna][$establecimiento->alias_estab]['cumplimiento'] = 0;
}

$data4b2019['ALTO HOSPICIO']['meta'] = '90%';
$data4b2019['CAMIÑA']['meta'] = '90%';
$data4b2019['COLCHANE']['meta'] = '94%';
$data4b2019['HUARA']['meta'] = '90%';
$data4b2019['IQUIQUE']['meta'] = '91%';
$data4b2019['PICA']['meta'] = '90%';
$data4b2019['POZO ALMONTE']['meta'] = '90%';

/* ===== Query numerador ===== */
$sql_numerador =
"SELECT e.Comuna, e.alias_estab, r.Mes, sum(ifnull(Col01,0)) as numerador
    FROM ".$year."rems r
    LEFT JOIN 2019establecimientos e ON r.IdEstablecimiento=e.Codigo
    WHERE
    e.meta_san = 1 AND Ano = 2019 AND (Mes = 6 OR Mes = 12) AND
    CodigoPrestacion IN ('P4190809','P4170300','P4190500','P4190600')
    GROUP by e.Comuna, e.alias_estab, r.Mes
    ORDER BY e.Comuna, e.alias_estab, r.Mes";

$numeradores = DB::connection('mysql_rem')->select($sql_numerador);

foreach($numeradores as $registro) {
    /*$data4b2019[$registro->Comuna]['numerador'] += $registro->numerador;
    $data4b2019[$registro->Comuna][$registro->alias_estab]['numerador'] = $registro->numerador;*/

    if($registro->Mes == 6) {
        $data4b2019[$registro->Comuna]['numerador_6'] += $registro->numerador;
        $data4b2019[$registro->Comuna][$registro->alias_estab]['numerador_6'] = $registro->numerador;
    }
    if($registro->Mes == 12){
        $data4b2019[$registro->Comuna]['numerador_12'] += $registro->numerador;
        $data4b2019[$registro->Comuna][$registro->alias_estab]['numerador_12'] = $registro->numerador;
    }
}

/* ===== Query denominador ===== */
$sql_denominador =
"SELECT e.Comuna, e.alias_estab, r.Mes, sum(ifnull(Col01,0)) as denominador
    FROM ".$year."rems r
    LEFT JOIN 2019establecimientos e ON r.IdEstablecimiento=e.Codigo
    WHERE
    e.meta_san = 1 AND Ano = 2019 AND (Mes = 6 OR Mes = 12) AND
    CodigoPrestacion IN ('P4150602')
    GROUP by e.Comuna, e.alias_estab, r.Mes
    ORDER BY e.Comuna, e.alias_estab, r.Mes";

$denomidores = DB::connection('mysql_rem')->select($sql_denominador);

foreach($denomidores as $registro) {
    /*$data4b2019[$registro->Comuna]['denominador'] += $registro->denominador;
    $data4b2019[$registro->Comuna][$registro->alias_estab]['denominador'] = $registro->denominador;*/

    if($registro->Mes == 6) {
        $data4b2019[$registro->Comuna]['denominador_6'] += $registro->denominador;
        $data4b2019[$registro->Comuna][$registro->alias_estab]['denominador_6'] = $registro->denominador;
    }
    if($registro->Mes == 12){
        $data4b2019[$registro->Comuna]['denominador_12'] += $registro->denominador;
        $data4b2019[$registro->Comuna][$registro->alias_estab]['denominador_12'] = $registro->denominador;
    }
}


/* ==== Calculos ==== */
foreach($data4b2019 as $nombre_comuna => $comuna) {
    foreach($comuna as $nombre_establecimiento => $establecimiento) {
        /* Existe en el array un indice ['numerador'], ['denominador'] y ['meta'],
         * estos almacenan la información de la comuna, por lo tanto tengo que saltarlos
         * en la iteración del foreach y continuar con los establecimientos */
        /* Realizar los calculos mensuales */
        if($nombre_establecimiento != 'numerador' AND
            $nombre_establecimiento != 'numerador_6' AND
            $nombre_establecimiento != 'numerador_12' AND
            $nombre_establecimiento != 'denominador' AND
            $nombre_establecimiento != 'denominador_6' AND
            $nombre_establecimiento != 'denominador_12' AND
            $nombre_establecimiento != 'meta' AND
            $nombre_establecimiento != 'cumplimiento'){

            /* Calculo de las metas de cada establecimiento */
            switch($ultimo_rem) {
                case 1:
                case 2:
                case 3:
                case 4:
                case 5:
                    $data4b2019[$nombre_comuna]['cumplimiento'] = 0;
                    break;
                case 6:
                case 7:
                case 8:
                case 9:
                case 10:
                case 11:
                    $data4b2019[$nombre_comuna][$nombre_establecimiento]['numerador'] =
                        $data4b2019[$nombre_comuna][$nombre_establecimiento]['numerador_6'];
                    $data4b2019[$nombre_comuna][$nombre_establecimiento]['denominador'] =
                        $data4b2019[$nombre_comuna][$nombre_establecimiento]['denominador_6'];
                    break;
                case 12:
                    $data4b2019[$nombre_comuna][$nombre_establecimiento]['numerador'] =
                        $data4b2019[$nombre_comuna][$nombre_establecimiento]['numerador_12'];
                    $data4b2019[$nombre_comuna][$nombre_establecimiento]['denominador'] =
                        $data4b2019[$nombre_comuna][$nombre_establecimiento]['denominador_12'];
                    break;
            }
            if($data4b2019[$nombre_comuna][$nombre_establecimiento]['denominador'] == 0) {
                /* Si es 0 el denominadore entonces la meta es 0 */
                $data4b2019[$nombre_comuna][$nombre_establecimiento]['cumplimiento'] = 0;
            }
            else {
                /* De lo contrario calcular el porcentaje */
                $data4b2019[$nombre_comuna][$nombre_establecimiento]['cumplimiento'] =
                    $data4b2019[$nombre_comuna][$nombre_establecimiento]['numerador'] /
                    $data4b2019[$nombre_comuna][$nombre_establecimiento]['denominador'] * 100;
            }

            /* Fija la meta de la comuna también a sus establecimientos */
            $data4b2019[$nombre_comuna][$nombre_establecimiento]['meta'] = $data4b2019[$nombre_comuna]['meta'];


            switch($ultimo_rem) {
                case 1:
                case 2:
                case 3:
                case 4:
                case 5:
                    $data4b2019[$nombre_comuna]['cumplimiento'] = 0;
                    break;
                case 6:
                case 7:
                case 8:
                case 9:
                case 10:
                case 11:
                    $data4b2019[$nombre_comuna]['numerador'] =
                        $data4b2019[$nombre_comuna]['numerador_6'];
                    $data4b2019[$nombre_comuna]['denominador'] =
                        $data4b2019[$nombre_comuna]['denominador_6'];
                    break;
                case 12:
                    $data4b2019[$nombre_comuna]['numerador'] =
                        $data4b2019[$nombre_comuna]['numerador_12'];
                    $data4b2019[$nombre_comuna]['denominador'] =
                        $data4b2019[$nombre_comuna]['denominador_12'];
                    break;
            }
            /* Calculo de las metas de la comuna */
            if($data4b2019[$nombre_comuna]['denominador'] == 0) {
                /* Si es 0 el denominadore entonces la meta es 0 */
                $data4b2019[$nombre_comuna]['cumplimiento'] = 0;
            }
            else {
                /* De lo contrario calcular el porcentaje */
                $data4b2019[$nombre_comuna]['cumplimiento'] = $data4b2019[$nombre_comuna]['numerador'] / $data4b2019[$nombre_comuna]['denominador'] * 100;
            }
        }
    }
}

//INDICADOR 5
//2019

$data52019 = array();

$sql_establecimientos = "SELECT comuna, alias_estab
                         FROM 2019establecimientos
                         WHERE meta_san = 1
                         ORDER BY comuna;";

$establecimientos = DB::connection('mysql_rem')->select($sql_establecimientos);

/* ==== Inicializar en 0 el arreglo de datos $data52019 ==== */
foreach($establecimientos as $establecimiento) {
    $data52019[$establecimiento->comuna]['numerador'] = 0;
    $data52019[$establecimiento->comuna]['numerador_6'] = 0;
    $data52019[$establecimiento->comuna]['numerador_12'] = 0;
    $data52019[$establecimiento->comuna]['denominador'] = 0;
    $data52019[$establecimiento->comuna]['meta'] = 0;
    $data52019[$establecimiento->comuna]['cumplimiento'] = 0;
    $data52019[$establecimiento->comuna][$establecimiento->alias_estab]['numerador'] = 0;
    $data52019[$establecimiento->comuna][$establecimiento->alias_estab]['numerador_6'] = 0;
    $data52019[$establecimiento->comuna][$establecimiento->alias_estab]['numerador_12'] = 0;
    $data52019[$establecimiento->comuna][$establecimiento->alias_estab]['denominador'] = 0;
    $data52019[$establecimiento->comuna][$establecimiento->alias_estab]['meta'] = 0;
    $data52019[$establecimiento->comuna][$establecimiento->alias_estab]['cumplimiento'] = 0;
}

$data52019['ALTO HOSPICIO']['meta'] = '23%';
$data52019['CAMIÑA']['meta'] = '27%';
$data52019['COLCHANE']['meta'] = '13%';
$data52019['HUARA']['meta'] = '30%';
$data52019['IQUIQUE']['meta'] = '50%';
$data52019['PICA']['meta'] = '47%';
$data52019['POZO ALMONTE']['meta'] = '34%';

/* ===== Query numerador ===== */
$sql_numerador =
"SELECT e.Comuna, e.alias_estab, r.Mes, sum(ifnull(Col01,0)) as numerador
    FROM ".$year."rems r
    LEFT JOIN 2019establecimientos e ON r.IdEstablecimiento=e.Codigo
    WHERE
    e.meta_san = 1 AND Ano = 2019 AND (Mes = 6 OR Mes = 12) AND
    CodigoPrestacion IN ('P4180200','P4200100')
    GROUP by e.Comuna, e.alias_estab, r.Mes
    ORDER BY e.Comuna, e.alias_estab, r.Mes";

$numeradores = DB::connection('mysql_rem')->select($sql_numerador);

foreach($numeradores as $registro) {
    /*$data52019[$registro->Comuna]['numerador'] += $registro->numerador;
    $data52019[$registro->Comuna][$registro->alias_estab]['numerador'] = $registro->numerador;*/

    if($registro->Mes == 6) {
        $data52019[$registro->Comuna]['numerador_6'] += $registro->numerador;
        $data52019[$registro->Comuna][$registro->alias_estab]['numerador_6'] = $registro->numerador;
    }
    if($registro->Mes == 12){
        $data52019[$registro->Comuna]['numerador_12'] += $registro->numerador;
        $data52019[$registro->Comuna][$registro->alias_estab]['numerador_12'] = $registro->numerador;
    }
}

/* ===== Query denominador ===== */
$sql_denominador = "SELECT alias_estab, Comuna, SUM(denominador) as denominador
                    FROM
                    (
                      (SELECT e.alias_estab, e.Comuna, COUNT(*)*0.157 AS denominador
                        FROM percapita_pro p
                        LEFT JOIN 2019establecimientos e ON e.Codigo = p.COD_CENTRO
                        WHERE
                        FECHA_CORTE = '2018-08-31' AND
                        EDAD BETWEEN 15 AND 64 AND
                        ACEPTADO_RECHAZADO = 'ACEPTADO' AND e.meta_san = 1
                        GROUP BY e.Comuna, e.alias_estab
                        ORDER BY e.Comuna, e.alias_estab)

                      UNION

                      (SELECT e.alias_estab, e.Comuna, COUNT(*)*0.643 AS denominador
                        FROM percapita_pro p
                        LEFT JOIN 2019establecimientos e ON e.Codigo = p.COD_CENTRO
                        WHERE
                        FECHA_CORTE = '2018-08-31' AND
                        EDAD >= 65 AND
                        ACEPTADO_RECHAZADO = 'ACEPTADO' AND e.meta_san = 1
                        GROUP BY e.Comuna, e.alias_estab
                        ORDER BY e.Comuna, e.alias_estab)
                    ) tmp
                    group by tmp.Comuna, tmp.alias_estab
                    order by tmp.Comuna, tmp.alias_estab";

$denominadores = DB::connection('mysql_rem')->select($sql_denominador);

foreach($denominadores as $registro) {
    $data52019[$registro->Comuna]['denominador'] += $registro->denominador;
    $data52019[$registro->Comuna][$registro->alias_estab]['denominador'] = $registro->denominador;
}

$data52019['CAMIÑA']['denominador'] = 279;
$data52019['CAMIÑA']['CGR Camiña']['denominador'] = 0;
$data52019['CAMIÑA']['Posta Rural Moquella']['denominador'] = 0;

$data52019['COLCHANE']['denominador'] = 208;
$data52019['COLCHANE']['CGR Colchane']['denominador'] = 0;
$data52019['COLCHANE']['Posta Rural Enquelga']['denominador'] = 0;
$data52019['COLCHANE']['Posta Rural Cariquima']['denominador'] = 0;

$data52019['HUARA']['denominador'] = 450;
$data52019['HUARA']['CGR Dr. Amador Neghme Rodríguez']['denominador'] = 0;
$data52019['HUARA']['Posta Rural Pisagua']['denominador'] = 0;
$data52019['HUARA']['Posta Rural Tarapacá']['denominador'] = 0;
$data52019['HUARA']['Posta Rural Chiapa']['denominador'] = 0;
$data52019['HUARA']['Posta Rural Sibaya']['denominador'] = 0;

/* ==== Calculos ==== */
foreach($data52019 as $nombre_comuna => $comuna) {
    foreach($comuna as $nombre_establecimiento => $establecimiento) {
        /* Existe en el array un indice ['numerador'], ['denominador'] y ['meta'],
         * estos almacenan la información de la comuna, por lo tanto tengo que saltarlos
         * en la iteración del foreach y continuar con los establecimientos */
        /* Realizar los calculos mensuales */
        if($nombre_establecimiento != 'numerador' AND
            $nombre_establecimiento != 'numerador_6' AND
            $nombre_establecimiento != 'numerador_12' AND
            $nombre_establecimiento != 'denominador' AND
            $nombre_establecimiento != 'meta' AND
            $nombre_establecimiento != 'cumplimiento'){

            /* Calculo de las metas de cada establecimiento */
            if($data52019[$nombre_comuna][$nombre_establecimiento]['denominador'] == 0) {
                /* Si es 0 el denominadore entonces la meta es 0 */
                $data52019[$nombre_comuna][$nombre_establecimiento]['cumplimiento'] = 0;
            }
            else {
                /* De lo contrario calcular el porcentaje */
                switch($ultimo_rem) {
                    case 1:
                    case 2:
                    case 3:
                    case 4:
                    case 5:
                        $data52019[$nombre_comuna]['cumplimiento'] = 0;
                        break;
                    case 6:
                    case 7:
                    case 8:
                    case 9:
                    case 10:
                    case 11:
                        $data52019[$nombre_comuna][$nombre_establecimiento]['numerador'] =
                            $data52019[$nombre_comuna][$nombre_establecimiento]['numerador_6'];
                        break;
                    case 12:
                        $data52019[$nombre_comuna][$nombre_establecimiento]['numerador'] =
                            $data52019[$nombre_comuna][$nombre_establecimiento]['numerador_12'];
                        break;
                }
                $data52019[$nombre_comuna][$nombre_establecimiento]['cumplimiento'] =
                    $data52019[$nombre_comuna][$nombre_establecimiento]['numerador'] / $data52019[$nombre_comuna][$nombre_establecimiento]['denominador'] * 100;
            }

            /* Fija la meta de la comuna también a sus establecimientos */
            $data52019[$nombre_comuna][$nombre_establecimiento]['meta'] = $data52019[$nombre_comuna]['meta'];

            /* Calculo de las metas de la comuna */
            if($data52019[$nombre_comuna]['denominador'] == 0) {
                /* Si es 0 el denominadore entonces la meta es 0 */
                $data52019[$nombre_comuna]['cumplimiento'] = 0;
            }
            else {
                /* De lo contrario calcular el porcentaje */
                switch($ultimo_rem) {
                    case 1:
                    case 2:
                    case 3:
                    case 4:
                    case 5:
                        $data52019[$nombre_comuna]['cumplimiento'] = 0;
                        break;
                    case 6:
                    case 7:
                    case 8:
                    case 9:
                    case 10:
                    case 11:
                        $data52019[$nombre_comuna]['numerador'] =
                            $data52019[$nombre_comuna]['numerador_6'];
                        break;
                    case 12:
                        $data52019[$nombre_comuna]['numerador'] =
                            $data52019[$nombre_comuna]['numerador_12'];
                        break;
                }
                $data52019[$nombre_comuna]['cumplimiento'] = $data52019[$nombre_comuna]['numerador'] / $data52019[$nombre_comuna]['denominador'] * 100;
            }
        }
    }
}

/* Numerador = A0200002	LACTANCIA MATERNA EN MENORES CONTROLADOS - TIPO DE ALIMENTACIÓN - LACTANCIA MATERNA EXCLUSIVA
   Denominador = A0200001	LACTANCIA MATERNA EN MENORES CONTROLADOS - TIPO DE ALIMENTACIÓN - MENORES CONTROLADOS
*/

$meses = array(1,2,3,4,5,6,7,8,9,10,11,12);
$flag1 = NULL;
$flag2 = NULL;
$data62019 = array();

$sql_establecimientos =
'SELECT comuna, alias_estab
 FROM 2019establecimientos
 WHERE meta_san = 1
 ORDER BY comuna;';

$establecimientos = DB::connection('mysql_rem')->select($sql_establecimientos);

/* ==== Inicializar en 0 el arreglo de datos $data62019 ==== */
foreach($establecimientos as $establecimiento) {
    $data62019[$establecimiento->comuna]['numeradores']['total'] = 0;
    $data62019[$establecimiento->comuna]['denominadores']['total'] = 0;
    $data62019[$establecimiento->comuna]['cumplimiento'] = 0;
    for($mes=1; $mes <= $ultimo_rem; $mes++) {
        $data62019[$establecimiento->comuna]['numeradores'][$mes] = 0;
        $data62019[$establecimiento->comuna]['denominadores'][$mes] = 0;
        $data62019[$establecimiento->comuna][$establecimiento->alias_estab]['numeradores']['total'] = 0;
        $data62019[$establecimiento->comuna][$establecimiento->alias_estab]['denominadores']['total'] = 0;
        $data62019[$establecimiento->comuna][$establecimiento->alias_estab]['numeradores'][$mes] = 0;
        $data62019[$establecimiento->comuna][$establecimiento->alias_estab]['denominadores'][$mes] = 0;
    }
    $data62019[$establecimiento->comuna][$establecimiento->alias_estab]['cumplimiento'] = 0;
}

$data62019['ALTO HOSPICIO']['meta'] = '60%';
$data62019['CAMIÑA']['meta'] = '70%';
$data62019['COLCHANE']['meta'] = '100%';
$data62019['HUARA']['meta'] = '75%';
$data62019['IQUIQUE']['meta'] = '63%';
$data62019['PICA']['meta'] = '60%';
$data62019['POZO ALMONTE']['meta'] = '56%';

/* ===== Query numerador ===== */
$sql_numerador = 'SELECT e.Comuna, e.alias_estab, r.Mes, (ifnull(Col08,0) + ifnull(Col09,0)) as numerador
    FROM '.$year.'rems r
    LEFT JOIN 2019establecimientos e
    ON r.IdEstablecimiento=e.Codigo
    WHERE CodigoPrestacion = "A0200002" AND e.meta_san = 1
    ORDER BY e.Comuna, e.alias_estab, r.Mes';
$numeradores = DB::connection('mysql_rem')->select($sql_numerador);

foreach($numeradores as $registro) {
    if( ($flag1 != $registro->Comuna) OR ($flag2 != $registro->alias_estab) ) {
        for($mes=1; $mes <= $ultimo_rem; $mes++) {
            $data62019[$registro->Comuna][$registro->alias_estab]['numeradores'][$mes] = 0;
        }
        $flag1 = $registro->Comuna;
        $flag2 = $registro->alias_estab;
    }
    $data62019[$registro->Comuna][$registro->alias_estab]['numeradores'][$registro->Mes] = $registro->numerador;
}

/* ===== Query denominador ===== */
$sql_denominador = 'SELECT e.Comuna, e.alias_estab, r.Mes, (ifnull(Col08,0) + ifnull(Col09,0)) as denominador
    FROM '.$year.'rems r
    LEFT JOIN 2019establecimientos e
    ON r.IdEstablecimiento=e.Codigo
    WHERE CodigoPrestacion = "A0200001" AND e.meta_san = 1
    ORDER BY e.Comuna, e.alias_estab, r.Mes';
$denominadores = DB::connection('mysql_rem')->select($sql_denominador);

foreach($denominadores as $registro) {
    if( ($flag1 != $registro->Comuna) OR ($flag2 != $registro->alias_estab) ) {
        for($mes=1; $mes <= $ultimo_rem; $mes++) {
            $data62019[$registro->Comuna][$registro->alias_estab]['denominadores'][$mes] = 0;
        }
        $flag1 = $registro->Comuna;
        $flag2 = $registro->alias_estab;
    }
    $data62019[$registro->Comuna][$registro->alias_estab]['denominadores'][$registro->Mes] = $registro->denominador;
}

/* ==== Calculos ==== */
foreach($data62019 as $nombre_comuna => $comuna) {
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
            $data62019[$nombre_comuna][$nombre_establecimiento]['denominadores']['total'] = array_sum($establecimiento['denominadores']);
            $data62019[$nombre_comuna][$nombre_establecimiento]['numeradores']['total'] = array_sum($establecimiento['numeradores']);

            /* Calcula los totales de cada comuna */
            $data62019[$nombre_comuna]['numeradores']['total'] += $data62019[$nombre_comuna][$nombre_establecimiento]['numeradores']['total'];
            $data62019[$nombre_comuna]['denominadores']['total'] += $data62019[$nombre_comuna][$nombre_establecimiento]['denominadores']['total'];

            /* Calcula la suma mensual por comuna */
            for($mes=1; $mes <= $ultimo_rem; $mes++) {
                $data62019[$nombre_comuna]['numeradores'][$mes] += $establecimiento['numeradores'][$mes];
                $data62019[$nombre_comuna]['denominadores'][$mes] += $establecimiento['denominadores'][$mes];
            }

            /* Calculo de las metas de cada establecimiento */
            if($data62019[$nombre_comuna][$nombre_establecimiento]['denominadores']['total'] == 0) {
                /* Si es 0 el denominadore entonces la cumplimiento es 0 */
                $data62019[$nombre_comuna][$nombre_establecimiento]['cumplimiento'] = 0;
            }
            else {
                /* De lo contrario calcular el porcentaje */
                $data62019[$nombre_comuna][$nombre_establecimiento]['cumplimiento'] = $data62019[$nombre_comuna][$nombre_establecimiento]['numeradores']['total'] / $data62019[$nombre_comuna][$nombre_establecimiento]['denominadores']['total'] * 100;
            }

            /* Calculo de las metas de la comuna */
            if($data62019[$nombre_comuna]['denominadores']['total'] == 0) {
                /* Si es 0 el denominadore entonces la cumplimiento es 0 */
                $data62019[$nombre_comuna]['cumplimiento'] = 0;
            }
            else {
                /* De lo contrario calcular el porcentaje */
                $data62019[$nombre_comuna]['cumplimiento'] = $data62019[$nombre_comuna]['numeradores']['total'] / $data62019[$nombre_comuna]['denominadores']['total'] * 100;
            }
        }
    }
}

/* 2018 */

$year = 2018;
/* 02010420	RESULTADOS DE LA APLICACIÓN DE ESCALA DE EVALUACIÓN DEL DESARROLLO PSICOMOTOR - REEVALUACIÓN - NORMAL (de riesgo)
   03500366	RESULTADOS DE LA APLICACIÓN DE ESCALA DE EVALUACIÓN DEL DESARROLLO PSICOMOTOR - REEVALUACIÓN - NORMAL CON REZAGO (de riesgo) */

$meses = array(1,2,3,4,5,6,7,8,9,10,11,12);
$flag1 = NULL;
$flag2 = NULL;
$data12018 = array();

$sql_establecimientos ='SELECT comuna, alias_estab
                        FROM establecimientos
                        WHERE meta_san = 1
                        ORDER BY comuna;';

$establecimientos = DB::connection('mysql_rem')->select($sql_establecimientos);

/* ==== Inicializar en 0 el arreglo de datos $data12018 ==== */
foreach($establecimientos as $establecimiento) {
    $data12018[$establecimiento->comuna]['numeradores']['total'] = 0;
    $data12018[$establecimiento->comuna]['denominadores']['total'] = 0;
    //$data12018[$establecimiento->comuna]['denominadores_2']['total'] = 0;
    $data12018[$establecimiento->comuna]['cumplimiento'] = 0;
    foreach($meses as $mes) {
        $data12018[$establecimiento->comuna]['numeradores'][$mes] = 0;
        $data12018[$establecimiento->comuna]['denominadores'][$mes] = 0;
        //$data12018[$establecimiento->comuna]['denominadores_2'][$mes] = 0;
        $data12018[$establecimiento->comuna][$establecimiento->alias_estab]['numeradores']['total'] = 0;
        $data12018[$establecimiento->comuna][$establecimiento->alias_estab]['denominadores']['total'] = 0;
        $data12018[$establecimiento->comuna][$establecimiento->alias_estab]['denominadores_2']['total'] = 0;
        $data12018[$establecimiento->comuna][$establecimiento->alias_estab]['numeradores'][$mes] = 0;
        $data12018[$establecimiento->comuna][$establecimiento->alias_estab]['denominadores'][$mes] = 0;
        $data12018[$establecimiento->comuna][$establecimiento->alias_estab]['denominadores_2'][$mes] = 0;
    }
    $data12018[$establecimiento->comuna][$establecimiento->alias_estab]['cumplimiento'] = 0;
}

$data12018['ALTO HOSPICIO']['meta'] = '90%';
$data12018['CAMIÑA']['meta'] = '100%';
$data12018['COLCHANE']['meta'] = '100%';
$data12018['HUARA']['meta'] = '90%';
$data12018['IQUIQUE']['meta'] = '92%';
$data12018['PICA']['meta'] = '90%';
$data12018['POZO ALMONTE']['meta'] = '100%';

/* ===== Query numerador ===== */
$sql_numerador = 'SELECT e.Comuna, e.alias_estab, r.Mes, sum((ifnull(Col08,0) + ifnull(Col09,0) + ifnull(Col10,0) + ifnull(Col11,0))) as numerador
    FROM '.$year.'rems r
    LEFT JOIN establecimientos e
    ON r.IdEstablecimiento=e.Codigo
    WHERE CodigoPrestacion in  (02010420,03500366) AND e.meta_san = 1 AND Mes BETWEEN 1 AND '.$ultimo_rem.'
    GROUP BY e.Comuna, e.alias_estab, r.Mes
    ORDER BY e.Comuna, e.alias_estab, r.Mes';
$numeradores = DB::connection('mysql_rem')->select($sql_numerador);

foreach($numeradores as $registro) {
    if( ($flag1 != $registro->Comuna) OR ($flag2 != $registro->alias_estab) ) {
        foreach($meses as $mes) {
            $data12018[$registro->Comuna][$registro->alias_estab]['numeradores'][$mes] = 0;
        }
        $flag1 = $registro->Comuna;
        $flag2 = $registro->alias_estab;
    }
    $data12018[$registro->Comuna][$registro->alias_estab]['numeradores'][$registro->Mes] = $registro->numerador;
}

/* ===== Query denominador ===== */
/*02010321	RESULTADOS DE LA APLICACIÓN DE ESCALA DE EVALUACIÓN DEL DESARROLLO PSICOMOTOR - PRIMERA EVALUACIÓN - RIESGO
  03500334	RESULTADOS DE LA APLICACIÓN DE ESCALA DE EVALUACIÓN DEL DESARROLLO PSICOMOTOR - TRASLADO DE ESTABLECIMIENTO - RIESGO*/

$sql_denominador = 'SELECT e.Comuna, e.alias_estab, r.Mes, sum((ifnull(Col08,0) + ifnull(Col09,0) + ifnull(Col10,0) + ifnull(Col11,0))) as denominador
    FROM '.$year.'rems r
    LEFT JOIN establecimientos e
    ON r.IdEstablecimiento=e.Codigo
    WHERE CodigoPrestacion in (02010321) AND e.meta_san = 1 AND Mes BETWEEN 1 AND '.$ultimo_rem.'
    GROUP BY e.Comuna, e.alias_estab, r.Mes
    ORDER BY e.Comuna, e.alias_estab, r.Mes';
$denominadores = DB::connection('mysql_rem')->select($sql_denominador);

foreach($denominadores as $registro) {
    if( ($flag1 != $registro->Comuna) OR ($flag2 != $registro->alias_estab) ) {
        foreach($meses as $mes) {
            $data12018[$registro->Comuna][$registro->alias_estab]['denominadores'][$mes] = 0;
        }
        $flag1 = $registro->Comuna;
        $flag2 = $registro->alias_estab;
    }
    $data12018[$registro->Comuna][$registro->alias_estab]['denominadores'][$registro->Mes] = $registro->denominador;
}

/* ===== Query denominador ===== */
$sql_denominador_2 = 'SELECT e.Comuna, e.alias_estab, r.Mes, sum((ifnull(Col08,0) + ifnull(Col09,0) + ifnull(Col10,0) + ifnull(Col11,0))) as denominador_2
    FROM '.$year.'rems r
    LEFT JOIN establecimientos e
    ON r.IdEstablecimiento=e.Codigo
    WHERE CodigoPrestacion in (03500334) AND e.meta_san = 1 AND Mes BETWEEN 1 AND '.$ultimo_rem.'
    GROUP BY e.Comuna, e.alias_estab, r.Mes
    ORDER BY e.Comuna, e.alias_estab, r.Mes';
$denominadores_2 = DB::connection('mysql_rem')->select($sql_denominador_2);

foreach($denominadores_2 as $registro) {
    if( ($flag1 != $registro->Comuna) OR ($flag2 != $registro->alias_estab) ) {
        foreach($meses as $mes) {
            $data12018[$registro->Comuna][$registro->alias_estab]['denominadores_2'][$mes] = 0;
        }
        $flag1 = $registro->Comuna;
        $flag2 = $registro->alias_estab;
    }
    $data12018[$registro->Comuna][$registro->alias_estab]['denominadores_2'][$registro->Mes] = $registro->denominador_2;
}

/* ==== Calculos ==== */
foreach($data12018 as $nombre_comuna => $comuna) {
    foreach($comuna as $nombre_establecimiento => $establecimiento) {
        /* Existe en el array un indice ['numerador'], ['denominador'] y ['meta'],
         * estos almacenan la información de la comuna, por lo tanto tengo que saltarlos
         * en la iteración del foreach y continuar con los establecimientos */
        /* Realizar los calculos mensuales */
        if($nombre_establecimiento != 'numeradores' AND
            $nombre_establecimiento != 'denominadores' AND
            $nombre_establecimiento != 'denominadores_2' AND
            $nombre_establecimiento != 'meta' AND
            $nombre_establecimiento != 'cumplimiento'){

            /* Calcula los totales de cada establecimiento */
            $data12018[$nombre_comuna][$nombre_establecimiento]['denominadores']['total'] = array_sum($establecimiento['denominadores']);
            $data12018[$nombre_comuna][$nombre_establecimiento]['denominadores_2']['total'] = array_sum($establecimiento['denominadores_2']);
            $data12018[$nombre_comuna][$nombre_establecimiento]['numeradores']['total'] = array_sum($establecimiento['numeradores']);

            //dd($data12018[$nombre_comuna][$nombre_establecimiento]['denominadores']['total']);

            /* Calcula los totales de cada comuna */
            $data12018[$nombre_comuna]['numeradores']['total'] += $data12018[$nombre_comuna][$nombre_establecimiento]['numeradores']['total'];
            $data12018[$nombre_comuna]['denominadores']['total'] += $data12018[$nombre_comuna][$nombre_establecimiento]['denominadores']['total']-$data12018[$nombre_comuna][$nombre_establecimiento]['denominadores_2']['total'];

            /* Calcula la suma mensual por comuna */
            foreach($meses as $mes){
                $data12018[$nombre_comuna]['numeradores'][$mes] += $establecimiento['numeradores'][$mes];
                $data12018[$nombre_comuna]['denominadores'][$mes] += $establecimiento['denominadores'][$mes] - $establecimiento['denominadores_2'][$mes];
            }

            /* Calculo de las metas de cada establecimiento */
            if($data12018[$nombre_comuna][$nombre_establecimiento]['denominadores']['total'] == 0) {
                /* Si es 0 el denominadore entonces el cumplimiento es 0 */
                $data12018[$nombre_comuna][$nombre_establecimiento]['cumplimiento'] = 0;
            }
            else {
                /* De lo contrario calcular el porcentaje */
                $data12018[$nombre_comuna][$nombre_establecimiento]['cumplimiento'] = $data12018[$nombre_comuna][$nombre_establecimiento]['numeradores']['total'] / ($data12018[$nombre_comuna][$nombre_establecimiento]['denominadores']['total'] - $data12018[$nombre_comuna][$nombre_establecimiento]['denominadores_2']['total']) * 100;
            }

            /* Calculo de las metas de la comuna */
            if($data12018[$nombre_comuna]['denominadores']['total'] == 0) {
                /* Si es 0 el denominadore entonces el cumplimiento es 0 */
                $data12018[$nombre_comuna]['cumplimiento'] = 0;
            }
            else {
                /* De lo contrario calcular el porcentaje */
                $data12018[$nombre_comuna]['cumplimiento'] = $data12018[$nombre_comuna]['numeradores']['total'] / $data12018[$nombre_comuna]['denominadores']['total'] * 100;
            }
        }
    }
}

//INDICADOR 2
//2018

$data22018 = array();

$sql_establecimientos = "SELECT comuna, alias_estab
                         FROM establecimientos
                         WHERE meta_san = 1
                         ORDER BY comuna;";

$establecimientos = DB::connection('mysql_rem')->select($sql_establecimientos);

/* ==== Inicializar en 0 el arreglo de datos $data22018 ==== */
foreach($establecimientos as $establecimiento) {
    /*$data22018[$establecimiento->comuna]['numerador'] = 0;
    $data22018[$establecimiento->comuna]['denominador'] = 0;
    $data22018[$establecimiento->comuna]['meta'] = 0;
    $data22018[$establecimiento->comuna]['cumplimiento'] = 0;
    $data22018[$establecimiento->comuna][$establecimiento->alias_estab]['numerador'] = 0;
    $data22018[$establecimiento->comuna][$establecimiento->alias_estab]['denominador'] = 0;
    $data22018[$establecimiento->comuna][$establecimiento->alias_estab]['meta'] = 0;
    $data22018[$establecimiento->comuna][$establecimiento->alias_estab]['cumplimiento'] = 0;*/

    $data22018[$establecimiento->comuna]['numerador'] = 0;
    $data22018[$establecimiento->comuna]['numerador_6'] = 0;
    $data22018[$establecimiento->comuna]['denominador'] = 0;
    $data22018[$establecimiento->comuna]['meta'] = 0;
    $data22018[$establecimiento->comuna]['cumplimiento'] = 0;
    $data22018[$establecimiento->comuna][$establecimiento->alias_estab]['numerador'] = 0;
    $data22018[$establecimiento->comuna][$establecimiento->alias_estab]['numerador_6'] = 0;
    $data22018[$establecimiento->comuna][$establecimiento->alias_estab]['denominador'] = 0;
    $data22018[$establecimiento->comuna][$establecimiento->alias_estab]['meta'] = 0;
    $data22018[$establecimiento->comuna][$establecimiento->alias_estab]['cumplimiento'] = 0;
}

$data22018['ALTO HOSPICIO']['meta'] = '23%';
$data22018['CAMIÑA']['meta'] = '100%';
$data22018['COLCHANE']['meta'] = '200 pap vigentes';
$data22018['HUARA']['meta'] = '25%';
$data22018['IQUIQUE']['meta'] = '29%';
$data22018['PICA']['meta'] = '32%';
$data22018['POZO ALMONTE']['meta'] = '37%';

/* ===== Query numerador ===== */
$sql_numerador =
"SELECT e.Comuna, e.alias_estab, r.Mes, sum(ifnull(Col01,0)) as numerador
    FROM ".$year."rems r
    LEFT JOIN establecimientos e ON r.IdEstablecimiento=e.Codigo
    WHERE
    e.meta_san = 1 AND Ano = 2018 AND (Mes = 6 OR Mes = 12) AND
    CodigoPrestacion IN ('P1206010','P1206020','P1206030','P1206040','P1206050','P1206060','P1206070','P1206080')
    GROUP by e.Comuna, e.alias_estab, r.Mes
    ORDER BY e.Comuna, e.alias_estab, r.Mes";

$numeradores = DB::connection('mysql_rem')->select($sql_numerador);

foreach($numeradores as $registro) {
    /*$data22018[$registro->Comuna]['numerador'] += $registro->numerador;
    $data22018[$registro->Comuna][$registro->alias_estab]['numerador'] = $registro->numerador;*/

    if($registro->Mes == 6) {
        $data22018[$registro->Comuna]['numerador_6'] += $registro->numerador;
        $data22018[$registro->Comuna][$registro->alias_estab]['numerador_6'] = $registro->numerador;
    }
    if($registro->Mes == 12){
        $data22018[$registro->Comuna]['numerador'] += $registro->numerador;
        $data22018[$registro->Comuna][$registro->alias_estab]['numerador'] = $registro->numerador;
    }
}

/* ===== Query denominador ===== */
$sql_denominador = "SELECT e.alias_estab, e.Comuna, COUNT(*) AS denominador
                    FROM percapita p
                    LEFT JOIN establecimientos e ON e.Codigo = p.COD_CENTRO
                    WHERE
                    FECHA_CORTE = '2017-08-31' AND
                    GENERO = 'F' AND
                    EDAD BETWEEN 25 AND 64 AND
                    ACEPTADO_RECHAZADO = 'ACEPTADO'
                    AND e.meta_san = 1
                    GROUP BY e.Comuna, e.alias_estab
                    ORDER BY e.Comuna, e.alias_estab";

$denominadores = DB::connection('mysql_rem')->select($sql_denominador);

foreach($denominadores as $registro) {
    $data22018[$registro->Comuna]['denominador'] += $registro->denominador;
    $data22018[$registro->Comuna][$registro->alias_estab]['denominador'] = $registro->denominador;
}

$data22018['CAMIÑA']['denominador'] = 616;
$data22018['CAMIÑA']['CGR Camiña']['denominador'] = 0;
$data22018['CAMIÑA']['Posta Rural Moquella']['denominador'] = 0;


$data22018['COLCHANE']['denominador'] = 200;
$data22018['COLCHANE']['CGR Colchane']['denominador'] = 0;
$data22018['COLCHANE']['Posta Rural Enquelga']['denominador'] = 0;
$data22018['COLCHANE']['Posta Rural Cariquima']['denominador'] = 0;

$data22018['HUARA']['denominador'] = 583;
$data22018['HUARA']['CGR Huara']['denominador'] = 0;
$data22018['HUARA']['Posta Rural Pisagua']['denominador'] = 0;
$data22018['HUARA']['Posta Rural Tarapacá']['denominador'] = 0;
$data22018['HUARA']['Posta Rural Chiapa']['denominador'] = 0;
$data22018['HUARA']['Posta Rural Sibaya']['denominador'] = 0;

/* ==== Calculos ==== */
foreach($data22018 as $nombre_comuna => $comuna) {
    foreach($comuna as $nombre_establecimiento => $establecimiento) {
        /* Existe en el array un indice ['numerador'], ['denominador'] y ['meta'],
         * estos almacenan la información de la comuna, por lo tanto tengo que saltarlos
         * en la iteración del foreach y continuar con los establecimientos */
        /* Realizar los calculos mensuales */
        if($nombre_establecimiento != 'numerador' AND
            $nombre_establecimiento != 'numerador_6' AND
            $nombre_establecimiento != 'denominador' AND
            $nombre_establecimiento != 'meta' AND
            $nombre_establecimiento != 'cumplimiento'){

            /* Calculo de las metas de cada establecimiento */
            if($data22018[$nombre_comuna][$nombre_establecimiento]['denominador'] == 0) {
                /* Si es 0 el denominadore entonces la meta es 0 */
                $data22018[$nombre_comuna][$nombre_establecimiento]['cumplimiento'] = 0;
            }
            else {
                /* De lo contrario calcular el porcentaje */
                $data22018[$nombre_comuna][$nombre_establecimiento]['cumplimiento'] =
                    $data22018[$nombre_comuna][$nombre_establecimiento]['numerador'] / $data22018[$nombre_comuna][$nombre_establecimiento]['denominador'] * 100;
            }

            /* Fija la meta de la comuna también a sus establecimientos */
            $data22018[$nombre_comuna][$nombre_establecimiento]['meta'] = $data22018[$nombre_comuna]['meta'];

            /* Calculo de las metas de la comuna */
            if($data22018[$nombre_comuna]['denominador'] == 0) {
                /* Si es 0 el denominadore entonces la meta es 0 */
                $data22018[$nombre_comuna]['cumplimiento'] = 0;
            }
            else {
                /* De lo contrario calcular el porcentaje */
                $data22018[$nombre_comuna]['cumplimiento'] = $data22018[$nombre_comuna]['numerador'] / $data22018[$nombre_comuna]['denominador'] * 100;
            }
        }
    }
}
