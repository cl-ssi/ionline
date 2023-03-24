<?php
use App\Models\Indicators\SingleParameter;

$meses = array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12);
$corte1 = array(1, 2, 3);
$naccionescorte1 = 4;
$naccionescorte2 = 2;
$naccionescorte3 = 1;
$naccionescorte4 = 3;

/***********  META 6.1 ************/
/* ==== Inicializar variables ==== */
$data6_1 = array();
$data6_1['label']['meta'] = '6.1 Porcentaje de utilización de la oferta del Programa de Reforzamiento Odontológico de
Atención Primaria de Salud (PRAPS) en la atención de casos de Lista de Espera de Consultas Nuevas
en las Especialidades Odontológicas de Prótesis Removible, Endodoncia y Periodoncia, ingresadas
al 2020';
//PONDERACION GLOBAL Y DE LOS 4 CORTES
$data6_1['ponderacion'] = '1,0%';
$data6_1[1]['anual'] = 20;
$data6_1[2]['anual'] = 25;
$data6_1[3]['anual'] = 25;
$data6_1[4]['anual'] = 30;
//POONDERACCIÓN ACCIONES [N°ACCION]
//$data6_1['meta'] = '100%';





//DATOS PARA INDICADORES ACCIÓN 1
$data6_1[1]['accion'] = 'Levantamiento de la oferta de Programas de Reforzamiento Odontológicos en la Atención
Primaria de Salud y listado de casos de Lista de Espera por Consulta Nueva de Especialidad
Odontológica de Prótesis Removible, Endodoncia y Periodoncia con fecha de corte al 31 de
marzo de 2020.';
$data6_1[1]['iverificacion'] = 5;
$data6_1[1]['verificacion'] = ' Ordinario del director del Servicio de Salud donde se indique la oferta de canastas PRAPS por
establecimiento (con nombre actual y código DEIS).';
$data6_1[1]['meta'] = '100%';
$data6_1[1]['label']['numerador'] = 'Número de actividades realizadas en el periodo t';
$data6_1[1]['label']['denominador'] = 'Número de actividades solicitadas en el periodo t';

//DATOS PARA ACCIÓN 1
foreach ($meses as $mes) {
    $data6_1[1]['numeradores'][$mes] = 0;
    $data6_1[1]['denominadores'][$mes] = 0;
}

$data6_1[1]['numerador_acumulado']=0;
$data6_1[1]['denominador_acumulado']=0;
$base_where = array(['law','Comges'],['year',2020],['indicator',"6.1"],['establishment_id',8]);
foreach ($meses as $mes) {
$value = SingleParameter::where(array_merge($base_where,array(['month',$mes],['position','numerador'])))->first();
if($value) 
{$data6_1[1]['numeradores'][$mes] = $value;
$data6_1[1]['numerador_acumulado'] += $value->value;}
else       $data6_1[1]['numeradores'][$mes] = null;

$value = SingleParameter::where(array_merge($base_where,array(['month',$mes],['position','denominador'])))->first();
if($value) 
{$data6_1[1]['denominadores'][$mes] = $value;
$data6_1[1]['denominador_acumulado'] += $value->value;}
else       $data6_1[1]['denominadores'][$mes] = null;

}
if ($data6_1[1]['denominador_acumulado'] > 0)
$data6_1[1]['cumplimiento'] = ($data6_1[1]['numerador_acumulado'] /  $data6_1[1]['denominador_acumulado']) * 100;
else
$data6_1[1]['cumplimiento'] = 0;
$data6_1[1]['ponderacion'] = 100;
$data6_1[1]['calculo'] =
    '
Resultado                  Porcentaje de Cumplimiento Asignado
x=100,0%                               100,0%
X<100,0%                                   0%
';
// calculo de cumplimiento
switch ($data6_1[true]) {
    case ($data6_1[1]['cumplimiento'] >= 100):
        $data6_1[1]['resultado'] = 100;
        break;
    default:
        $data6_1[1]['resultado'] = 0;
}
$data6_1[1]['cumplimientoponderado'] = (($data6_1[1]['resultado'] * $data6_1[1]['ponderacion']) / 100);




$data6_1['cumplimientoponderado']  = $data6_1[1]['cumplimientoponderado'];