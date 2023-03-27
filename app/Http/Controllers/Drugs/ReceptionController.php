<?php

namespace App\Http\Controllers\Drugs;

use App\Http\Controllers\Controller;
use App\Http\Requests\Drugs\StoreReceptionRequest;
use App\Http\Requests\Drugs\UpdateReceptionRequest;
use App\Models\Drugs\Reception;
use App\Models\Drugs\ReceptionItem;
use App\Models\Parameters\Parameter;
use App\Models\Drugs\Court;
use App\Models\Drugs\PoliceUnit;
use App\Models\Drugs\Substance;
use App\Models\Drugs\Destruction;
use App\Models\Drugs\Protocol;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReceptionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return view('drugs.receptions.index');
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
        return view('drugs.receptions.create')
            ->withCourts($courts)
            ->withPolice_units($policeUnits);
    }

    /* TODO: $x = Parameter::Where('module','drugs')->Where('parameter','MandatadoResolucion')->first(['value'])->value */

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Drugs\StoreReceptionRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreReceptionRequest $request)
    {
        $reception = new Reception($request->validated());
        $reception->user()->associate(Auth::user());
        $reception->date = now();
        $reception->manager_id = Parameter::get('drugs','Jefe');
        $reception->lawyer_id  = Parameter::get('drugs','Mandatado');
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
        $manager = User::Find(Parameter::get('drugs','Jefe'))->FullName;
        $observer = optional(User::Find(Parameter::get('drugs','MinistroDeFe')))->FullName;
        $lawyer_observer = optional(User::Find(Parameter::get('drugs','MinistroDeFeJuridico')))->FullName;

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

        return view('drugs.receptions.edit', compact('reception', 'courts', 'policeUnits'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Drugs\UpdateReceptionRequest  $request
     * @param  \App\Models\Drugs\Reception  $reception
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateReceptionRequest $request, Reception $reception)
    {
        $reception->update($request->validated());
        session()->flash('success', 'El acta de recepción '.$reception->id.' ha sido actualizado.');
        return redirect()->route('drugs.receptions.show', $reception->id);
    }

    public function showRecord(Reception $reception)
    {
        return view('drugs.receptions.reception_record')->withReception($reception);
    }

    public function showDocFiscal(Reception $reception)
    {
        /* Borrar poque no se ocupa parece XD */
        $substances = ReceptionItem::Where('reception_id',1)->distinct()->get(['substance_id']);

        $mandato = Parameter::get('drugs','MandatadoResolucion');

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
        $receptionitem->dispose_precursor = $request->input('dispose_precursor') == 'on' ? 1 : null;
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

        $manager_position = Parameter::get('drugs','Jefe');
        return view('drugs.receptions.protocols.show', compact('protocol','letra','manager_position'));
    }

    public function report()
    {
        /**
         * Obtiene todos los items sin reservar y por destruir.
         */
        $items = ReceptionItem::query()
            ->with('substance')
            ->whereNull('dispose_precursor')
            ->doesnthave('reception.destruction')
            ->selectRaw('*, net_weight - sample - countersample as total_sample')
            ->get();

        /**
         * Filtro los que tienen cantidad mayor a cero a destruir
         */
        $items = $items->filter(function($item) {
            return $item->total_sample > 0;
        });

        /**
         * Suma el total a destruir agrupados por sustancias
         */
        $items_sin_destruir = $items->groupBy('substance.name')->map(function ($row) {
            return $row->sum('destruct');
        });

        /**
         * Filtro para mostrar solo las sustancias donde la suma a destruir sea mayor a cero
         */
        $items_sin_destruir = $items_sin_destruir->filter(function($item) {
            return $item > 0;
        });

        /**
         * Obtiene todos los items
         */
        $items = ReceptionItem::query()
            ->with([
                'reception',
                'reception.user',
                'reception.court',
                'substance',
                'protocols',
                'reception.destruction.user',
                'resultSubstance',
                'reception.sampleToIsp',
                'reception.recordToCourt',
            ])
            ->orderBy('reception_id', 'desc')
            ->paginate(1000);


        return view('drugs.receptions.report', compact('items', 'items_sin_destruir'));
    }
}
