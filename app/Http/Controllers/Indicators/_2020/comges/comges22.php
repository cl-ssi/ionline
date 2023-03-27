<?php
use App\Models\Indicators\SingleParameter;

$meses = array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12);
$corte1 = array(1, 2, 3);

/***********  META 22.1 ************/
/* ==== Inicializar variables ==== */
$data22_1 = array();
$data22_1['label']['meta'] = '22.1 Porcentaje de avance SIDRA en implementación de Registro Clínico Electrónico en los procesos
priorizados en el periodo (Agenda, referencia/contra-referencia, Ambulatorio, Urgencia, Hospitalizado y
Tabla Quirúrgica).';

$data22_1['label']['numerador'] = 'Número de Hitos cumplidos según Plan de Trabajo SIDRA en el periodo t';
$data22_1['label']['denominador'] = 'N° total de Hitos planificados en el Plan de Trabajo SIDRA para el periodo t';
$data22_1['label']['fuente'] = 'Planificación SIDRA 2020';
$data22_1['meta'] = '100%';
$data22_1['ponderacion'] = '1,2%';
$data22_1[1]['anual'] = 25;
$data22_1[2]['anual'] = '25%';
$data22_1[2]['anual'] = '25%';
$data22_1[3]['anual'] = '25%';
$data22_1[1]['ponderacion'] = 100;
$data22_1[2]['ponderacion'] = 100;
$data22_1[3]['ponderacion'] = 100;
$data22_1[4]['ponderacion'] = 100;

$data22_1['iaccion'] = '';
$data22_1['faccion'] = '';
$data22_1['naccion'] = '1';


$data22_1[1]['accion'] = 'Cumplimiento del 100,0% de los hitos definidos en el plan de trabajo del Proyecto SIDRA para el
periodo, orientado fundamentalmente al proceso de implementación de los sistemas de Registro
Clínico Electrónico en los establecimientos de la red asistencial y referidos a los procesos
definidos como prioritarios.';
$data22_1[1]['verificacion'] = 'Planificación SIDRA 2020, informada mensualmente en plataforma SharePoint';
/* ==== Inicializar el arreglo de datos $data ==== */
$data22_1['numerador'] = '';
$data22_1['cumplimiento'] = '';


foreach ($meses as $mes) {
    $data22_1['numeradores'][$mes] = 0;
    $data22_1['denominadores'][$mes] = 0;
}

$data22_1['numerador_acumulado']=0;
$data22_1['denominador_acumulado']=0;
$base_where = array(['law','Comges'],['year',2020],['indicator',"22.1"],['establishment_id',8]);
foreach ($meses as $mes) {
$value = SingleParameter::where(array_merge($base_where,array(['month',$mes],['position','numerador'])))->first();
if($value) 
{$data22_1['numeradores'][$mes] = $value;
$data22_1['numerador_acumulado'] += $value->value;}
else       $data22_1['numeradores'][$mes] = null;

$value = SingleParameter::where(array_merge($base_where,array(['month',$mes],['position','denominador'])))->first();
if($value) 
{$data22_1['denominadores'][$mes] = $value;
$data22_1['denominador_acumulado'] += $value->value;}
else       $data22_1['denominadores'][$mes] = null;

}

if ($data22_1['denominador_acumulado'] > 0)
$data22_1['cumplimiento'] = ($data22_1['numerador_acumulado'] /  $data22_1['denominador_acumulado']) * 100;
else
$data22_1['cumplimiento'] = 0;

$data22_1['calculo'] =
'
Resultado Obtenido                  Porcentaje de Cumplimiento Asignado
x>=100,0%                               100,0%
90,0%<=X<100,0%                     75,0%
80,0%<=X<90,0%                     50,0%
70,0%<=X<80,0%                     25,0%
X<70,0%                                     0,0%
';
// calculo de cumplimiento
switch ($data22_1[true]) {
    case ($data22_1['cumplimiento'] >= 100):
        $data22_1['resultado'] = 100;
        break;
    case ($data22_1['cumplimiento'] >= 90):
        $data22_1['resultado'] = 75;
        break;
    case ($data22_1['cumplimiento'] >= 80):
        $data22_1['resultado'] = 50;
        break;
    case ($data22_1['cumplimiento'] >= 70):
            $data22_1['resultado'] = 25;
            break;
    default:
        $data22_1['resultado'] = 0;
}

$data22_1['cumplimientoponderado'] = (($data22_1['resultado'] * $data22_1[1]['ponderacion'])/100);




/***********  META 22.2 ************/
/* ==== Inicializar variables ==== */
$data22_2 = array();
$data22_2['label']['meta'] = '22.2 Porcentaje de procesos clínicos que cumplen con la evaluación de concordancia entre las atenciones médicas de los procesos priorizados (atención abierta, cerrada y urgencia) informadas a través de los registros clínicos (SIDRA) y las atenciones médicas informadas en el periodo a través de los REM enviados por los Servicios de Salud al DEIS.';
$data22_2['label']['numerador'] = 'Total de procesos que cumplen umbral del >=90,0% de concordancia en el periodo t';
$data22_2['label']['denominador'] = 'Total de procesos evaluados en el periodo t';
$data22_2['label']['fuente'] = '<br>Archivo de texto plano con información de los registros individualizados de los procesos priorizados.<br>REM enviado por los SS y provistos por DEIS para análisis';
$data22_2['meta'] = '90%';
$data22_2['ponderacion'] = '1,6';

/* ==== Datos corte 1 ==== */
$data22_1[1][] = '';
$data22_2[1]['accion'] = 'Alcanzar el 90,0% de concordancia entre las atenciones registradas en los sistemas de
información de registro clínico en los procesos comprometidos en la estrategia SIDRA y las
atenciones informadas a través de REM.';
$data22_2[1]['verificacion'] = '
Archivo de texto plano con información de los registros individualizados de los procesos priorizados.</li>
<li> REM enviado por los SS provistos por DEIS para analisis';
$data22_2[1]['ponderacion'] = 100;
$data22_2[1]['anual'] = 25;
foreach ($meses as $mes) {
    $data22_2['numeradores'][$mes] = 0;
    $data22_2['denominadores'][$mes] = 0;
}

$data22_2['numerador_acumulado']=0;
$data22_2['denominador_acumulado']=0;
$base_where = array(['law','Comges'],['year',2020],['indicator',"22.2"],['establishment_id',8]);
foreach ($meses as $mes) {
$value = SingleParameter::where(array_merge($base_where,array(['month',$mes],['position','numerador'])))->first();
if($value) 
{$data22_2['numeradores'][$mes] = $value;
$data22_2['numerador_acumulado'] += $value->value;}
else       $data22_2['numeradores'][$mes] = null;

$value = SingleParameter::where(array_merge($base_where,array(['month',$mes],['position','denominador'])))->first();
if($value) 
{$data22_2['denominadores'][$mes] = $value;
$data22_2['denominador_acumulado'] += $value->value;}
else       $data22_2['denominadores'][$mes] = null;

}

if ($data22_2['denominador_acumulado'] > 0)
$data22_2['cumplimiento'] = ($data22_2['numerador_acumulado'] /  $data22_2['denominador_acumulado']) * 100;
else
$data22_2['cumplimiento'] = 0;

$data22_2['calculo'] =
'
Resultado Obtenido                  Porcentaje de Cumplimiento Asignado
x>=90,0%                               100,0%
85,0%<=X<90,0%                     75,0%
80,0%<=X<85,0%                     50,0%
75,0%<=X<80,0%                     25,0%
X<75,0%                                     0,0%
';
// calculo de cumplimiento
switch ($data22_2[true]) {
    case ($data22_2['cumplimiento'] >= 90):
        $data22_2['resultado'] = 100;
        break;
    case ($data22_2['cumplimiento'] >= 85):
        $data22_2['resultado'] = 75;
        break;
    case ($data22_2['cumplimiento'] >= 80):
        $data22_2['resultado'] = 50;
        break;
    case ($data22_2['cumplimiento'] >= 75):
            $data22_2['resultado'] = 25;
            break;
    default:
        $data22_2['resultado'] = 0;
}

 $data22_2['cumplimientoponderado'] = (($data22_2['resultado'] * $data22_2[1]['ponderacion'])/100);




/***********  META 22.3 ************/
/* ==== Inicializar variables ==== */
$data22_3 = array();
$data22_3['label']['meta'] = '22.3 Porcentaje de ejecución financiera SIDRA en el periodo.';
$data22_3['label']['numerador'] = 'Número de Facturas SIDRA pagadas en el periodo t';
$data22_3['label']['denominador'] = 'Nº total de Facturas SIDRA para el periodo t';
$data22_3['label']['fuente'] = '<br>Actualización de facturas SIDRA del periodo cargadas SharePoint.<br>Estado de Ejecución Presupuestaria.<br> Comprobante de Pago de Facturas';
$data22_3['meta'] = '100%';
$data22_3['ponderacion'] = '1,2';

/* ==== Datos corte 1 ==== */
$data22_3[1][] = '';
$data22_3[1]['accion'] = '100,0%  de Ejecución de Facturas SIDRA 2020 correspondientes al corte (las facturas deben
además ser cargadas en SharePoint y se debe actualizar el estado de ejecución presupuestaria';
$data22_3[1]['verificacion'] = 'Actualización de facturas SIDRA del periodo cargadas en SharePoint.</li>
<li> Estado de Ejecución Presupuestaria </li>
<li> Comprobante de Pago de Facturas';
$data22_3[1]['ponderacion'] = '100';
$data22_3[1]['anual'] = '25';
foreach ($meses as $mes) {
    $data22_3['numeradores'][$mes] = 0;
    $data22_3['denominadores'][$mes] = 0;
}

$data22_3['numerador_acumulado']=0;
$data22_3['denominador_acumulado']=0;
$base_where = array(['law','Comges'],['year',2020],['indicator',"22.3"],['establishment_id',8]);
foreach ($meses as $mes) {
$value = SingleParameter::where(array_merge($base_where,array(['month',$mes],['position','numerador'])))->first();
if($value) 
{$data22_3['numeradores'][$mes] = $value;
$data22_3['numerador_acumulado'] += $value->value;}
else       $data22_3['numeradores'][$mes] = null;

$value = SingleParameter::where(array_merge($base_where,array(['month',$mes],['position','denominador'])))->first();
if($value) 
{$data22_3['denominadores'][$mes] = $value;
$data22_3['denominador_acumulado'] += $value->value;}
else       $data22_3['denominadores'][$mes] = null;

}

if ($data22_3['denominador_acumulado'] > 0)
$data22_3['cumplimiento'] = ($data22_3['numerador_acumulado'] /  $data22_3['denominador_acumulado']) * 100;
else
$data22_3['cumplimiento'] = 0;

$data22_3['calculo'] =
'
Resultado Obtenido                  Porcentaje de Cumplimiento Asignado
x>=100,0%                               100,0%
90,0%<=X<100,0%                     75,0%
80,0%<=X<90,0%                     50,0%
70,0%<=X<80,0%                     25,0%
X<70,0%                                     0,0%
';
// calculo de cumplimiento
switch ($data22_3[true]) {
    case ($data22_3['cumplimiento'] >= 100):
        $data22_3['resultado'] = 100;
        break;
    case ($data22_3['cumplimiento'] >= 90):
        $data22_3['resultado'] = 75;
        break;
    case ($data22_3['cumplimiento'] >= 80):
        $data22_3['resultado'] = 50;
        break;
    case ($data22_3['cumplimiento'] >= 70):
            $data22_3['resultado'] = 25;
            break;
    default:
        $data22_3['resultado'] = 0;
}

 $data22_3['cumplimientoponderado'] = (($data22_3['resultado'] * $data22_3[1]['ponderacion'])/100);





 /// DATOS CORTE  % CUMPLIMIENTO
 $data22['cumplimientocorte1'] = ($data22_1['cumplimientoponderado'] + $data22_2['cumplimientoponderado'] + $data22_3['cumplimientoponderado'])/3;
 //$data22['cumplimientocorte1'] = 0;

