<?php

namespace App\Http\Controllers\Lobby;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Lobby\Meeting;
use App\Http\Controllers\Controller;

class MeetingController extends Controller
{
    //
    public function index()
    {
        $meetings = Meeting::latest()->paginate(100);
        return view('lobby.index', compact('meetings'));
    }

    /**
    * Show
    */
    public function show(Meeting $meeting)
    {
        $establishment = $meeting->responsible->organizationalUnit->establishment;
        return Pdf::loadView('lobby.meeting.show', compact('meeting','establishment'))
            ->stream('meeting.pdf');

    }

    public function create()
    {
        return view('lobby.create');
    }

    public function store(Request $request)
    {
        $meeting = new Meeting($request->All());
        $meeting->save();
        session()->flash('success', 'Lobby creado exitosamente');
        return redirect()->route('lobby.meeting.index');
    }

    public function edit(Meeting $meeting)
    {
        return view('lobby.edit', compact('meeting'));
    }

    public function update(Request $request, Meeting $meeting)
    {
        $meeting->fill($request->all());
        $meeting->save();
        session()->flash('success', 'Lobby actualizado exitosamente');
        return redirect()->route('lobby.meeting.index');
    }
}
