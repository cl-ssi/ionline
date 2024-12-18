<?php

namespace App\Http\Controllers\Drugs;

use App\Exports\Drugs\ReceptionExport;
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
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Contracts\View\View;

class ReceptionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        /** Log access a partes, no crea otro registro, si el usuario ingreso dentro de los últimos x minutos */
        $minutos = 15;
        $ha_ingresado_en_rango_de_x_minutos = auth()->user()->accessLogs->where('type','drugs')->where('created_at', '>', now()->subMinutes($minutos))->last();
        
        if(!$ha_ingresado_en_rango_de_x_minutos) {
            // Registramos su acceso a partes
            auth()->user()->accessLogs()->create([
                'type' => 'drugs',
                'switch_id' => session()->get('god'),
                'enviroment' => 'Cloud Run' // Ya no es necesario
            ]);
        }

        return view('drugs.receptions.index');
    }

    /**
     * Show the form for creating a new resource.
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
        $reception->user()->associate(auth()->user());
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
     */
    public function show(Reception $reception)
    {
        $substances = Substance::where('presumed', true)->orderBy('name')->get();
        $trashedDestructions = Destruction::onlyTrashed()->where('reception_id', $reception->id)->get();
        $manager = User::Find(Parameter::get('drugs','Jefe'))->fullName;
        $observer = optional(User::Find(Parameter::get('drugs','MinistroDeFe')))->fullName;
        $lawyer_observer = optional(User::Find(Parameter::get('drugs','MinistroDeFeJuridico')))->fullName;

        return view('drugs.receptions.show', compact('reception', 'substances', 'trashedDestructions','manager','observer','lawyer_observer'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Drugs\Reception  $reception
     */
    public function history(Reception $reception): View
    {
        return view(view: 'drugs.receptions.history', data: compact('reception'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Drugs\Reception  $reception
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
        $reception->user()->associate(auth()->user());
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
        $protocol->user()->associate(auth()->user());
        $protocol->receptionItem()->associate($receptionitem);
        $protocol->save();

        session()->flash('success', 'Se ha agregado un protocolo al item nue: '.$receptionitem->nue.'');
        return back();
    }

    public function showProtocol(Protocol $protocol)
    {
        $manager_position = Parameter::get('drugs','Jefe');
        return view('drugs.receptions.protocols.show', compact('protocol','manager_position'));
    }

    public function report()
    {
        /**
         * Obtiene todos los items sin reservar y por destruir.
         */
        $items = ReceptionItem::query()
            ->with(
                [
                    'reception',
                    'reception.user',
                    'reception.partePoliceUnit',
                    'reception.court',
                    'resultSubstance',
                    'reception.destruction',
                    'reception.sampleToIsp',
                    'reception.recordToCourt',
                    'substance',
                ]
            )
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
         * Suma el total a destruir agrupados por sustancias, cada sustancia con su unidad de medida.
         */
        $items_sin_destruir = $items->groupBy('substance.name')->map(function ($item, $key) {
            return [
                'sum' => $item->sum('destruct'),
                'unit' => $item->pluck('substance.unit')->unique()->first(),
            ];
        });

        /**
         * Filtro para mostrar solo las sustancias donde la suma a destruir sea mayor a cero
         */
        $items_sin_destruir = $items_sin_destruir->filter(function($item, $key) {
            return $item['sum'] > 0;
        });

        $years = Reception::select(DB::raw('YEAR(created_at) as year'))
                ->groupBy('year')
                ->orderBy('year', 'asc')
                ->get();

        return view('drugs.receptions.report', compact('items_sin_destruir','years'));
    }

    public function alerts(): View
    {
        /**
         * Obtiene todas las recepciones que contengan sustancias que ISP y Presumidas sea true y 
         * que no tengan relación con sampleToIsp (no han sido enviadas al ISP)
         */
        $receptionsNotSentToIsp = Reception::with('items','items.substance')
            ->whereHas('items', function ($query) {
                $query->whereHas('substance', function ($substanceQuery) {
                    $substanceQuery->where('isp', true)
                                ->where('presumed', true);
                });
            })
            ->doesntHave('sampleToIsp')  // Aquí se filtran las recepciones sin relación con sampleToIsp
            ->whereDate('created_at', '>', now()->startOfYear()->subYears(3))  // ultimos 3 años
            ->get();

        /**
         * Obtiene todas las recepciones que tengan relación con destrucción y que no se les ha creado recordToCourt
         * (no se ha enviado a fiscalía)
         */
        $receptionsWithDestructionNotSendedToCourt = Reception::with('items','items.substance','destruction')
            ->whereHas('destruction', function ($query) {
                $query->where('destructed_at', '<=', now()->subDays(5));
            })
            ->has('destruction')
            ->doesntHave('recordToCourt')
            ->whereDate('created_at', '>', now()->startOfYear()->subYears(3))  // ultimos 3 años
            ->get();

        /**
         * Obtiene todas las recepciones que no tengan relación con recordToCourt
         * y cuya fecha de recepción (created_at) sea mayor a 30 días
         */
        $receptionsWithoutRecordToCourtOlderThan30Days = Reception::with('items','items.substance','destruction')
            ->doesntHave('recordToCourt')
            ->whereDate('created_at', '<=', now()->subDays(30)) // Filtra las recepciones creadas hace más de 30 días
            ->whereDate('created_at', '>', now()->startOfYear()->subYears(3))  // ultimos 3 años
            ->get();

        /**
         * Obtiene todas las recepciones que tengan items y que el item tenga una contra muestra
         * y tenga más de 2 años de antiguedad, utiliozando Reception
         */
        $itemsGreatherThanTwoYears = Reception::with('items')
            ->whereHas('items', function ($query) {
                $query->where('countersample', '>', 0);
            })
            ->whereBetween('created_at', [
                now()->subYears(2)->subMonth(),
                now()->subYears(2), 
            ])
            ->get();

        return view('drugs.receptions.alerts', compact(
            'receptionsNotSentToIsp', 
            'receptionsWithDestructionNotSendedToCourt',
            'receptionsWithoutRecordToCourtOlderThan30Days',
            'itemsGreatherThanTwoYears'
        ));
    }

    public function export($year) 
    {
        return Excel::download(new ReceptionExport($year), 'report.xlsx');
    }
}
