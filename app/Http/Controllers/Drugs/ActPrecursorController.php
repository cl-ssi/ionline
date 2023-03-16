<?php

namespace App\Http\Controllers\Drugs;

use App\Http\Controllers\Controller;
use App\Models\Drugs\ActPrecursor;

class ActPrecursorController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  ActPrecursor  $actPrecursor
     * @return \Illuminate\Http\Response
     */
    public function __invoke(ActPrecursor $actPrecursor)
    {
        return view('drugs.pdf.act-precursors', compact('actPrecursor'));
    }
}
