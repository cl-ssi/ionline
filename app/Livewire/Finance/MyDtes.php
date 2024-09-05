<?php

namespace App\Livewire\Finance;

use App\Models\Finance\Dte;
use Livewire\Component;

class MyDtes extends Component
{
    public function render()
    {
        // Eloquent query donde Dte tenga un RequestForm y el RequestForm tenga un ContractManager y ese ContractManager sea el usuario autenticado

        $dtes = Dte::with([
                'purchaseOrder',
                'purchaseOrder.receptions',
                'purchaseOrder.rejections',
                'receptions',
                'receptions.signedFileLegacy',
                'receptions.supportFile',
                'receptions.noOcFile',
                'receptions.numeration',
                'establishment',
                'controls',
                'requestForm',
                'requestForm.requestFormFiles',
                'requestForm.signedOldRequestForms',
                'requestForm.contractManager',
                'dtes',
                'invoices',
                'receptions',
                'contractManager',
                'tgrPayedDte',
            ])
            ->whereRelation('requestForm.contractManager', 'id', auth()->id())
            ->orWhere('contract_manager_id', auth()->id())
            ->orWhere('emisor', auth()->user()->runFormat)
            ->whereNull('rejected')
            ->orderByDesc('fecha_recepcion_sii')
            ->paginate(50);

        return view('livewire.finance.my-dtes', compact('dtes'));
    }
}
