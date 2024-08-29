<?php

namespace App\Livewire\Warehouse\Destinations;

use App\Models\Warehouse\Destination;
use Livewire\Component;
use Livewire\WithPagination;

class DestinationIndex extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $store;
    public $search;
    public $nav;

    public function render()
    {
        return view('livewire.warehouse.destinations.destination-index', [
            'destinations' => $this->getDestinations()
        ]);
    }

    public function getDestinations()
    {
        $search = "%$this->search%";
        $destinations = Destination::query()
            ->when($this->search, function($query) use($search) {
                $query->where('name', 'like', $search);
            })
            ->whereStoreId($this->store->id)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return $destinations;
    }

    public function deleteDestination(Destination $destination)
    {
        $destination->delete();
        $this->render();
    }
}
