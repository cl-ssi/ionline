<?php

/* Set active route */

use App\Models\Warehouse\ControlItem;
use App\Models\Warehouse\Product;
use App\Pharmacies\Program;

function active($route_name) {
    echo request()->routeIs($route_name) ? 'active' : '';
}

function money($value) {
    echo number_format($value,0,'','.');
}

function trashed($user) {
    if($user->trashed())
        echo '<i class="fas fa-user-slash" title="Usuario eliminado"></i>';
}

function lastBalance(Product $product, Program $program) {
    $controlItem = ControlItem::query()
        ->whereProductId($product->id)
        ->whereProgramId($program->id)
        ->latest()
        ->first();

    if($controlItem)
    {
        return $controlItem->balance;
    }

    return 0;
}

function productsOutStock(Program $program) {
    $productIds = collect([]);

    $controlItems = ControlItem::query()
        ->whereProgramId($program->id)
        ->groupBy('product_id')
        ->get();

    foreach($controlItems as $controlItem)
    {
        $lastBalance = lastBalance($controlItem->product, $controlItem->program);
        if($lastBalance == 0)
            $productIds->push($controlItem->product_id);
    }

    return $productIds;
}
