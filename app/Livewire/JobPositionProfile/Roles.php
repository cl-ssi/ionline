<?php

namespace App\Livewire\JobPositionProfile;

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
    public $editRoleIdRender = null;
    public $description = null;

    // public $messageMaxRoles = null;

    public function add($i)
    {
        /*
        if($this->count == 10){
            $this->messageMaxRoles = 'Estimado Usuario: Ha alcanzado el número máximo de funciones. (10)';
        }
        else{
        */
        
        //SE ELIMINA RESTRICCIÓN DE 10 OBJETIVOS    
        $i = $i + 1;
        $this->i = $i;
        array_push($this->inputs ,$i);
        $this->count++;
        
        /*
        }
        */
    }

    public function remove($i)
    {
        unset($this->inputs[$i]);
        $this->count--;
        // $this->messageMaxRoles = null;
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

    public function editRole($role)
    {
        $this->editRoleIdRender = $role['id'];
        $this->description      = $role['description'];
    }

    public function saveEditRole($role)
    {
        $this->role = Role::find($role['id']);
        $this->role->description = $this->description;
        
        $this->role->save();
        $this->editRoleIdRender = null;
    }

    public function cancelEdit(){
        $this->editRoleIdRender = null;
    }

    public function render()
    {
        $this->roles = Role::where('job_position_profile_id', $this->jobPositionProfile->id)->get();
        return view('livewire.job-position-profile.roles');
    }
}
