<?php

namespace App\Http\Controllers\ProfAgenda;

use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;

use Carbon\CarbonPeriod;
use Carbon\Carbon;
use App\User;
use App\Notifications\ProfAgenda\NewReservation;
use App\Notifications\ProfAgenda\CancelReservation;

use App\Models\ProfAgenda\OpenHour;
use App\Models\ProfAgenda\Appointment;
use App\Mail\OpenHourReservation;
use App\Mail\OpenHourCancelation;
use App\Http\Controllers\Controller;

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
                            ->whereHas('activityType')
                            ->when($assistance_param!=-1, function ($q) use ($assistance_param) {
                                return $q->where('assistance',intval($assistance_param));
                            })
                            ->when($patient_id_param, function ($q) use ($patient_id_param) {
                                return $q->where('patient_id',$patient_id_param);
                            })
                            ->with('profesional','activityType','patient')
                            ->withTrashed()
                            ->get();
        return view('prof_agenda.open_hours.index',compact('openHours','request'));
    }

    public function store(Request $request)
    {
        $openHour = OpenHour::find($request->openHours_id);
        // dd($openHour);

        // valida si existen del paciente con otros funcionarios en la misma hora
        $othersReservationsCount = OpenHour::where('patient_id',$request->user_id)
                                            ->where(function($query) use ($openHour){
                                                $query->whereBetween('start_date',[$openHour->start_date, $openHour->end_date])
                                                        ->orWhereBetween('end_date',[$openHour->start_date, $openHour->end_date]);
                                            })
                                            ->whereHas('activityType')
                                            ->count(); 
        if($othersReservationsCount>0){
            session()->flash('warning', 'No es posible realizar la reserva del paciente, porque tiene otra reserva a la misma hora con otro funcionario.');
            return redirect()->back();
        }

        // // valida si existen más de 2 horas reservadas en la semana
        // $resevationsInWeek = OpenHour::where('patient_id',$request->user_id)
        //                             ->whereBetween('start_date',[$openHour->start_date->startOfWeek(), $openHour->end_date->endOfWeek()])
        //                             ->whereHas('activityType')
        //                             ->count();

        // if($resevationsInWeek > 2){
        //     session()->flash('warning', 'Alcanzó el máximo de reservas a la semana (2 reservas). Si necesita agendar otra hora, contactar a Unidad de Salud del trabajador.');
        //     return redirect()->back();
        // }

        // if($openHour->start_date < now()){
        //     session()->flash('warning', 'No se puede reservar para una fecha pasada.');
        //     return redirect()->back();
        // }

        // solo si vienen parámetros del usuario, se hace modificación
        if($request->name && $request->fathers_family){
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
        }            

        // $openHour = OpenHour::find($request->openHours_id);
        if($request->phone_number){$openHour->contact_number = $request->phone_number;}
        $openHour->patient_id = $request->user_id;
        $openHour->observation = $request->observation;
        $openHour->save();

        // si es primera cita, se guarda fecha de inicio de tratamiento (de esta manera, el paciente podrá programar sus propias citas)
        if($request->first_appointment){
            $appointment = new Appointment();
            $appointment->open_hour_id = $openHour->id;
            $appointment->begin_date = now();
            $appointment->save();
        }

        //envía correo de confirmación
        if (config('app.env') === 'local') {
            if($openHour->patient){
                if($openHour->patient->email != null){
                    // Utilizando Notify 
                    $openHour->patient->notify(new NewReservation($openHour));
                } 
            }
        }
        
        session()->flash('success', 'Se guardó la información.');
        return redirect()->back();
    }

    public function patient_store(Request $request)
    {
        $openHour = OpenHour::find($request->openHours_id);

        // valida si existen del paciente con otros funcionarios en la misma hora
        $othersReservationsCount = OpenHour::where('patient_id',$request->user_id)
                                            ->where(function($query) use ($openHour){
                                                $query->whereBetween('start_date',[$openHour->start_date, $openHour->end_date])
                                                        ->orWhereBetween('end_date',[$openHour->start_date, $openHour->end_date]);
                                            })
                                            ->whereHas('activityType')
                                            ->count(); 
        if($othersReservationsCount>0){
            session()->flash('warning', 'No es posible realizar la reserva del paciente, porque tiene otra reserva a la misma hora con otro funcionario.');
            return redirect()->back();
        }

        // valida si existen más de 2 horas reservadas en la semana
        $resevationsInWeek = OpenHour::where('patient_id',$request->user_id)
                                    ->whereBetween('start_date',[$openHour->start_date->startOfWeek(), $openHour->end_date->endOfWeek()])
                                    ->whereHas('activityType')
                                    ->count();

        if($resevationsInWeek > 2){
            session()->flash('warning', 'Alcanzó el máximo de reservas a la semana (2 reservas). Si necesita agendar otra hora, contactar a Unidad de Salud del trabajador.');
            return redirect()->back();
        }

        if($openHour->start_date < now()){
            session()->flash('warning', 'No se puede reservar para una fecha pasada.');
            return redirect()->back();
        }

        // se deja reservar al paciente, solo si tiene activo un appointment (es decir, no ha sido dado de alta de otra reserva con misma actividad)
        $appointments = Appointment::whereHas('openHour', function ($query) use ($request) {
                                        return $query->where('patient_id', $request->user_id)
                                                     ->whereNull('discharged_date');
                                    })->first();
        if(!$appointments){
            session()->flash('warning', 'No puede reservar. Debe primero solicitar una reserva con su profesional.');
            return redirect()->back();
        }
        
        // se registra la reserva
        $openHour->patient_id = $request->user_id;
        $openHour->observation = $request->observation;
        $openHour->save();

        //envía correo de confirmación
        if (config('app.env') === 'local') {
            if($openHour->patient){
                if($openHour->patient->email != null){
                    // Utilizando Notify 
                    $openHour->patient->notify(new NewReservation($openHour));
                } 
            }
        }
        
        session()->flash('success', 'Se guardó la información.');
        return redirect()->back();
    }

    public function destroy(Request $request){
        $openHour = OpenHour::find($request->openHours_id);
        
        // validación
        if($openHour->start_date < now()){
            session()->flash('warning', 'No es posible suprimir un bloque que haya transcurrido.');
            return redirect()->back();
        }

        $openHour->delete();
        
        session()->flash('success', 'Se eliminó el bloque.');
        return redirect()->back();
    }

    public function delete_reservation(Request $request){
        
        $openHour = OpenHour::find($request->openHours_id);
        // dd($openHour);
        // validación
        if($openHour->start_date < now()){
            session()->flash('warning', 'No es posible eliminar una reserva de un bloque que haya trasncurrido.');
            return redirect()->back();
        }

        // se eliminan los appointments activos
        if($openHour->appointments){
            $openHour->appointments()->delete();
        }

        if($openHour->first_appointment){
            $appointment = new Appointment();
            $appointment->open_hour_id = $openHour->id;
            $appointment->begin_date = now();
            $appointment->save();
        }

        $openHour->deleted_bloqued_observation = now() . ": Se eliminó la reserva de " . $openHour->patient->shortName . ". Motivo: " . $request->deleted_bloqued_observation;
        $openHour->patient_id = null;
        $openHour->observation = null;
        $openHour->save();

        //envía correo de cancelación
        if (config('app.env') === 'local') {
            if($openHour->patient){
                if($openHour->patient->email != null){
                    if (filter_var($openHour->patient->email, FILTER_VALIDATE_EMAIL)) {
                        /*
                        * Utilizando Notify
                        */ 
                        $openHour->patient->notify(new CancelReservation($openHour));
    
                        /*
                        * Utilizando Mail
                        */ 
                        // Mail::to($openHour->patient)->send(new OpenHourCancelation($openHour));
                    } 
                }    
            }
        }
        
        session()->flash('success', 'Se guardó la información.');
        return redirect()->back();
    }

    public function block(Request $request){
        $openHour = OpenHour::find($request->openHours_id);

        // validación
        if($openHour->start_date < now()){
            session()->flash('warning', 'No es posible bloquear un bloque que haya trasncurrido.');
            return redirect()->back();
        }

        $openHour->deleted_bloqued_observation = now() . ": Motivo del bloqueo: " . $request->deleted_bloqued_observation;
        $openHour->blocked = true;
        $openHour->save();
        
        session()->flash('success', 'Se guardó la información.');
        return redirect()->back();
    }

    public function unblock(Request $request){
        $openHour = OpenHour::find($request->openHours_id);

        // validación
        if($openHour->start_date < now()){
            session()->flash('warning', 'No es posible desbloquear un bloque que haya trasncurrido.');
            return redirect()->back();
        }

        $openHour->deleted_bloqued_observation = null;
        $openHour->blocked = false;
        $openHour->save();
        
        session()->flash('success', 'Se guardó la información.');
        return redirect()->back();
    }

    public function change_hour($id, $start_date){
        $start_date = Carbon::parse($start_date);

        $openHour = OpenHour::find($id);

        // validación
        if($openHour->start_date < now()){
            session()->flash('warning', 'No es modificar el horario de un bloque que haya trasncurrido.');
            return redirect()->back();
        }

        $duration = $openHour->start_date->diffInMinutes($openHour->end_date);
        $openHour->start_date = $start_date;
        $openHour->end_date = $start_date->addMinutes($duration);
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

        // validación
        if($end_date < now()){
            session()->flash('warning', 'No se puede eliminar bloques que ya hayan transcurrido.');
            return redirect()->back();
        }

        OpenHour::whereBetween('start_date',[$start_date,$end_date])->where('profesional_id',$request->profesional_id)->delete();
        session()->flash('success', 'Se eliminaron los bloques.');
        return redirect()->back();
    }   

    public function assistance_confirmation(Request $request){
        if($request->openHours_id){
            $openHour = OpenHour::find($request->openHours_id);
            if($openHour){
                $openHour->assistance = true;
                $openHour->save();
        
                session()->flash('success', 'Se guardó la información.');
            }
        }
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

    public function blockPeriod(Request $request){
        $start_date = Carbon::parse($request->start_date);
        $start_date = Carbon::parse($start_date->format('Y-m-d') . " " . $request->start_hour);

        $end_date = Carbon::parse($request->end_date);
        $end_date = Carbon::parse($end_date->format('Y-m-d') . " " . $request->end_hour);

        OpenHour::whereBetween('start_date',[$start_date,$end_date])
                ->where('profesional_id',$request->profesional_id)
                ->where('blocked',false)
                ->update(['deleted_bloqued_observation' => now() . ": Motivo del bloqueo: Bloqueo masivo",
                            'blocked' => true]);

        // envia notificaciones
        $openHours = OpenHour::whereBetween('start_date',[$start_date,$end_date])
                            ->where('profesional_id',$request->profesional_id)
                            ->where('blocked',true)
                            ->get();
        foreach($openHours as $openHour){
            //envía correo de cancelación
            if (config('app.env') === 'local') {
                if($openHour->patient){
                    if($openHour->patient->email != null){
                        if (filter_var($openHour->patient->email, FILTER_VALIDATE_EMAIL)) {
                            /*
                            * Utilizando Notify
                            */ 
                            $openHour->patient->notify(new CancelReservation($openHour));
                        } 
                    }    
                }
            }
        }

        session()->flash('success', 'Se bloqueó el período.');
        return redirect()->back();
    }
}
