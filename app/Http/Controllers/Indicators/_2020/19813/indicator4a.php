<?php
namespace App\Http\Controllers\Indicators\_2020;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\Indicators\SingleParameter;

$year = 2020;

$sql_ultimo_rem = "SELECT MAX(Mes) as ultimo_rem FROM 2020rems;";
$ultimo_rem = DB::connection('mysql_rem')->select($sql_ultimo_rem)[0]->ultimo_rem;

$label['meta'] = 'Porcentaje de cobertura efectiva de personas con Diabetes Mellitus Tipo 2.';
$label['numerador'] = 'Nº personas con DM2 de 15 a 79 años con Hb A1c <7% más N° personas con DM2 de 80 y más años con Hb A1c <8% según último control vigente.*';
$label['denominador'] = 'Total de personas con DM2 de 15 y más años estimadas según prevalencia.**';

$data4a2020 = array();

$sql_establecimientos = "SELECT Codigo AS codigo, alias_estab AS nombre, comuna
                         FROM 2020establecimientos
                         WHERE meta_san = 1
                         ORDER BY comuna;";

$establecimientos = DB::connection('mysql_rem')->select($sql_establecimientos);

$data4a2020['ALTO HOSPICIO']['meta'] = '15%';
$data4a2020['CAMIÑA']['meta'] = '13%';
$data4a2020['COLCHANE']['meta'] = '6%';
$data4a2020['HUARA']['meta'] = '22%';
$data4a2020['IQUIQUE']['meta'] = '30%';
$data4a2020['PICA']['meta'] = '30%';
$data4a2020['POZO ALMONTE']['meta'] = '25%';

/* ==== Inicializar en 0 el arreglo de datos $data4a2020 ==== */
foreach($establecimientos as $establecimiento) {
    $data4a2020[$establecimiento->comuna]['numerador'] = 0;
    $data4a2020[$establecimiento->comuna]['establecimientos'][$establecimiento->nombre]['numerador'] = 0;

    $data4a2020[$establecimiento->comuna]['numerador_6'] = 0;
    $data4a2020[$establecimiento->comuna]['establecimientos'][$establecimiento->nombre]['numerador_6'] = 0;

    $data4a2020[$establecimiento->comuna]['numerador_12'] = 0;
    $data4a2020[$establecimiento->comuna]['establecimientos'][$establecimiento->nombre]['numerador_12'] = 0;

    $data4a2020[$establecimiento->comuna]['denominador'] = 0;
    $data4a2020[$establecimiento->comuna]['establecimientos'][$establecimiento->nombre]['denominador'] = 0;

    $data4a2020[$establecimiento->comuna]['cumplimiento'] = 0;
    $data4a2020[$establecimiento->comuna]['establecimientos'][$establecimiento->nombre]['cumplimiento'] = 0;

    $data4a2020[$establecimiento->comuna]['establecimientos'][$establecimiento->nombre]['meta'] = $data4a2020[$establecimiento->comuna]['meta'];
}

/* Sólo si está cargado sobre el rem de Junio */
// if($ultimo_rem >= 6) {
    /* ===== Query numerador ===== */
    $sql_numerador =
    "SELECT e.Comuna as comuna, e.alias_estab as nombre, r.Mes as mes, sum(ifnull(Col01,0)) as numerador
        FROM {$year}rems r
        LEFT JOIN 2020establecimientos e ON r.IdEstablecimiento=e.Codigo
        WHERE
        e.meta_san = 1 AND Ano = {$year} AND (Mes = 6 OR Mes = 12) AND
        CodigoPrestacion IN ('P4180300','P4200200')
        GROUP by e.Comuna, e.alias_estab, r.Mes
        ORDER BY e.Comuna, e.alias_estab, r.Mes";

    $numeradores = DB::connection('mysql_rem')->select($sql_numerador);

    foreach($numeradores as $registro) {
        if($registro->mes == 6) {
            $data4a2020[$registro->comuna]['numerador_6'] += $registro->numerador;
            $data4a2020[$registro->comuna]['establecimientos'][$registro->nombre]['numerador_6'] = $registro->numerador;
        }
        if($registro->mes == 12){
            $data4a2020[$registro->comuna]['numerador_12'] += $registro->numerador;
            $data4a2020[$registro->comuna]['establecimientos'][$registro->nombre]['numerador_12'] = $registro->numerador;
        }

        if($ultimo_rem < 12) {
            $data4a2020[$registro->comuna]['numerador'] = $data4a2020[$registro->comuna]['numerador_6'];
            $data4a2020[$registro->comuna]['establecimientos'][$registro->nombre]['numerador'] =
                $data4a2020[$registro->comuna]['establecimientos'][$registro->nombre]['numerador_6'];
        }
        else {
            $data4a2020[$registro->comuna]['numerador'] = $data4a2020[$registro->comuna]['numerador_12'];
            $data4a2020[$registro->comuna]['establecimientos'][$registro->nombre]['numerador'] =
                $data4a2020[$registro->comuna]['establecimientos'][$registro->nombre]['numerador_12'];
        }
    }




    /* ===== Query denominador ===== */
    $sql_denominador = "SELECT alias_estab as nombre, Comuna as comuna, SUM(denominador) as denominador
                    FROM
                    (
                      (SELECT e.alias_estab, e.Comuna, COUNT(*)*0.1 AS denominador
                        FROM 2020percapita p
                        LEFT JOIN 2020establecimientos e ON e.Codigo = p.COD_CENTRO
                        WHERE
                            e.meta_san = 1 AND
                        FECHA_CORTE = '2019-08-31' AND
                        EDAD BETWEEN 15 AND 64 AND
                        ACEPTADO_RECHAZADO = 'ACEPTADO'
                        GROUP BY e.Comuna, e.alias_estab
                        ORDER BY e.Comuna, e.alias_estab)

                      UNION

                      (SELECT e.alias_estab, e.Comuna, COUNT(*)*0.25 AS denominador
                        FROM 2020percapita p
                        LEFT JOIN 2020establecimientos e ON e.Codigo = p.COD_CENTRO
                        WHERE
                            e.meta_san = 1 AND
                        FECHA_CORTE = '2019-08-31' AND
                        EDAD >= 65 AND
                        ACEPTADO_RECHAZADO = 'ACEPTADO'
                        GROUP BY e.Comuna, e.alias_estab
                        ORDER BY e.Comuna, e.alias_estab)
                    ) tmp
                    group by tmp.Comuna, tmp.alias_estab
                    order by tmp.Comuna, tmp.alias_estab";

    $denominadores = DB::connection('mysql_rem')->select($sql_denominador);

    foreach($denominadores as $registro) {
        $data4a2020[$registro->comuna]['denominador'] += $registro->denominador;
        $data4a2020[$registro->comuna]['establecimientos'][$registro->nombre]['denominador'] = $registro->denominador;
    }

    /* Poblaciones manuales (denominadores) */
    $data4a2020['CAMIÑA']['denominador'] = 140;
    $data4a2020['CAMIÑA']['establecimientos']['CGR Camiña']['denominador'] = 0;
    $data4a2020['CAMIÑA']['establecimientos']['Posta Rural Moquella']['denominador'] = 0;

    $data4a2020['COLCHANE']['denominador'] = 101;
    $data4a2020['COLCHANE']['establecimientos']['CGR Colchane']['denominador'] = 0;
    $data4a2020['COLCHANE']['establecimientos']['Posta Rural Enquelga']['denominador'] = 0;
    $data4a2020['COLCHANE']['establecimientos']['Posta Rural Cariquima']['denominador'] = 0;

    $data4a2020['HUARA']['denominador'] = 231;
    $data4a2020['HUARA']['establecimientos']['CGR Dr. Amador Neghme Rodríguez']['denominador'] = 0;
    $data4a2020['HUARA']['establecimientos']['Posta Rural Pisagua']['denominador'] = 0;
    $data4a2020['HUARA']['establecimientos']['Posta Rural Tarapacá']['denominador'] = 0;
    $data4a2020['HUARA']['establecimientos']['Posta Rural Chiapa']['denominador'] = 0;
    $data4a2020['HUARA']['establecimientos']['Posta Rural Sibaya']['denominador'] = 0;

    /* ==== Calculos ==== */
    foreach($data4a2020 as $nombre_comuna => $comuna) {
        /* Calculo de las metas de la comuna */
        if($data4a2020[$nombre_comuna]['denominador'] == 0) {
            /* Si es 0 el denominadore entonces la meta es 0 */
            $data4a2020[$nombre_comuna]['cumplimiento'] = 0;
        }
        else {
            $data4a2020[$nombre_comuna]['cumplimiento'] = 
                $data4a2020[$nombre_comuna]['numerador'] /
                $data4a2020[$nombre_comuna]['denominador'] * 100;
        }

        foreach($comuna['establecimientos'] as $nombre_establecimiento => $establecimiento) {
            /* Calculo de cumplimiento de cada establecimiento */
            if($establecimiento['denominador'] == 0) {
                /* Si es 0 el denominador entonces la meta es 0 */
                $data4a2020[$nombre_comuna]['establecimientos'][$nombre_establecimiento]['cumplimiento'] = 0;
            }
            else {
                $data4a2020[$nombre_comuna]['establecimientos'][$nombre_establecimiento]['cumplimiento'] = 
                    $data4a2020[$nombre_comuna]['establecimientos'][$nombre_establecimiento]['numerador'] /
                    $data4a2020[$nombre_comuna]['establecimientos'][$nombre_establecimiento]['denominador'] * 100;
            }
        }
    }
// }
