<?php

namespace App\Http\Livewire\Finance;

use Livewire\WithPagination;
use Livewire\Component;
use App\Models\Finance\Dte;
use App\Models\Finance\Receptions\Reception;
use App\Models\Establishment;


class IndexDtes extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $filter = array();

    public $showManualDTE = false;

    public $establishments;

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

    public function searchDtes()
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
                    case 'folio':
                        $query->where('folio', $value);
                        break;
                    case 'folio_oc':
                        $query->where('folio_oc', $value);
                        break;
                    case 'folio_sigfe':
                        switch ($value) {
                            case 'Con Folio SIGFE':
                                $query->whereNotNull('folio_sigfe');
                                break;
                            case 'Sin Folio SIGFE':
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
                        $query->where('tipo_documento', $value);
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
        ])
            ->whereNull('rejected')
            ->orderByDesc('fecha_recepcion_sii');
        return $query->paginate(50);
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
    }

    /**
     * Toggle Cenabaste
     */
    public function toggleCenabast(Dte $dte)
    {
        $dte->cenabast = !$dte->cenabast;
        $dte->save();
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
            'folio_oc' => trim($this->folio_oc),
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
            $dte->upload_user_id !== null &&
            $dte->cenabast_signed_pharmacist !== null &&
            $dte->cenabast_signed_boss !== null

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
                    'cenabast_signed_pharmacist' => $dte->cenabast_signed_pharmacist,
                    'cenabast_signed_boss' => $dte->cenabast_signed_boss,
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


    public function loadManualDTE()
    {
        $this->showManualDTE = true;
    }

    public function dteAdded()
    {
        // Ocultar el formulario
        $this->showManualDTE = false;
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
            ]);
        
        $this->refresh();
    }




}
