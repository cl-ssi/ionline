<?php
namespace App\Http\Controllers\Indicators\_2020;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\Indicators\SingleParameter;

$year = 2020;

$sql_ultimo_rem = "SELECT MAX(Mes) as ultimo_rem FROM 2020rems;";
$ultimo_rem = DB::connection('mysql_rem')->select($sql_ultimo_rem)[0]->ultimo_rem;

$label['meta'] = 'Reducir la Brecha de cobertura de PAP vigente en mujeres de 25 a 64 años.';
$label['numerador'] = 'Nº de mujeres de 25 a 64 años inscritas validadas, con PAP vigente a diciembre 2020 *100.';
$label['denominador'] = 'Nº total de mujeres de 25 a 64 años inscritas validadas.';

$data22020 = array();

$sql_establecimientos = "SELECT Codigo AS codigo, alias_estab AS nombre, comuna
                         FROM 2020establecimientos
                         WHERE meta_san = 1
                         ORDER BY comuna;";

$establecimientos = DB::connection('mysql_rem')->select($sql_establecimientos);


$data22020['ALTO HOSPICIO']['meta'] = '47%';
$data22020['CAMIÑA']['meta'] = '88%';
$data22020['COLCHANE']['meta'] = '72%';
$data22020['HUARA']['meta'] = '66%';
$data22020['IQUIQUE']['meta'] = '53%';
$data22020['PICA']['meta'] = '60%';
$data22020['POZO ALMONTE']['meta'] = '59%';

/* ==== Inicializar en 0 el arreglo de datos $data22020 ==== */
foreach($establecimientos as $establecimiento) {
    $data22020[$establecimiento->comuna]['numerador'] = 0;
    $data22020[$establecimiento->comuna]['establecimientos'][$establecimiento->nombre]['numerador'] = 0;

    $data22020[$establecimiento->comuna]['numerador_6'] = 0;
    $data22020[$establecimiento->comuna]['establecimientos'][$establecimiento->nombre]['numerador_6'] = 0;

    $data22020[$establecimiento->comuna]['numerador_12'] = 0;
    $data22020[$establecimiento->comuna]['establecimientos'][$establecimiento->nombre]['numerador_12'] = 0;

    $data22020[$establecimiento->comuna]['denominador'] = 0;
    $data22020[$establecimiento->comuna]['establecimientos'][$establecimiento->nombre]['denominador'] = 0;

    $data22020[$establecimiento->comuna]['cumplimiento'] = 0;
    $data22020[$establecimiento->comuna]['establecimientos'][$establecimiento->nombre]['cumplimiento'] = 0;

    $data22020[$establecimiento->comuna]['establecimientos'][$establecimiento->nombre]['meta'] = $data22020[$establecimiento->comuna]['meta'];
}

/* Sólo si está cargado sobre el rem de Junio */
// if($ultimo_rem >= ) {

    /* ===== Query numerador ===== */
    $sql_numerador =
        "SELECT e.Comuna AS comuna, e.alias_estab AS nombre, r.Mes AS mes, sum(ifnull(Col01,0)) as numerador
        FROM {$year}rems r
        LEFT JOIN 2020establecimientos e ON r.IdEstablecimiento=e.Codigo
        WHERE
        e.meta_san = 1 AND Ano = {$year} AND (Mes = 6 OR Mes = 12) AND
        CodigoPrestacion IN ('P1206010','P1206020','P1206030','P1206040','P1206050','P1206060','P1206070','P1206080')
        GROUP by e.Comuna, e.alias_estab, r.Mes
        ORDER BY e.Comuna, e.alias_estab, r.Mes";

    $numeradores = DB::connection('mysql_rem')->select($sql_numerador);

    foreach($numeradores as $registro) {
        if($registro->mes == 6) {
            $data22020[$registro->comuna]['numerador_6'] += $registro->numerador;
            $data22020[$registro->comuna]['establecimientos'][$registro->nombre]['numerador_6'] = $registro->numerador;
        }
        if($registro->mes == 12){
            $data22020[$registro->comuna]['numerador_12'] += $registro->numerador;
            $data22020[$registro->comuna]['establecimientos'][$registro->nombre]['numerador_12'] = $registro->numerador;
        }

        if($ultimo_rem < 12) {
            $data22020[$registro->comuna]['numerador'] = $data22020[$registro->comuna]['numerador_6'];
            $data22020[$registro->comuna]['establecimientos'][$registro->nombre]['numerador'] =
                $data22020[$registro->comuna]['establecimientos'][$registro->nombre]['numerador_6'];
        }
        else {
            $data22020[$registro->comuna]['numerador'] = $data22020[$registro->comuna]['numerador_12'];
            $data22020[$registro->comuna]['establecimientos'][$registro->nombre]['numerador'] =
                $data22020[$registro->comuna]['establecimientos'][$registro->nombre]['numerador_12'];
        }
    }




    /* ===== Query denominador ===== */
    $sql_denominador = "SELECT e.alias_estab as nombre, e.Comuna as comuna, COUNT(*) AS denominador
                        FROM 2020percapita p
                        LEFT JOIN 2020establecimientos e ON e.Codigo = p.COD_CENTRO
                        WHERE
                        FECHA_CORTE = '2019-08-31' AND
                        GENERO = 'F' AND
                        EDAD BETWEEN 25 AND 64 AND
                        ACEPTADO_RECHAZADO = 'ACEPTADO'
                        AND e.meta_san = 1
                        GROUP BY e.Comuna, e.alias_estab
                        ORDER BY e.Comuna, e.alias_estab";

    $denominadores = DB::connection('mysql_rem')->select($sql_denominador);

    foreach($denominadores as $registro) {
        $data22020[$registro->comuna]['denominador'] += $registro->denominador;
        $data22020[$registro->comuna]['establecimientos'][$registro->nombre]['denominador'] = $registro->denominador;
    }

    /* Poblaciones manuales (denominadores) */
    $data22020['CAMIÑA']['denominador'] = 327;
    $data22020['CAMIÑA']['establecimientos']['CGR Camiña']['denominador'] = 0;
    $data22020['CAMIÑA']['establecimientos']['Posta Rural Moquella']['denominador'] = 0;

    $data22020['COLCHANE']['denominador'] = 218;
    $data22020['COLCHANE']['establecimientos']['CGR Colchane']['denominador'] = 0;
    $data22020['COLCHANE']['establecimientos']['Posta Rural Enquelga']['denominador'] = 0;
    $data22020['COLCHANE']['establecimientos']['Posta Rural Cariquima']['denominador'] = 0;

    $data22020['HUARA']['denominador'] = 594;
    $data22020['HUARA']['establecimientos']['CGR Dr. Amador Neghme Rodríguez']['denominador'] = 0;
    $data22020['HUARA']['establecimientos']['Posta Rural Pisagua']['denominador'] = 0;
    $data22020['HUARA']['establecimientos']['Posta Rural Tarapacá']['denominador'] = 0;
    $data22020['HUARA']['establecimientos']['Posta Rural Chiapa']['denominador'] = 0;
    $data22020['HUARA']['establecimientos']['Posta Rural Sibaya']['denominador'] = 0;

    /* ==== Calculos ==== */
    foreach($data22020 as $nombre_comuna => $comuna) {
        /* Calculo de las metas de la comuna */
        if($data22020[$nombre_comuna]['denominador'] == 0) {
            /* Si es 0 el denominadore entonces la meta es 0 */
            $data22020[$nombre_comuna]['cumplimiento'] = 0;
        }
        else {
            $data22020[$nombre_comuna]['cumplimiento'] = 
                $data22020[$nombre_comuna]['numerador'] /
                $data22020[$nombre_comuna]['denominador'] * 100;
        }

        foreach($comuna['establecimientos'] as $nombre_establecimiento => $establecimiento) {
            /* Calculo de cumplimiento de cada establecimiento */
            if($establecimiento['denominador'] == 0) {
                /* Si es 0 el denominador entonces la meta es 0 */
                $data22020[$nombre_comuna]['establecimientos'][$nombre_establecimiento]['cumplimiento'] = 0;
            }
            else {
                $data22020[$nombre_comuna]['establecimientos'][$nombre_establecimiento]['cumplimiento'] = 
                    $data22020[$nombre_comuna]['establecimientos'][$nombre_establecimiento]['numerador'] /
                    $data22020[$nombre_comuna]['establecimientos'][$nombre_establecimiento]['denominador'] * 100;
            }
        }
    }
// }
