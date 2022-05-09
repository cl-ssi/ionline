<?php

namespace App\Http\Livewire\Warehouse\Control;

use App\Models\Warehouse\ControlItem;
use App\Models\Warehouse\Product;
use Livewire\Component;

class ControlProductList extends Component
{
    public $control;
    public $controlItems;

    protected $listeners = [
        'refreshControlProductList' => 'mount'
    ];

    public function mount()
    {
        $this->controlItems = $this->control->items->sortByDesc('created_at');
    }

    public function deleteItem(ControlItem $controlItem)
    {
        $currentBalance = Product::lastBalance($controlItem->product, $controlItem->program);
        $amountToRemove = $controlItem->quantity;

        if(($controlItem->control->isReceiving() && ($currentBalance >= $controlItem->balance))
            OR $controlItem->control->isDispatch())
        {
            $controlItems = ControlItem::query()
                ->whereProgramId($controlItem->program_id)
                ->whereProductId($controlItem->product_id)
                ->where('id', '>', $controlItem->id)
                ->get();

            foreach($controlItems as $ci)
            {
                if($controlItem->control->isReceiving())
                    $newBalance = $ci->balance - $amountToRemove;
                else
                    $newBalance = $ci->balance + $amountToRemove;

                $ci->update([
                    'balance' => $newBalance
                ]);
            }

            $controlItem->delete();
        }

        $this->control->refresh();
        $this->mount();
    }

    public function render()
    {
        return view('livewire.warehouse.control.control-product-list');
    }
}
