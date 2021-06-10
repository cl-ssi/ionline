<?php

namespace App\Http\Controllers\Indicators;

use App\Http\Controllers\Controller;
use App\Indicators\Establecimiento;
use App\Indicators\HealthGoal;
use App\Indicators\Iaaps;
use App\Indicators\Indicator;
use App\Indicators\Percapita;
use App\Indicators\ProgramAps;
use App\Indicators\Rem;
use App\Indicators\Value;
use App\Models\Commune;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class IaapsController extends Controller
{
    public function index()
    {
        return view('indicators.iiaaps.index');
    }

    public function list($year)
    {
        $iiaaps = Iaaps::where('year', $year)->firstOrFail();
        return view('indicators.iiaaps.list', compact('iiaaps'));
    }

    public function show($year, $commune)
    {
        $iiaaps = Iaaps::where('year', $year)->firstOrFail();
        if(!in_array(mb_strtoupper(str_replace("_", " ", $commune)), array_map('trim', explode(';', $iiaaps->communes)))) abort(404);
        $iiaaps->load('indicators.values');
        $this->loadValuesWithRemSource($year, $commune, $iiaaps);
        // return $iiaaps;
        return view('indicators.iiaaps.show', compact('iiaaps'));
    }

    private function loadValuesWithRemSource($year, $commune, $iiaaps)
    {
        $iiaaps->commune = mb_strtoupper(str_replace("_", " ", $commune));
        $iiaaps->communes = array_map('trim', explode(';', $iiaaps->communes)); //Listado de comunas
        $establishment_cods = $iiaaps->establishment_cods != null ? array_map('trim', explode(';',$iiaaps->establishment_cods)) : null; //Listado de establecimientos por comuna
        $iiaaps->establishment_cods = array_map('trim', explode(',', $establishment_cods[array_search($iiaaps->commune, $iiaaps->communes)])); //Seleccionamos solo de la comuna que interesa mostrar
        $iiaaps->establishments = Establecimiento::year($year)->whereIn('Codigo', $iiaaps->establishment_cods)->get('alias_estab');
        foreach($iiaaps->indicators as $indicator){
            $goals = array_map('trim', explode(',', $indicator->goal));
            $indicator->goal = $goals[array_search($iiaaps->commune, $iiaaps->communes)];
            foreach(array('numerador', 'denominador') as $factor){
                $factor_cods = $factor == 'numerador' ? $indicator->numerator_cods : $indicator->denominator_cods;
                $factor_cols = $factor == 'numerador' ? $indicator->numerator_cols : $indicator->denominator_cols;

                // Consultamos si existen en el denominador valores FONASA manuales por comuna
                if($factor == 'denominador' && $indicator->denominator_values_by_commune != null){
                    $values = array_map('trim', explode(',', $indicator->denominator_values_by_commune));
                    $value = $values[array_search($iiaaps->commune, $iiaaps->communes)];

                    if(!empty($value)){ //valores distinto a 0 los procesamos
                        // Seteamos valores nuevos segun comuna y factor denominador
                        $value = new Value(['month' => 12, 'factor' => $factor, 'value' => $value]);
                        $value->commune = $iiaaps->commune;
                        $indicator->values->add($value);
                    }
                }

                if($factor_cods != null && $factor_cols != null){
                    //procesamos los datos necesarios para todas consultas rem que se necesiten para la meta sanitaria
                    $cods_array = array_map('trim', explode(';', $factor_cods));
                    $cols_array = array_map('trim', explode(';', $factor_cols));

                    for($i = 0; $i < count($cods_array); $i++){
                        //procesamos los datos necesarios para las consultas rem
                        $cods = array_map('trim', explode(',', $cods_array[$i]));
                        $cols = array_map('trim', explode(',', $cols_array[$i]));
                        $source = $factor == 'numerador' ? $indicator->numerator_source : $indicator->denominator_source;

                        // if(Str::contains($source, 'FONASA')){
                            // $result = Percapita::year($year)->selectRaw('COUNT(*)*'.reset($cols).' AS valor, COD_CENTRO')
                            //                         ->with('establecimiento')
                            //                         ->whereIn('COD_CENTRO', $iiaaps->establishment_cods)
                            //                         ->whereRaw(implode(' AND ', $cods))
                            //                         ->groupBy('COD_CENTRO')->orderBy('COD_CENTRO')->get();

                            // foreach($result as $item){
                            //     $value = new Value(['month' => 12, 'factor' => $factor, 'value' => $item->valor]);
                            //     $value->commune = $item->establecimiento->comuna;
                            //     $value->establishment = $item->establecimiento->alias_estab;
                            //     $indicator->values->add($value);
                            // }
                            // Consultamos si existen en el denominador valores manuales por comuna
                            // if($factor == 'denominador' && $indicator->denominator_values_by_commune != null){
                            //     $values = array_map('trim', explode(',', $indicator->denominator_values_by_commune));
                            //     $value = $values[array_search($iiaaps->commune, $iiaaps->communes)];

                            //     if(!empty($value)){ //valores distinto a 0 los procesamos
                            //         // Seteamos valores nuevos segun comuna y factor denominador
                            //         $value = new Value(['month' => 12, 'factor' => $factor, 'value' => $value]);
                            //         $value->commune = $iiaaps->commune;
                            //         $indicator->values->add($value);
                            //     }
                            // }
                        // } else { // fuente REM
                            if(Str::contains($source, 'REM')){
                                //Es rem P la consulta?
                                $isRemP = Rem::year($year-1)->select('Mes')
                                    ->whereIn('IdEstablecimiento', $iiaaps->establishment_cods)
                                    ->whereIn('CodigoPrestacion', preg_replace("/[^a-zA-Z 0-9]+/", "", $cods))->groupBy('Mes')->get()->count() == 2; //Procuro quitar los - de los codigos prestaciones antes de la consulta
                                
                                //buscamos por codigos de prestacion con valor negativo indica que existe otra consulta que necesita ser procesada para sumarle (resta) a primera consulta
                                $cods2 = null;
                                foreach($cods as $key => $value){
                                    if (strpos($value, "-") !== false) {
                                        $cods2[] = substr($value, 1); //le quitamos el signo negativo al codigo prestacion y guardamos valor en array $cods2
                                        unset($cods[$key]); //removemos item desde $cods
                                    }
                                }
                                
                                $raws = null;
                                foreach($cols as $col)
                                $raws .= next($cols) ? 'SUM(COALESCE('.$col.', 0)) + ' : 'SUM(COALESCE('.$col.', 0))';
                                $raws .= ' AS valor, IdEstablecimiento, Mes';
                                
                                if(!empty($cods)){
                                $result = Rem::year($isRemP ? $year - 1 : $year)->selectRaw($raws)->with('establecimiento')
                                            ->when($isRemP, function($query){
                                                return $query->where('Mes', 12);
                                            })
                                            ->whereIn('IdEstablecimiento', $iiaaps->establishment_cods)
                                            ->whereIn('CodigoPrestacion', $cods)->groupBy('IdEstablecimiento','Mes')->orderBy('Mes')->get();

                                foreach($result as $item){
                                    $value = new Value(['month' => $item->Mes, 'factor' => $factor, 'value' => $item->valor]);
                                    $value->commune = $item->establecimiento->comuna;
                                    if(!Str::contains($source, 'FONASA')) $value->establishment = $item->establecimiento->alias_estab;
                                    $indicator->values->add($value);
                                }
                            }
                            //Existe otra consulta que ejecutar con valores negativos para sumarlos a la primera consulta
                            if($cods2 != null){
                                //Es rem P la consulta?
                                // $isRemP = Rem::year($year-1)->select('Mes')
                                //             ->whereIn('IdEstablecimiento', $iiaaps->establishment_cods)
                                //             ->whereIn('CodigoPrestacion', $cods2)->groupBy('Mes')->get()->count() == 2;
                                // if($isRemP) $factor == 'numerador' ? $indicator->isNumRemP = true : $indicator->isDenRemP = true;

                                $result = Rem::year($isRemP ? $year -1 : $year)->selectRaw($raws)->with('establecimiento')
                                            ->when($isRemP, function($query){
                                                return $query->where('Mes', 12);
                                            })
                                            ->whereIn('IdEstablecimiento', $iiaaps->establishment_cods)
                                            ->whereIn('CodigoPrestacion', $cods2)->groupBy('IdEstablecimiento','Mes')->orderBy('Mes')->get();

                                foreach($result as $item){
                                    $value = new Value(['month' => $item->Mes, 'factor' => $factor, 'value' => -$item->valor]);
                                    $value->commune = $item->establecimiento->comuna;
                                    if(!Str::contains($source, 'FONASA')) $value->establishment = $item->establecimiento->alias_estab;
                                    $indicator->values->add($value);
                                }
                            }
                        }
                    }
                }
            }
        }
    }
}
