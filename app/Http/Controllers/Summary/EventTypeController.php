<?php

namespace App\Http\Controllers\Summary;

use Illuminate\Http\Request;
use App\Models\Summary\Type;
use App\Models\Summary\Link;
use App\Models\Summary\EventType;
use App\Http\Controllers\Controller;
use App\Models\Summary\Actor;

class EventTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $summaryTypes = Type::with([
            'eventTypes',
            'eventTypes.actor',
        ])
            ->where('establishment_id',auth()->user()->establishment_id)->get();
        return view('summary.events.index', compact('summaryTypes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $summaryTypes = Type::where('establishment_id',auth()->user()->establishment_id)->pluck('name','id');
        $summaryActors = Actor::pluck('name','id');

        return view('summary.events.create', compact('summaryTypes', 'summaryActors'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $eventType = new EventType($request->All());
        $eventType->require_user = isset($request->require_user);
        $eventType->require_file = isset($request->require_file);
        $eventType->start = isset($request->start);
        $eventType->end = isset($request->end);
        $eventType->investigator = isset($request->investigator);
        $eventType->actuary = isset($request->actuary);
        $eventType->repeat = isset($request->repeat);
        $eventType->sub_event = isset($request->sub_event);
        $eventType->summary_actor_id = $request->summary_actor_id;
        $eventType->establishment_id = auth()->user()->organizationalUnit->establishment->id;
        $eventType->save();
        session()->flash('success', 'Se ha añadido el tipo de evento correctamente.');
        return redirect()->route('summary.event-types.index');
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
    public function edit(EventType $eventType)
    {
        $summaryActors = Actor::pluck('name','id');

        $eventTypes = EventType::with('actor')
            ->where('summary_type_id', $eventType->summary_type_id)
            ->where('establishment_id', $eventType->establishment_id)
            ->orderBy('summary_actor_id')
            ->orderBy('name')
            ->get();

        return view('summary.events.edit', compact('eventType', 'summaryActors', 'eventTypes'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, EventType $eventType)
    {
        $eventType->name = $request->input('name');
        $eventType->description = $request->input('description');
        $eventType->duration = $request->input('duration');
        $eventType->require_user = isset($request->require_user);
        $eventType->require_file = isset($request->require_file);
        $eventType->start = isset($request->start);
        $eventType->end = isset($request->end);
        $eventType->investigator = isset($request->investigator);
        $eventType->actuary = isset($request->actuary);
        $eventType->repeat = isset($request->repeat);
        $eventType->sub_event = isset($request->sub_event);
        $eventType->num_repeat = $request->input('num_repeat');
        $eventType->summary_actor_id = $request->summary_actor_id;
        $eventType->establishment_id = auth()->user()->organizationalUnit->establishment->id;
        $eventType->save();

        /* Eliminar los enlaces existentes para el evento */
        $eventType->linksAfter()->delete();


        /* Crear los nuevos enlaces según los seleccionados en el formulario */
        foreach ($request->input('links', []) as $type_id) {
            //Se añaden los boleanos del evento anterior (actual editando) y el siguiente, (el guardado en el store)
            $afterTypeEvent = EventType::findorFail($type_id);
            Link::create([
                "before_event_id" => $eventType->id,
                "before_sub_event" => $eventType->sub_event,
                "after_event_id" => $type_id,
                "after_sub_event" => $afterTypeEvent->sub_event
            ]);

        }

        /* Actualizar los enlaces entre eventos con Link $link = new Link(); */
        session()->flash('success', 'Tipo de Evento actualizado exitosamente');

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(EventType $eventType)
    {
        //
        $eventType->delete();
        session()->flash('danger', 'El Evento ha sido eliminado.');
        return redirect()->route('summary.event-types.index');
    }
}
