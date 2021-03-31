<?php

namespace App\Http\Controllers\Rrhh;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\User;
use App\Models\Rrhh\ShiftTypes;
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
        $sTypes = ShiftTypes::all(); 
        // $sTypes = 1;
        return view('rrhh.shift_management.shiftstypes', compact('sTypes'));
    }
    public function editshifttype(Request $r)
    {	

    	$tiposJornada =   array(
    							'F' => "Libre",
								'D' => "Dia",
								'L' => "Largo",
								'N' => "Noche"
						);
        $sType = ShiftTypes::findOrFail($r->id); 
        return view('rrhh.shift_management.editshiftstype', compact('sType','tiposJornada'));

    }
    public function newshifttype(){
    	echo "create";
    }
    public function storenewshift(Request $r){

        $nSType = new ShiftTypes; 
        $nSType->name = $r->name;
        $nSType->shortname = $r->shortname;
        $nSType->day_series = implode(",", $r->day_series);
    }
    public function updateshifttype(Request $r){
    	// echo "updateshifttype ".implode(",", $r->day_series); 

    	$fSType = ShiftTypes::find($r->id);
    	$fSType->name = $r->name;
		$fSType->shortname = $r->shortname;
		$fSType->day_series = implode(",", $r->day_series);
		$fSType->update();
        session()->flash('info', 'El Turno tipo "'.$r->name.'" ha sido modificado.');
        return redirect()->route('rrhh.shiftsTypes.index');

    }

}
