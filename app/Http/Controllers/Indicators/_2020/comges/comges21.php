<?php

use App\Models\Indicators\SingleParameter;

$meses = array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12);
$corte1 = array(1, 2, 3);

/***********  META 21.1 ************/
/* ==== Inicializar variables ==== */
$data21_1 = array();
$data21_1['label']['meta'] = '21.1 Índice de Ausentismo Laboral.';
$data21_1['label']['numerador'] = 'Número total de días de ausentismo por Licencia Médica Curativa del período de la dotación efectiva, suplencias y reemplazos en el periodo';
$data21_1['label']['denominador'] = ' (Promedio de dotación efectiva + promedio de reemplazos y suplencias en el periodo)';
$data21_1['meta'] = '= 0%';
$data21_1['ponderacion'] = '3,0%';
$data21_1[1]['anual'] = 20;
$data21_1[2]['anual'] = '25%';
$data21_1[2]['anual'] = '25%';
$data21_1[3]['anual'] = '25%';
$data21_1[1]['ponderacion'] = 100;
$data21_1[2]['ponderacion'] = 100;
$data21_1[3]['ponderacion'] = 100;
$data21_1[4]['ponderacion'] = 100;

$data21_1['iaccion'] = '';
$data21_1['faccion'] = '';
$data21_1['naccion'] = '1';


$data21_1[1]['accion'] = 'Evaluación según meta comprometida por el Servicio de Salud al corte.';
$data21_1[1]['verificacion'] = 'Información extraída desde modelo SIRH-Qlikview de Ausentismo al mes de corte.';
/* ==== Inicializar el arreglo de datos $data ==== */
$data21_1['numerador'] = '';
$data21_1['cumplimiento'] = '';


foreach ($meses as $mes) {
    $data21_1['numeradores'][$mes] = 0;
    $data21_1['denominadores'][$mes] = 0;
}

$data21_1['numerador_acumulado']=0;
$data21_1['denominador_acumulado']=0;
$base_where = array(['law','Comges'],['year',2020],['indicator',"21.1"],['establishment_id',8]);
foreach ($meses as $mes) {
$value = SingleParameter::where(array_merge($base_where,array(['month',$mes],['position','numerador'])))->first();
if($value) 
{$data21_1['numeradores'][$mes] = $value;
$data21_1['numerador_acumulado'] += $value->value;}
else       $data21_1['numeradores'][$mes] = null;

$value = SingleParameter::where(array_merge($base_where,array(['month',$mes],['position','denominador'])))->first();
if($value) 
{$data21_1['denominadores'][$mes] = $value;
$data21_1['denominador_acumulado'] += $value->value;}
else       $data21_1['denominadores'][$mes] = null;

}

if ($data21_1['denominador_acumulado'] > 0)
$data21_1['cumplimiento'] = ($data21_1['numerador_acumulado'] /  $data21_1['denominador_acumulado']) * 100;
else
$data21_1['cumplimiento'] = 0;

$data21_1['calculo'] =
'
Resultado Obtenido                  Porcentaje de Cumplimiento Asignado
x<=0,0%                                         100,0%
5,0%>=X>0,0%                                    75,0%
10,0%>=X>5,0%                                   50,0%
15,0%>=X>10,0%                                  25,0%
X>15,0%                                        0,0%
';
// calculo de cumplimiento
switch ($data21_1[true]) {
    case ($data21_1['cumplimiento'] > 15):
        $data21_1['resultado'] = 0;
        break;
    case ($data21_1['cumplimiento'] > 10):
        $data21_1['resultado'] = 25;
        break;
    case ($data21_1['cumplimiento'] > 5):
        $data21_1['resultado'] = 50;
        break;
    case ($data21_1['cumplimiento'] > 0):
            $data21_1['resultado'] = 75;
            break;
    default:
        $data21_1['resultado'] = 100;
}

$data21_1['cumplimientoponderado'] = (($data21_1['resultado'] * $data21_1[1]['ponderacion'])/100);


/***********  META 21.2 ************/
/* ==== Inicializar variables ==== */
$data21_2 = array();
$data21_2['label']['meta'] = '21.2 Porcentaje de acciones implementadas del Plan Central de Abordaje Biopsicosocial del Ausentismo laboral por Licencia Médica Curativa.';
$data21_2['label']['numerador'] = 'N° de actividades ejecutadas del Plan de Ausentismo Establecimiento x a la fecha de corte';
$data21_2['label']['denominador'] = 'N° de Actividades comprometidas del plan de ausentismo del establecimiento x a la fecha de corte';
$data21_2['meta'] = '100%';
$data21_2['ponderacion'] = '1,0';

/* ==== Datos corte 1 ==== */
$data21_2[1][] = '';
$data21_2[1]['accion'] = 'Envío Plan de Trabajo 2020-2022.';
$data21_2[1]['verificacion'] = 'Documento con Plan de Trabajo 2020 - 2022';
$data21_2[1]['ponderacion'] = 100;
$data21_2[1]['anual'] = 20;
foreach ($meses as $mes) {
    $data21_2['numeradores'][$mes] = 0;
    $data21_2['denominadores'][$mes] = 0;
}

$data21_2['numerador_acumulado']=0;
$data21_2['denominador_acumulado']=0;
$base_where = array(['law','Comges'],['year',2020],['indicator',"21.2"],['establishment_id',8]);
foreach ($meses as $mes) {
$value = SingleParameter::where(array_merge($base_where,array(['month',$mes],['position','numerador'])))->first();
if($value) 
{$data21_2['numeradores'][$mes] = $value;
$data21_2['numerador_acumulado'] += $value->value;}
else       $data21_2['numeradores'][$mes] = null;

$value = SingleParameter::where(array_merge($base_where,array(['month',$mes],['position','denominador'])))->first();
if($value) 
{$data21_2['denominadores'][$mes] = $value;
$data21_2['denominador_acumulado'] += $value->value;}
else       $data21_2['denominadores'][$mes] = null;

}

if ($data21_2['denominador_acumulado'] > 0)
$data21_2['cumplimiento'] = ($data21_2['numerador_acumulado'] /  $data21_2['denominador_acumulado']) * 100;
else
$data21_2['cumplimiento'] = 0;

$data21_2['calculo'] =
'
Resultado Obtenido                  Porcentaje de Cumplimiento Asignado
x=100,0%                                100,0%
X<100,0%                                     0,0%
';
// calculo de cumplimiento
switch ($data21_2[true]) {
    case ($data21_2['cumplimiento'] >= 100):
        $data21_2['resultado'] = 100;
        break;    
    default:
        $data21_2['resultado'] = 0;
}

 $data21_2['cumplimientoponderado'] = (($data21_2['resultado'] * $data21_2[1]['ponderacion'])/100);




 /// DATOS CORTE  % CUMPLIMIENTO
 $data21['cumplimientocorte1'] = ($data21_1['cumplimientoponderado'] + $data21_2['cumplimientoponderado'])/2;
 //$data22['cumplimientocorte1'] = 0;

