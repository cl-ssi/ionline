<?php

namespace App\Http\Controllers\Unspsc;

use App\Http\Controllers\Controller;
use App\Models\Unspsc\Clase;
use App\Models\Unspsc\Family;
use App\Models\Unspsc\Segment;

class ClassController extends Controller
{
    public function index(Segment $segment, Family $family)
    {
        return view('unspsc.class.index', compact('segment', 'family'));
    }

    public function edit(Segment $segment, Family $family, Clase $class)
    {
        return view('unspsc.class.edit', compact('segment', 'family', 'class'));
    }
}
