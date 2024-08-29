<?php

namespace App\Livewire\Warehouse\Stores;

use App\Models\Warehouse\StoreUser;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Role;

class ManageStoreUsers extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $store;
    public $users;
    public $roles;
    public $user_id;
    public $role_id;
    public $search;
    public $search_user;
    public $selectedName;
    public $totalStoreUser;

    public $rules = [
        'user_id' => 'required|exists:users,id',
        'role_id' => 'required|exists:roles,id',
    ];

    public function mount()
    {
        $this->totalStoreUser = $this->store->users->count();
        $this->users = collect([]);
        $this->roles = Role::whereIn('id', [18, 19])->get();
    }

    public function render()
    {
        return view('livewire.warehouse.stores.manage-store-users', [
            'addedUsers' => $this->getAddedUsers()
        ]);
    }

    public function updatedSearch()
    {
        $users = collect([]);

        if($this->search)
        {
            $users = User::query()
                ->whereNotIn('id', $this->store->users()->pluck('user_id')->toArray())
                ->when($this->search, function ($query) {
                    $query->findByUser($this->search);
                })
                ->limit(5)
                ->get();
        }

        $this->users = $users;
    }

    public function getAddedUsers()
    {
        $users = StoreUser::query()
            ->where('store_id', $this->store->id)
            ->whereHas('user', function ($query) {
                $query->when($this->search_user, function ($subquery) {
                    $subquery->findByUser($this->search_user);
                });
            })
            ->orderBy('created_at', 'desc');

        $this->totalStoreUser = $users->count();
        $users = $users->paginate(10);

        return $users;
    }

    public function addSearchedUser(User $user)
    {
        $this->selectedName = $user->full_name;
        $this->user_id = $user->id;
        $this->search = null;
        $this->users = collect([]);
    }

    public function addUser()
    {
        $this->validate();


        $this->store->users()->attach($this->user_id, [
            'role_id' => $this->role_id,
            'status' => false,
        ]);

        $this->store->refresh();
        $this->resetInput();
        $this->updatedSearch();
        $this->render();
    }

    public function deleteUser(User $user)
    {
        $this->store->users()->detach($user->id);
        $this->store->refresh();
    }

    public function resetInput()
    {
        $this->selectedName = null;
        $this->search = null;
        $this->role_id = null;
        $this->user_id = null;
    }

    public function clearSearch()
    {
        $this->users = collect([]);
        $this->user_id = null;
        $this->selectedName = null;
        $this->search = null;
    }

    public function clearSearchUser()
    {
        $this->search_user = null;
        $this->render();
    }
}
