<?php

namespace App\Http\Livewire\ProfAgenda;

use Livewire\Component;

use Illuminate\Support\Facades\Auth;
use App\Models\Parameters\Profession;
use App\Models\ProfAgenda\Proposal;
use App\User;
use App\Models\Parameters\Parameter;

class SelectUserProfesion extends Component
{
    public $users;
    public $user_id;
    public $professions;
    public $profession_id;

    public function mount(){
        $profession_id = $this->profession_id;
        $professions = explode(',',Parameter::where('parameter','profesiones_ust')->pluck('value')->toArray()[0]);

        // se devuelve usuarios según rol asignado
        if(Auth::user()->can('Agenda UST: Administrador') || Auth::user()->can('Agenda UST: Secretaria')){
            $this->professions = Profession::whereIn('id',$professions)->get();
            $this->users = User::whereHas('agendaProposals', function($q) use ($profession_id){
                                    $q->where('profession_id',$profession_id);
                                })->get();
        }
        if(Auth::user()->can('Agenda UST: Funcionario')){
            // obtiene profesiones asociada a funcionario logeado
            $array = Proposal::where('user_id',Auth::user()->id)->get()->pluck('profession_id')->toArray();
            $this->professions = Profession::whereIn('id',$array)->get();

            $this->users = User::whereHas('agendaProposals', function($q) use ($profession_id){
                                $q->where('profession_id',$profession_id);
                                $q->where('user_id',Auth::user()->id);
                            })->get();
        }
        
    }

    public function change(){
        /* TODO: @sickiqq porqué el código está dos veces? */
        $profession_id = $this->profession_id;
        $professions = explode(',',Parameter::where('parameter','profesiones_ust')->pluck('value')->toArray()[0]);
        
        // se devuelve usuarios según rol asignado
        if(Auth::user()->can('Agenda UST: Administrador') || Auth::user()->can('Agenda UST: Secretaria')){
            $this->professions = Profession::whereIn('id',$professions)->get();
            $this->users = User::whereHas('agendaProposals', function($q) use ($profession_id){
                                    $q->where('profession_id',$profession_id);
                                })->get();
        }
        if(Auth::user()->can('Agenda UST: Funcionario')){
            // obtiene profesiones asociada a funcionario logeado
            $array = Proposal::where('user_id',Auth::user()->id)->get()->pluck('profession_id')->toArray();
            $this->professions = Profession::whereIn('id',$array)->get();
            
            $this->users = User::whereHas('agendaProposals', function($q) use ($profession_id){
                                $q->where('profession_id',$profession_id);
                                $q->where('user_id',Auth::user()->id);
                            })->get();
        }
    }

    public function render()
    {
        return view('livewire.prof-agenda.select-user-profesion');
    }
}
