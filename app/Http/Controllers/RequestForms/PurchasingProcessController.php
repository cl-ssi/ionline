<?php

namespace App\Http\Controllers\RequestForms;

use App\Documents\Document;
use App\Models\RequestForms\PurchasingProcess;
use Illuminate\Http\Request;

use App\Models\RequestForms\RequestForm;
use App\User;
use App\Models\Parameters\Supplier;
use App\Models\RequestForms\InternalPurchaseOrder;
use App\Models\RequestForms\InternalPmItem;

use App\Http\Controllers\Controller;
use App\Models\RequestForms\FundToBeSettled;
use App\Models\RequestForms\PettyCash;
use App\Models\RequestForms\PurchasingProcessDetail;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class PurchasingProcessController extends Controller
{
    public function index()
    {
        //By Purchaser
        if(Auth()->user()->organizational_unit_id == 37){
            $purchaser = User::with('requestForms')
                ->latest()
                ->whereHas('requestForms', function ($q){
                    $q->where('status', 'approved');
                })
                ->where('id', Auth()->user()->id)
                ->first();

            return view('request_form.purchase.index', compact('purchaser'));
        }
        else{
          session()->flash('danger', 'Estimado Usuario/a: Usted no pertence a la Unidad de Abastecimiento.');
          return redirect()->route('request_forms.my_forms');
        }
    }

    public function purchase(RequestForm $requestForm)
    {
        if(Auth()->user()->organizational_unit_id == 37){
            $requestForm->load('user', 'userOrganizationalUnit', 'contractManager', 'requestFormFiles', 'purchasingProcess.details');
            // return $requestForm->purchasingProcess->details->count();
            $suppliers = Supplier::orderBy('name','asc')->get();
            return view('request_form.purchase.purchase', compact('requestForm', 'suppliers'));
        }
        else{
            session()->flash('danger', 'Estimado Usuario/a: Usted no pertence a la Unidad de Abastecimiento.');
            return redirect()->route('request_forms.my_forms');
        }
    }

    public function create(RequestForm $requestForm)
    {
        $purchasingProcess = new PurchasingProcess();

        $purchasingProcess->purchase_mechanism_id = $requestForm->purchase_mechanism_id;
        $purchasingProcess->purchase_type_id      = $requestForm->purchase_type_id;
        $purchasingProcess->start_date            = Carbon::now();
        $purchasingProcess->status                = 'pending';
        $purchasingProcess->user_id               = Auth::user()->id;
        $purchasingProcess->request_form_id       = $requestForm->id;
        $purchasingProcess->save();
        return $purchasingProcess;
    }

    public function create_internal_oc(Request $request, RequestForm $requestForm)
    {
        $requestForm->load('purchasingProcess');
        if(!$requestForm->purchasingProcess) $requestForm->purchasingProcess = $this->create($requestForm);

        $internalPurchaseOrder                          = new InternalPurchaseOrder();
        $internalPurchaseOrder->date                    = Carbon::now();
        $internalPurchaseOrder->supplier_id             = $request->supplier_id;
        $internalPurchaseOrder->payment_condition       = $request->payment_condition;
        $internalPurchaseOrder->estimated_delivery_date = $request->estimated_delivery_date;
        $internalPurchaseOrder->save();

        foreach($request->item_id as $key => $item){
            $detail = new PurchasingProcessDetail();
            $detail->purchasing_process_id      = $requestForm->purchasingProcess->id;
            $detail->item_request_form_id       = $item;
            $detail->internal_purchase_order_id = $internalPurchaseOrder->id;
            $detail->user_id                    = Auth::user()->id;
            $detail->quantity                   = $request->quantity[$key];
            $detail->unit_value                 = $request->unit_value[$key];
            $detail->expense                    = $detail->quantity * $detail->unit_value;
            $detail->status                     = 'total';
            $detail->save();
        }

        return redirect()->route('request_forms.supply.purchase', compact('requestForm'));
    }

    public function create_petty_cash(Request $request, RequestForm $requestForm)
    {
        $requestForm->load('purchasingProcess');
        if(!$requestForm->purchasingProcess) $requestForm->purchasingProcess = $this->create($requestForm);

        $pettyCash                          = new PettyCash();
        $pettyCash->date                    = $request->date;
        $pettyCash->receipt_type            = $request->receipt_type;
        $pettyCash->receipt_number          = $request->receipt_number;
        $pettyCash->amount                  = $request->amount;
        $pettyCash->save();

        $now = Carbon::now()->format('Y_m_d_H_i_s');
        $file_name = $now.'_petty_cash_file_'.$pettyCash->id;
        $pettyCash->file = $request->file ? $request->file->storeAs('/ionline/request_forms_dev/purchase_item_files', $file_name.'.'.$request->file->extension(), 'gcs') : null;
        $pettyCash->save();

        foreach($request->item_id as $key => $item){
            $detail = new PurchasingProcessDetail();
            $detail->purchasing_process_id      = $requestForm->purchasingProcess->id;
            $detail->item_request_form_id       = $item;
            $detail->petty_cash_id              = $pettyCash->id;
            $detail->user_id                    = Auth::user()->id;
            $detail->quantity                   = $request->quantity[$key];
            $detail->unit_value                 = $request->unit_value[$key];
            $detail->expense                    = $detail->quantity * $detail->unit_value;
            $detail->status                     = 'total';
            $detail->save();
        }

        return redirect()->route('request_forms.supply.purchase', compact('requestForm'));
    }

    public function create_fund_to_be_settled(Request $request, RequestForm $requestForm)
    {
        $requestForm->load('purchasingProcess');
        if(!$requestForm->purchasingProcess) $requestForm->purchasingProcess = $this->create($requestForm);

        $fundToBeSettled                          = new FundToBeSettled();
        $fundToBeSettled->date                    = Carbon::now();
        $fundToBeSettled->amount                  = $request->amount;
        $fundToBeSettled->document_id             = Document::where('number', $request->memo_number)->where('type', 'Memo')->first()->id;
        $fundToBeSettled->save();

        foreach($request->item_id as $key => $item){
            $detail = new PurchasingProcessDetail();
            $detail->purchasing_process_id      = $requestForm->purchasingProcess->id;
            $detail->item_request_form_id       = $item;
            $detail->fund_to_be_settled_id      = $fundToBeSettled->id;
            $detail->user_id                    = Auth::user()->id;
            $detail->quantity                   = $request->quantity[$key];
            $detail->unit_value                 = $request->unit_value[$key];
            $detail->expense                    = $detail->quantity * $detail->unit_value;
            $detail->status                     = 'total';
            $detail->save();
        }

        return redirect()->route('request_forms.supply.purchase', compact('requestForm'));
    }
}
