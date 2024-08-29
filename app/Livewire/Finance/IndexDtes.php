<?php

namespace App\Livewire\Finance;

use App\Models\Establishment;
use App\Models\Finance\Dte;
use App\Models\Finance\Receptions\Reception;
use App\Notifications\Finance\DteConfirmation;
use App\Models\Parameters\Subtitle;
use Livewire\Attributes\On;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\DtesExport;
use Livewire\Component;
use Livewire\WithPagination;


class IndexDtes extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $filter = array();

    public $showManualDTE = false;

    public $establishments;

    public $subtitles;

    // public $establishment;

    public $successMessages = [];

    public $ids = array();

    public $establishment_id;

    public $showEdit = null;

    public $folio_oc = null;
    public $confirmation_status = null;
    //public $confirmation_observation = null;
    public $reason_rejection = null;
    public $monto_total = null;

    public $facturasEmisor;

    public $asociate_invoices;

    public $contract_manager_id;

    public function searchDtes($paginate = true)
    {
        $query = Dte::query();

        // app('debugbar')->log($this->filter);

        foreach ($this->filter as $filter => $value) {
            if ($value) {
                // app('debugbar')->log($filter);
                switch ($filter) {
                    case 'id':
                        $query->where('id', $value);
                        break;
                    case 'emisor':
                        /** 
                         * Algoritmo para obtener convertir $value que tiene XXXXXXXXX  
                         * en formato rut chileno XX.XXX.XXX-X 
                         **/
                        $value = preg_replace('/[^0-9K]/', '', strtoupper(trim($value)));
                        $dv = substr($value, -1);
                        $id = substr($value, 0, -1);
                        $value = $this->filter['emisor'] = number_format($id, 0, '', '.').'-'.$dv;

                        $query->where('emisor', $value);
                        break;
                    case 'folio':
                        $query->where('folio', $value);
                        break;
                    case 'folio_oc':
                        $query->where('folio_oc', 'like', '%' . $value. '%');
                        break;
                    case 'oc':
                        switch ($value) {
                            case 'Con OC':
                                $query->whereNotNull('folio_oc');
                                break;
                            case 'Sin OC':
                                $query->whereNull('folio_oc');
                                break;
                            case 'Sin OC de MP':
                                // Donde folio_oc no sea nulo ni vacio
                                $query->whereNotNull('folio_oc')->where('folio_oc', '<>', '');
                                $query->doesntHave('purchaseOrder');
                                break;
                        }
                        break;
                    case 'reception':
                        switch ($value) {
                            case 'Con Recepción':
                                $query->has('receptions');
                                break;
                            case 'Sin Recepción':
                                $query->doesntHave('receptions');
                                break;
                        }
                        break;
                    case 'folio_sigfe':
                        switch ($value) {
                            case 'Con SIGFE':
                                $query->whereNotNull('folio_sigfe');
                                break;
                            case 'Sin SIGFE':
                                $query->whereNull('folio_sigfe');
                                break;
                        }
                        break;
                    case 'establishment':
                        if ($value == '?') {
                            $query->whereNull('establishment_id');
                        } else {
                            $query->where('establishment_id', $value);
                        }
                        break;
                    case 'tipo_documento':
                        if ($value === 'facturas') {
                            $query->whereIn('tipo_documento', ['factura_electronica', 'factura_exenta']);
                        } else {
                            $query->where('tipo_documento', $value);
                        }
                        break;
                    case 'fecha_desde_sii':
                        $query->where('fecha_recepcion_sii', '>=', $value);
                        break;
                    case 'fecha_hasta_sii':
                        $query->where('fecha_recepcion_sii', '<=', $value);
                        break;
                    case 'estado':
                        switch ($value) {
                            case 'sin_estado':
                                $query->where('all_receptions', 0);
                                break;
                            case 'revision':
                                $query->where('all_receptions',1);
                                break;
                            case 'listo_para_pago':
                                $query->where('payment_ready',1);
                                break;
                        }
                        break;
                    case 'subtitulo':
                        $query->whereHas('requestForm', function ($query) use ($value) {
                            $query->whereHas('associateProgram', function ($query) use ($value) {
                                $query->whereHas('Subtitle', function ($query) use ($value) {
                                    $query->where('id', $value);
                                });
                            });
                        });
                        break;
                    case 'fecha_desde_revision':                        
                        $query->where('all_receptions_at', '>=', $value);
                        break;
                    case 'fecha_hasta_revision':
                        $query->where('all_receptions_at', '<=', $value);
                        break;

                }
            }
        }



        // Aplicar relaciones y ordenamiento
        $query->with([
            'purchaseOrder',
            'purchaseOrder.receptions',
            'purchaseOrder.rejections',
            'establishment',
            'controls',
            'requestForm',
            'requestForm.contractManager',
            'dtes',
            'invoices',            
            'contractManager'
        ])
            ->whereNull('rejected')
            ->orderByDesc('fecha_recepcion_sii');
        if ($paginate) {
            return $query->paginate(50);
        } else {
            return $query->get();
        }
        //return $query->paginate(50);
    }


    public function refresh()
    {

        //$this->dtes = $this->searchDtes();
        $this->resetPage();
    }

    public function mount()
    {
        $this->filter['folio'] = null;
        $this->filter['folio_oc'] = null;
        $this->filter['folio_sigfe'] = 'Sin Folio SIGFE';
        $this->filter['sender_status'] = 'Todas';
        $this->filter['establishment'] = auth()->user()->organizationalUnit->establishment_id;

        $establishments_ids = explode(',', env('APP_SS_ESTABLISHMENTS'));

        $this->establishments = Establishment::whereIn('id', $establishments_ids)->pluck('alias', 'id');

        $this->subtitles = Subtitle::all();


    }

    /**
     * Set establishment
     */
    public function setEstablishment()
    {
        foreach ($this->ids as $id => $value) {
            Dte::whereId($id)->update(['establishment_id' => $this->establishment_id]);
        }
        $this->ids = array();
    }

    public function show(Dte $dte)
    {
        $this->showEdit = $dte->id;
        $this->folio_oc = $dte->folio_oc;
        $this->confirmation_status = $dte->confirmation_status;
        $this->confirmation_observation = $dte->reason_rejection;
        $this->asociate_invoices = $dte->invoices->pluck('id');
        $this->monto_total = '$ ' . number_format($dte->monto_total, 0, '', '.');
        $this->facturasEmisor = Dte::where('emisor', 'like', '%' . trim($dte->emisor) . '%')
            ->whereIn('tipo_documento', ['factura_electronica', 'factura_exenta'])
            ->get();
        $this->contract_manager_id = null;
    }

    public function dismiss()
    {
        /** Codigo al cerrar el modal */
        $this->showEdit = null;
    }

    public function save($dte_id)
    {
        $dte = Dte::find($dte_id);
        $dte->update([
            // comprueba que $this->folio_oc no esté vacio, si lo está, lo deja como null
            'folio_oc' => $this->folio_oc ? trim($this->folio_oc) : null,
            'contract_manager_id' => $this->contract_manager_id ?? null,
            // 'confirmation_status' => $this->confirmation_status, //¿?
            // 'confirmation_user_id' => auth()->id(), //¿
            // 'confirmation_ou_id' => auth()->user()->organizational_unit_id, //¿?
            // 'confirmation_at' => now(), //¿?
            // 'confirmation_observation' => $this->confirmation_observation, //¿?
        ]);
        $dte->invoices()->sync($this->asociate_invoices);

        
        if($dte->receptions->first() and $dte->invoices->first())
        {
            //Una guía tiene una o mas recepciones, buscar las facturas asociadas a esa guía y a esa factura asociarle la recepción de la guia
            $dte->receptions->first()->dte_id = $dte->invoices->first()->id;
            $dte->receptions->first()->save();
        }


        if (
            $dte->confirmation_status !== null &&
            $dte->confirmation_user_id !== null &&
            $dte->confirmation_at !== null &&
            $dte->confirmation_signature_file !== null &&
            $dte->upload_user_id !== null
        ) 
        
        {
            foreach ($this->asociate_invoices as $invoice_id) {
                $invoice = Dte::find($invoice_id);
                $invoice->update([
                    'confirmation_status' => $dte->confirmation_status,
                    'confirmation_user_id' => $dte->confirmation_user_id,
                    'confirmation_ou_id' => $dte->confirmation_ou_id,
                    'confirmation_at' => $dte->confirmation_at,
                    'confirmation_signature_file' => $dte->confirmation_signature_file,
                    'upload_user_id' => $dte->upload_user_id,
                ]);
            }
        }
        $this->showEdit = null;
    }

    public function changeStatus($dte_id)
    {
        $dte = Dte::find($dte_id);

        // Actualizar el estado de confirmación y otros campos relacionados
        $dte->update([
            'confirmation_status' => $this->confirmation_status,
            'reason_rejection' => $this->confirmation_observation
        ]);
        $this->showEdit = null;
    }

    public function sendConfirmation($dte_id)
    {
        $dte = Dte::find($dte_id);
        // Notifica al administrador de contrato del FR
        $dte->requestForm?->contractManager?->notify(new DteConfirmation($dte));
        // Notifica al adminsitrador de contrato del DTE
        $dte->contractManager?->notify(new DteConfirmation($dte));

        $dte->confirmation_sender_id = auth()->id();
        $dte->confirmation_send_at = now();
        $dte->save();
    }

    public function updateAllReceptionsStatus($dte_id)
    {
        $dte = Dte::find($dte_id);
        $dte->update([
            'all_receptions' => true,
            'all_receptions_user_id' => auth()->id(),
            'all_receptions_ou_id' => auth()->user()->organizational_unit_id,
            'all_receptions_at' => now(),
        ]);
        $this->showEdit = null;
    }




    public function render()
    {
        $dtes = $this->searchDtes();

        return view('livewire.finance.index-dtes', [
            'dtes' => $dtes,
            //'establishments' => $establishments,
        ]);
    }


    public function updateReceptionDteId($receptionId, $dteId = null)
    {
        $reception = Reception::find($receptionId);
        if ($reception) {
            $reception->update(['dte_id' => $dteId]);
        }
    }

    public function rejectDte($dte_id)
    {
        $this->validate([
            'reason_rejection' => 'required',
        ]);

        $dte = Dte::find($dte_id);
        $dte->update(
            [
                'rejected' => true, 
                'reason_rejection' => $this->reason_rejection,
                'rejected_user_id' => auth()->id(),
                'rejected_at' => now(),
                'status' => 'Rechazada'
            ]);

        $this->refresh();
    }

    #[On('setContractManager')]
    public function setContractManager($userId)
    {
        $this->contract_manager_id = $userId;
    }

    public function exportToExcel()
    {
        $dtes = $this->searchDtes(false);
        return Excel::download(new DtesExport($dtes), 'dtes.xlsx');
    }

}
