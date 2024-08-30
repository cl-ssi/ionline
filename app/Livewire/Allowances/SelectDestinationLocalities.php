<?php

namespace App\Livewire\Allowances;

use Livewire\Component;

use App\Models\ClCommune;
use App\Models\ClLocality;
use Livewire\Attributes\On;

class SelectDestinationLocalities extends Component
{
    /*
    public $inputs = [];
    public $i = 0;
    public $count = 0;
    */

    public $searchedCommune;

    public $selectedLocality, $selectedLocalityName, $description;

    public $localities;

    public $key, $destinations;

    /*
    public function add($i)
    {
        $i = $i + 1;
        $this->i = $i;
        array_push($this->inputs ,$i);
        $this->count++;
    }
    */

    public function mount()
    {
        $this->add($this->i);
    }

    public function render()
    {
        return view('livewire.allowances.select-destination-localities');
    }

    /*
    #[On('searchedCommune')] 
    public function searchedCommune(ClCommune $comuneId)
    {
        $this->searchedCommune = $comuneId;
        
        $this->localities = ClLocality::
            where('commune_id', $this->searchedCommune->id)
            ->get();
    }
    */

    /*

    public function addDestination()
    {
        $selectedLocalityName = ClLocality::find($this->selectedLocality)->name;

        $this->destinations[] = [
            'id'            => '',
            'commune_id'    => $this->searchedCommune->id,
            'commune_name'  => $this->searchedCommune->name,
            'locality_id'   => $this->selectedLocality,
            'locality_name' => $selectedLocalityName,
            'description'   => $this->description
        ];

        $this->cleanDestination();
        $this->dispatch('onClearUserSearch');
        $this->emitUp('savedDestinations', $this->destinations);
    }
    */

    /*
    public function cleanDestination()
    {
        $this->selectedLocality = null;
        $this->description = null;
    }

    public function deleteDestination($key)
    {
        // SOLO PARA EL ELIMINAR EN CREATE 
        unset($this->destinations[$key]);
        $this->emitUp('savedDestinations', $this->destinations);
    }
    */
}
