<?php

namespace App\Http\Controllers\ServiceRequests;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\ServiceRequests\ServiceRequest;

class ProfileController extends Controller
{
    //
    public function show(Request $request, User $user = null, $year = null, $type = null, ServiceRequest $serviceRequest = null, $period = null)
    {
        if($request->method() == 'POST') {
            if($request->input('id')) {

                $serviceRequest = ServiceRequest::findOrFail($request->input('id'));
                
                return redirect()->route('rrhh.service-request.show', [
                    'user' => $serviceRequest->user_id, 
                    'year' => $serviceRequest->start_date->year,
                    'type' => $serviceRequest->program_contract_type,
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

        /** Si no se especificó un usuario, mostramos la vista solo con los filtros */
        if(!$user) {
            return view('service_requests.profile.show', compact('user'));
        }

        /** Si no se especificó un año, pasamos el actual por defecto */
        if($user AND !$year) {
            return redirect()->route('rrhh.service-request.show', [
                'user' => $user->id, 
                'year' => date('Y')
            ]);
        }

        /**
         * TODO: Revisar si es de tipo hora, que pasa con las aprobaciones de RRHH y Finansas
         */


        $fulfillment = null;

        if($serviceRequest) {
            if($period) {
                $fulfillment = $serviceRequest->fulfillments->where('month',$period)->first();
            }
            /** 
             * Si tiene 1 solo periodo, dejemos seteada la URL para que aparezca 
             * cargada la pagina con el periodo selecionado (fulfillment)
             */
            else if($serviceRequest->fulfillments->count() == 1){
                return redirect()->route('rrhh.service-request.show', [
                    'user' => $serviceRequest->user_id, 
                    'year' => $serviceRequest->start_date->year,
                    'type' => $serviceRequest->program_contract_type,
                    'serviceRequest' => $serviceRequest,
                    'period' => $serviceRequest->fulfillments->first()->month ?? null,
                ]);
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
