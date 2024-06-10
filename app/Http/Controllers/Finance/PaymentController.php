<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Finance\Dte;
use App\Models\Finance\PaymentFlow;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\DteReadyExport;
use Maatwebsite\Excel\Facades\Excel;

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
        $emisor = $request->input('emisor');
        $folio = $request->input('folio');
        $folio_oc = $request->input('folio_oc');
        $oc = $request->input('oc');
        $recepcion = $request->input('reception');
        $folio_compromiso = $request->input('folio_compromiso');
        $folio_devengo = $request->input('folio_devengo');
        $folio_pago = $request->input('folio_pago');
        $prov = $request->input('prov');
        $cart = $request->input('cart');
        $req = $request->input('req');
        $rev = $request->input('rev');
        

        if ($id) {
            $query->where('id', $id);
        }

        if ($emisor) {
            $query->where('emisor', $emisor);
        }

        if ($folio) {
            $query->where('folio', $folio);
        }

        if ($folio_oc) {
            $query->where('folio_oc', 'like', '%' . $folio_oc . '%');
        }

        if ($folio_compromiso) {
            $query->where('folio_compromiso_sigfe', $folio_compromiso);
        }
        if ($folio_devengo) {
            $query->where('folio_devengo_sigfe', $folio_devengo);
        }        

        if ($folio_pago) {
            
            //$query->where('paid_folio', $folio_pago);
            $query->whereHas('tgrPayedDte', function ($query) use ($folio_pago) {
                $query->where('folio', $folio_pago);
            });
        }        

        if ($oc && $oc !== 'Todos') {
            switch ($oc) {
                case 'Con OC':
                    $query->whereNotNull('folio_oc');
                    break;
                case 'Sin OC':
                    $query->whereNull('folio_oc');
                    break;
            }
        }

        if ($recepcion && $recepcion !== 'Todos') {
            switch ($recepcion) {
                case 'Sin Recepción':
                    $query->doesntHave('receptions');
                    break;
                case 'Con Recepción':
                    $query->has('receptions');
                    break;
            }
        }

        
        if ($prov && $prov !== 'Todos') {
            if ($prov === 'Sin') {
                $query->whereNull('excel_proveedor');
            } else {
                $query->where('excel_proveedor', true);
            }
        }
    
        if ($cart && $cart !== 'Todos') {
            if ($cart === 'Sin') {
                $query->whereNull('excel_cartera');
            } else {
                $query->where('excel_cartera', true);
            }
        }
    
        if ($req && $req !== 'Todos') {
            if ($req === 'Sin') {
                $query->whereNull('excel_requerimiento');
            } else {
                $query->where('excel_requerimiento', true);
            }
        }

        if ($rev && $rev !== 'Todos') {
            if ($rev === 'Sin') {
                $query->where('check_tesoreria', 0);
            } else {
                $query->where('check_tesoreria', 1);
            }
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

            'receptions',
            'receptions.signedFileLegacy',
            'receptions.numeration',

            'requestForm',
            'requestForm.requestFormFiles',
            'requestForm.signedOldRequestForms',

            'requestForm.father',
            'requestForm.father.requestFormFiles'

            
        ])
            ->whereNotIn('tipo_documento', ['guias_despacho','nota_debito','nota_credito'])
            ->whereNull('rejected')
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

        if ($request->filled('id') || $request->filled('folio') || $request->filled('oc') || $request->filled('folio_oc') || $request->filled('folio_compromiso') || $request->filled('folio_devengo')) {
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
        $dte->sender_ou = auth()->user()->organizational_unit_id;
        $dte->sender_at = now();
        $dte->save();
        PaymentFlow::create([
            'dte_id' => $dte->id,
            'user_id' => Auth::id(),
            'status' => 'Enviado a Pendiente Para Pago',
        ]);

        return redirect()->back()->with('success', 'Se ha enviado a bandeja Pendiente para Pagos exitosamente');
    }

    public function returnToDteInbox(Dte $dte)
    {
        $dte->all_receptions = null;
        $dte->all_receptions_user_id = null;
        $dte->all_receptions_ou_id = null;
        $dte->all_receptions_at = null;
        $dte->save();
        PaymentFlow::create([
            'dte_id' => $dte->id,
            'user_id' => Auth::id(),
            'status' => 'Retornado a bandeja DTE',
        ]);

        return redirect()->back()->with('success', 'Se ha devuelto a bandeja Dte exitosamente');
    }

    public function ready(Request $request)
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
            
            'receptions',
            'receptions.signedFileLegacy',
            'receptions.numeration',

            'requestForm',
            'requestForm.requestFormFiles',
            'requestForm.signedOldRequestForms',

            'requestForm.father',
            'requestForm.father.requestFormFiles'
            ])
            ->whereNull('rejected')
            ->where('all_receptions', 1)
            ->where('payment_ready', 1)
            ->where('establishment_id', auth()->user()->organizationalUnit->establishment_id);

            if ($request->filled('id') || $request->filled('emisor')  || $request->filled('folio') || $request->filled('folio_oc') || $request->filled('oc')  || $request->filled('prov') || $request->filled('cart') || $request->filled('req') || $request->filled('rev') ) {
                $query = $this->search($request, $query);
            }

        $dtes = $query->paginate(50);
        $request->flash();
        return view('finance.payments.ready', compact('dtes', 'request'));
    }

    public function readyExport(Request $request)
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
            
            'receptions',
            'receptions.signedFileLegacy',
            'receptions.numeration',

            'requestForm',
            'requestForm.requestFormFiles',
            'requestForm.signedOldRequestForms',

            'requestForm.father',
            'requestForm.father.requestFormFiles'
        ])
        ->whereNull('rejected')
        ->where('all_receptions', 1)
        ->where('payment_ready', 1)
        ->where('establishment_id', auth()->user()->organizationalUnit->establishment_id);

        if ($request->filled('id') || $request->filled('emisor')  || $request->filled('folio') || $request->filled('folio_oc') || $request->filled('oc')  || $request->filled('prov') || $request->filled('cart') || $request->filled('req') || $request->filled('rev') ) {
            $query = $this->search($request, $query);
        }

        $dtes = $query->get();

        return Excel::download(new DteReadyExport($dtes), 'ready_dtes.xlsx');
    }



    public function rejected(Request $request)
    {
        $query = Dte::with([
            'establishment',
            'confirmationUser',
            'purchaseOrder',
            'requestForm',
            'dtes',
            'invoices'
        ])
            ->whereNotNull('rejected')
            ->where('establishment_id', auth()->user()->organizationalUnit->establishment_id)
            ->orderByDesc('fecha_recepcion_sii');

            if ($request->filled('id') || $request->filled('emisor')  || $request->filled('folio') || $request->filled('folio_oc') || $request->filled('oc')  || $request->filled('prov') || $request->filled('cart') || $request->filled('req') || $request->filled('rev') ) {
                $query = $this->search($request, $query);
            }
        $dtes = $query->paginate(50);
        $request->flash();
        return view('finance.payments.rejected', compact('dtes', 'request'));
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

    public function paid(Request $request)
    {

        $query = Dte::with([
            'tgrPayedDte',
            'controls',
            'controls.store',
            'purchaseOrder',
            'purchaseOrder.receptions',
            'purchaseOrder.rejections',
            'establishment',
            'dtes',
            'invoices',
            
            'receptions',
            'receptions.signedFileLegacy',
            'receptions.numeration',

            'requestForm',
            'requestForm.requestFormFiles',
            'requestForm.signedOldRequestForms',

            'requestForm.father',
            'requestForm.father.requestFormFiles'
            ])
            ->whereNull('rejected')
            ->where('all_receptions', 1)
            ->where('payment_ready', 1)
            //->where('check_tesoreria', false)
            ->where('establishment_id', auth()->user()->organizationalUnit->establishment_id);

            if ($request->filled('id') || $request->filled('emisor')  || $request->filled('folio') || $request->filled('oc')  || $request->filled('prov') || $request->filled('cart') || $request->filled('req') || $request->filled('folio_compromiso') || $request->filled('folio_devengo') || $request->filled('folio_pago')) {
                $query = $this->search($request, $query);
            }

        $dtes = $query->paginate(50);
        $request->flash();

        return view('finance.payments.paid', compact('dtes','request'));

    }

    public function paidPdf(Dte $dte)
    {

        $establishment = auth()->user()->organizationalUnit->establishment;

        return Pdf::loadView('finance.payments.paid_pdf', [
            'dte' => $dte,
            'establishment' => $establishment,
        ])->setPaper('a4', 'landscape')->stream('comprobante_liquidacion_de_fondo.pdf');

        return view('finance.payments.paid_pdf', compact('dte'));
    }

    public function compromisoPdf(Dte $dte)
    {

        $establishment = auth()->user()->organizationalUnit->establishment;

        return Pdf::loadView('finance.payments.compromiso_pdf', [
            'dte' => $dte,
            'establishment' => $establishment,
        ])->stream('compromiso_sigfe.pdf');

        //return view('finance.payments.paid_pdf', compact('dte'));
    }

    public function devengoPdf(Dte $dte)
    {

        $establishment = auth()->user()->organizationalUnit->establishment;

        return Pdf::loadView('finance.payments.devengo_pdf', [
            'dte' => $dte,
            'establishment' => $establishment,
        ])->stream('devengo_sigfe.pdf');

        //return view('finance.payments.paid_pdf', compact('dte'));
    }




}
