<?php

$meses = array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12);
$corte1 = array(1, 2, 3);
$naccionescorte1 = 4;
$naccionescorte2 = 2;
$naccionescorte3 = 1;
$naccionescorte4 = 3;

/***********  META 10.2 ************/
/* ==== Inicializar variables ==== */
$data10_2 = array();
$data10_2['label']['meta'] = '10.2 Porcentaje de establecimientos que programan controles integrados para personas de 65
años o más, con dos o más patologías crónicas en el periodo.';
//PONDERACION GLOBAL Y DE LOS 4 CORTES
$data10_2['ponderacion'] = '1,0%';
$data10_2[1]['anual'] = 20;
$data10_2[2]['anual'] = 25;
$data10_2[3]['anual'] = 25;
$data10_2[4]['anual'] = 25;


//DATOS PARA INDICADORES ACCIÓN 1
$data10_2[1]['accion'] = 'Envío de Informe Técnico validado por Director de Servicio de Salud que contenga para este
indicador:<br>
- Información sobre el desarrollo local alcanzado al año 2019 en el área de programación y
ejecución de controles integrados para personas mayores con más de una condición crónica de
salud.<br>
- Planificación de acciones de acompañamiento y supervisión técnica por parte del SS para su
red de establecimientos, tendiente a reforzar aspectos de planificación y programación, y otros
como capacitación de equipos para atención de personas mayores, para mejorar la atención
centrada en las necesidades de las personas mayores y el cuidado de personas con condiciones
crónicas.';
$data10_2[1]['iverificacion'] =3;
$data10_2[1]['verificacion'] = 'Informe Técnico del III Corte entregado para evaluación a la División de Atención Primaria.';
$data10_2[1]['meta'] = '65%';
$data10_2[1]['label']['numerador'] = 'Número de acciones cumplidas para la implementación de controles integrados en personas de
65 años o más, con dos o más patologías crónicas en el periodo';
$data10_2[1]['label']['denominador'] = ' Número de acciones solicitadas
para la implementación de controles integrados en personas de 65 años o más, con dos o más
patologías crónicas en el periodo';

foreach ($meses as $mes) {
    $data10_2[1]['numeradores'][$mes] = 0;
    $data10_2[1]['denominadores'][$mes] = 0;
}

$data10_2[1]['numeradores'][1] = 11;
$data10_2[1]['numeradores'][2] = 12;
$data10_2[1]['numeradores'][3] = 13;
$data10_2[1]['numerador_acumulado'] = array_sum($data10_2[1]['numeradores']);

$data10_2[1]['denominadores'][1] = 11;
$data10_2[1]['denominadores'][2] = 12;
$data10_2[1]['denominadores'][3] = 13;
$data10_2[1]['denominador_acumulado'] = array_sum($data10_2[1]['denominadores']);

$data10_2[1]['cumplimiento'] = ($data10_2[1]['numerador_acumulado'] /
    $data10_2[1]['denominador_acumulado']) * 100;


$data10_2[1]['ponderacion'] = 100;

$data10_2[1]['calculo'] =
    '
Resultado                  Porcentaje de Cumplimiento Asignado
x=100,0%                               100,0%
X<100,0%                                 0,0%
';
// calculo de cumplimiento
switch ($data10_2[1]['cumplimiento']) {
    case ($data10_2[1]['cumplimiento'] >= 100):
        $data10_2[1]['resultado'] = 100;
        break;
    default:
        $data10_2[1]['resultado'] = 0;
}
$data10_2[1]['cumplimientoponderado'] = (($data10_2[1]['resultado'] * $data10_2[1]['ponderacion']) / 100);


$data10_2['cumplimientoponderado']  = $data10_2[1]['cumplimientoponderado'];