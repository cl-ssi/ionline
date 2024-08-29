<?php

namespace App\Http\Controllers;

use App\Livewire\CalendarEvent;
use App\Models\CarCalendarEvent;
use Illuminate\Http\Request;

class CarCalendarEventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
 
    public function index()
{
    $events = CarCalendarEvent::all();

    $events = $events->map(function ($event) {
        $event->driver_fullname = $event->driver ? $event->driver->name . " " . $event->driver->fathers_family . " " . $event->driver->mothers_family : null;
        $event->requester_fullname = $event->requester ? $event->requester->name . " " . $event->requester->fathers_family . " " . $event->requester->mothers_family : null;
        $event->requester_unit = $event->requester && $event->requester->organizationalUnit ? $event->requester->organizationalUnit->name : null;
        $event->backgroundColor = $this->getColor($event->state);
        unset($event->driver);
        unset($event->requester);
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
            'passengerNumber' => 'numeric|between:1,16',
            'start' => 'required|date',
            'end' => 'required|date|after_or_equal:start',
            'driver_id' => 'different:requester',
        ]);

        $event = CarCalendarEvent::create($request->all());

        return response()->json($event);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CalendarEvent  $calendarEvent
     * @return \Illuminate\Http\Response
     */
    public function show(CarCalendarEvent $calendarEvent)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CalendarEvent  $calendarEvent
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $event = CarCalendarEvent::findOrFail($id);
        return view('calendars.edit', compact('event'));
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
        $event = CarCalendarEvent::findOrFail($id);

        // $event->update([$request->all(), 'state' => $request->input('state'), 'color' => $this->getColor($request->input('state'))]);

        $event->update($request->all());
        // $event->save();

        return redirect('/calendars')->with('success', 'Evento Actualizado');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CalendarEvent  $calendarEvent
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $event = CarCalendarEvent::find($id);

        if (!$event) {
            return response()->json([
                'error' => 'No se pudo encontrar el evento'
            ], 404);
        }

        $event->delete();

        return $id;
    }

    private function getColor($state)
    {
        $colorMap = [
            'En Mantencion' => '#dc3545',
            'Por Confirmar' => '#fd7e14',
            'En Espera' => '#ffc107',
            'Agendado' => '#198754',
            'Disponible' => '#0d6efd',
            'Suspendido' => '#6c757d',
            'No Operativo' => '#553C7B',
        ];

        return $colorMap[$state] ?? null;
    }
}
