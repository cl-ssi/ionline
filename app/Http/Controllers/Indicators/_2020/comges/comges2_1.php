<?php

$meses = array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12);
$corte1 = array(1, 2, 3);
$naccionescorte1 = 4;
$naccionescorte2 = 2;
$naccionescorte3 = 1;
$naccionescorte4 = 3;

/***********  META 2.1 ************/
/* ==== Inicializar variables ==== */
$data2_1 = array();
$data2_1['label']['meta'] = '2.1 Porcentaje de cumplimiento de la programación de actividades trazadoras críticas por comuna
y/o establecimiento de Atención Primaria de Salud.';
//PONDERACION GLOBAL Y DE LOS 4 CORTES
$data2_1['ponderacion'] = '1,0%';
$data2_1[1]['anual'] = 25;
$data2_1[2]['anual'] = 25;
$data2_1[3]['anual'] = 25;
$data2_1[4]['anual'] = 30;
//POONDERACCIÓN ACCIONES [N°ACCION]
//$data2_1['meta'] = '100%';





//DATOS PARA INDICADORES ACCIÓN 1
$data2_1[1]['accion'] = 'Programación de 51 trazadoras por comuna y establecimiento dependiente de Servicio de Salud';
$data2_1[1]['iverificacion'] = 1;
$data2_1[1]['verificacion'] = 'Planilla estandarizada de 51 trazadoras por comuna y establecimiento dependiente, con
datos provenientes de programación operativa de APS';
$data2_1[1]['meta'] = '100%';
$data2_1[1]['label']['numerador'] = 'Número de planillas estandarizadas con programación realizadas en el periodo t';
$data2_1[1]['label']['denominador'] = 'Número de planillas estandarizadas con programación comprometidas en el periodo t';

foreach ($meses as $mes) {
    $data2_1[1]['numeradores'][$mes] = 0;
    $data2_1[1]['denominadores'][$mes] = 0;
}

$data2_1[1]['numeradores'][1] = 11;
$data2_1[1]['numeradores'][2] = 12;
$data2_1[1]['numeradores'][3] = 13;
$data2_1[1]['numerador_acumulado'] = array_sum($data2_1[1]['numeradores']);

$data2_1[1]['denominadores'][1] = 11;
$data2_1[1]['denominadores'][2] = 12;
$data2_1[1]['denominadores'][3] = 13;
$data2_1[1]['denominador_acumulado'] = array_sum($data2_1[1]['denominadores']);

$data2_1[1]['cumplimiento'] = ($data2_1[1]['numerador_acumulado'] /
    $data2_1[1]['denominador_acumulado']) * 100;


$data2_1[1]['ponderacion'] = 80;

$data2_1[1]['calculo'] =
    '
Resultado Obtenido                  Porcentaje de Cumplimiento Asignado
x=100,0%                                       100,0%
X<100,0%                             Porcentaje de comunas con programación
';
// calculo de cumplimiento
switch ($data2_1[1]['cumplimiento']) {
    case ($data2_1[1]['cumplimiento'] >= 100):
        $data2_1[1]['resultado'] = 100;
        break;    
    default:
        $data2_1[1]['resultado'] = 0;
}
$data2_1[1]['cumplimientoponderado'] = (($data2_1[1]['resultado'] * $data2_1[1]['ponderacion']) / 100);



//DATOS PARA INDICADORES ACCIÓN 2
$data2_1[2]['accion'] = 'Difusión de trazadoras a la Red de APS.';
$data2_1[2]['iverificacion'] = 1;
$data2_1[2]['verificacion'] = '. Acta de reunión de SS con la red APS o correos electrónicos que aborden difusión de 51
trazadoras a la Red';
$data2_1[2]['meta'] = '100%';
$data2_1[2]['label']['numerador'] = 'Número de medios de verificación con difusión de 51 trazadoras a la Red enviados en el periodo t';
$data2_1[2]['label']['denominador'] = 'Número de medios de verificación con difusión de 51 trazadoras a la Red comprometidos en el periodo t';

foreach ($meses as $mes) {
    $data2_1[2]['numeradores'][$mes] = 0;
    $data2_1[2]['denominadores'][$mes] = 0;
}

$data2_1[2]['numeradores'][2] = 11;
$data2_1[2]['numeradores'][2] = 12;
$data2_1[2]['numeradores'][3] = 13;
$data2_1[2]['numerador_acumulado'] = array_sum($data2_1[2]['numeradores']);

$data2_1[2]['denominadores'][2] = 11;
$data2_1[2]['denominadores'][2] = 12;
$data2_1[2]['denominadores'][3] = 13;
$data2_1[2]['denominador_acumulado'] = array_sum($data2_1[2]['denominadores']);

$data2_1[2]['cumplimiento'] = ($data2_1[2]['numerador_acumulado'] /
    $data2_1[2]['denominador_acumulado']) * 100;


$data2_1[2]['ponderacion'] = 20;

$data2_1[2]['calculo'] =
    '
Resultado Obtenido                  Porcentaje de Cumplimiento Asignado
x=100,0%                                       100,0%
X<100,0%                                         0,0%
';
// calculo de cumplimiento
switch ($data2_1[2]['cumplimiento']) {
    case ($data2_1[2]['cumplimiento'] >= 100):
        $data2_1[2]['resultado'] = 100;
        break;    
    default:
        $data2_1[2]['resultado'] = 0;
}
$data2_1[2]['cumplimientoponderado'] = (($data2_1[2]['resultado'] * $data2_1[2]['ponderacion']) / 100);






$data2_1['cumplimientoponderado']  = $data2_1[1]['cumplimientoponderado']+$data2_1[2]['cumplimientoponderado'];