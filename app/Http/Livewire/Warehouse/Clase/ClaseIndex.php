<?php

namespace App\Http\Livewire\Warehouse\Clase;

use App\Models\Warehouse\Clase;
use Livewire\Component;
use Livewire\WithPagination;

class ClaseIndex extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $segment;
    public $family;
    public $search;
    public $experiesAt;

    public function render()
    {
        return view('livewire.warehouse.class.class-index', ['classes' => $this->getClasses()]);
    }

    public function getClasses()
    {
        $search = "%$this->search%";
        return Clase::query()
            ->whereFamilyId($this->family->id)
            ->when($this->search, function ($query) use ($search) {
                $query->where('name', 'like', $search);
            })
            ->paginate(10);
    }


}
