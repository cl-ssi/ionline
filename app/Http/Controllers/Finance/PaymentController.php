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

    public function search(Request $request, $query)
    {
        $id = $request->input('id');
        $folio = $request->input('folio');
        $oc = $request->input('oc');
        $folio_compromiso = $request->input('folio_compromiso');
        $folio_devengo = $request->input('folio_devengo');

        // $query = Dte::query();

        if ($id) {
            $query->where('id', $id);
        }

        if ($folio) {
            $query->where('folio', $folio);
        }

        if ($oc) {
            $query->where('folio_oc', $oc);
        }

        if ($folio_compromiso) {
            $query->where('folio_compromiso_sigfe', $folio_compromiso);
        }

        if ($folio_devengo) {
            $query->where('folio_devengo_sigfe', $folio_devengo);
        }

        return $query;
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

    public function review(Request $request)
    {
        $query = Dte::with([
            'controls',
            'controls.store',
            'purchaseOrder',
            'purchaseOrder.receptions',
            'purchaseOrder.rejections',
            'establishment',
            'dtes',
            'invoices',

            'requestForm',
            'requestForm.requestFormFiles',
            'requestForm.contractManager',

            'requestForm.father',
            'requestForm.father.requestFormFiles'
        ])
            ->whereNotIn('tipo_documento', ['guias_despacho','nota_debito','nota_credito'])
            ->where('all_receptions', 1)
            ->where('establishment_id', auth()->user()->organizationalUnit->establishment->id)
            ->where(function (Builder $query) {
                $query->whereNull('payment_ready')
                    ->orWhere('payment_ready', 0);
            });

        /**
         * tipo_documento
         * ==============
         * factura_electronica
         * factura_exenta
         * guias_despacho
         * nota_debito
         * nota_credito
         * boleta_honorarios
         * boleta_electronica
         */

        if ($request->filled('id') || $request->filled('folio') || $request->filled('oc') || $request->filled('folio_compromiso') || $request->filled('folio_devengo')) {
            //$query = $this->search($request);
            $query = $this->search($request, $query);
        }


        $dtes = $query->paginate(50);
        $request->flash();

        return view('finance.payments.review', compact('dtes', 'request'));
    }


    public function sendToReadyInbox(Dte $dte)
    {
        $dte->payment_ready = 1;
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

    public function ready(Request $request)
    {
        $query = Dte::with([
                'purchaseOrder',
                'purchaseOrder.receptions',
                'purchaseOrder.rejections',
                'establishment',
                'controls',
                'controls.store',
                'dtes',
                'invoices',
                'paymentFlows',

                'requestForm',
                'requestForm.requestFormFiles',
                'requestForm.contractManager',
    
                'requestForm.father',
                'requestForm.father.requestFormFiles'
            ])
            ->where('all_receptions', 1)
            ->where('payment_ready', 1)
            ->where('establishment_id', auth()->user()->organizationalUnit->establishment_id);

            if ($request->filled('id') || $request->filled('folio') || $request->filled('oc') || $request->filled('folio_compromiso') || $request->filled('folio_devengo')) {
                $query = $this->search($request, $query);
            }

        $dtes = $query->paginate(50);
        $request->flash();
        return view('finance.payments.ready', compact('dtes', 'request'));
    }


    public function rejected()
    {
        $dtes = Dte::with([
            'establishment',
            'confirmationUser',
            'purchaseOrder',
            'requestForm',
            'dtes',
            'invoices'
        ])
            ->whereNotNull('rejected')
            ->where('establishment_id', auth()->user()->organizationalUnit->establishment_id)
            ->orderByDesc('fecha_recepcion_sii')
            ->paginate(50);
        return view('finance.payments.rejected', compact('dtes'));
    }

    public function returnToReview(Dte $dte, Request $request)
    {
        $dte->payment_ready = null;
        $dte->sender_id = null;
        $dte->sender_ou = null;
        $dte->sender_at = null;
        $dte->save();
        return redirect()->back()->with('success', 'Dte se regreso a Revisión');
    }


}
