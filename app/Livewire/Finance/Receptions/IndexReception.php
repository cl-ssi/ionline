<?php

namespace App\Livewire\Finance\Receptions;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use App\Traits\NumerateTrait;
use App\Models\Finance\Receptions\Reception;
use App\Models\Finance\Receptions\ReceptionType;

class IndexReception extends Component
{
    use WithPagination;
    use NumerateTrait;

    protected $paginationTheme = 'bootstrap';

    public $filter_id;
    public $filter_purchase_order;
    public $filter_reception_type_id;
    public $filter_date;
    public $filter_number;
    public $filter_pending;
    public $filter_responsable; // Agregar filtro por nombre del responsable
    public $types;
    public $error_msg;
    public $mercado_publico;


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
                'noOcFile',
                'dte',
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
            // ->whereHas('numeration', function($query) {
            //     $query->where('number', $this->filter_number);
            // })
            ->when($this->filter_date, function($query) {
                $query->where('date', $this->filter_date);
            })
            ->when($this->filter_responsable, function($query) {
                $query->whereHas('responsable', function($subQuery) {
                    $subQuery->where('full_name', 'like', '%' . $this->filter_responsable . '%');
                });
            })
            ->when($this->filter_pending, function($query) {
                switch($this->filter_pending) {
                    case 'with_number': $query->whereRelation('numeration','number','!=',null); break;
                    case 'without_number': $query->whereRelation('numeration','number','=',null); break;
                    case 'pending': $query->doesntHave('numeration'); break;
                    default: break;
                }
            })
            ->latest()
            ->paginate(100);
        return $receptions;
    }

    public function toggleMercadoPublico($receptionId)
    {
        $reception = Reception::find($receptionId);
        $reception->mercado_publico = !$reception->mercado_publico;
        $reception->save();
    }

}
