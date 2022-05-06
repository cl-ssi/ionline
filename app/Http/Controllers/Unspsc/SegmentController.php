<?php

namespace App\Http\Controllers\Unspsc;

use App\Http\Controllers\Controller;
use App\Models\Unspsc\Segment;

class SegmentController extends Controller
{
    public function index()
    {
        return view('unspsc.segments.index');
    }

    public function edit(Segment $segment)
    {
        return view('unspsc.segments.edit', compact('segment'));
    }
}
