<?php

namespace App\Http\Controllers\Indicators\_2020;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\Indicators\SingleParameter;
use App\Http\Controllers\Indicators\_2020\aps\Helper;

$year = 2020;
$data_reyno2020 = array();

$label['programa'] = 'Programa de Salud Sexual y Reproductiva.';

/***************** Indicador 1 *****************/
$ind = 1;
$label[$ind]['indicador'] = '1-. Ingreso precoz de Embarazo.';
$label[$ind]['numerador'] = 'N° de mujeres embarazadas ingresadas antes de las 14 semanas a control.';
$label[$ind]['denominador'] = 'Total de mujeres embarazadas ingresadas a control.';
$label[$ind]['fuente_numerador'] = $fuente['numerador'] = 'REM';
$label[$ind]['fuente_denominador'] = $fuente['denominador'] = 'REM';
$label[$ind]['ponderacion'] = '';

$establecimiento[0] = (object) array('comuna' => 'ALTO HOSPICIO', 'alias_estab' => 'CGU Dr. Hector Reyno');

$helper = new Helper();

/* ==== Inicializar en 0 el arreglo de datos $data_reyno2020 ==== */
$data_reyno2020 = $helper->initializeData($data_reyno2020, $establecimiento, $ind, $ultimo_rem, $fuente);

/* ==== Se ingresa las metas comunales ==== */
$data_reyno2020 = $helper->setMetas($data_reyno2020, $establecimiento, $ind, '90%');

/* ==== Query numerador ==== */
$sql_numerador = "SELECT e.Comuna, e.alias_estab, r.Mes, sum(ifnull(Col01,0)) as numerador
                   FROM {$year}rems r
                   LEFT JOIN {$year}establecimientos e
                   ON r.IdEstablecimiento=e.Codigo
                   WHERE CodigoPrestacion in (01080009) AND e.Codigo = 102307
                   GROUP BY e.Comuna, e.alias_estab, r.Mes
                   ORDER BY e.Comuna, e.alias_estab, r.Mes";
$valores['numerador'] = DB::connection('mysql_rem')->select($sql_numerador);

/* ==== Query denominador ==== */
$sql_denominador = "SELECT e.Comuna, e.alias_estab, r.Mes, sum(ifnull(Col01,0)) as denominador
                   FROM {$year}rems r
                   LEFT JOIN {$year}establecimientos e
                   ON r.IdEstablecimiento=e.Codigo
                   WHERE CodigoPrestacion in (01080008) AND e.Codigo = 102307
                   GROUP BY e.Comuna, e.alias_estab, r.Mes
                   ORDER BY e.Comuna, e.alias_estab, r.Mes";
$valores['denominador'] = DB::connection('mysql_rem')->select($sql_denominador);

$data_reyno2020 = $helper->setValores($data_reyno2020, $valores, $ind, $ultimo_rem, $fuente, $establecimiento);

/***************** Indicador 2 *****************/
$ind = 2;
$label[$ind]['indicador'] = '2-. Deteccion precoz del cáncer de cuello uterino.';
$label[$ind]['numerador'] = 'N° de mujeres de 25 a 64 años que cuenten con PAP vigente en los últimos tres años a diciembre 2020.';
$label[$ind]['denominador'] = 'N° total de mujeres de 25 a 64 años inscritas válidas por FONASA.';
$label[$ind]['fuente_numerador'] = $fuente['numerador'] = 'REM P';
$label[$ind]['fuente_denominador'] = $fuente['denominador'] = 'FONASA';
$label[$ind]['ponderacion'] = '';

/* ==== Inicializar en 0 el arreglo de datos $data_reyno2020 ==== */
$data_reyno2020 = $helper->initializeData($data_reyno2020, $establecimiento, $ind, $ultimo_rem, $fuente);

/* ==== Se ingresa las metas comunales ==== */
$data_reyno2020 = $helper->setMetas($data_reyno2020, $establecimiento, $ind, '80%');

/* ==== Query numerador ==== */
$sql_numerador = "SELECT e.Comuna, e.alias_estab, r.Mes, sum(ifnull(Col01,0)) as numerador
                    FROM ". ($ultimo_rem <= 5 ? $year-1 : $year) ."rems r
                    LEFT JOIN ". ($ultimo_rem <= 5 ? $year-1 : $year) ."establecimientos e
                    ON r.IdEstablecimiento=e.Codigo
                    WHERE CodigoPrestacion in ('P1206010', 'P1206020', 'P1206030', 'P1206040', 'P1206050',
                                                'P1206060', 'P1206070', 'P1206080') AND e.Codigo = 102307
                    AND r.Mes IN (". ($ultimo_rem <= 5 ? '12' : '6, 12') .")
                    GROUP BY e.Comuna, e.alias_estab, r.Mes
                    ORDER BY e.Comuna, e.alias_estab, r.Mes";

$valores['numerador'] = DB::connection('mysql_rem')->select($sql_numerador);

/* ==== Query denominador ==== */
$sql_denominador = "SELECT e.Comuna, e.alias_estab, COUNT(*) AS denominador
                   FROM {$year}percapita p
                   LEFT JOIN {$year}establecimientos e ON e.Codigo = p.COD_CENTRO
                   WHERE
                   FECHA_CORTE = '2019-08-31' AND
                   EDAD BETWEEN 25 AND 64 AND
                   ACEPTADO_RECHAZADO = 'ACEPTADO'
                   AND e.Codigo = 102307
                   GROUP BY e.Comuna, e.alias_estab
                   ORDER BY e.Comuna, e.alias_estab";

$valores['denominador'] = DB::connection('mysql_rem')->select($sql_denominador);

$data_reyno2020 = $helper->setValores($data_reyno2020, $valores, $ind, $ultimo_rem, $fuente, $establecimiento);

/***************** Indicador 3 *****************/
$ind = 3;
$label[$ind]['indicador'] = '3-. Cobertura mamografia.';
$label[$ind]['numerador'] = 'N° de mujeres de 50 a 69 años que cuenten con mx vigente en los ultimos tres años a diciembre 2020';
$label[$ind]['denominador'] = 'N° total de mujeres de 50 a 69 años inscritas validas por FONASA';
$label[$ind]['fuente_numerador'] = $fuente['numerador'] = 'REM P';
$label[$ind]['fuente_denominador'] = $fuente['denominador'] = 'FONASA';
$label[$ind]['ponderacion'] = '';

/* ==== Inicializar en 0 el arreglo de datos $data_reyno2020 ==== */
$data_reyno2020 = $helper->initializeData($data_reyno2020, $establecimiento, $ind, $ultimo_rem, $fuente);

/* ==== Se ingresa las metas comunales ==== */
$data_reyno2020 = $helper->setMetas($data_reyno2020, $establecimiento, $ind, '60%');

/* ==== Query numerador ==== */
$sql_numerador = "SELECT e.Comuna, e.alias_estab, r.Mes, sum(ifnull(Col01,0)) as numerador
                    FROM ". ($ultimo_rem <= 5 ? $year-1 : $year) ."rems r
                    LEFT JOIN ". ($ultimo_rem <= 5 ? $year-1 : $year) ."establecimientos e
                    ON r.IdEstablecimiento=e.Codigo
                    WHERE CodigoPrestacion in ('P1220030', 'P1207030', 'P1207040',
                                                'P1207050') AND e.Codigo = 102307
                    AND r.Mes IN (". ($ultimo_rem <= 5 ? '12' : '6, 12') .")
                    GROUP BY e.Comuna, e.alias_estab, r.Mes
                    ORDER BY e.Comuna, e.alias_estab, r.Mes";
                    
$valores['numerador'] = DB::connection('mysql_rem')->select($sql_numerador);

/* ==== Query denominador  ==== */
$sql_denominador = "SELECT e.Comuna, e.alias_estab, COUNT(*) AS denominador
                   FROM {$year}percapita p
                   LEFT JOIN {$year}establecimientos e ON e.Codigo = p.COD_CENTRO
                   WHERE
                   FECHA_CORTE = '2019-08-31' AND
                   EDAD BETWEEN 50 AND 69 AND
                   ACEPTADO_RECHAZADO = 'ACEPTADO'
                   AND e.Codigo = 102307 
                   GROUP BY e.Comuna, e.alias_estab
                   ORDER BY e.Comuna, e.alias_estab";

$valores['denominador'] = DB::connection('mysql_rem')->select($sql_denominador);

$data_reyno2020 = $helper->setValores($data_reyno2020, $valores, $ind, $ultimo_rem, $fuente, $establecimiento);

/***************** Indicador 4 *****************/
$ind = 4;
$label[$ind]['indicador'] = '4-. Test Rapido.';
$label[$ind]['numerador'] = 'N° de usuarios de 15 a 65 años y mas  que cuenten con test rapido aplicado en el mes.';
$label[$ind]['denominador'] = 'N° total de usuarios de 15 a 65 años y más inscritos validas por FONASA.';
$label[$ind]['fuente_numerador'] = $fuente['numerador'] = 'REM';
$label[$ind]['fuente_denominador'] = $fuente['denominador'] = 'FONASA';
$label[$ind]['ponderacion'] = '';

/* ==== Inicializar en 0 el arreglo de datos $data_reyno2020 ==== */
$data_reyno2020 = $helper->initializeData($data_reyno2020, $establecimiento, $ind, $ultimo_rem, $fuente);

/* ==== Se ingresa las metas comunales ==== */
$data_reyno2020 = $helper->setMetas($data_reyno2020, $establecimiento, $ind, '');

/* ==== Query numerador ==== */
$sql_numerador = "SELECT e.Comuna, e.alias_estab, r.Mes, sum(ifnull(Col13,0) + ifnull(Col15,0) +
                   ifnull(Col17,0) + ifnull(Col19,0) + ifnull(Col21,0) + ifnull(Col23,0) +
                   ifnull(Col25,0) + ifnull(Col27,0) + ifnull(Col29,0) + ifnull(Col31,0) +
                   ifnull(Col33,0)) as numerador
                   FROM {$year}rems r
                   LEFT JOIN {$year}establecimientos e
                   ON r.IdEstablecimiento=e.Codigo
                   WHERE CodigoPrestacion in (11057100, 11057101, 11057102, 11057103, 11057104,
                                              11057105, 11057106, 11057107, 11057108, 11057109,
                                              11057110, 11057111, 11057112, 11057113, 11057114,
                                              11057115, 11057116, 11057117, 11057118, 11057119,
                                              11057120, 11057121, 11057122) AND e.Codigo = 102307
                   GROUP BY e.Comuna, e.alias_estab, r.Mes
                   ORDER BY e.Comuna, e.alias_estab, r.Mes";
$valores['numerador'] = DB::connection('mysql_rem')->select($sql_numerador);

/* ==== Query denominador ==== */
$sql_denominador = "SELECT e.Comuna, e.alias_estab, COUNT(*) AS denominador
                    FROM {$year}percapita p
                    LEFT JOIN {$year}establecimientos e ON e.Codigo = p.COD_CENTRO
                    WHERE
                    FECHA_CORTE = '2019-08-31' AND
                    EDAD >= 15 AND
                    ACEPTADO_RECHAZADO = 'ACEPTADO'
                    AND e.Codigo = 102307
                    GROUP BY e.Comuna, e.alias_estab
                    ORDER BY e.Comuna, e.alias_estab";

$valores['denominador'] = DB::connection('mysql_rem')->select($sql_denominador);

$data_reyno2020 = $helper->setValores($data_reyno2020, $valores, $ind, $ultimo_rem, $fuente, $establecimiento);