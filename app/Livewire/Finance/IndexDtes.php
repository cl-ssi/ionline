<?php

namespace App\Livewire\Finance;

use App\Models\Establishment;
use App\Helpers;
use App\Models\Finance\Dte;
use App\Models\Finance\Receptions\Reception;
use App\Notifications\Finance\DteConfirmation;
use App\Models\Parameters\Subtitle;
use Livewire\Attributes\On;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\DtesExport;
use Illuminate\Support\Collection;
use Livewire\Component;
use Livewire\WithPagination;


class IndexDtes extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $filter = array();

    public $showManualDTE = false;

    public $establishments;

    public Collection $subtitles;

    public Collection $establishment;

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

    public function render()
    {
        $dtes = $this->searchDtes();
        return view('livewire.finance.index-dtes', [
            'dtes' => $dtes,
            //'establishments' => $establishments,
        ]);
    }

    public function searchDtes($paginate = true)
    {
        $query = Dte::with([ // Aplicar relaciones y ordenamiento
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
        ->when(isset($this->filter['id']), function($q){
            $q->where('id', $this->filter['id']);
        })
        ->when(isset($this->filter['emisor']), function($q){
            if(trim($this->filter['emisor']) != ''){
                $value = preg_replace('/[^0-9K]/', '', strtoupper(trim($this->filter['emisor'])));
                $dv = substr($value, -1);
                $id = substr($value, 0, -1);
                $value = $this->filter['emisor'] = number_format($id, 0, '', '.').'-'.$dv;
                $q->where('emisor', $value);
            }
        })
        ->when(isset($this->filter['folio']), function($q){
            $q->where('folio', $this->filter['folio']);
        })
        ->when(isset($this->filter['folio_oc']), function($q){
            $q->where('folio_oc', 'like', '%' . $this->filter['folio_oc'] . '%');
        })
        ->when(isset($this->filter['oc']), function($q){  
            $q->when($this->filter['oc'] == 'Con OC', function($q){
                $q->whereNotNull('folio_oc');
            })
            ->when($this->filter['oc'] == 'Sin OC',  function($q){
                    $q->whereNull('folio_oc');
            })
            ->when($this->filter['oc'] == 'Sin OC de MP', function($q){
                $q->whereNotNull('folio_oc')->where('folio_oc', '<>', '');
                $q->doesntHave('purchaseOrder');
            });
        })
        ->when(isset($this->filter['reception']), function($q){                   
            $q->when($this->filter['reception'] == 'Con Recepción',  function($q){
                $q->has('receptions');
            })
            ->when($this->filter['reception'] == 'Sin Recepción',  function($q){
                $q->doesntHave('receptions');   
            });
        })
        ->when(isset($this->filter['folio_sigfe']), function($q){                   
            $q->when($this->filter['folio_sigfe'] == 'Con SIGFE',  function($q){
                $q->whereNotNull('folio_sigfe');
            })
            ->when($this->filter['folio_sigfe'] == 'Sin SIGFE',  function($q){
                $q->whereNull('folio_sigfe');
            });
        })
        ->when(isset($this->filter['establishment']), function($q){                   
            $q->when($this->filter['establishment'] == '?',  function($q){
                $q->whereNull('establishment_id');
            })
            ->when($this->filter['establishment'] != 'all', function($q){
                $q->where('establishment_id', $this->filter['establishment']);
            });
        })
        ->when(isset($this->filter['tipo_documento']), function($q){
            $q->when($this->filter['tipo_documento'] == 'facturas',  function($q){
                $q->whereIn('tipo_documento', ['factura_electronica', 'factura_exenta']);
            }, function($q){
                $q->where('tipo_documento', $this->filter['tipo_documento']);
            });
        })
        ->when(isset($this->filter['fecha_desde_sii']), function($q){
            $q->where('fecha_recepcion_sii', '>=', $this->filter['fecha_desde_sii']);
        })
        ->when(isset($this->filter['fecha_hasta_sii']), function($q){
            $q->where('fecha_recepcion_sii', '<=', $this->filter['fecha_hasta_sii']);
        })
        ->when(isset($this->filter['estado']), function($q){  
            $q->when($this->filter['estado'] == 'sin_estado', function($q){
                $q->where('all_receptions', 0);
            })
            ->when($this->filter['estado'] == 'revision',  function($q){
                $q->where('all_receptions',1);
            })
            ->when($this->filter['estado'] == 'listo_para_pago', function($q){
                $q->where('payment_ready',1);
            });
        })
        ->when(isset($this->filter['subtitulo']), function($q){
            $value = $this->filter['subtitulo'];
            $q->whereHas('requestForm', function ($q) use ($value) {
                $q->whereHas('associateProgram', function ($q) use ($value) {
                    $q->whereHas('Subtitle', function ($q) use ($value) {
                        $q->where('id', $value);
                    });
                });
            });
        })
        ->when(isset($this->filter['fecha_desde_revision']), function($q){
            $q->where('all_receptions_at', '>=', $this->filter['fecha_desde_revision']);
        })
        ->when(isset($this->filter['fecha_hasta_revision']), function($q){
            $q->where('all_receptions_at', '<=', $this->filter['fecha_hasta_revision']);
        })
        ->orderByDesc('fecha_recepcion_sii');
        if ($paginate) {
            return $query->paginate(50);
        } else {
            return $query->get();
        }
    }

    public function refresh()
    {
        //$this->dtes = $this->searchDtes();
        $this->resetPage();
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
