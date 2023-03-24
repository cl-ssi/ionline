<?php

namespace App\Http\Controllers\Indicators\_2020;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\Indicators\SingleParameter;
use App\Http\Controllers\Indicators\_2020\aps\Helper;

$year = 2020;
$data_hosp2020 = array();

$label['programa'] = 'Programa de Salud Sexual y Reproductiva.';

/***************** Indicador 1 *****************/
$ind = 1;
$label[$ind]['indicador'] = 'Cesárea';
$label[$ind]['numerador'] = 'N° de usuarias con parto cesárea realizadas en periodo correspondiente.';
$label[$ind]['denominador'] = 'N° total de partos en el mismo periodo.';
$label[$ind]['fuente_numerador'] = $fuente['numerador'] = 'REM';
$label[$ind]['fuente_denominador'] = $fuente['denominador'] = 'REM';
$label[$ind]['ponderacion'] = '';

$establecimiento[0] = (object) array('comuna' => 'IQUIQUE', 'alias_estab' => 'Hospital Dr. Ernesto Torres G.');

$helper = new Helper();

/* ==== Inicializar en 0 el arreglo de datos $data2020 ==== */
$data_hosp2020 = $helper->initializeData($data_hosp2020, $establecimiento, $ind, $ultimo_rem, $fuente);

/* ==== Se ingresa la meta para el establecimiento ==== */
$data_hosp2020 = $helper->setMetas($data_hosp2020, $establecimiento, $ind, '');

/* ==== Query numerador ==== */
$sql_numerador = "SELECT e.Comuna, e.alias_estab, r.Mes, sum(ifnull(Col01,0)) as numerador
                  FROM {$year}rems r
                  LEFT JOIN {$year}establecimientos e
                  ON r.IdEstablecimiento=e.Codigo
                  WHERE CodigoPrestacion in (01030300, 24090700) AND e.Codigo = 102100
                  GROUP BY e.Comuna, e.alias_estab, r.Mes
                  ORDER BY e.Comuna, e.alias_estab, r.Mes";
$valores['numerador'] = DB::connection('mysql_rem')->select($sql_numerador);

/* ==== Query denominador ==== */
$sql_denominador = "SELECT e.Comuna, e.alias_estab, r.Mes, sum(ifnull(Col01,0)) as denominador
                    FROM {$year}rems r
                    LEFT JOIN {$year}establecimientos e
                    ON r.IdEstablecimiento=e.Codigo
                    WHERE CodigoPrestacion in (01030100, 01030200, 01030300, 24090700) 
                    AND e.Codigo = 102100
                    GROUP BY e.Comuna, e.alias_estab, r.Mes
                    ORDER BY e.Comuna, e.alias_estab, r.Mes";
$valores['denominador'] = DB::connection('mysql_rem')->select($sql_denominador);

$data_hosp2020 = $helper->setValores($data_hosp2020, $valores, $ind, $ultimo_rem, $fuente, $establecimiento);