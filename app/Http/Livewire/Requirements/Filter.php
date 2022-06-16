<?php

namespace App\Http\Livewire\Requirements;

use Livewire\Component;
use App\Requirements\Requirement;
use App\User;
//use Livewire\WithPagination;

class Filter extends Component
{
    //use WithPagination;

    public $requirements;
    public $user;

    public $req_id;
    public $subject;
    public $category;
    public $user_involved;
    public $parte;

    public function mount(User $user)
    {
        $this->requirements = collect();
        $this->user = $user;
    }

    public function search()
    {
        $requirements = Requirement::query();
        $requirements
            ->with('archived','categories','events','ccEvents','parte','events.from_user','events.to_user','events.from_ou', 'events.to_ou')
            ->whereHas('events', function ($query) {
                $query->where('from_user_id', $this->user->id)->orWhere('to_user_id', $this->user->id);
            });

        if($this->req_id)
        {
            $requirements->where('id',$this->req_id)->get();
        }
        else
        {
            if($this->subject)
            {
                $requirements->where('subject','LIKE','%'.$this->subject.'%');
            }
            if($this->category)
            {
                $requirements->whereHas('categories',function($query){
                    $query->where('name','LIKE','%'.$this->category.'%');
                });
            }
            $this->requirements = $requirements->get();
        }



    }
    public function render()
    {
        return view('livewire.requirements.filter');
    }
}
