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
        /** Preguntar si asigna fiscla */

        /** Preungar si asigna actuario */

        /** Preguntar si es ultimo evento y cerrar el sumario */


        dd($request->all());
        $event->fill($request->all());
        $event->save();

        /** Sacar el código de carga y eliminación de archivo a otros metodos de archivos */
        if ($request->hasFile('files')) {
            $files = $request->file('files');
            foreach ($files as $file) {
                $summaryEventFile = new SummaryEventFile();
                $filename = $file->getClientOriginalName();
                $summaryEventFile->summary_event_id = $event->id;
                $summaryEventFile->summary_id = $event->summary->id;
                $summaryEventFile->name = $file->getClientOriginalName();

                $summaryEventFile->file = $file->storeAs('ionline/summary/' .
                    $event->summary->id, $filename, ['disk' => 'gcs']);

                $summaryEventFile->save();
            }
        }

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
