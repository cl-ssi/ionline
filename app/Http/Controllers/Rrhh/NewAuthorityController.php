<?php

namespace App\Http\Controllers\Rrhh;

use App\Rrhh\NewAuthority;
use App\User;
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
        if (auth()->user()->can('Authorities: all')) {
            $ouTopLevels = OrganizationalUnit::where('level', 1)->get();
            return view('rrhh.new_authorities.index', compact('ouTopLevels'));
        } else {
            $ouTopLevels = OrganizationalUnit::where('level', 1)->where('establishment_id', auth()->user()->organizationalUnit->establishment->id)->get();
            return view('rrhh.new_authorities.index', compact('ouTopLevels'));
        }
    }

    public function calendar(OrganizationalUnit $organizationalUnit)
    {
        $holidays = Holiday::select('name', 'date')->get();
        $newAuthoritiesManager = NewAuthority::with(['user' => function ($query) {
            $query->select('id', 'name', 'fathers_family');
        }])
            ->where('organizational_unit_id', $organizationalUnit->id)
            ->where('type', 'manager')
            ->get();

        $newAuthoritiesDelegate = NewAuthority::with(['user' => function ($query) {
            $query->select('id', 'name', 'fathers_family');
        }])
            ->where('organizational_unit_id', $organizationalUnit->id)
            ->where('type', 'delegate')
            ->get();

        $newAuthoritiesSecretary = NewAuthority::with(['user' => function ($query) {
            $query->select('id', 'name', 'fathers_family');
        }])
            ->where('organizational_unit_id', $organizationalUnit->id)
            ->where('type', 'secretary')
            ->get();

        $subrogants = Subrogation::with(['subrogant'])
            ->where('organizational_unit_id', $organizationalUnit->id)
            ->select('id', 'subrogant_id')
            ->get();

        return view('rrhh.new_authorities.calendar', [
            'ou' => $organizationalUnit,
            'holidays' => $holidays,
            'newAuthorities' => $newAuthoritiesManager,
            'newAuthoritiesDelegate' => $newAuthoritiesDelegate,
            'newAuthoritiesSecretary' => $newAuthoritiesSecretary,
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

    public function update(Request $request, OrganizationalUnit $organizationalUnit)
    {
        $validatedData = $request->validate([
            'user_id' => 'required|exists:users,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);
        
        $user = User::find($validatedData['user_id']);
        $startDate = Carbon::parse($validatedData['start_date']);
        $endDate = Carbon::parse($validatedData['end_date']);
        $authorityThatDay = NewAuthority::where('organizational_unit_id', $organizationalUnit->id)->where('date', $startDate)->where('type', 'manager')->first();
        if ($request->updateFutureEventsCheck == 1) {
            $maxValue = NewAuthority::where('organizational_unit_id', $organizationalUnit->id)->where('type', 'manager')->where('user_id',$authorityThatDay->user_id)->max('date');
            $maxDate = Carbon::parse($maxValue);
            while ($startDate->lte($maxDate)) {
                $updateAuthority = NewAuthority::where('date', $startDate)
                ->where('user_id', $authorityThatDay->user_id)
                ->where('type', 'manager')->first();
                
                if ($updateAuthority) {
                    $updateAuthority->user_id = $user->id;
                    $updateAuthority->save();
                        }
                $startDate->addDay();
            }
            session()->flash('info', 'El usuario  ' . $user->full_name . ' ha sido dejado como autoridad  para todos los eventos a futuro de la antigua autoridad ' . $authorityThatDay->user->full_name.' Siendo la última fecha que tenia asignado como autoridad'.$maxValue);
        } else {
            NewAuthority::where('organizational_unit_id', $organizationalUnit->id)
                ->where('type', 'manager')
                ->whereBetween('date', [$startDate, $endDate])
                ->update([
                    'user_id' => $user->id,
                ]);
    
            session()->flash('info', 'El usuario subrogante ' . $user->full_name . ' ha sido dejado como subrogante desde ' . $validatedData['start_date'] . ' hasta ' . $validatedData['end_date']);
            
        }
        return redirect()->route('rrhh.new-authorities.calendar', $organizationalUnit->id);
    }

    public function create_subrogant(OrganizationalUnit $organizationalUnit)
    {
        return view('rrhh.new_authorities.create_subrogant');
    }
}