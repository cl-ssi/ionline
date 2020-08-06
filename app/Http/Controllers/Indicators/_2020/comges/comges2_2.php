<?php

$meses = array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12);
$corte1 = array(1, 2, 3);
$naccionescorte1 = 4;
$naccionescorte2 = 2;
$naccionescorte3 = 1;
$naccionescorte4 = 3;

/***********  META 2.2 ************/
/* ==== Inicializar variables ==== */
$data2_2 = array();
$data2_2['label']['meta'] = '2.2 Porcentaje de cumplimiento de la programación de horas de consultas de profesionales en
Atención Secundaria y Terciaria.';
//PONDERACION GLOBAL Y DE LOS 4 CORTES
$data2_2['ponderacion'] = '1,2%';
$data2_2[1]['anual'] = 20;
$data2_2[2]['anual'] = 25;
$data2_2[3]['anual'] = 25;
$data2_2[4]['anual'] = 25;


//DATOS PARA INDICADORES ACCIÓN 1
$data2_2[1]['accion'] = 'Cumplimiento del <strong>95,0%</strong> de consultas totales de profesionales (excluye odontología) programados al corte';
$data2_2[1]['iverificacion'] = 1;
$data2_2[1]['verificacion'] = 'Planilla consolidada del SS con el cumplimiento consultas totales de profesionales (excluye
odontología) programados al corte. (período enero- marzo 2020)';
$data2_2[1]['meta'] = '>=95%';
$data2_2[1]['label']['numerador'] = 'Número total de consultas de profesionales médicos especialistas y de profesionales no
médicos realizadas en el periodo t';
$data2_2[1]['label']['denominador'] = ' Número total de consultas de profesionales médicos especialistas y de profesionales no médicos programadas en el periodo t';

foreach ($meses as $mes) {
    $data2_2[1]['numeradores'][$mes] = 0;
    $data2_2[1]['denominadores'][$mes] = 0;
}

$data2_2[1]['numeradores'][1] = 11;
$data2_2[1]['numeradores'][2] = 12;
$data2_2[1]['numeradores'][3] = 13;
$data2_2[1]['numerador_acumulado'] = array_sum($data2_2[1]['numeradores']);

$data2_2[1]['denominadores'][1] = 11;
$data2_2[1]['denominadores'][2] = 12;
$data2_2[1]['denominadores'][3] = 13;
$data2_2[1]['denominador_acumulado'] = array_sum($data2_2[1]['denominadores']);

$data2_2[1]['cumplimiento'] = ($data2_2[1]['numerador_acumulado'] /
    $data2_2[1]['denominador_acumulado']) * 100;


$data2_2[1]['ponderacion'] = 100;

$data2_2[1]['calculo'] =
    '
Resultado Obtenido                   Porcentaje de Cumplimiento Asignado
X>=95,0%                                       100,0%
90,0%<=X<95,0%                                  75,0%
85,0%<=X<90,0%                                  50,0%
80,0%<=X<85,0%                                  25,0%
X<80,0%                                          0,0%
';
// calculo de cumplimiento
switch ($data2_2[1]['cumplimiento']) {
    case ($data2_2[1]['cumplimiento'] >= 95):
        $data2_2[1]['resultado'] = 100;
        break;
    case ($data2_2[1]['cumplimiento'] >= 90):
        $data2_2[1]['resultado'] = 75;
        break;
    case ($data2_2[1]['cumplimiento'] >= 85):
        $data2_2[1]['resultado'] = 50;
        break;
    case ($data2_2[1]['cumplimiento'] >= 80):
        $data2_2[1]['resultado'] = 25;
        break;
    default:
        $data2_2[1]['resultado'] = 0;
}

$data2_2[1]['cumplimientoponderado'] = (($data2_2[1]['resultado'] * $data2_2[1]['ponderacion']) / 100);

$data2_2['cumplimientoponderado'] = $data2_2[1]['cumplimientoponderado'];
