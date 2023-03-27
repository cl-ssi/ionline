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
$label[$ind]['indicador'] = '1-. Porcentaje de personas del Programa que cuenten con
    una visita domiciliaria integral.';
$label[$ind]['numerador'] = 'N° de personas  con Dependencia Severa  que reciben
    1 Visita Domiciliaria Integral.';
$label[$ind]['denominador'] = 'N° de personas con dependencia severa bajo control
    en el Programa de Atención Domiciliaria para personas con dependencia severa.';
$label[$ind]['fuente_numerador'] = 'REM';
$label[$ind]['fuente_denominador'] = 'REM P';

$label[$ind]['meta'] = '100%';

$label[$ind]['ponderacion'] = '';

/* ==== Inicializar en 0 el arreglo de datos $data_reyno2020 ==== */
for($mes=1; $mes <= $ultimo_rem; $mes++) {
    $data_reyno2020[$ind]['numeradores']['total'] = 0;
    //$data_reyno2020[$ind]['denominadores']['total'] = 0;
    $data_reyno2020[$ind]['numeradores'][$mes] = 0;
    //$data_reyno2020[$ind]['denominadores'][$mes] = 0;
}
$data_reyno2020[$ind]['denominador'] = 0;
$data_reyno2020[$ind]['denominador_a'] = 0;
$data_reyno2020[$ind]['denominador_6'] = 0;
$data_reyno2020[$ind]['denominador_12'] = 0;
$data_reyno2020[$ind]['cumplimiento'] = 0;

/* ===== Query numerador ===== */
$sql_valores = "SELECT e.Comuna, e.alias_estab, r.Mes, sum(ifnull(Col08,0)) as numerador
                  FROM {$year}rems r
                  LEFT JOIN {$year}establecimientos e
                  ON r.IdEstablecimiento=e.Codigo
                  WHERE CodigoPrestacion in (26274200, 26273106, 26274400, 26261400, 26300100) AND e.Codigo = 102307
                  GROUP BY e.Comuna, e.alias_estab, r.Mes
                  ORDER BY e.Comuna, e.alias_estab, r.Mes";
$valores = DB::connection('mysql_rem')->select($sql_valores);

foreach($valores as $valor) {
    $data_reyno2020[$ind]['numeradores'][$valor->Mes] = intval($valor->numerador);
    $data_reyno2020[$ind]['numeradores']['total'] += intval($valor->numerador);
}

if($ultimo_rem <= 5) {
  /* ===== Query denominador ===== */
  $sql_denominador = "SELECT e.Comuna, e.alias_estab, r.Mes, sum(ifnull(Col01,0)) as denominador
                      FROM 2019rems r
                      LEFT JOIN 2019establecimientos e
                      ON r.IdEstablecimiento=e.Codigo
                      WHERE CodigoPrestacion in ('P3160800') AND e.Codigo = 102307
                      AND r.Mes = '12'
                      GROUP BY e.Comuna, e.alias_estab, r.Mes
                      ORDER BY e.Comuna, e.alias_estab, r.Mes";
  $valores = DB::connection('mysql_rem')->select($sql_denominador);

  foreach($valores as $valor) {
      $data_reyno2020[$ind]['denominador_a'] = intval($valor->denominador);
  }

  $data_reyno2020[$ind]['denominador'] = $data_reyno2020[$ind]['denominador_a'];

  /* Calcular el cumplimento */
  if($data_reyno2020[$ind]['denominador_a'] != 0) {
      $data_reyno2020[$ind]['cumplimiento'] = $data_reyno2020[$ind]['numeradores']['total'] /
                                $data_reyno2020[$ind]['denominador_a'] * 100;
  }
}
else{
  /* ===== Query denominador ===== */
  $sql_denominador = "SELECT e.Comuna, e.alias_estab, r.Mes, sum(ifnull(Col01,0)) as denominador
                      FROM {$year}rems r
                      LEFT JOIN {$year}establecimientos e
                      ON r.IdEstablecimiento=e.Codigo
                      WHERE CodigoPrestacion in ('P3160800') AND e.Codigo = 102307
                      AND (Mes = 6 OR Mes = 12)
                      GROUP BY e.Comuna, e.alias_estab, r.Mes
                      ORDER BY e.Comuna, e.alias_estab, r.Mes";
  $valores = DB::connection('mysql_rem')->select($sql_denominador);

  foreach($valores as $valor) {
      switch($valor->Mes) {
          case 6:  $data_reyno2020[$ind]['denominador_6'] = intval($valor->denominador); break;
          case 12: $data_reyno2020[$ind]['denominador_12'] = intval($valor->denominador); break;
      }
  }

  if($ultimo_rem <= 11){
    $data_reyno2020[$ind]['denominador'] = $data_reyno2020[$ind]['denominador_6'];

    /* Calcular el cumplimento */
    if($data_reyno2020[$ind]['denominador_6'] != 0) {
        $data_reyno2020[$ind]['cumplimiento'] = $data_reyno2020[$ind]['numeradores']['total'] /
              $data_reyno2020[$ind]['denominador_6'] * 100;
    }
  }
  else{
    $data_reyno2020[$ind]['denominador'] = $data_reyno2020[$ind]['denominador_12'];

    /* Calcular el cumplimento */
    if($data_reyno2020[$ind]['denominador_12'] != 0) {
        $data_reyno2020[$ind]['cumplimiento'] = $data_reyno2020[$ind]['numeradores']['total'] /
              $data_reyno2020[$ind]['denominador_12'] * 100;
    }
  }
}

// Indicador 2

$ind = 2;
$label[$ind]['indicador'] = '2-. Porcentaje de personas que cuenten con dos visitas
    domiciliarias integrales.';
$label[$ind]['numerador'] = 'N° de personas  con Dependencia Severa que reciben
    la segunda Visita Domicilia Integral.';
$label[$ind]['denominador'] = 'N° de personas con dependencia severa bajo control
    en el Programa de Atención Domiciliaria para personas con dependencia severa.';
$label[$ind]['fuente_numerador'] = 'REM';
$label[$ind]['fuente_denominador'] = 'REM P';

$label[$ind]['meta'] = '80%';

$label[$ind]['ponderacion'] = '';

/* ==== Inicializar en 0 el arreglo de datos $data_reyno2020 ==== */
for($mes=1; $mes <= $ultimo_rem; $mes++) {
    $data_reyno2020[$ind]['numeradores']['total'] = 0;
    //$data_reyno2020[$ind]['denominadores']['total'] = 0;
    $data_reyno2020[$ind]['numeradores'][$mes] = 0;
    //$data_reyno2020[$ind]['denominadores'][$mes] = 0;
}
$data_reyno2020[$ind]['denominador'] = 0;
$data_reyno2020[$ind]['denominador_a'] = 0;
$data_reyno2020[$ind]['denominador_6'] = 0;
$data_reyno2020[$ind]['denominador_12'] = 0;
$data_reyno2020[$ind]['cumplimiento'] = 0;

/* ===== Query numerador ===== */
$sql_valores = "SELECT e.Comuna, e.alias_estab, r.Mes, sum(ifnull(Col09,0)) as numerador
                  FROM {$year}rems r
                  LEFT JOIN {$year}establecimientos e
                  ON r.IdEstablecimiento=e.Codigo
                  WHERE CodigoPrestacion in (26274200, 26273106, 26274400, 26261400, 26300100) AND e.Codigo = 102307
                  GROUP BY e.Comuna, e.alias_estab, r.Mes
                  ORDER BY e.Comuna, e.alias_estab, r.Mes";
$valores = DB::connection('mysql_rem')->select($sql_valores);

foreach($valores as $valor) {
    $data_reyno2020[$ind]['numeradores'][$valor->Mes] = intval($valor->numerador);
    $data_reyno2020[$ind]['numeradores']['total'] += intval($valor->numerador);
}

if($ultimo_rem <= 5) {
  /* ===== Query denominador ===== */
  $sql_denominador = "SELECT e.Comuna, e.alias_estab, r.Mes, sum(ifnull(Col01,0)) as denominador
                      FROM 2019rems r
                      LEFT JOIN 2019establecimientos e
                      ON r.IdEstablecimiento=e.Codigo
                      WHERE CodigoPrestacion in ('P3160800') AND e.Codigo = 102307
                      AND r.Mes = '12'
                      GROUP BY e.Comuna, e.alias_estab, r.Mes
                      ORDER BY e.Comuna, e.alias_estab, r.Mes";
  $valores = DB::connection('mysql_rem')->select($sql_denominador);

  foreach($valores as $valor) {
      $data_reyno2020[$ind]['denominador_a'] = intval($valor->denominador);
  }

  $data_reyno2020[$ind]['denominador'] = $data_reyno2020[$ind]['denominador_a'];

  /* Calcular el cumplimento */
  if($data_reyno2020[$ind]['denominador_a'] != 0) {
      $data_reyno2020[$ind]['cumplimiento'] = $data_reyno2020[$ind]['numeradores']['total'] /
                                $data_reyno2020[$ind]['denominador_a'] * 100;
  }
}
else{
  /* ===== Query denominador ===== */
  $sql_denominador = "SELECT e.Comuna, e.alias_estab, r.Mes, sum(ifnull(Col01,0)) as denominador
                      FROM {$year}rems r
                      LEFT JOIN {$year}establecimientos e
                      ON r.IdEstablecimiento=e.Codigo
                      WHERE CodigoPrestacion in ('P3160800') AND e.Codigo = 102307
                      AND (Mes = 6 OR Mes = 12)
                      GROUP BY e.Comuna, e.alias_estab, r.Mes
                      ORDER BY e.Comuna, e.alias_estab, r.Mes";
  $valores = DB::connection('mysql_rem')->select($sql_denominador);

  foreach($valores as $valor) {
      switch($valor->Mes) {
          case 6:  $data_reyno2020[$ind]['denominador_6'] = intval($valor->denominador); break;
          case 12: $data_reyno2020[$ind]['denominador_12'] = intval($valor->denominador); break;
      }
  }

  if($ultimo_rem <= 11){
    $data_reyno2020[$ind]['denominador'] = $data_reyno2020[$ind]['denominador_6'];

    /* Calcular el cumplimento */
    if($data_reyno2020[$ind]['denominador_6'] != 0) {
        $data_reyno2020[$ind]['cumplimiento'] = $data_reyno2020[$ind]['numeradores']['total'] /
              $data_reyno2020[$ind]['denominador_6'] * 100;
    }
  }
  else{
    $data_reyno2020[$ind]['denominador'] = $data_reyno2020[$ind]['denominador_12'];

    /* Calcular el cumplimento */
    if($data_reyno2020[$ind]['denominador_12'] != 0) {
        $data_reyno2020[$ind]['cumplimiento'] = $data_reyno2020[$ind]['numeradores']['total'] /
              $data_reyno2020[$ind]['denominador_12'] * 100;
    }
  }
}

// Indicador 3

$ind = 3;
$label[$ind]['indicador'] = '3-. Promedio de Visitas de Tratamiento y Seguimiento.';
$label[$ind]['numerador'] = 'N° de Visitas de Tratamiento y Seguimiento recibidas
    por personas con Dependencia Severa.';
$label[$ind]['denominador'] = 'N° de personas con dependencia severa bajo control
    en el Programa de Atención Domiciliaria para personas con dependencia severa.';
$label[$ind]['fuente_numerador'] = 'REM';
$label[$ind]['fuente_denominador'] = 'REM P';

$label[$ind]['meta'] = 'promedio 6';

$label[$ind]['ponderacion'] = '';

/* ==== Inicializar en 0 el arreglo de datos $data_reyno2020 ==== */
for($mes=1; $mes <= $ultimo_rem; $mes++) {
    $data_reyno2020[$ind]['numeradores']['total'] = 0;
    //$data_reyno2020[$ind]['denominadores']['total'] = 0;
    $data_reyno2020[$ind]['numeradores'][$mes] = 0;
    //$data_reyno2020[$ind]['denominadores'][$mes] = 0;
}
$data_reyno2020[$ind]['denominador'] = 0;
$data_reyno2020[$ind]['denominador_a'] = 0;
$data_reyno2020[$ind]['denominador_6'] = 0;
$data_reyno2020[$ind]['denominador_12'] = 0;
$data_reyno2020[$ind]['cumplimiento'] = 0;

/* ===== Query numerador ===== */
$sql_valores = "SELECT e.Comuna, e.alias_estab, r.Mes, sum(ifnull(Col10,0)) as numerador
                  FROM {$year}rems r
                  LEFT JOIN {$year}establecimientos e
                  ON r.IdEstablecimiento=e.Codigo
                  WHERE CodigoPrestacion in (26274200, 26273106, 26274400, 26261400, 26300100) AND e.Codigo = 102307
                  GROUP BY e.Comuna, e.alias_estab, r.Mes
                  ORDER BY e.Comuna, e.alias_estab, r.Mes";
$valores = DB::connection('mysql_rem')->select($sql_valores);

foreach($valores as $valor) {
    $data_reyno2020[$ind]['numeradores'][$valor->Mes] = intval($valor->numerador);
    $data_reyno2020[$ind]['numeradores']['total'] += intval($valor->numerador);
}

if($ultimo_rem <= 5) {
  /* ===== Query denominador ===== */
  $sql_denominador = "SELECT e.Comuna, e.alias_estab, r.Mes, sum(ifnull(Col01,0)) as denominador
                      FROM 2019rems r
                      LEFT JOIN 2019establecimientos e
                      ON r.IdEstablecimiento=e.Codigo
                      WHERE CodigoPrestacion in ('P3160800') AND e.Codigo = 102307
                      AND r.Mes = '12'
                      GROUP BY e.Comuna, e.alias_estab, r.Mes
                      ORDER BY e.Comuna, e.alias_estab, r.Mes";
  $valores = DB::connection('mysql_rem')->select($sql_denominador);

  foreach($valores as $valor) {
      $data_reyno2020[$ind]['denominador_a'] = intval($valor->denominador);
  }

  $data_reyno2020[$ind]['denominador'] = $data_reyno2020[$ind]['denominador_a'];

  /* Calcular el cumplimento */
  if($data_reyno2020[$ind]['denominador_a'] != 0) {
      $data_reyno2020[$ind]['cumplimiento'] = $data_reyno2020[$ind]['numeradores']['total'] /
                                $data_reyno2020[$ind]['denominador_a'] * 100;
  }
}
else{
  /* ===== Query denominador ===== */
  $sql_denominador = "SELECT e.Comuna, e.alias_estab, r.Mes, sum(ifnull(Col01,0)) as denominador
                      FROM {$year}rems r
                      LEFT JOIN {$year}establecimientos e
                      ON r.IdEstablecimiento=e.Codigo
                      WHERE CodigoPrestacion in ('P3160800') AND e.Codigo = 102307
                      AND (Mes = 6 OR Mes = 12)
                      GROUP BY e.Comuna, e.alias_estab, r.Mes
                      ORDER BY e.Comuna, e.alias_estab, r.Mes";
  $valores = DB::connection('mysql_rem')->select($sql_denominador);

  foreach($valores as $valor) {
      switch($valor->Mes) {
          case 6:  $data_reyno2020[$ind]['denominador_6'] = intval($valor->denominador); break;
          case 12: $data_reyno2020[$ind]['denominador_12'] = intval($valor->denominador); break;
      }
  }

  if($ultimo_rem <= 11){
    $data_reyno2020[$ind]['denominador'] = $data_reyno2020[$ind]['denominador_6'];

    /* Calcular el cumplimento */
    if($data_reyno2020[$ind]['denominador_6'] != 0) {
        $data_reyno2020[$ind]['cumplimiento'] = $data_reyno2020[$ind]['numeradores']['total'] /
              $data_reyno2020[$ind]['denominador_6'] * 100;
    }
  }
  else{
    $data_reyno2020[$ind]['denominador'] = $data_reyno2020[$ind]['denominador_12'];

    /* Calcular el cumplimento */
    if($data_reyno2020[$ind]['denominador_12'] != 0) {
        $data_reyno2020[$ind]['cumplimiento'] = $data_reyno2020[$ind]['numeradores']['total'] /
              $data_reyno2020[$ind]['denominador_12'] * 100;
    }
  }
}

// Indicador 4

$ind = 4;
$label[$ind]['indicador'] = '4-. Porcentaje de personas con dependencia severa sin
    escaras.';
$label[$ind]['numerador'] = 'N° de personas con dependencia severa sin escaras.';
$label[$ind]['denominador'] = 'N° de personas con dependencia severa bajo control
    en el Programa de Atención Domiciliaria para personas con dependencia severa.';
$label[$ind]['fuente_numerador'] = 'REM P';
$label[$ind]['fuente_denominador'] = 'REM P';

$label[$ind]['meta'] = '92%';

$label[$ind]['ponderacion'] = '';

$data_reyno2020[$ind]['numerador'] = 0;
$data_reyno2020[$ind]['numerador_a'] = 0;
$data_reyno2020[$ind]['numerador_6'] = 0;
$data_reyno2020[$ind]['numerador_6_1'] = 0;
$data_reyno2020[$ind]['numerador_6_2'] = 0;
$data_reyno2020[$ind]['numerador_12'] = 0;
$data_reyno2020[$ind]['numerador_12_1'] = 0;
$data_reyno2020[$ind]['numerador_12_2'] = 0;

$data_reyno2020[$ind]['denominador'] = 0;
$data_reyno2020[$ind]['denominador_a'] = 0;
$data_reyno2020[$ind]['denominador_6'] = 0;
$data_reyno2020[$ind]['denominador_12'] = 0;

$data_reyno2020[$ind]['cumplimiento'] = 0;

/* ===== Query numerador ===== */
$sql_numerador = "SELECT e.Comuna, e.alias_estab, r.Mes, sum(ifnull(Col01,0)) as numerador
                    FROM {$year}rems r
                    LEFT JOIN {$year}establecimientos e
                    ON r.IdEstablecimiento=e.Codigo
                    WHERE CodigoPrestacion in ('P3160800') AND e.Codigo = 102307
                    AND (r.Mes = '6' OR r.Mes = '12')
                    GROUP BY e.Comuna, e.alias_estab, r.Mes
                    ORDER BY e.Comuna, e.alias_estab, r.Mes";
$valores = DB::connection('mysql_rem')->select($sql_numerador);

foreach($valores as $valor) {
    switch ($valor->Mes) {
        case 6:
              $data_reyno2020[$ind]['numerador_6_1'] = $valor->numerador;
          break;
        case 12;
              $data_reyno2020[$ind]['numerador_12_1'] = $valor->numerador;
          break;
    }
}

/* ===== Query numerador ===== */
$sql_numerador = "SELECT e.Comuna, e.alias_estab, r.Mes, sum(ifnull(Col01,0)) as numerador
                    FROM {$year}rems r
                    LEFT JOIN {$year}establecimientos e
                    ON r.IdEstablecimiento=e.Codigo
                    WHERE CodigoPrestacion in ('P3160900') AND e.Codigo = 102307
                    AND (r.Mes = '6' OR r.Mes = '12')
                    GROUP BY e.Comuna, e.alias_estab, r.Mes
                    ORDER BY e.Comuna, e.alias_estab, r.Mes";
$valores = DB::connection('mysql_rem')->select($sql_numerador);

foreach($valores as $valor) {
    switch ($valor->Mes) {
        case 6:
              $data_reyno2020[$ind]['numerador_6_2'] = $valor->numerador;
          break;
        case 12;
              $data_reyno2020[$ind]['numerador_12_2'] = $valor->numerador;
          break;
    }
}

/* ===== Query denominador ===== */
$sql_denominador = "SELECT e.Comuna, e.alias_estab, r.Mes, sum(ifnull(Col01,0)) as denominador
                    FROM {$year}rems r
                    LEFT JOIN {$year}establecimientos e
                    ON r.IdEstablecimiento=e.Codigo
                    WHERE CodigoPrestacion in ('P3160800') AND e.Codigo = 102307
                    AND (r.Mes = '6' OR r.Mes = '12')
                    GROUP BY e.Comuna, e.alias_estab, r.Mes
                    ORDER BY e.Comuna, e.alias_estab, r.Mes";
$valores = DB::connection('mysql_rem')->select($sql_denominador);

foreach($valores as $valor) {
    switch ($valor->Mes) {
        case 6:
              $data_reyno2020[$ind]['denominador_6'] = $valor->denominador;
          break;
        case 12:
              $data_reyno2020[$ind]['denominador_12'] = $valor->denominador;
          break;
    }
}

/* Calcula numeradores deL establecimiento */
$data_reyno2020[$ind]['numerador_6'] = $data_reyno2020[$ind]['numerador_6_1'] -
    $data_reyno2020[$ind]['numerador_6_2'];

$data_reyno2020[$ind]['numerador_12'] = $data_reyno2020[$ind]['numerador_12_1'] -
    $data_reyno2020[$ind]['numerador_12_2'];

if($ultimo_rem >= 6 && $ultimo_rem <= 11){
    $data_reyno2020[$ind]['numerador'] = $data_reyno2020[$ind]['numerador_6'];
    $data_reyno2020[$ind]['denominador'] = $data_reyno2020[$ind]['denominador_6'];
}

elseif($ultimo_rem == 12) {
    $data_reyno2020[$ind]['numerador'] = $data_reyno2020[$ind]['numerador_12'];
    $data_reyno2020[$ind]['denominador'] = $data_reyno2020[$ind]['denominador_12'];
}

else{
    $data_reyno2020[$ind]['numerador'] = 0;
    $data_reyno2020[$ind]['denominador'] = 0;
}

/* Calculo de las metas de cada establecimiento */
if($data_reyno2020[$ind]['denominador'] == 0) {
    /* Si es 0 el denominadore entonces la cumplimiento es 0 */
    $data_reyno2020[$ind]['cumplimiento'] = 0;
}
else {
    $data_reyno2020[$ind]['cumplimiento'] =
    $data_reyno2020[$ind]['numerador'] / $data_reyno2020[$ind]['denominador'] * 100;
}

// Indicador 5

$ind = 5;
$label[$ind]['indicador'] = '5-. Porcentaje de Cuidadoras que cuentan con Examen Preventivo
    Vigente,  acorde a OOTT Ministerial.';
$label[$ind]['numerador'] = 'N° de cuidadoras de personas con dependencia severa
    con examen de medicina preventivo vigente.';
$label[$ind]['denominador'] = 'Total de cuidadores de personas con dependencia
    severa.';
$label[$ind]['fuente_numerador'] = 'REM P';
$label[$ind]['fuente_denominador'] = 'REM P';

$label[$ind]['meta'] = '75%';

$label[$ind]['ponderacion'] = '';

$data_reyno2020[$ind]['numerador'] = 0;
$data_reyno2020[$ind]['numerador_a'] = 0;
$data_reyno2020[$ind]['numerador_6'] = 0;
$data_reyno2020[$ind]['numerador_12'] = 0;

$data_reyno2020[$ind]['denominador'] = 0;
$data_reyno2020[$ind]['denominador_a'] = 0;
$data_reyno2020[$ind]['denominador_6'] = 0;
$data_reyno2020[$ind]['denominador_12'] = 0;

$data_reyno2020[$ind]['cumplimiento'] = 0;

/* ===== Query numerador ===== */
$sql_numerador = "SELECT e.Comuna, e.alias_estab, r.Mes, sum(ifnull(Col03,0)) as numerador
                    FROM {$year}rems r
                    LEFT JOIN {$year}establecimientos e
                    ON r.IdEstablecimiento=e.Codigo
                    WHERE CodigoPrestacion in ('P5300600') AND e.Codigo = 102307
                    AND (r.Mes = '6' OR r.Mes = '12')
                    GROUP BY e.Comuna, e.alias_estab, r.Mes
                    ORDER BY e.Comuna, e.alias_estab, r.Mes";
$valores = DB::connection('mysql_rem')->select($sql_numerador);

foreach($valores as $valor) {
    switch ($valor->Mes) {
        case 6:
              $data_reyno2020[$ind]['numerador_6'] = $valor->numerador;
          break;
        case 12;
              $data_reyno2020[$ind]['numerador_12'] = $valor->numerador;
          break;
    }
}

/* ===== Query denominador ===== */
$sql_denominador = "SELECT e.Comuna, e.alias_estab, r.Mes, sum(ifnull(Col01,0)) as denominador
                    FROM {$year}rems r
                    LEFT JOIN {$year}establecimientos e
                    ON r.IdEstablecimiento=e.Codigo
                    WHERE CodigoPrestacion in ('P5300600') AND e.Codigo = 102307
                    AND (r.Mes = '6' OR r.Mes = '12')
                    GROUP BY e.Comuna, e.alias_estab, r.Mes
                    ORDER BY e.Comuna, e.alias_estab, r.Mes";
$valores = DB::connection('mysql_rem')->select($sql_denominador);

foreach($valores as $valor) {
    switch ($valor->Mes) {
        case 6:
              $data_reyno2020[$ind]['denominador_6'] = $valor->denominador;
          break;
        case 12:
              $data_reyno2020[$ind]['denominador_12'] = $valor->denominador;
          break;
    }
}

if($ultimo_rem >= 6 && $ultimo_rem <= 11){
    $data_reyno2020[$ind]['numerador'] = $data_reyno2020[$ind]['numerador_6'];
    $data_reyno2020[$ind]['denominador'] = $data_reyno2020[$ind]['denominador_6'];
}

elseif($ultimo_rem == 12) {
    $data_reyno2020[$ind]['numerador'] = $data_reyno2020[$ind]['numerador_12'];
    $data_reyno2020[$ind]['denominador'] = $data_reyno2020[$ind]['denominador_12'];
}

else{
    $data_reyno2020[$ind]['numerador'] = 0;
    $data_reyno2020[$ind]['denominador'] = 0;
}

/* Calculo de las metas de cada establecimiento */
if($data_reyno2020[$ind]['denominador'] == 0) {
    /* Si es 0 el denominadore entonces la cumplimiento es 0 */
    $data_reyno2020[$ind]['cumplimiento'] = 0;
}
else {
    $data_reyno2020[$ind]['cumplimiento'] =
    $data_reyno2020[$ind]['numerador'] / $data_reyno2020[$ind]['denominador'] * 100;
}

// Indicador 6

$ind = 6;
$label[$ind]['indicador'] = '6-. Porcentaje de personas con indicación de NED reciben
    atención Nutricional en Domicilio.';
$label[$ind]['numerador'] = 'Nº de atenciones nutricionales en domicilio para personas
    del Programa de Atención Domiciliaria para Personas con Dependencia Severa
    con indicación de NED.';
$label[$ind]['denominador'] = 'N° total de personas con dependencia severa con
    indicación de NED.';
$label[$ind]['fuente_numerador'] = 'REM';
$label[$ind]['fuente_denominador'] = 'REM P';

$label[$ind]['meta'] = '100%';

$label[$ind]['ponderacion'] = '';

/* ==== Inicializar en 0 el arreglo de datos $data_reyno2020 ==== */
for($mes=1; $mes <= $ultimo_rem; $mes++) {
    $data_reyno2020[$ind]['numeradores']['total'] = 0;
    //$data_reyno2020[$ind]['denominadores']['total'] = 0;
    $data_reyno2020[$ind]['numeradores'][$mes] = 0;
    //$data_reyno2020[$ind]['denominadores'][$mes] = 0;
}
$data_reyno2020[$ind]['denominador'] = 0;
$data_reyno2020[$ind]['denominador_a'] = 0;
$data_reyno2020[$ind]['denominador_6'] = 0;
$data_reyno2020[$ind]['denominador_12'] = 0;
$data_reyno2020[$ind]['cumplimiento'] = 0;

/* ===== Query numerador ===== */
$sql_valores = "SELECT e.Comuna, e.alias_estab, r.Mes, sum(ifnull(Col01,0)) as numerador
                  FROM {$year}rems r
                  LEFT JOIN {$year}establecimientos e
                  ON r.IdEstablecimiento=e.Codigo
                  WHERE CodigoPrestacion in (26300150) AND e.Codigo = 102307
                  GROUP BY e.Comuna, e.alias_estab, r.Mes
                  ORDER BY e.Comuna, e.alias_estab, r.Mes";
$valores = DB::connection('mysql_rem')->select($sql_valores);

foreach($valores as $valor) {
    $data_reyno2020[$ind]['numeradores'][$valor->Mes] = intval($valor->numerador);
    $data_reyno2020[$ind]['numeradores']['total'] += intval($valor->numerador);
}

if($ultimo_rem <= 5) {
  /* ===== Query denominador ===== */
  $sql_denominador = "SELECT e.Comuna, e.alias_estab, r.Mes, sum(ifnull(Col01,0)) as denominador
                      FROM 2019rems r
                      LEFT JOIN 2019establecimientos e
                      ON r.IdEstablecimiento=e.Codigo
                      WHERE CodigoPrestacion in ('P3170200') AND e.Codigo = 102307
                      AND r.Mes = '12'
                      GROUP BY e.Comuna, e.alias_estab, r.Mes
                      ORDER BY e.Comuna, e.alias_estab, r.Mes";
  $valores = DB::connection('mysql_rem')->select($sql_denominador);

  foreach($valores as $valor) {
      $data_reyno2020[$ind]['denominador_a'] = intval($valor->denominador);
  }

  $data_reyno2020[$ind]['denominador'] = $data_reyno2020[$ind]['denominador_a'];

  /* Calcular el cumplimento */
  if($data_reyno2020[$ind]['denominador_a'] != 0) {
      $data_reyno2020[$ind]['cumplimiento'] = $data_reyno2020[$ind]['numeradores']['total'] /
                                $data_reyno2020[$ind]['denominador_a'] * 100;
  }
}
else{
  /* ===== Query denominador ===== */
  $sql_denominador = "SELECT e.Comuna, e.alias_estab, r.Mes, sum(ifnull(Col01,0)) as denominador
                      FROM {$year}rems r
                      LEFT JOIN {$year}establecimientos e
                      ON r.IdEstablecimiento=e.Codigo
                      WHERE CodigoPrestacion in ('P3170200') AND e.Codigo = 102307
                      AND (Mes = 6 OR Mes = 12)
                      GROUP BY e.Comuna, e.alias_estab, r.Mes
                      ORDER BY e.Comuna, e.alias_estab, r.Mes";
  $valores = DB::connection('mysql_rem')->select($sql_denominador);

  foreach($valores as $valor) {
      switch($valor->Mes) {
          case 6:  $data_reyno2020[$ind]['denominador_6'] = intval($valor->denominador); break;
          case 12: $data_reyno2020[$ind]['denominador_12'] = intval($valor->denominador); break;
      }
  }

  if($ultimo_rem <= 11){
    $data_reyno2020[$ind]['denominador'] = $data_reyno2020[$ind]['denominador_6'];

    /* Calcular el cumplimento */
    if($data_reyno2020[$ind]['denominador_6'] != 0) {
        $data_reyno2020[$ind]['cumplimiento'] = $data_reyno2020[$ind]['numeradores']['total'] /
              $data_reyno2020[$ind]['denominador_6'] * 100;
    }
  }
  else{
    $data_reyno2020[$ind]['denominador'] = $data_reyno2020[$ind]['denominador_12'];

    /* Calcular el cumplimento */
    if($data_reyno2020[$ind]['denominador_12'] != 0) {
        $data_reyno2020[$ind]['cumplimiento'] = $data_reyno2020[$ind]['numeradores']['total'] /
              $data_reyno2020[$ind]['denominador_12'] * 100;
    }
  }
}

// Indicador 7

$ind = 7;
$label[$ind]['indicador'] = '7-. Porcentaje de Cuidadoras/es de personas con dependencia
    severa del Programa evaluados con Escala de Zarit.';
$label[$ind]['numerador'] = 'N° de cuidadores de personas con dependencia severa
    del Programa de Atención Domiciliara para personas con Dependencia severa evaluados
     con Escala de Zarit.';
$label[$ind]['denominador'] = 'N° de cuidadores de personas con dependencia severa
    del Programa de Atención Domiciliaria para personas con dependencia severa.';
$label[$ind]['fuente_numerador'] = 'REM';
$label[$ind]['fuente_denominador'] = 'REM P';

$label[$ind]['meta'] = '80%';

$label[$ind]['ponderacion'] = '';

/* ==== Inicializar en 0 el arreglo de datos $data_reyno2020 ==== */
for($mes=1; $mes <= $ultimo_rem; $mes++) {
    $data_reyno2020[$ind]['numeradores']['total'] = 0;
    //$data_reyno2020[$ind]['denominadores']['total'] = 0;
    $data_reyno2020[$ind]['numeradores'][$mes] = 0;
    //$data_reyno2020[$ind]['denominadores'][$mes] = 0;
}
$data_reyno2020[$ind]['denominador'] = 0;
$data_reyno2020[$ind]['denominador_a'] = 0;
$data_reyno2020[$ind]['denominador_6'] = 0;
$data_reyno2020[$ind]['denominador_12'] = 0;
$data_reyno2020[$ind]['cumplimiento'] = 0;

/* ===== Query numerador ===== */
$sql_valores = "SELECT e.Comuna, e.alias_estab, r.Mes, sum(ifnull(Col01,0)) as numerador
                  FROM {$year}rems r
                  LEFT JOIN {$year}establecimientos e
                  ON r.IdEstablecimiento=e.Codigo
                  WHERE CodigoPrestacion in (03500361, 03500362) AND e.Codigo = 102307
                  GROUP BY e.Comuna, e.alias_estab, r.Mes
                  ORDER BY e.Comuna, e.alias_estab, r.Mes";
$valores = DB::connection('mysql_rem')->select($sql_valores);

foreach($valores as $valor) {
    $data_reyno2020[$ind]['numeradores'][$valor->Mes] = intval($valor->numerador);
    $data_reyno2020[$ind]['numeradores']['total'] += intval($valor->numerador);
}

if($ultimo_rem <= 5) {
  /* ===== Query denominador ===== */
  $sql_denominador = "SELECT e.Comuna, e.alias_estab, r.Mes, sum(ifnull(Col01,0)) as denominador
                      FROM 2019rems r
                      LEFT JOIN 2019establecimientos e
                      ON r.IdEstablecimiento=e.Codigo
                      WHERE CodigoPrestacion in ('P3170200') AND e.Codigo = 102307
                      AND r.Mes = '12'
                      GROUP BY e.Comuna, e.alias_estab, r.Mes
                      ORDER BY e.Comuna, e.alias_estab, r.Mes";
  $valores = DB::connection('mysql_rem')->select($sql_denominador);

  foreach($valores as $valor) {
      $data_reyno2020[$ind]['denominador_a'] = intval($valor->denominador);
  }

  $data_reyno2020[$ind]['denominador'] = $data_reyno2020[$ind]['denominador_a'];

  /* Calcular el cumplimento */
  if($data_reyno2020[$ind]['denominador_a'] != 0) {
      $data_reyno2020[$ind]['cumplimiento'] = $data_reyno2020[$ind]['numeradores']['total'] /
                                $data_reyno2020[$ind]['denominador_a'] * 100;
  }
}
else{
  /* ===== Query denominador ===== */
  $sql_denominador = "SELECT e.Comuna, e.alias_estab, r.Mes, sum(ifnull(Col01,0)) as denominador
                      FROM {$year}rems r
                      LEFT JOIN {$year}establecimientos e
                      ON r.IdEstablecimiento=e.Codigo
                      WHERE CodigoPrestacion in ('P3170200') AND e.Codigo = 102307
                      AND (Mes = 6 OR Mes = 12)
                      GROUP BY e.Comuna, e.alias_estab, r.Mes
                      ORDER BY e.Comuna, e.alias_estab, r.Mes";
  $valores = DB::connection('mysql_rem')->select($sql_denominador);

  foreach($valores as $valor) {
      switch($valor->Mes) {
          case 6:  $data_reyno2020[$ind]['denominador_6'] = intval($valor->denominador); break;
          case 12: $data_reyno2020[$ind]['denominador_12'] = intval($valor->denominador); break;
      }
  }

  if($ultimo_rem <= 11){
    $data_reyno2020[$ind]['denominador'] = $data_reyno2020[$ind]['denominador_6'];

    /* Calcular el cumplimento */
    if($data_reyno2020[$ind]['denominador_6'] != 0) {
        $data_reyno2020[$ind]['cumplimiento'] = $data_reyno2020[$ind]['numeradores']['total'] /
              $data_reyno2020[$ind]['denominador_6'] * 100;
    }
  }
  else{
    $data_reyno2020[$ind]['denominador'] = $data_reyno2020[$ind]['denominador_12'];

    /* Calcular el cumplimento */
    if($data_reyno2020[$ind]['denominador_12'] != 0) {
        $data_reyno2020[$ind]['cumplimiento'] = $data_reyno2020[$ind]['numeradores']['total'] /
              $data_reyno2020[$ind]['denominador_12'] * 100;
    }
  }
}

// Indicador 8

$ind = 8;
$label[$ind]['indicador'] = '8-. Porcentaje de Cuidadoras capacitados..';
$label[$ind]['numerador'] = 'N° de cuidadores capacitados por el programa de atención
    domiciliaria para personas con dependencia severa.';
$label[$ind]['denominador'] = 'N° de  cuidadoras(es) de personas con dependencia severa.';
$label[$ind]['fuente_numerador'] = 'REM P';
$label[$ind]['fuente_denominador'] = 'REM P';

$label[$ind]['meta'] = '';

$label[$ind]['ponderacion'] = '';

$data_reyno2020[$ind]['numerador'] = 0;
$data_reyno2020[$ind]['numerador_a'] = 0;
$data_reyno2020[$ind]['numerador_6'] = 0;
$data_reyno2020[$ind]['numerador_12'] = 0;

$data_reyno2020[$ind]['denominador'] = 0;
$data_reyno2020[$ind]['denominador_a'] = 0;
$data_reyno2020[$ind]['denominador_6'] = 0;
$data_reyno2020[$ind]['denominador_12'] = 0;

$data_reyno2020[$ind]['cumplimiento'] = 0;

/* ===== Query numerador ===== */
$sql_numerador = "SELECT e.Comuna, e.alias_estab, r.Mes, sum(ifnull(Col02,0)) as numerador
                    FROM {$year}rems r
                    LEFT JOIN {$year}establecimientos e
                    ON r.IdEstablecimiento=e.Codigo
                    WHERE CodigoPrestacion in ('P5300600') AND e.Codigo = 102307
                    AND (r.Mes = '6' OR r.Mes = '12')
                    GROUP BY e.Comuna, e.alias_estab, r.Mes
                    ORDER BY e.Comuna, e.alias_estab, r.Mes";
$valores = DB::connection('mysql_rem')->select($sql_numerador);

foreach($valores as $valor) {
    switch ($valor->Mes) {
        case 6:
              $data_reyno2020[$ind]['numerador_6'] = $valor->numerador;
          break;
        case 12;
              $data_reyno2020[$ind]['numerador_12'] = $valor->numerador;
          break;
    }
}

/* ===== Query denominador ===== */
$sql_denominador = "SELECT e.Comuna, e.alias_estab, r.Mes, sum(ifnull(Col01,0)) as denominador
                    FROM {$year}rems r
                    LEFT JOIN {$year}establecimientos e
                    ON r.IdEstablecimiento=e.Codigo
                    WHERE CodigoPrestacion in ('P5300600') AND e.Codigo = 102307
                    AND (r.Mes = '6' OR r.Mes = '12')
                    GROUP BY e.Comuna, e.alias_estab, r.Mes
                    ORDER BY e.Comuna, e.alias_estab, r.Mes";
$valores = DB::connection('mysql_rem')->select($sql_denominador);

foreach($valores as $valor) {
    switch ($valor->Mes) {
        case 6:
              $data_reyno2020[$ind]['denominador_6'] = $valor->denominador;
          break;
        case 12:
              $data_reyno2020[$ind]['denominador_12'] = $valor->denominador;
          break;
    }
}

if($ultimo_rem >= 6 && $ultimo_rem <= 11){
    $data_reyno2020[$ind]['numerador'] = $data_reyno2020[$ind]['numerador_6'];
    $data_reyno2020[$ind]['denominador'] = $data_reyno2020[$ind]['denominador_6'];
}

elseif($ultimo_rem == 12) {
    $data_reyno2020[$ind]['numerador'] = $data_reyno2020[$ind]['numerador_12'];
    $data_reyno2020[$ind]['denominador'] = $data_reyno2020[$ind]['denominador_12'];
}

else{
    $data_reyno2020[$ind]['numerador'] = 0;
    $data_reyno2020[$ind]['denominador'] = 0;
}

/* Calculo de las metas de cada establecimiento */
if($data_reyno2020[$ind]['denominador'] == 0) {
    /* Si es 0 el denominadore entonces la cumplimiento es 0 */
    $data_reyno2020[$ind]['cumplimiento'] = 0;
}
else {
    $data_reyno2020[$ind]['cumplimiento'] =
    $data_reyno2020[$ind]['numerador'] / $data_reyno2020[$ind]['denominador'] * 100;
}
