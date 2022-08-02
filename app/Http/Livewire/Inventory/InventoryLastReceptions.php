<?php

namespace App\Http\Livewire\Inventory;

use App\Models\Inv\Inventory;
use App\Models\Warehouse\ControlItem;
use Livewire\Component;
use Livewire\WithPagination;

class InventoryLastReceptions extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public function render()
    {
        return view('livewire.inventory.inventory-last-receptions', [
            'controlItems' => $this->getControlItems(),
        ])->extends('layouts.app');
    }

    public function getControlItems()
    {
        $controlItems = ControlItem::query()
            ->whereHas('control', function($query) {
                $query->whereType(1) // Receptions
                    ->whereNotNull('po_id')->orWhere('type_reception_id', 1); // PurchaseOrder or Donations
            })
            ->whereInventory(null)
            ->orderByDesc('created_at')
            ->paginate(5);

        return $controlItems;
    }

    public function createInventory(ControlItem $controlItem)
    {
        $controlItem->update([
            'inventory' => true
        ]);

        for($i = 1; $i <= $controlItem->quantity; $i++)
        {
            Inventory::create([
                'po_price' => $controlItem->unit_price,
                'po_code' => $controlItem->control->po_code,
                'po_date' => $controlItem->control->po_date,
                'product_id' => $controlItem->product_id,
                'control_id' => $controlItem->control_id,
                'store_id' => $controlItem->control->store_id,
                'po_id' => $controlItem->control->po_id,
                'request_form_id' => $controlItem->control->request_form_id,
                'request_user_ou_id' => optional($controlItem->control->requestForm)->request_user_ou_id,
                'request_user_id' => optional($controlItem->control->requestForm)->request_user_id,
            ]);
        }
    }

    public function discardInventory(ControlItem $controlItem)
    {
        $controlItem->update([
            'inventory' => false
        ]);
    }
}
