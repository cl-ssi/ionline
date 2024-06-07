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

        $dtes = $query->whereNull('rejected')->where('tipo_documento', 'LIKE', 'factura_%')->paginate(50);

        return view('livewire.finance.payment-backup',
        [
            'dtes' => $dtes,
        ]
            );
    }
}
