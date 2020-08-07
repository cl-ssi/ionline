<?php

$meses = array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12);
$corte1 = array(1, 2, 3);
$naccionescorte1 = 4;
$naccionescorte2 = 2;
$naccionescorte3 = 1;
$naccionescorte4 = 3;

/***********  META 12.1 ************/
/* ==== Inicializar variables ==== */
$data12_1 = array();
$data12_1['label']['meta'] = '12.1 Índice Funcional.';
//PONDERACION GLOBAL Y DE LOS 4 CORTES
$data12_1['ponderacion'] = '1,5%';
$data12_1[1]['anual'] = 25;
$data12_1[2]['anual'] = 25;
$data12_1[3]['anual'] = 25;
$data12_1[4]['anual'] = 25;
//POONDERACCIÓN ACCIONES [N°ACCION]
//$data12_1['meta'] = '100%';





//DATOS PARA INDICADORES ACCIÓN 1
$data12_1[1]['accion'] = 'Cálculo del Índice Funcional del periodo de enero a marzo. Para efectos del cálculo de
cumplimiento del Servicio de Salud, los Índices Funcionales de cada establecimiento son
evaluados de manera indidivual, según la tabla de sensibilidad del indicador. El promedio de los
porcentajes de cumplimiento corresponde al resultado del Servicio de Salud al corte.';
$data12_1[1]['verificacion'] = 'Reporte extraído desde MINSAL';
$data12_1[1]['meta'] = '100%';
$data12_1[1]['label']['numerador'] = 'CUMPLIMIENTO ASIGNADO';
$data12_1[1]['label']['denominador'] = 'N';

foreach ($meses as $mes) {
    $data12_1[1]['numeradores'][$mes] = 0;
    $data12_1[1]['denominadores'][$mes] = 0;
}

$data12_1[1]['numeradores'][1] = 11;
$data12_1[1]['numeradores'][2] = 12;
$data12_1[1]['numeradores'][3] = 13;
$data12_1[1]['numerador_acumulado'] = array_sum($data12_1[1]['numeradores']);

$data12_1[1]['denominadores'][1] = 11;
$data12_1[1]['denominadores'][2] = 12;
$data12_1[1]['denominadores'][3] = 13;
$data12_1[1]['denominador_acumulado'] = array_sum($data12_1[1]['denominadores']);

$data12_1[1]['cumplimiento'] = ($data12_1[1]['numerador_acumulado'] /
    $data12_1[1]['denominador_acumulado']) * 100;


$data12_1[1]['ponderacion'] = 100;

$data12_1[1]['calculo'] =
    '
Resultado                  Porcentaje de Cumplimiento Asignado
x=Envía informe con los contenidos solicitados.                               100,0%
X=Envía informe sin los contenidos solicitados o no envía informe               0,0%                                               0,0%
';
// calculo de cumplimiento
switch ($data12_1[1]['cumplimiento']) {
    case ($data12_1[1]['cumplimiento'] >= 100):
        $data12_1[1]['resultado'] = 100;
        break;
    default:
        $data12_1[1]['resultado'] = 0;
}
$data12_1[1]['cumplimientoponderado'] = (($data12_1[1]['resultado'] * $data12_1[1]['ponderacion']) / 100);


$data12_1['cumplimientoponderado']= $data12_1[1]['cumplimientoponderado'];