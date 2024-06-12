<?php

namespace App\Http\Livewire\Finance;

use Livewire\Component;
use App\Models\Finance\Dte;
use App\Models\Sigfe\PdfBackup;

class PaymentBackup extends Component
{
    public function render()
    {
        $query = Dte::query();

        // ->whereNull('rejected')
        
        // ->where('payment_ready', 1)
        // //->where('check_tesoreria', false)
        // ->where('establishment_id', auth()->user()->organizationalUnit->establishment_id);

        $dtes = $query
        ->whereNull('rejected')
        ->where('tipo_documento', 'LIKE', 'factura_%')
        ->where('all_receptions', 1)
        ->where('establishment_id', auth()->user()->organizationalUnit->establishment_id)
        ->where('payment_ready', 1)
        ->paginate(50);

        return view('livewire.finance.payment-backup',
        [
            'dtes' => $dtes,
        ]
            );
    }
}
