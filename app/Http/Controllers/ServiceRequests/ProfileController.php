<?php

namespace App\Http\Controllers\ServiceRequests;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Models\ServiceRequests\ServiceRequest;

class ProfileController extends Controller
{
    //
    public function show(Request $request, User $user, $year = null, $type = null, ServiceRequest $serviceRequest = null, $period = null)
    {
        /** Si no se especificó un año, pasamos el actual por defecto */
        if(!$year) {
            return redirect()->route('rrhh.service-request.show', [
                'user' => $user->id, 
                'year' => date('Y')
            ]);
            
        }

        if($serviceRequest) {
            $periods = array();

            /* Llenar el arreglo con números del 1 al 12 como índice y false como valor */
            for ($i = 1; $i <= 12; $i++) {
                $periods[$i] = false;
                
            }

            $meses = array(
                1 => "Ene",
                2 => "Feb",
                3 => "Mar",
                4 => "Abr",
                5 => "May",
                6 => "Jun",
                7 => "Jul",
                8 => "Ago",
                9 => "Sep",
                10 => "Oct",
                11 => "Nov",
                12 => "Dic"
            );

            $periodsAvailables = $serviceRequest->fulfillments->pluck('month')->toArray();
            foreach($periodsAvailables as $periodAvailable) {
                $periods[$periodAvailable] = true;
            }


            if($period) {
                $fulfillment = $serviceRequest->fulfillments->where('month',$period)->first();
            }
        }

        return view('service_requests.profile.show', compact(
            'user',
            'year',
            'type',
            'serviceRequest',
            'period',
            'periods',
            'meses',
            'fulfillment'
        ));
        
    }
}
