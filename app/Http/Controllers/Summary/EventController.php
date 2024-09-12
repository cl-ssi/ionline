<?php

namespace App\Http\Controllers\Summary;

use App\Http\Controllers\Controller;
use App\Models\Summary\Event;
use App\Models\Summary\Summary;
use Illuminate\Http\Request;

class EventController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Summary $summary, Event $event)
    {

        Event::create([
            'event_type_id' => $request->input('event_type_id'),
            'start_date' => now(),
            'summary_id' => $summary->id,
            'creator_id' => auth()->id(),
            'father_event_id' => $event->id,
        ]);

        return redirect()->back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Summary $summary, Event $event)
    {
        $event->fill($request->all());

        /** Preguntar si asigna fiscal */
        if ($event->type->investigator == true) {
            if ($request->input('user_id')) {
                $summary->investigator_id = $request->input('user_id');
                $summary->save();
            } else {
                session()->flash('danger', 'Debe incluir un usuario');
            }
        }

        /** Preguntar si asigna actuario */
        if ($event->type->actuary == true) {
            if ($request->input('user_id')) {
                $summary->actuary_id = $request->input('user_id');
                $summary->save();
            } else {
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

        session()->flash('success', 'El evento '.$event->type->name.' se actualizado exitosamente');

        return redirect()->back();
    }
}
