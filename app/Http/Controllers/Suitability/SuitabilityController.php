<?php

namespace App\Http\Controllers\Suitability;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;

class SuitabilityController extends Controller
{
    //

    public function index(Request $request)
    {
        //return view('replacement_staff.index', compact('request'));
    }

    public function indexOwn()
    {
        
        return view('suitability.indexown');

    }


    public function validateRequest()
    {
        return view('suitability.validaterequest');
    }

    public function validateRun(Request $request)
    {
        $user = User::find($request->run);
        if(!$user)
        {
            return redirect()->route('suitability.create',$request->run);
            
            
        }
        else
        {
            dd("Si existe");
        }
    }
    


    public function create($run)
    {
        
        return view('suitability.create',compact('run'));
        
    }

    public function store(Request $request)
    {
        $user = new User($request->All());
        $user->email_personal = $request->email;
        $user->external = 1;
        $user->save();
        session()->flash('success', 'Solicitud Creada Exitosamente');

        return redirect()->route('suitability.own');


    }


}
