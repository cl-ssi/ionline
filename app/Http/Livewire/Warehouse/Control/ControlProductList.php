<?php

namespace App\Http\Livewire\Warehouse\Control;

use App\Models\Warehouse\ControlItem;
use Livewire\Component;

class ControlProductList extends Component
{
    public $control;
    public $controlItems;

    protected $listeners = [
        'refreshControlProductList' => 'mount'
    ];

    public function mount()
    {
        $this->controlItems = $this->control->items->sortByDesc('created_at');
    }

    public function deleteItem(ControlItem $item)
    {
        $item->delete();
        $this->control->refresh();
    }

    public function render()
    {
        return view('livewire.warehouse.control.control-product-list');
    }
}
