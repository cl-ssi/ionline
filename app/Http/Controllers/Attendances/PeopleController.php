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

        if ($persona != null) {
            $persona->asistencia = true;
            $persona->save();

            //return redirect('main')->with('nombre', $persona->nombre)->withSuccess('Ingresado correctamente');
            return view('attendances.main', ["nombre" => $persona->nombre, "asistencia" => $persona->asistencia]);
        } else {

            $unregisteredPerson = new UnregisteredPeople();
            $unregisteredPerson->rut = $request->rut;

            $unregisteredPerson->save();

            return view('attendances.unregistered');
        }
    }
}