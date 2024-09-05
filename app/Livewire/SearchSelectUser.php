<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;

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
     * Si necesitas sea requerido
     * @livewire('search-select-user', ['required' => 'required'])
     * 
     * Si necesitas obtener el usuario seleccionado en otro componente livewire, debes indicar el nombre del listener
     * @livewire('search-select-user', ['emit_name' => 'Nombre del listener'])
     * 
     * Si necesitas restringir usuarios por U.O., deber usar un array precargado en el mount de tu componente
     * @livewire('search-select-user', ['restrict' => $restrict])
     * 
     * #[On('userSelected')]
     * public function userSelected($userId) {
     *    ...
     * }
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
    public $disabled;

    public $selectedUsers = [];

    public $restrict = [];

    protected function rules(){
        return [
            'query'  => 'required',
        ];
    }
    
    protected function messages(){ 
        return [
            'query.required' => 'Favor completar este campo.',
        ];
    }

    // public function updatedSelectedName($selectedName)
    // {
    //     $this->validateOnly($selectedName);
    // }

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
        $this->dispatch('userSelected', user: $user);
    }

    public function addUser()
    {
        /** Emite a cualquier otro componente que user_id seleccionó */
        $this->selectedUsers[] = $this->user;
        $this->dispatch('addUser', user: $this->user);
        $this->resetx();
    }

    public function updatedQuery()
    {
        $this->users = User::getUsersBySearch($this->query)
            ->whereNotIn('organizational_unit_id', $this->restrict)
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

    public function addSearchedUser(User $user){
        $this->searchedUser= $user;
        $this->dispatch($this->emit_name ?? 'searchedUser', user: $this->searchedUser);
    }

    public function render()
    {
        return view('livewire.search-select-user');
    }
}
