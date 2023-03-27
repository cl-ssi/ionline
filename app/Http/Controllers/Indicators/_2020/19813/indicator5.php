<?php
namespace App\Http\Controllers\Indicators\_2020;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\Indicators\SingleParameter;

$year = 2020;

$sql_ultimo_rem = "SELECT MAX(Mes) as ultimo_rem FROM 2020rems;";
$ultimo_rem = DB::connection('mysql_rem')->select($sql_ultimo_rem)[0]->ultimo_rem;

$label['meta'] = 'Porcentaje de personas mayores de 15 años y más con cobertura efectiva de hipertensión arterial.';
$label['numerador'] = 'Nº personas hipertensas de 15 a 79 años con PA<140/90 mmHg más Nº personas hipertensas de 80 y más años con PA<150/90 mmHg, según último control vigente. *';
$label['denominador'] = 'Total de personas hipertensas de 15 y más años estimadas según prevalencia. **';

$data52020 = array();

$sql_establecimientos = "SELECT comuna, alias_estab
                         FROM 2020establecimientos
                         WHERE meta_san = 1
                         ORDER BY comuna;";

$establecimientos = DB::connection('mysql_rem')->select($sql_establecimientos);

/* ==== Inicializar en 0 el arreglo de datos $data52020 ==== */
foreach($establecimientos as $establecimiento) {
    $data52020[$establecimiento->comuna]['numerador'] = 0;
    $data52020[$establecimiento->comuna]['numerador_6'] = 0;
    $data52020[$establecimiento->comuna]['numerador_12'] = 0;
    $data52020[$establecimiento->comuna]['denominador'] = 0;
    $data52020[$establecimiento->comuna]['meta'] = 0;
    $data52020[$establecimiento->comuna]['cumplimiento'] = 0;
    $data52020[$establecimiento->comuna][$establecimiento->alias_estab]['numerador'] = 0;
    $data52020[$establecimiento->comuna][$establecimiento->alias_estab]['numerador_6'] = 0;
    $data52020[$establecimiento->comuna][$establecimiento->alias_estab]['numerador_12'] = 0;
    $data52020[$establecimiento->comuna][$establecimiento->alias_estab]['denominador'] = 0;
    $data52020[$establecimiento->comuna][$establecimiento->alias_estab]['meta'] = 0;
    $data52020[$establecimiento->comuna][$establecimiento->alias_estab]['cumplimiento'] = 0;
}

$data52020['ALTO HOSPICIO']['meta'] = '25%';
$data52020['CAMIÑA']['meta'] = '22%';
$data52020['COLCHANE']['meta'] = '15%';
$data52020['HUARA']['meta'] = '30%';
$data52020['IQUIQUE']['meta'] = '47%';
$data52020['PICA']['meta'] = '49%';
$data52020['POZO ALMONTE']['meta'] = '34%';

/* ===== Query numerador ===== */
$sql_numerador =
"SELECT e.Comuna, e.alias_estab, r.Mes, sum(ifnull(Col01,0)) as numerador
    FROM {$year}rems r
    LEFT JOIN 2020establecimientos e ON r.IdEstablecimiento=e.Codigo
    WHERE
    e.meta_san = 1 AND Ano = {$year} AND (Mes = 6 OR Mes = 12) AND
    CodigoPrestacion IN ('P4180200','P4200100')
    GROUP by e.Comuna, e.alias_estab, r.Mes
    ORDER BY e.Comuna, e.alias_estab, r.Mes";

$numeradores = DB::connection('mysql_rem')->select($sql_numerador);

foreach($numeradores as $registro) {
    /*$data52020[$registro->Comuna]['numerador'] += $registro->numerador;
    $data52020[$registro->Comuna][$registro->alias_estab]['numerador'] = $registro->numerador;*/

    if($registro->Mes == 6) {
        $data52020[$registro->Comuna]['numerador_6'] += $registro->numerador;
        $data52020[$registro->Comuna][$registro->alias_estab]['numerador_6'] = $registro->numerador;
    }
    if($registro->Mes == 12){
        $data52020[$registro->Comuna]['numerador_12'] += $registro->numerador;
        $data52020[$registro->Comuna][$registro->alias_estab]['numerador_12'] = $registro->numerador;
    }
}

/* ===== Query denominador ===== */
$sql_denominador = "SELECT alias_estab, Comuna, SUM(denominador) as denominador
                    FROM
                    (
                      (SELECT e.alias_estab, e.Comuna, COUNT(*)*0.157 AS denominador
                        FROM 2020percapita p
                        LEFT JOIN 2020establecimientos e ON e.Codigo = p.COD_CENTRO
                        WHERE
                        FECHA_CORTE = '2019-08-31' AND
                        EDAD BETWEEN 15 AND 64 AND
                        ACEPTADO_RECHAZADO = 'ACEPTADO' AND e.meta_san = 1
                        GROUP BY e.Comuna, e.alias_estab
                        ORDER BY e.Comuna, e.alias_estab)

                      UNION

                      (SELECT e.alias_estab, e.Comuna, COUNT(*)*0.643 AS denominador
                        FROM 2020percapita p
                        LEFT JOIN 2020establecimientos e ON e.Codigo = p.COD_CENTRO
                        WHERE
                        FECHA_CORTE = '2019-08-31' AND
                        EDAD >= 65 AND
                        ACEPTADO_RECHAZADO = 'ACEPTADO' AND e.meta_san = 1
                        GROUP BY e.Comuna, e.alias_estab
                        ORDER BY e.Comuna, e.alias_estab)
                    ) tmp
                    group by tmp.Comuna, tmp.alias_estab
                    order by tmp.Comuna, tmp.alias_estab";

$denominadores = DB::connection('mysql_rem')->select($sql_denominador);

foreach($denominadores as $registro) {
    $data52020[$registro->Comuna]['denominador'] += $registro->denominador;
    $data52020[$registro->Comuna][$registro->alias_estab]['denominador'] = $registro->denominador;
}

$data52020['CAMIÑA']['denominador'] = 279;
$data52020['CAMIÑA']['CGR Camiña']['denominador'] = 0;
$data52020['CAMIÑA']['Posta Rural Moquella']['denominador'] = 0;

$data52020['COLCHANE']['denominador'] = 208;
$data52020['COLCHANE']['CGR Colchane']['denominador'] = 0;
$data52020['COLCHANE']['Posta Rural Enquelga']['denominador'] = 0;
$data52020['COLCHANE']['Posta Rural Cariquima']['denominador'] = 0;

$data52020['HUARA']['denominador'] = 450;
$data52020['HUARA']['CGR Dr. Amador Neghme Rodríguez']['denominador'] = 0;
$data52020['HUARA']['Posta Rural Pisagua']['denominador'] = 0;
$data52020['HUARA']['Posta Rural Tarapacá']['denominador'] = 0;
$data52020['HUARA']['Posta Rural Chiapa']['denominador'] = 0;
$data52020['HUARA']['Posta Rural Sibaya']['denominador'] = 0;

/* ==== Calculos ==== */
foreach($data52020 as $nombre_comuna => $comuna) {
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
            if($data52020[$nombre_comuna][$nombre_establecimiento]['denominador'] == 0) {
                /* Si es 0 el denominadore entonces la meta es 0 */
                $data52020[$nombre_comuna][$nombre_establecimiento]['cumplimiento'] = 0;
            }
            else {
                /* De lo contrario calcular el porcentaje */
                switch($ultimo_rem) {
                    case 1:
                    case 2:
                    case 3:
                    case 4:
                    case 5:
                        $data52020[$nombre_comuna]['cumplimiento'] = 0;
                        break;
                    case 6:
                    case 7:
                    case 8:
                    case 9:
                    case 10:
                    case 11:
                        $data52020[$nombre_comuna][$nombre_establecimiento]['numerador'] =
                            $data52020[$nombre_comuna][$nombre_establecimiento]['numerador_6'];
                        break;
                    case 12:
                        $data52020[$nombre_comuna][$nombre_establecimiento]['numerador'] =
                            $data52020[$nombre_comuna][$nombre_establecimiento]['numerador_12'];
                        break;
                }
                $data52020[$nombre_comuna][$nombre_establecimiento]['cumplimiento'] =
                    $data52020[$nombre_comuna][$nombre_establecimiento]['numerador'] / $data52020[$nombre_comuna][$nombre_establecimiento]['denominador'] * 100;
            }

            /* Fija la meta de la comuna también a sus establecimientos */
            $data52020[$nombre_comuna][$nombre_establecimiento]['meta'] = $data52020[$nombre_comuna]['meta'];

            /* Calculo de las metas de la comuna */
            if($data52020[$nombre_comuna]['denominador'] == 0) {
                /* Si es 0 el denominadore entonces la meta es 0 */
                $data52020[$nombre_comuna]['cumplimiento'] = 0;
            }
            else {
                /* De lo contrario calcular el porcentaje */
                switch($ultimo_rem) {
                    case 1:
                    case 2:
                    case 3:
                    case 4:
                    case 5:
                        $data52020[$nombre_comuna]['cumplimiento'] = 0;
                        break;
                    case 6:
                    case 7:
                    case 8:
                    case 9:
                    case 10:
                    case 11:
                        $data52020[$nombre_comuna]['numerador'] =
                            $data52020[$nombre_comuna]['numerador_6'];
                        break;
                    case 12:
                        $data52020[$nombre_comuna]['numerador'] =
                            $data52020[$nombre_comuna]['numerador_12'];
                        break;
                }
                $data52020[$nombre_comuna]['cumplimiento'] = $data52020[$nombre_comuna]['numerador'] / $data52020[$nombre_comuna]['denominador'] * 100;
            }
        }
    }
}
