<?php

namespace App\Http\Controllers\Indicators\_2020;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;


class Indicator19813Controller extends Controller
{
    public function index()
    {
        $sql_ultimo_rem = "SELECT MAX(Mes) as ultimo_rem FROM 2020rems;";
        $ultimo_rem = DB::connection('mysql_rem')->select($sql_ultimo_rem)[0]->ultimo_rem;

        /* 2019 */
        include(app_path().'/Http/Controllers/Indicators/_2019/19813/indicator1.php');

        include('19813/indicator1.php');
        include('19813/indicator2.php');
        include('19813/indicator3a.php');
        include('19813/indicator3b.php');
        include('19813/indicator3c.php');
        include('19813/indicator4a.php');
        include('19813/indicator4b.php');
        include('19813/indicator5.php');
        include('19813/indicator6.php');
        return view('indicators.19813.2020.index', compact('data12020', 'data22020', 'data3a2020', 'data3b2020',
                                                            'data3c2020', 'data4a2020', 'data4b2020', 'data52020',
                                                            'data62020','ultimo_rem'));
    }

    public function show(Request $request, $year, $law, $id)
    {
        $metas = $request->input('meta');
        $comunas = $request->input('comuna');
        return view('indicators/$year/$law/$id')->withYear($year)->withLaw($law)->withId($id)->withMetas($metas)->withComunas($comunas);
    }

    /* Metas de ley 19813 */
    public function indicador1(){
        $sql_ultimo_rem = "SELECT MAX(Mes) as ultimo_rem FROM 2020rems;";
        $ultimo_rem = DB::connection('mysql_rem')->select($sql_ultimo_rem)[0]->ultimo_rem;

        include(app_path().'/Http/Controllers/Indicators/_2019/19813/indicator1.php');
        include('19813/indicator1.php');

        return view('indicators.19813.2020.indicador1', compact('data12019', 'data12020', 'label', 'ultimo_rem'));
    }

    public function indicador2(){
        include('19813/indicator2.php');

        return view('indicators.19813.2020.indicador2', compact('data22020', 'label', 'ultimo_rem'));
    }

    public function indicador3a(){
        include('19813/indicator3a.php');

        return view('indicators.19813.2020.indicador3a', compact('data3a2020', 'label', 'ultimo_rem'));
    }

    public function indicador3b(){
        include('19813/indicator3b.php');

        return view('indicators.19813.2020.indicador3b', compact('data3b2020', 'label', 'ultimo_rem'));
    }

    public function indicador3c(){
        include('19813/indicator3c.php');

        return view('indicators.19813.2020.indicador3c', compact('data3c2020', 'label', 'ultimo_rem'));
    }

    public function indicador4a(){
        include('19813/indicator4a.php');

        return view('indicators.19813.2020.indicador4a', compact('data4a2020', 'label', 'ultimo_rem'));
    }

    public function indicador4b(){
        include('19813/indicator4b.php');

        return view('indicators.19813.2020.indicador4b', compact('data4b2020', 'label', 'ultimo_rem'));
    }

    public function indicador5(){
        include('19813/indicator5.php');

        return view('indicators.19813.2020.indicador5', compact('data52020', 'label', 'ultimo_rem'));
    }

    public function indicador6(){
        include('19813/indicator6.php');

        return view('indicators.19813.2020.indicador6', compact('data62020', 'label', 'ultimo_rem'));
    }
}
