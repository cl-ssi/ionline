<?php

namespace App\Http\Controllers\Indicators;

use App\Http\Controllers\Controller;
use App\Indicators\Aps;
use App\Indicators\Establecimiento;
use App\Indicators\Rem;
use App\Indicators\Value;
use Illuminate\Support\Str;

class ApsController extends Controller
{
    public function index()
    {
        return view('indicators.iaps.index');
    }

    public function list($year)
    {
        $iaps = Aps::with('indicators')->where('year', $year)->orderBy('number')->first();
        $iaps->reyno_active = $iaps->indicators()->where('establishment_cods','LIKE', '%102307%')->count() > 0;
        $iaps->hospital_active = $iaps->indicators()->where('establishment_cods','LIKE', '%102100%')->count() > 0;
        $iaps->ssi_active = $iaps->indicators()->where('establishment_cods','LIKE', '%102010%')->count() > 0;
        // return $iaps;
        return view('indicators.iaps.list', compact('iaps', 'year'));
    }
    
    public function show($year, $slug, $establishment_type)
    {
        $iaps = Aps::where('year', $year)->where('slug', $slug)->firstOrFail();
        $iaps->load('indicators.values');
        $this->loadValuesWithRemSource($year, $iaps, $establishment_type);
        // return $iaps;
        return view('indicators.iaps.show', compact('iaps'));
    }
    
    private function loadValuesWithRemSource($year, $iaps, $establishment_type)
    {
        $establishment_type_names = ['aps' => 'APS', 'reyno' => 'CGU Dr. Hector Reyno', 'hospital' => 'Hospital Dr. Ernesto Torres G.', 'ssi' => 'Dirección Servicio de Salud'];
        $iaps->establishment_type = $establishment_type_names[$establishment_type];
        $iaps->establishments = collect();
        foreach($iaps->indicators as $indicator){
            foreach(array('numerador', 'denominador') as $factor){
                $factor_cods = $factor == 'numerador' ? $indicator->numerator_cods : $indicator->denominator_cods;
                $factor_cols = $factor == 'numerador' ? $indicator->numerator_cols : $indicator->denominator_cols;
                $factor_source = $factor == 'numerador' ? $indicator->numerator_source : $indicator->denominator_source;
                $establishment_cods = null;

                if($factor == 'numerador' && $establishment_type == 'aps'){
                    $establishment_cods = array_map('trim', explode(',',$indicator->establishment_cods));
                    $establishment_cods = array_diff($establishment_cods, array("102307", "102100", "102010")); //descartar reyno, hospital y ssi
                    $establishments = Establecimiento::year($year)->whereIn('Codigo', $establishment_cods)->get(['id_establecimiento','alias_estab','comuna']);
                    foreach($establishments as $item) $iaps->establishments->add($item);
                }

                if($factor_cods != null && $factor_cols != null){
                    //procesamos los datos necesarios para las consultas rem
                    $cods = array_map('trim', explode(',', $factor_cods));
                    $cols = array_map('trim', explode(',', $factor_cols));
                    $raws = null;
                    foreach($cols as $col)
                        $raws .= next($cols) ? 'SUM(COALESCE('.$col.', 0)) + ' : 'SUM(COALESCE('.$col.', 0))';
                    $raws .= ' AS valor, IdEstablecimiento, Mes';
    
                    $result = Rem::year($year)->selectRaw($raws)
                                ->when($establishment_type == 'aps', function($query) use ($establishment_cods){ 
                                    return $query->with('establecimiento')->whereIn('IdEstablecimiento', $establishment_cods); 
                                })
                                ->when($establishment_type == 'reyno', function($query){
                                    return $query->where('IdEstablecimiento', 102307);
                                })
                                ->when($establishment_type == 'hospital', function($query){
                                    return $query->where('IdEstablecimiento', 102100);
                                })
                                ->when($establishment_type == 'ssi', function($query){
                                    return $query->where('IdEstablecimiento', 102010);
                                })
                                ->when($factor_source == 'REM P', function($query){
                                    return $query->whereIn('Mes', [6,12]);
                                })
                                ->whereIn('CodigoPrestacion', $cods)->groupBy('IdEstablecimiento','Mes')->orderBy('Mes')->get();
    
                    foreach($result as $item){
                        $value = new Value(['month' => $item->Mes, 'factor' => $factor, 'value' => $item->valor]);
                        $value->commune = $item->establecimiento->comuna;
                        $value->establishment = $item->establecimiento->alias_estab;
                        $indicator->values->add($value);
                    }
                }
            }
        }
        
        if($establishment_type == 'aps'){
            $iaps->establishments = $iaps->establishments->unique();
            $iaps->communes = $iaps->establishments->unique('comuna')->pluck('comuna')->sort();
        }
    }

}
