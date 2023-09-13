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

    public function search(Request $request)
    {        
        $id = $request->input('id');
        $folio = $request->input('folio');
        $oc = $request->input('oc');
        $folio_compromiso = $request->input('folio_compromiso');
        $folio_devengo = $request->input('folio_devengo');

        $query = Dte::query();

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
            'requestForm',
            'requestForm.contractManager',
        ])
            ->where('confirmation_status', 1)
            ->where('establishment_id', auth()->user()->organizationalUnit->establishment->id)
            ->where(function (Builder $query) {
                $query->whereNull('fin_status')
                    ->orWhere('fin_status', 'rechazado');
            });


        if ($request->filled('id') || $request->filled('folio') || $request->filled('oc') || $request->filled('folio_compromiso') || $request->filled('folio_devengo')) {
            $query = $this->search($request);
        }


        $dtes = $query->paginate(100);
        $request->flash();

        return view('finance.payments.review', compact('dtes', 'request'));
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
            ->where('establishment_id', auth()->user()->organizationalUnit->establishment_id)
            ->get();
        return view('finance.payments.ready', compact('dtes'));
    }


    public function rejected()
    {
        $dtes = Dte::where('confirmation_status',0)
            ->where('establishment_id', auth()->user()->organizationalUnit->establishment_id)
            ->orderByDesc('fecha_recepcion_sii')
            ->paginate(100);
        return view('finance.payments.rejected', compact('dtes'));
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
