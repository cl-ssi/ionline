<?php

namespace App\Http\Controllers\warehouse;

use App\Http\Controllers\Controller;
use App\Models\Warehouse\Family;
use App\Models\Warehouse\Segment;
use Illuminate\Http\Request;

class FamilyController extends Controller
{
    public function index(Segment $segment)
    {
        return view('warehouse.families.index', compact('segment'));
    }

    public function edit(Segment $segment, Family $family)
    {
        return view('warehouse.families.edit', compact('segment', 'family'));
    }
}
