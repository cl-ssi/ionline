<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use App\Models\RequestForms\RequestForm;
use Illuminate\Support\Facades\Auth;
use App\Models\Finance\Dte;


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
        dd('abastecimiento');
        //return view('finance.payments.index');
    }

    public function indexFinance()
    {
        dd('finanzas');
        //return view('finance.payments.index');
    }
}
