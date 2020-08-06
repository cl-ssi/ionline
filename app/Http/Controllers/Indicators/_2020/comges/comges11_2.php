<?php

$meses = array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12);
$corte1 = array(1, 2, 3);
$naccionescorte1 = 4;
$naccionescorte2 = 2;
$naccionescorte3 = 1;
$naccionescorte4 = 3;

/***********  META 11.2 ************/
/* ==== Inicializar variables ==== */
$data11_2 = array();
$data11_2['label']['meta'] = '11.2 Porcentaje de usuarios categorizados C2 atendidos oportunamente en las Unidades de
Emergencia Hospitalaria Adulto y Pediátrica en el periodo.';
//PONDERACION GLOBAL Y DE LOS 4 CORTES
$data11_2['ponderacion'] = '1,333%';
$data11_2[1]['anual'] = 20;
$data11_2[2]['anual'] = 25;
$data11_2[3]['anual'] = 25;
$data11_2[4]['anual'] = 25;


//DATOS PARA INDICADORES ACCIÓN 1
$data11_2[1]['accion'] = 'Informe de medición, monitoreo y resultados de los indicadores del corte.';
$data11_2[1]['iverificacion'] = 1;
$data11_2[1]['verificacion'] = 'Planillas de reportes que den cuenta del resultado, con N° de DAU y tiempos de
cumplimiento';
$data11_2[1]['meta'] = '>=90%';
$data11_2[1]['label']['numerador'] = 'N° total de usuarios C2 con primera atención médica en 30 minutos o menos, desde el tiempo de Categorización, en UEH en el periodo';
$data11_2[1]['label']['denominador'] = 'N° total de pacientes C2 atendidos en UEH en el periodo';

foreach ($meses as $mes) {
    $data11_2[1]['numeradores'][$mes] = 0;
    $data11_2[1]['denominadores'][$mes] = 0;
}

$data11_2[1]['numeradores'][1] = 11;
$data11_2[1]['numeradores'][2] = 12;
$data11_2[1]['numeradores'][3] = 13;
$data11_2[1]['numerador_acumulado'] = array_sum($data11_2[1]['numeradores']);

$data11_2[1]['denominadores'][1] = 11;
$data11_2[1]['denominadores'][2] = 12;
$data11_2[1]['denominadores'][3] = 13;
$data11_2[1]['denominador_acumulado'] = array_sum($data11_2[1]['denominadores']);

$data11_2[1]['cumplimiento'] = ($data11_2[1]['numerador_acumulado'] /
    $data11_2[1]['denominador_acumulado']) * 100;


$data11_2[1]['ponderacion'] = 100;

$data11_2[1]['calculo'] =
    '
Resultado                   Porcentaje de Cumplimiento Asignado
X>=15,0%                                      100,0%
12,0%<=X<15,0%                                75,0%
9,0%<=X<12,0%                                 50,0%
6,0%<=X<9,0%                                  25,0%
X<6,0%                                         0,0%
';
// calculo de cumplimiento
switch ($data11_2[1]['cumplimiento']) {
    case ($data11_2[1]['cumplimiento'] >= 90):
        $data11_2[1]['resultado'] = 100;
        break;
    case ($data11_2[1]['cumplimiento'] >= 85):
        $data11_2[1]['resultado'] = 75;
        break;
    case ($data11_2[1]['cumplimiento'] >= 80):
        $data11_2[1]['resultado'] = 50;
        break;
    case ($data11_2[1]['cumplimiento'] >= 75):
        $data11_2[1]['resultado'] = 25;
        break;
    default:
        $data11_2[1]['resultado'] = 0;
}

$data11_2[1]['cumplimientoponderado'] = (($data11_2[1]['resultado'] * $data11_2[1]['ponderacion']) / 100);




$data11_2['cumplimientoponderado'] = $data11_2[1]['cumplimientoponderado'];