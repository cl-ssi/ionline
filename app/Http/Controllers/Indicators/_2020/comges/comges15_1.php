<?php
use App\Models\Indicators\SingleParameter;

$meses = array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12);
$corte1 = array(1, 2, 3);
$naccionescorte1 = 4;
$naccionescorte2 = 2;
$naccionescorte3 = 1;
$naccionescorte4 = 3;

/***********  META 15.1 ************/
/* ==== Inicializar variables ==== */
$data15_1 = array();
$data15_1['label']['meta'] = '15.1 Porcentaje de Centros de Salud Familiar con protocolo de atención de Test visual/rápido
para VIH en el periodo.';
//PONDERACION GLOBAL Y DE LOS 4 CORTES
$data15_1['ponderacion'] = '1,0%';
$data15_1[1]['anual'] = 25;
$data15_1[2]['anual'] = '25%';
$data15_1[3]['anual'] = '25%';
$data15_1[4]['anual'] = '25%';
//POONDERACCIÓN ACCIONES [N°ACCION]
//$data15_1['meta'] = '100%';





//DATOS PARA INDICADORES ACCIÓN 1
$data15_1[1]['accion'] = 'Alcanzar un <strong>25,0%</strong> de Centros de Salud Familiar del Servicio de Salud con protocolo de atención
de Test visual/rápido de VIH al 31 de marzo del año 2020.';
$data15_1[1]['verificacion'] = '. Informe en formato MINSAL con el reporte del total de Centros de Salud Familiar del Servicio
de Salud con protocolo de atención de Test visual/rápido de VIH disponible al 31 de marzo
del año 2020';
$data15_1[1]['meta'] = '>=25%';
$data15_1[1]['label']['numerador'] = 'Número total de Centros de Salud Familiar del Servicio de Salud con protocolo de atención de Test
visual-rápido de VIH en el periodo t';
$data15_1[1]['label']['denominador'] = 'Número total de Centros de Salud Familiar del Servicio de Salud';
$data15_1[1]['ponderacion'] = 100;

//DATOS PARA ACCIÓN 1
foreach ($meses as $mes) {
    $data15_1[1]['numeradores'][$mes] = 0;
    $data15_1[1]['denominadores'][$mes] = 0;
}

$data15_1[1]['numerador_acumulado']=0;
$data15_1[1]['denominador_acumulado']=0;
$base_where = array(['law','Comges'],['year',2020],['indicator',"15.1"],['establishment_id',8]);
foreach ($meses as $mes) {
$value = SingleParameter::where(array_merge($base_where,array(['month',$mes],['position','numerador'])))->first();
if($value) 
{$data15_1[1]['numeradores'][$mes] = $value;
$data15_1[1]['numerador_acumulado'] += $value->value;}
else       $data15_1[1]['numeradores'][$mes] = null;

$value = SingleParameter::where(array_merge($base_where,array(['month',$mes],['position','denominador'])))->first();
if($value) 
{$data15_1[1]['denominadores'][$mes] = $value;
$data15_1[1]['denominador_acumulado'] += $value->value;}
else       $data15_1[1]['denominadores'][$mes] = null;

}

if ($data15_1[1]['denominador_acumulado'] > 0)
$data15_1[1]['cumplimiento'] = ($data15_1[1]['numerador_acumulado'] /  $data15_1[1]['denominador_acumulado']) * 100;
else
$data15_1[1]['cumplimiento'] = 0;

$data15_1[1]['calculo'] =
    '
Resultado                  Porcentaje de Cumplimiento Asignado
x>=25,0%                                100,0%
20,0<=X<25,0%                                        75,0%
15,0<=X<20,0%                                        50,0%
10,0<=X<15,0%                                        25,0%
X<10,0%                                               0,0%
';
// calculo de cumplimiento
switch ($data15_1[true]) {
    case ($data15_1[1]['cumplimiento'] >= 25):
        $data15_1[1]['resultado'] = 100;
        break;
    case ($data15_1[1]['cumplimiento'] >= 20):
        $data15_1[1]['resultado'] = 75;
        break;
    case ($data15_1[1]['cumplimiento'] >= 15):
        $data15_1[1]['resultado'] = 50;
        break;
    case ($data15_1[1]['cumplimiento'] >= 10):
        $data15_1[1]['resultado'] = 25;
        break;
    default:
        $data15_1[1]['resultado'] = 0;
}
$data15_1[1]['cumplimientoponderado'] = (($data15_1[1]['resultado'] * $data15_1[1]['ponderacion']) / 100);

$data15_1['cumplimientoponderado'] = $data15_1[1]['cumplimientoponderado'];
