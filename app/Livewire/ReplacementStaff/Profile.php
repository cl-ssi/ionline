<?php

namespace App\Livewire\ReplacementStaff;

use Livewire\Component;
use App\Models\ReplacementStaff\ProfileManage;
use App\Models\ReplacementStaff\ProfessionManage;

class Profile extends Component
{
    public $inputs = [];
    public $i = 1;
    public $count = 0;

    public $replacementStaff;
    public $profiles;

    public $profileSelected = null;
    public $selectstate = 'disabled';
    public $professions = null;


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

    public function updatedprofileSelected($profile_id){
        $this->professions = ProfessionManage::where('profile_manage_id', $profile_id)->get();

        if($profile_id == 3 or $profile_id == 4){
            $this->selectstate = '';
        }
        else{
            $this->selectstate = 'disabled';
        }
    }

    public function render()
    {
        $this->profiles = ProfileManage::all();

        return view('livewire.replacement-staff.profile', [
            'profiles'          => $this->profiles,
            'replacementStaff'  => $this->replacementStaff
        ]);
    }

}
