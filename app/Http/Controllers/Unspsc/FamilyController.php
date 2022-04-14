<?php

namespace App\Http\Controllers\Unspsc;

use App\Http\Controllers\Controller;
use App\Models\Unspsc\Family;
use App\Models\Unspsc\Segment;
use Illuminate\Http\Request;

class FamilyController extends Controller
{
    public function index(Segment $segment)
    {
        return view('unspsc.families.index', compact('segment'));
    }

    public function edit(Segment $segment, Family $family)
    {
        return view('unspsc.families.edit', compact('segment', 'family'));
    }
}
