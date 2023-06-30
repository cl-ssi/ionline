<?php

namespace App\Http\Livewire\Welfare\AmiPass;

use Livewire\Component;
use App\Models\Establishment;

class NewBeneficiaryRequest extends Component
{

    public $jefatura = '';
    public $correoElectronico = '';
    public $cargoUnidad = '';    
    public $selectedOption = '';
    public $establecimientos;
    public $selectedEstablishmentId = '';


    public function render()
    {

        if ($this->selectedOption === 'yo') {
            $this->jefatura = auth()->user()->full_name;
            $this->correoElectronico = auth()->user()->email;
            $this->cargoUnidad = auth()->user()->organizationalUnit->name;
            $this->selectedEstablishmentId = auth()->user()->organizationalUnit->establishment_id; // Actualiza el valor según los datos disponibles del usuario logeado
        } else {
            $this->resetFields();
        }
        return view('livewire.welfare.ami-pass.new-beneficiary-request');
    }

    public function mount()
    {
        $establishments_ids = explode(',', env('APP_SS_ESTABLISHMENTS'));
        $this->establecimientos = Establishment::whereIn('id', $establishments_ids)->orderBy('official_name')->get();
    }



    public function resetFields()
    {
        $this->jefatura = '';
        $this->correoElectronico = '';
        $this->cargoUnidad = '';
        $this->selectedEstablishmentId = '';
    }
}
