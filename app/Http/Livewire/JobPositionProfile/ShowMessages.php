<?php

namespace App\Http\Livewire\JobPositionProfile;

use Livewire\Component;

use App\Models\JobPositionProfiles\Message;

class ShowMessages extends Component
{
    public function render()
    {
        $messages = Message::all();
        return view('livewire.job-position-profile.show-messages', compact('messages'));
    }
}
