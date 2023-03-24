<?php

use App\Models\Indicators\SingleParameter;


$meses = array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12);
$corte1 = array(1, 2, 3);

/***********  META 25.1 ************/
/* ==== Inicializar variables ==== */
$data25_1 = array();
$data25_1['label']['meta'] = '25.1 Porcentaje de cumplimiento de compras en cantidad de medicamentos de la Canasta Esencial de medicamentos a través de intermediación CENABAST.';
$data25_1['label']['numerador'] = 'Cantidad de medicamentos de la Canasta CEM comprados a través de CENABAST';
$data25_1['label']['denominador'] = ' Cantidad total de medicamentos de la Canasta CEM comprados por el Servicio de Salud';
$data25_1['meta'] = '80%';
$data25_1['ponderacion'] = '0%';
$data25_1[1]['anual'] = 25;
$data25_1[2]['anual'] = '25%';
$data25_1[2]['anual'] = '25%';
$data25_1[3]['anual'] = '25%';
$data25_1[1]['ponderacion'] = 100;
$data25_1[2]['ponderacion'] = 100;
$data25_1[3]['ponderacion'] = 100;
$data25_1[4]['ponderacion'] = 100;

$data25_1['iaccion'] = '';
$data25_1['faccion'] = '';
$data25_1['naccion'] = '1';


$data25_1[1]['accion'] = 'Cumplimiento mayor o igual a un <strong>80,0%</strong> en cantidad de medicamentos de la Canasta CEM
comprados a través de CENABAST';
$data25_1[1]['verificacion'] = 'Informe de Cumplimiento que la Central de Abastecimiento carga mensualmente en el
observatorio de la página web de CENABAST, <a href="https://www.cenabast.cl/" target="_blank">www.cenabast.cl</a> </li>
<li> Sistema de información Canasta Esencial de Medicamento (SICEM).';
/* ==== Inicializar el arreglo de datos $data ==== */
$data25_1['numerador'] = '';
$data25_1['cumplimiento'] = '';


foreach ($meses as $mes) {
    $data25_1['numeradores'][$mes] = 0;
    $data25_1['denominadores'][$mes] = 0;
}



$data25_1['numerador_acumulado']=0;
$data25_1['denominador_acumulado']=0;
$base_where = array(['law','Comges'],['year',2020],['indicator',"25.1"],['establishment_id',8]);
foreach ($meses as $mes) {
$value = SingleParameter::where(array_merge($base_where,array(['month',$mes],['position','numerador'])))->first();
if($value) 
{$data25_1['numeradores'][$mes] = $value;
$data25_1['numerador_acumulado'] += $value->value;}
else       $data25_1['numeradores'][$mes] = null;

$value = SingleParameter::where(array_merge($base_where,array(['month',$mes],['position','denominador'])))->first();
if($value) 
{$data25_1['denominadores'][$mes] = $value;
$data25_1['denominador_acumulado'] += $value->value;}
else       $data25_1['denominadores'][$mes] = null;

}

if ($data25_1['denominador_acumulado'] > 0)
$data25_1['cumplimiento'] = ($data25_1['numerador_acumulado'] /  $data25_1['denominador_acumulado']) * 100;
else
$data25_1['cumplimiento'] = 0;

$data25_1['calculo'] =
'
Resultado Obtenido                  Porcentaje de Cumplimiento Asignado
x>=80,0%                                100,0%
75,0%<=X<80,0%                      75,0%
70,0%<=X<75,0%                      50,0%
65,0%<=X<70,0%                      25,0%
X<65,0%                                        0,0%
';
// calculo de cumplimiento
switch (true) {
    case ($data25_1['cumplimiento'] >= 80):
        $data25_1['resultado'] = 100;
        break;
    case ($data25_1['cumplimiento'] >= 75):
        $data25_1['resultado'] = 75;
        break;
    case ($data25_1['cumplimiento'] >= 70):
        $data25_1['resultado'] = 50;
        break;
    case ($data25_1['cumplimiento'] >= 65):
        $data25_1['resultado'] = 25;
        break;    
    default:
        $data25_1['resultado'] = 0;
}

$data25_1['cumplimientoponderado'] = (($data25_1['resultado'] * $data25_1[1]['ponderacion'])/100);

// foreach($meses as $mes) {
//     $data25_1['numeradores'][$mes] = 0;
//     $data25_2['denominadores'][$mes] = 0;
// }


/***********  META 25.2 ************/
/* ==== Inicializar variables ==== */
$data25_2 = array();
$data25_2['label']['meta'] = '25.2 Porcentaje de cumplimiento de compras en monto de la Canasta Esencial de medicamentos a través de intermediación CENABAST.';
$data25_2['label']['numerador'] = 'Monto total de medicamentos de la Canasta CEM comprados por el Servicio de Salud a través
de CENABAST';
$data25_2['label']['denominador'] = 'Monto total de medicamentos de la Canasta CEM comprados por el Servicio de
Salud';
$data25_2['meta'] = '60%';
$data25_2['ponderacion'] = '0';

/* ==== Datos corte 1 ==== */
$data25_1[1][] = '';
$data25_2[1]['accion'] = 'Cumplimiento mayor o igual a un <strong>60,0%</strong> del monto total de medicamentos de la Canasta CEM
comprados por el Servicio de Salud a través de CENABAST del periodo de enero a marzo';
$data25_2[1]['verificacion'] = 'Informe de Cumplimiento que la Central de Abastecimiento carga mensualmente en el
observatorio de la página web de CENABAST, <a href="https://www.cenabast.cl/" target="_blank">www.cenabast.cl</a> </li>
<li> Sistema de información Canasta Esencial de Medicamento (SICEM).';
$data25_2[1]['ponderacion'] = 100;
$data25_2[1]['anual'] = 25;
foreach ($meses as $mes) {
    $data25_2['numeradores'][$mes] = 0;
    $data25_2['denominadores'][$mes] = 0;
}

$data25_2['numerador_acumulado']=0;
$data25_2['denominador_acumulado']=0;
$base_where = array(['law','Comges'],['year',2020],['indicator',"25.2"],['establishment_id',8]);
foreach ($meses as $mes) {
$value = SingleParameter::where(array_merge($base_where,array(['month',$mes],['position','numerador'])))->first();
if($value) 
{$data25_2['numeradores'][$mes] = $value;
$data25_2['numerador_acumulado'] += $value->value;}
else       $data25_2['numeradores'][$mes] = null;

$value = SingleParameter::where(array_merge($base_where,array(['month',$mes],['position','denominador'])))->first();
if($value) 
{$data25_2['denominadores'][$mes] = $value;
$data25_2['denominador_acumulado'] += $value->value;}
else       $data25_2['denominadores'][$mes] = null;

}

if ($data25_2['denominador_acumulado'] > 0)
$data25_2['cumplimiento'] = ($data25_2['numerador_acumulado'] /  $data25_2['denominador_acumulado']) * 100;
else
$data25_2['cumplimiento'] = 0;

$data25_2['calculo'] =
'
Resultado Obtenido                  Porcentaje de Cumplimiento Asignado
x>=60,0%                               100,0%
50,0%<=X60,0%                           75,0%
40,0%<=X<50,0%                          50,0%
30,0%<=X<40,0%                          25,0%
X<30,0%                                     0,0%
';
// calculo de cumplimiento
switch (true) {
    case ($data25_2['cumplimiento'] >= 60):
        $data25_2['resultado'] = 100;
        break;
    case ($data25_2['cumplimiento'] >= 50):
        $data25_2['resultado'] = 75;
        break;
    case ($data25_2['cumplimiento'] >= 40):
        $data25_2['resultado'] = 50;
        break;
    case ($data25_2['cumplimiento'] >= 30):
            $data25_2['resultado'] = 25;
            break;
    default:
        $data25_2['resultado'] = 0;
}

 $data25_2['cumplimientoponderado'] = (($data25_2['resultado'] * $data25_2[1]['ponderacion'])/100);




 /// DATOS CORTE  % CUMPLIMIENTO
 $data25['cumplimientocorte1'] = ($data25_1['cumplimientoponderado'] + $data25_2['cumplimientoponderado'])/2;
 

