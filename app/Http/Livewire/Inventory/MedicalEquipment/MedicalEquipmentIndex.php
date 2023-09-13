<?php

namespace App\Http\Livewire\Inventory\MedicalEquipment;

use App\Models\Inv\MedicalEquipment;
use Livewire\Component;
use Livewire\WithPagination;

class MedicalEquipmentIndex extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $search;
    public $type_resource;

    public function render()
    {
        return view('livewire.inventory.medical-equipment.medical-equipment-index', [
            'medicalEquipment' => $this->getMedicalEquipment()
        ]);
    }

    public function getMedicalEquipment()
    {
        $medicalEquipment = MedicalEquipment::all()->toQuery()
            ->paginate(50);

        return $medicalEquipment;
    }
}
