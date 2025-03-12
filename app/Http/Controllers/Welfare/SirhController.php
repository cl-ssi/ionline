<?php

namespace App\Http\Controllers\Welfare;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Sirh\WelfareUser;
use App\Models\Sirh\ExistingContract;
use App\Models\Sirh\RsalUnidad;
use Carbon\Carbon;
use App\Models\File;

class SirhController extends Controller
{
    public function welfareUsers(Request $request)
    {
        $query = WelfareUser::query();
        
        if($request->has('search')) {
            $search = $request->get('search');
            $query->where('nombre', 'LIKE', "%$search%")
                  ->orWhere('rut', 'LIKE', "%$search%")
                  ->orWhere('unidad', 'LIKE', "%$search%");
        }
        
        $welfareUsers = $query->paginate(15);
        $lastUpdate = WelfareUser::selectRaw('MAX(GREATEST(created_at, COALESCE(updated_at, created_at))) as last_update')->first();
        
        return view('welfare.sirh.welfareUserIndex', compact('welfareUsers', 'lastUpdate'));
    }

    public function existingContract(Request $request)
    {
        $query = ExistingContract::query();
        
        if($request->has('search')) {
            $search = $request->get('search');
            $query->where('nombres', 'LIKE', "%$search%")
                  ->orWhere('rut', 'LIKE', "%$search%")
                  ->orWhere('unid_descripcion', 'LIKE', "%$search%");
        }
        
        $existingContract = $query->paginate(15);
        $lastUpdate = ExistingContract::selectRaw('MAX(GREATEST(created_at, COALESCE(updated_at, created_at))) as last_update')->first();
        
        return view('welfare.sirh.existingContractIndex', compact('existingContract', 'lastUpdate'));
    }

    public function rsalUnidad(Request $request)
    {
        $query = RsalUnidad::query();
        
        if($request->has('search')) {
            $search = $request->get('search');
            $query->where('unid_descripcion', 'LIKE', "%$search%")
                  ->orWhere('unid_codigo', 'LIKE', "%$search%")
                  ->orWhere('unid_comuna', 'LIKE', "%$search%");
        }
        
        $rsalUnidad = $query->paginate(15);
        $lastUpdate = RsalUnidad::selectRaw('MAX(GREATEST(created_at, COALESCE(updated_at, created_at))) as last_update')->first();
        
        return view('welfare.sirh.rsalUnidadIndex', compact('rsalUnidad', 'lastUpdate'));
    }
}
