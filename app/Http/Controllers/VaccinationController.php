<?php

namespace App\Http\Controllers;

use App\Models\Vaccination;
use App\Models\Vaccination\Slot;
use App\Models\Vaccination\Day;
use Illuminate\Http\Request;
//use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class VaccinationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function welcome()
    {
        return view('vaccination.welcome');
    }

    public function login($access_token)
    {
        if ($access_token) {
            // dd("");
            if (env('APP_ENV') == 'production') {
                // $access_token = session()->get('access_token');
                $url_base = "https://www.claveunica.gob.cl/openid/userinfo/";
                $response = Http::withToken($access_token)->post($url_base);
                $user_cu = json_decode($response);

                $vaccination = Vaccination::where('run',$user_cu->RolUnico->numero)->first();
                if($vaccination) {
                    $vaccination->run = $user_cu->RolUnico->numero;
                    $vaccination->dv = $user_cu->RolUnico->DV;
                    $vaccination->name = implode(' ', $user_cu->name->nombres);
                    $vaccination->fathers_family = $user_cu->name->apellidos[0];
                    $vaccination->mothers_family = $user_cu->name->apellidos[1];
                    $vaccination->personal_email = $user_cu->email;
                    $vaccination->inform_method = 1;
                    $vaccination->save();
                }
                else {
                    $vaccination = new Vaccination();
                }
            } elseif (env('APP_ENV') == 'local') {
                $vaccination = Vaccination::where('run',15287582)->first();
                if($vaccination) {
                    $vaccination->dv = 7;
                    $vaccination->name = "Alvaro";
                    $vaccination->fathers_family = "Torres";
                    $vaccination->mothers_family = "Fuschslocher";
                    $vaccination->personal_email = "email@email.com";
                }
                else {
                    $vaccination = new Vaccination();
                }
            }
            return $this->show($vaccination);
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        //$vaccinations = Vaccination::all();
        $vaccinations = Vaccination::search($request->input('search'))->paginate(250);
        return view('vaccination.index', compact('vaccinations', 'request'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $result = false;
        if($request->get('run')) $result = Vaccination::where('run',$request->run)->exists();
        return view('vaccination.create', compact('result'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'run' => 'required|unique:vaccinations'
        ]);

        $vaccination = new Vaccination($request->All());
        $vaccination->save();

        return redirect()->route('vaccination.edit',$vaccination)->with('success', 'El funcionario ha sido agregado');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Vaccination  $vaccination
     * @return \Illuminate\Http\Response
     */
    public function show(Vaccination $vaccination)
    {
        return view('vaccination.show', compact('vaccination'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Vaccination  $vaccination
     * @return \Illuminate\Http\Response
     */
    public function edit(Vaccination $vaccination)
    {
        return view('vaccination.edit', compact('vaccination'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Vaccination  $vaccination
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Vaccination $vaccination)
    {
        $vaccination->fill($request->all());
        $vaccination->save();

        return redirect()->back()->with('success', 'Se han guardado los cambios');;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Vaccination  $vaccination
     * @return \Illuminate\Http\Response
     */
    public function destroy(Vaccination $vaccination)
    {
        //
    }

    public function vaccinate(Vaccination $vaccination, $dose)
    {
        if ($dose = 'first')
        {
        $vaccination->first_dose_at = date("Y-m-d H:i:s");
        $vaccination->save();
        }
        if ($dose = 'second')
        {
        $vaccination->second_dose_at = date("Y-m-d H:i:s");
        $vaccination->save();
        }



        return redirect()->back();
    }

    public function card(Vaccination $vaccination)
    {
        return view('vaccination.card', compact('vaccination'));
    }

    public function report()
    {
        /* Total de funcionarios */
        $report['total'] = Vaccination::all()->count();

        /* Han visto la información por clave única */
        $report['informed_cu'] = Vaccination::where('inform_method',1)->count();
        $report['informed_cu_per'] = number_format($report['informed_cu'] / $report['total'] * 100, 1).'%';

        /* Han sido informados por teléfono */
        $report['informed_tp'] = Vaccination::where('inform_method',2)->count();
        $report['informed_tp_per'] = number_format($report['informed_tp'] / $report['total'] * 100, 1).'%';

        /* Han sido informados por email */
        $report['informed_em'] = Vaccination::where('inform_method',3)->count();
        $report['informed_em_per'] = number_format($report['informed_em'] / $report['total'] * 100, 1).'%';

        /* No han visto la información */
        $report['not_informed'] = $report['total'] - $report['informed_cu'] - $report['informed_tp'];
        $report['not_informed_per'] = number_format($report['not_informed'] / $report['total'] * 100, 1).'%';

        /* Cantidad de agendados con primera dosis */
        $report['fd_booking'] = Vaccination::whereDate('first_dose','>=','2021-02-23')->count();
        $report['fd_booking_per'] = number_format($report['fd_booking'] / $report['total'] * 100, 1).'%';

        /* Cantidad de vacunados con primera dosis */
        $report['fd_vaccined'] = Vaccination::whereNotNull('first_dose_at')->count();
        $report['fd_vaccined_per'] = number_format($report['fd_vaccined'] / $report['total'] * 100, 1).'%';

        /* Cantidad pendiente de vacunar con primera dosis */
        $report['fd_not_vaccined'] = $report['total'] - $report['fd_vaccined'];
        $report['fd_not_vaccined_per'] = number_format($report['fd_not_vaccined'] / $report['total'] * 100, 1).'%';

        /* Cantidad de agendados con segunda dosis */
        $report['sd_booking'] = Vaccination::whereNotNull('second_dose')->count();
        $report['sd_booking_per'] = number_format($report['sd_booking'] / $report['fd_vaccined'] * 100, 1).'%';

        /* Cantidad de vacunados con segunda dosis */
        $report['sd_vaccined'] = Vaccination::whereNotNull('second_dose_at')->count();
        $report['sd_vaccined_per'] = number_format($report['sd_vaccined'] / $report['total'] * 100, 1).'%';

        /* Cantidad pendiente de vacunar con segunda dosis */
        $report['sd_not_vaccined'] = $report['fd_vaccined'] - $report['sd_vaccined'];
        $report['sd_not_vaccined_per'] = number_format($report['sd_not_vaccined'] / $report['fd_vaccined'] * 100, 1).'%';

        //dd($report);

        return view('vaccination.report', compact('report'));
    }

    public function export(){

        $headers = array(
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=listado_vacuna_sarscov2.csv",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        );

        $filas = Vaccination::all();

        $columnas = array(
            'ID',
            'Establecimiento',
            'Unidad Organizacional',
            'Informado a través',
            'Nombre',
            'A.Paterno',
            'A.Materno',
            'RUN',
            '1° Dosis Cita',
            '1° Suministrada',
            '2° Dosis Cita',
            '2° Suministrada'
        );

        $callback = function() use ($filas, $columnas)
        {
            $file = fopen('php://output', 'w');
            fputs($file, $bom =( chr(0xEF) . chr(0xBB) . chr(0xBF) ));
            fputcsv($file, $columnas,';');
            foreach($filas as $fila) {
                fputcsv($file, array(
                    $fila->id,
                    $fila->aliasEstab,
                    $fila->organizationalUnit,
                    $fila->aliasInformMethod,
                    $fila->name,
                    $fila->fathers_family,
                    $fila->mothers_family,
                    $fila->runFormat,
                    $fila->first_dose,
                    $fila->first_dose_at,
                    $fila->second_dose,
                    $fila->second_dose_at,
                ),';');
            }
            fclose($file);
        };
        return response()->stream($callback, 200, $headers);
    }

    public function removeBooking(Vaccination $vaccination) {
        $slot = Slot::where('start_at',$vaccination->second_dose)->first();

        $slot->update(['used' => $slot->used - 1]);
        $vaccination->update(['second_dose' => null]);

        return redirect()->back();
    }

    public function slots(Request $request) {
        $records=null;
        if($request->input('search'))
        {
        $records = Vaccination::search($request->input('search'))->get();
        }
        $slots = Slot::whereBetween('start_at',[date('Y-m-d 00:00:00'),date('Y-m-d 23:59:59')])->get();
        foreach($slots as $slot) {
            $bookings = Vaccination::where('first_dose',$slot->start_at)->orWhere('second_dose',$slot->start_at)->get();
            $slot->bookings = $bookings;
        }

        $arrivals = Vaccination::orderBy('arrival_at')->whereNull('dome_at')
            ->whereBetween('arrival_at',[date('Y-m-d 00:00:00'),date('Y-m-d 23:59:59')])
            ->get();
        return view('vaccination.slots',compact('slots','arrivals','records'));
    }

    public function arrival(Vaccination $vaccination, $reverse = null)
    {
        if($reverse) {
            $vaccination->arrival_at = null;    
        }
        else {
            $vaccination->arrival_at = date("Y-m-d H:i:s");
        }
        $vaccination->save();

        return redirect()->back();
    }

    public function dome(Vaccination $vaccination)
    {
        $vaccination->dome_at = date("Y-m-d H:i:s");
        $vaccination->save();

        return redirect()->route('vaccination.slots')->with('success', 'El funcionario ha sido agregado a lista de espera');
    }
    
}
