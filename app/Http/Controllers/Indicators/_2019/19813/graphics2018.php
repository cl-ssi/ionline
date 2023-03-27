<?php
namespace App\Http\Controllers\Indicators;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\Indicators\SingleParameter;

/* INDICADOR 1 */
/* 2019 */

$sql_ultimo_rem = "SELECT MAX(Mes) as ultimo_rem FROM 2019rems;";
$ultimo_rem = DB::connection('mysql_rem')->select($sql_ultimo_rem)[0]->ultimo_rem;
$mescarga = $ultimo_rem;

/* 2018 */

$year = 2018;
/* 02010420	RESULTADOS DE LA APLICACIÓN DE ESCALA DE EVALUACIÓN DEL DESARROLLO PSICOMOTOR - REEVALUACIÓN - NORMAL (de riesgo)
   03500366	RESULTADOS DE LA APLICACIÓN DE ESCALA DE EVALUACIÓN DEL DESARROLLO PSICOMOTOR - REEVALUACIÓN - NORMAL CON REZAGO (de riesgo) */

$label['meta'] = 'Porcentaje de niños y niñas de 12 a 23 meses con riesgo del desarrollo psicomoor recuperados.';
$label['numerador'] = 'N° de niños y niñas de 12 a 23 meses dignosticados con riesgo del DSM recuperados, período enero a diciembre 2018.';
$label['denominador'] = 'N° de niños y niñas de 12 a 23 meses diagnosticados con riesgo de Desarrollo Psicomotor en su primera evaluación, período enero a diciembre 2018.';

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

$year = 2018;
$label['meta'] = 'Papanicolau (PAP) vigente en mujeres de 25 a 64 años.';
$label['numerador'] = 'N° logrado de mujeres de 25 a 64 años inscritas validadas, con PAP vigente a diciembre 2018*100';
$label['denominador'] = 'N° total de mujeres de 25 a 64 años inscritas validadas.';

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

$year = 2018;
/* Numerador = 09215313 09215413   Denominador = 01080008*/
$label['meta'] = 'Porcentaje de altas odontológicas totales en adolescentes de 12 años.';
$label['numerador'] = 'Nº de Adolescentes de 12 años con alta odontológica total de enero a diciembre 2018.';
$label['denominador'] = 'Total de Adolescentes de 12 años inscritos validados por FONASA para el año 2018.';

$meses = array(1,2,3,4,5,6,7,8,9,10,11,12);
$flag1 = NULL;
$flag2 = NULL;
$data3a2018 = array();

$sql_establecimientos = "SELECT comuna, alias_estab
                         FROM establecimientos
                         WHERE meta_san = 1
                         ORDER BY comuna";

$establecimientos = DB::connection('mysql_rem')->select($sql_establecimientos);

/* ==== Inicializar en 0 el arreglo de datos $data3a2018 ==== */
foreach($establecimientos as $establecimiento) {
    $data3a2018[$establecimiento->comuna]['numeradores']['total'] = 0;
    $data3a2018[$establecimiento->comuna]['denominador'] = 0;
    $data3a2018[$establecimiento->comuna]['cumplimiento'] = 0;
    foreach($meses as $mes) {
        $data3a2018[$establecimiento->comuna]['numeradores'][$mes] = 0;
        $data3a2018[$establecimiento->comuna][$establecimiento->alias_estab]['numeradores']['total'] = 0;
        $data3a2018[$establecimiento->comuna][$establecimiento->alias_estab]['numeradores'][$mes] = 0;
    }
    $data3a2018[$establecimiento->comuna][$establecimiento->alias_estab]['denominador'] = 0;
    $data3a2018[$establecimiento->comuna][$establecimiento->alias_estab]['cumplimiento'] = 0;
}

$data3a2018['ALTO HOSPICIO']['meta'] = '88%';
$data3a2018['CAMIÑA']['meta'] = '92%';
$data3a2018['COLCHANE']['meta'] = '93%';
$data3a2018['HUARA']['meta'] = '75%';
$data3a2018['IQUIQUE']['meta'] = '81%';
$data3a2018['PICA']['meta'] = '81%';
$data3a2018['POZO ALMONTE']['meta'] = '75%';


/* ===== Query numerador ===== */
$sql_numerador = 'SELECT e.Comuna, e.alias_estab, r.Mes, sum((ifnull(Col18,0) + ifnull(Col19,0))) as numerador
    FROM '.$year.'rems r
    LEFT JOIN establecimientos e
    ON r.IdEstablecimiento=e.Codigo
    WHERE CodigoPrestacion IN (09215313,09215413) AND e.meta_san = 1 AND Mes BETWEEN 1 AND '.$ultimo_rem.'
    GROUP by e.Comuna, e.alias_estab, r.Mes
    ORDER BY e.Comuna, e.alias_estab, r.Mes';
$numeradores = DB::connection('mysql_rem')->select($sql_numerador);

foreach($numeradores as $registro) {
    if( ($flag1 != $registro->Comuna) OR ($flag2 != $registro->alias_estab) ) {
        foreach($meses as $mes) {
            $data3a2018[$registro->Comuna][$registro->alias_estab]['numeradores'][$mes] = 0;
        }
        $flag1 = $registro->Comuna;
        $flag2 = $registro->alias_estab;
    }
    $data3a2018[$registro->Comuna][$registro->alias_estab]['numeradores'][$registro->Mes] = $registro->numerador;
}

/* ===== Query denominador ===== */
$sql_denominador = "SELECT e.alias_estab, e.Comuna, COUNT(*) AS denominador
                    FROM percapita p
                    LEFT JOIN establecimientos e ON e.Codigo = p.COD_CENTRO
                    WHERE
                    FECHA_CORTE = '2017-08-31' AND
                    EDAD = 12 AND
                    ACEPTADO_RECHAZADO = 'ACEPTADO' AND e.meta_san = 1
                    GROUP BY e.Comuna, e.alias_estab
                    ORDER BY e.Comuna, e.alias_estab";
$denominadores = DB::connection('mysql_rem')->select($sql_denominador);



foreach($denominadores as $registro) {
    $data3a2018[$registro->Comuna][$registro->alias_estab]['denominador'] = $registro->denominador;
    $data3a2018[$registro->Comuna]['denominador'] += $registro->denominador;
}

$data3a2018['ALTO HOSPICIO']['denominador'] = 1491;
$data3a2018['ALTO HOSPICIO']['CES Pedro Pulgar']['denominador'] = 1491;
$data3a2018['ALTO HOSPICIO']['CECOSF El Boro']['denominador'] = 0;
$data3a2018['ALTO HOSPICIO']['CECOSF La Tortuga']['denominador'] = 0;

$data3a2018['CAMIÑA']['denominador'] = 14;
$data3a2018['CAMIÑA']['CGR Camiña']['denominador'] = 0;
$data3a2018['CAMIÑA']['Posta Rural Moquella']['denominador'] = 0;

$data3a2018['COLCHANE']['denominador'] = 15;
$data3a2018['COLCHANE']['CGR Colchane']['denominador'] = 0;
$data3a2018['COLCHANE']['Posta Rural Enquelga']['denominador'] = 0;
$data3a2018['COLCHANE']['Posta Rural Cariquima']['denominador'] = 0;

$data3a2018['HUARA']['denominador'] = 47;
$data3a2018['HUARA']['CGR Huara']['denominador'] = 0;
$data3a2018['HUARA']['Posta Rural Pisagua']['denominador'] = 0;
$data3a2018['HUARA']['Posta Rural Tarapacá']['denominador'] = 0;
$data3a2018['HUARA']['Posta Rural Chiapa']['denominador'] = 0;
$data3a2018['HUARA']['Posta Rural Sibaya']['denominador'] = 0;

$data3a2018['IQUIQUE']['denominador'] = 2243;
$data3a2018['IQUIQUE']['CESFAM Cirujano Aguirre']['denominador'] = 709;
$data3a2018['IQUIQUE']['CESFAM Cirujano Videla']['denominador'] = 596;
$data3a2018['IQUIQUE']['CESFAM Cirujano Guzmán']['denominador'] = 432;
$data3a2018['IQUIQUE']['CESFAM Sur Iquique']['denominador'] = 497;
$data3a2018['IQUIQUE']['Posta Rural Chanavayita']['denominador'] = 5;
$data3a2018['IQUIQUE']['Posta Rural San Marcos']['denominador'] = 1;
$data3a2018['IQUIQUE']['CECOSF Cerro Esmeralda']['denominador'] = 3;

$data3a2018['PICA']['denominador'] = 78;
$data3a2018['PICA']['CESFAM Pica']['denominador'] = 78;
$data3a2018['PICA']['Posta Rural Cancosa']['denominador'] = 0;
$data3a2018['PICA']['Posta Rural Matilla']['denominador'] = 0;

$data3a2018['POZO ALMONTE']['denominador'] = 211;
$data3a2018['POZO ALMONTE']['CGR Pozo Almonte']['denominador'] = 211;
$data3a2018['POZO ALMONTE']['Posta Rural Mamiña']['denominador'] = 0;
$data3a2018['POZO ALMONTE']['Posta Rural La Tirana']['denominador'] = 0;
$data3a2018['POZO ALMONTE']['Posta Rural La Huayca']['denominador'] = 0;

/* ==== Calculos ==== */
foreach($data3a2018 as $nombre_comuna => $comuna) {
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
                $data3a2018[$nombre_comuna][$nombre_establecimiento]['numeradores']['total'] = array_sum($establecimiento['numeradores']);
                //$data3a2018[$nombre_comuna][$nombre_establecimiento]['denominadores']['total'] = array_sum($establecimiento['denominadores']);
            }

            /* Calcula los totales de cada comuna */
            $data3a2018[$nombre_comuna]['numeradores']['total'] += $data3a2018[$nombre_comuna][$nombre_establecimiento]['numeradores']['total'];
            //$data3a2018[$nombre_comuna]['denominadores']['total'] += $data3a2018[$nombre_comuna][$nombre_establecimiento]['denominadores']['total'];

            /* Calcula la suma mensual por comuna */
            foreach($meses as $mes){
                $data3a2018[$nombre_comuna]['numeradores'][$mes] += $establecimiento['numeradores'][$mes];
                //$data3a2018[$nombre_comuna]['denominadores'][$mes] += $establecimiento['denominadores'][$mes];
            }

            /* Calculo de las cumplimiento de cada establecimiento */
            if($data3a2018[$nombre_comuna][$nombre_establecimiento]['denominador'] == 0) {
                /* Si es 0 el denominadore entonces la cumplimiento es 0 */
                $data3a2018[$nombre_comuna][$nombre_establecimiento]['cumplimiento'] = 0;
            }
            else {
                /* De lo contrario calcular el porcentaje */
                $data3a2018[$nombre_comuna][$nombre_establecimiento]['cumplimiento'] =
                    $data3a2018[$nombre_comuna][$nombre_establecimiento]['numeradores']['total'] / $data3a2018[$nombre_comuna][$nombre_establecimiento]['denominador'] * 100;
            }

            /* Calculo de las cumplimiento de la comuna */
            if($data3a2018[$nombre_comuna]['denominador'] == 0) {
                /* Si es 0 el denominadore entonces la cumplimiento es 0 */
                $data3a2018[$nombre_comuna]['cumplimiento'] = 0;
            }
            else {
                /* De lo contrario calcular el porcentaje */
                $data3a2018[$nombre_comuna]['cumplimiento'] = $data3a2018[$nombre_comuna]['numeradores']['total'] / $data3a2018[$nombre_comuna]['denominador'] * 100;
            }
        }
    }
}

//INDICADOR 3B
//2018

$year = 2018;
/* Numerador = 09215313 09215413   Denominador = 01080008*/

$label['meta'] = 'Cobertura de alta odontológica total en embarazadas.';
$label['numerador'] = 'Nº de embarazadas con alta odontológica total de enero a diciembre 2018.';
$label['denominador'] = 'Nº total de embarazadas ingresadas a control prenatal de enero a diciembre del 2018.';

$meses = array(1,2,3,4,5,6,7,8,9,10,11,12);
$flag1 = NULL;
$flag2 = NULL;
$data3b2018 = array();

$sql_establecimientos =
'SELECT comuna, alias_estab
 FROM establecimientos
 WHERE meta_san = 1
 ORDER BY comuna;';

$establecimientos = DB::connection('mysql_rem')->select($sql_establecimientos);

/* ==== Inicializar en 0 el arreglo de datos $data3b2018 ==== */
foreach($establecimientos as $establecimiento) {
    $data3b2018[$establecimiento->comuna]['numeradores']['total'] = 0;
    $data3b2018[$establecimiento->comuna]['denominadores']['total'] = 0;
    $data3b2018[$establecimiento->comuna]['cumplimiento'] = 0;
    foreach($meses as $mes) {
        $data3b2018[$establecimiento->comuna]['numeradores'][$mes] = 0;
        $data3b2018[$establecimiento->comuna]['denominadores'][$mes] = 0;
        $data3b2018[$establecimiento->comuna][$establecimiento->alias_estab]['numeradores']['total'] = 0;
        $data3b2018[$establecimiento->comuna][$establecimiento->alias_estab]['denominadores']['total'] = 0;
        $data3b2018[$establecimiento->comuna][$establecimiento->alias_estab]['numeradores'][$mes] = 0;
        $data3b2018[$establecimiento->comuna][$establecimiento->alias_estab]['denominadores'][$mes] = 0;
    }
    $data3b2018[$establecimiento->comuna][$establecimiento->alias_estab]['cumplimiento'] = 0;
}

$data3b2018['ALTO HOSPICIO']['meta'] = '70%';
$data3b2018['CAMIÑA']['meta'] = '75%';
$data3b2018['COLCHANE']['meta'] = '75%';
$data3b2018['HUARA']['meta'] = '69%';
$data3b2018['IQUIQUE']['meta'] = '54%';
$data3b2018['PICA']['meta'] = '85%';
$data3b2018['POZO ALMONTE']['meta'] = '69%';

/* ===== Query numerador =====
09215313	INGRESOS Y EGRESOS  EN ESTABLECIMIENTOS APS - TIPO DE INGRESO O EGRESO - ALTAS ODONTOLÓGICAS PREVENTIVAS
09215413	INGRESOS Y EGRESOS  EN ESTABLECIMIENTOS APS - TIPO DE INGRESO O EGRESO - ALTAS ODONTOLÓGICAS INTEGRALES (EXCLUYE SECCIÓN G)
*/
$sql_numerador = 'SELECT e.Comuna, e.alias_estab, r.Mes, sum((ifnull(Col28,0))) as numerador
    FROM '.$year.'rems r
    LEFT JOIN establecimientos e
    ON r.IdEstablecimiento=e.Codigo
    WHERE CodigoPrestacion IN (09215313,09215413) AND e.meta_san = 1 AND Mes BETWEEN 1 AND '.$ultimo_rem.'
    GROUP BY e.Comuna, e.alias_estab, r.Mes
    ORDER BY e.Comuna, e.alias_estab, r.Mes';
$numeradores = DB::connection('mysql_rem')->select($sql_numerador);

foreach($numeradores as $registro) {
    if( ($flag1 != $registro->Comuna) OR ($flag2 != $registro->alias_estab) ) {
        foreach($meses as $mes) {
            $data3b2018[$registro->Comuna][$registro->alias_estab]['numeradores'][$mes] = 0;
        }
        $flag1 = $registro->Comuna;
        $flag2 = $registro->alias_estab;
    }
    $data3b2018[$registro->Comuna][$registro->alias_estab]['numeradores'][$registro->Mes] = $registro->numerador;
}

/* ===== Query denominador =====
01080008	INGRESOS DE GESTANTES A PROGRAMA PRENATAL - CONDICIÓN - GESTANTES INGRESADAS
*/
$sql_denominador = 'SELECT e.Comuna, e.alias_estab, r.Mes, (ifnull(Col01,0)) as denominador
    FROM '.$year.'rems r
    LEFT JOIN establecimientos e
    ON r.IdEstablecimiento=e.Codigo
    WHERE CodigoPrestacion = 01080008 AND e.meta_san = 1 AND Mes BETWEEN 1 AND '.$ultimo_rem.'
    ORDER BY e.Comuna, e.alias_estab, r.Mes';
$denominadores = DB::connection('mysql_rem')->select($sql_denominador);

foreach($denominadores as $registro) {
    if( ($flag1 != $registro->Comuna) OR ($flag2 != $registro->alias_estab) ) {
        foreach($meses as $mes) {
            $data3b2018[$registro->Comuna][$registro->alias_estab]['denominadores'][$mes] = 0;
        }
        $flag1 = $registro->Comuna;
        $flag2 = $registro->alias_estab;
    }
    $data3b2018[$registro->Comuna][$registro->alias_estab]['denominadores'][$registro->Mes] = $registro->denominador;
}

/* ==== Calculos ==== */
foreach($data3b2018 as $nombre_comuna => $comuna) {
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
            $data3b2018[$nombre_comuna][$nombre_establecimiento]['denominadores']['total'] = array_sum($establecimiento['denominadores']);
            $data3b2018[$nombre_comuna][$nombre_establecimiento]['numeradores']['total'] = array_sum($establecimiento['numeradores']);

            /* Calcula los totales de cada comuna */
            $data3b2018[$nombre_comuna]['numeradores']['total'] += $data3b2018[$nombre_comuna][$nombre_establecimiento]['numeradores']['total'];
            $data3b2018[$nombre_comuna]['denominadores']['total'] += $data3b2018[$nombre_comuna][$nombre_establecimiento]['denominadores']['total'];

            /* Calcula la suma mensual por comuna */
            foreach($meses as $mes){
                $data3b2018[$nombre_comuna]['numeradores'][$mes] += $establecimiento['numeradores'][$mes];
                $data3b2018[$nombre_comuna]['denominadores'][$mes] += $establecimiento['denominadores'][$mes];
            }

            /* Calculo de las cumplimiento de cada establecimiento */
            if($data3b2018[$nombre_comuna][$nombre_establecimiento]['denominadores']['total'] == 0) {
                /* Si es 0 el denominadore entonces la cumplimiento es 0 */
                $data3b2018[$nombre_comuna][$nombre_establecimiento]['cumplimiento'] = 0;
            }
            else {
                /* De lo contrario calcular el porcentaje */
                $data3b2018[$nombre_comuna][$nombre_establecimiento]['cumplimiento'] = $data3b2018[$nombre_comuna][$nombre_establecimiento]['numeradores']['total'] / $data3b2018[$nombre_comuna][$nombre_establecimiento]['denominadores']['total'] * 100;
            }

            /* Calculo de las cumplimiento de la comuna */
            if($data3b2018[$nombre_comuna]['denominadores']['total'] == 0) {
                /* Si es 0 el denominadore entonces la cumplimiento es 0 */
                $data3b2018[$nombre_comuna]['cumplimiento'] = 0;
            }
            else {
                /* De lo contrario calcular el porcentaje */
                $data3b2018[$nombre_comuna]['cumplimiento'] = $data3b2018[$nombre_comuna]['numeradores']['total'] / $data3b2018[$nombre_comuna]['denominadores']['total'] * 100;
            }
        }
    }
}

//INDICADOR 3C
//2019

$year = 2018;
/* Numerador = 09215015   Denominador =    */
$label['meta'] = 'Porcentaje de egresos odontológicos en niños y niñas de 6 años.';
$label['numerador'] = 'N° niños de 6 años inscritos con egreso odontológico de enero a dic. 2018.';
$label['denominador'] = 'Total niños de 6 años inscritos validados por FONASA para el año 2018.';


$meses = array(1,2,3,4,5,6,7,8,9,10,11,12);
$flag1 = NULL;
$flag2 = NULL;
$data3c2018 = array();

$sql_establecimientos = "SELECT comuna, alias_estab
                         FROM establecimientos
                         WHERE meta_san = 1
                         ORDER BY comuna";

$establecimientos = DB::connection('mysql_rem')->select($sql_establecimientos);

/* ==== Inicializar en 0 el arreglo de datos $data3c2018 ==== */
foreach($establecimientos as $establecimiento) {
    $data3c2018[$establecimiento->comuna]['numeradores']['total'] = 0;
    $data3c2018[$establecimiento->comuna]['denominador'] = 0;
    $data3c2018[$establecimiento->comuna]['cumplimiento'] = 0;
    foreach($meses as $mes) {
        $data3c2018[$establecimiento->comuna]['numeradores'][$mes] = 0;
        $data3c2018[$establecimiento->comuna][$establecimiento->alias_estab]['numeradores']['total'] = 0;
        $data3c2018[$establecimiento->comuna][$establecimiento->alias_estab]['numeradores'][$mes] = 0;
    }
    $data3c2018[$establecimiento->comuna][$establecimiento->alias_estab]['denominador'] = 0;
    $data3c2018[$establecimiento->comuna][$establecimiento->alias_estab]['cumplimiento'] = 0;
}


$data3c2018['ALTO HOSPICIO']['meta'] = '73%';
$data3c2018['CAMIÑA']['meta'] = '100%';
$data3c2018['COLCHANE']['meta'] = '100%';
$data3c2018['HUARA']['meta'] = '100%';
$data3c2018['IQUIQUE']['meta'] = '83%';
$data3c2018['PICA']['meta'] = '85%';
$data3c2018['POZO ALMONTE']['meta'] = '80%';


/* ===== Query numerador ===== */
$sql_numerador = 'SELECT e.Comuna, e.alias_estab, r.Mes, sum((ifnull(Col16,0) + ifnull(Col17,0))) as numerador
    FROM '.$year.'rems r
    LEFT JOIN establecimientos e
    ON r.IdEstablecimiento=e.Codigo
    WHERE CodigoPrestacion IN (09215015) AND e.meta_san = 1 AND Mes BETWEEN 1 AND '.$ultimo_rem.'
    GROUP by e.Comuna, e.alias_estab, r.Mes
    ORDER BY e.Comuna, e.alias_estab, r.Mes';
$numeradores = DB::connection('mysql_rem')->select($sql_numerador);

foreach($numeradores as $registro) {
    if( ($flag1 != $registro->Comuna) OR ($flag2 != $registro->alias_estab) ) {
        foreach($meses as $mes) {
            $data3c2018[$registro->Comuna][$registro->alias_estab]['numeradores'][$mes] = 0;
        }
        $flag1 = $registro->Comuna;
        $flag2 = $registro->alias_estab;
    }
    $data3c2018[$registro->Comuna][$registro->alias_estab]['numeradores'][$registro->Mes] = $registro->numerador;
}

/* ===== Query denominador ===== */
$sql_denominador = "SELECT e.alias_estab, e.Comuna, COUNT(*) AS denominador
                    FROM percapita p
                    LEFT JOIN establecimientos e ON e.Codigo = p.COD_CENTRO
                    WHERE
                    FECHA_CORTE = '2017-08-31' AND
                    EDAD = 6 AND
                    ACEPTADO_RECHAZADO = 'ACEPTADO' AND e.meta_san = 1
                    GROUP BY e.Comuna, e.alias_estab
                    ORDER BY e.Comuna, e.alias_estab";
$denominadores = DB::connection('mysql_rem')->select($sql_denominador);



foreach($denominadores as $registro) {
    $data3c2018[$registro->Comuna][$registro->alias_estab]['denominador'] = $registro->denominador;
    $data3c2018[$registro->Comuna]['denominador'] += $registro->denominador;
}

$data3c2018['ALTO HOSPICIO']['denominador'] = 1641;
$data3c2018['ALTO HOSPICIO']['CES Pedro Pulgar']['denominador'] = 1641;
$data3c2018['ALTO HOSPICIO']['CECOSF El Boro']['denominador'] = 0;
$data3c2018['ALTO HOSPICIO']['CECOSF La Tortuga']['denominador'] = 0;

$data3c2018['CAMIÑA']['denominador'] = 18;
$data3c2018['CAMIÑA']['CGR Camiña']['denominador'] = 0;
$data3c2018['CAMIÑA']['Posta Rural Moquella']['denominador'] = 0;

$data3c2018['COLCHANE']['denominador'] = 12;
$data3c2018['COLCHANE']['CGR Colchane']['denominador'] = 0;
$data3c2018['COLCHANE']['Posta Rural Enquelga']['denominador'] = 0;
$data3c2018['COLCHANE']['Posta Rural Cariquima']['denominador'] = 0;

$data3c2018['HUARA']['denominador'] = 61;
$data3c2018['HUARA']['CGR Huara']['denominador'] = 0;
$data3c2018['HUARA']['Posta Rural Pisagua']['denominador'] = 0;
$data3c2018['HUARA']['Posta Rural Tarapacá']['denominador'] = 0;
$data3c2018['HUARA']['Posta Rural Chiapa']['denominador'] = 0;
$data3c2018['HUARA']['Posta Rural Sibaya']['denominador'] = 0;

$data3c2018['IQUIQUE']['denominador'] = 2622;
$data3c2018['IQUIQUE']['CESFAM Cirujano Aguirre']['denominador'] = 780;
$data3c2018['IQUIQUE']['CESFAM Cirujano Videla']['denominador'] = 702;
$data3c2018['IQUIQUE']['CESFAM Cirujano Guzmán']['denominador'] = 519;
$data3c2018['IQUIQUE']['CESFAM Sur Iquique']['denominador'] = 610;
$data3c2018['IQUIQUE']['Posta Rural Chanavayita']['denominador'] = 1;
$data3c2018['IQUIQUE']['Posta Rural San Marcos']['denominador'] = 1;
$data3c2018['IQUIQUE']['CECOSF Cerro Esmeralda']['denominador'] = 9;

$data3c2018['PICA']['denominador'] = 99;
$data3c2018['PICA']['CESFAM Pica']['denominador'] = 99;
$data3c2018['PICA']['Posta Rural Cancosa']['denominador'] = 0;
$data3c2018['PICA']['Posta Rural Matilla']['denominador'] = 0;

$data3c2018['POZO ALMONTE']['denominador'] = 222;
$data3c2018['POZO ALMONTE']['CGR Pozo Almonte']['denominador'] = 222;
$data3c2018['POZO ALMONTE']['Posta Rural Mamiña']['denominador'] = 0;
$data3c2018['POZO ALMONTE']['Posta Rural La Tirana']['denominador'] = 0;
$data3c2018['POZO ALMONTE']['Posta Rural La Huayca']['denominador'] = 0;

/* ==== Calculos ==== */
foreach($data3c2018 as $nombre_comuna => $comuna) {
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
                $data3c2018[$nombre_comuna][$nombre_establecimiento]['numeradores']['total'] = array_sum($establecimiento['numeradores']);
                //$data3c2018[$nombre_comuna][$nombre_establecimiento]['denominadores']['total'] = array_sum($establecimiento['denominadores']);
            }

            /* Calcula los totales de cada comuna */
            $data3c2018[$nombre_comuna]['numeradores']['total'] += $data3c2018[$nombre_comuna][$nombre_establecimiento]['numeradores']['total'];
            //$data3c2018[$nombre_comuna]['denominadores']['total'] += $data3c2018[$nombre_comuna][$nombre_establecimiento]['denominadores']['total'];

            /* Calcula la suma mensual por comuna */
            foreach($meses as $mes){
                $data3c2018[$nombre_comuna]['numeradores'][$mes] += $establecimiento['numeradores'][$mes];
                //$data3c2018[$nombre_comuna]['denominadores'][$mes] += $establecimiento['denominadores'][$mes];
            }

            /* Calculo de las metas de cada establecimiento */
            if($data3c2018[$nombre_comuna][$nombre_establecimiento]['denominador'] == 0) {
                /* Si es 0 el denominadore entonces la cumplimiento es 0 */
                $data3c2018[$nombre_comuna][$nombre_establecimiento]['cumplimiento'] = 0;
            }
            else {
                /* De lo contrario calcular el porcentaje */
                $data3c2018[$nombre_comuna][$nombre_establecimiento]['cumplimiento'] =
                    $data3c2018[$nombre_comuna][$nombre_establecimiento]['numeradores']['total'] / $data3c2018[$nombre_comuna][$nombre_establecimiento]['denominador'] * 100;
            }

            /* Calculo de las metas de la comuna */
            if($data3c2018[$nombre_comuna]['denominador'] == 0) {
                /* Si es 0 el denominadore entonces la cumplimiento es 0 */
                $data3c2018[$nombre_comuna]['cumplimiento'] = 0;
            }
            else {
                /* De lo contrario calcular el porcentaje */
                $data3c2018[$nombre_comuna]['cumplimiento'] = $data3c2018[$nombre_comuna]['numeradores']['total'] / $data3c2018[$nombre_comuna]['denominador'] * 100;
            }
        }
    }
}

//INDICADOR 4A
//2019

$year = 2018;
$label['meta'] = 'Porcentaje de cobertura efectiva de personas con Diabetes Mellitus Tipo 2.';
$label['numerador'] = 'Nº personas con DM2 de 15 a 79 años con Hb A1c <7% más N° personas con DM2 de 80 y más años con Hb A1c <8% según último control vigente.';
$label['denominador'] = 'Total de personas con DM2 de 15 y más años estimadas según prevalencia. **';

$data4a2018 = array();

$sql_establecimientos = "SELECT comuna, alias_estab
                         FROM establecimientos
                         WHERE meta_san = 1
                         ORDER BY comuna;";

$establecimientos = DB::connection('mysql_rem')->select($sql_establecimientos);

/* ==== Inicializar en 0 el arreglo de datos $data4a2018 ==== */
foreach($establecimientos as $establecimiento) {
    $data4a2018[$establecimiento->comuna]['numerador'] = 0;
    $data4a2018[$establecimiento->comuna]['numerador_6'] = 0;
    $data4a2018[$establecimiento->comuna]['denominador'] = 0;
    $data4a2018[$establecimiento->comuna]['meta'] = 0;
    $data4a2018[$establecimiento->comuna]['cumplimiento'] = 0;
    $data4a2018[$establecimiento->comuna][$establecimiento->alias_estab]['numerador'] = 0;
    $data4a2018[$establecimiento->comuna][$establecimiento->alias_estab]['numerador_6'] = 0;
    $data4a2018[$establecimiento->comuna][$establecimiento->alias_estab]['denominador'] = 0;
    $data4a2018[$establecimiento->comuna][$establecimiento->alias_estab]['meta'] = 0;
    $data4a2018[$establecimiento->comuna][$establecimiento->alias_estab]['cumplimiento'] = 0;
}

$data4a2018['ALTO HOSPICIO']['meta'] = '15%';
$data4a2018['CAMIÑA']['meta'] = '25 Pctes';
$data4a2018['COLCHANE']['meta'] = '12 Pctes';
$data4a2018['HUARA']['meta'] = '20%';
$data4a2018['IQUIQUE']['meta'] = '32%';
$data4a2018['PICA']['meta'] = '43%';
$data4a2018['POZO ALMONTE']['meta'] = '30%';

/* ===== Query numerador ===== */
$sql_numerador =
"SELECT e.Comuna, e.alias_estab, r.Mes, sum(ifnull(Col01,0)) as numerador
    FROM ".$year."rems r
    LEFT JOIN establecimientos e ON r.IdEstablecimiento=e.Codigo
    WHERE
    e.meta_san = 1 AND Ano = 2018 AND (Mes = 6 OR Mes = 12) AND
    CodigoPrestacion IN ('P4180300','P4200200')
    GROUP by e.Comuna, e.alias_estab, r.Mes
    ORDER BY e.Comuna, e.alias_estab, r.Mes";

$numeradores = DB::connection('mysql_rem')->select($sql_numerador);

foreach($numeradores as $registro) {
    if($registro->Mes == 6) {
        $data4a2018[$registro->Comuna]['numerador_6'] += $registro->numerador;
        $data4a2018[$registro->Comuna][$registro->alias_estab]['numerador_6'] = $registro->numerador;
    }
    if($registro->Mes == 12){
        $data4a2018[$registro->Comuna]['numerador'] += $registro->numerador;
        $data4a2018[$registro->Comuna][$registro->alias_estab]['numerador'] = $registro->numerador;
    }
}

//echo '<pre>'; print_r($data4a2018); die();
/* ===== Query denominador ===== */
$sql_denominador = "SELECT alias_estab, Comuna, SUM(denominador) as denominador
                    FROM
                    (
                      (SELECT e.alias_estab, e.Comuna, COUNT(*)*0.1 AS denominador
                        FROM percapita p
                        LEFT JOIN establecimientos e ON e.Codigo = p.COD_CENTRO
                        WHERE
                            e.meta_san = 1 AND
                        FECHA_CORTE = '2017-08-31' AND
                        EDAD BETWEEN 15 AND 64 AND
                        ACEPTADO_RECHAZADO = 'ACEPTADO'
                        GROUP BY e.Comuna, e.alias_estab
                        ORDER BY e.Comuna, e.alias_estab)

                      UNION

                      (SELECT e.alias_estab, e.Comuna, COUNT(*)*0.25 AS denominador
                        FROM percapita p
                        LEFT JOIN establecimientos e ON e.Codigo = p.COD_CENTRO
                        WHERE
                            e.meta_san = 1 AND
                        FECHA_CORTE = '2017-08-31' AND
                        EDAD >= 65 AND
                        ACEPTADO_RECHAZADO = 'ACEPTADO'
                        GROUP BY e.Comuna, e.alias_estab
                        ORDER BY e.Comuna, e.alias_estab)
                    ) tmp
                    group by tmp.Comuna, tmp.alias_estab
                    order by tmp.Comuna, tmp.alias_estab";

$denominadores = DB::connection('mysql_rem')->select($sql_denominador);

foreach($denominadores as $registro) {
    $data4a2018[$registro->Comuna]['denominador'] += $registro->denominador;
    $data4a2018[$registro->Comuna][$registro->alias_estab]['denominador'] = $registro->denominador;
}

/* Según Paula, esto ya no va */
$data4a2018['CAMIÑA']['denominador'] = 25;
$data4a2018['CAMIÑA']['CGR Camiña']['denominador'] = 25;
$data4a2018['COLCHANE']['denominador'] = 12;

// $data4a2018['CAMIÑA']['denominador'] = 140;
// $data4a2018['CAMIÑA']['CGR Camiña']['denominador'] = 0;
// $data4a2018['CAMIÑA']['Posta Rural Moquella']['denominador'] = 0;
//
//
// $data4a2018['COLCHANE']['denominador'] = 101;
// $data4a2018['COLCHANE']['CGR Colchane']['denominador'] = 0;
// $data4a2018['COLCHANE']['Posta Rural Enquelga']['denominador'] = 0;
// $data4a2018['COLCHANE']['Posta Rural Cariquima']['denominador'] = 0;
//
$data4a2018['HUARA']['denominador'] = 231;
$data4a2018['HUARA']['CGR Huara']['denominador'] = 0;
$data4a2018['HUARA']['Posta Rural Pisagua']['denominador'] = 0;
$data4a2018['HUARA']['Posta Rural Tarapacá']['denominador'] = 0;
$data4a2018['HUARA']['Posta Rural Chiapa']['denominador'] = 0;
$data4a2018['HUARA']['Posta Rural Sibaya']['denominador'] = 0;

/* ==== Calculos ==== */
foreach($data4a2018 as $nombre_comuna => $comuna) {
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
            if($data4a2018[$nombre_comuna][$nombre_establecimiento]['denominador'] == 0) {
                /* Si es 0 el denominador entonces la meta es 0 */
                $data4a2018[$nombre_comuna][$nombre_establecimiento]['cumplimiento'] = 0;
            }
            else {
                /* De lo contrario calcular el porcentaje */
                $data4a2018[$nombre_comuna][$nombre_establecimiento]['cumplimiento'] =
                    $data4a2018[$nombre_comuna][$nombre_establecimiento]['numerador'] / $data4a2018[$nombre_comuna][$nombre_establecimiento]['denominador'] * 100;
            }

            /* Fija la meta de la comuna también a sus establecimientos */
            $data4a2018[$nombre_comuna][$nombre_establecimiento]['meta'] = $data4a2018[$nombre_comuna]['meta'];

            /* Calculo de las metas de la comuna */
            if($data4a2018[$nombre_comuna]['denominador'] == 0) {
                /* Si es 0 el denominadore entonces la meta es 0 */
                $data4a2018[$nombre_comuna]['cumplimiento'] = 0;
            }
            else {
                /* De lo contrario calcular el porcentaje */
                $data4a2018[$nombre_comuna]['cumplimiento'] = $data4a2018[$nombre_comuna]['numerador'] / $data4a2018[$nombre_comuna]['denominador'] * 100;
            }
        }
    }
}

$year = 2018;
$label['meta'] = 'Porcentaje de personas con diabetes de 15 años y más con evaluación anual de pie.';
$label['numerador'] = 'N° de personas con diabetes bajo control de 15 y más años con una evaluación de pie vigente.';
$label['denominador'] = 'N° total de personas diabéticas de 15 y más años bajo control al corte. **';

$data4b2018 = array();

$sql_establecimientos = "SELECT comuna, alias_estab
                         FROM establecimientos
                         WHERE meta_san = 1
                         ORDER BY comuna;";

$establecimientos = DB::connection('mysql_rem')->select($sql_establecimientos);

/* ==== Inicializar en 0 el arreglo de datos $data4b2018 ==== */
foreach($establecimientos as $establecimiento) {
    /*$data4b2018[$establecimiento->comuna]['numerador'] = 0;
    $data4b2018[$establecimiento->comuna]['denominador'] = 0;
    $data4b2018[$establecimiento->comuna]['meta'] = 0;
    $data4b2018[$establecimiento->comuna]['cumplimiento'] = 0;
    $data4b2018[$establecimiento->comuna][$establecimiento->alias_estab]['numerador'] = 0;
    $data4b2018[$establecimiento->comuna][$establecimiento->alias_estab]['denominador'] = 0;
    $data4b2018[$establecimiento->comuna][$establecimiento->alias_estab]['meta'] = 0;
    $data4b2018[$establecimiento->comuna][$establecimiento->alias_estab]['cumplimiento'] = 0;*/

    $data4b2018[$establecimiento->comuna]['numerador'] = 0;
    $data4b2018[$establecimiento->comuna]['numerador_6'] = 0;
    $data4b2018[$establecimiento->comuna]['denominador'] = 0;
    $data4b2018[$establecimiento->comuna]['denominador_6'] = 0;
    $data4b2018[$establecimiento->comuna]['meta'] = 0;
    $data4b2018[$establecimiento->comuna]['cumplimiento'] = 0;
    $data4b2018[$establecimiento->comuna][$establecimiento->alias_estab]['numerador'] = 0;
    $data4b2018[$establecimiento->comuna][$establecimiento->alias_estab]['numerador_6'] = 0;
    $data4b2018[$establecimiento->comuna][$establecimiento->alias_estab]['denominador'] = 0;
    $data4b2018[$establecimiento->comuna][$establecimiento->alias_estab]['denominador_6'] = 0;
    $data4b2018[$establecimiento->comuna][$establecimiento->alias_estab]['meta'] = 0;
    $data4b2018[$establecimiento->comuna][$establecimiento->alias_estab]['cumplimiento'] = 0;
}

$data4b2018['ALTO HOSPICIO']['meta'] = '90%';
$data4b2018['CAMIÑA']['meta'] = '91%';
$data4b2018['COLCHANE']['meta'] = '95%';
$data4b2018['HUARA']['meta'] = '90%';
$data4b2018['IQUIQUE']['meta'] = '93%';
$data4b2018['PICA']['meta'] = '90%';
$data4b2018['POZO ALMONTE']['meta'] = '90%';

/* ===== Query numerador ===== */
$sql_numerador =
"SELECT e.Comuna, e.alias_estab, r.Mes, sum(ifnull(Col01,0)) as numerador
    FROM ".$year."rems r
    LEFT JOIN establecimientos e ON r.IdEstablecimiento=e.Codigo
    WHERE
    e.meta_san = 1 AND Ano = 2018 AND (Mes = 6 OR Mes = 12) AND
    CodigoPrestacion IN ('P4190809','P4170300','P4190500','P4190600')
    GROUP by e.Comuna, e.alias_estab, r.Mes
    ORDER BY e.Comuna, e.alias_estab, r.Mes";

$numeradores = DB::connection('mysql_rem')->select($sql_numerador);

foreach($numeradores as $registro) {
    /*$data4b2018[$registro->Comuna]['numerador'] += $registro->numerador;
    $data4b2018[$registro->Comuna][$registro->alias_estab]['numerador'] = $registro->numerador;*/

    if($registro->Mes == 6) {
        $data4b2018[$registro->Comuna]['numerador_6'] += $registro->numerador;
        $data4b2018[$registro->Comuna][$registro->alias_estab]['numerador_6'] = $registro->numerador;
    }
    if($registro->Mes == 12){
        $data4b2018[$registro->Comuna]['numerador'] += $registro->numerador;
        $data4b2018[$registro->Comuna][$registro->alias_estab]['numerador'] = $registro->numerador;
    }
}

/* ===== Query denominador ===== */
$sql_denominador =
"SELECT e.Comuna, e.alias_estab, r.Mes, sum(ifnull(Col01,0)) as denominador
    FROM ".$year."rems r
    LEFT JOIN establecimientos e ON r.IdEstablecimiento=e.Codigo
    WHERE
    e.meta_san = 1 AND Ano = 2018 AND (Mes = 6 OR Mes = 12) AND
    CodigoPrestacion IN ('P4150602')
    GROUP by e.Comuna, e.alias_estab, r.Mes
    ORDER BY e.Comuna, e.alias_estab, r.Mes";

$denomidores = DB::connection('mysql_rem')->select($sql_denominador);

foreach($denomidores as $registro) {
    /*$data4b2018[$registro->Comuna]['denominador'] += $registro->denominador;
    $data4b2018[$registro->Comuna][$registro->alias_estab]['denominador'] = $registro->denominador;*/

    if($registro->Mes == 6) {
        $data4b2018[$registro->Comuna]['denominador_6'] += $registro->denominador;
        $data4b2018[$registro->Comuna][$registro->alias_estab]['denominador_6'] = $registro->denominador;
    }
    if($registro->Mes == 12){
        $data4b2018[$registro->Comuna]['denominador'] += $registro->denominador;
        $data4b2018[$registro->Comuna][$registro->alias_estab]['denominador'] = $registro->denominador;
    }
}


/* ==== Calculos ==== */
foreach($data4b2018 as $nombre_comuna => $comuna) {
    foreach($comuna as $nombre_establecimiento => $establecimiento) {
        /* Existe en el array un indice ['numerador'], ['denominador'] y ['meta'],
         * estos almacenan la información de la comuna, por lo tanto tengo que saltarlos
         * en la iteración del foreach y continuar con los establecimientos */
        /* Realizar los calculos mensuales */
        if($nombre_establecimiento != 'numerador' AND
            $nombre_establecimiento != 'numerador_6' AND
            $nombre_establecimiento != 'denominador' AND
            $nombre_establecimiento != 'denominador_6' AND
            $nombre_establecimiento != 'meta' AND
            $nombre_establecimiento != 'cumplimiento'){

            /* Calculo de las metas de cada establecimiento */
            if($data4b2018[$nombre_comuna][$nombre_establecimiento]['denominador'] == 0) {
                /* Si es 0 el denominadore entonces la meta es 0 */
                $data4b2018[$nombre_comuna][$nombre_establecimiento]['cumplimiento'] = 0;
            }
            else {
                /* De lo contrario calcular el porcentaje */
                $data4b2018[$nombre_comuna][$nombre_establecimiento]['cumplimiento'] =
                    $data4b2018[$nombre_comuna][$nombre_establecimiento]['numerador'] / $data4b2018[$nombre_comuna][$nombre_establecimiento]['denominador'] * 100;
            }

            /* Fija la meta de la comuna también a sus establecimientos */
            $data4b2018[$nombre_comuna][$nombre_establecimiento]['meta'] = $data4b2018[$nombre_comuna]['meta'];

            /* Calculo de las metas de la comuna */
            if($data4b2018[$nombre_comuna]['denominador'] == 0) {
                /* Si es 0 el denominadore entonces la meta es 0 */
                $data4b2018[$nombre_comuna]['cumplimiento'] = 0;
            }
            else {
                /* De lo contrario calcular el porcentaje */
                $data4b2018[$nombre_comuna]['cumplimiento'] = $data4b2018[$nombre_comuna]['numerador'] / $data4b2018[$nombre_comuna]['denominador'] * 100;
            }
        }
    }
}

//INDICADOR 5
//2018

$year = 2018;
$label['meta'] = 'Porcentaje de personas mayores de 15 años y más con cobertura efectiva de hipertensión arterial.';
$label['numerador'] = 'N° Personas hipertensas de 15 a 79 años con PA<140/90 mmHg más N° personas hipertensas de 80 y más años con PA<150/90 mmHg, según último control vigente.';
$label['denominador'] = 'N° total de personas hipertensas de 15 y más años estimadas según prevalencia (últimos 12 meses).';

$data52018 = array();

$sql_establecimientos = "SELECT comuna, alias_estab
                         FROM establecimientos
                         WHERE meta_san = 1
                         ORDER BY comuna;";

$establecimientos = DB::connection('mysql_rem')->select($sql_establecimientos);

/* ==== Inicializar en 0 el arreglo de datos $data52018 ==== */
foreach($establecimientos as $establecimiento) {
    $data52018[$establecimiento->comuna]['numerador'] = 0;
    $data52018[$establecimiento->comuna]['numerador_6'] = 0;
    $data52018[$establecimiento->comuna]['denominador'] = 0;
    $data52018[$establecimiento->comuna]['meta'] = 0;
    $data52018[$establecimiento->comuna]['cumplimiento'] = 0;
    $data52018[$establecimiento->comuna][$establecimiento->alias_estab]['numerador'] = 0;
    $data52018[$establecimiento->comuna][$establecimiento->alias_estab]['numerador_6'] = 0;
    $data52018[$establecimiento->comuna][$establecimiento->alias_estab]['denominador'] = 0;
    $data52018[$establecimiento->comuna][$establecimiento->alias_estab]['meta'] = 0;
    $data52018[$establecimiento->comuna][$establecimiento->alias_estab]['cumplimiento'] = 0;
}

$data52018['ALTO HOSPICIO']['meta'] = '21%';
$data52018['CAMIÑA']['meta'] = '71 Pctes';
$data52018['COLCHANE']['meta'] = '25 Pctes';
$data52018['HUARA']['meta'] = '26%';
$data52018['IQUIQUE']['meta'] = '55%';
$data52018['PICA']['meta'] = '49%';
$data52018['POZO ALMONTE']['meta'] = '51%';

/* ===== Query numerador ===== */
$sql_numerador =
"SELECT e.Comuna, e.alias_estab, r.Mes, sum(ifnull(Col01,0)) as numerador
    FROM ".$year."rems r
    LEFT JOIN establecimientos e ON r.IdEstablecimiento=e.Codigo
    WHERE
    e.meta_san = 1 AND Ano = 2018 AND (Mes = 6 OR Mes = 12) AND
    CodigoPrestacion IN ('P4180200','P4200100')
    GROUP by e.Comuna, e.alias_estab, r.Mes
    ORDER BY e.Comuna, e.alias_estab, r.Mes";

$numeradores = DB::connection('mysql_rem')->select($sql_numerador);

foreach($numeradores as $registro) {
    /*$data52018[$registro->Comuna]['numerador'] += $registro->numerador;
    $data52018[$registro->Comuna][$registro->alias_estab]['numerador'] = $registro->numerador;*/

    if($registro->Mes == 6) {
        $data52018[$registro->Comuna]['numerador_6'] += $registro->numerador;
        $data52018[$registro->Comuna][$registro->alias_estab]['numerador_6'] = $registro->numerador;
    }
    if($registro->Mes == 12){
        $data52018[$registro->Comuna]['numerador'] += $registro->numerador;
        $data52018[$registro->Comuna][$registro->alias_estab]['numerador'] = $registro->numerador;
    }
}

/* ===== Query denominador ===== */
$sql_denominador = "SELECT alias_estab, Comuna, SUM(denominador) as denominador
                    FROM
                    (
                      (SELECT e.alias_estab, e.Comuna, COUNT(*)*0.157 AS denominador
                        FROM percapita p
                        LEFT JOIN establecimientos e ON e.Codigo = p.COD_CENTRO
                        WHERE
                        FECHA_CORTE = '2017-08-31' AND
                        EDAD BETWEEN 15 AND 64 AND
                        ACEPTADO_RECHAZADO = 'ACEPTADO' AND e.meta_san = 1
                        GROUP BY e.Comuna, e.alias_estab
                        ORDER BY e.Comuna, e.alias_estab)

                      UNION

                      (SELECT e.alias_estab, e.Comuna, COUNT(*)*0.643 AS denominador
                        FROM percapita p
                        LEFT JOIN establecimientos e ON e.Codigo = p.COD_CENTRO
                        WHERE
                        FECHA_CORTE = '2017-08-31' AND
                        EDAD >= 65 AND
                        ACEPTADO_RECHAZADO = 'ACEPTADO' AND e.meta_san = 1
                        GROUP BY e.Comuna, e.alias_estab
                        ORDER BY e.Comuna, e.alias_estab)
                    ) tmp
                    group by tmp.Comuna, tmp.alias_estab
                    order by tmp.Comuna, tmp.alias_estab";

$denominadores = DB::connection('mysql_rem')->select($sql_denominador);

foreach($denominadores as $registro) {
    $data52018[$registro->Comuna]['denominador'] += $registro->denominador;
    $data52018[$registro->Comuna][$registro->alias_estab]['denominador'] = $registro->denominador;
}

$data52018['CAMIÑA']['denominador'] = 71;
$data52018['CAMIÑA']['CGR Camiña']['denominador'] = 0;
$data52018['CAMIÑA']['Posta Rural Moquella']['denominador'] = 0;

$data52018['COLCHANE']['denominador'] = 25;
$data52018['COLCHANE']['CGR Colchane']['denominador'] = 0;
$data52018['COLCHANE']['Posta Rural Enquelga']['denominador'] = 0;
$data52018['COLCHANE']['Posta Rural Cariquima']['denominador'] = 0;

$data52018['HUARA']['denominador'] = 450;
$data52018['HUARA']['CGR Huara']['denominador'] = 0;
$data52018['HUARA']['Posta Rural Pisagua']['denominador'] = 0;
$data52018['HUARA']['Posta Rural Tarapacá']['denominador'] = 0;
$data52018['HUARA']['Posta Rural Chiapa']['denominador'] = 0;
$data52018['HUARA']['Posta Rural Sibaya']['denominador'] = 0;

/* ==== Calculos ==== */
foreach($data52018 as $nombre_comuna => $comuna) {
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
            if($data52018[$nombre_comuna][$nombre_establecimiento]['denominador'] == 0) {
                /* Si es 0 el denominadore entonces la meta es 0 */
                $data52018[$nombre_comuna][$nombre_establecimiento]['cumplimiento'] = 0;
            }
            else {
                /* De lo contrario calcular el porcentaje */
                $data52018[$nombre_comuna][$nombre_establecimiento]['cumplimiento'] =
                    $data52018[$nombre_comuna][$nombre_establecimiento]['numerador'] / $data52018[$nombre_comuna][$nombre_establecimiento]['denominador'] * 100;
            }

            /* Fija la meta de la comuna también a sus establecimientos */
            $data52018[$nombre_comuna][$nombre_establecimiento]['meta'] = $data52018[$nombre_comuna]['meta'];

            /* Calculo de las metas de la comuna */
            if($data52018[$nombre_comuna]['denominador'] == 0) {
                /* Si es 0 el denominadore entonces la meta es 0 */
                $data52018[$nombre_comuna]['cumplimiento'] = 0;
            }
            else {
                /* De lo contrario calcular el porcentaje */
                $data52018[$nombre_comuna]['cumplimiento'] = $data52018[$nombre_comuna]['numerador'] / $data52018[$nombre_comuna]['denominador'] * 100;
            }
        }
    }
}

$year = 2018;
/* Numerador = A0200002	LACTANCIA MATERNA EN MENORES CONTROLADOS - TIPO DE ALIMENTACIÓN - LACTANCIA MATERNA EXCLUSIVA
   Denominador = A0200001	LACTANCIA MATERNA EN MENORES CONTROLADOS - TIPO DE ALIMENTACIÓN - MENORES CONTROLADOS
*/
$label['meta'] = 'Porcentaje de niños y niñas que al sexto mes de vida, cuentan con lactancia materna exclusiva.';
$label['numerador'] = 'N° de niños/as que al control de salud del sexto mes recibieron LME en el periodo de enero-diciembre 2018.';
$label['denominador'] = 'N° de niños/as con control de salud del sexto mes realizado en el periodo de enero-diciembre 2018.';

$meses = array(1,2,3,4,5,6,7,8,9,10,11,12);
$flag1 = NULL;
$flag2 = NULL;
$data62018 = array();

$sql_establecimientos =
'SELECT comuna, alias_estab
 FROM establecimientos
 WHERE meta_san = 1
 ORDER BY comuna;';

$establecimientos = DB::connection('mysql_rem')->select($sql_establecimientos);

/* ==== Inicializar en 0 el arreglo de datos $data62018 ==== */
foreach($establecimientos as $establecimiento) {
    $data62018[$establecimiento->comuna]['numeradores']['total'] = 0;
    $data62018[$establecimiento->comuna]['denominadores']['total'] = 0;
    $data62018[$establecimiento->comuna]['cumplimiento'] = 0;
    foreach($meses as $mes) {
        $data62018[$establecimiento->comuna]['numeradores'][$mes] = 0;
        $data62018[$establecimiento->comuna]['denominadores'][$mes] = 0;
        $data62018[$establecimiento->comuna][$establecimiento->alias_estab]['numeradores']['total'] = 0;
        $data62018[$establecimiento->comuna][$establecimiento->alias_estab]['denominadores']['total'] = 0;
        $data62018[$establecimiento->comuna][$establecimiento->alias_estab]['numeradores'][$mes] = 0;
        $data62018[$establecimiento->comuna][$establecimiento->alias_estab]['denominadores'][$mes] = 0;
    }
    $data62018[$establecimiento->comuna][$establecimiento->alias_estab]['cumplimiento'] = 0;
}

$data62018['ALTO HOSPICIO']['meta'] = '60%';
$data62018['CAMIÑA']['meta'] = '70%';
$data62018['COLCHANE']['meta'] = '60%';
$data62018['HUARA']['meta'] = '62%';
$data62018['IQUIQUE']['meta'] = '62%';
$data62018['PICA']['meta'] = '60%';
$data62018['POZO ALMONTE']['meta'] = '58%';

/* ===== Query numerador ===== */
$sql_numerador = 'SELECT e.Comuna, e.alias_estab, r.Mes, (ifnull(Col08,0) + ifnull(Col09,0)) as numerador
    FROM '.$year.'rems r
    LEFT JOIN establecimientos e
    ON r.IdEstablecimiento=e.Codigo
    WHERE CodigoPrestacion = "A0200002" AND e.meta_san = 1 AND Mes BETWEEN 1 AND '.$ultimo_rem.'
    ORDER BY e.Comuna, e.alias_estab, r.Mes';
$numeradores = DB::connection('mysql_rem')->select($sql_numerador);

foreach($numeradores as $registro) {
    if( ($flag1 != $registro->Comuna) OR ($flag2 != $registro->alias_estab) ) {
        foreach($meses as $mes) {
            $data62018[$registro->Comuna][$registro->alias_estab]['numeradores'][$mes] = 0;
        }
        $flag1 = $registro->Comuna;
        $flag2 = $registro->alias_estab;
    }
    $data62018[$registro->Comuna][$registro->alias_estab]['numeradores'][$registro->Mes] = $registro->numerador;
}

/* ===== Query denominador ===== */
$sql_denominador = 'SELECT e.Comuna, e.alias_estab, r.Mes, (ifnull(Col08,0) + ifnull(Col09,0)) as denominador
    FROM '.$year.'rems r
    LEFT JOIN establecimientos e
    ON r.IdEstablecimiento=e.Codigo
    WHERE CodigoPrestacion = "A0200001" AND e.meta_san = 1 AND Mes BETWEEN 1 AND '.$ultimo_rem.'
    ORDER BY e.Comuna, e.alias_estab, r.Mes';
$denominadores = DB::connection('mysql_rem')->select($sql_denominador);

foreach($denominadores as $registro) {
    if( ($flag1 != $registro->Comuna) OR ($flag2 != $registro->alias_estab) ) {
        foreach($meses as $mes) {
            $data62018[$registro->Comuna][$registro->alias_estab]['denominadores'][$mes] = 0;
        }
        $flag1 = $registro->Comuna;
        $flag2 = $registro->alias_estab;
    }
    $data62018[$registro->Comuna][$registro->alias_estab]['denominadores'][$registro->Mes] = $registro->denominador;
}

/* ==== Calculos ==== */
foreach($data62018 as $nombre_comuna => $comuna) {
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
            $data62018[$nombre_comuna][$nombre_establecimiento]['denominadores']['total'] = array_sum($establecimiento['denominadores']);
            $data62018[$nombre_comuna][$nombre_establecimiento]['numeradores']['total'] = array_sum($establecimiento['numeradores']);

            /* Calcula los totales de cada comuna */
            $data62018[$nombre_comuna]['numeradores']['total'] += $data62018[$nombre_comuna][$nombre_establecimiento]['numeradores']['total'];
            $data62018[$nombre_comuna]['denominadores']['total'] += $data62018[$nombre_comuna][$nombre_establecimiento]['denominadores']['total'];

            /* Calcula la suma mensual por comuna */
            foreach($meses as $mes){
                $data62018[$nombre_comuna]['numeradores'][$mes] += $establecimiento['numeradores'][$mes];
                $data62018[$nombre_comuna]['denominadores'][$mes] += $establecimiento['denominadores'][$mes];
            }

            /* Calculo de las metas de cada establecimiento */
            if($data62018[$nombre_comuna][$nombre_establecimiento]['denominadores']['total'] == 0) {
                /* Si es 0 el denominadore entonces la cumplimiento es 0 */
                $data62018[$nombre_comuna][$nombre_establecimiento]['cumplimiento'] = 0;
            }
            else {
                /* De lo contrario calcular el porcentaje */
                $data62018[$nombre_comuna][$nombre_establecimiento]['cumplimiento'] = $data62018[$nombre_comuna][$nombre_establecimiento]['numeradores']['total'] / $data62018[$nombre_comuna][$nombre_establecimiento]['denominadores']['total'] * 100;
            }

            /* Calculo de las metas de la comuna */
            if($data62018[$nombre_comuna]['denominadores']['total'] == 0) {
                /* Si es 0 el denominadore entonces la cumplimiento es 0 */
                $data62018[$nombre_comuna]['cumplimiento'] = 0;
            }
            else {
                /* De lo contrario calcular el porcentaje */
                $data62018[$nombre_comuna]['cumplimiento'] = $data62018[$nombre_comuna]['numeradores']['total'] / $data62018[$nombre_comuna]['denominadores']['total'] * 100;
            }
        }
    }
}
