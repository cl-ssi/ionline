<?php

namespace App\Http\Controllers\ProfAgenda;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\ProfAgenda\ActivityType;
use App\Models\ProfAgenda\Proposal;

class AgendaController extends Controller
{
    public function index(Request $request)
    {
        $activity_types = ActivityType::all();
        $user_id_param = $request->user_id;
        $profession_id = $request->profession_id;
        $proposals = Proposal::where('user_id',$user_id_param)
                            ->where('profession_id',$profession_id)
                            ->get();

        return view('prof_agenda.agenda',compact('request','proposals','activity_types'));
    }

    public function booking(Request $request)
    {
        $activity_types = ActivityType::all();
        $user_id_param = $request->user_id;
        $profession_id = $request->profession_id;
        $proposals = Proposal::where('user_id',$user_id_param)
                            ->where('profession_id',$profession_id)
                            ->get();
        return view('prof_agenda.booking_agenda',compact('request','proposals','activity_types'));
    }
}
