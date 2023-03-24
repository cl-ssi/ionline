<?php
use App\Models\Indicators\SingleParameter;

$meses = array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12);
$corte1 = array(1, 2, 3);
$naccionescorte1 = 4;
$naccionescorte2 = 2;
$naccionescorte3 = 1;
$naccionescorte4 = 3;

/***********  META 3.2 ************/
/* ==== Inicializar variables ==== */
$data3_2 = array();
$data3_2['label']['meta'] = '3.2 Porcentaje de cumplimiento de los subprocesos para la gestión de agenda de consultas de
atención odontológica ambulatoria en establecimientos de mediana y alta complejidad.';
//PONDERACION GLOBAL Y DE LOS 4 CORTES
$data3_2['ponderacion'] = '1,0%';
$data3_2[1]['anual'] = 25;
$data3_2[2]['anual'] = 25;
$data3_2[3]['anual'] = 25;
$data3_2[4]['anual'] = 25;


//DATOS PARA INDICADORES ACCIÓN 1
$data3_2[1]['accion'] = 'Envío de Memorándum con indicación del Director(a) del establecimiento hospitalario de mediana y/o alta complejidad al Servicio Dental sobre la obligatoriedad de centralizar la gestión de agenda en el establecimiento a más tardar al 31 de diciembre del año 2020.';
$data3_2[1]['iverificacion'] = 2;
$data3_2[1]['verificacion'] = 'Memorándum con indicación del Director(a) por cada uno de los establecimientos
hospitalarios de mediana y/o alta complejidad del Servicio de Salud, dirigido a su respectivo
Servicio Dental, sobre la obligatoriedad de centralizar la gestión de sus agendas en el
establecimiento a más tardar al 31 de diciembre del año 2020.';
$data3_2[1]['meta'] = '100%';
$data3_2[1]['label']['numerador'] = 'Número de establecimientos de mediana y alta complejidad del Servicio de Salud con
memorándum enviado en el periodo t';
$data3_2[1]['label']['denominador'] = 'Número de establecimientos de mediana y alta complejidad del Servicio de Salud';

//DATOS PARA ACCIÓN 1
foreach ($meses as $mes) {
    $data3_2[1]['numeradores'][$mes] = 0;
    $data3_2[1]['denominadores'][$mes] = 0;
}

$data3_2[1]['numerador_acumulado']=0;
$data3_2[1]['denominador_acumulado']=0;
$base_where = array(['law','Comges'],['year',2020],['indicator',"3.21"],['establishment_id',8]);
foreach ($meses as $mes) {
$value = SingleParameter::where(array_merge($base_where,array(['month',$mes],['position','numerador'])))->first();
if($value) 
{$data3_2[1]['numeradores'][$mes] = $value;
$data3_2[1]['numerador_acumulado'] += $value->value;}
else       $data3_2[1]['numeradores'][$mes] = null;

$value = SingleParameter::where(array_merge($base_where,array(['month',$mes],['position','denominador'])))->first();
if($value) 
{$data3_2[1]['denominadores'][$mes] = $value;
$data3_2[1]['denominador_acumulado'] += $value->value;}
else       $data3_2[1]['denominadores'][$mes] = null;

}

if ($data3_2[1]['denominador_acumulado'] > 0)
$data3_2[1]['cumplimiento'] = ($data3_2[1]['numerador_acumulado'] /  $data3_2[1]['denominador_acumulado']) * 100;
else
$data3_2[1]['cumplimiento'] = 0;


$data3_2[1]['ponderacion'] = 30;

$data3_2[1]['calculo'] =
    '
Resultado Obtenido                   Porcentaje de Cumplimiento Asignado
X=100,0%                                      100,0%
X<100,0%                                         0,0%
';
// calculo de cumplimiento
switch ($data3_2[true]) {
    case ($data3_2[1]['cumplimiento'] >= 100):
        $data3_2[1]['resultado'] = 100;
        break;    
    default:
        $data3_2[1]['resultado'] = 0;
}

$data3_2[1]['cumplimientoponderado'] = (($data3_2[1]['resultado'] * $data3_2[1]['ponderacion']) / 100);


//DATOS PARA INDICADORES ACCIÓN 2
$data3_2[2]['accion'] = 'Reflejar en la agenda vigente del período enero-marzo, el 100,0% de las consultas nuevas de
especialidades odontológicas programadas para el periodo: El Servicio de Salud debe elaborar unModelo Asistencial
63
Orientaciones Técnicas Compromisos de Gestión Año 2020
informe detallando: número total de CNE Odontológicas anuales programadas por especialidad y
el número total de CNE Odontológicas por especialidad que se disponibilizaron en el sistema de
agenda en el período enero a marzo. Con lo anterior se debe generar el % de concordancia entre
la programación de profesionales odontólogos y el sistema de agenda, según Anexo Nº2. Se debe
detallar el porcentaje de concordancia por especialidad. Cabe destacar que se considerará como
máximo el 100% de concordancia por especialidad en la concordancia global del Servicio de
Salud.';
$data3_2[2]['iverificacion'] = 1;
$data3_2[2]['verificacion'] = 'Planilla en formato ad hoc, según Anexo Nº2, elaborado por Servicio de Salud';
$data3_2[2]['meta'] = '>=100%';
$data3_2[2]['label']['numerador'] = 'Número total de consultas nuevas de especialidades odontológicas agendadas en el periodo t ';
$data3_2[2]['label']['denominador'] = 'Número total de consultas nuevas de especialidades odontológicas programadas en el periodo t';

//DATOS PARA ACCIÓN 2
foreach ($meses as $mes) {
    $data3_2[2]['numeradores'][$mes] = 0;
    $data3_2[2]['denominadores'][$mes] = 0;
}

$data3_2[2]['numerador_acumulado']=0;
$data3_2[2]['denominador_acumulado']=0;
$base_where = array(['law','Comges'],['year',2020],['indicator',"3.22"],['establishment_id',8]);
foreach ($meses as $mes) {
$value = SingleParameter::where(array_merge($base_where,array(['month',$mes],['position','numerador'])))->first();
if($value) 
{$data3_2[2]['numeradores'][$mes] = $value;
$data3_2[2]['numerador_acumulado'] += $value->value;}
else       $data3_2[2]['numeradores'][$mes] = null;

$value = SingleParameter::where(array_merge($base_where,array(['month',$mes],['position','denominador'])))->first();
if($value) 
{$data3_2[2]['denominadores'][$mes] = $value;
$data3_2[2]['denominador_acumulado'] += $value->value;}
else       $data3_2[2]['denominadores'][$mes] = null;

}

if ($data3_2[2]['denominador_acumulado'] > 0)
$data3_2[2]['cumplimiento'] = ($data3_2[2]['numerador_acumulado'] /  $data3_2[2]['denominador_acumulado']) * 100;
else
$data3_2[2]['cumplimiento'] = 0;


$data3_2[2]['ponderacion'] = 40;

$data3_2[2]['calculo'] =
    '
Resultado Obtenido                   Porcentaje de Cumplimiento Asignado
X>=100,0%                                       100,0%
90,0%<=X<100,0%                                 75,0%
80,0%<=X<90,0%                                  50,0%
70,0%<=X<80,0%                                  25,0%
X<70,0%                                          0,0%
';
// calculo de cumplimiento
switch ($data3_2[true]) {
    case ($data3_2[2]['cumplimiento'] >= 100):
        $data3_2[2]['resultado'] = 100;
        break;
    case ($data3_2[2]['cumplimiento'] >= 90):
        $data3_2[2]['resultado'] = 75;
        break;
    case ($data3_2[2]['cumplimiento'] >= 80):
        $data3_2[2]['resultado'] = 50;
        break;
    case ($data3_2[2]['cumplimiento'] >= 70):
        $data3_2[2]['resultado'] = 25;
        break;
    default:
        $data3_2[2]['resultado'] = 0;
}
$data3_2[2]['cumplimientoponderado'] = (($data3_2[2]['resultado'] * $data3_2[2]['ponderacion']) / 100);


//DATOS PARA INDICADORES ACCIÓN 3
$data3_2[3]['accion'] = '<br>- Establecer línea base de inasistencias a consultas de especialidad odontológica o “No Se
Presenta” (NSP), en base al período enero – marzo del año 2020 (datos REM A09 Sección I).<br>
- Establecer un plan de acción en donde se defina al menos una estrategia y sus etapas para
disminuir el porcentaje de consultas inasistentes o NSP: El Servicio de Salud debe elaborar y
enviar carta Gantt por cada una de las estrategias a trabajar durante el período.';
$data3_2[3]['iverificacion'] = 1;
$data3_2[3]['verificacion'] = 'Archivo con Carta Gantt elaborado por Servicio de Salud.';
$data3_2[3]['meta'] = '100%';
$data3_2[3]['label']['numerador'] = 'Número de acciones realizadas para el periodo t';
$data3_2[3]['label']['denominador'] = 'Número de acciones comprometidas para el periodo t';

//DATOS PARA ACCIÓN 3
foreach ($meses as $mes) {
    $data3_2[3]['numeradores'][$mes] = 0;
    $data3_2[3]['denominadores'][$mes] = 0;
}

$data3_2[3]['numerador_acumulado']=0;
$data3_2[3]['denominador_acumulado']=0;
$base_where = array(['law','Comges'],['year',2020],['indicator',"3.23"],['establishment_id',8]);
foreach ($meses as $mes) {
$value = SingleParameter::where(array_merge($base_where,array(['month',$mes],['position','numerador'])))->first();
if($value) 
{$data3_2[3]['numeradores'][$mes] = $value;
$data3_2[3]['numerador_acumulado'] += $value->value;}
else       $data3_2[3]['numeradores'][$mes] = null;

$value = SingleParameter::where(array_merge($base_where,array(['month',$mes],['position','denominador'])))->first();
if($value) 
{$data3_2[3]['denominadores'][$mes] = $value;
$data3_2[3]['denominador_acumulado'] += $value->value;}
else       $data3_2[3]['denominadores'][$mes] = null;

}

if ($data3_2[3]['denominador_acumulado'] > 0)
$data3_2[3]['cumplimiento'] = ($data3_2[3]['numerador_acumulado'] /  $data3_2[3]['denominador_acumulado']) * 100;
else
$data3_2[3]['cumplimiento'] = 0;


$data3_2[3]['ponderacion'] = 30;

$data3_2[3]['calculo'] =
    '
Resultado Obtenido                   Porcentaje de Cumplimiento Asignado
X=100,0%                                                100,0%
X<100,0%                                                  0,0%
';
// calculo de cumplimiento
switch ($data3_2[true]) {
    case ($data3_2[3]['cumplimiento'] >= 100):
        $data3_2[3]['resultado'] = 100;
        break;    
    default:
        $data3_2[3]['resultado'] = 0;
}

$data3_2[3]['cumplimientoponderado'] = (($data3_2[3]['resultado'] * $data3_2[3]['ponderacion']) / 100);









$data3_2['cumplimientoponderado'] = $data3_2[1]['cumplimientoponderado']+ $data3_2[2]['cumplimientoponderado']+ $data3_2[3]['cumplimientoponderado'];