<?php

namespace App\Livewire\Unspsc\Clase;

use App\Models\Unspsc\Clase;
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
        return view('livewire.unspsc.class.class-index', ['classes' => $this->getClasses()]);
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
