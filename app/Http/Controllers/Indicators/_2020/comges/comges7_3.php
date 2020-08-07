<?php

$meses = array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12);
$corte1 = array(1, 2, 3);
$naccionescorte1 = 4;
$naccionescorte2 = 2;
$naccionescorte3 = 1;
$naccionescorte4 = 3;





/***********  META 7.3 ************/
/* ==== Inicializar variables ==== */
$data7_3 = array();
$data7_3['label']['meta'] = '7.3 Porcentaje de cierre de brechas de cobertura, semestral para los exámenes de
mamografías y PAP del Servicio de Salud.';
//PONDERACION GLOBAL Y DE LOS 4 CORTES
$data7_3['ponderacion'] = '2,0%';
$data7_3[1]['anual'] = 20;
$data7_3[2]['anual'] = 25;
$data7_3[3]['anual'] = 25;
$data7_3[4]['anual'] = 25;







/// DATOS CORTE  % CUMPLIMIENTO
//$data7['cumplimientocorte1'] = ($data7_1[1]['cumplimientoponderado']+$data7_2[1]['cumplimientoponderado'])/2;
$data7['cumplimientocorte1'] = 0;
