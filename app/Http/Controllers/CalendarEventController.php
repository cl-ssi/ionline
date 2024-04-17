<?php

namespace App\Http\Controllers;

use App\Models\CalendarEvent;
use Illuminate\Http\Request;

class CalendarEventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $events = CalendarEvent::where('type', 'vehicle')->with(['driver', 'recipient'])->get();

        $events = $events->map(function ($event) {
            $event->driver_fullname = $event->driver->name . " " . $event->driver->fathers_family . " " . $event->driver->mothers_family;
            $event->recipient_fullname = $event->recipient->name . " " . $event->recipient->fathers_family . " " . $event->recipient->mothers_family;
            unset($event->driver);
            unset($event->recipient);
            return $event;
        });

        return response()->json($events);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'state' => 'required',
            'location' => 'required',
            'passengerNumber' => 'numeric|between:1,4',
            'start' => 'required|date',
            'end' => 'required|date|after_or_equal:start',
            'recipient_id' => 'required',
            'driver_id' => 'required|different:recipient',
        ]);

        $event = CalendarEvent::create($request->all());

        return response()->json($event);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CalendarEvent  $calendarEvent
     * @return \Illuminate\Http\Response
     */
    public function show(CalendarEvent $calendarEvent)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CalendarEvent  $calendarEvent
     * @return \Illuminate\Http\Response
     */
    public function edit(CalendarEvent $calendarEvent)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CalendarEvent  $calendarEvent
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $event = CalendarEvent::findOrFail($id);

        $event->update($request->all());

        return response()->json('Evento Actualizado');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CalendarEvent  $calendarEvent
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $event = CalendarEvent::find($id);

        if (!$event) {
            return response()->json([
                'error' => 'No se pudo encontrar el evento'
            ], 404);
        }

        $event->delete();

        return $id;
    }
}
