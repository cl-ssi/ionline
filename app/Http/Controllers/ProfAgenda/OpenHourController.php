<?php

namespace App\Http\Controllers\ProfAgenda;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\ProfAgenda\OpenHour;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use App\User;

class OpenHourController extends Controller
{

    public function index(Request $request)
    {
        $user_id_param = $request->user_id;
        $patient_id_param = $request->patient_id;
        $assistance_param = $request->assistance;
        // dd($assistance_param);

        $openHours = OpenHour::whereNotNull('patient_id')
                            ->where('blocked',0)
                            ->orderBy('start_date', 'DESC')
                            ->where('profesional_id',$user_id_param)
                            ->when($assistance_param!=-1, function ($q) use ($assistance_param) {
                                return $q->where('assistance',intval($assistance_param));
                            })
                            ->when($patient_id_param, function ($q) use ($patient_id_param) {
                                return $q->where('patient_id',$patient_id_param);
                            })
                            
                            ->get();
        return view('prof_agenda.open_hours.index',compact('openHours','request'));
    }

    public function store(Request $request){

        
        // // validación para dv de rut
        // if($request->dv!=null){
        //     session()->flash('warning', 'El campo dv no puede ser vacío.');
        //     return redirect()->back();
        // }

        // si el usuario se encuentra eliminado, se vuelve a dejar activo
        if(User::withTrashed()->find($request->user_id)){
            if(User::withTrashed()->find($request->user_id)->trashed()){
                User::withTrashed()->find($request->user_id)->restore();
            }
        }

        //devuelve user o lo crea
        if($request->new_user == 1){
            $user = User::updateOrCreate(
            ['id' => $request->user_id],
            [
                'dv' =>  $request->dv,
                'name' =>  $request->name,
                'fathers_family' =>  $request->fathers_family,
                'mothers_family' =>  $request->mothers_family,
                'commune_id' => $request->commune_id,
                'address' =>  $request->address,
                'phone_number' =>  $request->phone_number,
                'email' =>  $request->email,
                'organizational_unit_id' =>  $request->organizational_unit_id
            ]
            );
        }else{
            $user = User::updateOrCreate(
            ['id' => $request->user_id],
            [
                'dv' =>  $request->dv,
                'name' =>  $request->name,
                'fathers_family' =>  $request->fathers_family,
                'mothers_family' =>  $request->mothers_family,
                'commune_id' => $request->commune_id,
                'address' =>  $request->address,
                'phone_number' =>  $request->phone_number,
                'email' =>  $request->email
            ]
            );
        }        

        $openHour = OpenHour::find($request->openHours_id);
        $openHour->contact_number = $request->phone_number;
        $openHour->patient_id = $user->id;
        $openHour->observation = $request->observation;
        $openHour->save();
        
        session()->flash('success', 'Se guardó la información.');
        return redirect()->back();
    }

    public function destroy(Request $request){
        $openHour = OpenHour::find($request->openHours_id);
        $openHour->delete();
        
        session()->flash('success', 'Se eliminó el bloque.');
        return redirect()->back();
    }

    public function delete_reservation(Request $request){
        $openHour = OpenHour::find($request->openHours_id);
        $openHour->deleted_bloqued_observation = now() . ": Se eliminó la reserva de " . $openHour->patient->shortName . ". Motivo: " . $request->deleted_bloqued_observation;
        $openHour->patient_id = null;
        $openHour->observation = null;
        $openHour->save();
        
        session()->flash('success', 'Se guardó la información.');
        return redirect()->back();
    }

    public function block(Request $request){
        $openHour = OpenHour::find($request->openHours_id);
        $openHour->deleted_bloqued_observation = now() . ": Motivo del bloqueo: " . $request->deleted_bloqued_observation;
        $openHour->blocked = true;
        $openHour->save();
        
        session()->flash('success', 'Se guardó la información.');
        return redirect()->back();
    }

    public function unblock(Request $request){
        $openHour = OpenHour::find($request->openHours_id);
        $openHour->deleted_bloqued_observation = null;
        $openHour->blocked = false;
        $openHour->save();
        
        session()->flash('success', 'Se guardó la información.');
        return redirect()->back();
    }

    public function change_hour($id, $start_date){
        // dd($start_date);
        $start_date = Carbon::parse($start_date);
        // dd($start_date);
        
        $openHour = OpenHour::find($id);
        $openHour->start_date = $start_date;
        $openHour->end_date = $start_date->addMinutes($openHour->detail->duration);
        $openHour->save();

        session()->flash('success', 'Se guardó la información.');
        return redirect()->back();

    }

    public function saveBlock(Request $request){
        // dd($request);
        $date = Carbon::parse($request->date);
        $start_date = Carbon::parse($date->format('Y-m-d') . " " . $request->start_hour);
        $end_date = Carbon::parse($date->format('Y-m-d') . " " . $request->end_hour);
        // dd($start_date, $end_date);

        // dd($request);
        if($start_date <= $end_date){
            foreach (CarbonPeriod::create($start_date, $request->duration . " minutes", $end_date)->excludeEndDate() as $key => $hour) {
                $newOpenHour = new OpenHour();
                $newOpenHour->start_date = $date->format('Y-m-d') . " " . $hour->format('H:i');
                $newOpenHour->end_date = Carbon::parse($date->format('Y-m-d') . " " . $hour->format('H:i'))->addMinutes($request->duration)->format('Y-m-d H:i');
                $newOpenHour->profesional_id = $request->profesional_id;
                $newOpenHour->profession_id = $request->profession_id; 
                $newOpenHour->activity_type_id = $request->activity_type_id;
                $newOpenHour->save();
            }
        }
        // dd("");
        session()->flash('success', 'Se agregó el bloque.');
        return redirect()->back();
    }

    public function deleteBlocks(Request $request){
        $date = Carbon::parse($request->date);
        $start_date = Carbon::parse($date->format('Y-m-d') . " " . $request->start_hour);
        $end_date = Carbon::parse($date->format('Y-m-d') . " " . $request->end_hour);
        OpenHour::whereBetween('start_date',[$start_date,$end_date])->delete();
        session()->flash('success', 'Se eliminaron los bloques.');
        return redirect()->back();
    }   

    public function assistance_confirmation(Request $request){
        $openHour = OpenHour::find($request->openHours_id);
        $openHour->assistance = true;
        $openHour->save();

        session()->flash('success', 'Se guardó la información.');
        return redirect()->back();
    }

    public function absence_confirmation(Request $request){
        $openHour = OpenHour::find($request->openHours_id);
        $openHour->assistance = false;
        $openHour->absence_reason = $request->absence_reason;
        $openHour->save();

        session()->flash('success', 'Se guardó la información.');
        return redirect()->back();
    }

    
}
