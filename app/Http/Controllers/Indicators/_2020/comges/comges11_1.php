<?php

$meses = array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12);
$corte1 = array(1, 2, 3);
$naccionescorte1 = 4;
$naccionescorte2 = 2;
$naccionescorte3 = 1;
$naccionescorte4 = 3;

/***********  META 11.1 ************/
/* ==== Inicializar variables ==== */
$data11_1 = array();
$data11_1['label']['meta'] = '11.1 Porcentaje de derivación de pacientes con ENT desde los servicios de urgencia a establecimientos de Atencion Primaria de acuerdo con protocolo desarrollado e implementado en el periodo.';
//PONDERACION GLOBAL Y DE LOS 4 CORTES
$data11_1['ponderacion'] = '1,333%';
$data11_1[1]['anual'] = 25;
$data11_1[2]['anual'] = 25;
$data11_1[3]['anual'] = 25;
$data11_1[4]['anual'] = 30;
//POONDERACCIÓN ACCIONES [N°ACCION]
//$data11_1['meta'] = '100%';





//DATOS PARA INDICADORES ACCIÓN 1
$data11_1[1]['accion'] = 'Mantener el equipo de trabajo e incluir a organismos no participantes el año 2019, para el desarrollo de protocolos de derivación desde los SU hacia la red de APS';
$data11_1[1]['iverificacion'] = 6;
$data11_1[1]['verificacion'] = 'Resolución que sancione el equipo de trabajo, aprobada por el Director/a del SS respectivo.';
$data11_1[1]['meta'] = '100%';
$data11_1[1]['label']['numerador'] = 'No Aplica';
$data11_1[1]['label']['denominador'] = 'No Aplica';

foreach ($meses as $mes) {
    $data11_1[1]['numeradores'][$mes] = 0;
    $data11_1[1]['denominadores'][$mes] = 0;
}

$data11_1[1]['numeradores'][1] = 11;
$data11_1[1]['numeradores'][2] = 12;
$data11_1[1]['numeradores'][3] = 13;
$data11_1[1]['numerador_acumulado'] = array_sum($data11_1[1]['numeradores']);

$data11_1[1]['denominadores'][1] = 11;
$data11_1[1]['denominadores'][2] = 12;
$data11_1[1]['denominadores'][3] = 13;
$data11_1[1]['denominador_acumulado'] = array_sum($data11_1[1]['denominadores']);

$data11_1[1]['cumplimiento'] = ($data11_1[1]['numerador_acumulado'] /
    $data11_1[1]['denominador_acumulado']) * 100;


$data11_1[1]['ponderacion'] = 30;

$data11_1[1]['calculo'] =
    '
Resultado                                                                               Porcentaje de Cumplimiento Asignado
X=Envía resolución que sancione el equipo de trabajo.                                               100,0%
X=No Envía resolución que sancione el equipo de trabajo o de forma incompleta                 0,0%  
';
// calculo de cumplimiento
switch ($data11_1[1]['cumplimiento']) {
    case ($data11_1[1]['cumplimiento'] >= 10):
        $data11_1[1]['resultado'] = 100;
        break;
    case ($data11_1[1]['cumplimiento'] >= 7):
        $data11_1[1]['resultado'] = 75;
        break;
    case ($data11_1[1]['cumplimiento'] >= 4):
        $data11_1[1]['resultado'] = 50;
        break;
    case ($data11_1[1]['cumplimiento'] >= 1):
        $data11_1[1]['resultado'] = 25;
        break;
    default:
        $data11_1[1]['resultado'] = 0;
}
$data11_1[1]['cumplimientoponderado'] = (($data11_1[1]['resultado'] * $data11_1[1]['ponderacion']) / 100);






//DATOS PARA INDICADORES ACCIÓN 2
$data11_1[2]['accion'] = 'Establecer calendario de reuniones y supervisiones anual, en base a realidad local.';
$data11_1[2]['iverificacion'] = 1;
$data11_1[2]['verificacion'] = 'Ordinario que convoque a reunión al equipo de trabajo con calendario de reuniones y supervisiones establecido para el año en curso';
$data11_1[2]['meta'] = '100%';
$data11_1[2]['label']['numerador'] = 'No Aplica';
$data11_1[2]['label']['denominador'] = 'No Aplica';

foreach ($meses as $mes) {
    $data11_1[2]['numeradores'][$mes] = 0;
    $data11_1[2]['denominadores'][$mes] = 0;
}

$data11_1[2]['numeradores'][1] = 11;
$data11_1[2]['numeradores'][2] = 12;
$data11_1[2]['numeradores'][3] = 13;
$data11_1[2]['numerador_acumulado'] = array_sum($data11_1[2]['numeradores']);

$data11_1[2]['denominadores'][1] = 11;
$data11_1[2]['denominadores'][2] = 12;
$data11_1[2]['denominadores'][3] = 13;
$data11_1[2]['denominador_acumulado'] = array_sum($data11_1[2]['denominadores']);

$data11_1[2]['cumplimiento'] = ($data11_1[2]['numerador_acumulado'] /
    $data11_1[2]['denominador_acumulado']) * 100;


$data11_1[2]['ponderacion'] = 30;

$data11_1[2]['calculo'] =
    '
Resultado                                                                               Porcentaje de Cumplimiento Asignado
X=Envía Ordinario según instrucciones.                                               100,0%
X=No envía Ordinario según instrucciones o de forma incompleta                          0,0%
';
// calculo de cumplimiento
switch ($data11_1[2]['cumplimiento']) {
    case ($data11_1[2]['cumplimiento'] >= 100):
        $data11_1[2]['resultado'] = 100;
        break;
    case ($data11_1[2]['cumplimiento'] >= 90):
        $data11_1[2]['resultado'] = 75;
        break;
    case ($data11_1[2]['cumplimiento'] >= 80):
        $data11_1[2]['resultado'] = 50;
        break;
    case ($data11_1[2]['cumplimiento'] >= 70):
        $data11_1[2]['resultado'] = 25;
        break;
    default:
        $data11_1[2]['resultado'] = 0;
}
$data11_1[2]['cumplimientoponderado'] = (($data11_1[2]['resultado'] * $data11_1[2]['ponderacion']) / 100);






//DATOS PARA INDICADORES ACCIÓN 3
$data11_1[3]['accion'] = 'Alcanzar la implementación del protocolo en el <strong>100,0%</strong> de los establecimientos de la red.';
$data11_1[3]['iverificacion'] = 1;
$data11_1[3]['verificacion'] = 'Informe emitido por SS';
$data11_1[3]['meta'] = '100%';
$data11_1[3]['label']['numerador'] = 'Número de establecimientos con protocolo implementado en el periodo';
$data11_1[3]['label']['denominador'] = 'Número total de establecimientos del Servicio de Salud';

foreach ($meses as $mes) {
    $data11_1[3]['numeradores'][$mes] = 0;
    $data11_1[3]['denominadores'][$mes] = 0;
}

$data11_1[3]['numeradores'][1] = 11;
$data11_1[3]['numeradores'][2] = 12;
$data11_1[3]['numeradores'][3] = 13;
$data11_1[3]['numerador_acumulado'] = array_sum($data11_1[3]['numeradores']);

$data11_1[3]['denominadores'][1] = 11;
$data11_1[3]['denominadores'][2] = 12;
$data11_1[3]['denominadores'][3] = 13;
$data11_1[3]['denominador_acumulado'] = array_sum($data11_1[3]['denominadores']);

$data11_1[3]['cumplimiento'] = ($data11_1[3]['numerador_acumulado'] /
    $data11_1[3]['denominador_acumulado']) * 100;


$data11_1[3]['ponderacion'] = 40;

$data11_1[3]['calculo'] =
    '
Resultado                        Porcentaje de Cumplimiento Asignado
X=100,0%                                100,0%
90,0%<=X<100,0%                          75,0%
80,0%<=X<90,0%                           50,0%
70,0%<=X<80,0%                           25,0%
X<70,0%                                   0,0%
';
// calculo de cumplimiento
switch ($data11_1[3]['cumplimiento']) {
    case ($data11_1[3]['cumplimiento'] >= 100):
        $data11_1[3]['resultado'] = 100;
        break;
    case ($data11_1[3]['cumplimiento'] >= 90):
        $data11_1[3]['resultado'] = 75;
        break;
    case ($data11_1[3]['cumplimiento'] >= 80):
        $data11_1[3]['resultado'] = 50;
        break;
    case ($data11_1[3]['cumplimiento'] >= 70):
        $data11_1[3]['resultado'] = 25;
        break;
    default:
        $data11_1[3]['resultado'] = 0;
}
$data11_1[3]['cumplimientoponderado'] = (($data11_1[3]['resultado'] * $data11_1[3]['ponderacion']) / 100);








$data11_1['cumplimientoponderado'] = $data11_1[1]['cumplimientoponderado']+ $data11_1[2]['cumplimientoponderado']+ $data11_1[3]['cumplimientoponderado'];