<?php
use App\Models\Indicators\SingleParameter;

$meses = array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12);
$corte1 = array(1, 2, 3);
$naccionescorte1 = 4;
$naccionescorte2 = 2;
$naccionescorte3 = 1;
$naccionescorte4 = 3;

/***********  META 15.3 ************/
/* ==== Inicializar variables ==== */
$data15_3 = array();
$data15_3['label']['meta'] = '15.3 Porcentaje de establecimientos de atención secundaria con prestaciones para personas
con VIH que Implementan el protocolo Ministerial de rescate de personas que abandonan
controles y/o tratamiento antirretroviral, en el periodo.';
//PONDERACION GLOBAL Y DE LOS 4 CORTES
$data15_3['ponderacion'] = '2,0%';
$data15_3[1]['anual'] = 25;
$data15_3[2]['anual'] = '25%';
$data15_3[3]['anual'] = '25%';
$data15_3[4]['anual'] = '25%';



//DATOS PARA INDICADORES ACCIÓN 1 meta 15_3
$data15_3[1]['accion'] = 'Articular y formalizar protocolo de rescate del Servicio de Salud para personas viviendo con
VIH/SIDA que abandonan controles médicos y/o tratamiento antirretroviral, según lineamientos
MINSAL.';
$data15_3[1]['verificacion'] = 'Copia del Ordinario del Director del Servicio de Salud formalizando a la Red el protocolo de
rescate del Servicio de Salud para personas viviendo con VIH/SIDA que abandonan
controles médicos y/o tratamiento antirretroviral.</li>
<li>Copia del protocolo de rescate del Servicio De Salud para personas viviendo con VIH/SIDA
que abandonan controles médicos y/o tratamiento antirretroviral.';
$data15_3[1]['meta'] = '100%';
$data15_3[1]['label']['numerador'] = 'Número de acciones cumplidas para aumentar el rescate de personas viviendo con VIH/SIDA que
abandonan controles médicos y/o tratamiento antirretroviral en el periodo';
$data15_3[1]['label']['denominador'] = ' Número de acciones solicitadas para aumentar el rescate de personas viviendo con VIH/SIDA que abandonan
controles médicos y/o tratamiento antirretroviral en el periodo';

foreach ($meses as $mes) {
    $data15_3[1]['numeradores'][$mes] = 0;
    $data15_3[1]['denominadores'][$mes] = 0;
}

$data15_3[1]['numerador_acumulado']=0;
$data15_3[1]['denominador_acumulado']=0;
$base_where = array(['law','Comges'],['year',2020],['indicator',"15.3"],['establishment_id',8]);
foreach ($meses as $mes) {
$value = SingleParameter::where(array_merge($base_where,array(['month',$mes],['position','numerador'])))->first();
if($value) 
{$data15_3[1]['numeradores'][$mes] = $value;
$data15_3[1]['numerador_acumulado'] += $value->value;}
else       $data15_3[1]['numeradores'][$mes] = null;

$value = SingleParameter::where(array_merge($base_where,array(['month',$mes],['position','denominador'])))->first();
if($value) 
{$data15_3[1]['denominadores'][$mes] = $value;
$data15_3[1]['denominador_acumulado'] += $value->value;}
else       $data15_3[1]['denominadores'][$mes] = null;

}

if ($data15_3[1]['denominador_acumulado'] > 0)
$data15_3[1]['cumplimiento'] = ($data15_3[1]['numerador_acumulado'] /  $data15_3[1]['denominador_acumulado']) * 100;
else
$data15_3[1]['cumplimiento'] = 0;
$data15_3[1]['ponderacion'] = 100;

$data15_3[1]['calculo'] =
    '
Resultado                  Porcentaje de Cumplimiento Asignado
x>=60,0%                                100,0%
55,0<=X<60,0%                                        75,0%
50,0<=X<55,0%                                        50,0%
45,0<=X<50,0%                                        25,0%
X<45,0%                                               0,0%
';
// calculo de cumplimiento
switch ($data15_3[true]) {
    case ($data15_3[1]['cumplimiento'] >= 60):
        $data15_3[1]['resultado'] = 100;
        break;
    case ($data15_3[1]['cumplimiento'] >= 55):
        $data15_3[1]['resultado'] = 75;
        break;
    case ($data15_3[1]['cumplimiento'] >= 50):
        $data15_3[1]['resultado'] = 50;
        break;
    case ($data15_3[1]['cumplimiento'] >= 45):
        $data15_3[1]['resultado'] = 25;
        break;
    default:
        $data15_3[1]['resultado'] = 0;
}
$data15_3[1]['cumplimientoponderado'] = (($data15_3[1]['resultado'] * $data15_3[1]['ponderacion']) / 100);


$data15_3['cumplimientoponderado'] = $data15_3[1]['cumplimientoponderado'];