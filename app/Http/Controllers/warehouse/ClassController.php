<?php

namespace App\Http\Controllers\warehouse;

use App\Http\Controllers\Controller;
use App\Models\Warehouse\Clase;
use App\Models\Warehouse\Family;
use App\Models\Warehouse\Segment;
use Illuminate\Http\Request;

class ClassController extends Controller
{
    public function index(Segment $segment, Family $family)
    {
        return view('warehouse.class.index', compact('segment', 'family'));
    }

    public function edit(Segment $segment, Family $family, Clase $class)
    {
        return view('warehouse.class.edit', compact('segment', 'family', 'class'));
    }
}
