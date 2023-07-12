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

        $workingDayTypes = ServiceRequest::where('user_id', $run)->whereYear('request_date', $year)
            ->distinct()
            ->pluck('working_day_type');

        $serviceRequests = ServiceRequest::where('user_id', $run)->whereYear('request_date', $year)->where('working_day_type', $type)->get();

        $serviceRequestId = null;

        if ($id) {
            $serviceRequestId = ServiceRequest::findOrFail($id);
        }





        return view('service_requests.profile.show', compact('request', 'user', 'year', 'type', 'workingDayTypes', 'serviceRequests', 'id', 'serviceRequestId'));
    }
}
