<?php

namespace App\Http\Controllers\ServiceRequests;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Models\ServiceRequests\ServiceRequest;

class PerfilController extends Controller
{
    //
    public function show(Request $request, $run, $year = null, $type = null, $id = null, $period = null)
    {

        $fulfillment = null;
        $working_day_types = null;
        $periods = null;
        $meses = null;

        $user = User::findOrFail($run);

        /** Años en que tiene contratos */
        $yearsWithServiceRequests = ServiceRequest::where('user_id', $user->id)
            ->distinct()
            ->selectRaw('YEAR(start_date) as year')
            ->pluck('year')
            ->toArray();

        /** Array con rango de años entre el 2020 y el actual, todos seteados en false */
        $yearsRange = array_fill_keys(range(2020, date('Y')), false);

        /** Dejamos en true sólo aquellos que tiene contratos */
        foreach($yearsRange as $yearName => $value) {
            $yearsRange[$yearName] = in_array($yearName, $yearsWithServiceRequests) ??  false;
        }

        /**
         * Ej: dd($yearsRange) 
         * array:4 [
         *   2020 => false
         *   2021 => false
         *   2022 => true
         *   2023 => true
         * ]
         */

        if($year) {
            $working_day_types = [
                "DIURNO" => false,
                "HORA EXTRA" => false,
                "HORA MÉDICA" => false,
                "TERCER TURNO" => false,
                "TERCER TURNO - MODIFICADO" => false,
                "CUARTO TURNO" => false,
                "CUARTO TURNO - MODIFICADO" => false,
                "TURNO DE REEMPLAZO" => false,
                "VESPERTINO" => false,
                // "TURNO EXTRA" => false,
                // "OTRO" => false,
                // "DIURNO PASADO A TURNO" => false,
                // "DIARIO" => false
            ];
    
            $workingDayTypes = ServiceRequest::where('user_id', $run)
                ->whereYear('request_date', $year)
                ->distinct()
                ->pluck('working_day_type')
                ->toArray();
    
            /** Dejamos en true sólo aquellos que tiene contratos */
            foreach($working_day_types as $typeName => $value) {
                $working_day_types[$typeName] = in_array($typeName, $workingDayTypes) ??  false;
            }
        }

        // dd($working_day_types);

        $serviceRequests = ServiceRequest::where('user_id', $run)->whereYear('start_date', $year)->where('working_day_type', $type)->orderBy('start_date')->get();

        $serviceRequestId = null;

        if ($id) {
            $serviceRequestId = ServiceRequest::findOrFail($id);
        }


        if($id) {
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

            $periodsAvailables = $serviceRequestId->fulfillments->pluck('month')->toArray();
            foreach($periodsAvailables as $periodAvailable) {
                $periods[$periodAvailable] = true;
            }


            if(isset($period)) {
                $fulfillment = $serviceRequestId->fulfillments->where('month',$period)->first();
            }

            // dd($fulfillment);
        }



            $yearsRange[$year] = in_array($year, $yearsWithServiceRequests) ??  false;
        return view('service_requests.profile.show', compact(
            'request', 
            'yearsRange',
            'user',
            'year',
            'type',
            'working_day_types',
            'serviceRequests', 
            'id', 
            'serviceRequestId',
            'periods',
            'period',
            'meses',
            'fulfillment',
        ));
    }
}
