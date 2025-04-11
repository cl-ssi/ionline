<?php

namespace App\Livewire\Pharmacies;

use Livewire\Component;
use App\Models\Pharmacies\Patient;

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

    public $originEstablishmentName = ''; // Add this property for the establishment name
    public $originEstablishmentId = null; // Add this property for the establishment ID

    public $date; // Add this property to accept the date parameter

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
        $this->originEstablishmentName = ''; // Reset establishment name
        $this->originEstablishmentId = null; // Reset establishment ID
    }

    public function mount($date = null)
    {
        $this->date = $date; // Initialize the date if provided
        if($this->user) {
            $this->setUser($this->user);
        }
    }

    public function setUser(Patient $user)
    {
        $this->resetx();
        $this->user = $user;
        $this->selectedName = $user->full_name;
        $this->originEstablishmentName = $user->establishment->name ?? 'Establecimiento no disponible'; // Set establishment name
        $this->originEstablishmentId = $user->establishment->id ?? null; // Set establishment ID
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
        $this->users = Patient::getUsersBySearch($this->query)
            // ->whereNotIn('organizational_unit_id', $this->restrict)
            ->orderBy('full_name','Asc')
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

    public function addSearchedUser(Patient $user){
        $this->searchedUser= $user;
        $this->dispatch($this->emit_name ?? 'searchedUser', user: $this->searchedUser);
    }

    public function render()
    {
        return view('livewire.pharmacies.search-select-user');
    }
}
