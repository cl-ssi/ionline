<?php
namespace App\Http\Controllers\Indicators\_2019;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\Indicators\SingleParameter;


$year= 2019;
$meses = array(1,2,3,4,5,6,7,8,9,10,11,12);

$sql_ultimo_rem = "SELECT MAX(Mes) as ultimo_rem FROM 2019rems;";
$ultimo_rem = DB::connection('mysql_rem')->select($sql_ultimo_rem)[0]->ultimo_rem;

/***********  META 1.3. ************/
/* ==== Inicializar variables ==== */

$data13 = array();

$data13['label']['meta'] = '1.3. Porcentaje de pacientes hipertensos compensados
    bajo control en el grupo de 15 y más años en el nivel primario.';
$data13['label']['numerador'] = 'N° de personas hipertensas de 15 a 79 años con
    presión arterial <140/90 mmHg, más el N° de personas hipertensas de 80 y más
    años con presión arterial <150/90 mmHg, según último control vigente, en los
    últimos 12 meses.';
$data13['label']['denominador'] = 'Total de pacientes Hipertensos de 15 y más
    años bajo control en el nivel primario.';

$data13['label']['fuente']['numerador'] = 'REM';
$data13['label']['fuente']['denominador'] = 'REM';


$data13['meta'] = '≥68%';
$data13['ponderacion'] = '20%';


/* ==== Inicializar el arreglo de datos $data ==== */
$data13['numerador'] = '';
$data13['numerador_6'] = '';
$data13['numerador_12'] = '';
$data13['denominador'] = '';
$data13['denominador_6'] = '';
$data13['denominador_12'] = '';

$data13['cumplimiento'] = '';


/* PAULA: Pidio eliminar meta_san_18834 = 1 */
$sql_numerador = "SELECT r.Mes AS mes, SUM(COALESCE(Col01,0)) AS valor
                FROM {$year}rems r
                JOIN {$year}establecimientos e ON e.Codigo=r.IdEstablecimiento
                WHERE (Mes = 6 OR Mes = 12)
                	AND CodigoPrestacion IN ('P4180200','P4200100')
                GROUP BY r.Mes
                ORDER BY r.Mes";
$numeradores = DB::connection('mysql_rem')->select($sql_numerador);

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
        $data13['numerador'] = '';
        $data13['denominador'] = '';
        $data13['cumplimiento'] = '';
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
else {
    $data13['aporte'] = $data13['cumplimiento'] *  preg_replace("/[^0-9]/", '', $data13['ponderacion']) / 100;
}

/***********  META 1.4. ************/
/* ==== Inicializar variables ==== */
$data14 = array();

$data14['label']['meta'] = '1.4. Porcentaje de cumplimiento de programación de
    consultas de profesionales no médicos de establecimientos
    hospitalarios de alta complejidad.';
$data14['label']['numerador'] = 'Total, de número de consultas de profesionales
    no médicos realizadas.';
$data14['label']['denominador'] = 'Total, de número de consultas de profesionales
    no médicos programadas.';

$data14['label']['fuente']['numerador'] = 'REM';
$data14['label']['fuente']['denominador'] = 'Programacion Anual';

$data14['meta'] = '≥95%';
$data14['ponderacion'] = '25%';
$data14['cumplimiento'] = 0;
$data14['numerador_acumulado'] = 0;
$data14['denominador'] = 0;
foreach($meses as $mes) {
    $data14['numeradores'][$mes] = 0;
}

/* ===== Query numerador ===== */
$sql_numerador = "SELECT e.alias_estab, r.Mes, sum(ifnull(Col01,0)) AS numerador
    FROM {$year}rems r
    LEFT JOIN establecimientos e
    ON r.IdEstablecimiento=e.Codigo
    WHERE e.meta_san_18834_hosp = 1
    AND CodigoPrestacion IN (07024900, 07024915, 07024925, 07024935, 07024920, 07024816, 07024607, 07024817, 07024809, 07024705, 07024506,
                              07024930, 07024940, 070251200, 070251300, 070251400, '07030100A', 07030200, 07030300, 07030400, 07024950, 07024960,
                              28021230, 28021240, 28021250, 28021260, 28021270,
                              28021280, 28021290, 28021300, 28021310,
                              28021320, 28021330, 28021340, 28021350)
    GROUP by e.Comuna, e.alias_estab, r.Mes
    ORDER BY e.Comuna, e.alias_estab, r.Mes";
$numeradores = DB::connection('mysql_rem')->select($sql_numerador);

/* Asigna los valores al mes y calcula el acumulado */
foreach($numeradores as $registro) {
    $data14['numeradores'][$registro->Mes] = $registro->numerador;
    $data14['numerador_acumulado'] += $registro->numerador;
}


$base_where = array(['law','18834'],['year',$year],['indicator',14],['establishment_id',9],['position','denominador']);
$value = SingleParameter::where($base_where)->first();
if($value) $data14['denominador'] = $value->value;
else       $data14['denominador'] = null;

/* Calculo del cumplimiento */
if($data14['denominador'] == 0) {
    /* Si es 0 el denominador entonces el cumplimiento es 0 */
    $data14['cumplimiento'] = 0;
}
else {
    /* De lo contrario calcular el porcentaje */
    $data14['cumplimiento'] =
        $data14['numerador_acumulado'] /
        $data14['denominador'] * 100;
}


if( $data14['cumplimiento'] >= preg_replace("/[^0-9]/", '', $data14['meta'])) {
    $data14['aporte'] = preg_replace("/[^0-9]/", '', $data14['ponderacion']);
}
else {
    $data14['aporte'] = $data14['cumplimiento'] *  preg_replace("/[^0-9]/", '', $data14['ponderacion']) / 100;
}

// array:6 [▼
//   "meta" => "≥95%"
//   "ponderacion" => "10%"
//   "cumplimiento" => 18.478027867095
//   "numerador_acumulado" => 5172
//   "denominador" => 27990
//   "numeradores" => array:12 [▼
//     1 => "2716"
//     2 => "2456"
//     3 => 0
//     4 => 0
//     5 => 0
//     6 => 0
//     7 => 0
//     8 => 0
//     9 => 0
//     10 => 0
//     11 => 0
//     12 => 0
//   ]
// ]






/***********  META 1.7. ************/
/* ==== Inicializar variables ==== */

$data17['label']['meta'] = '1.7. Porcentaje de Gestión Efectiva para el
    Cumplimiento GES en la Red.';
$data17['label']['numerador'] = 'Garantías cumplidas + Garantías Exceptuadas +
    Garantías Incumplidas Atendidas.';
$data17['label']['denominador'] = '(Garantías Cumplidas + Garantías Exceptuadas +
    Garantías Incumplidas Atendidas + Garantías No Atendidas +
    Garantías Retrasadas) * 100.';

$data17['label']['fuente']['numerador'] = 'Datamart';
$data17['label']['fuente']['denominador'] = 'Datamart';

$data17['meta'] = '100%';
$data17['ponderacion'] = '15%';

$base_where = array(['law','18834'],['year',$year],['indicator',17],['establishment_id',9]);

for($i = 1; $i <= 12; $i++) {
    $where = array_merge($base_where,array(['month',$i],['position','numerador']));
    $value = SingleParameter::where($where)->first();
    if($value) $data17['numeradores'][$i] = $value->value;
    else       $data17['numeradores'][$i] = null;

    $where = array_merge($base_where,array(['month',$i],['position','denominador']));
    $value = SingleParameter::where($where)->first();
    if($value) $data17['denominadores'][$i] = $value->value;
    else       $data17['denominadores'][$i] = null;
}

$data17['numerador_acumulado']   = array_sum($data17['numeradores']);
$data17['denominador_acumulado'] = array_sum($data17['denominadores']);

if($data17['denominador_acumulado'] != 0) {
    $data17['cumplimiento'] = $data17['numerador_acumulado'] / $data17['denominador_acumulado'] * 100;
}
else $data17['cumplimiento'] = 0;



if( $data17['cumplimiento'] >= preg_replace("/[^0-9]/", '', $data17['meta'])) {
    $data17['aporte'] = preg_replace("/[^0-9]/", '', $data17['ponderacion']);
}
else {
    $data17['aporte'] = $data17['cumplimiento'] *  preg_replace("/[^0-9]/", '', $data17['ponderacion']) / 100;
}



/***********  META 1.8. ************/
/* ==== Inicializar variables ==== */

/* reporte a mes*/

$data18['label']['meta'] = '1.8. Porcentaje de pretaciones trazadoras de
    tratamiento GES otrogadas según lo programado de prestaciones
    trazadoras de tratamiento GES en contrato PPV para el año t.';
$data18['label']['numerador']   = 'Número de prestaciones trazadoras de
    tratamiento GES otorgadas dentro del año t.';
$data18['label']['denominador'] = 'N° de prestaciones trazadoras de
    tratamiento GES programadas en el contrato PPV para el año t.';

$data18['label']['fuente']['numerador'] = 'Plataforma SIGES';
$data18['label']['fuente']['denominador'] = 'Programacion Anual';

$data18['meta'] = '100%';
$data18['meta_umbral'] = '60%';
$data18['ponderacion'] = '10%';


$base_where = array(['law','18834'],['year',$year],['indicator',18],
                    ['establishment_id',9],['position','numerador']);
$value = SingleParameter::where($base_where)->first();

$data18['vigencia'] = $value->month;

if($value) $data18['numerador_acumulado'] = $value->value;
else       $data18['numerador_acumulado'] = null;

$base_where = array(['law','18834'],['year',$year],['indicator',18],['establishment_id',9],['position','denominador']);
$value = SingleParameter::where($base_where)->first();
if($value) $data18['denominador_acumulado'] = $value->value;
else       $data18['denominador_acumulado'] = null;

if($data18['denominador_acumulado'] != 0) {
    $data18['cumplimiento'] = $data18['numerador_acumulado'] /
        $data18['denominador_acumulado'] * 100;
}
else $data18['cumplimiento'] = 0;



if( $data18['cumplimiento'] >= preg_replace("/[^0-9]/", '', $data18['meta_umbral'])) {
    //$data18['aporte'] = preg_replace("/[^0-9]/", '', $data18['ponderacion']);
    $data18['aporte'] = $data18['cumplimiento'] / 100 * preg_replace("/[^0-9]/", '', $data18['ponderacion']);
}
else {
    // $data18['aporte'] = $data18['cumplimiento'] *  preg_replace("/[^0-9]/", '', $data18['ponderacion']) / 100;
    $data18['aporte'] = 0;
}






/***********  META 3.1. ************/
/* ==== Inicializar variables ==== */
$data31['label']['meta'] = '3.1. Porcentajes de funcionarios regidos
    por el Estatuto Administrativo, capacitados durante el año en al
    menos una actividad pertinente, de los nueve ejes estratégicos de
    la Estrategia Nacional de Salud.';
$data31['label']['numerador']   = 'N° de funcionarios regidos por el EA
    capacitados durante el año 2019 en al menos una actividad de capacitación
    pertinente de los nueve Ejes de la Estrategia Nacional de Salud.';
$data31['label']['denominador'] = 'N° total de funcionarios de dotación,
    regidos por el EA.';

$data31['label']['fuente']['numerador'] = 'Reporte RRHH';
$data31['label']['fuente']['denominador'] = 'Reporte RRHH';

$data31['meta'] = '≥50%';
$data31['ponderacion'] = '30%';

$base_where = array(['law','18834'],['year',$year],['indicator',31],['establishment_id',9],['position','numerador']);
$value = SingleParameter::where($base_where)->first();
if($value) $data31['numerador_acumulado'] = $value->value;
else       $data31['numerador_acumulado'] = null;

$data31['vigencia'] = $value->month;


$base_where = array(['law','18834'],['year',$year],['indicator',31],['establishment_id',9],['position','denominador']);
$value = SingleParameter::where($base_where)->first();
if($value) $data31['denominador_acumulado'] = $value->value;
else       $data31['denominador_acumulado'] = null;


if($data31['denominador_acumulado'] != 0) {
  $data31['cumplimiento'] = $data31['numerador_acumulado'] / $data31['denominador_acumulado'] * 100;
}
else $data31['cumplimiento'] = 0;



if( $data31['cumplimiento'] >= preg_replace("/[^0-9]/", '', $data31['meta'])) {
    $data31['aporte'] = preg_replace("/[^0-9]/", '', $data31['ponderacion']);
}
else {
    $data31['aporte'] = $data31['cumplimiento'] *  preg_replace("/[^0-9]/", '', $data31['ponderacion']) / 100;
}


?>
