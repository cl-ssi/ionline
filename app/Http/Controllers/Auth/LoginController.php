<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;


    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Handle an authentication attempt.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return Response
     */
    public function attemptLogin(Request $request)
    {
        $credentials = $request->only('id', 'password');

        /*
        * Limpiar run y quitar el DV
        */
        $credentials['id'] = str_replace('.','',$credentials['id']);
        $credentials['id'] = str_replace('-','',$credentials['id']);
        $credentials['id'] = substr($credentials['id'], 0, -1);


        if (Auth::attempt($credentials, $request->filled('remember'))) {
            // Authentication passed...
            return redirect()->intended('dashboard');
        }
    }

    /**
     * Overwrite username por id
     *
     */
    public function username()
    {
        return 'id';
    }
}
