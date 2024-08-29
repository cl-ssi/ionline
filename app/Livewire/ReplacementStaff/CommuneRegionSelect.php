<?php

namespace App\Livewire\ReplacementStaff;

use Livewire\Component;
use App\Models\ClRegion;
use App\Models\ClCommune;

class CommuneRegionSelect extends Component
{
    public $selectedRegion = null;
    public $selectedCommune = null;

    public $communes = null;

    public $replacementStaff;

    /* Para editar y precargar los select */
    public $regionSelected = null;
    public $communeSelected = null;

    public function mount(){
        if($this->replacementStaff) {
            $this->selectedRegion = $this->replacementStaff->region_id;
            $this->communes = ClCommune::where('region_id', $this->selectedRegion)->get();
            $this->selectedCommune = $this->replacementStaff->commune_id;
        }
    }

    public function render()
    {
        return view('livewire.replacement-staff.commune-region-select', [
            'regions' => ClRegion::all()
        ]);
    }

    public function updatedselectedRegion($region_id){
        $this->communes = ClCommune::where('region_id', $region_id)->OrderBy('name')->get();
    }
}
