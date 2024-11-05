<?php

namespace App\Livewire\ProfAgenda;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\Parameters\Profession;
use App\Models\ProfAgenda\Proposal;
use App\Models\User;
use App\Models\Parameters\Parameter;

class SelectUserProfesion extends Component
{
    public $profesional_ust;
    public $users;
    public $user_id;
    public $professions;
    public $profession_id;

    public function mount()
    {
        $this->loadData();
    }

    public function change()
    {
        $this->loadData();
    }

    private function loadData()
    {
        $profession_id = $this->profession_id;
        $professions = explode(',', Parameter::where('parameter', 'profesiones_ust')->pluck('value')->toArray()[0]);

        // Obtener el establishment_id del usuario autenticado
        $establishment_id = auth()->user()->establishment_id;

        $this->professions = Profession::whereIn('id', $professions)
            ->whereHas('openHours', function ($query) use ($establishment_id) {
                $query->where('start_date', '>=', now())
                    ->whereHas('profesional', function ($subQuery) use ($establishment_id) {
                        // Filtrar openHours asignadas a profesionales del mismo establecimiento que el usuario autenticado
                        $subQuery->where('establishment_id', $establishment_id);
                    });
            })
            ->get();

        // Cargar los usuarios relacionados con la profesión seleccionada y el establecimiento
        $this->users = $this->getUsersByProfession($profession_id, $establishment_id);
    }

    private function getUsersByProfession($profession_id, $establishment_id, $user_id = null)
    {
        return User::whereHas('agendaProposals', function ($query) use ($profession_id, $user_id) {
            $query->where('profession_id', $profession_id)
                ->where('status', 'Aperturado')
                ->where('end_date', '>=', now()->format('Y-m-d'));

            if ($user_id) {
                $query->where('user_id', $user_id);
            }
        })
        ->where('establishment_id', $establishment_id) // Filtrar solo usuarios del mismo establecimiento
        ->get();
    }

    public function render()
    {
        return view('livewire.prof-agenda.select-user-profesion');
    }
}
