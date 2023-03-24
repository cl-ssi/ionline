<?php
namespace App\Http\Controllers\Indicators\_2020;

use Illuminate\Support\Facades\DB;
use App\Models\Indicators\SingleParameter;

$last_year= 2019;
$year= 2020;

$sql_ultimo_rem = "SELECT MAX(Mes) as ultimo_rem FROM 2020rems;";
$ultimo_rem = DB::connection('mysql_rem')->select($sql_ultimo_rem)[0]->ultimo_rem;


/********** META 1.1. **********/
$data11_reyno = array();

$data11_reyno['label']['meta'] = '1.1. Pacientes diabéticos compensados en el
    grupo de 15 años y más.';
$data11_reyno['label']['numerador'] = '(N° de personas con DM2 de 15 a 79 años con
    hemoglobina gilcosilada bajo 7% según último control vigente en los  últimos
    12 meses) + (N° de personas con DM2 de 80 años y más años con hemoglobina
    glicosilada bajo 8%), según último control vigente en los últimos 12 meses.';
$data11_reyno['label']['denominador'] = 'Total de pacientes diabéticos de 15 años
    y más bajo control en el nivel primario * 100.';

$data11_reyno['label']['fuente']['numerador'] = 'REM';
$data11_reyno['label']['fuente']['denominador'] = 'REM';

$data11_reyno['meta'] = '45';
$data11_reyno['ponderacion'] = '20%';

/* ==== Inicializar en 0 el arreglo de datos $data ==== */
$data11_reyno['numerador_12a'] = '';
$data11_reyno['denominador_12a'] = '';

$data11_reyno['numerador'] = '';
$data11_reyno['numerador_6'] = '';
$data11_reyno['numerador_12'] = '';
$data11_reyno['denominador'] = '';
$data11_reyno['denominador_6'] = '';
$data11_reyno['denominador_12'] = '';

$data11_reyno['cumplimiento'] = '';

$data11_reyno['aporte'] = '';

/* AÑO ANTERIOR */

$sql_numerador = "SELECT r.Mes AS mes, sum(COALESCE(Col01,0)) as valor
                    FROM {$last_year}rems r
                    WHERE IdEstablecimiento = 102307 AND
                    Mes = 12
                    AND CodigoPrestacion IN ('P4180300','P4200200')
                    GROUP BY IdEstablecimiento, r.Mes
                    ORDER BY IdEstablecimiento, r.Mes";
$numeradores = DB::connection('mysql_rem')->select($sql_numerador);

foreach($numeradores as $numerador) {
    switch($numerador->mes) {
        case 12: $data11_reyno['numerador_12a'] = $numerador->valor; break;
    }
}

$sql_denominador = "SELECT r.Mes AS mes, sum(COALESCE(Col01,0)) as valor
                    FROM {$last_year}rems r
                    WHERE IdEstablecimiento = 102307 AND
                    Mes = 12
                    AND CodigoPrestacion IN ('P4150602')
                    GROUP BY IdEstablecimiento, r.Mes
                    ORDER BY IdEstablecimiento, r.Mes";
$denominadores = DB::connection('mysql_rem')->select($sql_denominador);

foreach($denominadores as $denominador) {
    switch($denominador->mes) {
        case 12: $data11_reyno['denominador_12a'] = $denominador->valor; break;
    }
}

/* -------------------------------------------------------------------------- */

/* AÑO T */

$sql_numerador = "SELECT r.Mes AS mes, sum(COALESCE(Col01,0)) as valor
                    FROM {$year}rems r
                    WHERE IdEstablecimiento = 102307 AND (Mes = 6 OR Mes = 12)
                    AND CodigoPrestacion IN ('P4180300','P4200200')
                    GROUP BY IdEstablecimiento, r.Mes
                    ORDER BY IdEstablecimiento, r.Mes";
$numeradores = DB::connection('mysql_rem')->select($sql_numerador);

foreach($numeradores as $numerador) {
    switch($numerador->mes) {
        case 6:  $data11_reyno['numerador_6'] = $numerador->valor; break;
        case 12: $data11_reyno['numerador_12'] = $numerador->valor; break;
    }
}

$sql_denominador = "SELECT r.Mes AS mes, sum(COALESCE(Col01,0)) as valor
                    FROM {$year}rems r
                    WHERE IdEstablecimiento = 102307 AND (Mes = 6 OR Mes = 12)
                    AND CodigoPrestacion IN ('P4150602')
                    GROUP BY IdEstablecimiento, r.Mes
                    ORDER BY IdEstablecimiento, r.Mes";
$denominadores = DB::connection('mysql_rem')->select($sql_denominador);

foreach($denominadores as $denominador) {
    switch($denominador->mes) {
        case 6:  $data11_reyno['denominador_6'] = $denominador->valor; break;
        case 12: $data11_reyno['denominador_12'] = $denominador->valor; break;
    }
}

switch($ultimo_rem){
    case 1:
    case 2:
    case 3:
    case 4:
    case 5:
        $data11_reyno['numerador'] = '';
        $data11_reyno['denominador'] = '';
        $data11_reyno['cumplimiento'] = '';
        break;
    case 6:
    case 7:
    case 8:
    case 9:
    case 10:
    case 11:
        if($data11_reyno['denominador_6'] AND $data11_reyno['denominador_6'] != 0) {
            $data11_reyno['cumplimiento'] = $data11_reyno['numerador_6'] / $data11_reyno['denominador_6'] * 100;
        }
        else {
            $data11_reyno['cumplimiento'] = 0;
        }
        $data11_reyno['numerador'] = $data11_reyno['numerador_6'] = number_format($data11_reyno['numerador_6'], 0, ',', '.');
        $data11_reyno['denominador'] = $data11_reyno['denominador_6'] = number_format($data11_reyno['denominador_6'], 0, ',', '.');
        break;
    case 12:
        if($data11_reyno['denominador_12'] AND $data11_reyno['denominador_12'] != 0) {
            $data11_reyno['cumplimiento'] = $data11_reyno['numerador_12'] / $data11_reyno['denominador_12'] * 100;
        }
        else {
            $data11_reyno['cumplimiento'] = 0;
        }
        $data11_reyno['numerador'] = $data11_reyno['numerador_12'] = number_format($data11_reyno['numerador_12'], 0, ',', '.');
        $data11_reyno['denominador'] = $data11_reyno['denominador_12'] = number_format($data11_reyno['denominador_12'], 0, ',', '.');
        break;
}

if( $data11_reyno['cumplimiento'] >= preg_replace("/[^0-9]/", '', $data11_reyno['meta'])) {
    $data11_reyno['aporte'] = preg_replace("/[^0-9]/", '', $data11_reyno['ponderacion']);
}
elseif( $data11_reyno['cumplimiento'] == NULL) {
    $data11_reyno['aporte'] = 0;
}
else {
    $data11_reyno['aporte'] = $data11_reyno['cumplimiento'] *  preg_replace("/[^0-9]/", '', $data11_reyno['ponderacion']) / $data11_reyno['meta'];
}

/********** META 1.2. **********/
/* ==== Inicializar en 0 el arreglo de datos $data ==== */
$data12_reyno = array();
$data12_reyno['label']['meta'] = '1.2. Evaluación anual de los pies en
    personas de 15 años y más con evaluación vigente del pie 
    según pauta de estimación del riesgo de ulceración en personas con diabetes.';
$data12_reyno['label']['numerador'] = 'N° de personas con DM2 bajo control de
    15 y más años con evaluación de pie vigente en el año t.';
$data12_reyno['label']['denominador'] = 'N° total de pacientes diabéticos de
    15 años y más bajo control en el nivel primario * 100.';

$data12_reyno['label']['fuente']['numerador'] = 'REM';
$data12_reyno['label']['fuente']['denominador'] = 'REM';

$data12_reyno['meta'] = '90';
$data12_reyno['ponderacion'] = '10%';

$data12_reyno['numerador_12a'] = '';
$data12_reyno['denominador_12a'] = '';

$data12_reyno['numerador'] = '';
$data12_reyno['numerador_6'] = '';
$data12_reyno['numerador_12'] = '';
$data12_reyno['denominador'] = '';
$data12_reyno['denominador_6'] = '';
$data12_reyno['denominador_12'] = '';

$data12_reyno['cumplimiento'] = '';

// AÑO ANTERIOR

$sql_numerador = "SELECT r.Mes AS mes, sum(ifnull(Col01,0)) as valor
                    FROM {$last_year}rems r
                    WHERE IdEstablecimiento = 102307 AND
                    Mes = 12
                    AND CodigoPrestacion IN ('P4190809','P4170300','P4190500','P4190600')
                    GROUP BY IdEstablecimiento, r.Mes
                    ORDER BY IdEstablecimiento, r.Mes";
$numeradores = DB::connection('mysql_rem')->select($sql_numerador);


foreach($numeradores as $numerador) {
    switch($numerador->mes) {
        case 12: $data12_reyno['numerador_12a'] = $numerador->valor; break;
    }
}

$sql_denominador = "SELECT r.Mes AS mes, sum(COALESCE(Col01,0)) as valor
                    FROM {$last_year}rems r
                    WHERE IdEstablecimiento = 102307 AND
                    Mes = 12
                    AND CodigoPrestacion IN ('P4150602')
                    GROUP BY IdEstablecimiento, r.Mes
                    ORDER BY IdEstablecimiento, r.Mes";
$denominadores = DB::connection('mysql_rem')->select($sql_denominador);

foreach($denominadores as $denominador) {
    switch($denominador->mes) {
        case 12: $data12_reyno['denominador_12a'] = $denominador->valor; break;
    }
}

// ----------------------------------------------------------------------------

// AÑO T

$sql_numerador = "SELECT r.Mes AS mes, sum(ifnull(Col01,0)) as valor
                    FROM {$year}rems r
                    WHERE IdEstablecimiento = 102307 AND (Mes = 6 OR Mes = 12)
                    AND CodigoPrestacion IN ('P4190809','P4170300','P4190500','P4190600')
                    GROUP BY IdEstablecimiento, r.Mes
                    ORDER BY IdEstablecimiento, r.Mes";
$numeradores = DB::connection('mysql_rem')->select($sql_numerador);


foreach($numeradores as $numerador) {
    switch($numerador->mes) {
        case 6:  $data12_reyno['numerador_6'] = $numerador->valor; break;
        case 12: $data12_reyno['numerador_12'] = $numerador->valor; break;
    }
}

$sql_denominador = "SELECT r.Mes AS mes, sum(COALESCE(Col01,0)) as valor
                    FROM {$year}rems r
                    WHERE IdEstablecimiento = 102307 AND (Mes = 6 OR Mes = 12)
                    AND CodigoPrestacion IN ('P4150602')
                    GROUP BY IdEstablecimiento, r.Mes
                    ORDER BY IdEstablecimiento, r.Mes";
$denominadores = DB::connection('mysql_rem')->select($sql_denominador);

foreach($denominadores as $denominador) {
    switch($denominador->mes) {
        case 6:  $data12_reyno['denominador_6'] = $denominador->valor; break;
        case 12: $data12_reyno['denominador_12'] = $denominador->valor; break;
    }
}

switch($ultimo_rem){
    case 1:
    case 2:
    case 3:
    case 4:
    case 5:
        $data12_reyno['numerador'] = '';
        $data12_reyno['denominador'] = '';
        $data12_reyno['cumplimiento'] = 0;
        break;
    case 6:
    case 7:
    case 8:
    case 9:
    case 10:
    case 11:
        if($data12_reyno['denominador_6'] AND $data12_reyno['denominador_6'] != 0) {
            $data12_reyno['cumplimiento'] = $data12_reyno['numerador_6'] / $data12_reyno['denominador_6'] * 100;
        }
        else {
            $data12_reyno['cumplimiento'] = 0;
        }
        $data12_reyno['numerador'] = $data12_reyno['numerador_6'] = number_format($data12_reyno['numerador_6'], 0, ',', '.');
        $data12_reyno['denominador'] = $data12_reyno['denominador_6'] = number_format($data12_reyno['denominador_6'], 0, ',', '.');
        break;
    case 12:
        if($data12_reyno['denominador_12'] AND $data12_reyno['denominador_12'] != 0) {
            $data12_reyno['cumplimiento'] = $data12_reyno['numerador_12'] / $data12_reyno['denominador_12'] * 100;
        }
        else {
            $data12_reyno['cumplimiento'] = 0;
        }
        $data12_reyno['numerador'] = $data12_reyno['numerador_12'] = number_format($data12_reyno['numerador_12'], 0, ',', '.');
        $data12_reyno['denominador'] = $data12_reyno['denominador_12'] = number_format($data12_reyno['denominador_12'], 0, ',', '.');
        break;
}

if( $data12_reyno['cumplimiento'] >= preg_replace("/[^0-9]/", '', $data12_reyno['meta'])) {
    $data12_reyno['aporte'] = preg_replace("/[^0-9]/", '', $data12_reyno['ponderacion']);
}
elseif( $data12_reyno['cumplimiento'] == NULL) {
    $data12_reyno['aporte'] = 0;
}
else {
    $data12_reyno['aporte'] = $data12_reyno['cumplimiento'] *  preg_replace("/[^0-9]/", '', $data12_reyno['ponderacion']) / $data12_reyno['meta'];
}

/********** META 1.3. **********/
$data13_reyno = array();
$data13_reyno['label']['meta'] = '1.3. Pacientes hipertenesos compensados bajo
    control en el grupo de 15 años y más.';
$data13_reyno['label']['numerador'] = '(N° de personas con HTAA de 15 y 79 años
    con presión arterial bajo 140/90 mmHg, según último control vigente
    en los últimos 12 meses) + (N° de personas con HTA de 80 años y más
    con presión arterial 150/90 mmHg), según último control vigente en
    los últimos 12 meses.';
$data13_reyno['label']['denominador'] = 'N° total de pacientes hipertensos de
    15 años y más bajo control en el nivel primario * 100.';

$data13_reyno['label']['fuente']['numerador'] = 'REM';
$data13_reyno['label']['fuente']['denominador'] = 'REM';

$data13_reyno['meta'] = '68';
$data13_reyno['ponderacion'] = '10%';

/* ==== Inicializar el arreglo de datos $data ==== */
$data13_reyno['numerador_12a'] = '';
$data13_reyno['denominador_12a'] = '';

$data13_reyno['numerador'] = '';
$data13_reyno['numerador_6'] = '';
$data13_reyno['numerador_12'] = '';
$data13_reyno['denominador'] = '';
$data13_reyno['denominador_6'] = '';
$data13_reyno['denominador_12'] = '';

$data13_reyno['cumplimiento'] = '';

// AÑO ANTERIOR

$sql_numerador = "SELECT r.Mes AS mes, sum(ifnull(Col01,0)) as valor
                    FROM {$last_year}rems r
                    WHERE IdEstablecimiento = 102307 AND
                    Mes = 12
                    AND CodigoPrestacion IN ('P4180200','P4200100')
                    GROUP BY IdEstablecimiento, r.Mes
                    ORDER BY IdEstablecimiento, r.Mes";
$numeradores = DB::connection('mysql_rem')->select($sql_numerador);

foreach($numeradores as $numerador) {
    switch($numerador->mes) {
        case 12: $data13_reyno['numerador_12a'] = $numerador->valor; break;
    }
}


$sql_denominador = "SELECT r.Mes AS mes, sum(COALESCE(Col01,0)) as valor
                    FROM {$last_year}rems r
                    WHERE IdEstablecimiento = 102307 AND (Mes = 6 OR Mes = 12)
                    AND CodigoPrestacion IN ('P4150601')
                    GROUP BY IdEstablecimiento, r.Mes
                    ORDER BY IdEstablecimiento, r.Mes";
$denominadores = DB::connection('mysql_rem')->select($sql_denominador);

foreach($denominadores as $denominador) {
    switch($denominador->mes) {
        case 12: $data13_reyno['denominador_12a'] = $denominador->valor; break;
    }
}

// -----------------------------------------------------------------------------

// AÑO T

$sql_numerador = "SELECT r.Mes AS mes, sum(ifnull(Col01,0)) as valor
                    FROM {$year}rems r
                    WHERE IdEstablecimiento = 102307 AND (Mes = 6 OR Mes = 12)
                    AND CodigoPrestacion IN ('P4180200','P4200100')
                    GROUP BY IdEstablecimiento, r.Mes
                    ORDER BY IdEstablecimiento, r.Mes";
$numeradores = DB::connection('mysql_rem')->select($sql_numerador);

foreach($numeradores as $numerador) {
    switch($numerador->mes) {
        case 6:  $data13_reyno['numerador_6'] = $numerador->valor; break;
        case 12: $data13_reyno['numerador_12'] = $numerador->valor; break;
    }
}

$sql_denominador = "SELECT r.Mes AS mes, sum(COALESCE(Col01,0)) as valor
                    FROM {$year}rems r
                    WHERE IdEstablecimiento = 102307 AND (Mes = 6 OR Mes = 12)
                    AND CodigoPrestacion IN ('P4150601')
                    GROUP BY IdEstablecimiento, r.Mes
                    ORDER BY IdEstablecimiento, r.Mes";
$denominadores = DB::connection('mysql_rem')->select($sql_denominador);

foreach($denominadores as $denominador) {
    switch($denominador->mes) {
        case 6:  $data13_reyno['denominador_6'] = $denominador->valor; break;
        case 12: $data13_reyno['denominador_12'] = $denominador->valor; break;
    }
}

switch($ultimo_rem){
    case 1:
    case 2:
    case 3:
    case 4:
    case 5:
        $data13_reyno['numerador'] = '';
        $data13_reyno['denominador'] = '';
        $data13_reyno['cumplimiento'] = 0;
        break;
    case 6:
    case 7:
    case 8:
    case 9:
    case 10:
    case 11:
        if($data13_reyno['denominador_6'] AND $data13_reyno['denominador_6'] != 0) {
            $data13_reyno['cumplimiento'] = $data13_reyno['numerador_6'] / $data13_reyno['denominador_6'] * 100;
        }
        else {
            $data13_reyno['cumplimiento'] = 0;
        }
        $data13_reyno['numerador'] = $data13_reyno['numerador_6'] = number_format($data13_reyno['numerador_6'], 0, ',', '.');
        $data13_reyno['denominador'] = $data13_reyno['denominador_6'] = number_format($data13_reyno['denominador_6'], 0, ',', '.');
        break;
    case 12:
        if($data13_reyno['denominador_12'] AND $data13_reyno['denominador_12'] != 0) {
            $data13_reyno['cumplimiento'] = $data13_reyno['numerador_12'] / $data13_reyno['denominador_12'] * 100;
        }
        else {
            $data13_reyno['cumplimiento'] = 0;
        }
        $data13_reyno['numerador'] = $data13_reyno['numerador_12'] = number_format($data13_reyno['numerador_12'], 0, ',', '.');
        $data13_reyno['denominador'] = $data13_reyno['denominador_12'] = number_format($data13_reyno['denominador_12'], 0, ',', '.');
        break;
}

if( $data13_reyno['cumplimiento'] >= preg_replace("/[^0-9]/", '', $data13_reyno['meta'])) {
    $data13_reyno['aporte'] = preg_replace("/[^0-9]/", '', $data13_reyno['ponderacion']);
}
elseif( $data13_reyno['cumplimiento'] == null) {
    $data13_reyno['aporte'] = 0;
}
else {
    $data13_reyno['aporte'] = $data13_reyno['cumplimiento'] *  preg_replace("/[^0-9]/", '', $data13_reyno['ponderacion']) / $data13_reyno['meta'];
}

/***********  META 1.8. ************/
/* ==== Inicializar variables ==== */

$data18_reyno['label']['meta'] = '1.8. Porcentaje de Gestión Efectiva para el
    Cumplimiento GES en la Red.';
$data18_reyno['label']['numerador'] = 'Garantías cumplidas + Garantías Exceptuadas +
    Garantías Incumplidas Atendidas.';
$data18_reyno['label']['denominador'] = '(Garantías Cumplidas + Garantías Exceptuadas +
    Garantías Incumplidas Atendidas + Garantías Incumplidas No Atendidas +
    Garantías Retrasadas) * 100.';

$data18_reyno['label']['fuente']['numerador'] = 'Datamart';
$data18_reyno['label']['fuente']['denominador'] = 'Datamart';

$data18_reyno['meta'] = '100';
$data18_reyno['ponderacion'] = '30%';

$base_where = array(['law','18834'],['year',$year],['indicator',18],['establishment_id',12]);

for($i = 1; $i <= 12; $i++) {
    $where = array_merge($base_where,array(['month',$i],['position','numerador']));
    $value = SingleParameter::where($where)->first();
    if($value) $data18_reyno['numeradores'][$i] = $value->value;
    else       $data18_reyno['numeradores'][$i] = null;

    $where = array_merge($base_where,array(['month',$i],['position','denominador']));
    $value = SingleParameter::where($where)->first();
    if($value) $data18_reyno['denominadores'][$i] = $value->value;
    else       $data18_reyno['denominadores'][$i] = null;
}

$data18_reyno['numerador_acumulado']   = array_sum($data18_reyno['numeradores']);
$data18_reyno['denominador_acumulado'] = array_sum($data18_reyno['denominadores']);

if($data18_reyno['denominador_acumulado'] != 0) {
    $data18_reyno['cumplimiento'] = $data18_reyno['numerador_acumulado'] / $data18_reyno['denominador_acumulado'] * 100;
}
else $data18_reyno['cumplimiento'] = 0;



if( $data18_reyno['cumplimiento'] >= preg_replace("/[^0-9]/", '', $data18_reyno['meta'])) {
    $data18_reyno['aporte'] = preg_replace("/[^0-9]/", '', $data18_reyno['ponderacion']);
}
else {
    $data18_reyno['aporte'] = $data18_reyno['cumplimiento'] *  preg_replace("/[^0-9]/", '', $data18_reyno['ponderacion']) / $data18_reyno['meta'];
}

/********** META 3.1 **********/
$data31_reyno['label']['meta'] = '3.1. Porcentajes de funcionarios regidos
    por el Estatuto Administrativo, capacitados durante el año, en al
    menos una actividad pertinente de los nueve ejes estratégicos de
    la Estrategia Nacional de Salud.';
$data31_reyno['label']['numerador']   = 'N° de funcionarios capacitados durante
    año t.';
$data31_reyno['label']['denominador'] = 'N° total de funcionarios de la dotación
    año t';


$data31_reyno['label']['fuente']['numerador'] = 'Reporte RRHH';
$data31_reyno['label']['fuente']['denominador'] = 'Reporte RRHH';

$data31_reyno['meta'] = '50';
$data31_reyno['ponderacion'] = '30%';

$base_where = array(['law','18834'],['year',$year],['indicator',31],['establishment_id',12],['position','numerador']);
$value = SingleParameter::where($base_where)->first();
if($value) {
  $data31_reyno['numerador_acumulado'] = $value->value;
  $data31_reyno['vigencia'] = $value->month;
}
else{
  $data31_reyno['numerador_acumulado'] = null;
  $data31_reyno['vigencia'] = 1;
}

$base_where = array(['law','18834'],['year',$year],['indicator',31],['establishment_id',12],['position','denominador']);
$value = SingleParameter::where($base_where)->first();
if($value) $data31_reyno['denominador_acumulado'] = $value->value;
else       $data31_reyno['denominador_acumulado'] = null;


if($data31_reyno['denominador_acumulado'] != 0) {
    $data31_reyno['cumplimiento'] = $data31_reyno['numerador_acumulado'] / $data31_reyno['denominador_acumulado'] * 100;
}
else $data31_reyno['cumplimiento'] = 0;


if( $data31_reyno['cumplimiento'] >= preg_replace("/[^0-9]/", '', $data31_reyno['meta'])) {
    $data31_reyno['aporte'] = preg_replace("/[^0-9]/", '', $data31_reyno['ponderacion']);
}
else {
    $data31_reyno['aporte'] = $data31_reyno['cumplimiento'] *  preg_replace("/[^0-9]/", '', $data31_reyno['ponderacion']) / $data31_reyno['meta'];
}
?>
