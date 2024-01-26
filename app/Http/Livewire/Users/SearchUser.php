<?php

namespace App\Http\Livewire\Users;

use App\User;
use Livewire\Component;

class SearchUser extends Component
{
    public $users;
    public $user_id;
    public $search;
    public $tagId;
    public $showResult;
    public $eventName;
    public $smallInput = false;
    public $placeholder;
    public $idsExceptUsers = [];
    public $bt = '5';

    protected $listeners = [
        'clearSearchUser' => 'clearSearch',
        'userId',
        'idsExceptUsers',
        'render'
    ];

    public function mount()
    {
        $this->users = collect([]);
    }

    public function render()
    {
        return view('livewire.users.search-user');
    }

    public function updatedSearch()
    {
        $this->showResult = true;
        $this->users = collect([]);

        if($this->search)
        {
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

        if ($user) {
            $this->addSearchedUser($user);
        }
}





    public function addSearchedUser(User $user)
    {        
        $this->showResult = false;
        $this->search = $user->full_name;
        $this->user_id = $user->id;
        $this->users = collect([]);

        $this->emit($this->eventName, $this->user_id);
    }

    public function clearSearch($emitEvent = true)
    {
        if($emitEvent)
            $this->emit($this->eventName, null);

        $this->showResult = false;
        $this->users = collect([]);
        $this->user_id = null;
        $this->search = null;
    }

    public function userId($user_id)
    {
        $this->user_id = $user_id;
    }

    public function idsExceptUsers($idsExceptUsers)
    {
        $this->idsExceptUsers = $idsExceptUsers;
    }
}
