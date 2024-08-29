<?php

namespace App\Livewire\Meetings;

use Livewire\Component;

use App\Models\Meetings\Meeting;

class SearchMeeting extends Component
{
    public $index;

    public function render()
    {
        if($this->index == 'own'){
            return view('livewire.meetings.search-meeting', [
                'meetings' => Meeting::latest()
                    ->where('user_creator_id', auth()->id())
                    ->paginate(50)
            ]);
        }
        if($this->index == 'all'){
            return view('livewire.meetings.search-meeting', [
                'meetings' => Meeting::latest()
                    ->paginate(50)
            ]);
        }
    }
}
