<?php

namespace App\Http\Livewire\Finance;

use Livewire\WithPagination;
use Livewire\Component;
use App\Models\Finance\Dte;
use App\Models\Establishment;

class IndexDtes extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $filter;

    public $showManualDTE = false;

    public $establishments;

    public $establishment;

    public $successMessages = [];

    public $filter_folio;
    public $filter_folio_oc;
    public $filter_folio_sigfe;
    public $filter_sender_status;
    public $filter_selected_establishment;



    public function searchDtes()
    {
        $query = Dte::query();

        if (!empty($this->filter_folio)) {
            $query->where('folio', $this->filter_folio);
        }

        if (!empty($this->filter_folio_oc)) {
            $query->where('folio_oc', $this->filter_folio_oc);
        }

        if (!empty($this->filter_folio_sigfe)) {
            switch ($this->filter_folio_sigfe) {
                case 'Con Folio SIGFE':
                    $query->whereNotNull('folio_sigfe');
                    break;
                case 'Sin Folio SIGFE':
                    $query->whereNull('folio_sigfe');
                    break;
            }
        }

        if (!empty($this->filter_sender_status)) {
            switch ($this->filter_sender_status) {
                case 'no confirmadas y enviadas a confirmación':
                    $query->whereNull('confirmation_status')->whereNotNull('confirmation_send_at');
                    break;
                case 'Enviado a confirmación':
                    $query->whereNotNull('confirmation_send_at');
                    break;
                case 'Confirmada':
                    $query->whereNotNull('confirmation_send_at')->where('confirmation_status', 1);
                    break;
                case 'No Confirmadas':
                    $query->whereNotNull('confirmation_send_at')->whereNull('confirmation_status');
                    break;
                case 'Confirmadas':
                    $query->whereNotNull('confirmation_send_at')->where('confirmation_status', 1);
                    break;
                case 'Rechazadas':
                    $query->whereNotNull('confirmation_send_at')->where('confirmation_status', 0);
                    break;
                case 'Sin Envío':
                    $query->whereNull('confirmation_send_at')->whereNull('confirmation_status');
                    break;
            }
        }

        if (!empty($this->filter_selected_establishment)) {
            $query->where('establishment_id', $this->filter_selected_establishment);
        }

        // Rest of your searchDtes logic...

        // Aplicar relaciones y ordenamiento
        $query->with([
            'purchaseOrder',
            'controls',
            'requestForm',
            'requestForm.contractManager',
        ])
            ->whereNot('tipo_documento', 'guias_despacho')
            ->orderBy('emision');

        return $query->paginate(100);
    }








    public function refresh()
    {
        /**
         * Sólo hace el re redner del componente
         */
    }



    public function mount()
    {

        $establishments_ids = explode(',', env('APP_SS_ESTABLISHMENTS'));

        $this->establishments = Establishment::whereIn('id', $establishments_ids)
            ->select('id', 'name')
            ->orderBy('name')
            ->get();
    }

    public function loadManualDTE()
    {
        $this->showManualDTE = true;
    }

    public function dteAdded()
    {
        // Ocultar el formulario
        $this->showManualDTE = false;
    }

    public function render()
    {
        // $query = Dte::search($this->filter)->with([
        //     'purchaseOrder',
        //     'controls',
        //     'requestForm',
        //     'requestForm.contractManager',
        // ])
        //     ->whereNot('tipo_documento', 'guias_despacho')
        //     ->orderBy('emision')
        //     ->paginate(50);

        //$establishments = Establishment::orderBy('name')->get();


        $dtes = $this->searchDtes();



        return view('livewire.finance.index-dtes', [
            'dtes' => $dtes,
            //'establishments' => $establishments,
        ]);
    }
}
