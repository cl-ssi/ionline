<?php

namespace App\Http\Controllers;

use App\Models\Vaccination;
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
                    $vaccination->save();
                }
                else {
                    $vaccination = new Vaccination();
                }
            } elseif (env('APP_ENV') == 'local') {
                $vaccination = Vaccination::where('run',15)->first();
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
    public function index()
    {
        $vaccinations = Vaccination::all();
        return view('vaccination.index', compact('vaccinations'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('vaccination.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $vaccination = new Vaccination($request->All());
        $vaccination->save();

        session()->flash('El funcionario ha sido agreagdo');
        return redirect()->route('vaccination.create');
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

        return redirect()->route('vaccination.index');
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
}
