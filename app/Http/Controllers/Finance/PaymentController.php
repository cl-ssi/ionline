<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Finance\Dte;
use App\Models\Finance\PaymentFlow;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;



class PaymentController extends Controller
{
    /**
     * Index
     */
    public function index()
    {
        return view('finance.payments.index');
    }

    /**
     * Index Own
     */
    public function indexOwn()
    {
        $userId = Auth::id();
        $dtes = Dte::whereHas('immediatePurchase.requestForm', function ($query) use ($userId) {
            $query->where('request_user_id', $userId)
                ->orWhere('contract_manager_id', $userId);
        })
            ->whereNotIn('tipo_documento', ['guias_despacho', 'nota_credito'])
            ->get();
        return view('finance.payments.indexown', compact('dtes'));
    }

    public function review()
    {
        $dtes = Dte::with([
            'controls',
            'requestForm',
            'requestForm.contractManager',
        ])
            //Se deja como antes mientras no se implementa un filtro en el review
            ->where('confirmation_status', 1)
            ->where('establishment_id', auth()->user()->organizationalUnit->establishment->id)
            ->where(function (Builder $query) {
                $query->whereNull('fin_status')
                    ->orWhere('fin_status', 'rechazado');
            })
            ->paginate(50);



        return view('finance.payments.review', compact('dtes'));
    }


    public function sendToReadyInbox(Dte $dte)
    {
        $dte->fin_status = 'Enviado a Pendiente Para Pago';
        $dte->sender_id = Auth::id();
        $dte->sender_ou = Auth::user()->organizational_unit_id;
        $dte->sender_at = now();
        $dte->save();
        PaymentFlow::create([
            'dte_id' => $dte->id,
            'user_id' => Auth::id(),
            'status' => 'Enviado a Pendiente Para Pago',
        ]);

        return redirect()->back()->with('success', 'Se ha enviado a bandeja Pendiente para Pagos exitosamente');
    }

    public function ready()
    {
        $dtes = Dte::where('confirmation_status', 1)
            ->where('fin_status', 'Enviado a Pendiente Para Pago')
            ->where('establishment_id', auth()->user()->organizationalUnit->establishment->id)
            ->get();
        return view('finance.payments.ready', compact('dtes'));
    }


    public function update(Dte $dte, Request $request)
    {
        $dte->fin_status = $request->status;
        $dte->folio_sigfe = $request->folio_sigfe;
        $dte->payer_id = Auth::id();
        $dte->payer_ou = Auth::user()->organizational_unit_id;
        $dte->payer_at = now();

        $dte->save();
        PaymentFlow::create([
            'dte_id' => $dte->id,
            'user_id' => Auth::id(),
            'status' => $request->status,
            'observation' => $request->observation,
        ]);

        return redirect()->back()->with('success', 'Flujo de pago actualizado exitosamente');
    }
}
