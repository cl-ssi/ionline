<?php

$meses = array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12);
$corte1 = array(1, 2, 3);
$naccionescorte1 = 4;
$naccionescorte2 = 2;
$naccionescorte3 = 1;
$naccionescorte4 = 3;

/***********  META 7.1 ************/
/* ==== Inicializar variables ==== */
$data7_1 = array();
$data7_1['label']['meta'] = '7.1 Porcentaje de cumplimiento de garantías de oportunidad GES en patologías oncológicas y de
las metas de reducción de tiempos de espera quirúrgicos por problemas de salud oncológicos No
GES en el periodo.';
//PONDERACION GLOBAL Y DE LOS 4 CORTES
$data7_1['ponderacion'] = '2,0%';
$data7_1[1]['anual'] = 20;
$data7_1[2]['anual'] = 25;
$data7_1[3]['anual'] = 25;
$data7_1[4]['anual'] = 25;
//POONDERACCIÓN ACCIONES [N°ACCION]
//$data7_1['meta'] = '100%';





//DATOS PARA INDICADORES ACCIÓN 1
$data7_1[1]['accion'] = 'Resolver el 100,0% de las garantías de oportunidad en problemas de salud oncológicos vigentes
al 31 de marzo de 2020';
$data7_1[1]['iverificacion'] =4;
$data7_1[1]['verificacion'] = 'Reporte de cumplimiento de garantías GES extraído centralizado desde MINSAL';
$data7_1[1]['meta'] = '100%';
$data7_1[1]['label']['numerador'] = 'Número de Garantías Cumplidas + Garantías Exceptuadas + Garantías Incumplidas Atendidas en
el periodo t';
$data7_1[1]['label']['denominador'] = 'Número de Garantías Cumplidas + Garantías Exceptuadas + Garantías Incumplidas
Atendidas + Garatías Incumplidas no Atendidas + Garantías Retrasadas en el periodo t';

foreach ($meses as $mes) {
    $data7_1[1]['numeradores'][$mes] = 0;
    $data7_1[1]['denominadores'][$mes] = 0;
}

$data7_1[1]['numeradores'][1] = 11;
$data7_1[1]['numeradores'][2] = 12;
$data7_1[1]['numeradores'][3] = 13;
$data7_1[1]['numerador_acumulado'] = array_sum($data7_1[1]['numeradores']);

$data7_1[1]['denominadores'][1] = 11;
$data7_1[1]['denominadores'][2] = 12;
$data7_1[1]['denominadores'][3] = 13;
$data7_1[1]['denominador_acumulado'] = array_sum($data7_1[1]['denominadores']);

$data7_1[1]['cumplimiento'] = ($data7_1[1]['numerador_acumulado'] /
    $data7_1[1]['denominador_acumulado']) * 100;


$data7_1[1]['ponderacion'] = 50;

$data7_1[1]['calculo'] =
    '
Resultado                  Porcentaje de Cumplimiento Asignado
x=Envía informe con los contenidos solicitados.                               100,0%
X=Envía informe sin los contenidos solicitados o no envía informe               0,0%                                               0,0%
';
// calculo de cumplimiento
switch ($data7_1[1]['cumplimiento']) {
    case ($data7_1[1]['cumplimiento'] >= 100):
        $data7_1[1]['resultado'] = 100;
        break;
    default:
        $data7_1[1]['resultado'] = 0;
}
$data7_1[1]['cumplimientoponderado'] = (($data7_1[1]['resultado'] * $data7_1[1]['ponderacion']) / 100);


//DATOS PARA INDICADORES ACCIÓN 2
$data7_1[2]['accion'] = 'Lograr que el <strong>18,75%</strong> de los casos en espera de resolución quirúrgica por problemas de salud
oncológicos no GES se encuentren en un <strong>tiempo menor o igual a 30 dias de espera.</strong>';
$data7_1[2]['iverificacion'] =1;
$data7_1[2]['verificacion'] = 'Reporte SIGTE extraído centralizado desde MINSAL';
$data7_1[2]['meta'] = '18,75%';
$data7_1[2]['label']['numerador'] = 'Número de casos oncológicos No GES en lista de espera quirúrgica por un periodo igual o menor
a 30 días en el periodo';
$data7_1[2]['label']['denominador'] = 'Número Total de casos oncológicos No GES en lista de espera quirúrgica
comprometidos en el periodo';

foreach ($meses as $mes) {
    $data7_1[2]['numeradores'][$mes] = 0;
    $data7_1[2]['denominadores'][$mes] = 0;
}

$data7_1[2]['numeradores'][1] = 0;
$data7_1[2]['numeradores'][2] = 0;
$data7_1[2]['numeradores'][3] = 6;
$data7_1[2]['numerador_acumulado'] = array_sum($data7_1[2]['numeradores']);

$data7_1[2]['denominadores'][1] = 11;
$data7_1[2]['denominadores'][2] = 12;
$data7_1[2]['denominadores'][3] = 13;
$data7_1[2]['denominador_acumulado'] = array_sum($data7_1[2]['denominadores']);

$data7_1[2]['cumplimiento'] = ($data7_1[2]['numerador_acumulado'] /
    $data7_1[2]['denominador_acumulado']) * 100;


$data7_1[2]['ponderacion'] = 50;

$data7_1[2]['calculo'] =
    '
Resultado Obtenido Meta Mantención                  Porcentaje de Cumplimiento Asignado
x>= 18,75% ­.                               100,0%
15,0%<=X<18,75%                             76,0%
11,25%<=X<15,0%                             50,0%
7,5%<=X<11,25%                              25,0%
X<7,5%                                       0,0%
';
// calculo de cumplimiento
switch ($data7_1[2]['cumplimiento']) {
    case ($data7_1[2]['cumplimiento'] >= 18):
        $data7_1[2]['resultado'] = 100;
        break;
        case ($data7_1[2]['cumplimiento'] >= 15):
            $data7_1[2]['resultado'] = 75;
            break;
            case ($data7_1[2]['cumplimiento'] >= 11.25):
                $data7_1[2]['resultado'] = 50;
                break;
                case ($data7_1[2]['cumplimiento'] >= 7.5):
                    $data7_1[2]['resultado'] = 25;
                    break;
                    
    default:
        $data7_1[2]['resultado'] = 0;
}
$data7_1[2]['cumplimientoponderado'] = (($data7_1[2]['resultado'] * $data7_1[2]['ponderacion']) / 100);



$data7_1['cumplimientoponderado']  = $data7_1[1]['cumplimientoponderado']+
                                    $data7_1[2]['cumplimientoponderado'];