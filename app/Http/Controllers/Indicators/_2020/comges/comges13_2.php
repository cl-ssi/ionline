<?php

$meses = array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12);
$corte1 = array(1, 2, 3);
$naccionescorte1 = 4;
$naccionescorte2 = 2;
$naccionescorte3 = 1;
$naccionescorte4 = 3;


/***********  META 13.2 ************/
/* ==== Inicializar variables ==== */
$data13_2 = array();
$data13_2['label']['meta'] = '13.2 Porcentaje de suspensión de intervenciones quirúrgicas en pacientes de tabla quirúrgica programada.';
//PONDERACION GLOBAL Y DE LOS 4 CORTES
$data13_2['ponderacion'] = '1,2%';
$data13_2[1]['anual'] = 25;
$data13_2[2]['anual'] = 25;
$data13_2[3]['anual'] = 25;
$data13_2[4]['anual'] = 25;


//DATOS PARA INDICADORES ACCIÓN 1
$data13_2[1]['accion'] = 'Alcanzar un porcentaje de suspensión de intervenciones quirúrgicas menor o igual a un <strong>10,0%.</strong>';
$data13_2[1]['iverificacion'] = 8;
$data13_2[1]['verificacion'] = 'Planilla en formato MINSAL, en base a datos REM.';
$data13_2[1]['meta'] = '<=10%';
$data13_2[1]['label']['numerador'] = 'N° de intervenciones quirúrgicas suspendidas en el periodo';
$data13_2[1]['label']['denominador'] = 'N° de intervenciones quirúrgicas programadas en el periodo';

foreach ($meses as $mes) {
    $data13_2[1]['numeradores'][$mes] = 0;
    $data13_2[1]['denominadores'][$mes] = 0;
}

$data13_2[1]['numeradores'][1] = 11;
$data13_2[1]['numeradores'][2] = 12;
$data13_2[1]['numeradores'][3] = 13;
$data13_2[1]['numerador_acumulado'] = array_sum($data13_2[1]['numeradores']);

$data13_2[1]['denominadores'][1] = 11;
$data13_2[1]['denominadores'][2] = 12;
$data13_2[1]['denominadores'][3] = 13;
$data13_2[1]['denominador_acumulado'] = array_sum($data13_2[1]['denominadores']);

$data13_2[1]['cumplimiento'] = ($data13_2[1]['numerador_acumulado'] /
    $data13_2[1]['denominador_acumulado']) * 100;


$data13_2[1]['ponderacion'] = 100;

$data13_2[1]['calculo'] =
    '
Resultado Obtenido                  Porcentaje de Cumplimiento Asignado
x<=10,0%.                                                   100,0%
11,0%>=X>10,0%                                               75,0%
12,0%>=X>11,0%                                               50,0%
13,0%>=X>12,0%                                               25,0%
X>13,0%                                                       0,0%
';
// calculo de cumplimiento
switch ($data13_2[1]['cumplimiento']) {
    case ($data13_2[1]['cumplimiento'] > 13):
        $data13_2[1]['resultado'] = 0;
        break;
    case ($data13_2[1]['cumplimiento'] > 12):
        $data13_2[1]['resultado'] = 25;
        break;
    case ($data13_2[1]['cumplimiento'] > 11):
        $data13_2[1]['resultado'] = 50;
        break;
    case ($data13_2[1]['cumplimiento'] >= 10):
        $data13_2[1]['resultado'] = 75;
        break;
    default:
        $data13_2[1]['resultado'] = 0;
}
$data13_2[1]['cumplimientoponderado'] = (($data13_2[1]['resultado'] * $data13_2[1]['ponderacion']) / 100);


$data13_2['cumplimientoponderado'] = $data13_2[1]['cumplimientoponderado'];