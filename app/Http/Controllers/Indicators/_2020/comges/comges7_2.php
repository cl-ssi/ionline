<?php

$meses = array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12);
$corte1 = array(1, 2, 3);
$naccionescorte1 = 4;
$naccionescorte2 = 2;
$naccionescorte3 = 1;
$naccionescorte4 = 3;




/***********  META 7.2 ************/
/* ==== Inicializar variables ==== */
$data7_2 = array();
$data7_2['label']['meta'] = '7.2 Porcentaje de cumplimiento de las actividades de implementación del modelo de gestión
de la red oncológica para el periodo.';
//PONDERACION GLOBAL Y DE LOS 4 CORTES
$data7_2['ponderacion'] = '1,0%';
$data7_2[1]['anual'] = 35;
$data7_2[2]['anual'] = 25;
$data7_2[3]['anual'] = 25;
$data7_2[4]['anual'] = 25;


//DATOS PARA INDICADORES ACCIÓN 1
$data7_2[1]['accion'] = 'Designar, mediante Resolución Exenta, a un “Gestor de Red Oncológica” en el Servicio de Salud.';
$data7_2[1]['iverificacion'] =2;
$data7_2[1]['verificacion'] = 'Resolución Exenta que nombra al “Gestor de Red Oncológica” del Servicio de Salud, enviada
via ordinario al Departamento de Manejo Integral del Cáncer del Ministerio de Salud.';
$data7_2[1]['meta'] = '100%';
$data7_2[1]['label']['numerador'] = 'Número de Resoluciones Exentas de nombramiento del “Gestor de Red Oncológica” del Servicio
de Salud, enviada via ordinario al Departamento de Manejo Integral del Cáncer del Ministerio de
Salud';
$data7_2[1]['label']['denominador'] = 'Número de Resoluciones Exentas de nombramiento del “Gestor de Red Oncológica” del
Servicio de Salud, comprometidas para el periodo';

foreach ($meses as $mes) {
    $data7_2[1]['numeradores'][$mes] = 0;
    $data7_2[1]['denominadores'][$mes] = 0;
}

$data7_2[1]['numeradores'][1] = 11;
$data7_2[1]['numeradores'][2] = 12;
$data7_2[1]['numeradores'][3] = 13;
$data7_2[1]['numerador_acumulado'] = array_sum($data7_2[1]['numeradores']);

$data7_2[1]['denominadores'][1] = 11;
$data7_2[1]['denominadores'][2] = 12;
$data7_2[1]['denominadores'][3] = 13;
$data7_2[1]['denominador_acumulado'] = array_sum($data7_2[1]['denominadores']);

$data7_2[1]['cumplimiento'] = ($data7_2[1]['numerador_acumulado'] /
    $data7_2[1]['denominador_acumulado']) * 100;


$data7_2[1]['ponderacion'] = 40;

$data7_2[1]['calculo'] =
    '
Resultado Obtenido Meta Mantención                  Porcentaje de Cumplimiento Asignado
X=100,0%                               100,0%
X<100,0%                                0,0%
';
// calculo de cumplimiento
switch ($data7_2[1]['cumplimiento']) {
    case ($data7_2[1]['cumplimiento'] >= 100):
        $data7_2[1]['resultado'] = 100;
        break;    
    default:
        $data7_2[1]['resultado'] = 0;
}

$data7_2[1]['cumplimientoponderado'] = (($data7_2[1]['resultado'] * $data7_2[1]['ponderacion']) / 100);


//DATOS PARA INDICADORES ACCIÓN 2
$data7_2[2]['accion'] = 'Presentación de pacientes a Comité Oncológico Multidisciplinario antes del primer tratamiento
oncológico.';
$data7_2[2]['iverificacion'] =1;
$data7_2[2]['verificacion'] = 'Informe del Comité oncológico en el que se informa resumen de los casos evaluados en el mes
de Marzo 2020 que especifique el número de pacientes presentados ante el Comité antes del
primer tratamiento, el total de pacientes presentados ante el Comité y el número de
reuniones efectuadas.';
$data7_2[2]['meta'] = '100%';
$data7_2[2]['label']['numerador'] = 'Número de informes trimestrales del Comité oncológico enviados al Departamento Manejo
Integral del Cáncer';
$data7_2[2]['label']['denominador'] = 'Número de informes comprometidos para el periodo';

foreach ($meses as $mes) {
    $data7_2[2]['numeradores'][$mes] = 0;
    $data7_2[2]['denominadores'][$mes] = 0;
}

$data7_2[2]['numeradores'][1] = 11;
$data7_2[2]['numeradores'][2] = 12;
$data7_2[2]['numeradores'][3] = 13;
$data7_2[2]['numerador_acumulado'] = array_sum($data7_2[2]['numeradores']);

$data7_2[2]['denominadores'][1] = 11;
$data7_2[2]['denominadores'][2] = 12;
$data7_2[2]['denominadores'][3] = 13;
$data7_2[2]['denominador_acumulado'] = array_sum($data7_2[2]['denominadores']);

$data7_2[2]['cumplimiento'] = ($data7_2[2]['numerador_acumulado'] /
    $data7_2[2]['denominador_acumulado']) * 100;


$data7_2[2]['ponderacion'] = 20;

$data7_2[2]['calculo'] =
    '
Resultado                  Porcentaje de Cumplimiento Asignado
x=Envía informe con los contenidos solicitados.                               100,0%
X=Envía informe sin los contenidos solicitados o no envía informe               0,0%                                               0,0%
';
// calculo de cumplimiento
switch ($data7_2[2]['cumplimiento']) {
    case ($data7_2[2]['cumplimiento'] >= 100):
        $data7_2[2]['resultado'] = 100;
        break;
    default:
        $data7_2[2]['resultado'] = 0;
}
$data7_2[2]['cumplimientoponderado'] = (($data7_2[2]['resultado'] * $data7_2[2]['ponderacion']) / 100);




//DATOS PARA INDICADORES ACCIÓN 3
$data7_2[3]['accion'] = 'Reuniones mensuales del Consejo Técnico Local del Servicio de Salud.';
$data7_2[3]['iverificacion'] =1;
$data7_2[3]['verificacion'] = 'Actas del Consejó Tecnico Local correspondientes a marzo del año 2020, que especifique el
seguimiento de los indicadores del Modelo de Gestión de la Red Oncológica.';
$data7_2[3]['meta'] = '100%';
$data7_2[3]['label']['numerador'] = 'Número de actas del consejo técnico local enviados al Departamento Manejo Integral del
Cáncer';
$data7_2[3]['label']['denominador'] = 'Número de actas comprometidas para el periodo';

foreach ($meses as $mes) {
    $data7_2[3]['numeradores'][$mes] = 0;
    $data7_2[3]['denominadores'][$mes] = 0;
}

$data7_2[3]['numeradores'][1] = 11;
$data7_2[3]['numeradores'][2] = 12;
$data7_2[3]['numeradores'][3] = 13;
$data7_2[3]['numerador_acumulado'] = array_sum($data7_2[3]['numeradores']);

$data7_2[3]['denominadores'][1] = 11;
$data7_2[3]['denominadores'][2] = 12;
$data7_2[3]['denominadores'][3] = 13;
$data7_2[3]['denominador_acumulado'] = array_sum($data7_2[3]['denominadores']);

$data7_2[3]['cumplimiento'] = ($data7_2[3]['numerador_acumulado'] /
    $data7_2[3]['denominador_acumulado']) * 100;


$data7_2[3]['ponderacion'] = 20;

$data7_2[3]['calculo'] =
    '
Resultado                  Porcentaje de Cumplimiento Asignado
x=Envía informe con los contenidos solicitados.                               100,0%
X=Envía informe sin los contenidos solicitados o no envía informe               0,0%                                               0,0%
';
// calculo de cumplimiento
switch ($data7_2[3]['cumplimiento']) {
    case ($data7_2[3]['cumplimiento'] >= 100):
        $data7_2[3]['resultado'] = 100;
        break;
    default:
        $data7_2[3]['resultado'] = 0;
}
$data7_2[3]['cumplimientoponderado'] = (($data7_2[3]['resultado'] * $data7_2[3]['ponderacion']) / 100);




//DATOS PARA INDICADORES ACCIÓN 4
$data7_2[4]['accion'] = 'Reuniones trimestrales del Comisión Macrorregional de Cáncer.';
$data7_2[4]['iverificacion'] =1;
$data7_2[4]['verificacion'] = 'Acta del Comisión Macrorregional de Cáncer correspondiente al primer trimestre del año
2020<a href="#" title="Las actas deberán ser realizadas en formato enviado por el Departamento de Manejo Integral del Cáncer, el que dará cuenta de los temas presentados en la reunión y el plan de trabajo para el siguiente trimestre."><sup>23</sup></a>, que especifiquen los temas presentados en la reunión y el plan de trabajo para el siguiente trimestre';
$data7_2[4]['meta'] = '100%';
$data7_2[4]['label']['numerador'] = 'Número de actas de la Comisión Macrorregional de Cáncer enviadas al Departamento Manejo
Integral del Cáncer';
$data7_2[4]['label']['denominador'] = 'Número de actas comprometidas para el periodo';

foreach ($meses as $mes) {
    $data7_2[4]['numeradores'][$mes] = 0;
    $data7_2[4]['denominadores'][$mes] = 0;
}

$data7_2[4]['numeradores'][1] = 11;
$data7_2[4]['numeradores'][2] = 12;
$data7_2[4]['numeradores'][3] = 13;
$data7_2[4]['numerador_acumulado'] = array_sum($data7_2[4]['numeradores']);

$data7_2[4]['denominadores'][1] = 11;
$data7_2[4]['denominadores'][2] = 12;
$data7_2[4]['denominadores'][3] = 13;
$data7_2[4]['denominador_acumulado'] = array_sum($data7_2[4]['denominadores']);

$data7_2[4]['cumplimiento'] = ($data7_2[4]['numerador_acumulado'] /
    $data7_2[4]['denominador_acumulado']) * 100;


$data7_2[4]['ponderacion'] = 20;

$data7_2[4]['calculo'] =
    '
ResultadoObtenido Meta Mantención                  Porcentaje de Cumplimiento Asignado
x=100,0%                                                        100,0%
X<100,0%                                                          0,0%
';
// calculo de cumplimiento
switch ($data7_2[4]['cumplimiento']) {
    case ($data7_2[4]['cumplimiento'] >= 100):
        $data7_2[4]['resultado'] = 100;
        break;
    default:
        $data7_2[4]['resultado'] = 0;
}
$data7_2[4]['cumplimientoponderado'] = (($data7_2[4]['resultado'] * $data7_2[4]['ponderacion']) / 100);




$data7_2['cumplimientoponderado']  = $data7_2[1]['cumplimientoponderado']+
                                    $data7_2[2]['cumplimientoponderado']+
                                    $data7_2[3]['cumplimientoponderado']+
                                    $data7_2[4]['cumplimientoponderado'];

