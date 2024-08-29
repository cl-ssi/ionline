<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Rrhh\OrganizationalUnit;

class SearchSelectOrganizationalUnit extends Component
{
    /** Uso:
     * @livewire('search-select-organizational-unit')
     *
     * Se puede definir el nombre del campo que almacenará el id de la unidad organizacional
     * @livewire('search-select-organizational-unit', ['selected_id' => 'ou_id'])
     * 
     * Se puede definir el nombre del listener del metodo
     * @livewire('search-select-organizational-unit', ['emit_name' => 'searchedAdminOu'])
     *
     * Si necesitas que aparezca precargada la unidad organizacional
     * @livewire('search-select-organizational-unit', ['organizational_unit' => $organizationalUnit])
     *
     * Si necesitas que el campo sea requerido
     * @livewire('search-select-organizational-unit', ['required' => 'required'])
     * 
     * Si necesitas definir el tamaño del campo form-control-sm
     * @livewire('search-select-organizational-unit', ['small_option' => true])
     */

    public $query;
    public $organizationalUnits;

    /* PARA PRECARGAR */
    public $organizationalUnit;
    public $selectedOuName;
    public $selected_id = 'ou_id';
    public $required = '';
    public $small_option = false;
    public $msg_too_many;

    public $emit_name;

    public function setOrganizationalUnit(OrganizationalUnit $organizationalUnit)
    {
        $this->query = '';
        $this->organizationalUnits = [];
        $this->organizationalUnit = null;
        $this->selectedOuName = null;
        
        $this->organizationalUnit = $organizationalUnit;
        $this->selectedOuName = $organizationalUnit->name;
    }

    public function resetx()
    {
        $this->query = '';
        $this->organizationalUnits = [];
        $this->organizationalUnit = null;
        $this->selectedOuName = null;
        if($this->emit_name == 'searchedRequesterOu'){
            $this->dispatch('clearRequesterOu');
        }
        if($this->emit_name == 'searchedAdminOu'){
            $this->dispatch('clearAdminOu');
        }
        if($this->emit_name == 'searchedResponsibleOu'){
            $this->dispatch('clearResponsibleOu');
        }
    }

    public function addSearchedOrganizationalUnit($organizationalUnitId){
        $this->searchedOrganizationalUnit = $organizationalUnitId;
        $this->dispatch($this->emit_name ?? 'searchedOrganizationalUnit', organizationalUnit: $this->searchedOrganizationalUnit);
    }

    public function mount()
    {   
        if($this->organizationalUnit) {
            $this->setOrganizationalUnit($this->organizationalUnit);
        }
    }

    public function updatedQuery()
    {
        $this->organizationalUnits = OrganizationalUnit::getOrganizationalUnitsBySearch($this->query)
            ->orderBy('name','Asc')
            ->get();

        /** Más de 50 resultados  */
        if(count($this->organizationalUnits) >= 25)
        {
            $this->organizationalUnits = [];
            $this->msg_too_many = true;
        }
        else {
            $this->msg_too_many = false;
        }
    }

    public function render()
    {
        return view('livewire.search-select-organizational-unit');
    }
}
