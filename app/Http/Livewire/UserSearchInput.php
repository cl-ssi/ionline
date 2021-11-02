<?php

namespace App\Http\Livewire;
use App\User;

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
