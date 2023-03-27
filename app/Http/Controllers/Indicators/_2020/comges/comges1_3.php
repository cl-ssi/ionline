<?php

use App\Models\Indicators\SingleParameter;

$meses = array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12);
$corte1 = array(1, 2, 3);
$naccionescorte1 = 4;
$naccionescorte2 = 2;
$naccionescorte3 = 1;
$naccionescorte4 = 3;

/***********  META 1.3 ************/
/* ==== Inicializar variables ==== */
$data1_3 = array();
$data1_3['label']['meta'] = '1.3 Porcentaje de contrarreferencias realizadas al alta de consulta de especialidad.';
//PONDERACION GLOBAL Y DE LOS 4 CORTES
$data1_3['ponderacion'] = '1,333%';
$data1_3[1]['anual'] = 20;
$data1_3[2]['anual'] = 25;
$data1_3[3]['anual'] = 25;
$data1_3[4]['anual'] = 25;


//DATOS PARA INDICADORES ACCIÓN 1
$data1_3[1]['accion'] = 'Si el Servicio de Salud presentó un porcentaje <strong>mayor o igual a un 80,0% a Diciembre de 2019</strong>
de contrarreferencias al alta médica realizadas en el nivel secundario, debe mantenerlo.<br>
Si el Servicio de Salud presentó un porcentaje <strong>menor a un 80,0%</strong> a Diciembre de 2019 de
contrarreferencias al alta médica realizadas en el nivel secundario, deberá aumentar un 10,0%
de la brecha observada en su línea base a diciembre de 2019, para obtener un 80,0%';
$data1_3[1]['iverificacion'] = 1;
$data1_3[1]['verificacion'] = 'Reporte REM A07.</li>
<li>Informe Servicio de Salud con Resultado del indicador.';
$data1_3[1]['meta'] = '>=10%';
$data1_3[1]['label']['numerador'] = '(Porcentaje Contrarreferencias al Alta línea base – Porcentaje Contrarreferencias al Alta periodo t) ';
$data1_3[1]['label']['denominador'] = '(Porcentaje Contrarreferencias al Alta línea base – 80,0%)';

//DATOS PARA ACCIÓN 1
foreach ($meses as $mes) {
    $data1_3[1]['numeradores'][$mes] = 0;
    $data1_3[1]['denominadores'][$mes] = 0;
}

$data1_3[1]['numerador_acumulado']=0;
$data1_3[1]['denominador_acumulado']=0;
$base_where = array(['law','Comges'],['year',2020],['indicator',"1.3"],['establishment_id',8]);
foreach ($meses as $mes) {
$value = SingleParameter::where(array_merge($base_where,array(['month',$mes],['position','numerador'])))->first();
if($value) 
{$data1_3[1]['numeradores'][$mes] = $value;
$data1_3[1]['numerador_acumulado'] += $value->value;}
else       $data1_3[1]['numeradores'][$mes] = null;

$value = SingleParameter::where(array_merge($base_where,array(['month',$mes],['position','denominador'])))->first();
if($value) 
{$data1_3[1]['denominadores'][$mes] = $value;
$data1_3[1]['denominador_acumulado'] += $value->value;}
else       $data1_3[1]['denominadores'][$mes] = null;

}

if ($data1_3[1]['denominador_acumulado'] > 0)
$data1_3[1]['cumplimiento'] = ($data1_3[1]['numerador_acumulado'] /  $data1_3[1]['denominador_acumulado']) * 100;
else
$data1_3[1]['cumplimiento'] = 0;

$data1_3[1]['ponderacion'] = 100;

$data1_3[1]['calculo'] =
    '
Resultado Obtenido Meta Disminución de la Brecha                  Porcentaje de Cumplimiento Asignado
x>=10,0%                                                                        100,0%
9,0%<=X<10,0%                                                                75,0%
8,0%<=X<9,0%                                                                 50,0%
7,0%<=X<8,0%                                                                 25,0%
X<7,0%                                                                              0,0%
';
// calculo de cumplimiento
switch ($data1_3[true]) {
    case ($data1_3[1]['cumplimiento'] >= 10):
        $data1_3[1]['resultado'] = 100;
        break;
    case ($data1_3[1]['cumplimiento'] >= 9):
        $data1_3[1]['resultado'] = 75;
        break;
    case ($data1_3[1]['cumplimiento'] >= 8):
        $data1_3[1]['resultado'] = 50;
        break;
    case ($data1_3[1]['cumplimiento'] >= 7):
        $data1_3[1]['resultado'] = 25;
        break;
    default:
        $data1_3[1]['resultado'] = 0;
}

$data1_3[1]['cumplimientoponderado'] = (($data1_3[1]['resultado'] * $data1_3[1]['ponderacion']) / 100);
