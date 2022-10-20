<?php

namespace App\Http\Livewire;

use App\User;
use Livewire\Component;

class MultipleUserSearch extends Component
{
    public $users;
    public $listUsers;
    public $nameInput;

    protected $listeners = [
        'myUserUsingId'
    ];

    public function mount($myUsers)
    {
        $this->users = collect($myUsers);
        $this->listUsers = User::whereIn('id', $this->users)->get();
    }

    public function render()
    {
        return view('livewire.multiple-user-search');
    }

    public function myUserUsingId($value)
    {
        if($value != null)
        {
            $this->users->push($value);
            $this->users = $this->users->unique();
            $this->listUsers = User::whereIn('id', $this->users)->get();
            $this->emit('clearSearchUser');
        }
    }

    public function deleteUser($index)
    {
        $this->users = $this->users->forget($index)->values();
        $this->listUsers = User::whereIn('id', $this->users)->get();
    }
}
