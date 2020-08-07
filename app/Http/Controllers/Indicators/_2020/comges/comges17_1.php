<?php

$meses = array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12);
$corte1 = array(1, 2, 3);
$naccionescorte1 = 4;
$naccionescorte2 = 2;
$naccionescorte3 = 1;
$naccionescorte4 = 3;

/***********  META 17.1 ************/
/* ==== Inicializar variables ==== */
$data17_1 = array();
$data17_1['label']['meta'] = '17.1 Porcentaje de acciones implementadas del Plan Estratégico de Participación Ciudadana, diseñado por los Servicios de Salud para el año 2020.';
///ESTE COMGES 17 NO TIENE NUMERADOR DENOMINADOR, SE DESCRIBE NUMERADOR COMO VALOR A SOLICITAR

$data17_1[1]['label']['numerador'] = 'Envío Informe según indicaciones';
$data17_1[1]['label']['denominador'] = 'Número de actividades solicitadas en el periodo t';







//PONDERACION GLOBAL Y DE LOS 4 CORTES
$data17_1['ponderacion'] = '4%';
$data17_1[1]['anual'] = 30;
$data17_1[2]['anual'] = '25%';
$data17_1[3]['anual'] = '25%';
$data17_1[4]['anual'] = '25%';
//POONDERACCIÓN ACCIONES [N°ACCION]
//$data17_1['meta'] = '100%';
$data17_1[1]['meta'] = '100%';
$data17_1[1]['ponderacion'] = 40;
$data17_1[2]['ponderacion'] = 20;
$data17_1[3]['ponderacion'] = 40;



$data17_1[1]['accion'] = 'Elaboración de Diagnóstico territorial de Participación Ciudadana, el cual debe contener las
consideraciones técnicas y los aspectos solicitados según formato Minsal, enviado previo a la
evaluación del corte.';
$data17_1[1]['verificacion'] = 'Informe Plan Anual de Participación (Formato Minsal).';
$data17_1[2]['accion'] = 'Planteamiento de los objetivos del Plan Anual de Participación, los cuales deben estar en
concordancia con el diagnostico territorial realizado';
$data17_1[2]['verificacion'] = 'Informe Plan Anual de Participación (Formato Minsal).';
$data17_1[3]['accion'] = 'Planificación de actividades considerando:<br>
    <strong>Actividades de Participación:</strong><br>
    − 5 conversatorios (1 corte II, 2 corte III y 2 corte IV) en temáticas priorizadas por el Servicio
    de Salud.<br>
    − 1 Diálogo Participativo (Corte II) en temática priorizada por el Servicio de Salud.<br>
    − 1 Consulta ciudadana virtual y/o presencial al año, en temática priorizada por el Servicio de
    Salud, visada por el Departamento de Participación Ciudadana y Trato al Usuario del
    Ministerio de Salud. (Esta consulta se puede realizar en el periodo correspondiente a los
    cortes II, III o IV; pero debe ser reportada en el corte IV. A su vez, el mínimo de personasModelo Asistencial
    243
    Orientaciones Técnicas Compromisos de Gestión Año 2020
    consultadas debe ser 100) .<br>
    − 3 actividades (1 por corte a partir del corte II) utilizando mecanismos distintos a los
    considerados en el título IV de la ley 18.575 (establecidos en la guía metodológica). Tanto el
    mecanismo como el tema debe ser elegido por el Servicio de Salud.<br>
    <strong>Trabajo con el Consejo de la Sociedad Civil (COSOC):</strong><br>
    − 4 reuniones del COSOC como mínimo (1 por corte La reunión correspondiente al periodo del
    corte I debe ser reportada en el corte II junto a la reunión correspondiente a dicho corte).<br>
    − 2 capacitaciones para fortalecer las competencias de los dirigentes sociales (1 por corte,
    específicamente en los cortes II y III). Considerar para estas capacitaciones como publico
    objetivos a los consejeros pertenecientes al COSOC, CDL y CCU.<br>
    − Acciones para la regularización del Consejo de la Sociedad Civil (sólo en caso de aplicar).<br><br>
    <strong>La planificación de actividades correspondientes al Plan Anual de Participación debe ir en
    concordancia con el diagnostico territorial y objetivos planteados. A su vez, debe contener
    las consideraciones técnicas y los aspectos solicitados según formato Minsal, enviado
    previo a la evaluación del corte.</strong>';
$data17_1[3]['verificacion'] = 'Matriz de Trabajo 2020 (Formato Minsal).';
//DATOS PARA ACCIÓN 1
foreach ($meses as $mes) {
    $data17_1[1]['numeradores'][$mes] = 0;
    $data17_1[1]['denominadores'][$mes] = 0;
}

$data17_1[1]['numeradores'][1] = 11;
$data17_1[1]['numeradores'][2] = 12;
$data17_1[1]['numeradores'][3] = 13;
$data17_1[1]['numerador_acumulado'] = array_sum($data17_1[1]['numeradores']);

$data17_1[1]['denominadores'][1] = 11;
$data17_1[1]['denominadores'][2] = 12;
$data17_1[1]['denominadores'][3] = 13;
$data17_1[1]['denominador_acumulado'] = array_sum($data17_1[1]['denominadores']);

$data17_1[1]['cumplimiento'] = ($data17_1[1]['numerador_acumulado'] /
    $data17_1[1]['denominador_acumulado']) * 100;

$data17_1[1]['calculo'] =
'
Resultado Obtenido                  Porcentaje de Cumplimiento Asignado
Envío Informe según indicaciones                                100,0%
Envío informe incompleto o sin envío                                        0,0%
';
// calculo de cumplimiento
switch ($data17_1[1]['cumplimiento']) {
    case ($data17_1[1]['cumplimiento'] >= 100):
        $data17_1[1]['resultado'] = 100;
        break;
    
    default:
        $data17_1[1]['resultado'] = 0;
}

$data17_1[1]['cumplimientoponderado'] = (($data17_1[1]['resultado'] * $data17_1[1]['ponderacion'])/100);





//DATOS PARA ACCIÓN 2
///ESTE COMGES 17 NO TIENE NUMERADOR DENOMINADOR, SE DESCRIBE NUMERADOR COMO VALOR A SOLICITAR
$data17_1[2]['label']['numerador'] = 'Plantea objetivos del Plan Anual de Participación, en concordancia con el
diagnostico territorial realizado';
$data17_1[2]['label']['denominador'] = 'Número de actividades solicitadas en el periodo t';
$data17_1[2]['meta'] = '100%';

foreach ($meses as $mes) {
    $data17_1[2]['numeradores'][$mes] = 0;
    $data17_1[2]['denominadores'][$mes] = 0;
}
$data17_1[2]['numeradores'][1] = 11;
$data17_1[2]['numeradores'][2] = 12;
$data17_1[2]['numeradores'][3] = 13;
$data17_1[2]['numerador_acumulado'] = array_sum($data17_1[2]['numeradores']);
$data17_1[2]['denominadores'][1] = 11;
$data17_1[2]['denominadores'][2] = 12;
$data17_1[2]['denominadores'][3] = 13;
$data17_1[2]['denominador_acumulado'] = array_sum($data17_1[2]['denominadores']);
$data17_1[2]['cumplimiento'] = ($data17_1[2]['numerador_acumulado'] /
    $data17_1[2]['denominador_acumulado']) * 100;
$data17_1[2]['calculo'] =
'
Resultado                   Porcentaje de Cumplimiento Asignado
Plantea objetivos del Plan Anual de Participación en Concordancia con el diagnostico territorial realizado              100,0%
Planteamiento de objetivos incompleto o sin planteamiento                                                                                       0,0%
';
// calculo de cumplimiento
switch ($data17_1[2]['cumplimiento']) {
    case ($data17_1[2]['cumplimiento'] >= 100):
        $data17_1[2]['resultado'] = 100;
        break;   
    default:
        $data17_1[2]['resultado'] = 0;
}
$data17_1[2]['cumplimientoponderado'] = (($data17_1[2]['resultado'] * $data17_1[2]['ponderacion'])/100);








//DATOS PARA ACCIÓN 3
///ESTE COMGES 17 NO TIENE NUMERADOR DENOMINADOR, SE DESCRIBE NUMERADOR COMO VALOR A SOLICITAR
$data17_1[3]['label']['numerador'] = 'Envío de la Planificación de actividades correspondientes al Plan Anual de Participación';
$data17_1[3]['label']['denominador'] = 'Número de actividades solicitadas en el periodo t';
$data17_1[3]['meta'] = '100%';

foreach ($meses as $mes) {
    $data17_1[3]['numeradores'][$mes] = 0;
    $data17_1[3]['denominadores'][$mes] = 0;
}
$data17_1[3]['numeradores'][1] = 11;
$data17_1[3]['numeradores'][3] = 12;
$data17_1[3]['numeradores'][3] = 13;
$data17_1[3]['numerador_acumulado'] = array_sum($data17_1[3]['numeradores']);
$data17_1[3]['denominadores'][1] = 11;
$data17_1[3]['denominadores'][3] = 12;
$data17_1[3]['denominadores'][3] = 13;
$data17_1[3]['denominador_acumulado'] = array_sum($data17_1[3]['denominadores']);
$data17_1[3]['cumplimiento'] = ($data17_1[3]['numerador_acumulado'] /
    $data17_1[3]['denominador_acumulado']) * 100;
$data17_1[3]['calculo'] =
'
Resultado                  Porcentaje de Cumplimiento Asignado
Envío de la Planificación de actividades correspondientes al Plan Anual de Participación                                100,0%
No envío de la planificación, envío parcial y/o sin cumplir con la metodología de trabajo                                        0,0%
';
// calculo de cumplimiento
switch ($data17_1[3]['cumplimiento']) {
    case ($data17_1[3]['cumplimiento'] >= 100):
        $data17_1[3]['resultado'] = 100;
        break;   
    default:
        $data17_1[3]['resultado'] = 0;
}
$data17_1[3]['cumplimientoponderado'] = (($data17_1[3]['resultado'] * $data17_1[3]['ponderacion'])/100);









 /// DATOS CORTE  % CUMPLIMIENTO
 $data17['cumplimientocorte1'] = $data17_1[1]['cumplimientoponderado'] + $data17_1[2]['cumplimientoponderado'] + $data17_1[3]['cumplimientoponderado'];
 


 $data17_1['cumplimientoponderado'] = $data17_1[1]['cumplimientoponderado'] + $data17_1[2]['cumplimientoponderado'] + $data17_1[3]['cumplimientoponderado'];