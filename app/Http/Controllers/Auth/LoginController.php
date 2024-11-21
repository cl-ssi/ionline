<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use App\Models\User;

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
    
    use ThrottlesLogins, AuthenticatesUsers;


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
    public function login(Request $request)
    {
        $originalId = strtoupper($request->input('id'));
        $this->validateLogin($request);

        if (method_exists($this, 'hasTooManyLoginAttempts') && $this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }


        if ($this->attemptLogin($request)) {
            /** Authentication passed...*/
            if ($request->hasSession()) {
                $request->session()->put('auth.password_confirmed_at', time());
            }

            /** Log access */
            auth()->user()->accessLogs()->create([
                'type' => 'local',
            ]);

            /** Check if user have a gravatar */
            auth()->user()->checkGravatar;

            /** Store login type */
            session(['loginType' => 'local']);

            return $this->sendLoginResponse($request);
        }
        $request->merge(['id' => $originalId]);
        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }

    /**
     * Validate the user login request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function validateLogin(Request $request)
    {
        /*
        * Limpiar run y quitar el DV
        */
        $runUpper   = strtoupper($request->input('id'));
        $runFilter  = preg_replace('/[^0-9K]/', '', $runUpper);
        $id         = substr($runFilter, 0, -1);

        $request->replace([
            'id'        => $id, 
            'password'  => $request->input('password')
        ]);

        $request->validate([
            'id'        => 'required|string',
            'password'  => 'required|string',
        ]);
    }

    /**
     * Attempt to log the user into the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    protected function attemptLogin(Request $request)
    {
        return $this->guard()->attempt(
            $this->credentials($request), $request->boolean('remember')
        );
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
        
        //dd('llegue');
        Auth::guard('external')->logout();
        
        $request->session()->flush();
        $request->session()->regenerate();
        request()->session()->invalidate();
        request()->session()->regenerateToken();

        $url_logout = "https://accounts.claveunica.gob.cl/api/v1/accounts/app/logout?redirect=";
        $url_redirect = "https://i.saludtarapaca.gob.cl/logout";
        $url = $url_logout.urlencode($url_redirect);
        return redirect()->to($url)->send();
        
    }

}
