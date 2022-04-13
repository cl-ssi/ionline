<?php

namespace App\Http\Controllers\warehouse;

use App\Http\Controllers\Controller;
use App\Models\Warehouse\Segment;
use Illuminate\Http\Request;

class SegmentController extends Controller
{
    public function index()
    {
        return view('warehouse.segments.index');
    }

    public function edit(Segment $segment)
    {
        return view('warehouse.segments.edit', compact('segment'));
    }
}
