<?php

namespace App\Http\Controllers\Programmings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Programmings\ProgrammingDay;

class ProgrammingDayController extends Controller
{
    public function index()
    {
        $professionals = ProgrammingDay::All()->SortBy('id');
        return view('programmings/programmingDays/index')->withProgrammingDays($professionals);
    }

    public function show(Request $request, $id)
    {
        $programmingDays = ProgrammingDay::where('programming_id',$id)->first();
        return view('programmings/programmingDays/index')->withProgrammingDays($programmingDays);
    }
}
