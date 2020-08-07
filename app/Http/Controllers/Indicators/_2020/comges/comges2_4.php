<?php

$meses = array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12);
$corte1 = array(1, 2, 3);
$naccionescorte1 = 4;
$naccionescorte2 = 2;
$naccionescorte3 = 1;
$naccionescorte4 = 3;

/***********  META 2.4 ************/
/* ==== Inicializar variables ==== */
$data2_4 = array();
$data2_4['label']['meta'] = '2.4 Porcentaje de cumplimiento de la programación de horas de consultas nuevas, tratamientos
y procedimientos imagenológicos realizados por profesionales Cirujanos Dentistas especialistas.';
//PONDERACION GLOBAL Y DE LOS 4 CORTES
$data2_4['ponderacion'] = '1,0%';
$data2_4[1]['anual'] = 20;
$data2_4[2]['anual'] = 25;
$data2_4[3]['anual'] = 25;
$data2_4[4]['anual'] = 25;


//DATOS PARA INDICADORES ACCIÓN 1
$data2_4[1]['accion'] = 'Contar con proceso de programación 2020 actualizado con la totalidad de horas contratadas de
los profesionales Cirujanos Dentistas que ejecutan prestaciones de especialidad (reprogramación
si es requerido por el Servicio de Salud o establecimientos) y validado de acuerdo a plantilla de
RRHH según SIRH, emitida desde DIGEDEP.';
$data2_4[1]['iverificacion'] = 1;
$data2_4[1]['verificacion'] = 'Planilla Excel con Consolidado de Programación Odontológica año 2020 con la totalidad de
horas contratadas, programadas y validada de acuerdo a plantilla de RRHH emitida por
DIGEDEP.</li>
<li>Planilla Excel con Consolidado de Programación de Procedimientos Imagenológicos año 2020
con la totalidad de horas contratadas, programadas y validada de acuerdo a plantilla de RRHH
emitida por DIGEDEP.</li>
<li>Planilla Excel con ausentismo legal efectivo período enero- marzo (feriado legal,
administrativos, capacitaciones, lactancia materna) por cada profesional programado,
validado por RRHH.</li>';
$data2_4[1]['meta'] = '100%';
$data2_4[1]['label']['numerador'] = 'Número total de programaciones validadas comprometidas en el periodo t';
$data2_4[1]['label']['denominador'] = 'Número total de programaciones validadas solicitadas en el periodo t';

foreach ($meses as $mes) {
    $data2_4[1]['numeradores'][$mes] = 0;
    $data2_4[1]['denominadores'][$mes] = 0;
}

$data2_4[1]['numeradores'][1] = 11;
$data2_4[1]['numeradores'][2] = 12;
$data2_4[1]['numeradores'][3] = 13;
$data2_4[1]['numerador_acumulado'] = array_sum($data2_4[1]['numeradores']);

$data2_4[1]['denominadores'][1] = 11;
$data2_4[1]['denominadores'][2] = 12;
$data2_4[1]['denominadores'][3] = 13;
$data2_4[1]['denominador_acumulado'] = array_sum($data2_4[1]['denominadores']);

$data2_4[1]['cumplimiento'] = ($data2_4[1]['numerador_acumulado'] /
    $data2_4[1]['denominador_acumulado']) * 100;


$data2_4[1]['ponderacion'] = 20;

$data2_4[1]['calculo'] =
    '
Resultado Obtenido                   Porcentaje de Cumplimiento Asignado
X=100,0%                                      100,0%
X<100,0%                                         0,0%
';
// calculo de cumplimiento
switch ($data2_4[1]['cumplimiento']) {
    case ($data2_4[1]['cumplimiento'] >= 100):
        $data2_4[1]['resultado'] = 100;
        break;
    default:
        $data2_4[1]['resultado'] = 0;
}

$data2_4[1]['cumplimientoponderado'] = (($data2_4[1]['resultado'] * $data2_4[1]['ponderacion']) / 100);


//DATOS PARA INDICADORES ACCIÓN 2
$data2_4[2]['accion'] = 'Cumplimiento mayor o igual a 95% de consultas nuevas tratamientos y procedimientos
imagenológicos de Especialidades Odontológicas realizadas por profesional Cirujano Dentista
programados en los establecimientos de baja, mediana y alta complejidad en el período eneromarzo.';
$data2_4[2]['iverificacion'] = 1;
$data2_4[2]['verificacion'] = '. Planilla Excel de Evaluación con el cumplimiento de acuerdo al denominador validado por
Servicio de Salud, correspondiente al período enero – marzo 2020.</li>
<li> Reporte REM A09 sección F, sección F.1 y sección I.';
$data2_4[2]['meta'] = '>=95%';
$data2_4[2]['label']['numerador'] = 'Número total de consultas nuevas, tratamientos y procedimientos imagenológicos de
especialidades odontológicas, realizadas por profesional Cirujano Dentista en el período t';
$data2_4[2]['label']['denominador'] = 'Número total de consultas nuevas, tratamientos y procedimientos imagenológicos de especialidades odontológicas programadas por profesional Cirujano Dentista en el período t';

foreach ($meses as $mes) {
    $data2_4[2]['numeradores'][$mes] = 0;
    $data2_4[2]['denominadores'][$mes] = 0;
}

$data2_4[2]['numeradores'][1] = 11;
$data2_4[2]['numeradores'][2] = 12;
$data2_4[2]['numeradores'][3] = 13;
$data2_4[2]['numerador_acumulado'] = array_sum($data2_4[2]['numeradores']);

$data2_4[2]['denominadores'][1] = 11;
$data2_4[2]['denominadores'][2] = 12;
$data2_4[2]['denominadores'][3] = 13;
$data2_4[2]['denominador_acumulado'] = array_sum($data2_4[2]['denominadores']);

$data2_4[2]['cumplimiento'] = ($data2_4[2]['numerador_acumulado'] /
    $data2_4[2]['denominador_acumulado']) * 100;


$data2_4[2]['ponderacion'] = 80;

$data2_4[2]['calculo'] =
    '
Resultado Obtenido                   Porcentaje de Cumplimiento Asignado
X>=95,0%                                       100,0%
90,0%<=X<95,0%                                  75,0%
85,0%<=X<90,0%                                  50,0%
80,0%<=X<85,0%                                  25,0%
X<80,0%                                          0,0%
';
// calculo de cumplimiento
switch ($data2_4[2]['cumplimiento']) {
    case ($data2_4[2]['cumplimiento'] >= 95):
        $data2_4[2]['resultado'] = 100;
        break;
    case ($data2_4[2]['cumplimiento'] >= 90):
        $data2_4[2]['resultado'] = 75;
        break;
    case ($data2_4[2]['cumplimiento'] >= 85):
        $data2_4[2]['resultado'] = 50;
        break;
    case ($data2_4[2]['cumplimiento'] >= 80):
        $data2_4[2]['resultado'] = 25;
        break;
    default:
        $data2_4[2]['resultado'] = 0;
}
$data2_4[2]['cumplimientoponderado'] = (($data2_4[2]['resultado'] * $data2_4[2]['ponderacion']) / 100);




$data2_4['cumplimientoponderado'] = $data2_4[1]['cumplimientoponderado']+$data2_4[2]['cumplimientoponderado'];