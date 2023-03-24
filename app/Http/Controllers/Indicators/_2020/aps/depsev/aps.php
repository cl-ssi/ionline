<?php
namespace App\Http\Controllers\Indicators\_2020;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\Indicators\SingleParameter;

$year = 2020;

$label['programa'] = 'Dependencia Severa.';

// Indicador 1
$ind = 1;
$label[$ind]['meta'] = '1-. Porcentaje de personas del Programa que cuenten con
    una visita domiciliaria integral.';
$label[$ind]['numerador'] = 'N° de personas  con Dependencia Severa  que reciben
    1 Visita Domiciliaria Integral.';
$label[$ind]['denominador'] = 'N° de personas con dependencia severa bajo control
    en el Programa de Atención Domiciliaria para personas con dependencia severa.';
$label[$ind]['fuente_numerador'] = 'REM';
$label[$ind]['fuente_denominador'] = 'REM P';
$label[$ind]['ponderacion'] = '';

$meses = array(1,2,3,4,5,6,7,8,9,10,11,12);
$flag1 = NULL;
$flag2 = NULL;
$data2020 = array();

$sql_establecimientos ='SELECT comuna, alias_estab
                        FROM 2020establecimientos
                        WHERE p_depsev = 1
                        ORDER BY comuna, id_establecimiento';

$establecimientos = DB::connection('mysql_rem')->select($sql_establecimientos);

/* ==== Inicializar en 0 el arreglo de datos $data2020 ==== */
foreach($establecimientos as $establecimiento) {
     $data2020[$establecimiento->comuna][$ind]['numeradores']['total'] = 0;
     // $data2020[$establecimiento->comuna][$ind]['denominadores']['total'] = 0;
     $data2020[$establecimiento->comuna][$ind]['denominador'] = 0;
     $data2020[$establecimiento->comuna][$ind]['denominador_a'] = 0;
     $data2020[$establecimiento->comuna][$ind]['denominador_6'] = 0;
     $data2020[$establecimiento->comuna][$ind]['denominador_12'] = 0;
     $data2020[$establecimiento->comuna][$ind]['cumplimiento'] = 0;
     for($mes=1; $mes <= $ultimo_rem; $mes++) {
         $data2020[$establecimiento->comuna][$ind]['numeradores'][$mes] = 0;
         $data2020[$establecimiento->comuna][$ind][$establecimiento->alias_estab]['numeradores']['total'] = 0;
         $data2020[$establecimiento->comuna][$ind][$establecimiento->alias_estab]['numeradores'][$mes] = 0;

         $data2020[$establecimiento->comuna][$ind][$establecimiento->alias_estab]['denominador'] = 0;
         $data2020[$establecimiento->comuna][$ind][$establecimiento->alias_estab]['denominador_a'] = 0;
         $data2020[$establecimiento->comuna][$ind][$establecimiento->alias_estab]['denominador_6'] = 0;
         $data2020[$establecimiento->comuna][$ind][$establecimiento->alias_estab]['denominador_12'] = 0;
     }
     $data2020[$establecimiento->comuna][$ind][$establecimiento->alias_estab]['cumplimiento'] = 0;
}

$data2020['ALTO HOSPICIO'][$ind]['meta'] = '100%';
$data2020['CAMIÑA'][$ind]['meta'] = '100%';
$data2020['COLCHANE'][$ind]['meta'] = '100%';
$data2020['HUARA'][$ind]['meta'] = '100%';
$data2020['IQUIQUE'][$ind]['meta'] = '100%';
$data2020['PICA'][$ind]['meta'] = '100%';
$data2020['POZO ALMONTE'][$ind]['meta'] = '100%';

/* ===== Query numerador ===== */
$sql_numerador = "SELECT e.Comuna, e.alias_estab, r.Mes, sum(ifnull(Col08,0)) as numerador
                   FROM {$year}rems r
                   LEFT JOIN {$year}establecimientos e
                   ON r.IdEstablecimiento=e.Codigo
                   WHERE CodigoPrestacion in (26274200, 26273106, 26274400, 26261400, 26300100) AND e.p_depsev = 1
                   GROUP BY e.Comuna, e.alias_estab, r.Mes
                   ORDER BY e.Comuna, e.alias_estab, r.Mes";
$numeradores = DB::connection('mysql_rem')->select($sql_numerador);

foreach($numeradores as $registro) {
     if( ($flag1 != $registro->Comuna) OR ($flag2 != $registro->alias_estab) ) {
         for($mes=1; $mes <= $ultimo_rem; $mes++) {
             $data2020[$registro->Comuna][$ind][$registro->alias_estab]['numeradores'][$mes] = 0;
         }
         $flag1 = $registro->Comuna;
         $flag2 = $registro->alias_estab;
     }
     $data2020[$registro->Comuna][$ind][$registro->alias_estab]['numeradores'][$registro->Mes] = $registro->numerador;
}

if($ultimo_rem <= 5){
     /* ===== Query denominador ===== */
     $sql_denominador = "SELECT e.Comuna, e.alias_estab, r.Mes, sum(ifnull(Col01,0)) as denominador
                         FROM 2019rems r
                         LEFT JOIN 2019establecimientos e
                         ON r.IdEstablecimiento=e.Codigo
                         WHERE CodigoPrestacion in ('P3160800') AND e.p_depsev = 1
                         AND r.Mes = '12'
                         GROUP BY e.Comuna, e.alias_estab, r.Mes
                         ORDER BY e.Comuna, e.alias_estab, r.Mes";
     $valores = DB::connection('mysql_rem')->select($sql_denominador);

     foreach($valores as $valor) {
         $data2020[$valor->Comuna][$ind][$valor->alias_estab]['denominador_a'] = $valor->denominador;
     }
}
 else{
     /* ===== Query denominador ===== */
     $sql_denominador = "SELECT e.Comuna, e.alias_estab, r.Mes, sum(ifnull(Col01,0)) as denominador
                         FROM {$year}rems r
                         LEFT JOIN {$year}establecimientos e
                         ON r.IdEstablecimiento=e.Codigo
                         WHERE CodigoPrestacion in ('P3160800') AND e.p_depsev = 1
                         AND (r.Mes = '6' OR r.Mes = '12')
                         GROUP BY e.Comuna, e.alias_estab, r.Mes
                         ORDER BY e.Comuna, e.alias_estab, r.Mes";
     $valores = DB::connection('mysql_rem')->select($sql_denominador);

     foreach($valores as $valor) {
         switch ($valor->Mes) {
           case 6:
                 $data2020[$valor->Comuna][$ind][$valor->alias_estab]['denominador_6'] = $valor->denominador;
             break;
           case 12:
                 $data2020[$valor->Comuna][$ind][$valor->alias_estab]['denominador_12'] = $valor->denominador;
             break;
         }
     }
}

/* ==== Calculos ==== */
foreach($data2020 as $nombre_comuna => $comuna) {
  foreach($comuna as $nro_ind => $indicador) {
    foreach($indicador as $nombre_establecimiento => $establecimiento) {
         /* Existe en el array un indice ['numerador'], ['denominador'] y ['meta'],
          * estos almacenan la información de la comuna, por lo tanto tengo que saltarlos
          * en la iteración del foreach y continuar con los establecimientos */
         /* Realizar los calculos mensuales */
         if($nombre_establecimiento != 'numeradores' AND
             $nombre_establecimiento != 'denominador' AND
             $nombre_establecimiento != 'denominador_a' AND
             $nombre_establecimiento != 'denominador_6' AND
             $nombre_establecimiento != 'denominador_12' AND
             $nombre_establecimiento != 'meta' AND
             $nombre_establecimiento != 'cumplimiento' AND
             $nro_ind == $ind){

             /* Calcula numeradores totales de cada establecimiento */
             $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['numeradores']['total'] = array_sum($establecimiento['numeradores']);

             /* Calcula la suma mensual de numeradores por comuna */
             for($mes=1; $mes <= $ultimo_rem; $mes++) {
                 $data2020[$nombre_comuna][$ind]['numeradores'][$mes] += $establecimiento['numeradores'][$mes];
             }

             /* Calcula el numerador total de cada comuna */
             $data2020[$nombre_comuna][$ind]['numeradores']['total'] += $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['numeradores']['total'];

             /* Calcula el denominador total de cada comuna según REM */
             $data2020[$nombre_comuna][$ind]['denominador_a'] += $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['denominador_a'];
             $data2020[$nombre_comuna][$ind]['denominador_6'] += $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['denominador_6'];
             $data2020[$nombre_comuna][$ind]['denominador_12'] += $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['denominador_12'];

             //Asigna el denominador por establecimiento y comunal para los calculos.
             if($ultimo_rem <= 5){
                 $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['denominador'] = $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['denominador_a'];
                 $data2020[$nombre_comuna][$ind]['denominador'] = $data2020[$nombre_comuna][$ind]['denominador_a'];
             }
             elseif($ultimo_rem >= 6 && $ultimo_rem <= 11){
                 $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['denominador'] = $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['denominador_6'];
                 $data2020[$nombre_comuna][$ind]['denominador'] = $data2020[$nombre_comuna][$ind]['denominador_6'];
             }
             else {
                 $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['denominador'] = $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['denominador_12'];
                 $data2020[$nombre_comuna][$ind]['denominador'] = $data2020[$nombre_comuna][$ind]['denominador_12'];
             }

             /* Calculo de las metas de cada establecimiento */
             if($data2020[$nombre_comuna][$ind][$nombre_establecimiento]['denominador'] == 0) {
                 /* Si es 0 el denominadore entonces la cumplimiento es 0 */
                 $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['cumplimiento'] = 0;
             }
             else {
                 $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['cumplimiento'] =
                     $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['numeradores']['total'] / $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['denominador'] * 100;
             }

             /* Calculo de las metas de la comuna */
             if($data2020[$nombre_comuna][$ind]['denominador'] == 0) {
                 /* Si es 0 el denominadore entonces la cumplimiento es 0 */
                 $data2020[$nombre_comuna][$ind]['cumplimiento'] = 0;
             }
             else {
                 /* De lo contrario calcular el porcentaje */
                 $data2020[$nombre_comuna][$ind]['cumplimiento'] = $data2020[$nombre_comuna][$ind]['numeradores']['total'] / $data2020[$nombre_comuna][$ind]['denominador'] * 100;
             }
         }
     }
   }
}

// Indicador 2
$ind = 2;
$label[$ind]['meta'] = '2-. Porcentaje de personas que cuenten con dos visitas
    domiciliarias integrales.';
$label[$ind]['numerador'] = 'N° de personas  con Dependencia Severa que reciben
    la segunda Visita Domicilia Integral.';
$label[$ind]['denominador'] = 'N° de personas con dependencia severa bajo control
    en el Programa de Atención Domiciliaria para personas con dependencia severa.';
$label[$ind]['fuente_numerador'] = 'REM';
$label[$ind]['fuente_denominador'] = 'REM P';
$label[$ind]['ponderacion'] = '';

$meses = array(1,2,3,4,5,6,7,8,9,10,11,12);
$flag1 = NULL;
$flag2 = NULL;

$sql_establecimientos ='SELECT comuna, alias_estab
                        FROM 2020establecimientos
                        WHERE p_depsev = 1
                        ORDER BY comuna, id_establecimiento';

$establecimientos = DB::connection('mysql_rem')->select($sql_establecimientos);

  /* ==== Inicializar en 0 el arreglo de datos $data2020 ==== */
foreach($establecimientos as $establecimiento) {
    $data2020[$establecimiento->comuna][$ind]['numeradores']['total'] = 0;
    // $data2020[$establecimiento->comuna][$ind]['denominadores']['total'] = 0;
    $data2020[$establecimiento->comuna][$ind]['denominador'] = 0;
    $data2020[$establecimiento->comuna][$ind]['denominador_a'] = 0;
    $data2020[$establecimiento->comuna][$ind]['denominador_6'] = 0;
    $data2020[$establecimiento->comuna][$ind]['denominador_12'] = 0;
    $data2020[$establecimiento->comuna][$ind]['cumplimiento'] = 0;
    for($mes=1; $mes <= $ultimo_rem; $mes++) {
        $data2020[$establecimiento->comuna][$ind]['numeradores'][$mes] = 0;
        $data2020[$establecimiento->comuna][$ind][$establecimiento->alias_estab]['numeradores']['total'] = 0;
        $data2020[$establecimiento->comuna][$ind][$establecimiento->alias_estab]['numeradores'][$mes] = 0;

        $data2020[$establecimiento->comuna][$ind][$establecimiento->alias_estab]['denominador'] = 0;
        $data2020[$establecimiento->comuna][$ind][$establecimiento->alias_estab]['denominador_a'] = 0;
        $data2020[$establecimiento->comuna][$ind][$establecimiento->alias_estab]['denominador_6'] = 0;
        $data2020[$establecimiento->comuna][$ind][$establecimiento->alias_estab]['denominador_12'] = 0;
    }
    $data2020[$establecimiento->comuna][$ind][$establecimiento->alias_estab]['cumplimiento'] = 0;
}

$data2020['ALTO HOSPICIO'][$ind]['meta'] = '80%';
$data2020['CAMIÑA'][$ind]['meta'] = '80%';
$data2020['COLCHANE'][$ind]['meta'] = '80%';
$data2020['HUARA'][$ind]['meta'] = '80%';
$data2020['IQUIQUE'][$ind]['meta'] = '80%';
$data2020['PICA'][$ind]['meta'] = '80%';
$data2020['POZO ALMONTE'][$ind]['meta'] = '80%';

/* ===== Query numerador ===== */
$sql_numerador = "SELECT e.Comuna, e.alias_estab, r.Mes, sum(ifnull(Col09,0)) as numerador
                  FROM {$year}rems r
                  LEFT JOIN {$year}establecimientos e
                  ON r.IdEstablecimiento=e.Codigo
                  WHERE CodigoPrestacion in (26274200, 26273106, 26274400, 26261400, 26300100) AND e.p_depsev = 1
                  GROUP BY e.Comuna, e.alias_estab, r.Mes
                  ORDER BY e.Comuna, e.alias_estab, r.Mes";
$numeradores = DB::connection('mysql_rem')->select($sql_numerador);

foreach($numeradores as $registro) {
    if( ($flag1 != $registro->Comuna) OR ($flag2 != $registro->alias_estab) ) {
        for($mes=1; $mes <= $ultimo_rem; $mes++) {
            $data2020[$registro->Comuna][$ind][$registro->alias_estab]['numeradores'][$mes] = 0;
        }
        $flag1 = $registro->Comuna;
        $flag2 = $registro->alias_estab;
    }
    $data2020[$registro->Comuna][$ind][$registro->alias_estab]['numeradores'][$registro->Mes] = $registro->numerador;
}

if($ultimo_rem <= 5){
    /* ===== Query denominador ===== */
    $sql_denominador = "SELECT e.Comuna, e.alias_estab, r.Mes, sum(ifnull(Col01,0)) as denominador
                        FROM 2019rems r
                        LEFT JOIN 2019establecimientos e
                        ON r.IdEstablecimiento=e.Codigo
                        WHERE CodigoPrestacion in ('P3160800') AND e.p_depsev = 1
                        AND r.Mes = '12'
                        GROUP BY e.Comuna, e.alias_estab, r.Mes
                        ORDER BY e.Comuna, e.alias_estab, r.Mes";
    $valores = DB::connection('mysql_rem')->select($sql_denominador);

    foreach($valores as $valor) {
        $data2020[$valor->Comuna][$ind][$valor->alias_estab]['denominador_a'] = $valor->denominador;
    }
}
else{
    /* ===== Query denominador ===== */
    $sql_denominador = "SELECT e.Comuna, e.alias_estab, r.Mes, sum(ifnull(Col01,0)) as denominador
                        FROM {$year}rems r
                        LEFT JOIN {$year}establecimientos e
                        ON r.IdEstablecimiento=e.Codigo
                        WHERE CodigoPrestacion in ('P3160800') AND e.p_depsev = 1
                        AND (r.Mes = '6' OR r.Mes = '12')
                        GROUP BY e.Comuna, e.alias_estab, r.Mes
                        ORDER BY e.Comuna, e.alias_estab, r.Mes";
    $valores = DB::connection('mysql_rem')->select($sql_denominador);

    foreach($valores as $valor) {
        switch ($valor->Mes) {
            case 6:
                  $data2020[$valor->Comuna][$ind][$valor->alias_estab]['denominador_6'] = $valor->denominador;
              break;
            case 12:
                  $data2020[$valor->Comuna][$ind][$valor->alias_estab]['denominador_12'] = $valor->denominador;
              break;
        }
    }
}

/* ==== Calculos ==== */
foreach($data2020 as $nombre_comuna => $comuna) {
  foreach($comuna as $nro_ind => $indicador) {
    foreach($indicador as $nombre_establecimiento => $establecimiento) {
        /* Existe en el array un indice ['numerador'], ['denominador'] y ['meta'],
           * estos almacenan la información de la comuna, por lo tanto tengo que saltarlos
           * en la iteración del foreach y continuar con los establecimientos */
        /* Realizar los calculos mensuales */
        if($nombre_establecimiento != 'numeradores' AND
              $nombre_establecimiento != 'denominador' AND
              $nombre_establecimiento != 'denominador_a' AND
              $nombre_establecimiento != 'denominador_6' AND
              $nombre_establecimiento != 'denominador_12' AND
              $nombre_establecimiento != 'meta' AND
              $nombre_establecimiento != 'cumplimiento' AND
              $nro_ind == $ind){
            /* Calcula numeradores totales de cada establecimiento */
            $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['numeradores']['total'] = array_sum($establecimiento['numeradores']);

            /* Calcula la suma mensual de numeradores por comuna */
            for($mes=1; $mes <= $ultimo_rem; $mes++) {
                $data2020[$nombre_comuna][$ind]['numeradores'][$mes] += $establecimiento['numeradores'][$mes];
            }

            /* Calcula el numerador total de cada comuna */
            $data2020[$nombre_comuna][$ind]['numeradores']['total'] += $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['numeradores']['total'];

            /* Calcula el denominador total de cada comuna según REM */
            $data2020[$nombre_comuna][$ind]['denominador_a'] += $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['denominador_a'];
            $data2020[$nombre_comuna][$ind]['denominador_6'] += $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['denominador_6'];
            $data2020[$nombre_comuna][$ind]['denominador_12'] += $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['denominador_12'];

            //Asigna el denominador por establecimiento y comunal para los calculos.
            if($ultimo_rem <= 5){
                $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['denominador'] = $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['denominador_a'];
                $data2020[$nombre_comuna][$ind]['denominador'] = $data2020[$nombre_comuna][$ind]['denominador_a'];
            }
            elseif($ultimo_rem >= 6 && $ultimo_rem <= 11){
                $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['denominador'] = $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['denominador_6'];
                $data2020[$nombre_comuna][$ind]['denominador'] = $data2020[$nombre_comuna][$ind]['denominador_6'];
            }
            else {
                $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['denominador'] = $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['denominador_12'];
                $data2020[$nombre_comuna][$ind]['denominador'] = $data2020[$nombre_comuna][$ind]['denominador_12'];
            }

            /* Calculo de las metas de cada establecimiento */
            if($data2020[$nombre_comuna][$ind][$nombre_establecimiento]['denominador'] == 0) {
                /* Si es 0 el denominadore entonces la cumplimiento es 0 */
                $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['cumplimiento'] = 0;
            }
            else {
                $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['cumplimiento'] =
                    $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['numeradores']['total'] / $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['denominador'] * 100;
            }

            /* Calculo de las metas de la comuna */
            if($data2020[$nombre_comuna][$ind]['denominador'] == 0) {
                /* Si es 0 el denominadore entonces la cumplimiento es 0 */
                $data2020[$nombre_comuna][$ind]['cumplimiento'] = 0;
            }
            else {
                /* De lo contrario calcular el porcentaje */
                $data2020[$nombre_comuna][$ind]['cumplimiento'] = $data2020[$nombre_comuna][$ind]['numeradores']['total'] / $data2020[$nombre_comuna][$ind]['denominador'] * 100;
            }
        }
    }
  }
}

// Indicador 3
$ind = 3;
$label[$ind]['meta'] = '3-. Promedio de Visitas de Tratamiento y Seguimiento.';
$label[$ind]['numerador'] = 'N° de Visitas de Tratamiento y Seguimiento recibidas
    por personas con Dependencia Severa.';
$label[$ind]['denominador'] = 'N° de personas con dependencia severa bajo control
    en el Programa de Atención Domiciliaria para personas con dependencia severa.';
$label[$ind]['fuente_numerador'] = 'REM';
$label[$ind]['fuente_denominador'] = 'REM P';
$label[$ind]['ponderacion'] = '';

$meses = array(1,2,3,4,5,6,7,8,9,10,11,12);
$flag1 = NULL;
$flag2 = NULL;

$sql_establecimientos ='SELECT comuna, alias_estab
                        FROM 2020establecimientos
                        WHERE p_depsev = 1
                        ORDER BY comuna, id_establecimiento';

$establecimientos = DB::connection('mysql_rem')->select($sql_establecimientos);

  /* ==== Inicializar en 0 el arreglo de datos $data2020 ==== */
foreach($establecimientos as $establecimiento) {
    $data2020[$establecimiento->comuna][$ind]['numeradores']['total'] = 0;
    // $data2020[$establecimiento->comuna][$ind]['denominadores']['total'] = 0;
    $data2020[$establecimiento->comuna][$ind]['denominador'] = 0;
    $data2020[$establecimiento->comuna][$ind]['denominador_a'] = 0;
    $data2020[$establecimiento->comuna][$ind]['denominador_6'] = 0;
    $data2020[$establecimiento->comuna][$ind]['denominador_12'] = 0;
    $data2020[$establecimiento->comuna][$ind]['cumplimiento'] = 0;
    for($mes=1; $mes <= $ultimo_rem; $mes++) {
        $data2020[$establecimiento->comuna][$ind]['numeradores'][$mes] = 0;
        $data2020[$establecimiento->comuna][$ind][$establecimiento->alias_estab]['numeradores']['total'] = 0;
        $data2020[$establecimiento->comuna][$ind][$establecimiento->alias_estab]['numeradores'][$mes] = 0;

        $data2020[$establecimiento->comuna][$ind][$establecimiento->alias_estab]['denominador'] = 0;
        $data2020[$establecimiento->comuna][$ind][$establecimiento->alias_estab]['denominador_a'] = 0;
        $data2020[$establecimiento->comuna][$ind][$establecimiento->alias_estab]['denominador_6'] = 0;
        $data2020[$establecimiento->comuna][$ind][$establecimiento->alias_estab]['denominador_12'] = 0;
    }
    $data2020[$establecimiento->comuna][$ind][$establecimiento->alias_estab]['cumplimiento'] = 0;
}

$data2020['ALTO HOSPICIO'][$ind]['meta'] = 'promedio 6';
$data2020['CAMIÑA'][$ind]['meta'] = 'promedio 6';
$data2020['COLCHANE'][$ind]['meta'] = 'promedio 6';
$data2020['HUARA'][$ind]['meta'] = 'promedio 6';
$data2020['IQUIQUE'][$ind]['meta'] = 'promedio 6';
$data2020['PICA'][$ind]['meta'] = 'promedio 6';
$data2020['POZO ALMONTE'][$ind]['meta'] = 'promedio 6';

/* ===== Query numerador ===== */
$sql_numerador = "SELECT e.Comuna, e.alias_estab, r.Mes, sum(ifnull(Col10,0)) as numerador
                  FROM {$year}rems r
                  LEFT JOIN {$year}establecimientos e
                  ON r.IdEstablecimiento=e.Codigo
                  WHERE CodigoPrestacion in (26274200, 26273106, 26274400, 26261400, 26300100) AND e.p_depsev = 1
                  GROUP BY e.Comuna, e.alias_estab, r.Mes
                  ORDER BY e.Comuna, e.alias_estab, r.Mes";
$numeradores = DB::connection('mysql_rem')->select($sql_numerador);

foreach($numeradores as $registro) {
    if( ($flag1 != $registro->Comuna) OR ($flag2 != $registro->alias_estab) ) {
        for($mes=1; $mes <= $ultimo_rem; $mes++) {
            $data2020[$registro->Comuna][$ind][$registro->alias_estab]['numeradores'][$mes] = 0;
        }
        $flag1 = $registro->Comuna;
        $flag2 = $registro->alias_estab;
    }
    $data2020[$registro->Comuna][$ind][$registro->alias_estab]['numeradores'][$registro->Mes] = $registro->numerador;
}

if($ultimo_rem <= 5){
    /* ===== Query denominador ===== */
    $sql_denominador = "SELECT e.Comuna, e.alias_estab, r.Mes, sum(ifnull(Col01,0)) as denominador
                        FROM 2019rems r
                        LEFT JOIN 2019establecimientos e
                        ON r.IdEstablecimiento=e.Codigo
                        WHERE CodigoPrestacion in ('P3160800') AND e.p_depsev = 1
                        AND r.Mes = '12'
                        GROUP BY e.Comuna, e.alias_estab, r.Mes
                        ORDER BY e.Comuna, e.alias_estab, r.Mes";
    $valores = DB::connection('mysql_rem')->select($sql_denominador);

    foreach($valores as $valor) {
        $data2020[$valor->Comuna][$ind][$valor->alias_estab]['denominador_a'] = $valor->denominador;
    }
}
else{
    /* ===== Query denominador ===== */
    $sql_denominador = "SELECT e.Comuna, e.alias_estab, r.Mes, sum(ifnull(Col01,0)) as denominador
                        FROM {$year}rems r
                        LEFT JOIN {$year}establecimientos e
                        ON r.IdEstablecimiento=e.Codigo
                        WHERE CodigoPrestacion in ('P3160800') AND e.p_depsev = 1
                        AND (r.Mes = '6' OR r.Mes = '12')
                        GROUP BY e.Comuna, e.alias_estab, r.Mes
                        ORDER BY e.Comuna, e.alias_estab, r.Mes";
    $valores = DB::connection('mysql_rem')->select($sql_denominador);

    foreach($valores as $valor) {
        switch ($valor->Mes) {
            case 6:
                  $data2020[$valor->Comuna][$ind][$valor->alias_estab]['denominador_6'] = $valor->denominador;
              break;
            case 12:
                  $data2020[$valor->Comuna][$ind][$valor->alias_estab]['denominador_12'] = $valor->denominador;
              break;
        }
    }
}

/* ==== Calculos ==== */
foreach($data2020 as $nombre_comuna => $comuna) {
  foreach($comuna as $nro_ind => $indicador) {
    foreach($indicador as $nombre_establecimiento => $establecimiento) {
        /* Existe en el array un indice ['numerador'], ['denominador'] y ['meta'],
           * estos almacenan la información de la comuna, por lo tanto tengo que saltarlos
           * en la iteración del foreach y continuar con los establecimientos */
        /* Realizar los calculos mensuales */
        if($nombre_establecimiento != 'numeradores' AND
              $nombre_establecimiento != 'denominador' AND
              $nombre_establecimiento != 'denominador_a' AND
              $nombre_establecimiento != 'denominador_6' AND
              $nombre_establecimiento != 'denominador_12' AND
              $nombre_establecimiento != 'meta' AND
              $nombre_establecimiento != 'cumplimiento' AND
              $nro_ind == $ind){
            /* Calcula numeradores totales de cada establecimiento */
            $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['numeradores']['total'] = array_sum($establecimiento['numeradores']);

            /* Calcula la suma mensual de numeradores por comuna */
            for($mes=1; $mes <= $ultimo_rem; $mes++) {
                $data2020[$nombre_comuna][$ind]['numeradores'][$mes] += $establecimiento['numeradores'][$mes];
            }

            /* Calcula el numerador total de cada comuna */
            $data2020[$nombre_comuna][$ind]['numeradores']['total'] += $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['numeradores']['total'];

            /* Calcula el denominador total de cada comuna según REM */
            $data2020[$nombre_comuna][$ind]['denominador_a'] += $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['denominador_a'];
            $data2020[$nombre_comuna][$ind]['denominador_6'] += $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['denominador_6'];
            $data2020[$nombre_comuna][$ind]['denominador_12'] += $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['denominador_12'];

            //Asigna el denominador por establecimiento y comunal para los calculos.
            if($ultimo_rem <= 5){
                $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['denominador'] = $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['denominador_a'];
                $data2020[$nombre_comuna][$ind]['denominador'] = $data2020[$nombre_comuna][$ind]['denominador_a'];
            }
            elseif($ultimo_rem >= 6 && $ultimo_rem <= 11){
                $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['denominador'] = $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['denominador_6'];
                $data2020[$nombre_comuna][$ind]['denominador'] = $data2020[$nombre_comuna][$ind]['denominador_6'];
            }
            else {
                $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['denominador'] = $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['denominador_12'];
                $data2020[$nombre_comuna][$ind]['denominador'] = $data2020[$nombre_comuna][$ind]['denominador_12'];
            }

            /* Calculo de las metas de cada establecimiento */
            if($data2020[$nombre_comuna][$ind][$nombre_establecimiento]['denominador'] == 0) {
                /* Si es 0 el denominadore entonces la cumplimiento es 0 */
                $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['cumplimiento'] = 0;
            }
            else {
                $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['cumplimiento'] =
                    $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['numeradores']['total'] / $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['denominador'] * 100;
            }

            /* Calculo de las metas de la comuna */
            if($data2020[$nombre_comuna][$ind]['denominador'] == 0) {
                /* Si es 0 el denominadore entonces la cumplimiento es 0 */
                $data2020[$nombre_comuna][$ind]['cumplimiento'] = 0;
            }
            else {
                /* De lo contrario calcular el porcentaje */
                $data2020[$nombre_comuna][$ind]['cumplimiento'] = $data2020[$nombre_comuna][$ind]['numeradores']['total'] / $data2020[$nombre_comuna][$ind]['denominador'] * 100;
            }
        }
    }
  }
}

// Indicador 4
$ind = 4;
$label[$ind]['meta'] = '4-. Porcentaje de personas con dependencia severa sin
    escaras.';
$label[$ind]['numerador'] = 'N° de personas con dependencia severa sin escaras.';
$label[$ind]['denominador'] = 'N° de personas con dependencia severa bajo control
    en el Programa de Atención Domiciliaria para personas con dependencia severa.';
$label[$ind]['fuente_numerador'] = 'REM P';
$label[$ind]['fuente_denominador'] = 'REM P';
$label[$ind]['ponderacion'] = '';

$meses = array(1,2,3,4,5,6,7,8,9,10,11,12);
$flag1 = NULL;
$flag2 = NULL;

$sql_establecimientos ='SELECT comuna, alias_estab
                        FROM 2020establecimientos
                        WHERE p_depsev = 1
                        ORDER BY comuna, id_establecimiento';

$establecimientos = DB::connection('mysql_rem')->select($sql_establecimientos);

  /* ==== Inicializar en 0 el arreglo de datos $data2020 ==== */
foreach($establecimientos as $establecimiento) {
    // $data2020[$establecimiento->comuna][$ind]['numeradores']['total'] = 0;
    $data2020[$establecimiento->comuna][$ind]['numerador'] = 0;
    $data2020[$establecimiento->comuna][$ind]['numerador_a'] = 0;
    $data2020[$establecimiento->comuna][$ind]['numerador_6'] = 0;
    $data2020[$establecimiento->comuna][$ind]['numerador_12'] = 0;
    // $data2020[$establecimiento->comuna][$ind]['denominadores']['total'] = 0;
    $data2020[$establecimiento->comuna][$ind]['denominador'] = 0;
    $data2020[$establecimiento->comuna][$ind]['denominador_a'] = 0;
    $data2020[$establecimiento->comuna][$ind]['denominador_6'] = 0;
    $data2020[$establecimiento->comuna][$ind]['denominador_12'] = 0;
    $data2020[$establecimiento->comuna][$ind]['cumplimiento'] = 0;
    for($mes=1; $mes <= $ultimo_rem; $mes++) {
        // $data2020[$establecimiento->comuna][$ind]['numeradores'][$mes] = 0;
        // $data2020[$establecimiento->comuna][$ind][$establecimiento->alias_estab]['numeradores']['total'] = 0;
        // $data2020[$establecimiento->comuna][$ind][$establecimiento->alias_estab]['numeradores'][$mes] = 0;

        $data2020[$establecimiento->comuna][$ind][$establecimiento->alias_estab]['numerador'] = 0;
        $data2020[$establecimiento->comuna][$ind][$establecimiento->alias_estab]['numerador_a'] = 0;
        $data2020[$establecimiento->comuna][$ind][$establecimiento->alias_estab]['numerador_6'] = 0;
        $data2020[$establecimiento->comuna][$ind][$establecimiento->alias_estab]['numerador_6_1'] = 0;
        $data2020[$establecimiento->comuna][$ind][$establecimiento->alias_estab]['numerador_6_2'] = 0;
        $data2020[$establecimiento->comuna][$ind][$establecimiento->alias_estab]['numerador_12'] = 0;
        $data2020[$establecimiento->comuna][$ind][$establecimiento->alias_estab]['numerador_12_1'] = 0;
        $data2020[$establecimiento->comuna][$ind][$establecimiento->alias_estab]['numerador_12_2'] = 0;

        $data2020[$establecimiento->comuna][$ind][$establecimiento->alias_estab]['denominador'] = 0;
        $data2020[$establecimiento->comuna][$ind][$establecimiento->alias_estab]['denominador_a'] = 0;
        $data2020[$establecimiento->comuna][$ind][$establecimiento->alias_estab]['denominador_6'] = 0;
        $data2020[$establecimiento->comuna][$ind][$establecimiento->alias_estab]['denominador_12'] = 0;
    }
    $data2020[$establecimiento->comuna][$ind][$establecimiento->alias_estab]['cumplimiento'] = 0;
}

$data2020['ALTO HOSPICIO'][$ind]['meta'] = '92%';
$data2020['CAMIÑA'][$ind]['meta'] = '92%';
$data2020['COLCHANE'][$ind]['meta'] = '92%';
$data2020['HUARA'][$ind]['meta'] = '92%';
$data2020['IQUIQUE'][$ind]['meta'] = '92%';
$data2020['PICA'][$ind]['meta'] = '92%';
$data2020['POZO ALMONTE'][$ind]['meta'] = '92%';

/* ===== Query numerador ===== */
$sql_numerador = "SELECT e.Comuna, e.alias_estab, r.Mes, sum(ifnull(Col01,0)) as numerador
                    FROM {$year}rems r
                    LEFT JOIN {$year}establecimientos e
                    ON r.IdEstablecimiento=e.Codigo
                    WHERE CodigoPrestacion in ('P3160800') AND e.p_depsev = 1
                    AND (r.Mes = '6' OR r.Mes = '12')
                    GROUP BY e.Comuna, e.alias_estab, r.Mes
                    ORDER BY e.Comuna, e.alias_estab, r.Mes";
$valores = DB::connection('mysql_rem')->select($sql_numerador);

foreach($valores as $valor) {
    switch ($valor->Mes) {
        case 6:
              $data2020[$valor->Comuna][$ind][$valor->alias_estab]['numerador_6_1'] = $valor->numerador;
          break;
        case 12;
              $data2020[$valor->Comuna][$ind][$valor->alias_estab]['numerador_12_1'] = $valor->numerador;
          break;
    }
}

/* ===== Query numerador ===== */
$sql_numerador = "SELECT e.Comuna, e.alias_estab, r.Mes, sum(ifnull(Col01,0)) as numerador
                    FROM {$year}rems r
                    LEFT JOIN {$year}establecimientos e
                    ON r.IdEstablecimiento=e.Codigo
                    WHERE CodigoPrestacion in ('P3160900') AND e.p_depsev = 1
                    AND (r.Mes = '6' OR r.Mes = '12')
                    GROUP BY e.Comuna, e.alias_estab, r.Mes
                    ORDER BY e.Comuna, e.alias_estab, r.Mes";
$valores = DB::connection('mysql_rem')->select($sql_numerador);

foreach($valores as $valor) {
    switch ($valor->Mes) {
        case 6:
              $data2020[$valor->Comuna][$ind][$valor->alias_estab]['numerador_6_2'] = $valor->numerador;
          break;
        case 12;
              $data2020[$valor->Comuna][$ind][$valor->alias_estab]['numerador_12_2'] = $valor->numerador;
          break;
    }
}

/* ===== Query denominador ===== */
$sql_denominador = "SELECT e.Comuna, e.alias_estab, r.Mes, sum(ifnull(Col01,0)) as denominador
                    FROM {$year}rems r
                    LEFT JOIN {$year}establecimientos e
                    ON r.IdEstablecimiento=e.Codigo
                    WHERE CodigoPrestacion in ('P3160800') AND e.p_depsev = 1
                    AND (r.Mes = '6' OR r.Mes = '12')
                    GROUP BY e.Comuna, e.alias_estab, r.Mes
                    ORDER BY e.Comuna, e.alias_estab, r.Mes";
$valores = DB::connection('mysql_rem')->select($sql_denominador);

foreach($valores as $valor) {
    switch ($valor->Mes) {
        case 6:
              $data2020[$valor->Comuna][$ind][$valor->alias_estab]['denominador_6'] = $valor->denominador;
          break;
        case 12:
              $data2020[$valor->Comuna][$ind][$valor->alias_estab]['denominador_12'] = $valor->denominador;
          break;
    }
}

/* ==== Calculos ==== */
foreach($data2020 as $nombre_comuna => $comuna) {
  foreach($comuna as $nro_ind => $indicador) {
    foreach($indicador as $nombre_establecimiento => $establecimiento) {
        /* Existe en el array un indice ['numerador'], ['denominador'] y ['meta'],
           * estos almacenan la información de la comuna, por lo tanto tengo que saltarlos
           * en la iteración del foreach y continuar con los establecimientos */
        /* Realizar los calculos mensuales */
        if($nombre_establecimiento != 'numerador' AND
              $nombre_establecimiento != 'numerador_a' AND
              $nombre_establecimiento != 'numerador_6' AND
              $nombre_establecimiento != 'numerador_12' AND
              $nombre_establecimiento != 'denominador' AND
              $nombre_establecimiento != 'denominador_a' AND
              $nombre_establecimiento != 'denominador_6' AND
              $nombre_establecimiento != 'denominador_12' AND
              $nombre_establecimiento != 'meta' AND
              $nombre_establecimiento != 'cumplimiento' AND
              $nro_ind == $ind){

            // dd($establecimiento);

            /* Calcula numeradores totales de cada establecimiento */
            $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['numerador_6'] = $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['numerador_6_1'] -
                $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['numerador_6_2'];

            $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['numerador_12'] = $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['numerador_12_1'] -
                $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['numerador_12_2'];

            /* Calcula el numerador total de cada comuna */
            // $data2020[$nombre_comuna][$ind]['numeradores']['total'] += $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['numeradores']['total'];

            /* Calcula el denominador total de cada comuna según REM */
            // $data2020[$nombre_comuna][$ind]['numerador_a'] += $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['numerador_a'];
            $data2020[$nombre_comuna][$ind]['numerador_6'] += $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['numerador_6'];
            $data2020[$nombre_comuna][$ind]['numerador_12'] += $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['numerador_12'];

            // $data2020[$nombre_comuna][$ind]['denominador_a'] += $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['denominador_a'];
            $data2020[$nombre_comuna][$ind]['denominador_6'] += $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['denominador_6'];
            $data2020[$nombre_comuna][$ind]['denominador_12'] += $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['denominador_12'];

            //Asigna el denominador por establecimiento y comunal para los calculos.
            // if($ultimo_rem <= 5){
            //     $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['denominador'] = $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['denominador_a'];
            //     $data2020[$nombre_comuna][$ind]['denominador'] = $data2020[$nombre_comuna][$ind]['denominador_a'];
            // }
            if($ultimo_rem >= 6 && $ultimo_rem <= 11){

                $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['denominador'] = $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['denominador_6'];
                $data2020[$nombre_comuna][$ind]['denominador'] = $data2020[$nombre_comuna][$ind]['denominador_6'];

                $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['numerador'] = $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['numerador_6'];
                $data2020[$nombre_comuna][$ind]['numerador'] = $data2020[$nombre_comuna][$ind]['numerador_6'];
            }
            elseif($ultimo_rem == 12) {
                $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['numerador'] = $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['numerador_12'];
                $data2020[$nombre_comuna][$ind]['numerador'] = $data2020[$nombre_comuna][$ind]['numerador_12'];

                $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['denominador'] = $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['denominador_12'];
                $data2020[$nombre_comuna][$ind]['denominador'] = $data2020[$nombre_comuna][$ind]['denominador_12'];
            }
            else{
                $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['numerador'] = 0;
                $data2020[$nombre_comuna][$ind]['numerador'] = 0;

                $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['denominador'] = 0;
                $data2020[$nombre_comuna][$ind]['denominador'] = 0;
            }

            /* Calculo de las metas de cada establecimiento */
            if($data2020[$nombre_comuna][$ind][$nombre_establecimiento]['denominador'] == 0) {
                /* Si es 0 el denominadore entonces la cumplimiento es 0 */
                $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['cumplimiento'] = 0;
            }
            else {
                $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['cumplimiento'] =
                    $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['numerador'] / $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['denominador'] * 100;
            }

            /* Calculo de las metas de la comuna */
            if($data2020[$nombre_comuna][$ind]['denominador'] == 0) {
                /* Si es 0 el denominadore entonces la cumplimiento es 0 */
                $data2020[$nombre_comuna][$ind]['cumplimiento'] = 0;
            }
            else {
                /* De lo contrario calcular el porcentaje */
                $data2020[$nombre_comuna][$ind]['cumplimiento'] = $data2020[$nombre_comuna][$ind]['numerador'] / $data2020[$nombre_comuna][$ind]['denominador'] * 100;
            }
        }
    }
  }
}

// Indicador 5
$ind = 5;
$label[$ind]['meta'] = '5-. Porcentaje de Cuidadoras que cuentan con Examen Preventivo
    Vigente,  acorde a OOTT Ministerial.';
$label[$ind]['numerador'] = 'N° de cuidadoras de personas con dependencia severa
    con examen de medicina preventivo vigente.';
$label[$ind]['denominador'] = 'Total de cuidadores de personas con dependencia
    severa.';
$label[$ind]['fuente_numerador'] = 'REM P';
$label[$ind]['fuente_denominador'] = 'REM P';
$label[$ind]['ponderacion'] = '';

$meses = array(1,2,3,4,5,6,7,8,9,10,11,12);
$flag1 = NULL;
$flag2 = NULL;

$sql_establecimientos ='SELECT comuna, alias_estab
                        FROM 2020establecimientos
                        WHERE p_depsev = 1
                        ORDER BY comuna, id_establecimiento';

$establecimientos = DB::connection('mysql_rem')->select($sql_establecimientos);

  /* ==== Inicializar en 0 el arreglo de datos $data2020 ==== */
foreach($establecimientos as $establecimiento) {
    // $data2020[$establecimiento->comuna][$ind]['numeradores']['total'] = 0;
    $data2020[$establecimiento->comuna][$ind]['numerador'] = 0;
    $data2020[$establecimiento->comuna][$ind]['numerador_a'] = 0;
    $data2020[$establecimiento->comuna][$ind]['numerador_6'] = 0;
    $data2020[$establecimiento->comuna][$ind]['numerador_12'] = 0;
    // $data2020[$establecimiento->comuna][$ind]['denominadores']['total'] = 0;
    $data2020[$establecimiento->comuna][$ind]['denominador'] = 0;
    $data2020[$establecimiento->comuna][$ind]['denominador_a'] = 0;
    $data2020[$establecimiento->comuna][$ind]['denominador_6'] = 0;
    $data2020[$establecimiento->comuna][$ind]['denominador_12'] = 0;
    $data2020[$establecimiento->comuna][$ind]['cumplimiento'] = 0;
    for($mes=1; $mes <= $ultimo_rem; $mes++) {
        // $data2020[$establecimiento->comuna][$ind]['numeradores'][$mes] = 0;
        // $data2020[$establecimiento->comuna][$ind][$establecimiento->alias_estab]['numeradores']['total'] = 0;
        // $data2020[$establecimiento->comuna][$ind][$establecimiento->alias_estab]['numeradores'][$mes] = 0;

        $data2020[$establecimiento->comuna][$ind][$establecimiento->alias_estab]['numerador'] = 0;
        $data2020[$establecimiento->comuna][$ind][$establecimiento->alias_estab]['numerador_a'] = 0;
        $data2020[$establecimiento->comuna][$ind][$establecimiento->alias_estab]['numerador_6'] = 0;
        $data2020[$establecimiento->comuna][$ind][$establecimiento->alias_estab]['numerador_12'] = 0;

        $data2020[$establecimiento->comuna][$ind][$establecimiento->alias_estab]['denominador'] = 0;
        $data2020[$establecimiento->comuna][$ind][$establecimiento->alias_estab]['denominador_a'] = 0;
        $data2020[$establecimiento->comuna][$ind][$establecimiento->alias_estab]['denominador_6'] = 0;
        $data2020[$establecimiento->comuna][$ind][$establecimiento->alias_estab]['denominador_12'] = 0;
    }
    $data2020[$establecimiento->comuna][$ind][$establecimiento->alias_estab]['cumplimiento'] = 0;
}

$data2020['ALTO HOSPICIO'][$ind]['meta'] = '75%';
$data2020['CAMIÑA'][$ind]['meta'] = '75%';
$data2020['COLCHANE'][$ind]['meta'] = '75%';
$data2020['HUARA'][$ind]['meta'] = '75%';
$data2020['IQUIQUE'][$ind]['meta'] = '75%';
$data2020['PICA'][$ind]['meta'] = '75%';
$data2020['POZO ALMONTE'][$ind]['meta'] = '75%';

/* ===== Query numerador ===== */
$sql_numerador = "SELECT e.Comuna, e.alias_estab, r.Mes, sum(ifnull(Col03,0)) as numerador
                    FROM {$year}rems r
                    LEFT JOIN {$year}establecimientos e
                    ON r.IdEstablecimiento=e.Codigo
                    WHERE CodigoPrestacion in ('P5300600') AND e.p_depsev = 1
                    AND (r.Mes = '6' OR r.Mes = '12')
                    GROUP BY e.Comuna, e.alias_estab, r.Mes
                    ORDER BY e.Comuna, e.alias_estab, r.Mes";
$valores = DB::connection('mysql_rem')->select($sql_numerador);

foreach($valores as $valor) {
    switch ($valor->Mes) {
        case 6:
              $data2020[$valor->Comuna][$ind][$valor->alias_estab]['numerador_6'] = $valor->numerador;
          break;
        case 12;
              $data2020[$valor->Comuna][$ind][$valor->alias_estab]['numerador_12'] = $valor->numerador;
          break;
    }
}

/* ===== Query denominador ===== */
$sql_denominador = "SELECT e.Comuna, e.alias_estab, r.Mes, sum(ifnull(Col01,0)) as denominador
                    FROM {$year}rems r
                    LEFT JOIN {$year}establecimientos e
                    ON r.IdEstablecimiento=e.Codigo
                    WHERE CodigoPrestacion in ('P5300600') AND e.p_depsev = 1
                    AND (r.Mes = '6' OR r.Mes = '12')
                    GROUP BY e.Comuna, e.alias_estab, r.Mes
                    ORDER BY e.Comuna, e.alias_estab, r.Mes";
$valores = DB::connection('mysql_rem')->select($sql_denominador);

foreach($valores as $valor) {
    switch ($valor->Mes) {
        case 6:
              $data2020[$valor->Comuna][$ind][$valor->alias_estab]['denominador_6'] = $valor->denominador;
          break;
        case 12:
              $data2020[$valor->Comuna][$ind][$valor->alias_estab]['denominador_12'] = $valor->denominador;
          break;
    }
}

/* ==== Calculos ==== */
foreach($data2020 as $nombre_comuna => $comuna) {
  foreach($comuna as $nro_ind => $indicador) {
    foreach($indicador as $nombre_establecimiento => $establecimiento) {
        /* Existe en el array un indice ['numerador'], ['denominador'] y ['meta'],
           * estos almacenan la información de la comuna, por lo tanto tengo que saltarlos
           * en la iteración del foreach y continuar con los establecimientos */
        /* Realizar los calculos mensuales */
        if($nombre_establecimiento != 'numerador' AND
              $nombre_establecimiento != 'numerador_a' AND
              $nombre_establecimiento != 'numerador_6' AND
              $nombre_establecimiento != 'numerador_12' AND
              $nombre_establecimiento != 'denominador' AND
              $nombre_establecimiento != 'denominador_a' AND
              $nombre_establecimiento != 'denominador_6' AND
              $nombre_establecimiento != 'denominador_12' AND
              $nombre_establecimiento != 'meta' AND
              $nombre_establecimiento != 'cumplimiento' AND
              $nro_ind == $ind){

            $data2020[$nombre_comuna][$ind]['numerador_6'] += $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['numerador_6'];
            $data2020[$nombre_comuna][$ind]['numerador_12'] += $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['numerador_12'];

            $data2020[$nombre_comuna][$ind]['denominador_6'] += $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['denominador_6'];
            $data2020[$nombre_comuna][$ind]['denominador_12'] += $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['denominador_12'];

            if($ultimo_rem >= 6 && $ultimo_rem <= 11){

                $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['denominador'] = $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['denominador_6'];
                $data2020[$nombre_comuna][$ind]['denominador'] = $data2020[$nombre_comuna][$ind]['denominador_6'];

                $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['numerador'] = $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['numerador_6'];
                $data2020[$nombre_comuna][$ind]['numerador'] = $data2020[$nombre_comuna][$ind]['numerador_6'];
            }
            elseif($ultimo_rem == 12) {
                $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['numerador'] = $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['numerador_12'];
                $data2020[$nombre_comuna][$ind]['numerador'] = $data2020[$nombre_comuna][$ind]['numerador_12'];

                $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['denominador'] = $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['denominador_12'];
                $data2020[$nombre_comuna][$ind]['denominador'] = $data2020[$nombre_comuna][$ind]['denominador_12'];
            }
            else{
                $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['numerador'] = 0;
                $data2020[$nombre_comuna][$ind]['numerador'] = 0;

                $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['denominador'] = 0;
                $data2020[$nombre_comuna][$ind]['denominador'] = 0;
            }

            /* Calculo de las metas de cada establecimiento */
            if($data2020[$nombre_comuna][$ind][$nombre_establecimiento]['denominador'] == 0) {
                /* Si es 0 el denominadore entonces la cumplimiento es 0 */
                $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['cumplimiento'] = 0;
            }
            else {
                $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['cumplimiento'] =
                    $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['numerador'] / $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['denominador'] * 100;
            }

            /* Calculo de las metas de la comuna */
            if($data2020[$nombre_comuna][$ind]['denominador'] == 0) {
                /* Si es 0 el denominadore entonces la cumplimiento es 0 */
                $data2020[$nombre_comuna][$ind]['cumplimiento'] = 0;
            }
            else {
                /* De lo contrario calcular el porcentaje */
                $data2020[$nombre_comuna][$ind]['cumplimiento'] = $data2020[$nombre_comuna][$ind]['numerador'] / $data2020[$nombre_comuna][$ind]['denominador'] * 100;
            }
        }
    }
  }
}

// Indicador 6
$ind = 6;
$label[$ind]['meta'] = '6-. Porcentaje de personas con indicación de NED reciben
    atención Nutricional en Domicilio.';
$label[$ind]['numerador'] = 'Nº de atenciones nutricionales en domicilio para personas
    del Programa de Atención Domiciliaria para Personas con Dependencia Severa
    con indicación de NED.';
$label[$ind]['denominador'] = 'N° total de personas con dependencia severa con
    indicación de NED.';
$label[$ind]['fuente_numerador'] = 'REM';
$label[$ind]['fuente_denominador'] = 'REM P';
$label[$ind]['ponderacion'] = '';

$meses = array(1,2,3,4,5,6,7,8,9,10,11,12);
$flag1 = NULL;
$flag2 = NULL;

$sql_establecimientos ='SELECT comuna, alias_estab
                        FROM 2020establecimientos
                        WHERE p_depsev = 1
                        ORDER BY comuna, id_establecimiento';

$establecimientos = DB::connection('mysql_rem')->select($sql_establecimientos);

  /* ==== Inicializar en 0 el arreglo de datos $data2020 ==== */
foreach($establecimientos as $establecimiento) {
    $data2020[$establecimiento->comuna][$ind]['numeradores']['total'] = 0;
    // $data2020[$establecimiento->comuna][$ind]['denominadores']['total'] = 0;
    $data2020[$establecimiento->comuna][$ind]['denominador'] = 0;
    $data2020[$establecimiento->comuna][$ind]['denominador_a'] = 0;
    $data2020[$establecimiento->comuna][$ind]['denominador_6'] = 0;
    $data2020[$establecimiento->comuna][$ind]['denominador_12'] = 0;
    $data2020[$establecimiento->comuna][$ind]['cumplimiento'] = 0;
    for($mes=1; $mes <= $ultimo_rem; $mes++) {
        $data2020[$establecimiento->comuna][$ind]['numeradores'][$mes] = 0;
        $data2020[$establecimiento->comuna][$ind][$establecimiento->alias_estab]['numeradores']['total'] = 0;
        $data2020[$establecimiento->comuna][$ind][$establecimiento->alias_estab]['numeradores'][$mes] = 0;

        $data2020[$establecimiento->comuna][$ind][$establecimiento->alias_estab]['denominador'] = 0;
        $data2020[$establecimiento->comuna][$ind][$establecimiento->alias_estab]['denominador_a'] = 0;
        $data2020[$establecimiento->comuna][$ind][$establecimiento->alias_estab]['denominador_6'] = 0;
        $data2020[$establecimiento->comuna][$ind][$establecimiento->alias_estab]['denominador_12'] = 0;
    }
    $data2020[$establecimiento->comuna][$ind][$establecimiento->alias_estab]['cumplimiento'] = 0;
}

$data2020['ALTO HOSPICIO'][$ind]['meta'] = '100%';
$data2020['CAMIÑA'][$ind]['meta'] = '100%';
$data2020['COLCHANE'][$ind]['meta'] = '100%';
$data2020['HUARA'][$ind]['meta'] = '100%';
$data2020['IQUIQUE'][$ind]['meta'] = '100%';
$data2020['PICA'][$ind]['meta'] = '100%';
$data2020['POZO ALMONTE'][$ind]['meta'] = '100%';

/* ===== Query numerador ===== */
$sql_numerador = "SELECT e.Comuna, e.alias_estab, r.Mes, sum(ifnull(Col01,0)) as numerador
                  FROM {$year}rems r
                  LEFT JOIN {$year}establecimientos e
                  ON r.IdEstablecimiento=e.Codigo
                  WHERE CodigoPrestacion in (26300150) AND e.p_depsev = 1
                  GROUP BY e.Comuna, e.alias_estab, r.Mes
                  ORDER BY e.Comuna, e.alias_estab, r.Mes";
$numeradores = DB::connection('mysql_rem')->select($sql_numerador);

foreach($numeradores as $registro) {
    if( ($flag1 != $registro->Comuna) OR ($flag2 != $registro->alias_estab) ) {
        for($mes=1; $mes <= $ultimo_rem; $mes++) {
            $data2020[$registro->Comuna][$ind][$registro->alias_estab]['numeradores'][$mes] = 0;
        }
        $flag1 = $registro->Comuna;
        $flag2 = $registro->alias_estab;
    }
    $data2020[$registro->Comuna][$ind][$registro->alias_estab]['numeradores'][$registro->Mes] = $registro->numerador;
}

if($ultimo_rem <= 5){
    /* ===== Query denominador ===== */
    $sql_denominador = "SELECT e.Comuna, e.alias_estab, r.Mes, sum(ifnull(Col01,0)) as denominador
                        FROM 2019rems r
                        LEFT JOIN 2019establecimientos e
                        ON r.IdEstablecimiento=e.Codigo
                        WHERE CodigoPrestacion in ('P3170200') AND e.p_depsev = 1
                        AND r.Mes = '12'
                        GROUP BY e.Comuna, e.alias_estab, r.Mes
                        ORDER BY e.Comuna, e.alias_estab, r.Mes";
    $valores = DB::connection('mysql_rem')->select($sql_denominador);

    foreach($valores as $valor) {
        $data2020[$valor->Comuna][$ind][$valor->alias_estab]['denominador_a'] = $valor->denominador;
    }
}
else{
    /* ===== Query denominador ===== */
    $sql_denominador = "SELECT e.Comuna, e.alias_estab, r.Mes, sum(ifnull(Col01,0)) as denominador
                        FROM {$year}rems r
                        LEFT JOIN {$year}establecimientos e
                        ON r.IdEstablecimiento=e.Codigo
                        WHERE CodigoPrestacion in ('P3170200') AND e.p_depsev = 1
                        AND (r.Mes = '6' OR r.Mes = '12')
                        GROUP BY e.Comuna, e.alias_estab, r.Mes
                        ORDER BY e.Comuna, e.alias_estab, r.Mes";
    $valores = DB::connection('mysql_rem')->select($sql_denominador);

    foreach($valores as $valor) {
        switch ($valor->Mes) {
            case 6:
                  $data2020[$valor->Comuna][$ind][$valor->alias_estab]['denominador_6'] = $valor->denominador;
              break;
            case 12:
                  $data2020[$valor->Comuna][$ind][$valor->alias_estab]['denominador_12'] = $valor->denominador;
              break;
        }
    }
}

/* ==== Calculos ==== */
foreach($data2020 as $nombre_comuna => $comuna) {
  foreach($comuna as $nro_ind => $indicador) {
    foreach($indicador as $nombre_establecimiento => $establecimiento) {
        /* Existe en el array un indice ['numerador'], ['denominador'] y ['meta'],
           * estos almacenan la información de la comuna, por lo tanto tengo que saltarlos
           * en la iteración del foreach y continuar con los establecimientos */
        /* Realizar los calculos mensuales */
        if($nombre_establecimiento != 'numeradores' AND
              $nombre_establecimiento != 'denominador' AND
              $nombre_establecimiento != 'denominador_a' AND
              $nombre_establecimiento != 'denominador_6' AND
              $nombre_establecimiento != 'denominador_12' AND
              $nombre_establecimiento != 'meta' AND
              $nombre_establecimiento != 'cumplimiento' AND
              $nro_ind == $ind){
            /* Calcula numeradores totales de cada establecimiento */
            $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['numeradores']['total'] = array_sum($establecimiento['numeradores']);

            /* Calcula la suma mensual de numeradores por comuna */
            for($mes=1; $mes <= $ultimo_rem; $mes++) {
                $data2020[$nombre_comuna][$ind]['numeradores'][$mes] += $establecimiento['numeradores'][$mes];
            }

            /* Calcula el numerador total de cada comuna */
            $data2020[$nombre_comuna][$ind]['numeradores']['total'] += $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['numeradores']['total'];

            /* Calcula el denominador total de cada comuna según REM */
            $data2020[$nombre_comuna][$ind]['denominador_a'] += $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['denominador_a'];
            $data2020[$nombre_comuna][$ind]['denominador_6'] += $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['denominador_6'];
            $data2020[$nombre_comuna][$ind]['denominador_12'] += $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['denominador_12'];

            //Asigna el denominador por establecimiento y comunal para los calculos.
            if($ultimo_rem <= 5){
                $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['denominador'] = $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['denominador_a'];
                $data2020[$nombre_comuna][$ind]['denominador'] = $data2020[$nombre_comuna][$ind]['denominador_a'];
            }
            elseif($ultimo_rem >= 6 && $ultimo_rem <= 11){
                $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['denominador'] = $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['denominador_6'];
                $data2020[$nombre_comuna][$ind]['denominador'] = $data2020[$nombre_comuna][$ind]['denominador_6'];
            }
            else {
                $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['denominador'] = $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['denominador_12'];
                $data2020[$nombre_comuna][$ind]['denominador'] = $data2020[$nombre_comuna][$ind]['denominador_12'];
            }

            /* Calculo de las metas de cada establecimiento */
            if($data2020[$nombre_comuna][$ind][$nombre_establecimiento]['denominador'] == 0) {
                /* Si es 0 el denominadore entonces la cumplimiento es 0 */
                $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['cumplimiento'] = 0;
            }
            else {
                $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['cumplimiento'] =
                    $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['numeradores']['total'] / $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['denominador'] * 100;
            }

            /* Calculo de las metas de la comuna */
            if($data2020[$nombre_comuna][$ind]['denominador'] == 0) {
                /* Si es 0 el denominadore entonces la cumplimiento es 0 */
                $data2020[$nombre_comuna][$ind]['cumplimiento'] = 0;
            }
            else {
                /* De lo contrario calcular el porcentaje */
                $data2020[$nombre_comuna][$ind]['cumplimiento'] = $data2020[$nombre_comuna][$ind]['numeradores']['total'] / $data2020[$nombre_comuna][$ind]['denominador'] * 100;
            }
        }
    }
  }
}

// Indicador 7
$ind = 7;
$label[$ind]['meta'] = '7-. Porcentaje de Cuidadoras/es de personas con dependencia
    severa del Programa evaluados con Escala de Zarit.';
$label[$ind]['numerador'] = 'N° de cuidadores de personas con dependencia severa
    del Programa de Atención Domiciliara para personas con Dependencia severa evaluados
     con Escala de Zarit.';
$label[$ind]['denominador'] = 'N° de cuidadores de personas con dependencia severa
    del Programa de Atención Domiciliaria para personas con dependencia severa.';
$label[$ind]['fuente_numerador'] = 'REM';
$label[$ind]['fuente_denominador'] = 'REM P';
$label[$ind]['ponderacion'] = '';

$meses = array(1,2,3,4,5,6,7,8,9,10,11,12);
$flag1 = NULL;
$flag2 = NULL;

$sql_establecimientos ='SELECT comuna, alias_estab
                        FROM 2020establecimientos
                        WHERE p_depsev = 1
                        ORDER BY comuna, id_establecimiento';

$establecimientos = DB::connection('mysql_rem')->select($sql_establecimientos);

  /* ==== Inicializar en 0 el arreglo de datos $data2020 ==== */
foreach($establecimientos as $establecimiento) {
    $data2020[$establecimiento->comuna][$ind]['numeradores']['total'] = 0;
    // $data2020[$establecimiento->comuna][$ind]['denominadores']['total'] = 0;
    $data2020[$establecimiento->comuna][$ind]['denominador'] = 0;
    $data2020[$establecimiento->comuna][$ind]['denominador_a'] = 0;
    $data2020[$establecimiento->comuna][$ind]['denominador_6'] = 0;
    $data2020[$establecimiento->comuna][$ind]['denominador_12'] = 0;
    $data2020[$establecimiento->comuna][$ind]['cumplimiento'] = 0;
    for($mes=1; $mes <= $ultimo_rem; $mes++) {
        $data2020[$establecimiento->comuna][$ind]['numeradores'][$mes] = 0;
        $data2020[$establecimiento->comuna][$ind][$establecimiento->alias_estab]['numeradores']['total'] = 0;
        $data2020[$establecimiento->comuna][$ind][$establecimiento->alias_estab]['numeradores'][$mes] = 0;

        $data2020[$establecimiento->comuna][$ind][$establecimiento->alias_estab]['denominador'] = 0;
        $data2020[$establecimiento->comuna][$ind][$establecimiento->alias_estab]['denominador_a'] = 0;
        $data2020[$establecimiento->comuna][$ind][$establecimiento->alias_estab]['denominador_6'] = 0;
        $data2020[$establecimiento->comuna][$ind][$establecimiento->alias_estab]['denominador_12'] = 0;
    }
    $data2020[$establecimiento->comuna][$ind][$establecimiento->alias_estab]['cumplimiento'] = 0;
}

$data2020['ALTO HOSPICIO'][$ind]['meta'] = '80%';
$data2020['CAMIÑA'][$ind]['meta'] = '80%';
$data2020['COLCHANE'][$ind]['meta'] = '80%';
$data2020['HUARA'][$ind]['meta'] = '80%';
$data2020['IQUIQUE'][$ind]['meta'] = '80%';
$data2020['PICA'][$ind]['meta'] = '80%';
$data2020['POZO ALMONTE'][$ind]['meta'] = '80%';

/* ===== Query numerador ===== */
$sql_numerador = "SELECT e.Comuna, e.alias_estab, r.Mes, sum(ifnull(Col01,0)) as numerador
                  FROM {$year}rems r
                  LEFT JOIN {$year}establecimientos e
                  ON r.IdEstablecimiento=e.Codigo
                  WHERE CodigoPrestacion in (03500361, 03500362) AND e.p_depsev = 1
                  GROUP BY e.Comuna, e.alias_estab, r.Mes
                  ORDER BY e.Comuna, e.alias_estab, r.Mes";
$numeradores = DB::connection('mysql_rem')->select($sql_numerador);

foreach($numeradores as $registro) {
    if( ($flag1 != $registro->Comuna) OR ($flag2 != $registro->alias_estab) ) {
        for($mes=1; $mes <= $ultimo_rem; $mes++) {
            $data2020[$registro->Comuna][$ind][$registro->alias_estab]['numeradores'][$mes] = 0;
        }
        $flag1 = $registro->Comuna;
        $flag2 = $registro->alias_estab;
    }
    $data2020[$registro->Comuna][$ind][$registro->alias_estab]['numeradores'][$registro->Mes] = $registro->numerador;
}

if($ultimo_rem <= 5){
    /* ===== Query denominador ===== */
    $sql_denominador = "SELECT e.Comuna, e.alias_estab, r.Mes, sum(ifnull(Col01,0)) as denominador
                        FROM 2019rems r
                        LEFT JOIN 2019establecimientos e
                        ON r.IdEstablecimiento=e.Codigo
                        WHERE CodigoPrestacion in ('P5300600') AND e.p_depsev = 1
                        AND r.Mes = '12'
                        GROUP BY e.Comuna, e.alias_estab, r.Mes
                        ORDER BY e.Comuna, e.alias_estab, r.Mes";
    $valores = DB::connection('mysql_rem')->select($sql_denominador);

    foreach($valores as $valor) {
        $data2020[$valor->Comuna][$ind][$valor->alias_estab]['denominador_a'] = $valor->denominador;
    }
}
else{
    /* ===== Query denominador ===== */
    $sql_denominador = "SELECT e.Comuna, e.alias_estab, r.Mes, sum(ifnull(Col01,0)) as denominador
                        FROM {$year}rems r
                        LEFT JOIN {$year}establecimientos e
                        ON r.IdEstablecimiento=e.Codigo
                        WHERE CodigoPrestacion in ('P5300600') AND e.p_depsev = 1
                        AND (r.Mes = '6' OR r.Mes = '12')
                        GROUP BY e.Comuna, e.alias_estab, r.Mes
                        ORDER BY e.Comuna, e.alias_estab, r.Mes";
    $valores = DB::connection('mysql_rem')->select($sql_denominador);

    foreach($valores as $valor) {
        switch ($valor->Mes) {
            case 6:
                  $data2020[$valor->Comuna][$ind][$valor->alias_estab]['denominador_6'] = $valor->denominador;
              break;
            case 12:
                  $data2020[$valor->Comuna][$ind][$valor->alias_estab]['denominador_12'] = $valor->denominador;
              break;
        }
    }
}

/* ==== Calculos ==== */
foreach($data2020 as $nombre_comuna => $comuna) {
  foreach($comuna as $nro_ind => $indicador) {
    foreach($indicador as $nombre_establecimiento => $establecimiento) {
        /* Existe en el array un indice ['numerador'], ['denominador'] y ['meta'],
           * estos almacenan la información de la comuna, por lo tanto tengo que saltarlos
           * en la iteración del foreach y continuar con los establecimientos */
        /* Realizar los calculos mensuales */
        if($nombre_establecimiento != 'numeradores' AND
              $nombre_establecimiento != 'denominador' AND
              $nombre_establecimiento != 'denominador_a' AND
              $nombre_establecimiento != 'denominador_6' AND
              $nombre_establecimiento != 'denominador_12' AND
              $nombre_establecimiento != 'meta' AND
              $nombre_establecimiento != 'cumplimiento' AND
              $nro_ind == $ind){
            /* Calcula numeradores totales de cada establecimiento */
            $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['numeradores']['total'] = array_sum($establecimiento['numeradores']);

            /* Calcula la suma mensual de numeradores por comuna */
            for($mes=1; $mes <= $ultimo_rem; $mes++) {
                $data2020[$nombre_comuna][$ind]['numeradores'][$mes] += $establecimiento['numeradores'][$mes];
            }

            /* Calcula el numerador total de cada comuna */
            $data2020[$nombre_comuna][$ind]['numeradores']['total'] += $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['numeradores']['total'];

            /* Calcula el denominador total de cada comuna según REM */
            $data2020[$nombre_comuna][$ind]['denominador_a'] += $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['denominador_a'];
            $data2020[$nombre_comuna][$ind]['denominador_6'] += $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['denominador_6'];
            $data2020[$nombre_comuna][$ind]['denominador_12'] += $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['denominador_12'];

            //Asigna el denominador por establecimiento y comunal para los calculos.
            if($ultimo_rem <= 5){
                $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['denominador'] = $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['denominador_a'];
                $data2020[$nombre_comuna][$ind]['denominador'] = $data2020[$nombre_comuna][$ind]['denominador_a'];
            }
            elseif($ultimo_rem >= 6 && $ultimo_rem <= 11){
                $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['denominador'] = $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['denominador_6'];
                $data2020[$nombre_comuna][$ind]['denominador'] = $data2020[$nombre_comuna][$ind]['denominador_6'];
            }
            else {
                $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['denominador'] = $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['denominador_12'];
                $data2020[$nombre_comuna][$ind]['denominador'] = $data2020[$nombre_comuna][$ind]['denominador_12'];
            }

            /* Calculo de las metas de cada establecimiento */
            if($data2020[$nombre_comuna][$ind][$nombre_establecimiento]['denominador'] == 0) {
                /* Si es 0 el denominadore entonces la cumplimiento es 0 */
                $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['cumplimiento'] = 0;
            }
            else {
                $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['cumplimiento'] =
                    $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['numeradores']['total'] / $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['denominador'] * 100;
            }

            /* Calculo de las metas de la comuna */
            if($data2020[$nombre_comuna][$ind]['denominador'] == 0) {
                /* Si es 0 el denominadore entonces la cumplimiento es 0 */
                $data2020[$nombre_comuna][$ind]['cumplimiento'] = 0;
            }
            else {
                /* De lo contrario calcular el porcentaje */
                $data2020[$nombre_comuna][$ind]['cumplimiento'] = $data2020[$nombre_comuna][$ind]['numeradores']['total'] / $data2020[$nombre_comuna][$ind]['denominador'] * 100;
            }
        }
    }
  }
}

// Indicador 5
$ind = 8;
$label[$ind]['meta'] = '8-. Porcentaje de Cuidadoras capacitados.';
$label[$ind]['numerador'] = 'N° de cuidadores capacitados por el programa de atención
    domiciliaria para personas con dependencia severa.';
$label[$ind]['denominador'] = 'N° de  cuidadoras(es) de personas con dependencia severa.';
$label[$ind]['fuente_numerador'] = 'REM P';
$label[$ind]['fuente_denominador'] = 'REM P';
$label[$ind]['ponderacion'] = '';

$meses = array(1,2,3,4,5,6,7,8,9,10,11,12);
$flag1 = NULL;
$flag2 = NULL;

$sql_establecimientos ='SELECT comuna, alias_estab
                        FROM 2020establecimientos
                        WHERE p_depsev = 1
                        ORDER BY comuna, id_establecimiento';

$establecimientos = DB::connection('mysql_rem')->select($sql_establecimientos);

  /* ==== Inicializar en 0 el arreglo de datos $data2020 ==== */
foreach($establecimientos as $establecimiento) {
    // $data2020[$establecimiento->comuna][$ind]['numeradores']['total'] = 0;
    $data2020[$establecimiento->comuna][$ind]['numerador'] = 0;
    $data2020[$establecimiento->comuna][$ind]['numerador_a'] = 0;
    $data2020[$establecimiento->comuna][$ind]['numerador_6'] = 0;
    $data2020[$establecimiento->comuna][$ind]['numerador_12'] = 0;
    // $data2020[$establecimiento->comuna][$ind]['denominadores']['total'] = 0;
    $data2020[$establecimiento->comuna][$ind]['denominador'] = 0;
    $data2020[$establecimiento->comuna][$ind]['denominador_a'] = 0;
    $data2020[$establecimiento->comuna][$ind]['denominador_6'] = 0;
    $data2020[$establecimiento->comuna][$ind]['denominador_12'] = 0;
    $data2020[$establecimiento->comuna][$ind]['cumplimiento'] = 0;
    for($mes=1; $mes <= $ultimo_rem; $mes++) {
        // $data2020[$establecimiento->comuna][$ind]['numeradores'][$mes] = 0;
        // $data2020[$establecimiento->comuna][$ind][$establecimiento->alias_estab]['numeradores']['total'] = 0;
        // $data2020[$establecimiento->comuna][$ind][$establecimiento->alias_estab]['numeradores'][$mes] = 0;

        $data2020[$establecimiento->comuna][$ind][$establecimiento->alias_estab]['numerador'] = 0;
        $data2020[$establecimiento->comuna][$ind][$establecimiento->alias_estab]['numerador_a'] = 0;
        $data2020[$establecimiento->comuna][$ind][$establecimiento->alias_estab]['numerador_6'] = 0;
        $data2020[$establecimiento->comuna][$ind][$establecimiento->alias_estab]['numerador_12'] = 0;

        $data2020[$establecimiento->comuna][$ind][$establecimiento->alias_estab]['denominador'] = 0;
        $data2020[$establecimiento->comuna][$ind][$establecimiento->alias_estab]['denominador_a'] = 0;
        $data2020[$establecimiento->comuna][$ind][$establecimiento->alias_estab]['denominador_6'] = 0;
        $data2020[$establecimiento->comuna][$ind][$establecimiento->alias_estab]['denominador_12'] = 0;
    }
    $data2020[$establecimiento->comuna][$ind][$establecimiento->alias_estab]['cumplimiento'] = 0;
}

$data2020['ALTO HOSPICIO'][$ind]['meta'] = '';
$data2020['CAMIÑA'][$ind]['meta'] = '';
$data2020['COLCHANE'][$ind]['meta'] = '';
$data2020['HUARA'][$ind]['meta'] = '';
$data2020['IQUIQUE'][$ind]['meta'] = '';
$data2020['PICA'][$ind]['meta'] = '';
$data2020['POZO ALMONTE'][$ind]['meta'] = '';

/* ===== Query numerador ===== */
$sql_numerador = "SELECT e.Comuna, e.alias_estab, r.Mes, sum(ifnull(Col02,0)) as numerador
                    FROM {$year}rems r
                    LEFT JOIN {$year}establecimientos e
                    ON r.IdEstablecimiento=e.Codigo
                    WHERE CodigoPrestacion in ('P5300600') AND e.p_depsev = 1
                    AND (r.Mes = '6' OR r.Mes = '12')
                    GROUP BY e.Comuna, e.alias_estab, r.Mes
                    ORDER BY e.Comuna, e.alias_estab, r.Mes";
$valores = DB::connection('mysql_rem')->select($sql_numerador);

foreach($valores as $valor) {
    switch ($valor->Mes) {
        case 6:
              $data2020[$valor->Comuna][$ind][$valor->alias_estab]['numerador_6'] = $valor->numerador;
          break;
        case 12;
              $data2020[$valor->Comuna][$ind][$valor->alias_estab]['numerador_12'] = $valor->numerador;
          break;
    }
}

/* ===== Query denominador ===== */
$sql_denominador = "SELECT e.Comuna, e.alias_estab, r.Mes, sum(ifnull(Col01,0)) as denominador
                    FROM {$year}rems r
                    LEFT JOIN {$year}establecimientos e
                    ON r.IdEstablecimiento=e.Codigo
                    WHERE CodigoPrestacion in ('P5300600') AND e.p_depsev = 1
                    AND (r.Mes = '6' OR r.Mes = '12')
                    GROUP BY e.Comuna, e.alias_estab, r.Mes
                    ORDER BY e.Comuna, e.alias_estab, r.Mes";
$valores = DB::connection('mysql_rem')->select($sql_denominador);

foreach($valores as $valor) {
    switch ($valor->Mes) {
        case 6:
              $data2020[$valor->Comuna][$ind][$valor->alias_estab]['denominador_6'] = $valor->denominador;
          break;
        case 12:
              $data2020[$valor->Comuna][$ind][$valor->alias_estab]['denominador_12'] = $valor->denominador;
          break;
    }
}

/* ==== Calculos ==== */
foreach($data2020 as $nombre_comuna => $comuna) {
  foreach($comuna as $nro_ind => $indicador) {
    foreach($indicador as $nombre_establecimiento => $establecimiento) {
        /* Existe en el array un indice ['numerador'], ['denominador'] y ['meta'],
           * estos almacenan la información de la comuna, por lo tanto tengo que saltarlos
           * en la iteración del foreach y continuar con los establecimientos */
        /* Realizar los calculos mensuales */
        if($nombre_establecimiento != 'numerador' AND
              $nombre_establecimiento != 'numerador_a' AND
              $nombre_establecimiento != 'numerador_6' AND
              $nombre_establecimiento != 'numerador_12' AND
              $nombre_establecimiento != 'denominador' AND
              $nombre_establecimiento != 'denominador_a' AND
              $nombre_establecimiento != 'denominador_6' AND
              $nombre_establecimiento != 'denominador_12' AND
              $nombre_establecimiento != 'meta' AND
              $nombre_establecimiento != 'cumplimiento' AND
              $nro_ind == $ind){

            $data2020[$nombre_comuna][$ind]['numerador_6'] += $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['numerador_6'];
            $data2020[$nombre_comuna][$ind]['numerador_12'] += $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['numerador_12'];

            $data2020[$nombre_comuna][$ind]['denominador_6'] += $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['denominador_6'];
            $data2020[$nombre_comuna][$ind]['denominador_12'] += $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['denominador_12'];

            if($ultimo_rem >= 6 && $ultimo_rem <= 11){

                $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['denominador'] = $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['denominador_6'];
                $data2020[$nombre_comuna][$ind]['denominador'] = $data2020[$nombre_comuna][$ind]['denominador_6'];

                $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['numerador'] = $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['numerador_6'];
                $data2020[$nombre_comuna][$ind]['numerador'] = $data2020[$nombre_comuna][$ind]['numerador_6'];
            }
            elseif($ultimo_rem == 12) {
                $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['numerador'] = $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['numerador_12'];
                $data2020[$nombre_comuna][$ind]['numerador'] = $data2020[$nombre_comuna][$ind]['numerador_12'];

                $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['denominador'] = $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['denominador_12'];
                $data2020[$nombre_comuna][$ind]['denominador'] = $data2020[$nombre_comuna][$ind]['denominador_12'];
            }
            else{
                $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['numerador'] = 0;
                $data2020[$nombre_comuna][$ind]['numerador'] = 0;

                $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['denominador'] = 0;
                $data2020[$nombre_comuna][$ind]['denominador'] = 0;
            }

            /* Calculo de las metas de cada establecimiento */
            if($data2020[$nombre_comuna][$ind][$nombre_establecimiento]['denominador'] == 0) {
                /* Si es 0 el denominadore entonces la cumplimiento es 0 */
                $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['cumplimiento'] = 0;
            }
            else {
                $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['cumplimiento'] =
                    $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['numerador'] / $data2020[$nombre_comuna][$ind][$nombre_establecimiento]['denominador'] * 100;
            }

            /* Calculo de las metas de la comuna */
            if($data2020[$nombre_comuna][$ind]['denominador'] == 0) {
                /* Si es 0 el denominadore entonces la cumplimiento es 0 */
                $data2020[$nombre_comuna][$ind]['cumplimiento'] = 0;
            }
            else {
                /* De lo contrario calcular el porcentaje */
                $data2020[$nombre_comuna][$ind]['cumplimiento'] = $data2020[$nombre_comuna][$ind]['numerador'] / $data2020[$nombre_comuna][$ind]['denominador'] * 100;
            }
        }
    }
  }
}
