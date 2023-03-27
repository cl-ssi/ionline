<?php

namespace App\Http\Controllers\Indicators\_2018;

use App\Models\Indicators\ProgramApsValue;
use App\Models\Indicators\ProgramApsGlosa;
use App\Models\Commune;
use App\Models\Establishment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
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
        $glosas   = ProgramApsGlosa::where('periodo', 2018)->get();

        /* Inicializar valores */
        foreach($communes as $commune) {
            $commune->name = mb_strtoupper($commune->name);
            foreach($glosas as $glosa) {
                $data[$commune->name][$glosa->numero]['id'] = $glosa->id;
                $data[$commune->name][$glosa->numero]['poblacion'] = '';
                $data[$commune->name][$glosa->numero]['cobertura'] = '';
                $data[$commune->name][$glosa->numero]['concentracion'] = null;
                $data[$commune->name][$glosa->numero]['actividadesProgramadas'] = '';
                $data[$commune->name][$glosa->numero]['observadoAnterior'] = '';
                $data[$commune->name][$glosa->numero]['rendimientoProfesional'] = '';
                $data[$commune->name][$glosa->numero]['observaciones'] = '';
            }
        }

        $values = ProgramApsValue::with('glosa')->where(function ($query) { $query->where('periodo', 2018);})->get();

        foreach($values as $value) {
            $value->commune->name = mb_strtoupper($value->commune->name);
            $data[$value->commune->name][$value->glosa->numero]['cobertura'] = $value->cobertura;
            $data[$value->commune->name][$value->glosa->numero]['concentracion'] = $value->concentracion;
            $data[$value->commune->name][$value->glosa->numero]['actividadesProgramadas'] = $value->actividadesProgramadas;
            $data[$value->commune->name][$value->glosa->numero]['observadoAnterior'] = $value->observadoAnterior;
            $data[$value->commune->name][$value->glosa->numero]['rendimientoProfesional'] = $value->rendimientoProfesional;
            $data[$value->commune->name][$value->glosa->numero]['observaciones'] = $value->observaciones;
        }


        /* Obtener las poblaciones por cada uno de los indicadores */
        /* 1 */
        $query ='SELECT e.comuna, SUM(Col06 + Col08 + Col10) AS total FROM 2018rems r
                JOIN establecimientos e ON r.IdEstablecimiento = e.Codigo
                WHERE CodigoPrestacion IN (02010201) AND Ano = 2018
                GROUP BY e.comuna ORDER BY e.comuna';
        $poblaciones = DB::connection('mysql_rem')->select($query);

        foreach($poblaciones as $poblacion) {
            $data[$poblacion->comuna][1]['poblacion'] = $poblacion->total;
        }

        /* 2 */
        $query ='SELECT e.comuna, SUM(Col01) AS total FROM 2018rems r
                JOIN establecimientos e ON r.IdEstablecimiento = e.Codigo
                WHERE CodigoPrestacion IN (02010103) AND Ano = 2018
                GROUP BY e.comuna ORDER BY e.comuna';
        $poblaciones = DB::connection('mysql_rem')->select($query);

        foreach($poblaciones as $poblacion) {
            $data[$poblacion->comuna][2]['poblacion'] = $poblacion->total;
        }

        /* 3 */
        $query ='SELECT e.comuna, SUM(Col04 + Col05 + Col06 + Col07 + Col08 + Col09) AS total FROM 2018rems r
                JOIN establecimientos e ON r.IdEstablecimiento = e.Codigo
                WHERE CodigoPrestacion IN (04040420, 04040421, 04040428) AND Ano = 2018
                GROUP BY e.comuna ORDER BY e.comuna';
        $poblaciones = DB::connection('mysql_rem')->select($query);

        foreach($poblaciones as $poblacion) {
            $data[$poblacion->comuna][3]['poblacion'] = $poblacion->total;
        }

        /* 4 */
        $query ='SELECT e.comuna, SUM(Col06 + Col07) AS total FROM 2018rems r
                JOIN establecimientos e ON r.IdEstablecimiento = e.Codigo
                WHERE CodigoPrestacion IN (02010320, 05225303, 02010321, 02010322) AND Ano = 2018
                GROUP BY e.comuna ORDER BY e.comuna';
        $poblaciones = DB::connection('mysql_rem')->select($query);

        foreach($poblaciones as $poblacion) {
            $data[$poblacion->comuna][4]['poblacion'] = $poblacion->total;
        }

        /* 5 */
        $query ='SELECT e.comuna, SUM(Col10 + Col11) AS total FROM 2018rems r
                JOIN establecimientos e ON r.IdEstablecimiento = e.Codigo
                WHERE CodigoPrestacion IN (02010320, 05225303, 02010321, 02010322) AND Ano = 2018
                GROUP BY e.comuna ORDER BY e.comuna';
        $poblaciones = DB::connection('mysql_rem')->select($query);

        foreach($poblaciones as $poblacion) {
            $data[$poblacion->comuna][5]['poblacion'] = $poblacion->total;
        }

        /* 6 */
        $query ='SELECT e.comuna, SUM(Col12 + Col13) AS total FROM 2018rems r
                JOIN establecimientos e ON r.IdEstablecimiento = e.Codigo
                WHERE CodigoPrestacion IN (02010320, 05225303, 02010321, 02010322) AND Ano = 2018
                GROUP BY e.comuna ORDER BY e.comuna';
        $poblaciones = DB::connection('mysql_rem')->select($query);

        foreach($poblaciones as $poblacion) {
            $data[$poblacion->comuna][6]['poblacion'] = $poblacion->total;
        }

        /* 7 */
        $query ='SELECT e.comuna, SUM(Col04 + Col05 + Col06 + Col07 + Col08 + Col09) AS total FROM 2018rems r
                JOIN establecimientos e ON r.IdEstablecimiento = e.Codigo
                WHERE CodigoPrestacion IN (04040417, 04040418) AND Ano = 2018
                GROUP BY e.comuna ORDER BY e.comuna';
        $poblaciones = DB::connection('mysql_rem')->select($query);

        foreach($poblaciones as $poblacion) {
            $data[$poblacion->comuna][7]['poblacion'] = $poblacion->total;
        }

        /* 8 */
        $query ='SELECT e.comuna, SUM(Col04 + Col05 + Col06 + Col07 + Col08 + Col09) AS total FROM 2018rems r
                JOIN establecimientos e ON r.IdEstablecimiento = e.Codigo
                WHERE CodigoPrestacion IN (03020101, 03020201, 03020301, 03020402, 03020403, 03020401, 03040210, 03040220, 04040100, 04025010, 04025020, 04025025, 04040427, 03020501) AND Ano = 2018
                GROUP BY e.comuna ORDER BY e.comuna';
        $poblaciones = DB::connection('mysql_rem')->select($query);

        foreach($poblaciones as $poblacion) {
            $data[$poblacion->comuna][8]['poblacion'] = $poblacion->total;
        }

        /* 9 */
        $query ='SELECT e.comuna, SUM(Col04 + Col05 + Col06 + Col07 + Col08 + Col09 + Col10 + Col11 + Col12 + Col13) AS total FROM 2018rems r
                JOIN establecimientos e ON r.IdEstablecimiento = e.Codigo
                WHERE CodigoPrestacion IN (23080300, 23080400, 23080500) AND Ano = 2018
                GROUP BY e.comuna ORDER BY e.comuna';
        $poblaciones = DB::connection('mysql_rem')->select($query);

        foreach($poblaciones as $poblacion) {
            $data[$poblacion->comuna][9]['poblacion'] = $poblacion->total;
        }

        /* 10 */
        $query ='SELECT e.comuna, SUM(Col04 + Col05 + Col06 + Col07 + Col08 + Col09 + Col10 + Col11) AS total FROM 2018rems r
                JOIN establecimientos e ON r.IdEstablecimiento = e.Codigo
                WHERE CodigoPrestacion IN (05225304, 02010420, 05225305, 03500366, 05225306, 02010421, 02010422) AND Ano = 2018
                GROUP BY e.comuna ORDER BY e.comuna';
        $poblaciones = DB::connection('mysql_rem')->select($query);

        foreach($poblaciones as $poblacion) {
            $data[$poblacion->comuna][10]['poblacion'] = $poblacion->total;
        }

        /* 11 */
        $query ='SELECT e.comuna, SUM(Col12 + Col13) AS total FROM 2018rems r
                JOIN establecimientos e ON r.IdEstablecimiento = e.Codigo
                WHERE CodigoPrestacion IN (05225304, 02010420, 05225305, 03500366, 05225306, 02010421, 02010422) AND Ano = 2018
                GROUP BY e.comuna ORDER BY e.comuna';
        $poblaciones = DB::connection('mysql_rem')->select($query);

        foreach($poblaciones as $poblacion) {
            $data[$poblacion->comuna][11]['poblacion'] = $poblacion->total;
        }

        /* 12 */
        $query ='SELECT e.comuna, SUM(Col01) AS total FROM 2018rems r
                JOIN establecimientos e ON r.IdEstablecimiento = e.Codigo
                WHERE CodigoPrestacion IN (06902700) AND Ano = 2018
                GROUP BY e.comuna ORDER BY e.comuna';
        $poblaciones = DB::connection('mysql_rem')->select($query);

        foreach($poblaciones as $poblacion) {
            $data[$poblacion->comuna][12]['poblacion'] = $poblacion->total;
        }

        /* 13 */
        $query ='SELECT e.comuna, SUM(Col01 + Col02 + Col03 + Col04) AS total FROM 2018rems r
                JOIN establecimientos e ON r.IdEstablecimiento = e.Codigo
                WHERE CodigoPrestacion IN (01030500, 01030600, 01030700, 01030800) AND Ano = 2018
                GROUP BY e.comuna ORDER BY e.comuna';
        $poblaciones = DB::connection('mysql_rem')->select($query);

        foreach($poblaciones as $poblacion) {
            $data[$poblacion->comuna][13]['poblacion'] = $poblacion->total;
        }

        /* 14 */
        $query ='SELECT e.comuna, SUM(Col01 + Col02 + Col03 + Col04) AS total FROM 2018rems r
                JOIN establecimientos e ON r.IdEstablecimiento = e.Codigo
                WHERE CodigoPrestacion IN (01030500, 01030600, 01030700, 01030800) AND Ano = 2018
                GROUP BY e.comuna ORDER BY e.comuna';
        $poblaciones = DB::connection('mysql_rem')->select($query);

        foreach($poblaciones as $poblacion) {
            $data[$poblacion->comuna][14]['poblacion'] = $poblacion->total;
        }

        /* 15 */
        $query ='SELECT e.comuna, SUM(Col10 + Col11 + Col12 + Col13) AS total FROM 2018rems r
                JOIN establecimientos e ON r.IdEstablecimiento = e.Codigo
                WHERE CodigoPrestacion IN (03020101, 03020201, 03020301, 03020402, 03020403, 03020401, 03040210, 03040220, 04040100, 04025010, 04025020, 04025025, 04040427, 03020501) AND Ano = 2018
                GROUP BY e.comuna ORDER BY e.comuna';
        $poblaciones = DB::connection('mysql_rem')->select($query);

        foreach($poblaciones as $poblacion) {
            $data[$poblacion->comuna][15]['poblacion'] = $poblacion->total;
        }

        /* 16 */
        $query ='SELECT e.comuna, SUM(Col02 + Col03) AS total FROM 2018rems r
                JOIN establecimientos e ON r.IdEstablecimiento = e.Codigo
                WHERE CodigoPrestacion IN (01080008) AND Ano = 2018
                GROUP BY e.comuna ORDER BY e.comuna';
        $poblaciones = DB::connection('mysql_rem')->select($query);

        foreach($poblaciones as $poblacion) {
            $data[$poblacion->comuna][16]['poblacion'] = $poblacion->total;
        }

        /* 17 */
        $query ='SELECT e.comuna, SUM(Col03 + Col04) AS total FROM 2018rems r
                JOIN establecimientos e ON r.IdEstablecimiento = e.Codigo
                WHERE CodigoPrestacion IN (01010401, 01010403) AND Ano = 2018
                GROUP BY e.comuna ORDER BY e.comuna';
        $poblaciones = DB::connection('mysql_rem')->select($query);

        foreach($poblaciones as $poblacion) {
            $data[$poblacion->comuna][17]['poblacion'] = $poblacion->total;
        }

        /* 18 */
        $query ='SELECT e.comuna, SUM(Col08 + Col09 + Col10 + Col11) AS total FROM 2018rems r
                JOIN establecimientos e ON r.IdEstablecimiento = e.Codigo
                WHERE CodigoPrestacion IN (19120601, 19120602,  19120603, 19120606, 19120608, 19120609, 19120611) AND Ano = 2018
                GROUP BY e.comuna ORDER BY e.comuna';
        $poblaciones = DB::connection('mysql_rem')->select($query);

        foreach($poblaciones as $poblacion) {
            $data[$poblacion->comuna][18]['poblacion'] = $poblacion->total;
        }

        /* 19 */
        $query ='SELECT e.comuna, SUM(Col08 + Col09 + Col10 + Col11) AS total FROM 2018rems r
                JOIN establecimientos e ON r.IdEstablecimiento = e.Codigo
                WHERE CodigoPrestacion IN (06020201, 06020208, 06020202, 06020602, 06020206, 06200400, 06904900, 06200500, 06200501, 06905912) AND Ano = 2018
                GROUP BY e.comuna ORDER BY e.comuna';
        $poblaciones = DB::connection('mysql_rem')->select($query);

        foreach($poblaciones as $poblacion) {
            $data[$poblacion->comuna][19]['poblacion'] = $poblacion->total;
        }

        /* 20 */
        $query ='SELECT e.comuna, SUM(Col08 + Col09 + Col10 + Col11) AS total FROM 2018rems r
                JOIN establecimientos e ON r.IdEstablecimiento = e.Codigo
                WHERE CodigoPrestacion IN (06020201, 06020208, 06020202, 06020602, 06020206, 06200400, 06904900, 06200500, 06200501, 06905912) AND Ano = 2018
                GROUP BY e.comuna ORDER BY e.comuna';
        $poblaciones = DB::connection('mysql_rem')->select($query);

        foreach($poblaciones as $poblacion) {
            $data[$poblacion->comuna][20]['poblacion'] = $poblacion->total;
        }

        /* 21 */
        $query ='SELECT e.comuna, SUM(Col10 + Col11 + Col12 + Col13) AS total FROM 2018rems r
                JOIN establecimientos e ON r.IdEstablecimiento = e.Codigo
                WHERE CodigoPrestacion IN (03020604) AND Ano = 2018
                GROUP BY e.comuna ORDER BY e.comuna';
        $poblaciones = DB::connection('mysql_rem')->select($query);

        foreach($poblaciones as $poblacion) {
            $data[$poblacion->comuna][21]['poblacion'] = $poblacion->total;
        }

        /* 22 */
        $query ='SELECT e.comuna, SUM(Col07 + Col08) AS total FROM 2018rems r
                JOIN establecimientos e ON r.IdEstablecimiento = e.Codigo
                WHERE CodigoPrestacion IN (27300919, 27300920) AND Ano = 2018
                GROUP BY e.comuna ORDER BY e.comuna';
        $poblaciones = DB::connection('mysql_rem')->select($query);

        foreach($poblaciones as $poblacion) {
            $data[$poblacion->comuna][22]['poblacion'] = $poblacion->total;
        }

        /* 23 */
        $query ='SELECT e.comuna, SUM(Col14 + Col15 + Col16 + Col17 + Col18 + Col19 + Col20 + Col21 + Col22 + Col23 + Col24 + Col25 + Col26 + Col27 + Col28 + Col29 + Col30 + Col31) AS total FROM 2018rems r
                JOIN establecimientos e ON r.IdEstablecimiento = e.Codigo
                WHERE CodigoPrestacion IN (03020101, 03020201, 03020301, 03020402, 03020403, 03020401, 03040210, 03040220, 04040100, 04025010, 04025020, 04025025, 04040427, 03020501) AND Ano = 2018
                GROUP BY e.comuna ORDER BY e.comuna';
        $poblaciones = DB::connection('mysql_rem')->select($query);

        foreach($poblaciones as $poblacion) {
            $data[$poblacion->comuna][23]['poblacion'] = $poblacion->total;
        }

        /* 24 */
        $query ='SELECT e.comuna, SUM(Col14 + Col15 + Col16 + Col17 + Col18 + Col19 + Col20 + Col21 + Col22 + Col23 + Col24 + Col25 + Col26 + Col27 + Col28 + Col29 + Col30 + Col31 + Col32 + Col33 + Col34 + Col35) AS total FROM 2018rems r
                JOIN establecimientos e ON r.IdEstablecimiento = e.Codigo
                WHERE CodigoPrestacion IN (23080300, 23080400, 23080500) AND Ano = 2018
                GROUP BY e.comuna ORDER BY e.comuna';
        $poblaciones = DB::connection('mysql_rem')->select($query);

        foreach($poblaciones as $poblacion) {
            $data[$poblacion->comuna][24]['poblacion'] = $poblacion->total;
        }

        /* 25 */
        $query ='SELECT e.comuna, SUM(Col01) AS total FROM 2018rems r
                JOIN establecimientos e ON r.IdEstablecimiento = e.Codigo
                WHERE CodigoPrestacion IN (27290100, 27290200) AND Ano = 2018
                GROUP BY e.comuna ORDER BY e.comuna';
        $poblaciones = DB::connection('mysql_rem')->select($query);

        foreach($poblaciones as $poblacion) {
            $data[$poblacion->comuna][25]['poblacion'] = $poblacion->total;
        }

        /* 26 */
        $query ='SELECT e.comuna, SUM(Col07 + Col09 + Col11 + Col13 + Col15) AS total FROM 2018rems r
                JOIN establecimientos e ON r.IdEstablecimiento = e.Codigo
                WHERE CodigoPrestacion IN (03030330, 03030340, 03030120, 03030130) AND Ano = 2018
                GROUP BY e.comuna ORDER BY e.comuna';
        $poblaciones = DB::connection('mysql_rem')->select($query);

        foreach($poblaciones as $poblacion) {
            $data[$poblacion->comuna][26]['poblacion'] = $poblacion->total;
        }

        /* 27 */
        $query ='SELECT e.comuna, SUM(Col14 + Col15 + Col16 + Col17 + Col18 + Col19 + Col20 + Col21 + Col22 + Col23 + Col24 + Col25 + Col26 + Col27 + Col28 + Col29 + Col30 + Col31) AS total FROM 2018rems r
                JOIN establecimientos e ON r.IdEstablecimiento = e.Codigo
                WHERE CodigoPrestacion IN (03020604) AND Ano = 2018
                GROUP BY e.comuna ORDER BY e.comuna';
        $poblaciones = DB::connection('mysql_rem')->select($query);

        foreach($poblaciones as $poblacion) {
            $data[$poblacion->comuna][27]['poblacion'] = $poblacion->total;
        }

        /* 28 */
        $query ='SELECT e.comuna, SUM(Col08) AS total FROM 2018rems r
                JOIN establecimientos e ON r.IdEstablecimiento = e.Codigo
                WHERE CodigoPrestacion IN (19140401, 19140403) AND Ano = 2018
                GROUP BY e.comuna ORDER BY e.comuna';
        $poblaciones = DB::connection('mysql_rem')->select($query);

        foreach($poblaciones as $poblacion) {
            $data[$poblacion->comuna][28]['poblacion'] = $poblacion->total;
        }

        /* 29 */
        $query ='SELECT e.comuna, SUM(Col32 + Col33 + Col34 + Col35 + Col36 + Col37 + Col38 + Col39) AS total FROM 2018rems r
                JOIN establecimientos e ON r.IdEstablecimiento = e.Codigo
                WHERE CodigoPrestacion IN (03020101, 03020201, 03020301, 03020402, 03020403, 03020401, 03040210, 03040220, 04040100, 04025010, 04025020, 04025025, 04040427, 03020501) AND Ano = 2018
                GROUP BY e.comuna ORDER BY e.comuna';
        $poblaciones = DB::connection('mysql_rem')->select($query);

        foreach($poblaciones as $poblacion) {
            $data[$poblacion->comuna][29]['poblacion'] = $poblacion->total;
        }

        /* 30 */
        $query ='SELECT e.comuna, SUM(Col32 + Col33 + Col34 + Col35 + Col36 + Col37 + Col38 + Col39) AS total FROM 2018rems r
                JOIN establecimientos e ON r.IdEstablecimiento = e.Codigo
                WHERE CodigoPrestacion IN (03020604) AND Ano = 2018
                GROUP BY e.comuna ORDER BY e.comuna';
        $poblaciones = DB::connection('mysql_rem')->select($query);

        foreach($poblaciones as $poblacion) {
            $data[$poblacion->comuna][30]['poblacion'] = $poblacion->total;
        }

        /* 31 */
        $query ='SELECT e.comuna, SUM(Col30 + Col31 + Col32 + Col33 + Col34 + Col35 + Col36 + Col37) AS total FROM 2018rems r
                JOIN establecimientos e ON r.IdEstablecimiento = e.Codigo
                WHERE CodigoPrestacion IN ("01030100A", "01030200B") AND Ano = 2018
                GROUP BY e.comuna ORDER BY e.comuna';
        $poblaciones = DB::connection('mysql_rem')->select($query);

        foreach($poblaciones as $poblacion) {
            $data[$poblacion->comuna][31]['poblacion'] = $poblacion->total;
        }

        /* 32 */
        $query ='SELECT e.comuna, SUM(Col26 + Col27) AS total FROM 2018rems r
                JOIN establecimientos e ON r.IdEstablecimiento = e.Codigo
                WHERE CodigoPrestacion IN (09400082) AND Ano = 2018
                GROUP BY e.comuna ORDER BY e.comuna';
        $poblaciones = DB::connection('mysql_rem')->select($query);

        foreach($poblaciones as $poblacion) {
            $data[$poblacion->comuna][32]['poblacion'] = $poblacion->total;
        }

        /* 33 */
        $query ='SELECT e.comuna, SUM(Col01) AS total FROM 2018rems r
                JOIN establecimientos e ON r.IdEstablecimiento = e.Codigo
                WHERE CodigoPrestacion IN (09201713) AND Ano = 2018
                GROUP BY e.comuna ORDER BY e.comuna';
        $poblaciones = DB::connection('mysql_rem')->select($query);

        foreach($poblaciones as $poblacion) {
            $data[$poblacion->comuna][33]['poblacion'] = $poblacion->total;
        }

        /* 34 */
        $query ='SELECT e.comuna, SUM(Col04 + Col05 + Col06 + Col07 + Col08 + Col09) AS total FROM 2018rems r
                JOIN establecimientos e ON r.IdEstablecimiento = e.Codigo
                WHERE CodigoPrestacion IN (01080008) AND Ano = 2018
                GROUP BY e.comuna ORDER BY e.comuna';
        $poblaciones = DB::connection('mysql_rem')->select($query);

        foreach($poblaciones as $poblacion) {
            $data[$poblacion->comuna][34]['poblacion'] = $poblacion->total;
        }

        /* 35 */
        $query ='SELECT e.comuna, SUM(Col04 + Col05 + Col06 + Col07 + Col08 + Col09 + Col10 + Col11) AS total FROM 2018rems r
                JOIN establecimientos e ON r.IdEstablecimiento = e.Codigo
                WHERE CodigoPrestacion IN (01080011, 05810443, 01080021, 01080022, 01080023, 01090060, 01080024, 01080013, 01080014) AND Ano = 2018
                GROUP BY e.comuna ORDER BY e.comuna';
        $poblaciones = DB::connection('mysql_rem')->select($query);

        foreach($poblaciones as $poblacion) {
            $data[$poblacion->comuna][35]['poblacion'] = $poblacion->total;
        }

        /* 36 */
        $query ='SELECT e.comuna, SUM(Col13 + Col15 + Col17 + Col19 + Col21 + Col23) AS total FROM 2018rems r
                JOIN establecimientos e ON r.IdEstablecimiento = e.Codigo
                WHERE CodigoPrestacion IN (19120601, 19120602, 19120603, 19120606, 19120608, 19120609, 19120611) AND Ano = 2018
                GROUP BY e.comuna ORDER BY e.comuna';
        $poblaciones = DB::connection('mysql_rem')->select($query);

        foreach($poblaciones as $poblacion) {
            $data[$poblacion->comuna][36]['poblacion'] = $poblacion->total;
        }

        /* 37 */
        $query ='SELECT e.comuna, SUM(Col05 + Col06 + Col07 + Col08 + Col09 + Col10 + Col11 + Col12 + Col13) AS total FROM 2018rems r
                JOIN establecimientos e ON r.IdEstablecimiento = e.Codigo
                WHERE CodigoPrestacion IN (01010601, 01010603) AND Ano = 2018
                GROUP BY e.comuna ORDER BY e.comuna';
        $poblaciones = DB::connection('mysql_rem')->select($query);

        foreach($poblaciones as $poblacion) {
            $data[$poblacion->comuna][37]['poblacion'] = $poblacion->total;
        }

        /* 38 */
        $query ='SELECT e.comuna, SUM(Col09 + Col10 + Col11 + Col12 + Col13) AS total FROM 2018rems r
                JOIN establecimientos e ON r.IdEstablecimiento = e.Codigo
                WHERE CodigoPrestacion IN (01010901, 01010903) AND Ano = 2018
                GROUP BY e.comuna ORDER BY e.comuna';
        $poblaciones = DB::connection('mysql_rem')->select($query);

        foreach($poblaciones as $poblacion) {
            $data[$poblacion->comuna][38]['poblacion'] = $poblacion->total;
        }

        /* 39 */
        $query ='SELECT e.comuna, SUM(Col01) AS total FROM 2018rems r
                JOIN establecimientos e ON r.IdEstablecimiento = e.Codigo
                WHERE CodigoPrestacion IN (19140700, 19140800, 19140900, 19150100, 19150200, 19150300, 19150400, 19150500) AND Ano = 2018
                GROUP BY e.comuna ORDER BY e.comuna';
        $poblaciones = DB::connection('mysql_rem')->select($query);

        foreach($poblaciones as $poblacion) {
            $data[$poblacion->comuna][39]['poblacion'] = $poblacion->total;
        }

        /* 40 */
        $query ='SELECT e.comuna, SUM(Col01) AS total FROM 2018rems r
                JOIN establecimientos e ON r.IdEstablecimiento = e.Codigo
                WHERE CodigoPrestacion IN (26261000, 26260100, 26273101, 26274000, 26291000, 26291050, 26291100, 26273102, 26274600, 26262300, 26273103, 26273105, 26274200, 26280010, 26262400, 26291150, 26291200, 26291250, 26291300, 26280020, 26273106, 26274400, 26261400, 26273107, 26274601, 26260600, 26261800, 26261900, 26273109, 26275400, 26275500, 26275600, 26273110, 26262100) AND Ano = 2018
                GROUP BY e.comuna ORDER BY e.comuna';
        $poblaciones = DB::connection('mysql_rem')->select($query);

        foreach($poblaciones as $poblacion) {
            $data[$poblacion->comuna][40]['poblacion'] = $poblacion->total;
        }

        /* 41 */
        $query ='SELECT e.comuna, SUM(Col03) AS total FROM 2018rems r
                JOIN establecimientos e ON r.IdEstablecimiento = e.Codigo
                WHERE CodigoPrestacion IN (23046200) AND Ano = 2018
                GROUP BY e.comuna ORDER BY e.comuna';
        $poblaciones = DB::connection('mysql_rem')->select($query);

        foreach($poblaciones as $poblacion) {
            $data[$poblacion->comuna][41]['poblacion'] = $poblacion->total;
        }

        /* 42 */
        $query ='SELECT e.comuna, SUM(Col01) AS total FROM 2018rems r
                JOIN establecimientos e ON r.IdEstablecimiento = e.Codigo
                WHERE CodigoPrestacion IN (09230500) AND Ano = 2018
                GROUP BY e.comuna ORDER BY e.comuna';
        $poblaciones = DB::connection('mysql_rem')->select($query);

        foreach($poblaciones as $poblacion) {
            $data[$poblacion->comuna][42]['poblacion'] = $poblacion->total;
        }

        /* 43 */
        $query ='SELECT e.comuna, SUM(Col01) AS total FROM 2018rems r
                JOIN establecimientos e ON r.IdEstablecimiento = e.Codigo
                WHERE CodigoPrestacion IN (19120701, 19120702, 19120703, 19120706, 19120708, 19120709,  19120711) AND Ano = 2018
                GROUP BY e.comuna ORDER BY e.comuna';
        $poblaciones = DB::connection('mysql_rem')->select($query);

        foreach($poblaciones as $poblacion) {
            $data[$poblacion->comuna][43]['poblacion'] = $poblacion->total;
        }

        /* 44 */
        $query ='SELECT e.comuna, SUM(Col01) AS total FROM 2018rems r
                JOIN establecimientos e ON r.IdEstablecimiento = e.Codigo
                WHERE CodigoPrestacion IN ("P7200500") AND Ano = 2018
                GROUP BY e.comuna ORDER BY e.comuna';
        $poblaciones = DB::connection('mysql_rem')->select($query);

        foreach($poblaciones as $poblacion) {
            $data[$poblacion->comuna][44]['poblacion'] = $poblacion->total;
        }

        /* 45 */
        $query ='SELECT e.comuna, SUM(Col01) AS total FROM 2018rems r
                JOIN establecimientos e ON r.IdEstablecimiento = e.Codigo
                WHERE CodigoPrestacion IN (16100300, 16200220, 16100600, 16100700, 16100100) AND Ano = 2018
                GROUP BY e.comuna ORDER BY e.comuna';
        $poblaciones = DB::connection('mysql_rem')->select($query);

        foreach($poblaciones as $poblacion) {
            $data[$poblacion->comuna][45]['poblacion'] = $poblacion->total;
        }

        /* 46 */
        $query ='SELECT e.comuna, SUM(Col01) AS total FROM 2018rems r
                JOIN establecimientos e ON r.IdEstablecimiento = e.Codigo
                WHERE CodigoPrestacion IN (03500361) AND Ano = 2018
                GROUP BY e.comuna ORDER BY e.comuna';
        $poblaciones = DB::connection('mysql_rem')->select($query);

        foreach($poblaciones as $poblacion) {
            $data[$poblacion->comuna][46]['poblacion'] = $poblacion->total;
        }

        /* 47 */
        $query ='SELECT e.comuna, SUM(Col01) AS total FROM 2018rems r
                JOIN establecimientos e ON r.IdEstablecimiento = e.Codigo
                WHERE CodigoPrestacion IN (23090590) AND Ano = 2018
                GROUP BY e.comuna ORDER BY e.comuna';
        $poblaciones = DB::connection('mysql_rem')->select($query);

        foreach($poblaciones as $poblacion) {
            $data[$poblacion->comuna][47]['poblacion'] = $poblacion->total;
        }

        /* 48 */
        $query ='SELECT e.comuna, SUM(Col01) AS total FROM 2018rems r
                JOIN establecimientos e ON r.IdEstablecimiento = e.Codigo
                WHERE CodigoPrestacion IN (19120301, 19120302, 19120303, 19120304, 19120306, 19120308, 19120310, 19170200, 19120311, 19120312, 19120305) AND Ano = 2018
                GROUP BY e.comuna ORDER BY e.comuna';
        $poblaciones = DB::connection('mysql_rem')->select($query);

        foreach($poblaciones as $poblacion) {
            $data[$poblacion->comuna][48]['poblacion'] = $poblacion->total;
        }

        /* 49 */
        $query ='SELECT e.comuna, SUM(Col01) AS total FROM 2018rems r
                JOIN establecimientos e ON r.IdEstablecimiento = e.Codigo
                WHERE CodigoPrestacion IN (06020201) AND Ano = 2018
                GROUP BY e.comuna ORDER BY e.comuna';
        $poblaciones = DB::connection('mysql_rem')->select($query);

        foreach($poblaciones as $poblacion) {
            $data[$poblacion->comuna][49]['poblacion'] = $poblacion->total;
        }

        /* 50 */
        $query ='SELECT e.comuna, SUM(Col01) AS total FROM 2018rems r
                JOIN establecimientos e ON r.IdEstablecimiento = e.Codigo
                WHERE CodigoPrestacion IN (06020208) AND Ano = 2018
                GROUP BY e.comuna ORDER BY e.comuna';
        $poblaciones = DB::connection('mysql_rem')->select($query);

        foreach($poblaciones as $poblacion) {
            $data[$poblacion->comuna][50]['poblacion'] = $poblacion->total;
        }

        /* 51 */
        $query ='SELECT e.comuna, SUM(Col39) AS total FROM 2018rems r
                JOIN establecimientos e ON r.IdEstablecimiento = e.Codigo
                WHERE CodigoPrestacion IN (06020206) AND Ano = 2018
                GROUP BY e.comuna ORDER BY e.comuna';
        $poblaciones = DB::connection('mysql_rem')->select($query);

        foreach($poblaciones as $poblacion) {
            $data[$poblacion->comuna][51]['poblacion'] = $poblacion->total;
        }

        /* 52 */
        $query ='SELECT e.comuna, SUM(Col33) AS total FROM 2018rems r
                JOIN establecimientos e ON r.IdEstablecimiento = e.Codigo
                WHERE CodigoPrestacion IN (02010201) AND Ano = 2018
                GROUP BY e.comuna ORDER BY e.comuna';
        $poblaciones = DB::connection('mysql_rem')->select($query);

        foreach($poblaciones as $poblacion) {
            $data[$poblacion->comuna][52]['poblacion'] = $poblacion->total;
        }

        /* 53 */
        $query ='SELECT e.comuna, SUM(Col33) AS total FROM 2018rems r
                JOIN establecimientos e ON r.IdEstablecimiento = e.Codigo
                WHERE CodigoPrestacion IN (02010103) AND Ano = 2018
                GROUP BY e.comuna ORDER BY e.comuna';
        $poblaciones = DB::connection('mysql_rem')->select($query);

        foreach($poblaciones as $poblacion) {
            $data[$poblacion->comuna][53]['poblacion'] = $poblacion->total;
        }

        /* 54 */
        $query ='SELECT e.comuna, SUM(Col01 + Col02 + Col03 + Col04 + Col05) AS total FROM 2018rems r
                JOIN establecimientos e ON r.IdEstablecimiento = e.Codigo
                WHERE CodigoPrestacion IN ("P4190805", "P4190806", "P4190950", "P4200300", "P4180800", "P4190960", "P4190807", "P4190808", "P4190809", "P4170300", "P4190500", "P4190600", "P4190970", "P4170500", "P4190812", "P4200400", "P4200500") AND Ano = 2018
                GROUP BY e.comuna ORDER BY e.comuna';
        $poblaciones = DB::connection('mysql_rem')->select($query);

        foreach($poblaciones as $poblacion) {
            $data[$poblacion->comuna][54]['poblacion'] = $poblacion->total;
        }

        /* 55 */
        $query ='SELECT e.comuna, SUM(Col01 + Col02 + Col03 + Col04 + Col05 + Col06) AS total FROM 2018rems r
                JOIN establecimientos e ON r.IdEstablecimiento = e.Codigo
                WHERE CodigoPrestacion IN ("P7010100", "P7010200", "P7010300", "P7200100", "P7200200", "P7010400", "P7010500", "P7010600", "P7200300", "P7200400") AND Ano = 2018
                GROUP BY e.comuna ORDER BY e.comuna';
        $poblaciones = DB::connection('mysql_rem')->select($query);

        foreach($poblaciones as $poblacion) {
            $data[$poblacion->comuna][55]['poblacion'] = $poblacion->total;
        }

        /* 56 */
        $query ='SELECT e.comuna, SUM(Col02) AS total FROM 2018rems r
                JOIN establecimientos e ON r.IdEstablecimiento = e.Codigo
                WHERE CodigoPrestacion IN (80404002) AND Ano = 2018
                GROUP BY e.comuna ORDER BY e.comuna';
        $poblaciones = DB::connection('mysql_rem')->select($query);

        foreach($poblaciones as $poblacion) {
            $data[$poblacion->comuna][56]['poblacion'] = $poblacion->total;
        }

        /* 57 */
        $query ='SELECT e.comuna, SUM(Col01 + Col02) AS total FROM 2018rems r
                JOIN establecimientos e ON r.IdEstablecimiento = e.Codigo
                WHERE CodigoPrestacion IN (27282400) AND Ano = 2018
                GROUP BY e.comuna ORDER BY e.comuna';
        $poblaciones = DB::connection('mysql_rem')->select($query);

        foreach($poblaciones as $poblacion) {
            $data[$poblacion->comuna][57]['poblacion'] = $poblacion->total;
        }

        /* 58 */
        $query ='SELECT e.comuna, SUM(Col01) AS total FROM 2018rems r
                JOIN establecimientos e ON r.IdEstablecimiento = e.Codigo
                WHERE CodigoPrestacion IN (26275400, 26275500, 26275600, 26273110) AND Ano = 2018
                GROUP BY e.comuna ORDER BY e.comuna';
        $poblaciones = DB::connection('mysql_rem')->select($query);

        foreach($poblaciones as $poblacion) {
            $data[$poblacion->comuna][58]['poblacion'] = $poblacion->total;
        }

        /* 59 */
        $query ='SELECT e.comuna, SUM(Col04 + Col05 + Col06 + Col07 + Col09) AS total FROM 2018rems r
                JOIN establecimientos e ON r.IdEstablecimiento = e.Codigo
                WHERE CodigoPrestacion IN (223080500) AND Ano = 2018
                GROUP BY e.comuna ORDER BY e.comuna';
        $poblaciones = DB::connection('mysql_rem')->select($query);

        foreach($poblaciones as $poblacion) {
            $data[$poblacion->comuna][59]['poblacion'] = $poblacion->total;
        }

        /* 60 */
        $query ='SELECT e.comuna, SUM(Col01) AS total FROM 2018rems r
                JOIN establecimientos e ON r.IdEstablecimiento = e.Codigo
                WHERE CodigoPrestacion IN (28021320) AND Ano = 2018
                GROUP BY e.comuna ORDER BY e.comuna';
        $poblaciones = DB::connection('mysql_rem')->select($query);

        foreach($poblaciones as $poblacion) {
            $data[$poblacion->comuna][60]['poblacion'] = $poblacion->total;
        }

        /* 61 */
        $query ='SELECT e.comuna, SUM(Col10 + Col11 + Col12 + Col13) AS total FROM 2018rems r
                JOIN establecimientos e ON r.IdEstablecimiento = e.Codigo
                WHERE CodigoPrestacion IN (23080500) AND Ano = 2018
                GROUP BY e.comuna ORDER BY e.comuna';
        $poblaciones = DB::connection('mysql_rem')->select($query);

        foreach($poblaciones as $poblacion) {
            $data[$poblacion->comuna][61]['poblacion'] = $poblacion->total;
        }

        /* 62 */
        $query ='SELECT e.comuna, SUM(Col14 + Col15 + Col17 + Col18 + Col19 + Col20 + Col21 +Col22 + Col23 + Col24 + Col25 + Col26 + Col27) AS total FROM 2018rems r
                JOIN establecimientos e ON r.IdEstablecimiento = e.Codigo
                WHERE CodigoPrestacion IN (23080500) AND Ano = 2018
                GROUP BY e.comuna ORDER BY e.comuna';
        $poblaciones = DB::connection('mysql_rem')->select($query);

        foreach($poblaciones as $poblacion) {
            $data[$poblacion->comuna][62]['poblacion'] = $poblacion->total;
        }

        /* 63 */
        $query ='SELECT e.comuna, SUM(Col28 + Col29 + Col30 + Col31 + Col32 + Col33 + Col34 +Col35) AS total FROM 2018rems r
                JOIN establecimientos e ON r.IdEstablecimiento = e.Codigo
                WHERE CodigoPrestacion IN (23080500) AND Ano = 2018
                GROUP BY e.comuna ORDER BY e.comuna';
        $poblaciones = DB::connection('mysql_rem')->select($query);

        foreach($poblaciones as $poblacion) {
            $data[$poblacion->comuna][63]['poblacion'] = $poblacion->total;
        }

        /* 64 */
        $query ='SELECT e.comuna, SUM(Col01) AS total FROM 2018rems r
                JOIN establecimientos e ON r.IdEstablecimiento = e.Codigo
                WHERE CodigoPrestacion IN (28021330) AND Ano = 2018
                GROUP BY e.comuna ORDER BY e.comuna';
        $poblaciones = DB::connection('mysql_rem')->select($query);

        foreach($poblaciones as $poblacion) {
            $data[$poblacion->comuna][64]['poblacion'] = $poblacion->total;
        }

        /* 65 */
        $query ='SELECT e.comuna, SUM(Col01) AS total FROM 2018rems r
                JOIN establecimientos e ON r.IdEstablecimiento = e.Codigo
                WHERE CodigoPrestacion IN (23046200) AND Ano = 2018
                GROUP BY e.comuna ORDER BY e.comuna';
        $poblaciones = DB::connection('mysql_rem')->select($query);

        foreach($poblaciones as $poblacion) {
            $data[$poblacion->comuna][65]['poblacion'] = $poblacion->total;
        }

        /* 66 */
        $query ='SELECT e.comuna, SUM(Col01) AS total FROM 2018rems r
                JOIN establecimientos e ON r.IdEstablecimiento = e.Codigo
                WHERE CodigoPrestacion IN ("P2200700") AND Ano = 2018
                GROUP BY e.comuna ORDER BY e.comuna';
        $poblaciones = DB::connection('mysql_rem')->select($query);

        foreach($poblaciones as $poblacion) {
            $data[$poblacion->comuna][66]['poblacion'] = $poblacion->total;
        }

        /* 67 */
        $query ='SELECT e.comuna, SUM(Col01) AS total FROM 2018rems r
                JOIN establecimientos e ON r.IdEstablecimiento = e.Codigo
                WHERE CodigoPrestacion IN ("P2200800") AND Ano = 2018
                GROUP BY e.comuna ORDER BY e.comuna';
        $poblaciones = DB::connection('mysql_rem')->select($query);

        foreach($poblaciones as $poblacion) {
            $data[$poblacion->comuna][67]['poblacion'] = $poblacion->total;
        }



        /* Calculos */
        foreach($data as $nombre_comuna => $comuna) {
            foreach($comuna as $glosa => $valor){
                /* Calculo de actividadesProgramadas = poblacion * concentracion */
                if($data[$nombre_comuna][$glosa]['concentracion']) {
                    $data[$nombre_comuna][$glosa]['actividadesProgramadas'] =
                        $data[$nombre_comuna][$glosa]['poblacion'] *
                        $data[$nombre_comuna][$glosa]['concentracion'];
                }
            }
        }

        // echo '<pre>';
        // print_r($data);
        // die();

        return view('indicators.program_aps.2018.index', compact('data','glosas','communes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $glosas = ProgramApsGlosa::where('periodo', 2018)->get();
        $establishments = Establishment::All();
        $communes = Commune::All();
        return view('indicators.program_aps.2018.create', compact('glosas','establishments', 'communes'));
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

        return redirect()->route('indicators.program_aps.2018.create');
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
        $programApsValue = ProgramApsValue::firstOrCreate([
            'program_aps_glosa_id' => $glosa->id,
            'commune_id' => $commune->id,
            'periodo' => $glosa->periodo
         ]);
        //$programApsValue->save();
        $glosas = ProgramApsGlosa::where('periodo', 2018)->get();
        $establishments = Establishment::All();
        $communes = Commune::All();
        return view('indicators.program_aps.2018.edit',
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
        return redirect()->route('indicators.program_aps.2018.index');
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
