<?php

namespace App\Http\Controllers\Rrhh;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\User;
use App\Models\Rrhh\ShiftTypes;
use App\Rrhh\OrganizationalUnit;
use App\Programmings\Professional;
use Spatie\Permission\Models\Role;

class ShiftManagementController extends Controller
{
     public function index(Request $r)
    {
    	// echo "Shift Management";
    	  $dias = 31;
        
        $actuallyMonth = Carbon::now()->format('m');
        $actuallyDay = Carbon::now()->format('d');
        $actuallyYear = Carbon::now()->format('Y');

        $months =  (object) array(
						'01'=>'Enero',
						'02'=>'Febrero',
						'03'=>'Marzo',
						'04'=>'Abril',
						'05'=>'Mayo',
						'06'=>'Junio',
						'07'=>'Julio',
						'08'=>'Agosto',
						'09'=>'Septiembre',
						'10'=>'Octubre',
						'11'=>'Noviembre',
						'12'=>'Diciembre',
					);

        $sTypes = ShiftTypes::all(); 
    	$users = User::Search($r->get('name'))->orderBy('name','Asc')->paginate(500);
    	$cargos = OrganizationalUnit::all();
        return view('rrhh.shift_management.index', compact('users','cargos','sTypes','dias','actuallyMonth','actuallyDay','actuallyYear','months'));
    }
 	public function indexfiltered(Request $r){

        
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
    	// echo "create";
    	$tiposJornada =   array(
    							'F' => "Libre",
								'D' => "Dia",
								'L' => "Largo",
								'N' => "Noche"
						);
        return view('rrhh.shift_management.createshifttype', compact('tiposJornada'));

    }
    public function storenewshift(Request $r){

        $nSType = new ShiftTypes; 
        $nSType->name = $r->name;
        $nSType->shortname = $r->shortname;
        $nSType->day_series = implode(",", $r->day_series);
        $nSType->save();
        session()->flash('info', 'El Turno tipo <i>"'.$r->name.'"</i> ha sido creado.');
        return redirect()->route('rrhh.shiftsTypes.index');

    }
    public function updateshifttype(Request $r){
    	// echo "updateshifttype ".implode(",", $r->day_series); 

    	$fSType = ShiftTypes::find($r->id);
    	$fSType->name = $r->name;
		$fSType->shortname = $r->shortname;
		$fSType->day_series = implode(",", $r->day_series);
		$fSType->update();
        session()->flash('info', 'El Turno tipo <i>"'.$r->name.'"</i> ha sido modificado.');
        return redirect()->route('rrhh.shiftsTypes.index');

    }

}
