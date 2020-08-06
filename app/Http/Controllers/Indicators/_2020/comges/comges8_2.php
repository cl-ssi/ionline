<?php

$meses = array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12);
$corte1 = array(1, 2, 3);
$naccionescorte1 = 4;
$naccionescorte2 = 2;
$naccionescorte3 = 1;
$naccionescorte4 = 3;



/***********  META 8.2 ************/
/* ==== Inicializar variables ==== */
$data8_2 = array();
$data8_2['label']['meta'] = '8.2 Porcentaje de cumplimiento del Índice de Ocupación Dental (IOD) del Servicio de Salud en el periodo';
//PONDERACION GLOBAL Y DE LOS 4 CORTES
$data8_2['ponderacion'] = '2,0%';
$data8_2[1]['anual'] = 25;
$data8_2[2]['anual'] = 25;
$data8_2[3]['anual'] = 25;
$data8_2[4]['anual'] = 25;


//DATOS PARA INDICADORES ACCIÓN 1
$data8_2[1]['accion'] = 'Cumplimiento Índice Ocupación Dental (IOD) en el Servicio de Salud en el periodo.';
$data8_2[1]['iverificacion'] =4;
$data8_2[1]['verificacion'] = 'REM A 09 Sección I</li>
<li>N° de sillones dentales disponibles por Servicio de Salud. Si no envía el N° de sillones
dentales disponibles por establecimiento, se calificará con un 0%';
$data8_2[1]['meta'] = 'IOD >= 0,60';
$data8_2[1]['label']['numerador'] = '{[(Consultas nuevas de especialidad x 0,25) + (Ingresos a tratamiento en la especialidad x 0,5) +
    (Controles de especialidad x 0,5) + (Tiempo entre consultas x Número de semanas periodo t)]';
$data8_2[1]['label']['denominador'] = '(Número de Sillones x 44 x Número de semanas en el periodo t)} x 0,85';

foreach ($meses as $mes) {
    $data8_2[1]['numeradores'][$mes] = 0;
    $data8_2[1]['denominadores'][$mes] = 0;
}

$data8_2[1]['numeradores'][1] = 11;
$data8_2[1]['numeradores'][2] = 12;
$data8_2[1]['numeradores'][3] = 13;
$data8_2[1]['numerador_acumulado'] = array_sum($data8_2[1]['numeradores']);

$data8_2[1]['denominadores'][1] = 11;
$data8_2[1]['denominadores'][2] = 12;
$data8_2[1]['denominadores'][3] = 13;
$data8_2[1]['denominador_acumulado'] = array_sum($data8_2[1]['denominadores']);

$data8_2[1]['cumplimiento'] = ($data8_2[1]['numerador_acumulado'] /
    $data8_2[1]['denominador_acumulado']) * 100;


$data8_2[1]['ponderacion'] = 100;

$data8_2[1]['calculo'] =
    '
Resultado                  Porcentaje de Cumplimiento Asignado
IOD>=0,60                               100,0%
0,55<=X<0,60               75,0%
0,30<=X<0,45               50,0%
0,15<=X<0,30               25,0%
IOD<0,15%                      0,0%

';
// calculo de cumplimiento
switch ($data8_2[1]['cumplimiento']) {
    case ($data8_2[1]['cumplimiento'] >= 0.6):
        $data8_2[1]['resultado'] = 100;
        break;
    case ($data8_2[1]['cumplimiento'] >= 0.45):
        $data8_2[1]['resultado'] = 75;
        break;
    case ($data8_2[1]['cumplimiento'] >= 0.30):
        $data8_2[1]['resultado'] = 50;
        break;
    case ($data8_2[1]['cumplimiento'] >= 0.15):
        $data8_2[1]['resultado'] = 25;
        break;
    default:
        $data8_2[1]['resultado'] = 0;
}
$data8_2[1]['cumplimientoponderado'] = (($data8_2[1]['resultado'] * $data8_2[1]['ponderacion']) / 100);



$data8_2['cumplimientoponderado']  = $data8_2[1]['cumplimientoponderado'];