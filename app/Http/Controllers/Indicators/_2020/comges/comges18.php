<?php

use App\Models\Indicators\SingleParameter;

$meses = array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12);
$corte1inicio = 1;


/***********  META 18.1 ************/
/* ==== Inicializar variables ==== */
$data18_1 = array();
$data18_1['label']['meta'] = '18.1 Porcentaje de acciones ejecutadas, medidas y evaluadas del Plan Comunicacional Institucional en el periodo.';
$data18_1[1]['label']['numerador'] = 'Sumatoria porcentajes de cumplimiento ponderados obtenidos según los requisitos para el
diseño del plan comunicacional institucional en el periodo t';
$data18_1[1]['label']['denominador'] = 'Sumatoria porcentajes de
cumplimiento ponderados de los requisitos para el diseño del plan comunicacional institucional
máximo a obtener';


//PONDERACION GLOBAL Y DE LOS 4 CORTES
$data18_1['ponderacion'] = '4%';
$data18_1[1]['anual'] = 25;
$data18_1[2]['anual'] = '25%';
$data18_1[3]['anual'] = '25%';
$data18_1[4]['anual'] = '25%';
//POONDERACCIÓN ACCIONES [N°ACCION]
//$data18_1['meta'] = '100%';

//ponderacion corte
$data18_1[1]['meta'] = '100%';
$data18_1[1]['ponderacion'] = 100;
$data18_1[2]['ponderacion'] = 25;
$data18_1[3]['ponderacion'] = 25;
$data18_1[4]['ponderacion'] = 25;


$data18_1[1]['accion'] = 'Diseño de Plan Comunicacional Institucional, considerando los resultados de la evaluación y
sistematización del año 2019';
$data18_1[1]['verificacion'] = 'Plan Comunicacional Institucional según formato MINSAL.';

//DATOS PARA ACCIÓN 1
foreach ($meses as $mes) {
    $data18_1[1]['numeradores'][$mes] = 0;
    $data18_1[1]['denominadores'][$mes] = 0;
}

$data18_1[1]['numerador_acumulado']=0;
$data18_1[1]['denominador_acumulado']=0;
$base_where = array(['law','Comges'],['year',2020],['indicator',"18.1"],['establishment_id',8]);
foreach ($meses as $mes) {
$value = SingleParameter::where(array_merge($base_where,array(['month',$mes],['position','numerador'])))->first();
if($value) 
{$data18_1[1]['numeradores'][$mes] = $value;
$data18_1[1]['numerador_acumulado'] += $value->value;}
else       $data18_1[1]['numeradores'][$mes] = null;

$value = SingleParameter::where(array_merge($base_where,array(['month',$mes],['position','denominador'])))->first();
if($value) 
{$data18_1[1]['denominadores'][$mes] = $value;
$data18_1[1]['denominador_acumulado'] += $value->value;}
else       $data18_1[1]['denominadores'][$mes] = null;

}

if ($data18_1[1]['denominador_acumulado'] > 0)
$data18_1[1]['cumplimiento'] = ($data18_1[1]['numerador_acumulado'] /  $data18_1[1]['denominador_acumulado']) * 100;
else
$data18_1[1]['cumplimiento'] = 0;

$data18_1[1]['calculo'] =
'
Resultado Obtenido                  Porcentaje de Cumplimiento Asignado
Diseño de Plan Comunicacional Institucional                                8,0%
Objetivo Estratégico/General                                                8,0%
Objetivo(s) Específico(s).                                                  8,0%
Actividad(es).                                                              8,0%
Descripción Metodológica              .                                     8,0%
Producto Esperado o Resultado/Impacto.                                 8,0%
Medio Verificador.                                                        8,0%
Responsables.                                                               8,0%
Participantes.                                                                  8,0%
Observaciones.                                                              8,0%
Cronograma.                                                                 20,0%
';
// calculo de cumplimiento
switch ($data18_1[true]) {
    case ($data18_1[1]['cumplimiento'] >= 100):
        $data18_1[1]['resultado'] = 100;
        break;
    
    default:
        $data18_1[1]['resultado'] = $data18_1[1]['cumplimiento'];
}

$data18_1[1]['cumplimientoponderado'] = (($data18_1[1]['resultado'] * $data18_1[1]['ponderacion'])/100);







 /// DATOS CORTE  % CUMPLIMIENTO
 $data18['cumplimientocorte1'] = $data18_1[1]['cumplimientoponderado'];
 //$data22['cumplimientocorte1'] = 0;

