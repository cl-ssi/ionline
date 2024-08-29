<?php

namespace App\Livewire\JobPositionProfile;

use Livewire\Component;

use App\Models\JobPositionProfiles\Message;

class ShowMessages extends Component
{
    public $jobPositionProfile;

    public function render()
    {
        $messages = Message::where('job_position_profile_id', $this->jobPositionProfile->id)
            ->get();
        return view('livewire.job-position-profile.show-messages', compact('messages'));
    }
}
