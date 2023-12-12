<?php

namespace App\Http\Livewire\Finance\Receptions;

use Livewire\WithPagination;
use Livewire\Component;
use App\Models\Finance\Receptions\ReceptionType;
use App\Models\Finance\Receptions\Reception;

class IndexReception extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    
    
    public $filter_id;
    public $filter_purchase_order;
    public $filter_reception_type_id;
    public $filter_date;
    public $filter_number;
    public $types;

    /**
    * Mount
    */
    public function mount()
    {
        $this->types = ReceptionType::where('establishment_id',auth()->user()->organizationalUnit->establishment_id)
            ->pluck('name','id')->toArray();
    }

    public function render()
    {
        return view('livewire.finance.receptions.index-reception', [
            'receptions' => $this->getReceptions()
        ]);
    }

    public function getReceptions()
    {
        
        $receptions = Reception::query()
            ->with([
                'items',
                'purchaseOrder',
                'responsable',
                'approvals',
                'approvals.approver',
                'approvals.sentToOu',
                'approvals.sentToOu.currentManager',
                'approvals.sentToOu.currentManager.user',
                'approvals.sentToUser',
                'numeration',
                'files',
                'supportFile',
                'signedFileLegacy',
            ])
            //->where('creator_id', auth()->id())
            ->where('establishment_id', auth()->user()->organizationalUnit->establishment_id)
            ->orderByDesc('id')
            ->when($this->filter_id, function($query) {
                $query->where('id', $this->filter_id);
            })
            ->when($this->filter_purchase_order, function($query) {
                $query->where('purchase_order', $this->filter_purchase_order);
            })
            ->when($this->filter_reception_type_id, function($query) {
                $query->where('reception_type_id', $this->filter_reception_type_id);
            })
            ->when($this->filter_number, function($query) { 
                $query->where('number', $this->filter_number);
            })
            ->when($this->filter_date, function($query) {
                $query->where('date', $this->filter_date);
            })
            ->latest()
            ->paginate(100);
        return $receptions;
    }
    
}
