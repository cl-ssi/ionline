<?php
namespace App\Http\Controllers\Indicators\_2019;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\Indicators\SingleParameter;

/*************************************/
/********* SERVICIO DE SALUD *********/
/*************************************/

$year = 2019;

$sql_ultimo_rem = "SELECT MAX(Mes) as ultimo_rem FROM 2019rems;";
$ultimo_rem = DB::connection('mysql_rem')->select($sql_ultimo_rem)[0]->ultimo_rem;



/* INDICADOR 1.1.1 */
$data111['label']['meta'] = '1.1.1 Pacientes diabéticos compensados en
    el grupo de 15 años y más.';
$data111['label']['numerador'] = 'N° de personas con DM2 de 15 A 79 años
    con Hemoglobina Glicosilada bajo 7%, según último control en los
    últimos 12 meses + N° de personas con DM2 de 80 años y más con
    Hemoglobina Glicosilada bajo 8% según último control vigente, en los
    últimos 12 meses.';
$data111['label']['denominador'] = 'Total de pacientes diabéticos de 15
    años y más bajo control en el nivel primario * 100.';
$data111['meta'] = '≥45%';
$data111['ponderacion'] = '10%';

/* ==== Inicializar el arreglo de datos $data ==== */
$data111['numerador'] = '';
$data111['numerador_6'] = '';
$data111['numerador_12'] = '';
$data111['denominador'] = '';
$data111['denominador_6'] = '';
$data111['denominador_12'] = '';

$data111['cumplimiento'] = '';


$sql_numerador = "SELECT r.Mes AS mes, SUM(COALESCE(Col01,0)) AS valor
                FROM {$year}rems r
                WHERE (Mes = 6 OR Mes = 12)
                  AND CodigoPrestacion IN ('P4180300','P4200200')
                GROUP BY r.Mes
                ORDER BY r.Mes";
$numeradores = DB::connection('mysql_rem')->select($sql_numerador);

foreach($numeradores as $numerador) {
    switch($numerador->mes) {
        case 6:  $data111['numerador_6'] = $numerador->valor; break;
        case 12: $data111['numerador_12'] = $numerador->valor; break;
    }
}

$sql_denominador = "SELECT r.Mes AS mes, SUM(COALESCE(Col01,0)) AS valor
                    FROM {$year}rems r
                    WHERE (Mes = 6 OR Mes = 12)
                      AND CodigoPrestacion IN ('P4150602')
                    GROUP BY r.Mes
                    ORDER BY r.Mes";
$denominadores = DB::connection('mysql_rem')->select($sql_denominador);

foreach($denominadores as $denominador) {
    switch($denominador->mes) {
        case 6:  $data111['denominador_6'] = $denominador->valor; break;
        case 12: $data111['denominador_12'] = $denominador->valor; break;
    }
}

switch($ultimo_rem){
    case 1:
    case 2:
    case 3:
    case 4:
    case 5:
        $data111['numerador'] = '';
        $data111['denominador'] = '';
        $data111['cumplimiento'] = '';
        break;
    case 6:
    case 7:
    case 8:
    case 9:
    case 10:
    case 11:
        if($data111['denominador_6'] AND $data111['denominador_6'] != 0) {
            $data111['cumplimiento'] = $data111['numerador_6'] / $data111['denominador_6'] * 100;
        }
        else {
            $data111['cumplimiento'] = 0;
        }
        $data111['numerador'] = $data111['numerador_6'] = number_format($data111['numerador_6'], 0, ',', '.');
        $data111['denominador'] = $data111['denominador_6'] = number_format($data111['denominador_6'], 0, ',', '.');
        break;
    case 12:
        if($data111['denominador_12'] AND $data111['denominador_12'] != 0) {
            $data111['cumplimiento'] = $data111['numerador_12'] / $data111['denominador_12'] * 100;
        }
        else {
            $data111['cumplimiento'] = 0;
        }
        $data111['numerador'] = $data111['numerador_12'] = number_format($data111['numerador_12'], 0, ',', '.');
        $data111['denominador'] = $data111['denominador_12'] = number_format($data111['denominador_12'], 0, ',', '.');
        break;
}

/**** INDICADOR 1.1.2 ****/
$data112['label']['meta'] = '1.1.2 Evaluacion Anual de los Pies en
    personas con DM2 de 15 y más con diabetes bajo control.';
$data112['label']['numerador'] = 'N° de personas con DM2 bajo control de
    15 y más años con una evaluación de pié viegente en el año t.';
$data112['label']['denominador'] = 'N° total de pacientes diabéticos de
    15 años y más bajo controlen nivel primario. * 100.';
$data112['meta'] = '≥90%';
$data112['ponderacion'] = '10%';


/* ==== Inicializar el arreglo de datos $data ==== */
$data112['numerador'] = '';
$data112['numerador_6'] = '';
$data112['numerador_12'] = '';
$data112['denominador'] = '';
$data112['denominador_6'] = '';
$data112['denominador_12'] = '';

$data112['cumplimiento'] = '';


$sql_numerador = "SELECT r.Mes AS mes, SUM(COALESCE(Col01,0)) AS valor
                FROM {$year}rems r
                WHERE (Mes = 6 OR Mes = 12)
                    AND CodigoPrestacion IN ('P4190809','P4170300','P4190500','P4190600')
                GROUP BY r.Mes
                ORDER BY r.Mes";
$numeradores = DB::connection('mysql_rem')->select($sql_numerador);

foreach($numeradores as $numerador) {
    switch($numerador->mes) {
        case 6:  $data112['numerador_6'] = $numerador->valor; break;
        case 12: $data112['numerador_12'] = $numerador->valor; break;
    }
}

$sql_denominador = "SELECT r.Mes AS mes, SUM(COALESCE(Col01,0)) AS valor
                    FROM {$year}rems r
                    WHERE (Mes = 6 OR Mes = 12)
                        AND CodigoPrestacion IN ('P4150602')
                    GROUP BY r.Mes
                    ORDER BY r.Mes";
$denominadores = DB::connection('mysql_rem')->select($sql_denominador);

foreach($denominadores as $denominador) {
    switch($denominador->mes) {
        case 6:  $data112['denominador_6'] = $denominador->valor; break;
        case 12: $data112['denominador_12'] = $denominador->valor; break;
    }
}

switch($ultimo_rem){
    case 1:
    case 2:
    case 3:
    case 4:
    case 5:
        $data112['numerador'] = '';
        $data112['denominador'] = '';
        $data112['cumplimiento'] = '';
        break;
    case 6:
    case 7:
    case 8:
    case 9:
    case 10:
    case 11:
        if($data112['denominador_6'] AND $data112['denominador_6'] != 0) {
            $data112['cumplimiento'] = $data112['numerador_6'] / $data112['denominador_6'] * 100;
        }
        else {
            $data112['cumplimiento'] = 0;
        }
        $data112['numerador'] = $data112['numerador_6'] = number_format($data112['numerador_6'], 0, ',', '.');
        $data112['denominador'] = $data112['denominador_6'] = number_format($data112['denominador_6'], 0, ',', '.');
        break;
    case 12:
        if($data112['denominador_12'] AND $data112['denominador_12'] != 0) {
            $data112['cumplimiento'] = $data112['numerador_12'] / $data112['denominador_12'] * 100;
        }
        else {
            $data112['cumplimiento'] = 0;
        }
        $data112['numerador'] = $data112['numerador_12'] = number_format($data112['numerador_12'], 0, ',', '.');
        $data112['denominador'] = $data112['denominador_12'] = number_format($data112['denominador_12'], 0, ',', '.');
        break;
}

/**** INDICADOR 1.1.3 ****/
$data113['label']['meta'] = '1.1.3 Pacientes hipertensos compensados
    bajo control en el grupo de 15 años y más.';
$data113['label']['numerador'] = 'N° personas con HTA de 15 a 79 años
    con presión arterial bajo 140/90 mmHg, según último control vigente
    en los últimos 12 meses + N° de personas con HTC de 80 y más años
    con presión arterial bajo 150/90 mmHg, según último control vigente,
    en los últimos 12 meses.';
$data113['label']['denominador'] = 'N° total de pacientes hipertensos de
    15 años y más bajo control en el nivel primario * 100.';
$data113['meta'] = '≥68%';
$data113['ponderacion'] = '6.5%';

/* ==== Inicializar el arreglo de datos $data ==== */
$data113['numerador'] = '';
$data113['numerador_6'] = '';
$data113['numerador_12'] = '';
$data113['denominador'] = '';
$data113['denominador_6'] = '';
$data113['denominador_12'] = '';

$data113['cumplimiento'] = '';


$sql_numerador = "SELECT r.Mes AS mes, SUM(COALESCE(Col01,0)) AS valor
                FROM {$year}rems r
                WHERE (Mes = 6 OR Mes = 12)
                    AND CodigoPrestacion IN ('P4180200','P4200100')
                GROUP BY r.Mes
                ORDER BY r.Mes";
$numeradores = DB::connection('mysql_rem')->select($sql_numerador);

foreach($numeradores as $numerador) {
    switch($numerador->mes) {
        case 6:  $data113['numerador_6'] = $numerador->valor; break;
        case 12: $data113['numerador_12'] = $numerador->valor; break;
    }
}

$sql_denominador = "SELECT r.Mes AS mes, SUM(COALESCE(Col01,0)) AS valor
                    FROM {$year}rems r
                    WHERE (Mes = 6 OR Mes = 12)
                        AND CodigoPrestacion IN ('P4150601')
                    GROUP BY r.Mes
                    ORDER BY r.Mes";
$denominadores = DB::connection('mysql_rem')->select($sql_denominador);

foreach($denominadores as $denominador) {
    switch($denominador->mes) {
        case 6:  $data113['denominador_6'] = $denominador->valor; break;
        case 12: $data113['denominador_12'] = $denominador->valor; break;
    }
}

switch($ultimo_rem){
    case 1:
    case 2:
    case 3:
    case 4:
    case 5:
        $data113['numerador'] = '';
        $data113['denominador'] = '';
        $data113['cumplimiento'] = '';
        break;
    case 6:
    case 7:
    case 8:
    case 9:
    case 10:
    case 11:
        if($data113['denominador_6'] AND $data113['denominador_6'] != 0) {
            $data113['cumplimiento'] = $data113['numerador_6'] / $data113['denominador_6'] * 100;
        }
        else {
            $data113['cumplimiento'] = 0;
        }
        $data113['numerador'] = $data113['numerador_6'] = number_format($data113['numerador_6'], 0, ',', '.');
        $data113['denominador'] = $data113['denominador_6'] = number_format($data113['denominador_6'], 0, ',', '.');
        break;
    case 12:
        if($data113['denominador_12'] AND $data113['denominador_12'] != 0) {
            $data113['cumplimiento'] = $data113['numerador_12'] / $data113['denominador_12'] * 100;
        }
        else {
            $data113['cumplimiento'] = 0;
        }
        $data113['numerador'] = $data113['numerador_12'] = number_format($data113['numerador_12'], 0, ',', '.');
        $data113['denominador'] = $data113['denominador_12'] = number_format($data113['denominador_12'], 0, ',', '.');
        break;
}

/**** INDICADOR 1.2 ****/
$data12['label']['meta'] = '1.2 Porcentaje de Intervenciones Quirúrgicas
    Suspendidas.';
$data12['label']['numerador'] = 'N° de intervenciones en especialidad
    quirúrgicas suspendidas en el establecimiento en el periodo.';
$data12['label']['denominador'] = 'N° total de intervencines en
    especialidad quirúrgicas programadas en tabla en el periodo * 100.';
$data12['meta'] = '<=7%';
$data12['ponderacion'] = '7%';

/* Inicializar los meses, si son menores al ultimo rem cargado */
for($mes = 1; $mes <= 12; $mes ++) {
    if($mes <= $ultimo_rem) {
        $data12['numeradores'][$mes] = 0;
        $data12['denominadores'][$mes] = 0;
    }
    else {
        $data12['numeradores'][$mes] = '-';
        $data12['denominadores'][$mes] = '-';
    }
}

$data12['numerador_acumulado'] = 0;
$data12['denominador_acumulado'] = 0;

$sql_valores =
    "SELECT Mes AS mes,
        (SUM(ifnull(Col07,0)) + SUM(ifnull(Col08,0))) AS numerador,
        (SUM(ifnull(Col05,0)) + SUM(ifnull(Col06,0))) AS denominador
    FROM 2019prestaciones p
    LEFT JOIN 2019rems r
    ON p.codigo_prestacion = r.CodigoPrestacion
    WHERE Nserie = 'A21' AND IdEstablecimiento = 102100 AND r.Ano = 2019 AND
    codigo_prestacion IN
        (21500600, 21600800, 21600900, 21700100, 21500700, 21500800,
        21700300, 21700400, 21700500, 21700600, 21500900, 21700700)
    GROUP BY Mes";
$valores = DB::connection('mysql_rem')->select($sql_valores);

foreach($valores as $valor) {
    $data12['numeradores'][$valor->mes] = intval($valor->numerador);
    $data12['numerador_acumulado'] += intval($valor->numerador);
    $data12['denominadores'][$valor->mes] = intval($valor->denominador);
    $data12['denominador_acumulado'] += intval($valor->denominador);
}

/* Calcular el cumplimento */
if($data12['denominador_acumulado'] != 0) {
    $data12['cumplimiento'] = round($data12['numerador_acumulado'] /
                              $data12['denominador_acumulado'] * 100,1);
}

/**** INDICADOR b ****/
$datab['label']['meta'] = 'b. Porcentaje de cumplimento de la
    programación anual de consulta médicas realizadas por especialista.';
$datab['label']['numerador'] = 'N° de consultas epecialista realizadas
    durante el periodo.';
$datab['label']['denominador'] = 'N° total de consultas de especialistas
    programadas y validadas para igual periodo * 100.';
$datab['meta'] = '≥95%';
$datab['ponderacion'] = '7%';

$datab['numerador_acumulado'] = 0;
$datab['denominador_acumulado'] = 0;

/* Inicializar los meses, si son menores al ultimo rem cargado */
for($mes = 1; $mes <= 12; $mes ++) {
    if($mes <= $ultimo_rem) {
        $datab['denominadores'][$mes] = 9335;
        $datab['numeradores'][$mes] = 0;
        $datab['denominador_acumulado'] += $datab['denominadores'][$mes];
    }
    else {
        $datab['numeradores'][$mes] = '-';
        $datab['denominadores'][$mes] = '-';
    }
}

//$datab['numerador_acumulado'] = 0;
//$datab['denominador_acumulado'] = 37340;

$sql_numeradores =
"SELECT Mes AS mes, floor(SUM(ifnull(Col01,0))) AS numerador
FROM 2019prestaciones p
LEFT JOIN 2019rems r
ON p.codigo_prestacion = r.CodigoPrestacion
WHERE Nserie = 'A07' AND IdEstablecimiento = 102100 AND r.Ano = 2019 AND
codigo_prestacion IN
    (7020130, 7020230, 7020330, 7020331, 7020332, 7024219, 7020500,
    7020501, 7020600, 7020601, 7020700, 7020800, 7020801, 7020900,
    7020901, 7021000, 7021001, 7021100, 7021101, 7021230, 7021300,
    7021301, 7022000, 7022001, 7021531, 7022132, 7022133, 7022134,
    7021700, 7021800, 7021801, 7021900, 7022130, 7022142, 7022143,
    7022144, 7022135, 7022136, 7022137, 7022700, 7022800, 7022900,
    7021701, 7023100, 7023200, 7023201, 7023202, 7023203, 7023700,
    7023701, 7023702, 7023703, 7024000, 7024001, 7024200, 7030500,
    7024201, 7024202, 7030501, 7030502)
GROUP BY Mes;";

$valores = DB::connection('mysql_rem')->select($sql_numeradores);

foreach($valores as $valor) {
    $datab['numeradores'][$valor->mes] = intval($valor->numerador);
    $datab['numerador_acumulado'] += intval($valor->numerador);
}

/* Calcular el cumplimento */
if($datab['denominador_acumulado'] != 0) {
    $datab['cumplimiento'] = round($datab['numerador_acumulado'] /
                              $datab['denominador_acumulado'] * 100,1);
}
else {
    $datab['cumplimiento'] = 0;
}

/**** INDICADOR c ****/
$datac['label']['meta'] = 'c. Porcentaje de Cumplimiento de la
    Programación anual de Consultas Médicas realizadas en modalidad
    Telemedicina.';
$datac['label']['numerador'] = 'N° total de consultas médicas de
    espcialidad realizadas a través de telemedicina, durante el periodo.';
$datac['label']['denominador'] = 'N° total de consultas de especialista
    programadas y validadas para igual perido * 100.';
$datac['meta'] = '≥95%';
$datac['ponderacion'] = '6%';

/* Inicializar los meses, si son menores al ultimo rem cargado */
for($mes = 1; $mes <= 12; $mes ++) {
    if($mes <= $ultimo_rem) {
        $datac['numeradores'][$mes] = 0;
        //$datac['denominadores'][$mes] = 0;
    }
    else {
        $datac['numeradores'][$mes] = '-';
        //$datac['denominadores'][$mes] = '-';
    }
}

$datac['numerador_acumulado'] = 0;
$datac['denominador_acumulado'] = 42;

$sql_numeradores =
"SELECT Mes AS mes, FLOOR(
    SUM(ifnull(Col09,0)) +
    SUM(ifnull(Col10,0)) +
    SUM(ifnull(Col11,0)) +
    SUM(ifnull(Col12,0))
) AS numerador
FROM 2019prestaciones p
LEFT JOIN 2019rems r
ON p.codigo_prestacion = r.CodigoPrestacion
WHERE Nserie = 'A30' AND IdEstablecimiento = 102100 AND r.Ano = 2019 AND
codigo_prestacion IN (
    30000000, 30000001, 30000002, 30000003, 30000004, 30000005, 30000006,
    30000007, 30000008, 30000009, 30000010, 30000011, 30000012, 30000013,
    30000014, 30000015, 30000016, 30000017, 30000018, 30000019, 30000020,
    30000021, 30000022, 30000023, 30000024, 30000025, 30000026, 30000027,
    30000028, 30000029, 30000030, 30000031, 30000032, 30000033, 30000034,
    30000035, 30000036, 30000037, 30000038, 30000039, 30000040, 30000041,
    30000042, 30000043, 30000044, 30000045, 30000046, 30000047, 30000048,
    30000049, 30000050, 30000051, 30000052, 30000053, 30000054, 30000086,
    30000055, 30000056, 30000087, 30000088
)
GROUP BY Mes;
";

$valores = DB::connection('mysql_rem')->select($sql_numeradores);

foreach($valores as $valor) {
    $datac['numeradores'][$valor->mes] = intval($valor->numerador);
    $datac['numerador_acumulado'] += intval($valor->numerador);
}

/* Calcular el cumplimento */
if($datac['denominador_acumulado'] != 0) {
    $datac['cumplimiento'] = round($datac['numerador_acumulado'] /
                              $datac['denominador_acumulado'] * 100,1);
}
else $datac['cumplimiento'] = 0;

/**** INDICADOR d ****/
$datad['label']['meta'] = 'd. Variación procentual de pacientes que
    esperan más de 12 horas en la Unidad de Emeergencia Hospitalaria
    UEH para ceder a una cama de dotación.';
$datad['label']['numerador'] = 'Porcentaje de pacientes proventientes
    del UEH, que se hospitalizan después de las 12 horas desde la
    indicación, en periodo t-2  - Porcentaje de pacientes provenientes
    desde la UEH, que se hospitalizan después de las 12 horas desde la
    indicación en perioro t.';
$datad['label']['denominador'] = 'Porcentaje de pacientes provenientes
    la la UEH, que se hospitalizan después de las 12 horas desde la
    indicación en periodo t-2 * 100.';
$datad['meta'] = '>=5% de reducción';


$datad['ponderacion'] = '27%';
$datad['cumplimiento'] = 0;
$datad['numerador_acumulado'] = 0;
$datad['denominador_acumulado'] = 0;

/* ===== denominador ===== */
/* Primero los denominadores porque los uso para calcular el numerador */
$datad['denominadores'] =  [1=>2.5, 2=>4.2, 3=>2.0,  4=>2.1,  5=>1.6,  6=>1.0,
                 7=>2.4, 8=>2.7, 9=>1.4, 10=>1.3, 11=>1.4, 12=>2.7];

/* ==== Inicializar en 0 el arreglo de datos $data ==== */
for($mes = 1; $mes <= 12; $mes ++) {
    if($mes <= $ultimo_rem) {
        $datad['numeradores'][$mes] = 0;
        //$datad['denominadores'][$mes] = 0;
    }
    else {
        $datad['numeradores'][$mes] = '-';
        $datad['denominadores'][$mes] = '-';
    }
}

/* ===== Query numerador ===== */
$sql_numerador = "SELECT e.servicio_salud, e.alias_estab, r.Mes, sum(ifnull(Col01,0)) as numerador
    FROM {$year}rems r
    LEFT JOIN establecimientos e
    ON r.IdEstablecimiento=e.Codigo
    WHERE CodigoPrestacion IN (08222640,08222650,08222660,08221600,08222670,08222680,'08230500A')
    AND e.meta_san_18834_hosp = 1
    GROUP BY e.servicio_salud, e.alias_estab, r.Mes
    ORDER BY e.servicio_salud, e.alias_estab, r.Mes";
$numeradores_totales = DB::connection('mysql_rem')->select($sql_numerador);

foreach($numeradores_totales as $registro) {
    $tmp[$registro->Mes]['totales'] = $registro->numerador;
}

$sql_numerador = "SELECT e.servicio_salud, e.alias_estab, r.Mes, sum(ifnull(Col01,0)) as numerador
    FROM {$year}rems r
    LEFT JOIN establecimientos e
    ON r.IdEstablecimiento=e.Codigo
    WHERE CodigoPrestacion IN (08222650,08222660)
    AND e.meta_san_18834_hosp = 1
    GROUP BY e.servicio_salud, e.alias_estab, r.Mes
    ORDER BY e.servicio_salud, e.alias_estab, r.Mes";
$numeradores = DB::connection('mysql_rem')->select($sql_numerador);

foreach($numeradores as $registro) {
    $tmp[$registro->Mes]['numerador'] = $registro->numerador;
}

foreach($tmp as $key => $mes){
    $tmp[$key]['porcentaje'] = $mes['numerador'] * 100 / $mes['totales'];
    $datad['numeradores'][$key] = round($datad['denominadores'][$key] - $tmp[$key]['porcentaje'],1);
    $datad['numerador_acumulado'] += $datad['numeradores'][$key];
    $datad['denominador_acumulado'] += $datad['denominadores'][$key];
}

/* ==== Calculos ==== */
if($datad['denominador_acumulado'] == 0) {
    /* Si es 0 el denominador entonces el cumplimiento es 0 */
    $datad['cumplimiento'] = 0;
}
else {
    /* De lo contrario calcular el porcentaje */
    $datad['cumplimiento'] =
        round($datad['numerador_acumulado'] /
        $datad['denominador_acumulado'],1);
}

/**** INDICADOR 3.a ****/
$data3a['label']['meta'] = '3.a Porcentaje de Gestión Efectiva para el
    Cumplimiento GES en la Red.';
$data3a['label']['numerador'] = 'Garantías Cumplidas + Garantías
    Exceptuadas + Garantías Incumplidas Atendidas';
$data3a['label']['denominador'] = '(Garantías Cumplidas + Garantías
    Exceptuadas + Garantías Incumplidas Atendidas ´Garantías Incumplidas
    no Atendidas + Garantías Retrsadas) * 100.';
$data3a['meta'] = '100%';
$data3a['ponderacion'] = '7%';

$base_where = array(['law','19664'],['year',$year],['indicator',31],['establishment_id',9]);

for($i = 1; $i <= 12; $i++) {
    $where = array_merge($base_where,array(['month',$i],['position','numerador']));
    $value = SingleParameter::where($where)->first();
    if($value) $data3a['numeradores'][$i] = $value->value;
    else       $data3a['numeradores'][$i] = null;

    $where = array_merge($base_where,array(['month',$i],['position','denominador']));
    $value = SingleParameter::where($where)->first();
    if($value) $data3a['denominadores'][$i] = $value->value;
    else       $data3a['denominadores'][$i] = null;
}

$data3a['numerador_acumulado']   = array_sum($data3a['numeradores']);
$data3a['denominador_acumulado'] = array_sum($data3a['denominadores']);

if($data3a['denominador_acumulado'] != 0) {
    $data3a['cumplimiento'] = $data3a['numerador_acumulado'] / $data3a['denominador_acumulado'] * 100;
}
else $data3a['cumplimiento'] = 0;

/**** INDICADOR 3.b ****/
$data3b['label']['meta'] = '3.b Porcentaje de intervenciones sanitarias
    GES otrogadas según lo programado en contrato PPV para el año t.';
$data3b['label']['numerador'] = 'Número de intervencines sanitarias GES
    de contrato PPV otrogadas dentro del año t.';
$data3b['label']['denominador'] = 'Total de Intervenciones sanitarias
    GES programadas en el contrato PPV para el año t * 100.';
$data3b['meta'] = '100%';
$data3b['ponderacion'] = '12.5%';

$base_where = array(['law','19664'],['year',$year],['indicator',32],
                    ['establishment_id',9],['position','numerador']);


$value = SingleParameter::where($base_where)->first();

if($value) {
    $data3b['numerador_acumulado'] = $value->value;
    $data3b['vigencia'] = $value->month;
}
else {
    $data3b['numerador_acumulado'] = null;
    $data3b['vigencia'] = 1;
}

$base_where = array(['law','19664'],['year',$year],['indicator',32],
                    ['establishment_id',9],['position','denominador']);

$value = SingleParameter::where($base_where)->first();

if($value) $data3b['denominador_acumulado'] = $value->value;
else       $data3b['denominador_acumulado'] = null;



if($data3b['denominador_acumulado'] != 0) {
    $data3b['cumplimiento'] = $data3b['numerador_acumulado'] / $data3b['denominador_acumulado'] * 100;
}
else $data3b['cumplimiento'] = 0;

/***********************************/
/*********** HOSPITAL **************/
/***********************************/

/**** INDICADOR 1.2 ****/
$data12_hetg['label']['meta'] = '1.2 Porcentaje de Intervenciones Quirúrgicas
    Suspendidas.';
$data12_hetg['label']['numerador'] = 'N° de intervenciones en especialidad
    quirúrgicas suspendidas en el establecimiento en el periodo.';
$data12_hetg['label']['denominador'] = 'N° total de intervencines en
    especialidad quirúrgicas programadas en tabla en el periodo * 100.';
$data12_hetg['meta'] = '<=7%';
$data12_hetg['ponderacion'] = '7%';

/* Inicializar los meses, si son menores al ultimo rem cargado */
for($mes = 1; $mes <= 12; $mes ++) {
    if($mes <= $ultimo_rem) {
        $data12_hetg['numeradores'][$mes] = 0;
        $data12_hetg['denominadores'][$mes] = 0;
    }
    else {
        $data12_hetg['numeradores'][$mes] = '-';
        $data12_hetg['denominadores'][$mes] = '-';
    }
}

$data12_hetg['numerador_acumulado'] = 0;
$data12_hetg['denominador_acumulado'] = 0;

$sql_valores =
    "SELECT Mes AS mes,
      (SUM(ifnull(Col07,0)) + SUM(ifnull(Col08,0))) AS numerador,
      (SUM(ifnull(Col05,0)) + SUM(ifnull(Col06,0))) AS denominador
    FROM 2019prestaciones p
    LEFT JOIN 2019rems r
    ON p.codigo_prestacion = r.CodigoPrestacion
    WHERE Nserie = 'A21' AND IdEstablecimiento = 102100 AND r.Ano = 2019 AND
    codigo_prestacion IN
        (21500600, 21600800, 21600900, 21700100, 21500700, 21500800,
        21700300, 21700400, 21700500, 21700600, 21500900, 21700700)
    GROUP BY Mes";
$valores = DB::connection('mysql_rem')->select($sql_valores);

foreach($valores as $valor) {
    $data12_hetg['numeradores'][$valor->mes] = intval($valor->numerador);
    $data12_hetg['numerador_acumulado'] += intval($valor->numerador);
    $data12_hetg['denominadores'][$valor->mes] = intval($valor->denominador);
    $data12_hetg['denominador_acumulado'] += intval($valor->denominador);
}

/* Calcular el cumplimento */
if($data12_hetg['denominador_acumulado'] != 0) {
    $data12_hetg['cumplimiento'] = round($data12_hetg['numerador_acumulado'] /
                              $data12_hetg['denominador_acumulado'] * 100,1);
}

/**** INDICADOR 1.3 ****/
$data13_hetg['label']['meta'] = '1.3 Porcentaje de ambulatorización de
    cirugías mayores en el año t.';
$data13_hetg['label']['numerador'] = 'N° de egreos de CMA.';
$data13_hetg['label']['denominador'] = '(N° e Egresos de CMA + Número de
    Egresos totales no ambulatorios) * 100.';
$data13_hetg['meta'] = '≥42%';
$data13_hetg['ponderacion'] = '';

$base_where = array(['law','19664'],['year',$year],['indicator',13],['establishment_id',1]);

for($i = 1; $i <= 12; $i++) {
    $where = array_merge($base_where,array(['month',$i],['position','numerador']));
    $value = SingleParameter::where($where)->first();
    if($value) $data13_hetg['numeradores'][$i] = $value->value;
    else       $data13_hetg['numeradores'][$i] = null;

    $where = array_merge($base_where,array(['month',$i],['position','denominador']));
    $value = SingleParameter::where($where)->first();
    if($value) $data13_hetg['denominadores'][$i] = $value->value;
    else       $data13_hetg['denominadores'][$i] = null;
}

$data13_hetg['numerador_acumulado']   = array_sum($data13_hetg['numeradores']);
$data13_hetg['denominador_acumulado'] = array_sum($data13_hetg['denominadores']);

if($data13_hetg['denominador_acumulado'] != 0) {
    $data13_hetg['cumplimiento'] = $data13_hetg['numerador_acumulado'] / $data13_hetg['denominador_acumulado'] * 100;
}
else $data13_hetg['cumplimiento'] = 0;



/**** INDICADOR 1.4 ****/
$data14_hetg['label']['meta'] = '1.4 Variación procentual del número de días
    promedio de espera para intervenciones quirúrgicas, según línea base.';
$data14_hetg['label']['numerador'] = '1. Para Calculo de Meta de Reducción,
    según Tabla N°1 (No ingresar en plataforma DIPRES):
    ((Promedio de días de espera de las intervenciones quirúrgicas
    electivas del año t-1 del establecimiento) - (promedio de días de
    espera de las intervenciones quirúrgicas electivas del año t-1 nacional)';
$data14_hetg['label']['denominador'] = '(promedio de días de espera de las
    intervenciones quirúrgicas electivas del año t-1 nacional)) *100';
$data14_hetg['meta'] = '100%';
$data14_hetg['ponderacion'] = '';


$base_where = array(['law','19664'],['year',$year],['indicator',14],['establishment_id',1]);

for($i = 1; $i <= 12; $i++) {
    $where = array_merge($base_where,array(['month',$i],['position','numerador']));
    $value = SingleParameter::where($where)->first();
    if($value) $data14_hetg['numeradores'][$i] = $value->value;
    else       $data14_hetg['numeradores'][$i] = null;

    $where = array_merge($base_where,array(['month',$i],['position','denominador']));
    $value = SingleParameter::where($where)->first();
    if($value) $data14_hetg['denominadores'][$i] = $value->value;
    else       $data14_hetg['denominadores'][$i] = null;
}

$data14_hetg['numerador_acumulado']   = array_sum($data14_hetg['numeradores']);
$data14_hetg['denominador_acumulado'] = array_sum($data14_hetg['denominadores']);

if($data14_hetg['denominador_acumulado'] != 0) {
    $data14_hetg['cumplimiento'] = $data14_hetg['numerador_acumulado'] / $data14_hetg['denominador_acumulado'] * 100;
}
else $data14_hetg['cumplimiento'] = 0;


/**** INDICADOR a ****/
$dataa_hetg['label']['meta'] = 'a. Porcentaje de altas Odonotlógicas de
    especialidades del nivel secundario por ingreso de tratamiento.';
$dataa_hetg['label']['numerador'] = 'N° de altas de tratamiento odonológico
    de especialidades del periodo.';
$dataa_hetg['label']['denominador'] = 'N° de ingresos a tratamiento
    odonológico de especialidades del periodo * 100.';
$dataa_hetg['meta'] = '≥60%';
$dataa_hetg['ponderacion'] = '6%';

/* Inicializar los meses, si son menores al ultimo rem cargado */
for($mes = 1; $mes <= 12; $mes ++) {
    if($mes <= $ultimo_rem) {
        $dataa_hetg['numeradores'][$mes] = 0;
        $dataa_hetg['denominadores'][$mes] = 0;
    }
    else {
        $dataa_hetg['numeradores'][$mes] = '-';
        $dataa_hetg['denominadores'][$mes] = '-';
    }
}

$dataa_hetg['numerador_acumulado'] = 0;
$dataa_hetg['denominador_acumulado'] = 0;

$sql_numeradores =
    "SELECT Mes AS mes, floor(SUM(ifnull(Col01,0))) AS numerador
    FROM 2019prestaciones p
    LEFT JOIN 2019rems r
    ON p.codigo_prestacion = r.CodigoPrestacion
    WHERE Nserie = 'A09' AND IdEstablecimiento = 102100 AND r.Ano = 2019 AND
    codigo_prestacion IN
        (09216213, 09204954, 09216613, 09217013, 09217513, 09218013,
        09218413, 09218913, 09219313, 09309050, 09309250, 09240600)
    GROUP BY Mes";
$valores = DB::connection('mysql_rem')->select($sql_numeradores);

foreach($valores as $valor) {
    $dataa_hetg['numeradores'][$valor->mes] = intval($valor->numerador);
    $dataa_hetg['numerador_acumulado'] += intval($valor->numerador);
}

$sql_denominadores =
    "SELECT Mes AS mes, floor(SUM(ifnull(Col01,0))) AS denominador
    FROM 2019prestaciones p
    LEFT JOIN 2019rems r
    ON p.codigo_prestacion = r.CodigoPrestacion
    WHERE Nserie = 'A09' AND IdEstablecimiento = 102100 AND r.Ano = 2019 AND
    codigo_prestacion IN
        (09216113, 09204953, 09216513, 09216913, 09217413, 09217913,
         09218313, 09218813, 09219213, 09309000, 09309200, 09240500)
    GROUP BY Mes";
$valores = DB::connection('mysql_rem')->select($sql_denominadores);


foreach($valores as $valor) {
    $dataa_hetg['denominadores'][$valor->mes] = intval($valor->denominador);
    $dataa_hetg['denominador_acumulado'] += intval($valor->denominador);
}

/* Calcular el cumplimento */
if($dataa_hetg['denominador_acumulado'] != 0) {
    $dataa_hetg['cumplimiento'] = round($dataa_hetg['numerador_acumulado'] /
                              $dataa_hetg['denominador_acumulado'] * 100,1);
}
else {
    $dataa_hetg['cumplimiento'] = 0;
}

/**** INDICADOR b ****/
$datab_hetg['label']['meta'] = 'b. Porcentaje de cumplimento de la
    programación anual de consulta médicas realizadas por especialista.';
$datab_hetg['label']['numerador'] = 'N° de consultas epecialista realizadas
    durante el periodo.';
$datab_hetg['label']['denominador'] = 'N° total de consultas de especialistas
    programadas y validadas para igual periodo * 100.';
$datab_hetg['meta'] = '≤95%';
$datab_hetg['ponderacion'] = '7%';

$datab_hetg['numerador_acumulado'] = 0;
$datab_hetg['denominador_acumulado'] = 0;

/* Inicializar los meses, si son menores al ultimo rem cargado */
for($mes = 1; $mes <= 12; $mes ++) {
    if($mes <= $ultimo_rem) {
        $datab_hetg['denominadores'][$mes] = 9335;
        $datab_hetg['numeradores'][$mes] = 0;
        $datab_hetg['denominador_acumulado'] += $datab_hetg['denominadores'][$mes];
    }
    else {
        $datab_hetg['numeradores'][$mes] = '-';
        $datab_hetg['denominadores'][$mes] = '-';
    }
}



$sql_numeradores =
"SELECT Mes AS mes, floor(SUM(ifnull(Col01,0))) AS numerador
FROM 2019prestaciones p
LEFT JOIN 2019rems r
ON p.codigo_prestacion = r.CodigoPrestacion
WHERE Nserie = 'A07' AND IdEstablecimiento = 102100 AND r.Ano = 2019 AND
codigo_prestacion IN
    (7020130, 7020230, 7020330, 7020331, 7020332, 7024219, 7020500,
    7020501, 7020600, 7020601, 7020700, 7020800, 7020801, 7020900,
    7020901, 7021000, 7021001, 7021100, 7021101, 7021230, 7021300,
    7021301, 7022000, 7022001, 7021531, 7022132, 7022133, 7022134,
    7021700, 7021800, 7021801, 7021900, 7022130, 7022142, 7022143,
    7022144, 7022135, 7022136, 7022137, 7022700, 7022800, 7022900,
    7021701, 7023100, 7023200, 7023201, 7023202, 7023203, 7023700,
    7023701, 7023702, 7023703, 7024000, 7024001, 7024200, 7030500,
    7024201, 7024202, 7030501, 7030502)
GROUP BY Mes;";

$valores = DB::connection('mysql_rem')->select($sql_numeradores);

foreach($valores as $valor) {
    $datab_hetg['numeradores'][$valor->mes] = intval($valor->numerador);
    $datab_hetg['numerador_acumulado'] += intval($valor->numerador);
}

/* Calcular el cumplimento */
if($datab_hetg['denominador_acumulado'] != 0) {
    $datab_hetg['cumplimiento'] = round($datab_hetg['numerador_acumulado'] /
                              $datab_hetg['denominador_acumulado'] * 100,1);
}
else {
    $datab_hetg['cumplimiento'] = 0;
}

/**** INDICADOR c ****/
$datac_hetg['label']['meta'] = 'c. Porcentaje de Cumplimiento de la
    Programación anual de Consultas Médicas realizadas en modalidad
    Telemedicina.';
$datac_hetg['label']['numerador'] = 'N° total de consultas médicas de
    espcialidad realizadas a través de telemedicina, durante el periodo.';
$datac_hetg['label']['denominador'] = 'N° total de consultas de especialista
    programadas y validadas para igual perido * 100.';
$datac_hetg['meta'] = '≤95%';
$datac_hetg['ponderacion'] = '6%';

/* Inicializar los meses, si son menores al ultimo rem cargado */
for($mes = 1; $mes <= 12; $mes ++) {
    if($mes <= $ultimo_rem) {
        $datac_hetg['numeradores'][$mes] = 0;
        //$datac_hetg['denominadores'][$mes] = 0;
    }
    else {
        $datac_hetg['numeradores'][$mes] = '-';
        //$datac_hetg['denominadores'][$mes] = '-';
    }
}

$datac_hetg['numerador_acumulado'] = 0;
/* pasrlo a SingleParameter */
$datac_hetg['denominador_acumulado'] = 42;

$sql_numeradores =
"SELECT Mes AS mes, FLOOR(
  SUM(ifnull(Col09,0)) +
  SUM(ifnull(Col10,0)) +
  SUM(ifnull(Col11,0)) +
  SUM(ifnull(Col12,0))
) AS numerador
FROM 2019prestaciones p
LEFT JOIN 2019rems r
ON p.codigo_prestacion = r.CodigoPrestacion
WHERE Nserie = 'A30' AND IdEstablecimiento = 102100 AND r.Ano = 2019 AND
codigo_prestacion IN (
    30000000, 30000001, 30000002, 30000003, 30000004, 30000005, 30000006,
    30000007, 30000008, 30000009, 30000010, 30000011, 30000012, 30000013,
    30000014, 30000015, 30000016, 30000017, 30000018, 30000019, 30000020,
    30000021, 30000022, 30000023, 30000024, 30000025, 30000026, 30000027,
    30000028, 30000029, 30000030, 30000031, 30000032, 30000033, 30000034,
    30000035, 30000036, 30000037, 30000038, 30000039, 30000040, 30000041,
    30000042, 30000043, 30000044, 30000045, 30000046, 30000047, 30000048,
    30000049, 30000050, 30000051, 30000052, 30000053, 30000054, 30000086,
    30000055, 30000056, 30000087, 30000088
)
GROUP BY Mes;
";

$valores = DB::connection('mysql_rem')->select($sql_numeradores);

foreach($valores as $valor) {
    $datac_hetg['numeradores'][$valor->mes] = intval($valor->numerador);
    $datac_hetg['numerador_acumulado'] += intval($valor->numerador);
}

/* Calcular el cumplimento */
if($datac_hetg['denominador_acumulado'] != 0) {
    $datac_hetg['cumplimiento'] = round($datac_hetg['numerador_acumulado'] /
                              $datac_hetg['denominador_acumulado'] * 100,1);
}
else $datac_hetg['cumplimiento'] = 0;

/**** INDICADOR e ****/
$datae_hetg['label']['meta'] = 'e. Promedio de días de estadía de pacientes
    derivados vía UUCC a prestadores privados fuera de convenio.';
$datae_hetg['label']['numerador'] = 'N° de días de hospitalización de
    pacientes derivados vía UGCC en el extrasistema.';
$datae_hetg['label']['denominador'] = 'N° total de pacientes derivados vía
    UGCC al extrasistema.';
$datae_hetg['meta'] = '<=10%';
$datae_hetg['ponderacion'] = '';

$base_where = array(['law','19664'],['year',$year],['indicator',25],['establishment_id',1]);

for($i = 1; $i <= 12; $i++) {
    $where = array_merge($base_where,array(['month',$i],['position','numerador']));
    $value = SingleParameter::where($where)->first();
    if($value) $datae_hetg['numeradores'][$i] = $value->value;
    else       $datae_hetg['numeradores'][$i] = null;

    $where = array_merge($base_where,array(['month',$i],['position','denominador']));
    $value = SingleParameter::where($where)->first();
    if($value) $datae_hetg['denominadores'][$i] = $value->value;
    else       $datae_hetg['denominadores'][$i] = null;
}

$datae_hetg['numerador_acumulado']   = array_sum($datae_hetg['numeradores']);
$datae_hetg['denominador_acumulado'] = array_sum($datae_hetg['denominadores']);

if($datae_hetg['denominador_acumulado'] != 0) {
    $datae_hetg['cumplimiento'] = $datae_hetg['numerador_acumulado'] / $datae_hetg['denominador_acumulado'] * 100;
}
else $datae_hetg['cumplimiento'] = 0;

/**** INDICADOR 3.a ****/
$data3a_hetg['label']['meta'] = '3.a Porcentaje de Gestión Efectiva para el
    Cumplimiento GES en la Red.';
$data3a_hetg['label']['numerador'] = 'Garantías Cumplidas + Garantías
    Exceptuadas + Garantías Incumplidas Atendidas';
$data3a_hetg['label']['denominador'] = '(Garantías Cumplidas + Garantías
    Exceptuadas + Garantías Incumplidas Atendidas ´Garantías Incumplidas
    no Atendidas + Garantías Retrsadas) * 100.';
$data3a_hetg['meta'] = '100%';
$data3a_hetg['ponderacion'] = '7%';

$base_where = array(['law','19664'],['year',$year],['indicator',31],['establishment_id',1]);

for($i = 1; $i <= 12; $i++) {
    $where = array_merge($base_where,array(['month',$i],['position','numerador']));
    $value = SingleParameter::where($where)->first();
    if($value) $data3a_hetg['numeradores'][$i] = $value->value;
    else       $data3a_hetg['numeradores'][$i] = null;

    $where = array_merge($base_where,array(['month',$i],['position','denominador']));
    $value = SingleParameter::where($where)->first();
    if($value) $data3a_hetg['denominadores'][$i] = $value->value;
    else       $data3a_hetg['denominadores'][$i] = null;
}

$data3a_hetg['numerador_acumulado']   = array_sum($data3a_hetg['numeradores']);
$data3a_hetg['denominador_acumulado'] = array_sum($data3a_hetg['denominadores']);

if($data3a_hetg['denominador_acumulado'] != 0) {
    $data3a_hetg['cumplimiento'] = $data3a_hetg['numerador_acumulado'] / $data3a_hetg['denominador_acumulado'] * 100;
}
else $data3a_hetg['cumplimiento'] = 0;

/**** INDICADOR 3.b ****/
$data3b_hetg['label']['meta'] = '3.b Porcentaje de intervenciones sanitarias
    GES otrogadas según lo programado en contrato PPV para el año t.';
$data3b_hetg['label']['numerador'] = 'Número de intervencines sanitarias GES
    de contrato PPV otrogadas dentro del año t.';
$data3b_hetg['label']['denominador'] = 'Total de Intervenciones sanitarias
    GES programadas en el contrato PPV para el año t * 100.';
$data3b_hetg['meta'] = '100%';
$data3b_hetg['ponderacion'] = '20%';

$base_where = array(['law','19664'],['year',$year],['indicator',32],
                    ['establishment_id',1],['position','numerador']);


$value = SingleParameter::where($base_where)->first();

if($value) {
    $data3b_hetg['numerador_acumulado'] = $value->value;
    $data3b_hetg['vigencia'] = $value->month;
}
else {
    $data3b_hetg['numerador_acumulado'] = null;
    $data3b_hetg['vigencia'] = 1;
}

$base_where = array(['law','19664'],['year',$year],['indicator',32],
                    ['establishment_id',1],['position','denominador']);

$value = SingleParameter::where($base_where)->first();

if($value) $data3b_hetg['denominador_acumulado'] = $value->value;
else       $data3b_hetg['denominador_acumulado'] = null;



if($data3b_hetg['denominador_acumulado'] != 0) {
    $data3b_hetg['cumplimiento'] = $data3b_hetg['numerador_acumulado'] / $data3b_hetg['denominador_acumulado'] * 100;
}
else $data3b_hetg['cumplimiento'] = 0;


/*********************************/
/*********** REYNO  **************/
/*********************************/

/* INDICADOR 1.1.1 */
$data111_reyno['label']['meta'] = '1.1.1 Pacientes diabéticos compensados en
    el grupo de 15 años y más.';
$data111_reyno['label']['numerador'] = 'N° de personas con DM2 de 15 A 79 años
    con Hemoglobina Glicosilada bajo 7%, según último control en los
    últimos 12 meses + N° de personas con DM2 de 80 años y más con
    Hemoglobina Glicosilada bajo 8% según último control vigente, en los
    últimos 12 meses.';
$data111_reyno['label']['denominador'] = 'Total de pacientes diabéticos de 15
    años y más bajo control en el nivel primario * 100.';
$data111_reyno['meta'] = '≥45%';
$data111_reyno['ponderacion'] = '25%';


/* ==== Inicializar el arreglo de datos $data ==== */
$data111_reyno['numerador'] = '';
$data111_reyno['numerador_6'] = '';
$data111_reyno['numerador_12'] = '';
$data111_reyno['denominador'] = '';
$data111_reyno['denominador_6'] = '';
$data111_reyno['denominador_12'] = '';

$data111_reyno['cumplimiento'] = '';


$sql_numerador = "SELECT r.Mes AS mes, SUM(COALESCE(Col01,0)) AS valor
                FROM {$year}rems r
                JOIN {$year}establecimientos e ON e.Codigo=r.IdEstablecimiento
                WHERE meta_san_18834 = 1
                    AND e.Codigo = 102307
                  AND (Mes = 6 OR Mes = 12)
                  AND CodigoPrestacion IN ('P4180300','P4200200')
                GROUP BY r.Mes
                ORDER BY r.Mes";
$numeradores = DB::connection('mysql_rem')->select($sql_numerador);

foreach($numeradores as $numerador) {
    switch($numerador->mes) {
        case 6:  $data111_reyno['numerador_6'] = $numerador->valor; break;
        case 12: $data111_reyno['numerador_12'] = $numerador->valor; break;
    }
}

$sql_denominador = "SELECT r.Mes AS mes, SUM(COALESCE(Col01,0)) AS valor
                    FROM {$year}rems r
                    JOIN {$year}establecimientos e ON e.Codigo=r.IdEstablecimiento
                    WHERE meta_san_18834 = 1
                        AND e.Codigo = 102307
                      AND (Mes = 6 OR Mes = 12)
                      AND CodigoPrestacion IN ('P4150602')
                    GROUP BY r.Mes
                    ORDER BY r.Mes";
$denominadores = DB::connection('mysql_rem')->select($sql_denominador);

foreach($denominadores as $denominador) {
    switch($denominador->mes) {
        case 6:  $data111_reyno['denominador_6'] = $denominador->valor; break;
        case 12: $data111_reyno['denominador_12'] = $denominador->valor; break;
    }
}

switch($ultimo_rem){
    case 1:
    case 2:
    case 3:
    case 4:
    case 5:
        $data111_reyno['numerador'] = '';
        $data111_reyno['denominador'] = '';
        $data111_reyno['cumplimiento'] = '';
        break;
    case 6:
    case 7:
    case 8:
    case 9:
    case 10:
    case 11:
        if($data111_reyno['denominador_6'] AND $data111_reyno['denominador_6'] != 0) {
            $data111_reyno['cumplimiento'] = $data111_reyno['numerador_6'] / $data111_reyno['denominador_6'] * 100;
        }
        else {
            $data111_reyno['cumplimiento'] = 0;
        }
        $data111_reyno['numerador'] = $data111_reyno['numerador_6'] = number_format($data111_reyno['numerador_6'], 0, ',', '.');
        $data111_reyno['denominador'] = $data111_reyno['denominador_6'] = number_format($data111_reyno['denominador_6'], 0, ',', '.');
        break;
    case 12:
        if($data111_reyno['denominador_12'] AND $data111_reyno['denominador_12'] != 0) {
            $data111_reyno['cumplimiento'] = $data111_reyno['numerador_12'] / $data111_reyno['denominador_12'] * 100;
        }
        else {
            $data111_reyno['cumplimiento'] = 0;
        }
        $data111_reyno['numerador'] = $data111_reyno['numerador_12'] = number_format($data111_reyno['numerador_12'], 0, ',', '.');
        $data111_reyno['denominador'] = $data111_reyno['denominador_12'] = number_format($data111_reyno['denominador_12'], 0, ',', '.');
        break;
}

/**** INDICADOR 1.1.2 ****/
$data112_reyno['label']['meta'] = '1.1.2 Evaluacion Anual de los Pies en
    personas con DM2 de 15 y más con diabetes bajo control.';
$data112_reyno['label']['numerador'] = 'N° de personas con DM2 bajo control de
    15 y más años con una evaluación de pié viegente en el año t.';
$data112_reyno['label']['denominador'] = 'N° total de pacientes diabéticos de
    15 años y más bajo controlen nivel primario. * 100.';
$data112_reyno['meta'] = '≥90%';
$data112_reyno['ponderacion'] = '15%';

/* ==== Inicializar el arreglo de datos $data ==== */
$data112_reyno['numerador'] = '';
$data112_reyno['numerador_6'] = '';
$data112_reyno['numerador_12'] = '';
$data112_reyno['denominador'] = '';
$data112_reyno['denominador_6'] = '';
$data112_reyno['denominador_12'] = '';

$data112_reyno['cumplimiento'] = '';


$sql_numerador = "SELECT r.Mes AS mes, SUM(COALESCE(Col01,0)) AS valor
                FROM {$year}rems r
                JOIN {$year}establecimientos e ON e.Codigo=r.IdEstablecimiento
                WHERE meta_san_18834 = 1
                    AND e.Codigo = 102307
                    AND (Mes = 6 OR Mes = 12)
                    AND CodigoPrestacion IN ('P4190809','P4170300','P4190500','P4190600')
                GROUP BY r.Mes
                ORDER BY r.Mes";
$numeradores = DB::connection('mysql_rem')->select($sql_numerador);

foreach($numeradores as $numerador) {
    switch($numerador->mes) {
        case 6:  $data112_reyno['numerador_6'] = $numerador->valor; break;
        case 12: $data112_reyno['numerador_12'] = $numerador->valor; break;
    }
}

$sql_denominador = "SELECT r.Mes AS mes, SUM(COALESCE(Col01,0)) AS valor
                    FROM {$year}rems r
                    JOIN {$year}establecimientos e ON e.Codigo=r.IdEstablecimiento
                    WHERE meta_san_18834 = 1
                        AND e.Codigo = 102307
                        AND (Mes = 6 OR Mes = 12)
                        AND CodigoPrestacion IN ('P4150602')
                    GROUP BY r.Mes
                    ORDER BY r.Mes";
$denominadores = DB::connection('mysql_rem')->select($sql_denominador);

foreach($denominadores as $denominador) {
    switch($denominador->mes) {
        case 6:  $data112_reyno['denominador_6'] = $denominador->valor; break;
        case 12: $data112_reyno['denominador_12'] = $denominador->valor; break;
    }
}

switch($ultimo_rem){
    case 1:
    case 2:
    case 3:
    case 4:
    case 5:
        $data112_reyno['numerador'] = '';
        $data112_reyno['denominador'] = '';
        $data112_reyno['cumplimiento'] = '';
        break;
    case 6:
    case 7:
    case 8:
    case 9:
    case 10:
    case 11:
        if($data112_reyno['denominador_6'] AND $data112_reyno['denominador_6'] != 0) {
            $data112_reyno['cumplimiento'] = $data112_reyno['numerador_6'] / $data112_reyno['denominador_6'] * 100;
        }
        else {
            $data112_reyno['cumplimiento'] = 0;
        }
        $data112_reyno['numerador'] = $data112_reyno['numerador_6'] = number_format($data112_reyno['numerador_6'], 0, ',', '.');
        $data112_reyno['denominador'] = $data112_reyno['denominador_6'] = number_format($data112_reyno['denominador_6'], 0, ',', '.');
        break;
    case 12:
        if($data112_reyno['denominador_12'] AND $data112_reyno['denominador_12'] != 0) {
            $data112_reyno['cumplimiento'] = $data112_reyno['numerador_12'] / $data112_reyno['denominador_12'] * 100;
        }
        else {
            $data112_reyno['cumplimiento'] = 0;
        }
        $data112_reyno['numerador'] = $data112_reyno['numerador_12'] = number_format($data112_reyno['numerador_12'], 0, ',', '.');
        $data112_reyno['denominador'] = $data112_reyno['denominador_12'] = number_format($data112_reyno['denominador_12'], 0, ',', '.');
        break;
}




/**** INDICADOR 1.1.3 ****/
$data113_reyno['label']['meta'] = '1.1.3 Pacientes hipertensos compensados
    bajo control en el grupo de 15 años y más.';
$data113_reyno['label']['numerador'] = 'N° personas con HTA de 15 a 79 años
    con presión arterial bajo 140/90 mmHg, según último control vigente
    en los últimos 12 meses + N° de personas con HTC de 80 y más años
    con presión arterial bajo 150/90 mmHg, según último control vigente,
    en los últimos 12 meses.';
$data113_reyno['label']['denominador'] = 'N° total de pacientes hipertensos de
    15 años y más bajo control en el nivel primario * 100.';
$data113_reyno['meta'] = '≥68%';
$data113_reyno['ponderacion'] = '10%';

/* ==== Inicializar el arreglo de datos $data ==== */
$data113_reyno['numerador'] = '';
$data113_reyno['numerador_6'] = '';
$data113_reyno['numerador_12'] = '';
$data113_reyno['denominador'] = '';
$data113_reyno['denominador_6'] = '';
$data113_reyno['denominador_12'] = '';

$data113_reyno['cumplimiento'] = '';


$sql_numerador = "SELECT r.Mes AS mes, SUM(COALESCE(Col01,0)) AS valor
                FROM {$year}rems r
                JOIN {$year}establecimientos e ON e.Codigo=r.IdEstablecimiento
                WHERE meta_san_18834 = 1
                    AND e.Codigo = 102307
                    AND (Mes = 6 OR Mes = 12)
                    AND CodigoPrestacion IN ('P4180200','P4200100')
                GROUP BY r.Mes
                ORDER BY r.Mes";
$numeradores = DB::connection('mysql_rem')->select($sql_numerador);

foreach($numeradores as $numerador) {
    switch($numerador->mes) {
        case 6:  $data113_reyno['numerador_6'] = $numerador->valor; break;
        case 12: $data113_reyno['numerador_12'] = $numerador->valor; break;
    }
}

$sql_denominador = "SELECT r.Mes AS mes, SUM(COALESCE(Col01,0)) AS valor
                    FROM {$year}rems r
                    JOIN {$year}establecimientos e ON e.Codigo=r.IdEstablecimiento
                    WHERE meta_san_18834 = 1
                        AND e.Codigo = 102307
                        AND (Mes = 6 OR Mes = 12)
                        AND CodigoPrestacion IN ('P4150601')
                    GROUP BY r.Mes
                    ORDER BY r.Mes";
$denominadores = DB::connection('mysql_rem')->select($sql_denominador);

foreach($denominadores as $denominador) {
    switch($denominador->mes) {
        case 6:  $data113_reyno['denominador_6'] = $denominador->valor; break;
        case 12: $data113_reyno['denominador_12'] = $denominador->valor; break;
    }
}

switch($ultimo_rem){
    case 1:
    case 2:
    case 3:
    case 4:
    case 5:
        $data113_reyno['numerador'] = '';
        $data113_reyno['denominador'] = '';
        $data113_reyno['cumplimiento'] = '';
        break;
    case 6:
    case 7:
    case 8:
    case 9:
    case 10:
    case 11:
        if($data113_reyno['denominador_6'] AND $data113_reyno['denominador_6'] != 0) {
            $data113_reyno['cumplimiento'] = $data113_reyno['numerador_6'] / $data113_reyno['denominador_6'] * 100;
        }
        else {
            $data113_reyno['cumplimiento'] = 0;
        }
        $data113_reyno['numerador'] = $data113_reyno['numerador_6'] = number_format($data113_reyno['numerador_6'], 0, ',', '.');
        $data113_reyno['denominador'] = $data113_reyno['denominador_6'] = number_format($data113_reyno['denominador_6'], 0, ',', '.');
        break;
    case 12:
        if($data113_reyno['denominador_12'] AND $data113_reyno['denominador_12'] != 0) {
            $data113_reyno['cumplimiento'] = $data113_reyno['numerador_12'] / $data113_reyno['denominador_12'] * 100;
        }
        else {
            $data113_reyno['cumplimiento'] = 0;
        }
        $data113_reyno['numerador'] = $data113_reyno['numerador_12'] = number_format($data113_reyno['numerador_12'], 0, ',', '.');
        $data113_reyno['denominador'] = $data113_reyno['denominador_12'] = number_format($data113_reyno['denominador_12'], 0, ',', '.');
        break;
}


$data3a_reyno['label']['meta'] = '3.a Porcentaje de Gestión Efectiva para el
    Cumplimiento GES en la Red.';
$data3a_reyno['label']['numerador'] = 'Garantías Cumplidas + Garantías
    Exceptuadas + Garantías Incumplidas Atendidas';
$data3a_reyno['label']['denominador'] = '(Garantías Cumplidas + Garantías
    Exceptuadas + Garantías Incumplidas Atendidas ´Garantías Incumplidas
    no Atendidas + Garantías Retrsadas) * 100.';
$data3a_reyno['meta'] = '100%';
$data3a_reyno['ponderacion'] = '50%';

$base_where = array(['law','19664'],['year',$year],['indicator',31],['establishment_id',12]);

for($i = 1; $i <= 12; $i++) {
    $where = array_merge($base_where,array(['month',$i],['position','numerador']));
    $value = SingleParameter::where($where)->first();
    if($value) $data3a_reyno['numeradores'][$i] = $value->value;
    else       $data3a_reyno['numeradores'][$i] = null;

    $where = array_merge($base_where,array(['month',$i],['position','denominador']));
    $value = SingleParameter::where($where)->first();
    if($value) $data3a_reyno['denominadores'][$i] = $value->value;
    else       $data3a_reyno['denominadores'][$i] = null;
}

$data3a_reyno['numerador_acumulado']   = array_sum($data3a_reyno['numeradores']);
$data3a_reyno['denominador_acumulado'] = array_sum($data3a_reyno['denominadores']);

if($data3a_reyno['denominador_acumulado'] != 0) {
    $data3a_reyno['cumplimiento'] = $data3a_reyno['numerador_acumulado'] / $data3a_reyno['denominador_acumulado'] * 100;
}
else $data3a_reyno['cumplimiento'] = 0;
//dd($datab);
?>
