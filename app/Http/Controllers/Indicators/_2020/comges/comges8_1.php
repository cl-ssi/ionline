<?php

$meses = array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12);
$corte1 = array(1, 2, 3);
$naccionescorte1 = 4;
$naccionescorte2 = 2;
$naccionescorte3 = 1;
$naccionescorte4 = 3;

/***********  META 8.1 ************/
/* ==== Inicializar variables ==== */
$data8_1 = array();
$data8_1['label']['meta'] = '8.1 Porcentaje de cumplimiento de las acciones para el fortalecimiento de la salud bucal en el
periodo.';
//PONDERACION GLOBAL Y DE LOS 4 CORTES
$data8_1['ponderacion'] = '2,0%';
$data8_1[1]['anual'] = 25;
$data8_1[2]['anual'] = 25;
$data8_1[3]['anual'] = 25;
$data8_1[4]['anual'] = 25;
//POONDERACCIÓN ACCIONES [N°ACCION]
//$data8_1['meta'] = '100%';





//DATOS PARA INDICADORES ACCIÓN 1
$data8_1[1]['accion'] = '<br><strong>Línea Fortalecimiento de Registros:</strong><br>
1. Envío plan de acción para mejorar los registros existentes y los que ingresarán en el Sistema
de Gestión de Tiempos de Espera (SIGTE).<br>
2. Envío plan de acción para mejorar el registro en REM A 09 Secciones F-I.';
$data8_1[1]['iverificacion'] =6;
$data8_1[1]['verificacion'] = 'Plan de acción con responsables y actividades comprometidas para mejorar el registro en el
Sistema de Gestión de Tiempos de Espera (SIGTE) según formato.</li>
<li>Plan de acción con responsables y actividades comprometidas para mejorar el registro REM A
09 Secciones F-I según formato';
$data8_1[1]['meta'] = '100%';
$data8_1[1]['label']['numerador'] = 'Número de planes de acción enviados en el periodo t';
$data8_1[1]['label']['denominador'] = 'Número de planes de acción solicitados en el periodo t ';

foreach ($meses as $mes) {
    $data8_1[1]['numeradores'][$mes] = 0;
    $data8_1[1]['denominadores'][$mes] = 0;
}

$data8_1[1]['numeradores'][1] = 11;
$data8_1[1]['numeradores'][2] = 12;
$data8_1[1]['numeradores'][3] = 13;
$data8_1[1]['numerador_acumulado'] = array_sum($data8_1[1]['numeradores']);

$data8_1[1]['denominadores'][1] = 11;
$data8_1[1]['denominadores'][2] = 12;
$data8_1[1]['denominadores'][3] = 13;
$data8_1[1]['denominador_acumulado'] = array_sum($data8_1[1]['denominadores']);

$data8_1[1]['cumplimiento'] = ($data8_1[1]['numerador_acumulado'] /
    $data8_1[1]['denominador_acumulado']) * 100;


$data8_1[1]['ponderacion'] = 50;

$data8_1[1]['calculo'] =
    '
Resultado Obtenido                  Porcentaje de Cumplimiento Asignado
x=100,0%.                               100,0%
X<100,0%                                  0,0%
';
// calculo de cumplimiento
switch ($data8_1[1]['cumplimiento']) {
    case ($data8_1[1]['cumplimiento'] >= 100):
        $data8_1[1]['resultado'] = 100;
        break;
    default:
        $data8_1[1]['resultado'] = 0;
}
$data8_1[1]['cumplimientoponderado'] = (($data8_1[1]['resultado'] * $data8_1[1]['ponderacion']) / 100);


//DATOS PARA INDICADORES ACCIÓN 2
$data8_1[2]['accion'] = '<br><strong>Línea Fortalecimiento de la Coordinación en la Red Odontológica:</strong><br>
1. Realizar una Jornada de coordinación de la Red Asistencial Odontológica en cada Servicio de
Salud, con presentaciones de los referentes odontológicos de nivel primario y secundario.<br>
2. Adaptación de los Protocolos de Referencia y Contrarreferencia Nacionales en las
especialidades de Rehabilitación Oral, Trastornos Temporomandibulares y Dolor Orofacial y
Ortodoncia y Ortopedia Dento Maxilofacial. Este proceso de adaptación se debe realizar con
grupos de trabajo representativos de la Red Asistencial (especialistas, generales,
administrativos, encargados de registro, etc.).';
$data8_1[2]['iverificacion'] =1;
$data8_1[2]['verificacion'] = 'Envío de informe que contenga el programa de la Jornada, presentaciones realizadas y
listado de asistentes.</li>
<li> Envío de Protocolos confeccionados con su Resolución respectiva.</li>
<li> Ordinario de difusión a la Red de cada Servicio de Salud de los Protocolos confeccionados.</li>
<li> Acta(s) de reunión(es) junto a listados de asistencia, sobre la adaptación de los Protocolos';
$data8_1[2]['meta'] = '100%';
$data8_1[2]['label']['numerador'] = 'Número de acciones cumplidas en el periodo t';
$data8_1[2]['label']['denominador'] = 'Número de acciones solicitadas en el periodo t';

foreach ($meses as $mes) {
    $data8_1[2]['numeradores'][$mes] = 0;
    $data8_1[2]['denominadores'][$mes] = 0;
}

$data8_1[2]['numeradores'][1] = 11;
$data8_1[2]['numeradores'][2] = 12;
$data8_1[2]['numeradores'][3] = 13;
$data8_1[2]['numerador_acumulado'] = array_sum($data8_1[2]['numeradores']);

$data8_1[2]['denominadores'][1] = 11;
$data8_1[2]['denominadores'][2] = 12;
$data8_1[2]['denominadores'][3] = 13;
$data8_1[2]['denominador_acumulado'] = array_sum($data8_1[2]['denominadores']);

$data8_1[2]['cumplimiento'] = ($data8_1[2]['numerador_acumulado'] /
    $data8_1[2]['denominador_acumulado']) * 100;


$data8_1[2]['ponderacion'] = 50;

$data8_1[2]['calculo'] =
    '
Resultado                  Porcentaje de Cumplimiento Asignado
x=Envía informe con los contenidos solicitados.                               100,0%
X=Envía informe sin los contenidos solicitados o no envía informe               0,0%                                               0,0%
';
// calculo de cumplimiento
switch ($data8_1[2]['cumplimiento']) {
    case ($data8_1[2]['cumplimiento'] >= 100):
        $data8_1[2]['resultado'] = 100;
        break;
    default:
        $data8_1[2]['resultado'] = 0;
}
$data8_1[2]['cumplimientoponderado'] = (($data8_1[2]['resultado'] * $data8_1[2]['ponderacion']) / 100);



$data8_1['cumplimientoponderado']  = $data8_1[1]['cumplimientoponderado']+
                                    $data8_1[2]['cumplimientoponderado'];