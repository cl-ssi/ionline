<?php

namespace App\Livewire\Inventory;

use Livewire\Component;
use App\Models\Inv\Inventory;
use App\Models\Establishment;

class PrintCodeQueue extends Component
{
    public Establishment $establishment;

    /**
    * togglePrinted
    */
    public function togglePrinted()
    {
        Inventory::whereNull('printed')
            ->where('establishment_id', $this->establishment->id)
            ->update([
                'printed' => true
            ]);
    }

    public function render()
    {
        $inventories = Inventory::whereNull('printed')
            ->where('establishment_id', $this->establishment->id)
            ->get();

        return view('livewire.inventory.print-code-queue',[
            'inventories' => $inventories
        ])->extends('layouts.blank');
    }
}
