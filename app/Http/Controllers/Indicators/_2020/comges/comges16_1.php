<?php
use App\Models\Indicators\SingleParameter;

$meses = array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12);
$corte1 = array(1, 2, 3);
$naccionescorte1 = 4;
$naccionescorte2 = 2;
$naccionescorte3 = 1;
$naccionescorte4 = 3;

/***********  META 16.1 ************/
/* ==== Inicializar variables ==== */
$data16_1 = array();
$data16_1['label']['meta'] = '16.1 Porcentaje de cumplimiento de actividades del Plan Cuatrienal de Mejoramiento de la
Satisfacción Usuaria en Urgencia, Farmacia y Lista de Espera, en los establecimientos
hospitalarios y de Atención Primaria de Salud.';




//PONDERACION GLOBAL Y DE LOS 4 CORTES
$data16_1['ponderacion'] = '4%';
$data16_1[1]['anual'] = 25;
$data16_1[2]['anual'] = '25%';
$data16_1[3]['anual'] = '25%';
$data16_1[4]['anual'] = '25%';
//POONDERACCIÓN ACCIONES [N°ACCION]
//$data16_1['meta'] = '100%';





//DATOS PARA INDICADORES
$data16_1[1]['accion'] = 'Cumplimiento del <strong>25,0%</strong> de las actividades comprometidas del Plan de Mejoramiento de la
Satisfacción Usuaria, en Recepción y acogida, trato e información a usuarios y usuarias, en
Urgencia, Farmacia y Lista de Espera, con evaluación de las acciones desarrolladas en el corte.';
$data16_1[1]['verificacion'] = 'Cumplimiento del Plan (anexo 4 año 2019), en formato de anexo 6 MINSAL 2020.</li>
<li>Informe de Evaluación, en formato de anexo 7 MINSAL 2020';
$data16_1[1]['meta'] = '25%';
$data16_1[1]['label']['numerador'] = 'Número de actividades ejecutadas del Plan Cuatrienal de Mejoramiento de la Satisfacción
Usuaria en el periodo t ';
$data16_1[1]['label']['denominador'] = 'Total de actividades comprometidas en el periodo t';
//ponderacion corte
$data16_1[1]['ponderacion'] = 100;



//DATOS PARA ACCIÓN 1
foreach ($meses as $mes) {
    $data16_1[1]['numeradores'][$mes] = 0;
    $data16_1[1]['denominadores'][$mes] = 0;
}

$data16_1[1]['numerador_acumulado']=0;
$data16_1[1]['denominador_acumulado']=0;
$base_where = array(['law','Comges'],['year',2020],['indicator',"16.1"],['establishment_id',8]);
foreach ($meses as $mes) {
$value = SingleParameter::where(array_merge($base_where,array(['month',$mes],['position','numerador'])))->first();
if($value) 
{$data16_1[1]['numeradores'][$mes] = $value;
$data16_1[1]['numerador_acumulado'] += $value->value;}
else       $data16_1[1]['numeradores'][$mes] = null;

$value = SingleParameter::where(array_merge($base_where,array(['month',$mes],['position','denominador'])))->first();
if($value) 
{$data16_1[1]['denominadores'][$mes] = $value;
$data16_1[1]['denominador_acumulado'] += $value->value;}
else       $data16_1[1]['denominadores'][$mes] = null;

}

if ($data16_1[1]['denominador_acumulado'] > 0)
$data16_1[1]['cumplimiento'] = ($data16_1[1]['numerador_acumulado'] /  $data16_1[1]['denominador_acumulado']) * 100;
else
$data16_1[1]['cumplimiento'] = 0;


$data16_1[1]['calculo'] =
    '
Resultado                  Porcentaje de Cumplimiento Asignado
x>=25,0%                                100,0%
20,0<=X<25,0%                                        75,0%
15,0<=X<20,0%                                        50,0%
10,0<=X<15,0%                                        25,0%
X<10,0%                                               0,0%
';
// calculo de cumplimiento
switch ($data16_1[true]) {
    case ($data16_1[1]['cumplimiento'] >= 25):
        $data16_1[1]['resultado'] = 100;
        break;
    case ($data16_1[1]['cumplimiento'] >= 20):
        $data16_1[1]['resultado'] = 75;
        break;
    case ($data16_1[1]['cumplimiento'] >= 15):
        $data16_1[1]['resultado'] = 50;
        break;
    case ($data16_1[1]['cumplimiento'] >= 10):
        $data16_1[1]['resultado'] = 25;
        break;
    default:
        $data16_1[1]['resultado'] = 0;
}

$data16_1[1]['cumplimientoponderado'] = (($data16_1[1]['resultado'] * $data16_1[1]['ponderacion']) / 100);











/// DATOS CORTE  % CUMPLIMIENTO
$data16['cumplimientocorte1'] = $data16_1[1]['cumplimientoponderado'];


$data16_1['cumplimientoponderado'] = $data16_1[1]['cumplimientoponderado'];
