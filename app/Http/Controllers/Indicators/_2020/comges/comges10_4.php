<?php

$meses = array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12);
$corte1 = array(1, 2, 3);
$naccionescorte1 = 4;
$naccionescorte2 = 2;
$naccionescorte3 = 1;
$naccionescorte4 = 3;



/***********  META 10.4 ************/
/* ==== Inicializar variables ==== */
$data10_4 = array();
$data10_4['label']['meta'] = '10.4 Porcentaje de cumplimiento de las acciones para el fortalecimiento del programa de
Atención Domiciliaria en el periodo.';
//PONDERACION GLOBAL Y DE LOS 4 CORTES
$data10_4['ponderacion'] = '1,0%';
$data10_4[1]['anual'] = 25;
$data10_4[2]['anual'] = 25;
$data10_4[3]['anual'] = 25;
$data10_4[4]['anual'] = 25;


//DATOS PARA INDICADORES ACCIÓN 1
$data10_4[1]['accion'] = 'Envío de Informe presentado por el Servicio de Salud para evaluación del I Corte que incluya:<br>
    - Resumen resultados de la auditoría anual del Programa Dependencia Severa año 2019 y
    desarrollo de la atención domiciliaria para personas con dependencia severa y sus cuidadores.<br>
    - Planificación de acciones de acompañamiento y supervisión técnica para la atención de
    personas con dependencia severa y la realización de al menos 2 Visitas Domiciliarias Integrales.<br>
    - Información sobre el desarrollo del área de cuidado al cuidador en las comunas y
    establecimientos de su jurisdicción.<br>
    - Planificación de acciones de acompañamiento y supervisión técnica para la evaluación y
    atención de cuidadores de personas con dependencia severa.';
$data10_4[1]['iverificacion'] =1;
$data10_4[1]['verificacion'] = 'Informe Técnico del I Corte entregado para evaluación a la División de Atención Primaria.';
$data10_4[1]['meta'] = '100%';
$data10_4[1]['label']['numerador'] = 'Número de acciones cumplidas para el fortalecimiento del programa de Atención Domiciliaria
en el periodo';
$data10_4[1]['label']['denominador'] = 'Número de acciones solicitadas para el fortalecimiento del programa de Atención
Domiciliaria en el periodo';

foreach ($meses as $mes) {
    $data10_4[1]['numeradores'][$mes] = 0;
    $data10_4[1]['denominadores'][$mes] = 0;
}

$data10_4[1]['numeradores'][1] = 11;
$data10_4[1]['numeradores'][2] = 12;
$data10_4[1]['numeradores'][3] = 13;
$data10_4[1]['numerador_acumulado'] = array_sum($data10_4[1]['numeradores']);

$data10_4[1]['denominadores'][1] = 11;
$data10_4[1]['denominadores'][2] = 12;
$data10_4[1]['denominadores'][3] = 13;
$data10_4[1]['denominador_acumulado'] = array_sum($data10_4[1]['denominadores']);

$data10_4[1]['cumplimiento'] = ($data10_4[1]['numerador_acumulado'] /
    $data10_4[1]['denominador_acumulado']) * 100;


$data10_4[1]['ponderacion'] = 100;

$data10_4[1]['calculo'] =
    '
Resultado                  Porcentaje de Cumplimiento Asignado
x=100,0%                               100,0%
X<100,0%                                 0,0%
';
// calculo de cumplimiento
switch ($data10_4[1]['cumplimiento']) {
    case ($data10_4[1]['cumplimiento'] >= 100):
        $data10_4[1]['resultado'] = 100;
        break;
    default:
        $data10_4[1]['resultado'] = 0;
}

$data10_4[1]['cumplimientoponderado'] = (($data10_4[1]['resultado'] * $data10_4[1]['ponderacion']) / 100);


$data10_4['cumplimientoponderado']  = $data10_4[1]['cumplimientoponderado'];