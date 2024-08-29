<?php

namespace App\Livewire;
use App\Models\User;

use Livewire\Component;

class UserSearchInput extends Component
{	
	public $term = "";
    public function render()
    {	
    	sleep(1);
        $users = User::search($this->term)->paginate(10);

        $data = [
            'users' => $users,
        ];
        return view('livewire.user-search-input',$data);
    }
}
