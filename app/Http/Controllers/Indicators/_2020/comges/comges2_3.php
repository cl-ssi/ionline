<?php

$meses = array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12);
$corte1 = array(1, 2, 3);
$naccionescorte1 = 4;
$naccionescorte2 = 2;
$naccionescorte3 = 1;
$naccionescorte4 = 3;

/***********  META 2.3 ************/
/* ==== Inicializar variables ==== */
$data2_3 = array();
$data2_3['label']['meta'] = '2.3 Porcentaje de cumplimiento de programación de horas de consultas de Telemedicina por
profesionales médicos especialistas en Atención Secundaria y Terciaria.';
//PONDERACION GLOBAL Y DE LOS 4 CORTES
$data2_3['ponderacion'] = '0,8%';
$data2_3[1]['anual'] = 20;
$data2_3[2]['anual'] = 25;
$data2_3[3]['anual'] = 25;
$data2_3[4]['anual'] = 25;


//DATOS PARA INDICADORES ACCIÓN 1
$data2_3[1]['accion'] = 'Cumplimiento de <strong>95,0%</strong> de las horas de consultas por Telemedicina de profesionales médicos
especialistas programadas Atención Secundaria y Terciaria.';
$data2_3[1]['iverificacion'] = 2;
$data2_3[1]['verificacion'] = 'Planilla consolidada del SS con el cumplimiento consultas de Telemedicina de profesionales
médicos especialistas programados al corte. (período enero- marzo 2020)';
$data2_3[1]['meta'] = '>=95%';
$data2_3[1]['label']['numerador'] = 'Número total de consultas por telemedicina de profesionales médicos especialistas realizadas en el periodo';
$data2_3[1]['label']['denominador'] = 'Total de consultas por Telemedicina de profesionales médicos especialistas programadas en el periodo';

foreach ($meses as $mes) {
    $data2_3[1]['numeradores'][$mes] = 0;
    $data2_3[1]['denominadores'][$mes] = 0;
}

$data2_3[1]['numeradores'][1] = 11;
$data2_3[1]['numeradores'][2] = 12;
$data2_3[1]['numeradores'][3] = 13;
$data2_3[1]['numerador_acumulado'] = array_sum($data2_3[1]['numeradores']);

$data2_3[1]['denominadores'][1] = 11;
$data2_3[1]['denominadores'][2] = 12;
$data2_3[1]['denominadores'][3] = 13;
$data2_3[1]['denominador_acumulado'] = array_sum($data2_3[1]['denominadores']);

$data2_3[1]['cumplimiento'] = ($data2_3[1]['numerador_acumulado'] /
    $data2_3[1]['denominador_acumulado']) * 100;


$data2_3[1]['ponderacion'] = 80;

$data2_3[1]['calculo'] =
    '
    Resultado Obtenido                   Porcentaje de Cumplimiento Asignado
    X>=95,0%                                       100,0%
    90,0%<=X<95,0%                                  75,0%
    85,0%<=X<90,0%                                  50,0%
    80,0%<=X<85,0%                                  25,0%
    X<80,0%                                          0,0%
';
// calculo de cumplimiento
switch ($data2_3[1]['cumplimiento']) {
    case ($data2_3[1]['cumplimiento'] >= 95):
        $data2_3[1]['resultado'] = 100;
        break;
    case ($data2_3[1]['cumplimiento'] >= 90):
        $data2_3[1]['resultado'] = 75;
        break;
    case ($data2_3[1]['cumplimiento'] >= 85):
        $data2_3[1]['resultado'] = 50;
        break;
    case ($data2_3[1]['cumplimiento'] >= 80):
        $data2_3[1]['resultado'] = 25;
        break;
    default:
        $data2_3[1]['resultado'] = 0;
}

$data2_3[1]['cumplimientoponderado'] = (($data2_3[1]['resultado'] * $data2_3[1]['ponderacion']) / 100);


//DATOS PARA INDICADORES ACCIÓN 2
$data2_3[2]['accion'] = 'Ordinario dirigido hacia Departamento de Salud Digital, que indique la definición del plan de
trabajo del año 2020 para la implementación de estrategias de Telemedicina, de acuerdo a los
criterios definidos en notas del indicador.';
$data2_3[2]['iverificacion'] = 1;
$data2_3[2]['verificacion'] = 'Envío de ordinario firmado por Director de SS con plan de trabajo para el año 2020, que
detalle: responsables, análisis de oferta y demanda, nodos críticos de implementación de
Telemedicina, de acuerdo a criterios definidos en notas de indicador.';
$data2_3[2]['meta'] = '100%';
$data2_3[2]['label']['numerador'] = 'Número de Ordinarios que indiquen la definición del plan de trabajo del año 2020 realizadas en el periodo';
$data2_3[2]['label']['denominador'] = 'Número de Ordinarios que indiquen la definición del plan de trabajo del año 2020 comprometidos en el periodo';

foreach ($meses as $mes) {
    $data2_3[2]['numeradores'][$mes] = 0;
    $data2_3[2]['denominadores'][$mes] = 0;
}

$data2_3[2]['numeradores'][1] = 11;
$data2_3[2]['numeradores'][2] = 12;
$data2_3[2]['numeradores'][3] = 13;
$data2_3[2]['numerador_acumulado'] = array_sum($data2_3[2]['numeradores']);

$data2_3[2]['denominadores'][1] = 11;
$data2_3[2]['denominadores'][2] = 12;
$data2_3[2]['denominadores'][3] = 13;
$data2_3[2]['denominador_acumulado'] = array_sum($data2_3[2]['denominadores']);

$data2_3[2]['cumplimiento'] = ($data2_3[2]['numerador_acumulado'] /
    $data2_3[2]['denominador_acumulado']) * 100;


$data2_3[2]['ponderacion'] = 20;

$data2_3[2]['calculo'] =
    '
Resultado Obtenido                   Porcentaje de Cumplimiento Asignado
X=100,0%                                       100,0%
X<100,0%                                          0,0%
';
// calculo de cumplimiento
switch ($data2_3[2]['cumplimiento']) {
    case ($data2_3[2]['cumplimiento'] >= 100):
        $data2_3[2]['resultado'] = 100;
        break;    
    default:
        $data2_3[2]['resultado'] = 0;
}
$data2_3[2]['cumplimientoponderado'] = (($data2_3[2]['resultado'] * $data2_3[2]['ponderacion']) / 100);








$data2_3['cumplimientoponderado'] = $data2_3[1]['cumplimientoponderado']+$data2_3[2]['cumplimientoponderado'];