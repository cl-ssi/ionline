<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\ClCommune;


class SearchSelectCommune extends Component
{
    /** Uso:
     * @livewire('search-select-commune')
     *
     * Se puede definir el nombre del campo que almacenará el id de la unidad organizacional
     * @livewire('search-select-commune', ['selected_id' => 'commune_id'])
     * 
     * Si necesitas que aparezca precargada la comuna
     * @livewire('search-select-commune', ['commune' => $commune])
     * 
     */

    public $query;
    public $communes;

    /* PARA PRECARGAR */
    public $commune;
    public $selectedCommuneName;
    public $selected_id = 'commune_id';
    public $msg_too_many;

    public $required = '';
    public $small_option = false;

    protected $listeners = ['onClearUserSearch'];
    
    public function updatedQuery()
    {
        $this->communes = ClCommune::getCommunesBySearch($this->query)
            ->orderBy('name','Asc')
            ->get();
 
        /** Más de 50 resultados  */
        if(count($this->communes) >= 25)
        {
            $this->communes = [];
            $this->msg_too_many = true;
        }
        else {
            $this->msg_too_many = false;
        }
    }

    public function mount()
    {
        if($this->commune) {
            $this->setCommune($this->commune);
        }
    }

    public function setCommune(ClCommune $commune)
    {
        $this->query = '';
        $this->communes = [];
        $this->commune = null;
        $this->selectedCommuneName = null;
        
        $this->commune = $commune;
        $this->selectedCommuneName = $commune->name;
        
        /* OJO: SE EMITE EL ID DEL CAMPO PARA EL CONTROL DE ESTE, EN CASO DE QUE EXISTAN DOS O MÁS COMPONENTES IGUALES (USAR ID DIFERENTES) 
            VIATICO: origin_commune_id
            VIATICO: destination_commune_id
        */

        $this->emit('searchedCommune', $this->commune->id);
        $this->emit('selectedInputId', $this->selected_id);
    }

    public function addSearchedCommune($communeId){
        $this->searchedCommune = $communeId;
        // $this->emit($this->emit_name ?? 'searchedOrganizationalUnit', $this->searchedOrganizationalUnit);
    }

    public function resetx()
    {
        $this->query = '';
        $this->communes = [];
        $this->commune = null;
        $this->selectedCommuneName = null;
    }

    public function onClearUserSearch(){
        if($this->selected_id == 'destination_commune_id'){
            $this->resetx();
        }
    }

    public function render()
    {
        return view('livewire.search-select-commune');
    }
}
