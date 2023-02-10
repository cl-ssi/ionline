<?php

namespace App\Http\Livewire\Lobby;

use Livewire\Component;
use App\Models\Lobby\Meeting;

class MeetingShow extends Component
{
    public Meeting $meeting;

    public function render()
    {
        return view('livewire.lobby.meeting-show')->layout('layouts.report');
    }
}
