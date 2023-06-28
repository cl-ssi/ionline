<?php

namespace App\Http\Controllers\Summary;

use App\Http\Controllers\Controller;
use App\Models\Summary\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
    public function update(Request $request, Event $event)
    {

        $event->fill($request->all());
        /** Preguntar si asigna fiscla */
        if ($event->type->investigator) {
            // Lógica para asignar fiscal
        }

        /** Preungar si asigna actuario */
        if ($event->type->actuary) {
            // Lógica para asignar actuario
        }

        /** Preguntar si es ultimo evento y cerrar el sumario */

        /** Parte de último evento que cierra sumario */
        if ($event->type->end) {
            // Lógica para cierre de sumario
            $event->end_date = now();
            $event->summary->end_at = now();
            $event->summary->save();
        }

        // Verificar si es el último evento y cerrar el sumario
        if ($request->input('save') === 'save&close') {
            // Lógica para cerrar el sumario
            $event->end_date = now();
        }        
        
        $event->save();
        session()->flash('success', 'Evento ' . $event->type->name . ' del sumario ' . $event->summary->name . ' Actualizado exitosamente');
        return redirect()->route('summary.index');
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
