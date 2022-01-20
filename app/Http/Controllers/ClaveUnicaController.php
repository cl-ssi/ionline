<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Models\UserExternal;

/* No se si son necesarias, las puse para el try catch */
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\RequestException;
use Exception;

class ClaveUnicaController extends Controller
{
    public function autenticar(Request $request){
        /* Primer paso, redireccionar al login de clave única */
        //$redirect = '../monitor/lab/login';
        $redirect = $request->input('redirect');
        //die($redirect);

        $url_base = "https://accounts.claveunica.gob.cl/accounts/login/?next=/openid/authorize";
        $client_id = env("CLAVEUNICA_CLIENT_ID");
        $redirect_uri = urlencode(env("CLAVEUNICA_CALLBACK"));
        $state = base64_encode(csrf_token().$redirect);
        $scope = env("CLAVEUNICA_SCOPE");
        //'openid+run+name+email';

        $url=$url_base.urlencode('?client_id='.$client_id.'&redirect_uri='.$redirect_uri.'&scope='.$scope.'&response_type=code&state='.$state);

        return redirect()->to($url)->send();
    }

    public function callback(Request $request) {
        $code = $request->input('code');
        $state = $request->input('state'); // token

        $url_base = "https://accounts.claveunica.gob.cl/openid/token/";
        $client_id = env("CLAVEUNICA_CLIENT_ID");
        $client_secret = env("CLAVEUNICA_SECRET_ID");
        $redirect_uri = urlencode(env("CLAVEUNICA_CALLBACK"));
        //$state = csrf_token();
        //$scope = 'openid+run+name+email';

        try {
            $response = Http::asForm()->post($url_base, [
                'client_id' => $client_id,
                'client_secret' => $client_secret,
                'redirect_uri' => $redirect_uri,
                'grant_type' => 'authorization_code',
                'code' => $code,
                'state' => $state,
            ]);
        } catch (ConnectException | RequestException | Exception $e) {
            logger("Error en callback de clave unica, redirecionando al login ", ['e' => $e]);
            return redirect()->route('login');
        }


        /* Paso especial de SSI */
        /* Obtengo la url del sistema al que voy a redireccionar el login true */
        if($response->getStatusCode() == 200) {
            $redirect     = base64_decode(substr(base64_decode($state), 40));
            $access_token = json_decode($response)->access_token;
    
            $url_redirect = env('APP_URL').$redirect.'/'.$access_token;
    
            return redirect()->to($url_redirect)->send();
        }
        else {
            return redirect()->route('claveunica.autenticar');
        }

        /*
        [RolUnico] => stdClass Object
            (
                [DV] => 4
                [numero] => 44444444
                [tipo] => RUN
            )

        [sub] => 2594
        [name] => stdClass Object
            (
                [apellidos] => Array
                    (
                        [0] => Del rio
                        [1] => Gonzalez
                    )

                [nombres] => Array
                    (
                        [0] => Maria
                        [1] => Carmen
                        [2] => De los angeles
                    )

            )
        [email] => mcdla@mail.com
        */
    }

    public function login($access_token = null)
    {
        if ($access_token) {
            //dd($access_token);
            if (env('APP_ENV') == 'production' OR env('APP_ENV') == 'testing') {
                //$access_token = session()->get('access_token');
                $url_base = "https://www.claveunica.gob.cl/openid/userinfo";
                $response = Http::withToken($access_token)->post($url_base);
               
		        if($response->getStatusCode() == 200) {
                    $user_cu = json_decode($response);
                    
                    $user = new User();
                    $user->id = $user_cu->RolUnico->numero;
                    $user->dv = $user_cu->RolUnico->DV;
                    $user->name = implode(' ', $user_cu->name->nombres);
                    $user->fathers_family = (array_key_exists(0, $user_cu->name->apellidos)) ? $user_cu->name->apellidos[0] : '';
                    $user->mothers_family = (array_key_exists(1, $user_cu->name->apellidos)) ? $user_cu->name->apellidos[1] : '';
                    if(isset($user_cu->email)) {
                        $user->email = $user_cu->email;
                    }
		        }
		        else {
                    session()->flash('danger', 'Error en clave única. No se pudo iniciar sesión');
		            return redirect()->route('login');
		        }
            } elseif (env('APP_ENV') == 'local') {
                $user = new User();
                $user->id = 12345678;
                $user->dv = 9;
                $user->name = "Administrador";
                $user->fathers_family = "Ap1";
                $user->mothers_family = "Ap2";
                $user->email = "email@email.com";
            }

            $u = User::find($user->id);
            if($u) {
                $u->name = $user->name;
                $u->fathers_family = $user->fathers_family;
                $u->mothers_family = $user->mothers_family;
                $u->email_personal = $user->email;
                $u->save();
                Auth::login($u, true);
                $route = 'home';
            }
            else {
                session()->flash('danger', 'No existe el usuario registrado en el sistema');
                $route = 'login';
            }

            return redirect()->route($route);
            //Auth::loginUsingId($user->id, true);
        }
    }

    public function loginExternal($access_token = null)
    {
        if ($access_token) {
            //dd($access_token);
            if (env('APP_ENV') == 'production' OR env('APP_ENV') == 'testing') {
                //$access_token = session()->get('access_token');
                $url_base = "https://www.claveunica.gob.cl/openid/userinfo";
                $response = Http::withToken($access_token)->post($url_base);
                $user_cu = json_decode($response);
                
		        if($user_cu) {
                    //ACA HAY QUE BUSCAR POR EL ID EL USUARIO SI EXISTE LO CARGO Y LOGEO

                    $user = UserExternal::find($user_cu->RolUnico->numero);
                    if(!$user)
                    {
                        $user = new UserExternal();
                        $user->id = $user_cu->RolUnico->numero;
                        $user->dv = $user_cu->RolUnico->DV;
                        $user->name = implode(' ', $user_cu->name->nombres);
                        $user->fathers_family = $user_cu->name->apellidos[0];
                        $user->mothers_family = $user_cu->name->apellidos[1];
                        if(isset($user_cu->email)) {
                            $user->email = $user_cu->email;
                        }                        
                        $user->save();
                        
                    }
                    
                    
		        }
		        else {
                    session()->flash('danger', 'Error en clave única. No se pudo iniciar sesión');
		            return redirect()->route('login');
		        }
            } elseif (env('APP_ENV') == 'local') {
                $user = new User();
                $user->id = 12345678;
                $user->dv = 9;
                $user->name = "Administrador";
                $user->fathers_family = "Ap1";
                $user->mothers_family = "Ap2";
                $user->email = "email@email.com";
            }            
            Auth::guard('external')->login($user, true);
            

            return redirect()->route('external');
            //Auth::loginUsingId($user->id, true);
        }
    }

    public function logout() {
        
        if(env('APP_ENV') == 'local'){
            return redirect()->route('logout');
        }else{
            $url_logout = "https://accounts.claveunica.gob.cl/api/v1/accounts/app/logout?redirect=";
            $url_redirect = "https://www.saludiquique.app/logout";
            $url = $url_logout.urlencode($url_redirect);
        }        

        return redirect()->to($url)->send();
    }

}
