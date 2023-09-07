<?php

namespace App\Http\Livewire\ProfAgenda;

use Livewire\Component;

use App\Models\Parameters\Profession;
use App\User;

class SelectUserProfesion extends Component
{
    public $users;
    public $user_id;
    public $professions;
    public $profession_id;

    public function mount(){
        $this->professions = Profession::whereIn('id',[1,4,5,6])->get();

        $profession_id = $this->profession_id;
        $this->users = User::whereHas('agendaProposals', function($q) use ($profession_id){
            $q->where('profession_id',$profession_id);
        })->get();
    }

    public function change(){
        $profession_id = $this->profession_id;
        $this->users = User::whereHas('agendaProposals', function($q) use ($profession_id){
                                $q->where('profession_id',$profession_id);
                            })->get();
    }

    public function render()
    {
        return view('livewire.prof-agenda.select-user-profesion');
    }
}
