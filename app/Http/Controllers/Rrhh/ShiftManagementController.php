<?php

namespace App\Http\Controllers\Rrhh;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\User;
use Spatie\Permission\Models\Role;

class ShiftManagementController extends Controller
{
     public function index(Request $request)
    {
    	// echo "Shift Management";
    	$users = User::Search($request->get('name'))->orderBy('name','Asc')->paginate(500);
        return view('rrhh.shift_management.index', compact('users'));
    }
 	
 	public function shiftstypesindex()
    {
        // return view('rrhh.shift_management.shiftstypes', compact('users'));
        return view('rrhh.shift_management.shiftstypes');
    }

}
