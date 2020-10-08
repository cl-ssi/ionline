<?php

namespace App\Http\Controllers\Programmings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Programmings\ProfessionalHour;
use App\Programmings\Professional;

class ProfessionalHourController extends Controller
{
    public function index(Request $request)
    {
        $professionalHours = Professional::select(
                                                'pro_professionals.id'
                                                ,'pro_professionals.name'
                                                ,'T1.id AS professionalHour_id'
                                                ,'T1.value'
                                                ,'T1.programming_id')
                                        ->leftjoin('pro_professional_hours AS T1', 'pro_professionals.id', '=', 'T1.professional_id')
                                        ->where('T1.programming_id',1)
                                        ->get();

        $professionals = Professional::All()->SortBy('id');
        
        return view('programmings/professionalHours/index')->withProfessionalHours($professionalHours)->withProfessionals($professionals);
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

    public function show(Request $request, $id)
    {
        $professionalHours = Professional::select(
                                                'pro_professionals.id'
                                                ,'pro_professionals.name'
                                                ,'T1.id AS professionalHour_id'
                                                ,'T1.value'
                                                ,'T1.programming_id')
                                        ->leftjoin('pro_professional_hours AS T1', 'pro_professionals.id', '=', 'T1.professional_id')
                                        ->where('T1.programming_id',$id)
                                        ->orderBy('pro_professionals.id')
                                        ->get();

        $professionals = Professional::All()->SortBy('id');
        
        return view('programmings/professionalHours/index')->withProfessionalHours($professionalHours)->withProfessionals($professionals);
    }
}
