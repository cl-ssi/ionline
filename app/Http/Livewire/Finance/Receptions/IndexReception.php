<?php

namespace App\Http\Livewire\Finance\Receptions;

use Livewire\Component;
use App\Models\Finance\Receptions\Reception;
use Livewire\WithPagination;

class IndexReception extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    
    
    public $filter_id;
    public $filter_purchase_order;
    public $filter_number;
    public $filter_user_responsible_id;
    public $filter_date;


    public function render()
    {
        return view('livewire.finance.receptions.index-reception', [
            'receptions' => $this->getReceptions()
        ]);
    }

    public function getReceptions()
    {
        
        $receptions = Reception::query()
            ->orderByDesc('id')
            ->when($this->filter_id, function($query) {
                $query->where('id', $this->filter_id);
            })
            ->when($this->filter_purchase_order, function($query) {
                $query->where('purchase_order', $this->filter_purchase_order);
            })
            ->when($this->filter_number, function($query) { 
                $query->where('number', $this->filter_number);
            })
            ->when($this->filter_user_responsible_id, function($query) {
                $query->where('user_responsible_id', $this->filter_user_responsible_id);
            })
            ->when($this->filter_date, function($query) {
                $query->where('date', $this->filter_date);
            })
            ->paginate(100);        
        return $receptions;
    }
    
}
