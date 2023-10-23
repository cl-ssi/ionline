<?php

namespace App\Http\Controllers\Attendances;

use App\Models\Attendances\People;
use App\Models\Attendances\UnregisteredPeople;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PeopleController extends Controller
{
    public function customLogin(Request $request)
    {

        $persona = People::where('rut', $request->rut)->first();

        $jornada = $request->jornada;

        $fecha = $request->fecha;

        if ($persona != null) {
            if ($fecha == "3") {
                if ($jornada == 'dia') {
                    if (!$persona->asistencia_dia_2) {
                        $persona->asistencia_dia_2 = true;
                    }
                } else if ($jornada == 'tarde') {
                    if (!$persona->asistencia_tarde_2) {
                        $persona->asistencia_tarde_2 = true;
                    }
                }
            } else if ($fecha == "2") {
                if (!$persona->asistencia_dia_1) {
                    $persona->asistencia_dia_1 = true;
                }
            }

            

            $persona->save();

            //return redirect('main')->with('nombre', $persona->nombre)->withSuccess('Ingresado correctamente');
            return view('attendances.main', ["nombre" => $persona->nombre, "asistencia" => $persona->asistencia, "persona" => $persona]);
        } else {

            $unregisteredPerson = new UnregisteredPeople();
            $unregisteredPerson->rut = $request->rut;

            $unregisteredPerson->save();

            return view('attendances.unregistered');
        }
    }
}