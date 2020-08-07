<?php

$meses = array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12);
$corte1 = array(1, 2, 3);
$naccionescorte1 = 4;
$naccionescorte2 = 2;
$naccionescorte3 = 1;
$naccionescorte4 = 3;


/***********  META 10.3 ************/
/* ==== Inicializar variables ==== */
$data10_3 = array();
$data10_3['label']['meta'] = '10.3 Porcentaje de personas con 65 años o más ingresadas a Cuidado Integral, que cuentan con
Plan de Cuidado Integral Consensuado en el periodo.';
//PONDERACION GLOBAL Y DE LOS 4 CORTES
$data10_3['ponderacion'] = '1,0%';
$data10_3[1]['anual'] = 25;
$data10_3[2]['anual'] = 25;
$data10_3[3]['anual'] = 25;
$data10_3[4]['anual'] = 25;


//DATOS PARA INDICADORES ACCIÓN 1
$data10_3[1]['accion'] = '100% de las personas de 65 años y más ingresadas al Cuidado Integral cuentan con plan de
cuidado integral consensuado a la fecha de corte';
$data10_3[1]['iverificacion'] =1;
$data10_3[1]['verificacion'] = 'Reporte REM extraido por MINSAL.';
$data10_3[1]['meta'] = '100%';
$data10_3[1]['label']['numerador'] = 'Número de personas de 65 años o más ingresadas a Cuidado Integral centrado en las personas
que cuentan con plan de cuidado integral consensuado';
$data10_3[1]['label']['denominador'] = 'N° total de personas de 65 años y más
ingresadas a Cuidado Integral centrado en las personas';

foreach ($meses as $mes) {
    $data10_3[1]['numeradores'][$mes] = 0;
    $data10_3[1]['denominadores'][$mes] = 0;
}

$data10_3[1]['numeradores'][1] = 11;
$data10_3[1]['numeradores'][2] = 12;
$data10_3[1]['numeradores'][3] = 13;
$data10_3[1]['numerador_acumulado'] = array_sum($data10_3[1]['numeradores']);

$data10_3[1]['denominadores'][1] = 11;
$data10_3[1]['denominadores'][2] = 12;
$data10_3[1]['denominadores'][3] = 13;
$data10_3[1]['denominador_acumulado'] = array_sum($data10_3[1]['denominadores']);

$data10_3[1]['cumplimiento'] = ($data10_3[1]['numerador_acumulado'] /
    $data10_3[1]['denominador_acumulado']) * 100;


$data10_3[1]['ponderacion'] = 100;

$data10_3[1]['calculo'] =
    '
Resultado                  Porcentaje de Cumplimiento Asignado
x=100,0%                               100,0%
X<100,0%                            Según cumplimiento
';
// calculo de cumplimiento
switch ($data10_3[1]['cumplimiento']) {
    case ($data10_3[1]['cumplimiento'] >= 100):
        $data10_3[1]['resultado'] = 100;
        break;
    default:
        $data10_3[1]['resultado'] = 0;
}

$data10_3[1]['cumplimientoponderado'] = (($data10_3[1]['resultado'] * $data10_3[1]['ponderacion']) / 100);


$data10_3['cumplimientoponderado']  = $data10_3[1]['cumplimientoponderado'];