<?php

namespace App\Http\Controllers\Rrhh;

use App\Rrhh\NewAuthority;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Rrhh\OrganizationalUnit;
use Illuminate\Support\Facades\Auth;
use App\Models\Parameters\Holiday;
use DateInterval;
use DatePeriod;

class NewAuthorityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $ouTopLevels = OrganizationalUnit::with([
            'childs',
            'childs.childs',
            'childs.childs.childs.childs',
            'childs.childs.childs.childs.childs'
        ])->where('level', 1)->get();


        return view('rrhh.new_authorities.index', compact('ouTopLevels'));
    }

    public function calendar(OrganizationalUnit $organizationalUnit)
    {
        $calendar = [];
        $holidays = Holiday::all();        
        return view('rrhh.new_authorities.calendar', [
            'calendar' => $calendar,
            'ou' => $organizationalUnit,
            'holidays' => $holidays
        ]);
    }

}
