<?php

namespace App\Http\Controllers\Indicators\_2020;

use App\Models\Indicators\ProgramApsValue;
use App\Models\Indicators\ProgramApsGlosa;
use App\Models\Commune;
use App\Models\Establishment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
// use App\Models\Indicators\Rem;
use Illuminate\Support\Facades\DB;

class ProgramApsValueController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        // return $id;
        if(!in_array($id, range(0,8)) OR !preg_match('/^\d+$/', $id)) abort(404);

        $sql_ultimo_rem = "SELECT MAX(Mes) as ultimo_rem FROM 2020rems;";
        $ultimo_rem = DB::connection('mysql_rem')->select($sql_ultimo_rem)[0]->ultimo_rem;

        $communes = Commune::All();
        $communes = $communes->each(function($item){
            $item->name = mb_strtoupper($item->name);
        });

        /* Crea la comuna Hector Reyno on the fly */
        $commune = new Commune();
        $commune->id = 8;
        $commune->name = "HECTOR REYNO";
        $communes->push($commune);

        $comuna = $communes->find($id);

        $glosas   = ProgramApsGlosa::where('periodo', 2020)->orderBy('numero')->get();

        /* Inicializar valores */
        if($comuna == null){ //RESUMEN
            foreach($glosas as $glosa) {
                $data[$glosa->numero]['total_numerador'] = 0;
                $data[$glosa->numero]['total_denominador'] = 0;
                $data[$glosa->numero]['total_cobertura'] = null;
            }

            // foreach($communes as $commune)
            //     foreach($glosas as $glosa) {
            //         $data[$commune->name][$glosa->numero]['id'] = $glosa->id;
            //         // $data[$commune->name][$glosa->numero]['poblacion'] = '';
            //         // $data[$commune->name][$glosa->numero]['cobertura'] = '';
            //         // $data[$commune->name][$glosa->numero]['concentracion'] = null;
            //         $data[$commune->name][$glosa->numero]['actividadesProgramadas'] = null;
            //         $data[$commune->name][$glosa->numero]['observadoAnterior'] = '';
            //         // $data[$commune->name][$glosa->numero]['rendimientoProfesional'] = '';
            //         $data[$commune->name][$glosa->numero]['observaciones'] = '';
            //         for($mes = 1; $mes < 12; $mes++) $data[$commune->name][$glosa->numero]['numeradores'][$mes] = $mes <= $ultimo_rem ? 0 : null;
            //         $data[$commune->name][$glosa->numero]['ct_marzo'] = null;
            //         $data[$commune->name][$glosa->numero]['porc_marzo'] = '';
            //     }
        } else {
            foreach($glosas as $glosa) {
                $data[$comuna->name][$glosa->numero]['id'] = $glosa->id;
                // $data[$comuna->name][$glosa->numero]['poblacion'] = '';
                // $data[$comuna->name][$glosa->numero]['cobertura'] = '';
                // $data[$comuna->name][$glosa->numero]['concentracion'] = null;
                $data[$comuna->name][$glosa->numero]['actividadesProgramadas'] = null;
                $data[$comuna->name][$glosa->numero]['observadoAnterior'] = '';
                // $data[$comuna->name][$glosa->numero]['rendimientoProfesional'] = '';
                $data[$comuna->name][$glosa->numero]['observaciones'] = '';
                for($mes = 1; $mes < 12; $mes++) $data[$comuna->name][$glosa->numero]['numeradores'][$mes] = $mes <= $ultimo_rem ? 0 : null;
                $data[$comuna->name][$glosa->numero]['ct_marzo'] = null;
                $data[$comuna->name][$glosa->numero]['porc_marzo'] = '';
            }
        }

        // $values = ProgramApsValue::with('glosa')->with('commune')->where(function ($query) { $query->where('periodo', 2020)->orderBy('numero');})->get();
        // cambiar el 6 por id comuna
        // $values = ProgramApsValue::with('glosa')->with('commune')
        //                          ->where(function ($query) { $query->where('periodo', 2020)->orderBy('numero');})
        //                          ->where('commune_id', $comuna->id)->get();

        // foreach($values as $value) {
        //     $value->commune->name = mb_strtoupper($value->commune->name);
        //     //$data[$value->commune->name][$value->glosa->numero]['poblacion'] = $value->poblacion;
        //     $data[$value->commune->name][$value->glosa->numero]['cobertura'] = $value->cobertura;
        //     $data[$value->commune->name][$value->glosa->numero]['concentracion'] = $value->concentracion;
        //     $data[$value->commune->name][$value->glosa->numero]['actividadesProgramadas'] = $value->actividadesProgramadas;
        //     $data[$value->commune->name][$value->glosa->numero]['observadoAnterior'] = $value->observadoAnterior;
        //     $data[$value->commune->name][$value->glosa->numero]['rendimientoProfesional'] = $value->rendimientoProfesional;
        //     $data[$value->commune->name][$value->glosa->numero]['observaciones'] = $value->observaciones;
        //     if($value->commune->id == 8) {
        //         //$data['HECTOR REYNO'][$value->glosa->numero]['poblacion'] = $value->poblacion;
        //         $data['HECTOR REYNO'][$value->glosa->numero]['cobertura'] = $value->cobertura;
        //         $data['HECTOR REYNO'][$value->glosa->numero]['concentracion'] = $value->concentracion;
        //         $data['HECTOR REYNO'][$value->glosa->numero]['actividadesProgramadas'] = $value->actividadesProgramadas;
        //         $data['HECTOR REYNO'][$value->glosa->numero]['observadoAnterior'] = $value->observadoAnterior;
        //         $data['HECTOR REYNO'][$value->glosa->numero]['rendimientoProfesional'] = $value->rendimientoProfesional;
        //         $data['HECTOR REYNO'][$value->glosa->numero]['observaciones'] = $value->observaciones;
        //     }
        // }

        $filter_commune_reyno = $comuna ? ($comuna->id != 8 ? 'AND e.comuna LIKE "'.$comuna->name.'" AND e.Codigo != 102307' : 'AND e.Codigo = 102307') : null;

        /* Poblaciones */
        // $query ='SELECT
        //         	IF(COD_CENTRO = 102307, "HECTOR REYNO", comuna) AS NombreComuna,
        //         	COUNT(*) poblacion FROM percapita_pro p
        //         LEFT JOIN 2020establecimientos e
        //         ON p.COD_CENTRO = e.Codigo
        //         WHERE p.AUTORIZADO = "X" AND p.EDAD BETWEEN 10 AND 19 '. $filter_commune_reyno . ' 
        //         GROUP BY NombreComuna, comuna ORDER BY comuna';
        // // dd($query);        
        // $poblaciones_10a_a_19a = DB::connection('mysql_rem')->select($query);

        // $query ='SELECT
        //             IF(COD_CENTRO = 102307, "HECTOR REYNO", comuna) AS NombreComuna,
        //             COUNT(*) poblacion FROM percapita_pro p
        //         LEFT JOIN 2020establecimientos e
        //         ON p.COD_CENTRO = e.Codigo
        //         WHERE p.AUTORIZADO = "X" AND p.EDAD BETWEEN 10 AND 64 '. $filter_commune_reyno . ' 
        //         GROUP BY NombreComuna, comuna ORDER BY comuna';
        // $poblaciones_10a_a_64a = DB::connection('mysql_rem')->select($query);

        // $query ='SELECT
        //             IF(COD_CENTRO = 102307, "HECTOR REYNO", comuna) AS NombreComuna,
        //             COUNT(*) poblacion FROM percapita_pro p
        //         LEFT JOIN 2020establecimientos e
        //         ON p.COD_CENTRO = e.Codigo
        //         WHERE p.AUTORIZADO = "X" AND p.EDAD BETWEEN 20 AND 64 '. $filter_commune_reyno . ' 
        //         GROUP BY NombreComuna, comuna ORDER BY comuna';
        // $poblaciones_20a_a_64a = DB::connection('mysql_rem')->select($query);

        // $query ='SELECT
        //             IF(COD_CENTRO = 102307, "HECTOR REYNO", comuna) AS NombreComuna,
        //             COUNT(*) poblacion FROM percapita_pro p
        //         LEFT JOIN 2020establecimientos e
        //         ON p.COD_CENTRO = e.Codigo
        //         WHERE p.AUTORIZADO = "X" AND p.EDAD > 64 '. $filter_commune_reyno . ' 
        //         GROUP BY NombreComuna, comuna ORDER BY comuna';
        // $poblaciones_mayor_64a = DB::connection('mysql_rem')->select($query);

        // $query ='SELECT
        //             IF(COD_CENTRO = 102307, "HECTOR REYNO", comuna) AS NombreComuna,
        //             COUNT(*) poblacion FROM percapita_pro p
        //         LEFT JOIN 2020establecimientos e
        //         ON p.COD_CENTRO = e.Codigo
        //         WHERE p.AUTORIZADO = "X" '. $filter_commune_reyno . '
        //         GROUP BY NombreComuna, comuna ORDER BY comuna';
        // $poblaciones_total = DB::connection('mysql_rem')->select($query);

        // echo '<pre>';
        // print_r($data);
        // die();


        /* Obtener los valores por cada uno de los indicadores */
        /* 1 */
        $query ='SELECT
	               IF(Codigo = 102307, "HECTOR REYNO", comuna) AS NombreComuna, mes,
                   SUM(COALESCE(Col06,0) + COALESCE(Col08,0) + COALESCE(Col10,0)) AS numerador FROM 2020rems r
                JOIN 2020establecimientos e ON r.IdEstablecimiento = e.Codigo
                WHERE CodigoPrestacion IN (02010201)
                AND r.mes IN (1,2,3,4,5,6,7,8,9,10,11)
                AND r.IdEstablecimiento NOT IN (102100,102600,102601,102602,102011)
                '. $filter_commune_reyno . ' 
                GROUP BY NombreComuna, mes ORDER BY NombreComuna, mes';
        $cantidades = DB::connection('mysql_rem')->select($query);

        // $cantidades = Rem::year(2020)->selectRaw('SUM(COALESCE(Col06,0)) + SUM(COALESCE(Col08,0)) + SUM(COALESCE(Col10,0)) AS valor, IdEstablecimiento, Mes')
        // ->with('establecimiento')
        // ->when(isset($comuna) && $comuna->id != 8, function($q) use ($comuna){
        //     return $q->whereHas('establecimiento', function($q2) use ($comuna){
        //         return $q2->where('comuna', $comuna->name)->where('Codigo', '!=', 102307);
        //         });
        // })
        // ->when(isset($comuna) && $comuna->id == 8, function($q){
        //     return $q->whereHas('establecimiento', function($q2){
        //         return $q2->where('Codigo', 102307);
        //         });
        // })
        // ->whereIn('CodigoPrestacion', ['02010201'])
        // ->whereIn('Mes',[1,2,3,4,5,6,7,8,9,10,11])
        // ->whereNotIn('CodigoPrestacion', ['102100','102600','102601','102602','102011'])
        // ->groupBy('IdEstablecimiento','Mes')->orderBy('Mes')->get();
        
        // dd($cantidades->sum('valor'));

        foreach($cantidades as $cantidad) {
            if($comuna == null){
                $data[1]['total_numerador'] += $cantidad->numerador;
            } else {
                $data[$cantidad->NombreComuna][1]['numeradores'][$cantidad->mes] = $cantidad->numerador;
                $data[$cantidad->NombreComuna][1]['ct_marzo'] += $cantidad->numerador;
            }
        }

        // $query ='SELECT
        //             IF(COD_CENTRO = 102307, "HECTOR REYNO", comuna) AS NombreComuna,
        //             COUNT(*) poblacion FROM percapita_pro p
        //         LEFT JOIN 2020establecimientos e
        //         ON p.COD_CENTRO = e.Codigo
        //         WHERE p.AUTORIZADO = "X" AND p.EDAD = 0 '. $filter_commune_reyno . ' 
        //         AND TIMESTAMPDIFF(MONTH, FECHA_NACIMIENTO, FECHA_CORTE) IN (2,4,6)
        //         GROUP BY NombreComuna, comuna ORDER BY comuna';
        
        // $poblaciones = DB::connection('mysql_rem')->select($query);

        // foreach($poblaciones as $poblacion) {
        //     $data[$poblacion->NombreComuna][1]['poblacion'] = $poblacion->poblacion;
        // }

        $denominadores = ['IQUIQUE' => 1653, 'ALTO HOSPICIO' => 2125, 'POZO ALMONTE' => 397, 'PICA' => 150, 
                          'HUARA' => 168, 'CAMIÑA' => 246, 'COLCHANE' => 15, 'HECTOR REYNO' => 964];
                          
        if($comuna == null)
            foreach($denominadores as $denominador) $data[1]['total_denominador'] += $denominador;
        else
            $data[$comuna->name][1]['actividadesProgramadas'] = $denominadores[$comuna->name];
        
        /* 2 */
        $query ='SELECT
                    IF(Codigo = 102307, "HECTOR REYNO", comuna) AS NombreComuna, mes,
                    SUM(COALESCE(Col06,0) + COALESCE(Col07,0)) AS numerador FROM 2020rems r
                JOIN 2020establecimientos e ON r.IdEstablecimiento = e.Codigo
                WHERE CodigoPrestacion IN (02010320, 05225303, 02010321, 02010322)
                AND r.mes IN (1,2,3,4,5,6,7,8,9,10,11)
                AND r.IdEstablecimiento NOT IN (102100,102600,102601,102602,102011)
                '. $filter_commune_reyno . ' 
                GROUP BY NombreComuna, mes ORDER BY NombreComuna, mes';
        $cantidades = DB::connection('mysql_rem')->select($query);

        foreach($cantidades as $cantidad) {
            if($comuna == null){
                $data[2]['total_numerador'] += $cantidad->numerador;
            } else {
                $data[$cantidad->NombreComuna][2]['numeradores'][$cantidad->mes] = $cantidad->numerador;
                $data[$cantidad->NombreComuna][2]['ct_marzo'] += $cantidad->numerador;
            }
        }

        // $query ='SELECT
        //             IF(COD_CENTRO = 102307, "HECTOR REYNO", comuna) AS NombreComuna,
        //             COUNT(*) poblacion FROM percapita_pro p
        //         LEFT JOIN 2020establecimientos e
        //         ON p.COD_CENTRO = e.Codigo
        //         WHERE p.AUTORIZADO = "X" AND p.EDAD = 0 '. $filter_commune_reyno . ' 
        //         AND TIMESTAMPDIFF(MONTH, FECHA_NACIMIENTO, FECHA_CORTE) = 8
        //         GROUP BY NombreComuna, comuna ORDER BY comuna';
        // $poblaciones = DB::connection('mysql_rem')->select($query);

        // foreach($poblaciones as $poblacion) {
        //     $data[$poblacion->NombreComuna][2]['poblacion'] = $poblacion->poblacion;
        // }

        $denominadores = ['IQUIQUE' => 1653, 'ALTO HOSPICIO' => 787, 'POZO ALMONTE' => 132, 'PICA' => 51, 
                          'HUARA' => 18, 'CAMIÑA' => 60, 'COLCHANE' => 5, 'HECTOR REYNO' => 321];
        
        if($comuna == null)
            foreach($denominadores as $denominador) $data[2]['total_denominador'] += $denominador;
        else
            $data[$comuna->name][2]['actividadesProgramadas'] = $denominadores[$comuna->name];
        
        /* 3 */
        $query ='SELECT
                    IF(Codigo = 102307, "HECTOR REYNO", comuna) AS NombreComuna, mes,
                    SUM(COALESCE(Col08,0) + COALESCE(Col09,0) + COALESCE(Col10,0) + COALESCE(Col11,0)) AS numerador FROM 2020rems r
                JOIN 2020establecimientos e ON r.IdEstablecimiento = e.Codigo
                WHERE CodigoPrestacion IN (02010320, 05225303, 02010321, 02010322)
                AND r.mes IN (1,2,3,4,5,6,7,8,9,10,11)
                AND r.IdEstablecimiento NOT IN (102100,102600,102601,102602,102011)'
                . $filter_commune_reyno . ' 
                GROUP BY NombreComuna, mes ORDER BY NombreComuna, mes';
        $cantidades = DB::connection('mysql_rem')->select($query);

        foreach($cantidades as $cantidad) {
            if($comuna == null){
                $data[3]['total_numerador'] += $cantidad->numerador;
            } else {
                $data[$cantidad->NombreComuna][3]['numeradores'][$cantidad->mes] = $cantidad->numerador;
                $data[$cantidad->NombreComuna][3]['ct_marzo'] += $cantidad->numerador;
            }
        }

        // $query ='SELECT
        //             IF(COD_CENTRO = 102307, "HECTOR REYNO", comuna) AS NombreComuna,
        //             COUNT(*) poblacion FROM percapita_pro p
        //         LEFT JOIN 2020establecimientos e
        //         ON p.COD_CENTRO = e.Codigo
        //         WHERE p.AUTORIZADO = "X" AND p.EDAD = 1 '. $filter_commune_reyno . ' 
        //         AND TIMESTAMPDIFF(MONTH, FECHA_NACIMIENTO, FECHA_CORTE) = 18
        //         GROUP BY NombreComuna, comuna ORDER BY comuna';
        // $poblaciones = DB::connection('mysql_rem')->select($query);

        // foreach($poblaciones as $poblacion) {
        //     $data[$poblacion->NombreComuna][3]['poblacion'] = $poblacion->poblacion;
        // }

        $denominadores = ['IQUIQUE' => 1321, 'ALTO HOSPICIO' => 842, 'POZO ALMONTE' => 189, 'PICA' => 84, 
                          'HUARA' => 66, 'CAMIÑA' => 106, 'COLCHANE' => 5, 'HECTOR REYNO' => 251];
        
        if($comuna == null)
        foreach($denominadores as $denominador) $data[3]['total_denominador'] += $denominador;
        else
            $data[$comuna->name][3]['actividadesProgramadas'] = $denominadores[$comuna->name];
            
        /* 4 */
        $query ='SELECT
                    IF(Codigo = 102307, "HECTOR REYNO", comuna) AS NombreComuna, mes,
                    SUM(COALESCE(Col12,0) + COALESCE(Col13,0)) AS numerador FROM 2020rems r
                JOIN 2020establecimientos e ON r.IdEstablecimiento = e.Codigo
                WHERE CodigoPrestacion IN (02010320, 05225303, 02010321, 02010322)
                AND r.mes IN (1,2,3,4,5,6,7,8,9,10,11)
                AND r.IdEstablecimiento NOT IN (102100,102600,102601,102602,102011) '
                . $filter_commune_reyno . ' 
                GROUP BY NombreComuna, mes ORDER BY NombreComuna, mes';
        $cantidades = DB::connection('mysql_rem')->select($query);

        foreach($cantidades as $cantidad) {
            if($comuna == null){
                $data[4]['total_numerador'] += $cantidad->numerador;
            } else {
                $data[$cantidad->NombreComuna][4]['numeradores'][$cantidad->mes] = $cantidad->numerador;
                $data[$cantidad->NombreComuna][4]['ct_marzo'] += $cantidad->numerador;
            }
        }

        // $query ='SELECT
        //             IF(COD_CENTRO = 102307, "HECTOR REYNO", comuna) AS NombreComuna,
        //             COUNT(*) poblacion FROM percapita_pro p
        //         LEFT JOIN 2020establecimientos e
        //         ON p.COD_CENTRO = e.Codigo
        //         WHERE p.AUTORIZADO = "X" AND p.EDAD = 3 '. $filter_commune_reyno . ' 
        //         GROUP BY NombreComuna, comuna ORDER BY comuna';
        // $poblaciones = DB::connection('mysql_rem')->select($query);
        
        // foreach($poblaciones as $poblacion) {
        //     $data[$poblacion->NombreComuna][4]['poblacion'] = $poblacion->poblacion;
        // }

        $denominadores = ['IQUIQUE' => 2251, 'ALTO HOSPICIO' => 765, 'POZO ALMONTE' => 198, 'PICA' => 84, 
                          'HUARA' => 48, 'CAMIÑA' => 72, 'COLCHANE' => 3, 'HECTOR REYNO' => 306];
        
        if($comuna == null)
        foreach($denominadores as $denominador) $data[4]['total_denominador'] += $denominador;
        else
            $data[$comuna->name][4]['actividadesProgramadas'] = $denominadores[$comuna->name];
        
        /* 5 */
        // REM A04
        $query ='SELECT
                    IF(Codigo = 102307, "HECTOR REYNO", comuna) AS NombreComuna, mes,
                    SUM(
                        COALESCE(Col04,0) +
                        COALESCE(Col05,0) +
                        COALESCE(Col06,0) +
                        COALESCE(Col07,0) +
                        COALESCE(Col08,0) +
                        COALESCE(Col09,0)
                    ) AS numerador FROM 2020rems r
                JOIN 2020establecimientos e ON r.IdEstablecimiento = e.Codigo
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
                AND r.mes IN (1,2,3,4,5,6,7,8,9,10,11)
                AND r.IdEstablecimiento NOT IN (102100,102600,102601,102602,102011) '
                . $filter_commune_reyno . ' 
                GROUP BY NombreComuna, mes ORDER BY NombreComuna, mes';
        $cantidades = DB::connection('mysql_rem')->select($query);
        
        foreach($cantidades as $cantidad) {
            if($comuna == null){
                $data[5]['total_numerador'] += $cantidad->numerador;
            } else {
                $data[$cantidad->NombreComuna][5]['numeradores'][$cantidad->mes] = $cantidad->numerador;
                $data[$cantidad->NombreComuna][5]['ct_marzo'] += $cantidad->numerador;
            }
        }

        // REM A08
        $query ='SELECT
                    IF(Codigo = 102307, "HECTOR REYNO", comuna) AS NombreComuna, mes,
                    SUM(
                        COALESCE(Col04,0) +
                        COALESCE(Col05,0) +
                        COALESCE(Col06,0) +
                        COALESCE(Col07,0)
                    ) AS numerador FROM 2020rems r
                JOIN 2020establecimientos e ON r.IdEstablecimiento = e.Codigo
                WHERE CodigoPrestacion IN (08220001)
                AND r.mes IN (1,2,3,4,5,6,7,8,9,10,11)
                AND r.IdEstablecimiento NOT IN (102100,102600,102601,102602,102011) '
                . $filter_commune_reyno . ' 
                GROUP BY NombreComuna, mes ORDER BY NombreComuna, mes';
        $cantidades = DB::connection('mysql_rem')->select($query);

        foreach($cantidades as $cantidad) {
            if($comuna == null){
                $data[5]['total_numerador'] += $cantidad->numerador;
            } else {
                $data[$cantidad->NombreComuna][5]['numeradores'][$cantidad->mes] += $cantidad->numerador;
                $data[$cantidad->NombreComuna][5]['ct_marzo'] += $cantidad->numerador;
            }
        }

        // REM A23
        $query ='SELECT
                    IF(Codigo = 102307, "HECTOR REYNO", comuna) AS NombreComuna, mes,
                    SUM(
                        COALESCE(Col04,0) +
                        COALESCE(Col05,0) +
                        COALESCE(Col06,0) +
                        COALESCE(Col07,0) +
                        COALESCE(Col08,0) +
                        COALESCE(Col09,0)
                    ) AS numerador FROM 2020rems r
                JOIN 2020establecimientos e ON r.IdEstablecimiento = e.Codigo
                WHERE CodigoPrestacion IN (23080200)
                AND r.mes IN (1,2,3,4,5,6,7,8,9,10,11)
                AND r.IdEstablecimiento NOT IN (102100,102600,102601,102602,102011) '
                . $filter_commune_reyno . ' 
                GROUP BY NombreComuna, mes ORDER BY NombreComuna, mes';
        $cantidades = DB::connection('mysql_rem')->select($query);

        foreach($cantidades as $cantidad) {
            if($comuna == null){
                $data[5]['total_numerador'] += $cantidad->numerador;
            } else {
                $data[$cantidad->NombreComuna][5]['numeradores'][$cantidad->mes] += $cantidad->numerador;
                $data[$cantidad->NombreComuna][5]['ct_marzo'] += $cantidad->numerador;
            }
        }

        // $query ='SELECT
        //             IF(COD_CENTRO = 102307, "HECTOR REYNO", comuna) AS NombreComuna,
        //             COUNT(*) poblacion FROM percapita_pro p
        //         LEFT JOIN 2020establecimientos e
        //         ON p.COD_CENTRO = e.Codigo
        //         WHERE p.AUTORIZADO = "X" AND p.EDAD < 10 '. $filter_commune_reyno . ' 
        //         GROUP BY NombreComuna, comuna ORDER BY comuna';
        // $poblaciones = DB::connection('mysql_rem')->select($query);

        // foreach($poblaciones as $poblacion) {
        //     $data[$poblacion->NombreComuna][5]['poblacion'] = $poblacion->poblacion;
        // }

        $denominadores = ['IQUIQUE' => 18982, 'ALTO HOSPICIO' => 12142, 'POZO ALMONTE' => 4800, 'PICA' => 6800, 
                          'HUARA' => 261, 'CAMIÑA' => 198, 'COLCHANE' => 104, 'HECTOR REYNO' => 2036];
        
        if($comuna == null)
            foreach($denominadores as $denominador) $data[5]['total_denominador'] += $denominador;
        else
            $data[$comuna->name][5]['actividadesProgramadas'] = $denominadores[$comuna->name];
        
        /* 6 */
        $query ='SELECT
                    IF(Codigo = 102307, "HECTOR REYNO", comuna) AS NombreComuna, mes,
                    SUM(COALESCE(Col04,0) + COALESCE(Col05,0) + COALESCE(Col06,0) +
                        COALESCE(Col07,0) + COALESCE(Col08,0) + COALESCE(Col09,0) +
                        COALESCE(Col10,0) + COALESCE(Col11,0))
                        AS numerador FROM 2020rems r
                JOIN 2020establecimientos e ON r.IdEstablecimiento = e.Codigo
                WHERE CodigoPrestacion IN (05225304, 02010420, 05225305, 03500366, 05225306, 02010421, 02010422)
                AND r.mes IN (1,2,3,4,5,6,7,8,9,10,11)
                AND r.IdEstablecimiento NOT IN (102100,102600,102601,102602,102011) '
                . $filter_commune_reyno . ' 
                GROUP BY NombreComuna, mes ORDER BY NombreComuna, mes';
        $cantidades = DB::connection('mysql_rem')->select($query);

        foreach($cantidades as $cantidad) {
            if($comuna == null){
                $data[6]['total_numerador'] += $cantidad->numerador;
            } else {
                $data[$cantidad->NombreComuna][6]['numeradores'][$cantidad->mes] = $cantidad->numerador;
                $data[$cantidad->NombreComuna][6]['ct_marzo'] += $cantidad->numerador;
            }
        }

        // $query ='SELECT
        //             IF(COD_CENTRO = 102307, "HECTOR REYNO", comuna) AS NombreComuna,
        //             COUNT(*) poblacion FROM percapita_pro p
        //         LEFT JOIN 2020establecimientos e
        //         ON p.COD_CENTRO = e.Codigo
        //         WHERE p.AUTORIZADO = "X" AND p.EDAD < 2 '. $filter_commune_reyno . ' 
        //         GROUP BY NombreComuna, comuna ORDER BY comuna';
        // $poblaciones = DB::connection('mysql_rem')->select($query);

        // foreach($poblaciones as $poblacion) {
        //     $data[$poblacion->NombreComuna][6]['poblacion'] = $poblacion->poblacion;
        // }

        $denominadores = ['IQUIQUE' => 146, 'ALTO HOSPICIO' => 204, 'POZO ALMONTE' => 78, 'PICA' => 20, 
                          'HUARA' => 96, 'CAMIÑA' => 3, 'COLCHANE' => 5, 'HECTOR REYNO' => 977];

        if($comuna == null)
            foreach($denominadores as $denominador) $data[6]['total_denominador'] += $denominador;
        else
            $data[$comuna->name][6]['actividadesProgramadas'] = $denominadores[$comuna->name];
        
        /* 7 */
        $query ='SELECT
                    IF(Codigo = 102307, "HECTOR REYNO", comuna) AS NombreComuna, mes,
                    SUM(COALESCE(Col12,0) + COALESCE(Col13,0)) AS numerador FROM 2020rems r
                JOIN 2020establecimientos e ON r.IdEstablecimiento = e.Codigo
                WHERE CodigoPrestacion IN (05225304, 02010420, 05225305, 03500366,03500400, 03500401, 05225306, 02010421, 02010422)
                AND r.mes IN (1,2,3,4,5,6,7,8,9,10,11)
                AND r.IdEstablecimiento NOT IN (102100,102600,102601,102602,102011) '
                . $filter_commune_reyno . ' 
                GROUP BY NombreComuna, mes ORDER BY NombreComuna, mes';
        $cantidades = DB::connection('mysql_rem')->select($query);

        foreach($cantidades as $cantidad) {
            if($comuna == null){
                $data[7]['total_numerador'] += $cantidad->numerador;
            } else {
                $data[$cantidad->NombreComuna][7]['numeradores'][$cantidad->mes] = $cantidad->numerador;
                $data[$cantidad->NombreComuna][7]['ct_marzo'] += $cantidad->numerador;
            }
        }

        // $query ='SELECT
        //             IF(COD_CENTRO = 102307, "HECTOR REYNO", comuna) AS NombreComuna,
        //             COUNT(*) poblacion FROM percapita_pro p
        //         LEFT JOIN 2020establecimientos e
        //         ON p.COD_CENTRO = e.Codigo
        //         WHERE p.AUTORIZADO = "X" AND p.EDAD BETWEEN 2 AND 4 '. $filter_commune_reyno . ' 
        //         GROUP BY NombreComuna, comuna ORDER BY comuna';
        // $poblaciones = DB::connection('mysql_rem')->select($query);

        // foreach($poblaciones as $poblacion) {
        //     $data[$poblacion->NombreComuna][7]['poblacion'] = $poblacion->poblacion;
        // }

        $denominadores = ['IQUIQUE' => 249, 'ALTO HOSPICIO' => 109, 'POZO ALMONTE' => 14, 'PICA' => 50, 
                          'HUARA' => 140, 'CAMIÑA' => 1, 'COLCHANE' => 2, 'HECTOR REYNO' => 612];
        
        if($comuna == null)
            foreach($denominadores as $denominador) $data[7]['total_denominador'] += $denominador;
        else
            $data[$comuna->name][7]['actividadesProgramadas'] = $denominadores[$comuna->name];

        /* 8 */
        $query ='SELECT
                    IF(Codigo = 102307, "HECTOR REYNO", comuna) AS NombreComuna, mes,
                    SUM(COALESCE(Col04,0) + COALESCE(Col05,0) + COALESCE(Col06,0) +
                        COALESCE(Col07,0) + COALESCE(Col08,0) + COALESCE(Col09,0) +
                        COALESCE(Col10,0) + COALESCE(Col11,0) + COALESCE(Col12,0) +
                        COALESCE(Col13,0)) AS numerador FROM 2020rems r
                JOIN 2020establecimientos e ON r.IdEstablecimiento = e.Codigo
                WHERE CodigoPrestacion IN (23080300, 23080400, 23080500)
                AND r.mes IN (1,2,3,4,5,6,7,8,9,10,11)
                AND r.IdEstablecimiento NOT IN (102100,102600,102601,102602,102011) '
                . $filter_commune_reyno . ' 
                GROUP BY NombreComuna, mes ORDER BY NombreComuna, mes';
        $cantidades = DB::connection('mysql_rem')->select($query);

        foreach($cantidades as $cantidad) {
            if($comuna == null){
                $data[8]['total_numerador'] += $cantidad->numerador;
            } else {
                $data[$cantidad->NombreComuna][8]['numeradores'][$cantidad->mes] = $cantidad->numerador;
                $data[$cantidad->NombreComuna][8]['ct_marzo'] += $cantidad->numerador;
            }
        }

        // $query ='SELECT
        //             IF(COD_CENTRO = 102307, "HECTOR REYNO", comuna) AS NombreComuna,
        //             COUNT(*) poblacion FROM percapita_pro p
        //         LEFT JOIN 2020establecimientos e
        //         ON p.COD_CENTRO = e.Codigo
        //         WHERE p.AUTORIZADO = "X" AND p.EDAD < 20 '. $filter_commune_reyno . ' 
        //         GROUP BY NombreComuna, comuna ORDER BY comuna';
        // $poblaciones = DB::connection('mysql_rem')->select($query);

        // foreach($poblaciones as $poblacion) {
        //     $data[$poblacion->NombreComuna][8]['poblacion'] = $poblacion->poblacion;
        // }

        $denominadores = ['IQUIQUE' => 8, 'ALTO HOSPICIO' => 1240, 'POZO ALMONTE' => 994, 'PICA' => 49, 
                          'HUARA' => 390, 'CAMIÑA' => 16, 'COLCHANE' => 12, 'HECTOR REYNO' => 1168];

        if($comuna == null)
            foreach($denominadores as $denominador) $data[8]['total_denominador'] += $denominador;
        else
            $data[$comuna->name][8]['actividadesProgramadas'] = $denominadores[$comuna->name];
        
        /* 9 */
        $query ='SELECT
                    IF(Codigo = 102307, "HECTOR REYNO", comuna) AS NombreComuna, mes,
                    SUM(COALESCE(Col04,0) + COALESCE(Col05,0) + COALESCE(Col06,0) +
                        COALESCE(Col07,0) + COALESCE(Col08,0) + COALESCE(Col09,0) +
                        COALESCE(Col10,0) + COALESCE(Col11,0) + COALESCE(Col12,0) +
                        COALESCE(Col13,0)) AS numerador FROM 2020rems r
                JOIN 2020establecimientos e ON r.IdEstablecimiento = e.Codigo
                WHERE CodigoPrestacion IN (23030100, 23030300, 23030400, 23030500, 23042000, 23090410, "23042000A", 23042100, 23042200, 23042300, 23042400)
                AND r.mes IN (1,2,3,4,5,6,7,8,9,10,11)
                AND r.IdEstablecimiento NOT IN (102100,102600,102601,102602,102011) '
                . $filter_commune_reyno . ' 
                GROUP BY NombreComuna, mes ORDER BY NombreComuna, mes';
        $cantidades = DB::connection('mysql_rem')->select($query);

        foreach($cantidades as $cantidad) {
            if($comuna == null){
                $data[9]['total_numerador'] += $cantidad->numerador;
            } else {
                $data[$cantidad->NombreComuna][9]['numeradores'][$cantidad->mes] = $cantidad->numerador;
                $data[$cantidad->NombreComuna][9]['ct_marzo'] += $cantidad->numerador;
            }
        }

        // $query ='SELECT
        //             IF(COD_CENTRO = 102307, "HECTOR REYNO", comuna) AS NombreComuna,
        //             COUNT(*) poblacion FROM percapita_pro p
        //         LEFT JOIN 2020establecimientos e
        //         ON p.COD_CENTRO = e.Codigo
        //         WHERE p.AUTORIZADO = "X" AND p.EDAD < 20 '. $filter_commune_reyno . ' 
        //         GROUP BY NombreComuna, comuna ORDER BY comuna';
        // $poblaciones = DB::connection('mysql_rem')->select($query);

        // foreach($poblaciones as $poblacion) {
        //     $data[$poblacion->NombreComuna][9]['poblacion'] = $poblacion->poblacion;
        // }

        $denominadores = ['IQUIQUE' => 1, 'ALTO HOSPICIO' => 96, 'POZO ALMONTE' => 6, 'PICA' => 74, 
                          'HUARA' => 55, 'CAMIÑA' => 0, 'COLCHANE' => 10, 'HECTOR REYNO' => 423];

        if($comuna == null)
            foreach($denominadores as $denominador) $data[9]['total_denominador'] += $denominador;
        else
            $data[$comuna->name][9]['actividadesProgramadas'] = $denominadores[$comuna->name];

        /* 10 */
        $query ='SELECT
                    IF(Codigo = 102307, "HECTOR REYNO", comuna) AS NombreComuna, mes,
                    SUM(COALESCE(Col01,0) + COALESCE(Col04,0)) AS numerador FROM 2020rems r
                JOIN 2020establecimientos e ON r.IdEstablecimiento = e.Codigo
                WHERE CodigoPrestacion IN (01030500, 01030600, 01030700, 01030800)
                AND r.mes IN (1,2,3,4,5,6,7,8,9,10,11)
                AND r.IdEstablecimiento NOT IN (102100,102600,102601,102602,102011) '
                . $filter_commune_reyno . ' 
                GROUP BY NombreComuna, mes ORDER BY NombreComuna, mes';
        $cantidades = DB::connection('mysql_rem')->select($query);

        foreach($cantidades as $cantidad) {
            if($comuna == null){
                $data[10]['total_numerador'] += $cantidad->numerador;
            } else {
                $data[$cantidad->NombreComuna][10]['numeradores'][$cantidad->mes] = $cantidad->numerador;
                $data[$cantidad->NombreComuna][10]['ct_marzo'] += $cantidad->numerador;
            }
        }

        // foreach($poblaciones_10a_a_19a as $poblacion) {
        //     $data[$poblacion->NombreComuna][10]['poblacion'] = $poblacion->poblacion;
        // }

        $denominadores = ['IQUIQUE' => 4632, 'ALTO HOSPICIO' => 236, 'POZO ALMONTE' => 214, 'PICA' => 339, 
                          'HUARA' => 13, 'CAMIÑA' => 0, 'COLCHANE' => 47, 'HECTOR REYNO' => 50];

        if($comuna == null)
            foreach($denominadores as $denominador) $data[10]['total_denominador'] += $denominador;
        else
            $data[$comuna->name][10]['actividadesProgramadas'] = $denominadores[$comuna->name];
        
        /* 11 */
        // REM A04
        $query ='SELECT
                    IF(Codigo = 102307, "HECTOR REYNO", comuna) AS NombreComuna, mes,
                    SUM(COALESCE(Col10,0) + COALESCE(Col11,0) + COALESCE(Col12,0) + COALESCE(Col13,0)) AS numerador FROM 2020rems r
                JOIN 2020establecimientos e ON r.IdEstablecimiento = e.Codigo
                WHERE CodigoPrestacion IN (03020101, 03020201, 03020301, 03020402, 03020403, 03020401, 03040210, 03040220, 04040100, 04025010, 04025020, 04025025, 04040427, 03020501)
                AND r.mes IN (1,2,3,4,5,6,7,8,9,10,11)
                AND r.IdEstablecimiento NOT IN (102100,102600,102601,102602,102011) '
                . $filter_commune_reyno . ' 
                GROUP BY NombreComuna, mes ORDER BY NombreComuna, mes';
        $cantidades = DB::connection('mysql_rem')->select($query);

        foreach($cantidades as $cantidad) {
            if($comuna == null){
                $data[11]['total_numerador'] += $cantidad->numerador;
            } else {
                $data[$cantidad->NombreComuna][11]['numeradores'][$cantidad->mes] = $cantidad->numerador;
                $data[$cantidad->NombreComuna][11]['ct_marzo'] += $cantidad->numerador;
            }
        }

        // REM A08
        $query ='SELECT
                    IF(Codigo = 102307, "HECTOR REYNO", comuna) AS NombreComuna, mes,
                    SUM(COALESCE(Col08,0) + COALESCE(Col09,0) + COALESCE(Col10,0) + COALESCE(Col11,0)) AS numerador FROM 2020rems r
                JOIN 2020establecimientos e ON r.IdEstablecimiento = e.Codigo
                WHERE CodigoPrestacion IN (08220001)
                AND r.mes IN (1,2,3,4,5,6,7,8,9,10,11)
                AND r.IdEstablecimiento NOT IN (102100,102600,102601,102602,102011) '
                . $filter_commune_reyno . ' 
                GROUP BY NombreComuna, mes ORDER BY NombreComuna, mes';
        $cantidades = DB::connection('mysql_rem')->select($query);

        foreach($cantidades as $cantidad) {
            if($comuna == null){
                $data[11]['total_numerador'] += $cantidad->numerador;
            } else {
                $data[$cantidad->NombreComuna][11]['numeradores'][$cantidad->mes] += $cantidad->numerador;
                $data[$cantidad->NombreComuna][11]['ct_marzo'] += $cantidad->numerador;
            }
        }

        // REM A23
        $query ='SELECT
                    IF(Codigo = 102307, "HECTOR REYNO", comuna) AS NombreComuna, mes,
                    SUM(COALESCE(Col10,0) + COALESCE(Col11,0) + COALESCE(Col12,0) + COALESCE(Col13,0)) AS numerador FROM 2020rems r
                JOIN 2020establecimientos e ON r.IdEstablecimiento = e.Codigo
                WHERE CodigoPrestacion IN (23080200)
                AND r.mes IN (1,2,3,4,5,6,7,8,9,10,11)
                AND r.IdEstablecimiento NOT IN (102100,102600,102601,102602,102011) '
                . $filter_commune_reyno . ' 
                GROUP BY NombreComuna, mes ORDER BY NombreComuna, mes';
        $cantidades = DB::connection('mysql_rem')->select($query);

        foreach($cantidades as $cantidad) {
            if($comuna == null){
                $data[11]['total_numerador'] += $cantidad->numerador;
            } else {
                $data[$cantidad->NombreComuna][11]['numeradores'][$cantidad->mes] += $cantidad->numerador;
                $data[$cantidad->NombreComuna][11]['ct_marzo'] += $cantidad->numerador;
            }
        }

        // foreach($poblaciones_10a_a_19a as $poblacion) {
        //     $data[$poblacion->NombreComuna][11]['poblacion'] = $poblacion->poblacion;
        // }

        $denominadores = ['IQUIQUE' => 23158, 'ALTO HOSPICIO' => 1599, 'POZO ALMONTE' => 1938, 'PICA' => 299, 
                          'HUARA' => 366, 'CAMIÑA' => 11, 'COLCHANE' => 0, 'HECTOR REYNO' => 2521];

        if($comuna == null)
            foreach($denominadores as $denominador) $data[11]['total_denominador'] += $denominador;
        else
            $data[$comuna->name][11]['actividadesProgramadas'] = $denominadores[$comuna->name];

        /* 12 */
        $query ='SELECT
                    IF(Codigo = 102307, "HECTOR REYNO", comuna) AS NombreComuna, mes,
                    SUM(COALESCE(Col02,0) + COALESCE(Col03,0)) AS numerador FROM 2020rems r
                JOIN 2020establecimientos e ON r.IdEstablecimiento = e.Codigo
                WHERE CodigoPrestacion IN (01080011, 05810443, 01080021, 01080022, 01080023, 01090060, 05970038, 05970039, 01080013, 01080014,
                                           05970040, 05970041, "05050100A", 05970042, 05970043, 05970044, 05970045, 05970046, 05970047)
                AND r.mes IN (1,2,3,4,5,6,7,8,9,10,11)
                AND r.IdEstablecimiento NOT IN (102100,102600,102601,102602,102011) '
                . $filter_commune_reyno . ' 
                GROUP BY NombreComuna, mes ORDER BY NombreComuna, mes';
        $cantidades = DB::connection('mysql_rem')->select($query);

        foreach($cantidades as $cantidad) {
            if($comuna == null){
                $data[12]['total_numerador'] += $cantidad->numerador;
            } else {
                $data[$cantidad->NombreComuna][12]['numeradores'][$cantidad->mes] = $cantidad->numerador;
                $data[$cantidad->NombreComuna][12]['ct_marzo'] += $cantidad->numerador;
            }
        }

        // foreach($poblaciones_10a_a_19a as $poblacion) {
        //     $data[$poblacion->NombreComuna][12]['poblacion'] = $poblacion->poblacion;
        // }

        $denominadores = ['IQUIQUE' => 0, 'ALTO HOSPICIO' => 160, 'POZO ALMONTE' => 621, 'PICA' => 134, 
                          'HUARA' => 25, 'CAMIÑA' => 55, 'COLCHANE' => 47, 'HECTOR REYNO' => 127];

        if($comuna == null)
            foreach($denominadores as $denominador) $data[12]['total_denominador'] += $denominador;
        else
            $data[$comuna->name][12]['actividadesProgramadas'] = $denominadores[$comuna->name];

        /* 13 */
        $query ='SELECT
                    IF(Codigo = 102307, "HECTOR REYNO", comuna) AS NombreComuna, mes,
                    SUM(COALESCE(Col08,0) + COALESCE(Col09,0) + COALESCE(Col10,0) + COALESCE(Col11,0)) AS numerador FROM 2020rems r
                JOIN 2020establecimientos e ON r.IdEstablecimiento = e.Codigo
                WHERE CodigoPrestacion IN (19120601, 19120602,  19120603, 19120606, 19120608, 19120609, 19120611)
                AND r.mes IN (1,2,3,4,5,6,7,8,9,10,11)
                AND r.IdEstablecimiento NOT IN (102100,102600,102601,102602,102011) '
                . $filter_commune_reyno . ' 
                GROUP BY NombreComuna, mes ORDER BY NombreComuna, mes';
        $cantidades = DB::connection('mysql_rem')->select($query);

        foreach($cantidades as $cantidad) {
            if($comuna == null){
                $data[13]['total_numerador'] += $cantidad->numerador;
            } else {
                $data[$cantidad->NombreComuna][13]['numeradores'][$cantidad->mes] = $cantidad->numerador;
                $data[$cantidad->NombreComuna][13]['ct_marzo'] += $cantidad->numerador;
            }
        }

        // foreach($poblaciones_10a_a_19a as $poblacion) {
        //     $data[$poblacion->NombreComuna][13]['poblacion'] = $poblacion->poblacion;
        // }

        $denominadores = ['IQUIQUE' => 2316, 'ALTO HOSPICIO' => 1599, 'POZO ALMONTE' => 621, 'PICA' => 339, 
                          'HUARA' => 104, 'CAMIÑA' => 0, 'COLCHANE' => 47, 'HECTOR REYNO' => 127];

        if($comuna == null)
            foreach($denominadores as $denominador) $data[13]['total_denominador'] += $denominador;
        else
            $data[$comuna->name][13]['actividadesProgramadas'] = $denominadores[$comuna->name];
        
        /* 14 */
        $query ='SELECT
                    IF(Codigo = 102307, "HECTOR REYNO", comuna) AS NombreComuna, mes,
                    SUM(COALESCE(Col08,0) + COALESCE(Col09,0) + COALESCE(Col10,0) + COALESCE(Col11,0)) AS numerador FROM 2020rems r
                JOIN 2020establecimientos e ON r.IdEstablecimiento = e.Codigo
                WHERE CodigoPrestacion IN (19120701, 19120702,  19120703, 19120706, 19120708, 19120709, 19120711)
                AND r.mes IN (1,2,3,4,5,6,7,8,9,10,11)
                AND r.IdEstablecimiento NOT IN (102100,102600,102601,102602,102011) '
                . $filter_commune_reyno . ' 
                GROUP BY NombreComuna, mes ORDER BY NombreComuna, mes';
        $cantidades = DB::connection('mysql_rem')->select($query);

        foreach($cantidades as $cantidad) {
            if($comuna == null){
                $data[14]['total_numerador'] += $cantidad->numerador;
            } else {
                $data[$cantidad->NombreComuna][14]['numeradores'][$cantidad->mes] = $cantidad->numerador;
                $data[$cantidad->NombreComuna][14]['ct_marzo'] += $cantidad->numerador;
            }
        }

        // foreach($poblaciones_10a_a_19a as $poblacion) {
        //     $data[$poblacion->NombreComuna][14]['poblacion'] = $poblacion->poblacion;
        // }

        $denominadores = ['IQUIQUE' => 2316, 'ALTO HOSPICIO' => 800, 'POZO ALMONTE' => 435, 'PICA' => 105, 
                          'HUARA' => 104, 'CAMIÑA' => 0, 'COLCHANE' => 47, 'HECTOR REYNO' => 76];

        if($comuna == null)
            foreach($denominadores as $denominador) $data[14]['total_denominador'] += $denominador;
        else
        $data[$comuna->name][14]['actividadesProgramadas'] = $denominadores[$comuna->name];

        /* 15 */
        $query ='SELECT
                    IF(Codigo = 102307, "HECTOR REYNO", comuna) AS NombreComuna, mes,
                    SUM(COALESCE(Col08,0) + COALESCE(Col09,0) + COALESCE(Col10,0) + COALESCE(Col11,0)) AS numerador FROM 2020rems r
                JOIN 2020establecimientos e ON r.IdEstablecimiento = e.Codigo
                WHERE CodigoPrestacion IN (06020201, 06020208, 06020202, 06020602, 06020206, 06200400, 06904900, 06200500, 06200501, 06905912)
                AND r.mes IN (1,2,3,4,5,6,7,8,9,10,11)
                AND r.IdEstablecimiento NOT IN (102100,102600,102601,102602,102011) '
                . $filter_commune_reyno . ' 
                GROUP BY NombreComuna, mes ORDER BY NombreComuna, mes';
        $cantidades = DB::connection('mysql_rem')->select($query);

        foreach($cantidades as $cantidad) {
            if($comuna == null){
                $data[15]['total_numerador'] += $cantidad->numerador;
            } else {
                $data[$cantidad->NombreComuna][15]['numeradores'][$cantidad->mes] = $cantidad->numerador;
                $data[$cantidad->NombreComuna][15]['ct_marzo'] += $cantidad->numerador;
            }
        }

        // foreach($poblaciones_10a_a_19a as $poblacion) {
        //     $data[$poblacion->NombreComuna][15]['poblacion'] = $poblacion->poblacion;
        // }

        $denominadores = ['IQUIQUE' => 2779, 'ALTO HOSPICIO' => 2393, 'POZO ALMONTE' => 1267, 'PICA' => 311, 
                          'HUARA' => 172, 'CAMIÑA' => 28, 'COLCHANE' => 45, 'HECTOR REYNO' => 3346];

        if($comuna == null)
            foreach($denominadores as $denominador) $data[15]['total_denominador'] += $denominador;
        else
            $data[$comuna->name][15]['actividadesProgramadas'] = $denominadores[$comuna->name];

        /* 16 */
        $query ='SELECT
                    IF(Codigo = 102307, "HECTOR REYNO", comuna) AS NombreComuna, mes,
                    SUM(COALESCE(Col01,0)) AS numerador FROM 2020rems r
                JOIN 2020establecimientos e ON r.IdEstablecimiento = e.Codigo
                WHERE CodigoPrestacion IN (01110107, 01080040)
                AND r.mes IN (1,2,3,4,5,6,7,8,9,10,11)
                AND r.IdEstablecimiento NOT IN (102100,102600,102601,102602,102011) '
                . $filter_commune_reyno . ' 
                GROUP BY NombreComuna, mes ORDER BY NombreComuna, mes';
        $cantidades = DB::connection('mysql_rem')->select($query);

        foreach($cantidades as $cantidad) {
            if($comuna == null){
                $data[16]['total_numerador'] += $cantidad->numerador;
            } else {
                $data[$cantidad->NombreComuna][16]['numeradores'][$cantidad->mes] = $cantidad->numerador;
                $data[$cantidad->NombreComuna][16]['ct_marzo'] += $cantidad->numerador;
            }
        }

        // $query ='SELECT
        //             IF(COD_CENTRO = 102307, "HECTOR REYNO", comuna) AS NombreComuna,
        //             COUNT(*) poblacion FROM percapita_pro p
        //         LEFT JOIN 2020establecimientos e
        //         ON p.COD_CENTRO = e.Codigo
        //         WHERE p.AUTORIZADO = "X" AND p.EDAD = 0 '. $filter_commune_reyno . ' 
        //         AND TIMESTAMPDIFF(DAY, FECHA_NACIMIENTO, FECHA_CORTE) < 28
        //         GROUP BY NombreComuna, comuna ORDER BY comuna';
        // $poblaciones = DB::connection('mysql_rem')->select($query);

        // foreach($poblaciones as $poblacion) {
        //     $data[$poblacion->NombreComuna][16]['poblacion'] = $poblacion->poblacion;
        // }

        $denominadores = ['IQUIQUE' => 1653, 'ALTO HOSPICIO' => 891, 'POZO ALMONTE' => 132, 'PICA' => 55, 
                          'HUARA' => 32, 'CAMIÑA' => 13, 'COLCHANE' => 5, 'HECTOR REYNO' => 321];

        if($comuna == null)
            foreach($denominadores as $denominador) $data[16]['total_denominador'] += $denominador;
        else
            $data[$comuna->name][16]['actividadesProgramadas'] = $denominadores[$comuna->name];

        /* 17 */
        $query ='SELECT
                    IF(Codigo = 102307, "HECTOR REYNO", comuna) AS NombreComuna, mes,
                    SUM(COALESCE(Col08,0)) AS numerador FROM 2020rems r
                JOIN 2020establecimientos e ON r.IdEstablecimiento = e.Codigo
                WHERE CodigoPrestacion IN (19140401,19180000,19140402,19140403)
                AND r.mes IN (1,2,3,4,5,6,7,8,9,10,11)
                AND r.IdEstablecimiento NOT IN (102100,102600,102601,102602,102011) '
                . $filter_commune_reyno . ' 
                GROUP BY NombreComuna, mes ORDER BY NombreComuna, mes';
        $cantidades = DB::connection('mysql_rem')->select($query);

        foreach($cantidades as $cantidad) {
            if($comuna == null){
                $data[17]['total_numerador'] += $cantidad->numerador;
            } else {
                $data[$cantidad->NombreComuna][17]['numeradores'][$cantidad->mes] = $cantidad->numerador;
                $data[$cantidad->NombreComuna][17]['ct_marzo'] += $cantidad->numerador;
            }
        }

        // foreach($poblaciones_20a_a_64a as $poblacion) {
        //     $data[$poblacion->NombreComuna][17]['poblacion'] = $poblacion->poblacion;
        // }

        $denominadores = ['IQUIQUE' => 4512, 'ALTO HOSPICIO' => 30, 'POZO ALMONTE' => 32, 'PICA' => 4, 
                          'HUARA' => 0, 'CAMIÑA' => 2, 'COLCHANE' => 0, 'HECTOR REYNO' => 49];

        if($comuna == null)
            foreach($denominadores as $denominador) $data[17]['total_denominador'] += $denominador;
        else
            $data[$comuna->name][17]['actividadesProgramadas'] = $denominadores[$comuna->name];

        /* 18 */
        $query ='SELECT
                    IF(Codigo = 102307, "HECTOR REYNO", comuna) AS NombreComuna, mes,
                    SUM(COALESCE(Col01,0)) AS numerador FROM 2020rems r
                JOIN 2020establecimientos e ON r.IdEstablecimiento = e.Codigo
                WHERE CodigoPrestacion IN (01080008)
                AND r.mes IN (1,2,3,4,5,6,7,8,9,10,11)
                AND r.IdEstablecimiento NOT IN (102100,102600,102601,102602,102011) '
                . $filter_commune_reyno . ' 
                GROUP BY NombreComuna, mes ORDER BY NombreComuna, mes';
        $cantidades = DB::connection('mysql_rem')->select($query);

        foreach($cantidades as $cantidad) {
            if($comuna == null){
                $data[18]['total_numerador'] += $cantidad->numerador;
            } else {
                $data[$cantidad->NombreComuna][18]['numeradores'][$cantidad->mes] = $cantidad->numerador;
                $data[$cantidad->NombreComuna][18]['ct_marzo'] += $cantidad->numerador;
            }
        }

        // $query ='SELECT
        //             IF(COD_CENTRO = 102307, "HECTOR REYNO", comuna) AS NombreComuna,
        //             COUNT(*) poblacion FROM percapita_pro p
        //         LEFT JOIN 2020establecimientos e
        //         ON p.COD_CENTRO = e.Codigo
        //         WHERE p.AUTORIZADO = "X" AND p.EDAD >= 10 AND p.GENERO = "M" '. $filter_commune_reyno . ' 
        //         GROUP BY NombreComuna, comuna ORDER BY comuna';
        // $poblaciones = DB::connection('mysql_rem')->select($query);

        // foreach($poblaciones as $poblacion) {
        //     $data[$poblacion->NombreComuna][18]['poblacion'] = $poblacion->poblacion;
        // }

        $denominadores = ['IQUIQUE' => 0, 'ALTO HOSPICIO' => 700, 'POZO ALMONTE' => 25, 'PICA' => 495, 
                          'HUARA' => 16, 'CAMIÑA' => 0, 'COLCHANE' => 0, 'HECTOR REYNO' => 431];

        if($comuna == null)
            foreach($denominadores as $denominador) $data[18]['total_denominador'] += $denominador;
        else
            $data[$comuna->name][18]['actividadesProgramadas'] = $denominadores[$comuna->name];

        /* 19 */
        $query ='SELECT
                    IF(Codigo = 102307, "HECTOR REYNO", comuna) AS NombreComuna, mes,
                    SUM(COALESCE(Col04,0) + COALESCE(Col05,0) + COALESCE(Col06,0) +
                        COALESCE(Col07,0) + COALESCE(Col08,0) + COALESCE(Col09,0) +
                        COALESCE(Col10,0) + COALESCE(Col11,0))
                        AS numerador FROM 2020rems r
                JOIN 2020establecimientos e ON r.IdEstablecimiento = e.Codigo
                WHERE CodigoPrestacion IN (01080011, 05810443, 01080021, 01080022, 01080023, 01090060, 01080024, 01080013, 01080014)
                AND r.mes IN (1,2,3,4,5,6,7,8,9,10,11)
                AND r.IdEstablecimiento NOT IN (102100,102600,102601,102602,102011) '
                . $filter_commune_reyno . ' 
                GROUP BY NombreComuna, mes ORDER BY NombreComuna, mes';
        $cantidades = DB::connection('mysql_rem')->select($query);

        foreach($cantidades as $cantidad) {
            if($comuna == null){
                $data[19]['total_numerador'] += $cantidad->numerador;
            } else {
                $data[$cantidad->NombreComuna][19]['numeradores'][$cantidad->mes] = $cantidad->numerador;
                $data[$cantidad->NombreComuna][19]['ct_marzo'] += $cantidad->numerador;
            }
        }

        // $query ='SELECT
        //             IF(COD_CENTRO = 102307, "HECTOR REYNO", comuna) AS NombreComuna,
        //             COUNT(*) poblacion FROM percapita_pro p
        //         LEFT JOIN 2020establecimientos e
        //         ON p.COD_CENTRO = e.Codigo
        //         WHERE p.AUTORIZADO = "X" AND p.EDAD >= 20 AND p.GENERO = "M" '. $filter_commune_reyno . ' 
        //         GROUP BY NombreComuna, comuna ORDER BY comuna';
        // $poblaciones = DB::connection('mysql_rem')->select($query);

        // foreach($poblaciones as $poblacion) {
        //     $data[$poblacion->NombreComuna][19]['poblacion'] = $poblacion->poblacion;
        // }

        $denominadores = ['IQUIQUE' => 346, 'ALTO HOSPICIO' => 728, 'POZO ALMONTE' => 80, 'PICA' => 4175, 
                          'HUARA' => 34, 'CAMIÑA' => 1, 'COLCHANE' => 0, 'HECTOR REYNO' => 339];

        if($comuna == null)
            foreach($denominadores as $denominador) $data[19]['total_denominador'] += $denominador;
        else
            $data[$comuna->name][19]['actividadesProgramadas'] = $denominadores[$comuna->name];

        /* 20 */
        $query ='SELECT
                IF(Codigo = 102307, "HECTOR REYNO", comuna) AS NombreComuna, mes,
                SUM(COALESCE(Col13,0) + COALESCE(Col15,0) + COALESCE(Col17,0) +
                    COALESCE(Col19,0) + COALESCE(Col21,0) + COALESCE(Col23,0))
                    AS numerador FROM 2020rems r
                JOIN 2020establecimientos e ON r.IdEstablecimiento = e.Codigo
                WHERE CodigoPrestacion IN (19120601, 19120602, 19120603, 19120606, 19120608, 19120609, 19120611)
                AND r.mes IN (1,2,3,4,5,6,7,8,9,10,11)
                AND r.IdEstablecimiento NOT IN (102100,102600,102601,102602,102011) '
                . $filter_commune_reyno . ' 
                GROUP BY NombreComuna, mes ORDER BY NombreComuna, mes';
        $cantidades = DB::connection('mysql_rem')->select($query);

        foreach($cantidades as $cantidad) {
            if($comuna == null){
                $data[20]['total_numerador'] += $cantidad->numerador;
            } else {
                $data[$cantidad->NombreComuna][20]['numeradores'][$cantidad->mes] = $cantidad->numerador;
                $data[$cantidad->NombreComuna][20]['ct_marzo'] += $cantidad->numerador;
            }
        }

        // $query ='SELECT
        //             IF(COD_CENTRO = 102307, "HECTOR REYNO", comuna) AS NombreComuna, mes,
        //             COUNT(*) poblacion FROM percapita_pro p
        //         LEFT JOIN 2020establecimientos e
        //         ON p.COD_CENTRO = e.Codigo
        //         WHERE p.AUTORIZADO = "X" AND p.EDAD BETWEEN 20 AND 49 AND p.GENERO = "M" '. $filter_commune_reyno . ' 
        //         GROUP BY NombreComuna, comuna ORDER BY comuna';
        // $poblaciones_20a_a_49a_m = DB::connection('mysql_rem')->select($query);

        // foreach($poblaciones_20a_a_49a_m as $poblacion) {
        //     $data[$poblacion->NombreComuna][20]['poblacion'] = $poblacion->poblacion;
        // }

        $denominadores = ['IQUIQUE' => 6631, 'ALTO HOSPICIO' => 1233, 'POZO ALMONTE' => 237, 'PICA' => 675, 
                          'HUARA' => 266, 'CAMIÑA' => 79, 'COLCHANE' => 0, 'HECTOR REYNO' => 410];

        if($comuna == null)
            foreach($denominadores as $denominador) $data[20]['total_denominador'] += $denominador;
        else
            $data[$comuna->name][20]['actividadesProgramadas'] = $denominadores[$comuna->name];

        /* 21 */
        $query ='SELECT
                IF(Codigo = 102307, "HECTOR REYNO", comuna) AS NombreComuna, mes,
                SUM(COALESCE(Col05,0) + COALESCE(Col06,0) + COALESCE(Col07,0) +
                    COALESCE(Col08,0) + COALESCE(Col09,0) + COALESCE(Col10,0) +
                    COALESCE(Col11,0) + COALESCE(Col12,0) + COALESCE(Col13,0))
                    AS numerador FROM 2020rems r
                JOIN 2020establecimientos e ON r.IdEstablecimiento = e.Codigo
                WHERE CodigoPrestacion IN (01010601, 01010603)
                AND r.mes IN (1,2,3,4,5,6,7,8,9,10,11)
                AND r.IdEstablecimiento NOT IN (102100,102600,102601,102602,102011) '
                . $filter_commune_reyno . ' 
                GROUP BY NombreComuna, mes ORDER BY NombreComuna, mes';
        $cantidades = DB::connection('mysql_rem')->select($query);

        foreach($cantidades as $cantidad) {
            if($comuna == null){
                $data[21]['total_numerador'] += $cantidad->numerador;
            } else {
                $data[$cantidad->NombreComuna][21]['numeradores'][$cantidad->mes] = $cantidad->numerador;
                $data[$cantidad->NombreComuna][21]['ct_marzo'] += $cantidad->numerador;
            }
        }

        // $query ='SELECT
        //             IF(COD_CENTRO = 102307, "HECTOR REYNO", comuna) AS NombreComuna,
        //             COUNT(*) poblacion FROM percapita_pro p
        //         LEFT JOIN 2020establecimientos e
        //         ON p.COD_CENTRO = e.Codigo
        //         WHERE p.AUTORIZADO = "X" AND p.EDAD BETWEEN 20 AND 64 AND p.GENERO = "M" '. $filter_commune_reyno . ' 
        //         GROUP BY NombreComuna, comuna ORDER BY comuna';
        // $poblaciones = DB::connection('mysql_rem')->select($query);

        // foreach($poblaciones as $poblacion) {
        //     $data[$poblacion->NombreComuna][21]['poblacion'] = $poblacion->poblacion;
        // }

        $denominadores = ['IQUIQUE' => 16190, 'ALTO HOSPICIO' => 3800, 'POZO ALMONTE' => 474, 'PICA' => 1713, 
                          'HUARA' => 140, 'CAMIÑA' => 128, 'COLCHANE' => 0, 'HECTOR REYNO' => 965];

        if($comuna == null)
            foreach($denominadores as $denominador) $data[21]['total_denominador'] += $denominador;
        else
            $data[$comuna->name][21]['actividadesProgramadas'] = $denominadores[$comuna->name];


        /* 22 */
        $query ='SELECT
               IF(Codigo = 102307, "HECTOR REYNO", comuna) AS NombreComuna, mes,
               SUM(COALESCE(Col09,0) + COALESCE(Col10,0) + COALESCE(Col11,0) + COALESCE(Col12,0) + COALESCE(Col13,0)) AS numerador FROM 2020rems r
                JOIN 2020establecimientos e ON r.IdEstablecimiento = e.Codigo
                WHERE CodigoPrestacion IN (01010901, 01010903)
                AND r.mes IN (1,2,3,4,5,6,7,8,9,10,11)
                AND r.IdEstablecimiento NOT IN (102100,102600,102601,102602,102011) '
                . $filter_commune_reyno . ' 
                GROUP BY NombreComuna, mes ORDER BY NombreComuna, mes';
        $cantidades = DB::connection('mysql_rem')->select($query);

        foreach($cantidades as $cantidad) {
            if($comuna == null){
                $data[22]['total_numerador'] += $cantidad->numerador;
            } else {
                $data[$cantidad->NombreComuna][22]['numeradores'][$cantidad->mes] = $cantidad->numerador;
                $data[$cantidad->NombreComuna][22]['ct_marzo'] += $cantidad->numerador;
            }
        }

        // $query ='SELECT
        //             IF(COD_CENTRO = 102307, "HECTOR REYNO", comuna) AS NombreComuna,
        //             COUNT(*) poblacion FROM percapita_pro p
        //         LEFT JOIN 2020establecimientos e
        //         ON p.COD_CENTRO = e.Codigo
        //         WHERE p.AUTORIZADO = "X" AND p.EDAD BETWEEN 45 AND 64 AND p.GENERO = "M" '. $filter_commune_reyno . ' 
        //         GROUP BY NombreComuna, comuna ORDER BY comuna';
        // $poblaciones = DB::connection('mysql_rem')->select($query);

        // foreach($poblaciones as $poblacion) {
        //     $data[$poblacion->NombreComuna][22]['poblacion'] = $poblacion->poblacion;
        // }

        $denominadores = ['IQUIQUE' => 651, 'ALTO HOSPICIO' => 46, 'POZO ALMONTE' => 26, 'PICA' => 50, 
                          'HUARA' => 24, 'CAMIÑA' => 6, 'COLCHANE' => 0, 'HECTOR REYNO' => 15];

        if($comuna == null)
            foreach($denominadores as $denominador) $data[22]['total_denominador'] += $denominador;
        else
            $data[$comuna->name][22]['actividadesProgramadas'] = $denominadores[$comuna->name];

        /* 23 */
        $query ='SELECT
               IF(Codigo = 102307, "HECTOR REYNO", comuna) AS NombreComuna, mes,
               SUM(COALESCE(Col01,0)) AS numerador FROM 2020rems r
                JOIN 2020establecimientos e ON r.IdEstablecimiento = e.Codigo
                WHERE CodigoPrestacion IN (19120701, 19120702, 19120703, 19120706, 19120708, 19120709,  19120711)
                AND r.mes IN (1,2,3,4,5,6,7,8,9,10,11)
                AND r.IdEstablecimiento NOT IN (102100,102600,102601,102602,102011) '
                . $filter_commune_reyno . ' 
                GROUP BY NombreComuna, mes ORDER BY NombreComuna, mes';
        $cantidades = DB::connection('mysql_rem')->select($query);

        foreach($cantidades as $cantidad) {
            if($comuna == null){
                $data[23]['total_numerador'] += $cantidad->numerador;
            } else {
                $data[$cantidad->NombreComuna][23]['numeradores'][$cantidad->mes] = $cantidad->numerador;
                $data[$cantidad->NombreComuna][23]['ct_marzo'] += $cantidad->numerador;
            }
        }

        // $query ='SELECT
        //             IF(COD_CENTRO = 102307, "HECTOR REYNO", comuna) AS NombreComuna,
        //             COUNT(*) poblacion FROM percapita_pro p
        //         LEFT JOIN 2020establecimientos e
        //         ON p.COD_CENTRO = e.Codigo
        //         WHERE p.AUTORIZADO = "X" AND p.EDAD >= 10 '. $filter_commune_reyno . ' 
        //         GROUP BY NombreComuna, comuna ORDER BY comuna';
        // $poblaciones = DB::connection('mysql_rem')->select($query);

        // foreach($poblaciones as $poblacion) {
        //     $data[$poblacion->NombreComuna][23]['poblacion'] = $poblacion->poblacion;
        // }

        $denominadores = ['IQUIQUE' => 1592, 'ALTO HOSPICIO' => 3082, 'POZO ALMONTE' => 710, 'PICA' => 98, 
                          'HUARA' => 124, 'CAMIÑA' => 234, 'COLCHANE' => 0, 'HECTOR REYNO' => 107];

        if($comuna == null)
            foreach($denominadores as $denominador) $data[23]['total_denominador'] += $denominador;
        else
            $data[$comuna->name][23]['actividadesProgramadas'] = $denominadores[$comuna->name];

        /* 24 */
        $query ='SELECT
                    IF(Codigo = 102307, "HECTOR REYNO", comuna) AS NombreComuna, mes,
                    SUM(COALESCE(Col06,0) + COALESCE(Col07,0) + COALESCE(Col08,0) + COALESCE(Col09,0) + COALESCE(Col10,0) + COALESCE(Col11,0) +
                        COALESCE(Col12,0) + COALESCE(Col13,0) + COALESCE(Col14,0) + COALESCE(Col15,0) + COALESCE(Col16,0) + COALESCE(Col17,0) + 
                        COALESCE(Col18,0) + COALESCE(Col19,0) + COALESCE(Col20,0) + COALESCE(Col21,0) + COALESCE(Col22,0) + COALESCE(Col23,0) + 
                        COALESCE(Col24,0) + COALESCE(Col25,0) + COALESCE(Col26,0) + COALESCE(Col27,0) + COALESCE(Col28,0) + COALESCE(Col29,0) + 
                        COALESCE(Col30,0) + COALESCE(Col31,0) + COALESCE(Col32,0) + COALESCE(Col33,0) + COALESCE(Col34,0) + COALESCE(Col35,0) + 
                        COALESCE(Col36,0) + COALESCE(Col37,0)) AS numerador FROM 2020rems r
                JOIN 2020establecimientos e ON r.IdEstablecimiento = e.Codigo
                WHERE CodigoPrestacion IN (06902700)
                AND r.mes IN (1,2,3,4,5,6,7,8,9,10,11)
                AND r.IdEstablecimiento NOT IN (102100,102600,102601,102602,102011) '
                . $filter_commune_reyno . ' 
                GROUP BY NombreComuna, mes ORDER BY NombreComuna, mes';
        $cantidades = DB::connection('mysql_rem')->select($query);

        foreach($cantidades as $cantidad) {
            if($comuna == null){
                $data[24]['total_numerador'] += $cantidad->numerador;
            } else {
                $data[$cantidad->NombreComuna][24]['numeradores'][$cantidad->mes] = $cantidad->numerador;
                $data[$cantidad->NombreComuna][24]['ct_marzo'] += $cantidad->numerador;
            }
        }

        // $query ='SELECT
        //             IF(COD_CENTRO = 102307, "HECTOR REYNO", comuna) AS NombreComuna,
        //             COUNT(*) poblacion FROM percapita_pro p
        //         LEFT JOIN 2020establecimientos e
        //         ON p.COD_CENTRO = e.Codigo
        //         WHERE p.AUTORIZADO = "X" AND p.EDAD > 4 '. $filter_commune_reyno . ' 
        //         GROUP BY NombreComuna, comuna ORDER BY comuna';
        // $poblaciones = DB::connection('mysql_rem')->select($query);

        // foreach($poblaciones as $poblacion) {
        //     $data[$poblacion->NombreComuna][24]['poblacion'] = $poblacion->poblacion;
        // }

        $denominadores = ['IQUIQUE' => 119, 'ALTO HOSPICIO' => 5, 'POZO ALMONTE' => 40, 'PICA' => 0, 
                          'HUARA' => 3, 'CAMIÑA' => 0, 'COLCHANE' => 80, 'HECTOR REYNO' => 159];

        if($comuna == null)
            foreach($denominadores as $denominador) $data[24]['total_denominador'] += $denominador;
        else
            $data[$comuna->name][24]['actividadesProgramadas'] = $denominadores[$comuna->name];

        /* 25 */
        $query ='SELECT
               IF(Codigo = 102307, "HECTOR REYNO", comuna) AS NombreComuna, mes,
               SUM(COALESCE(Col01,0)) AS numerador FROM 2020rems r
                JOIN 2020establecimientos e ON r.IdEstablecimiento = e.Codigo
                WHERE CodigoPrestacion IN (06020201)
                AND r.mes IN (1,2,3,4,5,6,7,8,9,10,11)
                AND r.IdEstablecimiento NOT IN (102100,102600,102601,102602,102011) '
                . $filter_commune_reyno . ' 
                GROUP BY NombreComuna, mes ORDER BY NombreComuna, mes';
        $cantidades = DB::connection('mysql_rem')->select($query);

        foreach($cantidades as $cantidad) {
            if($comuna == null){
                $data[25]['total_numerador'] += $cantidad->numerador;
            } else {
                $data[$cantidad->NombreComuna][25]['numeradores'][$cantidad->mes] = $cantidad->numerador;
                $data[$cantidad->NombreComuna][25]['ct_marzo'] += $cantidad->numerador;
            }
        }

        // $query ='SELECT
        //             IF(Codigo = 102307, "HECTOR REYNO", comuna) AS NombreComuna,
        //             SUM(COALESCE(Col01,0)) AS numerador FROM 2020rems r
        //         JOIN 2020establecimientos e ON r.IdEstablecimiento = e.Codigo
        //         WHERE CodigoPrestacion IN ("P6221000")
        //         AND r.mes IN (6) '. $filter_commune_reyno . ' 
        //         GROUP BY NombreComuna, mes ORDER BY NombreComuna, mes';
        // $poblaciones = DB::connection('mysql_rem')->select($query);

        // foreach($poblaciones as $poblacion) {
        //     $data[$poblacion->NombreComuna][25]['poblacion'] = $poblacion->total;
        //     $data[$poblacion->NombreComuna][26]['poblacion'] = $poblacion->total;
        // }

        $denominadores = ['IQUIQUE' => 509, 'ALTO HOSPICIO' => 1915, 'POZO ALMONTE' => 245, 'PICA' => 260, 
                          'HUARA' => 24, 'CAMIÑA' => 0, 'COLCHANE' => 24, 'HECTOR REYNO' => 7939];

        if($comuna == null)
            foreach($denominadores as $denominador) $data[25]['total_denominador'] += $denominador;
        else
            $data[$comuna->name][25]['actividadesProgramadas'] = $denominadores[$comuna->name];

        /* 26 */
        $query ='SELECT
               IF(Codigo = "102307", "HECTOR REYNO", comuna) AS NombreComuna, mes,
               SUM(COALESCE(Col01,0)) AS numerador FROM 2020rems r
                JOIN 2020establecimientos e ON r.IdEstablecimiento = e.Codigo
                WHERE CodigoPrestacion IN (06020208)
                AND r.mes IN (1,2,3,4,5,6,7,8,9,10,11)
                AND r.IdEstablecimiento NOT IN (102100,102600,102601,102602,102011) '
                . $filter_commune_reyno . ' 
                GROUP BY NombreComuna, mes ORDER BY NombreComuna, mes';
        $cantidades = DB::connection('mysql_rem')->select($query);

        foreach($cantidades as $cantidad) {
            if($comuna == null){
                $data[26]['total_numerador'] += $cantidad->numerador;
            } else {
                $data[$cantidad->NombreComuna][26]['numeradores'][$cantidad->mes] = $cantidad->numerador;
                $data[$cantidad->NombreComuna][26]['ct_marzo'] += $cantidad->numerador;
            }
        }

        $denominadores = ['IQUIQUE' => 5604, 'ALTO HOSPICIO' => 10175, 'POZO ALMONTE' => 245, 'PICA' => 2108, 
                          'HUARA' => 48, 'CAMIÑA' => 0, 'COLCHANE' => 72, 'HECTOR REYNO' => 11182];

        if($comuna == null)
            foreach($denominadores as $denominador) $data[26]['total_denominador'] += $denominador;
        else
            $data[$comuna->name][26]['actividadesProgramadas'] = $denominadores[$comuna->name];

        /* 27 */
        $query ='SELECT
                    IF(Codigo = 102307, "HECTOR REYNO", comuna) AS NombreComuna, mes,
                    SUM(COALESCE(Col07,0) + COALESCE(Col08,0)) AS numerador FROM 2020rems r
                JOIN 2020establecimientos e ON r.IdEstablecimiento = e.Codigo
                WHERE CodigoPrestacion IN (27300919,27300920)
                AND r.mes IN (1,2,3,4,5,6,7,8,9,10,11)
                AND r.IdEstablecimiento NOT IN (102100,102600,102601,102602,102011) '
                . $filter_commune_reyno . ' 
                GROUP BY NombreComuna, mes ORDER BY NombreComuna, mes';
        $cantidades = DB::connection('mysql_rem')->select($query);

        foreach($cantidades as $cantidad) {
            if($comuna == null){
                $data[27]['total_numerador'] += $cantidad->numerador;
            } else {
                $data[$cantidad->NombreComuna][27]['numeradores'][$cantidad->mes] = $cantidad->numerador;
                $data[$cantidad->NombreComuna][27]['ct_marzo'] += $cantidad->numerador;
            }
        }

        // foreach($poblaciones_10a_a_19a as $poblacion) {
        //     $data[$poblacion->NombreComuna][27]['poblacion'] = $poblacion->poblacion;
        // }

        $denominadores = ['IQUIQUE' => 0, 'ALTO HOSPICIO' => 800, 'POZO ALMONTE' => 249, 'PICA' => 2, 
                          'HUARA' => 312, 'CAMIÑA' => 0, 'COLCHANE' => 40, 'HECTOR REYNO' => 25];

        if($comuna == null)
            foreach($denominadores as $denominador) $data[27]['total_denominador'] += $denominador;
        else
            $data[$comuna->name][27]['actividadesProgramadas'] = $denominadores[$comuna->name];

        /* 28 */
        $query ='SELECT
                    IF(Codigo = 102307, "HECTOR REYNO", comuna) AS NombreComuna, mes,
                    SUM(
                        COALESCE(Col01,0)
                    ) AS numerador FROM 2020rems r
                JOIN 2020establecimientos e ON r.IdEstablecimiento = e.Codigo
                WHERE CodigoPrestacion IN (27300500, 27290100, 27290200)
                AND r.mes IN (1,2,3,4,5,6,7,8,9,10,11)
                AND r.IdEstablecimiento NOT IN (102100,102600,102601,102602,102011) '
                . $filter_commune_reyno . ' 
                GROUP BY NombreComuna, mes ORDER BY NombreComuna, mes';
        $cantidades = DB::connection('mysql_rem')->select($query);

        foreach($cantidades as $cantidad) {
            if($comuna == null){
                $data[28]['total_numerador'] += $cantidad->numerador;
            } else {
                $data[$cantidad->NombreComuna][28]['numeradores'][$cantidad->mes] = $cantidad->numerador;
                $data[$cantidad->NombreComuna][28]['ct_marzo'] += $cantidad->numerador;
            }
        }

        // foreach($poblaciones_10a_a_64a as $poblacion) {
        //     $data[$poblacion->NombreComuna][28]['poblacion'] = $poblacion->poblacion;
        // }

        $denominadores = ['IQUIQUE' => 0, 'ALTO HOSPICIO' => 0, 'POZO ALMONTE' => 540, 'PICA' => 11, 
                          'HUARA' => 0, 'CAMIÑA' => 0, 'COLCHANE' => 258, 'HECTOR REYNO' => 0];

        if($comuna == null)
            foreach($denominadores as $denominador) $data[28]['total_denominador'] += $denominador;
        else
            $data[$comuna->name][28]['actividadesProgramadas'] = $denominadores[$comuna->name];

        /* 29 */
        $query ='SELECT
                    IF(Codigo = 102307, "HECTOR REYNO", comuna) AS NombreComuna, mes,
                    SUM(COALESCE(Col30,0) + COALESCE(Col31,0) +
                        COALESCE(Col32,0) + COALESCE(Col33,0) + COALESCE(Col34,0) +
                        COALESCE(Col35,0) + COALESCE(Col36,0) + COALESCE(Col37,0))
                        AS numerador FROM 2020rems r
                JOIN 2020establecimientos e ON r.IdEstablecimiento = e.Codigo
                WHERE CodigoPrestacion IN ("01030100A", "01030200B")
                AND r.mes IN (1,2,3,4,5,6,7,8,9,10,11)
                AND r.IdEstablecimiento NOT IN (102100,102600,102601,102602,102011) '
                . $filter_commune_reyno . ' 
                GROUP BY NombreComuna, mes ORDER BY NombreComuna, mes';
        $cantidades = DB::connection('mysql_rem')->select($query);

        foreach($cantidades as $cantidad) {
            if($comuna == null){
                $data[29]['total_numerador'] += $cantidad->numerador;
            } else {
                $data[$cantidad->NombreComuna][29]['numeradores'][$cantidad->mes] = $cantidad->numerador;
                $data[$cantidad->NombreComuna][29]['ct_marzo'] += $cantidad->numerador;
            }
        }

        // foreach($poblaciones_mayor_64a as $poblacion) {
        //     $data[$poblacion->NombreComuna][29]['poblacion'] = $poblacion->poblacion;
        // }

        $denominadores = ['IQUIQUE' => 9101, 'ALTO HOSPICIO' => 404, 'POZO ALMONTE' => 701, 'PICA' => 14, 
                          'HUARA' => 26, 'CAMIÑA' => 17, 'COLCHANE' => 22, 'HECTOR REYNO' => 266];

        if($comuna == null)
            foreach($denominadores as $denominador) $data[29]['total_denominador'] += $denominador;
        else
            $data[$comuna->name][29]['actividadesProgramadas'] = $denominadores[$comuna->name];

        /* 30 */
        $query ='SELECT
               IF(Codigo = 102307, "HECTOR REYNO", comuna) AS NombreComuna, mes,
               SUM(COALESCE(Col01,0)) AS numerador FROM 2020rems r
                JOIN 2020establecimientos e ON r.IdEstablecimiento = e.Codigo
                WHERE CodigoPrestacion IN (16100300, 16200220, 16100600, 16100700, 16100100)
                AND r.mes IN (1,2,3,4,5,6,7,8,9,10,11)
                AND r.IdEstablecimiento NOT IN (102100,102600,102601,102602,102011) '
                . $filter_commune_reyno . ' 
                GROUP BY NombreComuna, mes ORDER BY NombreComuna, mes';
        $cantidades = DB::connection('mysql_rem')->select($query);

        foreach($cantidades as $cantidad) {
            if($comuna == null){
                $data[30]['total_numerador'] += $cantidad->numerador;
            } else {
                $data[$cantidad->NombreComuna][30]['numeradores'][$cantidad->mes] = $cantidad->numerador;
                $data[$cantidad->NombreComuna][30]['ct_marzo'] += $cantidad->numerador;
            }
        }

        // $query ='SELECT
        //             IF(COD_CENTRO = 102307, "HECTOR REYNO", comuna) AS NombreComuna,
        //             COUNT(*) poblacion FROM percapita_pro p
        //         LEFT JOIN 2020establecimientos e
        //         ON p.COD_CENTRO = e.Codigo
        //         WHERE p.AUTORIZADO = "X" AND p.EDAD >= 65 '. $filter_commune_reyno . ' 
        //         GROUP BY NombreComuna, comuna ORDER BY comuna';
        // $poblaciones = DB::connection('mysql_rem')->select($query);

        // foreach($poblaciones as $poblacion) {
        //     $data[$poblacion->NombreComuna][30]['poblacion'] = $poblacion->poblacion;
        // }

        $denominadores = ['IQUIQUE' => 0, 'ALTO HOSPICIO' => 10011, 'POZO ALMONTE' => 3446, 'PICA' => 1944, 
                          'HUARA' => 143, 'CAMIÑA' => 1344, 'COLCHANE' => 2340, 'HECTOR REYNO' => 2498];

        if($comuna == null)
            foreach($denominadores as $denominador) $data[30]['total_denominador'] += $denominador;
        else
            $data[$comuna->name][30]['actividadesProgramadas'] = $denominadores[$comuna->name];

        /* 31 */
        $query ='SELECT
                    IF(Codigo = 102307, "HECTOR REYNO", comuna) AS NombreComuna, mes,
                    SUM(
						  COALESCE(Col01,0)
						  ) AS numerador FROM 2020rems r
                JOIN 2020establecimientos e ON r.IdEstablecimiento = e.Codigo
                WHERE CodigoPrestacion IN (03500361, 03500362)
                AND r.mes IN (1,2,3,4,5,6,7,8,9,10,11)
                AND r.IdEstablecimiento NOT IN (102100,102600,102601,102602,102011) '
                . $filter_commune_reyno . ' 
                GROUP BY NombreComuna, mes ORDER BY NombreComuna, mes';
        $cantidades = DB::connection('mysql_rem')->select($query);

        foreach($cantidades as $cantidad) {
            if($comuna == null){
                $data[31]['total_numerador'] += $cantidad->numerador;
            } else {
                $data[$cantidad->NombreComuna][31]['numeradores'][$cantidad->mes] = $cantidad->numerador;
                $data[$cantidad->NombreComuna][31]['ct_marzo'] += $cantidad->numerador;
            }
        }

        // foreach($poblaciones_total as $poblacion) {
        //     $data[$poblacion->NombreComuna][31]['poblacion'] = $poblacion->poblacion;
        // }

        $denominadores = ['IQUIQUE' => 0, 'ALTO HOSPICIO' => 93, 'POZO ALMONTE' => 80, 'PICA' => 14, 
                          'HUARA' => 16, 'CAMIÑA' => 5, 'COLCHANE' => 12, 'HECTOR REYNO' => 27];

        if($comuna == null)
            foreach($denominadores as $denominador) $data[31]['total_denominador'] += $denominador;
        else
            $data[$comuna->name][31]['actividadesProgramadas'] = $denominadores[$comuna->name];

        /* 32 */
        $query ='SELECT
                    IF(Codigo = 102307, "HECTOR REYNO", comuna) AS NombreComuna, mes,
                    SUM(COALESCE(Col04,0) + COALESCE(Col05,0) + COALESCE(Col06,0) +
                        COALESCE(Col07,0) + COALESCE(Col08,0) + COALESCE(Col09,0))
                        AS numerador FROM 2020rems r
                JOIN 2020establecimientos e ON r.IdEstablecimiento = e.Codigo
                WHERE CodigoPrestacion IN (04040423, 04040424, 04040425, 04040426)
                AND r.mes IN (1,2,3,4,5,6,7,8,9,10,11)
                AND r.IdEstablecimiento NOT IN (102100,102600,102601,102602,102011) '
                . $filter_commune_reyno . ' 
                GROUP BY NombreComuna, mes ORDER BY NombreComuna, mes';
        $cantidades = DB::connection('mysql_rem')->select($query);

        foreach($cantidades as $cantidad) {
            if($comuna == null){
                $data[32]['total_numerador'] += $cantidad->numerador;
            } else {
                $data[$cantidad->NombreComuna][32]['numeradores'][$cantidad->mes] = $cantidad->numerador;
                $data[$cantidad->NombreComuna][32]['ct_marzo'] += $cantidad->numerador;
            }
        }

        // $query ='SELECT
        //             IF(COD_CENTRO = 102307, "HECTOR REYNO", comuna) AS NombreComuna,
        //             COUNT(*) poblacion FROM percapita_pro p
        //         LEFT JOIN 2020establecimientos e
        //         ON p.COD_CENTRO = e.Codigo
        //         WHERE p.AUTORIZADO = "X" AND p.EDAD = 0
        //         AND TIMESTAMPDIFF(MONTH, FECHA_NACIMIENTO, FECHA_CORTE) <= 6 '
        //         . $filter_commune_reyno . ' 
        //         GROUP BY NombreComuna, comuna ORDER BY comuna';
        // $poblaciones = DB::connection('mysql_rem')->select($query);

        // foreach($poblaciones as $poblacion) {
        //     $data[$poblacion->NombreComuna][32]['poblacion'] = $poblacion->poblacion;
        // }

        $denominadores = ['IQUIQUE' => 80, 'ALTO HOSPICIO' => 81, 'POZO ALMONTE' => 7, 'PICA' => 821, 
                          'HUARA' => 40, 'CAMIÑA' => 23, 'COLCHANE' => 1, 'HECTOR REYNO' => 1478];

        if($comuna == null)
            foreach($denominadores as $denominador) $data[32]['total_denominador'] += $denominador;
        else
            $data[$comuna->name][32]['actividadesProgramadas'] = $denominadores[$comuna->name];

        /* 33 */
        $query ='SELECT
                    IF(Codigo = 102307, "HECTOR REYNO", comuna) AS NombreComuna, mes,
                    SUM(COALESCE(Col04,0) + COALESCE(Col05,0) + COALESCE(Col06,0) + 
                        COALESCE(Col07,0) + COALESCE(Col08,0) + COALESCE(Col09,0)) AS numerador FROM 2020rems r
                JOIN 2020establecimientos e ON r.IdEstablecimiento = e.Codigo
                WHERE CodigoPrestacion IN (04050120)
                AND r.mes IN (1,2,3,4,5,6,7,8,9,10,11)
                AND r.IdEstablecimiento NOT IN (102100,102600,102601,102602,102011) '
                . $filter_commune_reyno . ' 
                GROUP BY NombreComuna, mes ORDER BY NombreComuna, mes';
        $cantidades = DB::connection('mysql_rem')->select($query);

        foreach($cantidades as $cantidad) {
            if($comuna == null){
                $data[33]['total_numerador'] += $cantidad->numerador;
            } else {
                $data[$cantidad->NombreComuna][33]['numeradores'][$cantidad->mes] = $cantidad->numerador;
                $data[$cantidad->NombreComuna][33]['ct_marzo'] += $cantidad->numerador;
            }
        }

        // $query ='SELECT
        //             IF(COD_CENTRO = 102307, "HECTOR REYNO", comuna) AS NombreComuna,
        //             COUNT(*) poblacion FROM percapita_pro p
        //         LEFT JOIN 2020establecimientos e
        //         ON p.COD_CENTRO = e.Codigo
        //         WHERE p.AUTORIZADO = "X" AND p.EDAD < 10 '. $filter_commune_reyno . ' 
        //         GROUP BY NombreComuna, comuna ORDER BY comuna';
        // $poblaciones = DB::connection('mysql_rem')->select($query);

        // foreach($poblaciones as $poblacion) {
        //     $data[$poblacion->NombreComuna][33]['poblacion'] = $poblacion->poblacion;
        // }

        $denominadores = ['IQUIQUE' => 5267, 'ALTO HOSPICIO' => 1275, 'POZO ALMONTE' => 346, 'PICA' => 48, 
                          'HUARA' => 54, 'CAMIÑA' => 9, 'COLCHANE' => 8, 'HECTOR REYNO' => 244];

        if($comuna == null)
            foreach($denominadores as $denominador) $data[33]['total_denominador'] += $denominador;
        else
            $data[$comuna->name][33]['actividadesProgramadas'] = $denominadores[$comuna->name];

        /* 34 */
        $query ='SELECT
                    IF(Codigo = 102307, "HECTOR REYNO", comuna) AS NombreComuna, mes,
                    SUM(COALESCE(Col04,0) + COALESCE(Col05,0) + COALESCE(Col06,0) + 
                        COALESCE(Col07,0) + COALESCE(Col08,0) + COALESCE(Col09,0)) AS numerador FROM 2020rems r
                JOIN 2020establecimientos e ON r.IdEstablecimiento = e.Codigo
                WHERE CodigoPrestacion IN (04050110)
                AND r.mes IN (1,2,3,4,5,6,7,8,9,10,11)
                AND r.IdEstablecimiento NOT IN (102100,102600,102601,102602,102011) '
                . $filter_commune_reyno . ' 
                GROUP BY NombreComuna, mes ORDER BY NombreComuna, mes';
        $cantidades = DB::connection('mysql_rem')->select($query);

        foreach($cantidades as $cantidad) {
            if($comuna == null){
                $data[34]['total_numerador'] += $cantidad->numerador;
            } else {
                $data[$cantidad->NombreComuna][34]['numeradores'][$cantidad->mes] = $cantidad->numerador;
                $data[$cantidad->NombreComuna][34]['ct_marzo'] += $cantidad->numerador;
            }
        }

        // $query ='SELECT
        //             IF(COD_CENTRO = 102307, "HECTOR REYNO", comuna) AS NombreComuna,
        //             COUNT(*) poblacion FROM percapita_pro p
        //         LEFT JOIN 2020establecimientos e
        //         ON p.COD_CENTRO = e.Codigo
        //         WHERE p.AUTORIZADO = "X" AND p.EDAD < 10 '. $filter_commune_reyno . ' 
        //         GROUP BY NombreComuna, comuna ORDER BY comuna';
        // $poblaciones = DB::connection('mysql_rem')->select($query);

        // foreach($poblaciones as $poblacion) {
        //     $data[$poblacion->NombreComuna][34]['poblacion'] = $poblacion->poblacion;
        // }

        $denominadores = ['IQUIQUE' => 8883, 'ALTO HOSPICIO' => 4098, 'POZO ALMONTE' => 2456, 'PICA' => 180, 
                          'HUARA' => 167, 'CAMIÑA' => 27, 'COLCHANE' => 0, 'HECTOR REYNO' => 586];

        if($comuna == null)
            foreach($denominadores as $denominador) $data[34]['total_denominador'] += $denominador;
        else
            $data[$comuna->name][34]['actividadesProgramadas'] = $denominadores[$comuna->name];

        /* 35 */
        $query ='SELECT
                    IF(Codigo = 102307, "HECTOR REYNO", comuna) AS NombreComuna, mes,
                    SUM(COALESCE(Col10,0) + COALESCE(Col11,0) + COALESCE(Col12,0) + COALESCE(Col13,0)) AS numerador FROM 2020rems r
                JOIN 2020establecimientos e ON r.IdEstablecimiento = e.Codigo
                WHERE CodigoPrestacion IN (03020604, 04050110, 04050120)
                AND r.mes IN (1,2,3,4,5,6,7,8,9,10,11)
                AND r.IdEstablecimiento NOT IN (102100,102600,102601,102602,102011) '
                . $filter_commune_reyno . ' 
                GROUP BY NombreComuna, mes ORDER BY NombreComuna, mes';
        $cantidades = DB::connection('mysql_rem')->select($query);

        foreach($cantidades as $cantidad) {
            if($comuna == null){
                $data[35]['total_numerador'] += $cantidad->numerador;
            } else {
                $data[$cantidad->NombreComuna][35]['numeradores'][$cantidad->mes] = $cantidad->numerador;
                $data[$cantidad->NombreComuna][35]['ct_marzo'] += $cantidad->numerador;
            }
        }

        // foreach($poblaciones_10a_a_19a as $poblacion) {
        //     $data[$poblacion->NombreComuna][35]['poblacion'] = $poblacion->poblacion;
        // }

        $denominadores = ['IQUIQUE' => 3705, 'ALTO HOSPICIO' => 1120, 'POZO ALMONTE' => 124, 'PICA' => 53, 
                          'HUARA' => 312, 'CAMIÑA' => 0, 'COLCHANE' => 74, 'HECTOR REYNO' => 254];

        if($comuna == null)
            foreach($denominadores as $denominador) $data[35]['total_denominador'] += $denominador;
        else
            $data[$comuna->name][35]['actividadesProgramadas'] = $denominadores[$comuna->name];

        /* 36 */
        $query ='SELECT
                    IF(Codigo = 102307, "HECTOR REYNO", comuna) AS NombreComuna, mes,
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
						  ) AS numerador FROM 2020rems r
                JOIN 2020establecimientos e ON r.IdEstablecimiento = e.Codigo
                WHERE CodigoPrestacion IN (03020604, 04050110, 04050120)
                AND r.mes IN (1,2,3,4,5,6,7,8,9,10,11)
                AND r.IdEstablecimiento NOT IN (102100,102600,102601,102602,102011) '
                . $filter_commune_reyno . ' 
                GROUP BY NombreComuna, mes ORDER BY NombreComuna, mes';
        $cantidades = DB::connection('mysql_rem')->select($query);

        foreach($cantidades as $cantidad) {
            if($comuna == null){
                $data[36]['total_numerador'] += $cantidad->numerador;
            } else {
                $data[$cantidad->NombreComuna][36]['numeradores'][$cantidad->mes] = $cantidad->numerador;
                $data[$cantidad->NombreComuna][36]['ct_marzo'] += $cantidad->numerador;
            }
        }

        // foreach($poblaciones_20a_a_64a as $poblacion) {
        //     $data[$poblacion->NombreComuna][36]['poblacion'] = $poblacion->poblacion;
        // }

        $denominadores = ['IQUIQUE' => 31294, 'ALTO HOSPICIO' => 4190, 'POZO ALMONTE' => 1664, 'PICA' => 187, 
                          'HUARA' => 131, 'CAMIÑA' => 91, 'COLCHANE' => 87, 'HECTOR REYNO' => 828];

        if($comuna == null)
            foreach($denominadores as $denominador) $data[36]['total_denominador'] += $denominador;
        else
            $data[$comuna->name][36]['actividadesProgramadas'] = $denominadores[$comuna->name];

        /* 37 */
        $query ='SELECT
                    IF(Codigo = 102307, "HECTOR REYNO", comuna) AS NombreComuna, mes,
                    SUM(
						  COALESCE(Col32,0) +
						  COALESCE(Col33,0) +
						  COALESCE(Col34,0) +
						  COALESCE(Col35,0) +
						  COALESCE(Col36,0) +
						  COALESCE(Col37,0) +
						  COALESCE(Col38,0) +
						  COALESCE(Col39,0)
						  ) AS numerador FROM 2020rems r
                JOIN 2020establecimientos e ON r.IdEstablecimiento = e.Codigo
                WHERE CodigoPrestacion IN (03020604, 04050110, 04050120)
                AND r.mes IN (1,2,3,4,5,6,7,8,9,10,11)
                AND r.IdEstablecimiento NOT IN (102100,102600,102601,102602,102011) '
                . $filter_commune_reyno . ' 
                GROUP BY NombreComuna, mes ORDER BY NombreComuna, mes';
        $cantidades = DB::connection('mysql_rem')->select($query);

        foreach($cantidades as $cantidad) {
            if($comuna == null){
                $data[37]['total_numerador'] += $cantidad->numerador;
            } else {
                $data[$cantidad->NombreComuna][37]['numeradores'][$cantidad->mes] = $cantidad->numerador;
                $data[$cantidad->NombreComuna][37]['ct_marzo'] += $cantidad->numerador;
            }
        }

        // foreach($poblaciones_mayor_64a as $poblacion) {
        //     $data[$poblacion->NombreComuna][37]['poblacion'] = $poblacion->poblacion;
        // }

        $denominadores = ['IQUIQUE' => 14859, 'ALTO HOSPICIO' => 763, 'POZO ALMONTE' => 127, 'PICA' => 347, 
                          'HUARA' => 52, 'CAMIÑA' => 39, 'COLCHANE' => 67, 'HECTOR REYNO' => 24];

        if($comuna == null)
            foreach($denominadores as $denominador) $data[37]['total_denominador'] += $denominador;
        else
        $data[$comuna->name][37]['actividadesProgramadas'] = $denominadores[$comuna->name];

        /* 38 */
        $query ='SELECT
                    IF(Codigo = 102307, "HECTOR REYNO", comuna) AS NombreComuna, mes,
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
						  COALESCE(Col35,0)) AS numerador FROM 2020rems r
                JOIN 2020establecimientos e ON r.IdEstablecimiento = e.Codigo
                WHERE CodigoPrestacion IN (23080300,23080400,23080500)
                AND r.mes IN (1,2,3,4,5,6,7,8,9,10,11)
                AND r.IdEstablecimiento NOT IN (102100,102600,102601,102602,102011) '
                . $filter_commune_reyno . ' 
                GROUP BY NombreComuna, mes ORDER BY NombreComuna, mes';
        $cantidades = DB::connection('mysql_rem')->select($query);

        foreach($cantidades as $cantidad) {
            if($comuna == null){
                $data[38]['total_numerador'] += $cantidad->numerador;
            } else {
                $data[$cantidad->NombreComuna][38]['numeradores'][$cantidad->mes] = $cantidad->numerador;
                $data[$cantidad->NombreComuna][38]['ct_marzo'] += $cantidad->numerador;
            }
        }

        // $query ='SELECT
        //             IF(COD_CENTRO = 102307, "HECTOR REYNO", comuna) AS NombreComuna,
        //             COUNT(*) poblacion FROM percapita_pro p
        //         LEFT JOIN 2020establecimientos e
        //         ON p.COD_CENTRO = e.Codigo
        //         WHERE p.AUTORIZADO = "X" AND p.EDAD > 20 '. $filter_commune_reyno . ' 
        //         GROUP BY NombreComuna, comuna ORDER BY comuna';
        // $poblaciones = DB::connection('mysql_rem')->select($query);

        // foreach($poblaciones as $poblacion) {
        //     $data[$poblacion->NombreComuna][38]['poblacion'] = $poblacion->poblacion;
        // }

        $denominadores = ['IQUIQUE' => 8672, 'ALTO HOSPICIO' => 377, 'POZO ALMONTE' => 756, 'PICA' => 418, 
                          'HUARA' => 64, 'CAMIÑA' => 32, 'COLCHANE' => 12, 'HECTOR REYNO' => 640];

        if($comuna == null)
            foreach($denominadores as $denominador) $data[38]['total_denominador'] += $denominador;
        else
            $data[$comuna->name][38]['actividadesProgramadas'] = $denominadores[$comuna->name];

        /* 39 */
        $query ='SELECT
                    IF(Codigo = 102307, "HECTOR REYNO", comuna) AS NombreComuna, mes,
                    SUM(
						  COALESCE(Col01,0)
						  ) AS numerador FROM 2020rems r
                JOIN 2020establecimientos e ON r.IdEstablecimiento = e.Codigo
                WHERE CodigoPrestacion IN (23045600)
                AND r.mes IN (1,2,3,4,5,6,7,8,9,10,11)
                AND r.IdEstablecimiento NOT IN (102100,102600,102601,102602,102011) '
                . $filter_commune_reyno . ' 
                GROUP BY NombreComuna, mes ORDER BY NombreComuna, mes';
        $cantidades = DB::connection('mysql_rem')->select($query);

        foreach($cantidades as $cantidad) {
            if($comuna == null){
                $data[39]['total_numerador'] += $cantidad->numerador;
            } else {
                $data[$cantidad->NombreComuna][39]['numeradores'][$cantidad->mes] = $cantidad->numerador;
                $data[$cantidad->NombreComuna][39]['ct_marzo'] += $cantidad->numerador;
            }
        }

        // $query ='SELECT
        //             IF(Codigo = 102307, "HECTOR REYNO", comuna) AS NombreComuna,
        //             SUM(
		// 				  COALESCE(Col01,0)
		// 				  ) AS numerador FROM 2020rems r
        //         JOIN 2020establecimientos e ON r.IdEstablecimiento = e.Codigo
        //         WHERE CodigoPrestacion IN (23080300, 23080400, 23080500)
        //         AND r.mes IN (1,2,3,4,5,6,7,8,9,10,11)
        //         AND r.IdEstablecimiento NOT IN (102100,102600,102601,102602,102011) '
        //         . $filter_commune_reyno . ' 
        //         GROUP BY NombreComuna, mes ORDER BY NombreComuna, mes';
        // $poblaciones = DB::connection('mysql_rem')->select($query);

        // foreach($poblaciones as $poblacion) {
        //     $data[$poblacion->NombreComuna][39]['poblacion'] = $poblacion->total;
        // }

        $denominadores = ['IQUIQUE' => 4966, 'ALTO HOSPICIO' => 9, 'POZO ALMONTE' => 81, 'PICA' => 51, 
                          'HUARA' => 0, 'CAMIÑA' => 64, 'COLCHANE' => 348, 'HECTOR REYNO' => 72];

        if($comuna == null)
            foreach($denominadores as $denominador) $data[39]['total_denominador'] += $denominador;
        else
            $data[$comuna->name][39]['actividadesProgramadas'] = $denominadores[$comuna->name];

        /* 40 */
        $numeradores = ['IQUIQUE' => 2475, 'ALTO HOSPICIO' => 648, 'POZO ALMONTE' => 45, 'PICA' => 41, 
                          'HUARA' => 113, 'CAMIÑA' => 24, 'COLCHANE' => 13, 'HECTOR REYNO' => 178];

        if($comuna == null){
            foreach($numeradores as $numerador) $data[40]['total_numerador'] += $numerador;
        } else {
            $data[$comuna->name][40]['ct_marzo'] = $numeradores[$comuna->name];
            // mostrar nada en los meses
            for($mes = 1; $mes <= $ultimo_rem; $mes++) $data[$comuna->name][40]['numeradores'][$mes] = null;
        }
        // $query ='SELECT
        //             IF(COD_CENTRO = 102307, "HECTOR REYNO", comuna) AS NombreComuna,
        //             COUNT(*) poblacion FROM percapita_pro p
        //         LEFT JOIN 2020establecimientos e
        //         ON p.COD_CENTRO = e.Codigo
        //         WHERE p.AUTORIZADO = "X" AND p.EDAD = 65 '. $filter_commune_reyno . ' 
        //         GROUP BY NombreComuna, comuna ORDER BY comuna';
        // $poblaciones = DB::connection('mysql_rem')->select($query);

        // foreach($poblaciones as $poblacion) {
        //     $data[$poblacion->NombreComuna][40]['poblacion'] = $poblacion->poblacion;
        // }

        $denominadores = ['IQUIQUE' => 1959, 'ALTO HOSPICIO' => 655, 'POZO ALMONTE' => 129, 'PICA' => 71, 
                          'HUARA' => 38, 'CAMIÑA' => 14, 'COLCHANE' => 21, 'HECTOR REYNO' => 155];

        if($comuna == null)
            foreach($denominadores as $denominador) $data[40]['total_denominador'] += $denominador;
        else
            $data[$comuna->name][40]['actividadesProgramadas'] = $denominadores[$comuna->name];

        /* 41 */
        $query ='SELECT
                   IF(Codigo = 102307, "HECTOR REYNO", comuna) AS NombreComuna, mes,
                   SUM(COALESCE(Col01,0)) AS numerador FROM 2020rems r
                    JOIN 2020establecimientos e ON r.IdEstablecimiento = e.Codigo
                    WHERE CodigoPrestacion IN (19120301, 19120302, 19120303, 19120304, 19120306, 19120308, 19120310, 19170200, 19120311, 19120312, 19120305)
                    AND r.mes IN (1,2,3,4,5,6,7,8,9,10,11)
                    AND r.IdEstablecimiento NOT IN (102100,102600,102601,102602,102011) '
                    . $filter_commune_reyno . ' 
                    GROUP BY NombreComuna, mes ORDER BY NombreComuna, mes';
        $cantidades = DB::connection('mysql_rem')->select($query);

        foreach($cantidades as $cantidad) {
            if($comuna == null){
                $data[41]['total_numerador'] += $cantidad->numerador;
            } else {
                $data[$cantidad->NombreComuna][41]['numeradores'][$cantidad->mes] = $cantidad->numerador;
                $data[$cantidad->NombreComuna][41]['ct_marzo'] += $cantidad->numerador;
            }
        }

        // foreach($poblaciones_total as $poblacion) {
        //     $data[$poblacion->NombreComuna][41]['poblacion'] = $poblacion->poblacion;
        // }

        $denominadores = ['IQUIQUE' => 5368, 'ALTO HOSPICIO' => 653, 'POZO ALMONTE' => 497, 'PICA' => 287, 
                          'HUARA' => 69, 'CAMIÑA' => 715, 'COLCHANE' => 74, 'HECTOR REYNO' => 807];

        if($comuna == null)
            foreach($denominadores as $denominador) $data[41]['total_denominador'] += $denominador;
        else
            $data[$comuna->name][41]['actividadesProgramadas'] = $denominadores[$comuna->name];

        /* 42 */
        $query ='SELECT
                    IF(Codigo = 102307, "HECTOR REYNO", comuna) AS NombreComuna, mes,
                    SUM(COALESCE(Col26,0) + COALESCE(Col27,0)) AS numerador FROM 2020rems r
                JOIN 2020establecimientos e ON r.IdEstablecimiento = e.Codigo
                WHERE CodigoPrestacion IN (09400082)
                AND r.mes IN (1,2,3,4,5,6,7,8,9,10,11)
                AND r.IdEstablecimiento NOT IN (102100,102600,102601,102602,102011) '
                . $filter_commune_reyno . ' 
                GROUP BY NombreComuna, mes ORDER BY NombreComuna, mes';
        $cantidades = DB::connection('mysql_rem')->select($query);

        foreach($cantidades as $cantidad) {
            if($comuna == null){
                $data[42]['total_numerador'] += $cantidad->numerador;
            } else {
                $data[$cantidad->NombreComuna][42]['numeradores'][$cantidad->mes] = $cantidad->numerador;
                $data[$cantidad->NombreComuna][42]['ct_marzo'] += $cantidad->numerador;
            }
        }

        // foreach($poblaciones_mayor_64a as $poblacion) {
        //     $data[$poblacion->NombreComuna][42]['poblacion'] = $poblacion->poblacion;
        // }

        $denominadores = ['IQUIQUE' => 0, 'ALTO HOSPICIO' => 795, 'POZO ALMONTE' => 64, 'PICA' => 150, 
                          'HUARA' => 281, 'CAMIÑA' => 6785, 'COLCHANE' => 222, 'HECTOR REYNO' => 958];

        if($comuna == null)
            foreach($denominadores as $denominador) $data[42]['total_denominador'] += $denominador;
        else
            $data[$comuna->name][42]['actividadesProgramadas'] = $denominadores[$comuna->name];

        /* 43 */
        $query ='SELECT
                    IF(Codigo = 102307, "HECTOR REYNO", comuna) AS NombreComuna, mes,
                    SUM(COALESCE(Col01,0)) AS numerador FROM 2020rems r
                JOIN 2020establecimientos e ON r.IdEstablecimiento = e.Codigo
                WHERE CodigoPrestacion IN (09201713)
                AND r.mes IN (1,2,3,4,5,6,7,8,9,10,11)
                AND r.IdEstablecimiento NOT IN (102100,102600,102601,102602,102011) '
                . $filter_commune_reyno . ' 
                GROUP BY NombreComuna, mes ORDER BY NombreComuna, mes';
        $cantidades = DB::connection('mysql_rem')->select($query);

        foreach($cantidades as $cantidad) {
            if($comuna == null){
                $data[43]['total_numerador'] += $cantidad->numerador;
            } else {
                $data[$cantidad->NombreComuna][43]['numeradores'][$cantidad->mes] = $cantidad->numerador;
                $data[$cantidad->NombreComuna][43]['ct_marzo'] += $cantidad->numerador;
            }
        }

        // foreach($poblaciones_total as $poblacion) {
        //     $data[$poblacion->NombreComuna][43]['poblacion'] = $poblacion->poblacion;
        // }

        $denominadores = ['IQUIQUE' => 0, 'ALTO HOSPICIO' => 5441, 'POZO ALMONTE' => 13, 'PICA' => 296, 
                          'HUARA' => 9, 'CAMIÑA' => 23, 'COLCHANE' => 0, 'HECTOR REYNO' => 0];

        if($comuna == null)
            foreach($denominadores as $denominador) $data[43]['total_denominador'] += $denominador;
        else
            $data[$comuna->name][43]['actividadesProgramadas'] = $denominadores[$comuna->name];

        /* 44 */
        $query ='SELECT
               IF(Codigo = 102307, "HECTOR REYNO", comuna) AS NombreComuna, mes,
               SUM(COALESCE(Col01,0)) AS numerador FROM 2020rems r
                JOIN 2020establecimientos e ON r.IdEstablecimiento = e.Codigo
                WHERE CodigoPrestacion IN (09230500)
                AND r.mes IN (1,2,3,4,5,6,7,8,9,10,11)
                AND r.IdEstablecimiento NOT IN (102100,102600,102601,102602,102011) '
                . $filter_commune_reyno . ' 
                GROUP BY NombreComuna, mes ORDER BY NombreComuna, mes';
        $cantidades = DB::connection('mysql_rem')->select($query);

        foreach($cantidades as $cantidad) {
            if($comuna == null){
                $data[44]['total_numerador'] += $cantidad->numerador;
            } else {
                $data[$cantidad->NombreComuna][44]['numeradores'][$cantidad->mes] = $cantidad->numerador;
                $data[$cantidad->NombreComuna][44]['ct_marzo'] += $cantidad->numerador;
            }
        }

        // $query ='SELECT
        //             IF(COD_CENTRO = 102307, "HECTOR REYNO", comuna) AS NombreComuna,
        //             COUNT(*) poblacion FROM percapita_pro p
        //         LEFT JOIN 2020establecimientos e
        //         ON p.COD_CENTRO = e.Codigo
        //         WHERE p.AUTORIZADO = "X" AND p.EDAD >= 12 '. $filter_commune_reyno . ' 
        //         GROUP BY NombreComuna, comuna ORDER BY comuna';
        // $poblaciones = DB::connection('mysql_rem')->select($query);

        // foreach($poblaciones as $poblacion) {
        //     $data[$poblacion->NombreComuna][44]['poblacion'] = $poblacion->poblacion;
        // }

        $denominadores = ['IQUIQUE' => 900, 'ALTO HOSPICIO' => 2158, 'POZO ALMONTE' => 0, 'PICA' => 392, 
                          'HUARA' => 69, 'CAMIÑA' => 118, 'COLCHANE' => 0, 'HECTOR REYNO' => 0];

        if($comuna == null)
            foreach($denominadores as $denominador) $data[44]['total_denominador'] += $denominador;
        else
            $data[$comuna->name][44]['actividadesProgramadas'] = $denominadores[$comuna->name];

        /* 45 */
        $query ='SELECT
               IF(Codigo = 102307, "HECTOR REYNO", comuna) AS NombreComuna, mes,
               SUM(COALESCE(Col01,0)) AS numerador FROM 2020rems r
                JOIN 2020establecimientos e ON r.IdEstablecimiento = e.Codigo
                WHERE CodigoPrestacion IN (19140700, 19140800, 19140900, 19150100, 19150200, 19150300, 19150400, 19150500, 19190100)
                AND r.mes IN (1,2,3,4,5,6,7,8,9,10,11)
                AND r.IdEstablecimiento NOT IN (102100,102600,102601,102602,102011) '
                . $filter_commune_reyno . ' 
                GROUP BY NombreComuna, mes ORDER BY NombreComuna, mes';
        $cantidades = DB::connection('mysql_rem')->select($query);

        foreach($cantidades as $cantidad) {
            if($comuna == null){
                $data[45]['total_numerador'] += $cantidad->numerador;
            } else {
                $data[$cantidad->NombreComuna][45]['numeradores'][$cantidad->mes] = $cantidad->numerador;
                $data[$cantidad->NombreComuna][45]['ct_marzo'] += $cantidad->numerador;
            }
        }

        // foreach($poblaciones_total as $poblacion) {
        //     $data[$poblacion->NombreComuna][45]['poblacion'] = $poblacion->poblacion;
        // }

        $denominadores = ['IQUIQUE' => 80, 'ALTO HOSPICIO' => 20, 'POZO ALMONTE' => 48, 'PICA' => 29, 
                          'HUARA' => 18, 'CAMIÑA' => 0, 'COLCHANE' => 55, 'HECTOR REYNO' => 0];

        if($comuna == null)
            foreach($denominadores as $denominador) $data[45]['total_denominador'] += $denominador;
        else
            $data[$comuna->name][45]['actividadesProgramadas'] = $denominadores[$comuna->name];

        /* 46 */
        //REM A26
        $query ='SELECT
                    IF(Codigo = 102307, "HECTOR REYNO", comuna) AS NombreComuna, mes,
                    SUM(
						  COALESCE(Col01,0)
						  ) AS numerador FROM 2020rems r
                JOIN 2020establecimientos e ON r.IdEstablecimiento = e.Codigo
                WHERE CodigoPrestacion IN (26261000,26260100,26273101,26274000,26291000,26291050,26291100,26273102,26274600,26262300,26273103,26273105,26280010,26291150,26262400,
					 26291200,26291250,26291300,26280020,26273107,26274601,26300110,26274200,26273106,26274400,26261400,26300100,26260600,26261800,26261900,26273109,26275400,26275500,
					 26275600,26273110,26262100)
                AND r.mes IN (1,2,3,4,5,6,7,8,9,10,11)
                AND r.IdEstablecimiento NOT IN (102100,102600,102601,102602,102011) '
                . $filter_commune_reyno . ' 
                GROUP BY NombreComuna, mes ORDER BY NombreComuna, mes';
        $cantidades = DB::connection('mysql_rem')->select($query);

        foreach($cantidades as $cantidad) {
            if($comuna == null){
                $data[46]['total_numerador'] += $cantidad->numerador;
            } else {
                $data[$cantidad->NombreComuna][46]['numeradores'][$cantidad->mes] = $cantidad->numerador;
                $data[$cantidad->NombreComuna][46]['ct_marzo'] += $cantidad->numerador;
            }
        }

        //REM A28
        $query ='SELECT
                    IF(Codigo = 102307, "HECTOR REYNO", comuna) AS NombreComuna, mes,
                    SUM(
						  COALESCE(Col01,0)
						  ) AS numerador FROM 2020rems r
                JOIN 2020establecimientos e ON r.IdEstablecimiento = e.Codigo
                WHERE CodigoPrestacion IN (26274800)
                AND r.mes IN (1,2,3,4,5,6,7,8,9,10,11)
                AND r.IdEstablecimiento NOT IN (102100,102600,102601,102602,102011) '
                . $filter_commune_reyno . ' 
                GROUP BY NombreComuna, mes ORDER BY NombreComuna, mes';
        $cantidades = DB::connection('mysql_rem')->select($query);

        foreach($cantidades as $cantidad) {
            if($comuna == null){
                $data[46]['total_numerador'] += $cantidad->numerador;
            } else {
                $data[$cantidad->NombreComuna][46]['numeradores'][$cantidad->mes] += $cantidad->numerador;
                $data[$cantidad->NombreComuna][46]['ct_marzo'] += $cantidad->numerador;
            }
        }

        // foreach($poblaciones_total as $poblacion) {
        //     $data[$poblacion->NombreComuna][46]['poblacion'] = $poblacion->poblacion;
        // }

        $denominadores = ['IQUIQUE' => 459, 'ALTO HOSPICIO' => 1915, 'POZO ALMONTE' => 7239, 'PICA' => 1050, 
                          'HUARA' => 32, 'CAMIÑA' => 0, 'COLCHANE' => 155, 'HECTOR REYNO' => 0];

        if($comuna == null)
            foreach($denominadores as $denominador) $data[46]['total_denominador'] += $denominador;
        else
            $data[$comuna->name][46]['actividadesProgramadas'] = $denominadores[$comuna->name];

        /* 47 */
        $query ='SELECT
                    IF(Codigo = 102307, "HECTOR REYNO", comuna) AS NombreComuna, mes,
                    SUM(
						  COALESCE(Col01,0)
						  ) AS numerador FROM 2020rems r
                JOIN 2020establecimientos e ON r.IdEstablecimiento = e.Codigo
                WHERE CodigoPrestacion IN ("P7200500")
                AND r.mes IN (6)
                AND r.IdEstablecimiento NOT IN (102100,102600,102601,102602,102011) '
                . $filter_commune_reyno . ' 
                GROUP BY NombreComuna, mes ORDER BY NombreComuna, mes';
        $cantidades = DB::connection('mysql_rem')->select($query);

        foreach($cantidades as $cantidad) {
            if($comuna == null){
                $data[47]['total_numerador'] += $cantidad->numerador;
            } else {
                $data[$cantidad->NombreComuna][47]['numeradores'][$cantidad->mes] = $cantidad->numerador;
                $data[$cantidad->NombreComuna][47]['ct_marzo'] += $cantidad->numerador;
            }
        }

        // foreach($poblaciones_total as $poblacion) {
        //     $data[$poblacion->NombreComuna][47]['poblacion'] = $poblacion->poblacion;
        // }

        $denominadores = ['IQUIQUE' => 69, 'ALTO HOSPICIO' => 132, 'POZO ALMONTE' => 2172, 'PICA' => 485, 
                          'HUARA' => 27, 'CAMIÑA' => 0, 'COLCHANE' => 52, 'HECTOR REYNO' => 0];

        if($comuna == null)
            foreach($denominadores as $denominador) $data[47]['total_denominador'] += $denominador;
        else
            $data[$comuna->name][47]['actividadesProgramadas'] = $denominadores[$comuna->name];

        /* 48 */
        $query ='SELECT
                    IF(Codigo = 102307, "HECTOR REYNO", comuna) AS NombreComuna, mes,
                    SUM(
						  COALESCE(Col39,0)
						  ) AS numerador FROM 2020rems r
                JOIN 2020establecimientos e ON r.IdEstablecimiento = e.Codigo
                WHERE CodigoPrestacion IN (06020206)
                AND r.mes IN (1,2,3,4,5,6,7,8,9,10,11)
                AND r.IdEstablecimiento NOT IN (102100,102600,102601,102602,102011) '
                . $filter_commune_reyno . ' 
                GROUP BY NombreComuna, mes ORDER BY NombreComuna, mes';
        $cantidades = DB::connection('mysql_rem')->select($query);

        foreach($cantidades as $cantidad) {
            if($comuna == null){
                $data[48]['total_numerador'] += $cantidad->numerador;
            } else {
                $data[$cantidad->NombreComuna][48]['numeradores'][$cantidad->mes] = $cantidad->numerador;
                $data[$cantidad->NombreComuna][48]['ct_marzo'] += $cantidad->numerador;
            }
        }

        // $query ='SELECT
        //             IF(Codigo = 102307, "HECTOR REYNO", comuna) AS NombreComuna,
        //             SUM(
		// 				  COALESCE(Col39,0)
		// 				  ) AS numerador FROM 2020rems r
        //         JOIN 2020establecimientos e ON r.IdEstablecimiento = e.Codigo
        //         WHERE CodigoPrestacion IN (06020201, 06020208, 06020202, 06020602, 06020206, 06200400, 06904900, 06200500, 06200501, 06905912)
        //         AND r.mes IN (1,2,3,4,5,6,7,8,9,10,11)
        //         AND r.IdEstablecimiento NOT IN (102100,102600,102601,102602,102011) '
        //         . $filter_commune_reyno . ' 
        //         GROUP BY NombreComuna, mes ORDER BY NombreComuna, mes';
        // $poblaciones = DB::connection('mysql_rem')->select($query);

        // foreach($poblaciones as $poblacion) {
        //     $data[$poblacion->NombreComuna][48]['poblacion'] = $poblacion->total;
        // }

        $denominadores = ['IQUIQUE' => 0, 'ALTO HOSPICIO' => 172, 'POZO ALMONTE' => 96, 'PICA' => 88, 
                          'HUARA' => 0, 'CAMIÑA' => 0, 'COLCHANE' => 5, 'HECTOR REYNO' => 296];

        if($comuna == null)
            foreach($denominadores as $denominador) $data[48]['total_denominador'] += $denominador;
        else
            $data[$comuna->name][48]['actividadesProgramadas'] = $denominadores[$comuna->name];

        /* 49 */
        $query ='SELECT
                    IF(Codigo = 102307, "HECTOR REYNO", comuna) AS NombreComuna, mes,
                    SUM(
						  COALESCE(Col36,0)
						  ) AS numerador FROM 2020rems r
                JOIN 2020establecimientos e ON r.IdEstablecimiento = e.Codigo
                WHERE CodigoPrestacion IN (02010201)
                AND r.mes IN (1,2,3,4,5,6,7,8,9,10,11)
                AND r.IdEstablecimiento NOT IN (102100,102600,102601,102602,102011) '
                . $filter_commune_reyno . ' 
                GROUP BY NombreComuna, mes ORDER BY NombreComuna, mes';
        $cantidades = DB::connection('mysql_rem')->select($query);

        foreach($cantidades as $cantidad) {
            if($comuna == null){
                $data[49]['total_numerador'] += $cantidad->numerador;
            } else {
                $data[$cantidad->NombreComuna][49]['numeradores'][$cantidad->mes] = $cantidad->numerador;
                $data[$cantidad->NombreComuna][49]['ct_marzo'] += $cantidad->numerador;
            }
        }

        // foreach($poblaciones as $poblacion) {
        //     $data[$poblacion->NombreComuna][49]['poblacion'] = $poblacion->total;
        // }

        $denominadores = ['IQUIQUE' => 0, 'ALTO HOSPICIO' => 258, 'POZO ALMONTE' => 96, 'PICA' => 26, 
                          'HUARA' => 0, 'CAMIÑA' => 0, 'COLCHANE' => 5, 'HECTOR REYNO' => 296];

        if($comuna == null)
            foreach($denominadores as $denominador) $data[49]['total_denominador'] += $denominador;
        else
            $data[$comuna->name][49]['actividadesProgramadas'] = $denominadores[$comuna->name];

        /* 50 */
        $query ='SELECT
                    IF(Codigo = 102307, "HECTOR REYNO", comuna) AS NombreComuna, mes,
                    SUM(
						  COALESCE(Col36,0)
						  ) AS numerador FROM 2020rems r
                JOIN 2020establecimientos e ON r.IdEstablecimiento = e.Codigo
                WHERE CodigoPrestacion IN (02010103)
                AND r.mes IN (1,2,3,4,5,6,7,8,9,10,11)
                AND r.IdEstablecimiento NOT IN (102100,102600,102601,102602,102011) '
                . $filter_commune_reyno . ' 
                GROUP BY NombreComuna, mes ORDER BY NombreComuna, mes';
        $cantidades = DB::connection('mysql_rem')->select($query);

        foreach($cantidades as $cantidad) {
            if($comuna == null){
                $data[50]['total_numerador'] += $cantidad->numerador;
            } else {
                $data[$cantidad->NombreComuna][50]['numeradores'][$cantidad->mes] = $cantidad->numerador;
                $data[$cantidad->NombreComuna][50]['ct_marzo'] += $cantidad->numerador;
            }
        }

        // foreach($poblaciones as $poblacion) {
        //     $data[$poblacion->NombreComuna][50]['poblacion'] = $poblacion->total;
        // }

        $denominadores = ['IQUIQUE' => 0, 'ALTO HOSPICIO' => 194, 'POZO ALMONTE' => 24, 'PICA' => 62, 
                          'HUARA' => 0, 'CAMIÑA' => 0, 'COLCHANE' => 5, 'HECTOR REYNO' => 296];

        if($comuna == null)
            foreach($denominadores as $denominador) $data[50]['total_denominador'] += $denominador;
        else
            $data[$comuna->name][50]['actividadesProgramadas'] = $denominadores[$comuna->name];

        // /* 51 */
        /* TODO: hacer las consultas para trazadora #51 */
        // mostrar nada en los meses
        if($comuna == null)
            foreach($numeradores as $numerador) $data[51]['total_numerador'] = null;
        else 
            for($mes = 1; $mes <= $ultimo_rem; $mes++) $data[$comuna->name][51]['numeradores'][$mes] = null;

        $denominadores = ['IQUIQUE' => 0, 'ALTO HOSPICIO' => 0, 'POZO ALMONTE' => 497, 'PICA' => 0, 
                          'HUARA' => 0, 'CAMIÑA' => 0, 'COLCHANE' => 62, 'HECTOR REYNO' => 0];

        if($comuna == null)
            foreach($denominadores as $denominador) $data[51]['total_denominador'] += $denominador;
        else
            $data[$comuna->name][51]['actividadesProgramadas'] = $denominadores[$comuna->name];


        /* Calculos */
        /* Sobreescribir valores de poblacion seteados manual */
        // foreach($values as $value) {
        //     if(is_numeric($value->poblacion)){
        //         $value->commune->name = mb_strtoupper($value->commune->name);
        //         $data[$value->commune->name][$value->glosa->numero]['poblacion'] = $value->poblacion;
        //     }
        // }

        // dd($data);
        if($comuna == null){
            foreach($glosas as $glosa) 
                if($data[$glosa->numero]['total_denominador'] != 0)
                    $data[$glosa->numero]['total_cobertura'] = number_format(
                        ($data[$glosa->numero]['total_numerador'] /
                        $data[$glosa->numero]['total_denominador'])*100
                    , 1, '.', '');
        } else {
            foreach($data as $nombre_comuna => $comuna) {
                foreach($comuna as $glosa => $valor){
                    /* Calculo de actividadesProgramadas = poblacion * concentracion */
                    // if($data[$nombre_comuna][$glosa]['poblacion'] AND
                    //    $data[$nombre_comuna][$glosa]['concentracion'] AND
                    //    $data[$nombre_comuna][$glosa]['cobertura']) {

                        // if(!$data[$nombre_comuna][$glosa]['actividadesProgramadas']) {
                        //     $data[$nombre_comuna][$glosa]['actividadesProgramadas'] =
                        //         $data[$nombre_comuna][$glosa]['poblacion'] *
                        //         $data[$nombre_comuna][$glosa]['concentracion'] *
                        //         $data[$nombre_comuna][$glosa]['cobertura']/100;
                        // }

                        // if($data[$nombre_comuna][$glosa]['actividadesProgramadas'] AND
                        //    $data[$nombre_comuna][$glosa]['ct_marzo'] ) {
                        if($data[$nombre_comuna][$glosa]['actividadesProgramadas'] != 0)

                            $data[$nombre_comuna][$glosa]['porc_marzo'] =
                                number_format(
                                    ($data[$nombre_comuna][$glosa]['ct_marzo'] /
                                    $data[$nombre_comuna][$glosa]['actividadesProgramadas'])*100
                                , 1, '.', '');
                        // }
                    // }
                }
            }
        }

        // echo '<pre>';
        // print_r($data);
        // die();

        return view('indicators.program_aps.2020.index', compact('id','data','glosas','communes'));
        // return redirect()->route('indicators.program_aps.2020.index', $id)->with(compact('data','glosas','communes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $glosas = ProgramApsGlosa::where('periodo', 2020)->orderBy('numero')->get();
        $establishments = Establishment::All();
        $communes = Commune::All();
        return view('indicators.program_aps.2020.create', compact('id', 'glosas','establishments', 'communes'));
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

        return redirect()->route('indicators.program_aps.2020.create');
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
        $glosas = ProgramApsGlosa::where('periodo', 2020)->orderBy('numero')->get();
        $establishments = Establishment::All();
        $communes = Commune::All();

        return view('indicators.program_aps.2020.edit',
            compact('programApsValue','glosas','establishments','communes', 'commune'));
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
        return redirect()->route('indicators.program_aps.2020.index');
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
