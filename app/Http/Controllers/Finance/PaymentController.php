<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Finance\Dte;
use App\Models\Finance\PaymentFlow;
use Illuminate\Database\Eloquent\Builder;



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

    public function indexProvision()
    {
        $dtes = Dte::where('confirmation_status', 1)
                ->where(function (Builder $query) {
                    $query->whereNull('fin_status')
                          ->orWhere('fin_status', 'rechazado');
                })
                ->get();
        return view('finance.payments.flows', compact('dtes'));
    }

    public function sendToFinance(Dte $dte)
    {
        $dte->fin_status = 'Enviado a Finanzas';
        $dte->save();
        PaymentFlow::create([
            'dte_id' => $dte->id,
            'user_id' => Auth::id(),
            'status' => 'Enviado a Finanzas',
        ]);

        return redirect()->back()->with('success', 'Se ha enviado a finanzas exitosamente');
        
    }

    public function indexFinance()
    {
        dd('finanzas');
        //return view('finance.payments.index');
    }
}
