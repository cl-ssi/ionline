<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\User;

class SearchSelectUser extends Component
{
    /** Uso:
     * @livewire('search-select-user')
     *
     * Se puede definir el nombre del campo que almacenará el id de usuario
     * @livewire('search-select-user', ['selected_id' => 'user_id'])
     *
     * Si necesitas que aparezca precargado el usuario
     * @livewire('search-select-user', ['user' => $user])
     *
     *  Si necesitas sea requerido
     * @livewire('search-select-user', ['required' => 'required'])
     */
    public $query;
    public $users;
    /** Para cuando viene precargado */
    public $user;
    public $selectedName;
    public $selected_id = 'user_id';
    public $msg_too_many;
    public $required = '';
    
    public $emit_name;
    public $small_option = false;
    public $addUsers = false;

    public $selectedUsers = [];

    public function resetx()
    {
        $this->query = '';
        $this->users = [];
        $this->user = null;
        $this->selectedName = null;
    }

    public function mount()
    {
        if($this->user) {
            $this->setUser($this->user);
        }
    }

    public function setUser(User $user)
    {
        $this->resetx();
        $this->user = $user;
        $this->selectedName = $user->fullName;
        /** Emite a cualquier otro componente que user_id seleccionó */
        $this->emit('userSelected',$user->id);
    }

    public function addUser()
    {
        /** Emite a cualquier otro componente que user_id seleccionó */
        $this->selectedUsers[] = $this->user;
        $this->emit('addUser',$this->user);
        $this->resetx();
    }

    public function updatedQuery()
    {
        $this->users = User::getUsersBySearch($this->query)
            ->orderBy('name','Asc')
            ->get();

        /** Más de 50 resultados  */
        if(count($this->users) >= 25)
        {
            $this->users = [];
            $this->msg_too_many = true;
        }
        else {
            $this->msg_too_many = false;
        }
    }

    public function addSearchedUser($userId){
        $this->searchedUser= $userId;
        $this->emit($this->emit_name ?? 'searchedUser', $this->searchedUser);
    }

    public function render()
    {
        return view('livewire.search-select-user');
    }
}
