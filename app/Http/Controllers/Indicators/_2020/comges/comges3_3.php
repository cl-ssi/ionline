<?php

$year = 2020;

$meses = array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12);
$corte1 = array(1, 2, 3);
$naccionescorte1 = 4;
$naccionescorte2 = 2;
$naccionescorte3 = 1;
$naccionescorte4 = 3;

/***********  META 3.3 ************/
/* ==== Inicializar variables ==== */
$data3_3 = array();
$data3_3['label']['meta'] = '3.3 Porcentaje de consultas médicas nuevas ambulatorias de especialidades en
establecimientos de alta y mediana complejidad.';
//PONDERACION GLOBAL Y DE LOS 4 CORTES
$data3_3['ponderacion'] = '1,0%';
$data3_3[1]['anual'] = 20;
$data3_3[2]['anual'] = 25;
$data3_3[3]['anual'] = 25;
$data3_3[4]['anual'] = 25;


//DATOS PARA INDICADORES ACCIÓN 1
$data3_3[1]['accion'] = 'Si el Servicio de Salud presentó un porcentaje <strong>mayor o igual a un 32,0% a Diciembre de 2019</strong>
de consultas nuevas de especialidades médicas, debe mantenerlo.<br>
Si el Servicio de Salud presentó un porcentaje menor a un <strong>32,0% a Diciembre de 2019</strong> de
consultas nuevas de especialidades médicas, deberá aumentar un <strong>10,0%</strong> de la brecha observada
en su línea base a diciembre de 2019.';
$data3_3[1]['iverificacion'] = 3;
$data3_3[1]['verificacion'] = 'Reporte REM A07';
$data3_3[1]['meta'] = '>=32%';
$data3_3[1]['label']['numerador'] = 'Número de consultas nuevas de médicos especialistas realizadas en el periodo de evaluación.';
$data3_3[1]['label']['denominador'] = 'Total de consultas de médicos especialistas realizadas en el mismo periodo de evaluación.';

$data3_3[1]['numerador_acumulado'] = 0;
$data3_3[1]['denominador_acumulado'] = 0;

foreach ($meses as $mes) {
    $data3_3[1]['numeradores'][$mes] = 0;
    $data3_3[1]['denominadores'][$mes] = 0;
}

/* ===== Query numerador ===== */
$sql_valores = "SELECT e.Comuna, e.alias_estab, r.Mes, sum(ifnull(Col22,0) + ifnull(Col26,0)) as numerador
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
    $data3_3[1]['numeradores'][$valor->Mes] = $valor->numerador;
    $data3_3[1]['numerador_acumulado'] += $valor->numerador;
}

/* ===== Query denominador ===== */
$sql_valores = "SELECT e.Comuna, e.alias_estab, r.Mes, sum(ifnull(Col01,0)) as denominador
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
    $data3_3[1]['denominadores'][$valor->Mes] = $valor->denominador;
    $data3_3[1]['denominador_acumulado'] += $valor->denominador;
}

$data3_3[1]['cumplimiento'] = ($data3_3[1]['numerador_acumulado'] /
    $data3_3[1]['denominador_acumulado']) * 100;


$data3_3[1]['ponderacion'] = 50;

$data3_3[1]['calculo'] =
    '
    Resultado Obtenido Meta Mantención                  Porcentaje de Cumplimiento Asignado
    x>=32,0%                                                                        100,0%
    30,0%<=X<32,0%                                                                  50,0%    
    X<30,0%                                                                          0,0%
';
// calculo de cumplimiento
switch ($data3_3[true]) {
    case ($data3_3[1]['cumplimiento'] >= 32):
        $data3_3[1]['resultado'] = 100;
        break;
    case ($data3_3[1]['cumplimiento'] >= 30):
        $data3_3[1]['resultado'] = 50;
        break;
    default:
        $data3_3[1]['resultado'] = 0;
}

$data3_3[1]['cumplimientoponderado'] = (($data3_3[1]['resultado'] * $data3_3[1]['ponderacion']) / 100);


//DATOS PARA INDICADORES ACCIÓN 2
$data3_3[2]['accion'] = 'Aumentar <strong>1,0</strong> punto porcentual de consultas nuevas en 3 especialidades médicas con mayor
promedio de espera a diciembre de 2019';
$data3_3[2]['iverificacion'] = 2;
$data3_3[2]['verificacion'] = 'Reporte REM A07.';
$data3_3[2]['meta'] = '100%';
$data3_3[2]['label']['numerador'] = 'Número de especialidades que alcanzan el aumento de 1pp en el periodo t';
$data3_3[2]['label']['denominador'] = 'Total de especialidades comprometidas a aumentar 1 pp en el periodo';

foreach ($meses as $mes) {
    $data3_3[2]['numeradores'][$mes] = 0;
    $data3_3[2]['denominadores'][$mes] = 0;
}

$data3_3[2]['numeradores'][1] = 11;
$data3_3[2]['numeradores'][2] = 12;
$data3_3[2]['numeradores'][3] = 13;
$data3_3[2]['numerador_acumulado'] = array_sum($data3_3[2]['numeradores']);

$data3_3[2]['denominadores'][1] = 11;
$data3_3[2]['denominadores'][2] = 12;
$data3_3[2]['denominadores'][3] = 13;
$data3_3[2]['denominador_acumulado'] = array_sum($data3_3[2]['denominadores']);

$data3_3[2]['cumplimiento'] = ($data3_3[2]['numerador_acumulado'] /
    $data3_3[2]['denominador_acumulado']) * 100;


$data3_3[2]['ponderacion'] = 50;

$data3_3[2]['calculo'] =
    '
Resultado Obtenido                   Porcentaje de Cumplimiento Asignado
X=100,0%                                       100,0%
66,66%<=X<100,0%                                 50,0%
X<66,66%                                          0,0%
';
// calculo de cumplimiento
switch ($data3_3[true]) {
    case ($data3_3[2]['cumplimiento'] >= 100):
        $data3_3[2]['resultado'] = 100;
        break;
    case ($data3_3[2]['cumplimiento'] >= 66.66):
        $data3_3[2]['resultado'] = 50;
        break;
    default:
        $data3_3[2]['resultado'] = 0;
}
$data3_3[2]['cumplimientoponderado'] = (($data3_3[2]['resultado'] * $data3_3[2]['ponderacion']) / 100);





$data3_3['cumplimientoponderado'] = $data3_3[1]['cumplimientoponderado'] + $data3_3[2]['cumplimientoponderado'];
