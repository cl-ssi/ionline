<?php

namespace App\Http\Controllers\Rrhh;

use App\Rrhh\NewAuthority;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Rrhh\OrganizationalUnit;
use App\Models\Parameters\Holiday;
use App\Models\Profile\Subrogation;
use Carbon\Carbon;

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
        $holidays = Holiday::all();
        $newAuthorities = NewAuthority::where('organizational_unit_id', $organizationalUnit->id)->get();
        $subrogants = Subrogation::where('organizational_unit_id', $organizationalUnit->id)->get();        
        return view('rrhh.new_authorities.calendar', [
            'ou' => $organizationalUnit,
            'holidays' => $holidays,
            'newAuthorities' => $newAuthorities,
            'subrogants' => $subrogants,
        ]);
    }

    public function create(OrganizationalUnit $organizationalUnit)
    {
        return view('rrhh.new_authorities.create', [
            'ou' => $organizationalUnit,
        ]);
    }

    public function store(Request $request)
    {
        $from = Carbon::createFromFormat('Y-m-d', $request->from);
        $to = Carbon::createFromFormat('Y-m-d', $request->to);
    
        if ($from > $to) {
            session()->flash('warning', 'La fecha "Desde" no puede ser mayor que la fecha "Hasta".');
            return redirect()->back();
        }
    
        $days = $to->diffInDays($from) + 1;
    
        for ($i = 0; $i < $days; $i++) {
            $date = $from->copy()->addDays($i);
    
            $existingAuthority = NewAuthority::whereBetween('date', [$from, $to])
                ->where('organizational_unit_id', $request->organizational_unit_id)
                ->where('type', $request->type)
                ->first();

            
    
            if ($existingAuthority) {
                session()->flash('warning', 'Ya existe una autoridad para la fecha ' . $date->format('Y-m-d') . ' y unidad organizacional seleccionada.');
                return redirect()->back();
            }
    
            $newAuthority = new NewAuthority();
            $newAuthority->user_id = $request->user_id;
            $newAuthority->representation_id = $request->representation_id;
            $newAuthority->date = $date;
            $newAuthority->position = $request->position;
            $newAuthority->type = $request->type;
            $newAuthority->organizational_unit_id = $request->organizational_unit_id;
            $newAuthority->decree = $request->decree;
            $newAuthority->save();
        }
    
        session()->flash('info', 'El usuario ' . $newAuthority->user->fullname . ' ha sido creado como autoridad de la unidad organizacional para ' . $days . ' días.');
        return redirect()->route('rrhh.new-authorities.calendar', $newAuthority->organizational_unit_id);
    }

    

}
