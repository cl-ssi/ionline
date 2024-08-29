<?php

namespace App\Livewire\Parameters\Supplier;

use Livewire\Component;
use App\Models\Parameters\Supplier;
use Livewire\WithPagination;

class SearchSuppliers extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $selectedName = null;

    protected $queryString = ['selectedName'];

    public function render()
    {
        $suppliers = Supplier::with('region', 'commune')
            ->search($this->selectedName)     
            ->orderBy('name')
            ->paginate(50);

        return view('livewire.parameters.supplier.search-suppliers', compact('suppliers'));
    }

    public function updatingSelectedName(){
        $this->resetPage();
    }
}
