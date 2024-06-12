<?php

namespace App\Http\Livewire\Finance;

use Livewire\Component;
use App\Models\Finance\Dte;
use App\Models\Sigfe\PdfBackup;
use Livewire\WithPagination;

class PaymentBackup extends Component
{

    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $filters = [
        'id' => null,
        'emisor' => null,
        'folio_pago' => null,
    ];

    public function search()
    {
        
        $this->resetPage();
    }


    public function render()
    {
        $query = Dte::query()
            ->whereNull('rejected')
            ->where('tipo_documento', 'LIKE', 'factura_%')
            ->where('all_receptions', 1)
            ->where('establishment_id', auth()->user()->organizationalUnit->establishment_id)
            ->where('payment_ready', 1);

        // Aplica filtros
        if ($this->filters['id']) {
            $query->where('id', $this->filters['id']);
        }
        if ($this->filters['emisor']) {
            $query->where('emisor', 'LIKE', '%' . $this->filters['emisor'] . '%');
        }
        if ($this->filters['folio_pago']) {
            $query->where('paid_folio', 'LIKE', '%' . $this->filters['folio_pago'] . '%');
        }
        // Aplica más filtros según tus necesidades

        $dtes = $query->paginate(50);

        return view('livewire.finance.payment-backup', [
            'dtes' => $dtes,
        ]);
    }
}
