<?php

namespace App\Livewire\Unspsc\Segment;

use App\Models\Unspsc\Segment;
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
        return view('livewire.unspsc.segment.segment-index', ['segments' => $this->getSegments()]);
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
