<?php

namespace App\Http\Controllers\Warehouse;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Warehouse\Control;

class VisationContractManager extends Controller
{
    //
    public function index(Request $request, $tray = null)
    {

        $query = Control::where('visation_contract_manager_user_id', auth()->id())->where('require_contract_manager_visation', 1);
        if(!$tray){
            $query->whereNull('visation_contract_manager_status');

        }
        elseif ($tray === 'aprobados') {
            $query->where('visation_contract_manager_status', 1);
        } elseif ($tray === 'rechazados') {
            $query->where('visation_contract_manager_status', 0);
        }

        $controls = $query->paginate(100);
        $request->flash();
        return view('warehouse.visations.contract_manager.index', compact('controls', 'tray', 'request'));
    }


    public function accept(Control $control)
    {
        $control->visation_contract_manager_status = 1;
        $control->visation_contract_manager_at = now();
        $control->save();
        return redirect()->back()->with('success', 'Aceptado correctamente.');
    }


    public function reject(Control $control, Request $request)
    {
        $control->visation_contract_manager_status = 0;
        $control->visation_contract_manager_at = now();
        $control->visation_contract_manager_rejection_observation = $request->input('observacion');
        $control->save();
        return redirect()->back()->with('success', 'Rechazado correctamente.');
    }
}
