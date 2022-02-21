<?php

namespace App\Http\Controllers\Drugs;

use App\Models\Drugs\Reception;
use App\Models\Drugs\ReceptionItem;
use App\User;
use App\Parameters\Parameter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Drugs\Court;
use App\Models\Drugs\PoliceUnit;
use App\Models\Drugs\Substance;
use App\Models\Drugs\Destruction;
use App\Models\Drugs\Protocol;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;


class ReceptionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $receptions = Reception::with('documentPoliceUnit', 'partePoliceUnit', 'items')->Search($request->get('id'))->get();
        //dd($receptions);
        //$receptions = Reception::whereDate('created_at', '>', Carbon::today()->subDays(16))->latest()->get();
        //Reception::Reception::whereDate('created_at', '>', Carbon\Carbon::today()->subDays(16))->latest()->paginate(100);
        return view('drugs.receptions.index')->withReceptions($receptions);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $courts = Court::All()->SortBy('name');
        $policeUnits = PoliceUnit::All()->SortBy('name');
        //$substances = Substance::All()->SortBy('name');
        return view('drugs.receptions.create')
            ->withCourts($courts)
            ->withPolice_units($policeUnits);
    }

    //TODO: $x = Parameter::Where('module','drugs')->Where('parameter','MandatadoResolucion')->first(['value'])->value

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $reception = new Reception($request->All());
        $reception->user()->associate(Auth::user());
        $reception->manager_id = Parameter::get('drugs','Jefe')->value;
        $reception->lawyer_id  = Parameter::get('drugs','Mandatado')->value;
        $reception->save();

        return redirect()->route('drugs.receptions.show', $reception);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Drugs\Reception  $reception
     * @return \Illuminate\Http\Response
     */
    public function show(Reception $reception)
    {
        $substances = Substance::where('presumed', true)->orderBy('name')->get();
        $trashedDestructions = Destruction::onlyTrashed()->where('reception_id', $reception->id)->get();
        //dd($trashedDestructions);
        $manager = User::Find(Parameter::get('drugs','Jefe')->value)->FullName;
        //$observer = User::Find(Parameter::get('drugs','Mandatado')->value)->FullName;
        $observer = User::Find(Parameter::get('drugs','MinistroDeFe')->value)->FullName;
        $lawyer_observer = User::Find(Parameter::get('drugs','MinistroDeFeJuridico')->value)->FullName;
        return view('drugs.receptions.show', compact('reception', 'substances', 'trashedDestructions','manager','observer','lawyer_observer'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Drugs\Reception  $reception
     * @return \Illuminate\Http\Response
     */
    public function edit(Reception $reception)
    {
        $courts = Court::All()->SortBy('name');
        $policeUnits = PoliceUnit::All()->SortBy('name');

        //$substances = Substance::All()->SortBy('name');
        return view('drugs.receptions.edit', compact('reception', 'courts', 'policeUnits'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Drugs\Reception  $reception
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Reception $reception)
    {
        $reception->fill($request->all());
        $reception->save();
        session()->flash('success', 'El acta de recepción '.$reception->id.' ha sido actualizado.');
        return redirect()->route('drugs.receptions.show',$reception->id);
    }


    public function showRecord(Reception $reception)
    {
        return view('drugs.receptions.reception_record')->withReception($reception);
    }

    public function showDocFiscal(Reception $reception)
    {

        /* Borrar poque no se ocupa parece XD */
        $substances = ReceptionItem::Where('reception_id',1)->distinct()->get(['substance_id']);

        $mandato = Parameter::get('drugs','MandatadoResolucion')->value;

        //return view('drugs.receptions.doc_fiscal', compact('reception', 'substances', 'mandato'));
    }



    public function storeItem(Request $request, Reception $reception)
    {
        if ($request->filled('net_weight')) {
            $destruct = $request->input('net_weight') -
                ( $request->input('sample_number') * ( $request->input('sample') + $request->input('countersample') ) );
        }
        else {
            $destruct = $request->input('estimated_net_weight') -
                ( $request->input('sample_number') * ( $request->input('sample') + $request->input('countersample') ) );
        }
        $request->request->set('destruct', $destruct);
        $reception->items()->create($request->all());

        /* Re asociar usuario a quien le agrega items a la recepción */
        $reception->user()->associate(Auth::user());
        $reception->save();

        return redirect()->route('drugs.receptions.show', $reception);
    }

    public function editItem(ReceptionItem $receptionitem)
    {
        $substances = Substance::where('presumed', true)->orderBy('name')->get();
        $substancesFound = Substance::where('presumed', false)->orderBy('name')->get();
        return view('drugs.receptions.show')
            ->withItem($receptionitem)
            ->withSubstances($substances)
            ->withSubstancesFound($substancesFound)
            ->withReception($receptionitem->reception);

    }

    public function updateItem(Request $request, ReceptionItem $receptionitem)
    {
        if ($request->filled('net_weight')) {
            $destruct = $request->input('net_weight') -
                ( $request->input('sample_number') * ( $request->input('sample') + $request->input('countersample') ) );
        }
        else {
            $destruct = $request->input('estimated_net_weight') -
                ( $request->input('sample_number') * ( $request->input('sample') + $request->input('countersample') ) );
        }
        $request->request->set('destruct', $destruct);
        $receptionitem->fill($request->all());
        $receptionitem->save();
        session()->flash('success', 'El item nue: '.$receptionitem->nue.' ha sido actualizado.');
        return redirect()->route('drugs.receptions.show', $receptionitem->reception->id);
    }

    public function destroyItem(Request $request, ReceptionItem $receptionitem)
    {
        if( ! $receptionitem->reception->wasDestructed() ) {
            $receptionitem->delete();
            session()->flash('success', 'El item nue: '.$receptionitem->nue.' ha sido destruido.');
        }
        return redirect()->route('drugs.receptions.show', $receptionitem->reception->id);
    }

    public function storeResult(Request $request, ReceptionItem $receptionitem)
    {
        $receptionitem->fill($request->all());
        $receptionitem->save();
        session()->flash('success', 'El item nue: '.$receptionitem->nue.' ha sido actualizado.');
        return redirect()->route('drugs.receptions.show', $receptionitem->reception->id);
    }

    public function storeProtocol(Request $request, ReceptionItem $receptionitem)
    {
        $protocol = new Protocol($request->All());
        $protocol->user()->associate(Auth::user());
        $protocol->receptionItem()->associate($receptionitem);
        $protocol->save();

        session()->flash('success', 'Se ha agregado un protocolo al item nue: '.$receptionitem->nue.'');
        return back();
    }

    public function showProtocol(Protocol $protocol)
    {
        /* Calculo de la letra del item */
        $letras = ['a','b','c','d','e','f','g','h','i','j','k','l','m',
                   'n','o','p','q','r','s','t','u','v','w','x','y','z',
                   'aa','ab','ac','ad','ae','af','ag','ah','ai','aj','ak','al','am',
                   'an','ao','ap','aq','ar','as','at','au','av','aw','ax','ay','az',
                   'ba','bb','bc','bd','be','bf','bg','bh','bi','bj','bk','bl','bm',
                   'bn','bo','bp','bq','br','bs','bt','bu','bv','bw','bx','by','bz',
                   'ca','cb','cc','cd','ce','cf','cg','ch','ci','cj','ck','cl','cm',
                   'cn','co','cp','cq','cr','cs','ct','cu','cv','cw','cx','cy','cz',];
        foreach($protocol->receptionItem->reception->items as $item) {
            $items[] = $item->id;
        }
        $clave = array_search($protocol->reception_item_id, $items);
        $letra = $letras[$clave];
        /* Fin del calculo de la letra del item */

        $manager_position = Parameter::get('drugs','Jefe')->value;
        return view('drugs.receptions.protocols.show', compact('protocol','letra','manager_position'));
    }

    public function report()
    {
        $items = ReceptionItem::with('substance')->doesnthave('reception.destruction')->get();
        $items_sin_destruir = $items->groupBy('substance.name')->map(function ($row) {
            return $row->sum('destruct');
        });

        $items = ReceptionItem::with([
            'reception',
            'reception.user',
            'reception.court',
            'substance',
            'protocols',
            'reception.destruction.user',
            'resultSubstance',
            'reception.sampleToIsp',
            'reception.recordToCourt'
            ])->orderBy('reception_id', 'desc')->paginate(5000);

        //$destruct = $items->sum('destruct');

        //dd($deals);
        /*
        $deals = $regions->sum(function ($region) {
            return $region->submits->sum('deals');
        });

        $num = $mystuff->groupBy('dateDay')->map(function ($row) {
            return $row->sum('n');
        });
        */

        return view('drugs.receptions.report', compact('items', 'items_sin_destruir'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Drugs\Reception  $reception
     * @return \Illuminate\Http\Response
     */
    public function destroy(Reception $reception)
    {
        //
    }
}
