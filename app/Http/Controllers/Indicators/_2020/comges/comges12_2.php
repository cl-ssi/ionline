<?php

$meses = array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12);
$corte1 = array(1, 2, 3);
$naccionescorte1 = 4;
$naccionescorte2 = 2;
$naccionescorte3 = 1;
$naccionescorte4 = 3;


/***********  META 12.2 ************/
/* ==== Inicializar variables ==== */
$data12_2 = array();
$data12_2['label']['meta'] = '12.2 Porcentaje de pacientes con indicación de hospitalización desde la UEH, que acceden a
cama de dotación en menos de 12 horas.';
//PONDERACION GLOBAL Y DE LOS 4 CORTES
$data12_2['ponderacion'] = '1,5%';
$data12_2[1]['anual'] = 25;
$data12_2[2]['anual'] = 25;
$data12_2[3]['anual'] = 25;
$data12_2[4]['anual'] = 25;


//DATOS PARA INDICADORES ACCIÓN 1
$data12_2[1]['accion'] = 'Cálculo del Porcentaje de pacientes con indicación de hospitalización desde UEH, que acceden a
cama de dotación en menos de 12 horas del periodo de enero a marzo.
Para efectos del cálculo de cumplimiento del Servicio de Salud, cada establecimiento es
evaluado de manera indidivual, según la tabla de sensibilidad del indicador. El promedio de los
porcentajes de cumplimiento corresponde al resultado del Servicio de Salud al corte.<br>
<strong>Aplica a establecimientos con UEH que realizan hospitalizaciones adultas y/o pediátricas (se
excluye hospitalización obstétrica).</strong>';
$data12_2[1]['verificacion'] = 'Reporte extraído REM/DEIS';
$data12_2[1]['meta'] = '>=65%';
$data12_2[1]['label']['numerador'] = 'Número Total de Pacientes con indicación de hospitalización que esperan en UEH T’< 12 horas
para acceder a cama de dotación en el periodo t';
$data12_2[1]['label']['denominador'] = 'Número total de pacientes con indicación de
hospitalización en UEH en el periodo t';

foreach ($meses as $mes) {
    $data12_2[1]['numeradores'][$mes] = 0;
    $data12_2[1]['denominadores'][$mes] = 0;
}

$data12_2[1]['numeradores'][1] = 11;
$data12_2[1]['numeradores'][2] = 12;
$data12_2[1]['numeradores'][3] = 13;
$data12_2[1]['numerador_acumulado'] = array_sum($data12_2[1]['numeradores']);

$data12_2[1]['denominadores'][1] = 11;
$data12_2[1]['denominadores'][2] = 12;
$data12_2[1]['denominadores'][3] = 13;
$data12_2[1]['denominador_acumulado'] = array_sum($data12_2[1]['denominadores']);

$data12_2[1]['cumplimiento'] = ($data12_2[1]['numerador_acumulado'] /
    $data12_2[1]['denominador_acumulado']) * 100;


$data12_2[1]['ponderacion'] = 100;

$data12_2[1]['calculo'] =
    '
Resultado                  Porcentaje de Cumplimiento Asignado
x>=65,0%.                               100,0%
60,0%<=X<65,0%                                               75,0%
55,0%<=X<60,0%                                               50,0%
50,0%<=X<55,0%                                               25,0%
X<50,0%                                               0,0%
';
// calculo de cumplimiento
switch ($data12_2[1]['cumplimiento']) {
    case ($data12_2[1]['cumplimiento'] >= 65):
        $data12_2[1]['resultado'] = 100;
        break;
    case ($data12_2[1]['cumplimiento'] >= 60):
        $data12_2[1]['resultado'] = 75;
        break;
    case ($data12_2[1]['cumplimiento'] >= 55):
        $data12_2[1]['resultado'] = 50;
        break;
    case ($data12_2[1]['cumplimiento'] >= 50):
        $data12_2[1]['resultado'] = 25;
        break;
    default:
        $data12_2[1]['resultado'] = 0;
}
$data12_2[1]['cumplimientoponderado'] = (($data12_2[1]['resultado'] * $data12_2[1]['ponderacion']) / 100);


$data12_2['cumplimientoponderado'] = $data12_2[1]['cumplimientoponderado'];