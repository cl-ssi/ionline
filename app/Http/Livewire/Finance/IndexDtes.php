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
    public $confirmation_observation = null;
    public $monto_total = null;

    public $facturasEmisor;

    public $asociate_invoices;

    public function searchDtes()
    {
        $query = Dte::query();

        // app('debugbar')->log($this->filter);

        foreach($this->filter as $filter => $value) {
            if($value) {
                // app('debugbar')->log($filter);
                switch($filter) {
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
                        switch($value) {
                            case 'Con Folio SIGFE':
                                $query->whereNotNull('folio_sigfe');
                                break;
                            case 'Sin Folio SIGFE':
                                $query->whereNull('folio_sigfe');
                                break;
                        }
                        break;
                    case 'establishment':
                        if($value == '?') {
                            $query->whereNull('establishment_id');
                        }
                        else {
                            $query->where('establishment_id', $value);
                        }
                        break;
                    case 'tipo_documento':
                            $query->where('tipo_documento', $value);
                            break;
                }
            }
        }

        // if (!empty($this->filter_sender_status)) {
        //     switch ($this->filter_sender_status) {
        //         case 'no confirmadas y enviadas a confirmación':
        //             $query->whereNull('confirmation_status')->whereNotNull('confirmation_send_at');
        //             break;
        //         case 'Enviado a confirmación':
        //             $query->whereNotNull('confirmation_send_at');
        //             break;
        //         case 'Confirmada':
        //             $query->whereNotNull('confirmation_send_at')->where('confirmation_status', 1);
        //             break;
        //         case 'No Confirmadas':
        //             $query->whereNotNull('confirmation_send_at')->whereNull('confirmation_status');
        //             break;
        //         case 'Confirmadas':
        //             $query->whereNotNull('confirmation_send_at')->where('confirmation_status', 1);
        //             break;
        //         case 'Rechazadas':
        //             $query->whereNotNull('confirmation_send_at')->where('confirmation_status', 0);
        //             break;
        //         case 'Sin Envío':
        //             $query->whereNull('confirmation_send_at')->whereNull('confirmation_status');
        //             break;
        //     }
        // }

        // if (!empty($this->filter_selected_establishment)) {
        //     $query->where('establishment_id', $this->filter_selected_establishment);
        // }

        // Rest of your searchDtes logic...

        // Aplicar relaciones y ordenamiento
        $query->with([
            'purchaseOrder',
            'establishment',
            'controls',
            'requestForm',
            'requestForm.contractManager',
            'dtes',
            'invoices',
        ])
            // ->whereNull('confirmation_status')
            // ->orWhere('confirmation_status',true)
            ->where(function ($query) {
                $query->where('confirmation_status',true)
                    ->orWhereNull('confirmation_status');
            })
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

        $this->establishments = Establishment::whereIn('id', $establishments_ids)->pluck('alias','id');
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
        foreach($this->ids as $id => $value) {
            Dte::whereId($id)->update(['establishment_id'=>$this->establishment_id]);
        }
        $this->ids = array();
    }

    public function show(Dte $dte)
    {
        $this->showEdit = $dte->id;
        $this->folio_oc = $dte->folio_oc;
        $this->confirmation_status = $dte->confirmation_status;
        $this->confirmation_observation = $dte->confirmation_observation;
        $this->asociate_invoices = $dte->invoices->pluck('id');
        $this->monto_total = '$ '.number_format($dte->monto_total, 0, '', '.');
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
            'confirmation_status' => $this->confirmation_status,
            'confirmation_user_id' => auth()->id(),
            'confirmation_ou_id' => auth()->user()->organizational_unit_id,
            'confirmation_at' => now(),
            'confirmation_observation' => $this->confirmation_observation,
        ]);

        $dte->invoices()->sync($this->asociate_invoices);
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

    public function render()
    {
        $dtes = $this->searchDtes();

        return view('livewire.finance.index-dtes', [
            'dtes' => $dtes,
            //'establishments' => $establishments,
        ])->extends('layouts.bt4.app');
    }
}
