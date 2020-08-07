<?php

$meses = array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12);
$corte1 = array(1, 2, 3);
$naccionescorte1 = 4;
$naccionescorte2 = 2;
$naccionescorte3 = 1;
$naccionescorte4 = 3;

/***********  META 11.3 ************/
/* ==== Inicializar variables ==== */
$data11_3 = array();
$data11_3['label']['meta'] = '11.3 Porcentaje de usuarios que abandonan durante el Proceso de Atención de Urgencia en las
Unidades de Emergencia Hospitalaria Adulto y Pediátrica';
//PONDERACION GLOBAL Y DE LOS 4 CORTES
$data11_3['ponderacion'] = '1,333%';
$data11_3[1]['anual'] = 25;
$data11_3[2]['anual'] = 25;
$data11_3[3]['anual'] = 25;
$data11_3[4]['anual'] = 25;


//DATOS PARA INDICADORES ACCIÓN 1
$data11_3[1]['accion'] = 'Informe de medición, monitoreo y resultados de los indicadores del corte.';
$data11_3[1]['iverificacion'] = 1;
$data11_3[1]['verificacion'] = 'Planillas de reportes que den cuenta del resultado, con N° de Demanda de Urgencia y N° de
Atenciones de Urgencia. Fuente DEIS- REM A08';
$data11_3[1]['meta'] = '<=10%';
$data11_3[1]['label']['numerador'] = 'Número total de DAU generados en las Unidades de Emergencia Hospitalaria Adulto y Pediátrica en el periodo – Número total de altas desde las Unidades de Emergencia Hospitalaria Adulto y Pediátrica en el periodo';
$data11_3[1]['label']['denominador'] = 'Número total de DAU generados en las Unidades de Emergencia Hospitalaria Adulto y Pediátrica en el periodo';

foreach ($meses as $mes) {
    $data11_3[1]['numeradores'][$mes] = 0;
    $data11_3[1]['denominadores'][$mes] = 0;
}

$data11_3[1]['numeradores'][1] = 11;
$data11_3[1]['numeradores'][2] = 12;
$data11_3[1]['numeradores'][3] = 13;
$data11_3[1]['numerador_acumulado'] = array_sum($data11_3[1]['numeradores']);

$data11_3[1]['denominadores'][1] = 11;
$data11_3[1]['denominadores'][2] = 12;
$data11_3[1]['denominadores'][3] = 13;
$data11_3[1]['denominador_acumulado'] = array_sum($data11_3[1]['denominadores']);

$data11_3[1]['cumplimiento'] = ($data11_3[1]['numerador_acumulado'] /
    $data11_3[1]['denominador_acumulado']) * 100;


$data11_3[1]['ponderacion'] = 100;

$data11_3[1]['calculo'] =
    '
Resultado                   Porcentaje de Cumplimiento Asignado
X<=10,0%                                      100,0%
12,5%>=X>10,0%                                75,0%
15,0%>=X>12,5%                                 50,0%
17,5%>=X>15,0%                                  25,0%
X>17,5%                                         0,0%
';
// calculo de cumplimiento
switch ($data11_3[1]['cumplimiento']) {
    case ($data11_3[1]['cumplimiento'] > 17.5):
        $data11_3[1]['resultado'] = 0;
        break;
    case ($data11_3[1]['cumplimiento'] > 15):
        $data11_3[1]['resultado'] = 25;
        break;
    case ($data11_3[1]['cumplimiento'] > 12.5):
        $data11_3[1]['resultado'] = 50;
        break;
    case ($data11_3[1]['cumplimiento'] > 10):
        $data11_3[1]['resultado'] = 75;
        break;
    default:
        $data11_3[1]['resultado'] = 100;
}

$data11_3[1]['cumplimientoponderado'] = (($data11_3[1]['resultado'] * $data11_3[1]['ponderacion']) / 100);




$data11_3['cumplimientoponderado'] = $data11_3[1]['cumplimientoponderado'];