<?php

namespace App\Http\Controllers\Programmings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Programmings\ProfessionalHour;
use App\Models\Programmings\Professional;

class ProfessionalHourController extends Controller
{
    public function index(Request $request)
    {
        $professionalHours = ProfessionalHour::with('professional')->where('programming_id', $request->programming_id)->get();
        $professionals = Professional::All();
        
        return view('programmings/professionalHours/index', compact('professionalHours', 'professionals'));
    }

    public function store(Request $request)
    {
        $professionalValid = ProfessionalHour::where('professional_id', $request->professional_id)
                                  ->where('programming_id', $request->programming_id)
                                  ->first();
        if($professionalValid){
            session()->flash('warning', 'Ya se ha asignado este Profesional Hora');
        }
        else {
    
            $professionalHour = new ProfessionalHour($request->All());
            $professionalHour->professional_id = $request->professional_id;
            $professionalHour->programming_id = $request->programming_id;
            $professionalHour->value = $request->value;
        
            $professionalHour->save();

            session()->flash('info', 'Se ha asignado un nuevo Profesional Hora');
        }

        return redirect()->back();
    }

    public function destroy($id)
    {
      $professionalHour = ProfessionalHour::where('id',$id)->first();
      $professionalHour->delete();

      session()->flash('success', 'El registro ha sido eliminado de este listado');
       return redirect()->back();
    }
}
