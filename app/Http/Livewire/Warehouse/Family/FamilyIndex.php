<?php

namespace App\Http\Livewire\Warehouse\Family;

use App\Models\Warehouse\Family;
use Livewire\Component;
use Livewire\WithPagination;

class FamilyIndex extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $segment;
    public $search;

    public function render()
    {
        return view('livewire.warehouse.family.family-index', ['families' => $this->getFamilies()]);
    }

    public function getFamilies()
    {
        $search = "%$this->search%";
        $families = Family::query()
            ->whereSegmentId($this->segment->id)
            ->when($this->search, function ($query) use ($search) {
                $query->where('name', 'like', $search);
            })
            ->paginate(10);
        return $families;
    }
}
