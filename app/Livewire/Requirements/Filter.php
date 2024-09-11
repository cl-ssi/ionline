<?php

namespace App\Livewire\Requirements;

use Livewire\Component;
use App\Models\Requirements\Requirement;
use App\Models\User;
use Livewire\WithPagination;
use App\Exports\RequirementsExport;
use Maatwebsite\Excel\Facades\Excel;

class Filter extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    // public $requirements;
    public $user;
    public $auth_user;

    public $req_id;
    public $subject;
    public $body;
    public $label;
    public $category_id;
    public $user_involved;
    public $parte;
    public $status = 'Pendientes';
    public $readedStatus = 'Todos';

    public function mount(User $user, User $auth_user)
    {
        $this->user = $user;
        $this->auth_user = $auth_user;
    }

    public function getRequirements()
    {
        $requirements = Requirement::query();
        $requirements
            ->with([
                'archived',
                'labels',
                'events',
                'ccEvents',
                'parte',
                'events.from_user',
                'events.to_user',
                'events.from_ou',
                'events.to_ou',
                'eventsWithoutCC',
                'eventsViewed',
            ])
            ->whereHas('events', function ($query) {
                $query->where('from_user_id', $this->user->id)->orWhere('to_user_id', $this->user->id);
            });

        if($this->req_id)
        {
            $requirements->where('id',$this->req_id);
        }
        if($this->subject)
        {
            $requirements->where('subject','LIKE','%'.$this->subject.'%');
        }

        if ($this->body) {            
            $requirements->whereHas('events', function ($query) {
                $query->where('body', 'LIKE', '%' . $this->body . '%');
            });
        }

        if($this->label)
        {
            $requirements->whereHas('labels', function ($query) {
                $query->where('name','LIKE','%'.$this->label.'%');
            });
        }

        if($this->category_id)
        {
            $requirements->where('category_id', $this->category_id);
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

        if($this->status == 'Archivados')
        {
            $requirements->whereHas('archived', function ($query) {
                $query->whereIn('user_id', [$this->user->id, $this->auth_user->id]);
            });
        }
        else if($this->status == 'Pendientes')
        {
            $requirements->whereDoesntHave('archived', function ($query) {
                $query->whereIn('user_id', [$this->user->id, $this->auth_user->id]);
            });
        }
        else if($this->status == 'Expirados')
        {
            $requirements->where('limit_at', '<', now()) // Requerimientos cuya fecha límite haya pasado
                        ->where('status', '<>', 'cerrado'); // Que no estén cerrados
        }

        if($this->readedStatus == 'Sin leer')
        {
            $requirements->whereHas('eventsWithoutCC', function ($query) {
                $query->whereDoesntHave('viewed');
            });
        }

        return $requirements->orderByDesc('id')->paginate(100);
    }

    /**
    * search
    */
    public function search()
    {
        $this->resetPage();
    }
    public function render()
    {
        $requirements = $this->getRequirements();
        
        return view('livewire.requirements.filter',[
            'requirements' => $requirements,
        ]);
    }

    public function export()
    {
        $filteredRequirements = $this->getRequirements()->pluck('id'); // Obtener solo los IDs de los requisitos filtrados
        
        // Aplicar los mismos filtros al exportador
        return Excel::download(new RequirementsExport($filteredRequirements), 'requirements.xlsx');
    }
    


}
