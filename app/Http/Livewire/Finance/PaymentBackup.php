<?php

namespace App\Http\Livewire\Finance;

use Livewire\Component;
use App\Models\Finance\Dte;

class PaymentBackup extends Component
{
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


    public function render()
    {
        //$dtes = $this->searchDtes();

        $query = Dte::query();

        $dtes = $query->whereNull('rejected')->paginate(50);

        return view('livewire.finance.payment-backup',
        [
            'dtes' => $dtes,
        ]
            );
    }
}
