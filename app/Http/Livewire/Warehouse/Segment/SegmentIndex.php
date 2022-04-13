<?php

namespace App\Http\Livewire\Warehouse\Segment;

use App\Models\Warehouse\Segment;
use Livewire\Component;
use Livewire\WithPagination;

class SegmentIndex extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $search;
    public $experiesAt;

    public function render()
    {
        return view('livewire.warehouse.segment.segment-index', ['segments' => $this->getSegments()]);
    }

    public function getSegments()
    {
        $search = "%$this->search%";
        return Segment::query()
            ->when($this->search, function ($query) use ($search) {
                $query->where('name', 'like', $search);
            })
            ->paginate(10);
    }
}
