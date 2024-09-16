<?php

namespace App\Http\Controllers\Documents;

use App\Http\Controllers\Controller;
use App\Models\Documents\Manual;
use Barryvdh\DomPDF\Facade\Pdf;

class ManualController extends Controller
{
    public function show(Manual $manual)
    {
        return Pdf::loadView('documents.manuals.show', [
            'record'        => $manual,
            'establishment' => auth()->user()->establishment,
        ])->stream('download.pdf');
    }
}
