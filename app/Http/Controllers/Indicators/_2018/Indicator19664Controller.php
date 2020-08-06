<?php

namespace App\Http\Controllers\Indicators\_2018;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class Indicator19664Controller extends Controller
{
    public function index()
    {
        return view('indicators.19664.2018.index');
    }

    /***********************************/
    /*********** HOSPITAL **************/
    /***********************************/
    public function servicio(){
        $year = 2018;


        /* INDICADOR 1 */
        //$breadcrumb = $collect(request()->segments());

        $label1['meta'] = '1.1 Porcentaje de pacientes diabéticos compensados
            bajo control en el grupo de 15 años y más en el nivel primario.';
        $label1['numerador'] = 'N° de personas con DM2 de 15 A 79 años con
            Hemoglobina Glicosilada bajo 7%, más el N° de personas con DM2 de
            80 y mas años con Hemoglobina Glicosilada bajo 8% según último
            control vigente, en los últimos 12 meses';
        $label1['denominador'] = 'Total de pacientes diabéticos de 15 y más años
            bajo control en el nivel primario';

        $data1 = array();

        $sql_establecimientos = "SELECT servicio_salud, comuna, alias_estab
                           FROM establecimientos
                           WHERE meta_san_18834 = 1
                           ORDER BY comuna";

        $establecimientos = DB::connection('mysql_rem')->select($sql_establecimientos);

        /* ==== Inicializar en 0 el arreglo de datos $data ==== */
        foreach($establecimientos as $establecimiento) {
            $data1[$establecimiento->servicio_salud]['numerador'] = 0;
            $data1[$establecimiento->servicio_salud]['numerador_6'] = 0;
            $data1[$establecimiento->servicio_salud]['denominador'] = 0;
            $data1[$establecimiento->servicio_salud]['denominador_6'] = 0;
            $data1[$establecimiento->servicio_salud]['meta'] = 0;
            $data1[$establecimiento->servicio_salud]['cumplimiento'] = 0;
            $data1[$establecimiento->servicio_salud][$establecimiento->alias_estab]['numerador'] = 0;
            $data1[$establecimiento->servicio_salud][$establecimiento->alias_estab]['numerador_6'] = 0;
            $data1[$establecimiento->servicio_salud][$establecimiento->alias_estab]['denominador'] = 0;
            $data1[$establecimiento->servicio_salud][$establecimiento->alias_estab]['denominador_6'] = 0;
            $data1[$establecimiento->servicio_salud][$establecimiento->alias_estab]['meta'] = 0;
            $data1[$establecimiento->servicio_salud][$establecimiento->alias_estab]['cumplimiento'] = 0;
        }

        $data1['SERVICIO DE SALUD IQUIQUE']['meta'] = '≥45%';

        /* ===== Query numerador ===== */
        $sql_numerador =
            "SELECT e.servicio_salud, e.alias_estab, r.Mes, sum(ifnull(Col01,0)) as numerador
            FROM {$year}rems r
            LEFT JOIN establecimientos e ON r.IdEstablecimiento=e.Codigo
            WHERE
            e.meta_san_18834 = 1 AND Ano = $year AND (Mes = 6 OR Mes = 12) AND
            CodigoPrestacion IN ('P4180300','P4200200')
            GROUP by e.servicio_salud, e.alias_estab, r.Mes
            ORDER BY e.servicio_salud, e.alias_estab, r.Mes";

        $numeradores = DB::connection('mysql_rem')->select($sql_numerador);

        foreach($numeradores as $registro) {
            /*$data1[$registro->servicio_salud]['numerador'] += $registro->numerador;
            $data1[$registro->servicio_salud][$registro->alias_estab]['numerador'] = $registro->numerador;*/

            if($registro->Mes == 6) {
                $data1[$registro->servicio_salud]['numerador_6'] += $registro->numerador;
                $data1[$registro->servicio_salud][$registro->alias_estab]['numerador_6'] = $registro->numerador;
            }
            if($registro->Mes == 12){
                $data1[$registro->servicio_salud]['numerador'] += $registro->numerador;
                $data1[$registro->servicio_salud][$registro->alias_estab]['numerador'] = $registro->numerador;
            }
        }

        /* ===== Query denominador ===== */
        $sql_denominador =
            "SELECT e.servicio_salud, e.alias_estab, r.Mes, sum(ifnull(Col01,0)) as denominador
            FROM {$year}rems r
            LEFT JOIN establecimientos e ON r.IdEstablecimiento=e.Codigo
            WHERE
            e.meta_san_18834 = 1 AND Ano = $year AND (Mes = 6 OR Mes = 12) AND
            CodigoPrestacion IN ('P4150602')
            GROUP by e.servicio_salud, e.alias_estab, r.Mes
            ORDER BY e.servicio_salud, e.alias_estab, r.Mes";

            $denomidores = DB::connection('mysql_rem')->select($sql_denominador);

            foreach($denomidores as $registro) {
            /*$data1[$registro->servicio_salud]['denominador'] += $registro->denominador;
            $data1[$registro->servicio_salud][$registro->alias_estab]['denominador'] = $registro->denominador;*/

            if($registro->Mes == 6){
                $data1[$registro->servicio_salud]['denominador_6'] += $registro->denominador;
                $data1[$registro->servicio_salud][$registro->alias_estab]['denominador_6'] = $registro->denominador;
            }
            if($registro->Mes == 12){
                $data1[$registro->servicio_salud]['denominador'] += $registro->denominador;
                $data1[$registro->servicio_salud][$registro->alias_estab]['denominador'] = $registro->denominador;
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
                            $data1[$nombre_comuna][$nombre_establecimiento]['numerador'] /
                            $data1[$nombre_comuna][$nombre_establecimiento]['denominador'] * 100;
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
                        $data1[$nombre_comuna]['cumplimiento'] =
                            $data1[$nombre_comuna]['numerador'] /
                            $data1[$nombre_comuna]['denominador'] * 100;
                    }
                }
            }
        }

        /* INDICADOR 1.2 */
        $label2['meta'] = '1.2 Porcentaje de pacientes hipertensos compensados
            bajo control en el grupo de 15 y más años en el nivel primario.';
        $label2['numerador'] = 'N° personas hipertensas de 15-79 años con
            presión arterial <140/90 mmHg, más N° personas hipertensas de 80 y
            más años con presión arterial <150/90 mmHg, según último control
            vigente, en los últimos 12 meses.';
        $label2['denominador'] = 'Total de pacientes Hipertensos de 15 y más
            años bajo control en el nivel primario.';

        $data = array();

        $sql_establecimientos = "SELECT servicio_salud, comuna, alias_estab
                               FROM establecimientos
                               WHERE meta_san_18834 = 1
                               ORDER BY comuna";

        $establecimientos = DB::connection('mysql_rem')->select($sql_establecimientos);

        /* ==== Inicializar en 0 el arreglo de datos $data ==== */
        foreach($establecimientos as $establecimiento) {
            $data2[$establecimiento->servicio_salud]['numerador'] = 0;
            $data2[$establecimiento->servicio_salud]['numerador_6'] = 0;
            $data2[$establecimiento->servicio_salud]['denominador'] = 0;
            $data2[$establecimiento->servicio_salud]['denominador_6'] = 0;
            $data2[$establecimiento->servicio_salud]['meta'] = 0;
            $data2[$establecimiento->servicio_salud]['cumplimiento'] = 0;
            $data2[$establecimiento->servicio_salud][$establecimiento->alias_estab]['numerador'] = 0;
            $data2[$establecimiento->servicio_salud][$establecimiento->alias_estab]['numerador_6'] = 0;
            $data2[$establecimiento->servicio_salud][$establecimiento->alias_estab]['denominador'] = 0;
            $data2[$establecimiento->servicio_salud][$establecimiento->alias_estab]['denominador_6'] = 0;
            $data2[$establecimiento->servicio_salud][$establecimiento->alias_estab]['meta'] = 0;
            $data2[$establecimiento->servicio_salud][$establecimiento->alias_estab]['cumplimiento'] = 0;
        }

        $data2['SERVICIO DE SALUD IQUIQUE']['meta'] = '≥68%';

        /* ===== Query numerador ===== */
        $sql_numerador =
            "SELECT e.servicio_salud, e.alias_estab, r.Mes, sum(ifnull(Col01,0)) as numerador
            FROM {$year}rems r
            LEFT JOIN establecimientos e ON r.IdEstablecimiento=e.Codigo
            WHERE
            e.meta_san_18834 = 1 AND Ano = $year AND (Mes = 6 OR Mes = 12) AND
            CodigoPrestacion IN ('P4180200','P4200100')
            GROUP by e.servicio_salud, e.alias_estab, r.Mes
            ORDER BY e.servicio_salud, e.alias_estab, r.Mes";

        $numeradores = DB::connection('mysql_rem')->select($sql_numerador);

        foreach($numeradores as $registro) {
            /*$data2[$registro->servicio_salud]['numerador'] += $registro->numerador;
            $data2[$registro->servicio_salud][$registro->alias_estab]['numerador'] = $registro->numerador;*/

            if($registro->Mes == 6) {
                $data2[$registro->servicio_salud]['numerador_6'] += $registro->numerador;
                $data2[$registro->servicio_salud][$registro->alias_estab]['numerador_6'] = $registro->numerador;
            }
            if($registro->Mes == 12){
                $data2[$registro->servicio_salud]['numerador'] += $registro->numerador;
                $data2[$registro->servicio_salud][$registro->alias_estab]['numerador'] = $registro->numerador;
            }
        }

        /* ===== Query denominador ===== */
        $sql_denominador =
            "SELECT e.servicio_salud, e.alias_estab, r.Mes, sum(ifnull(Col01,0)) as denominador
            FROM {$year}rems r
            LEFT JOIN establecimientos e ON r.IdEstablecimiento=e.Codigo
            WHERE
            e.meta_san_18834 = 1 AND Ano = $year AND (Mes = 6 OR Mes = 12) AND
            CodigoPrestacion IN ('P4150601')
            GROUP by e.servicio_salud, e.alias_estab, r.Mes
            ORDER BY e.servicio_salud, e.alias_estab, r.Mes";

        $denomidores = DB::connection('mysql_rem')->select($sql_denominador);

        foreach($denomidores as $registro) {
            /*$data2[$registro->servicio_salud]['denominador'] += $registro->denominador;
            $data2[$registro->servicio_salud][$registro->alias_estab]['denominador'] = $registro->denominador;*/

            if($registro->Mes == 6){
                $data2[$registro->servicio_salud]['denominador_6'] += $registro->denominador;
                $data2[$registro->servicio_salud][$registro->alias_estab]['denominador_6'] = $registro->denominador;
            }
            if($registro->Mes == 12){
                $data2[$registro->servicio_salud]['denominador'] += $registro->denominador;
                $data2[$registro->servicio_salud][$registro->alias_estab]['denominador'] = $registro->denominador;
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
                            $data2[$nombre_comuna][$nombre_establecimiento]['numerador'] /
                            $data2[$nombre_comuna][$nombre_establecimiento]['denominador'] * 100;
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
                        $data2[$nombre_comuna]['cumplimiento'] =
                            $data2[$nombre_comuna]['numerador'] /
                            $data2[$nombre_comuna]['denominador'] * 100;
                    }
                }
            }
        }

        /* INDICADOR 1.3 */
        $label3['meta'] = '1.3 Porcentaje de Evaluación Anual de los Pies en
            personas con Diabetes bajo control de 15 y más años, en el año t.';
        $label3['numerador'] = 'N° de Personas con diabetes bajo control de 15
            y más años con una evaluación de pie, vigente en el año t.';
        $label3['denominador'] = 'N° Total de personas diabéticas de 15 y más
            años bajo control en el año t.';

        $data = array();

        $sql_establecimientos =
            "SELECT servicio_salud, comuna, alias_estab
            FROM establecimientos
            WHERE meta_san_18834 = 1
            ORDER BY comuna";

        $establecimientos = DB::connection('mysql_rem')->select($sql_establecimientos);

        /* ==== Inicializar en 0 el arreglo de datos $data ==== */
        foreach($establecimientos as $establecimiento) {
            $data3[$establecimiento->servicio_salud]['numerador'] = 0;
            $data3[$establecimiento->servicio_salud]['numerador_6'] = 0;
            $data3[$establecimiento->servicio_salud]['denominador'] = 0;
            $data3[$establecimiento->servicio_salud]['denominador_6'] = 0;
            $data3[$establecimiento->servicio_salud]['meta'] = 0;
            $data3[$establecimiento->servicio_salud]['cumplimiento'] = 0;
            $data3[$establecimiento->servicio_salud][$establecimiento->alias_estab]['numerador'] = 0;
            $data3[$establecimiento->servicio_salud][$establecimiento->alias_estab]['numerador_6'] = 0;
            $data3[$establecimiento->servicio_salud][$establecimiento->alias_estab]['denominador'] = 0;
            $data3[$establecimiento->servicio_salud][$establecimiento->alias_estab]['denominador_6'] = 0;
            $data3[$establecimiento->servicio_salud][$establecimiento->alias_estab]['meta'] = 0;
            $data3[$establecimiento->servicio_salud][$establecimiento->alias_estab]['cumplimiento'] = 0;
        }

        $data3['SERVICIO DE SALUD IQUIQUE']['meta'] = '≥90%';

        /* ===== Query numerador ===== */
        $sql_numerador =
            "SELECT e.servicio_salud, e.alias_estab, r.Mes, sum(ifnull(Col01,0)) as numerador
            FROM {$year}rems r
            LEFT JOIN establecimientos e ON r.IdEstablecimiento=e.Codigo
            WHERE
            e.meta_san_18834 = 1 AND Ano = $year AND (Mes = 6 OR Mes = 12) AND
            CodigoPrestacion IN ('P4190809','P4170300','P4190500','P4190600')
            GROUP by e.servicio_salud, e.alias_estab, r.Mes
            ORDER BY e.servicio_salud, e.alias_estab, r.Mes";

        $numeradores = DB::connection('mysql_rem')->select($sql_numerador);

        foreach($numeradores as $registro) {
            /*$data3[$registro->servicio_salud]['numerador'] += $registro->numerador;
            $data3[$registro->servicio_salud][$registro->alias_estab]['numerador'] = $registro->numerador;*/

            if($registro->Mes == 6) {
                $data3[$registro->servicio_salud]['numerador_6'] += $registro->numerador;
                $data3[$registro->servicio_salud][$registro->alias_estab]['numerador_6'] = $registro->numerador;
            }
            if($registro->Mes == 12){
                $data3[$registro->servicio_salud]['numerador'] += $registro->numerador;
                $data3[$registro->servicio_salud][$registro->alias_estab]['numerador'] = $registro->numerador;
            }
        }

        /* ===== Query denominador ===== */
        $sql_denominador =
            "SELECT e.servicio_salud, e.alias_estab, r.Mes, sum(ifnull(Col01,0)) as denominador
            FROM {$year}rems r
            LEFT JOIN establecimientos e ON r.IdEstablecimiento=e.Codigo
            WHERE
            e.meta_san_18834 = 1 AND Ano = $year AND (Mes = 6 OR Mes = 12) AND
            CodigoPrestacion IN ('P4150602')
            GROUP by e.servicio_salud, e.alias_estab, r.Mes
            ORDER BY e.servicio_salud, e.alias_estab, r.Mes";

        $denomidores = DB::connection('mysql_rem')->select($sql_denominador);

        foreach($denomidores as $registro) {
            /*$data3[$registro->servicio_salud]['denominador'] += $registro->denominador;
            $data3[$registro->servicio_salud][$registro->alias_estab]['denominador'] = $registro->denominador;*/

            if($registro->Mes == 6){
                $data3[$registro->servicio_salud]['denominador_6'] += $registro->denominador;
                $data3[$registro->servicio_salud][$registro->alias_estab]['denominador_6'] = $registro->denominador;
            }
            if($registro->Mes == 12){
                $data3[$registro->servicio_salud]['denominador'] += $registro->denominador;
                $data3[$registro->servicio_salud][$registro->alias_estab]['denominador'] = $registro->denominador;
            }
        }

        /* ==== Calculos ==== */
        foreach($data3 as $nombre_comuna => $comuna) {
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
                    if($data3[$nombre_comuna][$nombre_establecimiento]['denominador'] == 0) {
                        /* Si es 0 el denominadore entonces la meta es 0 */
                        $data3[$nombre_comuna][$nombre_establecimiento]['cumplimiento'] = 0;
                    }
                    else {
                        /* De lo contrario calcular el porcentaje */
                        $data3[$nombre_comuna][$nombre_establecimiento]['cumplimiento'] =
                            $data3[$nombre_comuna][$nombre_establecimiento]['numerador'] /
                            $data3[$nombre_comuna][$nombre_establecimiento]['denominador'] * 100;
                    }

                    /* Fija la meta de la comuna también a sus establecimientos */
                    $data3[$nombre_comuna][$nombre_establecimiento]['meta'] = $data3[$nombre_comuna]['meta'];

                    /* Calculo de las metas de la comuna */
                    if($data3[$nombre_comuna]['denominador'] == 0) {
                        /* Si es 0 el denominadore entonces la meta es 0 */
                        $data3[$nombre_comuna]['cumplimiento'] = 0;
                    }
                    else {
                        /* De lo contrario calcular el porcentaje */
                        $data3[$nombre_comuna]['cumplimiento'] =
                            $data3[$nombre_comuna]['numerador'] /
                            $data3[$nombre_comuna]['denominador'] * 100;
                    }
                }
            }
        }

        /* INDICADOR 1.4 */
        $label4['meta'] = '1.4 Oportunidad de Hopitalización para pacientes desde UEH.';
        $label4['numerador'] = 'Porcentaje de pacientes proveniente de la UEH,
            que se hospitalizan después de 12 horas desde la indicación, en el año t.';
        $label4['denominador'] = 'Total de pacientes ingresado a los servicios
            clinicos con indicacion de hospitalización en el año t.';

        $meses = array(1,2,3,4,5,6,7,8,9,10,11,12);
        $flag1 = NULL;
        $flag2 = NULL;
        $data4 = array();

        $sql_establecimientos ='SELECT servicio_salud, dependencia, alias_estab
                                FROM establecimientos
                                WHERE meta_san_18834 = 1
                                ORDER BY comuna';

        $establecimientos = DB::connection('mysql_rem')->select($sql_establecimientos);

        /* ==== Inicializar en 0 el arreglo de datos $data ==== */
        foreach($establecimientos as $establecimiento) {
            $data4[$establecimiento->servicio_salud]['numeradores']['total'] = 0;
            $data4[$establecimiento->servicio_salud]['denominadores']['total'] = 0;
            $data4[$establecimiento->servicio_salud]['cumplimiento'] = 0;
            foreach($meses as $mes) {
                $data4[$establecimiento->servicio_salud]['numeradores'][$mes] = 0;
                $data4[$establecimiento->servicio_salud]['denominadores'][$mes] = 0;
                $data4[$establecimiento->servicio_salud][$establecimiento->alias_estab]['numeradores']['total'] = 0;
                $data4[$establecimiento->servicio_salud][$establecimiento->alias_estab]['denominadores']['total'] = 0;
                $data4[$establecimiento->servicio_salud][$establecimiento->alias_estab]['numeradores'][$mes] = 0;
                $data4[$establecimiento->servicio_salud][$establecimiento->alias_estab]['denominadores'][$mes] = 0;
            }
            $data4[$establecimiento->servicio_salud][$establecimiento->alias_estab]['cumplimiento'] = 0;
        }

        $data4['SERVICIO DE SALUD IQUIQUE']['meta'] = 'Disminución > = 5% de pacientes con espera de hospitalización > a 12 horas';

        /* ===== Query numerador ===== */
        $sql_numerador = "SELECT e.servicio_salud, e.alias_estab, r.Mes, sum(ifnull(Col01,0)) as numerador
                        FROM {$year}rems r
                        LEFT JOIN establecimientos e
                        ON r.IdEstablecimiento=e.Codigo
                        WHERE e.meta_san_18834 = 1 AND Ano = $year AND
                        CodigoPrestacion IN (08222650,08222660)
                        GROUP by e.servicio_salud, e.alias_estab, r.Mes
                        ORDER BY e.servicio_salud, e.alias_estab, r.Mes";
        $numeradores = DB::connection('mysql_rem')->select($sql_numerador);

        foreach($numeradores as $registro) {
            if( ($flag1 != $registro->servicio_salud) OR ($flag2 != $registro->alias_estab) ) {
                foreach($meses as $mes) {
                    $data4[$registro->servicio_salud][$registro->alias_estab]['numeradores'][$mes] = 0;
                }
                $flag1 = $registro->servicio_salud;
                $flag2 = $registro->alias_estab;
            }
            $data4[$registro->servicio_salud][$registro->alias_estab]['numeradores'][$registro->Mes] = $registro->numerador;
        }

        /* ===== Query denominador ===== */
        $sql_denominador = "SELECT e.servicio_salud, e.alias_estab, r.Mes, sum(ifnull(Col01,0)) as denominador
                            FROM {$year}rems r
                            LEFT JOIN establecimientos e
                            ON r.IdEstablecimiento=e.Codigo
                            WHERE e.meta_san_18834 = 1 AND Ano = $year AND
                            CodigoPrestacion IN (08222640,08222650,08222660)
                            GROUP by e.servicio_salud, e.alias_estab, r.Mes
                            ORDER BY e.servicio_salud, e.alias_estab, r.Mes";
        $denominadores = DB::connection('mysql_rem')->select($sql_denominador);

        foreach($denominadores as $registro) {
            if( ($flag1 != $registro->servicio_salud) OR ($flag2 != $registro->alias_estab) ) {
                foreach($meses as $mes) {
                    $data4[$registro->servicio_salud][$registro->alias_estab]['denominadores'][$mes] = 0;
                }
                $flag1 = $registro->servicio_salud;
                $flag2 = $registro->alias_estab;
            }
            $data4[$registro->servicio_salud][$registro->alias_estab]['denominadores'][$registro->Mes] = $registro->denominador;
        }

        /* ==== Calculos ==== */
        foreach($data4 as $nombre_comuna => $comuna) {
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
                    $data4[$nombre_comuna][$nombre_establecimiento]['denominadores']['total'] =
                        array_sum($establecimiento['denominadores']);
                    $data4[$nombre_comuna][$nombre_establecimiento]['numeradores']['total'] =
                        array_sum($establecimiento['numeradores']);

                    /* Calcula los totales de cada comuna */
                    $data4[$nombre_comuna]['numeradores']['total'] += $data4[$nombre_comuna][$nombre_establecimiento]['numeradores']['total'];
                    $data4[$nombre_comuna]['denominadores']['total'] += $data4[$nombre_comuna][$nombre_establecimiento]['denominadores']['total'];

                    /* Calcula la suma mensual por comuna */
                    foreach($meses as $mes){
                        $data4[$nombre_comuna]['numeradores'][$mes] += $establecimiento['numeradores'][$mes];
                        $data4[$nombre_comuna]['denominadores'][$mes] += $establecimiento['denominadores'][$mes];
                    }

                    /* Calculo de las metas de cada establecimiento */
                    if($data4[$nombre_comuna][$nombre_establecimiento]['denominadores']['total'] == 0) {
                        /* Si es 0 el denominadore entonces el cumplimiento es 0 */
                        $data4[$nombre_comuna][$nombre_establecimiento]['cumplimiento'] = 0;
                    }
                    else {
                        /* De lo contrario calcular el porcentaje */
                        $data4[$nombre_comuna][$nombre_establecimiento]['cumplimiento'] =
                            $data4[$nombre_comuna][$nombre_establecimiento]['numeradores']['total'] /
                            $data4[$nombre_comuna][$nombre_establecimiento]['denominadores']['total'] * 100;
                    }

                    /* Calculo de las metas de la comuna */
                    if($data4[$nombre_comuna]['denominadores']['total'] == 0) {
                        /* Si es 0 el denominadore entonces el cumplimiento es 0 */
                        $data4[$nombre_comuna]['cumplimiento'] = 0;
                    }
                    else {
                        /* De lo contrario calcular el porcentaje */
                        $data4[$nombre_comuna]['cumplimiento'] =
                            $data4[$nombre_comuna]['numeradores']['total'] /
                            $data4[$nombre_comuna]['denominadores']['total'] * 100;
                    }
                }
            }
        }
        return view('indicators.19664.'.$year.'.servicio',
            compact('data1', 'label1', 'data2', 'label2', 'data3', 'label3', 'data4', 'label4'));
    }




    /***********************************/
    /*********** HOSPITAL **************/
    /***********************************/

    public function hospital(){
        $year = 2018;
        $label4['meta'] = '1.4 Oportunidad de Hopitalización para pacientes desde UEH.';
        $label4['numerador'] = 'Porcentaje de pacientes proveniente de la UEH,
            que se hospitalizan después de 12 horas desde la indicación, en el año t.';
        $label4['denominador'] = 'Total de pacientes ingresado a los servicios
            clinicos con indicacion de hospitalización en el año t.';

        $meses = array(1,2,3,4,5,6,7,8,9,10,11,12);
        $flag1 = NULL;
        $flag2 = NULL;
        $data4 = array();

        $sql_establecimientos ='SELECT servicio_salud, dependencia, alias_estab
                                FROM establecimientos
                                WHERE meta_san_18834_hosp = 1
                                ORDER BY comuna';

        $establecimientos = DB::connection('mysql_rem')->select($sql_establecimientos);

        /* ==== Inicializar en 0 el arreglo de datos $data ==== */
        foreach($establecimientos as $establecimiento) {
            $data4[$establecimiento->alias_estab]['numeradores']['total'] = 0;
            $data4[$establecimiento->alias_estab]['denominadores']['total'] = 0;
            $data4[$establecimiento->alias_estab]['cumplimiento'] = 0;
            foreach($meses as $mes) {
                $data4[$establecimiento->alias_estab]['numeradores'][$mes] = 0;
                $data4[$establecimiento->alias_estab]['denominadores'][$mes] = 0;
                $data4[$establecimiento->alias_estab][$establecimiento->alias_estab]['numeradores']['total'] = 0;
                $data4[$establecimiento->alias_estab][$establecimiento->alias_estab]['denominadores']['total'] = 0;
                $data4[$establecimiento->alias_estab][$establecimiento->alias_estab]['numeradores'][$mes] = 0;
                $data4[$establecimiento->alias_estab][$establecimiento->alias_estab]['denominadores'][$mes] = 0;
            }
            $data4[$establecimiento->alias_estab][$establecimiento->alias_estab]['cumplimiento'] = 0;
        }

        $data4['Hospital Dr. Ernesto Torres G.']['meta'] = 'Disminución > = 5% de pacientes con espera de hospitalización > a 12 horas';

        /* ===== Query numerador ===== */
        $sql_numerador = "SELECT e.servicio_salud, e.alias_estab, r.Mes, sum(ifnull(Col01,0)) as numerador
                        FROM {$year}rems r
                        LEFT JOIN establecimientos e
                        ON r.IdEstablecimiento=e.Codigo
                        WHERE e.meta_san_18834_hosp = 1 AND Ano = $year AND
                        CodigoPrestacion IN (08222650,08222660)
                        GROUP by e.servicio_salud, e.alias_estab, r.Mes
                        ORDER BY e.servicio_salud, e.alias_estab, r.Mes";
        $numeradores = DB::connection('mysql_rem')->select($sql_numerador);

        foreach($numeradores as $registro) {
            if( ($flag1 != $registro->alias_estab) OR ($flag2 != $registro->alias_estab) ) {
                foreach($meses as $mes) {
                    $data4[$registro->alias_estab][$registro->alias_estab]['numeradores'][$mes] = 0;
                }
                $flag1 = $registro->alias_estab;
                $flag2 = $registro->alias_estab;
            }
            $data4[$registro->alias_estab][$registro->alias_estab]['numeradores'][$registro->Mes] = $registro->numerador;
        }

        /* ===== Query denominador ===== */
        $sql_denominador = "SELECT e.servicio_salud, e.alias_estab, r.Mes, sum(ifnull(Col01,0)) as denominador
                            FROM {$year}rems r
                            LEFT JOIN establecimientos e
                            ON r.IdEstablecimiento=e.Codigo
                            WHERE e.meta_san_18834_hosp = 1 AND Ano = $year AND
                            CodigoPrestacion IN (08222640,08222650,08222660)
                            GROUP by e.servicio_salud, e.alias_estab, r.Mes
                            ORDER BY e.servicio_salud, e.alias_estab, r.Mes";
        $denominadores = DB::connection('mysql_rem')->select($sql_denominador);

        foreach($denominadores as $registro) {
            if( ($flag1 != $registro->alias_estab) OR ($flag2 != $registro->alias_estab) ) {
                foreach($meses as $mes) {
                    $data4[$registro->alias_estab][$registro->alias_estab]['denominadores'][$mes] = 0;
                }
                $flag1 = $registro->alias_estab;
                $flag2 = $registro->alias_estab;
            }
            $data4[$registro->alias_estab][$registro->alias_estab]['denominadores'][$registro->Mes] = $registro->denominador;
        }

        /* ==== Calculos ==== */
        foreach($data4 as $nombre_comuna => $comuna) {
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
                    $data4[$nombre_comuna][$nombre_establecimiento]['denominadores']['total'] =
                        array_sum($establecimiento['denominadores']);
                    $data4[$nombre_comuna][$nombre_establecimiento]['numeradores']['total'] =
                        array_sum($establecimiento['numeradores']);

                    /* Calcula los totales de cada comuna */
                    $data4[$nombre_comuna]['numeradores']['total'] +=
                        $data4[$nombre_comuna][$nombre_establecimiento]['numeradores']['total'];
                    $data4[$nombre_comuna]['denominadores']['total'] +=
                        $data4[$nombre_comuna][$nombre_establecimiento]['denominadores']['total'];

                    /* Calcula la suma mensual por comuna */
                    foreach($meses as $mes){
                        $data4[$nombre_comuna]['numeradores'][$mes] += $establecimiento['numeradores'][$mes];
                        $data4[$nombre_comuna]['denominadores'][$mes] += $establecimiento['denominadores'][$mes];
                    }

                    /* Calculo de las metas de cada establecimiento */
                    if($data4[$nombre_comuna][$nombre_establecimiento]['denominadores']['total'] == 0) {
                        /* Si es 0 el denominadore entonces el cumplimiento es 0 */
                        $data4[$nombre_comuna][$nombre_establecimiento]['cumplimiento'] = 0;
                    }
                    else {
                        /* De lo contrario calcular el porcentaje */
                        $data4[$nombre_comuna][$nombre_establecimiento]['cumplimiento'] =
                            $data4[$nombre_comuna][$nombre_establecimiento]['numeradores']['total'] /
                            $data4[$nombre_comuna][$nombre_establecimiento]['denominadores']['total'] * 100;
                    }

                    /* Calculo de las metas de la comuna */
                    if($data4[$nombre_comuna]['denominadores']['total'] == 0) {
                        /* Si es 0 el denominadore entonces el cumplimiento es 0 */
                        $data4[$nombre_comuna]['cumplimiento'] = 0;
                    }
                    else {
                        /* De lo contrario calcular el porcentaje */
                        $data4[$nombre_comuna]['cumplimiento'] =
                            $data4[$nombre_comuna]['numeradores']['total'] /
                            $data4[$nombre_comuna]['denominadores']['total'] * 100;
                    }
                }
            }
        }
        return view('indicators.19664.'.$year.'.hospital')->withData4($data4)->withLabel4($label4);
    }
}
