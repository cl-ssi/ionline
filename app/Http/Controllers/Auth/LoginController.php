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
        $this->middleware('guest:external')->except('logout');
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
            /** Authentication passed...*/
            
            /** Log access */
            $enviroment='servidor nuevo';
            if(env('OLD_SERVER'))
            {
                $enviroment='servidor antiguo';
            }
            auth()->user()->accessLogs()->create([
                'type' => 'local',
                //'enviroment' => env('APP_ENV')
                'enviroment' => $enviroment
            ]);

            /** Check if user have a gravatar */
            auth()->user()->checkGravatar;

            return redirect()->route('home');

            /** Estaba esto, no se que hace */
            // return redirect()->intended('dashboard');
        }
    }

    public function logout()
    {
		if(Auth::check())
		{
            Auth::logout();

            request()->session()->invalidate();
            request()->session()->regenerateToken();

            return redirect()->route('welcome');
		}

        if(Auth::guard('external')->check()) // significa que es un usuario externo
        {
            Auth::guard('external')->logout();
            
            return redirect()->route('welcome');
        }

		return redirect('/');
	}


    /**
     * Overwrite username por id
     *
     */
    public function username()
    {
        return 'id';
    }


    public function showExternalLoginForm()
    {

        return view('auth.login', ['url' => 'external']);
    }


    public function externalLogin(Request $request)
    {
        
        $credentials = $request->only('id', 'password');
        $credentials['id'] = str_replace('.','',$credentials['id']);
        $credentials['id'] = str_replace('-','',$credentials['id']);
        $credentials['id'] = substr($credentials['id'], 0, -1);

        


        if (Auth::guard('external')->attempt($credentials, $request->filled('remember'))) {
            // Authentication passed...
            return redirect()->intended('/external');
        }
        return back()->withInput($request->only('email', 'remember'));
        
    }



    public function LogoutExternal(Request $request)
    {
        
        dd('llegue');
        Auth::guard('external')->logout();
        
        $request->session()->flush();
        $request->session()->regenerate();
        request()->session()->invalidate();
        request()->session()->regenerateToken();

        $url_logout = "https://accounts.claveunica.gob.cl/api/v1/accounts/app/logout?redirect=";
        $url_redirect = "https://i.saludiquique.cl/logout";
        $url = $url_logout.urlencode($url_redirect);
        return redirect()->to($url)->send();
        
    }

}
