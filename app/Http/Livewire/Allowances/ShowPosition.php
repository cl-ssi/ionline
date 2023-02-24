<?php

namespace App\Http\Livewire\Allowances;

use Livewire\Component;

use App\User;

class ShowPosition extends Component
{
    public $position;

    public $searchedUser;

    protected $listeners = ['searchedUser'];

    public function mount(){
        if($this->position) {            
            $this->setPosition($this->position);
        }
    }

    public function setPosition($position)
    {
        $this->position = $position;
    }

    public function render()
    {
        return view('livewire.allowances.show-position');
    }

    public function searchedUser(User $user){
        $this->searchedUser = $user;
        $this->position = $this->searchedUser->position;
    }
}
