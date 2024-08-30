<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Attributes\On;
use Livewire\Component;

class MultipleUserSearch extends Component
{
    public $users;
    public $listUsers;
    public $nameInput;

    public function mount($myUsers)
    {
        $this->users = collect($myUsers);
        $this->listUsers = User::whereIn('id', $this->users)->get();
    }

    public function render()
    {
        return view('livewire.multiple-user-search');
    }

    #[On('myUserUsingId')]
    public function myUserUsingId($value)
    {
        if($value != null)
        {
            $this->users->push($value);
            $this->users = $this->users->unique();
            $this->listUsers = User::whereIn('id', $this->users)->get();
            $this->dispatch('clearSearchUser');
        }
    }

    public function deleteUser($index)
    {
        $this->users = $this->users->forget($index)->values();
        $this->listUsers = User::whereIn('id', $this->users)->get();
    }
}
