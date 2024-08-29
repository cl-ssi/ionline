<?php

namespace App\Livewire\Warehouse\Control;

use App\Models\Warehouse\Control;
use Livewire\Component;
use Livewire\WithPagination;

class ControlDispatch extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $store;
    public $type;
    public $nav;

    public function render()
    {
        return view('livewire.warehouse.control.control-dispatch', [
            'controls' => $this->getControls()
        ]);
    }

    public function getControls()
    {
        $controls = Control::query()
            ->whereStoreId($this->store->id)
            ->whereType(0)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return $controls;
    }
}
