<?php

namespace App\Livewire\Warehouse\Invoices;

use Livewire\Component;
use App\Models\Inv\Inventory;

class ListInvoices extends Component
{
    public Inventory $inventory;

    public function render()
    {
        return view('livewire.warehouse.invoices.list-invoices');
    }
}
