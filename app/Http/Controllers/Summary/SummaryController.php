<?php

namespace App\Http\Controllers\Summary;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Summary\Summary;
use App\Models\Summary\Event;
use App\Models\Summary\EventType;

class SummaryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        /* TODO: mostrar sólo eventos en los que soy creador, fiscal o actuario */
        $summaries = Summary::all();
        return view('summary.index', compact('summaries'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('summary.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        /** Obtiene el evento marcado como primer evento de un sumario */
        $eventType = EventType::where('start',true)->first();

        if(is_null($eventType)) {
            session()->flash('warning', 'No existe ningún tipo de evento marcado como: "Es el primer evento de un sumario"');
        }
        else {
            $summary = new Summary($request->All());
            $summary->creator_id = auth()->user()->id;
            $summary->status = $event->name;
            $summary->start_at = now();
            $summary->establishment_id = auth()->user()->organizationalUnit->establishment->id;
            $summary->save();
            
            $event = new Event();
            $event->event_id = $eventType->id;
            $event->start_date = now();
            $event->summary_id = $summary->id;
            $event->creator_id = auth()->id();
            $event->save();

            session()->flash('success', 'Se creo el sumario correctamente.');
        }

        return redirect()->route('summary.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Summary $summary)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Summary  $summary
     * @return \Illuminate\Http\Response
     */
    public function edit(Summary $summary)
    {
        /** Esto ya no se necesita, ya que está implementado lastEvent */
        // foreach($summary->events as $event) {
        //     if($event->type->sub_event == false) {
        //         $lastNonSubEvent = $event;
        //     }
        // }

        return view('summary.edit', compact('summary'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Summary  $summary
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  Summary  $summary
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
