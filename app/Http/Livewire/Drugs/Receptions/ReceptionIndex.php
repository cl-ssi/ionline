<?php

namespace App\Http\Livewire\Drugs\Receptions;

use App\Models\Drugs\Reception;
use Illuminate\Support\Carbon;
use Livewire\Component;
use Livewire\WithPagination;

class ReceptionIndex extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $search;
    public $filter = "all";


    public function render()
    {
        return view('livewire.drugs.receptions.reception-index', [
            'receptions' => $this->getReceptions()
        ]);
    }

    /**
     * Para que aparezca los días pendientes de destrucción
     * Formula: Que no tenga una destrucción creada
     * que tenga items con saldo mayor a cero ((peso neto - primera + segunda) saldo a destruir mayor > 0)
     * y que tenga al menos un item, distinto a un precursor reservado
     */
    public function getReceptions()
    {
        $receptions = Reception::query()
            ->with([
                'items',
                'partePoliceUnit',
                'documentPoliceUnit',
                'destruction',
                'haveItemsForDestruction'
            ])
            ->withCount(['items'])
            ->when($this->filter == 'pending', function($query) {
                $query->has('haveItemsForDestruction')->where(function($query) {
                    $query->doesntHave('destruction');
                });
            })
            ->when($this->filter == '', function($query) {
                $query->whereDate('created_at', '>', Carbon::today()->subDays(16));
            })
            ->Search($this->search)
            ->latest()
            ->paginate(100);

        return $receptions;
    }
}
