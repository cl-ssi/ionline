<?php

namespace App\Observers;

use App\Models\Inv\InventoryLabel;
use Illuminate\Support\Str;

class InventoryLabelObserver
{
    /**
     * Handle the InventoryLabel "creating" event.
     *
     * @param  \App\Models\Inv\InventoryLabel  $inventoryLabel
     * @return void
     */
    public function creating(InventoryLabel $inventoryLabel)
    {
        $inventoryLabel->name = Str::lower($inventoryLabel->name);
    }

    /**
     * Handle the InventoryLabel "updating" event.
     *
     * @param  \App\Models\Inv\InventoryLabel  $inventoryLabel
     * @return void
     */
    public function updating(InventoryLabel $inventoryLabel)
    {
        $inventoryLabel->name = Str::lower($inventoryLabel->name);
    }
}
