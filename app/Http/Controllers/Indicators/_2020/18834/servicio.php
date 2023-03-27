<?php
namespace App\Http\Controllers\Indicators\_2020;

use App\Models\Indicators\Rem;
use Illuminate\Support\Facades\DB;
use App\Models\Indicators\SingleParameter;

$last_year= 2019;
$year= 2020;
$meses = array(1,2,3,4,5,6,7,8,9,10,11,12);

$sql_ultimo_rem = "SELECT MAX(Mes) as ultimo_rem FROM 2020rems;";
$ultimo_rem = DB::connection('mysql_rem')->select($sql_ultimo_rem)[0]->ultimo_rem;

/***********  META 1.3. ************/
/* ==== Inicializar variables ==== */

$data13 = array();

$data13['label']['meta'] = '1.3. Pacientes hipertensos compensados
    bajo control en el grupo de 15 y más';
$data13['label']['numerador'] = '(N° de personas hipertensas de 15 a 79 años con
    presión arterial <140/90 mmHg) + (N° de personas hipertensas de 80 y más
    años con presión arterial <150/90 mmHg), según último control vigente, en los
    últimos 12 meses.';
$data13['label']['denominador'] = 'Total de pacientes Hipertensos de 15 y más
    años bajo control en el nivel primario * 100';

$data13['label']['fuente']['numerador'] = 'REM';
$data13['label']['fuente']['denominador'] = 'REM';


$data13['meta'] = '68';
$data13['ponderacion'] = '20%';


/* ==== Inicializar el arreglo de datos $data ==== */
$data13['numerador_12a'] = '';
$data13['denominador_12a'] = '';

$data13['numerador'] = '';
$data13['numerador_6'] = '';
$data13['numerador_12'] = '';
$data13['denominador'] = '';
$data13['denominador_6'] = '';
$data13['denominador_12'] = '';

$data13['cumplimiento'] = '';

/* AÑO ANTERIOR */
$sql_numerador = "SELECT r.Mes AS mes, SUM(COALESCE(Col01,0)) AS valor
                FROM {$last_year}rems r
                JOIN {$last_year}establecimientos e ON e.Codigo=r.IdEstablecimiento
                WHERE Mes = 12 AND
                  CodigoPrestacion IN ('P4180200','P4200100')
                GROUP BY r.Mes
                ORDER BY r.Mes";
$numeradores = DB::connection('mysql_rem')->select($sql_numerador);

// $numeradores = Rem::year(2019)->with('establecimiento')->whereIn('Mes', [12])->whereIn('CodigoPrestacion', ['P4180200','P4200100'])->sum('Col01');
// dd($numeradores);

foreach($numeradores as $numerador) {
    switch($numerador->mes) {
        case 12: $data13['numerador_12a'] = $numerador->valor; break;
    }
}

$sql_denominador = "SELECT r.Mes AS mes, SUM(COALESCE(Col01,0)) AS valor
                    FROM {$last_year}rems r
                    JOIN {$last_year}establecimientos e ON e.Codigo=r.IdEstablecimiento
                    WHERE Mes = 12 AND
                      CodigoPrestacion IN ('P4150601')
                    GROUP BY r.Mes
                    ORDER BY r.Mes";
$denominadores = DB::connection('mysql_rem')->select($sql_denominador);

// $denominadores = Rem::year(2019)->with('establecimiento')->whereIn('Mes', [12])->whereIn('CodigoPrestacion', ['P4150601'])->sum('Col01');
// dd($denominadores);

foreach($denominadores as $denominador) {
    switch($denominador->mes) {
        case 12: $data13['denominador_12a'] = $denominador->valor; break;
    }
}
/* -------------------------------------------------------------------------- */

/* AÑO T */
$sql_numerador = "SELECT r.Mes AS mes, SUM(COALESCE(Col01,0)) AS valor
                FROM {$year}rems r
                JOIN {$year}establecimientos e ON e.Codigo=r.IdEstablecimiento
                WHERE (Mes = 6 OR Mes = 12)
                	AND CodigoPrestacion IN ('P4180200','P4200100')
                GROUP BY r.Mes
                ORDER BY r.Mes";
$numeradores = DB::connection('mysql_rem')->select($sql_numerador);

// $numeradores = Rem::year(2020)->with('establecimiento')->selectRaw('SUM(COALESCE(Col01,0)) AS valor, Mes')->whereIn('Mes', [6,12])->whereIn('CodigoPrestacion', ['P4180200','P4200100'])->groupBy('Mes')->orderBy('Mes')->get();
// dd($numeradores);

foreach($numeradores as $numerador) {
    switch($numerador->mes) {
        case 6:  $data13['numerador_6'] = $numerador->valor; break;
        case 12: $data13['numerador_12'] = $numerador->valor; break;
    }
}

/* PAULA: Pidio eliminar meta_san_18834 = 1 */
$sql_denominador = "SELECT r.Mes AS mes, SUM(COALESCE(Col01,0)) AS valor
                    FROM {$year}rems r
                    JOIN {$year}establecimientos e ON e.Codigo=r.IdEstablecimiento
                    WHERE (Mes = 6 OR Mes = 12)
                    	AND CodigoPrestacion IN ('P4150601')
                    GROUP BY r.Mes
                    ORDER BY r.Mes";
$denominadores = DB::connection('mysql_rem')->select($sql_denominador);

foreach($denominadores as $denominador) {
    switch($denominador->mes) {
        case 6:  $data13['denominador_6'] = $denominador->valor; break;
        case 12: $data13['denominador_12'] = $denominador->valor; break;
    }
}

switch($ultimo_rem){
    case 1:
    case 2:
    case 3:
    case 4:
    case 5:
        $data13['numerador'] = 0;
        $data13['denominador'] = 0;
        $data13['cumplimiento'] = 0;
        break;
    case 6:
    case 7:
    case 8:
    case 9:
    case 10:
    case 11:
        if($data13['denominador_6'] AND $data13['denominador_6'] != 0) {
            $data13['cumplimiento'] = $data13['numerador_6'] / $data13['denominador_6'] * 100;
        }
        else {
            $data13['cumplimiento'] = 0;
        }
        $data13['numerador'] = $data13['numerador_6'] = $data13['numerador_6'];
        $data13['denominador'] = $data13['denominador_6'] = $data13['denominador_6'];
        break;
    case 12:
        if($data13['denominador_12'] AND $data13['denominador_12'] != 0) {
            $data13['cumplimiento'] = $data13['numerador_12'] / $data13['denominador_12'] * 100;
        }
        else {
            $data13['cumplimiento'] = 0;
        }
        $data13['numerador'] = $data13['numerador_12'] = $data13['numerador_12'];
        $data13['denominador'] = $data13['denominador_12'] = $data13['denominador_12'];
        break;
}


if( $data13['cumplimiento'] >= preg_replace("/[^0-9]/", '', $data13['meta'])) {
    $data13['aporte'] = preg_replace("/[^0-9]/", '', $data13['ponderacion']);
}
elseif( $data13['cumplimiento'] == NULL) {
    $data13['aporte'] = 0;
}
else {
    // $data13['aporte'] = $data13['cumplimiento'] *  preg_replace("/[^0-9]/", '', $data13['ponderacion']) / 100;
    $data13['aporte'] = $data13['cumplimiento'] *  preg_replace("/[^0-9]/", '', $data13['ponderacion']) / $data13['meta'];
}

/***********  META 1.5. ************/
/* ==== Inicializar variables ==== */
$data15 = array();

$data15['label']['meta'] = '1.5. Porcentaje de cumplimiento de programación de
    consultas de profesionales no médicos de establecimientos
    hospitalarios de alta y mediana complejidad.';
$data15['label']['numerador'] = 'Número de consultas de profesionales
    no médicos realizadas en año t.';
$data15['label']['denominador'] = 'Total de consultas de profesionales
    no médicos programadas y validadas en año t * 100.';

$data15['label']['fuente']['numerador'] = 'REM';
$data15['label']['fuente']['denominador'] = 'Programacion Anual';

$data15['meta'] = '95';
$data15['ponderacion'] = '25%';
$data15['cumplimiento'] = 0;
$data15['numerador_acumulado'] = 0;
$data15['denominador'] = 0;
foreach($meses as $mes) {
    $data15['numeradores'][$mes] = 0;
}

/* ===== Query numerador ===== */
$sql_numerador = "SELECT e.alias_estab, r.Mes, sum(ifnull(Col01,0)) AS numerador
    FROM {$year}rems r
    LEFT JOIN {$year}establecimientos e
    ON r.IdEstablecimiento=e.Codigo
    WHERE e.meta_san_18834_hosp = 1
    AND CodigoPrestacion IN (07024900, 07024915, 07024925, 07024935, 07024920, 07024816, 07024607, 07024705, 07024506)
    GROUP by e.Comuna, e.alias_estab, r.Mes
    ORDER BY e.Comuna, e.alias_estab, r.Mes";
$numeradores = DB::connection('mysql_rem')->select($sql_numerador);

/* Asigna los valores al mes y calcula el acumulado */
foreach($numeradores as $registro) {
    $data15['numeradores'][$registro->Mes] = $registro->numerador;
    $data15['numerador_acumulado'] += $registro->numerador;
}


$base_where = array(['law','18834'],['year',$year],['indicator',15],['establishment_id',9],['position','denominador']);
$value = SingleParameter::where($base_where)->first();
if($value) $data15['denominador'] = $value->value;
else       $data15['denominador'] = null;

/* Calculo del cumplimiento */
if($data15['denominador'] == 0) {
    /* Si es 0 el denominador entonces el cumplimiento es 0 */
    $data15['cumplimiento'] = 0;
}
else {
    /* De lo contrario calcular el porcentaje */
    $data15['cumplimiento'] =
        $data15['numerador_acumulado'] /
        $data15['denominador'] * 100;
}


if( $data15['cumplimiento'] >= preg_replace("/[^0-9]/", '', $data15['meta'])) {
    $data15['aporte'] = preg_replace("/[^0-9]/", '', $data15['ponderacion']);
}
else {
    $data15['aporte'] = $data15['cumplimiento'] *  preg_replace("/[^0-9]/", '', $data15['ponderacion']) / 100;
}

/***********  META 1.8. ************/
/* ==== Inicializar variables ==== */

$data18['label']['meta'] = '1.8. Porcentaje de Gestión Efectiva para el
    Cumplimiento GES en la Red.';
$data18['label']['numerador'] = 'Garantías cumplidas + Garantías Exceptuadas +
    Garantías Incumplidas Atendidas.';
$data18['label']['denominador'] = '(Garantías Cumplidas + Garantías Exceptuadas +
    Garantías Incumplidas Atendidas + Garantías Incumplidas No Atendidas +
    Garantías Retrasadas) * 100.';

$data18['label']['fuente']['numerador'] = 'Datamart';
$data18['label']['fuente']['denominador'] = 'Datamart';

$data18['meta'] = '99.5';
$data18['ponderacion'] = '15%';

$base_where = array(['law','18834'],['year',$year],['indicator',18],['establishment_id',9]);

for($i = 1; $i <= 12; $i++) {
    $where = array_merge($base_where,array(['month',$i],['position','numerador']));
    $value = SingleParameter::where($where)->first();
    if($value) $data18['numeradores'][$i] = $value->value;
    else       $data18['numeradores'][$i] = null;

    $where = array_merge($base_where,array(['month',$i],['position','denominador']));
    $value = SingleParameter::where($where)->first();
    if($value) $data18['denominadores'][$i] = $value->value;
    else       $data18['denominadores'][$i] = null;
}

$data18['numerador_acumulado']   = array_sum($data18['numeradores']);
$data18['denominador_acumulado'] = array_sum($data18['denominadores']);

if($data18['denominador_acumulado'] != 0) {
    $data18['cumplimiento'] = $data18['numerador_acumulado'] / $data18['denominador_acumulado'] * 100;
}
else $data18['cumplimiento'] = 0;

if( $data18['cumplimiento'] >= $data18['meta']) {
    $data18['aporte'] = preg_replace("/[^0-9]/", '', $data18['ponderacion']);
}
else {
    // $data18['aporte'] = 0;
    $data18['aporte'] = $data18['cumplimiento'] *  preg_replace("/[^0-9]/", '', $data18['ponderacion']) / $data18['meta'];
}

/********** META 1.2. **********/
/* ==== Inicializar en 0 el arreglo de datos $data ==== */
$data12 = array();
$data12['label']['meta'] = '1.2. Evaluación anual de los pies en
    personas de 15 años y más con evaluación vigente del pie 
    según pauta de estimación del riesgo de ulceración en personas con diabetes.';
$data12['label']['numerador'] = 'N° de personas con DM2 bajo control de
    15 y más años con evaluación de pie vigente en el año t.';
$data12['label']['denominador'] = 'N° total de pacientes diabéticos de
    15 años y más bajo control en el nivel primario * 100.';

$data12['label']['fuente']['numerador'] = 'REM';
$data12['label']['fuente']['denominador'] = 'REM';

$data12['meta'] = '90';
$data12['ponderacion'] = '10%';

$data12['numerador_12a'] = '';
$data12['denominador_12a'] = '';

$data12['numerador'] = '';
$data12['numerador_6'] = '';
$data12['numerador_12'] = '';
$data12['denominador'] = '';
$data12['denominador_6'] = '';
$data12['denominador_12'] = '';

$data12['cumplimiento'] = '';

/* AÑO ANTERIOR */

$sql_numerador = "SELECT r.Mes AS mes, sum(ifnull(Col01,0)) as valor
                    FROM {$last_year}rems r
                    JOIN {$last_year}establecimientos e ON e.Codigo=r.IdEstablecimiento
                    WHERE (Mes = 6 OR Mes = 12)
                    AND CodigoPrestacion IN ('P4190809','P4170300','P4190500','P4190600')
                    GROUP BY r.Mes
                    ORDER BY r.Mes";
$numeradores = DB::connection('mysql_rem')->select($sql_numerador);


foreach($numeradores as $numerador) {
    switch($numerador->mes) {
        case 12: $data12['numerador_12a'] = $numerador->valor; break;
    }
}

$sql_denominador = "SELECT r.Mes AS mes, sum(COALESCE(Col01,0)) as valor
                    FROM {$last_year}rems r
                    JOIN {$last_year}establecimientos e ON e.Codigo=r.IdEstablecimiento
                    WHERE Mes = 12
                    AND CodigoPrestacion IN ('P4150602')
                    GROUP BY r.Mes
                    ORDER BY r.Mes";
$denominadores = DB::connection('mysql_rem')->select($sql_denominador);

foreach($denominadores as $denominador) {
    switch($denominador->mes) {
        case 12: $data12['denominador_12a'] = $denominador->valor; break;
    }
}

/* -------------------------------------------------------------------------- */
/* AÑO T */

$sql_numerador = "SELECT r.Mes, sum(ifnull(Col01,0)) as valor
                    FROM {$year}rems r
                    WHERE r.Mes in (6, 12)
                    AND CodigoPrestacion IN ('P4190809','P4170300','P4190500','P4190600') AND IdEstablecimiento NOT IN (102100)
                    GROUP BY r.Mes
                    ORDER BY r.Mes";
$numeradores = DB::connection('mysql_rem')->select($sql_numerador);


foreach($numeradores as $numerador) {
    switch($numerador->Mes) {
        case 6:  $data12['numerador_6'] = $numerador->valor; break;
        case 12: $data12['numerador_12'] = $numerador->valor; break;
    }
}

$sql_denominador = "SELECT r.Mes AS mes, sum(COALESCE(Col01,0)) as valor
                    FROM {$year}rems r
                    WHERE (Mes = 6 OR Mes = 12)
                    AND CodigoPrestacion IN ('P4150602')
                    GROUP BY r.Mes
                    ORDER BY r.Mes";
$denominadores = DB::connection('mysql_rem')->select($sql_denominador);

foreach($denominadores as $denominador) {
    switch($denominador->mes) {
        case 6:  $data12['denominador_6'] = $denominador->valor; break;
        case 12: $data12['denominador_12'] = $denominador->valor; break;
    }
}

switch($ultimo_rem){
    case 1:
    case 2:
    case 3:
    case 4:
    case 5:
        $data12['numerador'] = 0;
        $data12['denominador'] = 0;
        $data12['cumplimiento'] = 0;
        break;
    case 6:
    case 7:
    case 8:
    case 9:
    case 10:
    case 11:
        if($data12['denominador_6'] AND $data12['denominador_6'] != 0) {
            $data12['cumplimiento'] = $data12['numerador_6'] / $data12['denominador_6'] * 100;
        }
        else {
            $data12['cumplimiento'] = 0;
        }
        $data12['numerador'] = $data12['numerador_6'] = $data12['numerador_6'];
        $data12['denominador'] = $data12['denominador_6'] = $data12['denominador_6'];
        break;
    case 12:
        if($data12['denominador_12'] AND $data12['denominador_12'] != 0) {
            $data12['cumplimiento'] = $data12['numerador_12'] / $data12['denominador_12'] * 100;
        }
        else {
            $data12['cumplimiento'] = 0;
        }
        $data12['numerador'] = $data12['numerador_12'] = $data12['numerador_12'];
        $data12['denominador'] = $data12['denominador_12'] = $data12['denominador_12'];
        break;
}

if( $data12['cumplimiento'] >= $data12['meta']) {
    $data12['aporte'] = preg_replace("/[^0-9]/", '', $data12['ponderacion']);
}
elseif( $data12['cumplimiento'] == NULL) {
    $data12['aporte'] = 0;
}
else {
    $data12['aporte'] = $data12['cumplimiento'] *  preg_replace("/[^0-9]/", '', $data12['ponderacion']) / $data12['meta'];
}

/********** META 3.1 **********/
$data31['label']['meta'] = '3.1. Porcentajes de funcionarios regidos
    por el Estatuto Administrativo, capacitados durante el año en al
    menos una actividad pertinente, de los nueve ejes estratégicos de
    la Estrategia Nacional de Salud.';
$data31['label']['numerador']   = 'N° de funcionarios regidos por el EA
    capacitados durante el año t.';
$data31['label']['denominador'] = 'N° total de funcionarios de dotación,
    regidos por el EA. * 100.';

$data31['label']['fuente']['numerador'] = 'Reporte RRHH';
$data31['label']['fuente']['denominador'] = 'Reporte RRHH';

$data31['meta'] = '50';
$data31['ponderacion'] = '30%';

$base_where = array(['law','18834'],['year',$year],['indicator',31],['establishment_id',9],['position','numerador']);
$value = SingleParameter::where($base_where)->first();

if($value){
  $data31['numerador_acumulado'] = $value->value;
  $data31['vigencia'] = $value->month;
}
else{
  $data31['numerador_acumulado'] = null;
  $data31['vigencia'] = 1;
}

$base_where = array(['law','18834'],['year',$year],['indicator',31],['establishment_id',9],['position','denominador']);
$value = SingleParameter::where($base_where)->first();
if($value) $data31['denominador_acumulado'] = $value->value;
else       $data31['denominador_acumulado'] = null;


if($data31['denominador_acumulado'] != 0) {
    $data31['cumplimiento'] = $data31['numerador_acumulado'] / $data31['denominador_acumulado'] * 100;
}
else $data31['cumplimiento'] = 0;


if( $data31['cumplimiento'] >= $data31['meta']) {
    $data31['aporte'] = preg_replace("/[^0-9]/", '', $data31['ponderacion']);
}
else {
    $data31['aporte'] = $data31['cumplimiento'] *  preg_replace("/[^0-9]/", '', $data31['ponderacion']) / $data31['meta'];
}

?>
