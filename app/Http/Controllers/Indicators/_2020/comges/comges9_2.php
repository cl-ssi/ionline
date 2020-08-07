<?php

$meses = array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12);
$corte1 = array(1, 2, 3);
$naccionescorte1 = 4;
$naccionescorte2 = 2;
$naccionescorte3 = 1;
$naccionescorte4 = 3;


/***********  META 9.2 ************/
/* ==== Inicializar variables ==== */
$data9_2 = array();
$data9_2['label']['meta'] = '9.2 Porcentaje de cobertura de consultorías de salud mental en establecimientos de APS.';
//PONDERACION GLOBAL Y DE LOS 4 CORTES
$data9_2['ponderacion'] = '2,0%';
$data9_2[1]['anual'] = 15;
$data9_2[2]['anual'] = 25;
$data9_2[3]['anual'] = 25;
$data9_2[4]['anual'] = 25;


//DATOS PARA INDICADORES ACCIÓN 1
$data9_2[1]['accion'] = '<strong>8,0%</strong> de cumplimiento de ejecución de consultorías de salud mental de adultos';
$data9_2[1]['iverificacion'] =1;
$data9_2[1]['verificacion'] = 'REM A-06, Sección A2, Col. 3</li>
<li> Registro Local de Teleconsultorías.';
$data9_2[1]['meta'] = '8%';
$data9_2[1]['label']['numerador'] = 'N° de actividades de consultorías realizadas en el periodo';
$data9_2[1]['label']['denominador'] = 'N° de actividades de consultorías de salud mental programadas';

foreach ($meses as $mes) {
    $data9_2[1]['numeradores'][$mes] = 0;
    $data9_2[1]['denominadores'][$mes] = 0;
}

$data9_2[1]['numeradores'][1] = 11;
$data9_2[1]['numeradores'][2] = 12;
$data9_2[1]['numeradores'][3] = 13;
$data9_2[1]['numerador_acumulado'] = array_sum($data9_2[1]['numeradores']);

$data9_2[1]['denominadores'][1] = 11;
$data9_2[1]['denominadores'][2] = 12;
$data9_2[1]['denominadores'][3] = 13;
$data9_2[1]['denominador_acumulado'] = array_sum($data9_2[1]['denominadores']);

$data9_2[1]['cumplimiento'] = ($data9_2[1]['numerador_acumulado'] /
    $data9_2[1]['denominador_acumulado']) * 100;


$data9_2[1]['ponderacion'] = 100;

$data9_2[1]['calculo'] =
    '
Resultado                  Porcentaje de Cumplimiento Asignado
X>=8,0%                               100,0%
5,0%<=X<8,0%               75,0%
3,0%<=X<5,0%               50,0%
1,0%<=X<3,0%               25,0%
X<1,0%                      0,0%

';
// calculo de cumplimiento
switch ($data9_2[1]['cumplimiento']) {
    case ($data9_2[1]['cumplimiento'] >= 8):
        $data9_2[1]['resultado'] = 100;
        break;
    case ($data9_2[1]['cumplimiento'] >= 5):
        $data9_2[1]['resultado'] = 75;
        break;
    case ($data9_2[1]['cumplimiento'] >= 3):
        $data9_2[1]['resultado'] = 50;
        break;
    case ($data9_2[1]['cumplimiento'] >= 1):
        $data9_2[1]['resultado'] = 25;
        break;
    default:
        $data9_2[1]['resultado'] = 0;
}
$data9_2[1]['cumplimientoponderado'] = (($data9_2[1]['resultado'] * $data9_2[1]['ponderacion']) / 100);




$data9_2['cumplimientoponderado']  = $data9_2[1]['cumplimientoponderado'];
