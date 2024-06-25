<?php

namespace App\Http\Livewire\Finance;

use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use App\Models\Finance\Dte;
use App\Models\Sigfe\PdfBackup;
use Illuminate\Database\Eloquent\Builder;

class InstitutionalPayment extends Component
{
    use WithFileUploads;
    use WithPagination;

    public $SupportFile;
    protected $paginationTheme = 'bootstrap';

    public $filters = [
        'id' => null,
        'emisor' => null,
        'folio_pago' => null,
        'sin_firma' => 'Todos',
        'firmado' => 'Todos',
    ];

    public function search()
    {
        $this->resetPage();
    }
    public function updatedSupportFile()
    {
        dd($this->SupportFile);
    }

    public function save($dte_id)
    {
        $id = $dte_id;
        // $this->validate();

        /* Documento de respaldo: Support File */
        dd("no entre al if");
        if($this->SupportFile) {
            dd("entre al if");
            $storage_path = 'ionline/finances/institutional_payment/support_documents';
            $filename = $id.'.pdf';

            $this->SupportFile->storeAs($storage_path, $filename, 'gcs');


            /* $institutional_payment->files()->create([
                'storage_path' => $storage_path.'/'.$filename,
                'stored' => true,
                'type' => 'support_file',
                'stored_by_id' => auth()->id(),
            ]); */
        }
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

        // Filtrar los resultados según el estado de todas las aprobaciones
        if ($this->filters['firmado'] == 'Firmados') {
            $query->whereHas('comprobantePago.approvals', function (Builder $query) {
                $query->where('status', 1);
            }, '=', 2);
        } elseif ($this->filters['firmado'] == 'Pendientes') {
            $query->whereHas('comprobantePago.approvals', function (Builder $query) {
                $query->where('status', '!=', 1);
            });
        }

        $dtes = $query->paginate(50);
        return view('livewire.finance.institutional-payment', [
            'dtes' => $dtes,
        ]);
    }
}
