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

    public function mount(){
        $profession_id = $this->profession_id;
        $professions = explode(',',Parameter::where('parameter','profesiones_ust')->pluck('value')->toArray()[0]);

        if($this->profesional_ust == true){
            // se devuelve usuarios según rol asignado
            if(auth()->user()->can('Agenda UST: Administrador') || auth()->user()->can('Agenda UST: Secretaria')){
                $this->professions = Profession::whereIn('id',$professions)->get();
                $this->users = User::whereHas('agendaProposals', function($q) use ($profession_id){
                                        $q->where('profession_id',$profession_id)
                                            ->where('status','Aperturado')
                                            ->where('end_date','>=',now()->format('Y-m-d'));
                                    })->get();
                                    // dd($this->users);
            }
            if(auth()->user()->can('Agenda UST: Funcionario')){
                // obtiene profesiones asociada a funcionario logeado
                $array = Proposal::where('user_id',auth()->id())->get()->pluck('profession_id')->toArray();
                $this->professions = Profession::whereIn('id',$array)->get();

                $this->users = User::whereHas('agendaProposals', function($q) use ($profession_id){
                                    $q->where('profession_id',$profession_id);
                                    $q->where('user_id',auth()->id());
                                    $q->where('status','Aperturado');
                                    $q->where('end_date','>=',now()->format('Y-m-d'));
                                })->get();
            }
        }else{
            $this->professions = Profession::whereIn('id',$professions)->get();
            $this->users = User::whereHas('agendaProposals', function($q) use ($profession_id){
                                    $q->where('profession_id',$profession_id)
                                        ->where('status','Aperturado')
                                        ->where('end_date','>=',now()->format('Y-m-d'));
                                })->get();
        }
    }

    public function change(){
        /* TODO: @sickiqq porqué el código está dos veces? */
        $profession_id = $this->profession_id;
        $professions = explode(',',Parameter::where('parameter','profesiones_ust')->pluck('value')->toArray()[0]);
        
        if($this->profesional_ust == true){
            // se devuelve usuarios según rol asignado
            if(auth()->user()->can('Agenda UST: Administrador') || auth()->user()->can('Agenda UST: Secretaria')){
                $this->professions = Profession::whereIn('id',$professions)->get();
                $this->users = User::whereHas('agendaProposals', function($q) use ($profession_id){
                                        $q->where('profession_id',$profession_id)
                                            ->where('status','Aperturado')
                                            ->where('end_date','>=',now()->format('Y-m-d'));
                                    })->get();
            }
            if(auth()->user()->can('Agenda UST: Funcionario')){
                // obtiene profesiones asociada a funcionario logeado
                $array = Proposal::where('user_id',auth()->id())->get()->pluck('profession_id')->toArray();
                $this->professions = Profession::whereIn('id',$array)->get();
                
                $this->users = User::whereHas('agendaProposals', function($q) use ($profession_id){
                                    $q->where('profession_id',$profession_id);
                                    $q->where('user_id',auth()->id());
                                    $q->where('end_date','>=',now()->format('Y-m-d'));
                                })->get();
            }
        }else{
            $this->professions = Profession::whereIn('id',$professions)->get();
            $this->users = User::whereHas('agendaProposals', function($q) use ($profession_id){
                                    $q->where('profession_id',$profession_id)
                                        ->where('status','Aperturado')
                                        ->where('end_date','>=',now()->format('Y-m-d'));
                                })->get();
        }
    }

    public function render()
    {
        return view('livewire.prof-agenda.select-user-profesion');
    }
}
