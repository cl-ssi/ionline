<?php

namespace App\Livewire\Inventory;

use App\Models\Establishment;
use App\Models\Inv\EstablishmentUser;
use App\Models\User;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Role;

class InventoryManageUsers extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $establishment;
    public $search_user;
    public $user_id;
    public $role_id;
    public $roles;

    public $rules = [
        'role_id' => 'required|exists:roles,id',
        'user_id' => 'required|exists:users,id'
    ];

    public function mount(Establishment $establishment)
    {
        $this->roles = Role::whereIn('id', [21, 22])->get();
    }

    public function render()
    {
        return view('livewire.inventory.inventory-manage-users',[
            'users' => $this->getUsers()
        ]);
    }

    //$userId has to be value
    #[On('myUserId')]
    public function myUserId($value)
    {
        $this->user_id = $value;
    }

    public function addUser()
    {
        $dataValidated = $this->validate();
        $dataValidated['establishment_id'] = $this->establishment->id;

        EstablishmentUser::create($dataValidated);

        $this->establishment->refresh();

        $this->dispatch('idsExceptUsers', idsExceptUsers: $this->establishment->usersInventories->pluck('id'))->to('users.search-user');
        $this->dispatch('clearSearchUser');
        $this->role_id = null;
    }

    public function getUsers()
    {
        $users = EstablishmentUser::query()
            ->whereEstablishmentId($this->establishment->id)
            ->whereHas('user', function ($query) {
                $query->when($this->search_user, function ($query) {
                    $query->findByUser($this->search_user);
                });
            })
            ->orderBy('created_at', 'desc');

        $users = $users->paginate(10);

        return $users;
    }

    public function clearSearchUser()
    {
        $this->search_user = null;
        $this->render();
    }

    public function deleteUser(User $user)
    {
        $this->establishment->usersInventories()->detach($user->id);
        $this->establishment->refresh();
        $this->dispatch('idsExceptUsers', idsExceptUsers: $this->establishment->usersInventories->pluck('id'))->to('users.search-user');
    }
}
