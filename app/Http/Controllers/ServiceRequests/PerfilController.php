<?php

namespace App\Http\Controllers\ServiceRequests;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Models\ServiceRequests\ServiceRequest;

class PerfilController extends Controller
{
    //
    public function show(Request $request, $run, $year = null, $type = null, $id = null)
    {

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





            $yearsRange[$year] = in_array($year, $yearsWithServiceRequests) ??  false;
        return view('service_requests.profile.show', compact('request', 'yearsRange','user', 'year', 'type', 'working_day_types', 'serviceRequests', 'id', 'serviceRequestId'));
    }
}
