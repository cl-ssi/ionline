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

        $query = Control::where('visation_contract_manager_user_id', auth()->id())->where('require_contract_manager_visation',1);
        if ($tray === 'aprobados') {
            $query->where('visation_contract_manager_status', 1);
        } elseif ($tray === 'rechazados') {
            $query->where('visation_contract_manager_status', 0);
        }

        $controls = $query->paginate(100);
        $request->flash();
        return view('warehouse.visations.contract_manager.index', compact('controls', 'tray', 'request'));
    }
}
