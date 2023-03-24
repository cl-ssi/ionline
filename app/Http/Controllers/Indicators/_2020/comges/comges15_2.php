<?php
use App\Models\Indicators\SingleParameter;

$meses = array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12);
$corte1 = array(1, 2, 3);
$naccionescorte1 = 4;
$naccionescorte2 = 2;
$naccionescorte3 = 1;
$naccionescorte4 = 3;



/***********  META 15.2 ************/
/* ==== Inicializar variables ==== */
$data15_2 = array();
$data15_2['label']['meta'] = '15.2 Porcentaje de personas viviendo con VIH en control activo que se encuentran en terapia
antirretroviral y con carga viral indetectable en el periodo.';
//PONDERACION GLOBAL Y DE LOS 4 CORTES
$data15_2['ponderacion'] = '2,0%';
$data15_2[1]['anual'] = 25;
$data15_2[2]['anual'] = '25%';
$data15_2[3]['anual'] = '25%';
$data15_2[4]['anual'] = '25%';



//DATOS PARA INDICADORES ACCIÓN 1 meta 15_2
$data15_2[1]['accion'] = 'Alcanzar al menos un <strong>60,0%</strong> de personas con VIH en control activo pertenecientes al Servicio de
Salud que se encuentren en terapia antirretroviral al 31 de marzo del año 2020';
$data15_2[1]['verificacion'] = 'Informe en formato MINSAL con el reporte del Servicio de Salud, que señale el porcentaje de
personas en Terapia Antirretroviral al 31 de marzo del año 2020';
$data15_2[1]['meta'] = '>=60%';
$data15_2[1]['label']['numerador'] = 'Número de personas con VIH en control activo pertenecientes al Servicio de Salud que se
encuentran en terapia antirretroviral en el periodo';
$data15_2[1]['label']['denominador'] = 'Número de personas con VIH en control activo pertenecientes al Servicio de Salud en el periodo';

//DATOS PARA ACCIÓN 1
foreach ($meses as $mes) {
    $data15_2[1]['numeradores'][$mes] = 0;
    $data15_2[1]['denominadores'][$mes] = 0;
}

$data15_2[1]['numerador_acumulado']=0;
$data15_2[1]['denominador_acumulado']=0;
$base_where = array(['law','Comges'],['year',2020],['indicator',"15.21"],['establishment_id',8]);
foreach ($meses as $mes) {
$value = SingleParameter::where(array_merge($base_where,array(['month',$mes],['position','numerador'])))->first();
if($value) 
{$data15_2[1]['numeradores'][$mes] = $value;
$data15_2[1]['numerador_acumulado'] += $value->value;}
else       $data15_2[1]['numeradores'][$mes] = null;

$value = SingleParameter::where(array_merge($base_where,array(['month',$mes],['position','denominador'])))->first();
if($value) 
{$data15_2[1]['denominadores'][$mes] = $value;
$data15_2[1]['denominador_acumulado'] += $value->value;}
else       $data15_2[1]['denominadores'][$mes] = null;

}

if ($data15_2[1]['denominador_acumulado'] > 0)
$data15_2[1]['cumplimiento'] = ($data15_2[1]['numerador_acumulado'] /  $data15_2[1]['denominador_acumulado']) * 100;
else
$data15_2[1]['cumplimiento'] = 0;


$data15_2[1]['ponderacion'] = 50;

$data15_2[1]['calculo'] =
    '
Resultado                  Porcentaje de Cumplimiento Asignado
x>=60,0%                                100,0%
55,0<=X<60,0%                                        75,0%
50,0<=X<55,0%                                        50,0%
45,0<=X<50,0%                                        25,0%
X<45,0%                                               0,0%
';
// calculo de cumplimiento
switch ($data15_2[true]) {
    case ($data15_2[1]['cumplimiento'] >= 60):
        $data15_2[1]['resultado'] = 100;
        break;
    case ($data15_2[1]['cumplimiento'] >= 55):
        $data15_2[1]['resultado'] = 75;
        break;
    case ($data15_2[1]['cumplimiento'] >= 50):
        $data15_2[1]['resultado'] = 50;
        break;
    case ($data15_2[1]['cumplimiento'] >= 45):
        $data15_2[1]['resultado'] = 25;
        break;
    default:
        $data15_2[1]['resultado'] = 0;
}

$data15_2[1]['cumplimientoponderado'] = (($data15_2[1]['resultado'] * $data15_2[1]['ponderacion']) / 100);






//DATOS PARA INDICADORES ACCIÓN 2 meta 15_2
$data15_2[2]['accion'] = 'Alcanzar al menos un <strong>60,0%</strong> de personas con VIH en control activo pertenecientes al Servicio de
Salud que se encuentran en terapia antirretroviral con carga viral indetectable al 31 de marzo
del año 2020.';
$data15_2[2]['verificacion'] = 'Informe en formato MINSAL con el reporte del Servicio de Salud, que señale el porcentaje de
personas en Terapia Antirretroviral ga viral indetectable, al 31 de marzo del año 2020';
$data15_2[2]['meta'] = '>=60%';
$data15_2[2]['label']['numerador'] = 'Número de personas con VIH en control activo pertenecientes al Servicio de Salud que se
encuentran en terapia antirretroviral con carga viral indetectable en el periodo';
$data15_2[2]['label']['denominador'] = 'Número de personas con VIH en control activo pertenecientes al Servicio de Salud que se encuentran en
terapia antirretroviral en el periodo';

//DATOS PARA ACCIÓN 2
foreach ($meses as $mes) {
    $data15_2[2]['numeradores'][$mes] = 0;
    $data15_2[2]['denominadores'][$mes] = 0;
}

$data15_2[2]['numerador_acumulado']=0;
$data15_2[2]['denominador_acumulado']=0;
$base_where = array(['law','Comges'],['year',2020],['indicator',"15.22"],['establishment_id',8]);
foreach ($meses as $mes) {
$value = SingleParameter::where(array_merge($base_where,array(['month',$mes],['position','numerador'])))->first();
if($value) 
{$data15_2[2]['numeradores'][$mes] = $value;
$data15_2[2]['numerador_acumulado'] += $value->value;}
else       $data15_2[2]['numeradores'][$mes] = null;

$value = SingleParameter::where(array_merge($base_where,array(['month',$mes],['position','denominador'])))->first();
if($value) 
{$data15_2[2]['denominadores'][$mes] = $value;
$data15_2[2]['denominador_acumulado'] += $value->value;}
else       $data15_2[2]['denominadores'][$mes] = null;

}

if ($data15_2[2]['denominador_acumulado'] > 0)
$data15_2[2]['cumplimiento'] = ($data15_2[2]['numerador_acumulado'] /  $data15_2[2]['denominador_acumulado']) * 100;
else
$data15_2[2]['cumplimiento'] = 0;


$data15_2[2]['ponderacion'] = 50;

$data15_2[2]['calculo'] =
    '
Resultado                  Porcentaje de Cumplimiento Asignado
x>=60,0%                                100,0%
55,0<=X<60,0%                                        75,0%
50,0<=X<55,0%                                        50,0%
45,0<=X<50,0%                                        25,0%
X<45,0%                                               0,0%
';
// calculo de cumplimiento
switch ($data15_2[true]) {
    case ($data15_2[2]['cumplimiento'] >= 60):
        $data15_2[2]['resultado'] = 100;
        break;
    case ($data15_2[2]['cumplimiento'] >= 55):
        $data15_2[2]['resultado'] = 75;
        break;
    case ($data15_2[2]['cumplimiento'] >= 50):
        $data15_2[2]['resultado'] = 50;
        break;
    case ($data15_2[2]['cumplimiento'] >= 45):
        $data15_2[2]['resultado'] = 25;
        break;
    default:
        $data15_2[2]['resultado'] = 0;
}

$data15_2[2]['cumplimientoponderado'] = (($data15_2[2]['resultado'] * $data15_2[2]['ponderacion']) / 100);



$data15_2['cumplimientoponderado'] = $data15_2[1]['cumplimientoponderado']+$data15_2[2]['cumplimientoponderado'];