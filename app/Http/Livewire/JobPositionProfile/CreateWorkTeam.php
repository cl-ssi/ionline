<?php

namespace App\Http\Livewire\JobPositionProfile;

use Livewire\Component;
use App\Models\JobPositionProfiles\WorkTeam;

class CreateWorkTeam extends Component
{
    public $inputs = [];
    public $i = 1;
    public $count = 0;
    public $jobPositionProfile;
    public $workTeams = null;
    public $workTeam = null;

    public function add($i)
    {
        $i = $i + 1;
        $this->i = $i;
        array_push($this->inputs ,$i);
        $this->count++;
    }

    public function remove($i)
    {
        unset($this->inputs[$i]);
        $this->count--;
    }

    public function mount($jobPositionProfile)
    {
        $this->jobPositionProfile = $jobPositionProfile;
    }

    public function render()
    {
        $this->work_teams = WorkTeam::where('job_position_profile_id', $this->jobPositionProfile->id)->get();
        return view('livewire.job-position-profile.create-work-team');
    }
}
