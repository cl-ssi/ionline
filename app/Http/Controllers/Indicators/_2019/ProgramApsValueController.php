<?php

namespace App\Http\Controllers\Indicators\_2019;

use App\Models\Indicators\ProgramApsValue;
use App\Models\Indicators\ProgramApsGlosa;
use App\Models\Commune;
use App\Models\Establishment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Indicators\Establecimiento;
use App\Models\Indicators\Rem;
use Illuminate\Support\Facades\DB;

class ProgramApsValueController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $communes = Commune::All();

        /* Crea la comuna Hector Reyno on the fly */
        $commune = new Commune();
        $commune->id = 8;
        $commune->name = "Hector Reyno";
        $communes->push($commune);


        $glosas   = ProgramApsGlosa::where('periodo', 2019)->get();

        /* Inicializar valores */
        foreach($communes as $commune) {
            $commune->name = mb_strtoupper($commune->name);
            foreach($glosas as $glosa) {
                $data[$commune->name][$glosa->numero]['id'] = $glosa->id;
                $data[$commune->name][$glosa->numero]['poblacion'] = '';
                $data[$commune->name][$glosa->numero]['cobertura'] = '';
                $data[$commune->name][$glosa->numero]['concentracion'] = null;
                $data[$commune->name][$glosa->numero]['actividadesProgramadas'] = 0;
                $data[$commune->name][$glosa->numero]['observadoAnterior'] = '';
                $data[$commune->name][$glosa->numero]['rendimientoProfesional'] = '';
                $data[$commune->name][$glosa->numero]['observaciones'] = '';
                $data[$commune->name][$glosa->numero]['ct_marzo'] = 0;
                $data[$commune->name][$glosa->numero]['porc_marzo'] = '';
            }
        }

        $values = ProgramApsValue::with('glosa')->with('commune')->where(function ($query) { $query->where('periodo', 2019);})->get();

        foreach($values as $value) {
            $value->commune->name = mb_strtoupper($value->commune->name);
            //$data[$value->commune->name][$value->glosa->numero]['poblacion'] = $value->poblacion;
            $data[$value->commune->name][$value->glosa->numero]['cobertura'] = $value->cobertura;
            $data[$value->commune->name][$value->glosa->numero]['concentracion'] = $value->concentracion;
            $data[$value->commune->name][$value->glosa->numero]['actividadesProgramadas'] = $value->actividadesProgramadas;
            $data[$value->commune->name][$value->glosa->numero]['observadoAnterior'] = $value->observadoAnterior;
            $data[$value->commune->name][$value->glosa->numero]['rendimientoProfesional'] = $value->rendimientoProfesional;
            $data[$value->commune->name][$value->glosa->numero]['observaciones'] = $value->observaciones;
            if($value->commune->id == 7) {
                //$data['HECTOR REYNO'][$value->glosa->numero]['poblacion'] = $value->poblacion;
                $data['HECTOR REYNO'][$value->glosa->numero]['cobertura'] = $value->cobertura;
                $data['HECTOR REYNO'][$value->glosa->numero]['concentracion'] = $value->concentracion;
                $data['HECTOR REYNO'][$value->glosa->numero]['actividadesProgramadas'] = $value->actividadesProgramadas;
                $data['HECTOR REYNO'][$value->glosa->numero]['observadoAnterior'] = $value->observadoAnterior;
                $data['HECTOR REYNO'][$value->glosa->numero]['rendimientoProfesional'] = $value->rendimientoProfesional;
                $data['HECTOR REYNO'][$value->glosa->numero]['observaciones'] = $value->observaciones;
            }
        }


        /* Poblaciones */
        $query ='SELECT
                	IF(COD_CENTRO = 102307, "HECTOR REYNO", comuna) AS NombreComuna,
                	COUNT(*) poblacion FROM percapita_pro p
                LEFT JOIN 2019establecimientos e
                ON p.COD_CENTRO = e.Codigo
                WHERE p.AUTORIZADO = "X" AND p.EDAD BETWEEN 10 AND 19
                GROUP BY NombreComuna, comuna ORDER BY comuna';
        $poblaciones_10a_a_19a = DB::connection('mysql_rem')->select($query);

        $query ='SELECT
                    IF(COD_CENTRO = 102307, "HECTOR REYNO", comuna) AS NombreComuna,
                    COUNT(*) poblacion FROM percapita_pro p
                LEFT JOIN 2019establecimientos e
                ON p.COD_CENTRO = e.Codigo
                WHERE p.AUTORIZADO = "X" AND p.EDAD BETWEEN 20 AND 64
                GROUP BY NombreComuna, comuna ORDER BY comuna';
        $poblaciones_20a_a_64a = DB::connection('mysql_rem')->select($query);

        $query ='SELECT
                    IF(COD_CENTRO = 102307, "HECTOR REYNO", comuna) AS NombreComuna,
                    COUNT(*) poblacion FROM percapita_pro p
                LEFT JOIN 2019establecimientos e
                ON p.COD_CENTRO = e.Codigo
                WHERE p.AUTORIZADO = "X" AND p.EDAD > 64
                GROUP BY NombreComuna, comuna ORDER BY comuna';
        $poblaciones_mayor_64a = DB::connection('mysql_rem')->select($query);

        // echo '<pre>';
        // print_r($data);
        // die();


        /* Obtener los valores por cada uno de los indicadores */
        /* 1 */
        $query ='SELECT
	               IF(Codigo = "102307", "HECTOR REYNO", comuna) AS NombreComuna, e.alias_estab,
                   SUM(COALESCE(Col06,0) + COALESCE(Col08,0) + COALESCE(Col10,0)) AS total FROM 2019rems r
                JOIN 2019establecimientos e ON r.IdEstablecimiento = e.Codigo
                WHERE CodigoPrestacion IN (02010201)
                AND r.mes IN (1,2,3,4,5,6,7,8,9,10,11,12)
                AND r.IdEstablecimiento NOT IN (102100,102600,102601,102602,102011)
                GROUP BY NombreComuna, e.alias_estab ORDER BY NombreComuna, e.alias_estab';
        $cantidades = DB::connection('mysql_rem')->select($query);

        foreach($cantidades as $cantidad) {
            if($cantidad->NombreComuna != 'HECTOR REYNO') $data[$cantidad->NombreComuna][1][$cantidad->alias_estab]['ct_marzo'] = $cantidad->total;
            $data[$cantidad->NombreComuna][1]['ct_marzo'] += $cantidad->total;
        }

        $query ='SELECT
                    IF(COD_CENTRO = 102307, "HECTOR REYNO", comuna) AS NombreComuna,
                    COUNT(*) poblacion FROM percapita_pro p
                LEFT JOIN 2019establecimientos e
                ON p.COD_CENTRO = e.Codigo
                WHERE p.AUTORIZADO = "X" AND p.EDAD = 0
                AND TIMESTAMPDIFF(MONTH, FECHA_NACIMIENTO, FECHA_CORTE) IN (2,4,6)
                GROUP BY NombreComuna, comuna ORDER BY comuna';
        $poblaciones = DB::connection('mysql_rem')->select($query);

        foreach($poblaciones as $poblacion) {
            $data[$poblacion->NombreComuna][1]['poblacion'] = $poblacion->poblacion;
        }

        /* 2 */
        $query ='SELECT
                    IF(Codigo = "102307", "HECTOR REYNO", comuna) AS NombreComuna, e.alias_estab,
                    SUM(COALESCE(Col01,0)) AS total FROM 2019rems r
                JOIN 2019establecimientos e ON r.IdEstablecimiento = e.Codigo
                WHERE CodigoPrestacion IN (01110107, 01080040)
                AND r.mes IN (1,2,3,4,5,6,7,8,9,10,11,12)
                AND r.IdEstablecimiento NOT IN (102100,102600,102601,102602,102011)
                GROUP BY NombreComuna, e.alias_estab ORDER BY NombreComuna, e.alias_estab';
        $cantidades = DB::connection('mysql_rem')->select($query);

        foreach($cantidades as $cantidad) {
            if($cantidad->NombreComuna != 'HECTOR REYNO') $data[$cantidad->NombreComuna][2][$cantidad->alias_estab]['ct_marzo'] = $cantidad->total;
            $data[$cantidad->NombreComuna][2]['ct_marzo'] += $cantidad->total;
        }

        $query ='SELECT
                    IF(COD_CENTRO = 102307, "HECTOR REYNO", comuna) AS NombreComuna,
                    COUNT(*) poblacion FROM percapita_pro p
                LEFT JOIN 2019establecimientos e
                ON p.COD_CENTRO = e.Codigo
                WHERE p.AUTORIZADO = "X" AND p.EDAD = 0
                AND TIMESTAMPDIFF(DAY, FECHA_NACIMIENTO, FECHA_CORTE) < 28
                GROUP BY NombreComuna, comuna ORDER BY comuna';
        $poblaciones = DB::connection('mysql_rem')->select($query);

        foreach($poblaciones as $poblacion) {
            $data[$poblacion->NombreComuna][2]['poblacion'] = $poblacion->poblacion;
        }

        $data['HECTOR REYNO'][2]['poblacion'] = 316;
        $data['HECTOR REYNO'][2]['actividadesProgramadas'] = 316;

        /* 3 */
        $query ='SELECT
                    IF(Codigo = "102307", "HECTOR REYNO", comuna) AS NombreComuna, e.alias_estab,
                    SUM(COALESCE(Col04,0) + COALESCE(Col05,0) + COALESCE(Col06,0) +
                        COALESCE(Col07,0) + COALESCE(Col08,0) + COALESCE(Col09,0))
                        AS total FROM 2019rems r
                JOIN 2019establecimientos e ON r.IdEstablecimiento = e.Codigo
                WHERE CodigoPrestacion IN (04040426)
                AND r.mes IN (1,2,3,4,5,6,7,8,9,10,11,12)
                AND r.IdEstablecimiento NOT IN (102100,102600,102601,102602,102011)
                GROUP BY NombreComuna, e.alias_estab ORDER BY NombreComuna, e.alias_estab';
        $cantidades = DB::connection('mysql_rem')->select($query);

        foreach($cantidades as $cantidad) {
            if($cantidad->NombreComuna != 'HECTOR REYNO') $data[$cantidad->NombreComuna][3][$cantidad->alias_estab]['ct_marzo'] = $cantidad->total;
            $data[$cantidad->NombreComuna][3]['ct_marzo'] += $cantidad->total;
        }

        $query ='SELECT
                    IF(COD_CENTRO = 102307, "HECTOR REYNO", comuna) AS NombreComuna,
                    COUNT(*) poblacion FROM percapita_pro p
                LEFT JOIN 2019establecimientos e
                ON p.COD_CENTRO = e.Codigo
                WHERE p.AUTORIZADO = "X" AND p.EDAD = 0
                AND TIMESTAMPDIFF(MONTH, FECHA_NACIMIENTO, FECHA_CORTE) <= 6
                GROUP BY NombreComuna, comuna ORDER BY comuna';
        $poblaciones = DB::connection('mysql_rem')->select($query);

        foreach($poblaciones as $poblacion) {
            $data[$poblacion->NombreComuna][3]['poblacion'] = $poblacion->poblacion;
        }


        /* 4 */
        $query ='SELECT
                    IF(Codigo = "102307", "HECTOR REYNO", comuna) AS NombreComuna, e.alias_estab,
                    SUM(COALESCE(Col06,0) + COALESCE(Col07,0)) AS total FROM 2019rems r
                JOIN 2019establecimientos e ON r.IdEstablecimiento = e.Codigo
                WHERE CodigoPrestacion IN (02010320, 05225303, 02010321, 02010322)
                AND r.mes IN (1,2,3,4,5,6,7,8,9,10,11,12)
                AND r.IdEstablecimiento NOT IN (102100,102600,102601,102602,102011)
                GROUP BY NombreComuna, e.alias_estab ORDER BY NombreComuna, e.alias_estab';
        $cantidades = DB::connection('mysql_rem')->select($query);

        foreach($cantidades as $cantidad) {
            if($cantidad->NombreComuna != 'HECTOR REYNO') $data[$cantidad->NombreComuna][4][$cantidad->alias_estab]['ct_marzo'] = $cantidad->total;
            $data[$cantidad->NombreComuna][4]['ct_marzo'] += $cantidad->total;
        }

        $query ='SELECT
                    IF(COD_CENTRO = 102307, "HECTOR REYNO", comuna) AS NombreComuna,
                    COUNT(*) poblacion FROM percapita_pro p
                LEFT JOIN 2019establecimientos e
                ON p.COD_CENTRO = e.Codigo
                WHERE p.AUTORIZADO = "X" AND p.EDAD = 0
                AND TIMESTAMPDIFF(MONTH, FECHA_NACIMIENTO, FECHA_CORTE) = 8
                GROUP BY NombreComuna, comuna ORDER BY comuna';
        $poblaciones = DB::connection('mysql_rem')->select($query);

        foreach($poblaciones as $poblacion) {
            $data[$poblacion->NombreComuna][4]['poblacion'] = $poblacion->poblacion;
        }

        /* 5 */
        $query ='SELECT
                    IF(Codigo = "102307", "HECTOR REYNO", comuna) AS NombreComuna, e.alias_estab,
                    SUM(COALESCE(Col10,0) + COALESCE(Col11,0)) AS total FROM 2019rems r
                JOIN 2019establecimientos e ON r.IdEstablecimiento = e.Codigo
                WHERE CodigoPrestacion IN (02010320, 05225303, 02010321, 02010322)
                AND r.mes IN (1,2,3,4,5,6,7,8,9,10,11,12)
                AND r.IdEstablecimiento NOT IN (102100,102600,102601,102602,102011)
                GROUP BY NombreComuna, e.alias_estab ORDER BY NombreComuna, e.alias_estab';
        $cantidades = DB::connection('mysql_rem')->select($query);

        foreach($cantidades as $cantidad) {
            if($cantidad->NombreComuna != 'HECTOR REYNO') $data[$cantidad->NombreComuna][5][$cantidad->alias_estab]['ct_marzo'] = $cantidad->total;
            $data[$cantidad->NombreComuna][5]['ct_marzo'] += $cantidad->total;
        }

        $query ='SELECT
                    IF(COD_CENTRO = 102307, "HECTOR REYNO", comuna) AS NombreComuna,
                    COUNT(*) poblacion FROM percapita_pro p
                LEFT JOIN 2019establecimientos e
                ON p.COD_CENTRO = e.Codigo
                WHERE p.AUTORIZADO = "X" AND p.EDAD = 1
                AND TIMESTAMPDIFF(MONTH, FECHA_NACIMIENTO, FECHA_CORTE) = 18
                GROUP BY NombreComuna, comuna ORDER BY comuna';
        $poblaciones = DB::connection('mysql_rem')->select($query);

        foreach($poblaciones as $poblacion) {
            $data[$poblacion->NombreComuna][5]['poblacion'] = $poblacion->poblacion;
        }

        /* 6 */
        $query ='SELECT
                    IF(Codigo = "102307", "HECTOR REYNO", comuna) AS NombreComuna, e.alias_estab,
                    SUM(COALESCE(Col12,0) + COALESCE(Col13,0)) AS total FROM 2019rems r
                JOIN 2019establecimientos e ON r.IdEstablecimiento = e.Codigo
                WHERE CodigoPrestacion IN (02010320, 05225303, 02010321, 02010322)
                AND r.mes IN (1,2,3,4,5,6,7,8,9,10,11,12)
                AND r.IdEstablecimiento NOT IN (102100,102600,102601,102602,102011)
                GROUP BY NombreComuna, e.alias_estab ORDER BY NombreComuna, e.alias_estab';
        $cantidades = DB::connection('mysql_rem')->select($query);

        foreach($cantidades as $cantidad) {
            if($cantidad->NombreComuna != 'HECTOR REYNO') $data[$cantidad->NombreComuna][6][$cantidad->alias_estab]['ct_marzo'] = $cantidad->total;
            $data[$cantidad->NombreComuna][6]['ct_marzo'] += $cantidad->total;
        }

        $query ='SELECT
                    IF(COD_CENTRO = 102307, "HECTOR REYNO", comuna) AS NombreComuna,
                    COUNT(*) poblacion FROM percapita_pro p
                LEFT JOIN 2019establecimientos e
                ON p.COD_CENTRO = e.Codigo
                WHERE p.AUTORIZADO = "X" AND p.EDAD = 3
                GROUP BY NombreComuna, comuna ORDER BY comuna';
        $poblaciones = DB::connection('mysql_rem')->select($query);

        foreach($poblaciones as $poblacion) {
            $data[$poblacion->NombreComuna][6]['poblacion'] = $poblacion->poblacion;
        }

        /* 7 */
        $query ='SELECT
                    IF(Codigo = "102307", "HECTOR REYNO", comuna) AS NombreComuna, e.alias_estab,
                    SUM(
                        COALESCE(Col04,0) +
                        COALESCE(Col05,0) +
                        COALESCE(Col06,0) +
                        COALESCE(Col07,0) +
                        COALESCE(Col08,0) +
                        COALESCE(Col09,0)
                    ) AS total FROM 2019rems r
                JOIN 2019establecimientos e ON r.IdEstablecimiento = e.Codigo
                WHERE CodigoPrestacion IN (04040417, 04040418)
                AND r.mes IN (1,2,3,4,5,6,7,8,9,10,11,12)
                AND r.IdEstablecimiento NOT IN (102100,102600,102601,102602,102011)
                GROUP BY NombreComuna, e.alias_estab ORDER BY NombreComuna, e.alias_estab';
        $cantidades = DB::connection('mysql_rem')->select($query);

        foreach($cantidades as $cantidad) {
            if($cantidad->NombreComuna != 'HECTOR REYNO') $data[$cantidad->NombreComuna][7][$cantidad->alias_estab]['ct_marzo'] = $cantidad->total;
            $data[$cantidad->NombreComuna][7]['ct_marzo'] += $cantidad->total;
        }

        $query ='SELECT
                    IF(COD_CENTRO = 102307, "HECTOR REYNO", comuna) AS NombreComuna,
                    COUNT(*) poblacion FROM percapita_pro p
                LEFT JOIN 2019establecimientos e
                ON p.COD_CENTRO = e.Codigo
                WHERE p.AUTORIZADO = "X" AND p.EDAD < 9
                GROUP BY NombreComuna, comuna ORDER BY comuna';
        $poblaciones = DB::connection('mysql_rem')->select($query);

        foreach($poblaciones as $poblacion) {
            $data[$poblacion->NombreComuna][7]['poblacion'] = $poblacion->poblacion;
        }


        /* 8 */
        $query ='SELECT
                    IF(Codigo = "102307", "HECTOR REYNO", comuna) AS NombreComuna, e.alias_estab,
                    SUM(
                        COALESCE(Col04,0) +
                        COALESCE(Col05,0) +
                        COALESCE(Col06,0) +
                        COALESCE(Col07,0) +
                        COALESCE(Col08,0) +
                        COALESCE(Col09,0)
                    ) AS total FROM 2019rems r
                JOIN 2019establecimientos e ON r.IdEstablecimiento = e.Codigo
                WHERE CodigoPrestacion IN (
                    3020101,
                    3020201,
                    3020301,
                    3020402,
                    3020403,
                    3020401,
                    3040210,
                    3040220,
                    4040100,
                    4025010,
                    4025020,
                    4025025,
                    4040427,
                    3020501)
                AND r.mes IN (1,2,3,4,5,6,7,8,9,10,11,12)
                AND r.IdEstablecimiento NOT IN (102100,102600,102601,102602,102011)
                GROUP BY NombreComuna, e.alias_estab ORDER BY NombreComuna, e.alias_estab';
        $cantidades = DB::connection('mysql_rem')->select($query);

        foreach($cantidades as $cantidad) {
            if($cantidad->NombreComuna != 'HECTOR REYNO') $data[$cantidad->NombreComuna][8][$cantidad->alias_estab]['ct_marzo'] = $cantidad->total;
            $data[$cantidad->NombreComuna][8]['ct_marzo'] += $cantidad->total;
        }

        $query ='SELECT
                    IF(COD_CENTRO = 102307, "HECTOR REYNO", comuna) AS NombreComuna,
                    COUNT(*) poblacion FROM percapita_pro p
                LEFT JOIN 2019establecimientos e
                ON p.COD_CENTRO = e.Codigo
                WHERE p.AUTORIZADO = "X" AND p.EDAD < 10
                GROUP BY NombreComuna, comuna ORDER BY comuna';
        $poblaciones = DB::connection('mysql_rem')->select($query);

        foreach($poblaciones as $poblacion) {
            $data[$poblacion->NombreComuna][8]['poblacion'] = $poblacion->poblacion;
        }

        /* 9 */
        $query ='SELECT
                    IF(Codigo = "102307", "HECTOR REYNO", comuna) AS NombreComuna, e.alias_estab,
                    SUM(COALESCE(Col04,0) + COALESCE(Col05,0) + COALESCE(Col06,0) +
                        COALESCE(Col07,0) + COALESCE(Col08,0) + COALESCE(Col09,0) +
                        COALESCE(Col10,0) + COALESCE(Col11,0) + COALESCE(Col12,0) +
                        COALESCE(Col13,0)) AS total FROM 2019rems r
                JOIN 2019establecimientos e ON r.IdEstablecimiento = e.Codigo
                WHERE CodigoPrestacion IN (23080300, 23080400, 23080500)
                AND r.mes IN (1,2,3,4,5,6,7,8,9,10,11,12)
                AND r.IdEstablecimiento NOT IN (102100,102600,102601,102602,102011)
                GROUP BY NombreComuna, e.alias_estab ORDER BY NombreComuna, e.alias_estab';
        $cantidades = DB::connection('mysql_rem')->select($query);

        foreach($cantidades as $cantidad) {
            if($cantidad->NombreComuna != 'HECTOR REYNO') $data[$cantidad->NombreComuna][9][$cantidad->alias_estab]['ct_marzo'] = $cantidad->total;
            $data[$cantidad->NombreComuna][9]['ct_marzo'] += $cantidad->total;
        }

        $query ='SELECT
                    IF(COD_CENTRO = 102307, "HECTOR REYNO", comuna) AS NombreComuna,
                    COUNT(*) poblacion FROM percapita_pro p
                LEFT JOIN 2019establecimientos e
                ON p.COD_CENTRO = e.Codigo
                WHERE p.AUTORIZADO = "X" AND p.EDAD < 20
                GROUP BY NombreComuna, comuna ORDER BY comuna';
        $poblaciones = DB::connection('mysql_rem')->select($query);

        foreach($poblaciones as $poblacion) {
            $data[$poblacion->NombreComuna][9]['poblacion'] = $poblacion->poblacion;
        }

        /* 10 */
        $query ='SELECT
                    IF(Codigo = "102307", "HECTOR REYNO", comuna) AS NombreComuna, e.alias_estab,
                    SUM(COALESCE(Col04,0) + COALESCE(Col05,0) + COALESCE(Col06,0) +
                        COALESCE(Col07,0) + COALESCE(Col08,0) + COALESCE(Col09,0) +
                        COALESCE(Col10,0) + COALESCE(Col11,0))
                        AS total FROM 2019rems r
                JOIN 2019establecimientos e ON r.IdEstablecimiento = e.Codigo
                WHERE CodigoPrestacion IN (05225304, 02010420, 05225305, 03500366, 05225306, 02010421, 02010422)
                AND r.mes IN (1,2,3,4,5,6,7,8,9,10,11,12)
                AND r.IdEstablecimiento NOT IN (102100,102600,102601,102602,102011)
                GROUP BY NombreComuna, e.alias_estab ORDER BY NombreComuna, e.alias_estab';
        $cantidades = DB::connection('mysql_rem')->select($query);

        foreach($cantidades as $cantidad) {
            if($cantidad->NombreComuna != 'HECTOR REYNO') $data[$cantidad->NombreComuna][10][$cantidad->alias_estab]['ct_marzo'] = $cantidad->total;
            $data[$cantidad->NombreComuna][10]['ct_marzo'] += $cantidad->total;
        }

        $query ='SELECT
                    IF(COD_CENTRO = 102307, "HECTOR REYNO", comuna) AS NombreComuna,
                    COUNT(*) poblacion FROM percapita_pro p
                LEFT JOIN 2019establecimientos e
                ON p.COD_CENTRO = e.Codigo
                WHERE p.AUTORIZADO = "X" AND p.EDAD < 2
                GROUP BY NombreComuna, comuna ORDER BY comuna';
        $poblaciones = DB::connection('mysql_rem')->select($query);

        foreach($poblaciones as $poblacion) {
            $data[$poblacion->NombreComuna][10]['poblacion'] = $poblacion->poblacion;
        }

        /* 11 */
        $query ='SELECT
                    IF(Codigo = "102307", "HECTOR REYNO", comuna) AS NombreComuna, e.alias_estab,
                    SUM(COALESCE(Col12,0) + COALESCE(Col13,0)) AS total FROM 2019rems r
                JOIN 2019establecimientos e ON r.IdEstablecimiento = e.Codigo
                WHERE CodigoPrestacion IN (05225304, 02010420, 05225305, 03500366, 05225306, 02010421, 02010422)
                AND r.mes IN (1,2,3,4,5,6,7,8,9,10,11,12)
                AND r.IdEstablecimiento NOT IN (102100,102600,102601,102602,102011)
                GROUP BY NombreComuna, e.alias_estab ORDER BY NombreComuna, e.alias_estab';
        $cantidades = DB::connection('mysql_rem')->select($query);

        foreach($cantidades as $cantidad) {
            if($cantidad->NombreComuna != 'HECTOR REYNO') $data[$cantidad->NombreComuna][11][$cantidad->alias_estab]['ct_marzo'] = $cantidad->total;
            $data[$cantidad->NombreComuna][11]['ct_marzo'] += $cantidad->total;
        }

        $query ='SELECT
                    IF(COD_CENTRO = 102307, "HECTOR REYNO", comuna) AS NombreComuna,
                    COUNT(*) poblacion FROM percapita_pro p
                LEFT JOIN 2019establecimientos e
                ON p.COD_CENTRO = e.Codigo
                WHERE p.AUTORIZADO = "X" AND p.EDAD BETWEEN 2 AND 4
                GROUP BY NombreComuna, comuna ORDER BY comuna';
        $poblaciones = DB::connection('mysql_rem')->select($query);

        foreach($poblaciones as $poblacion) {
            $data[$poblacion->NombreComuna][11]['poblacion'] = $poblacion->poblacion;
        }

        /* 12 */
        $query ='SELECT
                    IF(Codigo = "102307", "HECTOR REYNO", comuna) AS NombreComuna, e.alias_estab,
                    SUM(COALESCE(Col01,0)) AS total FROM 2019rems r
                JOIN 2019establecimientos e ON r.IdEstablecimiento = e.Codigo
                WHERE CodigoPrestacion IN (06902700)
                AND r.mes IN (1,2,3,4,5,6,7,8,9,10,11,12)
                AND r.IdEstablecimiento NOT IN (102100,102600,102601,102602,102011)
                GROUP BY NombreComuna, e.alias_estab ORDER BY NombreComuna, e.alias_estab';
        $cantidades = DB::connection('mysql_rem')->select($query);

        foreach($cantidades as $cantidad) {
            if($cantidad->NombreComuna != 'HECTOR REYNO') $data[$cantidad->NombreComuna][12][$cantidad->alias_estab]['ct_marzo'] = $cantidad->total;
            $data[$cantidad->NombreComuna][12]['ct_marzo'] += $cantidad->total;
        }

        $query ='SELECT
                    IF(COD_CENTRO = 102307, "HECTOR REYNO", comuna) AS NombreComuna,
                    COUNT(*) poblacion FROM percapita_pro p
                LEFT JOIN 2019establecimientos e
                ON p.COD_CENTRO = e.Codigo
                WHERE p.AUTORIZADO = "X" AND p.EDAD > 4
                GROUP BY NombreComuna, comuna ORDER BY comuna';
        $poblaciones = DB::connection('mysql_rem')->select($query);

        foreach($poblaciones as $poblacion) {
            $data[$poblacion->NombreComuna][12]['poblacion'] = $poblacion->poblacion;
        }

        /* 13 */
        $query ='SELECT
                    IF(Codigo = "102307", "HECTOR REYNO", comuna) AS NombreComuna, e.alias_estab,
                    SUM(COALESCE(Col01,0) + COALESCE(Col04,0)) AS total FROM 2019rems r
                JOIN 2019establecimientos e ON r.IdEstablecimiento = e.Codigo
                WHERE CodigoPrestacion IN (01030500, 01030600, 01030700, 01030800)
                AND r.mes IN (1,2,3,4,5,6,7,8,9,10,11,12)
                AND r.IdEstablecimiento NOT IN (102100,102600,102601,102602,102011)
                GROUP BY NombreComuna, e.alias_estab ORDER BY NombreComuna, e.alias_estab';
        $cantidades = DB::connection('mysql_rem')->select($query);

        foreach($cantidades as $cantidad) {
            if($cantidad->NombreComuna != 'HECTOR REYNO') $data[$cantidad->NombreComuna][13][$cantidad->alias_estab]['ct_marzo'] = $cantidad->total;
            $data[$cantidad->NombreComuna][13]['ct_marzo'] += $cantidad->total;
        }

        foreach($poblaciones_10a_a_19a as $poblacion) {
            $data[$poblacion->NombreComuna][13]['poblacion'] = $poblacion->poblacion;
        }

        /* 14 */
        $query ='SELECT
                    IF(Codigo = "102307", "HECTOR REYNO", comuna) AS NombreComuna, e.alias_estab,
                    SUM(COALESCE(Col10,0) + COALESCE(Col11,0) + COALESCE(Col12,0) + COALESCE(Col13,0)) AS total FROM 2019rems r
                JOIN 2019establecimientos e ON r.IdEstablecimiento = e.Codigo
                WHERE CodigoPrestacion IN (03020101, 03020201, 03020301, 03020402, 03020403, 03020401, 03040210, 03040220, 04040100, 04025010, 04025020, 04025025, 04040427, 03020501)
                AND r.mes IN (1,2,3,4,5,6,7,8,9,10,11,12)
                AND r.IdEstablecimiento NOT IN (102100,102600,102601,102602,102011)
                GROUP BY NombreComuna, e.alias_estab ORDER BY NombreComuna, e.alias_estab';
        $cantidades = DB::connection('mysql_rem')->select($query);

        foreach($cantidades as $cantidad) {
            if($cantidad->NombreComuna != 'HECTOR REYNO') $data[$cantidad->NombreComuna][14][$cantidad->alias_estab]['ct_marzo'] = $cantidad->total;
            $data[$cantidad->NombreComuna][14]['ct_marzo'] += $cantidad->total;
        }

        foreach($poblaciones_10a_a_19a as $poblacion) {
            $data[$poblacion->NombreComuna][14]['poblacion'] = $poblacion->poblacion;
        }

        /* 15 */
        $query ='SELECT
                    IF(Codigo = "102307", "HECTOR REYNO", comuna) AS NombreComuna, e.alias_estab,
                    SUM(COALESCE(Col02,0) + COALESCE(Col03,0)) AS total FROM 2019rems r
                JOIN 2019establecimientos e ON r.IdEstablecimiento = e.Codigo
                WHERE CodigoPrestacion IN (01080008)
                AND r.mes IN (1,2,3,4,5,6,7,8,9,10,11,12)
                AND r.IdEstablecimiento NOT IN (102100,102600,102601,102602,102011)
                GROUP BY NombreComuna, e.alias_estab ORDER BY NombreComuna, e.alias_estab';
        $cantidades = DB::connection('mysql_rem')->select($query);

        foreach($cantidades as $cantidad) {
            if($cantidad->NombreComuna != 'HECTOR REYNO') $data[$cantidad->NombreComuna][15][$cantidad->alias_estab]['ct_marzo'] = $cantidad->total;
            $data[$cantidad->NombreComuna][15]['ct_marzo'] += $cantidad->total;
        }

        $query ='SELECT
                    IF(COD_CENTRO = 102307, "HECTOR REYNO", comuna) AS NombreComuna,
                    COUNT(*) poblacion FROM percapita_pro p
                LEFT JOIN 2019establecimientos e
                ON p.COD_CENTRO = e.Codigo
                WHERE p.AUTORIZADO = "X" AND p.EDAD BETWEEN 10 AND 19
                AND p.GENERO = "M"
                GROUP BY NombreComuna, comuna ORDER BY comuna';
        $poblaciones = DB::connection('mysql_rem')->select($query);

        foreach($poblaciones as $poblacion) {
            $data[$poblacion->NombreComuna][15]['poblacion'] = $poblacion->poblacion;
        }

        /* 16 */
        $query ='SELECT
                    IF(Codigo = "102307", "HECTOR REYNO", comuna) AS NombreComuna, e.alias_estab,
                    SUM(COALESCE(Col03,0) + COALESCE(Col04,0)) AS total FROM 2019rems r
                JOIN 2019establecimientos e ON r.IdEstablecimiento = e.Codigo
                WHERE CodigoPrestacion IN (01010401, 01010403)
                AND r.mes IN (1,2,3,4,5,6,7,8,9,10,11,12)
                AND r.IdEstablecimiento NOT IN (102100,102600,102601,102602,102011)
                GROUP BY NombreComuna, e.alias_estab ORDER BY NombreComuna, e.alias_estab';
        $cantidades = DB::connection('mysql_rem')->select($query);

        foreach($cantidades as $cantidad) {
            if($cantidad->NombreComuna != 'HECTOR REYNO') $data[$cantidad->NombreComuna][16][$cantidad->alias_estab]['ct_marzo'] = $cantidad->total;
            $data[$cantidad->NombreComuna][16]['ct_marzo'] += $cantidad->total;
        }

        foreach($poblaciones_10a_a_19a as $poblacion) {
            $data[$poblacion->NombreComuna][16]['poblacion'] = $poblacion->poblacion;
        }

        /* 17 */
        $query ='SELECT
                    IF(Codigo = "102307", "HECTOR REYNO", comuna) AS NombreComuna, e.alias_estab,
                    SUM(COALESCE(Col08,0) + COALESCE(Col09,0) + COALESCE(Col10,0) + COALESCE(Col11,0)) AS total FROM 2019rems r
                JOIN 2019establecimientos e ON r.IdEstablecimiento = e.Codigo
                WHERE CodigoPrestacion IN (19120601, 19120602,  19120603, 19120606, 19120608, 19120609, 19120611)
                AND r.mes IN (1,2,3,4,5,6,7,8,9,10,11,12)
                AND r.IdEstablecimiento NOT IN (102100,102600,102601,102602,102011)
                GROUP BY NombreComuna, e.alias_estab ORDER BY NombreComuna, e.alias_estab';
        $cantidades = DB::connection('mysql_rem')->select($query);

        foreach($cantidades as $cantidad) {
            if($cantidad->NombreComuna != 'HECTOR REYNO') $data[$cantidad->NombreComuna][17][$cantidad->alias_estab]['ct_marzo'] = $cantidad->total;
            $data[$cantidad->NombreComuna][17]['ct_marzo'] += $cantidad->total;
        }

        foreach($poblaciones_10a_a_19a as $poblacion) {
            $data[$poblacion->NombreComuna][17]['poblacion'] = $poblacion->poblacion;
        }


        /* 18 */
        $query ='SELECT
                    IF(Codigo = "102307", "HECTOR REYNO", comuna) AS NombreComuna, e.alias_estab,
                    SUM(COALESCE(Col08,0) + COALESCE(Col09,0) + COALESCE(Col10,0) + COALESCE(Col11,0)) AS total FROM 2019rems r
                JOIN 2019establecimientos e ON r.IdEstablecimiento = e.Codigo
                WHERE CodigoPrestacion IN (06020201, 06020208, 06020202, 06020602, 06020206, 06200400, 06904900, 06200500, 06200501, 06905912)
                AND r.mes IN (1,2,3,4,5,6,7,8,9,10,11,12)
                AND r.IdEstablecimiento NOT IN (102100,102600,102601,102602,102011)
                GROUP BY NombreComuna, e.alias_estab ORDER BY NombreComuna, e.alias_estab';
        $cantidades = DB::connection('mysql_rem')->select($query);

        foreach($cantidades as $cantidad) {
            if($cantidad->NombreComuna != 'HECTOR REYNO') $data[$cantidad->NombreComuna][18][$cantidad->alias_estab]['ct_marzo'] = $cantidad->total;
            $data[$cantidad->NombreComuna][18]['ct_marzo'] += $cantidad->total;
        }

        foreach($poblaciones_10a_a_19a as $poblacion) {
            $data[$poblacion->NombreComuna][18]['poblacion'] = $poblacion->poblacion;
        }

        /* 19 */
        $query ='SELECT
                    IF(Codigo = "102307", "HECTOR REYNO", comuna) AS NombreComuna, e.alias_estab,
                    SUM(COALESCE(Col10,0) + COALESCE(Col11,0) + COALESCE(Col12,0) + COALESCE(Col13,0)) AS total FROM 2019rems r
                JOIN 2019establecimientos e ON r.IdEstablecimiento = e.Codigo
                WHERE CodigoPrestacion IN (03020604)
                AND r.mes IN (1,2,3,4,5,6,7,8,9,10,11,12)
                AND r.IdEstablecimiento NOT IN (102100,102600,102601,102602,102011)
                GROUP BY NombreComuna, e.alias_estab ORDER BY NombreComuna, e.alias_estab';
        $cantidades = DB::connection('mysql_rem')->select($query);

        foreach($cantidades as $cantidad) {
            if($cantidad->NombreComuna != 'HECTOR REYNO') $data[$cantidad->NombreComuna][19][$cantidad->alias_estab]['ct_marzo'] = $cantidad->total;
            $data[$cantidad->NombreComuna][19]['ct_marzo'] += $cantidad->total;
        }

        foreach($poblaciones_10a_a_19a as $poblacion) {
            $data[$poblacion->NombreComuna][19]['poblacion'] = $poblacion->poblacion;
        }

        /* 20 */
        $query ='SELECT
                    IF(Codigo = "102307", "HECTOR REYNO", comuna) AS NombreComuna, e.alias_estab,
                    SUM(COALESCE(Col07,0) + COALESCE(Col08,0)) AS total FROM 2019rems r
                JOIN 2019establecimientos e ON r.IdEstablecimiento = e.Codigo
                WHERE CodigoPrestacion IN (27300919,27300920)
                AND r.mes IN (1,2,3,4,5,6,7,8,9,10,11,12)
                AND r.IdEstablecimiento NOT IN (102100,102600,102601,102602,102011)
                GROUP BY NombreComuna, e.alias_estab ORDER BY NombreComuna, e.alias_estab';
        $cantidades = DB::connection('mysql_rem')->select($query);

        foreach($cantidades as $cantidad) {
            if($cantidad->NombreComuna != 'HECTOR REYNO') $data[$cantidad->NombreComuna][20][$cantidad->alias_estab]['ct_marzo'] = $cantidad->total;
            $data[$cantidad->NombreComuna][20]['ct_marzo'] += $cantidad->total;
        }

        foreach($poblaciones_10a_a_19a as $poblacion) {
            $data[$poblacion->NombreComuna][20]['poblacion'] = $poblacion->poblacion;
        }

        /* 21 */
        $query ='SELECT
                    IF(Codigo = "102307", "HECTOR REYNO", comuna) AS NombreComuna, e.alias_estab,
                    SUM(
                        COALESCE(Col14,0) +
                    	COALESCE(Col15,0) +
                    	COALESCE(Col16,0) +
                    	COALESCE(Col17,0) +
                    	COALESCE(Col18,0) +
                    	COALESCE(Col19,0) +
                    	COALESCE(Col20,0) +
                    	COALESCE(Col21,0) +
                    	COALESCE(Col22,0) +
                    	COALESCE(Col23,0) +
                    	COALESCE(Col24,0) +
                    	COALESCE(Col25,0) +
                    	COALESCE(Col26,0) +
                    	COALESCE(Col27,0) +
                    	COALESCE(Col28,0) +
                    	COALESCE(Col29,0) +
                    	COALESCE(Col30,0) +
                    	COALESCE(Col31,0)
                    ) AS total FROM 2019rems r
                 JOIN 2019establecimientos e ON r.IdEstablecimiento = e.Codigo
                 WHERE CodigoPrestacion IN (03020101,03020201,03020301,03020402,03020403,03020401,03040210,03040220,04040100,04025010,04025020,04025025,04040427,03020501)
                 AND r.mes IN (1,2,3,4,5,6,7,8,9,10,11,12)
                 AND r.IdEstablecimiento NOT IN (102100,102600,102601,102602,102011)
                 GROUP BY NombreComuna, e.alias_estab ORDER BY NombreComuna, e.alias_estab';
        $cantidades = DB::connection('mysql_rem')->select($query);

        foreach($cantidades as $cantidad) {
            if($cantidad->NombreComuna != 'HECTOR REYNO') $data[$cantidad->NombreComuna][21][$cantidad->alias_estab]['ct_marzo'] = $cantidad->total;
            $data[$cantidad->NombreComuna][21]['ct_marzo'] += $cantidad->total;
        }

        foreach($poblaciones_20a_a_64a as $poblacion) {
            $data[$poblacion->NombreComuna][21]['poblacion'] = $poblacion->poblacion;
        }

        /* 22 */
        $query ='SELECT
                    IF(Codigo = "102307", "HECTOR REYNO", comuna) AS NombreComuna, e.alias_estab,
                    SUM(
						  COALESCE(Col14,0) +
						  COALESCE(Col15,0) +
						  COALESCE(Col16,0) +
						  COALESCE(Col17,0) +
						  COALESCE(Col18,0) +
						  COALESCE(Col19,0) +
						  COALESCE(Col20,0) +
						  COALESCE(Col21,0) +
						  COALESCE(Col22,0) +
						  COALESCE(Col23,0) +
						  COALESCE(Col24,0) +
						  COALESCE(Col25,0) +
						  COALESCE(Col26,0) +
						  COALESCE(Col27,0) +
						  COALESCE(Col28,0) +
						  COALESCE(Col29,0) +
						  COALESCE(Col30,0) +
						  COALESCE(Col31,0) +
						  COALESCE(Col32,0) +
						  COALESCE(Col33,0) +
						  COALESCE(Col34,0) +
						  COALESCE(Col35,0)) AS total FROM 2019rems r
                JOIN 2019establecimientos e ON r.IdEstablecimiento = e.Codigo
                WHERE CodigoPrestacion IN (23080300,23080400,23080500)
                AND r.mes IN (1,2,3,4,5,6,7,8,9,10,11,12)
                AND r.IdEstablecimiento NOT IN (102100,102600,102601,102602,102011)
                GROUP BY NombreComuna, e.alias_estab ORDER BY NombreComuna, e.alias_estab';
        $cantidades = DB::connection('mysql_rem')->select($query);

        foreach($cantidades as $cantidad) {
            if($cantidad->NombreComuna != 'HECTOR REYNO') $data[$cantidad->NombreComuna][22][$cantidad->alias_estab]['ct_marzo'] = $cantidad->total;
            $data[$cantidad->NombreComuna][22]['ct_marzo'] += $cantidad->total;
        }

        $query ='SELECT
                    IF(COD_CENTRO = 102307, "HECTOR REYNO", comuna) AS NombreComuna,
                    COUNT(*) poblacion FROM percapita_pro p
                LEFT JOIN 2019establecimientos e
                ON p.COD_CENTRO = e.Codigo
                WHERE p.AUTORIZADO = "X" AND p.EDAD > 20
                GROUP BY NombreComuna, comuna ORDER BY comuna';
        $poblaciones = DB::connection('mysql_rem')->select($query);

        foreach($poblaciones as $poblacion) {
            $data[$poblacion->NombreComuna][22]['poblacion'] = $poblacion->poblacion;
        }

        /* 23 */
        $query ='SELECT
                    IF(Codigo = "102307", "HECTOR REYNO", comuna) AS NombreComuna, e.alias_estab,
                    SUM(
                        COALESCE(Col01,0)
                    ) AS total FROM 2019rems r
                JOIN 2019establecimientos e ON r.IdEstablecimiento = e.Codigo
                WHERE CodigoPrestacion IN (27290100,27290200)
                AND r.mes IN (1,2,3,4,5,6,7,8,9,10,11,12)
                AND r.IdEstablecimiento NOT IN (102100,102600,102601,102602,102011)
                GROUP BY NombreComuna, e.alias_estab ORDER BY NombreComuna, e.alias_estab';
        $cantidades = DB::connection('mysql_rem')->select($query);

        foreach($cantidades as $cantidad) {
            if($cantidad->NombreComuna != 'HECTOR REYNO') $data[$cantidad->NombreComuna][23][$cantidad->alias_estab]['ct_marzo'] = $cantidad->total;
            $data[$cantidad->NombreComuna][23]['ct_marzo'] += $cantidad->total;
        }

        foreach($poblaciones_20a_a_64a as $poblacion) {
            $data[$poblacion->NombreComuna][23]['poblacion'] = $poblacion->poblacion;
        }

        /* 24 */
        $query ='SELECT
                    IF(Codigo = "102307", "HECTOR REYNO", comuna) AS NombreComuna, e.alias_estab,
                    SUM(
						  COALESCE(Col07,0) +
						  COALESCE(Col09,0) +
						  COALESCE(Col11,0) +
						  COALESCE(Col13,0) +
						  COALESCE(Col15,0) +
						  COALESCE(Col17,0) +
						  COALESCE(Col19,0) +
						  COALESCE(Col21,0) +
						  COALESCE(Col23,0)
						  ) AS total FROM 2019rems r
                JOIN 2019establecimientos e ON r.IdEstablecimiento = e.Codigo
                WHERE CodigoPrestacion IN (03030330,03030340,03030120,03030130)
                AND r.mes IN (1,2,3,4,5,6,7,8,9,10,11,12)
                AND r.IdEstablecimiento NOT IN (102100,102600,102601,102602,102011)
                GROUP BY NombreComuna, e.alias_estab ORDER BY NombreComuna, e.alias_estab';
        $cantidades = DB::connection('mysql_rem')->select($query);

        foreach($cantidades as $cantidad) {
            if($cantidad->NombreComuna != 'HECTOR REYNO') $data[$cantidad->NombreComuna][24][$cantidad->alias_estab]['ct_marzo'] = $cantidad->total;
            $data[$cantidad->NombreComuna][24]['ct_marzo'] += $cantidad->total;
        }

        $query ='SELECT
                    IF(COD_CENTRO = 102307, "HECTOR REYNO", comuna) AS NombreComuna,
                    COUNT(*) poblacion FROM percapita_pro p
                LEFT JOIN 2019establecimientos e
                ON p.COD_CENTRO = e.Codigo
                WHERE p.AUTORIZADO = "X" AND p.EDAD BETWEEN 20 AND 64
                AND p.GENERO = "M"
                GROUP BY NombreComuna, comuna ORDER BY comuna';
        $poblaciones = DB::connection('mysql_rem')->select($query);

        foreach($poblaciones as $poblacion) {
            $data[$poblacion->NombreComuna][24]['poblacion'] = $poblacion->poblacion;
        }

        /* 25 */
        $query ='SELECT
                    IF(Codigo = "102307", "HECTOR REYNO", comuna) AS NombreComuna, e.alias_estab,
                    SUM(
						  COALESCE(Col14,0) +
						  COALESCE(Col15,0) +
						  COALESCE(Col16,0) +
						  COALESCE(Col17,0) +
						  COALESCE(Col18,0) +
						  COALESCE(Col19,0) +
						  COALESCE(Col20,0) +
						  COALESCE(Col21,0) +
						  COALESCE(Col22,0) +
						  COALESCE(Col23,0) +
						  COALESCE(Col24,0) +
						  COALESCE(Col25,0) +
						  COALESCE(Col26,0) +
						  COALESCE(Col27,0) +
						  COALESCE(Col28,0) +
						  COALESCE(Col29,0) +
						  COALESCE(Col30,0) +
						  COALESCE(Col31,0)
						  ) AS total FROM 2019rems r
                JOIN 2019establecimientos e ON r.IdEstablecimiento = e.Codigo
                WHERE CodigoPrestacion IN (03020604)
                AND r.mes IN (1,2,3,4,5,6,7,8,9,10,11,12)
                AND r.IdEstablecimiento NOT IN (102100,102600,102601,102602,102011)
                GROUP BY NombreComuna, e.alias_estab ORDER BY NombreComuna, e.alias_estab';
        $cantidades = DB::connection('mysql_rem')->select($query);

        foreach($cantidades as $cantidad) {
            if($cantidad->NombreComuna != 'HECTOR REYNO') $data[$cantidad->NombreComuna][25][$cantidad->alias_estab]['ct_marzo'] = $cantidad->total;
            $data[$cantidad->NombreComuna][25]['ct_marzo'] += $cantidad->total;
        }

        foreach($poblaciones_20a_a_64a as $poblacion) {
            $data[$poblacion->NombreComuna][25]['poblacion'] = $poblacion->poblacion;
        }

        /* 26 */
        $query ='SELECT
                    IF(Codigo = "102307", "HECTOR REYNO", comuna) AS NombreComuna, e.alias_estab,
                    SUM(COALESCE(Col08,0)) AS total FROM 2019rems r
                JOIN 2019establecimientos e ON r.IdEstablecimiento = e.Codigo
                WHERE CodigoPrestacion IN (19140501,19140503)
                AND r.mes IN (1,2,3,4,5,6,7,8,9,10,11,12)
                AND r.IdEstablecimiento NOT IN (102100,102600,102601,102602,102011)
                GROUP BY NombreComuna, e.alias_estab ORDER BY NombreComuna, e.alias_estab';
        $cantidades = DB::connection('mysql_rem')->select($query);

        foreach($cantidades as $cantidad) {
            if($cantidad->NombreComuna != 'HECTOR REYNO') $data[$cantidad->NombreComuna][26][$cantidad->alias_estab]['ct_marzo'] = $cantidad->total;
            $data[$cantidad->NombreComuna][26]['ct_marzo'] += $cantidad->total;
        }

        foreach($poblaciones_20a_a_64a as $poblacion) {
            $data[$poblacion->NombreComuna][26]['poblacion'] = $poblacion->poblacion;
        }

        /* 27 */
        $query ='SELECT
                    IF(Codigo = "102307", "HECTOR REYNO", comuna) AS NombreComuna, e.alias_estab,
                    SUM(
                        COALESCE(Col32,0) +
                    	COALESCE(Col33,0) +
                    	COALESCE(Col34,0) +
                    	COALESCE(Col35,0) +
                    	COALESCE(Col36,0) +
                    	COALESCE(Col37,0) +
                    	COALESCE(Col38,0) +
                    	COALESCE(Col39,0)
                    ) AS total FROM 2019rems r
                 JOIN 2019establecimientos e ON r.IdEstablecimiento = e.Codigo
                 WHERE CodigoPrestacion IN (03020101,03020201,03020301,03020402,03020403,03020401,03040210,03040220,04040100,04025010,04025020,04025025,04040427,03020501)
                 AND r.mes IN (1,2,3,4,5,6,7,8,9,10,11,12)
                 AND r.IdEstablecimiento NOT IN (102100,102600,102601,102602,102011)
                 GROUP BY NombreComuna, e.alias_estab ORDER BY NombreComuna, e.alias_estab';
        $cantidades = DB::connection('mysql_rem')->select($query);

        foreach($cantidades as $cantidad) {
            if($cantidad->NombreComuna != 'HECTOR REYNO') $data[$cantidad->NombreComuna][27][$cantidad->alias_estab]['ct_marzo'] = $cantidad->total;
            $data[$cantidad->NombreComuna][27]['ct_marzo'] += $cantidad->total;
        }

        foreach($poblaciones_mayor_64a as $poblacion) {
            $data[$poblacion->NombreComuna][27]['poblacion'] = $poblacion->poblacion;
        }

        /* 28 */
        $query ='SELECT
                    IF(Codigo = "102307", "HECTOR REYNO", comuna) AS NombreComuna, e.alias_estab,
                    SUM(
						  COALESCE(Col32,0) +
						  COALESCE(Col33,0) +
						  COALESCE(Col34,0) +
						  COALESCE(Col35,0) +
						  COALESCE(Col36,0) +
						  COALESCE(Col37,0) +
						  COALESCE(Col38,0) +
						  COALESCE(Col39,0)
						  ) AS total FROM 2019rems r
                JOIN 2019establecimientos e ON r.IdEstablecimiento = e.Codigo
                WHERE CodigoPrestacion IN (03020604)
                AND r.mes IN (1,2,3,4,5,6,7,8,9,10,11,12)
                AND r.IdEstablecimiento NOT IN (102100,102600,102601,102602,102011)
                GROUP BY NombreComuna, e.alias_estab ORDER BY NombreComuna, e.alias_estab';
        $cantidades = DB::connection('mysql_rem')->select($query);

        foreach($cantidades as $cantidad) {
            if($cantidad->NombreComuna != 'HECTOR REYNO') $data[$cantidad->NombreComuna][28][$cantidad->alias_estab]['ct_marzo'] = $cantidad->total;
            $data[$cantidad->NombreComuna][28]['ct_marzo'] += $cantidad->total;
        }

        foreach($poblaciones_mayor_64a as $poblacion) {
            $data[$poblacion->NombreComuna][28]['poblacion'] = $poblacion->poblacion;
        }

        /* 29 */
        $query ='SELECT
                    IF(Codigo = "102307", "HECTOR REYNO", comuna) AS NombreComuna, e.alias_estab,
                    SUM(COALESCE(Col32,0) + COALESCE(Col33,0) + COALESCE(Col34,0) +
                        COALESCE(Col35,0) + COALESCE(Col36,0) + COALESCE(Col37,0) +
                        COALESCE(Col38,0) + COALESCE(Col39,0))
                        AS total FROM 2019rems r
                JOIN 2019establecimientos e ON r.IdEstablecimiento = e.Codigo
                WHERE CodigoPrestacion IN (03020604)
                AND r.mes IN (1,2,3,4,5,6,7,8,9,10,11,12)
                AND r.IdEstablecimiento NOT IN (102100,102600,102601,102602,102011)
                GROUP BY NombreComuna, e.alias_estab ORDER BY NombreComuna, e.alias_estab';
        $cantidades = DB::connection('mysql_rem')->select($query);

        foreach($cantidades as $cantidad) {
            if($cantidad->NombreComuna != 'HECTOR REYNO') $data[$cantidad->NombreComuna][29][$cantidad->alias_estab]['ct_marzo'] = $cantidad->total;
            $data[$cantidad->NombreComuna][29]['ct_marzo'] += $cantidad->total;
        }

        foreach($poblaciones_mayor_64a as $poblacion) {
            $data[$poblacion->NombreComuna][29]['poblacion'] = $poblacion->poblacion;
        }

        /* 30 */
        // $query ='SELECT
        //             IF(Codigo = "102307", "HECTOR REYNO", comuna) AS NombreComuna,
        //             SUM(COALESCE(Col30,0) + COALESCE(Col31,0) + COALESCE(Col32,0) +
        //                 COALESCE(Col33,0) + COALESCE(Col34,0) + COALESCE(Col35,0) +
        //                 COALESCE(Col36,0) + COALESCE(Col37,0))
        //                 AS total FROM 2019rems r
        //         JOIN 2019establecimientos e ON r.IdEstablecimiento = e.Codigo
        //         WHERE CodigoPrestacion IN ("01030100A", "01030200B")
        //         AND r.mes IN (1,2,3,4,5,6,7,8,9,10,11,12)
        //         AND r.IdEstablecimiento NOT IN (102100,102600,102601,102602,102011)
        //         GROUP BY NombreComuna ORDER BY NombreComuna';
        // $cantidades = DB::connection('mysql_rem')->select($query);
        //
        // foreach($cantidades as $cantidad) {
        //     $data[$cantidad->NombreComuna][30]['ct_marzo'] = $cantidad->total;
        // }
        $data['IQUIQUE'][30]['ct_marzo'] = 55768;
        $data['ALTO HOSPICIO'][30]['ct_marzo'] = 24748;
        $data['PICA'][30]['ct_marzo'] = 1586;
        $data['POZO ALMONTE'][30]['ct_marzo'] = 3446;
        $data['HUARA'][30]['ct_marzo'] = 1003;
        $data['CAMIÑA'][30]['ct_marzo'] = 455;
        $data['COLCHANE'][30]['ct_marzo'] = 244;
        $data['HECTOR REYNO'][30]['ct_marzo'] = 2910;


        $query ='SELECT
                    IF(COD_CENTRO = 102307, "HECTOR REYNO", comuna) AS NombreComuna,
                    COUNT(*) poblacion FROM percapita_pro p
                LEFT JOIN 2019establecimientos e
                ON p.COD_CENTRO = e.Codigo
                WHERE p.AUTORIZADO = "X"
                GROUP BY NombreComuna, comuna ORDER BY comuna';
        $poblaciones = DB::connection('mysql_rem')->select($query);

        foreach($poblaciones as $poblacion) {
            $data[$poblacion->NombreComuna][30]['poblacion'] = $poblacion->poblacion;
            $data[$poblacion->NombreComuna][32]['poblacion'] = $poblacion->poblacion;
            // $data[$poblacion->NombreComuna][38]['poblacion'] = $poblacion->poblacion;
            $data[$poblacion->NombreComuna][39]['poblacion'] = $poblacion->poblacion;
            $data[$poblacion->NombreComuna][46]['poblacion'] = $poblacion->poblacion;
            $data[$poblacion->NombreComuna][47]['poblacion'] = $poblacion->poblacion;
            $data[$poblacion->NombreComuna][48]['poblacion'] = $poblacion->poblacion;
        }


        /* 31 */
        $query ='SELECT
                    IF(Codigo = "102307", "HECTOR REYNO", comuna) AS NombreComuna, e.alias_estab,
                    SUM(COALESCE(Col26,0) + COALESCE(Col27,0)) AS total FROM 2019rems r
                JOIN 2019establecimientos e ON r.IdEstablecimiento = e.Codigo
                WHERE CodigoPrestacion IN (09400082)
                AND r.mes IN (1,2,3,4,5,6,7,8,9,10,11,12)
                AND r.IdEstablecimiento NOT IN (102100,102600,102601,102602,102011)
                GROUP BY NombreComuna, e.alias_estab ORDER BY NombreComuna, e.alias_estab';
        $cantidades = DB::connection('mysql_rem')->select($query);

        foreach($cantidades as $cantidad) {
            if($cantidad->NombreComuna != 'HECTOR REYNO') $data[$cantidad->NombreComuna][31][$cantidad->alias_estab]['ct_marzo'] = $cantidad->total;
            $data[$cantidad->NombreComuna][31]['ct_marzo'] += $cantidad->total;
        }

        foreach($poblaciones_mayor_64a as $poblacion) {
            $data[$poblacion->NombreComuna][31]['poblacion'] = $poblacion->poblacion;
        }

        /* 32 */
        $query ='SELECT
                    IF(Codigo = "102307", "HECTOR REYNO", comuna) AS NombreComuna, e.alias_estab,
                    SUM(COALESCE(Col01,0)) AS total FROM 2019rems r
                JOIN 2019establecimientos e ON r.IdEstablecimiento = e.Codigo
                WHERE CodigoPrestacion IN (09201713)
                AND r.mes IN (1,2,3,4,5,6,7,8,9,10,11,12)
                AND r.IdEstablecimiento NOT IN (102100,102600,102601,102602,102011)
                GROUP BY NombreComuna, e.alias_estab ORDER BY NombreComuna, e.alias_estab';
        $cantidades = DB::connection('mysql_rem')->select($query);

        foreach($cantidades as $cantidad) {
            if($cantidad->NombreComuna != 'HECTOR REYNO') $data[$cantidad->NombreComuna][32][$cantidad->alias_estab]['ct_marzo'] = $cantidad->total;
            $data[$cantidad->NombreComuna][32]['ct_marzo'] += $cantidad->total;
        }


        /* 33 */
        $query ='SELECT
                    IF(Codigo = "102307", "HECTOR REYNO", comuna) AS NombreComuna, e.alias_estab,
                    SUM(COALESCE(Col04,0) + COALESCE(Col05,0) + COALESCE(Col06,0) +
                        COALESCE(Col07,0) + COALESCE(Col08,0) + COALESCE(Col09,0))
                        AS total FROM 2019rems r
                JOIN 2019establecimientos e ON r.IdEstablecimiento = e.Codigo
                WHERE CodigoPrestacion IN (01080008)
                AND r.mes IN (1,2,3,4,5,6,7,8,9,10,11,12)
                AND r.IdEstablecimiento NOT IN (102100,102600,102601,102602,102011)
                GROUP BY NombreComuna, e.alias_estab ORDER BY NombreComuna, e.alias_estab';
        $cantidades = DB::connection('mysql_rem')->select($query);

        foreach($cantidades as $cantidad) {
            if($cantidad->NombreComuna != 'HECTOR REYNO') $data[$cantidad->NombreComuna][33][$cantidad->alias_estab]['ct_marzo'] = $cantidad->total;
            $data[$cantidad->NombreComuna][33]['ct_marzo'] += $cantidad->total;
        }

        $query ='SELECT
                    IF(COD_CENTRO = 102307, "HECTOR REYNO", comuna) AS NombreComuna,
                    COUNT(*) poblacion FROM percapita_pro p
                LEFT JOIN 2019establecimientos e
                ON p.COD_CENTRO = e.Codigo
                WHERE p.AUTORIZADO = "X" AND p.EDAD BETWEEN 20 AND 49
                AND p.GENERO = "M"
                GROUP BY NombreComuna, comuna ORDER BY comuna';
        $poblaciones_20a_a_49a_m = DB::connection('mysql_rem')->select($query);

        foreach($poblaciones_20a_a_49a_m as $poblacion) {
            $data[$poblacion->NombreComuna][33]['poblacion'] = $poblacion->poblacion;
        }


        /* 34 */
        $query ='SELECT
                    IF(Codigo = "102307", "HECTOR REYNO", comuna) AS NombreComuna, e.alias_estab,
                    SUM(COALESCE(Col04,0) + COALESCE(Col05,0) + COALESCE(Col06,0) +
                        COALESCE(Col07,0) + COALESCE(Col08,0) + COALESCE(Col09,0) +
                        COALESCE(Col10,0) + COALESCE(Col11,0))
                        AS total FROM 2019rems r
                JOIN 2019establecimientos e ON r.IdEstablecimiento = e.Codigo
                WHERE CodigoPrestacion IN (01080011, 05810443, 01080021, 01080022, 01080023, 01090060, 01080024, 01080013, 01080014)
                AND r.mes IN (1,2,3,4,5,6,7,8,9,10,11,12)
                AND r.IdEstablecimiento NOT IN (102100,102600,102601,102602,102011)
                GROUP BY NombreComuna, e.alias_estab ORDER BY NombreComuna, e.alias_estab';
        $cantidades = DB::connection('mysql_rem')->select($query);

        foreach($cantidades as $cantidad) {
            if($cantidad->NombreComuna != 'HECTOR REYNO') $data[$cantidad->NombreComuna][34][$cantidad->alias_estab]['ct_marzo'] = $cantidad->total;
            $data[$cantidad->NombreComuna][34]['ct_marzo'] += $cantidad->total;
        }

        $query ='SELECT
                    IF(COD_CENTRO = 102307, "HECTOR REYNO", comuna) AS NombreComuna,
                    COUNT(*) poblacion FROM percapita_pro p
                LEFT JOIN 2019establecimientos e
                ON p.COD_CENTRO = e.Codigo
                WHERE p.AUTORIZADO = "X" AND p.EDAD >= 20
                AND p.GENERO = "M"
                GROUP BY NombreComuna, comuna ORDER BY comuna';
        $poblaciones = DB::connection('mysql_rem')->select($query);

        foreach($poblaciones as $poblacion) {
            $data[$poblacion->NombreComuna][34]['poblacion'] = $poblacion->poblacion;
        }


        /* 35 */
        $query ='SELECT
                IF(Codigo = "102307", "HECTOR REYNO", comuna) AS NombreComuna, e.alias_estab,
                SUM(COALESCE(Col13,0) + COALESCE(Col15,0) + COALESCE(Col17,0) +
                    COALESCE(Col19,0) + COALESCE(Col21,0) + COALESCE(Col23,0))
                    AS total FROM 2019rems r
                JOIN 2019establecimientos e ON r.IdEstablecimiento = e.Codigo
                WHERE CodigoPrestacion IN (19120601, 19120602, 19120603, 19120606, 19120608, 19120609, 19120611)
                AND r.mes IN (1,2,3,4,5,6,7,8,9,10,11,12)
                AND r.IdEstablecimiento NOT IN (102100,102600,102601,102602,102011)
                GROUP BY NombreComuna, e.alias_estab ORDER BY NombreComuna, e.alias_estab';
        $cantidades = DB::connection('mysql_rem')->select($query);

        foreach($cantidades as $cantidad) {
            if($cantidad->NombreComuna != 'HECTOR REYNO') $data[$cantidad->NombreComuna][35][$cantidad->alias_estab]['ct_marzo'] = $cantidad->total;
            $data[$cantidad->NombreComuna][35]['ct_marzo'] += $cantidad->total;
        }

        foreach($poblaciones_20a_a_49a_m as $poblacion) {
            $data[$poblacion->NombreComuna][35]['poblacion'] = $poblacion->poblacion;
        }

        /* 36 */
        $query ='SELECT
                IF(Codigo = "102307", "HECTOR REYNO", comuna) AS NombreComuna, e.alias_estab,
                SUM(COALESCE(Col05,0) + COALESCE(Col06,0) + COALESCE(Col07,0) +
                    COALESCE(Col08,0) + COALESCE(Col09,0) + COALESCE(Col10,0) +
                    COALESCE(Col11,0) + COALESCE(Col12,0) + COALESCE(Col13,0))
                    AS total FROM 2019rems r
                JOIN 2019establecimientos e ON r.IdEstablecimiento = e.Codigo
                WHERE CodigoPrestacion IN (01010601, 01010603)
                AND r.mes IN (1,2,3,4,5,6,7,8,9,10,11,12)
                AND r.IdEstablecimiento NOT IN (102100,102600,102601,102602,102011)
                GROUP BY NombreComuna, e.alias_estab ORDER BY NombreComuna, e.alias_estab';
        $cantidades = DB::connection('mysql_rem')->select($query);

        foreach($cantidades as $cantidad) {
            if($cantidad->NombreComuna != 'HECTOR REYNO') $data[$cantidad->NombreComuna][36][$cantidad->alias_estab]['ct_marzo'] = $cantidad->total;
            $data[$cantidad->NombreComuna][36]['ct_marzo'] += $cantidad->total;
        }

        $query ='SELECT
                    IF(COD_CENTRO = 102307, "HECTOR REYNO", comuna) AS NombreComuna,
                    COUNT(*) poblacion FROM percapita_pro p
                LEFT JOIN 2019establecimientos e
                ON p.COD_CENTRO = e.Codigo
                WHERE p.AUTORIZADO = "X" AND p.EDAD BETWEEN 20 AND 64
                AND p.GENERO = "M"
                GROUP BY NombreComuna, comuna ORDER BY comuna';
        $poblaciones = DB::connection('mysql_rem')->select($query);

        foreach($poblaciones as $poblacion) {
            $data[$poblacion->NombreComuna][36]['poblacion'] = $poblacion->poblacion;
        }


        /* 37 */
        $query ='SELECT
               IF(Codigo = "102307", "HECTOR REYNO", comuna) AS NombreComuna, e.alias_estab,
               SUM(COALESCE(Col09,0) + COALESCE(Col10,0) + COALESCE(Col11,0) + COALESCE(Col12,0) + COALESCE(Col13,0)) AS total FROM 2019rems r
                JOIN 2019establecimientos e ON r.IdEstablecimiento = e.Codigo
                WHERE CodigoPrestacion IN (01010901, 01010903)
                AND r.mes IN (1,2,3,4,5,6,7,8,9,10,11,12)
                AND r.IdEstablecimiento NOT IN (102100,102600,102601,102602,102011)
                GROUP BY NombreComuna, e.alias_estab ORDER BY NombreComuna, e.alias_estab';
        $cantidades = DB::connection('mysql_rem')->select($query);

        foreach($cantidades as $cantidad) {
            if($cantidad->NombreComuna != 'HECTOR REYNO') $data[$cantidad->NombreComuna][37][$cantidad->alias_estab]['ct_marzo'] = $cantidad->total;
            $data[$cantidad->NombreComuna][37]['ct_marzo'] += $cantidad->total;
        }

        $query ='SELECT
                    IF(COD_CENTRO = 102307, "HECTOR REYNO", comuna) AS NombreComuna,
                    COUNT(*) poblacion FROM percapita_pro p
                LEFT JOIN 2019establecimientos e
                ON p.COD_CENTRO = e.Codigo
                WHERE p.AUTORIZADO = "X" AND p.EDAD BETWEEN 45 AND 64
                AND p.GENERO = "M"
                GROUP BY NombreComuna, comuna ORDER BY comuna';
        $poblaciones = DB::connection('mysql_rem')->select($query);

        foreach($poblaciones as $poblacion) {
            $data[$poblacion->NombreComuna][37]['poblacion'] = $poblacion->poblacion;
        }


        /* 38 */
        $query ='SELECT
               IF(Codigo = "102307", "HECTOR REYNO", comuna) AS NombreComuna, e.alias_estab,
               SUM(COALESCE(Col01,0)) AS total FROM 2019rems r
                JOIN 2019establecimientos e ON r.IdEstablecimiento = e.Codigo
                WHERE CodigoPrestacion IN (19140700, 19140800, 19140900, 19150100, 19150200, 19150300, 19150400, 19150500, 19190100)
                AND r.mes IN (1,2,3,4,5,6,7,8,9,10,11,12)
                AND r.IdEstablecimiento NOT IN (102100,102600,102601,102602,102011)
                GROUP BY NombreComuna, e.alias_estab ORDER BY NombreComuna, e.alias_estab';
        $cantidades = DB::connection('mysql_rem')->select($query);

        foreach($cantidades as $cantidad) {
            if($cantidad->NombreComuna != 'HECTOR REYNO') $data[$cantidad->NombreComuna][38][$cantidad->alias_estab]['ct_marzo'] = $cantidad->total;
            $data[$cantidad->NombreComuna][38]['ct_marzo'] += $cantidad->total;
        }

        $query ='SELECT
               IF(Codigo = "102307", "HECTOR REYNO", comuna) AS NombreComuna,
               SUM(COALESCE(Col01,0)) AS total FROM 2019rems r
                JOIN 2019establecimientos e ON r.IdEstablecimiento = e.Codigo
                WHERE CodigoPrestacion IN ("P7010100", "P7010400") AND Ano = 2019
                GROUP BY NombreComuna ORDER BY NombreComuna';
        $poblaciones = DB::connection('mysql_rem')->select($query);

        foreach($poblaciones as $poblacion) {
            $data[$poblacion->NombreComuna][38]['poblacion'] = $poblacion->total;
        }


        /* 39 */
        $query ='SELECT
                    IF(Codigo = "102307", "HECTOR REYNO", comuna) AS NombreComuna, e.alias_estab,
                    SUM(
						  COALESCE(Col01,0)
						  ) AS total FROM 2019rems r
                JOIN 2019establecimientos e ON r.IdEstablecimiento = e.Codigo
                WHERE CodigoPrestacion IN (26261000,26260100,26273101,26274000,26291000,26291050,26291100,26273102,26274600,26262300,26273103,26273105,26274200,26280010,26262400,
					 26291150,26291200,26291250,26291300,26280020,26273106,26274400,26261400,26273107,26274601,26300100,26300110,26260600,26261800,26261900,26273109,26275400,26275500,
					 26275600,26273110,26262100,26300120,26300130)
                AND r.mes IN (1,2,3,4,5,6,7,8,9,10,11,12)
                AND r.IdEstablecimiento NOT IN (102100,102600,102601,102602,102011)
                GROUP BY NombreComuna, e.alias_estab ORDER BY NombreComuna, e.alias_estab';
        $cantidades = DB::connection('mysql_rem')->select($query);

        foreach($cantidades as $cantidad) {
            if($cantidad->NombreComuna != 'HECTOR REYNO') $data[$cantidad->NombreComuna][39][$cantidad->alias_estab]['ct_marzo'] = $cantidad->total;
            $data[$cantidad->NombreComuna][39]['ct_marzo'] += $cantidad->total;
        }

        /* 40 */
        $query ='SELECT
                    IF(Codigo = "102307", "HECTOR REYNO", comuna) AS NombreComuna, e.alias_estab,
                    SUM(
						  COALESCE(Col02,0)
						  ) AS total FROM 2019rems r
                JOIN 2019establecimientos e ON r.IdEstablecimiento = e.Codigo
                WHERE CodigoPrestacion IN (23046200)
                AND r.mes IN (1,2,3,4,5,6,7,8,9,10,11,12)
                AND r.IdEstablecimiento NOT IN (102100,102600,102601,102602,102011)
                GROUP BY NombreComuna, e.alias_estab ORDER BY NombreComuna, e.alias_estab';
        $cantidades = DB::connection('mysql_rem')->select($query);

        foreach($cantidades as $cantidad) {
            if($cantidad->NombreComuna != 'HECTOR REYNO') $data[$cantidad->NombreComuna][40][$cantidad->alias_estab]['ct_marzo'] = $cantidad->total;
            $data[$cantidad->NombreComuna][40]['ct_marzo'] += $cantidad->total;
        }

        $query ='SELECT
                    IF(COD_CENTRO = 102307, "HECTOR REYNO", comuna) AS NombreComuna,
                    COUNT(*) poblacion FROM percapita_pro p
                LEFT JOIN 2019establecimientos e
                ON p.COD_CENTRO = e.Codigo
                WHERE p.AUTORIZADO = "X" AND p.EDAD > 40
                GROUP BY NombreComuna, comuna ORDER BY comuna';
        $poblaciones = DB::connection('mysql_rem')->select($query);

        foreach($poblaciones as $poblacion) {
            $data[$poblacion->NombreComuna][40]['poblacion'] = $poblacion->poblacion;
        }


        /* 41 */
        $query ='SELECT
               IF(Codigo = "102307", "HECTOR REYNO", comuna) AS NombreComuna, e.alias_estab,
               SUM(COALESCE(Col01,0)) AS total FROM 2019rems r
                JOIN 2019establecimientos e ON r.IdEstablecimiento = e.Codigo
                WHERE CodigoPrestacion IN (09230500)
                AND r.mes IN (1,2,3,4,5,6,7,8,9,10,11,12)
                AND r.IdEstablecimiento NOT IN (102100,102600,102601,102602,102011)
                GROUP BY NombreComuna, e.alias_estab ORDER BY NombreComuna, e.alias_estab';
        $cantidades = DB::connection('mysql_rem')->select($query);

        foreach($cantidades as $cantidad) {
            if($cantidad->NombreComuna != 'HECTOR REYNO') $data[$cantidad->NombreComuna][41][$cantidad->alias_estab]['ct_marzo'] = $cantidad->total;
            $data[$cantidad->NombreComuna][41]['ct_marzo'] += $cantidad->total;
        }

        $query ='SELECT
                    IF(COD_CENTRO = 102307, "HECTOR REYNO", comuna) AS NombreComuna,
                    COUNT(*) poblacion FROM percapita_pro p
                LEFT JOIN 2019establecimientos e
                ON p.COD_CENTRO = e.Codigo
                WHERE p.AUTORIZADO = "X" AND p.EDAD >= 12
                GROUP BY NombreComuna, comuna ORDER BY comuna';
        $poblaciones = DB::connection('mysql_rem')->select($query);

        foreach($poblaciones as $poblacion) {
            $data[$poblacion->NombreComuna][41]['poblacion'] = $poblacion->poblacion;
        }


        /* 42 */
        $query ='SELECT
               IF(Codigo = "102307", "HECTOR REYNO", comuna) AS NombreComuna, e.alias_estab,
               SUM(COALESCE(Col01,0)) AS total FROM 2019rems r
                JOIN 2019establecimientos e ON r.IdEstablecimiento = e.Codigo
                WHERE CodigoPrestacion IN (19120701, 19120702, 19120703, 19120706, 19120708, 19120709,  19120711)
                AND r.mes IN (1,2,3,4,5,6,7,8,9,10,11,12)
                AND r.IdEstablecimiento NOT IN (102100,102600,102601,102602,102011)
                GROUP BY NombreComuna, e.alias_estab ORDER BY NombreComuna, e.alias_estab';
        $cantidades = DB::connection('mysql_rem')->select($query);

        foreach($cantidades as $cantidad) {
            if($cantidad->NombreComuna != 'HECTOR REYNO') $data[$cantidad->NombreComuna][42][$cantidad->alias_estab]['ct_marzo'] = $cantidad->total;
            $data[$cantidad->NombreComuna][42]['ct_marzo'] += $cantidad->total;
        }

        $query ='SELECT
                    IF(COD_CENTRO = 102307, "HECTOR REYNO", comuna) AS NombreComuna,
                    COUNT(*) poblacion FROM percapita_pro p
                LEFT JOIN 2019establecimientos e
                ON p.COD_CENTRO = e.Codigo
                WHERE p.AUTORIZADO = "X" AND p.EDAD >= 10
                GROUP BY NombreComuna, comuna ORDER BY comuna';
        $poblaciones = DB::connection('mysql_rem')->select($query);

        foreach($poblaciones as $poblacion) {
            $data[$poblacion->NombreComuna][42]['poblacion'] = $poblacion->poblacion;
        }

        /* 43 */
        $query ='SELECT
                    IF(Codigo = "102307", "HECTOR REYNO", comuna) AS NombreComuna, e.alias_estab,
                    SUM(
						  COALESCE(Col01,0)
						  ) AS total FROM 2019rems r
                JOIN 2019establecimientos e ON r.IdEstablecimiento = e.Codigo
                WHERE CodigoPrestacion IN ("P7200500")
                AND r.mes IN (6)
                AND r.IdEstablecimiento NOT IN (102100,102600,102601,102602,102011)
                GROUP BY NombreComuna, e.alias_estab ORDER BY NombreComuna, e.alias_estab';
        $cantidades = DB::connection('mysql_rem')->select($query);

        foreach($cantidades as $cantidad) {
            if($cantidad->NombreComuna != 'HECTOR REYNO') $data[$cantidad->NombreComuna][43][$cantidad->alias_estab]['ct_marzo'] = $cantidad->total;
            $data[$cantidad->NombreComuna][43]['ct_marzo'] += $cantidad->total;
        }

        $query ='SELECT
               IF(Codigo = "102307", "HECTOR REYNO", comuna) AS NombreComuna,
               SUM(COALESCE(Col01,0)) AS total FROM 2019rems r
                JOIN 2019establecimientos e ON r.IdEstablecimiento = e.Codigo
                WHERE CodigoPrestacion IN ("P7200500") AND Ano = 2019
                GROUP BY NombreComuna ORDER BY NombreComuna';
        $poblaciones = DB::connection('mysql_rem')->select($query);

        foreach($poblaciones as $poblacion) {
            $data[$poblacion->NombreComuna][43]['poblacion'] = $poblacion->total;
        }


        /* 44 */
        $query ='SELECT
               IF(Codigo = "102307", "HECTOR REYNO", comuna) AS NombreComuna, e.alias_estab,
               SUM(COALESCE(Col01,0)) AS total FROM 2019rems r
                JOIN 2019establecimientos e ON r.IdEstablecimiento = e.Codigo
                WHERE CodigoPrestacion IN (16100300, 16200220, 16100600, 16100700, 16100100)
                AND r.mes IN (1,2,3,4,5,6,7,8,9,10,11,12)
                AND r.IdEstablecimiento NOT IN (102100,102600,102601,102602,102011)
                GROUP BY NombreComuna, e.alias_estab ORDER BY NombreComuna, e.alias_estab';
        $cantidades = DB::connection('mysql_rem')->select($query);

        foreach($cantidades as $cantidad) {
            if($cantidad->NombreComuna != 'HECTOR REYNO') $data[$cantidad->NombreComuna][44][$cantidad->alias_estab]['ct_marzo'] = $cantidad->total;
            $data[$cantidad->NombreComuna][44]['ct_marzo'] += $cantidad->total;
        }

        $query ='SELECT
                    IF(COD_CENTRO = 102307, "HECTOR REYNO", comuna) AS NombreComuna,
                    COUNT(*) poblacion FROM percapita_pro p
                LEFT JOIN 2019establecimientos e
                ON p.COD_CENTRO = e.Codigo
                WHERE p.AUTORIZADO = "X" AND p.EDAD >= 65
                GROUP BY NombreComuna, comuna ORDER BY comuna';
        $poblaciones = DB::connection('mysql_rem')->select($query);

        foreach($poblaciones as $poblacion) {
            $data[$poblacion->NombreComuna][44]['poblacion'] = $poblacion->poblacion;
        }


        /* 45 */
        $query ='SELECT
               IF(Codigo = "102307", "HECTOR REYNO", comuna) AS NombreComuna, e.alias_estab,
               SUM(COALESCE(Col01,0)) AS total FROM 2019rems r
                JOIN 2019establecimientos e ON r.IdEstablecimiento = e.Codigo
                WHERE CodigoPrestacion IN (03500361)
                AND r.mes IN (1,2,3,4,5,6,7,8,9,10,11,12)
                AND r.IdEstablecimiento NOT IN (102100,102600,102601,102602,102011)
                GROUP BY NombreComuna, e.alias_estab ORDER BY NombreComuna, e.alias_estab';
        $cantidades = DB::connection('mysql_rem')->select($query);

        foreach($cantidades as $cantidad) {
            if($cantidad->NombreComuna != 'HECTOR REYNO') $data[$cantidad->NombreComuna][45][$cantidad->alias_estab]['ct_marzo'] = $cantidad->total;
            $data[$cantidad->NombreComuna][45]['ct_marzo'] += $cantidad->total;
        }

        $query ='SELECT
                    IF(COD_CENTRO = 102307, "HECTOR REYNO", comuna) AS NombreComuna,
                    COUNT(*) poblacion FROM percapita_pro p
                LEFT JOIN 2019establecimientos e
                ON p.COD_CENTRO = e.Codigo
                WHERE p.AUTORIZADO = "X" AND p.EDAD = 65
                GROUP BY NombreComuna, comuna ORDER BY comuna';
        $poblaciones = DB::connection('mysql_rem')->select($query);

        foreach($poblaciones as $poblacion) {
            $data[$poblacion->NombreComuna][45]['poblacion'] = $poblacion->poblacion;
        }


        /* 46 */
        $query ='SELECT
                    IF(Codigo = "102307", "HECTOR REYNO", comuna) AS NombreComuna, e.alias_estab,
                    SUM(
						  COALESCE(Col01,0)
						  ) AS total FROM 2019rems r
                JOIN 2019establecimientos e ON r.IdEstablecimiento = e.Codigo
                WHERE CodigoPrestacion IN (03500361,03500362)
                AND r.mes IN (1,2,3,4,5,6,7,8,9,10,11,12)
                AND r.IdEstablecimiento NOT IN (102100,102600,102601,102602,102011)
                GROUP BY NombreComuna, e.alias_estab ORDER BY NombreComuna, e.alias_estab';
        $cantidades = DB::connection('mysql_rem')->select($query);

        foreach($cantidades as $cantidad) {
            if($cantidad->NombreComuna != 'HECTOR REYNO') $data[$cantidad->NombreComuna][46][$cantidad->alias_estab]['ct_marzo'] = $cantidad->total;
            $data[$cantidad->NombreComuna][46]['ct_marzo'] += $cantidad->total;
        }

        /* 47 */
        $query ='SELECT
               IF(Codigo = "102307", "HECTOR REYNO", comuna) AS NombreComuna, e.alias_estab,
               SUM(COALESCE(Col01,0)) AS total FROM 2019rems r
                JOIN 2019establecimientos e ON r.IdEstablecimiento = e.Codigo
                WHERE CodigoPrestacion IN (23090590)
                AND r.mes IN (1,2,3,4,5,6,7,8,9,10,11,12)
                AND r.IdEstablecimiento NOT IN (102100,102600,102601,102602,102011)
                GROUP BY NombreComuna, e.alias_estab ORDER BY NombreComuna, e.alias_estab';
        $cantidades = DB::connection('mysql_rem')->select($query);

        foreach($cantidades as $cantidad) {
            if($cantidad->NombreComuna != 'HECTOR REYNO') $data[$cantidad->NombreComuna][47][$cantidad->alias_estab]['ct_marzo'] = $cantidad->total;
            $data[$cantidad->NombreComuna][47]['ct_marzo'] += $cantidad->total;
        }

        /* 48 */
        $query ='SELECT
                   IF(Codigo = "102307", "HECTOR REYNO", comuna) AS NombreComuna, e.alias_estab,
                   SUM(COALESCE(Col01,0)) AS total FROM 2019rems r
                    JOIN 2019establecimientos e ON r.IdEstablecimiento = e.Codigo
                    WHERE CodigoPrestacion IN (19120301, 19120302, 19120303, 19120304, 19120306, 19120308, 19120310, 19170200, 19120311, 19120312, 19120305)
                    AND r.mes IN (1,2,3,4,5,6,7,8,9,10,11,12)
                    AND r.IdEstablecimiento NOT IN (102100,102600,102601,102602,102011)
                    GROUP BY NombreComuna, e.alias_estab ORDER BY NombreComuna, e.alias_estab';
        $cantidades = DB::connection('mysql_rem')->select($query);

        foreach($cantidades as $cantidad) {
            if($cantidad->NombreComuna != 'HECTOR REYNO') $data[$cantidad->NombreComuna][48][$cantidad->alias_estab]['ct_marzo'] = $cantidad->total;
            $data[$cantidad->NombreComuna][48]['ct_marzo'] += $cantidad->total;
        }

        /* 49 */
        $query ='SELECT
               IF(Codigo = "102307", "HECTOR REYNO", comuna) AS NombreComuna, e.alias_estab,
               SUM(COALESCE(Col01,0)) AS total FROM 2019rems r
                JOIN 2019establecimientos e ON r.IdEstablecimiento = e.Codigo
                WHERE CodigoPrestacion IN (06020201)
                AND r.mes IN (1,2,3,4,5,6,7,8,9,10,11,12)
                AND r.IdEstablecimiento NOT IN (102100,102600,102601,102602,102011)
                GROUP BY NombreComuna, e.alias_estab ORDER BY NombreComuna, e.alias_estab';
        $cantidades = DB::connection('mysql_rem')->select($query);

        foreach($cantidades as $cantidad) {
            if($cantidad->NombreComuna != 'HECTOR REYNO') $data[$cantidad->NombreComuna][49][$cantidad->alias_estab]['ct_marzo'] = $cantidad->total;
            $data[$cantidad->NombreComuna][49]['ct_marzo'] += $cantidad->total;
        }

        $query ='SELECT
                    IF(Codigo = "102307", "HECTOR REYNO", comuna) AS NombreComuna,
                    SUM(COALESCE(Col01,0)) AS total FROM 2019rems r
                JOIN 2019establecimientos e ON r.IdEstablecimiento = e.Codigo
                WHERE CodigoPrestacion IN ("P6221000")
                AND r.mes IN (6)
                GROUP BY NombreComuna ORDER BY NombreComuna';
        $poblaciones = DB::connection('mysql_rem')->select($query);

        foreach($poblaciones as $poblacion) {
            $data[$poblacion->NombreComuna][49]['poblacion'] = $poblacion->total;
            $data[$poblacion->NombreComuna][50]['poblacion'] = $poblacion->total;
        }

        /* 50 */
        $query ='SELECT
               IF(Codigo = "102307", "HECTOR REYNO", comuna) AS NombreComuna, e.alias_estab,
               SUM(COALESCE(Col01,0)) AS total FROM 2019rems r
                JOIN 2019establecimientos e ON r.IdEstablecimiento = e.Codigo
                WHERE CodigoPrestacion IN (06020208)
                AND r.mes IN (1,2,3,4,5,6,7,8,9,10,11,12)
                AND r.IdEstablecimiento NOT IN (102100,102600,102601,102602,102011)
                GROUP BY NombreComuna, e.alias_estab ORDER BY NombreComuna, e.alias_estab';
        $cantidades = DB::connection('mysql_rem')->select($query);

        foreach($cantidades as $cantidad) {
            if($cantidad->NombreComuna != 'HECTOR REYNO') $data[$cantidad->NombreComuna][50][$cantidad->alias_estab]['ct_marzo'] = $cantidad->total;
            $data[$cantidad->NombreComuna][50]['ct_marzo'] += $cantidad->total;
        }

        /* 51 */
        $query ='SELECT
                    IF(Codigo = "102307", "HECTOR REYNO", comuna) AS NombreComuna, e.alias_estab,
                    SUM(
						  COALESCE(Col39,0)
						  ) AS total FROM 2019rems r
                JOIN 2019establecimientos e ON r.IdEstablecimiento = e.Codigo
                WHERE CodigoPrestacion IN (06020206)
                AND r.mes IN (1,2,3,4,5,6,7,8,9,10,11,12)
                AND r.IdEstablecimiento NOT IN (102100,102600,102601,102602,102011)
                GROUP BY NombreComuna, e.alias_estab ORDER BY NombreComuna, e.alias_estab';
        $cantidades = DB::connection('mysql_rem')->select($query);

        foreach($cantidades as $cantidad) {
            if($cantidad->NombreComuna != 'HECTOR REYNO') $data[$cantidad->NombreComuna][51][$cantidad->alias_estab]['ct_marzo'] = $cantidad->total;
            $data[$cantidad->NombreComuna][51]['ct_marzo'] += $cantidad->total;
        }

        /* 52 */
        $query ='SELECT
                    IF(Codigo = "102307", "HECTOR REYNO", comuna) AS NombreComuna, e.alias_estab,
                    SUM(
						  COALESCE(Col36,0)
						  ) AS total FROM 2019rems r
                JOIN 2019establecimientos e ON r.IdEstablecimiento = e.Codigo
                WHERE CodigoPrestacion IN (02010201)
                AND r.mes IN (1,2,3,4,5,6,7,8,9,10,11,12)
                AND r.IdEstablecimiento NOT IN (102100,102600,102601,102602,102011)
                GROUP BY NombreComuna, e.alias_estab ORDER BY NombreComuna, e.alias_estab';
        $cantidades = DB::connection('mysql_rem')->select($query);

        foreach($cantidades as $cantidad) {
            if($cantidad->NombreComuna != 'HECTOR REYNO') $data[$cantidad->NombreComuna][52][$cantidad->alias_estab]['ct_marzo'] = $cantidad->total;
            $data[$cantidad->NombreComuna][52]['ct_marzo'] += $cantidad->total;
        }


        /* 53 */
        $query ='SELECT
                    IF(Codigo = "102307", "HECTOR REYNO", comuna) AS NombreComuna, e.alias_estab,
                    SUM(
						  COALESCE(Col36,0)
						  ) AS total FROM 2019rems r
                JOIN 2019establecimientos e ON r.IdEstablecimiento = e.Codigo
                WHERE CodigoPrestacion IN (02010103)
                AND r.mes IN (1,2,3,4,5,6,7,8,9,10,11,12)
                AND r.IdEstablecimiento NOT IN (102100,102600,102601,102602,102011)
                GROUP BY NombreComuna, e.alias_estab ORDER BY NombreComuna, e.alias_estab';
        $cantidades = DB::connection('mysql_rem')->select($query);

        foreach($cantidades as $cantidad) {
            if($cantidad->NombreComuna != 'HECTOR REYNO') $data[$cantidad->NombreComuna][53][$cantidad->alias_estab]['ct_marzo'] = $cantidad->total;
            $data[$cantidad->NombreComuna][53]['ct_marzo'] += $cantidad->total;
        }



        /* Calculos */
        /* Sobreescribir valores de poblacion seteados manual */
        foreach($values as $value) {
            if(is_numeric($value->poblacion)){
                $value->commune->name = mb_strtoupper($value->commune->name);
                $data[$value->commune->name][$value->glosa->numero]['poblacion'] = $value->poblacion;
            }
        }


        foreach($data as $nombre_comuna => $comuna) {
            foreach($comuna as $glosa => $valor){
                /* Calculo de actividadesProgramadas = poblacion * concentracion */
                if($data[$nombre_comuna][$glosa]['poblacion'] AND
                   $data[$nombre_comuna][$glosa]['concentracion'] AND
                   $data[$nombre_comuna][$glosa]['cobertura']) {

                    if(!$data[$nombre_comuna][$glosa]['actividadesProgramadas']) {
                        $data[$nombre_comuna][$glosa]['actividadesProgramadas'] =
                            $data[$nombre_comuna][$glosa]['poblacion'] *
                            $data[$nombre_comuna][$glosa]['concentracion'] *
                            $data[$nombre_comuna][$glosa]['cobertura']/100;
                    }

                    if($data[$nombre_comuna][$glosa]['actividadesProgramadas'] AND
                       $data[$nombre_comuna][$glosa]['ct_marzo'] ) {

                        $data[$nombre_comuna][$glosa]['porc_marzo'] =
                            number_format(
                                $data[$nombre_comuna][$glosa]['ct_marzo'] /
                                $data[$nombre_comuna][$glosa]['actividadesProgramadas']*100
                            , 1, '.', '');
		            }
                }
            }
        }




        // echo '<pre>';
        // print_r($data);
        // die();

        return view('indicators.program_aps.2019.index', compact('data','glosas','communes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $glosas = ProgramApsGlosa::where('periodo', 2019)->get();
        $establishments = Establishment::All();
        $communes = Commune::All();
        return view('indicators.program_aps.2019.create', compact('glosas','establishments', 'communes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $programApsValue = ProgramApsValue::create($request->all());

        session()->flash('info', 'El valor con covertura de '.$programApsValue->cobertura.'% ha sido creado.');

        return redirect()->route('indicators.program_aps.2019.create');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Indicators\ProgramApsValue  $programApsValue
     * @return \Illuminate\Http\Response
     */
    public function show(ProgramApsValue $programApsValue)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Indicators\ProgramApsValue  $programApsValue
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, ProgramApsGlosa $glosa, Commune $commune)
    {
        // $commune = Commune::find($communeId);
        // if(!$commune) {
        //     $commune = new Commune();
        //     $commune->id = $communeId;
        //     $commune->name = "HECTOR REYNO";
        // }
        // //dd($commune);
        $programApsValue = ProgramApsValue::firstOrCreate([
            'program_aps_glosa_id' => $glosa->id,
            'commune_id' => $commune->id,
            'periodo' => $glosa->periodo
         ]);
        //$programApsValue->save();
        $glosas = ProgramApsGlosa::where('periodo', 2019)->get();
        $establishments = Establishment::All();
        $communes = Commune::All();

        return view('indicators.program_aps.2019.edit',
            compact('programApsValue','glosas','establishments','communes'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Indicators\ProgramApsValue  $programApsValue
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ProgramApsValue $programApsValue)
    {
        $programApsValue->fill($request->all());
        $programApsValue->save();
        session()->flash('success', 'Parametro: ha sido actualizado.');
        return redirect()->route('indicators.program_aps.2019.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Indicators\ProgramApsValue  $programApsValue
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProgramApsValue $programApsValue)
    {
        //
    }
}
