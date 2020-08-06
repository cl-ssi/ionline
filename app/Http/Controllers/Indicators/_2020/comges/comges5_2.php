<?php

$meses = array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12);
$corte1 = array(1, 2, 3);
$naccionescorte1 = 4;
$naccionescorte2 = 2;
$naccionescorte3 = 1;
$naccionescorte4 = 3;

/***********  META 5.2 ************/
/* ==== Inicializar variables ==== */
$data5_2 = array();
$data5_2['label']['meta'] = '5.2 Porcentaje de casos resueltos de la lista de espera de intervenciones quirúrgicas mayores
electivas, según meta definida para cada Servicio de Salud.';
//PONDERACION GLOBAL Y DE LOS 4 CORTES
$data5_2['ponderacion'] = '3,0%';
$data5_2[1]['anual'] = 20;
$data5_2[2]['anual'] = 25;
$data5_2[3]['anual'] = 25;
$data5_2[4]['anual'] = 25;


//DATOS PARA INDICADORES ACCIÓN 1
$data5_2[1]['accion'] = 'Resolución del <strong>15,0%</strong> de su universo total según la meta definida para SS.';
$data5_2[1]['iverificacion'] = 2;
$data5_2[1]['verificacion'] = 'Reporte SIGTE extraído desde MINSAL.';
$data5_2[1]['meta'] = '>=15%';
$data5_2[1]['label']['numerador'] = 'Número de casos resueltos de la lista de espera de intervenciones quirúrgicas electivas, según
meta ajustada para el Servicio de Salud en el periodo';
$data5_2[1]['label']['denominador'] = 'Número total de casos comprometidos a
resolver de la lista de espera de intervenciones quirúrgicas electivas, según meta ajustada para
el Servicio de Salud';

foreach ($meses as $mes) {
    $data5_2[1]['numeradores'][$mes] = 0;
    $data5_2[1]['denominadores'][$mes] = 0;
}

$data5_2[1]['numeradores'][1] = 11;
$data5_2[1]['numeradores'][2] = 12;
$data5_2[1]['numeradores'][3] = 13;
$data5_2[1]['numerador_acumulado'] = array_sum($data5_2[1]['numeradores']);

$data5_2[1]['denominadores'][1] = 11;
$data5_2[1]['denominadores'][2] = 12;
$data5_2[1]['denominadores'][3] = 13;
$data5_2[1]['denominador_acumulado'] = array_sum($data5_2[1]['denominadores']);

$data5_2[1]['cumplimiento'] = ($data5_2[1]['numerador_acumulado'] /
    $data5_2[1]['denominador_acumulado']) * 100;


$data5_2[1]['ponderacion'] = 40;

$data5_2[1]['calculo'] =
    '
Resultado                   Porcentaje de Cumplimiento Asignado
X>=15,0%                                        100,0%
12,0%<=X<15,0%                                75,0%
9,0%<=X<12,0%                                50,0%
6,0%<=X<9,0%                                25,0%
X<6,0%                                          0,0%
';
// calculo de cumplimiento
switch ($data5_2[1]['cumplimiento']) {
    case ($data5_2[1]['cumplimiento'] >= 15):
        $data5_2[1]['resultado'] = 100;
        break;
    case ($data5_2[1]['cumplimiento'] >= 12):
        $data5_2[1]['resultado'] = 75;
        break;
    case ($data5_2[1]['cumplimiento'] >= 9):
        $data5_2[1]['resultado'] = 50;
        break;
    case ($data5_2[1]['cumplimiento'] >= 6):
        $data5_2[1]['resultado'] = 25;
        break;
    default:
        $data5_2[1]['resultado'] = 0;
}

$data5_2[1]['cumplimientoponderado'] = (($data5_2[1]['resultado'] * $data5_2[1]['ponderacion']) / 100);


//DATOS PARA INDICADORES ACCIÓN 2
$data5_2[2]['accion'] = 'Resolución de <strong>100,0%</strong> de casos con fecha de ingreso según meta definida para SS.';
$data5_2[2]['iverificacion'] = 2;
$data5_2[2]['verificacion'] = 'Reporte SIGTE extraído desde MINSAL.';
$data5_2[2]['meta'] = '>=100%';
$data5_2[2]['label']['numerador'] = 'Número de casos resueltos de la lista de espera de intervenciones quirúrgicas electivas, según
meta ajustada para el Servicio de Salud en el periodo';
$data5_2[2]['label']['denominador'] = 'Número total de casos comprometidos a
resolver de la lista de espera de intervenciones quirúrgicas electivas, según meta ajustada para
el Servicio de Salud en el periodo';

foreach ($meses as $mes) {
    $data5_2[2]['numeradores'][$mes] = 0;
    $data5_2[2]['denominadores'][$mes] = 0;
}

$data5_2[2]['numeradores'][1] = 11;
$data5_2[2]['numeradores'][2] = 12;
$data5_2[2]['numeradores'][3] = 13;
$data5_2[2]['numerador_acumulado'] = array_sum($data5_2[2]['numeradores']);

$data5_2[2]['denominadores'][1] = 11;
$data5_2[2]['denominadores'][2] = 12;
$data5_2[2]['denominadores'][3] = 13;
$data5_2[2]['denominador_acumulado'] = array_sum($data5_2[2]['denominadores']);

$data5_2[2]['cumplimiento'] = ($data5_2[2]['numerador_acumulado'] /
    $data5_2[2]['denominador_acumulado']) * 100;


$data5_2[2]['ponderacion'] = 40;

$data5_2[2]['calculo'] =
    '
Resultado                   Porcentaje de Cumplimiento Asignado
X>=100,0%                               100,0%
90,0%<=X<100,0%                                75,0%
80,0%<=X<90,0%                                50,0%
70,0%<=X<80,0%                                25,0%
X<70,0%                                0,0%
';
// calculo de cumplimiento
switch ($data5_2[2]['cumplimiento']) {
    case ($data5_2[2]['cumplimiento'] >= 100):
        $data5_2[2]['resultado'] = 100;
        break;
    case ($data5_2[2]['cumplimiento'] >= 90):
        $data5_2[2]['resultado'] = 75;
        break;
    case ($data5_2[2]['cumplimiento'] >= 80):
        $data5_2[2]['resultado'] = 50;
        break;
    case ($data5_2[2]['cumplimiento'] >= 70):
        $data5_2[2]['resultado'] = 25;
        break;
    default:
        $data5_2[2]['resultado'] = 0;
}
$data5_2[2]['cumplimientoponderado'] = (($data5_2[2]['resultado'] * $data5_2[2]['ponderacion']) / 100);




//DATOS PARA INDICADORES ACCIÓN 3
$data5_2[3]['accion'] = 'Resolución del <strong>100,0%</strong> de casos SENAME según la meta definida para SS.';
$data5_2[3]['iverificacion'] = 2;
$data5_2[3]['verificacion'] = 'Reporte SIGTE extraído desde MINSAL.';
$data5_2[3]['meta'] = '0';
$data5_2[3]['label']['numerador'] = 'Número de casos <strong>abiertos</strong> de la lista de espera por ibtervenciones quirúrgicas mayores
electivas, correspondientes a casos de usuarios SENAME, con fecha de entrada mayor a 1 año';
$data5_2[3]['label']['denominador'] = ' Total de casos a resolver de la lista de espera por consultas nuevas de especialidades odontológicas de la Red
Asistencial comprometidos en el periodo';

foreach ($meses as $mes) {
    $data5_2[3]['numeradores'][$mes] = 0;
    $data5_2[3]['denominadores'][$mes] = 0;
}

// $data5_2[3]['numeradores'][1] = 11;
// $data5_2[3]['numeradores'][2] = 12;
// $data5_2[3]['numeradores'][3] = 13;
$data5_2[3]['numerador_acumulado'] = array_sum($data5_2[3]['numeradores']);

// $data5_2[3]['denominadores'][1] = 11;
// $data5_2[3]['denominadores'][2] = 12;
// $data5_2[3]['denominadores'][3] = 13;
$data5_2[3]['denominador_acumulado'] = array_sum($data5_2[3]['denominadores']);

// $data5_2[3]['cumplimiento'] = ($data5_2[3]['numerador_acumulado'] /
//     $data5_2[3]['denominador_acumulado']) * 100;

$data5_2[3]['cumplimiento'] = 0;

$data5_2[3]['ponderacion'] = 10;

$data5_2[3]['calculo'] =
    '
Resultado                   Porcentaje de Cumplimiento Asignado
X=0%                               100,0%
X>0                                0,0%
';
// calculo de cumplimiento/*

switch ($data5_2[3]['cumplimiento']) {
    case ($data5_2[3]['cumplimiento'] >= 15):
        $data5_2[3]['resultado'] = 100;
        break;
    case ($data5_2[3]['cumplimiento'] >= 12):
        $data5_2[3]['resultado'] = 75;
        break;
    case ($data5_2[3]['cumplimiento'] >= 9):
        $data5_2[3]['resultado'] = 50;
        break;
    case ($data5_2[3]['cumplimiento'] >= 6):
        $data5_2[3]['resultado'] = 25;
        break;
    default:
        $data5_2[3]['resultado'] = 0;
}

$data5_2[3]['cumplimientoponderado'] = (($data5_2[3]['resultado'] * $data5_2[3]['ponderacion']) / 100);


//DATOS PARA INDICADORES ACCIÓN 4
$data5_2[4]['accion'] = 'Resolución del <strong>15,0%</strong> del universo total de usuarios PRAIS primera generación con fecha de
ingreso igual o menor 30 de junio de 2019';
$data5_2[4]['iverificacion'] = 2;
$data5_2[4]['verificacion'] = 'Reporte SIGTE extraído desde MINSAL.';
$data5_2[4]['meta'] = '>=15%';
$data5_2[4]['label']['numerador'] = 'Número de casos resueltos de la lista de espera de intervenciones quirúrgicas electivas, de
usuarios PRAIS primera generación, según meta ajustada para el Servicio de Salud en el periodo';
$data5_2[4]['label']['denominador'] = 'Número total de casos comprometidos a resolver de la lista de espera de intervenciones
quirúrgicas electivas, de usuarios PRAIS primera generación, según meta ajustada para el Servicio
de Salud';
foreach ($meses as $mes) {
    $data5_2[4]['numeradores'][$mes] = 0;
    $data5_2[4]['denominadores'][$mes] = 0;
}
$data5_2[4]['numeradores'][1] = 11;
$data5_2[4]['numeradores'][2] = 12;
$data5_2[4]['numeradores'][3] = 13;
$data5_2[4]['numerador_acumulado'] = array_sum($data5_2[4]['numeradores']);

$data5_2[4]['denominadores'][1] = 11;
$data5_2[4]['denominadores'][2] = 12;
$data5_2[4]['denominadores'][3] = 13;
$data5_2[4]['denominador_acumulado'] = array_sum($data5_2[4]['denominadores']);

$data5_2[4]['cumplimiento'] = ($data5_2[4]['numerador_acumulado'] /
    $data5_2[4]['denominador_acumulado']) * 100;


$data5_2[4]['ponderacion'] = 10;

$data5_2[4]['calculo'] =
    '
Resultado                                      Resultado
X>=15,0%                                        100,0%
12,0%<=X<15,0%                                  75,0%
9,0%<=X<12,0%                                   50,0%
6,0%<=X<9,0%                                    25,0%
X<6,0%                                          0,0%
';
// calculo de cumplimiento
switch ($data5_2[4]['cumplimiento']) {
    case ($data5_2[4]['cumplimiento'] >= 15):
        $data5_2[4]['resultado'] = 100;
        break;
    case ($data5_2[4]['cumplimiento'] >= 12):
        $data5_2[4]['resultado'] = 75;
        break;
    case ($data5_2[4]['cumplimiento'] >= 9):
        $data5_2[4]['resultado'] = 50;
        break;
    case ($data5_2[4]['cumplimiento'] >= 6):
        $data5_2[4]['resultado'] = 25;
        break;
    default:
        $data5_2[4]['resultado'] = 0;
}
$data5_2[4]['cumplimientoponderado'] = (($data5_2[4]['resultado'] * $data5_2[4]['ponderacion']) / 100);






$data5_2['cumplimientoponderado'] = $data5_2[1]['cumplimientoponderado']+ $data5_2[2]['cumplimientoponderado']+$data5_2[3]['cumplimientoponderado']+$data5_2[4]['cumplimientoponderado'];