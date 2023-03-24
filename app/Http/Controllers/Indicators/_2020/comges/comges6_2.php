<?php
use App\Models\Indicators\SingleParameter;

$meses = array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12);
$corte1 = array(1, 2, 3);
$naccionescorte1 = 4;
$naccionescorte2 = 2;
$naccionescorte3 = 1;
$naccionescorte4 = 3;


/***********  META 6.2 ************/
/* ==== Inicializar variables ==== */
$data6_2 = array();
$data6_2['label']['meta'] = '6.2 Porcentaje de disminución de la lista de espera por Consultas Nuevas de Especialidades
Odontológicas de la Red Asistencial.';
//PONDERACION GLOBAL Y DE LOS 4 CORTES
$data6_2['ponderacion'] = '3,0%';
$data6_2[1]['anual'] = 20;
$data6_2[2]['anual'] = 25;
$data6_2[3]['anual'] = 25;
$data6_2[4]['anual'] = 25;


//DATOS PARA INDICADORES ACCIÓN 1
$data6_2[1]['accion'] = 'Resolución del <strong>15,0%</strong> de su universo total según la meta definida para SS (excluye ortodoncia).';
$data6_2[1]['iverificacion'] = 3;
$data6_2[1]['verificacion'] = 'Reporte SIGTE extraído desde MINSAL.';
$data6_2[1]['meta'] = '>=15%';
$data6_2[1]['label']['numerador'] = 'Número de casos egresados de la lista de espera por consultas nuevas de especialidades
odontológicas de la Red Asistencial del universo comprometido en el periodo ';
$data6_2[1]['label']['denominador'] = ' Total de casos a resolver de la lista de espera por consultas nuevas de especialidades odontológicas de la Red
Asistencial comprometidos en el periodo';

//DATOS PARA ACCIÓN 1
foreach ($meses as $mes) {
    $data6_2[1]['numeradores'][$mes] = 0;
    $data6_2[1]['denominadores'][$mes] = 0;
}

$data6_2[1]['numerador_acumulado']=0;
$data6_2[1]['denominador_acumulado']=0;
$base_where = array(['law','Comges'],['year',2020],['indicator',"6.21"],['establishment_id',8]);
foreach ($meses as $mes) {
$value = SingleParameter::where(array_merge($base_where,array(['month',$mes],['position','numerador'])))->first();
if($value) 
{$data6_2[1]['numeradores'][$mes] = $value;
$data6_2[1]['numerador_acumulado'] += $value->value;}
else       $data6_2[1]['numeradores'][$mes] = null;

$value = SingleParameter::where(array_merge($base_where,array(['month',$mes],['position','denominador'])))->first();
if($value) 
{$data6_2[1]['denominadores'][$mes] = $value;
$data6_2[1]['denominador_acumulado'] += $value->value;}
else       $data6_2[1]['denominadores'][$mes] = null;

}

if ($data6_2[1]['denominador_acumulado'] > 0)
$data6_2[1]['cumplimiento'] = ($data6_2[1]['numerador_acumulado'] /  $data6_2[1]['denominador_acumulado']) * 100;
else
$data6_2[1]['cumplimiento'] = 0;


$data6_2[1]['ponderacion'] = 25;

$data6_2[1]['calculo'] =
    '
Resultado                   Porcentaje de Cumplimiento Asignado
X>=15,0%                                        100,0%
12,0%<=X<15,0%                                  75,0%
9,0%<=X<12,0%                                   50,0%
6,0%<=X<9,0%                                    25,0%
X<6,0%                                           0,0%
';
// calculo de cumplimiento
switch ($data6_2[true]) {
    case ($data6_2[1]['cumplimiento'] >= 15):
        $data6_2[1]['resultado'] = 100;
        break;
    case ($data6_2[1]['cumplimiento'] >= 12):
        $data6_2[1]['resultado'] = 75;
        break;
    case ($data6_2[1]['cumplimiento'] >= 9):
        $data6_2[1]['resultado'] = 50;
        break;
    case ($data6_2[1]['cumplimiento'] >= 6):
        $data6_2[1]['resultado'] = 25;
        break;
    default:
        $data6_2[1]['resultado'] = 0;
}

$data6_2[1]['cumplimientoponderado'] = (($data6_2[1]['resultado'] * $data6_2[1]['ponderacion']) / 100);


//DATOS PARA INDICADORES ACCIÓN 2
$data6_2[2]['accion'] = 'Resolución de <strong>100,0%</strong> de casos con fecha de ingreso según meta definida para SS (excluye
ortodoncia).';
$data6_2[2]['iverificacion'] = 3;
$data6_2[2]['verificacion'] = 'Reporte SIGTE extraído desde MINSAL.';
$data6_2[2]['meta'] = '>=100%';
$data6_2[2]['label']['numerador'] = 'Número de casos egresados de la lista de espera por consultas nuevas de especialidades
odontológicas de la Red Asistencial del universo comprometido en el periodo';
$data6_2[2]['label']['denominador'] = ' Total de casos a resolver de la lista de espera por consultas nuevas de especialidades odontológicas de la Red
Asistencial comprometidos en el periodo';

//DATOS PARA ACCIÓN 2
foreach ($meses as $mes) {
    $data6_2[2]['numeradores'][$mes] = 0;
    $data6_2[2]['denominadores'][$mes] = 0;
}

$data6_2[2]['numerador_acumulado']=0;
$data6_2[2]['denominador_acumulado']=0;
$base_where = array(['law','Comges'],['year',2020],['indicator',"6.22"],['establishment_id',8]);
foreach ($meses as $mes) {
$value = SingleParameter::where(array_merge($base_where,array(['month',$mes],['position','numerador'])))->first();
if($value) 
{$data6_2[2]['numeradores'][$mes] = $value;
$data6_2[2]['numerador_acumulado'] += $value->value;}
else       $data6_2[2]['numeradores'][$mes] = null;

$value = SingleParameter::where(array_merge($base_where,array(['month',$mes],['position','denominador'])))->first();
if($value) 
{$data6_2[2]['denominadores'][$mes] = $value;
$data6_2[2]['denominador_acumulado'] += $value->value;}
else       $data6_2[2]['denominadores'][$mes] = null;

}

if ($data6_2[2]['denominador_acumulado'] > 0)
$data6_2[2]['cumplimiento'] = ($data6_2[2]['numerador_acumulado'] /  $data6_2[2]['denominador_acumulado']) * 100;
else
$data6_2[2]['cumplimiento'] = 0;


$data6_2[2]['ponderacion'] = 25;


$data6_2[2]['calculo'] =
    '
Resultado                   Porcentaje de Cumplimiento Asignado
X>=100,0%                                       100,0%
90,0%<=X<100,0%                                  75,0%
80,0%<=X<90,0%                                   50,0%
70,0%<=X<80,0%                                   25,0%
X<70,0%                                           0,0%
';
// calculo de cumplimiento
switch ($data6_2[true]) {
    case ($data6_2[2]['cumplimiento'] >= 100):
        $data6_2[2]['resultado'] = 100;
        break;
    case ($data6_2[2]['cumplimiento'] >= 90):
        $data6_2[2]['resultado'] = 75;
        break;
    case ($data6_2[2]['cumplimiento'] >= 80):
        $data6_2[2]['resultado'] = 50;
        break;
    case ($data6_2[2]['cumplimiento'] >= 70):
        $data6_2[2]['resultado'] = 25;
        break;
    default:
        $data6_2[2]['resultado'] = 0;
}
$data6_2[2]['cumplimientoponderado'] = (($data6_2[2]['resultado'] * $data6_2[2]['ponderacion']) / 100);




//DATOS PARA INDICADORES ACCIÓN 3
$data6_2[3]['accion'] = 'Resolución del <strong>15,0%</strong> de su universo total según la meta definida para SS en la especialidad de
Ortodoncia.';
$data6_2[3]['iverificacion'] = 1;
$data6_2[3]['verificacion'] = 'Reporte SIGTE extraído desde MINSAL.';
$data6_2[3]['meta'] = '>=15%';
$data6_2[3]['label']['numerador'] = 'Número de casos egresados de la lista de espera por consultas nuevas de especialidades
odontológicas de la Red Asistencial del universo comprometido en el periodo';
$data6_2[3]['label']['denominador'] = ' Total de casos a resolver de la lista de espera por consultas nuevas de especialidades odontológicas de la Red
Asistencial comprometidos en el periodo';

//DATOS PARA ACCIÓN 3
foreach ($meses as $mes) {
    $data6_2[3]['numeradores'][$mes] = 0;
    $data6_2[3]['denominadores'][$mes] = 0;
}

$data6_2[3]['numerador_acumulado']=0;
$data6_2[3]['denominador_acumulado']=0;
$base_where = array(['law','Comges'],['year',2020],['indicator',"6.23"],['establishment_id',8]);
foreach ($meses as $mes) {
$value = SingleParameter::where(array_merge($base_where,array(['month',$mes],['position','numerador'])))->first();
if($value) 
{$data6_2[3]['numeradores'][$mes] = $value;
$data6_2[3]['numerador_acumulado'] += $value->value;}
else       $data6_2[3]['numeradores'][$mes] = null;

$value = SingleParameter::where(array_merge($base_where,array(['month',$mes],['position','denominador'])))->first();
if($value) 
{$data6_2[3]['denominadores'][$mes] = $value;
$data6_2[3]['denominador_acumulado'] += $value->value;}
else       $data6_2[3]['denominadores'][$mes] = null;

}

if ($data6_2[3]['denominador_acumulado'] > 0)
$data6_2[3]['cumplimiento'] = ($data6_2[3]['numerador_acumulado'] /  $data6_2[3]['denominador_acumulado']) * 100;
else
$data6_2[3]['cumplimiento'] = 0;


$data6_2[3]['ponderacion'] = 15;

$data6_2[3]['calculo'] =
    '
    Resultado                   Porcentaje de Cumplimiento Asignado
    X>=15,0%                               100,0%
    12,0%<=X<15,0%                                75,0%
    9,0%<=X<12,0%                                50,0%
    6,0%<=X<9,0%                                25,0%
    X<6,0%                                0,0%
';
// calculo de cumplimiento
switch ($data6_2[true]) {
    case ($data6_2[3]['cumplimiento'] >= 15):
        $data6_2[3]['resultado'] = 100;
        break;
    case ($data6_2[3]['cumplimiento'] >= 12):
        $data6_2[3]['resultado'] = 75;
        break;
    case ($data6_2[3]['cumplimiento'] >= 9):
        $data6_2[3]['resultado'] = 50;
        break;
    case ($data6_2[3]['cumplimiento'] >= 6):
        $data6_2[3]['resultado'] = 25;
        break;
    default:
        $data6_2[3]['resultado'] = 0;
}

$data6_2[3]['cumplimientoponderado'] = (($data6_2[3]['resultado'] * $data6_2[3]['ponderacion']) / 100);


//DATOS PARA INDICADORES ACCIÓN 4
$data6_2[4]['accion'] = 'Resolución de <strong>100,0%</strong> de casos con fecha de ingreso según meta definida para SS en la
especialidad de Ortodoncia.';
$data6_2[4]['iverificacion'] = 1;
$data6_2[4]['verificacion'] = 'Reporte SIGTE extraído desde MINSAL.';
$data6_2[4]['meta'] = '>=100%';
$data6_2[4]['label']['numerador'] = 'Número de casos egresados de la lista de espera por consultas nuevas de especialidades
odontológicas de la Red Asistencial del universo comprometido en el periodor';
$data6_2[4]['label']['denominador'] = 'Total de casos a resolver de la lista de espera por consultas nuevas de especialidades odontológicas de la Red Asistencial comprometidos en el periodo';
//DATOS PARA ACCIÓN 4
foreach ($meses as $mes) {
    $data6_2[4]['numeradores'][$mes] = 0;
    $data6_2[4]['denominadores'][$mes] = 0;
}

$data6_2[4]['numerador_acumulado']=0;
$data6_2[4]['denominador_acumulado']=0;
$base_where = array(['law','Comges'],['year',2020],['indicator',"6.24"],['establishment_id',8]);
foreach ($meses as $mes) {
$value = SingleParameter::where(array_merge($base_where,array(['month',$mes],['position','numerador'])))->first();
if($value) 
{$data6_2[4]['numeradores'][$mes] = $value;
$data6_2[4]['numerador_acumulado'] += $value->value;}
else       $data6_2[4]['numeradores'][$mes] = null;

$value = SingleParameter::where(array_merge($base_where,array(['month',$mes],['position','denominador'])))->first();
if($value) 
{$data6_2[4]['denominadores'][$mes] = $value;
$data6_2[4]['denominador_acumulado'] += $value->value;}
else       $data6_2[4]['denominadores'][$mes] = null;

}

if ($data6_2[4]['denominador_acumulado'] > 0)
$data6_2[4]['cumplimiento'] = ($data6_2[4]['numerador_acumulado'] /  $data6_2[4]['denominador_acumulado']) * 100;
else
$data6_2[4]['cumplimiento'] = 0;
$data6_2[4]['ponderacion'] = 15;

$data6_2[4]['calculo'] =
    '
    Resultado                   Porcentaje de Cumplimiento Asignado
    X>=100,0%                               100,0%
    90,0%<=X<100,0%                                75,0%
    80,0%<=X<90,0%                                50,0%
    70,0%<=X<80,0%                                25,0%
    X<70,0%                                0,0%
';
// calculo de cumplimiento
switch ($data6_2[true]) {
    case ($data6_2[4]['cumplimiento'] >= 100):
        $data6_2[4]['resultado'] = 100;
        break;
    case ($data6_2[4]['cumplimiento'] >= 90):
        $data6_2[4]['resultado'] = 75;
        break;
    case ($data6_2[4]['cumplimiento'] >= 80):
        $data6_2[4]['resultado'] = 50;
        break;
    case ($data6_2[4]['cumplimiento'] >= 70):
        $data6_2[4]['resultado'] = 25;
        break;
    default:
        $data6_2[4]['resultado'] = 0;
}
$data6_2[4]['cumplimientoponderado'] = (($data6_2[4]['resultado'] * $data6_2[4]['ponderacion']) / 100);




//DATOS PARA INDICADORES ACCIÓN 5
$data6_2[5]['accion'] = 'Resolución del <strong>100,0%</strong> de casos SENAME según la meta definida para SS.';
$data6_2[5]['iverificacion'] = 3;
$data6_2[5]['verificacion'] = 'Reporte SIGTE extraído desde MINSAL.';
$data6_2[5]['meta'] = '0';
$data6_2[5]['label']['numerador'] = 'Número de casos abiertos de la lista de espera por consultas nuevas de especialidades
odontológicas de la Red Asistencial, correspondientes a casos de usuarios SENAME, con fecha de
entreda mayor a 1 año';
$data6_2[5]['label']['denominador'] = 'Total de casos a resolver de la lista de espera por consultas nuevas de especialidades odontológicas de la Red Asistencial comprometidos en el periodo';
//DATOS PARA ACCIÓN 5
foreach ($meses as $mes) {
    $data6_2[5]['numeradores'][$mes] = 0;
    //$data6_2[5]['denominadores'][$mes] = 0;
}

$data6_2[5]['numerador_acumulado']=0;
//$data6_2[5]['denominador_acumulado']=0;
$base_where = array(['law','Comges'],['year',2020],['indicator',"6.25"],['establishment_id',8]);
foreach ($meses as $mes) {
$value = SingleParameter::where(array_merge($base_where,array(['month',$mes],['position','numerador'])))->first();
if($value) 
{$data6_2[5]['numeradores'][$mes] = $value;
$data6_2[5]['numerador_acumulado'] += $value->value;}
else       $data6_2[5]['numeradores'][$mes] = null;

//$value = SingleParameter::where(array_merge($base_where,array(['month',$mes],['position','denominador'])))->first();
//if($value) 
//{$data6_2[5]['denominadores'][$mes] = $value;
//$data6_2[5]['denominador_acumulado'] += $value->value;}
//else       $data6_2[5]['denominadores'][$mes] = null;

}

if ($data6_2[5]['numerador_acumulado'] > 0)
$data6_2[5]['cumplimiento'] = $data6_2[5]['numerador_acumulado'];
else
$data6_2[5]['cumplimiento'] = 0;


$data6_2[5]['ponderacion'] = 10;

$data6_2[5]['calculo'] =
    '
Resultado                   Porcentaje de Cumplimiento Asignado
X=0%                               100,0%
X>0                                0,0%
';
// calculo de cumplimiento
switch ($data6_2[true]) {
    case ($data6_2[5]['cumplimiento'] > 0):
        $data6_2[5]['resultado'] = 0;
        break;    
    default:
        $data6_2[5]['resultado'] = 100;
}
$data6_2[5]['cumplimientoponderado'] = (($data6_2[5]['resultado'] * $data6_2[5]['ponderacion']) / 100);




//DATOS PARA INDICADORES ACCIÓN 6
$data6_2[6]['accion'] = 'Resolución del <strong>15,0%</strong> del universo total de usuarios PRAIS primera generación con fecha de ingreso igual o anterior al 30 de junio de 2019.';
$data6_2[6]['iverificacion'] = 3;
$data6_2[6]['verificacion'] = 'Reporte SIGTE extraído desde MINSAL.';
$data6_2[6]['meta'] = '>=15%';
$data6_2[6]['label']['numerador'] = 'Número de casos egresados de la lista de espera por consultas nuevas de especialidades
odontológicas de la Red Asistencial del universo comprometido en el periodo';
$data6_2[6]['label']['denominador'] = 'Total de casos a resolver de la lista de espera por consultas nuevas de especialidades odontológicas de la Red Asistencial comprometidos en el periodo';

//DATOS PARA ACCIÓN 6
foreach ($meses as $mes) {
    $data6_2[6]['numeradores'][$mes] = 0;
    $data6_2[6]['denominadores'][$mes] = 0;
}

$data6_2[6]['numerador_acumulado']=0;
$data6_2[6]['denominador_acumulado']=0;
$base_where = array(['law','Comges'],['year',2020],['indicator',"6.26"],['establishment_id',8]);
foreach ($meses as $mes) {
$value = SingleParameter::where(array_merge($base_where,array(['month',$mes],['position','numerador'])))->first();
if($value) 
{$data6_2[6]['numeradores'][$mes] = $value;
$data6_2[6]['numerador_acumulado'] += $value->value;}
else       $data6_2[6]['numeradores'][$mes] = null;

$value = SingleParameter::where(array_merge($base_where,array(['month',$mes],['position','denominador'])))->first();
if($value) 
{$data6_2[6]['denominadores'][$mes] = $value;
$data6_2[6]['denominador_acumulado'] += $value->value;}
else       $data6_2[6]['denominadores'][$mes] = null;

}

if ($data6_2[6]['denominador_acumulado'] > 0)
$data6_2[6]['cumplimiento'] = ($data6_2[6]['numerador_acumulado'] /  $data6_2[6]['denominador_acumulado']) * 100;
else
$data6_2[6]['cumplimiento'] = 0;


$data6_2[6]['ponderacion'] = 10;

$data6_2[6]['calculo'] =
    '
    Resultado                   Resultado
X>=15,0%                               100,0%
12,0%<=X<15,0%                                75,0%
9,0%<=X<12,0%                                50,0%
6,0%<=X<9,0%                                25,0%
X<6,0%                                0,0%
';
// calculo de cumplimiento
switch ($data6_2[true]) {
    case ($data6_2[6]['cumplimiento'] >= 15):
        $data6_2[6]['resultado'] = 100;
        break;
    case ($data6_2[6]['cumplimiento'] >= 12):
        $data6_2[6]['resultado'] = 75;
        break;
    case ($data6_2[6]['cumplimiento'] >= 9):
        $data6_2[6]['resultado'] = 50;
        break;
    case ($data6_2[6]['cumplimiento'] >= 6):
        $data6_2[6]['resultado'] = 25;
        break;
    default:
        $data6_2[6]['resultado'] = 0;
}
$data6_2[6]['cumplimientoponderado'] = (($data6_2[6]['resultado'] * $data6_2[6]['ponderacion']) / 100);










$data6_2['cumplimientoponderado']  = $data6_2[1]['cumplimientoponderado']+
                                    $data6_2[2]['cumplimientoponderado']+
                                    $data6_2[3]['cumplimientoponderado']+
                                    $data6_2[4]['cumplimientoponderado']+
                                    $data6_2[5]['cumplimientoponderado']+
                                    $data6_2[6]['cumplimientoponderado'];
