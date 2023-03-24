<?php

namespace App\Http\Controllers\Indicators\_2019;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\Indicators\SingleParameter;

class Indicator19664Controller extends Controller
{
    public function index()
    {
        include('19664/graphics.php');
        return view('indicators.19664.2019.index', compact('data111', 'data112', 'data113', 'data12', 'datab', 'datac', 'data3a', 'data3b',
                                                           'data12_hetg', 'data13_hetg', 'data14_hetg', 'dataa_hetg', 'datab_hetg', 'datac_hetg', 'datae_hetg', 'data3a_hetg', 'data3b_hetg',
                                                           'data111_reyno', 'data112_reyno', 'data113_reyno', 'data3a_reyno'));
    }

    /*************************************/
    /********* SERVICIO DE SALUD *********/
    /*************************************/
    public function servicio(){
        $year = 2019;
        $meses = array(1,2,3,4,5,6,7,8,9,10,11,12);

        $sql_ultimo_rem = "SELECT MAX(Mes) as ultimo_rem FROM 2019rems;";
        $ultimo_rem = DB::connection('mysql_rem')->select($sql_ultimo_rem)[0]->ultimo_rem;



        /* INDICADOR 1.1.1 */
        $data111['label']['meta'] = '1.1.1 Pacientes diabéticos compensados en
            el grupo de 15 años y más.';
        $data111['label']['numerador'] = 'N° de personas con DM2 de 15 A 79 años
            con Hemoglobina Glicosilada bajo 7%, según último control en los
            últimos 12 meses + N° de personas con DM2 de 80 años y más con
            Hemoglobina Glicosilada bajo 8% según último control vigente, en los
            últimos 12 meses.';
        $data111['label']['denominador'] = 'Total de pacientes diabéticos de 15
            años y más bajo control en el nivel primario * 100.';
        $data111['meta'] = '≥45%';
        $data111['ponderacion'] = '10%';

        /* ==== Inicializar el arreglo de datos $data ==== */
        $data111['numerador'] = '';
        $data111['numerador_6'] = '';
        $data111['numerador_12'] = '';
        $data111['denominador'] = '';
        $data111['denominador_6'] = '';
        $data111['denominador_12'] = '';

        $data111['cumplimiento'] = '';


        $sql_numerador = "SELECT r.Mes AS mes, SUM(COALESCE(Col01,0)) AS valor
                        FROM {$year}rems r
                        WHERE (Mes = 6 OR Mes = 12) AND IdEstablecimiento NOT IN (102100)
                        	AND CodigoPrestacion IN ('P4180300','P4200200')
                        GROUP BY r.Mes
                        ORDER BY r.Mes";
        $numeradores = DB::connection('mysql_rem')->select($sql_numerador);

        foreach($numeradores as $numerador) {
            switch($numerador->mes) {
                case 6:  $data111['numerador_6'] = $numerador->valor; break;
                case 12: $data111['numerador_12'] = $numerador->valor; break;
            }
        }

        $sql_denominador = "SELECT r.Mes AS mes, SUM(COALESCE(Col01,0)) AS valor
                            FROM {$year}rems r
                            WHERE (Mes = 6 OR Mes = 12) AND IdEstablecimiento NOT IN (102100)
                            	AND CodigoPrestacion IN ('P4150602')
                            GROUP BY r.Mes
                            ORDER BY r.Mes";
        $denominadores = DB::connection('mysql_rem')->select($sql_denominador);

        foreach($denominadores as $denominador) {
            switch($denominador->mes) {
                case 6:  $data111['denominador_6'] = $denominador->valor; break;
                case 12: $data111['denominador_12'] = $denominador->valor; break;
            }
        }

        switch($ultimo_rem){
            case 1:
            case 2:
            case 3:
            case 4:
            case 5:
                $data111['numerador'] = '';
                $data111['denominador'] = '';
                $data111['cumplimiento'] = '';
                break;
            case 6:
            case 7:
            case 8:
            case 9:
            case 10:
            case 11:
                if($data111['denominador_6'] AND $data111['denominador_6'] != 0) {
                    $data111['cumplimiento'] = number_format($data111['numerador_6'] / $data111['denominador_6'] * 100, 2, ',', '.');
                }
                else {
                    $data111['cumplimiento'] = 0;
                }
                $data111['numerador'] = $data111['numerador_6'] = number_format($data111['numerador_6'], 0, ',', '.');
                $data111['denominador'] = $data111['denominador_6'] = number_format($data111['denominador_6'], 0, ',', '.');
                break;
            case 12:
                if($data111['denominador_12'] AND $data111['denominador_12'] != 0) {
                    $data111['cumplimiento'] = number_format($data111['numerador_12'] / $data111['denominador_12'] * 100, 2, ',', '.');
                }
                else {
                    $data111['cumplimiento'] = 0;
                }
                $data111['numerador'] = $data111['numerador_12'] = number_format($data111['numerador_12'], 0, ',', '.');
                $data111['denominador'] = $data111['denominador_12'] = number_format($data111['denominador_12'], 0, ',', '.');
                break;
        }


        /**** INDICADOR 1.1.2 ****/
        $data112['label']['meta'] = '1.1.2 Evaluacion Anual de los Pies en
            personas con DM2 de 15 y más con diabetes bajo control.';
        $data112['label']['numerador'] = 'N° de personas con DM2 bajo control de
            15 y más años con una evaluación de pié viegente en el año t.';
        $data112['label']['denominador'] = 'N° total de pacientes diabéticos de
            15 años y más bajo controlen nivel primario. * 100.';
        $data112['meta'] = '≥90%';
        $data112['ponderacion'] = '10%';


        /* ==== Inicializar el arreglo de datos $data ==== */
        $data112['numerador'] = '';
        $data112['numerador_6'] = '';
        $data112['numerador_12'] = '';
        $data112['denominador'] = '';
        $data112['denominador_6'] = '';
        $data112['denominador_12'] = '';

        $data112['cumplimiento'] = '';


        $sql_numerador = "SELECT r.Mes AS mes, SUM(COALESCE(Col01,0)) AS valor
                        FROM {$year}rems r
                        WHERE (Mes = 6 OR Mes = 12) AND IdEstablecimiento NOT IN (102100)
                            AND CodigoPrestacion IN ('P4190809','P4170300','P4190500','P4190600')
                        GROUP BY r.Mes
                        ORDER BY r.Mes";
        $numeradores = DB::connection('mysql_rem')->select($sql_numerador);

        foreach($numeradores as $numerador) {
            switch($numerador->mes) {
                case 6:  $data112['numerador_6'] = $numerador->valor; break;
                case 12: $data112['numerador_12'] = $numerador->valor; break;
            }
        }

        $sql_denominador = "SELECT r.Mes AS mes, SUM(COALESCE(Col01,0)) AS valor
                            FROM {$year}rems r
                            WHERE (Mes = 6 OR Mes = 12) AND IdEstablecimiento NOT IN (102100)
                                AND CodigoPrestacion IN ('P4150602')
                            GROUP BY r.Mes
                            ORDER BY r.Mes";
        $denominadores = DB::connection('mysql_rem')->select($sql_denominador);

        foreach($denominadores as $denominador) {
            switch($denominador->mes) {
                case 6:  $data112['denominador_6'] = $denominador->valor; break;
                case 12: $data112['denominador_12'] = $denominador->valor; break;
            }
        }

        switch($ultimo_rem){
            case 1:
            case 2:
            case 3:
            case 4:
            case 5:
                $data112['numerador'] = '';
                $data112['denominador'] = '';
                $data112['cumplimiento'] = '';
                break;
            case 6:
            case 7:
            case 8:
            case 9:
            case 10:
            case 11:
                if($data112['denominador_6'] AND $data112['denominador_6'] != 0) {
                    $data112['cumplimiento'] = number_format($data112['numerador_6'] / $data112['denominador_6'] * 100, 2, ',', '.');
                }
                else {
                    $data112['cumplimiento'] = 0;
                }
                $data112['numerador'] = $data112['numerador_6'] = number_format($data112['numerador_6'], 0, ',', '.');
                $data112['denominador'] = $data112['denominador_6'] = number_format($data112['denominador_6'], 0, ',', '.');
                break;
            case 12:
                if($data112['denominador_12'] AND $data112['denominador_12'] != 0) {
                    $data112['cumplimiento'] = number_format($data112['numerador_12'] / $data112['denominador_12'] * 100, 2, ',', '.');
                }
                else {
                    $data112['cumplimiento'] = 0;
                }
                $data112['numerador'] = $data112['numerador_12'] = number_format($data112['numerador_12'], 0, ',', '.');
                $data112['denominador'] = $data112['denominador_12'] = number_format($data112['denominador_12'], 0, ',', '.');
                break;
        }




        /**** INDICADOR 1.1.3 ****/
        $data113['label']['meta'] = '1.1.3 Pacientes hipertensos compensados
            bajo control en el grupo de 15 años y más.';
        $data113['label']['numerador'] = 'N° personas con HTA de 15 a 79 años
            con presión arterial bajo 140/90 mmHg, según último control vigente
            en los últimos 12 meses + N° de personas con HTC de 80 y más años
            con presión arterial bajo 150/90 mmHg, según último control vigente,
            en los últimos 12 meses.';
        $data113['label']['denominador'] = 'N° total de pacientes hipertensos de
            15 años y más bajo control en el nivel primario * 100.';
        $data113['meta'] = '≥68%';
        $data113['ponderacion'] = '6.5%';

        /* ==== Inicializar el arreglo de datos $data ==== */
        $data113['numerador'] = '';
        $data113['numerador_6'] = '';
        $data113['numerador_12'] = '';
        $data113['denominador'] = '';
        $data113['denominador_6'] = '';
        $data113['denominador_12'] = '';

        $data113['cumplimiento'] = '';


        $sql_numerador = "SELECT r.Mes AS mes, SUM(COALESCE(Col01,0)) AS valor
                        FROM {$year}rems r
                        WHERE (Mes = 6 OR Mes = 12) AND IdEstablecimiento NOT IN (102100)
                            AND CodigoPrestacion IN ('P4180200','P4200100')
                        GROUP BY r.Mes
                        ORDER BY r.Mes";
        $numeradores = DB::connection('mysql_rem')->select($sql_numerador);

        foreach($numeradores as $numerador) {
            switch($numerador->mes) {
                case 6:  $data113['numerador_6'] = $numerador->valor; break;
                case 12: $data113['numerador_12'] = $numerador->valor; break;
            }
        }

        $sql_denominador = "SELECT r.Mes AS mes, SUM(COALESCE(Col01,0)) AS valor
                            FROM {$year}rems r
                            WHERE (Mes = 6 OR Mes = 12) AND IdEstablecimiento NOT IN (102100)
                                AND CodigoPrestacion IN ('P4150601')
                            GROUP BY r.Mes
                            ORDER BY r.Mes";
        $denominadores = DB::connection('mysql_rem')->select($sql_denominador);

        foreach($denominadores as $denominador) {
            switch($denominador->mes) {
                case 6:  $data113['denominador_6'] = $denominador->valor; break;
                case 12: $data113['denominador_12'] = $denominador->valor; break;
            }
        }

        switch($ultimo_rem){
            case 1:
            case 2:
            case 3:
            case 4:
            case 5:
                $data113['numerador'] = '';
                $data113['denominador'] = '';
                $data113['cumplimiento'] = '';
                break;
            case 6:
            case 7:
            case 8:
            case 9:
            case 10:
            case 11:
                if($data113['denominador_6'] AND $data113['denominador_6'] != 0) {
                    $data113['cumplimiento'] = number_format($data113['numerador_6'] / $data113['denominador_6'] * 100, 2, ',', '.');
                }
                else {
                    $data113['cumplimiento'] = 0;
                }
                $data113['numerador'] = $data113['numerador_6'] = number_format($data113['numerador_6'], 0, ',', '.');
                $data113['denominador'] = $data113['denominador_6'] = number_format($data113['denominador_6'], 0, ',', '.');
                break;
            case 12:
                if($data113['denominador_12'] AND $data113['denominador_12'] != 0) {
                    $data113['cumplimiento'] = number_format($data113['numerador_12'] / $data113['denominador_12'] * 100, 2, ',', '.');
                }
                else {
                    $data113['cumplimiento'] = 0;
                }
                $data113['numerador'] = $data113['numerador_12'] = number_format($data113['numerador_12'], 0, ',', '.');
                $data113['denominador'] = $data113['denominador_12'] = number_format($data113['denominador_12'], 0, ',', '.');
                break;
        }




        /**** INDICADOR 1.2 ****/
        $data12['label']['meta'] = '1.2 Porcentaje de Intervenciones Quirúrgicas
            Suspendidas.';
        $data12['label']['numerador'] = 'N° de intervenciones en especialidad
            quirúrgicas suspendidas en el establecimiento en el periodo.';
        $data12['label']['denominador'] = 'N° total de intervencines en
            especialidad quirúrgicas programadas en tabla en el periodo * 100.';
        $data12['meta'] = '<=7%';
        $data12['ponderacion'] = '7%';

        /* Inicializar los meses, si son menores al ultimo rem cargado */
        for($mes = 1; $mes <= 12; $mes ++) {
            if($mes <= $ultimo_rem) {
                $data12['numeradores'][$mes] = 0;
                $data12['denominadores'][$mes] = 0;
            }
            else {
                $data12['numeradores'][$mes] = '-';
                $data12['denominadores'][$mes] = '-';
            }
        }

        $data12['numerador_acumulado'] = 0;
        $data12['denominador_acumulado'] = 0;

        $sql_valores =
            "SELECT Mes AS mes,
                (SUM(ifnull(Col07,0)) + SUM(ifnull(Col08,0))) AS numerador,
                (SUM(ifnull(Col05,0)) + SUM(ifnull(Col06,0))) AS denominador
            FROM 2019prestaciones p
            LEFT JOIN 2019rems r
            ON p.codigo_prestacion = r.CodigoPrestacion
            WHERE Nserie = 'A21' AND IdEstablecimiento = 102100 AND r.Ano = 2019 AND
            codigo_prestacion IN
                (21500600, 21600800, 21600900, 21700100, 21500700, 21500800,
                21700300, 21700400, 21700500, 21700600, 21500900, 21700700)
            GROUP BY Mes";
        $valores = DB::connection('mysql_rem')->select($sql_valores);

        foreach($valores as $valor) {
            $data12['numeradores'][$valor->mes] = intval($valor->numerador);
            $data12['numerador_acumulado'] += intval($valor->numerador);
            $data12['denominadores'][$valor->mes] = intval($valor->denominador);
            $data12['denominador_acumulado'] += intval($valor->denominador);
        }

        /* Calcular el cumplimento */
        if($data12['denominador_acumulado'] != 0) {
            $data12['cumplimiento'] = round($data12['numerador_acumulado'] /
                                      $data12['denominador_acumulado'] * 100,1);
        }



        /**** INDICADOR 1.4 ****/
        $data14['label']['meta'] = '1.4 Variación procentual del número de días
            promedio de espera para intervenciones quirúrgicas, según línea base.';
        $data14['label']['numerador'] = '1. Para Calculo de Meta de Reducción,
            según Tabla N°1 (No ingresar en plataforma DIPRES):
            ((Promedio de días de espera de las intervenciones quirúrgicas
            electivas del año t-1 del establecimiento) - (promedio de días de
            espera de las intervenciones quirúrgicas electivas del año t-1 nacional)';
        $data14['label']['denominador'] = '(promedio de días de espera de las
            intervenciones quirúrgicas electivas del año t-1 nacional)) *100';
        $data14['meta'] = 'disminución 8% respecto de línea base.';
        $data14['meta_nacional'] = '34';
        $data14['ponderacion'] = '7%';

        $base_where = array(['law','19664'],['year',$year],['indicator',14],['establishment_id',9]);

        for($i = 1; $i <= 12; $i++) {
            $where = array_merge($base_where,array(['month',$i],['position','numerador']));
            $value = SingleParameter::where($where)->first();
            if($value) $data14['numeradores'][$i] = $value->value;
            else       $data14['numeradores'][$i] = null;

            $where = array_merge($base_where,array(['month',$i],['position','denominador']));
            $value = SingleParameter::where($where)->first();
            if($value) $data14['denominadores'][$i] = $value->value;
            else       $data14['denominadores'][$i] = null;
        }

        /* 'mensual','semestral','anual','acumulada' */
        $where = array_merge($base_where,array(['type','acumulada'],['position','numerador']));
        $value = SingleParameter::where($where)->first();

        if($value) {
            $data14['numerador_acumulado']   = $value->value;
        }
        else {
            $data14['numerador_acumulado']   = array_sum($data14['numeradores']);
        }

        /* 'mensual','semestral','anual','acumulada' */
        $where = array_merge($base_where,array(['type','acumulada'],['position','denominador']));
        $value = SingleParameter::where($where)->first();

        if($value) {
            $data14['denominador_acumulado']   = $value->value;
        }
        else {
            $data14['denominador_acumulado'] = array_sum($data14['denominadores']);
        }


        if($data14['denominador_acumulado'] != 0) {
            $data14['cumplimiento'] = number_format(
                $data14['numerador_acumulado'] / $data14['denominador_acumulado'] * 100,2, ',', '.');
        }
        else $data14['cumplimiento'] = 0;



        /**** INDICADOR b ****/
        $datab['label']['meta'] = 'b. Porcentaje de cumplimento de la
            programación anual de consulta médicas realizadas por especialista.';
        $datab['label']['numerador'] = 'N° de consultas epecialista realizadas
            durante el periodo.';
        $datab['label']['denominador'] = 'N° total de consultas de especialistas
            programadas y validadas para igual periodo * 100.';
        $datab['meta'] = '≥95%';
        $datab['ponderacion'] = '7%';

        $datab['numerador_acumulado'] = 0;
        $datab['denominador_acumulado'] = 112193;

        /* Inicializar los meses, si son menores al ultimo rem cargado */
        for($mes = 1; $mes <= 12; $mes ++) {
            if($mes <= $ultimo_rem) {
                //$datab['denominadores'][$mes] = 9335;
                $datab['numeradores'][$mes] = 0;
                //$datab['denominador_acumulado'] += $datab['denominadores'][$mes];
            }
            else {
                $datab['numeradores'][$mes] = '-';
                $datab['denominadores'][$mes] = '-';
            }
        }

        //$datab['numerador_acumulado'] = 0;
        //$datab['denominador_acumulado'] = 37340;

        $sql_numeradores =
        "SELECT Mes AS mes, floor(SUM(ifnull(Col01,0))) AS numerador
        FROM 2019prestaciones p
        LEFT JOIN 2019rems r
        ON p.codigo_prestacion = r.CodigoPrestacion
        WHERE Nserie = 'A07' AND IdEstablecimiento = 102100 AND r.Ano = 2019 AND
        codigo_prestacion IN
            (7020130, 7020230, 7020330, 7020331, 7020332, 7024219, 7020500,
            7020501, 7020600, 7020601, 7020700, 7020800, 7020801, 7020900,
            7020901, 7021000, 7021001, 7021100, 7021101, 7021230, 7021300,
            7021301, 7022000, 7022001, 7021531, 7022132, 7022133, 7022134,
            7021700, 7021800, 7021801, 7021900, 7022130, 7022142, 7022143,
            7022144, 7022135, 7022136, 7022137, 7022700, 7022800, 7022900,
            7021701, 7023100, 7023200, 7023201, 7023202, 7023203, 7023700,
            7023701, 7023702, 7023703, 7024000, 7024001, 7024200, 7030500,
            7024201, 7024202, 7030501, 7030502)
        GROUP BY Mes;";

        $valores = DB::connection('mysql_rem')->select($sql_numeradores);

        foreach($valores as $valor) {
            $datab['numeradores'][$valor->mes] = intval($valor->numerador);
            $datab['numerador_acumulado'] += intval($valor->numerador);
        }

        /* Calcular el cumplimento */
        if($datab['denominador_acumulado'] != 0) {
            $datab['cumplimiento'] = round($datab['numerador_acumulado'] /
                                      $datab['denominador_acumulado'] * 100,1);
        }
        else {
            $datab['cumplimiento'] = 0;
        }




        /**** INDICADOR c ****/
        $datac['label']['meta'] = 'c. Porcentaje de Cumplimiento de la
            Programación anual de Consultas Médicas realizadas en modalidad
            Telemedicina.';
        $datac['label']['numerador'] = 'N° total de consultas médicas de
            espcialidad realizadas a través de telemedicina, durante el periodo.';
        $datac['label']['denominador'] = 'N° total de consultas de especialista
            programadas y validadas para igual perido * 100.';
        $datac['meta'] = '≥95%';
        $datac['ponderacion'] = '6%';

        /* Inicializar los meses, si son menores al ultimo rem cargado */
        for($mes = 1; $mes <= 12; $mes ++) {
            if($mes <= $ultimo_rem) {
                $datac['numeradores'][$mes] = 0;
                //$datac['denominadores'][$mes] = 0;
            }
            else {
                $datac['numeradores'][$mes] = '-';
                //$datac['denominadores'][$mes] = '-';
            }
        }

        $datac['numerador_acumulado'] = 0;
        $datac['denominador_acumulado'] = 50;

        $sql_numeradores =
        "SELECT Mes AS mes, FLOOR(
            SUM(ifnull(Col09,0)) +
            SUM(ifnull(Col10,0)) +
            SUM(ifnull(Col11,0)) +
            SUM(ifnull(Col12,0))
        ) AS numerador
        FROM 2019prestaciones p
        LEFT JOIN 2019rems r
        ON p.codigo_prestacion = r.CodigoPrestacion
        WHERE Nserie = 'A30' AND IdEstablecimiento = 102100 AND r.Ano = 2019 AND
        codigo_prestacion IN (
            30000000, 30000001, 30000002, 30000003, 30000004, 30000005, 30000006,
            30000007, 30000008, 30000009, 30000010, 30000011, 30000012, 30000013,
            30000014, 30000015, 30000016, 30000017, 30000018, 30000019, 30000020,
            30000021, 30000022, 30000023, 30000024, 30000025, 30000026, 30000027,
            30000028, 30000029, 30000030, 30000031, 30000032, 30000033, 30000034,
            30000035, 30000036, 30000037, 30000038, 30000039, 30000040, 30000041,
            30000042, 30000043, 30000044, 30000045, 30000046, 30000047, 30000048,
            30000049, 30000050, 30000051, 30000052, 30000053, 30000054, 30000086,
            30000055, 30000056, 30000087, 30000088
        )
        GROUP BY Mes;
        ";

        $valores = DB::connection('mysql_rem')->select($sql_numeradores);

        foreach($valores as $valor) {
            $datac['numeradores'][$valor->mes] = intval($valor->numerador);
            $datac['numerador_acumulado'] += intval($valor->numerador);
        }

        /* Calcular el cumplimento */
        if($datac['denominador_acumulado'] != 0) {
            $datac['cumplimiento'] = round($datac['numerador_acumulado'] /
                                      $datac['denominador_acumulado'] * 100,1);
        }
        else $datac['cumplimiento'] = 0;




        /**** INDICADOR d ****/
        $datad['label']['meta'] = 'd. Variación porcentual de pacientes que
            esperan más de 12 horas en la Unidad de Emeergencia Hospitalaria
            UEH para ceder a una cama de dotación.';
        $datad['label']['numerador'] = '% de pacientes provenientes desde la UEH,
            que se hospitalizan después de 12 horas desde la indicación, en el año t.';
        $datad['label']['denominador'] = '% de pacientes provenientes de la UEH, que
            se hospitalizan después de las 12 horas desde la indicación en el
            año t-2 * 100.';

        $datad['meta'] = '>=5% de reducción';
        $datad['ponderacion'] = '27%';
        $datad['cumplimiento'] = 0;
        $datad['numerador'] = 0;
        $datad['numerador_acumulado'] = 0;
        $datad['numerador_acumulado_2'] = 0;
        $datad['denominador_acumulado'] = 5;

        /* ===== denominador ===== */
        /* Primero los denominadores porque los uso para calcular el numerador */
        /*$datad['denominadores'] =  [1=>2.5, 2=>4.2, 3=>2.0,  4=>2.1,  5=>1.6,  6=>1.0,
                         7=>2.4, 8=>2.7, 9=>1.4, 10=>1.3, 11=>1.4, 12=>2.7];*/

        /* ==== Inicializar en 0 el arreglo de datos $data ====
        for($mes = 1; $mes <= 12; $mes ++) {
            if($mes <= $ultimo_rem) {
                $datad['numeradores'][$mes] = 0;
                //$datad['denominadores'][$mes] = 0;
            }
            else {
                $datad['numeradores'][$mes] = '-';
                $datad['denominadores'][$mes] = '-';
            }
        }*/

        /* ==== Inicializar en 0 el arreglo de datos $data ==== */
        foreach($meses as $mes) {
            $datad['numeradores'][$mes] = 0;
            $datad['numeradores_2'][$mes] = 0;
            $datad['denominadores'][$mes] = 0;
        }

        /* ===== Query numerador ===== */
        $sql_numerador = "SELECT e.servicio_salud, e.alias_estab, r.Mes, sum(ifnull(Col01,0)) as numerador
            FROM {$year}rems r
            LEFT JOIN establecimientos e
            ON r.IdEstablecimiento=e.Codigo
            WHERE CodigoPrestacion IN (08222640,08222650,08222660,08221600,08222670,08222680,'08230500A')
            AND e.meta_san_18834_hosp = 1
            GROUP BY e.servicio_salud, e.alias_estab, r.Mes
            ORDER BY e.servicio_salud, e.alias_estab, r.Mes";
        $numeradores_totales = DB::connection('mysql_rem')->select($sql_numerador);

        foreach($numeradores_totales as $registro) {
            $tmp[$registro->Mes]['totales'] = $registro->numerador;
        }

        $sql_numerador = "SELECT e.servicio_salud, e.alias_estab, r.Mes, sum(ifnull(Col01,0)) as numerador
            FROM {$year}rems r
            LEFT JOIN establecimientos e
            ON r.IdEstablecimiento=e.Codigo
            WHERE CodigoPrestacion IN (08222650,08222660)
            AND e.meta_san_18834_hosp = 1
            GROUP BY e.servicio_salud, e.alias_estab, r.Mes
            ORDER BY e.servicio_salud, e.alias_estab, r.Mes";
        $numeradores = DB::connection('mysql_rem')->select($sql_numerador);

        foreach($numeradores as $registro) {
            $tmp[$registro->Mes]['numerador'] = $registro->numerador;
        }

        foreach($tmp as $key => $mes){
            /*$tmp[$key]['porcentaje'] = $mes['numerador'] * 100 / $mes['totales'];
            $datad['numeradores'][$key] = round($datad['denominadores'][$key] - $tmp[$key]['porcentaje'],1);
            $datad['numerador_acumulado'] += $datad['numeradores'][$key];
            $datad['denominador_acumulado'] += $datad['denominadores'][$key];*/

            $datad['numeradores_2'][$key] += $mes['numerador'];
            $datad['numeradores'][$key] += $mes['totales'];
            $datad['numerador_acumulado'] += $datad['numeradores'][$key];
            $datad['numerador_acumulado_2'] += $datad['numeradores_2'][$key];
        }

        /* ==== Calculos ==== */
        if($datad['denominador_acumulado'] == 0) {
            /* Si es 0 el denominador entonces el cumplimiento es 0 */
            $datad['cumplimiento'] = 0;
        }
        else {
            /* De lo contrario calcular el porcentaje */
            $datad['cumplimiento'] =
                round($datad['numerador_acumulado'] /
                $datad['denominador_acumulado'],1);

            $datad['numerador'] = $datad['numerador_acumulado_2'] / $datad['numerador_acumulado'] * 100;
            $datad['cumplimiento'] = round($datad['numerador'],1) / $datad['denominador_acumulado'] * 100;
        }





        /**** INDICADOR 3.a ****/
        $data3a['label']['meta'] = '3.a Porcentaje de Gestión Efectiva para el
            Cumplimiento GES en la Red.';
        $data3a['label']['numerador'] = 'Garantías Cumplidas + Garantías
            Exceptuadas + Garantías Incumplidas Atendidas';
        $data3a['label']['denominador'] = '(Garantías Cumplidas + Garantías
            Exceptuadas + Garantías Incumplidas Atendidas ´Garantías Incumplidas
            no Atendidas + Garantías Retrsadas) * 100.';
        $data3a['meta'] = '100%';
        $data3a['ponderacion'] = '7%';

        $base_where = array(['law','19664'],['year',$year],['indicator',31],['establishment_id',9]);

        for($i = 1; $i <= 12; $i++) {
            $where = array_merge($base_where,array(['month',$i],['position','numerador']));
            $value = SingleParameter::where($where)->first();
            if($value) $data3a['numeradores'][$i] = $value->value;
            else       $data3a['numeradores'][$i] = null;

            $where = array_merge($base_where,array(['month',$i],['position','denominador']));
            $value = SingleParameter::where($where)->first();
            if($value) $data3a['denominadores'][$i] = $value->value;
            else       $data3a['denominadores'][$i] = null;
        }

        $data3a['numerador_acumulado']   = array_sum($data3a['numeradores']);
        $data3a['denominador_acumulado'] = array_sum($data3a['denominadores']);

        if($data3a['denominador_acumulado'] != 0) {
            $data3a['cumplimiento'] = number_format(
                $data3a['numerador_acumulado'] / $data3a['denominador_acumulado'] * 100,2, ',', '.');
        }
        else $data3a['cumplimiento'] = 0;



        /**** INDICADOR 3.b ****/
        $data3b['label']['meta'] = '3.b Porcentaje de intervenciones sanitarias
            GES otrogadas según lo programado en contrato PPV para el año t.';
        $data3b['label']['numerador'] = 'Número de intervencines sanitarias GES
            de contrato PPV otrogadas dentro del año t.';
        $data3b['label']['denominador'] = 'Total de Intervenciones sanitarias
            GES programadas en el contrato PPV para el año t * 100.';
        $data3b['meta'] = '100%';
        $data3b['ponderacion'] = '12.5%';

        $base_where = array(['law','19664'],['year',$year],['indicator',32],
                            ['establishment_id',9],['position','numerador']);


        $value = SingleParameter::where($base_where)->first();

        if($value) {
            $data3b['numerador_acumulado'] = $value->value;
            $data3b['vigencia'] = $value->month;
        }
        else {
            $data3b['numerador_acumulado'] = null;
            $data3b['vigencia'] = 1;
        }

        $base_where = array(['law','19664'],['year',$year],['indicator',32],
                            ['establishment_id',9],['position','denominador']);

        $value = SingleParameter::where($base_where)->first();

        if($value) $data3b['denominador_acumulado'] = $value->value;
        else       $data3b['denominador_acumulado'] = null;



        if($data3b['denominador_acumulado'] != 0) {
            $data3b['cumplimiento'] = number_format(
                $data3b['numerador_acumulado'] / $data3b['denominador_acumulado'] * 100,2, ',', '.');
        }
        else $data3b['cumplimiento'] = 0;




        return view('indicators.19664.'.$year.'.servicio',
            compact('data111', 'data112', 'data113', 'data12', 'data14', 'datab', 'datac', 'datad', 'data3a', 'data3b'));
    }




    /***********************************/
    /*********** HOSPITAL **************/
    /***********************************/
    public function hospital(){
        $meses = array(1,2,3,4,5,6,7,8,9,10,11,12);
        $year = 2019;

        $sql_ultimo_rem = "SELECT MAX(Mes) as ultimo_rem FROM 2019rems;";
        $ultimo_rem = DB::connection('mysql_rem')->select($sql_ultimo_rem)[0]->ultimo_rem;


        /**** INDICADOR 1.2 ****/
        $data12['label']['meta'] = '1.2 Porcentaje de Intervenciones Quirúrgicas
            Suspendidas.';
        $data12['label']['numerador'] = 'N° de intervenciones en especialidad
            quirúrgicas suspendidas en el establecimiento en el periodo.';
        $data12['label']['denominador'] = 'N° total de intervencines en
            especialidad quirúrgicas programadas en tabla en el periodo * 100.';
        $data12['meta'] = '<=7%';
        $data12['ponderacion'] = '7%';

        /* Inicializar los meses, si son menores al ultimo rem cargado */
        for($mes = 1; $mes <= 12; $mes ++) {
            if($mes <= $ultimo_rem) {
                $data12['numeradores'][$mes] = 0;
                $data12['denominadores'][$mes] = 0;
            }
            else {
                $data12['numeradores'][$mes] = '-';
                $data12['denominadores'][$mes] = '-';
            }
        }

        $data12['numerador_acumulado'] = 0;
        $data12['denominador_acumulado'] = 0;

        $sql_valores =
            "SELECT Mes AS mes,
            	(SUM(ifnull(Col07,0)) + SUM(ifnull(Col08,0))) AS numerador,
            	(SUM(ifnull(Col05,0)) + SUM(ifnull(Col06,0))) AS denominador
            FROM 2019prestaciones p
            LEFT JOIN 2019rems r
            ON p.codigo_prestacion = r.CodigoPrestacion
            WHERE Nserie = 'A21' AND IdEstablecimiento = 102100 AND r.Ano = 2019 AND
            codigo_prestacion IN
                (21500600, 21600800, 21600900, 21700100, 21500700, 21500800,
                21700300, 21700400, 21700500, 21700600, 21500900, 21700700)
            GROUP BY Mes";
        $valores = DB::connection('mysql_rem')->select($sql_valores);

        foreach($valores as $valor) {
            $data12['numeradores'][$valor->mes] = intval($valor->numerador);
            $data12['numerador_acumulado'] += intval($valor->numerador);
            $data12['denominadores'][$valor->mes] = intval($valor->denominador);
            $data12['denominador_acumulado'] += intval($valor->denominador);
        }

        /* Calcular el cumplimento */
        if($data12['denominador_acumulado'] != 0) {
            $data12['cumplimiento'] = round($data12['numerador_acumulado'] /
                                      $data12['denominador_acumulado'] * 100,1);
        }



        /**** INDICADOR 1.3 ****/
        $data13['label']['meta'] = '1.3 Porcentaje de ambulatorización de
            cirugías mayores en el año t.';
        $data13['label']['numerador'] = 'N° de egreos de CMA.';
        $data13['label']['denominador'] = '(N° e Egresos de CMA + Número de
            Egresos totales no ambulatorios) * 100.';
        $data13['meta'] = '≥42%';
        $data13['ponderacion'] = '7%';

        $base_where = array(['law','19664'],['year',$year],['indicator',13],['establishment_id',1]);

        for($i = 1; $i <= 12; $i++) {
            $where = array_merge($base_where,array(['month',$i],['position','numerador']));
            $value = SingleParameter::where($where)->first();
            if($value) $data13['numeradores'][$i] = $value->value;
            else       $data13['numeradores'][$i] = null;

            $where = array_merge($base_where,array(['month',$i],['position','denominador']));
            $value = SingleParameter::where($where)->first();
            if($value) $data13['denominadores'][$i] = $value->value;
            else       $data13['denominadores'][$i] = null;
        }

        $data13['numerador_acumulado']   = array_sum($data13['numeradores']);
        $data13['denominador_acumulado'] = array_sum($data13['denominadores']);

        if($data13['denominador_acumulado'] != 0) {
            $data13['cumplimiento'] = number_format(
                $data13['numerador_acumulado'] / $data13['denominador_acumulado'] * 100,2, ',', '.');
        }
        else $data13['cumplimiento'] = 0;





        /**** INDICADOR 1.4 ****/
        $data14['label']['meta'] = '1.4 Variación procentual del número de días
            promedio de espera para intervenciones quirúrgicas, según línea base.';
        $data14['label']['numerador'] = '1. Para Calculo de Meta de Reducción,
            según Tabla N°1 (No ingresar en plataforma DIPRES):
            ((Promedio de días de espera de las intervenciones quirúrgicas
            electivas del año t-1 del establecimiento) - (promedio de días de
            espera de las intervenciones quirúrgicas electivas del año t-1 nacional)';
        $data14['label']['denominador'] = '(promedio de días de espera de las
            intervenciones quirúrgicas electivas del año t-1 nacional)) *100';
        $data14['meta'] = '100%';
        $data14['meta_nacional'] = '34';
        $data14['ponderacion'] = '7%';


        $base_where = array(['law','19664'],['year',$year],['indicator',14],['establishment_id',1]);

        for($i = 1; $i <= 12; $i++) {
            $where = array_merge($base_where,array(['month',$i],['position','numerador']));
            $value = SingleParameter::where($where)->first();
            if($value) $data14['numeradores'][$i] = $value->value;
            else       $data14['numeradores'][$i] = null;

            $where = array_merge($base_where,array(['month',$i],['position','denominador']));
            $value = SingleParameter::where($where)->first();
            if($value) $data14['denominadores'][$i] = $value->value;
            else       $data14['denominadores'][$i] = null;
        }

        /* 'mensual','semestral','anual','acumulada' */
        $where = array_merge($base_where,array(['type','acumulada'],['position','numerador']));
        $value = SingleParameter::where($where)->first();

        if($value) {
            $data14['numerador_acumulado']   = $value->value;
        }
        else {
            $data14['numerador_acumulado']   = array_sum($data14['numeradores']);
        }

        /* 'mensual','semestral','anual','acumulada' */
        $where = array_merge($base_where,array(['type','acumulada'],['position','denominador']));
        $value = SingleParameter::where($where)->first();

        if($value) {
            $data14['denominador_acumulado']   = $value->value;
        }
        else {
            $data14['denominador_acumulado'] = array_sum($data14['denominadores']);
        }


        if($data14['denominador_acumulado'] != 0) {
            $data14['cumplimiento'] = number_format(
                $data14['numerador_acumulado'] / $data14['denominador_acumulado'] * 100,2, ',', '.');
        }
        else $data14['cumplimiento'] = 0;



        /**** INDICADOR a ****/
        $dataa['label']['meta'] = 'a. Porcentaje de altas Odonotlógicas de
            especialidades del nivel secundario por ingreso de tratamiento.';
        $dataa['label']['numerador'] = 'N° de altas de tratamiento odonológico
            de especialidades del periodo.';
        $dataa['label']['denominador'] = 'N° de ingresos a tratamiento
            odonológico de especialidades del periodo * 100.';
        $dataa['meta'] = '≥60%';
        $dataa['ponderacion'] = '6%';

        /* Inicializar los meses, si son menores al ultimo rem cargado */
        for($mes = 1; $mes <= 12; $mes ++) {
            if($mes <= $ultimo_rem) {
                $dataa['numeradores'][$mes] = 0;
                $dataa['denominadores'][$mes] = 0;
            }
            else {
                $dataa['numeradores'][$mes] = '-';
                $dataa['denominadores'][$mes] = '-';
            }
        }

        $dataa['numerador_acumulado'] = 0;
        $dataa['denominador_acumulado'] = 0;

        $sql_numeradores =
            "SELECT Mes AS mes, floor(SUM(ifnull(Col01,0))) AS numerador
            FROM 2019prestaciones p
            LEFT JOIN 2019rems r
            ON p.codigo_prestacion = r.CodigoPrestacion
            WHERE Nserie = 'A09' AND IdEstablecimiento = 102100 AND r.Ano = 2019 AND
            codigo_prestacion IN
                (09216213, 09204954, 09216613, 09217013, 09217513, 09218013,
                09218413, 09218913, 09219313, 09309050, 09309250, 09240600)
            GROUP BY Mes";
        $valores = DB::connection('mysql_rem')->select($sql_numeradores);

        foreach($valores as $valor) {
            $dataa['numeradores'][$valor->mes] = intval($valor->numerador);
            $dataa['numerador_acumulado'] += intval($valor->numerador);
        }

        $sql_denominadores =
            "SELECT Mes AS mes, floor(SUM(ifnull(Col01,0))) AS denominador
            FROM 2019prestaciones p
            LEFT JOIN 2019rems r
            ON p.codigo_prestacion = r.CodigoPrestacion
            WHERE Nserie = 'A09' AND IdEstablecimiento = 102100 AND r.Ano = 2019 AND
            codigo_prestacion IN
                (09216113, 09204953, 09216513, 09216913, 09217413, 09217913,
                 09218313, 09218813, 09219213, 09309000, 09309200, 09240500)
            GROUP BY Mes";
        $valores = DB::connection('mysql_rem')->select($sql_denominadores);


        foreach($valores as $valor) {
            $dataa['denominadores'][$valor->mes] = intval($valor->denominador);
            $dataa['denominador_acumulado'] += intval($valor->denominador);
        }

        /* Calcular el cumplimento */
        if($dataa['denominador_acumulado'] != 0) {
            $dataa['cumplimiento'] = round($dataa['numerador_acumulado'] /
                                      $dataa['denominador_acumulado'] * 100,1);
        }
        else {
            $dataa['cumplimiento'] = 0;
        }






        /**** INDICADOR b ****/
        $datab['label']['meta'] = 'b. Porcentaje de cumplimento de la
            programación anual de consulta médicas realizadas por especialista.';
        $datab['label']['numerador'] = 'N° de consultas epecialista realizadas
            durante el periodo.';
        $datab['label']['denominador'] = 'N° total de consultas de especialistas
            programadas y validadas para igual periodo * 100.';
        $datab['meta'] = '≤95%';
        $datab['ponderacion'] = '7%';

        $datab['numerador_acumulado'] = 0;
        $datab['denominador_acumulado'] = 112193;

        /* Inicializar los meses, si son menores al ultimo rem cargado */
        for($mes = 1; $mes <= 12; $mes ++) {
            if($mes <= $ultimo_rem) {
                //$datab['denominadores'][$mes] = 9335;
                $datab['numeradores'][$mes] = 0;
                //$datab['denominador_acumulado'] += $datab['denominadores'][$mes];
            }
            else {
                $datab['numeradores'][$mes] = '-';
                $datab['denominadores'][$mes] = '-';
            }
        }



        $sql_numeradores =
        "SELECT Mes AS mes, floor(SUM(ifnull(Col01,0))) AS numerador
        FROM 2019prestaciones p
        LEFT JOIN 2019rems r
        ON p.codigo_prestacion = r.CodigoPrestacion
        WHERE Nserie = 'A07' AND IdEstablecimiento = 102100 AND r.Ano = 2019 AND
        codigo_prestacion IN
            (7020130, 7020230, 7020330, 7020331, 7020332, 7024219, 7020500,
            7020501, 7020600, 7020601, 7020700, 7020800, 7020801, 7020900,
            7020901, 7021000, 7021001, 7021100, 7021101, 7021230, 7021300,
            7021301, 7022000, 7022001, 7021531, 7022132, 7022133, 7022134,
            7021700, 7021800, 7021801, 7021900, 7022130, 7022142, 7022143,
            7022144, 7022135, 7022136, 7022137, 7022700, 7022800, 7022900,
            7021701, 7023100, 7023200, 7023201, 7023202, 7023203, 7023700,
            7023701, 7023702, 7023703, 7024000, 7024001, 7024200, 7030500,
            7024201, 7024202, 7030501, 7030502)
        GROUP BY Mes;";

        $valores = DB::connection('mysql_rem')->select($sql_numeradores);

        foreach($valores as $valor) {
            $datab['numeradores'][$valor->mes] = intval($valor->numerador);
            $datab['numerador_acumulado'] += intval($valor->numerador);
        }

        /* Calcular el cumplimento */
        if($datab['denominador_acumulado'] != 0) {
            $datab['cumplimiento'] = round($datab['numerador_acumulado'] /
                                      $datab['denominador_acumulado'] * 100,1);
        }
        else {
            $datab['cumplimiento'] = 0;
        }






        /**** INDICADOR c ****/
        $datac['label']['meta'] = 'c. Porcentaje de Cumplimiento de la
            Programación anual de Consultas Médicas realizadas en modalidad
            Telemedicina.';
        $datac['label']['numerador'] = 'N° total de consultas médicas de
            espcialidad realizadas a través de telemedicina, durante el periodo.';
        $datac['label']['denominador'] = 'N° total de consultas de especialista
            programadas y validadas para igual perido * 100.';
        $datac['meta'] = '≤95%';
        $datac['ponderacion'] = '6%';

        /* Inicializar los meses, si son menores al ultimo rem cargado */
        for($mes = 1; $mes <= 12; $mes ++) {
            if($mes <= $ultimo_rem) {
                $datac['numeradores'][$mes] = 0;
                //$datac['denominadores'][$mes] = 0;
            }
            else {
                $datac['numeradores'][$mes] = '-';
                //$datac['denominadores'][$mes] = '-';
            }
        }

        $datac['numerador_acumulado'] = 0;
        /* pasrlo a SingleParameter */
        $datac['denominador_acumulado'] = 50;

        $sql_numeradores =
        "SELECT Mes AS mes, FLOOR(
        	SUM(ifnull(Col09,0)) +
        	SUM(ifnull(Col10,0)) +
        	SUM(ifnull(Col11,0)) +
        	SUM(ifnull(Col12,0))
        ) AS numerador
        FROM 2019prestaciones p
        LEFT JOIN 2019rems r
        ON p.codigo_prestacion = r.CodigoPrestacion
        WHERE Nserie = 'A30' AND IdEstablecimiento = 102100 AND r.Ano = 2019 AND
        codigo_prestacion IN (
            30000000, 30000001, 30000002, 30000003, 30000004, 30000005, 30000006,
            30000007, 30000008, 30000009, 30000010, 30000011, 30000012, 30000013,
            30000014, 30000015, 30000016, 30000017, 30000018, 30000019, 30000020,
            30000021, 30000022, 30000023, 30000024, 30000025, 30000026, 30000027,
            30000028, 30000029, 30000030, 30000031, 30000032, 30000033, 30000034,
            30000035, 30000036, 30000037, 30000038, 30000039, 30000040, 30000041,
            30000042, 30000043, 30000044, 30000045, 30000046, 30000047, 30000048,
            30000049, 30000050, 30000051, 30000052, 30000053, 30000054, 30000086,
            30000055, 30000056, 30000087, 30000088
        )
        GROUP BY Mes;
        ";

        $valores = DB::connection('mysql_rem')->select($sql_numeradores);

        foreach($valores as $valor) {
            $datac['numeradores'][$valor->mes] = intval($valor->numerador);
            $datac['numerador_acumulado'] += intval($valor->numerador);
        }

        /* Calcular el cumplimento */
        if($datac['denominador_acumulado'] != 0) {
            $datac['cumplimiento'] = round($datac['numerador_acumulado'] /
                                      $datac['denominador_acumulado'] * 100,1);
        }
        else $datac['cumplimiento'] = 0;




        /**** INDICADOR d ****/
        $datad['label']['meta'] = 'd. Variación porcentual de pacientes que
            esperan más de 12 horas en la Unidad de Emergencia Hospitalaria (UEH)
            para acceder a una cama de dotación.';
        $datad['label']['numerador'] = '% de pacientes provenientes desde la UEH,
                que se hospitalizan después de 12 horas desde la indicación,
                en el año t.';
        $datad['label']['denominador'] = '% de pacientes provenientes de la UEH, que
            se hospitalizan después de las 12 horas desde la indicación en el
            año t-2 * 100.';

        $datad['meta'] = '>=5% de reducción';
        $datad['ponderacion'] = '27%';
        $datad['cumplimiento'] = 0;
        $datad['numerador_acumulado'] = 0;
        $datad['numerador_acumulado_2'] = 0;
        $datad['denominador_acumulado'] = 5;

        /* ===== denominador ===== */
        /* Primero los denominadores porque los uso para calcular el numerador
        $datad['denominadores'] =  [1=>2.5, 2=>4.2, 3=>2.0,  4=>2.1,  5=>1.6,  6=>1.0,
                         7=>2.4, 8=>2.7, 9=>1.4, 10=>1.3, 11=>1.4, 12=>2.7];*/

        /* ==== Inicializar en 0 el arreglo de datos $data ====
        for($mes = 1; $mes <= 12; $mes ++) {
            if($mes <= $ultimo_rem) {
                $datad['numeradores'][$mes] = 0;
                //$datad['denominadores'][$mes] = 0;
            }
            else {
                $datad['numeradores'][$mes] = '-';
                $datad['denominadores'][$mes] = '-';
            }
        }*/
        foreach($meses as $mes) {
            $datad['numeradores'][$mes] = 0;
            $datad['numeradores_2'][$mes] = 0;
            $datad['denominadores'][$mes] = 0;
        }

        /* ===== Query numerador ===== */
        $sql_numerador = "SELECT e.servicio_salud, e.alias_estab, r.Mes, sum(ifnull(Col01,0)) as numerador
            FROM {$year}rems r
            LEFT JOIN establecimientos e
            ON r.IdEstablecimiento=e.Codigo
            WHERE CodigoPrestacion IN (08222640,08222650,08222660,08221600,08222670,08222680,'08230500A')
			AND e.meta_san_18834_hosp = 1
			GROUP BY e.servicio_salud, e.alias_estab, r.Mes
            ORDER BY e.servicio_salud, e.alias_estab, r.Mes";
        $numeradores_totales = DB::connection('mysql_rem')->select($sql_numerador);

        foreach($numeradores_totales as $registro) {
            $tmp[$registro->Mes]['totales'] = $registro->numerador;
        }

        $sql_numerador = "SELECT e.servicio_salud, e.alias_estab, r.Mes, sum(ifnull(Col01,0)) as numerador
            FROM {$year}rems r
            LEFT JOIN establecimientos e
            ON r.IdEstablecimiento=e.Codigo
            WHERE CodigoPrestacion IN (08222650,08222660)
			AND e.meta_san_18834_hosp = 1
			GROUP BY e.servicio_salud, e.alias_estab, r.Mes
            ORDER BY e.servicio_salud, e.alias_estab, r.Mes";
        $numeradores = DB::connection('mysql_rem')->select($sql_numerador);

        foreach($numeradores as $registro) {
            $tmp[$registro->Mes]['numerador'] = $registro->numerador;
        }

        foreach($tmp as $key => $mes){
            /*$tmp[$key]['porcentaje'] = $mes['numerador'] * 100 / $mes['totales'];
            $datad['numeradores'][$key] = round($datad['denominadores'][$key] - $tmp[$key]['porcentaje'],1);
            $datad['numerador_acumulado'] += $datad['numeradores'][$key];
            $datad['denominador_acumulado'] += $datad['denominadores'][$key];*/

            $datad['numeradores_2'][$key] += $mes['numerador'];
            $datad['numeradores'][$key] += $mes['totales'];
            $datad['numerador_acumulado'] += $datad['numeradores'][$key];
            $datad['numerador_acumulado_2'] += $datad['numeradores_2'][$key];
        }

        /* ==== Calculos ==== */
        if($datad['denominador_acumulado'] == 0) {
            /* Si es 0 el denominador entonces el cumplimiento es 0 */
            $datad['cumplimiento'] = 0;
        }
        else {
            /* De lo contrario calcular el porcentaje
            $datad['cumplimiento'] =
                round($datad['numerador_acumulado'] /
                $datad['denominador_acumulado'],1);*/
                $datad['numerador'] = $datad['numerador_acumulado_2'] / $datad['numerador_acumulado'] * 100;

                $datad['cumplimiento'] = round($datad['numerador'],1) / $datad['denominador_acumulado'] * 100;
        }





        /**** INDICADOR e ****/
        $datae['label']['meta'] = 'e. Promedio de días de estadía de pacientes
            derivados vía UUCC a prestadores privados fuera de convenio.';
        $datae['label']['numerador'] = 'N° de días de hospitalización de
            pacientes derivados vía UGCC en el extrasistema.';
        $datae['label']['denominador'] = 'N° total de pacientes derivados vía
            UGCC al extrasistema.';
        $datae['meta'] = '<=10%';
        $datae['ponderacion'] = '6%';

        $base_where = array(['law','19664'],['year',$year],['indicator',25],['establishment_id',1]);

        for($i = 1; $i <= 12; $i++) {
            $where = array_merge($base_where,array(['month',$i],['position','numerador']));
            $value = SingleParameter::where($where)->first();
            if($value) $datae['numeradores'][$i] = $value->value;
            else       $datae['numeradores'][$i] = null;

            $where = array_merge($base_where,array(['month',$i],['position','denominador']));
            $value = SingleParameter::where($where)->first();
            if($value) $datae['denominadores'][$i] = $value->value;
            else       $datae['denominadores'][$i] = null;
        }

        $datae['numerador_acumulado']   = array_sum($datae['numeradores']);
        $datae['denominador_acumulado'] = array_sum($datae['denominadores']);

        if($datae['denominador_acumulado'] != 0) {
            $datae['cumplimiento'] = number_format(
                $datae['numerador_acumulado'] / $datae['denominador_acumulado'] * 100,2, ',', '.');
        }
        elseif($datae['denominador_acumulado'] == 0 && $datae['numerador_acumulado'] == 0) {
            $datae['cumplimiento'] = 100;
        }
        else $datae['cumplimiento'] = 0;



        /**** INDICADOR 3.a ****/
        $data3a['label']['meta'] = '3.a Porcentaje de Gestión Efectiva para el
            Cumplimiento GES en la Red.';
        $data3a['label']['numerador'] = 'Garantías Cumplidas + Garantías
            Exceptuadas + Garantías Incumplidas Atendidas';
        $data3a['label']['denominador'] = '(Garantías Cumplidas + Garantías
            Exceptuadas + Garantías Incumplidas Atendidas ´Garantías Incumplidas
            no Atendidas + Garantías Retrsadas) * 100.';
        $data3a['meta'] = '100%';
        $data3a['ponderacion'] = '7%';

        $base_where = array(['law','19664'],['year',$year],['indicator',31],['establishment_id',1]);

        for($i = 1; $i <= 12; $i++) {
            $where = array_merge($base_where,array(['month',$i],['position','numerador']));
            $value = SingleParameter::where($where)->first();
            if($value) $data3a['numeradores'][$i] = $value->value;
            else       $data3a['numeradores'][$i] = null;

            $where = array_merge($base_where,array(['month',$i],['position','denominador']));
            $value = SingleParameter::where($where)->first();
            if($value) $data3a['denominadores'][$i] = $value->value;
            else       $data3a['denominadores'][$i] = null;
        }

        $data3a['numerador_acumulado']   = array_sum($data3a['numeradores']);
        $data3a['denominador_acumulado'] = array_sum($data3a['denominadores']);

        if($data3a['denominador_acumulado'] != 0) {
            $data3a['cumplimiento'] = number_format(
                $data3a['numerador_acumulado'] / $data3a['denominador_acumulado'] * 100,2, ',', '.');
        }
        else $data3a['cumplimiento'] = 0;



        /**** INDICADOR 3.b ****/
        $data3b['label']['meta'] = '3.b Porcentaje de intervenciones sanitarias
            GES otrogadas según lo programado en contrato PPV para el año t.';
        $data3b['label']['numerador'] = 'Número de intervencines sanitarias GES
            de contrato PPV otrogadas dentro del año t.';
        $data3b['label']['denominador'] = 'Total de Intervenciones sanitarias
            GES programadas en el contrato PPV para el año t * 100.';
        $data3b['meta'] = '100%';
        $data3b['ponderacion'] = '20%';

        $base_where = array(['law','19664'],['year',$year],['indicator',32],
                            ['establishment_id',1],['position','numerador']);


        $value = SingleParameter::where($base_where)->first();

        if($value) {
            $data3b['numerador_acumulado'] = $value->value;
            $data3b['vigencia'] = $value->month;
        }
        else {
            $data3b['numerador_acumulado'] = null;
            $data3b['vigencia'] = 1;
        }

        $base_where = array(['law','19664'],['year',$year],['indicator',32],
                            ['establishment_id',1],['position','denominador']);

        $value = SingleParameter::where($base_where)->first();

        if($value) $data3b['denominador_acumulado'] = $value->value;
        else       $data3b['denominador_acumulado'] = null;



        if($data3b['denominador_acumulado'] != 0) {
            $data3b['cumplimiento'] = number_format(
                $data3b['numerador_acumulado'] / $data3b['denominador_acumulado'] * 100,2, ',', '.');
        }
        else $data3b['cumplimiento'] = 0;





        return view('indicators.19664.'.$year.'.hospital',
            compact('data12','data13','data14','dataa','datab','datac','datad','datae','data3a','data3b', 'ultimo_rem'));
    }






    /*********************************/
    /*********** REYNO  **************/
    /*********************************/
    public function reyno(){
        $year = 2019;

        $sql_ultimo_rem = "SELECT MAX(Mes) as ultimo_rem FROM 2019rems;";
        $ultimo_rem = DB::connection('mysql_rem')->select($sql_ultimo_rem)[0]->ultimo_rem;

        /* INDICADOR 1.1.1 */
        $data111['label']['meta'] = '1.1.1 Pacientes diabéticos compensados en
            el grupo de 15 años y más.';
        $data111['label']['numerador'] = 'N° de personas con DM2 de 15 A 79 años
            con Hemoglobina Glicosilada bajo 7%, según último control en los
            últimos 12 meses + N° de personas con DM2 de 80 años y más con
            Hemoglobina Glicosilada bajo 8% según último control vigente, en los
            últimos 12 meses.';
        $data111['label']['denominador'] = 'Total de pacientes diabéticos de 15
            años y más bajo control en el nivel primario * 100.';
        $data111['meta'] = '≥45%';
        $data111['ponderacion'] = '25%';


        /* ==== Inicializar el arreglo de datos $data ==== */
        $data111['numerador'] = '';
        $data111['numerador_6'] = '';
        $data111['numerador_12'] = '';
        $data111['denominador'] = '';
        $data111['denominador_6'] = '';
        $data111['denominador_12'] = '';

        $data111['cumplimiento'] = '';


        $sql_numerador = "SELECT r.Mes AS mes, SUM(COALESCE(Col01,0)) AS valor
                        FROM {$year}rems r
                        JOIN {$year}establecimientos e ON e.Codigo=r.IdEstablecimiento
                        WHERE meta_san_18834 = 1
                            AND e.Codigo = 102307
                        	AND (Mes = 6 OR Mes = 12)
                        	AND CodigoPrestacion IN ('P4180300','P4200200')
                        GROUP BY r.Mes
                        ORDER BY r.Mes";
        $numeradores = DB::connection('mysql_rem')->select($sql_numerador);

        foreach($numeradores as $numerador) {
            switch($numerador->mes) {
                case 6:  $data111['numerador_6'] = $numerador->valor; break;
                case 12: $data111['numerador_12'] = $numerador->valor; break;
            }
        }

        $sql_denominador = "SELECT r.Mes AS mes, SUM(COALESCE(Col01,0)) AS valor
                            FROM {$year}rems r
                            JOIN {$year}establecimientos e ON e.Codigo=r.IdEstablecimiento
                            WHERE meta_san_18834 = 1
                                AND e.Codigo = 102307
                            	AND (Mes = 6 OR Mes = 12)
                            	AND CodigoPrestacion IN ('P4150602')
                            GROUP BY r.Mes
                            ORDER BY r.Mes";
        $denominadores = DB::connection('mysql_rem')->select($sql_denominador);

        foreach($denominadores as $denominador) {
            switch($denominador->mes) {
                case 6:  $data111['denominador_6'] = $denominador->valor; break;
                case 12: $data111['denominador_12'] = $denominador->valor; break;
            }
        }

        switch($ultimo_rem){
            case 1:
            case 2:
            case 3:
            case 4:
            case 5:
                $data111['numerador'] = '';
                $data111['denominador'] = '';
                $data111['cumplimiento'] = '';
                break;
            case 6:
            case 7:
            case 8:
            case 9:
            case 10:
            case 11:
                if($data111['denominador_6'] AND $data111['denominador_6'] != 0) {
                    $data111['cumplimiento'] = number_format($data111['numerador_6'] / $data111['denominador_6'] * 100, 2, ',', '.');
                }
                else {
                    $data111['cumplimiento'] = 0;
                }
                $data111['numerador'] = $data111['numerador_6'] = number_format($data111['numerador_6'], 0, ',', '.');
                $data111['denominador'] = $data111['denominador_6'] = number_format($data111['denominador_6'], 0, ',', '.');
                break;
            case 12:
                if($data111['denominador_12'] AND $data111['denominador_12'] != 0) {
                    $data111['cumplimiento'] = number_format($data111['numerador_12'] / $data111['denominador_12'] * 100, 2, ',', '.');
                }
                else {
                    $data111['cumplimiento'] = 0;
                }
                $data111['numerador'] = $data111['numerador_12'] = number_format($data111['numerador_12'], 0, ',', '.');
                $data111['denominador'] = $data111['denominador_12'] = number_format($data111['denominador_12'], 0, ',', '.');
                break;
        }

        /**** INDICADOR 1.1.2 ****/
        $data112['label']['meta'] = '1.1.2 Evaluacion Anual de los Pies en
            personas con DM2 de 15 y más con diabetes bajo control.';
        $data112['label']['numerador'] = 'N° de personas con DM2 bajo control de
            15 y más años con una evaluación de pié viegente en el año t.';
        $data112['label']['denominador'] = 'N° total de pacientes diabéticos de
            15 años y más bajo controlen nivel primario. * 100.';
        $data112['meta'] = '≥90%';
        $data112['ponderacion'] = '15%';

        /* ==== Inicializar el arreglo de datos $data ==== */
        $data112['numerador'] = '';
        $data112['numerador_6'] = '';
        $data112['numerador_12'] = '';
        $data112['denominador'] = '';
        $data112['denominador_6'] = '';
        $data112['denominador_12'] = '';

        $data112['cumplimiento'] = '';


        $sql_numerador = "SELECT r.Mes AS mes, SUM(COALESCE(Col01,0)) AS valor
                        FROM {$year}rems r
                        JOIN {$year}establecimientos e ON e.Codigo=r.IdEstablecimiento
                        WHERE meta_san_18834 = 1
                            AND e.Codigo = 102307
                            AND (Mes = 6 OR Mes = 12)
                            AND CodigoPrestacion IN ('P4190809','P4170300','P4190500','P4190600')
                        GROUP BY r.Mes
                        ORDER BY r.Mes";
        $numeradores = DB::connection('mysql_rem')->select($sql_numerador);

        foreach($numeradores as $numerador) {
            switch($numerador->mes) {
                case 6:  $data112['numerador_6'] = $numerador->valor; break;
                case 12: $data112['numerador_12'] = $numerador->valor; break;
            }
        }

        $sql_denominador = "SELECT r.Mes AS mes, SUM(COALESCE(Col01,0)) AS valor
                            FROM {$year}rems r
                            JOIN {$year}establecimientos e ON e.Codigo=r.IdEstablecimiento
                            WHERE meta_san_18834 = 1
                                AND e.Codigo = 102307
                                AND (Mes = 6 OR Mes = 12)
                                AND CodigoPrestacion IN ('P4150602')
                            GROUP BY r.Mes
                            ORDER BY r.Mes";
        $denominadores = DB::connection('mysql_rem')->select($sql_denominador);

        foreach($denominadores as $denominador) {
            switch($denominador->mes) {
                case 6:  $data112['denominador_6'] = $denominador->valor; break;
                case 12: $data112['denominador_12'] = $denominador->valor; break;
            }
        }

        switch($ultimo_rem){
            case 1:
            case 2:
            case 3:
            case 4:
            case 5:
                $data112['numerador'] = '';
                $data112['denominador'] = '';
                $data112['cumplimiento'] = '';
                break;
            case 6:
            case 7:
            case 8:
            case 9:
            case 10:
            case 11:
                if($data112['denominador_6'] AND $data112['denominador_6'] != 0) {
                    $data112['cumplimiento'] = number_format($data112['numerador_6'] / $data112['denominador_6'] * 100, 2, ',', '.');
                }
                else {
                    $data112['cumplimiento'] = 0;
                }
                $data112['numerador'] = $data112['numerador_6'] = number_format($data112['numerador_6'], 0, ',', '.');
                $data112['denominador'] = $data112['denominador_6'] = number_format($data112['denominador_6'], 0, ',', '.');
                break;
            case 12:
                if($data112['denominador_12'] AND $data112['denominador_12'] != 0) {
                    $data112['cumplimiento'] = number_format($data112['numerador_12'] / $data112['denominador_12'] * 100, 2, ',', '.');
                }
                else {
                    $data112['cumplimiento'] = 0;
                }
                $data112['numerador'] = $data112['numerador_12'] = number_format($data112['numerador_12'], 0, ',', '.');
                $data112['denominador'] = $data112['denominador_12'] = number_format($data112['denominador_12'], 0, ',', '.');
                break;
        }




        /**** INDICADOR 1.1.3 ****/
        $data113['label']['meta'] = '1.1.3 Pacientes hipertensos compensados
            bajo control en el grupo de 15 años y más.';
        $data113['label']['numerador'] = 'N° personas con HTA de 15 a 79 años
            con presión arterial bajo 140/90 mmHg, según último control vigente
            en los últimos 12 meses + N° de personas con HTC de 80 y más años
            con presión arterial bajo 150/90 mmHg, según último control vigente,
            en los últimos 12 meses.';
        $data113['label']['denominador'] = 'N° total de pacientes hipertensos de
            15 años y más bajo control en el nivel primario * 100.';
        $data113['meta'] = '≥68%';
        $data113['ponderacion'] = '10%';

        /* ==== Inicializar el arreglo de datos $data ==== */
        $data113['numerador'] = '';
        $data113['numerador_6'] = '';
        $data113['numerador_12'] = '';
        $data113['denominador'] = '';
        $data113['denominador_6'] = '';
        $data113['denominador_12'] = '';

        $data113['cumplimiento'] = '';


        $sql_numerador = "SELECT r.Mes AS mes, SUM(COALESCE(Col01,0)) AS valor
                        FROM {$year}rems r
                        JOIN {$year}establecimientos e ON e.Codigo=r.IdEstablecimiento
                        WHERE meta_san_18834 = 1
                            AND e.Codigo = 102307
                            AND (Mes = 6 OR Mes = 12)
                            AND CodigoPrestacion IN ('P4180200','P4200100')
                        GROUP BY r.Mes
                        ORDER BY r.Mes";
        $numeradores = DB::connection('mysql_rem')->select($sql_numerador);

        foreach($numeradores as $numerador) {
            switch($numerador->mes) {
                case 6:  $data113['numerador_6'] = $numerador->valor; break;
                case 12: $data113['numerador_12'] = $numerador->valor; break;
            }
        }

        $sql_denominador = "SELECT r.Mes AS mes, SUM(COALESCE(Col01,0)) AS valor
                            FROM {$year}rems r
                            JOIN {$year}establecimientos e ON e.Codigo=r.IdEstablecimiento
                            WHERE meta_san_18834 = 1
                                AND e.Codigo = 102307
                                AND (Mes = 6 OR Mes = 12)
                                AND CodigoPrestacion IN ('P4150601')
                            GROUP BY r.Mes
                            ORDER BY r.Mes";
        $denominadores = DB::connection('mysql_rem')->select($sql_denominador);

        foreach($denominadores as $denominador) {
            switch($denominador->mes) {
                case 6:  $data113['denominador_6'] = $denominador->valor; break;
                case 12: $data113['denominador_12'] = $denominador->valor; break;
            }
        }

        switch($ultimo_rem){
            case 1:
            case 2:
            case 3:
            case 4:
            case 5:
                $data113['numerador'] = '';
                $data113['denominador'] = '';
                $data113['cumplimiento'] = '';
                break;
            case 6:
            case 7:
            case 8:
            case 9:
            case 10:
            case 11:
                if($data113['denominador_6'] AND $data113['denominador_6'] != 0) {
                    $data113['cumplimiento'] = number_format($data113['numerador_6'] / $data113['denominador_6'] * 100, 2, ',', '.');
                }
                else {
                    $data113['cumplimiento'] = 0;
                }
                $data113['numerador'] = $data113['numerador_6'] = number_format($data113['numerador_6'], 0, ',', '.');
                $data113['denominador'] = $data113['denominador_6'] = number_format($data113['denominador_6'], 0, ',', '.');
                break;
            case 12:
                if($data113['denominador_12'] AND $data113['denominador_12'] != 0) {
                    $data113['cumplimiento'] = number_format($data113['numerador_12'] / $data113['denominador_12'] * 100, 2, ',', '.');
                }
                else {
                    $data113['cumplimiento'] = 0;
                }
                $data113['numerador'] = $data113['numerador_12'] = number_format($data113['numerador_12'], 0, ',', '.');
                $data113['denominador'] = $data113['denominador_12'] = number_format($data113['denominador_12'], 0, ',', '.');
                break;
        }


        $data3a['label']['meta'] = '3.a Porcentaje de Gestión Efectiva para el
            Cumplimiento GES en la Red.';
        $data3a['label']['numerador'] = 'Garantías Cumplidas + Garantías
            Exceptuadas + Garantías Incumplidas Atendidas';
        $data3a['label']['denominador'] = '(Garantías Cumplidas + Garantías
            Exceptuadas + Garantías Incumplidas Atendidas ´Garantías Incumplidas
            no Atendidas + Garantías Retrsadas) * 100.';
        $data3a['meta'] = '100%';
        $data3a['ponderacion'] = '50%';

        $base_where = array(['law','19664'],['year',$year],['indicator',31],['establishment_id',12]);

        for($i = 1; $i <= 12; $i++) {
            $where = array_merge($base_where,array(['month',$i],['position','numerador']));
            $value = SingleParameter::where($where)->first();
            if($value) $data3a['numeradores'][$i] = $value->value;
            else       $data3a['numeradores'][$i] = null;

            $where = array_merge($base_where,array(['month',$i],['position','denominador']));
            $value = SingleParameter::where($where)->first();
            if($value) $data3a['denominadores'][$i] = $value->value;
            else       $data3a['denominadores'][$i] = null;
        }

        $data3a['numerador_acumulado']   = array_sum($data3a['numeradores']);
        $data3a['denominador_acumulado'] = array_sum($data3a['denominadores']);

        if($data3a['denominador_acumulado'] != 0) {
            $data3a['cumplimiento'] = number_format(
                $data3a['numerador_acumulado'] / $data3a['denominador_acumulado'] * 100,2, ',', '.');
        }
        else $data3a['cumplimiento'] = 0;

        return view('indicators.19664.'.$year.'.reyno',
            compact('data111', 'data112', 'data113', 'data3a'));
    }
}
