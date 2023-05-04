<?php

namespace App\Http\Livewire\Finance;

use Livewire\WithPagination;
use Livewire\Component;
use App\Models\Finance\Dte;

class IndexDtes extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $filter;

    /**
    * query
    */
    public function query()
    {
        return Dte::search($this->filter)->paginate(100);
    }

    public function render()
    {
        return view('livewire.finance.index-dtes', [
            'dtes' => $this->query()
        ]);
    }
}
