<?php

namespace App\Http\Controllers\Summary;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Summary\Event;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $events = Event::all();
        return view('summary.events.index', compact('events'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('summary.events.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $event = new Event($request->All());
        $event->user = isset($request->user);
        $event->file = isset($request->file);
        $event->start = isset($request->start);
        $event->end = isset($request->end);
        $event->investigator = isset($request->investigator);
        $event->actuary = isset($request->actuary);
        $event->repeat = isset($request->repeat);
        $event->establishment_id = auth()->user()->organizationalUnit->establishment->id;
        $event->save();
        session()->flash('success', 'Se ha añadido el tipo de evento correctamente.');
        return redirect()->route('summary.events.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Event $event)
    {
        return view('summary.events.edit', compact('event'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Event $event)
    {
        $event->name = $request->input('name');
        $event->duration = $request->input('duration');
        $event->user = isset($request->user);
        $event->file = isset($request->file);
        $event->start = isset($request->start);
        $event->end = isset($request->end);
        $event->investigator = isset($request->investigator);
        $event->actuary = isset($request->actuary);
        $event->repeat = isset($request->repeat);
        $event->num_repeat = $request->input('num_repeat');
        $event->establishment_id = auth()->user()->organizationalUnit->establishment->id;
        $event->save();
        session()->flash('success', 'Tipo de Evento Actualizado Exitosamente');
        return redirect()->route('summary.events.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Event $event)
    {
        //
        $event->delete();
        session()->flash('danger', 'El Evento ha sido eliminado.');
        return redirect()->route('summary.events.index');
    }
}
