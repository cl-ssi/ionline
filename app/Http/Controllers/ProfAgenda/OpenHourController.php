<?php

namespace App\Http\Controllers\ProfAgenda;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\ProfAgenda\OpenHour;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

class OpenHourController extends Controller
{
    public function store(Request $request){
        $openHour = OpenHour::find($request->openHours_id);
        $openHour->contact_number = $request->contact_number;
        $openHour->patient_id = $request->patient_id;
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
}
