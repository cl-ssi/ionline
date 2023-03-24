<?php

use App\Models\Indicators\SingleParameter;

$meses = array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12);
/***********  META 24.1 ************/
/* ==== Inicializar variables ==== */
$data24_1 = array();
$data24_1['label']['meta'] = '24.1 Porcentaje de Presupuesto Devengado subtítulos 29 (circular 33), 31 y 32 en relación a
monto de inversión decretado totalmente tramitado';

$data24_1['label']['numerador'] = 'Número de acciones realizadas en el periodo t';
$data24_1['label']['fuente']['numerador'] = 'monto devengado informado por el Servicio de Salud el cual es contrastado con
información incorporada en SIGFE';
$data24_1['label']['denominador'] = 'Número de acciones solicitadas en el periodo t';
$data24_1['label']['fuente']['denominador'] = ' Montos Decretados (Decretos)';
$data24_1['meta'] = '100%';
$data24_1['ponderacion'] = '4%';
$data24_1[1]['anual'] = 25;
$data24_1[2]['anual'] = '25%';
$data24_1[2]['anual'] = '25%';
$data24_1[3]['anual'] = '25%';
$data24_1[1]['ponderacion'] = 100;
$data24_1[2]['ponderacion'] = '100%';
$data24_1[3]['ponderacion'] = '100%';
$data24_1[4]['ponderacion'] = '100%';

$data24_1['iaccion'] = '';
$data24_1['faccion'] = '';
$data24_1['naccion'] = '1';


$data24_1[1]['accion'] = 'Envío de Informe de Avance que contenga:<br>
    − Pantallazos SIGFE con movimiento efectivo del mes y el acumulado a la fecha relativo a
    Subtítulo 29 (circular 33) donde aparezca monto devengado y también monto pagado, además
    deberá remitir planilla Excel respectiva detallando nombre del Proyecto, monto decretado y
    monto devengado).<br>
    − Pantallazos SIGFE con movimiento efectivo del mes y el acumulado a la fecha relativo a
    Subtítulos: 31, donde aparezca monto devengado y monto pagado, el cual debe estar abierto por306
    Compromiso de Gestión N°24
    proyecto de inversión e ítem (Gastos Administrativos, Consultorías, Terrenos, Obras Civiles,
    Equipamiento, Equipos, Vehículos, Otros Gastos).<br>
    − Reporte de Asignación Presupuestaria en formato PDF por cada proyecto de Inversión, extraído
    del Banco Integrado de Proyecto';
$data24_1[1]['verificacion'] = 'Informe de avances que contenga pantallazo SIGFE y Reporte de Banco Integrado de Proyectos';
/* ==== Inicializar el arreglo de datos $data ==== */
/* ==== Inicializar el arreglo de datos $data ==== */
$data24_1['numerador'] = '';
$data24_1['cumplimiento'] = '';


foreach ($meses as $mes) {
    $data24_1['numeradores'][$mes] = 0;
    $data24_1['denominadores'][$mes] = 0;
}

$data24_1['numerador_acumulado']=0;
$data24_1['denominador_acumulado']=0;
$base_where = array(['law','Comges'],['year',2020],['indicator',"24.1"],['establishment_id',8]);
foreach ($meses as $mes) {
$value = SingleParameter::where(array_merge($base_where,array(['month',$mes],['position','numerador'])))->first();
if($value) 
{$data24_1['numeradores'][$mes] = $value;
$data24_1['numerador_acumulado'] += $value->value;}
else       $data24_1['numeradores'][$mes] = null;

$value = SingleParameter::where(array_merge($base_where,array(['month',$mes],['position','denominador'])))->first();
if($value) 
{$data24_1['denominadores'][$mes] = $value;
$data24_1['denominador_acumulado'] += $value->value;}
else       $data24_1['denominadores'][$mes] = null;

}

if ($data24_1['denominador_acumulado'] > 0)
$data24_1['cumplimiento'] = ($data24_1['numerador_acumulado'] /  $data24_1['denominador_acumulado']) * 100;
else
$data24_1['cumplimiento'] = 0;

$data24_1['calculo'] =
'
Resultado Obtenido                  Porcentaje de Cumplimiento Asignado
x=100,0%                                    100,0%
X<100,0%                                        0,0%
';
// calculo de cumplimiento
switch ($data24_1[true]) {
    case ($data24_1['cumplimiento'] >= 100):
        $data24_1['resultado'] = 100;
        break;    
    default:
        $data24_1['resultado'] = 0;
}

$data24_1['cumplimientoponderado'] = (($data24_1['resultado'] * $data24_1[1]['ponderacion'])/100);

/// DATOS CORTE  % CUMPLIMIENTO
$data24['cumplimientocorte1'] = $data24_1['cumplimientoponderado'];