<?php

namespace App\Livewire\ProfAgenda;

use Livewire\Component;
use App\Models\Parameters\Parameter;
use Illuminate\Support\Facades\Auth;
use App\Models\Parameters\Profession;
use App\Notifications\ProfAgenda\NewReservation;
use App\Models\User;
use App\Models\ProfAgenda\ActivityType;
use App\Models\ProfAgenda\OpenHour;

class BookingAgenda extends Component
{
    public $professions;
    public $profession;
    public $professionId;
    public $showStep1 = true;
    public $showStep2 = false;
    public $showStep3 = false;
    public $showStep4 = false;
    public $activityTypes;
    public $activityType;
    public $users;
    public $openHours;
    public $users_with_openhours;

    public function mount()
    {
        $professions = explode(',', Parameter::where('parameter', 'profesiones_ust')->pluck('value')->toArray()[0]);
        $this->professions = Profession::whereIn('id', $professions)->get();
    }

    public function goToStep2($professionId)
    {
        $this->professionId = $professionId;
        $this->showStep1 = false;
        $this->showStep2 = true;
        $this->showStep3 = false;
        $this->showStep4 = false;

        $this->profession = Profession::where('id', $professionId)
            ->with(['agendaProposals' => function ($q) {
                return $q->where('status', 'Aperturado')
                    ->where('end_date', '>=', now()->format('Y-m-d'));
            }])->first();

        // Si es HAH, solo muestra información de su establecimiento.
        $hah_flag = auth()->user()->establishment_id == 41;

        // Profesionales encontrados
        $users = User::whereIn('id', $this->profession->agendaProposals->pluck('user_id'))
            ->when($hah_flag, function ($q) {
                return $q->where('establishment_id', 41);
            })
            ->get();

        $this->users = $users;

        $uniqueActivityTypes = [];
        foreach ($users as $user) {
            $activityTypes = ActivityType::whereIn('id', $user->employeeOpenHours->pluck('activity_type_id')->unique())
                ->where('auto_reservable', true)
                ->get();

            foreach ($activityTypes as $activityType) {
                $uniqueActivityTypes[$activityType->id] = $activityType;
            }
        }
        $this->activityTypes = array_values($uniqueActivityTypes);
    }

    public function goToStep3($activityTypeId)
    {
        $this->showStep1 = false;
        $this->showStep2 = false;
        $this->showStep3 = true;
        $this->showStep4 = false;

        $hah_user = auth()->user()->establishment_id == 41;

        $this->activityType = ActivityType::find($activityTypeId);

        $this->openHours = OpenHour::where('activity_type_id', $activityTypeId)
            ->whereIn('profesional_id', $this->users->pluck('id'))
            ->where('start_date', '>=', now())
            ->whereNull('patient_id')
            ->where('blocked', 0)
            ->when($hah_user, function ($q) {
                return $q->whereHas("profesional", function ($subQuery) {
                    $subQuery->where('establishment_id', 41);
                });
            })
            ->get();

        $this->users_with_openhours = User::whereIn('id', $this->openHours->pluck('profesional_id')->unique())->get();
    }

    public function goToStep1()
    {
        $this->showStep1 = true;
        $this->showStep2 = false;
        $this->showStep3 = false;
        $this->showStep4 = false;
    }

    public function saveReservation($id)
    {
        $openHour = OpenHour::find($id);

        $othersReservationsCount = OpenHour::where('patient_id', auth()->user()->id)
            ->where(function ($query) use ($openHour) {
                $query->whereBetween('start_date', [$openHour->start_date, $openHour->end_date])
                    ->orWhereBetween('end_date', [$openHour->start_date, $openHour->end_date]);
            })
            ->where('profesional_id', '<>', $openHour->profesional_id)
            ->where('id', '<>', $openHour->id)
            ->whereHas('activityType')
            ->count();

        if ($othersReservationsCount > 0) {
            session()->flash('message', 'No es posible realizar la reserva, porque ya tienes otra reserva a la misma hora con otro funcionario.');
            return;
        }

        $allow_consecutive_days = $openHour->activityType->allow_consecutive_days;
        $maximum_allowed_per_week = $openHour->activityType->maximum_allowed_per_week;

        if ($allow_consecutive_days == 0) {
            $previousDay = $openHour->start_date->copy()->subDay();
            $nextDay = $openHour->start_date->copy()->addDay();

            $consecutiveReservations = OpenHour::where('patient_id', auth()->user()->id)
                ->where(function ($query) use ($previousDay, $nextDay, $openHour) {
                    $query->whereDate('start_date', $previousDay)
                        ->orWhereDate('start_date', $openHour->start_date)
                        ->orWhereDate('start_date', $nextDay);
                })
                ->whereHas('activityType')
                ->where('id', '<>', $openHour->id)
                ->where('profesional_id', $openHour->profesional_id)
                ->count();

            if ($consecutiveReservations > 0) {
                session()->flash('message', 'No es posible realizar la reserva, porque este bloque está configurado para no ser reservado días consecutivos.');
                return;
            }
        }

        if ($maximum_allowed_per_week > 0) {
            $countReservations = OpenHour::where('patient_id', auth()->user()->id)
                ->whereBetween('start_date', [$openHour->start_date->startOfWeek(), $openHour->end_date->endOfWeek()])
                ->where('id', '<>', $openHour->id)
                ->whereHas('activityType')
                ->where('profesional_id', $openHour->profesional_id)
                ->count();

            if (($countReservations + 1) > $maximum_allowed_per_week) {
                session()->flash('message', 'No es posible realizar la reserva, porque la configuración de este bloque acepta como máximo ' . $maximum_allowed_per_week . ' reservas a la semana.');
                return;
            }
        }

        if ($openHour->patient_id) {
            session()->flash('message', 'El bloque ya se encuentra reservado, intente nuevamente.');
            return;
        }

        if ($openHour->blocked == 1) {
            session()->flash('message', 'El bloque no se encuentra disponible, intente nuevamente.');
            return;
        }

        $openHour->patient_id = auth()->user()->id;
        $openHour->reserver_id = auth()->user()->id;
        $openHour->save();

        if ($openHour->patient && $openHour->patient->email != null) {
            $openHour->patient->notify(new NewReservation($openHour));
        }

        session()->flash('message', 'Se registró la reserva.');

        $this->showStep1 = false;
        $this->showStep2 = false;
        $this->showStep3 = false;
        $this->showStep4 = true;
    }

    public function render()
    {
        return view('livewire.prof-agenda.booking-agenda');
    }
}
