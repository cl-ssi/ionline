<?php

namespace App\Livewire\Finance;

use Livewire\Component;
use App\Models\Finance\Dte;
use App\Models\Sigfe\PdfBackup;
use Livewire\WithPagination;
use Illuminate\Database\Eloquent\Builder;

class PaymentBackup extends Component
{

    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $filters = [
        'id' => null,
        'emisor' => null,
        'folio_pago' => null,
        'estado_folio_pago' => 'Todos',
        'sin_firma' => 'Todos',
        'firmado' => 'Todos',        
    ];

    public function search()
    {
        
        $this->resetPage();
    }


    public function render()
    {
        $query = Dte::query()
            ->with([
                'comprobantePago',
                'requestForm.contractManager',
                'contractManager',
                'establishment',
                'tgrPayedDte',
                'receptions'
            ])
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

        if ($this->filters['sin_firma'] == 'Subidos') {
            $query->whereHas('comprobantePago');
        } elseif ($this->filters['sin_firma'] == 'Sin Subir') {
            $query->whereDoesntHave('comprobantePago');
        }

        
        if ($this->filters['firmado'] == 'Firmados') {
            $query->whereHas('comprobantePago.approvals', function (Builder $query) {
                $query->where('status', 1);
            }, '=', 2);
        } elseif ($this->filters['firmado'] == 'Pendientes') {
            $query->whereHas('comprobantePago.approvals', function (Builder $query) {
                $query->where('status', '!=', 1);
            });
        }

        if ($this->filters['estado_folio_pago'] == 'Con Folio') {
            $query->WhereHas('tgrPayedDte');
        } elseif ($this->filters['estado_folio_pago'] == 'Sin Folio') {
            $query->whereDoesntHave('tgrPayedDte');
        }

        $dtes = $query->paginate(50);

        return view('livewire.finance.payment-backup', [
            'dtes' => $dtes,
        ]);
    }
}
