<?php

namespace App\Livewire\Drugs\Receptions;

use App\Models\Drugs\ReceptionItem;
use App\Models\Drugs\Substance;
use Livewire\Component;
use Livewire\WithPagination;

class ReportByItem extends Component
{
    use WithPagination;
    var $paginationTheme = 'bootstrap';

    public $rama;

    public function render()
    {
        /** Obtener todas todas las ramas de las sustancias */
        $ramas = Substance::whereNotNull('rama')->groupBy('rama')->pluck('rama')->toArray();

        /**
         * Obtiene todos los items
         */
        $items = ReceptionItem::with([
                'reception',
                'reception.user',
                'reception.court',
                'substance',
                'protocols',
                'reception.destruction.user',
                'resultSubstance',
                'reception.sampleToIsp',
                'reception.recordToCourt',
                'reception.partePoliceUnit',
            ])
            ->when($this->rama, function ($query, $rama) {
                return $query->whereHas('substance', function ($query) use ($rama) {
                    $query->where('rama', $rama);
                });
            })
            ->orderBy('reception_id', 'desc')
            ->paginate(1000);
        
        return view('livewire.drugs.receptions.report-by-item', [
            'items' => $items,
            'ramas' => $ramas,
        ]);
    }
}
