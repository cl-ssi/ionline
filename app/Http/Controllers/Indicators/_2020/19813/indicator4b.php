<?php
namespace App\Http\Controllers\Indicators\_2020;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\Indicators\SingleParameter;

$year = 2020;

$sql_ultimo_rem = "SELECT MAX(Mes) as ultimo_rem FROM 2020rems;";
$ultimo_rem = DB::connection('mysql_rem')->select($sql_ultimo_rem)[0]->ultimo_rem;

$label['meta'] = 'Porcentaje de personas con diabetes de 15 años y más con evaluación anual de pie.';
$label['numerador'] = 'N° de personas con diabetes bajo control de 15 y más años con una evaluación de pie vigente.';
$label['denominador'] = 'N° total de personas diabéticas de 15 y más años bajo control al corte. **';

$data4b2020 = array();

$sql_establecimientos = "SELECT comuna, alias_estab
                         FROM 2020establecimientos
                         WHERE meta_san = 1
                         ORDER BY comuna;";

$establecimientos = DB::connection('mysql_rem')->select($sql_establecimientos);

/* ==== Inicializar en 0 el arreglo de datos $data4b2020 ==== */
foreach($establecimientos as $establecimiento) {
    /*$data4b2020[$establecimiento->comuna]['numerador'] = 0;
    $data4b2020[$establecimiento->comuna]['denominador'] = 0;
    $data4b2020[$establecimiento->comuna]['meta'] = 0;
    $data4b2020[$establecimiento->comuna]['cumplimiento'] = 0;
    $data4b2020[$establecimiento->comuna][$establecimiento->alias_estab]['numerador'] = 0;
    $data4b2020[$establecimiento->comuna][$establecimiento->alias_estab]['denominador'] = 0;
    $data4b2020[$establecimiento->comuna][$establecimiento->alias_estab]['meta'] = 0;
    $data4b2020[$establecimiento->comuna][$establecimiento->alias_estab]['cumplimiento'] = 0;*/

    $data4b2020[$establecimiento->comuna]['numerador'] = 0;
    $data4b2020[$establecimiento->comuna]['numerador_6'] = 0;
    $data4b2020[$establecimiento->comuna]['numerador_12'] = 0;
    $data4b2020[$establecimiento->comuna]['denominador'] = 0;
    $data4b2020[$establecimiento->comuna]['denominador_6'] = 0;
    $data4b2020[$establecimiento->comuna]['denominador_12'] = 0;
    $data4b2020[$establecimiento->comuna]['meta'] = 0;
    $data4b2020[$establecimiento->comuna]['cumplimiento'] = 0;
    $data4b2020[$establecimiento->comuna][$establecimiento->alias_estab]['numerador'] = 0;
    $data4b2020[$establecimiento->comuna][$establecimiento->alias_estab]['numerador_6'] = 0;
    $data4b2020[$establecimiento->comuna][$establecimiento->alias_estab]['numerador_12'] = 0;
    $data4b2020[$establecimiento->comuna][$establecimiento->alias_estab]['denominador'] = 0;
    $data4b2020[$establecimiento->comuna][$establecimiento->alias_estab]['denominador_6'] = 0;
    $data4b2020[$establecimiento->comuna][$establecimiento->alias_estab]['denominador_12'] = 0;
    $data4b2020[$establecimiento->comuna][$establecimiento->alias_estab]['meta'] = 0;
    $data4b2020[$establecimiento->comuna][$establecimiento->alias_estab]['cumplimiento'] = 0;
}

$data4b2020['ALTO HOSPICIO']['meta'] = '90%';
$data4b2020['CAMIÑA']['meta'] = '90%';
$data4b2020['COLCHANE']['meta'] = '92%';
$data4b2020['HUARA']['meta'] = '90%';
$data4b2020['IQUIQUE']['meta'] = '90%';
$data4b2020['PICA']['meta'] = '90%';
$data4b2020['POZO ALMONTE']['meta'] = '90%';

/* ===== Query numerador ===== */
$sql_numerador =
"SELECT e.Comuna, e.alias_estab, r.Mes, sum(ifnull(Col01,0)) as numerador
    FROM {$year}rems r
    LEFT JOIN 2020establecimientos e ON r.IdEstablecimiento=e.Codigo
    WHERE
    e.meta_san = 1 AND Ano = {$year} AND (Mes = 6 OR Mes = 12) AND
    CodigoPrestacion IN ('P4190809','P4170300','P4190500','P4190600')
    GROUP by e.Comuna, e.alias_estab, r.Mes
    ORDER BY e.Comuna, e.alias_estab, r.Mes";

$numeradores = DB::connection('mysql_rem')->select($sql_numerador);

foreach($numeradores as $registro) {
    /*$data4b2020[$registro->Comuna]['numerador'] += $registro->numerador;
    $data4b2020[$registro->Comuna][$registro->alias_estab]['numerador'] = $registro->numerador;*/

    if($registro->Mes == 6) {
        $data4b2020[$registro->Comuna]['numerador_6'] += $registro->numerador;
        $data4b2020[$registro->Comuna][$registro->alias_estab]['numerador_6'] = $registro->numerador;
    }
    if($registro->Mes == 12){
        $data4b2020[$registro->Comuna]['numerador_12'] += $registro->numerador;
        $data4b2020[$registro->Comuna][$registro->alias_estab]['numerador_12'] = $registro->numerador;
    }
}

/* ===== Query denominador ===== */
$sql_denominador =
"SELECT e.Comuna, e.alias_estab, r.Mes, sum(ifnull(Col01,0)) as denominador
    FROM {$year}rems r
    LEFT JOIN 2020establecimientos e ON r.IdEstablecimiento=e.Codigo
    WHERE
    e.meta_san = 1 AND Ano = {$year} AND (Mes = 6 OR Mes = 12) AND
    CodigoPrestacion IN ('P4150602')
    GROUP by e.Comuna, e.alias_estab, r.Mes
    ORDER BY e.Comuna, e.alias_estab, r.Mes";

$denomidores = DB::connection('mysql_rem')->select($sql_denominador);

foreach($denomidores as $registro) {
    /*$data4b2020[$registro->Comuna]['denominador'] += $registro->denominador;
    $data4b2020[$registro->Comuna][$registro->alias_estab]['denominador'] = $registro->denominador;*/

    if($registro->Mes == 6) {
        $data4b2020[$registro->Comuna]['denominador_6'] += $registro->denominador;
        $data4b2020[$registro->Comuna][$registro->alias_estab]['denominador_6'] = $registro->denominador;
    }
    if($registro->Mes == 12){
        $data4b2020[$registro->Comuna]['denominador_12'] += $registro->denominador;
        $data4b2020[$registro->Comuna][$registro->alias_estab]['denominador_12'] = $registro->denominador;
    }
}


/* ==== Calculos ==== */
foreach($data4b2020 as $nombre_comuna => $comuna) {
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
                    $data4b2020[$nombre_comuna]['cumplimiento'] = 0;
                    break;
                case 6:
                case 7:
                case 8:
                case 9:
                case 10:
                case 11:
                    $data4b2020[$nombre_comuna][$nombre_establecimiento]['numerador'] =
                        $data4b2020[$nombre_comuna][$nombre_establecimiento]['numerador_6'];
                    $data4b2020[$nombre_comuna][$nombre_establecimiento]['denominador'] =
                        $data4b2020[$nombre_comuna][$nombre_establecimiento]['denominador_6'];
                    break;
                case 12:
                    $data4b2020[$nombre_comuna][$nombre_establecimiento]['numerador'] =
                        $data4b2020[$nombre_comuna][$nombre_establecimiento]['numerador_12'];
                    $data4b2020[$nombre_comuna][$nombre_establecimiento]['denominador'] =
                        $data4b2020[$nombre_comuna][$nombre_establecimiento]['denominador_12'];
                    break;
            }
            if($data4b2020[$nombre_comuna][$nombre_establecimiento]['denominador'] == 0) {
                /* Si es 0 el denominadore entonces la meta es 0 */
                $data4b2020[$nombre_comuna][$nombre_establecimiento]['cumplimiento'] = 0;
            }
            else {
                /* De lo contrario calcular el porcentaje */
                $data4b2020[$nombre_comuna][$nombre_establecimiento]['cumplimiento'] =
                    $data4b2020[$nombre_comuna][$nombre_establecimiento]['numerador'] /
                    $data4b2020[$nombre_comuna][$nombre_establecimiento]['denominador'] * 100;
            }

            /* Fija la meta de la comuna también a sus establecimientos */
            $data4b2020[$nombre_comuna][$nombre_establecimiento]['meta'] = $data4b2020[$nombre_comuna]['meta'];


            switch($ultimo_rem) {
                case 1:
                case 2:
                case 3:
                case 4:
                case 5:
                    $data4b2020[$nombre_comuna]['cumplimiento'] = 0;
                    break;
                case 6:
                case 7:
                case 8:
                case 9:
                case 10:
                case 11:
                    $data4b2020[$nombre_comuna]['numerador'] =
                        $data4b2020[$nombre_comuna]['numerador_6'];
                    $data4b2020[$nombre_comuna]['denominador'] =
                        $data4b2020[$nombre_comuna]['denominador_6'];
                    break;
                case 12:
                    $data4b2020[$nombre_comuna]['numerador'] =
                        $data4b2020[$nombre_comuna]['numerador_12'];
                    $data4b2020[$nombre_comuna]['denominador'] =
                        $data4b2020[$nombre_comuna]['denominador_12'];
                    break;
            }
            /* Calculo de las metas de la comuna */
            if($data4b2020[$nombre_comuna]['denominador'] == 0) {
                /* Si es 0 el denominadore entonces la meta es 0 */
                $data4b2020[$nombre_comuna]['cumplimiento'] = 0;
            }
            else {
                /* De lo contrario calcular el porcentaje */
                $data4b2020[$nombre_comuna]['cumplimiento'] = $data4b2020[$nombre_comuna]['numerador'] / $data4b2020[$nombre_comuna]['denominador'] * 100;
            }
        }
    }
}
