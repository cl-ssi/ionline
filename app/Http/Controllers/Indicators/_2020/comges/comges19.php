<?php

use App\Models\Indicators\SingleParameter;

$meses = array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12);
$corte1 = array(1, 2, 3);
$naccionescorte1 = 4;
$naccionescorte2 = 2;
$naccionescorte3 = 1;
$naccionescorte4 = 3;

/***********  META 19.1 ************/
/* ==== Inicializar variables ==== */
$data19_1 = array();
$data19_1['label']['meta'] = '19.1 Porcentaje de cumplimiento de actividades que facilitan la optimización y mejora de la gestión de medicamentos en el periodo';
$data19_1[1]['label']['numerador'] = 'Número de actividades ejecutadas y validadas en el periodo t';
$data19_1[1]['label']['denominador'] = 'Número de actividades solicitadas en el periodo t';







//PONDERACION GLOBAL Y DE LOS 4 CORTES
$data19_1['ponderacion'] = '4%';
$data19_1[1]['anual'] = 40;
$data19_1[2]['anual'] = '25%';
$data19_1[3]['anual'] = '25%';
$data19_1[4]['anual'] = '25%';
//POONDERACCIÓN ACCIONES [N°ACCION]
//$data19_1['meta'] = '100%';
$data19_1[1]['meta'] = '100%';
$data19_1[1]['ponderacion'] = 25;
$data19_1[2]['ponderacion'] = 25;
$data19_1[3]['ponderacion'] = 25;
$data19_1[4]['ponderacion'] = 25;


$data19_1[1]['accion'] = 'El SS enviará a MINSAL (subir archivo a carpeta compartida de COMGES) planilla consolidada de
“Registro de ingresos y egresos de Fármacos en el trimestre respectivo” (ver anexo 1). Para este
corte, será válido el archivo que contenga los Ingresos y Egresos de Fármacos entre el
01/01/2020 al 31/03/2020 en los establecimientos hospitalarios de alta y mediana complejidad
del Servicio de Salud.';
$data19_1[1]['verificacion'] = ' Planilla Consolidada “Registro de ingresos y egresos de Fármacos en el trimestre respectivo”
(ver anexo 1).';
$data19_1[2]['accion'] = 'El SS enviará a MINSAL (subir archivo a carpeta compartida de COMGES) archivo excel según
anexo 3, que informe el arsenal farmacológico vigente al 31/03/2020, de todos los
establecimientos de mediana y alta complejidad de la Red Asistencial';
$data19_1[2]['verificacion'] = 'Archivo excel de acuerdo al anexo 3 subido a carpeta compartida de COMGES 19. El detalle de
los fármacos que componen el arsenal farmacológico de la Red Asistencial deberá informarse
según homologación a código único de medicamentos';
$data19_1[3]['accion'] = 'Homologación de codificación de medicamentos a código único definido por la Subsecretaria de
Redes Asistenciales. Para este corte, el alcance de la Homologación será exigido sólo en Anexo 1
y Anexo 3. Sin perjuicio del avance en la homologación de códigos en los sistemas de
información de cada establecimiento.';
$data19_1[3]['verificacion'] = 'Envió de Planilla Consolidada de “Registro de ingresos y egresos de Fármacos en el trimestre
respectivo” (ver anexo 1) y “Arsenal Farmacológico Servicio de Salud” (ver anexo 3) con la
Homologación de códigos. Sólo se considerará cumplida está actividad, en la medida que cada
establecimiento de alta y mediana complejidad del Servicio de Salud respectivo, incluya en las
citadas planillas, la homologación de todos sus medicamentos en el trimestre respectivo';
$data19_1[4]['accion'] = 'Envío de Manual(es) de procedimientos vigentes asociados al proceso logístico de
medicamentos y su nivel de adopción en cada Establecimiento Hospitalario.';
$data19_1[4]['verificacion'] = 'Subir a carpeta compartida del Compromiso de Gestion los procedimientos vigentes y su nivel
de adopción de cada Establecimiento de alta y mediana complejidad que componen la Red del
Servicio de Salud respectivo';
//DATOS PARA ACCIÓN 1
foreach ($meses as $mes) {
    $data19_1[1]['numeradores'][$mes] = 0;
    $data19_1[1]['denominadores'][$mes] = 0;
}

$data19_1[1]['numerador_acumulado']=0;
$data19_1[1]['denominador_acumulado']=0;
$base_where = array(['law','Comges'],['year',2020],['indicator',"19.01"],['establishment_id',8]);
foreach ($meses as $mes) {
$value = SingleParameter::where(array_merge($base_where,array(['month',$mes],['position','numerador'])))->first();
if($value) 
{$data19_1[1]['numeradores'][$mes] = $value;
$data19_1[1]['numerador_acumulado'] += $value->value;}
else       $data19_1[1]['numeradores'][$mes] = null;

$value = SingleParameter::where(array_merge($base_where,array(['month',$mes],['position','denominador'])))->first();
if($value) 
{$data19_1[1]['denominadores'][$mes] = $value;
$data19_1[1]['denominador_acumulado'] += $value->value;}
else       $data19_1[1]['denominadores'][$mes] = null;

}

if ($data19_1[1]['denominador_acumulado'] > 0)
$data19_1[1]['cumplimiento'] = ($data19_1[1]['numerador_acumulado'] /  $data19_1[1]['denominador_acumulado']) * 100;
else
$data19_1[1]['cumplimiento'] = 0;

$data19_1[1]['calculo'] =
'
Resultado Obtenido                  Porcentaje de Cumplimiento Asignado
x=100,0%                                100,0%
X<100,0%                                        0,0%
';
// calculo de cumplimiento
switch ($data19_1 [true]) {
    case ($data19_1[1]['cumplimiento'] >= 100):
        $data19_1[1]['resultado'] = 100;
        break;
    
    default:
        $data19_1[1]['resultado'] = 0;
}

$data19_1[1]['cumplimientoponderado'] = (($data19_1[1]['resultado'] * $data19_1[1]['ponderacion'])/100);





//DATOS PARA ACCIÓN 2
$data19_1[2]['label']['numerador'] = 'Número de actividades ejecutadas y validadas en el periodo t';
$data19_1[2]['label']['denominador'] = 'Número de actividades solicitadas en el periodo t';
$data19_1[2]['meta'] = '100%';

foreach ($meses as $mes) {
    $data19_1[2]['numeradores'][$mes] = 0;
    $data19_1[2]['denominadores'][$mes] = 0;
}

$data19_1[2]['numerador_acumulado']=0;
$data19_1[2]['denominador_acumulado']=0;
$base_where = array(['law','Comges'],['year',2020],['indicator',"19.02"],['establishment_id',8]);
foreach ($meses as $mes) {
$value = SingleParameter::where(array_merge($base_where,array(['month',$mes],['position','numerador'])))->first();
if($value) 
{$data19_1[2]['numeradores'][$mes] = $value;
$data19_1[2]['numerador_acumulado'] += $value->value;}
else       $data19_1[2]['numeradores'][$mes] = null;

$value = SingleParameter::where(array_merge($base_where,array(['month',$mes],['position','denominador'])))->first();
if($value) 
{$data19_1[2]['denominadores'][$mes] = $value;
$data19_1[2]['denominador_acumulado'] += $value->value;}
else       $data19_1[2]['denominadores'][$mes] = null;

}

if ($data19_1[2]['denominador_acumulado'] > 0)
$data19_1[2]['cumplimiento'] = ($data19_1[2]['numerador_acumulado'] /  $data19_1[2]['denominador_acumulado']) * 100;
else
$data19_1[2]['cumplimiento'] = 0;
$data19_1[2]['calculo'] =
'
Resultado Obtenido                  Porcentaje de Cumplimiento Asignado
x=100,0%                                100,0%
X<100,0%                                        0,0%
';
// calculo de cumplimiento
switch ($data19_1[true]) {
    case ($data19_1[2]['cumplimiento'] >= 100):
        $data19_1[2]['resultado'] = 100;
        break;   
    default:
        $data19_1[2]['resultado'] = 0;
}
$data19_1[2]['cumplimientoponderado'] = (($data19_1[2]['resultado'] * $data19_1[2]['ponderacion'])/100);








//DATOS PARA ACCIÓN 3
$data19_1[3]['label']['numerador'] = 'Número de actividades ejecutadas y validadas en el periodo t';
$data19_1[3]['label']['denominador'] = 'Número de actividades solicitadas en el periodo t';
$data19_1[3]['meta'] = '100%';

foreach ($meses as $mes) {
    $data19_1[3]['numeradores'][$mes] = 0;
    $data19_1[3]['denominadores'][$mes] = 0;
}

$data19_1[3]['numerador_acumulado']=0;
$data19_1[3]['denominador_acumulado']=0;
$base_where = array(['law','Comges'],['year',2020],['indicator',"19.03"],['establishment_id',8]);
foreach ($meses as $mes) {
$value = SingleParameter::where(array_merge($base_where,array(['month',$mes],['position','numerador'])))->first();
if($value) 
{$data19_1[3]['numeradores'][$mes] = $value;
$data19_1[3]['numerador_acumulado'] += $value->value;}
else       $data19_1[3]['numeradores'][$mes] = null;

$value = SingleParameter::where(array_merge($base_where,array(['month',$mes],['position','denominador'])))->first();
if($value) 
{$data19_1[3]['denominadores'][$mes] = $value;
$data19_1[3]['denominador_acumulado'] += $value->value;}
else       $data19_1[3]['denominadores'][$mes] = null;

}

if ($data19_1[3]['denominador_acumulado'] > 0)
$data19_1[3]['cumplimiento'] = ($data19_1[3]['numerador_acumulado'] /  $data19_1[3]['denominador_acumulado']) * 100;
else
$data19_1[3]['cumplimiento'] = 0;
$data19_1[3]['calculo'] =
'
Resultado Obtenido                  Porcentaje de Cumplimiento Asignado
x=100,0%                                100,0%
X<100,0%                                        0,0%
';
// calculo de cumplimiento
switch ($data19_1 [true]) {
    case ($data19_1[3]['cumplimiento'] >= 100):
        $data19_1[3]['resultado'] = 100;
        break;   
    default:
        $data19_1[3]['resultado'] = 0;
}
$data19_1[3]['cumplimientoponderado'] = (($data19_1[3]['resultado'] * $data19_1[3]['ponderacion'])/100);







//DATOS PARA ACCIÓN 4
$data19_1[4]['label']['numerador'] = 'Número de actividades ejecutadas y validadas en el periodo t';
$data19_1[4]['label']['denominador'] = 'Número de actividades solicitadas en el periodo t';
$data19_1[4]['meta'] = '100%';

foreach ($meses as $mes) {
    $data19_1[4]['numeradores'][$mes] = 0;
    $data19_1[4]['denominadores'][$mes] = 0;
}

$data19_1[4]['numerador_acumulado']=0;
$data19_1[4]['denominador_acumulado']=0;
$base_where = array(['law','Comges'],['year',2020],['indicator',"19.04"],['establishment_id',8]);
foreach ($meses as $mes) {
$value = SingleParameter::where(array_merge($base_where,array(['month',$mes],['position','numerador'])))->first();
if($value) 
{$data19_1[4]['numeradores'][$mes] = $value;
$data19_1[4]['numerador_acumulado'] += $value->value;}
else       $data19_1[4]['numeradores'][$mes] = null;

$value = SingleParameter::where(array_merge($base_where,array(['month',$mes],['position','denominador'])))->first();
if($value) 
{$data19_1[4]['denominadores'][$mes] = $value;
$data19_1[4]['denominador_acumulado'] += $value->value;}
else       $data19_1[4]['denominadores'][$mes] = null;

}

if ($data19_1[4]['denominador_acumulado'] > 0)
$data19_1[4]['cumplimiento'] = ($data19_1[4]['numerador_acumulado'] /  $data19_1[4]['denominador_acumulado']) * 100;
else
$data19_1[4]['cumplimiento'] = 0;
$data19_1[4]['calculo'] =
'
Resultado Obtenido                  Porcentaje de Cumplimiento Asignado
x=100,0%                                100,0%
X<100,0%                                        0,0%
';
// calculo de cumplimiento
switch ($data19_1[true]) {
    case ($data19_1[4]['cumplimiento'] >= 100):
        $data19_1[4]['resultado'] = 100;
        break;   
    default:
        $data19_1[4]['resultado'] = 0;
}
$data19_1[4]['cumplimientoponderado'] = (($data19_1[4]['resultado'] * $data19_1[4]['ponderacion'])/100);







 /// DATOS CORTE  % CUMPLIMIENTO
 $data19['cumplimientocorte1'] = $data19_1[1]['cumplimientoponderado'] + $data19_1[2]['cumplimientoponderado'] + $data19_1[3]['cumplimientoponderado'] + $data19_1[4]['cumplimientoponderado'];
 //$data22['cumplimientocorte1'] = 0;

