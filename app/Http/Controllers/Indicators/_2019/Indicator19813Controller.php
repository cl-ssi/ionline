<?php

namespace App\Http\Controllers\Indicators\_2019;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class Indicator19813Controller extends Controller
{
    public function index()
    {
        //include "../graphics.php";
        include('19813/graphics2018.php');
        include('19813/graphics.php');
        return view('indicators.19813.2019.index')->withData12019($data12019)->withData12018($data12018)
                                                  ->withData22019($data22019)->withData22018($data22018)
                                                  ->withData3a2019($data3a2019)->withData3a2018($data3a2018)
                                                  ->withData3b2019($data3b2019)->withData3b2018($data3b2018)
                                                  ->withData3c2019($data3c2019)->withData3c2018($data3c2018)
                                                  ->withData4a2019($data4a2019)->withData4a2018($data4a2018)
                                                  ->withData4b2019($data4b2019)->withData4b2018($data4b2018)
                                                  ->withData52019($data52019)->withData52018($data52018)
                                                  ->withData62019($data62019)->withData62018($data62018)->withMescarga($mescarga)->withLabel($label);
    }

    public function show(Request $request, $year, $law, $id)
    {
        $metas = $request->input('meta');
        $comunas = $request->input('comuna');
        return view('indicators/$year/$law/$id')->withYear($year)->withLaw($law)->withId($id)->withMetas($metas)->withComunas($comunas);
    }

    /* Metas de ley 19813 */
    public function indicador1(){
        $year = 2019;

        $sql_ultimo_rem = "SELECT MAX(Mes) as ultimo_rem FROM 2019rems;";
        $ultimo_rem = DB::connection('mysql_rem')->select($sql_ultimo_rem)[0]->ultimo_rem;

        /* 02010420	RESULTADOS DE LA APLICACIÓN DE ESCALA DE EVALUACIÓN DEL DESARROLLO PSICOMOTOR - REEVALUACIÓN - NORMAL (de riesgo)
           03500366	RESULTADOS DE LA APLICACIÓN DE ESCALA DE EVALUACIÓN DEL DESARROLLO PSICOMOTOR - REEVALUACIÓN - NORMAL CON REZAGO (de riesgo) */

        $label['meta'] = 'Porcentaje de niños y niñas de 12 a 23 meses con riesgo del desarrollo psicomotor recuperados.';
        $label['numerador'] = 'N° de niños y niñas de 12 a 23 meses dignosticados con riesgo del DSM recuperados, período enero a diciembre 2019.';
        $label['denominador'] = 'N° de niños y niñas de 12 a 23 meses diagnosticados con riesgo de Desarrollo Psicomotor en su primera evaluación, período enero a diciembre 2019.';

        $meses = array(1,2,3,4,5,6,7,8,9,10,11,12);
        $flag1 = NULL;
        $flag2 = NULL;
        $data = array();

        $sql_establecimientos ='SELECT comuna, alias_estab
                                FROM 2019establecimientos
                                WHERE meta_san = 1
                                ORDER BY comuna;';

        $establecimientos = DB::connection('mysql_rem')->select($sql_establecimientos);

        /* ==== Inicializar en 0 el arreglo de datos $data ==== */
        foreach($establecimientos as $establecimiento) {
            $data[$establecimiento->comuna]['numeradores']['total'] = 0;
            $data[$establecimiento->comuna]['denominadores']['total'] = 0;
            //$data[$establecimiento->comuna]['denominadores_2']['total'] = 0;
            $data[$establecimiento->comuna]['cumplimiento'] = 0;
            for($mes=1; $mes <= $ultimo_rem; $mes++) {
                $data[$establecimiento->comuna]['numeradores'][$mes] = 0;
                $data[$establecimiento->comuna]['denominadores'][$mes] = 0;
                //$data[$establecimiento->comuna]['denominadores_2'][$mes] = 0;
                $data[$establecimiento->comuna][$establecimiento->alias_estab]['numeradores']['total'] = 0;
                $data[$establecimiento->comuna][$establecimiento->alias_estab]['denominadores']['total'] = 0;
                $data[$establecimiento->comuna][$establecimiento->alias_estab]['denominadores_2']['total'] = 0;
                $data[$establecimiento->comuna][$establecimiento->alias_estab]['numeradores'][$mes] = 0;
                $data[$establecimiento->comuna][$establecimiento->alias_estab]['denominadores'][$mes] = 0;
                $data[$establecimiento->comuna][$establecimiento->alias_estab]['denominadores_2'][$mes] = 0;
            }
            $data[$establecimiento->comuna][$establecimiento->alias_estab]['cumplimiento'] = 0;
        }

        $data['ALTO HOSPICIO']['meta'] = '90%';
        $data['CAMIÑA']['meta'] = '100%';
        $data['COLCHANE']['meta'] = '100%';
        $data['HUARA']['meta'] = '90%';
        $data['IQUIQUE']['meta'] = '94%';
        $data['PICA']['meta'] = '90%';
        $data['POZO ALMONTE']['meta'] = '90%';

        /* ===== Query numerador ===== */
        $sql_numerador = "SELECT e.Comuna, e.alias_estab, r.Mes, sum((ifnull(Col08,0) + ifnull(Col09,0) + ifnull(Col10,0) + ifnull(Col11,0))) as numerador
            FROM {$year}rems r
            LEFT JOIN 2019establecimientos e
            ON r.IdEstablecimiento=e.Codigo
            WHERE CodigoPrestacion in (02010420,03500366) AND e.meta_san = 1
            GROUP BY e.Comuna, e.alias_estab, r.Mes
            ORDER BY e.Comuna, e.alias_estab, r.Mes";
        $numeradores = DB::connection('mysql_rem')->select($sql_numerador);

        foreach($numeradores as $registro) {
            if( ($flag1 != $registro->Comuna) OR ($flag2 != $registro->alias_estab) ) {
                for($mes=1; $mes <= $ultimo_rem; $mes++) {
                    $data[$registro->Comuna][$registro->alias_estab]['numeradores'][$mes] = 0;
                }
                $flag1 = $registro->Comuna;
                $flag2 = $registro->alias_estab;
            }
            $data[$registro->Comuna][$registro->alias_estab]['numeradores'][$registro->Mes] = $registro->numerador;
        }
        //dd($data['IQUIQUE']);

        /* ===== Query denominador ===== */
        /*02010321	RESULTADOS DE LA APLICACIÓN DE ESCALA DE EVALUACIÓN DEL DESARROLLO PSICOMOTOR - PRIMERA EVALUACIÓN - RIESGO
          03500334	RESULTADOS DE LA APLICACIÓN DE ESCALA DE EVALUACIÓN DEL DESARROLLO PSICOMOTOR - TRASLADO DE ESTABLECIMIENTO - RIESGO*/

        $sql_denominador = "SELECT e.Comuna, e.alias_estab, r.Mes,
                            (
                            	SUM( CASE WHEN CodigoPrestacion IN (02010321) THEN
                            		COALESCE(Col08,0) + COALESCE(Col09,0) + COALESCE(Col10,0) + COALESCE(Col11,0)
                            		ELSE 0 END)
                            	-
                            	SUM( CASE WHEN CodigoPrestacion IN (03500334) THEN
                            		COALESCE(Col08,0) + COALESCE(Col09,0) + COALESCE(Col10,0) + COALESCE(Col11,0)
                            		ELSE 0 END)
                            ) AS denominador
                            FROM {$year}rems r
                            LEFT JOIN 2019establecimientos e
                            ON r.IdEstablecimiento=e.Codigo
                            WHERE e.meta_san = 1
                            GROUP BY e.Comuna, e.alias_estab, r.Mes
                            ORDER BY e.Comuna, e.alias_estab, r.Mes";

        $denominadores = DB::connection('mysql_rem')->select($sql_denominador);

        foreach($denominadores as $registro) {
            if( ($flag1 != $registro->Comuna) OR ($flag2 != $registro->alias_estab) ) {
                for($mes=1; $mes <= $ultimo_rem; $mes++) {
                    $data[$registro->Comuna][$registro->alias_estab]['denominadores'][$mes] = 0;
                }
                $flag1 = $registro->Comuna;
                $flag2 = $registro->alias_estab;
            }
            $data[$registro->Comuna][$registro->alias_estab]['denominadores'][$registro->Mes] = $registro->denominador;
        }

        /* ===== Query denominador ===== */
        // $sql_denominador_2 = 'SELECT e.Comuna, e.alias_estab, r.Mes, sum((ifnull(Col08,0) + ifnull(Col09,0) + ifnull(Col10,0) + ifnull(Col11,0))) as denominador_2
        //     FROM '.$year.'rems r
        //     LEFT JOIN 2019establecimientos e
        //     ON r.IdEstablecimiento=e.Codigo
        //     WHERE CodigoPrestacion in (03500334) AND e.meta_san = 1
        //     GROUP BY e.Comuna, e.alias_estab, r.Mes
        //     ORDER BY e.Comuna, e.alias_estab, r.Mes';
        // $denominadores_2 = DB::connection('mysql_rem')->select($sql_denominador_2);
        //
        // foreach($denominadores_2 as $registro) {
        //     if( ($flag1 != $registro->Comuna) OR ($flag2 != $registro->alias_estab) ) {
        //         foreach($meses as $mes) {
        //             $data[$registro->Comuna][$registro->alias_estab]['denominadores_2'][$mes] = 0;
        //         }
        //         $flag1 = $registro->Comuna;
        //         $flag2 = $registro->alias_estab;
        //     }
        //     $data[$registro->Comuna][$registro->alias_estab]['denominadores_2'][$registro->Mes] = $registro->denominador_2;
        // }

        /* ==== Calculos ==== */

        foreach($data as $nombre_comuna => $comuna) {
            foreach($comuna as $nombre_establecimiento => $establecimiento) {
                /* Existe en el array un indice ['numerador'], ['denominador'] y ['meta'],
                 * estos almacenan la información de la comuna, por lo tanto tengo que saltarlos
                 * en la iteración del foreach y continuar con los establecimientos */
                /* Realizar los calculos mensuales */
                if($nombre_establecimiento != 'numeradores' AND
                    $nombre_establecimiento != 'denominadores' AND
                    //$nombre_establecimiento != 'denominadores_2' AND
                    $nombre_establecimiento != 'meta' AND
                    $nombre_establecimiento != 'cumplimiento'){

                    /* Calcula los totales de cada establecimiento */
                    $data[$nombre_comuna][$nombre_establecimiento]['denominadores']['total'] = array_sum($establecimiento['denominadores']);
                    //$data[$nombre_comuna][$nombre_establecimiento]['denominadores_2']['total'] = array_sum($establecimiento['denominadores_2']);
                    $data[$nombre_comuna][$nombre_establecimiento]['numeradores']['total'] = array_sum($establecimiento['numeradores']);

                    //dd($data[$nombre_comuna][$nombre_establecimiento]['denominadores']['total']);

                    /* Calcula los totales de cada comuna */
                    $data[$nombre_comuna]['numeradores']['total'] += $data[$nombre_comuna][$nombre_establecimiento]['numeradores']['total'];
                    $data[$nombre_comuna]['denominadores']['total'] += $data[$nombre_comuna][$nombre_establecimiento]['denominadores']['total'];
                    //-$data[$nombre_comuna][$nombre_establecimiento]['denominadores_2']['total'];

                    /* Calcula la suma mensual por comuna */
                    for($mes=1; $mes <= $ultimo_rem; $mes++) {
                        $data[$nombre_comuna]['numeradores'][$mes] += $establecimiento['numeradores'][$mes];
                        $data[$nombre_comuna]['denominadores'][$mes] += $establecimiento['denominadores'][$mes];// - $establecimiento['denominadores_2'][$mes];
                    }

                    /* Calculo de las metas de cada establecimiento */
                    if($data[$nombre_comuna][$nombre_establecimiento]['denominadores']['total'] == 0) {
                        /* Si es 0 el denominadore entonces el cumplimiento es 0 */
                        $data[$nombre_comuna][$nombre_establecimiento]['cumplimiento'] = 0;
                    }
                    else {
                        /* De lo contrario calcular el porcentaje */
                        $data[$nombre_comuna][$nombre_establecimiento]['cumplimiento'] =
                            $data[$nombre_comuna][$nombre_establecimiento]['numeradores']['total'] /
                            $data[$nombre_comuna][$nombre_establecimiento]['denominadores']['total'] * 100;
                    }

                    /* Calculo de las metas de la comuna */
                    $dataGraphics[$nombre_comuna]['cumplimiento'][$mes] = 0;
                    if($data[$nombre_comuna]['denominadores']['total'] == 0) {
                        /* Si es 0 el denominadore entonces el cumplimiento es 0 */
                        $data[$nombre_comuna]['cumplimiento'] = 0;
                    }
                    else {
                        /* De lo contrario calcular el porcentaje */
                        $data[$nombre_comuna]['cumplimiento'] = $data[$nombre_comuna]['numeradores']['total'] / $data[$nombre_comuna]['denominadores']['total'] * 100;
                        //$dataGraphics[$nombre_comuna]['cumplimiento'][$mes] = $dataGraphics[$nombre_comuna]['numeradores'][$mes] / $data[$nombre_comuna]['denominadores'][$mes] * 100;
                    }
                }
            }
        }
        //dd($data);
        //echo '<pre>'; print_r($data);
        include('19813/graphics.php');
        return view('indicators.19813.2019.indicador1')->withData($data)->withLabel($label)->withData12019($data12019)->withData12018($data12018)->withMescarga($mescarga);
    }

    public function indicador2(){
        $year = 2019;

        $sql_ultimo_rem = "SELECT MAX(Mes) as ultimo_rem FROM 2019rems;";
        $ultimo_rem = DB::connection('mysql_rem')->select($sql_ultimo_rem)[0]->ultimo_rem;

        $label['meta'] = 'Papanicolau (PAP) vigente en mujeres de 25 a 64 años.';
        $label['numerador'] = 'N° logrado de mujeres de 25 a 64 años inscritas validadas, con PAP vigente a diciembre 2019*100';
        $label['denominador'] = 'N° total de mujeres de 25 a 64 años inscritas validadas.';

        $data = array();

        $sql_establecimientos = "SELECT Codigo AS codigo, alias_estab AS nombre, comuna
                                 FROM 2019establecimientos
                                 WHERE meta_san = 1
                                 ORDER BY comuna;";

        $establecimientos = DB::connection('mysql_rem')->select($sql_establecimientos);


        $data['ALTO HOSPICIO']['meta'] = '46%';
        $data['CAMIÑA']['meta'] = '59%';
        $data['COLCHANE']['meta'] = '100%';
        $data['HUARA']['meta'] = '57%';
        $data['IQUIQUE']['meta'] = '55%';
        $data['PICA']['meta'] = '55%';
        $data['POZO ALMONTE']['meta'] = '59%';

        /* ==== Inicializar en 0 el arreglo de datos $data ==== */
        foreach($establecimientos as $establecimiento) {
            $data[$establecimiento->comuna]['numerador'] = 0;
            $data[$establecimiento->comuna]['establecimientos'][$establecimiento->nombre]['numerador'] = 0;

            $data[$establecimiento->comuna]['numerador_6'] = 0;
            $data[$establecimiento->comuna]['establecimientos'][$establecimiento->nombre]['numerador_6'] = 0;

            $data[$establecimiento->comuna]['numerador_12'] = 0;
            $data[$establecimiento->comuna]['establecimientos'][$establecimiento->nombre]['numerador_12'] = 0;

            $data[$establecimiento->comuna]['denominador'] = 0;
            $data[$establecimiento->comuna]['establecimientos'][$establecimiento->nombre]['denominador'] = 0;

            $data[$establecimiento->comuna]['cumplimiento'] = 0;
            $data[$establecimiento->comuna]['establecimientos'][$establecimiento->nombre]['cumplimiento'] = 0;

            $data[$establecimiento->comuna]['establecimientos'][$establecimiento->nombre]['meta'] = $data[$establecimiento->comuna]['meta'];
        }

        /* Sólo si está cargado sobre el rem de Junio */
        if($ultimo_rem >= 6) {

            /* ===== Query numerador ===== */
            $sql_numerador =
                "SELECT e.Comuna AS comuna, e.alias_estab AS nombre, r.Mes AS mes, sum(ifnull(Col01,0)) as numerador
                FROM {$year}rems r
                LEFT JOIN 2019establecimientos e ON r.IdEstablecimiento=e.Codigo
                WHERE
                e.meta_san = 1 AND Ano = 2019 AND (Mes = 6 OR Mes = 12) AND
                CodigoPrestacion IN ('P1206010','P1206020','P1206030','P1206040','P1206050','P1206060','P1206070','P1206080')
                GROUP by e.Comuna, e.alias_estab, r.Mes
                ORDER BY e.Comuna, e.alias_estab, r.Mes";

            $numeradores = DB::connection('mysql_rem')->select($sql_numerador);

            foreach($numeradores as $registro) {
                if($registro->mes == 6) {
                    $data[$registro->comuna]['numerador_6'] += $registro->numerador;
                    $data[$registro->comuna]['establecimientos'][$registro->nombre]['numerador_6'] = $registro->numerador;
                }
                if($registro->mes == 12){
                    $data[$registro->comuna]['numerador_12'] += $registro->numerador;
                    $data[$registro->comuna]['establecimientos'][$registro->nombre]['numerador_12'] = $registro->numerador;
                }

                if($ultimo_rem < 12) {
                    $data[$registro->comuna]['numerador'] = $data[$registro->comuna]['numerador_6'];
                    $data[$registro->comuna]['establecimientos'][$registro->nombre]['numerador'] =
                        $data[$registro->comuna]['establecimientos'][$registro->nombre]['numerador_6'];
                }
                else {
                    $data[$registro->comuna]['numerador'] = $data[$registro->comuna]['numerador_12'];
                    $data[$registro->comuna]['establecimientos'][$registro->nombre]['numerador'] =
                        $data[$registro->comuna]['establecimientos'][$registro->nombre]['numerador_12'];
                }
            }




            /* ===== Query denominador ===== */
            $sql_denominador = "SELECT e.alias_estab as nombre, e.Comuna as comuna, COUNT(*) AS denominador
                                FROM percapita_pro p
                                LEFT JOIN 2019establecimientos e ON e.Codigo = p.COD_CENTRO
                                WHERE
                                FECHA_CORTE = '2018-08-31' AND
                                GENERO = 'F' AND
                                EDAD BETWEEN 25 AND 64 AND
                                ACEPTADO_RECHAZADO = 'ACEPTADO'
                                AND e.meta_san = 1
                                GROUP BY e.Comuna, e.alias_estab
                                ORDER BY e.Comuna, e.alias_estab";

            $denominadores = DB::connection('mysql_rem')->select($sql_denominador);

            foreach($denominadores as $registro) {
                $data[$registro->comuna]['denominador'] += $registro->denominador;
                $data[$registro->comuna]['establecimientos'][$registro->nombre]['denominador'] = $registro->denominador;
            }

            /* Poblaciones manuales (denominadores) */
            $data['CAMIÑA']['denominador'] = 327;
            $data['CAMIÑA']['establecimientos']['CGR Camiña']['denominador'] = 0;
            $data['CAMIÑA']['establecimientos']['Posta Rural Moquella']['denominador'] = 0;

            $data['COLCHANE']['denominador'] = 218;
            $data['COLCHANE']['establecimientos']['CGR Colchane']['denominador'] = 0;
            $data['COLCHANE']['establecimientos']['Posta Rural Enquelga']['denominador'] = 0;
            $data['COLCHANE']['establecimientos']['Posta Rural Cariquima']['denominador'] = 0;

            $data['HUARA']['denominador'] = 594;
            $data['HUARA']['establecimientos']['CGR Dr. Amador Neghme Rodríguez']['denominador'] = 0;
            $data['HUARA']['establecimientos']['Posta Rural Pisagua']['denominador'] = 0;
            $data['HUARA']['establecimientos']['Posta Rural Tarapacá']['denominador'] = 0;
            $data['HUARA']['establecimientos']['Posta Rural Chiapa']['denominador'] = 0;
            $data['HUARA']['establecimientos']['Posta Rural Sibaya']['denominador'] = 0;


            /* ==== Calculos ==== */
            foreach($data as $nombre_comuna => $comuna) {
                /* Calculo de las metas de la comuna */
                if($data[$nombre_comuna]['denominador'] == 0) {
                    /* Si es 0 el denominadore entonces la meta es 0 */
                    $data[$nombre_comuna]['cumplimiento'] = 0;
                }
                else {
                    $data[$nombre_comuna]['cumplimiento'] = number_format(
                        $data[$nombre_comuna]['numerador'] /
                        $data[$nombre_comuna]['denominador'] * 100
                        , 2, ',', '.');
                }
                /* Formateo de tipo de número después de hacer calculos*/
                $data[$nombre_comuna]['numerador'] = number_format($data[$nombre_comuna]['numerador'], 0, ',', '.');
                $data[$nombre_comuna]['numerador_6'] = number_format($data[$nombre_comuna]['numerador_6'], 0, ',', '.');
                $data[$nombre_comuna]['numerador_12'] = number_format($data[$nombre_comuna]['numerador_12'], 0, ',', '.');
                $data[$nombre_comuna]['denominador'] = number_format($data[$nombre_comuna]['denominador'], 0, ',', '.');

                foreach($comuna['establecimientos'] as $nombre_establecimiento => $establecimiento) {
                    /* Calculo de cumplimiento de cada establecimiento */
                    if($establecimiento['denominador'] == 0) {
                        /* Si es 0 el denominador entonces la meta es 0 */
                        $data[$nombre_comuna]['establecimientos'][$nombre_establecimiento]['cumplimiento'] = 0;
                    }
                    else {
                        $data[$nombre_comuna]['establecimientos'][$nombre_establecimiento]['cumplimiento'] = number_format(
                            $data[$nombre_comuna]['establecimientos'][$nombre_establecimiento]['numerador'] /
                            $data[$nombre_comuna]['establecimientos'][$nombre_establecimiento]['denominador'] * 100
                            , 2, ',', '.');
                    }

                    /* Formateo de tipo de número después de hacer calculos*/
                    $data[$nombre_comuna]['establecimientos'][$nombre_establecimiento]['numerador'] =
                       number_format($data[$nombre_comuna]['establecimientos'][$nombre_establecimiento]['numerador'], 0, ',', '.');
                    $data[$nombre_comuna]['establecimientos'][$nombre_establecimiento]['numerador_6'] =
                        number_format($data[$nombre_comuna]['establecimientos'][$nombre_establecimiento]['numerador_6'], 0, ',', '.');
                    $data[$nombre_comuna]['establecimientos'][$nombre_establecimiento]['numerador_12'] =
                        number_format($data[$nombre_comuna]['establecimientos'][$nombre_establecimiento]['numerador_12'], 0, ',', '.');
                    $data[$nombre_comuna]['establecimientos'][$nombre_establecimiento]['denominador'] =
                        number_format($data[$nombre_comuna]['establecimientos'][$nombre_establecimiento]['denominador'], 0, ',', '.');

                }
            }
        }
        //echo '<pre>'; print_r($data); die();
        //echo '<pre>'; print_r($data);
        include('19813/graphics.php');
        return view('indicators.19813.2019.indicador2')->withData($data)->withLabel($label)->withData22019($data22019)->withData22018($data22018)->withMescarga($mescarga);
    }

    public function indicador3a(){
        $year = 2019;

        $sql_ultimo_rem = "SELECT MAX(Mes) as ultimo_rem FROM 2019rems;";
        $ultimo_rem = DB::connection('mysql_rem')->select($sql_ultimo_rem)[0]->ultimo_rem;

        /* Numerador = 09215313 09215413   Denominador = 01080008*/
        $label['meta'] = 'Porcentaje de altas odontológicas totales en adolescentes de 12 años.';
        $label['numerador'] = 'Nº de Adolescentes de 12 años con alta odontológica total de enero a diciembre 2019.';
        $label['denominador'] = 'Total de Adolescentes de 12 años inscritos validados por FONASA para el año 2019.';

        $meses = array(1,2,3,4,5,6,7,8,9,10,11,12);
        $flag1 = NULL;
        $flag2 = NULL;
        $data = array();

        $sql_establecimientos = "SELECT comuna, alias_estab
                                 FROM 2019establecimientos
                                 WHERE meta_san = 1
                                 ORDER BY comuna";

        $establecimientos = DB::connection('mysql_rem')->select($sql_establecimientos);

        /* ==== Inicializar en 0 el arreglo de datos $data ==== */
        foreach($establecimientos as $establecimiento) {
            $data[$establecimiento->comuna]['numeradores']['total'] = 0;
            $data[$establecimiento->comuna]['denominador'] = 0;
            $data[$establecimiento->comuna]['cumplimiento'] = 0;
            for($mes=1; $mes <= $ultimo_rem; $mes++) {
                $data[$establecimiento->comuna]['numeradores'][$mes] = 0;
                $data[$establecimiento->comuna][$establecimiento->alias_estab]['numeradores']['total'] = 0;
                $data[$establecimiento->comuna][$establecimiento->alias_estab]['numeradores'][$mes] = 0;
            }
            $data[$establecimiento->comuna][$establecimiento->alias_estab]['denominador'] = 0;
            $data[$establecimiento->comuna][$establecimiento->alias_estab]['cumplimiento'] = 0;
        }

        $data['ALTO HOSPICIO']['meta'] = '89%';
        $data['CAMIÑA']['meta'] = '95%';
        $data['COLCHANE']['meta'] = '93%';
        $data['HUARA']['meta'] = '80%';
        $data['IQUIQUE']['meta'] = '81%';
        $data['PICA']['meta'] = '82%';
        $data['POZO ALMONTE']['meta'] = '75%';


        /* ===== Query numerador ===== */
        $sql_numerador = 'SELECT e.Comuna, e.alias_estab, r.Mes, sum((COALESCE(Col18,0) + COALESCE(Col19,0))) as numerador
            FROM '.$year.'rems r
            LEFT JOIN 2019establecimientos e
            ON r.IdEstablecimiento=e.Codigo
            WHERE CodigoPrestacion IN (09215313,09215413) AND e.meta_san = 1
            GROUP by e.Comuna, e.alias_estab, r.Mes
            ORDER BY e.Comuna, e.alias_estab, r.Mes';
        $numeradores = DB::connection('mysql_rem')->select($sql_numerador);

        foreach($numeradores as $registro) {
            if( ($flag1 != $registro->Comuna) OR ($flag2 != $registro->alias_estab) ) {
                for($mes=1; $mes <= $ultimo_rem; $mes++) {
                    $data[$registro->Comuna][$registro->alias_estab]['numeradores'][$mes] = 0;
                }
                $flag1 = $registro->Comuna;
                $flag2 = $registro->alias_estab;
            }
            $data[$registro->Comuna][$registro->alias_estab]['numeradores'][$registro->Mes] = $registro->numerador;
        }

        /* ===== Query denominador ===== */
        $sql_denominador = "SELECT e.alias_estab, e.Comuna, COUNT(*) AS denominador
                            FROM percapita_pro p
                            LEFT JOIN 2019establecimientos e ON e.Codigo = p.COD_CENTRO
                            WHERE
                            FECHA_CORTE = '2018-08-31' AND
                            EDAD = 12 AND
                            ACEPTADO_RECHAZADO = 'ACEPTADO' AND e.meta_san = 1
                            GROUP BY e.Comuna, e.alias_estab
                            ORDER BY e.Comuna, e.alias_estab";
        $denominadores = DB::connection('mysql_rem')->select($sql_denominador);



        foreach($denominadores as $registro) {
            $data[$registro->Comuna][$registro->alias_estab]['denominador'] = $registro->denominador;
            $data[$registro->Comuna]['denominador'] += $registro->denominador;
        }

        /* NO se porqué está este valor a mano, no se necesita */
        // $data['ALTO HOSPICIO']['denominador'] = 1491;
        // $data['ALTO HOSPICIO']['CESFAM Pedro Pulgar']['denominador'] = 1491;
        // $data['ALTO HOSPICIO']['CECOSF El Boro']['denominador'] = 0;
        // $data['ALTO HOSPICIO']['CECOSF La Tortuga']['denominador'] = 0;

        $data['CAMIÑA']['denominador'] = 21;
        $data['CAMIÑA']['CGR Camiña']['denominador'] = 0;
        $data['CAMIÑA']['Posta Rural Moquella']['denominador'] = 0;

        $data['COLCHANE']['denominador'] = 19;
        $data['COLCHANE']['CGR Colchane']['denominador'] = 0;
        $data['COLCHANE']['Posta Rural Enquelga']['denominador'] = 0;
        $data['COLCHANE']['Posta Rural Cariquima']['denominador'] = 0;

        $data['HUARA']['denominador'] = 31;
        $data['HUARA']['CGR Dr. Amador Neghme Rodríguez']['denominador'] = 0;
        $data['HUARA']['Posta Rural Pisagua']['denominador'] = 0;
        $data['HUARA']['Posta Rural Tarapacá']['denominador'] = 0;
        $data['HUARA']['Posta Rural Chiapa']['denominador'] = 0;
        $data['HUARA']['Posta Rural Sibaya']['denominador'] = 0;

        // $data['IQUIQUE']['denominador'] = 2243;
        // $data['IQUIQUE']['CESFAM Cirujano Aguirre']['denominador'] = 709;
        // $data['IQUIQUE']['CESFAM Cirujano Videla']['denominador'] = 596;
        // $data['IQUIQUE']['CESFAM Cirujano Guzmán']['denominador'] = 432;
        // $data['IQUIQUE']['CESFAM Sur Iquique']['denominador'] = 497;
        // $data['IQUIQUE']['Posta Rural Chanavayita']['denominador'] = 5;
        // $data['IQUIQUE']['Posta Rural San Marcos']['denominador'] = 1;
        // $data['IQUIQUE']['CECOSF Cerro Esmeralda']['denominador'] = 3;

        // $data['PICA']['denominador'] = 78;
        // $data['PICA']['CESFAM Pica']['denominador'] = 78;
        // $data['PICA']['Posta Rural Cancosa']['denominador'] = 0;
        // $data['PICA']['Posta Rural Matilla']['denominador'] = 0;

        // $data['POZO ALMONTE']['denominador'] = 211;
        // $data['POZO ALMONTE']['CESFAM Pozo Almonte']['denominador'] = 211;
        // $data['POZO ALMONTE']['Posta Rural Mamiña']['denominador'] = 0;
        // $data['POZO ALMONTE']['Posta Rural La Tirana']['denominador'] = 0;
        // $data['POZO ALMONTE']['Posta Rural La Huayca']['denominador'] = 0;

        //echo '<pre>-'; print_r($data); die();

        /* ==== Calculos ==== */
        foreach($data as $nombre_comuna => $comuna) {
            foreach($comuna as $nombre_establecimiento => $establecimiento) {
                /* Existe en el array un indice ['numerador'], ['denominador'] y ['meta'],
                 * estos almacenan la información de la comuna, por lo tanto tengo que saltarlos
                 * en la iteración del foreach y continuar con los establecimientos */
                /* Realizar los calculos mensuales */
                if($nombre_establecimiento != 'numeradores' AND
                    $nombre_establecimiento != 'denominador' AND
                    $nombre_establecimiento != 'meta' AND
                    $nombre_establecimiento != 'cumplimiento'){

                    /* Calcula los totales de cada establecimiento */
                    if(is_array($establecimiento['numeradores'])) {
                        $data[$nombre_comuna][$nombre_establecimiento]['numeradores']['total'] = array_sum($establecimiento['numeradores']);
                        //$data[$nombre_comuna][$nombre_establecimiento]['denominadores']['total'] = array_sum($establecimiento['denominadores']);
                    }

                    /* Calcula los totales de cada comuna */
                    $data[$nombre_comuna]['numeradores']['total'] += $data[$nombre_comuna][$nombre_establecimiento]['numeradores']['total'];
                    //$data[$nombre_comuna]['denominadores']['total'] += $data[$nombre_comuna][$nombre_establecimiento]['denominadores']['total'];

                    /* Calcula la suma mensual por comuna */
                    for($mes=1; $mes <= $ultimo_rem; $mes++) {
                        $data[$nombre_comuna]['numeradores'][$mes] += $establecimiento['numeradores'][$mes];
                        //$data[$nombre_comuna]['denominadores'][$mes] += $establecimiento['denominadores'][$mes];
                    }

                    /* Calculo de las cumplimiento de cada establecimiento */
                    if($data[$nombre_comuna][$nombre_establecimiento]['denominador'] == 0) {
                        /* Si es 0 el denominadore entonces la cumplimiento es 0 */
                        $data[$nombre_comuna][$nombre_establecimiento]['cumplimiento'] = 0;
                    }
                    else {
                        /* De lo contrario calcular el porcentaje */
                        $data[$nombre_comuna][$nombre_establecimiento]['cumplimiento'] =
                            $data[$nombre_comuna][$nombre_establecimiento]['numeradores']['total'] / $data[$nombre_comuna][$nombre_establecimiento]['denominador'] * 100;
                    }

                    /* Calculo de las cumplimiento de la comuna */
                    if($data[$nombre_comuna]['denominador'] == 0) {
                        /* Si es 0 el denominadore entonces la cumplimiento es 0 */
                        $data[$nombre_comuna]['cumplimiento'] = 0;
                    }
                    else {
                        /* De lo contrario calcular el porcentaje */
                        $data[$nombre_comuna]['cumplimiento'] = $data[$nombre_comuna]['numeradores']['total'] / $data[$nombre_comuna]['denominador'] * 100;
                    }
                }
            }
        }
        include('19813/graphics.php');
        return view('indicators.19813.2019.indicador3a')->withData($data)->withLabel($label)->withData3a2019($data3a2019)->withMescarga($mescarga);
    }

    public function indicador3b(){
        $year = 2019;

        $sql_ultimo_rem = "SELECT MAX(Mes) as ultimo_rem FROM 2019rems;";
        $ultimo_rem = DB::connection('mysql_rem')->select($sql_ultimo_rem)[0]->ultimo_rem;

        /* Numerador = 09215313 09215413   Denominador = 01080008*/

        $label['meta'] = 'Cobertura de alta odontológica total en embarazadas.';
        $label['numerador'] = 'Nº de embarazadas con alta odontológica total de enero a diciembre 2019.';
        $label['denominador'] = 'Nº total de embarazadas ingresadas a control prenatal de enero a diciembre del 2019.';

        $meses = array(1,2,3,4,5,6,7,8,9,10,11,12);
        $flag1 = NULL;
        $flag2 = NULL;
        $data = array();

        $sql_establecimientos =
        'SELECT comuna, alias_estab
         FROM 2019establecimientos
         WHERE meta_san = 1
         ORDER BY comuna;';

        $establecimientos = DB::connection('mysql_rem')->select($sql_establecimientos);

        /* ==== Inicializar en 0 el arreglo de datos $data ==== */
        foreach($establecimientos as $establecimiento) {
            $data[$establecimiento->comuna]['numeradores']['total'] = 0;
            $data[$establecimiento->comuna]['denominadores']['total'] = 0;
            $data[$establecimiento->comuna]['cumplimiento'] = 0;
            for($mes=1; $mes <= $ultimo_rem; $mes++) {
                $data[$establecimiento->comuna]['numeradores'][$mes] = 0;
                $data[$establecimiento->comuna]['denominadores'][$mes] = 0;
                $data[$establecimiento->comuna][$establecimiento->alias_estab]['numeradores']['total'] = 0;
                $data[$establecimiento->comuna][$establecimiento->alias_estab]['denominadores']['total'] = 0;
                $data[$establecimiento->comuna][$establecimiento->alias_estab]['numeradores'][$mes] = 0;
                $data[$establecimiento->comuna][$establecimiento->alias_estab]['denominadores'][$mes] = 0;
            }
            $data[$establecimiento->comuna][$establecimiento->alias_estab]['cumplimiento'] = 0;
        }

        $data['ALTO HOSPICIO']['meta'] = '72%';
        $data['CAMIÑA']['meta'] = '75%';
        $data['COLCHANE']['meta'] = '80%';
        $data['HUARA']['meta'] = '74%';
        $data['IQUIQUE']['meta'] = '59%';
        $data['PICA']['meta'] = '85%';
        $data['POZO ALMONTE']['meta'] = '69%';

        /* ===== Query numerador =====
        09215313	INGRESOS Y EGRESOS  EN ESTABLECIMIENTOS APS - TIPO DE INGRESO O EGRESO - ALTAS ODONTOLÓGICAS PREVENTIVAS
        09215413	INGRESOS Y EGRESOS  EN ESTABLECIMIENTOS APS - TIPO DE INGRESO O EGRESO - ALTAS ODONTOLÓGICAS INTEGRALES (EXCLUYE SECCIÓN G)
        */
        $sql_numerador = 'SELECT e.Comuna, e.alias_estab, r.Mes, sum((ifnull(Col28,0))) as numerador
            FROM '.$year.'rems r
            LEFT JOIN 2019establecimientos e
            ON r.IdEstablecimiento=e.Codigo
            WHERE CodigoPrestacion IN (09215313,09215413) AND e.meta_san = 1
            GROUP BY e.Comuna, e.alias_estab, r.Mes
            ORDER BY e.Comuna, e.alias_estab, r.Mes';
        $numeradores = DB::connection('mysql_rem')->select($sql_numerador);

        foreach($numeradores as $registro) {
            if( ($flag1 != $registro->Comuna) OR ($flag2 != $registro->alias_estab) ) {
                for($mes=1; $mes <= $ultimo_rem; $mes++) {
                    $data[$registro->Comuna][$registro->alias_estab]['numeradores'][$mes] = 0;
                }
                $flag1 = $registro->Comuna;
                $flag2 = $registro->alias_estab;
            }
            $data[$registro->Comuna][$registro->alias_estab]['numeradores'][$registro->Mes] = $registro->numerador;
        }

        /* ===== Query denominador =====
        01080008	INGRESOS DE GESTANTES A PROGRAMA PRENATAL - CONDICIÓN - GESTANTES INGRESADAS
        */
        $sql_denominador = 'SELECT e.Comuna, e.alias_estab, r.Mes, (ifnull(Col01,0)) as denominador
            FROM '.$year.'rems r
            LEFT JOIN 2019establecimientos e
            ON r.IdEstablecimiento=e.Codigo
            WHERE CodigoPrestacion = 01080008 AND e.meta_san = 1
            ORDER BY e.Comuna, e.alias_estab, r.Mes';
        $denominadores = DB::connection('mysql_rem')->select($sql_denominador);

        foreach($denominadores as $registro) {
            if( ($flag1 != $registro->Comuna) OR ($flag2 != $registro->alias_estab) ) {
                for($mes=1; $mes <= $ultimo_rem; $mes++) {
                    $data[$registro->Comuna][$registro->alias_estab]['denominadores'][$mes] = 0;
                }
                $flag1 = $registro->Comuna;
                $flag2 = $registro->alias_estab;
            }
            $data[$registro->Comuna][$registro->alias_estab]['denominadores'][$registro->Mes] = $registro->denominador;
        }

        /* ==== Calculos ==== */
        foreach($data as $nombre_comuna => $comuna) {
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
                    $data[$nombre_comuna][$nombre_establecimiento]['denominadores']['total'] = array_sum($establecimiento['denominadores']);
                    $data[$nombre_comuna][$nombre_establecimiento]['numeradores']['total'] = array_sum($establecimiento['numeradores']);

                    /* Calcula los totales de cada comuna */
                    $data[$nombre_comuna]['numeradores']['total'] += $data[$nombre_comuna][$nombre_establecimiento]['numeradores']['total'];
                    $data[$nombre_comuna]['denominadores']['total'] += $data[$nombre_comuna][$nombre_establecimiento]['denominadores']['total'];

                    /* Calcula la suma mensual por comuna */
                    for($mes=1; $mes <= $ultimo_rem; $mes++) {
                        $data[$nombre_comuna]['numeradores'][$mes] += $establecimiento['numeradores'][$mes];
                        $data[$nombre_comuna]['denominadores'][$mes] += $establecimiento['denominadores'][$mes];
                    }

                    /* Calculo de las cumplimiento de cada establecimiento */
                    if($data[$nombre_comuna][$nombre_establecimiento]['denominadores']['total'] == 0) {
                        /* Si es 0 el denominadore entonces la cumplimiento es 0 */
                        $data[$nombre_comuna][$nombre_establecimiento]['cumplimiento'] = 0;
                    }
                    else {
                        /* De lo contrario calcular el porcentaje */
                        $data[$nombre_comuna][$nombre_establecimiento]['cumplimiento'] = $data[$nombre_comuna][$nombre_establecimiento]['numeradores']['total'] / $data[$nombre_comuna][$nombre_establecimiento]['denominadores']['total'] * 100;
                    }

                    /* Calculo de las cumplimiento de la comuna */
                    if($data[$nombre_comuna]['denominadores']['total'] == 0) {
                        /* Si es 0 el denominadore entonces la cumplimiento es 0 */
                        $data[$nombre_comuna]['cumplimiento'] = 0;
                    }
                    else {
                        /* De lo contrario calcular el porcentaje */
                        $data[$nombre_comuna]['cumplimiento'] = $data[$nombre_comuna]['numeradores']['total'] / $data[$nombre_comuna]['denominadores']['total'] * 100;
                    }
                }
            }
        }
        include('19813/graphics.php');
        return view('indicators.19813.2019.indicador3b')->withData($data)->withLabel($label)->withData3b2019($data3b2019)->withMescarga($mescarga);
    }

    public function indicador3c(){
        $year = 2019;

        $sql_ultimo_rem = "SELECT MAX(Mes) as ultimo_rem FROM 2019rems;";
        $ultimo_rem = DB::connection('mysql_rem')->select($sql_ultimo_rem)[0]->ultimo_rem;

        /* Numerador = 09215015   Denominador =    */
        $label['meta'] = 'Porcentaje de egresos odontológicos en niños y niñas de 6 años.';
        $label['numerador'] = 'N° niños de 6 años inscritos con egreso odontológico de enero a dic. 2019.';
        $label['denominador'] = 'Total niños de 6 años inscritos validados por FONASA para el año 2019.';


        $flag1 = NULL;
        $flag2 = NULL;
        $data = array();

        $sql_establecimientos = "SELECT comuna, alias_estab
                                 FROM 2019establecimientos
                                 WHERE meta_san = 1
                                 ORDER BY comuna";

        $establecimientos = DB::connection('mysql_rem')->select($sql_establecimientos);

        /* ==== Inicializar en 0 el arreglo de datos $data ==== */
        foreach($establecimientos as $establecimiento) {
            $data[$establecimiento->comuna]['numeradores']['total'] = 0;
            $data[$establecimiento->comuna]['denominador'] = 0;
            $data[$establecimiento->comuna]['cumplimiento'] = 0;
            for($mes=1; $mes <= $ultimo_rem; $mes++) {
                $data[$establecimiento->comuna]['numeradores'][$mes] = 0;
                $data[$establecimiento->comuna][$establecimiento->alias_estab]['numeradores']['total'] = 0;
                $data[$establecimiento->comuna][$establecimiento->alias_estab]['numeradores'][$mes] = 0;
            }
            $data[$establecimiento->comuna][$establecimiento->alias_estab]['denominador'] = 0;
            $data[$establecimiento->comuna][$establecimiento->alias_estab]['cumplimiento'] = 0;
        }


        $data['ALTO HOSPICIO']['meta'] = '74%';
        $data['CAMIÑA']['meta'] = '100%';
        $data['COLCHANE']['meta'] = '100%';
        $data['HUARA']['meta'] = '100%';
        $data['IQUIQUE']['meta'] = '83%';
        $data['PICA']['meta'] = '85%';
        $data['POZO ALMONTE']['meta'] = '80%';


        /* ===== Query numerador ===== */
        $sql_numerador = 'SELECT e.Comuna, e.alias_estab, r.Mes, sum((ifnull(Col16,0) + ifnull(Col17,0))) as numerador
            FROM '.$year.'rems r
            LEFT JOIN 2019establecimientos e
            ON r.IdEstablecimiento=e.Codigo
            WHERE CodigoPrestacion IN (09215015) AND e.meta_san = 1
            GROUP by e.Comuna, e.alias_estab, r.Mes
            ORDER BY e.Comuna, e.alias_estab, r.Mes';
        $numeradores = DB::connection('mysql_rem')->select($sql_numerador);

        foreach($numeradores as $registro) {
            if( ($flag1 != $registro->Comuna) OR ($flag2 != $registro->alias_estab) ) {
                for($mes=1; $mes <= $ultimo_rem; $mes++) {
                    $data[$registro->Comuna][$registro->alias_estab]['numeradores'][$mes] = 0;
                }
                $flag1 = $registro->Comuna;
                $flag2 = $registro->alias_estab;
            }
            $data[$registro->Comuna][$registro->alias_estab]['numeradores'][$registro->Mes] = $registro->numerador;
        }

        /* ===== Query denominador ===== */
        $sql_denominador = "SELECT e.alias_estab, e.Comuna, COUNT(*) AS denominador
                            FROM percapita_pro p
                            LEFT JOIN 2019establecimientos e ON e.Codigo = p.COD_CENTRO
                            WHERE
                            FECHA_CORTE = '2018-08-31' AND
                            EDAD = 6 AND
                            ACEPTADO_RECHAZADO = 'ACEPTADO' AND e.meta_san = 1
                            GROUP BY e.Comuna, e.alias_estab
                            ORDER BY e.Comuna, e.alias_estab";
        $denominadores = DB::connection('mysql_rem')->select($sql_denominador);



        foreach($denominadores as $registro) {
            $data[$registro->Comuna][$registro->alias_estab]['denominador'] = $registro->denominador;
            $data[$registro->Comuna]['denominador'] += $registro->denominador;
        }

        // $data['ALTO HOSPICIO']['denominador'] = 1641;
        // $data['ALTO HOSPICIO']['CESFAM Pedro Pulgar']['denominador'] = 1641;
        // $data['ALTO HOSPICIO']['CECOSF El Boro']['denominador'] = 0;
        // $data['ALTO HOSPICIO']['CECOSF La Tortuga']['denominador'] = 0;

        $data['CAMIÑA']['denominador'] = 28;
        $data['CAMIÑA']['CGR Camiña']['denominador'] = 0;
        $data['CAMIÑA']['Posta Rural Moquella']['denominador'] = 0;

        $data['COLCHANE']['denominador'] = 6;
        $data['COLCHANE']['CGR Colchane']['denominador'] = 0;
        $data['COLCHANE']['Posta Rural Enquelga']['denominador'] = 0;
        $data['COLCHANE']['Posta Rural Cariquima']['denominador'] = 0;

        $data['HUARA']['denominador'] = 77;
        $data['HUARA']['CGR Dr. Amador Neghme Rodríguez']['denominador'] = 0;
        $data['HUARA']['Posta Rural Pisagua']['denominador'] = 0;
        $data['HUARA']['Posta Rural Tarapacá']['denominador'] = 0;
        $data['HUARA']['Posta Rural Chiapa']['denominador'] = 0;
        $data['HUARA']['Posta Rural Sibaya']['denominador'] = 0;

        // $data['IQUIQUE']['denominador'] = 2622;
        // $data['IQUIQUE']['CESFAM Cirujano Aguirre']['denominador'] = 780;
        // $data['IQUIQUE']['CESFAM Cirujano Videla']['denominador'] = 702;
        // $data['IQUIQUE']['CESFAM Cirujano Guzmán']['denominador'] = 519;
        // $data['IQUIQUE']['CESFAM Sur Iquique']['denominador'] = 610;
        // $data['IQUIQUE']['Posta Rural Chanavayita']['denominador'] = 1;
        // $data['IQUIQUE']['Posta Rural San Marcos']['denominador'] = 1;
        // $data['IQUIQUE']['CECOSF Cerro Esmeralda']['denominador'] = 9;

        // $data['PICA']['denominador'] = 99;
        // $data['PICA']['CESFAM Pica']['denominador'] = 99;
        // $data['PICA']['Posta Rural Cancosa']['denominador'] = 0;
        // $data['PICA']['Posta Rural Matilla']['denominador'] = 0;

        // $data['POZO ALMONTE']['denominador'] = 258;
        // $data['POZO ALMONTE']['CESFAM Pozo Almonte']['denominador'] = 258;
        // $data['POZO ALMONTE']['Posta Rural Mamiña']['denominador'] = 0;
        // $data['POZO ALMONTE']['Posta Rural La Tirana']['denominador'] = 0;
        // $data['POZO ALMONTE']['Posta Rural La Huayca']['denominador'] = 0;

        /* ==== Calculos ==== */
        foreach($data as $nombre_comuna => $comuna) {
            foreach($comuna as $nombre_establecimiento => $establecimiento) {
                /* Existe en el array un indice ['numerador'], ['denominador'] y ['meta'],
                 * estos almacenan la información de la comuna, por lo tanto tengo que saltarlos
                 * en la iteración del foreach y continuar con los establecimientos */
                /* Realizar los calculos mensuales */
                if($nombre_establecimiento != 'numeradores' AND
                    $nombre_establecimiento != 'denominador' AND
                    $nombre_establecimiento != 'meta' AND
                    $nombre_establecimiento != 'cumplimiento'){

                    /* Calcula los totales de cada establecimiento */
                    if(is_array($establecimiento['numeradores'])) {
                        $data[$nombre_comuna][$nombre_establecimiento]['numeradores']['total'] = array_sum($establecimiento['numeradores']);
                        //$data[$nombre_comuna][$nombre_establecimiento]['denominadores']['total'] = array_sum($establecimiento['denominadores']);
                    }

                    /* Calcula los totales de cada comuna */
                    $data[$nombre_comuna]['numeradores']['total'] += $data[$nombre_comuna][$nombre_establecimiento]['numeradores']['total'];
                    //$data[$nombre_comuna]['denominadores']['total'] += $data[$nombre_comuna][$nombre_establecimiento]['denominadores']['total'];

                    /* Calcula la suma mensual por comuna */
                    for($mes=1; $mes <= $ultimo_rem; $mes++) {
                        $data[$nombre_comuna]['numeradores'][$mes] += $establecimiento['numeradores'][$mes];
                        //$data[$nombre_comuna]['denominadores'][$mes] += $establecimiento['denominadores'][$mes];
                    }

                    /* Calculo de las metas de cada establecimiento */
                    if($data[$nombre_comuna][$nombre_establecimiento]['denominador'] == 0) {
                        /* Si es 0 el denominadore entonces la cumplimiento es 0 */
                        $data[$nombre_comuna][$nombre_establecimiento]['cumplimiento'] = 0;
                    }
                    else {
                        /* De lo contrario calcular el porcentaje */
                        $data[$nombre_comuna][$nombre_establecimiento]['cumplimiento'] =
                            $data[$nombre_comuna][$nombre_establecimiento]['numeradores']['total'] / $data[$nombre_comuna][$nombre_establecimiento]['denominador'] * 100;
                    }

                    /* Calculo de las metas de la comuna */
                    if($data[$nombre_comuna]['denominador'] == 0) {
                        /* Si es 0 el denominadore entonces la cumplimiento es 0 */
                        $data[$nombre_comuna]['cumplimiento'] = 0;
                    }
                    else {
                        /* De lo contrario calcular el porcentaje */
                        $data[$nombre_comuna]['cumplimiento'] = $data[$nombre_comuna]['numeradores']['total'] / $data[$nombre_comuna]['denominador'] * 100;
                    }
                }
            }
        }
        include('19813/graphics.php');
        return view('indicators.19813.2019.indicador3c')->withData($data)->withLabel($label)->withData3c2019($data3c2019)->withMescarga($mescarga);
    }

    public function indicador4a(){
        $year = 2019;

        $sql_ultimo_rem = "SELECT MAX(Mes) as ultimo_rem FROM 2019rems;";
        $ultimo_rem = DB::connection('mysql_rem')->select($sql_ultimo_rem)[0]->ultimo_rem;

        $label['meta'] = 'Porcentaje de cobertura efectiva de personas con Diabetes Mellitus Tipo 2.';
        $label['numerador'] = 'Nº personas con DM2 de 15 a 79 años con Hb A1c <7% más N° personas con DM2 de 80 y más años con Hb A1c <8% según último control vigente.';
        $label['denominador'] = 'Total de personas con DM2 de 15 y más años estimadas según prevalencia. **';

        $data = array();

        $sql_establecimientos = "SELECT Codigo AS codigo, alias_estab AS nombre, comuna
                                 FROM 2019establecimientos
                                 WHERE meta_san = 1
                                 ORDER BY comuna;";

        $establecimientos = DB::connection('mysql_rem')->select($sql_establecimientos);

        $data['ALTO HOSPICIO']['meta'] = '16%';
        $data['CAMIÑA']['meta'] = '20%';
        $data['COLCHANE']['meta'] = '15%';
        $data['HUARA']['meta'] = '20%';
        $data['IQUIQUE']['meta'] = '30%';
        $data['PICA']['meta'] = '30%';
        $data['POZO ALMONTE']['meta'] = '24%';

        /* ==== Inicializar en 0 el arreglo de datos $data ==== */
        foreach($establecimientos as $establecimiento) {
            $data[$establecimiento->comuna]['numerador'] = 0;
            $data[$establecimiento->comuna]['establecimientos'][$establecimiento->nombre]['numerador'] = 0;

            $data[$establecimiento->comuna]['numerador_6'] = 0;
            $data[$establecimiento->comuna]['establecimientos'][$establecimiento->nombre]['numerador_6'] = 0;

            $data[$establecimiento->comuna]['numerador_12'] = 0;
            $data[$establecimiento->comuna]['establecimientos'][$establecimiento->nombre]['numerador_12'] = 0;

            $data[$establecimiento->comuna]['denominador'] = 0;
            $data[$establecimiento->comuna]['establecimientos'][$establecimiento->nombre]['denominador'] = 0;

            $data[$establecimiento->comuna]['cumplimiento'] = 0;
            $data[$establecimiento->comuna]['establecimientos'][$establecimiento->nombre]['cumplimiento'] = 0;

            $data[$establecimiento->comuna]['establecimientos'][$establecimiento->nombre]['meta'] = $data[$establecimiento->comuna]['meta'];
        }

        /* Sólo si está cargado sobre el rem de Junio */
        if($ultimo_rem >= 6) {
            /* ===== Query numerador ===== */
            $sql_numerador =
            "SELECT e.Comuna as comuna, e.alias_estab as nombre, r.Mes as mes, sum(ifnull(Col01,0)) as numerador
                FROM {$year}rems r
                LEFT JOIN 2019establecimientos e ON r.IdEstablecimiento=e.Codigo
                WHERE
                e.meta_san = 1 AND Ano = 2019 AND (Mes = 6 OR Mes = 12) AND
                CodigoPrestacion IN ('P4180300','P4200200')
                GROUP by e.Comuna, e.alias_estab, r.Mes
                ORDER BY e.Comuna, e.alias_estab, r.Mes";

            $numeradores = DB::connection('mysql_rem')->select($sql_numerador);

            foreach($numeradores as $registro) {
                if($registro->mes == 6) {
                    $data[$registro->comuna]['numerador_6'] += $registro->numerador;
                    $data[$registro->comuna]['establecimientos'][$registro->nombre]['numerador_6'] = $registro->numerador;
                }
                if($registro->mes == 12){
                    $data[$registro->comuna]['numerador_12'] += $registro->numerador;
                    $data[$registro->comuna]['establecimientos'][$registro->nombre]['numerador_12'] = $registro->numerador;
                }

                if($ultimo_rem < 12) {
                    $data[$registro->comuna]['numerador'] = $data[$registro->comuna]['numerador_6'];
                    $data[$registro->comuna]['establecimientos'][$registro->nombre]['numerador'] =
                        $data[$registro->comuna]['establecimientos'][$registro->nombre]['numerador_6'];
                }
                else {
                    $data[$registro->comuna]['numerador'] = $data[$registro->comuna]['numerador_12'];
                    $data[$registro->comuna]['establecimientos'][$registro->nombre]['numerador'] =
                        $data[$registro->comuna]['establecimientos'][$registro->nombre]['numerador_12'];
                }
            }




            /* ===== Query denominador ===== */
            $sql_denominador = "SELECT alias_estab as nombre, Comuna as comuna, SUM(denominador) as denominador
                            FROM
                            (
                            	(SELECT e.alias_estab, e.Comuna, COUNT(*)*0.1 AS denominador
                            		FROM percapita_pro p
                            		LEFT JOIN 2019establecimientos e ON e.Codigo = p.COD_CENTRO
                            		WHERE
                                    e.meta_san = 1 AND
                            		FECHA_CORTE = '2018-08-31' AND
                            		EDAD BETWEEN 15 AND 64 AND
                            		ACEPTADO_RECHAZADO = 'ACEPTADO'
                            		GROUP BY e.Comuna, e.alias_estab
                            		ORDER BY e.Comuna, e.alias_estab)

                            	UNION

                            	(SELECT e.alias_estab, e.Comuna, COUNT(*)*0.25 AS denominador
                            		FROM percapita_pro p
                            		LEFT JOIN 2019establecimientos e ON e.Codigo = p.COD_CENTRO
                            		WHERE
                                    e.meta_san = 1 AND
                            		FECHA_CORTE = '2018-08-31' AND
                            		EDAD >= 65 AND
                            		ACEPTADO_RECHAZADO = 'ACEPTADO'
                            		GROUP BY e.Comuna, e.alias_estab
                            		ORDER BY e.Comuna, e.alias_estab)
                            ) tmp
                            group by tmp.Comuna, tmp.alias_estab
                            order by tmp.Comuna, tmp.alias_estab";

            $denominadores = DB::connection('mysql_rem')->select($sql_denominador);

            foreach($denominadores as $registro) {
                $data[$registro->comuna]['denominador'] += $registro->denominador;
                $data[$registro->comuna]['establecimientos'][$registro->nombre]['denominador'] = $registro->denominador;
            }

            /* Poblaciones manuales (denominadores) */
            $data['CAMIÑA']['denominador'] = 140;
            $data['CAMIÑA']['establecimientos']['CGR Camiña']['denominador'] = 0;
            $data['CAMIÑA']['establecimientos']['Posta Rural Moquella']['denominador'] = 0;

            $data['COLCHANE']['denominador'] = 101;
            $data['COLCHANE']['establecimientos']['CGR Colchane']['denominador'] = 0;
            $data['COLCHANE']['establecimientos']['Posta Rural Enquelga']['denominador'] = 0;
            $data['COLCHANE']['establecimientos']['Posta Rural Cariquima']['denominador'] = 0;

            $data['HUARA']['denominador'] = 231;
            $data['HUARA']['establecimientos']['CGR Dr. Amador Neghme Rodríguez']['denominador'] = 0;
            $data['HUARA']['establecimientos']['Posta Rural Pisagua']['denominador'] = 0;
            $data['HUARA']['establecimientos']['Posta Rural Tarapacá']['denominador'] = 0;
            $data['HUARA']['establecimientos']['Posta Rural Chiapa']['denominador'] = 0;
            $data['HUARA']['establecimientos']['Posta Rural Sibaya']['denominador'] = 0;

            /* ==== Calculos ==== */
            foreach($data as $nombre_comuna => $comuna) {
                /* Calculo de las metas de la comuna */
                if($data[$nombre_comuna]['denominador'] == 0) {
                    /* Si es 0 el denominadore entonces la meta es 0 */
                    $data[$nombre_comuna]['cumplimiento'] = 0;
                }
                else {
                    $data[$nombre_comuna]['cumplimiento'] = number_format(
                        $data[$nombre_comuna]['numerador'] /
                        $data[$nombre_comuna]['denominador'] * 100
                        , 2, ',', '.');
                }
                /* Formateo de tipo de número después de hacer calculos*/
                $data[$nombre_comuna]['numerador'] = number_format($data[$nombre_comuna]['numerador'], 0, ',', '.');
                $data[$nombre_comuna]['numerador_6'] = number_format($data[$nombre_comuna]['numerador_6'], 0, ',', '.');
                $data[$nombre_comuna]['numerador_12'] = number_format($data[$nombre_comuna]['numerador_12'], 0, ',', '.');
                $data[$nombre_comuna]['denominador'] = number_format($data[$nombre_comuna]['denominador'], 0, ',', '.');

                foreach($comuna['establecimientos'] as $nombre_establecimiento => $establecimiento) {
                    /* Calculo de cumplimiento de cada establecimiento */
                    if($establecimiento['denominador'] == 0) {
                        /* Si es 0 el denominador entonces la meta es 0 */
                        $data[$nombre_comuna]['establecimientos'][$nombre_establecimiento]['cumplimiento'] = 0;
                    }
                    else {
                        $data[$nombre_comuna]['establecimientos'][$nombre_establecimiento]['cumplimiento'] = number_format(
                            $data[$nombre_comuna]['establecimientos'][$nombre_establecimiento]['numerador'] /
                            $data[$nombre_comuna]['establecimientos'][$nombre_establecimiento]['denominador'] * 100
                            , 2, ',', '.');
                    }

                    /* Formateo de tipo de número después de hacer calculos*/
                    $data[$nombre_comuna]['establecimientos'][$nombre_establecimiento]['numerador'] =
                       number_format($data[$nombre_comuna]['establecimientos'][$nombre_establecimiento]['numerador'], 0, ',', '.');
                    $data[$nombre_comuna]['establecimientos'][$nombre_establecimiento]['numerador_6'] =
                        number_format($data[$nombre_comuna]['establecimientos'][$nombre_establecimiento]['numerador_6'], 0, ',', '.');
                    $data[$nombre_comuna]['establecimientos'][$nombre_establecimiento]['numerador_12'] =
                        number_format($data[$nombre_comuna]['establecimientos'][$nombre_establecimiento]['numerador_12'], 0, ',', '.');
                    $data[$nombre_comuna]['establecimientos'][$nombre_establecimiento]['denominador'] =
                        number_format($data[$nombre_comuna]['establecimientos'][$nombre_establecimiento]['denominador'], 0, ',', '.');

                }
            }
        }
        //echo '<pre>'; print_r($data); die();
        //echo '<pre>'; print_r($data);
        include('19813/graphics.php');
        return view('indicators.19813.2019.indicador4a')->withData($data)->withLabel($label)->withData4a2019($data4a2019)->withMescarga($mescarga);
    }

    public function indicador4b(){
        $year = 2019;

        $sql_ultimo_rem = "SELECT MAX(Mes) as ultimo_rem FROM 2019rems;";
        $ultimo_rem = DB::connection('mysql_rem')->select($sql_ultimo_rem)[0]->ultimo_rem;

        $label['meta'] = 'Porcentaje de personas con diabetes de 15 años y más con evaluación anual de pie.';
        $label['numerador'] = 'N° de personas con diabetes bajo control de 15 y más años con una evaluación de pie vigente.';
        $label['denominador'] = 'N° total de personas diabéticas de 15 y más años bajo control al corte. **';

        $data = array();

        $sql_establecimientos = "SELECT comuna, alias_estab
                                 FROM 2019establecimientos
                                 WHERE meta_san = 1
                                 ORDER BY comuna;";

        $establecimientos = DB::connection('mysql_rem')->select($sql_establecimientos);

        /* ==== Inicializar en 0 el arreglo de datos $data ==== */
        foreach($establecimientos as $establecimiento) {
            /*$data[$establecimiento->comuna]['numerador'] = 0;
            $data[$establecimiento->comuna]['denominador'] = 0;
            $data[$establecimiento->comuna]['meta'] = 0;
            $data[$establecimiento->comuna]['cumplimiento'] = 0;
            $data[$establecimiento->comuna][$establecimiento->alias_estab]['numerador'] = 0;
            $data[$establecimiento->comuna][$establecimiento->alias_estab]['denominador'] = 0;
            $data[$establecimiento->comuna][$establecimiento->alias_estab]['meta'] = 0;
            $data[$establecimiento->comuna][$establecimiento->alias_estab]['cumplimiento'] = 0;*/

            $data[$establecimiento->comuna]['numerador'] = 0;
            $data[$establecimiento->comuna]['numerador_6'] = 0;
            $data[$establecimiento->comuna]['numerador_12'] = 0;
            $data[$establecimiento->comuna]['denominador'] = 0;
            $data[$establecimiento->comuna]['denominador_6'] = 0;
            $data[$establecimiento->comuna]['denominador_12'] = 0;
            $data[$establecimiento->comuna]['meta'] = 0;
            $data[$establecimiento->comuna]['cumplimiento'] = 0;
            $data[$establecimiento->comuna][$establecimiento->alias_estab]['numerador'] = 0;
            $data[$establecimiento->comuna][$establecimiento->alias_estab]['numerador_6'] = 0;
            $data[$establecimiento->comuna][$establecimiento->alias_estab]['numerador_12'] = 0;
            $data[$establecimiento->comuna][$establecimiento->alias_estab]['denominador'] = 0;
            $data[$establecimiento->comuna][$establecimiento->alias_estab]['denominador_6'] = 0;
            $data[$establecimiento->comuna][$establecimiento->alias_estab]['denominador_12'] = 0;
            $data[$establecimiento->comuna][$establecimiento->alias_estab]['meta'] = 0;
            $data[$establecimiento->comuna][$establecimiento->alias_estab]['cumplimiento'] = 0;
        }

        $data['ALTO HOSPICIO']['meta'] = '90%';
        $data['CAMIÑA']['meta'] = '90%';
        $data['COLCHANE']['meta'] = '94%';
        $data['HUARA']['meta'] = '90%';
        $data['IQUIQUE']['meta'] = '91%';
        $data['PICA']['meta'] = '90%';
        $data['POZO ALMONTE']['meta'] = '90%';

        /* ===== Query numerador ===== */
        $sql_numerador =
        "SELECT e.Comuna, e.alias_estab, r.Mes, sum(ifnull(Col01,0)) as numerador
            FROM ".$year."rems r
            LEFT JOIN 2019establecimientos e ON r.IdEstablecimiento=e.Codigo
            WHERE
            e.meta_san = 1 AND Ano = 2019 AND (Mes = 6 OR Mes = 12) AND
            CodigoPrestacion IN ('P4190809','P4170300','P4190500','P4190600')
            GROUP by e.Comuna, e.alias_estab, r.Mes
            ORDER BY e.Comuna, e.alias_estab, r.Mes";

        $numeradores = DB::connection('mysql_rem')->select($sql_numerador);

        foreach($numeradores as $registro) {
            /*$data[$registro->Comuna]['numerador'] += $registro->numerador;
            $data[$registro->Comuna][$registro->alias_estab]['numerador'] = $registro->numerador;*/

            if($registro->Mes == 6) {
                $data[$registro->Comuna]['numerador_6'] += $registro->numerador;
                $data[$registro->Comuna][$registro->alias_estab]['numerador_6'] = $registro->numerador;
            }
            if($registro->Mes == 12){
                $data[$registro->Comuna]['numerador_12'] += $registro->numerador;
                $data[$registro->Comuna][$registro->alias_estab]['numerador_12'] = $registro->numerador;
            }
        }

        /* ===== Query denominador ===== */
        $sql_denominador =
        "SELECT e.Comuna, e.alias_estab, r.Mes, sum(ifnull(Col01,0)) as denominador
            FROM ".$year."rems r
            LEFT JOIN 2019establecimientos e ON r.IdEstablecimiento=e.Codigo
            WHERE
            e.meta_san = 1 AND Ano = 2019 AND (Mes = 6 OR Mes = 12) AND
            CodigoPrestacion IN ('P4150602')
            GROUP by e.Comuna, e.alias_estab, r.Mes
            ORDER BY e.Comuna, e.alias_estab, r.Mes";

        $denomidores = DB::connection('mysql_rem')->select($sql_denominador);

        foreach($denomidores as $registro) {
            /*$data[$registro->Comuna]['denominador'] += $registro->denominador;
            $data[$registro->Comuna][$registro->alias_estab]['denominador'] = $registro->denominador;*/

            if($registro->Mes == 6) {
                $data[$registro->Comuna]['denominador_6'] += $registro->denominador;
                $data[$registro->Comuna][$registro->alias_estab]['denominador_6'] = $registro->denominador;
            }
            if($registro->Mes == 12){
                $data[$registro->Comuna]['denominador_12'] += $registro->denominador;
                $data[$registro->Comuna][$registro->alias_estab]['denominador_12'] = $registro->denominador;
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
                    $nombre_establecimiento != 'numerador_12' AND
                    $nombre_establecimiento != 'denominador' AND
                    $nombre_establecimiento != 'denominador_6' AND
                    $nombre_establecimiento != 'denominador_12' AND
                    $nombre_establecimiento != 'meta' AND
                    $nombre_establecimiento != 'cumplimiento'){

                    /* Calculo de las metas de cada establecimiento */
                    switch($ultimo_rem) {
                        case 1:
                        case 2:
                        case 3:
                        case 4:
                        case 5:
                            $data[$nombre_comuna]['cumplimiento'] = 0;
                            break;
                        case 6:
                        case 7:
                        case 8:
                        case 9:
                        case 10:
                        case 11:
                            $data[$nombre_comuna][$nombre_establecimiento]['numerador'] =
                                $data[$nombre_comuna][$nombre_establecimiento]['numerador_6'];
                            $data[$nombre_comuna][$nombre_establecimiento]['denominador'] =
                                $data[$nombre_comuna][$nombre_establecimiento]['denominador_6'];
                            break;
                        case 12:
                            $data[$nombre_comuna][$nombre_establecimiento]['numerador'] =
                                $data[$nombre_comuna][$nombre_establecimiento]['numerador_12'];
                            $data[$nombre_comuna][$nombre_establecimiento]['denominador'] =
                                $data[$nombre_comuna][$nombre_establecimiento]['denominador_12'];
                            break;
                    }
                    if($data[$nombre_comuna][$nombre_establecimiento]['denominador'] == 0) {
                        /* Si es 0 el denominadore entonces la meta es 0 */
                        $data[$nombre_comuna][$nombre_establecimiento]['cumplimiento'] = 0;
                    }
                    else {
                        /* De lo contrario calcular el porcentaje */
                        $data[$nombre_comuna][$nombre_establecimiento]['cumplimiento'] =
                            $data[$nombre_comuna][$nombre_establecimiento]['numerador'] /
                            $data[$nombre_comuna][$nombre_establecimiento]['denominador'] * 100;
                    }

                    /* Fija la meta de la comuna también a sus establecimientos */
                    $data[$nombre_comuna][$nombre_establecimiento]['meta'] = $data[$nombre_comuna]['meta'];


                    switch($ultimo_rem) {
                        case 1:
                        case 2:
                        case 3:
                        case 4:
                        case 5:
                            $data[$nombre_comuna]['cumplimiento'] = 0;
                            break;
                        case 6:
                        case 7:
                        case 8:
                        case 9:
                        case 10:
                        case 11:
                            $data[$nombre_comuna]['numerador'] =
                                $data[$nombre_comuna]['numerador_6'];
                            $data[$nombre_comuna]['denominador'] =
                                $data[$nombre_comuna]['denominador_6'];
                            break;
                        case 12:
                            $data[$nombre_comuna]['numerador'] =
                                $data[$nombre_comuna]['numerador_12'];
                            $data[$nombre_comuna]['denominador'] =
                                $data[$nombre_comuna]['denominador_12'];
                            break;
                    }
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
        //echo '<pre>'; print_r($data); die();
        //echo '<pre>'; print_r($data);
        include('19813/graphics.php');
        return view('indicators.19813.2019.indicador4b')->withData($data)->withLabel($label)->withData4b2019($data4b2019)->withMescarga($mescarga);
    }

    public function indicador5(){
        $year = 2019;

        $sql_ultimo_rem = "SELECT MAX(Mes) as ultimo_rem FROM 2019rems;";
        $ultimo_rem = DB::connection('mysql_rem')->select($sql_ultimo_rem)[0]->ultimo_rem;

        $label['meta'] = 'Porcentaje de personas mayores de 15 años y más con cobertura efectiva de hipertensión arterial.';
        $label['numerador'] = 'N° Personas hipertensas de 15 a 79 años con PA<140/90 mmHg más N° personas hipertensas de 80 y más años con PA<150/90 mmHg, según último control vigente.';
        $label['denominador'] = 'N° total de personas hipertensas de 15 y más años estimadas según prevalencia (últimos 12 meses).';

        $data = array();

        $sql_establecimientos = "SELECT comuna, alias_estab
                                 FROM 2019establecimientos
                                 WHERE meta_san = 1
                                 ORDER BY comuna;";

        $establecimientos = DB::connection('mysql_rem')->select($sql_establecimientos);

        /* ==== Inicializar en 0 el arreglo de datos $data ==== */
        foreach($establecimientos as $establecimiento) {
            $data[$establecimiento->comuna]['numerador'] = 0;
            $data[$establecimiento->comuna]['numerador_6'] = 0;
            $data[$establecimiento->comuna]['numerador_12'] = 0;
            $data[$establecimiento->comuna]['denominador'] = 0;
            $data[$establecimiento->comuna]['meta'] = 0;
            $data[$establecimiento->comuna]['cumplimiento'] = 0;
            $data[$establecimiento->comuna][$establecimiento->alias_estab]['numerador'] = 0;
            $data[$establecimiento->comuna][$establecimiento->alias_estab]['numerador_6'] = 0;
            $data[$establecimiento->comuna][$establecimiento->alias_estab]['numerador_12'] = 0;
            $data[$establecimiento->comuna][$establecimiento->alias_estab]['denominador'] = 0;
            $data[$establecimiento->comuna][$establecimiento->alias_estab]['meta'] = 0;
            $data[$establecimiento->comuna][$establecimiento->alias_estab]['cumplimiento'] = 0;
        }

        $data['ALTO HOSPICIO']['meta'] = '23%';
        $data['CAMIÑA']['meta'] = '27%';
        $data['COLCHANE']['meta'] = '13%';
        $data['HUARA']['meta'] = '30%';
        $data['IQUIQUE']['meta'] = '50%';
        $data['PICA']['meta'] = '47%';
        $data['POZO ALMONTE']['meta'] = '34%';

        /* ===== Query numerador ===== */
        $sql_numerador =
        "SELECT e.Comuna, e.alias_estab, r.Mes, sum(ifnull(Col01,0)) as numerador
            FROM ".$year."rems r
            LEFT JOIN 2019establecimientos e ON r.IdEstablecimiento=e.Codigo
            WHERE
            e.meta_san = 1 AND Ano = 2019 AND (Mes = 6 OR Mes = 12) AND
            CodigoPrestacion IN ('P4180200','P4200100')
            GROUP by e.Comuna, e.alias_estab, r.Mes
            ORDER BY e.Comuna, e.alias_estab, r.Mes";

        $numeradores = DB::connection('mysql_rem')->select($sql_numerador);

        foreach($numeradores as $registro) {
            /*$data[$registro->Comuna]['numerador'] += $registro->numerador;
            $data[$registro->Comuna][$registro->alias_estab]['numerador'] = $registro->numerador;*/

            if($registro->Mes == 6) {
                $data[$registro->Comuna]['numerador_6'] += $registro->numerador;
                $data[$registro->Comuna][$registro->alias_estab]['numerador_6'] = $registro->numerador;
            }
            if($registro->Mes == 12){
                $data[$registro->Comuna]['numerador_12'] += $registro->numerador;
                $data[$registro->Comuna][$registro->alias_estab]['numerador_12'] = $registro->numerador;
            }
        }

        /* ===== Query denominador ===== */
        $sql_denominador = "SELECT alias_estab, Comuna, SUM(denominador) as denominador
                            FROM
                            (
                            	(SELECT e.alias_estab, e.Comuna, COUNT(*)*0.157 AS denominador
                            		FROM percapita_pro p
                            		LEFT JOIN 2019establecimientos e ON e.Codigo = p.COD_CENTRO
                            		WHERE
                            		FECHA_CORTE = '2018-08-31' AND
                            		EDAD BETWEEN 15 AND 64 AND
                            		ACEPTADO_RECHAZADO = 'ACEPTADO' AND e.meta_san = 1
                            		GROUP BY e.Comuna, e.alias_estab
                            		ORDER BY e.Comuna, e.alias_estab)

                            	UNION

                            	(SELECT e.alias_estab, e.Comuna, COUNT(*)*0.643 AS denominador
                            		FROM percapita_pro p
                            		LEFT JOIN 2019establecimientos e ON e.Codigo = p.COD_CENTRO
                            		WHERE
                            		FECHA_CORTE = '2018-08-31' AND
                            		EDAD >= 65 AND
                            		ACEPTADO_RECHAZADO = 'ACEPTADO' AND e.meta_san = 1
                            		GROUP BY e.Comuna, e.alias_estab
                            		ORDER BY e.Comuna, e.alias_estab)
                            ) tmp
                            group by tmp.Comuna, tmp.alias_estab
                            order by tmp.Comuna, tmp.alias_estab";

        $denominadores = DB::connection('mysql_rem')->select($sql_denominador);

        foreach($denominadores as $registro) {
            $data[$registro->Comuna]['denominador'] += $registro->denominador;
            $data[$registro->Comuna][$registro->alias_estab]['denominador'] = $registro->denominador;
        }

        $data['CAMIÑA']['denominador'] = 279;
        $data['CAMIÑA']['CGR Camiña']['denominador'] = 0;
        $data['CAMIÑA']['Posta Rural Moquella']['denominador'] = 0;

        $data['COLCHANE']['denominador'] = 208;
        $data['COLCHANE']['CGR Colchane']['denominador'] = 0;
        $data['COLCHANE']['Posta Rural Enquelga']['denominador'] = 0;
        $data['COLCHANE']['Posta Rural Cariquima']['denominador'] = 0;

        $data['HUARA']['denominador'] = 450;
        $data['HUARA']['CGR Dr. Amador Neghme Rodríguez']['denominador'] = 0;
        $data['HUARA']['Posta Rural Pisagua']['denominador'] = 0;
        $data['HUARA']['Posta Rural Tarapacá']['denominador'] = 0;
        $data['HUARA']['Posta Rural Chiapa']['denominador'] = 0;
        $data['HUARA']['Posta Rural Sibaya']['denominador'] = 0;

        /* ==== Calculos ==== */
        foreach($data as $nombre_comuna => $comuna) {
            foreach($comuna as $nombre_establecimiento => $establecimiento) {
                /* Existe en el array un indice ['numerador'], ['denominador'] y ['meta'],
                 * estos almacenan la información de la comuna, por lo tanto tengo que saltarlos
                 * en la iteración del foreach y continuar con los establecimientos */
                /* Realizar los calculos mensuales */
                if($nombre_establecimiento != 'numerador' AND
                    $nombre_establecimiento != 'numerador_6' AND
                    $nombre_establecimiento != 'numerador_12' AND
                    $nombre_establecimiento != 'denominador' AND
                    $nombre_establecimiento != 'meta' AND
                    $nombre_establecimiento != 'cumplimiento'){

                    /* Calculo de las metas de cada establecimiento */
                    if($data[$nombre_comuna][$nombre_establecimiento]['denominador'] == 0) {
                        /* Si es 0 el denominadore entonces la meta es 0 */
                        $data[$nombre_comuna][$nombre_establecimiento]['cumplimiento'] = 0;
                    }
                    else {
                        /* De lo contrario calcular el porcentaje */
                        switch($ultimo_rem) {
                            case 1:
                            case 2:
                            case 3:
                            case 4:
                            case 5:
                                $data[$nombre_comuna]['cumplimiento'] = 0;
                                break;
                            case 6:
                            case 7:
                            case 8:
                            case 9:
                            case 10:
                            case 11:
                                $data[$nombre_comuna][$nombre_establecimiento]['numerador'] =
                                    $data[$nombre_comuna][$nombre_establecimiento]['numerador_6'];
                                break;
                            case 12:
                                $data[$nombre_comuna][$nombre_establecimiento]['numerador'] =
                                    $data[$nombre_comuna][$nombre_establecimiento]['numerador_12'];
                                break;
                        }
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
                        switch($ultimo_rem) {
                            case 1:
                            case 2:
                            case 3:
                            case 4:
                            case 5:
                                $data[$nombre_comuna]['cumplimiento'] = 0;
                                break;
                            case 6:
                            case 7:
                            case 8:
                            case 9:
                            case 10:
                            case 11:
                                $data[$nombre_comuna]['numerador'] =
                                    $data[$nombre_comuna]['numerador_6'];
                                break;
                            case 12:
                                $data[$nombre_comuna]['numerador'] =
                                    $data[$nombre_comuna]['numerador_12'];
                                break;
                        }
                        $data[$nombre_comuna]['cumplimiento'] = $data[$nombre_comuna]['numerador'] / $data[$nombre_comuna]['denominador'] * 100;
                    }
                }
            }
        }

        //echo '<pre>'; print_r($data); die();
        //echo '<pre>'; print_r($data);
        include('19813/graphics.php');
        return view('indicators.19813.2019.indicador5')->withData($data)->withLabel($label)->withData52019($data52019)->withMescarga($mescarga);
    }

    public function indicador6(){
        $year = 2019;

        $sql_ultimo_rem = "SELECT MAX(Mes) as ultimo_rem FROM 2019rems;";
        $ultimo_rem = DB::connection('mysql_rem')->select($sql_ultimo_rem)[0]->ultimo_rem;

        /* Numerador = A0200002	LACTANCIA MATERNA EN MENORES CONTROLADOS - TIPO DE ALIMENTACIÓN - LACTANCIA MATERNA EXCLUSIVA
           Denominador = A0200001	LACTANCIA MATERNA EN MENORES CONTROLADOS - TIPO DE ALIMENTACIÓN - MENORES CONTROLADOS
        */
        $label['meta'] = 'Porcentaje de niños y niñas que al sexto mes de vida, cuentan con lactancia materna exclusiva.';
        $label['numerador'] = 'N° de niños/as que al control de salud del sexto mes recibieron LME en el periodo de enero-diciembre 2019.';
        $label['denominador'] = 'N° de niños/as con control de salud del sexto mes realizado en el periodo de enero-diciembre 2019.';

        $meses = array(1,2,3,4,5,6,7,8,9,10,11,12);
        $flag1 = NULL;
        $flag2 = NULL;
        $data = array();

        $sql_establecimientos =
        'SELECT comuna, alias_estab
         FROM 2019establecimientos
         WHERE meta_san = 1
         ORDER BY comuna;';

        $establecimientos = DB::connection('mysql_rem')->select($sql_establecimientos);

        /* ==== Inicializar en 0 el arreglo de datos $data ==== */
        foreach($establecimientos as $establecimiento) {
            $data[$establecimiento->comuna]['numeradores']['total'] = 0;
            $data[$establecimiento->comuna]['denominadores']['total'] = 0;
            $data[$establecimiento->comuna]['cumplimiento'] = 0;
            for($mes=1; $mes <= $ultimo_rem; $mes++) {
                $data[$establecimiento->comuna]['numeradores'][$mes] = 0;
                $data[$establecimiento->comuna]['denominadores'][$mes] = 0;
                $data[$establecimiento->comuna][$establecimiento->alias_estab]['numeradores']['total'] = 0;
                $data[$establecimiento->comuna][$establecimiento->alias_estab]['denominadores']['total'] = 0;
                $data[$establecimiento->comuna][$establecimiento->alias_estab]['numeradores'][$mes] = 0;
                $data[$establecimiento->comuna][$establecimiento->alias_estab]['denominadores'][$mes] = 0;
            }
            $data[$establecimiento->comuna][$establecimiento->alias_estab]['cumplimiento'] = 0;
        }

        $data['ALTO HOSPICIO']['meta'] = '60%';
        $data['CAMIÑA']['meta'] = '70%';
        $data['COLCHANE']['meta'] = '100%';
        $data['HUARA']['meta'] = '75%';
        $data['IQUIQUE']['meta'] = '63%';
        $data['PICA']['meta'] = '60%';
        $data['POZO ALMONTE']['meta'] = '56%';

        /* ===== Query numerador ===== */
        $sql_numerador = 'SELECT e.Comuna, e.alias_estab, r.Mes, (ifnull(Col08,0) + ifnull(Col09,0)) as numerador
            FROM '.$year.'rems r
            LEFT JOIN 2019establecimientos e
            ON r.IdEstablecimiento=e.Codigo
            WHERE CodigoPrestacion = "A0200002" AND e.meta_san = 1
            ORDER BY e.Comuna, e.alias_estab, r.Mes';
        $numeradores = DB::connection('mysql_rem')->select($sql_numerador);

        foreach($numeradores as $registro) {
            if( ($flag1 != $registro->Comuna) OR ($flag2 != $registro->alias_estab) ) {
                for($mes=1; $mes <= $ultimo_rem; $mes++) {
                    $data[$registro->Comuna][$registro->alias_estab]['numeradores'][$mes] = 0;
                }
                $flag1 = $registro->Comuna;
                $flag2 = $registro->alias_estab;
            }
            $data[$registro->Comuna][$registro->alias_estab]['numeradores'][$registro->Mes] = $registro->numerador;
        }

        /* ===== Query denominador ===== */
        $sql_denominador = 'SELECT e.Comuna, e.alias_estab, r.Mes, (ifnull(Col08,0) + ifnull(Col09,0)) as denominador
            FROM '.$year.'rems r
            LEFT JOIN 2019establecimientos e
            ON r.IdEstablecimiento=e.Codigo
            WHERE CodigoPrestacion = "A0200001" AND e.meta_san = 1
            ORDER BY e.Comuna, e.alias_estab, r.Mes';
        $denominadores = DB::connection('mysql_rem')->select($sql_denominador);

        foreach($denominadores as $registro) {
            if( ($flag1 != $registro->Comuna) OR ($flag2 != $registro->alias_estab) ) {
                for($mes=1; $mes <= $ultimo_rem; $mes++) {
                    $data[$registro->Comuna][$registro->alias_estab]['denominadores'][$mes] = 0;
                }
                $flag1 = $registro->Comuna;
                $flag2 = $registro->alias_estab;
            }
            $data[$registro->Comuna][$registro->alias_estab]['denominadores'][$registro->Mes] = $registro->denominador;
        }

        /* ==== Calculos ==== */
        foreach($data as $nombre_comuna => $comuna) {
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
                    $data[$nombre_comuna][$nombre_establecimiento]['denominadores']['total'] = array_sum($establecimiento['denominadores']);
                    $data[$nombre_comuna][$nombre_establecimiento]['numeradores']['total'] = array_sum($establecimiento['numeradores']);

                    /* Calcula los totales de cada comuna */
                    $data[$nombre_comuna]['numeradores']['total'] += $data[$nombre_comuna][$nombre_establecimiento]['numeradores']['total'];
                    $data[$nombre_comuna]['denominadores']['total'] += $data[$nombre_comuna][$nombre_establecimiento]['denominadores']['total'];

                    /* Calcula la suma mensual por comuna */
                    for($mes=1; $mes <= $ultimo_rem; $mes++) {
                        $data[$nombre_comuna]['numeradores'][$mes] += $establecimiento['numeradores'][$mes];
                        $data[$nombre_comuna]['denominadores'][$mes] += $establecimiento['denominadores'][$mes];
                    }

                    /* Calculo de las metas de cada establecimiento */
                    if($data[$nombre_comuna][$nombre_establecimiento]['denominadores']['total'] == 0) {
                        /* Si es 0 el denominadore entonces la cumplimiento es 0 */
                        $data[$nombre_comuna][$nombre_establecimiento]['cumplimiento'] = 0;
                    }
                    else {
                        /* De lo contrario calcular el porcentaje */
                        $data[$nombre_comuna][$nombre_establecimiento]['cumplimiento'] = $data[$nombre_comuna][$nombre_establecimiento]['numeradores']['total'] / $data[$nombre_comuna][$nombre_establecimiento]['denominadores']['total'] * 100;
                    }

                    /* Calculo de las metas de la comuna */
                    if($data[$nombre_comuna]['denominadores']['total'] == 0) {
                        /* Si es 0 el denominadore entonces la cumplimiento es 0 */
                        $data[$nombre_comuna]['cumplimiento'] = 0;
                    }
                    else {
                        /* De lo contrario calcular el porcentaje */
                        $data[$nombre_comuna]['cumplimiento'] = $data[$nombre_comuna]['numeradores']['total'] / $data[$nombre_comuna]['denominadores']['total'] * 100;
                    }
                }
            }
        }

        //echo '<pre>'; print_r($data);
        include('19813/graphics.php');
        return view('indicators.19813.2019.indicador6')->withData($data)->withLabel($label)->withData62019($data62019)->withMescarga($mescarga);
        /* 09215313 09215413   01080008*/
    }
}
