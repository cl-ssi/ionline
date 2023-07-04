<?php

namespace App\Http\Controllers\Mammography;

use App\Models\Mammography\Mammography;
use App\Models\Mammography\MammographySlot;
use App\Models\Mammography\MammographyDay;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;

class MammographyController extends Controller
{
    public function welcome()
    {
        return view('mammography.welcome');
    }

    public function login($access_token)
    {
        if ($access_token) {
            // dd("");
            if (env('APP_ENV') == 'production') {
                // $access_token = session()->get('access_token');
                $url_base = "https://accounts.claveunica.gob.cl/openid/userinfo";
                $response = Http::withToken($access_token)->post($url_base);
                $user_cu = json_decode($response);

                $mammography = Mammography::where('run',$user_cu->RolUnico->numero)->first();
                if($mammography) {
                    $mammography->run = $user_cu->RolUnico->numero;
                    $mammography->dv = $user_cu->RolUnico->DV;
                    $mammography->name = implode(' ', $user_cu->name->nombres);
                    $mammography->fathers_family = $user_cu->name->apellidos[0];
                    $mammography->mothers_family = $user_cu->name->apellidos[1];
                    $mammography->personal_email = $user_cu->email;
                    $mammography->inform_method = 1;
                    $mammography->save();

                    return $this->show($mammography);
                }

                session()->flash('danger', 'Estimada Usuaria: ud, no se encuentra en nuestros registros');
                return redirect()->route('mammography.welcome');

            } elseif (env('APP_ENV') == 'local') {
                $mammography = mammography::where('run',16966444)->first();
                if($mammography) {
                    $mammography->dv = 7;
                    $mammography->name = "Jorge";
                    $mammography->fathers_family = "Miranda";
                    $mammography->mothers_family = "López";
                    $mammography->personal_email = "email@email.com";

                    return $this->show($mammography);
                }
                else {
                    $mammography = new mammography();
                }
            }

        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $mammograms = Mammography::search($request->input('search'))->paginate(250);
        return view('mammography.index', compact('mammograms', 'request'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $result = false;
        if($request->get('run')) {
            $result = Mammography::where('run',$request->run)->exists();
        }
        return view('mammography.create', compact('result'));
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
            'run' => 'required|unique:mammographies'
        ]);

        $mammography = new Mammography($request->All());
        $mammography->save();

        return redirect()->route('mammography.edit',$mammography)->with('success', 'La funcionaria ha sido agregado');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Mammography  $mammography
     * @return \Illuminate\Http\Response
     */
    public function show(Mammography $mammography)
    {
        return view('mammography.show', compact('mammography'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Mammography  $mammography
     * @return \Illuminate\Http\Response
     */
    public function edit(Mammography $mammography)
    {
        return view('mammography.edit', compact('mammography'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Mammography  $mammography
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Mammography $mammography)
    {
        $mammography->fill($request->all());
        $mammography->save();

        return redirect()->back()->with('success', 'Funcionario(a) Actualizado');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Mammography  $mammography
     * @return \Illuminate\Http\Response
     */
    public function destroy(Mammography $mammography)
    {
        //
    }

    public function slots(Request $request) {
        // $records=null;
        // if($request->input('search'))
        // {
        // $records = Mammography::search($request->input('search'))->get();
        // }
        // $slots = MammographySlot::whereBetween('start_at',[date('Y-m-d 00:00:00'),date('Y-m-d 23:59:59')])->get();
        // foreach($slots as $slot) {
        //     $bookings = Vaccination::where('first_dose',$slot->start_at)->orWhere('second_dose',$slot->start_at)->get();
        //     $slot->bookings = $bookings;
        // }
        //
        // $arrivals = Mammography::orderBy('arrival_at')
        //     ->whereBetween('arrival_at',[date('Y-m-d 00:00:00'),date('Y-m-d 23:59:59')])
        //     ->get();
        // return view('vaccination.slots',compact('slots','arrivals','records'));
    }

    public function export(){

        $headers = array(
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=listado_personal_con_reserva_mamografia.csv",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        );

        $filas = Mammography::where('exam_date', '!=', NULL)
            ->orderBy('exam_date', 'ASC')
            ->get();

        $columnas = array(
            'ID',
            'RUN',
            'Nombre',
            'A.Paterno',
            'A.Materno',
            'Dia de Reserva'
        );

        $callback = function() use ($filas, $columnas)
        {
            $file = fopen('php://output', 'w');
            fputs($file, $bom =( chr(0xEF) . chr(0xBB) . chr(0xBF) ));
            fputcsv($file, $columnas,';');
            foreach($filas as $fila) {
                fputcsv($file, array(
                    $fila->id,
                    $fila->runFormat,
                    $fila->name,
                    $fila->fathers_family,
                    $fila->mothers_family,
                    $fila->exam_date,
                ),';');
            }
            fclose($file);
        };
        return response()->stream($callback, 200, $headers);
    }

    public function schedule(Request $request){
        $mammograms = Mammography::whereDate('exam_date', $request->search)->get();

        $day = MammographyDay::whereDate('day', $request->search)->first();

        return view('mammography.schedule',compact('day', 'request', 'mammograms'));
    }
}
