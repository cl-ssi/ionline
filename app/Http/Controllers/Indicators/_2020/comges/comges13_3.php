<?php

$meses = array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12);
$corte1 = array(1, 2, 3);
$naccionescorte1 = 4;
$naccionescorte2 = 2;
$naccionescorte3 = 1;
$naccionescorte4 = 3;



/***********  META 13.3 ************/
/* ==== Inicializar variables ==== */
$data13_3 = array();
$data13_3['label']['meta'] = '13.3 Porcentaje de ocupación de quirófanos de cirugía electiva.';
//PONDERACION GLOBAL Y DE LOS 4 CORTES
$data13_3['ponderacion'] = '1,2%';
$data13_3[1]['anual'] = 25;
$data13_3[2]['anual'] = 25;
$data13_3[3]['anual'] = 25;
$data13_3[4]['anual'] = 25;


//DATOS PARA INDICADORES ACCIÓN 1
$data13_3[1]['accion'] = 'Cumplir con un 25,0% de la meta de reducción para el año 2020.<br>
<strong>Meta de Reducción = LB + [(80,0% - LB) / 4].</strong>';
$data13_3[1]['iverificacion'] = '3';
$data13_3[1]['verificacion'] = 'Planilla en formato MINSAL, en base a datos REM.';
$data13_3[1]['meta'] = '<=25%';
$data13_3[1]['label']['numerador'] = 'N° de horas de cirugias ocupadas en Qx trabajo';
$data13_3[1]['label']['denominador'] = 'N° Horas totales dosponibles Qx habilitados';

foreach ($meses as $mes) {
    $data13_3[1]['numeradores'][$mes] = 0;
    $data13_3[1]['denominadores'][$mes] = 0;
}

$data13_3[1]['numeradores'][1] = 11;
$data13_3[1]['numeradores'][2] = 12;
$data13_3[1]['numeradores'][3] = 13;
$data13_3[1]['numerador_acumulado'] = array_sum($data13_3[1]['numeradores']);

$data13_3[1]['denominadores'][1] = 11;
$data13_3[1]['denominadores'][2] = 12;
$data13_3[1]['denominadores'][3] = 13;
$data13_3[1]['denominador_acumulado'] = array_sum($data13_3[1]['denominadores']);

$data13_3[1]['cumplimiento'] = ($data13_3[1]['numerador_acumulado'] /
    $data13_3[1]['denominador_acumulado']) * 100;


$data13_3[1]['ponderacion'] = 100;

$data13_3[1]['calculo'] =
    '
Resultado                  Porcentaje de Cumplimiento Asignado
x<=5,6%.                               100,0%
5,9%>=X>5,6%                                               75,0%
6,2%>=X>5,9%                                               50,0%
6,5%>=X>6,2%                                               25,0%
X>6,5%                                               0,0%
';
// calculo de cumplimiento
switch ($data13_3[1]['cumplimiento']) {
    case ($data13_3[1]['cumplimiento'] <= 5.6):
        $data13_3[1]['resultado'] = 100;
        break;
    case ($data13_3[1]['cumplimiento'] <= 5.9):
        $data13_3[1]['resultado'] = 75;
        break;
    case ($data13_3[1]['cumplimiento'] <= 6.2):
        $data13_3[1]['resultado'] = 50;
        break;
    case ($data13_3[1]['cumplimiento'] <= 6.5):
        $data13_3[1]['resultado'] = 25;
        break;
    default:
        $data13_3[1]['resultado'] = 0;
}
$data13_3[1]['cumplimientoponderado'] = (($data13_3[1]['resultado'] * $data13_3[1]['ponderacion']) / 100);



$data13_3['cumplimientoponderado'] =$data13_3[1]['cumplimientoponderado'];
