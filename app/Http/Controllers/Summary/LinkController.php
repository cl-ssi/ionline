<?php

namespace App\Http\Controllers\Summary;

use App\Http\Controllers\Controller;
use App\Models\Summary\EventType;
use App\Models\Summary\Link;
use App\Models\Summary\Type;
use Illuminate\Http\Request;

class LinkController extends Controller
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
            'eventTypes.linksBefore',
            'eventTypes.linksBefore.beforeEvent',
            'eventTypes.linksBefore.beforeEvent.actor',
            'eventTypes.linksAfter',
            'eventTypes.linksAfter.afterEvent',
            'eventTypes.linksAfter.afterEvent.actor',
        ])
            ->where('establishment_id', auth()->user()->establishment_id)
            ->get();

        return view('summary.links.index', compact('summaryTypes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $events = EventType::all();

        return view('summary.links.create', compact('events'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Link::create($request->all());
        session()->flash('success', 'Se ha añadido el Vinculo correctamente.');

        return redirect()->route('summary.links.index');
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
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
