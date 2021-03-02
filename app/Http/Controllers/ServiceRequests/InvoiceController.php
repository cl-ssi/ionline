<?php

namespace App\Http\Controllers\ServiceRequests;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use App\Models\ServiceRequests\ServiceRequest;


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

                $sr = ServiceRequest::where('rut',$user_cu->RolUnico->numero)->first();
            //     if($sr) {
                    
            //     }
            //     else {
            //         //$vaccination = new Vaccination();
            //         ''
            //     }
            // } elseif (env('APP_ENV') == 'local') {
            //     $vaccination = Vaccination::where('run',15287582)->first();
            //     if($vaccination) {
            //         $vaccination->dv = 7;
            //         $vaccination->name = "Alvaro";
            //         $vaccination->fathers_family = "Torres";
            //         $vaccination->mothers_family = "Fuschslocher";
            //         $vaccination->personal_email = "email@email.com";
            //     }
            //     else {
            //         $vaccination = new Vaccination();
            //     }
            }
            return $this->show($sr);
        }
    }


    public function show(ServiceRequest $sr)
    {
        return view('service_requests.invoice.show', compact('sr'));
    }


}
