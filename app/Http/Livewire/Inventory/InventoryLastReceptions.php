<?php

namespace App\Http\Livewire\Inventory;

use App\Models\Establishment;
use App\Models\Inv\Inventory;
use App\Models\RequestForms\RequestForm;
use App\Models\Unspsc\Product as UnspscProduct;
use App\Models\Warehouse\ControlItem;
use App\Models\Warehouse\TypeReception;
use Livewire\Component;
use Livewire\WithPagination;

class InventoryLastReceptions extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $establishment;
    public $search;
    public $type_reception_id;

    public function mount(Establishment $establishment)
    {
        //
    }

    public function render()
    {
        return view('livewire.inventory.inventory-last-receptions', [
            'controlItems' => $this->getControlItems(),
        ])->extends('layouts.bt4.app');
    }

    public function getControlItems()
    {
        $search = "%$this->search%";

        $controlItems = ControlItem::query()
            ->when($this->search, function ($query) use($search) {
                $query->when($this->type_reception_id == TypeReception::receiving(), function ($query) use ($search) {
                    $query->whereHas('control', function ($query) use ($search) {
                        $query->whereHas('origin', function ($query) use ($search) {
                            $query->where('name', 'like', $search);
                        });
                    });
                })
                ->when($this->type_reception_id == TypeReception::purchaseOrder(), function ($query) use ($search) {
                    $query->whereHas('control', function($query) use($search) {
                        $query->where('po_code', 'like', $search);
                    });
                })
                ->orWhereHas('product', function ($query) use ($search) {
                    $query->where('name', 'like', $search)
                        ->orWhereHas('product', function ($query) use ($search) {
                            $query->where('name', 'like', $search);
                        });
                });
            })
            ->when($this->type_reception_id != '', function ($query) {
                $query->whereHas('control', function ($query) {
                    $query->whereTypeReceptionId($this->type_reception_id);
                });
            })
            ->whereHas('control', function($query) {
                $query->whereHas('store', function ($query) {
                    $query->whereEstablishmentId($this->establishment->id);
                })
                ->whereType(1) // Control Type: Receptions
                ->whereTypeReceptionId(TypeReception::receiving()) // By PurchaseOrder or Donations
                ->orWhere('type_reception_id', TypeReception::purchaseOrder());
            })
            ->whereInventory(null)
            ->orderByDesc('created_at')
            ->paginate(5);

        return $controlItems;
    }

    public function getBudgetItemId(RequestForm $requestForm = null, UnspscProduct $product)
    {
        $budget_item_id = null;
        if($requestForm && $requestForm->itemRequestForms->count() > 0)
        {
            $itemRequestForm = $requestForm->itemRequestForms->where('product_id', $product->id)->first();
            $budget_item_id = $itemRequestForm ? $itemRequestForm->budget_item_id : null;
        }
        return $budget_item_id;
    }

    public function createInventory(ControlItem $controlItem)
    {
        $controlItem->update([
            'inventory' => true
        ]);

        for($i = 1; $i <= $controlItem->quantity; $i++)
        {
            Inventory::create([
                'establishment_id' => $this->establishment->id,
                'po_price' => $controlItem->unit_price,
                'po_code' => $controlItem->control->po_code,
                'po_date' => $controlItem->control->po_date,
                'product_id' => $controlItem->product_id,
                'unspsc_product_id' => $controlItem->product->product->id,
                'control_id' => $controlItem->control_id,
                'store_id' => $controlItem->control->store_id,
                'po_id' => $controlItem->control->po_id,
                'request_form_id' => $controlItem->control->request_form_id,
                'request_user_ou_id' => optional($controlItem->control->requestForm)->request_user_ou_id,
                'request_user_id' => optional($controlItem->control->requestForm)->request_user_id,
                'budget_item_id' => $this->getBudgetItemId($controlItem->control->requestForm, $controlItem->product->product),
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
