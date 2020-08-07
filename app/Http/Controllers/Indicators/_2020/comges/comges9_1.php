<?php

$meses = array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12);
$corte1 = array(1, 2, 3);
$naccionescorte1 = 4;
$naccionescorte2 = 2;
$naccionescorte3 = 1;
$naccionescorte4 = 3;

/***********  META 9.1 ************/
/* ==== Inicializar variables ==== */
$data9_1 = array();
$data9_1['label']['meta'] = '9.1 Porcentaje de cumplimiento de las etapas del proceso de actualización del Diseño de la Red
Temática de Salud Mental en la Red Asistencial.';
//PONDERACION GLOBAL Y DE LOS 4 CORTES
$data9_1['ponderacion'] = '2,0%';
$data9_1[1]['anual'] = 15;
$data9_1[2]['anual'] = 25;
$data9_1[3]['anual'] = 25;
$data9_1[4]['anual'] = 25;
//POONDERACCIÓN ACCIONES [N°ACCION]
//$data9_1['meta'] = '100%';





//DATOS PARA INDICADORES ACCIÓN 1
$data9_1[1]['accion'] = 'Oferta de Salud Mental de cada Servicio de Salud, considerando APS y especialidad';
$data9_1[1]['iverificacion'] =8;
$data9_1[1]['verificacion'] = 'Informe de Identificación de la Oferta de Salud Mental del Servicio de Salud.';
$data9_1[1]['meta'] = '100%';
$data9_1[1]['label']['numerador'] = 'Número de etapas cumplidas del proceso de actualización del Diseño de la Red Temática de
Salud Mental en la Red Asistencial en el periodo';
$data9_1[1]['label']['denominador'] = 'Número de etapas definidas del proceso de
actualización del Diseño de la Red Temática de Salud Mental en la Red Asistencial en el periodo';

foreach ($meses as $mes) {
    $data9_1[1]['numeradores'][$mes] = 0;
    $data9_1[1]['denominadores'][$mes] = 0;
}

$data9_1[1]['numeradores'][1] = 11;
$data9_1[1]['numeradores'][2] = 12;
$data9_1[1]['numeradores'][3] = 13;
$data9_1[1]['numerador_acumulado'] = array_sum($data9_1[1]['numeradores']);

$data9_1[1]['denominadores'][1] = 11;
$data9_1[1]['denominadores'][2] = 12;
$data9_1[1]['denominadores'][3] = 13;
$data9_1[1]['denominador_acumulado'] = array_sum($data9_1[1]['denominadores']);

$data9_1[1]['cumplimiento'] = ($data9_1[1]['numerador_acumulado'] /
    $data9_1[1]['denominador_acumulado']) * 100;


$data9_1[1]['ponderacion'] = 100;

$data9_1[1]['calculo'] =
    '
Resultado Obtenido                  Porcentaje de Cumplimiento Asignado
x=100,0%.                                       100,0%
X<100,0%                                    0,0%
';
// calculo de cumplimiento
switch ($data9_1[1]['cumplimiento']) {
    case ($data9_1[1]['cumplimiento'] >= 100):
        $data9_1[1]['resultado'] = 100;
        break;
    default:
        $data9_1[1]['resultado'] = 0;
}
$data9_1[1]['cumplimientoponderado'] = (($data9_1[1]['resultado'] * $data9_1[1]['ponderacion']) / 100);


$data9_1['cumplimientoponderado']  = $data9_1[1]['cumplimientoponderado'];