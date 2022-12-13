<?php

namespace App\Http\Livewire\JobPositionProfile;

use Livewire\Component;
use App\Models\JobPositionProfiles\Role;

class Roles extends Component
{
    public $inputs = [];
    public $i = 1;
    public $count = 0;
    public $jobPositionProfile;
    public $roles = null;
    public $role = null;

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

    public function deleteRole($role)
    {
        $this->role = Role::find($role['id']);
        $this->role->delete();
    }

    public function render()
    {
        $this->roles = Role::where('job_position_profile_id', $this->jobPositionProfile->id)->get();
        return view('livewire.job-position-profile.roles');
    }
}
