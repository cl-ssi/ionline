<?php

namespace App\Http\Livewire\Warehouse\Control;

use App\Models\Warehouse\Control;
use App\Models\Warehouse\ControlItem;
use App\Models\Pharmacies\Program;
use Livewire\Component;

class ControlReport extends Component
{
    public $store;
    public $programs;
    public $products;
    public $search;
    public $product_id;
    public $program_id;
    public $start_date;
    public $end_date;

    protected $listeners = [
        'myProductId'
    ];

    public function mount()
    {
        $idsPrograms = Control::query()
            ->where('wre_controls.store_id', $this->store->id)
            ->select([
                'wre_control_items.program_id',
            ])
            ->join('wre_control_items', 'wre_controls.id', '=', 'wre_control_items.control_id')
            ->groupBy('wre_control_items.program_id')
            ->pluck('wre_control_items.program_id');

        $this->programs = Program::findMany($idsPrograms);

        $this->start_date = now()->startOfMonth()->format('Y-m-d');
        $this->end_date = now()->endOfMonth()->format('Y-m-d');
    }

    public function render()
    {
        return view('livewire.warehouse.control.control-report',[
            'controlItems' => $this->getControlItems()
        ]);
    }

    public function getControlItems()
    {
        $controlItems = ControlItem::query()
            ->whereHas('control', function($query) {
                $query->whereStoreId($this->store->id)
                    ->whereConfirm(true);
            })
            ->when($this->start_date, function($query) {
                $query->whereDate('created_at', '>=', $this->start_date);
            })
            ->when($this->end_date, function($query) {
                $query->whereDate('created_at', '<=', $this->end_date);
            })
            ->when($this->program_id, function($query) {
                $query->when($this->program_id == -1, function($subquery) {
                    $subquery->where('program_id', '=', null);
                }, function ($subquery) {
                    $subquery->where('program_id', '=', $this->program_id);
                });
            })
            ->when($this->product_id, function($query) {
                $query->where('product_id', $this->product_id);
            })
            ->whereConfirm(true)
            ->orderBy('created_at', 'desc')
            ->get();

        return $controlItems;
    }
}
