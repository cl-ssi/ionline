<?php
namespace App\Http\Controllers\Indicators\IAAPS\_2019;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class IAAPSController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('indicators.iaaps.2019.index');
    }



    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Indicators\IAAPS\IAAPS  $iAAPS
     * @return \Illuminate\Http\Response
     * public function show(IAAPS $iAAPS)
     */
    public function show($comuna)
    {
        $sql_ultimo_rem = "SELECT MAX(Mes) as ultimo_rem FROM 2019rems;";
        $ultimo_rem = DB::connection('mysql_rem')->select($sql_ultimo_rem)[0]->ultimo_rem;
        $mes = 12;

        switch ($comuna) {
            case 'iquique':
                $nombre_comuna = 'Iquique';
                $cod_establecimientos = array(102300,102301,102302,102306,102412,102413,102701);
                $comunal['data3']['meta'] = 1.2;
                $comunal['data4']['meta'] = 93.70;
                $comunal['data5']['meta'] = 0.39;
                $comunal['data6']['meta'] = 23.54;
                $comunal['data61']['meta'] = 48.86;
                $comunal['data7']['meta'] = 99.95;
                $comunal['data8']['meta'] = 18.05;
                $comunal['data9']['meta'] = 28.57;
                $comunal['data10']['meta'] = 22.00;
                $comunal['data13']['meta'] = 90.00;
                $comunal['data14']['meta'] = 20.00;
                $comunal['data15']['meta'] = 32.70;
                $comunal['data16']['meta'] = 54.00;
                $comunal['data17']['meta'] = 59.03;
                $comunal['data18']['meta'] = 46.94;
                break;
            case 'alto_hospicio':
                $nombre_comuna = 'Alto Hospicio';
                $cod_establecimientos = array(102305,200557,102705,200335);
                $comunal['data3']['meta'] = 0.9;
                $comunal['data4']['meta'] = 92.81;
                $comunal['data5']['meta'] = 0.27;
                $comunal['data6']['meta'] = 19.99;
                $comunal['data61']['meta'] = 40.02;
                $comunal['data7']['meta'] = 99.64;
                $comunal['data8']['meta'] = 16.28;
                $comunal['data9']['meta'] = 24.86;
                $comunal['data10']['meta'] = 15.01;
                $comunal['data13']['meta'] = 91.50;
                $comunal['data14']['meta'] = 18.80;
                $comunal['data15']['meta'] = 16.01;
                $comunal['data16']['meta'] = 23.00;
                $comunal['data17']['meta'] = 64.97;
                $comunal['data18']['meta'] = 35.71;
                break;
            case 'pica':
                $nombre_comuna = 'Pica';
                $cod_establecimientos = array(102304,102416,102411);
                $comunal['data3']['meta'] = 1.22;
                $comunal['data4']['meta'] = 92.76;
                $comunal['data5']['meta'] = 0.47;
                $comunal['data6']['meta'] = 21.02;
                $comunal['data61']['meta'] = 55.71;
                $comunal['data7']['meta'] = 100;
                $comunal['data8']['meta'] = 34.23;
                $comunal['data9']['meta'] = 37.31;
                $comunal['data10']['meta'] = 21.72;
                $comunal['data13']['meta'] = 89.74;
                $comunal['data14']['meta'] = 31.82;
                $comunal['data15']['meta'] = 34.99;
                $comunal['data16']['meta'] = 54.04;
                $comunal['data17']['meta'] = 79.88;
                $comunal['data18']['meta'] = 67.03;
                break;
            case 'pozo_almonte':
                $nombre_comuna = 'Pozo Almonte';
                $cod_establecimientos = array(102303,102403,102406,102414);
                $comunal['data3']['meta'] = 1.20;
                $comunal['data4']['meta'] = 90.00;
                $comunal['data5']['meta'] = 0.22;
                $comunal['data6']['meta'] = 22.00;
                $comunal['data61']['meta'] = 51.01;
                $comunal['data7']['meta'] = 95.00;
                $comunal['data8']['meta'] = 18.05;
                $comunal['data9']['meta'] = 17.49;
                $comunal['data10']['meta'] = 17.01;
                $comunal['data13']['meta'] = 87.39;
                $comunal['data14']['meta'] = 22.69;
                $comunal['data15']['meta'] = 23.03;
                $comunal['data16']['meta'] = 40.01;
                $comunal['data17']['meta'] = 50.79;
                $comunal['data18']['meta'] = 43.30;
                break;
        }


        /***********************************/
        /**********  INDICADOR 3 ***********/
        /***********************************/

        $comunal['data3']['label']['indicador'] =
            'Tasa de consultas de morbilidad y de controles médicos, por habitante año.';
        $comunal['data3']['label']['numerador'] =
            'N° de consultas de morbilidad y controles realizadas por médicos';
        $comunal['data3']['label']['denominador'] = 'Población inscrita';


        /* Inicializar valores */

        $comunal['data3']['denominador_acumulado'] = 0;
        $comunal['data3']['numerador_acumulado'] = 0;
        for($i = 1; $i <= $ultimo_rem; $i++) {
            $comunal['data3']['numeradores'][$i] = 0;
        }
        $comunal['data3']['avance'] = 0;

        foreach($cod_establecimientos as $cod_estab){
            switch ($cod_estab) {
                case 102300:
                    $establecimientos[$cod_estab]['nombre'] =
                        'Centro De Salud Familiar Cirujano Aguirre'; break;
                case 102301:
                    $establecimientos[$cod_estab]['nombre'] =
                        'Centro De Salud Familiar Cirujano Videla'; break;
                case 102302:
                    $establecimientos[$cod_estab]['nombre'] =
                        'Centro De Salud Familiar Cirujano Guzmán'; break;
                case 102306:
                    $establecimientos[$cod_estab]['nombre'] =
                        'Centro De Salud Familiar Sur De Iquique'; break;
                case 102412:
                    $establecimientos[$cod_estab]['nombre'] =
                        'Posta De Salud Rural Chanavayita'; break;
                case 102413:
                    $establecimientos[$cod_estab]['nombre'] =
                        'Posta De Salud Rural San Marcos'; break;
                case 102701:
                    $establecimientos[$cod_estab]['nombre'] =
                        'Centro Comunitario De Salud Familiar Cerro Esmeralda'; break;


                case 102305:
                    $establecimientos[$cod_estab]['nombre'] =
                        'CESFAM Pedro Pulgar Melgarejo'; break;
                case 200557:
                    $establecimientos[$cod_estab]['nombre'] =
                        'CESFAM Yandry Añazco'; break;
                case 102705:
                    $establecimientos[$cod_estab]['nombre'] =
                        'Centro Comunitario de Salud Familiar El Boro'; break;
                case 200335:
                    $establecimientos[$cod_estab]['nombre'] =
                        'Centro Comunitario de Salud Familiar La Tortuga'; break;

                case 102304:
                    $establecimientos[$cod_estab]['nombre'] =
                        'CESFAM PICA'; break;
                case 102416:
                    $establecimientos[$cod_estab]['nombre'] =
                        'Posta Matilla'; break;
                case 102411:
                    $establecimientos[$cod_estab]['nombre'] =
                        'Posta Cancosa'; break;


                case 102303:
                    $establecimientos[$cod_estab]['nombre'] =
                        'CESFAM Pozo Almonte'; break;
                case 102403:
                    $establecimientos[$cod_estab]['nombre'] =
                        'Posta Mamiña'; break;
                case 102406:
                    $establecimientos[$cod_estab]['nombre'] =
                        'Posta La Tirana'; break;
                case 102414:
                    $establecimientos[$cod_estab]['nombre'] =
                        'Posta La Huayca'; break;
            }
            $establecimientos[$cod_estab]['data3']['numerador_acumulado'] = 0;
            for($i = 1; $i <= $ultimo_rem; $i++) {
                $establecimientos[$cod_estab]['data3']['numeradores'][$i] = 0;
            }
            $establecimientos[$cod_estab]['data3']['denominador_acumulado'] = 0;
            $establecimientos[$cod_estab]['data3']['avance'] = 0;
        }





        $sql_numeradores =
            "SELECT IdEstablecimiento AS cod_estab, Mes AS mes, SUM(COALESCE(Col01,0)) numerador FROM 2019rems
            WHERE IdEstablecimiento IN (".implode(', ', $cod_establecimientos).")
            AND CodigoPrestacion IN (
            01010101, 01010201, 01080001, 01110106, 01080030, 01010601, 01010901, 01010401,
            02010101,
            03010501, 03030190, '01030100A', '01030300C', 01200010, 03030140, 01200031,
            03020101, 03020201, 03020301, 03020402, 03020403, 03020401, 03040210, 03040220, 04040100, 04025010, 04025020, 04025025, 04040427, 03020501,
            06020201,
            08220001,
            23080200, 23080300
        )  AND mes <= $mes
            GROUP BY IdEstablecimiento, Mes";

        $numeradores = DB::connection('mysql_rem')->select($sql_numeradores);

        foreach($numeradores as $numerador) {
            $establecimientos[$numerador->cod_estab]['data3']['numeradores'][$numerador->mes] = $numerador->numerador;
            $establecimientos[$numerador->cod_estab]['data3']['numerador_acumulado'] += $numerador->numerador;
            $comunal['data3']['numerador_acumulado'] += $numerador->numerador;
            $comunal['data3']['numeradores'][$numerador->mes] += $numerador->numerador;
        }


        $sql_denominadores =
           "SELECT NOMBRE_CENTRO, COD_CENTRO, COUNT(*) AS POBLACION
            FROM percapita_pro
            WHERE AUTORIZADO = 'X' AND FECHA_CORTE = '2018-08-31' AND
            COD_CENTRO IN (".implode(', ', $cod_establecimientos).")
            GROUP BY COD_CENTRO, NOMBRE_CENTRO";

        $poblaciones = DB::connection('mysql_rem')->select($sql_denominadores);


        foreach($poblaciones as $establecimiento) {
            $comunal['data3']['denominador_acumulado'] += $establecimiento->POBLACION;
            $establecimientos[$establecimiento->COD_CENTRO]['data3']['denominador_acumulado'] = $establecimiento->POBLACION;
        }

        /* Calculos */
        $comunal['data3']['avance'] = number_format((float)
            $comunal['data3']['numerador_acumulado'] / $comunal['data3']['denominador_acumulado']
            , 2, '.', '');

        foreach($establecimientos as $cod => $estab){
            if($estab['data3']['denominador_acumulado'] > 0)
            $establecimientos[$cod]['data3']['avance'] = number_format((float)
                $estab['data3']['numerador_acumulado'] / $estab['data3']['denominador_acumulado']
                , 2, '.', '');
        }




        /***********************************/
        /**********  INDICADOR 4 ***********/
        /***********************************/

        /* Inicializar valores */
        $comunal['data4']['label']['indicador'] =
            'Porcentaje de consultas y controles resueltos en APS
            (Sin derivación a nivel secundario)';
        $comunal['data4']['label']['numerador'] =
            'N° de control y consultas médicas realizadas en APS- N° SIC de
            control y consultas médicas generadas en APS';
        $comunal['data4']['label']['denominador'] =
            'N° total de consultas  y controles por médico * 100';


        $comunal['data4']['numerador_acumulado'] = 0;
        $comunal['data4']['denominador_acumulado'] = 0;

        for($i = 1; $i <= $ultimo_rem; $i++) {
            $comunal['data4']['numeradores'][$i] = 0;
        }


        foreach($cod_establecimientos as $cod_estab){
            for($i = 1; $i <= $ultimo_rem; $i++) {
                $establecimientos[$cod_estab]['data4']['numeradores'][$i] = 0;
            }
            $establecimientos[$cod_estab]['data4']['numerador_acumulado'] = 0;
            $establecimientos[$cod_estab]['data4']['denominador_acumulado'] = 0;
            $establecimientos[$cod_estab]['data4']['avance'] = 0;
        }

        $comunal['data4']['avance'] = 0;

        $sql_numeradores =
        "SELECT IdEstablecimiento AS cod_estab, Mes AS mes,
        	(
        		SUM( CASE WHEN CodigoPrestacion IN (
        	        01010101, 01010201, 01080001, 01110106, 01080030, 01010601, 01010901,
        	        01010401, 02010101, 03010501, 03030190, '01030100A', '01030300C',
        	        01200010, 03030140, 01200031, 03020101, 03020201, 03020301, 03020402,
        	        03020403, 03020401, 03040210, 03040220, 04040100, 04025010, 04025020,
        	        04025025, 04040427, 03020501, 06020201, 08220001, 23080200, 23080300
                ) THEN COALESCE(Col01,0) ELSE 0 END)
         			-
        		SUM( CASE WHEN CodigoPrestacion IN (
                    07020130, 07020230, 07020330, 07020331, 07020332, 07024219, 07020500,
                    07020501, 07020600, 07020601, 07020700, 07020800, 07020801, 07020900,
                    07020901, 07021000, 07021001, 07021100, 07021101, 07021230, 07021300,
                    07021301, 07022000, 07022001, 07021531, 07022132, 07022133, 07022134,
                    07021700, 07021800, 07021801, 07021900, 07022130, 07022142, 07022143,
                    07022144, 07022135, 07022136, 07022137, 07022700, 07022800, 07022900,
                    07021701, 07023100, 07023203, 07023700, 07023701, 07023702, 07023703,
                    07024000, 07024001, 07024200, 07030500, 07024201, 07024202, 07030501,
                    07030502 ) THEN COALESCE(Col44,0)+COALESCE(Col45,0) ELSE 0 END)
        	) AS numerador
        FROM 2019rems
        WHERE IdEstablecimiento IN (".implode(', ', $cod_establecimientos).") AND mes <= $mes
        GROUP BY IdEstablecimiento, Mes";


        $numeradores = DB::connection('mysql_rem')->select($sql_numeradores);

        foreach($numeradores as $numerador) {
            $establecimientos[$numerador->cod_estab]['data4']['numeradores'][$numerador->mes] = $numerador->numerador;
            $establecimientos[$numerador->cod_estab]['data4']['numerador_acumulado'] += $numerador->numerador;
            $comunal['data4']['numerador_acumulado'] += $numerador->numerador;
            $comunal['data4']['numeradores'][$numerador->mes] += $numerador->numerador;
        }

        $comunal['data4']['denominador_acumulado'] = $comunal['data3']['numerador_acumulado'];
        $comunal['data4']['denominadores'] = $comunal['data3']['numeradores'];

        foreach($establecimientos as $cod_estab => $estab) {
            $establecimientos[$cod_estab]['data4']['denominador_acumulado'] =
                $establecimientos[$cod_estab]['data3']['numerador_acumulado'];
            $establecimientos[$cod_estab]['data4']['denominadores'] =
                $establecimientos[$cod_estab]['data3']['numeradores'];
        }

        /* Calculos */
        $comunal['data4']['avance'] = number_format((float)
            $comunal['data4']['numerador_acumulado']*100 / $comunal['data4']['denominador_acumulado']
            , 2, '.', '');

        foreach($establecimientos as $cod => $estab){
            if($estab['data4']['denominador_acumulado'] > 0)
            $establecimientos[$cod]['data4']['avance'] = number_format((float)
                $estab['data4']['numerador_acumulado']*100 / $estab['data4']['denominador_acumulado']
                , 2, '.', '');
        }



        /***********************************/
        /**********  INDICADOR 5 ***********/
        /***********************************/

        $comunal['data5']['label']['indicador'] =
            'Tasa de Visita Domiciliaria Integral';
        $comunal['data5']['label']['numerador'] =
            'Nº visitas domiciliarias integrales realizadas';
        $comunal['data5']['label']['denominador'] =
            'Nº de familias (población inscrita / 3,3)';


        /* Inicializar valores */

        $comunal['data5']['denominador_acumulado'] = 0;
        $comunal['data5']['numerador_acumulado'] = 0;
        for($i = 1; $i <= $ultimo_rem; $i++) {
            $comunal['data5']['numeradores'][$i] = 0;
        }
        $comunal['data5']['avance'] = 0;

        foreach($cod_establecimientos as $cod_estab){
            for($i = 1; $i <= $ultimo_rem; $i++) {
                $establecimientos[$cod_estab]['data5']['numeradores'][$i] = 0;
            }
            $establecimientos[$cod_estab]['data5']['numerador_acumulado'] = 0;
            $establecimientos[$cod_estab]['data5']['denominador_acumulado'] = 0;
            $establecimientos[$cod_estab]['data5']['avance'] = 0;
        }

        /* 27-09-2019 Eliminada codigo de prestación 28021624 */
        $sql_numeradores =
            "SELECT IdEstablecimiento AS cod_estab, Mes AS mes, SUM(COALESCE(Col01,0)) numerador FROM 2019rems
            WHERE IdEstablecimiento IN (".implode(', ', $cod_establecimientos).")
            AND CodigoPrestacion IN (
                26261000,
        		26260100, 26273101, 26274000,
        		26291000, 26291050,
        		26291100, 26273102,
        		26274600, 26262300,
        		26273103, 26273105,
        		26274200, 26280010,
        		26262400, 26291150,
        		26291200, 26291250,
        		26291300, 26280020,
        		26273106, 26274400,
        		26261400, 26273107,
        		26274601, 26300100,
        		26300110, 26273110,
        		26300120, 26300130,
        		26274800
            ) AND mes <= $mes
            GROUP BY IdEstablecimiento, Mes";

        $numeradores = DB::connection('mysql_rem')->select($sql_numeradores);

        foreach($numeradores as $numerador) {
            $establecimientos[$numerador->cod_estab]['data5']['numeradores'][$numerador->mes] = $numerador->numerador;
            $establecimientos[$numerador->cod_estab]['data5']['numerador_acumulado'] += $numerador->numerador;
            $comunal['data5']['numerador_acumulado'] += $numerador->numerador;
            $comunal['data5']['numeradores'][$numerador->mes] += $numerador->numerador;
        }


        $sql_denominadores =
           "SELECT NOMBRE_CENTRO, COD_CENTRO, COUNT(*) AS POBLACION
            FROM percapita_pro
            WHERE AUTORIZADO = 'X' AND FECHA_CORTE = '2018-08-31' AND
            COD_CENTRO IN (".implode(', ', $cod_establecimientos).")
            GROUP BY COD_CENTRO, NOMBRE_CENTRO";

        $poblaciones = DB::connection('mysql_rem')->select($sql_denominadores);


        foreach($poblaciones as $establecimiento) {
            $comunal['data5']['denominador_acumulado'] += round($establecimiento->POBLACION/3.3);
            $establecimientos[$establecimiento->COD_CENTRO]['data5']['denominador_acumulado'] = round($establecimiento->POBLACION/3.3);
        }

        /* Calculos */
        $comunal['data5']['avance'] = number_format((float)
            $comunal['data5']['numerador_acumulado'] / $comunal['data5']['denominador_acumulado']
            , 2, '.', '');

        foreach($establecimientos as $cod => $estab){
            if($estab['data5']['denominador_acumulado'] > 0)
            $establecimientos[$cod]['data5']['avance'] = number_format((float)
                $estab['data5']['numerador_acumulado'] / $estab['data5']['denominador_acumulado']
                , 2, '.', '');
        }


        /***********************************/
        /*********  INDICADOR 6.1 **********/
        /***********************************/

        $comunal['data6']['label']['indicador'] =
            'Cobertura Examen de Medicina Preventiva en hombres y mujeres de
            20 a 64 años';
        $comunal['data6']['label']['numerador'] =
            'Nº Examen de Medicina Preventiva (EMP) realizado en población de
            hombres y mujeres de 20 a 64 años';
        $comunal['data6']['label']['denominador'] =
            'Población de hombres y mujeres de 20 a 64 años inscrita, menos
            población de hombres y mujeres de 20 a 64 años bajo control en
            Programa Salud Cardiovascular) *100';


        /* Inicializar valores */

        $comunal['data6']['denominador_acumulado'] = 0;
        $comunal['data6']['numerador_acumulado'] = 0;
        for($i = 1; $i <= $ultimo_rem; $i++) {
            $comunal['data6']['numeradores'][$i] = 0;
        }
        $comunal['data6']['avance'] = 0;

        foreach($cod_establecimientos as $cod_estab){
            for($i = 1; $i <= $ultimo_rem; $i++) {
                $establecimientos[$cod_estab]['data6']['numeradores'][$i] = 0;
            }
            $establecimientos[$cod_estab]['data6']['numerador_acumulado'] = 0;
            $establecimientos[$cod_estab]['data6']['denominador_acumulado'] = 0;
            $establecimientos[$cod_estab]['data6']['avance'] = 0;
        }

        $sql_numeradores =
            "SELECT IdEstablecimiento AS cod_estab, Mes AS mes,
        	 round(SUM(
                COALESCE(Col06,0)+
                COALESCE(Col07,0)+
                COALESCE(Col08,0)+
                COALESCE(Col09,0)+
                COALESCE(Col10,0)+
                COALESCE(Col11,0)+
                COALESCE(Col12,0)+
                COALESCE(Col13,0)+
                COALESCE(Col14,0)+
                COALESCE(Col15,0)+
                COALESCE(Col16,0)+
                COALESCE(Col17,0)+
                COALESCE(Col18,0)+
                COALESCE(Col19,0)+
                COALESCE(Col20,0)+
                COALESCE(Col21,0)+
                COALESCE(Col22,0)+
                COALESCE(Col23,0)
                )) numerador
        	 FROM 2019rems
            WHERE IdEstablecimiento IN (".implode(', ', $cod_establecimientos).")
            AND CodigoPrestacion IN (
        		03030330, 03030340, 03030120, 03030130
            ) AND mes <= $mes
            GROUP BY IdEstablecimiento, Mes";

        $numeradores = DB::connection('mysql_rem')->select($sql_numeradores);

        foreach($numeradores as $numerador) {
            $establecimientos[$numerador->cod_estab]['data6']['numeradores'][$numerador->mes] = $numerador->numerador;
            $establecimientos[$numerador->cod_estab]['data6']['numerador_acumulado'] += $numerador->numerador;
            $comunal['data6']['numerador_acumulado'] += $numerador->numerador;
            $comunal['data6']['numeradores'][$numerador->mes] += $numerador->numerador;
        }


        /* D - (A+B-C)   =  D - A - B + C*/
        /* D */
        $sql_denominadores_d =
            "SELECT NOMBRE_CENTRO, COD_CENTRO as cod_estab, COUNT(*) AS denominador
                FROM percapita_pro
                WHERE AUTORIZADO = 'X' AND FECHA_CORTE = '2018-08-31' AND
                EDAD BETWEEN 20 AND 64 AND
                COD_CENTRO IN (".implode(', ', $cod_establecimientos).")
                GROUP BY COD_CENTRO, NOMBRE_CENTRO";
        $denominadores_d = DB::connection('mysql_rem')->select($sql_denominadores_d);

        foreach($denominadores_d as $denominador) {
            $establecimientos[$denominador->cod_estab]['data6']['denominador_acumulado'] += $denominador->denominador;
            $comunal['data6']['denominador_acumulado'] += $denominador->denominador;
        }


        /* A */
        $sql_denominadores_a =
            "SELECT IdEstablecimiento AS cod_estab, Mes AS mes,
                round(SUM(
                   COALESCE(Col06,0)+
                   COALESCE(Col07,0)+
                   COALESCE(Col08,0)+
                   COALESCE(Col09,0)+
                   COALESCE(Col10,0)+
                   COALESCE(Col11,0)+
                   COALESCE(Col12,0)+
                   COALESCE(Col13,0)+
                   COALESCE(Col14,0)+
                   COALESCE(Col15,0)+
                   COALESCE(Col16,0)+
                   COALESCE(Col17,0)+
                   COALESCE(Col18,0)+
                   COALESCE(Col19,0)+
                   COALESCE(Col20,0)+
                   COALESCE(Col21,0)+
                   COALESCE(Col22,0)+
                   COALESCE(Col23,0)
                   )) denominador
             FROM 2018rems
            WHERE IdEstablecimiento IN (".implode(', ', $cod_establecimientos).")
            AND mes = 12
            AND CodigoPrestacion IN ('P4150100')
            GROUP BY IdEstablecimiento, Mes
            ORDER BY cod_estab";
        $denominadores_a = DB::connection('mysql_rem')->select($sql_denominadores_a);

        foreach($denominadores_a as $denominador) {
            $establecimientos[$denominador->cod_estab]['data6']['denominador_acumulado'] -= $denominador->denominador;
            $comunal['data6']['denominador_acumulado'] -= $denominador->denominador;
        }



        /* B */
        $sql_denominadores_b =
            "SELECT IdEstablecimiento AS cod_estab,
        	 round(SUM(
                COALESCE(Col06,0)+
                COALESCE(Col07,0)+
                COALESCE(Col08,0)+
                COALESCE(Col09,0)+
                COALESCE(Col10,0)+
                COALESCE(Col11,0)+
                COALESCE(Col12,0)+
                COALESCE(Col13,0)+
                COALESCE(Col14,0)+
                COALESCE(Col15,0)+
                COALESCE(Col16,0)+
                COALESCE(Col17,0)+
                COALESCE(Col18,0)+
                COALESCE(Col19,0)+
                COALESCE(Col20,0)+
                COALESCE(Col21,0)+
                COALESCE(Col22,0)+
                COALESCE(Col23,0)
                )) denominador
        	 FROM 2019rems
            WHERE IdEstablecimiento IN (".implode(', ', $cod_establecimientos).")
            AND CodigoPrestacion IN ('03030360') AND mes <= $mes
            GROUP BY IdEstablecimiento
            ORDER BY cod_estab";
        $denominadores_b = DB::connection('mysql_rem')->select($sql_denominadores_b);

        foreach($denominadores_b as $denominador) {
            $establecimientos[$denominador->cod_estab]['data6']['denominador_acumulado'] -= $denominador->denominador;
            $comunal['data6']['denominador_acumulado'] -= $denominador->denominador;
        }


        /* C */
        $sql_denominadores_c =
            "SELECT IdEstablecimiento AS cod_estab,
        	 round(SUM(
                 COALESCE(Col06,0)+
                 COALESCE(Col07,0)+
                 COALESCE(Col08,0)+
                 COALESCE(Col09,0)+
                 COALESCE(Col10,0)+
                 COALESCE(Col11,0)+
                 COALESCE(Col12,0)+
                 COALESCE(Col13,0)+
                 COALESCE(Col14,0)+
                 COALESCE(Col15,0)+
                 COALESCE(Col16,0)+
                 COALESCE(Col17,0)+
                 COALESCE(Col18,0)+
                 COALESCE(Col19,0)+
                 COALESCE(Col20,0)+
                 COALESCE(Col21,0)+
                 COALESCE(Col22,0)+
                 COALESCE(Col23,0))) denominador
        	 FROM 2019rems
            WHERE IdEstablecimiento IN (".implode(', ', $cod_establecimientos).")
            AND CodigoPrestacion IN ('05810040') AND mes <= $mes
            GROUP BY IdEstablecimiento
            ORDER BY cod_estab";
        $denominadores_c = DB::connection('mysql_rem')->select($sql_denominadores_c);

        foreach($denominadores_c as $denominador) {
            $establecimientos[$denominador->cod_estab]['data6']['denominador_acumulado'] += $denominador->denominador;
            $comunal['data6']['denominador_acumulado'] += $denominador->denominador;
        }

        /* Calculos */
        $comunal['data6']['avance'] = number_format((float)
            $comunal['data6']['numerador_acumulado']*100 / $comunal['data6']['denominador_acumulado']
            , 2, '.', '');

        foreach($establecimientos as $cod => $estab){
            if($estab['data6']['denominador_acumulado'] > 0)
            $establecimientos[$cod]['data6']['avance'] = number_format((float)
                $estab['data6']['numerador_acumulado']*100 / $estab['data6']['denominador_acumulado']
                , 2, '.', '');
        }






        /***********************************/
        /*********  INDICADOR 6.1 **********/
        /***********************************/

        $comunal['data61']['label']['indicador'] =
            'Cobertura de Examen de Medicina Preventiva del Adulto de 65  años y más';
        $comunal['data61']['label']['numerador'] =
            'N° de adultos de 65 y más años con Examen de Medicina Preventiva';
        $comunal['data61']['label']['denominador'] =
            'Población inscrita de 65 años) * 100';


        /* Inicializar valores */

        $comunal['data61']['denominador_acumulado'] = 0;
        $comunal['data61']['numerador_acumulado'] = 0;
        for($i = 1; $i <= $ultimo_rem; $i++) {
            $comunal['data61']['numeradores'][$i] = 0;
        }
        $comunal['data61']['avance'] = 0;

        foreach($cod_establecimientos as $cod_estab){
            for($i = 1; $i <= $ultimo_rem; $i++) {
                $establecimientos[$cod_estab]['data61']['numeradores'][$i] = 0;
            }
            $establecimientos[$cod_estab]['data61']['numerador_acumulado'] = 0;
            $establecimientos[$cod_estab]['data61']['denominador_acumulado'] = 0;
            $establecimientos[$cod_estab]['data61']['avance'] = 0;
        }

        $sql_numeradores =
            "SELECT IdEstablecimiento AS cod_estab, Mes AS mes,
                SUM(
                COALESCE(Col24,0)+
                COALESCE(Col25,0)+
                COALESCE(Col26,0)+
                COALESCE(Col27,0)+
                COALESCE(Col28,0)+
                COALESCE(Col29,0)+
                COALESCE(Col30,0)+
                COALESCE(Col31,0)
                ) numerador FROM 2019rems
            WHERE IdEstablecimiento IN (".implode(', ', $cod_establecimientos).")
            AND CodigoPrestacion IN (
            	03030330, 03030340, 03030120, 03030130
            ) AND mes <= $mes
            GROUP BY IdEstablecimiento, Mes";

        $numeradores = DB::connection('mysql_rem')->select($sql_numeradores);

        foreach($numeradores as $numerador) {
            $establecimientos[$numerador->cod_estab]['data61']['numeradores'][$numerador->mes] = $numerador->numerador;
            $establecimientos[$numerador->cod_estab]['data61']['numerador_acumulado'] += $numerador->numerador;
            $comunal['data61']['numerador_acumulado'] += $numerador->numerador;
            $comunal['data61']['numeradores'][$numerador->mes] += $numerador->numerador;
        }


        $sql_denominadores =
           "SELECT NOMBRE_CENTRO, COD_CENTRO, COUNT(*) AS POBLACION
            FROM percapita_pro
            WHERE AUTORIZADO = 'X' AND FECHA_CORTE = '2018-08-31' AND EDAD >= 65 AND
                  COD_CENTRO IN (".implode(', ', $cod_establecimientos).")
            GROUP BY COD_CENTRO, NOMBRE_CENTRO";

        $poblaciones = DB::connection('mysql_rem')->select($sql_denominadores);


        foreach($poblaciones as $establecimiento) {
            $comunal['data61']['denominador_acumulado'] += $establecimiento->POBLACION;
            $establecimientos[$establecimiento->COD_CENTRO]['data61']['denominador_acumulado'] = $establecimiento->POBLACION;
        }

        /* Calculos */
        $comunal['data61']['avance'] = number_format((float)
            $comunal['data61']['numerador_acumulado']*100 / $comunal['data61']['denominador_acumulado']
            , 2, '.', '');

        foreach($establecimientos as $cod => $estab){
            if($estab['data61']['denominador_acumulado'] > 0)
            $establecimientos[$cod]['data61']['avance'] = number_format((float)
                $estab['data61']['numerador_acumulado']*100 / $estab['data61']['denominador_acumulado']
                , 2, '.', '');
        }





        /*********************************/
        /*********  INDICADOR 7 **********/
        /*********************************/

        $comunal['data7']['label']['indicador'] =
            'Cobertura de Evaluación del Desarrollo Psicomotor de niños(as) de 12 a 23 meses bajo control';
        $comunal['data7']['label']['numerador'] =
            'Nº de Niños(as) de 12 a 23 meses con Evaluación de Desarrollo Psicomotor';
        $comunal['data7']['label']['denominador'] =
            'Nº de Niños(as) 12 a 23  meses bajo control)*100';


        /* Inicializar valores */

        $comunal['data7']['denominador_acumulado'] = 0;
        $comunal['data7']['numerador_acumulado'] = 0;
        for($i = 1; $i <= $ultimo_rem; $i++) {
            $comunal['data7']['numeradores'][$i] = 0;
        }
        $comunal['data7']['avance'] = 0;

        foreach($cod_establecimientos as $cod_estab){
            for($i = 1; $i <= $ultimo_rem; $i++) {
                $establecimientos[$cod_estab]['data7']['numeradores'][$i] = 0;
            }
            $establecimientos[$cod_estab]['data7']['numerador_acumulado'] = 0;
            $establecimientos[$cod_estab]['data7']['denominador_acumulado'] = 0;
            $establecimientos[$cod_estab]['data7']['avance'] = 0;
        }

        $sql_numeradores =
            "SELECT IdEstablecimiento AS cod_estab, Mes AS mes,
                round(SUM(
                    COALESCE(Col08,0)+
                    COALESCE(Col09,0)+
                    COALESCE(Col10,0)+
                    COALESCE(Col11,0)
                    )) numerador FROM 2019rems
            WHERE IdEstablecimiento IN (".implode(', ', $cod_establecimientos).")
            AND CodigoPrestacion IN (
        		02010320, 05225303, 02010321, 02010322
            ) AND mes <= $mes
            GROUP BY IdEstablecimiento, Mes";

        $numeradores = DB::connection('mysql_rem')->select($sql_numeradores);

        foreach($numeradores as $numerador) {
            $establecimientos[$numerador->cod_estab]['data7']['numeradores'][$numerador->mes] = $numerador->numerador;
            $establecimientos[$numerador->cod_estab]['data7']['numerador_acumulado'] += $numerador->numerador;
            $comunal['data7']['numerador_acumulado'] += $numerador->numerador;
            $comunal['data7']['numeradores'][$numerador->mes] += $numerador->numerador;
        }

        /* Antes se sacaba con REM P 2018 ahora lo reemplacé por REM P 2019 */
        $sql_denominadores =
           "SELECT IdEstablecimiento AS cod_estab, Mes AS mes,
                round(SUM(
                    COALESCE(Col20,0)+
                    COALESCE(Col21,0)+
                    COALESCE(Col22,0)+
                    COALESCE(Col23,0)
                    )) denominador
            FROM 2019rems
            WHERE IdEstablecimiento IN (".implode(', ', $cod_establecimientos).")
            AND Mes = 6
            AND CodigoPrestacion IN (
        		'P2060000'
            )
            GROUP BY IdEstablecimiento, Mes";

        $poblaciones = DB::connection('mysql_rem')->select($sql_denominadores);


        foreach($poblaciones as $establecimiento) {
            $comunal['data7']['denominador_acumulado'] += $establecimiento->denominador;
            $establecimientos[$establecimiento->cod_estab]['data7']['denominador_acumulado'] = $establecimiento->denominador;
        }

        /* Calculos */
        if($comunal['data7']['denominador_acumulado'] > 0)
        $comunal['data7']['avance'] = number_format((float)
            $comunal['data7']['numerador_acumulado']*100 / $comunal['data7']['denominador_acumulado']
            , 2, '.', '');

        foreach($establecimientos as $cod => $estab){
            if($estab['data7']['denominador_acumulado'] > 0)
            $establecimientos[$cod]['data7']['avance'] = number_format((float)
                $estab['data7']['numerador_acumulado']*100 / $estab['data7']['denominador_acumulado']
                , 2, '.', '');
        }





        /*********************************/
        /*********  INDICADOR 8 **********/
        /*********************************/

        $comunal['data8']['label']['indicador'] =
            'Cobertura de control de salud integral a adolescentes de 10 a 14 años.';
        $comunal['data8']['label']['numerador'] =
            'Nº de controles de salud integral realizados a adolescentes de 10 a 14 años';
        $comunal['data8']['label']['denominador'] =
            'población adolescente de 10 a 14 años inscrita en el establecimiento de salud*100';


        /* Inicializar valores */

        $comunal['data8']['denominador_acumulado'] = 0;
        $comunal['data8']['numerador_acumulado'] = 0;
        for($i = 1; $i <= $ultimo_rem; $i++) {
            $comunal['data8']['numeradores'][$i] = 0;
        }
        $comunal['data8']['avance'] = 0;

        foreach($cod_establecimientos as $cod_estab){
            for($i = 1; $i <= $ultimo_rem; $i++) {
                $establecimientos[$cod_estab]['data8']['numeradores'][$i] = 0;
            }
            $establecimientos[$cod_estab]['data8']['numerador_acumulado'] = 0;
            $establecimientos[$cod_estab]['data8']['denominador_acumulado'] = 0;
            $establecimientos[$cod_estab]['data8']['avance'] = 0;
        }

        $sql_numeradores =
            "SELECT IdEstablecimiento AS cod_estab, Mes AS mes,
                round(SUM(COALESCE(Col01,0))) numerador FROM 2019rems
            WHERE IdEstablecimiento IN (".implode(', ', $cod_establecimientos).")
            AND CodigoPrestacion IN (
        		01030500,01030600,01030700,01030800
            ) AND mes <= $mes
            GROUP BY IdEstablecimiento, Mes";

        $numeradores = DB::connection('mysql_rem')->select($sql_numeradores);

        foreach($numeradores as $numerador) {
            $establecimientos[$numerador->cod_estab]['data8']['numeradores'][$numerador->mes] = $numerador->numerador;
            $establecimientos[$numerador->cod_estab]['data8']['numerador_acumulado'] += $numerador->numerador;
            $comunal['data8']['numerador_acumulado'] += $numerador->numerador;
            $comunal['data8']['numeradores'][$numerador->mes] += $numerador->numerador;
        }


        $sql_denominadores =
           "SELECT NOMBRE_CENTRO, COD_CENTRO, COUNT(*) AS POBLACION
            FROM percapita_pro
            WHERE AUTORIZADO = 'X' AND FECHA_CORTE = '2018-08-31' AND
            EDAD BETWEEN 10 AND 14 AND
            COD_CENTRO IN (".implode(', ', $cod_establecimientos).")
            GROUP BY COD_CENTRO, NOMBRE_CENTRO";

        $poblaciones = DB::connection('mysql_rem')->select($sql_denominadores);


        foreach($poblaciones as $establecimiento) {
            $comunal['data8']['denominador_acumulado'] += $establecimiento->POBLACION;
            $establecimientos[$establecimiento->COD_CENTRO]['data8']['denominador_acumulado'] = $establecimiento->POBLACION;
        }

        /* Calculos */
        if($comunal['data8']['denominador_acumulado'] > 0)
        $comunal['data8']['avance'] = number_format((float)
            $comunal['data8']['numerador_acumulado']*100 / $comunal['data8']['denominador_acumulado']
            , 2, '.', '');

        foreach($establecimientos as $cod => $estab){
            if($estab['data8']['denominador_acumulado'] > 0)
            $establecimientos[$cod]['data8']['avance'] = number_format((float)
                $estab['data8']['numerador_acumulado']*100 / $estab['data8']['denominador_acumulado']
                , 2, '.', '');
        }





        /*********************************/
        /*********  INDICADOR 9 **********/
        /*********************************/

        $comunal['data9']['label']['indicador'] =
            'Proporción de población de 7 a menores de 20 años con alta odontológica total';
        $comunal['data9']['label']['numerador'] =
            'Nº de altas odontológicas totales en población de 7 años a menor de 20 años';
        $comunal['data9']['label']['denominador'] =
            'Población inscrita de 7 a menor de 20 años) *100';



        /* Inicializar valores */

        $comunal['data9']['denominador_acumulado'] = 0;
        $comunal['data9']['numerador_acumulado'] = 0;
        for($i = 1; $i <= $ultimo_rem; $i++) {
            $comunal['data9']['numeradores'][$i] = 0;
        }
        $comunal['data9']['avance'] = 0;

        foreach($cod_establecimientos as $cod_estab){
            for($i = 1; $i <= $ultimo_rem; $i++) {
                $establecimientos[$cod_estab]['data9']['numeradores'][$i] = 0;
            }
            $establecimientos[$cod_estab]['data9']['numerador_acumulado'] = 0;
            $establecimientos[$cod_estab]['data9']['denominador_acumulado'] = 0;
            $establecimientos[$cod_estab]['data9']['avance'] = 0;
        }

        $sql_numeradores =
            "SELECT IdEstablecimiento AS cod_estab, Mes AS mes,
                round(SUM(
                    COALESCE(Col18,0)+
                    COALESCE(Col19,0)+
                    COALESCE(Col20,0)+
                    COALESCE(Col21,0)+
                    COALESCE(Col22,0)+
                    COALESCE(Col23,0)
                    )) numerador FROM 2019rems
            WHERE IdEstablecimiento IN (".implode(', ', $cod_establecimientos).")
            AND CodigoPrestacion IN (
        		09215313, 09215413
            ) AND mes <= $mes
            GROUP BY IdEstablecimiento, Mes";

        $numeradores = DB::connection('mysql_rem')->select($sql_numeradores);

        foreach($numeradores as $numerador) {
            $establecimientos[$numerador->cod_estab]['data9']['numeradores'][$numerador->mes] = $numerador->numerador;
            $establecimientos[$numerador->cod_estab]['data9']['numerador_acumulado'] += $numerador->numerador;
            $comunal['data9']['numerador_acumulado'] += $numerador->numerador;
            $comunal['data9']['numeradores'][$numerador->mes] += $numerador->numerador;
        }


        $sql_denominadores =
           "SELECT NOMBRE_CENTRO, COD_CENTRO, COUNT(*) AS POBLACION
            FROM percapita_pro
            WHERE AUTORIZADO = 'X' AND FECHA_CORTE = '2018-08-31' AND
            EDAD BETWEEN 7 AND 19 AND
            COD_CENTRO IN (".implode(', ', $cod_establecimientos).")
            GROUP BY COD_CENTRO, NOMBRE_CENTRO";

        $poblaciones = DB::connection('mysql_rem')->select($sql_denominadores);


        foreach($poblaciones as $establecimiento) {
            $comunal['data9']['denominador_acumulado'] += $establecimiento->POBLACION;
            $establecimientos[$establecimiento->COD_CENTRO]['data9']['denominador_acumulado'] = $establecimiento->POBLACION;
        }

        /* Calculos */
        if($comunal['data9']['denominador_acumulado'] > 0)
        $comunal['data9']['avance'] = number_format((float)
            $comunal['data9']['numerador_acumulado']*100 / $comunal['data9']['denominador_acumulado']
            , 2, '.', '');

        foreach($establecimientos as $cod => $estab){
            if($estab['data9']['denominador_acumulado'] > 0)
            $establecimientos[$cod]['data9']['avance'] = number_format((float)
                $estab['data9']['numerador_acumulado']*100 / $estab['data9']['denominador_acumulado']
                , 2, '.', '');
        }




        /***********************************/
        /**********  INDICADOR 10 ***********/
        /***********************************/

        /* Inicializar valores */
        $comunal['data10']['label']['indicador'] =
            'Cobertura de atención Integral a personas de 5 y más años con trastornos mentales';
        $comunal['data10']['label']['numerador'] =
            'Nº de personas de 5 y más años con trastorno mental bajo control';
        $comunal['data10']['label']['denominador'] =
            'Nº de personas esperadas según prevalencia de trastornos mentales';



        /* Inicializar valores */
        $comunal['data10']['numerador_acumulado'] = 0;
        $comunal['data10']['denominador_acumulado'] = 0;
        $comunal['data10']['avance'] = 0;

        foreach($cod_establecimientos as $cod_estab){
            $establecimientos[$cod_estab]['data10']['numerador_acumulado'] = 0;
            $establecimientos[$cod_estab]['data10']['denominador_acumulado'] = 0;
            $establecimientos[$cod_estab]['data10']['avance'] = 0;
        }

        /* I + J - K */
        $sql_numeradores_i =
            "SELECT IdEstablecimiento AS cod_estab,
        	 round(SUM(
                COALESCE(Col06,0)+
                COALESCE(Col07,0)+
                COALESCE(Col08,0)+
                COALESCE(Col09,0)+
                COALESCE(Col10,0)+
                COALESCE(Col11,0)+
                COALESCE(Col12,0)+
                COALESCE(Col13,0)+
                COALESCE(Col14,0)+
                COALESCE(Col15,0)+
                COALESCE(Col16,0)+
                COALESCE(Col17,0)+
                COALESCE(Col18,0)+
                COALESCE(Col19,0)+
                COALESCE(Col20,0)+
                COALESCE(Col21,0)+
                COALESCE(Col22,0)+
                COALESCE(Col23,0)+
                COALESCE(Col24,0)+
                COALESCE(Col25,0)+
                COALESCE(Col26,0)+
                COALESCE(Col27,0)+
                COALESCE(Col28,0)+
                COALESCE(Col29,0)+
                COALESCE(Col30,0)+
                COALESCE(Col31,0)+
                COALESCE(Col32,0)+
                COALESCE(Col33,0)+
                COALESCE(Col34,0)+
                COALESCE(Col35,0)+
                COALESCE(Col36,0)+
                COALESCE(Col37,0)
                )) numerador
        	 FROM 2018rems
            WHERE IdEstablecimiento IN (".implode(', ', $cod_establecimientos).")
            AND mes = 12
            AND CodigoPrestacion IN ('P6227601')
            GROUP BY IdEstablecimiento";

        $numeradores_i = DB::connection('mysql_rem')->select($sql_numeradores_i);

        foreach($numeradores_i as $numerador) {
            $establecimientos[$numerador->cod_estab]['data10']['numerador_acumulado'] += $numerador->numerador;
            $comunal['data10']['numerador_acumulado'] += $numerador->numerador;
        }

        $sql_numeradores_j =
            "SELECT IdEstablecimiento AS cod_estab,
        	 round(SUM(
                COALESCE(Col06,0)+
                COALESCE(Col07,0)+
                COALESCE(Col08,0)+
                COALESCE(Col09,0)+
                COALESCE(Col10,0)+
                COALESCE(Col11,0)+
                COALESCE(Col12,0)+
                COALESCE(Col13,0)+
                COALESCE(Col14,0)+
                COALESCE(Col15,0)+
                COALESCE(Col16,0)+
                COALESCE(Col17,0)+
                COALESCE(Col18,0)+
                COALESCE(Col19,0)+
                COALESCE(Col20,0)+
                COALESCE(Col21,0)+
                COALESCE(Col22,0)+
                COALESCE(Col23,0)+
                COALESCE(Col24,0)+
                COALESCE(Col25,0)+
                COALESCE(Col26,0)+
                COALESCE(Col27,0)+
                COALESCE(Col28,0)+
                COALESCE(Col29,0)+
                COALESCE(Col30,0)+
                COALESCE(Col31,0)+
                COALESCE(Col32,0)+
                COALESCE(Col33,0)+
                COALESCE(Col34,0)+
                COALESCE(Col35,0)+
                COALESCE(Col36,0)+
                COALESCE(Col37,0)
            )) numerador
        	FROM 2019rems
            WHERE IdEstablecimiento IN (".implode(', ', $cod_establecimientos).")
            AND CodigoPrestacion IN ('05810441') AND mes <= $mes
            GROUP BY IdEstablecimiento";

        $numeradores_j = DB::connection('mysql_rem')->select($sql_numeradores_j);

        foreach($numeradores_j as $numerador) {
            $establecimientos[$numerador->cod_estab]['data10']['numerador_acumulado'] += $numerador->numerador;
            $comunal['data10']['numerador_acumulado'] += $numerador->numerador;
        }

        $sql_numeradores_k =
            "SELECT IdEstablecimiento AS cod_estab,
        	 round(SUM(
                 COALESCE(Col06,0)+
                 COALESCE(Col07,0)+
                 COALESCE(Col08,0)+
                 COALESCE(Col09,0)+
                 COALESCE(Col10,0)+
                 COALESCE(Col11,0)+
                 COALESCE(Col12,0)+
                 COALESCE(Col13,0)+
                 COALESCE(Col14,0)+
                 COALESCE(Col15,0)+
                 COALESCE(Col16,0)+
                 COALESCE(Col17,0)+
                 COALESCE(Col18,0)+
                 COALESCE(Col19,0)+
                 COALESCE(Col20,0)+
                 COALESCE(Col21,0)+
                 COALESCE(Col22,0)+
                 COALESCE(Col23,0)+
                 COALESCE(Col24,0)+
                 COALESCE(Col25,0)+
                 COALESCE(Col26,0)+
                 COALESCE(Col27,0)+
                 COALESCE(Col28,0)+
                 COALESCE(Col29,0)+
                 COALESCE(Col30,0)+
                 COALESCE(Col31,0)+
                 COALESCE(Col32,0)+
                 COALESCE(Col33,0)+
                 COALESCE(Col34,0)+
                 COALESCE(Col35,0)+
                 COALESCE(Col36,0)+
                 COALESCE(Col37,0)+
                 COALESCE(Col38,0)+
                 COALESCE(Col39,0)+
                 COALESCE(Col40,0)
             )) numerador
        	FROM 2019rems
            WHERE IdEstablecimiento IN (".implode(', ', $cod_establecimientos).")
            AND CodigoPrestacion IN ('05810442') AND mes <= $mes
            GROUP BY IdEstablecimiento";

        $numeradores_k = DB::connection('mysql_rem')->select($sql_numeradores_k);

        foreach($numeradores_k as $numerador) {
            $establecimientos[$numerador->cod_estab]['data10']['numerador_acumulado'] -= $numerador->numerador;
            $comunal['data10']['numerador_acumulado'] -= $numerador->numerador;
        }





        $sql_denominadores =
            "SELECT NOMBRE_CENTRO, COD_CENTRO, ROUND(COUNT(*)*0.22) AS POBLACION
                FROM percapita_pro
                WHERE AUTORIZADO = 'X' AND FECHA_CORTE = '2018-08-31' AND
                EDAD >= 5 AND
                COD_CENTRO IN (".implode(', ', $cod_establecimientos).")
                GROUP BY COD_CENTRO, NOMBRE_CENTRO";


        $poblaciones = DB::connection('mysql_rem')->select($sql_denominadores);


        foreach($poblaciones as $establecimiento) {
            $comunal['data10']['denominador_acumulado'] += $establecimiento->POBLACION;
            $establecimientos[$establecimiento->COD_CENTRO]['data10']['denominador_acumulado'] = $establecimiento->POBLACION;
        }


        /* Calculos */
        if($comunal['data10']['denominador_acumulado'] > 0)
        $comunal['data10']['avance'] = number_format((float)
            $comunal['data10']['numerador_acumulado']*100 / $comunal['data10']['denominador_acumulado']
            , 2, '.', '');

        foreach($establecimientos as $cod => $estab){
            if($estab['data10']['denominador_acumulado'] > 0)
            $establecimientos[$cod]['data10']['avance'] = number_format((float)
                $estab['data10']['numerador_acumulado']*100 / $estab['data10']['denominador_acumulado']
                , 2, '.', '');
        }




        /***********************************/
        /**********  INDICADOR 13 ***********/
        /***********************************/

        /* Inicializar valores */
        $comunal['data13']['label']['indicador'] =
            'Ingreso precoz de mujeres a control de embarazo';
        $comunal['data13']['label']['numerador'] =
            'N° de mujeres embarazadas ingresadas antes de las 14 semanas a control';
        $comunal['data13']['label']['denominador'] =
            'Total de mujeres embarazadas ingresadas a control)*100';


        $comunal['data13']['numerador_acumulado'] = 0;
        $comunal['data13']['denominador_acumulado'] = 0;

        for($i = 1; $i <= $ultimo_rem; $i++) {
            $comunal['data13']['numeradores'][$i] = 0;
            $comunal['data13']['denominadores'][$i] = 0;
        }


        foreach($cod_establecimientos as $cod_estab){
            for($i = 1; $i <= $ultimo_rem; $i++) {
                $establecimientos[$cod_estab]['data13']['numeradores'][$i] = 0;
                $establecimientos[$cod_estab]['data13']['denominadores'][$i] = 0;
            }
            $establecimientos[$cod_estab]['data13']['numerador_acumulado'] = 0;
            $establecimientos[$cod_estab]['data13']['denominador_acumulado'] = 0;
            $establecimientos[$cod_estab]['data13']['avance'] = 0;
        }

        $comunal['data13']['avance'] = 0;

        $sql_numeradores =
            "SELECT IdEstablecimiento AS cod_estab, Mes AS mes,
                round(SUM(COALESCE(Col01,0))) numerador FROM 2019rems
            WHERE IdEstablecimiento IN (".implode(', ', $cod_establecimientos).")
            AND CodigoPrestacion IN (
                01080009
            ) AND mes <= $mes
            GROUP BY IdEstablecimiento, Mes";


        $numeradores = DB::connection('mysql_rem')->select($sql_numeradores);

        foreach($numeradores as $numerador) {
            $establecimientos[$numerador->cod_estab]['data13']['numeradores'][$numerador->mes] = $numerador->numerador;
            $establecimientos[$numerador->cod_estab]['data13']['numerador_acumulado'] += $numerador->numerador;
            $comunal['data13']['numerador_acumulado'] += $numerador->numerador;
            $comunal['data13']['numeradores'][$numerador->mes] += $numerador->numerador;
        }

        $sql_denominadores =
            "SELECT IdEstablecimiento AS cod_estab, Mes AS mes,
                round(SUM(COALESCE(Col01,0))) denominador FROM 2019rems
            WHERE IdEstablecimiento IN (".implode(', ', $cod_establecimientos).")
            AND CodigoPrestacion IN (
                01080008
            ) AND mes <= $mes
            GROUP BY IdEstablecimiento, Mes";


        $denominadores = DB::connection('mysql_rem')->select($sql_denominadores);

        foreach($denominadores as $denominador) {
            $establecimientos[$denominador->cod_estab]['data13']['denominadores'][$denominador->mes] = $denominador->denominador;
            $establecimientos[$denominador->cod_estab]['data13']['denominador_acumulado'] += $denominador->denominador;
            $comunal['data13']['denominador_acumulado'] += $denominador->denominador;
            $comunal['data13']['denominadores'][$denominador->mes] += $denominador->denominador;
        }

        /* Calculos */
        $comunal['data13']['avance'] = number_format((float)
            $comunal['data13']['numerador_acumulado']*100 / $comunal['data13']['denominador_acumulado']
            , 2, '.', '');

        foreach($establecimientos as $cod => $estab){
            if($estab['data13']['denominador_acumulado'] > 0)
            $establecimientos[$cod]['data13']['avance'] = number_format((float)
                $estab['data13']['numerador_acumulado']*100 / $estab['data13']['denominador_acumulado']
                , 2, '.', '');
        }



        /**********************************/
        /*********  INDICADOR 14 **********/
        /**********************************/

        $comunal['data14']['label']['indicador'] =
            'Cobertura de método anticonceptivos en adolescentes de 15 a 19 años inscritos que usan métodos de regulación de la fertilidad';
        $comunal['data14']['label']['numerador'] =
            'N° de adolescentes bajo control de 15 a 19 años inscritos que usan métodos de regulación de la fertilidad';
        $comunal['data14']['label']['denominador'] =
            'Total adolescentes de 15 a19 años inscritos)*100';


        /**********************************/
        /*********  INDICADOR 15 **********/
        /**********************************/

        $comunal['data15']['label']['indicador'] =
            'Cobertura efectiva de Tratamiento en personas con Diabetes Mellitus 2, de 15 y más años';
        $comunal['data15']['label']['numerador'] =
            'Nº de personas con Diabetes Mellitus 2 de 15 a 79 años con Hb A1c bajo 7% +  Nº de personas con Diabetes Mellitus 2 de 80 y más con Hb A1c bajo 8% según último control vigente';
        $comunal['data15']['label']['denominador'] =
            'Total de personas con diabetes de 15 y más años esperados según prevalencia)*100';


        /**********************************/
        /*********  INDICADOR 16 **********/
        /**********************************/

        $comunal['data16']['label']['indicador'] =
            'Cobertura efectiva de Tratamiento en personas de 15 y más años, con Hipertensión Arterial';
        $comunal['data16']['label']['numerador'] =
            'Nº de personas hipertensas de 15 a 79 años con PA< 140/90 mm Hg +  Nº de personas hipertensas de 80 y más con PA <150/90 mm Hg según último control vigente';
        $comunal['data16']['label']['denominador'] =
            'Total de personas de 15 años y más, hipertensas esperadas según prevalencia)*100';



        /**********************************/
        /*********  INDICADOR 17 **********/
        /**********************************/

        $comunal['data17']['label']['indicador'] =
            'Proporción de niñas y niños menores de 3 años libre de caries en población inscrita';
        $comunal['data17']['label']['numerador'] =
            'N º de niños y niñas menores de 3 años con registro ceod = 0';
        $comunal['data17']['label']['denominador'] =
            'N° de niñas y niños menores de 3 años inscritos)*100';



        /* Inicializar valores */

        $comunal['data17']['denominador_acumulado'] = 0;
        $comunal['data17']['numerador_acumulado'] = 0;
        for($i = 1; $i <= $ultimo_rem; $i++) {
            $comunal['data17']['numeradores'][$i] = 0;
        }
        $comunal['data17']['avance'] = 0;

        foreach($cod_establecimientos as $cod_estab){
            for($i = 1; $i <= $ultimo_rem; $i++) {
                $establecimientos[$cod_estab]['data17']['numeradores'][$i] = 0;
            }
            $establecimientos[$cod_estab]['data17']['numerador_acumulado'] = 0;
            $establecimientos[$cod_estab]['data17']['denominador_acumulado'] = 0;
            $establecimientos[$cod_estab]['data17']['avance'] = 0;
        }

        $sql_numeradores =
            "SELECT IdEstablecimiento AS cod_estab, Mes AS mes,
                round(SUM(
                    COALESCE(Col04,0)+
                    COALESCE(Col05,0)+
                    COALESCE(Col06,0)+
                    COALESCE(Col07,0)+
                    COALESCE(Col08,0)+
                    COALESCE(Col09,0)
                    )) numerador FROM 2019rems
            WHERE IdEstablecimiento IN (".implode(', ', $cod_establecimientos).")
            AND CodigoPrestacion IN (
        		09220100
            ) AND mes <= $mes
            GROUP BY IdEstablecimiento, Mes";

        $numeradores = DB::connection('mysql_rem')->select($sql_numeradores);

        foreach($numeradores as $numerador) {
            $establecimientos[$numerador->cod_estab]['data17']['numeradores'][$numerador->mes] = $numerador->numerador;
            $establecimientos[$numerador->cod_estab]['data17']['numerador_acumulado'] += $numerador->numerador;
            $comunal['data17']['numerador_acumulado'] += $numerador->numerador;
            $comunal['data17']['numeradores'][$numerador->mes] += $numerador->numerador;
        }


        $sql_denominadores =
           "SELECT NOMBRE_CENTRO, COD_CENTRO, COUNT(*) AS POBLACION
            FROM percapita_pro
            WHERE AUTORIZADO = 'X' AND FECHA_CORTE = '2018-08-31' AND
            EDAD < 3 AND
            COD_CENTRO IN (".implode(', ', $cod_establecimientos).")
            GROUP BY COD_CENTRO, NOMBRE_CENTRO";

        $poblaciones = DB::connection('mysql_rem')->select($sql_denominadores);


        foreach($poblaciones as $establecimiento) {
            $comunal['data17']['denominador_acumulado'] += $establecimiento->POBLACION;
            $establecimientos[$establecimiento->COD_CENTRO]['data17']['denominador_acumulado'] = $establecimiento->POBLACION;
        }

        /* Calculos */
        if($comunal['data17']['denominador_acumulado'] > 0)
        $comunal['data17']['avance'] = number_format((float)
            $comunal['data17']['numerador_acumulado']*100 / $comunal['data17']['denominador_acumulado']
            , 2, '.', '');

        foreach($establecimientos as $cod => $estab){
            if($estab['data17']['denominador_acumulado'] > 0)
            $establecimientos[$cod]['data17']['avance'] = number_format((float)
                $estab['data17']['numerador_acumulado']*100 / $estab['data17']['denominador_acumulado']
                , 2, '.', '');
        }



        /**********************************/
        /*********  INDICADOR 18 **********/
        /**********************************/

        $comunal['data18']['label']['indicador'] =
            'Proporción de niñas y niños menores de 6 años con estado nutricional normal';
        $comunal['data18']['label']['numerador'] =
            'N º de niños y niñas menores de 6 años con estado nutricional normal';
        $comunal['data18']['label']['denominador'] =
            'N° de niñas y niños menores de 6 años inscritos)*100';




        // echo '<pre>';
        // print_r($comunal);
        // print_r($establecimientos);
        // die();

        return view('indicators.iaaps.2019.show',
            compact('nombre_comuna', 'comunal', 'establecimientos'));
    }

}
