<?php
use App\Models\Indicators\SingleParameter;

$meses = array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12);
$corte1 = array(1, 2, 3);
$naccionescorte1 = 4;
$naccionescorte2 = 2;
$naccionescorte3 = 1;
$naccionescorte4 = 3;

/***********  META 3.1 ************/
/* ==== Inicializar variables ==== */
$data3_1 = array();
$data3_1['label']['meta'] = '3.1 Porcentaje de cumplimiento de los requisitos mínimos de agenda en establecimientos de
Atención Primaria y coordinación agenda-proceso programático.';
//PONDERACION GLOBAL Y DE LOS 4 CORTES
$data3_1['ponderacion'] = '1,0%';
$data3_1[1]['anual'] = 25;
$data3_1[2]['anual'] = 25;
$data3_1[3]['anual'] = 25;
$data3_1[4]['anual'] = 30;
//POONDERACCIÓN ACCIONES [N°ACCION]
//$data3_1['meta'] = '100%';





//DATOS PARA INDICADORES ACCIÓN 1
$data3_1[1]['accion'] = 'Contar con Plan de gestión de demanda actualizado 2020 en APS por cada comuna y establecimientos APS dependientes de Servicios de Salud.';
$data3_1[1]['iverificacion'] = 2;
$data3_1[1]['verificacion'] = 'Documento de Plan de gestión de demanda por cada comuna y establecimiento dependiente
(comunas con CESFAM y CECOSF)';
$data3_1[1]['meta'] = '100%';
$data3_1[1]['label']['numerador'] = 'Número de planes de gestión de demanda realizadas en el periodo t';
$data3_1[1]['label']['denominador'] = 'Número de planes de gestión de demanda comprometidas en el periodo t';

//DATOS PARA ACCIÓN 1
foreach ($meses as $mes) {
    $data3_1[1]['numeradores'][$mes] = 0;
    $data3_1[1]['denominadores'][$mes] = 0;
}

$data3_1[1]['numerador_acumulado']=0;
$data3_1[1]['denominador_acumulado']=0;
$base_where = array(['law','Comges'],['year',2020],['indicator',"3.11"],['establishment_id',8]);
foreach ($meses as $mes) {
$value = SingleParameter::where(array_merge($base_where,array(['month',$mes],['position','numerador'])))->first();
if($value) 
{$data3_1[1]['numeradores'][$mes] = $value;
$data3_1[1]['numerador_acumulado'] += $value->value;}
else       $data3_1[1]['numeradores'][$mes] = null;

$value = SingleParameter::where(array_merge($base_where,array(['month',$mes],['position','denominador'])))->first();
if($value) 
{$data3_1[1]['denominadores'][$mes] = $value;
$data3_1[1]['denominador_acumulado'] += $value->value;}
else       $data3_1[1]['denominadores'][$mes] = null;

}

if ($data3_1[1]['denominador_acumulado'] > 0)
$data3_1[1]['cumplimiento'] = ($data3_1[1]['numerador_acumulado'] /  $data3_1[1]['denominador_acumulado']) * 100;
else
$data3_1[1]['cumplimiento'] = 0;


$data3_1[1]['ponderacion'] = 70;

$data3_1[1]['calculo'] =
    '
Resultado Obtenido                  Porcentaje de Cumplimiento Asignado
x=100,0%                                       100,0%
X<100,0%                                          0,0%
';
// calculo de cumplimiento
switch ($data3_1[true]) {
    case ($data3_1[1]['cumplimiento'] >= 100):
        $data3_1[1]['resultado'] = 100;
        break;    
    default:
        $data3_1[1]['resultado'] = 0;
}
$data3_1[1]['cumplimientoponderado'] = (($data3_1[1]['resultado'] * $data3_1[1]['ponderacion']) / 100);



//DATOS PARA INDICADORES ACCIÓN 2
$data3_1[2]['accion'] = 'Cumplimiento de 50% de comunas y establecimientos dependientes con Agenda escalonada y
ofertada a la población por hora específica de atención (o mantener línea base si es superior)';
$data3_1[2]['iverificacion'] = 2;
$data3_1[2]['verificacion'] = 'Planilla de reporte de Servicio de Salud con requisitos mínimos de agenda de cada
comuna y establecimiento dependiente (comunas con CESFAM y CECOSF).</li>
<li>Informe de SS conteniendo: supervisión a establecimientos y/o comunas, en donde se evidencie que usuario es citado en hora específica de atención y captura de pantalla en relación a apertura de agenda de controles.';
$data3_1[2]['meta'] = '>=50%';
$data3_1[2]['label']['numerador'] = 'Número de comunas y establecimientos dependientes con Agenda escalonada y ofertada a la
población por hora específica de atención en el periodo t ';
$data3_1[2]['label']['denominador'] = 'Número de comunas y establecimientos dependientes con Agenda escalonada y ofertada a la población por hora
específica de atención comprometidos en el periodo t';

//DATOS PARA ACCIÓN 2
foreach ($meses as $mes) {
    $data3_1[2]['numeradores'][$mes] = 0;
    $data3_1[2]['denominadores'][$mes] = 0;
}

$data3_1[2]['numerador_acumulado']=0;
$data3_1[2]['denominador_acumulado']=0;
$base_where = array(['law','Comges'],['year',2020],['indicator',"3.12"],['establishment_id',8]);
foreach ($meses as $mes) {
$value = SingleParameter::where(array_merge($base_where,array(['month',$mes],['position','numerador'])))->first();
if($value) 
{$data3_1[2]['numeradores'][$mes] = $value;
$data3_1[2]['numerador_acumulado'] += $value->value;}
else       $data3_1[2]['numeradores'][$mes] = null;

$value = SingleParameter::where(array_merge($base_where,array(['month',$mes],['position','denominador'])))->first();
if($value) 
{$data3_1[2]['denominadores'][$mes] = $value;
$data3_1[2]['denominador_acumulado'] += $value->value;}
else       $data3_1[2]['denominadores'][$mes] = null;

}

if ($data3_1[2]['denominador_acumulado'] > 0)
$data3_1[2]['cumplimiento'] = ($data3_1[2]['numerador_acumulado'] /  $data3_1[2]['denominador_acumulado']) * 100;
else
$data3_1[2]['cumplimiento'] = 0;


$data3_1[2]['ponderacion'] = 10;

$data3_1[2]['calculo'] =
    '
Resultado Obtenido                  Porcentaje de Cumplimiento Asignado
x>=50,0%                                        100,0%
40,0%<=X<50,0%                                   75,0%
30,0%<=X<40,0%                                   50,0%
20,0%<=X<30,0%                                   25,0%
X<20,0%                                           0,0%
';
// calculo de cumplimiento
switch ($data3_1[true]) {
    case ($data3_1[2]['cumplimiento'] >= 50):
        $data3_1[2]['resultado'] = 100;
        break;
    case ($data3_1[2]['cumplimiento'] >= 40):
        $data3_1[2]['resultado'] = 75;
        break;
    case ($data3_1[2]['cumplimiento'] >= 30):
        $data3_1[2]['resultado'] = 50;
        break;
    case ($data3_1[2]['cumplimiento'] >= 20):
        $data3_1[2]['resultado'] = 25;
        break;
    default:
        $data3_1[2]['resultado'] = 0;
}
$data3_1[2]['cumplimientoponderado'] = (($data3_1[2]['resultado'] * $data3_1[2]['ponderacion']) / 100);


//DATOS PARA INDICADORES ACCIÓN 3
$data3_1[3]['accion'] = 'Cumplimiento de 75% de comunas y establecimientos dependientes con Apertura de Agenda entre 2 meses a 6 meses (o mantener línea base si es superior)';
$data3_1[3]['iverificacion'] = 1;
$data3_1[3]['verificacion'] = 'Planilla de reporte de Servicio de Salud con requisitos mínimos de agenda de cada
comuna y establecimiento dependiente (comunas con CESFAM y CECOSF).</li>
<li> Informe de SS conteniendo: supervisión a establecimientos y/o comunas, en donde se
evidencie que usuario es citado en hora específica de atención y captura de pantalla en
relación a apertura de agenda de controles.';
$data3_1[3]['meta'] = '>=75%';
$data3_1[3]['label']['numerador'] = 'Número de comunas y establecimientos dependientes con Agenda escalonada y ofertada a la
población por hora específica de atención en el periodo t';
$data3_1[3]['label']['denominador'] = ' Número de comunas y
establecimientos dependientes con Agenda escalonada y ofertada a la población por hora específica de atención comprometidos en el periodo t';

//DATOS PARA ACCIÓN 3
foreach ($meses as $mes) {
    $data3_1[3]['numeradores'][$mes] = 0;
    $data3_1[3]['denominadores'][$mes] = 0;
}

$data3_1[3]['numerador_acumulado']=0;
$data3_1[3]['denominador_acumulado']=0;
$base_where = array(['law','Comges'],['year',2020],['indicator',"3.13"],['establishment_id',8]);
foreach ($meses as $mes) {
$value = SingleParameter::where(array_merge($base_where,array(['month',$mes],['position','numerador'])))->first();
if($value) 
{$data3_1[3]['numeradores'][$mes] = $value;
$data3_1[3]['numerador_acumulado'] += $value->value;}
else       $data3_1[3]['numeradores'][$mes] = null;

$value = SingleParameter::where(array_merge($base_where,array(['month',$mes],['position','denominador'])))->first();
if($value) 
{$data3_1[3]['denominadores'][$mes] = $value;
$data3_1[3]['denominador_acumulado'] += $value->value;}
else       $data3_1[3]['denominadores'][$mes] = null;

}

if ($data3_1[3]['denominador_acumulado'] > 0)
$data3_1[3]['cumplimiento'] = ($data3_1[3]['numerador_acumulado'] /  $data3_1[3]['denominador_acumulado']) * 100;
else
$data3_1[3]['cumplimiento'] = 0;


$data3_1[3]['ponderacion'] = 10;

$data3_1[3]['calculo'] =
    '
Resultado Obtenido                  Porcentaje de Cumplimiento Asignado
x>=75,0%                                        100,0%
60,0%<=X<75,0%                                   75,0%
45,0%<=X<60,0%                                   50,0%
30,0%<=X<45,0%                                   25,0%
X<30,0%                                           0,0%
';
// calculo de cumplimiento
switch ($data3_1[true]) {
    case ($data3_1[3]['cumplimiento'] >= 75):
        $data3_1[3]['resultado'] = 100;
        break;
    case ($data3_1[3]['cumplimiento'] >= 60):
        $data3_1[3]['resultado'] = 75;
        break;
    case ($data3_1[3]['cumplimiento'] >= 45):
        $data3_1[3]['resultado'] = 50;
        break;
    case ($data3_1[3]['cumplimiento'] >= 30):
        $data3_1[3]['resultado'] = 25;
        break;
    default:
        $data3_1[3]['resultado'] = 0;
}
$data3_1[3]['cumplimientoponderado'] = (($data3_1[3]['resultado'] * $data3_1[3]['ponderacion']) / 100);


//DATOS PARA INDICADORES ACCIÓN 4
$data3_1[4]['accion'] = 'Contar con Planilla “definición de actividades posibles de agendar” desde planilla de programación operativa APS.';
$data3_1[4]['iverificacion'] = 1;
$data3_1[4]['verificacion'] = 'Planilla “definición de actividades posibles de agendar”.';
$data3_1[4]['meta'] = '100%';
$data3_1[4]['label']['numerador'] = 'Número de planillas “definición de actividades posibles de agendar” realizadas por comunas y
establecimientos dependientes en el periodo t';
$data3_1[4]['label']['denominador'] = 'Número de planillas “definición de actividades posibles de agendar” comprometidas por comunas y establecimientos dependientes en el periodo t';

//DATOS PARA ACCIÓN 4
foreach ($meses as $mes) {
    $data3_1[4]['numeradores'][$mes] = 0;
    $data3_1[4]['denominadores'][$mes] = 0;
}

$data3_1[4]['numerador_acumulado']=0;
$data3_1[4]['denominador_acumulado']=0;
$base_where = array(['law','Comges'],['year',2020],['indicator',"3.14"],['establishment_id',8]);
foreach ($meses as $mes) {
$value = SingleParameter::where(array_merge($base_where,array(['month',$mes],['position','numerador'])))->first();
if($value) 
{$data3_1[4]['numeradores'][$mes] = $value;
$data3_1[4]['numerador_acumulado'] += $value->value;}
else       $data3_1[4]['numeradores'][$mes] = null;

$value = SingleParameter::where(array_merge($base_where,array(['month',$mes],['position','denominador'])))->first();
if($value) 
{$data3_1[4]['denominadores'][$mes] = $value;
$data3_1[4]['denominador_acumulado'] += $value->value;}
else       $data3_1[4]['denominadores'][$mes] = null;

}

if ($data3_1[4]['denominador_acumulado'] > 0)
$data3_1[4]['cumplimiento'] = ($data3_1[4]['numerador_acumulado'] /  $data3_1[4]['denominador_acumulado']) * 100;
else
$data3_1[4]['cumplimiento'] = 0;


$data3_1[4]['ponderacion'] = 10;

$data3_1[4]['calculo'] =
    '
Resultado Obtenido                  Porcentaje de Cumplimiento Asignado
x=100,0%                                       100,0%
X<100,0%                           Porcentaje de comunias con planillas realizadas.
';
// calculo de cumplimiento
switch ($data3_1[true]) {
    case ($data3_1[4]['cumplimiento'] >= 100):
        $data3_1[4]['resultado'] = 100;
        break;    
    default:
        $data3_1[4]['resultado'] = $data3_1[4]['cumplimiento'];
}
$data3_1[4]['cumplimientoponderado'] = (($data3_1[4]['resultado'] * $data3_1[4]['ponderacion']) / 100);





$data3_1['cumplimientoponderado'] = $data3_1[1]['cumplimientoponderado']+ $data3_1[2]['cumplimientoponderado']+ $data3_1[3]['cumplimientoponderado']+ $data3_1[4]['cumplimientoponderado'];