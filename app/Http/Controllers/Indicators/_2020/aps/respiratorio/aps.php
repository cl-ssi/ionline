<?php
namespace App\Http\Controllers\Indicators\_2020;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\Indicators\SingleParameter;
use App\Http\Controllers\Indicators\_2020\aps\Helper;

$year = 2020;

// comentario

$label['programa'] = 'Programa Respiratorio.';

$data2020 = array();
$helper = new Helper();

$sql_establecimientos ="SELECT comuna, alias_estab
                        FROM {$year}establecimientos
                        WHERE p_respiratorio = 1
                        ORDER BY comuna, id_establecimiento";

$establecimientos = DB::connection('mysql_rem')->select($sql_establecimientos);

/***************** Indicador 1 *****************/
$ind = 1;
$label[$ind]['indicador'] = '1. % de cambio de población IRA bajo control';
$label[$ind]['numerador'] = 'Población bajo control de menores de 20 años en el programa respiratorio 2020 - población bajo control de menores de 20 años en el programa respiratorio 2019.';
$label[$ind]['denominador'] = 'Población bajo control de menores de 20 años en el programa respiratorio 2020.';
$label[$ind]['fuente_numerador'] = $fuente['numerador'] = 'REM P';
$label[$ind]['fuente_denominador'] = $fuente['denominador'] = 'REM P';
$label[$ind]['ponderacion'] = '';

/* ==== Inicializar en 0 el arreglo de datos $data2020 ==== */
$data2020 = $helper->initializeData($data2020, $establecimientos, $ind, $ultimo_rem, $fuente);

/* ==== Se ingresa las metas comunales ==== */
$data2020 = $helper->setMetas($data2020, $establecimientos, $ind, '5%');

/* ==== Query numerador ==== */
$sql_numerador = "SELECT e.Comuna, e.alias_estab, r.Mes, sum(ifnull(Col04,0) + ifnull(Col05,0) + ifnull(Col06,0) +
                   ifnull(Col07,0) + ifnull(Col08,0) + ifnull(Col09,0) + ifnull(Col10,0) + ifnull(Col11,0)) as numerador
                   FROM ". ($year-1) ."rems r
                   LEFT JOIN ". ($year-1) ."establecimientos e
                   ON r.IdEstablecimiento=e.Codigo
                   WHERE CodigoPrestacion in ('P3160930') AND e.p_respiratorio = 1
                   AND r.Mes='12'
                   GROUP BY e.Comuna, e.alias_estab, r.Mes
                   ORDER BY e.Comuna, e.alias_estab, r.Mes";
$valores['numerador'] = DB::connection('mysql_rem')->select($sql_numerador);

/* ==== Query denominador ==== */
$sql_denominador = "SELECT e.Comuna, e.alias_estab, r.Mes, sum(ifnull(Col04,0) + ifnull(Col05,0) + ifnull(Col06,0) +
                   ifnull(Col07,0) + ifnull(Col08,0) + ifnull(Col09,0) + ifnull(Col10,0) + ifnull(Col11,0)) as denominador
                   FROM {$year}rems r
                   LEFT JOIN {$year}establecimientos e
                   ON r.IdEstablecimiento=e.Codigo
                   WHERE CodigoPrestacion in ('P3160930') AND e.p_respiratorio = 1
                   AND r.Mes IN (6,2)
                   GROUP BY e.Comuna, e.alias_estab, r.Mes
                   ORDER BY e.Comuna, e.alias_estab, r.Mes";
$valores['denominador'] = DB::connection('mysql_rem')->select($sql_denominador);

$data2020 = $helper->setValores($data2020, $valores, $ind, $ultimo_rem, $fuente, $establecimientos);

//Necesitamos recalcular los numeradores segun denominador para sacar la diferencia entre el año actual y el anterior
$data2020 = $helper->recalcularNumerador($data2020, $ind, $establecimientos);

/***************** Indicador 2 *****************/
$ind = 2;
$label[$ind]['indicador'] = '2. % de cambio de población ERA bajo control';
$label[$ind]['numerador'] = 'Población bajo control de menores de 20 años en el programa respiratorio 2020 - población bajo control de menores de 20 años en el programa respiratorio 2019.';
$label[$ind]['denominador'] = 'Población bajo control de menores de 20 años en el programa respiratorio 2020.';
$label[$ind]['fuente_numerador'] = $fuente['numerador'] = 'REM P';
$label[$ind]['fuente_denominador'] = $fuente['denominador'] = 'REM P';
$label[$ind]['ponderacion'] = '';

/* ==== Inicializar en 0 el arreglo de datos $data2020 ==== */
$data2020 = $helper->initializeData($data2020, $establecimientos, $ind, $ultimo_rem, $fuente);

/* ==== Se ingresa las metas comunales ==== */
$data2020 = $helper->setMetas($data2020, $establecimientos, $ind, '5%');

/* ==== Query numerador ==== */
$sql_numerador = "SELECT e.Comuna, e.alias_estab, r.Mes, sum(ifnull(Col04,0) + ifnull(Col05,0) + ifnull(Col06,0) +
                   ifnull(Col07,0) + ifnull(Col08,0) + ifnull(Col09,0) + ifnull(Col10,0) + ifnull(Col11,0)) as numerador
                   FROM ". ($year-1) ."rems r
                   LEFT JOIN ". ($year-1) ."establecimientos e
                   ON r.IdEstablecimiento=e.Codigo
                   WHERE CodigoPrestacion in ('P3160930') AND e.p_respiratorio = 1
                   AND r.Mes='12'
                   GROUP BY e.Comuna, e.alias_estab, r.Mes
                   ORDER BY e.Comuna, e.alias_estab, r.Mes";
$valores['numerador'] = DB::connection('mysql_rem')->select($sql_numerador);

/* ==== Query denominador ==== */
$sql_denominador = "SELECT e.Comuna, e.alias_estab, r.Mes, sum(ifnull(Col04,0) + ifnull(Col05,0) + ifnull(Col06,0) +
                   ifnull(Col07,0) + ifnull(Col08,0) + ifnull(Col09,0) + ifnull(Col10,0) + ifnull(Col11,0)) as denominador
                   FROM {$year}rems r
                   LEFT JOIN {$year}establecimientos e
                   ON r.IdEstablecimiento=e.Codigo
                   WHERE CodigoPrestacion in ('P3160930') AND e.p_respiratorio = 1
                   AND r.Mes IN (6,2)
                   GROUP BY e.Comuna, e.alias_estab, r.Mes
                   ORDER BY e.Comuna, e.alias_estab, r.Mes";
$valores['denominador'] = DB::connection('mysql_rem')->select($sql_denominador);

$data2020 = $helper->setValores($data2020, $valores, $ind, $ultimo_rem, $fuente, $establecimientos);

//Necesitamos recalcular los numeradores segun denominador para sacar la diferencia entre el año actual y el anterior
$data2020 = $helper->recalcularNumerador($data2020, $ind, $establecimientos);

/***************** Indicador 3 *****************/
$ind = 3;
$label[$ind]['indicador'] = '3. % de población asmática que se encuentra con evaluación de nivel de control';
$label[$ind]['numerador'] = 'N° pacientes asmáticos menores de 20 años en control con evaluación de nivel de control';
$label[$ind]['denominador'] = 'Población asmática menor de 20 años en control';
$label[$ind]['fuente_numerador'] = $fuente['numerador'] = 'REM P';
$label[$ind]['fuente_denominador'] = $fuente['denominador'] = 'REM P';
$label[$ind]['ponderacion'] = '';

/* ==== Inicializar en 0 el arreglo de datos $data2020 ==== */
$data2020 = $helper->initializeData($data2020, $establecimientos, $ind, $ultimo_rem, $fuente);

/* ==== Se ingresa las metas comunales ==== */
$data2020 = $helper->setMetas($data2020, $establecimientos, $ind, '90%');

/* ==== Query numerador ==== */
$sql_numerador = "SELECT e.Comuna, e.alias_estab, r.Mes, sum(ifnull(Col04,0) + ifnull(Col05,0) + ifnull(Col06,0) +
                   ifnull(Col07,0) + ifnull(Col08,0) + ifnull(Col09,0) + ifnull(Col10,0) + ifnull(Col11,0)) as numerador
                   FROM ". ($ultimo_rem <= 5 ? $year-1 : $year) ."rems r
                   LEFT JOIN ". ($ultimo_rem <= 5 ? $year-1 : $year) ."establecimientos e
                   ON r.IdEstablecimiento=e.Codigo
                   WHERE CodigoPrestacion in ('P3161041', 'P3161042', 'P3161043', 'P3161044') AND e.p_respiratorio = 1
                   AND r.Mes IN (". ($ultimo_rem <= 5 ? '12' : '6, 12') .")
                   GROUP BY e.Comuna, e.alias_estab, r.Mes
                   ORDER BY e.Comuna, e.alias_estab, r.Mes";
$valores['numerador'] = DB::connection('mysql_rem')->select($sql_numerador);

/* ==== Query denominador ==== */
$sql_denominador = "SELECT e.Comuna, e.alias_estab, r.Mes, sum(ifnull(Col04,0) + ifnull(Col05,0) + ifnull(Col06,0) +
                   ifnull(Col07,0) + ifnull(Col08,0) + ifnull(Col09,0) + ifnull(Col10,0) + ifnull(Col11,0)) as denominador
                   FROM ". ($ultimo_rem <= 5 ? $year-1 : $year) ."rems r
                   LEFT JOIN ". ($ultimo_rem <= 5 ? $year-1 : $year) ."establecimientos e
                   ON r.IdEstablecimiento=e.Codigo
                   WHERE CodigoPrestacion in ('P3160980', 'P3160990', 'P3161000') AND e.p_respiratorio = 1
                   AND r.Mes IN (". ($ultimo_rem <= 5 ? '12' : '6, 12') .")
                   GROUP BY e.Comuna, e.alias_estab, r.Mes
                   ORDER BY e.Comuna, e.alias_estab, r.Mes";
$valores['denominador'] = DB::connection('mysql_rem')->select($sql_denominador);

$data2020 = $helper->setValores($data2020, $valores, $ind, $ultimo_rem, $fuente, $establecimientos);

/***************** Indicador 4 *****************/
$ind = 4;
$label[$ind]['indicador'] = '4. % pacientes EPOC A bajo control que cumplieron con un programa de rehabilitación pulmonar';
$label[$ind]['numerador'] = 'N° pacientes EPOC Etapa A que finalizan programa de rehabilitación pulmonar';
$label[$ind]['denominador'] = 'Población EPOC Etapa A bajo control';
$label[$ind]['fuente_numerador'] = $fuente['numerador'] = 'REM';
$label[$ind]['fuente_denominador'] = $fuente['denominador'] = 'REM P';
$label[$ind]['ponderacion'] = '';

/* ==== Inicializar en 0 el arreglo de datos $data2020 ==== */
$data2020 = $helper->initializeData($data2020, $establecimientos, $ind, $ultimo_rem, $fuente);

/* ==== Se ingresa las metas comunales ==== */
$data2020 = $helper->setMetas($data2020, $establecimientos, $ind, '40%');

/* ==== Query numerador ==== */
$sql_numerador = "SELECT e.Comuna, e.alias_estab, r.Mes, sum(ifnull(Col01,0)) as numerador
                   FROM {$year}rems r
                   LEFT JOIN {$year}establecimientos e
                   ON r.IdEstablecimiento=e.Codigo
                   WHERE CodigoPrestacion in (23060105) AND e.p_respiratorio = 1
                   GROUP BY e.Comuna, e.alias_estab, r.Mes
                   ORDER BY e.Comuna, e.alias_estab, r.Mes";
$valores['numerador'] = DB::connection('mysql_rem')->select($sql_numerador);

/* ==== Query denominador ==== */
$sql_denominador = "SELECT e.Comuna, e.alias_estab, r.Mes, sum(ifnull(Col01,0)) as denominador
                   FROM ". ($ultimo_rem <= 5 ? $year-1 : $year) ."rems r
                   LEFT JOIN ". ($ultimo_rem <= 5 ? $year-1 : $year) ."establecimientos e
                   ON r.IdEstablecimiento=e.Codigo
                   WHERE CodigoPrestacion in ('P3161010') AND e.p_respiratorio = 1
                   AND r.Mes IN (". ($ultimo_rem <= 5 ? '12' : '6, 12') .")
                   GROUP BY e.Comuna, e.alias_estab, r.Mes
                   ORDER BY e.Comuna, e.alias_estab, r.Mes";
$valores['denominador'] = DB::connection('mysql_rem')->select($sql_denominador);

$data2020 = $helper->setValores($data2020, $valores, $ind, $ultimo_rem, $fuente, $establecimientos);

/***************** Indicador 5 *****************/
$ind = 5;
$label[$ind]['indicador'] = '5. % de pacientes Asma y EPOC en control con evaluación de nivel de control';
$label[$ind]['numerador'] = 'N° de pacientes mayores de 20 años Asma y EPOC con evaluación de nivel de control';
$label[$ind]['denominador'] = 'N° total de pacientes Asma y EPOC mayores de 20 años';
$label[$ind]['fuente_numerador'] = $fuente['numerador'] = 'REM P';
$label[$ind]['fuente_denominador'] = $fuente['denominador'] = 'REM P';
$label[$ind]['ponderacion'] = '';

/* ==== Inicializar en 0 el arreglo de datos $data2020 ==== */
$data2020 = $helper->initializeData($data2020, $establecimientos, $ind, $ultimo_rem, $fuente);

/* ==== Se ingresa las metas comunales ==== */
$data2020 = $helper->setMetas($data2020, $establecimientos, $ind, '90%');

/* ==== Query numerador ==== */
$sql_numerador = "SELECT e.Comuna, e.alias_estab, r.Mes, sum(ifnull(Col12,0) + ifnull(Col13,0) + ifnull(Col14,0) +
                   ifnull(Col15,0) + ifnull(Col16,0) + ifnull(Col17,0) + ifnull(Col18,0) + ifnull(Col19,0) +
                   ifnull(Col20,0) + ifnull(Col21,0) + ifnull(Col22,0) + ifnull(Col23,0) + ifnull(Col24,0) +
                   ifnull(Col25,0) + ifnull(Col26,0) + ifnull(Col27,0) + ifnull(Col28,0) + ifnull(Col29,0) +
                   ifnull(Col30,0) + ifnull(Col31,0) + ifnull(Col32,0) + ifnull(Col33,0) + ifnull(Col34,0) +
                   ifnull(Col35,0) + ifnull(Col36,0) + ifnull(Col37,0)) as numerador
                   FROM ". ($ultimo_rem <= 5 ? $year-1 : $year) ."rems r
                   LEFT JOIN ". ($ultimo_rem <= 5 ? $year-1 : $year) ."establecimientos e
                   ON r.IdEstablecimiento=e.Codigo
                   WHERE CodigoPrestacion in ('P3161041', 'P3161042', 'P3161043', 'P3161044', 'P3161045',
                   'P3161046', 'P3161047') AND e.p_respiratorio = 1
                   AND r.Mes IN (". ($ultimo_rem <= 5 ? '12' : '6, 12') .")
                   GROUP BY e.Comuna, e.alias_estab, r.Mes
                   ORDER BY e.Comuna, e.alias_estab, r.Mes";
$valores['numerador'] = DB::connection('mysql_rem')->select($sql_numerador);

/* ==== Query denominador ==== */
$sql_denominador = "SELECT e.Comuna, e.alias_estab, r.Mes, sum(ifnull(Col12,0) + ifnull(Col13,0) + ifnull(Col14,0) +
                   ifnull(Col15,0) + ifnull(Col16,0) + ifnull(Col17,0) + ifnull(Col18,0) + ifnull(Col19,0) +
                   ifnull(Col20,0) + ifnull(Col21,0) + ifnull(Col22,0) + ifnull(Col23,0) + ifnull(Col24,0) +
                   ifnull(Col25,0) + ifnull(Col26,0) + ifnull(Col27,0) + ifnull(Col28,0) + ifnull(Col29,0) +
                   ifnull(Col30,0) + ifnull(Col31,0) + ifnull(Col32,0) + ifnull(Col33,0) + ifnull(Col34,0) +
                   ifnull(Col35,0) + ifnull(Col36,0) + ifnull(Col37,0)) as denominador
                   FROM ". ($ultimo_rem <= 5 ? $year-1 : $year) ."rems r
                   LEFT JOIN ". ($ultimo_rem <= 5 ? $year-1 : $year) ."establecimientos e
                   ON r.IdEstablecimiento=e.Codigo
                   WHERE CodigoPrestacion in ('P3160980', 'P3160990', 'P3161000', 'P3161010', 'P3161020') AND e.p_respiratorio = 1
                   AND r.Mes IN (". ($ultimo_rem <= 5 ? '12' : '6, 12') .")
                   GROUP BY e.Comuna, e.alias_estab, r.Mes
                   ORDER BY e.Comuna, e.alias_estab, r.Mes";
$valores['denominador'] = DB::connection('mysql_rem')->select($sql_denominador);

$data2020 = $helper->setValores($data2020, $valores, $ind, $ultimo_rem, $fuente, $establecimientos);
