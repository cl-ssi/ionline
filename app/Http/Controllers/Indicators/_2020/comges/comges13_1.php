<?php

$meses = array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12);
$corte1 = array(1, 2, 3);
$naccionescorte1 = 4;
$naccionescorte2 = 2;
$naccionescorte3 = 1;
$naccionescorte4 = 3;

/***********  META 13.1 ************/
/* ==== Inicializar variables ==== */
$data13_1 = array();
$data13_1['label']['meta'] = '13.1 Porcentaje de ambulatorización de cirugías mayores';
//PONDERACION GLOBAL Y DE LOS 4 CORTES
$data13_1['ponderacion'] = '1,6%';
$data13_1[1]['anual'] = 25;
$data13_1[2]['anual'] = 25;
$data13_1[3]['anual'] = 25;
$data13_1[4]['anual'] = 25;






//DATOS PARA INDICADORES ACCIÓN 1
$data13_1[1]['accion'] = 'Alcanzar el porcentaje de aumento de ambulatorización de intervenciones quirúrgicas mayores,
según el porcentaje obtenido durante el año 2018 (X):';
$data13_1[1]['iverificacion'] = '11';
$data13_1[1]['verificacion'] = 'Planilla en formato MINSAL, en base a datos GRD.';
$data13_1[1]['meta'] = '100%';
$data13_1[1]['label']['numerador'] = 'Porcentaje de ambulatorización de cirugías mayores en el periodo';
$data13_1[1]['label']['denominador'] = 'Porcentaje de ambulatorización de cirugías mayores en el año 2019';

foreach ($meses as $mes) {
    $data13_1[1]['numeradores'][$mes] = 0;
    $data13_1[1]['denominadores'][$mes] = 0;
}

$data13_1[1]['numeradores'][1] = 11;
$data13_1[1]['numeradores'][2] = 12;
$data13_1[1]['numeradores'][3] = 13;
$data13_1[1]['numerador_acumulado'] = array_sum($data13_1[1]['numeradores']);

$data13_1[1]['denominadores'][1] = 11;
$data13_1[1]['denominadores'][2] = 12;
$data13_1[1]['denominadores'][3] = 13;
$data13_1[1]['denominador_acumulado'] = array_sum($data13_1[1]['denominadores']);

$data13_1[1]['cumplimiento'] = ($data13_1[1]['numerador_acumulado'] /
    $data13_1[1]['denominador_acumulado']) * 100;


$data13_1[1]['ponderacion'] = 100;

$data13_1[1]['calculo'] =
    '
Resultado                  Porcentaje de Cumplimiento Asignado
x=Envía informe con los contenidos solicitados.                               100,0%
X=Envía informe sin los contenidos solicitados o no envía informe               0,0%                                               0,0%
';
// calculo de cumplimiento
switch ($data13_1[1]['cumplimiento']) {
    case ($data13_1[1]['cumplimiento'] >= 100):
        $data13_1[1]['resultado'] = 100;
        break;
    default:
        $data13_1[1]['resultado'] = 0;
}
$data13_1[1]['cumplimientoponderado'] = (($data13_1[1]['resultado'] * $data13_1[1]['ponderacion']) / 100);


$data13_1['cumplimientoponderado']= $data13_1[1]['cumplimientoponderado'];