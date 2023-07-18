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
        if($request->method() == 'POST') {
            if($request->input('id')) {

                $serviceRequest = ServiceRequest::findOrFail($request->input('id'));
                
                return redirect()->route('rrhh.service-request.show', [
                    'user' => $serviceRequest->user_id, 
                    'year' => $serviceRequest->start_date->year,
                    'type' => $serviceRequest->working_day_type,
                    'serviceRequest' => $serviceRequest,
                ]);
            }
            if($request->input('user_id')) {
                return redirect()->route('rrhh.service-request.show', [
                    'user' => $request->input('user_id'), 
                    'year' => date('Y')
                ]);
            }
        }

        /** Si no se especificó un año, pasamos el actual por defecto */
        if(!$year) {
            return redirect()->route('rrhh.service-request.show', [
                'user' => $user->id, 
                'year' => date('Y')
            ]);
        }

        /** 
         * TODO: Si es de tipo horas, entonces tiene 1 solo periodo,
         * dejemos seteada la URL con el único periodo para evitar 
         * que tengan que hacer click en el periodo (fulfillment)
         * 
         * Revisar si es de tipo hora, que pasa con las aprobaciones de RRHH y Finansas
         */


        $fulfillment = null;
        if($serviceRequest) {
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
            'fulfillment'
        ));
        
    }
}
