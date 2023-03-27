<?php
namespace App\Http\Controllers\Indicators\_2020;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\Indicators\SingleParameter;

$last_year = 2019;
$year = 2020;

$meses = array(1,2,3,4,5,6,7,8,9,10,11,12);

$sql_ultimo_rem = "SELECT MAX(Mes) as ultimo_rem FROM 2020rems;";
$ultimo_rem = DB::connection('mysql_rem')->select($sql_ultimo_rem)[0]->ultimo_rem;

/* INDICADOR 1. */
$data1_reyno['label']['meta'] = '1. Pacientes diabéticos compensados en
    el grupo de 15 años y más.';
$data1_reyno['label']['numerador'] = 'N° de personas con DM2 de 15 A 79 años
    con Hemoglobina Glicosilada bajo 7%, según último control en los
    últimos 12 meses + N° de personas con DM2 de 80 años y más con
    Hemoglobina Glicosilada bajo 8% según último control vigente, en los
    últimos 12 meses.';
$data1_reyno['label']['denominador'] = 'Total de pacientes diabéticos de 15
    años y más bajo control en el nivel primario * 100.';

$data1_reyno['label']['fuente']['numerador'] = 'REM';
$data1_reyno['label']['fuente']['denominador'] = 'REM';

$data1_reyno['meta'] = '45';
$data1_reyno['ponderacion'] = '25%';

/* ==== Inicializar el arreglo de datos $data ==== */
$data1_reyno['numerador_12a'] = '';
$data1_reyno['denominador_12a'] = '';

$data1_reyno['numerador'] = '';
$data1_reyno['numerador_6'] = '';
$data1_reyno['numerador_12'] = '';
$data1_reyno['denominador'] = '';
$data1_reyno['denominador_6'] = '';
$data1_reyno['denominador_12'] = '';

$data1_reyno['cumplimiento'] = '';

$data1_reyno['aporte'] = '';

// AÑO ANTERIOR

$sql_numerador = "SELECT r.Mes AS mes, SUM(COALESCE(Col01,0)) AS valor
                FROM {$last_year}rems r
                JOIN {$last_year}establecimientos e ON e.Codigo=r.IdEstablecimiento
                WHERE Mes = 12
                  AND e.Codigo = 102307
                  AND CodigoPrestacion IN ('P4180300','P4200200')
                GROUP BY r.Mes
                ORDER BY r.Mes";

$numeradores = DB::connection('mysql_rem')->select($sql_numerador);

foreach($numeradores as $numerador) {
    switch($numerador->mes) {
        case 12: $data1_reyno['numerador_12a'] = $numerador->valor; break;
    }
}

$sql_denominador = "SELECT r.Mes AS mes, SUM(COALESCE(Col01,0)) AS valor
                    FROM {$last_year}rems r
                    JOIN {$last_year}establecimientos e ON e.Codigo=r.IdEstablecimiento
                    WHERE Mes = 12
                      AND e.Codigo = 102307
                      AND CodigoPrestacion IN ('P4150602')
                    GROUP BY r.Mes
                    ORDER BY r.Mes";

$denominadores = DB::connection('mysql_rem')->select($sql_denominador);

foreach($denominadores as $denominador) {
    switch($denominador->mes) {
        case 12: $data1_reyno['denominador_12a'] = $denominador->valor; break;
    }
}

// ----------------------------------------------------------------------------

$sql_numerador = "SELECT r.Mes AS mes, SUM(COALESCE(Col01,0)) AS valor
                FROM {$year}rems r
                JOIN {$year}establecimientos e ON e.Codigo=r.IdEstablecimiento
                WHERE (Mes = 6 OR Mes = 12)
                  AND e.Codigo = 102307
                  AND CodigoPrestacion IN ('P4180300','P4200200')
                GROUP BY r.Mes
                ORDER BY r.Mes";

$numeradores = DB::connection('mysql_rem')->select($sql_numerador);

foreach($numeradores as $numerador) {
    switch($numerador->mes) {
        case 6:  $data1_reyno['numerador_6'] = $numerador->valor; break;
        case 12: $data1_reyno['numerador_12'] = $numerador->valor; break;
    }
}

$sql_denominador = "SELECT r.Mes AS mes, SUM(COALESCE(Col01,0)) AS valor
                    FROM {$year}rems r
                    JOIN {$year}establecimientos e ON e.Codigo=r.IdEstablecimiento
                    WHERE (Mes = 6 OR Mes = 12)
                      AND e.Codigo = 102307
                      AND CodigoPrestacion IN ('P4150602')
                    GROUP BY r.Mes
                    ORDER BY r.Mes";

$denominadores = DB::connection('mysql_rem')->select($sql_denominador);

foreach($denominadores as $denominador) {
    switch($denominador->mes) {
        case 6:  $data1_reyno['denominador_6'] = $denominador->valor; break;
        case 12: $data1_reyno['denominador_12'] = $denominador->valor; break;
    }
}

switch($ultimo_rem){
    case 1:
    case 2:
    case 3:
    case 4:
    case 5:
        $data1_reyno['numerador'] = '';
        $data1_reyno['denominador'] = '';
        $data1_reyno['cumplimiento'] = '';
        break;
    case 6:
    case 7:
    case 8:
    case 9:
    case 10:
    case 11:
        if($data1_reyno['numerador_6'] AND $data1_reyno['denominador_6'] != 0) {
            $data1_reyno['cumplimiento'] = $data1_reyno['numerador_6'] / $data1_reyno['denominador_6'] * 100;
        }
        else {
            $data1_reyno['cumplimiento'] = 0;
        }
        $data1_reyno['numerador'] = $data1_reyno['numerador_6'] = $data1_reyno['numerador_6'];
        $data1_reyno['denominador'] = $data1_reyno['denominador_6'] = $data1_reyno['denominador_6'];
        break;
    case 12:
        if($data1_reyno['numerador_12'] AND $data1_reyno['denominador_12'] != 0) {
            $data1_reyno['cumplimiento'] = $data1_reyno['numerador_12'] / $data1_reyno['denominador_12'] * 100;
        }
        else {
            $data1_reyno['cumplimiento'] = 0;
        }
        $data1_reyno['numerador'] = $data1_reyno['numerador_12'] = $data1_reyno['numerador_12'];
        $data1_reyno['denominador'] = $data1_reyno['denominador_12'] = $data1_reyno['denominador_12'];
        break;
}

if( $data1_reyno['cumplimiento'] >= preg_replace("/[^0-9]/", '', $data1_reyno['meta'])) {
    $data1_reyno['aporte'] = preg_replace("/[^0-9]/", '', $data1_reyno['ponderacion']);
}
else {
    $data1_reyno['aporte'] = $data1_reyno['cumplimiento'] *  preg_replace("/[^0-9]/", '', $data1_reyno['ponderacion']) / $data1_reyno['meta'];
}

/**** INDICADOR 2. ****/
$data2_reyno['label']['meta'] = '2. Evaluacion Anual de los Pies en
    personas con DM2 de 15 y más con diabetes bajo control.';
$data2_reyno['label']['numerador'] = 'N° de personas con DM2 bajo control de
    15 y más años con una evaluación de pié viegente en el año t.';
$data2_reyno['label']['denominador'] = 'N° total de pacientes diabéticos de
    15 años y más bajo controlen nivel primario. * 100.';

$data2_reyno['meta'] = '90';
$data2_reyno['ponderacion'] = '15%';

$data2_reyno['label']['fuente']['numerador'] = 'REM';
$data2_reyno['label']['fuente']['denominador'] = 'REM';

/* ==== Inicializar el arreglo de datos $data ==== */
$data2_reyno['numerador_12a'] = '';
$data2_reyno['denominador_12a'] = '';

$data2_reyno['numerador'] = '';
$data2_reyno['numerador_6'] = '';
$data2_reyno['numerador_12'] = '';
$data2_reyno['denominador'] = '';
$data2_reyno['denominador_6'] = '';
$data2_reyno['denominador_12'] = '';

$data2_reyno['cumplimiento'] = '';

$data2_reyno['aporte'] = '';

// AÑO ANTERIOR

$sql_numerador = "SELECT r.Mes AS mes, SUM(COALESCE(Col01,0)) AS valor
                FROM {$last_year}rems r
                JOIN {$last_year}establecimientos e ON e.Codigo=r.IdEstablecimiento
                WHERE Mes = 12
                    AND e.Codigo = 102307
                    AND CodigoPrestacion IN ('P4190809','P4170300','P4190500','P4190600')
                GROUP BY r.Mes
                ORDER BY r.Mes";

$numeradores = DB::connection('mysql_rem')->select($sql_numerador);

foreach($numeradores as $numerador) {
    switch($numerador->mes) {
        case 12: $data2_reyno['numerador_12a'] = $numerador->valor; break;
    }
}

$sql_denominador = "SELECT r.Mes AS mes, SUM(COALESCE(Col01,0)) AS valor
                    FROM {$last_year}rems r
                    JOIN {$last_year}establecimientos e ON e.Codigo=r.IdEstablecimiento
                    WHERE Mes = 12
                      AND e.Codigo = 102307
                      AND CodigoPrestacion IN ('P4150602')
                    GROUP BY r.Mes
                    ORDER BY r.Mes";
$denominadores = DB::connection('mysql_rem')->select($sql_denominador);

foreach($denominadores as $denominador) {
    switch($denominador->mes) {
        case 12: $data2_reyno['denominador_12a'] = $denominador->valor; break;
    }
}

// -----------------------------------------------------------------------------

$sql_numerador = "SELECT r.Mes AS mes, SUM(COALESCE(Col01,0)) AS valor
                FROM {$year}rems r
                JOIN {$year}establecimientos e ON e.Codigo=r.IdEstablecimiento
                WHERE (Mes = 6 OR Mes = 12)
                    AND e.Codigo = 102307
                    AND CodigoPrestacion IN ('P4190809','P4170300','P4190500','P4190600')
                GROUP BY r.Mes
                ORDER BY r.Mes";

$numeradores = DB::connection('mysql_rem')->select($sql_numerador);

foreach($numeradores as $numerador) {
    switch($numerador->mes) {
        case 6:  $data2_reyno['numerador_6'] = $numerador->valor; break;
        case 12: $data2_reyno['numerador_12'] = $numerador->valor; break;
    }
}

$sql_denominador = "SELECT r.Mes AS mes, SUM(COALESCE(Col01,0)) AS valor
                    FROM {$year}rems r
                    JOIN {$year}establecimientos e ON e.Codigo=r.IdEstablecimiento
                    WHERE (Mes = 6 OR Mes = 12)
                      AND e.Codigo = 102307
                      AND CodigoPrestacion IN ('P4150602')
                    GROUP BY r.Mes
                    ORDER BY r.Mes";
$denominadores = DB::connection('mysql_rem')->select($sql_denominador);

foreach($denominadores as $denominador) {
    switch($denominador->mes) {
        case 6:  $data2_reyno['denominador_6'] = $denominador->valor; break;
        case 12: $data2_reyno['denominador_12'] = $denominador->valor; break;
    }
}

switch($ultimo_rem){
    case 1:
    case 2:
    case 3:
    case 4:
    case 5:
        $data2_reyno['numerador'] = '';
        $data2_reyno['denominador'] = '';
        $data2_reyno['cumplimiento'] = '';
        break;
    case 6:
    case 7:
    case 8:
    case 9:
    case 10:
    case 11:
        if($data2_reyno['numerador_6'] AND $data2_reyno['denominador_6'] != 0) {
            $data2_reyno['cumplimiento'] = $data2_reyno['numerador_6'] / $data2_reyno['denominador_6'] * 100;
        }
        else {
            $data2_reyno['cumplimiento'] = 0;
        }
        $data2_reyno['numerador'] = $data2_reyno['numerador_6'] = $data2_reyno['numerador_6'];
        $data2_reyno['denominador'] = $data2_reyno['denominador_6'] = $data2_reyno['denominador_6'];
        break;
    case 12:
        if($data2_reyno['numerador_12'] AND $data2_reyno['denominador_12'] != 0) {
            $data2_reyno['cumplimiento'] = $data2_reyno['numerador_12'] / $data2_reyno['denominador_12'] * 100;
        }
        else {
            $data2_reyno['cumplimiento'] = 0;
        }
        $data2_reyno['numerador'] = $data2_reyno['numerador_12'] = $data2_reyno['numerador_12'];
        $data2_reyno['denominador'] = $data2_reyno['denominador_12'] = $data2_reyno['denominador_12'];
        break;
}

if( $data2_reyno['cumplimiento'] >= preg_replace("/[^0-9]/", '', $data2_reyno['meta'])) {
    $data2_reyno['aporte'] = preg_replace("/[^0-9]/", '', $data2_reyno['ponderacion']);
}
else{
    $data2_reyno['aporte'] = $data2_reyno['cumplimiento'] *  preg_replace("/[^0-9]/", '', $data2_reyno['ponderacion']) / $data2_reyno['meta'];
}

/**** INDICADOR 3. ****/
$data3_reyno['label']['meta'] = '3. Pacientes hipertensos compensados
    bajo control en el grupo de 15 años y más.';
$data3_reyno['label']['numerador'] = 'N° personas con HTA de 15 a 79 años
    con presión arterial bajo 140/90 mmHg, según último control vigente
    en los últimos 12 meses + N° de personas con HTC de 80 y más años
    con presión arterial bajo 150/90 mmHg, según último control vigente,
    en los últimos 12 meses.';
$data3_reyno['label']['denominador'] = 'N° total de pacientes hipertensos de
    15 años y más bajo control en el nivel primario * 100.';

$data3_reyno['label']['fuente']['numerador'] = 'REM';
$data3_reyno['label']['fuente']['denominador'] = 'REM';

$data3_reyno['meta'] = '68';
$data3_reyno['ponderacion'] = '10';

/* ==== Inicializar el arreglo de datos $data ==== */
$data3_reyno['numerador'] = '';
$data3_reyno['numerador_6'] = '';
$data3_reyno['numerador_12'] = '';
$data3_reyno['denominador'] = '';
$data3_reyno['denominador_6'] = '';
$data3_reyno['denominador_12'] = '';

$data3_reyno['cumplimiento'] = '';

$data3_reyno['aporte'] = '';

// AÑO ANTERIOR

$sql_numerador = "SELECT r.Mes AS mes, SUM(COALESCE(Col01,0)) AS valor
                FROM {$last_year}rems r
                JOIN {$last_year}establecimientos e ON e.Codigo=r.IdEstablecimiento
                WHERE Mes = 12
                  AND e.Codigo = 102307
                  AND CodigoPrestacion IN ('P4180200','P4200100')
                GROUP BY r.Mes
                ORDER BY r.Mes";
$numeradores = DB::connection('mysql_rem')->select($sql_numerador);

foreach($numeradores as $numerador) {
    switch($numerador->mes) {
        case 12: $data3_reyno['numerador_12a'] = $numerador->valor; break;
    }
}

$sql_denominador = "SELECT r.Mes AS mes, SUM(COALESCE(Col01,0)) AS valor
                    FROM {$last_year}rems r
                    JOIN {$last_year}establecimientos e ON e.Codigo=r.IdEstablecimiento
                    WHERE (Mes = 6 OR Mes = 12)
                      AND e.Codigo = 102307
                      AND CodigoPrestacion IN ('P4150601')
                    GROUP BY r.Mes
                    ORDER BY r.Mes";
$denominadores = DB::connection('mysql_rem')->select($sql_denominador);

foreach($denominadores as $denominador) {
    switch($denominador->mes) {
        case 12: $data3_reyno['denominador_12a'] = $denominador->valor; break;
    }
}

// ----------------------------------------------------------------------------

$sql_numerador = "SELECT r.Mes AS mes, SUM(COALESCE(Col01,0)) AS valor
                FROM {$year}rems r
                JOIN {$year}establecimientos e ON e.Codigo=r.IdEstablecimiento
                WHERE (Mes = 6 OR Mes = 12)
                  AND e.Codigo = 102307
                  AND CodigoPrestacion IN ('P4180200','P4200100')
                GROUP BY r.Mes
                ORDER BY r.Mes";
$numeradores = DB::connection('mysql_rem')->select($sql_numerador);

foreach($numeradores as $numerador) {
    switch($numerador->mes) {
        case 6:  $data3_reyno['numerador_6'] = $numerador->valor; break;
        case 12: $data3_reyno['numerador_12'] = $numerador->valor; break;
    }
}

$sql_denominador = "SELECT r.Mes AS mes, SUM(COALESCE(Col01,0)) AS valor
                    FROM {$year}rems r
                    JOIN {$year}establecimientos e ON e.Codigo=r.IdEstablecimiento
                    WHERE (Mes = 6 OR Mes = 12)
                      AND e.Codigo = 102307
                      AND CodigoPrestacion IN ('P4150601')
                    GROUP BY r.Mes
                    ORDER BY r.Mes";
$denominadores = DB::connection('mysql_rem')->select($sql_denominador);

foreach($denominadores as $denominador) {
    switch($denominador->mes) {
        case 6:  $data3_reyno['denominador_6'] = $denominador->valor; break;
        case 12: $data3_reyno['denominador_12'] = $denominador->valor; break;
    }
}

switch($ultimo_rem){
    case 1:
    case 2:
    case 3:
    case 4:
    case 5:
        $data3_reyno['numerador'] = '';
        $data3_reyno['denominador'] = '';
        $data3_reyno['cumplimiento'] = '';
        break;
    case 6:
    case 7:
    case 8:
    case 9:
    case 10:
    case 11:
        if($data3_reyno['numerador_6'] AND $data3_reyno['denominador_6'] != 0) {
            $data3_reyno['cumplimiento'] = $data3_reyno['numerador_6'] / $data3_reyno['denominador_6'] * 100;
        }
        else {
            $data3_reyno['cumplimiento'] = 0;
        }
        $data3_reyno['numerador'] = $data3_reyno['numerador_6'] = $data3_reyno['numerador_6'];
        $data3_reyno['denominador'] = $data3_reyno['denominador_6'] = $data3_reyno['denominador_6'];
        break;
    case 12:
        if($data3_reyno['denominador_12'] AND $data3_reyno['denominador_12'] != 0) {
            $data3_reyno['cumplimiento'] = $data3_reyno['numerador_12'] / $data3_reyno['denominador_12'] * 100;
        }
        else {
            $data3_reyno['cumplimiento'] = 0;
        }
        $data3_reyno['numerador'] = $data3_reyno['numerador_12'] = $data3_reyno['numerador_12'];
        $data3_reyno['denominador'] = $data3_reyno['denominador_12'] = $data3_reyno['denominador_12'];
        break;
}

if( $data3_reyno['cumplimiento'] >= $data3_reyno['meta']) {
    $data3_reyno['aporte'] = $data3_reyno['ponderacion'];
}
else{
    $data3_reyno['aporte'] = $data3_reyno['cumplimiento'] *  preg_replace("/[^0-9]/", '', $data3_reyno['ponderacion']) / $data3_reyno['meta'];
}

/* INDICADOR 12 */
$data12_reyno['label']['meta'] = '12. Porcentaje de Gestión Efectiva para el
    Cumplimiento GES en la Red.';
$data12_reyno['label']['numerador'] = 'Garantías cumplidas + Garantías Exceptuadas +
    Garantías Incumplidas Atendidas.';
$data12_reyno['label']['denominador'] = '(Garantías Cumplidas + Garantías Exceptuadas +
    Garantías Incumplidas Atendidas + Garantías Incumplidas No Atendidas +
    Garantías Retrasadas) * 100.';

$data12_reyno['label']['fuente']['numerador'] = 'Datamart';
$data12_reyno['label']['fuente']['denominador'] = 'Datamart';

$data12_reyno['meta'] = '100';
$data12_reyno['ponderacion'] = '50%';

$base_where = array(['law','19664'],['year',$year],['indicator',12],['establishment_id',12]);

for($i = 1; $i <= $ultimo_rem; $i++) {
    $where = array_merge($base_where,array(['month',$i],['position','numerador']));
    $value = SingleParameter::where($where)->first();
    if($value) $data12_reyno['numeradores'][$i] = $value->value;
    else       $data12_reyno['numeradores'][$i] = null;

    $where = array_merge($base_where,array(['month',$i],['position','denominador']));
    $value = SingleParameter::where($where)->first();
    if($value) $data12_reyno['denominadores'][$i] = $value->value;
    else       $data12_reyno['denominadores'][$i] = null;
}

$data12_reyno['numerador_acumulado']   = array_sum($data12_reyno['numeradores']);
$data12_reyno['denominador_acumulado'] = array_sum($data12_reyno['denominadores']);

if($data12_reyno['denominador_acumulado'] != 0) {
    $data12_reyno['cumplimiento'] = $data12_reyno['numerador_acumulado'] / $data12_reyno['denominador_acumulado'] * 100;
}
else $data12_reyno['cumplimiento'] = 0;

if( $data12_reyno['cumplimiento'] >= preg_replace("/[^0-9]/", '', $data12_reyno['meta'])) {
    $data12_reyno['aporte'] = preg_replace("/[^0-9]/", '', $data12_reyno['ponderacion']);
}
else {
    $data12_reyno['aporte'] = $data12_reyno['cumplimiento'] *  preg_replace("/[^0-9]/", '', $data12_reyno['ponderacion']) / $data12_reyno['meta'];
}

?>
