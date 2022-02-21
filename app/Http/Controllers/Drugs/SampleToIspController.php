<?php

namespace App\Http\Controllers\Drugs;

use App\Models\Drugs\SampleToIsp;
use App\Models\Drugs\Reception;
use App\Parameters\Parameter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class SampleToIspController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Reception $reception, Request $request)
    {
        $sampleToISP = SampleToISP::firstOrNew(['reception_id' => $reception->id]);
        $sampleToISP->fill($request->all());
        $sampleToISP->reception_id = $reception->id;
        $sampleToISP->user()->associate(Auth::user());
        $sampleToISP->manager_id = Parameter::get('drugs','Jefe')->value;
        $sampleToISP->lawyer_id  = Parameter::get('drugs','Mandatado')->value;
        $sampleToISP->save();

        session()->flash('info', 'Se ha creado envío a ISP con peso sobre de '
                                    .$sampleToISP->envelope_weight);

        return redirect()->route('drugs.receptions.show', $sampleToISP->reception_id);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Drug\SampleToIsp  $sampleToIsp
     * @return \Illuminate\Http\Response
     */
    public function show(Reception $reception)
    {
        $samples = 0;

        // $letras = array();
        // foreach (range('a', 'z') as $char) {
        //     $letras[] = $char;
        // }

        /* Calculo de la letra del item */
        $letras = ['a','b','c','d','e','f','g','h','i','j','k','l','m',
                   'n','o','p','q','r','s','t','u','v','w','x','y','z',
                   'aa','ab','ac','ad','ae','af','ag','ah','ai','aj','ak','al','am',
                   'an','ao','ap','aq','ar','as','at','au','av','aw','ax','ay','az',
                   'ba','bb','bc','bd','be','bf','bg','bh','bi','bj','bk','bl','bm',
                   'bn','bo','bp','bq','br','bs','bt','bu','bv','bw','bx','by','bz',
                   'ca','cb','cc','cd','ce','cf','cg','ch','ci','cj','ck','cl','cm',
                   'cn','co','cp','cq','cr','cs','ct','cu','cv','cw','cx','cy','cz',];

        foreach($reception->items as $key => $item){
            $reception->items[$key]['position'] = $letras[$key];
        }

        $items = $reception->items->where('substance.laboratory', 'ISP');

        foreach($items as $item) {
            $samples += $item->sample_number;
        }

        $mandato = Parameter::get('drugs','MandatadoResolucion')->value;

        return view('drugs.receptions.sample_to_isp', compact('reception','samples', 'items', 'mandato'));
    }

}
