<?php

namespace App\Http\Livewire\Warehouse\Invoices;

use App\Models\Warehouse\Control;
use Livewire\Component;

class ListInvoices extends Component
{
    public $control;

    public function mount(Control $control)
    {
        $this->control = $control;
    }

    public function render()
    {
        return view('livewire.warehouse.invoices.list-invoices');
    }
}
