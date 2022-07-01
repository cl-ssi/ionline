<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    public function index()
    {
        return view('inventory.index');
    }

    public function details()
    {
        return view('inventory.details');
    }

    public function last_income()
    {
        return view('inventory.last_income');
    }

    public function pending_inventory()
    {
        return view('inventory.pending_inventory');

    }
}
