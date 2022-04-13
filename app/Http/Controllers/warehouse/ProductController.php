<?php

namespace App\Http\Controllers\warehouse;

use App\Http\Controllers\Controller;
use App\Models\Warehouse\Clase;
use App\Models\Warehouse\Family;
use App\Models\Warehouse\Product;
use App\Models\Warehouse\Segment;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Segment $segment, Family $family, Clase $class)
    {
        return view('warehouse.products.index', compact('segment', 'family', 'class'));
    }

    public function edit(Segment $segment, Family $family, Clase $class, Product $product)
    {
        return view('warehouse.products.edit', compact('segment', 'family', 'class', 'product'));
    }

    public function all()
    {
        return view('warehouse.products.all');
    }
}
