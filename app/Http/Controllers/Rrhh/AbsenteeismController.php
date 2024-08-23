<?php

namespace App\Http\Controllers\Rrhh;

use App\Http\Controllers\Controller;
use App\Models\Rrhh\Absenteeism;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class AbsenteeismController extends Controller
{
    public function show(Absenteeism $absenteeism)
    {
        return Pdf::loadView('rrhh.absenteeisms.show', [
            'record' => $absenteeism,
            'establishment' => $absenteeism->user->establishment,
            'approval' => $absenteeism->approval,
        ])->stream('download.pdf');
    }
}
