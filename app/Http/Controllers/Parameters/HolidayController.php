<?php

namespace App\Http\Controllers\Parameters;

use App\Models\Parameters\Holiday;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HolidayController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //Holiday::whereYear('date', '=', date('Y'))->get()
        $holidays = Holiday::All();
        return view('parameters/holidays/index')->withHolidays($holidays);
    }
}
