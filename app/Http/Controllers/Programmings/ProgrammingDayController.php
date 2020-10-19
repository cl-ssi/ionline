<?php

namespace App\Http\Controllers\Programmings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Programmings\ProgrammingDay;

class ProgrammingDayController extends Controller
{
    public function index(Request $request)
    {
        $programmingDays = ProgrammingDay::where('programming_id',$request->programming_id)->first();
        return view('programmings/programmingDays/index')->withProgrammingDays($programmingDays);
    }

    public function show(Request $request, $id)
    {
        $programmingDays = ProgrammingDay::where('programming_id',$id)->first();
        return view('programmings/programmingDays/index')->withProgrammingDays($programmingDays);
    }

    public function store(Request $request)
    {
        //dd($request);
        $programmingDays = new ProgrammingDay($request->All());
        $programmingDays->save();
        return redirect()->back();
    }

    public function update(Request $request, $id)
    {
      
      $programmingDays = ProgrammingDay::where('id', $id)->first();
      $programmingDays->fill($request->all());
      $programmingDays->save();
      return redirect()->back();
    }
}
