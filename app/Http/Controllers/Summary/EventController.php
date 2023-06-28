<?php

namespace App\Http\Controllers\Summary;

use Illuminate\Http\Request;
use App\Models\Summary\Summary;
use App\Models\Summary\Event;
use App\Http\Controllers\Controller;

class EventController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Summary $summary)
    {
        Event::create([
            'event_id' => $request->input('event_id'),
            'start_date' => now(),
            'summary_id' => $summary->id,
            'creator_id' => auth()->id(),
        ]);

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Summary\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function show(Event $event)
    {
        //
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Summary\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Summary $summary, Event $event)
    {
        $event->fill($request->all());

        /** Preguntar si asigna fiscal */
        if ($event->type->investigator == true) {
            if($request->input('user_id')) {
                $summary->investigator_id = $request->input('user_id');
                $summary->save();
            }
            else {
                session()->flash('danger', 'Debe incluir un usuario');
            }
        }

        /** Preguntar si asigna actuario */
        if ($event->type->actuary == true) {
            if($request->input('user_id')) {
                $summary->actuary_id = $request->input('user_id');
                $summary->save();
            }
            else {
                session()->flash('danger', 'Debe incluir un usuario');
            }
        }

        /** Preguntar si es ultimo evento y cerrar el sumario */

        /** Parte de último evento que cierra sumario */
        if ($event->type->end) {
            /* Lógica para cierre de sumario */
            $event->end_date = now();

            $summary->end_at = now();
            $summary->save();
        }

        /* Verificar si es el último evento y cerrar el sumario */
        if ($request->input('save') === 'save&close') {
            /* Lógica para cerrar el evento */
            $event->end_date = now();
        }
        
        $event->save();

        session()->flash('success', 'El evento ' . $event->type->name . ' se actualizado exitosamente');

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Summary\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function destroy(Event $event)
    {
        //
    }
}
