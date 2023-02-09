<?php

namespace App\Http\Livewire\Requirements;

use Livewire\Component;
use App\Models\Requirements\Requirement;
use App\User;
//use Livewire\WithPagination;

class Filter extends Component
{
    //use WithPagination;

    public $requirements;
    public $user;

    public $req_id;
    public $subject;
    public $label;
    public $user_involved;
    public $parte;

    public function mount(User $user)
    {
        $this->user = $user;
    }

    public function search()
    {
        $requirements = Requirement::query();
        $requirements
            ->with('archived','labels','events','ccEvents','parte','events.from_user','events.to_user','events.from_ou', 'events.to_ou')
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
            if($this->label)
            {
                $requirements->whereHas('labels', function ($query) {
                    $query->where('name','LIKE','%'.$this->label.'%');
                });
            }
            if($this->parte)
            {
                $requirements->whereHas('parte', function ($query) {
                    $query->search2($this->parte);
                });
            }
            if($this->user_involved)
            {
                $requirements->whereHas('events', function ($query) {
                    $query->whereHas('from_user', function ($q) {
                        $q->fullSearch($this->user_involved);
                    });
                    $query->orWhereHas('to_user', function ($q) {
                        $q->fullSearch($this->user_involved);
                    });
                });
            }
        }
        $this->requirements = $requirements->get();

    }
    public function render()
    {
        return view('livewire.requirements.filter');
    }
}
