<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use App\Models\Finance\Dte;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DteController extends Controller
{
    /**
     * Callback after accepting a DTE
     *
     * @param  Dte $dte
     * @return void
     */
    public function store(Dte $dte, Request $request)
    {
        $dte->update([
            'confirmation_status' => 1,
            'confirmation_user_id' => auth()->id(),
            'confirmation_ou_id' => auth()->user()->organizational_unit_id,
            'confirmation_observation' => '',
            'confirmation_at' => now(),
            'confirmation_signature_file' => $request->folder . $request->filename . '.pdf',
        ]);

        return redirect()->back()->with('success', 'El dte fue aceptado exitosamente.');
    }

    public function pdf(Dte $dte)
    {
        return Storage::disk('gcs')->download($dte->confirmation_signature_file);
    }


    public function downloadManualDteFile(Dte $dte)
    {
        return Storage::disk('gcs')->download($dte->archivo_carga_manual);
    }

    public function saveFile(Request $request, $dte)
    {
        $file = $request->file('acta_' . $dte);
        $dte = Dte::findorFail($dte);
        if ($request->tray == 'servicios') {
            dd('soy servicio');
        } elseif ($request->tray == 'bienes') {
            dd('soy bien');
        }
    }





    /** Testing, para probar el modulo de aprobaciones */
    public function process($approval_id, $param1, $param2)
    {
        logger()->info('Prueba de callback modulo aprobaciones: id ' . $approval_id . ' param1: ' . $param1);
    }
}
