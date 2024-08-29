<?php

namespace App\Livewire\Inventory;

use App\Http\Requests\Inventory\DischargeDateRequest;
use Livewire\Component;

class AddDischargeDate extends Component
{
    public $inventory;
    public $discharge_date;
    public $act_number;

    public function render()
    {
        return view('livewire.inventory.add-discharge-date');
    }

    public function rules()
    {
        return (new DischargeDateRequest())->rules();
    }

    public function save()
    {
        $dataValidated = $this->validate();
        $this->inventory->update($dataValidated);
        $this->resetInput();
        $this->dispatch('updateMovementIndex');
    }

    public function resetInput()
    {
        $this->discharge_date = null;
        $this->act_number = null;
    }
}
