<?php

namespace App\Livewire\Allowances;

use Livewire\Attributes\On;
use Livewire\Component;

use App\Models\User;

class ShowPosition extends Component
{
    public $position;

    public $searchedUser;

    protected $rules = [
        'position'  => 'required'
    ];
    
    protected $messages = [
        'position.required' => 'Favor completar este campo.'
    ];

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

    #[On('searchedUser')]
    public function searchedUser(User $user) {
<<<<<<< HEAD
        $this->searchedUser = $user;
        $this->position = $this->searchedUser->position;
        
=======
        $this->position = $user->position;

>>>>>>> ea952b412 (Víaticos: Fix LW usuarios comunas)
        /* Se emite position a Allowance */
        $this->dispatch('emitPosition', position: $user->position);
    }

    public function updatedPosition($positionValue)
    {
        /* Se emite position a Allowance */
        $this->dispatch('emitPositionValue', position: $positionValue);
    }
}
