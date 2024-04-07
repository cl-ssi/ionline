<?php

namespace App\Http\Controllers\ServiceRequests;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Illuminate\Http\Client\ConnectionException;
use App\Models\User;
use App\Models\ServiceRequests\ServiceRequest;
use App\Models\ServiceRequests\Fulfillment;
use App\Models\Rrhh\UserBankAccount;
use App\Http\Controllers\Controller;


class InvoiceController extends Controller
{
    //

    public function welcome()
    {
        return view('service_requests.invoice.welcome');
    }

    public function login($access_token = null)
    {
        $user_id = '';
        if ($access_token) {

            if (env('APP_ENV') == 'production' OR env('APP_ENV') == 'testing') {
                $url_base = "https://accounts.claveunica.gob.cl/openid/userinfo";

                try {
                    $response = Http::withToken($access_token)->post($url_base);
                } catch(ConnectionException $e) {
                    session()->flash('danger', 'Disculpe, no nos pudimos conectar con Clave Única, por favor intente más tarde.');

                    // logger()->info('Clave Única Time out en userinfo', [
                    //     'cu_access_token' => $access_token,
                    //     'error_de_cu' => $e->getMessage(),
                    // ]);

                    return redirect()->route('invoice.welcome');
                }

                if($response->getStatusCode() == 200) {
                    $user_cu = json_decode($response);
                    $user_id = $user_cu->RolUnico->numero;
                }
                else {
                    // return redirect()->route('invoice.welcome');

                    /** Este fragmento es para logear en caso de bloqueo de CU a través de WSSI */
                    $url = env('WSSSI_CHILE_URL').'/claveunica/login/'.$access_token;
                    try {
                        $response_wssi = Http::get($url);
                    } catch(ConnectionException $e) {
                        session()->flash('danger', 'Disculpe, no nos pudimos conectar con Clave Única, por favor intente más tarde.');

                        // logger()->info('Clave Única Time out en bypass', [
                        //     'cu_access_token' => $access_token,
                        //     'error_de_cu' => $e->getMessage(),
                        // ]);

                        return redirect()->route('invoice.welcome');
                    }

                    $user_cu = json_decode($response_wssi);

                    if($user_cu){
                        $user_id = $user_cu->RolUnico->numero;

                        // logger()->info('Utilizando el ByPass de CU a través del WSSI', [
                        //     'cu_access_token' => $access_token,
                        //     'error_de_cu' => $response->body(),
                        // ]);

                    }
                    else{
                        // logger()->info('ByPass - $user_cu - vacío', [
                        //     'user_cu' => $user_cu,
                        // ]);
                        return view('service_requests.invoice.welcome');
                    }
                }
                
            } else if (env('APP_ENV') == 'local') {
                $user_id = $access_token;
            }
            if($user_id)
            {
                return $this->show($user_id);
            }
        }
    }


    public function show($user_id)
    {
        //$serviceRequests = ServiceRequest::where('user_id',$user_id)->get();

        //$fulfillment = Fulfillment::whereHas('ServiceRequest', function($query, use $user_id) { $query->where('user_id',$user_id);})->orderBy('payment_date')->get();

        $fulfillments = Fulfillment::whereHas('ServiceRequest', function($query) use ($user_id) {
            $query->where('user_id',$user_id);}
            )->orderBy('year', 'DESC')->orderBy('month', 'DESC')->get();

        $bankaccount = UserBankAccount::where('user_id',$user_id)->get();

        $user = User::find($user_id);

        //if(!$user)  logger("Invocie Login: No existe el usuario en la bd ", ['user_id' => $user_id]);
        
        return view('service_requests.invoice.show', compact('fulfillments','bankaccount','user'));
    }


}
