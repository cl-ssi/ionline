<?php

$year = 2020;

$meses = array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12);
$corte1 = array(1, 2, 3);
$naccionescorte1 = 4;
$naccionescorte2 = 2;
$naccionescorte3 = 1;
$naccionescorte4 = 3;

/***********  META 3.4 ************/
/* ==== Inicializar variables ==== */
$data3_4 = array();
$data3_4['label']['meta'] = '3.4 Porcentaje de disminución de inasistencias o consultas “No Se Presenta” (NSP), en consultas
con profesionales médicos de atención secundaria.';
//PONDERACION GLOBAL Y DE LOS 4 CORTES
$data3_4['ponderacion'] = '1,0%';
$data3_4[1]['anual'] = 20;
$data3_4[2]['anual'] = 25;
$data3_4[3]['anual'] = 25;
$data3_4[4]['anual'] = 25;


//DATOS PARA INDICADORES ACCIÓN 1
$data3_4[1]['accion'] = 'Alcanzar un porcentaje de consultas inasistentes o NSP en consultas agendadas con
profesionales médicos de atención secundaria menor o igual a un <strong>15,0%.</strong>';
$data3_4[1]['iverificacion'] = 4;
$data3_4[1]['verificacion'] = 'REM A07';
$data3_4[1]['meta'] = '<=15%';
$data3_4[1]['label']['numerador'] = 'Número total de consultas inasistentes o NSP en consultas agendadas con profesionales
médicos de atención secundaria por Servicio de Salud en el periodo de evaluación';
$data3_4[1]['label']['denominador'] = 'Número
total de consultas de especialidades médicas realizadas en atención secundaria + número total
de consultas inasistentes o NSP en consultas agendadas con profesionales médicos de atención secundaria por Servicio de Salud en el periodo de evaluación';

$data3_4[1]['numerador_acumulado'] = 0;
$data3_4[1]['denominador_acumulado'] = 0;

foreach ($meses as $mes) {
    $data3_4[1]['numeradores'][$mes] = 0;
    $data3_4[1]['denominadores'][$mes] = 0;
}

/* ===== Query numerador ===== */
$sql_valores = "SELECT e.Comuna, e.alias_estab, r.Mes, sum(ifnull(Col32,0) + ifnull(Col33,0)) as numerador
                  FROM {$year}rems r
                  LEFT JOIN {$year}establecimientos e
                  ON r.IdEstablecimiento=e.Codigo
                  WHERE CodigoPrestacion in (07020130, 07020230, 07020330, 07020331, 07020332, 07024219, 07020500, 07020501,
                                            07020600, 07020601, 07020700, 07020800, 07020801, 07020900, 07020901, 07021000,
                                            07021001, 07021100, 07021101, 07021230, 07021300, 07021301, 07022000, 07022001,
                                            07021531, 07022132, 07022133, 07022134, 07021700, 07021800, 07021801, 07021900,
                                            07022130, 07022142, 07022143, 07022144, 07022135, 07022136, 07022137, 07022700,
                                            07022800, 07022900, 07021701, 07023100, 07023200, 07023201, 07023202, 07023203,
                                            07023700, 07023701, 07023702, 07023703, 07024000, 07024001, 07024200, 07030500,
                                            07024201, 07024202, 07030501, 07030502) AND e.Codigo = 102100
                  GROUP BY e.Comuna, e.alias_estab, r.Mes
                  ORDER BY e.Comuna, e.alias_estab, r.Mes";
$valores = DB::connection('mysql_rem')->select($sql_valores);

foreach ($valores as $valor) {
    $data3_4[1]['numeradores'][$valor->Mes] = $valor->numerador;
    $data3_4[1]['numerador_acumulado'] += $valor->numerador;
}

/* ===== Query denominador ===== */
$sql_valores = "SELECT e.Comuna, e.alias_estab, r.Mes, sum(ifnull(Col01,0) + ifnull(Col32,0) + ifnull(Col33,0)) as denominador
                  FROM {$year}rems r
                  LEFT JOIN {$year}establecimientos e
                  ON r.IdEstablecimiento=e.Codigo
                  WHERE CodigoPrestacion in (07020130, 07020230, 07020330, 07020331, 07020332, 07024219, 07020500, 07020501,
                                            07020600, 07020601, 07020700, 07020800, 07020801, 07020900, 07020901, 07021000,
                                            07021001, 07021100, 07021101, 07021230, 07021300, 07021301, 07022000, 07022001,
                                            07021531, 07022132, 07022133, 07022134, 07021700, 07021800, 07021801, 07021900,
                                            07022130, 07022142, 07022143, 07022144, 07022135, 07022136, 07022137, 07022700,
                                            07022800, 07022900, 07021701, 07023100, 07023200, 07023201, 07023202, 07023203,
                                            07023700, 07023701, 07023702, 07023703, 07024000, 07024001, 07024200, 07030500,
                                            07024201, 07024202, 07030501, 07030502) AND e.Codigo = 102100
                  GROUP BY e.Comuna, e.alias_estab, r.Mes
                  ORDER BY e.Comuna, e.alias_estab, r.Mes";
$valores = DB::connection('mysql_rem')->select($sql_valores);

foreach ($valores as $valor) {
    $data3_4[1]['denominadores'][$valor->Mes] = $valor->denominador;
    $data3_4[1]['denominador_acumulado'] += $valor->denominador;
}

$data3_4[1]['cumplimiento'] = ($data3_4[1]['numerador_acumulado'] /
    $data3_4[1]['denominador_acumulado']) * 100;


$data3_4[1]['ponderacion'] = 100;

$data3_4[1]['calculo'] =
    '
Resultado Obtenido                   Porcentaje de Cumplimiento Asignado
X<=15,0%                                      100,0%
16,0%>=X>15,0%                                  75,0%
17,0%>=X>16,0%                                  50,0%
18,0%>=X>17,0%                                  25,0%
X>18,0%                                         0,0%
';
// calculo de cumplimiento
switch ($data3_4[true]) {
    case ($data3_4[1]['cumplimiento'] > 18):
        $data3_4[1]['resultado'] = 0;
        break;
    case ($data3_4[1]['cumplimiento'] > 17):
        $data3_4[1]['resultado'] = 25;
        break;
    case ($data3_4[1]['cumplimiento'] > 16):
        $data3_4[1]['resultado'] = 50;
        break;
    case ($data3_4[1]['cumplimiento'] > 15):
        $data3_4[1]['resultado'] = 75;
        break;
    default:
        $data3_4[1]['resultado'] = 100;
}

$data3_4[1]['cumplimientoponderado'] = (($data3_4[1]['resultado'] * $data3_4[1]['ponderacion']) / 100);






$data3_4['cumplimientoponderado'] = $data3_4[1]['cumplimientoponderado'];
