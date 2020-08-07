<?php

$meses = array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12);
$corte1 = array(1, 2, 3);
$naccionescorte1 = 4;
$naccionescorte2 = 2;
$naccionescorte3 = 1;
$naccionescorte4 = 3;

/***********  META 4.1 ************/
/* ==== Inicializar variables ==== */
$data4_1 = array();
$data4_1['label']['meta'] = '4.1 Porcentaje de casos egresados de la lista de espera de consultas nuevas de especialidades médicas con
destino APS en las especialidades de Oftalmología, Ginecología (Climaterio), Otorrinolaringología y
Dermatología, ingresadas con fecha igual o anterior al 31 de diciembre del año 2018.';
//PONDERACION GLOBAL Y DE LOS 4 CORTES
$data4_1['ponderacion'] = '1,0%';
$data4_1[1]['anual'] = 20;
$data4_1[2]['anual'] = 25;
$data4_1[3]['anual'] = 25;
$data4_1[4]['anual'] = 30;
//POONDERACCIÓN ACCIONES [N°ACCION]
//$data4_1['meta'] = '100%';





//DATOS PARA INDICADORES ACCIÓN 1
$data4_1[1]['accion'] = 'Resolución del <strong>10,0%</strong> de su universo total al 31 de diciembre de 2018.';
$data4_1[1]['iverificacion'] = 3;
$data4_1[1]['verificacion'] = 'Reporte SIGTE extraído desde MINSAL.';
$data4_1[1]['meta'] = '>=10%';
$data4_1[1]['label']['numerador'] = 'Número de casos egresados de la lista de espera de consultas nuevas de especialidades
médicas, con destino APS de las especialidades de Oftalmología, Ginecología (Climaterio),
Otorrinolaringología y Dermatología ingresadas con fecha igual o anterior al 31 de diciembre del
año 2018 en el periodo';
$data4_1[1]['label']['denominador'] = 'Número total de casos comprometidos a egresar de la lista de espera de
consultas nuevas de especialidades médicas con destino APS de las especialidades de
Oftalmología, Ginecología (Climaterio), Otorrinolaringología y Dermatología, ingresadas con
fecha igual o anterior al 31 de diciembre del año 2018';

foreach ($meses as $mes) {
    $data4_1[1]['numeradores'][$mes] = 0;
    $data4_1[1]['denominadores'][$mes] = 0;
}

$data4_1[1]['numeradores'][1] = 11;
$data4_1[1]['numeradores'][2] = 12;
$data4_1[1]['numeradores'][3] = 13;
$data4_1[1]['numerador_acumulado'] = array_sum($data4_1[1]['numeradores']);

$data4_1[1]['denominadores'][1] = 11;
$data4_1[1]['denominadores'][2] = 12;
$data4_1[1]['denominadores'][3] = 13;
$data4_1[1]['denominador_acumulado'] = array_sum($data4_1[1]['denominadores']);

$data4_1[1]['cumplimiento'] = ($data4_1[1]['numerador_acumulado'] /
    $data4_1[1]['denominador_acumulado']) * 100;


$data4_1[1]['ponderacion'] = 50;

$data4_1[1]['calculo'] =
    '
Resultado Obtenido                  Porcentaje de Cumplimiento Asignado
x>=10,0%                                       100,0%
7,0%<=X<10,0%                                   75,0%
4,0%<=X<7,0%                                   50,0%
1,0%<=X<4,0%                                   25,0%
X<1,0%                                          0,0%
';
// calculo de cumplimiento
switch ($data4_1[1]['cumplimiento']) {
    case ($data4_1[1]['cumplimiento'] >= 10):
        $data4_1[1]['resultado'] = 100;
        break;
    case ($data4_1[1]['cumplimiento'] >= 7):
        $data4_1[1]['resultado'] = 75;
        break;
    case ($data4_1[1]['cumplimiento'] >= 4):
        $data4_1[1]['resultado'] = 50;
        break;
    case ($data4_1[1]['cumplimiento'] >= 1):
        $data4_1[1]['resultado'] = 25;
        break;
    default:
        $data4_1[1]['resultado'] = 0;
}
$data4_1[1]['cumplimientoponderado'] = (($data4_1[1]['resultado'] * $data4_1[1]['ponderacion']) / 100);






//DATOS PARA INDICADORES ACCIÓN 2
$data4_1[2]['accion'] = 'Resolución del <strong>100,0%</strong> de personas con fecha de ingreso igual y anterior al 31 de diciembre de
2016';
$data4_1[2]['iverificacion'] = 1;
$data4_1[2]['verificacion'] = 'Reporte SIGTE extraído desde MINSAL.';
$data4_1[2]['meta'] = '100%';
$data4_1[2]['label']['numerador'] = 'Número de casos egresados de la lista de espera de consultas nuevas de especialidades
médicas, con destino APS de las especialidades de Oftalmología, Ginecología (Climaterio),
Otorrinolaringología y Dermatología ingresadas con fecha igual o anterior al 31 de diciembre del
año 2016 en el periodo';
$data4_1[2]['label']['denominador'] = 'Número total de casos comprometidos a egresar de la lista de espera de
consultas nuevas de especialidades médicas con destino APS de las especialidades de
Oftalmología, Ginecología (Climaterio), Otorrinolaringología y Dermatología, ingresadas con
fecha igual o anterior al 31 de diciembre del año 2016';

foreach ($meses as $mes) {
    $data4_1[2]['numeradores'][$mes] = 0;
    $data4_1[2]['denominadores'][$mes] = 0;
}

$data4_1[2]['numeradores'][2] = 11;
$data4_1[2]['numeradores'][2] = 12;
$data4_1[2]['numeradores'][3] = 13;
$data4_1[2]['numerador_acumulado'] = array_sum($data4_1[2]['numeradores']);

$data4_1[2]['denominadores'][2] = 11;
$data4_1[2]['denominadores'][2] = 12;
$data4_1[2]['denominadores'][3] = 13;
$data4_1[2]['denominador_acumulado'] = array_sum($data4_1[2]['denominadores']);

$data4_1[2]['cumplimiento'] = ($data4_1[2]['numerador_acumulado'] /
    $data4_1[2]['denominador_acumulado']) * 100;


$data4_1[2]['ponderacion'] = 50;

$data4_1[2]['calculo'] =
    '
Resultado Obtenido                  Porcentaje de Cumplimiento Asignado
x>=100,0%                                       100,0%
90,0%<=X<100,0%                                  75,0%
80,0%<=X<90,0%                                   50,0%
70,0%<=X<80,0%                                   25,0%
X<70,0%                                           0,0%
';
// calculo de cumplimiento
switch ($data4_1[2]['cumplimiento']) {
    case ($data4_1[2]['cumplimiento'] >= 100):
        $data4_1[2]['resultado'] = 100;
        break;
    case ($data4_1[2]['cumplimiento'] >= 90):
        $data4_1[2]['resultado'] = 75;
        break;
    case ($data4_1[2]['cumplimiento'] >= 80):
        $data4_1[2]['resultado'] = 50;
        break;
    case ($data4_1[2]['cumplimiento'] >= 70):
        $data4_1[2]['resultado'] = 25;
        break;
    default:
        $data4_1[2]['resultado'] = 0;
}
$data4_1[2]['cumplimientoponderado'] = (($data4_1[2]['resultado'] * $data4_1[2]['ponderacion']) / 100);






$data4_1['cumplimientoponderado'] = $data4_1[1]['cumplimientoponderado']+ $data4_1[2]['cumplimientoponderado'];