<?php

$meses = array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12);
$corte1 = array(1, 2, 3);
$naccionescorte1 = 4;
$naccionescorte2 = 2;
$naccionescorte3 = 1;
$naccionescorte4 = 3;



/***********  META 12.3 ************/
/* ==== Inicializar variables ==== */
$data12_3 = array();
$data12_3['label']['meta'] = '12.3 Porcentaje de Egresos con Estadía Prolongada Superior';
//PONDERACION GLOBAL Y DE LOS 4 CORTES
$data12_3['ponderacion'] = '1,0%';
$data12_3[1]['anual'] = 25;
$data12_3[2]['anual'] = 25;
$data12_3[3]['anual'] = 25;
$data12_3[4]['anual'] = 25;


//DATOS PARA INDICADORES ACCIÓN 1
$data12_3[1]['accion'] = 'Cálculo del Porcentaje de egresos con estadías prolongadas del periodo de enero a marzo.<br>
<strong>Exclusiones:</strong><br>
− De la especialidad de Psiquiatría (adultos, adolescentes e infantil).<br>
− Pacientes judicializados código diagnóstico CIE10 Z65.3 Problemas relacionados con otras
circunstancias legales (arresto, custodia de niño o procedimiento de amparo, juicio, litigio).<br>
− Casos socio-sanitarios.<br>
− Casos rehabilitación.';
$data12_3[1]['verificacion'] = 'Reporte extraído desde MINSAL';
$data12_3[1]['meta'] = '<=5,6%';
$data12_3[1]['label']['numerador'] = 'Número de egresos con estadías prolongadas en el período t';
$data12_3[1]['label']['denominador'] = 'Total de egresos codificados en el período t';

foreach ($meses as $mes) {
    $data12_3[1]['numeradores'][$mes] = 0;
    $data12_3[1]['denominadores'][$mes] = 0;
}

$data12_3[1]['numeradores'][1] = 11;
$data12_3[1]['numeradores'][2] = 12;
$data12_3[1]['numeradores'][3] = 13;
$data12_3[1]['numerador_acumulado'] = array_sum($data12_3[1]['numeradores']);

$data12_3[1]['denominadores'][1] = 11;
$data12_3[1]['denominadores'][2] = 12;
$data12_3[1]['denominadores'][3] = 13;
$data12_3[1]['denominador_acumulado'] = array_sum($data12_3[1]['denominadores']);

$data12_3[1]['cumplimiento'] = ($data12_3[1]['numerador_acumulado'] /
    $data12_3[1]['denominador_acumulado']) * 100;


$data12_3[1]['ponderacion'] = 100;

$data12_3[1]['calculo'] =
    '
Resultado                  Porcentaje de Cumplimiento Asignado
x<=5,6%.                               100,0%
5,9%>=X>5,6%                                               75,0%
6,2%>=X>5,9%                                               50,0%
6,5%>=X>6,2%                                               25,0%
X>6,5%                                               0,0%
';
// calculo de cumplimiento
switch ($data12_3[1]['cumplimiento']) {
    case ($data12_3[1]['cumplimiento'] <= 5.6):
        $data12_3[1]['resultado'] = 100;
        break;
    case ($data12_3[1]['cumplimiento'] <= 5.9):
        $data12_3[1]['resultado'] = 75;
        break;
    case ($data12_3[1]['cumplimiento'] <= 6.2):
        $data12_3[1]['resultado'] = 50;
        break;
    case ($data12_3[1]['cumplimiento'] <= 6.5):
        $data12_3[1]['resultado'] = 25;
        break;
    default:
        $data12_3[1]['resultado'] = 0;
}
$data12_3[1]['cumplimientoponderado'] = (($data12_3[1]['resultado'] * $data12_3[1]['ponderacion']) / 100);



$data12_3['cumplimientoponderado'] =$data12_3[1]['cumplimientoponderado'];
