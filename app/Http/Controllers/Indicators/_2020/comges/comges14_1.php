<?php
use App\Models\Indicators\SingleParameter;

$meses = array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12);
$corte1 = array(1, 2, 3);
$naccionescorte1 = 4;
$naccionescorte2 = 2;
$naccionescorte3 = 1;
$naccionescorte4 = 3;

/***********  META 14.1 ************/
/* ==== Inicializar variables ==== */
$data14_1 = array();
$data14_1['label']['meta'] = '14.1 Tasa de Donantes Efectivos de Órganos pmp generados por Servicio de Salud por año.';
//PONDERACION GLOBAL Y DE LOS 4 CORTES
$data14_1['ponderacion'] = '4,0%';
$data14_1[1]['anual'] = 15;
$data14_1[2]['anual'] = '25%';
$data14_1[3]['anual'] = '25%';
$data14_1[4]['anual'] = '25%';
//POONDERACCIÓN ACCIONES [N°ACCION]
//$data14_1['meta'] = '100%';





//DATOS PARA INDICADORES ACCIÓN 1
$data14_1[1]['accion'] = 'Envío de informe que contenga:<br>
    1. Tasa de Donantes Efectivos de Órganos generados en el Servicio de Salud en 1° Trimestre
    de 2020.<br>
    2. Nodos Críticos detectados en este corte, para la generación de donantes de órganos en los
    hospitales del SS.<br>
    3. Estrategias implementadas, en este corte como Servicio de Salud, para corregir los nodos
    críticos detectados.';
$data14_1[1]['verificacion'] = 'Envío de informe en formato MINSAL';
$data14_1[1]['meta'] = '100%';
$data14_1[1]['label']['numerador'] = 'Número de informes enviados con la totalidad de contenidos solicitados en el periodo t';
$data14_1[1]['label']['denominador'] = 'Número de informes comprometidos a enviar con la totalidad de contenidos en el periodo t';

foreach ($meses as $mes) {
    $data14_1[1]['numeradores'][$mes] = 0;
    $data14_1[1]['denominadores'][$mes] = 0;
}

$data14_1[1]['numerador_acumulado']=0;
$data14_1[1]['denominador_acumulado']=0;
$base_where = array(['law','Comges'],['year',2020],['indicator',"14.1"],['establishment_id',8]);
foreach ($meses as $mes) {
$value = SingleParameter::where(array_merge($base_where,array(['month',$mes],['position','numerador'])))->first();
if($value) 
{$data14_1[1]['numeradores'][$mes] = $value;
$data14_1[1]['numerador_acumulado'] += $value->value;}
else       $data14_1[1]['numeradores'][$mes] = null;

$value = SingleParameter::where(array_merge($base_where,array(['month',$mes],['position','denominador'])))->first();
if($value) 
{$data14_1[1]['denominadores'][$mes] = $value;
$data14_1[1]['denominador_acumulado'] += $value->value;}
else       $data14_1[1]['denominadores'][$mes] = null;

}

if ($data14_1[1]['denominador_acumulado'] > 0)
$data14_1[1]['cumplimiento'] = ($data14_1[1]['numerador_acumulado'] /  $data14_1[1]['denominador_acumulado']) * 100;
else
$data14_1[1]['cumplimiento'] = 0;


$data14_1[1]['ponderacion'] = 100;

$data14_1[1]['calculo'] =
    '
Resultado                  Porcentaje de Cumplimiento Asignado
x=Envía informe con los contenidos solicitados.                               100,0%
X=Envía informe sin los contenidos solicitados o no envía informe               0,0%                                               0,0%
';
// calculo de cumplimiento
switch ($data14_1[true]) {
    case ($data14_1[1]['cumplimiento'] >= 100):
        $data14_1[1]['resultado'] = 100;
        break;    
    default:
        $data14_1[1]['resultado'] = 0;
}
$data14_1[1]['cumplimientoponderado'] = (($data14_1[1]['resultado'] * $data14_1[1]['ponderacion']) / 100);



$data14_1['cumplimientoponderado'] = $data14_1[1]['cumplimientoponderado'];