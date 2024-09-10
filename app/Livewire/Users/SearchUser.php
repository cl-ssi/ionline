<?php

namespace App\Livewire\Users;

use App\Models\User;
use Livewire\Component;
use Livewire\Attributes\On;

class SearchUser extends Component
{
    public $users;
    public $user_id;
    public $search;
    public $tagId; //ya no se usa
    public $showResult;
    public $eventName;
    public $smallInput = false;
    public $placeholder;
    public $idsExceptUsers = [];
    public $bt = '5';

    public function mount()
    {
        $this->users = collect([]);
    }

    #[On('render')]
    public function render()
    {
        return view('livewire.users.search-user');
    }

    public function updatedSearch()
    {
        $this->showResult = true;
        $this->users      = collect([]);

        if ( $this->search ) {
            $this->users = User::query()
                ->withTrashed()
                ->whereNotIn('id', $this->idsExceptUsers)
                ->when($this->search, function ($query) {
                    $query->findByUser($this->search);
                })
                ->limit(5)
                ->get();
        }
    }

    public function handleSearchedUser($userId)
    {
        $user = User::withTrashed()->find($userId);

        if ( $user ) {
            $this->addSearchedUser($user);
        }
    }

    public function addSearchedUser(User $user)
    {
        $this->showResult = false;
        $this->search     = $user->full_name;
        $this->user_id    = $user->id;
        $this->users      = collect([]);

        $this->dispatch($this->eventName, value: $this->user_id);
    }

    #[On('clearSearchUser')]
    public function clearSearch($emitEvent = true)
    {
        if ( $emitEvent )
            $this->dispatch($this->eventName, value: null);

        $this->showResult = false;
        $this->users      = collect([]);
        $this->user_id    = null;
        $this->search     = null;
    }

    #[On('userId')]
    public function userId($user_id)
    {
        $this->user_id = $user_id;
    }

    #[On('idsExceptUsers')]
    public function idsExceptUsers($idsExceptUsers)
    {
        $this->idsExceptUsers = $idsExceptUsers;
    }
}
