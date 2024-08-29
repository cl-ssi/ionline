<?php

namespace App\Livewire\JobPositionProfile;

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
    public $editWorkTeamIdRender = null;
    public $description = null;

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

    public function deleteWorkTeam($workTeam)
    {
        $this->workTeam = WorkTeam::find($workTeam['id']);
        $this->workTeam->delete();
    }

    public function editWorkTeam($workTeam)
    {
        $this->editWorkTeamIdRender = $workTeam['id'];
        $this->description      = $workTeam['description'];
    }

    public function saveEditWorkTeam($workTeam)
    {
        $this->workTeam = WorkTeam::find($workTeam['id']);
        $this->workTeam->description = $this->description;
        
        $this->workTeam->save();
        $this->editWorkTeamIdRender = null;
    }

    public function cancelEdit(){
        $this->editWorkTeamIdRender = null;
    }

    public function render()
    {
        $this->workTeams = WorkTeam::where('job_position_profile_id', $this->jobPositionProfile->id)->get();
        return view('livewire.job-position-profile.create-work-team');
    }
}
