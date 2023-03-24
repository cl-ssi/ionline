<?php

namespace App\Http\Controllers\Indicators\_2018;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\Indicators\SingleParameter;

class Indicator18834Controller extends Controller
{
    public function index()
    {
        return view('indicators.18834.2018.index');
    }

    public function show(Request $request, $year, $law, $id)
    {
        $metas = $request->input('meta');
        $comunas = $request->input('comuna');
        return view('indicators/$year/$law/$id')->withYear($year)->withLaw($law)->withId($id)->withMetas($metas);
    }

    public function servicio(){
        $year= 2018;
      $label['meta'] = '2. Porcentaje de pacientes hipertensos compensados bajo control en el grupo de 15 y más años en el nivel primario.';
      $label['numerador'] = 'N° de personas hipertensas de 15 a 79 años con presión arterial <140/90 mmHg, más el N° de personas hipertensas de 80 y más años con presión arterial <150/90 mmHg, según último control vigente, en los últimos 12 meses.';
      $label['denominador'] = 'Total de pacientes Hipertensos de 15 y más años bajo control en el nivel primario.';

      $data = array();

      $sql_establecimientos = "SELECT servicio_salud, comuna, alias_estab
                               FROM establecimientos
                               WHERE meta_san_18834 = 1
                               ORDER BY comuna";

      $establecimientos = DB::connection('mysql_rem')->select($sql_establecimientos);

      /* ==== Inicializar en 0 el arreglo de datos $data ==== */
      foreach($establecimientos as $establecimiento) {
          $data[$establecimiento->servicio_salud]['numerador'] = 0;
          $data[$establecimiento->servicio_salud]['numerador_6'] = 0;
          $data[$establecimiento->servicio_salud]['denominador'] = 0;
          $data[$establecimiento->servicio_salud]['denominador_6'] = 0;
          $data[$establecimiento->servicio_salud]['meta'] = 0;
          $data[$establecimiento->servicio_salud]['cumplimiento'] = 0;
          $data[$establecimiento->servicio_salud][$establecimiento->alias_estab]['numerador'] = 0;
          $data[$establecimiento->servicio_salud][$establecimiento->alias_estab]['denominador'] = 0;
          $data[$establecimiento->servicio_salud][$establecimiento->alias_estab]['meta'] = 0;
          $data[$establecimiento->servicio_salud][$establecimiento->alias_estab]['cumplimiento'] = 0;
      }

      $data['SERVICIO DE SALUD IQUIQUE']['meta'] = '≥68%';

      /* ===== Query numerador ===== */
      $sql_numerador =
      "SELECT e.servicio_salud, e.alias_estab, r.Mes, sum(ifnull(Col01,0)) as numerador
          FROM ".$year."rems r
          LEFT JOIN establecimientos e ON r.IdEstablecimiento=e.Codigo
          WHERE
          e.meta_san_18834 = 1 AND Ano = 2018 AND (Mes = 6 OR Mes = 12) AND
          CodigoPrestacion IN ('P4180200','P4200100')
          GROUP by e.servicio_salud, e.alias_estab, r.Mes
          ORDER BY e.servicio_salud, e.alias_estab, r.Mes";

      $numeradores = DB::connection('mysql_rem')->select($sql_numerador);

      foreach($numeradores as $registro) {
          /*$data[$registro->servicio_salud]['numerador'] += $registro->numerador;
          $data[$registro->servicio_salud][$registro->alias_estab]['numerador'] = $registro->numerador;*/

          if($registro->Mes == 6) {
              $data[$registro->servicio_salud]['numerador_6'] += $registro->numerador;
              $data[$registro->servicio_salud][$registro->alias_estab]['numerador_6'] = $registro->numerador;
          }
          if($registro->Mes == 12){
              $data[$registro->servicio_salud]['numerador'] += $registro->numerador;
              $data[$registro->servicio_salud][$registro->alias_estab]['numerador'] = $registro->numerador;
          }
      }

      /* ===== Query denominador ===== */
      $sql_denominador =
      "SELECT e.servicio_salud, e.alias_estab, r.Mes, sum(ifnull(Col01,0)) as denominador
          FROM ".$year."rems r
          LEFT JOIN establecimientos e ON r.IdEstablecimiento=e.Codigo
          WHERE
          e.meta_san_18834 = 1 AND Ano = 2018 AND (Mes = 6 OR Mes = 12) AND
          CodigoPrestacion IN ('P4150601')
          GROUP by e.servicio_salud, e.alias_estab, r.Mes
          ORDER BY e.servicio_salud, e.alias_estab, r.Mes";

      $denomidores = DB::connection('mysql_rem')->select($sql_denominador);

      foreach($denomidores as $registro) {
          if($registro->Mes == 6){
            $data[$registro->servicio_salud]['denominador_6'] += $registro->denominador;
            $data[$registro->servicio_salud][$registro->alias_estab]['denominador_6'] = $registro->denominador;
          }
          if($registro->Mes == 12){
            $data[$registro->servicio_salud]['denominador'] += $registro->denominador;
            $data[$registro->servicio_salud][$registro->alias_estab]['denominador'] = $registro->denominador;
          }
      }

      /* ==== Calculos ==== */
      foreach($data as $nombre_comuna => $comuna) {
          foreach($comuna as $nombre_establecimiento => $establecimiento) {
              /* Existe en el array un indice ['numerador'], ['denominador'] y ['meta'],
               * estos almacenan la información de la comuna, por lo tanto tengo que saltarlos
               * en la iteración del foreach y continuar con los establecimientos */
              /* Realizar los calculos mensuales */
              if($nombre_establecimiento != 'numerador' AND
                  $nombre_establecimiento != 'numerador_6' AND
                  $nombre_establecimiento != 'denominador' AND
                  $nombre_establecimiento != 'denominador_6' AND
                  $nombre_establecimiento != 'meta' AND
                  $nombre_establecimiento != 'cumplimiento'){

                  /* Calculo de las metas de cada establecimiento */
                  if($data[$nombre_comuna][$nombre_establecimiento]['denominador'] == 0) {
                      /* Si es 0 el denominadore entonces la meta es 0 */
                      $data[$nombre_comuna][$nombre_establecimiento]['cumplimiento'] = 0;
                  }
                  else {
                      /* De lo contrario calcular el porcentaje */
                      $data[$nombre_comuna][$nombre_establecimiento]['cumplimiento'] =
                          $data[$nombre_comuna][$nombre_establecimiento]['numerador'] / $data[$nombre_comuna][$nombre_establecimiento]['denominador'] * 100;
                  }

                  /* Fija la meta de la comuna también a sus establecimientos */
                  $data[$nombre_comuna][$nombre_establecimiento]['meta'] = $data[$nombre_comuna]['meta'];

                  /* Calculo de las metas de la comuna */
                  if($data[$nombre_comuna]['denominador'] == 0) {
                      /* Si es 0 el denominadore entonces la meta es 0 */
                      $data[$nombre_comuna]['cumplimiento'] = 0;
                  }
                  else {
                      /* De lo contrario calcular el porcentaje */
                      $data[$nombre_comuna]['cumplimiento'] = $data[$nombre_comuna]['numerador'] / $data[$nombre_comuna]['denominador'] * 100;
                  }
              }
          }
      }

      /* INDICADOR 3 */

      $label3['meta'] = '3. Porcentaje de egreso de maternidades con Lactancia materna Exclusiva (LME).';
      $label3['numerador'] = 'N° de egresos de maternidad con LME.';
      $label3['denominador'] = 'N° total de egresos de maternidad.';

      $meses = array(1,2,3,4,5,6,7,8,9,10,11,12);
      $flag1 = NULL;
      $flag2 = NULL;
      $data3 = array();

      $sql_establecimientos ='SELECT servicio_salud, dependencia, alias_estab
                              FROM establecimientos
                              WHERE meta_san_18834 = 1
                              ORDER BY comuna';

      $establecimientos = DB::connection('mysql_rem')->select($sql_establecimientos);

      /* ==== Inicializar en 0 el arreglo de datos $data ==== */
      foreach($establecimientos as $establecimiento) {
          $data3[$establecimiento->servicio_salud]['numeradores']['total'] = 0;
          $data3[$establecimiento->servicio_salud]['denominadores']['total'] = 0;
          $data3[$establecimiento->servicio_salud]['cumplimiento'] = 0;
          foreach($meses as $mes) {
              $data3[$establecimiento->servicio_salud]['numeradores'][$mes] = 0;
              $data3[$establecimiento->servicio_salud]['denominadores'][$mes] = 0;
              $data3[$establecimiento->servicio_salud][$establecimiento->alias_estab]['numeradores']['total'] = 0;
              $data3[$establecimiento->servicio_salud][$establecimiento->alias_estab]['denominadores']['total'] = 0;
              $data3[$establecimiento->servicio_salud][$establecimiento->alias_estab]['numeradores'][$mes] = 0;
              $data3[$establecimiento->servicio_salud][$establecimiento->alias_estab]['denominadores'][$mes] = 0;
          }
          $data3[$establecimiento->servicio_salud][$establecimiento->alias_estab]['cumplimiento'] = 0;

      }

      $data3['SERVICIO DE SALUD IQUIQUE']['meta'] = '≥90%';

      /* ===== Query numerador ===== */
      $sql_numerador = 'SELECT e.servicio_salud, e.alias_estab, r.Mes, ifnull(Col01,0) as numerador
          FROM '.$year.'rems r
          LEFT JOIN establecimientos e
          ON r.IdEstablecimiento=e.Codigo
          WHERE CodigoPrestacion = 24200100 AND e.meta_san_18834 = 1
          ORDER BY e.servicio_salud, e.alias_estab, r.Mes';
      $numeradores = DB::connection('mysql_rem')->select($sql_numerador);

      foreach($numeradores as $registro) {
          if( ($flag1 != $registro->servicio_salud) OR ($flag2 != $registro->alias_estab) ) {
              foreach($meses as $mes) {
                  $data3[$registro->servicio_salud][$registro->alias_estab]['numeradores'][$mes] = 0;
              }
              $flag1 = $registro->servicio_salud;
              $flag2 = $registro->alias_estab;
          }
          $data3[$registro->servicio_salud][$registro->alias_estab]['numeradores'][$registro->Mes] = $registro->numerador;
      }

      /* ===== Query denominador ===== */
      $sql_denominador = 'SELECT e.servicio_salud, e.alias_estab, r.Mes, ifnull(Col01,0) as denominador
          FROM '.$year.'rems r
          LEFT JOIN establecimientos e
          ON r.IdEstablecimiento=e.Codigo
          WHERE CodigoPrestacion = 24200134 AND e.meta_san_18834 = 1
          ORDER BY e.servicio_salud, e.alias_estab, r.Mes';
      $denominadores = DB::connection('mysql_rem')->select($sql_denominador);

      foreach($denominadores as $registro) {
          if( ($flag1 != $registro->servicio_salud) OR ($flag2 != $registro->alias_estab) ) {
              foreach($meses as $mes) {
                  $data3[$registro->servicio_salud][$registro->alias_estab]['denominadores'][$mes] = 0;
              }
              $flag1 = $registro->servicio_salud;
              $flag2 = $registro->alias_estab;
          }
          $data3[$registro->servicio_salud][$registro->alias_estab]['denominadores'][$registro->Mes] = $registro->denominador;
      }

      /* ==== Calculos ==== */
      foreach($data3 as $nombre_comuna => $comuna) {
          foreach($comuna as $nombre_establecimiento => $establecimiento) {
              /* Existe en el array un indice ['numerador'], ['denominador'] y ['meta'],
               * estos almacenan la información de la comuna, por lo tanto tengo que saltarlos
               * en la iteración del foreach y continuar con los establecimientos */
              /* Realizar los calculos mensuales */
              if($nombre_establecimiento != 'numeradores' AND
                  $nombre_establecimiento != 'denominadores' AND
                  $nombre_establecimiento != 'meta' AND
                  $nombre_establecimiento != 'cumplimiento'){

                  /* Calcula los totales de cada establecimiento */
                  $data3[$nombre_comuna][$nombre_establecimiento]['denominadores']['total'] = array_sum($establecimiento['denominadores']);
                  $data3[$nombre_comuna][$nombre_establecimiento]['numeradores']['total'] = array_sum($establecimiento['numeradores']);

                  /* Calcula los totales de cada comuna */
                  $data3[$nombre_comuna]['numeradores']['total'] += $data3[$nombre_comuna][$nombre_establecimiento]['numeradores']['total'];
                  $data3[$nombre_comuna]['denominadores']['total'] += $data3[$nombre_comuna][$nombre_establecimiento]['denominadores']['total'];

                  /* Calcula la suma mensual por comuna */
                  foreach($meses as $mes){
                      $data3[$nombre_comuna]['numeradores'][$mes] += $establecimiento['numeradores'][$mes];
                      $data3[$nombre_comuna]['denominadores'][$mes] += $establecimiento['denominadores'][$mes];
                  }

                  /* Calculo de las metas de cada establecimiento */
                  if($data3[$nombre_comuna][$nombre_establecimiento]['denominadores']['total'] == 0) {
                      /* Si es 0 el denominadore entonces el cumplimiento es 0 */
                      $data3[$nombre_comuna][$nombre_establecimiento]['cumplimiento'] = 0;
                  }
                  else {
                      /* De lo contrario calcular el porcentaje */
                      $data3[$nombre_comuna][$nombre_establecimiento]['cumplimiento'] = $data3[$nombre_comuna][$nombre_establecimiento]['numeradores']['total'] / $data3[$nombre_comuna][$nombre_establecimiento]['denominadores']['total'] * 100;
                  }

                  /* Calculo de las metas de la comuna */
                  if($data3[$nombre_comuna]['denominadores']['total'] == 0) {
                      /* Si es 0 el denominadore entonces el cumplimiento es 0 */
                      $data3[$nombre_comuna]['cumplimiento'] = 0;
                  }
                  else {
                      /* De lo contrario calcular el porcentaje */
                      $data3[$nombre_comuna]['cumplimiento'] = $data3[$nombre_comuna]['numeradores']['total'] / $data3[$nombre_comuna]['denominadores']['total'] * 100;
                  }
              }
          }
      }

        /********** META 8 **********/

        $data8['label'] = '8. Porcentaje de casos con Garantías Explicitas de salud, en lo que se cumplen las garantías del año t.';
        $data8['label_numerador']   = 'N° de casos GES con garantías cumplidas del año t.';
        $data8['label_denominador'] = 'N° Total de caos GES del año t.';
        $data8['meta'] = '100%';

        $base_where = array(['law','18834'],['year',2018],['indicator',8],['establishment_id',9],['position','numerador']);

        $data8['numeradores'][1] = SingleParameter::where(array_merge($base_where,array(['month',1])))->first()->value;
        $data8['numeradores'][2] = SingleParameter::where(array_merge($base_where,array(['month',2])))->first()->value;
        $data8['numeradores'][3] = SingleParameter::where(array_merge($base_where,array(['month',3])))->first()->value;
        $data8['numeradores'][4] = SingleParameter::where(array_merge($base_where,array(['month',4])))->first()->value;
        $data8['numeradores'][5] = SingleParameter::where(array_merge($base_where,array(['month',5])))->first()->value;
        $data8['numeradores'][6] = SingleParameter::where(array_merge($base_where,array(['month',6])))->first()->value;
        $data8['numeradores'][7] = SingleParameter::where(array_merge($base_where,array(['month',7])))->first()->value;
        $data8['numeradores'][8] = SingleParameter::where(array_merge($base_where,array(['month',8])))->first()->value;
        $data8['numeradores'][9] = SingleParameter::where(array_merge($base_where,array(['month',9])))->first()->value;
        $data8['numeradores'][10] = SingleParameter::where(array_merge($base_where,array(['month',10])))->first()->value;
        $data8['numeradores'][11] = SingleParameter::where(array_merge($base_where,array(['month',11])))->first()->value;
        $data8['numeradores'][12] = SingleParameter::where(array_merge($base_where,array(['month',12])))->first()->value;
        $data8['numerador_acumulado'] = array_sum($data8['numeradores']);

        $base_where = array(['law','18834'],['year',2018],['indicator',8],['establishment_id',9],['position','denominador']);
        $data8['denominadores'][1] = SingleParameter::where(array_merge($base_where,array(['month',1])))->first()->value;
        $data8['denominadores'][2] = SingleParameter::where(array_merge($base_where,array(['month',2])))->first()->value;
        $data8['denominadores'][3] = SingleParameter::where(array_merge($base_where,array(['month',3])))->first()->value;
        $data8['denominadores'][4] = SingleParameter::where(array_merge($base_where,array(['month',4])))->first()->value;
        $data8['denominadores'][5] = SingleParameter::where(array_merge($base_where,array(['month',5])))->first()->value;
        $data8['denominadores'][6] = SingleParameter::where(array_merge($base_where,array(['month',6])))->first()->value;
        $data8['denominadores'][7] = SingleParameter::where(array_merge($base_where,array(['month',7])))->first()->value;
        $data8['denominadores'][8] = SingleParameter::where(array_merge($base_where,array(['month',8])))->first()->value;
        $data8['denominadores'][9] = SingleParameter::where(array_merge($base_where,array(['month',9])))->first()->value;
        $data8['denominadores'][10] = SingleParameter::where(array_merge($base_where,array(['month',10])))->first()->value;
        $data8['denominadores'][11] = SingleParameter::where(array_merge($base_where,array(['month',11])))->first()->value;
        $data8['denominadores'][12] = SingleParameter::where(array_merge($base_where,array(['month',12])))->first()->value;
        $data8['denominador_acumulado'] = array_sum($data8['denominadores']);

        //$cumplimiento = ;
        $data8['cumplimiento'] = number_format(
            $data8['numerador_acumulado'] / $data8['denominador_acumulado'] * 100,2, ',', '.');


        /********** META 9 **********/

        $data9['label'] = '9. Porcentaje de pretaciones trazadoras de tratamiento
                        GES otrogadas según lo programado de prestaciones
                        trazadoras de tratamiento GES en contrato PPC para el año t';
        $data9['label_numerador']   = 'Número de prestaciones trazadoras de tratamiento GES otorgadas dentro del año t.';
        $data9['label_denominador'] = 'N° de prestaciones trazadoras de tratamiento GES programadas en el contrato PPV para el año t.';
        $data9['meta'] = '100%';

        $base_where = array(['law','18834'],['year',2018],['indicator',9],['establishment_id',9],['position','numerador']);
        $data9['numerador_acumulado'] = SingleParameter::where($base_where)->first()->value;

        $base_where = array(['law','18834'],['year',2018],['indicator',9],['establishment_id',9],['position','denominador']);
        $data9['denominador_acumulado'] = SingleParameter::where($base_where)->first()->value;

        $data9['cumplimiento'] = number_format(
            $data9['numerador_acumulado'] / $data9['denominador_acumulado'] * 100,2, ',', '.');

        $data9['vigencia'] = '';

        /********** META 10 **********/

        $data10['label'] = '10. Porcentajes de funcionarios regidos por el
            Estatuto Administrativo, capacitados durante el año 2018 en
            al menos una actividad de capacitación pertinente,
            de los nueve Ejes Estratégicos de Estrategia Nacional de Salud.';
        $data10['label_numerador']   = 'N° de funcionarios regidos por el EA capacitados durante el año 2018 en al menos una actividad de capacitación pertinene de los nueve Ejes de la Estrategia Nacional de Salud';
        $data10['label_denominador'] = 'N° total de funcionarios de dotación, regidos por el EA';
        $data10['meta'] = '50%';

        $base_where = array(['law','18834'],['year',2018],['indicator',10],['establishment_id',9],['position','numerador']);
        $data10['numerador_acumulado'] = SingleParameter::where($base_where)->first()->value;

        $base_where = array(['law','18834'],['year',2018],['indicator',10],['establishment_id',9],['position','denominador']);
        $data10['denominador_acumulado'] = SingleParameter::where($base_where)->first()->value;

        $data10['cumplimiento'] = number_format(
            $data10['numerador_acumulado'] / $data10['denominador_acumulado'] * 100,2, ',', '.');

        $data10['vigencia'] = 7;

        //echo '<pre>'; print_r($data8); die();
        //echo '<pre>'; print_r($data); die();
        //echo '<pre>'; print_r($data);
        return view('indicators.18834.2018.servicio', compact('data','label','data3','label3','data8','data9','data10'));
    }

    //HOSPITAL

    public function hospital(){
        $year= 2018;

      /* INDICADOR 3 */

      $label3['meta'] = '3. Porcentaje de egreso de maternidades con Lactancia materna Exclusiva (LME).';
      $label3['numerador'] = 'N° de egresos de maternidad con LME.';
      $label3['denominador'] = 'N° total de egresos de maternidad.';

      $meses = array(1,2,3,4,5,6,7,8,9,10,11,12);
      $flag1 = NULL;
      $flag2 = NULL;
      $data3 = array();

      $sql_establecimientos ='SELECT servicio_salud, dependencia, alias_estab
                              FROM establecimientos
                              WHERE meta_san_18834_hosp = 1
                              ORDER BY comuna';

      $establecimientos = DB::connection('mysql_rem')->select($sql_establecimientos);

      /* ==== Inicializar en 0 el arreglo de datos $data ==== */
      foreach($establecimientos as $establecimiento) {
          $data3[$establecimiento->alias_estab]['numeradores']['total'] = 0;
          $data3[$establecimiento->alias_estab]['denominadores']['total'] = 0;
          $data3[$establecimiento->alias_estab]['cumplimiento'] = 0;
          foreach($meses as $mes) {
              $data3[$establecimiento->alias_estab]['numeradores'][$mes] = 0;
              $data3[$establecimiento->alias_estab]['denominadores'][$mes] = 0;
              $data3[$establecimiento->alias_estab][$establecimiento->alias_estab]['numeradores']['total'] = 0;
              $data3[$establecimiento->alias_estab][$establecimiento->alias_estab]['denominadores']['total'] = 0;
              $data3[$establecimiento->alias_estab][$establecimiento->alias_estab]['numeradores'][$mes] = 0;
              $data3[$establecimiento->alias_estab][$establecimiento->alias_estab]['denominadores'][$mes] = 0;
          }
          $data3[$establecimiento->alias_estab][$establecimiento->alias_estab]['cumplimiento'] = 0;

      }

      $data3['Hospital Dr. Ernesto Torres G.']['meta'] = '≥90%';

      /* ===== Query numerador ===== */
      $sql_numerador = 'SELECT e.servicio_salud, e.alias_estab, r.Mes, ifnull(Col01,0) as numerador
          FROM '.$year.'rems r
          LEFT JOIN establecimientos e
          ON r.IdEstablecimiento=e.Codigo
          WHERE CodigoPrestacion = 24200100 AND e.meta_san_18834_hosp = 1
          ORDER BY e.servicio_salud, e.alias_estab, r.Mes';
      $numeradores = DB::connection('mysql_rem')->select($sql_numerador);

      foreach($numeradores as $registro) {
          if( ($flag1 != $registro->alias_estab) OR ($flag2 != $registro->alias_estab) ) {
              foreach($meses as $mes) {
                  $data3[$registro->alias_estab][$registro->alias_estab]['numeradores'][$mes] = 0;
              }
              $flag1 = $registro->alias_estab;
              $flag2 = $registro->alias_estab;
          }
          $data3[$registro->alias_estab][$registro->alias_estab]['numeradores'][$registro->Mes] = $registro->numerador;
      }

      /* ===== Query denominador ===== */
      $sql_denominador = 'SELECT e.servicio_salud, e.alias_estab, r.Mes, ifnull(Col01,0) as denominador
          FROM '.$year.'rems r
          LEFT JOIN establecimientos e
          ON r.IdEstablecimiento=e.Codigo
          WHERE CodigoPrestacion = 24200134 AND e.meta_san_18834_hosp = 1
          ORDER BY e.servicio_salud, e.alias_estab, r.Mes';
      $denominadores = DB::connection('mysql_rem')->select($sql_denominador);

      foreach($denominadores as $registro) {
          if( ($flag1 != $registro->alias_estab) OR ($flag2 != $registro->alias_estab) ) {
              foreach($meses as $mes) {
                  $data3[$registro->alias_estab][$registro->alias_estab]['denominadores'][$mes] = 0;
              }
              $flag1 = $registro->alias_estab;
              $flag2 = $registro->alias_estab;
          }
          $data3[$registro->alias_estab][$registro->alias_estab]['denominadores'][$registro->Mes] = $registro->denominador;
      }

      /* ==== Calculos ==== */
      foreach($data3 as $nombre_comuna => $comuna) {
          foreach($comuna as $nombre_establecimiento => $establecimiento) {
              /* Existe en el array un indice ['numerador'], ['denominador'] y ['meta'],
               * estos almacenan la información de la comuna, por lo tanto tengo que saltarlos
               * en la iteración del foreach y continuar con los establecimientos */
              /* Realizar los calculos mensuales */
              if($nombre_establecimiento != 'numeradores' AND
                  $nombre_establecimiento != 'denominadores' AND
                  $nombre_establecimiento != 'meta' AND
                  $nombre_establecimiento != 'cumplimiento'){

                  /* Calcula los totales de cada establecimiento */
                  $data3[$nombre_comuna][$nombre_establecimiento]['denominadores']['total'] = array_sum($establecimiento['denominadores']);
                  $data3[$nombre_comuna][$nombre_establecimiento]['numeradores']['total'] = array_sum($establecimiento['numeradores']);

                  /* Calcula los totales de cada comuna */
                  $data3[$nombre_comuna]['numeradores']['total'] += $data3[$nombre_comuna][$nombre_establecimiento]['numeradores']['total'];
                  $data3[$nombre_comuna]['denominadores']['total'] += $data3[$nombre_comuna][$nombre_establecimiento]['denominadores']['total'];

                  /* Calcula la suma mensual por comuna */
                  foreach($meses as $mes){
                      $data3[$nombre_comuna]['numeradores'][$mes] += $establecimiento['numeradores'][$mes];
                      $data3[$nombre_comuna]['denominadores'][$mes] += $establecimiento['denominadores'][$mes];
                  }

                  /* Calculo de las metas de cada establecimiento */
                  if($data3[$nombre_comuna][$nombre_establecimiento]['denominadores']['total'] == 0) {
                      /* Si es 0 el denominadore entonces el cumplimiento es 0 */
                      $data3[$nombre_comuna][$nombre_establecimiento]['cumplimiento'] = 0;
                  }
                  else {
                      /* De lo contrario calcular el porcentaje */
                      $data3[$nombre_comuna][$nombre_establecimiento]['cumplimiento'] = $data3[$nombre_comuna][$nombre_establecimiento]['numeradores']['total'] / $data3[$nombre_comuna][$nombre_establecimiento]['denominadores']['total'] * 100;
                  }

                  /* Calculo de las metas de la comuna */
                  if($data3[$nombre_comuna]['denominadores']['total'] == 0) {
                      /* Si es 0 el denominadore entonces el cumplimiento es 0 */
                      $data3[$nombre_comuna]['cumplimiento'] = 0;
                  }
                  else {
                      /* De lo contrario calcular el porcentaje */
                      $data3[$nombre_comuna]['cumplimiento'] = $data3[$nombre_comuna]['numeradores']['total'] / $data3[$nombre_comuna]['denominadores']['total'] * 100;
                  }
              }
          }
      }

      //INDICADOR 5

      $label5['meta'] = '5. Porcentaje de cumplimiento de programación de consultas de profesionales no médicos de establecimientos hospitalarios de alta complejidad.';
      $label5['numerador'] = 'Total, de número de consultas de profesionales no médicos realizadas.';
      $label5['denominador'] = 'Total, de número de consultas de profesionales no médicos programadas.';

      $meses = array(1,2,3,4,5,6,7,8,9,10,11,12);
      $flag1 = NULL;
      $flag2 = NULL;
      $data5 = array();

      $sql_establecimientos ='SELECT comuna, dependencia, alias_estab
                              FROM establecimientos
                              WHERE meta_san_18834_hosp = 1
                              ORDER BY comuna';

      $establecimientos = DB::connection('mysql_rem')->select($sql_establecimientos);

      /* ==== Inicializar en 0 el arreglo de datos $data ==== */
      foreach($establecimientos as $establecimiento) {
          $data5[$establecimiento->alias_estab]['numeradores']['total'] = 0;
          $data5[$establecimiento->alias_estab]['denominador']['total'] = 0;
          $data5[$establecimiento->alias_estab]['cumplimiento'] = 0;
          foreach($meses as $mes) {
              $data5[$establecimiento->alias_estab]['numeradores'][$mes] = 0;
              $data5[$establecimiento->alias_estab][$establecimiento->alias_estab]['numeradores']['total'] = 0;
              $data5[$establecimiento->alias_estab][$establecimiento->alias_estab]['numeradores_2']['total'] = 0;
              $data5[$establecimiento->alias_estab][$establecimiento->alias_estab]['numeradores'][$mes] = 0;
              $data5[$establecimiento->alias_estab][$establecimiento->alias_estab]['numeradores_2'][$mes] = 0;
          }
          $data5[$establecimiento->alias_estab][$establecimiento->alias_estab]['cumplimiento'] = 0;
      }

      $data5['Hospital Dr. Ernesto Torres G.']['meta'] = '≥95%';

      /* ===== Query numerador ===== */
      $sql_numerador = 'SELECT e.alias_estab, r.Mes, sum(ifnull(Col01,0)) as numerador
        FROM '.$year.'rems r
        LEFT JOIN establecimientos e
        ON r.IdEstablecimiento=e.Codigo
        WHERE e.meta_san_18834_hosp = 1
        AND CodigoPrestacion IN (07024900, 07024915, 07024925, 07024935, 07024920, 07024816, 07024607, 07024817, 07024809, 07024705, 07024506)
        GROUP by e.Comuna, e.alias_estab, r.Mes
        ORDER BY e.Comuna, e.alias_estab, r.Mes';
      $numeradores = DB::connection('mysql_rem')->select($sql_numerador);

      foreach($numeradores as $registro) {
          if( ($flag1 != $registro->alias_estab) OR ($flag2 != $registro->alias_estab) ) {
              foreach($meses as $mes) {
                  $data[$registro->alias_estab][$registro->alias_estab]['numeradores'][$mes] = 0;
              }
              $flag1 = $registro->alias_estab;
              $flag2 = $registro->alias_estab;
          }
          $data5[$registro->alias_estab][$registro->alias_estab]['numeradores'][$registro->Mes] = $registro->numerador;
      }

      /* ===== Query denominador ===== */
      $sql_numerador_2 = 'SELECT e.alias_estab, r.Mes, sum(ifnull(Col39,0)) as numerador_2
          FROM '.$year.'rems r
          LEFT JOIN establecimientos e
          ON r.IdEstablecimiento=e.Codigo
          WHERE e.meta_san_18834_hosp = 1
          AND CodigoPrestacion IN (07024900, 07024915, 07024925, 07024935, 07024920, 07024816, 07024607, 07024817, 07024809, 07024705, 07024506)
          GROUP by e.Comuna, e.alias_estab, r.Mes
          ORDER BY e.Comuna, e.alias_estab, r.Mes';
      $numeradores_2 = DB::connection('mysql_rem')->select($sql_numerador_2);

      foreach($numeradores_2 as $registro) {
          if( ($flag1 != $registro->alias_estab) OR ($flag2 != $registro->alias_estab) ) {
              foreach($meses as $mes) {
                  $data[$registro->alias_estab][$registro->alias_estab]['numeradores_2'][$mes] = 0;
              }
              $flag1 = $registro->alias_estab;
              $flag2 = $registro->alias_estab;
          }
          $data5[$registro->alias_estab][$registro->alias_estab]['numeradores_2'][$registro->Mes] = $registro->numerador_2;
      }

      $data5['Hospital Dr. Ernesto Torres G.']['denominador']['total'] = 27990;

      /* ==== Calculos ==== */
      foreach($data5 as $nombre_comuna => $comuna) {
          foreach($comuna as $nombre_establecimiento => $establecimiento) {
              /* Existe en el array un indice ['numerador'], ['denominador'] y ['meta'],
               * estos almacenan la información de la comuna, por lo tanto tengo que saltarlos
               * en la iteración del foreach y continuar con los establecimientos */
              /* Realizar los calculos mensuales */

              if($nombre_establecimiento != 'numeradores' AND
                  $nombre_establecimiento != 'numeradores_2' AND
                  $nombre_establecimiento != 'denominador' AND
                  $nombre_establecimiento != 'meta' AND
                  $nombre_establecimiento != 'cumplimiento'){

                  /* Calcula los totales de cada establecimiento */
                  $data5[$nombre_comuna][$nombre_establecimiento]['numeradores']['total'] = array_sum($establecimiento['numeradores']);
                  $data5[$nombre_comuna][$nombre_establecimiento]['numeradores_2']['total'] = array_sum($establecimiento['numeradores_2']);

                  /* Calcula los totales de cada comuna */
                  $data5[$nombre_comuna]['numeradores']['total'] = $data5[$nombre_comuna][$nombre_establecimiento]['numeradores']['total'] - $data5[$nombre_comuna][$nombre_establecimiento]['numeradores_2']['total'];

                  /* Calcula la suma mensual por comuna */
                  foreach($meses as $mes){
                      $data5[$nombre_comuna]['numeradores'][$mes] = $establecimiento['numeradores'][$mes]-$establecimiento['numeradores_2'][$mes];
                  }

                  /* Calculo de las metas de la comuna */
                  if($data5[$nombre_comuna]['denominador']['total'] == 0) {
                      /* Si es 0 el denominadore entonces el cumplimiento es 0 */
                      $data5[$nombre_comuna]['cumplimiento'] = 0;
                  }
                  else {
                      /* De lo contrario calcular el porcentaje */
                      $data5[$nombre_comuna]['cumplimiento'] = $data5[$nombre_comuna]['numeradores']['total'] / $data5[$nombre_comuna]['denominador']['total'] * 100;
                  }
              }
          }
      }

      //INDICADOR 6

      $label6['meta'] = '6. Porcentaje de categorización de Urgencia a través de ESI en las UEH.';
      $label6['numerador'] = 'Número de pacientes categorizados según herramienta ESI en Unidad de Emergencia Hospitalaria, en establecimientos de alta y mediana complejidad.';
      $label6['denominador'] = 'Total, de pacientes con consultas de Urgencia realizadas en Unidades de Emergencia Hospitalaria (UEH) de establecimientos de alta y mediana complejidad.';

      $meses = array(1,2,3,4,5,6,7,8,9,10,11,12);
      $flag1 = NULL;
      $flag2 = NULL;
      $data = array();

      $sql_establecimientos ='SELECT dependencia, alias_estab
                              FROM establecimientos
                              WHERE meta_san_18834_hosp = 1
                              ORDER BY comuna';

      $establecimientos = DB::connection('mysql_rem')->select($sql_establecimientos);

      /* ==== Inicializar en 0 el arreglo de datos $data ==== */
      foreach($establecimientos as $establecimiento) {
          $data6[$establecimiento->alias_estab]['numeradores']['total'] = 0;
          $data6[$establecimiento->alias_estab]['denominadores']['total'] = 0;
          $data6[$establecimiento->alias_estab]['cumplimiento'] = 0;
          foreach($meses as $mes) {
              $data6[$establecimiento->alias_estab]['numeradores'][$mes] = 0;
              $data6[$establecimiento->alias_estab]['denominadores'][$mes] = 0;
              $data6[$establecimiento->alias_estab][$establecimiento->alias_estab]['numeradores']['total'] = 0;
              $data6[$establecimiento->alias_estab][$establecimiento->alias_estab]['denominadores']['total'] = 0;
              $data6[$establecimiento->alias_estab][$establecimiento->alias_estab]['numeradores'][$mes] = 0;
              $data6[$establecimiento->alias_estab][$establecimiento->alias_estab]['denominadores'][$mes] = 0;
          }
          $data[$establecimiento->alias_estab][$establecimiento->alias_estab]['cumplimiento'] = 0;

      }

      $data6['Hospital Dr. Ernesto Torres G.']['meta'] = '≥90%';

      /* ===== Query numerador ===== */
      $sql_numerador = 'SELECT e.alias_estab, r.Mes, sum(ifnull(Col39,0)) as numerador
        FROM '.$year.'rems r
        LEFT JOIN establecimientos e
        ON r.IdEstablecimiento=e.Codigo
        WHERE e.meta_san_18834_hosp = 1
        AND CodigoPrestacion IN (08180201, 08180202, 08180203, 08180204, 08222610)
        GROUP by e.Comuna, e.alias_estab, r.Mes
        ORDER BY e.Comuna, e.alias_estab, r.Mes';
      $numeradores = DB::connection('mysql_rem')->select($sql_numerador);

      foreach($numeradores as $registro) {
          if( ($flag1 != $registro->alias_estab) OR ($flag2 != $registro->alias_estab) ) {
              foreach($meses as $mes) {
                  $data[$registro->alias_estab][$registro->alias_estab]['numeradores'][$mes] = 0;
              }
              $flag1 = $registro->alias_estab;
              $flag2 = $registro->alias_estab;
          }
          $data6[$registro->alias_estab][$registro->alias_estab]['numeradores'][$registro->Mes] = $registro->numerador;
      }

      /* ===== Query denominador ===== */
      $sql_denominador = 'SELECT e.alias_estab, r.Mes, ifnull(Col01,0) as denominador
          FROM '.$year.'rems r
          LEFT JOIN establecimientos e
          ON r.IdEstablecimiento=e.Codigo
          WHERE CodigoPrestacion = 08221000
          AND e.meta_san_18834_hosp = 1
          AND r.Mes > 6
          ORDER BY e.Comuna, e.alias_estab, r.Mes';
      $denominadores = DB::connection('mysql_rem')->select($sql_denominador);

      foreach($denominadores as $registro) {
          if( ($flag1 != $registro->alias_estab) OR ($flag2 != $registro->alias_estab) ) {
              foreach($meses as $mes) {
                  $data6[$registro->alias_estab][$registro->alias_estab]['denominadores'][$mes] = 0;
              }
              $flag1 = $registro->alias_estab;
              $flag2 = $registro->alias_estab;
          }
          $data6[$registro->alias_estab][$registro->alias_estab]['denominadores'][$registro->Mes] = $registro->denominador;
      }

      /* ==== Calculos ==== */
      foreach($data6 as $nombre_comuna => $comuna) {
          foreach($comuna as $nombre_establecimiento => $establecimiento) {
              /* Existe en el array un indice ['numerador'], ['denominador'] y ['meta'],
               * estos almacenan la información de la comuna, por lo tanto tengo que saltarlos
               * en la iteración del foreach y continuar con los establecimientos */
              /* Realizar los calculos mensuales */
              if($nombre_establecimiento != 'numeradores' AND
                  $nombre_establecimiento != 'denominadores' AND
                  $nombre_establecimiento != 'meta' AND
                  $nombre_establecimiento != 'cumplimiento'){

                  /* Calcula los totales de cada establecimiento */
                  $data6[$nombre_comuna][$nombre_establecimiento]['denominadores']['total'] = array_sum($establecimiento['denominadores']);
                  $data6[$nombre_comuna][$nombre_establecimiento]['numeradores']['total'] = array_sum($establecimiento['numeradores']);

                  /* Calcula los totales de cada comuna */
                  $data6[$nombre_comuna]['numeradores']['total'] += $data6[$nombre_comuna][$nombre_establecimiento]['numeradores']['total'];
                  $data6[$nombre_comuna]['denominadores']['total'] += $data6[$nombre_comuna][$nombre_establecimiento]['denominadores']['total'];

                  /* Calcula la suma mensual por comuna */
                  foreach($meses as $mes){
                      $data6[$nombre_comuna]['numeradores'][$mes] += $establecimiento['numeradores'][$mes];
                      $data6[$nombre_comuna]['denominadores'][$mes] += $establecimiento['denominadores'][$mes];
                  }

                  /* Calculo de las metas de cada establecimiento */
                  if($data6[$nombre_comuna][$nombre_establecimiento]['denominadores']['total'] == 0) {
                      /* Si es 0 el denominadore entonces el cumplimiento es 0 */
                      $data6[$nombre_comuna][$nombre_establecimiento]['cumplimiento'] = 0;
                  }
                  else {
                      /* De lo contrario calcular el porcentaje */
                      $data6[$nombre_comuna][$nombre_establecimiento]['cumplimiento'] = $data6[$nombre_comuna][$nombre_establecimiento]['numeradores']['total'] / $data6[$nombre_comuna][$nombre_establecimiento]['denominadores']['total'] * 100;
                  }

                  /* Calculo de las metas de la comuna */
                  if($data6[$nombre_comuna]['denominadores']['total'] == 0) {
                      /* Si es 0 el denominadore entonces el cumplimiento es 0 */
                      $data6[$nombre_comuna]['cumplimiento'] = 0;
                  }
                  else {
                      /* De lo contrario calcular el porcentaje */
                      $data6[$nombre_comuna]['cumplimiento'] = $data6[$nombre_comuna]['numeradores']['total'] / $data6[$nombre_comuna]['denominadores']['total'] * 100;
                  }
              }
          }
      }

      /********** META 7 **********/

      $data7['label'] = '7. Porcentaje de categorización de pacientes en niveles de riesgo dependencia.';
      $data7['label_numerador']   = 'Número DC Categorizados';
      $data7['label_denominador'] = 'Número DC Ocupados en Camas que se Categorizan de Lunes a Domingo';
      $data7['meta'] = '90%';

      $base_where = array(['law','18834'],['year',2018],['indicator',7],['establishment_id',1],['position','numerador']);

      $data7['numeradores'][1] = SingleParameter::where(array_merge($base_where,array(['month',1])))->first()->value;
      $data7['numeradores'][2] = SingleParameter::where(array_merge($base_where,array(['month',2])))->first()->value;
      $data7['numeradores'][3] = SingleParameter::where(array_merge($base_where,array(['month',3])))->first()->value;
      $data7['numeradores'][4] = SingleParameter::where(array_merge($base_where,array(['month',4])))->first()->value;
      $data7['numeradores'][5] = SingleParameter::where(array_merge($base_where,array(['month',5])))->first()->value;
      $data7['numeradores'][6] = SingleParameter::where(array_merge($base_where,array(['month',6])))->first()->value;
      $data7['numeradores'][7] = SingleParameter::where(array_merge($base_where,array(['month',7])))->first()->value;
      $data7['numeradores'][8] = SingleParameter::where(array_merge($base_where,array(['month',8])))->first()->value;
      $data7['numeradores'][9] = SingleParameter::where(array_merge($base_where,array(['month',9])))->first()->value;
      $data7['numeradores'][10] = SingleParameter::where(array_merge($base_where,array(['month',10])))->first()->value;
      $data7['numeradores'][11] = SingleParameter::where(array_merge($base_where,array(['month',11])))->first()->value;
      $data7['numeradores'][12] = SingleParameter::where(array_merge($base_where,array(['month',12])))->first()->value;
      $data7['numerador_acumulado'] = array_sum($data7['numeradores']);

      $base_where = array(['law','18834'],['year',2018],['indicator',7],['establishment_id',1],['position','denominador']);
      $data7['denominadores'][1] = SingleParameter::where(array_merge($base_where,array(['month',1])))->first()->value;
      $data7['denominadores'][2] = SingleParameter::where(array_merge($base_where,array(['month',2])))->first()->value;
      $data7['denominadores'][3] = SingleParameter::where(array_merge($base_where,array(['month',3])))->first()->value;
      $data7['denominadores'][4] = SingleParameter::where(array_merge($base_where,array(['month',4])))->first()->value;
      $data7['denominadores'][5] = SingleParameter::where(array_merge($base_where,array(['month',5])))->first()->value;
      $data7['denominadores'][6] = SingleParameter::where(array_merge($base_where,array(['month',6])))->first()->value;
      $data7['denominadores'][7] = SingleParameter::where(array_merge($base_where,array(['month',7])))->first()->value;
      $data7['denominadores'][8] = SingleParameter::where(array_merge($base_where,array(['month',8])))->first()->value;
      $data7['denominadores'][9] = SingleParameter::where(array_merge($base_where,array(['month',9])))->first()->value;
      $data7['denominadores'][10] = SingleParameter::where(array_merge($base_where,array(['month',10])))->first()->value;
      $data7['denominadores'][11] = SingleParameter::where(array_merge($base_where,array(['month',11])))->first()->value;
      $data7['denominadores'][12] = SingleParameter::where(array_merge($base_where,array(['month',12])))->first()->value;
      $data7['denominador_acumulado'] = array_sum($data7['denominadores']);

      //$cumplimiento = ;
      $data7['cumplimiento'] = number_format(
          $data7['numerador_acumulado'] / $data7['denominador_acumulado'] * 100,2, ',', '.');



      /********** META 8 **********/

      $data8['label'] = '8. Porcentaje de casos con Garantías Explicitas de salud, en lo que se cumplen las garantías del año t.';
      $data8['label_numerador']   = 'N° de casos GES con garantías cumplidas del año t.';
      $data8['label_denominador'] = 'N° Total de caos GES del año t.';
      $data8['meta'] = '100%';

      $base_where = array(['law','18834'],['year',2018],['indicator',8],['establishment_id',1],['position','numerador']);

      $data8['numeradores'][1] = SingleParameter::where(array_merge($base_where,array(['month',1])))->first()->value;
      $data8['numeradores'][2] = SingleParameter::where(array_merge($base_where,array(['month',2])))->first()->value;
      $data8['numeradores'][3] = SingleParameter::where(array_merge($base_where,array(['month',3])))->first()->value;
      $data8['numeradores'][4] = SingleParameter::where(array_merge($base_where,array(['month',4])))->first()->value;
      $data8['numeradores'][5] = SingleParameter::where(array_merge($base_where,array(['month',5])))->first()->value;
      $data8['numeradores'][6] = SingleParameter::where(array_merge($base_where,array(['month',6])))->first()->value;
      $data8['numeradores'][7] = SingleParameter::where(array_merge($base_where,array(['month',7])))->first()->value;
      $data8['numeradores'][8] = SingleParameter::where(array_merge($base_where,array(['month',8])))->first()->value;
      $data8['numeradores'][9] = SingleParameter::where(array_merge($base_where,array(['month',9])))->first()->value;
      $data8['numeradores'][10] = SingleParameter::where(array_merge($base_where,array(['month',10])))->first()->value;
      $data8['numeradores'][11] = SingleParameter::where(array_merge($base_where,array(['month',11])))->first()->value;
      $data8['numeradores'][12] = SingleParameter::where(array_merge($base_where,array(['month',12])))->first()->value;
      $data8['numerador_acumulado'] = array_sum($data8['numeradores']);

      $base_where = array(['law','18834'],['year',2018],['indicator',8],['establishment_id',1],['position','denominador']);
      $data8['denominadores'][1] = SingleParameter::where(array_merge($base_where,array(['month',1])))->first()->value;
      $data8['denominadores'][2] = SingleParameter::where(array_merge($base_where,array(['month',2])))->first()->value;
      $data8['denominadores'][3] = SingleParameter::where(array_merge($base_where,array(['month',3])))->first()->value;
      $data8['denominadores'][4] = SingleParameter::where(array_merge($base_where,array(['month',4])))->first()->value;
      $data8['denominadores'][5] = SingleParameter::where(array_merge($base_where,array(['month',5])))->first()->value;
      $data8['denominadores'][6] = SingleParameter::where(array_merge($base_where,array(['month',6])))->first()->value;
      $data8['denominadores'][7] = SingleParameter::where(array_merge($base_where,array(['month',7])))->first()->value;
      $data8['denominadores'][8] = SingleParameter::where(array_merge($base_where,array(['month',8])))->first()->value;
      $data8['denominadores'][9] = SingleParameter::where(array_merge($base_where,array(['month',9])))->first()->value;
      $data8['denominadores'][10] = SingleParameter::where(array_merge($base_where,array(['month',10])))->first()->value;
      $data8['denominadores'][11] = SingleParameter::where(array_merge($base_where,array(['month',11])))->first()->value;
      $data8['denominadores'][12] = SingleParameter::where(array_merge($base_where,array(['month',12])))->first()->value;
      $data8['denominador_acumulado'] = array_sum($data8['denominadores']);

      //$cumplimiento = ;
      $data8['cumplimiento'] = number_format(
          $data8['numerador_acumulado'] / $data8['denominador_acumulado'] * 100,2, ',', '.');


      /********** META 9 **********/

      $data9['label'] = '9. Porcentaje de pretaciones trazadoras de tratamiento
                      GES otrogadas según lo programado de prestaciones
                      trazadoras de tratamiento GES en contrato PPC para el año t';
      $data9['label_numerador']   = 'Número de prestaciones trazadoras de tratamiento GES otorgadas dentro del año t.';
      $data9['label_denominador'] = 'N° de prestaciones trazadoras de tratamiento GES programadas en el contrato PPV para el año t.';
      $data9['meta'] = '100%';

      $base_where = array(['law','18834'],['year',2018],['indicator',9],['establishment_id',1],['position','numerador']);
      $data9['numerador_acumulado'] = SingleParameter::where($base_where)->first()->value;

      $base_where = array(['law','18834'],['year',2018],['indicator',9],['establishment_id',1],['position','denominador']);
      $data9['denominador_acumulado'] = SingleParameter::where($base_where)->first()->value;

      $data9['cumplimiento'] = number_format(
          $data9['numerador_acumulado'] / $data9['denominador_acumulado'] * 100,2, ',', '.');

      /* reporte a mes*/
      $data9['vigencia'] = '';

      /********** META 10 **********/

      $data10['label'] = '10. Porcentajes de funcionarios regidos por el
          Estatuto Administrativo, capacitados durante el año 2018 en
          al menos una actividad de capacitación pertinente,
          de los nueve Ejes Estratégicos de Estrategia Nacional de Salud.';
      $data10['label_numerador']   = 'N° de funcionarios regidos por el EA capacitados durante el año 2018 en al menos una actividad de capacitación pertinene de los nueve Ejes de la Estrategia Nacional de Salud';
      $data10['label_denominador'] = 'N° total de funcionarios de dotación, regidos por el EA';
      $data10['meta'] = '50%';

      $base_where = array(['law','18834'],['year',2018],['indicator',10],['establishment_id',1],['position','numerador']);
      $data10['numerador_acumulado'] = SingleParameter::where($base_where)->first()->value;

      $base_where = array(['law','18834'],['year',2018],['indicator',10],['establishment_id',1],['position','denominador']);
      $data10['denominador_acumulado'] = SingleParameter::where($base_where)->first()->value;

      $data10['cumplimiento'] = number_format(
          $data10['numerador_acumulado'] / $data10['denominador_acumulado'] * 100,2, ',', '.');

      $data10['vigencia'] = 12;

      //echo '<pre>'; print_r($data); die();
      //echo '<pre>'; print_r($data);
      return view('indicators.18834.2018.hospital', compact('data3','label3','data5','label5','data6','label6','data7','data8','data9','data10'));
    }

    public function reyno(){
        $year= 2018;
      $label1['meta'] = '1. Porcentaje de pacientes diabéticos compensados bajo control en el grupo de 15 años y más en el nivel primario.';
      $label1['numerador'] = 'N° de personas con DM de 15 a 79 años con Hemoglobina Glicosilada bajo el 7%, más el N° de personas con DM de 80 años y más años con Hemoglobina Glicosilada bajo el 8% según último control vigente, en los últimos 12 meses.';
      $label1['denominador'] = 'Total de pacientes diabéticos de 15 y más años bajo control en el nivel primario.';

      $data1 = array();

      $sql_establecimientos = "SELECT comuna, alias_estab
                               FROM establecimientos
                               WHERE meta_san_18834 = 1
                               AND id_establecimiento = 13
                               ORDER BY comuna";

      $establecimientos = DB::connection('mysql_rem')->select($sql_establecimientos);

      /* ==== Inicializar en 0 el arreglo de datos $data ==== */
      foreach($establecimientos as $establecimiento) {
          $data1[$establecimiento->alias_estab]['numerador'] = 0;
          $data1[$establecimiento->alias_estab]['numerador_6'] = 0;
          $data1[$establecimiento->alias_estab]['denominador'] = 0;
          $data1[$establecimiento->alias_estab]['denominador_6'] = 0;
          $data1[$establecimiento->alias_estab]['meta'] = 0;
          $data1[$establecimiento->alias_estab]['cumplimiento'] = 0;
          $data1[$establecimiento->alias_estab][$establecimiento->alias_estab]['numerador'] = 0;
          $data1[$establecimiento->alias_estab][$establecimiento->alias_estab]['numerador_6'] = 0;
          $data1[$establecimiento->alias_estab][$establecimiento->alias_estab]['denominador'] = 0;
          $data1[$establecimiento->alias_estab][$establecimiento->alias_estab]['denominador_6'] = 0;
          $data1[$establecimiento->alias_estab][$establecimiento->alias_estab]['meta'] = 0;
          $data1[$establecimiento->alias_estab][$establecimiento->alias_estab]['cumplimiento'] = 0;
      }

      $data1['CGU Dr. Hector Reyno']['meta'] = '≥45%';

      /* ===== Query numerador ===== */
      $sql_numerador =
      "SELECT e.alias_estab, r.Mes, sum(ifnull(Col01,0)) as numerador
          FROM ".$year."rems r
          LEFT JOIN establecimientos e ON r.IdEstablecimiento=e.Codigo
          WHERE
          e.meta_san_18834 = 1 AND id_establecimiento = 13 AND Ano = 2018 AND (Mes = 6 OR Mes = 12) AND
          CodigoPrestacion IN ('P4180300','P4200200')
          GROUP by e.alias_estab, r.Mes
          ORDER BY e.alias_estab, r.Mes";

      $numeradores = DB::connection('mysql_rem')->select($sql_numerador);

      foreach($numeradores as $registro) {
          /*$data1[$registro->alias_estab]['numerador'] += $registro->numerador;
          $data1[$registro->alias_estab][$registro->alias_estab]['numerador'] = $registro->numerador;*/

          if($registro->Mes == 6) {
              $data1[$registro->alias_estab]['numerador_6'] += $registro->numerador;
              $data1[$registro->alias_estab][$registro->alias_estab]['numerador_6'] = $registro->numerador;
          }
          if($registro->Mes == 12){
              $data1[$registro->alias_estab]['numerador'] += $registro->numerador;
              $data1[$registro->alias_estab][$registro->alias_estab]['numerador'] = $registro->numerador;
          }
      }

      /* ===== Query denominador ===== */
      $sql_denominador =
      "SELECT e.alias_estab, r.Mes, sum(ifnull(Col01,0)) as denominador
          FROM ".$year."rems r
          LEFT JOIN establecimientos e ON r.IdEstablecimiento=e.Codigo
          WHERE
          e.meta_san_18834 = 1 AND id_establecimiento = 13 AND Ano = 2018 AND (Mes = 6 OR Mes = 12) AND
          CodigoPrestacion IN ('P4150602')
          GROUP by e.alias_estab, r.Mes
          ORDER BY e.alias_estab, r.Mes";

      $denomidores = DB::connection('mysql_rem')->select($sql_denominador);

      foreach($denomidores as $registro) {
          /*$data1[$registro->alias_estab]['denominador'] += $registro->denominador;
          $data1[$registro->alias_estab][$registro->alias_estab]['denominador'] = $registro->denominador;*/

          if($registro->Mes == 6) {
              $data1[$registro->alias_estab]['denominador_6'] += $registro->denominador;
              $data1[$registro->alias_estab][$registro->alias_estab]['denominador_6'] = $registro->denominador;
          }
          if($registro->Mes == 12){
              $data1[$registro->alias_estab]['denominador'] += $registro->denominador;
              $data1[$registro->alias_estab][$registro->alias_estab]['denominador'] = $registro->denominador;
          }
      }

      /* ==== Calculos ==== */
      foreach($data1 as $nombre_comuna => $comuna) {
          foreach($comuna as $nombre_establecimiento => $establecimiento) {
              /* Existe en el array un indice ['numerador'], ['denominador'] y ['meta'],
               * estos almacenan la información de la comuna, por lo tanto tengo que saltarlos
               * en la iteración del foreach y continuar con los establecimientos */
              /* Realizar los calculos mensuales */
              if($nombre_establecimiento != 'numerador' AND
                  $nombre_establecimiento != 'numerador_6' AND
                  $nombre_establecimiento != 'denominador' AND
                  $nombre_establecimiento != 'denominador_6' AND
                  $nombre_establecimiento != 'meta' AND
                  $nombre_establecimiento != 'cumplimiento'){

                  /* Calculo de las metas de cada establecimiento */
                  if($data1[$nombre_comuna][$nombre_establecimiento]['denominador'] == 0) {
                      /* Si es 0 el denominadore entonces la meta es 0 */
                      $data1[$nombre_comuna][$nombre_establecimiento]['cumplimiento'] = 0;
                  }
                  else {
                      /* De lo contrario calcular el porcentaje */
                      $data1[$nombre_comuna][$nombre_establecimiento]['cumplimiento'] =
                          $data1[$nombre_comuna][$nombre_establecimiento]['numerador'] / $data1[$nombre_comuna][$nombre_establecimiento]['denominador'] * 100;
                  }

                  /* Fija la meta de la comuna también a sus establecimientos */
                  $data1[$nombre_comuna][$nombre_establecimiento]['meta'] = $data1[$nombre_comuna]['meta'];

                  /* Calculo de las metas de la comuna */
                  if($data1[$nombre_comuna]['denominador'] == 0) {
                      /* Si es 0 el denominadore entonces la meta es 0 */
                      $data1[$nombre_comuna]['cumplimiento'] = 0;
                  }
                  else {
                      /* De lo contrario calcular el porcentaje */
                      $data1[$nombre_comuna]['cumplimiento'] = $data1[$nombre_comuna]['numerador'] / $data1[$nombre_comuna]['denominador'] * 100;
                  }
              }
          }
      }

      //INDICADOR 2

      $label2['meta'] = '2. Porcentaje de pacientes hipertensos compensados bajo control en el grupo de 15 y más años en el nivel primario.';
      $label2['numerador'] = 'N° de personas hipertensas de 15 a 79 años con presión arterial <140/90 mmHg, más el N° de personas hipertensas de 80 y más años con presión arterial <150/90 mmHg, según último control vigente, en los últimos 12 meses.';
      $label2['denominador'] = 'Total de pacientes Hipertensos de 15 y más años bajo control en el nivel primario.';

      $data = array();

      $sql_establecimientos = "SELECT servicio_salud, comuna, alias_estab
                               FROM establecimientos
                               WHERE meta_san_18834 = 1
                               AND id_establecimiento = 13
                               ORDER BY comuna";

      $establecimientos = DB::connection('mysql_rem')->select($sql_establecimientos);

      /* ==== Inicializar en 0 el arreglo de datos $data ==== */
      foreach($establecimientos as $establecimiento) {
          $data2[$establecimiento->alias_estab]['numerador'] = 0;
          $data2[$establecimiento->alias_estab]['numerador_6'] = 0;
          $data2[$establecimiento->alias_estab]['denominador'] = 0;
          $data2[$establecimiento->alias_estab]['denominador_6'] = 0;
          $data2[$establecimiento->alias_estab]['meta'] = 0;
          $data2[$establecimiento->alias_estab]['cumplimiento'] = 0;
          $data2[$establecimiento->alias_estab][$establecimiento->alias_estab]['numerador'] = 0;
          $data2[$establecimiento->alias_estab][$establecimiento->alias_estab]['numerador_6'] = 0;
          $data2[$establecimiento->alias_estab][$establecimiento->alias_estab]['denominador'] = 0;
          $data2[$establecimiento->alias_estab][$establecimiento->alias_estab]['denominador_6'] = 0;
          $data2[$establecimiento->alias_estab][$establecimiento->alias_estab]['meta'] = 0;
          $data2[$establecimiento->alias_estab][$establecimiento->alias_estab]['cumplimiento'] = 0;
      }
      $data2['CGU Dr. Hector Reyno']['meta'] = '≥68%';

      /* ===== Query numerador ===== */
      $sql_numerador =
      "SELECT e.alias_estab, r.Mes, sum(ifnull(Col01,0)) as numerador
          FROM ".$year."rems r
          LEFT JOIN establecimientos e ON r.IdEstablecimiento=e.Codigo
          WHERE
          e.meta_san_18834 = 1 AND id_establecimiento = 13 AND Ano = 2018 AND (Mes = 6 OR Mes = 12) AND
          CodigoPrestacion IN ('P4180200','P4200100')
          GROUP by e.alias_estab, r.Mes
          ORDER BY e.alias_estab, r.Mes";

      $numeradores = DB::connection('mysql_rem')->select($sql_numerador);

      foreach($numeradores as $registro) {
          /*$data2[$registro->alias_estab]['numerador'] += $registro->numerador;
          $data2[$registro->alias_estab][$registro->alias_estab]['numerador'] = $registro->numerador;*/

          if($registro->Mes == 6) {
              $data2[$registro->alias_estab]['numerador_6'] += $registro->numerador;
              $data2[$registro->alias_estab][$registro->alias_estab]['numerador_6'] = $registro->numerador;
          }
          if($registro->Mes == 12){
              $data2[$registro->alias_estab]['numerador'] += $registro->numerador;
              $data2[$registro->alias_estab][$registro->alias_estab]['numerador'] = $registro->numerador;
          }
      }

      /* ===== Query denominador ===== */
      $sql_denominador =
      "SELECT e.alias_estab, r.Mes, sum(ifnull(Col01,0)) as denominador
          FROM ".$year."rems r
          LEFT JOIN establecimientos e ON r.IdEstablecimiento=e.Codigo
          WHERE
          e.meta_san_18834 = 1 AND id_establecimiento = 13 AND Ano = 2018 AND (Mes = 6 OR Mes = 12) AND
          CodigoPrestacion IN ('P4150601')
          GROUP by e.alias_estab, r.Mes
          ORDER BY e.alias_estab, r.Mes";

      $denomidores = DB::connection('mysql_rem')->select($sql_denominador);

      foreach($denomidores as $registro) {
          /*$data2[$registro->alias_estab]['denominador'] += $registro->denominador;
          $data2[$registro->alias_estab][$registro->alias_estab]['denominador'] = $registro->denominador;*/

          if($registro->Mes == 6) {
              $data2[$registro->alias_estab]['denominador_6'] += $registro->denominador;
              $data2[$registro->alias_estab][$registro->alias_estab]['denominador_6'] = $registro->denominador;
          }
          if($registro->Mes == 12){
              $data2[$registro->alias_estab]['denominador'] += $registro->denominador;
              $data2[$registro->alias_estab][$registro->alias_estab]['denominador'] = $registro->denominador;
          }
      }

      /* ==== Calculos ==== */
      foreach($data2 as $nombre_comuna => $comuna) {
          foreach($comuna as $nombre_establecimiento => $establecimiento) {
              /* Existe en el array un indice ['numerador'], ['denominador'] y ['meta'],
               * estos almacenan la información de la comuna, por lo tanto tengo que saltarlos
               * en la iteración del foreach y continuar con los establecimientos */
              /* Realizar los calculos mensuales */
              if($nombre_establecimiento != 'numerador' AND
                  $nombre_establecimiento != 'numerador_6' AND
                  $nombre_establecimiento != 'denominador' AND
                  $nombre_establecimiento != 'denominador_6' AND
                  $nombre_establecimiento != 'meta' AND
                  $nombre_establecimiento != 'cumplimiento'){

                  /* Calculo de las metas de cada establecimiento */
                  if($data2[$nombre_comuna][$nombre_establecimiento]['denominador'] == 0) {
                      /* Si es 0 el denominadore entonces la meta es 0 */
                      $data2[$nombre_comuna][$nombre_establecimiento]['cumplimiento'] = 0;
                  }
                  else {
                      /* De lo contrario calcular el porcentaje */
                      $data2[$nombre_comuna][$nombre_establecimiento]['cumplimiento'] =
                          $data2[$nombre_comuna][$nombre_establecimiento]['numerador'] / $data2[$nombre_comuna][$nombre_establecimiento]['denominador'] * 100;
                  }

                  /* Fija la meta de la comuna también a sus establecimientos */
                  $data2[$nombre_comuna][$nombre_establecimiento]['meta'] = $data2[$nombre_comuna]['meta'];

                  /* Calculo de las metas de la comuna */
                  if($data2[$nombre_comuna]['denominador'] == 0) {
                      /* Si es 0 el denominadore entonces la meta es 0 */
                      $data2[$nombre_comuna]['cumplimiento'] = 0;
                  }
                  else {
                      /* De lo contrario calcular el porcentaje */
                      $data2[$nombre_comuna]['cumplimiento'] = $data2[$nombre_comuna]['numerador'] / $data2[$nombre_comuna]['denominador'] * 100;
                  }
              }
          }
      }

      //INDICADOR 4

      $label4['meta'] = '4. Porcentaje de Evaluación Anual de los Pies en personas con Diabetes bajo control de 15 y más años, en el año t.';
      $label4['numerador'] = 'N° de personas con diabetes bajo control de 15 y más años con una evaluación de pie, vigente en el año t.';
      $label4['denominador'] = 'TN° Total de personas diabéticas de 15 y más años bajo control en el año t.';

      $data4 = array();

      $sql_establecimientos = "SELECT comuna, alias_estab
                               FROM establecimientos
                               WHERE meta_san_18834 = 1
                               AND id_establecimiento = 13
                               ORDER BY comuna";

      $establecimientos = DB::connection('mysql_rem')->select($sql_establecimientos);

      /* ==== Inicializar en 0 el arreglo de datos $data ==== */
      foreach($establecimientos as $establecimiento) {
          $data4[$establecimiento->alias_estab]['numerador'] = 0;
          $data4[$establecimiento->alias_estab]['numerador_6'] = 0;
          $data4[$establecimiento->alias_estab]['denominador'] = 0;
          $data4[$establecimiento->alias_estab]['denominador_6'] = 0;
          $data4[$establecimiento->alias_estab]['meta'] = 0;
          $data4[$establecimiento->alias_estab]['cumplimiento'] = 0;
          $data4[$establecimiento->alias_estab][$establecimiento->alias_estab]['numerador'] = 0;
          $data4[$establecimiento->alias_estab][$establecimiento->alias_estab]['numerador_6'] = 0;
          $data4[$establecimiento->alias_estab][$establecimiento->alias_estab]['denominador'] = 0;
          $data4[$establecimiento->alias_estab][$establecimiento->alias_estab]['denominador_6'] = 0;
          $data4[$establecimiento->alias_estab][$establecimiento->alias_estab]['meta'] = 0;
          $data4[$establecimiento->alias_estab][$establecimiento->alias_estab]['cumplimiento'] = 0;
      }

      $data4['CGU Dr. Hector Reyno']['meta'] = '≥90%';

      /* ===== Query numerador ===== */
      $sql_numerador =
      "SELECT e.alias_estab, r.Mes, sum(ifnull(Col01,0)) as numerador
          FROM ".$year."rems r
          LEFT JOIN establecimientos e ON r.IdEstablecimiento=e.Codigo
          WHERE
          e.meta_san_18834 = 1 AND id_establecimiento = 13 AND Ano = 2018 AND (Mes = 6 OR Mes = 12) AND
          CodigoPrestacion IN ('P4190809','P4170300','P4190500','P4190600')
          GROUP by e.alias_estab, r.Mes
          ORDER BY e.alias_estab, r.Mes";

      $numeradores = DB::connection('mysql_rem')->select($sql_numerador);

      foreach($numeradores as $registro) {
          /*$data4[$registro->alias_estab]['numerador'] += $registro->numerador;
          $data4[$registro->alias_estab][$registro->alias_estab]['numerador'] = $registro->numerador;*/

          if($registro->Mes == 6) {
              $data4[$registro->alias_estab]['numerador_6'] += $registro->numerador;
              $data4[$registro->alias_estab][$registro->alias_estab]['numerador_6'] = $registro->numerador;
          }
          if($registro->Mes == 12){
              $data4[$registro->alias_estab]['numerador'] += $registro->numerador;
              $data4[$registro->alias_estab][$registro->alias_estab]['numerador'] = $registro->numerador;
          }
      }

      /* ===== Query denominador ===== */
      $sql_denominador =
      "SELECT e.alias_estab, r.Mes, sum(ifnull(Col01,0)) as denominador
          FROM ".$year."rems r
          LEFT JOIN establecimientos e ON r.IdEstablecimiento=e.Codigo
          WHERE
          e.meta_san_18834 = 1 AND id_establecimiento = 13 AND Ano = 2018 AND (Mes = 6 OR Mes = 12) AND
          CodigoPrestacion IN ('P4150602')
          GROUP by e.alias_estab, r.Mes
          ORDER BY e.alias_estab, r.Mes";

      $denomidores = DB::connection('mysql_rem')->select($sql_denominador);

      foreach($denomidores as $registro) {
          /*$data4[$registro->alias_estab]['denominador'] += $registro->denominador;
          $data4[$registro->alias_estab][$registro->alias_estab]['denominador'] = $registro->denominador;*/

          if($registro->Mes == 6) {
              $data4[$registro->alias_estab]['denominador_6'] += $registro->denominador;
              $data4[$registro->alias_estab][$registro->alias_estab]['denominador_6'] = $registro->denominador;
          }
          if($registro->Mes == 12){
              $data4[$registro->alias_estab]['denominador'] += $registro->denominador;
              $data4[$registro->alias_estab][$registro->alias_estab]['denominador'] = $registro->denominador;
          }
      }

      /* ==== Calculos ==== */
      foreach($data4 as $nombre_comuna => $comuna) {
          foreach($comuna as $nombre_establecimiento => $establecimiento) {
              /* Existe en el array un indice ['numerador'], ['denominador'] y ['meta'],
               * estos almacenan la información de la comuna, por lo tanto tengo que saltarlos
               * en la iteración del foreach y continuar con los establecimientos */
              /* Realizar los calculos mensuales */
              if($nombre_establecimiento != 'numerador' AND
                  $nombre_establecimiento != 'numerador_6' AND
                  $nombre_establecimiento != 'denominador' AND
                  $nombre_establecimiento != 'denominador_6' AND
                  $nombre_establecimiento != 'meta' AND
                  $nombre_establecimiento != 'cumplimiento'){

                  /* Calculo de las metas de cada establecimiento */
                  if($data4[$nombre_comuna][$nombre_establecimiento]['denominador'] == 0) {
                      /* Si es 0 el denominadore entonces la meta es 0 */
                      $data4[$nombre_comuna][$nombre_establecimiento]['cumplimiento'] = 0;
                  }
                  else {
                      /* De lo contrario calcular el porcentaje */
                      $data4[$nombre_comuna][$nombre_establecimiento]['cumplimiento'] =
                          $data4[$nombre_comuna][$nombre_establecimiento]['numerador'] / $data4[$nombre_comuna][$nombre_establecimiento]['denominador'] * 100;
                  }

                  /* Fija la meta de la comuna también a sus establecimientos */
                  $data4[$nombre_comuna][$nombre_establecimiento]['meta'] = $data4[$nombre_comuna]['meta'];

                  /* Calculo de las metas de la comuna */
                  if($data4[$nombre_comuna]['denominador'] == 0) {
                      /* Si es 0 el denominadore entonces la meta es 0 */
                      $data4[$nombre_comuna]['cumplimiento'] = 0;
                  }
                  else {
                      /* De lo contrario calcular el porcentaje */
                      $data4[$nombre_comuna]['cumplimiento'] = $data4[$nombre_comuna]['numerador'] / $data4[$nombre_comuna]['denominador'] * 100;
                  }
              }
          }
      }


      /********** META 8 **********/

      $data8['label'] = '8. Porcentaje de casos con Garantías Explicitas de salud, en lo que se cumplen las garantías del año t.';
      $data8['label_numerador']   = 'N° de casos GES con garantías cumplidas del año t.';
      $data8['label_denominador'] = 'N° Total de caos GES del año t.';
      $data8['meta'] = '100%';

      $base_where = array(['law','18834'],['year',2018],['indicator',8],['establishment_id',12],['position','numerador']);

      $data8['numeradores'][1] = SingleParameter::where(array_merge($base_where,array(['month',1])))->first()->value;
      $data8['numeradores'][2] = SingleParameter::where(array_merge($base_where,array(['month',2])))->first()->value;
      $data8['numeradores'][3] = SingleParameter::where(array_merge($base_where,array(['month',3])))->first()->value;
      $data8['numeradores'][4] = SingleParameter::where(array_merge($base_where,array(['month',4])))->first()->value;
      $data8['numeradores'][5] = SingleParameter::where(array_merge($base_where,array(['month',5])))->first()->value;
      $data8['numeradores'][6] = SingleParameter::where(array_merge($base_where,array(['month',6])))->first()->value;
      $data8['numeradores'][7] = SingleParameter::where(array_merge($base_where,array(['month',7])))->first()->value;
      $data8['numeradores'][8] = SingleParameter::where(array_merge($base_where,array(['month',8])))->first()->value;
      $data8['numeradores'][9] = SingleParameter::where(array_merge($base_where,array(['month',9])))->first()->value;
      $data8['numeradores'][10] = SingleParameter::where(array_merge($base_where,array(['month',10])))->first()->value;
      $data8['numeradores'][11] = SingleParameter::where(array_merge($base_where,array(['month',11])))->first()->value;
      $data8['numeradores'][12] = SingleParameter::where(array_merge($base_where,array(['month',12])))->first()->value;
      $data8['numerador_acumulado'] = array_sum($data8['numeradores']);

      $base_where = array(['law','18834'],['year',2018],['indicator',8],['establishment_id',12],['position','denominador']);
      $data8['denominadores'][1] = SingleParameter::where(array_merge($base_where,array(['month',1])))->first()->value;
      $data8['denominadores'][2] = SingleParameter::where(array_merge($base_where,array(['month',2])))->first()->value;
      $data8['denominadores'][3] = SingleParameter::where(array_merge($base_where,array(['month',3])))->first()->value;
      $data8['denominadores'][4] = SingleParameter::where(array_merge($base_where,array(['month',4])))->first()->value;
      $data8['denominadores'][5] = SingleParameter::where(array_merge($base_where,array(['month',5])))->first()->value;
      $data8['denominadores'][6] = SingleParameter::where(array_merge($base_where,array(['month',6])))->first()->value;
      $data8['denominadores'][7] = SingleParameter::where(array_merge($base_where,array(['month',7])))->first()->value;
      $data8['denominadores'][8] = SingleParameter::where(array_merge($base_where,array(['month',8])))->first()->value;
      $data8['denominadores'][9] = SingleParameter::where(array_merge($base_where,array(['month',9])))->first()->value;
      $data8['denominadores'][10] = SingleParameter::where(array_merge($base_where,array(['month',10])))->first()->value;
      $data8['denominadores'][11] = SingleParameter::where(array_merge($base_where,array(['month',11])))->first()->value;
      $data8['denominadores'][12] = SingleParameter::where(array_merge($base_where,array(['month',12])))->first()->value;
      $data8['denominador_acumulado'] = array_sum($data8['denominadores']);

      //$cumplimiento = ;
      $data8['cumplimiento'] = number_format(
          $data8['numerador_acumulado'] / $data8['denominador_acumulado'] * 100,2, ',', '.');


      /********** META 10 **********/

      $data10['label'] = '10. Porcentajes de funcionarios regidos por el
          Estatuto Administrativo, capacitados durante el año 2018 en
          al menos una actividad de capacitación pertinente,
          de los nueve Ejes Estratégicos de Estrategia Nacional de Salud.';
      $data10['label_numerador']   = 'N° de funcionarios regidos por el EA capacitados durante el año 2018 en al menos una actividad de capacitación pertinene de los nueve Ejes de la Estrategia Nacional de Salud';
      $data10['label_denominador'] = 'N° total de funcionarios de dotación, regidos por el EA';
      $data10['meta'] = '50%';

      $base_where = array(['law','18834'],['year',2018],['indicator',10],['establishment_id',12],['position','numerador']);
      $data10['numerador_acumulado'] = SingleParameter::where($base_where)->first()->value;

      $base_where = array(['law','18834'],['year',2018],['indicator',10],['establishment_id',12],['position','denominador']);
      $data10['denominador_acumulado'] = SingleParameter::where($base_where)->first()->value;

      $data10['cumplimiento'] = number_format(
          $data10['numerador_acumulado'] / $data10['denominador_acumulado'] * 100,2, ',', '.');

      $data10['vigencia'] = 12;
      //echo '<pre>'; print_r($data); die();
      //echo '<pre>'; print_r($data);
      return view('indicators.18834.2018.reyno', compact('data1','label1','data2','label2','data4','label4','data8','data10'));
    }
}
