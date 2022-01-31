<?php

namespace App\Http\Controllers\Drugs;

use App\Models\Drugs\RecordToCourt;
use App\Models\Drugs\Reception;
use App\Parameters\Parameter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class RecordToCourtController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Reception $reception, Request $request)
    {
        $recordToCourt = RecordToCourt::firstOrNew(['reception_id' => $reception->id]);
        $recordToCourt->fill($request->all());
        $recordToCourt->reception_id = $reception->id;
        $recordToCourt->user()->associate(Auth::user());
        $recordToCourt->manager_id = Parameter::get('drugs','Jefe')->value;
        $recordToCourt->lawyer_id  = Parameter::get('drugs','Mandatado')->value;
        $recordToCourt->save();

        session()->flash('info', 'Se ha creado oficio a fiscalía número: '
                                    .$recordToCourt->number);

        return redirect()->route('drugs.receptions.show', $recordToCourt->reception_id);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Drugs\RecordToCourt  $recordToCourt
     * @return \Illuminate\Http\Response
     */
    public function show(Reception $reception)
    {
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

        $itemsISP = $reception->items->where('substance.laboratory', 'ISP');
        $itemsSEREMI = $reception->items->where('substance.laboratory', 'SEREMI');

        //dd($itemsISP);

        $recordToCourt = $reception->recordToCourt;

        $mandato = Parameter::get('drugs','MandatadoResolucion')->value;

        return view('drugs.receptions.record_to_court',
                    compact('reception', 'recordToCourt', 'itemsISP', 'itemsSEREMI','mandato'));
    }

}
