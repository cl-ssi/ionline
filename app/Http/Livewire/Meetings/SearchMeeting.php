<?php

namespace App\Http\Livewire\Meetings;

use Livewire\Component;

use App\Models\Meetings\Meeting;

class SearchMeeting extends Component
{
    public $index;

    public function render()
    {
        if($this->index == 'own'){
            return view('livewire.meetings.search-meeting', [
                'meetings' => Meeting::all()
            ]);
        }
    }
}
