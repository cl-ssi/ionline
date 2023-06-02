<?php

namespace App\Http\Controllers\Lobby;

use App\Http\Controllers\Controller;
use App\Models\Lobby\Meeting;
use Illuminate\Http\Request;

class MeetingController extends Controller
{
    //
    public function index()
    {
        $meetings = Meeting::latest()->paginate(100);
        return view('lobby.index',compact('meetings'));
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
}
