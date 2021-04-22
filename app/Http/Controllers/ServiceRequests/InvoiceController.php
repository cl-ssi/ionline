<?php

namespace App\Http\Controllers\ServiceRequests;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Rrhh\UserBankAccount;
use Illuminate\Support\Facades\Http;
use App\Models\ServiceRequests\ServiceRequest;
use App\Models\ServiceRequests\Fulfillment;
use App\User;


class InvoiceController extends Controller
{
    //

    public function welcome()
    {
        return view('service_requests.invoice.welcome');
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
                $user_id = $user_cu->RolUnico->numero;
                // $user = $user.'-'.$user_cu->RolUnico->DV;


            } else if (env('APP_ENV') == 'local') {
                $user_id = $access_token;

            }
            return $this->show($user_id);
        }
    }


    public function show($user_id)
    {
        //$serviceRequests = ServiceRequest::where('user_id',$user_id)->get();

        //$fulfillment = Fulfillment::whereHas('ServiceRequest', function($query, use $user_id) { $query->where('user_id',$user_id);})->orderBy('payment_date')->get();



        $fulfillments = Fulfillment::whereHas('ServiceRequest', function($query) use ($user_id) { 
            $query->where('user_id',$user_id);}
            )->orderBy('payment_date')->get();

        $bankaccount = UserBankAccount::where('user_id',$user_id)->get();

        $user = User::find($user_id);

        
        return view('service_requests.invoice.show', compact('fulfillments','bankaccount','user'));
    }


}
