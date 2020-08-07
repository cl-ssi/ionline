<?php

$year = 2020;

$meses = array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12);
$corte1 = array(1, 2, 3);
$naccionescorte1 = 4;
$naccionescorte2 = 2;
$naccionescorte3 = 1;
$naccionescorte4 = 3;

/***********  META 1.1 ************/
/* ==== Inicializar variables ==== */
$data1_1 = array();
$data1_1['label']['meta'] = '1.1 Porcentaje de pertinencia en las derivaciones generadas por una consulta en Atención Primaria de Salud';
//PONDERACION GLOBAL Y DE LOS 4 CORTES
$data1_1['ponderacion'] = '1,333%';
$data1_1[1]['anual'] = 20;
$data1_1[2]['anual'] = 25;
$data1_1[3]['anual'] = 25;
$data1_1[4]['anual'] = 30;
//PONDERACCIÓN ACCIONES [N°ACCION]
//$data1_1['meta'] = '100%';

//DATOS PARA INDICADORES ACCIÓN 1
$data1_1[1]['accion'] = 'Si el Servicio de Salud presentó un porcentaje <strong>mayor o igual a un 90,0% a Diciembre de 2019 </strong>
de pertinencia en las derivaciones generadas por una consulta en Atención Primaria de Salud,
debe mantenerlo.<br>
Si el Servicio de Salud presentó un porcentaje <strong>menor a un 90,0%</strong> a Diciembre de 2019 de
pertinencia en las derivaciones generadas por una consulta en Atención Primaria de Salud,
deberá aumentar un 10,0% de la brecha observada en su línea base a diciembre de 2019, para
obtener un 90,0%
';
$data1_1[1]['iverificacion'] = 1;
$data1_1[1]['verificacion'] = 'Reporte REM A07, Sección A';
$data1_1[1]['meta'] = '>=10%';
$data1_1[1]['label']['numerador'] = 'Porcentaje Pertinencia línea base – Porcentaje Pertinencia periodo t';
$data1_1[1]['label']['denominador'] = 'Porcentaje Pertinencia línea base – 90,0%';

$data1_1[1]['numerador_acumulado'] = 0;
$data1_1[1]['denominador_acumulado'] = 0;

foreach ($meses as $mes) {
    $data1_1[1]['numeradores'][$mes] = 0;
    $data1_1[1]['denominadores'][$mes] = 0;
}

/* ===== Query numerador ===== */
$sql_valores = "SELECT e.Comuna, e.alias_estab, r.Mes, sum(ifnull(Col30,0) + ifnull(Col31,0)) as numerador
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

foreach($valores as $valor) {
    $data1_1[1]['numeradores'][$valor->Mes] = $valor->numerador;
    $data1_1[1]['numerador_acumulado'] += $valor->numerador;
}

/* ===== Query denominador ===== */
$sql_valores = "SELECT e.Comuna, e.alias_estab, r.Mes, sum(ifnull(Col22,0) + ifnull(Col26,0)) as denominador
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

foreach($valores as $valor) {
    $data1_1[1]['denominadores'][$valor->Mes] = $valor->denominador;
    $data1_1[1]['denominador_acumulado'] += $valor->denominador;
}

// dd($data1_1);

$data1_1[1]['cumplimiento'] = ($data1_1[1]['numerador_acumulado'] /
    $data1_1[1]['denominador_acumulado']) * 100;


$data1_1[1]['ponderacion'] = 100;

$data1_1[1]['calculo'] =
    '
Resultado Obtenido Meta Disminución de la Brecha                  Porcentaje de Cumplimiento Asignado
x>=10,0%                                                                        100,0%
9,0%<=X<10,0%                                                                75,0%
8,0%<=X<9,0%                                                                 50,0%
7,0%<=X<8,0%                                                                 25,0%
X<7,0%                                                                              0,0%
';
// calculo de cumplimiento
switch ($data1_1[1]['cumplimiento']) {
    case ($data1_1[1]['cumplimiento'] >= 10):
        $data1_1[1]['resultado'] = 100;
        break;
    case ($data1_1[1]['cumplimiento'] >= 9):
        $data1_1[1]['resultado'] = 75;
        break;
    case ($data1_1[1]['cumplimiento'] >= 8):
        $data1_1[1]['resultado'] = 50;
        break;
    case ($data1_1[1]['cumplimiento'] >= 7):
        $data1_1[1]['resultado'] = 25;
        break;
    default:
        $data1_1[1]['resultado'] = 0;
}
$data1_1[1]['cumplimientoponderado'] = (($data1_1[1]['resultado'] * $data1_1[1]['ponderacion']) / 100);
