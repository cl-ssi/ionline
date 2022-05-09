<?php

namespace App\Http\Controllers\Unspsc;

use App\Http\Controllers\Controller;
use App\Models\Unspsc\Clase;
use App\Models\Unspsc\Family;
use App\Models\Unspsc\Product;
use App\Models\Unspsc\Segment;

class ProductController extends Controller
{
    public function index(Segment $segment, Family $family, Clase $class)
    {
        return view('unspsc.products.index', compact('segment', 'family', 'class'));
    }

    public function edit(Segment $segment, Family $family, Clase $class, Product $product)
    {
        return view('unspsc.products.edit', compact('segment', 'family', 'class', 'product'));
    }

    public function all()
    {
        return view('unspsc.products.all');
    }
}
