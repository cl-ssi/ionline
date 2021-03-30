<?php

namespace App\Http\Controllers\Rrhh;

use App\Http\Controllers\Controller;
use App\Models\Rrhh\Attendance;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $attendances = Attendance::all();

        return view('rrhh.attendances.index', compact('attendances'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function import()
    {
        return view('rrhh.attendances.import');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $attendances = $request->file('attendances_file')->get();
        $separator = "\r\n";
        $line = strtok($attendances, $separator);

        //echo "<pre>";
        while ($line !== false) {
            # do something with $line
            $line = strtok( $separator );
            #001,01,01,0016865601,0000000000,07,44,01,01,21,00,00,00,00,00,0000000000,0000000000, 0.00, 0.00
            $array = explode(',',$line);
            //print_r($array);
            if(count($array) >= 2){
                Attendance::create([
                    'user_id' => intval($array[3]),
                    'type' => $array[2],
                    'timestamp' => '20'.$array[9].'-'.$array[7].'-'.$array[8].' '.$array[5].':'.$array[6],
                    'clock_id' => 1
                ]);
            }

        }

        $attendances = Attendance::all();
        return view('rrhh.attendances.import', compact('attendances'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Rrhh\Attendance  $attendance
     * @return \Illuminate\Http\Response
     */
    public function show(Attendance $attendance)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Rrhh\Attendance  $attendance
     * @return \Illuminate\Http\Response
     */
    public function edit(Attendance $attendance)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Rrhh\Attendance  $attendance
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Attendance $attendance)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Rrhh\Attendance  $attendance
     * @return \Illuminate\Http\Response
     */
    public function destroy(Attendance $attendance)
    {
        //
    }
}
