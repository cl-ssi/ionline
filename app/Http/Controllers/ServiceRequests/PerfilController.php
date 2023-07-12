<?php

namespace App\Http\Controllers\ServiceRequests;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Models\ServiceRequests\ServiceRequest;

class PerfilController extends Controller
{
    //
    public function show(Request $request, $run, $year = null, $type = null)
    {

        $user = User::findOrFail($run);

        

        $workingDayTypes = ServiceRequest::where('user_id', $run)
            ->distinct()
            ->pluck('working_day_type');


        return view('service_requests.profile.show', compact('request', 'user', 'year', 'workingDayTypes'));
    }
}
