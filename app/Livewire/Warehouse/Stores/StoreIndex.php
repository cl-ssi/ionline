<?php

namespace App\Livewire\Warehouse\Stores;

use App\Models\Warehouse\Store;
use Livewire\Component;
use Livewire\WithPagination;

class StoreIndex extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $search = null;

    public function render()
    {
        return view('livewire.warehouse.stores.store-index', ['stores' => $this->getStores()]);
    }

    public function getStores()
    {
        $search = "%$this->search%";

        $stores = Store::query()
            ->when($this->search, function($query) use($search) {
                $query->where('name', 'like', $search)
                    ->orWhere('address', 'like', $search)
                    ->orWhereHas('commune', function ($query) use ($search) {
                        $query->where('name', 'like', $search);
                    });
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return $stores;
    }

    public function delete(Store $store)
    {
        $store->delete();
        $this->render();
    }
}
