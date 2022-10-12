<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Inv\Inventory;
// use Livewire\WithPagination;

class TicResources extends Component
{
	//use WithPagination;
	protected $paginationTheme = 'bootstrap';
	public $inventories;

	/**
	* Mount
	*/
	public function mount()
	{
		$this->inventories = Inventory::query()
			->whereRelation('unspscProduct', 'code', '>=', '43000000')
			->whereRelation('unspscProduct', 'code', '<=', '44000000')
            ->doesntHave('computer')
			->get();
	}

    public function render()
    {
        return view('livewire.tic-resources')->extends('layouts.app');
    }
}
