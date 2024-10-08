<?php

namespace App\Livewire\Drugs\Receptions;

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
    public $nue = null;


    public function render()
    {
        return view('livewire.drugs.receptions.reception-index', [
            'receptions' => $this->getReceptions()
        ]);
    }

    public function getReceptions()
    {
        $receptions = Reception::query()
            ->with([
                'items',
                'partePoliceUnit',
                'documentPoliceUnit',
                'destruction',
                'haveItemsForDestruction',
            ])
            ->withCount(['items'])
            ->when($this->filter == 'pending', function($query) {
                /**
                 * Actas de recepción que tengan la cantidad a destruir mayor a cero y que no tenga acta de destrución
                 */
                $query->has('haveItemsForDestruction')
                    ->where(function($query) {
                        $query->doesntHave('destruction');
                    })
                    /**
                     * Actas que tenga items al menos un items a destruir, o item no reservado
                     */
                    ->has('itemsWithoutPrecursors');
            })
            ->when($this->filter == '', function($query) {
                $query->whereDate('created_at', '>', Carbon::today()->subDays(16));
            })
            // when nue is not null, filter $reception->items with nue attribute
            ->when($this->nue, function($query) {
                $query->whereHas('items', function($query) {
                    $query->where('nue', 'like', "%{$this->nue}%");
                });
            })
            ->search($this->search)
            ->latest()
            ->paginate(100);

        return $receptions;
    }
}
