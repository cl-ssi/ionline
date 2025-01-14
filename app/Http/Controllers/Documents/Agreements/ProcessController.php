<?php

namespace App\Http\Controllers\Documents\Agreements;

use App\Http\Controllers\Controller;
use App\Models\Documents\Agreements\Process;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class ProcessController extends Controller
{
    public function view(int $record)
    {
        $process = Process::findOrFail($record);

        return Pdf::loadView('documents.agreements.processes.view', [
            'record' => $process
        ])->stream();
    }
}
