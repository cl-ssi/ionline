<?php

namespace App\Http\Livewire\Requirements;

use Livewire\Component;
use App\Requirements\Requirement;
use App\User;
use Illuminate\Support\Carbon;
use Livewire\WithPagination;
use Illuminate\Support\Str;

class Filter extends Component
{
    use WithPagination;
	protected $paginationTheme = 'bootstrap';

    public $user;
    public $auth_user;
    public $allowed_users;
    public $statuses;
    public $idEventsCopy;

    public $status = "Pendiente";
    public $req_id;
    public $subject;
    public $category;
    public $user_involved;
    public $parte;
    public $start;
    public $end;

    public function mount()
    {
        $this->getEventsCopy();
        $this->getAllowedUsers();
        $this->getStatuses();
    }

    public function render()
    {
        return view('livewire.requirements.filter', [
            'requirements' => $this->getRequirements(),
        ]);
    }

    public function getRequirements()
    {
        $requirements = Requirement::query();

        $requirements
            ->with('archived', 'categories', 'events', 'ccEvents', 'parte', 'events.from_user', 'events.to_user', 'events.from_ou', 'events.to_ou')
            ->whereHas('events', function ($query) {
                $query->where('from_user_id', $this->user->id)->orWhere('to_user_id', $this->user->id);
            });

        if($this->req_id)
        {
            $requirements->whereId($this->req_id)->get();
        }
        else
        {
            if($this->status == 'Archivado')
            {
                $requirements->whereHas('archived', function ($query) {
                    $query->whereIn('user_id', [$this->user->id, $this->auth_user->id]);
                });
                $requirements->whereNotIn('id', $this->idEventsCopy);
            }

            if($this->status == 'Pendiente')
            {
                $requirements->whereDoesntHave('archived', function ($query) {
                    $query->whereIn('user_id', [$this->user->id, $this->auth_user->id]);
                });
                $requirements->whereNotIn('id', $this->idEventsCopy);
            }

            if($this->status == 'Copia')
            {
                $requirements->whereIn('id', $this->idEventsCopy);
            }

            if(
                $this->status != 'Archivado' &&
                $this->status != 'Pendiente' &&
                $this->status != 'Copia' &&
                $this->status != 'Todos'
            )
            {
                $requirements->whereStatus(Str::lower($this->status));
                $requirements->whereNotIn('id', $this->idEventsCopy);
            }

            if($this->subject)
            {
                $requirements->where('subject', 'LIKE', '%' . $this->subject . '%');
            }

            if($this->category)
            {
                $requirements->whereHas('categories', function ($query) {
                    $query->where('name', 'LIKE', '%' . $this->category . '%');
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

            if($this->start)
                $requirements->whereDate('created_at', '>=', Carbon::parse($this->start)->startOfDay());

            if($this->end)
                $requirements->whereDate('created_at', '<=', Carbon::parse($this->end)->endOfDay());
        }

        return $requirements->latest()->paginate(5);

    }

    public function getEventsCopy()
    {
        $this->idEventsCopy = Requirement::eventsCopy($this->user);
    }

    public function getAllowedUsers()
    {
        $this->allowed_users = User::whereIn('id' , $this->allowed_users)->get();
    }

    public function getStatuses()
    {
        $statuses = Requirement::groupBy('status')->get('status')->pluck('status');
        $statuses->push('archivado');
        $statuses->push('pendiente');
        $statuses->push('copia');
        $statuses->push('todos');

        $statuses = $statuses->map(function ($item) {
            return Str::ucfirst($item);
        });

        $this->statuses = $statuses;
    }
}
