<?php

namespace App\Http\Controllers\Rrhh;

use App\Models\Rrhh\Authority;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Rrhh\OrganizationalUnit;
use App\Models\Parameters\Holiday;
use App\Models\Profile\Subrogation;
use Carbon\Carbon;


class AuthorityController extends Controller
{
    
    
    /**
     * Display a listing of the resource.
     * Código para probar si se implemento bien los cambios de funciones a newAuthority
     */
    public function test()
    {
        $ou_id = 20; // cambiar por el id de una unidad organizacional válida

        $authority = Authority::getTodayAuthorityManagerFromDate($ou_id);

        if ($authority) {
            echo "Se ha encontrado un jefe de hoy para la unidad organizacional con id " . $ou_id . ":";
            echo "\nNombre: " . $authority->user->fullname;
            echo "\nCargo: " . $authority->position;
        } else {
            echo "No se ha encontrado un jefe para hoy para la unidad organizacional con id " . $ou_id;
        }
    }
    
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //TODO Deberia ser al reves de los establecimientos a OU
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
        $subrogants = Subrogation::with(['subrogant'])
            ->where('organizational_unit_id', $organizationalUnit->id)
            ->select('id', 'subrogant_id', 'type')
            ->get();

        return view('rrhh.new_authorities.calendar', [
            'ou' => $organizationalUnit,
            'subrogants' => $subrogants,
        ]);
    }



    public function getEvents(OrganizationalUnit $organizationalUnit)
    {
        $newAuthorities = Authority::with(['user' => function ($query) {
            $query->select('id', 'name', 'fathers_family');
        }])
            ->where('organizational_unit_id', $organizationalUnit->id)
            ->whereIn('type', ['manager', 'delegate', 'secretary'])
            ->get();
        $events = [];
    
        foreach ($newAuthorities as $authority) {
            $backgroundColor = '';
            if ($authority->type->value == 'delegate') {
              $backgroundColor = '#6c757d';
            } elseif ($authority->type->value == 'secretary') {
              $backgroundColor = '#ffc107';
            } elseif ($authority->type->value == 'manager') {
              $backgroundColor = '#007bff';
            }
            $event = [
                'title' => $authority->user->tinyName,
                'start' => $authority->date,
                'end' => $authority->date,
                'backgroundColor' => $backgroundColor,
                'type' => $authority->type->value,
                // agrega más campos aquí si los necesitas
            ];
            $events[] = $event;
        }
        
        $holidays = Holiday::select('name', 'date')->get();
        
        foreach ($holidays as $holiday) {
            $event = [
                'title' => $holiday->name,
                'start' => $holiday->date,
                'end' => $holiday->date,
                'backgroundColor' => '#FF0000',
                
            ];
            $events[] = $event;
        }
    
        return json_encode($events);
    }
    


    public function create(OrganizationalUnit $organizationalUnit)
    {
        return view('rrhh.new_authorities.create', [
            'ou' => $organizationalUnit,
        ]);
    }

    public function store(Request $request)
    {
        //TODO tratar de no basarme en el copy paste del original y ocupar la validacion del update
        $from = Carbon::createFromFormat('Y-m-d', $request->from);
        $to = Carbon::createFromFormat('Y-m-d', $request->to);

        if ($from > $to) {
            session()->flash('warning', 'La fecha "Desde" no puede ser mayor que la fecha "Hasta".');
            return redirect()->back();
        }

        $days = (int) $to->diffInDays($from) + 1;

        for ($i = 0; $i < $days; $i++) {
            $date = $from->copy()->addDays($i);

            //TODO deberia estar afuera la validacion de si existe autoridad
            $existingAuthority = Authority::whereBetween('date', [$from, $to])
                ->where('organizational_unit_id', $request->organizational_unit_id)
                ->where('type', $request->type)
                ->first();



            if ($existingAuthority) {
                session()->flash('warning', 'Ya existe una autoridad para la fecha ' . $date->format('Y-m-d') . ' y unidad organizacional seleccionada.');
                return redirect()->back();
            }

            //buscar la diferencia de request->input('user_id) 
            $newAuthority = new Authority();
            $newAuthority->user_id = $request->user_id;
            $newAuthority->representation_id = $request->representation_id;
            $newAuthority->date = $date;
            $newAuthority->position = $request->position;
            $newAuthority->type = $request->type;
            $newAuthority->organizational_unit_id = $request->organizational_unit_id;
            $newAuthority->decree = $request->decree;
            $newAuthority->save();
        }

        session()->flash('info', 'El usuario ' . $newAuthority->user->fullName . ' ha sido creado como autoridad de la unidad organizacional para ' . $days . ' días.');
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
        $authorityThatDay = Authority::where('organizational_unit_id', $organizationalUnit->id)->where('date', $startDate)->where('type', 'manager')->first();
        if ($request->updateFutureEventsCheck == 1) {
            $maxValue = Authority::where('organizational_unit_id', $organizationalUnit->id)->where('type', 'manager')->where('user_id', $authorityThatDay->user_id)->max('date');
            //TODO quitar el maxdate
            $maxDate = Carbon::parse($maxValue);
            while ($startDate->lte($maxDate)) {
                //TODO cambiar el comportamiento de que reemplace todo (hasta la fecha)
                $updateAuthority = Authority::where('date', $startDate)
                    ->where('user_id', $authorityThatDay->user_id)
                    ->where('type', 'manager')->first();

                if ($updateAuthority) {
                    $updateAuthority->user_id = $user->id;
                    $updateAuthority->save();
                }
                $startDate->addDay();
            }
            session()->flash('info', 'El usuario  ' . $user->full_name . ' ha sido dejado como autoridad  para todos los eventos a futuro de la antigua autoridad ' . $authorityThatDay->user->full_name . ' Siendo la última fecha que tenia asignado como autoridad' . $maxValue);
        } else {
            Authority::where('organizational_unit_id', $organizationalUnit->id)
                ->where('type', 'manager')
                ->whereBetween('date', [$startDate, $endDate])
                ->update([
                    'user_id' => $user->id,
                ]);

            session()->flash('info', 'El usuario subrogante ' . $user->fullName . ' ha sido dejado como subrogante desde ' . $validatedData['start_date'] . ' hasta ' . $validatedData['end_date']);
        }
        return redirect()->route('rrhh.new-authorities.calendar', $organizationalUnit->id);
    }

    public function create_subrogant(OrganizationalUnit $organizationalUnit)
    {
        return view('rrhh.new_authorities.create_subrogant');
    }
}
